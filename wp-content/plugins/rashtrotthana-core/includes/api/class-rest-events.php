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
        ] );
    }

    public function get_events( \WP_REST_Request $request ) {
        $args = [
            'post_type'      => 'event',
            'posts_per_page' => $request->get_param( 'per_page' ) ?: 10,
            'paged'          => $request->get_param( 'page' ) ?: 1,
            'meta_key'       => '_ry_start_date',
            'orderby'        => 'meta_value',
            'order'          => 'ASC'
        ];

        // Filter by upcoming events by default
        if ( $request->get_param( 'upcoming' ) !== 'false' ) {
            $args['meta_query'] = [
                [
                    'key'     => '_ry_start_date',
                    'value'   => date('Y-m-d'),
                    'compare' => '>=',
                    'type'    => 'DATE'
                ]
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
                'start_date'            => get_post_meta( $post->ID, '_ry_start_date', true ),
                'end_date'              => get_post_meta( $post->ID, '_ry_end_date', true ),
                'start_time'            => get_post_meta( $post->ID, '_ry_start_time', true ),
                'end_time'              => get_post_meta( $post->ID, '_ry_end_time', true ),
                'venue'                 => get_post_meta( $post->ID, '_ry_venue', true ),
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
