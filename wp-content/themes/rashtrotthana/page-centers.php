<?php get_header(); ?>

<!-- Leaflet CSS & JS for Interactive Centers Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
/* ============================================================
   Centers Page — Synced Background with Homepage & About Us
   ============================================================ */
.rs-centers-page {
    position: relative;
    isolation: isolate;
    color: var(--color-text);
    background: 
        linear-gradient(rgba(255, 255, 255, 0.82), rgba(255, 255, 255, 0.82)),
        url("<?php echo esc_url( get_template_directory_uri() . '/assets/images/bg.jpg' ); ?>") center top / cover fixed no-repeat !important;
    animation: rs-nature-drift 24s ease-in-out infinite alternate;
}
.rs-centers-page::before,
.rs-centers-page::after {
    position: absolute;
    z-index: -1;
    display: block;
    width: 26rem;
    height: 26rem;
    border-radius: 50%;
    content: "";
    filter: blur(12px);
    opacity: .80;
    pointer-events: none;
}
.rs-centers-page::before {
    top: 0; left: 0;
    width: 100%; height: 100%;
    border-radius: 0;
    background:
        radial-gradient(circle at 8% 8%, rgba(249, 183, 42, .18), transparent 26rem),
        radial-gradient(circle at 92% 16%, rgba(243, 106, 33, .14), transparent 30rem);
    filter: none;
    opacity: 1;
}
.rs-centers-page::after {
    top: 55rem; right: -15rem;
    background: radial-gradient(circle, rgba(249, 183, 42, .22), transparent 68%);
    animation: rsa-atmosphere-pulse 5s ease-in-out infinite alternate;
}
@keyframes rs-nature-drift {
    0%   { background-position: center top, 48% top; }
    100% { background-position: center top, 52% top; }
}
@keyframes rsa-atmosphere-pulse {
    0%   { opacity: .28; transform: scale(.96); }
    100% { opacity: .6;  transform: scale(1.08); }
}
@media (prefers-reduced-motion: reduce) {
    .rs-centers-page { animation: none; }
    .rs-centers-page::after { animation: none; }
}
</style>

