<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04H_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: ini untuk samakan nilai midterm dgn midterm lain
//----------------------------------------------------------------------------------------------------
require_once '../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdekls	='JHS-9B';

$query ="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='$kdekls'";
$result =mysql_query($query);
while($data =mysql_fetch_array($result))
{
	$nis=$data[nis];

	$set	="	SET		t_prgrptps.hw221	=t_prgrptps.hw211,
						t_prgrptps.hw222	=t_prgrptps.hw212,
						t_prgrptps.hw223	=t_prgrptps.hw213,
						t_prgrptps.hw224	=t_prgrptps.hw214,
						t_prgrptps.hw225	=t_prgrptps.hw215,
						t_prgrptps.prj221	=t_prgrptps.prj211,
						t_prgrptps.prj222	=t_prgrptps.prj212,
						t_prgrptps.prj223	=t_prgrptps.prj213,
						t_prgrptps.prj224	=t_prgrptps.prj214,
						t_prgrptps.prj225	=t_prgrptps.prj215,
						t_prgrptps.tes221	=t_prgrptps.tes211,
						t_prgrptps.tes222	=t_prgrptps.tes212,
						t_prgrptps.tes223	=t_prgrptps.tes213,
						t_prgrptps.tes224	=t_prgrptps.tes214,
						t_prgrptps.tes225	=t_prgrptps.tes215,
						t_prgrptps.midtes22	=t_prgrptps.midtes21,
						t_prgrptps.akh22	=t_prgrptps.akh21";
	$query1 ="	UPDATE 	t_prgrptps ".$set.
			"	WHERE 	t_prgrptps.nis='$nis'  and
						t_prgrptps.akh22=0";
	$result1=mysql_query ($query1) or die (error("Data tidak berhasil di Rubah"));
}

$set	="	SET		t_rtpsrpt.rt22	=t_rtpsrpt.rt21";
$query1 ="	UPDATE 	t_rtpsrpt ".$set.
		"	WHERE 	t_rtpsrpt.kdekls='$kdekls' and
					t_rtpsrpt.rt22=0";
$result1=mysql_query ($query1) or die (error("Data tidak berhasil di Rubah"));
?>