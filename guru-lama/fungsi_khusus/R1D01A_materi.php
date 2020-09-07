<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
$kdegru1=$_GET['kdegru'];
$kdeklm=$_GET['kdeklm'];
$kdeplj=$_GET['kdeplj'];
$query ="	SELECT 	g_gnrmtr.*
			FROM 	g_gnrmtr
			WHERE
					g_gnrmtr.kdeplj='". mysql_escape_string($kdeplj)."' AND
					g_gnrmtr.kdeklm='". mysql_escape_string($kdeklm)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);
$kdemtr	=$data['kdemtr'];

//$stok = $data[sldawl]+$data[msk]-$data[klr];
$query1	=" 	SELECT 		g_dtlmtr.*,t_mstkry.*
			FROM 		g_dtlmtr,t_mstkry
			WHERE 		g_dtlmtr.kdemtr='$kdemtr'AND
                        g_dtlmtr.kdegru=t_mstkry.kdekry
            ORDER BY g_dtlmtr.id";
$result1=mysql_query($query1);

$no=0;
while($data1 =mysql_fetch_array($result1))
{   $nmamtr2=$data1['nmamtr'];
    $kdemtr	=$data1['kdemtr'];
    $kdegru	=$data1['kdegru'];
    $nmakry	=$data1['nmakry'];
    $stt1	=$data1['stt'];
    $tglinp=$data1['tglinp'];
    $jaminp=$data1['jaminp'];
    $type	=$data1['type'];

	$no++;
	echo"
	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH=' 4%'><CENTER>$no	</CENTER></TD>
  		<TD WIDTH='35%'>$nmamtr2</TD>
        <TD WIDTH='30%'><center>$nmakry</center></TD>
        <TD WIDTH='12%'><center>$tglinp/$jaminp</center></TD>";
        if($kdegru!=$kdegru1)
        {
        echo"<TD WIDTH='7%'><center><img src='../images/disable.gif'></center></TD>";
        }
        else
        {
         if($stt1=='Enabled')
         {
         echo"<TD WIDTH='7%'><center><a href='#' stt='$stt1' id='$nmamtr2'class='stt1'><img src='../images/enable.gif' ></a></center></TD>";
         }
         else
         {
         echo"<TD WIDTH='7%'><center><a href='#' stt='$stt1' id='$nmamtr2'class='stt1'><img src='../images/disable.gif' ></a></center></TD>";
         }
        }
        echo"
        <TD WIDTH='	7%'><CENTER><a href='../files/materi/$kdemtr/$nmamtr2.$type'target='_blank'>
								<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
        if($kdegru!=$kdegru1)
                                                        {
                                                          echo"
                                                          <TD WIDTH='7%'><CENTER><IMG src='../images/hapus_d.gif' BORDER='0'></CENTER></TD>";
                                                        }
        else
        {
        echo"
		<TD WIDTH=' 7%'><CENTER><a href='#' id='$data[id]'class='hapusmtr'>
								<IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
        }
        }
        echo"
	</TR>
    <SCRIPT TYPE='text/javascript' src='../guru/js/R1D01A.js'></SCRIPT>
<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>
<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01A_hapus.js'></SCRIPT>
";
?>