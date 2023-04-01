<?php
include 'includes/session.inc.php';

$barangay = $pdo->query("SELECT * FROM barangay")->fetchAll();
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="./assets/css/main.css" />
    <link rel="stylesheet" href="./assets/css/bs-overwrite.css" />

    <title>Admin Panel</title>

    <style>
        #brgy-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        #action {
            vertical-align: middle;
        }

        #action button {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <?php
    include './partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include './partials/nav_header.php';
        ?>

        <!-- List of Barangays -->
        <div class="wrapper">
            <?php
            if (isset($_GET['message'])) {
            ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_GET['message'] ?>
                </div>
            <?php
            } ?>
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title">List of Barangays</h3>
            </div>

            <!-- Page body -->
            <!-- List of Barangays -->
            <div class="page-body" style="overflow-x:auto; min-height: 60vh;">
                <table id="barangay-table" class="row-border hover">
                    <thead>
                        <tr>
                            <th>Barangay ID</th>
                            <th>Barangay Logo</th>
                            <th>Barangay Name</th>
                            <th>Barangay Link</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($barangay as $barangay) { ?>
                            <tr>
                                <td><?php echo $barangay['b_id'] ?></td>
                                <td>
                                    <img src="./assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>" alt="barangay logo of <?php echo $barangay['b_name'] ?>" id="brgy-logo">
                                </td>
                                <td style="text-transform: capitalize;"><?php echo $barangay['b_name'] ?></td>
                                <?php
                                $brgyName = $barangay['b_name'];
                                ?>
                                <td><?php echo $barangay['b_link'] ?></td>
                                <td><?php
                                    if ($barangay['is_active']) {
                                        echo "Active";
                                    } else {
                                        echo "Deactivated";
                                    }
                                    ?></td>
                                <td id="action">

                                    <button id="dropdownDividerButton" data-dropdown-toggle="<?php echo $brgyName ?>" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Action <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg></button>

                                    <!-- Dropdown menu -->
                                    <div id="<?php echo $brgyName ?>" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton">
                                            <li>
                                                <a href="./barangay-edit.php?id=<?php echo $barangay['b_id'] ?>" class="block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                            <li>
                                                <a href="./barangay-print.php?id=<?php echo $barangay['b_id'] ?>" class="block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Print</a>
                                            </li>
                                            <li>
                                                <!-- <a href="./includes/delete-brgy.inc.php?id=$barangay[b_id] ?>" onclick="return confirm('Are you sure you want to deactivate $barangay[b_name]?')">Deactivate</a> -->
                                                <?php
                                                if ($barangay['is_active']) {
                                                    echo "
                                                    <a href=\"./includes/delete-brgy.inc.php?id=$barangay[b_id]\" onclick=\"return confirm('Are you sure you want to deactivate $barangay[b_name]?')\" class=\"block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600
                                                    dark:hover:text-white\">Deactivate</a>
                                            ";
                                                } else {
                                                    echo "
                                                    <a href=\"./includes/activate-brgy.inc.php?id=$barangay[b_id]\" onclick=\"return confirm('Are you sure you want to activate $barangay[b_name]?')\" class=\"block font-bold px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600
                                                    dark:hover:text-white\">Activate</a>
                                            ";
                                                }
                                                ?>
                                            </li>

                                        </ul>
                                        <div class="py-2">
                                            <a href="../../<?php echo $barangay['b_link'] ?>" target="_blank" class="font-bold block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Visit
                                                link</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>


    <script src="./assets/js/sidebar.js"></script>
    <script src="./assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#barangay-table').DataTable();
        });
        // $(document).ready(function() {
        //     $('#deact-barangay-table').DataTable();
        // });


        $(document).ready(function() {
            $('#staticBackdrop').modal('show');
        });

        $(".alert").show();
        setTimeout(function() {
            $(".alert").hide();
        }, 5000);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>

</body>

</html>