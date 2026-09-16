<?php
namespace Rashtrotthana\Core\Taxonomies;

class Resource_Type {
    public function register() {
        add_action( 'init', [ $this, 'register_taxonomy' ] );
    }

    public function register_taxonomy() {
        $labels = [
            'name'              => _x( 'Resource Types', 'taxonomy general name', 'rashtrotthana-core' ),
            'singular_name'     => _x( 'Resource Type', 'taxonomy singular name', 'rashtrotthana-core' ),
            'search_items'      => __( 'Search Resource Types', 'rashtrotthana-core' ),
            'all_items'         => __( 'All Resource Types', 'rashtrotthana-core' ),
            'parent_item'       => __( 'Parent Resource Type', 'rashtrotthana-core' ),
            'parent_item_colon' => __( 'Parent Resource Type:', 'rashtrotthana-core' ),
            'edit_item'         => __( 'Edit Resource Type', 'rashtrotthana-core' ),
            'update_item'       => __( 'Update Resource Type', 'rashtrotthana-core' ),
            'add_new_item'      => __( 'Add New Resource Type', 'rashtrotthana-core' ),
            'new_item_name'     => __( 'New Resource Type Name', 'rashtrotthana-core' ),
            'menu_name'         => __( 'Types', 'rashtrotthana-core' ),
        ];

        $args = [
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'resource-type' ],
            'show_in_rest'      => true,
            'rest_base'         => 'resource_type',
        ];

        register_taxonomy( 'resource_type', [ 'resource' ], $args );
    }
}
