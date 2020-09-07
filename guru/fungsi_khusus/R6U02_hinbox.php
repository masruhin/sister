<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

foreach($_POST['id'] as $value)
{ 

$query1	="	SELECT g_trmeml.*
					FROM g_trmeml
					WHERE g_trmeml.id='$value'";
		$result	=mysql_query($query1);
        $data1	=mysql_fetch_array($result);
        $kdetrm	=$data1['kdetrm'];
$inbox = '../../guru/file_email/terima/'.$kdetrm;
if(file_exists($inbox))
{
   if (is_dir($inbox))
      $dir_handle = opendir($inbox);
   if (!$dir_handle)
      return false;
   while($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
         if (!is_dir($inbox."/".$file))
            unlink($inbox."/".$file);
         else
            delete_directory($inbox.'/'.$file);    
      }
   }
   closedir($dir_handle);
   rmdir($inbox);
 }
  $del = mysql_query("DELETE FROM g_trmeml WHERE id='$value'");
if($del)
{
	echo"
    <script type='text/javascript'>
		window.location.href='../guru.php?mode=R6U02';
	</script>";
}
}	
?>