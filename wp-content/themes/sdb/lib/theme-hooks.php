<?php

/************************************************
 *		Front End
 ************************************************/

/* Hide styling things from editors */
add_action('admin_head', 'mandr_hide_acf_styling_fields');
function mandr_hide_acf_styling_fields() {
	if( !current_user_can('administrator') ) : ?>
	<style>
		.acf-field[data-name="section_class"],
		.acf-field[data-name="toggle_id"] {
			display: none;
		}
	</style>
	<?php endif;
	?>
	<style>
		.acf-postbox > .inside {
			width: 960px;
			max-width: 100%;
			margin-left: auto !important;
			margin-right: auto !important;
		}
		.acf-flexible-content .layout .acf-fc-layout-handle {
			background-color: #676767;
			color: #fff;
		}
		.acf-row:nth-child .acf-row-handle.order,
		.acf-row:nth-child .acf-row-handle.remove {
			background-color: #ebebeb;
			color: #777;
		}
		.acf-row:nth-child(2n) .acf-row-handle.order,
		.acf-row:nth-child(2n) .acf-row-handle.remove {
			background-color: #ccc;
			color: #fff;
		}
        .acf-fields>.acf-field.new-tab-link {
            border-top: none;
            padding-top: 0;
        }
        .acf-fields>.acf-field.new-tab-link .acf-label {
            width: 0;
            height: 0;
            margin: 0;
            padding: 0;
            visibility: hidden;
            overflow: hidden;
        }
        .clearfield {
            clear: both !important;
        }
    </style>
	<?php
}

/** 
 * Remove wp version from wp_head output
 */
remove_action('wp_head', 'wp_generator');

/**
 * Body Class
 * adds custom class to body via body_class filter
 */
// Not Home Body Class
add_filter( 'body_class', 'sp_body_class' );
function sp_body_class( $classes ) {	
	if(!is_front_page()){
		$classes[] = 'not-home';
	}
	
	return $classes;
}

/**
 * Page Slug Body Class
 */
add_filter( 'body_class', 'add_slug_body_class' );
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}

/*
 * Category ID in Body and Post Class
 */
add_filter('post_class', 'category_id_class');
add_filter('body_class', 'category_id_class');
function category_id_class($classes) {
    global $post;
    if( isset($post) ) {
        foreach((get_the_category($post->ID)) as $category) {
            $classes [] = 'cat-' . $category->cat_ID . '-id';
        }
    }
    return $classes;
}

/**
 * Add classes to next and previous links
 */
add_filter('next_post_link', 'posts_link_class');
add_filter('previous_post_link', 'posts_link_class');
function posts_link_class($format){
     $format = str_replace('href=', 'class="button" href=', $format);
     return $format;
}

/**
 * Excerpts
 */
add_filter('excerpt_length', function(){
	return 12;
}, 99);
add_filter('excerpt_more', 'custom_excerpt_more');
function custom_excerpt_more($more) {
    return '&hellip;';
}

/**
 * Code to add imageBox filter to content images
 */
