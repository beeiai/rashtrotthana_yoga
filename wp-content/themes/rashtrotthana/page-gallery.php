<?php get_header(); ?>
<?php
// Fetch published gallery items from WordPress database
$db_gallery_posts = get_posts( [
    'post_type'      => 'ry_gallery',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
] );

$photos = [];
$videos = [];

if ( ! empty( $db_gallery_posts ) ) {
    foreach ( $db_gallery_posts as $g_post ) {
        $g_type     = get_post_meta( $g_post->ID, '_ry_gallery_type', true ) ?: 'image';
        $image_url  = get_post_meta( $g_post->ID, '_ry_gallery_image_url', true ) ?: '';
        $video_url  = get_post_meta( $g_post->ID, '_ry_gallery_video_url', true ) ?: '';
        $duration   = get_post_meta( $g_post->ID, '_ry_gallery_video_duration', true ) ?: '';
        $caption    = $g_post->post_content ?: $g_post->post_title;

        if ( empty( $image_url ) && has_post_thumbnail( $g_post->ID ) ) {
            $image_url = get_the_post_thumbnail_url( $g_post->ID, 'large' );
        }

        if ( $g_type === 'video' ) {
            $embed_url = $video_url;
            if ( preg_match( '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video_url, $m ) ) {
                $embed_url = 'https://www.youtube.com/embed/' . $m[1];
                if ( empty( $image_url ) ) {
                    $image_url = 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
                }
            }
            $videos[] = [
                'title'       => $g_post->post_title,
                'subtitle'    => $caption,
                'duration'    => $duration,
                'thumbnail'   => $image_url,
                'video_url'   => $embed_url,
            ];
        } else {
            if ( ! empty( $image_url ) ) {
                $photos[] = [
                    'title'     => $g_post->post_title,
                    'image_url' => $image_url,
                ];
            }
        }
    }
}

// Dynamic Stats
$center_counts   = wp_count_posts( 'ry_center' );
$total_centers   = ( $center_counts && isset( $center_counts->publish ) && $center_counts->publish > 0 ) ? $center_counts->publish . '+' : '23+';
$activity_counts = wp_count_posts( 'ry_activity' );
$total_acts      = ( $activity_counts && isset( $activity_counts->publish ) && $activity_counts->publish > 0 ) ? $activity_counts->publish . '+' : '35+';
?>

<main class="rs-gallery-page">
    <!-- Hero Section -->
    <section class="rs-gallery-hero">
        <div class="rs-gallery-hero-image"></div>
        <div class="rs-container rs-gallery-hero-inner">
            <div>
                <h1>Gal<em>lery</em> <span>♧</span></h1>
                <h2>Moments that inspire. Memories that stay.</h2>
                <p>Explore highlights from our programs, events, celebrations and everyday moments across our centers.</p>
                <div class="rs-gallery-stats">
                    <p><strong><?php echo esc_html( $total_centers ); ?></strong><span>Centers</span></p>
                    <p><strong><?php echo esc_html( $total_acts ); ?></strong><span>Activities</span></p>
                    <p><strong>1.5+ Lakh</strong><span>Lives Touched</span></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Photo Gallery Section -->
    <section class="rs-photo-gallery" id="photos">
        <div class="rs-container">
            <h2>♧ &nbsp; Photo Gallery</h2>
            <?php if ( ! empty( $photos ) ) : ?>
                <div class="rs-photo-grid" id="rs-front-photo-grid">
                    <?php foreach ( $photos as $photo ) : ?>
                        <button class="rs-media-item rs-photo-card" type="button" data-type="image"
                                data-src="<?php echo esc_url( $photo['image_url'] ); ?>"
                                data-title="<?php echo esc_attr( $photo['title'] ); ?>">
                            <img src="<?php echo esc_url( $photo['image_url'] ); ?>" alt="<?php echo esc_attr( $photo['title'] ); ?>" loading="lazy">
                        </button>
                    <?php endforeach; ?>
                </div>
                <?php if ( count( $photos ) > 12 ) : ?>
                    <button class="rs-load-photos" type="button">Load More Photos &nbsp;↓</button>
                <?php endif; ?>
            <?php else : ?>
                <div style="text-align: center; padding: 60px 20px; color: #666;">
                    <p style="font-size: 16px; margin: 0;">No photos published yet. Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Video Gallery Section (if videos exist) -->
    <?php if ( ! empty( $videos ) ) : ?>
    <section class="rs-video-gallery">
        <div class="rs-container">
            <div class="rs-gallery-section-title">
                <h2>▣ &nbsp; Video Gallery</h2>
                <a href="#videos">View all videos &nbsp;→</a>
            </div>
            <div class="rs-video-grid" id="videos">
                <?php foreach ( $videos as $video ) : ?>
                    <article class="rs-video-card">
                        <button class="rs-media-item" type="button" data-type="video"
                                data-src="<?php echo esc_url( $video['video_url'] ); ?>"
                                data-title="<?php echo esc_attr( $video['title'] ); ?>">
                            <img src="<?php echo esc_url( $video['thumbnail'] ); ?>" alt="<?php echo esc_attr( $video['title'] ); ?>" loading="lazy">
                            <span class="rs-video-duration"><?php echo esc_html( $video['duration'] ); ?></span>
                            <b>▶</b>
                        </button>
                        <h3><?php echo esc_html( $video['title'] ); ?></h3>
                        <p><?php echo esc_html( $video['subtitle'] ); ?></p>
                        <a href="#videos" class="rs-play-trigger">Watch Video &nbsp;→</a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Newsletter Subscribe -->
    <section class="rs-gallery-subscribe">
        <div class="rs-container">
            <div>
                <span>✉</span>
                <p>
                    <strong>Stay Connected. Stay Inspired.</strong>
                    <small>Subscribe to our newsletter and never miss updates on our programs, events and inspiring stories.</small>
                </p>
                <form>
                    <input type="email" aria-label="Email address" placeholder="Enter your email">
                    <button type="submit">Subscribe &nbsp;→</button>
                </form>
            </div>
        </div>
    </section>
</main>

<!-- Lightbox Modal -->
<div class="rs-gallery-lightbox" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Gallery preview">
    <div class="rs-gallery-lightbox-backdrop" data-gallery-close></div>
    <div class="rs-gallery-lightbox-content">
        <button class="rs-gallery-close" type="button" aria-label="Close preview" data-gallery-close>×</button>
        <button class="rs-gallery-prev" type="button" aria-label="Previous item">‹</button>
        <div class="rs-gallery-media"></div>
        <button class="rs-gallery-next" type="button" aria-label="Next item">›</button>
        <p></p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── Watch video text click triggers lightbox ─────────────────────
    document.querySelectorAll('.rs-play-trigger').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var art = this.closest('.rs-video-card');
            if (art) {
                var mBtn = art.querySelector('.rs-media-item');
                if (mBtn) mBtn.click();
            }
        });
    });

    // ── Lightbox Implementation ──────────────────────────────────────
    var box = document.querySelector('.rs-gallery-lightbox');
    var media = box.querySelector('.rs-gallery-media');
    var caption = box.querySelector('.rs-gallery-lightbox-content p');
    var current = 0;

    function getVisibleItems() {
        return [].slice.call(document.querySelectorAll('.rs-media-item')).filter(function(el) {
            return el.offsetParent !== null;
        });
    }

    function show(i) {
        var items = getVisibleItems();
        if (!items.length) return;
        current = (i + items.length) % items.length;
        var item = items[current];
        var type = item.dataset.type;
        var src = item.dataset.src;
        var title = item.dataset.title || '';

        media.innerHTML = type === 'video'
            ? '<iframe src="' + src + '?autoplay=1" title="' + title + '" allow="autoplay; fullscreen" allowfullscreen></iframe>'
            : '<img src="' + src + '" alt="' + title + '">';
        caption.textContent = title;
        box.classList.add('is-open');
        box.setAttribute('aria-hidden', 'false');
        document.body.classList.add('rs-gallery-open');
    }

    function close() {
        box.classList.remove('is-open');
        box.setAttribute('aria-hidden', 'true');
        media.innerHTML = '';
        document.body.classList.remove('rs-gallery-open');
    }

    document.addEventListener('click', function(e) {
        var item = e.target.closest('.rs-media-item');
        if (item) {
            var items = getVisibleItems();
            var idx = items.indexOf(item);
            show(idx >= 0 ? idx : 0);
        }
    });

    box.querySelector('.rs-gallery-next').addEventListener('click', function() { show(current + 1); });
    box.querySelector('.rs-gallery-prev').addEventListener('click', function() { show(current - 1); });
    box.querySelectorAll('[data-gallery-close]').forEach(function(b) { b.addEventListener('click', close); });

    document.addEventListener('keydown', function(e) {
        if (!box.classList.contains('is-open')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowRight') show(current + 1);
        if (e.key === 'ArrowLeft') show(current - 1);
    });
});
</script>

<?php get_footer(); ?>
