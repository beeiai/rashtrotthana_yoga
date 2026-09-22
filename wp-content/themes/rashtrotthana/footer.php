<?php
$address = function_exists('get_field') ? get_field('ry_address_primary', 'option') : "#1, Rashtrotthana Complex,\nMalleswaram, Bengaluru - 560003\nKarnataka, India";
$phone   = function_exists('get_field') ? get_field('ry_phone_primary', 'option') : '+91 80 1234 5678';
$email   = function_exists('get_field') ? get_field('ry_email_primary', 'option') : 'info@rashtrotthana.org';

$fb_url  = function_exists('get_field') ? get_field('ry_facebook_url', 'option') : '#';
$tw_url  = function_exists('get_field') ? get_field('ry_twitter_url', 'option') : '#';
$in_url  = function_exists('get_field') ? get_field('ry_instagram_url', 'option') : '#';
$yt_url  = function_exists('get_field') ? get_field('ry_youtube_url', 'option') : '#';
?>
<style>
.rs-footer-brand:after{content:none}
.rs-footer-brand{display:flex;flex-direction:column;align-items:center;text-align:center}
.rs-footer-logo{margin:0 auto 16px}
.rs-footer-tagline{width:100%;margin:0 0 20px!important;text-align:center}
.rs-socials{justify-content:center;width:100%;margin-top:0}
.rs-whatsapp-float{position:fixed;right:24px;bottom:24px;z-index:1090;display:grid;place-items:center;width:54px;height:54px;border-radius:50%;background:#25d366;color:#fff;box-shadow:0 8px 20px rgba(21,112,56,.34);transition:transform 180ms ease,box-shadow 180ms ease}
.rs-whatsapp-float:hover{color:#fff;transform:translateY(-3px);box-shadow:0 12px 24px rgba(21,112,56,.4)}
.rs-whatsapp-float svg{width:27px;height:27px;fill:currentColor}
@media(max-width:600px){.rs-whatsapp-float{right:16px;bottom:16px;width:48px;height:48px}}
</style>
<footer class="rs-footer">
    <div class="rs-container rs-footer-grid">
        <div class="rs-footer-brand">
            <a class="rs-footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Rashtrotthana Group home">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/rashtrotthana-group-logo.png' ); ?>" alt="Rashtrotthana Group">
            </a>
            <p class="rs-footer-tagline">To create<br>Sustainable Healthy Society</p>
            <div class="rs-socials" aria-label="Social media links">
                <?php if ( $fb_url ) : ?>
                <a href="<?php echo esc_url( $fb_url ); ?>" aria-label="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4h-3c-3.3 0-5 2-5 5v3H6v4h3v4h4v-4h3l1-4h-4V9c0-.7.3-1 1-1Z"/></svg></a>
                <?php endif; if ( $tw_url ) : ?>
                <a href="<?php echo esc_url( $tw_url ); ?>" aria-label="Twitter"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.9 7.1v.5c0 5.1-3.9 11-11 11-2.2 0-4.2-.6-5.9-1.8h.9c1.8 0 3.4-.6 4.7-1.6a3.9 3.9 0 0 1-3.6-2.7c.6.1 1.1.1 1.7-.1A3.9 3.9 0 0 1 2.6 8.6c.5.3 1.1.5 1.7.5a3.9 3.9 0 0 1-1.2-5.2 11 11 0 0 0 8 4.1 3.9 3.9 0 0 1 6.6-3.6c.9-.2 1.7-.5 2.4-.9-.3.9-.9 1.6-1.7 2.1.8-.1 1.5-.3 2.2-.6-.5.8-1.1 1.5-1.7 2.1Z"/></svg></a>
                <?php endif; if ( $in_url ) : ?>
                <a href="<?php echo esc_url( $in_url ); ?>" aria-label="Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
                <?php endif; if ( $yt_url ) : ?>
                <a href="<?php echo esc_url( $yt_url ); ?>" aria-label="YouTube"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.6 7.2a2.8 2.8 0 0 0-2-2C17.8 4.7 12 4.7 12 4.7s-5.8 0-7.6.5a2.8 2.8 0 0 0-2 2C2 9 2 12 2 12s0 3 .4 4.8a2.8 2.8 0 0 0 2 2c1.8.5 7.6.5 7.6.5s5.8 0 7.6-.5a2.8 2.8 0 0 0 2-2C22 15 22 12 22 12s0-3-.4-4.8ZM10 15.5v-7l6 3.5-6 3.5Z"/></svg></a>
                <?php endif; ?>
            </div>
        </div>
        <div><h3>Quick Links</h3><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">About Us</a><a href="<?php echo esc_url( home_url( '/activities/' ) ); ?>">Activities</a><a href="<?php echo esc_url( home_url( '/centers/' ) ); ?>">Centers</a><a href="<?php echo esc_url( home_url( '/events/' ) ); ?>">Events</a><a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>">Gallery</a></div>
        <div><h3>Support</h3><a href="#">Join Us</a><a href="#">Donate</a><a href="#">Volunteer</a><a href="#">Careers</a><a href="#">FAQ's</a></div>
        <div>
            <h3>Contact Us</h3>
            <p><?php echo nl2br( esc_html( $address ) ); ?></p>
            <p><?php echo esc_html( $phone ); ?><br><?php echo esc_html( $email ); ?></p>
        </div>
    </div>
    <div class="rs-container rs-footer-bottom"><span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> Rashtrotthana Parishat. All Rights Reserved.</span><span>Privacy Policy &nbsp;|&nbsp; Terms &amp; Conditions</span></div>
</footer>
<a class="rs-whatsapp-float" href="https://wa.me/<?php echo esc_attr( preg_replace('/[^0-9]/', '', $phone) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Contact us on WhatsApp">
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 3.5A11.8 11.8 0 0 0 2.2 17.7L1 22.8l5.2-1.2A11.8 11.8 0 1 0 20.5 3.5ZM12 21a9 9 0 0 1-4.5-1.2l-.3-.2-3.1.7.7-3-.2-.3A9 9 0 1 1 12 21Zm4.9-6.7c-.3-.2-1.8-.9-2.1-1s-.5-.2-.7.2-.8 1-.9 1.1-.4.2-.7 0a7.4 7.4 0 0 1-2.2-1.4 8.4 8.4 0 0 1-1.6-2c-.2-.3 0-.5.1-.7l.4-.5c.1-.2.2-.4.3-.6s0-.4 0-.6l-1-2.4c-.2-.5-.5-.4-.7-.4h-.6c-.2 0-.6.1-.9.5s-1.2 1.1-1.2 2.7 1.2 3.1 1.4 3.4a10.5 10.5 0 0 0 4 3.7c.6.3 1 .5 1.4.6.6.2 1.1.2 1.5.1.5-.1 1.8-.7 2-1.4s.3-1.3.2-1.4-.3-.2-.6-.4Z"/></svg>
</a>

<?php wp_footer(); ?>

</body>
</html>
