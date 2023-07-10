<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';

//Getting residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);


$record = $pdo->query("SELECT * FROM vaccine_inventory WHERE vaccineBrgyID = '$barangayId'")->fetchAll();
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
    <!-- Specific spage styling -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Popup -->
    <link rel="stylesheet" href="./assets/css/popup.css">
    <!-- table css and js-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- main css ref -->
    <link rel="stylesheet" href="assets/css/health_vaccine.css"/>
    <!-- jquery for calendar --> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <title>Admin Panel | Vaccination Inventory</title>
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
        <div class="wrapper officials">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title">Health and Sanitation</h3>
                <p>Vaccination Inventory</p>
            </div>

            <!-- Page body -->
            <div class="page-body body">
            </div>

            <!-- Page body -->
            <div class="page-body">
                <!-- insert record -->
                <div style="margin-bottom: 1.5rem;">
                    <a href="vaccination.php"><button class="recordbtn" >Back</button></a>
                    <button class="recordbtn" onclick="openInsertPopup()">Insert Record</button>
                    
                </div>

                <!-- table -->
                <div>
                    <table id="vaccine" class="row-border hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Vaccine Name</th>
                                <th>Vaccine Status</th>
                                <th>Vaccine Quantity</th>
                                <th>Vaccine Expiration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- inserting values from database to table through foreach statement -->
                            <?php foreach($record as $row) { 
                                    $color_status = $row['vaccineStatus'];
                                    $color_style = '';
                                    
                                    if ($color_status == 'Available') {
                                        $color_style = 'color: green;';
                                    }else {
                                        $color_style = 'color: red;';
                                    }
                                ?>
                                <tr>
                                
                                    <td><?php echo $row['vaccineInventoryID']?></td>
                                    <td><?php echo $row['vaccineName']?></td>
                                    <td style="<?php echo $color_style;?>"><?php echo $row['vaccineStatus']?></td>
                                    <td><?php echo $row['vaccineQuantity']?></td>
                                    <td><?php echo $row['vaccineExpDate']?></td>
                                    
                                   
                                    <!-- action button row -->
                                    <td>
                                        <button><a href="./assets/includes/add_view/add_view-inventory.php?id=<?php echo $row['vaccineInventoryID']?>&action=view">View</a></button>
                                        <button><a href="./assets/includes/add_view/add_view-inventory.php?id=<?php echo $row['vaccineInventoryID'] ?>&action=edit">Edit</a></button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Add Officials -->
                <div class="modal-bg" onclick="closePopup()" id="modal-background">
                </div>

                <div class="popup" id="modal-container">
                    <h1>List of Residents</h1>

                    <table id="residents" class="row-border hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resident as $resident) { ?>
                                <tr id="<?php echo $resident['resident_id'] ?>" style="cursor:pointer">
                                    <td><?php echo $resident['resident_id'] ?></td>
                                    <td><?php
                                        $resident_fullname = "$resident[firstname] $resident[middlename] $resident[lastname]";
                                        echo $resident_fullname ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>


                    <!-- close popup button -->
                    <span class="close-popup" onclick="closePopup()">
                        <i class="fa-solid fa-x"></i>
                    </span>
                </div>
            </div>
            
            <!-- insert record modal -->
                <div class="modal" id="modal_vaccine">
                <div class="header">
                    <p class="header-text-vacc"><b>Insert Vaccination record</b></p>
                    <button class="closebtn" onclick="closeInsertPopup()">X</button>
                    
                    
                    <!-- Form for adding officials -->
                    <form action="./assets/includes/query.php" method="POST" class="add-officials-form" onsubmit="return validateForm()">
                        <!-- resident name -->
                        <div>
                            <input type="hidden" name="id_resident" id="resident_id">
                            <input type="hidden" name="brgy_id" value="<?php echo $barangayId?>">
                        </div>
                        <div>
                            <label for="position" class="block font-medium text-gray-900 dark:text-white">Vaccine Name:</label>
                            <input type="text" name="vaccineName" placeholder="Input Vaccine Name">
                        </div>
                        <div>
                            <label for="position" class="block font-medium text-gray-900 dark:text-white">Vaccine Status</label>
                            <select name="vaccineStatus" id="">
                                <option selected disabled> Choose Vaccine Status</option>
                                <option value="Available"> Available</option>
                                <option value="Out of Stock"> Out of Stock</option>
                            </select>
                        </div>
                        <div>
                            <label for="position" class="block font-medium text-gray-900 dark:text-white">Quantity:</label>
                            <input type="number" name="vaccineQuantity" placeholder="Input Vaccine Quatity(pcs)">
                        </div>
                        <div>
                            <label for="position" class="block font-medium text-gray-900 dark:text-white">Expiration Date:</label>
                            <input type="date" name="vaccineExpDate">
                        </div>
                        <div>
                            <label for="position" class="block font-medium text-gray-900 dark:text-white">Description:</label>
                            <textarea name="vaccineDescrip" id="" cols="52" rows="2" placeholder="Input Vaccine Description"></textarea>
                        </div>
                        
                        <button onclick="return  confirm('Do you want to add this record?')" type="submit" name="submit_add_inventory-vaccine" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
                    </form>

                </div>
                </div>

    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="./assets/js/popup.js"></script>
    <script src="./assets//js/select-resident.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#residents').DataTable();
        });

        function validateForm() {
            const input = document.getElementById("resident_name").value;
            if (input == "") {
                alert("Select resident");
                return false;
            }
        }
    </script>

    <script>
        let modal = document.getElementById('modal_vaccine');

            function openInsertPopup() {
                modal.classList.add("modal-active");
            }
            function closeInsertPopup() {
                modal.classList.remove("modal-active");
            }
    </script>

    <script>
        $(document).ready(function() {
            $('#vaccine').DataTable();
        });
    </script>
</body>

</html>