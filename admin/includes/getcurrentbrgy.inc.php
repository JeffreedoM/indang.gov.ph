<?php
include 'dbh.inc.php';

$municipality = $pdo->query("SELECT municipality_link FROM superadmin_config")->fetch();

$url = $_SERVER['PHP_SELF'];
// Check if running on localhost
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    // Handle localhost logic here
    $domain = $municipality['municipality_link'];
    if (preg_match('#' . preg_quote($domain, '#') . '/([^/]+)/#', $url, $matches)) {
        $currentBarangay = $matches[1];
    }
} else {
    // non-localhost (deployed)
    $domain = $_SERVER['HTTP_HOST'];
    if (preg_match('#' . preg_quote($domain, '#') . '/([^/]+)/#', $url, $matches)) {
        $currentBarangay = $matches[1];
    }
}
// $currentBarangay = basename(__DIR__);
$barangay = $pdo->query("SELECT * FROM barangay WHERE b_link='$domain/$currentBarangay'")->fetch();
$barangayName = ucwords($barangay['b_name']);
$barangayId = $barangay['b_id'];
