<?php

use setasign\Fpdi\Fpdi;

require '../../../../vendor/autoload.php';
include '../../../includes/deactivated.inc.php';
include '../../../includes/session.inc.php';
include '../../../includes/dbh.inc.php';
include '../includes/function.php';

$officials = getBrgyOfficials($pdo, $barangayId);
$secretary = $officials['secretary']['firstname'] . ' ' . $officials['secretary']['lastname'];
$captain = !empty($officials['captain']) ? $officials['captain']['firstname'] . ' ' . $officials['captain']['lastname'] : '';
$incident_id = $_GET['print_id'];
$b_name = $barangay['b_name'];
$city_logo = "../../../../admin/assets/images/$municipality_logo";
$logo = "../../../../admin/assets/images/uploads/barangay-logos/$barangay[b_logo]";

$incidents = getIncidentsByBarangayId($incident_id, $barangayId, $pdo);
$complainants = getIncidentComplainant($pdo, $incident_id);
$offenders = getIncidentOffender($pdo, $incident_id);
foreach ($incidents as $list) {
    $case = $list['case_incident'];
    $title = $list['incident_title'];
    $date = $list['date_incident'];
    $time = $list['time_incident'];
    $location = $list['location'];
    $narr = $list['narrative'];
    $json_narr = json_decode($narr);
    $date_r = $list['date_reported'];
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
    }
    function Footer()
    {
        global $secretary, $captain;
        $this->SetFont('Arial', '', 8);
        $this->Ln(5);
        $this->SetY(-20);
        $this->Cell(0, 5, 'Prepared By: ' . $secretary, 0, 1);
        $this->Cell(0, 5, 'Barangay Captain: ' . $captain, 0, 0);

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

    function Justify($text, $w, $h)
    {
        $tab_paragraphe = explode("\n", $text);
        $nb_paragraphe = count($tab_paragraphe);
        $j = 0;

        while ($j < $nb_paragraphe) {

            $paragraphe = $tab_paragraphe[$j];
            $tab_mot = explode(' ', $paragraphe);
            $nb_mot = count($tab_mot);

            // Handle strings longer than paragraph width
            $tab_mot2 = array();
            $k = 0;
            $l = 0;
            while ($k < $nb_mot) {

                $len_mot = strlen($tab_mot[$k]);
                if ($len_mot < ($w - 5)) {
                    $tab_mot2[$l] = $tab_mot[$k];
                    $l++;
                } else {
                    $m = 0;
                    $chaine_lettre = '';
                    while ($m < $len_mot) {

                        $lettre = substr($tab_mot[$k], $m, 1);
                        $len_chaine_lettre = $this->GetStringWidth($chaine_lettre . $lettre);

                        if ($len_chaine_lettre > ($w - 7)) {
                            $tab_mot2[$l] = $chaine_lettre . '-';
                            $chaine_lettre = $lettre;
                            $l++;
                        } else {
                            $chaine_lettre .= $lettre;
                        }
                        $m++;
                    }
                    if ($chaine_lettre) {
                        $tab_mot2[$l] = $chaine_lettre;
                        $l++;
                    }
                }
                $k++;
            }

            // Justified lines
            $nb_mot = count($tab_mot2);
            $i = 0;
            $ligne = '';
            while ($i < $nb_mot) {

                $mot = $tab_mot2[$i];
                $len_ligne = $this->GetStringWidth($ligne . ' ' . $mot);

                if ($len_ligne > ($w - 5)) {

                    $len_ligne = $this->GetStringWidth($ligne);
                    $nb_carac = strlen($ligne);
                    $ecart = (($w - 2) - $len_ligne) / $nb_carac;
                    $this->_out(sprintf('BT %.3F Tc ET', $ecart * $this->k));
                    $this->MultiCell($w, $h, $ligne);
                    $ligne = $mot;
                } else {

                    if ($ligne) {
                        $ligne .= ' ' . $mot;
                    } else {
                        $ligne = $mot;
                    }
                }
                $i++;
            }

            // Last line
            $this->_out('BT 0 Tc ET');
            $this->MultiCell($w, $h, $ligne);
            $j++;
        }
    }
}




//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm
$pdf = new TextNormalizerFPDF();




//define new alias for total page numbers
$pdf->AliasNbPages('{pages}');

$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage('P', 'A4');

$pdf->Line(10, 46, 200, 46);
$pdf->Line(10, 48, 200, 48);

//INCIDENT REPORT
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 6, 'CERTIFICATE', 0, 1, 'C');

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, 'Incident Case Report', 0, 1, 'C');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, 'FOR RECORD: ', 0, 0);
$pdf->SetX(60);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(10, 6, $title, 0, 1);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, 'Entry No: ', 0, 0);
$pdf->SetX(60);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 6, $incident_id, 0, 1);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, 'Location: ', 0, 0);
$pdf->SetX(60);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 6, $location, 0, 1);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, 'Date & Time Reported: ', 0, 0);

