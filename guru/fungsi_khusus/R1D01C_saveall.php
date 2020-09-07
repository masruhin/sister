<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
$pilih=$_POST['pilih'];
$kdesl	=$_POST['kdesl'];
$kdercu	=$_POST['kdercu'];
$kdercu2	=$_POST['kdercu2'];

if($pilih=='banksoal')
{
$query 	="	INSERT INTO g_dtlrcu (kdercu,soal,sttjwb,bbtnli)
            SELECT 	'$kdercu' as kdercu,soal,sttjwb,bbtnli
			FROM 	g_dtlsal
			where 	g_dtlsal.kdesl='$kdesl'";
$result	=mysql_query ($query) or die(error("Data tidak berhasil di Input")) ;
}
else
if($pilih=='rencanasoal')
{
$query 	="	INSERT INTO g_dtlrcu (kdercu,soal,sttjwb,bbtnli)
            SELECT 	'$kdercu' as kdercu,soal,sttjwb,bbtnli
			FROM 	g_dtlrcu
			where 	g_dtlrcu.kdercu='$kdercu2'";
$result	=mysql_query ($query) or die(error("Data tidak berhasil di Input")) ;
}

?>