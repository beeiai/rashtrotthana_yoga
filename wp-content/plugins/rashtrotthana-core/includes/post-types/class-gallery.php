<?php
namespace Rashtrotthana\Core\Post_Types;

class Gallery {
    public function register() {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    public function register_post_type() {
        $labels = [
            'name'               => _x( 'Gallery Items', 'post type general name', 'rashtrotthana-core' ),
            'singular_name'      => _x( 'Gallery Item', 'post type singular name', 'rashtrotthana-core' ),
            'menu_name'          => _x( 'Gallery', 'admin menu', 'rashtrotthana-core' ),
            'name_admin_bar'     => _x( 'Gallery Item', 'add new on admin bar', 'rashtrotthana-core' ),
            'add_new'            => _x( 'Add New', 'gallery item', 'rashtrotthana-core' ),
            'add_new_item'       => __( 'Add New Gallery Item', 'rashtrotthana-core' ),
            'new_item'           => __( 'New Gallery Item', 'rashtrotthana-core' ),
            'edit_item'          => __( 'Edit Gallery Item', 'rashtrotthana-core' ),
            'view_item'          => __( 'View Gallery Item', 'rashtrotthana-core' ),
            'all_items'          => __( 'All Gallery Items', 'rashtrotthana-core' ),
            'search_items'       => __( 'Search Gallery Items', 'rashtrotthana-core' ),
            'not_found'          => __( 'No gallery items found.', 'rashtrotthana-core' ),
            'not_found_in_trash' => __( 'No gallery items found in Trash.', 'rashtrotthana-core' )
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => false,
            'query_var'          => true,
            'rewrite'            => [ 'slug' => 'gallery-item' ],
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 24,
            'menu_icon'          => 'dashicons-format-gallery',
            'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
            'taxonomies'         => [ 'gallery_category' ],
            'show_in_rest'       => true,
            'rest_base'          => 'gallery',
        ];

        register_post_type( 'ry_gallery', $args );
    }
}
