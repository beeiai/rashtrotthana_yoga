<?php
namespace Rashtrotthana\Core\Meta;

class Event_Meta {
    public function init() {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
        add_action( 'save_post_event', [ $this, 'save_meta_boxes' ] );
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
        $center = get_post_meta( $post->ID, '_ry_center', true );
        $requires_registration = get_post_meta( $post->ID, '_ry_requires_registration', true );
        $registration_form = get_post_meta( $post->ID, '_ry_registration_form', true );
        $max_participants = get_post_meta( $post->ID, '_ry_maximum_participants', true );
        $reg_start = get_post_meta( $post->ID, '_ry_registration_start', true );
        $reg_end = get_post_meta( $post->ID, '_ry_registration_end', true );
        $featured = get_post_meta( $post->ID, '_ry_featured', true );

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
        <div style="display: flex; gap: 20px;">
            <p>
                <label for="ry_venue"><strong><?php _e( 'Venue', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="text" id="ry_venue" name="ry_venue" value="<?php echo esc_attr( $venue ); ?>" class="regular-text">
            </p>
            <p>
                <label for="ry_center"><strong><?php _e( 'Center ID', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="number" id="ry_center" name="ry_center" value="<?php echo esc_attr( $center ); ?>" class="regular-text">
            </p>
        </div>
        <hr>
        <h4>Registration</h4>
        <p>
            <label for="ry_requires_registration">
                <input type="checkbox" id="ry_requires_registration" name="ry_requires_registration" value="1" <?php checked( $requires_registration, '1' ); ?>>
                <strong><?php _e( 'Requires Registration', 'rashtrotthana-core' ); ?></strong>
            </label>
        </p>
        <div style="display: flex; gap: 20px;">
            <p>
                <label for="ry_registration_form"><strong><?php _e( 'Registration Form ID', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="number" id="ry_registration_form" name="ry_registration_form" value="<?php echo esc_attr( $registration_form ); ?>" class="regular-text">
            </p>
            <p>
                <label for="ry_maximum_participants"><strong><?php _e( 'Maximum Participants', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="number" id="ry_maximum_participants" name="ry_maximum_participants" value="<?php echo esc_attr( $max_participants ); ?>" class="regular-text">
            </p>
        </div>
        <div style="display: flex; gap: 20px;">
            <p>
                <label for="ry_registration_start"><strong><?php _e( 'Registration Start (YYYY-MM-DD HH:MM)', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="datetime-local" id="ry_registration_start" name="ry_registration_start" value="<?php echo esc_attr( $reg_start ); ?>" class="regular-text">
            </p>
            <p>
                <label for="ry_registration_end"><strong><?php _e( 'Registration End (YYYY-MM-DD HH:MM)', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="datetime-local" id="ry_registration_end" name="ry_registration_end" value="<?php echo esc_attr( $reg_end ); ?>" class="regular-text">
            </p>
        </div>
        <p>
            <label for="ry_featured">
                <input type="checkbox" id="ry_featured" name="ry_featured" value="1" <?php checked( $featured, '1' ); ?>>
                <strong><?php _e( 'Featured Event', 'rashtrotthana-core' ); ?></strong>
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
            'ry_start_date'            => 'sanitize_text_field',
            'ry_end_date'              => 'sanitize_text_field',
            'ry_start_time'            => 'sanitize_text_field',
            'ry_end_time'              => 'sanitize_text_field',
            'ry_venue'                 => 'sanitize_text_field',
            'ry_center'                => 'absint',
            'ry_registration_form'     => 'absint',
            'ry_maximum_participants'  => 'absint',
            'ry_registration_start'    => 'sanitize_text_field',
            'ry_registration_end'      => 'sanitize_text_field',
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
