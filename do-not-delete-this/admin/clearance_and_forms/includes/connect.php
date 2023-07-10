<?php

       if (isset($_POST['submit'])) {
            $clearancename = $_POST['clearancename'];
            $conn = new mysqli('localhost', 'root', '', 'bmis');

        if ($conn->connect_error){
            die('Connection Failed' .$conn->connect_error);
        }else{
            $stmt= $conn->  prepare("INSERT INTO clearance(clearance_name) values(?)");
            $stmt->bind_param("s", $clearancename);
            $stmt->execute();
            echo $clearancename." has been added";
            $stmt->close();
            $conn->close();
        }
        
        header('Location: ' . $_SERVER['PHP_SELF']); 
        exit();
       
        }


    
    // database connection



