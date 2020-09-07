<?php

require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdeang=$_GET['kdeang'];

$query 	="	SELECT 	*
			FROM 	t_setprp
			WHERE	t_setprp.set LIKE'%".'Batas'."%'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);
$bts	=$data[nli];

$query	=mysql_query(" 	SELECT 		*,t_dtlpjm.kdebku,t_mstbku.jdl
						FROM 		t_gnrpjm,t_dtlpjm,t_mstbku
						WHERE 		t_gnrpjm.kdeang='$kdeang' AND
									t_gnrpjm.nmrpjm=t_dtlpjm.nmrpjm AND
									t_dtlpjm.kdebku=t_mstbku.kdebku
                        ORDER BY 	t_gnrpjm.nmrpjm desc");

$no=0;
while($data =mysql_fetch_array($query))
{ 
	$tglpjm	=$data[tglpjm];
    $jdwpb  =date('d-m-Y',strtotime($tglpjm."+$bts day"));
	$no++;
	echo"
	<TR>
		<TD WIDTH='	4%' HEIGHT='20'><CENTER>$no	</CENTER></TD>
  		<TD WIDTH='10%'><CENTER>$data[nmrpjm]	</CENTER></TD>
  		<TD WIDTH='10%'><CENTER>$data[kdebku]	</CENTER></TD>
  		<TD WIDTH='56%'>$data[jdl]						</TD>
  		<TD WIDTH='10%'><CENTER>$jdwpb			</CENTER></TD>
  		<TD WIDTH='10%'><CENTER>$data[tglkmb]	</CENTER></TD>
	</TR>";
}
echo"
<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>
<SCRIPT TYPE='text/javascript' src='../js/hapus.js'></SCRIPT>";
?>