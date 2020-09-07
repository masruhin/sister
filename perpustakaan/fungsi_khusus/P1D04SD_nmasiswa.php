<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdeang=$_GET['kdeang'];
$kdekls=$_GET['kdekls'];
$query =mysql_query("	SELECT 		*
						FROM 		t_mstssw
						WHERE 		t_mstssw.nis='$kdeang' AND t_mstssw.kdekls='$kdekls' ");
$data	=mysql_fetch_array($query) or die (mysql_error());
$nmassw	=$data['nmassw'];
echo"$nmassw";
//--	penambahan nama karyawan jika diminta, buatan d


	if(mysql_num_rows($query)=='0')
	{
		echo
			"<SCRIPT LANGUAGE='JavaScript'>
				window.alert(' ".$kdeang." bukan kode siswa  ');
			</SCRIPT>";
	}


// BUAT SISWA
?>