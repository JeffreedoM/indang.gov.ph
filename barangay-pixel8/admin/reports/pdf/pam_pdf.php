<?php
require 'vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../function.php';
require('justification.php');

$id = $_GET['view_id'];

$officials = getBrgyOfficials($pdo, $barangayId);
$secretary = $officials['secretary']['firstname'] . ' ' . $officials['secretary']['lastname'];
$captain = $officials['captain']['firstname'] . ' ' . $officials['captain']['lastname'];
$b_name = $barangay['b_name'];
$logo = "../../../../admin/assets/images/uploads/barangay-logos/$barangay[b_logo]";

if (isset($id)) {

    $stmt = $pdo->prepare("SELECT * FROM report_personnel_list WHERE barangay_id = $barangayId AND pam_id = :id ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $pam = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM report_personnel WHERE pam_id = :id ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $numRows = $stmt->rowCount();
    $personnel = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($pam as $row) {
        $name = $row['pam_title'];
        $n_name = $row['n_name'];
        $quarter = $row['quarter'];
        $date = $row['date'];
    }
}


class MyPDF extends FPDF
{

    // Override AddPage to add content to the body
    function AddPage($orientation = '', $size = '', $rotation = 0)
    {
        parent::AddPage($orientation, $size, $rotation);

        // Add some text
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Hello, World!', 0, 1);
    }
    // Page header
    function Header()
    {
        global $id, $secretary, $b_name, $captain,
            $pam, $personnel, $numRows;
        foreach ($pam as $row) {


            $n_name = $row['n_name'];
            $quarter = $row['quarter'];
            $date = $row['date'];
        }

        // Arial bold 15
        $this->SetFont('Arial', 'B', 12);
        // Move to the right


        // Title
        $this->Cell(335, 15, "PERSONNEL ATTENDANCE MONITORING", 0, 0, 'C');
        $this->Cell(1, 5, "", 0, 1, 'C');
        $this->Cell(336, 20, "Attendance Monitoring Form 1A", 0, 0, 'C');
        $this->Cell(1, 10, "", 0, 1, 'C');
        $this->Cell(336, 14, "For The " . $quarter . " Quarter", 0, 1, 'C');
        $this->Cell(1, 9, "", 0, 1, 'C');
        $this->Cell(20, 1, "", 0, 0, 'C');

        $this->Cell(1, 0, "", 0, 1, 'C');

        $this->Cell(20, 1, "", 0, 0, 'C');
        $this->Cell(52, 30, "", 1, 0, 'C');
        $this->Cell(52, 30, "", 1, 0, 'C');
        $this->Cell(106, 30, "", 1, 0, 'C');
        $this->Cell(40, 30, "", 1, 0, 'C');
        $this->Cell(49, 30, "", 1, 0, 'C');
        $this->Cell(1, 0, "", 0, 1, 'C');

        $this->Cell(20, 1, "", 0, 0, 'C');
        $this->Cell(52, 9, "LGU (Province, City,", 0, 0, 'C');
        $this->Cell(52, 9, "Name of Non-", 0, 0, 'C');
        $this->Cell(106, 9, "Nature of Non-Compliance(3)", 1, 0, 'C');
        $this->Cell(90, 9, "", 0, 1, 'C');

        $this->Cell(20, 1, "", 0, 0, 'C');
        $this->Cell(52, 10, "Municipality, Barangay", 0, 0, 'C');
        $this->Cell(52, 10, "Compliant Personnel", 0, 0, 'C');
        $this->Cell(53, 21, "", 1, 0, 'C');
        $this->Cell(53, 10, "Habitual", 0, 0, 'C');
        $this->Cell(40, 10, "Station", 0, 0, 'C');
        $this->Cell(49, 10, "Position/Designation", 0, 0, 'C');
        $this->Cell(1, 1, "", 0, 1, 'C');


        $this->Cell(124, 9, "", 0, 0, 'C');
        $this->Cell(53, 9, "Habitual", 0, 0, 'C');
        $this->Cell(139, 10, "", 0, 0, 'C');
        $this->Cell(1, 9, "", 0, 1, 'C');


        $this->Cell(20, 1, "", 0, 0, 'C');
        $this->Cell(52, 10, "(1)", 0, 0, 'C');
        $this->Cell(52, 10, "(2)", 0, 0, 'C');
        $this->Cell(53, 10, "Absenteeism", 0, 0, 'C');
        $this->Cell(53, 10, "Tardiness", 0, 0, 'C');
        $this->Cell(40, 10, "(4)", 0, 0, 'C');
        $this->Cell(49, 10, "(5)", 0, 0, 'C');
        $this->Cell(1, 11, "", 0, 1, 'C');
    }


    function Footer()
    {
        global $secretary, $captain, $n_name;
        $this->SetFont('Arial', 'B', 12);
        $this->SetY(-40);
        $this->Ln(4);
        $this->Cell(20, 5, "", 0, 0, 'C');
        $this->Cell(170, 0, "Prepared by:", 0, 0);
        $this->Cell(150, 0, "Submitted by:", 0, 0);


        $this->SetFont('Arial', 'BU', 12);
        $this->Ln(15);
        $this->Cell(20, 5, "", 0, 0, 'C');
        $this->Cell(170, 0, "$secretary", 0, 0);
        $this->Cell(150, 0, "$captain", 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Ln(6);
        $this->Cell(20, 5, "", 0, 0, 'C');
        $this->Cell(170, 0, "Kalihim", 0, 0);
        $this->Cell(150, 0, "Punong Barangay", 0, 0);
        $this->SetFont('Arial', 'BU', 12);
        $this->Cell(20, 25, "", 0, 1, 'C');
        $this->Cell(300, 10, "" . $n_name . "", 0, 1, 'C');
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(300, 0, "Mayor", 0, 1, 'C');
    }
}

// Instanciation of inherited class

$pdf = new PDF('L', 'mm', 'legal');

$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

//header
// Arial bold 15
$pdf->SetFont('Arial', 'B', 12);
// Move to the right
$pdf->Image($logo, 25, 10, 35, 30);
$pdf->Image($logo, 290, 10, 35, 30);

// Title
$pdf->Cell(335, 15, "PERSONNEL ATTENDANCE MONITORING", 0, 0, 'C');
$pdf->Cell(1, 5, "", 0, 1, 'C');
$pdf->Cell(336, 20, "Attendance Monitoring Form 1A", 0, 0, 'C');
$pdf->Cell(1, 10, "", 0, 1, 'C');
$pdf->Cell(336, 14, "For The " . $quarter . " Quarter", 0, 1, 'C');
$pdf->Cell(1, 9, "", 0, 1, 'C');
$pdf->Cell(20, 1, "", 0, 0, 'C');

$pdf->Cell(1, 0, "", 0, 1, 'C');

$pdf->Cell(20, 1, "", 0, 0, 'C');
$pdf->Cell(52, 30, "", 1, 0, 'C');
$pdf->Cell(52, 30, "", 1, 0, 'C');
$pdf->Cell(106, 30, "", 1, 0, 'C');
$pdf->Cell(40, 30, "", 1, 0, 'C');
$pdf->Cell(49, 30, "", 1, 0, 'C');
$pdf->Cell(1, 0, "", 0, 1, 'C');

$pdf->Cell(20, 1, "", 0, 0, 'C');
$pdf->Cell(52, 9, "LGU (Province, City,", 0, 0, 'C');
$pdf->Cell(52, 9, "Name of Non-", 0, 0, 'C');
$pdf->Cell(106, 9, "Nature of Non-Compliance(3)", 1, 0, 'C');
$pdf->Cell(90, 9, "", 0, 1, 'C');

$pdf->Cell(20, 1, "", 0, 0, 'C');
$pdf->Cell(52, 10, "Municipality, Barangay", 0, 0, 'C');
$pdf->Cell(52, 10, "Compliant Personnel", 0, 0, 'C');
$pdf->Cell(53, 21, "", 1, 0, 'C');
$pdf->Cell(53, 10, "Habitual", 0, 0, 'C');
$pdf->Cell(40, 10, "Station", 0, 0, 'C');
$pdf->Cell(49, 10, "Position/Designation", 0, 0, 'C');
$pdf->Cell(1, 1, "", 0, 1, 'C');


$pdf->Cell(124, 9, "", 0, 0, 'C');
$pdf->Cell(53, 9, "Habitual", 0, 0, 'C');
$pdf->Cell(139, 10, "", 0, 0, 'C');
$pdf->Cell(1, 9, "", 0, 1, 'C');


$pdf->Cell(20, 1, "", 0, 0, 'C');
$pdf->Cell(52, 10, "(1)", 0, 0, 'C');
$pdf->Cell(52, 10, "(2)", 0, 0, 'C');
$pdf->Cell(53, 10, "Absenteeism", 0, 0, 'C');
$pdf->Cell(53, 10, "Tardiness", 0, 0, 'C');
$pdf->Cell(40, 10, "(4)", 0, 0, 'C');
$pdf->Cell(49, 10, "(5)", 0, 0, 'C');
$pdf->Cell(1, 11, "", 0, 1, 'C');



//list of table
if ($numRows > 0) {
    foreach ($personnel as $list) {

        $pdf->Cell(20, 1, "", 0, 0, 'C');
        $pdf->Cell(52, 10, "" . $b_name . "", 1, 0, 'C');
        $pdf->Cell(52, 10, "" . $list['nonComp_name'] . "", 1, 0, 'C');
        $pdf->Cell(53, 10, "" . $list['nonComp_absent'] . "", 1, 0, 'C');
        $pdf->Cell(53, 10, "" . $list['nonComp_tardy'] . "", 1, 0, 'C');
        $pdf->Cell(40, 10, "" . $list['station'] . "", 1, 0, 'C');
        $pdf->Cell(49, 10, "" . $list['position'] . "", 1, 0, 'C');
        $pdf->Cell(1, 10, "", 0, 1, 'C');
    }
    if ($numRows < 7) {
        for ($i = $numRows; $i < 7; $i++) {


            $pdf->Cell(20, 1, "", 0, 0, 'C');
            $pdf->Cell(52, 10, "", 1, 0, 'C');
            $pdf->Cell(52, 10, "", 1, 0, 'C');
            $pdf->Cell(53, 10, "", 1, 0, 'C');
            $pdf->Cell(53, 10, "", 1, 0, 'C');
            $pdf->Cell(40, 10, "", 1, 0, 'C');
            $pdf->Cell(49, 10, "", 1, 0, 'C');
            $pdf->Cell(1, 10, "", 0, 1, 'C');
        }
    }
} else {

    for ($i = 0; $i < 7; $i++) {

        $pdf->Cell(20, 1, "", 0, 0, 'C');
        $pdf->Cell(52, 10, "", 1, 0, 'C');
        $pdf->Cell(52, 10, "", 1, 0, 'C');
        $pdf->Cell(53, 10, "", 1, 0, 'C');
        $pdf->Cell(53, 10, "", 1, 0, 'C');
        $pdf->Cell(40, 10, "", 1, 0, 'C');
        $pdf->Cell(49, 10, "", 1, 0, 'C');
        $pdf->Cell(1, 10, "", 0, 1, 'C');
    }
}
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(10);
$pdf->Cell(20, 5, "", 0, 0, 'C');
$pdf->Cell(210, 10, "Prepared by:", 0, 0);
$pdf->Cell(150, 10, "Submitted by:", 0, 0);


$pdf->SetFont('Arial', 'BU', 12);
$pdf->Ln(15);
$pdf->Cell(20, 5, "", 0, 0, 'C');
$pdf->Cell(210, 0, "$secretary", 0, 0);
$pdf->Cell(150, 0, "$captain", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(6);
$pdf->Cell(20, 5, "", 0, 0, 'C');
$pdf->Cell(210, 0, "Kalihim", 0, 0);
$pdf->Cell(150, 0, "Punong Barangay", 0, 0);

$pdf->SetFont('Arial', 'BU', 12);
$pdf->Cell(20, 6, "", 0, 1, 'C');
$pdf->Cell(340, 10, "" . $n_name . "", 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(340, 0, "Mayor", 0, 1, 'C');



$pdf->Output($name . '-report.pdf', 'I');
