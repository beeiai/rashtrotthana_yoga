<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

radm_portal_header( 'Gallery', 'Upload and manage photos and videos to be displayed on your website gallery.' );
?>

<!-- ── Top Breadcrumb Bar ─────────────────────────────────────────── -->
<div class="radm-page-topbar" style="margin-bottom: 20px;">
    <nav class="radm-breadcrumb">
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=radm-dashboard' ) ); ?>">Home</a>
        <span class="sep">&gt;</span>
        <span class="current">Gallery</span>
    </nav>
</div>

<!-- ── Gallery Header Actions & Primary Type Tabs ────────────────── -->
<div class="radm-gallery-top-row">
    <!-- Type Filter Tabs (All, Images, Videos) -->
    <div class="radm-gallery-tabs" id="radm-gallery-type-tabs">
        <button type="button" class="radm-gallery-tab is-active" data-type="all">
            All (<span id="radm-gcount-all">0</span>)
        </button>
        <button type="button" class="radm-gallery-tab" data-type="image">
            Images (<span id="radm-gcount-image">0</span>)
        </button>
        <button type="button" class="radm-gallery-tab" data-type="video">
            Videos (<span id="radm-gcount-video">0</span>)
        </button>
    </div>

    <!-- Search & Upload CTA -->
    <div class="radm-gallery-top-right">
        <div class="radm-search-wrap">
            <svg class="radm-search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="radm-gallery-search-input" class="radm-input radm-gallery-search"
                   placeholder="Search media..." />
        </div>

        <button type="button" class="radm-btn radm-btn-primary radm-open-upload-btn" id="radm-upload-media-btn" onclick="if(window.radmOpenGalleryModal){window.radmOpenGalleryModal(null);}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="12" y2="12"/>
            </svg>
            + Upload Media
        </button>
    </div>
</div>

<?php
// Dynamically query categories from taxonomy & postmeta
$gallery_terms = get_terms( [
    'taxonomy'   => 'gallery_category',
    'hide_empty' => false,
] );
$dynamic_cats = [];
if ( ! empty( $gallery_terms ) && ! is_wp_error( $gallery_terms ) ) {
    foreach ( $gallery_terms as $term ) {
        $dynamic_cats[] = $term->name;
    }
}
global $wpdb;
$meta_cats = $wpdb->get_col( "SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_ry_gallery_category' AND meta_value != ''" );
if ( ! empty( $meta_cats ) ) {
    $dynamic_cats = array_unique( array_merge( $dynamic_cats, $meta_cats ) );
}
sort( $dynamic_cats );
?>

<!-- ── Secondary Filter Bar (Category, Event, Status, Sort) ───────── -->
<div class="radm-gallery-filter-bar">
    <div class="radm-filter-group">
        <label class="radm-filter-label" for="radm-filter-category">Category</label>
        <select id="radm-filter-category" class="radm-filter-select">
            <option value="">All Categories</option>
            <?php
            foreach ( $dynamic_cats as $cat_name ) {
                echo '<option value="' . esc_attr( $cat_name ) . '">' . esc_html( $cat_name ) . '</option>';
            }
            ?>
        </select>
    </div>

    <div class="radm-filter-group">
        <label class="radm-filter-label" for="radm-filter-event">Event</label>
        <select id="radm-filter-event" class="radm-filter-select">
            <option value="">All Events</option>
            <?php
            $events = get_posts( [
                'post_type'      => 'ry_event',
                'post_status'    => [ 'publish', 'draft' ],
                'posts_per_page' => 50,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ] );
            if ( ! empty( $events ) ) {
                foreach ( $events as $ev ) {
                    echo '<option value="' . esc_attr( $ev->ID ) . '">' . esc_html( $ev->post_title ) . '</option>';
                }
            }
            ?>
        </select>
    </div>

    <div class="radm-filter-group">
        <label class="radm-filter-label" for="radm-filter-status">Status</label>
        <select id="radm-filter-status" class="radm-filter-select">
            <option value="">All Status</option>
            <option value="publish">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    <div class="radm-filter-group radm-filter-group--sort">
        <label class="radm-filter-label" for="radm-filter-sort">Sort by</label>
        <select id="radm-filter-sort" class="radm-filter-select">
            <option value="latest">Latest First</option>
            <option value="oldest">Oldest First</option>
            <option value="title_asc">Name (A-Z)</option>
            <option value="title_desc">Name (Z-A)</option>
        </select>
    </div>
