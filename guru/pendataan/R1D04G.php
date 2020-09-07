<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04G.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT EXTRA CURRICULAR
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Gclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04G_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
			
		$query	="	SELECT 		DISTINCT t_mstplj.kdeplj,t_mstplj.nmaplj
								FROM 		t_mstpng,t_mstplj
								WHERE		t_mstpng.kdegru='$kdekry' AND
											t_mstpng.kdeplj=t_mstplj.kdeplj	AND
											t_mstplj.str='X'"; // menghasilkan subjek ekstra kurikuler
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><B>INPUT EXTRACURRICULAR (PS)</B></TD></TR>
			<TR></TR><TR></TR>
		</TABLE>
			
		<FORM ACTION='guru.php?mode=R1D04G' METHOD='post'>
			<DIV style='overflow:auto;width:25%;height:380px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH='80%' HEIGHT='20'><CENTER>Subject	</CENTER></TD>
						<TD WIDTH='20%'><CENTER>Detail	</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD>$data[nmaplj]</TD>
							<TD><CENTER><a href='guru.php?mode=R1D04G&kdeplj=$data[kdeplj]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>
		</FORM>
		<span style='color: #FF0000;'><B><U>Note</U></B></span><BR>
		<span style='color: #FF0000;'>Subject only for Extracurricular</span>";
 	}

	function R1D04G()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$kdeplj	=$_GET['kdeplj'];
		$pilihan=$_GET['pilihan'];
		$sms='';
		$midtrm='';
		
		//$thn_ajr	=$_GET['thn_ajr'];
		
		if( substr($kdekls,0,4)=='SHS-' )
		{
			$sms	='Semester';
			$query 	=mysql_query("	SELECT 		t_setthn_sma.* 
									FROM 		t_setthn_sma
									WHERE		t_setthn_sma.set='$sms'");//menghasilkan semester berapa
			$data = mysql_fetch_array($query);
			$sms=$data[nli];
						
			$midtrm	='Mid Term';
			$query 	=mysql_query("	SELECT 		t_setthn_sma.* 
									FROM 		t_setthn_sma
									WHERE		t_setthn_sma.set='$midtrm'");// menghasilkan mid berapa
			$data = mysql_fetch_array($query);
			$nlitrm=$data[nli];
			$midtrm=$midtrm.' '.$nlitrm;
		}
		else if( substr($kdekls,0,2)=='P-' )
		{
			$sms	='Semester';
			$query 	=mysql_query("	SELECT 		t_setthn_sd.* 
									FROM 		t_setthn_sd
									WHERE		t_setthn_sd.set='$sms'");//menghasilkan semester berapa
			$data = mysql_fetch_array($query);
			$sms=$data[nli];
						
			$midtrm	='Mid Term';
			$query 	=mysql_query("	SELECT 		t_setthn_sd.* 
									FROM 		t_setthn_sd
									WHERE		t_setthn_sd.set='$midtrm'");// menghasilkan mid berapa
			$data = mysql_fetch_array($query);
			$nlitrm=$data[nli];
			$midtrm=$midtrm.' '.$nlitrm;
		}
		else if( substr($kdekls,0,4)=='JHS-' )
		{
			$sms	='Semester';
			$query 	=mysql_query("	SELECT 		t_setthn_smp.* 
									FROM 		t_setthn_smp
									WHERE		t_setthn_smp.set='$sms'");//menghasilkan semester berapa
			$data = mysql_fetch_array($query);
			$sms=$data[nli];
						
			$midtrm	='Mid Term';
			$query 	=mysql_query("	SELECT 		t_setthn_smp.* 
									FROM 		t_setthn_smp
									WHERE		t_setthn_smp.set='$midtrm'");// menghasilkan mid berapa
			$data = mysql_fetch_array($query);
			$nlitrm=$data[nli];
			$midtrm=$midtrm.' '.$nlitrm;
		}
		else
		{
			$sms	='Semester';
			$query 	=mysql_query("	SELECT 		t_setthn.* 
									FROM 		t_setthn
									WHERE		t_setthn.set='$sms'");//menghasilkan semester berapa
			$data = mysql_fetch_array($query);
			$sms=$data[nli];
						
			$midtrm	='Mid Term';
			$query 	=mysql_query("	SELECT 		t_setthn.* 
									FROM 		t_setthn
									WHERE		t_setthn.set='$midtrm'");// menghasilkan mid berapa
			$data = mysql_fetch_array($query);
			$nlitrm=$data[nli];
			$midtrm=$midtrm.' '.$nlitrm;
		}
		
		$query="	SELECT 			t_mstplj.*
					FROM 			t_mstplj
					WHERE 			t_mstplj.kdeplj='$kdeplj'";//menghasilkan subjek ekstrakuriler bersangkutan
		$result=mysql_query($query);
		$data=mysql_fetch_array($result);
		$nmaplj=$data[nmaplj];
		
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

		$query 	="	SELECT 		t_mstssw.*
					FROM 		t_mstssw
					WHERE 		t_mstssw.kdekls	='". mysql_escape_string($kdekls)."' AND 
								
								t_mstssw.str != 'K'
					ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw";//t_mstssw.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND 
					// menghasilkan semua murid per kelas
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

			$query2	="	SELECT 		t_extcrrps.*
						FROM 		t_extcrrps
						WHERE 		t_extcrrps.nis		='". mysql_escape_string($nis)."'	AND
									t_extcrrps.kdeplj	='". mysql_escape_string($kdeplj)."'  "; //AND t_extcrrps.thn_ajaran		='". mysql_escape_string($thn_ajr)."'
									
									// menghasilkan nilai ektrakuriler per murid
			$result2 =mysql_query($query2);
			$data2 	 =mysql_fetch_array($result2);
			$cell[$i][2]=$data2['ext'."$sms"."$nlitrm"];
			$cell[$i][3]=$data2['ktr'."$sms"."$nlitrm"];
			
			$i++;
		}

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>INPUT EXTRA CURRICULAR  <span style='color: #FF0000;'>( $nmaplj )</span></B></TD></TR>
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
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04G'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						<INPUT TYPE='hidden' 	NAME='kdeplj'	VALUE=$kdeplj>
					</TD>
						
              	</TR>
				<!--<tr>
					<td>Tahun Pelajaran</td><td> : 
						
						<input type='text' NAME='thn_ajr' ID='thn_ajr' value='2018-2019' readonly/>
						<INPUT TYPE='submit' 					VALUE='View'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04G'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						<INPUT TYPE='hidden' 	NAME='kdeplj'	VALUE=$kdeplj>
						
					</td>
				</tr>-->	
			</TABLE>
		</FORM>
		
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 3%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='20%'><CENTER>Student	</CENTER></TD>
						<TD WIDTH='07%'><CENTER>Grade	</CENTER></TD>
						<TD WIDTH='66%'><CENTER>Note	</CENTER></TD>
					</TR>";
					$j=0;
					$no=1;
					while($j<$i)
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nmassw'.$j;
						$nmav	=$cell[$j][1];
						$ext	='ext'."$sms"."$nlitrm".$j;
						$extv	=$cell[$j][2];
						$ktr	='ktr'."$sms"."$nlitrm".$j;
						$ktrv	=$cell[$j][3];
				
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>$nmav</CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$ext'
										TYPE		='text'
										SIZE		='1'
										MAXLENGTH	='1'
										VALUE 		='$extv'
										ID			='$ext'
										ONKEYUP		='uppercase(this.id)'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$ktr'
										TYPE		='text'
										SIZE		='100'
										MAXLENGTH	='200'
										VALUE 		='$ktrv'
										ID			='$ktr'
										
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
			<BR>
			";//Pelajaran

			// pilihan tombol pilihan
			if ($pilihan=='detil'  AND $kdekls!='')
			{
				echo"<INPUT TYPE='button' 	VALUE='Subject' 	onClick=window.location.href='guru.php?mode=R1D04G_Cari' />";
				
				echo"
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='guru.php?mode=R1D04G&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit'>";//&thn_ajr=$thn_ajr
				if($kdekls!='')
				{
					echo"<INPUT TYPE='button'	VALUE='Setting by Class' 	onClick=window.location.href='guru.php?mode=R1D04G&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=seting'>";//&thn_ajr=$thn_ajr
				}	
				
			}	
				
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='SAVE'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04G_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdeplj'		VALUE=$kdeplj>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<!--<INPUT TYPE='hidden' NAME='thn_ajr'		VALUE=$thn_ajr>-->
				<INPUT TYPE='hidden' NAME='sms'			VALUE=$sms>
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE=$nlitrm>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}

			if($pilihan=='seting')
			{
				echo"
				Seting Nilai  :
				<INPUT 	NAME		='midtrms'
						TYPE		='text'
						SIZE		='1'
						MAXLENGTH	='1'
						VALUE 		='$midtrms'
						ID			='midtrms'
						ONKEYUP		='uppercase(this.id)'
						ONKEYPRESS	='return enter(this,event)'
						$isian2></CENTER>
				<INPUT TYPE='submit' 					VALUE='SAVE'>
				<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04G_Save'>
				<INPUT TYPE='hidden' NAME='kdeplj'		VALUE=$kdeplj>
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
	function R1D04G_Save()
	{
		$kdekls	=$_POST['kdekls'];
		$kdeplj	=$_POST['kdeplj'];
		//$thn_ajr	=$_POST['thn_ajr'];
		$sms	=$_POST['sms'];
		$nlitrm	=$_POST['nlitrm'];
		$midtrms=$_POST['midtrms'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
			$ext 	="ext"."$sms"."$nlitrm".$j;
			if($midtrms=='')
			{
				$ext	=$_POST["$ext"]; 
			}	
			else
			{
				$ext	=$midtrms;
			}	
			$ktr 	="ktr"."$sms"."$nlitrm".$j;
			$ktr	=$_POST["$ktr"]; 

			if($midtrms=='')
			{
				$set	="	SET		t_extcrrps.nis		='". mysql_escape_string($nis)."',
									t_extcrrps.kdeplj	='". mysql_escape_string($kdeplj)."',
									
									t_extcrrps.ext"."$sms"."$nlitrm"."	='". mysql_escape_string($ext)."',
									t_extcrrps.ktr"."$sms"."$nlitrm"."	='". mysql_escape_string($ktr)."',
									t_extcrrps.kdeusr	='". mysql_escape_string($kdeusr)."',
									t_extcrrps.tglrbh	='". mysql_escape_string($tglrbh)."',
									t_extcrrps.jamrbh	='". mysql_escape_string($jamrbh)."'"; //t_extcrrps.thn_ajaran	='". mysql_escape_string($thn_ajr)."',
			}
			else
			{	
				$set	="	SET		t_extcrrps.nis		='". mysql_escape_string($nis)."',
									t_extcrrps.kdeplj	='". mysql_escape_string($kdeplj)."',
									
									t_extcrrps.ext"."$sms"."$nlitrm"."	='". mysql_escape_string($ext)."',
									t_extcrrps.kdeusr	='". mysql_escape_string($kdeusr)."',
									t_extcrrps.tglrbh	='". mysql_escape_string($tglrbh)."',
									t_extcrrps.jamrbh	='". mysql_escape_string($jamrbh)."'"; //t_extcrrps.thn_ajaran	='". mysql_escape_string($thn_ajr)."',
			}
			$query	="	SELECT 		t_extcrrps.*
						FROM 		t_extcrrps
						WHERE 		t_extcrrps.nis	='". mysql_escape_string($nis)."'	AND
									t_extcrrps.kdeplj	='". mysql_escape_string($kdeplj)."' 		";//AND t_extcrrps.thn_ajaran	='". mysql_escape_string($thn_ajr)."'
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_extcrrps ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
			}
			else
			{
				$query 	="	UPDATE 	t_extcrrps ".$set.
						"	WHERE 	t_extcrrps.nis	='". mysql_escape_string($nis)	."'	AND
									t_extcrrps.kdeplj	='". mysql_escape_string($kdeplj)	."' 	";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));	//AND t_extcrrps.thn_ajaran	='". mysql_escape_string($thn_ajr)."'	
			}	
			$j++;
		}
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04G&kdeplj=$kdeplj&kdekls=$kdekls&nis=$nis&pilihan=detil\">\n";//&thn_ajr=$thn_ajr
 	}		
}//akhir class
?>