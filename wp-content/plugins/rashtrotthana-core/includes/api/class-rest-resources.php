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
                'type'     => [
                    'sanitize_callback' => 'sanitize_text_field',
                ],
                'featured' => [
                    'sanitize_callback' => 'sanitize_text_field',
                ]
            ]
        ] );

        register_rest_route( 'ry/v1', '/resources/(?P<id>\d+)', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [ $this, 'get_resource' ],
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

    public function get_resources( \WP_REST_Request $request ) {
        $args = [
            'post_type'      => 'resource',
            'post_status'    => 'publish', // SECURITY FIX
            'posts_per_page' => $request->get_param( 'per_page' ),
            'paged'          => $request->get_param( 'page' ),
        ];

        $tax_queries = [];
        
        if ( $request->get_param( 'category' ) ) {
            $tax_queries[] = [
                'taxonomy' => 'resource_category',
                'field'    => 'slug',
                'terms'    => $request->get_param( 'category' ),
            ];
        }

        if ( $request->get_param( 'type' ) ) {
            $tax_queries[] = [
                'taxonomy' => 'resource_type',
                'field'    => 'slug',
                'terms'    => $request->get_param( 'type' ),
            ];
        }

        if ( count( $tax_queries ) > 0 ) {
            if ( count( $tax_queries ) > 1 ) {
                $tax_queries['relation'] = 'AND';
            }
            $args['tax_query'] = $tax_queries;
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
            $data[] = $this->prepare_resource_for_response( $post );
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

    public function get_resource( \WP_REST_Request $request ) {
        $post = get_post( (int) $request->get_param( 'id' ) );
        
        if ( ! $post || $post->post_type !== 'resource' || $post->post_status !== 'publish' ) {
            return new \WP_Error( 'not_found', 'Resource not found', [ 'status' => 404 ] );
        }

        return rest_ensure_response( $this->prepare_resource_for_response( $post, true ) );
    }

    private function prepare_resource_for_response( $post, $is_single = false ) {
        $terms_cat = wp_get_post_terms( $post->ID, 'resource_category' );
        $category = ! is_wp_error( $terms_cat ) && ! empty( $terms_cat ) ? [ 'id' => $terms_cat[0]->term_id, 'name' => $terms_cat[0]->name, 'slug' => $terms_cat[0]->slug ] : null;

        $terms_type = wp_get_post_terms( $post->ID, 'resource_type' );
        $type = ! is_wp_error( $terms_type ) && ! empty( $terms_type ) ? [ 'id' => $terms_type[0]->term_id, 'name' => $terms_type[0]->name, 'slug' => $terms_type[0]->slug ] : null;

        $image_id = get_post_thumbnail_id( $post->ID );
        $image = null;
        if ( $image_id ) {
            $image = [
                'url' => wp_get_attachment_image_url( $image_id, 'large' ),
                'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true )
            ];
        }

        $data = [
            'id'               => $post->ID,
            'title'            => get_the_title( $post ),
            'slug'             => $post->post_name,
            'short_description'=> get_the_excerpt( $post ),
            'featured_image'   => $image,
            'category'         => $category,
            'type'             => $type,
            'file_url'         => get_post_meta( $post->ID, '_ry_file_url', true ),
            'external_link'    => get_post_meta( $post->ID, '_ry_external_link', true ),
            'publication_date' => get_post_meta( $post->ID, '_ry_publication_date', true ),
            'featured'         => (bool) get_post_meta( $post->ID, '_ry_featured', true ),
        ];

        if ( $is_single ) {
            $data['description'] = apply_filters( 'the_content', $post->post_content );
        }

        return $data;
    }
}
