<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$prd	=periode('KEUANGAN');
$tglbtu	=$_POST['tglbtu'];
$prdB	=substr($tglbtu,-2).substr($tglbtu,3,2);

if($prdB<>$prd)
{
	echo "no";
}
else
{
	echo "yes";
}
?>