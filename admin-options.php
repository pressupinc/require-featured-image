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
			<?php settings_fields( 'rfi' ); ?>
			<?php do_settings_sections( 'rfi' ); ?>
			<input name="Submit" type="submit" value="<?php esc_attr_e( 'Save Changes', 'require-featured-image' ); ?>" class="button button-primary" />
		</form>
	</div>
<?php
}

add_action( 'admin_init', 'rfi_admin_init' );
function rfi_admin_init(){
	// Create Settings
	$option_group = 'rfi';
	$option_name = 'rfi_post_types';
	register_setting( $option_group, $option_name );

	// Create section of Page
	$settings_section = 'rfi_main';
	$page = 'rfi';
	add_settings_section( $settings_section, __( 'Post Types', 'require-featured-image' ), 'rfi_main_section_text_output', $page );
	
	// Add fields to that section
	add_settings_field( $option_name, __('Post Types that require featured images ', 'require-featured-image' ), 'rfi_post_types_input_renderer', $page, $settings_section );
}

function rfi_main_section_text_output() {
	_e( '<p>You can specify the post type for Require Featured Image to work on. By default it works on Posts only.</p><p>If you\'re not seeing a post type here that you think should be, it probably does not have support for featured images. Only post types that support featured images will appear on this list.</p>', 'require-featured-image' );
}

function rfi_return_post_types_which_support_featured_images() {
	$post_types = get_post_types( array( 'public' => true ), 'objects' );
	foreach ( $post_types as $type => $obj ) {
		if ( post_type_supports( $type, 'thumbnail' ) ) {
			$return[$type] = $obj;
		}
	}
	return $return;
}

function rfi_post_types_input_renderer() {
	$option = rfi_return_post_types();
	$post_types = rfi_return_post_types_which_support_featured_images();

	foreach ( $post_types as $type => $obj ) {
		if ( in_array( $type, $option ) ) {
			echo '<input type="checkbox" name="rfi_post_types[]" value="'.$type.'" checked="checked">'.$obj->label.'<br>';
		} else {
			echo '<input type="checkbox" name="rfi_post_types[]" value="'.$type.'">'.$obj->label.'<br>';
		}
	}
}