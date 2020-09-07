<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdekls=$_GET['kdekls'];
$query ="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
						t_mstssw.str != 'K'
            ORDER BY 	t_mstssw.nmassw";
$result =mysql_query($query);

echo"
<TR bgcolor='dedede'>
	<TD WIDTH=' 5%' HEIGHT='20'><CENTER>No	</CENTER></TD>
	<TD WIDTH='55%'><CENTER>Name			</CENTER></TD>
	<TD WIDTH='10%'><CENTER>Detail			</CENTER></TD>
	<!--<TD WIDTH='10%'><CENTER>Result			</CENTER></TD>-->
	<TD WIDTH='10%'><CENTER>Atten.			</CENTER></TD>
    <!--<TD WIDTH='10%'><CENTER>Paym.			</CENTER></TD>-->
</TR>";

$no=0;
while($data =mysql_fetch_array($result))
{   
	$nis	=$data['nis'];
	$nmassw	=$data['nmassw'];
    $kdekls	=$data['kdekls'];
 
	$no++;
	echo"
	<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
		<TD><CENTER>$no 	</CENTER></TD>
  		<TD>($nis) $nmassw</TD>
		<TD><CENTER><a href='../tatausaha/pendataan/T1D01_C01.php?nis=$nis' target=_blank><IMG src='../images/icon_pdf_e.gif' BORDER='0'></a></CENTER></TD>
        <!--<TD>
			<CENTER><a href='#' nmasw='$nmassw' id='$data[nis]' class='nilai'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>-->
        <TD><CENTER>
			<a href='#' nmasw='$nmassw' id='$data[nis]' class='kehadiran'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
        <!--<TD><CENTER>
			<a href='#' href='#' nmasw='$nmassw' id='$data[nis]' class='bayar'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>-->
	</TR>";
}
echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D02D.js'></SCRIPT>";
?>