<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdeang=$_POST['kdeang'];
$query =mysql_query("	SELECT 		t_mstssw.*
						FROM 		t_mstssw
						WHERE 		t_mstssw.nis='$kdeang'");
if(mysql_num_rows($query)>0)
{
	echo "yes";
}
else
{
	echo "no";
}

// BUAT SISWA
?>