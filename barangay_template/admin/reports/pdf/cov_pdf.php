<?php
require '../../../../vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../function.php';
require('includes/justification.php');

$logo = "../../../../admin/assets/images/uploads/barangay-logos/$barangay[b_logo]";
$city_logo = "../../../../admin/assets/images/$municipality_logo";
$cert = $pdo->query("SELECT * FROM report_certificate WHERE barangay_id = $barangayId")->fetchAll();
$brgy = $barangay['b_name'];
$officials = getBrgyOfficials($pdo, $barangayId);
$secretary = $officials['secretary']['firstname'] . ' ' . strtoupper($officials['secretary']['middlename'][0]) . ' ' . $officials['secretary']['lastname'];
$id = $_GET['view_id'];
if (isset($id)) {

    $stmt = $pdo->prepare("SELECT * FROM report_certificate WHERE barangay_id = $barangayId AND cert_id = :id ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $cert = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($cert as $row) {
        $name = $row['cert_name'];
        $capt = $row['capt'];
        $date = $row['date'];
        $person = $row['person'];
    }
}



// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);





// logo of barangay and municipal
$pdf->Image($logo, 20, 10, 30, 30);
$pdf->Image($city_logo, 160, 10, 30, 30);


// Logo
$pdf->Ln(3);

// Times bold 15
$pdf->SetFont('Times', '', 15);

// Title

// Get page width
$pageWidth = $pdf->GetPageWidth();

// Calculate horizontal center position
$cellWidth = 190; // Width of the cell
$centerPos = ($pageWidth - $cellWidth) / 2;

$pdf->SetX($centerPos);
$pdf->Cell(0, 6, "Republic of the Philippines", 0, 5, 'C');
$pdf->SetX($centerPos); // Set X position to center position
$pdf->Cell(0, 6, "Department of Interior & Local Government", 5, 5, 'C');

// Get page width
$pageWidth = $pdf->GetPageWidth();

// Calculate horizontal center position
$cellWidth = 185; // Width of the cell
$centerPos = ($pageWidth - $cellWidth) / 2;

$pdf->SetX($centerPos); // Set X position to center position
$pdf->Cell(0, 6, "Province of Cavite", 5, 5, 'C');

$pdf->SetFont('Times', 'B', 15);
$pdf->Ln(3);
$pdf->SetX($centerPos);
$pdf->Cell(0, 5, "BARANGAY $brgy", 5, 5, 'C');
$pdf->Ln(20);
$pdf->SetX($centerPos);
$pdf->Cell(0, 10, "OFFICE OF THE BARANGAY CHAIRMAN", 5, 5, 'C');

$pdf->SetLineWidth(0.1);
$pdf->Line(10, 68, 200, 68);
$pdf->Line(10, 69, 200, 69);

$pdf->Ln(15);
$pdf->SetX($centerPos);
$pdf->Cell(0, 5, "CERTIFICATE OF VALIDATION", 5, 5, 'C');
// Line break
$pdf->Ln(10);

$pdf->SetFont('Times', '', 15);
$content = "\t       THIS IS TO CERTIFY that based on the Barangay Blotter Book, no complaint was received/ handled by this Barangay for the period of $date.";

$pdf->Justify($content, 190, 6);

$pdf->Ln(20);
$pdf->SetFont('Times', 'B', 15);
$pdf->Cell(80, 0, "$person", 5, 5, 'C');
$pdf->Cell(80, 1, "________________________", 5, 5, 'C');
$pdf->SetFont('Times', '', 11);
$pdf->Cell(80, 10, "(Printed name and signature)", 5, 5, 'C');
$pdf->SetFont('Times', '', 15);
$pdf->Cell(80, 5, "NAME OF APPLICANT", 5, 5, 'C');

$pdf->Ln(30);
$pdf->SetFont('Times', '', 11);
$pdf->Cell(260, 5, "Approved by:", 5, 5, 'C');
$pdf->Ln(6);
$pdf->SetFont('Times', 'B', 15);
$pdf->Cell(300, 0, "$capt", 5, 5, 'C');
$pdf->Cell(300, 1, "________________________", 5, 5, 'C');
$pdf->SetFont('Times', '', 11);
$pdf->Cell(300, 10, "(Printed name and signature)", 5, 5, 'C');

$pdf->SetFont('Times', '', 15);
$pdf->Cell(300, 5, "BARANGAY CAPTAIN", 5, 5, 'C');

$pdf->SetTitle($name . ' No.' . $id);

$pdf->Output($name . ' No.' . $id . '.pdf', 'I');
