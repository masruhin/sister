<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdekls=$_GET['kdekls'];
$query ="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."'
			ORDER BY	t_mstssw.nmassw";
$result =mysql_query($query);
echo"
<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
	<TR bgcolor='dedede'>
		<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
		<TD WIDTH='15%'><CENTER>NIS				</CENTER></TD>
		<TD WIDTH='75%'><CENTER>Siswa			</CENTER></TD>
		<TD WIDTH=' 6%'><CENTER>Detil			</CENTER></TD>
	</TR>";
$no=0;
while($data =mysql_fetch_array($result))
{
	$nmassw	=$data['nmassw'];
	$nis	=$data['nis'];
	$no++;
	echo"

	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD HEIGHT='20'><CENTER>$no 	</CENTER></TD>
		<TD><CENTER>$nis</CENTER></TD>
  		<TD>$nmassw	</TD>
		<TD><CENTER><a href='../tatausaha/pendataan/T1D01_C01.php?nis=$nis' target=_blank><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
		
	</TR>";
}
//echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D02B.js'></SCRIPT>";
?>