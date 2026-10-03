<?php
namespace Rashtrotthana\Core\Api;

class Rest_Gallery {

    public function init() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public function register_routes() {
        // List Gallery Items (GET) & Create Gallery Item (POST)
        register_rest_route( 'ry/v1', '/gallery', [
            [
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_items' ],
                'permission_callback' => '__return_true',
                'args'                => [
                    'type'     => [ 'sanitize_callback' => 'sanitize_key', 'default' => 'all' ],
                    'category' => [ 'sanitize_callback' => 'sanitize_text_field' ],
                    'event_id' => [ 'sanitize_callback' => 'absint' ],
                    'status'   => [ 'sanitize_callback' => 'sanitize_key' ],
                    'search'   => [ 'sanitize_callback' => 'sanitize_text_field' ],
                    'sort'     => [ 'sanitize_callback' => 'sanitize_key', 'default' => 'latest' ],
                    'per_page' => [ 'sanitize_callback' => 'absint', 'default' => 8 ],
                    'page'     => [ 'sanitize_callback' => 'absint', 'default' => 1 ],
                ],
            ],
            [
                'methods'             => \WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'create_item' ],
                'permission_callback' => [ $this, 'check_write_permission' ],
            ],
        ] );

        // Single Item: Get (GET), Update (POST/PUT/PATCH), Delete (DELETE)
        register_rest_route( 'ry/v1', '/gallery/(?P<id>\d+)', [
            [
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_item' ],
                'permission_callback' => '__return_true',
            ],
            [
                'methods'             => \WP_REST_Server::EDITABLE,
                'callback'            => [ $this, 'update_item' ],
                'permission_callback' => [ $this, 'check_write_permission' ],
            ],
            [
                'methods'             => \WP_REST_Server::DELETABLE,
                'callback'            => [ $this, 'delete_item' ],
                'permission_callback' => [ $this, 'check_write_permission' ],
            ],
        ] );