<?php
$centers = array(
    array(
        'id'        => 'jayanagar',
        'name'      => 'Jayanagar Center',
        'area'      => '4th Block, Jayanagar',
        'zone'      => 'South Bengaluru',
        'zone_slug' => 'south',
        'lat'       => 12.9250,
        'lng'       => 77.5938,
        'phone'     => '080 2664 4444',
        'hours'     => 'Morning: 5:30 AM – 10:30 AM | Evening: 4:30 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for Beginners', 'Yoga Therapy', 'Pranayama', 'Yoga for All'),
        'activities'=> array('yoga', 'therapy', 'wellness'),
        'address'   => 'No. 12, 4th Block, Jayanagar, Bengaluru – 560011',
        'email'     => 'jayanagar@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Spacious Yoga Shala', 'Certified Instructors', 'Ayurveda & Therapy Desk'),
    ),
    array(
        'id'        => 'basavanagudi',
        'name'      => 'Basavanagudi Center',
        'area'      => 'Bull Temple Road',
        'zone'      => 'South Bengaluru',
        'zone_slug' => 'south',
        'lat'       => 12.9432,
        'lng'       => 77.5681,
        'phone'     => '080 2665 1234',
        'hours'     => 'Morning: 5:30 AM – 10:00 AM | Evening: 5:00 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for All', 'Yoga Therapy', 'Children Programs', 'Pranayama'),
        'activities'=> array('yoga', 'therapy', 'children', 'wellness'),
        'address'   => 'No. 34, Bull Temple Road, Basavanagudi, Bengaluru – 560004',
        'email'     => 'basavanagudi@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Historic Cultural Hall', 'Prenatal & Therapy Care', 'Library & Reading Room'),
    ),
    array(
        'id'        => 'malleswaram',
        'name'      => 'Malleswaram Center',
        'area'      => '18th Cross, Margosa Road',
        'zone'      => 'Central Bengaluru',
        'zone_slug' => 'central',
        'lat'       => 13.0068,
        'lng'       => 77.5713,
        'phone'     => '080 2336 7890',
        'hours'     => 'Morning: 5:30 AM – 11:00 AM | Evening: 4:30 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for All', 'Pranayama & Meditation', 'Vedic Arts', 'Therapeutic Yoga'),
        'activities'=> array('yoga', 'therapy', 'culture', 'wellness'),
        'address'   => 'Rashtrotthana Complex, 18th Cross, Margosa Road, Malleswaram, Bengaluru – 560003',
        'email'     => 'malleswaram@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1487958449943-2429e8be8625?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Multi-Storey Complex', 'Full Yoga Studio', 'Cultural Academy'),
    ),
    array(
        'id'        => 'yelahanka',
        'name'      => 'Yelahanka Center',
        'area'      => 'Yelahanka New Town',
        'zone'      => 'North Bengaluru',
        'zone_slug' => 'north',
        'lat'       => 13.0990,
        'lng'       => 77.5963,
        'phone'     => '080 2954 5678',
        'hours'     => 'Morning: 5:30 AM – 10:00 AM | Evening: 5:00 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for Beginners', 'Fitness Yoga', 'Therapy', 'Meditation'),
        'activities'=> array('yoga', 'fitness', 'therapy', 'wellness'),
        'address'   => 'New Town Main Road, Yelahanka, Bengaluru – 560064',
        'email'     => 'yelahanka@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Modern Open Space', 'Yoga Equipment Available', 'Dedicated Parking'),
    ),
    array(
        'id'        => 'indiranagar',
        'name'      => 'Indiranagar Center',
        'area'      => '100 Feet Road, Indiranagar',
        'zone'      => 'East Bengaluru',
        'zone_slug' => 'east',
        'lat'       => 12.9784,
        'lng'       => 77.6408,
        'phone'     => '080 2521 3344',
        'hours'     => 'Morning: 6:00 AM – 10:30 AM | Evening: 4:30 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Vinyasa Yoga', 'Therapeutic Yoga', 'Mindfulness & Meditation', 'Corporate Yoga'),
        'activities'=> array('yoga', 'wellness', 'fitness'),
        'address'   => '100 Feet Road, HAL 2nd Stage, Indiranagar, Bengaluru – 560038',
        'email'     => 'indiranagar@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1545205597-3d9d02c29597?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Premium Studio Flooring', 'Airy Natural Light', 'Individual Consultation'),
    ),
    array(
        'id'        => 'koramangala',
        'name'      => 'Koramangala Center',
        'area'      => '5th Block, Koramangala',
        'zone'      => 'South Bengaluru',
        'zone_slug' => 'south',
        'lat'       => 12.9352,
        'lng'       => 77.6245,
        'phone'     => '080 2553 7890',
        'hours'     => 'Morning: 5:45 AM – 10:00 AM | Evening: 5:00 PM – 9:00 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Power Yoga', 'Yoga for Beginners', 'Stress Management', 'Youth Batches'),
        'activities'=> array('yoga', 'fitness', 'wellness'),
        'address'   => '80 Feet Road, 5th Block, Koramangala, Bengaluru – 560095',
        'email'     => 'koramangala@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Central Location', 'Special Youth Programs', 'Weekend Intensive Workshops'),
    ),
    array(
        'id'        => 'banashankari',
        'name'      => 'Banashankari Center',
        'area'      => '2nd Stage, BSK',
        'zone'      => 'South Bengaluru',
        'zone_slug' => 'south',
        'lat'       => 12.9255,
        'lng'       => 77.5670,
        'phone'     => '080 2671 2233',
        'hours'     => 'Morning: 5:30 AM – 10:00 AM | Evening: 4:30 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for All', 'Senior Citizen Yoga', 'Pranayama', 'Yoga Therapy'),
        'activities'=> array('yoga', 'therapy', 'wellness'),
        'address'   => '100 Feet Ring Road, 2nd Stage, Banashankari, Bengaluru – 560070',
        'email'     => 'banashankari@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Senior Citizen Friendly', 'Gentle Therapy Focus', 'Spiritual Study Circle'),
    ),
    array(
        'id'        => 'rajajinagar',
        'name'      => 'Rajajinagar Center',
        'area'      => '1st Block, Rajajinagar',
        'zone'      => 'West Bengaluru',
        'zone_slug' => 'west',
        'lat'       => 12.9982,
        'lng'       => 77.5530,
        'phone'     => '080 2312 4567',
        'hours'     => 'Morning: 5:30 AM – 10:30 AM | Evening: 5:00 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Hatha Yoga', 'Kids Yoga & Sanskrit', 'Women Health Batches', 'Therapy'),
        'activities'=> array('yoga', 'children', 'therapy', 'culture'),
        'address'   => 'Dr. Rajkumar Road, 1st Block, Rajajinagar, Bengaluru – 560010',
        'email'     => 'rajajinagar@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Traditional Gurukula Spirit', 'Holistic Women Wellness', 'Weekend Seminars'),
    ),
    array(
        'id'        => 'hsrlayout',
        'name'      => 'HSR Layout Center',
        'area'      => 'Sector 2, HSR Layout',
        'zone'      => 'South Bengaluru',
        'zone_slug' => 'south',
        'lat'       => 12.9116,
        'lng'       => 77.6389,
        'phone'     => '080 2572 8899',
        'hours'     => 'Morning: 6:00 AM – 10:00 AM | Evening: 5:00 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Ashtanga Vinyasa', 'Weight Management', 'Pranayama', 'Kids Fitness'),
        'activities'=> array('yoga', 'fitness', 'children', 'wellness'),
        'address'   => '27th Main Road, Sector 2, HSR Layout, Bengaluru – 560102',
        'email'     => 'hsr@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1575052814086-f385e2e2ad1b?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Tech-Professional Batches', 'Postural Correction Clinics', 'Shower Facilities'),
    ),
    array(
        'id'        => 'whitefield',
        'name'      => 'Whitefield Center',
        'area'      => 'ITPL Main Road',
        'zone'      => 'East Bengaluru',
        'zone_slug' => 'east',
        'lat'       => 12.9698,
        'lng'       => 77.7499,
        'phone'     => '080 2845 6789',
        'hours'     => 'Morning: 6:00 AM – 9:30 AM | Evening: 5:30 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Corporate Destress Yoga', 'Yoga Therapy', 'Meditation', 'Beginners Core'),
        'activities'=> array('yoga', 'wellness', 'therapy'),
        'address'   => 'Near Hope Farm Junction, ITPL Main Road, Whitefield, Bengaluru – 560066',
        'email'     => 'whitefield@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1599447421416-3414500d18a5?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Ergonomic Posture Focus', 'Stress Relief Audio Lab', 'Evening Stretch Batches'),
    ),
    array(
        'id'        => 'marathahalli',
        'name'      => 'Marathahalli Center',
        'area'      => 'Outer Ring Road',
        'zone'      => 'East Bengaluru',
        'zone_slug' => 'east',
        'lat'       => 12.9591,
        'lng'       => 77.6974,
        'phone'     => '080 2854 1122',
        'hours'     => 'Morning: 5:30 AM – 9:30 AM | Evening: 5:00 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for All', 'Gymnastics & Yoga', 'Karate & Taekwondo', 'Therapy'),
        'activities'=> array('yoga', 'martial-arts', 'fitness', 'therapy'),
        'address'   => 'Varthur Main Road, Near Bridge, Marathahalli, Bengaluru – 560037',
        'email'     => 'marathahalli@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Integrated Sports Wing', 'Kids Martial Arts Arena', 'Physical Fitness Labs'),
    ),
    array(
        'id'        => 'vijayanagar',
        'name'      => 'Vijayanagar Center',
        'area'      => 'MC Layout, Vijayanagar',
        'zone'      => 'West Bengaluru',
        'zone_slug' => 'west',
        'lat'       => 12.9698,
        'lng'       => 77.5358,
        'phone'     => '080 2338 9911',
        'hours'     => 'Morning: 5:30 AM – 10:30 AM | Evening: 4:30 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for Beginners', 'Therapy Clinics', 'Samskrita Bharati Classes', 'Wellness'),
        'activities'=> array('yoga', 'therapy', 'children', 'wellness'),
        'address'   => '17th Cross, MC Layout, Vijayanagar, Bengaluru – 560040',
        'email'     => 'vijayanagar@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Close to Metro Station', 'Experienced Senior Gurus', 'Ayur-Diet Consultation'),
    ),
    array(
        'id'        => 'hebbal',
        'name'      => 'Hebbal Center',
        'area'      => 'Bellary Road, Near Flyover',
        'zone'      => 'North Bengaluru',
        'zone_slug' => 'north',
        'lat'       => 13.0358,
        'lng'       => 77.5970,
        'phone'     => '080 2341 5500',
        'hours'     => 'Morning: 5:30 AM – 9:30 AM | Evening: 5:00 PM – 8:00 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for Beginners', 'Therapy Sessions', 'Pranayama', 'Meditation'),
        'activities'=> array('yoga', 'therapy', 'wellness'),
        'address'   => 'Bellary Road, Near Hebbal Flyover, Bengaluru – 560024',
        'email'     => 'hebbal@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Serene Green Ambience', 'Spine & Backache Clinics', 'Yoga Mats Provided'),
    ),
    array(
        'id'        => 'sahakarnagar',
        'name'      => 'Sahakarnagar Center',
        'area'      => 'F Block, Sahakarnagar',
        'zone'      => 'North Bengaluru',
        'zone_slug' => 'north',
        'lat'       => 13.0623,
        'lng'       => 77.5925,
        'phone'     => '080 2362 7788',
        'hours'     => 'Morning: 5:30 AM – 10:00 AM | Evening: 4:30 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for All', 'Taekwondo & Karate', 'Women Wellness', 'Pranayama'),
        'activities'=> array('yoga', 'martial-arts', 'wellness'),
        'address'   => 'F Block, Sahakarnagar Main Road, Bengaluru – 560092',
        'email'     => 'sahakarnagar@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Spacious Training Grounds', 'Self-Defence Academy', 'Community Health Camps'),
    ),
    array(
        'id'        => 'rtnagar',
        'name'      => 'RT Nagar Center',
        'area'      => 'Dinnur Main Road',
        'zone'      => 'North Bengaluru',
        'zone_slug' => 'north',
        'lat'       => 13.0184,
        'lng'       => 77.5924,
        'phone'     => '080 2333 4455',
        'hours'     => 'Morning: 5:30 AM – 9:30 AM | Evening: 5:00 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for Beginners', 'Therapy for Diabetes & BP', 'Meditation', 'Pranayama'),
        'activities'=> array('yoga', 'therapy', 'wellness'),
        'address'   => 'Dinnur Main Road, RT Nagar, Bengaluru – 560032',
        'email'     => 'rtnagar@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1545205597-3d9d02c29597?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Metabolic Health Specialists', 'Individual Progress Tracking', 'Quiet Study Ambience'),
    ),
    array(
        'id'        => 'padmanabhanagar',
        'name'      => 'Padmanabhanagar Center',
        'area'      => 'Near Devegowda Petrol Bunk',
        'zone'      => 'South Bengaluru',
        'zone_slug' => 'south',
        'lat'       => 12.9182,
        'lng'       => 77.5576,
        'phone'     => '080 2669 3322',
        'hours'     => 'Morning: 5:30 AM – 10:00 AM | Evening: 4:30 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for All', 'Yoga Therapy', 'Vedic Chanting', 'Children Shloka Batches'),
        'activities'=> array('yoga', 'therapy', 'children', 'culture'),
        'address'   => '15th Main, Padmanabhanagar, Bengaluru – 560070',
        'email'     => 'padmanabhanagar@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Sanskrit & Culture Wing', 'Senior Citizen Care', 'Herbal Garden Campus'),
    ),
    array(
        'id'        => 'kengeri',
        'name'      => 'Kengeri Satellite Town',
        'area'      => 'Near Metro Station, Kengeri',
        'zone'      => 'West Bengaluru',
        'zone_slug' => 'west',
        'lat'       => 12.9081,
        'lng'       => 77.4854,
        'phone'     => '080 2848 9900',
        'hours'     => 'Morning: 5:30 AM – 9:30 AM | Evening: 5:00 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for Beginners', 'Sports Fitness', 'Therapy', 'Meditation'),
        'activities'=> array('yoga', 'fitness', 'therapy', 'wellness'),
        'address'   => 'Satellite Town Main Road, Kengeri, Bengaluru – 560060',
        'email'     => 'kengeri@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Expansive Green Campus', 'Residential Yoga Retreats', 'Direct Metro Connectivity'),
    ),
    array(
        'id'        => 'nagarbhavi',
        'name'      => 'Nagarbhavi Center',
        'area'      => '2nd Stage, Nagarbhavi',
        'zone'      => 'West Bengaluru',
        'zone_slug' => 'west',
        'lat'       => 12.9602,
        'lng'       => 77.5103,
        'phone'     => '080 2321 6677',
        'hours'     => 'Morning: 5:30 AM – 10:00 AM | Evening: 5:00 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for All', 'Therapeutic Asanas', 'Pranayama & Kriya', 'Youth Fitness'),
        'activities'=> array('yoga', 'therapy', 'wellness', 'fitness'),
        'address'   => 'Near BDA Complex, 2nd Stage, Nagarbhavi, Bengaluru – 560072',
        'email'     => 'nagarbhavi@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Natural Ventilation Halls', 'Kriya Cleansing Workshops', 'Youth Sports Clubs'),
    ),
    array(
        'id'        => 'mahalakshmi',
        'name'      => 'Mahalakshmi Layout',
        'area'      => '12th Main, Mahalakshmi Layout',
        'zone'      => 'West Bengaluru',
        'zone_slug' => 'west',
        'lat'       => 13.0125,
        'lng'       => 77.5458,
        'phone'     => '080 2349 8811',
        'hours'     => 'Morning: 5:30 AM – 10:00 AM | Evening: 4:30 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for All', 'Pranayama & Chanting', 'Bharatanatyam', 'Therapy'),
        'activities'=> array('yoga', 'culture', 'therapy', 'wellness'),
        'address'   => '12th Main Road, Mahalakshmi Layout, Bengaluru – 560086',
        'email'     => 'mahalakshmi@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Elevated Panoramic Shala', 'Classical Dance Wing', 'Spiritual Discourse Hall'),
    ),
    array(
        'id'        => 'peenya',
        'name'      => 'Peenya Center',
        'area'      => 'Industrial Area, 2nd Stage',
        'zone'      => 'West Bengaluru',
        'zone_slug' => 'west',
        'lat'       => 13.0285,
        'lng'       => 77.5255,
        'phone'     => '080 2839 4400',
        'hours'     => 'Morning: 6:00 AM – 9:00 AM | Evening: 5:30 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Workplace Wellness', 'Yoga for Beginners', 'Therapy', 'Stress Relief'),
        'activities'=> array('yoga', 'wellness', 'therapy'),
        'address'   => 'Peenya Industrial Area, 2nd Stage, Bengaluru – 560058',
        'email'     => 'peenya@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1545205597-3d9d02c29597?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Industrial Shift Batches', 'Occupational Health Clinics', 'Soundproof Yoga Hall'),
    ),
    array(
        'id'        => 'chandralayout',
        'name'      => 'Chandra Layout Center',
        'area'      => '1st Main Road, Chandra Layout',
        'zone'      => 'West Bengaluru',
        'zone_slug' => 'west',
        'lat'       => 12.9568,
        'lng'       => 77.5273,
        'phone'     => '080 2328 1199',
        'hours'     => 'Morning: 5:30 AM – 10:00 AM | Evening: 5:00 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for Beginners', 'Prenatal Yoga', 'Children Programs', 'Meditation'),
        'activities'=> array('yoga', 'wellness', 'children'),
        'address'   => '1st Main Road, Chandra Layout, Vijayanagar, Bengaluru – 560040',
        'email'     => 'chandralayout@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Neighbourhood Yoga Sanctuary', 'Maternal Yoga Batches', 'Boutique Studio'),
    ),
    array(
        'id'        => 'bellandur',
        'name'      => 'Bellandur Center',
        'area'      => 'Green Glen Layout',
        'zone'      => 'East Bengaluru',
        'zone_slug' => 'east',
        'lat'       => 12.9260,
        'lng'       => 77.6762,
        'phone'     => '080 2574 3300',
        'hours'     => 'Morning: 6:00 AM – 10:00 AM | Evening: 5:30 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Corporate Fitness', 'Vinyasa Flow', 'Pranayama', 'Yoga Therapy'),
        'activities'=> array('yoga', 'fitness', 'wellness', 'therapy'),
        'address'   => 'Green Glen Layout, Bellandur, Bengaluru – 560103',
        'email'     => 'bellandur@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Tech Corridor Location', 'Ergonomic Desk Relief', 'Mindfulness Sessions'),
    ),
    array(
        'id'        => 'jpnagar',
        'name'      => 'JP Nagar Center',
        'area'      => '6th Phase, JP Nagar',
        'zone'      => 'South Bengaluru',
        'zone_slug' => 'south',
        'lat'       => 12.9063,
        'lng'       => 77.5855,
        'phone'     => '080 2658 9090',
        'hours'     => 'Morning: 5:30 AM – 10:00 AM | Evening: 4:30 PM – 8:30 PM',
        'timing'    => 'both',
        'timing_label' => 'Morning & Evening',
        'programs'  => array('Yoga for All', 'Therapeutic Yoga', 'Meditation & Chanting', 'Kids Batches'),
        'activities'=> array('yoga', 'therapy', 'children', 'wellness'),
        'address'   => '24th Main Road, 6th Phase, JP Nagar, Bengaluru – 560078',
        'email'     => 'jpnagar@rashtrotthana.org',
        'image'     => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=800&q=80',
        'features'  => array('Spacious Wooden Floor Shala', 'Therapy Consultations', 'Cultural Hall'),
    ),
);

