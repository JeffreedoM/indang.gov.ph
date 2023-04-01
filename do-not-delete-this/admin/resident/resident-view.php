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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.6.95/css/materialdesignicons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <link rel="stylesheet" href="../../assets/css/bs-overwrite.css" />
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

        <!-- View Resident -->
        <div class="resident-view wrapper">
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
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"><?php echo $fullname ?></span>
                                </div>
                            </li>
                        </ol>
                    </div>

                </h3>
            </div>
            <div class="page-content page-container" id="page-content">

                <div class="row container d-flex justify-content-center">
                    <div class="col-md-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-4 bg-c-lite-green user-profile">
                                    <div class="card-block text-center text-white">
                                        <div class="m-b-25">
                                            <?php if ($resident['image'] === '') { ?>
                                                <img src="./assets/images/uploads/noprofile.jpg" class="img-radius mx-auto" alt="User-Profile-Image">
                                            <?php } else {
                                            ?>
                                                <img src="./assets/images/uploads/<?php echo $resident['image'] ?>" class="img-radius mx-auto" alt="User-Profile-Image">
                                            <?php } ?>
                                            <!-- <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image"> -->
                                        </div>
                                        <h6 class="f-w-600"><?php echo $fullname ?></h6>
                                        <p>Resident ID: <?php echo $id ?></p>
                                        <button id="edit-button">
                                            <a href="./resident-edit.php?id=<?php echo $resident['resident_id'] ?>">Edit <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i></a>
                                        </button>

                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Sex</p>
                                                <h6 class="text-muted f-w-400"><?php echo $resident['sex'] ?></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Birthdate</p>
                                                <h6 class="text-muted f-w-400"><?php echo $resident['birthdate'] ?></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Age</p>
                                                <h6 class="text-muted f-w-400"><?php echo $resident['age'] ?></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Civil Status</p>
                                                <h6 class="text-muted f-w-400"><?php echo $resident['civil_status'] ?></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Religion</p>
                                                <h6 class="text-muted f-w-400"><?php echo $resident['religion'] ?></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Height</p>
                                                <h6 class="text-muted f-w-400"><?php echo $resident['height'] ?></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Weight</p>
                                                <h6 class="text-muted f-w-400"><?php echo $resident['weight'] ?></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Contact</p>
                                                <h6 class="text-muted f-w-400"><?php echo $resident['contact'] ?></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Occupation Status</p>
                                                <h6 class="text-muted f-w-400"><?php echo $resident['occupation_status'] ?></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Occupation</p>
                                                <h6 class="text-muted f-w-400"><?php echo $resident['occupation'] ?></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Address</p>
                                                <h6 class="text-muted f-w-400"><?php echo $resident['address'] ?></h6>
                                            </div>
                                        </div>
                                        <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Family</h6>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Mother</p>
                                                <h6 class="text-muted f-w-400"></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Father</p>
                                                <h6 class="text-muted f-w-400"></h6>
                                            </div>
                                        </div>
                                        <ul class="social-link list-unstyled m-t-40 m-b-5">
                                            <!-- <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="facebook" data-abc="true"><i class="mdi mdi-facebook feather icon-facebook facebook" aria-hidden="true"></i></a></li>
                                            <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="twitter" data-abc="true"><i class="mdi mdi-twitter feather icon-twitter twitter" aria-hidden="true"></i></a></li>
                                            <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="instagram" data-abc="true"><i class="mdi mdi-instagram feather icon-instagram instagram" aria-hidden="true"></i></a></li> -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>