<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

foreach($_POST['id'] as $value)
{   
  
	$del = mysql_query("DELETE FROM g_trmeml WHERE id='$value'");
	$del2 = mysql_query("DELETE FROM g_krmeml WHERE id='$value'");
        
}

if($del)
{
	echo"
    <script type='text/javascript'>
		window.location.href='../guru.php?mode=R6U02';
	</script>";
}
elseif($del2)
{
  echo"
	<script type='text/javascript'>
		window.location.href='../guru.php?mode=R6U021';
	</script>";
}
else
{
    echo"error";
}
?>