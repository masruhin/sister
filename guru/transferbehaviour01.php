<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04H_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: ini untuk transfer behaviour dari subjek 1 ke subjek 2
//----------------------------------------------------------------------------------------------------
require_once '../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdekls1	='JHS-9A';
$kdekls2	='JHS-9B';
$pljlama='BIG';
$pljbaru='ENG';

$query ="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='$kdekls1' OR t_mstssw.kdekls='$kdekls2'";
$result =mysql_query($query);
while($data =mysql_fetch_array($result))
{
	$nis=$data[nis];
	
	$query2 	="	SELECT 	t_indbhvps.*
					FROM 	t_indbhvps
					WHERE 	t_indbhvps.nis='$nis' AND
							t_indbhvps.kdeplj='$pljlama'";
	$result2 =mysql_query($query2);
	
	while($data2 	=mysql_fetch_array($result2))
	{
		$id			=$data2[id];
		$idkdeplj	=207;
		$midtrm22	=$data2[midtrm22];

		$set	="	SET		t_indbhvps.midtrm22	='$midtrm22'";
		$query1 ="	UPDATE 	t_indbhvps ".$set.
				"	WHERE 	t_indbhvps.kdeplj='$pljbaru' AND
							t_indbhvps.nis='$nis'		and
							t_indbhvps.id='$id' and
							t_indbhvps.idkdeplj='$idkdeplj'";
		$result1=mysql_query ($query1) or die (error("Data tidak berhasil di Rubah"));
	}	
}
?>