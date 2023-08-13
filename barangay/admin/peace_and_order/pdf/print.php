<?php
require_once '../../../../vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../includes/function.php';

$officials = getBrgyOfficials($pdo, $barangayId);
$secretary = $officials['secretary']['firstname'] . ' ' . $officials['secretary']['lastname'];
$captain = !empty($officials['captain']) ? $officials['captain']['firstname'] . ' ' . $officials['captain']['lastname'] : '';
$incident_id = $_GET['print_id'];
$b_name = $barangay['b_name'];
$city_logo = "../../../../admin/assets/images/$municipality_logo";
$logo = "../../../../admin/assets/images/uploads/barangay-logos/$barangay[b_logo]";

$incidents = getIncidentsByBarangayId($incident_id, $barangayId, $pdo);
$complainants = getIncidentComplainant($pdo, $incident_id);
$offenders = getIncidentOffender($pdo, $incident_id);
foreach ($incidents as $list) {
    $case = $list['case_incident'];
    $title = $list['incident_title'];
    $date = $list['date_incident'];
    $time = $list['time_incident'];
    $location = $list['location'];
    $narr = $list['narrative'];
    $json_narr = json_decode($narr, true);
    $date_r = $list['date_reported'];
}

$pdf = new \Mpdf\Mpdf();

$paperSize = 'A4';

$pdf->AddPageByArray([
    'orientation' => 'P', // 'P' for portrait or 'L' for landscape
    'sheet-size' => $paperSize,
]);

//define new alias for total page numbers
$pdf->AliasNbPages('{pages}');

$pdf->SetAutoPageBreak(true, 15);

$pdf->WriteHTML("
<h4 style='text-align:center; font-family: Times'>
Republic of the Philippines
<br>
Province of Cavite
<br>
Municipality of Indang
<br>
Barangay $b_name
</h4>
");

$pdf->Cell(12);

//page width size center
$pageWidth = 210;
$cellWidth = 185;
$centerPos = ($pageWidth - $cellWidth) / 2;

// logo
$logoPos = ($pageWidth  / 2);
$pdf->Image($logo, $logoPos - 55, 15, 20, 20);
$pdf->Image($city_logo, $logoPos + 35, 15, 20, 20);

$pdf->Ln(5);

$pdf->Line(10, 48, 200, 48);
$pdf->Line(10, 50, 200, 50);

//INCIDENT REPORT
$pdf->SetFont('Times', 'B', 20);
$pdf->Cell(0, 6, 'CERTIFICATE', 0, 1, 'C');

$pdf->Ln(4);
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 6, 'Incident Case Report', 0, 1, 'C');

$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 6, 'FOR RECORD: ', 0, 0);
$pdf->SetX(65);
$pdf->SetFont('Times', '', 11);
$pdf->Cell(10, 6, $title, 0, 1);

$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 6, 'Entry No: ', 0, 0);
$pdf->SetX(65);
$pdf->SetFont('Times', '', 11);
$pdf->Cell(0, 6, $incident_id, 0, 1);

$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 6, 'Location: ', 0, 0);
$pdf->SetX(65);
$pdf->SetFont('Times', '', 11);
$pdf->Cell(0, 6, $location, 0, 1);

$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 6, 'Date & Time Reported: ', 0, 0);

$pdf->SetX(65);
$pdf->SetFont('Times', '', 11);
$pdf->Cell(0, 6, $date_r, 0, 1);


//LIST OF COMPLAINANT
$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 5, 'COMPLAINANT/REPORT PERSON', 0, 1);

$pdf->SetFont('Times', 'B', 11);
// Set the fill color and stroke color to gray
$pdf->SetFillColor(128, 128, 128);
$pdf->SetDrawColor(128, 128, 128);
$pdf->Cell(45, 5, 'Name', 1, 0, '', true);
$pdf->Cell(20, 5, 'Sex', 1, 0, '', true);
$pdf->Cell(30, 5, 'Phone No.', 1, 0, '', true);
$pdf->Cell(40, 5, 'Birthdate', 1, 0, '', true);
$pdf->Cell(55, 5, 'Address', 1, 1, '', true);

$pdf->SetFont('Times', '', 11);
$pdf->SetDrawColor(128, 128, 128);

