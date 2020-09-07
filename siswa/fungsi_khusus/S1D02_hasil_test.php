<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$nis=$_GET['nis'];
$kdekls=$_GET['kdekls'];
$kdeplj=$_GET['kdeplj'];
$query ="	SELECT 	u_gnroln.*,g_gnrrcu.*,t_mstbbt.*
			FROM 	u_gnroln,g_gnrrcu,t_mstbbt
			WHERE   u_gnroln.nis='". mysql_escape_string($nis)."' AND
					g_gnrrcu.kdeplj='". mysql_escape_string($kdeplj)."' AND
					g_gnrrcu.kdekls='". mysql_escape_string($kdekls)."' AND
                    u_gnroln.kdercu=g_gnrrcu.kdercu AND
                    g_gnrrcu.kdebbt=t_mstbbt.kdebbt";
$result =mysql_query($query);
$no=0;
while($data =mysql_fetch_array($result))
{   $tglujn	=$data['tglujn'];
    $jamujn	=$data['jamujn'];
    $ktr	=$data['ktr'];
    $nli	=$data['nli'];
    $kdebbt	=$data['nmabbt'];

	$no++;
	echo"
	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH=' 4%'><CENTER>$no 	</CENTER></TD>
  		<TD WIDTH='10%'><CENTER>$tglujn	</CENTER></TD>
        <TD WIDTH='10%'><CENTER>$jamujn	</CENTER></TD>
        <TD WIDTH='56%'><CENTER>$ktr	</CENTER></TD>
        <TD WIDTH='10%'><CENTER>$kdebbt	</CENTER></TD>
        <TD WIDTH=' 5%'><CENTER><b>$nli</b></CENTER></TD>
        <TD WIDTH=' 4%'><CENTER>
			<a href='../files/materi/$kdemtr/$nmamtr2.$type'target='_blank'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
	</TR>";
}
?>