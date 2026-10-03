import re

with open('wp-content/plugins/rashtrotthana-admin/includes/admin-init.php', 'r', encoding='utf-8') as f:
    text = f.read()

replacement = """    // Manage Centers, Activities, News, Events from within the Portal menu
    add_submenu_page( 'radm-dashboard', 'Manage Centers', 'Centers', 'manage_options', 'edit.php?post_type=rs_center' );
    add_submenu_page( 'radm-dashboard', 'Manage Activities', 'Activities', 'manage_options', 'edit.php?post_type=rs_activity' );
    add_submenu_page( 'radm-dashboard', 'Manage Events', 'Events (Advanced)', 'manage_options', 'edit.php?post_type=event' );
    add_submenu_page( 'radm-dashboard', 'Manage News', 'News', 'manage_options', 'edit.php' );
}"""

# Use regex to replace the previous insertions
text = re.sub(r'//\s*Add native WP management pages.*?\}', replacement, text, flags=re.DOTALL)

with open('wp-content/plugins/rashtrotthana-admin/includes/admin-init.php', 'w', encoding='utf-8') as f:
    f.write(text)
