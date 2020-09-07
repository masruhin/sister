<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kdekry	=$_GET['kdekry'];
$thnabs	=$_GET['thnabs'];
$blnab	=$_GET['blnab'];
$abs	='-'.$blnab.'-'.$thnabs;

$query 	="	SELECT 		t_mstkry.*
			FROM 		t_mstkry
			WHERE 		t_mstkry.kdekry='". mysql_escape_string($kdekry)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);
$nmakry	=$data[nmakry];///01/2015

echo"
	<TR bgcolor='dedede'>
		<TD HEIGHT=40 COLSPAN='8'><CENTER><b>ATTENDANCE<br>
			($kdekry) $nmakry</CENTER></b>
		</TD>
	</TR>
	
								<TR bgcolor='dedede'>
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No</CENTER></TD>
									<TD WIDTH='15%'><CENTER>Date		</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Status		</CENTER>  </TD>
									<TD WIDTH='76%'><CENTER>Note	</CENTER> </TD>
								</TR>";

$query 	="	SELECT 	t_abskry.*,t_sttabs.nmastt
			FROM 	t_abskry,t_sttabs
			WHERE 	t_abskry.kdekry='". mysql_escape_string($kdekry)."'		AND
					(t_abskry.tglabs 	LIKE'%".$abs."%' OR '$abs'='') 	AND
                    t_abskry.kdestt=t_sttabs.kdestt
			ORDER BY t_abskry.tglabs";
$result =mysql_query($query);
$no=0;
while($data =mysql_fetch_array($result))
{   
	$tglabs	=$data['tglabs'];
    $nmastt	=$data['nmastt'];
    $ktr	=$data['ktr'];

	$no++;
    if($thnabs=='')
    { echo"";

    }
    else
    {
	echo"
	<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
		<TD HEIGHT='20'><CENTER>$no </CENTER></TD>
  		<TD><CENTER>$tglabs			</CENTER></TD>
        <TD><CENTER>$nmastt			</CENTER></TD>
        <TD><CENTER>$ktr			</CENTER></TD>
	</TR>";
    }
}
?>