<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdeklm	=$_GET['kdeklm'];
$kdeplj	=$_GET['kdeplj'];

$query	=" 	SELECT 		t_klmkls.*
			FROM 		t_klmkls
			WHERE 		t_klmkls.kdeklm='". mysql_escape_string($kdeklm)."'";
$result	=mysql_query($query);
$data 	=mysql_fetch_array($result);
$nmaklm	=$data['nmaklm'];

$query	=" 	SELECT 		t_mstplj.*
			FROM 		t_mstplj
			WHERE 		t_mstplj.kdeplj='". mysql_escape_string($kdeplj)."'";
$result	=mysql_query($query);
$data 	=mysql_fetch_array($result);
$nmaplj	=$data['nmaplj'];

$query	=" 	SELECT 		g_dtlmtr.*,g_gnrmtr.*,t_mstkry.*
			FROM 		g_dtlmtr,g_gnrmtr,t_mstkry
			WHERE 		g_gnrmtr.kdeplj='". mysql_escape_string($kdeplj)."'	AND
						g_gnrmtr.kdeklm='". mysql_escape_string($kdeklm)."'	AND
						g_dtlmtr.kdemtr=g_gnrmtr.kdemtr	AND
						g_dtlmtr.kdegru=t_mstkry.kdekry
            ORDER BY 	g_dtlmtr.nmamtr";
$result	=mysql_query($query);

echo"
<TR bgcolor='dedede'>
	<TD HEIGHT=40><CENTER><b>MATERIAL<br>
		$nmaplj - $nmaklm</CENTER></b>
	</TD>
</TR>";

$no=0;
while($data =mysql_fetch_array($result))
{   
	$nmamtr	=$data['nmamtr'];
	$nmamtr2	=substr($data['nmamtr'],0,30).'...';
    $kdemtr	=$data['kdemtr'];
    $nmakry =$data['nmakry'];
    $tglinp =$data['tglinp'];
    $jaminp =$data['jaminp'];
    $type	=$data['type'];
	$no++;
	echo"
	<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
        <TD>
			<a href='../files/materi/$kdemtr/$nmamtr.$type' target='_blank'>";
				switch($type)
				{
					case($type=='doc' OR $type=='docx'):
						echo"<IMG src='../images/icon_doc48_e.png' BORDER='0' text-align:left style='float: left; margin-right:10px; margin-left:5px; margin-top:5px; margin-bottom:5px'>";
						break;
					case($type=='xls' OR $type=='xlsx'):
						echo"<IMG src='../images/icon_xls48_e.png' BORDER='0' text-align:left style='float: left; margin-right:10px; margin-left:5px; margin-top:5px; margin-bottom:5px'>";
						break;
					case($type=='pdf'):
						echo"<IMG src='../images/icon_pdf48_e.png' BORDER='0' text-align:left style='float: left; margin-right:10px; margin-left:5px; margin-top:5px; margin-bottom:5px'>";
						break;
					case($type=='pps' OR $type=='ppsx' OR $type=='ppt' OR $type=='pptx'):
						echo"<IMG src='../images/icon_pps48_e.png' BORDER='0' text-align:left style='float: left; margin-right:10px; margin-left:5px; margin-top:5px; margin-bottom:5px'>";
						break;
					case($type=='txt'):
						echo"<IMG src='../images/icon_txt48_e.png' BORDER='0' text-align:left style='float: left; margin-right:10px; margin-left:5px; margin-top:5px; margin-bottom:5px'>";
						break;
					case($type=='swf'):
						echo"<IMG src='../images/icon_swf48_e.png' BORDER='0' text-align:left style='float: left; margin-right:10px; margin-left:5px; margin-top:5px; margin-bottom:5px'>";
						break;
					default:
						echo"<IMG src='../images/icon-show48_e.png' BORDER='0' text-align:left style='float: left; margin-right:10px; margin-left:5px; margin-top:5px; margin-bottom:5px'>";
				}
			echo"<br>
			<b>$nmamtr</b></a><br>
			$nmakry<br>
			$tglinp / $jaminp
		</TD>
	</TR>"; 
} 
?>