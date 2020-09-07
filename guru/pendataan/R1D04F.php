<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04F.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT Personality traits
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Fclass
{
	function R1D04F()
	{
		echo"<SCRIPT TYPE='ext/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$pilihan=$_GET['pilihan'];
		$sms='';
		$midtrm='';
		
		$thn_ajr	=$_GET['thn_ajr'];
		
		if( substr($kdekls,0,4)=='SHS-' )
		{
			$sms	='Semester';
			$query 	=mysql_query("	SELECT 		t_setthn_sma.* 
									FROM 		t_setthn_sma
									WHERE		t_setthn_sma.set='$sms'");// menghasilkan semester
			$data = mysql_fetch_array($query);
			$sms=$data[nli];
						
			$midtrm	='Mid Term';
			$query 	=mysql_query("	SELECT 		t_setthn_sma.* 
									FROM 		t_setthn_sma
									WHERE		t_setthn_sma.set='$midtrm'");// menghasilkan mid
			$data = mysql_fetch_array($query);
			$nlitrm=$data[nli];
			$midtrm=$midtrm.' '.$nlitrm;
		}
		else if( substr($kdekls,0,2)=='P-' )
		{
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
		}
		else if( substr($kdekls,0,4)=='JHS-' )
		{
			$sms	='Semester';
			$query 	=mysql_query("	SELECT 		t_setthn_smp.* 
									FROM 		t_setthn_smp
									WHERE		t_setthn_smp.set='$sms'");// menghasilkan semester
			$data = mysql_fetch_array($query);
			$sms=$data[nli];
						
			$midtrm	='Mid Term';
			$query 	=mysql_query("	SELECT 		t_setthn_smp.* 
									FROM 		t_setthn_smp
									WHERE		t_setthn_smp.set='$midtrm'");// menghasilkan mid
			$data = mysql_fetch_array($query);
			$nlitrm=$data[nli];
			$midtrm=$midtrm.' '.$nlitrm;
		}
		else
		{
			$sms	='Semester';
			$query 	=mysql_query("	SELECT 		t_setthn.* 
									FROM 		t_setthn
									WHERE		t_setthn.set='$sms'");// menghasilkan semester
			$data = mysql_fetch_array($query);
			$sms=$data[nli];
						
			$midtrm	='Mid Term';
			$query 	=mysql_query("	SELECT 		t_setthn.* 
									FROM 		t_setthn
									WHERE		t_setthn.set='$midtrm'");// menghasilkan mid
			$data = mysql_fetch_array($query);
			$nlitrm=$data[nli];
			$midtrm=$midtrm.' '.$nlitrm;
		}
		
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

		$query 	="	SELECT 		t_mstssw.*
					FROM 		t_mstssw
					WHERE 		t_mstssw.kdekls	='". mysql_escape_string($kdekls)."' AND 
								t_mstssw.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
								t_mstssw.str=''
					ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw";// menghasilkan siswa per kelas
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

			$query2	="	SELECT 		t_personps.*
						FROM 		t_personps
						WHERE 		t_personps.nis		='". mysql_escape_string($nis)."' AND 
									t_personps.thn_ajaran		='". mysql_escape_string($thn_ajr)."' "; // menghasilkan nilai kehadiran per siswa
			$result2 =mysql_query($query2);
			$data2 	 =mysql_fetch_array($result2);
			$cell[$i][2]=$data2['att'."$sms"."$nlitrm"];
			$cell[$i][3]=$data2['dil'."$sms"."$nlitrm"];
			$cell[$i][4]=$data2['ord'."$sms"."$nlitrm"];
			$cell[$i][5]=$data2['cle'."$sms"."$nlitrm"];
			
			$cell[$i][6]=$data2['spr'."$sms"."$nlitrm"];
			$cell[$i][7]=$data2['soc'."$sms"."$nlitrm"];
			$i++;
		}

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>INPUT Personality Traits & Behavior</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='10%'>Class</TD>
					<TD WIDTH='90%'>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>
						<OPTION VALUE='' SELECTED>--Select--</OPTION>";
						$query2="	SELECT 		*,t_mstkls.kdekls
									FROM 		t_prstkt,t_klmkls,t_mstkls
                                    WHERE      	t_prstkt.kdekry='". mysql_escape_string($kdekry)."' AND
												t_prstkt.kdetkt=t_klmkls.kdetkt AND
												(t_prstkt.kdejbt=200 OR t_prstkt.kdejbt=300 OR t_prstkt.kdejbt=900) AND
												t_klmkls.kdeklm=t_mstkls.kdeklm	AND
												(t_mstkls.wlikls='". mysql_escape_string($kdekry)."' OR t_prstkt.kdejbt=900)
									ORDER BY t_mstkls.kdeklm,t_mstkls.kdekls"; // menghasilkan per kelas						t_prstkt.kdejbt=200 OR 
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
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04F'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						<!--<INPUT TYPE='hidden' 	NAME='thnajr'	VALUE=$thnajr>-->
					</td>
				</tr>	
			</TABLE>
		</FORM>
		
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 3%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='25%'><CENTER>Name	    </CENTER></TD>
						<TD WIDTH='12%'><CENTER>Attitude (Kelakuan)	</CENTER></TD>
						<TD WIDTH='12%'><CENTER>Diligence/Discipline (Kerajinan/Kedisiplinan)	</CENTER></TD>
						<TD WIDTH='12%'><CENTER>Orderliness (Kerapihan)	</CENTER></TD>
						<TD WIDTH='12%'><CENTER>Cleanliness (Kebersihan)	</CENTER></TD>
						
						<TD WIDTH='12%'><CENTER>Spiritual Behavior	</CENTER></TD>
						<TD WIDTH='12%'><CENTER>Social Behavior	</CENTER></TD>
						
					</TR>";
					$j=0;
					$no=1;
					while($j<$i)
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nmassw'.$j;
						$nmav	=$cell[$j][1];
						
						$att	='att'."$sms"."$nlitrm".$j;
						$attv	=$cell[$j][2];
						$dil	='dil'."$sms"."$nlitrm".$j;
						$dilv	=$cell[$j][3];
						$ord	='ord'."$sms"."$nlitrm".$j;
						$ordv	=$cell[$j][4];
						$cle	='cle'."$sms"."$nlitrm".$j;
						$clev	=$cell[$j][5];
						
						$spr	='spr'."$sms"."$nlitrm".$j;
						$sprv	=$cell[$j][6];
						$soc	='soc'."$sms"."$nlitrm".$j;
						$socv	=$cell[$j][7];
				
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>$nmav</CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$att'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$attv'
										ID			='$att'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$dil'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$dilv'
										ID			='$dil'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$ord'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$ordv'
										ID			='$ord'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$cle'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$clev'
										ID			='$cle'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
							
							<TD><CENTER>
								<INPUT 	NAME		='$spr'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$sprv'
										ID			='$spr'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$soc'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$socv'
										ID			='$soc'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
					
							
						</TR>";

						$j++;
						$no++;
					}		
				echo"	
				</TABLE>	
			</DIV>
			<BR>";

			// pilihan tombol pilihan
			if ($pilihan=='detil'  AND $kdekls!='')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='guru.php?mode=R1D04F&kdekls=$kdekls&pilihan=edit&thn_ajr=$thn_ajr'>";
				//
				
			}	
				
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04F_Save'>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<INPUT TYPE='hidden' NAME='thn_ajr'		VALUE=$thn_ajr>
				<INPUT TYPE='hidden' NAME='sms'			VALUE=$sms>
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE=$nlitrm>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}

			// tombol simpan (komentar)
			

						// tombol simpan (komentar)
			

			echo"
		</FORM>";
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04F_Save()
	{
		$kdekls	=$_POST['kdekls'];
		$thn_ajr=$_POST['thn_ajr'];
		$sms	=$_POST['sms'];
		$nlitrm	=$_POST['nlitrm'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
			
			$att 	="att"."$sms"."$nlitrm".$j;
			$att	=$_POST["$att"]; 
			$dil 	="dil"."$sms"."$nlitrm".$j;
			$dil	=$_POST["$dil"]; 
			$ord 	="ord"."$sms"."$nlitrm".$j;
			$ord	=$_POST["$ord"]; 
			$cle 	="cle"."$sms"."$nlitrm".$j;
			$cle	=$_POST["$cle"]; 
			
			$spr 	="spr"."$sms"."$nlitrm".$j;
			$spr	=$_POST["$spr"]; 
			$soc 	="soc"."$sms"."$nlitrm".$j;
			$soc	=$_POST["$soc"]; 

			$set	="	SET		t_personps.nis		='". mysql_escape_string($nis)."',
								t_personps.thn_ajaran		='". mysql_escape_string($thn_ajr)."',
								t_personps.att"."$sms"."$nlitrm"."	='". mysql_escape_string($att)."',
								t_personps.dil"."$sms"."$nlitrm"."	='". mysql_escape_string($dil)."',
								t_personps.ord"."$sms"."$nlitrm"."	='". mysql_escape_string($ord)."',
								t_personps.cle"."$sms"."$nlitrm"."	='". mysql_escape_string($cle)."',
								
								t_personps.spr"."$sms"."$nlitrm"."	='". mysql_escape_string($spr)."',
								t_personps.soc"."$sms"."$nlitrm"."	='". mysql_escape_string($soc)."',
								t_personps.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_personps.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_personps.jamrbh	='". mysql_escape_string($jamrbh)."'"; 

			$query	="	SELECT 		t_personps.*
						FROM 		t_personps
						WHERE 		t_personps.nis	='". mysql_escape_string($nis)."' AND 
									t_personps.thn_ajaran	='". mysql_escape_string($thn_ajr)."' ";
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_personps ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
			}
			else
			{
				$query 	="	UPDATE 	t_personps ".$set.
						"	WHERE 	t_personps.nis	='". mysql_escape_string($nis)	."' AND 
									t_personps.thn_ajaran	='". mysql_escape_string($thn_ajr)	."' ";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			}	
			$j++;
		}
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04F&kdekls=$kdekls&nis=$nis&pilihan=detil&thn_ajr=$thn_ajr\">\n";
 	}		

	// -------------------------------------------------- Save komentar --------------------------------------------------
			

	// -------------------------------------------------- Save kenaikan --------------------------------------------------
			
	
}//akhir class
?>