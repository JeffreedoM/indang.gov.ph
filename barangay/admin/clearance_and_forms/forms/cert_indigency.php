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

    <?php include_once 'template.php' ?>
    <div class="right">
        <h1 class="title">CERTIFICATE OF INDIGENCY</h1>

        <div class="text-base mt-14 leading-8">
            <p class="font-semibold ">To Whom It may Concern:</p>

            <p class="mt-8">
                <span class="pr-4"></span>THIS IS TO CERTIFY that __<span class="underline underline-offset-[2px]"><?php echo "$clearance[firstname] $clearance[middlename] $clearance[lastname]" ?></span>__,<br>
                __<span class="underline underline-offset-[3px]"><?php echo $clearance['age'] ?></span>__years of age, Filipino and whose signature appears below, is a<br>
                bonafide resident of Barangay <?php echo $barangayName; ?>, Indang, Cavite.
                <br>
                <br>
                <span class="pr-4"></span>IT IS FURTHER CERTIFIED that __<span class="underline underline-offset-[2px]"><?php echo "$clearance[firstname] $clearance[middlename] $clearance[lastname]" ?></span>__,<br>
                who is known to the undersigned, is person of good character, a <br>
                law-biding citizen and has neither nor criminal record/s in this barangay as<br>
                of this date and further certifies that the abovementioned individual<br>
                belongs to the low/no income bracket or an <b>INDIGENT</b> member in our community.<br>
                <br>
                <span class="pr-4"></span>This CERTIFICATION is issued upon the request of the abovementioned<br>
                person for whatever legal purposes it may serve.
                <br>
                <br>
                <span class="pr-4"></span>DONE AND ISSUED this__<span id="day" class="underline underline-offset-[3px]">_____</span>__ day of __<span id="month" class="underline underline-offset-[3px]">__</span>__ 20<span id="year" class="underline underline-offset-[3px]">______</span>_, at Barangay <?php echo $barangayName; ?>
                Indang, Cavite.


            <div class="mt-6 leading-normal">
                <p>_______________________</p>
                <p class="font-semibold mb-6"><span class="pr-4 "></span>Signature of Applicant</p>

                <div class="float-right m-w-[50%] pr-[10%]">
                    <p class="mb-8">Approved by:</p>
                    <div class="text-center float-left">
                        <p class="font-semibold uppercase underline underline-offset-4"><?php echo $brgyCaptain['name'] ?></p>
                        <p class="">Barangay Chairman</p>
                    </div>
                </div>
            </div>
        </div>
        </p>
    </div>

    </div>


    <script src="../../../assets/js/sidebar.js"></script>
    <script src="../assets/js/dates.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>