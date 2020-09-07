<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04XSD.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT PROGRESS REPORT			sd
//----------------------------------------------------------------------------------------------------
echo"
<html>
<style>
	.tooltip {
	  position: relative;
	  display: inline-block;
	  border-bottom: 1px dotted black;
	}

	.tooltip .tooltiptext {
	  visibility: hidden;
	  width: 250px;
	  background-color: lightblue;
	  color: #fff;
	  text-align: left;
	  border-radius: 6px;
	  padding: 5px 0;

	  /* Position the tooltip */
	  position: absolute;
	  z-index: 1;
	}

	.tooltip:hover .tooltiptext {
	  visibility: visible;
	}
</style>
<body>
";



if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04XSDclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04XSD_Cari()
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
			<TR><TD><B>INPUT LEARNING RECORD (PS) LO Score</B></TD></TR>
			<TR></TR><TR></TR>
		</TABLE>
			
		<FORM ACTION='guru.php?mode=R1D04XSD' METHOD='post'>
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
							<TD><CENTER><a href='guru.php?mode=R1D04XSD&kdeplj=$data[kdeplj]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>
		</FORM>";
 	}
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	
	// -------------------------------------------------- Layar Utama --------------------------------------------------	
	function R1D04XSD()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$kdeplj	=$_GET['kdeplj'];
		//$kdetkt	=$_GET['kdetkt']; // namabahbuatan
		$pilihan=$_GET['pilihan'];
		$kolom1	=$_GET['kolom1'];
		$kolom2	=$_GET['kolom2'];
		
		//$thn_ajr	=$_GET['thn_ajr'];

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
					while($y<26)
					{
						$isianhw[$y]='disabled';
						$y++;
					}
					
					break;
				case 'edit':
					$y=1;
					while($y<26)
					{
						if($kolom1=='hw' and $kolom2=="$y")
							$isianhw[$y]='enable';
						else	
							$isianhw[$y]='disabled';
						
						$y++;
					}
					
					break;
			}		
		//}
		
		// akhisr buatan
		
		

		$query 	="	SELECT 		t_mstssw.*
					FROM 		t_mstssw
					WHERE 		t_mstssw.kdekls	='". mysql_escape_string($kdekls)."'	AND
								
								t_mstssw.str=''
					ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; 
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
			
			//echo"$nis	<br/>$thn_ajr	<br/>$kdeplj";
			
			// awal buatan
			
			//if($kdetkt=='PS')
			//{
				$query2	="	SELECT 		t_learnrcd_sd.*
						FROM 		t_learnrcd_sd
						WHERE 		t_learnrcd_sd.nis		='". mysql_escape_string($nis)."' AND
									
									t_learnrcd_sd.kdeplj	='". mysql_escape_string($kdeplj)."' ";//t_learnrcd_sd.thn_ajaran		='". mysql_escape_string($thn_ajr)."' AND
				//t_learnrcd_sd.nis		='". mysql_escape_string($kdekls)."' AND
				$result2 =mysql_query($query2);
				$data2 	 =mysql_fetch_array($result2);
				$y=1;
				while($y<26)
				{
					$cell[$i][$y+1]=$data2['hw'."$sms"."$nlitrm"."$y"];
					$cellY[$i][$y+1]=$data2['hw'."$sms"."$nlitrm"."$y"];
					
					//$str	= $cell[$i][$y+1];
					//echo"$str<br/>";
					
					$y++;
				}
				
				//$str	= $cell[0][4];
				
				//echo"$str";
				
				/*$qry2 	="	SELECT 		t_lrcd.*
								FROM 		t_lrcd 
								WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd.kde LIKE '". mysql_escape_string($kdeplj)."%' ";
				$rslt2 =mysql_query($qry2);
				$yes=1;
				while( $dta2=mysql_fetch_array($rslt2) )
				{
					$cell[$yes][4] = $dta2[nmektr];
					$yes++;
				}*/
				
				
				
				
				
				$rslt2='';
				$qry2 	="	SELECT 		t_learnrcd.*
							FROM 		t_learnrcd 
							WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
										
										t_learnrcd.kde LIKE '". mysql_escape_string($kdeplj)."%'
							ORDER BY	t_learnrcd.kdekls, t_learnrcd.kde
							";
				$rslt2 =mysql_query($qry2);
				if(mysql_num_rows($rslt2)=='0')
				{
					$qry2 	="	SELECT 		t_lrcd.*
							FROM 		t_lrcd 
							WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
										t_lrcd.kde LIKE '". mysql_escape_string($kdeplj)."%' 
							ORDER BY	t_lrcd.nourut			
							";
					$rslt2 =mysql_query($qry2);
				}
				$yes=1;
				while( $dta2=mysql_fetch_array($rslt2) )
				{
					//$cell[$yes][4] = $dta2[nmektr];
					$cell[$yes][4] = $dta2['nmektr'."$sms"."$nlitrm"];
					$yes++;
				}
				
				
				
				
				$i++;
			//}
			
			// akhir buatan
			
				
				
			
			
		}

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>INPUT LEARNING RECORD (PS) LO Score <span style='color: #FF0000;'>( $nmaplj )</span></B></TD></TR>
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
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04XSD'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						<INPUT TYPE='hidden' 	NAME='kdeplj'	VALUE=$kdeplj>
						
					</TD>	
              	</TR>
				<!--<tr>
					<td>Tahun Pelajaran</td><td> : 
						
						<input type='text' NAME='thn_ajr' ID='thn_ajr' value='2018-2019' readonly/>
						<INPUT TYPE='submit' 					VALUE='View'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04XSD'>
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
						<TD WIDTH='78%' COLSPAN='$yes' HEIGHT='30'><CENTER>Learning Objectives	    	</CENTER></TD>";//ROWSPAN='2' HEIGHT='20'
					
					echo"	
					</TR>
					<TR bgcolor='dedede'>";
						$y=1;
						while($y<$yes)
						{
							$nmektr=$cell[$y][4];
							echo"<TD WIDTH='4%' HEIGHT='20' title='$nmektr'><CENTER>$nmektr </CENTER></TD>";//substr($nmektr,0,1)
							$y++;
						}
					echo"
					</tr>
					<TR bgcolor='dedede'>";
						if ($pilihan=='detil'  AND $kdekls!='')
						{
							$y=1;
							while($y<$yes)
							{
								$nmektr=$cell[$y][4];
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER><a href='guru.php?mode=R1D04XSD&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=hw&kolom2=$y' title='$nmektr'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}	
							
						}
						else
						{
							$y=1;
							while($y<$yes)
							{
								$nmektr=$cell[$y][4];
								echo"<TD WIDTH='4%' HEIGHT='20' title='$nmektr'><CENTER>$y	</CENTER></TD>";
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
							while($y<$yes)
							{
								$hw		='hw'."$sms"."$nlitrm"."$y"."$j";
								$hwv	=$cellY[$j][$y+1];
								//$hwv	=$cell[$j][$y+1];
								
								//echo"$hwv<br/>";
								
								// awal buatan
								if ($hwv==0)
									$hwv='';
								// khir buatan
								
								$nmektr=$cell[$y][4];
								
								
								
								echo"
								<TD><CENTER>
										<div class='tooltip'>
										
											<INPUT 	NAME		='$hw'
													TYPE		='text'
													SIZE		='3'
													MAXLENGTH	='3'
													VALUE 		='$hwv'
													ID			='$hw'
													ONKEYUP		='formatangka(this);'	
													ONKEYPRESS	='return enter(this,event)'
													
													$isianhw[$y]/>
													
													
										
										  <span class='tooltiptext'>
											<table width='100%'>
												<tr>
													<td width='2%'>
														LO
													</td>
													<td width='1%'>
														:
													</td>
													<td>
														 $nmektr
													</td>
												</tr>
											</table>
											
											<br/>
											
											<table width='100%'>
												<tr>
													<td width='2%'>
														SN
													</td>
													<td width='1%'>
														:
													</td>
													<td>
														$nmav
													</td>
												</tr>
											</table>
											
											<br/>			
											
											<table border='1' style='' width='100%'>
												<tr>
													<th align='center'>
														Symbol
													</th>
													<th align='center'>
														Interpretation
													</th>
												</tr>
												<tr>
													<td align='center'>
														5
													</td>
													<td>
														Exceeds expectation
													</td>
												</tr>
												<tr>
													<td align='center'>
														4
													</td>
													<td>
														Meets expectation
													</td>
												</tr>
												<tr>
													<td align='center'>
														3
													</td>
													<td>
														Progressing in the desired competency
													</td>
												</tr>
												<tr>
													<td align='center'>
														2
													</td>
													<td>
														Emerging in the desired competency
													</td>
												</tr>
												<tr>
													<td align='center'>
														1
													</td>
													<td>
														Not Yet Demonstrated/Observed
													</td>
												</tr>
											</table>
										  </span>
										</div>
										
										
										
											
									</CENTER>
								</TD>";
								$y++;
							}	
							
							
							
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
				echo"<INPUT TYPE='button' 	VALUE='Subject' 	onClick=window.location.href='guru.php?mode=R1D04XSD_Cari'>";
				echo"&nbsp;&nbsp;&nbsp;<span style='color: #FF0000;'>  To change, click on the red numbers</span>"; 
			  
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			// pilihan tombol pilihan
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='SAVE'/>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04XSD_Save'/>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='edit'/>
				<INPUT TYPE='hidden' NAME='kdeplj'		VALUE='$kdeplj'/>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE='$kdekls'/>
				<INPUT TYPE='hidden' NAME='sms'			VALUE='$sms'/>
				<!--<INPUT TYPE='hidden' NAME='thn_ajr'			VALUE=$thn_ajr>-->
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE='$nlitrm'/>
				<INPUT TYPE='hidden' NAME='kolom1'		VALUE='$kolom1'/>
				<INPUT TYPE='hidden' NAME='kolom2'		VALUE='$kolom2'/>
				<INPUT TYPE='hidden' NAME='i'			VALUE='$i'/>";
				
				//$i -> jumlah siswa
				
				for ($y = 0; $y < 25; $y++) {
					$hw_d[$y]		='hw'."$sms"."$nlitrm".$kolom2.$y;
				}
				
				
				
				echo"
					
					<b><i><u>or</b></i></u> setting by Class : <input type='text' size='3' maxlength='1' id='inputnilai' name='inputnilai' title='Mohon tolong diisi dengan angka saja. Terima kasih' />
					
					<button onclick='myFunctionSet()' title='Tolong di cek kembali input an nya. Terima kasih'>set</button>
					
					<script>
						function myFunctionSet() {
							document.getElementById('$hw_d[0]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[1]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[2]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[3]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[4]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[5]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[6]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[7]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[8]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[9]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[10]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[11]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[12]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[13]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[14]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[15]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[16]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[17]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[18]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[19]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[20]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[21]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[22]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[23]').value = document.getElementById('inputnilai').value;
							document.getElementById('$hw_d[24]').value = document.getElementById('inputnilai').value;
							
							
							
							return false;
						}
					</script>
					
					
					
				";
			}
			echo"
		</FORM>";
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04XSD_Save()
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
		
		//$thn_ajr	=$_POST['thn_ajr'];
		
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

			$set	="	SET		t_learnrcd_sd.nis		='". mysql_escape_string($nis)."',
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."',
								t_learnrcd_sd.kdeplj	='". mysql_escape_string($kdeplj)."',
								
								t_learnrcd_sd."."$nliw"."	='". mysql_escape_string($nli)."',
								t_learnrcd_sd.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_learnrcd_sd.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_learnrcd_sd.jamrbh	='". mysql_escape_string($jamrbh)."' "; //t_learnrcd_sd.thn_ajaran		='". mysql_escape_string($thn_ajr)."',	

			$query	="	SELECT 		t_learnrcd_sd.*
						FROM 		t_learnrcd_sd
						WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."'	AND 
									
									t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."'	AND
									t_learnrcd_sd.kdeplj	='". mysql_escape_string($kdeplj)."'"; //t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."'	AND 
									// menghasilkan nis dan matpel nya
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_learnrcd_sd ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan")); // input nilai
			}
			else
			{
				$query 	="	UPDATE 	t_learnrcd_sd ".$set.
						"	WHERE 	t_learnrcd_sd.nis	='". mysql_escape_string($nis)	."'	AND 
									
									t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."'	AND
									t_learnrcd_sd.kdeplj	='". mysql_escape_string($kdeplj)	."'";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah")); //t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."'	AND 
				// update nilai
			}	
			$j++;
		}
		
		

		
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04XSD&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=detil\">\n";//&thn_ajr=$thn_ajr
 	}		
}//akhir class



echo"
</body>
</html>
";
?>