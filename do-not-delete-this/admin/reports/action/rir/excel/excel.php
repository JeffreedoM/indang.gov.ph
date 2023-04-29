<?php

use PhpOffice\PhpSpreadsheet\Calculation\Category;

require 'vendor/autoload.php';
include '../../../../../includes/deactivated.inc.php';
include '../../../../../includes/session.inc.php';
include '../../../../../includes/dbh.inc.php';
include '../../../function.php';

$officials = getBrgyOfficials($pdo);

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
        $total_residents = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId")->fetchAll(),
        $adult = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 18 AND age <= 59")->fetchAll(),
        $employed = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND occupation_status = 'Employed'")->fetchAll(),
        $female = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND sex = 'Female'")->fetchAll(),
        $infant = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age = 0")->fetchAll(),
        $male = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND sex = 'Male'")->fetchAll(),
        $children = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 1 AND age <= 12")->fetchAll(),
        $pregnant = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId")->fetchAll(),
        $senior = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 60 ")->fetchAll(),
        $teens = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 13 AND age <= 17")->fetchAll(),
        $employed = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND occupation_status = 'Unemployed'")->fetchAll(),
        $death = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId")->fetchAll()
    );
    for ($i = 0; $i <= count($categories); $i++) {
        if ($id == ($i + 1)) {
            $category = $categories[$i];
        }
    }

    // $total_residents = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE barangay_id = $barangayId")->fetchAll();
    // $infant = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE barangay_id = $barangayId AND age = 0")->fetchColumn();
    // $children = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE barangay_id = $barangayId AND age >= 1 AND age <= 12")->fetchColumn();
    // $teens = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE barangay_id = $barangayId AND age >= 13 AND age <= 17")->fetchColumn();
    // $adult = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE barangay_id = $barangayId AND age >= 18 AND age <= 59")->fetchColumn();
    // $senior = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE barangay_id = $barangayId AND age >= 60 ")->fetchColumn();
}

// //start of PhpSpreadsheet
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// $spreadsheet = new Spreadsheet();
// // Get the active worksheet
// $sheet = $spreadsheet->getActiveSheet();

// // Create a header row
// $sheet->setCellValue('A1', 'Name');
// $sheet->setCellValue('B1', 'Age');
// $sheet->setCellValue('C1', 'Country');

// // Set the data for the table

// $writer = new Xlsx($spreadsheet);
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename= ' . $name . '-Resident.xlsx');
// hea// $data = array(
//     array('John', 30, 'USA'),
//     array('Jane', 25, 'Canada'),
//     array('Bob', 40, 'Australia'),
// );

// // Loop through the data and set the cell values
// $row = 2;
// foreach ($data as $rowData) {
//     $sheet->setCellValue('A' . $row, $rowData[0]);
//     $sheet->setCellValue('B' . $row, $rowData[1]);
//     $sheet->setCellValue('C' . $row, $rowData[2]);
//     $row++;
// }der('Cache-Control: max-age=0');

// $writer->save('php://output');

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
    $sheet->setCellValue('B' . $row, $list['firstname']);
    $sheet->setCellValue('C' . $row, $list['middlename']);
    $sheet->setCellValue('D' . $row, $list['lastname']);
    $sheet->setCellValue('E' . $row, $list['suffix']);
    $sheet->setCellValue('F' . $row, $list['birthdate']);
    $sheet->setCellValue('G' . $row, $list['civil_status']);
    $sheet->setCellValue('H' . $row, $list['sex']);
    $sheet->setCellValue('I' . $row, $list['religion']);
    $sheet->setCellValue('J' . $row, 'filipino');
    $sheet->setCellValue('K' . $row, $list['occupation']);
    $sheet->setCellValue('L' . $row, $list['occupation_status']);
    $sheet->setCellValue('M' . $row, 'date');
    // Center the cell contents
    $sheet->getStyle('A' . $row . ':M' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A4:M4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE);
    $row++;
}






$row1 = $row + 4;
$sheet->mergeCells('A' . ($row1 + 1) . ':C' . ($row1 + 1));
$sheet->setCellValue('A' . ($row1 + 1), 'Prepared By: ' . $officials['secretary']['firstname'] . '' . $officials['secretary']['lastname']);
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
