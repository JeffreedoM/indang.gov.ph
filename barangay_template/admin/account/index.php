<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';

// Define the SQL query to join the tables
$stmt = $pdo->prepare("SELECT * FROM resident 
                    INNER JOIN officials ON resident.resident_id = officials.resident_id
                    WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
// Execute the SQL statement
$stmt->execute();
// Fetch the results as an associative array
$results = $stmt->fetchAll();


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

    <title>Admin Panel</title>
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
                <h3 class="page-title">Account</h3>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <table id="officials-table" class="row-border hover">
                    <thead>
                        <tr>
                            <th>Resident ID</th>
                            <th>Full Name</th>
                            <th>Position</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $resident) { ?>
                            <tr>
                                <td><?php echo $resident['resident_id'] ?></td>
                                <?php $resident_fullname = "$resident[firstname] $resident[middlename] $resident[lastname]";
                                ?>
                                <td><?php echo $resident_fullname ?></td>
                                <td><?php echo $resident['position'] ?></td>
                                <?php
                                //checking if official already has an account
                                $stmt = $pdo->prepare("SELECT COUNT(*) FROM accounts WHERE official_id = :official_id");
                                $stmt->bindParam(':official_id', $resident['official_id']);
                                $stmt->execute();

                                $count = $stmt->fetchColumn();

                                if ($count > 0) {
                                ?>
                                    <td></td>
                                <?php
                                } else {
                                ?>
                                    <td>
                                        <!-- Modal toggle -->
                                        <button data-modal-target="<?php echo $resident['resident_id'] ?>" data-modal-toggle="<?php echo $resident['resident_id'] ?>" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                            Create
                                        </button>

                                        <!-- Main Modal  -->
                                        <div id="<?php echo $resident['resident_id'] ?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative w-full max-w-md max-h-full">
                                                <!-- Modal content -->
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="<?php echo $resident['resident_id'] ?>">
                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                    <div class="px-6 py-6 lg:px-8">
                                                        <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-white">Create account for <?php echo $resident_fullname ?></h3>
                                                        <form class="space-y-4" action="includes/add-account.inc.php" method="POST" id="add-account-form">
                                                            <div>
                                                                <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                                                                <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Username" required>
                                                            </div>
                                                            <div>
                                                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                                                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                                            </div>
                                                            <div>
                                                                <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                                                                <input type="password" id="confirm-password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                                            </div>
                                                            <div id="error-message" class="hidden">
                                                                <p class="text-red-700">Passwords do not match!</p>
                                                            </div>
                                                            <input type="hidden" name="official_id" value="<?php echo $resident['official_id'] ?>">
                                                            <button type="submit" name="add_account" id="add_account-button" class="mt-10 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create Account</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                <?php
                                }
                                ?>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#officials-table').DataTable();
        });

        /* confirm password */
        let button = document.getElementById('add_account-button')
        let errorMessage = document.getElementById('error-message')

        button.addEventListener('click', function(e) {
            let pass1 = document.getElementById('password').value
            let pass2 = document.getElementById('confirm-password').value

            if (pass1 !== pass2) {
                e.preventDefault();
                errorMessage.style.display = 'block';

                // hide the error message after 3 seconds
                setTimeout(function() {
                    errorMessage.style.display = 'none'
                }, 3000)
            }
        })
    </script>
</body>

</html>