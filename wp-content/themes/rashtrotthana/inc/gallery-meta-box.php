<?php
/**
 * Gallery Album Meta Boxes & Upload Folder Management — Rashtrotthana Yoga
 *
 * Provides:
 *  1. Physical folder preservation for album uploads (wp-content/uploads/gallery/{album-slug}/)
 *  2. Admin Meta Box for Event Date, Venue, Category Badge, Photo Gallery (wp.media), and Video Highlights
 *  3. Save sanitization & database persistence
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── 1. Enforce Physical Folder Structure on Disk ─────────────────────────────
/**
 * Route media uploads attached to an rs_gallery_album into dedicated subfolders on disk:
 * wp-content/uploads/gallery/{album-slug}/
 */
add_filter( 'upload_dir', 'rs_gallery_album_upload_dir' );
function rs_gallery_album_upload_dir( $dirs ) {
    $post_id = 0;
    if ( isset( $_REQUEST['post_id'] ) ) {
        $post_id = intval( $_REQUEST['post_id'] );
    } elseif ( isset( $_POST['post_id'] ) ) {
        $post_id = intval( $_POST['post_id'] );
    }

    if ( ! $post_id ) {
        return $dirs;
    }

    $post = get_post( $post_id );
    if ( ! $post || $post->post_type !== 'rs_gallery_album' ) {
        return $dirs;
    }

    // Determine album folder name
    $album_slug = $post->post_name ? sanitize_title( $post->post_name ) : sanitize_title( $post->post_title );
    if ( ! $album_slug ) {
        $album_slug = 'album-' . $post_id;
    }

    $custom_subdir = '/gallery/' . $album_slug;

    $dirs['subdir'] = $custom_subdir;
    $dirs['path']   = $dirs['basedir'] . $custom_subdir;
    $dirs['url']    = $dirs['baseurl'] . $custom_subdir;

    return $dirs;
}

// ── 2. Register Meta Box ─────────────────────────────────────────────────────
add_action( 'add_meta_boxes', 'rs_register_gallery_album_meta_boxes' );
function rs_register_gallery_album_meta_boxes() {
    add_meta_box(
        'rs_gallery_album_details',
        __( 'Album Details & Photo Management', 'rashtrotthana' ),
        'rs_render_gallery_album_meta_box',
        'rs_gallery_album',
        'normal',
        'high'
    );
}

