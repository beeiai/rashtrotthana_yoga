import re

with open('wp-content/plugins/rashtrotthana-admin/includes/admin-init.php', 'r', encoding='utf-8') as f:
    text = f.read()

text = text.replace('edit.php?post_type=activity', 'edit.php?post_type=rs_activity')

with open('wp-content/plugins/rashtrotthana-admin/includes/admin-init.php', 'w', encoding='utf-8') as f:
    f.write(text)
