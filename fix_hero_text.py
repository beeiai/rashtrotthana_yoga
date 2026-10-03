import re

with open('wp-content/themes/rashtrotthana/style.css', 'r', encoding='utf-8') as f:
    css = f.read()

# Add text shadow to hero title and description to make it pop regardless of image
css += "\n.rs-hero-title, .rs-hero-description { text-shadow: 0 2px 10px rgba(255, 255, 255, 0.9), 0 0 40px rgba(255, 255, 255, 0.8); }\n"
css += "@media (max-width: 768px) { .rs-hero-title { font-size: 2.2rem !important; } .rs-hero-content { background: rgba(255, 250, 244, 0.7); border-radius: 12px; padding: 20px !important; margin: 20px !important; } }\n"

with open('wp-content/themes/rashtrotthana/style.css', 'w', encoding='utf-8') as f:
    f.write(css)
