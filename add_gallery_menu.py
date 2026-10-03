import re

with open('wp-content/plugins/rashtrotthana-admin/includes/admin-init.php', 'r', encoding='utf-8') as f:
    text = f.read()

search = "    add_submenu_page( 'radm-dashboard', 'Manage News', 'News', 'manage_options', 'edit.php' );"
replace = """    add_submenu_page( 'radm-dashboard', 'Manage News', 'News', 'manage_options', 'edit.php' );
    add_submenu_page( 'radm-dashboard', 'Manage Gallery', 'Gallery', 'manage_options', 'edit.php?post_type=rs_gallery_album' );"""

text = text.replace(search, replace)

with open('wp-content/plugins/rashtrotthana-admin/includes/admin-init.php', 'w', encoding='utf-8') as f:
    f.write(text)
