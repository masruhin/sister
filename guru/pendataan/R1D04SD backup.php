<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04SD.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT LEARNING RECORD
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04SDclass
{
	function R1D04SD()
	{
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/ajax.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/ajax-dynamic-list.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";
		
		echo"<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>";
		
		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../perpustakaan/js/P1D04_validasi_bkupjm.js'></SCRIPT>
		";
		
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/jquery-1.2.3.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/jquery.validate.pack.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript'>
			$(document).ready(function()
			{
				$('#validasi').validate()
			});
		</SCRIPT>";
		
		echo"
		<SCRIPT language='javascript'>
		function sf()
			{ 
				document.f1.kdekls.focus();
				//document.f1.kdeang.focus();
			}
		</SCRIPT>
		
		<SCRIPT>
		function sw()
		{ 
			
		}
		</SCRIPT>
		";
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$kdeang	=$_GET['kdeang'];
		$nmasw	=$_GET['nmasw'];
		$pilihan=$_GET['pilihan'];

		$sms	='Semester';
		$query 	=mysql_query("	SELECT 		t_setthn_sd.* 
								FROM 		t_setthn_sd
								WHERE		t_setthn_sd.set='$sms'");// menghasilkan semester
		$data = mysql_fetch_array($query);
		$sms=$data[nli];
					
		$midtrm	='Mid Term';
		$query 	=mysql_query("	SELECT 		t_setthn_sd.* 
								FROM 		t_setthn_sd
								WHERE		t_setthn_sd.set='$midtrm'");// menghasilkan mid
		$data = mysql_fetch_array($query);
		$nlitrm=$data[nli];
		$midtrm=$midtrm.' '.$nlitrm;
		
		if($pilihan=='')
			$pilihan='detil';

		switch($pilihan)
		{
			case 'detil':
				$isian1	='disabled';
				$isian2	='disabled';
				$isian3	='disabled';
				break;
			case 'edit':
				$isian1	='enable';
				$isian2	='disabled';
				$isian3	='disabled';
				break;
			//
		}		

		$query 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' "; 		// ORDER BY	t_lrcd.
		$result =mysql_query($query);

		$i=0;
		while($data = mysql_fetch_array($result))
		{
			$cell[$i][0]=$data[kde];
			$cell[$i][1]=$data[nmektr];
			$kde		=$data[kde];
			
			$query2	="	SELECT 		t_learnrcd.*
						FROM 		t_learnrcd
						WHERE 		t_learnrcd.nis	='". mysql_escape_string($kdeang)."' AND
									t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
									t_learnrcd.kde	='". mysql_escape_string($kde)."' ";
			$result2 =mysql_query($query2);
			$data2	=mysql_fetch_array($result2);
			
			$cell[$i][2]=$data2['nli'."$sms"."$nlitrm"];
			
			$i++;
		}
		
		//$str=$cell2[0][2];
		//echo"$str";
		
		echo"
		<SCRIPT TYPE='text/javascript' src='../perpustakaan/js/P1D04.js'></SCRIPT>
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:430px;padding-right:-2px;'>
				<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
					<TR><TD COLSPAN='2'><B>INPUT LEARNING RECORD</B></TD></TR>
					<TR></TR><TR></TR>
					
					
					
					<tr><td>Class</td><td>: <SELECT NAME		='kdekls'
								ID			='kdekls'
								onkeypress	='return enter(this,event)'
								class		='kdekls'>
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
						while($data2=mysql_fetch_array($result2))
						{
							if ($kdekls==$data2[kdekls])
								echo"<OPTION VALUE='$data2[kdekls]' SELECTED>$data2[kdekls]</OPTION>";
							else
								echo"<OPTION VALUE='$data2[kdekls]'>$data2[kdekls]</OPTION>";
						}
						echo"
						</SELECT></td></tr>
					
					
					
					<TR><TD WIDTH='10%'>Student No. </TD>
							<TD WIDTH='90%'>:   
								<INPUT 	NAME		='kdeang'
										ID			='kdeang'
										TYPE		='text'
										SIZE		='10'
										MAXLENGTH	='10'
										VALUE		='$kdeang'
										onkeyup		='uppercase(this.id)'
										onkeypress	='return enter(this,event)'
										onchange    =sw();
										CLASS		='kdeang'
										TITLE		='...harus diisi'
										/>";//$isian2
								//if($pilihan=='tambah')
								//{
									echo"
									<input 	type		='text'
											ID			='nmasw'
											NAME		='nmasw'
											SIZE		='50'
											MAXLENGTH	='50'
											VALUE		='$nmasw'
											readonly/>";
								//}
								
							echo"
								<INPUT TYPE='submit' 					VALUE='View' name='submit1'>
								<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04SD'>
								<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
							</TD>
						</TR>
				</TABLE>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 3%' HEIGHT='40'><CENTER>No	</CENTER></TD>
						<TD WIDTH='25%'><CENTER>Learning Objectives	    </CENTER></TD>
						<TD WIDTH='12%'><CENTER>Description</CENTER></TD>
						
					</TR>";
					
					
					
					//rlg
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'>Subject : Religion and Character Education	</TD>
					</TR>";
					echo"<TR bgcolor='dedede'>
						<TD colspan='3' HEIGHT='20'>Pupil is able to:	</TD>
					</TR>";
					
					$qRLG 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'rlg%' "; 		// ORDER BY	t_lrcd.
					$rRLG =mysql_query($qRLG);
					$j=0;
					$no=1;
					while($dRLG = mysql_fetch_array($rRLG))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv' /></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}
					//$cell[$i][0]=$data[kde];
					//$kde		=$data[kde];
					
					/*$j=0;
					$no=1;
					while($j<3)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv' /></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}	*/	
					
					
					
					//cme
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'>Subject : Pancasila and Civic Education	</TD>
					</TR>";
					echo"<TR bgcolor='dedede'>
						<TD colspan='3' HEIGHT='20'>Pupil is able to:	</TD>
					</TR>";
					$no=1;
					while($j<7)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}		
					
					
					
					//bin
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'>Subject : Bahasa Indonesia	</TD>
					</TR>";
					echo"<TR bgcolor='dedede'>
						<TD colspan='3' HEIGHT='20'>Siswa mampu:	</TD>
					</TR>";
					echo"<tr><TD WIDTH=' 3%' HEIGHT='20'><CENTER> </CENTER></TD>
						<TD colspan='2'><b>Mendengarkan dan Berbicara</b>	    </TD></tr>";
					$no=1;
					while($j<9)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}		
					echo"<tr><TD WIDTH=' 3%' HEIGHT='20'><CENTER> </CENTER></TD>
						<TD colspan='2'><b>Membaca dan Menulis</b>	    </TD></tr>";
					$no=1;
					while($j<11)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}	
					
					
					
					//mth
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'><b>Subject : Mathematics</b>	</TD>
					</TR>";
					echo"<TR bgcolor='dedede'>
						<TD colspan='3' HEIGHT='20'>Pupil is able to:	</TD>
					</TR>";
					$no=1;
					while($j<18)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}	
					
					
					
					//scn
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'><b>Subject : General Science</b>	</TD>
					</TR>";
					echo"<TR bgcolor='dedede'>
						<TD colspan='3' HEIGHT='20'>Pupil is able to:	</TD>
					</TR>";
					$no=1;
					while($j<25)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}	
					
					
					
					//scls
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'><b>Subject: Social Studies</b>	</TD>
					</TR>";
					
					$no=1;
					while($j<30)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}	
					
					
					
					//art
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'><b>Subject : Cultural Arts And Music</b>	</TD>
					</TR>";
					echo"<TR bgcolor='dedede'>
						<TD colspan='3' HEIGHT='20'>Pupil is able to:	</TD>
					</TR>";
					$no=1;
					while($j<33)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}	
					
					
					
					//pe
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'><b>Subject : Physical Education and Health</b>	</TD>
					</TR>";
					echo"<TR bgcolor='dedede'>
						<TD colspan='3' HEIGHT='20'>Pupil is able to:	</TD>
					</TR>";
					$no=1;
					while($j<38)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}	
					
					
					
					//eng
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'><b>Subject : English</b>	</TD>
					</TR>";
					echo"<TR bgcolor='dedede'>
						<TD colspan='3' HEIGHT='20'>Pupil is able to:	</TD>
					</TR>";
					echo"<TR>
						<TD colspan='3' HEIGHT='20'><b>Phonics, Spelling and Vocabulary</b>	</TD>
					</TR>";
					$no=1;
					while($j<41)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}	
					echo"<TR>
						<TD colspan='3' HEIGHT='20'><b>Grammar and Punctuation</b>	</TD>
					</TR>";
					$no=1;
					while($j<47)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}	
					echo"<TR>
						<TD colspan='3' HEIGHT='20'><b>Reading and Writing</b>	</TD>
					</TR>";
					$no=1;
					while($j<57)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}	
					echo"<TR>
						<TD colspan='3' HEIGHT='20'><b>Speaking and Listening</b>	</TD>
					</TR>";
					$no=1;
					while($j<61)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}
					
					
					
					//mnd
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'><b>Subject : Mandarin</b>	</TD>
					</TR>";
					echo"<TR bgcolor='dedede'>
						<TD colspan='3' HEIGHT='20'>Pupil is able to:	</TD>
					</TR>";
					
					$no=1;
					while($j<65)//$i
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav' /></CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>
							
						</TR>";//$isian1

						$j++;
						$no++;
					}	
				echo"	
				</TABLE>	
			</DIV>
			<BR>";

			
			
			echo"
				<INPUT TYPE='submit' 					VALUE='Simpan' name='submit2'> <INPUT TYPE='button' VALUE='New' onClick=window.location.href='guru.php?mode=R1D04SD'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04SD_Save'>
				
				<INPUT TYPE='hidden' NAME='sms'			VALUE=$sms>
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE=$nlitrm>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";//'65'<!--<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>-->
			
			
			
			echo"
		</FORM>";
		
		
		
 	}
	
	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04SD_Save()
	{
		$kdekls	=$_POST['kdekls'];
		$kdeang	=$_POST['kdeang'];
		//$nmasw	=$_POST['nmasw'];
		$sms	=$_POST['sms'];
		$nlitrm	=$_POST['nlitrm'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		
		$query	="	SELECT 		*
										FROM 		t_mstssw
										WHERE 		t_mstssw.nis='$kdeang' ";
		$result =mysql_query($query);
		$data	=mysql_fetch_array($result);
		$nmasw	=$data['nmassw'];
		
		$query2	="	SELECT 		*
										FROM 		t_mstssw
										WHERE 		t_mstssw.kdekls='$kdekls' AND 
													t_mstssw.nis='$kdeang' ";
		$result2 =mysql_query($query2);
		if(mysql_num_rows($result2)=='0')
		{
			echo"<SCRIPT LANGUAGE='JavaScript'>
						window.alert(' Kesalahan pada kelas dan siswa ');
					</SCRIPT>";
		}
		
		/*if ($_POST['submit1'])
		{
			echo"<SCRIPT LANGUAGE='JavaScript'>
							window.alert(' 1 ');
						</SCRIPT>";
		}
		
		if ($_POST['submit2'])
		{
			echo"<SCRIPT LANGUAGE='JavaScript'>
							window.alert(' 2 ');
						</SCRIPT>";
		}*/
		
		
		
		if ($_POST['submit1'])
		{
			if($kdekls!='' OR $kdeang!='')
			{
				$query =mysql_query("	SELECT 		*
										FROM 		t_mstssw
										WHERE 		t_mstssw.nis='$kdeang' ");
				
				if(mysql_num_rows($query)=='0')
				{
					echo"<SCRIPT LANGUAGE='JavaScript'>
							window.alert(' ".$kdeang." bukan kode siswa  ');
						</SCRIPT>";
				}
			}//..end if
			else
			{
				echo"<SCRIPT LANGUAGE='JavaScript'>
						window.alert(' Class & Student No. harus diisi ');
					</SCRIPT>";
			}
		}
		
		if ($_POST['submit2'])
		{
			if($kdekls!='' OR $kdeang!='')
			{
				$query =mysql_query("	SELECT 		*
										FROM 		t_mstssw
										WHERE 		t_mstssw.nis='$kdeang' ");
				
				if(mysql_num_rows($query)=='0')
				{
					echo"<SCRIPT LANGUAGE='JavaScript'>
							window.alert(' ".$kdeang." bukan kode siswa  ');
						</SCRIPT>";
				}
				else
				{
					$j=0;
					while($j<$i)
					{
						$nis 	='nis'.$j;
						$nis	=$_POST["$nis"]; 
						
						$nma 	='nma'.$j;
						$nma	=$_POST["$nma"]; 
						
						$att 	="att"."$sms"."$nlitrm".$j;
						$att	=$_POST["$att"]; 
						
						$set	="	SET		t_learnrcd.nis		='". mysql_escape_string($kdeang)."',
											t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."',
											t_learnrcd.kde		='". mysql_escape_string($nis)."',
											t_learnrcd.nmektr	='". mysql_escape_string($nma)."',
											t_learnrcd.nli"."$sms"."$nlitrm"."	='". mysql_escape_string($att)."',
											
											t_learnrcd.kdeusr	='". mysql_escape_string($kdeusr)."',
											t_learnrcd.tglrbh	='". mysql_escape_string($tglrbh)."',
											t_learnrcd.jamrbh	='". mysql_escape_string($jamrbh)."' "; 
						
						$query	="	SELECT 		t_learnrcd.*
									FROM 		t_learnrcd
									WHERE 		t_learnrcd.nis	='". mysql_escape_string($kdeang)."' AND
												t_learnrcd.kde	='". mysql_escape_string($nis)."' ";
						$result =mysql_query($query);
						$data	=mysql_fetch_array($result);
						if($data[nis]=='' AND $data[kde]=='')
						{
							$query 	="	INSERT INTO t_learnrcd ".$set; 
							$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan $kdeang"));
						}
						else
						{
							$query 	="	UPDATE 	t_learnrcd ".$set.
									"	WHERE 	t_learnrcd.nis	='". mysql_escape_string($kdeang)	."' AND
												t_learnrcd.kde		='". mysql_escape_string($nis)."' ";
							$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
						}	
						
						$j++;
					}//..end while
				}
			}//..end if
			else
			{
				echo"<SCRIPT LANGUAGE='JavaScript'>
						window.alert(' Class & Student No. harus diisi ');
					</SCRIPT>";
			}
		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04SD&kdeang=$kdeang&kdekls=$kdekls&nmasw=$nmasw&pilihan=detil\">\n";//&nis=$nis
 	}		

	// -------------------------------------------------- Save komentar --------------------------------------------------
			

	// -------------------------------------------------- Save kenaikan --------------------------------------------------
			
	
}//akhir class
?>