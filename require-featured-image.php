<?php
/*
Plugin Name: Require Featured Image
Plugin URI: http://pressupinc.com/wordpress-plugins/require-featured-image/
Description: Like it says on the tin: requires posts to have a featured image set before they'll be published.
Author: Press Up
Version: 0.3.0
Author URI: http://pressupinc.com
*/ 

add_action( 'pre_post_update', 'rfi_dont_publish' );

function rfi_dont_publish($post_ID) {
    $post = get_post($post_ID);
    // Incredible HACKERY because I can't find a hook that does what I want, or where
    $request_publish_test = isset($_REQUEST['publish']);
    $request_under_status_test = isset($_REQUEST['_status']) && $_REQUEST['_status'] == 'publish';
    if ( $post->post_type == 'post' 
    	&& ( $request_publish_test || $request_under_status_test ) 
    	&& !has_post_thumbnail($post_ID) ) {
        wp_die( 'You cannot publish a post without it having a featured image.' );
    }
}

add_action( 'admin_enqueue_scripts', 'rfi_admin_js' );
function rfi_admin_js($hook) {
	if( $hook != 'post.php' && $hook != 'post-new.php' )
        return;
    wp_register_script( 'rfi-admin-js', plugins_url('/require-featured-image-on-edit.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'rfi-admin-js' );
}