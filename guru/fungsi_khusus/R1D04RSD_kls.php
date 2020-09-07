<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
 
echo"
<OPTION selected VALUE=''>--All Class--</OPTION>";
//$kdegru =$_GET['kdegru'];
$kdekls =$_GET['kdekls'];


	$query2="	SELECT 		t_mstssw.*
				FROM		t_mstssw
				WHERE		t_mstssw.kdekls='$kdekls' 
				"; // khususs guru matpel tsb.

$result2=mysql_query($query2);
while($kg =mysql_fetch_array($result2))
{
   	$kgd=$kg['nis'];
    echo"<OPTION VALUE='$kgd'>$kgd</OPTION>\n";
}
?>
