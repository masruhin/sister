<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
 
$pilih 	    = $_GET['pilih'];
$kdeplj 	= $_GET['kdeplj'];
$kdegru 	= $_GET['kdegru'];
$kdesl 	    = $_GET['kdesl'];
if($pilih=='banksoal')
{
$query 	=mysql_query("	SELECT   	g_dtlsal.*,g_gnrsal.*
						FROM 		g_dtlsal,g_gnrsal
						WHERE		(g_gnrsal.kdeplj='$kdeplj' OR '$kdeplj'='') AND
									(g_gnrsal.kdegru='$kdegru' OR '$kdegru'='') AND
									(g_gnrsal.kdesl ='$kdesl' OR '$kdesl'='') AND
                                    g_dtlsal.kdesl=g_gnrsal.kdesl
						ORDER BY 	g_dtlsal.id");
						
$no=0;
while($data =mysql_fetch_array($query))
{
	$soal = susun_kalimat(strip_tags($data['soal']),65);
	$no++;

	echo"
    <TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH='	5%'><CENTER>$no<input type='hidden' name='kdesl' id='kdesl'value='$data[kdesl]'></CENTER></TD>
        <TD WIDTH='85%' ><input type='hidden' name='id'id='id' value='$data[id]'>$soal[0]...</TD>
        <TD WIDTH='10%'><CENTER><a href='#' id='$data[id]' class='detil'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
    </TR>";
}
}
else
if($pilih=='rencanasoal')
{
$query 	=mysql_query("	SELECT   	g_dtlrcu.*,g_gnrrcu.*
						FROM 		g_gnrrcu,g_dtlrcu
						WHERE		(g_gnrrcu.kdeplj='$kdeplj' OR '$kdeplj'='') AND
									(g_gnrrcu.kdegru='$kdegru' OR '$kdegru'='') AND
									(g_gnrrcu.kdercu ='$kdesl' OR '$kdesl'='') AND
                                    g_dtlrcu.kdercu=g_gnrrcu.kdercu
						ORDER BY 	g_dtlrcu.id");
$no=0;
while($data =mysql_fetch_array($query))
{
	$soal = susun_kalimat(strip_tags($data['soal']),65);
	$no++;

	echo"
    <TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH='	5%'><CENTER>$no<input type='hidden' name='kdercu2' id='kdercu2'value='$data[kdercu]'></CENTER></TD>
        <TD WIDTH='85%' ><input type='hidden' name='id'id='id' value='$data[id]'>$soal[0]...</TD>
        <TD WIDTH='10%'><CENTER><a href='#' id='$data[id]' class='detil2'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
    </TR>";
}
}
//<TD WIDTH='10%'><CENTER><a href='#' id='$data[id]' class='detil'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>

echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01C.js'></SCRIPT>";
?>