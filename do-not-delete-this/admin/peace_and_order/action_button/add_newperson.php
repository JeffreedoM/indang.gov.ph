<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/deactivated.inc.php';
include_once '../includes/function.php';


//selecting offender and complainant
$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$residents = $stmt->fetchAll();

$o_residents = $residents;
$incident_id = $_GET['add_id'];

//Array all Id in Complainant and Offender
$o_ids = [];
$c_ids = [];

foreach (getIncidentOffender($pdo, $incident_id) as $o_id) {
    $o_ids[] = $o_id['resident_id'];
}

foreach (getIncidentComplainant($pdo, $incident_id) as $c_id) {
    $c_ids[] = $c_id['resident_id'];
}
$o_ids = json_encode($o_ids);
$c_ids = json_encode($c_ids);



if (isset($_POST['add_comp'])) {
    $id = $_POST['complainant_id'];
    $complainant_type = $_POST['resident_type'];

    //insert to incident_reporting_person db
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];
    $bdate = $_POST['bdate'];
    $address = $_POST['address'];

    if ($complainant_type === 'resident') {
        addIncidentComplainant($complainant_type, $id, $incident_id);
    } else {
        $id = addNonResident($fname, $lname, $gender, $bdate, $number, $address, $barangayId, $incident_id);
        addIncidentComplainant($complainant_type, $id, $incident_id);
    }
    // header("Location: ../list_incident.php");
    // exit;
}

