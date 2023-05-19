<?php


if(isset($_POST['submitRecord'])) {
    $clearancename = $_POST['clearance_name'];
    $residentname = $_POST['resident_name'];
    $purpose = $_POST['purpose'];





    $conn = new mysqli('localhost','root','','bmis');

    if($conn->connect_error){
        die('Connection Failed'.$conn->connect_error);
    }else{

            $clearance_quantity = $conn->prepare("SELECT distrib_quantity FROM clearance_total WHERE clearance_id = ?");
            $clearance_quantity->bind_param("i", $clearancename);
            $clearance_quantity->execute();
            $clearance_quantity->store_result();
            $clearance_quantity->bind_result($current_quantity);
            $clearance_quantity->fetch();

            // clearance_price fetch 

            $clearance_price = $conn->prepare("SELECT clearance_amount FROM clearance WHERE clearance_id = ?");
            $clearance_price->bind_param("i", $clearancename);
            $clearance_price->execute();
            $clearance_price->store_result();
            $clearance_price->bind_result($current_price);
            $clearance_price->fetch();
            
            // checking stmt query

            $check_stmt = $conn->prepare("SELECT distrib_quantity FROM clearance_total WHERE clearance_id = ?");
            $check_stmt->bind_param("i", $clearancename);
            $check_stmt->execute();
            $check_stmt->store_result();

            if($check_stmt->num_rows > 0) {               
                $new_quantity = $current_quantity + 1;
                $total_price = $current_price * $new_quantity;

                $update_stmt = $conn->prepare("UPDATE clearance_total SET distrib_quantity = ?, distrib_total = ? WHERE clearance_id = ? AND barangay_id = $barangayId");
                $update_stmt->bind_param("iii",  $new_quantity, $total_price, $clearancename);
                $update_stmt->execute();
                $update_stmt->close();
            }else{
                $clearance_quantity = 1;
                $total_price = $current_price;

                $update_stmt = $conn->prepare("INSERT into clearance_total(clearance_id, barangay_id, distrib_quantity, distrib_total)VALUES (?,?,?,?)");
                $update_stmt->bind_param("siii", $clearancename, $barangayId, $clearance_quantity, $total_price);
                $update_stmt->execute();
                $update_stmt->close();
            

                
            } 

             $insert_stmt = $conn->prepare("INSERT into clearance_release(clearance_id, resident_id, barangay_id, purpose) VALUES (?,?,?,?)");
             $insert_stmt-> bind_param("ssis", $clearancename, $residentname, $barangayId, $purpose);
             $insert_stmt-> execute();
             $insert_stmt-> close();


        

        
    }
}



?>