<?php
namespace Rashtrotthana\Core\Api;

class Rest_Activities {
    public function init() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public function register_routes() {
        register_rest_route( 'ry/v1', '/activities', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [ $this, 'get_activities' ],
            'permission_callback' => '__return_true', // Publicly accessible, but only exposes published data
            'args'                => [
                'per_page' => [
                    'sanitize_callback' => 'absint',
                    'default'           => 10,
                ],
                'page'     => [
                    'sanitize_callback' => 'absint',
                    'default'           => 1,
                ],
                'category' => [
                    'sanitize_callback' => 'sanitize_text_field',
                ],
                'center'   => [
                    'sanitize_callback' => 'absint',
                ],
                'featured' => [
                    'sanitize_callback' => 'sanitize_text_field',
                ]
            ]
        ] );

        register_rest_route( 'ry/v1', '/activities/(?P<id>\d+)', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [ $this, 'get_activity' ],
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

    public function get_activities( \WP_REST_Request $request ) {
        $args = [
            'post_type'      => 'activity',
            'post_status'    => 'publish', // SECURITY FIX: Only expose published items
            'posts_per_page' => $request->get_param( 'per_page' ),
            'paged'          => $request->get_param( 'page' ),
        ];

        if ( $request->get_param( 'category' ) ) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'activity_category',
                    'field'    => 'slug',
                    'terms'    => $request->get_param( 'category' ),
                ],
            ];
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
            $data[] = $this->prepare_activity_for_response( $post );
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

    public function get_activity( \WP_REST_Request $request ) {
        $post = get_post( (int) $request->get_param( 'id' ) );
        
        if ( ! $post || $post->post_type !== 'activity' || $post->post_status !== 'publish' ) {
            return new \WP_Error( 'not_found', 'Activity not found', [ 'status' => 404 ] );
        }

        return rest_ensure_response( $this->prepare_activity_for_response( $post, true ) );
    }

    private function prepare_activity_for_response( $post, $is_single = false ) {
        $terms = wp_get_post_terms( $post->ID, 'activity_category' );
        $category = ! is_wp_error( $terms ) && ! empty( $terms ) ? [ 'id' => $terms[0]->term_id, 'name' => $terms[0]->name, 'slug' => $terms[0]->slug ] : null;

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
            'category'              => $category,
            'center'                => $center,
            'duration'              => get_post_meta( $post->ID, '_ry_duration', true ),
            'frequency'             => get_post_meta( $post->ID, '_ry_frequency', true ),
            'instructor'            => get_post_meta( $post->ID, '_ry_instructor', true ),
            'registration_enabled'  => (bool) get_post_meta( $post->ID, '_ry_requires_registration', true ),
            'featured'              => (bool) get_post_meta( $post->ID, '_ry_featured', true ),
        ];

        if ( $is_single ) {
            $data['description'] = apply_filters( 'the_content', $post->post_content );
            $reg_form = get_post_meta( $post->ID, '_ry_registration_form', true );
            if ( $reg_form ) {
                $data['registration_form_id'] = (int) $reg_form;
            }
        }

        return $data;
    }
}