if (isset($_POST['add_off'])) {
    $id = $_POST['offender_id'];
    $offender_type = $_POST['offender_type'];

    //insert to incident_reporting_person db
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];
    $bdate = $_POST['bdate'];
    $address = $_POST['address'];
    $desc = $_POST['desc'];

    if ($offender_type === 'resident') {
        addIncidentOffender($offender_type, $id, $incident_id, $desc);
    } else {
        $id = addNonResident($fname, $lname, $gender, $bdate, $number, $address, $barangayId, $incident_id);
        addIncidentOffender($offender_type, $id, $incident_id, $desc);
    }

    // header("Location: ../list_incident.php");
    // exit;
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
    <!-- for logo -->
    <script src="https://kit.fontawesome.com/4c7eb3588b.js" crossorigin="anonymous"></script>
    <!-- all id in offender/complainant -->
    <script>
        var oIds = <?php echo $o_ids; ?>;
        var cIds = <?php echo $c_ids; ?>;
    </script>
    <!-- Specific module styling -->
    <link rel="stylesheet" href="./../assets/css/styles.css">

    <!-- <link rel="stylesheet" href="../../assets/css/bs-overwrite.css" /> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <style>
        table {
            width: 900px;
            margin-bottom: 10px;
        }

        .list_involve td {
            text-align: center;
        }

        th {
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

        hr {
            border: none;
            border-top: 5px solid #ccc;
        }

        .hidden-cell {
            display: none;
        }

        .hidden {
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

                <div style="float: right;">
                    <button type="button"><a href="../list_incident.php"><i class="fa-regular fa-circle-xmark fa-2xl"></i></a></button>
                </div>
                <br>
                <h1 style="text-align:center; font-size: 20px;"><b>Add Involve Person</b></h1>
                <br>
                <!-- SELECT TYPE OF RESIDENT -->
                <div style="display: flex; align-items: center;">
                    <label style="margin-right: 0.5rem" for="select_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">SELECT TYPE:</label>
                    <select name="select_res" onchange="showInput()" id="select_type" class="bg-gray-500 text-white rounded-md px-4 py-2">
                        <option value="complainant">Complainant</option>
                        <option value="offender">Offender</option>
                    </select>


                </div>

                <!-- Reporting person/Complainant -->
                <div id="complainant" style="display: visible;">
                    <form id="form1" method="POST">
                        <table*>
                            <br>
                            <br>
                            <h3><strong>Reporting person/Complainant</strong></h3>
                            <!-- first select resident type -->
                            <div class="mb-4">
                                <select onchange="showInput1()" id="res_type" name="resident_type" class="bg-red-50 border border-red-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" selected disabled>Select Resident Type</option>
                                    <option value="resident">Resident</option>
                                    <option value="not resident">Non-Resident</option>
                                </select>
                            </div>
                            <div id="c_input">
                                <!-- list of resident complainant -->
                                <?php include '../includes/resident_comp.php'; ?>

                                <!-- Name -->
                                <div style="margin-top: 1rem;" class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="hidden" name="complainant_id" class="complainant_id">
                                        <input type="text" name="fname" id="complainant_fname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="lname" id="complainant_lname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                                    </div>
                                </div>

                                <!-- Number -->

                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="tel" pattern="[0-9]{4}[0-9]{3}[0-9]{4}" name="number" id="contact" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                                    <select name="gender" id="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="" selected disabled>--Select--</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <!--Birthdate -->
                                <div style="margin-top: 1rem;">
                                    <div class="relative w-1/2 sm:w-full">
                                        <label for="">Birthdate <span class="required-input">*</span></label>
                                        <div>
                                            <input type="date" name="bdate" id="bdate" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                        </div>
                                    </div>
                                </div>
                                <!--Address -->
                                <div style="margin-top: 1rem;" class="relative z-0 w-full mb-6 group">
                                    <input type="text" name="address" id="address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    <label for="floating_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Address</label>
                                </div>
                            </div>
                            <br>
                            <button onclick="alert('Complainant Person Successfully Added')" type="submit" name="add_comp" style="display: flex;" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Submit</button>
                            </table>

                    </form>
                </div>

                <!--  OFFENDER FORM -->
                <div id="offender" style="display: none;">
                    <form method="POST">
                        <br>
                        <br>
                        <h3><strong>Offender/s</strong></h3>
                        <!-- select type of resident -->
                        <div class="mb-4">
                            <select onchange="showInput2()" id="res_type2" name="offender_type" class="bg-red-50 border border-red-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="" selected disabled>Select Resident Type</option>
                                <option value="resident">Resident</option>
                                <option value="not resident">Non-Resident</option>
                            </select>
                        </div>
                        <div id="o_input">
                            <!-- list of resident offender -->
                            <?php include '../includes/resident_off.php'; ?>

                            <!-- Name -->
                            <div style="margin-top: 1rem;" class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="hidden" name="offender_id" class="offender_id">
                                    <input type="text" name="fname" id="o_fname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                                </div>
                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="text" name="lname" id="o_lname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                                </div>
                            </div>

                            <!-- Number -->
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="tel" pattern="[0-9]{4}[0-9]{3}[0-9]{4}" name="number" id="o_contact" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone number</label>
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                                <select name="gender" id="o_gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" selected disabled>--Select--</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <!--Birthdate -->
                            <div style="margin-top: 1rem;">
                                <div class="relative w-1/2 sm:w-full">
                                    <label for="">Birthdate <span class="required-input">*</span></label>
                                    <div>
                                        <input type="date" name="bdate" id="o_bdate" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                    </div>
                                </div>
                            </div>
                            <!--Address -->
                            <div style="margin-top: 1rem;" class="relative z-0 w-full mb-6 group">
                                <input type="text" name="address" id="o_address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="floating_address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Address</label>
                            </div>
                            <!-- Description -->
                            <div>
                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea name="desc" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter description..." required></textarea>
                            </div>
                        </div>
                        <br>
                        <button onclick="alert('Offender Person Successfully Added')" type="submit" name="add_off" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
                    </form>
                </div>

            </div>

    </main>
    <script src="./../assets/js/add-newperson.js"></script>
    <script src="../../../assets/js/sidebar.js"></script>
    <script src="./../assets/js/add-incident.js"></script>
    <script src="./../assets/js/remote_modals.js"></script>
    <!-- <script src="./assets/js/required.js"></script> -->
    <script src="./../assets/js/select-resident.js"></script>
    <script src="./../assets/js/disabled_input.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        /* set max date to current date */
        document.getElementById("bdate").max = new Date().toISOString().split("T")[0];

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