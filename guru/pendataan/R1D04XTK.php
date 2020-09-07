<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04XTK.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT PROGRESS REPORT			TK
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04XTKclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04XTK_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
			
		$query	="	SELECT 		DISTINCT t_mstplj.kdeplj,t_mstplj.nmaplj
								FROM 		t_mstpng,t_mstplj
								WHERE		t_mstpng.kdegru='$kdekry' AND
											t_mstpng.kdeplj=t_mstplj.kdeplj	AND
											t_mstplj.str='' AND
											t_mstplj.kdeplj NOT LIKE 'A%'";
		$result	=mysql_query($query) or die (mysql_error()); // menghasilkan kode dan nama pelajaran

		echo"
		<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><B>INPUT LEARNING RECORD</B></TD></TR>
			<TR></TR><TR></TR>
		</TABLE>
			
		<FORM ACTION='guru.php?mode=R1D04XTK' METHOD='post'>
			<DIV style='overflow:auto;width:25%;height:410px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH='80%' HEIGHT='20'><CENTER>Tematic	</CENTER></TD>
						<TD WIDTH='20%'><CENTER>Detail		</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD>$data[nmaplj]</TD>
							<TD><CENTER><a href='guru.php?mode=R1D04XTK&kdeplj=$data[kdeplj]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>
		</FORM>";
 	}
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	
	// -------------------------------------------------- Layar Utama --------------------------------------------------	
	function R1D04XTK()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$kdeplj	=$_GET['kdeplj'];
		//$kdetkt	=$_GET['kdetkt']; // namabahbuatan
		$pilihan=$_GET['pilihan'];
		$kolom1	=$_GET['kolom1'];
		$kolom2	=$_GET['kolom2'];
		
		$thnajr	=$_GET['thnajr'];

		$sms	='Semester';
		$query 	=mysql_query("	SELECT 		t_setthn_tk.* 
								FROM 		t_setthn_tk
								WHERE		t_setthn_tk.set='$sms'");
		$data = mysql_fetch_array($query); // menghasilkan semester 1 atau 2
		$sms=$data[nli];
					
		$midtrm	='Mid Term';
		$query 	=mysql_query("	SELECT 		t_setthn_tk.* 
								FROM 		t_setthn_tk
								WHERE		t_setthn_tk.set='$midtrm'");
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
					WHERE 		t_mstssw.kdekls	='". mysql_escape_string($kdekls)."'  AND
								t_mstssw.thn_ajaran	='". mysql_escape_string($thnajr)."' 	and
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
				$query2	="	SELECT 		t_learnrcd_tk.*
						FROM 		t_learnrcd_tk
						WHERE 		t_learnrcd_tk.nis		='". mysql_escape_string($nis)."' AND
									t_learnrcd_tk.kdeplj	='". mysql_escape_string($kdeplj)."' AND 
									t_learnrcd_tk.thn_ajaran	='". mysql_escape_string($thnajr)."' ";
				
				$result2 =mysql_query($query2);
				$data2 	 =mysql_fetch_array($result2);
				$y=1;
				while($y<26)
				{
					$cell[$i][$y+1]=$data2['hw'."$sms"."$nlitrm"."$y"];
					$y++;
				}
				
				$qry2 	="	SELECT 		t_lrcd_tk.*
								FROM 		t_lrcd_tk 
								WHERE		t_lrcd_tk.kdekls	='". mysql_escape_string($kdekls)."' AND
											t_lrcd_tk.kde LIKE '". mysql_escape_string($kdeplj)."%' AND 
											t_lrcd_tk.thn_ajaran	='". mysql_escape_string($thnajr)."' ";
				$rslt2 =mysql_query($qry2);
				$yes=1;
				while( $dta2=mysql_fetch_array($rslt2) )
				{
					$cell[$yes][44] = $dta2[nmektr];
					$yes++;
				}
				
				$i++;
			//}
			
			// akhir buatan
			
				
				
			
			
		}

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>INPUT LEARNING RECORD <span style='color: #FF0000;'>( $nmaplj )</span></B></TD></TR>
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
							$kls = '';
							
							if($data[kdekls]=='PG1')
								$kls = 'Pre-K1';
							else if($data[kdekls]=='PG2')
								$kls = 'Pre-K2';
							else
								$kls = $data[kdekls];
							
							
							
							if($kdekls==$data[kdekls])
								echo"<OPTION VALUE='$data[kdekls]' SELECTED>$kls</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdekls]'>$kls</OPTION>";
							
						}
						
						/*if($kdekry=='M08010012')//Ms. Glory
						{
							echo"<OPTION VALUE='KG-A1'>KG-A1</OPTION>";
							echo"<OPTION VALUE='KG-A2'>KG-A2</OPTION>";
						}*/
						
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
						<input type='text' NAME='thnajr' ID='thnajr' value='2018-2019' readonly/>
						<INPUT TYPE='submit' 					VALUE='View'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04XTK'>
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
						<TD WIDTH='2%' ROWSPAN='3' HEIGHT='30'><CENTER>No	</CENTER></TD>
						<TD WIDTH='20%' ROWSPAN='3'><CENTER>Name	    </CENTER></TD>
						<TD WIDTH='78%' COLSPAN='$yes' HEIGHT='30'><CENTER>Learning Objectives	    	</CENTER></TD>";//ROWSPAN='2' HEIGHT='20'
					
					echo"	
					</TR>
					<TR bgcolor='dedede'>";
						$y=1;
						while($y<$yes)
						{
							$nmektr=$cell[$y][44];
							echo"<TD WIDTH='4%' HEIGHT='20' title='$nmektr'><CENTER>$nmektr	</CENTER></TD>";//substr($nmektr,0,1)
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
								//$sst = $cell[0][$y+1];
								$nmektr=$cell[$y][44];
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER><a href='guru.php?mode=R1D04XTK&kdeplj=$kdeplj&kdekls=$kdekls&thnajr=$thnajr&pilihan=edit&kolom1=hw&kolom2=$y' title='$nmektr'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}	
							
						}
						else
						{
							$y=1;
							while($y<$yes)
							{
								$nmektr=$cell[$y][44];
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
								$sst = $cell[$j][$y+1];
								//$hwv	=$cell[$j][$y+1];
								
								// awal buatan
								if ($hwv==0)
									$hwv='';
								// khir buatan
								
								$nmektr=$cell[$y][44];
								
								echo"
								<TD><CENTER>
									<INPUT 	NAME		='$hw'
											TYPE		='text'
											SIZE		='3'
											MAXLENGTH	='3'
											VALUE 		='$sst'
											ID			='$hw'
											
											
											title		='$no. $nmav'
											$isianhw[$y]/></CENTER>
								</TD>";
								$y++;//ONKEYUP		='formatangka(this);' ONKEYPRESS	='return enter(this,event)'			$nmektr
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
			<!--<INPUT TYPE='button' 	VALUE='Subject' 	onClick=window.location.href='guru.php?mode=R1D04XTK_Cari'>-->";
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
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04XTK_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdeplj'		VALUE=$kdeplj>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<INPUT TYPE='hidden' NAME='thnajr'		VALUE=$thnajr>
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
	function R1D04XTK_Save()
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
		
		$thnajr	=$_POST['thnajr'];
		
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

			$set	="	SET		t_learnrcd_tk.nis		='". mysql_escape_string($nis)."',
								t_learnrcd_tk.kdekls	='". mysql_escape_string($kdekls)."',
								t_learnrcd_tk.kdeplj	='". mysql_escape_string($kdeplj)."',
								t_learnrcd_tk."."$nliw"."	='". mysql_escape_string($nli)."',
								t_learnrcd_tk.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_learnrcd_tk.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_learnrcd_tk.jamrbh	='". mysql_escape_string($jamrbh)."', 
								t_learnrcd_tk.thn_ajaran		='". mysql_escape_string($thnajr)."' "; 

			$query	="	SELECT 		t_learnrcd_tk.*
						FROM 		t_learnrcd_tk
						WHERE 		t_learnrcd_tk.nis	='". mysql_escape_string($nis)."'	AND 
									t_learnrcd_tk.kdekls	='". mysql_escape_string($kdekls)."'	AND
									t_learnrcd_tk.kdeplj	='". mysql_escape_string($kdeplj)."' AND 
									t_learnrcd_tk.thn_ajaran	='". mysql_escape_string($thnajr)."' "; // menghasilkan nis dan matpel nya
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_learnrcd_tk ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan")); // input nilai
			}
			else
			{
				$query 	="	UPDATE 	t_learnrcd_tk ".$set.
						"	WHERE 	t_learnrcd_tk.nis	='". mysql_escape_string($nis)	."'	AND 
									t_learnrcd_tk.kdekls	='". mysql_escape_string($kdekls)."'	AND
									t_learnrcd_tk.kdeplj	='". mysql_escape_string($kdeplj)	."' AND 
									t_learnrcd_tk.thn_ajaran	='". mysql_escape_string($thnajr)."' ";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah")); // update nilai
			}	
			$j++;
		}
		
		

		
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04XTK&kdeplj=$kdeplj&kdekls=$kdekls&thnajr=$thnajr&pilihan=detil\">\n";
 	}		
}//akhir class
?>