// ── 3. Render Meta Box HTML ──────────────────────────────────────────────────
function rs_render_gallery_album_meta_box( $post ) {
    wp_nonce_field( 'rs_save_gallery_album_meta', 'rs_gallery_album_nonce' );

    $date     = get_post_meta( $post->ID, '_rs_album_date', true );
    $venue    = get_post_meta( $post->ID, '_rs_album_venue', true );
    $category = get_post_meta( $post->ID, '_rs_album_category', true );
    $photos_raw = get_post_meta( $post->ID, '_rs_album_photos', true );
    $videos_raw = get_post_meta( $post->ID, '_rs_album_videos', true );

    // Parse photo IDs
    $photo_ids = array();
    if ( is_string( $photos_raw ) && ! empty( $photos_raw ) ) {
        if ( $photos_raw[0] === '[' ) {
            $photo_ids = json_decode( $photos_raw, true ) ?: array();
        } else {
            $photo_ids = array_filter( array_map( 'intval', explode( ',', $photos_raw ) ) );
        }
    } elseif ( is_array( $photos_raw ) ) {
        $photo_ids = $photos_raw;
    }

    // Parse videos
    $videos = array();
    if ( is_string( $videos_raw ) && ! empty( $videos_raw ) ) {
        $videos = json_decode( $videos_raw, true ) ?: array();
    } elseif ( is_array( $videos_raw ) ) {
        $videos = $videos_raw;
    }

    $album_slug = $post->post_name ?: sanitize_title( $post->post_title ?: 'album-' . $post->ID );
    ?>
    <style>
        .rs-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        .rs-meta-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #1e1e1e;
        }
        .rs-meta-field input, .rs-meta-field select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
        }
        .rs-folder-badge {
            background: #f0f6fc;
            border: 1px solid #c8d8ec;
            color: #0c4a6e;
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 22px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .rs-photos-container {
            border: 2px dashed #c3c4c7;
            background: #fafafa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .rs-photos-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .rs-photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 12px;
            min-height: 80px;
        }
        .rs-photo-card {
            position: relative;
            aspect-ratio: 4/3;
            background: #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #cbd5e1;
        }
        .rs-photo-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .rs-photo-remove {
            position: absolute;
            top: 4px;
            right: 4px;
            background: rgba(143, 23, 29, 0.9);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            line-height: 1;
            transition: background 0.15s ease;
        }
        .rs-photo-remove:hover {
            background: #b91c1c;
        }
        .rs-videos-container {
            border-top: 1px solid #dcdcde;
            padding-top: 20px;
            margin-top: 20px;
        }
        .rs-video-row {
            display: grid;
            grid-template-columns: 2fr 1fr 2fr 40px;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
            background: #f8fafc;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        .rs-video-remove {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #f87171;
            border-radius: 4px;
            height: 36px;
            cursor: pointer;
            font-weight: bold;
        }
        .rs-video-remove:hover {
            background: #ef4444;
            color: #fff;
        }
    </style>

    <div class="rs-folder-badge">
        <span class="dashicons dashicons-category"></span>
        <span><strong>Folder Structure Maintained:</strong> Media uploaded for this album is physically stored inside: <code>/wp-content/uploads/gallery/<?php echo esc_html( $album_slug ); ?>/</code></span>
    </div>

    <div class="rs-meta-grid">
        <div class="rs-meta-field">
            <label for="rs_album_date"><?php _e( 'Event Date / Range', 'rashtrotthana' ); ?></label>
            <input type="text" id="rs_album_date" name="rs_album_date" value="<?php echo esc_attr( $date ); ?>" placeholder="e.g. June 21, 2025 or May 10 – May 18, 2025" />
        </div>
        <div class="rs-meta-field">
            <label for="rs_album_venue"><?php _e( 'Venue / Location', 'rashtrotthana' ); ?></label>
            <input type="text" id="rs_album_venue" name="rs_album_venue" value="<?php echo esc_attr( $venue ); ?>" placeholder="e.g. Jayanagar Central Yogashala" />
        </div>
        <div class="rs-meta-field">
            <label for="rs_album_category"><?php _e( 'Category Badge', 'rashtrotthana' ); ?></label>
            <input type="text" id="rs_album_category" name="rs_album_category" list="rs_cat_suggestions" value="<?php echo esc_attr( $category ?: 'Special Event' ); ?>" placeholder="e.g. Special Event" />
            <datalist id="rs_cat_suggestions">
                <option value="Special Event">
                <option value="Children & Youth">
                <option value="Cultural Utsav">
                <option value="Therapy & Health">
                <option value="Heritage & Retreat">
                <option value="Celebrations">
                <option value="Workshops">
            </datalist>
        </div>
    </div>

    <!-- Album Photos Manager -->
    <div class="rs-photos-container">
        <div class="rs-photos-toolbar">
            <div>
                <strong style="font-size: 15px; color: #1e1e1e;"><?php _e( 'Album Photos', 'rashtrotthana' ); ?></strong>
                <span id="rs-photos-count" style="margin-left: 8px; color: #64748b; font-size: 13px;">(<?php echo count( $photo_ids ); ?> photos)</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="button button-primary" id="rs-add-photos-btn">
                    <span class="dashicons dashicons-format-gallery" style="vertical-align: middle; margin-right: 4px;"></span>
                    <?php _e( 'Add / Upload Photos', 'rashtrotthana' ); ?>
                </button>
                <button type="button" class="button" id="rs-clear-photos-btn" style="color: #b91c1c;">
                    <?php _e( 'Clear All', 'rashtrotthana' ); ?>
                </button>
            </div>
        </div>

        <p class="description" style="margin-bottom: 15px;">
            <?php _e( 'Click "Add / Upload Photos" to select or bulk upload images. You can select multiple images at once from the Media Library or drop files directly from your computer.', 'rashtrotthana' ); ?>
        </p>

        <div class="rs-photos-grid" id="rs-photos-grid">
            <?php foreach ( $photo_ids as $pid ) : ?>
                <?php
                $img_src = wp_get_attachment_image_url( $pid, 'thumbnail' );
                if ( ! $img_src ) continue;
                ?>
                <div class="rs-photo-card" data-id="<?php echo esc_attr( $pid ); ?>">
                    <img src="<?php echo esc_url( $img_src ); ?>" alt="" />
                    <button type="button" class="rs-photo-remove" title="Remove photo" aria-label="Remove photo">&times;</button>
                </div>
            <?php endforeach; ?>
        </div>

        <input type="hidden" name="rs_album_photos" id="rs_album_photos" value="<?php echo esc_attr( wp_json_encode( $photo_ids ) ); ?>" />
    </div>

    <!-- YouTube Video Highlights -->
    <div class="rs-videos-container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <div>
                <strong style="font-size: 15px; color: #1e1e1e;"><?php _e( 'Video Highlights (Optional)', 'rashtrotthana' ); ?></strong>
                <p class="description" style="margin: 3px 0 0;"><?php _e( 'Add YouTube links or event recap videos associated with this album.', 'rashtrotthana' ); ?></p>
            </div>
            <button type="button" class="button" id="rs-add-video-btn">
                <span class="dashicons dashicons-video-alt3" style="vertical-align: middle; margin-right: 4px;"></span>
                <?php _e( '+ Add Video', 'rashtrotthana' ); ?>
            </button>
        </div>

        <div id="rs-videos-list">
            <?php if ( ! empty( $videos ) ) : ?>
                <?php foreach ( $videos as $index => $v ) : ?>
                    <div class="rs-video-row">
                        <input type="text" name="rs_video_title[]" value="<?php echo esc_attr( isset( $v['title'] ) ? $v['title'] : '' ); ?>" placeholder="Video Title" />
                        <input type="text" name="rs_video_duration[]" value="<?php echo esc_attr( isset( $v['duration'] ) ? $v['duration'] : ( isset( $v['subtitle'] ) ? $v['subtitle'] : '02:30' ) ); ?>" placeholder="Duration (e.g. 03:15)" />
                        <input type="text" name="rs_video_url[]" value="<?php echo esc_attr( isset( $v['embed_url'] ) ? $v['embed_url'] : ( isset( $v['url'] ) ? $v['url'] : '' ) ); ?>" placeholder="YouTube URL (https://www.youtube.com/watch?v=...)" />
                        <button type="button" class="rs-video-remove" title="Remove Video">&times;</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var photoIds = <?php echo wp_json_encode( array_values( $photo_ids ) ); ?>;
        var mediaFrame;

        function updatePhotosInput() {
            $('#rs_album_photos').val(JSON.stringify(photoIds));
            $('#rs-photos-count').text('(' + photoIds.length + ' photos)');
        }

        // Open Media Library Modal
        $('#rs-add-photos-btn').on('click', function(e) {
            e.preventDefault();

            if (mediaFrame) {
                mediaFrame.open();
                return;
            }

            mediaFrame = wp.media({
                title: '<?php echo esc_js( __( 'Select or Upload Photos for this Album', 'rashtrotthana' ) ); ?>',
                button: { text: '<?php echo esc_js( __( 'Add Selected Photos', 'rashtrotthana' ) ); ?>' },
                multiple: true,
                library: { type: 'image' }
            });

            mediaFrame.on('select', function() {
                var selection = mediaFrame.state().get('selection');
                selection.each(function(attachment) {
                    var att = attachment.toJSON();
                    var id = parseInt(att.id, 10);
                    if (photoIds.indexOf(id) === -1) {
                        photoIds.push(id);
                        var thumbUrl = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
                        var card = $('<div class="rs-photo-card" data-id="' + id + '">' +
                            '<img src="' + thumbUrl + '" alt="" />' +
                            '<button type="button" class="rs-photo-remove" title="Remove photo">&times;</button>' +
                        '</div>');
                        $('#rs-photos-grid').append(card);
                    }
                });
                updatePhotosInput();
            });

            mediaFrame.open();
        });

        // Remove Single Photo
        $('#rs-photos-grid').on('click', '.rs-photo-remove', function() {
            var card = $(this).closest('.rs-photo-card');
            var id = parseInt(card.data('id'), 10);
            photoIds = photoIds.filter(function(item) { return item !== id; });
            card.remove();
            updatePhotosInput();
        });

        // Clear All Photos
        $('#rs-clear-photos-btn').on('click', function() {
            if (photoIds.length === 0) return;
            if (confirm('<?php echo esc_js( __( 'Are you sure you want to remove all photos from this album?', 'rashtrotthana' ) ); ?>')) {
                photoIds = [];
                $('#rs-photos-grid').empty();
                updatePhotosInput();
            }
        });

        // Add Video Row
        $('#rs-add-video-btn').on('click', function() {
            var row = $('<div class="rs-video-row">' +
                '<input type="text" name="rs_video_title[]" value="" placeholder="Video Title" />' +
                '<input type="text" name="rs_video_duration[]" value="03:00" placeholder="Duration (e.g. 03:15)" />' +
                '<input type="text" name="rs_video_url[]" value="" placeholder="YouTube URL (https://www.youtube.com/watch?v=...)" />' +
                '<button type="button" class="rs-video-remove" title="Remove Video">&times;</button>' +
            '</div>');
            $('#rs-videos-list').append(row);
        });

        // Remove Video Row
        $('#rs-videos-list').on('click', '.rs-video-remove', function() {
            $(this).closest('.rs-video-row').remove();
        });
    });
    </script>
    <?php
}