        // Toggle Status endpoint
        register_rest_route( 'ry/v1', '/gallery/(?P<id>\d+)/toggle-status', [
            'methods'             => \WP_REST_Server::CREATABLE,
            'callback'            => [ $this, 'toggle_status' ],
            'permission_callback' => [ $this, 'check_write_permission' ],
        ] );
    }

    public function check_write_permission( \WP_REST_Request $request ): bool {
        return current_user_can( 'upload_files' ) || current_user_can( 'edit_posts' ) || current_user_can( 'manage_options' );
    }

    public function get_items( \WP_REST_Request $request ) {
        $type      = sanitize_key( $request->get_param( 'type' ) ?: 'all' );
        $category  = sanitize_text_field( $request->get_param( 'category' ) ?: '' );
        $event_id  = absint( $request->get_param( 'event_id' ) ?: 0 );
        $status    = sanitize_key( $request->get_param( 'status' ) ?: '' );
        $search    = sanitize_text_field( $request->get_param( 'search' ) ?: '' );
        $sort      = sanitize_key( $request->get_param( 'sort' ) ?: 'latest' );
        $page      = max( 1, absint( $request->get_param( 'page' ) ?: 1 ) );
        $per_page  = max( 1, absint( $request->get_param( 'per_page' ) ?: 8 ) );

        $meta_query = [];
        if ( in_array( $type, [ 'image', 'video' ], true ) ) {
            $meta_query[] = [
                'key'     => '_ry_gallery_type',
                'value'   => $type,
                'compare' => '=',
            ];
        }
        if ( ! empty( $category ) ) {
            $meta_query[] = [
                'key'     => '_ry_gallery_category',
                'value'   => $category,
                'compare' => '=',
            ];
        }
        if ( $event_id > 0 ) {
            $meta_query[] = [
                'key'     => '_ry_gallery_event_id',
                'value'   => $event_id,
                'compare' => '=',
            ];
        }

        $post_status = [ 'publish', 'draft' ];
        if ( $status === 'publish' ) {
            $post_status = [ 'publish' ];
        } elseif ( $status === 'draft' ) {
            $post_status = [ 'draft' ];
        }

        $query_args = [
            'post_type'      => 'ry_gallery',
            'post_status'    => $post_status,
            'posts_per_page' => -1,
            's'              => $search,
        ];

        if ( ! empty( $meta_query ) ) {
            $query_args['meta_query'] = $meta_query;
        }

        if ( $sort === 'oldest' ) {
            $query_args['orderby'] = 'date';
            $query_args['order']   = 'ASC';
        } elseif ( $sort === 'title_asc' ) {
            $query_args['orderby'] = 'title';
            $query_args['order']   = 'ASC';
        } elseif ( $sort === 'title_desc' ) {
            $query_args['orderby'] = 'title';
            $query_args['order']   = 'DESC';
        } else {
            $query_args['orderby'] = 'date';
            $query_args['order']   = 'DESC';
        }

        $all_posts = get_posts( $query_args );

        // Count totals
        $total_all   = 0;
        $total_image = 0;
        $total_video = 0;

        $base_posts = get_posts( [
            'post_type'      => 'ry_gallery',
            'post_status'    => [ 'publish', 'draft' ],
            'posts_per_page' => -1,
        ] );

        foreach ( $base_posts as $bp ) {
            $t = get_post_meta( $bp->ID, '_ry_gallery_type', true ) ?: 'image';
            $total_all++;
            if ( $t === 'video' ) {
                $total_video++;
            } else {
                $total_image++;
            }
        }

        $total_filtered = count( $all_posts );
        $offset         = ( $page - 1 ) * $per_page;
        $paged_posts    = array_slice( $all_posts, $offset, $per_page );

        $items = [];
        foreach ( $paged_posts as $post ) {
            $items[] = $this->prepare_item_for_response( $post );
        }

        return rest_ensure_response( [
            'items'          => $items,
            'total'          => $total_filtered,
            'page'           => $page,
            'per_page'       => $per_page,
            'total_pages'    => ceil( $total_filtered / $per_page ),
            'counts'         => [
                'all'   => $total_all,
                'image' => $total_image,
                'video' => $total_video,
            ],
        ] );
    }

    public function get_item( \WP_REST_Request $request ) {
        $id   = absint( $request->get_param( 'id' ) );
        $post = get_post( $id );
        if ( ! $post || $post->post_type !== 'ry_gallery' ) {
            return new \WP_Error( 'not_found', 'Gallery item not found', [ 'status' => 404 ] );
        }
        return rest_ensure_response( $this->prepare_item_for_response( $post ) );
    }

    public function create_item( \WP_REST_Request $request ) {
        $title      = sanitize_text_field( $request->get_param( 'title' ) ?: '' );
        $media_type = sanitize_key( $request->get_param( 'media_type' ) ?: 'image' );
        $image_url  = esc_url_raw( $request->get_param( 'image_url' ) ?: '' );
        $video_url  = esc_url_raw( $request->get_param( 'video_url' ) ?: '' );
        $video_dur  = sanitize_text_field( $request->get_param( 'video_duration' ) ?: '' );
        $video_post = esc_url_raw( $request->get_param( 'video_poster' ) ?: '' );
        $category   = sanitize_text_field( $request->get_param( 'category' ) ?: 'General' );
        $event_id   = absint( $request->get_param( 'event_id' ) ?: 0 );
        $media_date = sanitize_text_field( $request->get_param( 'media_date' ) ?: current_time( 'Y-m-d' ) );
        $status     = sanitize_key( $request->get_param( 'status' ) ?: 'publish' );
        $desc       = sanitize_textarea_field( $request->get_param( 'description' ) ?: '' );

        if ( empty( $title ) ) {
            $title = 'Gallery Item ' . current_time( 'd M Y' );
        }

        // Auto detect youtube thumbnail
        if ( $media_type === 'video' ) {
            if ( ! empty( $video_post ) ) {
                $image_url = $video_post;
            } elseif ( empty( $image_url ) && ! empty( $video_url ) ) {
                if ( preg_match( '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video_url, $m ) ) {
                    $image_url = 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
                }
            }
        }

        if ( empty( $image_url ) && $media_type !== 'video' ) {
            $image_url = '';
        }

        $post_id = wp_insert_post( [
            'post_title'   => $title,
            'post_content' => $desc,
            'post_type'    => 'ry_gallery',
            'post_status'  => $status,
            'post_author'  => get_current_user_id() ?: 1,
        ], true );

        if ( is_wp_error( $post_id ) ) {
            return $post_id;
        }

        update_post_meta( $post_id, '_ry_gallery_type', $media_type );
        update_post_meta( $post_id, '_ry_gallery_image_url', $image_url );
        update_post_meta( $post_id, '_ry_gallery_video_url', $video_url );
        update_post_meta( $post_id, '_ry_gallery_video_duration', $video_dur );
        update_post_meta( $post_id, '_ry_gallery_category', $category );
        update_post_meta( $post_id, '_ry_gallery_event_id', $event_id );
        update_post_meta( $post_id, '_ry_gallery_date', $media_date );

        if ( ! empty( $category ) ) {
            wp_set_object_terms( $post_id, $category, 'gallery_category', false );
        }

        $post = get_post( $post_id );
        return rest_ensure_response( [
            'success' => true,
            'item'    => $this->prepare_item_for_response( $post ),
            'message' => 'Media added successfully.',
        ] );
    }

    public function update_item( \WP_REST_Request $request ) {
        $id   = absint( $request->get_param( 'id' ) );
        $post = get_post( $id );
        if ( ! $post || $post->post_type !== 'ry_gallery' ) {
            return new \WP_Error( 'not_found', 'Gallery item not found', [ 'status' => 404 ] );
        }

        $title      = sanitize_text_field( $request->get_param( 'title' ) ?: $post->post_title );
        $media_type = sanitize_key( $request->get_param( 'media_type' ) ?: get_post_meta( $id, '_ry_gallery_type', true ) );
        $image_url  = esc_url_raw( $request->get_param( 'image_url' ) ?: get_post_meta( $id, '_ry_gallery_image_url', true ) );
        $video_url  = esc_url_raw( $request->get_param( 'video_url' ) ?: get_post_meta( $id, '_ry_gallery_video_url', true ) );
        $video_dur  = sanitize_text_field( $request->get_param( 'video_duration' ) ?: get_post_meta( $id, '_ry_gallery_video_duration', true ) );
        $category   = sanitize_text_field( $request->get_param( 'category' ) ?: get_post_meta( $id, '_ry_gallery_category', true ) );
        $event_id   = absint( $request->get_param( 'event_id' ) ?? get_post_meta( $id, '_ry_gallery_event_id', true ) );
        $status     = sanitize_key( $request->get_param( 'status' ) ?: $post->post_status );
        $desc       = sanitize_textarea_field( $request->get_param( 'description' ) ?? $post->post_content );

        wp_update_post( [
            'ID'           => $id,
            'post_title'   => $title,
            'post_content' => $desc,
            'post_status'  => $status,
        ] );

        update_post_meta( $id, '_ry_gallery_type', $media_type );
        update_post_meta( $id, '_ry_gallery_image_url', $image_url );
        update_post_meta( $id, '_ry_gallery_video_url', $video_url );
        update_post_meta( $id, '_ry_gallery_video_duration', $video_dur );
        update_post_meta( $id, '_ry_gallery_category', $category );
        update_post_meta( $id, '_ry_gallery_event_id', $event_id );

        if ( ! empty( $category ) ) {
            wp_set_object_terms( $id, $category, 'gallery_category', false );
        }

        $updated_post = get_post( $id );
        return rest_ensure_response( [
            'success' => true,
            'item'    => $this->prepare_item_for_response( $updated_post ),
            'message' => 'Media updated successfully.',
        ] );
    }

    public function delete_item( \WP_REST_Request $request ) {
        $id   = absint( $request->get_param( 'id' ) );
        $post = get_post( $id );
        if ( ! $post || $post->post_type !== 'ry_gallery' ) {
            return new \WP_Error( 'not_found', 'Gallery item not found', [ 'status' => 404 ] );
        }

        $deleted = wp_delete_post( $id, true );
        if ( ! $deleted ) {
            return new \WP_Error( 'delete_failed', 'Failed to delete media', [ 'status' => 500 ] );
        }

        return rest_ensure_response( [
            'success' => true,
            'id'      => $id,
            'message' => 'Media deleted successfully.',
        ] );
    }

    public function toggle_status( \WP_REST_Request $request ) {
        $id   = absint( $request->get_param( 'id' ) );
        $post = get_post( $id );
        if ( ! $post || $post->post_type !== 'ry_gallery' ) {
            return new \WP_Error( 'not_found', 'Gallery item not found', [ 'status' => 404 ] );
        }

        $new_status = ( $post->post_status === 'publish' ) ? 'draft' : 'publish';
        wp_update_post( [
            'ID'          => $id,
            'post_status' => $new_status,
        ] );

        return rest_ensure_response( [
            'success'    => true,
            'id'         => $id,
            'new_status' => $new_status,
            'message'    => 'Status changed to ' . ( $new_status === 'publish' ? 'Published' : 'Draft' ) . '.',
        ] );
    }

    private function prepare_item_for_response( \WP_Post $post ): array {
        $g_type     = get_post_meta( $post->ID, '_ry_gallery_type', true ) ?: 'image';
        $image_url  = get_post_meta( $post->ID, '_ry_gallery_image_url', true ) ?: '';
        $video_url  = get_post_meta( $post->ID, '_ry_gallery_video_url', true ) ?: '';
        $duration   = get_post_meta( $post->ID, '_ry_gallery_video_duration', true ) ?: '';
        $g_cat      = get_post_meta( $post->ID, '_ry_gallery_category', true ) ?: 'General';
        $g_event_id = (int) get_post_meta( $post->ID, '_ry_gallery_event_id', true );
        $g_date_raw = get_post_meta( $post->ID, '_ry_gallery_date', true ) ?: get_the_date( 'Y-m-d', $post->ID );
        $g_date_fmt = $g_date_raw ? date( 'd M Y', strtotime( $g_date_raw ) ) : date( 'd M Y', strtotime( $post->post_date ) );

        $event_name = '';
        if ( $g_event_id > 0 ) {
            $ev_post = get_post( $g_event_id );
            if ( $ev_post ) {
                $event_name = $ev_post->post_title;
            }
        }

        $sub_tag = '';
        if ( ! empty( $event_name ) ) {
            $sub_tag = 'Event: ' . $event_name;
        } elseif ( ! empty( $g_cat ) ) {
            $sub_tag = ( in_array( $g_cat, [ 'Yoga Day Celebration', 'Weekend Yoga Camp', 'Spiritual Talk', 'Regular Class', 'Annual Day' ], true ) ? 'Event: ' : 'Category: ' ) . $g_cat;
        }

        if ( empty( $image_url ) ) {
            if ( has_post_thumbnail( $post->ID ) ) {
                $image_url = get_the_post_thumbnail_url( $post->ID, 'large' );
            } else {
                $image_url = 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=900&q=80';
            }
        }

        return [
            'id'             => $post->ID,
            'title'          => $post->post_title,
            'description'    => $post->post_content,
            'type'           => $g_type,
            'image_url'      => $image_url,
            'video_url'      => $video_url,
            'video_duration' => $duration,
            'category'       => $g_cat,
            'event_id'       => $g_event_id,
            'event_name'     => $event_name,
            'sub_tag'        => $sub_tag,
            'date_raw'       => $g_date_raw,
            'date_fmt'       => $g_date_fmt,
            'status'         => $post->post_status,
            'is_published'   => $post->post_status === 'publish',
        ];
    }
}
