<?php
namespace Rashtrotthana\Core;

class Plugin {

    public function init() {
        // Load text domain
        add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );

        // Initialize Post Types
        $this->init_post_types();

        // Initialize Taxonomies
        $this->init_taxonomies();

        // Initialize Meta Boxes
        $this->init_meta();

        // Initialize REST API
        $this->init_rest_api();

        // Initialize Integrations
        $this->init_integrations();
    }

    public function load_textdomain() {
        load_plugin_textdomain( 'rashtrotthana-core', false, dirname( plugin_basename( RY_CORE_PLUGIN_DIR ) ) . '/languages' );
    }

    private function init_post_types() {
        ( new Post_Types\Activity() )->register();
        ( new Post_Types\Center() )->register();
        ( new Post_Types\Event() )->register();
        ( new Post_Types\Resource() )->register();
        ( new Post_Types\Testimonial() )->register();
        ( new Post_Types\Faq() )->register();
    }

    private function init_taxonomies() {
        ( new Taxonomies\Activity_Category() )->register();
        ( new Taxonomies\Resource_Category() )->register();
        ( new Taxonomies\Resource_Type() )->register();
        ( new Taxonomies\Gallery_Category() )->register();
        ( new Taxonomies\Faq_Category() )->register();
    }

    private function init_meta() {
        ( new Meta\Activity_Meta() )->init();
        ( new Meta\Center_Meta() )->init();
        ( new Meta\Event_Meta() )->init();
        ( new Meta\Resource_Meta() )->init();
    }

    private function init_rest_api() {
        ( new Api\Rest_Activities() )->init();
        ( new Api\Rest_Centers() )->init();
        ( new Api\Rest_Events() )->init();
        ( new Api\Rest_Resources() )->init();
        ( new Api\Rest_Search() )->init();
    }

    private function init_integrations() {
        ( new Integrations\Registration_Hooks() )->init();
        ( new Integrations\Wati_Hooks() )->init();
    }

    public static function activate() {
        // Run registration methods to ensure flush_rewrite_rules works
        ( new Post_Types\Activity() )->register_post_type();
        ( new Post_Types\Center() )->register_post_type();
        ( new Post_Types\Event() )->register_post_type();
        ( new Post_Types\Resource() )->register_post_type();
        ( new Post_Types\Testimonial() )->register_post_type();
        ( new Post_Types\Faq() )->register_post_type();
        
        ( new Taxonomies\Activity_Category() )->register_taxonomy();
        ( new Taxonomies\Resource_Category() )->register_taxonomy();
        ( new Taxonomies\Resource_Type() )->register_taxonomy();
        ( new Taxonomies\Gallery_Category() )->register_taxonomy();
        ( new Taxonomies\Faq_Category() )->register_taxonomy();

        flush_rewrite_rules();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }
}
