<?php
namespace Rashtrotthana\Core\Meta;

class Activity_Meta {
    public function init() {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
        add_action( 'save_post_activity', [ $this, 'save_meta_boxes' ] );
    }

    public function add_meta_boxes() {
        add_meta_box(
            'ry_activity_meta',
            __( 'Activity Details', 'rashtrotthana-core' ),
            [ $this, 'render_meta_box' ],
            'activity',
            'normal',
            'high'
        );
    }

    public function render_meta_box( $post ) {
        wp_nonce_field( 'ry_activity_meta_nonce', 'ry_activity_meta_nonce_field' );

        $duration = get_post_meta( $post->ID, '_ry_duration', true );
        $frequency = get_post_meta( $post->ID, '_ry_frequency', true );
        $instructor = get_post_meta( $post->ID, '_ry_instructor', true );
        $requires_registration = get_post_meta( $post->ID, '_ry_requires_registration', true );
        $registration_form = get_post_meta( $post->ID, '_ry_registration_form', true );
        $center = get_post_meta( $post->ID, '_ry_center', true );
        $featured = get_post_meta( $post->ID, '_ry_featured', true );

        ?>
        <p>
            <label for="ry_duration"><strong><?php _e( 'Duration', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="text" id="ry_duration" name="ry_duration" value="<?php echo esc_attr( $duration ); ?>" class="regular-text">
        </p>
        <p>
            <label for="ry_frequency"><strong><?php _e( 'Frequency', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="text" id="ry_frequency" name="ry_frequency" value="<?php echo esc_attr( $frequency ); ?>" class="regular-text">
        </p>
        <p>
            <label for="ry_instructor"><strong><?php _e( 'Instructor', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="text" id="ry_instructor" name="ry_instructor" value="<?php echo esc_attr( $instructor ); ?>" class="regular-text">
        </p>
        <p>
            <label for="ry_center"><strong><?php _e( 'Center ID', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="number" id="ry_center" name="ry_center" value="<?php echo esc_attr( $center ); ?>" class="regular-text">
        </p>
        <p>
            <label for="ry_registration_form"><strong><?php _e( 'Select Form Group (Combined Center Forms)', 'rashtrotthana-core' ); ?></strong></label><br>
            <?php
            global $wpdb;
            $fg_table = $wpdb->prefix . 'ry_form_groups';
            $form_groups = [];
            if ( $wpdb->get_var( "SHOW TABLES LIKE '$fg_table'" ) === $fg_table ) {
                $form_groups = $wpdb->get_results( "SELECT id, name, status FROM {$fg_table} ORDER BY name ASC", ARRAY_A );
            }
            ?>
            <select id="ry_registration_form" name="ry_registration_form" class="regular-text" style="width: 100%; max-width: 320px;">
                <option value="0"><?php _e( '-- No Form Group Attached --', 'rashtrotthana-core' ); ?></option>
                <?php if ( ! empty( $form_groups ) ) : ?>
                    <?php foreach ( $form_groups as $fg ) : ?>
                        <option value="<?php echo esc_attr( $fg['id'] ); ?>" <?php selected( (int) $registration_form, (int) $fg['id'] ); ?>>
                            <?php echo esc_html( $fg['name'] ); ?> (ID: <?php echo esc_html( $fg['id'] ); ?><?php echo $fg['status'] === 'inactive' ? ' - Inactive' : ''; ?>)
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php if ( $registration_form ) : ?>
                <span style="display: block; margin-top: 6px; font-size: 12px; color: #166534;">
                    🔗 <strong>Single Link:</strong> <code><?php echo esc_url( home_url( '/?ry_form_group=' . $registration_form ) ); ?></code>
                </span>
            <?php endif; ?>
        </p>
        <p>
            <label for="ry_requires_registration">
                <input type="checkbox" id="ry_requires_registration" name="ry_requires_registration" value="1" <?php checked( $requires_registration, '1' ); ?>>
                <strong><?php _e( 'Requires Registration', 'rashtrotthana-core' ); ?></strong>
            </label>
        </p>
        <p>
            <label for="ry_featured">
                <input type="checkbox" id="ry_featured" name="ry_featured" value="1" <?php checked( $featured, '1' ); ?>>
                <strong><?php _e( 'Featured Activity', 'rashtrotthana-core' ); ?></strong>
            </label>
        </p>
        <?php
    }

    public function save_meta_boxes( $post_id ) {
        if ( ! isset( $_POST['ry_activity_meta_nonce_field'] ) || ! wp_verify_nonce( $_POST['ry_activity_meta_nonce_field'], 'ry_activity_meta_nonce' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $fields = [
            'ry_duration'          => 'sanitize_text_field',
            'ry_frequency'         => 'sanitize_text_field',
            'ry_instructor'        => 'sanitize_text_field',
            'ry_center'            => 'absint',
            'ry_registration_form' => 'absint',
        ];

        foreach ( $fields as $field => $sanitizer ) {
            if ( isset( $_POST[ $field ] ) ) {
                update_post_meta( $post_id, '_' . $field, call_user_func( $sanitizer, $_POST[ $field ] ) );
            }
        }

        $requires_reg = isset( $_POST['ry_requires_registration'] ) ? '1' : '0';
        update_post_meta( $post_id, '_ry_requires_registration', $requires_reg );

        $featured = isset( $_POST['ry_featured'] ) ? '1' : '0';
        update_post_meta( $post_id, '_ry_featured', $featured );
    }
}
