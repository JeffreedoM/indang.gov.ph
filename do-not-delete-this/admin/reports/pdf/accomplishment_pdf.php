<?php
require 'vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../function.php';
require('justification.php');

$brgy = $barangay['b_name'];
$logo = $barangay['b_logo'];
$officials = getBrgyOfficials($pdo);
$secretary = $officials['secretary']['firstname'] . ' ' . $officials['secretary']['lastname'];
$id = $_GET['view_id'];
if (isset($id)) {

    $stmt = $pdo->prepare("SELECT * FROM report_accomplishment WHERE acc_id = :id ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $acc = $stmt->fetchAll(PDO::FETCH_ASSOC);
}



$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);


// $pdf->Image($tmp_file);

$pdf->Image('logo.jpg', 12, 10, 34, 29);

$pdf->Image('logo.jpg', 160, 10, 33, 28);



foreach ($acc as $row)
    $name = $row['acc_name'];
$month = $row['month'];
$year = $row['year'];
$comt = 'None';
$nr = $row['acc_content'];
// Logo
$pdf->Ln(3);
// Arial bold 15
$pdf->SetFont('Arial', '', 12);
// Move to the right
$pdf->Cell(80);


// Title
$pdf->Cell(200, 5, "", 0, 1, 'C');
$pdf->Cell(200, 5, "Republic of the Philippines", 0, 1, 'C');
$pdf->Cell(200, 5, "Province of Cavite", 0, 1, 'C');
$pdf->Cell(200, 5, "Municipality of Indang", 0, 1, 'C');
$pdf->Ln(2);
$pdf->Cell(200, 5, "BARANGAY $brgy", 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(200, 15, "OFFICE OF THE SANGGUNIANG BARANGAY", 0, 1, 'C');
$pdf->Cell(190, 0, "", 1, 1);
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(200, 5, "ACCOMPLISHMENT REPORT FOR $month, $year ", 0, 1, 'C');
$pdf->Ln(5);
if ($comt != "None") {

    $pdf->Cell(200, 5, "Committee on $comt", 0, 0, 'C');
}
$pdf->Ln(15);
$pdf->Cell(10, 2, "", 0, 1, 'FJ');
// $pdf->MultiCell(170, 6, "$nr", 0, 1, 'FJ');

$pdf->Justify($nr, 190, 6);


$pdf->Output($name . '.pdf', 'I');
