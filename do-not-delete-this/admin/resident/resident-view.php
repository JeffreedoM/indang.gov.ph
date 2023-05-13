<?php
include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

$id = $_GET['id']; // id of the resident in the current profile 
// select resident from the resident table
$resident = $pdo->query("SELECT * FROM resident WHERE resident_id='$id'")->fetch();
$fullname = "$resident[firstname] $resident[middlename] $resident[lastname] $resident[suffix]";

include 'includes/resident-view.inc.php';
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
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
        <div class="resident-view wrapper" style="position:relative;">
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
                                                <h6 class="text-muted f-w-400"><?php echo date('F j, Y', strtotime($resident['birthdate'])) ?></h6>
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
                                                <!-- Modal toggle -->
                                                <?php if ($mother_exists) : ?>
                                                    <h6 class="text-muted f-w-400"><?php echo $mother_fullname ?></h6>
                                                <?php else : ?>
                                                    <button data-modal-target="motherModal" data-modal-toggle="motherModal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                                        Add mother
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-5 mt-2 f-w-600">Father</p>
                                                <!-- Modal toggle -->
                                                <?php if ($father_exists) : ?>
                                                    <h6 class="text-muted f-w-400"><?php echo $father_fullname ?></h6>
                                                <?php else : ?>
                                                    <button data-modal-target="fatherModal" data-modal-toggle="fatherModal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                                        Add father
                                                    </button>
                                                <?php endif; ?>
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

                <!-- Modal for List of Female Residents -->
                <div id="motherModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    List of Female Residents
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="motherModal">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-6 space-y-6">

                                <table id="female-residents-table" class="row-border hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($femaleResidents as $femaleResident) { ?>
                                            <tr id="<?php echo $femaleResident['resident_id'] ?>" style="cursor:pointer" data-modal-hide="motherModal" data-modal-target="motherAlert" data-modal-toggle="motherAlert">
                                                <td><?php echo $femaleResident['resident_id'] ?></td>
                                                <td><?php
                                                    $femaleResident_fullname = "$femaleResident[firstname] $femaleResident[middlename] $femaleResident[lastname]";
                                                    echo $femaleResident_fullname ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Adding Mother Form with Confirmation -->
                <div id="motherAlert" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="motherAlert">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-6 text-center">
                                <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to add this resident as mother?</h3>
                                <form action="includes/resident-family.inc.php" method="POST">
                                    <!-- get id of resident -->
                                    <input type="hidden" name="resident_id" id="resident_id" value="<?php echo $_GET['id'] ?>">

                                    <!-- get id of selected mother resident -->
                                    <input type="hidden" name="mother_id" class="selected_id">

                                    <!-- Submit  -->
                                    <button data-modal-hide="motherAlert" type="submit" name="submit_mother" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                        Yes, I'm sure
                                    </button>

                                    <button data-modal-hide="motherAlert" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        <input type="reset" value="No, cancel">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for List of Male Residents -->
                <div id="fatherModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    List of Male Residents
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="fatherModal">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-6 space-y-6">

                                <table id="male-residents-table" class="row-border hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($maleResidents as $maleResident) { ?>
                                            <tr id="<?php echo $maleResident['resident_id'] ?>" style="cursor:pointer" data-modal-hide="fatherModal" data-modal-target="fatherAlert" data-modal-toggle="fatherAlert">
                                                <td><?php echo $maleResident['resident_id'] ?></td>
                                                <td><?php
                                                    $maleResident_fullname = "$maleResident[firstname] $maleResident[middlename] $maleResident[lastname]";
                                                    echo $maleResident_fullname ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Adding Father Form with Confirmation -->
                <div id="fatherAlert" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="fatherAlert">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-6 text-center">
                                <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to add this resident as father?</h3>
                                <form action="includes/resident-family.inc.php" method="POST">
                                    <!-- get id of resident -->
                                    <input type="hidden" name="resident_id" id="resident_id" value="<?php echo $_GET['id'] ?>">

                                    <!-- get id of selected father resident -->
                                    <input type="hidden" name="father_id" class="selected_id">

                                    <!-- Submit  -->
                                    <button data-modal-hide="fatherAlert" type="submit" name="submit_father" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                        Yes, I'm sure
                                    </button>

                                    <button data-modal-hide="fatherAlert" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        <input type="reset" value="No, cancel">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="./assets/js/select-resident.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#female-residents-table').DataTable();
        });
        $(document).ready(function() {
            $('#male-residents-table').DataTable();
        });
    </script>
</body>

</html>