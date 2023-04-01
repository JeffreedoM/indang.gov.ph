<?php

include 'dbh.inc.php';
define('SITE_ROOT', realpath(dirname(__FILE__)));

if (isset($_POST['submit'])) {

    $brgyName = $_POST['brgy-name'];
    $brgyAddress = $_POST['brgy-address'];
    $brgyFullAddress = "$brgyAddress Indang, Cavite";

    $brgyFolderName = strtolower(str_replace(" ", "-", $brgyName));
    $brgyLink = 'indang.gov.ph/' . $brgyFolderName;

    $firstName = $_POST['firstname'];
    $middleName = $_POST['middlename'];
    $lastName = $_POST['lastname'];

    $fullName = "$firstName $middleName $lastName";

    $username = $_POST['username'];
    $password = $_POST['password'];



    // for Barangay Logo
    $file = $_FILES['image'];

    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    // $fileType = $_FILES['image']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    // if the file extenstion is allowed
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            //if there is no error uploading the file
            if ($fileSize < 5000000) {  // 5mb
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                // $fileDestination = 'assets/images/uploads/barangay-logos/' . $fileNameNew;
                $fileDestination =  'assets/images/uploads/barangay-logos/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                // file is successfully uploaded

            } else {
                //if the file size is too big
?>
                <script>

                </script>
<?php
                echo 'file size is too big';
            }
        } else {
            // if there is an error uploading the file
            echo 'error uploading file';
        }
    } else {
        //if the file extension is not allowed
        echo 'file extension is not allowed';
    }

    // $sql = "UPDATE total SET total_expenses = total_expenses + ?";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([$expenses]);

    $sql = "INSERT INTO barangay (b_name, b_address, b_logo, b_link, admin_name, admin_user, admin_pass) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$brgyName, $brgyFullAddress, $fileNameNew, $brgyLink, $fullName, $username, $password]);
}
