<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdestt	=$_POST['kdestt'];
$query 	=mysql_query("	SELECT 	t_sttkry.*
						FROM 	t_sttkry
						WHERE 	t_sttkry.kdestt='$kdestt'");
if(mysql_num_rows($query)>0)
{
	echo "no";
}
else
{
	echo "yes";
}
?>