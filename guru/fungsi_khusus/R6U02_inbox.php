<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$kdekry=$_GET[kdekry];
$query ="	SELECT 		g_trmeml.*,t_mstkry.nmakry,t_mstkry.kdekry
			FROM 		g_trmeml,t_mstkry
			WHERE 		g_trmeml.utk='". mysql_escape_string($kdekry)."' AND
			            g_trmeml.dri=t_mstkry.kdekry
			ORDER BY	g_trmeml.tglkrm DESC";
$result =mysql_query($query);
echo"

<b>INBOX</b>
<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
	<TR bgcolor='dedede'>
	    <TD WIDTH=' 3%'><CENTER><input type='checkbox' onclick='ceksemua()' id='cekbox'	name='cekbox'		</CENTER></TD>
		<TD WIDTH='17%' HEIGHT='20'><CENTER><b>From</b></CENTER></TD>
		<TD WIDTH='65%'><CENTER><b>Subject</b></CENTER></TD>
		<TD WIDTH='15%'><CENTER><b>Date</b></CENTER></TD>
	</TR>";
	
	$no=0;
	while($data =mysql_fetch_array($result))
	{
		$kdetrm	=$data['kdetrm'];
		$dri	=$data['dri'];
		$nmakry	=$data['nmakry'];
		$kdekry =$data['kdekry'];
		$sbj	=$data['sbj'];
		$tglkrm	=$data['tglkrm'];
		$ktr    =$data['isi'];
		$atch    =$data['atch'];
		$stt    =$data['stt'];
		$id     =$data['id'];
	
		echo"
		<TR id='tr$no'\" bgcolor='F5F5F5'>
			<TD><CENTER><input type=checkbox name='id[]' id='id$no' value='$id'></CENTER></TD>";
			
			if($stt=='')
			{
				echo"
				<TD><a href='#'  id='$data[id]' class='baca'><b>$nmakry</b></a></TD>
				<TD><input type='hidden' id='kdetrm' value='$kdetrm'><a href='#'  id='$id' class='baca'><b>$sbj</b></a>";
				if($atch=='A')
				{
				echo" &nbsp <IMG src='../images/paperclip.gif' BORDER='0'>";
				}echo"</TD>
				<TD><center><a href='#'  id='$data[id]' class='baca'><b>$tglkrm</b></center></a></TD>";
			}
			else
			{
				echo"
				<TD><a href='#'  id='$data[id]' class='baca'>$nmakry</a></TD>
				<TD><input type='hidden' id='kdetrm' value='$kdetrm'><a href='#'  id='$data[id]' class='baca'>$sbj</a>";
				if($atch=='A')
				{
				echo" &nbsp <IMG src='../images/paperclip.gif' BORDER='0'>";
				}echo"</TD>
				<TD><center><a href='#'  id='$data[id]' class='baca'>$tglkrm</center></a></TD>";
			}
			echo"
			
		</TR>";
		$no++;
	}
	
	echo"
	<input type='hidden' id='jumlahcek' value='$no' name='jumlahcek'>
</TABLE>
<input type='button'  id='del' value='delete' onclick='konfirmasicek2()'>
<SCRIPT TYPE='text/javascript' 		src='../guru/js/R6U02_baca.js'></SCRIPT>";
?>