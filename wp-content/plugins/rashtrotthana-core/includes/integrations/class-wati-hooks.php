<?php
namespace Rashtrotthana\Core\Integrations;

class Wati_Hooks {
    public function init() {
        // Defines core actions that WATI plugin might hook into for notifications.
        
        // Example: Trigger when a new center is created
        add_action( 'save_post_center', [ $this, 'notify_wati_on_new_center' ], 10, 3 );
    }

    public function notify_wati_on_new_center( $post_id, $post, $update ) {
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }
        
        if ( ! $update ) {
            /**
             * Action: ry_core_new_center_created
             * WATI plugin hooks into this to send notifications if necessary.
             */
            do_action( 'ry_core_new_center_created', $post_id, $post );
        }
    }

    /**
     * Generalized trigger for WATI notifications.
     */
    public static function trigger_notification( $type, $data ) {
        /**
         * Action: ry_core_trigger_notification
         * @param string $type The notification type (e.g., 'event_reminder', 'registration_success')
         * @param array $data Contextual data
         */
        do_action( 'ry_core_trigger_notification', $type, $data );
    }
}
