<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdeang=$_GET['kdeang'];
/*$query =mysql_query("	SELECT 		*
						FROM 		t_mstssw
						WHERE 		t_mstssw.nis='$kdeang'");
$data	=mysql_fetch_array($query);
$nmassw	=$data['nmassw'];
echo"$nmassw";*/
//--	penambahan nama karyawan jika diminta, buatan d

	//if(mysql_num_rows($query)=='0')
	//{
		$query2 =mysql_query("	SELECT 		*
								FROM 		t_mstkry
								WHERE 		t_mstkry.kdekry='$kdeang'");
		$data	=mysql_fetch_array($query2);
		$nmassw	=$data['nmakry'];
		echo"$nmassw";
	//}

	// BUAT GURU
?>