<?php
require_once '../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
              
echo"
<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>";

$kdercu	=$_GET['kdercu'];

$query	=mysql_query(" 	SELECT 		g_dtlrcu.*
						FROM 		g_dtlrcu
						WHERE 		g_dtlrcu.kdercu='$kdercu'
                        ORDER BY 	soal asc ");

$no=0;
while($data =mysql_fetch_array($query))
{
	$soal =susun_kalimat($data['soal'], 80);
	$no++;
	echo"
	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH=' 5%'><CENTER>$no		</CENTER></TD>
		<TD WIDTH='65%'><CENTER>$soal...</CENTER></TD>
	</TR>";
}
echo"
<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>
<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01C_hapus.js'></SCRIPT>";
?>