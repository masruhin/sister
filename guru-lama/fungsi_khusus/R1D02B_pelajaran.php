<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdekls=$_GET['kdekls'];
$query ="	SELECT 	*,t_mstkry.nmakry,t_mstplj.nmaplj
			FROM 	t_mstpng,t_mstkry,t_mstplj
			WHERE t_mstpng.kdekls='". mysql_escape_string($kdekls)."' AND
                  t_mstpng.kdegru=t_mstkry.kdekry AND
                  t_mstpng.kdeplj=t_mstplj.kdeplj
			ORDER BY t_mstpng.kdeplj";
$result =mysql_query($query);
 echo"
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='48%'><CENTER>Pelajaran			</CENTER></TD>
									<TD WIDTH='48%'><CENTER>Guru				</CENTER></TD>
								</TR>";
$no=0;
while($data =mysql_fetch_array($result))
{
	$nmaplj	=$data['nmaplj'];
    $nmakry	=$data['nmakry'];
	$no++;
	echo"

	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD HEIGHT='20'><CENTER>$no 	</CENTER></TD>
  		<TD>$nmaplj	</TD>
        <TD>$nmakry	</TD>
	</TR>";
}
echo"
</TABLE>";
?>