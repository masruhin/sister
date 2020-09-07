<?php
//----------------------------------------------------------------------------------------------------
//Program		: P1D01.php
//Sumber		: sister
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi KATEGORI
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class P1D01class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function P1D01_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdektg	=$_GET['kdektg'];

		$query ="	SELECT 		t_ktg.* 
					FROM 		t_ktg 
					WHERE 		(t_ktg.kdektg LIKE'%".$kdektg."%' OR '$kdektg'='')
					ORDER BY 	t_ktg.kdektg";
		$result	= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=perpustakaan.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>KATEGORI</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kode Kategori</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdektg'	
								ID			='kdektg'	
								TYPE		='text' 		
								SIZE		='5' 
								MAXLENGTH	='5' 
								onkeyup		='uppercase(this.id)'>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='P1D01_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='perpustakaan.php?mode=P1D01_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='perpustakaan.php?mode=P1D01' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:370px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No				</CENTER></TD>
						<TD WIDTH=' 5%'><CENTER>Kode			</CENTER></TD>
						<TD WIDTH='79%'><CENTER>Kategori		</CENTER></TD>
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
							<TD><CENTER>$no			</CENTER></TD>
							<TD>$data[kdektg]</TD>
							<TD>$data[nmaktg]</TD>";
							// otorisasi akses detil
							if (hakakses("P1D01D")==1)
							{
								echo"
								<TD><CENTER><a href='perpustakaan.php?mode=P1D01&kdektg=$data[kdektg]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("P1D01E")==1)
							{		
								echo"
								<TD><CENTER><a href='perpustakaan.php?mode=P1D01&kdektg=$data[kdektg]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("P1D01H")==1)
							{		
								echo"
								<TD><CENTER><a href='perpustakaan.php?mode=P1D01_Hapus&kdektg=$data[kdektg]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("P1D01T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah' onClick=window.location.href='perpustakaan.php?mode=P1D01&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function P1D01()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../perpustakaan/js/P1D01_validasi_kdektg.js'></SCRIPT>";
		
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
			$kdektgB=$_GET['kdektg'];
			$query 	="	SELECT 	t_ktg.* 
						FROM 	t_ktg 
						WHERE 	kdektg='". mysql_escape_string($kdektgB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$kdektg	=$data[kdektg];
			$nmaktg	=$data[nmaktg];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='perpustakaan.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>KATEGORI</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Kategori</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdektg'	
								TYPE		='text' 	
								SIZE		='5' 	
								MAXLENGTH	='5'
								VALUE 		='$kdektg'
								ID			='kdektg'
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
				<TR><TD>Nama Kategori</TD>
					<TD>: 
						<INPUT 	NAME		='nmaktg'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		=\"$nmaktg\"
								id			='nmaktg'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
			</TABLE>";

			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('P1D01T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='perpustakaan.php?mode=P1D01&pilihan=tambah'>";
			}	
					
			// tombol edit
			if (hakakses('P1D01E')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='perpustakaan.php?mode=P1D01&kdektg=$kdektg&pilihan=edit'>";
			}	
					
			// tombol hapus
			if (hakakses('P1D01H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='P1D01_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdektg'	VALUE='$kdektg'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='P1D01_Save'>";
			}
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='P1D01_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdektgB'	VALUE='$kdektgB'>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='perpustakaan.php?mode=P1D01_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function P1D01_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdektg	=$_POST['kdektg'];
		}
		else
		{
			$kdektg	=$_GET['kdektg'];
		}	
		
		$query	="	DELETE 
					FROM 	t_ktg 
					WHERE 	t_ktg.kdektg='". mysql_escape_string($kdektg)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=perpustakaan.php?mode=P1D01_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function P1D01_Save()
	{
  		$kdektgB=$_POST['kdektgB'];
  		$kdektg	=$_POST['kdektg'];
  		$nmaktg	=$_POST['nmaktg'];
		
  		$pilihan=$_POST['pilihan'];

		$set	="	SET	t_ktg.kdektg	='". mysql_escape_string($kdektg)."',
						t_ktg.nmaktg	='". mysql_escape_string($nmaktg)."'";
		
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_ktg ".$set. 
					 "	WHERE 	t_ktg.kdektg	='". mysql_escape_string($kdektgB)."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_ktg ".$set; 
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=perpustakaan.php?mode=P1D01&kdektg=$kdektg\">\n"; 
 	}
}//akhir class
?>