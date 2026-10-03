<?php
require_once(__DIR__ . "/wp-load.php");

$json = file_get_contents("C:\\Users\\sande\\.gemini\\antigravity\\brain\\e5c0e098-e742-4c77-91d8-039e319ff6c2\\scratch\\parsed_centers.json");
$centers = json_decode($json, true);

if (!$centers) {
    die("Failed to parse JSON.\n");
}

echo "Updating Centers...\n";

foreach ($centers as $c) {
    $existing = get_page_by_title($c["name"], OBJECT, "center");
    if (!$existing) {
        $post_id = wp_insert_post([
            "post_title"   => $c["name"],
            "post_type"    => "center",
            "post_status"  => "publish",
            "post_content" => $c["address"]
        ]);
        echo "Created new center: {$c["name"]}\n";
    } else {
        $post_id = $existing->ID;
        wp_update_post([
            "ID" => $post_id,
            "post_content" => $c["address"]
        ]);
        echo "Updated center: {$c["name"]}\n";
    }
    
    if (is_wp_error($post_id)) continue;
    
    update_field("lat", $c["lat"], $post_id);
    update_field("lng", $c["lng"], $post_id);
    update_field("phone", $c["phone"], $post_id);
    update_field("map_link", $c["map_link"], $post_id);
    update_field("instagram", $c["instagram"], $post_id);
    update_field("facebook", $c["facebook"], $post_id);
    update_field("linkedin", $c["linkedin"], $post_id);
    
    $programs = [];
    foreach ($c["activities"] as $act) {
        $programs[] = array(
            "program_name" => $act["name"] . " (" . $act["timing"] . ")"
        );
    }
    update_field("programs", $programs, $post_id);
    
    update_post_meta($post_id, "_ry_center_lat", $c["lat"]);
    update_post_meta($post_id, "_ry_center_lng", $c["lng"]);
    update_post_meta($post_id, "_ry_center_phone", $c["phone"]);
}
echo "Done!\n";

