<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
// include '../../includes/dbh.inc.php';

//Getting residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
    <link rel="stylesheet" href="./assets/css/main.css">


    <title>Officials | Admin Panel</title>
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


            <!-- Alert if adding of officials is successful -->
            <?php if (isset($_GET['message']) and $_GET['message'] == 'success') : ?>
                <div id="alert-3" class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">Official Successfully Added!</span>
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>


            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">

                <h3 class="page-title">Add Barangay Officials</h3>

                <!-- page tabs -->
                <div class="border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center dark:text-gray-400">
                        <li class="mr-2">
                            <a href="officials.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Organizational Chart
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="officials-table.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Officials
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="#" class="inline-flex p-4 bg-white rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group">
                                Add Official
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <?php if ($logged_resident['position'] == 'Barangay Secretary') : ?>
                <!-- Page body -->
                <div class="page-body">
                    <button class="add-resident__button " onclick="openPopup()">
                        <label class="block font-medium text-red-500 dark:text-white cursor-pointer">Select resident <i class="fa-solid fa-caret-down ml-1"></i></label>
                        <!-- <span class="text-red-600">Select Resident <i class="fa-solid fa-caret-down ml-1"></i></span> -->
                    </button>

                    <!-- Form for adding officials -->
                    <form action="includes/add-officials.inc.php" method="POST" id="myForm" class="add-officials-form" onsubmit="return validateForm()">
                        <!-- resident name -->
                        <div>
                            <input type="text" id="resident_name" placeholder="Select resident above" readonly aria-label="disabled input 2" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <input type="hidden" name="resident_id" id="resident_id">
                        </div>
                        <!-- position -->
                        <div class="mt-3">
                            <label for="position" class="block font-medium text-gray-900 dark:text-white">Position</label>
                            <select id="position" name="position" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled selected>Select position</option>
                                <option value="Barangay Captain">Barangay Captain</option>
                                <option value="Barangay Secretary">Barangay Secretary</option>
                                <option value="Barangay Treasurer">Barangay Treasurer</option>
                                <option value="Barangay Leaders">Barangay Leaders</option>
                                <option value="Barangay Tanod">Barangay Tanod</option>
                                <option value="Barangay Health Worker">Barangay Health Worker</option>
                                <option value="Committee on Peace and Order">Committee on Peace and Order</option>
                                <option value="Committee on Public Information/Environment">Committee on Public Information/Environment</option>
                                <option value="Committee on Agricultural">Committee on Agricultural</option>
                                <option value="Committee on Health and Sports">Committee on Health and Sports</option>
                                <option value="Committee on Education">Committee on Education</option>
                                <option value="Committee on Budget and Appropriation">Committee on Budget and Appropriation</option>
                                <option value="Committee on Infrastructure">Committee on Infrastructure</option>
                                <option value="Sangguniang Kabataan">Sangguniang Kabataan</option>
                                <option value="Home Owner Association">Home Owner Association</option>
                                <option value="Lupon Tagapamayapa">Lupon Tagapamayapa</option>
                                <option value="Barangay Nutrition Scholars">Barangay Nutrition Scholars</option>
                                <option value="Utility Officers">Utility Officers</option>
                                <option value="Technical Vocational Instructors">Technical Vocational Instructors</option>
                                <option value="Barangay AIDE">Barangay AIDE</option>
                                <option value="Outsider">Outsider</option>
                                <option value="Barangay Chief Tanod">Barangay Chief Tanod</option>
                                <option value="Barangay Deputy Tanod">Barangay Deputy Tanod</option>
                                <option value="BHRAO">BHRAO</option>
                            </select>
                            <span id="positionError" class="text-red-500"></span>
                        </div>
                        <!-- year start and end -->
                        <div class="mt-3">
                            <div date-rangepicker class="flex items-center">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="date-start" type="text" autocomplete="off" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
                                </div>
                                <span class="mx-4 text-gray-500">to</span>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input name="date-end" type="text" autocomplete="off" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
                    </form>

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
            <?php else : ?>
                <div class="page-body" style="display:flex; align-items:center; justify-content:center;">
                    <h1>You do not have sufficient privileges to access this page.</h1>
                </div>

            <?php endif ?>
        </div>

    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="./assets/js/popup.js"></script>
    <script src="./assets//js/select-resident.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./assets/js/check-position.js"></script>
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


</body>

</html>