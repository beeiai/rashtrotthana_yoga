<?php get_header(); ?>

<style>
/* ============================================================
   Activities Page — Synced with Homepage & About Us Design System
   ============================================================ */
.rs-activities-page {
    position: relative;
    isolation: isolate;
    color: var(--color-text);
    background: 
        linear-gradient(rgba(255, 255, 255, 0.82), rgba(255, 255, 255, 0.82)),
        url("<?php echo esc_url( get_template_directory_uri() . '/assets/images/bg.jpg' ); ?>") center top / cover fixed no-repeat !important;
    animation: rs-nature-drift 24s ease-in-out infinite alternate;
}
.rs-activities-page::before,
.rs-activities-page::after {
    position: absolute;
    z-index: -1;
    display: block;
    width: 24rem;
    height: 24rem;
    border-radius: 50%;
    content: "";
    filter: blur(10px);
    opacity: .80;
    pointer-events: none;
}
.rs-activities-page::before {
    top: 0; left: 0;
    width: 100%; height: 100%;
    border-radius: 0;
    background:
        radial-gradient(circle at 8% 8%, rgba(249, 183, 42, .18), transparent 24rem),
        radial-gradient(circle at 92% 18%, rgba(243, 106, 33, .14), transparent 28rem);
    filter: none;
    opacity: 1;
}
.rs-activities-page::after {
    top: 60rem; right: -15rem;
    background: radial-gradient(circle, rgba(249, 183, 42, .24), transparent 68%);
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
    .rs-activities-page { animation: none; }
    .rs-activities-page::after { animation: none; }
}
</style>

