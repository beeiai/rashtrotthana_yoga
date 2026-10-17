<?php
/**
 * Rashtrotthana Admin Portal — Shared Layout & Permission Helpers
 * Included once via admin-init.php. Safe to call from any page.
 **/

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Returns all available portal modules with metadata
 */
function radm_get_all_modules(): array {
    return [
        'dashboard'     => [
            'slug'   => 'radm-dashboard',
            'label'  => 'Dashboard',
            'icon'   => '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
            'desc'   => 'Overview, quick stats & recent activity',
        ],
        'registrations' => [
            'slug'   => 'radm-registrations',
            'label'  => 'Registrations',
            'icon'   => '<path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>',
            'desc'   => 'Participant submissions, statuses & CSV exports',
        ],
        'gallery'       => [
            'slug'   => 'radm-gallery',
            'label'  => 'Gallery',
            'icon'   => '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>',
            'desc'   => 'Photos, videos & media management',
        ],
        'form-groups'   => [
            'slug'   => 'radm-form-groups',
            'label'  => 'Form Groups',
            'icon'   => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>',
            'desc'   => 'Single registration link with center Google forms',
        ],
        'whatsapp'      => [
            'slug'   => 'radm-whatsapp',
            'label'  => 'WhatsApp (WATI)',
            'icon'   => '<path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>',
            'desc'   => 'WhatsApp templates, messaging & broadcasts',
        ],
        'roles'         => [
            'slug'   => 'radm-roles',
            'label'  => 'Roles & Responsibilities',
            'icon'   => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>',
            'desc'   => 'Staff roles, access permissions & center scopes',
        ],
                'pages'         => [
            'slug'   => 'radm-pages',
            'label'  => 'Content Pages',
            'icon'   => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>',
            'desc'   => 'Centers, Activities, News & More',
        ],
        'settings'      => [
            'slug'   => 'radm-settings',
            'label'  => 'Settings',
            'icon'   => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>',
            'desc'   => 'System configurations & integration keys',
        ],
    ];
}

/**
 * Returns managed centers list (Settings -> Centers Management & Dropdowns)
 * Dynamically queries the real centers from the database (rs_center / center)
 */
function radm_get_centers_list(): array {
    // 1. Fetch real centers directly from the database CPT (rs_center / center)
    $cpt_centers = get_posts( [
        'post_type'      => [ 'rs_center', 'center' ],
        'post_status'    => [ 'publish', 'draft' ],
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ] );

    if ( ! empty( $cpt_centers ) ) {
        $saved = get_option( 'radm_centers_list', [] );
        $saved_status = [];
        if ( is_array( $saved ) ) {
            foreach ( $saved as $s ) {
                if ( ! empty( $s['id'] ) && isset( $s['status'] ) ) {
                    $saved_status[ (string) $s['id'] ] = $s['status'];
                }
                if ( ! empty( $s['name'] ) && isset( $s['status'] ) ) {
                    $saved_status[ strtolower( trim( $s['name'] ) ) ] = $s['status'];
                }
            }
        }

        $list = [];
        foreach ( $cpt_centers as $c ) {
            $cid  = (string) $c->ID;
            $name = $c->post_title;
            $norm = strtolower( trim( $name ) );
            $loc  = get_post_meta( $c->ID, 'area', true )
                ?: ( get_post_meta( $c->ID, 'center_location', true )
                ?: ( get_post_meta( $c->ID, 'zone', true ) ?: 'Bangalore' ) );

            $status = ( $c->post_status === 'publish' ) ? 'active' : 'inactive';
            if ( isset( $saved_status[ $cid ] ) ) {
                $status = $saved_status[ $cid ];
            } elseif ( isset( $saved_status[ 'center-' . $cid ] ) ) {
                $status = $saved_status[ 'center-' . $cid ];
            } elseif ( isset( $saved_status[ $norm ] ) ) {
                $status = $saved_status[ $norm ];
            }

            $list[] = [
                'id'       => $cid,
                'name'     => $name,
                'location' => $loc,
                'status'   => $status,
            ];
        }

        // Include any custom extra centers added from Settings -> Centers Management (if not in CPT)
        if ( is_array( $saved ) ) {
            foreach ( $saved as $s ) {
                $s_name = strtolower( trim( $s['name'] ?? '' ) );
                if ( ! empty( $s_name ) && ! in_array( $s['id'] ?? '', [ 'center-1', 'center-2', 'center-3', 'center-4', 'center-5' ], true ) ) {
                    $already = false;
                    foreach ( $list as $existing ) {
                        if ( strtolower( trim( $existing['name'] ) ) === $s_name ) {
                            $already = true;
                            break;
                        }
                    }
                    if ( ! $already ) {
                        $list[] = $s;
                    }
                }
            }
        }

        return $list;
    }

    $saved = get_option( 'radm_centers_list', null );
    if ( is_array( $saved ) && ! empty( $saved ) ) {
        return $saved;
    }

    return [];
}

