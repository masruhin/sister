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
$query 	="	INSERT INTO g_dtlrcu (kdercu,soal,jwb1,jwb2,jwb3,jwb4,jwb5,sttjwb,kdegbr)
            SELECT 	'$kdercu' as kdercu,soal,jwb1,jwb2,jwb3,jwb4,jwb5,sttjwb,CONCAT('$kdesl',id) as kdegbr
			FROM 	g_dtlsal
			where 	g_dtlsal.kdesl='$kdesl'";
$result	=mysql_query ($query) or die(error("Data tidak berhasil di Input")) ;
}
else
if($pilih=='rencanasoal')
{
$query 	="	INSERT INTO g_dtlrcu (kdercu,soal,jwb1,jwb2,jwb3,jwb4,jwb5,sttjwb,kdegbr)
            SELECT 	'$kdercu' as kdercu,soal,jwb1,jwb2,jwb3,jwb4,jwb5,sttjwb,kdegbr
			FROM 	g_dtlrcu
			where 	g_dtlrcu.kdercu='$kdercu2'";
$result	=mysql_query ($query) or die(error("Data tidak berhasil di Input")) ;
}

?>