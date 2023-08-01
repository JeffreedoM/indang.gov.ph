<?php

function checkLogin($pdo)
{
    include 'deactivated.inc.php';
    if (isset($_SESSION['account_id'])) {
        $accountId = $_SESSION['account_id'];

        $stmt = $pdo->prepare("SELECT * FROM accounts 
        JOIN officials ON accounts.official_id = officials.official_id
        WHERE account_id = ?");
        $stmt->execute([$accountId]);

        $account_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($account_data) {
            // Check if the user is a Barangay Secretary
            if ($account_data['position'] === 'Barangay Secretary') {
                // User is a Barangay Secretary, allow access to all modules
                return $account_data;
            }

            // Get the module name from the URL
            $urlParts = explode('/', $_SERVER['REQUEST_URI']);
            $moduleName = isset($urlParts[4]) ? $urlParts[4] : '';

            // Check if the current page is the dashboard, and allow all officials to access it
            if ($moduleName === 'dashboard') {
                // All users have permission to the 'dashboard' module
                return $account_data;
            }
            // Check if the current page is account-settings, and allow all officials to access it
            if (strpos($moduleName, 'account-settings.php') !== false) {
                // All users have permission to the 'account settings'
                return $account_data;
            }


            $allowedModules = json_decode($account_data['allowed_modules'], true);

            // Check if user has the allowed role(s) for the current module
            if (in_array($moduleName, $allowedModules)) {
                // User has permission, continue execution
                return $account_data;
            } else {
                // User has no permission
                // header('Location: ' . $barangayURL . 'unauthorized.php');
                // exit();
            }
        }
    }
    // Redirect to login if not logged in
    header('Location: ' . $barangayURL . 'login.php');
}
