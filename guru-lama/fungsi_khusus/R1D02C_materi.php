<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdekry=$_GET['kdekry'];
$query ="	SELECT 	*,t_mstplj.nmaplj,g_dtlmtr.nmamtr
			FROM 	g_dtlmtr,g_gnrmtr,t_mstplj
			WHERE g_dtlmtr.kdegru='". mysql_escape_string($kdekry)."' AND
                  g_dtlmtr.kdemtr=g_gnrmtr.kdemtr AND
						g_gnrmtr.kdeplj=t_mstplj.kdeplj
			ORDER BY 	g_gnrmtr.kdeklm,t_mstplj.nmaplj,g_dtlmtr.nmamtr";
$result =mysql_query($query);
 echo"
 <div style='overflow:auto;width:100%;height:360px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 5%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='20%'><CENTER>Pelajaran				</CENTER>
                                    <TD WIDTH='65%'><CENTER>Materi				</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Kelas				</CENTER></TD>
								</TR>";
$no=0;
while($data =mysql_fetch_array($result))
{
    $kdemtr	=$data['kdemtr'];
    $nmamtr	=$data['nmamtr'];
    $nmaplj	=$data['nmaplj'];
	$kdeklm	=$data['kdeklm'];
    $type=$data['type'];
	$no++;
	echo"

	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD><CENTER>$no 	</CENTER></TD>
        <TD><CENTER>$nmaplj	</CENTER></TD>
        <TD>      <a href='../files/materi/$kdemtr/$nmamtr.$type' target='_blank'>";
			                    switch ($type)
			{
				case($type=='doc' OR $type=='docx'):
					echo"<IMG src='../images/icon_doc_e.gif' BORDER='0'>";
					break;
				case($type=='pdf'):
					echo"<IMG src='../images/icon_pdf_e.gif' BORDER='0'>";
					break;
				case($type=='pps' OR $type=='ppsx'):
					echo"<IMG src='../images/icon_pps_e.gif' BORDER='0'>";
					break;
				case($type=='txt'):
					echo"<IMG src='../images/icon_txt_e.gif' BORDER='0'>";
					break;
				case($type=='swf'):
					echo"<IMG src='../images/icon_swf_e.gif' BORDER='0'>";
					break;
				default:
					echo"<IMG src='../images/images_e.gif' BORDER='0'>";
			}
			echo"$nmamtr
		                         </TD>
<TD><CENTER>$kdeklm	</CENTER></TD>								 
	</TR>";
}
//echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D02B.js'></SCRIPT>";
?>