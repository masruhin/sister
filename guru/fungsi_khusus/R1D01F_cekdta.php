<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';


$kdeplj =$_POST['kdeplj'];
$prdtes =$_POST['prdtes'];
 
$query ="SELECT 	 t_prgrptps.kdeplj,t_prgrptps.nis,SUM(t_prgrptps.$prdtes) as jml,t_mstssw.kdekls
						FROM 	t_prgrptps,t_mstssw
						WHERE 	t_prgrptps.kdeplj='$kdeplj' AND
						        t_prgrptps.nis =t_mstssw.nis
								ORDER BY nis";
$result =mysql_query($query);
while($data	=mysql_fetch_array($result))
{
$kdepljj=$data['kdeplj'];
$niss=$data['nis'];
$kdekls=$data['kdekls'];
$nli=$data['jml'];
}
if($nli=='')
{
echo"0";
}
else
{echo"$nli";
}



			

?>