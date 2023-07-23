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
    <style>
       h2 {
        color: red;
       }
    </style>
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
                <h3 class="page-title">Delete Clearance</h3>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <div>
                    <h2><b><span>Are you sure you want to delete <?php echo $value;?> ?</span></b></h2>
                </div>
                <div class="delete-option">
                    <form  method="POST">
                        <input type="hidden" name="clearancename" value="<?php echo $id;?>">
                        <button type="submit" name="delete" class="deleteButton">
                            Yes
                        </button>
                    </form>
                       
                    <button class="deleteButton">
                        <a href="index.php">No</a></button>
                </div>
            </div>
        </div>

    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>

</body>

</html>

<?php
        if (isset($_POST['delete'])) {      
            $sql = "DELETE FROM clearance WHERE clearance_id='$id'";

            if (mysqli_query($conn, $sql)) {     
                echo "<script>window.location.href='index.php';</script>"; 
                exit();
            } else {
                echo "Error updating!" . mysqli_error($conn);
            }
        }
    ?>