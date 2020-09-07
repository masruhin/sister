<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: K5L02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Fungsi-fungsi LAPORAN BUKTI KELUAR UANG
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class K5L02class
{	
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function K5L02()
	{
		echo'<script TYPE="text/javascript" src="../js/DatePicker/WdatePicker.js"></script>';
		
		echo"
		<FORM ACTION='laporan/K5L02_Cetak.php' target=_blank METHOD=post NAME=f1 ENCTYPE=multipart/form-data>
			<TABLE  BORDER='0' CELLSPACING='5' CELLPADDING='5' BORDERCOLOR='#000000' WIDTH=100% >
				<TR><TD COLSPAN=2><B>LAPORAN BUKTI KELUAR UANG</B></TD></TR>
				<TR></TR><TR></TR>
              	<TR><TD WIDTH='15%'>Dari Tanggal</TD>
              		<TD WIDTH='85%'>: 
						<INPUT TYPE='text' SIZE=10 MAXLENGTH=10 NAME='tgl1'  id='tgl1' VALUE=''>
							<IMG onClick='WdatePicker({el:tgl1});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
							Sampai Tanggal : 
							<INPUT TYPE='text' SIZE=10 MAXLENGTH=10 NAME='tgl2'  id='tgl2' VALUE='' >
							<IMG onClick='WdatePicker({el:tgl2});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
					</TD>
              	</TR>
				<TR>
					<TD></TD>
					<TD><span style='color: #FF0000;'>* Kosongkan Tanggal untuk periode berjalan</span></TD>
				</TR>
				<TR><TD>Jenis Pengeluaran</TD>
					<TD>: 
						<SELECT	NAME		='kdejku'	
								VALUE 		='$kdejku'
								onkeypress	='return enter(this,event)'>";
						$query	="	SELECT 		t_jku.* 
									FROM 		t_jku  
									ORDER BY 	t_jku.kdejku";
    					$result		=mysql_query($query);
						echo"
						<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
    					while($data=mysql_fetch_array($result))
    					{
							if ($kdejku==$data[kdejku]) 
								echo 
								"<OPTION VALUE='$data[kdejku]' SELECTED>$data[nmajku]</OPTION>";
  	  						else 
								echo 
								"<OPTION VALUE='$data[kdejku]' >$data[nmajku]</OPTION>";
    					}
       					echo
						"</SELECT>		
					</TD>
				</TR>	
			</TABLE>
			<INPUT TYPE=submit 	VALUE=Cetak>
		</FORM>";
	}
}
?>