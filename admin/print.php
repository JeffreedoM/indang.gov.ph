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
    <script src="https://cdn.tailwindcss.com"></script>
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

        @media print {
            :root {
                font-size: 11px;
            }

            #printPageButton {
                display: none;
            }

            body {
                margin: 10px;
            }

        }

        @page {
            size: 127mm 76.2mm;
            /* Set the width and height for the custom index card size */
            margin: 10px;
        }
    </style>
</head>

<body>
    <!-- <header>
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
    </div> -->

    <header>
        <img src="./assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>" alt="Barangay Logo" width="50px">
        <div>
            <div>Republic of the Philippines</div>
            <div>Province of Cavite</div>
            <div>Municipality of Indang</div>
            <div><?php echo $barangayName ?></div>
        </div>
        <img src="./assets/images/<?php echo $municipality['municipality_logo'] ?>" alt="Barangay Logo" width="50px">
    </header>

    <div class="mt-8 mx-[2.5rem]">
        <h1 class="text-center mb-6 font-semibold text-2xl"><?php echo $barangayName ?></h1>
        <div class="mb-3 bg-slate-100 p-3 flex justify-between rounded">
            <p>Username: </p>
            <p><?php echo $last_account['username'] ?>
            </p>
        </div>
        <div class="mb-3 bg-slate-100 p-3 flex justify-between rounded">
            <p>Password: </p>
            <p><?php echo $last_account['default_password'] ?></p>
        </div>
        <div class="mb-5 bg-slate-100 p-3 flex justify-between rounded">
            <p>Barangay Link: </p>
            <p><?php echo $barangay['b_link'] ?>
            </p>
        </div>
        <p class="text-[8px]">Note: It is important to immediately change the default username and password for the security of the system.</p>
    </div>

</body>

</html>