<?php
/**
 * Rashtrotthana Admin Portal — Roles & Responsibilities Page
 * Dynamic Module Access (Tag Multi-Select), Center Restrictions & Staff Management
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

// Verify capabilities (Super Admin / manage_options)
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die(
        '<div style="font-family:sans-serif;text-align:center;padding:50px 20px;">'
        . '<h2 style="color:#0f172a;">Access Restricted</h2>'
        . '<p style="color:#64748b;">You do not have sufficient permissions to manage Roles & Responsibilities.</p>'
        . '<a href="' . esc_url( admin_url( 'admin.php?page=radm-dashboard' ) ) . '" style="display:inline-block;margin-top:15px;color:#2E7D32;font-weight:600;text-decoration:none;">&larr; Return to Dashboard</a>'
        . '</div>',
        'Permission Denied',
        [ 'response' => 403 ]
    );
}

radm_portal_header( 'Roles & Responsibilities', 'Configure staff roles, custom module access & center restrictions' );
$all_modules = radm_get_all_modules();
$all_centers = radm_get_all_centers();
$all_roles   = radm_get_all_roles();
?>

<!-- ── Tabs Header ── -->
<div class="radm-tabs" style="margin-bottom: 20px; display: flex; gap: 8px; border-bottom: 2px solid var(--radm-border); padding-bottom: 12px;">
    <button type="button" class="radm-tab-btn is-active" id="radm-tab-staff-users" data-tab="staff-users" style="padding: 8px 18px; border-radius: 6px; font-weight: 600; font-size: 13.5px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; background: #e8f5e9; color: #2E7D32;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
        </svg>
        Staff Users &amp; Access
    </button>
    <button type="button" class="radm-tab-btn" id="radm-tab-custom-roles" data-tab="custom-roles" style="padding: 8px 18px; border-radius: 6px; font-weight: 600; font-size: 13.5px; border: 1px solid var(--radm-border); cursor: pointer; display: inline-flex; align-items: center; gap: 8px; background: #fff; color: var(--radm-text);">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
        </svg>
        Custom Roles &amp; Permissions
    </button>
</div>

<!-- ══════════════════════════════════════════════════════════════════
     TAB 1: STAFF USERS & ACCESS
     ══════════════════════════════════════════════════════════════════ -->
<div id="radm-tab-pane-staff-users" class="radm-tab-pane is-active">
    <!-- ── Filter & Action Header ── -->
    <div class="radm-page-controls" style="display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 20px; flex-wrap: wrap;">
        <div style="display: flex; gap: 12px; align-items: center; flex: 1; min-width: 280px;">
            <div class="radm-search-wrap" style="position: relative; width: 100%; max-width: 320px;">
                <input type="text" id="radm-users-search" class="radm-input" placeholder="Search staff name or email..." style="padding-left: 36px;" />
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--radm-text-muted);">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
            <select id="radm-users-role-filter" class="radm-select" style="max-width: 200px;">
                <option value="">All Roles</option>
                <?php foreach ( $all_roles as $r_slug => $r_info ) : ?>
                    <option value="<?php echo esc_attr( $r_slug ); ?>"><?php echo esc_html( $r_info['name'] ); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="button" class="radm-btn radm-btn-primary" id="radm-open-create-user-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Add Staff User
            </button>
        </div>
    </div>

    <!-- ── Staff Users & Permissions Table ── -->
    <div class="radm-card" style="padding: 0; overflow: visible;">
        <div class="radm-table-responsive" style="overflow: visible; min-height: 280px;">
            <table class="radm-table radm-roles-table">
                <thead>
                    <tr>
                        <th style="width: 44px; text-align: center;">#</th>
                        <th style="min-width: 200px;">Staff User</th>
                        <th style="width: 150px;">Role</th>
                        <th style="min-width: 280px;">Accessible Modules</th>
                        <th style="min-width: 150px;">Center Scope</th>
                        <th style="width: 130px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody id="radm-users-tbody">
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 50px 20px; color: var(--radm-text-muted);">
                            <div class="radm-spinner" style="margin: 0 auto 12px;"></div>
                            Loading staff users and permissions...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════
     TAB 2: CUSTOM ROLES & PERMISSIONS
     ══════════════════════════════════════════════════════════════════ -->
<div id="radm-tab-pane-custom-roles" class="radm-tab-pane" style="display: none;">
    <!-- ── Role Actions Header ── -->
    <div class="radm-page-controls" style="display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 20px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 280px;">
            <h3 style="margin: 0 0 4px; font-size: 16px; color: var(--radm-text);">System &amp; Custom Roles</h3>
            <p style="margin: 0; font-size: 13px; color: var(--radm-text-muted);">Create customized roles with specific module access rights and center restrictions</p>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="button" class="radm-btn radm-btn-primary" id="radm-open-create-role-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Create New Role
            </button>
        </div>
    </div>

    <!-- ── Roles Table ── -->
    <div class="radm-card" style="padding: 0; overflow: visible;">
        <div class="radm-table-responsive" style="overflow: visible; min-height: 240px;">
            <table class="radm-table radm-custom-roles-table">
                <thead>
                    <tr>
                        <th style="width: 44px; text-align: center;">#</th>
                        <th style="min-width: 180px;">Role Name</th>
                        <th style="min-width: 140px;">Role Key</th>
                        <th style="min-width: 280px;">Attached Module Access Rights</th>
                        <th style="min-width: 150px;">Center Scope</th>
                        <th style="width: 100px; text-align: center;">Users</th>
                        <th style="width: 120px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody id="radm-roles-list-tbody">
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px 20px; color: var(--radm-text-muted);">
                            <div class="radm-spinner" style="margin: 0 auto 12px;"></div>
                            Loading roles and access rights...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- ══════════════════════════════════════════════════════════════════
     EDIT USER MODULE ACCESS MODAL (TAG MULTI-SELECT + RESTRICT CENTER)
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-user-access-overlay" aria-hidden="true">
    <div class="radm-modal" style="max-width: 620px; width: 94%;">
        
        <div class="radm-modal-header">
            <div>
                <h3 id="radm-ua-modal-title" style="margin: 0 0 2px;">Edit Module Access</h3>
                <p id="radm-ua-modal-subtitle" style="margin: 0; font-size: 13px; color: var(--radm-text-muted);">Manage accessible navbar modules and center restrictions</p>
            </div>
            <button type="button" class="radm-modal-close" id="radm-ua-modal-close" aria-label="Close modal">×</button>
        </div>

        <form id="radm-user-access-form">
            <input type="hidden" id="radm-ua-user-id" name="user_id" value="" />

            <div class="radm-modal-body" style="padding: 20px 24px; display: flex; flex-direction: column; gap: 18px;">
                
                <!-- Role Selector -->
                <div class="radm-form-group">
                    <label for="radm-ua-role" class="radm-label" style="font-weight: 600;">
                        Assign Role <span style="color:#ef4444;">*</span>
                    </label>
                    <select id="radm-ua-role" class="radm-select" style="width: 100%;">
                        <?php foreach ( $all_roles as $r_slug => $r_info ) : ?>
                            <option value="<?php echo esc_attr( $r_slug ); ?>">
                                <?php echo esc_html( $r_info['name'] ); ?> <?php echo ! empty( $r_info['is_system'] ) ? '(System)' : '(Custom)'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- ── Accessible Modules Tag Multi-Select Dropdown ── -->
                <div class="radm-form-group" id="radm-ua-modules-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label class="radm-label" style="font-weight: 600; margin: 0;">
                            Accessible Modules <span style="color:#ef4444;">*</span>
                        </label>
                        <div style="font-size: 12px; display: flex; gap: 8px;">
                            <button type="button" class="radm-btn-link" id="radm-ua-select-all-mods" style="color: var(--radm-green-primary); font-weight: 600;">Select All</button>
                            <span style="color: #cbd5e1;">|</span>
                            <button type="button" class="radm-btn-link" id="radm-ua-clear-all-mods" style="color: #64748b;">Clear</button>
                        </div>
                    </div>
                    <p style="margin: 0 0 8px; font-size: 12.5px; color: var(--radm-text-muted);">
                        The user will only see the selected items in their portal sidebar navbar.
                    </p>

                    <!-- Multi-Select Custom Tag Box Component -->
                    <div class="radm-tag-multiselect" id="radm-ua-mods-multiselect">
                        <!-- Selected Tags Display Area -->
                        <div class="radm-tag-box" id="radm-ua-mods-tags-container">
                            <!-- Populated with tags dynamically via JS: [ Events ✕ ] -->
                            <span class="radm-tag-placeholder" id="radm-ua-mods-placeholder">Click to select accessible modules...</span>
                        </div>

                        <!-- Dropdown Checkbox Panel -->
                        <div class="radm-tag-dropdown" id="radm-ua-mods-dropdown" style="display: none;">
                            <div class="radm-tag-dropdown-header">
                                <input type="text" id="radm-ua-mods-search" class="radm-input radm-input--sm" placeholder="Filter modules..." />
                            </div>
                            <div class="radm-tag-options-list" id="radm-ua-mods-options-list">
                                <?php foreach ( $all_modules as $mod_k => $mod_v ) : ?>
                                    <label class="radm-tag-opt-row" data-key="<?php echo esc_attr( $mod_k ); ?>">
                                        <input type="checkbox" name="radm_ua_mod_check" value="<?php echo esc_attr( $mod_k ); ?>" />
                                        <span class="radm-tag-opt-title"><?php echo esc_html( $mod_v['label'] ); ?></span>
                                        <small class="radm-tag-opt-desc"><?php echo esc_html( $mod_v['desc'] ); ?></small>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Restrict by Center Toggle (Bonus Control) ── -->
                <div class="radm-card" style="padding: 14px 16px; background: #f8fafc; border: 1px solid var(--radm-border); border-radius: 10px; margin: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <strong style="font-size: 13.5px; color: var(--radm-text); display: block;">📍 Restrict by Center</strong>
                            <span style="font-size: 12.5px; color: var(--radm-text-muted);">
                                Restrict this user to view registrations and forms only for specific centers.
                            </span>
                        </div>
                        <label class="radm-switch" style="margin: 0; flex-shrink: 0;">
                            <input type="checkbox" id="radm-ua-restrict-center-toggle" />
                            <span class="radm-slider"></span>
                        </label>
                    </div>

                    <!-- Center Multi-Select Picker (Shown when Toggle is ON) -->
                    <div id="radm-ua-centers-wrapper" style="display: none; margin-top: 14px; padding-top: 14px; border-top: 1px solid #e2e8f0;">
                        <label class="radm-label" style="font-weight: 600; font-size: 12.5px; margin-bottom: 6px;">
                            Select Assigned Centers:
                        </label>
                        <div class="radm-centers-checklist" id="radm-ua-centers-checklist" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 8px; max-height: 160px; overflow-y: auto;">
                            <?php foreach ( $all_centers as $c ) : ?>
                                <label class="radm-center-check-pill">
                                    <input type="checkbox" name="radm_ua_center_check" value="<?php echo esc_attr( $c['name'] ); ?>" />
                                    <span><?php echo esc_html( $c['name'] ); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div><!-- /.radm-modal-body -->

            <div class="radm-modal-footer" style="display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="radm-btn" id="radm-ua-modal-delete-btn" style="background: #fef2f2; border: 1px solid #fca5a5; color: #dc2626; font-size: 13px; padding: 7px 12px; cursor: pointer; border-radius: 6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13" style="margin-right: 4px; vertical-align: -1px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                    Delete User
                </button>
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="radm-btn radm-btn-outline" id="radm-ua-modal-cancel-btn">Cancel</button>
                    <button type="submit" class="radm-btn radm-btn-primary" id="radm-ua-modal-save-btn">
                        <span id="radm-ua-save-text">Save Access Permissions</span>
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════
     CREATE NEW STAFF USER MODAL
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-create-user-overlay" aria-hidden="true">
    <div class="radm-modal" style="max-width: 600px; width: 94%;">
        
        <div class="radm-modal-header">
            <div>
                <h3 style="margin: 0 0 2px;">Add New Staff User</h3>
                <p style="margin: 0; font-size: 13px; color: var(--radm-text-muted);">Create a staff account with customized module access</p>
            </div>
            <button type="button" class="radm-modal-close" id="radm-create-user-close" aria-label="Close modal">×</button>
        </div>

        <form id="radm-create-user-form">
            <div class="radm-modal-body" style="padding: 20px 24px; display: flex; flex-direction: column; gap: 14px;">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="radm-form-group">
                        <label class="radm-label">Full Name <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="radm-cu-name" class="radm-input" placeholder="e.g. Ramesh Kumar" required />
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label">Email Address <span style="color:#ef4444;">*</span></label>
                        <input type="email" id="radm-cu-email" class="radm-input" placeholder="ramesh@rashtrotthana.org" required />
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="radm-form-group">
                        <label class="radm-label">Username <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="radm-cu-username" class="radm-input" placeholder="e.g. ramesh_k" required />
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label">Password <span style="color:#ef4444;">*</span></label>
                        <div style="position: relative;">
                            <input type="password" id="radm-cu-password" class="radm-input" placeholder="Min. 6 characters" minlength="6" required style="padding-right: 40px;" />
                            <button type="button" class="radm-pwd-toggle-btn" data-target="radm-cu-password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--radm-text-muted); padding: 4px;" title="Show/Hide Password">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="radm-form-group">
                    <label class="radm-label">Staff Role <span style="color:#ef4444;">*</span></label>
                    <select id="radm-cu-role" class="radm-select" style="width: 100%;">
                        <?php foreach ( $all_roles as $r_slug => $r_info ) : ?>
                            <option value="<?php echo esc_attr( $r_slug ); ?>" <?php selected( $r_slug, 'radm_admin' ); ?>>
                                <?php echo esc_html( $r_info['name'] ); ?> <?php echo ! empty( $r_info['is_system'] ) ? '(System)' : '(Custom)'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="radm-modal-footer">
                <button type="button" class="radm-btn radm-btn-outline" id="radm-create-user-cancel">Cancel</button>
                <button type="submit" class="radm-btn radm-btn-primary" id="radm-create-user-submit">
                    <span>Create Staff User</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════
     DELETE STAFF USER CONFIRMATION MODAL
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-delete-user-overlay" aria-hidden="true">
    <div class="radm-modal" style="max-width: 440px;">
        <div class="radm-modal-header" style="border-bottom: 1px solid #fee2e2;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <div>
                    <h3 style="margin: 0; color: #b91c1c; font-size: 17px;">Delete Staff User</h3>
                    <p style="margin: 2px 0 0; font-size: 12px; color: var(--radm-text-muted);">This action cannot be undone.</p>
                </div>
            </div>
            <button type="button" class="radm-modal-close" id="radm-del-user-close" aria-label="Close">×</button>
        </div>
        <div class="radm-modal-body" style="padding: 20px 24px;">
            <p style="margin: 0 0 12px; font-size: 14px; color: var(--radm-text); line-height: 1.5;">
                Are you sure you want to delete staff user <strong id="radm-del-user-name" style="color: #1e293b;">this user</strong>?
            </p>
            <p style="margin: 0; font-size: 12.5px; color: var(--radm-text-muted);">
                Their access permissions and WordPress login account will be permanently removed.
            </p>
        </div>
        <div class="radm-modal-footer" style="background: #f8fafc; border-top: 1px solid var(--radm-border); display: flex; justify-content: flex-end; gap: 10px; padding: 14px 20px;">
            <button type="button" class="radm-btn radm-btn-outline" id="radm-del-user-cancel-btn">Cancel</button>
            <button type="button" class="radm-btn radm-btn-danger" id="radm-del-user-confirm-btn" style="background: #dc2626; color: #fff; border-color: #dc2626;">
                Delete User
            </button>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════
     RESET USER PASSWORD MODAL (SUPER ADMIN)
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-reset-password-overlay" aria-hidden="true">
    <div class="radm-modal" style="max-width: 480px; width: 94%;">
        
        <div class="radm-modal-header">
            <div>
                <h3 style="margin: 0 0 2px;">Reset User Password</h3>
                <p style="margin: 0; font-size: 13px; color: var(--radm-text-muted);">Set a new password for staff member who forgot their credentials</p>
            </div>
            <button type="button" class="radm-modal-close" id="radm-reset-pwd-close" aria-label="Close modal">×</button>
        </div>

        <form id="radm-reset-password-form">
            <input type="hidden" id="radm-rp-user-id" value="" />

            <div class="radm-modal-body" style="padding: 20px 24px; display: flex; flex-direction: column; gap: 16px;">
                
                <!-- Target User Info Card -->
                <div style="background: #f8fafc; border: 1px solid var(--radm-border); border-radius: 8px; padding: 12px 16px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #e8f5e9; color: #2E7D32; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 15px;" id="radm-rp-user-initial">
                        U
                    </div>
                    <div>
                        <strong id="radm-rp-user-name" style="display: block; font-size: 14px; color: var(--radm-text);">Staff Name</strong>
                        <span id="radm-rp-user-email" style="font-size: 12px; color: var(--radm-text-muted);">staff@email.com</span>
                    </div>
                </div>

                <div class="radm-form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label class="radm-label" for="radm-rp-new-password" style="margin-bottom: 0;">New Password <span style="color:#ef4444;">*</span></label>
                        <button type="button" id="radm-rp-generate-btn" style="background: none; border: none; color: var(--radm-green-primary); font-size: 12px; font-weight: 600; cursor: pointer; padding: 0;">
                            🎲 Generate Strong Password
                        </button>
                    </div>
                    <div style="position: relative;">
                        <input type="password" id="radm-rp-new-password" class="radm-input" placeholder="Enter new password" minlength="6" required style="padding-right: 40px;" />
                        <button type="button" class="radm-pwd-toggle-btn" data-target="radm-rp-new-password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--radm-text-muted); padding: 4px;" title="Show/Hide Password">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <div class="radm-form-group">
                    <label class="radm-label" for="radm-rp-confirm-password">Confirm Password <span style="color:#ef4444;">*</span></label>
                    <div style="position: relative;">
                        <input type="password" id="radm-rp-confirm-password" class="radm-input" placeholder="Confirm new password" minlength="6" required style="padding-right: 40px;" />
                        <button type="button" class="radm-pwd-toggle-btn" data-target="radm-rp-confirm-password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--radm-text-muted); padding: 4px;" title="Show/Hide Password">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <p style="margin: 0; font-size: 12px; color: var(--radm-text-muted); line-height: 1.4;">
                    ℹ️ Stale sessions for this user will be invalidated automatically. The user can immediately log in using this password.
                </p>

            </div>

            <div class="radm-modal-footer">
                <button type="button" class="radm-btn radm-btn-outline" id="radm-reset-pwd-cancel">Cancel</button>
                <button type="submit" class="radm-btn radm-btn-primary" id="radm-reset-pwd-submit">
                    <span id="radm-reset-pwd-submit-text">Reset Password</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════
     CREATE CUSTOM ROLE MODAL (SUPER ADMIN)
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-create-role-overlay" aria-hidden="true">
    <div class="radm-modal" style="max-width: 620px; width: 94%;">
        
        <div class="radm-modal-header">
            <div>
                <h3 style="margin: 0 0 2px;">Create Custom Role</h3>
                <p style="margin: 0; font-size: 13px; color: var(--radm-text-muted);">Define a new staff role and attach specific module access rights</p>
            </div>
            <button type="button" class="radm-modal-close" id="radm-create-role-close" aria-label="Close modal">×</button>
        </div>

        <form id="radm-create-role-form">
            <div class="radm-modal-body" style="padding: 20px 24px; display: flex; flex-direction: column; gap: 16px;">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="radm-form-group">
                        <label class="radm-label">Role Display Name <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="radm-cr-name" class="radm-input" placeholder="e.g. Camp Coordinator" required />
                    </div>
                    <div class="radm-form-group">
                        <label class="radm-label">Role Key / Slug (optional)</label>
                        <input type="text" id="radm-cr-slug" class="radm-input" placeholder="auto-generated, e.g. radm_camp_coordinator" />
                    </div>
                </div>

                <!-- Attached Access Rights (Modules Checklist) -->
                <div class="radm-form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label class="radm-label" style="margin-bottom: 0; font-weight: 600;">Attach Module Access Rights <span style="color:#ef4444;">*</span></label>
                        <div style="display: flex; gap: 10px;">
                            <button type="button" id="radm-cr-select-all-mods" style="background: none; border: none; color: var(--radm-green-primary); font-size: 12px; font-weight: 600; cursor: pointer; padding: 0;">Select All</button>
                            <span style="color: var(--radm-border);">|</span>
                            <button type="button" id="radm-cr-clear-all-mods" style="background: none; border: none; color: var(--radm-text-muted); font-size: 12px; font-weight: 600; cursor: pointer; padding: 0;">Clear All</button>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; max-height: 200px; overflow-y: auto; border: 1px solid var(--radm-border); border-radius: 8px; padding: 12px; background: #fafafa;">
                        <?php foreach ( $all_modules as $m_k => $m_v ) : ?>
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer; padding: 4px; border-radius: 4px;">
                                <input type="checkbox" name="radm_cr_mod_check" value="<?php echo esc_attr( $m_k ); ?>" <?php checked( $m_k, 'dashboard' ); ?> />
                                <span><?php echo esc_html( $m_v['label'] ); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Center Restriction Scope -->
                <div class="radm-form-group">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: var(--radm-text);">
                        <input type="checkbox" id="radm-cr-restrict-center-toggle" />
                        <span>Restrict role by default to specific centers</span>
                    </label>
                    <div id="radm-cr-centers-wrapper" style="display: none; margin-top: 10px; border: 1px solid var(--radm-border); border-radius: 8px; padding: 10px; max-height: 180px; overflow-y: auto; background: #fafafa;">
                        <?php foreach ( $all_centers as $c ) : ?>
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer; margin-bottom: 6px;">
                                <input type="checkbox" name="radm_cr_center_check" value="<?php echo esc_attr( $c['name'] ); ?>" />
                                <span><?php echo esc_html( $c['name'] ); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

            <div class="radm-modal-footer">
                <button type="button" class="radm-btn radm-btn-outline" id="radm-create-role-cancel">Cancel</button>
                <button type="submit" class="radm-btn radm-btn-primary" id="radm-create-role-submit">
                    <span id="radm-create-role-submit-text">Create Role</span>
                </button>
            </div>
        </form>

    </div>
</div>

<?php radm_portal_footer(); ?>
