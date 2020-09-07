<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
 
echo"
<OPTION selected VALUE=''>--All Class--</OPTION>";
$kdegru =$_GET['kdegru'];
$kdeplj =$_GET['kdeplj'];

$query2	="	SELECT 		t_prstkt.* 
			FROM 		t_prstkt
			WHERE 		t_prstkt.kdekry='$kdegru' 
			ORDER BY 	t_prstkt.kdekry";
$result2	=mysql_query($query2);
$kdejbt=1000;
while($data2=mysql_fetch_array($result2))
{
	if($data2[kdejbt]<$kdejbt AND $data2[kdejbt]!='')
		$kdejbt	=$data2[kdejbt];
}	

if(($kdejbt<400 OR $kdejbt==900) AND $kdejbt!=500)
{
	$query2="	SELECT 		t_mstpng.*,t_mstkls.kdekls
				FROM		t_mstkls,t_mstpng
				WHERE		t_mstpng.kdeplj='$kdeplj'AND
							t_mstpng.kdekls=t_mstkls.kdekls
				ORDER BY	t_mstkls.kdeklm,t_mstkls.kdekls";
}
if($kdejbt==400)
{
	$query2="	SELECT 		t_mstpng.*,t_mstkls.kdekls
				FROM		t_mstkls,t_mstpng
				WHERE		t_mstpng.kdegru='$kdegru' AND
							t_mstpng.kdeplj='$kdeplj'AND
							t_mstpng.kdekls=t_mstkls.kdekls
				ORDER BY	t_mstkls.kdeklm,t_mstkls.kdekls";
}
$result2=mysql_query($query2);
while($kg =mysql_fetch_array($result2))
{
   	$kgd=$kg['kdekls'];
    echo"<OPTION VALUE='$kgd'>$kgd</OPTION>\n";
}
?>
