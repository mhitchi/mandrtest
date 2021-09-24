<?php

/*
Plugin Name: M&R Color Picker
Description: Color picker editor for TinyMCE
Author: M&R
Author URI: http://www.mandr-group.com
Based On: TinyMCE Color Picker v1.3
Based On URI: http://wordpress.org/plugins/tinymce-colorpicker/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 *	Add the to the options page for admins the ability to choose custom colors
 */
add_action( 'plugins_loaded', 'mandr_acf_admin_color_options' );
function mandr_acf_admin_color_options() {
	if( function_exists('acf_add_local_field_group') ):
	
		acf_add_local_field_group(array (
			'key' => 'group_5595a339a9ffb',
			'title' => 'Options(Admin)',
			'fields' => array (
				array (
					'key' => 'field_5595a361ad637',
					'label' => 'Colors',
					'name' => '',
					'type' => 'tab',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'placement' => 'top',
				),
				array (
					'key' => 'field_5595a37fad638',
					'label' => 'Colors',
					'name' => 'colors',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'min' => '',
					'max' => '',
					'layout' => 'table',
					'button_label' => 'Add Color',
					'sub_fields' => array (
						array (
							'key' => 'field_5595a3a5ad639',
							'label' => 'Color',
							'name' => 'color',
							'type' => 'color_picker',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
						),
					),
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'acf-options',
					),
					array (
						'param' => 'current_user_role',
						'operator' => '==',
						'value' => 'administrator',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
		));
	
	endif;
}
/**
 *	add colorpicker to tinymce
 */
add_action( 'mce_external_plugins', 'mandr_colorpicker__mce_external_plugins' );
function mandr_colorpicker__mce_external_plugins( $plugins ) {
	if ( class_exists('acf') ) :
		$plugins['wptextcolor'] = plugin_dir_url( __FILE__ ) . 'tinymce-colorpicker.js';
	endif;
	
	return $plugins;
	

}

/**
 *	add styles for color picker
 */
add_action( 'wp_enqueue_editor', 'mandr_colorpicker__wp_enqueue_editor' );
function mandr_colorpicker__wp_enqueue_editor( $args ) {
	if ( class_exists('acf') ) :
		if ( ! empty( $args['tinymce'] ) ) {
	
			wp_enqueue_style( 'tinymce-colorpicker', plugin_dir_url( __FILE__ ) . 'tinymce-colorpicker.css' );
			wp_enqueue_script( 'wp-color-picker' );
	
		}
	endif;
}

/**
 *	grab colors for TinyMCE
 */
add_filter( 'tiny_mce_before_init', 'mandr_colorpicker__tiny_mce_before_init' );
function mandr_colorpicker__tiny_mce_before_init( $init ) {
	if ( class_exists('acf') ) :
		if( have_rows('colors', 'option') ) {
			$colors = array();
			
			while( have_rows('colors', 'option') ) {
				the_row();
				$colors[] = get_sub_field('color');
			}
			
			$settings = array(
				'customColors'	=>	$colors
			);
			
			$init['tinyMCEColorPicker'] = json_encode( $settings );
			
			return $init;
		}else {
			return $init;
		}
	endif;
	
	return $init;
}

/**
 *	add colorpicker button
 */
add_filter( 'mce_buttons_2', 'mandr_colorpicker__mce_buttons_2' );
function mandr_colorpicker__mce_buttons_2( $buttons ) {
	if ( class_exists('acf') ) :
		if ( ( $key = array_search( 'forecolor', $buttons ) ) !== false ) {
			return $buttons;
		} else {
			array_push( $buttons, 'forecolor' );
			return $buttons;
		}
	endif;
	
	return $buttons;
}