<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
$nis=$_GET['nis'];
$query ="	SELECT 	t_btukng.*
			FROM 	t_btukng
			WHERE   t_btukng.nis='". mysql_escape_string($nis)."'";
$result =mysql_query($query);
echo"
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='bayar'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Tanggal			</CENTER></TD>
									<TD WIDTH='15%'><CENTER>Nomor Bukti		</CENTER></TD>
                                    <TD WIDTH='61%'><CENTER>Keterangan		</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Nilai			</CENTER></TD>
								</TR>";
$no=0;
while($data =mysql_fetch_array($result))
{   $tglbtu	=$data['tglbtu'];
    $nmrbtu	=$data['nmrbtu'];
    $ktr	=$data['ktr'];
    $nli	=number_format($data['nli']);

	$no++;
	echo"


								<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD HEIGHT=20><CENTER>$no 	</CENTER></TD>
  		<TD><CENTER>$tglbtu	</CENTER></TD>
        <TD><CENTER>$nmrbtu	</CENTER></TD>
        <TD><CENTER>$ktr	</CENTER></TD>
        <TD><CENTER><b>$nli</b></CENTER></TD>
	</TR>
							</TABLE>
						</DIV>

	";
}

?>