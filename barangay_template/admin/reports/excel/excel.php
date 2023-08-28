<?php

require '../../../../vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../function.php';

$officials = getBrgyOfficials($pdo, $barangayId);

$id = $_GET['id'];
$b_name = $barangay['b_name'];
$logo = "../../../../admin/assets/images/uploads/barangay-logos/$barangay[b_logo]";
$city_logo = "../../../../admin/assets/images/$municipality_logo";

if (isset($id)) {
    $sql = "SELECT *  FROM report_resident WHERE rres_id =:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $report = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($report as $list) {
        $name = $list['rres_category'];
    }

    // selected columns in filter
    if (isset($_SESSION['filters'])) {
        $columns = $_SESSION['filters'];
        $selectedColumns = "resident_id," . implode(", ", $columns);
    } else {
        $selectedColumns = '*';
        $columns = array('lastname', 'firstname', 'middlename', 'suffix', 'birthdate', 'civil_status', 'sex', 'religion', 'citizenship', 'occupation', 'occupation_status', 'date_recorded');
    }

    /* For selecting residents associated with barangay*/
    $ages = $pdo->query("
    SELECT $selectedColumns,
           TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age
    FROM resident
    WHERE is_alive = 1 AND barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll(PDO::FETCH_ASSOC);

    // Separate residents into different age groups
    $infants = array_filter($ages, function ($resident) {
        return $resident['age'] >= 0 && $resident['age'] <= 1;
    });

    $children = array_filter($ages, function ($resident) {
        return $resident['age'] >= 2 && $resident['age'] <= 12;
    });

    $teens = array_filter($ages, function ($resident) {
        return $resident['age'] >= 13 && $resident['age'] <= 17;
    });

    $adults = array_filter($ages, function ($resident) {
        return $resident['age'] >= 18 && $resident['age'] <= 59;
    });

    $seniors = array_filter($ages, function ($resident) {
        return $resident['age'] >= 60;
    });


    $categories = array(
        $total_residents = $pdo->query("SELECT $selectedColumns FROM resident WHERE is_alive = 1 AND barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll(),
        $adults,
        $employed = $pdo->query("SELECT $selectedColumns FROM resident WHERE (occupation_status != 'Unemployed' AND occupation_status != '' AND occupation_status != 'N/A') AND  is_alive = 1 AND barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll(),
        $female = $pdo->query("SELECT $selectedColumns FROM resident WHERE (sex = 'Female') AND barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll(),
        $infants,
        $male = $pdo->query("SELECT $selectedColumns FROM resident WHERE (sex = 'Male') AND  is_alive = 1 AND barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll(),
        $children,
        $pregnant = $pdo->query("SELECT $selectedColumns FROM resident INNER JOIN pregnant ON resident.resident_id = pregnant.id_resident WHERE is_alive = 1 AND barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll(),
        $seniors,
        $teens,
        $unemployed = $pdo->query("SELECT $selectedColumns FROM resident WHERE (occupation_status = 'Unemployed') AND  is_alive = 1 AND barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll(),
        $death = $pdo->query("SELECT $selectedColumns FROM resident WHERE is_alive = 0 AND barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll()

    );
    for ($i = 0; $i <= count($categories); $i++) {
        if ($id == ($i + 1)) {
            // for only date filters
            if (in_array('date_recorded', $columns) && !empty($_SESSION['date_filters'])) {

                $category_datefilter = $categories[$i];

                // Validate and sanitize the date input
                $dates = $_SESSION['date_filters'];
                $startDate = DateTime::createFromFormat('m/d/Y', $dates[0]);
                $endDate = DateTime::createFromFormat('m/d/Y', $dates[1]);

                if ($startDate && $endDate) {
                    $startDate = $startDate->format('Y-m-d');
                    $endDate = $endDate->format('Y-m-d');

                    // Filtering the date records
                    $category = array_filter($category_datefilter, function ($resident) use ($startDate, $endDate) {
                        $recordedDate = $resident['date_recorded'];
                        return $recordedDate >= $startDate && $recordedDate <= $endDate;
                    });
                } else {
                    $category = $categories[$i];
                }
            } else {
                $category = $categories[$i];
            }
            // $category = $pdo->query("$categories[$i] AND barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll();
        }
    }
}

//start generating excell
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Load the template file
$templatePath = 'template.xlsx';
$spreadsheet = IOFactory::load($templatePath);

// $spreadsheet = new Spreadsheet();

// Make changes to the template as needed
$sheet = $spreadsheet->getActiveSheet();

// insert the barangay logo
$barangayLogo = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$barangayLogo->setName('Barangay Logo');
$barangayLogo->setDescription('Barangay Logo');
$barangayLogo->setPath($logo);
$barangayLogo->setCoordinates('F1');
$barangayLogo->setHeight(80); // Adjust the height of the logo (in pixels)
$barangayLogo->setWorksheet($sheet);

$name = $name . (($name !== 'All residents') ? ' Residents' : '');

$sheet->mergeCells('A6:M6');
$sheet->setCellValue('A1', 'Republic of the Philippines');
$sheet->setCellValue('A2', 'Province of Cavite');
$sheet->setCellValue('A3', 'Municipality of Indang');
$sheet->setCellValue('A4', 'BARANGAY ' . $b_name);
$sheet->setCellValue('A6', $name);

// Insert the City logo
$cityLogo = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$cityLogo->setName('City Logo');
$cityLogo->setDescription('City Logo');
$cityLogo->setPath($city_logo);
$cityLogo->setCoordinates('J1');
$cityLogo->setHeight(80); // Adjust the height of the logo (in pixels)
$cityLogo->setWorksheet($sheet);

$styleArray = array(
    'borders' => array(
        'outline' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('argb' => '000'),
        ),
    ),
);


$headerNames = array(
    'lastname' => 'Last Name',
    'firstname' => 'First Name',
    'middlename' => 'Middle Name',
    'suffix' => 'Suffix',
    'birthdate' => 'Birthdate',
    'civil_status' => 'Marital',
    'sex' => 'Sex',
    'religion' => 'Religion',
    'citizenship' => 'Nationality',
    'occupation' => 'Occupation',
    'occupation_status' => 'Status',
    'date_recorded' => 'Date Record'
);

$row = 7;
$columnIndex = 2; // Start with the second column (B)

foreach ($columns as $column) {
    if (array_key_exists($column, $headerNames)) {
        $columnLetter = chr(65 + $columnIndex - 1); // Convert column index to ASCII letter (B=66, C=67, etc.)
        $cellReference = $columnLetter . $row;

        // Set the header name from the headerNames array
        $headerName = $headerNames[$column];
        $sheet->setCellValue($cellReference, $headerName);

        $columnIndex++; // Move to the next column
    }
}



// Loop through the data and set the cell values
$sheet->getStyle('A7:M7')->applyFromArray($styleArray);
$row = 8;
foreach ($category as $list) {
    $sheet->getStyle('A' . $row . ':M' . $row)->applyFromArray($styleArray);
    $sheet->setCellValue('A' . $row, $list['resident_id']);

    $columnIndex = 1;
    foreach ($columns as $column) {
        $columnLetter = chr(65 + $columnIndex); // Convert column index to ASCII letter (A=65, B=66, etc.)
        $cellReference = $columnLetter . $row;

        switch ($column) {
            case 'lastname':
            case 'firstname':
            case 'middlename':
            case 'suffix':
                $sheet->setCellValue($cellReference, ucfirst(strtolower($list[$column])));
                break;
            case 'birthdate':
                $sheet->setCellValue($cellReference, date('F j, Y', strtotime($list[$column])));
                break;
            default:
                $sheet->setCellValue($cellReference, $list[$column]);
                break;
        }

        $columnIndex++;
    }

    $row++;
}



// $row = 8;
// foreach ($category as $list) {
//     $sheet->getStyle('A' . $row . ':M' . $row)->applyFromArray($styleArray);
//     $sheet->setCellValue('A' . $row, $list['resident_id']);
//     $sheet->setCellValue('B' . $row, $list['lastname']);
//     $sheet->setCellValue('C' . $row, $list['firstname']);
//     $sheet->setCellValue('D' . $row, $list['middlename']);
//     $sheet->setCellValue('E' . $row, $list['suffix']);
//     $sheet->setCellValue('F' . $row, date('F j, Y', strtotime($list['birthdate'])));
//     $sheet->setCellValue('G' . $row, $list['civil_status']);
//     $sheet->setCellValue('H' . $row, $list['sex']);
//     $sheet->setCellValue('I' . $row, $list['religion']);
//     $sheet->setCellValue('J' . $row, $list['citizenship']);
//     $sheet->setCellValue('K' . $row, $list['occupation']);
//     $sheet->setCellValue('L' . $row, $list['occupation_status']);
//     $sheet->setCellValue('M' . $row, $list['date_recorded']);
//     // // Center the cell contents
//     // $sheet->getStyle('A' . $row . ':M' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
//     // $sheet->getStyle('A4:M4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE);
//     $row++;
// }

$row1 = $row + 4;
$sheet->mergeCells('A' . ($row1 + 1) . ':C' . ($row1 + 1));
$sheet->setCellValue('A' . ($row1 + 1), 'Prepared By: ');
// $sheet->setCellValue('A' . ($row1 + 1), 'Prepared By: ' . $officials['secretary']['firstname'] . ' ' . $officials['secretary']['lastname']);
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
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment;filename= ' . $name . '.xlsx');
header('Cache-Control: max-age=0');

// Output the generated file to the browser
$writer->save('php://output');
