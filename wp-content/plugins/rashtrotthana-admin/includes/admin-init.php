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

// Shortcodes (ongoing-events)
require_once RADM_PLUGIN_DIR . 'shortcodes/ongoing-events.php';

// ── Roles Initialization ───────────────────────────────────────────────────────
function radm_create_roles(): void {
    // Admin Role (Can manage content and registrations, but NOT options/roles)
    if ( ! get_role( 'radm_admin' ) ) {
        add_role( 'radm_admin', 'Portal Admin', [
            'read'                      => true,
            'edit_posts'                => true,
            'edit_pages'                => true,
            'edit_others_posts'         => true,
            'edit_others_pages'         => true,
            'manage_ry_registrations'   => true, // Custom cap for registrations
            'upload_files'              => true,
        ] );
    }

    // Gallery Management Role (Can only upload files and read)
    if ( ! get_role( 'radm_gallery' ) ) {
        add_role( 'radm_gallery', 'Gallery Manager', [
            'read'                      => true,
            'upload_files'              => true,
        ] );
    }
}
add_action( 'admin_init', 'radm_create_roles' );

// ── Menu Registration ────────────────────────────────────────────────────────
function radm_register_menu(): void {
    // Base capability for the portal is manage_ry_registrations (Admins & Super Admins)
    add_menu_page(
        'Rashtrotthana Portal',
        'Rashtrotthana',
        'manage_ry_registrations',
        'radm-dashboard',
        'radm_page_dashboard',
        'none',
        2
    );

    $pages = [
        [ 'radm-dashboard',     'Dashboard',               'manage_ry_registrations', 'radm_page_dashboard'     ],
        [ 'radm-registrations', 'Registrations',           'manage_ry_registrations', 'radm_page_registrations' ],
        [ 'radm-form-groups',   'Form Groups',             'manage_ry_registrations', 'radm_page_form_groups'   ],
        [ 'radm-whatsapp',      'WhatsApp (WATI)',         'manage_ry_registrations', 'radm_page_whatsapp'      ],
        [ 'radm-roles',         'Roles & Responsibilities','manage_options',          'radm_page_roles'         ],
        [ 'radm-settings',      'Settings',                'manage_options',          'radm_page_settings'      ],
    ];

    foreach ( $pages as [ $slug, $title, $cap, $callback ] ) {
        add_submenu_page( 'radm-dashboard', $title, $title, $cap, $slug, $callback );
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
