<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$nmassw=$_GET['nmassw'];
$kdekls=$_GET['kdekls'];
$query ="	SELECT 	*
			FROM 	t_mstssw
			WHERE t_mstssw.kdekls='". mysql_escape_string($kdekls)."'AND
            (t_mstssw.nmassw 	LIKE'%".$nmassw."%' OR '$nmassw'='')";
$result =mysql_query($query);

$no=0;
while($data =mysql_fetch_array($result))
{   
	$nis	=$data['nis'];
	$nmassw	=$data['nmassw'];

	$no++;
	echo"
	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH=' 8%'><CENTER>$no 	</CENTER></TD>
  		<TD WIDTH='52%'>$nmassw</TD>
		<TD WIDTH='10%'><CENTER><a href='../tatausaha/pendataan/T1D01_C01.php?nis=$nis' target=_blank><IMG src='../images/icon_pdf_e.gif' BORDER='0'></a></CENTER></TD>
        <TD WIDTH='10%'>
			<CENTER><a href='#' nmasw='$nmassw' id='$data[nis]' class='nilai'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
        <TD WIDTH='10%'><CENTER>
			<a href='#' nmasw='$nmassw' id='$data[nis]' class='kehadiran'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
        <TD WIDTH='10%'><CENTER>
			<a href='#' nmasw='$nmassw' id='$data[nis]' class='bayar'>
			<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		</TD>
	</TR>";
}
echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D02D.js'></SCRIPT>";
?>