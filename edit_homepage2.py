import sys

filepath = 'wp-content/themes/rashtrotthana/template-parts/home/homepage-sections.php'
with open(filepath, 'r', encoding='utf-8') as f:
    lines = f.readlines()

new_lines = lines[:31] + [
    '        <div class="rs-card-grid rs-activity-grid">\n',
    '            <article class="rs-activity-card"><img class="rs-activity-uniform-img" src="<?php echo esc_url( get_template_directory_uri() . \'/assets/images/client/21-06-22-idy-celebration-12-.jpg\' ); ?>" alt="Yoga" loading="lazy"><h3>Yoga</h3></article>\n',
    '            <article class="rs-activity-card"><img class="rs-activity-uniform-img" src="<?php echo esc_url( get_template_directory_uri() . \'/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg\' ); ?>" alt="Gym" loading="lazy"><h3>Gym</h3></article>\n',
    '            <article class="rs-activity-card"><img class="rs-activity-uniform-img" src="<?php echo esc_url( get_template_directory_uri() . \'/assets/images/client/07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg\' ); ?>" alt="Music and Dance" loading="lazy"><h3>Music and Dance</h3></article>\n',
    '            <article class="rs-activity-card"><img class="rs-activity-uniform-img" src="<?php echo esc_url( get_template_directory_uri() . \'/assets/images/client/rashtrotthana-yoga-center.jpg\' ); ?>" alt="Karate" loading="lazy"><h3>Karate</h3></article>\n',
    '        </div>\n'
] + lines[38:]

with open(filepath, 'w', encoding='utf-8') as f:
    f.writelines(new_lines)
