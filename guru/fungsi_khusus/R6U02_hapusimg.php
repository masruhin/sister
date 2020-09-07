<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$file 	=$_GET['file'];
$kdekrm 	=$_GET['kdekrm'];
$filea= "../../guru/file_email/kirim/$kdekrm/$file";
$fileb= "../../guru/file_email/terima/$kdekrm/$file";
if (file_exists($filea))
				unlink($filea);

if (file_exists($fileb))
				unlink($fileb);
?>