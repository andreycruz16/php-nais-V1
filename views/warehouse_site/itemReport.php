<?php
include('session.php');
require_once('tcpdf/tcpdf.php');

if($_GET['stock_id']) {
    $stock_id = $_GET['stock_id'];
} 

if($_GET['partNumber']) {
    $partNumber = $_GET['partNumber'];
}  

if($_GET['description']) {
    $description = $_GET['description'];
}  

if($_GET['quantity']) {
    $quantity = $_GET['quantity'];
}  

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

        $image_file = 'QrCodes/'.$_GET['partNumber'].'.png';
        $this->Image($image_file, 250, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Ln();
        $this->SetFont('helvetica', 'B', 12);
        // $this->Cell(0, 8, 'Report on the Physical Count of All Items', 0, 0, 'C');
        $this->Cell(0, 8, 'REPORT ON STOCK RECORD HISTORY ', 0, 0, 'C');
        $this->SetFont('helvetica', 'R', 8);
        $this->Ln();
        $this->Cell(0, 0, 'NICHIYU ASIALIFT PHILIPPINES, INC.', 0, 0, 'C');
        $this->Ln();
        $this->Cell(0, 0, '# 9M.FLORES ST. STO. ROSARIO SILANGAN, PATEROS M.M.', 0, 0, 'C');
        $this->Ln();
        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(0, 0, date('F d, Y'), 0, 0, 'C');
        // $this->writeHTML('<img width="50px" height="50px" title="'.$_GET['partNumber'].'" src="QrCodes/1.png" />');
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
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NICHIYU ASIALIFT');
$pdf->SetTitle('ItemReport_'.$partNumber.'_'.date('M-d-y'));
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
$txt = '<br><br>
<strong>Department: </strong><i>Warehouse</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>Description: </strong><i>'.$description.'</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>Part #: </strong><i>'.$partNumber.'</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>Current Quantity: </strong><i>'.$quantity.'</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br><br>



<table rules="all" border=".5" width="100%">
        <tr style="background-color:#313131; color:#fff;">
            <th align="center" width="6.5%"><i>#</i></th>
            <th align="center" width="12.5%"> Date (M/D/Y)</th>
            <th align="center" width="18.5%"> Reference&nbsp;Type</th>
            <th align="center" width="12.5%"> Reference&nbsp;#</th>
            <th align="center" width="14.5%"> Receiving&nbsp;Report</th>
            <th align="center" width="12.5%"> Transfer&nbsp;Type</th>
            <th align="center" width="10.5%"> +/-</th>
            <th align="center" width="12.5%"> Quantity</th>
        </tr>';
require '../../database.php';
$sql = "SELECT 
        tbl_warehouse_history.timestamp, 
        tbl_warehouse_history.date,
        tbl_reference.referenceType,
        tbl_warehouse_history.referenceNumber,
        tbl_warehouse_history.quantity,
        tbl_warehouse_history.quantityChange,
        tbl_transfer_type.transferType,
        tbl_users.username,
        tbl_warehouse_history.history_id,
        tbl_warehouse_history.receivingReport
        FROM tbl_warehouse_history 
        INNER JOIN tbl_reference
        ON tbl_warehouse_history.reference_id = tbl_reference.reference_id
        INNER JOIN tbl_transfer_type
        ON tbl_transfer_type.transferType_id = tbl_warehouse_history.transferType_id
        INNER JOIN tbl_users
        ON tbl_warehouse_history.user_id = tbl_users.user_id
        WHERE tbl_warehouse_history.stock_id = ".$stock_id."
        ORDER BY tbl_warehouse_history.history_id DESC;";

 $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $ctr = 1;
            while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                $timestamp = $row[0];
                $date = $row[1];
                $referenceType = $row[2];
                $referenceNumber = $row[3];
                $quantity = $row[4];
                $quantityChange = $row[5];
                $transferType = $row[6];
                $username = $row[7];
                $history_id = $row[8];
                $receivingReport = $row[9];

$txt.='       
        <tr>
            <td align="center">'. $ctr .'</td>
            <td align="center"> '. date('m/d/Y', strtotime($date)) .'</td>
            <td align="center"> '. $referenceType .'</td>
            <td align="center"> '. $referenceNumber .'</td>
            <td align="center"> '. $receivingReport .'</td>
            <td align="center"> '. $transferType .'</td>
            <td align="center"> '. $quantityChange .'</td>
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
$pdf->Output('ItemReport_'.$partNumber.'_'.date('M-d-y').'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+