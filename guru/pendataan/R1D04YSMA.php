<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04YSMA.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT PROGRESS REPORT sma 10
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04YSMAclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04YSMA_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
			
		$query	="	SELECT 		DISTINCT t_mstplj.kdeplj,t_mstplj.nmaplj
								FROM 		t_mstpng,t_mstplj
								WHERE		t_mstpng.kdegru='$kdekry' AND
											t_mstpng.kdeplj=t_mstplj.kdeplj	AND
											t_mstplj.str=''";
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><B>INPUT GRADING SHEET (SHS) 10-11</B></TD></TR>
			<TR></TR><TR></TR>
		</TABLE>
			
		<FORM ACTION='guru.php?mode=R1D04YSMA' METHOD='post'>
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
							<TD><CENTER><a href='guru.php?mode=R1D04YSMA&kdeplj=$data[kdeplj]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>
		</FORM>";
 	}
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	
	// -------------------------------------------------- Layar Utama --------------------------------------------------	
	function R1D04YSMA()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$kdeplj	=$_GET['kdeplj'];
		$pilihan=$_GET['pilihan'];
		$kolom1	=$_GET['kolom1'];
		$kolom2	=$_GET['kolom2'];
		
		$thn_ajr	=$_GET['thn_ajr'];

		$sms	='Semester';
		$query 	=mysql_query("	SELECT 		t_setthn_sma.* 
								FROM 		t_setthn_sma
								WHERE		t_setthn_sma.set='$sms'");
		$data = mysql_fetch_array($query);
		$sms=$data[nli];
					
		$midtrm	='Mid Term';
		$query 	=mysql_query("	SELECT 		t_setthn_sma.* 
								FROM 		t_setthn_sma
								WHERE		t_setthn_sma.set='$midtrm'");
		$data = mysql_fetch_array($query);
		$nlitrm=$data[nli];
		$midtrm=$midtrm.' '.$nlitrm;
		
		$query="	SELECT 			t_mstplj.*
					FROM 			t_mstplj
					WHERE 			t_mstplj.kdeplj='$kdeplj'";
		$result=mysql_query($query);
		$data=mysql_fetch_array($result);
		$nmaplj=$data[nmaplj];
		
		if($pilihan=='')
			$pilihan='detil';

		switch($pilihan)
		{
			case 'detil':
				$y=1;
				while($y<13)
				{
					$isianhw[$y]='disabled';
					$isianprj[$y]='disabled';
					$y++;
				}
				$y=1;
				while($y<6)
				{
					$isiantes[$y]='disabled';
					
					$y++;
				}
				
				$y=1;
				while($y<13)
				{
					$isianae[$y]='disabled';
					$isianaf[$y]='disabled';
					$y++;
				}
				$y=1;
				while($y<6)
				{
					$isianag[$y]='disabled';
					$y++;
				}
				$isianmidtes[1]='disabled';
				break;
			case 'edit':
				$y=1;
				while($y<13)
				{
					if($kolom1=='hw' and $kolom2=="$y")
						$isianhw[$y]='enable';
					else	
						$isianhw[$y]='disabled';
						
					if($kolom1=='prj' and $kolom2=="$y")	
						$isianprj[$y]='enable';
					else
						$isianprj[$y]='disabled';
					
					$y++;
				}	
				$y=1;
				while($y<6)
				{
					if($kolom1=='tes' and $kolom2=="$y")		
						$isiantes[$y]='enable';
					else	
						$isiantes[$y]='disabled';
					
					$y++;
				}

				$y=1;
				while($y<13)
				{
					if($kolom1=='ae' and $kolom2=="$y")
						$isianae[$y]='enable';
					else	
						$isianae[$y]='disabled';
						
					if($kolom1=='af' and $kolom2=="$y")	
						$isianaf[$y]='enable';
					else
						$isianaf[$y]='disabled';
					
					$y++;
				}	
				$y=1;
				while($y<6)
				{
					if($kolom1=='ag' and $kolom2=="$y")		 // k13
						$isianag[$y]='enable';
					else	
						$isianag[$y]='disabled';
					
					$y++;
				}
				
				if($kolom1=='midtes')		
					$isianmidtes[1]='enable';
				else	
					$isianmidtes[1]='disabled';
				break;
				
		}		

		$query 	="	SELECT 		t_mstssw.*
					FROM 		t_mstssw
					WHERE 		t_mstssw.kdekls	='". mysql_escape_string($kdekls)."'	AND
								t_mstssw.thn_ajaran	='". mysql_escape_string($thn_ajr)."'	AND
								t_mstssw.str=''
					ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw";
		$result =mysql_query($query);

		$i=0;
		while($data = mysql_fetch_array($result))
		{
			$cell[$i][0]=$data[nis];
			$nis		=$data[nis];
			$cell[$i][1]=$data[nmassw];
			$kdeusr		=$data[kdeusr];
			$tglrbh		=$data[tglrbh];
			$jamrbh		=$data[jamrbh];
//--..
			$query2	="	SELECT 		t_prgrptps_sma_k13.*
						FROM 		t_prgrptps_sma_k13
						WHERE 		t_prgrptps_sma_k13.nis		='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma_k13.thn_ajaran		='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma_k13.kdeplj	='". mysql_escape_string($kdeplj)."'";
			$result2 =mysql_query($query2);
			$data2 	 =mysql_fetch_array($result2);
			$y=1;
			while($y<13)
			{
				$cell[$i][$y+1]=$data2['hw'."$sms"."$nlitrm"."$y"];
				$y++;
			}	

			$y=1;
			while($y<13)
			{
				$cell[$i][$y+13]=$data2['prj'."$sms"."$nlitrm"."$y"];
				$y++;
			}	
			
			$y=1;
			while($y<6)
			{
				$cell[$i][$y+25]=$data2['tes'."$sms"."$nlitrm"."$y"];
				$y++;
			}
			//..
			
			$y=1;
			$cell[$i][$y+30]=$data2['midtes'."$sms"."$nlitrm"];
			
			$y=1;
			$cell[$i][$y+31]=$data2['qg_k13_'."$sms"."$nlitrm"];
			
			//..
			$y=1;
			while($y<13)
			{
				$cell[$i][$y+32]=$data2['ae'."$sms"."$nlitrm"."$y"];
				$y++;
			}	

			$y=1;
			while($y<13)
			{
				$cell[$i][$y+44]=$data2['af'."$sms"."$nlitrm"."$y"];
				$y++;
			}
			
			$y=1; // k13						
			while($y<6)
			{
				$cell[$i][$y+56]=$data2['ag'."$sms"."$nlitrm"."$y"];
				$y++;
			}
			
			$y=1;
			$cell[$i][$y+61]=$data2['qg_k14_'."$sms"."$nlitrm"];
			
			
			
			$i++;
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
									ORDER BY 		t_mstkls.kdeklm,t_mstpng.kdekls";
						$result2=mysql_query($query2);
						while($data=mysql_fetch_array($result2))
						{
							if($data[kdekls]=='SHS-10IPA' OR $data[kdekls]=='SHS-10IPS' OR $data[kdekls]=='SHS-11IPA' OR $data[kdekls]=='SHS-11IPS')
							{
								if($kdekls==$data[kdekls])
									echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
								else
									echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
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
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04YSMA'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						<INPUT TYPE='hidden' 	NAME='kdeplj'	VALUE=$kdeplj>
						<!--<INPUT TYPE='hidden' 	NAME='thnajr'	VALUE=$thnajr>-->
					</td>
				</tr>	
			</TABLE>
		</FORM>
		
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH='2%' ROWSPAN='2' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD ROWSPAN='2'><CENTER>Name	    </CENTER></TD>
						<TD COLSPAN='12' HEIGHT='20'><CENTER>QUIZZES	    	</CENTER></TD>
						<TD COLSPAN='12'><CENTER>HOMEWORK/WORKSHEET	    	</CENTER></TD>
						<TD COLSPAN='5'><CENTER>UNIT TEST	    	</CENTER></TD>";
						
						if ($pilihan=='detil'  AND $kdekls!='')
							echo"
							<TD WIDTH='4%' ROWSPAN='2'><CENTER><a href='guru.php?mode=R1D04YSMA&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=midtes'><span style='color: #FF0000;'><b>mid</b></span></CENTER></TD>";
						else
							echo"
							<TD WIDTH='4%' ROWSPAN='2'><CENTER>mid</CENTER></TD>";
							
						echo"<TD WIDTH='4%' ROWSPAN='2'><CENTER>QG</CENTER></TD>";
						
						echo"<TD COLSPAN='12'><CENTER>Praktek/Presentasi/Practical/Presentation							    	</CENTER></TD>";
						echo"<TD COLSPAN='12'><CENTER>Project/Proyek/Product							    	</CENTER></TD>";
						echo"<TD COLSPAN='5'><CENTER>Portofolio/Performance							    	</CENTER></TD>";
						
						echo"<TD WIDTH='4%' ROWSPAN='2'><CENTER>QG</CENTER></TD>";
						
						
						
					echo"	
					</TR>
					<TR bgcolor='dedede'>";
						if ($pilihan=='detil'  AND $kdekls!='')
						{
							$y=1;
							while($y<13)
							{
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER><a href='guru.php?mode=R1D04YSMA&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=hw&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}	
							$y=1;
							while($y<13)
							{
								echo"<TD WIDTH='4%'><CENTER><a href='guru.php?mode=R1D04YSMA&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=prj&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}	
							$y=1;
							while($y<6)
							{
								echo"<TD WIDTH='4%'><CENTER><a href='guru.php?mode=R1D04YSMA&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=tes&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}
							//..k13
							$y=1;
							while($y<13)
							{
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER><a href='guru.php?mode=R1D04YSMA&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=ae&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}	
							$y=1;
							while($y<13)
							{
								echo"<TD WIDTH='4%'><CENTER><a href='guru.php?mode=R1D04YSMA&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=af&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}
							$y=1;
							while($y<6)
							{
								echo"<TD WIDTH='4%'><CENTER><a href='guru.php?mode=R1D04YSMA&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=edit&kolom1=ag&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}
							
						}
						else
						{
							$y=1;
							while($y<13)
							{
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER>$y	</CENTER></TD>";
								$y++;
							}	
							$y=1;
							while($y<13)
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
							//..k13
							$y=1;
							while($y<13)
							{
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER>$y	</CENTER></TD>";
								$y++;
							}	
							$y=1;
							while($y<13)
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
						<TR height='66'>
							<TD><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>$nmav </CENTER></TD>";
							$y=1;
							while($y<13)
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
							while($y<13)
							{
								$prj	='prj'."$sms"."$nlitrm"."$y"."$j";
								$prjv	=$cell[$j][$y+13];
								
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
							while($y<6)
							{
								$tes	='tes'."$sms"."$nlitrm"."$y"."$j";
								$tesv	=$cell[$j][$y+25];
								
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
							//..
							
							
							
							$y=1;
							$midtes	='midtes'."$sms"."$nlitrm"."$j";
							$midtesv=$cell[$j][$y+30];
							
							// awal buatan
							if ($midtesv==0)
								$midtesv='';
							// khir buatan
							
							echo"
							<TD><CENTER>
								<INPUT 	NAME		='$midtes'
										TYPE		='text'
										SIZE		='3'
										MAXLENGTH	='3'
										VALUE 		='$midtesv'
										ID			='$midtes'
										ONKEYUP		='formatangka(this);'	
										ONKEYPRESS	='return enter(this,event)'
										TITLE		='$no. $nmav'
										$isianmidtes[1]></CENTER>
								</TD>";
							
							
							
							$y=1;
							$QG	='qg_k13_'."$sms"."$nlitrm"."$j";
							$QGv=$cell[$j][$y+31];	//		$isianQG[1]
							
							// awal buatan
							if ($QGv==0)
								$QGv='';
							// khir buatan
							
							echo"
							<TD><CENTER>
								<INPUT 	NAME		='$QG'
										TYPE		='text'
										SIZE		='3'
										MAXLENGTH	='3'
										VALUE 		='$QGv'
										ID			='$QG'
										ONKEYUP		='formatangka(this);'	
										ONKEYPRESS	='return enter(this,event)'
										TITLE		='$no. $nmav'
										DISABLED></CENTER>
								</TD>";
							
							
							
							//..k13
							$y=1;
							while($y<13)
							{
								$ae		='ae'."$sms"."$nlitrm"."$y"."$j";
								$aev	=$cell[$j][$y+32];
								
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
							while($y<13)
							{
								$af	='af'."$sms"."$nlitrm"."$y"."$j";
								$afv	=$cell[$j][$y+44];
								
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
							
							$y=1;
							while($y<6)
							{
								$ag	='ag'."$sms"."$nlitrm"."$y"."$j";
								$agv	=$cell[$j][$y+56];
								
								// awal buatan
								if ($agv==0)
									$agv='';
								// khir buatan
								
								echo"
								<TD><CENTER>
									<INPUT 	NAME		='$ag'
											TYPE		='text'
											SIZE		='3'
											MAXLENGTH	='3'
											VALUE 		='$agv'
											ID			='$ag'
											ONKEYUP		='formatangka(this);'	
											ONKEYPRESS	='return enter(this,event)'
											TITLE		='$no. $nmav'
											$isianag[$y]></CENTER>
								</TD>";
								$y++;
							}
							
							$y=1;
							$QG	='qg_k14_'."$sms"."$nlitrm"."$j";
							$QGv=$cell[$j][$y+61];	//		$isianQG[1]
							
							// awal buatan
							if ($QGv==0)
								$QGv='';
							// khir buatan
							
							echo"
							<TD><CENTER>
								<INPUT 	NAME		='$QG'
										TYPE		='text'
										SIZE		='3'
										MAXLENGTH	='3'
										VALUE 		='$QGv'
										ID			='$QG'
										ONKEYUP		='formatangka(this);'	
										ONKEYPRESS	='return enter(this,event)'
										TITLE		='$no. $nmav'
										DISABLED></CENTER>
								</TD>";
								
							
							
						echo"		
						</TR>";

						$j++;
						$no++;
					}		
				echo"	
				</TABLE>	
			</DIV>
			<BR>
			<INPUT TYPE='button' 	VALUE='Subject' 	onClick=window.location.href='guru.php?mode=R1D04YSMA_Cari'>";
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
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04YSMA_Save'>
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
	function R1D04YSMA_Save()
	{
		$kdeplj	=$_POST['kdeplj'];
		$kdekls	=$_POST['kdekls'];
		$sms	=$_POST['sms'];
		$nlitrm	=$_POST['nlitrm'];
		$kolom1	=$_POST['kolom1'];
		$kolom2	=$_POST['kolom2'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		
		$thn_ajr	=$_POST['thn_ajr'];
		
		//..--sampai sini
		
		$query	="	SELECT 		t_mstbbt_sma_k13.*
					FROM 		t_mstbbt_sma_k13
					WHERE		t_mstbbt_sma_k13.kdebbt='1HW'";
		$result	=mysql_query($query) or die('Query gagal1');
		$data 	=mysql_fetch_array($result);
		$bbtW=$data[bbt] / 100;
		
		$query	="	SELECT 		t_mstbbt_sma_k13.*
					FROM 		t_mstbbt_sma_k13
					WHERE		t_mstbbt_sma_k13.kdebbt='2PRJ'";
		$result	=mysql_query($query) or die('Query gagal1');
		$data 	=mysql_fetch_array($result);
		$bbtX=$data[bbt] / 100;

		$query	="	SELECT 		t_mstbbt_sma_k13.*
					FROM 		t_mstbbt_sma_k13
					WHERE		t_mstbbt_sma_k13.kdebbt='3TES'";
		$result	=mysql_query($query) or die('Query gagal1');
		$data 	=mysql_fetch_array($result);
		$bbtY=$data[bbt] / 100;

		$query	="	SELECT 		t_mstbbt_sma_k13.*
					FROM 		t_mstbbt_sma_k13
					WHERE		t_mstbbt_sma_k13.kdebbt='4MID'";
		$result	=mysql_query($query) or die('Query gagal1');
		$data 	=mysql_fetch_array($result);
		$bbtZ=$data[bbt] / 100;
		
		//k13
		
		$query	="	SELECT 		t_mstbbt_sma_k13.*
					FROM 		t_mstbbt_sma_k13
					WHERE		t_mstbbt_sma_k13.kdebbt='5AE'";
		$result	=mysql_query($query) or die('Query gagal1');
		$data 	=mysql_fetch_array($result);
		$bbtAe=$data[bbt] / 100;
		
		$query	="	SELECT 		t_mstbbt_sma_k13.*
					FROM 		t_mstbbt_sma_k13
					WHERE		t_mstbbt_sma_k13.kdebbt='6AF'";
		$result	=mysql_query($query) or die('Query gagal1');
		$data 	=mysql_fetch_array($result);
		$bbtAf=$data[bbt] / 100;

		$query	="	SELECT 		t_mstbbt_sma_k13.*
					FROM 		t_mstbbt_sma_k13
					WHERE		t_mstbbt_sma_k13.kdebbt='7AG'";
		$result	=mysql_query($query) or die('Query gagal1');
		$data 	=mysql_fetch_array($result);
		$bbtAg=$data[bbt] / 100;
		
		
		
				
		
		
		
		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
			if($kolom1=='midtes')
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

			$set	="	SET		t_prgrptps_sma_k13.nis		='". mysql_escape_string($nis)."',
								t_prgrptps_sma_k13.kdeplj	='". mysql_escape_string($kdeplj)."',
								t_prgrptps_sma_k13.thn_ajaran		='". mysql_escape_string($thn_ajr)."',
								t_prgrptps_sma_k13."."$nliw"."	='". mysql_escape_string($nli)."',
								t_prgrptps_sma_k13.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_prgrptps_sma_k13.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_prgrptps_sma_k13.jamrbh	='". mysql_escape_string($jamrbh)."'"; 

			$query	="	SELECT 		t_prgrptps_sma_k13.*
						FROM 		t_prgrptps_sma_k13
						WHERE 		t_prgrptps_sma_k13.nis	='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma_k13.thn_ajaran	='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma_k13.kdeplj	='". mysql_escape_string($kdeplj)."'";
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_prgrptps_sma_k13 ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
			}
			else
			{
				$query 	="	UPDATE 	t_prgrptps_sma_k13 ".$set.
						"	WHERE 	t_prgrptps_sma_k13.nis	='". mysql_escape_string($nis)	."'	AND
									t_prgrptps_sma_k13.thn_ajaran	='". mysql_escape_string($thn_ajr)	."'	AND
									t_prgrptps_sma_k13.kdeplj	='". mysql_escape_string($kdeplj)	."'";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			}	
			$j++;
		}
		
		//-------------------------- simpan hasil akhir
		$bghw	=1;
		$bgprj	=1;
		$bgtes	=1;
		//k13
		$bgae	=1;
		$bgaf	=1;
		$bgag	=1;
		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
	
			$query2 ="	SELECT 		t_prgrptps_sma_k13.*
						FROM 		t_prgrptps_sma_k13
						WHERE		t_prgrptps_sma_k13.nis	='$nis'		AND
									t_prgrptps_sma_k13.thn_ajaran	='$thn_ajr'		AND
									t_prgrptps_sma_k13.kdeplj='$kdeplj' ";
			$result2=mysql_query($query2) or die('Query gagal');
			$data2	=mysql_fetch_array($result2);
			$y	=1;
			$hw	=0;
			$prj=0;
			$tes=0;
			//k13
			$ae=0;
			$af=0;
			$ag=0;
			while($y<13)
			{
				if($data2['hw'."$sms"."$nlitrm"."$y"]>0)
					$hw++;
				if($data2['prj'."$sms"."$nlitrm"."$y"]>0)
					$prj++;
				$y++;	
			}
			$y	=1;
			while($y<6)
			{
				if($data2['tes'."$sms"."$nlitrm"."$y"]>0)
					$tes++;	
				$y++;	
			}
			//k13
			$y  =1; 
			while($y<13)
			{
				if($data2['ae'."$sms"."$nlitrm"."$y"]>0)
					$ae++;
				if($data2['af'."$sms"."$nlitrm"."$y"]>0)
					$af++;
				$y++;	
			}
			$y	=1;
			while($y<6)
			{
				if($data2['ag'."$sms"."$nlitrm"."$y"]>0)
					$ag++;	
				$y++;	
			}
			
			if($hw>$bghw)
				$bghw=$hw;
			if($prj>$bgprj)
				$bgprj=$prj;
			if($tes>$bgtes)
				$bgtes=$tes;
			//k13
			if($ae>$bgae)
				$bgae=$ae;
			if($af>$bgaf)
				$bgaf=$af;
			if($ag>$bgag)
				$bgag=$ag;
	
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
			//k13
			$ttlae=0;
			$ttlaf=0;
			$ttlag=0;

			$query2 ="	SELECT 		t_prgrptps_sma_k13.*
						FROM 		t_prgrptps_sma_k13
						WHERE		t_prgrptps_sma_k13.nis	='$nis'		AND
									t_prgrptps_sma_k13.thn_ajaran	='$thn_ajr'		AND
									t_prgrptps_sma_k13.kdeplj='$kdeplj'";
			$result2=mysql_query($query2) or die('Query gagal');
			$data2	=mysql_fetch_array($result2);
	
			$y=1;
			while($y<13)
			{
				$hw=$data2['hw'."$sms"."$nlitrm"."$y"];
				$prj=$data2['prj'."$sms"."$nlitrm"."$y"];
				$ttlhw=$ttlhw+$hw;
				$ttlprj=$ttlprj+$prj;
				$y++;
			}		
			$y=1;
			while($y<6)
			{
				$tes=$data2['tes'."$sms"."$nlitrm"."$y"];
				$ttltes=$ttltes+$tes;
				$y++;
			}
			//k13			
			$y=1;
			while($y<13)
			{
				$ae=$data2['ae'."$sms"."$nlitrm"."$y"];
				$af=$data2['af'."$sms"."$nlitrm"."$y"];
				$ttlae=$ttlae+$ae;
				$ttlaf=$ttlaf+$af;
				$y++;
			}
			$y=1;
			while($y<6)
			{
				$ag=$data2['ag'."$sms"."$nlitrm"."$y"];
				$ttlag=$ttlag+$ag;
				$y++;
			}
			
			$bghw_x = 100 * $bghw;
			$avghw	=$ttlhw*100/$bghw_x;
			//$avghw	=$ttlhw/$bghw;
			//$bavghw	=($avghw*$bbthw)/100;
			
			//if ($kdeplj == 'ICT') // 100 + 90 + 90 + 100 + 90 + 90 + 90
			$bgprj_x = 100 * $bgprj;
			$avgprj	=$ttlprj*100/$bgprj_x;
			//$avgprj	=$ttlprj/$bgprj;
			//$bavgprj=($avgprj*$bbtprj)/100;
			
			$bgtes_x = 100 * $bgtes;
			$avgtes	=$ttltes*100/$bgtes_x;
			//$avgtes	=$ttltes/$bgtes;
			//$bavgtes=($avgtes*$bbttes)/100;
			
			//k13
			
			$bgae_x = 100 * $bgae;
			$avgae	=$ttlae*100/$bgae_x;
			//$avgae	=$ttlae/$bgae;
			//$bavgae	=($avgae*$bbtae)/100;
			
			$bgaf_x = 100 * $bgaf;
			$avgaf	=$ttlaf*100/$bgaf_x;
			//$avgaf	=$ttlaf/$bgaf;
			//$bavgaf=($avgaf*$bbtaf)/100;
			
			$bgag_x = 100 * $bgag;
			$avgag	=$ttlag*100/$bgag_x;
			//$avgag	=$ttlag/$bgag;
			//$bavgag=($avgag*$bbtag)/100;

			//$ttl		=$bavghw+$bavgprj+$bavgtes;
			//$ttl70		=$ttl*((100-$bbtmidtes)/100);
			$midtes		=$data2['midtes'."$sms"."$nlitrm"];
			$midtes30	= $midtes * 100 / 100; // .. -- / 100 nya disetting
			//$midtes30	=($midtes*$bbtmidtes)/100;
			//$nliakh		=$ttl70+$midtes30;
			
			//
				//------QUARTER GRADE
				
				
				
				
				
				$QG_k13 = (number_format($avghw) * $bbtW) + (number_format($avgprj) * $bbtX) + (number_format($avgtes) * $bbtY) + (number_format($midtes30) * $bbtZ);
				$QG_k14 = (number_format($avgae) * $bbtAe) + (number_format($avgaf) * $bbtAf) + (number_format($avgag) * $bbtAg);
				
					$nliakh = ( number_format($QG_k13) + number_format($QG_k14) ) / 2;
					$nliakh = number_format($nliakh,1,',','.');
					
			//
			
			$avehw		='avehw'."$sms"."$nlitrm";
			$aveprj		='aveprj'."$sms"."$nlitrm";		
			$avetes		='avetes'."$sms"."$nlitrm";		
			$avemid		='avemid'."$sms"."$nlitrm";			
			
			$aveae		='aveae'."$sms"."$nlitrm";		
			$aveaf		='aveaf'."$sms"."$nlitrm";		
			$aveag		='aveag'."$sms"."$nlitrm";		
			
			$qg_k13_	='qg_k13_'."$sms"."$nlitrm";
			$qg_k14_	='qg_k14_'."$sms"."$nlitrm";
			$akh		='akh'."$sms"."$nlitrm";
			$ttlakh		=$ttlakh+$nliakh;

			$set	="	SET		t_prgrptps_sma_k13."."$avehw"."		='". mysql_escape_string(number_format($avghw))."',
								t_prgrptps_sma_k13."."$aveprj"."	='". mysql_escape_string(number_format($avgprj))."',
								t_prgrptps_sma_k13."."$avetes"."	='". mysql_escape_string(number_format($avgtes))."',
								t_prgrptps_sma_k13."."$avemid"."	='". mysql_escape_string(number_format($midtes30))."',
								t_prgrptps_sma_k13."."$aveae"."		='". mysql_escape_string(number_format($avgae))."',
								t_prgrptps_sma_k13."."$aveaf"."		='". mysql_escape_string(number_format($avgaf))."',
								t_prgrptps_sma_k13."."$aveag"."		='". mysql_escape_string(number_format($avgag))."',
								t_prgrptps_sma_k13."."$qg_k13_"."	='". mysql_escape_string($QG_k13)."',
								t_prgrptps_sma_k13."."$qg_k14_"."	='". mysql_escape_string($QG_k14)."',
								t_prgrptps_sma_k13."."$akh"."	='". mysql_escape_string($nliakh)."' "; 
			$query 	="	UPDATE 	t_prgrptps_sma_k13 ".$set.
					"	WHERE 	t_prgrptps_sma_k13.nis	='". mysql_escape_string($nis)	."'	AND
								t_prgrptps_sma_k13.thn_ajaran	='". mysql_escape_string($thn_ajr)	."'	AND
								t_prgrptps_sma_k13.kdeplj	='". mysql_escape_string($kdeplj)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			
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
								t_rtpsrpt.kdeplj	='". mysql_escape_string($kdeplj)."'";
		$result =mysql_query($query);
		$data	=mysql_fetch_array($result);
		if($data[kdekls]=='')
		{
		  	$query 	="	INSERT INTO t_rtpsrpt ".$set; 
			$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
		}
		else
		{
			$query 	="	UPDATE 	t_rtpsrpt ".$set.
					"	WHERE 	t_rtpsrpt.kdekls	='". mysql_escape_string($kdekls)	."'	AND
								t_rtpsrpt.kdeplj	='". mysql_escape_string($kdeplj)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
		}	
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04YSMA&kdeplj=$kdeplj&kdekls=$kdekls&thn_ajr=$thn_ajr&pilihan=detil\">\n";
 	}		
}//akhir class
?>