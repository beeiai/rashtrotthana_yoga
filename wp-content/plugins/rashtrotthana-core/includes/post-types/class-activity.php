<?php
namespace Rashtrotthana\Core\Post_Types;

class Activity {
    public function register() {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    public function register_post_type() {
        $labels = [
            'name'               => _x( 'Activities', 'post type general name', 'rashtrotthana-core' ),
            'singular_name'      => _x( 'Activity', 'post type singular name', 'rashtrotthana-core' ),
            'menu_name'          => _x( 'Activities', 'admin menu', 'rashtrotthana-core' ),
            'name_admin_bar'     => _x( 'Activity', 'add new on admin bar', 'rashtrotthana-core' ),
            'add_new'            => _x( 'Add New', 'activity', 'rashtrotthana-core' ),
            'add_new_item'       => __( 'Add New Activity', 'rashtrotthana-core' ),
            'new_item'           => __( 'New Activity', 'rashtrotthana-core' ),
            'edit_item'          => __( 'Edit Activity', 'rashtrotthana-core' ),
            'view_item'          => __( 'View Activity', 'rashtrotthana-core' ),
            'all_items'          => __( 'All Activities', 'rashtrotthana-core' ),
            'search_items'       => __( 'Search Activities', 'rashtrotthana-core' ),
            'not_found'          => __( 'No activities found.', 'rashtrotthana-core' ),
            'not_found_in_trash' => __( 'No activities found in Trash.', 'rashtrotthana-core' )
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => [ 'slug' => 'activities' ],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 20,
            'menu_icon'          => 'dashicons-universal-access',
            'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
            'show_in_rest'       => true,
            'rest_base'          => 'activity',
        ];

        register_post_type( 'activity', $args );
    }
}
