import re

with open('wp-content/themes/rashtrotthana/inc/data-helpers.php', 'r', encoding='utf-8') as f:
    text = f.read()

text = text.replace("'post_type' => 'rs_event'", "'post_type' => 'event'")

with open('wp-content/themes/rashtrotthana/inc/data-helpers.php', 'w', encoding='utf-8') as f:
    f.write(text)
