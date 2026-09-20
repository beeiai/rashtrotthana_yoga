<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

radm_portal_header( 'Form Groups Router', 'Enterprise Google Form Routing Engine & Analytics' );

// Fetch initial list of Form Groups
$groups_map = get_option( 'radm_form_groups', [] );
$groups     = is_array( $groups_map ) ? array_values( $groups_map ) : [];
?>

<!-- ── Top Bar ─────────────────────────────────────────────────────────── -->
<div class="radm-reg-topbar">
    <div style="display:flex;align-items:center;gap:10px;">
        <div class="radm-input-icon" style="max-width:280px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" class="radm-input" id="radm-fg-search"
                   placeholder="Search Form Groups…" style="font-size:13px;">
        </div>
        <span class="radm-count-label" id="radm-fg-count">
            <?php echo count($groups); ?> group<?php echo count($groups) !== 1 ? 's' : ''; ?>
        </span>
    </div>
    <button type="button" class="radm-btn radm-btn-primary" id="radm-add-fg-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Add Form Group
    </button>
</div>

<!-- ── Shortcode Explanation Banner ────────────────────────────────────── -->
<div class="radm-shortcode-hint">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
    <div>
        <strong>Industry-Standard Form Router:</strong> Group multiple centre Google Forms under a single vanity link or shortcode (e.g. <code>yoga-2026</code>). Users select their centre via visual cards grid or dropdown, and are seamlessly redirected to their centre's form with full click tracking!
    </div>
</div>

<!-- ── Form Groups Table ────────────────────────────────────────────────── -->
<div class="radm-card">
    <div class="radm-table-wrap">
        <table class="radm-table" id="radm-fg-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Form Group Title & Slug</th>
                    <th>Centres</th>
                    <th>Mode & Layout</th>
                    <th>Analytics</th>
                    <th>Shortcode</th>
                    <th>Direct Share Link</th>
                    <th style="width:190px;text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody id="radm-fg-tbody">
                <?php if ( empty( $groups ) ) : ?>
                <tr id="radm-fg-empty">
                    <td colspan="8">
                        <div class="radm-coming-soon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                            </svg>
                            <h3>No Form Groups Created Yet</h3>
                            <p>Click "Add Form Group" to combine multiple centre Google Forms into one smart router page.</p>
                        </div>
                    </td>
                </tr>
                <?php else :
                    foreach ( $groups as $i => $g ) :
                        $g_id         = esc_attr( $g['id'] ?? '' );
                        $slug         = esc_attr( $g['slug'] ?? $g_id );
                        $title        = esc_html( $g['title'] ?? 'Untitled Group' );
                        $desc         = esc_html( $g['description'] ?? '' );
                        $action_mode  = esc_attr( $g['action_mode'] ?? 'redirect' );
                        $ui_layout    = esc_attr( $g['ui_layout'] ?? 'cards' );
                        $centres      = is_array( $g['centres'] ?? null ) ? $g['centres'] : [];
                        $c_count      = count( $centres );
                        
                        $analytics    = is_array( $g['analytics'] ?? null ) ? $g['analytics'] : [];
                        $total_clicks = array_sum( $analytics );
                        
                        $shortcode    = '[ry_form_group slug="' . $slug . '"]';
                        $direct_url   = home_url( '/?ry_form_group=' . $slug );
                        $updated_at   = esc_html( $g['updated_at'] ?? '—' );
                        $json_data    = esc_attr( wp_json_encode( $g ) );
                ?>
                <tr class="radm-fg-row" data-id="<?php echo $g_id; ?>" data-group='<?php echo $json_data; ?>'>
                    <td style="color:var(--radm-text-muted);font-weight:600;"><?php echo $i + 1; ?></td>
                    <td>
                        <strong style="color:var(--radm-text);display:block;font-size:14px;"><?php echo $title; ?></strong>
                        <code style="font-size:11.5px;color:#6366f1;background:#eef2ff;padding:2px 6px;border-radius:4px;display:inline-block;margin-top:3px;">
                            /<?php echo $slug; ?>
                        </code>
                        <?php if ( $desc ) : ?>
                            <small style="color:var(--radm-text-muted);font-size:11.5px;display:block;margin-top:2px;"><?php echo $desc; ?></small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="radm-badge radm-badge--open" style="font-weight:600;">
                            <?php echo $c_count; ?> Centre<?php echo $c_count !== 1 ? 's' : ''; ?>
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;flex-direction:column;gap:4px;">
                            <span class="radm-badge <?php echo $action_mode === 'redirect' ? 'radm-badge--open' : 'radm-badge--draft'; ?>" style="font-size:11px;">
                                <?php echo $action_mode === 'redirect' ? '⚡ Redirect' : '🖼️ Embed'; ?>
                            </span>
                            <span class="radm-badge" style="font-size:11px;background:#f1f5f9;color:#475569;">
                                <?php echo $ui_layout === 'cards' ? '🎴 Visual Cards' : '🔽 Dropdown'; ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="radm-btn radm-btn-outline radm-fg-analytics-btn" data-id="<?php echo $g_id; ?>" style="padding:4px 9px;font-size:12px;display:inline-flex;align-items:center;gap:5px;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13">
                                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                            </svg>
                            <strong><?php echo number_format( $total_clicks ); ?></strong> Clicks
                        </button>
                    </td>
                    <td>
                        <div class="radm-shortcode-badge">
                            <code><?php echo esc_html( $shortcode ); ?></code>
                            <button type="button" class="radm-copy-sc-btn" data-code="<?php echo esc_attr( $shortcode ); ?>" title="Copy shortcode">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="13" height="13">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                    <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                    <td>
                        <div class="radm-shortcode-badge" style="background:#e0f2fe;border-color:#bae6fd;">
                            <code style="color:#0369a1;"><?php echo esc_html( substr( $direct_url, 0, 28 ) . '…' ); ?></code>
                            <button type="button" class="radm-copy-sc-btn" data-code="<?php echo esc_attr( $direct_url ); ?>" title="Copy Direct Share Link">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="13" height="13">
                                    <path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/>
                                    <path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/>
                                </svg>
                            </button>
                            <a href="<?php echo esc_url( $direct_url ); ?>" target="_blank" rel="noopener" class="radm-copy-sc-btn" title="Open Form Page in New Tab">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="13" height="13">
                                    <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                                    <polyline points="15 3 21 3 21 9"/>
                                    <line x1="10" y1="14" x2="21" y2="3"/>
                                </svg>
                            </a>
                        </div>
                    </td>
                    <td style="text-align:center;">
                        <div class="radm-action-group" style="justify-content:center;">
                            <button type="button" class="radm-icon-btn radm-icon-btn--edit radm-preview-fg-btn"
                                    title="Preview Group Form" data-id="<?php echo $g_id; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--edit radm-edit-fg-btn"
                                    title="Edit Form Group" data-id="<?php echo $g_id; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="radm-icon-btn radm-icon-btn--delete radm-delete-fg-btn"
                                    title="Delete Form Group" data-id="<?php echo $g_id; ?>" data-title="<?php echo $title; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     CREATE / EDIT FORM GROUP MODAL
     ══════════════════════════════════════════════════════════════ -->
