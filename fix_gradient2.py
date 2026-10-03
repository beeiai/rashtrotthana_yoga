import re

with open('wp-content/themes/rashtrotthana/style.css', 'r', encoding='utf-8') as f:
    css = f.read()

css = css.replace('.rs-hero-image-wrapper:after { content: ""; ', '.rs-hero-image-wrapper:after { content: ""; position: absolute; inset: 0; z-index: 1; pointer-events: none; ')

with open('wp-content/themes/rashtrotthana/style.css', 'w', encoding='utf-8') as f:
    f.write(css)
