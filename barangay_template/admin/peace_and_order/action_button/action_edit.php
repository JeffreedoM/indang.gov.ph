<?php
include '../../../includes/dbh.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/deactivated.inc.php';
include './../includes/function.php';

$incident_id = $_GET['update_id'];

//Getting residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$residents = $stmt->fetchAll(PDO::FETCH_ASSOC);
$o_residents = $residents;




//select the incident/offender/complainant
$stmt = $pdo->prepare("SELECT * FROM incident_table WHERE incident_id = :incident_id");
$stmt->bindParam(':incident_id', $incident_id);
$stmt->execute();

$incident = $stmt->fetchAll(PDO::FETCH_ASSOC);

$complainants = getIncidentComplainant($pdo, $incident_id);
$offenders = getIncidentOffender($pdo, $incident_id);
foreach ($incident as $list) {
    $blotter_type = $list['blotterType_id'];
    $status = $list['status'];
    $case = $list['case_incident'];
    $i_title = $list['incident_title'];
    $i_date = $list['date_incident'];
    $i_time = $list['time_incident'];
    $location = $list['location'];
    $narr_json = $list['narrative'];
    $narrs = json_decode($narr_json, true);
}

// selecting incident history for hearing status and date
$stmt = $pdo->prepare("SELECT * FROM incident_history WHERE incident_id = :incident_id");
$stmt->bindParam(':incident_id', $incident_id);
$stmt->execute();
$history = $stmt->fetchAll();

foreach ($history as $list) {
    $hearing_date = json_decode($list['hearing_status'], true);
    $hearing_status = json_decode($list['status_input'], true);
}


