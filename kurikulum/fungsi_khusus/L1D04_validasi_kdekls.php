<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdekls	=$_POST['kdekls'];
$query 	=mysql_query("	SELECT 	t_mstkls.*
						FROM 	t_mstkls
						WHERE 	t_mstkls.kdekls='$kdekls'");
if(mysql_num_rows($query)>0)
{
	echo "no";
}
else
{
	echo "yes";
}
?>