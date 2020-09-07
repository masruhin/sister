<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04HINTRVW.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT PROGRESS REPORT
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04HINTRVWclass
{
	function R1D04HINTRVW()
	{
		echo"<SCRIPT TYPE='ext/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>";
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];//tanggal
		$pilihan=$_GET['pilihan'];
		$sms='';
		$midtrm='';
		
		
		//else
		//{
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

		

			$query2	="	SELECT 		t_intrvw_sd_det.*
						FROM 		t_intrvw_sd_det
						WHERE 		t_intrvw_sd_det.tgl		='". mysql_escape_string($kdekls)."' AND
									t_intrvw_sd_det.kdeusr	='". mysql_escape_string($kdekry)."' 
						ORDER BY	t_intrvw_sd_det.no
						"; // menghasilkan nilai kehadiran per siswa
			$result2 =mysql_query($query2);
			$i=0;
			while( $data2 	 =mysql_fetch_array($result2) )
			{
				$cell[$i][0]=$data2['no'];//."$sms"."$nlitrm"
				$cell[$i][1]=$data2['nmassw_br'];//."$sms"."$nlitrm"
				$cell[$i][2]=$data2['tgl'];//."$sms"."$nlitrm"
				$cell[$i][3]=$data2['wkt'];//."$sms"."$nlitrm"
				$cell[$i][4]=$data2['intrvw'];//."$sms"."$nlitrm"
				$i++;
			}
		
//2
		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>Input Hasil Interview</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='10%' valign='top'>Date</TD>
					<TD WIDTH='90%'>
						<PRE> : <INPUT 	NAME		='kdekls'  
										TYPE		='text' 
										SIZE		=10 
										MAXLENGTH	=10 
										VALUE		='$kdekls' 
										id			='kdekls'
										/><IMG onClick='WdatePicker({el:kdekls});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'> <INPUT TYPE='submit' 					VALUE='View'>
						</PRE>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04HINTRVW'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
					</TD>	
              	</TR>				
			</TABLE>
		</FORM>
		
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 3%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Nama Siswa Baru	    </CENTER></TD>
						<TD WIDTH='7%'><CENTER>Date	    </CENTER></TD>
						<TD WIDTH='5%'><CENTER>Time	    </CENTER></TD>
						<TD WIDTH='75%'><CENTER>Hasil Interview</CENTER></TD>
						
						
					</TR>";
					$j=0;
					$no=1;
					$jmldta=$i+1;
					//while($j<$i)
					while($j<$jmldta)
					{
						$nmr	='no'.$j;
						$nmrv	=$no;
						
						$nmassw_br	='nmassw_br'."$sms"."$nlitrm".$j;
						$nmassw_brv=$cell[$j][1];
						
						$tgl	='tgl'."$sms"."$nlitrm".$j;
						$tglv	=$cell[$j][2];
						
						$wkt	='wkt'."$sms"."$nlitrm".$j;
						$wktv	=$cell[$j][3];
						
						$intrvw	='intrvw'."$sms"."$nlitrm".$j;
						$intrvwv=$cell[$j][4];
						
						//	readonly		style		='background:gray'					
						
						echo"
						<TR HEIGHT='66'>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nmr'		VALUE=$nmrv>		
							</TD>
							
							<TD><CENTER>
								<INPUT 	NAME		='$nmassw_br'  
										TYPE		='text' 
										SIZE		=20 
										MAXLENGTH	=20 
										VALUE		='$nmassw_brv' 
										id			='$nmassw_br'
										$isian2>
								</CENTER></TD>
							<TD>
								<PRE><INPUT 	NAME		='$tgl'  
										TYPE		='text' 
										SIZE		=10 
										MAXLENGTH	=10 
										VALUE		='$kdekls' 
										id			='$tgl'
										
										$isian2/><IMG onClick='WdatePicker({el:$tgl});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle' disabled></PRE></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$wkt'  
										TYPE		='text' 
										SIZE		=10 
										MAXLENGTH	=10 
										VALUE		='$wktv' 
										id			='$wkt'
										placeholder	='09:15:00'
										$isian2>
								</CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$intrvw'
										TYPE		='text'
										SIZE		='200'
										VALUE 		='$intrvwv'
										ID			='$intrvw'
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
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='guru.php?mode=R1D04HINTRVW&kdekls=$kdekls&pilihan=komentar'>";
				
			}	
				
			
			// tombol simpan (komentar)
			if($pilihan=='komentar')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04HINTRVW_Save_Komentar'>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<INPUT TYPE='hidden' NAME='sms'			VALUE=$sms>
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE=$nlitrm>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}

			
			echo"
		</FORM>";
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	//function R1D04HINTRVW_Save()
	
	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04HINTRVW_Save_Komentar()
	{
		$kdekls	=$_POST['kdekls'];
		$sms	=$_POST['sms'];
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
			
			$nmassw_br ="nmassw_br"."$sms"."$nlitrm".$j;
			$nmassw_br	=$_POST["$nmassw_br"];		
			
			$tgl 	="tgl"."$sms"."$nlitrm".$j;
			$tgl	=$_POST["$tgl"];
			$wkt 	="wkt"."$sms"."$nlitrm".$j;
			$wkt	=$_POST["$wkt"];
			
			$intrvw	="intrvw"."$sms"."$nlitrm".$j;
			$intrvw	=$_POST["$intrvw"]; 
			$intrvw	=str_replace("'","`","$intrvw");
			
			$set	="	SET		t_intrvw_sd_det.no		='". mysql_escape_string($nmr)."',
								t_intrvw_sd_det.nmassw_br		='". mysql_escape_string($nmassw_br)."',
								t_intrvw_sd_det.tgl		='". mysql_escape_string($tgl)."',
								t_intrvw_sd_det.wkt		='". mysql_escape_string($wkt)."',
								t_intrvw_sd_det.intrvw	='". mysql_escape_string($intrvw)."',
								
								t_intrvw_sd_det.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_intrvw_sd_det.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_intrvw_sd_det.jamrbh	='". mysql_escape_string($jamrbh)."'"; 		//	t_intrvw_sd_det.kmn"."$sms"."$nlitrm"."

			$query	="	SELECT 		t_intrvw_sd_det.*
						FROM 		t_intrvw_sd_det
						WHERE 		t_intrvw_sd_det.no	='". mysql_escape_string($nmr)."' AND 
									t_intrvw_sd_det.tgl	='". mysql_escape_string($tgl)."' AND 
									t_intrvw_sd_det.kdeusr	='". mysql_escape_string($kdeusr)."' ";
			$result =mysql_query($query);
			//$data	=mysql_fetch_array($result);
			if( $data 	 =mysql_fetch_array($result) )
			{
				$query 	="	UPDATE 	t_intrvw_sd_det ".$set.
						"	WHERE 	t_intrvw_sd_det.no	='". mysql_escape_string($nmr)	."' AND
									t_intrvw_sd_det.tgl	='". mysql_escape_string($tgl)."' AND
									t_intrvw_sd_det.kdeusr	='". mysql_escape_string($kdeusr)."' ";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			}
			else
			{
				if( $nmassw_br=='' AND $intrvw=='' )
				{
					
				}
				else
				{
					$query 	="	INSERT INTO t_intrvw_sd_det ".$set; 
					$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
				}
			}
			
			$j++;
		}
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04HINTRVW&kdekls=$kdekls&nis=$nis&pilihan=detil\">\n";
 	}		

	// -------------------------------------------------- Save --------------------------------------------------
	//function R1D04HINTRVW_Save_Kenaikan()
	
}//akhir class
?>