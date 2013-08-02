<?php
/*
Plugin Name: Require Featured Image
Plugin URI: http://pressupinc.com/wordpress-plugins/require-featured-image/
Description: Requires posts to have a featured image set before they'll be published
Author: Press Up
Version: 0.2.1
Author URI: http://pressupinc.com
*/ 

add_action( 'pre_post_update', 'rfi_dont_publish' );
function rfi_dont_publish() {
    global $post;
    if ( !has_post_thumbnail($post->ID) ) {
        wp_die( 'You cannot publish a post without it having a featured image.' );
    }
}

add_action('admin_notices', 'rfi_admin_notice');
function rfi_admin_notice(){
    echo '<div id="no-feature-image-message"></div>';
}

add_action( 'admin_enqueue_scripts', 'rfi_admin_js' );
function rfi_admin_js($hook) {
	if( $hook != 'post.php' && $hook != 'post-new.php' )
        return;
    wp_register_script( 'checkadminjs', plugins_url('/check.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'checkadminjs' );
}