<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
include 'assets/includes/add-medicine.php';

$stmt = $pdo->prepare("SELECT * FROM medicine_inventory WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$record = $stmt->fetchAll(PDO::FETCH_ASSOC);


$currentId = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM medicine_inventory WHERE ID = :current_id");
$stmt->bindParam(':current_id', $currentId, PDO::PARAM_INT);
$stmt->execute();
$medicine = $stmt->fetch(PDO::FETCH_ASSOC);

$medicineName = $medicine['medicine_name'];
$ID = $medicine['ID'];
$medDate = $medicine['medicine_expiration'];
$quantity = $medicine['medicine_quantity'];
$desc = $medicine['medicine_description'];

$formattedDate = date('F j, Y', strtotime($medDate));

$expiryTimestamp = strtotime($medDate);
$currentTimestamp = time();





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
    <link rel="stylesheet" href="assets/css/health.css" />
    <!-- jquery for calendar -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Medicine Inventory</title>


    <style>
        .button {
            cursor: pointer;
            border: 1px solid #8E94A9;
            background: none;
            color: #8E94A9;
            border-radius: 3px;
            padding: 0.3rem 0.5rem;
            font-weight: var(--fw-m);
        }

        .button:hover {
            background-color: #8E94A9;
            color: white;
        }

        .quantity {
            display: flex;
            align-items: center;
            width: 30%;
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
                <h3 class="page-title">Health and Sanitation</h3>
                <p>Medicine Inventory</p>
            </div>

            <!-- Page body -->
            <div class="page-body body">

            </div>

            <div class="page-body">
                <div style="text-align:center; ">
                    <p style="text-transform: uppercase; font-weight:bold;"><?php echo $medicineName ?></p>
                </div>

                <div style="margin-top: 2rem;">
                    <p>
                        <?php if ($expiryTimestamp < $currentTimestamp) {
                            // Medicine has expired
                            $formattedDate = date('F j, Y', $expiryTimestamp);
                            echo "Expiration Date: $formattedDate <span style='color: red;'>(Expired)</span>";
                        } else {
                            // Medicine is not yet expired
                            $formattedDate = date('F j, Y', $expiryTimestamp);
                            echo "Expiration Date: $formattedDate";
                        }
                        ?>
                    </p>
                </div>

                <form action="./assets/includes/edit-inventory.inc.php" method="POST">
                    <input type="hidden" name="medicine_id" value=<?php echo $currentId ?>>
                    <div style="margin-top: 1rem;" class="quantity">
                        <p style="margin-right: .5rem;">Quantity: </p>
                        <input type="number" name="medicine_quantity" value="<?php echo $quantity; ?>" required>
                    </div>

                    <div style="margin-top: 1rem;">
                        <p style="margin-bottom: 0.5rem;">Description: </p>
                        <textarea name="medicine_description" rows="5" cols="50" maxlength="500" style="width: 50%;"><?php echo $desc ?></textarea>
                    </div>
                    <button onclick="return  confirm('Do you want to edit this record?')" type="submit" name="submit_edit" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" style="margin-top: 2rem; width: 15%;">Submit</button>
                </form>
            </div>
        </div>
    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>