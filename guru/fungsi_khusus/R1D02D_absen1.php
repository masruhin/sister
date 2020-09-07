<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$nis	=$_GET['nis'];
$thnabs	=$_GET['thnabs'];
$blnab	=$_GET['blnab'];
$abs	='-'.$blnab.'-'.$thnabs;

$query ="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.nis='". mysql_escape_string($nis)."'";
$result =mysql_query($query);
$data =mysql_fetch_array($result);
$nmassw=$data[nmassw];

echo"
	<TR bgcolor='dedede'>
		<TD HEIGHT=40 COLSPAN='8'><CENTER><b>ATTENDANCE<br>
			($nis) $nmassw</CENTER></b>
		</TD>
	</TR>

								<TR bgcolor='dedede'>
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Date	</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Status	</CENTER>  </TD>
									<TD WIDTH='76%'><CENTER>Note	</CENTER> </TD>
								</TR>";

$query 	="	SELECT 	t_absssw.*,t_sttabs.nmastt
			FROM 	t_absssw,t_sttabs
			WHERE 	t_absssw.nis='". mysql_escape_string($nis)."'		AND
					(t_absssw.tglabs 	LIKE'%".$abs."%' OR '$abs'='') 	AND
                    t_absssw.kdestt=t_sttabs.kdestt";
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
		<TD WIDTH=' 4%' HEIGHT='20'><CENTER>$no </CENTER></TD>
  		<TD WIDTH='10%'><CENTER>$tglabs			</CENTER></TD>
        <TD WIDTH='10%'><CENTER>$nmastt			</CENTER></TD>
        <TD WIDTH='76%'><CENTER>$ktr			</CENTER></TD>
	</TR>";
    }
}
?>