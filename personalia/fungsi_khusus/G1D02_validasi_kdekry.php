<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdekry	=$_POST['kdekry'];
$query 	=mysql_query("	SELECT 	t_mstkry.*
						FROM 	t_mstkry
						WHERE 	t_mstkry.kdekry='$kdekry'");
if(mysql_num_rows($query)>0)
{
	echo "no";
}
else
{
	echo "yes";
}
?>