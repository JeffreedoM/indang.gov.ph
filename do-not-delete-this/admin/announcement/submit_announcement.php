<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
?>

<?php

// Get the form data
$title = $_POST['announcement_title'];
$announcement_what = $_POST['announcement_what'];
$announcement_where = $_POST['announcement_where'];
$announcement_when = $_POST['announcement_when'];
$message = $_POST['announcement_message'];
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
  } else {

    // Upload the image (if one was provided)
    if ($fileNameNew) {
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($fileNameNew);
      move_uploaded_file($_FILES["announcement_photo"]["tmp_name"], $target_file);
    }


    // Insert the announcement into the database
    $insertsql = "INSERT INTO announcement (announcement_id,brgy_id, announcement_title, announcement_what,announcement_where,announcement_when, announcement_message, announcement_photo)
  VALUES ('','$barangayId', '$title','$announcement_what','$announcement_where','$announcement_when', '$message', '$fileNameNew')";
    if ($conn->query($insertsql) === TRUE) {
      echo '<script>alert("Record added successfully!"); window.location.href = "index.php";</script>';
    } else {
      echo '<script>alert("Error: No file was uploaded or an error occurred during upload."); window.location.href = "index.php";</script>';
    }
  }
} else {
  echo "Error: " . $insertsql . "<br>" . $conn->error;
}


?>
