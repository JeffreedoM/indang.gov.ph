<?php
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';

$id = $_GET['id'];
$sql = "SELECT * FROM new_clearance c JOIN resident r ON r.resident_id = c.resident_id WHERE c.clearance_id = :clearance_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':clearance_id', $id, PDO::PARAM_INT);
$stmt->execute();
$clearance = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/forms.css">
    <link rel="icon" type="image/x-icon" href="../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title><?php echo "$clearance[lastname] $clearance[form_request]" ?></title>

</head>

<body>
    <!-- Form Template -->
    <!-- Header -->
    <?php include_once 'template.php' ?>
    <div class="right">
        <h1 class="title">CERTIFICATE OF RESIDENCY</h1>

        <div class="text-base mt-14 leading-8">
            <p class="font-semibold ">To Whom It may Concern:</p>

            <p class="mt-10">
                <span class="pr-4"></span>THIS IS TO CERTIFY that Mr./Mrs./Miss.__<span class="underline underline-offset-[2px]"><?php echo "$clearance[firstname] $clearance[middlename] $clearance[lastname]" ?></span>__,<br>
                __<span class="underline underline-offset-[3px]"><?php echo $clearance['age'] ?></span>__years old, single/married, male/female is a bonafide resident of<br>
                <span class="underline underline-offset-[2px]"><?php echo $clearance['address'] ?></span> since_____________.
                <br>
                <br>
                <span class="pr-4"></span>This certification is issued upon the request of __<span class="underline underline-offset-[2px]"><?php echo "$clearance[firstname] $clearance[middlename] $clearance[lastname]" ?></span>__ for<br>
                whatever legal purpose it may serve him/her best.<br>

                <br>
                <span class="pr-4"></span>Given this__<span id="day" class="underline underline-offset-[3px]">_____</span>__ day of __<span id="month" class="underline underline-offset-[3px]">__</span>__ 20<span id="year" class="underline underline-offset-[3px]">______</span>_, Barangay <?php echo $barangayName; ?>,<br>
                Municipalilty of Indang, Cavite, Philippines.
                <br>
                <br>

            <div class="float-right m-w-[50%] p-[10%]">
                <p class="mb-8">Approved by:</p>
                <div class="text-center float-left">
                    <p class="font-semibold uppercase underline underline-offset-4"><?php echo $brgyCaptain['name'] ?></p>
                    <p class="">Barangay Chairman</p>
                </div>
            </div>
        </div>
        </p>
    </div>

    </div>

    </div>
    <script src="../assets/js/dates.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>