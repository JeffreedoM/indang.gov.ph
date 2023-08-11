<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $sex = $_POST['sex'];
    $bdate = $_POST['birthdate'];
    // Prepare and execute a query to find residents with similar attributes
    $sql = "SELECT * FROM resident WHERE firstname = :firstname AND lastname = :lastname AND sex = :sex AND birthdate = :birthdate AND barangay_id = :barangay_id";
    $stmt = $pdo->prepare($sql);

    // Define an array with the parameter values for binding
    $params = array(
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':sex' => $sex,
        ':birthdate' => $bdate,
        ':barangay_id' => $barangayId
    );

    // Bind the parameters from the array
    $stmt->execute($params);

    // Fetch the result, if any
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Send JSON response indicating whether a duplicate was found
    echo json_encode(['duplicate' => ($result !== false), 'result' => $result]);
    exit;
}
