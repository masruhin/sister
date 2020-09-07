<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
 
$pilih 	= $_GET['pilih'];
$kdegr 	= $_GET['kdeplj'];
$kdegu 	= $_GET['kdegru'];
$ktr 	= $_GET['ktr'];
if($pilih=='banksoal')
{
$query 	=mysql_query("	SELECT   	*,g_dtlsal.soal
						FROM 		g_gnrsal,g_dtlsal
						WHERE		(g_gnrsal.kdeplj LIKE'%".$kdegr."%' OR '$kdegr'='') AND
									(g_gnrsal.kdegru LIKE'%".$kdegu."%' OR '$kdegu'='') AND
									(g_gnrsal.ktr LIKE'%".$ktr."%' OR '$ktr'='') AND
                                    g_gnrsal.kdesl=g_dtlsal.kdesl
						ORDER BY 	g_gnrsal.ktr");
$no=0;
while($data =mysql_fetch_array($query))
{
 	$soal =susun_kalimat($data['soal'], 80);
	$no++;

	echo"
    <TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH='	5%'><CENTER>$no<input type='hidden' name='kdesl' id='kdesl'value='$data[kdesl]'></CENTER></TD>
        <TD WIDTH='85%' ><input type='hidden' name='id'id='id' value='$data[id]'>$soal[0]...</TD>
        <TD WIDTH='10%'><CENTER><a href='#' id='$data[id]' class='detil'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
    </TR>";
}
}
else
if($pilih=='rencanasoal')
{
$query 	=mysql_query("	SELECT   	*,g_dtlrcu.soal
						FROM 		g_gnrrcu,g_dtlrcu
						WHERE		(g_gnrrcu.kdeplj LIKE'%".$kdegr."%' OR '$kdegr'='') AND
									(g_gnrrcu.kdegru LIKE'%".$kdegu."%' OR '$kdegu'='') AND
									(g_gnrrcu.ktr LIKE'%".$ktr."%' OR '$ktr'='') AND
                                    g_gnrrcu.kdercu=g_dtlrcu.kdercu
						ORDER BY 	g_gnrrcu.ktr");
$no=0;
while($data =mysql_fetch_array($query))
{
 	$soal =susun_kalimat($data['soal'], 80);
	$no++;

	echo"
    <TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH='	5%'><CENTER>$no<input type='hidden' name='kdercu2' id='kdercu2'value='$data[kdercu]'></CENTER></TD>
        <TD WIDTH='85%' ><input type='hidden' name='id'id='id' value='$data[id]'>$soal[0]...</TD>
        <TD WIDTH='10%'><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></CENTER></TD>
    </TR>";
}
}

echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01C.js'></SCRIPT>";
?>