<?php
require_once('wp-load.php');
$opt = array (
  0 => array (
    'value' => 1972,
    'suffix' => '',
    'label' => 'Since',
  ),
  1 => array (
    'value' => 35,
    'suffix' => '+',
    'label' => 'Activities',
  ),
  2 => array (
    'value' => 18,
    'suffix' => '',
    'label' => 'Projects',
  ),
  3 => array (
    'value' => 12,
    'suffix' => '',
    'label' => 'Centers',
  ),
  4 => array (
    'value' => 1000,
    'suffix' => '+',
    'label' => 'Lives Impacted',
  )
);
update_option('options_ry_home_stats', $opt);

// For ACF repeaters in options, we also need to update the individual meta keys for each row!
update_option('options_ry_home_stats', 5); // the number of rows
update_option('_options_ry_home_stats', 'field_hx_stats');

for ($i=0; $i<5; $i++) {
    update_option('options_ry_home_stats_'.$i.'_value', $opt[$i]['value']);
    update_option('_options_ry_home_stats_'.$i.'_value', 'field_hx_stat_val');
    
    update_option('options_ry_home_stats_'.$i.'_suffix', $opt[$i]['suffix']);
    update_option('_options_ry_home_stats_'.$i.'_suffix', 'field_hx_stat_suf');
    
    update_option('options_ry_home_stats_'.$i.'_label', $opt[$i]['label']);
    update_option('_options_ry_home_stats_'.$i.'_label', 'field_hx_stat_lbl');
}
echo "Done updating ACF options!\n";
