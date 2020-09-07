<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdejtu	=$_GET['kdejtu'];
$nis	=$_GET['nis'];
$query 	= mysql_query("	SELECT 		*
						FROM 		t_btukng
						WHERE 		kdejtu='$kdejtu'AND
                                    nis   ='$nis'");
if(mysql_num_rows($query)=='')
{
	echo "B";
}
else
{
	echo "A";
}
?>