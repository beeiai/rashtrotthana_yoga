<?php
namespace Rashtrotthana\Registration\Forms;

class Form_Manager {

    /**
     * Get a form and its fields by ID
     */
    public static function get_form( $form_id ) {
        global $wpdb;

        $form = $wpdb->get_row( $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}ry_forms WHERE id = %d AND status = 'active'",
            $form_id
        ), ARRAY_A );

        if ( ! $form ) {
            return false;
        }

        $fields = $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}ry_form_fields WHERE form_id = %d ORDER BY sort_order ASC",
            $form_id
        ), ARRAY_A );

        // Parse JSON options/settings
        foreach ( $fields as &$field ) {
            $field['options'] = !empty( $field['options'] ) ? json_decode( $field['options'], true ) : [];
            $field['settings'] = !empty( $field['settings'] ) ? json_decode( $field['settings'], true ) : [];
            $field['required'] = (bool) $field['required'];
        }

        $form['fields'] = $fields;

        return $form;
    }

    /**
     * Get all active forms (useful for admin dropdowns)
     */
    public static function get_all_forms() {
        global $wpdb;

        return $wpdb->get_results(
            "SELECT id, title FROM {$wpdb->prefix}ry_forms WHERE status = 'active' ORDER BY title ASC",
            ARRAY_A
        );
    }
}
