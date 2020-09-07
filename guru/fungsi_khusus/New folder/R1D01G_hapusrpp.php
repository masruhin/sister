<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$soal 	=$_GET['id'];
$kderpp =$_GET['kderpp'];
$typ =$_GET['type'];
$nmarpp =$_GET['nmarpp'];
$sql	="	DELETE 
			FROM 	{$prefix}g_dtlrpp 
			WHERE 	id='$soal'";
mysql_query($sql)or die (error("Data tidak berhasil di hapus"));

echo"$kderpp $nmarpp";

$file= "../../files/rpp/$kderpp/$nmarpp.$typ";
if (file_exists($file))
				unlink($file);
?>