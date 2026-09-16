<?php
/**
 * Plugin Name:       Rashtrotthana Registration
 * Plugin URI:        https://rashtrotthana.org/
 * Description:       Registration system for the Rashtrotthana Yoga Website activities and events.
 * Version:           1.0.0
 * Author:            Rashtrotthana IT
 * Text Domain:       rashtrotthana-registration
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define constants
define( 'RY_REGISTRATION_VERSION', '1.0.0' );
define( 'RY_REGISTRATION_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RY_REGISTRATION_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Require main plugin class
require_once RY_REGISTRATION_PLUGIN_DIR . 'includes/class-plugin.php';

// Initialize the plugin
function ry_registration_init() {
    $plugin = new \Rashtrotthana\Registration\Plugin();
    $plugin->init();
}
add_action( 'plugins_loaded', 'ry_registration_init' );

// Registration and Activation Hooks
register_activation_hook( __FILE__, [ '\Rashtrotthana\Registration\Plugin', 'activate' ] );
register_deactivation_hook( __FILE__, [ '\Rashtrotthana\Registration\Plugin', 'deactivate' ] );
