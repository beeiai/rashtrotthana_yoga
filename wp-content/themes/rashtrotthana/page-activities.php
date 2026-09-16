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
            array( 'name' => 'Yoga for Beginners', 'desc' => 'Foundational asanas, mindful breathing techniques (pranayama), and relaxation for newcomers.', 'badge' => 'Beginner' ),
            array( 'name' => 'Yoga for All', 'desc' => 'Daily structured morning and evening batches for stamina, flexibility, and sustained daily energy.', 'badge' => 'Daily Batches' ),
            array( 'name' => 'Yoga Therapy Sessions', 'desc' => 'Customized therapeutic yoga addressing chronic back pain, diabetes, hypertension, and stress.', 'badge' => 'Therapeutic' ),
            array( 'name' => 'Prenatal Yoga', 'desc' => 'Safe, nurturing practices guided by certified instructors to support expectant mothers.', 'badge' => 'Specialized' ),
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
            array( 'name' => 'Carnatic Music', 'desc' => 'Classical vocal and swara practice rooted in sacred ragas, talas, and traditional compositions.', 'badge' => 'Classical Vocal' ),
            array( 'name' => 'Keyboard Lessons', 'desc' => 'Structured training covering foundational notations, western chords, and Indian melodic pieces.', 'badge' => 'Instrumental' ),
            array( 'name' => 'Light Music (Sugama Sangeetha)', 'desc' => 'Soulful rendition of Bhavageethe, devotionals, and cultural melodies with lyrical expression.', 'badge' => 'Vocal' ),
            array( 'name' => 'Flute (Bansuri)', 'desc' => 'Bamboo flute lessons from fundamental breath control and finger placement to classical ragas.', 'badge' => 'Instrumental' ),
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
            array( 'name' => 'Bharatanatyam', 'desc' => 'Sacred South Indian classical dance cultivating mudras, rhythm, adavus, and abhinaya.', 'badge' => 'Classical' ),
            array( 'name' => 'Kathak', 'desc' => 'North Indian classical dance celebrated for intricate footwork, swift chakkars, and expressions.', 'badge' => 'Classical' ),
            array( 'name' => 'Folk Dance', 'desc' => 'Vibrant regional dances celebrating Indian harvest, seasons, and cultural festivities.', 'badge' => 'Folk Heritage' ),
            array( 'name' => 'Contemporary Dance', 'desc' => 'Expressive modern movement combining rhythm, bodily agility, and creative storytelling.', 'badge' => 'Modern' ),
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
            array( 'name' => 'Karate', 'desc' => 'Speed, power, self-defence katas, and belt grading under certified black belt instructors.', 'badge' => 'All Belts' ),
            array( 'name' => 'Taekwondo', 'desc' => 'Dynamic kicks, flexibility, mental fortitude, and Olympic-style sparring drills.', 'badge' => 'Fitness' ),
            array( 'name' => 'Kalaripayattu', 'desc' => 'Ancient Indian martial art emphasizing animal stances, fluid movement, and body conditioning.', 'badge' => 'Traditional' ),
            array( 'name' => 'Self Defence Workshops', 'desc' => 'Practical situational awareness, evasion tactics, and reflexive defence for women and youth.', 'badge' => 'Workshops' ),
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
            array( 'name' => 'Samskrita Bala Kendra', 'desc' => 'Interactive Sanskrit learning through joyful stories, rhymes, shlokas, and cultural activities.', 'badge' => 'Ages 5-12' ),
            array( 'name' => 'Bala Samskara Kendra', 'desc' => 'Character building, moral stories, Indian heritage values, and cooperative games.', 'badge' => 'Weekly Batches' ),
            array( 'name' => 'Personality Development', 'desc' => 'Public speaking, emotional resilience, teamwork, and confidence workshops for youth.', 'badge' => 'Teens & Youth' ),
            array( 'name' => 'Summer & Holiday Camps', 'desc' => 'Engaging vacation camps featuring arts, crafts, science experiments, yoga, and nature walks.', 'badge' => 'Camps' ),
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
            array( 'name' => 'Modern Gym & Strength', 'desc' => 'Full-suite cardio and resistance training equipment guided by certified fitness instructors.', 'badge' => 'Coached' ),
            array( 'name' => 'Swimming Pool & Coaching', 'desc' => 'Hygienic, regulated swimming pools with certified coaching for beginners and lap swimmers.', 'badge' => 'All Levels' ),
            array( 'name' => 'Table Tennis', 'desc' => 'Professional indoor tables, coaching clinics, and intra-center tournaments for all ages.', 'badge' => 'Indoor Sports' ),
            array( 'name' => 'Chess Academy', 'desc' => 'Strategic calculation, openings theory, and tournament preparation led by rated coaches.', 'badge' => 'Mind Sport' ),
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
            array( 'name' => 'Counselling Centre', 'desc' => 'Confidential psychological consultation, stress alleviation, and family wellness support.', 'badge' => 'Confidential' ),
            array( 'name' => 'Acupressure & Colour Therapy', 'desc' => 'Non-invasive, meridian-based natural therapies promoting organ balance and relief.', 'badge' => 'Natural' ),
            array( 'name' => 'Yoga Therapy & Naturopathy', 'desc' => 'Integrated lifestyle modification, diet counselling, and targeted yogic cleansing.', 'badge' => 'Therapeutic' ),
            array( 'name' => 'Therapeutic Body Massage', 'desc' => 'Traditional restorative herbal oil massages improving circulation and muscle recovery.', 'badge' => 'Restorative' ),
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
            array( 'name' => 'Kannada Coaching', 'desc' => 'Structured language learning from spoken conversational fluency to reading and literature.', 'badge' => 'Language' ),
            array( 'name' => 'Vishwa Samskrama Classes', 'desc' => 'Thought-provoking discourses on Indian civilizational history, ethics, and world thought.', 'badge' => 'Heritage' ),
            array( 'name' => 'Bhagavadgita Study Circles', 'desc' => 'Verse-by-verse chanting, philosophical inquiry, and practical life applications for modern living.', 'badge' => 'Wisdom' ),
            array( 'name' => 'Calligraphy & Vedic Arts', 'desc' => 'Mindful handwritten script artistry, Devanagari lettering, and Indian geometric motifs.', 'badge' => 'Artistry' ),
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
                    <h3>Available Programs &amp; Classes</h3>
                </div>
                <div class="rs-act-programs-grid" id="rs-modal-programs">
                    <!-- Injected dynamically via JS -->
                </div>
                <div class="rs-act-centers-banner">
                    <div class="rs-act-centers-info">
                        <span class="rs-act-centers-icon" aria-hidden="true">⌖</span>
                        <div class="rs-act-centers-text">
                            <strong>Offered Across Rashtrotthana Centers</strong>
                            <p>Available at 23+ centers across Bengaluru with flexible morning &amp; evening batches.</p>
                        </div>
                    </div>
                    <a href="<?php echo esc_url( home_url('/centers/') ); ?>" class="rs-act-centers-btn">View Centers →</a>
                </div>
            </div>
            <div class="rs-act-modal-footer">
                <p class="rs-act-modal-footer-note">Personalized guidance by certified Rashtrotthana instructors.</p>
                <div class="rs-act-modal-footer-actions">
                    <button type="button" class="rs-act-modal-close-btn" data-close-modal="true">Close</button>
                    <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" class="rs-act-modal-cta-btn">Enquire / Register Now →</a>
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
                var itemEl = document.createElement('div');
                itemEl.className = 'rs-act-program-item';
                itemEl.innerHTML =
                    '<div class="rs-act-program-header">' +
                        '<h4 class="rs-act-program-title">' + escapeHtml(item.name) + '</h4>' +
                        (item.badge ? '<span class="rs-act-program-badge">' + escapeHtml(item.badge) + '</span>' : '') +
                    '</div>' +
                    '<p class="rs-act-program-desc">' + escapeHtml(item.desc) + '</p>';
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
