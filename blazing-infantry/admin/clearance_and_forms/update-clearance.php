<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';

$conn = new mysqli('localhost', 'root', '', 'bmis');
if ($conn->connect_error){
    die('Connection Failed' .$conn->connect_error);
}else{
    $id = $_GET['id'];
    $sql = mysqli_query($conn, "SELECT * FROM clearance WHERE clearance_id=$id");
    $user = mysqli_fetch_assoc($sql);

    $value = $user['clearance_name'];
    $price = $user['clearance_amount'];

}
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
    <link rel="stylesheet" href="./assets/css/buttons.css" type="text/css" />

    <title>Admin Panel | Update Clearance</title>
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
                <h3 class="page-title">Update <?php echo $value; ?></h3>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <div>
                    <form action="" method="POST">
                        <div>
                        <label for=""><p><b>Clearance name: </b></p></label>
                        <input type="text" name="clearancename" value="<?php  echo $value; ?>" placeholder="<?php  echo $value; ?>">
                        </div>
                        <div style="margin-top: 1rem;">
                        <label for=""><p><b>Clearance Price: </b></p></label>
                        <input type="number" name="clearanceprice" value="<?php  echo $price; ?>" placeholder="Current price is: <?php  echo $price; ?>">
                        </div>
                        <button type="submit" name="update" class="submitButton">Update Clearance</button>
                    </form>
                </div>
            </div>

    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>

</body>

</html>

<?php
        if (isset($_POST['update'])) {
            $clearancename = mysqli_real_escape_string($conn, $_POST['clearancename']);
            $clearanceprice = mysqli_real_escape_string($conn, $_POST['clearanceprice']);

            $sql = "UPDATE new_clearance SET clearance_name= '$clearancename', clearance_amount = '$clearanceprice' WHERE clearance_id='$id'";

            if (mysqli_query($conn, $sql)) {     
                echo "<script>window.location.href='index.php';</script>"; 
                exit();
            } else {
                echo "Error updating!" . mysqli_error($conn);
            }
        }
    ?>