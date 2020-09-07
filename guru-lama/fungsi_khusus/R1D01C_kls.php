<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
 
echo"
<OPTION selected VALUE=''> --Pilih-- </OPTION>";
$kdegru =$_GET['kdegru'];
$kdeplj =$_GET['kdeplj'];
$query2="	SELECT 	 *,t_mstkls.kdekls
										FROM 	   t_mstkls,t_mstpng
										WHERE
                                                    t_mstpng.kdegru='$kdegru' AND
                                                    t_mstpng.kdeplj='$kdeplj'AND
                                                    t_mstpng.kdekls=t_mstkls.kdekls
                                                    ";
$result2=mysql_query($query2);
while($kg =mysql_fetch_array($result2))
{
   	$kgd=$kg['kdekls'];
    echo"<OPTION VALUE='$kgd'>$kgd</OPTION>\n";
}
?>
