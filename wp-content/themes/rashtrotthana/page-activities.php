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
/**
 * Activities data — loaded from data/activities-data.php.
 * To swap in DB data, update rs_get_activity_categories() in inc/data-helpers.php.
 */
$activity_categories = rs_get_activity_categories();
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
