<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D11D.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SISWA rapot SD 
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D11Dclass
{
    // -------------------------------------------------- Cetak Daftar --------------------------------------------------
 	function R1D11D()
 	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<script TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></script>";

        $kdekry	=$_SESSION["Admin"]["kdekry"];
		$sms='1';
		$midtrm='1';

	 	echo"
		<!--<FORM ACTION='pendataan/R1D11D_C01.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>-->
		<FORM ACTION='pendataan/R1D11D_C01_HTML.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>CETAK RAPOR DIKNAS (SD) AKADEMIK PENGETAHUAN</B></TD></TR>
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
												(t_klmkls.kdetkt='PS' OR t_klmkls.kdetkt='JHS' OR t_klmkls.kdetkt='SHS') AND
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
				</TR>";
				
				/*echo"
				<TR><TD>NIS</TD>
					<TD>:
						<input name='nis' type='text' value='' id='nis' />
					</TD>
				</TR>";*/
				
				/*echo"<input name='sms' type='hidden' value='2' id='sms' />";
				echo"
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
				</TR>";						asli */
				
				echo"<TR><TD>Semester</TD>
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
				";
				/*<TR><TD>Mid Term</TD>
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
				</TR>*/
				
				echo"
                <!--<TR><TD>Print Date</TD>
              		<TD>:
						<INPUT 	NAME		='tglctk'
								TYPE		='text'
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='11-12-2020'
								ID			='tglctk'
								ONKEYPRESS	='return enter(this,event)'>
						<IMG onClick='WdatePicker({el:tglctk});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
					</TD>
				</TR>-->
				<!--$tglctk-->
				<!--<tr>
					<td>Tahun Pelajaran</td><td> : 
						
						<input type='text' NAME='thnajr' ID='thnajr' value='2018-2019' readonly/>
						
					</td>
				</tr>-->				
    	   	</TABLE>
			<INPUT TYPE='submit' VALUE='Cetak' />
		</FORM>";
 	}
}//akhir class
?>