<?php
include 'dbh.inc.php';

$id = $_GET['id'];
$sql = $pdo->query("UPDATE barangay SET is_active = 0 WHERE b_id='$id'")->execute();

// $barangay = $pdo->query("SELECT * FROM barangay WHERE b_id='$id'")->fetch();
// $folderName = str_replace("indang.gov.ph/", '', $barangay['b_link']);


// function deleteDirectory($dirPath)
// {
//     if (!is_dir($dirPath)) {
//         return false;
//     }

//     $files = scandir($dirPath);
//     print_r($files); // for debugging purposes only.
//     foreach ($files as $file) {
//         if ($file == "." || $file == "..") {
//             continue;
//         }
//         $filePath = $dirPath . '/' . $file;

//         // // for debugging purposes only. ==========

//         // //permissions
//         // $permissions = fileperms($filePath);
//         // print_r(decoct($permissions));

//         // // writable
//         // if (!is_writable($filePath)) {
//         //     echo "File is not writable.";
//         // }

//         // //symbolic link
//         // if (is_link($filePath)) {
//         //     echo "File is a symbolic link.";
//         // }
//         // ======================================

//         if (is_dir($filePath)) {
//             deleteDirectory($filePath);
//         } else {
//             unlink($filePath);
//         }
//     }

//     return rmdir($dirPath);
// }

// $root = dirname(__FILE__, 3);
// $dirPath = "$root\\$folderName";
// // chmod($dirPath, 0777);
// deleteDirectory($dirPath);

// //delete the uploaded image of the logo
// $logoName = $barangay['b_logo'];
// $logoImgPath = "$root\admin\assets\images\uploads\barangay-logos\\$logoName";
// $status = unlink($logoImgPath);


// $sql = $pdo->query("DELETE FROM barangay WHERE b_id='$id'");



header('Location: ../barangay.php?message=Barangay deactivated successfully');
