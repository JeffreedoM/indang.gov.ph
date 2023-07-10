<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';


// ADD FINANCE
if (isset($_POST['add_finance'])) {
    
    $financeTreasurer = $_POST['financeTreasurer'];     
    $financeRCD = $_POST['financeRCD'];     
    $financeProject2 = $_POST['financeProject'];         
    $financeAmount = $_POST['financeAmount'];     
    $financeDate = $_POST['financeDate'];     
    $financeBrgyID = $_POST['brgyID'];     
    $financeDescription = $_POST['financeDescription'];     

    if ($financeProject2 == ''){
        $financeProject = $_POST['financeOthers'];
    } else{
        $financeProject = $_POST['financeProject'];
    }

    $sql = "INSERT INTO new_finance (financeTreasurer, financeRCD, financeProject, financeAmount, financeDate, financeBrgyID, financeDescription) 
        VALUES (:financeTreasurer, :financeRCD, :financeProject, :financeAmount, :financeDate, :financeBrgyID, :financeDescription)";

    $params = array(
        ':financeTreasurer' => $financeTreasurer,
        ':financeRCD' => $financeRCD,
        ':financeProject' => $financeProject,
        ':financeAmount' => $financeAmount,
        ':financeDate' => $financeDate,
        ':financeBrgyID' => $financeBrgyID,
        ':financeDescription' => $financeDescription);
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header('Location: ../index.php');
}

// EDIT FINANCE
if(isset($_POST['edit_finance'])){
    $id_resident = $_POST['id_resident'];
    $financeProject = $_POST['financeProject'];    
    $financeTreasurer = $_POST['financeTreasurer'];     
    $financeRCD = $_POST['financeRCD'];     
    $financeAmount = $_POST['financeAmount'];     
    $financeDate = $_POST['financeDate'];     
    $financeDescription = $_POST['financeDescription'];    
    

    $query = "UPDATE new_finance SET financeTreasurer=?, financeRCD=?, financeProject=?, financeAmount=?, financeDate=?, financeDescription=?
        WHERE financeID=?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$financeTreasurer, $financeRCD, $financeProject, $financeAmount, $financeDate, $financeDescription, $id_resident]);
    echo "<script>alert('Record Updated!'); window.location.href = '../index.php';</script>";
}

if(isset($_POST['submit_delete_finance'])){
    $id_resident = $_POST['id_resident'];
    $query = "DELETE FROM new_finance WHERE financeID=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_resident]);
    echo "<script>alert('Deleted Successfully!'); window.location.href = '../index.php';</script>";
    exit;
}

