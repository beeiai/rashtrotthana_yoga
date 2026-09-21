<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Verify capabilities
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( 'You do not have sufficient permissions to access this page.' );
}

// Handle Form Submission
$message = '';
if ( isset( $_POST['radm_save_settings'] ) ) {
    if ( ! check_admin_referer( 'radm_save_settings_action', 'radm_save_settings_nonce' ) ) {
        wp_die( 'Security check failed.' );
    }

    // General Settings
    update_option( 'blogname', sanitize_text_field( $_POST['blogname'] ?? '' ) );
    update_option( 'blogdescription', sanitize_text_field( $_POST['blogdescription'] ?? '' ) );
    update_option( 'admin_email', sanitize_email( $_POST['admin_email'] ?? '' ) );

    // Contact Information
    update_option( 'radm_contact_phone', sanitize_text_field( $_POST['radm_contact_phone'] ?? '' ) );
    update_option( 'radm_contact_email', sanitize_email( $_POST['radm_contact_email'] ?? '' ) );
    update_option( 'radm_contact_address', sanitize_textarea_field( $_POST['radm_contact_address'] ?? '' ) );

    // Integration Settings
    update_option( 'wati_api_base_url', esc_url_raw( $_POST['wati_api_base_url'] ?? '' ) );
    update_option( 'wati_access_token', sanitize_text_field( $_POST['wati_access_token'] ?? '' ) );
    update_option( 'ry_ai_api_key', sanitize_text_field( $_POST['ry_ai_api_key'] ?? '' ) );

    // Notifications
    update_option( 'radm_notify_email_active', isset( $_POST['radm_notify_email_active'] ) ? '1' : '0' );
    update_option( 'radm_notify_sms_active', isset( $_POST['radm_notify_sms_active'] ) ? '1' : '0' );

    $message = '<div class="radm-toast radm-toast--success radm-toast-show">Settings saved successfully.</div>';
}

radm_portal_header( 'Settings', 'Configure your site and portal preferences' );
echo $message;
?>

<div class="radm-card">
    <div class="radm-card-header">
        <h2>System Configuration</h2>
    </div>

    <form method="post" action="">
        <?php wp_nonce_field( 'radm_save_settings_action', 'radm_save_settings_nonce' ); ?>
        
        <div style="display: flex; gap: 40px; flex-wrap: wrap;">
            
            <!-- General Settings -->
            <div style="flex: 1; min-width: 300px;">
                <h3>General Settings</h3>
                <p>Website name, logo, and core branding.</p>
                
                <div class="radm-form-group" style="margin-bottom: 15px;">
                    <label>Website Name</label>
                    <input type="text" name="blogname" value="<?php echo esc_attr( get_option( 'blogname' ) ); ?>" class="radm-input" style="width: 100%;" />
                </div>
                
                <div class="radm-form-group" style="margin-bottom: 15px;">
                    <label>Tagline</label>
                    <input type="text" name="blogdescription" value="<?php echo esc_attr( get_option( 'blogdescription' ) ); ?>" class="radm-input" style="width: 100%;" />
                </div>
                
                <div class="radm-form-group" style="margin-bottom: 15px;">
                    <label>System Admin Email</label>
                    <input type="email" name="admin_email" value="<?php echo esc_attr( get_option( 'admin_email' ) ); ?>" class="radm-input" style="width: 100%;" />
                </div>
            </div>

            <!-- Contact Information -->
            <div style="flex: 1; min-width: 300px;">
                <h3>Contact Information</h3>
                <p>Public contact details for the organization.</p>
                
                <div class="radm-form-group" style="margin-bottom: 15px;">
                    <label>Public Contact Phone</label>
                    <input type="text" name="radm_contact_phone" value="<?php echo esc_attr( get_option( 'radm_contact_phone' ) ); ?>" class="radm-input" style="width: 100%;" />
                </div>
                
                <div class="radm-form-group" style="margin-bottom: 15px;">
                    <label>Public Contact Email</label>
                    <input type="email" name="radm_contact_email" value="<?php echo esc_attr( get_option( 'radm_contact_email' ) ); ?>" class="radm-input" style="width: 100%;" />
                </div>
                
                <div class="radm-form-group" style="margin-bottom: 15px;">
                    <label>Headquarters Address</label>
                    <textarea name="radm_contact_address" class="radm-input" style="width: 100%; height: 80px;"><?php echo esc_textarea( get_option( 'radm_contact_address' ) ); ?></textarea>
                </div>
            </div>
            
        </div>

        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 30px 0;" />

        <div style="display: flex; gap: 40px; flex-wrap: wrap;">
            
            <!-- Integration Settings -->
            <div style="flex: 1; min-width: 300px;">
                <h3>Integration Settings</h3>
                <p>API keys and endpoint configurations.</p>
                
                <div class="radm-form-group" style="margin-bottom: 15px;">
                    <label>WATI API Base URL</label>
                    <input type="url" name="wati_api_base_url" value="<?php echo esc_attr( get_option( 'wati_api_base_url' ) ); ?>" class="radm-input" style="width: 100%;" placeholder="https://live-server-XXXX.wati.io" />
                </div>
                
                <div class="radm-form-group" style="margin-bottom: 15px;">
                    <label>WATI Access Token</label>
                    <input type="password" name="wati_access_token" value="<?php echo esc_attr( get_option( 'wati_access_token' ) ); ?>" class="radm-input" style="width: 100%;" placeholder="Enter Token..." />
                </div>
                
                <div class="radm-form-group" style="margin-bottom: 15px;">
                    <label>AI Provider API Key (OpenAI/Anthropic)</label>
                    <input type="password" name="ry_ai_api_key" value="<?php echo esc_attr( get_option( 'ry_ai_api_key' ) ); ?>" class="radm-input" style="width: 100%;" placeholder="sk-..." />
                </div>
            </div>

            <!-- Notifications & Backup -->
            <div style="flex: 1; min-width: 300px;">
                <h3>Notifications & Data</h3>
                
                <div class="radm-form-group" style="margin-bottom: 15px;">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" name="radm_notify_email_active" value="1" <?php checked( get_option( 'radm_notify_email_active', '1' ), '1' ); ?> />
                        Enable System Email Alerts
                    </label>
                </div>
                
                <div class="radm-form-group" style="margin-bottom: 15px;">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" name="radm_notify_sms_active" value="1" <?php checked( get_option( 'radm_notify_sms_active', '0' ), '1' ); ?> />
                        Enable SMS / WhatsApp Alerts
                    </label>
                </div>

                <div style="margin-top: 30px; padding: 15px; background: #f8fafc; border-radius: 8px;">
                    <h4>Backup & Data Management</h4>
                    <p style="font-size: 13px; color: #64748b;">To export all registrations, please use the Registrations module. Full site backups should be managed via your hosting provider or a dedicated backup plugin.</p>
                    <a href="<?php echo esc_url( admin_url( 'admin-ajax.php?action=radm_export_csv&nonce=' . wp_create_nonce('radm_nonce') ) ); ?>" class="radm-btn radm-btn-secondary" style="margin-top:10px;">
                        Export All Registrations (CSV)
                    </a>
                </div>
            </div>
            
        </div>

        <div style="margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
            <button type="submit" name="radm_save_settings" class="radm-btn radm-btn-primary">
                Save All Settings
            </button>
        </div>

    </form>
</div>

<?php radm_portal_footer(); ?>
