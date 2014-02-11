<?php

add_action( 'admin_menu', 'rfi_admin_add_page' );
function rfi_admin_add_page() {
	add_options_page( 'Require Featured Image Page', 'Req Featured Image', 'manage_options', 'rfi', 'rfi_options_page' );
}

function rfi_options_page() {
?>
<div class="wrap">
	<h2><?php _e( 'Require Featured Image', 'require-featured-image' ) ?></h2>
	<form action="options.php" method="post">
		<?php settings_fields( 'rfi_options' ); ?>
		<?php do_settings_sections( 'rfi' ); ?>
		 
		<input name="Submit" type="submit" value="<?php esc_attr_e( 'Save Changes', 'require-featured-image' ); ?>" class="button button-primary" />
	</form>
</div>
<?php
}

add_action( 'admin_init', 'rfi_admin_init' );
function rfi_admin_init(){
	// Create Settings
	register_setting( 'rfi_options', 'rfi_post_types' );
	
	// Create section of Page
	add_settings_section( 'rfi_main', __( 'Post Types', 'require-featured-image' ), 'rfi_main_section_text_output', 'rfi' );
	
	// Add fields to that section
	// add_settings_field( 'rfi_notification_text', 'Notification Text: ', 'rfi_notification_input_renderer', 'rfi', 'rfi_main' );
	add_settings_field( 'rfi_post_types', __('Post Types that require featured images ', 'require-featured-image' ), 'rfi_post_types_input_renderer', 'rfi', 'rfi_main' );
}

function rfi_main_section_text_output() {
	__( '<p>You can specify the post type for Require Feautured Image to work on. By default it works on Posts only.</p><p>If you\'re not seeing a post type here that you think should be, it probably does not have support for featured images. Only post types that support featured images will appear on this list.</p>', 'require-featured-image' );
}

function rfi_notification_input_renderer() {
	$option = get_option( 'rfi_notification_text' );
	echo "<input id='rfi_notification_text' name='rfi_notification_text' size='60' type='text' value='{$option}' />";
}

function rfi_post_types_input_renderer() {
	$option = rfi_return_post_types_option();
	$post_types = get_post_types( array( 'public' => true ), 'objects' );

	foreach ( $post_types as $type => $obj ) {
		if ( ! post_type_supports( $type, 'thumbnail' ) ) {
			continue;
		}
		if ( in_array( $type, $option ) ) {
			echo '<input type="checkbox" name="rfi_post_types[]" value="'.$type.'" checked="checked">'.$obj->label.'<br>';
		} else {
			echo '<input type="checkbox" name="rfi_post_types[]" value="'.$type.'">'.$obj->label.'<br>';
		}
	}
}

function rfi_text_validate( $input ) {
	$validated = trim( $input );
	return $validated;
}