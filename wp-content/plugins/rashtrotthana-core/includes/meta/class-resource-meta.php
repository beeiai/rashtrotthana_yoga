<?php
namespace Rashtrotthana\Core\Meta;

class Resource_Meta {
    public function init() {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
        add_action( 'save_post', [ $this, 'save_meta_boxes' ] );
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
        $author = get_post_meta( $post->ID, '_ry_author', true );
        $external_link = get_post_meta( $post->ID, '_ry_external_link', true );

        ?>
        <p>
            <label for="ry_file_url"><strong><?php _e( 'File URL', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="url" id="ry_file_url" name="ry_file_url" value="<?php echo esc_url( $file_url ); ?>" class="large-text">
        </p>
        <p>
            <label for="ry_author"><strong><?php _e( 'Author', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="text" id="ry_author" name="ry_author" value="<?php echo esc_attr( $author ); ?>" class="regular-text">
        </p>
        <p>
            <label for="ry_external_link"><strong><?php _e( 'External Link', 'rashtrotthana-core' ); ?></strong></label><br>
            <input type="url" id="ry_external_link" name="ry_external_link" value="<?php echo esc_url( $external_link ); ?>" class="large-text">
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
        if ( isset( $_POST['ry_author'] ) ) {
            update_post_meta( $post_id, '_ry_author', sanitize_text_field( $_POST['ry_author'] ) );
        }
        if ( isset( $_POST['ry_external_link'] ) ) {
            update_post_meta( $post_id, '_ry_external_link', sanitize_url( $_POST['ry_external_link'] ) );
        }
    }
}
