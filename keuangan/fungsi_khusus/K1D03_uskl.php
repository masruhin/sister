<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$droo=$_GET['dr'];
$query =mysql_query("	SELECT 		*
						FROM 		t_mstssw
						WHERE 		t_mstssw.nmassw='$droo'");
$data	=mysql_fetch_array($query);
$nis	=$data['nis'];
$unskl=$data['unskl'];
$us=number_format($unskl);
echo"$us";
?>