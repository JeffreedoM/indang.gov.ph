<?php

// Set the session save path
$sessionSavePath = dirname(__DIR__) . '/sessions';
session_save_path($sessionSavePath);

// Start the session
session_start();

// Set the idle session time (in seconds)
$idleSessionTime = 3600; // 1 hour (adjust this as needed)

// Check and delete idle session files
$currentTime = time();
$files = glob("$sessionSavePath/sess_*");
foreach ($files as $file) {
    if (file_exists($file) && ($currentTime - filemtime($file) > $idleSessionTime)) {
        unlink($file);
    }
}


// Set a custom session expiration time (in seconds)
// $sessionExpiration = 86400; // 24 hours (adjust this as needed)

// // Check and delete old session files
// $currentTime = time();
// $files = glob("$sessionSavePath/sess_*");
// foreach ($files as $file) {
//     if (file_exists($file) && ($currentTime - filemtime($file) > $sessionExpiration)) {
//         unlink($file);
//     }
// }