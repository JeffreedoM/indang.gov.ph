<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
include './includes/connect.php';

//Getting residents from the database
$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query for sort and budget report
include_once './includes/budget-query.php';

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
    <link rel="stylesheet" href="./assets/css/table.css" type="text/css" />

    <!-- Test pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


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

            <!-- For date sorting -->
            <form action="" method="GET">
                <?php
                $date_from2 = isset($_GET['date_from']) ? $_GET['date_from'] : '';
                $date_to2 = isset($_GET['date_to']) ? $_GET['date_to'] : '';

                if (empty($date_from2)) {
                    $datemd_from = '';
                } else {
                    $datemd_from = date("mdY", strtotime($date_from2));
                }

                if (empty($date_to2)) {
                    $datemd_to = '';
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
            <div class="page-body" id="printElement" style="overflow-x:auto; min-height: 60vh;">
                <!-- In Line Style -->
                <?php include_once "./includes/printstyle.php"?>

                <!-- Header -->
                <div class="headerReport">
                    <img class="reportsImg" src="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay_img?>">
                    <div class="headerReportText">
                        <h3><b>Republic of the Philippine</b></h3>
                        <p>Province of Cavite</p>
                        <p>Municipality of Indang</p>
                        <p>Barangay <?php echo $barangay_reg?></p>
                        <h1 class="headerCollection"><b>Report of Collections and Deposits</b></h1>
                    </div>
                    <img class="reportsImg" src="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay_img?>">
                </div>
                <br>               

                <!-- Treasurer Name and Barangay Detail -->
                <div class="wrap-position printPosition">
                    <div class="wrap-position-sub printSub">
                        <label for="date"><b>Barangay Treasurer</b></label>

                        <p><?php echo $name_registered ?></p>
                        <br>
                        <label for="date"><b>Barangay Name</b></label>
                        <p><?php echo $barangay_reg ?></p>
                    </div>

                    <div class="wrap-position-sub printSub" style="padding-left:200px;">
                        <label for="date-from"><b>Date</b></label>
                        <p><?php $datetoString = ' - ' . $date_to2;
                            echo $date_from2 . $datetoString; ?></p>
                        <br>
                        <label for="date"><b>RCD NO.</b></label>
                        <p><?php echo $treasurer_id.$datemd_from.$datemd_to ?></p>
                    </div>
                </div>

                <br><hr><br>

                <!-- Table A-->
                <h1 class="subheader"><b>A. COLLECTION</b></h1>
                <table class="tableCollection">
                    <tr>
                        <th>Date</th>
                        <th>Payor/DBC</th>
                        <th>Nature of Collection</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>

                    <?php foreach ($collection as $collection) { 
                        $formattedDate = date("F j, Y", strtotime($collection['collectionDate']));
                    ?>
                    <tr>
                        <td><?php echo $formattedDate?></td>
                        <td><?php echo $collection['collectionPayor']?></td>
                        <td><?php echo $collection['collectionNature']?></td>
                        <td style="text-align: right;"><?php echo 'NA'?></td>
                        <td style="text-align: right;"><?php echo $collection['collectionAmount']?></td>
                    </tr>
                    <?php } 
                        if($finalTotalClearance != 0){
                            foreach ($clearance as $clearance) { 
                            // FOR CLEARANCE
                            $form = $clearance['form_request'];
                            $count_form = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM new_clearance WHERE form_request='$form' AND barangay_id='$barangayId' AND status='Paid' GROUP BY form_request")->fetchColumn();   
                            
                            $sumClearance = $pdo->query("SELECT COALESCE(SUM(amount), 0) AS total_clearance FROM new_clearance WHERE form_request='$form' AND barangay_id='$barangayId' AND status='Paid' GROUP BY form_request");
                            $sumClearanceRow = $sumClearance->fetch();
                            $sumClearanceFinal = $sumClearanceRow['total_clearance']; 
                            $formattedSumClearanceFinal = number_format($sumClearanceFinal, 2);
                            
                            $formattedDate = date("F j, Y", strtotime($clearance['finance_date']));
                            ?>
                                <tr>
                                <td><?php echo $formattedDate?></td>
                                <td>Clearance</td>
                                <td><?php echo $clearance['form_request']?></td>
                                <td style="text-align: right;"><?php echo $count_form?></td>
                                <td style="text-align: right;"><?php echo $formattedSumClearanceFinal?></td>
                                </tr>
                            <?php
                            }
                        }
                    ?>
                    <tr>
                        <td colspan="5">Total : <?php echo $finalTotalCollection + $finalTotalClearance?></td>
                    </tr>
                </table>
                <!-- Divider -->
                <br>

                <!-- Table B-->
                <h1 class="subheader"><b>B. DEPOSITS</b></h1>
                <table class="tableCollection">
                    <tr>
                        <th>Date</th>
                        <th>Bank/Branch</th>
                        <th>Reference</th>
                        <th>Amount</th>
                    </tr>
                    <?php foreach ($deposit as $deposit) { 
                        $formattedDate = date("F j, Y", strtotime($deposit['depositDate']));    
                    ?>
                    <tr>
                        <td><?php echo $formattedDate?></td>
                        <td><?php echo $deposit['depositBank']?></td>
                        <td><?php echo $deposit['depositReference']?></td>
                        <td style="text-align: right;"><?php echo $deposit['depositAmount']?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4">Total: <?php echo $finalTotalDeposit?></td>
                    </tr>
                </table>
                <!-- Divider -->
                <br>

                <!-- Table C-->
                <h1 class="subheader"><b>C. BILLS AND EXPENSES</b></h1>
                <table class="tableCollection">
                    <tr>
                        <th>Projects</th>
                        <th>Project Amount</th>
                        <th>Water Bills</th>
                        <th>Electric Bills</th>
                        <th>Date</th>
                    </tr>
                    <?php foreach ($expenses as $expenses) { 
                        $formattedDateFrom = date("F j, Y", strtotime($expenses['expensesDateFrom'])); 
                        $formattedDateTo = date("F j, Y", strtotime($expenses['expensesDateTo'])); 
                    ?>
                    <tr>
                        <td><?php echo $expenses['expensesProject']?></td>
                        <td style="text-align: right;"><?php echo $expenses['expensesProjectAmount']?></td>
                        <td style="text-align: right;"><?php echo $expenses['expensesElectricAmount']?></td>
                        <td style="text-align: right;"><?php echo $expenses['expensesWaterAmount']?></td>
                        <td><?php echo $formattedDateFrom." / ".$formattedDateTo?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="5">Total: <?php echo $finalTotalExpenses?></td>
                    </tr>
                </table>
                <!-- Divider -->
                <br>
            </div>
            <!-- Print Button -->
            <button onclick="printElement()" class="block bg-yellow-300 hover:bg-yellow-500 p-2 px-4 rounded-md mx-auto mt-10">Print <i class="fa-solid fa-print"></i></button>
        </div>
    </main>

    <script src="./assets/js/popup2.js"></script>
    <script src="./assets//js/select-resident.js"></script>
    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script defer>
        $(document).ready(function() {
            $('#clearance-list').DataTable();
        });
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

    <!-- Print Function -->
    <script>
        function printElement() {
        var printContents = document.getElementById("printElement").innerHTML;
        var originalContents = document.body.innerHTML;

        // Create a new window for printing
        var printWindow = window.open("", "_blank");
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Finance Report</title></head><body>' + printContents + '</body></html>');
        printWindow.document.close();

        // Call the print function of the new window
        printWindow.print();

        // Restore the original contents of the page
        document.body.innerHTML = originalContents;
        }

    </script>
</body>

</html>