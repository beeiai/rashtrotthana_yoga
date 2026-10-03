<?php
namespace Rashtrotthana\Core\Api;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Rest_Form_Groups {

    public function init() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public function register_routes() {
        // List (GET) & Create (POST)
        register_rest_route( 'ry/v1', '/form-groups', [
            [
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_items' ],
                'permission_callback' => '__return_true',
                'args'                => [
                    'status'   => [ 'sanitize_callback' => 'sanitize_key' ],
                    'search'   => [ 'sanitize_callback' => 'sanitize_text_field' ],
                    'per_page' => [ 'sanitize_callback' => 'absint', 'default' => 10 ],
                    'page'     => [ 'sanitize_callback' => 'absint', 'default' => 1 ],
                ],
            ],
            [
                'methods'             => \WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'create_item' ],
                'permission_callback' => [ $this, 'check_write_permission' ],
            ],
        ] );

        // Single Item: Get (GET), Update (POST/PUT/PATCH), Delete (DELETE)
        register_rest_route( 'ry/v1', '/form-groups/(?P<id>\d+)', [
            [
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_item' ],
                'permission_callback' => '__return_true',
            ],
            [
                'methods'             => \WP_REST_Server::EDITABLE,
                'callback'            => [ $this, 'update_item' ],
                'permission_callback' => [ $this, 'check_write_permission' ],
            ],
            [
                'methods'             => \WP_REST_Server::DELETABLE,
                'callback'            => [ $this, 'delete_item' ],
                'permission_callback' => [ $this, 'check_write_permission' ],
            ],
        ] );

        // Toggle Status
        register_rest_route( 'ry/v1', '/form-groups/(?P<id>\d+)/toggle-status', [
            'methods'             => \WP_REST_Server::CREATABLE,
            'callback'            => [ $this, 'toggle_status' ],
            'permission_callback' => [ $this, 'check_write_permission' ],
        ] );