add_filter('the_content', 'addMagnificTitle_replace', 99);
add_filter('acf_the_content', 'addMagnificTitle_replace', 99);
function addMagnificTitle_replace ($content) {
	global $post;
	if ( isset($post) ) {
		// [0] <a xyz href="...(.bmp|.gif|.jpg|.jpeg|.png)" zyx>yx</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz zyx>yx</a>
		$pattern[0]          = "/(<a)([^\>]*?) href=('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)>(.*?)<\/a>/i";
		$replacement[0] = '$1 href=$3$4$5$6$2$7>$8</a>';
		// [1] <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz zyx>yx</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" rel="magnificMe" data-group="[POST-ID]" xyz zyx>yx</a>
		$pattern[1]          = "/(<a href=)('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)(>)(.*?)(<\/a>)/i";
		$replacement[1] = '$1$2$3$4$5 rel="magnificMe" data-group="['.$post->ID.']" $6$7$8$9';
		// [2] <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" rel="magnificMe" data-group="[POST-ID]" xyz rel="(magnificMe|nomagnificMe)yxz" zyx>yx</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz rel="(magnificMe|nomagnificMe)yxz" zyx>yx</a>
		$pattern[2]          = "/(<a href=)('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\") rel=('|\")magnificMe([^\>]*?)('|\")([^\>]*?) rel=('|\")(magnificMe|nomagnificMe)([^\>]*?)('|\")([^\>]*?)(>)(.*?)(<\/a>)/i";
		$replacement[2] = '$1$2$3$4$5$9 rel=$10$11$12$13$14$15$16$17';
		// [3] <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz>yx title=yxz xy</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz title=yxz>yx title=yxz xy</a>
		$pattern[3]          = "/(<a href=)('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?)(>)(.*?) title=('|\")(.*?)('|\")(.*?)(<\/a>)/i";
		$replacement[3] = '$1$2$3$4$5$6 title=$9$10$11$7$8 title=$9$10$11$12$13';
		// [4] <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz title=zxy xzy title=yxz>yx</a> --> <a href="...(.bmp|.gif|.jpg|.jpeg|.png)" xyz title=zxy xzy>yx</a>
		$pattern[4]          = "/(<a href=)('|\")([^\>]*?)(\.bmp|\.gif|\.jpg|\.jpeg|\.png)('|\")([^\>]*?) title=([^\>]*?) title=([^\>]*?)(>)(.*?)(<\/a>)/i";
		$replacement[4] = '$1$2$3$4$5$6 title=$7$9$10$11';
		$content = preg_replace($pattern, $replacement, $content);
	}
	return $content;
}

// Remove Empty Paragraphs
add_filter('the_content', 'shortcode_empty_paragraph_fix');
add_filter('acf_the_content', 'shortcode_empty_paragraph_fix');
function shortcode_empty_paragraph_fix($content)
{   
	$array = array (
			'<p>[' => '[', 
			']</p>' => ']', 
			']<br />' => ']'
	);

	$content = strtr($content, $array);

	return $content;
}

/**
 * Remove paragraphs wrapping image
 */
add_filter('the_content', 'filter_ptags_on_images', 99); 
add_filter('acf_the_content', 'filter_ptags_on_images', 99); 
function filter_ptags_on_images($content){
	return preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '\1', $content);
}

/************************************************
 *		Back End
 ************************************************/
/**
 * By default, in Add/Edit Post, WordPress moves checked categories to the top of the list, and unchecked to the bottom.
 * When you have subcategories that you want to keep below their parents at all times, this makes no sense.
 * This function removes that automatic reordering so the categories widget retains its order regardless of checked state.
 * Thanks to https://stackoverflow.com/a/12586404
 */
add_filter( 'wp_terms_checklist_args', 'taxonomy_checklist_checked_ontop_filter' );
function taxonomy_checklist_checked_ontop_filter ( $args ) {
	$args['checked_ontop'] = false;
	return $args;
}
// Gallery Default settings
add_filter( 'media_view_settings', 'mandr_gallery_defaults' );
function mandr_gallery_defaults($settings) {
	$settings['galleryDefaults']['link'] = 'file';
    $settings['galleryDefaults']['columns'] = 4;
	$settings['galleryDefaults']['size'] = 'thumbnail';
    return $settings;
}

/**
 * Add SEO description from custom field. Will only show inside source <meta>
 * Also pull custom field into description textarea field
 */ 
//add_filter('the_seo_framework_custom_field_description', 'generate_acf_description_meta', 10, 2);
//add_filter('the_seo_framework_fetched_description_excerpt', 'generate_acf_description_meta', 10, 2);
function generate_acf_description_meta($desc, $args){
    // If description already set, just return that
    if($desc !== ''){
        return $desc;
    }

    // Grab custom field information
    $custom_field = get_field('update_with_custom_field_name');
    if($custom_field){
        $desc = filter_var($custom_field, FILTER_SANITIZE_STRING) ?: $desc;
        return $desc;
    }
}

// Add shortcode to SEO Framework descriptions
//add_filter( 'the_seo_framework_custom_field_description', 'enable_seo_framework_shortcode', 10, 2 );
function enable_seo_framework_shortcode( $description, $args ){
    return do_shortcode( $description );
}

/**
 *	ACF Google Maps Key
 *  - change when site goes live
 */
// Staging
add_filter('acf/settings/google_api_key', function () {
    return MR_GOOGLE_MAPS_API_KEY;
}); 

/**
 *			WP Srcset Fix
 */
