<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdejku	=$_POST['kdejku'];
$query 	=mysql_query("	SELECT 		*
						FROM 		t_jku
						WHERE 		kdejku='$kdejku'");
if(mysql_num_rows($query)>0)
{
	echo "no";
}
else
{
	echo "yes";
}
?>