/**
 * Helper: Retrieve formatted weekly operation hours for a center
 */
if ( ! function_exists( 'rs_get_center_op_hours' ) ) {
    function rs_get_center_op_hours( $center ) {
        if ( ! empty( $center['operation_hours'] ) ) {
            return $center['operation_hours'];
        }
        $cid = ! empty( $center['id'] ) ? $center['id'] : '';
        if ( in_array( $cid, array( 'indiranagar', 'koramangala', 'whitefield', 'bellandur', 'hsrlayout' ) ) ) {
            return 'Mon – Sat: 6:00 AM – 9:00 PM | Sun: 6:30 AM – 1:00 PM';
        } elseif ( in_array( $cid, array( 'malleswaram', 'jayanagar', 'basavanagudi', 'jpnagar', 'banashankari' ) ) ) {
            return 'Mon – Sat: 5:30 AM – 8:30 PM | Sun: 6:00 AM – 1:00 PM';
        } elseif ( in_array( $cid, array( 'peenya' ) ) ) {
            return 'Mon – Sat: 6:00 AM – 8:30 PM | Sun: Closed (Facility Maintenance)';
        } else {
            return 'Mon – Sat: 5:30 AM – 8:30 PM | Sun: 6:00 AM – 12:30 PM';
        }
    }
}

/**
 * Helper: Retrieve rich, comprehensive activity schedules for each center
 */
