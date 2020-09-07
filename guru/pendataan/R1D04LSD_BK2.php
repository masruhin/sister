<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LSD_BK2.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SISWA print ledger sd
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04LSD_BK2class
{
    // -------------------------------------------------- Cetak Daftar --------------------------------------------------
 	function R1D04LSD_BK2()
 	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<script TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></script>";

        $kdekry	=$_SESSION["Admin"]["kdekry"];
		$sms='1';
		$midtrm='1';

	 	echo"
		<FORM ACTION='pendataan/R1D04LSD_BK2_C01.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>PRINT BIMBINGAN KONSELING (PS) STATUS CONSELING</B></TD></TR>
           		<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>NIS</TD>
					<TD WIDTH='85%'>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>
						<OPTION VALUE='' SELECTED>--Select--</OPTION>";
						$query3="	SELECT 		nis, nmassw, kdekls
									FROM 		t_mstssw
                                    WHERE      	str != 'K' AND 
												( kdekls LIKE 'P-%' )
									ORDER BY	kdekls,nmassw "; // kdekls LIKE 'P-%'
						$result3=mysql_query($query3);
						while($data3=mysql_fetch_array($result3))
						{
							$kelas		=$data3[kdekls];
							$kelas = substr( $kelas, 0, 3);
							
							if ($kdekls==$data3[nis])
								echo"<OPTION VALUE='$data3[nis]' SELECTED>$data3[nmassw] ($kelas)</OPTION>";
							else
								echo"<OPTION VALUE='$data3[nis]'>$data3[nmassw] ($kelas)</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>
				<TR><TD>Semester</TD>
					<TD>:
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
				
				
				
                <TR><TD>Print Date</TD>
              		<TD>:
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
    	   	</TABLE>
			<INPUT TYPE=submit 		VALUE='Print'>
		</FORM>";
 	}
}//akhir class
?>