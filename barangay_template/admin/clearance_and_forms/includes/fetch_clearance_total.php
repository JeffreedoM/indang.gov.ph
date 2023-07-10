<?php 

    $conn = new mysqli('localhost', 'root', '', 'bmis');

if ($conn->connect_error){
    die('Connection Failed' .$conn->connect_error);
}else{
    $id = $_GET['id'];
    $sql = mysqli_query($conn, "SELECT * FROM clearance_total WHERE clearance_id=$id");
    $user = mysqli_fetch_assoc($sql);

    $clearanceQuantity = isset($user['distrib_quantity']) ? $user['distrib_quantity'] : 0;

    echo $clearanceQuantity;
}


?>