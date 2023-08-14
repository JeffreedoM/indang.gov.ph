<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';

// session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $middlename = trim($_POST['middlename']);
    $lastname = trim($_POST['lastname']);
    $suffix = $_POST['suffix'] ?? "";
    $sex = $_POST['sex'];
    $bdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $civil_status = $_POST['civil_status'];
    $contact_type = $_POST['contact_type'] ?? "";
    $contact = $_POST['contact'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $citizenship = $_POST['citizenship'];
    $citizenship = ucwords($citizenship);
    $religion = $_POST['religion'];
    $occupation_status = $_POST['res_occupation-status'];
    $occupation = $_POST['occupation'];

    /* resident address */
    $house = $_POST['house'];
    $street = $_POST['street'];

    /* For File Image */
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
    $fileDestination =  '../assets/images/uploads/' . $fileNameNew;
    // $fileDestination =  './assets/images/uploads/' . $fileNameNew;
    move_uploaded_file($fileTmpName, $fileDestination);

    // $address = "$house $building $barangay";


    $sql = "INSERT INTO resident (
        barangay_id,
        firstname,
        middlename,
        lastname,
        suffix,
        sex,
        birthdate,
        -- age,
        civil_status,
        contact_type,
        contact,
        height,
        weight,
        citizenship,
        religion,
        occupation_status,
        occupation,
        house,
        street,
        image
    ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $barangayId, $firstname, $middlename, $lastname, $suffix, $sex, $bdate, $civil_status, $contact_type, $contact, $height, $weight, $citizenship, $religion, $occupation_status, $occupation, $house,
        $street, $fileNameNew
    ]);

    $resident_id = $pdo->lastInsertId();
    if ($age >= 0 && $age <= 1) {

        /* Insert newborn to newborn table */
        $stmt = $pdo->prepare("INSERT INTO hns_newborn (resident_id) VALUES (:resident_id)");
        $stmt->bindParam(':resident_id', $resident_id);
        $stmt->execute();
    }
    /* echo "<script>
    alert('Successfully added resident!');
    window.location.href='../../resident-view.php?id=.$pdo->lastInserted()';
    </script>"; */

    $redirect_url = "../resident-view.php?id=" . $resident_id;
    echo '<script>window.location.href = "' . $redirect_url . '";</script>';
    exit;
}
