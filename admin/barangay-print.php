<?php
include 'includes/dbh.inc.php';

$barangayId = $_GET['id'];
$barangay = $pdo->query("SELECT * FROM barangay WHERE b_id='$barangayId'")->fetch();
$municipality = $pdo->query("SELECT * FROM superadmin_config")->fetch();

$barangayName = ucwords($barangay['b_name']);


$sql = "SELECT * FROM resident r
        JOIN officials o ON r.resident_id = o.resident_id
        JOIN accounts a ON a.official_id = o.official_id 
        WHERE r.barangay_id = :barangay_id";
// Prepare the statement
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$account = $stmt->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Print</title>

    <style>
        button {
            position: absolute;
            bottom: 10%;
            left: 50%;
            transform: translateX(-50%);
        }

        @media print {
            :root {
                font-size: 11px;
            }

            #printPageButton {
                display: none;
            }

            body {
                margin: 10px;
            }

        }

        @page {
            size: 127mm 76.2mm;
            /* Set the width and height for the custom index card size */
            margin: 10px;
        }

        header {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            gap: 1rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <header>
        <img src="./assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>" alt="Barangay Logo" width="50px">
        <div>
            <div>Republic of the Philippines</div>
            <div>Province of Cavite</div>
            <div>Municipality of Indang</div>
            <div><?php echo $barangayName ?></div>
        </div>
        <img src="./assets/images/<?php echo $municipality['municipality_logo'] ?>" alt="Barangay Logo" width="50px">
    </header>

    <div class="mt-8 mx-[2.5rem]">
        <h1 class="text-center mb-6 font-semibold text-2xl"><?php echo $barangayName ?></h1>
        <div class="mb-3 bg-slate-100 p-3 flex justify-between rounded">
            <p>Username: </p>
            <p><?php echo $account['username'] ?>
            </p>
        </div>
        <div class="mb-3 bg-slate-100 p-3 flex justify-between rounded">
            <p>Password: </p>
            <p><?php echo $account['default_password'] ?></p>
        </div>
        <div class="mb-5 bg-slate-100 p-3 flex justify-between rounded">
            <p>Barangay Link: </p>
            <p><?php echo $barangay['b_link'] ?>
            </p>
        </div>
        <p class="text-[8px]">Note: It is important to immediately change the default username and password for the security of the system.</p>
    </div>
    <button class="bg-yellow-400 px-5 py-2 rounded-lg hover:bg-yellow-500" id="printPageButton" onClick="window.print();">Print <i class="fa-solid fa-print"></i></button>



    <script>
        document.title = "<?php echo "$barangayName Login Credentials" ?>"
        window.print();
    </script>
</body>

</html>