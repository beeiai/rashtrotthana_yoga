<?php
/**
 * Content Pages Module — Rashtrotthana Admin Portal
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$user_name = wp_get_current_user()->display_name ?: 'Admin';
radm_portal_header( 'Content Pages', 'Manage Centers, Activities, News, Events, and more.' );
?>

<div class="radm-card">
    <div class="radm-card-header">
        <h2>Website Content Management</h2>
    </div>
    
    <div class="radm-actions-grid">
        
        <!-- Centers -->
        <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=rs_center' ) ); ?>" class="radm-action-card">
            <div class="radm-action-icon orange">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path><circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
            <div class="radm-action-text">
                <strong>Manage Centers</strong>
                <span>Add, edit, or remove Rashtrotthana branches</span>
            </div>
            <div class="radm-action-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </div>
        </a>

        <!-- Activities -->
        <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=rs_activity' ) ); ?>" class="radm-action-card">
            <div class="radm-action-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
            <div class="radm-action-text">
                <strong>Manage Activities</strong>
                <span>Update yoga classes, workshops & activities</span>
            </div>
            <div class="radm-action-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </div>
        </a>

        <!-- Events -->
        <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=event' ) ); ?>" class="radm-action-card">
            <div class="radm-action-icon purple">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="radm-action-text">
                <strong>Manage Events (Advanced)</strong>
                <span>Create and edit native WordPress event posts</span>
            </div>
            <div class="radm-action-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </div>
        </a>

        <!-- News -->
        <a href="<?php echo esc_url( admin_url( 'edit.php' ) ); ?>" class="radm-action-card">
            <div class="radm-action-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 22h16a2 2 0 002-2V4a2 2 0 00-2-2H8a2 2 0 00-2 2v16a2 2 0 01-2 2zm0 0a2 2 0 01-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path>
                </svg>
            </div>
            <div class="radm-action-text">
                <strong>Manage News</strong>
                <span>Publish press releases and news updates</span>
            </div>
            <div class="radm-action-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </div>
        </a>

        <!-- Inquiries -->
        <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=rs_inquiry' ) ); ?>" class="radm-action-card">
            <div class="radm-action-icon" style="color:#d946ef; background:rgba(217, 70, 239, 0.1);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </div>
            <div class="radm-action-text">
                <strong>View Inquiries</strong>
                <span>Read submissions from the Contact Us form</span>
            </div>
            <div class="radm-action-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </div>
        </a>

        <!-- System Settings -->
        <a href="<?php echo esc_url( admin_url( 'options-general.php' ) ); ?>" class="radm-action-card">
            <div class="radm-action-icon outline">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"></path>
                </svg>
            </div>
            <div class="radm-action-text">
                <strong>System Settings</strong>
                <span>Manage permalinks, timezone, and global WP settings</span>
            </div>
            <div class="radm-action-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </div>
        </a>

    </div>
</div>

<?php radm_portal_footer(); ?>
