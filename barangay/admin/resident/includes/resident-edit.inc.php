<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';

if (isset($_POST['submit'])) {
    $resident_id = $_POST['resident_id'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $suffix = $_POST['suffix'];
    $sex = $_POST['sex'];
    $bdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $civil_status = $_POST['civil_status'];
    $contact_type = $_POST['contact_type'];
    $contact = $_POST['contact'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $citizenship = $_POST['citizenship'];
    $religion = $_POST['religion'];
    $occupation_status = $_POST['res_occupation-status'];
    $occupation = $_POST['occupation'];

    /* For File Image */
    if (!empty($_FILES['image']['name'])) {

        $resident = $pdo->query("SELECT * FROM resident WHERE resident_id='$resident_id'")->fetch();
        $imageName = $resident['image'];
        if (empty($imageName)) {
            // If the image is empty, upload the new file and update the table_column value
            $fileName = $_FILES['image']['name'];
            $fileTmpName = $_FILES['image']['tmp_name'];
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $fileNameNew = uniqid('', true) . "." . $fileActualExt;
            $fileDestination = '../assets/images/uploads/' . $fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
            $pdo->query("UPDATE resident SET image='$fileNameNew' WHERE resident_id=$resident_id");
        } else {
            // If the image is not empty, delete the old file and upload the new file
            $fileToDelete = '../assets/images/uploads/' . $imageName;
            unlink($fileToDelete);
            $fileName = $_FILES['image']['name'];
            $fileTmpName = $_FILES['image']['tmp_name'];
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $fileNameNew = uniqid('', true) . "." . $fileActualExt;
            $fileDestination = '../assets/images/uploads/' . $fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
            $pdo->query("UPDATE resident SET image='$fileNameNew' WHERE resident_id=$resident_id");
        }
    }


    $address = $_POST['address'];

    $sql = "UPDATE resident SET 
        firstname = ?,
        middlename = ?,
        lastname = ?,
        suffix = ?,
        sex = ?,
        birthdate = ?,
        age = ?,
        civil_status = ?,
        contact_type = ?,
        contact = ?,
        height = ?,
        weight = ?,
        citizenship =?,
        religion = ?,
        occupation_status = ?,
        occupation = ?,
        address = ?
        -- image = ?
    WHERE resident_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$firstname, $middlename, $lastname, $suffix, $sex, $bdate, $age, $civil_status, $contact_type, $contact, $height, $weight, $citizenship, $religion, $occupation_status, $occupation, $address, $resident_id]);

    /* echo "<script>
    alert('Successfully added resident!');
    window.location.href='../../resident-view.php?id=.$pdo->lastInserted()';
    </script>"; */

    header('Location: ../resident-view.php?id=' . $resident_id);
}
