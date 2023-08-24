<?php
include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

// alive residents
$stmt = $pdo->prepare("SELECT * FROM resident WHERE is_alive = 1 AND barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['show-deceased'])) {
    // all residents
    $stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id ORDER BY is_alive ASC");
    $stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
    $stmt->execute();
    $all_residents = $stmt->fetchAll();

    $resident = $all_residents;
}
if (isset($_POST['clear'])) {
    header('Location: resident-profiling.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <link rel="stylesheet" href="./assets/css/main-resident.css">
    <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Resident Profiling</title>

    <style>
        #deceased {
            width: 100%;
            background-color: pink;
            /* display: none; */
        }

        .show-deceased {
            display: block;
            color: red;
            border-bottom: 2px solid red;
            margin-bottom: 1rem;
        }

        .show-deceased-cell {
            display: none;
        }
    </style>
</head>

<body>
    <?php
    include '../../partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include '../../partials/nav_header.php';
        ?>

        <!-- Resident Profiling Page-->
        <div class="resident wrapper">

            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title font-semibold">List of Residents</h3>
            </div>

            <!-- Page body -->
            <!-- Display residents in table -->
            <div class="display-resident page-body" style="overflow-x: scroll;">

                <!-- Button to add resident -->
                <!-- When button is clicked, the add resident form will pop-up -->
                <button class="add-resident__button " onclick="openPopup()">
                    <span>Add resident</span>
                </button>

                <button class="show-deceased">
                    <form action="" method="POST">
                        <?php if (!isset($_POST['show-deceased'])) : ?>
                            <button type="submit" name="show-deceased" class="show-deceased">
                                Show Deceased
                            </button>
                        <?php else : ?>
                            <button type="submit" name="clear" class="show-deceased">
                                Hide Deceased
                            </button>
                        <?php endif ?>
                    </form>
                </button>

                <!-- Get residents in database -->
                <!-- All residents information will show in table -->
                <table id="resident-table" class="row-border hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Sex</th>
                            <th>Religion</th>
                            <th>Civil Status</th>
                            <?php if (isset($_POST['show-deceased'])) : ?>
                                <th>Deceased</th>
                            <?php endif ?>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resident as $resident) {
                            $is_alive = $resident['is_alive'] == 1;
                        ?>

                            <tr <?php echo $is_alive ? '' : "id='deceased'" ?>>
                                <td><?php
                                    $suffix = $resident['suffix'] != '' ?  "($resident[suffix])" : "";
                                    $resident_fullname = "$resident[firstname] $resident[middlename] $resident[lastname] $suffix";
                                    echo $resident_fullname ?>
                                </td>
                                <td><?php echo $resident['sex'] ?></td>
                                <td><?php echo $resident['religion'] ?></td>
                                <td><?php echo $resident['civil_status'] ?></td>
                                <?php if (isset($_POST['show-deceased'])) : ?>
                                    <td><?php echo $is_alive ? 'No' : 'Yes'  ?> </td>
                                <?php endif ?>
                                <td>
                                    <button><a href="./resident-view.php?id=<?php echo $resident['resident_id'] ?>">View</a></button>
                                    <button><a href="./resident-edit.php?id=<?php echo $resident['resident_id'] ?>">Edit</a></button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Add resident -->
            <div class="modal-bg" onclick="closePopup()" id="modal-background">
            </div>

            <div class="add-resident popup" id="modal-container">
                <h1 class="add-resident__title">Personal Information</h1>
                <form action="includes/resident.inc.php" method="POST" enctype="multipart/form-data" class="add-resident__form" id="addResidentForm">
                    <!-- Personal Information Title -->
                    <h2 class="form-title">Resident Information</h2>
                    <p class="add-resident__desc">Fill up all the required fields with asterisk**.</p>

                    <!-- Profile Image -->
                    <div class="profile-pic-div">
                        <img src="./assets/images/uploads/noprofile.jpg" id="photo">
                        <input type="file" name="image" id="file">
                        <label for="file" id="uploadBtn">Choose Photo</label>
                    </div>

                    <!-- Personal Information Form -->
                    <div class="personal-info form-group">
                        <!-- First Name -->
                        <div>
                            <label for="">First name <span class="required-input">*</span></label>
                            <input type="text" name="firstname" id="firstname" placeholder="First name" required>
                        </div>
                        <!-- Middle Name -->
                        <div>
                            <label for="">Middle name</label>
                            <input type="text" name="middlename" placeholder="Middle name">
                        </div>
                        <!-- Last Name -->
                        <div>
                            <label for="">Last name <span class="required-input">*</span></label>
                            <input type="text" name="lastname" id="lastname" placeholder="Last name" required>
                        </div>
                        <!-- Suffix -->
                        <div>
                            <label for="">Suffix</label>
                            <div class="select-wrapper">
                                <select name="suffix" id="suffix">
                                    <option value="" disabled selected>Select a suffix</option>
                                    <option value="CFRE">CFRE</option>
                                    <option value="CLU">CLU</option>
                                    <option value="CPA">CPA</option>
                                    <option value="C.S.J">C.S.J</option>
                                    <option value="D.C.">D.C.</option>
                                    <option value="D.D.">D.D.</option>
                                    <option value="D.D.S.">D.D.S.</option>
                                    <option value="D.M.D.">D.M.D.</option>
                                    <option value="D.O.">D.O.</option>
                                    <option value="D.V.M.">D.V.M.</option>
                                    <option value="Ed.D.">Ed.D.</option>
                                    <option value="Esq.">Esq.</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="Inc.">Inc.</option>
                                    <option value="J.D.">J.D.</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="LL.D.">LL.D.</option>
                                    <option value="Ltd.">Ltd.</option>
                                    <option value="M.D.">M.D.</option>
                                    <option value="O.D.">O.D.</option>
                                    <option value="O.S.B.">O.S.B.</option>
                                    <option value="P.C.">P.C.</option>
                                    <option value="P.E.">P.E.</option>
                                    <option value="Ph.D.">Ph.D.</option>
                                    <option value="Ret.">Ret.</option>
                                    <option value="R.G.S">R.G.S</option>
                                    <option value="R.N">R.N.</option>
                                    <option value="R.N.C">R.N.C.</option>
                                    <option value="S.H.C.J.">S.H.C.J.</option>
                                    <option value="S.J.">S.J.</option>
                                    <option value="S.N.J.M.">S.N.J.M.</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="S.S.M.O.">S.S.M.O.</option>
                                    <option value="USA">USA</option>
                                    <option value="USAF">USAF</option>
                                    <option value="USAFR">USAFR</option>
                                    <option value="USAR">USAR</option>
                                    <option value="USCG">USCG</option>
                                    <option value="USMCR">USMCR</option>
                                    <option value="USN">USN</option>
                                    <option value="USNR">USNR</option>
                                </select>
                            </div>
                            <p id="clear-suffix" style="display: none;" class="m-0 ml-auto mt-1 underline underline-offset-4 cursor-pointer" onclick="document.getElementById('suffix').value = ''">Clear Selection</p>

                        </div>
                        <!-- Sex -->
                        <div>
                            <label for="">Sex <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="sex" id="sex" required>
                                    <option value="" disabled selected>Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <!-- Birthdate -->
                        <div>
                            <label for="">Birthdate <span class="required-input">*</span></label>
                            <input type="date" name="birthdate" id="res_bdate" class="date" placeholder="Birthdate" onblur="getAge()" required>
                        </div>
                        <!-- Age -->
                        <div>
                            <label for="">Age</label>
                            <input type="number" name="age" id="res_age" readonly maxlength="3" placeholder="Age" required>
                        </div>
                        <!-- Civil Status -->
                        <div>
                            <label for="">Civil Status <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="civil_status" id="" required>
                                    <option value="" disabled selected>Civil Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widow">Widow/er</option>
                                    <option value="Legally Separated">Legally Separated</option>
                                    <option value="Annulled">Annulled</option>
                                </select>
                            </div>
                        </div>
                        <!-- Contact Type -->
                        <div>
                            <label for="">Contact Type</label>
                            <div class="select-wrapper">
                                <select name="contact_type" id="res_contacttype" onchange="maxLengthFunction(); ">
                                    <option value="" disabled selected>Contact Type</option>
                                    <option value="no_contact">N/A</option>
                                    <option value="mobile">Mobile</option>
                                    <option value="tel">Tel.</option>
                                </select>
                            </div>
                        </div>
                        <!-- Contact Number -->
                        <div>
                            <label for="">Contact</label>
                            <input type="text" name="contact" id="res_contactnum" placeholder="Contact No." readonly onkeyup="formatContactNumber()">
                        </div>
                        <!-- Height -->
                        <div>
                            <label for="">Height (optional)</label>
                            <input type="number" name="height" id="" placeholder="Height (cm)">
                        </div>
                        <!-- Weight -->
                        <div>
                            <label for="">Weight (optional)</label>
                            <input type="number" name="weight" id="" placeholder="Weight (kg)">
                        </div>
                        <!-- Citizenship -->
                        <div>
                            <label for="">Citizenship <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="citizenship" id="res_citizenship" required>
                                    <option value="" disabled selected>Citizenship</option>
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
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div id="otherCitizenshipInput" style="width: 100%; display: none; margin-top: 1rem;">
                                <label for="otherCitizenship">Input Citizenship</label>
                                <input type="text" name="citizenship" id="otherCitizenship" style="width: 100%;">
                            </div>
                        </div>
                        <!-- Religion -->
                        <div>
                            <label for="">Religion <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="religion" id="religionSelect" required>
                                    <option value="" disabled selected>Religion</option>
                                    <option value="Ang Dating Daan">Ang Dating Daan</option>
                                    <option value="Baptist">Baptist</option>
                                    <option value="Born Again">Born Again</option>
                                    <option value="Buddhism">Buddhism</option>
                                    <option value="Christian Catholic">Christian Catholic</option>
                                    <option value="Christian Protestant">Christian Protestant</option>
                                    <option value="Iglesia Ni Kristo">Iglesia Ni Kristo</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Jehovah's Witness">Jehovah's Witness</option>
                                    <option value="Seventh Day Adventist">Seventh Day Adventist</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div id="otherReligionInput" style="width: 100%; display: none; margin-top: 1rem;">
                                <label for="otherReligion">Input Religion</label>
                                <input type="text" name="religion" id="otherReligion" style="width: 100%;">
                            </div>
                        </div>
                        <!-- Occupation Status -->
                        <div>
                            <label for="">Occupation Status <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="res_occupation-status" id="res_occupation-status" onchange="occupationFunction()" required>
                                    <option value="" disabled selected>Occupation Status</option>
                                    <option value="Employed">Employed</option>
                                    <option value="Employed Government">Employed Government</option>
                                    <option value="Employed Private">Employed Private</option>
                                    <option value="Overseas Filipino Worker (OFW)">Overseas Filipino Worker (OFW)</option>
                                    <option value="Self-Employed (SE)">Self-Employed (SE)</option>
                                    <option value="Unemployed">Unemployed</option>
                                </select>
                            </div>
                        </div>
                        <!-- Occupation -->
                        <div>
                            <label for="">Occupation</label>
                            <input type="text" name="occupation" id="res_occupation" placeholder="Occupation" readonly>
                        </div>
                    </div>

                    <!-- Resident Address Title-->
                    <h2 class="form-title">Resident Address</h2>
                    <p class="add-resident__desc"></p>

                    <!-- Resident Address Form -->
                    <div class="resident-address form-group">

                        <!-- House no. -->
                        <div>
                            <label for="">House no. <span class="required-input">*</span></label>
                            <input type="text" name="house" placeholder="House no." required>
                        </div>
                        <!-- Building or Street -->
                        <div>
                            <label for="">Building or Street Name <span class="required-input">*</span></label>
                            <input type="text" name="street" placeholder="Building or Street Name" required>
                        </div>
                        <!-- Barangay Name -->
                        <!-- <div>
                            <label for="">Barangay <span class="required-input">*</span></label>
                            <input type="text" name="barangay" placeholder="Barangay" value="<?php echo $barangayName ?>" disabled required class="bg-gray-100">
                        </div> -->
                    </div>

                    <button type="submit" name="add-resident" id="submitButton">Add resident</button>

                </form>

                <!-- close popup button -->
                <span class="close-popup" onclick="closePopup()">
                    <i class="fa-solid fa-x"></i>
                </span>
            </div>
        </div>

        <!-- Alert for confirming duplicate entries -->


        <!-- <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            Toggle modal
        </button> -->

        <div id="popup-modal" data-modal-backdrop="static" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button> -->
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 font-normal text-gray-500 dark:text-gray-400">
                            <div class="font-semibold mb-2">Warning: Potential Duplicate Resident</div>
                            Attributes of the new resident closely resemble an existing entry.<span class="block mt-3"> </span>
                        </h3>
                        <div class="mb-5 w-[200px] mx-auto">
                            <div class="mx-auto">
                                <img id="result_image" src="" alt="User-Profile-Image" class="mx-auto" width="200">
                            </div>
                            <div class="text-left mx-auto">
                                <p id="result_name" class="text-center mb-3"></p>
                                <p id="result_birthdate"></p>
                                <p id="result_age"></p>
                                <p id="result_sex"></p>
                            </div>
                        </div>
                        <hr>
                        <h3 class="m-5 font-normal text-gray-500 dark:text-gray-400">Are you sure you want to add this resident?</h3>
                        <button data-modal-hide="popup-modal" id="confirmDuplicateBtn" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Yes, add resident
                        </button>
                        <button data-modal-hide="popup-modal" id="cancelDuplicateBtn" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="./assets/js/resident-profiling.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        const clearSuffix = document.getElementById('clear-suffix')
        const suffix = document.getElementById('suffix')
        suffix.addEventListener('change', () => {
            clearSuffix.style.display = 'block'
        })
    </script>
    <script>
        document.getElementById("addResidentForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the form from submitting

            // Get input values
            const firstname = document.getElementById("firstname").value.trim();
            const lastname = document.getElementById("lastname").value.trim();
            const sex = document.getElementById("sex").value;
            const birthdate = document.getElementById("res_bdate").value;

            // Send an AJAX request to check for duplicate residents
            const formData = new FormData();
            formData.append('firstname', firstname);
            formData.append('lastname', lastname);
            formData.append('sex', sex);
            formData.append('birthdate', birthdate);

            fetch("includes/check_duplicate_resident.php", {
                    method: "POST",
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.duplicate) {
                        const result = JSON.parse(JSON.stringify(data.result)); // Get the result from the server
                        // console.log(result)
                        const confirmModal = document.getElementById('popup-modal')
                        const modal = new Modal(confirmModal, {
                            closable: false
                        })
                        modal.show()

                        // Displaying the fetched registered resident
                        const result_image = document.getElementById('result_image')
                        if (result.image === '') {
                            result_image.src = './assets/images/uploads/noprofile.jpg'
                        } else {
                            result_image.src = `./assets/images/uploads/${result.image}`
                        }

                        function calculateAge(dateOfBirth) {
                            // Parse the date of birth string into a Date object
                            var dob = new Date(dateOfBirth);

                            // Get the current date
                            var currentDate = new Date();

                            // Calculate the difference in years
                            var age = currentDate.getFullYear() - dob.getFullYear();

                            // Adjust the age if the birth month hasn't occurred yet or if the birth month has occurred but the birth day hasn't occurred yet
                            if (currentDate.getMonth() < dob.getMonth() || (currentDate.getMonth() === dob.getMonth() && currentDate.getDate() < dob.getDate())) {
                                age--;
                            }

                            return age;
                        }

                        function formatDateToWords(dateString) {
                            // Split the date string into year, month, and day components
                            const [year, month, day] = dateString.split('-');

                            // Month names
                            const months = [
                                'January', 'February', 'March', 'April', 'May', 'June',
                                'July', 'August', 'September', 'October', 'November', 'December'
                            ];

                            // Convert the month to its corresponding word
                            const monthWord = months[parseInt(month) - 1];

                            // Format the date in words
                            const formattedDate = `${monthWord} ${parseInt(day)}, ${year}`;

                            return formattedDate;
                        }

                        const age = calculateAge(result.birthdate);
                        const birthdate = formatDateToWords(result.birthdate);
                        document.getElementById('result_name').textContent = `${result.firstname} ${result.middlename} ${result.lastname}`
                        document.getElementById('result_birthdate').textContent = `Birthdate: ${birthdate}`
                        document.getElementById('result_age').textContent = `Age: ${age}`
                        document.getElementById('result_sex').textContent = `Sex: ${result.sex}`

                        // Handle the user's choice
                        document.getElementById('confirmDuplicateBtn').addEventListener('click', function() {
                            // console.log('User clicked yes')
                            // User clicked yes, submit the form
                            // Get the form element
                            const addResidentForm = document.getElementById("addResidentForm");

                            if (addResidentForm && addResidentForm instanceof HTMLFormElement) {
                                addResidentForm.submit();
                            } else {
                                console.error("The form element is not found or is not recognized as a form.");
                            }
                        });
                        document.getElementById('cancelDuplicateBtn').addEventListener('click', function() {
                            // console.log('User clicked cancel')
                            // User canceled, close the modal
                            modal.hide();
                        });

                    } else {
                        // No duplicate, submit the form
                        const addResidentForm = document.getElementById("addResidentForm");

                        // No duplicate, submit the form
                        addResidentForm.submit();
                    }
                })
                .catch(error => {
                    console.error("An error occurred:", error);
                });
        });
    </script>
    <script>
        /* set max date to current date */
        document.getElementById("res_bdate").max = new Date().toISOString().split("T")[0];

        $(document).ready(function() {
            $('#resident-table').DataTable({
                <?php if (isset($_POST['show-deceased'])) : ?> 'order': [4, 'desc']

                <?php endif ?>
            });
        });

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

        // submitButton.addEventListener('click', function(event) {
        //     if (!fileInput.value) {
        //         event.preventDefault(); //prevent form submission
        //         alert("Please choose a Profile Image.");
        //     }
        // });

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