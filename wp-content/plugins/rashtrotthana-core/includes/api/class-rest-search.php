<?php
namespace Rashtrotthana\Core\Api;

class Rest_Search {
    public function init() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public function register_routes() {
        register_rest_route( 'ry/v1', '/search', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [ $this, 'get_search_results' ],
            'permission_callback' => '__return_true',
        ] );
    }

    public function get_search_results( \WP_REST_Request $request ) {
        $keyword = $request->get_param( 'q' );
        
        if ( empty( $keyword ) ) {
            return new \WP_Error( 'missing_param', 'The q parameter is required', [ 'status' => 400 ] );
        }

        $args = [
            'post_type'      => [ 'activity', 'center', 'event', 'resource' ],
            'posts_per_page' => 20,
            's'              => sanitize_text_field( $keyword ),
        ];

        $query = new \WP_Query( $args );
        $data = [];

        foreach ( $query->posts as $post ) {
            $data[] = [
                'id'        => $post->ID,
                'title'     => get_the_title( $post ),
                'type'      => $post->post_type,
                'excerpt'   => get_the_excerpt( $post ),
                'url'       => get_permalink( $post ),
            ];
        }

        return rest_ensure_response( [
            'data'  => $data,
            'total' => $query->found_posts,
        ] );
    }
}
