<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
include 'assets/includes/medicine-distrib.php';

// select from current id 

$query = "SELECT resident_id, CONCAT(firstname, ' ', middlename, ' ', lastname) AS full_name FROM resident WHERE barangay_id = :barangay_id";
// Prepare and execute the SQL statement
$stmt = $pdo->prepare($query);
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
// Retrieve the results
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);
//record retrieving 
$record = $pdo->query("SELECT * FROM medicine_distribution")->fetchAll();
$medicine = $pdo->query("SELECT * FROM medicine_inventory")->fetchAll();

// query for joining three tables 'medicine_distribution','medicine_inventory', and 'resident'

$joint = $pdo->query("SELECT * FROM medicine_distribution md
                    JOIN medicine_inventory mi ON md.medicine_id = mi.ID
                    JOIN resident r ON md.resident_id = r.resident_id")->fetchAll();



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
            </div>

            <!-- Page body -->
            <div class="page-body body">
            <!-- header -->
                <div class="tab-header">
                    <a href="index.php">
                        <div class="tabs">Medicine Inventory</div>
                    </a>
                    <a href="medicine-distribution.php">
                        <div class="tabs" style="background-color: #ccc;">Medicine Distribution</div>
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
                </div>             
            </div>
            <div class="page-body">
            <!-- insert record -->
                <div style="margin-bottom: 1.5rem;">
                    <button class="recordbtn" onclick="openPopup()">Insert Record</button>
                </div>
                <!-- table -->
                <div>
                    <table id="inventory" class="row-border hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Medicine Name</th>
                                <th>Quantity</th>
                                <th>Given to</th>
                                <th>Date Given</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- inserting values from database to table through foreach statement -->
                            <tr>
                                <?php foreach($joint as $row) { ?>
                                    <td><?php echo $row['distrib_id']?></td>
                                    <td><?php echo $row['medicine_name']?></td>
                                    <td><?php echo $row['distrib_quantity']?></td>
                                    <td><?php echo $row['firstname']; echo ' ' . $row['middlename']; echo ' ' .$row['lastname']?></td>
                                    <td><?php echo $row['distrib_date']?></td>
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
            <p class="header-text">Medicine Distribution</p>
            <button class="closebtn" onclick="closePopup()">X</button>
            <div class="content2">
                <form action="" method="POST" class="form-content">
                    <div class="field2">
                        <p>Medicine: </p>
                        <select name="medicine_name" value="" placeholder="" required>
                            <option style="color: gray;">Name | Exp Date | Stock</option>
                            <?php foreach ($medicine as $medicine) { 
                                if($medicine['medicine_quantity'] == 0) {
                                    continue; // Skip to next iteration if medicine_quantity is zero
                                }
                            ?>
                                <option value=<?php echo$medicine['ID']?> class="medicine-option">
                                    <?php echo$medicine['medicine_name']?> [<?php echo $medicine['medicine_expiration']?>]
                                    <span>Stock:</span><?php echo $medicine['medicine_quantity']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="field2">
                        <p>Quantity<span style="color: darkgray;">(pcs)</span>: </p>
                        <input type="number" name="medicine_quantity" value="" required>                       
                    </div>
                    <div class="field2">
                        <p>Recepient: </p>
                        <select name="resident_name"required>
                            <option style="color: gray;">Name of Resident</option>
                        <?php foreach ($resident as $resident) { ?>
                            <option value=<?php echo$resident['resident_id']?> class="resident-option">
                                <?php echo$resident['full_name']?>
                            </option>

                        <?php } ?>
                        </select>
                    </div>
                    <div class="field2">
                        <p>Date Given: </p>
                        <input type="date" id="date-given" name="date" placeholder="mm/dd/yyyy" required>
                    </div>
                    <button type="submit" name="submitRecord" class="submitRecord" style="margin-top: 0.5rem;">Submit</button>
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
        $('#inventory').DataTable();
    });
    </script>
     <!-- script for calendar -->
     <script>
            $(function(){
                $("#date").datepicker();
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