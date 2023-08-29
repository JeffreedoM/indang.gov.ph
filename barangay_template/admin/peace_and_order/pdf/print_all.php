<?php
require_once '../../../../vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../includes/function.php';

$officials = getBrgyOfficials($pdo, $barangayId);
$secretary = $officials['secretary']['firstname'] . ' ' . strtoupper($officials['secretary']['middlename'][0]) . '. ' . $officials['secretary']['lastname'] . $officials['secretary']['suffix'];
$captain = !empty($officials['captain']) ? $officials['captain']['firstname'] . ' ' . strtoupper($officials['captain']['middlename'][0]) . '. ' . $officials['captain']['lastname'] . $officials['captain']['suffix'] : '';
$b_name = $barangay['b_name'];

// for the link of Barangay Logo
$logo = "../../../../admin/assets/images/uploads/barangay-logos/$barangay[b_logo]";
$city_logo = "../../../../admin/assets/images/$municipality_logo";
$name = "All Incident Reports";

//Selecting resident offender
$sql = "SELECT * FROM resident WHERE barangay_id = $barangayId ORDER BY lastname ASC";

$sql = "SELECT DISTINCT r.*
FROM resident r
INNER JOIN incident_offender io ON io.resident_id = r.resident_id
WHERE r.barangay_id = $barangayId
";


$query = $pdo->prepare($sql);
$query->execute();
$allReports = $query->fetchAll(PDO::FETCH_ASSOC);


// New mPDF
$pdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'orientation' => 'L',
    'format' => 'Legal',
]);

// Define your HTML header content
$headerHTML = "
<div style='font-size:10pt;text-align: center; font-family: Times; line-height: 1.5;'>
    Republic of the Philippines
    <div style='margin-top: .5px;'>Province of Cavite</div>
    <div style='margin-top: .5px;'>Municipality of Indang</div>
    <div style='margin-top: .5px;'>Barangay $b_name</div>
</div>
";

// Set the HTML header
$style = '
<style>
    body {
        font-size: 10pt;
        text-align: center;
        font-family: Times;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid black;
        text-align: left;
        padding: 5px;
    }
    th {
        background-color: #808080;
    }
</style>
';

//PDF content
$pdfHeader = '

<table style="margin-top: 1rem;">
    <tr>
        <th>Name of Offender</th>
        <th width="5%">Sex</th>
        <th>Contact</th>
        <th>Address</th>
        <th colspan="4" style="text-align:center;">Incident Details</th>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <th>Case</th>
        <th>Incident No./Title</th>
        <th>Status</th>
        <th>Date of Incident</th>
    </tr>
';

$pdfContent = "<h4 style='margin-top: 2rem;'>All Incident Reports</h4>" . $style .  $pdfHeader;


foreach ($allReports as $list) {
    $contact = !empty($list['contact']) ? $list['contact'] : 'N/A';
    $suffix = !empty($list['suffix'] != '') ?  "  ($list[suffix])" : "";
    $pdfContent .=  "<tr>";
    $pdfContent .=  "<td>$list[lastname], $list[firstname] $list[middlename]$suffix</td>";
    $pdfContent .=  "<td>$list[sex]</td>";
    $pdfContent .=  "<td>$contact</td>";
    $pdfContent .=  "<td>$list[house] $list[street] $barangayName</td>";
    $pdfContent .=  "</tr>";

    $resident_id = $list['resident_id'];
    $incidents = getIncidentReports($pdo, $resident_id, $barangayId);

    $case = '';
    $incident_title = '';
    $date = '';
    $status = '';

    foreach ($incidents as $row) {
        $case .= $row['case_incident'] . "<br>";
        $incident_title .= $row['incident_id'] . " - " . $row['incident_title'] . "<br>";
        $status .= getStatusText($row['status']) . "<br>";
        $date .= date('F j, Y', strtotime($row['date_incident'])) . "<br>";
    }
    $pdfContent .=  "<td>$case</td>";
    $pdfContent .=  "<td>$incident_title</td>";
    $pdfContent .=  "<td>$status</td>";
    $pdfContent .=  "<td>$date</td>";
}

$pdfContent .= "</table>";

// Add a new page
$pdf->AddPage();
$pdf->SetY(10);
$pdf->WriteHTML($headerHTML);
// Logo positioning
$pageWidth = $pdf->w;
$logoPos = ($pageWidth / 2);
$pdf->Image($logo, $logoPos - 45, 10, 20, 20);
$pdf->Image($city_logo, $logoPos + 25, 10, 20, 20);
// You can also add the city logo here using similar code


$pdf->SetY(30);
// Add content to the page
$pdf->WriteHTML($pdfContent);

// Define the HTML content for the footer
$footerHtml = '
<div style="margin-top:10px">
<div>Prepared By:</div>
<br>
<div>
<div>
' . $secretary . '
<div style="
width: 200px; 
background-color: black;
margin: 0 auto;
margin-bottom: 5px;
"></div> 
<div style="font-size:10px">
<i>(Printed name and signature)</i><br>
<b>Barangay Secretary</b></div>
<br>
</div>

<div>
' . $captain . '
<div style="
width: 200px; 
background-color: black;
margin: 0 auto;
margin-bottom: 5px;
"></div>
<div style="font-size:10px">
<i>(Printed name and signature)</i><br>
<b>Barangay Captain</b></div>
</div>
</div>
</div>
';

// Set the HTML footer for all pages
$pdf->WriteHTML($footerHtml);

$pdf->SetTitle($name);

$pdf->Output($name . '.pdf', 'I');