if (isset($_POST['submit'])) {
    try {

        // Retrieve the existing data for the incident
        $stmt = $pdo->prepare("SELECT * FROM incident_table WHERE incident_id = :incident_id");
        $stmt->bindParam(':incident_id', $incident_id);
        $stmt->execute();
        $existing_incident = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the incident exists
        if ($existing_incident) {
            $blotter_type = $_POST['blotter_type'];

            // Update the incident_table db
            $case_incident = ($_POST['i_case'] === 'more') ? $_POST['case_more'] : $_POST['i_case'];
            $i_title = $_POST['i_title'];
            $i_date = $_POST['i_date'];
            $i_time = $_POST['i_time'];
            $location = $_POST['i_location'];
            $status = $_POST['status'];



            $narratives = $_POST['narrative'];
            $narratives = array_filter($narratives, function ($value) {
                return $value !== "";
            });

            $jsonNarrative = json_encode($narratives);

            // for hearing_status and hearing_date
            if (!empty($_POST['dateHearing']) && !empty($_POST['statusInput'])) {
                $dateHearing = $_POST['dateHearing'];
                $statusInput = $_POST['statusInput'];

                $dateHearing = json_encode($dateHearing);
                $statusInput = json_encode($statusInput);

                $stmt = $pdo->prepare("UPDATE incident_history SET hearing_status = :hearing_status, status_input = :statusInput , incident_id = :incident_id WHERE incident_id = :incident_id");
                $stmt->bindParam(":hearing_status", $dateHearing);
                $stmt->bindParam(":statusInput", $statusInput);
                $stmt->bindParam(":incident_id", $incident_id);
                $pdo->beginTransaction();
                $stmt->execute();
                $pdo->commit();
            }

            $stmt3 = $pdo->prepare("UPDATE incident_table SET case_incident = :case_incident, incident_title = :i_title, date_incident = :i_date, time_incident = :i_time, `location` = :location, `status` = :status, narrative = :narrative, blotterType_id = :blotterType_id, barangay_id = :b_id WHERE incident_id = :incident_id");
            $stmt3->bindParam(':case_incident', $case_incident);
            $stmt3->bindParam(':i_title', $i_title);
            $stmt3->bindParam(':i_date', $i_date);
            $stmt3->bindParam(':i_time', $i_time);
            $stmt3->bindParam(':location', $location);
            $stmt3->bindParam(':status', $status);
            $stmt3->bindParam(':narrative', $jsonNarrative);
            $stmt3->bindParam(':blotterType_id', $blotter_type);
            $stmt3->bindParam(':b_id', $barangayId);
            $stmt3->bindParam(':incident_id', $incident_id);


            // Execute the update query
            $pdo->beginTransaction();
            $stmt3->execute();
            $pdo->commit();


            header("location: ../list_incident.php");
            exit;
        }
    } catch (PDOException $e) {
        // Handle the exception/error here
        echo "Error: " . $e->getMessage();
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
    <script src="https://kit.fontawesome.com/4c7eb3588b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../assets/css/main.css" />
    <!-- Specific module styling -->
    <link rel="stylesheet" href="./../assets/css/styles.css">

    <!-- <link rel="stylesheet" href="../../assets/css/bs-overwrite.css" /> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="icon" type="image/x-icon" href="../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Peace and Order</title>
    <style>
        hr {
            border: none;
            border-top: 5px solid #ccc;
        }

        .hidden-cell {
            display: none;
        }


        textarea {
            width: 300px;
            /* Set the desired width */
            height: 150px;
        }

        .delete-button {
            float: right;
            color: red;
        }

        .delete-button2 {
            float: right;
            color: red;
        }

        .textN {
            margin-top: auto;
        }

        .split {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

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
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <a href="../list_incident.php"> Back</a></button>
                <br>
                <h1 style="text-align:center; font-size: 20px;"><b>Edit Incident Blotter</b></h1>
                <br>
                <form id="myForm" action="" method="POST">
                    <!-- SELECT BLOTTER TYPE -->
                    <div class="mb-1">
                        <select name="blotter_type" class="bg-green-50 border border-green-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected disabled>Select Blotter Type</option>
                            <option value="1" <?php if ($blotter_type == 1) {
                                                    echo "selected";
                                                } ?>>Complaint</option>
                            <option value="2" <?php if ($blotter_type == 2) {
                                                    echo "selected";
                                                } ?>>Incident</option>
                        </select>
                    </div>

                    <!-- INCIDENT DETAILS -->
                    <!-- criminal case -->
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
                            <input type="text" name="case_more" value="<?php echo $case; ?>" class="block w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" placeholder="other case...">
                        </div>
                    </div>

                    <!-- incident title -->
                    <div class="my-3">
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label>Incident Title</label>
                                <input type="text" name="i_title" value="<?php echo $i_title; ?>" required class="block w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                            </div>
                            <div class="relative z-0 w-1/2 mb-6 group">
                                <label for="status">Status</label>
                                <select name="status" id="status" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="1" <?php echo $status === '1' ? "selected" : ""; ?>>On-going</option>
                                    <option value="2" <?php echo $status === '2' ? "selected" : ""; ?>>Dismiss</option>
                                    <option value="3" <?php echo $status === '3' ? "selected" : ""; ?>>Certified 4a</option>
                                    <option value="4" <?php echo $status === '4' ? "selected" : ""; ?>>Mediated</option>
                                    <option value="5" <?php echo $status === '5' ? "selected" : ""; ?>>Resolved</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- date -->
                    <div class="mb-3">
                        <label>Date of Incident</label>
                        <input type="date" name="i_date" id="date" value="<?php echo $i_date; ?>" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    </div>

                    <!-- time -->
                    <div class="mb-3">
                        <label>Time of Incident</label>
                        <input type="time" name="i_time" value="<?php echo $i_time; ?>" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    </div>

                    <!-- location -->
                    <div class="mb-3">
                        <label>Location of incident</label>
                        <input type="text" name="i_location" value="<?php echo $location; ?>" required class="block w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    </div>
                    <!-- Narrative -->
                    <div id="textNarrative">
                        <label for="0" class="block mb-2 text-m font-medium text-gray-900 dark:text-white">Narrative:</label>
                        <?php
                        $narr_index = 0;

                        if (!empty($narrs)) :
                            foreach ($narrs as $narr) :
                                switch ($narr_index) {
                                    case 1:
                                        $label =  "1st hearing";
                                        break;
                                    case 2:
                                        $label = "2nd hearing";
                                        break;
                                    case 3:
                                        $label = "3rd hearing";
                                        break;

                                    default:
                                        $label = $narr_index . "th hearing";
                                        break;
                                }

                        ?>
                                <?php


                                if ($narr_index !== 0) :
                                ?>
                                    <div class="split">
                                        <label for="<?php echo $narr_index ?>" style="" class="block mb-1 text-m font-medium text-gray-900 dark:text-white"><?php echo $label . ": " . $hearing_status[$narr_index - 1]; ?></label>
                                        <input name="dateHearing[]" value="<?php echo $hearing_date[$narr_index - 1]; ?>" style="display: block; margin-left: auto; outline:none; min-width: 220px;" readOnly />
                                        <input type="hidden" name="statusInput[]" value="<?php echo $hearing_status[$narr_index - 1]; ?>">
                                    </div>
                                <?php

                                endif; ?>
                                <div class="textN">
                                    <textarea name="narrative[]" id="<?php echo $narr_index ?>" required class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter Narrative..."><?php echo $narr; ?></textarea>
                                    <input type="hidden" name="hearing[]" id="num_hearing" value="<?php echo $narr_index; ?>" />

                                </div>
                                <script>
                                    // Initialize CKEditor for the textarea with the unique ID
                                    CKEDITOR.replace('<?php echo $narr_index; ?>');
                                </script>
                            <?php
                                $narr_index++;
                            endforeach;
                        else : ?> <!-- If no narrative in the database -->
                            <div class="textN">
                                <textarea name="narrative[]" required class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter Narrative..."></textarea>
                            </div>
                        <?php
                        endif;
                        // for delete button
                        if ($narr_index !== 1) :
                        ?>
                            <span><button class="delete-button2" onclick="return confirm('Are you sure you want to delete this narrative?')" name="delete_narr"><a href="../includes/delete_narr.php?delete_id=<?php echo $incident_id; ?>&narr_index=<?php echo $narr_index - 1 ?>">Delete</a></button></span>
                        <?php endif; ?>
                        <input type="hidden" id="num" value="<?php echo $narr_index - 1; ?>" />

                    </div>
                    <!-- Modal toggle -->
                    <button id="addNarrative" style="color: green;" type="button"><i class="fa-solid fa-plus"></i>Add</button>
                    <?php
                    date_default_timezone_set('Asia/Manila');
                    ?>
                    <input type="hidden" id="inputDate" value="<?php echo date("F d, Y")  . ' ' . date('H:i:s') ?>" />

                    <!-- <button style="color: green;" type="button" data-modal-target="small-modal" data-modal-toggle="small-modal"><i class="fa-solid fa-plus"></i>Add</button> -->


                    <div class="mt-2">
                        <button name="submit" type="submit" class="w-full mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Save Changes</button>
                    </div>
                </form>

            </div>
        </div>
    </main>


    <!-- <textarea name="editor1"></textarea> -->
    <!-- <script>
        CKEDITOR.replace('narrative[]');
    </script> -->
    <script src="../../../assets/js/sidebar.js"></script>
    <script src="./../assets/js/add-incident.js"></script>
    <script src="./../assets/js/remote_modals.js"></script>
    <!-- <script src="./assets/js/required.js"></script> -->
    <script src="./../assets/js/radioInput_more.js"></script>
    <!-- <script src="./../assets/js/select-resident.js"></script> -->
    <script src="./../assets/js/text-area.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        /* set max date to current date */
        document.getElementById("date").max = new Date().toISOString().split("T")[0];
        document.getElementById("inputDate").max = new Date().toISOString().split("T")[0];
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

        // label for px in CKEDITOR
        CKEDITOR.on("dialogDefinition", function(ev) {
            // Check if the dialog being defined is the "image" dialog
            if (ev.data.name === "image") {
                var dialogDefinition = ev.data.definition;

                // Find the width and height inputs in the dialog
                var widthInput = dialogDefinition.getContents("info").get("txtWidth");
                var heightInput = dialogDefinition.getContents("info").get("txtHeight");

                // Change the labels of the width and height inputs
                widthInput.label = "Width (px)";
                heightInput.label = "Height (px)";
            }
        });
        document.getElementById("dateButton").addEventListener("click", function() {
            var inputDate = document.getElementById("inputDate").value;
            var inputField = document.getElementById("inputDate");
            inputField.value = "Selected date: " + inputDate;
        });
    </script>

</body>

</html>