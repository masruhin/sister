<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdebku	=$_POST['kdebku'];
$query 	=mysql_query("	SELECT 		t_dtlpjm.*
						FROM 		t_dtlpjm
						WHERE 		t_dtlpjm.kdebku='$kdebku'
                        ORDER BY 	t_dtlpjm.nmrpjm desc");
$data	=mysql_fetch_array($query);
$tglkmb	=$data[tglkmbmb];
$kdebku	=$data[kdebku];

if(empty($kdebku))
{
	echo"no";
}
else
	if(empty($tglkmb))
	{
		echo "yes";
	}
	else
	{
		echo "no";
	}
?>