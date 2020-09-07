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
		
		//$thn_ajr	=$_GET['thn_ajr'];

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
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."'
					ORDER BY	t_lrcd.nourut
					"; 		
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
									t_learnrcd.kde	='". mysql_escape_string($kde)."' 		"; //  AND t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."'
			$result2 =mysql_query($query2);
			$data2	=mysql_fetch_array($result2);
			
			$cell[$i][2]=$data2['nli'."$sms"."$nlitrm"];
			$cell[$i][3]=$data2['nmektr'."$sms"."$nlitrm"];
			//$cell[$i][3]=$data2['nmektr'];
			
			$i++;
		}
		
		//$str=$cell2[0][2];
		//echo"$str";
		
		echo"
		<SCRIPT TYPE='text/javascript' src='../perpustakaan/js/P1D04.js'></SCRIPT>
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:430px;padding-right:-2px;'>
				<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
					<TR><TD COLSPAN='2'><B>INPUT LEARNING RECORD (PS) LO</B></TD></TR>
					<TR></TR><TR></TR>
					
					
					
					<tr>
						<td>Class</td><td>: <SELECT NAME		='kdekls'
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
						</SELECT>
						
						<INPUT TYPE='submit' 					VALUE='View' name='submit1'>
								<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04SD'>
								<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						
						</td>
					</tr>
					<!--	
					<tr>
						<td>Tahun Pelajaran</td><td> : 
							
							<input type='text' NAME='thn_ajr' ID='thn_ajr' value='2018-2019' readonly/>
							<INPUT TYPE='submit' 					VALUE='View' name='submit1'>
								<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04SD'>
								<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						</td>
					</tr>
					-->
					
					
					<TR><TD WIDTH='10%'><!--Student No. --></TD>
							<TD WIDTH='90%'><!--:   
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
										/>-->";//$isian2
								//if($pilihan=='tambah')
								//{
									echo"
									<!--<input 	type		='text'
											ID			='nmasw'
											NAME		='nmasw'
											SIZE		='50'
											MAXLENGTH	='50'
											VALUE		='$nmasw'
											readonly/>-->";
								//}
								
							echo"
								
							</TD>
						</TR>
				</TABLE>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 3%' HEIGHT='40'><CENTER>No	</CENTER></TD>
						<TD WIDTH='25%'><CENTER>Learning Objectives	    </CENTER></TD>
						<!--<TD WIDTH='12%'><CENTER>Description</CENTER></TD>-->
						
					</TR>";
					
					
					
					//rlg
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'>Subject : Religion and Character Education	</TD>
					</TR>";
					echo"<TR bgcolor='dedede'>
						<TD colspan='3' HEIGHT='20'>Pupil is able to:	</TD>
					</TR>";
					$rRLG ='';
					$qRLG 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'rlg%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					$rRLG =mysql_query($qRLG);
					if(mysql_num_rows($rRLG)=='0')
					{
						$qRLG 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'rlg%' "; 		// ORDER BY	t_lrcd.
						$rRLG =mysql_query($qRLG);
					}
					$j=0;
					$no=1;
					while($dRLG = mysql_fetch_array($rRLG))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dRLG[nmektr];
						$cell[$j][4]=$dRLG['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv'/>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='Religion and Character Education' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv' /></CENTER>
							</TD>-->
							
						</TR>";//$isian1

						$j++;
						$no++;
					}
					
					
					
					//cme
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'>Subject : Pancasila and Civic Education	</TD>
					</TR>";
					echo"<TR bgcolor='dedede'>
						<TD colspan='3' HEIGHT='20'>Pupil is able to:	</TD>
					</TR>";
					$rCME ='';
					$qCME 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'cme%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					$rCME =mysql_query($qCME);
					if(mysql_num_rows($rCME)=='0')
					{
						$qCME 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'cme%' "; 		// ORDER BY	t_lrcd.
						$rCME =mysql_query($qCME);
					}
					$no=1;
					while($dCME = mysql_fetch_array($rCME))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dCME[nmektr];
						$cell[$j][4]=$dCME['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv'/>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='Pancasila and Civic Education' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
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
					$rBIN ='';
					$qBIN 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'binA%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					$rBIN =mysql_query($qBIN);
					if(mysql_num_rows($rBIN)=='0')
					{
						$qBIN 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'binA%' "; 		// ORDER BY	t_lrcd.
						$rBIN =mysql_query($qBIN);
					}
					$no=1;
					while($dBIN = mysql_fetch_array($rBIN))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dBIN[nmektr];
						$cell[$j][4]=$dBIN['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv'/>		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='Bahasa Indonesia -> Mendengarkan dan Berbicara'		/></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
						</TR>";//$isian1

						$j++;
						$no++;
					}
					echo"<tr><TD WIDTH=' 3%' HEIGHT='20'><CENTER> </CENTER></TD>
						<TD colspan='2'><b>Membaca dan Menulis</b>	    </TD></tr>";
					$rBIN2 ='';
					$qBIN2 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'binB%' 
								ORDER BY	t_learnrcd.kdekls, t_learnrcd.kde			
											";
					$rBIN2 =mysql_query($qBIN2);
					if(mysql_num_rows($rBIN2)=='0')
					{
						$qBIN2 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'binB%' 
								ORDER BY	t_lrcd.nourut			
											"; 		
						$rBIN2 =mysql_query($qBIN2);
					}
					$no=1;
					while($dBIN2 = mysql_fetch_array($rBIN2))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dBIN2[nmektr];
						$cell[$j][4]=$dBIN2['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv' />		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='Bahasa Indonesia -> Membaca dan Menulis' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
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
					$rMTH ='';
					$qMTH 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'mth%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					$rMTH =mysql_query($qMTH);
					if(mysql_num_rows($rMTH)=='0')
					{
						$qMTH 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'mth%' "; 		// ORDER BY	t_lrcd.
						$rMTH =mysql_query($qMTH);
					}
					$no=1;
					while($dMTH = mysql_fetch_array($rMTH))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dMTH[nmektr];
						$cell[$j][4]=$dMTH['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv' />		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='Mathematics' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
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
					$rSCN ='';
					$qSCN 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'scn%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					$rSCN =mysql_query($qSCN);
					if(mysql_num_rows($rSCN)=='0')
					{
						$qSCN 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'scn%' "; 		// ORDER BY	t_lrcd.
						$rSCN =mysql_query($qSCN);
					}
					$no=1;
					while($dSCN = mysql_fetch_array($rSCN))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dSCN[nmektr];
						$cell[$j][4]=$dSCN['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv' />		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='General Science' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
						</TR>";//$isian1

						$j++;
						$no++;
					}
					
					
					
					//scls
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'><b>Subject: Social Studies</b>	</TD>
					</TR>";
					$rSCLS ='';
					$qSCLS 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'scls%' ";
					$rSCLS =mysql_query($qSCLS);
					if(mysql_num_rows($rSCLS)=='0')
					{
						$qSCLS 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'scls%' "; 		// ORDER BY	t_lrcd.
						$rSCLS =mysql_query($qSCLS);
					}
					$no=1;
					while($dSCLS = mysql_fetch_array($rSCLS))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dSCLS[nmektr];
						$cell[$j][4]=$dSCLS['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv' />		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='Social Studies' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
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
					$rART='';
					$qART 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'art%' 
								ORDER BY	t_learnrcd.kdekls, t_learnrcd.kde			
											"; 
					$rART =mysql_query($qART);
					if(mysql_num_rows($rART)=='0')
					{
						$qART 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'art%' 
								ORDER BY	t_lrcd.nourut			
											"; 		 
						$rART =mysql_query($qART);
					}
					$no=1;
					while($dART = mysql_fetch_array($rART))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dART[nmektr];
						$cell[$j][4]=$dART['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv' />		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='Cultural Arts And Music' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
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
					$rPE='';
					$qPE 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'pe%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					$rPE =mysql_query($qPE);
					if(mysql_num_rows($rPE)=='0')
					{
						$qPE 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'pe%' "; 		// ORDER BY	t_lrcd.
						$rPE =mysql_query($qPE);
					}
					$no=1;
					while($dPE = mysql_fetch_array($rPE))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dPE[nmektr];
						$cell[$j][4]=$dPE['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv' />		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='Physical Education and Health' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
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
					$rENG1='';
					$qENG1 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'engA%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					$rENG1 =mysql_query($qENG1);
					if(mysql_num_rows($rENG1)=='0')
					{
						$qENG1 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'engA%' "; 		// ORDER BY	t_lrcd.
						$rENG1 =mysql_query($qENG1);
					}
					$no=1;
					while($dENG1 = mysql_fetch_array($rENG1))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dENG1[nmektr];
						$cell[$j][4]=$dENG1['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv' />		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='English -> Phonics, Spelling and Vocabulary' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
						</TR>";//$isian1

						$j++;
						$no++;
					}
					echo"<TR>
						<TD colspan='3' HEIGHT='20'><b>Grammar and Punctuation</b>	</TD>
					</TR>";
					$rENG2='';
					$qENG2 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											
											t_learnrcd.kde LIKE 'engB%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					$rENG2 =mysql_query($qENG2);
					if(mysql_num_rows($rENG2)=='0')
					{
						$qENG2 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'engB%' "; 		// ORDER BY	t_lrcd.
						$rENG2 =mysql_query($qENG2);
					}
					$no=1;
					while($dENG2 = mysql_fetch_array($rENG2))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dENG2[nmektr];
						$cell[$j][4]=$dENG2['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv' />		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='English -> Grammar and Punctuation' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
						</TR>";//$isian1

						$j++;
						$no++;
					}
					echo"<TR>
						<TD colspan='3' HEIGHT='20'><b>Reading and Writing</b>	</TD>
					</TR>";
					$rENG3='';
					$qENG3 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'engC%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					$rENG3 =mysql_query($qENG3);
					if(mysql_num_rows($rENG3)=='0')
					{
						$qENG3 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'engC%' "; 		// ORDER BY	t_lrcd.
						$rENG3 =mysql_query($qENG3);
					}
					$no=1;
					while($dENG3 = mysql_fetch_array($rENG3))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dENG3[nmektr];
						$cell[$j][4]=$dENG3['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv' />		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='English -> Reading and Writing' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
						</TR>";//$isian1

						$j++;
						$no++;
					}
					echo"<TR>
						<TD colspan='3' HEIGHT='20'><b>Speaking and Listening</b>	</TD>
					</TR>";
					$rENG4='';
					$qENG4 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'engD%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					$rENG4 =mysql_query($qENG4);
					if(mysql_num_rows($rENG4)=='0')
					{
						$qENG4 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'engD%' "; 		// ORDER BY	t_lrcd.
						$rENG4 =mysql_query($qENG4);
					}
					$no=1;
					while($dENG4 = mysql_fetch_array($rENG4))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dENG4[nmektr];
						$cell[$j][4]=$dENG4['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv' />		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='English -> Speaking and Listening' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
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
					$rMND='';
					$qMND 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
											
											t_learnrcd.kde LIKE 'mnd%' 
								ORDER BY	t_learnrcd.kdekls, t_learnrcd.kde
											"; 
					$rMND =mysql_query($qMND);
					if(mysql_num_rows($rMND)=='0')
					{
						$qMND 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'mnd%' 
								ORDER BY	t_lrcd.nourut
											"; 		
						$rMND =mysql_query($qMND);
					}
					$no=1;
					while($dMND = mysql_fetch_array($rMND))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dMND[nmektr];
						$cell[$j][4]=$dMND['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv' />		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='Mandarin' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
						</TR>";//$isian1

						$j++;
						$no++;
					}
					
					
					
					//com
					echo"<TR bgcolor='yellow'>
						<TD colspan='3' HEIGHT='20'><b>Subject : Computer Education</b>	</TD>
					</TR>";
					echo"<TR bgcolor='dedede'>
						<TD colspan='3' HEIGHT='20'>Pupil is able to:	</TD>
					</TR>";
					$rCOM='';
					$qCOM 	="	SELECT 		t_learnrcd.*
								FROM 		t_learnrcd 
								WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											
											t_learnrcd.kde LIKE 'com%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					$rCOM =mysql_query($qCOM);
					if(mysql_num_rows($rCOM)=='0')
					{
						$qCOM 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE 'com%' "; 		// ORDER BY	t_lrcd.
						$rCOM =mysql_query($qCOM);
					}
					$no=1;
					while($dCOM = mysql_fetch_array($rCOM))
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nma'.$j;
						//$cell[$j][4]=$dCOM[nmektr];
						$cell[$j][4]=$dCOM['nmektr'."$sms"."$nlitrm"];
						$nmav	=$cell[$j][4];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE='$nisv' />		
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nma'
										TYPE		='text'
										SIZE		='200'
										MAXLENGTH	='200'
										VALUE 		='$nmav'
										TITLE		='Computer Education' /></CENTER></TD>
							<!--<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										></CENTER>
							</TD>-->
							
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
				
				<INPUT TYPE='hidden' NAME='sms'			VALUE='$sms'/>
				
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE='$nlitrm'/>
				<INPUT TYPE='hidden' NAME='i'			VALUE='$i'>";//'65'<!--<INPUT TYPE='hidden' NAME='thn_ajar'			VALUE='$thn_ajar'>--><!--<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>-->
			
			
			
			echo"
		</FORM>";
		
		
		
 	}
	
	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04SD_Save()
	{
		$kdekls	=$_POST['kdekls'];
		//$kdeang	=$_POST['kdeang'];//$nmasw	=$_POST['nmasw'];
		
		$sms	=$_POST['sms'];
		$nlitrm	=$_POST['nlitrm'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		
		//$thn_ajr	=$_POST['thn_ajr'];
		
		/*$query	="	SELECT 		*
										FROM 		t_mstssw
										WHERE 		t_mstssw.nis='$kdeang' ";
		$result =mysql_query($query);
		$data	=mysql_fetch_array($result);
		$nmasw	=$data['nmassw'];*/
		
		/*$query2	="	SELECT 		*
										FROM 		t_mstssw
										WHERE 		t_mstssw.kdekls='$kdekls' AND 
													t_mstssw.nis='$kdeang' ";
		$result2 =mysql_query($query2);
		if(mysql_num_rows($result2)=='0')
		{
			echo"<SCRIPT LANGUAGE='JavaScript'>
						window.alert(' Kesalahan pada kelas dan siswa ');
					</SCRIPT>";
		}*/
		
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
			if($kdekls!='')// OR $kdeang!=''
			{
				/*$query =mysql_query("	SELECT 		*
										FROM 		t_mstssw
										WHERE 		t_mstssw.nis='$kdeang' ");
				
				if(mysql_num_rows($query)=='0')
				{
					echo"<SCRIPT LANGUAGE='JavaScript'>
							window.alert(' ".$kdeang." bukan kode siswa  ');
						</SCRIPT>";
				}*/
			}//..end if
			else
			{
				echo"<SCRIPT LANGUAGE='JavaScript'>
						window.alert(' Class harus diisi ');//& Student No. 
					</SCRIPT>";
			}
		}
		
		if ($_POST['submit2'])
		{
			if($kdekls!='' OR $kdeang!='')
			{
				/*$query =mysql_query("	SELECT 		*
										FROM 		t_mstssw
										WHERE 		t_mstssw.nis='$kdeang' ");
				if(mysql_num_rows($query)=='0')
				{
					echo"<SCRIPT LANGUAGE='JavaScript'>
							window.alert(' ".$kdeang." bukan kode siswa  ');
						</SCRIPT>";
				}
				else
				{*/
					$j=0;
					while($j<$i)
					{
						$nis 	='nis'.$j;
						$nis	=$_POST["$nis"]; 
						
						$nma 	='nma'.$j;
						$nma	=$_POST["$nma"]; 
						
						$att 	="att"."$sms"."$nlitrm".$j;
						$att	=0;//$_POST["$att"]; 
						
						//t_learnrcd.nis		='". mysql_escape_string($kdeang)."',
						
						$set	="	SET		
											t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."',
											t_learnrcd.kde		='". mysql_escape_string($nis)."',
											t_learnrcd.nmektr	='". mysql_escape_string($nma)."',
											
											t_learnrcd.kdeusr	='". mysql_escape_string($kdeusr)."',
											t_learnrcd.tglrbh	='". mysql_escape_string($tglrbh)."',
											t_learnrcd.jamrbh	='". mysql_escape_string($jamrbh)."',

											t_learnrcd.nmektr"."$sms"."$nlitrm"."	='". mysql_escape_string($nma)."'
											
											"; 
											
											
											
											/*		GAK KEPAKE
											t_learnrcd.nli"."$sms"."$nlitrm"."	='". mysql_escape_string($att)."',
											*/
						
						
						
						// t_learnrcd.nis	='". mysql_escape_string($kdeang)."' AND
						
						$query	="	SELECT 		t_learnrcd.*
									FROM 		t_learnrcd
									WHERE 		
												t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
												t_learnrcd.kde	='". mysql_escape_string($nis)."' 
												";
												
						$result =mysql_query($query);
						$data	=mysql_fetch_array($result);
						if($data[nis]=='' AND $data[kdekls]=='' AND $data[kde]=='')
						{
							$query 	="	INSERT INTO t_learnrcd ".$set; 
							$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan $kdeang"));
						}
						else
						{
							$query 	="	UPDATE 	t_learnrcd ".$set.
									"	WHERE 	
												t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND 
												t_learnrcd.kde		='". mysql_escape_string($nis)."' 
												";
												//t_learnrcd.nis	='". mysql_escape_string($kdeang)	."' AND
							$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));
												
						}	
						
						$j++;
					}//..end while
				//}//END ELSE
			}//..end if
			else
			{
				echo"<SCRIPT LANGUAGE='JavaScript'>
						window.alert(' Class harus diisi ');
					</SCRIPT>";//& Student No. 
			}
		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04SD&kdeang=$kdeang&kdekls=$kdekls&nmasw=$nmasw&pilihan=detil\">\n";//&nis=$nis	//&thn_ajr=$thn_ajr
 	}		

	// -------------------------------------------------- Save komentar --------------------------------------------------
			

	// -------------------------------------------------- Save kenaikan --------------------------------------------------
			
	
}//akhir class
?>