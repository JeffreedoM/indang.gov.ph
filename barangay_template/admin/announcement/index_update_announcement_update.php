<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
$conn = mysqli_connect("localhost","root","","bmis");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
	  <link rel="stylesheet" href="announcement.css" />
     
    <title>Admin Panel</title>

</head>

<body>
    <?php
    include '../../partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include '../../partials/nav_header.php';
        ?>

        <!-- Container -->
        <div class="wrapper">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title"><?php echo $barangayName . "  " ?>Announcement Module</h3>
            </div>
 <!-- navigation menu -->


  <div class="container">
    <br><br><br>
  
			
            <button class="index-btn" onclick="redirectToIndexAnnouncement()">Create a Index Announcement</button>
            <button class="update-index-btn" onclick="redirectToIndexUpdateAnnouncement()">Update Announcement</button>
            <button class="modal-btn"  onclick="openModal()">Create a SMS Announcement</button> 
			<div id="myModal" class="modal">
			<div class="modal-content">
				<span class="close" onclick="closeModal()">&times;</span>

				<form action="form_action.php" method="POST">
				<h2>Automated SMS</h2>
        <div class="form-group">
        <label for="date">Date:</label>
        <input type="" id="date" name="date" readonly class="borderless">
        </div>
        <div class="form-group">
        
        </div>
				<div class="form-group">
					<label for="message">Message to Recipient:</label> <br>
          <textarea name="message" class="textarea" id="msg" required> </textarea>
				
				</div>
				<div class="form-group">
					<label for="category">Category for Recipients:</label>
					<select id="category" name="category" class="form-control" required>
					<option value="">-- Select Category --</option>
					<option value="Resident">Residents</option>
					<option value="Senior">Senior</option>
					<option value="Barangay_Official">Barangay Officials</option>
					</select>
				</div>
				<input type="submit" name = "submit" class="btn btn-primary" value="Send_SMS">
				</form>
			</div>
			</div>
      
      
</div>
<br><br>

<div class="container-2">
<h2 style="text-align: center;">Update Index Announcement</h2>


</div>
<br><br>
<div class="container" style="display: flex; justify-content: center; align-items: center;">
 




<?php
if (isset($_GET['announcement_id'])) {
    $id = $_GET['announcement_id'];

    $dislayresult = "SELECT * 
                      FROM announcement a 
                      INNER JOIN barangay b 
                      ON a.brgy_id = b.b_id 
                      WHERE a.announcement_id = $id;";
                   // Execute the query
        $result_id = $conn->query($dislayresult);
        
        // Check if the query was successful and fetch the row
        if ( $result_id &&  $result_id->num_rows > 0) {
            $row_result =  $result_id->fetch_assoc();

            ?>





<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $a_title = $_POST['announcement_title'];
    $a_what = $_POST['announcement_what'];
    $a_where = $_POST['announcement_where'];
    $a_when = $_POST['announcement_when'];
    $a_msg = $_POST['announcement_message'];
    
    $image_filename = $_FILES['announcement_photo']['name'];
 

   


    $fileExt = explode('.', $image_filename);
    $fileActualExt = strtolower(end($fileExt));
    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
    
    
    // Check if an image file was uploaded
    if (isset($_FILES['announcement_photo']) && $_FILES['announcement_photo']['error'] == UPLOAD_ERR_OK) {
      // Check if the uploaded file is a PNG or JPEG image
      $fileType = $_FILES['announcement_photo']['type'];
      if ($fileType != 'image/png' && $fileType != 'image/jpeg' && $fileType != 'image/jpg') {
        echo "Error: Invalid file type. Only PNG, JPG and JPEG images are allowed.";
       
      }
      else{
      
    // Upload the image (if one was provided)
    if ($fileNameNew) {
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($fileNameNew);
      move_uploaded_file($_FILES["announcement_photo"]["tmp_name"], $target_file);
    }
    


   
    $updateQuery = "UPDATE announcement SET announcement_title = '$a_title',
     announcement_what = '$a_what', 
     announcement_where = '$a_where', 
     announcement_when = ' $a_when', 
     announcement_message = '$a_msg',
     announcement_photo = '$fileNameNew' WHERE announcement_id = '$id'";
    $result = mysqli_query($conn, $updateQuery);
    if ($result) {
        echo '<script>alert("Announcement details updated successfully.");';
        echo 'window.location.href = "index.php";</script>';

    } else {
        echo '<script>alert("Error in updating photo.");' ;
        echo 'window.location.href = "index.php";</script>';
    
    }
}
    }
}


?>


<form action=""  method="post" class="space-y-6" enctype="multipart/form-data">
                    <div>
                        <label for="announcement_title" class="flex items-start justify-between p-4 block mb-2 text-sm font-medium font-bold text-gray-900 dark:text-white">Announcement Title</label>
                        <input value= "<?php echo $row_result['announcement_title']; ?>" type="text" name="announcement_title" id="announcement_title" class="flex items-start justify-between p-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-50 h-10 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <div>

                    
                        <label for="announcement_what" class="flex items-start justify-between p-4 block mb-2 text-sm font-medium font-bold text-gray-900 dark:text-white">What</label>
                        <input type="text" value= "<?php echo $row_result['announcement_what']; ?>" name="announcement_what" id="announcement_what" class="flex items-start justify-between p-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-50 h-10 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    </div>
                    <div>
                        <label for="announcement_where" class="flex items-start justify-between p-4 block mb-2 text-sm font-medium font-bold text-gray-900 dark:text-white">Where</label>
                        <input type="text" value= "<?php echo $row_result['announcement_where']; ?>" name="announcement_where" id="announcement_where" class="flex items-start justify-between p-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-50 h-10 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    </div>
                    <div>
                        <label for="announcement_when" class="flex items-start justify-between p-4 block mb-2 text-sm font-medium font-bold text-gray-900 dark:text-white">When</label>
                        <input type="date" value= "<?php echo $row_result['announcement_when']; ?>" name="announcement_when" id="announcement_when" class="flex items-start justify-between p-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-50 h-10 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    </div>
                    <div>
                        <label for="announcement_message"  class="flex items-start justify-between p-4 block mb-2 text-sm font-medium font-bold text-gray-900 dark:text-white">Announcement Message</label>
                        <textarea name="announcement_message" value= "<?php echo $row_result['announcement_message']; ?>" id="announcement_message" class="flex items-start justify-between p-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-100 h-10 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"></textarea>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="announcement_photo">Upload file</label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" name="announcement_photo">
                        <?php 
                        if (!empty($row_result['announcement_photo'])): ?>
                            <img src="uploads/<?php echo $row_result['announcement_photo']; ?>" alt="Uploaded Image">
                        <?php 
                            endif; ?>
                    </div>

                    <button type="submit" name= "submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update Announcement</button>
                      </form>
            <?php
        }   

}
?>

   

</div>
    <script src="modalscript.js"></script>
    <script src="ckeditor5/ckeditor.js"></script>
    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script>
  function redirectToIndexAnnouncement() {
    window.location.href = "index.php";
  }
</script>

</body>

</html>