$pdf->SetX(60);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 6, $date_r, 0, 1);


//LIST OF COMPLAINANT
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 5, 'COMPLAINANT/REPORT PERSON', 0, 1);

$pdf->SetFont('Arial', 'B', 11);
// Set the fill color and stroke color to gray
$pdf->SetFillColor(128, 128, 128);
$pdf->SetDrawColor(128, 128, 128);
$pdf->Cell(50, 5, 'Name', 1, 0, '', true);
$pdf->Cell(30, 5, 'Gender', 1, 0, '', true);
$pdf->Cell(30, 5, 'Phone No.', 1, 0, '', true);
$pdf->Cell(30, 5, 'Birthdate', 1, 0, '', true);
$pdf->Cell(50, 5, 'Address', 1, 1, '', true);

$pdf->SetFont('Arial', '', 11);
$pdf->SetDrawColor(128, 128, 128);

foreach ($complainants as $list) {
    $name = !empty($list['firstname']) && !empty($list['lastname'])
        ? $list['firstname'] . ' ' . $list['lastname']
        : $list['non_res_firstname'] . ' ' . $list['non_res_lastname'];
    $gender = !empty($list['sex']) ? $list['sex'] : $list['non_res_gender'];
    $contact = !empty($list['contact']) ? $list['contact'] : $list['non_res_contact'];
    $birthdate = !empty($list['birthdate']) ? $list['birthdate'] : $list['non_res_birthdate'];
    $address = !empty($list['address']) ? $list['address'] : $list['non_res_address'];

    $pdf->Cell(50, 5, $name, 'LR', 0);
    $pdf->Cell(30, 5, $gender, 'LR', 0);
    $pdf->Cell(30, 5, !empty($contact) ? $contact : "N/A", 'LR', 0);
    $pdf->Cell(30, 5, $birthdate, 'LR', 0);
    if ($pdf->GetStringWidth($address) > 50) {
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(50, 5, $address, 'LR', 1);
        $pdf->SetFont('Arial', '', 11);
    } else {
        $pdf->Cell(50, 5, $address, 'LR', 1);
    }

    //add table's bottom line
    $pdf->Cell(190, 0, '', 'T', 1, '', true);
}




//LIST OF OFFENDER
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 5, 'OFFENDER PERSON', 0, 1);
// Set the fill color and stroke color to gray
$pdf->SetFillColor(128, 128, 128);
$pdf->SetDrawColor(128, 128, 128);


$pdf->SetFont('Arial', '', 11);
$pdf->SetDrawColor(128, 128, 128);

foreach ($offenders as $list) {
    $name = !empty($list['firstname']) && !empty($list['lastname'])
        ? $list['firstname'] . ' ' . $list['lastname']
        : $list['non_res_firstname'] . ' ' . $list['non_res_lastname'];
    $gender = !empty($list['sex']) ? $list['sex'] : $list['non_res_gender'];
    $contact = !empty($list['contact']) ? $list['contact'] : $list['non_res_contact'];
    $birthdate = !empty($list['birthdate']) ? $list['birthdate'] : $list['non_res_birthdate'];
    $address = !empty($list['address']) ? $list['address'] : $list['non_res_address'];

    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(30, 5, "Name:", 0, 0, '');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 5, $name, 0, 1);

    $pdf->Cell(30, 5, 'Gender:', 0, 0, '');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 5, $gender, 0, 1);

    $pdf->Cell(30, 5, 'Phone No.:', 0, 0, '');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 5, !empty($contact) ? $contact : "N/A", 0, 1);

    $pdf->Cell(30, 5, 'Birthdate:', 0, 0, '');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 5, $birthdate, 0, 1);

    $pdf->Cell(30, 5, 'Address:', 0, 0, '');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 5, $address, 0, 1);

    $pdf->Cell(30, 5, 'Description:', 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->MultiCell(0, 5, $list['desc'], 0, 1);

    $pdf->SetFont('Arial', '', 11);

    //add table's bottom line
    $pdf->Cell(190, 0, '', 'T', 1, '', true);
}



// narrative texts
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 5, "NARRATIVE:", 0, 1, "");
$pdf->SetFont('Arial', '', 11);
$pdf->Justify("\t       " . $json_narr[0], 190, 6);
for ($i = 1; $i < count($json_narr); $i++) {
    $pdf->Cell(0, 5, "", 0, 1, "");
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 5, "$i.", 0, 1, "");
    $pdf->SetFont('Arial', '', 11);
    $pdf->Justify("\t       " . $json_narr[$i], 190, 6);
}





$pdf->SetTitle('Incident Case No.' . $incident_id);

$pdf->Output('Incident Case No.' . $incident_id . '.pdf', 'I');
