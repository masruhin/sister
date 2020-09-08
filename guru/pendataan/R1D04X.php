<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04X.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT PROGRESS REPORT			sd
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Xclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04X_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
			
		$query	="	SELECT 		DISTINCT t_mstplj.kdeplj,t_mstplj.nmaplj
								FROM 		t_mstpng,t_mstplj
								WHERE		t_mstpng.kdegru='$kdekry' AND
											t_mstpng.kdeplj=t_mstplj.kdeplj	AND
											t_mstplj.str=''";
		$result	=mysql_query($query) or die (mysql_error()); // menghasilkan kode dan nama pelajaran

		echo"
		<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><B>INPUT GRADING SHEET (PS)</B></TD></TR>
			<TR></TR><TR></TR>
		</TABLE>
			
		<FORM ACTION='guru.php?mode=R1D04X' METHOD='post'>
			<DIV style='overflow:auto;width:25%;height:410px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH='80%' HEIGHT='20'><CENTER>Subject	</CENTER></TD>
						<TD WIDTH='20%'><CENTER>Detail		</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD>$data[nmaplj]</TD>
							<TD><CENTER><a href='guru.php?mode=R1D04X&kdeplj=$data[kdeplj]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>
		</FORM>";
 	}
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	
	// -------------------------------------------------- Layar Utama --------------------------------------------------	
	function R1D04X()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$kdeplj	=$_GET['kdeplj'];
		//$kdetkt	=$_GET['kdetkt']; // namabahbuatan
		$pilihan=$_GET['pilihan'];
		$kolom1	=$_GET['kolom1'];
		$kolom2	=$_GET['kolom2'];
		
		//$thnajr	=$_GET['thnajr'];

		$sms	='Semester';
		$query 	=mysql_query("	SELECT 		t_setthn_sd.* 
								FROM 		t_setthn_sd
								WHERE		t_setthn_sd.set='$sms'");
		$data = mysql_fetch_array($query); // menghasilkan semester 1 atau 2
		$sms=$data[nli];
					
		$midtrm	='Mid Term';
		$query 	=mysql_query("	SELECT 		t_setthn_sd.* 
								FROM 		t_setthn_sd
								WHERE		t_setthn_sd.set='$midtrm'");
		$data = mysql_fetch_array($query); // menghasilkan mid term
		$nlitrm=$data[nli];
		$midtrm=$midtrm.' '.$nlitrm;
		
		$query="	SELECT 			t_mstplj.*
					FROM 			t_mstplj
					WHERE 			t_mstplj.kdeplj='$kdeplj'"; // menghasilkan nama pelajaran
		$result=mysql_query($query);
		$data=mysql_fetch_array($result);
		$nmaplj=$data[nmaplj];
		
		if($pilihan=='')
			$pilihan='detil';
		
		
		
		// awal buatan
		
		//if($kdetkt=='PS')
		//{
			switch($pilihan)
			{
				case 'detil':
					$y=1;
					while($y<9)
					{
						$isianhw[$y]='disabled';
						$y++;
					}
					//st
					//$y=1;
					$isianst[9]='disabled';
					
					$y=1;
					while($y<9)
					{
						$isianprj[$y]='disabled';
						$y++;
					}
					//st_
					//$y=1;
					$isianst_[18]='disabled';
					
					$y=1;
					while($y<8)
					{
						$isiantes[$y]='disabled';
						$y++;
					}
					
					//$isianmidtes[1]='disabled';
					
					
					
					//ka
					$y=1;
					while($y<9)
					{
						$isianka[$y]='disabled';
						$y++;
					}
					
					//sa
					$y=1;
					while($y<9)
					{
						$isiansa[$y]='disabled';
						$y++;
					}
					
					
					
					break;
				case 'edit':
					$y=1;
					while($y<9)
					{
						if($kolom1=='hw' and $kolom2=="$y")
							$isianhw[$y]='enable';
						else	
							$isianhw[$y]='disabled';
						
						$y++;
					}
					//st
					//$y=1;
					if($kolom1=='st' and $kolom2=='9')
						$isianst[9]='enable';
					else	
						$isianst[9]='disabled';
					
					$y=1;
					while($y<9)
					{
						if($kolom1=='prj' and $kolom2=="$y")	
							$isianprj[$y]='enable';
						else
							$isianprj[$y]='disabled';
						
						$y++;
					}
					//st_
					//$y=1;
					if($kolom1=='st_' and $kolom2=='9')	
						$isianst_[18]='enable';
					else
						$isianst_[18]='disabled';
					
					$y=1;
					while($y<8)
					{
							
						if($kolom1=='tes' and $kolom2=="$y")		
							$isiantes[$y]='enable';
						else	
							$isiantes[$y]='disabled';
						
						$y++;
					}
					
					
					
					/*if($kolom1=='midtes')		
						$isianmidtes[1]='enable';
					else	
						$isianmidtes[1]='disabled';*/
					
					
					
					//ka
					$y=1;
					while($y<9)
					{
						if($kolom1=='hw' and $kolom2=="$y")
							$isianka[$y]='enable';
						else	
							$isianka[$y]='disabled';
						
						$y++;
					}
					
					//sa
					$y=1;
					while($y<9)
					{
						if($kolom1=='prj' and $kolom2=="$y")
							$isiansa[$y]='enable';
						else	
							$isiansa[$y]='disabled';
						
						$y++;
					}
					
					
					
					break;
			}		
		//}
		
		// akhisr buatan
		
		

		$query 	="	SELECT 		t_mstssw.*
					FROM 		t_mstssw
					WHERE 		t_mstssw.kdekls	='". mysql_escape_string($kdekls)."' AND 
								
								t_mstssw.str=''
					ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; //t_mstssw.thn_ajaran	='". mysql_escape_string($thnajr)."' and
					// menghasilkan semua murid dalam suatu kelas
		$result =mysql_query($query);

		$i=0;
		while($data = mysql_fetch_array($result)) // .. d
		{
			$cell[$i][0]=$data[nis];
			$nis		=$data[nis];
			$cell[$i][1]=$data[nmassw];
			$kdeusr		=$data[kdeusr];
			$tglrbh		=$data[tglrbh];
			$jamrbh		=$data[jamrbh];
			
			
			
			// awal buatan
			
			//if($kdetkt=='PS')
			//{
				$query2	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis		='". mysql_escape_string($nis)."' AND
									t_prgrptps_sd.kdeplj	='". mysql_escape_string($kdeplj)."'  ";
				//t_prgrptps_sd.nis		='". mysql_escape_string($kdekls)."' AND
				$result2 =mysql_query($query2);
				$data2 	 =mysql_fetch_array($result2);
				$y=1;
				while($y<9)
				{
					$cell[$i][$y+1]=$data2['hw'."$sms"."$nlitrm"."$y"];
					$y++;
				}
				
				$y=1;
				$cell[$i][$y+9]=$data2['st'."$sms"."$nlitrm"."9"]; // ST hw				

				$y=1;
				while($y<9)
				{
					$cell[$i][$y+10]=$data2['prj'."$sms"."$nlitrm"."$y"];
					$y++;
				}

				$y=1;
				$cell[$i][$y+18]=$data2['st_'."$sms"."$nlitrm".'9']; // ST prj
				
				$y=1;
				while($y<8)
				{
					$cell[$i][$y+19]=$data2['tes'."$sms"."$nlitrm"."$y"];
					$y++;
				}

				//$cell[$i][$y+26]=$data2['midtes'."$sms"."$nlitrm"];
				
				
				
				$d_ka1 = $data2['ka1_'."$sms"."$nlitrm"];
				$d_ka2 = $data2['ka2_'."$sms"."$nlitrm"];
				$d_ka3 = $data2['ka3_'."$sms"."$nlitrm"];
				$d_ka4 = $data2['ka4_'."$sms"."$nlitrm"];
				$d_ka5 = $data2['ka5_'."$sms"."$nlitrm"];
				$d_ka6 = $data2['ka6_'."$sms"."$nlitrm"];
				$d_ka7 = $data2['ka7_'."$sms"."$nlitrm"];
				$d_ka8 = $data2['ka8_'."$sms"."$nlitrm"];
				
				$d_sa1 = $data2['sa1_'."$sms"."$nlitrm"];
				$d_sa2 = $data2['sa2_'."$sms"."$nlitrm"];
				$d_sa3 = $data2['sa3_'."$sms"."$nlitrm"];
				$d_sa4 = $data2['sa4_'."$sms"."$nlitrm"];
				$d_sa5 = $data2['sa5_'."$sms"."$nlitrm"];
				$d_sa6 = $data2['sa6_'."$sms"."$nlitrm"];
				$d_sa7 = $data2['sa7_'."$sms"."$nlitrm"];
				$d_sa8 = $data2['sa8_'."$sms"."$nlitrm"];
				
				
				
				$i++;
			//}
			
			// akhir buatan
			
				
				
			
			
		}

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>INPUT GRADING SHEET <span style='color: #FF0000;'>( $nmaplj )</span></B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Class</TD>
					<TD>:
						<SELECT	NAME		='kdekls'
								ID			='kdekls'
								onkeypress	='return enter(this,event)'>
						<OPTION VALUE='' SELECTED>--Select--</OPTION>";
						$query2="	SELECT 			t_mstpng.*,t_mstkls.*
									FROM 			t_mstpng,t_mstkls
									WHERE 			t_mstpng.kdegru='$kdekry'	AND
													t_mstpng.kdeplj='$kdeplj'	AND
													t_mstpng.kdekls=t_mstkls.kdekls
									ORDER BY 		t_mstkls.kdeklm,t_mstpng.kdekls"; // menghasilkan kelas berapa saja yang diajarakan oleh guru tsb.
						$result2=mysql_query($query2);
						while($data=mysql_fetch_array($result2))
						{
							if($kdekls==$data[kdekls])
								echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
						}
						echo"
						</SELECT>
						
						<INPUT TYPE='submit' 					VALUE='View'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04X'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						<INPUT TYPE='hidden' 	NAME='kdeplj'	VALUE=$kdeplj>
						
					</TD>	
              	</TR>
				<!--<tr>
					<td>Tahun Pelajaran</td><td> : 
						
						<input type='text' NAME='thnajr' ID='thnajr' value='2018-2019' readonly/>
						<INPUT TYPE='submit' 					VALUE='View'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04X'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						<INPUT TYPE='hidden' 	NAME='kdeplj'	VALUE=$kdeplj>
						
					</td>
				</tr>-->	
			</TABLE>
		</FORM>
		
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>";
				
				// awal buatan
				
				//if($kdetkt=='PS')
				//{
					echo"<TR bgcolor='dedede'>
						<TD WIDTH='2%' ROWSPAN='3' HEIGHT='30'><CENTER>No	</CENTER></TD>
						<TD WIDTH='20%' ROWSPAN='3'><CENTER>Name	    </CENTER></TD>
						<TD WIDTH='25%' COLSPAN='9' HEIGHT='20'><CENTER><b><u>Knowledge Assessments (KA)</u></b>			<br/><br/>	    	Homework, Worksheet, Quiz, Daily Review, Daily Test			<br/><br/>		</CENTER></TD>";
						
					echo"<TD WIDTH='25%' COLSPAN='9'><CENTER><b><u>Skills Assessments (SA)</u></b>							<br/><br/>	    	Project, Presentation, Pratical Review, Pratical Test		<br/><br/>		</CENTER></TD>";
					
					echo"<TD WIDTH='24%' COLSPAN='7'><CENTER><b><u>Spiritual & Social Behavior (7 CORE VALUES)</u></b>	    	</CENTER></TD>
					</TR>";
					
					
					
					//AWAL BUATAN BARU
					
					echo"
						<TR bgcolor='dedede'>
							<!--Knowledge-->
							<td align='center'>
								<input type='text' name='d_ka1' size='3' maxlength='3' value='$d_ka1' $isianka[1]/><!--1-->
							</td>
							<td align='center'>
								<input type='text' name='d_ka2' size='3' maxlength='3' value='$d_ka2' $isianka[2]/><!--2-->
							</td>
							<td align='center'>
								<input type='text' name='d_ka3' size='3' maxlength='3' value='$d_ka3' $isianka[3]/><!--3-->
							</td>
							<td align='center'>
								<input type='text' name='d_ka4' size='3' maxlength='3' value='$d_ka4' $isianka[4]/><!--4-->
							</td>
							<td align='center'>
								<input type='text' name='d_ka5' size='3' maxlength='3' value='$d_ka5' $isianka[5]/><!--5-->
							</td>
							<td align='center'>
								<input type='text' name='d_ka6' size='3' maxlength='3' value='$d_ka6' $isianka[6]/><!--6-->
							</td>
							<td align='center'>
								<input type='text' name='d_ka7' size='3' maxlength='3' value='$d_ka7' $isianka[7]/><!--7-->
							</td>
							<td align='center'>
								<input type='text' name='d_ka8' size='3' maxlength='3' value='$d_ka8' $isianka[8]/><!--8-->
							</td>
							<td>
								Mid Test / Final Test
							</td>
							
							
							
							<!--Skills-->
							<td align='center'>
								<input type='text' name='d_sa1' size='3' maxlength='3' value='$d_sa1' $isiansa[1]/><!--1-->
							</td>
							<td>
								<input type='text' name='d_sa2' size='3' maxlength='3' value='$d_sa2' $isiansa[2]/><!--2-->
							</td>
							<td align='center'>
								<input type='text' name='d_sa3' size='3' maxlength='3' value='$d_sa3' $isiansa[3]/><!--3-->
							</td>
							<td align='center'>
								<input type='text' name='d_sa4' size='3' maxlength='3' value='$d_sa4' $isiansa[4]/><!--4-->
							</td>
							<td align='center'>
								<input type='text' name='d_sa5' size='3' maxlength='3' value='$d_sa5' $isiansa[5]/><!--5-->
							</td>
							<td align='center'>
								<input type='text' name='d_sa6' size='3' maxlength='3' value='$d_sa6' $isiansa[6]/><!--6-->
							</td>
							<td align='center'>
								<input type='text' name='d_sa7' size='3' maxlength='3' value='$d_sa7' $isiansa[7]/><!--7-->
							</td>
							<td align='center'>
								<input type='text' name='d_sa8' size='3' maxlength='3' value='$d_sa8' $isiansa[8]/><!--8-->
							</td>
							<td>
								Mid Test / Final Test
							</td>
							
							
							
							<!--7 core values-->
							<td>
								Respect
							</td>
							<td>
								Responsibility
							</td>
							<td>
								Resilience
							</td>
							<td>
								Integrity
							</td>
							<td>
								Generosity
							</td>
							<td>
								Harmony
							</td>
							<td>
								Truth
							</td>
						</tr>
					";
					
					//AKHIR BUATAN BARU
					
					
					
						/*if ($pilihan=='detil'  AND $kdekls!='')
							echo"
							<TD WIDTH='4%' ROWSPAN='2'><CENTER><a href='guru.php?mode=R1D04X&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=midtes'><span style='color: #FF0000;'><b>mid</b></span></CENTER></TD>";
						else
							echo"
							<TD WIDTH='4%' ROWSPAN='2'><CENTER>mid</CENTER></TD>";*/
						
					echo"	
					
					<TR bgcolor='dedede'>";
						if ($pilihan=='detil'  AND $kdekls!='')
						{
							$y=1;
							while($y<9)
							{
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER><a href='guru.php?mode=R1D04X&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=hw&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";//&thnajr=$thnajr
								$y++;
							}	
							//st
							$y=1;
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER><a href='guru.php?mode=R1D04X&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=st&kolom2=9'><span style='color: #FF0000;'><b>ST</b></span></CENTER></TD>";//&thnajr=$thnajr
							
							$y=1;
							while($y<9)
							{
								echo"<TD WIDTH='4%'><CENTER><!--R--><a href='guru.php?mode=R1D04X&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=prj&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";//&thnajr=$thnajr
								$y++;
							}
							//st_
							$y=1;
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER><a href='guru.php?mode=R1D04X&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=st_&kolom2=9'><span style='color: #FF0000;'><b>ST</b></span></CENTER></TD>";//&thnajr=$thnajr
							
							$y=1;
							while($y<8)
							{
								echo"<TD WIDTH='4%'><CENTER><a href='guru.php?mode=R1D04X&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=tes&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";//&thnajr=$thnajr
								$y++;
							}	
						}
						else
						{
							$y=1;
							while($y<9)
							{
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER>$y	</CENTER></TD>";
								$y++;
							}
							//st
							$y=1;
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER>ST	</CENTER></TD>";
							
							$y=1;
							while($y<9)
							{
								echo"<TD WIDTH='4%'><CENTER>$y	</CENTER></TD>";
								$y++;
							}	
							//st_
							$y=1;
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER>ST	</CENTER></TD>";
							
							$y=1;
							while($y<8)
							{
								echo"<TD WIDTH='4%'><CENTER>$y	</CENTER></TD>";
								$y++;
							}	
							
						}
					echo"	
					</TR>";
					
					
					
					
					
					
					
					$j=0;
					$no=1;
					while($j<$i)
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nmassw'.$j;
						$nmav	=$cell[$j][1];

						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>$nmav </CENTER></TD>";
							$y=1;
							while($y<9)
							{
								$hw		='hw'."$sms"."$nlitrm"."$y"."$j";
								$hwv	=$cell[$j][$y+1];
								
								// awal buatan
								if ($hwv==0)
									$hwv='';
								// khir buatan
								
								echo"
								<TD><CENTER>
									<INPUT 	NAME		='$hw'
											TYPE		='text'
											SIZE		='3'
											MAXLENGTH	='3'
											VALUE 		='$hwv'
											ID			='$hw'
											ONKEYUP		='formatangka(this);'	
											ONKEYPRESS	='return enter(this,event)'
											TITLE		='(KA $y) $no. $nmav'
											$isianhw[$y]></CENTER>
								</TD>";
								$y++;
							}	
							
							
							
							$y=1;
							$st		='st'."$sms"."$nlitrm".'9'."$j";
							$stv	=$cell[$j][$y+9];
							
							// awal buatan
							if ($stv==0)
								$stv='';
							// khir buatan
							
							echo"
							<TD><CENTER>
								<INPUT 	NAME		='$st'
										TYPE		='text'
										SIZE		='3'
										MAXLENGTH	='3'
										VALUE 		='$stv'
										ID			='$st'
										ONKEYUP		='formatangka(this);'	
										ONKEYPRESS	='return enter(this,event)'
										TITLE		='(KA ST) $no. $nmav'
										$isianst[9]></CENTER>
							</TD>";
							
							
							
							$y=1;
							while($y<9)
							{
								$prj	='prj'."$sms"."$nlitrm"."$y"."$j";
								$prjv	=$cell[$j][$y+10];
								
								// awal buatan
								if ($prjv==0)
									$prjv='';
								// khir buatan
								
								echo"
								<TD><CENTER>
									<INPUT 	NAME		='$prj'
											TYPE		='text'
											SIZE		='3'
											MAXLENGTH	='3'
											VALUE 		='$prjv'
											ID			='$prj'
											ONKEYUP		='formatangka(this);'	
											ONKEYPRESS	='return enter(this,event)'
											TITLE		='(SA $y) $no. $nmav'
											$isianprj[$y]></CENTER>
								</TD>";
								$y++;
							}	
							
							
							
							$y=1;
							$st_		='st_'."$sms"."$nlitrm".'9'."$j";
							$st_v	=$cell[$j][$y+18];
							
							// awal buatan
							if ($st_v==0)
								$st_v='';
							// khir buatan
							
							echo"
							<TD><CENTER>
								<INPUT 	NAME		='$st_'
										TYPE		='text'
										SIZE		='3'
										MAXLENGTH	='3'
										VALUE 		='$st_v'
										ID			='$st_'
										ONKEYUP		='formatangka(this);'	
										ONKEYPRESS	='return enter(this,event)'
										TITLE		='(SA ST) $no. $nmav'
										$isianst_[18]></CENTER>
							</TD>";
							
							
							
							$y=1;
							while($y<8)
							{
								$tes	='tes'."$sms"."$nlitrm"."$y"."$j";
								$tesv	=$cell[$j][$y+19];
								
								// awal buatan
								if ($tesv==0)
									$tesv='';
								// khir buatan
								
								echo"
								<TD><CENTER>
									<INPUT 	NAME		='$tes'
											TYPE		='text'
											SIZE		='3'
											MAXLENGTH	='3'
											VALUE 		='$tesv'
											ID			='$tes'
											ONKEYUP		='formatangka(this);'	
											ONKEYPRESS	='return enter(this,event)'
											TITLE		='(7 CORE VALUES $y) $no. $nmav'
											$isiantes[$y]></CENTER>
								</TD>";
								$y++;
							}	

							//$midtes	='midtes'."$sms"."$nlitrm"."$j";
							//$midtesv=$cell[$j][$y+26];
							
							// awal buatan
							//if ($midtesv==0)
								//$midtesv='';
							// khir buatan
							
							/*echo"
							<TD><CENTER>
								<INPUT 	NAME		='$midtes'
										TYPE		='text'
										SIZE		='3'
										MAXLENGTH	='3'
										VALUE 		='$midtesv'
										ID			='$midtes'
										ONKEYUP		='formatangka(this);'	
										ONKEYPRESS	='return enter(this,event)'
										$isianmidtes[1]></CENTER>
								</TD>";*/
						echo"		
						</TR>";

						$j++;
						$no++;
					}
				//}
				
				// akhir buatan
							
				echo"	
				</TABLE>	
			</DIV>
			<BR>
			";
			if($pilihan=='detil' AND $kdekls!='')
			{
			  echo"
			  <INPUT TYPE='button' 	VALUE='Subject' 	onClick=window.location.href='guru.php?mode=R1D04X_Cari'> 
			  <span style='color: #FF0000;'>  To change, click on the red numbers</span>"; 
			}

			// pilihan tombol pilihan
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='SAVE' />
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04X_Save' />
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='edit' />
				<INPUT TYPE='hidden' NAME='kdeplj'		VALUE='$kdeplj' />
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE='$kdekls' />
				
				<INPUT TYPE='hidden' NAME='sms'			VALUE='$sms' />
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE='$nlitrm' />
				<INPUT TYPE='hidden' NAME='kolom1'		VALUE='$kolom1' />
				<INPUT TYPE='hidden' NAME='kolom2'		VALUE='$kolom2' />
				<INPUT TYPE='hidden' NAME='i'			VALUE='$i' />";
			}
			echo"
		</FORM>";
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04X_Save()
	{
		$kdeplj	=$_POST['kdeplj'];
		$kdekls	=$_POST['kdekls'];
		//$kdetkt	=$_POST['kdetkt']; // namabahbuatan
		$sms	=$_POST['sms'];
		$nlitrm	=$_POST['nlitrm'];
		$kolom1	=$_POST['kolom1'];
		$kolom2	=$_POST['kolom2'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		
		
		$d_ka1	=$_POST['d_ka1'];
		$d_ka2	=$_POST['d_ka2'];
		$d_ka3	=$_POST['d_ka3'];
		$d_ka4	=$_POST['d_ka4'];
		$d_ka5	=$_POST['d_ka5'];
		$d_ka6	=$_POST['d_ka6'];
		$d_ka7	=$_POST['d_ka7'];
		$d_ka8	=$_POST['d_ka8'];
		
		$d_sa1	=$_POST['d_sa1'];
		$d_sa2	=$_POST['d_sa2'];
		$d_sa3	=$_POST['d_sa3'];
		$d_sa4	=$_POST['d_sa4'];
		$d_sa5	=$_POST['d_sa5'];
		$d_sa6	=$_POST['d_sa6'];
		$d_sa7	=$_POST['d_sa7'];
		$d_sa8	=$_POST['d_sa8'];
		
		
		$query	="	SELECT 		t_mstbbt_sd.*
					FROM 		t_mstbbt_sd
					WHERE		t_mstbbt_sd.kdebbt='1HW'";
		$result	=mysql_query($query) or die('Query gagal1'); // menghasilkan berapa persen bobot 1
		$data 	=mysql_fetch_array($result);
		$bbthw=$data[bbt];
		
		$query	="	SELECT 		t_mstbbt_sd.*
					FROM 		t_mstbbt_sd
					WHERE		t_mstbbt_sd.kdebbt='2PRJ'";
		$result	=mysql_query($query) or die('Query gagal1'); // menghasilkan berapa persen bobot 2
		$data 	=mysql_fetch_array($result);
		$bbtprj=$data[bbt];

		$query	="	SELECT 		t_mstbbt_sd.*
					FROM 		t_mstbbt_sd
					WHERE		t_mstbbt_sd.kdebbt='3TES'";
		$result	=mysql_query($query) or die('Query gagal1'); // menghasilkan berapa persen bobot 3
		$data 	=mysql_fetch_array($result);
		$bbttes=$data[bbt];

		$query	="	SELECT 		t_mstbbt_sd.*
					FROM 		t_mstbbt_sd
					WHERE		t_mstbbt_sd.kdebbt='4MID'";
		$result	=mysql_query($query) or die('Query gagal1'); // menghasilkan berapa persen bobot 4
		$data 	=mysql_fetch_array($result);
		$bbtmidtes=$data[bbt];
		
		$query	="	SELECT 		t_mstbbt_sd.*
					FROM 		t_mstbbt_sd
					WHERE		t_mstbbt_sd.kdebbt='5ST'";
		$result	=mysql_query($query) or die('Query gagal1'); // menghasilkan berapa persen bobot 5
		$data 	=mysql_fetch_array($result);
		$bbtst=$data[bbt];
		
		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
			if($kolom1=='midtes') // OR $kolom1=='st' OR $kolom1=='st_'
			{
				$nli 	="$kolom1"."$sms"."$nlitrm"."$j";
				$nliw 	="$kolom1"."$sms"."$nlitrm";
			}
			else
			{
				$nli 	="$kolom1"."$sms"."$nlitrm"."$kolom2"."$j";
				$nliw 	="$kolom1"."$sms"."$nlitrm"."$kolom2";
			}	
			$nli	=$_POST["$nli"]; 
			//$nli	= number_format( $nli ,0,',','.');
			
			
			
			//AWAL BUATAN BARU
			
			if ( $nli <= 39 )
			{
				$nli = 40;
				
				/*echo"
					<script>
						alert('Perhatian! Tolong Peng-input-an nilai tidak lebih kecil dari 40 , Terima kasih!');
					</script>
				";*/
			}
			/*else
			{
				
			}*/
			//return false
			//<meta http-equiv='refresh' content=\'0;url=guru.php?mode=R1D04X&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=detil\'>
			//setTimeout("window.history.go(-1)",2000);
			
			//AKHIR BUATAN BARU
			
			

			$set	="	SET		t_prgrptps_sd.nis		='". mysql_escape_string($nis)."',
								t_prgrptps_sd.kdeplj	='". mysql_escape_string($kdeplj)."',
								t_prgrptps_sd."."$nliw"."	='". mysql_escape_string($nli)."',
								t_prgrptps_sd.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_prgrptps_sd.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_prgrptps_sd.jamrbh	='". mysql_escape_string($jamrbh)."' ";

			$query	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis	='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sd.kdeplj	='". mysql_escape_string($kdeplj)."'  ";
									// menghasilkan nis dan matpel nya
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_prgrptps_sd ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan")); // input nilai
			}
			else
			{
				$query 	="	UPDATE 	t_prgrptps_sd ".$set.
						"	WHERE 	t_prgrptps_sd.nis	='". mysql_escape_string($nis)	."'	AND
									t_prgrptps_sd.kdeplj	='". mysql_escape_string($kdeplj)	."'  ";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah")); // update nilai
			}	
			$j++;
		}
		
		//-------------------------- simpan hasil akhir
		$bghw	=1;
		$bgprj	=1;
		$bgtes	=1;
		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
	
			$query2 ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis	='$nis'		AND
									t_prgrptps_sd.kdeplj='$kdeplj'  "; 
									// menghasilkan nis dan matpel nya
			$result2=mysql_query($query2) or die('Query gagal');
			$data2	=mysql_fetch_array($result2);
			$y	=1;
			$hw	=0;
			$prj=0;
			$tes=0;
			while($y<9)
			{
				if($data2['hw'."$sms"."$nlitrm"."$y"]>0)
					$hw++;
				
				$y++;	
			}
			$y	=1;
			while($y<9)
			{
				if($data2['prj'."$sms"."$nlitrm"."$y"]>0)
					$prj++;
				
				$y++;	
			}
			$y	=1;
			while($y<8)
			{
				if($data2['tes'."$sms"."$nlitrm"."$y"]>0)
					$tes++;	
				
				$y++;	
			}
			if($hw>$bghw)
				$bghw=$hw;
			if($prj>$bgprj)
				$bgprj=$prj;
			if($tes>$bgtes)
				$bgtes=$tes;
	
			$j++;
		}

		$j=0;
		$ttlakh=0;
		$jml=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
			$ttlhw=0;
			$ttlprj=0;
			$ttltes=0;

			$query2 ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis	='$nis'		AND
									t_prgrptps_sd.kdeplj='$kdeplj'  "; 
									// menghasilkan nis dan matpel nya
			$result2=mysql_query($query2) or die('Query gagal');
			$data2	=mysql_fetch_array($result2);
	
			$y=1;
			while($y<9)
			{
				$hw=$data2['hw'."$sms"."$nlitrm"."$y"];
				$ttlhw=$ttlhw+$hw;
				$y++;
			}
			$y=1;
			while($y<9)
			{
				$prj=$data2['prj'."$sms"."$nlitrm"."$y"];
				$ttlprj=$ttlprj+$prj;
				$y++;
			}
			$y=1;
			while($y<8)
			{
				$tes=$data2['tes'."$sms"."$nlitrm"."$y"];
				$ttltes=$ttltes+$tes;
				$y++;
			}
			$y=9;
			$st=$data2['st'."$sms"."$nlitrm"."$y"];
			$y=9;
			$st_=$data2['st_'."$sms"."$nlitrm"."$y"];
			
			$avghw	=$ttlhw/$bghw;
			//$avghw	= number_format($avghw,2,',','.');
			$bavghw	=($avghw*$bbthw)/100;
			$avgprj	=$ttlprj/$bgprj;
			//$avgprj	= number_format($avgprj,2,',','.');
			$bavgprj=($avgprj*$bbtprj)/100;
			$avgtes	=$ttltes/$bgtes;
			$bavgtes=($avgtes*$bbttes)/100;
			
			$bst=($st*$bbtst)/100;
			$bst_=($st_*$bbtst)/100;
			
			$nfgk = $bavghw + $bst;
			//$nfgk 	=number_format($nfgk);		//fgk
			$nfgs = $bavgprj + $bst_;
			//$nfgs 	=number_format($nfgs);		//fgs

			$ttl		=$bavghw+$bavgprj+$bavgtes;
			$ttl70		=$ttl*((100-$bbtmidtes)/100);
			$midtes		=$data2['midtes'."$sms"."$nlitrm"];
			$midtes30	=($midtes*$bbtmidtes)/100;
			$nliakh		=$ttl70+$midtes30;
			$fgk		='fgk'."$sms"."$nlitrm";
			$fgs		='fgs'."$sms"."$nlitrm";
			$akh		='akh'."$sms"."$nlitrm";
			$aff		='aff'."$sms"."$nlitrm";
			$ttlakh		=$ttlakh+$nliakh;
			
			
			
			//AWAL BUATAN BARU
			
			$kaw1		='ka1_'."$sms"."$nlitrm";
			$kaw2		='ka2_'."$sms"."$nlitrm";
			$kaw3		='ka3_'."$sms"."$nlitrm";
			$kaw4		='ka4_'."$sms"."$nlitrm";
			$kaw5		='ka5_'."$sms"."$nlitrm";
			$kaw6		='ka6_'."$sms"."$nlitrm";
			$kaw7		='ka7_'."$sms"."$nlitrm";
			$kaw8		='ka8_'."$sms"."$nlitrm";
			
			$saw1		='sa1_'."$sms"."$nlitrm";
			$saw2		='sa2_'."$sms"."$nlitrm";
			$saw3		='sa3_'."$sms"."$nlitrm";
			$saw4		='sa4_'."$sms"."$nlitrm";
			$saw5		='sa5_'."$sms"."$nlitrm";
			$saw6		='sa6_'."$sms"."$nlitrm";
			$saw7		='sa7_'."$sms"."$nlitrm";
			$saw8		='sa8_'."$sms"."$nlitrm";
			
			
			
			//AKHIR BUATAN BARU



			$set	="	SET		t_prgrptps_sd."."$kaw1"."	='". mysql_escape_string($d_ka1)."',
								t_prgrptps_sd."."$kaw2"."	='". mysql_escape_string($d_ka2)."',
								t_prgrptps_sd."."$kaw3"."	='". mysql_escape_string($d_ka3)."',
								t_prgrptps_sd."."$kaw4"."	='". mysql_escape_string($d_ka4)."',
								t_prgrptps_sd."."$kaw5"."	='". mysql_escape_string($d_ka5)."',
								t_prgrptps_sd."."$kaw6"."	='". mysql_escape_string($d_ka6)."',
								t_prgrptps_sd."."$kaw7"."	='". mysql_escape_string($d_ka7)."',
								t_prgrptps_sd."."$kaw8"."	='". mysql_escape_string($d_ka8)."',
								
								t_prgrptps_sd."."$saw1"."	='". mysql_escape_string($d_sa1)."',
								t_prgrptps_sd."."$saw2"."	='". mysql_escape_string($d_sa2)."',
								t_prgrptps_sd."."$saw3"."	='". mysql_escape_string($d_sa3)."',
								t_prgrptps_sd."."$saw4"."	='". mysql_escape_string($d_sa4)."',
								t_prgrptps_sd."."$saw5"."	='". mysql_escape_string($d_sa5)."',
								t_prgrptps_sd."."$saw6"."	='". mysql_escape_string($d_sa6)."',
								t_prgrptps_sd."."$saw7"."	='". mysql_escape_string($d_sa7)."',
								t_prgrptps_sd."."$saw8"."	='". mysql_escape_string($d_sa8)."',
								
								
								
								t_prgrptps_sd."."$fgk"."	='". mysql_escape_string($nfgk)."',
								t_prgrptps_sd."."$fgs"."	='". mysql_escape_string($nfgs)."',
								t_prgrptps_sd."."$akh"."	='". mysql_escape_string($avgtes)."',
								t_prgrptps_sd."."$aff"."	='". mysql_escape_string($avgtes)."' "; //$nliakh
			$query 	="	UPDATE 	t_prgrptps_sd ".$set.
					"	WHERE 	t_prgrptps_sd.nis	='". mysql_escape_string($nis)	."'	AND
								t_prgrptps_sd.kdeplj	='". mysql_escape_string($kdeplj)	."'  ";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah")); // UPDATE nilai field akh (akhir)
			
			if($nliakh>0)
				$jml++;
			
			$j++;
		}	

		
		
		//..belum dipakai
		//-------------------simpan rata2
		$rt		='rt'."$sms"."$nlitrm";
		if($ttlakh>0)
			$nlirt	=number_format($ttlakh/$jml,0,',','.');
		else
			$nlirt	=number_format(0,0,',','.');

		$set	="	SET		t_rtpsrpt.kdekls		='". mysql_escape_string($kdekls)."',
							t_rtpsrpt.kdeplj	='". mysql_escape_string($kdeplj)."',
							t_rtpsrpt."."$rt"."	='". mysql_escape_string($nlirt)."'"; 

		$query	="	SELECT 		t_rtpsrpt.*
					FROM 		t_rtpsrpt
					WHERE 		t_rtpsrpt.kdekls	='". mysql_escape_string($kdekls)."'	AND
								t_rtpsrpt.kdeplj	='". mysql_escape_string($kdeplj)."'"; // menghasilkan kode kelas dan kode matpel
		$result =mysql_query($query);
		$data	=mysql_fetch_array($result);
		if($data[kdekls]=='')
		{
		  	$query 	="	INSERT INTO t_rtpsrpt ".$set; 
			$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan")); // simpan rata" per kelas per matpel
		}
		else
		{
			$query 	="	UPDATE 	t_rtpsrpt ".$set.
					"	WHERE 	t_rtpsrpt.kdekls	='". mysql_escape_string($kdekls)	."'	AND
								t_rtpsrpt.kdeplj	='". mysql_escape_string($kdeplj)	."'"; // update rata" per kelas per matpel
			$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
		}	
		//..belum dipakai
		
		
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04X&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=detil\">\n";
 	}		
}//akhir class
?>