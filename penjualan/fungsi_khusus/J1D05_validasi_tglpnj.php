<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$prd	=periode('PENJUALAN');
$tglpnj	=$_POST['tglpnj'];
$prdB	=substr($tglpnj,-2).substr($tglpnj,3,2);

if($prdB<>$prd)
{
	echo "no";
}
else
{
	echo "yes";
}
?>