<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdegru =$_GET['kdegru'];
$kdeplj =$_GET['kdeplj'];

$query 	=mysql_query("	SELECT 		g_gnrsal.*
						FROM   		g_gnrsal
						WHERE   	g_gnrsal.kdegru='$kdegru'AND
									g_gnrsal.kdeplj='$kdeplj'
						ORDER BY  	g_gnrsal.kdesl desc LIMIT 1");
while($data =mysql_fetch_array($query))
{
   	$kdesl=$data['kdesl'];
    echo"$kdesl";
}
?>