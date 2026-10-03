import re

with open('wp-content/themes/rashtrotthana/inc/data-helpers.php', 'r', encoding='utf-8') as f:
    text = f.read()

# Remove fallback blocks
# Examples:
# if ( empty() ) { require get_template_directory() . '/data/contact-data.php'; return isset() ?  : array(); }
text = re.sub(r'if \(\s*(is_wp_error\(.*?\) \|\| )?empty\(\$.*?\)\s*\)\s*\{\s*require get_template_directory\(\) \. \'/data/.*?-data\.php\';\s*return.*?;?\s*\}', '', text, flags=re.DOTALL)

# For rs_get_homepage_data(), it has: require get_template_directory() . '/data/homepage-data.php';
text = re.sub(r"require get_template_directory\(\) \. '/data/homepage-data\.php';", "", text)

# Note: we must still return empty arrays if no posts found.
# Let's inspect where it might return variables that were defined in the require.
