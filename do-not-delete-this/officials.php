<?php
//for db connection
include 'includes/dbh.inc.php';
//Hide contents if the barangay is deactivated.
include 'includes/deactivated.inc.php';

function getOfficialDetails($position)
{
    global $pdo;
    $official = $pdo->query("SELECT * FROM resident INNER JOIN officials ON resident.resident_id = officials.resident_id WHERE officials.position = '$position'")->fetch();
    if ($official) {
        $imageSrc = $official['image'] ? 'admin/resident/assets/images/uploads/' . $official['image'] : './assets/images/uploads/no-profile.png';
        $name = "$official[firstname]  $official[middlename]  $official[lastname]";
        $bday = date('F j, Y', strtotime($official['birthdate']));
        $gender = $official['sex'];
        $civil_status = $official['civil_status'];
        $religion = $official['religion'];
        return array(
            'name' => $name,
            'image' => $imageSrc,
            'gender' => $gender,
            'birthday' => $bday,
            'status' => $civil_status,
            'religion' => $religion
        );
    } else {
        return array(
            // 'name' => "<a id='no-position' href='add-officials.php'>Set an official <i class='fa-solid fa-arrow-right-long'></i></a>",
            'name' => "Unassigned",
            'image' => './assets/images/uploads/no-profile.png',
            'gender' => '',
            'birthday' => '',
            'status' => '',
            'religion' => ''
        );
    }
}
$brgyCaptain = getOfficialDetails('Barangay Captain');
$brgyTreasurer = getOfficialDetails('Barangay Treasurer');
$comittee_peaceAndOrder = getOfficialDetails('Committee on Peace and Order');
$comittee_publicInformation = getOfficialDetails('Committee on Public Information/Environment');
$comittee_agricultural = getOfficialDetails('Committee on Agricultural');
$comittee_healthAndSports = getOfficialDetails('Committee on Health and Sports');
$comittee_education = getOfficialDetails('Committee on Education');
$comittee_budgetAndAppropriation = getOfficialDetails('Committee on Budget and Appropriation');
$comittee_infrastracture = getOfficialDetails('Committee on Infrastructure');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/homepage.css" />
    <link rel="stylesheet" href="./assets/css/officials.css" />
    <title><?php echo $barangayName ?></title>
    <link rel="icon" type="image/x-icon" href="../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
</head>

