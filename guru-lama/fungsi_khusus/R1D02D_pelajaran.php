<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdekls=$_GET['kdekls'];
$query ="	SELECT 	*,t_mstplj.nmaplj
			FROM 	t_mstkls,t_mstplj,g_gnrmtr,g_dtlmtr
			WHERE t_mstkls.kdekls='". mysql_escape_string($kdekls)."' AND
                  t_mstkls.kdeklm=g_gnrmtr.kdeklm AND
                  g_gnrmtr.kdemtr=g_dtlmtr.kdemtr AND
                  g_gnrmtr.kdeplj=t_mstplj.kdeplj
			ORDER BY t_mstplj.nmaplj,g_dtlmtr.nmamtr";
$result =mysql_query($query);
echo"
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 5%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='20%'><CENTER>Pelajaran			</CENTER></TD>
									<TD WIDTH='75%'><CENTER>Materi				</CENTER></TD>

								</TR>";

$no=0;
while($data =mysql_fetch_array($result))
{
	$nmaplj	=$data['nmaplj'];
    $type	=$data['type'];
	$kdemtr =$data['kdemtr'];
    $nmamtr =$data['nmamtr'];
 
	$no++;
	echo"
	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD><CENTER>$no 	</CENTER></TD>
  		<TD><CENTER>$nmaplj</CENTER> </TD>
        <TD>
			<a href='../files/materi/$kdemtr/$nmamtr.$type' target='_blank'>";
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
			echo"
			</a>
			$nmamtr
		</TD>
		
	</TR>";
}
echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D02D.js'></SCRIPT>";
?>