<?php
require 'vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../function.php';
require('justification.php');

$logo = "../../../../admin/assets/images/uploads/barangay-logos/$barangay[b_logo]";
$cert = $pdo->query("SELECT * FROM report_certificate WHERE barangay_id = $barangayId")->fetchAll();
$brgy = $barangay['b_name'];
$officials = getBrgyOfficials($pdo, $barangayId);
$secretary = $officials['secretary']['firstname'] . ' ' . $officials['secretary']['lastname'];
$id = $_GET['view_id'];
if (isset($id)) {

    $stmt = $pdo->prepare("SELECT * FROM report_certificate WHERE barangay_id = $barangayId AND cert_id = :id ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $cert = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($cert as $row) {
        $name = $row['cert_name'];
        $capt = $row['capt'];
        $l_date = $row['Ldate'];
    }
}



// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);





$pdf->Image($logo, 14, 10, 35, 30);

$pdf->Image($logo, 160, 10, 33, 28);


// Logo
$pdf->Ln(3);

// Arial bold 15
$pdf->SetFont('Arial', '', 15);

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

$pdf->SetFont('Arial', 'B', 15);
$pdf->Ln(3);
$pdf->SetX($centerPos);
$pdf->Cell(0, 5, "BARANGAY $brgy", 5, 5, 'C');
$pdf->Ln(20);
$pdf->SetX($centerPos);
$pdf->Cell(0, 10, "OFFICE OF THE BARANGAY CHAIRMAN", 5, 5, 'C');

$pdf->SetLineWidth(0.1);
$pdf->Line(20, 50 + 20, 190, 50 + 20);
$pdf->Line(20, 51 + 20, 190, 51 + 20);

$pdf->Ln(20);
$pdf->SetX($centerPos);
$pdf->Cell(0, 5, "CERTIFICATE OF VALIDATION", 5, 5, 'C');
// Line break
$pdf->Ln(20);
$pdf->Cell(40, 0, "", 0, 0);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(60, 5, "THIS IS TO CERTIFY", 0, 0, 'FJ');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(80, 5, " that based on the Barangay", 0, 5, 'FJ');
$pdf->Ln(5);
$pdf->Cell(20, 0, "", 0, 0);
$pdf->Cell(200, 5, " Blotter Book, no complaint was received/ handled by this  ", 5, 5, 'FJ');
$pdf->Ln(5);
$pdf->Cell(24, 0, "", 0, 0);
$pdf->Cell(130, 5, "Barangay for the period of 01 to $l_date.", 5, 5, 'FJ');


$pdf->Ln(30);
$pdf->SetFont('Arial', 'BU', 15);
$pdf->Cell(300, 7, "$capt", 5, 5, 'C');
$pdf->Ln(3);
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(300, 5, "BARANGAY CAPTAIN", 5, 5, 'C');






$pdf->Output($name . '-report.pdf', 'I');