// ── 4. Save Meta Box Data ────────────────────────────────────────────────────
add_action( 'save_post_rs_gallery_album', 'rs_save_gallery_album_meta_box_data', 10, 2 );
function rs_save_gallery_album_meta_box_data( $post_id, $post ) {
    if ( ! isset( $_POST['rs_gallery_album_nonce'] ) || ! wp_verify_nonce( $_POST['rs_gallery_album_nonce'], 'rs_save_gallery_album_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save Date
    if ( isset( $_POST['rs_album_date'] ) ) {
        update_post_meta( $post_id, '_rs_album_date', sanitize_text_field( $_POST['rs_album_date'] ) );
    }

    // Save Venue
    if ( isset( $_POST['rs_album_venue'] ) ) {
        update_post_meta( $post_id, '_rs_album_venue', sanitize_text_field( $_POST['rs_album_venue'] ) );
    }

    // Save Category
    if ( isset( $_POST['rs_album_category'] ) ) {
        update_post_meta( $post_id, '_rs_album_category', sanitize_text_field( $_POST['rs_album_category'] ) );
    }

    // Save Photos Array
    if ( isset( $_POST['rs_album_photos'] ) ) {
        $raw = stripslashes( $_POST['rs_album_photos'] );
        $decoded = json_decode( $raw, true );
        if ( is_array( $decoded ) ) {
            $sanitized_ids = array_values( array_filter( array_map( 'intval', $decoded ) ) );
            update_post_meta( $post_id, '_rs_album_photos', wp_json_encode( $sanitized_ids ) );
        }
    }

    // Save Videos Array
    if ( isset( $_POST['rs_video_title'] ) && is_array( $_POST['rs_video_title'] ) ) {
        $videos = array();
        $titles    = $_POST['rs_video_title'];
        $durations = isset( $_POST['rs_video_duration'] ) ? $_POST['rs_video_duration'] : array();
        $urls      = isset( $_POST['rs_video_url'] ) ? $_POST['rs_video_url'] : array();

        for ( $i = 0; $i < count( $titles ); $i++ ) {
            $title = sanitize_text_field( $titles[$i] );
            $url   = esc_url_raw( isset( $urls[$i] ) ? $urls[$i] : '' );
            if ( empty( $title ) && empty( $url ) ) {
                continue;
            }
            $duration = sanitize_text_field( isset( $durations[$i] ) ? $durations[$i] : '02:30' );
            
            // Format YouTube embed
            $embed_url = $url;
            if ( preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $m ) ) {
                $embed_url = 'https://www.youtube.com/embed/' . $m[1];
            }

            $videos[] = array(
                'title'     => $title,
                'subtitle'  => 'Event Highlights',
                'duration'  => $duration,
                'url'       => $url,
                'embed_url' => $embed_url,
            );
        }
        update_post_meta( $post_id, '_rs_album_videos', wp_json_encode( $videos ) );
    }
}
