<?php

include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

// $stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
// $stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
// $stmt->execute();
// $resident = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Define the SQL query to join the tables
$sql = "SELECT * FROM resident 
        INNER JOIN officials ON resident.resident_id = officials.resident_id";

// Prepare the SQL statement
$stmt = $pdo->prepare($sql);

// Execute the SQL statement
$stmt->execute();

// Fetch the results as an associative array
$results = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
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
                            <a href="officials.php">Home</a>
                        </button>
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <a href="officials-table.php">Officials</a>
                        </button>
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <a href="add-officials.php">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add Official</span>
                            </a>
                        </button>
                    </div>
                </div>

                <table id="officials-table" class="row-border hover">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Position</th>
                            <th>Date Appointed</th>
                            <th>Date End</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $resident) { ?>
                            <tr>
                                <td><?php echo "$resident[firstname] $resident[middlename] $resident[lastname]" ?></td>
                                <td><?php echo $resident['sex'] ?></td>
                                <td><?php echo $resident['position'] ?></td>
                                <td><?php echo date('F j, Y', strtotime($resident['date_start'])) ?></td>
                                <td><?php echo date('F j, Y', strtotime($resident['date_end'])) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>


            </div>
        </div>
    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#officials-table').DataTable();
        });
    </script>
</body>

</html>