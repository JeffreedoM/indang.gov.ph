<?php
// include 'dbh.inc.php';
// function checkLogin()

function checkLogin($pdo, $allowedRoles = [])
{
    // Check if the user is logged in and associated with the current barangay
    if (isset($_SESSION['account_id'])) {
        $id = $_SESSION['account_id'];

        $result = $pdo->query("SELECT * 
        FROM accounts 
        INNER JOIN officials 
        ON accounts.official_id = officials.official_id 
        WHERE accounts.account_id = '$id' 
        LIMIT 1");
        $result->execute();
        $numRows = $result->rowCount();
        if ($result && $numRows > 0) {
            $account_data = $result->fetch();
            // Get the module name from the URL
            $url_parts = explode('/', $_SERVER['REQUEST_URI']);
            $module_name = isset($url_parts[4]) ? $url_parts[4] : '';
            // Check if user has the allowed role(s) for the current module
            if (isset($allowedRoles[$module_name]) && in_array($account_data['position'], $allowedRoles[$module_name])) {
                return $account_data;
            } else {
                header('Location: ../../unauthorized.php');
                die;
            }
        }
    }

    // Redirect to login if not logged in or not authorized
    header('Location: ../../login.php');
    die;
}
