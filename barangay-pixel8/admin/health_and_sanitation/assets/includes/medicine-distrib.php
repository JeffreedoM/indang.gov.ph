<?php

if (isset($_POST['submitRecord'])) {
    $medicine_name = $_POST['medicine_name'];
    $medicine_quantity = $_POST['medicine_quantity'];
    $resident = $_POST['resident_name'];
    $date = date('Y-m-d', strtotime($_POST['date']));

    // availability variable 

    $NotAvailable = "Out of Stock";


    $conn = new mysqli('localhost','root','','bmis');

    if($conn->connect_error){
        die('Connection Failed'.$conn->connect_error);
    }else{

        $inventory_quantity = $conn->prepare("SELECT medicine_quantity FROM medicine_inventory WHERE ID =?");
        $inventory_quantity->bind_param("i", $medicine_name);
        $inventory_quantity->execute();
        $inventory_quantity->store_result();
        $inventory_quantity->bind_result($current_quantity);
        $inventory_quantity->fetch();

        // Check if record already exists
        $check_stmt = $conn->prepare("SELECT medicine_quantity FROM medicine_inventory WHERE ID = ?");
        $check_stmt->bind_param("i", $medicine_name);
        $check_stmt->execute();
        $check_stmt->store_result();

     
            if($check_stmt->num_rows > 0) {
                if($medicine_quantity > $current_quantity){
                    echo '<script>alert("Error: Quantity to distribute is greater than current stock.");</script>';
                }else{
                    $inventory_quantity = $current_quantity - $medicine_quantity;

                    $update_stmt = $conn->prepare("UPDATE medicine_inventory SET medicine_quantity = ? WHERE ID = ?");
                    $update_stmt->bind_param("ii", $inventory_quantity, $medicine_name);
                    $update_stmt->execute();
                    $update_stmt->close();

                    $stmt2 = $conn-> prepare("INSERT INTO medicine_distribution(medicine_id, distrib_quantity, resident_id, distrib_date) VALUES (?,?,?,?)");
                    $stmt2 -> bind_param("siss", $medicine_name, $medicine_quantity, $resident, $date);
                    $stmt2 ->execute();
                    $stmt2->close();
                }
            }

            // select from MEDICINE_AVAILABILITY VALUE

            $inventory_availability = $conn->prepare("SELECT  medicine_quantity FROM medicine_inventory WHERE ID =?");
            $inventory_availability->bind_param("i", $medicine_name);
            $inventory_availability->execute();
            $inventory_availability->store_result();
            $inventory_availability->bind_result($status);
            $inventory_availability->fetch();
            
            if ($status === 0) {
                $status_update = $conn->prepare("UPDATE medicine_inventory SET medicine_availability = ? WHERE ID = ?");
                $status_update->bind_param("si", $NotAvailable, $medicine_name);
                $status_update->execute();
                $status_update->close();
            }

        }
}




?>