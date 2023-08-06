<?php

include 'dbh.inc.php';
//Hide contents if the barangay is deactivated.

$municipality = $pdo->query("SELECT * FROM superadmin_config")->fetch();
$municipality_logo = $municipality['municipality_logo'];

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
$is_active = $barangay['is_active'];

if (!function_exists('base_url')) {
    function base_url($atRoot = FALSE, $atCore = FALSE, $parse = FALSE)
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf($tmplt, $http, $hostname, $end);
        } else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }
}
$barangayURL =  base_url(TRUE) . $barangay['b_link'] .  '/';
$provinceURL =  base_url(TRUE) . "$domain/";
//if barangay is deactivated
if (!$is_active) {
    // session_start();

    // if (isset($_SESSION['account_id'])) {
    //     unset($_SESSION['account_id']);
    // }

    header("Location: " . $provinceURL . "deactivated.php?id=$barangay[b_id]");
    exit();
}
