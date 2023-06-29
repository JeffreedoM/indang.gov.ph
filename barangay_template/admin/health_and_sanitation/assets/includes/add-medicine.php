<?php

include '../../includes/deactivated.inc.php';

if (isset($_POST['submitRecord'])) {
    $medicine_name = $_POST['medicine_name'];
    $medicine_quantity = $_POST['medicine_quantity'];
    $exp_date = date('Y-m-d', strtotime($_POST['expiration_date']));
    $medicine_desc = $_POST['medicine_description'];

    // stock availability 

    $isAvailable = "Available";
    $notAvailable = "Out of Stock";

    $conn = new mysqli('localhost', 'root', '', 'bmis');

    if ($conn->connect_error) {
        die('Connection Failed' . $conn->connect_error);
    } else {
        // Check if record already exists
        $check_stmt = $conn->prepare("SELECT medicine_quantity FROM medicine_inventory WHERE medicine_name = ? AND medicine_expiration = ?");
        $check_stmt->bind_param("ss", $medicine_name, $exp_date);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // If record exists, update the quantity
            $check_stmt->bind_result($existing_quantity);
            $check_stmt->fetch();
            $medicine_quantity += $existing_quantity;

            $update_stmt = $conn->prepare("UPDATE medicine_inventory SET medicine_quantity = ? WHERE medicine_name = ? AND medicine_expiration = ?");
            $update_stmt->bind_param("iss", $medicine_quantity, $medicine_name, $exp_date);
            $update_stmt->execute();
            $update_stmt->close();

            // update medicine_availability value
            if ($medicine_quantity > 0) {
                $update_status = $conn->prepare("UPDATE medicine_inventory SET medicine_availability = ? WHERE medicine_name = ? AND medicine_expiration = ?");
                $update_status->bind_param("sss", $isAvailable, $medicine_name, $exp_date);
                $update_status->execute();
                $update_status->close();
            } else {
                $update_status = $conn->prepare("UPDATE medicine_inventory SET medicine_availability = ? WHERE medicine_name = ? AND medicine_expiration = ?");
                $update_status->bind_param("sss", $notAvailable, $medicine_name, $exp_date);
                $update_status->execute();
                $update_status->close();
            }
        } else {
            // If record does not exist, insert new record
            $insert_stmt = $conn->prepare("INSERT INTO medicine_inventory (medicine_name, medicine_quantity, medicine_expiration, medicine_description, medicine_availability, barangay_id) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param('sisssi', $medicine_name, $medicine_quantity, $exp_date, $medicine_desc, $isAvailable, $barangayId);
            $insert_stmt->execute();
            $insert_stmt->close();
        }




        $check_stmt->close();
        $conn->close();
    }

    // redirecting to the page itself
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
