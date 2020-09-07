<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdekry=$_GET[kdekry];
$query ="	SELECT 		g_krmeml.*,t_mstkry.nmakry
			FROM 		g_krmeml,t_mstkry
			WHERE 		g_krmeml.dri='". mysql_escape_string($kdekry)."' AND
			            g_krmeml.dri=t_mstkry.kdekry
			ORDER BY	g_krmeml.tglkrm DESC";
$result =mysql_query($query);

echo"
<b>OUTBOX</b>
<SCRIPT TYPE='text/javascript' 		src='../guru/js/R6U02_baca.js'></SCRIPT>
<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
	<TR bgcolor='dedede'>
	    <TD WIDTH=' 3%'><CENTER><input type='checkbox' onclick='ceksemua()' id='cekbox'	name='cekbox'		</CENTER></TD>
		<TD WIDTH='17%'><CENTER><b>To</b></CENTER></TD>
		<TD WIDTH='65%'><CENTER><b>Subject</b></CENTER></TD>
		<TD WIDTH='15%'><CENTER><b>Date</b></CENTER></TD>
	</TR>";
	$no=0;
	while($data =mysql_fetch_array($result))
	{
		$kdekrm	=$data['kdekrm'];
		$utk	=$data['utk'];
		$nmakry	=$data['nmakry'];
		$kdekry =$data['kdekry'];
		$sbj	=$data['sbj'];
		$tglkrm	=$data['tglkrm'];
		$ktr    =$data['isi'];
		$atch    =$data['atch'];
		$stt    =$data['stt'];
		$id     =$data['id'];

			$ut=(explode(",",$utk));
			$jmlut=count($ut);
			for($t=0;$t<$jmlut;$t++)
			{
				$query2 	="	SELECT t_mstkry.nmakry
							FROM 		t_mstkry
							WHERE 		t_mstkry.kdekry='". mysql_escape_string($ut[$t])."'";
				$result2 =mysql_query($query2);
				while($data2=mysql_fetch_array($result2))
				{
					$nmak=$data2[nmakry];
				}
			}
			$nmak=substr($nmak,0,20).'...';
	
		echo"
		<TR id='tr$no'\" bgcolor='F5F5F5'>
			<TD>
				<CENTER><input type=checkbox name='id[]' id='id$no' class='hp' value='$id'></CENTER>
			</TD>
			<TD>
				<a href='#'  id='$data[id]' class='baca1'>$nmak </a>	
			</TD>
			<TD>
				<a href='#'  id='$data[id]' class='baca1'>$sbj</a>";
				if($atch=='A')
				{
				echo" &nbsp <IMG src='../images/paperclip.gif' BORDER='0'>";
				}echo"
			</TD>
			<TD>
				<center><a href='#'  id='$data[id]' class='baca1'>$tglkrm</center></a>
			</TD>
		</TR>";
		$no++;
	}
	echo"
	<input type='hidden' id='jumlahcek' value='$no' name='jumlahcek'>
</TABLE>
<input type='button'  id='del' value='delete' onclick='konfirmasicek3()'>";
?>