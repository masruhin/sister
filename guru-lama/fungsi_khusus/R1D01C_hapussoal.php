<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$id	=$_GET['id'];
$sql="	DELETE 
		FROM 	{$prefix}g_dtlrcu 
		WHERE 	g_dtlrcu.id	='$id'";
mysql_query($sql)or die (error("Data tidak berhasil di Rubah"));
?>