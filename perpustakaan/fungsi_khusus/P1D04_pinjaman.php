<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$nmrpjmB=$_GET['nmrpjm'];

$query 	="	SELECT 	*
			FROM 	t_setprp
			WHERE	t_setprp.set LIKE'%".'Batas'."%'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);
$bts	=$data[nli];

$query 	="	SELECT 	*
			FROM 	t_gnrpjm
			WHERE 	t_gnrpjm.nmrpjm='". mysql_escape_string($nmrpjmB)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);
		
$str	=$data[str];
$nmrpjm	=$data[nmrpjm];
$tgl	=$data[tglpjm];
$jdwpb  =date('d-m-Y',strtotime($tgl."+$bts day"));
$prdB	=tgltoprd($tglpjm);
// akhir inisiasi parameter
$query2 ="	SELECT 		*,t_mstbku.jdl     
			FROM 		t_dtlpjm,t_mstbku
            WHERE 		t_dtlpjm.nmrpjm='$nmrpjm'AND
						t_dtlpjm.kdebku=t_mstbku.kdebku";
$result= mysql_query($query2)	or die (mysql_error());

$no=0;
while($data =mysql_fetch_array($result))
{
	$no++;
	echo"
	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH=' 4%' HEIGHT='20'><CENTER>$no	</CENTER></TD>
  		<TD WIDTH='10%'><CENTER>$data[kdebku]	</CENTER></TD>
  		<TD WIDTH='76%'>$data[jdl]						</TD>
  		<TD WIDTH='10%'><CENTER>$jdwpb			</CENTER></TD>
	</TR>";
}
echo"
<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>
<SCRIPT TYPE='text/javascript' src='../js/hapus.js'></SCRIPT>";
?>