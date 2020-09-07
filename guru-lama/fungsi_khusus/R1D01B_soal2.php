<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kdesl	=$_GET['kdesl'];
$query 	="	SELECT 	g_gnrsal.*
			FROM 	g_gnrsal
			WHERE 	g_gnrsal.kdesl='". mysql_escape_string($kdesl)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);
$kdesl1	=$data['kdesl'];

$query1	=" 	SELECT 		g_dtlsal.*
			FROM 		g_dtlsal
			WHERE 		g_dtlsal.kdesl='$kdesl'
            ORDER BY 	g_dtlsal.id";
$result1=mysql_query($query1);

$no=0;
while($data =mysql_fetch_array($result1))
{ 
	$soal = susun_kalimat($data['soal'],65);
	$jwb1 = strip_tags(substr($data['jwb1'],0,13));
	$jwb2 = strip_tags(substr($data['jwb2'],0,13));
	$jwb3 = strip_tags(substr($data['jwb3'],0,13));
	$jwb4 = strip_tags(substr($data['jwb4'],0,13));
	$jwb5 = strip_tags(substr($data['jwb5'],0,13));
	$no++;
	
	echo"
	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH=' 5%'><CENTER>$no			</CENTER></TD>
  		<TD WIDTH='55%'>$soal[0]...</TD>
        <TD WIDTH='10%'><CENTER><a href='guru.php?mode=R1D01B_Soal&kdesl=$data[kdesl]&id=$data[id]&pilihan=gambar'>
								<IMG src='../images/images_e.gif' BORDER='0'></a></CENTER></TD>
        <TD WIDTH='10%'><CENTER><a href='guru.php?mode=R1D01B_Soal&kdesl=$data[kdesl]&id=$data[id]&pilihan=detil_general'>
								<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
        <TD WIDTH='10%'><CENTER><a href='guru.php?mode=R1D01B_Soal&kdesl=$data[kdesl]&id=$data[id]&pilihan=edit_item'>
								<IMG src='../images/edit_e.gif' BORDER='0'></a></CENTER></TD>
		<TD WIDTH='10%'><CENTER><a href='#' id='$data[id]'class='hapussl'>
								<IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>
	</TR>";
}
echo"
<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>
<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01B_hapus.js'></SCRIPT>";
?>