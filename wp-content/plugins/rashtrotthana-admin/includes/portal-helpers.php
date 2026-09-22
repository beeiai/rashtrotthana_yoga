<?php
/**
 * Rashtrotthana Admin Portal — Shared Layout Helpers
 * Included once via admin-init.php. Safe to call from any page.
 **/

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Outputs the full portal shell: sidebar + header + opens .radm-content.
 * Call radm_portal_footer() to close it.
 */
function radm_portal_header( string $page_title, string $page_subtitle ): void { ?>
<div class="radm-portal">

    <!-- ░░ SIDEBAR ░░ -->
    <aside class="radm-sidebar">

        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-dashboard' ) ); ?>" class="radm-logo">
            <div class="radm-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C12 2 7 6 7 11C7 13.76 9.24 16 12 16C14.76 16 17 13.76 17 11C17 6 12 2 12 2Z" fill="white" opacity=".9"/>
                    <path d="M12 16C12 16 8 17 6 20H18C16 17 12 16 12 16Z" fill="white" opacity=".7"/>
                    <circle cx="12" cy="10" r="2" fill="white"/>
                </svg>
            </div>
            <div class="radm-logo-text">
                <strong>RASHTROTTHANA<br>YOGA</strong>
            </div>
        </a>

        <nav class="radm-nav">
            <?php
            $nav = [
                [ 'page' => 'radm-dashboard',     'label' => 'Dashboard',               'icon' => '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>' ],
                [ 'page' => 'radm-registrations', 'label' => 'Registrations',           'icon' => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>' ],
                [ 'page' => 'radm-form-groups',   'label' => 'Form Groups',             'icon' => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>' ],
                [ 'page' => 'radm-whatsapp',      'label' => 'WhatsApp (WATI)',         'icon' => '<path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>' ],
                [ 'page' => 'radm-roles',         'label' => 'Roles & Responsibilities','icon' => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>' ],
                [ 'page' => 'radm-settings',      'label' => 'Settings',               'icon' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>' ],
            ];
            $current = sanitize_key( $_GET['page'] ?? 'radm-dashboard' );
            foreach ( $nav as $item ) :
                $active = $current === $item['page'] ? ' active' : '';
            ?>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $item['page'] ) ); ?>"
               class="radm-nav-item<?php echo $active; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <?php echo $item['icon']; ?>
                </svg>
                <?php echo esc_html( $item['label'] ); ?>
            </a>
            <?php endforeach; ?>
        </nav>

        <div class="radm-sidebar-footer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s-8-4.5-8-11.8A8 8 0 0112 2a8 8 0 018 8.2c0 7.3-8 11.8-8 11.8z"/>
                <circle cx="12" cy="10" r="3"/>
            </svg>
            <span>Yoga for a<br>Better Tomorrow</span>
        </div>

    </aside>

    <!-- ░░ MAIN ░░ -->
    <main class="radm-main">

        <header class="radm-header">
            <div class="radm-header-left">
                <h1><?php echo esc_html( $page_title ); ?></h1>
                <p><?php echo esc_html( $page_subtitle ); ?></p>
            </div>
            <div class="radm-header-right">
                <span class="radm-header-date" id="radm-date"></span>
                <button class="radm-notif-btn" title="Notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 01-3.46 0"/>
                    </svg>
                    <span class="radm-notif-dot"></span>
                </button>
                <div class="radm-user-pill">
                    <div class="radm-user-avatar" id="radm-user-avatar">A</div>
                    <span id="radm-user-name">Admin</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>
            </div>
        </header>

        <div class="radm-content">
<?php }

function radm_portal_footer(): void { ?>
        </div><!-- /.radm-content -->
    </main>
</div><!-- /.radm-portal -->
<?php }
