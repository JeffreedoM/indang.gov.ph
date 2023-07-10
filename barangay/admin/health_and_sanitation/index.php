<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
include 'assets/includes/add-medicine.php';

$record = $pdo->query("SELECT * FROM medicine_inventory")->fetchAll();

$isAvailable = "Available";
$notAvailable = "Out of Stock";
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
    <!-- table css and js-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- main css ref -->
    <link rel="stylesheet" href="assets/css/health.css"/>
    <!-- jquery for calendar --> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
                <h3 class="page-title">Health and Sanitation</h3>
                <p>Medicine Inventory</p>
            </div>

            <!-- Page body -->
            <div class="page-body body">
            <!-- header -->
                <!-- <div class="tab-header">
                    <div class="tabs" style="background-color: #ccc;">Medicine Inventory</div>
                    <a href="medicine-distribution.php">
                        <div class="tabs">Medicine Distribution</div>
                    </a>
                    <a href="vaccination.php">
                        <div class="tabs">Vaccination</div>
                    </a>
                    <a href="newborn.php">
                        <div class="tabs">Newborn</div>
                    </a>
                    <a href="pregnant.php">
                        <div class="tabs">Pregnant</div>
                    </a>
                    <a href="death.php">
                    <div class="tabs" style="border-right: none;">Death</div>
                    </a>
                </div>              -->
            </div>

            <div class="page-body">
            <!-- insert record -->
                <div style="margin-bottom: 1.5rem;">
                    <button class="recordbtn" onclick="openPopup()">Insert Record</button>
                </div>
                <!-- table -->
                <div>
                    <table id="vaccine" class="row-border hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Availability</th>
                                <th>Stock</th>
                                <th>Expiration Date</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- inserting values from database to table through foreach statement -->
                            <?php foreach($record as $row) { ?>
                                <tr>
                                    <?php if($row['medicine_availability'] === $notAvailable) { ?>
                                    <td style="color: gray;"><?php echo $row['ID']?></td>
                                    <td style="color: gray;"><?php echo $row['medicine_name']?></td>
                                    <td style="color: gray;"><?php echo $row['medicine_availability']?></td>
                                    <td style="color: gray;"><?php echo $row['medicine_quantity']?></td>
                                    <td style="color: gray;"><?php echo $row['medicine_expiration']?></td>
                                    <td style="color: gray;"><?php echo $row['medicine_description']?></td>
                                    <?php }else{ ?>
                                    <td><?php echo $row['ID']?></td>
                                    <td><?php echo $row['medicine_name']?></td>
                                    <td style="color: green;"><?php echo $row['medicine_availability']?></td>
                                    <td><?php echo $row['medicine_quantity']?></td>
                                    <td><?php echo $row['medicine_expiration']?></td>
                                    <td><?php echo $row['medicine_description']?></td>
                                       <?php }?>
                                    
                                   
                                    <!-- action button row -->
                                    <td>
                                        <div>
                                            <button>Edit</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
    <!-- end of wrapper -->                            
        </div>
        <!-- insert record modal -->
        <div class="modal" id="modal">
        <div class="header">
            <p class="header-text">Insert record</p>
            <button class="closebtn" onclick="closePopup()">X</button>
            <div class="content" id="popup">        
                <form action="" method="POST" class="form-content">
                    <div class="field">
                        <p style="margin-bottom: 0.5rem;">Name of Medicine: </p>
                        <input type="text" name="medicine_name" value="" required>
                    </div>
                    <div class="field">
                        <p style="margin-bottom: 0.5rem;">Quantity<span style="color: darkgray;">(pcs)</span>: </p>
                        <input type="number" name="medicine_quantity" value="" required>
                    </div>
                    <div class="field">
                        <p style="margin-bottom: 0.5rem;">Expiration Date: </p>
                        <input type="date" id="exp_date" name="expiration_date" placeholder="mm/dd/yyyy" required>
                    </div>
                    <div class="field">
                        <p style="margin-bottom: 0.5rem;">Description: </p>
                        <textarea name="medicine_description" rows="2" cols="18" maxlength="500" style="width: 100%;"></textarea>
                    </div>
                    <button type="submit" class="submitRecord" name="submitRecord">Submit</button>
                </form>
            </div>
        </div>
        </div>
    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <!-- script for table -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#vaccine').DataTable();
    });
    </script>
    <!-- script for calendar -->
        <script>
            $(function(){
                $("#expiration_date").datepicker();
            }); 
        </script>

    <!-- popup js -->
            
            <script>
                let modal = document.getElementById('modal');

                    function openPopup() {
                        modal.classList.add("modal-active");
                    }
                    function closePopup() {
                        modal.classList.remove("modal-active");
                    }
            </script>

    <!-- end of table script -->
</body>

</html>