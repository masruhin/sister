<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$prd	=periode('PENJUALAN');
$tglbmb	=$_POST['tglbmb'];
$prdB	=substr($tglbmb,-2).substr($tglbmb,3,2);

if($prdB<>$prd)
{
	echo "no";
}
else
{
	echo "yes";
}
?>