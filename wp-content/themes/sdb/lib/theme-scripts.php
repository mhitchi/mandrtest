<?php

/* jQuery include, allowing auto select of http or https */
function my_jquery_enqueue() {
	wp_deregister_script('jquery');
   	//wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js", false, NULL);
	wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js", false, NULL);
   	wp_enqueue_script('jquery');
}
if (!is_admin()) {add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);}

/* Enqueue JS and CSS */
function my_script() {
	
	/* Javascript */
	wp_enqueue_script( 'all', get_stylesheet_directory_uri().'/assets/js/all.min.js', array('jquery'), filemtime(get_template_directory().'/assets/js/all.min.js') );
	wp_enqueue_script( 'ftr', get_stylesheet_directory_uri().'/assets/js/ftr.min.js', '', filemtime(get_template_directory().'/assets/js/ftr.min.js'), true );
	
	/* Font */
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,700', false, NULL );
	
	/* CSS */
	wp_enqueue_style( 'style', get_stylesheet_uri(), false, filemtime(get_stylesheet_directory().'/style.css') );		
}
add_action('wp_enqueue_scripts', 'my_script');