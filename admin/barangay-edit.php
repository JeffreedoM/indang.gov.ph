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