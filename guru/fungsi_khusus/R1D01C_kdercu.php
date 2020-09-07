<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kdegru =$_GET['kdegru'];
$kdeplj =$_GET['kdeplj'];

$query 	=mysql_query("SELECT 		g_gnrrcu.*
						FROM   		g_gnrrcu
						WHERE   	g_gnrrcu.kdegru='$kdegru'AND
									g_gnrrcu.kdeplj='$kdeplj'
						ORDER BY  	g_gnrrcu.kdercu desc LIMIT 1");
while($data =mysql_fetch_array($query))
{
   	$kdercu=$data['kdercu'];
    echo"$data[kdercu]";
}
?>