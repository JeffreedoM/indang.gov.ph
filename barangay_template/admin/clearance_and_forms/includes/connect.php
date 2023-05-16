<?php

       if (isset($_POST['submit'])) {
            $clearancename = $_POST['clearancename'];
            $clearanceamount = $_POST['clearanceamount'];
            $conn = new mysqli('localhost', 'root', '', 'bmis');

        if ($conn->connect_error){
            die('Connection Failed' .$conn->connect_error);
        }else{
            $stmt= $conn->  prepare("INSERT INTO clearance(clearance_name, clearance_amount) values(?,?)");
            $stmt->bind_param("sd", $clearancename, $clearanceamount);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        
        header('Location: ' . $_SERVER['PHP_SELF']); 
        exit();
       
        }


    
    // database connection



