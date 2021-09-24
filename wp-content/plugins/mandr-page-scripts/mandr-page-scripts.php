<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package           M&R Page Scripts
 *
 * @wordpress-plugin
 * Plugin Name:       M&R Page Scripts
 * Plugin URI:        https://www.mandr-group.com
 * Description:       This plugin adds an ACF field for adding scripts to pages and posts. This plugin should be adjusted to if non-admins will be editing the website, and any scripts will be put in the fields.
 * Version:           1.9
 * Author:            M&R Marketing
 * Author URI:        https://www.mandr-group.com
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'M&R Page Scripts', '1.9' );

add_action( 'init', 'mandr_scripts_init');

function mandr_scripts_init() {

    // Add the options page
    if( function_exists('acf_add_options_page') ) {
        acf_add_options_page(array(
            'page_title' 	=> 'Site Scripts',
            'menu_title'	=> 'Site Scripts',
            'menu_slug' 	=> 'mandr-site-scripts',
            'capability'	=> 'administrator',
        ));
    }

    // Add the meta
    if( function_exists('acf_add_local_field_group') ){

        acf_add_local_field_group(array(
            'key' => 'group_5caba88def137',
            'title' => 'Header Scripts',
            'fields' => array(
                array(
                    'key' => 'field_5caba8cfd74e7',
                    'label' => 'Code',
                    'name' => 'mandr_headerscripts_code',
                    'type' => 'textarea',
                    'instructions' => 'This text will be echoed into the head.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => 4,
                    'new_lines' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post',
                    ),
                    array(
                        'param' => 'current_user_role',
                        'operator' => '==',
                        'value' => 'administrator',
                    ),
                ),
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'page',
                    ),
                    array(
                        'param' => 'current_user_role',
                        'operator' => '==',
                        'value' => 'administrator',
                    ),
                ),
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'mandr_service',
                    ),
                    array(
                        'param' => 'current_user_role',
                        'operator' => '==',
                        'value' => 'administrator',
                    ),
                ),
            ),
            'menu_order' => 100,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
    
        acf_add_local_field_group(array(
            'key' => 'group_5cae226bdd0cd',
            'title' => 'Site Scripts',
            'fields' => array(
                array(
                    'key' => 'field_5cae3f23e497c',
                    'label' => 'Header Scripts (Higher Priority)',
                    'name' => 'mandr_site_header_scripts_hi_p_code',
                    'type' => 'wysiwyg',
                    'instructions' => 'Text added here will be echoed early into the wp_head hook of every page and post on the site. This is where Google Tag Manager\'s main script should go.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'tabs' => 'text',
                    'media_upload' => 0,
                    'toolbar' => 'full',
                    'delay' => 0,
                ),
                array(
                    'key' => 'field_5cae227dd68c4',
                    'label' => 'Header Scripts (Lower Priority)',
                    'name' => 'mandr_site_header_scripts_lo_p_code',
                    'type' => 'wysiwyg',
                    'instructions' => 'Text added here will be echoed later into the wp_head hook of every page and post on the site. This is where Schema should go.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '
<!--
<script type="application/ld+json"> 
{
        "@context": "http://www.schema.org",
        "@type": "LocalBusiness",
        "name": "M&amp;R Marketing Group",
        "legalName" : "M&amp;R Marketing Group LLC",
        "url": "https://www.mandr-group.com",
        "logo": "https://www.mandr-group.com/wp-content/themes/mandr/images/mandr-logo.png",
        "image": "https://www.mandr-group.com/wp-content/themes/mandr/images/mandr-logo.png",
        "foundingDate": "2008",
        "founders": [
                {
                "@type": "Person",
                "name": "Matthew Michael"
                },
                {
                "@type": "Person",
                "name": "Nick Rios"
                                                                }
        ],
        "address": {
                "@type": "PostalAddress",
                "streetAddress": "331 3rd Street",
                "addressLocality": "Macon",
                "addressRegion": "GA",
                "postalCode": "31201",
                "addressCountry": "USA"
        },
        "telephone": "+1-478-621-4491",
        "geo": {
                "@type": "GeoCoordinates",
                "latitude": "32.8365731",
                "longitude": "-83.627142"
        },
        "openingHours": "Mo, Tu, We, Th, Fr 08:00-17:00",
        "contactPoint": {
                "@type": "ContactPoint",
                "contactType": "Sales, Support",
                "telephone": "+1-478-621-4491",
                "email": "hey@mandr-group.com"
        },
        "sameAs": [ 
                "https://www.facebook.com/BolingRR",
                "https://twitter.com/MandRGroup",
                "http://www.linkedin.com/company/m&amp;r-marketing-group",
                "https://www.pinterest.com/mandrmarketing/",
                "https://www.instagram.com/mandrgroup/",
                "https://www.mandr-group.com/feed/"
        ]
}
</script>
-->
                    ',
                    'tabs' => 'text',
                    'media_upload' => 0,
                    'toolbar' => 'full',
                    'delay' => 0,
                ),
                array(
                    'key' => 'field_5cae3fa4e497d',
                    'label' => 'Opening Body Scripts',
                    'name' => 'mandr_site_body_scripts_code',
                    'type' => 'wysiwyg',
                    'instructions' => 'Text added here will be echoed just after the opening <body> tag on every page and post on the site. This is where Google Tag Manager\'s body scripts should go. NOTE: This requires WordPress 5.2 and that the theme has the \'wp_body_open()\' function added after the opening body tag.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'tabs' => 'text',
                    'media_upload' => 0,
                    'toolbar' => 'full',
                    'delay' => 0,
                ),
                array(
                    'key' => 'field_5cae3feae497e',
                    'label' => 'Footer Scripts',
                    'name' => 'mandr_site_footer_scripts_code',
                    'type' => 'wysiwyg',
                    'instructions' => 'Text added here echoes in the wp_footer hook.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'tabs' => 'text',
                    'media_upload' => 0,
                    'toolbar' => 'full',
                    'delay' => 0,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'mandr-site-scripts',
                    ),
                    array(
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
            'active' => true,
            'description' => '',
        ));
    }

    // remove the html filter on all ACF fields
    add_filter('acf/allow_unfiltered_html', 'mandr_scripts_acf_allow_unfiltered_html_all_fields');
    function mandr_scripts_acf_allow_unfiltered_html_all_fields() {
        return true;
    }

    // re-apply filter to non-code fields
    add_filter('acf/update_value', 'mandr_scripts_acf_disallow_unfiltered_html_non_code_field', 1, 3);
    function mandr_scripts_acf_disallow_unfiltered_html_non_code_field($value, $post_id, $field){
        if(!empty($value)){
            if(
                $field['name'] !== 'mandr_headerscripts_code' &&
                $field['name'] !== 'mandr_site_header_scripts_lo_p_code' &&
                $field['name'] !== 'mandr_site_header_scripts_hi_p_code' &&
                $field['name'] !== 'mandr_site_body_scripts_code' &&
                $field['name'] !== 'mandr_site_footer_scripts_code'
            ) {
                if(
                    $field['type'] !== 'tab' &&
                    $field['type'] !== 'group' &&
                    $field['type'] !== 'repeater' &&
                    $field['type'] !== 'flexible_content' &&
                    $field['type'] !== 'clone'
                ){
                    if( !is_array($value) && !is_object($value) ) {
                        $value = wp_kses_post($value);
                    }elseif( is_array($value) ) {
                        foreach($value as $key => $val) {
                            if( !is_array($val) ) {
                                $value[$key] = wp_kses_post($val);
                            }else {
                                error_log('Nested array found when running wp_kses_post() in the mandr_acf_disallow_unfiltered_html_non_code_field hook.
                                The field type was '.$field['type'].' and the field name was '.$field['name'].'.');
                                error_log($value);
                            }
                        }
                    }elseif( is_object($value) ) {
                        error_log('Object found when running wp_kses_post() in the mandr_acf_disallow_unfiltered_html_non_code_field hook.
                        The field type was '.$field['type'].' and the field name was '.$field['name'].'.');
                        error_log($value);
                    }
                }
            }
        }

        return $value;
    }
}

// Early <head>
add_action( 'wp_head', 'mandr_scripts_echo_into_head_early', 1);
function mandr_scripts_echo_into_head_early() {
    // remove_filter('acf_the_content', 'wpautop');
    echo get_field('mandr_site_header_scripts_hi_p_code', 'option', false);
    // add_filter('acf_the_content', 'wpautop');
}

// Late <head>
add_action( 'wp_head', 'mandr_scripts_echo_into_head_late', 100);
function mandr_scripts_echo_into_head_late() {
    // remove_filter('acf_the_content', 'wpautop');
    echo get_field('mandr_site_header_scripts_lo_p_code', 'option', false);
    echo get_field('mandr_headerscripts_code');
    // add_filter('acf_the_content', 'wpautop');
}

// After opening <body>
add_action( 'wp_body_open', 'mandr_scripts_echo_into_body', 100);
function mandr_scripts_echo_into_body() {
    // remove_filter('acf_the_content', 'wpautop');
    echo get_field('mandr_site_body_scripts_code', 'option', false);
    // add_filter('acf_the_content', 'wpautop');
}

// At footer
add_action( 'wp_footer', 'mandr_scripts_echo_into_footer', 100);
function mandr_scripts_echo_into_footer() {
    // remove_filter('acf_the_content', 'wpautop');
    echo get_field('mandr_site_footer_scripts_code', 'option', false);
    // add_filter('acf_the_content', 'wpautop');
}