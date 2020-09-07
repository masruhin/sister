<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdebku =$_GET['kdebku'];
$kdeang =$_GET['kdeang1'];
$query 	=mysql_query("	SELECT 	 	kdebku,kdeang 
						FROM  		t_gnrpjm 
						INNER JOIN 	t_dtlpjm 
						ON 			t_gnrpjm.nmrpjm=t_dtlpjm.nmrpjm
						WHERE   	t_dtlpjm.kdebku='$kdebku' AND 
									t_gnrpjm.kdeang ='$kdeang' ");
while($data =mysql_fetch_array($query))
{
   	$nmrpjm=$data['nmrpjm'];
   	$kdeang=$data['kdeang'];
    echo"$nmrpjm";
}
?>