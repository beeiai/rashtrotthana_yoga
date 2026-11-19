<?php
// Contact & social media details hardcoded as requested
$address = "No. 93/1, ‘Keshava Shilpa’, Kempegowda Nagar, Bengaluru – 560 004";
$phone   = "+91-96060 80778";
$email   = "yoga.coord@rashtrotthana.org";

$instagram_url = "https://www.instagram.com/rashtrotthana_yoga_official/";
$x_url         = "https://x.com/Rashtrotthana_P";
$youtube_url   = "https://www.youtube.com/channel/UCccixFI_2_JydCPQWBCYpPQ";

$whatsapp_num  = function_exists('get_field') ? (get_field('ry_whatsapp_number', 'option') ?: '+91 96060 44453') : '+91 96060 44453';
?>
<style>
.rs-footer { margin-top: 60px; }
.rs-footer-brand:after{content:none}
.rs-footer-brand{display:flex;flex-direction:column;align-items:flex-start;text-align:left}
.rs-footer-logo{display:block;width:auto!important;max-width:140px!important;height:auto!important;overflow:visible!important;margin:0 0 16px 0}
.rs-footer-logo img{display:block;width:auto!important;max-width:130px!important;max-height:130px!important;height:auto!important;object-fit:contain}
.rs-footer-tagline{width:100%;margin:0 0 20px!important;text-align:left}
.rs-footer a, .rs-footer p, .rs-footer span{color:#fae9de}
.rs-footer-contact-list{display:flex;flex-direction:column;gap:12px;margin:12px 0 20px;}
.rs-footer-contact-item{display:flex;align-items:flex-start;gap:10px;margin:0;}
.rs-footer-contact-icon{flex-shrink:0;width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;color:#F9B72A;margin-top:2px;}
.rs-footer-contact-icon svg{width:16px;height:16px;stroke-width:2.2;}
.rs-footer-contact-text{margin:0;line-height:1.45;font-size:0.92rem;color:#fae9de;}
.rs-footer-contact-link{display:inline!important;color:#fae9de!important;text-decoration:none;transition:color .2s ease;font-size:0.92rem;line-height:1.45;}
.rs-footer-contact-link:hover{color:#F9B72A!important;text-decoration:underline}
.rs-socials{justify-content:flex-start;width:100%;margin-top:0;gap:12px;display:flex;}
.rs-socials a{display:grid!important;place-items:center;width:34px;height:34px;border-radius:50%;background:#ffffff;color:#4c5661!important;transition:transform .2s ease,background .2s ease,color .2s ease;text-decoration:none}
.rs-socials a:hover{transform:translateY(-2px);background:#fff8ec;color:#8F171D!important;box-shadow:0 4px 12px rgba(0,0,0,.15)}
.rs-socials svg{width:18px;height:18px}
.rs-whatsapp-float{position:fixed;right:24px;bottom:24px;z-index:1090;display:flex;align-items:center;justify-content:center;width:58px;height:58px;border-radius:50%;background:transparent;box-shadow:0 8px 24px rgba(0,0,0,.18),0 4px 12px rgba(37,211,102,.35);transition:transform 220ms cubic-bezier(.34,1.56,.64,1),box-shadow 220ms ease;text-decoration:none;line-height:0}
.rs-whatsapp-float:hover{transform:translateY(-4px) scale(1.08);box-shadow:0 14px 28px rgba(0,0,0,.22),0 6px 18px rgba(37,211,102,.45)}
.rs-whatsapp-float img{width:100%;height:100%;display:block;object-fit:contain;border-radius:50%;pointer-events:none}
@media(max-width:600px){.rs-whatsapp-float{right:16px;bottom:16px;width:50px;height:50px}}
</style>
<footer class="rs-footer">
    <div class="rs-container rs-footer-grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));">
        <div class="rs-footer-brand">
            <a class="rs-footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Rashtrotthana Parishat home">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/rashtrotthana-footer-logo.png?v=' . filemtime( get_template_directory() . '/assets/images/rashtrotthana-footer-logo.png' ) ); ?>" alt="Rashtrotthana Parishat">
            </a>
            <p class="rs-footer-tagline">To create<br>Sustainable Healthy Society</p>
        </div>
        <div>
            <h3>Site Map</h3>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">About Us</a>
            <a href="<?php echo esc_url( home_url( '/activities/' ) ); ?>">Activities</a>
            <a href="<?php echo esc_url( home_url( '/centers/' ) ); ?>">Centers</a>
            <a href="<?php echo esc_url( home_url( '/events/' ) ); ?>">Events</a>
            <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">Contact Us</a>
        </div>
        <div>
            <h3>Connect With Us</h3>
            <div class="rs-footer-contact-list">
                <div class="rs-footer-contact-item">
                    <span class="rs-footer-contact-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8Z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </span>
                    <span class="rs-footer-contact-text"><?php echo esc_html( $address ); ?></span>
                </div>
                <div class="rs-footer-contact-item">
                    <span class="rs-footer-contact-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </span>
                    <a href="tel:+919606080778" class="rs-footer-contact-link"><?php echo esc_html( $phone ); ?></a>
                </div>
                <div class="rs-footer-contact-item">
                    <span class="rs-footer-contact-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    </span>
                    <a href="mailto:<?php echo esc_attr( $email ); ?>" class="rs-footer-contact-link"><?php echo esc_html( $email ); ?></a>
                </div>
            </div>
            <h3 style="margin-top:16px; font-size:1.1rem;">Follow Us</h3>
            <div class="rs-socials" aria-label="Social media links">
                <a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Follow us on Instagram">
                    <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                </a>
                <a href="<?php echo esc_url( $x_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Follow us on X (Twitter)">
                    <svg viewBox="0 0 24 24" aria-hidden="true" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <a href="<?php echo esc_url( $youtube_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Subscribe on YouTube">
                    <svg viewBox="0 0 24 24" aria-hidden="true" fill="currentColor"><path d="M21.6 7.2a2.8 2.8 0 0 0-2-2C17.8 4.7 12 4.7 12 4.7s-5.8 0-7.6.5a2.8 2.8 0 0 0-2 2C2 9 2 12 2 12s0 3 .4 4.8a2.8 2.8 0 0 0 2 2c1.8.5 7.6.5 7.6.5s5.8 0 7.6-.5a2.8 2.8 0 0 0 2-2C22 15 22 12 22 12s0-3-.4-4.8ZM10 15.5v-7l6 3.5-6 3.5Z"/></svg>
                </a>
            </div>
        </div>
    </div>
    <div class="rs-container rs-footer-bottom"><span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> Rashtrotthana Parishat. All Rights Reserved.</span><span>Privacy Policy &nbsp;|&nbsp; Terms &amp; Conditions</span></div>
</footer>
<a class="rs-whatsapp-float" href="https://wa.me/<?php echo esc_attr( preg_replace('/[^0-9]/', '', $whatsapp_num) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Contact us on WhatsApp">
    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/whatsapp-icon.png' ); ?>" alt="WhatsApp" width="58" height="58">
</a>

<?php wp_footer(); ?>

</body>
</html>
