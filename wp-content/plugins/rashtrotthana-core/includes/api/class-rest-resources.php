<?php
namespace Rashtrotthana\Core\Api;

class Rest_Resources {
    public function init() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public function register_routes() {
        register_rest_route( 'ry/v1', '/resources', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [ $this, 'get_resources' ],
            'permission_callback' => '__return_true',
        ] );
    }

    public function get_resources( \WP_REST_Request $request ) {
        $args = [
            'post_type'      => 'resource',
            'posts_per_page' => $request->get_param( 'per_page' ) ?: 10,
            'paged'          => $request->get_param( 'page' ) ?: 1,
        ];

        if ( $request->get_param( 'category' ) ) {
            $args['tax_query'][] = [
                'taxonomy' => 'resource_category',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( $request->get_param( 'category' ) ),
            ];
        }

        if ( $request->get_param( 'type' ) ) {
            $args['tax_query'][] = [
                'taxonomy' => 'resource_type',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( $request->get_param( 'type' ) ),
            ];
        }

        $query = new \WP_Query( $args );
        $data = [];

        foreach ( $query->posts as $post ) {
            $data[] = [
                'id'            => $post->ID,
                'title'         => get_the_title( $post ),
                'thumbnail'     => get_the_post_thumbnail_url( $post->ID, 'large' ),
                'file_url'      => get_post_meta( $post->ID, '_ry_file_url', true ),
                'author'        => get_post_meta( $post->ID, '_ry_author', true ),
                'external_link' => get_post_meta( $post->ID, '_ry_external_link', true ),
            ];
        }

        return rest_ensure_response( [
            'data'  => $data,
            'total' => $query->found_posts,
            'pages' => $query->max_num_pages,
        ] );
    }
}