if ( ! function_exists( 'rs_get_center_detailed_activities' ) ) {
    function rs_get_center_detailed_activities( $center ) {
        $programs = ! empty( $center['programs'] ) ? $center['programs'] : array( 'Yoga for Beginners', 'Yoga for All', 'Yoga Therapy', 'Pranayama' );
        $activities = array();

        foreach ( $programs as $prog ) {
            $prog_lower = strtolower( $prog );

            if ( strpos( $prog_lower, 'beginner' ) !== false ) {
                $activities[] = array(
                    'name'    => 'Yoga for Beginners (Sarala Yoga)',
                    'badge'   => 'Foundational',
                    'days'    => 'Monday to Friday (5 Days/wk)',
                    'timings' => 'Morning: 6:00 AM – 7:00 AM | Evening: 6:00 PM – 7:00 PM',
                    'dates'   => 'New batches start 1st & 16th of every month (Ongoing admissions)',
                    'desc'    => 'Foundational asanas, joint mobility drills (Sukshma Vyayama), breathing fundamentals, and guided Shavasana relaxation tailored for newcomers.',
                );
            } elseif ( strpos( $prog_lower, 'therapy' ) !== false || strpos( $prog_lower, 'therapeutic' ) !== false ) {
                $activities[] = array(
                    'name'    => 'Yoga Chikitsa (Therapeutic Yoga Clinic)',
                    'badge'   => 'Personalized Care',
                    'days'    => 'Mon, Wed, Fri & Saturday',
                    'timings' => 'Morning: 8:30 AM – 9:30 AM, 9:45 AM – 10:45 AM | Evening: 4:30 PM – 5:30 PM',
                    'dates'   => 'Prior doctor consultation required; individualized daily recovery slots',
                    'desc'    => 'Targeted clinical yoga modules addressing chronic lumbar & cervical pain, postural correction, hypertension, diabetes, and stress management.',
                );
            } elseif ( strpos( $prog_lower, 'pranayama' ) !== false || strpos( $prog_lower, 'meditation' ) !== false || strpos( $prog_lower, 'dhyana' ) !== false ) {
                $activities[] = array(
                    'name'    => 'Pranayama & Dhyana (Breathwork & Meditation)',
                    'badge'   => 'Mindfulness',
                    'days'    => 'Tuesday, Thursday & Saturday',
                    'timings' => 'Morning: 6:30 AM – 7:30 AM | Evening: 7:00 PM – 8:00 PM',
                    'dates'   => 'Continuous monthly enrollment (Weekday & weekend slots)',
                    'desc'    => 'Systematic breath control covering Nadi Shodhana, Kapalabhati, Bhramari resonance, and guided silent meditation for nervous system harmony.',
                );
            } elseif ( strpos( $prog_lower, 'all' ) !== false || strpos( $prog_lower, 'general' ) !== false || strpos( $prog_lower, 'hatha' ) !== false ) {
                $activities[] = array(
                    'name'    => 'Yoga for All (Samanya & Advanced Yoga)',
                    'badge'   => 'Daily Batches',
                    'days'    => 'Monday to Saturday (6 Days/wk)',
                    'timings' => 'Morning: 5:30 AM – 6:30 AM, 7:15 AM – 8:15 AM | Evening: 5:00 PM – 6:00 PM, 6:30 PM – 7:30 PM',
                    'dates'   => 'Open admissions — enroll at any time during the month',
                    'desc'    => 'Comprehensive daily practice incorporating dynamic Surya Namaskar series, posture endurance, core strength, flexibility, and pranayama.',
                );
            } elseif ( strpos( $prog_lower, 'child' ) !== false || strpos( $prog_lower, 'kids' ) !== false || strpos( $prog_lower, 'bala' ) !== false ) {
                $activities[] = array(
                    'name'    => 'Bala Yoga & Samskara Kendra (Children)',
                    'badge'   => 'Ages 6–14',
                    'days'    => 'Saturday & Sunday (Weekend Batches)',
                    'timings' => 'Saturday: 4:30 PM – 6:00 PM | Sunday: 8:00 AM – 9:30 AM',
                    'dates'   => 'Quarterly & annual batches open year-round',
                    'desc'    => 'Value-based personality development integrating physical agility postures, memory-enhancing shlokas, concentration drills, and cultural games.',
                );
            } elseif ( strpos( $prog_lower, 'corporate' ) !== false || strpos( $prog_lower, 'destress' ) !== false || strpos( $prog_lower, 'workplace' ) !== false ) {
                $activities[] = array(
                    'name'    => 'Corporate Destress & Ergonomic Posture Yoga',
                    'badge'   => 'Working Professionals',
                    'days'    => 'Monday to Friday',
                    'timings' => 'Morning: 6:30 AM – 7:30 AM | Evening: 7:00 PM – 8:00 PM',
                    'dates'   => 'Flexible monthly batches for working professionals',
                    'desc'    => 'Relieve desk-bound spinal compression, cervical tension, and digital eye strain with targeted corrective yoga and restorative breathwork.',
                );
            } elseif ( strpos( $prog_lower, 'karate' ) !== false || strpos( $prog_lower, 'taekwondo' ) !== false || strpos( $prog_lower, 'martial' ) !== false ) {
                $activities[] = array(
                    'name'    => 'Martial Arts & Self-Defence Academy',
                    'badge'   => 'Discipline & Fitness',
                    'days'    => 'Tuesday, Thursday & Saturday',
                    'timings' => 'Morning: 6:00 AM – 7:15 AM | Evening: 5:30 PM – 6:45 PM',
                    'dates'   => 'New batches start 1st of every month (Belt gradings held periodically)',
                    'desc'    => 'Self-defence katas, agility conditioning, sparring drills, and mental focus led by certified black-belt instructors for youth and adults.',
                );
            } elseif ( strpos( $prog_lower, 'prenatal' ) !== false || strpos( $prog_lower, 'women' ) !== false ) {
                $activities[] = array(
                    'name'    => 'Prenatal & Women\'s Wellness Yoga',
                    'badge'   => 'Specialized Care',
                    'days'    => 'Mon, Wed & Friday',
                    'timings' => 'Morning: 9:30 AM – 10:30 AM | Evening: 4:30 PM – 5:30 PM',
                    'dates'   => 'Intake on every Monday (Medical clearance recommended)',
                    'desc'    => 'Safe, nurturing prenatal movements, pelvic floor strengthening, breath coordination, and restorative relaxation supporting maternal wellness.',
                );
            } elseif ( strpos( $prog_lower, 'art' ) !== false || strpos( $prog_lower, 'dance' ) !== false || strpos( $prog_lower, 'bharatanatyam' ) !== false || strpos( $prog_lower, 'sanskrit' ) !== false || strpos( $prog_lower, 'chanting' ) !== false ) {
                $activities[] = array(
                    'name'    => 'Classical Arts & Cultural Academy',
                    'badge'   => 'Heritage & Culture',
                    'days'    => 'Friday, Saturday & Sunday',
                    'timings' => 'Evening: 5:00 PM – 7:00 PM',
                    'dates'   => 'Quarterly admission cycle starting 1st of every month',
                    'desc'    => 'Indian classical music, Bharatanatyam dance fundamentals, and Vedic shloka recitation cultivating traditional cultural heritage.',
                );
            } elseif ( strpos( $prog_lower, 'vinyasa' ) !== false || strpos( $prog_lower, 'power' ) !== false || strpos( $prog_lower, 'weight' ) !== false || strpos( $prog_lower, 'fitness' ) !== false ) {
                $activities[] = array(
                    'name'    => 'Vinyasa Flow & Functional Fitness',
                    'badge'   => 'High Energy',
                    'days'    => 'Monday to Friday',
                    'timings' => 'Morning: 6:00 AM – 7:00 AM | Evening: 6:30 PM – 7:30 PM',
                    'dates'   => 'Continuous admissions on a monthly basis',
                    'desc'    => 'Dynamic breath-synchronized flow sequences designed to build core strength, cardiovascular stamina, metabolic burn, and bodily flexibility.',
                );
            } else {
                $activities[] = array(
                    'name'    => $prog,
                    'badge'   => 'Regular Batch',
                    'days'    => 'Monday to Friday',
                    'timings' => 'Morning: 6:00 AM – 7:30 AM | Evening: 5:30 PM – 7:00 PM',
                    'dates'   => 'Admissions open 1st & 16th of every month',
                    'desc'    => 'Guided yoga curriculum at ' . $center['name'] . ' fostering health, vitality, mental clarity, and mindfulness.',
                );
            }
        }

        if ( count( $activities ) < 3 ) {
            $activities[] = array(
                'name'    => 'Pranayama & Guided Meditation',
                'badge'   => 'All Levels',
                'days'    => 'Tuesday, Thursday & Saturday',
                'timings' => 'Morning: 6:30 AM – 7:30 AM | Evening: 7:00 PM – 8:00 PM',
                'dates'   => 'Continuous monthly admissions',
                'desc'    => 'Cultivate breath mastery, mental peace, and stress resilience under certified Rashtrotthana Yoga Acharyas.',
            );
        }

        return $activities;
    }
}

/**
 * Helper: Retrieve center-specific upcoming events
 */
if ( ! function_exists( 'rs_get_center_events' ) ) {
    function rs_get_center_events( $center ) {
        $events = array();
        $cid = ! empty( $center['id'] ) ? $center['id'] : '';
        $cname = ! empty( $center['name'] ) ? $center['name'] : 'Center';
        $events_url = home_url( '/events/' );

        // Event 1: Flagship Community Gathering
        $events[] = array(
            'title' => 'International Yoga Day Celebration 2026',
            'desc'  => 'A grand community gathering celebrating the transformative power of Yoga. Join hundreds of practitioners at ' . $cname . ' for collective Surya Namaskara, guided pranayama, and sacred chanting.',
            'link'  => $events_url . '#event-1',
        );

        // Event 2 & 3: Tailored to center zone & character
        if ( in_array( $cid, array( 'whitefield', 'bellandur', 'indiranagar', 'koramangala', 'hsrlayout' ) ) ) {
            $events[] = array(
                'title' => 'Corporate Destress & Spinal Health Workshop',
                'desc'  => 'An intensive practical masterclass designed for working professionals to release cervical fatigue, improve desk posture, and restore natural sleep rhythm.',
                'link'  => $events_url . '#event-3',
            );
            $events[] = array(
                'title' => 'Breathwork & Sound Resonance Masterclass',
                'desc'  => 'Deep experiential session blending Nadi Shodhana, Brahmari resonance, and Omkar meditation to alleviate mental fatigue and balance cortisol levels.',
                'link'  => $events_url . '#event-4',
            );
        } elseif ( in_array( $cid, array( 'basavanagudi', 'rajajinagar', 'padmanabhanagar', 'mahalakshmi' ) ) ) {
            $events[] = array(
                'title' => 'Summer Yoga & Samskara Camp for Children',
                'desc'  => 'An enriching 10-day immersive camp for kids aged 7–14 featuring posture agility, Sanskrit shlokas, memory games, moral stories, and traditional Indian team sports.',
                'link'  => $events_url . '#event-2',
            );
            $events[] = array(
                'title' => 'Vedic Chanting & Cultural Yoga Darshana',
                'desc'  => 'Explore traditional Patanjali Yoga Sutra recitations, classical breath control, and experiential sessions on yogic lifestyle at ' . $cname . '.',
                'link'  => $events_url . '#event-4',
            );
        } elseif ( in_array( $cid, array( 'jayanagar', 'malleswaram', 'vijayanagar', 'banashankari', 'jpnagar' ) ) ) {
            $events[] = array(
                'title' => 'Yoga for Stress Alleviation & Metabolic Wellness',
                'desc'  => 'Targeted psychosomatic wellness workshop designed to dissolve chronic tension, regulate hypertension and blood sugar, and enhance vital energy.',
                'link'  => $events_url . '#event-3',
            );
            $events[] = array(
                'title' => 'Meditation & Pranayama Intensive Masterclass',
                'desc'  => 'Deep dive into traditional breath regulation, Antar Mouna meditation, and yogic relaxation led by senior Acharyas with over 20 years of practice.',
                'link'  => $events_url . '#event-4',
            );
        } else {
            $events[] = array(
                'title' => 'Surya Namaskara & Breathwork Intensive',
                'desc'  => 'An invigorating morning intensive exploring 108 Surya Namaskaras, ujjayi breathing, and rhythmic core stabilization with individualized guidance.',
                'link'  => $events_url . '#event-3',
            );
            $events[] = array(
                'title' => 'Holistic Health & Lifestyle Consultation Camp',
                'desc'  => 'One-on-one postural evaluation, personalized therapeutic asana recommendations, and natural lifestyle counseling by qualified Yoga experts.',
                'link'  => $events_url . '#event-4',
            );
        }

        return $events;
    }
}

