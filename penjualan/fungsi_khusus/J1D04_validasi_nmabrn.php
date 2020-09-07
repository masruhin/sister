<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$nmabrn=$_POST['nmabrn'];
$query =mysql_query("	SELECT 	t_mstbrn.*
						FROM 	t_mstbrn
						WHERE 	t_mstbrn.nmabrn='$nmabrn'");
if(mysql_num_rows($query)>0)
{
	echo "yes";
}
else
{
	echo "no";
}
?>