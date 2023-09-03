<?php
require_once '../../../../vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../includes/function.php';

$officials = getBrgyOfficials($pdo, $barangayId);
$secretary = $officials['secretary']['firstname'] . ' ' . $officials['secretary']['middlename'] . $officials['secretary']['lastname'] . $officials['secretary']['suffix'];
$captain = !empty($officials['captain']) ? $officials['captain']['firstname'] . ' ' . $officials['captain']['middlename'] . $officials['captain']['lastname'] . $officials['captain']['suffix'] : '';
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
// formating the date reported
$datetime = new DateTime($date_r);
$r_date = $datetime->format('F j, Y');
$r_time = $datetime->format('h:i A');

// selecting incident history for hearing status and date
$stmt = $pdo->prepare("SELECT * FROM incident_history WHERE incident_id = :incident_id");
$stmt->bindParam(':incident_id', $incident_id);
$stmt->execute();
$history = $stmt->fetchAll();

foreach ($history as $list) {
    $hearing_date = json_decode($list['hearing_status'], true);
    $hearing_status = json_decode($list['status_input'], true);
}


// Start generating PDF
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
<div style='font-size:10pt;text-align: center; font-family: Times; line-height: 1.5;'>
    Republic of the Philippines
    <div style='margin-top: .5px;'>Province of Cavite</div>
    <div style='margin-top: .5px;'>Municipality of Indang</div>
    <div style='margin-top: .5px;'>Barangay $b_name</div>
</div>
");

$pdf->Cell(12);

//page width size center
$pageWidth = 210;
$cellWidth = 185;
$centerPos = ($pageWidth - $cellWidth) / 2;

// logo
$logoPos = ($pageWidth  / 2);
$pdf->Image($logo, $logoPos - 50, 15, 20, 20);
$pdf->Image($city_logo, $logoPos + 30, 15, 20, 20);

$pdf->Ln(5);

$pdf->Line(10, 53, 200, 53);
$pdf->Line(10, 55, 200, 55);

//INCIDENT REPORT
$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 20);
$pdf->Cell(0, 6, 'INCIDENT REPORT', 0, 1, 'C');
// $pdf->Cell(0, 6, 'Incident Case Report', 0, 1, 'C');
$pdf->Ln(10);
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
$pdf->Cell(0, 6, "$r_date $r_time", 0, 1);


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
    $middlename = !empty($list['middlename']) ? (strtoupper($list['middlename'][0])) . '. ' : '';
    $name = !empty($list['firstname']) || !empty($list['lastname'])
        ? $list['firstname'] . ' ' . $middlename . $list['lastname']
        : $list['non_res_firstname'] . ' ' . $list['non_res_lastname'];
    $suffix = !empty($list['suffix'] != '') ?  "($list[suffix])" : "";
    $gender = !empty($list['sex']) ? $list['sex'] : $list['non_res_gender'];
    $contact = !empty($list['contact']) ? $list['contact'] : $list['non_res_contact'];
    $birthdate = !empty($list['birthdate']) ? $list['birthdate'] : $list['non_res_birthdate'];
    $address = !empty($list['house'] || $list['street']) ? "$list[house] $list[street] $barangayName" : $list['non_res_address'];

    if ($pdf->GetStringWidth($name . $suffix) > 45) {
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(45, 5, " $name $suffix", 'LR', 0);
        $pdf->SetFont('Times', '', 11);
    } else {
        $pdf->Cell(45, 5, " $name $suffix", 'LR', 0);
    }
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
    $middlename = !empty($list['middlename']) ? (strtoupper($list['middlename'][0])) . '.' : '';
    $name = !empty($list['firstname']) || !empty($list['lastname'])
        ? $list['firstname'] . ' ' . $middlename . ' ' . $list['lastname']
        : $list['non_res_firstname'] . ' ' . $list['non_res_lastname'];
    $suffix = !empty($list['suffix'] != '') ?  " ($list[suffix])" : "";
    $gender = !empty($list['sex']) ? $list['sex'] : $list['non_res_gender'];
    $contact = !empty($list['contact']) ? $list['contact'] : $list['non_res_contact'];
    $birthdate = !empty($list['birthdate']) ? $list['birthdate'] : $list['non_res_birthdate'];
    $address = !empty($list['house'] || $list['street']) ? "$list[house] $list[street] $barangayName" : $list['non_res_address'];

    $pdf->Ln(5);
    $pdf->SetFont('Times', 'B', 11);
    $pdf->Cell(30, 5, "Name:", 0, 0, '');
    $pdf->SetFont('Times', '', 11);
    $pdf->Cell(0, 5, $name . $suffix, 0, 1);

    $pdf->Cell(30, 5, 'Sex:', 0, 0, '');
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

// $pdf->AddPage();
$y = $pdf->y;
$pdf->SetY($y + 10);

$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 5, "NARRATIVE:", 0, 1, "");
$pdf->SetFont('Times', '', 11);

$pdf->WriteHTML($json_narr[0]);
for ($i = 1; $i < count($json_narr); $i++) {
    $pdf->Cell(0, 5, "", 0, 1, "");
    $pdf->SetFont('Times', 'B', 11);
    $pdf->Cell(0, 5, "$i.", 0, 1, "");
    $pdf->SetFont('Times', '', 11);
    $pdf->Cell(0, 5, "Status: " . $hearing_status[$i - 1], 0, 0, "");
    $pdf->SetX(155);
    $pdf->Cell(0, 5, "Date: " . $hearing_date[$i - 1], 0, 1, "");
    $pdf->Ln(5);
    $pdf->WriteHTML($json_narr[$i]);
}

// Define the HTML content for the footer

// $footerHtml = '

// <table width="100%" style="font-size: 10pt">
//     <tr>
//         <td style="padding-bottom: 10px;">
//             Prepared By:
//         </td>
//     </tr>
//     <tr>
//         <td><u>' . $secretary . '</u></td>
//         <td style="text-align: right; "><u>' . $captain . '</u></td>
//     </tr>
//     <tr>
//         <td height="20px" style="font-size: 10px; ">
//             <i>(Printed name and signature)</i>
//         </td>
//         <td style="font-size: 10px; text-align: right; ">
//         <i>(Printed name and signature)</i>
//         </td>
//     </tr>
//     <tr>
//         <td>Barangay Secretary</td>
//         <td style="text-align: right; ">Barangay Captain</td>
//     </tr>
// </table>


// ';

// $footerHtml = $style . $footerHtml;

// Set the HTML footer for all pages
// $pdf->WriteHTML($footerHtml);

$pdf->SetAutoPageBreak(true, 10);
$pdf->SetFont('Times', '', 8);
$y = $pdf->y;
$pdf->Line(15, $y + 5, 205, $y + 5);
$pdf->SetY($y + 10);
$pdf->Cell(130, 4, 'Prepared By: ', 0, 0);
$pdf->Cell(120, 4, 'Checked By: ', 0, 1);
$pdf->Ln(2);
$pdf->Cell(130, 4, 'Signature:_____________________________', 0, 0);
$pdf->Cell(120, 4, 'Signature:_____________________________', 0, 1);
$pdf->Cell(130, 4, 'Name: ' . $secretary, 0, 0);
$pdf->Cell(120, 4, 'Name: ' . $captain, 0, 1);
$pdf->Cell(130, 4, 'Position: Barangay Secretary', 0, 0);
$pdf->Cell(120, 4, 'Position: Barangay Captain', 0, 1);


$pdf->SetTitle('Incident Case No.' . $incident_id);

$pdf->Output('Incident Case No.' . $incident_id . '.pdf', 'I');
