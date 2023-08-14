<?php

include '../../../includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $official_id = $_POST['official_id'];

    $stmt = $pdo->prepare("INSERT INTO accounts (official_id, username, password) VALUES (:official_id, :username, :password)");
    $data = array(
        'official_id' => $official_id,
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT),
    );
    $stmt->execute($data);

    // header('Location: ../index.php');

    echo "<script>
    window.location.href = '../index.php';
    </script>";
}
