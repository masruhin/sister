<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04H.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT PROGRESS REPORT
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Hclass
{
	function R1D04H()
	{
		echo"<SCRIPT TYPE='ext/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$pilihan=$_GET['pilihan'];
		$sms='';
		$midtrm='';
		
		//$thn_ajr	=$_GET['thn_ajr'];
		
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
			case 'komentar':
				$isian1	='disabled';
				$isian2	='enable';
				$isian3	='disabled';
				break;
			case 'kenaikan':
				$isian1	='disabled';
				$isian2	='disabled';
				$isian3	='enable';
				break;
				
		}		

		$query 	="	SELECT 		t_mstssw.*
					FROM 		t_mstssw
					WHERE 		t_mstssw.kdekls	='". mysql_escape_string($kdekls)."' AND 
								
								t_mstssw.str=''
					ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw";//t_mstssw.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					// menghasilkan siswa per kelas
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

			$query2	="	SELECT 		t_hdrkmnps.*
						FROM 		t_hdrkmnps
						WHERE 		t_hdrkmnps.nis		='". mysql_escape_string($nis)."'  "; //AND t_hdrkmnps.thn_ajaran		='". mysql_escape_string($thn_ajr)."'
						// menghasilkan nilai kehadiran per siswa
			$result2 =mysql_query($query2);
			$data2 	 =mysql_fetch_array($result2);
			$cell[$i][2]=$data2['skt'."$sms"."$nlitrm"];
			$cell[$i][3]=$data2['izn'."$sms"."$nlitrm"];
			$cell[$i][4]=$data2['alp'."$sms"."$nlitrm"];
			$cell[$i][5]=$data2['kmn'."$sms"."$nlitrm"];
			$cell[$i][6]=$data2['kenaikan'."$sms"."$nlitrm"];
			
			$i++;
		}

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>INPUT ABSENCES (PS)<!--& COMMENT--></B></TD></TR>
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
						<INPUT TYPE='submit' 					VALUE='View'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04H'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
					</TD>	
              	</TR>				
				<!--<tr>
					<td>Tahun Pelajaran</td><td> : 
						
						<input type='text' NAME='thn_ajr' ID='thn_ajr' value='2018-2019' readonly/>
						<INPUT TYPE='submit' 					VALUE='View'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04H'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						
					</td>
				</tr>-->	
			</TABLE>
		</FORM>
		
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 3%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='22%'><CENTER>Name	    </CENTER></TD>
						<TD WIDTH='5%'><CENTER>Sick	</CENTER></TD>
						<TD WIDTH='5%'><CENTER>Permit	</CENTER></TD>
						<TD WIDTH='5%'><CENTER>Alpha	</CENTER></TD>
						<TD WIDTH='5%'><CENTER>Total	</CENTER></TD>
						<TD WIDTH='45%'><CENTER>Comment</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Promoted</CENTER></TD>
					</TR>";
					$j=0;
					$no=1;
					while($j<$i)
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nmassw'.$j;
						$nmav	=$cell[$j][1];
						$skt	='skt'."$sms"."$nlitrm".$j;
						$sktv	=$cell[$j][2];
						$izn	='izn'."$sms"."$nlitrm".$j;
						$iznv	=$cell[$j][3];
						$alp	='alp'."$sms"."$nlitrm".$j;
						$alpv	=$cell[$j][4];
						$ttlv	=$sktv+$iznv+$alpv;
						$kmn	='kmn'."$sms"."$nlitrm".$j;
						$kmnv	=$cell[$j][5];
						$kenaikan	='kenaikan'."$sms"."$nlitrm".$j;
						$kenaikanv	=$cell[$j][6];
				
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>$nmav</CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$skt'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$sktv'
										ID			='$skt'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$izn'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$iznv'
										ID			='$izn'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$alp'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$alpv'
										ID			='$alp'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
							<TD><CENTER>$ttlv</CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$kmn'
										TYPE		='text'
										SIZE		='120'
										VALUE 		='$kmnv'
										ID			='$kmn'
										ONKEYPRESS	='return enter(this,event)'
										$isian2></CENTER>
							</TD>
					<TD>
						<INPUT NAME			='$kenaikan'
								TYPE		='radio'
								VALUE 		='Y'
								ID			='$kenaikan'";
						if("$kenaikanv"=='Y')
							echo"checked";
							echo" $isian3> Yes
						<INPUT 	NAME		='$kenaikan'
								TYPE		='radio'
								VALUE 		='T'
								ID			='$kenaikan'";
						if("$kenaikanv"=='T')
							echo"checked";
							echo" $isian3> No
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
				<INPUT TYPE='button'	VALUE='Edit Attenance' 	onClick=window.location.href='guru.php?mode=R1D04H&kdekls=$kdekls&pilihan=edit'>";//&thn_ajr=$thn_ajr
				echo"
				<INPUT TYPE='button'	VALUE='Edit Comment' 	onClick=window.location.href='guru.php?mode=R1D04H&kdekls=$kdekls&pilihan=komentar'>";//&thn_ajr=$thn_ajr
				echo"
				<INPUT TYPE='button'	VALUE='Edit Promoted' 	onClick=window.location.href='guru.php?mode=R1D04H&kdekls=$kdekls&pilihan=kenaikan'>";//&thn_ajr=$thn_ajr
			}	
				
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04H_Save'>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<!--<INPUT TYPE='hidden' NAME='thn_ajr'		VALUE=$thn_ajr>-->
				<INPUT TYPE='hidden' NAME='sms'			VALUE=$sms>
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE=$nlitrm>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}

			// tombol simpan (komentar)
			if($pilihan=='komentar')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04H_Save_Komentar'>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<!--<INPUT TYPE='hidden' NAME='thn_ajr'		VALUE=$thn_ajr>-->
				<INPUT TYPE='hidden' NAME='sms'			VALUE=$sms>
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE=$nlitrm>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}

						// tombol simpan (komentar)
			if($pilihan=='kenaikan')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04H_Save_Kenaikan'>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<!--<INPUT TYPE='hidden' NAME='thn_ajr'		VALUE=$thn_ajr>-->
				<INPUT TYPE='hidden' NAME='sms'			VALUE=$sms>
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE=$nlitrm>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}

			echo"
		</FORM>";
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04H_Save()
	{
		$kdekls	=$_POST['kdekls'];
		$sms	=$_POST['sms'];
		$nlitrm	=$_POST['nlitrm'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		
		//$thn_ajr	=$_POST['thn_ajr'];

		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
			$skt 	="skt"."$sms"."$nlitrm".$j;
			$skt	=$_POST["$skt"]; 
			$izn 	="izn"."$sms"."$nlitrm".$j;
			$izn	=$_POST["$izn"]; 
			$alp 	="alp"."$sms"."$nlitrm".$j;
			$alp	=$_POST["$alp"]; 

			$set	="	SET		t_hdrkmnps.nis		='". mysql_escape_string($nis)."',
								
								t_hdrkmnps.skt"."$sms"."$nlitrm"."	='". mysql_escape_string($skt)."',
								t_hdrkmnps.izn"."$sms"."$nlitrm"."	='". mysql_escape_string($izn)."',
								t_hdrkmnps.alp"."$sms"."$nlitrm"."	='". mysql_escape_string($alp)."',
								t_hdrkmnps.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_hdrkmnps.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_hdrkmnps.jamrbh	='". mysql_escape_string($jamrbh)."'"; //t_hdrkmnps.thn_ajaran		='". mysql_escape_string($thn_ajr)."',

			$query	="	SELECT 		t_hdrkmnps.*
						FROM 		t_hdrkmnps
						WHERE 		t_hdrkmnps.nis	='". mysql_escape_string($nis)."'  ";  //AND t_hdrkmnps.thn_ajaran	='". mysql_escape_string($thn_ajr)."'
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_hdrkmnps ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
			}
			else
			{
				$query 	="	UPDATE 	t_hdrkmnps ".$set.
						"	WHERE 	t_hdrkmnps.nis	='". mysql_escape_string($nis)	."'  ";//AND t_hdrkmnps.thn_ajaran	='". mysql_escape_string($thn_ajr)."'
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			}	
			$j++;
		}
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04H&kdekls=$kdekls&nis=$nis&pilihan=detil\">\n";//&thn_ajr=$thn_ajr
 	}		

	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04H_Save_Komentar()
	{
		$kdekls	=$_POST['kdekls'];
		$sms	=$_POST['sms'];
		$nlitrm	=$_POST['nlitrm'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		
		//$thn_ajr	=$_POST['thn_ajr'];

		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
			$kmn 	="kmn"."$sms"."$nlitrm".$j;
			$kmn	=$_POST["$kmn"]; 
			$kmn	=str_replace("'","`","$kmn");

			$set	="	SET		t_hdrkmnps.nis		='". mysql_escape_string($nis)."',
								
								t_hdrkmnps.kmn"."$sms"."$nlitrm"."	='". mysql_escape_string($kmn)."',
								t_hdrkmnps.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_hdrkmnps.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_hdrkmnps.jamrbh	='". mysql_escape_string($jamrbh)."'"; //t_hdrkmnps.thn_ajaran		='". mysql_escape_string($thn_ajr)."',

			$query	="	SELECT 		t_hdrkmnps.*
						FROM 		t_hdrkmnps
						WHERE 		t_hdrkmnps.nis	='". mysql_escape_string($nis)."'  ";  //AND t_hdrkmnps.thn_ajaran	='". mysql_escape_string($thn_ajr)."'
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_hdrkmnps ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
			}
			else
			{
				$query 	="	UPDATE 	t_hdrkmnps ".$set.
						"	WHERE 	t_hdrkmnps.nis	='". mysql_escape_string($nis)	."' 	";//AND t_hdrkmnps.thn_ajaran	='". mysql_escape_string($thn_ajr)	."'
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			}	
			$j++;
		}
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04H&kdekls=$kdekls&nis=$nis&pilihan=detil\">\n";//&thn_ajr=$thn_ajr
 	}		

	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04H_Save_Kenaikan()
	{
		$kdekls	=$_POST['kdekls'];
		$sms	=$_POST['sms'];
		$nlitrm	=$_POST['nlitrm'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		
		//$thn_ajr	=$_POST['thn_ajr'];

		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
			$kenaikan 	="kenaikan"."$sms"."$nlitrm".$j;
			$kenaikan	=$_POST["$kenaikan"]; 
			$kenaikan	=str_replace("'","`","$kenaikan");

			$set	="	SET		t_hdrkmnps.nis		='". mysql_escape_string($nis)."',
								
								t_hdrkmnps.kenaikan"."$sms"."$nlitrm"."	='". mysql_escape_string($kenaikan)."',
								t_hdrkmnps.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_hdrkmnps.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_hdrkmnps.jamrbh	='". mysql_escape_string($jamrbh)."'"; //t_hdrkmnps.thn_ajaran		='". mysql_escape_string($thn_ajr)."',

			$query	="	SELECT 		t_hdrkmnps.*
						FROM 		t_hdrkmnps
						WHERE 		t_hdrkmnps.nis	='". mysql_escape_string($nis)."'  ";  //AND t_hdrkmnps.thn_ajaran	='". mysql_escape_string($thn_ajr)."'
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_hdrkmnps ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
			}
			else
			{
				$query 	="	UPDATE 	t_hdrkmnps ".$set.
						"	WHERE 	t_hdrkmnps.nis	='". mysql_escape_string($nis)	."'  ";//AND t_hdrkmnps.thn_ajaran	='". mysql_escape_string($thn_ajr)	."'
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			}	
			$j++;
		}
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04H&kdekls=$kdekls&nis=$nis&pilihan=detil\">\n";//&thn_ajr=$thn_ajr
 	}		
	
}//akhir class
?>