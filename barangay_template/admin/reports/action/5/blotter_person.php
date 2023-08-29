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
    if (!empty($row['resident_id'])) {
        $suffix = !empty($row['suffix'] != '') ?  "  ($row[suffix])" : "";
        $comp = $row["firstname"] . " " . strtoupper($row['middlename'][0]) . ". " . $row["lastname"] . $suffix;
    } else {
        $comp = "$row[non_res_firstname] $row[non_res_lastname]";
    }
    // Add each complainant to the "complainants" array in the response
    $responseData["complainants"][] = $comp;
}

foreach ($offenders as $row) {
    $suffix = !empty($row['suffix'] != '') ?  "  ($row[suffix])" : "";
    if (!empty($row['resident_id'])) {
        $off = $row["firstname"] . " " . strtoupper($row['middlename'][0]) . ". " . $row["lastname"] . $suffix;
    } else {
        $off = "$row[non_res_firstname] $row[non_res_lastname]";
    }
    // Add each offender to the "offenders" array in the response
    $responseData["offenders"][] = $off;
}

header('Content-Type: application/json');

echo json_encode($responseData);
