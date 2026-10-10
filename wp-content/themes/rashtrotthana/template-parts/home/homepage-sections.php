<?php
/**
 * Homepage sections — Rashtrotthana Yoga
 *
 * Data is loaded via rs_get_homepage_data() from inc/data-helpers.php.
 * To replace with real DB content, update the helper function — this file stays unchanged.
 */

// ── Load homepage data bundle ─────────────────────────────────────────────────
$_home               = rs_get_homepage_data();
$rs_values           = $_home['values'];
$rs_stats            = $_home['stats'];
$rs_home_cards       = $_home['center_cards'];
$rs_founder          = $_home['founder'];
$rs_home_activities  = ! empty( $_home['activities'] ) ? $_home['activities'] : array();
$activity_fallbacks  = $_home['activity_fallbacks'];
$event_fallbacks     = $_home['event_fallbacks'];

// Live events fetched directly from DB via rs_get_events()
$home_events = function_exists( 'rs_get_events' ) ? rs_get_events() : array();
?>

<section class="rs-values rs-section">
    <div class="rs-container">
        <div class="rs-heading"><h2>Our Vision, Mission &amp; Values</h2></div>
        <div class="rs-value-grid">
            <?php foreach ( $rs_values as $item ) : ?>
                <article class="rs-value-card"><div><h3><?php echo esc_html( $item['title'] ); ?></h3><p><?php echo esc_html( $item['text'] ); ?></p></div></article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="rs-content-section">
    <div class="rs-container">
        <div class="rs-section-row"><h2>Our Activities</h2><a class="rs-outline-link" href="<?php echo esc_url( home_url('/activities/') ); ?>">View All Activities</a></div>
        <div class="rs-card-grid rs-activity-grid">
            <?php foreach ( $rs_home_activities as $act ) : ?>
                <article class="rs-activity-card">
                    <a href="<?php echo esc_url( $act['link'] ); ?>">
                        <div class="rs-activity-card-media">
                            <img src="<?php echo esc_url( $act['image'] ); ?>" alt="<?php echo esc_attr( $act['name'] ); ?>" loading="lazy">
                        </div>
                        <div class="rs-activity-card-body">
                            <h3><?php echo esc_html( $act['name'] ); ?></h3>
                            <p><?php echo esc_html( $act['desc'] ); ?></p>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="rs-stats" aria-label="Rashtrotthana impact">
    <div class="rs-container rs-stat-grid">
        <div class="rs-stat-heading"><h2>Our Impact in Numbers</h2><p>Creating a legacy of wellness, wisdom and service since 1972</p></div>
        <?php foreach ( $rs_stats as $stat ) : ?>
            <div><strong class="rs-stat-value" data-count="<?php echo esc_attr( $stat['value'] ); ?>" data-suffix="<?php echo esc_attr( $stat['suffix'] ); ?>">0<?php echo esc_html( $stat['suffix'] ); ?></strong><span><?php echo esc_html( $stat['label'] ); ?></span></div>
        <?php endforeach; ?>
    </div>
</section>

<section class="rs-centers rs-section" id="centers-section">
    <div class="rs-container rs-center-finder">
        <!-- Top Header Bar: Title on Left, Search & Locate on Right -->
        <div class="rs-centers-top-bar">
            <div class="rs-centers-title-col">
                <span class="rs-kicker">OUR PRESENCE</span>
                <h2 class="rs-centers-heading">Find a Center</h2>
                <p class="rs-centers-subheading">Our <?php echo count(rs_get_centers()); ?> centers bring wellness, learning and community closer to you.</p>
            </div>
            <div class="rs-centers-action-col">
                <form class="rs-center-search-box" role="search">
                    <label class="screen-reader-text" for="rs-center-search-input">Search centers</label>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.35-4.35"/></svg>
                    <input id="rs-center-search-input" type="search" placeholder="Search by area or center..." autocomplete="off">
                </form>
            </div>
        </div>

        <p class="rs-center-search-status" aria-live="polite"></p>

        <!-- 4-Card Horizontal Grid -->
        <div class="rs-center-cards">
            <?php foreach ( $rs_home_cards as $center ) : 
                $is_def = ! empty( $center['is_default'] );
            ?>
                <article class="rs-center-card"
                         data-name="<?php echo esc_attr( strtolower( $center['name'] ) ); ?>"
                         data-slug="<?php echo esc_attr( $center['slug'] ); ?>"
                         data-default="<?php echo $is_def ? 'true' : 'false'; ?>"
                         <?php echo $is_def ? '' : 'hidden'; ?>>
                    <div class="rs-center-card-img-wrap">
                        <img src="<?php echo esc_url( $center['image'] ); ?>" alt="<?php echo esc_attr( $center['name'] ); ?>" loading="lazy">
                    </div>
                    <div class="rs-center-card-body">
                        <h3><?php echo esc_html( $center['name'] ); ?></h3>
                        <a class="rs-center-button" href="<?php echo esc_url( home_url( '/centers/#' . $center['slug'] ) ); ?>">
                            <span>View Details</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <p class="rs-center-no-results" aria-live="polite" hidden>No centers match your search.</p>
    </div>
</section>