/**
 * Returns all active centers for dropdowns & restrictions
 */
function radm_get_all_centers(): array {
    $list = radm_get_centers_list();
    $centers = [];
    foreach ( $list as $c ) {
        if ( ( $c['status'] ?? 'active' ) === 'active' ) {
            $centers[] = [
                'id'       => (string) ( $c['id'] ?? $c['name'] ),
                'name'     => $c['name'],
                'location' => $c['location'] ?? 'Bangalore',
                'status'   => $c['status'] ?? 'active',
            ];
        }
    }
    if ( empty( $centers ) ) {
        foreach ( $list as $c ) {
            $centers[] = [
                'id'       => (string) ( $c['id'] ?? $c['name'] ),
                'name'     => $c['name'],
                'location' => $c['location'] ?? 'Bangalore',
                'status'   => $c['status'] ?? 'active',
            ];
        }
    }
    return $centers;
}

/**
 * Returns all portal roles (built-in and custom created)
 */
function radm_get_all_roles(): array {
    $default_roles = [
        'administrator'    => [
            'key'             => 'administrator',
            'name'            => 'Super Admin',
            'is_system'       => true,
            'modules'         => array_keys( radm_get_all_modules() ),
            'restrict_center' => false,
            'centers'         => [],
        ],
        'radm_admin'       => [
            'key'             => 'radm_admin',
            'name'            => 'Admin (Content & Reg)',
            'is_system'       => true,
            'modules'         => [ 'dashboard', 'registrations', 'gallery', 'form-groups', 'whatsapp', 'pages' ],
            'restrict_center' => false,
            'centers'         => [],
        ],
        'radm_gallery'     => [
            'key'             => 'radm_gallery',
            'name'            => 'Gallery Manager',
            'is_system'       => true,
            'modules'         => [ 'dashboard', 'gallery' ],
            'restrict_center' => false,
            'centers'         => [],
        ],
        'radm_center_admin'=> [
            'key'             => 'radm_center_admin',
            'name'            => 'Center Admin',
            'is_system'       => true,
            'modules'         => [ 'dashboard', 'registrations', 'form-groups' ],
            'restrict_center' => true,
            'centers'         => [],
        ],
        'subscriber'       => [
            'key'             => 'subscriber',
            'name'            => 'Subscriber',
            'is_system'       => true,
            'modules'         => [ 'dashboard' ],
            'restrict_center' => false,
            'centers'         => [],
        ],
    ];

    $custom_roles = get_option( 'radm_custom_roles', [] );
    if ( is_array( $custom_roles ) ) {
        foreach ( $custom_roles as $role_key => $role_data ) {
            $default_roles[ $role_key ] = array_merge( [
                'key'             => $role_key,
                'name'            => $role_data['name'] ?? ucfirst( str_replace( [ 'radm_', '_' ], [ '', ' ' ], $role_key ) ),
                'is_system'       => false,
                'modules'         => $role_data['modules'] ?? [ 'dashboard' ],
                'restrict_center' => ! empty( $role_data['restrict_center'] ),
                'centers'         => $role_data['centers'] ?? [],
            ], $role_data );
        }
    }

    return $default_roles;
}

/**
 * Returns module & center permissions for a given user
 */
