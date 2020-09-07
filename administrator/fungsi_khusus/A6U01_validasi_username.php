<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$username	=$_POST['username'];
$query 		=mysql_query("	SELECT 		user.*
							FROM 		user
							WHERE 		user.username='$username'");
if(mysql_num_rows($query)>0)
{
	echo "no";
}
else
{
	echo "yes";
}
?>