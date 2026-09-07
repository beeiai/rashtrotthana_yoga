<?php
namespace Rashtrotthana\Core\Meta;

class Resource_Meta {
    public function init() {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
        add_action( 'save_post_resource', [ $this, 'save_meta_boxes' ] );
    }

    public function add_meta_boxes() {
        add_meta_box(
            'ry_resource_meta',
            __( 'Resource Details', 'rashtrotthana-core' ),
            [ $this, 'render_meta_box' ],
            'resource',
            'normal',
            'high'
        );
    }

    public function render_meta_box( $post ) {
        wp_nonce_field( 'ry_resource_meta_nonce', 'ry_resource_meta_nonce_field' );

        $file_url = get_post_meta( $post->ID, '_ry_file_url', true );
        $external_link = get_post_meta( $post->ID, '_ry_external_link', true );
        $pub_date = get_post_meta( $post->ID, '_ry_publication_date', true );
        $featured = get_post_meta( $post->ID, '_ry_featured', true );

        ?>
        <p>
            <label for="ry_file_url"><strong><?php _e( 'Attached File URL', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="url" id="ry_file_url" name="ry_file_url" value="<?php echo esc_url( $file_url ); ?>" class="large-text">
        </p>
        <p>
            <label for="ry_external_link"><strong><?php _e( 'External Link URL', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="url" id="ry_external_link" name="ry_external_link" value="<?php echo esc_url( $external_link ); ?>" class="large-text">
        </p>
        <p>
            <label for="ry_publication_date"><strong><?php _e( 'Publication Date', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="date" id="ry_publication_date" name="ry_publication_date" value="<?php echo esc_attr( $pub_date ); ?>" class="regular-text">
        </p>
        <p>
            <label for="ry_featured">
                <input type="checkbox" id="ry_featured" name="ry_featured" value="1" <?php checked( $featured, '1' ); ?>>
                <strong><?php _e( 'Featured Resource', 'rashtrotthana-core' ); ?></strong>
            </label>
        </p>
        <?php
    }

    public function save_meta_boxes( $post_id ) {
        if ( ! isset( $_POST['ry_resource_meta_nonce_field'] ) || ! wp_verify_nonce( $_POST['ry_resource_meta_nonce_field'], 'ry_resource_meta_nonce' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['ry_file_url'] ) ) {
            update_post_meta( $post_id, '_ry_file_url', sanitize_url( $_POST['ry_file_url'] ) );
        }
        if ( isset( $_POST['ry_external_link'] ) ) {
            update_post_meta( $post_id, '_ry_external_link', sanitize_url( $_POST['ry_external_link'] ) );
        }
        if ( isset( $_POST['ry_publication_date'] ) ) {
            update_post_meta( $post_id, '_ry_publication_date', sanitize_text_field( $_POST['ry_publication_date'] ) );
        }

        $featured = isset( $_POST['ry_featured'] ) ? '1' : '0';
        update_post_meta( $post_id, '_ry_featured', $featured );
    }
}
