<?php

use PhpOffice\PhpSpreadsheet\Calculation\Category;

require '../../../../vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../function.php';

$officials = getBrgyOfficials($pdo, $barangayId);

$id = $_GET['id'];
$b_name = $barangay['b_name'];

if (isset($id)) {
    $sql = "SELECT *  FROM report_resident WHERE rres_id =:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $report = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($report as $list) {
        $name = $list['rres_category'];
    }

    /* For selecting residents associated with barangay*/
    $stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
    $stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
    $stmt->execute();
    $resident = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* Classification */
    $categories = array(
        //pregnant, death has no record
        $total_residents = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll(),
        $adult = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 18 AND age <= 59 ORDER BY lastname ASC")->fetchAll(),
        $employed = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND occupation_status = 'Employed' ORDER BY lastname ASC")->fetchAll(),
        $female = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND sex = 'Female' ORDER BY lastname ASC")->fetchAll(),
        $infant = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age = 0 ORDER BY lastname ASC")->fetchAll(),
        $male = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND sex = 'Male' ORDER BY lastname ASC")->fetchAll(),
        $children = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 1 AND age <= 12")->fetchAll(),
        $pregnant = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll(),
        $senior = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 60 ORDER BY lastname ASC")->fetchAll(),
        $teens = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 13 AND age <= 17 ORDER BY lastname ASC")->fetchAll(),
        $employed = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND occupation_status = 'Unemployed' ORDER BY lastname ASC")->fetchAll(),
        $death = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll()
    );
    for ($i = 0; $i <= count($categories); $i++) {
        if ($id == ($i + 1)) {
            $category = $categories[$i];
        }
    }
}

//start generating excell
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

// Load the template file
$templatePath = 'template.xlsx';
$spreadsheet = IOFactory::load($templatePath);


// Make changes to the template as needed
$sheet = $spreadsheet->getActiveSheet();


$sheet->mergeCells('A4:M4');
$sheet->setCellValue('A1', 'Republic of the Philippines');
$sheet->setCellValue('A2', 'Province of Cavite');
$sheet->setCellValue('A3', 'Municipality of Indang');
$sheet->setCellValue('A4', 'BARANGAY ' . $b_name);


// Loop through the data and set the cell values
$row = 8;
foreach ($category as $list) {
    $sheet->setCellValue('A' . $row, $list['resident_id']);
    $sheet->setCellValue('B' . $row, $list['lastname']);
    $sheet->setCellValue('C' . $row, $list['firstname']);
    $sheet->setCellValue('D' . $row, $list['middlename']);
    $sheet->setCellValue('E' . $row, $list['suffix']);
    $sheet->setCellValue('F' . $row, $list['birthdate']);
    $sheet->setCellValue('G' . $row, $list['civil_status']);
    $sheet->setCellValue('H' . $row, $list['sex']);
    $sheet->setCellValue('I' . $row, $list['religion']);
    $sheet->setCellValue('J' . $row, 'filipino');
    $sheet->setCellValue('K' . $row, $list['occupation']);
    $sheet->setCellValue('L' . $row, $list['occupation_status']);
    $sheet->setCellValue('M' . $row, $list['date_recorded']);
    // // Center the cell contents
    // $sheet->getStyle('A' . $row . ':M' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    // $sheet->getStyle('A4:M4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE);
    $row++;
}

$row1 = $row + 4;
$sheet->mergeCells('A' . ($row1 + 1) . ':C' . ($row1 + 1));
$sheet->setCellValue('A' . ($row1 + 1), 'Prepared By: ' . $officials['secretary']['firstname'] . ' ' . $officials['secretary']['lastname']);
$sheet->mergeCells('A' . ($row1 + 3) . ':D' . ($row1 + 3));
$sheet->setCellValue('A' . ($row1 + 3), 'Signature:_____________________________');
$sheet->mergeCells('A' . ($row1 + 4) . ':C' . ($row1 + 4));
$sheet->setCellValue('A' . ($row1 + 4), 'Name:');
$sheet->mergeCells('A' . ($row1 + 5) . ':C' . ($row1 + 5));
$sheet->setCellValue('A' . ($row1 + 5), 'Position:');






// Generate a new Excel file
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

// Set the headers to force a download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename= ' . $name . '-Resident.xlsx');
header('Cache-Control: max-age=0');

// Output the generated file to the browser
$writer->save('php://output');
