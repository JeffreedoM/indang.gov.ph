<?php

//SORT DATE
if (isset($_GET['sort_date'])) {
    $date_from = $_GET['date_from'];
    $date_to = $_GET['date_to'];
    if (!empty($date_from) && empty($date_to)) {
        $collection = $pdo->query("SELECT * FROM new_finance WHERE financeLabel='collection' AND financeBrgyID='$barangayId' AND collectionDate = '$date_from'")->fetchAll();
        $deposit = $pdo->query("SELECT * FROM new_finance WHERE financeLabel='deposit' AND financeBrgyID='$barangayId' AND depositDate = '$date_from'")->fetchAll();
        $expenses = $pdo->query("SELECT * FROM new_finance WHERE financeLabel='expenses' AND financeBrgyID='$barangayId' AND expensesDateFrom = '$date_from'")->fetchAll();
        
        // For Clearance
        $clearance = $pdo->query("SELECT * FROM new_clearance WHERE barangay_id='$barangayId' AND finance_date = '$date_from' AND status='Paid' GROUP BY form_request")->fetchAll();
        // Total Clearance
        $totalAmountClearance = $pdo->query("SELECT COALESCE(SUM(amount), 0) AS total_clearance FROM new_clearance WHERE barangay_id='$barangayId' AND finance_date = '$date_from' AND status='Paid'");
        $totalRowAmountClearance = $totalAmountClearance->fetch();
        $finalTotalClearance = $totalRowAmountClearance['total_clearance'];

        // Total Collection
        $totalAmountCollection = $pdo->query("SELECT COALESCE(SUM(collectionAmount), 0) AS total_collection FROM new_finance WHERE financeLabel='collection' AND financeBrgyID='$barangayId' AND collectionDate = '$date_from'");
        $totalRowAmountCollection = $totalAmountCollection->fetch();
        $finalTotalCollection = $totalRowAmountCollection['total_collection'];

        // Total Deposit
        $totalAmountDeposit = $pdo->query("SELECT COALESCE(SUM(depositAmount), 0) AS total_deposit FROM new_finance WHERE financeLabel='deposit' AND financeBrgyID='$barangayId' AND depositDate = '$date_from'");
        $totalRowAmountDeposit = $totalAmountDeposit->fetch();
        $finalTotalDeposit = $totalRowAmountDeposit['total_deposit'];

        // Total Expenses
        $totalAmountExpenses = $pdo->query("SELECT COALESCE(SUM(expensesProjectAmount + expensesElectricAmount + expensesWaterAmount), 0) AS total_expenses FROM new_finance WHERE financeLabel='expenses' AND financeBrgyID='$barangayId' AND expensesDateFrom = '$date_from'");
        $totalRowAmountExpenses = $totalAmountExpenses->fetch();
        $finalTotalExpenses = $totalRowAmountExpenses['total_expenses'];
    }
    if (!empty($date_from) && !empty($date_to)) { //WHEN BOTH DATE IS SELECTED
        $collection = $pdo->query("SELECT * FROM new_finance WHERE financeLabel='collection' AND financeBrgyID='$barangayId' AND collectionDate >= '$date_from' AND collectionDate <= '$date_to'")->fetchAll();
        $deposit = $pdo->query("SELECT * FROM new_finance WHERE financeLabel='deposit' AND financeBrgyID='$barangayId' AND depositDate >= '$date_from' AND depositDate <= '$date_to'")->fetchAll();
        $expenses = $pdo->query("SELECT * FROM new_finance WHERE financeLabel='expenses' AND financeBrgyID='$barangayId' AND expensesDateFrom >= '$date_from' AND expensesDateTo <= '$date_to'")->fetchAll();
        
        // For Clearance
        $clearance = $pdo->query("SELECT * FROM new_clearance WHERE barangay_id='$barangayId' AND finance_date >= '$date_from' AND finance_date <= '$date_to' AND status='Paid' GROUP BY form_request")->fetchAll();
        // Total Clearance
        $totalAmountClearance = $pdo->query("SELECT COALESCE(SUM(amount), 0) AS total_clearance FROM new_clearance WHERE barangay_id='$barangayId' AND finance_date >= '$date_from' AND finance_date <= '$date_to' AND status='Paid'");
        $totalRowAmountClearance = $totalAmountClearance->fetch();
        $finalTotalClearance = $totalRowAmountClearance['total_clearance'];

        // Total Collection
        $totalAmountCollection = $pdo->query("SELECT COALESCE(SUM(collectionAmount), 0) AS total_collection FROM new_finance WHERE financeLabel='collection' AND financeBrgyID='$barangayId' AND collectionDate >= '$date_from' AND collectionDate <= '$date_to'");
        $totalRowAmountCollection = $totalAmountCollection->fetch();
        $finalTotalCollection = $totalRowAmountCollection['total_collection'];

        // Total Deposit
        $totalAmountDeposit = $pdo->query("SELECT COALESCE(SUM(depositAmount), 0) AS total_deposit FROM new_finance WHERE financeLabel='deposit' AND financeBrgyID='$barangayId' AND depositDate >= '$date_from' AND depositDate <= '$date_to'");
        $totalRowAmountDeposit = $totalAmountDeposit->fetch();
        $finalTotalDeposit = $totalRowAmountDeposit['total_deposit'];

        // Total Expenses
        $totalAmountExpenses = $pdo->query("SELECT COALESCE(SUM(expensesProjectAmount + expensesElectricAmount + expensesWaterAmount), 0) AS total_expenses FROM new_finance WHERE financeLabel='expenses' AND financeBrgyID='$barangayId' AND expensesDateFrom >= '$date_from' AND expensesDateTo <= '$date_to'");
        $totalRowAmountExpenses = $totalAmountExpenses->fetch();
        $finalTotalExpenses = $totalRowAmountExpenses['total_expenses'];
    }
} else { //WHEN THERE ARE NO SELECTED DATE
    $collection = $pdo->query("SELECT * FROM new_finance WHERE financeLabel='collection' AND financeBrgyID='$barangayId'")->fetchAll();
    $deposit = $pdo->query("SELECT * FROM new_finance WHERE financeLabel='deposit' AND financeBrgyID='$barangayId'")->fetchAll();
    $expenses = $pdo->query("SELECT * FROM new_finance WHERE financeLabel='expenses' AND financeBrgyID='$barangayId'")->fetchAll();

    // For Clearance
    $clearance = $pdo->query("SELECT * FROM new_clearance WHERE barangay_id='$barangayId' AND status='Paid' GROUP BY form_request")->fetchAll();
    // Total Clearance
    $totalAmountClearance = $pdo->query("SELECT COALESCE(SUM(amount), 0) AS total_clearance FROM new_clearance WHERE barangay_id='$barangayId' AND status='Paid'");
    $totalRowAmountClearance = $totalAmountClearance->fetch();
    $finalTotalClearance = $totalRowAmountClearance['total_clearance'];

    // Total Collection
    $totalAmountCollection = $pdo->query("SELECT COALESCE(SUM(collectionAmount), 0) AS total_collection FROM new_finance WHERE financeLabel='collection' AND financeBrgyID='$barangayId'");
    $totalRowAmountCollection = $totalAmountCollection->fetch();
    $finalTotalCollection = $totalRowAmountCollection['total_collection'];
    
    // Total Deposit
    $totalAmountDeposit = $pdo->query("SELECT COALESCE(SUM(depositAmount), 0) AS total_deposit FROM new_finance WHERE financeLabel='deposit' AND financeBrgyID='$barangayId'");
    $totalRowAmountDeposit = $totalAmountDeposit->fetch();
    $finalTotalDeposit = $totalRowAmountDeposit['total_deposit'];

    // Total Expenses
    $totalAmountExpenses = $pdo->query("SELECT COALESCE(SUM(expensesProjectAmount + expensesElectricAmount + expensesWaterAmount), 0) AS total_expenses FROM new_finance WHERE financeLabel='expenses' AND financeBrgyID='$barangayId'");
    $totalRowAmountExpenses = $totalAmountExpenses->fetch();
    $finalTotalExpenses = $totalRowAmountExpenses['total_expenses'];

}

//Treasurer name registered
$treasurer = $pdo->query("SELECT * FROM resident JOIN officials ON resident.resident_id = officials.resident_id WHERE position = 'Barangay Treasurer'")->fetch();
if ($treasurer) {
    $name_registered = $treasurer['firstname'].' '.$treasurer['middlename'].' '.$treasurer['lastname'];
    $treasurer_id=$treasurer['official_id'];
} else {
    $name_registered = 'Unregistered';
    $treasurer_id = '00';
}

// Barangay Name
$barangay_reg = $pdo->query("SELECT b_name FROM barangay WHERE b_id = '$barangayId'")->fetchColumn();

//Barangay Images
$barangay_img = $pdo->query("SELECT b_logo FROM barangay WHERE b_id = '$barangayId'")->fetchColumn();
?>