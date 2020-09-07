<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D01B_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SOAL
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdesl	=$_GET['kdesl'];
$query 	="	SELECT 		g_dtlsal.*,g_gnrsal.ktr,t_mstplj.nmaplj
			FROM 		g_dtlsal,g_gnrsal,t_mstplj
			WHERE		g_dtlsal.kdesl='". mysql_escape_string($kdesl)."'	AND
						g_dtlsal.kdesl=g_gnrsal.kdesl	AND
						g_gnrsal.kdeplj=t_mstplj.kdeplj
			ORDER BY 	g_dtlsal.id";
$result =mysql_query($query) or die('Query gagal');

$i=0;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[kdesl];
	$cell[$i][1] 	=$data[nmaplj];
	$cell[$i][2] 	=$data[ktr];
	$cell[$i][3] 	=$data[soal];
	$cell[$i][4] 	=$data[sttjwb];
	$i++;
}

echo"
<TABLE WIDTH='100%'>";
$j=0;
$no=1;
while($j<$i)
{
	$soal=str_replace('../files/','../../files/',$cell[$j][3]);
	$sttjwb=$cell[$j][4];
	echo"
	<TR>
	<TD VALIGN='top' width='1%'>
		$no. 
	</td>
	<TD>
		<TEXTAREA 	NAME		='soal'
													ID			='soal'
													VALUE		='$soal'
													rows		='6'
													cols		='100'
													
													readonly>$soal</TEXTAREA>
	</TD>
	</TR>
	
	<TR>
	<TD>
	</TD>
	<TD ALIGN='right'>
		Answer : $sttjwb
	</TD>
	</TR>";
	$j++;
	$no++;
}
echo"
</TABLE>";
?>