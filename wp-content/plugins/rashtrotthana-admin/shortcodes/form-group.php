<?php
/**
 * Frontend Shortcode: [ry_form_group id="..." slug="..."]
 *
 * Industry-Standard Enterprise Location & Google Form Router
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_shortcode( 'ry_form_group', 'radm_shortcode_form_group' );

function radm_shortcode_form_group( $atts ): string {
    $atts = shortcode_atts( [
        'id'   => '',
        'slug' => '',
    ], $atts );

    $search_key = sanitize_key( $atts['slug'] ?: $atts['id'] );
    if ( ! $search_key ) {
        return '<div class="ry-fg-err">Please specify a form group ID or slug: <code>[ry_form_group slug="..."]</code></div>';
    }

    $all_groups = get_option( 'radm_form_groups', [] );
    if ( ! is_array( $all_groups ) ) {
        return '<div class="ry-fg-err">Form Group not found.</div>';
    }

    // Lookup by ID or Slug
    $group = null;
    $group_id = null;
    foreach ( $all_groups as $gid => $gdata ) {
        if ( $gid === $search_key || ( isset( $gdata['slug'] ) && $gdata['slug'] === $search_key ) ) {
            $group    = $gdata;
            $group_id = $gid;
            break;
        }
    }

    if ( ! $group || ! $group_id ) {
        return '<div class="ry-fg-err">Form Group not found or link has expired.</div>';
    }

    $title       = $group['title'] ?? 'Registration Form';
    $desc        = $group['description'] ?? 'Select your nearest centre to access the registration form.';
    $action_mode = $group['action_mode'] ?? 'redirect';
    $ui_layout   = $group['ui_layout'] ?? 'cards';
    $centres     = is_array( $group['centres'] ?? null ) ? $group['centres'] : [];
    $ajax_url    = admin_url( 'admin-ajax.php' );

    ob_start();
    ?>
    <div class="ry-fg-container" id="ry-fg-app-<?php echo esc_attr( $group_id ); ?>">
        <style>
            .ry-fg-container {
                max-width: 880px;
                margin: 28px auto;
                background: #ffffff;
                border-radius: 18px;
                box-shadow: 0 12px 36px rgba(0,0,0,0.08);
                border: 1px solid #eef2f6;
                overflow: hidden;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                color: #1e293b;
            }
            .ry-fg-header {
                background: linear-gradient(135deg, #1b365d 0%, #2b4c7e 100%);
                color: #ffffff;
                padding: 28px 36px;
            }
            .ry-fg-header h2 {
                margin: 0 0 8px;
                font-size: 24px;
                font-weight: 700;
                color: #ffffff;
                letter-spacing: -0.3px;
            }
            .ry-fg-header p {
                margin: 0;
                font-size: 14.5px;
                opacity: 0.90;
                line-height: 1.5;
            }
            .ry-fg-body {
                padding: 30px 36px;
            }

            /* Live Search Filter */
            .ry-fg-search-box {
                position: relative;
                margin-bottom: 24px;
            }
            .ry-fg-search-box input {
                width: 100%;
                padding: 13px 16px 13px 44px;
                border: 1.5px solid #cbd5e1;
                border-radius: 12px;
                font-size: 15px;
                color: #1e293b;
                outline: none;
                transition: border-color 0.2s, box-shadow 0.2s;
                box-sizing: border-box;
            }
            .ry-fg-search-box input:focus {
                border-color: #2563eb;
                box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
            }
            .ry-fg-search-icon {
                position: absolute;
                left: 14px;
                top: 50%;
                transform: translateY(-50%);
                width: 18px;
                height: 18px;
                stroke: #94a3b8;
                pointer-events: none;
            }

            /* Visual Cards Grid Layout */
            .ry-fg-cards-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 16px;
                margin-bottom: 20px;
            }
            .ry-fg-card {
                background: #ffffff;
                border: 1.5px solid #e2e8f0;
                border-radius: 14px;
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                cursor: pointer;
                transition: all 0.2s ease;
                position: relative;
            }
            .ry-fg-card:hover {
                border-color: #2563eb;
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(37,99,235,0.10);
            }
            .ry-fg-card-badge {
                display: inline-block;
                background: #eff6ff;
                color: #1e40af;
                font-size: 11.5px;
                font-weight: 600;
                padding: 3px 8px;
                border-radius: 6px;
                margin-bottom: 10px;
                width: fit-content;
            }
            .ry-fg-card h4 {
                margin: 0 0 6px;
                font-size: 17px;
                font-weight: 700;
                color: #0f172a;
            }
            .ry-fg-card p {
                margin: 0 0 16px;
                font-size: 13px;
                color: #64748b;
                line-height: 1.4;
            }
            .ry-fg-card-btn {
                background: #2563eb;
                color: #ffffff;
                border: none;
                padding: 10px 16px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 13.5px;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                transition: background 0.18s;
                margin-top: auto;
            }
            .ry-fg-card-btn:hover {
                background: #1d4ed8;
            }

            /* Dropdown Select Layout */
            .ry-fg-select-wrap {
                margin-bottom: 24px;
            }
            .ry-fg-select {
                width: 100%;
                padding: 13px 16px;
                border: 1.5px solid #cbd5e1;
                border-radius: 12px;
                font-size: 15px;
                color: #1e293b;
                background: #ffffff;
                outline: none;
                box-sizing: border-box;
            }

            /* Countdown Redirect Screen */
            .ry-fg-countdown-screen {
                display: none;
                background: #f8fafc;
                border: 1px solid #cbd5e1;
                border-radius: 14px;
                padding: 36px 24px;
                text-align: center;
            }
            .ry-fg-progress-bar {
                width: 100%;
                height: 6px;
                background: #e2e8f0;
                border-radius: 3px;
                overflow: hidden;
                margin: 20px 0;
            }
            .ry-fg-progress-fill {
                width: 0%;
                height: 100%;
                background: #2563eb;
                transition: width 0.1s linear;
            }
            .ry-fg-back-btn {
                background: transparent;
                border: 1px solid #cbd5e1;
                color: #475569;
                padding: 8px 16px;
                border-radius: 8px;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                transition: all 0.18s;
            }
            .ry-fg-back-btn:hover {
                background: #f1f5f9;
                color: #0f172a;
            }

            /* Embedded Iframe View */
            .ry-fg-iframe-container {
                display: none;
            }
            .ry-fg-iframe-topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 12px 16px;
                background: #f1f5f9;
                border-radius: 10px 10px 0 0;
                border: 1px solid #e2e8f0;
                border-bottom: none;
            }
            .ry-fg-iframe-frame {
                width: 100%;
                height: 760px;
                border: 1px solid #e2e8f0;
                border-radius: 0 0 10px 10px;
                display: block;
            }
            .ry-fg-err {
                padding: 14px 18px;
                background: #fef2f2;
                border: 1px solid #fecaca;
                color: #991b1b;
                border-radius: 8px;
                font-size: 13.5px;
                margin: 16px 0;
            }
        </style>

        <!-- Header -->
        <div class="ry-fg-header">
            <h2><?php echo esc_html( $title ); ?></h2>
            <?php if ( $desc ) : ?>
                <p><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
        </div>

        <!-- Body -->
        <div class="ry-fg-body">

            <!-- Selection State (Step 1) -->
            <div id="ry-fg-step-select-<?php echo esc_attr( $group_id ); ?>">

                <!-- Search Input -->
                <div class="ry-fg-search-box">
                    <svg class="ry-fg-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" id="ry-fg-filter-<?php echo esc_attr( $group_id ); ?>" placeholder="Search your city or centre (e.g. Bangalore, Mysore…)">
                </div>

                <?php if ( $ui_layout === 'dropdown' ) : ?>
                    <!-- Dropdown Select View -->
                    <div class="ry-fg-select-wrap">
                        <select class="ry-fg-select" id="ry-fg-dropdown-<?php echo esc_attr( $group_id ); ?>">
                            <option value="">-- Choose your Centre --</option>
                            <?php foreach ( $centres as $c ) : ?>
                                <option value="<?php echo esc_attr( $c['id'] ?? '' ); ?>"
                                        data-name="<?php echo esc_attr( $c['name'] ?? '' ); ?>"
                                        data-url="<?php echo esc_url( $c['url'] ?? '' ); ?>">
                                    <?php echo esc_html( $c['name'] ?? '' ); ?><?php echo !empty($c['location']) ? ' (' . esc_html($c['location']) . ')' : ''; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else : ?>
                    <!-- Visual Cards Grid View (Default) -->
                    <div class="ry-fg-cards-grid" id="ry-fg-cards-<?php echo esc_attr( $group_id ); ?>">
                        <?php foreach ( $centres as $c ) :
                            $cid   = esc_attr( $c['id'] ?? '' );
                            $cname = esc_html( $c['name'] ?? '' );
                            $cloc  = esc_html( $c['location'] ?? '' );
                            $curl  = esc_url( $c['url'] ?? '' );
                        ?>
                        <div class="ry-fg-card" data-id="<?php echo $cid; ?>" data-name="<?php echo esc_attr( strtolower( $cname . ' ' . $cloc ) ); ?>" data-url="<?php echo $curl; ?>">
                            <div>
                                <span class="ry-fg-card-badge">📍 Centre</span>
                                <h4><?php echo $cname; ?></h4>
                                <p><?php echo $cloc ?: 'Rashtrotthana Yoga Centre'; ?></p>
                            </div>
                            <button type="button" class="ry-fg-card-btn">
                                Select & Open Form
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div><!-- /#step-select -->

            <!-- Countdown Redirect Screen (Step 2 - Redirect Mode) -->
            <div class="ry-fg-countdown-screen" id="ry-fg-countdown-<?php echo esc_attr( $group_id ); ?>">
                <h3 style="margin:0 0 6px;color:#0f172a;font-size:20px;">
                    Redirecting to <span id="ry-fg-centre-name-<?php echo esc_attr( $group_id ); ?>">Google Form</span>…
                </h3>
                <p style="margin:0;color:#64748b;font-size:14px;">
                    Taking you directly to the official Google Form in <strong id="ry-fg-timer-<?php echo esc_attr( $group_id ); ?>" style="color:#2563eb;">3</strong> seconds.
                </p>

                <div class="ry-fg-progress-bar">
                    <div class="ry-fg-progress-fill" id="ry-fg-pfill-<?php echo esc_attr( $group_id ); ?>"></div>
                </div>

                <div style="display:flex;align-items:center;justify-content:center;gap:14px;flex-wrap:wrap;">
                    <button type="button" class="ry-fg-back-btn" id="ry-fg-back-btn-<?php echo esc_attr( $group_id ); ?>">
                        ← Choose Different Centre
                    </button>
                    <a href="" id="ry-fg-direct-link-<?php echo esc_attr( $group_id ); ?>" class="ry-fg-card-btn" style="text-decoration:none;">
                        Click here if not redirected
                    </a>
                </div>
            </div>

            <!-- Embedded Iframe Screen (Step 2 - Embed Mode) -->
            <div class="ry-fg-iframe-container" id="ry-fg-iframe-wrap-<?php echo esc_attr( $group_id ); ?>">
                <div class="ry-fg-iframe-topbar">
                    <button type="button" class="ry-fg-back-btn" id="ry-fg-embed-back-btn-<?php echo esc_attr( $group_id ); ?>">
                        ← Change Centre
                    </button>
                    <strong style="font-size:13px;color:#334155;" id="ry-fg-embed-title-<?php echo esc_attr( $group_id ); ?>">Form</strong>
                </div>
                <iframe src="" class="ry-fg-iframe-frame" id="ry-fg-iframe-<?php echo esc_attr( $group_id ); ?>" title="Google Form"></iframe>
            </div>

        </div>
    </div>

    <script>
    (function() {
        const appId      = '<?php echo esc_attr( $group_id ); ?>';
        const ajaxUrl    = '<?php echo esc_url( $ajax_url ); ?>';
        const actionMode = '<?php echo esc_js( $action_mode ); ?>';

        const stepSelect = document.getElementById('ry-fg-step-select-' + appId);
        const searchInput= document.getElementById('ry-fg-filter-' + appId);
        const dropdown   = document.getElementById('ry-fg-dropdown-' + appId);
        const cardsWrap  = document.getElementById('ry-fg-cards-' + appId);

        const cdScreen   = document.getElementById('ry-fg-countdown-' + appId);
        const cdName     = document.getElementById('ry-fg-centre-name-' + appId);
        const cdTimer    = document.getElementById('ry-fg-timer-' + appId);
        const pFill      = document.getElementById('ry-fg-pfill-' + appId);
        const backBtn    = document.getElementById('ry-fg-back-btn-' + appId);
        const directLink = document.getElementById('ry-fg-direct-link-' + appId);

        const embedWrap  = document.getElementById('ry-fg-iframe-wrap-' + appId);
        const embedBack  = document.getElementById('ry-fg-embed-back-btn-' + appId);
        const embedTitle = document.getElementById('ry-fg-embed-title-' + appId);
        const embedFrame = document.getElementById('ry-fg-iframe-' + appId);

        let countdownInterval = null;

        // Search Filter
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const q = this.value.toLowerCase().trim();
                if (cardsWrap) {
                    const cards = cardsWrap.querySelectorAll('.ry-fg-card');
                    cards.forEach(c => {
                        const name = c.getAttribute('data-name') || '';
                        c.style.display = name.includes(q) ? 'flex' : 'none';
                    });
                }
                if (dropdown) {
                    const opts = dropdown.options;
                    for (let i = 0; i < opts.length; i++) {
                        if (!opts[i].value) continue;
                        const txt = opts[i].text.toLowerCase();
                        opts[i].style.display = txt.includes(q) ? '' : 'none';
                    }
                }
            });
        }

        // Track Click Analytics
        function trackClick(centreId) {
            if (!centreId) return;
            const body = new FormData();
            body.append('action', 'radm_track_form_group_click');
            body.append('group_id', appId);
            body.append('centre_id', centreId);
            fetch(ajaxUrl, { method: 'POST', body: body }).catch(() => {});
        }

        // Handle Selection Action
        function handleSelection(centreId, centreName, formUrl) {
            if (!formUrl) return;

            trackClick(centreId);

            if (actionMode === 'redirect') {
                stepSelect.style.display = 'none';
                cdScreen.style.display   = 'block';
                if (cdName) cdName.textContent = centreName;
                if (directLink) directLink.href = formUrl;

                let timeLeft = 3;
                if (cdTimer) cdTimer.textContent = timeLeft;
                if (pFill) pFill.style.width = '0%';

                let progress = 0;
                clearInterval(countdownInterval);

                countdownInterval = setInterval(() => {
                    progress += 3.33;
                    if (pFill) pFill.style.width = progress + '%';

                    if (progress >= 33 && progress < 66) {
                        if (cdTimer) cdTimer.textContent = '2';
                    } else if (progress >= 66 && progress < 99) {
                        if (cdTimer) cdTimer.textContent = '1';
                    } else if (progress >= 100) {
                        clearInterval(countdownInterval);
                        window.location.href = formUrl;
                    }
                }, 100);

            } else {
                // Embed Mode
                stepSelect.style.display = 'none';
                if (embedWrap) embedWrap.style.display = 'block';
                if (embedTitle) embedTitle.textContent = centreName + ' Google Form';

                let embedUrl = formUrl;
                if (!embedUrl.includes('embedded=true')) {
                    embedUrl += (embedUrl.includes('?') ? '&' : '?') + 'embedded=true';
                }
                if (embedFrame) embedFrame.src = embedUrl;
            }
        }

        // Event delegation for Cards Grid
        if (cardsWrap) {
            cardsWrap.addEventListener('click', function(e) {
                const card = e.target.closest('.ry-fg-card');
                if (!card) return;
                const cid   = card.getAttribute('data-id');
                const cname = card.querySelector('h4') ? card.querySelector('h4').textContent : '';
                const curl  = card.getAttribute('data-url');
                handleSelection(cid, cname, curl);
            });
        }

        // Dropdown Select
        if (dropdown) {
            dropdown.addEventListener('change', function() {
                const opt = dropdown.options[dropdown.selectedIndex];
                if (!opt || !opt.value) return;
                const cid   = opt.value;
                const cname = opt.getAttribute('data-name');
                const curl  = opt.getAttribute('data-url');
                handleSelection(cid, cname, curl);
            });
        }

        // Reset & Go Back Buttons
        function resetSelection() {
            clearInterval(countdownInterval);
            if (cdScreen) cdScreen.style.display = 'none';
            if (embedWrap) embedWrap.style.display = 'none';
            if (stepSelect) stepSelect.style.display = 'block';
            if (dropdown) dropdown.value = '';
        }

        if (backBtn)   backBtn.addEventListener('click', resetSelection);
        if (embedBack) embedBack.addEventListener('click', resetSelection);
    })();
    </script>
    <?php
    return ob_get_clean();
}

