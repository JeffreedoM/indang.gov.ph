<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
include './includes/connect.php';

//Getting residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);

$finance = $pdo->query("SELECT * FROM resident JOIN new_clearance ON resident.resident_id = new_clearance.resident_id;")->fetchAll();

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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="./assets/css/buttons.css" type="text/css" />
    <link rel="stylesheet" href="./assets/css/add_finance.css" type="text/css" />
    <link rel="stylesheet" href="./assets/css/popup2.css" type="text/css" />
    <link rel="stylesheet" href="./assets/css/styles2.css" type="text/css" />
    
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
                <h3 class="page-title">Clearance and Forms</h3>
            </div>

            <!-- Page body -->
            <div class="page-body" style="overflow-x:auto; min-height: 60vh;">
                

                <div class="add_clearance">
                    <button onclick="openInsertPopup()" class="add_transaction"><span>Add Transaction</span></button>
                    <a href="clearance-transactions.php">
                        <button type="submit" class="btn"><span>Form Transaction History</span></button>
                    </a>
                </div>

                <!-- List of clearances -->
                <div>
                    <table id="clearance-list" class="row-border hover">
                        <thead>
                            <tr>
                                <th>Form Type</th>
                                <th>Given To</th>
                                <th>Amount</th>
                                <th>Date Given</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Code to change color based on status -->
                            <?php foreach($finance as $row) { 
                                $color_status = $row['status'];
                                $color_style = '';
                                
                                if ($color_status == 'Pending') {
                                    $color_style = 'color: blue;';
                                } elseif ($color_status == 'Paid') {
                                    $color_style = 'color: green;';
                                } else {
                                    $color_style = 'color: red;';
                                }
                            ?>
                            <tr>
                                   
                                    <td><?php echo $row['form_request']?></td>
                                    <td><?php echo $row['firstname']; echo ' ' . $row['middlename']; echo ' ' .$row['lastname']?></td>
                                    <td><?php echo "₱" . $row['amount'];?></td>
                                    <td><?php echo $row['date_string']?></td>
                                    <td><span style="<?php echo $color_style ?>"> <?php echo $color_status?></span></td>
                                    <td>
                                        <button><a href="includes/add_view/add_view.php?finance_id=<?php echo $row['finance_id'] ?>&action=view&resident_id=<?php echo $row['resident_id']?>">View</a></button>
                                        <button><a href="includes/add_view/add_view.php?finance_id=<?php echo $row['finance_id'] ?>&action=edit&resident_id=<?php echo $row['resident_id']?>">Edit</a></button>
                                    </td>
                            </tr>
                                    <?php } ?>
                        </tbody>
                    </table>
                </div>
                
            </div>

            <!-- Add clearance pop-up -->
            <div class="add-clearance" id="modal" >
                
                <div class="content" id="popup">
                <button class="closebtn"onclick="closePopup()">X</button>
                    <h1 style="margin-bottom: 1rem;">Clearance Name/Type:</h1>
                    <form action="" method="POST" required>
                        <!-- input clearance name/type -->
                        <div>
                            <p></p>
                            <input type="text" name="clearancename" id="clearancename" placeholder="" required>
                        </div>
                        
                        <button type="submit" name="submit" id="submitButton" class="submitButton" >Add Clearance</button>
                    </form>
                </div>
            </div>
            
    </main>
    

    <!-- Add Officials -->
    <div class="modal-bg2" onclick="closePopup()" id="modal-background">
        </div>

        <div class="popup2" id="modal-container">
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

    <!-- insert record modal -->
    <div class="modal2" id="modal_vaccine">
        <div class="header">
            <p class="header-text-vacc"><b>Insert Record</b></p>
            <button class="closebtn2" onclick="closeInsertPopup()">X</button>
            
            <button class="add-resident__button" onclick="openPopup2()">
                <label for="position" class="block font-medium text-red-500 dark:text-white">Select resident <i class="fa-solid fa-caret-down ml-1"></i></label>
            </button>

            <!-- Form for adding officials -->
            <form action="./includes/query.php" method="POST" class="add-officials-form" onsubmit="return validateForm()">
                <!-- resident name -->
                <div>
                    <input type="text" name="finance_fname" id="resident_name" placeholder="Select resident above" readonly aria-label="disabled input 2" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <input type="hidden" name="id_resident" id="resident_id">
                </div>

                <!-- <div>
                    <label for="death_date" class="block font-medium text-gray-900 dark:text-white">Form Request Type</label>
                    <input type="date" name="death_date" placeholder="Date of Death">
                </div> -->

                <div class="wrap-position">
                    <div class="wrap-position-sub">
                        <label for="position" class="block font-medium text-gray-900 dark:text-white">Form Request Type</label>
                        <select name="form_request" id="">
                            <option selected value="" disabled> Choose Form Type</option>
                            <option value="Barangay Business Clearance"> Barangay Business Clearance</option>
                            <option value="Barangay Clearance"> Barangay Clearance</option>
                            <option value="Certificate of Clearance"> Certificate of Clearance</option>
                            <option value="Certificate of Good Moral Character"> Certificate of Good Moral Character</option>
                            <option value="Certificate of Indigency"> Certificate of Indigency</option>
                            <option value="Clearance"> Clearance</option>
                        </select>
                    </div>
                    <div class="wrap-position-sub">
                       <label for="position" class="block font-medium text-gray-900 dark:text-white">Others</label>
                        <input type="text" name="form_request_others" placeholder="Others"> 
                    </div>
                </div>
                <div class="wrap-position">
                    <div class="wrap-position-sub">
                        <label for="death_cause" class="block font-medium text-gray-900 dark:text-white">Amount</label>
                        <input type="text" name="finance_amount" placeholder="PHP">
                    </div>
                    <div class="wrap-position-sub">
                        <label for="death_cause" class="block font-medium text-gray-900 dark:text-white">Status</label>
                        <select name="status" id="">
                            <option selected disabled> Choose Status Type</option>
                            <option value="Pending"> Pending</option>
                            <option value="Paid"> Paid</option>
                            <option value="Released"> Released</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="death_cause" class="block font-medium text-gray-900 dark:text-white">Purpose</label>
                    <textarea name="finance_purpose" id="" cols="67" rows="5" placeholder="Request purpose ..."></textarea>
                </div>
                
                <input type="hidden" name="position_officials" value="">
                <button onclick="return  confirm('Do you want to add this record?')" type="submit" name="submit_finance" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
            </form>

        </div>
    </div>

    <script src="./assets/js/popup2.js"></script>
    <script src="./assets//js/select-resident.js"></script>
    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready( function () {
    $('#clearance-list').DataTable();
    } );
    </script>
    <!-- popup js -->
        <script>
            let popup = document.getElementById("popup")
            let modal = document.getElementById("modal")
           
           
                function openPopup() {
                    modal.classList.add("modal-active");
                    popup.classList.add("open-popup");
                } 
                function closePopup() {
                    popup.classList.remove("open-popup");
                    modal.classList.remove("modal-active");
                }             
        </script>

    <!-- event listener 
        <script>
            const submitButton = document.getElementById("submitButton")
                
            submitButton.addEventListener("click", function(event) {
                event.preventDefault();
            } );

            if (validateForm()) {
                
            }


    //input field checking 
            function validateForm() {
                let clearancename = document.getElementById("clearancename")

                if (clearancename == null || clearancename == "") {
                    alert("Clearance name must be filled out");
                    return false;
                }

                return true;
            }        
        </script> -->

        <script>
        let modal2 = document.getElementById('modal_vaccine');

            function openInsertPopup() {
                modal2.classList.add("modal-active2");
            }
            function closeInsertPopup() {
                modal2.classList.remove("modal-active2");
            }
        </script>

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

    

        
</body>

</html>