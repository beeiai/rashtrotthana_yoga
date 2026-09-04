<?php
namespace Rashtrotthana\Core\Integrations;

class Registration_Hooks {
    public function init() {
        // Core defines actions/filters that Registration plugin will hook into.
        
        // Shortcode to display registration button (Core can provide a placeholder or just document it)
        add_shortcode( 'ry_registration_button', [ $this, 'render_registration_button_placeholder' ] );
    }

    /**
     * Helper to check if an activity or event requires registration.
     * The Registration plugin can override or extend this via filters.
     *
     * @param int $post_id
     * @return bool
     */
    public static function requires_registration( $post_id ) {
        $requires = get_post_meta( $post_id, '_ry_requires_registration', true );
        return apply_filters( 'ry_core_requires_registration', (bool) $requires, $post_id );
    }

    /**
     * Action hook for themes/templates to display the registration form or button.
     * 
     * @param int $post_id
     */
    public static function display_registration( $post_id ) {
        /**
         * Action: ry_core_display_registration
         * Registration plugin hooks into this to render the form.
         */
        do_action( 'ry_core_display_registration', $post_id );
    }

    /**
     * Fallback shortcode for registration button in case registration plugin is inactive.
     */
    public function render_registration_button_placeholder( $atts ) {
        $atts = shortcode_atts( [
            'id' => get_the_ID(),
        ], $atts );

        if ( ! self::requires_registration( $atts['id'] ) ) {
            return '';
        }

        // Output nothing by default. The Registration plugin will override this shortcode.
        return apply_filters( 'ry_core_registration_button_html', '<!-- Registration Plugin Inactive -->', $atts['id'] );
    }
}
