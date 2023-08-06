<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';


// ADD FINANCE-Collection
if (isset($_POST['add_collection'])) {

    $financeBrgyID = $_POST['brgyID'];
    $financeLabel = 'collection';

    // Collection
    $collectionPayor = $_POST['collectionPayor'];
    $collectionDate = $_POST['collectionDate'];
    $collectionOther = $_POST['collectionOther'];
    $collectionAmount = $_POST['collectionAmount'];
    $collectionNature = $_POST['collectionNature'];

    if ($collectionPayor == '') {
        $finalCollectionPayor = $_POST['collectionOther'];
    } else {
        $finalCollectionPayor = $_POST['collectionPayor'];
    }

    $sql = "INSERT INTO new_finance (financeBrgyID, collectionPayor, collectionDate, collectionAmount, collectionNature, financeLabel) 
        VALUES (:financeBrgyID, :collectionPayor, :collectionDate, :collectionAmount, :collectionNature, :financeLabel)";

    $params = array(
        ':financeBrgyID' => $financeBrgyID,
        ':collectionPayor' => $finalCollectionPayor,
        ':collectionDate' => $collectionDate,
        ':collectionAmount' => $collectionAmount,
        ':collectionNature' => $collectionNature,
        ':financeLabel' => $financeLabel
    );
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header('Location: ../index.php');
}

// EDIT FINANCE-Collection
if (isset($_POST['edit_collection'])) {

    $collectionID = $_POST['collectionID'];
    $collectionPayor = $_POST['collectionPayor'];
    $collectionDate = $_POST['collectionDate'];
    $collectionAmount = $_POST['collectionAmount'];
    $collectionNature = $_POST['collectionNature'];
    $financeNote = $_POST['financeNote'];

    $query = "UPDATE new_finance SET collectionPayor=?, collectionDate=?, collectionAmount=?, collectionNature=?, financeNote=?
        WHERE financeID=?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$collectionPayor, $collectionDate, $collectionAmount, $collectionNature, $financeNote, $collectionID]);
    echo "<script>alert('Record Updated!'); window.location.href = '../index.php';</script>";
}

// DELETE FINANCE-Collection
if (isset($_POST['submit_delete_collection'])) {
    $collectionID = $_POST['collectionID'];
    $query = "DELETE FROM new_finance WHERE financeID=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$collectionID]);
    echo "<script>alert('Deleted Successfully!'); window.location.href = '../index.php';</script>";
    exit;
}


// ADD FINANCE-Expenses
if (isset($_POST['add_expenses'])) {

    $financeBrgyID = $_POST['brgyID'];
    $financeLabel = 'expenses';
    // Expenses

    $expensesDateFrom = $_POST['expensesDateFrom'];
    $expensesDateTo = $_POST['expensesDateTo'];

    // $expensesProject = $_POST['expensesProject'];
    // $expensesProjectAmount = $_POST['expensesProjectAmount'];

    $expensesOther = $_POST['expensesOther'];
    $expensesOtherAmount = $_POST['expensesOtherAmount'];

    $expensesElectricAmount = $_POST['expensesElectricAmount'];
    $expensesWaterAmount = $_POST['expensesWaterAmount'];


    $finalexpensesProject = $_POST['expensesProject'];
    $finalexpensesProjectAmount = $_POST['expensesProjectAmount'];


    $sql = "INSERT INTO new_finance (financeBrgyID, expensesProject, expensesProjectAmount, expensesElectricAmount, expensesWaterAmount, expensesDateFrom, expensesDateTo, financeLabel) 
        VALUES (:financeBrgyID, :expensesProject, :expensesProjectAmount, :expensesElectricAmount, :expensesWaterAmount, :expensesDateFrom, :expensesDateTo, :financeLabel)";

    $params = array(
        ':financeBrgyID' => $financeBrgyID,
        ':expensesProject' => $finalexpensesProject,
        ':expensesProjectAmount' => $finalexpensesProjectAmount,
        ':expensesElectricAmount' => $expensesElectricAmount,
        ':expensesWaterAmount' => $expensesWaterAmount,
        ':expensesDateFrom' => $expensesDateFrom,
        ':expensesDateTo' => $expensesDateTo,
        ':financeLabel' => $financeLabel

    );
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header('Location: ../expenses.php');
}

