<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kdemtr1 =nomor_mtr();
$kdeklm =$_GET['kdeklm'];
$kdeplj =$_GET['kdeplj'];

$query 	=mysql_query("	SELECT 	g_gnrmtr.*
						FROM   	g_gnrmtr
						WHERE
								g_gnrmtr.kdeklm='$kdeklm'	AND
								g_gnrmtr.kdeplj='$kdeplj'");
while($data =mysql_fetch_array($query))
if($kdeklm==''AND $kdeplj=='')
{
  echo"$kdeklm1";
}
else
{
	$kdemtr=$data['kdemtr'];
	echo"$kdemtr";
 }
?>