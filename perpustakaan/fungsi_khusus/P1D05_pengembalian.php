<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
 
$kdeang =$_GET['kdeang'];
$query 	=mysql_query("	SELECT 		*,t_mststt.kdestt
						FROM 		t_gnrpjm,t_mststt
						WHERE 		t_gnrpjm.kdeang='$kdeang' AND
									t_gnrpjm.stt = t_mststt.kdestt
						ORDER BY 	kdeang LIMIT 1 "); // 
while($data =mysql_fetch_array($query))
{
   	$nmastt=$data['nmastt'];
   	$kdeang=$data['kdeang'];
    echo"$nmastt";
}
?>