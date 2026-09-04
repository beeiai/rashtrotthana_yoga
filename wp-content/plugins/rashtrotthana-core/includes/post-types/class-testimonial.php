<?php
namespace Rashtrotthana\Core\Post_Types;

class Testimonial {
    public function register() {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    public function register_post_type() {
        $labels = [
            'name'               => _x( 'Testimonials', 'post type general name', 'rashtrotthana-core' ),
            'singular_name'      => _x( 'Testimonial', 'post type singular name', 'rashtrotthana-core' ),
            'menu_name'          => _x( 'Testimonials', 'admin menu', 'rashtrotthana-core' ),
            'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'rashtrotthana-core' ),
            'add_new'            => _x( 'Add New', 'testimonial', 'rashtrotthana-core' ),
            'add_new_item'       => __( 'Add New Testimonial', 'rashtrotthana-core' ),
            'new_item'           => __( 'New Testimonial', 'rashtrotthana-core' ),
            'edit_item'          => __( 'Edit Testimonial', 'rashtrotthana-core' ),
            'view_item'          => __( 'View Testimonial', 'rashtrotthana-core' ),
            'all_items'          => __( 'All Testimonials', 'rashtrotthana-core' ),
            'search_items'       => __( 'Search Testimonials', 'rashtrotthana-core' ),
            'not_found'          => __( 'No testimonials found.', 'rashtrotthana-core' ),
            'not_found_in_trash' => __( 'No testimonials found in Trash.', 'rashtrotthana-core' )
        ];

        $args = [
            'labels'             => $labels,
            'public'             => false, // Typically displayed via shortcode/blocks
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => false,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 24,
            'menu_icon'          => 'dashicons-testimonial',
            'supports'           => [ 'title', 'editor', 'thumbnail' ], // Title = Name, Editor = Testimonial text, Thumbnail = Photo
            'show_in_rest'       => true,
            'rest_base'          => 'testimonial',
        ];

        register_post_type( 'testimonial', $args );
    }
}
