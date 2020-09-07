<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
$nis=$_GET['nis'];
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
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='nilai'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Tanggal			</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Jam				</CENTER></TD>
									<TD WIDTH='38%'><CENTER>Keterangan		</CENTER></TD>
                                    <TD WIDTH='20%'><CENTER>Pelajaran		</CENTER></TD>
									<TD WIDTH=' 6%'><CENTER>Bobot			</CENTER></TD>
									<TD WIDTH=' 6%'><CENTER>Nilai	</CENTER></TD>
									<TD WIDTH=' 6%'><CENTER>Detil			</CENTER></TD>
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


								<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
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
	</TR>
							</TABLE>
						</DIV>

	";
}

?>