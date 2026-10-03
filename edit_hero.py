import sys
import re

filepath = 'wp-content/themes/rashtrotthana/template-parts/home/hero.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

new_content = content.replace(
    '<img class="rs-hero-slide is-active" src="<?php echo esc_url( get_template_directory_uri() . \'/assets/images/client/21-06-22-idy-celebration-12-.jpg\' ); ?>" alt="Yoga practice at Rashtrotthana" fetchpriority="high">',
    '<img class="rs-hero-slide is-active" src="<?php echo esc_url( get_template_directory_uri() . \'/assets/images/client/dsc08484.jpg\' ); ?>" alt="Yoga practice at Rashtrotthana" fetchpriority="high">'
).replace(
    '<img class="rs-hero-slide" src="<?php echo esc_url( get_template_directory_uri() . \'/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg\' ); ?>" alt="Cultural Gathering" loading="lazy">',
    '<img class="rs-hero-slide" src="<?php echo esc_url( get_template_directory_uri() . \'/assets/images/client/dsc08548-2-.png\' ); ?>" alt="Cultural Gathering" loading="lazy">'
).replace(
    '<img class="rs-hero-slide" src="<?php echo esc_url( get_template_directory_uri() . \'/assets/images/client/07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg\' ); ?>" alt="Summer Camp" loading="lazy">',
    '<img class="rs-hero-slide" src="<?php echo esc_url( get_template_directory_uri() . \'/assets/images/client/dsc08572.jpg\' ); ?>" alt="Summer Camp" loading="lazy">'
)

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(new_content)