// EDIT FINANCE-Expenses
if (isset($_POST['edit_expenses'])) {

    $collectionID = $_POST['collectionID'];
    $financeNote = $_POST['financeNote'];

    $expensesDateFrom = $_POST['expensesDateFrom'];
    $expensesDateTo = $_POST['expensesDateTo'];
    $expensesProject = $_POST['expensesProject'];
    $expensesProjectAmount = $_POST['expensesProjectAmount'];
    $expensesElectricAmount = $_POST['expensesElectricAmount'];
    $expensesWaterAmount = $_POST['expensesWaterAmount'];


    $query = "UPDATE new_finance SET expensesDateFrom=?, expensesDateTo=?, expensesProject=?, expensesProjectAmount=?, expensesElectricAmount=?, expensesWaterAmount=?, financeNote=?
        WHERE financeID=?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$expensesDateFrom, $expensesDateTo, $expensesProject, $expensesProjectAmount, $expensesElectricAmount, $expensesWaterAmount,  $financeNote, $collectionID]);
    echo "<script>alert('Record Updated!'); window.location.href = '../expenses.php';</script>";
}

// DELETE FINANCE-Expenses
if (isset($_POST['submit_delete_expenses'])) {
    $collectionID = $_POST['collectionID'];
    $query = "DELETE FROM new_finance WHERE financeID=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$collectionID]);
    echo "<script>alert('Deleted Successfully!'); window.location.href = '../expenses.php';</script>";
    exit;
}

// ADD FINANCE-Deposit
if (isset($_POST['add_deposit'])) {

    $financeBrgyID = $_POST['brgyID'];
    $financeLabel = 'deposit';
    // Deposits

    $depositDate = $_POST['depositDate'];
    $depositBank = $_POST['depositBank'];
    $depositReference = $_POST['depositReference'];
    $depositAmount = $_POST['depositAmount'];



    $sql = "INSERT INTO new_finance (financeBrgyID, depositDate, depositBank, depositReference, depositAmount, financeLabel) 
        VALUES (:financeBrgyID, :depositDate, :depositBank, :depositReference, :depositAmount, :financeLabel)";

    $params = array(
        ':financeBrgyID' => $financeBrgyID,
        ':depositDate' => $depositDate,
        ':depositBank' => $depositBank,
        ':depositReference' => $depositReference,
        ':depositAmount' => $depositAmount,
        ':financeLabel' => $financeLabel

    );
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header('Location: ../deposits.php');
}

// EDIT FINANCE-Deposits
if (isset($_POST['edit_deposits'])) {

    $collectionID = $_POST['collectionID'];
    $financeNote = $_POST['financeNote'];

    $depositDate = $_POST['depositDate'];
    $depositBank = $_POST['depositBank'];
    $depositReference = $_POST['depositReference'];
    $depositAmount = $_POST['depositAmount'];


    $query = "UPDATE new_finance SET depositDate=?, depositBank=?, depositReference=?, depositAmount=?, financeNote=?
        WHERE financeID=?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$depositDate, $depositBank, $depositReference, $depositAmount, $financeNote, $collectionID]);
    echo "<script>alert('Record Updated!'); window.location.href = '../deposits.php';</script>";
}

// DELETE FINANCE-Expenses
if (isset($_POST['submit_delete_deposits'])) {
    $collectionID = $_POST['collectionID'];
    $query = "DELETE FROM new_finance WHERE financeID=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$collectionID]);
    echo "<script>alert('Deleted Successfully!'); window.location.href = '../deposits.php';</script>";
    exit;
}
