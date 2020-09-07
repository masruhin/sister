<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$soal 	=$_GET['id'];
$kdemtr =$_GET['kdemtr'];
$typ =$_GET['type'];
$nmamtr =$_GET['nmamtr'];
$sql	="	DELETE 
			FROM 	{$prefix}g_dtlmtr 
			WHERE 	id='$soal'";
mysql_query($sql)or die (error("Data tidak berhasil di hapus"));

echo"$kdemtr $nmamtr";

$file= "../../files/materi/$kdemtr/$nmamtr.$typ";
if (file_exists($file))
				unlink($file);
?>