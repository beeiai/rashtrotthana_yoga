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
        'settings'      => [
            'slug'   => 'radm-settings',
            'label'  => 'Settings',
            'icon'   => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>',
            'desc'   => 'System configurations & integration keys',
        ],
    ];
}

/**
 * Returns managed centers list (Settings -> Centers Management)
 */
function radm_get_centers_list(): array {
    $saved = get_option( 'radm_centers_list', null );
    if ( is_array( $saved ) && ! empty( $saved ) ) {
        return $saved;
    }

    // Default Centers based on standard Rashtrotthana centers
    $defaults = [
        [
            'id'       => 'center-1',
            'name'     => 'Jayanagar Center',
            'location' => 'Bangalore',
            'status'   => 'active',
        ],
        [
            'id'       => 'center-2',
            'name'     => 'Basavanagudi Center',
            'location' => 'Bangalore',
            'status'   => 'active',
        ],
        [
            'id'       => 'center-3',
            'name'     => 'Malleshwaram Center',
            'location' => 'Bangalore',
            'status'   => 'active',
        ],
        [
            'id'       => 'center-4',
            'name'     => 'Indiranagar Center',
            'location' => 'Bangalore',
            'status'   => 'active',
        ],
        [
            'id'       => 'center-5',
            'name'     => 'Koramangala Center',
            'location' => 'Bangalore',
            'status'   => 'inactive',
        ],
    ];

    update_option( 'radm_centers_list', $defaults );
    return $defaults;
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

    // Check role-level defaults
    $primary_role = ! empty( $user->roles ) ? $user->roles[0] : 'subscriber';
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
                'modules'         => [ 'dashboard', 'registrations', 'gallery', 'form-groups', 'whatsapp' ],
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
        ?>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-dashboard' ) ); ?>" class="radm-logo">
            <?php if ( ! empty( $org_logo_url ) ) : ?>
                <img src="<?php echo esc_url( $org_logo_url ); ?>" alt="Rashtrotthana Yoga" style="max-height: 42px; max-width: 180px; object-fit: contain;" />
            <?php else : ?>
                <div class="radm-logo-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C12 2 7 6 7 11C7 13.76 9.24 16 12 16C14.76 16 17 13.76 17 11C17 6 12 2 12 2Z" fill="white" opacity=".95"/>
                        <path d="M12 16C12 16 8 17 6 20H18C16 17 12 16 12 16Z" fill="white" opacity=".85"/>
                        <circle cx="12" cy="10" r="2.2" fill="white"/>
                    </svg>
                </div>
                <div class="radm-logo-text">
                    <strong>RASHTROTTHANA<br>YOGA</strong>
                </div>
            <?php endif; ?>
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
<?php }
