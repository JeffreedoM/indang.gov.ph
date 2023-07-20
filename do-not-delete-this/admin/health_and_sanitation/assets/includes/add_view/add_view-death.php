<?php

include '../../../../../includes/dbh.inc.php';
include '../../../../../includes/session.inc.php';
include '../../../../../includes/deactivated.inc.php';

$id = $_GET['id'];
$action = $_GET['action'];
$death = $pdo->query("SELECT * FROM death d
JOIN resident r ON d.resident_id = r.resident_id
WHERE death_id='$id'")->fetch();
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

    <title>Admin Panel</title>
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
                                <a href="../../../death.php" class="inline-flex items-center text-base font-semibold text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                    Death List
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <?php
                                    if ($action == 'edit') {
                                        $action_label = 'Edit';
                                    } else {
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
                        <input type="hidden" name="death_id" value="<?php echo $death['death_id'] ?>" id="resident_id">
                    </div>

                    <!-- Vaccine Condition -->
                    <?php
                    if ($action == 'edit') {
                        $action_read = '';
                        $action_class = '';
                    } else {
                        $action_read = 'readonly';
                        $action_class = 'bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500';
                    }
                    ?>
                    <div class="container_vaccine">

                        <div class="image_vaccine">
                            <center>
                                <img src="../../../assets/image/health.png" alt="Your image">
                                <br>
                                <p><?php echo $death['firstname'] . ' ' . $death['middlename'] . ' ' . $death['lastname'] ?></p>
                                <label for="position" class="block font-medium text-gray-900 dark:text-white"><b>First Name</b> </label>
                            </center>
                        </div>

                        <div class="form_vaccine">
                            <h2>Resident Personal Information</h2>
                            <hr>
                            <br>
                            <label for="death_date" class="block font-medium text-gray-900 dark:text-white">Firstname</label>
                            <input type="text" name="death_fname" value="<?php echo $death['firstname'] ?>" id="resident_name" <?php echo $action_read; ?> class="<?php echo $action_class; ?>">
                            <input type="hidden" name="resident_id" value="<?php echo $death['resident_id'] ?>" id="resident_id" <?php echo $action_read; ?> class="<?php echo $action_class; ?>">

                            <label for="death_date" class="block font-medium text-gray-900 dark:text-white">Middlename</label>
                            <input type="text" name="death_mname" value="<?php echo $death['middlename'] ?>" id="resident_name" <?php echo $action_read; ?> class="<?php echo $action_class; ?>">

                            <label for="death_date" class="block font-medium text-gray-900 dark:text-white">Lastname</label>
                            <input type="text" name="death_lname" value="<?php echo $death['lastname'] ?>" id="resident_name" <?php echo $action_read; ?> class="<?php echo $action_class; ?>">

                            <div>
                                <label for="death_sex">Sex</label>
                                <div>
                                    <label><input type="radio" name="death_sex" value="Male" <?= ($death['sex'] == 'Male') ? 'checked' : '' ?> required <?php echo $action_read; ?> class="<?php echo $action_class; ?>">Male</label>
                                </div>
                                <div>
                                    <label><input type="radio" name="death_sex" value="Female" <?= ($death['sex'] == 'Female') ? 'checked' : '' ?> required <?php echo $action_read; ?> class="<?php echo $action_class; ?>">Female</label>
                                </div>
                            </div>

                            <label for="death_date" class="block font-medium text-gray-900 dark:text-white">Address</label>
                            <input type="text" name="death_address" value="<?php echo $death['address'] ?>" id="resident_name" <?php echo $action_read; ?> class="<?php echo $action_class; ?>">


                            <br><br>
                            <h2><span class="vaccine_header">Death Information</span></h2>
                            <hr>
                            <br>
                            <label for="death_date" class="block font-medium text-gray-900 dark:text-white">Date of Death</label>
                            <input type="date" name="death_date" value="<?php echo $death['death_date'] ?>" <?php echo $action_read; ?> class="<?php echo $action_class; ?>">

                            <label for="death_cause" class="block font-medium text-gray-900 dark:text-white">Cause of Death</label>
                            <textarea name="death_cause" id="" cols="53" rows="5" <?php echo $action_read; ?> class="<?php echo $action_class; ?>"><?php echo $death['death_cause'] ?></textarea>


                            <!-- Vaccine Button -->
                            <?php
                            if ($action == 'edit') {
                            ?>
                                <button onclick="return  confirm('Do you want to edit this record?')" type="submit" name="submit_edit_death" id="submitButton" class="block mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update Record</button>
                            <?php
                            } else {
                            ?>
                                <button onclick="return  confirm('Do you want to delete this record?')" type="submit" name="submit_delete_death" id="submitButton" class="block mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Delete Record</button>
                            <?php
                            }
                            ?>
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