<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: J5L03.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: Fungsi-fungsi LAPORAN PERNJUALAN ( Per Hari )
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<H1>Permission Denied</H1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class J5L03class
{	
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function J5L03()
	{
		echo'<SCRIPT TYPE="text/javascript" src="../js/DatePicker/WdatePicker.js"></SCRIPT>';
		
		echo"
		<FORM ACTION='laporan/J5L03_Cetak.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE  BORDER='0' CELLSPACING='5' CELLPADDING='5' BORDERCOLOR='#000000' WIDTH='100%'>
				<TR><TD COLSPAN=2><B>LAPORAN PERNJUALAN ( Per Hari )</B></TD></TR>
				<TR></TR><TR></TR>
              	<TR><TD WIDTH='15%'>Dari Tanggal</TD>
              		<TD WIDTH='85%'>: 
						<INPUT TYPE='text' SIZE=10 MAXLENGTH=10 NAME='tgl1'  id='tgl1'VALUE=''>
						<IMG onClick='WdatePicker({el:tgl1});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
						Sampai Tanggal : 
						<INPUT TYPE='text' SIZE=10 MAXLENGTH=10 NAME='tgl2'  VALUE='' id='tgl2'>
						<IMG onClick='WdatePicker({el:tgl2});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
					</TD>
              	</TR>
				<TR>
					<TD></TD>
					<TD><span style='color: #FF0000;'>* Kosongkan Tanggal untuk periode berjalan</span></TD>
				</TR>
			</TABLE>
			<INPUT TYPE=submit 	VALUE=Cetak>
		</FORM>";
	}
}
?>