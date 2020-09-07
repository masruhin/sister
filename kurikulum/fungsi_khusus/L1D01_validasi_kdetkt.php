<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdetkt	=$_POST['kdetkt'];
$query 	=mysql_query("	SELECT 	t_msttkt.*
						FROM 	t_msttkt
						WHERE 	t_msttkt.kdetkt='$kdetkt'");
if(mysql_num_rows($query)>0)
{
	echo "no";
}
else
{
	echo "yes";
}
?>