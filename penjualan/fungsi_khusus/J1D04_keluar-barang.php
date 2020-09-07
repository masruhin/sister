<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$nmrbkbB=$_GET['nmrbkb'];

$prd 	=periode("PENJUALAN");
$query 	="	SELECT 	t_gnrbkb.*
			FROM 	t_gnrbkb
			WHERE 	t_gnrbkb.nmrbkb='". mysql_escape_string($nmrbkbB)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);
		
$str	=$data[str];
$nmrbkb	=$data[nmrbkb];
$tgl	=$data[tglbkb];
$utk	=$data[utk];
$ktr	=$data[ktr];
$prdB	=tgltoprd($tglbkb);

$query ="	SELECT 		t_dtlbkb.*,t_mstbrn.*,t_sldbrn.*
			FROM 		t_dtlbkb,t_mstbrn,t_sldbrn
			WHERE 		t_dtlbkb.nmrbkb='$nmrbkb'		AND 
						t_dtlbkb.kdebrn=t_mstbrn.kdebrn	AND 
						t_dtlbkb.kdebrn=t_sldbrn.kdebrn	AND 
						t_sldbrn.prd= $prd";
$result= mysql_query($query) or die (mysql_error());

$no=0;
while($data =mysql_fetch_array($result))
{
	$cekstok=$data['sldawl']+$data['msk']-$data['klr'];
	$bny	=number_format($data[bny]);
	$no++;
	echo"
	<TR onMouseOver=\"this.className='normal'='normal'\" onMouseOut=\"this.className='normal'='normal'\" >
		<TD WIDTH=' 5%'><CENTER><input type='hidden'	name='nmrbkb'	id='nmrbkb' 	value='$data[nmrbkb]'>$no			</CENTER></TD>
		<TD WIDTH='10%'><CENTER><input type='hidden'	name='kdebrn2'	id='kdebrn2' 	value='$data[kdebrn]'>$data[kdebrn]	</CENTER></TD>
		<TD WIDTH='68%'><CENTER>$data[nmabrn]</CENTER></TD>
		<TD WIDTH='12%'><CENTER>$bny</CENTER></TD>
		<TD WIDTH=' 5%'><CENTER><a href='#' id='$data[id]'bny='$data[bny]'class='hapus'>
								<IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>
	</TR>";
}
echo"
<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>
<SCRIPT TYPE='text/javascript' src='../penjualan/js/J1D04_hapus.js'></SCRIPT>";
?>