<?php
include 'dbh.inc.php';

$id = $_GET['id'];
$sql = $pdo->query("UPDATE barangay SET is_active = 1 WHERE b_id='$id'")->execute();


header('Location: ../barangay.php?message=Barangay activated successfully');
