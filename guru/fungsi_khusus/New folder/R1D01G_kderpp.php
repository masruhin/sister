<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kderpp1 =nomor_rpp();
$kdeklm =$_GET['kdeklm'];
$kdeplj =$_GET['kdeplj'];

$query 	=mysql_query("	SELECT 	g_gnrrpp.*
						FROM   	g_gnrrpp
						WHERE	g_gnrrpp.kdeklm='$kdeklm'	AND
								g_gnrrpp.kdeplj='$kdeplj'");
while($data =mysql_fetch_array($query))
if($kdeklm==''AND $kdeplj=='')
{
  echo"$kderpp1";
}
else
{
	$kderpp=$data['kderpp'];
	echo"$kderpp";
 }
?>