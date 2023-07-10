<?php
include '../../../../includes/deactivated.inc.php';
include '../../../../includes/session.inc.php';
include '../../../../includes/dbh.inc.php';
include '../../function.php';


$b_name = $barangay['b_name'];
$officials = getBrgyOfficials($pdo, $barangayId);

//session from create.php
$cert_name = $_SESSION['cert_name'];
$l_date = $_SESSION['l_date'];

if (isset($_POST['submit'])) {
    $capt = $_POST['capt'];
    $stmt = $pdo->prepare("INSERT INTO report_certificate (cert_name, capt, Ldate, barangay_id) VALUES (?,?,?,?)");
    $stmt->execute([$cert_name, $capt, $l_date, $barangayId]);

    echo "<script>window.location.href='../../index.php';</script>";
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
    <!-- <link rel="stylesheet" href="../../assets/css/style.css" /> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">

    <!-- css for data table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />


    </script>
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

                    </div>
                    <div class="body">

                        <form action="" method="POST">
                            <div class='title'>
                                <center>
                                    Republic of the Philippines
                                    <br>
                                    Department of Interior and Local Government
                                    <br>
                                    Province of Cavite
                                    <br>
                                    Municipality of Indang
                                    <br>
                                    BARANGAY <?php echo $b_name; ?>

                                </center>
                            </div>
                            <div class="office" style="border-bottom: 1px solid black; width: 100%; margin-top: 40px;">
                                <center>
                                    OFFICE OF THE PUNONG BARANGAY
                                </center>
                            </div>
                            <div style="text-align:center; margin-top: 20px">

                                <h3>CERTIFICATE OF VALIDATION</h3>
                            </div>
                            <div style="text-align:center;">
                                <p>

                                    THIS IS TO CERTIFY that based on the Barangay Blotter Book, no complaint
                                    <br>
                                    was received/ handled by this Barangay for the period of 01 to <?php echo $l_date; ?>.

                                </p>
                            </div>
                            <!-- input brgy captain -->
                            <div style="text-align:center; margin-top: 100px;">
                                <input type="text" name="capt" class="text-center" value="<?php echo !empty($officials['captain']) ? $officials['captain']['firstname'] . ' ' . $officials['captain']['lastname'] : '' ?>" required>
                                <label for="brgy_capt">Barangay Captain</label>


                            </div>
                            <!-- submit button -->
                            <div style="text-align:right; margin-right: 10px; margin-top:40px">

                                <button class="btn btn-secondary">
                                    <a href="create.php"> Cancel </a>
                                </button>
                                <button type="submit" name="submit" class="btn btn-primary">
                                    Save</button>
                            </div>

                        </form>

                    </div>
                </div>


                </table>
            </div>

        </div>





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

    <!-- script for calling the table -->
    <script>
        $(document).ready(function() {
            $('#report-table').DataTable();
        });
    </script>

</body>

</html>