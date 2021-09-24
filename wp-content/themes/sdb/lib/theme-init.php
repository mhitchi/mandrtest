<?php

add_action( 'after_setup_theme', 'mandr_setup_theme' );

function mandr_setup_theme() {
	
	define("THEME_VERSION", '1.0.1');
	//define("MR_CACHE_TIMEOUT", 15); //15s cache staging, unused
	define("MR_GOOGLE_MAPS_API_KEY", ''); // Empty google maps key for development usage
			
	/**
	 * Add WordPress HTML5 support
	 */
    add_theme_support('html5', ['caption', 'comment-form', 'gallery', 'search-form', 'script', 'style']);
	
	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
		
	/**
	 * Create Options page
	 */
	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page();
	}
	
	/**
	 * Add excerpts to pages
	 */
	add_post_type_support( 'page', 'excerpt' );	

	/**
	 *	Add Editor Stylesheet from main style.css
	 */
	//add_editor_style( get_stylesheet_directory_uri().'/style.css' );
	//add_editor_style( get_stylesheet_directory_uri().'/admin/shortcake-style.css' );

	/**
	 * This theme uses post thumbnails
	 */
	if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 600, 400, true ); // Normal post thumbnails
		add_image_size( 'medium-plus', 400, 300, true ); // Medium+ Size
	}
	
	/**
	 * Add custom image size to Wordpress admin area
	 */
	add_filter( 'image_size_names_choose', 'my_custom_image_sizes' );
	function my_custom_image_sizes( $sizes ) {
		return array_merge( $sizes, array(
			'medium-plus' => 'Medium+',
		) );
	}	
	
	/**
	 * Redirect Testimonial CPT single view to homepage
	 */
	//add_action( 'template_redirect', 'testimonial_redirect_post' );
	function testimonial_redirect_post() {
	  $queried_post_type = get_query_var('post_type');
	  if ( is_single() && 'mandr_testimonial' ==  $queried_post_type ) {
		wp_redirect( home_url(), 301 );
		exit;
	  }
	}

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * custom menu support
	 */
	add_theme_support( 'menus' );
	if ( function_exists( 'register_nav_menus' ) ) {
	  	register_nav_menus(
	  		array(
	  		  	'header_menu' => 'Header Menu',
				'footer_menu' => 'Footer Menu',
	  		)
	  	);
	}
}
