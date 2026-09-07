<?php
namespace Rashtrotthana\Core\Api;

class Rest_Centers {
    public function init() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public function register_routes() {
        register_rest_route( 'ry/v1', '/centers', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [ $this, 'get_centers' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'city' => [
                    'sanitize_callback' => 'sanitize_text_field',
                ],
                'search' => [
                    'sanitize_callback' => 'sanitize_text_field',
                ]
            ]
        ] );

        register_rest_route( 'ry/v1', '/centers/(?P<id>\d+)', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [ $this, 'get_center' ],
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

    public function get_centers( \WP_REST_Request $request ) {
        $args = [
            'post_type'      => 'center',
            'post_status'    => 'publish', // SECURITY FIX
            'posts_per_page' => -1,
        ];

        if ( $request->get_param( 'city' ) ) {
            $args['meta_query'][] = [
                'key'     => '_ry_city',
                'value'   => $request->get_param( 'city' ),
                'compare' => 'LIKE'
            ];
        }

        if ( $request->get_param( 'search' ) ) {
            $args['s'] = $request->get_param( 'search' );
        }

        $query = new \WP_Query( $args );
        $data = [];

        foreach ( $query->posts as $post ) {
            $data[] = $this->prepare_center_for_response( $post );
        }

        return rest_ensure_response( [
            'items' => $data,
            'total' => $query->found_posts,
        ] );
    }

    public function get_center( \WP_REST_Request $request ) {
        $post = get_post( (int) $request->get_param( 'id' ) );
        
        if ( ! $post || $post->post_type !== 'center' || $post->post_status !== 'publish' ) {
            return new \WP_Error( 'not_found', 'Center not found', [ 'status' => 404 ] );
        }

        return rest_ensure_response( $this->prepare_center_for_response( $post, true ) );
    }

    private function prepare_center_for_response( $post, $is_single = false ) {
        $image_id = get_post_thumbnail_id( $post->ID );
        $image = null;
        if ( $image_id ) {
            $image = [
                'url' => wp_get_attachment_image_url( $image_id, 'large' ),
                'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true )
            ];
        }

        $data = [
            'id'           => $post->ID,
            'name'         => get_the_title( $post ),
            'slug'         => $post->post_name,
            'featured_image' => $image,
            'address'      => get_post_meta( $post->ID, '_ry_address', true ),
            'city'         => get_post_meta( $post->ID, '_ry_city', true ),
            'state'        => get_post_meta( $post->ID, '_ry_state', true ),
            'pincode'      => get_post_meta( $post->ID, '_ry_pincode', true ),
            'phone'        => get_post_meta( $post->ID, '_ry_phone', true ),
            'email'        => get_post_meta( $post->ID, '_ry_email', true ),
            'opening_hours' => get_post_meta( $post->ID, '_ry_opening_hours', true ),
            'latitude'     => get_post_meta( $post->ID, '_ry_location_lat', true ),
            'longitude'    => get_post_meta( $post->ID, '_ry_location_lng', true ),
        ];

        if ( $is_single ) {
            $data['description'] = apply_filters( 'the_content', $post->post_content );
        }

        return $data;
    }
}
