<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04D.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SISWA
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Dclass
{
    // -------------------------------------------------- Cetak Daftar --------------------------------------------------
 	function R1D04D()
 	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<script TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></script>";
		echo"
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../guru/js/R1D04D.js'></SCRIPT>";

        $kdekry	=$_SESSION["Admin"]["kdekry"];

	 	echo"
		<FORM ACTION='pendataan/R1D04D_C01.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>PRINT WEEKLY PROGRESS</B></TD></TR>
           		<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Class</TD>
					<TD WIDTH='85%'>:
						<INPUT TYPE='hidden' 	NAME='kdegru' ID='kdegru'	VALUE='$kdekry'>
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								CLASS		='kdekls'
								onkeypress	='return enter(this,event)'>
						<OPTION VALUE='' SELECTED>--Select--</OPTION>";
						$query2="	SELECT 		t_mstkls.*,t_prstkt.*,t_klmkls.*
									FROM 		t_mstkls,t_prstkt,t_klmkls
                                    WHERE      	t_prstkt.kdekry='". mysql_escape_string($kdekry)."' AND
												t_prstkt.kdetkt=t_klmkls.kdetkt AND
												(t_klmkls.kdetkt='PG' OR t_klmkls.kdetkt='KG') AND
												(t_prstkt.kdejbt<400 OR t_prstkt.kdejbt=900) AND
												t_klmkls.kdeklm=t_mstkls.kdeklm	AND
												(t_mstkls.wlikls='". mysql_escape_string($kdekry)."' OR t_prstkt.kdejbt<300 OR t_prstkt.kdejbt=900)
									ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
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
				<TR><TD>Weekly Progress</TD>
					<TD>:
						<SELECT NAME		='idwa'
								ID			='idwa'
								CLASS		='idwa'
								ONKEYUP		='uppercase(this.id)'>
							<OPTION VALUE='' SELECTED>--Select--</OPTION>
						</SELECT>
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
}
?>