<?php
/*
Plugin Name: Require Featured Image
Plugin URI: http://pressupinc.com/wordpress-plugins/require-featured-image/
Description: Like it says on the tin: requires posts to have a featured image set before they'll be published.
Author: Press Up
Version: 1.1.4
Author URI: http://pressupinc.com
Text Domain: require-featured-image
*/ 

require_once('admin-options.php');

add_action( 'transition_post_status', 'rfi_guard', 10, 3 );
function rfi_guard( $new_status, $old_status, $post ) {
    if ( $new_status === 'publish' 
        && !rfi_should_let_post_publish( $post ) ) {
        wp_die( __( 'You cannot publish without a featured image.', 'require-featured-image' ) );
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
        wp_register_script( 'rfi-admin-js', plugins_url( '/require-featured-image-on-edit.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'rfi-admin-js' );
        wp_localize_script(
            'rfi-admin-js',
            'objectL10n',
            array(
                'jsWarningHtml' => __( '<strong>This entry has no featured image.</strong> Please set one. You need to set a featured image before publishing.', 'require-featured-image' ),
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

function rfi_should_let_post_publish( $post ) {
    $has_featured_image = has_post_thumbnail( $post->ID );
    $is_watched_post_type = in_array( $post->post_type, rfi_return_post_types() );
    $is_after_enforcement_time = strtotime( $post->post_date ) > rfi_enforcement_start_time();
    
    if ( $is_after_enforcement_time && $is_watched_post_type ) {
        return $has_featured_image;
    }
    return true;
}
