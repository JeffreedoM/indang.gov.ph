<?php

include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

$id = $_GET['id'];
$resident = $pdo->query("SELECT * FROM resident WHERE resident_id='$id'")->fetch();
$fullname = "$resident[firstname] $resident[middlename] $resident[lastname] $resident[suffix]";
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
    <link rel="stylesheet" href="./assets/css/main-resident.css">
    <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Resident Profiling</title>
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
                                <a href="resident-profiling.php" class="inline-flex items-center text-base font-semibold text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                    List of Residents
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <a href="resident-view.php?id=<?php echo $id ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white"><?php echo $fullname ?></a>
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
                <form action="./includes/resident-edit.inc.php" method="POST" enctype="multipart/form-data" class="add-resident__form">
                    <!-- Personal Information Title -->
                    <h2 class="form-title" style="margin-top: 0">Resident Information</h2>
                    <p class="add-resident__desc">Fill up all the required fields with asterisk**.</p>

                    <!-- Resident Id -->
                    <input type="hidden" name="resident_id" value="<?php echo $id ?>">
                    <!-- Profile Image -->
                    <div class="profile-pic-div">
                        <?php if (!empty($resident['image'])) { ?>
                            <img src="./assets/images/uploads/<?php echo $resident['image'] ?>" id="photo">
                        <?php } else { ?>
                            <img src="./assets/images/uploads/noprofile.jpg" id="photo">
                        <?php } ?>
                        <input type="file" name="image" id="file" novalidate>
                        <label for="file" id="uploadBtn">Change Photo</label>
                    </div>

                    <!-- Personal Information Form -->
                    <div class="personal-info form-group">
                        <!-- First Name -->
                        <div>
                            <label for="">First name <span class="required-input">*</span></label>
                            <input type="text" name="firstname" placeholder="Firstname" value="<?php echo $resident['firstname'] ?>" required>
                        </div>
                        <!-- Middle Name -->
                        <div>
                            <label for="">Middle name</label>
                            <input type="text" name="middlename" placeholder="Middle name" value="<?php echo $resident['middlename'] ?>">
                        </div>
                        <!-- Last Name -->
                        <div>
                            <label for="">Last name <span class="required-input">*</span></label>
                            <input type="text" name="lastname" placeholder="Last name" value="<?php echo $resident['lastname'] ?>" required>
                        </div>
                        <!-- Suffix -->
                        <div>
                            <label for="">Suffix</label>
                            <input type="text" name="suffix" placeholder="Suffix" readonly>
                        </div>
                        <!-- Sex -->
                        <div>
                            <label for="">Sex <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="sex" id="" required>
                                    <option value="" disabled selected>Sex</option>
                                    <option value="Male" <?php if ($resident['sex'] == "Male") echo "selected"; ?>>Male</option>
                                    <option value="Female" <?php if ($resident['sex'] == "Female") echo "selected"; ?>>Female</option>
                                </select>
                            </div>
                        </div>
                        <!-- Birthdate -->
                        <div>
                            <label for="">Birthdate <span class="required-input">*</span></label>
                            <input type="date" name="birthdate" id="res_bdate" placeholder="Birthdate" value="<?php echo $resident['birthdate'] ?>" onblur="getAge()" required>
                        </div>
                        <!-- Age -->
                        <div>
                            <label for="">Age <span class="required-input">*</span></label>
                            <input type="number" name="age" id="res_age" readonly maxlength="3" placeholder="Age" value="<?php echo $resident['age'] ?>" required>
                        </div>
                        <!-- Civil Status -->
                        <div>
                            <label for="">Civil Status <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="civil_status" id="" required>
                                    <option value="" disabled selected>Civil Status</option>
                                    <option value="Single" <?php if ($resident['civil_status'] == "Single") echo "selected"; ?>>Single</option>
                                    <option value="Married" <?php if ($resident['civil_status'] == "Married") echo "selected"; ?>>Married</option>
                                    <option value="Widow" <?php if ($resident['civil_status'] == "Widow") echo "selected"; ?>>Widow/er</option>
                                    <option value="Legally Separated" <?php if ($resident['civil_status'] == "Legally Separated") echo "selected"; ?>>Legally Separated</option>
                                    <option value="Annulled" <?php if ($resident['civil_status'] == "Annulled") echo "selected"; ?>>Annulled</option>
                                </select>
                            </div>
                        </div>
                        <!-- Contact Type -->
                        <div>
                            <label for="">Contact Type</label>
                            <div class="select-wrapper">
                                <select name="contact_type" id="res_contacttype" onchange="maxLengthFunction(); ">
                                    <option value="" disabled selected>Contact Type</option>
                                    <option value="no_contact" <?php if ($resident['contact_type'] == "no_contact") echo "selected"; ?>>N/A</option>
                                    <option value="mobile" <?php if ($resident['contact_type'] == "mobile") echo "selected"; ?>>Mobile</option>
                                    <option value="tel" <?php if ($resident['contact_type'] == "tel") echo "selected"; ?>>Tel.</option>
                                </select>
                            </div>
                        </div>
                        <!-- Contact Number -->
                        <div>
                            <label for="">Contact</label>
                            <input type="text" name="contact" id="res_contactnum" placeholder="Contact No." readonly onkeyup="numbersOnly(this)" value="<?php echo $resident['contact'] ?>">
                        </div>
                        <!-- Height -->
                        <div>
                            <label for="">Height (optional)</label>
                            <input type="number" name="height" id="" placeholder="Height (cm)" value="<?php echo $resident['height'] ?>">
                        </div>
                        <!-- Weight -->
                        <div>
                            <label for="">Weight (optional)</label>
                            <input type="number" name="weight" id="" placeholder="Weight (kg)" value="<?php echo $resident['weight'] ?>">
                        </div>
                        <!-- Religion -->
                        <div>
                            <label for="">Religion <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="religion" id="" required>
                                    <option value="" disabled selected>Religion</option>
                                    <option value="Ang Dating Daan" <?php if ($resident['religion'] == "Ang Dating Daan") echo "selected"; ?>>Ang Dating Daan</option>
                                    <option value="Baptist" <?php if ($resident['religion'] == "Baptist") echo "selected"; ?>>Baptist</option>
                                    <option value="Born Again" <?php if ($resident['religion'] == "Born Again") echo "selected"; ?>>Born Again</option>
                                    <option value="Buddhism" <?php if ($resident['religion'] == "Buddhism") echo "selected"; ?>>Buddhism</option>
                                    <option value="Christian Catholic" <?php if ($resident['religion'] == "Christian Catholic") echo "selected"; ?>>Christian Catholic</option>
                                    <option value="Christian Protestant" <?php if ($resident['religion'] == "Christian Protestant") echo "selected"; ?>>Christian Protestant</option>
                                    <option value="Iglesia Ni Kristo" <?php if ($resident['religion'] == "Iglesia Ni Kristo") echo "selected"; ?>>Iglesia Ni Kristo</option>
                                    <option value="Islam" <?php if ($resident['religion'] == "Islam") echo "selected"; ?>>Islam</option>
                                    <option value="Jehovah's Witness" <?php if ($resident['religion'] == "Jehovah's Witness") echo "selected"; ?>>Jehovah's Witness</option>
                                    <option value="Seventh Day Adventist" <?php if ($resident['religion'] == "Seventh Day Adventist") echo "selected"; ?>>Seventh Day Adventist</option>
                                </select>
                            </div>
                        </div>
                        <!-- Occupation Status -->
                        <div>
                            <label for="">Occupation Status <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="res_occupation-status" id="res_occupation-status" onchange="occupationFunction()" required>
                                    <option value="" disabled selected>Occupation Status</option>
                                    <option value="Employed" <?php if ($resident['occupation_status'] == "Employed") echo "selected"; ?>>Employed</option>
                                    <option value="Employed Government" <?php if ($resident['occupation_status'] == "Employed Government") echo "selected"; ?>>Employed Government</option>
                                    <option value="Employed Private" <?php if ($resident['occupation_status'] == "Employed Private") echo "selected"; ?>>Employed Private</option>
                                    <option value="Overseas Filipino Worker (OFW)" <?php if ($resident['occupation_status'] == "Overseas Filipino Worker (OFW)") echo "selected"; ?>>Overseas Filipino Worker (OFW)</option>
                                    <option value="Self-Employed (SE)" <?php if ($resident['occupation_status'] == "Self-Employed (SE)") echo "selected"; ?>>Self-Employed (SE)</option>
                                    <option value="Unemployed" <?php if ($resident['occupation_status'] == "Unemployed") echo "selected"; ?>>Unemployed</option>
                                </select>
                            </div>
                        </div>
                        <!-- Occupation -->
                        <div>
                            <label for="">Occupation</label>
                            <input type="text" name="occupation" id="res_occupation" placeholder="Occupation" readonly value="<?php echo $resident['occupation'] ?>">
                        </div>
                    </div>

                    <!-- Resident Address Title-->
                    <h2 class="form-title">Resident Address</h2>
                    <p class="add-resident__desc"></p>

                    <!-- Resident Address Form -->
                    <div class="resident-address form-group">

                        <!-- House no. -->
                        <div>
                            <label for="">Complete Address (House, Street, Barangay)<span class="required-input">*</span></label>
                            <input type="text" name="address" placeholder="Address" required value="<?php echo $resident['address'] ?>">
                        </div>
                    </div>

                    <button type="submit" name="submit" id="submitButton">Update resident</button>
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