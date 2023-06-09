<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/deactivated.inc.php';
include './../includes/function.php';
//Getting residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$residents = $stmt->fetchAll(PDO::FETCH_ASSOC);
$o_residents = $residents;

$incident_id = $_GET['update_id'];

//select the incident/offender/complainant
$stmt = $pdo->prepare("SELECT * FROM incident_table WHERE incident_id = :incident_id");
$stmt->bindParam(':incident_id', $incident_id);
$stmt->execute();
$incident = $stmt->fetchAll(PDO::FETCH_ASSOC);

$complainants = getIncidentComplainant($pdo, $incident_id);
$offenders = getIncidentOffender($pdo, $incident_id);
foreach ($incident as $list);
$case = $list['case_incident'];

//for report person/complainant resident
foreach ($complainants as $list1);
$c_fname = $list1['resident_id'] !== null ? $list1['firstname'] : $list1['non_res_firstname'];
$c_lname = $list1['resident_id'] !== null ? $list1['lastname'] : $list1['non_res_lastname'];
$c_gender = $list1['resident_id'] !== null ? $list1['sex'] : $list1['non_res_gender'];
$c_bdate = $list1['resident_id'] !== null ? $list1['birthdate'] : $list1['non_res_birthdate'];
$c_number = $list1['resident_id'] !== null ? $list1['contact'] : $list1['non_res_contact'];
$c_address = $list1['resident_id'] !== null ? $list1['address'] : $list1['non_res_address'];


//for offender person resident
foreach ($offenders as $list2);
$o_fname = $list2['resident_id'] !== null ? $list2['firstname'] : $list2['non_res_firstname'];
$o_lname = $list2['resident_id'] !== null ? $list2['lastname'] : $list2['non_res_lastname'];
$o_gender = $list2['resident_id'] !== null ? $list2['sex'] : $list2['non_res_gender'];
$o_bdate = $list2['resident_id'] !== null ? $list2['birthdate'] : $list2['non_res_birthdate'];
$o_number = $list2['resident_id'] !== null ? $list2['contact'] : $list2['non_res_contact'];
$o_address = $list2['resident_id'] !== null ? $list2['address'] : $list2['non_res_address'];
$desc = $list2['desc'];





