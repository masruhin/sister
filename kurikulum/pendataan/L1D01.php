<?php
//----------------------------------------------------------------------------------------------------
//Program		: L1D01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi TINGKAT
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class L1D01class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function L1D01_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdetkt	=$_GET['kdetkt'];
		
		$query ="	SELECT 		t_msttkt.* 
					FROM 		t_msttkt
					WHERE 		(t_msttkt.kdetkt LIKE'%".$kdetkt."%' OR '$kdetkt'='')
					ORDER BY 	t_msttkt.kdetkt";
		$result	=mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=kurikulum.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>TINGKAT</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kode Tingkat</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdetkt'	
								ID			='kdetkt'	
								TYPE		='text' 		
								SIZE		='10' 
								MAXLENGTH	='10'
								onkeyup		='uppercase(this.id)'>								
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='L1D01_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='kurikulum.php?mode=L1D01_Cari'>
					</TD>
				</TR>	
			</TABLE>
		</FORM>
			
		<FORM ACTION='kurikulum.php?mode=L1D01' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:370px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kode Tingkat	</CENTER></TD>
						<TD WIDTH='74%'><CENTER>Nama Tingkat	</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detil			</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit			</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Hapus			</CENTER></TD>
					</TR>";
					
					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[kdetkt]	</CENTER></TD>
							<TD><CENTER>$data[nmatkt]	</CENTER></TD>";
						
							// otorisasi akses detil
							if (hakakses("L1D01D")==1)
							{
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D01&kdetkt=$data[kdetkt]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("L1D01E")==1)
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D01&kdetkt=$data[kdetkt]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("L1D01H")==1)
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D01_Hapus&kdetkt=$data[kdetkt]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else	
							{
								echo"
								<TD><CENTER><IMG src='../images/hapus_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						echo"	
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>
			<BR>";
			// otorisasi akses tambah
			if (hakakses("L1D01T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah TINGKAT' onClick=window.location.href='kurikulum.php?mode=L1D01&pilihan=tambah'>";
			}	
		echo"
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function L1D01()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>		
		<SCRIPT TYPE='text/javascript' 	src='../kurikulum/js/L1D01_validasi_kdetkt.js'></SCRIPT>";

		echo"
		<SCRIPT TYPE='text/javascript' src='../js/jquery-1.2.3.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/jquery.validate.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript'>
			$(document).ready(function()
			{
				$('#validasi').validate()
			});
		</SCRIPT>";

		// inisiasi parameter berdasarkan pilihan tombol
		$pilihan=$_GET['pilihan'];

		if (empty($pilihan))
		{
			$pilihan='detil';
		}

		switch($pilihan)
		{
			case 'detil':
				$isian	='disabled';
				break;
			case 'tambah':
				$isian	='enable';
				break;
			case 'edit':
				$isian	='enable';
				break;
		}		
		
		if ($pilihan=='detil' OR $pilihan=='edit')
		{
			$kdetktB=$_GET['kdetkt'];
			$query 	="	SELECT 	t_msttkt.* 
						FROM 	t_msttkt
						WHERE 	kdetkt='". mysql_escape_string($kdetktB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$kdetkt	=$data[kdetkt];
			$nmatkt	=$data[nmatkt];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='kurikulum.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>TINGKAT</B></TD>
					<TD ALIGN='right'>";
						if ($pilihan=='detil')
						{
							echo"
							| <a href='kurikulum.php?mode=L1D01_Personil&kdetkt=$kdetkt&pilihan=$pilihan'>Personil</a>";
						}	
					echo"
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Tingkat</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdetkt'
								TYPE		='text' 	
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$kdetkt'
								ID			='kdetkt'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
						<SPAN 	ID			='msgbox'  
								STYLE		='display:none'>
						</SPAN>
					</TD>
				</TR>
				<TR><TD>Nama Tingkat</TD>
					<TD>: 
						<INPUT 	NAME		='nmatkt'
								TYPE		='text' 	
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmatkt'
								ID			='nmatkt'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
						</SPAN>
					</TD>
				</TR>
			</TABLE>";

			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('L1D01T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='kurikulum.php?mode=L1D01&pilihan=tambah'>";
			}	
						
			// tombol edit
			if (hakakses('L1D01E')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='kurikulum.php?mode=L1D01&kdetkt=$kdetkt&pilihan=edit'>";
			}	
						
			// tombol hapus
			if (hakakses('L1D01H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D01_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdetkt'	VALUE='$kdetkt'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D01_Save'>";
			}
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='L1D01_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdetktB'	VALUE='$kdetktB'>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='kurikulum.php?mode=L1D01_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function L1D01_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdetkt	=$_POST['kdetkt'];
		}
		else
		{
			$kdetkt	=$_GET['kdetkt'];
		}	
		
		$query	="	DELETE 
					FROM 	t_msttkt
					WHERE 	t_msttkt.kdetkt='". mysql_escape_string($kdetkt)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D01_Cari\">\n";
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function L1D01_Save()
	{
  		$kdetktB=$_POST['kdetktB'];
  		$kdetkt	=$_POST['kdetkt'];
		$nmatkt	=$_POST['nmatkt'];
  		$pilihan=$_POST['pilihan'];
		$set	="	SET		t_msttkt.kdetkt	='". mysql_escape_string($kdetkt)."',
							t_msttkt.nmatkt	='". mysql_escape_string($nmatkt)."'";

  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_msttkt ".$set.
					 "	WHERE 	t_msttkt.kdetkt	='". mysql_escape_string($kdetktB)."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_msttkt ".$set; 
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D01&kdetkt=$kdetkt\">\n"; 
 	}
	
	// -------------------------------------------------- Detil Personil --------------------------------------------------
	function L1D01_Personil()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		// ikdetktiasi parameter berdasarkan pilihan tombol
		$pilihan	=$_GET['pilihan'];
		
		switch($pilihan)
		{
			case 'detil':
				$isian	='disabled';
				break;
			case 'edit':
				$isian	='enable';
				break;
		}		
		
		$kdetktB=$_GET['kdetkt'];
		$query 	="	SELECT 	t_msttkt.*
					FROM 	t_msttkt
					WHERE 	t_msttkt.kdetkt='". mysql_escape_string($kdetktB)."'";
		$result= mysql_query($query) or die (mysql_error());
		$data 	=mysql_fetch_array($result);
		$kdetkt	=$data[kdetkt];
		$nmatkt	=$data[nmatkt];
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='kurikulum.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>PERSONIL</B></TD>
					<TD COLSPAN='2' ALIGN='right'>
						| <a href='kurikulum.php?mode=L1D01&kdetkt=$kdetkt&pilihan=$pilihan'>Tingkat</a>
					</TD>
				</TR>
				
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Tingkat</TD>
					<TD WIDTH='85%'>:
						<INPUT 	NAME		='kdetkt'
								TYPE		='text' 	
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$kdetkt'
								DISABLED>
					</TD>
				</TR>				
				<TR><TD>Nama Tingkat</TD>
					<TD>:
						<INPUT 	NAME		='nmatkt'
								TYPE		='text' 	
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmatkt'
								DISABLED>
					</TD>
				</TR>				
				<TR><TD COLSPAN='2'><HR></TD></TR>		
			</TABLE>	
			
			<DIV style='overflow:auto;width:100%;height:340px;padding-right:-2px;'>                
				<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
					<TR>
						<TD WIDTH='50%' VALIGN='top'><B>PERSONIL YANG DIPILIH</B>
							<INPUT TYPE='button'	VALUE='Hapus Semua Personil yang dipilih' 	onClick=window.location.href='kurikulum.php?mode=L1D01_Hapus_Personil_Semua&kdetkt=$kdetkt'>";
							$query1 ="	SELECT 		t_prstkt.*,t_mstkry.*
										FROM 		t_prstkt,t_mstkry
										WHERE 		t_prstkt.kdetkt	='$kdetktB'			AND
													t_prstkt.kdekry	=t_mstkry.kdekry	
										ORDER BY 	t_mstkry.nmakry"; 
							$result1= mysql_query($query1)	or die (mysql_error());
						
							echo"
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD WIDTH='15%' HEIGHT='20'><CENTER>Kode</CENTER></TD>
									<TD WIDTH='45%'><CENTER>Nama 			</CENTER></TD>
									<TD WIDTH='30%'><CENTER>Status 			</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Hapus 			</CENTER></TD>
								</TR>";
								$i=0;
								while($data1 =mysql_fetch_array($result1))
								{
									$kdekry	='kdekry'.$i;
									$kdekryv=$data1[kdekry];
									$nmakry	='nmakry'.$i;
									$nmakryv=$data1[nmakry];
									$kdejbt	='kdejbt'.$i;
									$kdejbtv=$data1[kdejbt];
									
									echo"
									<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
										<TD><CENTER>$kdekryv</CENTER>
											<INPUT TYPE='hidden' NAME='$kdekry'		VALUE=$kdekryv>	
										</TD>
										<TD>$nmakryv</TD>
										<TD><CENTER>
											<SELECT	NAME		='$kdejbt'	
													VALUE 		='$kdejbtv'
													onkeypress	='return enter(this,event)'
													$isian>
											<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";			
											$query	="	SELECT 		t_mstjbt.* 
														FROM 		t_mstjbt  
														ORDER BY 	t_mstjbt.kdejbt";
											$result	=mysql_query($query);
											while($data=mysql_fetch_array($result))
											{
												if ($kdejbtv==$data[kdejbt]) 
													echo"<OPTION VALUE='$data[kdejbt]' SELECTED>$data[nmajbt]</OPTION>";
												else 
													echo"<OPTION VALUE='$data[kdejbt]' >$data[nmajbt]</OPTION>";
											}
											echo"
											</SELECT>
											</CENTER>
										</TD>
										<TD><CENTER><a href='kurikulum.php?mode=L1D01_Hapus_Personil&kdetkt=$data1[kdetkt]&&kdekry=$data1[kdekry]'><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
									echo"	
									</TR>";
									$i++;
								}
							echo"	
							</TABLE>		
						</TD>
				
						<TD WIDTH='50%' VALIGN='top'><B>PILIHAN PERSONIL</B>
							<INPUT TYPE='button'	VALUE='Pilih Semua Personil' 	onClick=window.location.href='kurikulum.php?mode=L1D01_Save_Personil_Semua&kdetkt=$kdetkt'>";
							$query2 ="	SELECT 		DISTINCT t_mstkry.*,t_prstkt.kdetkt
										FROM 		t_mstkry
										LEFT JOIN 	t_prstkt ON t_mstkry.kdekry=t_prstkt.kdekry	AND t_prstkt.kdetkt='$kdetkt'
										ORDER BY 	t_mstkry.nmakry";  
							$result2= mysql_query($query2)	or die (mysql_error());
							echo"
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD WIDTH='15%' HEIGHT='20'><CENTER>Kode</CENTER></TD>
									<TD WIDTH='75%'><CENTER>Nama 			</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Pilih 			</CENTER></TD>
								</TR>";

								while($data2 =mysql_fetch_array($result2))
								{
									$kdetkt	=$data2[kdetkt];
									echo"
									<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
										<TD><CENTER>$data2[kdekry]</CENTER></TD>
										<TD>$data2[nmakry]</TD>";

										if($kdetkt=='')
										{
											echo"
											<TD><CENTER><a href='kurikulum.php?mode=L1D01_Save_Personil&kdetkt=$kdetktB&kdekry=$data2[kdekry]'><IMG src='../images/pilih_e.gif' BORDER='0'></a></CENTER></TD>";
										}
										else
										{
											echo"
											<TD><CENTER><IMG src='../images/pilih_d.gif' BORDER='0'></a></CENTER></TD>";
										}
									echo"	
									</TR>";
								}
							echo"	
							</TABLE>
						</TD>
					</TR>
				</TABLE>
			</DIV>
			<BR>";
			
			// pilihan tombol pilihan
			if($pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Edit Status' 	onClick=window.location.href='kurikulum.php?mode=L1D01_Personil&kdetkt=$kdetktB&pilihan=edit'>";
			}
			else
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='L1D01_Save_Edit_Personil'>
				<INPUT TYPE='hidden' NAME='kdetkt'		VALUE=$kdetktB>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
				
			}	
			echo"	
			<INPUT TYPE='button' 	VALUE='Daftar TINGKAT' 	onClick=window.location.href='kurikulum.php?mode=L1D01_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}	
	
	// -------------------------------------------------- Hapus_Personil --------------------------------------------------
	function L1D01_Hapus_Personil()
	{
		$kdetkt	=$_GET['kdetkt'];		
		$kdekry=$_GET['kdekry'];
		
		$query	="	DELETE 
					FROM 	t_prstkt
					WHERE 	t_prstkt.kdetkt='". mysql_escape_string($kdetkt)."'	AND
							t_prstkt.kdekry='". mysql_escape_string($kdekry)."'";
		$result	=mysql_query($query) or die (mysql_error());

		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D01_Personil&kdetkt=$kdetkt&pilihan=detil\">\n";
	}	

	// -------------------------------------------------- Hapus_Personil_Semua --------------------------------------------------
	function L1D01_Hapus_Personil_Semua()
	{
		$kdetkt	=$_GET['kdetkt'];		
		
		$query	="	DELETE 
					FROM 	t_prstkt
					WHERE 	t_prstkt.kdetkt='". mysql_escape_string($kdetkt)."'";	
		$result	=mysql_query($query) or die (mysql_error());

		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D01_Personil&kdetkt=$kdetkt&pilihan=detil\">\n";
	}	
	
	// -------------------------------------------------- Save Tata Usaha --------------------------------------------------
	function L1D01_Save_Personil()
	{
  		$kdetkt	=$_GET['kdetkt'];
  		$kdekry	=$_GET['kdekry'];
		$kdejbt	=$_GET['kdejbt'];
		
		$set	="	SET		t_prstkt.kdetkt	='". mysql_escape_string($kdetkt)."',
							t_prstkt.kdekry	='". mysql_escape_string($kdekry)."',
							t_prstkt.kdejbt	='". mysql_escape_string($kdejbt)."'";

		$query 	="	INSERT INTO t_prstkt ".$set; 
		$result	=mysql_query($query) or die (mysql_error());
		$pilihan='detil';

		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D01_Personil&kdetkt=$kdetkt&pilihan=$pilihan\">\n";
 	}	
	
	// -------------------------------------------------- Save Tata Usaha --------------------------------------------------
	function L1D01_Save_Personil_Semua()
	{
  		$kdetkt	=$_GET['kdetkt'];

		$query 	="	SELECT 		t_mstkry.*
					FROM 		t_mstkry"; 
		$result	=mysql_query($query) or die (mysql_error());

		while($data =mysql_fetch_array($result))
		{
			$kdekry	=$data[kdekry];

			$set	="	SET		t_prstkt.kdetkt	='". mysql_escape_string($kdetkt)."',
								t_prstkt.kdekry	='". mysql_escape_string($kdekry)."'";

			$query2 ="	INSERT INTO t_prstkt ".$set; 
			$result2=mysql_query($query2) or die (mysql_error());
		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D01_Personil&kdetkt=$kdetkt&pilihan=detil\">\n";
 	}		
	
	// -------------------------------------------------- Save Edit --------------------------------------------------
	function L1D01_Save_Edit_Personil()
	{
		$kdetkt	=$_POST['kdetkt'];
		$i		=$_POST['i'];

		$j=0;
		while($j<$i)
		{
			$kdekry ='kdekry'.$j;
			$kdekry	=$_POST["$kdekry"]; 
			$kdejbt ='kdejbt'.$j;
			$kdejbt	=$_POST["$kdejbt"];

			$set	="	SET		t_prstkt.kdekry	='". mysql_escape_string($kdekry)."',
								t_prstkt.kdejbt	='". mysql_escape_string($kdejbt)."'";
								
    		$query 	="	UPDATE 	t_prstkt ".$set. 
					 " 	WHERE 	t_prstkt.kdetkt	='". mysql_escape_string($kdetkt)	."'		AND
								t_prstkt.kdekry	='". mysql_escape_string($kdekry)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
			
			$j++;
		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D01_Personil&kdetkt=$kdetkt&pilihan=detil\">\n";
 	}	
}//akhir class
