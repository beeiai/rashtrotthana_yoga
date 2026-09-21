<?php
/**
 * Data Helper Functions — Rashtrotthana Yoga
 *
 * TEAMMATE GUIDE:
 * These functions are the SINGLE INTEGRATION POINT for your backend work.
 * Currently they load data from the data/ folder (hardcoded fallbacks).
 *
 * When a CPT + data is ready in WordPress DB:
 * 1. Comment out the require_once line.
 * 2. Replace the return statement with a get_posts() / WP_Query call.
 * 3. Map CPT fields → the array keys the templates expect (documented per function).
 * 4. NOTHING ELSE needs to change — HTML, CSS, JS are untouched.
 */

// ── Centers ───────────────────────────────────────────────────────────────────

/**
 * Get all center records.
 *
 * Template expects each item to have:
 *   id, name, area, zone, zone_slug, lat, lng, phone, hours, timing,
 *   timing_label, programs[], activities[], address, email, image, features[],
 *   activities_detail[], events[]
 *
 * @param  string $zone_slug  Optional filter: 'north'|'south'|'east'|'west'|'central'.
 * @return array
 */
function rs_get_centers( $zone_slug = '' ) {
    require_once get_template_directory() . '/data/centers-data.php';
    if ( $zone_slug ) {
        return array_values( array_filter( $centers, function( $c ) use ( $zone_slug ) {
            return isset( $c['zone_slug'] ) && $c['zone_slug'] === $zone_slug;
        } ) );
    }
    return $centers;
    /*
     * ── REPLACE ABOVE WITH DB QUERY WHEN READY ───────────────────────────────
     * $args = array( 'post_type' => 'rs_center', 'posts_per_page' => -1, ... );
     * if ( $zone_slug ) {
     *     $args['meta_query'] = array( array( 'key' => '_rs_zone_slug', 'value' => $zone_slug ) );
     * }
     * $posts = get_posts( $args );
     * return array_map( 'rs_center_post_to_array', $posts );
     * ─────────────────────────────────────────────────────────────────────────
     */
}

/**
 * Get flagship / featured centers for the contact page map.
 *
 * Template expects each item to have:
 *   id, name, area, address, phone, hours, email, lat, lng, is_hq, image
 *
 * @return array
 */
function rs_get_flagship_centers() {
    // Use require (not require_once) so the file executes in this function's scope.
    require get_template_directory() . '/data/contact-data.php';
    return $flagship_centers;
}

/**
 * Get FAQ items for the contact page.
 *
 * Template expects each item to have: q, a
 *
 * @return array
 */
function rs_get_faqs() {
    // Use require (not require_once) so the file executes fresh in this scope.
    require get_template_directory() . '/data/contact-data.php';
    return isset( $faqs_dataset ) ? $faqs_dataset : array();
}

// ── Activities ────────────────────────────────────────────────────────────────

/**
 * Get all activity categories with their sub-activity items.
 *
 * Template expects each item to have:
 *   slug, icon, title, tagline, text, image,
 *   items[] => { name, badge, desc, centers, batches, duration, frequency, eligibility }
 *
 * @return array
 */
function rs_get_activity_categories() {
    require_once get_template_directory() . '/data/activities-data.php';
    return $activity_categories;
    /*
     * ── REPLACE ABOVE WITH DB QUERY WHEN READY ───────────────────────────────
     * $posts = get_posts( array( 'post_type' => 'rs_activity', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
     * return array_map( 'rs_activity_post_to_array', $posts );
     * ─────────────────────────────────────────────────────────────────────────
     */
}

// ── Events ────────────────────────────────────────────────────────────────────

/**
 * Get all events.
 *
 * Template expects each item to have:
 *   id, day, month, year, date_iso, timeframe, title, venue, time,
 *   category, category_slug, mode, type, image, desc, fee
 *
 * @param  string $type  Optional: 'upcoming'|'past'.
 * @return array
 */
function rs_get_events( $type = '' ) {
    // Use require so the file re-executes in this function's local scope.
    require get_template_directory() . '/data/events-data.php';
    if ( $type ) {
        return array_values( array_filter( $events_dataset, function( $e ) use ( $type ) {
            return isset( $e['type'] ) && $e['type'] === $type;
        } ) );
    }
    return $events_dataset;
}

/**
 * Get all news articles.
 *
 * Template expects each item to have:
 *   id, title, date, category, category_slug, read_time, image, excerpt, full_text
 *
 * @return array
 */
function rs_get_news() {
    // Use require so the file re-executes fresh in this scope.
    require get_template_directory() . '/data/events-data.php';
    return isset( $news_dataset ) ? $news_dataset : array();
}

// ── Gallery ───────────────────────────────────────────────────────────────────

/**
 * Get all gallery albums.
 *
 * Template expects each item to have:
 *   id, title, category, category_slug, date, venue, desc, cover_image,
 *   photos[] => { title, url, caption },
 *   videos[] => { title, subtitle, duration, thumb, embed_url }
 *
 * @return array
 */
function rs_get_gallery_albums() {
    require_once get_template_directory() . '/data/gallery-data.php';
    return $gallery_events;
}

// ── Homepage ──────────────────────────────────────────────────────────────────

/**
 * Get homepage data bundle.
 * Returns: center_cards, stats, values, founder, activity_fallbacks, event_fallbacks
 *
 * @return array
 */
function rs_get_homepage_data() {
    require_once get_template_directory() . '/data/homepage-data.php';
    return array(
        'center_cards'       => $rs_home_center_cards,
        'stats'              => $rs_home_stats,
        'values'             => $rs_home_values,
        'founder'            => $rs_home_founder,
        'activity_fallbacks' => $rs_activity_fallbacks,
        'event_fallbacks'    => $rs_event_fallbacks,
    );
}
