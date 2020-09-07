<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LTK2.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SISWA print ledger sd
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04LTK2class
{
    // -------------------------------------------------- Cetak Daftar --------------------------------------------------
 	function R1D04LTK2()
 	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<script TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></script>";

        $kdekry	=$_SESSION["Admin"]["kdekry"];
		$sms='1';
		$midtrm='1';
		
		//R1D04LTK2_C01

	 	echo"
		<FORM ACTION='pendataan/R1D04LTK2_C01_html.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>PRINT LEARNING RECORD K2</B></TD></TR>
           		<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>NIS</TD>
					<TD WIDTH='85%'>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>
						<OPTION VALUE='' SELECTED>--Select--</OPTION>";
						$query2="	SELECT 		nis, nmassw
									FROM 		t_mstssw
                                    WHERE      	str != 'K' AND 
												( kdekls LIKE 'KG-B%' ) AND 
												thn_ajaran = '2018-2019'
									ORDER BY	kdekls "; // kdekls LIKE 'PG%' OR 
						$result2=mysql_query($query2);
						while($data=mysql_fetch_array($result2))
						{
							if ($kdekls==$data[nis])
								echo"<OPTION VALUE='$data[nis]' SELECTED>$data[nmassw] - $data[nis]</OPTION>";
							else
								echo"<OPTION VALUE='$data[nis]'>$data[nmassw] - $data[nis]</OPTION>";
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