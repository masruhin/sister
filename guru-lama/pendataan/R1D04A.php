<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04A.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT PROGRESS REPORT
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Aclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04A()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

        $kdekry	=$_SESSION["Admin"]["kdekry"];
		
		$kdekls	=$_GET['kdekls'];
		$nis	=$_GET['nis'];
		$pilihan=$_GET['pilihan'];
		
		if($pilihan=='')
			$pilihan='detil';

		switch($pilihan)
		{
			case 'detil':
				$isian1	='disabled';
				$isian2	='disabled';
				break;
			case 'edit':
				$isian1	='enable';
				$isian2	='disabled';
				break;
			case 'seting':
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
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>INPUT PROGRESS REPORT</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='10%'>Kelas</TD>
					<TD WIDTH='90%'>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						$query2="	SELECT 		*,t_mstkls.kdekls
									FROM 		t_prstkt,t_klmkls,t_mstkls
                                    WHERE      	t_prstkt.kdekry='". mysql_escape_string($kdekry)."' AND
												t_prstkt.kdetkt=t_klmkls.kdetkt AND
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
						<INPUT TYPE='submit' 					VALUE='Tampilkan'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04A'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
		
		<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
			<TR>
				<TD WIDTH='30%' valign='top'>
					<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
						<DIV style='overflow:auto;;width:100%;height:370px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 8%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='80%'><CENTER>Nama			</CENTER></TD>
									<TD WIDTH='12%'><CENTER>Detil				</CENTER></TD>
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
											<CENTER><a href='guru.php?mode=R1D04A&kdekls=$kdekls&nis=$data[nis]'>
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
						$trm	='Term';
						$query 	=mysql_query("	SELECT 		t_setthn.* 
												FROM 		t_setthn
												WHERE		t_setthn.set='$trm'");
						$data = mysql_fetch_array($query);
						$nlitrm=$data[nli];
						$trm=$trm.' '.$nlitrm;
		
						$query =mysql_query("	SELECT 		t_prgrptpg.*
												FROM 		t_prgrptpg
												WHERE   	t_prgrptpg.nis='". mysql_escape_string($nis)."'");
						$data = mysql_fetch_array($query);
						if($data[nis]=='' AND $nis!='')
						{
							echo"
							<SCRIPT TYPE='text/javascript'>
							window.alert('Data Progress belum ada, informasikan pada IT')
							</SCRIPT>";
		
							echo"<meta http-equiv=\"refresh\" content=\"1;url=guru.php\">\n";
						}

						$query ="	SELECT 		t_prgrptpg.*,t_setpgrpt.*,t_mstssw.nmassw
									FROM 		t_prgrptpg,t_setpgrpt,t_mstssw
									WHERE   	t_prgrptpg.nis='". mysql_escape_string($nis)."' AND
												t_prgrptpg.id=t_setpgrpt.id						AND
												t_setpgrpt.kdetkt='$kdetkt'						AND
												t_prgrptpg.nis=t_mstssw.nis
									ORDER BY	t_prgrptpg.nis,t_prgrptpg.id";
						$result =mysql_query($query);
					
						$i=0;
						while($data = mysql_fetch_array($result))
						{
							$cell[$i][0] 	=$data['nis'];
							$cell[$i][1] 	=$data['nmassw'];
							$cell[$i][2] 	=$data['id'];
							$cell[$i][3] 	=$data['lrnare'];
							$cell[$i][4] 	=$data["trm"."$nlitrm"];
							$cell[$i][5] 	=$data['kdeusr'];
							$i++;
						}
						$nmassw	=$cell[0][1].' ( '.$cell[0][0].' )';

						$query ="	SELECT 		t_attspcpg.*
									FROM 		t_attspcpg
									WHERE   	t_attspcpg.nis='". mysql_escape_string($nis)."'";
						$result =mysql_query($query);
						$data = mysql_fetch_array($result);
						$atttrm='atttrm'."$nlitrm";
						$atttrm=$data["$atttrm"];
						$spctrm='spctrm'."$nlitrm";
						$spctrm=$data["$spctrm"];

					echo"
					<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
						<B>Nama : $nmassw</B>
						<DIV style='overflow:auto;;width:100%;height:318px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD WIDTH='90%' HEIGHT='20'><CENTER>Learning Area</CENTER></TD>
									<TD WIDTH='10%'><CENTER>$trm			</CENTER></TD>
								</TR>";
								$j=0;
								while($j<$i)
								{
									$nis	='nis'.$j;
									$nisv	=$cell[$j][0];
									$id		='id'.$j;
									$idv	=$cell[$j][2];
									$lrnare	='lrnare'.$j;
									$lrnarevb=$cell[$j][3];
									$lrnarev=str_replace('/','',"$lrnarevb");
									$trmx	='trm'."$nlitrm".$j;
									$trmxv	=$cell[$j][4];
									$kdeusr	='kdeusr'.$j;
									$kdeusrv=$cell[$j][5];
									
									if(substr($lrnarevb,0,1)=='/')
									{
										echo"
										<TR bgcolor='E6E7E9'>
											<TD HEIGHT='25'><CENTER><B>$lrnarev</B></CENTER></TD>";
									}
									else
									{
										echo"
										<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
											<TD HEIGHT='25'>$lrnarevb 				</TD>";
									}
									if(substr($lrnarevb,0,1)=='/')
									{
										echo"
										<TD>&nbsp</TD>";
									}
									else
									{
										echo"
										<TD><CENTER><INPUT 	
													NAME		='$trmx'
													TYPE		='text'
													SIZE		='2'
													MAXLENGTH	='2'
													VALUE 		='$trmxv'
													ID 			='$trmx'
													ONKEYUP		='uppercase(this.id)'
													ONKEYPRESS	='return enter(this,event)'
													$isian1>
													<INPUT 	NAME='$id' TYPE='hidden' VALUE='$idv'>
											</CENTER>							
										</TD>";
									}
									echo"
									</TR>";
									$j++;
								}		
							echo"	
							</TABLE>
							<BR>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD COLSPAN='2' HEIGHT='20'><CENTER>Attitudes toward learning</CENTER></TD>
								</TR>
								<TR><TD HEIGHT='25' WIDTH=20%'>$trm</TD>
									<TD WIDTH='80%'><TEXTAREA 	NAME		='atttrm'
																ROWS		='5'
																cols       	='100'
																VALUE 		='$atttrm'
																ID			='atttrm'
																onchange	='uppercase(this.id)'
													$isian1>$atttrm</TEXTAREA>
									</TD>
								</TR>
							</TABLE>	
							<BR>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD COLSPAN='2' HEIGHT='20'><CENTER>Special Note</CENTER></TD>
								</TR>
								<TR><TD HEIGHT='25' WIDTH=20%'>$trm</TD>
									<TD WIDTH='80%'><TEXTAREA 	NAME		='spctrm'
																ROWS		='5'
																cols       	='100'
																VALUE 		='$spctrm'
																ID			='spctrm'
																onchange	='uppercase(this.id)'
													$isian1>$spctrm</TEXTAREA>
									</TD>
								</TR>
							</TABLE>	
						</DIV>
						<BR>";
						if ($pilihan=='detil' AND $nis!='')
						{
							echo"
							<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='guru.php?mode=R1D04A&kdekls=$kdekls&nis=$nisv&pilihan=edit'>";
							echo"
							<INPUT TYPE='button'	VALUE='Seting Term per kelas' 	onClick=window.location.href='guru.php?mode=R1D04A&kdekls=$kdekls&nis=$nisv&pilihan=seting'>";
						}	
						
						// tombol simpan (edit)
						if($pilihan=='edit' AND $nis!='')
						{
							echo"
							<INPUT TYPE='submit' 				VALUE='Simpan'>
							<INPUT TYPE='hidden' NAME='mode' 	VALUE='R1D04A_Save'>
							<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
							<INPUT TYPE='hidden' NAME='kdekls'	VALUE=$kdekls>
							<INPUT TYPE='hidden' NAME='nlitrm'	VALUE=$nlitrm>
							<INPUT TYPE='hidden' NAME='nis'		VALUE=$nisv>
							<INPUT TYPE='hidden' NAME='i'		VALUE=$i>";
						}

						if($pilihan=='seting')
						{
							echo"
							Seting Term  :
							<INPUT 	NAME		='trms'
									TYPE		='text'
									SIZE		='2'
									MAXLENGTH	='2'
									VALUE 		='$trms'
									ID			='trms'
									ONKEYUP		='uppercase(this.id)'
									ONKEYPRESS	='return enter(this,event)'
									$isian2></CENTER>
							<INPUT TYPE='submit' 					VALUE='Simpan'>
							<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04A_Save_Seting'>
							<INPUT TYPE='hidden' 	NAME='kdekls'	VALUE=$kdekls>
							<INPUT TYPE='hidden' 	NAME='nlitrm'	VALUE=$nlitrm>
							<INPUT TYPE='hidden' 	NAME='nis'		VALUE=$nisv>";
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
	function R1D04A_Save()
	{
  		$kdekls	=$_POST['kdekls'];
		$nlitrm	=$_POST['nlitrm'];
		$nis	=$_POST['nis'];
		$i		=$_POST['i'];
		$atttrm =$_POST['atttrm'];
		$spctrm =$_POST['spctrm'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

		$j=0;
		while($j<$i)
		{
			$id 	='id'.$j;
			$id		=$_POST["$id"]; 
			$trm 	="trm"."$nlitrm".$j;
			$trm	=$_POST["$trm"]; 

			$set	="	SET		t_prgrptpg.trm"."$nlitrm"."	='". mysql_escape_string($trm)."',
								t_prgrptpg.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_prgrptpg.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_prgrptpg.jamrbh	='". mysql_escape_string($jamrbh)."'";

			$query 	="	UPDATE 	t_prgrptpg ".$set.
					"	WHERE 	t_prgrptpg.nis	='". mysql_escape_string($nis)	."'	AND
								t_prgrptpg.id	='". mysql_escape_string($id)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));		
			$j++;
		}

		$set	="	SET		t_attspcpg.atttrm"."$nlitrm"."	='". mysql_escape_string($atttrm)."',
							t_attspcpg.spctrm"."$nlitrm"."	='". mysql_escape_string($spctrm)."',
							t_attspcpg.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_attspcpg.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_attspcpg.jamrbh	='". mysql_escape_string($jamrbh)."'";

		$query 	="	UPDATE 	t_attspcpg ".$set.
				"	WHERE 	t_attspcpg.nis	='". mysql_escape_string($nis)	."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));		

		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04A&kdekls=$kdekls&nis=$nis&pilihan=detil\">\n";
 	}		

	// -------------------------------------------------- Save Seting --------------------------------------------------
	function R1D04A_Save_Seting()
	{
		$kdekls	=$_POST['kdekls'];
  		$nis=$_POST['nis'];
  		$trms=$_POST['trms'];
		$nlitrm	=$_POST['nlitrm'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

		$set	="	SET		t_prgrptpg.trm"."$nlitrm"."	='". mysql_escape_string($trms)."',
							t_prgrptpg.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_prgrptpg.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_prgrptpg.jamrbh	='". mysql_escape_string($jamrbh)."'";

   		$query 	="	UPDATE 	t_prgrptpg,t_setpgrpt ".$set. 
				 " 	WHERE 	t_prgrptpg.nis	='". mysql_escape_string($nis)	."'	AND
							t_prgrptpg.id<200			AND
							t_prgrptpg.id=t_setpgrpt.id	AND
							left(t_setpgrpt.lrnare,1)!='/'";

		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));

		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04A&kdekls=$kdekls&nis=$nis&pilihan=detil\">\n";
 	}	
}//akhir class
?>