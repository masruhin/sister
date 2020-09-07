<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$soal 	=$_GET['id'];
$kdemtr =$_GET['kdemtr'];
$nmamtr =$_GET['nmamtr2'];

$files 	=glob('../files/materi/$kdemtr/$nmamtr.pdf');
        
foreach($files as $file) 
{
	unlink($file);
}

$sql	="	DELETE 
			FROM 	{$prefix}g_dtlmtr 
			WHERE 	id='$soal'";
mysql_query($sql)or die (error("Data tidak berhasil di hapus"));

echo"$kdemtr $nmamtr";
?>