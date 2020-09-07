<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$nmrpnjB=$_GET['nmrpnj'];

$prd 	=periode("PENJUALAN");
$query 	="	SELECT 	t_gnrpnj.*
			FROM 	t_gnrpnj
			WHERE 	t_gnrpnj.nmrpnj='". mysql_escape_string($nmrpnjB)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);

$str	=$data[str];
$nmrpnj	=$data[nmrpnj];
$tgl	=$data[tglpnj];
$hrg	=$data[hrg];
$prdB	=tgltoprd($tglpnj);

$query ="	SELECT 	t_dtlpnj.*
			FROM 	t_dtlpnj
			WHERE 	t_dtlpnj.nmrpnj='$nmrpnj'
                                        ";
$result= mysql_query($query)	or die (mysql_error());
while($data =mysql_fetch_array($result))
{
	$hrg		=$data['hrg'];
	$bny		=$data['bny'];
	$total		=$hrg*$bny;
	$tl[]		=$total;
	$ntotal		=number_format($total);
	$total1		=array_sum($tl);
	$stotal		=$total1 + '0';
	$subtotal	=number_format($stotal);
}
if($stotal=='')
	echo"0";
else
	echo"$subtotal";
?>