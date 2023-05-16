<?php
require 'vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../function.php';
require('justification.php');

$id = $_GET['view_id'];


$brgy = $barangay['b_name'];
$logo = "../../../../admin/assets/images/uploads/barangay-logos/$barangay[b_logo]";
$officials = getBrgyOfficials($pdo, $barangayId);
$household = getR_familyCount($pdo, $barangayId);
$secretary = $officials['secretary']['firstname'] . ' ' . $officials['secretary']['lastname'];
$cap = $officials['captain']['firstname'] . ' ' . $officials['captain']['lastname'];

if (isset($id)) {


    //selecting report_clean up table 
    $stmt = $pdo->prepare("SELECT * FROM report_cleanup WHERE barangay_id = $barangayId AND mcu_id = :id ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $mcu = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //selecting report_cleanup_nstep table
    $stmt = $pdo->prepare("SELECT * FROM report_cleanup_nstep WHERE mcu_id = :id ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $nstep = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //selecting count all residents
    $totalPop = getResidentCount($pdo, $barangayId);

    //for select report_clean
    foreach ($mcu as $row) {
        $name = $row['mcu_name'];
        $quat = $row['mcu_quarter'];
        $year = $row['mcu_year'];
        $date = $row['mcu_date'];
        $cce = $row['commChairman'];
        $tcomp = $row['total_compliant'];
        $com_ave = $row['com_ave'];
        $mrf_b = $row['mrf_brngy'];
        $mrf_f = $row['mrf_fclty'];

        //fetch checks column binary for YES or NO
        $answer1 = ($row["checks"] & 1) ? "Yes" : "No";
        $answer2 = (($row["checks"] >> 1) & 1) ? "Yes" : "No";
        $answer3 = (($row["checks"] >> 2) & 1) ? "Yes" : "No";
        $answer4 = (($row["checks"] >> 3) & 1) ? "Yes" : "No";
    }
}




$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont("zapfdingbats", "B", "12");
$check_m = chr(52);
$pdf->SetFont("ARIAL", "B", "12");

$pdf->Image($logo, 14, 10, 35, 30);

$pdf->Image($logo, 160, 10, 33, 28);

$pdf->Cell(50, 5, "", 5, 5, '');
$pdf->Cell(50, 5, "", 5, 5, 'C');
$pdf->Cell(200, 5, "MANILA BAY CLEAN UP, REHABILITATION", 5, 5, 'C');
$pdf->Ln(1);
$pdf->Cell(200, 5, "AND PRESERVTION PROJECT", 5, 5, 'C');

$pdf->Cell(200, 5, "Quarter: $quat quarter Year: $year", 5, 5, 'C');
$pdf->Cell(50, 5, "", 5, 5, 'C');
$pdf->Cell(200, 5, "SOLID WASTE MANAGEMENT", 5, 5, 'C');
$pdf->Cell(50, 5, "", 5, 5, 'C');
$pdf->Cell(50, 5, "GENERAL INFORMATION", 5, 5, '');
$pdf->Cell(50, 5, "", 5, 5, 'C');

$pdf->Cell(50, 5, "Name of Barangay: $brgy", 5, 0, '');
$pdf->SetX(110);
$pdf->Cell(50, 5, "Municipality: Indang ", 5, 1, '');
$pdf->Cell(50, 5, "Provincial location: CAVITE", 5, 0, '');
$pdf->SetX(110);
$pdf->Cell(50, 5, "Regional location: IV-A (CALABARZON) ", 5, 1, '');
$pdf->Cell(50, 5, "Total Population: $totalPop", 5, 0, '');
$pdf->SetX(110);
$pdf->Cell(50, 5, "No: of Household: $household ", 5, 1, '');


$pdf->Ln(5);
$pdf->SetFont("ARIAL", "BU", "14");
$pdf->Cell(50, 5, "", 5, 5, 'C');
$pdf->Cell(50, 5, "MANDATORY SEGRAGATION OF WASTE AT SOURCE ", 5, 5, '');
$pdf->SetFont("ARIAL", "", "14");

//12
$pdf->Cell(50, 5, "", 5, 5, 'C');
$pdf->Cell(100, 5, "12. Determinne the compliance rate of the barangay. ", 5, 5, '');
$pdf->Cell(100, 5, "       3.1.Total number of households: $household ", 5, 5, '');
$pdf->Cell(100, 5, "       3.2.Total number of compliant of households: $tcomp ", 5, 5, '');
$pdf->Cell(100, 5, "       3.3.Computed average Use formula blow  $com_ave ", 5, 5, '');
$pdf->Cell(50, 5, "", 5, 5, 'C');

$pdf->Cell(100, 5, "_____x100", 5, 5, 'C');

//13
$pdf->Cell(50, 5, "", 5, 5, 'C');
$pdf->Cell(100, 5, "13.Based on the computed average, is the Barangay compliant?  ", 5, 5, '');
$pdf->Cell(100, 5, "if average is 70% or higher, tick yes", 5, 5, 'C');
$pdf->Cell(100, 5, "if average is 69% or higher, tick yes", 5, 5, 'C');
$pdf->Cell(50, 5, "", 5, 5, 'C');
//check answer1
$check = '/';
if ($answer1 === "Yes") {


    $pdf->Cell(100, 10, "   $check Yes      No", 0, 1, '');
} else {
    $pdf->Cell(100, 10, "Yes      $check No", 0, 1, '');
}
$pdf->SetFont("ARIAL", "B", "10");
$pdf->Cell(50, 5, "", 5, 5, 'C');
$pdf->Cell(100, 5, "*The barangay must reach a maximum rate of 70% to be considered as complaint", 5, 5, '');

$pdf->Cell(50, 5, "_________________________________________________________________________________________________________________________________________________________________________________", 5, 5, 'C');
$pdf->Cell(50, 5, "", 5, 5, 'C');
$pdf->SetFont("ARIAL", "B", "14");
$pdf->Cell(50, 5, "FUNCTIONAL MATERIALS RECOVERY FACILITY ", 5, 5, '');
$pdf->Cell(50, 5, "", 5, 5, 'C');

//14
$pdf->SetFont("ARIAL", "B", "12");
$pdf->Cell(50, 20, "14. Determine the compliance rate of the Barangay ", 0, 1, '');
$pdf->Cell(175, 15, "", 1, 0, 'C');
$pdf->Cell(20, 15, "$mrf_b", 1, 0, 'C');
$pdf->Cell(0, 0, "", 0, 1, 'C');

$pdf->Cell(175, 7, "Is there an existing MRF service the Barangay, whether Individual, cluster or    ", 0, 0);
$pdf->Cell(0, 7, "", 0, 1);
$pdf->Cell(175, 7, "municipal? (50%)", 0, 0);
$pdf->Cell(0, 8, "", 0, 1);
$pdf->Cell(175, 15, "", 1, 0, 'C');
$pdf->Cell(20, 15, "$mrf_f", 1, 0, 'C');
$pdf->Cell(0, 0, "", 0, 1, 'C');

$pdf->Cell(175, 7, "Does the existing MRF with an operational solid waste transfer station or sorting    ", 0, 0);
$pdf->Cell(0, 7, "", 0, 1);
$pdf->Cell(175, 7, "station, drop off center, a composting facility and a recyling facility? (50%)", 0, 0);
$pdf->Cell(0, 8, "", 0, 1);
$pdf->Cell(175, 7, "", 1, 0, 'C');
$pdf->Cell(20, 7, "", 1, 0, 'C');
$pdf->Cell(0, 0, "", 0, 1, 'C');
$pdf->Cell(175, 7, "TOTAL", 0, 0);
//total mrf
$mrftotal = $mrf_f + $mrf_b;
$pdf->SetX(190);
$pdf->Cell(0, 7, "$mrftotal", 0, 1, 'C');

//15
$pdf->Ln(20);
$pdf->Cell(100, 10, "15. Based on the total score is the LGU complaint? ", 0, 1, '');
$pdf->Cell(100, 5, "   if score is 100%, tick yes", 0, 1, '');
$pdf->Cell(50, 5, "   otherwise tick No, tick yes", 0, 1, '');

//check answer2
if ($answer2 === "Yes") {

    $pdf->Cell(100, 10, "$check Yes      No", 0, 1, '');
} else {
    $pdf->Cell(100, 10, "Yes      $check No", 0, 1, '');
}

$pdf->Cell(50, 5, "_________________________________________________________________________________________________________________________________________________________________________________", 5, 5, 'C');
$pdf->SetFont("ARIAL", "B", "14");
$pdf->Cell(0, 7, "", 0, 1);
$pdf->Cell(50, 5, "NO- LITTERING AND RELATED ORDINANCES ", 5, 5, '');
$pdf->Cell(0, 7, "", 0, 1);
$pdf->SetFont("ARIAL", "B", "12");
$pdf->Cell(50, 5, "16. The Brangay has a No-Littering Ordinance  ", 5, 5, '');

//check answer3
if ($answer3 === "Yes") {


    $pdf->Cell(100, 10, "$check Yes      No", 0, 1, '');
} else {
    $pdf->Cell(100, 10, "Yes      $check No", 0, 1, '');
}
$pdf->Cell(50, 5, "17. If yes, is the ordinance strictly implemented? conduct a radom oscular inspection ", 5, 5, '');
$check = '';
$echeck = '';
if ($answer4 == "Yes") {
    $check = '/';
} else {

    $echeck    = "/";
}
$pdf->Cell(100, 10, "$check Yes       $echeck No", 0, 1, '');
$pdf->Cell(50, 5, "_________________________________________________________________________________________________________________________________________________________________________________", 5, 5, 'C');

$pdf->SetFont("ARIAL", "BU", "14");
$pdf->Cell(0, 7, "", 0, 1);
$pdf->Cell(50, 5, "NEXT STEPS", 5, 5, '');
$pdf->Ln(5);


$pdf->SetFont("ARIAL", "B", "12");
$pdf->Cell(45, 15, "", 1, 0, 'L');
$pdf->Cell(50, 15, "", 1, 0, 'L');
$pdf->Cell(55, 15, "", 1, 0, 'L');
$pdf->Cell(40, 15, "", 1, 0, 'L');
$pdf->Cell(0, 0, "", 0, 1, 'L');

$pdf->Cell(45, 7, "KEY LEGAL", 0, 0, 'L');
$pdf->Cell(50, 7, "LEGAL", 0, 0, 'L');
$pdf->Cell(55, 7, "REASON FOR LOW-", 0, 0, 'L');
$pdf->Cell(40, 7, "NEXT STEPS", 0, 0, 'L');
$pdf->Cell(0, 7, "", 0, 1);

$pdf->Cell(45, 7, "PROVISION", 0, 0, 'L');
$pdf->Cell(50, 7, "CONSEQUENCES", 0, 0, 'L');
$pdf->Cell(55, 7, "COMPLIANCE", 0, 0, 'L');
$pdf->Cell(0, 8, "", 0, 1);

foreach ($nstep as $row1) {
    $k = $row1['key_legal'];
    $l = $row1['legal_consq'];
    $r = $row1['reason_low'];
    $n = $row1['next_step'];
    $pdf->Cell(45, 7, $k, 1, 0, 'L');
    $pdf->Cell(50, 7, $l, 1, 0, 'L');
    $pdf->Cell(55, 7, $r, 1, 0, 'L');
    $pdf->Cell(40, 7, $n, 1, 0, 'L');
    $pdf->Cell(0, 7, "", 0, 1, 'L');
}
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(50, 5, "", 5, 5, 'C');
$pdf->Cell(50, 5, "", 5, 3, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(300, 5, "ACCOMPLISHED BY:", 5, 0, 'L');
$pdf->Cell(50, 5, "", 5, 5, 'C');
$pdf->Cell(50, 5, "", 5, 5, 'C');
$pdf->Cell(50, 5, "NO- LITTERING AND RELATED ORDINANCES ", 5, 5, '');
$pdf->Cell(0, 1, "", 0, 1);



$pdf->SetFont('Arial', 'BU', 12);
$pdf->Cell(80, 5, $cce, 5, 1, 'C');


$try = substr($date, 0, 10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 5, "Committee Chairman on Environment", 5, 0, 'C');
$pdf->Cell(140, 5, "$try", 5, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 5, "CERTIFIED TRUE AND CORRECT:", 5, 0, 'C');
$pdf->Cell(140, 5, "Date", 5, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'BU', 12);
$pdf->Cell(80, 5, "$cap", 5, 0, 'C');
$pdf->Cell(140, 5, "$try", 5, 1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 5, "Punong Barangay", 5, 0, 'C');
$pdf->Cell(140, 5, "Date", 5, 5, 'C');







$pdf->Output($name . '-report.pdf', 'I');
