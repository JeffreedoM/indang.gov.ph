<?php
include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';
// include 'add_blotter.php';

//list incident
$sql = "SELECT i.*, p.name, o.offender_name
FROM incident_table i 
        JOIN incident_offender1 o ON o.offender_id = i.offender_id
        JOIN Incident_reporting_person p ON i.person_id = p.person_id
        ORDER BY p.name";

$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

if ($resident = 1) {
    $resident = "Resident";
} else if ($resident = 2) {
    $resident = "Non-Resident";
}
if ($complaint = 1) {
    $complaint = "Complaint";
} else if ($complaint = 2) {
    $complaint = "Incident";
}
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
                <div class="modal-bg" onclick="closePopup()" id="modal-background">
                </div>

                <div class="add-resident popup" id="modal-container">
                    <?php include 'add_blotter.php'; ?>

                    <!-- close popup button -->
                    <span class="close-popup" onclick="closePopup()">
                        <i class="fa-solid fa-x"></i>
                    </span>
                </div>


                <table id="list_incident" class="row-border">
                    <thead>
                        <tr>
                            <td>Incident No.</td>
                            <td>Blotter type</td>
                            <td>Complaint</td>
                            <td>Offenders</td>
                            <td>Complaint type</td>
                            <td>Date Reported</td>
                            <td>Date Occured</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row) { ?>
                            <tr>
                                <td><?php echo $row['incident_id']; ?></td>
                                <td><?php echo $row['complainantType_id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['offender_name']; ?></td>
                                <td><?php echo $row['complainantType_id']; ?></td>
                                <td><?php echo $row['date_reported']; ?></td>
                                <td><?php echo "$row[date_incident] $row[time_incident]"; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <!-- <td>
                                    <button type="button" class="btn btn-primary"><a href="view.php?view_id=<?php echo $row['incident_id'] ?>">View</a></button>

                                    <button type="button" class="btn btn-warning"><a href="edit.php?update_id=<?php echo $row['incident_id'] ?>">Edit</a></button>

                                    <button type="button" class="btn btn-danger"><a href="delete.php?delete_id=<?php echo $row['incident_id'] ?>">Delete</a></button>
                                </td> -->
                                <td id="action">

                                    <button id="dropdownDividerButton" data-dropdown-toggle="<?php echo $row['incident_id'] ?>" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Action <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg></button>

                                    <!-- Dropdown menu -->
                                    <div id="<?php echo $row['incident_id'] ?>" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton">
                                            <li>
                                                <a href="view.php?view_id=<?php echo $row['incident_id'] ?>" class="block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">View</a>
                                            </li>
                                            <li>
                                                <a href="edit.php?update_id=<?php echo $row['incident_id'] ?>" class="block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="delete.php?delete_id=<?php echo $row['incident_id'] ?>" class="block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                            </li>
                                        </ul>
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
    <script src="../../assets/js/header.js"></script>
    <script src="./assets/js/add-incident.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#list_incident').DataTable();
        });
    </script>
</body>

</html>