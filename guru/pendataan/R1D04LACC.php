<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LACC.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SISWA print ledger sd
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04LACCclass
{
    // -------------------------------------------------- Cetak Daftar --------------------------------------------------
 	function R1D04LACC()
 	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<script TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></script>";

        $kdekry	=$_SESSION["Admin"]["kdekry"];
		$sms='1';
		$midtrm='1';

	 	echo"
		<FORM ACTION='pendataan/R1D04LACC_C01.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>PRINT ACCOMPLISHMENT REPORT SD</B></TD></TR>
           		<TR></TR><TR></TR>
				
				
				
				<TR><TD WIDTH='15%'>Semester</TD>
					<TD WIDTH='85%'>:
						<INPUT NAME			='sms'
								TYPE		='radio'
								VALUE 		='1'
								ID			='sms'";
						if($sms=='1')
							echo"checked";
							echo"> 
							1
						<INPUT 	NAME		='sms'
								TYPE		='radio'
								VALUE 		='2'
								ID			='sms'";
						if($sms=='2')
							echo"checked";
							echo"> 
							2
					</TD>
				</TR>
				
				<TR><TD>Mid Term</TD>
					<TD>:
						<INPUT NAME			='midtrm'
								TYPE		='radio'
								VALUE 		='1'
								ID			='midtrm'";
						if($midtrm=='1')
							echo"checked";
							echo"> 
							1
						<INPUT 	NAME		='midtrm'
								TYPE		='radio'
								VALUE 		='2'
								ID			='midtrm'";
						if($midtrm=='2')
							echo"checked";
							echo"> 
							2
					</TD>
				</TR>
				
				<TR><TD>Tahun</TD>
					<TD>:
						<INPUT NAME			='thn'
								TYPE		='text'
								VALUE 		='2018'
								ID			='thn'
						>
						
					</TD>
				</TR>
				
                <input type='hidden' name='kdekry' value='$kdekry' />
					
    	   	</TABLE>
			<INPUT TYPE=submit 		VALUE='Print'>
		</FORM>";
 	}
}//akhir class
?>