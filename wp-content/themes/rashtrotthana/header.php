<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<style>.rs-site-header{position:sticky;top:0;z-index:1100;box-shadow:0 3px 14px rgba(67,27,15,.1)}.rs-topbar-socials{gap:12px}.rs-topbar-socials a{display:grid;place-items:center}.rs-topbar-socials svg{width:14px;height:14px;fill:currentColor}@media(max-width:600px){.rs-topbar-right.rs-topbar-socials{display:flex}.rs-topbar-inner{justify-content:space-between}}</style>
<header class="rs-site-header">
    <div class="rs-topbar">
        <div class="rs-container rs-topbar-inner">
            <div class="rs-topbar-left"><span class="rs-since">Since 1972</span></div>
            <div class="rs-topbar-right rs-topbar-socials" aria-label="Social media links">
                <a href="#" aria-label="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4h-3c-3.3 0-5 2-5 5v3H6v4h3v4h4v-4h3l1-4h-4V9c0-.7.3-1 1-1Z"/></svg></a>
                <a href="#" aria-label="Twitter"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.9 7.1v.5c0 5.1-3.9 11-11 11-2.2 0-4.2-.6-5.9-1.8h.9c1.8 0 3.4-.6 4.7-1.6a3.9 3.9 0 0 1-3.6-2.7c.6.1 1.1.1 1.7-.1A3.9 3.9 0 0 1 2.6 8.6c.5.3 1.1.5 1.7.5a3.9 3.9 0 0 1-1.2-5.2 11 11 0 0 0 8 4.1 3.9 3.9 0 0 1 6.6-3.6c.9-.2 1.7-.5 2.4-.9-.3.9-.9 1.6-1.7 2.1.8-.1 1.5-.3 2.2-.6-.5.8-1.1 1.5-1.7 2.1Z"/></svg></a>
                <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.5 8.5A2.3 2.3 0 1 0 6.5 4a2.3 2.3 0 0 0 0 4.5ZM4.5 20h4V10h-4v10Zm6.5-10v10h4v-5.4c0-1.4.3-2.8 2-2.8s1.6 1.7 1.6 2.9V20h4v-6.1c0-3-1.6-4.4-3.9-4.4-1.8 0-2.6 1-3.1 1.7V10h-4.1Z"/></svg></a>
                <a href="#" aria-label="YouTube"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.6 7.2a2.8 2.8 0 0 0-2-2C17.8 4.7 12 4.7 12 4.7s-5.8 0-7.6.5a2.8 2.8 0 0 0-2 2C2 9 2 12 2 12s0 3 .4 4.8a2.8 2.8 0 0 0 2 2c1.8.5 7.6.5 7.6.5s5.8 0 7.6-.5a2.8 2.8 0 0 0 2-2C22 15 22 12 22 12s0-3-.4-4.8ZM10 15.5v-7l6 3.5-6 3.5Z"/></svg></a>
            </div>
        </div>
    </div>

    <nav class="rs-navbar">
        <div class="rs-container rs-navbar-inner">
            <a class="rs-brand" href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/rashtrotthana-group-logo.png' ); ?>" alt="Rashtrotthana Group">
            </a>
            <button class="rs-menu-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
            <div class="rs-navigation">
                <a class="rs-nav-link<?php echo is_front_page() ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <a class="rs-nav-link<?php echo is_page('about-us') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/about-us/')); ?>">About Us</a>
                <a class="rs-nav-link<?php echo is_page('activities') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/activities/')); ?>">Activities</a>
                <a class="rs-nav-link<?php echo is_page('centers') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/centers/')); ?>">Centers</a>
                <a class="rs-nav-link<?php echo is_page('events') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/events/')); ?>">Events</a>
                <a class="rs-nav-link<?php echo is_page('resources') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/resources/')); ?>">Resources</a>
                <a class="rs-nav-link<?php echo is_page('gallery') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/gallery/')); ?>">Gallery</a>
                <a class="rs-nav-link<?php echo is_page('contact-us') ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Contact Us</a>
                <a class="rs-donate-button" href="#">Join Us / Donate</a>
            </div>
        </div>
    </nav>
</header>
