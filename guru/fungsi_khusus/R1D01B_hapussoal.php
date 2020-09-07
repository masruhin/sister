<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$id 	=$_GET['id'];
$kdesl 	=$_GET['kdesl'];
$query	="	DELETE 
			FROM 	{$prefix}g_dtlsal 
			WHERE 	g_dtlsal.id ='$id'";
mysql_query($query) or die (error("Data tidak berhasil di hapus"));
?>