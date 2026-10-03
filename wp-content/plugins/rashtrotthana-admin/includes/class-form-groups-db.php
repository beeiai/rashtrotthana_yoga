<?php
/**
 * Database Schema and Data Access Layer for Form Groups
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class RADM_Form_Groups_DB {

    public static function get_table_name_groups(): string {
        global $wpdb;
        return $wpdb->prefix . 'ry_form_groups';
    }

    public static function get_table_name_centers(): string {
        global $wpdb;
        return $wpdb->prefix . 'ry_form_group_centers';
    }

    /**
     * Create or update the database tables using dbDelta
     */
    public static function install_tables(): void {
        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $charset_collate = $wpdb->get_charset_collate();
        $table_groups    = self::get_table_name_groups();
        $table_centers   = self::get_table_name_centers();

        $sql_groups = "CREATE TABLE {$table_groups} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            description TEXT NULL,
            status VARCHAR(20) NOT NULL DEFAULT 'active',
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY status_idx (status),
            KEY created_idx (created_at)
        ) {$charset_collate};";

        $sql_centers = "CREATE TABLE {$table_centers} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            form_group_id BIGINT(20) UNSIGNED NOT NULL,
            center_name VARCHAR(255) NOT NULL,
            form_url TEXT NOT NULL,
            display_order INT(11) NOT NULL DEFAULT 0,
            PRIMARY KEY (id),
            KEY form_group_idx (form_group_id)
        ) {$charset_collate};";

        dbDelta( $sql_groups );
        dbDelta( $sql_centers );
    }

    /**
     * Get all Form Groups with centers and counts
     */
    public static function get_all( array $args = [] ): array {
        global $wpdb;
        self::ensure_tables_exist();

        $table_groups  = self::get_table_name_groups();
        $table_centers = self::get_table_name_centers();

        $search   = sanitize_text_field( $args['search'] ?? '' );
        $status   = sanitize_key( $args['status'] ?? '' );
        $page     = max( 1, absint( $args['page'] ?? 1 ) );
        $per_page = max( 1, absint( $args['per_page'] ?? 10 ) );
        $offset   = ( $page - 1 ) * $per_page;

        $where_clauses = [ '1=1' ];
        $params        = [];

        if ( ! empty( $status ) && in_array( $status, [ 'active', 'inactive' ], true ) ) {
            $where_clauses[] = 'g.status = %s';
            $params[]        = $status;
        }

        if ( ! empty( $search ) ) {
            $like = '%' . $wpdb->esc_like( $search ) . '%';
            $where_clauses[] = '(g.name LIKE %s OR g.description LIKE %s)';
            $params[]        = $like;
            $params[]        = $like;
        }

        $where_sql = implode( ' AND ', $where_clauses );

        // Count total
        $count_query = "SELECT COUNT(g.id) FROM {$table_groups} g WHERE {$where_sql}";
        $total = empty( $params )
            ? (int) $wpdb->get_var( $count_query )
            : (int) $wpdb->get_var( $wpdb->prepare( $count_query, $params ) );

        // Fetch groups
        $data_query = "SELECT g.* FROM {$table_groups} g WHERE {$where_sql} ORDER BY g.id DESC LIMIT %d OFFSET %d";
        $fetch_params = array_merge( $params, [ $per_page, $offset ] );
        $groups = $wpdb->get_results( $wpdb->prepare( $data_query, $fetch_params ), ARRAY_A );

        if ( empty( $groups ) ) {
            return [
                'items'       => [],
                'total'       => 0,
                'page'        => $page,
                'per_page'    => $per_page,
                'total_pages' => 0,
            ];
        }

        // Fetch centers for all returned groups
        $group_ids = array_map( 'intval', wp_list_pluck( $groups, 'id' ) );
        $ids_placeholder = implode( ',', $group_ids );
        $centers = $wpdb->get_results(
            "SELECT * FROM {$table_centers} WHERE form_group_id IN ({$ids_placeholder}) ORDER BY display_order ASC, id ASC",
            ARRAY_A
        );

        $centers_by_group = [];
        foreach ( $centers as $c ) {
            $gid = (int) $c['form_group_id'];
            if ( ! isset( $centers_by_group[ $gid ] ) ) {
                $centers_by_group[ $gid ] = [];
            }
            $centers_by_group[ $gid ][] = [
                'id'            => (int) $c['id'],
                'center_name'   => $c['center_name'],
                'form_url'      => $c['form_url'],
                'display_order' => (int) $c['display_order'],
            ];
        }

        $items = [];
        foreach ( $groups as $g ) {
            $gid = (int) $g['id'];
            $g_centers = $centers_by_group[ $gid ] ?? [];
            $center_names = wp_list_pluck( $g_centers, 'center_name' );

            $items[] = [
                'id'            => $gid,
                'name'          => $g['name'],
                'description'   => $g['description'] ?? '',
                'status'        => $g['status'],
                'created_at'    => $g['created_at'],
                'created_fmt'   => date_i18n( 'd M Y', strtotime( $g['created_at'] ) ),
                'updated_at'    => $g['updated_at'],
                'total_centers' => count( $g_centers ),
                'centers'       => $g_centers,
                'center_names'  => $center_names,
            ];
        }

        return [
            'items'       => $items,
            'total'       => $total,
            'page'        => $page,
            'per_page'    => $per_page,
            'total_pages' => ceil( $total / $per_page ),
        ];
    }

    /**
     * Get a single Form Group by ID
     */
    public static function get( int $id ): ?array {
        global $wpdb;
        self::ensure_tables_exist();

        $table_groups  = self::get_table_name_groups();
        $table_centers = self::get_table_name_centers();

        $group = $wpdb->get_row(
            $wpdb->prepare( "SELECT * FROM {$table_groups} WHERE id = %d", $id ),
            ARRAY_A
        );

        if ( ! $group ) {
            return null;
        }

        $centers = $wpdb->get_results(
            $wpdb->prepare( "SELECT * FROM {$table_centers} WHERE form_group_id = %d ORDER BY display_order ASC, id ASC", $id ),
            ARRAY_A
        );

        $formatted_centers = [];
        foreach ( $centers as $c ) {
            $formatted_centers[] = [
                'id'            => (int) $c['id'],
                'center_name'   => $c['center_name'],
                'form_url'      => $c['form_url'],
                'display_order' => (int) $c['display_order'],
            ];
        }

        return [
            'id'            => (int) $group['id'],
            'name'          => $group['name'],
            'description'   => $group['description'] ?? '',
            'status'        => $group['status'],
            'created_at'    => $group['created_at'],
            'created_fmt'   => date_i18n( 'd M Y', strtotime( $group['created_at'] ) ),
            'updated_at'    => $group['updated_at'],
            'total_centers' => count( $formatted_centers ),
            'centers'       => $formatted_centers,
            'center_names'  => wp_list_pluck( $formatted_centers, 'center_name' ),
        ];
    }

    /**
     * Save (Create or Update) a Form Group and its Centers
     */
    public static function save( array $data ): int {
        global $wpdb;
        self::ensure_tables_exist();

        $table_groups  = self::get_table_name_groups();
        $table_centers = self::get_table_name_centers();

        $id          = absint( $data['id'] ?? 0 );
        $name        = sanitize_text_field( $data['name'] ?? '' );
        $description = sanitize_textarea_field( $data['description'] ?? '' );
        $status      = in_array( $data['status'] ?? 'active', [ 'active', 'inactive' ], true ) ? $data['status'] : 'active';
        $centers     = is_array( $data['centers'] ?? null ) ? $data['centers'] : [];

        if ( empty( $name ) ) {
            throw new \Exception( 'Form Group Name is required.' );
        }

        if ( $id > 0 ) {
            // Update
            $wpdb->update(
                $table_groups,
                [
                    'name'        => $name,
                    'description' => $description,
                    'status'      => $status,
                    'updated_at'  => current_time( 'mysql' ),
                ],
                [ 'id' => $id ],
                [ '%s', '%s', '%s', '%s' ],
                [ '%d' ]
            );
            $group_id = $id;
        } else {
            // Insert
            $wpdb->insert(
                $table_groups,
                [
                    'name'        => $name,
                    'description' => $description,
                    'status'      => $status,
                    'created_at'  => current_time( 'mysql' ),
                    'updated_at'  => current_time( 'mysql' ),
                ],
                [ '%s', '%s', '%s', '%s', '%s' ]
            );
            $group_id = (int) $wpdb->insert_id;
        }

        // Replace centers
        $wpdb->delete( $table_centers, [ 'form_group_id' => $group_id ], [ '%d' ] );

        $order = 1;
        foreach ( $centers as $c ) {
            $c_name = sanitize_text_field( $c['center_name'] ?? $c['name'] ?? '' );
            $c_url  = esc_url_raw( $c['form_url'] ?? $c['url'] ?? '' );

            if ( ! empty( $c_name ) && ! empty( $c_url ) ) {
                $wpdb->insert(
                    $table_centers,
                    [
                        'form_group_id' => $group_id,
                        'center_name'   => $c_name,
                        'form_url'      => $c_url,
                        'display_order' => $order++,
                    ],
                    [ '%d', '%s', '%s', '%d' ]
                );
            }
        }

        return $group_id;
    }

    /**
     * Delete Form Group and all its centers
     */
    public static function delete( int $id ): bool {
        global $wpdb;
        self::ensure_tables_exist();

        $table_groups  = self::get_table_name_groups();
        $table_centers = self::get_table_name_centers();

        $wpdb->delete( $table_centers, [ 'form_group_id' => $id ], [ '%d' ] );
        $deleted = $wpdb->delete( $table_groups, [ 'id' => $id ], [ '%d' ] );

        return (bool) $deleted;
    }

    /**
     * Toggle status (active <-> inactive)
     */
    public static function toggle_status( int $id ): string {
        global $wpdb;
        self::ensure_tables_exist();

        $table_groups = self::get_table_name_groups();
        $current = $wpdb->get_var( $wpdb->prepare( "SELECT status FROM {$table_groups} WHERE id = %d", $id ) );

        if ( ! $current ) {
            throw new \Exception( 'Form Group not found.' );
        }

        $new_status = ( $current === 'active' ) ? 'inactive' : 'active';
        $wpdb->update(
            $table_groups,
            [ 'status' => $new_status, 'updated_at' => current_time( 'mysql' ) ],
            [ 'id' => $id ],
            [ '%s', '%s' ],
            [ '%d' ]
        );

        return $new_status;
    }

    /**
     * Ensure database tables exist
     */
    public static function ensure_tables_exist(): void {
        global $wpdb;
        static $checked = false;
        if ( $checked ) return;

        $table = self::get_table_name_groups();
        if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table}'" ) !== $table ) {
            self::install_tables();
        }
        $checked = true;
    }
}
