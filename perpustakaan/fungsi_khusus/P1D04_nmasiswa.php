<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

//$userid_x	=$_SESSION["Admin"]["userid"];	// buatan d $userid_x
$kdeang=$_GET['kdeang'];

/*$query='';
if($userid_x==66 OR $userid_x=='66')
{
	$query =mysql_query("	SELECT 		*
						FROM 		t_mstssw
						WHERE 		t_mstssw.nis = '".substr($kdeang,0,3)."PG' OR 
									t_mstssw.nis = '".substr($kdeang,0,3)."TK' OR 
									t_mstssw.nis = '".substr($kdeang,0,3)."SD' ");
}
else// if($userid_x==85 OR $userid_x=='85')
{
	$query =mysql_query("	SELECT 		*
							FROM 		t_mstssw
							WHERE 		t_mstssw.nis = '".substr($kdeang,0,3)."SMP' OR 
										t_mstssw.nis = '".substr($kdeang,0,3)."SMA' ");
}*/
$query =mysql_query("	SELECT 		*
						FROM 		t_mstssw
						WHERE 		t_mstssw.nis='$kdeang' ");
$data	=mysql_fetch_array($query) or die (mysql_error());
$nmassw	=$data['nmassw'];
echo"$nmassw";
//--	penambahan nama karyawan jika diminta, buatan d


	if(mysql_num_rows($query)=='0')
	{
		echo
			"<SCRIPT LANGUAGE='JavaScript'>
				window.alert(' ".$kdeang." bukan kode siswa  ');
				exit();
			</SCRIPT>";
	}


// BUAT SISWA
?>