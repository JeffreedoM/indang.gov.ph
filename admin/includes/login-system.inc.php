<?php
// include 'dbh.inc.php';
// function checkLogin()

function checkLogin($pdo)
{
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];

        // $sql = "SELECT * FROM users WHERE user_id = ? LIMIT 1";
        // $result = $pdo->prepare($sql);
        // $result->execute([$id]);
        // $numRows = $result->fetchColumn();

        $result = $pdo->query("SELECT * FROM super_accounts WHERE user_id = '$id' LIMIT 1");
        $result->execute();
        $numRows = $result->rowCount();
        if ($result && $numRows > 0) {
            $user_data = $result->fetch();
            return $user_data;
        }
    }


    //redirect to login if not logged in
    header('Location: ../index.php');
    die;
}

function random_num($length)
{
    $text = '';
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {

        $text .= rand(0, 9);
    }

    return $text;
}
