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
            <div class="page-body" style="display: flex; justify-content:center ;">
                <!-- report format -->

                <div class="whole">
                    <div class="head">

                        <H3>CERTIFICATE OF VALIDATION</H3>
                    </div>
                    <div class="body">

                        <form action="" method="POST">
                            <div>
                                <input type="hidden" name="cert_name" value="Certificate Of Validation">

                            </div>
                            <div class="field-cov">
                                <span>Select Month</span>
                                <select name="cert_month" id="months" style="height:40px">
                                    <option value="">Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                            <div class="field2-cov">
                                <span>Select Year</span>
                                <input type="text" class="form-control" name="cert_year" id="datepicker" placeholder="Year" style="height: 30px; margin-top: .3rem;  " />
                            </div>
                            <div class="fieldBtn-cov">
                                <button type="submit" class="btn btn-secondary" style="margin-right: .3rem;">
                                    <a href="../../index.php">Back</a>
                                </button>
                                <button type="submit" name="submit" class="btn btn-primary">Generate Report</button>

                            </div>

                        </form>

                    </div>
                </div>


                </table>
            </div>

        </div>
a

        <?php

        if (isset($_POST['submit'])) {
            $year = $_POST['cert_year'];
            $cert_name = $_POST['cert_name'];
            $month = $_POST['cert_month'];

            $conn = new mysqli('localhost', 'root', '', 'bmis');

            if ($conn->connect_error) {
                die('Connection Failed' . $conn->connect_error);
            } else {

                $stmt = $conn->prepare("INSERT INTO report_certificate (cert_name,cert_month, cert_year) VALUES (?,?,?)");
                $stmt->bind_param("sss", $cert_name, $month, $year);
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
    <!-- select year -->
    <script>
        $("#datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
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