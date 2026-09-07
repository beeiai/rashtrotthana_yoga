<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<style>
.rs-site-header{position:sticky;top:0;z-index:1100;box-shadow:0 3px 14px rgba(67,27,15,.1)}
@media (min-width:601px){
    .rs-hero-content{width:min(calc(100% - 96px),760px)!important;max-width:760px!important;margin-left:0!important;margin-right:auto!important}
    .rs-hero-title{width:100%;max-width:760px!important;font-size:clamp(2.75rem,4.25vw,4.1rem)!important;line-height:1.08!important;letter-spacing:-.025em!important;text-wrap:balance}
}
@media (min-width:601px) and (max-width:900px){
    .rs-hero-content{width:calc(100% - 48px)!important}
    .rs-hero-title{max-width:680px!important;font-size:clamp(2.5rem,5vw,3.35rem)!important}
}
</style>
<header class="rs-site-header">
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
                <?php $header_logo = file_exists( get_template_directory() . '/assets/images/header-logo.png' ) ? 'header-logo.png' : '60_years_logo.png'; ?>
                <img class="rs-header-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $header_logo ); ?>" alt="Rashtrotthana">
            </div>
        </div>
    </nav>
</header>
