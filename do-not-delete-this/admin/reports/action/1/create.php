<?php
include '../../../../includes/deactivated.inc.php';
include '../../../../includes/session.inc.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <!-- //bootstrap for calendar -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../../assets/css/main.css" />
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">

    <!-- css for data table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />


    <title>Admin Panel</title>
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
                <!-- report format -->
                <div class="head">
                    <p>
                        Republic of the Philippines
                    </p>
                    <p> Province of Cavite</p>
                    <p> Municipality of Indang</p>



                    BARANGAY <span style="font-weight: bold ;"><?php echo $barangay['b_name']; ?></span>
                    <H3>OFFICE OF THE SANGGUNIANG BARANGAY</H3>
                </div>
                <div class="body">
                    <form action="" method="POST">
                        <div>
                            <input type="hidden" name="reportName" value="Accomplishment Report">
                        </div>
                        <div class="field1">
                            <span>ACCOMPLSHMENT REPORT FOR </span>
                            <input type="text" class="form-control" name="month" id="datepicker1" placeholder="Month" style="height: 30px; margin-top: .3rem; width:80px;" required>
                            <input type="text" class="form-control" name="year" id="datepicker" placeholder="Year" style="height: 30px; margin-top: .3rem; width:60px;" required>
                        </div>
                        <div class="field">
                            <textarea name="reportContent" id="" cols="30" rows="10" maxlength="500" style="width : 70%" required></textarea>
                        </div>
                        <div class="fieldBtn">
                            <button type="submit" class="btn btn-secondary" style="margin-right: .3rem;">
                                <a href="../../index.php">Back</a>
                            </button>
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>

                        </div>

                    </form>
                </div>

                </table>
            </div>

        </div>


        <?php

        if (isset($_POST['submit'])) {
            $reportName = $_POST['reportName'];
            $reportContent = $_POST['reportContent'];
            $month = $_POST['month'];
            $year = $_POST['year'];

            $conn = new mysqli('localhost', 'root', '', 'bmis');

            if ($conn->connect_error) {
                die('Connection Failed' . $conn->connect_error);
            } else {

                $stmt = $conn->prepare("INSERT INTO report_accomplishment (acc_name, acc_content, `month`,`year`) VALUES (?,?,?,?)");
                $stmt->bind_param("ssss", $reportName, $reportContent, $month, $year);
                $stmt->execute();
                $stmt->close();
            }

            echo "<script>window.location.href='../../index.php';</script>";
            exit();
        }

        ?>



    </main>
    <script src="../../../../assets/js/sidebar.js"></script>
    <script src="../../../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <!-- js for jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- js for data table -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

    <!-- date picker -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <!-- validate inputs -->
    <script src="./../../assets/js/validate_input.js"></script>
    <!-- select year -->
    <script>
        $("#datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
        $("#datepicker1").datepicker({
            format: "MM",
            viewMode: "months",
            minViewMode: "months"
        });
    </script>

    <!-- script for calling the table -->
    <script>
        $(document).ready(function() {
            $('#report-table').DataTable();
        });
    </script>

</body>

</html>