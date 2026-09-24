<?php
namespace Rashtrotthana\Core\Post_Types;

class Gallery {
    public function register() {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    public function register_post_type() {
        $labels = [
            'name'               => _x( 'Gallery Albums', 'post type general name', 'rashtrotthana-core' ),
            'singular_name'      => _x( 'Album', 'post type singular name', 'rashtrotthana-core' ),
            'menu_name'          => _x( 'Gallery', 'admin menu', 'rashtrotthana-core' ),
            'name_admin_bar'     => _x( 'Album', 'add new on admin bar', 'rashtrotthana-core' ),
            'add_new'            => _x( 'Add New', 'album', 'rashtrotthana-core' ),
            'add_new_item'       => __( 'Add New Album', 'rashtrotthana-core' ),
            'new_item'           => __( 'New Album', 'rashtrotthana-core' ),
            'edit_item'          => __( 'Edit Album', 'rashtrotthana-core' ),
            'view_item'          => __( 'View Album', 'rashtrotthana-core' ),
            'all_items'          => __( 'All Albums', 'rashtrotthana-core' ),
            'search_items'       => __( 'Search Albums', 'rashtrotthana-core' ),
            'not_found'          => __( 'No albums found.', 'rashtrotthana-core' ),
            'not_found_in_trash' => __( 'No albums found in Trash.', 'rashtrotthana-core' )
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => [ 'slug' => 'gallery-album' ],
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 24,
            'menu_icon'          => 'dashicons-format-gallery',
            'supports'           => [ 'title', 'editor', 'thumbnail' ], // thumbnail for cover image
            'show_in_rest'       => true,
            'rest_base'          => 'gallery',
        ];

        register_post_type( 'gallery_album', $args );
    }
}
