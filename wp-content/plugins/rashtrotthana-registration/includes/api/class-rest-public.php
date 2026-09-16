<?php
namespace Rashtrotthana\Registration\Api;

use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Response;
use Rashtrotthana\Registration\Forms\Form_Manager;
use Rashtrotthana\Registration\Submissions\Registration_Manager;

class Rest_Public extends WP_REST_Controller {

    protected $namespace = 'ry/v1';

    public function register_routes() {
        // GET Form Details
        register_rest_route( $this->namespace, '/forms/(?P<id>\d+)', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_form' ],
                'permission_callback' => '__return_true',
                'args'                => [
                    'id' => [
                        'validate_callback' => function( $param ) {
                            return is_numeric( $param );
                        }
                    ]
                ]
            ]
        ] );

        // POST Submit Registration
        register_rest_route( $this->namespace, '/forms/(?P<id>\d+)/submit', [
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'submit_form' ],
                'permission_callback' => '__return_true',
                'args'                => [
                    'id' => [
                        'required' => true,
                        'validate_callback' => function( $param ) { return is_numeric( $param ); }
                    ],
                    'activity_id' => [
                        'required' => false,
                        'type' => 'integer'
                    ],
                    'event_id' => [
                        'required' => false,
                        'type' => 'integer'
                    ],
                    'answers' => [
                        'required' => true,
                        'type' => 'object'
                    ],
                    'language' => [
                        'required' => false,
                        'type' => 'string',
                        'default' => 'en'
                    ]
                ]
            ]
        ] );
    }

    public function get_form( $request ) {
        $form_id = (int) $request['id'];
        $form = Form_Manager::get_form( $form_id );

        if ( ! $form ) {
            return new \WP_Error( 'not_found', 'Form not found', [ 'status' => 404 ] );
        }

        // Return a clean public version
        return new WP_REST_Response( [
            'id' => $form['id'],
            'title' => $form['title'],
            'description' => $form['description'],
            'fields' => array_map( function( $f ) {
                return [
                    'key' => $f['field_key'],
                    'label' => $f['label'],
                    'type' => $f['field_type'],
                    'required' => $f['required'],
                    'options' => $f['options']
                ];
            }, $form['fields'] )
        ], 200 );
    }

    public function submit_form( $request ) {
        $form_id = (int) $request['id'];
        $activity_id = $request->get_param( 'activity_id' ) ? (int) $request->get_param( 'activity_id' ) : 0;
        $event_id = $request->get_param( 'event_id' ) ? (int) $request->get_param( 'event_id' ) : 0;
        $answers = $request->get_param( 'answers' );
        $language = $request->get_param( 'language' );

        $result = Registration_Manager::submit( $form_id, $activity_id, $event_id, $answers, $language, 'web' );

        if ( is_wp_error( $result ) ) {
            return $result;
        }

        return new WP_REST_Response( $result, 201 );
    }
}
