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
                        echo $resident_suffix;
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
                                <select name="suffix" id="">
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
                            <label>Age <span class="required-input">*</span></label>
                            <input type="number" name="age" id="res_age" readonly maxlength="3" placeholder="Age" value="<?php echo $resident['age'] ?>" required>
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
                                    <option value="<?php echo $resident['citizenship'] ?>" selected><?php echo $resident['citizenship'] ?></option>
                                    <option value="Filipino">Filipino</option>
                                    <option value="afghan">Afghan</option>
                                    <option value="albanian">Albanian</option>
                                    <option value="algerian">Algerian</option>
                                    <option value="american">American</option>
                                    <option value="andorran">Andorran</option>
                                    <option value="angolan">Angolan</option>
                                    <option value="antiguans">Antiguans</option>
                                    <option value="argentinean">Argentinean</option>
                                    <option value="armenian">Armenian</option>
                                    <option value="australian">Australian</option>
                                    <option value="austrian">Austrian</option>
                                    <option value="azerbaijani">Azerbaijani</option>
                                    <option value="bahamian">Bahamian</option>
                                    <option value="bahraini">Bahraini</option>
                                    <option value="bangladeshi">Bangladeshi</option>
                                    <option value="barbadian">Barbadian</option>
                                    <option value="barbudans">Barbudans</option>
                                    <option value="batswana">Batswana</option>
                                    <option value="belarusian">Belarusian</option>
                                    <option value="belgian">Belgian</option>
                                    <option value="belizean">Belizean</option>
                                    <option value="beninese">Beninese</option>
                                    <option value="bhutanese">Bhutanese</option>
                                    <option value="bolivian">Bolivian</option>
                                    <option value="bosnian">Bosnian</option>
                                    <option value="brazilian">Brazilian</option>
                                    <option value="british">British</option>
                                    <option value="bruneian">Bruneian</option>
                                    <option value="bulgarian">Bulgarian</option>
                                    <option value="burkinabe">Burkinabe</option>
                                    <option value="burmese">Burmese</option>
                                    <option value="burundian">Burundian</option>
                                    <option value="cambodian">Cambodian</option>
                                    <option value="cameroonian">Cameroonian</option>
                                    <option value="canadian">Canadian</option>
                                    <option value="cape verdean">Cape Verdean</option>
                                    <option value="central african">Central African</option>
                                    <option value="chadian">Chadian</option>
                                    <option value="chilean">Chilean</option>
                                    <option value="chinese">Chinese</option>
                                    <option value="colombian">Colombian</option>
                                    <option value="comoran">Comoran</option>
                                    <option value="congolese">Congolese</option>
                                    <option value="costa rican">Costa Rican</option>
                                    <option value="croatian">Croatian</option>
                                    <option value="cuban">Cuban</option>
                                    <option value="cypriot">Cypriot</option>
                                    <option value="czech">Czech</option>
                                    <option value="danish">Danish</option>
                                    <option value="djibouti">Djibouti</option>
                                    <option value="dominican">Dominican</option>
                                    <option value="dutch">Dutch</option>
                                    <option value="east timorese">East Timorese</option>
                                    <option value="ecuadorean">Ecuadorean</option>
                                    <option value="egyptian">Egyptian</option>
                                    <option value="emirian">Emirian</option>
                                    <option value="equatorial guinean">Equatorial Guinean</option>
                                    <option value="eritrean">Eritrean</option>
                                    <option value="estonian">Estonian</option>
                                    <option value="ethiopian">Ethiopian</option>
                                    <option value="fijian">Fijian</option>
                                    <option value="finnish">Finnish</option>
                                    <option value="french">French</option>
                                    <option value="gabonese">Gabonese</option>
                                    <option value="gambian">Gambian</option>
                                    <option value="georgian">Georgian</option>
                                    <option value="german">German</option>
                                    <option value="ghanaian">Ghanaian</option>
                                    <option value="greek">Greek</option>
                                    <option value="grenadian">Grenadian</option>
                                    <option value="guatemalan">Guatemalan</option>
                                    <option value="guinea-bissauan">Guinea-Bissauan</option>
                                    <option value="guinean">Guinean</option>
                                    <option value="guyanese">Guyanese</option>
                                    <option value="haitian">Haitian</option>
                                    <option value="herzegovinian">Herzegovinian</option>
                                    <option value="honduran">Honduran</option>
                                    <option value="hungarian">Hungarian</option>
                                    <option value="icelander">Icelander</option>
                                    <option value="indian">Indian</option>
                                    <option value="indonesian">Indonesian</option>
                                    <option value="iranian">Iranian</option>
                                    <option value="iraqi">Iraqi</option>
                                    <option value="irish">Irish</option>
                                    <option value="israeli">Israeli</option>
                                    <option value="italian">Italian</option>
                                    <option value="ivorian">Ivorian</option>
                                    <option value="jamaican">Jamaican</option>
                                    <option value="japanese">Japanese</option>
                                    <option value="jordanian">Jordanian</option>
                                    <option value="kazakhstani">Kazakhstani</option>
                                    <option value="kenyan">Kenyan</option>
                                    <option value="kittian and nevisian">Kittian and Nevisian</option>
                                    <option value="kuwaiti">Kuwaiti</option>
                                    <option value="kyrgyz">Kyrgyz</option>
                                    <option value="laotian">Laotian</option>
                                    <option value="latvian">Latvian</option>
                                    <option value="lebanese">Lebanese</option>
                                    <option value="liberian">Liberian</option>
                                    <option value="libyan">Libyan</option>
                                    <option value="liechtensteiner">Liechtensteiner</option>
                                    <option value="lithuanian">Lithuanian</option>
                                    <option value="luxembourger">Luxembourger</option>
                                    <option value="macedonian">Macedonian</option>
                                    <option value="malagasy">Malagasy</option>
                                    <option value="malawian">Malawian</option>
                                    <option value="malaysian">Malaysian</option>
                                    <option value="maldivan">Maldivan</option>
                                    <option value="malian">Malian</option>
                                    <option value="maltese">Maltese</option>
                                    <option value="marshallese">Marshallese</option>
                                    <option value="mauritanian">Mauritanian</option>
                                    <option value="mauritian">Mauritian</option>
                                    <option value="mexican">Mexican</option>
                                    <option value="micronesian">Micronesian</option>
                                    <option value="moldovan">Moldovan</option>
                                    <option value="monacan">Monacan</option>
                                    <option value="mongolian">Mongolian</option>
                                    <option value="moroccan">Moroccan</option>
                                    <option value="mosotho">Mosotho</option>
                                    <option value="motswana">Motswana</option>
                                    <option value="mozambican">Mozambican</option>
                                    <option value="namibian">Namibian</option>
                                    <option value="nauruan">Nauruan</option>
                                    <option value="nepalese">Nepalese</option>
                                    <option value="new zealander">New Zealander</option>
                                    <option value="ni-vanuatu">Ni-Vanuatu</option>
                                    <option value="nicaraguan">Nicaraguan</option>
                                    <option value="nigerien">Nigerien</option>
                                    <option value="north korean">North Korean</option>
                                    <option value="northern irish">Northern Irish</option>
                                    <option value="norwegian">Norwegian</option>
                                    <option value="omani">Omani</option>
                                    <option value="pakistani">Pakistani</option>
                                    <option value="palauan">Palauan</option>
                                    <option value="panamanian">Panamanian</option>
                                    <option value="papua new guinean">Papua New Guinean</option>
                                    <option value="paraguayan">Paraguayan</option>
                                    <option value="peruvian">Peruvian</option>
                                    <option value="polish">Polish</option>
                                    <option value="portuguese">Portuguese</option>
                                    <option value="qatari">Qatari</option>
                                    <option value="romanian">Romanian</option>
                                    <option value="russian">Russian</option>
                                    <option value="rwandan">Rwandan</option>
                                    <option value="saint lucian">Saint Lucian</option>
                                    <option value="salvadoran">Salvadoran</option>
                                    <option value="samoan">Samoan</option>
                                    <option value="san marinese">San Marinese</option>
                                    <option value="sao tomean">Sao Tomean</option>
                                    <option value="saudi">Saudi</option>
                                    <option value="scottish">Scottish</option>
                                    <option value="senegalese">Senegalese</option>
                                    <option value="serbian">Serbian</option>
                                    <option value="seychellois">Seychellois</option>
                                    <option value="sierra leonean">Sierra Leonean</option>
                                    <option value="singaporean">Singaporean</option>
                                    <option value="slovakian">Slovakian</option>
                                    <option value="slovenian">Slovenian</option>
                                    <option value="solomon islander">Solomon Islander</option>
                                    <option value="somali">Somali</option>
                                    <option value="south african">South African</option>
                                    <option value="south korean">South Korean</option>
                                    <option value="spanish">Spanish</option>
                                    <option value="sri lankan">Sri Lankan</option>
                                    <option value="sudanese">Sudanese</option>
                                    <option value="surinamer">Surinamer</option>
                                    <option value="swazi">Swazi</option>
                                    <option value="swedish">Swedish</option>
                                    <option value="swiss">Swiss</option>
                                    <option value="syrian">Syrian</option>
                                    <option value="taiwanese">Taiwanese</option>
                                    <option value="tajik">Tajik</option>
                                    <option value="tanzanian">Tanzanian</option>
                                    <option value="thai">Thai</option>
                                    <option value="togolese">Togolese</option>
                                    <option value="tongan">Tongan</option>
                                    <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                                    <option value="tunisian">Tunisian</option>
                                    <option value="turkish">Turkish</option>
                                    <option value="tuvaluan">Tuvaluan</option>
                                    <option value="ugandan">Ugandan</option>
                                    <option value="ukrainian">Ukrainian</option>
                                    <option value="uruguayan">Uruguayan</option>
                                    <option value="uzbekistani">Uzbekistani</option>
                                    <option value="venezuelan">Venezuelan</option>
                                    <option value="vietnamese">Vietnamese</option>
                                    <option value="welsh">Welsh</option>
                                    <option value="yemenite">Yemenite</option>
                                    <option value="zambian">Zambian</option>
                                    <option value="zimbabwean">Zimbabwean</option>
                                </select>
                            </div>
                        </div>
                        <!-- Religion -->
                        <div>
                            <label>Religion <span class="required-input">*</span></label>
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
                                </select>
                            </div>
                        </div>
                        <!-- Occupation -->
                        <div>
                            <label>Occupation</label>
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
    </script>
</body>

</html>