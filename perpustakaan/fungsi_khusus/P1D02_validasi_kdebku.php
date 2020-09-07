<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdebku	=$_POST['kdebku'];
$query 	=mysql_query("	SELECT 		t_dtlpjm.*
						FROM 		t_dtlpjm
						WHERE 		t_dtlpjm.kdebku='$kdebku'");
$data	=mysql_fetch_array($query);
$tglkmb	=$data[tglkmb];
if(mysql_num_rows($query)=='')
{
	echo "yes";
}
else
{
	echo "no";
}
?>