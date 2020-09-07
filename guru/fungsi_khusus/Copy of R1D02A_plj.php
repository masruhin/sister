<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdeklm=$_GET['kdeklm'];
$query ="	SELECT 	DISTINCT t_mstplj.nmaplj,t_mstplj.kdeplj,t_mstkls.kdeklm
			FROM 		t_mstkls,t_mstpng,t_mstplj
			WHERE 		t_mstkls.kdeklm='". mysql_escape_string($kdeklm)."' AND
						t_mstkls.kdekls=t_mstpng.kdekls AND
						t_mstpng.kdeplj=t_mstplj.kdeplj	
			ORDER BY 	t_mstplj.nmaplj";
$result =mysql_query($query);
echo"
<TR bgcolor='dedede'>
	<TD WIDTH='10%' HEIGHT='20'><CENTER>No	</CENTER></TD>
	<TD WIDTH='45%'><CENTER>Subject			</CENTER></TD>
	<TD WIDTH='15%'><CENTER>Syllabus		</CENTER></TD>
	<TD WIDTH='15%'><CENTER>Material		</CENTER></TD>
	<TD WIDTH='15%'><CENTER>Task			</CENTER></TD>
</TR>";

$no=0;
while($data =mysql_fetch_array($result))
{
	$kdeklm	=$data['kdeklm'];
	$nmaplj	=$data['nmaplj'];
    $kdeplj=$data['kdeplj'];
	$type	="pdf";
	$filename  = '../../files/silabus/'.$kdeplj.'/'.$kdeklm.$kdeplj.'.'.$type;
	$filename2 = '../files/silabus/'.$kdeplj.'/'.$kdeklm.$kdeplj.'.'.$type;

	$no++;
	echo"
	<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">	
		<TD WIDTH='10%'><CENTER>$no 	</CENTER></TD>
  		<TD WIDTH='45%'><CENTER>$nmaplj</CENTER></TD>";
		if (file_exists($filename)) 
		{
			echo"
			<TD WIDTH='15%'><CENTER><a href=$filename2 target='_blank'><img src='../images/icon_pdf_e.gif'></a></CENTER></TD>";
		}
		else
		{
			echo"
			<TD WIDTH='15%'><CENTER><img src='../images/icon_pdf_d.gif'></a></CENTER></TD>";
		}
		echo"
        <TD WIDTH='15%'><CENTER>
			<a href='#' kdeplj='$kdeplj' id='$data[kdeklm]' class='mtr'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
        <TD WIDTH='15%'><CENTER>
			<a href='#' kdeplj='$kdeplj' id='$data[kdeklm]' class='tgs'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
	</TR>";
}
echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D02A.js'></SCRIPT>";
?>