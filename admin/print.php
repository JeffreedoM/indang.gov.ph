<?php
include 'includes/dbh.inc.php';

$barangay = $pdo->query("SELECT * FROM barangay ORDER BY b_id DESC LIMIT 1")->fetch();
$barangayName = ucwords($barangay['b_name']);
$municipality = $pdo->query("SELECT * FROM superadmin_config")->fetch();

$last_account = $pdo->query("SELECT * FROM accounts ORDER BY account_id DESC LIMIT 1")->fetch();


// $sql = $pdo->query(
//     "SELECT a.username, a.password, r.resident_name, b.barangay_name
//     FROM accounts a
//     JOIN resident r ON a.resident_id = r.resident_id
//     JOIN barangay b ON r.barangay_id = b.barangay_id;
//     ")->fetch();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title><?php echo $barangayName ?>Login Credentials</title>

    <style>
        header {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            gap: 1rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <header>
        <img src="./assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>" alt="Barangay Logo" width="80px">
        <div>
            <div>Republic of the Philippines</div>
            <div>Province of Cavite</div>
            <div>Municipality of Indang</div>
            <div><?php echo $barangayName ?></div>
        </div>
        <img src="./assets/images/<?php echo $municipality['municipality_logo'] ?>" alt="Barangay Logo" width="80px">
    </header>

    <div class="card position-absolute top-50 start-50 translate-middle" style=" max-width:550px; width:90%">
        <div class="card-body mx-4">
            <div class="container">
                <p class="my-5 text-center" style="font-size: 30px;"><?php echo $barangayName ?></p>
                <div class="row">
                    <hr>
                    <div class="col-xl-10">
                        <p class="fw-bold">Username: </p>
                    </div>
                    <div class="col-xl-2">
                        <p class="float-end"><?php echo $last_account['username'] ?>
                        </p>
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-xl-10">
                        <p class="fw-bold">Password: </p>
                    </div>
                    <div class="col-xl-2">
                        <p class="float-end"><?php echo $last_account['default_password'] ?>
                        </p>
                    </div>
                    <hr style="border: 2px solid black;">
                </div>
                <div class="row">
                    <div class="col-xl-10">
                        <p class="fw-bold">Barangay Link: </p>
                    </div>
                    <div class="col">
                        <p class="float-end"><?php echo $barangay['b_link'] ?>
                        </p>
                    </div>
                    <hr style="border: 2px solid black;">
                </div>
            </div>
        </div>
    </div>
</body>

</html>