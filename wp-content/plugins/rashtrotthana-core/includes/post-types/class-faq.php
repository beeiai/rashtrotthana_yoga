<?php
namespace Rashtrotthana\Core\Post_Types;

class Faq {
    public function register() {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    public function register_post_type() {
        $labels = [
            'name'               => _x( 'FAQs', 'post type general name', 'rashtrotthana-core' ),
            'singular_name'      => _x( 'FAQ', 'post type singular name', 'rashtrotthana-core' ),
            'menu_name'          => _x( 'FAQs', 'admin menu', 'rashtrotthana-core' ),
            'name_admin_bar'     => _x( 'FAQ', 'add new on admin bar', 'rashtrotthana-core' ),
            'add_new'            => _x( 'Add New', 'faq', 'rashtrotthana-core' ),
            'add_new_item'       => __( 'Add New FAQ', 'rashtrotthana-core' ),
            'new_item'           => __( 'New FAQ', 'rashtrotthana-core' ),
            'edit_item'          => __( 'Edit FAQ', 'rashtrotthana-core' ),
            'view_item'          => __( 'View FAQ', 'rashtrotthana-core' ),
            'all_items'          => __( 'All FAQs', 'rashtrotthana-core' ),
            'search_items'       => __( 'Search FAQs', 'rashtrotthana-core' ),
            'not_found'          => __( 'No FAQs found.', 'rashtrotthana-core' ),
            'not_found_in_trash' => __( 'No FAQs found in Trash.', 'rashtrotthana-core' )
        ];

        $args = [
            'labels'             => $labels,
            'public'             => false, // Displayed via blocks
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => false,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 25,
            'menu_icon'          => 'dashicons-editor-help',
            'supports'           => [ 'title', 'editor' ], // Title = Question, Editor = Answer
            'show_in_rest'       => true,
            'rest_base'          => 'faq',
        ];

        register_post_type( 'faq', $args );
    }
}
