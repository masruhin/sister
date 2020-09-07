<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

//$kdegru	=$_GET['kdegru'];
$kdeklm	=$_GET['kdeklm'];
$kdeplj	=$_GET['kdeplj'];
$query 	="	SELECT 	g_gnrmtr.*
			FROM 	g_gnrmtr
			WHERE
					g_gnrmtr.kdeplj='". mysql_escape_string($kdeplj)."' AND
					g_gnrmtr.kdeklm='". mysql_escape_string($kdeklm)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);
$kdemtr	=$data['kdemtr'];

$query	=" 	SELECT 		g_dtlmtr.*,t_mstkry.*
			FROM 		g_dtlmtr,t_mstkry
			WHERE 		g_dtlmtr.kdemtr='$kdemtr'AND
                        g_dtlmtr.kdegru=t_mstkry.kdekry
            ORDER BY 	g_dtlmtr.kdemtr";
$result	=mysql_query($query);

echo"
<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
								<TR bgcolor='dedede'>
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='46%'><CENTER>Materi  	</CENTER></TD>
                                    <TD WIDTH='30%'><CENTER>Guru  	</CENTER></TD>
                                    <TD WIDTH='20%'><CENTER>Tanggal/Jam  	</CENTER></TD>
								</TR>";

$no=0;
while($data =mysql_fetch_array($result))
{   $nmamtr	=$data['nmamtr'];
    $kdemtr	=$data['kdemtr'];
    $nmakry =$data['nmakry'];
    $tglinp =$data['tglinp'];
    $jaminp =$data['jaminp'];
    $type	=$data['type'];

	$no++;
	echo"
	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD><CENTER>$no 	</CENTER></TD>
        <TD><a href='../files/materi/$kdemtr/$nmamtr.$type' target='_blank'>";
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
        <TD><CENTER>$nmakry</CENTER></TD>
        <TD><CENTER>$tglinp / $jaminp</CENTER></TD>
	</TR>";
}
echo"
</TABLE>";
?>