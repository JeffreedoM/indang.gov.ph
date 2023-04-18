<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
?>

<?php

// Get the form data
$title = $_POST['announcement_title'];
$message = $_POST['announcement_message'];
$image_filename = $_FILES['announcement_image']['name'];

// Upload the image (if one was provided)
if ($image_filename) {
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($image_filename);
  move_uploaded_file($_FILES["announcement_image"]["tmp_name"], $target_file);
}

// Insert the announcement into the database
$insertsql = "INSERT INTO announcement (title, message, image_filename) VALUES ('$title', '$message', '$image_filename')";
if ($conn->query($insertsql) === TRUE) {
 
    
} else {
  echo "Error: " . $insertsql . "<br>" . $conn->error;
}

// Select the latest announcement from the database
$dislaysql = "SELECT * FROM announcement ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($dislaysql);


if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo "<h2>" . $row['title'] . "</h2>";
  echo "<p>" . $row['message'] . "</p>";

  if ($row['image_filename']) {
    echo "<img src='uploads/" . $row['image_filename'] . "' alt='" . $row['title'] . "'><br>";
  }
  
  echo "<small>Posted on " . $row['created_at'] . "</small>";
} else {
  echo "No announcements found";
}


?>
