<?php    

    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'myQrCodes'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'myQrCodes/';

    include "qrlib.php";
    
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);

    $qrValue = '1234-1234';
    $filename = $PNG_TEMP_DIR.$qrValue;
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 10;
    
 
    QRcode::png($qrValue, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
       
    //display generated file
    echo '<img title="'.$qrValue.'" src="'.$PNG_WEB_DIR.basename($filename).'" />';  