<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
 
echo"<OPTION selected VALUE=''>--Select--</OPTION>";
$kdekls =$_GET['kdekls'];

$query	=mysql_query("	SELECT 	 	t_mstkls.*,t_klmkls.*
						FROM 	 	t_mstkls,t_klmkls
						WHERE   	t_mstkls.kdekls='$kdekls'	AND
									t_mstkls.kdeklm=t_klmkls.kdeklm");
$data	=mysql_fetch_array($query);
$kdetkt	=$data[kdetkt];

$query	=mysql_query("	SELECT 	 t_setpgwa.*
						FROM 	 t_setpgwa
						WHERE    t_setpgwa.kdetkt='$kdetkt'");
while($data =mysql_fetch_array($query))
{
   	$idwa	=$data['idwa'];
	$nmawa	=$data['nmawa'];
    echo"<OPTION VALUE='$idwa'>$nmawa</OPTION>\n";
}
?>
