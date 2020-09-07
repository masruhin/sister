<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

echo"<OPTION selected VALUE=''>--Pilih--</OPTION>";

$kdeplj = $_GET['kdeplj'];
$kdegru = $_GET['kdegru'];
$query 	=mysql_query("	SELECT 	g_gnrsal.*
						FROM 	g_gnrsal
						WHERE 	g_gnrsal.kdeplj='$kdeplj' AND
                                g_gnrsal.kdegru='$kdegru'
						ORDER BY kdeplj");
while($data =mysql_fetch_array($query))
{
   	$ktr=$data['ktr'];
	echo"<OPTION VALUE='$ktr'>$ktr</OPTION>";
}
?>