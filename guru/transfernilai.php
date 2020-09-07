<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04H_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: ini untuk samakan nilai ingris -> english atau sebaliknya
//----------------------------------------------------------------------------------------------------
require_once '../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdekls	='JHS-9B';
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
	$hw221=$data2[hw221];
	$hw222=$data2[hw222];
	$hw223=$data2[hw223];
	$hw224=$data2[hw224];
	$hw225=$data2[hw225];
	$prj221=$data2[prj221];
	$prj222=$data2[prj222];
	$prj223=$data2[prj223];
	$prj224=$data2[prj224];
	$prj225=$data2[prj225];
	$tes221=$data2[tes221];
	$tes222=$data2[tes222];
	$tes223=$data2[tes223];
	$tes224=$data2[tes224];
	$tes225=$data2[tes225];
	$midtes22=$data2[midtes22];
	$akh22=$data2[akh22];
	
	$set	="	SET		t_prgrptps.hw221	='$hw221',
						t_prgrptps.hw222	='$hw222',
						t_prgrptps.hw223	='$hw223',
						t_prgrptps.hw224	='$hw224',
						t_prgrptps.hw225	='$hw225',
						t_prgrptps.prj221	='$prj221',
						t_prgrptps.prj222	='$prj222',
						t_prgrptps.prj223	='$prj223',
						t_prgrptps.prj224	='$prj224',
						t_prgrptps.prj225	='$prj225',
						t_prgrptps.tes221	='$tes221',
						t_prgrptps.tes222	='$tes222',
						t_prgrptps.tes223	='$tes223',
						t_prgrptps.tes224	='$tes224',
						t_prgrptps.tes225	='$tes225',
						t_prgrptps.midtes22	='$midtes22',
						t_prgrptps.akh22	='$akh22'";
	$query1 ="	UPDATE 	t_prgrptps ".$set.
			"	WHERE 	t_prgrptps.kdeplj='$pljbaru' AND
						t_prgrptps.nis='$nis'";
	$result1=mysql_query ($query1) or die (error("Data tidak berhasil di Rubah"));
}
?>