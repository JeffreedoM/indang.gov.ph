<?php

if (isset($_POST['submit'])) {
    $manage_name = $_POST['manage_name'];
    $manage_desc = $_POST['manage_desc'];
 

    $conn = new mysqli('localhost', 'root' , '' , 'bmis');

    if ($conn->connect_error) {
        die('Connection Failed'.$conn->connect_error);
    } else {

         // Check if record already exists
        $select_stmt = $conn->prepare("SELECT * FROM medicine_management WHERE manage_name = ?");
        $select_stmt->bind_param("s", $manage_name);
        $select_stmt->execute();
        $result = $select_stmt->get_result();
 
         if ($result->num_rows > 0) {
            // Data already exists, display JavaScript prompt
            echo "<script>";
            echo "alert('Data already exists');";
            echo "</script>";
        } else {

        $insert_stmt = $conn->prepare("INSERT INTO medicine_management (manage_name, manage_desc) VALUES (?, ?)");
        $insert_stmt->bind_param("ss", $manage_name, $manage_desc);
        $insert_stmt->execute();
        $insert_stmt->close();

            // redirecting to the page itself
        header('Location: ' . $_SERVER['PHP_SELF']); 
        exit();

        }

        $select_stmt->close();
        $conn->close();
    }

    

}

?>