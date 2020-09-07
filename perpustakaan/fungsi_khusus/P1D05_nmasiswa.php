<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdeang=$_GET['kdeang'];
/*$query =mysql_query("	SELECT 		*
						FROM 		t_mstssw
						WHERE 		t_mstssw.nis='$kdeang'");
$data	=mysql_fetch_array($query) or die (mysql_error());
$nmassw	=$data['nmassw'];
echo"$nmassw";*/
//--	penambahan nama karyawan jika diminta, buatan d


	//if(mysql_num_rows($query)=='0')
	if( substr($kdeang,0,1)=='M' )
	{
		$query =mysql_query("	SELECT 		*
								FROM 		t_mstkry
								WHERE 		t_mstkry.kdekry='$kdeang'");
		$data	=mysql_fetch_array($query);
		$nmassw	=$data['nmakry'];
		echo"$nmassw";
	}
	else
	{
		$query =mysql_query("	SELECT 		*
						FROM 		t_mstssw
						WHERE 		t_mstssw.nis='$kdeang'");
		$data	=mysql_fetch_array($query) or die (mysql_error());
		$nmassw	=$data['nmassw'];
		echo"$nmassw";
	}


// BUAT SISWA
?>