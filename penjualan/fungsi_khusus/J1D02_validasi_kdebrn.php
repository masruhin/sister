<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdebrn=$_POST['kdebrn'];
$query =mysql_query("	SELECT 	t_mstbrn.*
						FROM 	t_mstbrn
						WHERE 	t_mstbrn.kdebrn='$kdebrn'");
if(mysql_num_rows($query)>0)
{
	echo "no";
}
else
{
	echo "yes";
}
?>