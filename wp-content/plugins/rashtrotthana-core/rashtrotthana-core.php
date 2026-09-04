<?php
/**
 * Plugin Name:       Rashtrotthana Core
 * Plugin URI:        https://rashtrotthana.org/
 * Description:       Core functionality and content models for the Rashtrotthana Yoga Website.
 * Version:           1.0.0
 * Author:            Rashtrotthana IT
 * Text Domain:       rashtrotthana-core
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'RY_CORE_VERSION', '1.0.0' );
define( 'RY_CORE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RY_CORE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Autoloader for Rashtrotthana Core classes.
 */
spl_autoload_register( function( $class ) {
    $prefix = 'Rashtrotthana\\Core\\';
    $base_dir = RY_CORE_PLUGIN_DIR . 'includes/';

    $len = strlen( $prefix );
    if ( strncmp( $prefix, $class, $len ) !== 0 ) {
        return;
    }

    $relative_class = substr( $class, $len );
    $parts = explode( '\\', $relative_class );
    $class_name = array_pop( $parts );
    
    // Convert class name to file name (e.g. Activity_Meta to class-activity-meta.php)
    $file_name = 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';
    
    // Add path (e.g. Post_Types to post-types/)
    $path = '';
    if ( ! empty( $parts ) ) {
        $path = strtolower( implode( '/', $parts ) ) . '/';
        $path = str_replace( '_', '-', $path );
    }

    $file = $base_dir . $path . $file_name;

    if ( file_exists( $file ) ) {
        require $file;
    }
});

/**
 * Initialize the plugin.
 */
function run_rashtrotthana_core() {
    $plugin = new \Rashtrotthana\Core\Plugin();
    $plugin->init();
}
run_rashtrotthana_core();

/**
 * Activation hook.
 */
register_activation_hook( __FILE__, function() {
    \Rashtrotthana\Core\Plugin::activate();
});

/**
 * Deactivation hook.
 */
register_deactivation_hook( __FILE__, function() {
    \Rashtrotthana\Core\Plugin::deactivate();
});
