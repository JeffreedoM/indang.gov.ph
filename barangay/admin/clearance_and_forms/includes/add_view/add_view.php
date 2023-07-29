<?php

include '../../../../includes/dbh.inc.php';
include '../../../../includes/deactivated.inc.php';
include '../../../../includes/session.inc.php';

$finance_id = $_GET['clearance_id'];
$resident_id = $_GET['resident_id'];
$action = $_GET['action'];
$finance = $pdo->query("SELECT * FROM resident JOIN new_clearance ON resident.resident_id = new_clearance.resident_id WHERE new_clearance.clearance_id='$finance_id'")->fetch();
$finance2 = $pdo->query("SELECT * FROM resident JOIN new_clearance ON resident.resident_id = new_clearance.resident_id WHERE resident.resident_id='$resident_id'")->fetchAll();

$form_label = $finance['form_request'];
// Calculate total amount paid
$totalAmountResult = $pdo->query("SELECT COALESCE(SUM(amount), 0) AS total_amount FROM new_clearance WHERE status='Paid' AND resident_id='$resident_id'");
$totalRowAmount = $totalAmountResult->fetch();
$formAmount = $totalRowAmount['total_amount'];

//total request based on the form
$totalRequest = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM new_clearance WHERE resident_id='$resident_id'")->fetchColumn();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../../assets/css/main.css" />
    <link rel="stylesheet" href="../../assets/css/popup2.css" type="text/css" />

    <title>Admin Panel</title>

    <style>
        textarea {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php
    include '../../../../partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include '../../../../partials/nav_header.php';
        ?>

        <!-- Container -->
        <div class="wrapper">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title">

                    <div class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="../../index.php" class="inline-flex items-center text-base font-semibold text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                    <?= $finance['form_request']; ?>
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <?php
                                    if ($action == 'edit') {
                                        $action_label = 'Edit';
                                    } else {
                                        $action_label = 'View';
                                    }
                                    ?>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"><?php echo $action_label; ?> Transaction Detail</span>
                                </div>
                            </li>
                        </ol>
                    </div>

                </h3>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <form action="../query.php" method="POST" enctype="multipart/form-data" class="add-resident__form">
                    <div>
                        <input type="hidden" name="id_resident" value="<?php echo $finance['clearance_id']; ?>" id="resident_id">
                    </div>

                    <div class="container_vaccine">

                        <div class="image_vaccine">
                            <center>
                                <!-- <img src="../../../assets/image/health.png" alt="Your image"> -->
                                <br>
                                <h1><b><?php echo $finance['firstname'] . ' ' . $finance['middlename'] . ' ' . $finance['lastname'] ?></b></h1>
                                <label for="position" class="block font-medium text-gray-900 dark:text-white">Resident Name</label>
                                <br><br>
                            </center>
                        </div>

                        <?php
                        if ($action == 'view') {
                        ?>
                            <style>
                                #edit-view {
                                    display: none;
                                }
                            </style>
                        <?php
                        } else {
                        ?>
                            <style>
                                #view-view {
                                    display: none;
                                }
                            </style>
                        <?php
                        }
                        ?>
                        <div class="wrap-position2">
                            <div class="wrap-position-sub2">
                                <label for="position" class="block font-medium text-gray-900 dark:text-white"><b>Form Request</b></label>
                                <p id="view-view"><?php echo $finance['form_request'] ?></p>
                                <select name="form_request" id="edit-view">
                                    <option selected value="" disabled> Choose Form Type</option>
                                    <option value="Barangay Business Clearance" <?= ($finance['form_request'] == 'Barangay Business Clearance') ? 'selected' : '' ?>> Barangay Business Clearance</option>
                                    <option value="Barangay Clearance" <?= ($finance['form_request'] == 'Barangay Clearance') ? 'selected' : '' ?>> Barangay Clearance</option>
                                    <option value="Certificate of Clearance" <?= ($finance['form_request'] == 'Certificate of Clearance') ? 'selected' : '' ?>> Certificate of Clearance</option>
                                    <option value="Certificate of Good Moral Character" <?= ($finance['form_request'] == 'Certificate of Good Moral Character') ? 'selected' : '' ?>> Certificate of Good Moral Character</option>
                                    <option value="Certificate of Indigency" <?= ($finance['form_request'] == 'Certificate of Indigency') ? 'selected' : '' ?>> Certificate of Indigency</option>
                                    <option value="Clearance" <?= ($finance['form_request'] == 'Clearance') ? 'selected' : '' ?>> Clearance</option>
                                </select>
                            </div>
                            <div class="wrap-position-sub2">
                                <label for="position" class="block font-medium text-gray-900 dark:text-white"><b>Date Given</b></label>
                                <p id="view-view"><?php echo $finance['date_string'] ?></p>
                                <input type="date" name="finance_date" id="edit-view" value="<?php echo $finance['finance_date'] ?>">
                            </div>
                            <div class="wrap-position-sub2">
                                <label for="position" class="block font-medium text-gray-900 dark:text-white"><b>Status Request</b></label>
                                <p id="view-view"><?php echo $finance['status'] ?></p>
                                <select name="status" id="edit-view">
                                    <option selected disabled> Choose Status Type</option>
                                    <option value="Pending" <?= ($finance['status'] == 'Pending') ? 'selected' : '' ?>> Pending</option>
                                    <option value="Paid" <?= ($finance['status'] == 'Paid') ? 'selected' : '' ?>> Paid</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="wrap-position2">
                            <div class="wrap-position-sub2">
                                <label for="position" class="block font-medium text-gray-900 dark:text-white"><b>Amount Paid</b></label>
                                <input type="text" name="amount" id="edit-view" value="<?php echo $finance['amount'] ?>">
                                <p id="view-view"><?php echo '₱ ' . number_format($finance['amount'], 2, '.', ',') ?></p>
                            </div>
                            <div class="wrap-position-sub2">
                                <label for="position" class="block font-medium text-gray-900 dark:text-white"><b>Total Number of Request</b></label>
                                <p><?php echo $totalRequest ?></p>
                            </div>
                            <div class="wrap-position-sub2">
                                <label for="position" class="block font-medium text-gray-900 dark:text-white"><b>Total Amount Paid</b></label>
                                <p><?php echo '₱ ' . number_format($formAmount, 2, '.', ',') ?></p>
                            </div>
                        </div>

                        <div class="form_vaccine">
                            <hr>
                            <br>

                            <label for="position" class="block font-medium text-gray-900 dark:text-white">Purpose</label>
                            <textarea name="purpose" id="edit-view" cols="110" rows="5"><?php echo $finance['purpose'] ?></textarea>
                            <textarea id="view-view" rows="5" readonly><?php echo $finance['purpose'] ?></textarea>


                            <hr>
                            <br>
                            <center>
                                <h1><b>Transaction History</b> </h1>
                                <br>
                            </center>

                            <table id="clearance-list" class="table_transaction">
                                <thead>
                                    <tr>
                                        <th>Requested Forms</th>
                                        <th>Date Given</th>
                                        <th>Amount Paid</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($finance2 as $row) { ?>
                                        <tr>
                                            <td><?php echo $row['form_request'] ?></td>
                                            <td><?php echo $row['date_string'] ?></td>
                                            <td><?php echo '₱ ' . number_format($row['amount'], 2, '.', ',') ?></td>
                                            <td><?php echo $row['status'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>



                            <!-- Vaccine Button -->
                            <center>
                                <br><br><br>
                                <?php
                                if ($action == 'edit') {
                                ?>
                                    <button onclick="return  confirm('Do you want to edit this record?')" type="submit" name="submit_edit_finance" id="submitButton" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update Record</button>
                                <?php
                                } else {
                                ?>
                                    <button onclick="return  confirm('Do you want to delete this record?')" type="submit" name="submit_delete_finance" id="submitButton" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Delete Record</button>
                                <?php
                                }
                                ?>
                            </center>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="../../../../assets/js/sidebar.js"></script>
    <script src="./assets/js/resident-profiling.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>