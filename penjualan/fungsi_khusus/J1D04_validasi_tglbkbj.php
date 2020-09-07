<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$prd	=periode('PENJUALAN');
$tglbkb	=$_POST['tglbkb'];
$prdB	=substr($tglbkb,-2).substr($tglbkb,3,2);

if($prdB<>$prd)
{
	echo "no";
}
else
{
	echo "yes";
}
?>