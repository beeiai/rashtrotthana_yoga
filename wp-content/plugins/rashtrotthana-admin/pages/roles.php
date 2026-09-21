<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Verify capabilities
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( 'You do not have sufficient permissions to access this page.' );
}

$message = '';
// Handle role change submission
if ( isset( $_POST['radm_change_role'] ) ) {
    if ( ! check_admin_referer( 'radm_change_role_action', 'radm_change_role_nonce' ) ) {
        wp_die( 'Security check failed.' );
    }

    $user_id = absint( $_POST['user_id'] ?? 0 );
    $new_role = sanitize_text_field( $_POST['new_role'] ?? '' );
    
    // Prevent changing your own role accidentally if you are the only super admin
    if ( $user_id === get_current_user_id() && $new_role !== 'administrator' ) {
        $message = '<div class="radm-toast radm-toast--error radm-toast-show">You cannot demote yourself.</div>';
    } else {
        $user = get_userdata( $user_id );
        if ( $user && in_array( $new_role, [ 'administrator', 'radm_admin', 'radm_gallery', 'subscriber' ], true ) ) {
            $user->set_role( $new_role );
            $message = '<div class="radm-toast radm-toast--success radm-toast-show">Role updated successfully.</div>';
        } else {
            $message = '<div class="radm-toast radm-toast--error radm-toast-show">Invalid user or role.</div>';
        }
    }
}

radm_portal_header( 'Roles & Responsibilities', 'Manage staff roles and their responsibilities' );
echo $message;

// Fetch all users
$users = get_users();
$role_names = [
    'administrator' => 'Super Admin (Full Access)',
    'radm_admin'    => 'Admin (Content & Registrations)',
    'radm_gallery'  => 'Gallery Manager (Media Only)',
    'subscriber'    => 'Subscriber (No Access)',
];
?>

<div class="radm-card">
    <div class="radm-card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Staff Users</h2>
        <a href="<?php echo esc_url( admin_url( 'user-new.php' ) ); ?>" class="radm-btn radm-btn-primary">
            + Add New User
        </a>
    </div>

    <table class="radm-table" style="width: 100%; text-align: left; border-collapse: collapse; margin-top: 15px;">
        <thead>
            <tr style="border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 10px;">Name</th>
                <th style="padding: 12px 10px;">Email</th>
                <th style="padding: 12px 10px;">Current Role</th>
                <th style="padding: 12px 10px;">Change Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $users as $user ) : 
                $user_role = ! empty( $user->roles ) ? $user->roles[0] : 'subscriber';
            ?>
            <tr style="border-bottom: 1px solid #f1f5f9;">
                <td style="padding: 12px 10px;"><strong><?php echo esc_html( $user->display_name ); ?></strong></td>
                <td style="padding: 12px 10px;"><?php echo esc_html( $user->user_email ); ?></td>
                <td style="padding: 12px 10px;">
                    <span class="radm-badge radm-badge--<?php echo $user_role === 'administrator' ? 'open' : 'closed'; ?>" style="font-size: 12px; padding: 4px 8px; border-radius: 12px; background: #f1f5f9;">
                        <?php echo esc_html( $role_names[$user_role] ?? ucfirst($user_role) ); ?>
                    </span>
                </td>
                <td style="padding: 12px 10px;">
                    <form method="post" action="" style="display: flex; gap: 10px; align-items: center; margin: 0;">
                        <?php wp_nonce_field( 'radm_change_role_action', 'radm_change_role_nonce' ); ?>
                        <input type="hidden" name="user_id" value="<?php echo absint( $user->ID ); ?>" />
                        
                        <select name="new_role" class="radm-input" style="padding: 6px; font-size: 13px;">
                            <?php foreach ( $role_names as $role_key => $role_label ) : ?>
                                <option value="<?php echo esc_attr( $role_key ); ?>" <?php selected( $user_role, $role_key ); ?>>
                                    <?php echo esc_html( $role_label ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        
                        <button type="submit" name="radm_change_role" class="radm-btn radm-btn-secondary" style="padding: 6px 12px; font-size: 13px;">
                            Update
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="radm-card" style="margin-top: 20px; background: #f8fafc;">
    <h3>Role Capabilities Reference</h3>
    <ul style="line-height: 1.6; margin-left: 20px; color: #475569; font-size: 14px;">
        <li><strong>Super Admin:</strong> Full access to all modules, system settings, user management, and configuration.</li>
        <li><strong>Admin:</strong> Can create, edit, and delete events, manage registrations, and update page content. Cannot access system settings or change user roles.</li>
        <li><strong>Gallery Manager:</strong> Can access the WordPress media library to upload, organize, and delete gallery images. No access to settings or registrations.</li>
    </ul>
</div>

<?php radm_portal_footer(); ?>
