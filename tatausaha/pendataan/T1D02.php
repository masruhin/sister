<?php
//----------------------------------------------------------------------------------------------------
//Program		: T1D02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi ABSENSI SISWA
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class T1D02class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function T1D02()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>";
		
		$kdekls	=$_GET['kdekls'];
		$tglabs	=$_GET['tglabs'];
		$pilihan=$_GET['pilihan'];
		
		if($pilihan=='')
			$pilihan='baru';

		switch($pilihan)
		{
			case 'baru':
				$isian1	='disabled';
				$isian2	='disabled';
				$tglabs	=date("d-m-Y");
				break;
			case 'detil':
				$isian1	='disabled';
				$isian2	='disabled';
				break;
			case 'edit':
				$isian1	='disabled';
				$isian2	='enable';
				break;
		}		

		$query 	="	SELECT 		t_absssw.*,t_mstssw.*
					FROM 		t_absssw,t_mstssw
					WHERE 		t_absssw.kdekls	='". mysql_escape_string($kdekls)."'	AND
								t_absssw.tglabs	='". mysql_escape_string($tglabs)."'	AND
								t_absssw.nis=t_mstssw.nis
					ORDER BY	t_absssw.nis";
		$result =mysql_query($query);
		
		$i=0;
		while($data = mysql_fetch_array($result))
		{
			$cell[$i][0]=$data[nis];
			$cell[$i][1]=$data[nmassw];
			$cell[$i][2]=$data[kdestt];
			$cell[$i][3]=$data[jamdtn];
			$cell[$i][4]=$data[jampln];
			$cell[$i][5]=$data[ktr];
			$kdeusr		=$data[kdeusr];
			$tglrbh		=$data[tglrbh];
			$jamrbh		=$data[jamrbh];
		
			$i++;
		}

		echo"
		<FORM ACTION='tatausaha.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>ABSENSI SISWA</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD WIDTH='85%'>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";	
						$query2="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
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
					</TD>
				</TR>
              	<TR><TD>Tanggal</TD>
              		<TD>: 
						<INPUT 	NAME		='tglabs'  
								TYPE		='text' 
								SIZE		=10 
								MAXLENGTH	=10 
								VALUE		='$tglabs' 
								id			='tglabs'>
						<IMG onClick='WdatePicker({el:tglabs});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
						<INPUT TYPE='submit' 				VALUE='Tampilkan'>
						<INPUT TYPE='hidden' NAME='mode' 	VALUE='T1D02_isidata'>
					</TD>
              	</TR>				
			</TABLE>
		</FORM>
		
		<FORM ACTION='tatausaha.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;width:100%;height:360px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='10%'><CENTER>NIS 			</CENTER></TD>
						<TD WIDTH='26%'><CENTER>Nama Siswa	    </CENTER></TD>
						<TD WIDTH='10%'><CENTER>Status			</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Jam Datang		</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Jam Pulang		</CENTER></TD>
						<TD WIDTH='30%'><CENTER>Keterangan		</CENTER></TD>
					</TR>";
					$j=0;
					$no=1;
					while($j<$i)
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nmassw	='nmassw'.$j;
						$nmasswv=$cell[$j][1];
						$kdestt	='kdestt'.$j;
						$kdesttv=$cell[$j][2];
						$jamdtn	='jamdtn'.$j;
						$jamdtnv=$cell[$j][3];
						$jampln	='jampln'.$j;
						$jamplnv=$cell[$j][4];
						$ktr 	='ktr'.$j;
						$ktrv	=$cell[$j][5];
					
						if($kdesttv==4)
						{
							echo"<TR bgcolor='FFA3A1'>";
						}
						else
						{
							echo"<TR>";
						}
						
						echo"
							<TD HEIGHT='25'><CENTER>$no	</CENTER></TD>
							<TD><CENTER>$nisv</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>$nmasswv</CENTER></TD>
							<TD><CENTER>
								<SELECT	NAME		='$kdestt'	
										VALUE 		='$kdesttv'
										ONKEYPRESS	='return enter(this,event)'
										CLASS		='required'
										TITLE		='...harus diisi'
										$isian2>";
									$query="	SELECT 		t_sttabs.* 
												FROM 		t_sttabs  
												ORDER BY 	t_sttabs.kdestt";
									$result=mysql_query($query);
									while($data=mysql_fetch_array($result))
									{
										if ($kdesttv==$data[kdestt]) 
											echo"<OPTION VALUE='$data[kdestt]' SELECTED>$data[nmastt]</OPTION>";
										else 
											echo"<OPTION VALUE='$data[kdestt]'>$data[nmastt]</OPTION>";
									}
								echo
								"</SELECT>		
							</TD>
							<TD><CENTER>$jamdtnv</CENTER></TD>
							<TD><CENTER>$jamplnv</CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$ktr'
										TYPE		='text'
										SIZE		='50'
										MAXLENGTH	='50'
										VALUE 		='$ktrv'
										ID			='$ktr'
										ONKEYUP		='uppercase(this.id)'
										ONKEYPRESS	='return enter(this,event)'
										$isian2>
								</CENTER>
							</TD>
						</TR>";
	
						$j++;
						$no++;
					}		
				echo"	
				</TABLE>	
			</DIV>";
			
			// pilihan tombol pilihan
			// tombol edit
			if (hakakses('T1D02E')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='tatausaha.php?mode=T1D02&kdekls=$kdekls&tglabs=$tglabs&pilihan=edit'>";
			}	
				
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='T1D02_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<INPUT TYPE='hidden' NAME='tglabs'		VALUE=$tglabs>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}
			echo"
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
			$kdeusr - $tglrbh - $jamrbh
		</FORM>";
 	}

	// -------------------------------------------------- Save Absensi --------------------------------------------------
	function T1D02_Save()
	{
  		$kdeklsB=$_POST['kdekls'];
		$tglabsB=$_POST['tglabs'];
		$i		=$_POST['i'];
		$kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
			$kdestt ='kdestt'.$j;
			$kdestt	=$_POST["$kdestt"];
			$ktr 	='ktr'.$j;
			$ktr	=$_POST["$ktr"];
			
			if($kdestt=='')
				$kdestt==1;

			$set	="	SET		t_absssw.kdekls	='". mysql_escape_string($kdeklsB)."',
								t_absssw.nis	='". mysql_escape_string($nis)."',
								t_absssw.tglabs	='". mysql_escape_string($tglabsB)."',
								t_absssw.kdestt	='". mysql_escape_string($kdestt)."',
								t_absssw.ktr	='". mysql_escape_string($ktr)."',
								t_absssw.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_absssw.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_absssw.jamrbh	='". mysql_escape_string($jamrbh)."'";
								
    		$query 	="	UPDATE 	t_absssw ".$set. 
					 " 	WHERE 	t_absssw.kdekls	='". mysql_escape_string($kdeklsB)	."'	AND
								t_absssw.nis	='". mysql_escape_string($nis)	."'		AND
								t_absssw.tglabs	='". mysql_escape_string($tglabsB)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
			
			$j++;
		}
		echo"<meta http-equiv='refresh' content=\"0;url=tatausaha.php?mode=T1D02&kdekls=$kdeklsB&tglabs=$tglabsB&pilihan=detil\">\n";
 	}
	
	// -------------------------------------------------- Isi Data --------------------------------------------------
	function T1D02_isidata()
	{
  		$kdeklsB=$_POST['kdekls'];
		$tglabsB=$_POST['tglabs'];

		if($kdeklsB!='')
		{	
			$query2	="	SELECT 		t_mstssw.* 
						FROM 		t_mstssw
						WHERE 		t_mstssw.kdekls='$kdeklsB'";
			$result2= mysql_query($query2)	or die (mysql_error());						
	
			while($data =mysql_fetch_array($result2))
			{
				$nis 	=$data[nis];
				
				$query 	="	SELECT 		t_absssw.*
							FROM 		t_absssw
							WHERE 		t_absssw.kdekls	='". mysql_escape_string($kdeklsB)."'	AND
										t_absssw.nis	='". mysql_escape_string($nis)."'		AND
										t_absssw.tglabs	='". mysql_escape_string($tglabsB)."'";
				$result =mysql_query($query);
				$byk	=mysql_num_rows($result);

				if($byk=='')
				{
					$set	="	SET		t_absssw.kdekls	='". mysql_escape_string($kdeklsB)."',
										t_absssw.nis	='". mysql_escape_string($nis)."',
										t_absssw.tglabs	='". mysql_escape_string($tglabsB)."'";
					$query3 ="	INSERT INTO t_absssw ".$set; 
					$result3=mysql_query ($query3) or die (error("Data tidak berhasil di Input"));
				}	
			}	
		}
		echo"<meta http-equiv='refresh' content=\"0;url=tatausaha.php?mode=T1D02&kdekls=$kdeklsB&tglabs=$tglabsB&pilihan=detil\">\n";
 	}	
}//akhir class
?>