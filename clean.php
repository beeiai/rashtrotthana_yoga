<?php
 = 'wp-content/themes/rashtrotthana/inc/data-helpers.php';
 = file_get_contents();

// Remove if (empty(...)) { require ... }
 = preg_replace('/if\s*\(\s*(?:is_wp_error\([^)]+\)\s*\|\|\s*)?empty\(\$[a-zA-Z0-9_]+\)\s*\)\s*\{\s*require\s*get_template_directory\(\)\s*\.\s*\'\/data\/[^\']+\';\s*return\s*[^;]+;\s*\}/s', '', );

 = str_replace("require get_template_directory() . '/data/homepage-data.php';", "", );

 = str_replace("'values'     => \,", "'values'     => isset(\) ? \ : array(),", );
 = str_replace("'stats'      => \,", "'stats'      => isset(\) ? \ : array(),", );
 = str_replace("'team'       => \", "'team'       => isset(\) ? \ : array()", );

file_put_contents(, );
echo "Cleaned.\n";
