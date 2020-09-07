<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$nis	=$_GET['nis'];
$thnabs	=$_GET['thnabs'];
$blnab	=$_GET['blnab'];
$abs	='-'.$blnab.'-'.$thnabs;
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
	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH=' 4%' HEIGHT='20'><CENTER>$no </CENTER></TD>
  		<TD WIDTH='10%'><CENTER>$tglabs			</CENTER></TD>
        <TD WIDTH='10%'><CENTER>$nmastt			</CENTER></TD>
        <TD WIDTH='76%'><CENTER>$ktr			</CENTER></TD>
	</TR>";
    }
}
?>