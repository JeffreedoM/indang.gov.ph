<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';


$sql = "SELECT * 
        FROM hns_newborn_history nh 
        JOIN resident r ON nh.resident_id = r.resident_id 
        WHERE r.barangay_id = :barangayId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':barangayId', $barangayId);
$stmt->execute();
$newborn_history = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Pregnant</title>
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
        <div class="wrapper ">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header" style="margin: 0 !important;">
                <h3 class="page-title ml-3 mb-1">Health and Sanitation</h3>
                <p class="mb-4 ml-3">Pregnant</p>

                <!-- page tabs -->
                <div class="border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center dark:text-gray-400">
                        <li class="mr-2">
                            <a href="newborn.php" class="inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Newborn
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="#" class="cursor-pointer inline-flex p-4 bg-white rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group">
                                Newborn History
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <table id="pregnancy-history" class="row-border hover">
                    <thead>
                        <tr>
                            <th>Resident ID</th>
                            <th>Name</th>
                            <th>Sex</th>
                            <th>Birthdate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($newborn_history as $newborn) : ?>
                            <tr>
                                <td><?php echo $newborn['resident_id'] ?></td>
                                <td><?php echo $newborn['firstname'] . ' ' . $newborn['middlename'] . ' ' . $newborn['lastname'] ?></td>
                                <td><?php echo $newborn['sex'] ?></td>
                                <td><?php echo date("F d, Y", strtotime($newborn['birthdate'])) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pregnancy-history').DataTable();
        });
    </script>
</body>

</html>