/**
 * Handle Direct Share Link for Form Groups
 * Accessible via: /forms/slug/ or ?ry_form_group=slug_or_id
 */
add_action( 'template_redirect', 'radm_handle_direct_form_group_link' );

function radm_handle_direct_form_group_link(): void {
    $search_key = sanitize_key( $_GET['ry_form_group'] ?? $_GET['form_group'] ?? '' );
    if ( ! $search_key ) {
        return;
    }

    $all_groups = get_option( 'radm_form_groups', [] );
    if ( ! is_array( $all_groups ) ) {
        wp_die( 'Form Group not found or link has expired.', 'Form Not Found', [ 'response' => 404 ] );
    }

    $group = null;
    $group_id = null;
    foreach ( $all_groups as $gid => $gdata ) {
        if ( $gid === $search_key || ( isset( $gdata['slug'] ) && $gdata['slug'] === $search_key ) ) {
            $group    = $gdata;
            $group_id = $gid;
            break;
        }
    }

    if ( ! $group || ! $group_id ) {
        wp_die( 'Form Group not found or link has expired.', 'Form Not Found', [ 'response' => 404 ] );
    }

    status_header( 200 );
    header( 'Content-Type: text/html; charset=utf-8' );

    $content = radm_shortcode_form_group( [ 'id' => $group_id ] );
    $title   = esc_html( $group['title'] ?? 'Registration Form' );
    ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?> — Rashtrotthana Yoga</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                margin: 0;
                padding: 24px 16px 40px;
                background: #f1f5f9;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            }
            .ry-standalone-brand {
                text-align: center;
                margin-bottom: 24px;
            }
            .ry-standalone-brand strong {
                font-size: 20px;
                letter-spacing: 1px;
                color: #1b365d;
                font-weight: 800;
            }
        </style>
        <?php wp_head(); ?>
    </head>
    <body>
        <div class="ry-standalone-brand">
            <strong>RASHTROTTHANA YOGA</strong>
        </div>

        <?php echo $content; ?>

        <?php wp_footer(); ?>
    </body>
    </html>
    <?php
    exit;
}
