<?php
/*
Plugin Name: Require Featured Image
Plugin URI: http://pressupinc.com/wordpress-plugins/require-featured-image/
Description: Like it says on the tin: requires posts to have a featured image set before they'll be published.
Author: Press Up
Version: 0.6.3
Author URI: http://pressupinc.com
Text Domain: require-featured-image
*/ 

require_once('admin-options.php');

register_activation_hook( __FILE__, 'rfi_set_default_on_activation' );
function rfi_set_default_on_activation() {
    add_option( 'rfi_post_types', array('post') );
}

function rfi_textdomain_init() {
  load_plugin_textdomain( 'require-featured-image', false, dirname( plugin_basename( __FILE__ ) ).'/lang' ); 
}
add_action( 'plugins_loaded', 'rfi_textdomain_init' );


add_action( 'transition_post_status', 'rfi_dont_publish_post', 10, 3 );
function rfi_dont_publish_post( $new_status, $old_status, $post ) {
    if ( $new_status === 'publish' && !rfi_should_let_id_publish( $post ) ) {
        wp_die( __( 'You cannot publish without a featured image.', 'require-featured-image' ) );
    }
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
    return apply_filters( 'rfi_post_types' , rfi_return_post_types_option() ); 
}

function rfi_return_post_types_option() {
    $option = get_option( 'rfi_post_types', 'default' );
    if ( $option === 'default' ) {
        // Because there's no update hook, this should take care of people who hadn't set the option on activation and are used to 0.3.0 behaviour
        $option = array( 'post' );
    } 
    elseif ( $option === '' ) {
        // For people who want the plugin on, but doing nothing
        $option = array();
    }
    return $option;
}

function rfi_should_let_id_publish( $post ) {
    return !( in_array( $post->post_type, rfi_return_post_types() ) && !has_post_thumbnail( $post->ID ) );
}