<?php
function buatQR($objek)
{
    //set it to writable location, a place for QRtemp generated PNG files
    //$PNG_QRtemp_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'QRtemp'.DIRECTORY_SEPARATOR;
	
	$PNG_QRtemp_DIR = '../../'.DIRECTORY_SEPARATOR.'/files/QRtemp'.DIRECTORY_SEPARATOR;
    include "/qrcode/qrlib.php";    
    
    //ofcourse we need rights to create QRtemp dir
    if (!file_exists($PNG_QRtemp_DIR))
        mkdir($PNG_QRtemp_DIR);
    
    $filename = $PNG_QRtemp_DIR.$objek.'.png';
    
    //remember to sanitize user input in real-life solution !!! (pilihan 'L','M','Q','H')
    $errorCorrectionLevel = 'H';

	//remember to sanitize user input in real-life solution !!! (pilihan 1 - 10)	
    $matrixPointSize = 10;

    $filename = $PNG_QRtemp_DIR.$objek.'.png';
    QRcode::png($objek, $filename, $errorCorrectionLevel, $matrixPointSIZE, 2);    
}
?>