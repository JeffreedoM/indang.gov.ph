<?php
include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

$stmt = $pdo->prepare("SELECT * FROM special_project WHERE barangay_id ='$barangayId'");
$stmt->execute();
$special_project = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="./assets/css/main-project.css">
    <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Special Projects</title>

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
                <h3 class="page-title font-semibold">Special Projects</h3>
            </div>

            <!-- Page body -->
            <!-- Display residents in table -->
            <div class="display-resident page-body">

                <!-- Button to add resident -->
                <!-- When button is clicked, the add resident form will pop-up -->
                <button class="add-resident__button " onclick="openPopup()">
                    <span>New Project</span></button>

                <!-- Get residents in database -->
                <!-- All residents information will show in table -->
                <table id="resident-table" class="row-border hover">
                    <thead>
                        <tr>
                            <th>Project Name</th>
                            <th>Date of Activity</th>
                            <th>Description</th>
                            <th>Project Host</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($special_project as $project) { ?>
                            <tr>
                                <td><?php echo $project['project_name']; ?></td>
                                <td><?php echo date("F d, Y", strtotime($project['project_date'])); ?></td>
                                <td><?php echo $project['project_description']; ?></td>
                                <?php
                                if ($project['project_host'] == 'Others') {
                                    if ($project['project_other_host'] == null) {
                                        $host = $project['project_host'];
                                    } else {
                                        $host = $project['project_other_host'];
                                    }
                                } else {
                                    $host = $project['project_host'];
                                }
                                ?>
                                <td><?php echo $host; ?></td>

                                <!-- <td><?php echo $project['project_name'] ?></td>
                                <td><?= $project['project_date']; ?></td>
                                <td><?= $project['project_description']; ?></td> -->
                                <td>
                                    <button><a href="./project-view.php?id=<?php echo $project['project_id'] ?>">View</a></button>
                                    <button><a href="./project-edit.php?id=<?php echo $project['project_id'] ?>">Edit</a></button>
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
                <h1 class="add-resident__title">Special Project Information</h1>
                <form action="./query.php" method="POST" enctype="multipart/form-data" class="add-resident__form">
                    <!-- Personal Information Title -->
                    <h2 class="form-title">Project Details</h2>
                    <p class="add-resident__desc">Fill up all the required fields with asterisk**.</p>

                    <!-- Personal Information Form -->
                    <div class="personal-info form-group">
                        <!-- First Name -->
                        <div class="project-name">
                            <label for="">Project Name <span class="required-input">*</span></label>
                            <input type="text" name="project_name" placeholder="Title" required>
                        </div>
                        <div class="project-date">
                            <label for="">Date <span class="required-input">*</span></label>
                            <input type="date" name="project_date" id="date" required>
                        </div>
                    </div>
                    <div class="personal-info form-group">
                        <div class="project-host">
                            <label for="">Host <span class="required-input">*</span></label>
                            <select name="project_host" id="">
                                <option value="" selected disabled>Choose Event Host</option>
                                <option value="Barangay Officials">Barangay Officials</option>
                                <option value="SK">SK</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="project-name">
                            <label for="">Other Host Name [if option others is selected]</label>
                            <input type="text" name="project_other_host" placeholder="Other Host Name">
                        </div>
                    </div>
                    <div class="personal-info form-group">
                        <div class="project-description">
                            <label for="">Description <span class="required-input">*</span></label>
                            <script>
                                function addNewLine(event) {
                                    if (event.keyCode == 13) {
                                        event.preventDefault();
                                        var textarea = document.getElementById("myTextarea");
                                        textarea.value += "\n";
                                    }
                                }
                            </script>
                            <textarea id="myTextarea" onkeypress="addNewLine(event)" name="project_description" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="personal-info form-group">
                        <div class="project-description">
                            <label for="">Requirements</label>
                            <textarea name="project_requirements" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <button type="submit" name="submit" id="submitButton">Add Project</button>
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
        document.getElementById("date").max = new Date().toISOString().split("T")[0];

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