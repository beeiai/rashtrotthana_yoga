import re

with open('wp-content/plugins/rashtrotthana-admin/includes/admin-init.php', 'r', encoding='utf-8') as f:
    text = f.read()

# Replace manage_ry_registrations with manage_options for the menu registration
text = text.replace("'manage_ry_registrations'", "'manage_options'")

with open('wp-content/plugins/rashtrotthana-admin/includes/admin-init.php', 'w', encoding='utf-8') as f:
    f.write(text)
