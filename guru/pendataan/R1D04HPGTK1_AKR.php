<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04HPGTK1_AKR.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT PROGRESS REPORT
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04HPGTK1_AKRclass
{
	function R1D04HPGTK1_AKR()
	{
		echo"<SCRIPT TYPE='ext/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$pilihan=$_GET['pilihan'];
		$sms='';
		$midtrm='';
		
		
		//else
		//{
			$sms	='Semester';
			$query 	=mysql_query("	SELECT 		t_setthn_tk.* 
									FROM 		t_setthn_tk
									WHERE		t_setthn_tk.set='$sms'");// menghasilkan semester
			$data = mysql_fetch_array($query);
			$sms=$data[nli];
						
			$midtrm	='Mid Term';
			$query 	=mysql_query("	SELECT 		t_setthn_tk.* 
									FROM 		t_setthn_tk
									WHERE		t_setthn_tk.set='$midtrm'");// menghasilkan mid
			$data = mysql_fetch_array($query);
			$nlitrm=$data[nli];
			$midtrm=$midtrm.' '.$nlitrm;
		//}
		
		if($pilihan=='')
			$pilihan='detil';

		switch($pilihan)
		{
			case 'detil':
				$isian1	='disabled';
				$isian2	='disabled';
				$isian3	='disabled';
				break;
			
			case 'komentar':
				$isian1	='disabled';
				$isian2	='enable';
				$isian3	='disabled';
				break;
				
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

			$query2	="	SELECT 		t_hdrkmnps_pgtk1_akr.*
						FROM 		t_hdrkmnps_pgtk1_akr
						WHERE 		t_hdrkmnps_pgtk1_akr.nis		='". mysql_escape_string($nis)."'	"; // menghasilkan nilai kehadiran per siswa
			$result2 =mysql_query($query2);
			$data2 	 =mysql_fetch_array($result2);
			$cell[$i][5]=$data2['kmn'."$sms"."$nlitrm"];
			
			
			$i++;
		}

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>INPUT NARASI (I. NILAI-NILAI MORAL DAN AGAMA)</B></TD></TR>
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
							$kls = '';
							
							if($data[kdekls]=='PG1')
								$kls = 'Pre-K1';
							else if($data[kdekls]=='PG2')
								$kls = 'Pre-K2';
							else
								$kls = $data[kdekls];
							
							if ($kdekls==$data[kdekls])
								echo"<OPTION VALUE='$data[kdekls]' SELECTED>$kls</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdekls]'>$kls</OPTION>";
						}
						echo"
						</SELECT>
						<INPUT TYPE='submit' 					VALUE='View'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04HPGTK1_AKR'>
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
						<TD WIDTH='22%'><CENTER>Name	    </CENTER></TD>
						
						<TD WIDTH='45%'><CENTER>Comment</CENTER></TD>
						
					</TR>";
					$j=0;
					$no=1;
					while($j<$i)
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nmassw'.$j;
						$nmav	=$cell[$j][1];
						
						$kmn	='kmn'."$sms"."$nlitrm".$j;
						$kmnv	=$cell[$j][5];
						
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>$nmav</CENTER></TD>
							
							<TD><CENTER>
								<INPUT 	NAME		='$kmn'
										TYPE		='text'
										SIZE		='120'
										VALUE 		='$kmnv'
										ID			='$kmn'
										ONKEYPRESS	='return enter(this,event)'
										$isian2></CENTER>
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
				<INPUT TYPE='button'	VALUE='Edit Comment' 	onClick=window.location.href='guru.php?mode=R1D04HPGTK1_AKR&kdekls=$kdekls&pilihan=komentar'>";
				
			}	
				
			
			// tombol simpan (komentar)
			if($pilihan=='komentar')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04HPGTK1_AKR_Save_Komentar'>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<INPUT TYPE='hidden' NAME='sms'			VALUE=$sms>
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE=$nlitrm>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}

			
			echo"
		</FORM>";
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	//function R1D04HPGTK1_AKR_Save()
	
	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04HPGTK1_AKR_Save_Komentar()
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
			$kmn 	="kmn"."$sms"."$nlitrm".$j;
			$kmn	=$_POST["$kmn"]; 
			$kmn	=str_replace("'","`","$kmn");

			$set	="	SET		t_hdrkmnps_pgtk1_akr.nis		='". mysql_escape_string($nis)."',
								t_hdrkmnps_pgtk1_akr.kmn"."$sms"."$nlitrm"."	='". mysql_escape_string($kmn)."',
								t_hdrkmnps_pgtk1_akr.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_hdrkmnps_pgtk1_akr.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_hdrkmnps_pgtk1_akr.jamrbh	='". mysql_escape_string($jamrbh)."'"; 

			$query	="	SELECT 		t_hdrkmnps_pgtk1_akr.*
						FROM 		t_hdrkmnps_pgtk1_akr
						WHERE 		t_hdrkmnps_pgtk1_akr.nis	='". mysql_escape_string($nis)."'";
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_hdrkmnps_pgtk1_akr ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
			}
			else
			{
				$query 	="	UPDATE 	t_hdrkmnps_pgtk1_akr ".$set.
						"	WHERE 	t_hdrkmnps_pgtk1_akr.nis	='". mysql_escape_string($nis)	."'";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			}	
			$j++;
		}
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04HPGTK1_AKR&kdekls=$kdekls&nis=$nis&pilihan=detil\">\n";
 	}		

	// -------------------------------------------------- Save --------------------------------------------------
	//function R1D04HPGTK1_AKR_Save_Kenaikan()
	
}//akhir class
?>