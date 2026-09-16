<?php
namespace Rashtrotthana\Core\Taxonomies;

class Resource_Category {
    public function register() {
        add_action( 'init', [ $this, 'register_taxonomy' ] );
    }

    public function register_taxonomy() {
        $labels = [
            'name'              => _x( 'Resource Categories', 'taxonomy general name', 'rashtrotthana-core' ),
            'singular_name'     => _x( 'Resource Category', 'taxonomy singular name', 'rashtrotthana-core' ),
            'search_items'      => __( 'Search Resource Categories', 'rashtrotthana-core' ),
            'all_items'         => __( 'All Resource Categories', 'rashtrotthana-core' ),
            'parent_item'       => __( 'Parent Resource Category', 'rashtrotthana-core' ),
            'parent_item_colon' => __( 'Parent Resource Category:', 'rashtrotthana-core' ),
            'edit_item'         => __( 'Edit Resource Category', 'rashtrotthana-core' ),
            'update_item'       => __( 'Update Resource Category', 'rashtrotthana-core' ),
            'add_new_item'      => __( 'Add New Resource Category', 'rashtrotthana-core' ),
            'new_item_name'     => __( 'New Resource Category Name', 'rashtrotthana-core' ),
            'menu_name'         => __( 'Categories', 'rashtrotthana-core' ),
        ];

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'resource-category' ],
            'show_in_rest'      => true,
            'rest_base'         => 'resource_category',
        ];

        register_taxonomy( 'resource_category', [ 'resource' ], $args );
    }
}