<div id="radm-fg-modal-overlay" class="radm-modal-overlay" aria-hidden="true">
    <div class="radm-modal radm-modal--lg" role="dialog" aria-modal="true" style="max-width:800px;">

        <div class="radm-modal-header">
            <h3 id="radm-fg-modal-title">Add Form Group</h3>
            <button type="button" class="radm-modal-close" id="radm-fg-modal-close" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <div class="radm-modal-body" style="max-height:75vh;overflow-y:auto;">
            <input type="hidden" id="radm-fg-id">

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:14px;">
                <div class="radm-form-group">
                    <label class="radm-label" for="radm-fg-title">Form Group Title <span class="req">*</span></label>
                    <input type="text" id="radm-fg-title" class="radm-input"
                           placeholder="e.g. Yoga Course 2026 Registration" required>
                </div>
                <div class="radm-form-group">
                    <label class="radm-label" for="radm-fg-slug">URL Slug / Identifier <span style="font-weight:normal;color:var(--radm-text-muted);">(Optional)</span></label>
                    <input type="text" id="radm-fg-slug" class="radm-input"
                           placeholder="e.g. yoga-2026">
                    <small style="color:var(--radm-text-muted);font-size:11px;">Used in direct URLs: <code>?ry_form_group=slug</code></small>
                </div>
            </div>

            <div class="radm-form-group" style="margin-bottom:16px;">
                <label class="radm-label" for="radm-fg-desc">Description / Instructions <span style="font-weight:normal;color:var(--radm-text-muted);">(Optional)</span></label>
                <textarea id="radm-fg-desc" class="radm-textarea" rows="2"
                          placeholder="e.g. Select your nearest centre below to open the registration form."></textarea>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;background:#f8fafc;padding:14px;border-radius:8px;border:1px solid #e2e8f0;">
                <div class="radm-form-group" style="margin:0;">
                    <label class="radm-label" style="margin-bottom:6px;">Selection Action Mode</label>
                    <div style="display:flex;flex-direction:column;gap:8px;">
                        <label style="display:flex;align-items:center;gap:7px;cursor:pointer;font-size:13px;">
                            <input type="radio" name="radm_fg_action_mode" value="redirect" checked>
                            <span><strong>⚡ Direct Redirect</strong> (Auto countdown + open URL)</span>
                        </label>
                        <label style="display:flex;align-items:center;gap:7px;cursor:pointer;font-size:13px;">
                            <input type="radio" name="radm_fg_action_mode" value="embed">
                            <span><strong>🖼️ Embed in Page</strong> (Load inside Iframe)</span>
                        </label>
                    </div>
                </div>

                <div class="radm-form-group" style="margin:0;">
                    <label class="radm-label" style="margin-bottom:6px;">User Display Layout</label>
                    <div style="display:flex;flex-direction:column;gap:8px;">
                        <label style="display:flex;align-items:center;gap:7px;cursor:pointer;font-size:13px;">
                            <input type="radio" name="radm_fg_ui_layout" value="cards" checked>
                            <span><strong>🎴 Visual Cards Grid</strong> (Recommended, with search)</span>
                        </label>
                        <label style="display:flex;align-items:center;gap:7px;cursor:pointer;font-size:13px;">
                            <input type="radio" name="radm_fg_ui_layout" value="dropdown">
                            <span><strong>🔽 Compact Dropdown</strong> (Simple select box)</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Centre Mappings Section -->
            <div style="border-top:1px solid var(--radm-border);padding-top:16px;margin-top:16px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                    <div>
                        <strong style="font-size:14px;color:var(--radm-text);">Centre Google Form Mappings</strong>
                        <p style="margin:2px 0 0;font-size:12px;color:var(--radm-text-muted);">Map each Centre Name to its specific Google Form URL.</p>
                    </div>
                    <button type="button" class="radm-btn radm-btn-outline" id="radm-fg-add-centre-row-btn" style="padding:6px 12px;font-size:12.5px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="14" height="14">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Add Centre
                    </button>
                </div>

                <div id="radm-fg-centres-container" style="display:flex;flex-direction:column;gap:10px;">
                    <!-- Dynamic Rows Injected Here by JS -->
                </div>
            </div>
        </div>

        <div class="radm-modal-footer">
            <button type="button" class="radm-btn radm-btn-outline" id="radm-fg-cancel-btn">Cancel</button>
            <button type="button" class="radm-btn radm-btn-primary" id="radm-fg-save-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Save Form Group
            </button>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     FORM GROUP PREVIEW MODAL
     ══════════════════════════════════════════════════════════════ -->
