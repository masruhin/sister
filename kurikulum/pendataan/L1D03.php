<?php
//----------------------------------------------------------------------------------------------------
//Program		: L1D03.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi KELOMPOK KELAS
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class L1D03class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function L1D03_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$query ="	SELECT 		t_klmkls.*,t_msttkt.*
					FROM 		t_klmkls,t_msttkt
					WHERE		t_klmkls.kdetkt=t_msttkt.kdetkt
					ORDER BY 	t_klmkls.kdeklm";
		$result	=mysql_query($query)	or die (mysql_error());

		echo"
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>KELOMPOK KELAS</B></TD></TR>
				<TR></TR><TR></TR>
			</TABLE>
			
		<FORM ACTION='kurikulum.php?mode=L1D03' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:410px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kode Kelompok	</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kode Tingkat	</CENTER></TD>
						<TD WIDTH='64%'><CENTER>Nama Tingkat	</CENTER></TD>
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
							<TD><CENTER>$data[kdeklm]	</CENTER></TD>
							<TD><CENTER>$data[kdetkt]	</CENTER></TD>
							<TD><CENTER>$data[nmatkt]	</CENTER></TD>";
						
							// otorisasi akses detil
							if (hakakses("L1D03D")==1)
							{
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D03&kdeklm=$data[kdeklm]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("L1D03E")==1)
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D03&kdeklm=$data[kdeklm]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("L1D03H")==1)
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D03_Hapus&kdeklm=$data[kdeklm]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("L1D03T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah KELOMPOK KELAS' onClick=window.location.href='kurikulum.php?mode=L1D03&pilihan=tambah'>";
			}	
		echo"
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function L1D03()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>		
		<SCRIPT TYPE='text/javascript' 	src='../kurikulum/js/L1D03_validasi_kdeklm.js'></SCRIPT>";

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
			$kdeklmB=$_GET['kdeklm'];
			$query 	="	SELECT 	t_klmkls.*,t_msttkt.* 
						FROM 	t_klmkls,t_msttkt
						WHERE 	t_klmkls.kdeklm='". mysql_escape_string($kdeklmB)."'	AND
								t_klmkls.kdetkt=t_msttkt.kdetkt";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$kdeklm	=$data[kdeklm];
			$kdetkt	=$data[kdetkt];
			$nmatkt	=$data[nmatkt];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='kurikulum.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>KELOMPOK KELAS</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Kelompok Kelas</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdeklm'
								TYPE		='text' 	
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$kdeklm'
								ID			='kdeklm'
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
				<TR><TD>Kode Tingkat</TD>
					<TD>:
						<SELECT NAME		='kdetkt'
								ID			='kdetkt'
								ONKEYUP		='uppercase(this.id)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>";
						$query="	SELECT 		t_msttkt.*
									FROM 		t_msttkt
									ORDER BY 	t_msttkt.kdetkt";
						$result02=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						while($data02=mysql_fetch_array($result02))
						{
							if ($kdetkt==$data02[kdetkt])
								echo"<OPTION VALUE='$data02[kdetkt]' SELECTED>$data02[nmatkt]</OPTION>";
							else
								echo"<OPTION VALUE='$data02[kdetkt]'>$data02[nmatkt]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>					
			</TABLE>";

			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('L1D03T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='kurikulum.php?mode=L1D03&pilihan=tambah'>";
			}	
						
			// tombol edit
			if (hakakses('L1D03E')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='kurikulum.php?mode=L1D03&kdeklm=$kdeklm&pilihan=edit'>";
			}	
						
			// tombol hapus
			if (hakakses('L1D03H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D03_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdeklm'	VALUE='$kdeklm'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D03_Save'>";
			}
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='L1D03_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdeklmB'	VALUE='$kdeklmB'>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='kurikulum.php?mode=L1D03_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function L1D03_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdeklm	=$_POST['kdeklm'];
		}
		else
		{
			$kdeklm	=$_GET['kdeklm'];
		}	
		
		$query	="	DELETE 
					FROM 	t_klmkls
					WHERE 	t_klmkls.kdeklm='". mysql_escape_string($kdeklm)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D03_Cari\">\n";
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function L1D03_Save()
	{
  		$kdeklmB=$_POST['kdeklmB'];
  		$kdeklm	=$_POST['kdeklm'];
		$kdetkt	=$_POST['kdetkt'];
  		$pilihan=$_POST['pilihan'];
		$set	="	SET		t_klmkls.kdeklm	='". mysql_escape_string($kdeklm)."',
							t_klmkls.kdetkt	='". mysql_escape_string($kdetkt)."'";

  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_klmkls ".$set.
					 "	WHERE 	t_klmkls.kdeklm	='". mysql_escape_string($kdeklmB)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_klmkls ".$set; 
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D03&kdeklm=$kdeklm\">\n"; 
 	}
}//akhir class
?>