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
    array(
        'name'       => 'KG Nagar',
        'slug'       => 'kgnagar',
        'image'      => content_url( '/uploads/2026/10/Kempegowda-Nagar.jpg' ),
        'is_default' => true,
    ),
    array(
        'name'       => 'Jayanagar',
        'slug'       => 'jayanagar',
        'image'      => content_url( '/uploads/2026/10/Jayanagara.jpg' ),
        'is_default' => true,
    ),
    array(
        'name'       => 'Sadashivnagar',
        'slug'       => 'sadashivnagar',
        'image'      => content_url( '/uploads/2026/10/Sadashivnagar.jpg' ),
        'is_default' => true,
    ),
    array(
        'name'       => 'Kundalahalli',
        'slug'       => 'kundalahalli',
        'image'      => content_url( '/uploads/2026/10/Kundalahalli.jpg' ),
        'is_default' => true,
    ),
    array(
        'name'       => 'Girinagar',
        'slug'       => 'girinagar',
        'image'      => content_url( '/uploads/2026/10/Girinagar.jpg' ),
        'is_default' => false,
    ),
    array(
        'name'       => 'Gayathrinagar',
        'slug'       => 'gayathrinagar',
        'image'      => content_url( '/uploads/2026/10/Gayathrinagar.jpg' ),
        'is_default' => false,
    ),
    array(
        'name'       => 'Aksharam',
        'slug'       => 'aksharam',
        'image'      => content_url( '/uploads/2026/10/Basavangudi.jpg' ),
        'is_default' => false,
    ),
    array(
        'name'       => 'Kamakshipalya',
        'slug'       => 'kamakshipalya',
        'image'      => content_url( '/uploads/2026/10/KAMAKSHIPALYA.jpg' ),
        'is_default' => false,
    ),
    array(
        'name'       => 'Nagarbhavi',
        'slug'       => 'nagarbhavi',
        'image'      => content_url( '/uploads/2026/10/nagarbhavi.jpg' ),
        'is_default' => false,
    ),
    array(
        'name'       => 'RBI Layout',
        'slug'       => 'rbilayout',
        'image'      => content_url( '/uploads/2026/10/RBI-Layout.jpg' ),
        'is_default' => false,
    ),
    array(
        'name'       => 'Vijaynagar',
        'slug'       => 'vijaynagar',
        'image'      => content_url( '/uploads/2026/10/Vijaynagar.jpg' ),
        'is_default' => false,
    ),
    array(
        'name'       => 'Sunkenahalli',
        'slug'       => 'sunkenahalli',
        'image'      => get_template_directory_uri() . '/assets/images/client/20200529-175453.jpg',
        'is_default' => false,
    ),
);

// --- Impact Statistics ---
$rs_home_stats = array(
    array( 'value' => 1972, 'suffix' => '',       'label' => 'Since' ),
    array( 'value' => 35,   'suffix' => '+',      'label' => 'Activities' ),
    array( 'value' => 25,   'suffix' => '+',      'label' => 'Centers' ),
    array( 'value' => 200,  'suffix' => '+',      'label' => 'Daily Classes' ),
    array( 'value' => 1,    'suffix' => ' Lakh+', 'label' => 'Lives Impacted' ),
);

// --- Vision, Mission, Values, Impact ---
$rs_home_values = array(
    array( 'title' => 'Our Vision',  'text' => 'Swastha-Susthira Samajanirmanam — To build a healthy and sustainable society.' ),
    array( 'title' => 'Our Mission', 'text' => 'Advancing world-class yoga training and clinical research to cultivate a community of physical vitality, mental clarity, and spiritual harmony.' ),
    array( 'title' => 'Our Values',  'text' => 'Guided by Integrity and Affection (Aatmeeyata), we unite Commitment to excellence with Patriotism for our nation.' ),
    array( 'title' => 'Our Impact',  'text' => 'We enrich lives and build stronger communities by connecting people through meaningful public service and creating continuous opportunities for lifelong learning.' ),
);