<?php
$activity_categories = array(
    array(
        'slug'     => 'yoga-wellness',
        'icon'     => '☯',
        'title'    => 'Yoga & Wellness',
        'tagline'  => 'Strength, Balance & Inner Peace',
        'text'     => 'Yoga practices that build physical strength, flexibility, mental clarity, and inner calm across all age groups.',
        'image'    => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80',
        'items'    => array(
            array(
                'name'        => 'Yoga for Beginners (Sarala Yoga)',
                'badge'       => 'Foundational',
                'desc'        => 'Gentle joint mobility movements (Sukshma Vyayama), fundamental standing and sitting asanas, basic pranayama, and guided Shavasana relaxation.',
                'centers'     => 'Jayanagar, Basavanagudi, Malleswaram, Vijayanagar, Indiranagar, Whitefield, HSR Layout, JP Nagar, Sahakarnagar',
                'batches'     => 'Morning: 6:00 AM – 7:00 AM, 7:15 AM – 8:15 AM | Evening: 6:00 PM – 7:00 PM',
                'duration'    => '60 Mins / Class | 3-Month Foundation Course',
                'frequency'   => '5 Days / Week (Monday – Friday)',
                'eligibility' => 'Beginners & All Age Groups (Ages 12+)',
            ),
            array(
                'name'        => 'Yoga for All (Samanya & Advanced Yoga)',
                'badge'       => 'Daily Batches',
                'desc'        => 'Comprehensive daily practice incorporating dynamic Surya Namaskar cycles, posture endurance, core strength, flexibility, and vital energy pranayama.',
                'centers'     => 'Available at all 23 Rashtrotthana Centers across Bengaluru',
                'batches'     => 'Morning: 5:30 AM – 6:30 AM, 7:00 AM – 8:00 AM | Evening: 5:00 PM – 6:00 PM, 6:30 PM – 7:30 PM',
                'duration'    => '60 Mins / Class | Ongoing Monthly Enrollment',
                'frequency'   => '6 Days / Week (Monday – Saturday)',
                'eligibility' => 'All practitioners seeking sustained daily stamina & wellness',
            ),
            array(
                'name'        => 'Yoga Therapy Sessions (Yoga Chikitsa)',
                'badge'       => 'Therapeutic',
                'desc'        => 'Customized clinical yoga modules addressing chronic lumbar and cervical back pain, postural correction, diabetes, hypertension, and workplace stress.',
                'centers'     => 'Jayanagar, Basavanagudi, Malleswaram, Banashankari, Vijayanagar, JP Nagar, Sahakarnagar, RT Nagar',
                'batches'     => 'Morning: 8:30 AM – 9:30 AM, 9:45 AM – 10:45 AM | Evening: 4:30 PM – 5:30 PM',
                'duration'    => '60 Mins / Session | Tailored 12-Week Recovery Regimen',
                'frequency'   => '4 Days / Week (Mon, Wed, Fri & Sat)',
                'eligibility' => 'Individuals with chronic ailments or doctor-recommended therapy',
            ),
            array(
                'name'        => 'Prenatal & Postnatal Yoga Care',
                'badge'       => 'Specialized Care',
                'desc'        => 'Safe, nurturing prenatal movements, pelvic floor strengthening, breath coordination, and restorative relaxation supporting maternal wellness.',
                'centers'     => 'Jayanagar, Basavanagudi, Chandra Layout, Malleswaram, Indiranagar',
                'batches'     => 'Morning: 9:30 AM – 10:30 AM | Evening: 4:30 PM – 5:30 PM',
                'duration'    => '60 Mins / Class | Trimester-Wise Supervised Modules',
                'frequency'   => '3 Days / Week (Mon, Wed, Fri)',
                'eligibility' => 'Expectant mothers from 2nd trimester (Medical clearance required)',
            ),
        ),
    ),
    array(
        'slug'     => 'arts-music',
        'icon'     => '♫',
        'title'    => 'Arts & Music',
        'tagline'  => 'Creativity, Harmony & Soul',
        'text'     => 'Nurturing creativity and harmony through classical and contemporary vocal and instrumental music learning.',
        'image'    => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80',
        'items'    => array(
            array(
                'name'        => 'Carnatic Classical Vocal',
                'badge'       => 'Classical Vocal',
                'desc'        => 'Traditional Swara practice, Sarali, Janti varases, Geethams, and sacred Keerthanas rooted in sacred ragas, talas, and classic compositions.',
                'centers'     => 'Jayanagar, Basavanagudi, Malleswaram, Vijayanagar, Padmanabhanagar',
                'batches'     => 'Evening: 5:00 PM – 6:00 PM, 6:15 PM – 7:15 PM | Weekend: 9:00 AM – 10:30 AM',
                'duration'    => '60 Mins / Class | Annual Examination & Certification',
                'frequency'   => '2 to 3 Days / Week',
                'eligibility' => 'Ages 6+ & Adults (Beginner to Senior Vidwat)',
            ),
            array(
                'name'        => 'Keyboard Lessons (Classical & Western)',
                'badge'       => 'Instrumental',
                'desc'        => 'Structured finger dexterity training covering foundational notations, western chord theory, and Indian devotional and melodic pieces.',
                'centers'     => 'Malleswaram, Jayanagar, Basavanagudi, Vijayanagar, Yelahanka',
                'batches'     => 'Evening: 4:30 PM – 5:30 PM, 5:45 PM – 6:45 PM | Weekend Batches',
                'duration'    => '60 Mins / Class | Grade 1 to 8 Structured Syllabi',
                'frequency'   => '2 Days / Week',
                'eligibility' => 'Ages 7+ & Adults (Instruments provided in studio)',
            ),
            array(
                'name'        => 'Light Music (Sugama Sangeetha)',
                'badge'       => 'Vocal',
                'desc'        => 'Soulful rendition of Kannada Bhavageethe, devotionals, Dasa Sahitya, and cultural melodies with lyrical expression and voice culture.',
                'centers'     => 'Basavanagudi, Jayanagar, Malleswaram, Banashankari',
                'batches'     => 'Evening: 5:30 PM – 6:30 PM | Weekend: 10:30 AM – 12:00 PM',
                'duration'    => '60 Mins / Class | 6-Month Certificate Course',
                'frequency'   => '2 Days / Week (Friday & Saturday)',
                'eligibility' => 'Open to all music enthusiasts (Ages 8+)',
            ),
            array(
                'name'        => 'Flute (Classical Bansuri)',
                'badge'       => 'Instrumental',
                'desc'        => 'Bamboo flute training starting from fundamental breath control, blowing technique, and finger placement to classical ragas and improvisations.',
                'centers'     => 'Malleswaram, Jayanagar, Basavanagudi',
                'batches'     => 'Weekend: Saturday 4:00 PM – 5:30 PM, Sunday 8:00 AM – 9:30 AM',
                'duration'    => '90 Mins / Class | Traditional Guru-Shishya Guidance',
                'frequency'   => '2 Days / Week (Saturday & Sunday)',
                'eligibility' => 'Ages 10+ with dedication to wind instruments',
            ),
        ),
    ),
    array(
        'slug'     => 'dance',
        'icon'     => '♬',
        'title'    => 'Dance',
        'tagline'  => 'Grace, Rhythm & Heritage',
        'text'     => 'Traditional dance forms and creative movement preserving India\'s rich cultural heritage and rhythm.',
        'image'    => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=800&q=80',
        'items'    => array(
            array(
                'name'        => 'Bharatanatyam (Kalakshetra / Pandanallur)',
                'badge'       => 'Classical',
                'desc'        => 'Sacred classical Indian dance cultivating precise footwork, adavus, hastamudras, rhythmic tala patterns, and expressive abhinaya storytelling.',
                'centers'     => 'Basavanagudi, Jayanagar, Malleswaram, Mahalakshmi Layout, Vijayanagar',
                'batches'     => 'Evening: 4:30 PM – 5:30 PM, 5:45 PM – 6:45 PM | Weekend: 9:00 AM – 11:00 AM',
                'duration'    => '60 Mins / Class | Alankar to Rangapravesha Certification',
                'frequency'   => '3 Days / Week',
                'eligibility' => 'Ages 5+ to Adults',
            ),
            array(
                'name'        => 'Kathak (North Indian Classical)',
                'badge'       => 'Classical',
                'desc'        => 'North Indian classical dance celebrated for intricate ghungroo footwork (Tatkar), swift pirouettes (Chakkars), padhant recitation, and lyrical Radha-Krishna themes.',
                'centers'     => 'Malleswaram, Indiranagar, Jayanagar',
                'batches'     => 'Evening: 5:00 PM – 6:30 PM | Weekend: 10:00 AM – 11:30 AM',
                'duration'    => '75 Mins / Class | Systematic Gharana Pedagogy',
                'frequency'   => '2 Days / Week',
                'eligibility' => 'Ages 7+ & Adults',
            ),
            array(
                'name'        => 'Folk Dance (Janapada Nritya)',
                'badge'       => 'Folk Heritage',
                'desc'        => 'Vibrant regional folk dances of Karnataka and India including Kolata, Dollu Kunitha rhythms, harvest festivities, and group synchronization.',
                'centers'     => 'Basavanagudi, Malleswaram, Padmanabhanagar, Yelahanka',
                'batches'     => 'Weekend: Saturday & Sunday 3:30 PM – 5:00 PM',
                'duration'    => '90 Mins / Class | Festival Showcase & Annual Production',
                'frequency'   => '2 Days / Week (Weekends)',
                'eligibility' => 'Ages 6 to 18',
            ),
            array(
                'name'        => 'Contemporary Dance & Creative Movement',
                'badge'       => 'Modern Movement',
                'desc'        => 'Expressive modern movement combining bodily agility, floorwork, rhythmic musicality, creative storytelling, and stamina building.',
                'centers'     => 'Indiranagar, Koramangala, Whitefield, HSR Layout',
                'batches'     => 'Evening: 6:30 PM – 7:45 PM | Weekend: 11:00 AM – 12:30 PM',
                'duration'    => '75 Mins / Class | Foundation & Intermediate Levels',
                'frequency'   => '2 to 3 Days / Week',
                'eligibility' => 'Teens & Young Adults (Ages 12+)',
            ),
        ),
    ),
    array(
        'slug'     => 'martial-arts',
        'icon'     => '★',
        'title'    => 'Martial Arts',
        'tagline'  => 'Discipline, Agility & Self-Defence',
        'text'     => 'Self-defence and discipline-building through structured physical training, mental focus, and ancient techniques.',
        'image'    => 'https://images.unsplash.com/photo-1555597673-b21d5c935865?auto=format&fit=crop&w=800&q=80',
        'items'    => array(
            array(
                'name'        => 'Karate (Shotokan / Goju-Ryu)',
                'badge'       => 'All Belts',
                'desc'        => 'Speed, power, self-defence katas, bunkai analysis, and official belt grading examinations conducted under certified black belt masters.',
                'centers'     => 'Marathahalli, Sahakarnagar, Vijayanagar, Yelahanka, Kengeri, Rajajinagar',
                'batches'     => 'Morning: 6:00 AM – 7:15 AM | Evening: 5:30 PM – 6:45 PM',
                'duration'    => '75 Mins / Class | Continuous Belt Grading Cycle',
                'frequency'   => '3 Days / Week (Tue, Thu, Sat)',
                'eligibility' => 'Ages 6+ to Adults',
            ),
            array(
                'name'        => 'Taekwondo (Korean Martial Art)',
                'badge'       => 'Agility & Sparring',
                'desc'        => 'Dynamic high kicks, core agility, mental fortitude, speed breaking, and Olympic-style sparring drills with protective gear.',
                'centers'     => 'Sahakarnagar, Marathahalli, Bellandur, HSR Layout',
                'batches'     => 'Morning: 6:30 AM – 7:30 AM | Evening: 5:00 PM – 6:15 PM',
                'duration'    => '60 Mins / Class | Olympic Sparring Curriculum',
                'frequency'   => '3 Days / Week (Mon, Wed, Fri)',
                'eligibility' => 'Ages 7+ to Youth',
            ),
            array(
                'name'        => 'Kalaripayattu (Ancient Indian Martial Art)',
                'badge'       => 'Traditional',
                'desc'        => 'Ancient Indian warrior art emphasizing animal postures (Ashta Vadivu), body flexibility, oil massages, fluid footwork, and traditional wooden staff forms.',
                'centers'     => 'Basavanagudi, Malleswaram, Indiranagar',
                'batches'     => 'Morning: 6:00 AM – 7:30 AM | Weekend: 7:00 AM – 8:30 AM',
                'duration'    => '90 Mins / Class | Body Conditioning & Combat Conditioning',
                'frequency'   => '3 Days / Week',
                'eligibility' => 'Ages 10+ (Physical readiness required)',
            ),
            array(
                'name'        => 'Self Defence Workshops',
                'badge'       => 'Modular Workshops',
                'desc'        => 'Practical situational awareness, wrist release techniques, evasion tactics, and reflexive defence strategies designed for real-world personal safety.',
                'centers'     => 'Available across all 23 Centers (Special modular batches)',
                'batches'     => 'Weekend: Saturday 4:00 PM – 6:00 PM, Sunday 10:00 AM – 12:00 PM',
                'duration'    => '4-Week Intensive Certificate Bootcamp',
                'frequency'   => 'Weekend Sessions',
                'eligibility' => 'Women, College Students & Corporate Professionals',
            ),
        ),
    ),
    array(
        'slug'     => 'children-programs',
        'icon'     => '☺',
        'title'    => 'Children Programs',
        'tagline'  => 'Values, Character & Joyful Learning',
        'text'     => 'Value-based education and holistic development programs designed to spark curiosity and strong character in children.',
        'image'    => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=800&q=80',
        'items'    => array(
            array(
                'name'        => 'Samskrita Bala Kendra',
                'badge'       => 'Ages 5-12',
                'desc'        => 'Interactive, playful Sanskrit learning through joyful stories, rhymes, shlokas, conversational dialogues, and cultural value games.',
                'centers'     => 'Jayanagar, Basavanagudi, Malleswaram, Vijayanagar, Rajajinagar, Padmanabhanagar',
                'batches'     => 'Weekend: Saturday 4:00 PM – 5:30 PM | Sunday 9:00 AM – 10:30 AM',
                'duration'    => '90 Mins / Class | Annual Academic Cycle',
                'frequency'   => '2 Days / Week (Weekends)',
                'eligibility' => 'Children aged 5 to 12',
            ),
            array(
                'name'        => 'Bala Samskara Kendra',
                'badge'       => 'Weekly Mentorship',
                'desc'        => 'Character building, moral stories from Indian epics, civic duties, patriotic songs, shloka chanting, and cooperative traditional Indian sports.',
                'centers'     => 'Available at 18+ Residential Neighborhood Centers',
                'batches'     => 'Sunday Morning: 8:00 AM – 10:00 AM',
                'duration'    => '2 Hours / Session | Continuous Character Mentorship',
                'frequency'   => 'Weekly (Every Sunday)',
                'eligibility' => 'Children aged 6 to 14',
            ),
            array(
                'name'        => 'Personality Development & Public Speaking',
                'badge'       => 'Teens & Youth',
                'desc'        => 'Public speaking skills, emotional balance, critical thinking, leadership exercises, stage confidence, and interpersonal team workshops.',
                'centers'     => 'Jayanagar, Malleswaram, Koramangala, Indiranagar, Basavanagudi',
                'batches'     => 'Weekend: Saturday 3:30 PM – 5:30 PM | Vacation Batches',
                'duration'    => '8-Week Modular Workshop Series',
                'frequency'   => 'Weekly Sessions',
                'eligibility' => 'Teens & Youth aged 12 to 19',
            ),
            array(
                'name'        => 'Summer & Vacation Camps',
                'badge'       => 'Holiday Camps',
                'desc'        => 'Multi-activity vacation camps featuring arts, crafts, science experiments, yoga, Vedic mathematics, nature trails, and life skills.',
                'centers'     => 'All 23 Centers across Bengaluru',
                'batches'     => 'Holiday Seasons: Morning 9:00 AM – 1:00 PM (Daily)',
                'duration'    => '10 to 15 Days Immersive Vacation Camp',
                'frequency'   => 'Monday to Saturday during School Vacations',
                'eligibility' => 'Children aged 6 to 15',
            ),
        ),
    ),
    array(
        'slug'     => 'fitness-sports',
        'icon'     => '⌁',
        'title'    => 'Fitness & Sports',
        'tagline'  => 'Stamina, Strength & Sportsmanship',
        'text'     => 'Build physical strength, stamina, and confidence with modern sports facilities and expert fitness coaching.',
        'image'    => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800&q=80',
        'items'    => array(
            array(
                'name'        => 'Modern Gym & Strength Conditioning',
                'badge'       => 'Coached Fitness',
                'desc'        => 'Full-suite cardio, resistance, and functional training guided by certified trainers, with posture tracking and personal fitness roadmaps.',
                'centers'     => 'Marathahalli, Sahakarnagar, Kengeri, Vijayanagar, Yelahanka',
                'batches'     => 'Morning: 5:30 AM – 10:30 AM | Evening: 5:00 PM – 9:30 PM',
                'duration'    => 'Flexible Workout Slots (Monthly & Annual Plans)',
                'frequency'   => '6 Days / Week (Monday – Saturday)',
                'eligibility' => 'Ages 16+ (Cardio & Resistance Guidance)',
            ),
            array(
                'name'        => 'Swimming Pool & Professional Coaching',
                'badge'       => 'All Levels',
                'desc'        => 'Hygienic, regulated swimming pools with certified coaching for beginners, stroke perfection for intermediate swimmers, and dedicated lap lanes.',
                'centers'     => 'Marathahalli Sports Wing, Kengeri Campus',
                'batches'     => 'Morning: 6:00 AM – 9:00 AM | Evening: 4:00 PM – 7:00 PM',
                'duration'    => '45 Mins Coaching Slot | Monthly Batches',
                'frequency'   => '6 Days / Week (Dedicated Ladies & Kids Batches)',
                'eligibility' => 'Ages 5+ to Adults',
            ),
            array(
                'name'        => 'Table Tennis Academy',
                'badge'       => 'Indoor Sports',
                'desc'        => 'Tournament-grade indoor tables, grip and spin technique coaching, match strategy, and intra-center ranking tournaments for amateur and competitive players.',
                'centers'     => 'Malleswaram Complex, Marathahalli, Sahakarnagar, Jayanagar',
                'batches'     => 'Morning: 6:30 AM – 9:00 AM | Evening: 4:30 PM – 8:30 PM',
                'duration'    => '60 Mins Table Slot | Coaching Clinics Available',
                'frequency'   => 'Daily Slots & Weekend Leagues',
                'eligibility' => 'All Age Groups',
            ),
            array(
                'name'        => 'Chess Academy (Grandmaster Strategy)',
                'badge'       => 'Mind Sport',
                'desc'        => 'Strategic opening theory, tactical puzzle solving, endgame calculation, and tournament readiness taught by FIDE rated coaches.',
                'centers'     => 'Jayanagar, Malleswaram, Basavanagudi, Vijayanagar',
                'batches'     => 'Weekend: Saturday 4:00 PM – 6:00 PM, Sunday 9:30 AM – 11:30 AM',
                'duration'    => '2 Hours / Class | Beginner to Advanced Syllabus',
                'frequency'   => '2 Days / Week (Weekends)',
                'eligibility' => 'Ages 6+ to Adults',
            ),
        ),
    ),
    array(
        'slug'     => 'health-therapy',
        'icon'     => '✿',
        'title'    => 'Health & Therapy',
        'tagline'  => 'Natural Healing & Holistic Care',
        'text'     => 'Therapeutic programs and natural healing therapies restoring physical harmony, mental peace, and vital health.',
        'image'    => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=800&q=80',
        'items'    => array(
            array(
                'name'        => 'Holistic Psychological Counselling',
                'badge'       => 'Confidential',
                'desc'        => 'Confidential consultation, emotional stress alleviation, family counselling, and adolescent guidance guided by certified psychologists.',
                'centers'     => 'Jayanagar, Malleswaram, Basavanagudi, Vijayanagar',
                'batches'     => 'By Appointment: Monday – Saturday 10:00 AM – 6:00 PM',
                'duration'    => '45 to 60 Mins per Confidential Session',
                'frequency'   => 'Weekly or Bi-weekly Follow-ups',
                'eligibility' => 'Individuals, Youth, Couples & Families',
            ),
            array(
                'name'        => 'Acupressure & Colour Therapy',
                'badge'       => 'Natural Healing',
                'desc'        => 'Non-invasive, meridian-based natural therapies promoting internal organ equilibrium, migraine relief, and digestive rejuvenation.',
                'centers'     => 'Jayanagar, Basavanagudi, Malleswaram, Banashankari',
                'batches'     => 'Morning: 9:00 AM – 12:30 PM | Evening: 4:00 PM – 7:00 PM',
                'duration'    => '30 to 45 Mins / Treatment Session',
                'frequency'   => 'Course of 7 to 14 Therapy Sessions',
                'eligibility' => 'All ages seeking drugless holistic therapy',
            ),
            array(
                'name'        => 'Yoga Therapy & Naturopathy Desk',
                'badge'       => 'Clinical Care',
                'desc'        => 'Integrated lifestyle disease reversal protocols, mud packs, hydrotherapy advice, diet counselling, and targeted therapeutic yogic cleansing (Shatkriyas).',
                'centers'     => 'Jayanagar, Basavanagudi, Malleswaram, Banashankari, JP Nagar, Vijayanagar',
                'batches'     => 'Morning: 8:00 AM – 11:30 AM | Evening: 4:30 PM – 7:30 PM',
                'duration'    => '60 Mins / Consultation & Regimen',
                'frequency'   => 'Daily / Alternate Days (Mon – Sat)',
                'eligibility' => 'Patients with metabolic, spinal, or psychosomatic disorders',
            ),
            array(
                'name'        => 'Therapeutic Ayurvedic Body Massage',
                'badge'       => 'Restorative',
                'desc'        => 'Traditional restorative herbal oil massages (Abhyanga) improving blood circulation, relieving chronic muscular fatigue, and promoting deep sleep.',
                'centers'     => 'Jayanagar, Malleswaram, Basavanagudi Health Desks',
                'batches'     => 'By Prior Booking: Monday – Saturday 8:00 AM – 5:00 PM',
                'duration'    => '60 to 90 Mins / Authentic Abhyanga Session',
                'frequency'   => 'Weekly or Recommended Therapy Cycle',
                'eligibility' => 'Men & Women (Separate dedicated treatment suites)',
            ),
        ),
    ),
    array(
        'slug'     => 'knowledge-culture',
        'icon'     => '▤',
        'title'    => 'Knowledge & Culture',
        'tagline'  => 'Wisdom, Heritage & Lifelong Learning',
        'text'     => 'Inspiring programs celebrating timeless wisdom, regional languages, Indian philosophy, and cultural values.',
        'image'    => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=800&q=80',
        'items'    => array(
            array(
                'name'        => 'Kannada Coaching (Spoken & Written)',
                'badge'       => 'Language',
                'desc'        => 'Structured language learning from everyday conversational fluency to functional reading and classic Kannada literature appreciation.',
                'centers'     => 'Indiranagar, Koramangala, Whitefield, Bellandur, HSR Layout, Malleswaram',
                'batches'     => 'Weekend: Saturday 4:00 PM – 5:30 PM, Sunday 10:00 AM – 11:30 AM | Weekday Evenings',
                'duration'    => '3-Month Conversational & Reading Certification',
                'frequency'   => '2 Days / Week',
                'eligibility' => 'Non-Kannada speakers, New Residents & Professionals',
            ),
            array(
                'name'        => 'Vishwa Samskrama Cultural Classes',
                'badge'       => 'Civilizational Heritage',
                'desc'        => 'Inspiring discourses on Indian civilizational history, ethics, universal dharma, and global contributions of ancient Indian wisdom.',
                'centers'     => 'Basavanagudi, Malleswaram, Jayanagar, Rajajinagar',
                'batches'     => 'Weekend Evening: Saturday 6:00 PM – 7:30 PM',
                'duration'    => '90 Mins Lecture & Interactive Discussion',
                'frequency'   => 'Weekly Sessions',
                'eligibility' => 'Youth, Scholars & Cultural Seekers',
            ),
            array(
                'name'        => 'Bhagavadgita Study Circles',
                'badge'       => 'Wisdom Circle',
                'desc'        => 'Verse-by-verse chanting, Sanskrit grammatical meaning, philosophical inquiry, and practical life applications for peaceful, purposeful modern living.',
                'centers'     => 'Jayanagar, Basavanagudi, Malleswaram, Vijayanagar, Padmanabhanagar, Banashankari',
                'batches'     => 'Sunday Morning: 7:30 AM – 9:00 AM | Friday Evening: 6:30 PM – 7:30 PM',
                'duration'    => '75 Mins / Session | Continuous Chapter-by-Chapter Study',
                'frequency'   => 'Weekly Sessions',
                'eligibility' => 'Open to All Seekers',
            ),
            array(
                'name'        => 'Calligraphy & Vedic Arts',
                'badge'       => 'Artistry',
                'desc'        => 'Mindful handwritten script artistry, Devanagari lettering, sacred Yantra geometry, and traditional Indian motif illustrations.',
                'centers'     => 'Malleswaram, Basavanagudi, Jayanagar',
                'batches'     => 'Weekend: Saturday 3:00 PM – 5:00 PM',
                'duration'    => '2 Hours / Workshop | 8-Week Masterclass',
                'frequency'   => 'Weekly Sessions',
                'eligibility' => 'Ages 10+ to Adults',
            ),
        ),
    ),
);
?>

