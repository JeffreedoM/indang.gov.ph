<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
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
    $religion = $_POST['religion'];
    $occupation_status = $_POST['res_occupation-status'];
    $occupation = $_POST['occupation'];

    /* For File Image */
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
    // $fileDestination = 'assets/images/uploads/barangay-logos/' . $fileNameNew;
    $fileDestination =  '../assets/images/uploads/' . $fileNameNew;
    move_uploaded_file($fileTmpName, $fileDestination);


    /* resident address */
    $house = $_POST['house'];
    $building = $_POST['building'];
    $barangay = $_POST['barangay'];

    // $fullname = "$firstname $middlename $lastname";
    $address = "$house $building $barangay";

    $sql = "INSERT INTO resident (
        barangay_id,
        firstname,
        middlename,
        lastname,
        suffix,
        sex,
        birthdate,
        age,
        civil_status,
        contact_type,
        contact,
        height,
        weight,
        citizenship,
        religion,
        occupation_status,
        occupation,
        address,
        image
    ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$barangayId, $firstname, $middlename, $lastname, $suffix, $sex, $bdate, $age, $civil_status, $contact_type, $contact, $height, $weight, $citizenship, $religion, $occupation_status, $occupation, $address, $fileNameNew]);

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

    header("Location: ../resident-view.php?id=" . $resident_id);
}
