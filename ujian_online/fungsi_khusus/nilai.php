<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
 
$nis	=$_SESSION["Admin"]["nis"];
$kdeoln	=$_GET['kdeoln'];
$tglujn =date("d-m-Y");
$jamujn	=date("h:i:s");

$query 	="	SELECT 		*,g_gnrrcu.kdercu,g_dtlrcu.kdercu
			FROM 		u_gnroln,u_dtloln,g_gnrrcu,g_dtlrcu
			WHERE 		u_gnroln.nis='$nis'	AND
						u_gnroln.kdeoln=u_dtloln.kdeoln AND
						u_gnroln.kdercu=g_gnrrcu.kdercu AND
						u_gnroln.kdercu=g_dtlrcu.kdercu AND
						g_gnrrcu.kdercu=g_dtlrcu.kdercu AND
						u_dtloln.soal=g_dtlrcu.soal
			ORDER BY 	u_gnroln.kdeoln";
$result	= mysql_query($query)	or die (mysql_error());

$jw='0';
while($data =mysql_fetch_array($result))
{
	$soal   =$data[soal];
	$stsjwb	=$data[stsjwb];
	$stsjwb1=$data[stsjwb1];
	$kdercu	=$data[kdercu];
	$kdeoln	=$data[kdeoln];
	echo"
	<tr>
		<td>";
			if($stsjwb==$stsjwb1)
			{
				$jwb='1';
				echo"1";
			}
			else
			{
				$jwb='0';
				echo"0";
			} 
		echo"
		</td>";
		$jw +=$jwb;
}
$query	="SELECT COUNT(*)as soal FROM u_dtloln WHERE kdeoln='$kdeoln'";
$result	=mysql_query($query);
$data	=mysql_fetch_assoc($result);
$j		=$data['soal'];

$nilai=$jw / $j * '100';
echo"<td> bener $jw dari  $j soal</td> nilai $nilai  ";
?>