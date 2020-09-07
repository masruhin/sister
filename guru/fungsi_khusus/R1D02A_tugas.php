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

$query 	="	SELECT 	g_gnrtgs.*
			FROM 	g_gnrtgs
			WHERE	g_gnrtgs.kdeplj='". mysql_escape_string($kdeplj)."' AND
					g_gnrtgs.kdeklm='". mysql_escape_string($kdeklm)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);
$kdetgs	=$data['kdetgs'];

$query	=" 	SELECT 		g_dtltgs.*,t_mstkry.*
			FROM 		g_dtltgs,t_mstkry
			WHERE 		g_dtltgs.kdetgs='$kdetgs'AND
                        g_dtltgs.kdegru=t_mstkry.kdekry
            ORDER BY 	g_dtltgs.kdetgs";
$result	=mysql_query($query);
//TASK
echo"
<TR bgcolor='dedede'>
	<TD HEIGHT=40><CENTER><b>WORKSHEET<br>
		$nmaplj - $nmaklm</CENTER></b>
	</TD>
</TR>";

$no=0;
while($data =mysql_fetch_array($result))
{   
	$nmatgs	=$data['nmatgs'];
    $kdetgs	=$data['kdetgs'];
    $nmakry =$data['nmakry'];
    $tglinp =$data['tglinp'];
    $jaminp =$data['jaminp'];
    $type	=$data['type'];

	$no++;
	echo"
	<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
        <TD>
			<a href='../files/tugas/$kdetgs/$nmatgs.$type' target='_blank'>";
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
			<b>$nmatgs</b></a><br>
			$nmakry<br>
			$tglinp / $jaminp
		</TD>
	</TR>";
}
?>