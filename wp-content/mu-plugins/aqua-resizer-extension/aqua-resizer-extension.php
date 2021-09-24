<?php
/**
 * Plugin Name: Aqua Resizer the Plugin
 * Description: A plugin utilizing Syamil MJ's script to resize images on the fly and store them for re-use (utilizing native Wordpress functions).
 * Version: .9
 * Author: Will Hawthorne
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Include Syamil MJ from Aqua Graphite's script
if( ! function_exists( 'aq_resize' ) ) {
	include_once( plugin_dir_path( __FILE__ ) . 'aq_resizer.php' );
}

// Helper Functions

// Resize the featured image of a post
function aq_resize_featured_image( $postid = null, $width, $height, $crop = true, $single = true, $upscale = true ){
	if( $postid === null ) {
		$postid = get_the_ID();
	}
	
	$img_id = get_post_thumbnail_id( $postid );
	$pre_image = wp_get_attachment_image_src( $img_id, 'full' );
	$image_url = aq_resize( $pre_image[0], $width, $height, $crop, $single, $upscale );
	
	return $image_url;
	
}

// Resize the featured image of a post
function resize_featured_image($postid, $aq_args){
	
	$aq_arg_defaults = array(
		'width' => null,
		'height' => null,
		'crop' => null,
		'single' => true,
		'upscale' => false
	);
	$aq_args = wp_parse_args( $aq_args, $aq_arg_defaults );
	extract( $aq_args, EXTR_SKIP );	
	
	$img_id = get_post_thumbnail_id( $postid );
	$pre_image = wp_get_attachment_image_src( $img_id, 'full' );
	$image_url = aq_resize( $pre_image[0], $width, $height, $crop, $single, $upscale );
	
	return $image_url;
	
}

// Basic function - resize based on the image at the given url - nearly identical to aq_resizer function "process"
function resize_by_url($full_url, $aq_args){
	
	$aq_arg_defaults = array(
		'width' => null,
		'height' => null,
		'crop' => null,
		'single' => true,
		'upscale' => false
	);
	$aq_args = wp_parse_args( $aq_args, $aq_arg_defaults );
	extract( $aq_args, EXTR_SKIP );
		
	$image_url = aq_resize( $full_url, $width, $height, $crop, $single, $upscale );
	
	return $image_url;
	
}