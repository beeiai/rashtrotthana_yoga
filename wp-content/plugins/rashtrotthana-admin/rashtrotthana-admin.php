<?php
/**
 * Plugin Name: Rashtrotthana Admin Portal
 * Plugin URI:  https://rashtrotthana.org
 * Description: Custom admin portal for the entire Rashtrotthana Yoga website — manages registrations, events, WhatsApp (WATI), roles & responsibilities, and settings.
 * Version:     1.4.0
 * Author:      Rashtrotthana Yoga
 * License:     GPL-2.0-or-later
 * Text Domain: rashtrotthana-admin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'RADM_VERSION',    '1.4.0' );
define( 'RADM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RADM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once RADM_PLUGIN_DIR . 'includes/admin-init.php';
