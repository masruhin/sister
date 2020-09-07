<?php
//----------------------------------------------------------------------------------------------------
//Program		: K1D02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 23/04/2012
//Keterangan	: Fungsi-fungsi JENIS PENGELUARAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class K1D02class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function K1D02_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdejku	=$_GET['kdejku'];

		$query 	="	SELECT 		t_jku.* 
					FROM 		t_jku 
					WHERE 		(t_jku.kdejku LIKE'%".$kdejku."%' OR '$kdejku'='')
					ORDER BY 	t_jku.kdejku";
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<FORM ACTION=keuangan.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>JENIS PENGELUARAN</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kode Jenis</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdejku'
								ID			='kdejku'
								TYPE		='text' 		
								SIZE		='10' 
								MAXLENGTH	='10'
								onkeyup		='uppercase(this.id)'>								
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='K1D02_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='keuangan.php?mode=K1D02_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='keuangan.php?mode=K1D02' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:370px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No		</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kode	</CENTER></TD>
						<TD WIDTH='74%'><CENTER>Jenis	</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detil	</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit	</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Hapus	</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no		</CENTER></TD>
							<TD>$data[kdejku]</TD>
							<TD>$data[nmajku]</TD>";
							// otorisasi akses detil
							if (hakakses("K1D02D")==1)
							{
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D02&kdejku=$data[kdejku]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("K1D02E")==1)
							{		
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D02&kdejku=$data[kdejku]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("K1D02H")==1)
							{		
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D02_Hapus&kdejku=$data[kdejku]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("K1D02T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah JENIS PENGELUARAN' onClick=window.location.href='keuangan.php?mode=K1D02&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function K1D02()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../keuangan/js/K1D02_validasi_kdejku.js'></SCRIPT>";
		
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
			$kdejkuB=$_GET['kdejku'];
			$query 	="	SELECT 	t_jku.* 
						FROM 	t_jku 
						WHERE 	kdejku='". mysql_escape_string($kdejkuB)."'";
			$result	=mysql_query($query) or die (mysql_error());
			$data 	=mysql_fetch_array($result);
		
			$kdejku	=$data[kdejku];
			$nmajku	=$data[nmajku];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='keuangan.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>JENIS PENGELUARAN</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Jenis</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdejku'	
								TYPE		='text' 	
								SIZE		='10' 	
								MAXLENGTH	='10'
								VALUE 		='$kdejku'
								id			='kdejku'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
						<SPAN 	ID			='msgbox'  
								STYLE		='display:none'>
						</SPAN>
					</TD>
				</TR>
				<TR><TD>Nama Jenis</TD>
					<TD>: 
						<INPUT 	NAME		='nmajku'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$nmajku'
								id			='nmajku'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
			</TABLE>";
				
			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('K1D02T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='keuangan.php?mode=K1D02&pilihan=tambah'>";
			}	
					
			// tombol edit
			if (hakakses('K1D02E')==1 and $pilihan=='detil')	
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='keuangan.php?mode=K1D02&kdejku=$kdejku&pilihan=edit'>";
			}	
					
			// tombol hapus
			if (hakakses('K1D02H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='K1D02_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdejku'	VALUE='$kdejku'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='K1D02_Save'>";
			}

			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='K1D02_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdejkuB'	VALUE='$kdejkuB'>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='keuangan.php?mode=K1D02_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>							
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function K1D02_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdejku	=$_POST['kdejku'];
		}
		else
		{
			$kdejku	=$_GET['kdejku'];
		}	
		
		$query	="	DELETE 
					FROM 	t_jku 
					WHERE 	t_jku.kdejku='". mysql_escape_string($kdejku)."'";
		$result	=mysql_query($query) or die (mysql_error());		

		echo"<meta http-equiv='refresh' content=\"0;url=keuangan.php?mode=K1D02_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function K1D02_Save()
	{
  		$kdejkuB=$_POST['kdejkuB'];
  		$kdejku	=$_POST['kdejku'];
  		$nmajku	=$_POST['nmajku'];
  		$pilihan=$_POST['pilihan'];
		$set	="	SET		t_jku.kdejku	='". mysql_escape_string($kdejku)	."',
							t_jku.nmajku	='". mysql_escape_string($nmajku)	."'";
		
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_jku ".$set. 
					 "	WHERE 	t_jku.kdejku	='". mysql_escape_string($kdejkuB)	."'";
			$result	=mysql_query($query) or die (mysql_error());
        }
  		else
  		{
  			$query 	="	INSERT INTO t_jku ".$set; 
			$result	=mysql_query($query) or die (mysql_error());
  		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=keuangan.php?mode=K1D02&kdejku=$kdejku\">\n"; 
 	}
}//akhir class
?>