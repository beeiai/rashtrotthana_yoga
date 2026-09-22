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
$activity_fallbacks  = $_home['activity_fallbacks'];
$event_fallbacks     = $_home['event_fallbacks'];

// WordPress CPT queries (return empty until CPTs are populated)
$activities = rashtrotthana_home_collection( array( 'activity', 'activities' ) );
$events     = rashtrotthana_home_collection( array( 'event', 'events' ), 4 );
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
            <?php if ( $activities ) : foreach ( $activities as $post ) : setup_postdata( $post ); ?>
                <article class="rs-activity-card"><a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); } ?><h3><?php the_title(); ?></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 14 ) ); ?></p></a></article>
            <?php endforeach; wp_reset_postdata(); else : foreach ( $activity_fallbacks as $item ) : ?>
                <article class="rs-activity-card"><img src="<?php echo esc_url( $item[2] ); ?>" alt="" loading="lazy"><h3><?php echo esc_html( $item[0] ); ?></h3><p><?php echo esc_html( $item[1] ); ?></p></article>
            <?php endforeach; endif; ?>
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
                <p class="rs-centers-subheading">Our 23 centers bring wellness, learning and community closer to you.</p>
            </div>
            <div class="rs-centers-action-col">
                <form class="rs-center-search-box" role="search">
                    <label class="screen-reader-text" for="rs-center-search-input">Search centers</label>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.35-4.35"/></svg>
                    <input id="rs-center-search-input" type="search" placeholder="Search by area or center..." autocomplete="off">
                </form>
                <a class="rs-center-locate-btn" href="<?php echo esc_url( home_url('/centers/') ); ?>">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5.3 7 13 7 13s7-7.7 7-13a7 7 0 0 0-7-7Zm0 10.1A3.1 3.1 0 1 1 12 5.9a3.1 3.1 0 0 1 0 6.2Z"/></svg>
                    <span>Locate Centers Near You</span>
                </a>
            </div>
        </div>

        <p class="rs-center-search-status" aria-live="polite"></p>

        <!-- 4-Card Horizontal Grid -->
        <div class="rs-center-cards">
            <?php foreach ( $rs_home_cards as $center ) : ?>
                <article class="rs-center-card">
                    <div class="rs-center-card-img-wrap">
                        <img src="<?php echo esc_url( $center['image'] ); ?>" alt="<?php echo esc_attr( $center['name'] ); ?>" loading="lazy">
                    </div>
                    <div class="rs-center-card-body">
                        <h3><?php echo esc_html( $center['name'] ); ?></h3>
                        <p class="rs-center-location"><?php echo esc_html( $center['city'] ); ?></p>
                        <a class="rs-center-button" href="<?php echo esc_url( home_url('/centers/') ); ?>">
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

<section class="rs-content-section">
    <div class="rs-container">
        <div class="rs-section-row"><h2>Upcoming Events</h2><a class="rs-outline-link" href="<?php echo esc_url( home_url('/events/') ); ?>">View All Events</a></div>
        <div class="rs-card-grid rs-event-grid">
            <?php if ( $events ) : foreach ( $events as $post ) : setup_postdata( $post ); ?>
                <article class="rs-event-card"><a href="<?php the_permalink(); ?>"><div class="rs-event-image"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); } ?><span><b><?php echo esc_html( get_the_date( 'd' ) ); ?></b><?php echo esc_html( get_the_date( 'M' ) ); ?></span></div><h3><?php the_title(); ?></h3><p>View event details</p><span class="rs-register-button">Register Now</span></a></article>
            <?php endforeach; wp_reset_postdata(); else : foreach ( $event_fallbacks as $event ) : ?>
                <article class="rs-event-card"><div class="rs-event-image"><img src="<?php echo esc_url( $event['image'] ); ?>" alt="" loading="lazy"><span><b><?php echo esc_html( $event['day'] ); ?></b><?php echo esc_html( $event['month'] ); ?></span></div><h3><?php echo esc_html( $event['title'] ); ?></h3><p><?php echo esc_html( $event['time'] . ' | ' . $event['venue'] ); ?></p><a class="rs-register-button" href="#">Register Now</a></article>
            <?php endforeach; endif; ?>
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
    <div class="rs-container"><div class="rs-section-row"><h2>Moments of Inspiration</h2><a class="rs-outline-link" href="<?php echo esc_url( home_url('/gallery/') ); ?>">View Gallery</a></div><div class="rs-gallery-grid"><?php foreach ( $activity_fallbacks as $item ) : ?><img src="<?php echo esc_url( $item[2] ); ?>" alt="" loading="lazy"><?php endforeach; ?></div></div>
</section>