/*
 * Force URLs in srcset attributes into HTTPS scheme.
 * This is particularly useful when you're running a Flexible SSL frontend like Cloudflare
 */
add_filter( 'wp_calculate_image_srcset', 'ssl_srcset' );
function ssl_srcset( $sources ) {
	if( is_ssl() ) { 
		foreach ( $sources as &$source ) {
			$source['url'] = set_url_scheme( $source['url'], 'https' );
		}
	}

  return $sources;
}


/**
 *	Disable Emojis
 *		//http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
 */
add_action( 'init', 'disable_wp_emojicons' );
function disable_wp_emojicons() {
	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	
	// filter to remove TinyMCE emojis
	add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
function disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
	return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
	return array();
	}
}

/**
 * Hide the 'Attachment Page' option for the link-to part.
 */
add_action( 'print_media_templates', function(){
    echo '
        <style>       
            .post-php select.link-to option[value="post"],
            .post-php select[data-setting="link"] option[value="post"] 
            { display: none; }
        </style>';
});

/**
 *	Change the image attachment "link to" none by default
 *		https://wordpress.org/support/topic/insert-image-default-to-no-link
 */
update_option('image_default_link_type','none');

/**
 * Adds access to 'Edit Theme Options' for 'Editors'
 * Restricts capabilities to only 'Menu' access
 */
add_action ('admin_init', 'get_editor_role');
function get_editor_role() {
         /* Get 'Editor' role and add capabilities */
        $roleObject = get_role( 'editor' );
       
        if (!$roleObject->has_cap( 'edit_theme_options' ) ) {
                $roleObject->add_cap( 'edit_theme_options' );
        }
}
add_action('admin_menu', 'mandr_editor_capability_access');
function mandr_editor_capability_access() {    
        /**
         * Remove menu access if user does not have ability to create users
         * i.e. not an Administrator
         */
	
		// Uncomment to debug menu items
		// global $menu, $submenu;
		// echo '<pre>'; print_r( $menu ); echo '</pre>'; // TOP LEVEL MENUS
		// echo '<pre>'; print_r( $submenu ); echo '</pre>'; // SUBMENUS
	
        if ( !current_user_can( 'create_users' ) ) {
               
        /** Main Menus **/
		//remove_menu_page( 'edit.php' );					//Posts
        //remove_menu_page( 'index.php' );                  //Dashboard
        //remove_menu_page( 'upload.php' );                 //Media
        //remove_menu_page( 'edit.php?post_type=page' );    //Pages
        remove_menu_page( 'edit-comments.php' );          //Comments
        remove_menu_page( 'themes.php' );                 //Appearance
        //remove_menu_page( 'plugins.php' );                //Plugins
        //remove_menu_page( 'users.php' );                  //Users
        remove_menu_page( 'tools.php' );                  //Tools
        //remove_menu_page( 'options-general.php' );        //Settings
                
        /** Submenus **/
        //global $submenu;
        remove_submenu_page( 'themes.php', 'themes.php' );
        //remove_submenu_page( 'themes.php', 'widgets.php' );
        remove_submenu_page( 'themes.php', 'theme-editor.php' );
               
        /**
         * Add new menu item. This one links to the custom menu
         * https://developer.wordpress.org/reference/functions/add_menu_page/
         */
         add_menu_page( 'Page Title', 'Menus', 'edit_others_posts', 'nav-menus.php', '', 'dashicons-menu', 72 );
		 //add_menu_page( 'Page Title', 'Widgets', 'edit_others_posts', 'widgets.php', '', 'dashicons-screenoptions', 73 );
        }
}
// Adjust what shows up on the New part of Admin Bar
add_action( 'admin_bar_menu', 'mandr_admin_bar_editing', 999 );
function mandr_admin_bar_editing() {
	global $wp_admin_bar;
	//$wp_admin_bar->remove_node( 'new-post' );
}

/**
 * WP dashboard menu ids to removeChild(about, wporg, documentation, support-forums, feedback)
 */
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );
function mytheme_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('about');
	$wp_admin_bar->remove_menu('wporg');
	$wp_admin_bar->remove_menu('documentation');
	$wp_admin_bar->remove_menu('support-forums');
	$wp_admin_bar->remove_menu('feedback');
	$wp_admin_bar->remove_menu('comments');
}
	
