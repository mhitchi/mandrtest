<?php

/* See Register Post Type
	https://codex.wordpress.org/Function_Reference/register_post_type
*/

/**
 *	Event
 */
//add_action( 'init', 'mandr_create_event_cpt' );
function mandr_create_event_cpt() {
	
	/* Events */
	$singular = 'Event';
	$plural = 'Events';
	$lc_singular = strtolower($singular);
	
	$labels = array(
		'name'                => $plural,
		'singular_name'       => $singular,
		'menu_name'           => $plural, 
		'name_admin_bar'      => $plural,
		'parent_item_colon'   => $singular.':',
		'all_items'           => 'All '.$plural,
		'add_new_item'        => 'Add New '.$singular,
		'add_new'             => 'Add New '.$singular,
		'new_item'            => 'New '.$singular,
		'edit_item'           => 'Edit '.$singular,
		'update_item'         => 'Update '.$singular,
		'view_item'           => 'View '.$singular,
		'search_items'        => 'Search '.$singular,
		'not_found'           => $singular.' not found',
        'not_found_in_trash'  => $singular.' not found in Trash',
        'item_published'      => $singular.' published',
        'item_published_privately' => $singular.' published privately.',
        'item_reverted_to_draft' => $singular.' reverted to draft.',
        'item_scheduled'      => $singular.' scheduled.',
        'item_updated'        => $singular.' updated.'
	);
	
	$args = array(
		'label'				  => $plural,
		'labels'              => $labels,
		//'description'		  => '',
		'public'              => true,
		//'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-calendar', // https://developer.wordpress.org/resource/dashicons/
		//'capability_type'     => 'post', 
		//'capabilities'		  => array( ),
		//'map_meta_cap'		  => null,
		//'hierarchical'		  => false,
		'supports'            => array( 'title', 'editor' ),
		//'register_meta_box_cb'	=> '',
		//'taxonomies'		  => '',
		'has_archive'         => false,
		//'permalink_epmask'	  => EP_PERMALINK,
		'rewrite'			  => array(
									'slug' 		=> $lc_singular,
									'with_front' => false,
									'feeds'		=> false,
									//'ep_mask'	=> EP_PERMALINK
									),
		'query_var'				=> false
		//'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
	);
	
	register_post_type( 'mandr_'.$lc_singular, $args );
	
	$tax_single = 'Category';
	$tax_plural = 'Categories';
	$tax_labels = array(
		'name'                       => $tax_single,
		'singular_name'              => $tax_single,
		'search_items'               => 'Search '.$tax_plural,
		'popular_items'              => 'Popular '.$tax_plural,
		'all_items'                  => 'All '.$tax_plural,
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => 'Edit '.$tax_single,
		'update_item'                => 'Update '.$tax_single,
		'add_new_item'               => 'Add New '.$tax_single,
		'new_item_name'              => 'New '.$tax_single.' Name',
		'separate_items_with_commas' => 'Separate '.$tax_plural.' with commas',
		'add_or_remove_items'        => 'Add or remove '.$tax_plural,
		'choose_from_most_used'      => 'Choose from the most used '.$tax_plural,
		'not_found'                  => 'No '.$tax_plural.' found.',
		'menu_name'                  => $tax_plural
	);
	$tax_args = array(
		'hierarchical'	=> false,
		'labels'	=> $tax_labels,
		'show_ui'	=> true,
		'show_admin_column' => true,
		'query_var'	=> false
	);
	register_taxonomy( 'event_category', 'mandr_event', $tax_args );
}

/**
 *	Photo Gallery
 */
