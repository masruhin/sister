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

$query ="	SELECT 	t_btukng.*,t_jtu.*
			FROM 	t_btukng,t_jtu
			WHERE   t_btukng.nis='". mysql_escape_string($nis)."'	AND
					t_btukng.kdejtu=t_jtu.kdejtu";
$result =mysql_query($query);
echo"
<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='bayar' class='table02'>
	<TR bgcolor='dedede'>
		<TD HEIGHT=40 COLSPAN='8'><CENTER><b>PAYMENT<br>
			($nis) $nmassw</CENTER></b>
		</TD>
	</TR>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='11%'><CENTER>Date			</CENTER></TD>
									<TD WIDTH='15%'><CENTER>Evidence	</CENTER></TD>
                                    <TD WIDTH='58%'><CENTER>Note		</CENTER></TD>
									<TD WIDTH='12%'><CENTER>Amount		</CENTER></TD>
								</TR>";
$no=0;
while($data =mysql_fetch_array($result))
{   $tglbtu	=$data['tglbtu'];
    $nmrbtu	=$data['nmrbtu'];
	$nmajtu	=$data['nmajtu'];
    $ktr	=$data['ktr'];
    $nli	=number_format($data['nli']);

	$no++;
	echo"


								<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
		<TD HEIGHT=20><CENTER>$no 	</CENTER></TD>
  		<TD><CENTER>$tglbtu	</CENTER></TD>
        <TD><CENTER>$nmrbtu	</CENTER></TD>
        <TD>$nmajtu $ktr</TD>
        <TD><CENTER><b>$nli</b></CENTER></TD>
	</TR>";
}	
echo"
							</TABLE>
						</DIV>

	";


?>