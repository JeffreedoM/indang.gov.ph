<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/deactivated.inc.php';


$id = $_GET['view_id'];

$_SESSION['incident_id'] = $id;

//select incident_table
$sql = "SELECT * FROM incident_table
    WHERE incident_id = :id
";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$list1 = $stmt->fetch(PDO::FETCH_ASSOC);

//selecting incident_complainant
$sql = "SELECT * FROM incident_offender
    LEFT JOIN resident ON incident_offender.resident_id = resident.resident_id
    LEFT JOIN non_resident ON incident_offender.non_resident_id = non_resident.non_resident_id
    LEFT JOIN incident_table ON incident_offender.incident_id = incident_table.incident_id
    WHERE incident_offender.incident_id = $id
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$list2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

//selecting incident_complainant
$sql = "SELECT * FROM incident_complainant
    LEFT JOIN resident ON incident_complainant.resident_id = resident.resident_id
    LEFT JOIN non_resident ON incident_complainant.non_resident_id = non_resident.non_resident_id
    LEFT JOIN incident_table ON incident_complainant.incident_id = incident_table.incident_id
    WHERE incident_complainant.incident_id = $id
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$list3 = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
    <link rel="stylesheet" href="../../../assets/css/main.css" />
    <!-- for logo -->
    <script src="https://kit.fontawesome.com/4c7eb3588b.js" crossorigin="anonymous"></script>

    <!-- Specific module styling -->
    <!-- <link rel="stylesheet" href="./assets/css/styles.css"> -->
    <!-- <link rel="stylesheet" href="../../assets/css/bs-overwrite.css" /> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="icon" type="image/x-icon" href="../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Peace and Order</title>
    <style>
        table {
            /* width: 100%; */
            width: 900px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .list_involve td {
            text-align: left;
        }

        th {
            text-align: left;
            margin-bottom: 20px;
        }

        input {
            width: 250px;
            margin-bottom: .5rem;
            border-radius: 5px;
            padding: 10px;
        }

        .action_btn button {
            width: 90px;
        }

        h1 {
            display: inline;
        }

        .legend {
            float: right;
            margin-right: 20%;
        }

        .bullet-point {
            position: relative;
            padding-left: 15px;
        }

        .bullet-point::before {
            content: "";
            position: absolute;
            left: 0;
            top: 8px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: black;
        }
    </style>

</head>

<body>
    <?php
    include '../../../partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include '../../../partials/nav_header.php';
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
                <form method="post" id="view">
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <a href="../list_incident.php"> Back</a></button>
                    <table>
                        <tr>
                            <th>List of person involve</th>
                        </tr>
                        <tr>
                            <td>Case</td>
                            <td>
                                <input type="text" name="case" value="<?php echo ucfirst(strtolower($list1['case_incident'])); ?>" style="width: 300px;" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Incident title</td>
                            <td>
                                <input type="text" name="case" value="<?php echo  $list1['incident_title']; ?>" style="width: 300px;" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Date of Incident</td>
                            <td>
                                <input type="text" name="case" value="<?php echo date('F j, Y', strtotime($list1['date_incident'])); ?>" style="width: 300px;" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Time of Incident</td>
                            <td>
                                <input type="time" name="case" value="<?php echo $list1['time_incident']; ?>" style="width: 300px;" readonly>
                            </td>
                        </tr>
                    </table>
                    <br><br>
                    <h1><strong>List of Involves:</strong></h1>
                    <span class="legend"><i class="bullet-point"></i> - Resident</span>

                    <table class="list_involve" id="list_involve">
                        <thead>
                            <th>Name</th>
                            <th>Sex</th>
                            <th>Address</th>
                            <th>Involve Person type</th>
                            <th style="width:200px; text-align: center;">Action</th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($list2 as $list) {
                                if ($list['offender_type'] == "resident") {
                            ?>
                                    <tr>
                                        <td><i class="bullet-point"></i><?php echo $list['firstname'] . " " . $list['lastname']; ?></td>
                                        <td><?php echo $list['sex']; ?></td>
                                        <td><?php echo "$list[house] $list[street] $barangayName"; ?></td>
                                        <td style="color: crimson"><?php echo "Offender"; ?></td>
                                        <td>
                                            <div class="action_btn">
                                                <button type="button" class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <a href="edit_person.php?up_off_id=<?php echo $list['offender_id']; ?>">
                                                        Edit details</a></button>
                                                <button onclick="return confirm('Are you sure you want to delete this person?')" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                    <a href="delete_person.php? view_id=<?php echo $id; ?>&del_off_id=<?php echo $list['offender_id']; ?>">
                                                        Remove</a></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                } else {
                                ?>
                                    <tr>
                                        <td><?php echo $list['non_res_firstname'] . " " . $list['non_res_lastname']; ?></td>
                                        <td><?php echo $list['non_res_gender']; ?></td>
                                        <td><?php echo $list['non_res_address']; ?></td>
                                        <td style="color: crimson"><?php echo "Offender" ?></td>

                                        <td>
                                            <div class="action_btn">
                                                <button class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><a href="edit_person.php?up_off_id=<?php echo $list['offender_id']; ?>">
                                                        Edit details</a></button>
                                                <button onclick="return confirm('Are you sure you want to delete this person?')" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                    <a href="delete_person.php? view_id=<?php echo $id; ?>&del_off_id=<?php echo $list['offender_id']; ?>">Remove</a></button>
                                            </div>
                                        </td>
                                    </tr>
                            <?php

                                }
                            }
                            ?>
                            <?php
                            foreach ($list3 as $list) {
                                if ($list['complainant_type'] == "resident") {
                            ?>
                                    <tr>
                                        <td><i class="bullet-point"></i><?php echo $list['firstname'] . " " . $list['lastname']; ?></td>
                                        <td><?php echo $list['sex']; ?></td>
                                        <td><?php echo "$list[house] $list[street] $barangayName"; ?></td>
                                        <td style="color: green"><?php echo "Complainant"; ?></td>
                                        <td>
                                            <div class="action_btn">
                                                <button type="button" class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <a href="edit_person.php?up_comp_id=<?php echo $list['complainant_id']; ?>">
                                                        Edit details</a></button>
                                                <button onclick="return confirm('Are you sure you want to delete this person?')" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                    <a href="delete_person.php? view_id=<?php echo $id; ?>&del_comp_id=<?php echo $list['complainant_id']; ?>">
                                                        Remove</a></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                } else {
                                ?><tr>
                                        <td><?php echo $list['non_res_firstname'] . " " . $list['non_res_lastname']; ?></td>
                                        <td><?php echo $list['non_res_gender']; ?></td>
                                        <td><?php echo $list['non_res_address']; ?></td>
                                        <td style="color: green"><?php echo "Complainant" ?></td>

                                        <td>
                                            <div class="action_btn">
                                                <button class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><a href="edit_person.php?up_comp_id=<?php echo $list['complainant_id']; ?>">
                                                        Edit details</a></button>
                                                <button onclick="return confirm('Are you sure you want to delete this person?')" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                    <a href="delete_person.php? view_id=<?php echo $id; ?>&del_comp_id=<?php echo $list['complainant_id']; ?>">
                                                        Remove</a></button>
                                            </div>
                                        </td>
                                    </tr>
                            <?php

                                }
                            }
                            ?>
                            </tr>
                        </tbody>
                    </table>

                    <br>
                </form>
            </div>
        </div>
    </main>

    <script src="../../../assets/js/sidebar.js"></script>
    <!-- <script src="../../assets/js/header.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> -->

</body>

</html>