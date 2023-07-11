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

    /* For selecting residents associated with barangay*/
    $stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
    $stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
    $stmt->execute();
    $resident = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* Classification */
    $categories = array(
        $total_residents = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll(),
        $adult = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 18 AND age <= 59 ORDER BY lastname ASC")->fetchAll(),
        $employed = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND occupation_status = 'Employed' ORDER BY lastname ASC")->fetchAll(),
        $female = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND sex = 'Female' ORDER BY lastname ASC")->fetchAll(),
        $infant = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age = 0 ORDER BY lastname ASC")->fetchAll(),
        $male = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND sex = 'Male' ORDER BY lastname ASC")->fetchAll(),
        $children = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 1 AND age <= 12")->fetchAll(),
        $pregnant = $pdo->query("SELECT * FROM resident INNER JOIN pregnant ON resident.resident_id = pregnant.id_resident WHERE barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll(),
        $senior = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 60 ORDER BY lastname ASC")->fetchAll(),
        $teens = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND age >= 13 AND age <= 17 ORDER BY lastname ASC")->fetchAll(),
        $employed = $pdo->query("SELECT * FROM resident WHERE barangay_id = $barangayId AND occupation_status = 'Unemployed' ORDER BY lastname ASC")->fetchAll(),
        $death = $pdo->query("SELECT * FROM death WHERE barangay_id = $barangayId ORDER BY lastname ASC")->fetchAll()
    );
    for ($i = 0; $i <= count($categories); $i++) {
        if ($id == ($i + 1)) {
            $category = $categories[$i];
        }
    }
}


class PDF extends Fpdi
{
    function Header()
    {
        global $b_name, $logo, $city_logo;
        $this->SetFont('Arial', 'B', 11);

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
        $this->Image($logo, $logoPos - 55, 10, 20, 20);
        $this->Image($city_logo, $logoPos + 35, 10, 20, 20);

        //title

        $this->SetX($centerPos + 65);
        $this->Cell(0, 6, 'Republic of the Philippines', 0, 1);
        $this->Cell(0, 6, 'Province of Cavite', 0, 1, 'C');
        $this->Cell(0, 6, 'Municipality of Indang', 0, 1, 'C');
        $this->Cell(0, 6, 'Barangay ' . $b_name, 0, 1, 'C');

        //dummy cell to give line spacing
        //$this->Cell(0,5,'',0,1);
        //is equivalent to:
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 8);

        // Set the fill color and stroke color to gray
        $this->SetFillColor(128, 128, 128);
        $this->SetDrawColor(128, 128, 128);
        $this->Cell(30, 5, 'Last Name', 1, 0, '', true);
        $this->Cell(30, 5, 'First Name', 1, 0, '', true);
        $this->Cell(30, 5, 'Middle Name', 1, 0, '', true);
        $this->Cell(15, 5, 'Suffix', 1, 0, '', true);
        $this->Cell(30, 5, 'Birthdate', 1, 0, '', true);
        $this->Cell(30, 5, 'Marital', 1, 0, '', true);
        $this->Cell(15, 5, 'Gender', 1, 0, '', true);
        $this->Cell(30, 5, 'Religion', 1, 0, '', true);
        $this->Cell(25, 5, 'Nationality', 1, 0, '', true);
        $this->Cell(30, 5, 'Occupation', 1, 0, '', true);
        $this->Cell(40, 5, 'Status', 1, 0, '', true);
        $this->Cell(30, 5, 'Date Record', 1, 1, '', true);
    }
    function Footer()
    {
        global $secretary;
        // $this->SetFont('Arial', '', 8);
        // $this->SetY(-40);
        // $this->Cell(0, 6, 'Prepared By: ' . $secretary, 0, 1);
        // $this->Cell(0, 6, 'Signature:_____________________________', 0, 1);
        // $this->Cell(0, 6, 'Name:', 0, 1);
        // $this->Cell(0, 6, 'Position:', 0, 1);


        $this->SetFont('Arial', '', 8);
        //Go to 1.5 cm from bottom
        $this->SetY(-15);

        $this->SetFont('Arial', '', 8);

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

$pdf = new PDF('P', 'mm', 'A4'); //use new class
$pdf = new TextNormalizerFPDF();
//define new alias for total page numbers
$pdf->AliasNbPages('{pages}');

$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage('L', 'Legal');

$pdf->SetFont('Arial', '', 8);
$pdf->SetDrawColor(128, 128, 128);



foreach ($category as $list) {
    $pdf->Cell(30, 5, $list['lastname'], 'LR', 0);
    $pdf->Cell(30, 5, $list['firstname'], 'LR', 0);
    $pdf->Cell(30, 5, $list['middlename'], 'LR', 0);
    $pdf->Cell(15, 5, $list['suffix'], 'LR', 0);
    $pdf->Cell(30, 5, $list['birthdate'], 'LR', 0);
    $pdf->Cell(30, 5, $list['civil_status'], 'LR', 0);
    $pdf->Cell(15, 5, $list['sex'], 'LR', 0);
    if ($pdf->GetStringWidth($list['religion']) > 30) {
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(30, 5, $list['religion'], 'LR', 0);
        $pdf->SetFont('Arial', '', 8);
    } else {
        $pdf->Cell(30, 5, $list['religion'], 'LR', 0);
    }
    $pdf->Cell(25, 5, $list['citizenship'], 'LR', 0);
    if ($pdf->GetStringWidth($list['occupation']) > 25) {
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(30, 5, $list['occupation'], 'LR', 0);
        $pdf->SetFont('Arial', '', 8);
    } else {
        $pdf->Cell(30, 5, $list['occupation'], 'LR', 0);
    }


    if ($pdf->GetStringWidth($list['occupation_status']) > 35) {
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(40, 5, $list['occupation_status'], 'LR', 0);
        $pdf->SetFont('Arial', '', 8);
    } else {
        $pdf->Cell(40, 5, $list['occupation_status'], 'LR', 0);
    }
    $pdf->Cell(30, 5, $list['date_recorded'], 'LR', 1);
}
//add table's bottom line
$pdf->Cell(335, 0, '', 'T', 1, '', true);


// prepared name and signature
$pdf->SetY(-40);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 6, 'Prepared By: ' . $secretary, 0, 1);
$pdf->Cell(0, 6, 'Signature:_____________________________', 0, 1);
$pdf->Cell(0, 6, 'Name:', 0, 1);
$pdf->Cell(0, 6, 'Position:', 0, 1);


$pdf->SetTitle($name . (($name !== 'All resident') ? ' Residents' : ''));

$pdf->Output($name . (($name !== 'All resident') ? ' Residents' : ''), 'I');
