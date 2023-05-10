<?php
 if (isset($_POST['deletebtn'])) {
    $clearancename = $_POST['id'];
    $conn = new mysqli('localhost', 'root', '', 'bmis');
 
if ($conn->connect_error){
    die('Connection Failed' .$conn->connect_error); 
   }else {  
    $stmt= $conn->prepare("DELETE FROM clearance where clearance_name = ?");
    $stmt->bind_param("s", $clearancename);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
header('Location: ' . $_SERVER['PHP_SELF']); 
exit();
 }
?>


<!-- Delete pop up -->
<div class="delete-clearance" id="modal2" >
                <div class="delete-content" id="popup2">
                    <h1>Do you want to delete?</h1>
                    <div class="delete-button">
                    <form action="" method="POST">                   
                        <button type="submit" name="YES" class="deleteButton" onclick="closePopup2()">
                            YES
                        </button>
                        <button type="submit" name="NO" class="deleteButton" onclick="closePopup2()">
                            NO
                        </button>                    
                    </form>
                    </div>
                </div>
            </div>
