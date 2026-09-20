<?php
/**
 * Dashboard Page — Rashtrotthana Admin Portal
 * Stats and events are loaded from the real database via JS/AJAX on page load.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$user_name = wp_get_current_user()->display_name ?: 'Admin';
radm_portal_header( 'Dashboard', 'Welcome back, ' . esc_html( $user_name ) . '!' );
?>

<!-- ── Stat Cards (values filled by JS via AJAX) ──────────────────────────── -->
<div class="radm-stats-grid">

    <div class="radm-stat-card">
        <div class="radm-stat-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
            </svg>
        </div>
        <div class="radm-stat-info">
            <div class="radm-stat-value" id="stat-total-registrations">
                <span class="radm-stat-skeleton"></span>
            </div>
            <div class="radm-stat-label">Total Registrations</div>
        </div>
    </div>

    <div class="radm-stat-card">
        <div class="radm-stat-icon orange">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <div class="radm-stat-info">
            <div class="radm-stat-value" id="stat-active-events">
                <span class="radm-stat-skeleton"></span>
            </div>
            <div class="radm-stat-label">Active Events</div>
        </div>
    </div>

    <div class="radm-stat-card">
        <div class="radm-stat-icon purple">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                <line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
        </div>
        <div class="radm-stat-info">
            <div class="radm-stat-value" id="stat-today-registrations">
                <span class="radm-stat-skeleton"></span>
            </div>
            <div class="radm-stat-label">Registrations Today</div>
        </div>
    </div>

</div>

<!-- ── Upcoming Events (loaded by JS) ────────────────────────────────────────── -->
<div class="radm-card">
    <div class="radm-card-header">
        <h2>Upcoming Events</h2>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-registrations' ) ); ?>" class="radm-view-all">
            View All
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                 style="width:14px;height:14px;">
                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </svg>
        </a>
    </div>
    <div class="radm-table-wrap">
        <table class="radm-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Registrations</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="dash-events-tbody">
                <tr id="dash-events-loading">
                    <td colspan="6" style="text-align:center;padding:24px;color:var(--radm-text-muted);">
                        Loading events…
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- ── Quick Actions ───────────────────────────────────────────────────────── -->
<div class="radm-card">
    <div class="radm-card-header">
        <h2>Quick Actions</h2>
    </div>
    <div class="radm-actions-grid">
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-registrations&radm_view=create' ) ); ?>" class="radm-action-card">
            <div class="radm-action-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
            </div>
            <div class="radm-action-text">
                <strong>Create New Event</strong>
                <span>Set up an event with registration</span>
            </div>
            <div class="radm-action-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </div>
        </a>

        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-registrations' ) ); ?>" class="radm-action-card">
            <div class="radm-action-icon outline">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                    <path d="M16 3.13a4 4 0 010 7.75"/>
                </svg>
            </div>
            <div class="radm-action-text">
                <strong>View Registrations</strong>
                <span>See and manage all participants</span>
            </div>
            <div class="radm-action-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </div>
        </a>
    </div>
</div>

<?php radm_portal_footer(); ?>
