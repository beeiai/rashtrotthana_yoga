<?php
namespace Rashtrotthana\Core\Post_Types;

class Event {
    public function register() {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    public function register_post_type() {
        $labels = [
            'name'               => _x( 'Events', 'post type general name', 'rashtrotthana-core' ),
            'singular_name'      => _x( 'Event', 'post type singular name', 'rashtrotthana-core' ),
            'menu_name'          => _x( 'Events', 'admin menu', 'rashtrotthana-core' ),
            'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'rashtrotthana-core' ),
            'add_new'            => _x( 'Add New', 'event', 'rashtrotthana-core' ),
            'add_new_item'       => __( 'Add New Event', 'rashtrotthana-core' ),
            'new_item'           => __( 'New Event', 'rashtrotthana-core' ),
            'edit_item'          => __( 'Edit Event', 'rashtrotthana-core' ),
            'view_item'          => __( 'View Event', 'rashtrotthana-core' ),
            'all_items'          => __( 'All Events', 'rashtrotthana-core' ),
            'search_items'       => __( 'Search Events', 'rashtrotthana-core' ),
            'not_found'          => __( 'No events found.', 'rashtrotthana-core' ),
            'not_found_in_trash' => __( 'No events found in Trash.', 'rashtrotthana-core' )
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => [ 'slug' => 'events' ],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 22,
            'menu_icon'          => 'dashicons-calendar-alt',
            'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
            'show_in_rest'       => true,
            'rest_base'          => 'event',
        ];

        register_post_type( 'event', $args );
    }
}
