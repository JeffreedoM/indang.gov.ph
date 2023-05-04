<?php

include '../../includes/dbh.inc.php';
include '../../includes/session.inc.php';
include '../../includes/deactivated.inc.php';

function getOfficialDetails($position)
{
    global $pdo;
    $official = $pdo->query("SELECT * FROM resident INNER JOIN officials ON resident.resident_id = officials.resident_id WHERE officials.position = '$position'")->fetch();
    if ($official) {
        $imageSrc = $official['image'] ? '../resident/assets/images/uploads/' . $official['image'] : '../../assets/images/uploads/no-profile.png';
        $name = "$official[firstname]  $official[middlename]  $official[lastname]";
        return array('name' => $name, 'image' => $imageSrc);
    } else {
        return array(
            // 'name' => "<a id='no-position' href='add-officials.php'>Set $position</a>",
            'name' => "<a id='no-position' href='add-officials.php'>Set an official <i class='fa-solid fa-arrow-right-long'></i></a>",
            'image' => '../../assets/images/uploads/no-profile.png'
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/main.css" />

    <!-- specific page styling -->
    <link rel="stylesheet" href="./assets/css/main.css" />

    <title>Admin | Officials</title>

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
                <h3 class="page-title">Barangay Officials</h3>
                <!-- page tabs -->
                <div class="border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center dark:text-gray-400">
                        <li class="mr-2">
                            <a href="#" class="inline-flex p-4 bg-white rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group">
                                Organizational Chart
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="officials-table.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Officials
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="add-officials.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Add Official
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <div class="card-container">
                    <div class="card">
                        <img src="<?php echo $brgyCaptain['image'] ?>" alt="">
                        <h1 class="card-title"><?php echo $brgyCaptain['name'] ?></h1>
                        <p class="card-body">Barangay Captain</p>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card">
                        <img src="<?php echo $brgyTreasurer['image'] ?>" alt="">
                        <h1 class="card-title"><?php echo $brgyTreasurer['name'] ?></h1>
                        <p class="card-body">Barangay Treasurer</p>
                    </div>
                </div>
                <div class="row kagawad">
                    <div class="card-container">
                        <div class="card">
                            <img src="<?php echo $comittee_peaceAndOrder['image'] ?>" alt="">
                            <h1 class="card-title"><?php echo $comittee_peaceAndOrder['name'] ?></h1>
                            <p class="card-body">Committee on Peace and Order</p>
                        </div>
                    </div>
                    <div class="card-container">
                        <div class="card">
                            <img src="<?php echo $comittee_publicInformation['image'] ?>" alt="">
                            <h1 class="card-title"><?php echo $comittee_publicInformation['name'] ?></h1>
                            <p class="card-body">Committee on Public Information/Environment</p>
                        </div>
                    </div>
                    <div class="card-container">
                        <div class="card">
                            <img src="<?php echo $comittee_agricultural['image'] ?>" alt="">
                            <h1 class="card-title"><?php echo $comittee_agricultural['name'] ?></h1>
                            <p class="card-body">Committee on Agricultural</p>
                        </div>
                    </div>
                    <div class="card-container">
                        <div class="card">
                            <img src="<?php echo $comittee_healthAndSports['image'] ?>" alt="">
                            <h1 class="card-title"><?php echo $comittee_healthAndSports['name'] ?></h1>
                            <p class="card-body">Committee on Health and Sports</p>
                        </div>
                    </div>
                    <div class="card-container">
                        <div class="card">
                            <img src="<?php echo $comittee_education['image'] ?>" alt="">
                            <h1 class="card-title"><?php echo $comittee_education['name'] ?></h1>
                            <p class="card-body">Committee on Education</p>
                        </div>
                    </div>
                    <div class="card-container">
                        <div class="card">
                            <img src="<?php echo $comittee_budgetAndAppropriation['image'] ?>" alt="">
                            <h1 class="card-title"><?php echo $comittee_budgetAndAppropriation['name'] ?></h1>
                            <p class="card-body">Committee on Budget and Appropriation</p>
                        </div>
                    </div>
                    <div class="card-container">
                        <div class="card">
                            <img src="<?php echo $comittee_infrastracture['image'] ?>" alt="">
                            <h1 class="card-title"><?php echo $comittee_infrastracture['name'] ?></h1>
                            <p class="card-body">Committee on Infrastructure</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>