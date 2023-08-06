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
<style>
    .i-label {
        font-size: 12px;
        font-style: italic;
        border-top: 1px solid black;
    }

    .bullet-list {
        list-style-type: disc;
    }

    .footer {
        margin: 10px;
    }

    .position {
        margin-bottom: 1rem;
    }

    .text-center {
        padding: 0 30px;
        margin-top: 1.5rem;
    }
</style>

<body>
    <?php

    function getOfficialDetails($position)
    {
        global $pdo;
        global $barangayId;
        $official = $pdo->query("SELECT * FROM resident INNER JOIN officials ON resident.resident_id = officials.resident_id WHERE officials.position = '$position' AND resident.barangay_id ='$barangayId'")->fetch();
        if ($official) {
            $middleInitial = substr($official['middlename'], 0, 1);
            $name = "$official[firstname]  $middleInitial.  $official[lastname]";
            return array('name' => $name);
        } else {
            return array(
                // 'name' => "<a id='no-position' href='add-officials.php'>Set $position</a>",
                'name' => "Unassigned",

            );
        }
    }
    $brgyCaptain = getOfficialDetails('Barangay Captain');
    $brgyTreasurer = getOfficialDetails('Barangay Treasurer');
    $comittee_peaceAndOrder = getOfficialDetails('Committee on Peace and Order');
    $comittee_publicInformation = getOfficialDetails('Committee on Public Information/Environment');
    $comittee_agricultural = getOfficialDetails('Committee on Agricultural');
    $comittee_healthAndSports = getOfficialDetails('Committee on Health and Sports');
    $comittee_education = getOfficialDetails('Committee on Education');
    $comittee_budgetAndAppropriation = getOfficialDetails('Committee on Budget and Appropriation');
    $comittee_infrastracture = getOfficialDetails('Committee on Infrastructure');
    $brgySecretary = getOfficialDetails('Barangay Secretary');
    $sk = getOfficialDetails('Sangguniang Kabataan');
    ?>

    <div class="flex justify-between">
        <button class="py-2 px-4 m-3 bg-yellow-400 rounded-md hover:bg-yellow-500" id="backButton" onClick="window.location.href = '../index.php';"><i class="fa-solid fa-left-long"></i> Back</button>
        <button class="py-2 px-4 m-3 bg-yellow-400 rounded-md hover:bg-yellow-500" id="printPageButton" onClick="window.print();">Print <i class="fa-solid fa-print"></i></button>
    </div>
    <!-- Form Template -->
    <!-- Header -->
    <div class="form-container">
        <div class="header">
            <img src="../../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>" alt="Barangay Logo" width="80px">
            <div>
                <div>Republic of the Philippines</div>
                <div>Province of Cavite</div>
                <div>Municipality of Indang</div>
                <div><?php echo $barangayName ?></div>
            </div>
            <img src="../../../../admin/assets/images/<?php echo $municipality['municipality_logo'] ?>" alt="Barangay Logo" width="80px">
        </div>
        <h2>Office of the Sangguniang Barangay</h2>
        <div class="form-content">
            <div class="left">
                <h3>SANGGUNIANG BARANGAY</h3>

                <div class="officials">
                    <p class="name"><?php echo $brgyCaptain['name'] ?></p>
                    <p class="position">Barangay Chairman</p>
                    <p class="name"><?php echo $comittee_publicInformation['name'] ?></p>
                    <p class="position">Barangay Kagawad</p>
                    <p class="name"><?php echo $comittee_agricultural['name'] ?></p>
                    <p class="position">Barangay Kagawad</p>
                    <p class="name"><?php echo $comittee_education['name'] ?></p>
                    <p class="position">Barangay Kagawad</p>
                    <p class="name"><?php echo $comittee_healthAndSports['name'] ?></p>
                    <p class="position">Barangay Kagawad</p>
                    <p class="name"><?php echo $comittee_infrastracture['name'] ?></p>
                    <p class="position">Barangay Kagawad</p>
                    <p class="name"><?php echo $comittee_budgetAndAppropriation['name'] ?></p>
                    <p class="position">Barangay Kagawad</p>
                    <p class="name"><?php echo $comittee_peaceAndOrder['name'] ?></p>
                    <p class="position">Barangay Kagawad</p>
                    <p class="name"><?php echo $brgyTreasurer['name'] ?></p>
                    <p class="position">Barangay Treasurer</p>
                    <p class="name"><?php echo $brgySecretary['name'] ?></p>
                    <p class="position">Barangay Secretary</p>
                </div>

            </div>
            <div class="right">
                <h1 class="font-semibold underline underline-offset-2 text-center text-lg">BARANGAY BUSINESS CLEARANCE</h1>

                <div class="text-base mt-10 leading-8" style="margin-right:40px">
                    <p class="font-semibold ">To Whom It may Concern:</p>

                    <p class="mt-5">
                        <span class="pr-4"></span>This is to certify that the Business or Trade Activity described below:


                        <!-- underlined -->
                    <div class="i-container">
                        <div class="text-center">
                            <div class="i-label">(Applicant Name)</div>
                        </div>

                        <div class="text-center">
                            <div class="i-label">(Bussiness Name of Trade Activities)</div>
                        </div>
                        <div class="text-center">
                            <div class="i-label">(Bussiness Address)</div>
                        </div>
                        <div class="text-center">
                            <div class="i-label">(Owner/Proprietor)</div>
                        </div>
                        <div class="text-center">
                            <div class="i-label">(Expiration Date)</div>
                        </div>
                    </div>
                    <br>
                    <span class="pr-4"></span>Proposed to be established and operate in this Barangay and is being applied for
                    a Barangay Business Clearance to be used in securing a corresponding Mayor's Permit/Business Permit has been found to be;<br>

                    <ul style="margin-left: 40px;">
                        <li class="bullet-list">
                            In conformity with the provisions of existing Barangay Ordinances, Rules and Regulations being
                            enforced in this Barangay.
                        </li>
                        <li class="bullet-list">
                            Not among those businesses or trade activities being banned to be established in this Barangay.
                        </li>
                    </ul>

                    <br>
                    <span class="pr-4"></span>
                    <b>NOW THEREFORE</b>, In view of the foregoing, this Barangay, thru the undersigned, interposes no objection for the issuance of the corresponding Mayors Permit/Business Permit being applied for.
                    <br>
                    <p class="font-semibold">
                        <span class="pr-4"></span>Issued this __<span id="day" class="underline underline-offset-[3px]">_____</span>__ day of __<span id="month" class="underline underline-offset-[3px]">________________________</span>__ 20<span id="year" class="underline underline-offset-[3px]">______</span>_.
                    </p>
                </div>
                </p>
            </div>

        </div>

        <div class="footer">
            <p>
                This permit may be <b>REVOKED</b> anytime for <b>VIOLATION</b> of <b>P.D. 856</b> also known as "<b>CODE ON SANITATION OF
                    THE PHILIPPINES</b>" and <b>R,A, 6541</b> also known as "<b>THE NATIONAL BUILDING CODE OF THE PHILIPPINES</b>" </p>
            <br>
            <p>Inspected by:</p>
            <div class="mt-8 leading-normal">


                <p>________________________________________________________</p>
                <p style="font-size: 12px; font-style: italic;" class="font-semibold mb-6"><span class="pr-4 "></span>Committee on Solid Waste Management and Environmental Protection</p>

                <p>Ceritfied by:</p>
                <div class="float-right m-w-[50%] pr-[10%]">
                    <div class="float-right">
                        <div class="text-center float-right">
                            <p class="font-semibold uppercase underline underline-offset-4"><?php echo $brgyCaptain['name'] ?></p>
                            <p class="">Barangay Chairman</p>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <p class="font-semibold inline-flex">
                    <span class="w-[140px]">CTC No.</span>
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
            </div>
        </div>

        <script src="../assets/js/dates.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
</body>

</html>