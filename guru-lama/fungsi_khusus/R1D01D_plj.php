<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
 
echo"
<OPTION selected VALUE=''> --Pilih-- </OPTION>";
$kdegru =$_GET['kdegru'];
$kdekls =$_GET['kdekls'];
$query2="	SELECT 	 *,t_mstplj.nmaplj
										FROM 	   t_mstplj,t_mstpng
										WHERE
                                                    t_mstpng.kdegru='$kdegru' AND
                                                    t_mstpng.kdekls='$kdekls'AND
                                                    t_mstpng.kdeplj=t_mstplj.kdeplj
                                                    ";
$result2=mysql_query($query2);
while($kg =mysql_fetch_array($result2))
{
   	$kgd=$kg['nmaplj'];
    $kd=$kg['kdeplj'];
    echo"<OPTION VALUE='$kg'>$kgd</OPTION>\n";
}
?>
