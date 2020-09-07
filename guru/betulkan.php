<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04H_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdekls	='JHS-8B';
$pljlama='BIG';
$pljbaru='ENG';

$query ="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='$kdekls'";
$result =mysql_query($query);
while($data =mysql_fetch_array($result))
{
	$nis=$data[nis];
	
	$query2 	="	SELECT 	t_prgrptps.*
					FROM 	t_prgrptps
					WHERE 	t_prgrptps.nis='$nis' AND
							t_prgrptps.kdeplj='$pljlama'";
	$result2 =mysql_query($query2);
	$data2 	=mysql_fetch_array($result2);
	$hw121=$data2[hw121];
	$hw122=$data2[hw122];
	$hw123=$data2[hw123];
	$hw124=$data2[hw124];
	$hw125=$data2[hw125];
	$prj121=$data2[prj121];
	$prj122=$data2[prj122];
	$prj123=$data2[prj123];
	$prj124=$data2[prj124];
	$prj125=$data2[prj125];
	$tes121=$data2[tes121];
	$tes122=$data2[tes122];
	$tes123=$data2[tes123];
	$tes124=$data2[tes124];
	$tes125=$data2[tes125];
	
	$set	="	SET		t_prgrptps.hw121	='$hw121',
						t_prgrptps.hw122	='$hw122',
						t_prgrptps.hw123	='$hw123',
						t_prgrptps.hw124	='$hw124',
						t_prgrptps.hw125	='$hw125',
						t_prgrptps.prj121	='$prj121',
						t_prgrptps.prj122	='$prj122',
						t_prgrptps.prj123	='$prj123',
						t_prgrptps.prj124	='$prj124',
						t_prgrptps.prj125	='$prj125',
						t_prgrptps.tes121	='$tes121',
						t_prgrptps.tes122	='$tes122',
						t_prgrptps.tes123	='$tes123',
						t_prgrptps.tes124	='$tes124',
						t_prgrptps.tes125	='$tes125'";
	$query1 ="	UPDATE 	t_prgrptps ".$set.
			"	WHERE 	t_prgrptps.kdeplj='$pljbaru' AND
						t_prgrptps.nis='$nis'";
	$result1=mysql_query ($query1);
}
?>