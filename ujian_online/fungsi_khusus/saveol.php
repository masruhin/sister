<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$id		=$_POST['id'];
$kdeoln	=$_POST['kdeoln'];
$sttjwb1=$_POST['sttjwb'];

$query 	=mysql_query("	SELECT 	u_dtloln.*
						FROM 	u_dtloln
						WHERE  	u_dtloln.id = '$id' AND u_dtloln.kdeoln='$kdeoln'");
$result =mysql_fetch_assoc($query);

$query 	="	UPDATE 	u_dtloln
			SET		u_dtloln.sttjwb1='". mysql_escape_string($sttjwb1)."'
			WHERE 	u_dtloln.id		='". mysql_escape_string($id)."'";
$result =mysql_query ($query)or die(error("Data tidak berhasil di Input")) ;
?>