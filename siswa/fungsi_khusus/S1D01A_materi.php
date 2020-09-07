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
					g_gnrmtr.kdeklm='". mysql_escape_string($kdeklm)."' AND
					g_gnrmtr.kdeplj='". mysql_escape_string($kdeplj)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);
$kdemtr	=$data['kdemtr'];

$query	=" 	SELECT 		g_dtlmtr.*
			FROM 		g_dtlmtr
			WHERE 		g_dtlmtr.kdemtr='$kdemtr'
            ORDER BY 	g_dtlmtr.kdemtr";
$result	=mysql_query($query);

$no=0;
while($data =mysql_fetch_array($result))
{   $nmamtr	=$data['nmamtr'];
    $kdemtr	=$data['kdemtr'];
    $stt	=$data['stt'];
    $type	=$data['type'];

	$no++;
	echo"
	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH=' 4%'><CENTER>$no 	</CENTER></TD>
        <TD WIDTH=' 1%'><CENTER>";
        if($stt=='Enabled')
        {echo"
			<a href='../files/materi/$kdemtr/$nmamtr.$type' target='_blank'>";
			switch ($type) 
			{
				case($type=='doc' OR $type=='docx'):
					echo"<IMG src='../images/icon_doc.gif' BORDER='0'></a></CENTER></TD>";
					break;
				case($type=='pdf'):
					echo"
                     <IMG src='../images/icon_pdf_e.gif' BORDER='0'></a></CENTER></TD>";
					break;
				case($type=='pps' OR $type=='ppsx'):
					echo"<IMG src='../images/icon_pps.gif' BORDER='0'></a></CENTER></TD>";
					break;
				case($type=='txt'):
					echo"<IMG src='../images/icon_txt.gif' BORDER='0'></a></CENTER></TD>";
					break;
				case($type=='swf'): 	
					echo"<IMG src='../images/icon_swf.gif' BORDER='0'></a></CENTER></TD>";
					break;
				default:	
					echo"<IMG src='../images/images_e.gif' BORDER='0'></a></CENTER></TD>";
			}		
			echo"
			</a>";
            }
            else
            if($stt=='Disabled')
        {echo"
			";
			switch ($type)
			{
				case($type=='doc' OR $type=='docx'):
					echo"<IMG src='../images/icon_doc_d.gif' BORDER='0'></CENTER></TD>";
					break;
				case($type=='pdf'):
					echo"
                     <IMG src='../images/icon_pdf_d.gif' BORDER='0'></CENTER></TD>";
					break;
				case($type=='pps' OR $type=='ppsx'):
					echo"<IMG src='../images/icon_pps_d.gif' BORDER='0'></CENTER></TD>";
					break;
				case($type=='txt'):
					echo"<IMG src='../images/icon_txt_d.gif' BORDER='0'></CENTER></TD>";
					break;
				case($type=='swf'):
					echo"<IMG src='../images/icon_swf_d.gif' BORDER='0'></CENTER></TD>";
					break;
				default:
					echo"<IMG src='../images/images_e.gif' BORDER='0'></CENTER></TD>";
			}
			echo"
			</a>";
            }
             echo"
  		<TD WIDTH='95%'>$nmamtr</TD>
	</TR>";
}
?>