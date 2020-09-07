<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$id		=$_POST['id'];
$kdercu	=$_POST['kdercu'];
//$soal	=$_POST['soal'];
$soal	=str_replace('}','+',$_POST['soal']);
$sttjwb	=$_POST['sttjwb'];
$bbtnli	=$_POST['bbtnli'];

$query 	=mysql_query("	SELECT 	*
						FROM 	g_dtlrcu
						WHERE  	 g_dtlrcu.kdercu='$kdercu' AND g_dtlrcu.soal='$soal'");
$result =mysql_fetch_assoc($query);

if(mysql_num_rows($query)== "")
{
    $set	="	SET	g_dtlrcu.kdercu	='". mysql_escape_string($kdercu)."',
					g_dtlrcu.soal	='". mysql_escape_string($soal)	."',
					g_dtlrcu.sttjwb	='". mysql_escape_string($sttjwb)."',
					g_dtlrcu.bbtnli	='". mysql_escape_string($bbtnli)."'";
	$query1 ="INSERT INTO g_dtlrcu ".$set;
	$q 		=mysql_query ($query1)or die(error("Data tidak berhasil di Input")) ;
}
else
{
	echo"
	<SCRIPT LANGUAGE='JavaScript'>
		window.alert('Soal Sudah Ada dalam Rencana Ujian')
	</SCRIPT>";
}
?>