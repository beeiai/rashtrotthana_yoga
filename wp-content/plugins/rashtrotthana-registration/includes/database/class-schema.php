<?php
namespace Rashtrotthana\Registration\Database;

class Schema {

    /**
     * Current database version for migrations
     */
    const DB_VERSION = '1.0.0';

    /**
     * Create or update database tables.
     */
    public static function update_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        // 1. Forms Table
        $table_forms = $wpdb->prefix . 'ry_forms';
        $sql_forms = "CREATE TABLE $table_forms (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            description text,
            status varchar(50) DEFAULT 'active' NOT NULL,
            created_by bigint(20) unsigned NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            KEY status (status)
        ) $charset_collate;";
        dbDelta( $sql_forms );

        // 2. Form Fields Table
        $table_form_fields = $wpdb->prefix . 'ry_form_fields';
        $sql_form_fields = "CREATE TABLE $table_form_fields (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            form_id bigint(20) unsigned NOT NULL,
            field_key varchar(100) NOT NULL,
            label varchar(255) NOT NULL,
            field_type varchar(50) NOT NULL,
            options longtext,
            required tinyint(1) DEFAULT 0 NOT NULL,
            sort_order int(11) DEFAULT 0 NOT NULL,
            settings longtext,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            KEY form_id (form_id),
            KEY field_key (field_key)
        ) $charset_collate;";
        dbDelta( $sql_form_fields );

        // 3. Registrations Table
        $table_registrations = $wpdb->prefix . 'ry_registrations';
        $sql_registrations = "CREATE TABLE $table_registrations (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            registration_uuid varchar(64) NOT NULL,
            form_id bigint(20) unsigned NOT NULL,
            activity_id bigint(20) unsigned DEFAULT NULL,
            event_id bigint(20) unsigned DEFAULT NULL,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            phone varchar(50) NOT NULL,
            status varchar(50) DEFAULT 'pending' NOT NULL,
            language varchar(10) DEFAULT 'en' NOT NULL,
            source varchar(50) DEFAULT 'web' NOT NULL,
            submitted_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
            confirmed_at datetime DEFAULT NULL,
            cancelled_at datetime DEFAULT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY registration_uuid (registration_uuid),
            KEY form_id (form_id),
            KEY activity_id (activity_id),
            KEY event_id (event_id),
            KEY status (status),
            KEY email (email),
            KEY phone (phone)
        ) $charset_collate;";
        dbDelta( $sql_registrations );

        // 4. Registration Answers Table
        $table_answers = $wpdb->prefix . 'ry_registration_answers';
        $sql_answers = "CREATE TABLE $table_answers (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            registration_id bigint(20) unsigned NOT NULL,
            field_key varchar(100) NOT NULL,
            field_value longtext,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            KEY registration_id (registration_id),
            KEY field_key (field_key)
        ) $charset_collate;";
        dbDelta( $sql_answers );

        // Update DB version in options
        update_option( 'ry_registration_db_version', self::DB_VERSION );
    }
}
