<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdeklm	=$_POST['kdeklm'];
$query 	=mysql_query("	SELECT 	t_klmkls.*
						FROM 	t_klmkls
						WHERE 	t_klmkls.kdeklm='$kdeklm'");
if(mysql_num_rows($query)>0)
{
	echo "no";
}
else
{
	echo "yes";
}
?>