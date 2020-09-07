<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

$id		=$_POST[id];
$kdekrm	=$_POST[kdekrm];
$kdekry	=$_POST[kdekry];
$utk	=$_POST[utk];
$sbj	=$_POST[sbj];
$isi	=$_POST[isi];
$atch	=$_POST[atch];
$tglkrm =date("d-m-Y/H:i:s");
       	
$set	="	SET    	
					g_krmeml.utk	='". mysql_escape_string($utk)."',
					g_krmeml.sbj	='". mysql_escape_string($sbj)."',
					g_krmeml.isi	='". mysql_escape_string($isi)."',
					g_krmeml.atch	='". mysql_escape_string($atch)."',
					g_krmeml.tglkrm	='". mysql_escape_string($tglkrm)."'";
								
$query 	="	UPDATE g_krmeml ".$set.
         "	WHERE 	g_krmeml.id	='". mysql_escape_string($id)."'";
$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
		
// read the list of emails from the file.
$kry = explode(',', $utk);
$total_kry = count($kry);
for ($c=0; $c<$total_kry; $c++)
{
	$tol=$kry[$c];
	$kder=$kdekrm;
	$kdek=$kdekry;
	$ut=$tol;
	$sbj=$sbj;
	$ktr=$isi;
	$atch=$atch;
	$tglkrm=$tglkrm;
	$stt='';
	$setrm	="	SET		    g_trmeml.kdetrm	='". mysql_escape_string($kder)."',
							g_trmeml.dri	='". mysql_escape_string($kdek)."',
							g_trmeml.utk	='". mysql_escape_string($ut)."',
							g_trmeml.sbj	='". mysql_escape_string($sbj)."',
							g_trmeml.isi	='". mysql_escape_string($ktr)."',
							g_trmeml.atch	='". mysql_escape_string($atch)."',
							g_trmeml.tglkrm	='". mysql_escape_string($tglkrm)."',
							g_trmeml.stt	='". mysql_escape_string($stt)."'";
	$query 	="	INSERT INTO g_trmeml ".$setrm;
	$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
}	
?>