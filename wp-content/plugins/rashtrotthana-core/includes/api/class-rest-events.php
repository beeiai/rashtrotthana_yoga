<?php
namespace Rashtrotthana\Core\Api;

class Rest_Events {
    public function init() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public function register_routes() {
        register_rest_route( 'ry/v1', '/events', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [ $this, 'get_events' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'per_page' => [
                    'sanitize_callback' => 'absint',
                    'default'           => 10,
                ],
                'page'     => [
                    'sanitize_callback' => 'absint',
                    'default'           => 1,
                ],
                'status'   => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default'           => 'upcoming',
                ],
                'center'   => [
                    'sanitize_callback' => 'absint',
                ],
                'featured' => [
                    'sanitize_callback' => 'sanitize_text_field',
                ]
            ]
        ] );

        register_rest_route( 'ry/v1', '/events/(?P<id>\d+)', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [ $this, 'get_event' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'id' => [
                    'validate_callback' => function($param, $request, $key) {
                        return is_numeric( $param );
                    }
                ]
            ]
        ] );
    }

    public function get_events( \WP_REST_Request $request ) {
        $args = [
            'post_type'      => 'event',
            'post_status'    => 'publish', // SECURITY FIX
            'posts_per_page' => $request->get_param( 'per_page' ),
            'paged'          => $request->get_param( 'page' ),
            'meta_key'       => '_ry_start_date',
            'orderby'        => 'meta_value',
            'order'          => 'ASC'
        ];

        $today = date('Y-m-d');
        $status = $request->get_param( 'status' );

        if ( $status === 'upcoming' ) {
            $args['meta_query'][] = [
                'key'     => '_ry_start_date',
                'value'   => $today,
                'compare' => '>=',
                'type'    => 'DATE'
            ];
        } elseif ( $status === 'past' ) {
            $args['meta_query'][] = [
                'key'     => '_ry_start_date',
                'value'   => $today,
                'compare' => '<',
                'type'    => 'DATE'
            ];
            $args['order'] = 'DESC'; // Past events usually show newest first
        }

        if ( $request->get_param( 'center' ) ) {
            $args['meta_query'][] = [
                'key'   => '_ry_center',
                'value' => $request->get_param( 'center' ),
            ];
        }

        if ( $request->get_param( 'featured' ) === 'true' ) {
            $args['meta_query'][] = [
                'key'   => '_ry_featured',
                'value' => '1',
            ];
        }

        $query = new \WP_Query( $args );
        $data = [];

        foreach ( $query->posts as $post ) {
            $data[] = $this->prepare_event_for_response( $post );
        }

        return rest_ensure_response( [
            'items'      => $data,
            'pagination' => [
                'page'     => (int) $args['paged'],
                'per_page' => (int) $args['posts_per_page'],
                'total'    => (int) $query->found_posts,
                'pages'    => (int) $query->max_num_pages,
            ]
        ] );
    }

    public function get_event( \WP_REST_Request $request ) {
        $post = get_post( (int) $request->get_param( 'id' ) );
        
        if ( ! $post || $post->post_type !== 'event' || $post->post_status !== 'publish' ) {
            return new \WP_Error( 'not_found', 'Event not found', [ 'status' => 404 ] );
        }

        return rest_ensure_response( $this->prepare_event_for_response( $post, true ) );
    }

    private function prepare_event_for_response( $post, $is_single = false ) {
        $center_id = get_post_meta( $post->ID, '_ry_center', true );
        $center = null;
        if ( $center_id ) {
            $center_post = get_post( $center_id );
            if ( $center_post && $center_post->post_status === 'publish' ) {
                $center = [
                    'id'   => $center_post->ID,
                    'name' => get_the_title( $center_post )
                ];
            }
        }

        $image_id = get_post_thumbnail_id( $post->ID );
        $image = null;
        if ( $image_id ) {
            $image = [
                'url' => wp_get_attachment_image_url( $image_id, 'large' ),
                'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true )
            ];
        }

        $data = [
            'id'                    => $post->ID,
            'title'                 => get_the_title( $post ),
            'slug'                  => $post->post_name,
            'short_description'     => get_the_excerpt( $post ),
            'featured_image'        => $image,
            'start_date'            => get_post_meta( $post->ID, '_ry_start_date', true ),
            'end_date'              => get_post_meta( $post->ID, '_ry_end_date', true ),
            'start_time'            => get_post_meta( $post->ID, '_ry_start_time', true ),
            'end_time'              => get_post_meta( $post->ID, '_ry_end_time', true ),
            'venue'                 => get_post_meta( $post->ID, '_ry_venue', true ),
            'center'                => $center,
            'registration_enabled'  => (bool) get_post_meta( $post->ID, '_ry_requires_registration', true ),
            'featured'              => (bool) get_post_meta( $post->ID, '_ry_featured', true ),
        ];

        if ( $is_single ) {
            $data['description'] = apply_filters( 'the_content', $post->post_content );
            
            $reg_form = get_post_meta( $post->ID, '_ry_registration_form', true );
            if ( $reg_form ) {
                $data['registration_form_id'] = (int) $reg_form;
            }
            $data['capacity'] = get_post_meta( $post->ID, '_ry_maximum_participants', true );
            $data['registration_start'] = get_post_meta( $post->ID, '_ry_registration_start', true );
            $data['registration_end'] = get_post_meta( $post->ID, '_ry_registration_end', true );
        }

        return $data;
    }
}
