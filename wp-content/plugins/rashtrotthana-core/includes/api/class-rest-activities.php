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
            'permission_callback' => '__return_true', // Publicly accessible
        ] );
    }

    public function get_activities( \WP_REST_Request $request ) {
        $args = [
            'post_type'      => 'activity',
            'posts_per_page' => $request->get_param( 'per_page' ) ?: 10,
            'paged'          => $request->get_param( 'page' ) ?: 1,
        ];

        if ( $request->get_param( 'category' ) ) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'activity_category',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field( $request->get_param( 'category' ) ),
                ],
            ];
        }

        $query = new \WP_Query( $args );
        $data = [];

        foreach ( $query->posts as $post ) {
            $data[] = [
                'id'                    => $post->ID,
                'title'                 => get_the_title( $post ),
                'excerpt'               => get_the_excerpt( $post ),
                'thumbnail'             => get_the_post_thumbnail_url( $post->ID, 'large' ),
                'duration_minutes'      => get_post_meta( $post->ID, '_ry_duration_minutes', true ),
                'difficulty_level'      => get_post_meta( $post->ID, '_ry_difficulty_level', true ),
                'instructor'            => get_post_meta( $post->ID, '_ry_instructor', true ),
                'requires_registration' => (bool) get_post_meta( $post->ID, '_ry_requires_registration', true ),
            ];
        }

        return rest_ensure_response( [
            'data'  => $data,
            'total' => $query->found_posts,
            'pages' => $query->max_num_pages,
        ] );
    }
}
