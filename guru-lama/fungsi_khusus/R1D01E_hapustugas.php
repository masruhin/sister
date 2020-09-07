<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$soal 	=$_GET['id'];
$kdetgs =$_GET['kdetgs'];
$nmatgs =$_GET['nmatgs2'];

$files 	=glob('../files/tugas/$kdetgs/$nmatgs.pdf');
        
foreach($files as $file) 
{
	unlink($file);
}

$sql	="	DELETE 
			FROM 	{$prefix}g_dtltgs 
			WHERE 	id='$soal'";
mysql_query($sql)or die (error("Data tidak berhasil di hapus"));

echo"$kdetgs $nmatgs";
?>