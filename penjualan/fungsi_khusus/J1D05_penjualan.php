<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$nmrpnjB=$_GET['nmrpnj'];

$prd 	=periode("PENJUALAN");
$query 	="	SELECT 	*
			FROM 	t_gnrpnj
			WHERE 	t_gnrpnj.nmrpnj='". mysql_escape_string($nmrpnjB)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);
		
$str	=$data[str];
$nmrpnj	=$data[nmrpnj];
$tgl	=$data[tglpnj];
$hrg	=$data[hrg];
$prdB	=tgltoprd($tglpnj);

$query ="	SELECT 		t_dtlpnj.*,t_mstbrn.nmabrn,t_sldbrn.kdebrn
			FROM 		t_dtlpnj,t_mstbrn,t_sldbrn
			WHERE 		t_dtlpnj.nmrpnj='$nmrpnj'		AND 
						t_dtlpnj.kdebrn=t_mstbrn.kdebrn	AND 
						t_dtlpnj.kdebrn=t_sldbrn.kdebrn	AND 
						t_sldbrn.prd= $prd";
$result= mysql_query($query) or die (mysql_error());

$no=0;
while($data =mysql_fetch_array($result))
{
	$hrg		=$data['hrg'];
	$bny		=$data['bny'];
	$total		=$hrg*$bny;
	$tl[]		=$total;
	$ntotal		=number_format($total);
	$total1		=array_sum($tl);
	$subtotal	=number_format($total1);
	$hrgt		=number_format($hrg);
	$bny		=number_format($bny);
	$no++;
	echo"
	<TR onMouseOver=\"this.className='normal'='normal'\" onMouseOut=\"this.className='normal'='normal'\">
		<TD WIDTH='  5%'><CENTER>$no			</CENTER></TD>
		<TD WIDTH=' 10%'><CENTER>$data[kdebrn]	</CENTER></TD>
		<TD WIDTH=' 41%'><CENTER>$data[nmabrn]	</CENTER></TD>
		<TD WIDTH=' 15%'><CENTER>$hrgt			</CENTER></TD>
		<TD WIDTH=' 12%'><CENTER>$bny			</CENTER></TD>
		<TD WIDTH=' 12%'><CENTER>$ntotal		</CENTER></TD>
		<TD WIDTH='  5%'><CENTER><a href='#' id='$data[id]'bny='$data[bny]'class='hapus1'>
								<IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>
	</TR>";
}
echo"
<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>
<SCRIPT TYPE='text/javascript' src='../penjualan/js/J1D05_hapus.js'></SCRIPT>";
?>