<?php
/**
 * Frontend Shortcode & Modal for Form Groups: [ry_form_group id="X" text="Register Now"]
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_shortcode( 'ry_form_group', 'ry_shortcode_form_group' );

function ry_shortcode_form_group( $atts ): string {
    $atts = shortcode_atts( [
        'id'    => 0,
        'text'  => 'Register Now',
        'class' => '',
    ], $atts, 'ry_form_group' );

    $group_id = absint( $atts['id'] );
    if ( ! $group_id ) {
        return '';
    }

    $btn_text = esc_html( $atts['text'] );
    $extra_cls = esc_attr( $atts['class'] );

    return sprintf(
        '<button type="button" class="rs-btn rs-btn-primary ry-open-form-group-btn %s" data-form-group-id="%d">%s</button>',
        $extra_cls,
        $group_id,
        $btn_text
    );
}

/**
 * Handle Direct Shareable Link (e.g. for WhatsApp, Posters, QR Codes)
 * Accessible via: ?ry_form_group=1 or ?fg=1
 */
add_action( 'template_redirect', 'ry_handle_direct_form_group_landing' );
function ry_handle_direct_form_group_landing(): void {
    $fg_id = absint( $_GET['ry_form_group'] ?? $_GET['fg'] ?? 0 );
    if ( ! $fg_id ) {
        return;
    }

    require_once RADM_PLUGIN_DIR . 'includes/class-form-groups-db.php';
    $group = RADM_Form_Groups_DB::get( $fg_id );

    if ( ! $group || $group['status'] !== 'active' ) {
        wp_die(
            '<div style="font-family:sans-serif;text-align:center;padding:50px 20px;">'
            . '<h2 style="color:#0f172a;">Registration Unavailable</h2>'
            . '<p style="color:#64748b;">This registration form is currently closed or inactive.</p>'
            . '<a href="' . esc_url( home_url( '/' ) ) . '" style="display:inline-block;margin-top:15px;color:#2E7D32;font-weight:600;text-decoration:none;">&larr; Back to Home</a>'
            . '</div>',
            'Registration Closed',
            [ 'response' => 404 ]
        );
    }

    $centers = $group['centers'] ?? [];
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo esc_html( $group['name'] ); ?> — Rashtrotthana Yoga</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            body {
                font-family: 'Inter', -apple-system, sans-serif;
                background: #f8fafc;
                color: #0f172a;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 24px 16px;
            }
            .ry-direct-card {
                background: #ffffff;
                width: 100%;
                max-width: 480px;
                border-radius: 18px;
                box-shadow: 0 20px 40px -10px rgba(0,0,0,0.08), 0 1px 3px rgba(0,0,0,0.05);
                overflow: hidden;
                border: 1px solid #e2e8f0;
            }
            .ry-direct-header {
                padding: 28px 24px 20px;
                border-bottom: 1px solid #f1f5f9;
                text-align: center;
                background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);
            }
            .ry-direct-badge {
                display: inline-block;
                background: #e8f5e9;
                color: #2E7D32;
                font-size: 12px;
                font-weight: 700;
                padding: 4px 12px;
                border-radius: 20px;
                margin-bottom: 10px;
                letter-spacing: 0.5px;
                text-transform: uppercase;
            }
            .ry-direct-title {
                font-size: 20px;
                font-weight: 700;
                color: #0f172a;
                margin-bottom: 6px;
                line-height: 1.3;
            }
            .ry-direct-desc {
                font-size: 13.5px;
                color: #64748b;
                line-height: 1.45;
            }
            .ry-direct-body {
                padding: 24px;
            }
            .ry-direct-prompt {
                font-size: 14px;
                font-weight: 600;
                color: #334155;
                margin-bottom: 14px;
            }
            .ry-direct-options {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            .ry-direct-opt {
                display: flex;
                align-items: center;
                gap: 14px;
                padding: 14px 16px;
                border: 2px solid #e2e8f0;
                border-radius: 12px;
                cursor: pointer;
                transition: all 0.18s ease;
                background: #ffffff;
            }
            .ry-direct-opt:hover {
                border-color: #94a3b8;
                background: #f8fafc;
            }
            .ry-direct-opt.is-selected {
                border-color: #2E7D32;
                background: #f0fdf4;
            }
            .ry-direct-opt input[type="radio"] {
                appearance: none;
                width: 20px;
                height: 20px;
                border: 2px solid #cbd5e1;
                border-radius: 50%;
                outline: none;
                margin: 0;
                display: grid;
                place-content: center;
                flex-shrink: 0;
            }
            .ry-direct-opt input[type="radio"]::before {
                content: "";
                width: 10px;
                height: 10px;
                border-radius: 50%;
                transform: scale(0);
                transition: 0.15s transform ease;
                background: #2E7D32;
            }
            .ry-direct-opt input[type="radio"]:checked {
                border-color: #2E7D32;
            }
            .ry-direct-opt input[type="radio"]:checked::before {
                transform: scale(1);
            }
            .ry-direct-opt-text {
                font-size: 15px;
                font-weight: 600;
                color: #1e293b;
                flex-grow: 1;
            }
            .ry-direct-footer {
                padding: 16px 24px 24px;
            }
            .ry-direct-btn {
                background: #2E7D32;
                color: #ffffff;
                font-size: 15px;
                font-weight: 600;
                border: none;
                border-radius: 10px;
                padding: 13px 20px;
                width: 100%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                transition: all 0.18s ease;
                box-shadow: 0 4px 12px rgba(46, 125, 50, 0.25);
            }
            .ry-direct-btn:hover:not(:disabled) {
                background: #256628;
                transform: translateY(-1px);
            }
            .ry-direct-btn:disabled {
                background: #94a3b8;
                box-shadow: none;
                cursor: not-allowed;
                opacity: 0.6;
            }
            .ry-direct-brand {
                text-align: center;
                margin-top: 18px;
                font-size: 12px;
                color: #94a3b8;
            }
        </style>
    </head>
    <body>
        <div class="ry-direct-card">
            <div class="ry-direct-header">
                <span class="ry-direct-badge">Official Registration</span>
                <h1 class="ry-direct-title"><?php echo esc_html( $group['name'] ); ?></h1>
                <?php if ( ! empty( $group['description'] ) ) : ?>
                    <p class="ry-direct-desc"><?php echo esc_html( $group['description'] ); ?></p>
                <?php endif; ?>
            </div>

            <div class="ry-direct-body">
                <p class="ry-direct-prompt">Select Your Center to proceed:</p>
                <div class="ry-direct-options" id="ry-direct-opts">
                    <?php foreach ( $centers as $idx => $c ) : ?>
                        <label class="ry-direct-opt <?php echo $idx === 0 ? 'is-selected' : ''; ?>" data-url="<?php echo esc_url( $c['form_url'] ); ?>">
                            <input type="radio" name="direct_center" value="<?php echo esc_attr( $idx ); ?>" <?php checked( $idx, 0 ); ?> />
                            <span class="ry-direct-opt-text"><?php echo esc_html( $c['center_name'] ); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="ry-direct-footer">
                <button type="button" class="ry-direct-btn" id="ry-direct-submit">
                    Continue to Registration Form &rarr;
                </button>
            </div>
        </div>

        <div class="ry-direct-brand">
            &copy; <?php echo date('Y'); ?> Rashtrotthana Yoga. All rights reserved.
        </div>

        <script>
            (function() {
                var options = document.querySelectorAll('.ry-direct-opt');
                var submitBtn = document.getElementById('ry-direct-submit');
                var selectedUrl = "<?php echo !empty($centers[0]['form_url']) ? esc_url($centers[0]['form_url']) : ''; ?>";

                options.forEach(function(opt) {
                    opt.addEventListener('click', function() {
                        options.forEach(function(o) { o.classList.remove('is-selected'); });
                        this.classList.add('is-selected');
                        var radio = this.querySelector('input[type="radio"]');
                        if (radio) radio.checked = true;
                        selectedUrl = this.dataset.url;
                        if (submitBtn) submitBtn.disabled = !selectedUrl;
                    });
                });

                if (submitBtn) {
                    submitBtn.addEventListener('click', function() {
                        if (selectedUrl) {
                            window.location.href = selectedUrl;
                        }
                    });
                }
            })();
        </script>
    </body>
    </html>
    <?php
    exit;
}

