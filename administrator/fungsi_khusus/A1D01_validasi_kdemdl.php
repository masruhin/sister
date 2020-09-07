<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdemdl	=$_POST['kdemdl'];
$query 	=mysql_query("	SELECT 		t_mstmdl.*
						FROM 		t_mstmdl
						WHERE 		t_mstmdl.kdemdl='$kdemdl'");
if(mysql_num_rows($query)>0)
{
	echo "no";
}
else
{
	echo "yes";
}
?>