<section class="rs-content-section rs-home-events-section">
    <div class="rs-container">
        <div class="rs-section-row"><h2>Upcoming Events</h2><a class="rs-outline-link" href="<?php echo esc_url( home_url('/events/') ); ?>">View All Events</a></div>
        <div class="rs-card-grid rs-event-grid">
            <?php if ( ! empty( $home_events ) ) : foreach ( array_slice( $home_events, 0, 6 ) as $event ) : ?>
                <article class="rs-event-item-card"
                         id="home-event-<?php echo esc_attr( $event['id'] ); ?>"
                         data-type="<?php echo esc_attr( $event['type'] ); ?>"
                         data-category="<?php echo esc_attr( $event['category_slug'] ); ?>"
                         data-title="<?php echo esc_attr( $event['title'] ); ?>"
                         data-venue="<?php echo esc_attr( $event['venue'] ); ?>">
                    
                    <div class="rs-event-media">
                        <img src="<?php echo esc_url( $event['image'] ); ?>" alt="<?php echo esc_attr( $event['title'] ); ?>" loading="lazy">
                        <div class="rs-event-date-badge">
                            <strong><?php echo esc_html( $event['day'] ); ?></strong>
                            <span><?php echo esc_html( $event['month'] ); ?></span>
                        </div>
                        <span class="rs-event-category-pill"><?php echo esc_html( $event['category'] ); ?></span>
                    </div>

                    <div class="rs-event-body">
                        <div class="rs-event-meta-list">
                            <div class="rs-event-meta-item">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span><?php echo esc_html( $event['venue'] ); ?></span>
                            </div>
                            <div class="rs-event-meta-item">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span><?php echo esc_html( $event['time'] ); ?></span>
                            </div>
                        </div>

                        <h3 class="rs-event-title"><?php echo esc_html( $event['title'] ); ?></h3>
                        <p class="rs-event-desc"><?php echo esc_html( $event['desc'] ); ?></p>

                        <div class="rs-event-footer">
                            <span class="rs-event-mode-badge" title="<?php echo esc_attr( $event['mode'] ); ?>"><?php echo esc_html( $event['mode'] ); ?></span>
                            <a href="<?php echo esc_url( home_url( '/events/#' . $event['id'] ) ); ?>" class="rs-register-btn">
                                <span>Register Now</span> <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; else : ?>
                <div class="rs-events-empty-state" style="grid-column: 1 / -1; width: 100%; text-align: center; padding: 2.75rem 1.5rem; background: #fff8f5; border-radius: 16px; border: 1px dashed rgba(143, 23, 29, 0.28);">
                    <p style="margin: 0; font-size: 1.15rem; color: #5d1116; font-weight: 600;">There are no events available right now.</p>
                    <p style="margin: 0.5rem 0 0; font-size: 0.92rem; color: #7a5c58;">Please check back soon for upcoming workshops, retreats, and celebrations.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="rs-founder-section rs-section" id="founder-section">
    <div class="rs-container">
        <div class="rs-founder-grid">
            <div class="rs-founder-portrait-wrap">
                <img src="<?php echo esc_url( $rs_founder['image'] ); ?>" alt="<?php echo esc_attr( $rs_founder['image_alt'] ); ?>" loading="lazy">
            </div>

            <div class="rs-founder-content">
                <div class="rs-about-section-header">
                    <h2><?php echo esc_html( $rs_founder['title'] ); ?> <em>Founder</em></h2>
                    <p class="rs-about-section-desc"><?php echo esc_html( $rs_founder['subtitle'] ); ?></p>
                </div>

                <?php foreach ( $rs_founder['paragraphs'] as $para ) : ?>
                    <p><?php echo wp_kses_post( $para ); ?></p>
                <?php endforeach; ?>

                <!-- Quote Card -->
                <div class="rs-founder-quote-card">
                    <div class="rs-quote-mark" aria-hidden="true">&ldquo;</div>
                    <div class="rs-quote-body">
                        <div class="rs-quote-text"><?php echo esc_html( $rs_founder['quote'] ); ?></div>
                        <span class="rs-quote-author">&ndash; <?php echo esc_html( $rs_founder['quote_author'] ); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="rs-content-section rs-gallery">
    <div class="rs-container">
        <div class="rs-section-row">
            <h2>Moments of Inspiration</h2>
            <a class="rs-outline-link" href="<?php echo esc_url( home_url('/gallery/') ); ?>">View Gallery</a>
        </div>
        <div class="rs-gallery-grid">
            <?php 
            $gallery_media = function_exists( 'rs_get_home_gallery_images' ) ? rs_get_home_gallery_images( 12 ) : array();
            if ( ! empty( $gallery_media ) ) :
                foreach ( $gallery_media as $item ) : ?>
                    <a class="rs-gallery-item" href="<?php echo esc_url( home_url('/gallery/') ); ?>" title="<?php echo esc_attr( $item['title'] ); ?>">
                        <img src="<?php echo esc_url( $item['url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy">
                    </a>
                <?php endforeach;
            else : ?>
                <div class="rs-gallery-empty-state" style="grid-column: 1 / -1; width: 100%; text-align: center; padding: 2.5rem 1.5rem; background: #fff8f5; border-radius: 16px; border: 1px dashed rgba(143, 23, 29, 0.28);">
                    <p style="margin: 0; font-size: 1.05rem; color: #5d1116; font-weight: 600;">Gallery photos will appear here once uploaded to the media library.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var body = document.body;
    
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
});
</script>
