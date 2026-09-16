<?php
namespace Rashtrotthana\Core\Post_Types;

class Center {
    public function register() {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    public function register_post_type() {
        $labels = [
            'name'               => _x( 'Centers', 'post type general name', 'rashtrotthana-core' ),
            'singular_name'      => _x( 'Center', 'post type singular name', 'rashtrotthana-core' ),
            'menu_name'          => _x( 'Centers', 'admin menu', 'rashtrotthana-core' ),
            'name_admin_bar'     => _x( 'Center', 'add new on admin bar', 'rashtrotthana-core' ),
            'add_new'            => _x( 'Add New', 'center', 'rashtrotthana-core' ),
            'add_new_item'       => __( 'Add New Center', 'rashtrotthana-core' ),
            'new_item'           => __( 'New Center', 'rashtrotthana-core' ),
            'edit_item'          => __( 'Edit Center', 'rashtrotthana-core' ),
            'view_item'          => __( 'View Center', 'rashtrotthana-core' ),
            'all_items'          => __( 'All Centers', 'rashtrotthana-core' ),
            'search_items'       => __( 'Search Centers', 'rashtrotthana-core' ),
            'not_found'          => __( 'No centers found.', 'rashtrotthana-core' ),
            'not_found_in_trash' => __( 'No centers found in Trash.', 'rashtrotthana-core' )
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => [ 'slug' => 'centers' ],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 21,
            'menu_icon'          => 'dashicons-location',
            'supports'           => [ 'title', 'editor', 'thumbnail' ],
            'show_in_rest'       => true,
            'rest_base'          => 'center',
        ];

        register_post_type( 'center', $args );
    }
}
