<?php
namespace Rashtrotthana\Core\Api;

class Rest_Search {
    public function init() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public function register_routes() {
        register_rest_route( 'ry/v1', '/search', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [ $this, 'global_search' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'query' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'required'          => true,
                ],
                'per_page' => [
                    'sanitize_callback' => 'absint',
                    'default'           => 10,
                ],
                'type' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default'           => 'all', // all, activity, center, event, resource, faq
                ]
            ]
        ] );
    }

    public function global_search( \WP_REST_Request $request ) {
        $search_query = $request->get_param( 'query' );
        
        if ( empty( $search_query ) ) {
            return rest_ensure_response( [
                'items' => [],
                'total' => 0
            ] );
        }

        $type_param = $request->get_param( 'type' );
        $post_types = [];
        
        if ( $type_param === 'all' ) {
            $post_types = [ 'activity', 'center', 'event', 'resource', 'faq', 'post', 'page' ];
        } else {
            // Validate requested type
            $allowed_types = [ 'activity', 'center', 'event', 'resource', 'faq' ];
            $requested_types = explode( ',', $type_param );
            foreach ( $requested_types as $type ) {
                if ( in_array( trim( $type ), $allowed_types ) ) {
                    $post_types[] = trim( $type );
                }
            }
            if ( empty( $post_types ) ) {
                $post_types = [ 'activity', 'center', 'event', 'resource', 'faq' ];
            }
        }

        $args = [
            'post_type'      => $post_types,
            'post_status'    => 'publish', // SECURITY FIX
            's'              => $search_query,
            'posts_per_page' => $request->get_param( 'per_page' ),
        ];

        $query = new \WP_Query( $args );
        $data = [];

        foreach ( $query->posts as $post ) {
            $image_id = get_post_thumbnail_id( $post->ID );
            $image = null;
            if ( $image_id ) {
                $image = [
                    'url' => wp_get_attachment_image_url( $image_id, 'thumbnail' )
                ];
            }

            $data[] = [
                'id'        => $post->ID,
                'title'     => get_the_title( $post ),
                'type'      => $post->post_type,
                'url'       => get_permalink( $post ),
                'excerpt'   => get_the_excerpt( $post ),
                'image'     => $image
            ];
        }

        return rest_ensure_response( [
            'items' => $data,
            'total' => $query->found_posts,
        ] );
    }
}
