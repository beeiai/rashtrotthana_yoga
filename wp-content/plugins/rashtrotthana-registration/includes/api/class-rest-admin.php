<?php
namespace Rashtrotthana\Registration\Api;

use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Response;
use Rashtrotthana\Registration\Submissions\Registration_Manager;

class Rest_Admin extends WP_REST_Controller {

    protected $namespace = 'ry/v1';

    public function register_routes() {
        // GET Registrations List
        register_rest_route( $this->namespace, '/admin/registrations', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_registrations' ],
                'permission_callback' => [ $this, 'permissions_check' ],
                'args'                => [
                    'page'     => [ 'type' => 'integer', 'default' => 1 ],
                    'per_page' => [ 'type' => 'integer', 'default' => 50 ],
                    'event_id' => [ 'type' => 'integer' ],
                    'status'   => [ 'type' => 'string' ],
                ]
            ]
        ] );

        // POST Update Status
        register_rest_route( $this->namespace, '/admin/registrations/(?P<id>\d+)/status', [
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'update_status' ],
                'permission_callback' => [ $this, 'permissions_check' ],
                'args'                => [
                    'status' => [
                        'required' => true,
                        'type' => 'string'
                    ]
                ]
            ]
        ] );
    }

    public function permissions_check() {
        return current_user_can( 'manage_ry_registrations' );
    }

    public function get_registrations( $request ) {
        global $wpdb;

        $page = $request->get_param('page');
        $per_page = $request->get_param('per_page');
        $offset = ( $page - 1 ) * $per_page;

        $where = "1=1";
        $args = [];

        if ( $request->get_param('event_id') ) {
            $where .= " AND (event_id = %d OR activity_id = %d)";
            $args[] = $request->get_param('event_id');
            $args[] = $request->get_param('event_id');
        }

        if ( $request->get_param('status') ) {
            $where .= " AND status = %s";
            $args[] = $request->get_param('status');
        }

        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM {$wpdb->prefix}ry_registrations WHERE $where ORDER BY submitted_at DESC LIMIT %d OFFSET %d";
        
        $args[] = $per_page;
        $args[] = $offset;

        $results = $wpdb->get_results( $wpdb->prepare( $query, $args ), ARRAY_A );
        $total = $wpdb->get_var( "SELECT FOUND_ROWS()" );

        $response = new WP_REST_Response( [
            'items' => $results,
            'pagination' => [
                'page' => $page,
                'per_page' => $per_page,
                'total' => (int) $total
            ]
        ], 200 );

        return $response;
    }

    public function update_status( $request ) {
        $registration_id = (int) $request['id'];
        $status = $request->get_param('status');

        $result = Registration_Manager::update_status( $registration_id, $status );

        if ( is_wp_error( $result ) ) {
            return $result;
        }

        if ( ! $result ) {
            return new \WP_Error( 'update_failed', 'Failed to update registration status.', [ 'status' => 500 ] );
        }

        return new WP_REST_Response( [ 'success' => true ], 200 );
    }
}
