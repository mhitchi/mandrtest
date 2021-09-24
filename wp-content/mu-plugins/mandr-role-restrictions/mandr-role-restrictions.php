<?php

/*
Plugin Name: M&R Role Restrictions
Description: Extra editor (and below) role restrictions.
Author: M&R
Author URI: http://www.mandr-group.com
*/

/**
 *	Hooks
 */
add_action( 'admin_init','mr_role_restrictions_caps' );
function mr_role_restrictions_caps() {
	$editor_role = get_role('editor');
	$editor_role -> remove_cap('publish_pages');
	$author_role = get_role('author');
	$author_role -> remove_cap('publish pages');
}

add_action( 'admin_bar_menu', 'mr_role_restrictions_admin_bar', 999 );
function mr_role_restrictions_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_node( 'new-page' );
}

add_action( 'admin_menu','mr_role_restrictions_menu' );
function mr_role_restrictions_menu() {
	global $submenu;
	unset($submenu['edit.php?post_type=page'][10]);
}

add_action( 'admin_head','mr_role_restrictions_edit_page' );
function mr_role_restrictions_edit_page() {
	global $current_screen;
	if( ( $current_screen->id === 'edit-page' || $current_screen->id === 'page' )  && !current_user_can('administrator') ) {
		echo '
		<style>
			h1 .page-title-action{display: none !important;}
		</style>';
	}
}
  
add_action( 'admin_menu','mr_role_restrictions_redirect' );
function mr_role_restrictions_redirect() {
	$result = stripos($_SERVER['REQUEST_URI'], 'post-new.php?post_type=page');
	if ($result!==false && !current_user_can('publish_pages')) {
		wp_redirect(get_option('siteurl') . '/wp-admin/index.php?permissions_error=true');
	}
}

add_action( 'admin_init','mr_role_restrictions_permissions_notice' );
function mr_role_restrictions_permissions_notice_message() {
	echo "<div id='permissions-warning' class='error fade'><p><strong>".__('You do not have permission to access that page.')."</strong></p></div>";
}
function mr_role_restrictions_permissions_notice() {
	if( isset($_GET['permissions_error']) ) {
		add_action('admin_notices', 'mr_role_restrictions_permissions_notice_message');
	}
}