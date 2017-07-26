<?php
/*
Plugin Name: Require Featured Image
Plugin URI: http://pressupinc.com/wordpress-plugins/require-featured-image/
Description: Like it says on the tin: requires posts to have a featured image set before they'll be published.
Author: Press Up
Version: 1.2.3
Author URI: http://pressupinc.com
Text Domain: require-featured-image
*/

require_once('admin-options.php');

add_action( 'transition_post_status', 'rfi_guard', 10, 3 );
add_action('admin_notices', function(){
    global $pagenow, $post;

    if($pagenow =='post.php' && rfi_should_stop_post_publishing($post)){
        $minimum_size = get_option( 'rfi_minimum_size' );
        $width = $minimum_size['width'];
        $height = $minimum_size['height'];

        echo "<div class='message notice notice-error'><p> ";
        if(get_post_thumbnail_id( $post->ID )){
            echo "<strong>This entry has a featured image that is too small.</strong> Please use an image that is at least $width x $height pixels.";
        }else{
            echo "<strong>This entry has no featured image</strong> Please set one. You must set a featured image that is at least $width x $height pixels before publishing";
        }
        echo '</p></div>';

    }

});



function rfi_guard( $new_status, $old_status, $post ) {
    if ( $new_status === 'publish' && rfi_should_stop_post_publishing( $post ) ) {
        $post->post_status = $old_status;
        wp_update_post($post);

    }
}

register_activation_hook( __FILE__, 'rfi_set_default_on_activation' );
function rfi_set_default_on_activation() {
    add_option( 'rfi_post_types', array('post') );
    // We added the 86400 (one day) below, because without it 
    //      first run behavior was confusing
    add_option( 'rfi_enforcement_start', time() - 86400 );
}

add_action( 'plugins_loaded', 'rfi_textdomain_init' );
function rfi_textdomain_init() {
    load_plugin_textdomain(
        'require-featured-image',
        false,
        dirname( plugin_basename( __FILE__ ) ).'/lang'
    );
}

/**
 * These are helpers that aren't ever registered with events
 */

function rfi_should_stop_post_publishing( $post ) {
    $is_watched_post_type = rfi_is_supported_post_type( $post );
    $is_after_enforcement_time = rfi_is_in_enforcement_window( $post );
    $large_enough_image_attached = rfi_post_has_large_enough_image_attached( $post );

    if ( $is_after_enforcement_time && $is_watched_post_type ) {
        return !$large_enough_image_attached;
    }
    return false;
}

function rfi_is_supported_post_type( $post ) {
    return in_array( $post->post_type, rfi_return_post_types() );
}

function rfi_return_post_types() {
    $option = get_option( 'rfi_post_types', 'default' );
    if ( $option === 'default' ) {
        $option = array( 'post' );
        add_option( 'rfi_post_types', $option );
    } elseif ( $option === '' ) {
        // For people who want the plugin on, but doing nothing
        $option = array();
    }
    return apply_filters( 'rfi_post_types', $option );
}

function rfi_is_in_enforcement_window( $post ) {
    return strtotime($post->post_date) > rfi_enforcement_start_time();
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

function rfi_post_has_large_enough_image_attached( $post ) {
    $image_id = get_post_thumbnail_id( $post->ID );
    if ( $image_id === null ) {
        return false;
    }
    $image_meta = wp_get_attachment_image_src( $image_id, 'full' );
    $width = $image_meta[1];
    $height = $image_meta[2];
    $minimum_size = get_option( 'rfi_minimum_size' );

    if ( $width >= $minimum_size['width'] && $height >=  $minimum_size['height'] ){
        return true;
    }
    return false;
}

function rfi_get_warning_message() {
    $minimum_size = get_option('rfi_minimum_size');
    // Legacy case
    if ( $minimum_size['width'] == 0 && $minimum_size['height'] == 0 ) {
        return __( 'You cannot publish without a featured image.', 'require-featured-image' );
    }
    return sprintf(
        __( 'You cannot publish without a featured image that is at least %s x %s pixels.', 'require-featured-image' ),
        $minimum_size['width'],
        $minimum_size['height']
    );
}