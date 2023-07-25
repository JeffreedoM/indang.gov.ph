<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/deactivated.inc.php';

// if (isset($_POST['submit_mother'])) {
//     $mother_id = $_POST['mother_id'];
//     $resident_id = $_POST['resident_id'];

//     // Check if mother_id exists in resident_family table
//     $stmt = $pdo->prepare("SELECT family_id FROM resident_family WHERE mother_id = :mother_id");
//     $stmt->bindParam(':mother_id', $mother_id, PDO::PARAM_INT);
//     $stmt->execute();
//     $family_id = $stmt->fetchColumn();


//     if ($family_id !== false) {
//         echo 'mother exists';
//         // Mother exists in resident_family table
//         // Add family_id value for the resident
//         $stmt = $pdo->prepare("UPDATE resident SET family_id = :family_id WHERE resident_id = :resident_id");
//         $stmt->bindParam(':family_id', $family_id, PDO::PARAM_INT);
//         $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
//         $stmt->execute();
//     } else {
//         echo 'mother does not exists';
//         // Mother does not exist in resident_family table
//         // Check if the resident already has a family
//         $stmt = $pdo->prepare("SELECT family_id FROM resident WHERE resident_id = :resident_id");
//         $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
//         $stmt->execute();
//         $family_id = $stmt->fetchColumn();


//         if ($family_id !== null) {
//             echo 'may family na';
//             // Resident already has a family, update the mother_id in resident_family
//             $stmt = $pdo->prepare("UPDATE resident_family SET mother_id = :mother_id WHERE family_id = :family_id");
//             $stmt->bindParam(':mother_id', $mother_id, PDO::PARAM_INT);
//             $stmt->bindParam(':family_id', $family_id, PDO::PARAM_INT);
//             $stmt->execute();
//         } else {
//             echo 'wala pang family';
//             // Insert the mother_id and retrieve the generated family_id
//             $stmt = $pdo->prepare("INSERT INTO resident_family (mother_id) VALUES (:mother_id)");
//             $stmt->bindParam(':mother_id', $mother_id, PDO::PARAM_INT);
//             $stmt->execute();

//             // Retrieve the generated family_id
//             $family_id = $pdo->lastInsertId();

//             // Add family_id value for the resident
//             $stmt = $pdo->prepare("UPDATE resident SET family_id = :family_id WHERE resident_id = :resident_id");
//             $stmt->bindParam(':family_id', $family_id, PDO::PARAM_INT);
//             $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
//             $stmt->execute();
//         }
//     }

//     header("Location: ../resident-view.php?id=$resident_id");
// }

// if (isset($_POST['submit_father'])) {
//     $father_id = $_POST['father_id'];
//     $resident_id = $_POST['resident_id'];

//     // Check if father_id exists in resident_family table
//     $stmt = $pdo->prepare("SELECT family_id FROM resident_family WHERE father_id = :father_id");
//     $stmt->bindParam(':father_id', $father_id, PDO::PARAM_INT);
//     $stmt->execute();
//     $family_id = $stmt->fetchColumn();

//     if ($family_id !== false) {
//         // Father exists in resident_family table
//         // Add family_id value for the resident
//         $stmt = $pdo->prepare("UPDATE resident SET family_id = :family_id WHERE resident_id = :resident_id");
//         $stmt->bindParam(':family_id', $family_id, PDO::PARAM_INT);
//         $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
//         $stmt->execute();
//     } else {
//         // Father does not exist in resident_family table
//         // Check if the resident already has a family
//         $stmt = $pdo->prepare("SELECT family_id FROM resident WHERE resident_id = :resident_id");
//         $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
//         $stmt->execute();
//         $family_id = $stmt->fetchColumn();

//         if ($family_id !== null) {
//             // Resident already has a family, update the father_id in resident_family
//             $stmt = $pdo->prepare("UPDATE resident_family SET father_id = :father_id WHERE family_id = :family_id");
//             $stmt->bindParam(':father_id', $father_id, PDO::PARAM_INT);
//             $stmt->bindParam(':family_id', $family_id, PDO::PARAM_INT);
//             $stmt->execute();
//         } else {
//             // Insert the father_id and retrieve the generated family_id
//             $stmt = $pdo->prepare("INSERT INTO resident_family (father_id) VALUES (:father_id)");
//             $stmt->bindParam(':father_id', $father_id, PDO::PARAM_INT);
//             $stmt->execute();

//             // Retrieve the generated family_id
//             $family_id = $pdo->lastInsertId();

//             // Add family_id value for the resident
//             $stmt = $pdo->prepare("UPDATE resident SET family_id = :family_id WHERE resident_id = :resident_id");
//             $stmt->bindParam(':family_id', $family_id, PDO::PARAM_INT);
//             $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
//             $stmt->execute();
//         }
//     }

//     header("Location: ../resident-view.php?id=$resident_id");
// }


if (isset($_POST['submit_mother'])) {
    $mother_id = $_POST['mother_id'];
    $resident_id = $_POST['resident_id'];

    // Check if the resident already has a family
    $stmt = $pdo->prepare("SELECT family_id FROM resident WHERE resident_id = :resident_id");
    $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
    $stmt->execute();
    $family_id = $stmt->fetchColumn();


    if ($family_id !== null) {
        // echo 'may family na';
        // Resident already has a family, update the mother_id in resident_family
        $stmt = $pdo->prepare("UPDATE resident_family SET mother_id = :mother_id WHERE family_id = :family_id");
        $stmt->bindParam(':mother_id', $mother_id, PDO::PARAM_INT);
        $stmt->bindParam(':family_id', $family_id, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        // echo 'wala pang family';
        // Insert the mother_id and retrieve the generated family_id
        $stmt = $pdo->prepare("INSERT INTO resident_family (mother_id) VALUES (:mother_id)");
        $stmt->bindParam(':mother_id', $mother_id, PDO::PARAM_INT);
        $stmt->execute();

        // Retrieve the generated family_id
        $family_id = $pdo->lastInsertId();

        // Add family_id value for the resident
        $stmt = $pdo->prepare("UPDATE resident SET family_id = :family_id WHERE resident_id = :resident_id");
        $stmt->bindParam(':family_id', $family_id, PDO::PARAM_INT);
        $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    header("Location: ../resident-view.php?id=$resident_id");
}


if (isset($_POST['submit_father'])) {
    $father_id = $_POST['father_id'];
    $resident_id = $_POST['resident_id'];

    //    Check if the resident already has a family
    $stmt = $pdo->prepare("SELECT family_id FROM resident WHERE resident_id = :resident_id");
    $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
    $stmt->execute();
    $family_id = $stmt->fetchColumn();

    if ($family_id !== null) {
        // Resident already has a family, update the father_id in resident_family
        $stmt = $pdo->prepare("UPDATE resident_family SET father_id = :father_id WHERE family_id = :family_id");
        $stmt->bindParam(':father_id', $father_id, PDO::PARAM_INT);
        $stmt->bindParam(':family_id', $family_id, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        // Insert the father_id and retrieve the generated family_id
        $stmt = $pdo->prepare("INSERT INTO resident_family (father_id) VALUES (:father_id)");
        $stmt->bindParam(':father_id', $father_id, PDO::PARAM_INT);
        $stmt->execute();

        // Retrieve the generated family_id
        $family_id = $pdo->lastInsertId();

        // Add family_id value for the resident
        $stmt = $pdo->prepare("UPDATE resident SET family_id = :family_id WHERE resident_id = :resident_id");
        $stmt->bindParam(':family_id', $family_id, PDO::PARAM_INT);
        $stmt->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    header("Location: ../resident-view.php?id=$resident_id");
}
