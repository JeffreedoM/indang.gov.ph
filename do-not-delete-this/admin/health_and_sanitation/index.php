<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
include 'assets/includes/add-medicine2.php';




$joint = $pdo->query("SELECT * FROM medicine_inventory mi
                    JOIN medicine_management mm ON mi.manage_id = mm.manage_id")->fetchAll();

$record = $pdo->query("SELECT * FROM medicine_management")->fetchAll();

 $isAvailable = "Available";
 $notAvailable = "Out of Stock";

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
    <link rel="stylesheet" href="assets/css/health.css"/>
    <!-- jquery for calendar --> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <title>Admin Panel</title>
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
            </div>

            <!-- Page body -->
            <div class="page-body body">
            <!-- header -->
                <div class="tab-header">
                    <div class="tabs" style="background-color: #ccc;">Medicine Inventory</div>
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
                    <a href="death.php">
                    <div class="tabs" style="border-right: none;">Death</div>
                    </a>
                </div>             
            </div>

            <div class="page-body">
            <!-- insert record -->
                <div style="margin-bottom: 1.5rem;">
                    <button class="recordbtn" onclick="openPopup()">View Inventory</button>
                </div>
                

                <div style="width: 300px;">
                    <form method="POST">
                    <div class="mb-6">
                        <label for="manage_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Medicine Name</label>
                        <input type="text" id="manage_name" name="manage_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter Medicine Name" required>
                    </div>
                    <div class="mb-6">
                    <label for="medicine_quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                    <input type="number" id="medicine_quantity" name="medicine_quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter Medicine Quantity" required>
                    </div>
                    <div class="mb-6">
                    <label for="medicine_quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expiry Date</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input datepicker type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="manage_desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea id="manage_desc" name="manage_desc" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write Description..."></textarea>
                    </div>               
                    <button type="submit" name="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </form>
                </div>

            </div>
    <!-- end of wrapper -->                            
        </div>
        <!-- insert record modal -->
        <div class="modal" id="modal">
        <div class="header">
            <p class="header-text">Insert record</p>
            <button class="closebtn" onclick="closePopup()">X</button>
            <div class="content" id="popup">        
                <form action="" method="POST" class="form-content">
                    <div class="field">
                            <select name="manage_name" required>
                                <option style="color: gray;">Medicine</option>
                                <?php foreach ($record as $item) { ?>
                                    <option value=<?php echo $item['manage_id'] ?>>
                                        <?php echo $item['manage_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                    </div>
                    <div class="field">
                        <p style="margin-bottom: 0.5rem;">Quantity<span style="color: darkgray;">(pcs)</span>: </p>
                        <input type="number" name="medicine_quantity" value="" required>
                    </div>
                    <div class="field">
                        <p style="margin-bottom: 0.5rem;">Expiration Date: </p>
                        <input type="date" id="exp_date" name="expiration_date" placeholder="mm/dd/yyyy" required>
                    </div>
                    <div class="field">
                        <p style="margin-bottom: 0.5rem;">Description: </p>
                        <textarea name="medicine_description" rows="2" cols="18" maxlength="500" style="width: 100%;"></textarea>
                    </div>
                    <button type="submit" class="submitRecord" name="submitRecord">Submit</button>
                </form>
            </div>
        </div>
        </div>
    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <!-- script for table -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <!--script for calendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/datepicker.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#vaccine').DataTable();
    });
    </script>
    <!-- script for calendar -->
        <script>
            $(function(){
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