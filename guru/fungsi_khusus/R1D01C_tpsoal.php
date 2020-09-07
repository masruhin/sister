<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kdegr 	= $_GET['kdeplj'];
$kdegu	= $_GET['kdegru'];
$query 	=mysql_query("	SELECT  	*,g_dtlsal.soal
						FROM 		g_gnrsal,g_dtlsal
						WHERE 		g_gnrsal.kdeplj='$kdegr' AND
									g_gnrsal.kdegru='$kdegu' AND
									g_gnrsal.kdesl=g_dtlsal.kdesl
						ORDER BY 	ktr");
$no=0;
while($data =mysql_fetch_array($query))
{
	$soal = susun_kalimat(strip_tags($data['soal']),65);
	$no++;

	echo"
    <TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH=' 5%'><CENTER>$no <input type='hidden' name='kdesl' id='kdesl'value='$data[kdesl]'></CENTER></TD>
        <TD WIDTH='85%'>
			<input type='hidden' name='id'id='id' value='$data[id]'>$soal[0]...
		</TD>
        <TD WIDTH='10%'><CENTER>
			<a href='#' id='$data[id]' class='detil'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
	</TR>";
}
echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01C.js'></SCRIPT>";
?>