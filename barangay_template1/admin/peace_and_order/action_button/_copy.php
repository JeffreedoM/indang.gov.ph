<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/deactivated.inc.php';
include_once '../function.php';


if (isset($_POST['add_comp'])) {
    $resident_type = $_POST['resident_type'];
    $incident_id = $_GET['add_id'];

    //insert to incident_reporting_person db
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];
    $bdate = $_POST['bdate'];
    $address = $_POST['address'];
    $desc = $_POST['desc'];

    $id = addNonResident($fname, $lname, $gender, $bdate, $number, $address);
    addIncidentComplainant($resident_type, $id, $incident_id);
}

if (isset($_POST['add_off'])) {
    $offender_type = $_POST['offender_type'];
    $incident_id = $_GET['add_id'];

    //insert to incident_reporting_person db
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];
    $bdate = $_POST['bdate'];
    $address = $_POST['address'];
    $desc = $_POST['desc'];

    $id = addNonResident($fname, $lname, $gender, $bdate, $number, $address);
    addIncidentOffender($offender_type, $id, $incident_id, $desc);
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
    <link rel="stylesheet" href="../../../assets/css/main.css" />

    <!-- Specific module styling -->
    <link rel="stylesheet" href="./../assets/css/styles.css">

    <!-- <link rel="stylesheet" href="../../assets/css/bs-overwrite.css" /> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <title>Admin Panel</title>
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
            </div>
            <table>
                <thead>
                    <tr>

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        </div>
    </main>


    </form>
    <script src="../../../assets/js/sidebar.js"></script>
    <script src="../../../assets/js/header.js"></script>
    <script src="./../assets/js/add-incident.js"></script>
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