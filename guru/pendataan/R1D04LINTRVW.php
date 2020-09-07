<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LINTRVW.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SISWA print ledger sd
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04LINTRVWclass
{
    // -------------------------------------------------- Cetak Daftar --------------------------------------------------
 	function R1D04LINTRVW()
 	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<script TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></script>";

        $kdekry	=$_SESSION["Admin"]["kdekry"];
		$sms='1';
		$midtrm='1';

	 	echo"
		<FORM ACTION='pendataan/R1D04LINTRVW_C01.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>PRINT HASIL INTERVIEW SD</B></TD></TR>
           		<TR></TR><TR></TR>
				
				
				
				<TR><TD WIDTH='15%'>Date</TD>
					<TD WIDTH='85%'>:
						<INPUT 	NAME		='tglctk'
								TYPE		='text'
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$tglctk'
								ID			='tglctk'
								ONKEYPRESS	='return enter(this,event)'>
						<IMG onClick='WdatePicker({el:tglctk});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
					</TD>
				</TR>
				
				
				
                <input type='hidden' name='kdekry' value='$kdekry' />
					
    	   	</TABLE>
			<INPUT TYPE=submit 		VALUE='Print'>
		</FORM>";
 	}
}//akhir class
?>