//add_action( 'init', 'mandr_create_gallery_cpt' );
function mandr_create_gallery_cpt() {
	
	/* Photo Gallery */
	$singular = 'Photo Gallery';
	$plural = 'Photo Galleries';
	$lc_singular = 'photo-gallery';
	
	$labels = array(
		'name'                => $plural,
		'singular_name'       => $singular,
		'menu_name'           => $plural, 
		'name_admin_bar'      => $plural,
		'parent_item_colon'   => $singular.':',
		'all_items'           => 'All '.$plural,
		'add_new_item'        => 'Add New '.$singular,
		'add_new'             => 'Add New '.$singular,
		'new_item'            => 'New '.$singular,
		'edit_item'           => 'Edit '.$singular,
		'update_item'         => 'Update '.$singular,
		'view_item'           => 'View '.$singular,
		'search_items'        => 'Search '.$singular,
		'not_found'           => $singular.' not found',
        'not_found_in_trash'  => $singular.' not found in Trash',
        'item_published'      => $singular.' published',
        'item_published_privately' => $singular.' published privately.',
        'item_reverted_to_draft' => $singular.' reverted to draft.',
        'item_scheduled'      => $singular.' scheduled.',
        'item_updated'        => $singular.' updated.'
	);
	
	$args = array(
		'label'				  => $plural,
		'labels'              => $labels,
		//'description'		  => '',
		'public'              => true,
		//'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-gallery', // https://developer.wordpress.org/resource/dashicons/
		//'capability_type'     => 'post', 
		//'capabilities'		  => array( ),
		//'map_meta_cap'		  => null,
		//'hierarchical'		  => false,
		'supports'            => array( 'title', 'thumbnail' ),
		//'register_meta_box_cb'	=> '',
		//'taxonomies'		  => '',
		'has_archive'         => false,
		//'permalink_epmask'	  => EP_PERMALINK,
		'rewrite'			  => array(
									'slug' 		=> $lc_singular,
									'with_front' => false,
									'feeds'		=> false,
									//'ep_mask'	=> EP_PERMALINK
									),
		//'query_var'				=> false
		//'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
	);
	
	register_post_type( 'mandr_'.$lc_singular, $args );
} 
 

/**
 *	Testimonials
 */
//add_action( 'init', 'mandr_create_testimonial_cpt' );
function mandr_create_testimonial_cpt() {
	
	/* Photo Gallery */
	$singular = 'Testimonial';
	$plural = 'Testimonials';
	$lc_singular = 'testimonial';
	
	$labels = array(
		'name'                => $plural,
		'singular_name'       => $singular,
		'menu_name'           => $plural, 
		'name_admin_bar'      => $plural,
		'parent_item_colon'   => $singular.':',
		'all_items'           => 'All '.$plural,
		'add_new_item'        => 'Add New '.$singular,
		'add_new'             => 'Add New '.$singular,
		'new_item'            => 'New '.$singular,
		'edit_item'           => 'Edit '.$singular,
		'update_item'         => 'Update '.$singular,
		'view_item'           => 'View '.$singular,
		'search_items'        => 'Search '.$singular,
		'not_found'           => $singular.' not found',
        'not_found_in_trash'  => $singular.' not found in Trash',
        'item_published'      => $singular.' published',
        'item_published_privately' => $singular.' published privately.',
        'item_reverted_to_draft' => $singular.' reverted to draft.',
        'item_scheduled'      => $singular.' scheduled.',
        'item_updated'        => $singular.' updated.'
	);
	
	$args = array(
		'label'				  => $plural,
		'labels'              => $labels,
		//'description'		  => '',
		'public'              => true,
		//'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-quote', // https://developer.wordpress.org/resource/dashicons/
		//'capability_type'     => 'post', 
		//'capabilities'		  => array( ),
		//'map_meta_cap'		  => null,
		//'hierarchical'		  => false,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		//'register_meta_box_cb'	=> '',
		//'taxonomies'		  => '',
		'has_archive'         => false,
		//'permalink_epmask'	  => EP_PERMALINK,
		'rewrite'			  => array(
									'slug' 		=> $lc_singular,
									'with_front' => false,
									'feeds'		=> false,
									//'ep_mask'	=> EP_PERMALINK
									),
		'query_var'				=> false
		//'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
	);
	
	register_post_type( 'mandr_'.$lc_singular, $args );
}

/**
 *	Services
 */
