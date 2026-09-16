<?php
namespace Rashtrotthana\Registration\Integrations;

class Wati_Events {
    
    public function init() {
        // Documenting the hook signatures for the WATI Developer.
        // The WATI plugin should hook into these to send WhatsApp messages.
        
        // do_action( 'rashtrotthana_registration_created', int $registration_id, string $status, string $uuid );
        // do_action( 'rashtrotthana_registration_confirmed', int $registration_id, string $uuid );
        // do_action( 'rashtrotthana_registration_waitlisted', int $registration_id, string $uuid );
        // do_action( 'rashtrotthana_registration_status_changed', int $registration_id, string $new_status, string $old_status );
        // do_action( 'rashtrotthana_registration_cancelled', int $registration_id, string $uuid );
    }
}
