<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdekry=$_GET['kdekry'];
$query ="	SELECT 	*,t_mstplj.nmaplj
			FROM 	g_gnrrcu,t_mstplj
			WHERE g_gnrrcu.kdegru='". mysql_escape_string($kdekry)."' AND
                  g_gnrrcu.kdeplj=t_mstplj.kdeplj";
$result =mysql_query($query);
 echo"
 <div style='overflow:auto;width:100%;height:400px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' class='table02'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 5%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='40%'><CENTER>Planning Test		</CENTER></TD>
                                    <TD WIDTH='15%'><CENTER>Subject		</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Date				</CENTER>
									<TD WIDTH='10%'><CENTER>Time				</CENTER>
                                    <TD WIDTH='10%'><CENTER>Detail				</CENTER></TD>
                                    <TD WIDTH='10%'><CENTER>Result				</CENTER></TD>
								</TR>";
$no=0;
while($data =mysql_fetch_array($result))
{
    $kdercu	=$data['kdercu'];
    $tglrcu	=$data['tglrcu'];
	$jamrcu	=$data['jamrcu'];
    $nmaplj	=$data['nmaplj'];
    $ktr=$data['ktr'];
	$no++;
	echo"

	<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
		<TD><CENTER>$no 	</CENTER></TD>
  		<TD> $ktr	</TD>
        <TD><center>$nmaplj<center></TD>
        <TD><center>$tglrcu</center>	</TD>
		<TD><center>$jamrcu</center>	</TD>
        <TD><CENTER>
			                   <a href='../files/materi/$kdemtr/$nmamtr.$type'target='_blank'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>
       <TD><CENTER>
			                   <a href='../files/materi/$kdemtr/$nmamtr.$type'target='_blank'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>
	</TR>";
}
//echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D02B.js'></SCRIPT>";
?>