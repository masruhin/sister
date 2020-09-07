<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04FSMP.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT Personality traits
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04FSMPclass
{
	function R1D04FSMP()
	{
		echo"<SCRIPT TYPE='ext/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$pilihan=$_GET['pilihan'];

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

			$query2	="	SELECT 		t_sprtbhvps.*
						FROM 		t_sprtbhvps
						WHERE 		t_sprtbhvps.nis		='". mysql_escape_string($nis)."'	"; // menghasilkan nilai kehadiran per siswa
			$result2 =mysql_query($query2);
			$data2 	 =mysql_fetch_array($result2);
			$cell[$i][2]=$data2['spr'."$sms"."$nlitrm"];
			$cell[$i][3]=$data2['des'."$sms"."$nlitrm"];
			
			$i++;
		}

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>INPUT Spiritual Behaviour</B></TD></TR>
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
												(t_prstkt.kdejbt=300 OR t_prstkt.kdejbt=900) AND
												t_klmkls.kdeklm=t_mstkls.kdeklm	AND
												(t_mstkls.wlikls='". mysql_escape_string($kdekry)."' OR t_prstkt.kdejbt=900)
									ORDER BY t_mstkls.kdeklm,t_mstkls.kdekls"; // menghasilkan per kelas
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
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04FSMP'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
					</TD>	
              	</TR>				
			</TABLE>
		</FORM>
		
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 3%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='25%'><CENTER>Name	    </CENTER></TD>
						<TD WIDTH='18%'><CENTER>Letter Grade	</CENTER></TD>
						<TD WIDTH='48%'><CENTER>Description	</CENTER></TD>
						
					</TR>";
					$j=0;
					$no=1;
					while($j<$i)
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nmassw'.$j;
						$nmav	=$cell[$j][1];
						$spr	='spr'."$sms"."$nlitrm".$j;
						$sprv	=$cell[$j][2];
						
						$des	='des'."$sms"."$nlitrm".$j;
						$desv	=$cell[$j][3];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>$nmav</CENTER></TD>
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
								<INPUT 	NAME		='$des'
										TYPE		='text'
										SIZE		='100'
										MAXLENGTH	='200'
										VALUE 		='$desv'
										ID			='$des'
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
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='guru.php?mode=R1D04FSMP&kdekls=$kdekls&pilihan=edit'>";
				//
				
			}	
				
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04FSMP_Save'>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
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
	function R1D04FSMP_Save()
	{
		$kdekls	=$_POST['kdekls'];
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
			$spr 	="spr"."$sms"."$nlitrm".$j;
			$spr	=$_POST["$spr"]; 
			
			$des 	="des"."$sms"."$nlitrm".$j;
			$des	=$_POST["$des"]; 

			$set	="	SET		t_sprtbhvps.nis		='". mysql_escape_string($nis)."',
								t_sprtbhvps.spr"."$sms"."$nlitrm"."	='". mysql_escape_string($spr)."',
								t_sprtbhvps.des"."$sms"."$nlitrm"."	='". mysql_escape_string($des)."',
								
								t_sprtbhvps.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_sprtbhvps.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_sprtbhvps.jamrbh	='". mysql_escape_string($jamrbh)."'"; 

			$query	="	SELECT 		t_sprtbhvps.*
						FROM 		t_sprtbhvps
						WHERE 		t_sprtbhvps.nis	='". mysql_escape_string($nis)."'";
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_sprtbhvps ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
			}
			else
			{
				$query 	="	UPDATE 	t_sprtbhvps ".$set.
						"	WHERE 	t_sprtbhvps.nis	='". mysql_escape_string($nis)	."'";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			}	
			$j++;
		}
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04FSMP&kdekls=$kdekls&nis=$nis&pilihan=detil\">\n";
 	}		

	// -------------------------------------------------- Save komentar --------------------------------------------------
			

	// -------------------------------------------------- Save kenaikan --------------------------------------------------
			
	
}//akhir class
?>