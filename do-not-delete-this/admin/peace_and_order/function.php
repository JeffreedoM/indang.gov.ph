<?php


// function checklogin($con){
//     if(isset($_SESSION['user_id'])){
        
//         $id = $_SESSION['user_id'];
//         $query = "SELECT * FROM login WHERE user_id = '$id' limit 1";

//         $result = mysqli_query($con, $query);
//         if($result && mysqli_num_rows($result) > 0){
//             $user_data =mysqli_fetch_assoc($result);
//             return $user_data;
//         }
//     }
//     header("location: login.php");
//     die;
// }
// function addFriend($con){
//         $query = "SELECT * FROM login";

//         $result = mysqli_query($con, $query);
//         if($result){
//             while($row = mysqli_fetch_assoc($result)){
//             $fname = $row['fname'];
//             $lname = $row['lname'];
//             $email = $row['email'];

            
//             }return $row;
        
//     }

// }


// function random_num($length){

//     $text ="";
//     if($length > 5){
//         $length = 5;
//     }

//     $len = rand(4, $length);

//     for($i=0; $i<$len; $i++){
//         $text .= rand(0,9);
//     }
//     return $text;

// }

function res_type(){

    
    if($resident = 1){
        echo "Resident";
    }
    else if($resident = 2){
        echo "Non-Resident";
    }
}

function sort_as(){
 
    if(isset($_POST["sort_as"])){
        sort($id);
    }
}
?>

