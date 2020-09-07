<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdektg=$_POST['kdektg'];
$query =mysql_query("	SELECT 		t_ktg.*
						FROM 		t_ktg
						WHERE 		t_ktg.kdektg='$kdektg'");
if(mysql_num_rows($query)>0)
{
	echo "no";
}
else
{
	echo "yes";
}
?>