/**
 *	Completely Disable Comments_link
 */
	//https://www.dfactory.eu/wordpress-how-to/turn-off-disable-comments/
	
	// Disable support for comments and trackbacks in post types
	add_action('admin_init', 'df_disable_comments_post_types_support');
	function df_disable_comments_post_types_support() {
		$post_types = get_post_types();
		foreach ($post_types as $post_type) {
			if(post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	}
	// Close comments on the front-end
	add_filter('comments_open', 'df_disable_comments_status', 20, 2);
	add_filter('pings_open', 'df_disable_comments_status', 20, 2);
	function df_disable_comments_status() {
		return false;
	}
	// Redirect any user trying to access comments page
	add_action('admin_init', 'df_disable_comments_admin_menu_redirect');
	function df_disable_comments_admin_menu_redirect() {
		global $pagenow;
		if ($pagenow === 'edit-comments.php') {
			wp_redirect(home_url());
			exit;
		}
	}

/**
 * removes detailed login error information for security
 */
add_filter('login_errors', function($a) {
	return null;
});
	
/**
 * enable shortcodes in sidebar
 */
add_filter('widget_text', 'do_shortcode');

/*
 * Remove 'Preview Changes' button
 */
add_action('admin_head', 'removePreviewButtonFromPages');
function removePreviewButtonFromPages() {
 	// $pt = get_current_screen()->post_type;
    // if ( $pt != 'post') {
		echo '<style>
			#post-preview{
				display:none !important;
				}               
			} 
		</style>';	
	// } 
}

/**
 * Conditionally load ACF flex modules
 */
add_filter('acf/load_field/key=field_5e0685a213305', 'remove_layouts', 99);
function remove_layouts($field) {
	global $post;
    $layouts = $field['layouts'];

	// Only proceed if this is a page
	if( $post->post_type !== 'page' ) {
		return $field;
    }

	if ( (int)$post->ID !== (int)get_option( 'page_on_front' ) ) {
		$remove = array();

		return remove_flex_module_conditionally($field, $layouts, $remove);
	}

  	return $field;
}

/**
 * Remove flex layout from page layouts based on 
 * -- Broke loop out into own function so above function can handle conditional logic explicitly
 */
function remove_flex_module_conditionally($field, $layouts, $search){
	$field['layouts'] = array();

	// Had to modify the loop to match how class-acf-field-flexible-content builds array
	// plugins/advanced-custom-fields-pro/pro/class-acf-field-flexible-content.php 
	// ln 262
	foreach( $layouts as $k => $layout ) {
		if ( !in_array($layout['name'], $search) ) {
			$field['layouts'][ $layout['name'] ] = $layout;
		}
	}

	return $field;
}

/**
 * Add custom fields to Relevanssi excerpt core
 */
