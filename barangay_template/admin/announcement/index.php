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
  
		
            <button class="update-index-btn" onclick="redirectToIndexAnnouncement()">Create a Index Announcement</button>
            <button class="index-btn" onclick="redirectToIndexUpdateAnnouncement()">Update Announcement</button>
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
<div id="myModal-1" class="modal-1">
    <div class="modal-content-1">
      
      <form action="submit_announcement.php" method="post" class="index-form" enctype="multipart/form-data">
        <h2 id="ann">Create Index Announcement</h2><br><br>
        <label for="announcement_title">Announcement Title:</label>
        <input type="text" name="announcement_title" id="announcement_title" required>

        <label for="announcement_what">What:</label>
        <input type="text" name="announcement_what" id="announcement_what">

        <label for="announcement_where">Where:</label>
        <input type="text" name="announcement_where" id="announcement_where">

        <label for="announcement_when">When:</label>
        <input type="text" name="announcement_when" id="announcement_when">


        <label for="announcement_message">Announcement Message:</label>
        <textarea name="announcement_message" id="announcement_message" ></textarea>
  
        <label for="announcement_photo">Announcement Image:</label required>
        <input type="file" name="announcement_photo" id="announcement_photo" accept="image/*" required>
  
        <button type="submit">Submit Announcement</button>
      </form>
    </div>
  </div>

<br><br>
<br><br>


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
  function redirectToIndexUpdateAnnouncement() {
    window.location.href = "index_update_announcement.php";
  }
</script>

</body>

</html>