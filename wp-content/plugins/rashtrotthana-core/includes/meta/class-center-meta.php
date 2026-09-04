<?php
namespace Rashtrotthana\Core\Meta;

class Center_Meta {
    public function init() {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
        add_action( 'save_post', [ $this, 'save_meta_boxes' ] );
    }

    public function add_meta_boxes() {
        add_meta_box(
            'ry_center_meta',
            __( 'Center Details', 'rashtrotthana-core' ),
            [ $this, 'render_meta_box' ],
            'center',
            'normal',
            'high'
        );
    }

    public function render_meta_box( $post ) {
        wp_nonce_field( 'ry_center_meta_nonce', 'ry_center_meta_nonce_field' );

        $address = get_post_meta( $post->ID, '_ry_address', true );
        $city = get_post_meta( $post->ID, '_ry_city', true );
        $state = get_post_meta( $post->ID, '_ry_state', true );
        $pincode = get_post_meta( $post->ID, '_ry_pincode', true );
        $phone = get_post_meta( $post->ID, '_ry_phone', true );
        $email = get_post_meta( $post->ID, '_ry_email', true );
        $lat = get_post_meta( $post->ID, '_ry_location_lat', true );
        $lng = get_post_meta( $post->ID, '_ry_location_lng', true );

        ?>
        <p>
            <label for="ry_address"><strong><?php _e( 'Address', 'rashtrotthana-core' ); ?></strong></label><br>
            <textarea id="ry_address" name="ry_address" class="large-text" rows="3"><?php echo esc_textarea( $address ); ?></textarea>
        </p>
        <div style="display: flex; gap: 20px;">
            <p>
                <label for="ry_city"><strong><?php _e( 'City', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="text" id="ry_city" name="ry_city" value="<?php echo esc_attr( $city ); ?>" class="regular-text">
            </p>
            <p>
                <label for="ry_state"><strong><?php _e( 'State', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="text" id="ry_state" name="ry_state" value="<?php echo esc_attr( $state ); ?>" class="regular-text">
            </p>
            <p>
                <label for="ry_pincode"><strong><?php _e( 'Pincode', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="text" id="ry_pincode" name="ry_pincode" value="<?php echo esc_attr( $pincode ); ?>" class="regular-text">
            </p>
        </div>
        <div style="display: flex; gap: 20px;">
            <p>
                <label for="ry_phone"><strong><?php _e( 'Phone', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="text" id="ry_phone" name="ry_phone" value="<?php echo esc_attr( $phone ); ?>" class="regular-text">
            </p>
            <p>
                <label for="ry_email"><strong><?php _e( 'Email', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="email" id="ry_email" name="ry_email" value="<?php echo esc_attr( $email ); ?>" class="regular-text">
            </p>
        </div>
        <hr>
        <h4><?php _e( 'Map Coordinates', 'rashtrotthana-core' ); ?></h4>
        <div style="display: flex; gap: 20px;">
            <p>
                <label for="ry_location_lat"><strong><?php _e( 'Latitude', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="text" id="ry_location_lat" name="ry_location_lat" value="<?php echo esc_attr( $lat ); ?>" class="regular-text">
            </p>
            <p>
                <label for="ry_location_lng"><strong><?php _e( 'Longitude', 'rashtrotthana-core' ); ?></strong></label><br>
                <input type="text" id="ry_location_lng" name="ry_location_lng" value="<?php echo esc_attr( $lng ); ?>" class="regular-text">
            </p>
        </div>
        <?php
    }

    public function save_meta_boxes( $post_id ) {
        if ( ! isset( $_POST['ry_center_meta_nonce_field'] ) || ! wp_verify_nonce( $_POST['ry_center_meta_nonce_field'], 'ry_center_meta_nonce' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $fields = [
            'ry_address'       => 'sanitize_textarea_field',
            'ry_city'          => 'sanitize_text_field',
            'ry_state'         => 'sanitize_text_field',
            'ry_pincode'       => 'sanitize_text_field',
            'ry_phone'         => 'sanitize_text_field',
            'ry_email'         => 'sanitize_email',
            'ry_location_lat'  => 'sanitize_text_field',
            'ry_location_lng'  => 'sanitize_text_field',
        ];

        foreach ( $fields as $field => $sanitizer ) {
            if ( isset( $_POST[ $field ] ) ) {
                update_post_meta( $post_id, '_' . $field, call_user_func( $sanitizer, $_POST[ $field ] ) );
            }
        }
    }
}
