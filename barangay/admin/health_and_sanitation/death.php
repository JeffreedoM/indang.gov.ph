<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';

//Getting residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE is_alive = 1 AND barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);

/** Getting death records date_death and death_cause
 *  Other data will be fetched from resident table
 */
$stmt = $pdo->prepare("SELECT * FROM death d 
JOIN resident r ON d.resident_id = r.resident_id
WHERE r.barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$record = $stmt->fetchAll();
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

    <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Death</title>
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
            <div class="page-header">
                <h3 class="page-title">Health and Sanitation</h3>
                <p>Death</p>
            </div>

            <!-- Page body -->
            <!-- <div class="page-body body">
                <div class="tab-header">
                    <a href="index.php">
                        <div class="tabs">Medicine Inventory</div>
                    </a>
                    <a href="medicine-distribution.php">
                        <div class="tabs">Medicine Distribution</div>
                    </a>
                    <a href="vaccination.php">
                        <div class="tabs">Vaccination</div>
                    </a>
                    <a href="newborn.php">
                        <div class="tabs">Newborn</div>
                    </a>
                    <a href="pregnant.php">
                        <div class="tabs">Pregnant</div>
                    </a>
                    <div class="tabs" style="border-right: none; background-color: #ccc">Death</div>
                </div>
                
            </div> -->

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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Cause of Death</th>
                                <th>Date of Death</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- inserting values from database to table through foreach statement -->
                            <?php foreach ($record as $row) { ?>
                                <tr>

                                    <td><?php echo $row['resident_id'] ?></td>
                                    <td><?php
                                        $resident_fullname = "$row[firstname] $row[middlename] $row[lastname]";
                                        echo $resident_fullname ?>
                                    </td>
                                    <td><?php echo $row['death_cause'] ?></td>
                                    <td><?php echo date("F d, Y", strtotime($row['death_date'])) ?></td>

                                    <!-- action button row -->
                                    <td>
                                        <button><a href="./assets/includes/add_view/add_view-death.php?id=<?php echo $row['death_id'] ?>&action=view">View</a></button>
                                        <button><a href="./assets/includes/add_view/add_view-death.php?id=<?php echo $row['death_id'] ?>&action=edit">Edit</a></button>
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
                    <h1>List of Residents</h1>

                    <table id="residents" class="row-border hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resident as $resident) { ?>
                                <tr id="<?php echo $resident['resident_id'] ?>" style="cursor:pointer">
                                    <td><?php echo $resident['resident_id'] ?></td>
                                    <td><?php
                                        $resident_fullname = "$resident[firstname] $resident[middlename] $resident[lastname]";
                                        echo $resident_fullname ?>
                                    </td>
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
                    <p class="header-text-vacc"><b>Insert Death Record</b></p>
                    <button class="closebtn" onclick="closeInsertPopup()">X</button>

                    <button class="add-resident__button" onclick="openPopup()">
                        <label for="position" class="block font-medium text-red-500 dark:text-white">Select resident <i class="fa-solid fa-caret-down ml-1"></i></label>
                    </button>

                    <form action="./assets/includes/query.php" method="POST" class="add-officials-form" onsubmit="return validateForm()">
                        <!-- resident name -->
                        <div>
                            <input type="text" name="death_fname" id="resident_name" placeholder="Select resident above" readonly aria-label="disabled input 2" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <input type="hidden" name="resident_id" id="resident_id">
                        </div>
                        <div>
                            <label for="death_date" class="block font-medium text-gray-900 dark:text-white">Date of Death</label>
                            <input type="date" name="death_date" id="date" placeholder="Date of Death">
                        </div>
                        <div>
                            <label for="death_cause" class="block font-medium text-gray-900 dark:text-white">Cause of Death</label>
                            <textarea name="death_cause" id="" cols="53" rows="5" placeholder="Cause of Death"></textarea>
                        </div>
                        <input type="hidden" name="position_officials" value="">
                        <button onclick="return  confirm('Do you want to add this record?')" type="submit" name="submit_add_death" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
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
        /* set max date to current date */
        document.getElementById("date").max = new Date().toISOString().split("T")[0];

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