// Enrich each center with operation hours, detailed activities, and events
foreach ( $centers as &$c ) {
    $c['operation_hours']  = rs_get_center_op_hours( $c );
    $c['activity_details'] = rs_get_center_detailed_activities( $c );
    $c['events']           = rs_get_center_events( $c );
}
unset( $c );
?>

<main class="rs-centers-page">

    <!-- Header Section (Without old Hero/Numbers banner) -->
    <section class="rs-centers-header-section">
        <div class="rs-container">
            <div class="rs-centers-title-block">
                <div class="rs-centers-eyebrow">
                    <span class="rs-centers-eyebrow-dot"></span>
                    <span>BENGALURU NETWORK</span>
                </div>
                <h1 class="rs-centers-main-title">Explore Our Centers</h1>
                <p class="rs-centers-main-subtitle">
                    Discover 23+ vibrant centers across Bengaluru offering certified yoga, holistic therapy, and cultural programs. Find your nearest location, check batch timings, and join our community.
                </p>
            </div>

            <!-- Control Bar: Working Live Search & Working Multi-Filters -->
            <div class="rs-centers-control-bar">
                <div class="rs-search-box">
                    <span class="rs-search-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </span>
                    <input type="search" id="rs-center-search-input" placeholder="Search by center name, area, address, or activity..." aria-label="Search centers">
                    <button type="button" id="rs-search-clear" class="rs-search-clear-btn" aria-label="Clear search" title="Clear search">✕</button>
                </div>

                <div class="rs-filters-group">
                    <div class="rs-filter-item">
                        <label for="rs-filter-zone" class="sr-only">Zone</label>
                        <select id="rs-filter-zone" aria-label="Filter by zone">
                            <option value="all">All Zones</option>
                            <option value="south">South Bengaluru</option>
                            <option value="central">Central Bengaluru</option>
                            <option value="north">North Bengaluru</option>
                            <option value="east">East Bengaluru</option>
                            <option value="west">West Bengaluru</option>
                        </select>
                    </div>

                    <div class="rs-filter-item">
                        <label for="rs-filter-activity" class="sr-only">Activity</label>
                        <select id="rs-filter-activity" aria-label="Filter by activity">
                            <option value="all">All Activities</option>
                            <option value="yoga">Yoga &amp; Wellness</option>
                            <option value="therapy">Therapy &amp; Naturopathy</option>
                            <option value="children">Children Programs</option>
                            <option value="fitness">Fitness &amp; Sports</option>
                            <option value="martial-arts">Martial Arts</option>
                            <option value="culture">Arts &amp; Culture</option>
                        </select>
                    </div>

                    <div class="rs-filter-item">
                        <label for="rs-filter-timing" class="sr-only">Timing</label>
                        <select id="rs-filter-timing" aria-label="Filter by timing">
                            <option value="all">All Timings</option>
                            <option value="both">Morning &amp; Evening</option>
                            <option value="morning">Morning Batches</option>
                            <option value="evening">Evening Batches</option>
                        </select>
                    </div>

                    <button type="button" id="rs-clear-all-filters" class="rs-clear-btn">
                        <span aria-hidden="true">↺</span> Reset
                    </button>
                </div>
            </div>

            <div class="rs-centers-status-bar">
                <p class="rs-status-count">
                    Showing <span id="rs-centers-count">4</span> of <span id="rs-centers-total"><?php echo count($centers); ?></span> Centers
                </p>
                <div class="rs-status-hint">
                    <span>💡 Click any card or pin to highlight on map &amp; view batch schedules</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content: 50/50 Top Split (Top 4 Cards & Leaflet Map) + Full Width Lower Grid on "See More" -->
    <section class="rs-centers-directory-section">
        <div class="rs-container">

            <!-- Top 50% / 50% Split -->
            <div class="rs-centers-layout">

                <!-- Left 50%: Top 4 Cards Grid -->
                <div class="rs-centers-list-col">
                    <div class="rs-centers-grid" id="rs-centers-top-grid">
                        <?php 
                        for ( $i = 0; $i < min(4, count($centers)); $i++ ) : 
                            $center = $centers[$i];
                            $index = $i;
                        ?>
                            <article class="rs-directory-card"
                                     id="card-<?php echo esc_attr( $center['id'] ); ?>"
                                     data-id="<?php echo esc_attr( $center['id'] ); ?>"
                                     data-index="<?php echo esc_attr( $index ); ?>"
                                     data-name="<?php echo esc_attr( $center['name'] ); ?>"
                                     data-area="<?php echo esc_attr( $center['area'] ); ?>"
                                     data-address="<?php echo esc_attr( $center['address'] ); ?>"
                                     data-zone="<?php echo esc_attr( $center['zone_slug'] ); ?>"
                                     data-timing="<?php echo esc_attr( $center['timing'] ); ?>"
                                     data-activities="<?php echo esc_attr( implode(',', $center['activities']) ); ?>"
                                     data-programs="<?php echo esc_attr( implode(' ', $center['programs']) ); ?>"
                                     data-lat="<?php echo esc_attr( $center['lat'] ); ?>"
                                     data-lng="<?php echo esc_attr( $center['lng'] ); ?>"
                                     tabindex="0"
                                     role="region"
                                     aria-label="<?php echo esc_attr( $center['name'] ); ?>">

                                <div class="rs-directory-card-media">
                                    <img src="<?php echo esc_url( $center['image'] ); ?>" alt="<?php echo esc_attr( $center['name'] ); ?>" loading="lazy">
                                    <div class="rs-directory-card-media-overlay"></div>
                                    <span class="rs-directory-zone-pill"><?php echo esc_html( $center['zone'] ); ?></span>
                                    <button type="button" class="rs-locate-pin-btn" data-locate-id="<?php echo esc_attr( $center['id'] ); ?>" title="Locate on Map" aria-label="Locate on Map">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                    </button>
                                </div>

                                <div class="rs-directory-card-body">
                                    <div class="rs-directory-card-header">
                                        <h3 class="rs-directory-card-title"><?php echo esc_html( $center['name'] ); ?></h3>
                                        <p class="rs-directory-area">
                                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/>
                                                <circle cx="12" cy="10" r="3"/>
                                            </svg>
                                            <span><?php echo esc_html( $center['area'] ); ?></span>
                                        </p>
                                    </div>

                                    <div class="rs-directory-timing">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        <span><?php echo esc_html( $center['timing_label'] ); ?></span>
                                    </div>

                                    <div class="rs-directory-programs-tags">
                                        <?php foreach ( array_slice($center['programs'], 0, 3) as $program ) : ?>
                                            <span class="rs-directory-tag"><?php echo esc_html( $program ); ?></span>
                                        <?php endforeach; ?>
                                        <?php if ( count($center['programs']) > 3 ) : ?>
                                            <span class="rs-directory-tag-more">+<?php echo count($center['programs']) - 3; ?> more</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="rs-directory-card-footer">
                                        <a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $center['phone']) ); ?>" class="rs-directory-phone-link" title="Call center" onclick="event.stopPropagation();">
                                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                            </svg>
                                            <span><?php echo esc_html( $center['phone'] ); ?></span>
                                        </a>

                                        <button type="button" class="rs-center-details rs-open-center-modal-btn" data-modal="center-modal-<?php echo esc_attr( $center['id'] ); ?>" aria-haspopup="dialog">
                                            <span>View Details</span>
                                            <span aria-hidden="true">→</span>
                                        </button>
                                    </div>
                                </div>
                            </article>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Right 50%: Leaflet Interactive Map -->
                <div class="rs-centers-map-col">
                    <div class="rs-centers-map-container">
                        <div class="rs-map-header-bar">
                            <div class="rs-map-header-title">
                                <span class="rs-map-pulse-indicator"></span>
                                <span id="rs-map-title-text">All 23 Centers on Map</span>
                            </div>
                            <button type="button" id="rs-map-reset-view" class="rs-map-reset-view-btn" title="Show All Centers">
                                <span>⟲ All Centers</span>
                            </button>
                        </div>
                        <div id="rs-leaflet-map" class="rs-leaflet-map"></div>
                        <div class="rs-map-footer-hint">
                            <span>💡 Click any card or pin to highlight &amp; view batch schedules</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Lower Section: Centers 5+ appear below the map & top cards across 2 columns -->
            <div class="rs-centers-more-section" id="rs-centers-more-section">
                <div class="rs-centers-more-grid" id="rs-centers-more-grid">
                    <?php 
                    for ( $i = 4; $i < count($centers); $i++ ) : 
                        $center = $centers[$i];
                        $index = $i;
                    ?>
                        <article class="rs-directory-card"
                                 id="card-<?php echo esc_attr( $center['id'] ); ?>"
                                 data-id="<?php echo esc_attr( $center['id'] ); ?>"
                                 data-index="<?php echo esc_attr( $index ); ?>"
                                 data-name="<?php echo esc_attr( $center['name'] ); ?>"
                                 data-area="<?php echo esc_attr( $center['area'] ); ?>"
                                 data-address="<?php echo esc_attr( $center['address'] ); ?>"
                                 data-zone="<?php echo esc_attr( $center['zone_slug'] ); ?>"
                                 data-timing="<?php echo esc_attr( $center['timing'] ); ?>"
                                 data-activities="<?php echo esc_attr( implode(',', $center['activities']) ); ?>"
                                 data-programs="<?php echo esc_attr( implode(' ', $center['programs']) ); ?>"
                                 data-lat="<?php echo esc_attr( $center['lat'] ); ?>"
                                 data-lng="<?php echo esc_attr( $center['lng'] ); ?>"
                                 tabindex="0"
                                 role="region"
                                 aria-label="<?php echo esc_attr( $center['name'] ); ?>"
                                 style="display: none;">

                            <div class="rs-directory-card-media">
                                <img src="<?php echo esc_url( $center['image'] ); ?>" alt="<?php echo esc_attr( $center['name'] ); ?>" loading="lazy">
                                <div class="rs-directory-card-media-overlay"></div>
                                <span class="rs-directory-zone-pill"><?php echo esc_html( $center['zone'] ); ?></span>
                                <button type="button" class="rs-locate-pin-btn" data-locate-id="<?php echo esc_attr( $center['id'] ); ?>" title="Locate on Map" aria-label="Locate on Map">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="rs-directory-card-body">
                                <div class="rs-directory-card-header">
                                    <h3 class="rs-directory-card-title"><?php echo esc_html( $center['name'] ); ?></h3>
                                    <p class="rs-directory-area">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                        <span><?php echo esc_html( $center['area'] ); ?></span>
                                    </p>
                                </div>

                                <div class="rs-directory-timing">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    <span><?php echo esc_html( $center['timing_label'] ); ?></span>
                                </div>

                                <div class="rs-directory-programs-tags">
                                    <?php foreach ( array_slice($center['programs'], 0, 3) as $program ) : ?>
                                        <span class="rs-directory-tag"><?php echo esc_html( $program ); ?></span>
                                    <?php endforeach; ?>
                                    <?php if ( count($center['programs']) > 3 ) : ?>
                                        <span class="rs-directory-tag-more">+<?php echo count($center['programs']) - 3; ?> more</span>
                                    <?php endif; ?>
                                </div>

                                <div class="rs-directory-card-footer">
                                    <a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $center['phone']) ); ?>" class="rs-directory-phone-link" title="Call center" onclick="event.stopPropagation();">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                        </svg>
                                        <span><?php echo esc_html( $center['phone'] ); ?></span>
                                    </a>

                                    <button type="button" class="rs-center-details rs-open-center-modal-btn" data-modal="center-modal-<?php echo esc_attr( $center['id'] ); ?>" aria-haspopup="dialog">
                                        <span>View Details</span>
                                        <span aria-hidden="true">→</span>
                                    </button>
                                </div>
                            </div>
                        </article>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- See More Button (Paginates 4 at a time) -->
            <div class="rs-see-more-wrap" id="rs-see-more-wrap">
                <button type="button" id="rs-see-more-btn" class="rs-see-more-btn">
                    <span>See More Centers (<?php echo count($centers) - 4; ?> more) ↓</span>
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
            </div>

            <!-- No Results State -->
            <div id="rs-centers-no-results" class="rs-centers-no-results" style="display: none;">
                <div class="rs-no-results-icon">⌕</div>
                <h3>No centers match your filters</h3>
                <p>Try searching for a different area or clear your filter criteria to see all 23+ locations across Bengaluru.</p>
                <button type="button" id="rs-reset-filters-btn" class="rs-reset-filters-btn">Reset All Filters</button>
            </div>

        </div>
    </section>

    <!-- Redesigned Assistance / Help Banner -->
    <section class="rs-center-help-section">
        <div class="rs-container">
            <div class="rs-center-help-card">
                <div class="rs-help-card-glow" aria-hidden="true"></div>
                <div class="rs-help-card-left">
                    <div class="rs-help-icon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </div>
                    <div class="rs-help-text">
                        <span class="rs-help-eyebrow">NEED PERSONAL GUIDANCE?</span>
                        <h3>Can't find the right center or schedule?</h3>
                        <p>Our wellness team will connect you with the ideal batch, certified instructor, or therapy consultation nearest to your home or office.</p>
                    </div>
                </div>
                <div class="rs-help-card-actions">
                    <a href="tel:+918026644444" class="rs-help-btn-primary">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span>Call 080 2664 4444</span>
                    </a>
                    <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" class="rs-help-btn-secondary">
                        <span>Send an Enquiry →</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- Redesigned Pop-up Modals for Each Center -->