//add_action( 'init', 'mandr_create_services_cpt' );
function mandr_create_services_cpt() {
	
	/* Photo Gallery */
	$singular = 'Service';
	$plural = 'Services';
	$lc_singular = 'service';
	
	$labels = array(
		'name'                => $plural,
		'singular_name'       => $singular,
		'menu_name'           => $plural, 
		'name_admin_bar'      => $plural,
		'parent_item_colon'   => $singular.':',
		'all_items'           => 'All '.$plural,
		'add_new_item'        => 'Add New '.$singular,
		'add_new'             => 'Add New '.$singular,
		'new_item'            => 'New '.$singular,
		'edit_item'           => 'Edit '.$singular,
		'update_item'         => 'Update '.$singular,
		'view_item'           => 'View '.$singular,
		'search_items'        => 'Search '.$singular,
		'not_found'           => $singular.' not found',
        'not_found_in_trash'  => $singular.' not found in Trash',
        'item_published'      => $singular.' published',
        'item_published_privately' => $singular.' published privately.',
        'item_reverted_to_draft' => $singular.' reverted to draft.',
        'item_scheduled'      => $singular.' scheduled.',
        'item_updated'        => $singular.' updated.'
	);
	
	$args = array(
		'label'				  => $plural,
		'labels'              => $labels,
		//'description'		  => '',
		'public'              => true,
		//'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-hammer', // https://developer.wordpress.org/resource/dashicons/
		//'capability_type'     => 'post', 
		//'capabilities'		  => array( ),
		//'map_meta_cap'		  => null,
		//'hierarchical'		  => false,
		'supports'            => array( 'title', 'excerpt', 'thumbnail' ),
		//'register_meta_box_cb'	=> '',
		//'taxonomies'		  => '',
		'has_archive'         => false,
		//'permalink_epmask'	  => EP_PERMALINK,
		'rewrite'			  => array(
									'slug' 		=> $lc_singular,
									'with_front' => false,
									'feeds'		=> false,
									//'ep_mask'	=> EP_PERMALINK
									),
		//'query_var'				=> false
		//'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
	);
	
	register_post_type( 'mandr_'.$lc_singular, $args );
}

/**
 *	Locations
 */
//add_action( 'init', 'mandr_create_location_cpt' );
function mandr_create_location_cpt() {
	
	/* Locations */
	$singular = 'Location';
	$plural = 'Locations';
	$lc_singular = strtolower($singular);
	
	$labels = array(
		'name'                => $plural,
		'singular_name'       => $singular,
		'menu_name'           => $plural, 
		'name_admin_bar'      => $plural,
		'parent_item_colon'   => $singular.':',
		'all_items'           => 'All '.$plural,
		'add_new_item'        => 'Add New '.$singular,
		'add_new'             => 'Add New '.$singular,
		'new_item'            => 'New '.$singular,
		'edit_item'           => 'Edit '.$singular,
		'update_item'         => 'Update '.$singular,
		'view_item'           => 'View '.$singular,
		'search_items'        => 'Search '.$singular,
		'not_found'           => $singular.' not found',
        'not_found_in_trash'  => $singular.' not found in Trash',
        'item_published'      => $singular.' published',
        'item_published_privately' => $singular.' published privately.',
        'item_reverted_to_draft' => $singular.' reverted to draft.',
        'item_scheduled'      => $singular.' scheduled.',
        'item_updated'        => $singular.' updated.'
	);
	
	$args = array(
		'label'				  => $plural,
		'labels'              => $labels,
		//'description'		  => '',
		'public'              => true,
		//'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-admin-site', // https://developer.wordpress.org/resource/dashicons/
		//'capability_type'     => 'post', 
		//'capabilities'		  => array( ),
		//'map_meta_cap'		  => null,
		//'hierarchical'		  => false,
		'supports'            => array( 'title' ),
		//'register_meta_box_cb'	=> '',
		//'taxonomies'		  => '',
		'has_archive'         => false,
		//'permalink_epmask'	  => EP_PERMALINK,
		'rewrite'			  => array(
									'slug' 		=> $lc_singular,
									'with_front' => false,
									'feeds'		=> false,
									//'ep_mask'	=> EP_PERMALINK
									),
		'query_var'				=> false
		//'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
	);
	
	register_post_type( 'mandr_'.$lc_singular, $args );
}