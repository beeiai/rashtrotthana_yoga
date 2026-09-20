<?php
/**
 * Rashtrotthana Admin Portal — Menu Registration & Asset Loading
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

// Shared layout helpers (sidebar, header, footer wrappers)
require_once __DIR__ . '/portal-helpers.php';

// AJAX handlers (events CRUD, participants CRUD, stats, CSV export, form groups)
require_once __DIR__ . '/ajax-handlers.php';

// Shortcodes (form-group)
require_once RADM_PLUGIN_DIR . 'shortcodes/form-group.php';

// ── Menu Registration ─────────────────────────────────────────────────────────
function radm_register_menu(): void {
    add_menu_page(
        'Rashtrotthana Portal',
        'Rashtrotthana',
        'manage_options',
        'radm-dashboard',
        'radm_page_dashboard',
        'none',
        2
    );

    $pages = [
        [ 'radm-dashboard',     'Dashboard',               'radm_page_dashboard'     ],
        [ 'radm-registrations', 'Registrations',           'radm_page_registrations' ],
        [ 'radm-form-groups',   'Form Groups',             'radm_page_form_groups'   ],
        [ 'radm-whatsapp',      'WhatsApp (WATI)',          'radm_page_whatsapp'      ],
        [ 'radm-roles',         'Roles & Responsibilities', 'radm_page_roles'         ],
        [ 'radm-settings',      'Settings',                'radm_page_settings'      ],
    ];

    foreach ( $pages as [ $slug, $title, $callback ] ) {
        add_submenu_page( 'radm-dashboard', $title, $title, 'manage_options', $slug, $callback );
    }
}
add_action( 'admin_menu', 'radm_register_menu' );

// ── Asset Enqueueing ──────────────────────────────────────────────────────────
function radm_enqueue_assets( string $hook ): void {
    $our_hooks = [
        'toplevel_page_radm-dashboard',
        'rashtrotthana_page_radm-registrations',
        'rashtrotthana_page_radm-form-groups',
        'rashtrotthana_page_radm-whatsapp',
        'rashtrotthana_page_radm-roles',
        'rashtrotthana_page_radm-settings',
    ];

    if ( ! in_array( $hook, $our_hooks, true ) ) {
        return;
    }

    wp_enqueue_style(
        'radm-inter-font',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'radm-portal',
        RADM_PLUGIN_URL . 'assets/css/admin-portal.css',
        [ 'radm-inter-font' ],
        RADM_VERSION
    );
    wp_enqueue_script(
        'radm-portal',
        RADM_PLUGIN_URL . 'assets/js/admin-portal.js',
        [],
        RADM_VERSION,
        true
    );
    wp_localize_script( 'radm-portal', 'RADMConfig', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'radm_nonce' ),
        'page'    => sanitize_key( $_GET['page'] ?? 'radm-dashboard' ),
        'user'    => wp_get_current_user()->display_name,
    ] );
}
add_action( 'admin_enqueue_scripts', 'radm_enqueue_assets' );

// ── Body Class ────────────────────────────────────────────────────────────────
function radm_body_class( string $classes ): string {
    $screen = get_current_screen();
    if ( $screen && strpos( $screen->id, 'radm-' ) !== false ) {
        $classes .= ' radm-portal-active';
    }
    return $classes;
}
add_filter( 'admin_body_class', 'radm_body_class' );

// ── Page Callbacks ────────────────────────────────────────────────────────────
function radm_page_dashboard():     void { require RADM_PLUGIN_DIR . 'pages/dashboard.php';     }
function radm_page_registrations(): void { require RADM_PLUGIN_DIR . 'pages/registrations.php'; }
function radm_page_form_groups():   void { require RADM_PLUGIN_DIR . 'pages/form-groups.php';   }
function radm_page_whatsapp():      void { require RADM_PLUGIN_DIR . 'pages/whatsapp.php';      }
function radm_page_roles():         void { require RADM_PLUGIN_DIR . 'pages/roles.php';         }
function radm_page_settings():      void { require RADM_PLUGIN_DIR . 'pages/settings.php';      }
