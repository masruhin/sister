<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$nmrbmbB=$_GET['nmrbmb'];

$prd 	=periode("PENJUALAN");
$query 	="	SELECT 	t_gnrbmb.*
			FROM 	t_gnrbmb
			WHERE 	t_gnrbmb.nmrbmb='". mysql_escape_string($nmrbmbB)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);
		
$str	=$data[str];
$nmrbmb	=$data[nmrbmb];
$tgl	=$data[tglbmb];
$dr		=$data[dr];
$rfr	=$data[rfr];
$prdB	=tgltoprd($tglbmb);

$query ="	SELECT 		*,t_mstbrn.nmabrn,t_sldbrn.kdebrn
			FROM 		t_dtlbmb,t_mstbrn,t_sldbrn
			WHERE 		t_dtlbmb.nmrbmb='$nmrbmb'		AND 
						t_dtlbmb.kdebrn=t_mstbrn.kdebrn	AND 
						t_dtlbmb.kdebrn=t_sldbrn.kdebrn	AND 
						t_sldbrn.prd= $prd";
$result= mysql_query($query) or die (mysql_error());

$no=0;
while($data =mysql_fetch_array($result))
{
	$bny	=number_format($data[bny]);
	$no++;
	echo"
	<TR onMouseOver=\"this.className='normal'='normal'\" onMouseOut=\"this.className='normal'='normal'\" >
		<TD WIDTH=' 5%'><CENTER><input type='hidden'name='nmrbmb'id='nmrbmb' value='$data[nmrbmb]'>$no</CENTER></TD>
 		<TD WIDTH='10%'><CENTER><input type='hidden'name='kdebrn2'id='kdebrn2' value='$data[kdebrn]'>$data[kdebrn]</CENTER></TD>
  		<TD WIDTH='68%'><CENTER>$data[nmabrn]</CENTER></TD>
		<TD WIDTH='12%'><CENTER><input type='hidden'name='bny'id='bny' value='$data[bny]'>$bny</CENTER></TD>
		<TD WIDTH=' 5%'><CENTER><a href='#' id='$data[id]'bny='$data[bny]'class='hapusm'>
								<IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
		echo"
	</TR>";
}
echo"
<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>
<SCRIPT TYPE='text/javascript' src='../penjualan/js/J1D03_hapus.js'></SCRIPT>";
?>
