<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04E.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SISWA
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Eclass
{
    // -------------------------------------------------- Cetak Daftar --------------------------------------------------
 	function R1D04E()
 	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<script TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></script>";

        $kdekry	=$_SESSION["Admin"]["kdekry"];
		$trm='1';

	 	echo"
		<FORM ACTION='pendataan/R1D04E_C01.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>PRINT PROGRESS REPORT</B></TD></TR>
           		<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Class</TD>
					<TD WIDTH='85%'>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>
						<OPTION VALUE='' SELECTED>--Select--</OPTION>";
						$query2="	SELECT 		*,t_mstkls.kdekls
									FROM 		t_prstkt,t_klmkls,t_mstkls
                                    WHERE      	t_prstkt.kdekry='". mysql_escape_string($kdekry)."' AND
												t_prstkt.kdetkt=t_klmkls.kdetkt AND
												(t_klmkls.kdetkt='PG' OR t_klmkls.kdetkt='KG') AND
												(t_prstkt.kdejbt<400 OR t_prstkt.kdejbt=900) AND
												t_klmkls.kdeklm=t_mstkls.kdeklm	AND
												(t_mstkls.wlikls='". mysql_escape_string($kdekry)."' OR t_prstkt.kdejbt<300 OR t_prstkt.kdejbt=900)
									ORDER BY t_mstkls.kdeklm,t_mstkls.kdekls";
						$result2=mysql_query($query2);
						while($data=mysql_fetch_array($result2))
						{
							if ($kdekls==$data[kdekls])
								echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>
				<TR><TD>Term</TD>
					<TD>:
						<INPUT NAME			='trm'
								TYPE		='radio'
								VALUE 		='1'
								ID			='trm'";
						if($trm=='1')
							echo"checked";
							echo"> 
							1
						<INPUT 	NAME		='trm'
								TYPE		='radio'
								VALUE 		='2'
								ID			='trm'";
						if($trm=='2')
							echo"checked";
							echo"> 
							2
						<INPUT 	NAME		='trm'
								TYPE		='radio'
								VALUE 		='3'
								ID			='trm'";
						if($trm=='')
							echo"checked";
							echo"> 
							3
						<INPUT 	NAME		='trm'
								TYPE		='radio'
								VALUE 		='4'
								ID			='trm'";
						if($trm=='')
							echo"checked";
							echo"> 
							4	
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