<?php foreach ( $centers as $index => $center ) : 
    $center_activities = ! empty( $center['activity_details'] ) ? $center['activity_details'] : rs_get_center_detailed_activities( $center );
    $center_events     = ! empty( $center['events'] ) ? $center['events'] : rs_get_center_events( $center );
    $center_op_hours   = ! empty( $center['operation_hours'] ) ? $center['operation_hours'] : rs_get_center_op_hours( $center );
?>
    <div class="rs-center-modal" id="center-modal-<?php echo esc_attr( $center['id'] ); ?>" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="center-modal-title-<?php echo esc_attr( $center['id'] ); ?>">
        <div class="rs-center-modal-backdrop" data-close-modal="true"></div>
        <div class="rs-center-modal-container">
            <article class="rs-center-modal-card">
                <button type="button" class="rs-center-modal-close" aria-label="Close center details" data-close-modal="true">✕</button>

                <div class="rs-center-modal-header">
                    <div class="rs-center-modal-meta">
                        <span class="rs-center-modal-zone-badge"><?php echo esc_html( $center['zone'] ); ?></span>
                        <span class="rs-center-modal-dot" aria-hidden="true">•</span>
                        <span class="rs-center-modal-kicker">RASHTROTTHANA YOGA</span>
                    </div>
                    <h2 class="rs-center-modal-title" id="center-modal-title-<?php echo esc_attr( $center['id'] ); ?>">
                        <?php echo esc_html( $center['name'] ); ?>
                    </h2>
                    <p class="rs-center-modal-address">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span><?php echo esc_html( $center['address'] ); ?></span>
                    </p>
                </div>

                <div class="rs-center-modal-divider" aria-hidden="true"></div>

                <!-- Quick Specs Grid: Operation Hours, Direct Phone & Email Address (Location Zone removed) -->
                <div class="rs-center-specs-grid">
                    <div class="rs-spec-item rs-spec-op-hours">
                        <span class="rs-spec-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </span>
                        <div class="rs-spec-content">
                            <strong>Operation Hours</strong>
                            <p><?php echo esc_html( $center_op_hours ); ?></p>
                        </div>
                    </div>

                    <div class="rs-spec-item">
                        <span class="rs-spec-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </span>
                        <div class="rs-spec-content">
                            <strong>Direct Phone</strong>
                            <p><a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $center['phone']) ); ?>"><?php echo esc_html( $center['phone'] ); ?></a></p>
                        </div>
                    </div>

                    <div class="rs-spec-item">
                        <span class="rs-spec-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </span>
                        <div class="rs-spec-content">
                            <strong>Email Address</strong>
                            <p><a href="mailto:<?php echo esc_attr( $center['email'] ); ?>"><?php echo esc_html( $center['email'] ); ?></a></p>
                        </div>
                    </div>
                </div>

                <!-- Detailed Activities Section (Replaces Available Programs) -->
                <div class="rs-center-modal-section">
                    <div class="rs-center-modal-section-header">
                        <div>
                            <h3 class="rs-center-modal-section-title">Activities &amp; Batch Schedules</h3>
                            <p class="rs-center-modal-section-subtitle">Structured courses, therapeutic sessions, and daily batches conducted at this center.</p>
                        </div>
                    </div>
                    <div class="rs-center-activities-grid">
                        <?php foreach ( $center_activities as $act ) : ?>
                            <div class="rs-center-activity-card">
                                <div class="rs-center-act-top">
                                    <h4 class="rs-center-act-title"><?php echo esc_html( $act['name'] ); ?></h4>
                                    <?php if ( ! empty( $act['badge'] ) ) : ?>
                                        <span class="rs-center-act-badge"><?php echo esc_html( $act['badge'] ); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="rs-center-act-details">
                                    <div class="rs-center-act-detail-row">
                                        <span class="rs-act-detail-icon" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        </span>
                                        <span class="rs-act-detail-text"><strong>Timings:</strong> <?php echo esc_html( $act['timings'] ); ?></span>
                                    </div>
                                    <div class="rs-center-act-detail-row">
                                        <span class="rs-act-detail-icon" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                        </span>
                                        <span class="rs-act-detail-text"><strong>Batches:</strong> <?php echo esc_html( $act['days'] ); ?></span>
                                    </div>
                                    <?php if ( ! empty( $act['dates'] ) ) : ?>
                                        <div class="rs-center-act-detail-row">
                                            <span class="rs-act-detail-icon" aria-hidden="true">
                                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                                            </span>
                                            <span class="rs-act-detail-text"><strong>Admissions:</strong> <?php echo esc_html( $act['dates'] ); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p class="rs-center-act-desc"><?php echo esc_html( $act['desc'] ); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Center Events Section -->
                <div class="rs-center-modal-section">
                    <div class="rs-center-modal-section-header">
                        <div>
                            <h3 class="rs-center-modal-section-title">Center Events &amp; Workshops</h3>
                            <p class="rs-center-modal-section-subtitle">Upcoming special gatherings and intensive workshops scheduled at <?php echo esc_html( $center['name'] ); ?>.</p>
                        </div>
                    </div>
                    <div class="rs-center-modal-events-grid">
                        <?php foreach ( $center_events as $evt ) : ?>
                            <div class="rs-center-modal-event-card">
                                <div class="rs-center-modal-event-info">
                                    <h4 class="rs-center-modal-event-name"><?php echo esc_html( $evt['title'] ); ?></h4>
                                    <p class="rs-center-modal-event-desc"><?php echo esc_html( $evt['desc'] ); ?></p>
                                </div>
                                <div class="rs-center-modal-event-action">
                                    <a href="<?php echo esc_url( $evt['link'] ); ?>" class="rs-center-modal-event-register-btn">
                                        <span>Register Now →</span>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Facility Highlights -->
                <div class="rs-center-modal-section">
                    <h3 class="rs-center-modal-section-title">Facility Highlights</h3>
                    <div class="rs-center-modal-features">
                        <?php foreach ( $center['features'] as $feat ) : ?>
                            <div class="rs-modal-feature-badge">
                                <span class="rs-feature-check">✓</span>
                                <span><?php echo esc_html( $feat ); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Modal Actions (Close button removed from bottom) -->
                <div class="rs-center-modal-footer">
                    <p class="rs-center-modal-footer-note">
                        Need personalized batch timings or trial classes? Reach out directly to this center.
                    </p>
                    <div class="rs-center-modal-actions">
                        <a href="https://www.google.com/maps/search/?api=1&query=<?php echo rawurlencode( 'Rashtrotthana Yoga ' . $center['name'] . ' ' . $center['address'] ); ?>" target="_blank" rel="noopener" class="rs-center-modal-directions-btn">
                            <span>Get Directions ↗</span>
                        </a>
                        <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" class="rs-center-modal-enquire-btn">
                            <span>Enquire Now →</span>
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>
<?php endforeach; ?>

