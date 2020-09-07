<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$id		=$_POST['id'];
$kdercu	=$_POST['kdercu'];
$soal	=$_POST['soal'];
$jwb1	=$_POST['jwb1'];
$jwb2	=$_POST['jwb2'];
$jwb3	=$_POST['jwb3'];
$jwb4	=$_POST['jwb4'];
$jwb5	=$_POST['jwb5'];
$sttjwb	=$_POST['sttjwb'];
$kdegbr	=$_POST['kdegbr'];

$query 	=mysql_query("	SELECT 	*
						FROM 	g_dtlrcu
						WHERE  	 g_dtlrcu.kdercu='$kdercu' AND g_dtlrcu.soal='$soal'");
$result =mysql_fetch_assoc($query);

if(mysql_num_rows($query)== "")
{
    $set	="	SET	g_dtlrcu.kdercu	='". mysql_escape_string($kdercu)."',
					g_dtlrcu.soal	='". mysql_escape_string($soal)	."',
					g_dtlrcu.jwb1	='". mysql_escape_string($jwb1)	."',
					g_dtlrcu.jwb2	='". mysql_escape_string($jwb2)	."',
					g_dtlrcu.jwb3	='". mysql_escape_string($jwb3)	."',
					g_dtlrcu.jwb4	='". mysql_escape_string($jwb4)	."',
					g_dtlrcu.jwb5	='". mysql_escape_string($jwb5)	."',
					g_dtlrcu.sttjwb	='". mysql_escape_string($sttjwb)."',
					g_dtlrcu.kdegbr	='". mysql_escape_string($kdegbr)."'";
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