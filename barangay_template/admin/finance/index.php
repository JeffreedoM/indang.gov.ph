<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
include './includes/connect.php';
// $_SESSION['barangay_id'] = $loggedInBarangayID;

//Getting residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE is_alive = 1 AND barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);

$clearance = $pdo->query("SELECT * FROM new_finance WHERE financeBrgyID = '$barangayId' AND financeLabel='collection'")->fetchAll();
// $project = $pdo->query("SELECT * FROM special_project WHERE barangay_id = '$barangayId'")->fetchAll();

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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="./assets/css/buttons.css" type="text/css" />
    <link rel="stylesheet" href="./assets/css/add_finance.css" type="text/css" />
    <link rel="stylesheet" href="./assets/css/popup2.css" type="text/css" />
    <link rel="stylesheet" href="./assets/css/popup.css" type="text/css" /> <!--for resident-->
    <link rel="stylesheet" href="./assets/css/styles2.css" type="text/css" />
    <link rel="stylesheet" href="./assets/css/styles.css" type="text/css" />

    <title>Admin Panel | Finance</title>
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
                <h3 class="page-title">Finance</h3>
                <div class="border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center dark:text-gray-400">
                        <li class="mr-2">
                            <a href="#" class="inline-flex p-4 bg-white rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group">
                                Collections
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="deposits.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Deposits
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="expenses.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Expenses
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Page body -->
            <div class="page-body" style="overflow-x:auto; min-height: 60vh;">


                <div class="add_clearance">
                    <button onclick="openInsertPopup()" class="add_transaction"><span>Add Collections</span></button>
                    <a id="dynamic-link" href="">
                        <button class="add_transaction"> Budgetary Report</button>
                    </a>
                </div>

                <!-- List of clearances -->
                <div>
                    <table id="clearance-list" class="row-border hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Payor</th>
                                <th>Nature of Collection</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Code to change color based on status -->
                            <?php foreach ($clearance as $row) {
                                $formattedDate = date("F j, Y", strtotime($row['collectionDate']));
                            ?>
                                <tr>

                                    <td><?php echo $formattedDate ?></td>
                                    <td><?php echo $row['collectionPayor'] ?></td>
                                    <td><?php echo $row['collectionNature']; ?></td>
                                    <td style="text-align: right;"><?php echo "₱ " . number_format($row['collectionAmount'], 2, '.', ','); ?></td>
                                    <td>
                                        <button><a href="includes/add_view/add_view-collection.php?finance_id=<?php echo $row['financeID'] ?>&action=view&title=Collection">View</a></button>
                                        <button><a href="includes/add_view/add_view-collection.php?finance_id=<?php echo $row['financeID'] ?>&action=edit&title=Collection">Edit</a></button>
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
            <div class="modal2" id="modal_vaccine">
                <div class="header">
                    <p class="header-text-vacc"><b>Insert Collection Record</b></p>
                    <button class="closebtn2" onclick="closeInsertPopup()">X</button>

                    <!-- resident -->
                    <!-- <button class="add-resident__button" onclick="openPopup()">
                        <label for="position" class="block font-medium text-red-500 dark:text-white">Select payor <i class="fa-solid fa-caret-down ml-1"></i></label>
                    </button> -->

                    <!-- Form for adding officials -->
                    <form action="./includes/query.php" method="POST" class="add-officials-form" onsubmit="return validateForm()">
                        <!-- resident name -->
                        <input type="hidden" name="brgyID" value="<?php echo $barangayId ?>">
                        <div class="wrap-position">
                            <div class="wrap-position-sub">
                                <button class="add-resident__button" onclick="openPopup()" style="display: flex; justify-content:flex-start;">
                                    <label for="position" class="block font-medium text-red-500 dark:text-white">Select payor <i class="fa-solid fa-caret-down ml-1"></i></label>
                                </button>
                                <input type="text" name="collectionPayor" id="resident_name" placeholder="Select payor above" readonly aria-label="disabled input 2" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <input type="hidden" name="id_resident" id="resident_id">

                            </div>
                            <div class="wrap-position-sub">
                                <label for="date" class="block font-medium text-gray-900 dark:text-white">Date</label>
                                <input type="date" name="collectionDate">
                                <!-- <label for="position" class="block font-medium text-gray-900 dark:text-white">Payor</label>
                                <input type="text" name="collectionPayor" placeholder="Payor"> -->
                            </div>
                        </div>

                        <div class="wrap-position">
                            <div class="wrap-position-sub">
                                <label for="position" class="block font-medium text-gray-900 dark:text-white">Others</label>
                                <input type="text" name="collectionOther" placeholder="Payor">
                            </div>
                            <div class="wrap-position-sub">
                                <label for="death_cause" class="block font-medium text-gray-900 dark:text-white">Amount</label>
                                <input type="number" name="collectionAmount" placeholder="PHP" step="0.01">
                            </div>
                        </div>
                        <div>
                            <label for="position" class="block font-medium text-gray-900 dark:text-white">Nature of Collection</label>
                            <textarea name="collectionNature" id="" rows="5" placeholder="Type here" style="width: 100%; box-sizing: border-box;"></textarea>
                        </div>

                        <input type="hidden" name="position_officials" value="">
                        <button onclick="return  confirm('Do you want to add this record?')" type="submit" name="add_collection" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
                    </form>

                </div>
            </div>

    </main>


    <script src="./assets/js/select-resident.js"></script>
    <script src="./assets/js/popup.js"></script>
    <script src="./assets/js/popup2.js"></script>
    <script src="./assets/js/dynamic-link.js"></script>
    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- popup js -->
    <!-- <script>
        let popup = document.getElementById("popup")
        let modal = document.getElementById("modal")


        function openPopup() {
            modal.classList.add("modal-active");
            popup.classList.add("open-popup");
        }

        function closePopup() {
            popup.classList.remove("open-popup");
            modal.classList.remove("modal-active");
        }
    </script> -->

    <!-- Add Collection Record -->
    <script>
        let modal2 = document.getElementById('modal_vaccine');

        function openInsertPopup() {
            modal2.classList.add("modal-active2");
        }

        function closeInsertPopup() {
            modal2.classList.remove("modal-active2");
        }
    </script>

    <!-- Data table format for residents -->
    <script>
        /* set max date to current date */
        document.getElementById("date-given").max = new Date().toISOString().split("T")[0];

        function validateForm() {
            const input = document.getElementById("resident_name").value;
            // if (input == "") {
            //     alert("Select resident");
            //     return false;
            // }
        }
    </script>

    <!-- Data table format for clearance collection list -->
    <script>
        $(document).ready(function() {
            $('#clearance-list').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#residents').DataTable();
        });
    </script>

</body>

</html>