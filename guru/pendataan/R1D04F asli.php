<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04F.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT INDICATORS OF BEHAVIOUR
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Fclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04F_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
			
		$query	="	SELECT 		DISTINCT t_mstplj.kdeplj,t_mstplj.nmaplj
								FROM 		t_mstpng,t_mstplj
								WHERE		t_mstpng.kdegru='$kdekry' AND
											t_mstpng.kdeplj=t_mstplj.kdeplj  AND
											t_mstplj.str=''"; // menghasilkan subjek per guru
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><B>INPUT INDICATORS OF BEHAVIOUR PERFORMANCE</B></TD></TR>
			<TR></TR><TR></TR>
		</TABLE>
			
		<FORM ACTION='guru.php?mode=R1D04F' METHOD='post'>
			<DIV style='overflow:auto;width:25%;height:370px;padding-right:-2px;'>		
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
							<TD><CENTER><a href='guru.php?mode=R1D04F&kdeplj=$data[kdeplj]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>
		</FORM>";
 	}

	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04F()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

        $kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdeplj	=$_GET['kdeplj'];
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
		
		$query="	SELECT 			t_mstplj.*
					FROM 			t_mstplj
					WHERE 			t_mstplj.kdeplj='$kdeplj'"; // menghasilkan per subjek
		$result=mysql_query($query);
		$data=mysql_fetch_array($result);
		$nmaplj=$data[nmaplj];

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%' >
				<TR><TD COLSPAN='2'><B>INPUT INDICATORS OF BEHAVIOUR PERFORMANCE <span style='color: #FF0000;'>( $nmaplj )</span></B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='10%'>Class</TD>
  					<TD WIDTH='90%'>:
						<SELECT	NAME		='kdekls'
								ID			='kdekls'
								onkeypress	='return enter(this,event)'>
						<OPTION VALUE='' SELECTED>--Select--</OPTION>";
						$query2="	SELECT 			t_mstpng.*,t_mstkls.*
									FROM 			t_mstpng,t_mstkls
									WHERE 			t_mstpng.kdegru='$kdekry'	AND
													t_mstpng.kdeplj='$kdeplj'	AND
													t_mstpng.kdekls=t_mstkls.kdekls
									ORDER BY 		t_mstkls.kdeklm,t_mstpng.kdekls"; // menghasilkan kelas per guru
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
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04F'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						<INPUT TYPE='hidden' 	NAME='kdeplj'	VALUE=$kdeplj>
					</TD>
				</TR>
			</TABLE>
		</FORM>
		
		<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
			<TR>
				<TD WIDTH='30%' valign='top'>
					<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
						<DIV style='overflow:auto;;width:100%;height:330px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 8%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='80%'><CENTER>Name			</CENTER></TD>
									<TD WIDTH='12%'><CENTER>Detail			</CENTER></TD>
								</TR>";
								$query ="	SELECT 		t_mstssw.*
											FROM 		t_mstssw
											WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
														t_mstssw.str=''
											ORDER BY 	t_mstssw.nmassw"; // menghasilkan siswa per kelas
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
											<CENTER><a href='guru.php?mode=R1D04F&kdeplj=$kdeplj&kdekls=$kdekls&nis=$data[nis]'>
											<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
										</TD>
									</TR>";
								}
							echo"	
							</TABLE>	
						</DIV><BR>
						<INPUT TYPE='button' 	VALUE='Subject' 	onClick=window.location.href='guru.php?mode=R1D04F_Cari'>
					</FORM>
				</TD>
				
				<TD WIDTH='70%' valign='top'>";
					$nmassw='';
					if($nis!='')
					{
						$sms	='Semester';
						$query 	=mysql_query("	SELECT 		t_setthn.* 
												FROM 		t_setthn
												WHERE		t_setthn.set='$sms'"); // menghasilkan semester
						$data = mysql_fetch_array($query);
						$sms=$data[nli];
					
						$midtrm	='Mid Term';
						$query 	=mysql_query("	SELECT 		t_setthn.* 
												FROM 		t_setthn
												WHERE		t_setthn.set='$midtrm'"); // menghasilkan mid
						$data = mysql_fetch_array($query);
						$nlitrm=$data[nli];
						$midtrm=$midtrm.' '.$nlitrm;
		
						$query =mysql_query("	SELECT 		t_indbhvps.*
												FROM 		t_indbhvps
												WHERE   	t_indbhvps.nis='". mysql_escape_string($nis)."'	AND
															t_indbhvps.kdeplj='". mysql_escape_string($kdeplj)."'"); // menghasilkan nilai kepribadian per murid
						$data = mysql_fetch_array($query);
						if($data[nis]=='' AND $nis!='')
						{
							echo"
							<SCRIPT TYPE='text/javascript'>
							window.alert('Data Indicator belum ada, informasikan pada IT')
							</SCRIPT>";
		
							echo"<meta http-equiv=\"refresh\" content=\"1;url=guru.php\">\n";
						}

						$query ="	SELECT 		t_indbhvps.*,t_setpsbhv.*,t_mstssw.nmassw
									FROM 		t_indbhvps,t_setpsbhv,t_mstssw
									WHERE   	t_indbhvps.nis='". mysql_escape_string($nis)."' AND
												t_indbhvps.kdeplj='". mysql_escape_string($kdeplj)."'	AND
												t_indbhvps.id=t_setpsbhv.id						AND
												t_indbhvps.nis=t_mstssw.nis
									ORDER BY	t_indbhvps.nis,t_indbhvps.id"; // menghasilkan nilai kepribadian per murid
						$result =mysql_query($query);
					
						$i=0;
						while($data = mysql_fetch_array($result))
						{
							$cell[$i][0] 	=$data['nis'];
							$cell[$i][1] 	=$data['nmassw'];
							$cell[$i][2] 	=$data['id'];
							$cell[$i][3] 	=$data['indctring'];
							$cell[$i][4] 	=$data['indctrind'];
							$cell[$i][5] 	=$data["midtrm"."$sms"."$nlitrm"];
							$cell[$i][6] 	=$data['kdeusr'];
							$i++;
						}
						$nmassw	=$cell[0][1].' ( '.$cell[0][0].' )';
					echo"
					<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
						<B>Nama : $nmassw</B>
						<DIV style='overflow:auto;;width:100%;height:318px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
								<TR bgcolor='dedede'>
									<TD WIDTH='90%' HEIGHT='20'><CENTER>Indicator of Behaviour Performance</CENTER></TD>
									<TD WIDTH='10%'><CENTER>$midtrm			</CENTER></TD>
								</TR>";
								$j=0;
								while($j<$i)
								{
									$nis	='nis'.$j;
									$nisv	=$cell[$j][0];
									$id		='id'.$j;
									$idv	=$cell[$j][2];
									$indctring	='indctring'.$j;
									$indctringv=$cell[$j][3];
									$indctrindv=$cell[$j][4];
									$midtrmx='midtrm'."$sms"."$nlitrm".$j;
									$midtrmxv=$cell[$j][5];
									$kdeusr	='kdeusr'.$j;
									$kdeusrv=$cell[$j][6];
									
									echo"
									<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
										<TD HEIGHT='25'>$indctringv</TD>
										<TD><CENTER><INPUT 	
													NAME		='$midtrmx'
													TYPE		='text'
													SIZE		='2'
													MAXLENGTH	='2'
													VALUE 		='$midtrmxv'
													ID 			='$midtrmx'
													ONKEYUP		='uppercase(this.id)'
													ONKEYPRESS	='return enter(this,event)'
													$isian1>
													<INPUT 	NAME='$id' TYPE='hidden' VALUE='$idv'>
											</CENTER>							
										</TD>
									</TR>";
									$j++;
								}		
							echo"	
							</TABLE>
						</DIV>
						<BR>";
						if ($pilihan=='detil' AND $nis!='')
						{
							echo"
							<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='guru.php?mode=R1D04F&kdeplj=$kdeplj&kdekls=$kdekls&nis=$nisv&pilihan=edit'>";
							echo"
							<INPUT TYPE='button'	VALUE='Setting by Class' 	onClick=window.location.href='guru.php?mode=R1D04F&kdeplj=$kdeplj&kdekls=$kdekls&nis=$nisv&pilihan=seting'>";
							echo"
							<span style='color: #FF0000;'>Note : <b>A</b>-Excelent <b>B</b>-Good <b>C</b>-Sufficient <b>D</b>-Needs Improvement</span>";
						}	
						
						// tombol simpan (edit)
						if($pilihan=='edit' AND $nis!='')
						{
							echo"
							<INPUT TYPE='submit' 				VALUE='Simpan'>
							<INPUT TYPE='hidden' NAME='mode' 	VALUE='R1D04F_Save'>
							<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
							<INPUT TYPE='hidden' NAME='kdekls'	VALUE=$kdekls>
							<INPUT TYPE='hidden' NAME='kdeplj'	VALUE=$kdeplj>
							<INPUT TYPE='hidden' NAME='sms'		VALUE=$sms>
							<INPUT TYPE='hidden' NAME='nlitrm'	VALUE=$nlitrm>
							<INPUT TYPE='hidden' NAME='nis'		VALUE=$nisv>
							<INPUT TYPE='hidden' NAME='i'		VALUE=$i>";
						}

						if($pilihan=='seting')
						{
							echo"
							Seting Term  :
							<INPUT 	NAME		='midtrms'
									TYPE		='text'
									SIZE		='2'
									MAXLENGTH	='2'
									VALUE 		='$midtrms'
									ID			='midtrms'
									ONKEYUP		='uppercase(this.id)'
									ONKEYPRESS	='return enter(this,event)'
									$isian2></CENTER>
							<INPUT TYPE='submit' 					VALUE='Simpan'>
							<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04F_Save_Seting'>
							<INPUT TYPE='hidden' 	NAME='kdekls'	VALUE=$kdekls>
							<INPUT TYPE='hidden' 	NAME='kdeplj'	VALUE=$kdeplj>
							<INPUT TYPE='hidden' 	NAME='sms'		VALUE=$sms>
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
	function R1D04F_Save()
	{
  		$kdekls	=$_POST['kdekls'];
		$kdeplj	=$_POST['kdeplj'];
		$sms	=$_POST['sms'];
		$nlitrm	=$_POST['nlitrm'];
		$nis	=$_POST['nis'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

		$j=0;
		while($j<$i)
		{
			$id 	='id'.$j;
			$id		=$_POST["$id"]; 
			$midtrm 	="midtrm"."$sms"."$nlitrm".$j;
			$midtrm	=$_POST["$midtrm"]; 

			$set	="	SET		t_indbhvps.midtrm"."$sms"."$nlitrm"."	='". mysql_escape_string($midtrm)."',
								t_indbhvps.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_indbhvps.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_indbhvps.jamrbh	='". mysql_escape_string($jamrbh)."'";

			$query 	="	UPDATE 	t_indbhvps ".$set.
					"	WHERE 	t_indbhvps.nis	='". mysql_escape_string($nis)	."'	AND
								t_indbhvps.id	='". mysql_escape_string($id)	."'	AND
								t_indbhvps.kdeplj	='". mysql_escape_string($kdeplj)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));		
			$j++;
		}

		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04F&kdeplj=$kdeplj&kdekls=$kdekls&nis=$nis&pilihan=detil\">\n";
 	}		

	// -------------------------------------------------- Save Seting --------------------------------------------------
	function R1D04F_Save_Seting()
	{
		$kdekls	=$_POST['kdekls'];
		$kdeplj	=$_POST['kdeplj'];
  		$nis=$_POST['nis'];
  		$midtrms=$_POST['midtrms'];
		$sms	=$_POST['sms'];
		$nlitrm	=$_POST['nlitrm'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

		$set	="	SET		t_indbhvps.midtrm"."$sms"."$nlitrm"."	='". mysql_escape_string($midtrms)."',
							t_indbhvps.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_indbhvps.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_indbhvps.jamrbh	='". mysql_escape_string($jamrbh)."'";

   		$query 	="	UPDATE 	t_indbhvps ".$set. 
				 " 	WHERE 	t_indbhvps.nis	='". mysql_escape_string($nis)	."'	AND
							t_indbhvps.kdeplj	='". mysql_escape_string($kdeplj)	."'";

		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));

		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04F&kdeplj=$kdeplj&kdekls=$kdekls&nis=$nis&pilihan=detil\">\n";
 	}	
}//akhir class
?>