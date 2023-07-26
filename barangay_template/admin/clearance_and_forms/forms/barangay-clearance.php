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
    <?php include_once 'template.php' ?> <!-- Ganito nalang pre -->
    <div class="right"> <!-- Dito mo lagay sa loob nito contents pre -->
        <h1 class="title">BARANGAY CLEARANCE</h1>

        <div class="text-base mt-12 leading-8">
            <p class="font-semibold ">To Whom It may Concern:</p>

            <p class="mt-6">
                <span class="pr-4"></span>This is to certify that Mr./Mrs./Miss.____<span class="underline underline-offset-[3px]"><?php echo "$clearance[firstname] $clearance[middlename] $clearance[lastname]" ?></span>____,<br>
                _<span class="underline underline-offset-[3px]"><?php echo $clearance['age'] ?></span>_years old, single/married is personally known to me of good moral<br>
                character and law abiding citizen of the barangay with no derogatory record/ <br>
                file committed as of this date.<br>
                <span class="pr-4"></span>This clearance is valid for the period of ninety (90) days only from the date <br>
                of issued. <br>
                <span class="pr-4"></span>This certification has been issued upon the request of the subject person in <br>
                connection with his/her application for __<span class="underline underline-offset-[3px]"><?php echo $clearance['purpose'] ?></span>__. <br>
                <span class="pr-4"></span>Given this __<span id="day" class="underline underline-offset-[3px]">_____</span>__ day of __<span id="month" class="underline underline-offset-[3px]">________________________</span>__ 20<span id="year" class="underline underline-offset-[3px]">______</span>_.

            <div class="mt-8 leading-normal">
                <p>_______________________</p>
                <p class="font-semibold mb-6"><span class="pr-4 "></span>Signature of Applicant</p>

                <p class="font-semibold inline-flex">
                    <span class="w-[140px]">Res. Cert No.</span>
                    <span>:____________</span>
                </p>
                <br>
                <p class="font-semibold inline-flex">
                    <span class="w-[140px]">Issued at</span>
                    <span>:____________</span>
                </p>
                <br>
                <p class="font-semibold inline-flex">
                    <span class="w-[140px]">Issued on</span>
                    <span>:____________</span>
                </p>
                <br>
                <p class="font-semibold inline-flex">
                    <span class="w-[140px]">Official Receipt No.</span>
                    <span>:____________</span>
                </p>


                <div class="border border-black w-[150px] h-[60px] mt-8"></div>

                <div class="float-right m-w-[50%] pr-[10%]">
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