        // Public Centers Endpoint (for website modal)
        register_rest_route( 'ry/v1', '/form-groups/(?P<id>\d+)/public', [
            'methods'             => \WP_REST_Server::READABLE,
            'callback'            => [ $this, 'get_public_item' ],
            'permission_callback' => '__return_true',
        ] );
    }

    public function check_write_permission( \WP_REST_Request $request ): bool {
        return current_user_can( 'manage_ry_registrations' ) || current_user_can( 'manage_options' ) || current_user_can( 'edit_posts' );
    }

    public function get_items( \WP_REST_Request $request ) {
        if ( ! class_exists( '\RADM_Form_Groups_DB' ) ) {
            $db_file = WP_PLUGIN_DIR . '/rashtrotthana-admin/includes/class-form-groups-db.php';
            if ( file_exists( $db_file ) ) {
                require_once $db_file;
            } else {
                return new \WP_Error( 'db_missing', 'Form groups database module not loaded.', [ 'status' => 500 ] );
            }
        }

        $res = \RADM_Form_Groups_DB::get_all( [
            'search'   => $request->get_param( 'search' ) ?: '',
            'status'   => $request->get_param( 'status' ) ?: '',
            'page'     => max( 1, absint( $request->get_param( 'page' ) ?: 1 ) ),
            'per_page' => max( 1, absint( $request->get_param( 'per_page' ) ?: 10 ) ),
        ] );

        return rest_ensure_response( $res );
    }

    public function get_item( \WP_REST_Request $request ) {
        $id = absint( $request->get_param( 'id' ) );
        if ( ! class_exists( '\RADM_Form_Groups_DB' ) ) {
            require_once WP_PLUGIN_DIR . '/rashtrotthana-admin/includes/class-form-groups-db.php';
        }

        $group = \RADM_Form_Groups_DB::get( $id );
        if ( ! $group ) {
            return new \WP_Error( 'not_found', 'Form group not found.', [ 'status' => 404 ] );
        }

        return rest_ensure_response( $group );
    }

    public function get_public_item( \WP_REST_Request $request ) {
        $id = absint( $request->get_param( 'id' ) );
        if ( ! class_exists( '\RADM_Form_Groups_DB' ) ) {
            require_once WP_PLUGIN_DIR . '/rashtrotthana-admin/includes/class-form-groups-db.php';
        }

        $group = \RADM_Form_Groups_DB::get( $id );
        if ( ! $group || $group['status'] !== 'active' ) {
            return new \WP_Error( 'not_available', 'Registration for this form group is currently unavailable or inactive.', [ 'status' => 404 ] );
        }

        return rest_ensure_response( [
            'id'          => $group['id'],
            'name'        => $group['name'],
            'description' => $group['description'],
            'centers'     => $group['centers'],
        ] );
    }

    public function create_item( \WP_REST_Request $request ) {
        if ( ! class_exists( '\RADM_Form_Groups_DB' ) ) {
            require_once WP_PLUGIN_DIR . '/rashtrotthana-admin/includes/class-form-groups-db.php';
        }

        $body = $request->get_json_params() ?: $request->get_body_params();
        $name = sanitize_text_field( $body['name'] ?? '' );
        if ( empty( $name ) ) {
            return new \WP_Error( 'missing_name', 'Form Group Name is required.', [ 'status' => 400 ] );
        }

        try {
            $group_id = \RADM_Form_Groups_DB::save( [
                'name'        => $name,
                'description' => sanitize_textarea_field( $body['description'] ?? '' ),
                'status'      => sanitize_key( $body['status'] ?? 'active' ),
                'centers'     => is_array( $body['centers'] ?? null ) ? $body['centers'] : [],
            ] );

            $saved = \RADM_Form_Groups_DB::get( $group_id );
            return rest_ensure_response( [
                'success' => true,
                'message' => 'Form Group created successfully.',
                'group'   => $saved,
            ] );
        } catch ( \Exception $e ) {
            return new \WP_Error( 'save_failed', $e->getMessage(), [ 'status' => 500 ] );
        }
    }

    public function update_item( \WP_REST_Request $request ) {
        $id = absint( $request->get_param( 'id' ) );
        if ( ! class_exists( '\RADM_Form_Groups_DB' ) ) {
            require_once WP_PLUGIN_DIR . '/rashtrotthana-admin/includes/class-form-groups-db.php';
        }

        $existing = \RADM_Form_Groups_DB::get( $id );
        if ( ! $existing ) {
            return new \WP_Error( 'not_found', 'Form group not found.', [ 'status' => 404 ] );
        }

        $body = $request->get_json_params() ?: $request->get_body_params();
        $name = sanitize_text_field( $body['name'] ?? $existing['name'] );

        try {
            \RADM_Form_Groups_DB::save( [
                'id'          => $id,
                'name'        => $name,
                'description' => isset( $body['description'] ) ? sanitize_textarea_field( $body['description'] ) : $existing['description'],
                'status'      => isset( $body['status'] ) ? sanitize_key( $body['status'] ) : $existing['status'],
                'centers'     => isset( $body['centers'] ) && is_array( $body['centers'] ) ? $body['centers'] : $existing['centers'],
            ] );

            $updated = \RADM_Form_Groups_DB::get( $id );
            return rest_ensure_response( [
                'success' => true,
                'message' => 'Form Group updated successfully.',
                'group'   => $updated,
            ] );
        } catch ( \Exception $e ) {
            return new \WP_Error( 'update_failed', $e->getMessage(), [ 'status' => 500 ] );
        }
    }

    public function delete_item( \WP_REST_Request $request ) {
        $id = absint( $request->get_param( 'id' ) );
        if ( ! class_exists( '\RADM_Form_Groups_DB' ) ) {
            require_once WP_PLUGIN_DIR . '/rashtrotthana-admin/includes/class-form-groups-db.php';
        }

        $deleted = \RADM_Form_Groups_DB::delete( $id );
        if ( ! $deleted ) {
            return new \WP_Error( 'delete_failed', 'Failed to delete form group.', [ 'status' => 500 ] );
        }

        return rest_ensure_response( [
            'success' => true,
            'message' => 'Form Group deleted successfully.',
        ] );
    }

    public function toggle_status( \WP_REST_Request $request ) {
        $id = absint( $request->get_param( 'id' ) );
        if ( ! class_exists( '\RADM_Form_Groups_DB' ) ) {
            require_once WP_PLUGIN_DIR . '/rashtrotthana-admin/includes/class-form-groups-db.php';
        }

        try {
            $new_status = \RADM_Form_Groups_DB::toggle_status( $id );
            return rest_ensure_response( [
                'success'    => true,
                'id'         => $id,
                'new_status' => $new_status,
                'message'    => 'Status updated to ' . ucfirst( $new_status ),
            ] );
        } catch ( \Exception $e ) {
            return new \WP_Error( 'toggle_failed', $e->getMessage(), [ 'status' => 500 ] );
        }
    }
}
