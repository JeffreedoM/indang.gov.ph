<?php

include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

$id = $_GET['id'];
$project = $pdo->query("SELECT * FROM special_project WHERE project_id='$id'")->fetch();
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
    <link rel="stylesheet" href="./assets/css/main-project.css">
    <title>Special Projects | Admin Panel</title>
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
                <h3 class="page-title">

                    <div class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="index.php" class="inline-flex items-center text-base font-semibold text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                    Project List
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <a href="project-view.php?id=<?php echo $id ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white"><?php echo $project['project_name'] ?></a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Edit</span>
                                </div>
                            </li>
                        </ol>
                    </div>

                </h3>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <form action="./query.php" method="POST" enctype="multipart/form-data" class="add-resident__form">
                    <!-- Personal Information Title -->
                    <h2 class="form-title" style="margin-top: 0">Project Information</h2>
                    <p class="add-resident__desc">Fill up all the required fields with asterisk**.</p>

                    <!-- Resident Id -->
                    <input type="hidden" name="project_id" value="<?php echo $id ?>">
                    <!-- Personal Information Form -->
                    <div class="personal-info form-group">
                        <!-- Project Title -->
                        <div class="project-name">
                            <label for="">Project Title <span class="required-input">*</span></label>
                            <input type="text" name="project_name" placeholder="Firstname" value="<?php echo $project['project_name'] ?>" required>
                        </div>
                        <!-- Date of Activity -->
                        <div class="project-date">
                            <label for="">Date of Activity <span class="required-input">*</span></label>
                            <input type="date" name="project_date" id="res_bdate" value="<?php echo $project['project_date'] ?>" onblur="getAge()" required>
                        </div>
                    </div>
                    <div class="personal-info form-group">
                        <div class="project-host">
                            <label for="">Event Host <span class="required-input">*</span></label>
                            <select name="project_host" id="">
                                <option value="" selected disabled>Choose Event Host</option>
                                <option value="Barangay Officials" <?= ($project['project_host'] == 'Barangay Officials') ? 'selected' : '' ?>>Barangay Officials</option>
                                <option value="SK" <?= ($project['project_host'] == 'SK') ? 'selected' : '' ?>>SK</option>
                                <option value="Others" <?= ($project['project_host'] == 'Others') ? 'selected' : '' ?>>Others</option>
                            </select>
                        </div>
                        <!-- Project Title -->
                        <div class="project-name">
                            <label for="">Other Host Name [if option others is selected]</label>
                            <input type="text" name="project_other_host" placeholder="Other Host Name" value="<?php echo $project['project_other_host'] ?>">
                        </div>
                    </div>
                    <!-- Resident Address Title-->
                    <h2 class="form-title">Project Details</h2>
                    <p class="add-resident__desc"></p>

                    <!-- Project Detail Form -->
                    <div class="resident-address form-group">
                        <!-- Project Description -->
                        <div>
                            <label for="">Description<span class="required-input">*</span></label>
                            <textarea style="white-space: pre-wrap;" name="project_description" cols="30" rows="10"><?php echo $project['project_description'] ?></textarea>
                        </div>
                    </div>

                    <div class="resident-address form-group">
                        <!-- Project Description -->
                        <div>
                            <label for="">Requirements</label>
                            <textarea name="project_requirements" id="" cols="30" rows="10"><?php echo $project['project_requirements'] ?></textarea>
                        </div>
                    </div>

                    <button type="submit" name="submit_edit" id="submitButton">Update Project</button>
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