<main class="rs-activities-page">

    <section class="rs-activities-categories" id="categories">
        <div class="rs-container">
            <div class="rs-activities-heading">
                <p>FIND YOUR PRACTICE</p>
                <h2>Explore Our Activity Categories</h2>
            </div>
            <div class="rs-activities-grid">
                <?php foreach ( $activity_categories as $index => $category ) : ?>
                    <article class="rs-activity-card" id="<?php echo esc_attr( $category['slug'] ); ?>" data-index="<?php echo esc_attr( $index ); ?>">
                        <div class="rs-activity-card-media">
                            <img src="<?php echo esc_url( $category['image'] ); ?>" alt="<?php echo esc_attr( $category['title'] ); ?>" loading="lazy">
                            <div class="rs-activity-card-overlay"></div>
                            <span class="rs-activity-badge-icon" aria-hidden="true"><?php echo esc_html( $category['icon'] ); ?></span>
                            <span class="rs-activity-badge-count"><?php echo count( $category['items'] ); ?> Programs</span>
                        </div>
                        <div class="rs-activity-card-body">
                            <span class="rs-activity-card-tagline"><?php echo esc_html( $category['tagline'] ); ?></span>
                            <h3 class="rs-activity-card-title"><?php echo esc_html( $category['title'] ); ?></h3>
                            <p class="rs-activity-card-desc"><?php echo esc_html( $category['text'] ); ?></p>
                            <ul class="rs-activity-tags" aria-label="Highlighted programs">
                                <?php foreach ( $category['items'] as $item ) : ?>
                                    <li class="rs-activity-tag"><?php echo esc_html( $item['name'] ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="rs-card-btn rs-open-modal-btn" data-index="<?php echo esc_attr( $index ); ?>" aria-haspopup="dialog">
                                View Activities <span aria-hidden="true">→</span>
                            </button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="rs-activities-finder-section" id="contact">
        <div class="rs-container">
            <div class="rs-finder-banner">
                <div class="rs-finder-glow" aria-hidden="true"></div>
                <div class="rs-finder-left">
                    <div class="rs-finder-icon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <div class="rs-finder-text">
                        <div class="rs-finder-eyebrow">
                            <span class="rs-finder-dot"></span>
                            <span>FIND YOUR NEAREST PRACTICE</span>
                        </div>
                        <h2 class="rs-finder-title">Looking for a specific activity near you?</h2>
                        <p class="rs-finder-desc">Discover which programs, batches, and certified instructors are available at your nearest Rashtrotthana center across Bengaluru.</p>
                        <div class="rs-finder-perks">
                            <span class="rs-finder-perk">✓ 23+ Centers in Bengaluru</span>
                            <span class="rs-finder-perk">✓ Morning &amp; Evening Batches</span>
                            <span class="rs-finder-perk">✓ Certified Instructors</span>
                        </div>
                    </div>
                </div>
                <div class="rs-finder-actions">
                    <a href="<?php echo esc_url( home_url('/centers/') ); ?>" class="rs-finder-cta-btn">
                        <span>Find a Center Near You</span>
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14m-7-7 7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" class="rs-finder-secondary-link">
                        Have Questions? Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Popup Modal with Background Blur -->
<div id="rs-activity-modal" class="rs-act-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="rs-act-modal-title">
    <div class="rs-act-modal-backdrop" data-close-modal="true"></div>
    <div class="rs-act-modal-container">
        <div class="rs-act-modal-card">
            <button type="button" class="rs-act-modal-close" aria-label="Close activity details" data-close-modal="true">✕</button>
            <div class="rs-act-modal-header">
                <div class="rs-act-modal-meta">
                    <div class="rs-act-modal-icon" id="rs-modal-icon" aria-hidden="true">☯</div>
                    <span class="rs-act-modal-tagline" id="rs-modal-category">CATEGORY</span>
                </div>
                <h2 class="rs-act-modal-title" id="rs-act-modal-title">Category Title</h2>
                <p class="rs-act-modal-lead" id="rs-modal-lead">Category lead text</p>
            </div>
            <div class="rs-act-modal-divider" aria-hidden="true"></div>
            <div class="rs-act-modal-body">
                <div class="rs-act-section-heading">
                    <div>
                        <h3>Detailed Programs &amp; Class Schedules</h3>
                        <p class="rs-act-section-sub">Comprehensive details covering timings, weekly schedules, certified centers, and prerequisites.</p>
                    </div>
                </div>
                <div class="rs-act-subactivities-grid" id="rs-modal-programs">
                    <!-- Injected dynamically via JS with complete sub-activity details -->
                </div>
            </div>
            <div class="rs-act-modal-footer">
                <p class="rs-act-modal-footer-note">Personalized batch guidance &amp; consultations available at our center reception desks.</p>
                <div class="rs-act-modal-footer-actions">
                    <a href="<?php echo esc_url( home_url('/centers/') ); ?>" class="rs-act-modal-centers-link">
                        <span>View All 23 Centers ↗</span>
                    </a>
                    <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" class="rs-act-modal-cta-btn">
                        <span>Enquire / Register Now →</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script id="rs-activities-data" type="application/json">
<?php echo wp_json_encode( $activity_categories ); ?>
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var rawData = document.getElementById('rs-activities-data');
    var activitiesData = [];
    if (rawData) {
        try { activitiesData = JSON.parse(rawData.textContent); } catch (e) { console.error(e); }
    }

    var modal = document.getElementById('rs-activity-modal');
    var modalIcon = document.getElementById('rs-modal-icon');
    var modalCategory = document.getElementById('rs-modal-category');
    var modalTitle = document.getElementById('rs-act-modal-title');
    var modalLead = document.getElementById('rs-modal-lead');
    var modalPrograms = document.getElementById('rs-modal-programs');
    var lastFocusedElement = null;

    function openModal(index) {
        var category = activitiesData[index];
        if (!category || !modal) return;

        lastFocusedElement = document.activeElement;

        modalIcon.textContent = category.icon || '✿';
        modalCategory.textContent = category.tagline || 'ACTIVITY CATEGORY';
        modalTitle.textContent = category.title || '';
        modalLead.textContent = category.text || '';

        modalPrograms.innerHTML = '';
        if (category.items && category.items.length) {
            category.items.forEach(function (item) {
                var itemEl = document.createElement('article');
                itemEl.className = 'rs-act-subactivity-card';

                var enquireUrl = '<?php echo esc_url( home_url('/contact-us/') ); ?>?activity=' + encodeURIComponent(item.name);

                itemEl.innerHTML =
                    '<div class="rs-act-subact-header">' +
                        '<div class="rs-act-subact-title-wrap">' +
                            '<h4 class="rs-act-subact-title">' + escapeHtml(item.name) + '</h4>' +
                            (item.badge ? '<span class="rs-act-subact-badge">' + escapeHtml(item.badge) + '</span>' : '') +
                        '</div>' +
                        '<a href="' + enquireUrl + '" class="rs-act-subact-join-btn">Enquire →</a>' +
                    '</div>' +
                    '<p class="rs-act-subact-desc">' + escapeHtml(item.desc) + '</p>' +
                    '<div class="rs-act-subact-specs">' +
                        (item.centers ? 
                            '<div class="rs-act-spec-item rs-spec-full">' +
                                '<span class="rs-act-spec-icon" aria-hidden="true">' +
                                    '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/><circle cx="12" cy="10" r="3"/></svg>' +
                                '</span>' +
                                '<div class="rs-act-spec-content">' +
                                    '<strong>Available at Centers:</strong>' +
                                    '<span class="rs-spec-val-centers">' + escapeHtml(item.centers) + '</span>' +
                                '</div>' +
                            '</div>' : '') +
                        '<div class="rs-act-specs-subgrid">' +
                            (item.batches ? 
                                '<div class="rs-act-spec-item">' +
                                    '<span class="rs-act-spec-icon" aria-hidden="true">' +
                                        '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>' +
                                    '</span>' +
                                    '<div class="rs-act-spec-content">' +
                                        '<strong>Batches &amp; Timings:</strong>' +
                                        '<span>' + escapeHtml(item.batches) + '</span>' +
                                    '</div>' +
                                '</div>' : '') +
                            (item.frequency ? 
                                '<div class="rs-act-spec-item">' +
                                    '<span class="rs-act-spec-icon" aria-hidden="true">' +
                                        '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>' +
                                    '</span>' +
                                    '<div class="rs-act-spec-content">' +
                                        '<strong>Frequency:</strong>' +
                                        '<span>' + escapeHtml(item.frequency) + '</span>' +
                                    '</div>' +
                                '</div>' : '') +
                            (item.duration ? 
                                '<div class="rs-act-spec-item">' +
                                    '<span class="rs-act-spec-icon" aria-hidden="true">' +
                                        '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/></svg>' +
                                    '</span>' +
                                    '<div class="rs-act-spec-content">' +
                                        '<strong>Duration:</strong>' +
                                        '<span>' + escapeHtml(item.duration) + '</span>' +
                                    '</div>' +
                                '</div>' : '') +
                            (item.eligibility ? 
                                '<div class="rs-act-spec-item">' +
                                    '<span class="rs-act-spec-icon" aria-hidden="true">' +
                                        '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>' +
                                    '</span>' +
                                    '<div class="rs-act-spec-content">' +
                                        '<strong>Eligibility / Focus:</strong>' +
                                        '<span>' + escapeHtml(item.eligibility) + '</span>' +
                                    '</div>' +
                                '</div>' : '') +
                        '</div>' +
                    '</div>';

                modalPrograms.appendChild(itemEl);
            });
        }

        modal.classList.add('is-active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('rs-modal-open');

        var closeBtn = modal.querySelector('.rs-act-modal-close');
        if (closeBtn) closeBtn.focus();
    }

    function closeModal() {
        if (!modal) return;
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('rs-modal-open');
        if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
            lastFocusedElement.focus();
        }
    }

    function escapeHtml(str) {
        if (!str) return '';
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Open modal on View Activities button click
    document.querySelectorAll('.rs-open-modal-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var idx = parseInt(btn.getAttribute('data-index'), 10);
            openModal(idx);
        });
    });

    // Close modal on click of backdrop or close buttons
    document.querySelectorAll('[data-close-modal="true"]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            closeModal();
        });
    });

    // Keyboard Escape to close modal
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal && modal.classList.contains('is-active')) {
            closeModal();
        }
    });

    // 3D Perspective Tilt on pointer fine
    if (window.matchMedia('(pointer: fine)').matches) {
        var cards = document.querySelectorAll('.rs-activity-card');
        cards.forEach(function (card) {
            card.addEventListener('pointermove', function (e) {
                var bounds = card.getBoundingClientRect();
                var horizontal = (e.clientX - bounds.left) / bounds.width - 0.5;
                var vertical = (e.clientY - bounds.top) / bounds.height - 0.5;
                card.style.setProperty('--card-rotate-x', (vertical * -8).toFixed(2) + 'deg');
                card.style.setProperty('--card-rotate-y', (horizontal * 10).toFixed(2) + 'deg');
            }, { passive: true });

            card.addEventListener('pointerleave', function () {
                card.style.setProperty('--card-rotate-x', '0deg');
                card.style.setProperty('--card-rotate-y', '0deg');
            });
        });
    }
});
</script>

<?php get_footer(); ?>
