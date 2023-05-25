<?php

if (isset($_POST['submit'])) {
    $medicine_name = $_POST['medicine_id'];
    $medicine_quantity = $_POST['medicine_quantity'];
    $exp_date = date('Y-m-d', strtotime($_POST['expiration_date']));

    // stock availability 

    $isAvailable = "Available";
    $notAvailable = "Out of Stock";

    $conn = new mysqli('localhost', 'root' , '' , 'bmis');

    if ($conn->connect_error) {
        die('Connection Failed'.$conn->connect_error);
    } else {

      
        // Fetch existing batch
        $batchQuery = $conn->prepare("SELECT MAX(batch_id) FROM medicine_inventory WHERE manage_id = ?");
        $batchQuery->bind_param("s", $medicine_name);
        $batchQuery->execute();
        $batchQuery->store_result();
        $batchQuery->bind_result($current_batch);
        $batchQuery->fetch();
        $batchQuery->close();

        // Check if record already exists
        $checkQuery = $conn->prepare("SELECT * FROM medicine_inventory WHERE manage_id = ? AND medicine_expiration = ? AND batch_id = ?");
        $checkQuery->bind_param("ssi", $medicine_name, $exp_date, $current_batch);
        $checkQuery->execute();
        $checkQuery->store_result();

        if ($checkQuery->num_rows > 0) {
            // Existing batch
            $quantityQuery = $conn->prepare("SELECT medicine_quantity FROM medicine_inventory WHERE manage_id = ? AND medicine_expiration = ?");
            $quantityQuery->bind_param("ss", $medicine_name, $exp_date);
            $quantityQuery->execute();
            $quantityQuery->store_result();
            $quantityQuery->bind_result($existing_quantity);
            $quantityQuery->fetch();
            $quantityQuery->close();

            $medicine_quantity += $existing_quantity;

            // Update quantity and availability
            $update_stmt = $conn->prepare("UPDATE medicine_inventory SET medicine_quantity = ?, medicine_availability = CASE WHEN ? > 0 THEN ? ELSE ? END WHERE manage_id = ? AND medicine_expiration = ? AND batch_id = ?");
            $update_stmt->bind_param("iissssi", $medicine_quantity, $medicine_quantity, $isAvailable, $notAvailable, $medicine_name, $exp_date, $current_batch);
            $update_stmt->execute();
            $update_stmt->close();
        } else {
            // New batch
            $newBatchId = $current_batch + 1;

            // Insert new record
            $insert_stmt = $conn->prepare("INSERT INTO medicine_inventory (manage_id, batch_id, medicine_quantity, medicine_expiration, medicine_availability) VALUES (?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("siiss", $medicine_name, $newBatchId, $medicine_quantity, $exp_date, $isAvailable);
            $insert_stmt->execute();
            $insert_stmt->close();
        }

        $checkQuery->close();
        $conn->close();



    
    }

    // redirecting to the page itself
    header('Location: ' . './medicine-inventory.php'); 
    exit();
}



?>