// --- Founder Data ---
$rs_home_founder = array(
    'name'        => 'Sri Ajith Kumar',
    'title'       => 'Sri Ajith Kumar',
    'subtitle'    => '(1934 – 1990)',
    'image'       => content_url( '/uploads/2026/10/Shri-Ajith-kumar-Founder.png' ),
    'image_alt'   => 'Sri Ajith Kumar (1934 – 1990) - Founder, Rashtrotthana Yoga',
    'paragraphs'  => array(
        'Ajith Kumar is a talented graduate with gold medals in both Electrical and Mechanical engineering. He dedicated his entire life to the nation and became a promoter of the Rashtriya Swayamsevak Sangh. He demonstrated a keen interest in Yoga and was eager to foster awareness of it, aiming to entice more individuals to explore its teachings.',
        'He believed that mental health would only be good if physical health was good. Ajith Kumar, who received his Yoga education from the renowned Yoga masters Pattabhi Jois and B.K.S. Iyengar of Mysuru, trained many enthusiastic youths as Yoga trainers. This created an encouraging atmosphere for Yoga education throughout the state. Ajit’s guidance and efforts have been invaluable in helping organizations like the Hindu Seva Pratishthana and Rashtrotthana Parishat take up Yoga education as a major activity.',
    ),
    'quote'       => 'Mental health would only be good if physical health was good.',
    'quote_author'=> 'Sri Ajith Kumar',
);

// --- 4 Homepage Activities ---
$rs_home_activities = array(
    array(
        'name'  => 'Yoga',
        'desc'  => 'Authentic Patanjali Yoga, therapeutic wellness, and daily sadhana for physical vitality and mental peace.',
        'image' => content_url( '/uploads/2026/10/Yoga.jpg' ),
        'link'  => home_url( '/activities/#yoga-wellness' ),
    ),
    array(
        'name'  => 'GYM',
        'desc'  => 'Modern fitness equipment, strength conditioning, and personalized workout routines for all levels.',
        'image' => content_url( '/uploads/2026/10/gym.png' ),
        'link'  => home_url( '/activities/#fitness-sports' ),
    ),
    array(
        'name'  => 'Karate',
        'desc'  => 'Martial arts discipline, self-defense technique, mental focus, and agility training for all ages.',
        'image' => content_url( '/uploads/2026/10/karate.jpg' ),
        'link'  => home_url( '/activities/#martial-arts' ),
    ),
    array(
        'name'  => 'Music & Dance',
        'desc'  => 'Classical Carnatic vocal, instrumental music training, and expressive traditional dance forms.',
        'image' => content_url( '/uploads/2026/10/Music.jpg' ),
        'link'  => home_url( '/activities/#arts-music' ),
    ),
);

// --- Event Fallbacks (used on homepage until real CPT events are available) ---
$rs_event_fallbacks = array(
    array( 'day' => '25', 'month' => 'MAY', 'title' => 'International Yoga Day',       'time' => '7:00 AM Onwards', 'venue' => 'All Centers',   'image' => get_template_directory_uri() . '/assets/images/client/21-06-24-idy-celebration-by-rysri-jayanagar-1-.jpg' ),
    array( 'day' => '12', 'month' => 'JUN', 'title' => 'Summer Yoga Camp for Kids',   'time' => '9:00 AM - 1:00 PM', 'venue' => 'City Centers', 'image' => get_template_directory_uri() . '/assets/images/client/07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg' ),
    array( 'day' => '05', 'month' => 'JUL', 'title' => 'Yoga for Wellness Workshop',  'time' => '6:30 PM Onwards',  'venue' => 'Main Center',   'image' => get_template_directory_uri() . '/assets/images/client/dsc08484.jpg' ),
    array( 'day' => '18', 'month' => 'AUG', 'title' => 'Cultural Evening',            'time' => '5:00 PM Onwards',  'venue' => 'Auditorium',    'image' => get_template_directory_uri() . '/assets/images/client/dsc08572.jpg' ),
);
