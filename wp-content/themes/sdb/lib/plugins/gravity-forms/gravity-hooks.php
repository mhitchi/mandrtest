<?php
/**
 * Remove Gravity Forms secure URL hash
 */
add_filter( 'gform_permission_granted_pre_download', 'mandr_permissions_override', 10, 3);
function mandr_permissions_override($permission_granted, $form_id, $field_id ){	
	$permission_granted = true;
	
    return $permission_granted;
}

/**
 * Grab referrer url for form hidden field 'immrefurl'
 */
	add_filter( 'gform_field_value_immrefurl', 'mandr_immediate_referral_url');
	function mandr_immediate_referral_url( $form ){
		$url = $_SERVER['HTTP_REFERER'];

		return esc_url_raw($url);
	}

// editors can see entries, notes
	add_action( 'admin_init', 'mr_grav_editing_caps' );
	function mr_grav_editing_caps() {
		$editor = get_role('editor');

		/** FORMAT:
		if( $editor->has_cap('') ) {
			$editor->remove_cap('');
		}
		if( !$editor->has_cap('') ) {
			$editor->add_cap('');
		}
		**/

		// gravity forms add
		if( !$editor->has_cap('gravityforms_view_entries') ) {
			$editor->add_cap('gravityforms_view_entries');
		}
		if( !$editor->has_cap('gravityforms_edit_entry_notes') ) {
			$editor->add_cap('gravityforms_edit_entry_notes');
		}
		if( !$editor->has_cap('gravityforms_view_entry_notes') ) {
			$editor->add_cap('gravityforms_view_entry_notes');
		}

		// gravity forms remove
		if( $editor->has_cap('gform_full_access') ) {
			$editor->remove_cap('gform_full_access');
		}

	//	if( $editor->has_cap('gravityforms_api') ) {
	//		$editor->remove_cap('gravityforms_api');
	//	}
	//	if( $editor->has_cap('gravityforms_api_settings') ) {
	//		$editor->remove_cap('gravityforms_api_settings');
	//	}
	//	if( $editor->has_cap('gravityforms_create_form') ) {
	//		$editor->remove_cap('gravityforms_create_form');
	//	}
	//	if( $editor->has_cap('gravityforms_delete_entries') ) {
	//		$editor->remove_cap('gravityforms_delete_entries');
	//	}
	//	if( $editor->has_cap('gravityforms_delete_forms') ) {
	//		$editor->remove_cap('gravityforms_delete_forms');
	//	}
	//	if( $editor->has_cap('gravityforms_edit_entries') ) {
	//		$editor->remove_cap('gravityforms_edit_entries');
	//	}
	//	if( $editor->has_cap('gravityforms_edit_forms') ) {
	//		$editor->remove_cap('gravityforms_edit_forms');
	//	}
	//	if( $editor->has_cap('gravityforms_edit_settings') ) {
	//		$editor->remove_cap('gravityforms_edit_settings');
	//	}
	//	if( $editor->has_cap('gravityforms_export_entries') ) {
	//		$editor->remove_cap('gravityforms_export_entries');
	//	}
	//	if( $editor->has_cap('gravityforms_preview_forms') ) {
	//		$editor->remove_cap('gravityforms_preview_forms');
	//	}
	//	if( $editor->has_cap('gravityforms_system_status') ) {
	//		$editor->remove_cap('gravityforms_system_status');
	//	}
	//	if( $editor->has_cap('gravityforms_uninstall') ) {
	//		$editor->remove_cap('gravityforms_uninstall');
	//	}
	//	if( $editor->has_cap('gravityforms_view_addons') ) {
	//		$editor->remove_cap('gravityforms_view_addons');
	//	}
	//	if( $editor->has_cap('gravityforms_view_settings') ) {
	//		$editor->remove_cap('gravityforms_view_settings');
	//	}
	//	if( $editor->has_cap('gravityforms_view_updates') ) {
	//		$editor->remove_cap('gravityforms_view_updates');
	//	}

	//	if( $editor->has_cap('publish_pages') ) {
	//		$editor->remove_cap('publish_pages');
	//	}

	}

/**
 * Downloads require login
 */
	add_filter( 'gform_require_login_pre_download', 'mandr_require_login', 10, 3 );
	function mandr_require_login( $require_login, $form_id, $field_id ) {
		return true;
	}

/**
 * Append header + footer to all emails
 */
	//add_filter( 'gform_notification', 'form_notification_email', 10, 3 );
	function form_notification_email($notification, $form, $entry) {
		
		$notification['message'] = email_header().$notification['message'];
		
		return $notification;
	}
	function email_header(){
		return '<div style="margin-top:14pt;margin-bottom:14pt;"><img style="border-width: 0px;" _src="https://www.bikethomson.com/wp-content/themes/bike_thomson/images/logo-dark.png" src="https://www.bikethomson.com/wp-content/themes/bike_thomson/images/logo-dark.png" alt="Bike Thomson"></div>
	';
	}

/**
 *	Remove tab indexes
 */
	add_filter( 'gform_tabindex', '__return_false' ); 

/**
* Adjusting the HTML of the submit button to match design
*
*
* @param $button string required The text string of the button we're editing
* @param $form array required The whole form object
*
* @return string The new HTML for the button
*/
	add_filter( 'gform_submit_button', 'mandr_form_submit_button', 10, 5 );
	function mandr_form_submit_button ( $button, $form ){
		$button = str_replace( "input", "button", $button );
		$button = str_replace( "/", "", $button );
		$button .= "{$form['button']['text']}</button>";
		return $button;
	}