function radm_get_user_module_permissions( int $user_id = 0 ): array {
    if ( ! $user_id ) {
        $user_id = get_current_user_id();
    }
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        return [ 'modules' => [], 'restrict_center' => false, 'centers' => [], 'is_super_admin' => false ];
    }

    // Super Admin has full access to everything
    if ( in_array( 'administrator', $user->roles, true ) || user_can( $user_id, 'manage_options' ) ) {
        return [
            'modules'         => array_keys( radm_get_all_modules() ),
            'restrict_center' => false,
            'centers'         => [],
            'is_super_admin'  => true,
        ];
    }

    // Check user-level custom override first
    $custom_modules   = get_user_meta( $user_id, '_radm_allowed_modules', true );
    $restrict_center  = (bool) get_user_meta( $user_id, '_radm_restrict_center', true );
    $assigned_centers = get_user_meta( $user_id, '_radm_assigned_centers', true );
    if ( ! is_array( $assigned_centers ) ) { $assigned_centers = []; }

    if ( is_array( $custom_modules ) ) {
        return [
            'modules'         => $custom_modules,
            'restrict_center' => $restrict_center,
            'centers'         => $assigned_centers,
            'is_super_admin'  => false,
        ];
    }

    // Check custom roles option and role-level defaults
    $primary_role = ! empty( $user->roles ) ? $user->roles[0] : 'subscriber';

    $all_roles = radm_get_all_roles();
    if ( isset( $all_roles[ $primary_role ] ) && ! empty( $all_roles[ $primary_role ]['modules'] ) ) {
        return [
            'modules'         => $all_roles[ $primary_role ]['modules'],
            'restrict_center' => ! empty( $all_roles[ $primary_role ]['restrict_center'] ),
            'centers'         => $all_roles[ $primary_role ]['centers'] ?? [],
            'is_super_admin'  => false,
        ];
    }

    $role_perms = get_option( 'radm_role_permissions', [] );
    if ( isset( $role_perms[ $primary_role ] ) && is_array( $role_perms[ $primary_role ] ) ) {
        return [
            'modules'         => $role_perms[ $primary_role ]['modules'] ?? [ 'dashboard' ],
            'restrict_center' => ! empty( $role_perms[ $primary_role ]['restrict_center'] ),
            'centers'         => $role_perms[ $primary_role ]['centers'] ?? [],
            'is_super_admin'  => false,
        ];
    }

    // Default fallbacks for built-in roles
    switch ( $primary_role ) {
        case 'radm_admin':
            return [
                'modules'         => [ 'dashboard', 'registrations', 'gallery', 'form-groups', 'whatsapp', 'pages' ],
                'restrict_center' => false,
                'centers'         => [],
                'is_super_admin'  => false,
            ];
        case 'radm_gallery':
            return [
                'modules'         => [ 'dashboard', 'gallery' ],
                'restrict_center' => false,
                'centers'         => [],
                'is_super_admin'  => false,
            ];
        case 'radm_center_admin':
            return [
                'modules'         => [ 'dashboard', 'registrations', 'form-groups' ],
                'restrict_center' => true,
                'centers'         => [],
                'is_super_admin'  => false,
            ];
        default:
            return [
                'modules'         => [ 'dashboard' ],
                'restrict_center' => false,
                'centers'         => [],
                'is_super_admin'  => false,
            ];
    }
}

/**
 * Checks if current user can access a specific module key or slug
 */
function radm_user_can_access_module( string $module_key, int $user_id = 0 ): bool {
    $perms = radm_get_user_module_permissions( $user_id );
    if ( ! empty( $perms['is_super_admin'] ) ) {
        return true;
    }
    $allowed = $perms['modules'] ?? [];
    return in_array( $module_key, $allowed, true );
}

/**
 * Outputs the full portal shell: sidebar + header + opens .radm-content.
 * Call radm_portal_footer() to close it.
 */