<!-- JSON Data for Dynamic Scripting -->
<script id="rs-centers-data" type="application/json">
<?php echo wp_json_encode( $centers ); ?>
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var rawData = document.getElementById('rs-centers-data');
    var centersData = [];
    if (rawData) {
        try { centersData = JSON.parse(rawData.textContent); } catch (e) { console.error(e); }
    }

    var body = document.body;
    var searchInput = document.getElementById('rs-center-search-input');
    var searchClearBtn = document.getElementById('rs-search-clear');
    var zoneFilter = document.getElementById('rs-filter-zone');
    var activityFilter = document.getElementById('rs-filter-activity');
    var timingFilter = document.getElementById('rs-filter-timing');
    var resetBtn = document.getElementById('rs-clear-all-filters');
    var emptyResetBtn = document.getElementById('rs-reset-filters-btn');
    var countDisplay = document.getElementById('rs-centers-count');
    var totalCountDisplay = document.getElementById('rs-centers-total');
    var noResultsBox = document.getElementById('rs-centers-no-results');
    var topGrid = document.getElementById('rs-centers-top-grid');
    var moreGrid = document.getElementById('rs-centers-more-grid');
    var cards = Array.from(document.querySelectorAll('.rs-directory-card'));
    var seeMoreWrap = document.getElementById('rs-see-more-wrap');
    var seeMoreBtn = document.getElementById('rs-see-more-btn');
    var mapTitleText = document.getElementById('rs-map-title-text');
    var mapResetBtn = document.getElementById('rs-map-reset-view');

    var visibleLimit = 4;
    var matchingCards = [];
    var markersMap = {};
    var activeMarkerId = null;

    // ============================================================
    // 1. LEAFLET MAP INITIALIZATION & MARKERS
    // ============================================================
    var mapContainer = document.getElementById('rs-leaflet-map');
    if (!mapContainer) return;

    var map = L.map('rs-leaflet-map', {
        scrollWheelZoom: false,
        zoomControl: true
    }).setView([12.9716, 77.5946], 11);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    var mapIconUrl = '<?php echo esc_url( get_template_directory_uri() . "/assets/images/map_icon.png" ); ?>';

    function createMarkerIcon(isHighlighted) {
        return L.divIcon({
            className: 'rs-leaflet-custom-marker',
            html: '<div class="rs-map-flag-pin' + (isHighlighted ? ' is-highlighted' : '') + '">' +
                  '<div class="rs-flag-base-shadow"></div>' +
                  '<img src="' + mapIconUrl + '" class="rs-map-flag-img" alt="Center Marker">' +
                  '<div class="rs-flag-pulse"></div>' +
                  '</div>',
            iconSize: [38, 52],
            iconAnchor: [4, 51],
            popupAnchor: [15, -48]
        });
    }

    var allMarkersLayer = L.featureGroup().addTo(map);

    // Create Leaflet markers for all 23 centers
    centersData.forEach(function (center) {
        if (!center.lat || !center.lng) return;

        var marker = L.marker([center.lat, center.lng], {
            icon: createMarkerIcon(false),
            title: center.name,
            riseOnHover: true
        });

        var popupContent = 
            '<div class="rs-map-popup-inner">' +
                '<img src="' + center.image + '" alt="' + center.name + '" class="rs-map-popup-media" loading="lazy">' +
                '<div class="rs-map-popup-header">' +
                    '<span class="rs-directory-zone-pill" style="position:static;display:inline-block;padding:2px 7px;font-size:0.62rem;">' + center.zone + '</span>' +
                '</div>' +
                '<h4 class="rs-map-popup-title">' + center.name + '</h4>' +
                '<p class="rs-map-popup-area">' +
                    '<svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/><circle cx="12" cy="10" r="3"/></svg> ' +
                    center.area +
                '</p>' +
                '<p class="rs-map-popup-timing">☀ ' + (center.timing_label || center.hours) + '</p>' +
                '<button type="button" class="rs-map-popup-btn rs-open-center-modal-btn" data-modal="center-modal-' + center.id + '">View Details →</button>' +
            '</div>';

        marker.bindPopup(popupContent, { maxWidth: 280, className: 'rs-custom-leaflet-popup' });

        marker.on('click', function () {
            highlightCenter(center.id, false);
        });

        markersMap[center.id] = marker;
        allMarkersLayer.addLayer(marker);
    });

    if (centersData.length > 0) {
        map.fitBounds(allMarkersLayer.getBounds(), { padding: [36, 36] });
    }

    // Highlighting Logic
    function highlightCenter(centerId, doFly) {
        if (activeMarkerId && markersMap[activeMarkerId]) {
            markersMap[activeMarkerId].setIcon(createMarkerIcon(false));
            markersMap[activeMarkerId].setZIndexOffset(0);
        }
        cards.forEach(function (c) { c.classList.remove('is-active'); });

        activeMarkerId = centerId;
        var marker = markersMap[centerId];
        var card = document.getElementById('card-' + centerId);

        if (card) {
            card.classList.add('is-active');
        }

        if (marker) {
            marker.setIcon(createMarkerIcon(true));
            marker.setZIndexOffset(1000);
            if (doFly) {
                map.flyTo(marker.getLatLng(), 15, { duration: 0.8 });
                setTimeout(function () {
                    marker.openPopup();
                }, 400);
            } else {
                marker.openPopup();
            }

            var centerObj = centersData.find(function(c) { return c.id === centerId; });
            if (mapTitleText && centerObj) {
                mapTitleText.textContent = centerObj.name;
            }
        }
    }

    function resetAllMarkersHighlight() {
        if (activeMarkerId && markersMap[activeMarkerId]) {
            markersMap[activeMarkerId].setIcon(createMarkerIcon(false));
            markersMap[activeMarkerId].setZIndexOffset(0);
        }
        activeMarkerId = null;
        cards.forEach(function (c) { c.classList.remove('is-active'); });
        if (mapTitleText) {
            mapTitleText.textContent = 'All 23 Centers on Map';
        }
        if (allMarkersLayer.getLayers().length > 0) {
            map.fitBounds(allMarkersLayer.getBounds(), { padding: [36, 36] });
        }
    }

    // ============================================================
    // 2. FILTERING, SEARCH & PROGRESSIVE "SEE MORE" DISPLAY
    // ============================================================
    function updateCardVisibility() {
        var query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        var zoneVal = zoneFilter ? zoneFilter.value : 'all';
        var actVal = activityFilter ? activityFilter.value : 'all';
        var timingVal = timingFilter ? timingFilter.value : 'all';

        if (searchClearBtn) {
            searchClearBtn.style.display = query ? 'flex' : 'none';
        }

        matchingCards = [];
        var matchingBounds = L.latLngBounds([]);

        cards.forEach(function (card) {
            var cId = card.dataset.id;
            var cZone = card.dataset.zone;
            var cActivities = card.dataset.activities ? card.dataset.activities.split(',') : [];
            var cTiming = card.dataset.timing;
            var searchable = (
                card.dataset.name + ' ' +
                card.dataset.area + ' ' +
                card.dataset.address + ' ' +
                card.dataset.programs
            ).toLowerCase();

            var matchQuery = !query || searchable.indexOf(query) !== -1;
            var matchZone = (zoneVal === 'all') || (cZone === zoneVal);
            var matchAct = (actVal === 'all') || cActivities.indexOf(actVal) !== -1;
            var matchTiming = (timingVal === 'all') || (cTiming === timingVal) || (cTiming === 'both');

            var isMatch = matchQuery && matchZone && matchAct && matchTiming;
            var marker = markersMap[cId];

            if (isMatch) {
                matchingCards.push(card);
                if (marker) {
                    if (!allMarkersLayer.hasLayer(marker)) {
                        allMarkersLayer.addLayer(marker);
                    }
                    matchingBounds.extend(marker.getLatLng());
                }
            } else {
                if (marker && allMarkersLayer.hasLayer(marker)) {
                    allMarkersLayer.removeLayer(marker);
                }
            }
        });

        // Hide all cards first
        cards.forEach(function (card) {
            card.style.display = 'none';
        });

        // Distribute visible matching cards into Top Grid (first 4) and More Grid (5+)
        matchingCards.forEach(function (card, idx) {
            if (idx < visibleLimit) {
                card.style.display = '';
                if (idx < 4) {
                    if (topGrid && card.parentElement !== topGrid) {
                        topGrid.appendChild(card);
                    }
                } else {
                    if (moreGrid && card.parentElement !== moreGrid) {
                        moreGrid.appendChild(card);
                    }
                }
            }
        });

        // Update status counts
        var currentlyShown = Math.min(visibleLimit, matchingCards.length);
        if (countDisplay) {
            countDisplay.textContent = currentlyShown;
        }
        if (totalCountDisplay) {
            totalCountDisplay.textContent = matchingCards.length;
        }

        // Handle "See More" button visibility
        if (seeMoreWrap && seeMoreBtn) {
            if (matchingCards.length > visibleLimit) {
                seeMoreWrap.style.display = 'flex';
                var remaining = matchingCards.length - visibleLimit;
                seeMoreBtn.querySelector('span').textContent = 'See More Centers (' + remaining + ' more) ↓';
            } else {
                seeMoreWrap.style.display = 'none';
            }
        }

        // Empty state
        if (noResultsBox) {
            noResultsBox.style.display = (matchingCards.length === 0) ? 'block' : 'none';
        }

        // Fit map bounds to matching centers
        if (matchingCards.length > 0 && matchingBounds.isValid()) {
            map.fitBounds(matchingBounds, { padding: [40, 40], maxZoom: 14 });
            if (mapTitleText) {
                mapTitleText.textContent = matchingCards.length + ' Matching Centers on Map';
            }
        } else if (matchingCards.length === 0) {
            if (mapTitleText) {
                mapTitleText.textContent = 'No Matching Centers';
            }
        }
    }

    function onFilterChange() {
        visibleLimit = 4; // Reset to top 4 cards on every filter or search change
        updateCardVisibility();
    }

    function onSeeMoreClick() {
        visibleLimit += 4; // Reveal next 4 cards
        updateCardVisibility();
    }

    function resetAllFilters() {
        if (searchInput) searchInput.value = '';
        if (zoneFilter) zoneFilter.value = 'all';
        if (activityFilter) activityFilter.value = 'all';
        if (timingFilter) timingFilter.value = 'all';
        visibleLimit = 4;
        updateCardVisibility();
        resetAllMarkersHighlight();
    }

    if (seeMoreBtn) seeMoreBtn.addEventListener('click', onSeeMoreClick);
    if (searchInput) searchInput.addEventListener('input', onFilterChange);
    if (searchClearBtn) searchClearBtn.addEventListener('click', function () {
        searchInput.value = '';
        searchInput.focus();
        onFilterChange();
    });
    if (zoneFilter) zoneFilter.addEventListener('change', onFilterChange);
    if (activityFilter) activityFilter.addEventListener('change', onFilterChange);
    if (timingFilter) timingFilter.addEventListener('change', onFilterChange);
    if (resetBtn) resetBtn.addEventListener('click', resetAllFilters);
    if (emptyResetBtn) emptyResetBtn.addEventListener('click', resetAllFilters);
    if (mapResetBtn) mapResetBtn.addEventListener('click', resetAllMarkersHighlight);

    // Clicking card centers & highlights Leaflet Marker
    cards.forEach(function (card) {
        card.addEventListener('click', function (e) {
            if (e.target.closest('.rs-open-center-modal-btn') || e.target.closest('.rs-directory-phone-link')) {
                return;
            }
            highlightCenter(this.dataset.id, true);
        });
    });

    // Locate button on card thumbnail
    document.querySelectorAll('.rs-locate-pin-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var card = this.closest('.rs-directory-card');
            if (card) {
                highlightCenter(card.dataset.id, true);
            }
        });
    });

    // ============================================================
    // 3. CARD 3D TILT EFFECT
    // ============================================================
    cards.forEach(function (card) {
        card.addEventListener('mousemove', function (e) {
            var rect = this.getBoundingClientRect();
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;
            var centerX = rect.width / 2;
            var centerY = rect.height / 2;
            var rotateX = ((y - centerY) / centerY) * -5;
            var rotateY = ((x - centerX) / centerX) * 5;
            this.style.setProperty('--card-rotate-x', rotateX.toFixed(2) + 'deg');
            this.style.setProperty('--card-rotate-y', rotateY.toFixed(2) + 'deg');
        });
        card.addEventListener('mouseleave', function () {
            this.style.setProperty('--card-rotate-x', '0deg');
            this.style.setProperty('--card-rotate-y', '0deg');
        });
    });

    // ============================================================
    // 4. REDESIGNED MODAL POPUP LOGIC WITH BACKGROUND BLUR
    // ============================================================
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        body.classList.add('rs-center-modal-open');
        var closeBtn = modal.querySelector('.rs-center-modal-close');
        if (closeBtn) closeBtn.focus();
    }

    function closeModal() {
        document.querySelectorAll('.rs-center-modal.is-open').forEach(function (modal) {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        });
        body.classList.remove('rs-center-modal-open');
    }

    document.addEventListener('click', function (e) {
        var openBtn = e.target.closest('.rs-open-center-modal-btn');
        if (openBtn) {
            e.preventDefault();
            e.stopPropagation();
            var modalId = openBtn.dataset.modal;
            if (modalId) openModal(modalId);
            return;
        }

        if (e.target.matches('[data-close-modal="true"]') || e.target.closest('[data-close-modal="true"]')) {
            e.preventDefault();
            closeModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });

    // Initial render
    updateCardVisibility();
});
</script>

<?php get_footer(); ?>
