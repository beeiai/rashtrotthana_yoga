<?php
namespace Rashtrotthana\Registration\Validation;

class Validator {

    /**
     * Validate an email address
     */
    public static function is_valid_email( $email ) {
        return is_email( $email );
    }

    /**
     * Validate a phone number (e.g. +91XXXXXXXXXX or standard 10 digit)
     */
    public static function is_valid_phone( $phone ) {
        // Strip whitespace and dashes
        $phone = preg_replace('/[\s\-]/', '', $phone);
        // Very basic validation: Optional +, followed by 10-15 digits
        return preg_match('/^\+?[0-9]{10,15}$/', $phone);
    }

    /**
     * Validate form answers against the defined fields
     */
    public static function validate_answers( $form_fields, $answers ) {
        $errors = [];
        $sanitized_answers = [];

        foreach ( $form_fields as $field ) {
            $key = $field['field_key'];
            $value = isset( $answers[ $key ] ) ? trim( $answers[ $key ] ) : '';

            // Check required
            if ( $field['required'] && $value === '' ) {
                $errors[ $key ] = sprintf( __( 'The field "%s" is required.', 'rashtrotthana-registration' ), $field['label'] );
                continue;
            }

            // Skip empty non-required fields
            if ( $value === '' ) {
                continue;
            }

            // Validate based on type
            switch ( $field['field_type'] ) {
                case 'email':
                    if ( ! self::is_valid_email( $value ) ) {
                        $errors[ $key ] = sprintf( __( 'The field "%s" must be a valid email address.', 'rashtrotthana-registration' ), $field['label'] );
                    } else {
                        $sanitized_answers[ $key ] = sanitize_email( $value );
                    }
                    break;
                case 'phone':
                    if ( ! self::is_valid_phone( $value ) ) {
                        $errors[ $key ] = sprintf( __( 'The field "%s" must be a valid phone number.', 'rashtrotthana-registration' ), $field['label'] );
                    } else {
                        $sanitized_answers[ $key ] = sanitize_text_field( $value );
                    }
                    break;
                case 'textarea':
                    $sanitized_answers[ $key ] = sanitize_textarea_field( $value );
                    break;
                case 'number':
                    if ( ! is_numeric( $value ) ) {
                        $errors[ $key ] = sprintf( __( 'The field "%s" must be a number.', 'rashtrotthana-registration' ), $field['label'] );
                    } else {
                        $sanitized_answers[ $key ] = floatval( $value );
                    }
                    break;
                default:
                    // Default to text field sanitization
                    $sanitized_answers[ $key ] = sanitize_text_field( $value );
                    break;
            }
        }

        return [
            'is_valid' => empty( $errors ),
            'errors'   => $errors,
            'answers'  => $sanitized_answers
        ];
    }
}
