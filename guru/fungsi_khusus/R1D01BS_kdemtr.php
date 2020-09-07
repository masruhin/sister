<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kdemtr1 =nomor_bsl();
$kdeklm =$_GET['kdeklm'];
$kdeplj =$_GET['kdeplj'];

$query 	=mysql_query("	SELECT 	g_gnrbsl.*
						FROM   	g_gnrbsl
						WHERE	g_gnrbsl.kdeklm='$kdeklm'	AND
								g_gnrbsl.kdeplj='$kdeplj'");
while($data =mysql_fetch_array($query))
if($kdeklm==''AND $kdeplj=='')
{
  echo"$kdemtr1";
}
else
{
	$kdemtr=$data['kdebsl'];
	echo"$kdemtr";
 }
?>