<?php
namespace Rashtrotthana\Registration\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Admin_List_Table extends \WP_List_Table {

    public function __construct() {
        parent::__construct( [
            'singular' => 'registration',
            'plural'   => 'registrations',
            'ajax'     => false
        ] );
    }

    public function get_columns() {
        return [
            'cb'           => '<input type="checkbox" />',
            'name'         => __( 'Name', 'rashtrotthana-registration' ),
            'email'        => __( 'Email', 'rashtrotthana-registration' ),
            'phone'        => __( 'Phone', 'rashtrotthana-registration' ),
            'activity_id'  => __( 'Activity/Event', 'rashtrotthana-registration' ),
            'status'       => __( 'Status', 'rashtrotthana-registration' ),
            'submitted_at' => __( 'Submitted', 'rashtrotthana-registration' ),
        ];
    }

    public function get_sortable_columns() {
        return [
            'name'         => [ 'name', false ],
            'email'        => [ 'email', false ],
            'status'       => [ 'status', false ],
            'submitted_at' => [ 'submitted_at', true ],
        ];
    }

    protected function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'name':
            case 'email':
            case 'phone':
            case 'status':
            case 'submitted_at':
                return esc_html( $item[ $column_name ] );
            case 'activity_id':
                $post_id = $item['event_id'] ? $item['event_id'] : $item['activity_id'];
                if ( $post_id ) {
                    return sprintf( '<a href="%s">%s</a>', esc_url( get_edit_post_link( $post_id ) ), esc_html( get_the_title( $post_id ) ) );
                }
                return 'N/A';
            default:
                return print_r( $item, true );
        }
    }

    protected function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="registration[]" value="%s" />',
            $item['id']
        );
    }

    protected function column_name( $item ) {
        $actions = [
            'view'   => sprintf( '<a href="?page=%s&action=%s&registration=%s">View</a>', $_REQUEST['page'], 'view', $item['id'] ),
            'edit'   => sprintf( '<a href="?page=%s&action=%s&registration=%s">Edit Status</a>', $_REQUEST['page'], 'edit', $item['id'] ),
        ];

        return sprintf( '%1$s %2$s', esc_html( $item['name'] ), $this->row_actions( $actions ) );
    }

    protected function column_status( $item ) {
        $status = $item['status'];
        $class = '';
        switch( $status ) {
            case 'confirmed': $class = 'notice-success'; break;
            case 'pending': $class = 'notice-warning'; break;
            case 'waitlisted': $class = 'notice-info'; break;
            case 'cancelled':
            case 'rejected': $class = 'notice-error'; break;
        }

        return sprintf( '<span class="ry-status-badge %s" style="padding:4px 8px; border-radius:3px;">%s</span>', esc_attr( $class ), esc_html( ucfirst( $status ) ) );
    }

    public function prepare_items() {
        global $wpdb;

        $per_page = 20;
        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [ $columns, $hidden, $sortable ];

        $current_page = $this->get_pagenum();
        $offset = ( $current_page - 1 ) * $per_page;

        $orderby = ( ! empty( $_REQUEST['orderby'] ) ) ? sanitize_sql_orderby( $_REQUEST['orderby'] ) : 'submitted_at';
        $order = ( ! empty( $_REQUEST['order'] ) ) ? sanitize_sql_orderby( $_REQUEST['order'] ) : 'DESC';

        // Basic query
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM {$wpdb->prefix}ry_registrations ORDER BY $orderby $order LIMIT %d OFFSET %d";
        $data = $wpdb->get_results( $wpdb->prepare( $query, $per_page, $offset ), ARRAY_A );
        
        $total_items = $wpdb->get_var( "SELECT FOUND_ROWS()" );

        $this->items = $data;

        $this->set_pagination_args( [
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil( $total_items / $per_page )
        ] );
    }
}
