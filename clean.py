import re

with open('wp-content/plugins/rashtrotthana-admin/includes/admin-init.php', 'r', encoding='utf-8') as f:
    text = f.read()

# Replace the duplicated blocks
clean_function = """    foreach (  as [ , , ,  ] ) {
        add_submenu_page( 'radm-dashboard', , , , ,  );
    }
    
    // Manage Centers, Activities, News from within the Portal menu
    add_submenu_page( 'radm-dashboard', 'Manage Centers', 'Centers', 'manage_options', 'edit.php?post_type=rs_center' );
    add_submenu_page( 'radm-dashboard', 'Manage Activities', 'Activities', 'manage_options', 'edit.php?post_type=rs_activity' );
    add_submenu_page( 'radm-dashboard', 'Manage News', 'News', 'manage_options', 'edit.php' );
}"""

# Use regex to replace everything from oreach (  up to the closing } before dd_action( 'admin_menu'
text = re.sub(r'foreach\s*\(\s*\.*?\}\s*(?=add_action\(\s*\'admin_menu\')', clean_function + "\n", text, flags=re.DOTALL)

with open('wp-content/plugins/rashtrotthana-admin/includes/admin-init.php', 'w', encoding='utf-8') as f:
    f.write(text)
