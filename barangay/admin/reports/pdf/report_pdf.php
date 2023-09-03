<?php

use setasign\Fpdi\Fpdi;

require '../../../../vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../function.php';

$officials = getBrgyOfficials($pdo, $barangayId);
$secretary = $officials['secretary']['firstname'] . ' ' . $officials['secretary']['lastname'];
$id = $_GET['id'];
$b_name = $barangay['b_name'];

$logo = "../../../../admin/assets/images/uploads/barangay-logos/$barangay[b_logo]";
$city_logo = "../../../../admin/assets/images/$municipality_logo";

//for selecting id category
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
        $selectedColumns = implode(", ", $columns);
    } else {
        $selectedColumns = '*';
        $columns = array('lastname', 'firstname', 'middlename', 'suffix', 'birthdate', 'civil_status', 'sex', 'religion', 'citizenship', 'occupation', 'occupation_status', 'date_recorded');
    }

    $ages = $pdo->query("
    SELECT $selectedColumns,
           TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age
    FROM resident
    WHERE is_alive = 1 AND barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll();

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

// computing the total size of the table
$totalColumns = count($columns);
$size = 0;
foreach ($columns as $column) {
    if ($column === 'suffix' || $column === 'sex') {
        $size += 15;
    } elseif ($column === 'birthdate') {
        $size += 35;
    } elseif ($column === 'occupation_status') {
        $size += 40;
    } elseif ($column === 'citizenship') {
        $size += 20;
    } else {
        $size += 30;
    }
}


class PDF extends Fpdi
{
    function Header()
    {
        global $columns, $b_name, $logo, $city_logo, $name, $size;

        $this->SetFont('Times', '', 11);

        //dummy cell to put logo
        //$this->Cell(12,0,'',0,0);
        //is equivalent to:
        $this->Cell(12);

        //page width size center
        $pageWidth = $this->GetPageWidth();
        $cellWidth = 185; // Width of the cell
        $centerPos = ($pageWidth - $cellWidth) / 2;

        // logo
        $logoPos = ($pageWidth  / 2);
        $this->Image($logo, $logoPos - 45, 10, 20, 20);
        $this->Image($city_logo, $logoPos + 25, 10, 20, 20);

        //title

        $this->SetX($centerPos - 75);
        $this->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C');
        $this->Cell(0, 5, 'Province of Cavite', 0, 1, 'C');
        $this->Cell(0, 5, 'Municipality of Indang', 0, 1, 'C');
        $this->Cell(0, 5, 'Barangay ' . $b_name, 0, 1, 'C');

        //dummy cell to give line spacing
        //$this->Cell(0,5,'',0,1);
        //is equivalent to:

        $this->SetFont('Times', 'B', 11);
        $this->Ln(5);
        $this->Cell(0, 6, (($name !== 'All residents') ? $name . ' Residents' : 'Masterlist of Residents'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Times', 'B', 11);

        // Set the fill color and stroke color to gray
        $this->SetFillColor(128, 128, 128);
        $this->SetDrawColor(128, 128, 128);



        // Set the X coordinate for positioning
        $centerX = ($this->GetPageWidth() - $size) / 2;
        $this->SetX($centerX);

        // Header for table
        if (in_array('lastname', $columns)) {
            $this->Cell(30, 5, 'Last Name', 1, 0, '', true);
        }
        if (in_array('firstname', $columns)) {
            $this->Cell(30, 5, 'First Name', 1, 0, '', true);
        }
        if (in_array('middlename', $columns)) {
            $this->Cell(30, 5, 'Middle Name', 1, 0, '', true);
        }
        if (in_array('suffix', $columns)) {
            $this->Cell(15, 5, 'Suffix', 1, 0, '', true);
        }
        if (in_array('birthdate', $columns)) {
            $this->Cell(35, 5, 'Birthdate', 1, 0, '', true);
        }
        if (in_array('civil_status', $columns)) {
            $this->Cell(30, 5, 'Marital', 1, 0, '', true);
        }
        if (in_array('sex', $columns)) {
            $this->Cell(15, 5, 'Sex', 1, 0, '', true);
        }
        if (in_array('religion', $columns)) {
            $this->Cell(30, 5, 'Religion', 1, 0, '', true);
        }
        if (in_array('citizenship', $columns)) {
            $this->Cell(20, 5, 'Nationality', 1, 0, '', true);
        }
        if (in_array('occupation', $columns)) {
            $this->Cell(30, 5, 'Occupation', 1, 0, '', true);
        }
        if (in_array('occupation_status', $columns)) {
            $this->Cell(40, 5, 'Status', 1, 0, '', true);
        }
        if (in_array('date_recorded', $columns)) {
            $this->Cell(30, 5, 'Date Record', 1, 0, '', true);
        }
        $this->Cell(0, 5, '', 0, 1, '', false);
    }
    function Footer()
    {
        // global $secretary;
        // $this->SetFont('Times', '', 8);
        // $this->SetY(-40);
        // $this->Cell(0, 6, 'Prepared By: ' . $secretary, 0, 1);
        // $this->Cell(0, 6, 'Signature:_____________________________', 0, 1);
        // $this->Cell(0, 6, 'Name:', 0, 1);
        // $this->Cell(0, 6, 'Position:', 0, 1);


        $this->SetFont('Times', '', 8);
        //Go to 1.5 cm from bottom
        $this->SetY(-15);

        $this->SetFont('Times', '', 8);

        //width = 0 means the cell is extended up to the right margin
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . " / {pages}", 0, 0, 'C');
    }
}

class TextNormalizerFPDF extends PDF
{
    function __construct()
    {
        parent::__construct();
    }

    function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false)
    {
        parent::MultiCell($w, $h, $this->normalize($txt), $border, $align, $fill);
    }

    function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        parent::Cell($w, $h, $this->normalize($txt), $border, $ln, $align, $fill, $link);
    }

    function Write($h, $txt, $link = '')
    {
        parent::Write($h, $this->normalize($txt), $link);
    }

    function Text($x, $y, $txt)
    {
        parent::Text($x, $y, $this->normalize($txt));
    }

    protected function normalize($word)
    {
        // Thanks to: http://stackoverflow.com/questions/3514076/special-characters-in-fpdf-with-php

        $word = str_replace("@", "%40", $word);
        $word = str_replace("`", "%60", $word);
        $word = str_replace("¢", "%A2", $word);
        $word = str_replace("£", "%A3", $word);
        $word = str_replace("¥", "%A5", $word);
        $word = str_replace("|", "%A6", $word);
        $word = str_replace("«", "%AB", $word);
        $word = str_replace("¬", "%AC", $word);
        $word = str_replace("¯", "%AD", $word);
        $word = str_replace("º", "%B0", $word);
        $word = str_replace("±", "%B1", $word);
        $word = str_replace("ª", "%B2", $word);
        $word = str_replace("µ", "%B5", $word);
        $word = str_replace("»", "%BB", $word);
        $word = str_replace("¼", "%BC", $word);
        $word = str_replace("½", "%BD", $word);
        $word = str_replace("¿", "%BF", $word);
        $word = str_replace("À", "%C0", $word);
        $word = str_replace("Á", "%C1", $word);
        $word = str_replace("Â", "%C2", $word);
        $word = str_replace("Ã", "%C3", $word);
        $word = str_replace("Ä", "%C4", $word);
        $word = str_replace("Å", "%C5", $word);
        $word = str_replace("Æ", "%C6", $word);
        $word = str_replace("Ç", "%C7", $word);
        $word = str_replace("È", "%C8", $word);
        $word = str_replace("É", "%C9", $word);
        $word = str_replace("Ê", "%CA", $word);
        $word = str_replace("Ë", "%CB", $word);
        $word = str_replace("Ì", "%CC", $word);
        $word = str_replace("Í", "%CD", $word);
        $word = str_replace("Î", "%CE", $word);
        $word = str_replace("Ï", "%CF", $word);
        $word = str_replace("Ð", "%D0", $word);
        $word = str_replace("Ñ", "%D1", $word);
        $word = str_replace("Ò", "%D2", $word);
        $word = str_replace("Ó", "%D3", $word);
        $word = str_replace("Ô", "%D4", $word);
        $word = str_replace("Õ", "%D5", $word);
        $word = str_replace("Ö", "%D6", $word);
        $word = str_replace("Ø", "%D8", $word);
        $word = str_replace("Ù", "%D9", $word);
        $word = str_replace("Ú", "%DA", $word);
        $word = str_replace("Û", "%DB", $word);
        $word = str_replace("Ü", "%DC", $word);
        $word = str_replace("Ý", "%DD", $word);
        $word = str_replace("Þ", "%DE", $word);
        $word = str_replace("ß", "%DF", $word);
        $word = str_replace("à", "%E0", $word);
        $word = str_replace("á", "%E1", $word);
        $word = str_replace("â", "%E2", $word);
        $word = str_replace("ã", "%E3", $word);
        $word = str_replace("ä", "%E4", $word);
        $word = str_replace("å", "%E5", $word);
        $word = str_replace("æ", "%E6", $word);
        $word = str_replace("ç", "%E7", $word);
        $word = str_replace("è", "%E8", $word);
        $word = str_replace("é", "%E9", $word);
        $word = str_replace("ê", "%EA", $word);
        $word = str_replace("ë", "%EB", $word);
        $word = str_replace("ì", "%EC", $word);
        $word = str_replace("í", "%ED", $word);
        $word = str_replace("î", "%EE", $word);
        $word = str_replace("ï", "%EF", $word);
        $word = str_replace("ð", "%F0", $word);
        $word = str_replace("ñ", "%F1", $word);
        $word = str_replace("ò", "%F2", $word);
        $word = str_replace("ó", "%F3", $word);
        $word = str_replace("ô", "%F4", $word);
        $word = str_replace("õ", "%F5", $word);
        $word = str_replace("ö", "%F6", $word);
        $word = str_replace("÷", "%F7", $word);
        $word = str_replace("ø", "%F8", $word);
        $word = str_replace("ù", "%F9", $word);
        $word = str_replace("ú", "%FA", $word);
        $word = str_replace("û", "%FB", $word);
        $word = str_replace("ü", "%FC", $word);
        $word = str_replace("ý", "%FD", $word);
        $word = str_replace("þ", "%FE", $word);
        $word = str_replace("ÿ", "%FF", $word);

        return urldecode($word);
    }
}


