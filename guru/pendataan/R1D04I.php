<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04I.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT PROGRESS REPORT
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Iclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04I_Cari()
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
			<TR><TD><B>INPUT PROGRESS REPORT</B></TD></TR>
			<TR></TR><TR></TR>
		</TABLE>
			
		<FORM ACTION='guru.php?mode=R1D04I' METHOD='post'>
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
							<TD><CENTER><a href='guru.php?mode=R1D04I&kdeplj=$data[kdeplj]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>
		</FORM>";
 	}
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	
	// -------------------------------------------------- Layar Utama --------------------------------------------------	
	function R1D04I()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$kdeplj	=$_GET['kdeplj'];
		$pilihan=$_GET['pilihan'];
		$kolom1	=$_GET['kolom1'];
		$kolom2	=$_GET['kolom2'];

		$sms	='Semester';
		$query 	=mysql_query("	SELECT 		t_setthn.* 
								FROM 		t_setthn
								WHERE		t_setthn.set='$sms'");
		$data = mysql_fetch_array($query);
		$sms=$data[nli];
					
		$midtrm	='Mid Term';
		$query 	=mysql_query("	SELECT 		t_setthn.* 
								FROM 		t_setthn
								WHERE		t_setthn.set='$midtrm'");
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
				while($y<6)
				{
					$isianhw[$y]='disabled';
					$isianprj[$y]='disabled';
					$isiantes[$y]='disabled';
					$y++;
				}	
				$isianmidtes[1]='disabled';
				break;
			case 'edit':
				$y=1;
				while($y<6)
				{
					if($kolom1=='hw' and $kolom2=="$y")
						$isianhw[$y]='enable';
					else	
						$isianhw[$y]='disabled';
						
					if($kolom1=='prj' and $kolom2=="$y")	
						$isianprj[$y]='enable';
					else
						$isianprj[$y]='disabled';
						
					if($kolom1=='tes' and $kolom2=="$y")		
						$isiantes[$y]='enable';
					else	
						$isiantes[$y]='disabled';
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
					WHERE 		t_mstssw.kdekls	='". mysql_escape_string($kdekls)."'	and
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

			$query2	="	SELECT 		t_prgrptps.*
						FROM 		t_prgrptps
						WHERE 		t_prgrptps.nis		='". mysql_escape_string($nis)."'	AND
									t_prgrptps.kdeplj	='". mysql_escape_string($kdeplj)."'";
			$result2 =mysql_query($query2);
			$data2 	 =mysql_fetch_array($result2);
			$y=1;
			while($y<6)
			{
				$cell[$i][$y+1]=$data2['hw'."$sms"."$nlitrm"."$y"];
				$y++;
			}	

			$y=1;
			while($y<6)
			{
				$cell[$i][$y+6]=$data2['prj'."$sms"."$nlitrm"."$y"];
				$y++;
			}	
			
			$y=1;
			while($y<6)
			{
				$cell[$i][$y+11]=$data2['tes'."$sms"."$nlitrm"."$y"];
				$y++;
			}

			$cell[$i][$y+16]=$data2['midtes'."$sms"."$nlitrm"];
			
			$i++;
		}

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>INPUT PROGRESS REPORT <span style='color: #FF0000;'>( $nmaplj )</span></B></TD></TR>
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
							if($kdekls==$data[kdekls])
								echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
						}
						echo"
						</SELECT>
						<INPUT TYPE='submit' 					VALUE='View'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04I'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						<INPUT TYPE='hidden' 	NAME='kdeplj'	VALUE=$kdeplj>
					</TD>	
              	</TR>				
			</TABLE>
		</FORM>
		
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH='3%' ROWSPAN='2' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='33%' ROWSPAN='2'><CENTER>Name	    </CENTER></TD>
						<TD WIDTH='20%' COLSPAN='5' HEIGHT='20'><CENTER>Home Work / Class Work	    	</CENTER></TD>
						<TD WIDTH='20%' COLSPAN='5'><CENTER>Project/Experiment	    	</CENTER></TD>
						<TD WIDTH='20%' COLSPAN='5'><CENTER>Test	    	</CENTER></TD>";
						if ($pilihan=='detil'  AND $kdekls!='')
							echo"
							<TD WIDTH='4%' ROWSPAN='2'><CENTER><a href='guru.php?mode=R1D04I&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=midtes'><span style='color: #FF0000;'><b>mid</b></span></CENTER></TD>";
						else
							echo"
							<TD WIDTH='4%' ROWSPAN='2'><CENTER>mid</CENTER></TD>";
					echo"	
					</TR>
					<TR bgcolor='dedede'>";
						if ($pilihan=='detil'  AND $kdekls!='')
						{
							$y=1;
							while($y<6)
							{
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER><a href='guru.php?mode=R1D04I&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=hw&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}	
							$y=1;
							while($y<6)
							{
								echo"<TD WIDTH='4%'><CENTER><a href='guru.php?mode=R1D04I&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=prj&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}	
							$y=1;
							while($y<6)
							{
								echo"<TD WIDTH='4%'><CENTER><a href='guru.php?mode=R1D04I&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit&kolom1=tes&kolom2=$y'><span style='color: #FF0000;'><b>$y</b></span></CENTER></TD>";
								$y++;
							}	
						}
						else
						{
							$y=1;
							while($y<6)
							{
								echo"<TD WIDTH='4%' HEIGHT='20'><CENTER>$y	</CENTER></TD>";
								$y++;
							}	
							$y=1;
							while($y<6)
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
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>$nmav </CENTER></TD>";
							$y=1;
							while($y<6)
							{
								$hw		='hw'."$sms"."$nlitrm"."$y"."$j";
								$hwv	=$cell[$j][$y+1];
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
											$isianhw[$y]></CENTER>
								</TD>";
								$y++;
							}	
							$y=1;
							while($y<6)
							{
								$prj	='prj'."$sms"."$nlitrm"."$y"."$j";
								$prjv	=$cell[$j][$y+6];
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
											$isianprj[$y]></CENTER>
								</TD>";
								$y++;
							}	
							$y=1;
							while($y<6)
							{
								$tes	='tes'."$sms"."$nlitrm"."$y"."$j";
								$tesv	=$cell[$j][$y+11];
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
											$isiantes[$y]></CENTER>
								</TD>";
								$y++;
							}	

							$midtes	='midtes'."$sms"."$nlitrm"."$j";
							$midtesv=$cell[$j][$y+16];
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
										$isianmidtes[1]></CENTER>
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
			<INPUT TYPE='button' 	VALUE='Subject' 	onClick=window.location.href='guru.php?mode=R1D04I_Cari'>";
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
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04I_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdeplj'		VALUE=$kdeplj>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
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
	function R1D04I_Save()
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
		
		$query	="	SELECT 		t_mstbbt.*
					FROM 		t_mstbbt
					WHERE		t_mstbbt.kdebbt='1HW'";
		$result	=mysql_query($query) or die('Query gagal1');
		$data 	=mysql_fetch_array($result);
		$bbthw=$data[bbt];
		
		$query	="	SELECT 		t_mstbbt.*
					FROM 		t_mstbbt
					WHERE		t_mstbbt.kdebbt='2PRJ'";
		$result	=mysql_query($query) or die('Query gagal1');
		$data 	=mysql_fetch_array($result);
		$bbtprj=$data[bbt];

		$query	="	SELECT 		t_mstbbt.*
					FROM 		t_mstbbt
					WHERE		t_mstbbt.kdebbt='3TES'";
		$result	=mysql_query($query) or die('Query gagal1');
		$data 	=mysql_fetch_array($result);
		$bbttes=$data[bbt];

		$query	="	SELECT 		t_mstbbt.*
					FROM 		t_mstbbt
					WHERE		t_mstbbt.kdebbt='4MID'";
		$result	=mysql_query($query) or die('Query gagal1');
		$data 	=mysql_fetch_array($result);
		$bbtmidtes=$data[bbt];
		
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

			$set	="	SET		t_prgrptps.nis		='". mysql_escape_string($nis)."',
								t_prgrptps.kdeplj	='". mysql_escape_string($kdeplj)."',
								t_prgrptps."."$nliw"."	='". mysql_escape_string($nli)."',
								t_prgrptps.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_prgrptps.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_prgrptps.jamrbh	='". mysql_escape_string($jamrbh)."'"; 

			$query	="	SELECT 		t_prgrptps.*
						FROM 		t_prgrptps
						WHERE 		t_prgrptps.nis	='". mysql_escape_string($nis)."'	AND
									t_prgrptps.kdeplj	='". mysql_escape_string($kdeplj)."'";
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_prgrptps ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
			}
			else
			{
				$query 	="	UPDATE 	t_prgrptps ".$set.
						"	WHERE 	t_prgrptps.nis	='". mysql_escape_string($nis)	."'	AND
									t_prgrptps.kdeplj	='". mysql_escape_string($kdeplj)	."'";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			}	
			$j++;
		}
		
		//-------------------------- simpan hasil akhir
		$bghw	=1;
		$bgprj	=1;
		$bgtes	=1;
		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
	
			$query2 ="	SELECT 		t_prgrptps.*
						FROM 		t_prgrptps
						WHERE		t_prgrptps.nis	='$nis'		AND
									t_prgrptps.kdeplj='$kdeplj'";
			$result2=mysql_query($query2) or die('Query gagal');
			$data2	=mysql_fetch_array($result2);
			$y	=1;
			$hw	=0;
			$prj=0;
			$tes=0;
			while($y<6)
			{
				if($data2['hw'."$sms"."$nlitrm"."$y"]>0)
					$hw++;
				if($data2['prj'."$sms"."$nlitrm"."$y"]>0)
					$prj++;
				if($data2['tes'."$sms"."$nlitrm"."$y"]>0)
					$tes++;	
				$y++;	
			}
			if($hw>$bghw)
				$bghw=$hw;
			if($prj>$bgprj)
				$bgprj=$prj;
			if($tes>$bgtes)
				$bgtes=$tes;
	
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

			$query2 ="	SELECT 		t_prgrptps.*
						FROM 		t_prgrptps
						WHERE		t_prgrptps.nis	='$nis'		AND
									t_prgrptps.kdeplj='$kdeplj'";
			$result2=mysql_query($query2) or die('Query gagal');
			$data2	=mysql_fetch_array($result2);
	
			$y=1;
			while($y<6)
			{
				$hw=$data2['hw'."$sms"."$nlitrm"."$y"];
				$prj=$data2['prj'."$sms"."$nlitrm"."$y"];
				$tes=$data2['tes'."$sms"."$nlitrm"."$y"];
				$ttlhw=$ttlhw+$hw;
				$ttlprj=$ttlprj+$prj;
				$ttltes=$ttltes+$tes;
				$y++;
			}		
			$avghw	=$ttlhw/$bghw;
			$bavghw	=($avghw*$bbthw)/100;
			$avgprj	=$ttlprj/$bgprj;
			$bavgprj=($avgprj*$bbtprj)/100;
			$avgtes	=$ttltes/$bgtes;
			$bavgtes=($avgtes*$bbttes)/100;

			$ttl		=$bavghw+$bavgprj+$bavgtes;
			$ttl70		=$ttl*((100-$bbtmidtes)/100);
			$midtes		=$data2['midtes'."$sms"."$nlitrm"];
			$midtes30	=($midtes*$bbtmidtes)/100;
			$nliakh		=$ttl70+$midtes30;
			$akh		='akh'."$sms"."$nlitrm";
			$ttlakh		=$ttlakh+$nliakh;

			$set	="	SET		t_prgrptps."."$akh"."	='". mysql_escape_string($nliakh)."'"; 
			$query 	="	UPDATE 	t_prgrptps ".$set.
					"	WHERE 	t_prgrptps.nis	='". mysql_escape_string($nis)	."'	AND
								t_prgrptps.kdeplj	='". mysql_escape_string($kdeplj)	."'";
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
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04I&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=detil\">\n";
 	}		
}//akhir class
?>