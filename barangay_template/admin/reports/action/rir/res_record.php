<?php
include '../../../../includes/deactivated.inc.php';
include '../../../../includes/session.inc.php';
include './resFilter_modal.php';

// Fetch data from the database using PDO
$report = $pdo->query("SELECT * FROM report_resident")->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../../assets/css/main.css">
    <!-- css for data table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="icon" type="image/x-icon" href="../../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Reports</title>

    <style>
        #btn1,
        #btn2 {
            width: 100px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .button-container #uncheckButton {
            color: red;
            margin-left: auto;
        }

        /* Underline the buttons when hovered */
        .button-container button:hover {
            text-decoration: underline;
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
                <h3 class="page-title">Reports</h3>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <a href="../../index.php">Back</a></button>

                <!-- Modal toggle -->
                <div style="float: right;">
                    <button data-modal-target="filter-modal" data-modal-toggle="filter-modal" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:focus:ring-yellow-900" type="button">
                        Filter
                    </button>
                </div>
                <table class="row-border hover" id="report-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($report as $row) { ?>
                            <tr>
                                <td style="width: 20%;"><?php echo $row['rres_id']; ?></td>
                                <td><?php echo $row['rres_category']; ?></td>
                                <td style="width: 40%;">
                                    <div class="button_f">
                                        <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 ">
                                            <a href="../../excel/excel.php?id=<?php echo $row['rres_id']; ?>">Excel</a></button>
                                        <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-6 py-4 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                            <a href="../../pdf/report_pdf.php?id=<?php echo $row['rres_id']; ?>" target="_blank">Pdf</a></button>
                                    </div>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>

                </table>
            </div>

        </div>

        <?php include './resFilter_modal.php' ?>
    </main>

    <script src="../../../../assets/js/sidebar.js"></script>
    <!-- <script src="../../../../assets/js/header.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <!-- js for jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- js for data table -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <!-- js for datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.0/datepicker.min.js"></script>

    <!-- script for calling the table -->
    <script>
        $(document).ready(function() {
            $('#report-table').DataTable();
        });
    </script>

</body>

</html>