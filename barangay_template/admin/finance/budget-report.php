<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
include './includes/connect.php';

//Getting residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);

//SORT DATE
if(isset($_GET['sort_date'])){
    $date_from = $_GET['date_from'];
    $date_to = $_GET['date_to'];
    if (!empty($date_from) && empty($date_to)) {
        // CLEARANCE AND FORMS
        $finance = $pdo->query("SELECT * FROM new_clearance WHERE finance_date = '$date_from' GROUP BY form_request")->fetchAll();
        $totalRequest2 = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM new_clearance WHERE finance_date = '$date_from'")->fetchColumn();
        
        $totalAmountResult2 = $pdo->query("SELECT COALESCE(SUM(amount), 0) AS total_amount2 FROM new_clearance WHERE finance_date = '$date_from'");
        $totalRowAmount2 = $totalAmountResult2->fetch();
        $formAmount2 = $totalRowAmount2['total_amount2'];

        // FINANCE
        $project = $pdo->query("SELECT * FROM new_finance WHERE financeDate = '$date_from'")->fetchAll();

        $totalAmountResult3 = $pdo->query("SELECT COALESCE(SUM(financeAmount), 0) AS total_amount3 FROM new_finance WHERE financeDate = '$date_from'");
        $totalRowAmount3 = $totalAmountResult3->fetch();
        $formAmount3 = $totalRowAmount3['total_amount3'];
    } 
    if (!empty($date_from) && !empty($date_to)) {
        $finance = $pdo->query("SELECT * FROM new_clearance WHERE finance_date >= '$date_from' AND finance_date <= '$date_to' GROUP BY form_request")->fetchAll();
        $totalRequest2 = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM new_clearance WHERE finance_date >= '$date_from' AND finance_date <= '$date_to'")->fetchColumn();
        
        $totalAmountResult2 = $pdo->query("SELECT COALESCE(SUM(amount), 0) AS total_amount2 FROM new_clearance WHERE finance_date >= '$date_from' AND finance_date <= '$date_to'");
        $totalRowAmount2 = $totalAmountResult2->fetch();
        $formAmount2 = $totalRowAmount2['total_amount2'];

        // FINANCE
        $project = $pdo->query("SELECT * FROM new_finance WHERE financeDate >= '$date_from' AND financeDate <= '$date_to'")->fetchAll();

        $totalAmountResult3 = $pdo->query("SELECT COALESCE(SUM(financeAmount), 0) AS total_amount3 FROM new_finance WHERE financeDate >= '$date_from' AND financeDate <= '$date_to'");
        $totalRowAmount3 = $totalAmountResult3->fetch();
        $formAmount3 = $totalRowAmount3['total_amount3'];
    } 
} else {
    $finance = $pdo->query("SELECT * FROM new_clearance GROUP BY form_request")->fetchAll();

    // FINANCE
    $project = $pdo->query("SELECT * FROM new_finance")->fetchAll();

    $totalAmountResult3 = $pdo->query("SELECT COALESCE(SUM(financeAmount), 0) AS total_amount3 FROM new_finance");
    $totalRowAmount3 = $totalAmountResult3->fetch();
    $formAmount3 = $totalRowAmount3['total_amount3'];
}
    

    




