<?php

include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

// Define the SQL query to join the tables
$stmt = $pdo->prepare("SELECT * FROM resident 
                    INNER JOIN officials ON resident.resident_id = officials.resident_id
                    WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
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
    <link rel="stylesheet" href="./assets/css/main.css" />

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

                <!-- Alert if deleting of officials is successful -->
                <?php if (isset($_GET['message']) and $_GET['message'] == 'success') : ?>
                    <div id="alert-3" class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">You successfully unassigned an official!</span>
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- page tabs -->
                <div class="border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center dark:text-gray-400">
                        <li class="mr-2">
                            <a href="officials.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Organizational Chart
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="#" class="inline-flex p-4 bg-white rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group">
                                Officials
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="add-officials.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Add Official
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <table id="officials-table" class="row-border hover">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Position</th>
                            <th>Date Appointed</th>
                            <th>Date End</th>
                            <th>Action</th>
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
                                <td>
                                    <?php if ($resident['position'] !== 'Barangay Secretary') : ?>
                                        <button type="button" id="deleteBtn" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                            <a href="includes/delete-officials.inc.php?id=<?php echo $resident['resident_id'] ?>">Delete</a>
                                        </button>
                                    <?php endif; ?>
                                </td>
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

        // Get the delete button element
        const deleteBtn = document.getElementById('deleteBtn');

        // Attach a click event listener to the delete button
        deleteBtn.addEventListener('click', (event) => {
            // Prevent the default action of the link
            event.preventDefault();

            // Show a confirmation dialog box
            const confirmed = confirm('Are you sure you want to delete this row?');
            if (confirmed) {
                // If the user confirms, proceed with the link action
                window.location.href = deleteBtn.querySelector('a').href;
            }
        });
    </script>
</body>

</html>