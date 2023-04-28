<?php

include '../../../includes/dbh.inc.php';

if (isset($_POST['add_account'])) {
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

    header('Location: ../index.php');
}
