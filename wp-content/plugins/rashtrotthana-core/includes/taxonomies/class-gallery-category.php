<?php
namespace Rashtrotthana\Core\Taxonomies;

class Gallery_Category {
    public function register() {
        add_action( 'init', [ $this, 'register_taxonomy' ] );
    }

    public function register_taxonomy() {
        $labels = [
            'name'              => _x( 'Gallery Categories', 'taxonomy general name', 'rashtrotthana-core' ),
            'singular_name'     => _x( 'Gallery Category', 'taxonomy singular name', 'rashtrotthana-core' ),
            'search_items'      => __( 'Search Gallery Categories', 'rashtrotthana-core' ),
            'all_items'         => __( 'All Gallery Categories', 'rashtrotthana-core' ),
            'parent_item'       => __( 'Parent Gallery Category', 'rashtrotthana-core' ),
            'parent_item_colon' => __( 'Parent Gallery Category:', 'rashtrotthana-core' ),
            'edit_item'         => __( 'Edit Gallery Category', 'rashtrotthana-core' ),
            'update_item'       => __( 'Update Gallery Category', 'rashtrotthana-core' ),
            'add_new_item'      => __( 'Add New Gallery Category', 'rashtrotthana-core' ),
            'new_item_name'     => __( 'New Gallery Category Name', 'rashtrotthana-core' ),
            'menu_name'         => __( 'Gallery Categories', 'rashtrotthana-core' ),
        ];

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'gallery-category' ],
            'show_in_rest'      => true,
            'rest_base'         => 'gallery_category',
        ];

        register_taxonomy( 'gallery_category', [ 'attachment' ], $args );
    }
}
