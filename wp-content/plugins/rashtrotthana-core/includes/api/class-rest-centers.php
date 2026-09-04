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
        ] );
    }

    public function get_centers( \WP_REST_Request $request ) {
        $args = [
            'post_type'      => 'center',
            'posts_per_page' => $request->get_param( 'per_page' ) ?: -1,
        ];

        $query = new \WP_Query( $args );
        $data = [];

        foreach ( $query->posts as $post ) {
            $data[] = [
                'id'           => $post->ID,
                'title'        => get_the_title( $post ),
                'thumbnail'    => get_the_post_thumbnail_url( $post->ID, 'large' ),
                'address'      => get_post_meta( $post->ID, '_ry_address', true ),
                'city'         => get_post_meta( $post->ID, '_ry_city', true ),
                'state'        => get_post_meta( $post->ID, '_ry_state', true ),
                'pincode'      => get_post_meta( $post->ID, '_ry_pincode', true ),
                'phone'        => get_post_meta( $post->ID, '_ry_phone', true ),
                'email'        => get_post_meta( $post->ID, '_ry_email', true ),
                'location_lat' => get_post_meta( $post->ID, '_ry_location_lat', true ),
                'location_lng' => get_post_meta( $post->ID, '_ry_location_lng', true ),
            ];
        }

        return rest_ensure_response( [
            'data'  => $data,
            'total' => $query->found_posts,
        ] );
    }
}
