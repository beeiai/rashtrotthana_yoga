import re

with open('wp-content/themes/rashtrotthana/inc/data-helpers.php', 'r', encoding='utf-8') as f:
    text = f.read()

text = text.replace("'post_type' => 'gallery_album'", "'post_type' => 'rs_gallery_album'")

with open('wp-content/themes/rashtrotthana/inc/data-helpers.php', 'w', encoding='utf-8') as f:
    f.write(text)
