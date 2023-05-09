<?php
session_save_path(dirname(__DIR__) . '/sessions');
session_start();
include 'dbh.inc.php';
include 'login-system.inc.php';

$allowedRolesForPage = [
    'dashboard' => ['Barangay Secretary', 'Barangay Captain'],
    'officials' => ['Barangay Secretary', 'Barangay Captain'],
    'resident' => ['Barangay Secretary', 'Barangay Captain'],
    // Add more modules and allowed roles here
];

$account_data = checkLogin($pdo, $allowedRolesForPage);
