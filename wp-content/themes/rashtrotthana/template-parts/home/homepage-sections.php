<?php
/**
 * Homepage sections. Content types are optional: fallback cards keep the
 * design usable before integration.
 */
$activity_fallbacks = array(
    array( 'Yoga & Wellness', 'Yoga for all age groups, beginners, advanced and therapeutic programs.', 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=700&q=80' ),
    array( 'Education', 'Quality education and value-based learning for a better tomorrow.', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=700&q=80' ),
    array( 'Arts & Culture', 'Nurturing talent through music, dance and traditional arts.', 'https://images.unsplash.com/photo-1525201548942-d8732f6617a0?auto=format&fit=crop&w=700&q=80' ),
    array( 'Community Service', 'Serving society through social and humanitarian initiatives.', 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?auto=format&fit=crop&w=700&q=80' ),
    array( 'Sports & Fitness', 'Karate, fitness programs and physical development activities.', 'https://images.unsplash.com/photo-1552072092-7f9b8d63efcb?auto=format&fit=crop&w=700&q=80' ),
);
$event_fallbacks = array(
    array( '25', 'MAY', 'International Yoga Day', '7:00 AM Onwards', 'All Centers', 'https://images.unsplash.com/photo-1545389336-cf090694435e?auto=format&fit=crop&w=800&q=80' ),
    array( '12', 'JUN', 'Summer Yoga Camp for Kids', '9:00 AM - 1:00 PM', 'City Centers', 'https://images.unsplash.com/photo-1516627145497-ae6968895b74?auto=format&fit=crop&w=800&q=80' ),
    array( '05', 'JUL', 'Yoga for Wellness Workshop', '6:30 PM Onwards', 'Main Center', 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=800&q=80' ),
    array( '18', 'AUG', 'Cultural Evening', '5:00 PM Onwards', 'Auditorium', 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=800&q=80' ),
);
$activities = rashtrotthana_home_collection( array( 'activity', 'activities' ) );
$events     = rashtrotthana_home_collection( array( 'event', 'events' ), 4 );
$centers    = rashtrotthana_home_collection( array( 'center', 'centers' ), 3 );
?>

<section class="rs-values rs-section">
    <div class="rs-container">
        <div class="rs-heading"><h2>Our Vision, Mission &amp; Values</h2></div>
        <div class="rs-value-grid">
            <?php foreach ( array(
                array( 'Our Vision', 'To build a healthy, harmonious and sustainable society rooted in Indian values.' ),
                array( 'Our Mission', 'To empower individuals through Yoga, Education, Culture and Service for personal growth and social transformation.' ),
                array( 'Our Values', 'Integrity, compassion, discipline, selfless service and excellence in everything we do.' ),
                array( 'Our Impact', 'Building stronger communities through meaningful service and lifelong learning.' ),
            ) as $item ) : ?>
                <article class="rs-value-card"><div><h3><?php echo esc_html( $item[0] ); ?></h3><p><?php echo esc_html( $item[1] ); ?></p></div></article>
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
        <?php foreach ( array( array( '1972', 'Since' ), array( '35+', 'Activities' ), array( '18', 'Projects' ), array( '23+', 'Centers' ), array( '1000+', 'Lives Impacted' ) ) as $stat ) : ?>
            <div><strong><?php echo esc_html( $stat[0] ); ?></strong><span><?php echo esc_html( $stat[1] ); ?></span></div>
        <?php endforeach; ?>
    </div>
</section>

<section class="rs-centers rs-section">
    <div class="rs-container">
        <div class="rs-center-finder">
            <div class="rs-center-intro"><span class="rs-kicker">OUR PRESENCE</span><h2>Find a Center</h2><a class="rs-center-button" href="<?php echo esc_url( home_url('/centers/') ); ?>">View All Centers</a></div>
            <div class="rs-center-cards">
            <?php if ( $centers ) : foreach ( $centers as $post ) : setup_postdata( $post ); ?>
                <article class="rs-center-card"><a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); } ?><div class="rs-center-card-body"><h3><?php the_title(); ?></h3><p class="rs-center-location">Bengaluru, Karnataka</p><span class="rs-center-button">View Details</span></div></a></article>
            <?php endforeach; wp_reset_postdata(); else : foreach ( array( array( 'Malleswaram Yoga Center', 'Malleswaram, Bengaluru', 'https://images.unsplash.com/photo-1487958449943-2429e8be8625?auto=format&fit=crop&w=700&q=80' ), array( 'Jayanagar Wellness Center', 'Jayanagar, Bengaluru', 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=700&q=80' ), array( 'Kengeri Community Center', 'Kengeri, Bengaluru', 'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?auto=format&fit=crop&w=700&q=80' ) ) as $center ) : ?>
                <article class="rs-center-card"><img src="<?php echo esc_url( $center[2] ); ?>" alt="" loading="lazy"><div class="rs-center-card-body"><h3><?php echo esc_html( $center[0] ); ?></h3><p class="rs-center-location"><?php echo esc_html( $center[1] ); ?></p><a class="rs-center-button" href="#">View Details</a></div></article>
            <?php endforeach; endif; ?>
            </div>
            <a class="rs-center-locate" href="#"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5.3 7 13 7 13s7-7.7 7-13a7 7 0 0 0-7-7Zm0 10.1A3.1 3.1 0 1 1 12 5.9a3.1 3.1 0 0 1 0 6.2Z"/></svg><span>Locate Centers<br>Near You</span></a>
        </div>
    </div>
</section>

<section class="rs-content-section">
    <div class="rs-container">
        <div class="rs-section-row"><h2>Upcoming Events</h2><a class="rs-outline-link" href="<?php echo esc_url( home_url('/events/') ); ?>">View All Events</a></div>
        <div class="rs-card-grid rs-event-grid">
            <?php if ( $events ) : foreach ( $events as $post ) : setup_postdata( $post ); ?>
                <article class="rs-event-card"><a href="<?php the_permalink(); ?>"><div class="rs-event-image"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); } ?><span><b><?php echo esc_html( get_the_date( 'd' ) ); ?></b><?php echo esc_html( get_the_date( 'M' ) ); ?></span></div><h3><?php the_title(); ?></h3><p>View event details</p><span class="rs-register-button">Register Now</span></a></article>
            <?php endforeach; wp_reset_postdata(); else : foreach ( $event_fallbacks as $event ) : ?>
                <article class="rs-event-card"><div class="rs-event-image"><img src="<?php echo esc_url( $event[5] ); ?>" alt="" loading="lazy"><span><b><?php echo esc_html( $event[0] ); ?></b><?php echo esc_html( $event[1] ); ?></span></div><h3><?php echo esc_html( $event[2] ); ?></h3><p><?php echo esc_html( $event[3] . ' | ' . $event[4] ); ?></p><a class="rs-register-button" href="#">Register Now</a></article>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

<section class="rs-testimonials rs-section">
    <div class="rs-container">
        <div class="rs-heading"><h2>Voices of Trust</h2></div>
        <div class="rs-testimonial-grid">
            <?php foreach ( array( array( 'Ananya H.', 'Yoga Participant', 'Rashtrotthana programs have brought positivity and balance into my life. Truly life-changing!' ), array( 'Prasanna B.', 'Parent', 'The values and discipline I learned here continue to guide me every day.' ), array( 'Ramesh K.', 'Well-wisher', 'A wonderful platform for personality development and community service.' ) ) as $quote ) : ?>
                <blockquote><p><?php echo esc_html( $quote[2] ); ?></p><cite><?php echo esc_html( $quote[0] ); ?><small><?php echo esc_html( $quote[1] ); ?></small></cite></blockquote>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="rs-content-section rs-gallery">
    <div class="rs-container"><div class="rs-section-row"><h2>Moments of Inspiration</h2><a class="rs-outline-link" href="<?php echo esc_url( home_url('/gallery/') ); ?>">View Gallery</a></div><div class="rs-gallery-grid"><?php foreach ( $activity_fallbacks as $item ) : ?><img src="<?php echo esc_url( $item[2] ); ?>" alt="" loading="lazy"><?php endforeach; ?></div></div>
</section>

<section class="rs-cta">
    <div class="rs-container"><div><h2>Be a Part of the Change</h2><p>Join hands with Rashtrotthana in our mission<br>to create a healthier and better world.</p></div><a class="rs-btn rs-btn-primary" href="#">Join Us Today</a><a class="rs-btn rs-cta-donate" href="#">Donate Now</a></div>
</section>
