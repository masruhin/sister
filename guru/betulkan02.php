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

$kdetkt	='KG';

$query ="	SELECT 		t_mstssw.*,t_mstkls.*,t_klmkls.*
			FROM 		t_mstssw,t_mstkls,t_klmkls
			WHERE 		t_mstssw.kdekls=t_mstkls.kdekls	AND
						t_mstkls.kdeklm=t_klmkls.kdeklm AND
						t_klmkls.kdetkt='$kdetkt'";
$result =mysql_query($query);
while($data =mysql_fetch_array($result))
{
	$nis=$data[nis];
	$nol=0;
	
	$query2 ="	SELECT 		t_setpgrpt.*
				FROM 		t_setpgrpt
				WHERE 		t_setpgrpt.kdetkt='$kdetkt'	AND
							t_setpgrpt.idlama!='$nol'";
	$result2 =mysql_query($query2);
	while($data2 =mysql_fetch_array($result2))
	{
		$idlama	=$data2[idlama];
		$id		=$data2[id];

		$query3 ="	SELECT 		t_prgrptpg.*
					FROM 		t_prgrptpg
					WHERE 		t_prgrptpg.nis='$nis'	AND
								t_prgrptpg.idlama='$idlama'";
		$result3 =mysql_query($query3);
		
		$set	="	SET		t_prgrptpg.id	='$id'";
		$query4 ="	UPDATE 	t_prgrptpg ".$set.
				 "	WHERE 	t_prgrptpg.nis='$nis' AND
							t_prgrptpg.idlama='$idlama'";
		$result4=mysql_query ($query4);
	}	

	$set	="	SET		t_prgrptpg.nis	='$nis',
						t_prgrptpg.id	='4'";
							
	$query4 	="INSERT INTO t_prgrptpg ".$set;
	$result4 	=mysql_query ($query4);								
	$set	="	SET		t_prgrptpg.nis	='$nis',
						t_prgrptpg.id	='15'";
							
	$query4 	="INSERT INTO t_prgrptpg ".$set;
	$result4 	=mysql_query ($query4);		

	$set	="	SET		t_prgrptpg.nis	='$nis',
						t_prgrptpg.id	='17'";
							
	$query4 	="INSERT INTO t_prgrptpg ".$set;
	$result4 	=mysql_query ($query4);		

	$set	="	SET		t_prgrptpg.nis	='$nis',
						t_prgrptpg.id	='30'";
							
	$query4 	="INSERT INTO t_prgrptpg ".$set;
	$result4 	=mysql_query ($query4);		

	$set	="	SET		t_prgrptpg.nis	='$nis',
						t_prgrptpg.id	='31'";
							
	$query4 	="INSERT INTO t_prgrptpg ".$set;
	$result4 	=mysql_query ($query4);								
}
?>