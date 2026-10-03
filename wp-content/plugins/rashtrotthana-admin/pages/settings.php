<?php
/**
 * Rashtrotthana Admin Portal — Settings Page
 * Organization Settings & Centers Management
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

// Verify capabilities (Super Admin / manage_options)
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die(
        '<div style="font-family:sans-serif;text-align:center;padding:50px 20px;">'
        . '<h2 style="color:#0f172a;">Access Restricted</h2>'
        . '<p style="color:#64748b;">You do not have sufficient permissions to manage Settings.</p>'
        . '<a href="' . esc_url( admin_url( 'admin.php?page=radm-dashboard' ) ) . '" style="display:inline-block;margin-top:15px;color:#2E7D32;font-weight:600;text-decoration:none;">&larr; Return to Dashboard</a>'
        . '</div>',
        'Permission Denied',
        [ 'response' => 403 ]
    );
}

radm_portal_header( 'Settings', 'Manage organization details and centers' );

$org_name      = get_option( 'radm_org_name', get_option( 'blogname', 'Rashtrotthana Yoga' ) );
$contact_email = get_option( 'radm_contact_email', get_option( 'admin_email', 'info@rashtrotthanayoga.org' ) );
$default_logo  = get_template_directory_uri() . '/assets/images/rashtrotthana-group-logo.png';
$org_logo      = get_option( 'radm_org_logo', $default_logo );
?>

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

<?php radm_portal_footer(); ?>
