<?php
/**
 * Homepage Data — Rashtrotthana Yoga
 *
 * TEAMMATE GUIDE:
 * - $rs_home_center_cards  → Replace with rs_get_featured_centers(4) when CPTs are ready
 * - $rs_home_stats         → Replace with get_option('rs_impact_stats') when CMS is ready
 * - $rs_home_values        → Replace with get_option('rs_vision_mission') when CMS is ready
 * - $rs_activity_fallbacks → Remove once real CPT activities exist
 * - $rs_event_fallbacks    → Remove once real CPT events exist
 * - $rs_home_founder       → Replace with WordPress page content or get_option() when CMS is ready
 */

// --- Center Cards (Homepage Centers Section) ---
$rs_home_center_cards = array(
    array( 'name' => 'Malleswaram Yoga Center',    'city' => 'Bengaluru', 'image' => get_template_directory_uri() . '/assets/images/client/dsc08572.jpg' ),
    array( 'name' => 'Jayanagar Wellness Center',  'city' => 'Bengaluru', 'image' => get_template_directory_uri() . '/assets/images/client/dsc08548-2-.png' ),
    array( 'name' => 'Kengeri Community Center',   'city' => 'Bengaluru', 'image' => get_template_directory_uri() . '/assets/images/client/20200529-175453.jpg' ),
    array( 'name' => 'Rajarajeshwari Center',      'city' => 'Bengaluru', 'image' => get_template_directory_uri() . '/assets/images/client/20200529-182250.jpg' ),
);

// --- Impact Statistics ---
$rs_home_stats = array(
    array( 'value' => 1972, 'suffix' => '',  'label' => 'Since' ),
    array( 'value' => 35,   'suffix' => '+', 'label' => 'Activities' ),
    array( 'value' => 18,   'suffix' => '',  'label' => 'Projects' ),
    array( 'value' => 23,   'suffix' => '+', 'label' => 'Centers' ),
    array( 'value' => 1000, 'suffix' => '+', 'label' => 'Lives Impacted' ),
);

// --- Vision, Mission, Values ---
$rs_home_values = array(
    array( 'title' => 'Our Vision',  'text' => 'To build a healthy, harmonious and sustainable society rooted in Indian values.' ),
    array( 'title' => 'Our Mission', 'text' => 'To empower individuals through Yoga, Education, Culture and Service for personal growth and social transformation.' ),
    array( 'title' => 'Our Values',  'text' => 'Integrity, compassion, discipline, selfless service and excellence in everything we do.' ),
    array( 'title' => 'Our Impact',  'text' => 'Building stronger communities through meaningful service and lifelong learning.' ),
);

// --- Founder Data ---
$rs_home_founder = array(
    'name'        => 'Dr. D. Veerendra Heggade',
    'title'       => 'Our Visionary Founder',
    'subtitle'    => 'The guiding philosophy behind the Rashtrotthana Yoga movement.',
    'image'       => get_template_directory_uri() . '/assets/images/client/08-02-22-rathasaptami-celebration-yoga-centres-bengaluru-5-.jpg',
    'image_alt'   => 'Dr. D. Veerendra Heggade - Founder, Rashtrotthana Parishat',
    'paragraphs'  => array(
        '<strong>Dr. D. Veerendra Heggade</strong>, the revered Dharmadhikari of Dharmasthala and the founding inspiration behind Rashtrotthana Parishat, has been the beacon guiding this widespread Yoga movement.',
        'His steadfast conviction that Yoga possesses the intrinsic power to transform individuals, heal bodily ailments, and foster socially conscious citizens has catalyzed the growth of our extensive network of community centers.',
        'Under his inspiring guidance, Rashtrotthana Yoga remains steadfastly dedicated to service, integrity, and building a vigorous, harmonious nation.',
    ),
    'quote'       => 'Yoga is not just an exercise; it is a way of life. It connects body, mind, and spirit to create a balanced, meaningful, and joyful existence.',
    'quote_author'=> 'Dr. D. Veerendra Heggade',
);

// --- Activity Fallbacks (used on homepage until real CPT data is available) ---
$rs_activity_fallbacks = array(
    array( 'Yoga & Wellness',    'Yoga for all age groups, beginners, advanced and therapeutic programs.',     get_template_directory_uri() . '/assets/images/client/05-01-25-kutumba-milana-rysri-jayanagar-3-.jpg' ),
    array( 'Education',          'Quality education and value-based learning for a better tomorrow.',          get_template_directory_uri() . '/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg' ),
    array( 'Arts & Culture',     'Nurturing talent through music, dance and traditional arts.',                get_template_directory_uri() . '/assets/images/client/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-.jpg' ),
    array( 'Community Service',  'Serving society through social and humanitarian initiatives.',               get_template_directory_uri() . '/assets/images/client/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-.jpg' ),
    array( 'Sports & Fitness',   'Karate, fitness programs and physical development activities.',              get_template_directory_uri() . '/assets/images/client/21-06-22-idy-celebration-12-.jpg' ),
);

// --- Event Fallbacks (used on homepage until real CPT events are available) ---
$rs_event_fallbacks = array(
    array( 'day' => '25', 'month' => 'MAY', 'title' => 'International Yoga Day',       'time' => '7:00 AM Onwards', 'venue' => 'All Centers',   'image' => get_template_directory_uri() . '/assets/images/client/21-06-24-idy-celebration-by-rysri-jayanagar-1-.jpg' ),
    array( 'day' => '12', 'month' => 'JUN', 'title' => 'Summer Yoga Camp for Kids',   'time' => '9:00 AM - 1:00 PM', 'venue' => 'City Centers', 'image' => get_template_directory_uri() . '/assets/images/client/07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg' ),
    array( 'day' => '05', 'month' => 'JUL', 'title' => 'Yoga for Wellness Workshop',  'time' => '6:30 PM Onwards',  'venue' => 'Main Center',   'image' => get_template_directory_uri() . '/assets/images/client/dsc08484.jpg' ),
    array( 'day' => '18', 'month' => 'AUG', 'title' => 'Cultural Evening',            'time' => '5:00 PM Onwards',  'venue' => 'Auditorium',    'image' => get_template_directory_uri() . '/assets/images/client/dsc08572.jpg' ),
);
