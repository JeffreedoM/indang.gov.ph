<?php
include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <link rel="stylesheet" href="./assets/css/main-resident.css">
    <title>Resident Profiling</title>

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
            <div class="display-resident page-body">

                <?php if ($logged_resident['position'] == 'Barangay Secretary') {
                ?>
                    <!-- Button to add resident -->
                    <!-- When button is clicked, the add resident form will pop-up -->
                    <button class="add-resident__button " onclick="openPopup()">
                        <span>Add resident</span>
                    </button>
                <?php
                } ?>

                <!-- Get residents in database -->
                <!-- All residents information will show in table -->
                <table id="resident-table" class="row-border hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Sex</th>
                            <th>Religion</th>
                            <th>Civil Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resident as $resident) { ?>
                            <tr>
                                <td><?php
                                    $resident_fullname = "$resident[firstname] $resident[middlename] $resident[lastname]";
                                    echo $resident_fullname ?>
                                </td>
                                <td><?php echo $resident['sex'] ?></td>
                                <td><?php echo $resident['religion'] ?></td>
                                <td><?php echo $resident['civil_status'] ?></td>
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
                <form action="./includes/resident.inc.php" method="POST" enctype="multipart/form-data" class="add-resident__form">
                    <!-- Personal Information Title -->
                    <h2 class="form-title">Resident Information</h2>
                    <p class="add-resident__desc">Fill up all the required fields with asterisk**.</p>

                    <!-- Profile Image -->
                    <div class="profile-pic-div">
                        <img src="./assets/images/uploads/noprofile.jpg" id="photo">
                        <input type="file" name="image" id="file" required>
                        <label for="file" id="uploadBtn">Choose Photo</label>
                    </div>

                    <!-- Personal Information Form -->
                    <div class="personal-info form-group">
                        <!-- First Name -->
                        <div>
                            <label for="">First name <span class="required-input">*</span></label>
                            <input type="text" name="firstname" placeholder="Firstname" required>
                        </div>
                        <!-- Middle Name -->
                        <div>
                            <label for="">Middle name</label>
                            <input type="text" name="middlename" placeholder="Middle name">
                        </div>
                        <!-- Last Name -->
                        <div>
                            <label for="">Last name <span class="required-input">*</span></label>
                            <input type="text" name="lastname" placeholder="Last name" required>
                        </div>
                        <!-- Suffix -->
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
                            <label for="">Age <span class="required-input">*</span></label>
                            <input type="number" name="age" id="res_age" readonly maxlength="3" placeholder="Age" required>
                        </div>
                        <!-- Civil Status -->
                        <div>
                            <label for="">Civil Status <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="civil_status" id="" required>
                                    <option value="" disabled selected>Civil Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="widow">Widow/er</option>
                                    <option value="legally separated">Legally Separated</option>
                                    <option value="annulled">Annulled</option>
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
                            <input type="text" name="contact" id="res_contactnum" placeholder="Contact No." readonly onkeyup="numbersOnly(this)">
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
                                </select>
                            </div>
                        </div>
                        <!-- Religion -->
                        <div>
                            <label for="">Religion <span class="required-input">*</span></label>
                            <div class="select-wrapper">
                                <select name="religion" id="" required>
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
                                </select>
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
                            <input type="text" name="building" placeholder="Building or Street Name" required>
                        </div>
                        <!-- Barangay Name -->
                        <div>
                            <label for="">Barangay <span class="required-input">*</span></label>
                            <input type="text" name="barangay" placeholder="Barangay" required>
                        </div>
                    </div>

                    <button type="submit" name="submit" id="submitButton">Add resident</button>
                </form>

                <!-- close popup button -->
                <span class="close-popup" onclick="closePopup()">
                    <i class="fa-solid fa-x"></i>
                </span>
            </div>
        </div>


    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="./assets/js/resident-profiling.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        /* set max date to current date */
        document.getElementById("res_bdate").max = new Date().toISOString().split("T")[0];

        $(document).ready(function() {
            $('#resident-table').DataTable();
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

        submitButton.addEventListener('click', function(event) {
            if (!fileInput.value) {
                event.preventDefault(); //prevent form submission
                alert("Please choose a Profile Image.");
            }
        });
    </script>
</body>

</html>