//Treasurer name registered
$treasurer = $pdo->query("SELECT * FROM resident JOIN officials ON resident.resident_id = officials.resident_id WHERE position = 'Barangay Treasurer'")->fetch();



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
    
    <title>Admin Panel | Finance</title>
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
                <h3 class="page-title">

                    <div class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="index.php" class="inline-flex items-center text-base font-semibold text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                    Home
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"> Budgetary Reports</span>
                                </div>
                            </li>
                        </ol>
                    </div>
                </h3>
            </div>

            <form action="" method="GET">
            <?php
                $date_from2 = isset($_GET['date_from']) ? $_GET['date_from'] : '';
                $date_to2 = isset($_GET['date_to']) ? $_GET['date_to'] : '';

                if (empty($date_from2)) {
                    $datemd_from = '000000';
                } else {
                    $datemd_from = date("mdY", strtotime($date_from2));
                }
                
                if (empty($date_to2)) {
                    $datemd_to = '000000';
                } else {
                    $datemd_to = date("mdY", strtotime($date_to2));
                }

            ?>
            <div class="date-sort">
                <div class="date-sort-sub">
                    <label for="date-from">Date From</label>
                    <input type="date" name="date_from" value="<?php echo $date_from2 ?>" required> 
                </div>
                <div class="date-sort-sub">
                    <label for="date-to">Date To</label>
                    <input type="date" name="date_to" value="<?php echo $date_to2 ?>">
                </div>
                <div class="date-sort-sub">
                    <button type="submit" class="add_transaction" name="sort_date">Filter</button>
                </div>
            </div>
            </form>

            <!-- Page body -->
            <div class="page-body" style="overflow-x:auto; min-height: 60vh;">
                
                <center>
                    <h1>Report of Collections and Deposits</h1>
                    <br>
                </center>

                <div class="wrap-position">
                    <div class="wrap-position-sub">
                        <label for="date"><b>Barangay Treasurer</b></label>
                        
                        <p><?php echo $treasurer['firstname'].' '.$treasurer['middlename'].' '.$treasurer['lastname']?></p>
                        <br>
                        <label for="date"><b>Barangay Name</b></label>
                        <p>Don Severino</p>
                    </div>
                    
                    <div class="wrap-position-sub" style="padding-left:200px;">
                        <label for="date-from"><b>Date</b></label>
                        <p><?php $datetoString = ' - '.$date_to2; echo $date_from2.$datetoString; ?></p>
                        <br>
                        <label for="date"><b>RCD NO.</b></label>
                        <p><?php echo $treasurer['official_id'].$datemd_from.$datemd_to ?></p>
                    </div>
                </div>
                
                <br><hr><br>

                <div class="wrap-position">
                    <div class="wrap-position-sub">
                        <h1><b>Collections</b></h1>
                        <table class="finance-table">
                            <thead>
                                <tr>
                                    <th>Form Type</th>
                                    <th>Request Quantity</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    
                                    foreach($finance as $finance){

                                        if (!empty($date_from) && empty($date_to)) {
                                           
                                            //total request based on the form
                                            $form_label = $finance['form_request'];
                                            $totalRequest = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM new_clearance WHERE form_request='$form_label' AND finance_date = '$date_from'")->fetchColumn();
                                            
                                            // Calculate total amount paid
                                            $totalAmountResult = $pdo->query("SELECT COALESCE(SUM(amount), 0) AS total_amount FROM new_clearance WHERE form_request='$form_label' AND finance_date = '$date_from'");
                                            $totalRowAmount = $totalAmountResult->fetch();
                                            $formAmount = $totalRowAmount['total_amount'];
                                            
                                        } elseif (!empty($date_from) && !empty($date_to)) {
                                           
                                            //total request based on the form
                                            $form_label = $finance['form_request'];
                                            $totalRequest = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM new_clearance WHERE form_request='$form_label' AND finance_date >= '$date_from' AND finance_date <= '$date_to'")->fetchColumn();
                                           
                                            // Calculate total amount paid
                                            $totalAmountResult = $pdo->query("SELECT COALESCE(SUM(amount), 0) AS total_amount FROM new_clearance WHERE form_request='$form_label' AND finance_date >= '$date_from' AND finance_date <= '$date_to'");
                                            $totalRowAmount = $totalAmountResult->fetch();
                                            $formAmount = $totalRowAmount['total_amount'];

                                        } else {
                                            //total request based on the form
                                            $form_label = $finance['form_request'];
                                            $totalRequest = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM new_clearance WHERE form_request='$form_label'")->fetchColumn();
                                            $totalRequest2 = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM new_clearance")->fetchColumn();
                                            
                                            // Calculate total amount paid
                                            $totalAmountResult = $pdo->query("SELECT COALESCE(SUM(amount), 0) AS total_amount FROM new_clearance WHERE form_request='$form_label'");
                                            $totalRowAmount = $totalAmountResult->fetch();
                                            $formAmount = $totalRowAmount['total_amount'];
                                            
                                            $totalAmountResult2 = $pdo->query("SELECT COALESCE(SUM(amount), 0) AS total_amount2 FROM new_clearance");
                                            $totalRowAmount2 = $totalAmountResult2->fetch();
                                            $formAmount2 = $totalRowAmount2['total_amount2'];
                                        }
                                ?>

                                <tr>
                                    <td><?php echo $finance['form_request']?></td>
                                    <td><?php echo $totalRequest?></td>
                                    <td><?php echo $formAmount?></td>
                                </tr>

                                <?php
                                    }
                                ?>

                                <tr>
                                    <td><b>Total</b></td>
                                    <td><b><?php echo $totalRequest2?></b></td>
                                    <td><b><?php echo $formAmount2?></b></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <h1><b>Total Collection:</b> PHP <?php echo $formAmount2; ?></h1>
                    </div>
                    <div class="wrap-position-sub">
                        <h1><b>Deposits</b></h1>
                        <table class="finance-table">
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Amount Deposit</th>
                                    <th>Date Given</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($project as $project){

                                ?>
                                <tr>
                                    <td><?php echo $project['financeProject']?></td>
                                    <td><?php echo $project['financeAmount']?></td>
                                    <td><?php echo $project['financeDate']?></td>
                                </tr>
                                <?php 
                                    }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <h1><b>Total Deposits:</b> PHP <?php echo $formAmount3?></h1>
                    </div>
                </div>


                <!-- <div class="wrap-position">
                    <div class="wrap-position-sub">
                        <label for="date">Date From</label>
                        <input type="date">
                    </div>
                    <div class="wrap-position-sub">
                        <label for="date">Date To</label>
                        <input type="date">
                    </div>
                    <div class="wrap-position-sub">
                        <button type="submit" class="add_transaction">Sort</button>
                    </div>
                </div> -->
            
    </main>

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