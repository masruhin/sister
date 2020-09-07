<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

//$kdekry_x	=$_SESSION["Admin"]["kdekry"];	// buatan d 
$kdeklm=$_GET['kdeklm'];
/*$query ="	SELECT 	DISTINCT t_mstplj.nmaplj,t_mstplj.kdeplj,t_mstkls.kdeklm
			FROM 		t_mstkls,t_mstpng,t_mstplj
			WHERE 		t_mstkls.kdeklm='". mysql_escape_string($kdeklm)."' AND
						t_mstkls.kdekls=t_mstpng.kdekls AND
						t_mstpng.kdeplj=t_mstplj.kdeplj	AND
						t_mstplj.str=''
			ORDER BY 	t_mstplj.nmaplj";			asli*/
$query ="	SELECT 	DISTINCT t_setpsrpt.nmasbj,t_mstplj.kdeplj,t_mstkls.kdeklm
			FROM 		t_mstkls,t_mstpng,t_mstplj,t_setpsrpt,t_klmkls
			WHERE 		t_mstkls.kdeklm='". mysql_escape_string($kdeklm)."' AND
						t_setpsrpt.kdetkt=t_klmkls.kdetkt AND
						t_klmkls.kdeklm=t_mstkls.kdeklm AND
						t_mstkls.kdekls=t_mstpng.kdekls AND
						t_mstpng.kdeplj=t_mstplj.kdeplj	AND
						t_setpsrpt.kdeplj=t_mstplj.kdeplj	AND
						t_mstplj.str=''
			ORDER BY 	t_setpsrpt.id";
$result =mysql_query($query);
echo"
<TR bgcolor='dedede'>
	<TD WIDTH='10%' HEIGHT='20'><CENTER>No	</CENTER></TD>
	<TD WIDTH='30%'><CENTER>Subject			</CENTER></TD>
	<TD WIDTH='15%'><CENTER>Curriculum Plan		</CENTER></TD>
	<TD WIDTH='15%'><CENTER>Material		</CENTER></TD>
	<TD WIDTH='15%'><CENTER>Worksheet		</CENTER></TD>
	<TD WIDTH='15%'><CENTER>Lesson Plan				</CENTER></TD>
</TR>";//Task
//

$no=0;
while($data =mysql_fetch_array($result))
{
	/*$query2="SELECT DISTINCT g_gnrkrk.kdekrk,g_dtlkrk.nmakrk 
			FROM 	g_gnrkrk,g_dtlkrk,t_mstkls,t_mstplj
			WHERE 	g_gnrkrk.kdekrk=g_dtlkrk.kdekrk AND
					g_gnrkrk.kdeklm=t_mstkls.kdeklm AND
					g_gnrkrk.kdeplj=t_mstplj.kdeplj AND
					t_mstkls.kdeklm='". mysql_escape_string($kdeklm)."' AND
					g_dtlkrk.kdegru='M11070027' ";
	$result2 =mysql_query($query2);
	$data2 =mysql_fetch_array($result2);
	$kdekrk	=$data2['kdekrk'];
	$nmakrk	=$data2['nmakrk'];*/
	
	$kdeklm	=$data['kdeklm'];
	$nmaplj	=$data['nmasbj'];//nmaplj
    $kdeplj=$data['kdeplj'];
	/*$type	="pdf";
	$filename  = '../../files/materi/'.$kdekrk.'/'.$nmakrk.'.'.$type;
	$filename2 = '../files/materi/'.$kdekrk.'/'.$nmakrk.'.'.$type;
	$filename  = '../../files/silabus/'.$kdeplj.'/'.$kdeklm.$kdeplj.'.'.$type;
	$filename2 = '../files/silabus/'.$kdeplj.'/'.$kdeklm.$kdeplj.'.'.$type;*/

	$no++;
	
	echo"
	<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">	
		<TD WIDTH='10%'><CENTER>$no 	</CENTER></TD>
  		<TD WIDTH='30%'><CENTER>$nmaplj</CENTER></TD>";
		/*if (file_exists($filename2)) 
		{
			echo"
			<TD WIDTH='15%'><CENTER><a href=$filename2 target='_blank'><img src='../images/icon_pdf_e.gif'></a></CENTER></TD>";
		}
		else
		{
			//echo"
			//<TD WIDTH='15%'><CENTER><a href=$filename2 target='_blank'><img src='../images/icon_pdf_e.gif'></a></CENTER></TD>";
			echo"
			<TD WIDTH='15%'><CENTER><img src='../images/icon_pdf_d.gif'></a></CENTER></TD>";
		}*/
		echo"
		<TD WIDTH='15%'><CENTER>
			<a href='#' kdeplj='$kdeplj' id='$data[kdeklm]' class='krk'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
        <TD WIDTH='15%'><CENTER>
			<a href='#' kdeplj='$kdeplj' id='$data[kdeklm]' class='mtr'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
        <TD WIDTH='15%'><CENTER>
			<a href='#' kdeplj='$kdeplj' id='$data[kdeklm]' class='tgs'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
		<TD WIDTH='15%'><CENTER>
			<a href='#' kdeplj='$kdeplj' id='$data[kdeklm]' class='rpp'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
	</TR>";
	
	
	
	/*
		
	*/
}
echo"
<TR>
<TD COLSPAN='6' HEIGHT='20' align='center' bgcolor='dedede'><B>EXTRA KURIKULER</B></TD>
</TR>";

$query ="	SELECT 	DISTINCT t_mstplj.nmaplj,t_mstplj.kdeplj,t_mstkls.kdeklm
			FROM 		t_mstkls,t_mstpng,t_mstplj
			WHERE 		t_mstkls.kdeklm='". mysql_escape_string($kdeklm)."' AND
						t_mstkls.kdekls=t_mstpng.kdekls AND
						t_mstpng.kdeplj=t_mstplj.kdeplj	AND
						t_mstplj.str='X'
			ORDER BY 	t_mstplj.nmaplj";

$result =mysql_query($query);
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
  		<TD WIDTH='30%'><CENTER>$nmaplj</CENTER></TD>";
		/*if (file_exists($filename)) 
		{
			echo"
			<TD WIDTH='15%'><CENTER><a href=$filename2 target='_blank'><img src='../images/icon_pdf_e.gif'></a></CENTER></TD>";
		}
		else
		{
			echo"
			<TD WIDTH='15%'><CENTER><img src='../images/icon_pdf_d.gif'></a></CENTER></TD>";
		}*/
		echo"
		<TD WIDTH='15%'><CENTER>
			<a href='#' kdeplj='$kdeplj' id='$data[kdeklm]' class='krk'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
        <TD WIDTH='15%'><CENTER>
			<a href='#' kdeplj='$kdeplj' id='$data[kdeklm]' class='mtr'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
        <TD WIDTH='15%'><CENTER>
			<a href='#' kdeplj='$kdeplj' id='$data[kdeklm]' class='tgs'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
		<TD WIDTH='15%'><CENTER>
			<a href='#' kdeplj='$kdeplj' id='$data[kdeklm]' class='rpp'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
	</TR>";
	/*
		
	*/
}
echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D02A.js'></SCRIPT>";
?>