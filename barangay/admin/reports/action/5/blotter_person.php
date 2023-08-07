<?php
include '../../../../includes/deactivated.inc.php';
include '../../../../includes/session.inc.php';
include './../../function.php';
$incident_id = $_GET['incident_id'];

// Query the database to get the resident name for the selected incident_id
$complainants = getIncidentComplainant($pdo, $incident_id);
$offenders = getIncidentOffender($pdo, $incident_id);

// Combine the data and prepare the response
$responseData = array(
    "success" => true,
    "complainants" => array(),
    "offenders" => array(),
);

foreach ($complainants as $row) {
    $comp = $row["firstname"] . " " . $row["middlename"] . " " . $row["lastname"];
    // Add each complainant to the "complainants" array in the response
    $responseData["complainants"][] = $comp;
}

foreach ($offenders as $row) {
    $off = $row["firstname"] . " " . $row["middlename"] . " " . $row["lastname"];
    // Add each offender to the "offenders" array in the response
    $responseData["offenders"][] = $off;
}

// if (isset($incident_id)) {
//     $o_name = "$row[firstname] $row[middlename] $row[lastname]";
//     $c_name = "$row[firstname] $row[middlename] $row[lastname]";
//     $response = array("success" => true, "residentName" => $o_name);
//     // $o_response = array("success" => true, "residentName" => $o_name);
//     // $c_response = array("success" => true, "residentName" => $c_name);
// } else {
//     $response = array("success" => false);
// }

header('Content-Type: application/json');

echo json_encode($responseData);
