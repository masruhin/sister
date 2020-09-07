<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdejtu	=$_POST['kdejtu'];
$query 	= mysql_query("	SELECT 		*
						FROM 		t_jtu
						WHERE 		kdejtu='$kdejtu'");
if(mysql_num_rows($query)>0)
{
	echo "no";
}
else
{
	echo "yes";
}
?>