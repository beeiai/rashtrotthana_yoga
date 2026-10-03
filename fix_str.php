<?php
$c = file_get_contents('wp-content/themes/rashtrotthana/inc/data-helpers.php');
$c = str_replace(
    "'image'   => get_field('image', \$term_id),",
    "'image'   => get_field('image', \$term_id) ?: get_term_meta(\$term->term_id, 'image_url', true),",
    $c
);
file_put_contents('wp-content/themes/rashtrotthana/inc/data-helpers.php', $c);
