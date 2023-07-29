<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
// include 'assets/includes/medicine-distrib.php';

// select from current id 

$query = "SELECT resident_id, CONCAT(firstname, ' ', middlename, ' ', lastname) AS fullname FROM resident WHERE barangay_id = :barangay_id";
// Prepare and execute the SQL statement
$stmt = $pdo->prepare($query);
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
// Retrieve the results
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);
//record retrieving 
$record = $pdo->query("SELECT * FROM medicine_distribution")->fetchAll();
$medicine = $pdo->query("SELECT * FROM medicine_inventory")->fetchAll();

// query for joining three tables 'medicine_distribution','medicine_inventory', and 'resident'

$joint = $pdo->query("SELECT * FROM medicine_distribution md
                    JOIN medicine_inventory mi ON md.medicine_id = mi.ID
                    JOIN resident r ON md.resident_id = r.resident_id")->fetchAll();



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
    <!-- main css ref -->
    <link rel="stylesheet" href="assets/css/health.css" />

    <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Medicine Distribution</title>
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
                <p>Medicine Distribution</p>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <!-- insert record -->
                <div style="margin-bottom: 1.5rem;">
                    <button class="recordbtn" onclick="openPopup()">Insert Record</button>
                </div>
                <!-- table -->
                <div>
                    <table id="inventory" class="row-border hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Medicine Name</th>
                                <th>Quantity</th>
                                <th>Given to</th>
                                <th>Date Given</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- inserting values from database to table through foreach statement -->
                            <?php foreach ($joint as $row) { ?>
                                <tr>

                                    <td><?php echo $row['distrib_id'] ?></td>
                                    <td><?php echo $row['medicine_name'] ?></td>
                                    <td><?php echo $row['distrib_quantity'] ?></td>
                                    <td><?php echo $row['firstname'];
                                        echo ' ' . $row['middlename'];
                                        echo ' ' . $row['lastname'] ?></td>
                                    <td><?php echo date("F d, Y", strtotime($row['distrib_date'])) ?></td>
                                </tr>
                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end of wrapper -->
        </div>
        <!-- insert record modal -->
        <div class="modal" id="modal">
            <div class="header">
                <p class="header-text">Medicine Distribution</p>
                <button class="closebtn" onclick="closePopup()">X</button>
                <div class="content2">
                    <form action="assets/includes/medicine-distrib.php" method="POST" class="form-content">
                        <div class="field2">
                            <p>Medicine: </p>
                            <!-- Toggle for medicine modal -->
                            <input type="text" name="medicine_name" id="medicine_name" required readonly data-modal-target="medicineModal" data-modal-toggle="medicineModal">

                        </div>
                        <div class="field2">
                            <p>Quantity<span style="color: darkgray;">(pcs)</span>: </p>
                            <input type="number" name="medicine_quantity" value="" required>
                        </div>
                        <div class="field2">
                            <p>Recepient: </p>
                            <input type="text" name="resident_name" id="resident_name" required readonly data-modal-target="residentModal" data-modal-toggle="residentModal">
                        </div>
                        <div class="field2">
                            <p>Date Given: </p>
                            <input type="date" id="date-given" name="date" placeholder="mm/dd/yyyy" required>
                        </div>
                        <button type="submit" name="submitRecord" class="submitRecord" style="margin-top: 0.5rem;">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modals -->
        <!-- Modal for medicine -->
        <div id="medicineModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            List of Medicines
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="medicineModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <table id="medicine-table" class="row-border hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Medicine Name</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($medicine as $medicine) : ?>
                                    <tr id="<?php echo $medicine['ID'] ?>" data-modal-hide="medicineModal" class="medicine-row">
                                        <td><?php echo $medicine['ID'] ?></td>
                                        <td><?php echo $medicine['medicine_name'] ?></td>
                                        <td><?php echo $medicine['medicine_quantity'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for resident -->
        <div id="residentModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Select Resident
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="residentModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <table id="resident-table" class="row-border hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resident as $resident) : ?>
                                    <tr id="<?php echo $resident['resident_id'] ?>" data-modal-hide="residentModal" class="resident-row">
                                        <td><?php echo $resident['resident_id'] ?></td>
                                        <td><?php echo $resident['fullname'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="assets/js/select-medicine.js"></script>
    <script src="assets/js/select-resident.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <!-- script for table -->

    <script>
        /* set max date to current date */
        document.getElementById("date-given").max = new Date().toISOString().split("T")[0];

        $(document).ready(function() {
            $('#inventory').DataTable();
        });
        $(document).ready(function() {
            $('#medicine-table').DataTable();
        });
        $(document).ready(function() {
            $('#resident-table').DataTable();
        });
    </script>

    <!-- popup js -->

    <script>
        let modal = document.getElementById('modal');

        function openPopup() {
            modal.classList.add("modal-active");
        }

        function closePopup() {
            modal.classList.remove("modal-active");
        }
    </script>

    <!-- end of table script -->
</body>

</html>