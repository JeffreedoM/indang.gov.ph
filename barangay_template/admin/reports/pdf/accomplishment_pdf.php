<?php
require '../../../../vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../function.php';
require('includes/justification.php');

$id = $_GET['view_id'];

$brgy = $barangay['b_name'];

$logo = "../../../../admin/assets/images/uploads/barangay-logos/$barangay[b_logo]";
$city_logo = "../../../../admin/assets/images/$municipality_logo";

$officials = getBrgyOfficials($pdo, $barangayId);
$secretary = $officials['secretary']['firstname'] . ' ' . $officials['secretary']['lastname'];
$id = $_GET['view_id'];

if (isset($id)) {

    $stmt = $pdo->prepare("SELECT * FROM report_accomplishment WHERE barangay_id = $barangayId AND acc_id = :id ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $acc = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
foreach ($acc as $row) {
    $name = $row['acc_name'];
    $month = $row['month'];
    $year = $row['year'];
    $comt = 'None';
    $nr = $row['acc_content'];
}


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
$pdf->Cell(0, 10, "OFFICE OF THE SANGGUNIANG BARANGAY", 5, 5, 'C');

$pdf->SetLineWidth(0.1);
$pdf->Line(10, 68, 200, 68);
$pdf->Line(10, 69, 200, 69);

$pdf->Ln(15);
$pdf->SetFont('Times', '', 15);
$pdf->Cell(200, 5, "ACCOMPLISHMENT REPORT FOR $month, $year ", 0, 1, 'C');

$pdf->SetFont('Times', '', 12);
$pdf->Ln(10);
$content = "\t  $nr";
$pdf->Justify($content, 190, 6);

$pdf->SetTitle($name . ' No.' . $id);
$pdf->Output($name . ' No.' . $id . '.pdf', 'I');
