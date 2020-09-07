<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdeang	=$_POST['kdeang'];
$query1 = mysql_query("	SELECT 		t_mstssw.*
						FROM 		t_mstssw
						WHERE 		t_mstssw.nis='$kdeang'");

$query2 = mysql_query("	SELECT 		t_mstkry.*
						FROM 		t_mstkry
						WHERE 		t_mstkry.kdekry='$kdeang'");
if(mysql_num_rows($query1)>0)
{
	echo "yes";
}
else
	if(mysql_num_rows($query2)>0)
	{
		echo "yes";
	}
	else
	{
		echo"no";
	}
?>