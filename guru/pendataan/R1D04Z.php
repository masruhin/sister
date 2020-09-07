<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04Z.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT PROGRESS REPORT			sma 11-12
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Zclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04Z_Cari()
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
			<TR><TD><B>INPUT GRADING SHEET (SHS) 12 <!--IPA--></B></TD></TR>
			<TR></TR><TR></TR>
		</TABLE>
			
		<FORM ACTION='guru.php?mode=R1D04Z' METHOD='post'>
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
							<TD><CENTER><a href='guru.php?mode=R1D04Z&kdeplj=$data[kdeplj]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>
		</FORM>";
 	}
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	
	// -------------------------------------------------- Layar Utama --------------------------------------------------	
	function R1D04Z()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$kdeplj	=$_GET['kdeplj'];
		//$kdetkt	=$_GET['kdetkt']; // namabahbuatan
		$pilihan=$_GET['pilihan'];
		$kolom1	=$_GET['kolom1'];
		$kolom2	=$_GET['kolom2'];
		
		$thn_ajr	=$_GET['thn_ajr'];

		$sms	='Semester';
		$query 	=mysql_query("	SELECT 		t_setthn_sma.* 
								FROM 		t_setthn_sma
								WHERE		t_setthn_sma.set='$sms'");
		$data = mysql_fetch_array($query); // menghasilkan semester 1 atau 2
		$sms=$data[nli];
					
		$midtrm	='Mid Term';
		$query 	=mysql_query("	SELECT 		t_setthn_sma.* 
								FROM 		t_setthn_sma
								WHERE		t_setthn_sma.set='$midtrm'");
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
					while($y<8)
					{
						$isianhw[$y]='disabled';
						$y++;
					}
					$y=1;
					while($y<7)
					{
						$isianprj[$y]='disabled';
						$y++;
					}
					//st
					//$y=1;
					$isianst[1]='disabled';
					$y=1;
					while($y<8)
					{
						$isiantes[$y]='disabled';
						$y++;
					}
					$y=1;
					while($y<6)
					{
						$isianae[$y]='disabled';
						$y++;
					}
					//st_
					//$y=1;
					$isianst_[1]='disabled';
					$y=1;
					while($y<6)
					{
						$isianaf[$y]='disabled';
						$y++;
					}
					//$isianmidtes[1]='disabled';
					
					break;
				case 'edit':
					$y=1;
					while($y<8)
					{
						if($kolom1=='hw' and $kolom2=="$y")
							$isianhw[$y]='enable';
						else	
							$isianhw[$y]='disabled';
						
						$y++;
					}
					$y=1;
					while($y<7)
					{
						if($kolom1=='prj' and $kolom2=="$y")	
							$isianprj[$y]='enable';
						else
							$isianprj[$y]='disabled';
						
						$y++;
					}
					//st
					//$y=1;
					if($kolom1=='st')
						$isianst[1]='enable';
					else	
						$isianst[1]='disabled';
					
					$y=1;
					while($y<8)
					{
							
						if($kolom1=='tes' and $kolom2=="$y")		
							$isiantes[$y]='enable';
						else	
							$isiantes[$y]='disabled';
						
						$y++;
					}
					$y=1;
					while($y<6)
					{
						if($kolom1=='ae' and $kolom2=="$y")	
							$isianae[$y]='enable';
						else
							$isianae[$y]='disabled';
						
						$y++;
					}
					//st_
					//$y=1;
					if($kolom1=='st_')	
						$isianst_[1]='enable';
					else
						$isianst_[1]='disabled';
					
					$y=1;
					while($y<6)
					{
						if($kolom1=='af' and $kolom2=="$y")	
							$isianaf[$y]='enable';
						else
							$isianaf[$y]='disabled';
						
						$y++;
					}
					
					/*if($kolom1=='midtes')		
						$isianmidtes[1]='enable';
					else	
						$isianmidtes[1]='disabled';*/
					
					break;
			}		
		//}
		
		// akhisr buatan
		
		

		$query 	="	SELECT 		t_mstssw.*
					FROM 		t_mstssw
					WHERE 		t_mstssw.kdekls	='". mysql_escape_string($kdekls)."'	AND
								t_mstssw.thn_ajaran	='". mysql_escape_string($thn_ajr)."'	AND
								t_mstssw.str=''
					ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; // menghasilkan semua murid dalam suatu kelas
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
				$query2	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis		='". mysql_escape_string($nis)."' AND
									t_prgrptps_sma.thn_ajaran		='". mysql_escape_string($thn_ajr)."' AND
									t_prgrptps_sma.kdeplj	='". mysql_escape_string($kdeplj)."'";
				//t_prgrptps_sma.nis		='". mysql_escape_string($kdekls)."' AND
				$result2 =mysql_query($query2);
				$data2 	 =mysql_fetch_array($result2);
				$y=1;
				while($y<8)
				{
					$cell[$i][$y+1]=$data2['hw'."$sms"."$nlitrm"."$y"];
					$y++;
				}
				$y=1;
				while($y<7)
				{
					$cell[$i][$y+8]=$data2['prj'."$sms"."$nlitrm"."$y"];
					$y++;
				}
				$y=1;
				$cell[$i][$y+14]=$data2['st'."$sms"."$nlitrm"]; // ST				

				$y=1;
				while($y<8)
				{
					$cell[$i][$y+15]=$data2['tes'."$sms"."$nlitrm"."$y"];
					$y++;
				}
				$y=1;
				while($y<6)
				{
					$cell[$i][$y+22]=$data2['ae'."$sms"."$nlitrm"."$y"];
					$y++;
				}
				$y=1;
				$cell[$i][$y+27]=$data2['st_'."$sms"."$nlitrm"]; // ST_
				
				$y=1;
				while($y<6)
				{
					$cell[$i][$y+28]=$data2['af'."$sms"."$nlitrm"."$y"];
					$y++;
				}

				//$cell[$i][$y+26]=$data2['midtes'."$sms"."$nlitrm"];
				
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
							if($data[kdekls]=='SHS-10IPA' OR $data[kdekls]=='SHS-10IPS'  OR  $data[kdekls]=='SHS-11IPA' OR $data[kdekls]=='SHS-11IPS')
							{
								
							}
							else if($data[kdekls]=='SHS-12IPA' OR $data[kdekls]=='SHS-12IPS')
							{
								if( $kdeplj=='BIN' OR $kdeplj=='BLGY' OR $kdeplj=='CHM' OR $kdeplj=='ENG' OR $kdeplj=='ICT' OR $kdeplj=='MND' OR $kdeplj=='GRM' OR $kdeplj=='PE' OR $kdeplj=='PHY' OR $kdeplj=='RLG' )
								{
									if($kdekls==$data[kdekls])
										echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
									else
										echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
								}
							}
							else
							{
								
							}
						}
						echo"
						</SELECT>
						
					</TD>	
              	</TR>	
				<tr>
					<td>Tahun Pelajaran</td><td> : 
						<!--<SELECT NAME		='thnajr'
								ID			='thnajr'
								readonly/>
							<OPTION VALUE='2017-2018'>2017-2018</OPTION>
							<OPTION VALUE='2018-2019' SELECTED>2018-2019</OPTION>
						</select>-->
						<input type='text' NAME='thn_ajr' ID='thn_ajr' value='2018-2019' readonly/>
						<INPUT TYPE='submit' 					VALUE='View'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04Z'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						<INPUT TYPE='hidden' 	NAME='kdeplj'	VALUE=$kdeplj>
						<!--<INPUT TYPE='hidden' 	NAME='thnajr'	VALUE=$thnajr>-->
					</td>
				</tr>			
			</TABLE>
		</FORM>
		
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>";
				
				// awal buatan
				
				//if($kdetkt=='PS')
				//{
					echo"<TR bgcolor='dedede'>
						<TD WIDTH='2%' ROWSPAN='2' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='20%' ROWSPAN='2'><CENTER>Name	    </CENTER></TD>
						<TD WIDTH='25%' COLSPAN='7' HEIGHT='20'><CENTER>Writen Output/Quiz	    	</CENTER></TD>";
						
					echo"<TD WIDTH='25%' COLSPAN='6'><CENTER>Homework/Project	    	</CENTER></TD>";
					
					if ($pilihan=='detil'  AND $kdekls!='')
						echo"
						<TD WIDTH='4%' ROWSPAN='2'><CENTER><a href='guru.php?mode=R1D04Z&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=st'><span style='color: #FF0000;'><b>ST</b></span></CENTER></TD>";
					else
						echo"
						<TD WIDTH='4%' ROWSPAN='2'><CENTER>ST</CENTER></TD>";
					
					echo"<TD WIDTH='24%' COLSPAN='7'><CENTER>PERFORMANCE / QUIZ	    	</CENTER></TD>";
					echo"<TD WIDTH='25%' COLSPAN='5'><CENTER>Homework/Project/Lab	    	</CENTER></TD>";
					
					if ($pilihan=='detil'  AND $kdekls!='')
						echo"
						<TD WIDTH='4%' ROWSPAN='2'><CENTER><a href='guru.php?mode=R1D04Z&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=st_'><span style='color: #FF0000;'><b>ST</b></span></CENTER></TD>";
					else
						echo"
						<TD WIDTH='4%' ROWSPAN='2'><CENTER>ST</CENTER></TD>";
						
					echo"<TD WIDTH='25%' COLSPAN='5'><CENTER>Affective	    	</CENTER></TD>";
						
						/*if ($pilihan=='detil'  AND $kdekls!='')
							echo"
							<TD WIDTH='4%' ROWSPAN='2'><CENTER><a href='guru.php?mode=R1D04Z&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=midtes'><span style='color: #FF0000;'><b>mid</b></span></CENTER></TD>";
						else
							echo"
							<TD WIDTH='4%' ROWSPAN='2'><CENTER>mid</CENTER></TD>";*/
						
					echo"	
					</TR>
					<TR bgcolor='dedede'>";
						if ($pilihan=='detil'  AND $kdekls!='')
						{
							$y=1;
							while($y<8)
							{
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER><a href='guru.php?mode=R1D04Z&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=hw&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}	
							$y=1;
							while($y<7)
							{
								echo"<TD WIDTH='4%'><CENTER><!--R--><a href='guru.php?mode=R1D04Z&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=prj&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}
							//st
							//$y=1;
								//echo"<TD WIDTH='4%' HEIGHT='20'><CENTER><a href='guru.php?mode=R1D04Z&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=st&kolom2=9'><span style='color: #FF0000;'><b>ST</b></span></CENTER></TD>";
							$y=1;
							while($y<8)
							{
								echo"<TD WIDTH='4%'><CENTER><a href='guru.php?mode=R1D04Z&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=tes&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}
							$y=1;
							while($y<6)
							{
								echo"<TD WIDTH='4%'><CENTER><!--R--><a href='guru.php?mode=R1D04Z&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=ae&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}
							//st_
							//$y=1;
								//echo"<TD WIDTH='4%' HEIGHT='20'><CENTER><a href='guru.php?mode=R1D04Z&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=st_&kolom2=9'><span style='color: #FF0000;'><b>ST</b></span></CENTER></TD>";
							$y=1;
							while($y<6)
							{
								echo"<TD WIDTH='4%'><CENTER><!--R--><a href='guru.php?mode=R1D04Z&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=af&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}
						}
						else
						{
							$y=1;
							while($y<8)
							{
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER>$y	</CENTER></TD>";
								$y++;
							}
							$y=1;
							while($y<7)
							{
								echo"<TD WIDTH='4%'><CENTER>$y	</CENTER></TD>";
								$y++;
							}
							//st
							//$y=1;
								//echo"<TD WIDTH='4%' HEIGHT='20'><CENTER>ST	</CENTER></TD>";
							$y=1;
							while($y<8)
							{
								echo"<TD WIDTH='4%'><CENTER>$y	</CENTER></TD>";
								$y++;
							}	
							$y=1;
							while($y<6)
							{
								echo"<TD WIDTH='4%'><CENTER>$y	</CENTER></TD>";
								$y++;
							}
							//st_
							//$y=1;
								//echo"<TD WIDTH='4%' HEIGHT='20'><CENTER>ST	</CENTER></TD>";
							$y=1;
							while($y<6)
							{
								echo"<TD WIDTH='4%'><CENTER>$y	</CENTER></TD>";
								$y++;
							}
						}
					echo"	
					</TR>";
					
					
					
					//..sampai ini
					
					
					
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
							while($y<8)
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
											TITLE		='$no. $nmav'
											$isianhw[$y]></CENTER>
								</TD>";
								$y++;
							}
							$y=1;
							while($y<7)
							{
								$prj	='prj'."$sms"."$nlitrm"."$y"."$j";
								$prjv	=$cell[$j][$y+8];
								
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
											TITLE		='$no. $nmav'
											$isianprj[$y]></CENTER>
								</TD>";
								$y++;
							}
							$y=1;
							$st		='st'."$sms"."$nlitrm"."$j";
							$stv	=$cell[$j][$y+14];
							
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
										TITLE		='$no. $nmav'
										$isianst[1]></CENTER>
							</TD>";
							
							$y=1;
							while($y<8)
							{
								$tes	='tes'."$sms"."$nlitrm"."$y"."$j";
								$tesv	=$cell[$j][$y+15];
								
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
											TITLE		='$no. $nmav'
											$isiantes[$y]></CENTER>
								</TD>";
								$y++;
							}	
							$y=1;
							while($y<6)
							{
								$ae		='ae'."$sms"."$nlitrm"."$y"."$j";
								$aev	=$cell[$j][$y+22];
								
								// awal buatan
								if ($aev==0)
									$aev='';
								// khir buatan
								
								echo"
								<TD><CENTER>
									<INPUT 	NAME		='$ae'
											TYPE		='text'
											SIZE		='3'
											MAXLENGTH	='3'
											VALUE 		='$aev'
											ID			='$ae'
											ONKEYUP		='formatangka(this);'	
											ONKEYPRESS	='return enter(this,event)'
											TITLE		='$no. $nmav'
											$isianae[$y]></CENTER>
								</TD>";
								$y++;
							}	
							$y=1;
							$st_		='st_'."$sms"."$nlitrm"."$j";
							$st_v	=$cell[$j][$y+27];
							
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
										TITLE		='$no. $nmav'
										$isianst_[1]></CENTER>
							</TD>";
							
							$y=1;
							while($y<6)
							{
								$af		='af'."$sms"."$nlitrm"."$y"."$j";
								$afv	=$cell[$j][$y+28];
								
								// awal buatan
								if ($afv==0)
									$afv='';
								// khir buatan
								
								echo"
								<TD><CENTER>
									<INPUT 	NAME		='$af'
											TYPE		='text'
											SIZE		='3'
											MAXLENGTH	='3'
											VALUE 		='$afv'
											ID			='$af'
											ONKEYUP		='formatangka(this);'	
											ONKEYPRESS	='return enter(this,event)'
											TITLE		='$no. $nmav'
											$isianaf[$y]></CENTER>
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
			<INPUT TYPE='button' 	VALUE='Subject' 	onClick=window.location.href='guru.php?mode=R1D04Z_Cari'>";
			if($pilihan=='detil' AND $kdekls!='')
			{
			  echo"<span style='color: #FF0000;'>  To change, click on the red numbers</span>"; 
			}

			// pilihan tombol pilihan
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04Z_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdeplj'		VALUE=$kdeplj>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<INPUT TYPE='hidden' NAME='thn_ajr'		VALUE=$thn_ajr>
				<INPUT TYPE='hidden' NAME='sms'			VALUE=$sms>
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE=$nlitrm>
				<INPUT TYPE='hidden' NAME='kolom1'		VALUE=$kolom1>
				<INPUT TYPE='hidden' NAME='kolom2'		VALUE=$kolom2>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}
			echo"
		</FORM>";
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04Z_Save()
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
		
		$thn_ajr	=$_POST['thn_ajr'];
		
		$query	="	SELECT 		t_mstbbt_sma.*
					FROM 		t_mstbbt_sma
					WHERE		t_mstbbt_sma.kdebbt='1HW'";
		$result	=mysql_query($query) or die('Query gagal1'); // menghasilkan berapa persen bobot 1
		$data 	=mysql_fetch_array($result);
		$bbthw=$data[bbt];
		
		$query	="	SELECT 		t_mstbbt_sma.*
					FROM 		t_mstbbt_sma
					WHERE		t_mstbbt_sma.kdebbt='2PRJ'";
		$result	=mysql_query($query) or die('Query gagal1'); // menghasilkan berapa persen bobot 2
		$data 	=mysql_fetch_array($result);
		$bbtprj=$data[bbt];

		$query	="	SELECT 		t_mstbbt_sma.*
					FROM 		t_mstbbt_sma
					WHERE		t_mstbbt_sma.kdebbt='3ST'";
		$result	=mysql_query($query) or die('Query gagal1'); // menghasilkan berapa persen bobot 4
		$data 	=mysql_fetch_array($result);
		$bbtst=$data[bbt];
		
		$query	="	SELECT 		t_mstbbt_sma.*
					FROM 		t_mstbbt_sma
					WHERE		t_mstbbt_sma.kdebbt='4TES'";
		$result	=mysql_query($query) or die('Query gagal1'); // menghasilkan berapa persen bobot 4
		$data 	=mysql_fetch_array($result);
		$bbttes=$data[bbt];
		
		$query	="	SELECT 		t_mstbbt_sma.*
					FROM 		t_mstbbt_sma
					WHERE		t_mstbbt_sma.kdebbt='5AE'";
		$result	=mysql_query($query) or die('Query gagal1'); // menghasilkan berapa persen bobot 5
		$data 	=mysql_fetch_array($result);
		$bbtae=$data[bbt];
		
		$query	="	SELECT 		t_mstbbt_sma.*
					FROM 		t_mstbbt_sma
					WHERE		t_mstbbt_sma.kdebbt='6ST_'";
		$result	=mysql_query($query) or die('Query gagal1'); // menghasilkan berapa persen bobot 6
		$data 	=mysql_fetch_array($result);
		$bbtst_=$data[bbt];
		
		$query	="	SELECT 		t_mstbbt_sma.*
					FROM 		t_mstbbt_sma
					WHERE		t_mstbbt_sma.kdebbt='7AF'";
		$result	=mysql_query($query) or die('Query gagal1'); // menghasilkan berapa persen bobot 7
		$data 	=mysql_fetch_array($result);
		$bbtaf=$data[bbt];
		
		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
			if($kolom1=='st' OR $kolom1=='st_') // $kolom1=='midtes' OR 
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

			$set	="	SET		t_prgrptps_sma.nis		='". mysql_escape_string($nis)."',
								t_prgrptps_sma.kdeplj	='". mysql_escape_string($kdeplj)."',
								t_prgrptps_sma.thn_ajaran		='". mysql_escape_string($thn_ajr)."',
								t_prgrptps_sma."."$nliw"."	='". mysql_escape_string($nli)."',
								t_prgrptps_sma.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_prgrptps_sma.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_prgrptps_sma.jamrbh	='". mysql_escape_string($jamrbh)."'"; 

			$query	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis	='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran	='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj	='". mysql_escape_string($kdeplj)."'"; // menghasilkan nis dan matpel nya
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_prgrptps_sma ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan")); // input nilai
			}
			else
			{
				$query 	="	UPDATE 	t_prgrptps_sma ".$set.
						"	WHERE 	t_prgrptps_sma.nis	='". mysql_escape_string($nis)	."'	AND
									t_prgrptps_sma.thn_ajaran	='". mysql_escape_string($thn_ajr)	."'	AND
									t_prgrptps_sma.kdeplj	='". mysql_escape_string($kdeplj)	."'";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah")); // update nilai
			}	
			$j++;
		}
		
		//-------------------------- simpan hasil akhir
		$bghw	=1;
		$bgprj	=1;
		$bgtes	=1;
		$bgae	=1;
		$bgaf	=1;
		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
	
			$query2 ="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE		t_prgrptps_sma.nis	='$nis'		AND
									t_prgrptps_sma.thn_ajaran	='$thn_ajr'		AND
									t_prgrptps_sma.kdeplj='$kdeplj'"; // menghasilkan nis dan matpel nya
			$result2=mysql_query($query2) or die('Query gagal');
			$data2	=mysql_fetch_array($result2);
			$y	=1;
			$hw	=0;
			$prj=0;
			$tes=0;
			$ae=0;
			$af=0;
			while($y<8)
			{
				if($data2['hw'."$sms"."$nlitrm"."$y"]>0)
					$hw++;
				
				$y++;	
			}
			$y	=1;
			while($y<7)
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
			$y	=1;
			while($y<6)
			{
				if($data2['ae'."$sms"."$nlitrm"."$y"]>0)
					$ae++;	
				
				$y++;	
			}
			
			$y	=1;
			while($y<6)
			{
				if($data2['af'."$sms"."$nlitrm"."$y"]>0)
					$af++;	
				
				$y++;	
			}
			
			if($hw>$bghw)
				$bghw=$hw;
			if($prj>$bgprj)
				$bgprj=$prj;
			
			if($tes>$bgtes)
				$bgtes=$tes;
			if($ae>$bgae)
				$bgae=$ae;
			
			if($af>$bgaf)
				$bgaf=$af;
			
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
			$ttlae=0;
			
			$ttlaf=0;

			$query2 ="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE		t_prgrptps_sma.nis	='$nis'		AND
									t_prgrptps_sma.thn_ajaran	='$thn_ajr'		AND
									t_prgrptps_sma.kdeplj='$kdeplj'"; // menghasilkan nis dan matpel nya
			$result2=mysql_query($query2) or die('Query gagal');
			$data2	=mysql_fetch_array($result2);
	
			$y=1;
			while($y<8)
			{
				$hw=$data2['hw'."$sms"."$nlitrm"."$y"];
				$ttlhw=$ttlhw+$hw;
				$y++;
			}
			$y=1;
			while($y<7)
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
			$y=1;
			while($y<6)
			{
				$ae=$data2['ae'."$sms"."$nlitrm"."$y"];
				$ttlae=$ttlae+$ae;
				$y++;
			}
			
			$y=1;
			while($y<6)
			{
				$af=$data2['af'."$sms"."$nlitrm"."$y"];
				$ttlaf=$ttlaf+$af;
				$y++;
			}
			
			$avghw	=$ttlhw/$bghw;
			$bavghw	=($avghw*$bbthw)/100;
			$avgprj	=$ttlprj/$bgprj;
			$bavgprj=($avgprj*$bbtprj)/100;
			
			$avgtes	=$ttltes/$bgtes;
			$bavgtes=($avgtes*$bbttes)/100;
			$avgae	=$ttlae/$bgae;
			$bavgae	=($avgae*$bbtae)/100;
			
			//
			$bgaf_x = 10 * $bgaf;
			$avgaf	=$ttlaf*100/$bgaf_x;
			//
			//$avgaf	=$ttlaf/$bgaf;
			$bavgaf	=($avgaf*$bbtaf)/100;
			
			$smstes		=$data2['st'."$sms"."$nlitrm"];
			$smstes_	=$data2['st_'."$sms"."$nlitrm"];
			$ttl1		=($avghw+$avgprj+$smstes)/3;
			$ttl2		=($avgtes+$avgae+$smstes_)/3;
			$nt			=number_format( ($ttl1+$ttl2)/2 ,0,',','.');
			/*
			$ttl70		=$ttl*((100-$bbtmidtes)/100);
			
			$midtes30	=($midtes*$bbtmidtes)/100;
			$nliakh		=$ttl70+$midtes30;
			
			$ttlakh		=$ttlakh+$nliakh;
			*/
			
			$avehw		='avehw'."$sms"."$nlitrm";
			$aveprj		='aveprj'."$sms"."$nlitrm";
			$avetes		='avetes'."$sms"."$nlitrm";
			$aveae		='aveae'."$sms"."$nlitrm";
			
			$fgt		='fgt'."$sms"."$nlitrm";
			$fgp		='fgp'."$sms"."$nlitrm";
			$akh		='akh'."$sms"."$nlitrm";
			$aff		='aff'."$sms"."$nlitrm";
			
			$set	="	SET		t_prgrptps_sma."."$avehw"."	='". mysql_escape_string( $avghw )."',
								t_prgrptps_sma."."$aveprj"."	='". mysql_escape_string( $avgprj )."',
								t_prgrptps_sma."."$avetes"."	='". mysql_escape_string( $avgtes )."',
								t_prgrptps_sma."."$aveae"."	='". mysql_escape_string( $avgae )."',
								
								t_prgrptps_sma."."$fgt"."	='". mysql_escape_string( $ttl1 )."',
								t_prgrptps_sma."."$fgp"."	='". mysql_escape_string( $ttl2 )."',
								t_prgrptps_sma."."$akh"."	='". mysql_escape_string( $nt )."',
								t_prgrptps_sma."."$aff"."	='". mysql_escape_string( $avgaf )."'"; // $nliakh 
			$query 	="	UPDATE 	t_prgrptps_sma ".$set.
					"	WHERE 	t_prgrptps_sma.nis	='". mysql_escape_string($nis)	."'	AND
								t_prgrptps_sma.thn_ajaran	='". mysql_escape_string($thn_ajr)	."'	AND
								t_prgrptps_sma.kdeplj	='". mysql_escape_string($kdeplj)	."' ";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah")); // UPDATE nilai field akh (akhir)
			
			if($nliakh>0)
				$jml++;
			
			$j++;
		}	

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
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04Z&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=detil\">\n";
 	}		
}//akhir class
?>