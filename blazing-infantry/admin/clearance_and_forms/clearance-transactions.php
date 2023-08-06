<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
include './includes/connect.php';


$clearance = $pdo->query("SELECT * FROM new_clearance GROUP BY form_request")->fetchAll();

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
    <link rel="stylesheet" href="./assets/css/styles2.css" type="text/css" />

    <title>Admin Panel | Clearance and Forms</title>

    <style>
        #form_paid {
            text-align: right;
        }
    </style>
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
                <h3 class="page-title">Clearances and Forms</h3>
            </div>

            <!-- Page body -->

            <div class="page-body" style="overflow-x:auto; min-height: 60vh;">
                <!-- Add clearance -->
                <div class="add_clearance">
                    <a href="index.php">
                        <button type="submit" class="btn"><span>Back</span></button>
                    </a>
                </div>
                <!-- List of clearances -->
                <div>
                    <table id="clearance-list" class="row-border hover">
                        <thead>
                            <tr>
                                <th>Form Type</th>
                                <th>Total Request</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clearance as $clearance) {
                                $form = $clearance['form_request'];
                                $count_form = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM new_clearance WHERE form_request='$form'")->fetchColumn();
                                $sum_form = $pdo->query("SELECT SUM(amount) AS total FROM new_clearance WHERE form_request='$form'")->fetchColumn();
                            ?>
                                <tr>
                                    <td><?php echo $form ?></td>
                                    <td><?php echo $count_form ?></td>
                                    <td><?php echo "₱ " . number_format($sum_form, 2, '.', ',') ?></td>
                                    <td>
                                        <button class="updatebtn" onclick="openPopup(<?php echo $clearance['clearance_id'] ?>,'<?php echo $clearance['form_request'] ?>')">
                                            View Transaction
                                        </button>
                                    </td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Add clearance pop-up -->
            <div class="add-clearance" id="modal">

                <div class="content" id="popup">
                    <button class="closebtn" onclick="closePopup()">X</button>
                    <div class="header-center">
                        <h1>Transaction History</h1>
                    </div>
                    <div class="sub-header">
                        <br>
                        <hr>
                        <br>
                        <div class="sub-header-main">
                            <div class="sub-header-column1">
                                <h1><span class="label_form1">Form Type:</span> <br><span id="form_name"></span></h1><br>
                                <label for="status">Status</label>
                                <h1><span class="label_form1">Pending:</span> <span id="form_pending"></span></h1>
                                <hr>
                            </div>
                            <div class="sub-header-column1">
                                <h1><span class="label_form1">Form Fee:</span> <br><span id="form_amount"></span></h1><br>
                                <br>
                                <h1><span class="label_form1">Paid:</span> <span id="form_paid_status"></span></h1>
                                <hr>
                            </div>
                            <div class="sub-header-column1">
                                <h1><span class="label_form1">Total Request:</span> <br><span id="form_request"></span></h1><br>
                                <br>
                                <h1><span class="label_form1">Released:</span> <span id="form_released"></span></h1>
                                <hr>
                            </div>
                            <div class="sub-header-column1">
                                <h1><span class="label_form1">Total Amount:</span> <br><span id="form_total"></span></h1><br>
                            </div>
                        </div>
                        <br><br>

                        <h1>Resident Transaction Details</h1>
                        <br>
                        <table class="form_report">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date Given</th>
                                    <th>Status</th>
                                    <th style="text-align: right;">Amount Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="form_resident"></td>
                                    <td id="form_date"></td>
                                    <td id="form_status"></td>
                                    <td id="form_paid"></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>



                </div>

            </div>

    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#clearance-list').DataTable();
        });
    </script>
    <!-- popup js -->
    <script>
        let popup = document.getElementById("popup")
        let modal = document.getElementById("modal")
        clearanceId;
        form_name;


        function openPopup(clearance_id, form_label) {
            clearanceId = clearance_id;
            form_name = form_label;

            // Get the element
            let formName = document.getElementById("form_name");
            let formAmount = document.getElementById("form_amount");
            let formTotal = document.getElementById("form_total");
            let formResident = document.getElementById("form_resident");
            let formDate = document.getElementById("form_date");
            let formRequest = document.getElementById("form_request");
            let formStatus = document.getElementById("form_status");
            let formPaid = document.getElementById("form_paid");
            let formPending = document.getElementById("form_pending");
            let formPaidStatus = document.getElementById("form_paid_status");
            let formReleased = document.getElementById("form_released");

            // FORM NAME BY ARIANNE test
            let xhrFormName = new XMLHttpRequest();
            xhrFormName.open("GET", "includes/fetch_record.php?id=" + clearanceId + "&form_label=" + encodeURIComponent(form_name), true);
            xhrFormName.onload = function() {
                if (xhrFormName.status == 200) {
                    // Parse the JSON response
                    let response = JSON.parse(xhrFormName.responseText);

                    // Access the formName and formAmount from the response object
                    let receivedFormName = response.formName;
                    let receivedFormAmount = response.formAmount;
                    let receivedFormTotal = response.formTotal;
                    let receivedFormResident = response.formResident;
                    let receivedFormDate = response.formDate;
                    let receivedFormRequest = response.formRequest;
                    let receivedFormStatus = response.formStatus;
                    let receivedFormPaid = response.formPaid;
                    let receivedFormPending = response.formPending;
                    let receivedFormPaidStatus = response.formPaidStatus;
                    let receivedFormReleased = response.formReleased;
                    console.log(receivedFormPaid)

                    // Update the HTML elements with the received values
                    // "₱ " + parseFloat(receivedFormPaid).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    formName.innerHTML = receivedFormName;
                    formAmount.innerHTML = "₱ " + parseFloat(receivedFormAmount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    formTotal.innerHTML = "₱ " + parseFloat(receivedFormTotal).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    formResident.innerHTML = receivedFormResident;
                    formDate.innerHTML = receivedFormDate;
                    formRequest.innerHTML = receivedFormRequest;
                    formStatus.innerHTML = receivedFormStatus;
                    formPaid.innerHTML = receivedFormPaid.split('<br>').map(amount => "₱ " + parseFloat(amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")).join('<br>');
                    formPending.innerHTML = receivedFormPending;
                    formPaidStatus.innerHTML = receivedFormPaidStatus;
                    formReleased.innerHTML = receivedFormReleased;
                }
            };
            xhrFormName.send();


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

    <!-- test printjs -->
    <script>
        function printModalContent() {
            let modalContent = document.getElementById("popup").innerHTML;
            let printWindow = window.open("", "_blank");
            printWindow.document.open();
            printWindow.document.write(
                '<html><head><title>Modal Content</title></head><body>' +
                modalContent +
                "</body></html>"
            );
            printWindow.document.close();
            printWindow.print();
        }
    </script>




</body>

</html>