</div>

<!-- ── Media Grid ────────────────────────────────────────────────── -->
<div class="radm-gallery-grid-wrap">
    <div class="radm-gallery-grid" id="radm-gallery-grid">
        <!-- Dynamic Cards rendered via JS -->
        <div class="radm-gallery-loading" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--radm-text-muted);">
            <div class="radm-spinner" style="margin: 0 auto 12px;"></div>
            Loading media...
        </div>
    </div>
</div>

<!-- ── Pagination & Results Footer ───────────────────────────────── -->
<div class="radm-gallery-footer" id="radm-gallery-footer" style="display: none;">
    <div class="radm-gallery-counter">
        Showing <span id="radm-pg-start">1</span> to <span id="radm-pg-end">8</span> of <span id="radm-pg-total">0</span> media files
    </div>
    <div class="radm-gallery-pagination" id="radm-gallery-pagination">
        <!-- Pagination buttons injected via JS -->
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════
     UPLOAD / EDIT MEDIA MODAL (IMAGE + VIDEO SUPPORT)
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-gallery-modal-overlay" aria-hidden="true">
    <div class="radm-modal radm-modal--gallery" style="max-width: 540px; width: 92%;">
        
        <div class="radm-modal-header">
            <h3 id="radm-gallery-modal-title">Upload Media</h3>
            <button type="button" class="radm-modal-close" id="radm-gallery-modal-close" aria-label="Close modal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="radm-gallery-form" method="post" enctype="multipart/form-data">
            <input type="hidden" id="radm-gmedia-id" name="media_id" value="" />

            <div class="radm-modal-body">
                
                <!-- Media Type Switcher (Image / Video) -->
                <div class="radm-form-group" style="margin-bottom: 18px;">
                    <label class="radm-label">Media Type</label>
                    <div class="radm-type-switch">
                        <label class="radm-type-radio-label">
                            <input type="radio" name="media_type" value="image" id="radm-type-img" checked />
                            <div class="radm-type-pill">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                                Image / Photo
                            </div>
                        </label>
                        <label class="radm-type-radio-label">
                            <input type="radio" name="media_type" value="video" id="radm-type-vid" />
                            <div class="radm-type-pill">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                    <polygon points="23 7 16 12 23 17 23 7"/>
                                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
                                </svg>
                                Video
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Media Title -->
                <div class="radm-form-group" style="margin-bottom: 16px;">
                    <label class="radm-label" for="radm-gtitle">Media Title / Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="radm-gtitle" name="title" class="radm-input"
                           placeholder="e.g. International Yoga Day 2025" required />
                </div>

                <!-- Category & Event (2-column row) -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                    <div class="radm-form-group">
                        <label class="radm-label" for="radm-gcategory">Category</label>
                        <input type="text" id="radm-gcategory" name="category" list="radm-gcategory-list" class="radm-input"
                               placeholder="Choose or type category..." value="General" autocomplete="off" />
                        <datalist id="radm-gcategory-list">
                            <?php
                            foreach ( $dynamic_cats as $cat_name ) {
                                echo '<option value="' . esc_attr( $cat_name ) . '">';
                            }
                            ?>
                        </datalist>
                    </div>

                    <div class="radm-form-group">
                        <label class="radm-label" for="radm-gevent-id">Linked Event</label>
                        <select id="radm-gevent-id" name="event_id" class="radm-input">
                            <option value="0">None / General</option>
                            <?php
                            if ( ! empty( $events ) ) {
                                foreach ( $events as $ev ) {
                                    echo '<option value="' . esc_attr( $ev->ID ) . '">' . esc_html( $ev->post_title ) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- ── IMAGE SPECIFIC SECTION ── -->
                <div id="radm-section-image" class="radm-media-type-section">
                    <div class="radm-form-group" style="margin-bottom: 16px;">
                        <label class="radm-label">Choose Photo <span style="color:#ef4444;">*</span></label>
                        
                        <div class="radm-media-uploader-box" id="radm-guploader-box">
                            <div id="radm-gpreview-wrap" class="radm-gpreview-wrap" style="display: none;">
                                <img id="radm-gpreview-img" src="" alt="Photo Preview" />
                                <button type="button" class="radm-btn-remove-preview" id="radm-gremove-preview" title="Remove photo">×</button>
                            </div>

                            <div id="radm-gupload-prompt" class="radm-gupload-prompt">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="40" height="40" style="color: #2E7D32; margin-bottom: 8px;">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                                <p style="font-size: 14px; font-weight: 600; margin: 0 0 4px; color: var(--radm-text);">Choose a photo to upload</p>
                                <p style="font-size: 12px; color: var(--radm-text-muted); margin: 0 0 12px;">Drag &amp; drop an image here or choose below</p>
                                
                                <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                                    <button type="button" class="radm-btn radm-btn-primary" id="radm-gbrowse-btn" style="padding: 7px 16px; font-size: 13px; margin: 0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14" style="margin-right: 4px;">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="17 8 12 3 7 8"/>
                                            <line x1="12" y1="3" x2="12" y2="15"/>
                                        </svg>
                                        Browse Device
                                    </button>
                                    <input type="file" id="radm-gfile-input" name="image_file" accept="image/*" style="display: none;" />
                                    <button type="button" class="radm-btn radm-btn-secondary" id="radm-gpick-media-btn" style="padding: 7px 14px; font-size: 13px;">
                                        Media Library
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Direct Image URL Option -->
                        <div style="margin-top: 8px;">
                            <input type="text" id="radm-gimage-url" name="image_url" class="radm-input"
                                   placeholder="Or paste Direct Image URL (https://...)" style="font-size: 12.5px; padding: 7px 12px;" />
                        </div>
                    </div>
                </div>

                <!-- ── VIDEO SPECIFIC SECTION ── -->
                <div id="radm-section-video" class="radm-media-type-section" style="display: none;">
                    <div class="radm-form-group" style="margin-bottom: 14px;">
                        <label class="radm-label" for="radm-gvideo-url">Video URL (YouTube / Vimeo / MP4) <span style="color:#ef4444;">*</span></label>
                        <input type="url" id="radm-gvideo-url" name="video_url" class="radm-input"
                               placeholder="https://www.youtube.com/watch?v=..." />
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                        <div class="radm-form-group">
                            <label class="radm-label" for="radm-gvideo-dur">Duration</label>
                            <input type="text" id="radm-gvideo-dur" name="video_duration" class="radm-input"
                                   placeholder="e.g. 02:15" />
                        </div>
                        <div class="radm-form-group">
                            <label class="radm-label" for="radm-gvideo-poster">Custom Poster / Thumbnail URL</label>
                            <input type="url" id="radm-gvideo-poster" name="video_poster" class="radm-input"
                                   placeholder="Auto-detected from YouTube or URL" />
                        </div>
                    </div>
                </div>

                <!-- Status Selection -->
                <div class="radm-form-group">
                    <label class="radm-label" for="radm-gstatus">Status</label>
                    <select id="radm-gstatus" name="status" class="radm-input">
                        <option value="publish">Published (Visible on website)</option>
                        <option value="draft">Draft (Hidden)</option>
                    </select>
                </div>

            </div><!-- /.radm-modal-body -->

            <div class="radm-modal-footer">
                <button type="button" class="radm-btn radm-btn-outline" id="radm-gallery-modal-cancel">Cancel</button>
                <button type="submit" class="radm-btn radm-btn-primary" id="radm-gallery-modal-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span id="radm-gsubmit-text">Upload Media</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════════
     DELETE CONFIRMATION MODAL
     ══════════════════════════════════════════════════════════════════ -->
<div class="radm-modal-overlay" id="radm-gdelete-modal-overlay" aria-hidden="true">
    <div class="radm-modal radm-modal--sm">
        <div class="radm-modal-header">
            <h3>Delete Media</h3>
            <button type="button" class="radm-modal-close" id="radm-gdelete-modal-close" aria-label="Close modal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="radm-modal-body">
            <p>Are you sure you want to delete <strong id="radm-gdelete-title">this media</strong>?</p>
            <p style="color:var(--radm-text-muted); font-size:13px; margin-top:6px;">This action will remove it from your website gallery.</p>
        </div>
        <div class="radm-modal-footer">
            <button type="button" class="radm-btn radm-btn-outline" id="radm-gdelete-cancel-btn">Cancel</button>
            <button type="button" class="radm-btn radm-btn-danger" id="radm-gdelete-confirm-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                </svg>
                Yes, Delete
            </button>
        </div>
    </div>
</div>

<?php radm_portal_footer(); ?>