// add_filter('relevanssi_excerpt_content', 'fpd_search_custom_fields_to_excerpts', 10, 3);
function fpd_search_custom_fields_to_excerpts($content, $post, $query) {
	
	// grab advanced layout fields
	$fields = get_field('page_layouts', $post->ID);
	if( $fields ){
		foreach( $fields as $field ){
			if( $field['acf_fc_layout'] == 'block_2_image_content' )
			{
				$content .= " " . $field['primary_title'];
				$content .= " " . $field['primary_subtitle'];
				$content .= " " . $field['content'];
			} 
			elseif( $field['acf_fc_layout'] == 'block_bkgr_image_content' )
			{
				$content .= " " . $field['primary_title'];
				$content .= " " . $field['primary_subtitle'];
				$content .= " " . $field['content'];
            } 
			elseif( $field['acf_fc_layout'] == 'block_callout' )
			{
				$content .= " " . $field['primary_title'];
            } 
			elseif( $field['acf_fc_layout'] == 'block_content' )
			{
				$content .= " " . $field['primary_title'];
				$content .= " " . $field['content'];
            } 
			elseif( $field['acf_fc_layout'] == 'block_image_columns' )
			{
				$content .= " " . $field['primary_title'];
				$content .= " " . $field['content'];

				if( $field['columns'] ) {
                    foreach( $field['columns'] as $sub_field ) {
                        $content .= " " . $sub_field['column_title'];
                        $content .= " " . $sub_field['column_subtitle'];
						$content .= " " . $sub_field['column_excerpt'];
                    }
                }
            } 
			elseif( $field['acf_fc_layout'] == 'block_image_rows' )
			{
				if( $field['rows'] ) 
				{
                    foreach( $field['rows'] as $sub_field ) 
					{
                        $content .= " " . $sub_field['row_title'];
                        $content .= " " . $sub_field['row_subtitle'];
						$content .= " " . $sub_field['row_excerpt'];
                    }
                }
            } 
			elseif( $field['acf_fc_layout'] == 'block_large_image_carousel' )
			{
				if( $field['slides'] ) 
				{
                    foreach( $field['slides'] as $sub_field ) 
					{
                        $content .= " " . $sub_field['slide_title'];
                        $content .= " " . $sub_field['slide_subtitle'];
						$content .= " " . $sub_field['slide_excerpt'];
                    }
                }
            } 
			elseif( $field['acf_fc_layout'] == 'block_photo_gallery' )
			{
				$content .= " " . $field['primary_title'];
            } 
			elseif( $field['acf_fc_layout'] == 'block_stories' )
			{
				$content .= " " . $field['primary_title'];
				$content .= " " . $field['primary_subtitle'];
				$content .= " " . $field['content'];

				if( $field['stories'] ) {
                    foreach( $field['stories'] as $sub_field ) {
                        $content .= " " . $sub_field['story_title'];
                        $content .= " " . $sub_field['story_grade'];
						$content .= " " . $sub_field['story_content'];
                    }
                }
            } 
			elseif( $field['acf_fc_layout'] == 'block_video_banner' )
			{
				$content .= " " . $field['video_title'];
            } 
			elseif( $field['acf_fc_layout'] == 'block_video_content' )
			{
				$content .= " " . $field['primary_title'];
				$content .= " " . $field['primary_subtitle'];
				$content .= " " . $field['content'];
            } 
			elseif( $field['acf_fc_layout'] == 'module_standard_content' )
			{
                $content .= " " . $field['column_heading'];
                $content .= " " . $field['column_1'];
                $content .= " " . $field['column_2'];
                $content .= " " . $field['column_3'];
                $content .= " " . $field['column_4'];
			} 
			elseif( $field['acf_fc_layout'] == 'module_events' )
			{
				$content .= " " . $field['primary_title'];
            } 
			elseif( $field['acf_fc_layout'] == 'module_faculty' )
			{
				$content .= " " . $field['primary_title'];
            } 
			elseif( $field['acf_fc_layout'] == 'module_news' )
			{
				$content .= " " . $field['primary_title'];
            } 
			elseif( $field['acf_fc_layout'] == 'module_table' )
			{
				$content .= " " . $field['primary_title'];

                if( $field['table_rows'] ) {
                    foreach( $field['table_rows'] as $sub_field ) {
                        $content .= " " . $sub_field['table_column_1'];
						$content .= " " . $sub_field['table_column_2'];
						$content .= " " . $sub_field['table_column_3'];
						$content .= " " . $sub_field['table_column_4'];
						$content .= " " . $sub_field['table_column_5'];
						$content .= " " . $sub_field['table_column_6'];
						$content .= " " . $sub_field['table_column_7'];
						$content .= " " . $sub_field['table_column_8'];
                    }
                }
			}
			elseif( $field['acf_fc_layout'] == 'module_tabs' )
			{
                if( $field['tabs'] ) {
                    foreach( $field['tabs'] as $sub_field ) {
                        $content .= " " . $sub_field['tab_title'];
                        $content .= " " . $sub_field['tab_content'];
                    }
                }
			}
			elseif( $field['acf_fc_layout'] == 'module_testimonials' )
			{
				$content .= " " . $field['primary_title'];

                if( $field['testimonials'] ) {
                    foreach( $field['testimonials'] as $sub_field ) {
                        $content .= " " . $sub_field['testimonial_excerpt'];
						$content .= " " . $sub_field['testimonial_author'];
                    }
                }
			}
			elseif( $field['acf_fc_layout'] == 'module_toggles' )
			{
                if( $field['toggles'] ) {
                    foreach( $field['toggles'] as $sub_field ) {
                        $content .= " " . $sub_field['toggle_title'];
                        $content .= " " . $sub_field['toggled_content'];
                    }
                }
			} 
		}
    }
    
    return $content;
}