foreach ($complainants as $list) {
    $name = !empty($list['firstname']) || !empty($list['lastname'])
        ? $list['firstname'] . ' ' . $list['lastname']
        : $list['non_res_firstname'] . ' ' . $list['non_res_lastname'];
    $gender = !empty($list['sex']) ? $list['sex'] : $list['non_res_gender'];
    $contact = !empty($list['contact']) ? $list['contact'] : $list['non_res_contact'];
    $birthdate = !empty($list['birthdate']) ? $list['birthdate'] : $list['non_res_birthdate'];
    $address = !empty($list['house'] || $list['street']) ? "$list[house] $list[street] $barangayName" : $list['non_res_address'];

    $pdf->Cell(45, 5, " $name", 'LR', 0);
    $pdf->Cell(20, 5, " $gender", 'LR', 0);
    $pdf->Cell(30, 5, !empty($contact) ? " $contact" : " N/A", 'LR', 0);
    $pdf->Cell(40, 5, date(' F j, Y', strtotime($birthdate)), 'LR', 0);
    if ($pdf->GetStringWidth($address) > 50) {
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(55, 5, " $address", 'LR', 1);
        $pdf->SetFont('Times', '', 11);
    } else {
        $pdf->Cell(55, 5, " $address", 'LR', 1);
    }

    //add table's bottom line
    $pdf->Cell(190, 0, '', 'T', 1, '', true);
}




//LIST OF OFFENDER
$pdf->Ln(8);
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 5, 'OFFENDER PERSON', 0, 1);
// Set the fill color and stroke color to gray
$pdf->SetFillColor(128, 128, 128);
$pdf->SetDrawColor(128, 128, 128);


$pdf->SetFont('Times', '', 11);
$pdf->SetDrawColor(128, 128, 128);

foreach ($offenders as $list) {
    $name = !empty($list['firstname']) || !empty($list['lastname'])
        ? $list['firstname'] . ' ' . $list['lastname']
        : $list['non_res_firstname'] . ' ' . $list['non_res_lastname'];
    $gender = !empty($list['sex']) ? $list['sex'] : $list['non_res_gender'];
    $contact = !empty($list['contact']) ? $list['contact'] : $list['non_res_contact'];
    $birthdate = !empty($list['birthdate']) ? $list['birthdate'] : $list['non_res_birthdate'];
    $address = !empty($list['house'] || $list['street']) ? "$list[house] $list[street] $barangayName" : $list['non_res_address'];

    $pdf->Ln(5);
    $pdf->SetFont('Times', 'B', 11);
    $pdf->Cell(30, 5, "Name:", 0, 0, '');
    $pdf->SetFont('Times', '', 11);
    $pdf->Cell(0, 5, $name, 0, 1);

    $pdf->Cell(30, 5, 'Gender:', 0, 0, '');
    $pdf->SetFont('Times', '', 11);
    $pdf->Cell(0, 5, $gender, 0, 1);

    $pdf->Cell(30, 5, 'Phone No.:', 0, 0, '');
    $pdf->SetFont('Times', '', 11);
    $pdf->Cell(0, 5, !empty($contact) ? $contact : "N/A", 0, 1);

    $pdf->Cell(30, 5, 'Birthdate:', 0, 0, '');
    $pdf->SetFont('Times', '', 11);
    $pdf->Cell(0, 5, date('F j, Y', strtotime($birthdate)), 0, 1);

    $pdf->Cell(30, 5, 'Address:', 0, 0, '');
    $pdf->SetFont('Times', '', 11);
    $pdf->Cell(0, 5, $address, 0, 1);

    $pdf->Cell(30, 5, 'Description:', 0, 0);
    $pdf->SetFont('Times', '', 11);
    $pdf->MultiCell(0, 5, $list['desc'], 0, 1);

    $pdf->SetFont('Times', '', 11);

    //add table's bottom line
    $pdf->Cell(190, 0, '', 'T', 1, '', true);
}

$pdf->AddPage();

$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 5, "NARRATIVE:", 0, 1, "");
$pdf->SetFont('Times', '', 11);

$pdf->WriteHTML($json_narr[0]);
for ($i = 1; $i < count($json_narr); $i++) {
    $pdf->Cell(0, 5, "", 0, 1, "");
    $pdf->SetFont('Times', 'B', 11);
    $pdf->Cell(0, 5, "$i.", 0, 1, "");
    $pdf->SetFont('Times', '', 11);
    $pdf->WriteHTML($json_narr[$i]);
}

$pdf->SetFont('Times', '', 8);
$pdf->Ln(5);
$pdf->SetY(-25);
$pdf->Cell(0, 5, 'Prepared By: ' . $secretary, 0, 1);
$pdf->Cell(0, 5, 'Barangay Captain: ' . $captain, 0, 0);


$pdf->SetTitle('Incident Case No.' . $incident_id);

$pdf->Output('Incident Case No.' . $incident_id . '.pdf', 'I');
