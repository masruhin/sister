<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$prd 	=periode("PENJUALAN");
$kb 	=$_GET['kdebrn'];
$query 	=mysql_query("	SELECT 	t_sldbrn.*
						FROM 	t_sldbrn
						WHERE 	t_sldbrn.prd='$prd'		AND
								t_sldbrn.kdebrn='$kb'");
while($data =mysql_fetch_array($query))
{
	$cekstok=$data['sldawl']+$data['msk']-$data['klr'];
	echo"$cekstok";
}
?>