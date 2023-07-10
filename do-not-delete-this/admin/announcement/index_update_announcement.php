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
<div class="container">
    
    <!-- Body -->
    <div class="main-announcement-container">
        <?php
        // Define the SQL query
        $dislaysql = "SELECT * 
                      FROM announcement a 
                      INNER JOIN barangay b 
                      ON a.brgy_id = b.b_id 
                      WHERE b.b_id = $barangayId 
                      ORDER BY a.created_at DESC 
                      LIMIT 1;";

        // Execute the query
        $result2 = $conn->query($dislaysql);
        
        // Check if the query was successful and fetch the row
        if ($result2 && $result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            
            ?>
          
            </div>

            <div class="image-cover" >
                <a href="#">
                    <img id = "upload" class="rounded-t-lg mx-auto w-full sm:w-auto"  src="uploads/<?php echo $row2['announcement_photo'] ?>" alt=""/>
                </a>
                <div class="p-5">
                
                    <h5 class="mb-2 text-l font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-question-circle"></i> &#160 What: &#160 <?php echo $row2['announcement_what'] ?></h5>
        <h5 class="mb-2 text-l font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-map-marker-alt"></i> &#160 Where: &#160 <?php echo $row2['announcement_where'] ?></h5>
        <h5 class="mb-2 text-l font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-calendar"></i> &#160 When: &#160 <?php echo $row2['announcement_when'] ?></h5>
                    
                  
        
        
<!-- Modal toggle -->
<a href="index_update_announcement_update.php?announcement_id=<?php echo $row2['announcement_id']; ?>" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" >
  Update Announcement
            </a>





                    <!-- <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Read more
                        <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a> -->
                </div>
            </div>
        <?php
        }
        ?>

    </div>
    <div class="main-announcement-container">
        <?php
        // Define the SQL query
        $dislaysql = "SELECT * 
                      FROM announcement a 
                      INNER JOIN barangay b 
                      ON a.brgy_id = b.b_id 
                      WHERE b.b_id = $barangayId 
                      ORDER BY a.created_at DESC 
                      LIMIT 1, 2;"; // Fetch 2nd and 3rd announcements

        // Execute the query
        $result = $conn->query($dislaysql);

        // Check if the query was successful and fetch the rows
        if ($result && $result->num_rows > 0) {
            ?>
            <div class="flex justify-center">
            <?php
           
            while ($row = $result->fetch_assoc()) {
              
                ?>
                
                <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mx-2">
                    <a href="#">
                        <img id = "upload" class="rounded-t-lg mx-300" src="uploads/<?php echo $row['announcement_photo'] ?>" alt="ss" 
                        style="width: 300px; height: 200px; object-fit: contain; object-position: center center; "/>
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center "><?php echo $row['announcement_title'] ?></h5>
                        </a>
                        <h5 class="mb-2 text-l font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-question-circle"></i> &#160 What: &#160 <?php echo $row['announcement_what'] ?></h5>
        <h5 class="mb-2 text-l font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-map-marker-alt"></i> &#160 Where: &#160 <?php echo $row['announcement_where'] ?></h5>
        <h5 class="mb-2 text-l font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-calendar"></i> &#160 When: &#160 <?php echo $row['announcement_when'] ?></h5>
                     

               
<!-- Modal toggle -->
<a href="index_update_announcement_update.php?announcement_id=<?php echo $row['announcement_id']; ?>" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" >
  Update Announcement
            </a>



                    </div>
                </div>
                <?php
            }
           
            ?>
            </div>
            <?php
        }
        else{
          echo "No (" . $row . ") Result.";
        }
        ?>
    </div>
  
      </div>

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