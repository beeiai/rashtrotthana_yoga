<?php
require_once(__DIR__ . "/wp-load.php");

$json = file_get_contents("C:\\Users\\sande\\.gemini\\antigravity\\brain\\e5c0e098-e742-4c77-91d8-039e319ff6c2\\scraped_team.json");
$team = json_decode($json, true);

if ($team) {
    update_field("ry_about_team", $team, "option");
    echo "Successfully updated Team!\n";
} else {
    echo "Failed to load JSON.\n";
}
