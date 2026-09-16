<?php
namespace Rashtrotthana\Core\Taxonomies;

class Activity_Category {
    public function register() {
        add_action( 'init', [ $this, 'register_taxonomy' ] );
    }

    public function register_taxonomy() {
        $labels = [
            'name'              => _x( 'Activity Categories', 'taxonomy general name', 'rashtrotthana-core' ),
            'singular_name'     => _x( 'Activity Category', 'taxonomy singular name', 'rashtrotthana-core' ),
            'search_items'      => __( 'Search Activity Categories', 'rashtrotthana-core' ),
            'all_items'         => __( 'All Activity Categories', 'rashtrotthana-core' ),
            'parent_item'       => __( 'Parent Activity Category', 'rashtrotthana-core' ),
            'parent_item_colon' => __( 'Parent Activity Category:', 'rashtrotthana-core' ),
            'edit_item'         => __( 'Edit Activity Category', 'rashtrotthana-core' ),
            'update_item'       => __( 'Update Activity Category', 'rashtrotthana-core' ),
            'add_new_item'      => __( 'Add New Activity Category', 'rashtrotthana-core' ),
            'new_item_name'     => __( 'New Activity Category Name', 'rashtrotthana-core' ),
            'menu_name'         => __( 'Categories', 'rashtrotthana-core' ),
        ];

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'activity-category' ],
            'show_in_rest'      => true,
            'rest_base'         => 'activity_category',
        ];

        register_taxonomy( 'activity_category', [ 'activity' ], $args );
    }
}
