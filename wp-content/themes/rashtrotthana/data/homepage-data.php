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
    array( 'name' => 'Malleswaram Yoga Center',    'city' => 'Bengaluru', 'image' => 'https://images.unsplash.com/photo-1487958449943-2429e8be8625?auto=format&fit=crop&w=700&q=80' ),
    array( 'name' => 'Jayanagar Wellness Center',  'city' => 'Bengaluru', 'image' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=700&q=80' ),
    array( 'name' => 'Kengeri Community Center',   'city' => 'Bengaluru', 'image' => 'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?auto=format&fit=crop&w=700&q=80' ),
    array( 'name' => 'Rajarajeshwari Center',      'city' => 'Bengaluru', 'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=700&q=80' ),
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
    'image'       => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?auto=format&fit=crop&w=700&q=80',
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
    array( 'Yoga & Wellness',    'Yoga for all age groups, beginners, advanced and therapeutic programs.',     'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=700&q=80' ),
    array( 'Education',          'Quality education and value-based learning for a better tomorrow.',          'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=700&q=80' ),
    array( 'Arts & Culture',     'Nurturing talent through music, dance and traditional arts.',                'https://images.unsplash.com/photo-1525201548942-d8732f6617a0?auto=format&fit=crop&w=700&q=80' ),
    array( 'Community Service',  'Serving society through social and humanitarian initiatives.',               'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?auto=format&fit=crop&w=700&q=80' ),
    array( 'Sports & Fitness',   'Karate, fitness programs and physical development activities.',              'https://images.unsplash.com/photo-1552072092-7f9b8d63efcb?auto=format&fit=crop&w=700&q=80' ),
);

// --- Event Fallbacks (used on homepage until real CPT events are available) ---
$rs_event_fallbacks = array(
    array( 'day' => '25', 'month' => 'MAY', 'title' => 'International Yoga Day',       'time' => '7:00 AM Onwards', 'venue' => 'All Centers',   'image' => 'https://images.unsplash.com/photo-1545389336-cf090694435e?auto=format&fit=crop&w=800&q=80' ),
    array( 'day' => '12', 'month' => 'JUN', 'title' => 'Summer Yoga Camp for Kids',   'time' => '9:00 AM - 1:00 PM', 'venue' => 'City Centers', 'image' => 'https://images.unsplash.com/photo-1516627145497-ae6968895b74?auto=format&fit=crop&w=800&q=80' ),
    array( 'day' => '05', 'month' => 'JUL', 'title' => 'Yoga for Wellness Workshop',  'time' => '6:30 PM Onwards',  'venue' => 'Main Center',   'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=800&q=80' ),
    array( 'day' => '18', 'month' => 'AUG', 'title' => 'Cultural Evening',            'time' => '5:00 PM Onwards',  'venue' => 'Auditorium',    'image' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=800&q=80' ),
);
