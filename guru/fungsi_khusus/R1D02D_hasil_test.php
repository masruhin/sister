<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
$nis=$_GET['nis'];

$query ="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.nis='". mysql_escape_string($nis)."'";
$result =mysql_query($query);
$data =mysql_fetch_array($result);
$nmassw=$data[nmassw];

$query ="	SELECT 	u_gnroln.*,g_gnrrcu.*,t_mstbbt.*,t_mstplj.*
			FROM 	u_gnroln,g_gnrrcu,t_mstbbt,t_mstplj
			WHERE
                    u_gnroln.nis='". mysql_escape_string($nis)."' AND
                    u_gnroln.kdercu=g_gnrrcu.kdercu AND
                    g_gnrrcu.kdeplj=t_mstplj.kdeplj AND
                    g_gnrrcu.kdebbt=t_mstbbt.kdebbt
                    ";
$result =mysql_query($query);
echo"
<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='nilai' class='table02'>
	<TR bgcolor='dedede'>
		<TD HEIGHT=40 COLSPAN='8'><CENTER><b>RESULT<br>
			$nmassw</CENTER></b>
		</TD>
	</TR>
	<TR bgcolor='dedede'>
		<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
		<TD WIDTH='10%'><CENTER>Date			</CENTER></TD>
		<TD WIDTH='10%'><CENTER>Time				</CENTER></TD>
		<TD WIDTH='38%'><CENTER>Note		</CENTER></TD>
        <TD WIDTH='20%'><CENTER>Subject		</CENTER></TD>
		<TD WIDTH=' 6%'><CENTER>Type			</CENTER></TD>
		<TD WIDTH=' 6%'><CENTER>Result	</CENTER></TD>
		<TD WIDTH=' 6%'><CENTER>Detail			</CENTER></TD>
	</TR>";
$no=0;
while($data =mysql_fetch_array($result))
{   $tglujn	=$data['tglujn'];
    $jamujn	=$data['jamujn'];
    $ktr	=$data['ktr'];
    $nli	=$data['nli'];
    $kdebbt	=$data['nmabbt'];
    $nmaplj	=$data['nmaplj'];

	$no++;
	echo"
	<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
		<TD><CENTER>$no 	</CENTER></TD>
  		<TD><CENTER>$tglujn	</CENTER></TD>
        <TD><CENTER>$jamujn	</CENTER></TD>
        <TD><CENTER>$ktr	</CENTER></TD>
        <TD><CENTER>$nmaplj	</CENTER></TD>
        <TD><CENTER>$kdebbt	</CENTER></TD>
        <TD><CENTER><b>$nli</b></CENTER></TD>
        <TD><CENTER>
			<a href='../files/materi/$kdemtr/$nmamtr2.$type'target='_blank'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
	</TR>";
}
echo"	
</TABLE>
</DIV>";
?>