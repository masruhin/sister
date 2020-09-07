<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04HACC.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT PROGRESS REPORT
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04HACCclass
{
	function R1D04HACC()
	{
		echo"<SCRIPT TYPE='ext/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>";
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$pilihan=$_GET['pilihan'];
		$sms=$_GET['sms'];
		$trm=$_GET['trm'];
		$thn=$_GET['thn'];
		$period=$_GET['period'];
		
		
		
		$smster	='Semester';
		$query 	=mysql_query("	SELECT 		t_setthn_sd.* 
								FROM 		t_setthn_sd
								WHERE		t_setthn_sd.set='$smster'");// menghasilkan semester
		$data = mysql_fetch_array($query);
		$smster=$data[nli];
					
		$midtrm	='Mid Term';
		$query 	=mysql_query("	SELECT 		t_setthn_sd.* 
								FROM 		t_setthn_sd
								WHERE		t_setthn_sd.set='$midtrm'");// menghasilkan mid
		$data = mysql_fetch_array($query);
		$nlitrm=$data[nli];
		$midtrm=$midtrm.' '.$nlitrm;
		
		
		
		if( $sms=='' )
			$sms=$smster;//'1';//
		if( $trm=='' )
			$trm=$nlitrm;//'2';//
		if( $thn=='' )
			$thn = '2018';
		if( $period=='' )
			$period = $sms . $trm . $thn;
		
		
		
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

		

			$query2	="	SELECT 		t_acc_sd_det.*
						FROM 		t_acc_sd_det
						WHERE 		t_acc_sd_det.period		='". mysql_escape_string($period)."' AND
									t_acc_sd_det.kdeusr	='". mysql_escape_string($kdekry)."' "; // menghasilkan nilai kehadiran per siswa
			$result2 =mysql_query($query2);
			$i=0;
			while( $data2 	 =mysql_fetch_array($result2) )
			{
				$cell[$i][5]=$data2['stud'];//."$sms"."$nlitrm"
				$cell[$i][6]=$data2['teac'];//."$sms"."$nlitrm"
				$cell[$i][7]=$data2['curr'];//."$sms"."$nlitrm"
				$cell[$i][8]=$data2['phys'];//."$sms"."$nlitrm"
				$cell[$i][9]=$data2['comm'];//."$sms"."$nlitrm"
				$cell[$i][10]=$data2['othe'];//."$sms"."$nlitrm"
				
				$i++;
			}
		

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>Input Accomplishment Report SD</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='10%'>Semester</TD>
					<TD WIDTH='90%'>:
						
							<INPUT NAME			='sms'
									TYPE		='radio'
									VALUE 		='1'
									ID			='sms'";
							if($sms=='1')
								echo"checked";
								echo"> 
								1
							<INPUT 	NAME		='sms'
									TYPE		='radio'
									VALUE 		='2'
									ID			='sms'";
							if($sms=='2')
								echo"checked";
								echo"> 
								2
						
					</TD>	
              	</TR>
				
				<TR><TD>Mid Term</TD>
					<TD>:
						<INPUT NAME			='trm'
								TYPE		='radio'
								VALUE 		='1'
								ID			='trm'";
						if($trm=='1')
							echo"checked";
							echo"/> 
							1
						<INPUT 	NAME		='trm'
								TYPE		='radio'
								VALUE 		='2'
								ID			='trm'";
						if($trm=='2')
							echo"checked";
							echo"/> 
							2
					</TD>
				</TR>
				
				<TR><TD>Tahun</TD>
					<TD>:
						<INPUT NAME			='thn'
								TYPE		='text'
								VALUE 		='$thn'
								ID			='thn'
						>
						<INPUT TYPE='submit' 					VALUE='View'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04HACC'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
					</TD>
				</TR>
			</TABLE>
			
						
		</FORM>
		
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 3%' HEIGHT='20'><CENTER>No</CENTER></TD>
						<TD ><CENTER>I. Student Development</CENTER></TD>
						<TD ><CENTER>II. Teacher Development</CENTER></TD>
						<TD ><CENTER>III. Curriculum Development</CENTER></TD>
						<TD ><CENTER>IV. Physical Development</CENTER></TD>
						<TD ><CENTER>V. Community Development</CENTER></TD>
						<TD ><CENTER>VI. Other Related Concerns</CENTER></TD>
						
						
					</TR>";
					$j=0;
					$no=1;
					$jmldta=$i+1;
					//while($j<$i)
					while($j<$jmldta)
					{
						$nmr	='no'.$j;
						$nmrv	=$no;
						
						$nis	='nis'.$j;
						$nisv	=$period;
						
						$stud	='stud'."$sms"."$nlitrm".$j;
						$studv	=$cell[$j][5];
						
						$teac	='teac'."$sms"."$nlitrm".$j;
						$teacv	=$cell[$j][6];
						
						$curr	='curr'."$sms"."$nlitrm".$j;
						$currv	=$cell[$j][7];
						
						$phys	='phys'."$sms"."$nlitrm".$j;
						$physv=$cell[$j][8];
						
						$comm	='comm'."$sms"."$nlitrm".$j;
						$commv	=$cell[$j][9];
						
						$othe	='othe'."$sms"."$nlitrm".$j;
						$othev	=$cell[$j][10];
						
						
						echo"
						<TR HEIGHT='66'>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nmr'		VALUE=$nmrv>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							
							<TD>
								<CENTER>
									<INPUT 	NAME		='$stud'
											TYPE		='text'
											SIZE		='35'
											VALUE 		='$studv'
											ID			='$stud'
											ONKEYPRESS	='return enter(this,event)'
											$isian2>
								</CENTER>
							</TD>
							<TD>
								<CENTER>
									<INPUT 	NAME		='$teac'
											TYPE		='text'
											SIZE		='35'
											VALUE 		='$teacv'
											ID			='$teac'
											ONKEYPRESS	='return enter(this,event)'
											$isian2>
								</CENTER>
							</TD>
							<TD>
								<CENTER>
									<INPUT 	NAME		='$curr'
											TYPE		='text'
											SIZE		='35'
											VALUE 		='$currv'
											ID			='$curr'
											ONKEYPRESS	='return enter(this,event)'
											$isian2>
								</CENTER>
							</TD>
							<TD>
								<CENTER>
								<INPUT 	NAME		='$phys'
										TYPE		='text'
										SIZE		='35'
										VALUE 		='$physv'
										ID			='$phys'
										ONKEYPRESS	='return enter(this,event)'
										$isian2>
								</CENTER>
							</TD>
							<TD>
								<CENTER>
								<INPUT 	NAME		='$comm'
										TYPE		='text'
										SIZE		='35'
										VALUE 		='$commv'
										ID			='$comm'
										ONKEYPRESS	='return enter(this,event)'
										$isian2>
								</CENTER>
							</TD>
							<TD>
								<CENTER>
								<INPUT 	NAME		='$othe'  
										TYPE		='text' 
										SIZE		='35' 
										VALUE		='$othev' 
										id			='$othe'
										$isian2>
								</CENTER>
							</TD>
							
							
						</TR>";

						$j++;
						$no++;
					}		
				echo"	
				</TABLE>	
			</DIV>
			";

			// pilihan tombol pilihan
			if ($pilihan=='detil' AND $sms!='' AND $trm!='' AND $thn!='')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='guru.php?mode=R1D04HACC&sms=$sms&trm=$trm&thn=$thn&period=$period&pilihan=komentar'>";
				
			}	
				
			
			// tombol simpan (komentar)
			if($pilihan=='komentar')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04HACC_Save_Komentar'>
				
				<INPUT TYPE='hidden' NAME='sms'			VALUE=$sms>
				<INPUT TYPE='hidden' NAME='trm'			VALUE=$trm>
				<INPUT TYPE='hidden' NAME='thn'			VALUE=$thn>
				<INPUT TYPE='hidden' NAME='period'		VALUE=$period>
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE=$nlitrm>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}

			
			echo"
		</FORM>";
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	//function R1D04HACC_Save()
	
	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04HACC_Save_Komentar()
	{
		$sms	=$_POST['sms'];
		
		$sms	=$_POST['sms'];
		$trm	=$_POST['trm'];
		$thn	=$_POST['thn'];
		$period	=$_POST['period'];
		
		$nlitrm	=$_POST['nlitrm'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		
		
		
		
		
		
		
		$j=0;
		$jmldta=$i+1;
		//while($j<$i)
		while($j<$jmldta)
		{
			$nmr 	='no'.$j;
			$nmr	=$_POST["$nmr"]; 
			
			$stud 	="stud"."$sms"."$nlitrm".$j;
			$stud	=$_POST["$stud"]; 
			$stud	=str_replace("'","`","$stud");
			
			$teac 	="teac"."$sms"."$nlitrm".$j;
			$teac	=$_POST["$teac"]; 
			$teac	=str_replace("'","`","$teac");
			
			$curr 	="curr"."$sms"."$nlitrm".$j;
			$curr	=$_POST["$curr"]; 
			$curr	=str_replace("'","`","$curr");
			
			$phys 	="phys"."$sms"."$nlitrm".$j;
			$phys	=$_POST["$phys"]; 
			$phys	=str_replace("'","`","$phys");
			
			$comm 	="comm"."$sms"."$nlitrm".$j;
			$comm	=$_POST["$comm"]; 
			$comm	=str_replace("'","`","$comm");
			
			$othe 	="othe"."$sms"."$nlitrm".$j;
			$othe	=$_POST["$othe"]; 
			$othe	=str_replace("'","`","$othe");
			
			$set	="	SET		t_acc_sd_det.no		='". mysql_escape_string($nmr)."',
								t_acc_sd_det.period		='". mysql_escape_string($period)."',
								t_acc_sd_det.stud		='". mysql_escape_string($stud)."',
								t_acc_sd_det.teac		='". mysql_escape_string($teac)."',
								t_acc_sd_det.curr		='". mysql_escape_string($curr)."',
								t_acc_sd_det.phys		='". mysql_escape_string($phys)."',
								t_acc_sd_det.comm		='". mysql_escape_string($comm)."',
								t_acc_sd_det.othe		='". mysql_escape_string($othe)."',
								t_acc_sd_det.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_acc_sd_det.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_acc_sd_det.jamrbh	='". mysql_escape_string($jamrbh)."'"; 		//	t_acc_sd_det.kmn"."$sms"."$nlitrm"."

			$query	="	SELECT 		t_acc_sd_det.*
						FROM 		t_acc_sd_det
						WHERE 		t_acc_sd_det.period	='". mysql_escape_string($period)."' AND 
									t_acc_sd_det.kdeusr	='". mysql_escape_string($kdeusr)."' AND
									t_acc_sd_det.no	='". mysql_escape_string($nmr)."' ";
			$result =mysql_query($query);
			
			if( $data 	 =mysql_fetch_array($result) )
			{
				$query 	="	UPDATE 	t_acc_sd_det ".$set.
						"	WHERE 	t_acc_sd_det.period	='". mysql_escape_string($period)	."' AND
									t_acc_sd_det.kdeusr	='". mysql_escape_string($kdeusr)."' AND
									t_acc_sd_det.no	='". mysql_escape_string($nmr)."' ";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			}
			else
			{
				if( $stud=='' AND $teac=='' AND $curr==''AND $phys==''AND $comm==''AND $othe=='' )
				{
					
				}
				else
				{
					$query 	="	INSERT INTO t_acc_sd_det ".$set; 
					$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
				}
			}
			
			$j++;
		}
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04HACC&sms=$sms&trm=$trm&thn=$thn&pilihan=detil\">\n";
 	}		

	// -------------------------------------------------- Save --------------------------------------------------
	//function R1D04HACC_Save_Kenaikan()
	
}//akhir class
?>