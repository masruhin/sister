<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

foreach($_POST['id'] as $value)
{ 
$query	="	SELECT g_krmeml.*
					FROM g_krmeml
					WHERE g_krmeml.id='$value'";
		$result	=mysql_query($query);
        $data	=mysql_fetch_array($result);
        $kdekrm	=$data['kdekrm'];
$outbox = '../../guru/file_email/kirim/'.$kdekrm;
if(file_exists($outbox))
{
   if (is_dir($outbox))
      $dir_handle = opendir($outbox);
   if (!$dir_handle)
      return false;
   while($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
         if (!is_dir($outbox."/".$file))
            unlink($outbox."/".$file);
         else
            delete_directory($outbox.'/'.$file);    
      }
   }
   closedir($dir_handle);
   rmdir($outbox);

}
	$del = mysql_query("DELETE FROM g_krmeml WHERE id='$value'");
	if($del)
{
	echo"
    <script type='text/javascript'>
		window.location.href='../guru.php?mode=R6U02';
	</script>";
}
        
}

?>