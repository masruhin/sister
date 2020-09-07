<?php
session_start();
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kdekry	=$_SESSION["Admin"]["kdekry"];
$stt='';

// untuk mendapatkan kode guru
$query="	SELECT COUNT(utk) as jum
			FROM 	g_trmeml
			WHERE 	g_trmeml.utk='$kdekry' AND
					g_trmeml.stt='$stt'";
$result=mysql_query($query);
$data=mysql_fetch_array($result);
$utk=$data['jum'];
echo"<b>$utk</b>";
?>