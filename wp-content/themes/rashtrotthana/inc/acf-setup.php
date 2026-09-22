<?php
/**
 * Rashtrotthana Yoga Theme - ACF Options Page & Fields Registration
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Options Page
if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Site Content Settings',
        'menu_title'    => 'Site Content',
        'menu_slug'     => 'ry-site-content',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'icon_url'      => 'dashicons-admin-generic',
        'position'      => 30,
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Global Settings',
        'menu_title'    => 'Global Settings',
        'parent_slug'   => 'ry-site-content',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Homepage Content',
        'menu_title'    => 'Homepage',
        'parent_slug'   => 'ry-site-content',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'About Us Content',
        'menu_title'    => 'About Us',
        'parent_slug'   => 'ry-site-content',
    ));
}

// Register Local Field Groups
add_action('acf/init', 'ry_register_acf_field_groups');
function ry_register_acf_field_groups() {
    
    // 1. GLOBAL SETTINGS
    acf_add_local_field_group(array(
        'key' => 'group_ry_global_settings',
        'title' => 'Global Settings',
        'fields' => array(
            array(
                'key' => 'field_ry_phone_primary',
                'label' => 'Primary Phone',
                'name' => 'ry_phone_primary',
                'type' => 'text',
            ),
            array(
                'key' => 'field_ry_email_primary',
                'label' => 'Primary Email',
                'name' => 'ry_email_primary',
                'type' => 'email',
            ),
            array(
                'key' => 'field_ry_address_primary',
                'label' => 'Primary Address',
                'name' => 'ry_address_primary',
                'type' => 'textarea',
            ),
            array(
                'key' => 'field_ry_facebook_url',
                'label' => 'Facebook URL',
                'name' => 'ry_facebook_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_ry_instagram_url',
                'label' => 'Instagram URL',
                'name' => 'ry_instagram_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_ry_youtube_url',
                'label' => 'YouTube URL',
                'name' => 'ry_youtube_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_ry_twitter_url',
                'label' => 'Twitter/X URL',
                'name' => 'ry_twitter_url',
                'type' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-global-settings',
                ),
            ),
        ),
    ));

    // 2. HOMEPAGE SETTINGS
    acf_add_local_field_group(array(
        'key' => 'group_ry_homepage_settings',
        'title' => 'Homepage Settings',
        'fields' => array(
            array(
                'key' => 'field_ry_hero_title',
                'label' => 'Hero Title',
                'name' => 'ry_hero_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_ry_hero_subtitle',
                'label' => 'Hero Subtitle',
                'name' => 'ry_hero_subtitle',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_ry_hero_button_text',
                'label' => 'Hero Button Text',
                'name' => 'ry_hero_button_text',
                'type' => 'text',
            ),
            array(
                'key' => 'field_ry_hero_button_url',
                'label' => 'Hero Button URL',
                'name' => 'ry_hero_button_url',
                'type' => 'text',
            ),
            array(
                'key' => 'field_ry_home_featured_blocks',
                'label' => 'Featured Blocks',
                'name' => 'ry_home_featured_blocks',
                'type' => 'repeater',
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_ry_fb_title',
                        'label' => 'Block Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_ry_fb_desc',
                        'label' => 'Block Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                    array(
                        'key' => 'field_ry_fb_image',
                        'label' => 'Block Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-homepage',
                ),
            ),
        ),
    ));

    // 3. ABOUT US SETTINGS
    acf_add_local_field_group(array(
        'key' => 'group_ry_about_settings',
        'title' => 'About Us Settings',
        'fields' => array(
            array(
                'key' => 'field_ry_about_vision_title',
                'label' => 'Vision Title',
                'name' => 'ry_about_vision_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_ry_about_vision_text',
                'label' => 'Vision Text',
                'name' => 'ry_about_vision_text',
                'type' => 'wysiwyg',
            ),
            array(
                'key' => 'field_ry_about_vision_image',
                'label' => 'Vision Image',
                'name' => 'ry_about_vision_image',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_ry_about_mission_title',
                'label' => 'Mission Title',
                'name' => 'ry_about_mission_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_ry_about_mission_text',
                'label' => 'Mission Text',
                'name' => 'ry_about_mission_text',
                'type' => 'wysiwyg',
            ),
            array(
                'key' => 'field_ry_about_mission_image',
                'label' => 'Mission Image',
                'name' => 'ry_about_mission_image',
                'type' => 'image',
                'return_format' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-about-us',
                ),
            ),
        ),
    ));
}
