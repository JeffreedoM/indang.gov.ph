<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
include 'assets/includes/medicine-record.php';

$record = $pdo->query("SELECT * FROM medicine_management")->fetchAll();

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
    <link rel="stylesheet" href="assets/css/medicine-management.css"/>
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
                <h3 class="page-title">Medicine Management</h3>
            </div>

            <!-- Page body -->
            <div class="page-body body">
            <!-- header -->
                
            </div>

            <div class="page-body">
            <!-- insert record -->
                <div style="margin-bottom: 1.5rem;">
                    <button class="recordbtn" onclick="openPopup()">View Records</button>

                </div>

            <!-- form -->
            <div style="width: 300px;">
                <form method="POST">
                <div class="mb-6">
                    <label for="manage_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Medicine Name</label>
                    <input type="text" id="manage_name" name="manage_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter Medicine Name" required>
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
                      
            <div class="content" id="popup">
            <p class="header-text">Medicine records</p> 
            <button class="closebtn" onclick="closePopup()">X</button>
                <!-- table -->
                <div>
                    <table id="vaccine" class="row-border hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- inserting values from database to table through foreach statement -->
                            <?php foreach($record as $row) { ?>
                                <tr>
                                    <td><?php echo $row['manage_id']?></td>                                   
                                    <td><?php echo $row['manage_name']?></td>
                                    <td><?php echo $row['manage_desc']?></td>                                                                    
                                   
                                    <!-- action button row -->
                                    <td>
                                        <div>
                                            <button>Edit</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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