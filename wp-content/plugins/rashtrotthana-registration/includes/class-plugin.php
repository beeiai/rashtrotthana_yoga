<?php
namespace Rashtrotthana\Registration;

class Plugin {

    public function init() {
        // Load dependencies
        $this->load_dependencies();

        // Load text domain
        add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );

        // Initialize modules
        $this->init_modules();
    }

    private function load_dependencies() {
        // Database
        require_once RY_REGISTRATION_PLUGIN_DIR . 'includes/database/class-schema.php';

        // Additional requires will go here as we build them.
    }

    public function load_textdomain() {
        load_plugin_textdomain( 'rashtrotthana-registration', false, dirname( plugin_basename( RY_REGISTRATION_PLUGIN_DIR ) ) . '/languages' );
    }

    private function init_modules() {
        // Initialize APIs
        require_once RY_REGISTRATION_PLUGIN_DIR . 'includes/api/class-rest-public.php';
        require_once RY_REGISTRATION_PLUGIN_DIR . 'includes/api/class-rest-admin.php';
        
        add_action( 'rest_api_init', function() {
            $public_api = new Api\Rest_Public();
            $public_api->register_routes();

            $admin_api = new Api\Rest_Admin();
            $admin_api->register_routes();
        } );

        // Initialize Admin
        if ( is_admin() ) {
            require_once RY_REGISTRATION_PLUGIN_DIR . 'includes/admin/class-admin-menu.php';
            $admin_menu = new Admin\Admin_Menu();
            $admin_menu->init();
        }

        // Include Form Manager and Validators and Submissions so they are available
        require_once RY_REGISTRATION_PLUGIN_DIR . 'includes/forms/class-form-manager.php';
        require_once RY_REGISTRATION_PLUGIN_DIR . 'includes/validation/class-validator.php';
        require_once RY_REGISTRATION_PLUGIN_DIR . 'includes/submissions/class-registration-manager.php';
        
        // Initialize Integrations
        require_once RY_REGISTRATION_PLUGIN_DIR . 'includes/integrations/class-wati-events.php';
        $wati = new Integrations\Wati_Events();
        $wati->init();
    }

    public static function activate() {
        require_once RY_REGISTRATION_PLUGIN_DIR . 'includes/database/class-schema.php';
        
        // 1. Create/Update Database Tables
        Database\Schema::update_tables();

        // 2. Add Registration Capabilities to Roles
        self::add_capabilities();

        flush_rewrite_rules();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }

    private static function add_capabilities() {
        $admin = get_role( 'administrator' );
        if ( $admin ) {
            $admin->add_cap( 'manage_ry_registrations' );
        }

        // Add to Registration Manager if role exists, else create it
        $reg_manager = get_role( 'registration_manager' );
        if ( ! $reg_manager ) {
            add_role( 'registration_manager', __( 'Registration Manager', 'rashtrotthana-registration' ), [
                'read' => true,
                'manage_ry_registrations' => true,
            ]);
        } else {
            $reg_manager->add_cap( 'manage_ry_registrations' );
        }
    }
}
