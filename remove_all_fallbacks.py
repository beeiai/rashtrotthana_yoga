import re

with open('wp-content/themes/rashtrotthana/inc/data-helpers.php', 'r', encoding='utf-8') as f:
    text = f.read()

text = re.sub(r'if\s*\(\s*is_wp_error\(\s*\$terms\s*\)\s*\|\|\s*empty\(\s*\$terms\s*\)\s*\)\s*\{\s*require get_template_directory\(\) \. \'/data/activities-data\.php\';\s*return \$activity_categories;\s*\}', '', text)

text = re.sub(r'if\s*\(\s*empty\(\$faqs\)\s*\)\s*\{\s*require get_template_directory\(\) \. \'/data/contact-data\.php\';\s*return isset\(\$faqs_dataset\)\s*\?\s*\$faqs_dataset\s*:\s*array\(\);\s*\}', '', text)

text = re.sub(r'if\s*\(\s*empty\(\$albums\)\s*\)\s*\{\s*require get_template_directory\(\) \. \'/data/gallery-data\.php\';\s*return \$gallery_events;\s*\}', '', text)

with open('wp-content/themes/rashtrotthana/inc/data-helpers.php', 'w', encoding='utf-8') as f:
    f.write(text)
