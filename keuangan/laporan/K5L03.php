<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: K5L03.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Fungsi-fungsi LAPORAN BUKU HARIAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class K5L03class
{	
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function K5L03()
	{
		echo'<script TYPE="text/javascript" src="../js/DatePicker/WdatePicker.js"></script>';
		
		echo"
		<FORM ACTION='laporan/K5L03_Cetak.php' target=_blank METHOD=post NAME=f1 ENCTYPE=multipart/form-data>
			<TABLE  BORDER='0' CELLSPACING='5' CELLPADDING='5' BORDERCOLOR='#000000' WIDTH=100% >
				<TR><TD COLSPAN=2><B>LAPORAN BUKU HARIAN</B></TD></TR>
				<TR></TR><TR></TR>
              	<TR><TD WIDTH='15%'>Dari Tanggal</TD>
              		<TD WIDTH='85%'>: 
						<INPUT TYPE='text' SIZE=10 MAXLENGTH=10 NAME='tgl1'id='tgl1'  VALUE=''>
						<IMG onClick='WdatePicker({el:tgl1});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
						Sampai Tanggal : 
						<INPUT TYPE='text' SIZE=10 MAXLENGTH=10 NAME='tgl2' id='tgl2' VALUE=''>
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