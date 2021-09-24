<?php

$includes_path = TEMPLATEPATH . '/lib/';

// Load Theme Functions, helper functions
require_once $includes_path . 'theme-function.php';

// Load Blog/Listing Functions, helper functions
require_once $includes_path . 'blog-functions.php';

// Enqueue all scripts
require_once $includes_path . 'theme-scripts.php';

// Theme initialization, WP stuff
require_once $includes_path . 'theme-init.php';

// Theme hooks ( front and back-end actions and filters )
require_once $includes_path . 'theme-hooks.php';

// Gravity Forms Hooks
if( class_exists( 'GFCommon' ) ) {
	require_once $includes_path . 'plugins/gravity-forms/gravity-hooks.php';
}

// Woo Commerce Hooks
//if( class_exists( 'WooCommerce' ) ) {
	//require_once $includes_path . 'plugins/woocommerce/woo-setup.php';
	//require_once $includes_path . 'plugins/woocommerce/woo-hooks.php';
//}

// Event Calendar Hooks
//if( class_exists( 'Tribe__Events__Main' ) ) {
	//require_once $includes_path . 'plugins/event-calendar/event-calendar-hooks.php';
//}

// Shortcodes
require_once $includes_path . 'theme-shortcodes.php';

// Shortcode UI
if( function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
	require_once $includes_path . 'plugins/shortcode-ui/shortcodes.php';	
}

//Display template file at the top of the page, for debugging purposes
//add_action('wp_head', 'show_template');
function show_template() {
	global $template;
	print_r($template);
}

/* View Query Count */
add_action('wp_footer', 'wpse_footer_db_queries', 1000);
function wpse_footer_db_queries(){
    echo '<!-- '.get_num_queries().'q,'.timer_stop(0).'s,'.time().' -->';
	
	/**
    global $wpdb;
    echo "<!-- ";
    print_r( $wpdb->queries );
    echo " -->";
	*/
}
