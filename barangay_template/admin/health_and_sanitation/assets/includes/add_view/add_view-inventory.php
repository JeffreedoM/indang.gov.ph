<?php

include '../../../../../includes/dbh.inc.php';
include '../../../../../includes/session.inc.php';
include '../../../../../includes/deactivated.inc.php';

$id = $_GET['id'];
$action = $_GET['action'];

$vaccine_inventory = $pdo->query("SELECT * FROM vaccine_inventory WHERE vaccineInventoryID ='$id'")->fetch();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../../../../assets/css/main.css" />
    <link rel="stylesheet" href="../../../assets/css/health_vaccine.css" />
   
    <link rel="icon" type="image/x-icon" href="../../../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Medicin Inventory</title>
</head>

<body>
    <?php
    include '../../../../../partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include '../../../../../partials/nav_header.php';
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
                                <a href="../../../vaccination-inventory.php" class="inline-flex items-center text-base font-semibold text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                    Batch Inventory List
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
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"><?php echo $action_label; ?></span>
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
                        <input type="hidden" name="vaccineInventoryID" value="<?php echo $vaccine_inventory['vaccineInventoryID'] ?>">
                    </div>
                    
                    <div class="batch_main">
                        <h2><span class="vaccine_header"><b> Record <?php echo $vaccine_inventory['vaccineName']; ?></b></span></h2>
                        <hr>
                        <br>
                        
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

                        <div class="batch_sub_container">
                            <div class="batch_sub">
                                <label for="position" class="block font-medium text-gray-900 dark:text-white"><b>Vaccine Name</b></label>
                                <input type="text" id="edit-view" name="vaccineName" value="<?php echo $vaccine_inventory['vaccineName'] ?>">
                                <p id="view-view"><?php echo $vaccine_inventory['vaccineName'] ?></p>
                                <br>
                            </div>                          
                            <div class="batch_sub">
                                <label for="position" class="block font-medium text-gray-900 dark:text-white"><b>Vaccine Quantity</b></label>
                                <input type="number" id="edit-view" name="vaccineQuantity" value="<?php echo $vaccine_inventory['vaccineQuantity'] ?>">
                                <p id="view-view"><?php echo $vaccine_inventory['vaccineQuantity'] ?></p>
                            </div>                          
                        </div>               
                        <div class="batch_sub_container">
                            <div class="batch_sub">
                                <label for="position" class="block font-medium text-gray-900 dark:text-white"><b>Vaccine Expiration Date</b></label>
                                <input type="date" id="edit-view" name="vaccineExpDate" value="<?php echo $vaccine_inventory['vaccineExpDate'] ?>">
                                <p id="view-view"><?php echo $vaccine_inventory['vaccineExpDate'] ?></p>
                                <br>
                            </div>                          
                            <div class="batch_sub">
                                <label for="position" class="block font-medium text-gray-900 dark:text-white"><b>Vaccine Status</b></label>
                                <select name="vaccineStatus" id="edit-view">
                                    <option value="Available" <?= ($vaccine_inventory['vaccineStatus'] == 'Available') ? 'selected' : '' ?>>Available</option>
                                    <option value="Out of Stock" <?= ($vaccine_inventory['vaccineStatus'] == 'Out of Stock') ? 'selected' : '' ?>> Out of Stock</option>
                                </select>
                                <p id="view-view"><?php echo $vaccine_inventory['vaccineStatus'] ?></p>
                                <br>
                            </div>                          
                        </div>
                        <br>
                        <label for=""><b>Vaccine Description</b></label>
                        <textarea name="vaccineDescrip" id="edit-view" cols="113" rows="10"><?php echo $vaccine_inventory['vaccineDescrip']; ?></textarea>               
                        <textarea id="view-view" cols="113" rows="10" readonly><?php echo $vaccine_inventory['vaccineDescrip']; ?></textarea>               
                        <br>
                    </div>

                    <!-- Vaccine Button -->
                    <?php
                            if($action == 'edit'){
                                ?>
                                    <button onclick="return  confirm('Do you want to edit this record?')" type="submit" name="submit_edit-inventory" id="submitButton" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update Record</button>
                                <?php
                            } else{
                                ?>
                                    <button onclick="return  confirm('Do you want to delete this record?')" type="submit" name="submit_delete-inventory" id="submitButton" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Delete Record</button>
                                <?php
                            }
                        ?>
                </form>
            </div>
        </div>
    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="./assets/js/resident-profiling.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script>
        /* Uploading Profile Image */
        //declearing html elements

        const imgDiv = document.querySelector('.profile-pic-div');
        const img = document.querySelector('#photo');
        const file = document.querySelector('#file');
        const uploadBtn = document.querySelector('#uploadBtn');

        //if user hover on img div 

        imgDiv.addEventListener('mouseenter', function() {
            uploadBtn.style.display = "block";
        });

        //if we hover out from img div

        imgDiv.addEventListener('mouseleave', function() {
            uploadBtn.style.display = "none";
        });

        //lets work for image showing functionality when we choose an image to upload

        //when we choose a foto to upload

        file.addEventListener('change', function() {
            // this refers to file
            const choosedFile = this.files[0];

            if (choosedFile) {
                if (choosedFile.type.startsWith('image/')) {
                    const reader = new FileReader(); // FileReader is a predefined function of JS

                    reader.addEventListener('load', function() {
                        img.setAttribute('src', reader.result);
                    });

                    reader.readAsDataURL(choosedFile);
                } else {
                    alert('Please choose a valid image file!');
                    file.value = ''; // Reset the input file element to allow re-selection of file
                }
            }
        });

        const fileInput = document.getElementById('file');
        const submitButton = document.getElementById('submitButton');
        const message = document.getElementById('message');

        fileInput.addEventListener('onchange', () => {
            submitButton.addEventListener('click', function(event) {
                if (!fileInput.value) {
                    event.preventDefault(); //prevent form submission
                    alert("Please choose a Profile Image.");
                    alert(fileInput.value);
                }
            });
        })
    </script>
</body>

</html>