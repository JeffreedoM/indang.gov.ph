<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
include 'assets/includes/add-medicine.php';

$stmt = $pdo->prepare("SELECT * FROM medicine_inventory WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$record = $stmt->fetchAll(PDO::FETCH_ASSOC);

$isAvailable = "Available";
$notAvailable = "Out of Stock";

// $expiryTimestamp = strtotime($medDate);
$currentTimestamp = time();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <!-- table css and js-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- main css ref -->
    <!-- <link rel="stylesheet" href="assets/css/health.css" /> -->

    <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Medicine Inventory</title>


    <style>
        .button {
            cursor: pointer;
            border: 1px solid #8E94A9;
            background: none;
            color: #8E94A9;
            border-radius: 3px;
            padding: 0.3rem 0.5rem;
            font-weight: var(--fw-m);
        }

        .button:hover {
            background-color: #8E94A9;
            color: white;
        }
    </style>

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
                <p>Medicine Inventory</p>
            </div>

            <!-- Page body -->

            <div class="page-body">
                <!-- insert record -->
                <!-- <div style="margin-bottom: 1.5rem;">
                    <button class="recordbtn" onclick="openPopup()">Insert Record</button>
                </div> -->
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-6" data-modal-target="medicineModal" data-modal-toggle="medicineModal">Insert Record</button>

                <!-- Medicine Inventory Table -->
                <div>
                    <table id="vaccine" class="row-border hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Availability</th>
                                <th>Stock</th>
                                <th>Expiration Date</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- inserting values from database to table through foreach statement -->
                            <?php foreach ($record as $row) { ?>
                                <tr>
                                    <?php
                                    $expiredColor = "gray"; // Change this to whatever color you want for expired items
                                    $availableColor = "green"; // Change this to whatever color you want for available items

                                    $isAvailable = ($row['medicine_availability'] === $notAvailable) ? false : true;
                                    $isExpired = strtotime($row['medicine_expiration']) < time();

                                    $color = $isExpired ? $expiredColor : ($isAvailable ? $availableColor : "gray");
                                    ?>

                                    <td style="color: <?php echo $color; ?>"><?php echo $row['ID'] ?></td>
                                    <td style="color: <?php echo $color; ?>"><?php echo $row['medicine_name'] ?></td>
                                    <td style="color: <?php echo $color; ?>">
                                        <?php
                                        if (!$isAvailable) {
                                            echo "Not Available";
                                        } elseif ($isExpired) {
                                            echo "<span style='color: red;'>Expired</span>";
                                        } else {
                                            echo $row['medicine_availability'];
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    // Format the date to "Month day, Year" (e.g., January 29, 2000)
                                    $expirationDate = date("F d, Y", strtotime($row['medicine_expiration']));
                                    ?>
                                    <td style="color: <?php echo $color; ?>"><?php echo $row['medicine_quantity'] ?></td>
                                    <td style="color: <?php echo $color; ?>"><?php echo $expirationDate ?></td>
                                    <td style="color: <?php echo $color; ?>"><?php echo $row['medicine_description'] ?></td>



                                    <!-- action button row -->
                                    <td>
                                        <div>
                                            <a href="edit-inventory.php?id=<?php echo $row['ID'] ?>">
                                                <button class="button">Edit</button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal for medicine adding -->
        <div id="medicineModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Insert Medicine
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
                        <form action="" method="POST">
                            <div class="mb-5">
                                <p>Name of Medicine: </p>
                                <input type="text" name="medicine_name" value="" required class="w-full rounded-md border border-gray-300 bg-gray-50 text-sm">
                            </div>
                            <div class="mb-5">
                                <p>Quantity<span style="color: darkgray;">(pcs)</span>: </p>
                                <input type="number" name="medicine_quantity" value="" required class="w-full rounded-md border border-gray-300 bg-gray-50 text-sm">
                            </div>
                            <div class="mb-5">
                                <p>Expiration Date: </p>
                                <input type="date" id="exp_date" name="expiration_date" placeholder="mm/dd/yyyy" required class="w-full rounded-md border border-gray-300 bg-gray-50 text-sm">
                            </div>
                            <div class="mb-5">
                                <p>Description: </p>
                                <textarea name="medicine_description" rows="5" maxlength="500" class="w-full rounded-md border border-gray-300 bg-gray-50 text-sm"></textarea>
                            </div>
                            <button type="submit" name="submitRecord" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <!-- script for table -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#vaccine').DataTable();
        });
    </script>
    <!-- script for calendar -->
    <script>
        $(function() {
            $("#expiration_date").datepicker();
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