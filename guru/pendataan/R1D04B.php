<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04B.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT WEEKLY PROGRESS
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Bclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04B()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../guru/js/R1D04B.js'></SCRIPT>";

        $kdekry	=$_SESSION["Admin"]["kdekry"];
		
		$kdekls	=$_GET['kdekls'];
		$idwa	=$_GET['idwa'];
		$nis	=$_GET['nis'];
		$pilihan=$_GET['pilihan'];
		
		if($pilihan=='')
			$pilihan='new';

		switch($pilihan)
		{
			case 'detil':
				$isian1	='disabled';
				$isian2	='disabled';
				break;
			case 'new':
				$isian1	='enable';
				$isian2	='disabled';
				break;
			case 'edit':
				$isian1	='disabled';
				$isian2	='enable';
				break;
		}		
		
		$query 	="	SELECT 		t_mstkls.*,t_klmkls.*
					FROM 		t_mstkls,t_klmkls
					WHERE 		t_mstkls.kdekls='". mysql_escape_string($kdekls)."' AND
								t_mstkls.kdeklm=t_klmkls.kdeklm";
		$result =mysql_query($query) or die('Query gagal2');
		$data 	=mysql_fetch_array($result);
		$kdetkt=$data[kdetkt];

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>INPUT WEEKLY PROGRESS</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='10%'>Class</TD>
					<TD WIDTH='90%'>:
						<INPUT TYPE='hidden' 	NAME='kdegru' ID='kdegru'	VALUE='$kdekry'>
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								CLASS		='kdekls'
								onkeypress	='return enter(this,event)'
								$isian1>
						<OPTION VALUE='' SELECTED>--Select--</OPTION>";
						$query2="	SELECT 		t_mstkls.*,t_prstkt.*,t_klmkls.*
									FROM 		t_mstkls,t_prstkt,t_klmkls
                                    WHERE      	t_prstkt.kdekry='". mysql_escape_string($kdekry)."' AND
												t_prstkt.kdetkt=t_klmkls.kdetkt AND
												(t_klmkls.kdetkt='PG' OR t_klmkls.kdetkt='KG') AND
												t_klmkls.kdeklm=t_mstkls.kdeklm	AND
												(t_mstkls.wlikls='". mysql_escape_string($kdekry)."' OR t_prstkt.kdejbt<600 OR t_prstkt.kdejbt=900)
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
								onkeypress	='return enter(this,event)'
								$isian1>
						<OPTION VALUE='' SELECTED>--Select--</OPTION>";
						$query3="	SELECT 		t_setpgwa.*
									FROM 		t_setpgwa
									WHERE    t_setpgwa.kdetkt='$kdetkt'
									ORDER BY 	t_setpgwa.kdetkt,t_setpgwa.idwa";
						$result3=mysql_query($query3);
						while($data3=mysql_fetch_array($result3))
						{
							if ($idwa==$data3[idwa])
								echo"<OPTION VALUE='$data3[idwa]' SELECTED>$data3[nmawa]</OPTION>";
							else
								echo"<OPTION VALUE='$data3[idwa]'>$data3[nmawa]</OPTION>";
						}
						echo"
						</SELECT>";
						if($pilihan=='new')
						{
							echo"
							<INPUT TYPE='submit' 					VALUE='View'>
							<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04B'>
							<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>";
						}
						else
						{
							echo"
							<INPUT TYPE='submit' 					VALUE='New'>
							<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04B'>
							<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='new'>";
						}	
					echo"	
					</TD>
				</TR>
			</TABLE>
		</FORM>
		
		<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
			<TR>
				<TD WIDTH='30%' valign='top'>
					<FORM ACTION='guru.php' METHOD='post' NAME='f2' ENCTYPE='multipart/form-data'>
						<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 8%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='80%'><CENTER>Name			</CENTER></TD>
									<TD WIDTH='12%'><CENTER>Detail			</CENTER></TD>
								</TR>";
								$query ="	SELECT 		t_mstssw.*
											FROM 		t_mstssw
											WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."'
											ORDER BY 	t_mstssw.nmassw";
								$result =mysql_query($query);
					
								while($data =mysql_fetch_array($result))
								{   
									$nmassw	=$data['nmassw'];
									$kdekls	=$data['kdekls'];
 
									$no++;
									echo"
									<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
										<TD><CENTER>$no 	</CENTER></TD>
										<TD>$nmassw</TD>
										<TD>
											<CENTER><a href='guru.php?mode=R1D04B&kdekls=$kdekls&nis=$data[nis]&idwa=$idwa&pilihan=detil'>
											<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
										</TD>
									</TR>";
								}
							echo"	
							</TABLE>	
						</DIV>
					</FORM>
				</TD>
				
				<TD WIDTH='70%' valign='top'>";
					$nmassw='';
					if($nis!='')
					{
						$query =mysql_query("	SELECT 		t_wapg.*
												FROM 		t_wapg
												WHERE   	t_wapg.nis='". mysql_escape_string($nis)."'	AND
															t_wapg.idwa='". mysql_escape_string($idwa)."'");
						$data = mysql_fetch_array($query);
						if($data[nis]=='')
						{
							$query =mysql_query("	SELECT 		t_setpgwaplj.*
													FROM 		t_setpgwaplj
													WHERE   	t_setpgwaplj.kdetkt='". mysql_escape_string($kdetkt)."'
													ORDER BY	t_setpgwaplj.kdetkt,t_setpgwaplj.idplj");
							while($data = mysql_fetch_array($query))
							{
								$kdeplj=$data[kdeplj];
								$set	="	SET		t_wapg.nis		='". mysql_escape_string($nis)	."',
													t_wapg.idwa	='". mysql_escape_string($idwa)	."',
													t_wapg.kdeplj='". mysql_escape_string($kdeplj)	."'";
								$query2 	="	INSERT INTO t_wapg ".$set; 
								$result2	=mysql_query($query2) or die (mysql_error());
							}
							
						}

						$query =mysql_query("	SELECT 		t_wapgabs.*
												FROM 		t_wapgabs
												WHERE   	t_wapgabs.nis='". mysql_escape_string($nis)."'	AND
															t_wapgabs.idwa='". mysql_escape_string($idwa)."'");
						$data = mysql_fetch_array($query);
						if($data[nis]=='')
						{
							$set	="	SET		t_wapgabs.nis	='". mysql_escape_string($nis)	."',
												t_wapgabs.idwa	='". mysql_escape_string($idwa)	."'";
							$query2 ="	INSERT INTO t_wapgabs ".$set; 
							$result2=mysql_query($query2) or die (mysql_error());
						}
						
						$query ="	SELECT 		t_mstssw.*
									FROM 		t_mstssw
									WHERE   	t_mstssw.nis='". mysql_escape_string($nis)."'";
						$result =mysql_query($query);
						$data = mysql_fetch_array($result);
						$nmassw=$data[nmassw];
						
						$query 	="	SELECT 		t_setpgwaplj.* 
									FROM 		t_setpgwaplj 
									WHERE 		t_setpgwaplj.kdetkt='". mysql_escape_string($kdetkt)."'	
									ORDER BY 	t_setpgwaplj.kdetkt,t_setpgwaplj.idplj";
						$result	=mysql_query($query) or die (mysql_error());

						$i=0;
						while($data = mysql_fetch_array($result))
						{
							$cell[$i][0] 	=$data['kdeplj'];
							$kdeplj			=$data['kdeplj'];
							$cell[$i][1] 	=$data['nmaplj'];

							$query2	="	SELECT 		t_setpgwatpk.* 
										FROM 		t_setpgwatpk 
										WHERE 		t_setpgwatpk.idwa='". mysql_escape_string($idwa)."'	AND
													t_setpgwatpk.kdeplj='". mysql_escape_string($kdeplj)."'";
							$result2=mysql_query($query2) or die (mysql_error());
							$data2 	=mysql_fetch_array($result2);
						
							$cell[$i][2] 	=$data2['tpk1'];
							$cell[$i][3] 	=$data2['tpk2'];
							$cell[$i][4] 	=$data2['tpk3'];
							$cell[$i][5] 	=$data2['tpk4'];
							$cell[$i][6] 	=$data2['tpk5'];
							$cell[$i][7] 	=$data2['out1'];
							$cell[$i][9] 	=$data2['out2'];
							$cell[$i][11] 	=$data2['out3'];
							$cell[$i][13] 	=$data2['out4'];
							$cell[$i][15] 	=$data2['out5'];
							
							$query2	="	SELECT 		t_wapg.* 
										FROM 		t_wapg 
										WHERE 		t_wapg.nis='". mysql_escape_string($nis)."' AND
													t_wapg.idwa='". mysql_escape_string($idwa)."' AND
													t_wapg.kdeplj='". mysql_escape_string($kdeplj)."'";
							$result2=mysql_query($query2) or die (mysql_error());
							$data2 	=mysql_fetch_array($result2);
							$cell[$i][8] 	=$data2['nliout1'];
							$cell[$i][10] 	=$data2['nliout2'];
							$cell[$i][12] 	=$data2['nliout3'];
							$cell[$i][14] 	=$data2['nliout4'];
							$cell[$i][16] 	=$data2['nliout5'];
							$i++;
						}

						$query3	="	SELECT 		t_wapgabs.* 
									FROM 		t_wapgabs 
									WHERE 		t_wapgabs.nis='". mysql_escape_string($nis)."' AND
												t_wapgabs.idwa='". mysql_escape_string($idwa)."'";
						$result3=mysql_query($query3) or die (mysql_error());
						$data3 	=mysql_fetch_array($result3);
						$att	=$data3[att];
						$abs	=$data3[abs];
					echo"
					<FORM ACTION='guru.php' METHOD='post' NAME='f3' ENCTYPE='multipart/form-data'>
						<B>Name : $nmassw</B>
						<DIV style='overflow:auto;;width:100%;height:290px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
								<TR bgcolor='dedede'>
									<TD WIDTH=20% ROWSPAN=2 HEIGHT=20><CENTER><b>Subject and Topic</b></CENTER></TD>
									<TD WIDTH=55% ROWSPAN=2><CENTER><b>Outcomes/Expectations</b></CENTER></TD>
									<TD WIDTH=25% COLSPAN=6 HEIGHT=20><CENTER><b>Overview of Progress</b></CENTER></TD>
								</TR>
								<TR bgcolor='dedede'>
									<TD WIDTH='5%' HEIGHT=20><CENTER><b>A</b></CENTER></TD>
									<TD WIDTH='5%'><CENTER><b>B</b></CENTER></TD>
									<TD WIDTH='5%'><CENTER><b>C</b></CENTER></TD>
									<TD WIDTH='5%'><CENTER><b>D</b></CENTER></TD>
									<TD WIDTH='5%'><CENTER><b>N/A</b></CENTER></TD> 
								<TR>";
								$j=0;
								while($j<$i)
								{
									$kdeplj	='kdeplj'.$j;
									$kdepljv=$cell[$j][0];
									$nmaplj	='nmaplj'.$j;
									$nmapljv=$cell[$j][1];
									$x=1;
									while($x<6)
									{
										$tpk[$x]	='tpk'.$x.$j;
										$tpkv[$x]	=$cell[$j][$x+1];
										$out[$x]	='out'.$x.$j;
										$outv[$x]	=$cell[$j][$x*2+5];
										$nliout[$x]	='nliout'.$x.$j;
										$nlioutv[$x]=$cell[$j][$x*2+6];
										$x++;	
									}	

									echo"
									<TR>
										<INPUT TYPE='hidden' 	NAME='$kdeplj' id='kdeplj'	VALUE='$kdepljv'>
										<TD valign=top COLSPAN=7 HEIGHT=20>$nmapljv</TD>
									</TR>";
									$x=1;
									while($x<6)
									{
										echo"
										<TR>
											<TD>$tpkv[$x]</TD>
											<TD HEIGHT=20>$outv[$x]</TD>";
											if($nlioutv[$x]=='A' AND $pilihan=='detil')
												{echo"<TD bgColor='#FCC012'>";}
											else	
												{echo"<TD>";}
											echo"	
											<CENTER>
												<INPUT 	NAME	='$nliout[$x]'
														TYPE	='radio'
														VALUE 	='A'
														ID		='$nliout[$x]'";
													if($nlioutv[$x]=='A')
														echo"checked";
													echo"		
													$isian2> 
											<CENTER></TD>";
											if($nlioutv[$x]=='B' AND $pilihan=='detil')
												{echo"<TD bgColor='#FCC012'>";}
											else	
												{echo"<TD>";}
											echo"	
											<CENTER>
												<INPUT 	NAME	='$nliout[$x]'
														TYPE	='radio'
														VALUE 	='B'
														ID		='$nliout[$x]'";
													if($nlioutv[$x]=='B')
														echo"checked";
													echo"		
													$isian2> 
											<CENTER></TD>";
											if($nlioutv[$x]=='C' AND $pilihan=='detil')
												{echo"<TD bgColor='#FCC012'>";}
											else	
												{echo"<TD>";}
											echo"	
											<CENTER>
												<INPUT 	NAME	='$nliout[$x]'
														TYPE	='radio'
														VALUE 	='C'
														ID		='$nliout[$x]'";
													if($nlioutv[$x]=='C')
														echo"checked";
													echo"		
													$isian2> 
											<CENTER></TD>";
											if($nlioutv[$x]=='D' AND $pilihan=='detil')
												{echo"<TD bgColor='#FCC012'>";}
											else	
												{echo"<TD>";}
											echo"	
											<CENTER>
												<INPUT 	NAME	='$nliout[$x]'
														TYPE	='radio'
														VALUE 	='D'
														ID		='$nliout[$x]'";
													if($nlioutv[$x]=='D')
														echo"checked";
													echo"		
													$isian2> 
											<CENTER></TD>";
											if($nlioutv[$x]=='N' AND $pilihan=='detil')
												{echo"<TD bgColor='#FCC012'>";}
											else	
												{echo"<TD>";}
											echo"	
											<CENTER>
												<INPUT 	NAME	='$nliout[$x]'
														TYPE	='radio'
														VALUE 	='N'
														ID		='$nliout[$x]'";
													if($nlioutv[$x]=='N')
														echo"checked";
													echo"		
													$isian2> 
											<CENTER></TD>
										</TR>";
										$x++;
									}	
									$j++;
								}
							echo"	
							</TABLE>
							<br>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
								<TR bgcolor='dedede'>
									<TD WIDTH=80% HEIGHT=20><CENTER><b>Attendance</b></CENTER></TD>
									<TD WIDTH=20%><CENTER><b>Days</b></CENTER></TD>
								</TR>
								<TR><TD HEIGHT=20>Days Attended</TD>
									<TD><CENTER><INPUT 	NAME		='att'	
												TYPE		='text' 
												SIZE		='3' 	
												MAXLENGTH	='3'		
												VALUE		='$att'
												ONKEYUP		='formatangka(this);'
												onkeypress	='return enter(this,event)'
												$isian2>
									</CENTER></TD>
								</TR>
								<TR><TD HEIGHT=20>Days Absent</TD>
									<TD><CENTER><INPUT 	NAME		='abs'	
												TYPE		='text' 
												SIZE		='3' 	
												MAXLENGTH	='3'		
												VALUE		='$abs'
												ONKEYUP		='formatangka(this);'
												onkeypress	='return enter(this,event)'
												$isian2>
									</CENTER></TD>
								</TR>
							</TABLE>		
						</DIV>
						<BR>";
						if ($pilihan=='detil' AND $nis!='')
						{
							echo"
							<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='guru.php?mode=R1D04B&kdekls=$kdekls&nis=$nis&idwa=$idwa&pilihan=edit'>";
						}	
						
						// tombol simpan (edit)
						if($pilihan=='edit' AND $nis!='')
						{
							echo"
							<INPUT TYPE='submit' 				VALUE='Simpan'>
							<INPUT TYPE='hidden' NAME='mode' 	VALUE='R1D04B_Save'>
							<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
							<INPUT TYPE='hidden' NAME='kdekls'	VALUE=$kdekls>
							<INPUT TYPE='hidden' NAME='idwa'	VALUE=$idwa>
							<INPUT TYPE='hidden' NAME='nis'		VALUE=$nis>
							<INPUT TYPE='hidden' NAME='i'		VALUE=$i>";
						}
					echo"
					</FORM>";
					}
				echo"	
				</TD>
			</TR>
		</TABLE>";
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04B_Save()
	{
  		$kdekls	=$_POST['kdekls'];
		$idwa	=$_POST['idwa'];
		$nis	=$_POST['nis'];
		$i		=$_POST['i'];
		$att	=$_POST['att'];
		$abs	=$_POST['abs'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

		$j=0;
		while($j<$i) 
		{
			$kdeplj 	='kdeplj'.$j;
			$kdeplj		=$_POST["$kdeplj"]; 
			
			$nliout1 	="nliout1".$j;
			$nliout1	=$_POST["$nliout1"]; 
			$nliout2 	="nliout2".$j;
			$nliout2	=$_POST["$nliout2"]; 
			$nliout3 	="nliout3".$j;
			$nliout3	=$_POST["$nliout3"]; 
			$nliout4 	="nliout4".$j;
			$nliout4	=$_POST["$nliout4"]; 
			$nliout5 	="nliout5".$j;
			$nliout5	=$_POST["$nliout5"]; 
			
			$set	="	SET		t_wapg.nliout1	='". mysql_escape_string($nliout1)."',
								t_wapg.nliout2	='". mysql_escape_string($nliout2)."',
								t_wapg.nliout3	='". mysql_escape_string($nliout3)."',
								t_wapg.nliout4	='". mysql_escape_string($nliout4)."',
								t_wapg.nliout5	='". mysql_escape_string($nliout5)."'";

			$query 	="	UPDATE 	t_wapg ".$set.
					"	WHERE 	t_wapg.nis		='". mysql_escape_string($nis)	."'	AND
								t_wapg.idwa		='". mysql_escape_string($idwa)	."'	AND
								t_wapg.kdeplj	='". mysql_escape_string($kdeplj)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));		
			$j++;
		}

		$set	="	SET		t_wapgabs.att	='". mysql_escape_string($att)."',
							t_wapgabs.abs	='". mysql_escape_string($abs)."'";

		$query 	="	UPDATE 	t_wapgabs ".$set.
				"	WHERE 	t_wapgabs.nis		='". mysql_escape_string($nis)	."'	AND
							t_wapgabs.idwa		='". mysql_escape_string($idwa)	."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));		

		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04B&kdekls=$kdekls&nis=$nis&idwa=$idwa&pilihan=detil\">\n";
 	}		
}//akhir class
?>