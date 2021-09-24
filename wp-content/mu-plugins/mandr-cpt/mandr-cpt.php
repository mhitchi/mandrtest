<?php

// Create CPT = Staff Members
function custom_post_type() {
	$labels = array(
	  'name'               => _x( 'Staff Members', 'post type general name' ),
	  'singular_name'      => _x( 'Staff Member', 'post type singular name' ),
	  'add_new'            => _x( 'Add New', 'staff member' ),
	  'add_new_item'       => __( 'Add New Staff Members' ),
	  'edit_item'          => __( 'Edit Staff Member' ),
	  'new_item'           => __( 'New Staff Member' ),
	  'all_items'          => __( 'All Staff Members' ),
	  'view_item'          => __( 'View Staff Member' ),
	  'search_items'       => __( 'Search Staff Members' ),
	  'not_found'          => __( 'No staff member found' ),
	  'not_found_in_trash' => __( 'No staff member found in the Trash' ),
	  'parent_item_colon'  => '',
	  'menu_name'          => 'Staff Members'
	);
	$args = array(
	  'labels'        => $labels,
	  'description'   => 'Staff Members',
	  'public'        => true,
	  'menu_position' => 5,
	  'supports'      => array( 'title', 'editor', 'thumbnail' ),
	  'has_archive'   => true,
	);
	
	register_post_type( 'staff_members', $args );

    //Create taxonomy
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
        'hierarchical'  => false,
        'labels'    => $tax_labels,
        'show_ui'   => true,
        'show_admin_column' => true,
        'query_var' => false
    );
    register_taxonomy( 'staff_category', 'staff_member', $tax_args );

  }
  add_action( 'init', 'custom_post_type' );

