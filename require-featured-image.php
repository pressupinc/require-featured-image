<?php
/*
Plugin Name: Require Featured Image
Plugin URI: http://pressupinc.com/wordpress-plugins/require-featured-image/
Description: Like it says on the tin: requires posts to have a featured image set before they'll be published.
Author: Press Up
Version: 0.5.0
Author URI: http://pressupinc.com
*/ 

require_once('admin-options.php');

register_activation_hook( __FILE__, 'rfi_plugin_activate' );
function rfi_plugin_activate() {
    add_option( 'rfi_post_types', array('post') );
}


add_action( 'pre_post_update', 'rfi_dont_publish' );
function rfi_dont_publish( $post_ID ) {
    if ( rfi_should_let_id_publish( $post_ID ) ) {
        wp_die( 'You cannot publish without a featured image.' );
    }
}


add_action( 'admin_enqueue_scripts', 'rfi_admin_js' );
function rfi_admin_js( $hook ) {

    global $post;
	if ( $hook != 'post.php' && $hook != 'post-new.php' )
        return;

    if ( in_array( $post->post_type, rfi_return_post_types() ) ) {
        wp_register_script( 'rfi-admin-js', plugins_url( '/require-featured-image-on-edit.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'rfi-admin-js' );
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

function rfi_should_let_id_publish( $post_ID ) {
    $post = get_post( $post_ID );
    
    // Incredible HACKERY because I can't find a hook that does what I want, or where
    $request_publish_test = isset($_REQUEST['publish']);
    $request_under_status_test = isset($_REQUEST['_status']) && $_REQUEST['_status'] == 'publish';
    $are_trying_to_publish = ( $request_publish_test || $request_under_status_test );

    return ( 
        in_array( $post->post_type, rfi_return_post_types() )
        && $are_trying_to_publish 
        && !has_post_thumbnail( $post_ID ) 
    );
}