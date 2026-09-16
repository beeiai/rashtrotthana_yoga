<?php
namespace Rashtrotthana\Core\Taxonomies;

class Faq_Category {
    public function register() {
        add_action( 'init', [ $this, 'register_taxonomy' ] );
    }

    public function register_taxonomy() {
        $labels = [
            'name'              => _x( 'FAQ Categories', 'taxonomy general name', 'rashtrotthana-core' ),
            'singular_name'     => _x( 'FAQ Category', 'taxonomy singular name', 'rashtrotthana-core' ),
            'search_items'      => __( 'Search FAQ Categories', 'rashtrotthana-core' ),
            'all_items'         => __( 'All FAQ Categories', 'rashtrotthana-core' ),
            'parent_item'       => __( 'Parent FAQ Category', 'rashtrotthana-core' ),
            'parent_item_colon' => __( 'Parent FAQ Category:', 'rashtrotthana-core' ),
            'edit_item'         => __( 'Edit FAQ Category', 'rashtrotthana-core' ),
            'update_item'       => __( 'Update FAQ Category', 'rashtrotthana-core' ),
            'add_new_item'      => __( 'Add New FAQ Category', 'rashtrotthana-core' ),
            'new_item_name'     => __( 'New FAQ Category Name', 'rashtrotthana-core' ),
            'menu_name'         => __( 'Categories', 'rashtrotthana-core' ),
        ];

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'faq-category' ],
            'show_in_rest'      => true,
            'rest_base'         => 'faq_category',
        ];

        register_taxonomy( 'faq_category', [ 'faq' ], $args );
    }
}
