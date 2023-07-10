<?php

include '../../../../includes/dbh.inc.php';
include '../../../../includes/deactivated.inc.php';
include '../../../../includes/session.inc.php';

$finance_id = $_GET['finance_id'];
$action = $_GET['action'];
$finance = $pdo->query("SELECT * FROM new_finance WHERE financeID = '$finance_id'")->fetch();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../../assets/css/main.css" />
    <link rel="stylesheet" href="../../assets/css/popup2.css" type="text/css" />
   
    <title>Admin Panel</title>
</head>

<body>
    <?php
    include '../../../../partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include '../../../../partials/nav_header.php';
        ?>

        <!-- Container -->
        <div class="wrapper">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title">

                    <div class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="../../index.php" class="inline-flex items-center text-base font-semibold text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                    <?= $finance['financeProject']; ?>
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <?php
                                        if ($action == 'edit'){
                                            $action_label = 'Edit';
                                        } else{
                                            $action_label = 'View';
                                        }
                                    ?>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"><?php echo $action_label; ?> Budget Detail</span>
                                </div>
                            </li>
                        </ol>
                    </div>

                </h3>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <form action="../query.php" method="POST" enctype="multipart/form-data" class="add-resident__form">
                    <div>
                        <input type="hidden" name="id_resident" value="<?php echo $finance['financeID']; ?>" id="resident_id">
                    </div>
                    
                    <div class="container_vaccine">
                        

                        <?php
                            if($action == 'view'){
                                ?>
                                    <style>
                                        #edit-view{
                                            display: none;
                                        }
                                    </style>
                                <?php
                            } else{
                               ?>
                                 <style>
                                        #view-view{
                                            display: none;
                                        }
                                    </style>
                               <?php
                            }
                        ?>
                        <div class="wrap-position2">
                            <div class="wrap-position-sub2">
                                <label for="financeProject"><b>Project Name</b></label>
                                <input type="text" name="financeProject" id="edit-view" value="<?php echo $finance['financeProject'] ?>">
                                <p id="view-view"><?php echo $finance['financeProject']; ?></p>
                            </div>
                            <div class="wrap-position-sub2">
                                <label for="financeTreasurer"><b>Treasurer Name</b></label>
                                <input type="text" name="financeTreasurer" id="edit-view" value="<?php echo $finance['financeTreasurer'] ?>">
                                <p id="view-view"><?php echo $finance['financeTreasurer']; ?></p>
                            </div>
                            <div class="wrap-position-sub2">
                                <label for="financeRCD"><b>RCD No.</b></label>
                                <input type="text" name="financeRCD" id="edit-view" value="<?php echo $finance['financeRCD'] ?>">
                                <p id="view-view"><?php echo $finance['financeRCD']; ?></p>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="wrap-position2">
                            <div class="wrap-position-sub2">
                                <label for="financeAmount"><b>Amount Allocated</b></label>
                                <input type="text" name="financeAmount" id="edit-view" value="<?php echo $finance['financeAmount'] ?>">
                                <p id="view-view"><?php echo $finance['financeAmount']; ?></p>
                            </div>
                            <div class="wrap-position-sub2">
                                <label for="financeDate"><b>Date Given</b></label>
                                <input type="date" name="financeDate" id="edit-view" value="<?php echo $finance['financeDate'] ?>">
                                <p id="view-view"><?php echo $finance['financeDate']; ?></p>
                            </div>
                            <div class="wrap-position-sub2">
                                
                            </div>
                        </div>
                            
                        <div class="form_vaccine">
                        <hr>
                        <br>

                        <label for="financeDescription" class="block font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea name="financeDescription" id="edit-view" cols="110" rows="5"><?php echo $finance['financeDescription'] ?></textarea>
                        <textarea id="view-view" cols="110" rows="5" readonly><?php echo $finance['financeDescription'] ?></textarea>

                        
                        <!-- Vaccine Button -->
                        <center>
                            <br><br><br>
                        <?php
                            if($action == 'edit'){
                                ?>
                                    <button onclick="return  confirm('Do you want to edit this record?')" type="submit" name="edit_finance" id="submitButton" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update Record</button>
                                <?php
                            } else{
                                ?>
                                    <button onclick="return  confirm('Do you want to delete this record?')" type="submit" name="submit_delete_finance" id="submitButton" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Delete Record</button>
                                <?php
                            }
                        ?>
                        </center>
                       
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="./assets/js/resident-profiling.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>