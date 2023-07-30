<?php

if (isset($_POST['submit_edit'])) {
    $currentId = $_POST['medicine_id'];
    $quantity = $_POST['medicine_quantity'];
    $desc = $_POST['medicine_description'];


    $conn = new mysqli('localhost', 'root' , '' , 'bmis');

    if ($conn->connect_error) {
        die('Connection Failed'.$conn->connect_error);
    } else {
        $update_stmt = $conn->prepare("UPDATE medicine_inventory SET medicine_quantity = ?, medicine_description = ? WHERE ID = ?");
        $update_stmt->bind_param("isi", $quantity, $desc, $currentId);
        $update_stmt->execute();
        $update_stmt->close();


    // redirecting to the page itself
    header('Location: ../../index.php' ); 
    exit();
    }       
 

}

?>