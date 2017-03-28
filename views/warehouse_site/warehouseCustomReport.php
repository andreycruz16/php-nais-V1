<?php
include('session.php');
require_once('tcpdf/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        // $image_file = K_PATH_IMAGES.'logo_example.jpg';
        // $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        // Title
        // $this->writeHTML('<br>', true, false, true, false, '');
        // $this->Cell(0, 15, 'Report on the Physical Count of <item name>', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Ln();
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 8, 'Report on the Physical Count of <item desc> <partnumber>', 0, 0, 'C');
        $this->SetFont('helvetica', 'R', 8);
        $this->Ln();
        $this->Cell(0, 0, 'NICHIYU ASIALIFT PHILIPPINES, INC.', 0, 0, 'C');
        $this->Ln();
        $this->Cell(0, 0, '# 9M.FLORES ST. STO. ROSARIO SILANGAN, PATEROS M.M.', 0, 0, 'C');
        $this->Ln();
        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(0, 0, date('F d, Y'), 0, 0, 'C');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    }
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NICHIYU ASIALIFT');
$pdf->SetTitle('<title>');
// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

// set some text to print
$txt = '
<strong>From: </strong><i>'.date('F d, Y').'</i>&nbsp;&nbsp;&nbsp;&nbsp;<strong>To: </strong><i>'.date('F d, Y').'</i><br><br>
<table rules="all" border="1">
        <tr style="background-color:#313131; color:#fff;">
            <th align="center" width="40">#</th>
            <th align="center">Part #</th>
            <th align="center"> Description</th>
            <th align="center"> Date&nbsp;(M/D/Y)</th>
            <th align="center"> Quantity</th>
        </tr>';
require '../../database.php';
$sql = "SELECT tbl_warehouse.stock_id,
               tbl_warehouse.date,
               tbl_warehouse.description,
               tbl_reference.referenceType,
               tbl_warehouse.referenceNumber,
               tbl_warehouse.partNumber,
               tbl_warehouse.boxNumber,
               tbl_warehouse.quantity,
               tbl_warehouse.customerName,
               tbl_warehouse.model,
               tbl_warehouse.serialNumber,
               tbl_warehouse.minStockCount,
               tbl_transfer_type.transferType
        FROM tbl_warehouse
        INNER JOIN tbl_reference
        ON tbl_warehouse.reference_id = tbl_reference.reference_id
        INNER JOIN tbl_transfer_type
        ON tbl_warehouse.transferType_id = tbl_transfer_type.transferType_id;";

 $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $ctr = 1;
            while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                $stock_id = $row[0];
                $date = $row[1];
                $description = $row[2];
                $referenceType = $row[3];
                $referenceNumber = $row[4];
                $partNumber = $row[5];
                $boxNumber = $row[6];
                $quantity = $row[7];
                $customerName = $row[8];
                $model = $row[9];
                $serialNumber = $row[10];
                $minStockCount = $row[11];
                $transferType = $row[12];

$txt.='       
        <tr>
            <td align="center">'. $ctr .'</td>
            <td align=""> '. $partNumber .'</td>
            <td align=""> '. $description .'</td>
            <td align="center"> '. date('m/d/Y', strtotime($date)).'</td>
            <td align="center"> '. $quantity .'</td>
        </tr>                                                                   
    ';

                $ctr++;
            }
        }
        mysqli_close($conn);

$txt.='
</table>
    ';


// print a block of text using Write()
$pdf->writeHTML($txt, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('<title>.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+