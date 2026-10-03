import re

with open('wp-content/themes/rashtrotthana/template-parts/home/homepage-sections.php', 'r', encoding='utf-8') as f:
    text = f.read()

# Replace any block that starts with else : foreach ( $.*_fallbacks as up to endif; ?>
text = re.sub(r'else\s*:\s*foreach\s*\(\s*\$[a-zA-Z0-9_]+_fallbacks\s*as\s*\$[^)]+\)\s*:\s*\?>.*?<\?php\s*endforeach;\s*endif;\s*\?>', r'endif; ?>', text, flags=re.DOTALL)
text = re.sub(r'else\s*:\s*foreach\s*\(\s*\\s*as\s*\$[^)]+\)\s*:\s*\?>.*?<\?php\s*endforeach;\s*endif;\s*\?>', r'endif; ?>', text, flags=re.DOTALL)

with open('wp-content/themes/rashtrotthana/template-parts/home/homepage-sections.php', 'w', encoding='utf-8') as f:
    f.write(text)
