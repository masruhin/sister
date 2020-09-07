<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

echo"<OPTION selected VALUE=''>--Select--</OPTION>";

$kdeplj = $_GET['kdeplj'];
$kdegru = $_GET['kdegru'];
$query 	=mysql_query("	SELECT 	g_gnrrcu.*
						FROM 	g_gnrrcu
						WHERE 	g_gnrrcu.kdeplj='$kdeplj' AND
                                g_gnrrcu.kdegru='$kdegru'
						ORDER BY g_gnrrcu.kdercu");
while($data =mysql_fetch_array($query))
{
   	$ktr=$data['ktr'];
	$kdercu=$data['kdercu'];
	echo"<OPTION VALUE='$kdercu'>$ktr</OPTION>";
}
?>