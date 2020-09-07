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
<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' class='table02'>
	<TR bgcolor='dedede'>
		<TD COLSPAN='3' HEIGHT='20'><CENTER><b>Class : $kdekls</CENTER></b></TD>
	</TR>
	<TR bgcolor='dedede'>
		<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
		<TD WIDTH='48%'><CENTER>Subject			</CENTER></TD>
		<TD WIDTH='48%'><CENTER>Teacher				</CENTER></TD>
	</TR>";
$no=0;
while($data =mysql_fetch_array($result))
{
	$nmaplj	=$data['nmaplj'];
    $nmakry	=$data['nmakry'];
	$kdekry	=$data['kdekry'];
	$no++;
	echo"

	<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
		<TD HEIGHT='20'><CENTER>$no 	</CENTER></TD>
  		<TD>$nmaplj	</TD>
        <TD>$nmakry ($kdekry)</TD>
	</TR>";
}
echo"
</TABLE>";
?>