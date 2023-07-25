<?php
session_save_path(dirname(__DIR__) . '/sessions');
session_start();
include 'dbh.inc.php';
include 'login-system.inc.php';

// $allowedForAll = ['Barangay Secretary', 'Barangay Captain'];
// $allowedRolesForPage = [
//     'dashboard' => ['Barangay Secretary', 'Barangay Captain'],
//     'officials' => ['Barangay Secretary', 'Barangay Captain'],
//     'resident' => ['Barangay Secretary', 'Barangay Captain'],
//     'account' => ['Barangay Secretary'],
//     'announcement' => ['Barangay Secretary'],
//     'clearance_and_forms' => ['Barangay Secretary'],
//     'finance' => ['Barangay Secretary'],
//     'peace_and_order' => ['Barangay Secretary'],
//     'reports' => ['Barangay Secretary'],
//     'site_configuration' => ['Barangay Secretary'],
//     'special_projects' => ['Barangay Secretary'],
//     'health_and_sanitation' => ['Barangay Secretary'],
//     // Add more modules and allowed roles here
// ];

// $account_data = checkLogin($pdo, $allowedRolesForPage);
$account_data = checkLogin($pdo);
