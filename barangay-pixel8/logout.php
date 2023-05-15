<?php
include 'includes/session.php';
if (isset($_SESSION['account_id'])) {
    unset($_SESSION['account_id']);
}

header('Location: ./index.php');
die;
