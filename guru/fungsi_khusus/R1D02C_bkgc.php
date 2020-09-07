<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdekry=$_GET['kdekry'];
$query ="	SELECT 		t_mstkry.*
			FROM 		t_mstkry
			WHERE 		t_mstkry.kdekry='". mysql_escape_string($kdekry)."'";
$result =mysql_query($query);
$data =mysql_fetch_array($result);
$nmakry=$data[nmakry];



$query ="	SELECT 		DISTINCT t_hdrkmnps_sd_det.nis
			FROM 		t_hdrkmnps_sd_det
			WHERE 		t_hdrkmnps_sd_det.kdeusr='". mysql_escape_string($kdekry)."'
			ORDER BY 	t_hdrkmnps_sd_det.nis";
$result =mysql_query($query);
echo"
<div style='overflow:auto;width:100%;height:360px;padding-right:-2px;'>
<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='20' CELLSPACING='0' WIDTH='100%' class='table02'>
	<TR bgcolor='dedede'>
		<TD HEIGHT=40><CENTER><b>BK<br>
			$nmakry</CENTER></b>
		</TD>
	</TR>";

	$no=0;
	while($data =mysql_fetch_array($result))
	{
		$nis	=$data['nis'];
		
		$no++;
		echo"
		<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
			<TD>
				<a href='../files/materi/' target='_blank'>";
				
				echo"<BR>
				<b>$nmarpp</b></a><BR>
				$nmaklm - $nmaplj<BR>
				$tglinp / $jaminp
		    </TD>
		</TR>";
	}
//echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D02B.js'></SCRIPT>";
?>