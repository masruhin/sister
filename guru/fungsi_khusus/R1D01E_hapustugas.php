<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$soal 	=$_GET['id'];
$kdetgs =$_GET['kdetgs'];
$typ =$_GET['type'];
$nmatgs =$_GET['nmatgs'];




$sql	="	DELETE 
			FROM 	{$prefix}g_dtltgs 
			WHERE 	id='$soal'";
mysql_query($sql)or die (error("Data tidak berhasil di hapus"));

echo"$kdetgsa";

$file= "../../files/materi/$kdetgs/$nmatgs.$typ";
if (file_exists($file))
				unlink($file);
?>