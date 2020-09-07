<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$id		=$_POST['id'];
$kdesl	=$_POST['kdesl'];
$kdeslB	=$_POST['kdeslB'];
$soal	=$_POST['soal'];
$jwb1	=$_POST['jwb1'];
$jwb2	=$_POST['jwb2'];
$jwb3	=$_POST['jwb3'];
$jwb4	=$_POST['jwb4'];
$jwb5	=$_POST['jwb5'];
$sttjwb	=$_POST['sttjwb'];
$phtsoal=$_FILES['phtsoal']['tmp_name'];
$pilihan=$_POST['pilihan'];

$query 	="	UPDATE 	g_dtlsal
			SET		g_dtlsal.soal	='". mysql_escape_string($soal)	."',
					g_dtlsal.jwb1	='". mysql_escape_string($jwb1)	."',
					g_dtlsal.jwb2	='". mysql_escape_string($jwb2)	."',
					g_dtlsal.jwb3	='". mysql_escape_string($jwb3)	."',
					g_dtlsal.jwb4	='". mysql_escape_string($jwb4)	."',
					g_dtlsal.jwb5	='". mysql_escape_string($jwb5)	."',
					g_dtlsal.sttjwb	='". mysql_escape_string($sttjwb)."'
			WHERE  	g_dtlsal.id		='". mysql_escape_string($id)."'";
$result	=mysql_query ($query)or die(error("Data tidak berhasil di Input")) ;

if($phtsoal=='')
{
	$newfile='';
}
else
{
	$newfile= "../files/photo/soal/$id.jpg";
	if (file_exists($newfile))
		unlink($newfile);
	move_uploaded_file($phtsoal, "../files/photo/soal/$id.jpg");
}
?>