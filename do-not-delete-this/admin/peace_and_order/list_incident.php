<?php
include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';
include_once 'includes/function.php';

$sql = "SELECT * FROM incident_table WHERE barangay_id = $barangayId";

$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT * FROM incident_complainant 
LEFT JOIN resident ON incident_complainant.resident_id = resident.resident_id
LEFT JOIN non_resident ON incident_complainant.non_resident_id = non_resident.non_resident_id
LEFT JOIN incident_table ON incident_complainant.incident_id = incident_table.incident_id
";
$query = $pdo->prepare($sql2);
$query->execute();
$result1 = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/datepicker.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/main.css" />

    <!-- Specific module styling -->
    <link rel="stylesheet" href="./assets/css/styles.css">

    <!-- <link rel="stylesheet" href="../../assets/css/bs-overwrite.css" /> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <style>
        hr {
            border: none;
            border-top: 5px solid #ccc;
        }

        .hidden-cell {
            display: none;
        }
    </style>

    <title>Admin Panel</title>
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
        <div class="wrapper incident">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title">Peace and Order</h3>
            </div>

            <!-- Page body -->
            <div class="page-body" style="overflow-x:auto; min-height: 60vh;">

                <button type="button" onclick="openPopup()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add Incident</button>
                <!-- Add resident -->
                <div class="modal-bg" id="modal-background">
                </div>

                <div class="add-resident" id="modal-container">
                    <?php include 'add_blotter.php'; ?>
                </div>


                <table id="list_incident" class="row-border hover">
                    <thead>
                        <tr>
                            <td>Incident No.</td>
                            <td>Blotter type</td>
                            <td>Complainant</td>
                            <td>Offender/s</td>
                            <td>Complaint type</td>
                            <td>Date Reported</td>
                            <td>Date Occured</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($result as $row) {
                            $incident_id = $row['incident_id'];
                        ?>
                            <tr>
                                <!-- Incident No. -->
                                <td><?php echo $incident_id; ?></td>
                                <td>
                                    <!-- blotter_type -->
                                    <?php if ($row['blotterType_id'] == 1) {
                                        echo 'Complaint';
                                    } else {
                                        echo 'Incident';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <!-- complainant type -->
                                    <?php
                                    $complainants = getIncidentComplainant($pdo, $incident_id);
                                    foreach ($complainants as $row1) {
                                        $comp = $row1['complainant_type'];
                                        if ($comp == 'resident') {
                                            echo $row1['firstname'] . " " . $row1['lastname'] . "<br>";
                                        } else {
                                            echo $row1['non_res_firstname'] . " " . $row1['non_res_lastname'] . "<br>";
                                        }
                                    }

                                    ?>

                                </td>
                                <td>
                                    <!-- Offender/s type -->
                                    <?php
                                    $offenders = getIncidentOffender($pdo, $incident_id);
                                    foreach ($offenders as $row1) {
                                        $comp = $row1['offender_type'];
                                        if ($comp == 'resident') {
                                            echo $row1['firstname'] . " " . $row1['lastname'] . "<br>";
                                        } else {
                                            echo $row1['non_res_firstname'] . " " . $row1['non_res_lastname'] . "<br>";
                                        }
                                    }
                                    ?>

                                </td>

                                <td>
                                    <!-- Complainant type -->
                                    <?php
                                    foreach ($complainants as $row1) {
                                        echo $row1['complainant_type'];
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row['date_reported']; ?></td>
                                <td><?php echo "$row[date_incident] $row[time_incident]"; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td id=" action">

                                    <button id="dropdownDividerButton" data-dropdown-toggle="<?php echo $row['incident_id'] ?>" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Action <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg></button>

                                    <!-- Dropdown menu -->
                                    <div id="<?php echo $row['incident_id'] ?>" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton">
                                            <li>
                                                <button class="block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="addPerson(<?php echo $row['incident_id'] ?>)">Add person</button>
                                            </li>
                                            <li>
                                                <button class="block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="viewIncident(<?php echo $row['incident_id'] ?>)">View</button>
                                            </li>
                                            <li>

                                                <button class="block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-fb-toggle="modal" data-fb-target="#myModal2" onclick="editIncident(<?php echo $row['incident_id'] ?>)">Edit</button>
                                            </li>
                                            <li>
                                                <button class=" block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="deleteIncident(<?php echo $row['incident_id'] ?>)">Delete</button>
                                            </li>
                                        </ul>
                                        <!-- Add resident -->
                                        <div class="modal-bg" onclick="closePopup()" id="modal-background">
                                        </div>


                                    </div>


                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </main>



    <script src="../../assets/js/sidebar.js"></script>
    <script src="./assets/js/add-incident.js"></script>
    <script src="./assets/js/remote_modals.js"></script>
    <!-- <script src="./assets/js/required.js"></script> -->
    <script src="./assets/js/radioInput_more.js"></script>
    <script src="./assets/js/select-resident.js"></script>
    <script src="./assets/js/disabled_input.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#list_incident').DataTable();
        });
        $(document).ready(function() {
            $('#residents-table').DataTable();
        });
        $(document).ready(function() {
            $('#o_residents-table').DataTable();
        });

        //Selecting resident
        function validateForm() {
            const input = document.getElementById("resident_name").value;
            if (input == "") {
                alert("Select resident");
                return false;
            }
        }
    </script>


    </script>
</body>

</html>