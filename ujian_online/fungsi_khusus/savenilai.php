<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdeoln	=$_GET['kdeoln'];
$nli	=$_GET['nli'];

$query 	=mysql_query("	SELECT 	u_gnroln.*
						FROM 	u_gnroln
						WHERE  	u_gnroln.kdeoln = '$kdeoln'");
$result =mysql_fetch_assoc($query);

$query ="	UPDATE 	u_gnroln
			SET		u_gnroln.nli	='". mysql_escape_string($nli)."'
			WHERE 	u_gnroln.kdeoln	='". mysql_escape_string($kdeoln)."'";
$result	=mysql_query ($query)or die(error("Data tidak berhasil di Input")) ;
				
echo"<meta http-equiv='refresh' content=\"0;url=../index.php\">\n";
?>