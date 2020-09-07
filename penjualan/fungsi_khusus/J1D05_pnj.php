<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$nmabrn =$_GET['nmabrn'];
$query 	=mysql_query("	SELECT 		t_mstbrn.* 
						FROM 		t_mstbrn
						WHERE 		t_mstbrn.nmabrn='$nmabrn'");
while($data =mysql_fetch_array($query))
{
	$hrg=$data['hrg'];
	echo"$hrg";
}
?>