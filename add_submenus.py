import re

with open('wp-content/plugins/rashtrotthana-admin/includes/admin-init.php', 'r', encoding='utf-8') as f:
    text = f.read()

replacement = """    }
    
    // Add native WP management pages under the Custom Portal menu
    add_submenu_page( 'radm-dashboard', 'Manage Centers', 'Centers', 'manage_options', 'edit.php?post_type=rs_center' );
    add_submenu_page( 'radm-dashboard', 'Manage Activities', 'Activities', 'manage_options', 'edit.php?post_type=activity' );
    add_submenu_page( 'radm-dashboard', 'Manage News', 'News', 'manage_options', 'edit.php' );
}
add_action( 'admin_menu', 'radm_register_menu' );"""

# The exact text to replace is:
#     }
# }
# add_action( 'admin_menu', 'radm_register_menu' );

text = re.sub(r'\}\s*\}\s*add_action\(\s*\'admin_menu\',\s*\'radm_register_menu\'\s*\);', replacement, text)

with open('wp-content/plugins/rashtrotthana-admin/includes/admin-init.php', 'w', encoding='utf-8') as f:
    f.write(text)