<div id="radm-fg-preview-overlay" class="radm-modal-overlay" aria-hidden="true">
    <div class="radm-modal radm-modal--lg" role="dialog" aria-modal="true" style="max-width:860px;width:95%;">
        <div class="radm-modal-header">
            <h3 id="radm-fg-preview-title">Form Group Live Preview</h3>
            <button type="button" class="radm-modal-close" id="radm-fg-preview-close" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="radm-modal-body" style="padding:16px;">
            <div id="radm-fg-preview-body">
                <!-- Shortcode live UI rendered here by JS -->
            </div>
        </div>
        <div class="radm-modal-footer">
            <button type="button" class="radm-btn radm-btn-outline" id="radm-fg-preview-close-btn">Close Preview</button>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     FORM GROUP ANALYTICS MODAL
     ══════════════════════════════════════════════════════════════ -->
<div id="radm-fg-analytics-overlay" class="radm-modal-overlay" aria-hidden="true">
    <div class="radm-modal" role="dialog" aria-modal="true" style="max-width:600px;width:95%;">
        <div class="radm-modal-header">
            <h3 id="radm-fg-analytics-title">Centre Click Analytics</h3>
            <button type="button" class="radm-modal-close" id="radm-fg-analytics-close" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="radm-modal-body" style="padding:16px;">
            <div id="radm-fg-analytics-content">
                <!-- Analytics Breakdown Rendered Here by JS -->
            </div>
        </div>
        <div class="radm-modal-footer">
            <button type="button" class="radm-btn radm-btn-outline" id="radm-fg-analytics-close-btn">Close</button>
        </div>
    </div>
</div>

<?php
radm_portal_footer();
