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
    <script src="https://cdn.tailwindcss.com"></script>
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
                            <label>First name <span class="required-input">*</span></label>
                            <input type="text" name="firstname" placeholder="Firstname" value="<?php echo $resident['firstname'] ?>" required>
                        </div>
                        <!-- Middle Name -->
                        <div>
                            <label>Middle name</label>
                            <input type="text" name="middlename" placeholder="Middle name" value="<?php echo $resident['middlename'] ?>">
                        </div>
                        <!-- Last Name -->
                        <div>
                            <label>Last name <span class="required-input">*</span></label>
                            <input type="text" name="lastname" placeholder="Last name" value="<?php echo $resident['lastname'] ?>" required>
                        </div>
                        <!-- Suffix -->
                        <?php
                        $resident_suffix = $resident['suffix'];
                        $suffix_options = array(
                            "CFRE",
                            "CLU",
                            "CPA",
                            "C.S.J",
                            "D.C.",
                            "D.D.",
                            "D.D.S.",
                            "D.M.D.",
                            "D.O.",
                            "D.V.M.",
                            "Ed.D.",
                            "Esq.",
                            "II",
                            "III",
                            "IV",
                            "Inc.",
                            "J.D.",
                            "Jr.",
                            "LL.D.",
                            "Ltd.",
                            "M.D.",
                            "O.D.",
                            "O.S.B.",
                            "P.C.",
                            "P.E.",
                            "Ph.D.",
                            "Ret.",
                            "R.G.S",
                            "R.N.",
                            "R.N.C.",
                            "S.H.C.J.",
                            "S.J.",
                            "S.N.J.M.",
                            "Sr.",
                            "S.S.M.O.",
                            "USA",
                            "USAF",
                            "USAFR",
                            "USAR",
                            "USCG",
                            "USMCR",
                            "USN",
                            "USNR"
                        ); ?>
                        <div>
                            <label>Suffix</label>
                            <div class="select-wrapper">
                                <select name="suffix" id="suffix">
                                    <?php if ($resident_suffix === '') : ?>
                                        <option value="" disabled selected>Select a suffix</option>
                                    <?php endif ?>

                                    <?php
                                    foreach ($suffix_options as $suffix) {
                                        $selected = ($resident_suffix === $suffix) ? "selected" : "";
                                        echo '<option value="' . $suffix . '" ' . $selected . '>' . $suffix . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <p class="m-0 ml-auto mt-1 underline underline-offset-4 cursor-pointer" onclick="document.getElementById('suffix').value = ''">Clear Selection</p>
                        </div>
                        <!-- Sex -->
                        <div>
                            <label>Sex <span class="required-input">*</span></label>
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
                            <label>Birthdate <span class="required-input">*</span></label>
                            <input type="date" name="birthdate" id="res_bdate" placeholder="Birthdate" value="<?php echo $resident['birthdate'] ?>" onblur="getAge()" required>
                        </div>
                        <!-- Age -->
                        <div>
                            <label>Age</label>
                            <input type="number" name="age" id="res_age" readonly maxlength="3" placeholder="Age" required>
                        </div>
                        <!-- Civil Status -->
                        <div>
                            <label>Civil Status <span class="required-input">*</span></label>
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
                            <label>Contact Type</label>
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
                            <label>Contact</label>
                            <input type="text" name="contact" id="res_contactnum" placeholder="Contact No." onkeyup="formatContactNumber()" value="<?php echo $resident['contact'] ?>" <?php echo $resident['contact'] ? '' : 'readonly' ?>>
                        </div>
                        <!-- Height -->
                        <div>
                            <label>Height (cm)</label>
                            <input type="number" name="height" id="" placeholder="Height (cm)" value="<?php echo $resident['height'] ?>">
                        </div>
                        <!-- Weight -->
                        <div>
                            <label>Weight (kg)</label>
                            <input type="number" name="weight" id="" placeholder="Weight (kg)" value="<?php echo $resident['weight'] ?>">
                        </div>
                        <!-- Citizenship -->
                        <div>
                            <label>Citizenship <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="citizenship" id="res_citizenship" required>
                                    <option value="" disabled>Citizenship</option>
                                    <?php
                                    $predefinedCitizenships = array(
                                        "Filipino",
                                        "Afghan",
                                        "Albanian",
                                        "Algerian",
                                        "American",
                                        "Andorran",
                                        "Angolan",
                                        "Antiguans",
                                        "Argentinean",
                                        "Armenian",
                                        "Australian",
                                        "Austrian",
                                        "Azerbaijani",
                                        "Bahamian",
                                        "Bahraini",
                                        "Bangladeshi",
                                        "Barbadian",
                                        "Barbudans",
                                        "Batswana",
                                        "Belarusian",
                                        "Belgian",
                                        "Belizean",
                                        "Beninese",
                                        "Bhutanese",
                                        "Bolivian",
                                        "Bosnian",
                                        "Brazilian",
                                        "British",
                                        "Bruneian",
                                        "Bulgarian",
                                        "Burkinabe",
                                        "Burmese",
                                        "Burundian",
                                        "Cambodian",
                                        "Cameroonian",
                                        "Canadian",
                                        "Cape Verdean",
                                        "Central African",
                                        "Chadian",
                                        "Chilean",
                                        "Chinese",
                                        "Colombian",
                                        "Comoran",
                                        "Congolese",
                                        "Costa Rican",
                                        "Croatian",
                                        "Cuban",
                                        "Cypriot",
                                        "Czech",
                                        "Danish",
                                        "Djibouti",
                                        "Dominican",
                                        "Dutch",
                                        "East Timorese",
                                        "Ecuadorean",
                                        "Egyptian",
                                        "Emirian",
                                        "Equatorial Guinean",
                                        "Eritrean",
                                        "Estonian",
                                        "Ethiopian",
                                        "Fijian",
                                        "Finnish",
                                        "French",
                                        "Gabonese",
                                        "Gambian",
                                        "Georgian",
                                        "German",
                                        "Ghanaian",
                                        "Greek",
                                        "Grenadian",
                                        "Guatemalan",
                                        "Guinea-Bissauan",
                                        "Guinean",
                                        "Guyanese",
                                        "Haitian",
                                        "Herzegovinian",
                                        "Honduran",
                                        "Hungarian",
                                        "Icelander",
                                        "Indian",
                                        "Indonesian",
                                        "Iranian",
                                        "Iraqi",
                                        "Irish",
                                        "Israeli",
                                        "Italian",
                                        "Ivorian",
                                        "Jamaican",
                                        "Japanese",
                                        "Jordanian",
                                        "Kazakhstani",
                                        "Kenyan",
                                        "Kittian and Nevisian",
                                        "Kuwaiti",
                                        "Kyrgyz",
                                        "Laotian",
                                        "Latvian",
                                        "Lebanese",
                                        "Liberian",
                                        "Libyan",
                                        "Liechtensteiner",
                                        "Lithuanian",
                                        "Luxembourger",
                                        "Macedonian",
                                        "Malagasy",
                                        "Malawian",
                                        "Malaysian",
                                        "Maldivan",
                                        "Malian",
                                        "Maltese",
                                        "Marshallese",
                                        "Mauritanian",
                                        "Mauritian",
                                        "Mexican",
                                        "Micronesian",
                                        "Moldovan",
                                        "Monacan",
                                        "Mongolian",
                                        "Moroccan",
                                        "Mosotho",
                                        "Motswana",
                                        "Mozambican",
                                        "Namibian",
                                        "Nauruan",
                                        "Nepalese",
                                        "New Zealander",
                                        "Ni-Vanuatu",
                                        "Nicaraguan",
                                        "Nigerien",
                                        "North Korean",
                                        "Northern Irish",
                                        "Norwegian",
                                        "Omani",
                                        "Pakistani",
                                        "Palauan",
                                        "Panamanian",
                                        "Papua New Guinean",
                                        "Paraguayan",
                                        "Peruvian",
                                        "Polish",
                                        "Portuguese",
                                        "Qatari",
                                        "Romanian",
                                        "Russian",
                                        "Rwandan",
                                        "Saint Lucian",
                                        "Salvadoran",
                                        "Samoan",
                                        "San Marinese",
                                        "Sao Tomean",
                                        "Saudi",
                                        "Scottish",
                                        "Senegalese",
                                        "Serbian",
                                        "Seychellois",
                                        "Sierra Leonean",
                                        "Singaporean",
                                        "Slovakian",
                                        "Slovenian",
                                        "Solomon Islander",
                                        "Somali",
                                        "South African",
                                        "South Korean",
                                        "Spanish",
                                        "Sri Lankan",
                                        "Sudanese",
                                        "Surinamer",
                                        "Swazi",
                                        "Swedish",
                                        "Swiss",
                                        "Syrian",
                                        "Taiwanese",
                                        "Tajik",
                                        "Tanzanian",
                                        "Thai",
                                        "Togolese",
                                        "Tongan",
                                        "Trinidadian or Tobagonian",
                                        "Tunisian",
                                        "Turkish",
                                        "Tuvaluan",
                                        "Ugandan",
                                        "Ukrainian",
                                        "Uruguayan",
                                        "Uzbekistani",
                                        "Venezuelan",
                                        "Vietnamese",
                                        "Welsh",
                                        "Yemenite",
                                        "Zambian",
                                        "Zimbabwean",
                                        "Others"
                                    );

                                    // Check if $resident['citizenship'] is in the predefined options
                                    $residentCitizenship = $resident['citizenship'];
                                    if (!in_array($residentCitizenship, $predefinedCitizenships)) {
                                        echo '<option value="' . $residentCitizenship . '" selected>' . $residentCitizenship . '</option>';
                                    }

                                    foreach ($predefinedCitizenships as $citizenship) {
                                        $selected = ($residentCitizenship == $citizenship) ? 'selected' : '';
                                        echo '<option value="' . $citizenship . '" ' . $selected . '>' . $citizenship . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div id="otherCitizenshipInput" style="width: 100%; display: none; margin-top: 1rem;">
                                <label for="otherCitizenship">Input Citizenship</label>
                                <input type="text" name="citizenship" id="otherCitizenship" required style="width: 100%;">
                            </div>
                        </div>
                        <!-- Religion -->
                        <div>
                            <label>Religion <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="religion" id="religionSelect" required>
                                    <option value="" disabled>Religion</option>
                                    <?php
                                    $predefinedReligions = array(
                                        "Ang Dating Daan",
                                        "Baptist",
                                        "Born Again",
                                        "Buddhism",
                                        "Christian Catholic",
                                        "Christian Protestant",
                                        "Iglesia Ni Kristo",
                                        "Islam",
                                        "Jehovah's Witness",
                                        "Seventh Day Adventist",
                                        "Others"
                                    );

                                    // Check if $resident['religion'] is in the predefined options
                                    $residentReligion = $resident['religion'];
                                    if (!in_array($residentReligion, $predefinedReligions)) {
                                        echo '<option value="' . $residentReligion . '" selected>' . $residentReligion . '</option>';
                                    }

                                    foreach ($predefinedReligions as $religion) {
                                        $selected = ($residentReligion == $religion) ? 'selected' : '';
                                        echo '<option value="' . $religion . '" ' . $selected . '>' . $religion . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                            <div id="otherReligionInput" style="width: 100%; display: none; margin-top: 1rem;">
                                <label for="otherReligion">Input Religion</label>
                                <input type="text" name="religion" id="otherReligion" required style="width: 100%;">
                            </div>
                        </div>
                        <!-- Occupation Status -->
                        <div>
                            <label>Occupation Status <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="res_occupation-status" id="res_occupation-status" onchange="occupationFunction()" required>
                                    <option value="" disabled selected>Occupation Status</option>
                                    <option value="Employed" <?php if ($resident['occupation_status'] == "Employed") echo "selected"; ?>>Employed</option>
                                    <option value="Employed Government" <?php if ($resident['occupation_status'] == "Employed Government") echo "selected"; ?>>Employed Government</option>
                                    <option value="Employed Private" <?php if ($resident['occupation_status'] == "Employed Private") echo "selected"; ?>>Employed Private</option>
                                    <option value="Overseas Filipino Worker (OFW)" <?php if ($resident['occupation_status'] == "Overseas Filipino Worker (OFW)") echo "selected"; ?>>Overseas Filipino Worker (OFW)</option>
                                    <option value="Self-Employed (SE)" <?php if ($resident['occupation_status'] == "Self-Employed (SE)") echo "selected"; ?>>Self-Employed (SE)</option>
                                    <option value="Unemployed" <?php if ($resident['occupation_status'] == "Unemployed") echo "selected"; ?>>Unemployed</option>
                                    <option value="Unemployed" <?php if ($resident['occupation_status'] == "N/A") echo "selected"; ?>>N/A</option>
                                </select>
                            </div>
                        </div>
                        <!-- Occupation -->
                        <div>
                            <label>Occupation</label>
                            <input type="text" name="occupation" id="res_occupation" placeholder="Occupation" value="<?php echo $resident['occupation'] ?>">
                        </div>
                    </div>

                    <!-- Resident Address Title-->
                    <h2 class="form-title">Resident Address</h2>
                    <p class="add-resident__desc"></p>

                    <!-- Resident Address Form -->
                    <div class="resident-address form-group">

                        <!-- House no. -->
                        <div>
                            <label>House no. <span class="required-input">*</span></label>
                            <input type="text" name="house" placeholder="House no." value="<?php echo $resident['house'] ?>" required>
                        </div>
                        <!-- Building or Street -->
                        <div>
                            <label>Building or Street Name <span class="required-input">*</span></label>
                            <input type="text" name="street" placeholder="Building or Street Name" value="<?php echo $resident['street'] ?>" required>
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
        const clearSuffix = document.getElementById('clear-suffix')
        const suffix = document.getElementById('suffix')
        suffix.addEventListener('change', () => {
            clearSuffix.style.display = 'block'
        })
    </script>
    <script>
        /* set max date to current date */
        document.getElementById("res_bdate").max = new Date().toISOString().split("T")[0];

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

        // Other religion
        const religionSelect = document.getElementById("religionSelect");
        const otherReligionInput = document.getElementById("otherReligionInput");
        const otherReligionField = document.getElementById("otherReligion");

        otherReligionField.disabled = true;
        religionSelect.addEventListener("change", function() {
            if (religionSelect.value === "Others") {
                otherReligionInput.style.display = "block";
                otherReligionField.disabled = false;
            } else {
                otherReligionInput.style.display = "none";
                otherReligionField.disabled = true; // Disable the input
                otherReligionField.value = ""; // Clear its value
            }
        });

        // Other citizenship
        const citizenshipSelect = document.getElementById("res_citizenship");
        const othercitizenshipInput = document.getElementById("otherCitizenshipInput");
        const otherCitizenshipField = document.getElementById("otherCitizenship");

        otherCitizenshipField.disabled = true;
        citizenshipSelect.addEventListener("change", function() {
            if (citizenshipSelect.value === "Others") {
                othercitizenshipInput.style.display = "block";
                otherCitizenshipField.disabled = false;
            } else {
                othercitizenshipInput.style.display = "none";
                otherCitizenshipField.disabled = true; // Disable the input
                otherCitizenshipField.value = ""; // Clear its value
            }
        });
    </script>
</body>

</html>