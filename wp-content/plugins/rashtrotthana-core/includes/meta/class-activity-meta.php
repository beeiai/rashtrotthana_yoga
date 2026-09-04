<?php
namespace Rashtrotthana\Core\Meta;

class Activity_Meta {
    public function init() {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
        add_action( 'save_post', [ $this, 'save_meta_boxes' ] );
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

        $duration = get_post_meta( $post->ID, '_ry_duration_minutes', true );
        $difficulty = get_post_meta( $post->ID, '_ry_difficulty_level', true );
        $instructor = get_post_meta( $post->ID, '_ry_instructor', true );
        $requires_registration = get_post_meta( $post->ID, '_ry_requires_registration', true );

        ?>
        <p>
            <label for="ry_duration_minutes"><strong><?php _e( 'Duration (Minutes)', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="number" id="ry_duration_minutes" name="ry_duration_minutes" value="<?php echo esc_attr( $duration ); ?>" class="regular-text">
        </p>
        <p>
            <label for="ry_difficulty_level"><strong><?php _e( 'Difficulty Level', 'rashtrotthana-core' ); ?></strong></label><br>
            <select id="ry_difficulty_level" name="ry_difficulty_level">
                <option value="beginner" <?php selected( $difficulty, 'beginner' ); ?>><?php _e( 'Beginner', 'rashtrotthana-core' ); ?></option>
                <option value="intermediate" <?php selected( $difficulty, 'intermediate' ); ?>><?php _e( 'Intermediate', 'rashtrotthana-core' ); ?></option>
                <option value="advanced" <?php selected( $difficulty, 'advanced' ); ?>><?php _e( 'Advanced', 'rashtrotthana-core' ); ?></option>
            </select>
        </p>
        <p>
            <label for="ry_instructor"><strong><?php _e( 'Instructor', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="text" id="ry_instructor" name="ry_instructor" value="<?php echo esc_attr( $instructor ); ?>" class="regular-text">
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
        if ( ! isset( $_POST['ry_activity_meta_nonce_field'] ) || ! wp_verify_nonce( $_POST['ry_activity_meta_nonce_field'], 'ry_activity_meta_nonce' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['ry_duration_minutes'] ) ) {
            update_post_meta( $post_id, '_ry_duration_minutes', sanitize_text_field( $_POST['ry_duration_minutes'] ) );
        }

        if ( isset( $_POST['ry_difficulty_level'] ) ) {
            update_post_meta( $post_id, '_ry_difficulty_level', sanitize_text_field( $_POST['ry_difficulty_level'] ) );
        }

        if ( isset( $_POST['ry_instructor'] ) ) {
            update_post_meta( $post_id, '_ry_instructor', sanitize_text_field( $_POST['ry_instructor'] ) );
        }

        $requires_reg = isset( $_POST['ry_requires_registration'] ) ? '1' : '0';
        update_post_meta( $post_id, '_ry_requires_registration', $requires_reg );
    }
}
