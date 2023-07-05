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
    <script src="https://kit.fontawesome.com/4c7eb3588b.js" crossorigin="anonymous"></script>
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

        td {
            vertical-align: top !important;
        }

        button {
            display: flex !important;
            align-items: center;
        }

        .icon {
            margin-right: 8px;
        }

        #print {
            margin-top: .5rem;
            color: gray;
            margin-left: 1rem;
            display: flex;
        }

        .underline-on-hover:hover {
            text-decoration: underline;
        }

        .green-text {
            color: green;
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

                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><a href="add_blotter.php">Add Incident</a></button>
                <!-- <button type="button" onclick="openPopup()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add Incident</button> -->
                <!-- Add resident -->
                <!-- <div class="modal-bg" id="modal-background">
                </div>

                <div class="add-resident" id="modal-container"> -->
                <?php
                // include 'add_blotter.php'; 
                ?>

                <!-- close popup button -->
                <!-- <span class="close-popup" onclick="closePopup()">
                        <i class="fa-solid fa-x"></i>
                    </span>
                </div> -->



                <table id="list_incident" class="row-border hover">
                    <thead>
                        <tr>
                            <th>Incident No.</th>
                            <th>Blotter type</th>
                            <th>Complainant</th>
                            <th style="width: 15%">Offender/s</th>
                            <th>Complainant type</th>
                            <th>Date Reported</th>
                            <th>Date Occured</th>
                            <th>Status</th>
                            <th>Action</th>
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
                                            echo $row1['firstname'] . " " . $row1['lastname'];
                                        } else {
                                            echo $row1['non_res_firstname'] . " " . $row1['non_res_lastname'];
                                        }
                                        break;
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

                                <!-- Complainant type -->
                                <?php
                                foreach ($complainants as $row1) {
                                    $comp_type = $row1['complainant_type'];
                                    break;
                                }
                                ?>
                                <td <?php if ($comp_type === 'resident') {
                                        echo 'class="green-text"';
                                    } ?>>
                                    <?php echo $comp_type; ?>


                                </td>
                                <td><?php echo $row['date_reported']; ?></td>
                                <td><?php echo "$row[date_incident] $row[time_incident]"; ?></td>

                                <td>
                                    <!-- Status -->
                                    <?php $status = $row['status'];
                                    switch ($status) {
                                        case 1:
                                            echo "Mediated";
                                            break;
                                        case 2:
                                            echo "Dismiss";
                                            break;
                                        case 3:
                                            echo "Certified 4a";
                                            break;
                                    }
                                    ?>
                                </td>
                                <td id=" action">

                                    <button id="dropdownDividerButton" data-dropdown-toggle="<?php echo $row['incident_id'] ?>" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Action <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg></button>

                                    <!-- Dropdown menu -->
                                    <div id="<?php echo $row['incident_id'] ?>" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton">
                                            <li>
                                                <button class="block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="addPerson(<?php echo $row['incident_id'] ?>)">
                                                    <span class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                                        </svg>

                                                    </span>
                                                    Add person</button>
                                            </li>
                                            <li>
                                                <button class="block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="viewIncident(<?php echo $row['incident_id'] ?>)">
                                                    <span class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                    </span>View</button>

                                            </li>
                                            <li>

                                                <button class="block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" data-fb-toggle="modal" data-fb-target="#myModal2" onclick="editIncident(<?php echo $row['incident_id'] ?>)">
                                                    <span class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                        </svg>
                                                    </span>Edit</button>
                                            </li>
                                            <li>
                                                <button class=" block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="deleteIncident(<?php echo $row['incident_id'] ?>)" style="color:red">
                                                    <span class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </span>Delete</button>
                                            </li>
                                        </ul>
                                        <!-- Add resident -->
                                        <!-- <div class="modal-bg" onclick="closePopup()" id="modal-background">
                                        </div> -->


                                    </div>

                                    <a href="pdf/print.php?print_id=<?php echo $row['incident_id'] ?>" id="print" target="_blank" class="underline-on-hover">
                                        <span class="icon">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </span>
                                        Print
                                    </a>

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
    <script src="./assets/js/radioInput_more.js"></script>
    <script src="./assets/js/select-resident.js"></script>
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


</body>

</html>