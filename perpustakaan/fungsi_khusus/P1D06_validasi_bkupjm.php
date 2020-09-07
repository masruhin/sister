<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdebku=$_GET['kdebku'];
$nmrpjm=$_GET['nmrpjm'];
$query =mysql_query("	SELECT 		*,t_gnrpjm.kdeang
						FROM 		t_gnrpjm,t_dtlpjm
						WHERE       t_gnrpjm.nmrpjm='$nmrpjm'		AND
                                    t_gnrpjm.nmrpjm=t_dtlpjm.nmrpjm AND
                                    t_dtlpjm.kdebku='$kdebku'");
$data	=mysql_fetch_array($query);
$kdeang	=$data['kdeang'];
echo"$kdeang";
?>