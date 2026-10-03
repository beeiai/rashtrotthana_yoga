<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

radm_portal_header( 'Form Groups', 'Manage center-wise Google Form links. Users will select a center and be redirected to the respective Google Form.' );
?>

<!-- ── Top Breadcrumb Bar ─────────────────────────────────────────── -->
<div class="radm-page-topbar" style="margin-bottom: 20px;">
    <nav class="radm-breadcrumb">
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-dashboard' ) ); ?>">Home</a>
        <span class="sep">&gt;</span>
        <span class="current">Form Groups</span>
    </nav>
</div>

<!-- ── Header Search, Filter & Create Action ──────────────────────── -->
<div class="radm-fg-top-row">
    <div class="radm-fg-filters-left">
        <div class="radm-search-wrap">
            <svg class="radm-search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="radm-fg-search-input" class="radm-input radm-fg-search"
                   placeholder="Search form groups..." />
        </div>

        <div class="radm-select-wrap">
            <select id="radm-fg-status-filter" class="radm-input radm-select">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </div>

    <button type="button" class="radm-btn radm-btn-primary" id="radm-fg-create-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="12" y2="12"/>
        </svg>
        Create Form Group
    </button>
</div>

<!-- ── Form Groups Table ──────────────────────────────────────────── -->
<div class="radm-card" style="padding: 0; overflow: visible; margin-top: 18px;">
    <div class="radm-table-responsive" style="overflow: visible; min-height: 280px;">
        <table class="radm-table radm-fg-table">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">#</th>
                    <th style="min-width: 220px;">Form Group Name</th>
                    <th style="min-width: 250px;">Centers</th>
                    <th style="width: 120px; text-align: center;">Total Centers</th>
                    <th style="width: 110px;">Status</th>
                    <th style="width: 130px;">Created On</th>
                    <th style="width: 180px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody id="radm-fg-tbody">
                <tr>
                    <td colspan="7" style="text-align: center; padding: 50px 20px; color: var(--radm-text-muted);">
                        <div class="radm-spinner" style="margin: 0 auto 12px;"></div>
                        Loading form groups...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Table Footer / Pagination -->
    <div class="radm-fg-footer" id="radm-fg-footer" style="display: none;">
        <div class="radm-fg-counter">
            Showing <span id="radm-fg-start">1</span> to <span id="radm-fg-end">10</span> of <span id="radm-fg-total">0</span> form groups
        </div>
        <div class="radm-fg-pagination" id="radm-fg-pagination"></div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════
     CREATE / EDIT MULTI-STEP MODAL (EXACT MATCH TO REFERENCE DESIGN)
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-fg-wizard-overlay" aria-hidden="true">
    <div class="radm-modal radm-modal--wizard" style="max-width: 820px; width: 94%; padding: 0; overflow: hidden; border-radius: 16px;">
        
        <!-- Wizard Modal Header -->
        <div class="radm-modal-header" style="padding: 16px 24px; border-bottom: 1px solid var(--radm-border); background: #ffffff;">
            <h3 id="radm-fg-modal-heading" style="font-size: 17px; margin: 0; font-weight: 700; color: var(--radm-text);">Create Form Group</h3>
            <button type="button" class="radm-modal-close" id="radm-fg-wizard-close" aria-label="Close modal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <div class="radm-wizard-layout">
            
            <!-- Left Steps Sidebar -->
            <aside class="radm-wizard-sidebar">
                <div class="radm-wizard-step-item is-active" data-step="1" id="radm-step-nav-1">
                    <div class="radm-step-badge">1</div>
                    <div class="radm-step-info">
                        <strong>Basic Details</strong>
                        <small>Form group information</small>
                    </div>
                </div>

                <div class="radm-wizard-step-item" data-step="2" id="radm-step-nav-2">
                    <div class="radm-step-badge">2</div>
                    <div class="radm-step-info">
                        <strong>Center Form Links</strong>
                        <small>Add Google Form links</small>
                    </div>
                </div>

                <div class="radm-wizard-step-item" data-step="3" id="radm-step-nav-3">
                    <div class="radm-step-badge">3</div>
                    <div class="radm-step-info">
                        <strong>Review &amp; Save</strong>
                        <small>Confirm details</small>
                    </div>
                </div>
            </aside>

            <!-- Right Content Container -->
            <div class="radm-wizard-content">
                <form id="radm-fg-form" onsubmit="return false;">
                    <input type="hidden" id="radm-fg-input-id" value="" />

                    <!-- ── STEP 1: Basic Details ── -->
                    <div class="radm-wizard-step-panel is-active" id="radm-step-panel-1">
                        <div class="radm-panel-header">
                            <h4>Basic Details</h4>
                            <p>Enter the form group name and description.</p>
                        </div>

                        <div class="radm-form-group" style="margin-bottom: 16px;">
                            <label class="radm-label" for="radm-fg-input-name">Form Group Name <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="radm-fg-input-name" class="radm-input"
                                   placeholder="e.g. Yoga Camp Registration" required />
                        </div>

                        <div class="radm-form-group" style="margin-bottom: 18px;">
                            <label class="radm-label">Status</label>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <label class="radm-switch">
                                    <input type="checkbox" id="radm-fg-input-status" checked />
                                    <span class="radm-slider"></span>
                                </label>
                                <span id="radm-fg-status-label" style="font-size: 14px; font-weight: 600; color: #166534;">Active</span>
                            </div>
                            <small style="color: var(--radm-text-muted); font-size: 12px; margin-top: 4px; display: block;">
                                Form group will be visible to users on the website.
                            </small>
                        </div>

                        <div class="radm-form-group" style="margin-bottom: 24px;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline;">
                                <label class="radm-label" for="radm-fg-input-desc">Description <span style="font-weight: normal; color: var(--radm-text-muted);">(Optional)</span></label>
                                <span id="radm-fg-char-count" style="font-size: 11.5px; color: var(--radm-text-muted);">0/200</span>
                            </div>
                            <textarea id="radm-fg-input-desc" class="radm-input" rows="3" maxlength="200"
                                      placeholder="Summer yoga camp registration forms for different centers."></textarea>
                        </div>

                        <div class="radm-wizard-footer">
                            <button type="button" class="radm-btn radm-btn-outline radm-wizard-cancel-btn">Cancel</button>
                            <button type="button" class="radm-btn radm-btn-primary" id="radm-step1-next-btn">
                                Next &rarr;
                            </button>
                        </div>
                    </div>

                    <!-- ── STEP 2: Center Form Links ── -->
                    <div class="radm-wizard-step-panel" id="radm-step-panel-2" style="display: none;">
                        <div class="radm-panel-header" style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">
                            <div>
                                <h4>Center Form Links</h4>
                                <p>Add Google Form links for each center. Users will be redirected to the selected center's form.</p>
                            </div>
                            <button type="button" class="radm-btn radm-btn-outline" id="radm-fg-add-center-row-btn" style="padding: 6px 14px; font-size: 13px; white-space: nowrap;">
                                + Add Center
                            </button>
                        </div>

                        <div class="radm-center-rows-container">
                            <table class="radm-center-table">
                                <thead>
                                    <tr>
                                        <th style="width: 36px; text-align: center;">#</th>
                                        <th style="width: 38%;">Center Name <span style="color:#ef4444;">*</span></th>
                                        <th>Google Form Link <span style="color:#ef4444;">*</span></th>
                                        <th style="width: 50px; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="radm-fg-centers-tbody">
                                    <!-- Dynamic Rows rendered via JS -->
                                </tbody>
                            </table>
                        </div>

                        <div class="radm-wizard-footer" style="margin-top: 24px;">
                            <button type="button" class="radm-btn radm-btn-outline" id="radm-step2-back-btn">&larr; Back</button>
                            <div style="display: flex; gap: 10px;">
                                <button type="button" class="radm-btn radm-btn-outline radm-wizard-cancel-btn">Cancel</button>
                                <button type="button" class="radm-btn radm-btn-primary" id="radm-step2-next-btn">Next &rarr;</button>
                            </div>
                        </div>
                    </div>

                    <!-- ── STEP 3: Review & Save ── -->
                    <div class="radm-wizard-step-panel" id="radm-step-panel-3" style="display: none;">
                        <div class="radm-panel-header">
                            <h4>Review &amp; Save</h4>
                            <p>Review form group configuration before saving.</p>
                        </div>

                        <div class="radm-review-card">
                            <div class="radm-review-row">
                                <span class="radm-review-label">Form Group Name:</span>
                                <strong id="radm-rev-name" style="font-size: 15px; color: var(--radm-text);">-</strong>
                            </div>
                            <div class="radm-review-row">
                                <span class="radm-review-label">Status:</span>
                                <span id="radm-rev-status">-</span>
                            </div>
                            <div class="radm-review-row">
                                <span class="radm-review-label">Description:</span>
                                <span id="radm-rev-desc" style="color: var(--radm-text-muted); font-size: 13.5px;">-</span>
                            </div>
                            <div class="radm-review-row">
                                <span class="radm-review-label">Total Centers Configured:</span>
                                <strong id="radm-rev-total-centers" style="color: var(--radm-green-primary); font-size: 15px;">0</strong>
                            </div>
                        </div>

                        <div style="margin-top: 18px;">
                            <h5 style="font-size: 13.5px; font-weight: 600; margin: 0 0 8px; color: var(--radm-text);">Configured Centers &amp; Links</h5>
                            <div class="radm-review-centers-list" id="radm-rev-centers-list">
                                <!-- Populated via JS -->
                            </div>
                        </div>

                        <div class="radm-wizard-footer" style="margin-top: 24px;">
                            <button type="button" class="radm-btn radm-btn-outline" id="radm-step3-back-btn">&larr; Back</button>
                            <div style="display: flex; gap: 10px;">
                                <button type="button" class="radm-btn radm-btn-outline radm-wizard-cancel-btn">Cancel</button>
                                <button type="button" class="radm-btn radm-btn-primary" id="radm-fg-save-submit-btn">
                                    <span id="radm-fg-save-submit-text">Save Form Group</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div><!-- /.radm-wizard-content -->

        </div><!-- /.radm-wizard-layout -->

    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════
     VIEW FORM GROUP MODAL
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-fg-view-overlay" aria-hidden="true">
    <div class="radm-modal radm-modal--md" style="max-width: 600px;">
        <div class="radm-modal-header">
            <h3 id="radm-fg-view-title">Form Group Details</h3>
            <button type="button" class="radm-modal-close" id="radm-fg-view-close" aria-label="Close modal">×</button>
        </div>
        <div class="radm-modal-body" style="padding: 20px 24px;">
            <div style="margin-bottom: 14px;">
                <span style="font-size: 12px; color: var(--radm-text-muted); font-weight: 600; text-transform: uppercase;">Description</span>
                <p id="radm-fg-view-desc" style="margin: 4px 0 0; font-size: 14px; color: var(--radm-text);"></p>
            </div>

            <div style="margin-bottom: 12px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 12px 14px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <span style="font-size: 12px; color: #166534; font-weight: 700; text-transform: uppercase;">🔗 ONE SINGLE REGISTRATION LINK (WhatsApp, Posters, Events)</span>
                    <a id="radm-fg-view-open-link" href="#" target="_blank" style="font-size: 12px; color: #2E7D32; font-weight: 600; text-decoration: underline;">Test Open &rarr;</a>
                </div>
                <div style="display: flex; gap: 8px;">
                    <input type="text" id="radm-fg-view-directlink" class="radm-input" readonly style="background:#ffffff; font-family: monospace; font-size: 13px;" />
                    <button type="button" class="radm-btn radm-btn-primary" id="radm-fg-copy-directlink-btn" style="white-space: nowrap;">Copy Link</button>
                </div>
            </div>


            <div>
                <span style="font-size: 12px; color: var(--radm-text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 8px; display: block;">Center Links (<span id="radm-fg-view-center-count">0</span>)</span>
                <div class="radm-view-centers-list" id="radm-fg-view-centers-list" style="max-height: 220px; overflow-y: auto; border: 1px solid var(--radm-border); border-radius: 10px;"></div>
            </div>
        </div>
        <div class="radm-modal-footer" style="display: flex; justify-content: space-between; align-items: center;">
            <button type="button" class="radm-btn radm-btn-danger" id="radm-fg-view-del-btn" style="padding: 8px 14px; font-size: 13px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                </svg>
                Delete Form Group
            </button>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="radm-btn radm-btn-primary" id="radm-fg-view-edit-btn">Edit Form Group</button>
                <button type="button" class="radm-btn radm-btn-outline" id="radm-fg-view-close-btn">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════
     DELETE CONFIRMATION MODAL
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-fg-delete-overlay" aria-hidden="true">
    <div class="radm-modal radm-modal--sm">
        <div class="radm-modal-header">
            <h3>Delete Form Group</h3>
            <button type="button" class="radm-modal-close" id="radm-fg-delete-close" aria-label="Close modal">×</button>
        </div>
        <div class="radm-modal-body">
            <p>Are you sure you want to delete <strong id="radm-fg-delete-name">this form group</strong>?</p>
            <p style="color:var(--radm-text-muted); font-size:13px; margin-top:6px;">This will remove all associated center Google Form links.</p>
        </div>
        <div class="radm-modal-footer">
            <button type="button" class="radm-btn radm-btn-outline" id="radm-fg-delete-cancel-btn">Cancel</button>
            <button type="button" class="radm-btn radm-btn-danger" id="radm-fg-delete-confirm-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                </svg>
                Yes, Delete
            </button>
        </div>
    </div>
</div>

<?php radm_portal_footer(); ?>