<body>
    <header>
        <img src="../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>" alt="Logo of <?php echo ucwords($barangay['b_name']) ?>" class="barangay-logo">
        <div>
            <h1 class="barangay-name"><?php echo $barangayName ?></h1>
            <hr>
            <p>Indang, Cavite</p>
        </div>
        <img src="./assets/images/logo.jpg" alt="Logo of Indang" class="indang-logo">
    </header>

    <!-- navigation menu -->
    <nav>
        <ul>
            <li class="nav-item"><a href="index.php">Home</a></li>
            <div class="nav-item active dropdown-btn">About Us
                <div class="nav-item dropdown">
                    <a href="history.php" class="dropdown-item">
                        History
                        <!-- <i class="fa-solid fa-gear"></i> -->
                    </a>
                    <a href="officials.php" class="dropdown-item">
                        Officials
                        <!-- <i class="fa-solid fa-right-from-bracket"></i> -->
                    </a>
                </div>
            </div>
            <li class="nav-item"><a href="announcement.php">Announcement</a></li>
            <li class="nav-item"><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <main>
        <!-- Body -->
        <div class="wrapper">
            <div class="card-container">
                <div class="card">
                    <img src="<?php echo $brgyCaptain['image'] ?>" alt="">
                    <h1 class="card-title"><?php echo $brgyCaptain['name'] ?></h1>
                    <p class="card-body">Barangay Captain</p>
                    <button type="button" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="mt-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        More Info <i class="fa-solid fa-circle-info"></i>
                    </button>
                    <div id="popup-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="popup-modal">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <div class="p-6 text-center">
                                    <img src="<?php echo $brgyCaptain['image'] ?>" alt="" class="mx-auto">
                                    <h1 class="card-title"><?php echo $brgyCaptain['name'] ?></h1>
                                    <p class="card-body ">Barangay Captain</p>
                                    <div class="info p-6 mt-3 border-t border-gray-200 dark:border-gray-600">
                                        <div>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Gender:</span>
                                            <span class="text-sm"><?php echo $brgyCaptain['gender'] ?></span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Birthday:</span>
                                            <span class="text-sm"><?php echo $brgyCaptain['birthday'] ?></span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Civil Status:</span>
                                            <span class="text-sm"><?php echo $brgyCaptain['status'] ?></span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Religion:</span>
                                            <span class="text-sm"><?php echo $brgyCaptain['religion'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-container">
                <div class="card">
                    <img src="<?php echo $brgyTreasurer['image'] ?>" alt="">
                    <h1 class="card-title"><?php echo $brgyTreasurer['name'] ?></h1>
                    <p class="card-body">Barangay Treasurer</p>
                    <button type="button" data-modal-target="treasurer" data-modal-toggle="treasurer" class="mt-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        More Info <i class="fa-solid fa-circle-info"></i>
                    </button>
                    <div id="treasurer" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="treasurer">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <div class="p-6 text-center">
                                    <img src="<?php echo $brgyTreasurer['image'] ?>" alt="" class="mx-auto">
                                    <h1 class="card-title"><?php echo $brgyTreasurer['name'] ?></h1>
                                    <p class="card-body ">Barangay Treasurer</p>
                                    <div class="info p-6 mt-3 border-t border-gray-200 dark:border-gray-600">
                                        <div>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Gender:</span>
                                            <span class="text-sm"><?php echo $brgyTreasurer['gender'] ?></span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Birthday:</span>
                                            <span class="text-sm"><?php echo $brgyTreasurer['birthday'] ?></span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Civil Status:</span>
                                            <span class="text-sm"><?php echo $brgyTreasurer['status'] ?></span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Religion:</span>
                                            <span class="text-sm"><?php echo $brgyTreasurer['religion'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row kagawad">
                <div class="card-container">
                    <div class="card">
                        <img src="<?php echo $comittee_peaceAndOrder['image'] ?>" alt="">
                        <h1 class="card-title"><?php echo $comittee_peaceAndOrder['name'] ?></h1>
                        <p class="card-body">Committee on Peace and Order</p>
                        <button type="button" data-modal-target="peaceAndOrder" data-modal-toggle="peaceAndOrder" class="mt-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            More Info <i class="fa-solid fa-circle-info"></i>
                        </button>
                        <div id="peaceAndOrder" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="peaceAndOrder">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-6 text-center">
                                        <img src="<?php echo $comittee_peaceAndOrder['image'] ?>" alt="" class="mx-auto">
                                        <h1 class="card-title"><?php echo $comittee_peaceAndOrder['name'] ?></h1>
                                        <p class="card-body ">Committee on Peace and Order</p>
                                        <div class="info p-6 mt-3 border-t border-gray-200 dark:border-gray-600">
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Gender:</span>
                                                <span class="text-sm"><?php echo $comittee_peaceAndOrder['gender'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Birthday:</span>
                                                <span class="text-sm"><?php echo $comittee_peaceAndOrder['birthday'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Civil Status:</span>
                                                <span class="text-sm"><?php echo $comittee_peaceAndOrder['status'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Religion:</span>
                                                <span class="text-sm"><?php echo $comittee_peaceAndOrder['religion'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card">
                        <img src="<?php echo $comittee_publicInformation['image'] ?>" alt="">
                        <h1 class="card-title"><?php echo $comittee_publicInformation['name'] ?></h1>
                        <p class="card-body">Committee on Public Information/Environment</p>
                        <button type="button" data-modal-target="publicInformation" data-modal-toggle="publicInformation" class="mt-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            More Info <i class="fa-solid fa-circle-info"></i>
                        </button>
                        <div id="publicInformation" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="publicInformation">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-6 text-center">
                                        <img src="<?php echo $comittee_publicInformation['image'] ?>" alt="" class="mx-auto">
                                        <h1 class="card-title"><?php echo $comittee_publicInformation['name'] ?></h1>
                                        <p class="card-body ">Committee on Public Information/Environment</p>
                                        <div class="info p-6 mt-3 border-t border-gray-200 dark:border-gray-600">
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Gender:</span>
                                                <span class="text-sm"><?php echo $comittee_publicInformation['gender'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Birthday:</span>
                                                <span class="text-sm"><?php echo $comittee_publicInformation['birthday'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Civil Status:</span>
                                                <span class="text-sm"><?php echo $comittee_publicInformation['status'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Religion:</span>
                                                <span class="text-sm"><?php echo $comittee_publicInformation['religion'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card">
                        <img src="<?php echo $comittee_agricultural['image'] ?>" alt="">
                        <h1 class="card-title"><?php echo $comittee_agricultural['name'] ?></h1>
                        <p class="card-body">Committee on Agricultural</p>
                        <button type="button" data-modal-target="agricultural" data-modal-toggle="agricultural" class="mt-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            More Info <i class="fa-solid fa-circle-info"></i>
                        </button>
                        <div id="agricultural" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="agricultural">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-6 text-center">
                                        <img src="<?php echo $comittee_agricultural['image'] ?>" alt="" class="mx-auto">
                                        <h1 class="card-title"><?php echo $comittee_agricultural['name'] ?></h1>
                                        <p class="card-body ">Committee on Agricultural</p>
                                        <div class="info p-6 mt-3 border-t border-gray-200 dark:border-gray-600">
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Gender:</span>
                                                <span class="text-sm"><?php echo $comittee_agricultural['gender'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Birthday:</span>
                                                <span class="text-sm"><?php echo $comittee_agricultural['birthday'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Civil Status:</span>
                                                <span class="text-sm"><?php echo $comittee_agricultural['status'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Religion:</span>
                                                <span class="text-sm"><?php echo $comittee_agricultural['religion'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card">
                        <img src="<?php echo $comittee_healthAndSports['image'] ?>" alt="">
                        <h1 class="card-title"><?php echo $comittee_healthAndSports['name'] ?></h1>
                        <p class="card-body">Committee on Health and Sports</p>
                        <button type="button" data-modal-target="healthAndSports" data-modal-toggle="healthAndSports" class="mt-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            More Info <i class="fa-solid fa-circle-info"></i>
                        </button>
                        <div id="healthAndSports" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="healthAndSports">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-6 text-center">
                                        <img src="<?php echo $comittee_healthAndSports['image'] ?>" alt="" class="mx-auto">
                                        <h1 class="card-title"><?php echo $comittee_healthAndSports['name'] ?></h1>
                                        <p class="card-body ">Committee on Health and Sports</p>
                                        <div class="info p-6 mt-3 border-t border-gray-200 dark:border-gray-600">
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Gender:</span>
                                                <span class="text-sm"><?php echo $comittee_healthAndSports['gender'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Birthday:</span>
                                                <span class="text-sm"><?php echo $comittee_healthAndSports['birthday'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Civil Status:</span>
                                                <span class="text-sm"><?php echo $comittee_healthAndSports['status'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Religion:</span>
                                                <span class="text-sm"><?php echo $comittee_healthAndSports['religion'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card">
                        <img src="<?php echo $comittee_education['image'] ?>" alt="">
                        <h1 class="card-title"><?php echo $comittee_education['name'] ?></h1>
                        <p class="card-body">Committee on Education</p>
                        <button type="button" data-modal-target="education" data-modal-toggle="education" class="mt-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            More Info <i class="fa-solid fa-circle-info"></i>
                        </button>
                        <div id="education" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="education">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-6 text-center">
                                        <img src="<?php echo $comittee_education['image'] ?>" alt="" class="mx-auto">
                                        <h1 class="card-title"><?php echo $comittee_education['name'] ?></h1>
                                        <p class="card-body ">Committee on Education</p>
                                        <div class="info p-6 mt-3 border-t border-gray-200 dark:border-gray-600">
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Gender:</span>
                                                <span class="text-sm"><?php echo $comittee_education['gender'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Birthday:</span>
                                                <span class="text-sm"><?php echo $comittee_education['birthday'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Civil Status:</span>
                                                <span class="text-sm"><?php echo $comittee_education['status'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Religion:</span>
                                                <span class="text-sm"><?php echo $comittee_education['religion'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card">
                        <img src="<?php echo $comittee_budgetAndAppropriation['image'] ?>" alt="">
                        <h1 class="card-title"><?php echo $comittee_budgetAndAppropriation['name'] ?></h1>
                        <p class="card-body">Committee on Budget and Appropriation</p>
                        <button type="button" data-modal-target="budgetAndAppropriation" data-modal-toggle="budgetAndAppropriation" class="mt-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            More Info <i class="fa-solid fa-circle-info"></i>
                        </button>
                        <div id="budgetAndAppropriation" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="budgetAndAppropriation">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-6 text-center">
                                        <img src="<?php echo $comittee_budgetAndAppropriation['image'] ?>" alt="" class="mx-auto">
                                        <h1 class="card-title"><?php echo $comittee_budgetAndAppropriation['name'] ?></h1>
                                        <p class="card-body ">Committee on Budget and Appropriation</p>
                                        <div class="info p-6 mt-3 border-t border-gray-200 dark:border-gray-600">
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Gender:</span>
                                                <span class="text-sm"><?php echo $comittee_budgetAndAppropriation['gender'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Birthday:</span>
                                                <span class="text-sm"><?php echo $comittee_budgetAndAppropriation['birthday'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Civil Status:</span>
                                                <span class="text-sm"><?php echo $comittee_budgetAndAppropriation['status'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Religion:</span>
                                                <span class="text-sm"><?php echo $comittee_budgetAndAppropriation['religion'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card">
                        <img src="<?php echo $comittee_infrastracture['image'] ?>" alt="">
                        <h1 class="card-title"><?php echo $comittee_infrastracture['name'] ?></h1>
                        <p class="card-body">Committee on Infrastructure</p>
                        <button type="button" data-modal-target="infrastracture" data-modal-toggle="infrastracture" class="mt-2 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            More Info <i class="fa-solid fa-circle-info"></i>
                        </button>
                        <div id="infrastracture" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="infrastracture">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-6 text-center">
                                        <img src="<?php echo $comittee_infrastracture['image'] ?>" alt="" class="mx-auto">
                                        <h1 class="card-title"><?php echo $comittee_infrastracture['name'] ?></h1>
                                        <p class="card-body ">Committee on Infrastructure</p>
                                        <div class="info p-6 mt-3 border-t border-gray-200 dark:border-gray-600">
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Gender:</span>
                                                <span class="text-sm"><?php echo $comittee_infrastracture['gender'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Birthday:</span>
                                                <span class="text-sm"><?php echo $comittee_infrastracture['birthday'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Civil Status:</span>
                                                <span class="text-sm"><?php echo $comittee_infrastracture['status'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Religion:</span>
                                                <span class="text-sm"><?php echo $comittee_infrastracture['religion'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="gwt-standard-footer"></div>
    <script type="text/javascript">
        (function(d, s, id) {
            var js, gjs = d.getElementById('gwt-standard-footer');

            js = d.createElement(s);
            js.id = id;
            js.src = "//gwhs.i.gov.ph/gwt-footer/footer.js";
            gjs.parentNode.insertBefore(js, gjs);
        }(document, 'script', 'gwt-footer-jsdk'));
    </script>


    <script src="./assets/js/dropdown.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>

</html>