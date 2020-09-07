<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$d=$_GET['kdekrm'];
$handle1 = is_dir("../../guru/file_email/kirim/$d");
        if($handle1=='')
        {
			mkdir("../../guru/file_email/kirim/".$d, 0775);
        }
$handle2 = is_dir("../../guru/file_email/terima/$d");
        if($handle2=='')
        {
			mkdir("../../guru/file_email/terima/".$d, 0775);
        }
$uploaddir = '../../guru/file_email/kirim/'.$d.'/'; 
$uploaddir1 = '../../guru/file_email/terima/'.$d.'/';
$dh=$_FILES['uploadfile']['name'];
$df=$dh;
$file = $uploaddir . basename($df);
$files = $uploaddir1 . basename($df);  
$mv = move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file);
if ($mv) {
  echo "success";
 copy($file,$files);
} else {
	echo "error";
}
?>