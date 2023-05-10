<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
include './includes/connect.php';


$clearance = $pdo->query("SELECT * FROM clearance")->fetchAll();

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
    
    <title>Admin Panel | Clearance and Forms</title>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clearance as $clearance) { ?>
                                <tr>
                                    <td><?php echo $clearance['clearance_name']?></td>
                                    <td>
                                        <div>
                                            <button class="updatebtn" onclick="openPopup(<?php echo $clearance['clearance_id'] ?>)">
                                                View
                                            </button>
                                            <!-- <button class="viewbtn">
                                                View
                                            </button> --> 
                                        </div>
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
                    <h1 style="margin-bottom: 1.4rem ; margin-top: 2.5rem; font-size: 25px;">
                    <span id="clearance_name"></span>
                    </h1>
                    <p style="font-size: 18px;">Price: ₱<span id="clearance_price"></span></p>
                    <p style="font-size: 18px;">Total Release: <span id="clearance_total"> </p>
                    <p style="font-size: 18px;">Total Amount: ₱<span id="clearance_sales"> </p>
                </div>
       
            </div>
            
    </main>

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
            clearanceId;
           
           
            function openPopup(clearance_id) {
                clearanceId = clearance_id;

                // Get the element
                let clearanceName = document.getElementById("clearance_name");
                let clearancePrice = document.getElementById("clearance_price");
                let clearanceTotal = document.getElementById("clearance_total");
                let clearanceSales = document.getElementById("clearance_sales");
                

                // Set its innerHTML to the desired value

                 // Send an AJAX request to fetch the clearance name for the provided clearance ID
                let xhrName = new XMLHttpRequest();
                xhrName.open("GET", "includes/fetch_clearance_name.php?id=" + clearanceId, true);
                xhrName.onload = function() {
                    if (xhrName.status == 200) {
                    // Update the clearance_name span element with the clearance name
                    clearanceName.innerHTML = xhrName.responseText;
                    }
                };
                xhrName.send();
               
                 // Send an AJAX request to fetch the clearance price for the provided clearance ID
                 let xhrPrice = new XMLHttpRequest();
                 xhrPrice.open("GET", "includes/fetch_clearance_price.php?id=" + clearanceId, true);
                 xhrPrice.onload = function() {
                    if (xhrPrice.status == 200) {
                    // Update the clearance_name span element with the clearance name
                    clearancePrice.innerHTML = xhrPrice.responseText;
                    }
                };
                xhrPrice.send();

                 // Send an AJAX request to fetch the clearance price for the provided clearance ID
                 let xhrTotal = new XMLHttpRequest();
                 xhrTotal.open("GET", "includes/fetch_clearance_total.php?id=" + clearanceId, true);
                 xhrTotal.onload = function() {
                    if (xhrTotal.status == 200) {
                    // Update the clearance_name span element with the clearance name
                    clearanceTotal.innerHTML = xhrTotal.responseText;
                    }
                };
                xhrTotal.send();

                 // Send an AJAX request to fetch the clearance price for the provided clearance ID
                 let xhrSales = new XMLHttpRequest();
                 xhrSales.open("GET", "includes/fetch_clearance_totalsales.php?id=" + clearanceId, true);
                 xhrSales.onload = function() {
                    if (xhrSales.status == 200) {
                    // Update the clearance_name span element with the clearance name
                    clearanceSales.innerHTML = xhrSales.responseText;
                    }
                };
                xhrSales.send();






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
    



    

        
</body>

</html>