//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm
$pdf = new TextNormalizerFPDF();
//define new alias for total page numbers
$pdf->AliasNbPages('{pages}');

$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage('L', 'Legal');

$pdf->SetFont('Times', '', 11);
$pdf->SetDrawColor(128, 128, 128);




foreach ($category as $list) {
    $centerX = ($pdf->GetPageWidth() - $size) / 2;

    // Set the X coordinate for positioning
    $pdf->SetX($centerX);
    if (in_array('lastname', $columns)) {
        if ($pdf->GetStringWidth($list['lastname']) > 30) {
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(30, 5, $list['lastname'], 'LR', 0);
            $pdf->SetFont('Times', '', 11);
        } else {
            $pdf->Cell(30, 5, $list['lastname'], 'LR', 0);
        }
    }
    if (in_array('firstname', $columns)) {
        if ($pdf->GetStringWidth($list['firstname']) > 30) {
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(30, 5, $list['firstname'], 'LR', 0);
            $pdf->SetFont('Times', '', 11);
        } else {
            $pdf->Cell(30, 5, $list['firstname'], 'LR', 0);
        }
    }
    if (in_array('middlename', $columns)) {
        if ($pdf->GetStringWidth($list['middlename']) > 30) {
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(30, 5, $list['middlename'], 'LR', 0);
            $pdf->SetFont('Times', '', 11);
        } else {
            $pdf->Cell(30, 5, $list['middlename'], 'LR', 0);
        }
    }
    if (in_array('suffix', $columns)) {
        $pdf->Cell(15, 5, $list['suffix'], 'LR', 0);
    }
    if (in_array('birthdate', $columns)) {
        $pdf->Cell(35, 5, date('F j, Y', strtotime($list['birthdate'])), 'LR', 0);
    }
    if (in_array('civil_status', $columns)) {
        $pdf->Cell(30, 5, $list['civil_status'], 'LR', 0);
    }
    if (in_array('sex', $columns)) {
        $pdf->Cell(15, 5, $list['sex'], 'LR', 0);
    }
    if (in_array('religion', $columns)) {
        if ($pdf->GetStringWidth($list['religion']) > 30) {
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(30, 5, $list['religion'], 'LR', 0);
            $pdf->SetFont('Times', '', 11);
        } else {
            $pdf->Cell(30, 5, $list['religion'], 'LR', 0);
        }
    }
    if (in_array('citizenship', $columns)) {
        if ($pdf->GetStringWidth($list['citizenship']) > 20) {
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(20, 5, $list['citizenship'], 'LR', 0);
            $pdf->SetFont('Times', '', 11);
        } else {
            $pdf->Cell(20, 5, $list['citizenship'], 'LR', 0);
        }
    }
    if (in_array('occupation', $columns)) {
        if ($pdf->GetStringWidth($list['occupation']) > 30) {
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(30, 5, $list['occupation'], 'LR', 0);
            $pdf->SetFont('Times', '', 11);
        } else {
            $pdf->Cell(30, 5, $list['occupation'], 'LR', 0);
        }
    }

    if (in_array('occupation_status', $columns)) {
        if ($pdf->GetStringWidth($list['occupation_status']) > 40) {
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(40, 5, $list['occupation_status'], 'LR', 0);
            $pdf->SetFont('Times', '', 11);
        } else {
            $pdf->Cell(40, 5, $list['occupation_status'], 'LR', 0);
        }
    }
    if (in_array('date_recorded', $columns)) {
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(30, 5, $list['date_recorded'], 'LR', 0);
    }
    $pdf->SetFont('Times', '', 11);
    $pdf->Cell(0, 5, '', '', 1);

    $pdf->SetX($centerX);
    //add table's bottom line
    $pdf->Cell($size, 0, '', 'T', 1, '', true);
}



// prepared name and signature

$pdf->SetY($pdf->GetY() + 5);

$pdf->SetFont('Times', '', 11); // Set the font for the cells

$pdf->SetAutoPageBreak(true, 10);

// Add cells to the PDF
$pdf->Cell(0, 5, 'Prepared By: ', 0, 1);
$pdf->Ln(5);
$pdf->Cell(0, 5, 'Signature:_____________________________', 0, 1);
$pdf->Cell(0, 5, 'Name:', 0, 1);
$pdf->Cell(0, 5, 'Position:', 0, 1);



$pdf->SetTitle((($name !== 'All residents') ? $name . ' Residents' : 'Masterlist of Residents'));

$pdf->Output((($name !== 'All residents') ? $name . ' Residents' : 'Masterlist of Residents') . '.pdf', 'I');