function radm_portal_header( string $page_title, string $page_subtitle ): void {
    $all_modules = radm_get_all_modules();
    $perms       = radm_get_user_module_permissions();
    $allowed     = $perms['modules'] ?? [];

    // Ensure dashboard is included if user has any access
    if ( ! empty( $allowed ) && ! in_array( 'dashboard', $allowed, true ) ) {
        array_unshift( $allowed, 'dashboard' );
    }

    $current_page = sanitize_key( $_GET['page'] ?? 'radm-dashboard' );
    $current_screen_id = get_current_screen() ? get_current_screen()->id : '';
    ?>
<div class="radm-portal">

    <!-- ░░ SIDEBAR ░░ -->
    <aside class="radm-sidebar">

        <?php
        $org_logo_url = get_option( 'radm_org_logo', '' );
        $theme_logo   = get_template_directory_uri() . '/assets/images/rashtrotthana-group-logo.png';
        $display_logo = ! empty( $org_logo_url ) ? $org_logo_url : $theme_logo;
        ?>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-dashboard' ) ); ?>" class="radm-logo" style="padding: 16px 18px; display: flex; align-items: center; justify-content: center; min-height: 64px; background: #ffffff;">
            <img src="<?php echo esc_url( $display_logo ); ?>" alt="Rashtrotthana Yoga" style="max-height: 44px; max-width: 100%; object-fit: contain;" />
        </a>

        <nav class="radm-nav">
            <?php
            foreach ( $all_modules as $mod_key => $item ) :
                // Only render if user has permission for this module
                if ( ! in_array( $mod_key, $allowed, true ) ) {
                    continue;
                }

                $is_cpt = ! empty( $item['is_cpt'] );
                $url = $is_cpt ? admin_url( $item['slug'] ) : admin_url( 'admin.php?page=' . $item['slug'] );
                
                $active = '';
                if ( $is_cpt ) {
                    $active = ( strpos( $current_screen_id, 'event' ) !== false ) ? ' active' : '';
                } else {
                    $active = ( $current_page === $item['slug'] ) ? ' active' : '';
                }
            ?>
            <a href="<?php echo esc_url( $url ); ?>" class="radm-nav-item<?php echo $active; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <?php echo $item['icon']; ?>
                </svg>
                <?php echo esc_html( $item['label'] ); ?>
            </a>
            <?php if ( $mod_key === 'pages' ) : 
                $cur_sec = sanitize_key( $_GET['section'] ?? 'centers' );
            ?>
            <div class="radm-nav-sub">
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=centers' ) ); ?>" class="radm-nav-sub-item<?php echo ( $current_page === 'radm-pages' && $cur_sec === 'centers' ) ? ' active' : ''; ?>">
                    <span class="radm-sub-dot"></span> Centers
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=activities' ) ); ?>" class="radm-nav-sub-item<?php echo ( $current_page === 'radm-pages' && $cur_sec === 'activities' ) ? ' active' : ''; ?>">
                    <span class="radm-sub-dot"></span> Activities
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=events' ) ); ?>" class="radm-nav-sub-item<?php echo ( $current_page === 'radm-pages' && $cur_sec === 'events' ) ? ' active' : ''; ?>">
                    <span class="radm-sub-dot"></span> Events
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=news' ) ); ?>" class="radm-nav-sub-item<?php echo ( $current_page === 'radm-pages' && $cur_sec === 'news' ) ? ' active' : ''; ?>">
                    <span class="radm-sub-dot"></span> News &amp; Updates
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=faqs' ) ); ?>" class="radm-nav-sub-item<?php echo ( $current_page === 'radm-pages' && $cur_sec === 'faqs' ) ? ' active' : ''; ?>">
                    <span class="radm-sub-dot"></span> FAQs
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=inquiries' ) ); ?>" class="radm-nav-sub-item<?php echo ( $current_page === 'radm-pages' && $cur_sec === 'inquiries' ) ? ' active' : ''; ?>">
                    <span class="radm-sub-dot"></span> Contact Inquiries
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-pages&section=activity-inquiries' ) ); ?>" class="radm-nav-sub-item<?php echo ( $current_page === 'radm-pages' && $cur_sec === 'activity-inquiries' ) ? ' active' : ''; ?>">
                    <span class="radm-sub-dot"></span> Activity Enquiries
                </a>
            </div>
            <?php endif; ?>
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
                    <div class="radm-user-avatar" id="radm-user-avatar">
                        <?php echo esc_html( strtoupper( substr( wp_get_current_user()->display_name ?: 'A', 0, 1 ) ) ); ?>
                    </div>
                    <span id="radm-user-name"><?php echo esc_html( wp_get_current_user()->display_name ?: 'Admin' ); ?></span>
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

<!-- ══════════════════════════════════════════════════════════════════════════
     UNIVERSAL IN-PORTAL MEDIA PICKER MODAL (NO WP.MEDIA)
     ══════════════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-db-media-picker-modal" aria-hidden="true">
    <div class="radm-modal radm-modal--media-picker">
        <div class="radm-modal-header">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; border-radius:8px; background:rgba(46,125,50,0.12); display:flex; align-items:center; justify-content:center; color:#2E7D32;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:16px; font-weight:700;">Select from Media Library</h3>
                    <p style="margin:2px 0 0; font-size:12px; color:var(--radm-text-muted);">Choose an existing image or upload directly from your device</p>
                </div>
            </div>
            <button type="button" class="radm-modal-close" onclick="radmCloseMediaPickerModal()" title="Close">✕</button>
        </div>

        <!-- Search Bar & Direct Local Upload Trigger -->
        <div style="padding:12px 20px; background:#f8fafc; border-bottom:1px solid var(--radm-border); display:flex; gap:12px; align-items:center; justify-content:space-between; flex-wrap:wrap;">
            <div style="position:relative; flex:1; min-width:220px;">
                <input type="text" id="radm-media-picker-search" class="radm-input" placeholder="Search images by filename or title…" style="padding-left:36px; height:38px; width:100%; box-sizing:border-box;" />
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute; left:12px; top:11px; color:var(--radm-text-muted); pointer-events:none;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
            <button type="button" class="radm-btn radm-btn-primary" onclick="radmTriggerPickerUpload()" style="height:38px; display:inline-flex; align-items:center; gap:6px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                + Upload from Local
            </button>
        </div>

        <!-- Media Grid -->
        <div class="radm-modal-body" id="radm-media-picker-grid-wrap" style="padding:16px 20px; overflow-y:auto; flex:1; min-height:280px;">
            <div id="radm-media-picker-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(115px, 1fr)); gap:12px;"></div>
            <div id="radm-media-picker-loading" style="display:none; text-align:center; padding:48px 20px; color:var(--radm-text-muted);">
                <div style="font-size:14px; font-weight:600;">Loading Media Library…</div>
            </div>
            <div id="radm-media-picker-empty" style="display:none; text-align:center; padding:48px 20px; color:var(--radm-text-muted);">
                <p style="margin:0; font-size:14px;">No images found matching your search.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="radm-modal-footer" style="padding:12px 20px; display:flex; justify-content:space-between; align-items:center;">
            <div id="radm-media-picker-info" style="font-size:12.5px; color:var(--radm-text-muted); display:flex; align-items:center; gap:8px;">
                <span>Click an image to select</span>
            </div>
            <div style="display:flex; gap:10px;">
                <button type="button" class="radm-btn radm-btn-outline" onclick="radmCloseMediaPickerModal()">Cancel</button>
                <button type="button" class="radm-btn radm-btn-primary" id="radm-media-picker-select-btn" disabled onclick="radmConfirmMediaPickerSelection()">
                    Use Selected Image
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════════════
     MODAL: ORPHAN IMAGE DELETION CONFIRMATION
     ══════════════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-orphan-delete-modal" aria-hidden="true">
    <div class="radm-modal radm-modal--sm" style="max-width:440px;">
        <div class="radm-modal-header" style="border-bottom:1px solid var(--radm-border); padding:16px 20px;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; border-radius:50%; background:#FEF3C7; color:#D97706; display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:bold;">
                    ⚠️
                </div>
                <div>
                    <h3 style="margin:0; font-size:15px; font-weight:700; color:#B45309;">Unused Image Detected</h3>
                    <p style="margin:1px 0 0; font-size:11.5px; color:var(--radm-text-muted);">Storage Cleanup Confirmation</p>
                </div>
            </div>
            <button type="button" class="radm-modal-close" onclick="radmDismissOrphanModal()">✕</button>
        </div>
        <div class="radm-modal-body" style="padding:18px 20px;">
            <p style="margin:0; font-size:13.5px; color:var(--radm-text); line-height:1.5;">
                The previous image <strong id="radm-orphan-filename" style="word-break:break-all; color:#1e293b;"></strong> is <strong>not used anywhere else</strong> on your website.
            </p>
            <p style="margin:10px 0 0; font-size:12.5px; color:var(--radm-text-muted); line-height:1.5;">
                Would you like to permanently delete this unused file from the server storage and database to free up disk space?
            </p>
        </div>
        <div class="radm-modal-footer" style="padding:14px 20px; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="radm-btn radm-btn-outline" id="radm-orphan-keep-btn" onclick="radmDismissOrphanModal()">
                Keep in Library
            </button>
            <button type="button" class="radm-btn radm-btn-danger" id="radm-orphan-delete-btn" onclick="radmExecuteOrphanDelete()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/>
                </svg>
                Delete from Storage
            </button>
        </div>
    </div>
</div>

<!-- Hidden Universal File Input for Local Uploads -->
<input type="file" id="radm-universal-file-input" accept="image/*" style="display:none;" onchange="radmHandleUniversalFileSelect(this)" />
<?php }

