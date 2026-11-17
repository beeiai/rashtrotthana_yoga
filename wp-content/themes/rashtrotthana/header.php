<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Site Greeting Overlay (Appears only once on first visit, not on other pages) -->
<script>
if (typeof sessionStorage !== 'undefined' && sessionStorage.getItem('rs_greeting_shown')) {
    document.write('<style>#rs-greeting-overlay{display:none!important}</style>');
}
</script>
<div id="rs-greeting-overlay" class="rs-greeting-overlay" role="dialog" aria-modal="true" aria-label="Welcome to Rashtrotthana Yoga">
    <div class="rs-greeting-card">
        <button type="button" class="rs-greeting-close" id="rs-greeting-close" aria-label="Close greeting">&times;</button>
        <div class="rs-greeting-icon-wrap">
            <div class="rs-greeting-lotus">
                <svg viewBox="0 0 64 64" width="46" height="46" fill="none" stroke="currentColor">
                    <circle cx="32" cy="32" r="28" stroke="#BAC8B1" stroke-width="1.5" stroke-dasharray="3 3"/>
                    <path d="M32 14 C32 24 22 34 14 38 C18 42 25 43 32 43 C39 43 46 42 50 38 C42 34 32 24 32 14 Z" fill="rgba(186,200,177,0.4)" stroke="#7B9669" stroke-width="1.8"/>
                    <path d="M32 22 C32 29 26 36 19 40 C23 43 28 44 32 44 C36 44 41 43 45 40 C38 36 32 29 32 22 Z" fill="#7B9669" stroke="#404E3B" stroke-width="1.6"/>
                    <path d="M32 28 C32 33 29 38 24 41 C27 43 30 43.5 32 43.5 C34 43.5 37 43 40 41 C35 38 32 33 32 28 Z" fill="#404E3B" stroke="#404E3B" stroke-width="1.4"/>
                    <circle cx="32" cy="20" r="3" fill="#BAC8B1"/>
                </svg>
            </div>
        </div>
        <span class="rs-greeting-pill">Namaste</span>
        <h2 class="rs-greeting-heading">Welcome to Rashtrotthana Yoga</h2>
        <p class="rs-greeting-tagline">To create a Sustainable, Healthy Society</p>
        <p class="rs-greeting-sub">Harmonizing Body, Mind &amp; Soul</p>
        <div class="rs-greeting-timer-wrap">
            <div class="rs-greeting-timer-fill"></div>
        </div>
        <div class="rs-greeting-hint">Entering in 3 seconds &bull; <span class="rs-greeting-skip" id="rs-greeting-skip">tap to enter</span></div>
    </div>
</div>
<script>
(function() {
    var overlay = document.getElementById('rs-greeting-overlay');
    if (!overlay) return;

    // Show ONLY ONCE on first visit; never again when navigating between pages
    try {
        if (sessionStorage.getItem('rs_greeting_shown')) {
            if (overlay && overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
            return;
        }
        sessionStorage.setItem('rs_greeting_shown', '1');
    } catch (e) {}

    // Immediately blur the page background on first visit
    document.documentElement.classList.add('rs-greeting-active');

    var dismissed = false;
    function dismissGreeting() {
        if (dismissed) return;
        dismissed = true;
        document.documentElement.classList.remove('rs-greeting-active');
        overlay.classList.add('rs-dismissing');
        setTimeout(function() {
            if (overlay && overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
        }, 520);
    }

    // Auto-dismiss after 3 seconds (3000ms)
    var autoTimer = setTimeout(dismissGreeting, 3000);

    var closeBtn = document.getElementById('rs-greeting-close');
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            clearTimeout(autoTimer);
            dismissGreeting();
        });
    }

    var skipBtn = document.getElementById('rs-greeting-skip');
    if (skipBtn) {
        skipBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            clearTimeout(autoTimer);
            dismissGreeting();
        });
    }

    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) {
            clearTimeout(autoTimer);
            dismissGreeting();
        }
    });

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            clearTimeout(autoTimer);
            dismissGreeting();
        }
    });
})();
</script>

<style>
body::before {
    background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/watercolor-bg.jpg?v=' . filemtime( get_template_directory() . '/assets/images/watercolor-bg.jpg' ) ); ?>') !important;
}
.rs-site-header{position:sticky;top:0;z-index:1100;box-shadow:none}
/* Scroll-activated navbar liquid glass */
.rs-site-header.is-scrolled .rs-navbar {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.88) 0%, rgba(245, 248, 244, 0.68) 100%) !important;
    box-shadow: 0 16px 40px rgba(64, 78, 59, .14), inset 0 1.5px 1.5px #fff !important;
    -webkit-backdrop-filter: blur(28px) saturate(180%) !important;
    backdrop-filter: blur(28px) saturate(180%) !important;
}
.rs-site-header.is-scrolled .rs-navbar-inner {
    min-height: 62px;
    transition: min-height 260ms ease;
}
.rs-brand img {
    height: auto;
    max-height: 52px !important;
    width: auto !important;
    max-width: 260px;
    object-fit: contain;
}
@media (min-width: 1051px) {
    .rs-nav-link { font-size: 1.0rem !important; font-weight: 700 !important; }
    .rs-brand img { max-height: 54px !important; max-width: 270px !important; }
}
@media (max-width: 600px) {
    .rs-brand img { max-height: 44px !important; max-width: 190px !important; }
}
@media (max-width: 992px) {
    .rs-navbar-inner { min-height: 62px !important; }
    .rs-brand img { max-height: 42px !important; }
}
</style>

<!-- Ambient Morning Sunlight Caustics Layer -->
<div class="rs-caustic-layer" aria-hidden="true"></div>

<!-- Interactive Falling Leaves Canvas Layer (Kept strictly in the background) -->
<canvas id="rs-falling-leaves-canvas" class="rs-falling-leaves-canvas" aria-hidden="true"></canvas>

<header class="rs-site-header">
    <nav class="rs-navbar">
        <div class="rs-container rs-navbar-inner">
            <a class="rs-brand" href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/rashtrotthana-logo.png?v=' . filemtime( get_template_directory() . '/assets/images/rashtrotthana-logo.png' ) ); ?>" alt="Rashtrotthana Yogic Sciences and Research Institute">
            </a>
            <button class="rs-menu-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="rs-site-nav">
                <span></span><span></span><span></span>
            </button>
            <div class="rs-navigation" id="rs-site-nav">
                <a class="rs-nav-link<?php echo is_front_page() ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <a class="rs-nav-link<?php echo is_page('about-us') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/about-us/')); ?>">About Us</a>
                <a class="rs-nav-link<?php echo is_page('activities') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/activities/')); ?>">Activities</a>
                <a class="rs-nav-link<?php echo is_page('centers') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/centers/')); ?>">Centers</a>
                <a class="rs-nav-link<?php echo is_page('events') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/events/')); ?>">Events</a>
                <a class="rs-nav-link<?php echo is_page('gallery') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/gallery/')); ?>">Gallery</a>
                <a class="rs-nav-link<?php echo is_page('contact-us') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Contact Us</a>
            </div>
        </div>
    </nav>
</header>
<script>
(function () {
    /* Scroll-activated header tightening */
    var header = document.querySelector('.rs-site-header');
    if (header) {
        var onScroll = function () {
            header.classList.toggle('is-scrolled', window.scrollY > 30);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }
})();
</script>
