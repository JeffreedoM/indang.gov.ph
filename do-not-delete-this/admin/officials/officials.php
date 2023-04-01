<?php

include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    <!-- specific page styling -->
    <link rel="stylesheet" href="./assets/css/style.css" />

    <title>Admin | Officials</title>
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
                <h3 class="page-title">Barangay Officials</h3>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <div class="header">
                    <div class="nav-links">
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <a href="#">Home</a>
                        </button>
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <a href="#">Officials</a>
                        </button>
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <a href="#">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add Official</span>
                            </a>
                        </button>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card">
                        <img src="../../assets/images/uploads/no-profile.png" alt="" width="100px">
                        <h1 class="card-title">Jeffrey Nuñez</h1>
                        <p class="card-body">Barangay Captain</p>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card">
                        <img src="../../assets/images/uploads/no-profile.png" alt="" width="100px">
                        <h1 class="card-title">Jeffrey Nuñez</h1>
                        <p class="card-body">Barangay Captain</p>
                    </div>
                </div>
                <div class="row kagawad">
                    <div class="card-container">
                        <div class="card">
                            <img src="../../assets/images/uploads/no-profile.png" alt="" width="100px">
                            <h1 class="card-title">Jeffrey Nuñez</h1>
                            <p class="card-body">Barangay Captain</p>
                        </div>
                    </div>
                    <div class="card-container">
                        <div class="card">
                            <img src="../../assets/images/uploads/no-profile.png" alt="" width="100px">
                            <h1 class="card-title">Jeffrey Nuñez</h1>
                            <p class="card-body">Barangay Captain</p>
                        </div>
                    </div>
                    <div class="card-container">
                        <div class="card">
                            <img src="../../assets/images/uploads/no-profile.png" alt="" width="100px">
                            <h1 class="card-title">Jeffrey Nuñez</h1>
                            <p class="card-body">Barangay Captain</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>