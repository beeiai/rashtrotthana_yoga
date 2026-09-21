<?php
/**
 * Contact Page Data — Rashtrotthana Yoga
 * $flagship_centers: Replace with rs_get_flagship_centers() when CPTs are ready.
 * $faqs_dataset: Replace with rs_get_faqs() or WordPress options when CMS is ready.
 */
// Flagship Centers Dataset for Contact Page
$flagship_centers = array(
    array(
        'id'        => 'jayanagar',
        'name'      => 'Jayanagar Center (Head Office)',
        'area'      => '4th Block, Jayanagar',
        'address'   => 'No. 23, 4th Cross, 4th Block, Jayanagar, Bengaluru – 560011',
        'phone'     => '080 2664 4444',
        'hours'     => 'Mon – Sat: 5:00 AM – 9:00 PM | Sun: 6:00 AM – 1:00 PM',
        'email'     => 'info@rashtrotthanayoga.org',
        'lat'       => 12.9250,
        'lng'       => 77.5938,
        'is_hq'     => true,
        'image'     => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=700&q=80',
    ),
    array(
        'id'        => 'basavanagudi',
        'name'      => 'Basavanagudi Center',
        'area'      => 'Bull Temple Road',
        'address'   => 'No. 34, Bull Temple Road, Basavanagudi, Bengaluru – 560004',
        'phone'     => '080 2665 1234',
        'hours'     => 'Morning: 5:30 AM – 10:00 AM | Evening: 5:00 PM – 8:30 PM',
        'email'     => 'basavanagudi@rashtrotthana.org',
        'lat'       => 12.9432,
        'lng'       => 77.5681,
        'is_hq'     => false,
        'image'     => 'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?auto=format&fit=crop&w=700&q=80',
    ),
    array(
        'id'        => 'malleswaram',
        'name'      => 'Malleswaram Center',
        'area'      => '18th Cross, Margosa Road',
        'address'   => 'No. 18, 18th Cross, Margosa Road, Malleswaram, Bengaluru – 560055',
        'phone'     => '080 2336 7890',
        'hours'     => 'Morning: 5:30 AM – 11:00 AM | Evening: 4:30 PM – 8:30 PM',
        'email'     => 'malleswaram@rashtrotthana.org',
        'lat'       => 13.0068,
        'lng'       => 77.5713,
        'is_hq'     => false,
        'image'     => 'https://images.unsplash.com/photo-1487958449943-2429e8be8625?auto=format&fit=crop&w=700&q=80',
    ),
    array(
        'id'        => 'yelahanka',
        'name'      => 'Yelahanka Center',
        'area'      => 'Yelahanka New Town',
        'address'   => 'No. 45, Major Sandeep Unnikrishnan Road, Yelahanka New Town, Bengaluru – 560064',
        'phone'     => '080 2954 5678',
        'hours'     => 'Morning: 5:30 AM – 10:00 AM | Evening: 5:00 PM – 8:30 PM',
        'email'     => 'yelahanka@rashtrotthana.org',
        'lat'       => 13.0990,
        'lng'       => 77.5980,
        'is_hq'     => false,
        'image'     => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=700&q=80',
    ),
    array(
        'id'        => 'sadashivanagar',
        'name'      => 'Sadashivanagar Yogashala',
        'area'      => 'Sadashivanagar',
        'address'   => 'Opp. Sankey Tank, 11th Cross, Sadashivanagar, Bengaluru – 560080',
        'phone'     => '080 2361 9000',
        'hours'     => 'Morning: 6:00 AM – 10:30 AM | Evening: 5:00 PM – 8:00 PM',
        'email'     => 'sadashivanagar@rashtrotthana.org',
        'lat'       => 13.0075,
        'lng'       => 77.5815,
        'is_hq'     => false,
        'image'     => 'https://images.unsplash.com/photo-1545205597-3d9d02c29597?auto=format&fit=crop&w=700&q=80',
    ),
    array(
        'id'        => 'indiranagar',
        'name'      => 'Indiranagar Center',
        'area'      => '100 Feet Road, Indiranagar',
        'address'   => 'No. 88, 100 Feet Road, HAL 2nd Stage, Indiranagar, Bengaluru – 560038',
        'phone'     => '080 2521 4455',
        'hours'     => 'Morning: 5:30 AM – 10:30 AM | Evening: 4:30 PM – 8:30 PM',
        'email'     => 'indiranagar@rashtrotthana.org',
        'lat'       => 12.9784,
        'lng'       => 77.6408,
        'is_hq'     => false,
        'image'     => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=700&q=80',
    ),
);

// Frequently Asked Questions Dataset
$faqs_dataset = array(
    array(
        'q' => 'What are the daily timings and batch options at Rashtrotthana Yoga centers?',
        'a' => 'Most of our Bengaluru centers offer morning sessions starting from 5:30 AM up to 10:30 AM, and evening batches from 4:30 PM to 8:30 PM. We have beginner, intermediate, advanced, and therapeutic batches. You may select morning or evening slots depending on your personal daily routine.',
    ),
    array(
        'q' => 'How can I enroll in a yoga class or register for a consultation?',
        'a' => 'You can fill out the contact form on this page with your preferred timing and center, call our centralized counseling desk directly at 080 2664 4444, or walk into your nearest center during working hours. Our certified instructors will guide you through a brief health evaluation and recommend the optimal batch.',
    ),
    array(
        'q' => 'Do you provide interactive online yoga sessions?',
        'a' => 'Yes, Rashtrotthana Yoga conducts daily live interactive online classes via Zoom led by experienced teachers. Sessions include real-time posture corrections, guided Pranayama, and meditation, designed for practitioners joining from anywhere in India or abroad.',
    ),
    array(
        'q' => 'Are there specialized Yoga Therapy programs for health conditions?',
        'a' => 'Yes. We run dedicated Yoga Therapy programs for chronic back pain, cervical spondylosis, diabetes management, hypertension, asthma, and stress management. Therapy sessions are prescribed after a thorough assessment and supervised by certified yoga therapists.',
    ),
    array(
        'q' => 'Are there dedicated classes for children and senior citizens?',
        'a' => 'Certainly. We have "Bala Yoga" programs designed to enhance memory, concentration, stamina, and posture in school-going children. For seniors, we offer gentle, chair-assisted restorative yoga focusing on joint flexibility, balanced breathing, and vitality.',
    ),
    array(
        'q' => 'How can I volunteer or contribute to Rashtrotthana\'s social initiatives?',
        'a' => 'Rashtrotthana Yoga welcomes volunteers for free community yoga drives, youth fitness camps, rural outreach, blood donation drives, and cultural festivals. Please reach out via our contact form or send an email to info@rashtrotthanayoga.org with the subject "Volunteer Inquiry".',
    ),
);
