<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdekry=$_GET['kdekry'];
$query ="	SELECT 	*,t_mstplj.nmaplj,g_dtltgs.nmatgs
			FROM 	g_dtltgs,g_gnrtgs,t_mstplj
			WHERE g_dtltgs.kdegru='". mysql_escape_string($kdekry)."' AND
                  g_dtltgs.kdetgs=g_gnrtgs.kdetgs AND
						g_gnrtgs.kdeplj=t_mstplj.kdeplj
			ORDER BY 	g_gnrtgs.kdeklm,t_mstplj.nmaplj,g_dtltgs.nmatgs";
$result =mysql_query($query);
 echo"
 <div style='overflow:auto;width:100%;height:360px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 5%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='20%'><CENTER>Pelajaran				</CENTER>
                                    <TD WIDTH='65%'><CENTER>Tugas				</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Kelas				</CENTER></TD>
								</TR>";
$no=0;
while($data =mysql_fetch_array($result))
{
    $kdetgs	=$data['kdetgs'];
    $nmatgs	=$data['nmatgs'];
    $nmaplj	=$data['nmaplj'];
	$kdeklm	=$data['kdeklm'];
    $type=$data['type'];
	$no++;
	echo"

	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD><CENTER>$no 	</CENTER></TD>
        <TD><CENTER>$nmaplj	</CENTER></TD>
        <TD>      <a href='../files/tugas/$kdetgs/$nmatgs.$type'target='_blank'>";
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
			echo"$nmatgs
		                         </TD>
<TD><CENTER>$kdeklm	</CENTER></TD>								 
	</TR>";
}
//echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D02B.js'></SCRIPT>";
?>