/**
 * Render the global Center Selection Modal in wp_footer on the frontend
 */
add_action( 'wp_footer', 'ry_render_form_group_center_modal' );
function ry_render_form_group_center_modal(): void {
    if ( is_admin() ) {
        return;
    }
    ?>
    <!-- ── Center Selection Modal (User Side) ── -->
    <div class="ry-fg-modal-overlay" id="ry-fg-center-modal" aria-hidden="true" style="display: none;">
        <div class="ry-fg-modal" role="dialog" aria-modal="true" aria-labelledby="ry-fg-modal-title">
            <div class="ry-fg-modal-header">
                <div>
                    <h3 class="ry-fg-modal-title" id="ry-fg-modal-title">Select Your Center</h3>
                    <p class="ry-fg-modal-subtitle" id="ry-fg-modal-subtitle">Please select your center to proceed to the registration form.</p>
                </div>
                <button type="button" class="ry-fg-modal-close" id="ry-fg-modal-close-btn" aria-label="Close modal">×</button>
            </div>

            <div class="ry-fg-modal-body">
                <div class="ry-fg-loading" id="ry-fg-modal-loading" style="display: none;">
                    <div class="ry-fg-spinner"></div>
                    <p>Loading centers...</p>
                </div>

                <div class="ry-fg-error-msg" id="ry-fg-modal-error" style="display: none;"></div>

                <div class="ry-fg-centers-list" id="ry-fg-centers-container">
                    <!-- Dynamic Radio options populated via JS -->
                </div>
            </div>

            <div class="ry-fg-modal-footer">
                <button type="button" class="ry-fg-btn-continue" id="ry-fg-continue-btn" disabled>
                    Continue
                </button>
            </div>
        </div>
    </div>

    <style>
    .ry-fg-modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.22s ease, visibility 0.22s ease;
    }
    .ry-fg-modal-overlay.is-active {
        opacity: 1;
        visibility: visible;
        display: flex !important;
    }
    .ry-fg-modal {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 460px;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.22), 0 0 0 1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        animation: ryFgPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes ryFgPop {
        0% { transform: scale(0.94) translateY(8px); opacity: 0; }
        100% { transform: scale(1) translateY(0); opacity: 1; }
    }
    .ry-fg-modal-header {
        padding: 22px 24px 16px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    .ry-fg-modal-title {
        font-family: 'Inter', -apple-system, sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px;
        line-height: 1.25;
    }
    .ry-fg-modal-subtitle {
        font-family: 'Inter', -apple-system, sans-serif;
        font-size: 13px;
        color: #64748b;
        margin: 0;
        line-height: 1.4;
    }
    .ry-fg-modal-close {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #64748b;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 20px;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
        padding: 0;
        flex-shrink: 0;
    }
    .ry-fg-modal-close:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #dc2626;
    }
    .ry-fg-modal-body {
        padding: 20px 24px;
        max-height: 360px;
        overflow-y: auto;
    }
    .ry-fg-loading {
        text-align: center;
        padding: 30px 10px;
        color: #64748b;
        font-size: 14px;
    }
    .ry-fg-spinner {
        width: 30px;
        height: 30px;
        border: 3px solid #e2e8f0;
        border-top-color: #2E7D32;
        border-radius: 50%;
        margin: 0 auto 10px;
        animation: ryFgSpin 0.75s linear infinite;
    }
    @keyframes ryFgSpin {
        to { transform: rotate(360deg); }
    }
    .ry-fg-error-msg {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 12px 14px;
        border-radius: 10px;
        font-size: 13.5px;
        line-height: 1.4;
    }
    .ry-fg-centers-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .ry-fg-center-option {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.18s ease;
        background: #ffffff;
    }
    .ry-fg-center-option:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
    }
    .ry-fg-center-option input[type="radio"] {
        appearance: none;
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        border: 2px solid #cbd5e1;
        border-radius: 50%;
        outline: none;
        margin: 0;
        display: grid;
        place-content: center;
        transition: all 0.18s ease;
        flex-shrink: 0;
        cursor: pointer;
    }
    .ry-fg-center-option input[type="radio"]::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        transform: scale(0);
        transition: 0.15s transform ease-in-out;
        background-color: #2E7D32;
    }
    .ry-fg-center-option input[type="radio"]:checked {
        border-color: #2E7D32;
    }
    .ry-fg-center-option input[type="radio"]:checked::before {
        transform: scale(1);
    }
    .ry-fg-center-option.is-selected {
        border-color: #2E7D32;
        background: #f0fdf4;
    }
    .ry-fg-center-name {
        font-family: 'Inter', -apple-system, sans-serif;
        font-size: 14.5px;
        font-weight: 600;
        color: #1e293b;
        flex-grow: 1;
    }
    .ry-fg-modal-footer {
        padding: 14px 24px 22px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
    }
    .ry-fg-btn-continue {
        background: #2E7D32;
        color: #ffffff;
        font-family: 'Inter', -apple-system, sans-serif;
        font-size: 14px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        cursor: pointer;
        width: 100%;
        transition: all 0.18s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .ry-fg-btn-continue:hover:not(:disabled) {
        background: #256628;
    }
    .ry-fg-btn-continue:disabled {
        background: #94a3b8;
        cursor: not-allowed;
        opacity: 0.65;
    }
    </style>

    <script>
    (function() {
        var ajaxUrl = "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>";
        var modalEl = document.getElementById('ry-fg-center-modal');
        var modalTitle = document.getElementById('ry-fg-modal-title');
        var modalSub = document.getElementById('ry-fg-modal-subtitle');
        var loadingEl = document.getElementById('ry-fg-modal-loading');
        var errorEl = document.getElementById('ry-fg-modal-error');
        var listEl = document.getElementById('ry-fg-centers-container');
        var continueBtn = document.getElementById('ry-fg-continue-btn');
        var closeBtn = document.getElementById('ry-fg-modal-close-btn');

        var currentCenters = [];
        var selectedUrl = '';

        function openModal(groupId) {
            if (!modalEl) return;
            selectedUrl = '';
            currentCenters = [];
            continueBtn.disabled = true;
            errorEl.style.display = 'none';
            errorEl.textContent = '';
            listEl.innerHTML = '';
            loadingEl.style.display = 'block';

            modalEl.classList.add('is-active');
            modalEl.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            fetch(ajaxUrl + '?action=ry_get_public_form_group&id=' + encodeURIComponent(groupId))
                .then(function(r) { return r.json(); })
                .then(function(res) {
                    loadingEl.style.display = 'none';
                    if (!res.success) {
                        errorEl.textContent = (res.data && res.data.message) || 'Unable to load registration form.';
                        errorEl.style.display = 'block';
                        return;
                    }

                    var data = res.data;
                    if (data.name) {
                        modalTitle.textContent = 'Select Your Center';
                        modalSub.textContent = 'Please select your center to proceed to ' + data.name + '.';
                    }

                    currentCenters = data.centers || [];
                    if (!currentCenters.length) {
                        errorEl.textContent = 'No centers configured for this form group.';
                        errorEl.style.display = 'block';
                        return;
                    }

                    var html = '';
                    currentCenters.forEach(function(c, idx) {
                        html += '<label class="ry-fg-center-option" data-url="' + encodeURI(c.form_url) + '">'
                            + '<input type="radio" name="ry_selected_center" value="' + idx + '" />'
                            + '<span class="ry-fg-center-name">' + escHtml(c.center_name) + '</span>'
                            + '</label>';
                    });

                    listEl.innerHTML = html;

                    // Attach radio listeners
                    var options = listEl.querySelectorAll('.ry-fg-center-option');
                    options.forEach(function(opt) {
                        opt.addEventListener('click', function() {
                            options.forEach(function(o) { o.classList.remove('is-selected'); });
                            this.classList.add('is-selected');
                            var radio = this.querySelector('input[type="radio"]');
                            if (radio) radio.checked = true;
                            selectedUrl = this.dataset.url;
                            continueBtn.disabled = !selectedUrl;
                        });
                    });
                })
                .catch(function() {
                    loadingEl.style.display = 'none';
                    errorEl.textContent = 'Network error. Please try again.';
                    errorEl.style.display = 'block';
                });
        }

        function closeModal() {
            if (!modalEl) return;
            modalEl.classList.remove('is-active');
            modalEl.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        function escHtml(str) {
            var div = document.createElement('div');
            div.textContent = str || '';
            return div.innerHTML;
        }

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (modalEl) {
            modalEl.addEventListener('click', function(e) {
                if (e.target === modalEl) closeModal();
            });
        }

        if (continueBtn) {
            continueBtn.addEventListener('click', function() {
                if (selectedUrl) {
                    window.open(selectedUrl, '_blank');
                    closeModal();
                }
            });
        }

        // Global delegation for any register button
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('[data-form-group-id], [data-ry-form-group], .ry-open-form-group-btn');
            if (btn) {
                e.preventDefault();
                var gid = btn.dataset.formGroupId || btn.dataset.ryFormGroup || btn.getAttribute('data-form-group-id');
                if (gid) {
                    openModal(gid);
                }
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modalEl && modalEl.classList.contains('is-active')) {
                closeModal();
            }
        });

        window.ryOpenFormGroupModal = openModal;
    })();
    </script>
    <?php
}
