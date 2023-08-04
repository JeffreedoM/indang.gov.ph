<?php
include 'includes/session.inc.php';

$id = $_GET['id'];
$barangay = $pdo->query("SELECT * FROM barangay WHERE b_id='$id'")->fetch();
$barangayName = ucwords($barangay['b_name']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/main.css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Admin Panel</title>
</head>

<style>
    .barangay-logo {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .barangay-logo img {
        border-radius: 50%;
        width: 100px;
        height: 100px;
    }
</style>

<body>
    <?php
    include './partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include './partials/nav_header.php';
        ?>

        <!-- Add Barangay -->
        <div class="wrapper">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title">Edit "<?php echo $barangayName ?>"</h3>

            </div>

            <?php if (isset($_GET['reset']) && $_GET['reset'] == 'success') : ?>
                <div id="alert-border-3" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <div class="ml-3 text-sm font-medium">
                        Password has been reset.
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-3" aria-label="Close">
                        <span class="sr-only">Dismiss</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            <?php endif ?>

            <!-- Page body -->
            <div class="page-body">
                <form action="includes/update-brgy.inc.php" method="POST" class="add-brgy__form" enctype="multipart/form-data">
                    <div>
                        <label for="">Barangay Name</label>
                        <input type="text" name="brgy-name" value="<?php echo $barangayName ?>">
                        <input type="hidden" name="barangayId" value="<?php echo $id ?>">
                    </div>
                    <div class="barangay-logo">
                        <div>
                            <img src="./assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>" alt="" id="logo-img">
                        </div>
                        <div style="width: 100%;">
                            <label for="">Barangay Logo</label>
                            <input type="file" name="image" id="image-input" accept="image/jpeg, image/png">
                        </div>

                    </div>
                    <div id="address-container">
                        <label for="">Complete Address</label>
                        <div>
                            <input style="width: 100%;" type="text" name="brgy-address" value="<?php echo $barangay['b_address'] ?>">
                            <!-- <div>Indang, Cavite</div> -->
                        </div>

                    </div>

                    <button type="submit" name="submit" onclick="return confirm('Are you sure you want to update this barangay?')">Update <?php echo $barangayName ?></button>
                </form>

                <form action="includes/reset-password.inc.php" method="post">
                    <input type="hidden" name="barangay_id" value="<?php echo $id ?>">
                    <button type="submit" name="reset-password" class="bg-red-500 hover:bg-red-600 text-sm text-white py-3 px-4 mt-10 rounded-md" onclick="return confirm('Are you sure you want to reset the password of this barangay?');">Reset to Default Password</button>
                    <h1 class="mt-3 text-sm">
                        *Clicking this button will reset your password to the default one set at the beginning.</h1>
                </form>
            </div>



    </main>

    <script>
        const logo = document.querySelector('#image-input');
        var uploaded_image = "";

        logo.addEventListener('change', () => {
            const reader = new FileReader();
            const file = document.querySelector('input[type=file]').files[0];
            reader.addEventListener('load', () => {
                uploaded_image = reader.result;
                document.getElementById('logo-img').src = uploaded_image;
            })
            reader.readAsDataURL(file);

        })
    </script>
    <script src="./assets/js/sidebar.js"></script>
    <script src="./assets/js/header.js"></script>
</body>

</html>