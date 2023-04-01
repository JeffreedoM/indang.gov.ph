<?php
session_save_path(dirname(__DIR__) . '/sessions');
session_start();
include 'dbh.inc.php';
include 'login-system.inc.php';
$account_data = checkLogin($pdo);
