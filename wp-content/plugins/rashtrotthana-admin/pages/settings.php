<?php
/**
 * Rashtrotthana Admin Portal — Settings Page
 * Organization Settings & Centers Management
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$is_super_admin = current_user_can( 'manage_options' );
$current_user   = wp_get_current_user();
$all_roles      = radm_get_all_roles();
$primary_role   = ! empty( $current_user->roles ) ? $current_user->roles[0] : 'subscriber';
$role_label     = $all_roles[ $primary_role ]['name'] ?? ucfirst( str_replace( [ 'radm_', '_' ], [ '', ' ' ], $primary_role ) );

radm_portal_header( 'Settings', $is_super_admin ? 'Manage organization details, centers & account security' : 'Manage your portal account security & credentials' );

$org_name      = get_option( 'radm_org_name', get_option( 'blogname', 'Rashtrotthana Yoga' ) );
$contact_email = get_option( 'radm_contact_email', get_option( 'admin_email', 'info@rashtrotthanayoga.org' ) );
$default_logo  = get_template_directory_uri() . '/assets/images/rashtrotthana-group-logo.png';
$org_logo      = get_option( 'radm_org_logo', $default_logo );
?>

<?php if ( $is_super_admin ) : ?>
<div class="radm-settings-grid">
    
    <!-- ══════════════════════════════════════════════════════════════════
         LEFT CARD: ORGANIZATION SETTINGS
         ══════════════════════════════════════════════════════════════════ -->
    <div class="radm-settings-card">
        
        <div class="radm-settings-header">
            <div class="radm-settings-title-group">
                <div class="radm-settings-icon-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                        <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/>
                        <path d="M9 22v-4h6v4"/>
                        <path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/>
                        <path d="M8 10h.01"/><path d="M16 10h.01"/><path d="M12 10h.01"/>
                        <path d="M8 14h.01"/><path d="M16 14h.01"/><path d="M12 14h.01"/>
                    </svg>
                </div>
                <div>
                    <h2 class="radm-settings-title">Organization Settings</h2>
                    <p class="radm-settings-subtitle">Manage your organization's basic information. These details will be used across the system.</p>
                </div>
            </div>
        </div>

        <form id="radm-org-settings-form" style="display: flex; flex-direction: column; gap: 20px;">
            
            <div class="radm-form-group">
                <label class="radm-label">Organization Name <span style="color:#ef4444;">*</span></label>
                <input type="text" id="radm-org-name" class="radm-input" value="<?php echo esc_attr( $org_name ); ?>" required />
            </div>

            <div class="radm-form-group">
                <label class="radm-label">Logo <span style="color:#ef4444;">*</span></label>
                <div class="radm-logo-upload-wrap">
                    <div class="radm-logo-preview-box" id="radm-logo-preview-wrap">
                        <img id="radm-logo-img-preview" src="<?php echo esc_url( $org_logo ); ?>" alt="Organization Logo" />
                    </div>
                    <div class="radm-logo-upload-controls">
                        <input type="hidden" id="radm-org-logo-url" value="<?php echo esc_attr( $org_logo ); ?>" />
                        <button type="button" class="radm-btn radm-btn-outline" id="radm-change-logo-btn" style="font-size: 13px; font-weight: 600; padding: 7px 14px; display: inline-flex; align-items: center; gap: 6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            Change Logo
                        </button>
                        <span style="font-size: 12px; color: var(--radm-text-muted); line-height: 1.4;">
                            Recommended size: 300 x 300 px PNG or JPG (Max 2MB)
                        </span>
                    </div>
                </div>
            </div>

            <div class="radm-form-group">
                <label class="radm-label">Contact Email <span style="color:#ef4444;">*</span></label>
                <input type="email" id="radm-contact-email" class="radm-input" value="<?php echo esc_attr( $contact_email ); ?>" required />
            </div>

            <div style="margin-top: 10px;">
                <button type="submit" class="radm-btn radm-btn-primary" id="radm-save-org-btn" style="padding: 10px 22px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    <span id="radm-save-org-text">Save Changes</span>
                </button>
            </div>

        </form>

    </div>

    <!-- ══════════════════════════════════════════════════════════════════
         RIGHT CARD: CENTERS MANAGEMENT
         ══════════════════════════════════════════════════════════════════ -->
    <div class="radm-settings-card">
        
        <div class="radm-settings-header">
            <div class="radm-settings-title-group">
                <div class="radm-settings-icon-badge radm-settings-icon-badge--blue">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <div>
                    <h2 class="radm-settings-title">Centers Management</h2>
                    <p class="radm-settings-subtitle">Add, edit or delete centers. These centers will be available in events, registrations and form groups.</p>
                </div>
            </div>
            
            <button type="button" class="radm-btn radm-btn-primary" id="radm-add-center-btn" style="flex-shrink: 0; display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Add New Center
            </button>
        </div>

        <div class="radm-table-responsive" style="margin-top: 14px; border: 1px solid var(--radm-border); border-radius: 8px; overflow: hidden;">
            <table class="radm-table radm-centers-table">
                <thead>
                    <tr>
                        <th style="width: 44px; text-align: center;">#</th>
                        <th style="min-width: 180px;">CENTER NAME</th>
                        <th style="min-width: 120px;">LOCATION</th>
                        <th style="width: 110px;">STATUS</th>
                        <th style="width: 90px; text-align: right;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="radm-centers-tbody">
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--radm-text-muted);">
                            <div class="radm-spinner" style="margin: 0 auto 10px;"></div>
                            Loading centers...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>
<?php else : ?>
<div class="radm-card" style="margin-bottom: 24px; display: flex; align-items: center; gap: 14px; background: #f8fafc; border: 1px solid var(--radm-border); border-left: 4px solid var(--radm-green-primary); padding: 16px 20px;">
    <div style="width: 36px; height: 36px; border-radius: 50%; background: #e8f5e9; color: var(--radm-green-primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
    </div>
    <div>
        <strong style="display: block; font-size: 14px; color: var(--radm-text);">System Settings Managed by Super Admin</strong>
        <p style="margin: 2px 0 0; font-size: 13px; color: var(--radm-text-muted);">Organization profile and Centers management require Super Administrator permissions. You can manage your personal account security and login password below.</p>
    </div>
</div>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════════════════════
     ACCOUNT SECURITY & CHANGE PASSWORD CARD (FOR ALL LOGGED-IN USERS)
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-settings-card" style="margin-top: <?php echo $is_super_admin ? '24px' : '0'; ?>; max-width: 100%;">
    
    <div class="radm-settings-header" style="border-bottom: 1px solid var(--radm-border); padding-bottom: 16px; margin-bottom: 20px;">
        <div class="radm-settings-title-group">
            <div class="radm-settings-icon-badge" style="background: #f3e8ff; color: #7e22ce;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            <div>
                <h2 class="radm-settings-title">Account Security &amp; Password</h2>
                <p class="radm-settings-subtitle">Update your account login password. Your active session will be renewed automatically.</p>
            </div>
        </div>
    </div>

    <!-- User Profile Strip -->
    <div style="display: flex; align-items: center; justify-content: space-between; background: #f8fafc; border: 1px solid var(--radm-border); border-radius: 8px; padding: 14px 18px; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 42px; height: 42px; border-radius: 50%; background: #e8f5e9; color: #2E7D32; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px;">
                <?php echo esc_html( strtoupper( substr( $current_user->display_name ?: $current_user->user_login, 0, 1 ) ) ); ?>
            </div>
            <div>
                <strong style="display: block; font-size: 14.5px; color: var(--radm-text);">
                    <?php echo esc_html( $current_user->display_name ?: $current_user->user_login ); ?>
                    <span style="font-size: 12px; font-weight: 500; color: var(--radm-text-muted);">(@<?php echo esc_html( $current_user->user_login ); ?>)</span>
                </strong>
                <span style="font-size: 12.5px; color: var(--radm-text-muted);"><?php echo esc_html( $current_user->user_email ); ?></span>
            </div>
        </div>
        <div>
            <span class="radm-badge radm-badge--open" style="font-size: 12px; padding: 4px 10px;">
                <?php echo esc_html( $role_label ); ?>
            </span>
        </div>
    </div>

    <form id="radm-change-password-form" style="display: flex; flex-direction: column; gap: 18px;">
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px;">
            <div class="radm-form-group">
                <label class="radm-label" for="radm-current-password">Current Password <span style="color:#ef4444;">*</span></label>
                <div style="position: relative;">
                    <input type="password" id="radm-current-password" class="radm-input" placeholder="Enter current password" required style="padding-right: 40px;" />
                    <button type="button" class="radm-pwd-toggle-btn" data-target="radm-current-password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--radm-text-muted); padding: 4px;" title="Show/Hide Password">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="radm-form-group">
                <label class="radm-label" for="radm-new-password">New Password <span style="color:#ef4444;">*</span></label>
                <div style="position: relative;">
                    <input type="password" id="radm-new-password" class="radm-input" placeholder="Min. 6 characters" minlength="6" required style="padding-right: 40px;" />
                    <button type="button" class="radm-pwd-toggle-btn" data-target="radm-new-password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--radm-text-muted); padding: 4px;" title="Show/Hide Password">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="radm-form-group">
                <label class="radm-label" for="radm-confirm-password">Confirm New Password <span style="color:#ef4444;">*</span></label>
                <div style="position: relative;">
                    <input type="password" id="radm-confirm-password" class="radm-input" placeholder="Re-enter new password" minlength="6" required style="padding-right: 40px;" />
                    <button type="button" class="radm-pwd-toggle-btn" data-target="radm-confirm-password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--radm-text-muted); padding: 4px;" title="Show/Hide Password">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; align-items: center; gap: 12px; margin-top: 8px;">
            <button type="submit" class="radm-btn radm-btn-primary" id="radm-change-pwd-btn" style="padding: 10px 24px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span id="radm-change-pwd-text">Update Password</span>
            </button>
        </div>

    </form>

</div>

<?php if ( $is_super_admin ) : ?>
<!-- ══════════════════════════════════════════════════════════════════
     ADD / EDIT CENTER MODAL
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-center-modal-overlay" aria-hidden="true">
    <div class="radm-modal" style="max-width: 480px;">
        
        <div class="radm-modal-header">
            <div>
                <h3 id="radm-center-modal-title" style="margin: 0 0 2px;">Add New Center</h3>
                <p style="margin: 0; font-size: 13px; color: var(--radm-text-muted);">Configure center branch details and status</p>
            </div>
            <button type="button" class="radm-modal-close" id="radm-center-modal-close" aria-label="Close modal">×</button>
        </div>

        <form id="radm-center-form">
            <input type="hidden" id="radm-center-id" value="" />
            
            <div class="radm-modal-body" style="padding: 20px 24px; display: flex; flex-direction: column; gap: 16px;">
                
                <div class="radm-form-group">
                    <label class="radm-label">Center Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="radm-center-name" class="radm-input" placeholder="e.g. Jayanagar Center" required />
                </div>

                <div class="radm-form-group">
                    <label class="radm-label">Location <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="radm-center-location" class="radm-input" placeholder="e.g. Bangalore" value="Bangalore" required />
                </div>

                <div class="radm-form-group">
                    <label class="radm-label">Status <span style="color:#ef4444;">*</span></label>
                    <div style="display: flex; gap: 16px; align-items: center; margin-top: 6px;">
                        <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 14px; font-weight: 500;">
                            <input type="radio" name="radm_center_status" value="active" checked />
                            <span class="radm-badge radm-badge--open">Active</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 14px; font-weight: 500;">
                            <input type="radio" name="radm_center_status" value="inactive" />
                            <span class="radm-badge radm-badge--draft" style="background:#fee2e2;color:#991b1b;border-color:#fecaca;">Inactive</span>
                        </label>
                    </div>
                </div>

            </div>

            <div class="radm-modal-footer">
                <button type="button" class="radm-btn radm-btn-outline" id="radm-center-modal-cancel">Cancel</button>
                <button type="submit" class="radm-btn radm-btn-primary" id="radm-center-modal-submit">
                    <span id="radm-center-submit-text">Save Center</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════
     DELETE CENTER CONFIRMATION MODAL
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-delete-center-overlay" aria-hidden="true">
    <div class="radm-modal" style="max-width: 440px;">
        <div class="radm-modal-header" style="border-bottom: 1px solid #fee2e2;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    </svg>
                </div>
                <div>
                    <h3 style="margin: 0; color: #b91c1c; font-size: 17px;">Delete Center</h3>
                    <p style="margin: 2px 0 0; font-size: 12px; color: var(--radm-text-muted);">This action cannot be undone.</p>
                </div>
            </div>
            <button type="button" class="radm-modal-close" id="radm-del-center-close" aria-label="Close">×</button>
        </div>
        <div class="radm-modal-body" style="padding: 20px 24px;">
            <p style="margin: 0 0 10px; font-size: 14px; color: var(--radm-text); line-height: 1.5;">
                Are you sure you want to delete <strong id="radm-del-center-name" style="color: #1e293b;">this center</strong>?
            </p>
            <p style="margin: 0; font-size: 12.5px; color: var(--radm-text-muted);">
                It will be removed from available centers across events, registrations, and form groups.
            </p>
        </div>
        <div class="radm-modal-footer" style="background: #f8fafc; border-top: 1px solid var(--radm-border); display: flex; justify-content: flex-end; gap: 10px; padding: 14px 20px;">
            <button type="button" class="radm-btn radm-btn-outline" id="radm-del-center-cancel-btn">Cancel</button>
            <button type="button" class="radm-btn radm-btn-danger" id="radm-del-center-confirm-btn" style="background: #dc2626; color: #fff; border-color: #dc2626;">
                Delete Center
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<?php radm_portal_footer(); ?>
