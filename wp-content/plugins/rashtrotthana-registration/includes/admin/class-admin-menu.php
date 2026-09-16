<?php
namespace Rashtrotthana\Registration\Admin;

use Rashtrotthana\Registration\Submissions\Registration_Manager;

class Admin_Menu {

    public function init() {
        add_action( 'admin_menu', [ $this, 'add_menu_pages' ] );
        add_action( 'admin_init', [ $this, 'process_actions' ] );
    }

    public function add_menu_pages() {
        add_menu_page(
            __( 'Registrations', 'rashtrotthana-registration' ),
            __( 'Registrations', 'rashtrotthana-registration' ),
            'manage_ry_registrations',
            'ry-registrations',
            [ $this, 'render_registrations_page' ],
            'dashicons-clipboard',
            30
        );
    }

    public function render_registrations_page() {
        $action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';

        echo '<div class="wrap">';
        echo '<h1 class="wp-heading-inline">' . esc_html__( 'Registrations', 'rashtrotthana-registration' ) . '</h1>';

        if ( $action === 'view' && isset( $_GET['registration'] ) ) {
            $this->render_view_page( (int) $_GET['registration'] );
        } elseif ( $action === 'edit' && isset( $_GET['registration'] ) ) {
            $this->render_edit_page( (int) $_GET['registration'] );
        } else {
            $this->render_list_page();
        }

        echo '</div>';
    }

    private function render_list_page() {
        require_once RY_REGISTRATION_PLUGIN_DIR . 'includes/admin/class-admin-list-table.php';
        
        $list_table = new Admin_List_Table();
        $list_table->prepare_items();
        
        echo '<form method="get">';
        echo '<input type="hidden" name="page" value="ry-registrations" />';
        $list_table->search_box( __( 'Search Registrations', 'rashtrotthana-registration' ), 'search_id' );
        $list_table->display();
        echo '</form>';
    }

    private function render_view_page( $registration_id ) {
        global $wpdb;

        $registration = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ry_registrations WHERE id = %d", $registration_id ) );
        if ( ! $registration ) {
            echo '<p>' . esc_html__( 'Registration not found.', 'rashtrotthana-registration' ) . '</p>';
            return;
        }

        $answers = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ry_registration_answers WHERE registration_id = %d", $registration_id ) );

        echo '<h2>' . esc_html__( 'Registration Details', 'rashtrotthana-registration' ) . '</h2>';
        echo '<table class="form-table" role="presentation">';
        echo '<tbody>';
        echo '<tr><th scope="row">' . esc_html__( 'Name', 'rashtrotthana-registration' ) . '</th><td>' . esc_html( $registration->name ) . '</td></tr>';
        echo '<tr><th scope="row">' . esc_html__( 'Email', 'rashtrotthana-registration' ) . '</th><td>' . esc_html( $registration->email ) . '</td></tr>';
        echo '<tr><th scope="row">' . esc_html__( 'Phone', 'rashtrotthana-registration' ) . '</th><td>' . esc_html( $registration->phone ) . '</td></tr>';
        echo '<tr><th scope="row">' . esc_html__( 'Status', 'rashtrotthana-registration' ) . '</th><td><strong>' . esc_html( ucfirst( $registration->status ) ) . '</strong></td></tr>';
        echo '</tbody></table>';

        echo '<h3>' . esc_html__( 'Form Answers', 'rashtrotthana-registration' ) . '</h3>';
        echo '<table class="form-table" role="presentation"><tbody>';
        foreach ( $answers as $answer ) {
            echo '<tr><th scope="row">' . esc_html( $answer->field_key ) . '</th><td>' . esc_html( $answer->field_value ) . '</td></tr>';
        }
        echo '</tbody></table>';

        echo '<p><a href="?page=ry-registrations" class="button">' . esc_html__( 'Back to List', 'rashtrotthana-registration' ) . '</a></p>';
    }

    private function render_edit_page( $registration_id ) {
        global $wpdb;

        $registration = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ry_registrations WHERE id = %d", $registration_id ) );
        if ( ! $registration ) {
            echo '<p>' . esc_html__( 'Registration not found.', 'rashtrotthana-registration' ) . '</p>';
            return;
        }

        echo '<h2>' . esc_html__( 'Edit Registration Status', 'rashtrotthana-registration' ) . '</h2>';
        echo '<form method="post" action="">';
        wp_nonce_field( 'ry_edit_registration_status', 'ry_nonce' );
        echo '<input type="hidden" name="action" value="ry_update_status" />';
        echo '<input type="hidden" name="registration_id" value="' . esc_attr( $registration_id ) . '" />';
        
        echo '<table class="form-table" role="presentation"><tbody>';
        echo '<tr><th scope="row"><label for="status">' . esc_html__( 'Status', 'rashtrotthana-registration' ) . '</label></th>';
        echo '<td><select name="status" id="status">';
        
        $statuses = [ 'pending', 'confirmed', 'waitlisted', 'cancelled', 'rejected', 'completed' ];
        foreach ( $statuses as $s ) {
            echo '<option value="' . esc_attr( $s ) . '" ' . selected( $registration->status, $s, false ) . '>' . esc_html( ucfirst( $s ) ) . '</option>';
        }
        
        echo '</select></td></tr>';
        echo '</tbody></table>';
        
        submit_button( __( 'Update Status', 'rashtrotthana-registration' ) );
        echo '</form>';
        echo '<p><a href="?page=ry-registrations">' . esc_html__( 'Back to List', 'rashtrotthana-registration' ) . '</a></p>';
    }

    public function process_actions() {
        if ( isset( $_POST['action'] ) && $_POST['action'] === 'ry_update_status' ) {
            if ( ! isset( $_POST['ry_nonce'] ) || ! wp_verify_nonce( $_POST['ry_nonce'], 'ry_edit_registration_status' ) ) {
                wp_die( __( 'Invalid nonce specified', 'rashtrotthana-registration' ), __( 'Error', 'rashtrotthana-registration' ), [ 'response' => 403 ] );
            }

            if ( ! current_user_can( 'manage_ry_registrations' ) ) {
                wp_die( __( 'Insufficient permissions', 'rashtrotthana-registration' ), __( 'Error', 'rashtrotthana-registration' ), [ 'response' => 403 ] );
            }

            $registration_id = (int) $_POST['registration_id'];
            $status = sanitize_text_field( $_POST['status'] );

            Registration_Manager::update_status( $registration_id, $status );

            wp_redirect( add_query_arg( [ 'page' => 'ry-registrations', 'updated' => 'true' ], admin_url( 'admin.php' ) ) );
            exit;
        }
    }
}
