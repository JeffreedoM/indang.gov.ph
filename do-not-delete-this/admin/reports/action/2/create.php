<?php
include '../../../../includes/deactivated.inc.php';
include '../../../../includes/session.inc.php';
include '../../../../includes/dbh.inc.php';
include '../../function.php';


if (isset($_POST['submit'])) {

    $_SESSION['cert_name'] = $_POST['cert_name'];
    $year = $_POST['cert_year'];
    $month = $_POST['cert_month'];
    $l_date = getLastDayOfMonth($year, $month);

    $_SESSION['l_date'] = $l_date;



    header('location: cert.php');

    exit;
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
    <!-- //bootstrap for calendar -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../../assets/css/main.css" />
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">

    <!-- css for data table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />


    <title>Admin Panel</title>
</head>

<body id="body1">
    <form method="POST" id="form1">
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


                            <div>
                                <input type="hidden" name="cert_name" value="Certificate Of Validation" required>

                            </div>
                            <div class="field-cov">
                                <span>Select Month</span>
                                <select type='month' name="cert_month" id="months" style="height:40px" required>
                                    <option value="" selected disabled>Month</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="field2-cov">
                                <span>Select Year</span>
                                <input type="text" class="form-control" name="cert_year" id="datepicker" placeholder="Year" style="height: 30px; margin-top: .3rem;  " required>
                            </div>
                            <div class="fieldBtn-cov">
                                <button type="submit" class="btn btn-secondary" style="margin-right: .3rem;">
                                    <a href="../../index.php">Back</a>
                                </button>
                                <button type="submit" name="submit" class="btn btn-primary">Generate Report</button>

                            </div>



                        </div>
                    </div>


                    </table>
                </div>

            </div>
    </form>



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
    </script>

    <!-- script for calling the table -->
    <script>
        $(document).ready(function() {
            $('#report-table').DataTable();
        });
    </script>

</body>

</html>