if (isset($_POST['submit'])) {
    // Retrieve the existing incident ID
    // $incident_id = $_POST['incident_id'];

    // Retrieve the existing data for the incident
    $stmt = $pdo->prepare("SELECT * FROM incident_table WHERE incident_id = :incident_id");
    $stmt->bindParam(':incident_id', $incident_id);
    $stmt->execute();
    $existing_incident = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the incident exists
    if ($existing_incident) {
        // Update the incident details
        $offender_type = $_POST['o_res'];
        $complainant_type = $_POST['c_res'];
        $blotter_type = $_POST['blotter_type'];

        // Update the complainant data
        if ($complainant_type === 'resident') {
            $complainant_id = !empty($list1['resident_id']) ? $list1['resident_id'] : $_POST['complainant_id'];
        } else {
            $complainant_fname = $_POST['c_fname'];
            $complainant_lname = $_POST['c_lname'];
            $complainant_gender = $_POST['c_gender'];
            $complainant_bdate = $_POST['c_bdate'];
            $complainant_number = $_POST['c_number'];
            $complainant_address = $_POST['c_address'];
        }

        // Update the offender data
        if ($offender_type === 'resident') {
            $offender_id = !empty($list2['resident_id']) ? $list2['resident_id'] : $_POST['offender_id'];
        } else {
            $offender_fname = $_POST['o_fname'];
            $offender_lname = $_POST['o_lname'];
            $offender_gender = $_POST['o_gender'];
            $offender_bdate = $_POST['o_bdate'];
            $offender_number = $_POST['o_number'];
            $offender_address = $_POST['o_address'];
            $description = $_POST['desc'];
        }

        // Update the incident_table db
        $case_incident = ($_POST['i_case'] === 'more') ? $_POST['case_more'] : $_POST['i_case'];
        $i_title = $_POST['i_title'];
        $i_date = $_POST['i_date'];
        $i_time = $_POST['i_time'];
        $location = $_POST['i_location'];
        $status = 1;
        $narrative = $_POST['narrative'];

        $stmt3 = $pdo->prepare("UPDATE incident_table SET case_incident = :case_incident, incident_title = :i_title, date_incident = :i_date, time_incident = :i_time, location = :location, status = :status, narrative = :narrative, blotterType_id = :blotterType_id, barangay_id = :b_id WHERE incident_id = :incident_id");
        $stmt3->bindParam(':case_incident', $case_incident);
        $stmt3->bindParam(':i_title', $i_title);
        $stmt3->bindParam(':i_date', $i_date);
        $stmt3->bindParam(':i_time', $i_time);
        $stmt3->bindParam(':location', $location);
        $stmt3->bindParam(':status', $status);
        $stmt3->bindParam(':narrative', $narrative);
        $stmt3->bindParam(':blotterType_id', $blotter_type);
        $stmt3->bindParam(':b_id', $barangayId);
        $stmt3->bindParam(':incident_id', $incident_id);

        // Execute the update query
        $pdo->beginTransaction();
        $stmt3->execute();
        $pdo->commit();

        // Update the complainant data
        if ($complainant_type === 'resident') {
            $stmt = $pdo->prepare("UPDATE incident_complainant SET complainant_type = :complainant_type, resident_id = :resident_id WHERE incident_id = :incident_id");
            $stmt->bindParam(':complainant_type', $complainant_type);
            $stmt->bindParam(':resident_id', $complainant_id);
            $stmt->bindParam(':incident_id', $incident_id);
        } else {
            $stmt = $pdo->prepare("UPDATE non_resident SET non_res_firstname = :non_res_firstname, non_res_lastname = :non_res_lastname, non_res_gender = :non_res_gender, non_res_birthdate = :non_res_birthdate, non_res_contact = :non_res_contact, non_res_address = :non_res_address, barangay_id = :b_id WHERE incident_id = :incident_id");
            $stmt->bindParam(':non_res_firstname', $complainant_fname);
            $stmt->bindParam(':non_res_lastname', $complainant_lname);
            $stmt->bindParam(':non_res_gender', $complainant_gender);
            $stmt->bindParam(':non_res_birthdate', $complainant_bdate);
            $stmt->bindParam(':non_res_contact', $complainant_number);
            $stmt->bindParam(':non_res_address', $complainant_address);
            $stmt->bindParam(':b_id', $barangayId);
            $stmt->bindParam(':incident_id', $incident_id);
        }
        echo $complainant_id;
        // Execute the update query
        $pdo->beginTransaction();
        $stmt->execute();
        $pdo->commit();

        // Update the offender data
        if ($offender_type === 'resident') {
            $stmt = $pdo->prepare("UPDATE incident_offender SET offender_type = :offender_type, resident_id = :resident_id, `desc` = :desc WHERE incident_id = :incident_id");
            $stmt->bindParam(':offender_type', $offender_type);
            $stmt->bindParam(':resident_id', $offender_id);
            $stmt->bindParam(':desc', $description);
            $stmt->bindParam(':incident_id', $incident_id);
        } else {
            $stmt = $pdo->prepare("UPDATE non_resident SET non_res_firstname = :non_res_firstname, non_res_lastname = :non_res_lastname, non_res_gender = :non_res_gender, non_res_contact = :non_res_contact, non_res_birthdate = :non_res_birthdate, non_res_address = :non_res_address, barangay_id = :b_id WHERE incident_id = :incident_id");
            $stmt->bindParam(':non_res_firstname', $offender_fname);
            $stmt->bindParam(':non_res_lastname', $offender_lname);
            $stmt->bindParam(':non_res_gender', $offender_gender);
            $stmt->bindParam(':non_res_contact', $offender_number);
            $stmt->bindParam(':non_res_birthdate', $offender_bdate);
            $stmt->bindParam(':non_res_address', $offender_address);
            $stmt->bindParam(':b_id', $barangayId);
            $stmt->bindParam(':incident_id', $incident_id);
        }

        // Execute the update query
        $pdo->beginTransaction();
        $stmt->execute();
        $pdo->commit();

        header('location: ../list_incident.php');
    }
    return false; // Return false if the form was not submitted
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

    <style>
        hr {
            border: none;
            border-top: 5px solid #ccc;
        }

        .hidden-cell {
            display: none;
        }
    </style>

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


                <!-- INPUT FORMS IN ADD INCIDENT -->
                <!-- Modal -->
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <a href="../list_incident.php"> Back</a></button>
                <br>
                <h1 style="text-align:center; font-size: 20px;"><b>Edit Incident Blotter</b></h1>
                <br>
                <form id="myForm" action="" method="POST">

                    <!-- Complainant -->
                    <h3>Reporting Person/Complainant</h3>

                    <div class="mb-1">
                        <select name="blotter_type" class="bg-green-50 border border-green-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected disabled>Select Blotter Type</option>
                            <option value="1" <?php if ($list['blotterType_id'] == 1) {
                                                    echo "selected";
                                                } ?>>Complaint</option>
                            <option value="2" <?php if ($list['blotterType_id'] == 2) {
                                                    echo "selected";
                                                } ?>>Incident</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <select onchange="showInput1()" id="res_type" name="c_res" class="bg-red-50 border border-red-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected disabled>Select Resident Type</option>
                            <option value="resident" <?php if ($list1['complainant_type'] == 'resident') {
                                                            echo 'selected';
                                                        } ?>>Resident</option>
                            <option value="not resident" <?php if ($list1['complainant_type'] == 'not resident') {
                                                                echo 'selected';
                                                            } ?>>Non-Resident</option>
                        </select>
                    </div>
                    <div id="c_input">
                        <?php include '../includes/resident_comp.php'; ?>


                        <!-- Name -->
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="hidden" name="complainant_id" class="complainant_id">
                                <input type="text" name="c_fname" value="<?php echo $c_fname; ?>" id="complainant_fname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="c_lname" value="<?php echo $c_lname; ?>" id="complainant_lname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                            </div>
                        </div>

                        <!-- Number -->
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="tel" value="<?php echo $c_number; ?>" name="c_number" id="contact" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                            <select id="gender" name="c_gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled selected>Gender</option>
                                <option value="Male" <?php if ($c_gender == 'Male') {
                                                            echo 'selected';
                                                        } ?>>Male</option>
                                <option value="Female" <?php if ($c_gender == 'Female') {
                                                            echo 'selected';
                                                        } ?>>Female</option>
                            </select>
                        </div>

                        <!--Birthdate -->
                        <div class="mb-5">
                            <label for="">Birthdate <span class="required-input">*</span></label>
                            <div class="relative w-1/2 sm:w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="date" value="<?php echo $c_bdate; ?>" name="c_bdate" id="bdate" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                            </div>
                        </div>

                        <!--Address -->
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="c_address" value="<?php echo $c_bdate; ?>" id="address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="floating_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                Address</label>
                        </div>
                    </div>
                    <br><br>

                    <!-- OFFENDER INPUTS-->
                    <h3>Offender Person</h3>
                    <!--horizontal line -->
                    <hr>
                    <div id="o_input" style="margin-top: 10px;">
                        <div class="mb-3">
                            <select onchange="showInput2()" id="res_type2" name="o_res" class="bg-red-50 border border-red-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" selected disabled>Select Resident Type</option>
                                <option value="resident" <?php if ($list2['offender_type'] == 'resident') {
                                                                echo 'selected';
                                                            } ?>>Resident</option>
                                <option value="not resident" <?php if ($list2['offender_type'] == 'not resident') {
                                                                    echo 'selected';
                                                                } ?>>Non-Resident</option>
                            </select>
                        </div>

                        <?php include '../includes/resident_off.php'; ?>

                        <!-- Name -->
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="hidden" name="offender_id" class="offender_id">
                                <input type="text" name="o_fname" id="o_fname" value="<?php echo $o_fname; ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="o_lname" id="o_lname" value="<?php echo $o_lname; ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                            </div>
                        </div>

                        <!-- Number -->
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="tel" value="<?php echo $o_number; ?>" name="o_number" id="o_contact" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                            <select id="o_gender" name="o_gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled selected>Gender</option>
                                <option value="Male" <?php if ($o_gender == 'Male') {
                                                            echo 'selected';
                                                        } ?>>Male</option>
                                <option value="Female" <?php if ($o_gender == 'Female') {
                                                            echo 'selected';
                                                        } ?>>Female</option>
                            </select>
                        </div>

                        <!--Birthdate -->
                        <div class="mb-5">
                            <label for="">Birthdate <span class="required-input">*</span></label>
                            <div class="relative w-1/2 sm:w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="date" name="o_bdate" id="o_bdate" value="<?php echo $o_bdate; ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                            </div>
                        </div>

                        <!--Address -->
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="o_address" id="o_address" value="<?php echo $o_address; ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="floating_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                Address</label>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea name="desc" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter narrative..."><?php echo $desc; ?></textarea>
                        </div>
                    </div>


                    <!-- INCIDENT DETAILS -->
                    <!-- criminal case -->
                    <br>
                    <br>
                    <br>
                    <h3>Incident Details</h3>
                    <hr>
                    <div id="radio" class="flex" style="margin-top: 10px;">
                        <div class="flex items-center mr-4">
                            <input onclick="showInput()" id="criminalRadio" type="radio" value="criminal" name="i_case" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" <?php echo isChecked('criminal', $case); ?>>
                            <label for="criminalRadio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Criminal</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input onclick="showInput()" id="civilRadio" type="radio" value="civil" name="i_case" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" <?php echo isChecked('civil', $case); ?>>
                            <label for="civilRadio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Civil</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input onclick="showInput()" type="radio" id="i_others" name="i_case" value="more" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" <?php echo isChecked('more', $case); ?>>
                            <label for="i_others" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Others</label>
                        </div>
                        <div id="otherInput" style="display:none;">
                            <input type="text" name="case_more" value="<?php echo $case; ?>" class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" placeholder="other case...">
                        </div>
                    </div>


                    <!-- incident title -->
                    <div class="my-3">
                        <label>Incident Title</label>
                        <input type="text" name="i_title" value="<?php echo $list['incident_title']; ?>" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    </div>

                    <!-- date -->
                    <div class="mb-3">
                        <label>Date of Incident</label>
                        <input type="date" name="i_date" value="<?php echo $list['date_incident']; ?>" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    </div>

                    <!-- time -->
                    <div class="mb-3">
                        <label>Time of Incident</label>
                        <input type="time" name="i_time" value="<?php echo $list['time_incident']; ?>" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    </div>

                    <!-- location -->
                    <div class="mb-3">
                        <label>Location of incident</label>
                        <input type="text" name="i_location" value="<?php echo $list['location']; ?>" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    </div>
                    <!-- Narrative -->
                    <div>
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Narrative</label>
                        <textarea name="narrative" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..."><?php echo $list['narrative']; ?></textarea>
                    </div>
            </div>

            <div class="modal-footer" class="mt-2">
                <button name="submit" type="submit" class="w-full mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Save Changes</button>
            </div>
            </form>




        </div>
        </div>
    </main>



    <script src="../../../assets/js/sidebar.js"></script>
    <script src="./../assets/js/add-incident.js"></script>
    <script src="./../assets/js/remote_modals.js"></script>
    <!-- <script src="./assets/js/required.js"></script> -->
    <script src="./../assets/js/radioInput_more.js"></script>
    <script src="./../assets/js/select-resident.js"></script>
    <script src="./../assets/js/disabled_input.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
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