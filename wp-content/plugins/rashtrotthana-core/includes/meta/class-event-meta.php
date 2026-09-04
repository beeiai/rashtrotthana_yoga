<?php
namespace Rashtrotthana\Core\Meta;

class Event_Meta {
    public function init() {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
        add_action( 'save_post', [ $this, 'save_meta_boxes' ] );
    }

    public function add_meta_boxes() {
        add_meta_box(
            'ry_event_meta',
            __( 'Event Details', 'rashtrotthana-core' ),
            [ $this, 'render_meta_box' ],
            'event',
            'normal',
            'high'
        );
    }

    public function render_meta_box( $post ) {
        wp_nonce_field( 'ry_event_meta_nonce', 'ry_event_meta_nonce_field' );

        $start_date = get_post_meta( $post->ID, '_ry_start_date', true );
        $end_date = get_post_meta( $post->ID, '_ry_end_date', true );
        $start_time = get_post_meta( $post->ID, '_ry_start_time', true );
        $end_time = get_post_meta( $post->ID, '_ry_end_time', true );
        $venue = get_post_meta( $post->ID, '_ry_venue', true );
        $requires_registration = get_post_meta( $post->ID, '_ry_requires_registration', true );

        ?>
        <div style="display: flex; gap: 20px;">
            <p>
                <label for="ry_start_date"><strong><?php _e( 'Start Date', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="date" id="ry_start_date" name="ry_start_date" value="<?php echo esc_attr( $start_date ); ?>" class="regular-text">
            </p>
            <p>
                <label for="ry_end_date"><strong><?php _e( 'End Date', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="date" id="ry_end_date" name="ry_end_date" value="<?php echo esc_attr( $end_date ); ?>" class="regular-text">
            </p>
        </div>
        <div style="display: flex; gap: 20px;">
            <p>
                <label for="ry_start_time"><strong><?php _e( 'Start Time', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="time" id="ry_start_time" name="ry_start_time" value="<?php echo esc_attr( $start_time ); ?>" class="regular-text">
            </p>
            <p>
                <label for="ry_end_time"><strong><?php _e( 'End Time', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="time" id="ry_end_time" name="ry_end_time" value="<?php echo esc_attr( $end_time ); ?>" class="regular-text">
            </p>
        </div>
        <p>
            <label for="ry_venue"><strong><?php _e( 'Venue', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="text" id="ry_venue" name="ry_venue" value="<?php echo esc_attr( $venue ); ?>" class="large-text">
        </p>
        <p>
            <label for="ry_requires_registration">
                <input type="checkbox" id="ry_requires_registration" name="ry_requires_registration" value="1" <?php checked( $requires_registration, '1' ); ?>>
                <strong><?php _e( 'Requires Registration', 'rashtrotthana-core' ); ?></strong>
            </label>
        </p>
        <?php
    }

    public function save_meta_boxes( $post_id ) {
        if ( ! isset( $_POST['ry_event_meta_nonce_field'] ) || ! wp_verify_nonce( $_POST['ry_event_meta_nonce_field'], 'ry_event_meta_nonce' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $fields = [
            'ry_start_date' => 'sanitize_text_field',
            'ry_end_date'   => 'sanitize_text_field',
            'ry_start_time' => 'sanitize_text_field',
            'ry_end_time'   => 'sanitize_text_field',
            'ry_venue'      => 'sanitize_text_field',
        ];

        foreach ( $fields as $field => $sanitizer ) {
            if ( isset( $_POST[ $field ] ) ) {
                update_post_meta( $post_id, '_' . $field, call_user_func( $sanitizer, $_POST[ $field ] ) );
            }
        }

        $requires_reg = isset( $_POST['ry_requires_registration'] ) ? '1' : '0';
        update_post_meta( $post_id, '_ry_requires_registration', $requires_reg );
    }
}
