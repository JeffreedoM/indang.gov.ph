<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';

//Getting residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);

$record = $pdo->query("SELECT * FROM newborn WHERE newborn_brgyID='$barangayId'")->fetchAll();
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

    <title>Admin Panel | Newborn</title>
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
        <div class="wrapper">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title">Health and Sanitation</h3>
                <p>Newborn</p>
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
                        <div class="tabs" style="background-color: #ccc;">Newborn</div>
                    <a href="pregnant.php">
                        <div class="tabs">Pregnant</div>
                    </a>
                    <a href="death.php">
                    <div class="tabs" style="border-right: none;">Death</div>
                    </a>
                </div>
                
            </div> -->
            <!-- Page body -->
            <div class="page-body">
                <!-- insert record -->
                <div style="margin-bottom: 1.5rem;">
                    <button class="recordbtn" onclick="openNewBornInsertPopup()">Insert Record</button>
                </div>

                <!-- table -->
                <div>
                    <table id="newborn" class="row-border hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Birth Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- inserting values from database to table through foreach statement -->
                            <?php foreach ($record as $row) { ?>
                                <tr>

                                    <td><?php echo $row['newborn_id'] ?></td>
                                    <td><?php echo $row['newborn_fname'] . ' ' . $row['newborn_mname'] . ' ' . $row['newborn_lname'] ?></td>
                                    <td><?php echo $row['newborn_gender'] ?></td>
                                    <td><?php echo $row['newborn_date_birth'] ?></td>


                                    <!-- action button row -->
                                    <td>
                                        <button><a href="./assets/includes/add_view/add_view-newborn.php?id=<?php echo $row['newborn_id'] ?>&action=view">View</a></button>
                                        <button><a href="./assets/includes/add_view/add_view-newborn.php?id=<?php echo $row['newborn_id'] ?>&action=edit">Edit</a></button>
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
                    <span class="close-popup" onclick="closeNewBornPopup()">
                        <i class="fa-solid fa-x"></i>
                    </span>
                </div>
            </div>

            <!-- insert record modal -->
            <div class="modal" id="modal_vaccine">
                <div class="header_new">
                    <p class="header-text-vacc"><b>Insert Newborn Record</b></p>
                    <button class="closebtn" onclick="closeNewBornInsertPopup()">X</button>

                    <!-- Form for adding officials -->
                    <form action="./assets/includes/query.php" method="POST" class="add-officials-form" onsubmit="return validateForm()">
                        <!-- resident name -->
                        <input type="hidden" name="barangayID" value="<?php echo $barangayId ?>">
                        <div>
                            <div>
                                <label for="newborn_fname">First Name</label>
                                <input type="text" name="newborn_fname" placeholder="First Name" required>
                            </div>
                            <div>
                                <label for="newborn_mname">Middle Name</label>
                                <input type="text" name="newborn_mname" placeholder="Middle Name">
                            </div>
                            <div>
                                <label for="newborn_lname">Last Name</label>
                                <input type="text" name="newborn_lname" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div>
                            <label for="position" class="block font-medium text-gray-900 dark:text-white">Date of Birth</label>
                            <input type="date" name="newborn_date_birth" id="date" placeholder="Input Date of Birth" required>
                        </div>
                        <div>
                            <label for="newborn_gender">Sex</label>
                            <div>
                                <label><input type="radio" name="newborn_gender" value="Male" required>Male</label>
                            </div>
                            <div>
                                <label><input type="radio" name="newborn_gender" value="Female" required>Female</label>
                            </div>
                        </div>



                        <button onclick="return  confirm('Do you want to add this record?')" type="submit" name="submit_add_newborn" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
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

        let modal = document.getElementById('modal_vaccine');

        function openNewBornInsertPopup() {
            modal.classList.add("modal-active");
        }

        function closeNewBornInsertPopup() {
            modal.classList.remove("modal-active");
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#newborn').DataTable();
        });
    </script>
</body>

</html>