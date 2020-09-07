<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdejrs	=$_POST['kdejrs'];
$query 	=mysql_query("	SELECT 	t_mstjrs.*
						FROM 	t_mstjrs
						WHERE 	t_mstjrs.kdejrs='$kdejrs'");
if(mysql_num_rows($query)>0)
{
	echo "no";
}
else
{
	echo "yes";
}
?>