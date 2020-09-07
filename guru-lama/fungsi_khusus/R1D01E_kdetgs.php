<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kdetgs1 =nomor_tgs();
$kdeklm =$_GET['kdeklm'];
$kdeplj =$_GET['kdeplj'];

$query 	=mysql_query("	SELECT 	g_gnrtgs.*
						FROM   	g_gnrtgs
						WHERE
								g_gnrtgs.kdeklm='$kdeklm'	AND
								g_gnrtgs.kdeplj='$kdeplj'");
while($data =mysql_fetch_array($query))
if($kdeklm==''AND $kdeplj=='')
{
  echo"$kdeklm1";
}
else
{
	$kdetgs=$data['kdetgs'];
	echo"$kdetgs";
 }
?>