<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
// include 'assets/includes/medicine-distrib.php';

// select from current id 

$query = "SELECT resident_id, CONCAT(firstname, ' ', middlename, ' ', lastname) AS fullname FROM resident WHERE is_alive = 1 AND barangay_id = :barangay_id";
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
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-6" data-modal-target="medicineDistribModal" data-modal-toggle="medicineDistribModal">Insert Record</button>
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


        <!-- Modal for medicine distribution -->
        <div id="medicineDistribModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Medicine Distribution
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="medicineDistribModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <form action="assets/includes/medicine-distrib.php" method="POST" class="form-content">
                            <div class="mb-4">
                                <p>Medicine: </p>

                                <input type="hidden" name="medicine_id" id="medicine_id">
                                <!-- Toggle for list of medicine modal -->
                                <input type="text" name="medicine_name" id="medicine_name" required readonly data-modal-target="medicineModal" data-modal-toggle="medicineModal" class="w-full rounded-md border border-gray-300 bg-gray-50 text-sm">
                            </div>
                            <div class="mb-4">
                                <p>Quantity<span style="color: darkgray;">(pcs)</span>: </p>
                                <input type="number" name="medicine_quantity" id="medicine_quantity" min="0" disabled placeholder="Select Medicine First" required class="w-full rounded-md border border-gray-300 bg-gray-50 text-sm">
                            </div>
                            <div class="mb-4">
                                <p>Recipient: </p>
                                <input type="hidden" name="resident_id" id="resident_id">
                                <!-- Toggle for lsit of resident modal -->
                                <input type="text" name="resident_name" id="resident_name" required readonly data-modal-target="residentModal" data-modal-toggle="residentModal" class="w-full rounded-md border border-gray-300 bg-gray-50 text-sm">
                            </div>
                            <div class="mb-4">
                                <p>Date Given: </p>
                                <input type="date" id="date-given" name="date" placeholder="mm/dd/yyyy" required class="w-full rounded-md border border-gray-300 bg-gray-50 text-sm">
                            </div>
                            <button type="submit" name="submitRecord" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Submit</button>
                        </form>
                    </div>
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
                                    <th>Availability</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($medicine as $medicine) : ?>
                                    <tr id="<?php echo $medicine['ID'] ?>" <?php echo $medicine['medicine_quantity'] == 0 || $medicine['medicine_description'] == 'Expired' ? "style='pointer-events:none;'" : "style='cursor: pointer;'" ?> data-modal-hide="medicineModal" class="medicine-row">
                                        <td><?php echo $medicine['ID'] ?></td>
                                        <td><?php echo $medicine['medicine_name'] ?></td>
                                        <td><?php echo $medicine['medicine_quantity'] == 0 ? $medicine['medicine_quantity'] . ' <span class="text-red-500">(Out of Stock)</span>' : $medicine['medicine_quantity'] ?></td>
                                        <td><?php echo $medicine['medicine_description'] == 'Expired' ? '<span class="text-red-500">' . $medicine['medicine_description'] . '</span>' : $medicine['medicine_quantity'] ?></td>
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