<?php
// include 'dbh.inc.php';
// function checkLogin()

function checkLogin($pdo)
{
    // Check if the user is logged in and associated with the current barangay
    if (isset($_SESSION['account_id'])) {
        $id = $_SESSION['account_id'];

        $result = $pdo->query("SELECT * FROM accounts WHERE account_id = '$id' LIMIT 1");
        $result->execute();
        $numRows = $result->rowCount();
        if ($result && $numRows > 0) {
            $account_data = $result->fetch();
            return $account_data;
        }
    }
    // Redirect to login if not logged in or not associated with the current barangay
    header('Location: ../../login.php');
    die;
}
