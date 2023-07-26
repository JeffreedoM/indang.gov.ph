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