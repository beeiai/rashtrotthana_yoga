<?php
 = 'wp-content/themes/rashtrotthana/inc/data-helpers.php';
 = file_get_contents();

// Fix rs_get_homepage_data undefined variables
 = "function rs_get_homepage_data() {";
 = "function rs_get_homepage_data() {
    \ = [];
    \ = [];
    \ = [];
    \ = [];
    \ = [];
    \ = [];";
 = str_replace(, , );

// Fix foreach warning in rs_get_centers
 = "\ = get_field('programs', \->ID);
        if (\) {
            foreach (\ as \) {";
 = "\ = get_field('programs', \->ID);
        if ( is_numeric(\) || is_string(\) ) {
            \ = intval(\);
            \ = [];
            for ( \ = 0; \ < \; \++ ) {
                \[] = [
                    'program_name' => get_post_meta(\->ID, 'programs_' . \ . '_program_name', true),
                    'badge'        => get_post_meta(\->ID, 'programs_' . \ . '_badge', true),
                    'days'         => get_post_meta(\->ID, 'programs_' . \ . '_days', true),
                    'timings'      => get_post_meta(\->ID, 'programs_' . \ . '_timings', true),
                    'dates'        => get_post_meta(\->ID, 'programs_' . \ . '_dates', true),
                    'desc'         => get_post_meta(\->ID, 'programs_' . \ . '_desc', true),
                ];
            }
        }
        if (is_array(\)) {
            foreach (\ as \) {";
 = str_replace(, , );

file_put_contents(, );
echo "Patched successfully\n";
