import re

with open('wp-content/themes/rashtrotthana/style.css', 'r', encoding='utf-8') as f:
    css = f.read()

css = css.replace('.rs-hero-image-wrapper:after {', '.rs-hero-image-wrapper:after { content: ""; ')

with open('wp-content/themes/rashtrotthana/style.css', 'w', encoding='utf-8') as f:
    f.write(css)
