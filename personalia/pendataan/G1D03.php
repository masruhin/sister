<?php
//----------------------------------------------------------------------------------------------------
//Program		: G1D03.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi ABSENSI KARYAWAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class G1D03class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function G1D03()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>";
		
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

		$query 	="	SELECT 		t_abskry.kdekry,t_abskry.kdestt,t_abskry.ktr,t_mstkry.nmakry
					FROM 		t_abskry,t_mstkry
					WHERE 		t_abskry.tglabs	='". mysql_escape_string($tglabs)."'	AND
								t_abskry.kdekry=t_mstkry.kdekry
					ORDER BY	t_abskry.kdekry";
		$result =mysql_query($query);
		
		$i=0;
		while($data = mysql_fetch_array($result))
		{
			$cell[$i][0] 	=$data[kdekry];
			$cell[$i][1] 	=$data[nmakry];
			$cell[$i][2] 	=$data[kdestt];
			$cell[$i][3] 	=$data[ktr];
		
			$i++;
		}

		echo"
		<FORM ACTION='personalia.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>ABSENSI KARYAWAN</B></TD></TR>
				<TR></TR><TR></TR>
				
              	<TR><TD WIDTH='15%'>Tanggal</TD>
              		<TD WIDTH='85%'>: 
						<INPUT 	NAME		='tglabs'  
								TYPE		='text' 
								SIZE		=10 
								MAXLENGTH	=10 
								VALUE		='$tglabs' 
								id			='tglabs'>
						<IMG onClick='WdatePicker({el:tglabs});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
						<INPUT TYPE='submit' 				VALUE='Tampilkan'>
						<INPUT TYPE='hidden' NAME='mode' 	VALUE='G1D03_isidata'>
					</TD>
              	</TR>				
			</TABLE>
		</FORM>
		
		<FORM ACTION='personalia.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;width:100%;height:370px;padding-right:-2px;'>			
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kode 			</CENTER></TD>
						<TD WIDTH='44%'><CENTER>Nama Karyawan   </CENTER></TD>
						<TD WIDTH='10%'><CENTER>Status			</CENTER></TD>
						<TD WIDTH='32%'><CENTER>Keterangan		</CENTER></TD>
					</TR>";
					$j=0;
					$no=1;
					while($j<$i)
					{
						$kdekry	='kdekry'.$j;
						$kdekryv=$cell[$j][0];
						$nmakry	='nmakry'.$j;
						$nmakryv=$cell[$j][1];
						$kdestt	='kdestt'.$j;
						$kdesttv=$cell[$j][2];
						$ktr 	='ktr'.$j;
						$ktrv	=$cell[$j][3];
					
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
							<TD><CENTER>$kdekryv</CENTER>
								<INPUT TYPE='hidden' NAME='$kdekry'		VALUE=$kdekryv>		
							</TD>
							<TD><CENTER>$nmakryv</CENTER>
							</TD>
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
			</DIV>
			<BR>";
			
			// pilihan tombol pilihan
			// tombol edit
			if (hakakses('G1D03E')==1 and ($pilihan=='detil' or $pilihan=='baru'))
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='personalia.php?mode=G1D03&tglabs=$tglabs&pilihan=edit'>";
			}	
				
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='G1D03_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='edit'>
				<INPUT TYPE='hidden' NAME='tglabs'		VALUE=$tglabs>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}
			echo"
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>";
 	}

	// -------------------------------------------------- Save Absensi --------------------------------------------------
	function G1D03_Save()
	{
		$tglabsB=$_POST['tglabs'];
		$i		=$_POST['i'];
		$kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

		$j=0;
		while($j<$i)
		{
			$kdekry 	='kdekry'.$j;
			$kdekry	=$_POST["$kdekry"]; 
			$kdestt ='kdestt'.$j;
			$kdestt	=$_POST["$kdestt"];
			$ktr 	='ktr'.$j;
			$ktr	=$_POST["$ktr"];
			
			if($kdestt=='')
				$kdestt==1;

			$set	="	SET		t_abskry.kdekry	='". mysql_escape_string($kdekry)."',
								t_abskry.tglabs	='". mysql_escape_string($tglabsB)."',
								t_abskry.kdestt	='". mysql_escape_string($kdestt)."',
								t_abskry.ktr	='". mysql_escape_string($ktr)."',
								t_abskry.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_abskry.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_abskry.jamrbh	='". mysql_escape_string($jamrbh)."'";
								
    		$query 	="	UPDATE 	t_abskry ".$set. 
					 " 	WHERE 	t_abskry.kdekry	='". mysql_escape_string($kdekry)	."'		AND
								t_abskry.tglabs	='". mysql_escape_string($tglabsB)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
			
			$j++;
		}
		echo"<meta http-equiv='refresh' content=\"0;url=personalia.php?mode=G1D03&tglabs=$tglabsB&pilihan=detil\">\n";
 	}
	
	// -------------------------------------------------- Isi Data --------------------------------------------------
	function G1D03_isidata()
	{
		$tglabsB=$_POST['tglabs'];

		$query 	="	SELECT 		t_abskry.*
					FROM 		t_abskry
					WHERE 		t_abskry.tglabs	='". mysql_escape_string($tglabsB)."'";
		$result =mysql_query($query);
		$byk	=mysql_num_rows($result);
		
		if($byk=='')
		{	
			$query	="	SELECT 		t_mstkry.* 
						FROM 		t_mstkry";
			$result	= mysql_query($query)	or die (mysql_error());						
	
			while($data =mysql_fetch_array($result))
			{
				$kdekry 	=$data[kdekry];

				$set	="	SET		t_abskry.kdekry	='". mysql_escape_string($kdekry)."',
									t_abskry.tglabs	='". mysql_escape_string($tglabsB)."'";
				$query2 ="	INSERT INTO t_abskry ".$set; 
				$result2=mysql_query ($query2) or die (error("Data tidak berhasil di Input"));
			}	
		}
		$pilihan='detil';
		echo"<meta http-equiv='refresh' content=\"0;url=personalia.php?mode=G1D03&tglabs=$tglabsB&pilihan=$pilihan\">\n";
 	}	
}//akhir class
?>