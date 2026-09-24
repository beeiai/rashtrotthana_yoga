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

// Append this inside ry_register_acf_field_groups() or as a new hooked function
add_action('acf/init', 'ry_register_cpt_acf_field_groups');
function ry_register_cpt_acf_field_groups() {
    
    // ---------------------------------------------------------
    // 1. CENTER FIELDS
    // ---------------------------------------------------------
    acf_add_local_field_group(array(
        'key' => 'group_ry_center_fields',
        'title' => 'Center Details',
        'fields' => array(
            array('key' => 'field_c_area', 'label' => 'Area / Locality', 'name' => 'area', 'type' => 'text', 'required' => 1),
            array('key' => 'field_c_zone', 'label' => 'Zone', 'name' => 'zone', 'type' => 'select', 'choices' => array('South Bengaluru' => 'South Bengaluru', 'North Bengaluru' => 'North Bengaluru', 'East Bengaluru' => 'East Bengaluru', 'West Bengaluru' => 'West Bengaluru', 'Central Bengaluru' => 'Central Bengaluru')),
            array('key' => 'field_c_address', 'label' => 'Full Address', 'name' => 'address', 'type' => 'textarea', 'rows' => 3),
            array('key' => 'field_c_phone', 'label' => 'Phone', 'name' => 'phone', 'type' => 'text'),
            array('key' => 'field_c_email', 'label' => 'Email', 'name' => 'email', 'type' => 'email'),
            array('key' => 'field_c_hours', 'label' => 'Working Hours', 'name' => 'hours', 'type' => 'text', 'instructions' => 'e.g. Morning: 5:30 AM - 10:30 AM | Evening: 4:30 PM - 8:30 PM'),
            array('key' => 'field_c_lat', 'label' => 'Latitude', 'name' => 'lat', 'type' => 'number', 'step' => 'any'),
            array('key' => 'field_c_lng', 'label' => 'Longitude', 'name' => 'lng', 'type' => 'number', 'step' => 'any'),
            array('key' => 'field_c_is_hq', 'label' => 'Is Head Office?', 'name' => 'is_hq', 'type' => 'true_false', 'ui' => 1),
            array('key' => 'field_c_is_featured', 'label' => 'Show on Homepage?', 'name' => 'is_featured', 'type' => 'true_false', 'ui' => 1),
            array('key' => 'field_c_programs', 'label' => 'Programs Offered', 'name' => 'programs', 'type' => 'repeater', 'sub_fields' => array(
                array('key' => 'field_c_prog_name', 'label' => 'Program Name', 'name' => 'program_name', 'type' => 'text')
            )),
            array('key' => 'field_c_features', 'label' => 'Features / Highlights', 'name' => 'features', 'type' => 'repeater', 'sub_fields' => array(
                array('key' => 'field_c_feat_name', 'label' => 'Feature', 'name' => 'feature_name', 'type' => 'text')
            ))
        ),
        'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'center'))),
    ));

    // ---------------------------------------------------------
    // 2. EVENT FIELDS
    // ---------------------------------------------------------
    acf_add_local_field_group(array(
        'key' => 'group_ry_event_fields',
        'title' => 'Event Details',
        'fields' => array(
            array('key' => 'field_e_date', 'label' => 'Event Date', 'name' => 'event_date', 'type' => 'date_picker', 'display_format' => 'F j, Y', 'return_format' => 'Y-m-d', 'required' => 1),
            array('key' => 'field_e_time', 'label' => 'Time', 'name' => 'event_time', 'type' => 'text', 'instructions' => 'e.g. 6:30 AM - 9:00 AM'),
            array('key' => 'field_e_venue', 'label' => 'Venue / Center', 'name' => 'event_venue', 'type' => 'post_object', 'post_type' => array('center'), 'allow_null' => 1, 'multiple' => 0, 'return_format' => 'object', 'instructions' => 'Select a registered center, or leave blank to type a custom venue below.'),
            array('key' => 'field_e_venue_custom', 'label' => 'Custom Venue', 'name' => 'event_venue_custom', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_e_venue', 'operator' => '==empty')))),
            array('key' => 'field_e_mode', 'label' => 'Mode', 'name' => 'event_mode', 'type' => 'select', 'choices' => array('In-Person' => 'In-Person', 'Online' => 'Online', 'Hybrid Mode' => 'Hybrid Mode')),
            array('key' => 'field_e_fee', 'label' => 'Fee / Status', 'name' => 'event_fee', 'type' => 'text', 'instructions' => 'e.g. Free & Open for All'),
        ),
        'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'event'))),
    ));

    // ---------------------------------------------------------
    // 3. ACTIVITY FIELDS
    // ---------------------------------------------------------
    acf_add_local_field_group(array(
        'key' => 'group_ry_activity_fields',
        'title' => 'Activity Details',
        'fields' => array(
            array('key' => 'field_a_badge', 'label' => 'Badge / Tag', 'name' => 'badge', 'type' => 'text', 'instructions' => 'e.g. Foundational, Therapeutic'),
            array('key' => 'field_a_centers', 'label' => 'Available at Centers', 'name' => 'centers', 'type' => 'relationship', 'post_type' => array('center'), 'return_format' => 'object'),
            array('key' => 'field_a_batches', 'label' => 'Batches', 'name' => 'batches', 'type' => 'text', 'instructions' => 'e.g. Morning: 6:00 AM - 7:00 AM | Evening...'),
            array('key' => 'field_a_duration', 'label' => 'Duration', 'name' => 'duration', 'type' => 'text'),
            array('key' => 'field_a_frequency', 'label' => 'Frequency', 'name' => 'frequency', 'type' => 'text'),
            array('key' => 'field_a_eligibility', 'label' => 'Eligibility', 'name' => 'eligibility', 'type' => 'text'),
        ),
        'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'activity'))),
    ));
}
