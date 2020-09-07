<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$id		=$_POST['id'];
$kdesl	=$_POST['kdesl'];
$kdeslB	=$_POST['kdeslB'];
$soal	=$_POST['soal'];
$sttjwb	=$_POST['sttjwb'];
$pilihan=$_POST['pilihan'];

$query 	="	UPDATE 	g_dtlsal
			SET		g_dtlsal.soal	='". mysql_escape_string($soal)	."',
					g_dtlsal.sttjwb	='". mysql_escape_string($sttjwb)."'
			WHERE  	g_dtlsal.id		='". mysql_escape_string($id)."'";
$result	=mysql_query ($query)or die(error("Data tidak berhasil di Input")) ;
?>