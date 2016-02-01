<?php
/*
Plugin Name: Require Featured Image
Plugin URI: http://pressupinc.com/wordpress-plugins/require-featured-image/
Description: Like it says on the tin: requires posts to have a featured image set before they'll be published.
Author: Press Up
Version: 1.2.0
Author URI: http://pressupinc.com
Text Domain: require-featured-image
*/

require_once('admin-options.php');

add_action( 'transition_post_status', 'rfi_guard', 10, 3 );
function rfi_guard( $new_status, $old_status, $post ) {
    if ( $new_status === 'publish'
        && !rfi_should_let_post_publish( $post ) ) {
        $warning_message = rfi_check_size_is_set();
        wp_die( __( $warning_message, 'require-featured-image' ) );
    }
}

register_activation_hook( __FILE__, 'rfi_set_default_on_activation' );
function rfi_set_default_on_activation() {
    add_option( 'rfi_post_types', array('post') );
    add_option( 'rfi_enforcement_start', time() );
}

add_action( 'plugins_loaded', 'rfi_textdomain_init' );
function rfi_textdomain_init() {
    load_plugin_textdomain(
        'require-featured-image',
        false,
        dirname( plugin_basename( __FILE__ ) ).'/lang'
    );
}

add_action( 'admin_enqueue_scripts', 'rfi_enqueue_edit_screen_js' );
function rfi_enqueue_edit_screen_js( $hook ) {
    global $post;
	if ( $hook !== 'post.php' && $hook !== 'post-new.php' )
        return;

    if ( in_array( $post->post_type, rfi_return_post_types() ) ) {
        $minimum_size = get_option('rfi_minimum_size');

        wp_register_script( 'rfi-admin-js', plugins_url( '/require-featured-image-on-edit.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'rfi-admin-js' );

        wp_localize_script(
            'rfi-admin-js',
            'passedFromServer',
            array(
                'jsWarningHtml' => __( '<strong>This entry has no featured image.</strong> Please set one. You need to set a featured image before publishing.', 'require-featured-image' ),
                'jsSmallHtml' => sprintf( 
                    __( '<strong>This entry has a featured image that is too small.</strong> Please use an image that is at least %s x %s pixels.', 'require-featured-image' ), 
                    $minimum_size['width'], 
                    $minimum_size['height'] 
                ),
                'width' => $minimum_size['width'],
                'height' => $minimum_size['height'],
            )
        );
    }
}

/**
 * These are helpers that aren't ever registered with events
 */

function rfi_return_post_types() {
    $option = get_option( 'rfi_post_types', 'default' );
    if ( $option === 'default' ) {
        $option = array( 'post' );
        add_option( 'rfi_post_types', $option );
    }
    elseif ( $option === '' ) {
        // For people who want the plugin on, but doing nothing
        $option = array();
    }
    return apply_filters( 'rfi_post_types', $option );
}

function rfi_enforcement_start_time() {
    $option = get_option( 'rfi_enforcement_start', 'default' );
    if ( $option === 'default' ) {
        // added in 1.1.0, activation times for installations before
        //  that release are set to two weeks prior to the first call
        $existing_install_guessed_time = time() - ( 86400*14 );
        add_option( 'rfi_enforcement_start', $existing_install_guessed_time );
        $option = $existing_install_guessed_time;
    }
    return apply_filters( 'rfi_enforcement_start', (int)$option );
}

function rfi_check_featured_image_size($post){
    if(has_post_thumbnail($post->ID)){
        $image_id = get_post_thumbnail_id($post->ID);
        if($image_id != null){
            $image_meta = wp_get_attachment_image_src($image_id, 'full');
            $width = $image_meta[1];
            $height = $image_meta[2];
            $minimum_size = get_option('rfi_minimum_size');

            if ($width < $minimum_size['width'] ){
                return false;
            }
            elseif ($height <  $minimum_size['height']){
                return false;
            }
            else{
                return true;
            }
        }
    }
}

function rfi_check_size_is_set(){
    $minimum_size = get_option('rfi_minimum_size');
    if($minimum_size['width'] == 0 && $minimum_size['height'] == 0){
        return "You cannot publish without a featured image.";
    }
    else{
        return "You cannot publish without a featured image which is at least ". $minimum_size['width'] ."x".$minimum_size['height']." pixels.";
    }
}

function rfi_should_let_post_publish( $post ) {
    $has_featured_image = has_post_thumbnail( $post->ID );
    $is_watched_post_type = in_array( $post->post_type, rfi_return_post_types() );
    $is_after_enforcement_time = strtotime( $post->post_date ) > rfi_enforcement_start_time();
    $image_size_check = rfi_check_featured_image_size($post);

    if ( $is_after_enforcement_time && $is_watched_post_type ) {
        return $has_featured_image && $image_size_check;
    }
    return true;
}
