<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';

//Getting residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE is_alive = 1 AND sex = 'Female' AND barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$femaleResidents = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pregnant = $pdo->query("SELECT *
                      FROM resident
                      JOIN pregnant ON resident.resident_id = pregnant.id_resident
                      WHERE resident.barangay_id = '$barangayId' AND resident.sex = 'Female'")->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <!-- Specific spage styling -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Popup -->
    <link rel="stylesheet" href="./assets/css/popup.css">
    <!-- table css and js-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- main css ref -->
    <link rel="stylesheet" href="assets/css/health_vaccine.css" />
    <!-- jquery for calendar -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Pregnant</title>
</head>

<body>
    <?php
    include '../../partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include '../../partials/nav_header.php';
        ?>

        <!-- Container -->
        <div class="wrapper officials">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header" style="margin: 0 !important;">
                <h3 class="page-title ml-3 mb-1">Health and Sanitation</h3>
                <p class="mb-4 ml-3">Pregnant</p>

                <!-- page tabs -->
                <div class="border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center dark:text-gray-400">
                        <li class="mr-2">
                            <a href="#" class="cursor-pointer inline-flex p-4 bg-white rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group">
                                Pregnant
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="pregnancy-history.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Pregnancy History
                            </a>
                        </li>
                    </ul>
                </div>
            </div>



            <!-- Page body -->
            <div class="page-body" style="overflow-x: scroll;">
                <!-- insert record -->
                <div style="margin-bottom: 1.5rem;">
                    <button class="recordbtn" onclick="openInsertPopup()">Insert Record</button>
                </div>

                <!-- table -->
                <div>
                    <table id="vaccine" class="row-border hover">
                        <thead>
                            <tr>
                                <th>Resident ID</th>
                                <th>Name</th>
                                <th>Marital Status</th>
                                <th>No. of Pregnancy</th>
                                <th>Due Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- inserting values from database to table through foreach statement -->
                            <?php foreach ($pregnant as $pregnant) { ?>
                                <?php
                                $dueDate = new DateTime($pregnant['pregnant_due']);
                                $currentDate = new DateTime();

                                // The due date has already passed
                                if ($dueDate < $currentDate) {
                                    // Move the due pregnant to pregnant_history

                                    // Insert record in pregnant_history
                                    $sql = "INSERT INTO pregnant_history (pregnant_id, id_resident, pregnant_num, pregnant_due)
                                    VALUES (:pregnant_id, :id_resident, :pregnant_num, :pregnant_due)";
                                    $stmt = $pdo->prepare($sql);
                                    $data = array(
                                        'pregnant_id' => $pregnant['pregnant_id'],
                                        'id_resident' => $pregnant['id_resident'],
                                        'pregnant_num' => $pregnant['pregnant_num'],
                                        'pregnant_due' => $pregnant['pregnant_due']
                                    );
                                    $stmt->execute($data);

                                    // Delete the due pregnant in the pregnant records
                                    $sql = "DELETE FROM pregnant WHERE pregnant_id = :pregnant_id";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->bindParam(':pregnant_id', $pregnant['pregnant_id'], PDO::PARAM_INT);
                                    $stmt->execute();

                                    continue;
                                }

                                ?>
                                <tr>
                                    <td><?php echo $pregnant['id_resident'] ?></td>
                                    <td><?php echo $pregnant['firstname'] . ' ' . $pregnant['middlename'] . ' ' . $pregnant['lastname'] ?></td>
                                    <td><?php echo $pregnant['civil_status'] ?></td>
                                    <td><?php echo $pregnant['pregnant_num'] ?></td>
                                    <td><?php echo date("F d, Y", strtotime($pregnant['pregnant_due'])) ?></td>


                                    <!-- action button row -->
                                    <td>
                                        <button><a href="./assets/includes/add_view/add_view-pregnant.php?id=<?php echo $pregnant['pregnant_id'] ?>&action=view">View</a></button>
                                        <button><a href="./assets/includes/add_view/add_view-pregnant.php?id=<?php echo $pregnant['pregnant_id'] ?>&action=edit">Edit</a></button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Add Officials -->
                <div class="modal-bg" onclick="closePopup()" id="modal-background">
                </div>

                <div class="popup" id="modal-container">
                    <h1>List of Female Residents</h1>

                    <table id="residents" class="row-border hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Occupation</th>
                                <th>Marital Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($femaleResidents as $resident) { ?>
                                <tr id="<?php echo $resident['resident_id'] ?>" style="cursor:pointer">
                                    <td><?php echo $resident['resident_id'] ?></td>
                                    <td><?php
                                        $resident_fullname = "$resident[firstname] $resident[middlename] $resident[lastname]";
                                        echo $resident_fullname ?>
                                    </td>
                                    <td><?php echo $resident['occupation'] ?></td>
                                    <td><?php echo $resident['civil_status'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>


                    <!-- close popup button -->
                    <span class="close-popup" onclick="closePopup()">
                        <i class="fa-solid fa-x"></i>
                    </span>
                </div>
            </div>

            <!-- insert record modal -->
            <div class="modal" id="modal_vaccine">
                <div class="header">
                    <p class="header-text-vacc"><b>Insert Pregnancy Record</b></p>
                    <button class="closebtn" onclick="closeInsertPopup()">X</button>

                    <button class="add-resident__button" onclick="openPopup()">
                        <label for="position" class="block font-medium text-red-500 dark:text-white">Select resident <i class="fa-solid fa-caret-down ml-1"></i></label>
                    </button>

                    <!-- Form for adding officials -->
                    <form action="./assets/includes/query.php" method="POST" class="add-officials-form" onsubmit="return validateForm()">
                        <!-- resident name -->
                        <div class="mb-3">
                            <input type="text" name="pregnant_fname" id="resident_name" placeholder="Select resident above" readonly aria-label="disabled input 2" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <input type="hidden" name="id_resident" id="resident_id">
                        </div>
                        <div class="mb-3">
                            <label for="pregnant_num" class="block font-medium text-gray-900 dark:text-white">No. of Pregnancy</label>
                            <input type="number" name="pregnant_num" min="0" placeholder="Input No. of Pregnancy" class="text-sm rounded-lg border-gray-300">
                        </div>
                        <div class="mb-3">
                            <label for="pregnant_due" class="block font-medium text-gray-900 dark:text-white">Expected Date of Conception</label>
                            <input type="date" name="pregnant_due" min="<?php echo date('Y-m-d'); ?>" max="9999-12-31" required class="text-sm rounded-lg border-gray-300">
                        </div>

                        <button onclick="return  confirm('Do you want to add this record?')" type="submit" name="submit_add_pregnant" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
                    </form>

                </div>
            </div>

    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="./assets/js/popup.js"></script>
    <script src="./assets//js/select-resident.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#residents').DataTable();
        });

        function validateForm() {
            const input = document.getElementById("resident_name").value;
            if (input == "") {
                alert("Select resident");
                return false;
            }
        }
    </script>

    <script>
        let modal = document.getElementById('modal_vaccine');

        function openInsertPopup() {
            modal.classList.add("modal-active");
        }

        function closeInsertPopup() {
            modal.classList.remove("modal-active");
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#vaccine').DataTable();
        });
    </script>
</body>

</html>