<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdekry=$_GET['kdekry'];
$query ="	SELECT 		t_mstkry.*
			FROM 		t_mstkry
			WHERE 		t_mstkry.kdekry='". mysql_escape_string($kdekry)."'";
$result =mysql_query($query);
$data =mysql_fetch_array($result);
$nmakry=$data[nmakry];

$query ="	SELECT 		g_dtltgs.*,g_gnrtgs.*,t_mstplj.*,t_klmkls.*
			FROM 		g_dtltgs,g_gnrtgs,t_mstplj,t_klmkls
			WHERE 		g_dtltgs.kdegru='". mysql_escape_string($kdekry)."' AND
						g_dtltgs.kdetgs=g_gnrtgs.kdetgs AND
						g_gnrtgs.kdeplj=t_mstplj.kdeplj	AND
						g_gnrtgs.kdeklm=t_klmkls.kdeklm
			ORDER BY 	g_gnrtgs.kdeklm,t_mstplj.nmaplj,g_dtltgs.nmatgs";
$result =mysql_query($query);
echo"
<div style='overflow:auto;width:100%;height:360px;padding-right:-2px;'>
<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' class='table02'>
	<TR bgcolor='dedede'>
		<TD HEIGHT=40><CENTER><b>WORKSHEET<br>
			$nmakry</CENTER></b>
		</TD>
	</TR>";//TASK

	$no=0;
	while($data =mysql_fetch_array($result))
	{
		$kdetgs	=$data['kdetgs'];
		$nmatgs	=$data['nmatgs'];
		$nmaplj	=$data['nmaplj'];
		$kdeklm	=$data['kdeklm'];
		$nmaklm	=$data['nmaklm'];
		$tglinp =$data['tglinp'];
		$jaminp =$data['jaminp'];
		$type	=$data['type'];
		$no++;
		echo"
		<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
			<TD>     
				<a href='../files/tugas/$kdetgs/$nmatgs.$type'target='_blank'>";
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
				echo"<BR>
				<b>$nmatgs</b></a><BR>
				$nmaklm - $nmaplj<BR>
				$tglinp / $jaminp
			</TD>
		</TR>";
	}
//echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D02B.js'></SCRIPT>";
?>