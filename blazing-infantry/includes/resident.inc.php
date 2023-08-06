<?php

require_once 'dbh.inc.php';

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $suffix = $_POST['suffix']; // di ko pa alam to
    $sex = $_POST['sex'];
    $bdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $civil_status = $_POST['civil_status'];
    $contact_type = $_POST['contact_type'];
    $contact = $_POST['contact'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $religion = $_POST['religion'];
    $occupation_status = $_POST['res_occupation-status'];
    $occupation = $_POST['occupation'];

    /* resident Image */
    // $resImage = $_FILES['res_img'];
    // $fileName = $_FILES['res_img']['name'];
    // $fileTmpName = $_FILES['res_img']['tmp_name'];
    // $fileSize = $_FILES['res_img']['size'];
    // $fileError = $_FILES['res_img']['error'];
    // $fileType = $_FILES['res_img']['type'];

    // $fileExt = explode('.', $fileName);
    // $fileActualExt = strtolower(end($fileExt));

    // $allowed = array('jpg', 'jpeg', 'png');

    // if (in_array($fileActualExt, $allowed)) {
    //     if ($fileError === 0) {
    //         /* if ($fileSize < 5000000) {
    //         } else {
    //             echo "The image size is too big!";
    //         } */
    //         $fileNameNew = uniqid('', true) . "." . $fileActualExt;
    //         $fileDestination = "../images/uploads/res_images/$filenameNew";
    //         move_uploaded_file($fileTmpName, $fileDestination);
    //     } else {
    //         echo "There was an error uploading your file!";
    //     }
    // } else {
    //     echo "You cannot upload files of this type!";
    // }


    /* resident address */
    $house = $_POST['house'];
    $building = $_POST['building'];
    $barangay = $_POST['barangay'];

    $fullname = "$firstname $middlename $lastname";
    $address = "$house $building $barangay";

    $sql = "INSERT INTO resident (
        fullname,
        sex,
        birthdate,
        age,
        civil_status,
        contact_type,
        contact,
        height,
        weight,
        religion,
        occupation_status,
        occupation,
        address
    ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fullname, $sex, $bdate, $age, $civil_status, $contact_type, $contact, $height, $weight, $religion, $occupation_status, $occupation, $address]);

    /* echo "<script>
    alert('Successfully added resident!');
    window.location.href='../../resident-view.php?id=.$pdo->lastInserted()';
    </script>"; */

    header("Location: ../resident-view.php?id=" . $pdo->lastInsertId());
}
