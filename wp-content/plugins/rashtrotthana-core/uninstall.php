<?php
/**
 * Rashtrotthana Core Uninstall
 *
 * Fired when the plugin is uninstalled.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// Clear any cached data or options created by Core
delete_option( 'ry_core_version' );

// Note: We do NOT delete post types, terms, or meta here to prevent accidental data loss.
