<?php
namespace Rashtrotthana\Core\Post_Types;

class Resource {
    public function register() {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    public function register_post_type() {
        $labels = [
            'name'               => _x( 'Resources', 'post type general name', 'rashtrotthana-core' ),
            'singular_name'      => _x( 'Resource', 'post type singular name', 'rashtrotthana-core' ),
            'menu_name'          => _x( 'Resources', 'admin menu', 'rashtrotthana-core' ),
            'name_admin_bar'     => _x( 'Resource', 'add new on admin bar', 'rashtrotthana-core' ),
            'add_new'            => _x( 'Add New', 'resource', 'rashtrotthana-core' ),
            'add_new_item'       => __( 'Add New Resource', 'rashtrotthana-core' ),
            'new_item'           => __( 'New Resource', 'rashtrotthana-core' ),
            'edit_item'          => __( 'Edit Resource', 'rashtrotthana-core' ),
            'view_item'          => __( 'View Resource', 'rashtrotthana-core' ),
            'all_items'          => __( 'All Resources', 'rashtrotthana-core' ),
            'search_items'       => __( 'Search Resources', 'rashtrotthana-core' ),
            'not_found'          => __( 'No resources found.', 'rashtrotthana-core' ),
            'not_found_in_trash' => __( 'No resources found in Trash.', 'rashtrotthana-core' )
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => [ 'slug' => 'resources' ],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 23,
            'menu_icon'          => 'dashicons-media-document',
            'supports'           => [ 'title', 'editor', 'thumbnail' ],
            'show_in_rest'       => true,
            'rest_base'          => 'resource',
        ];

        register_post_type( 'resource', $args );
    }
}
