<?php
//----------------------------------------------------------------------------------------------------
//Program		: A1D01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 01/05/2012
//Keterangan	: Fungsi-fungsi MODUL
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}

// -------------------------------------------------- Class --------------------------------------------------
class A1D01class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function A1D01_Cari()
	{
		$kdemdl	=$_GET['kdemdl'];
			
		$query 	="	SELECT 		t_mstmdl.* 
					FROM 		t_mstmdl 
					WHERE 		(t_mstmdl.kdemdl LIKE'%".$kdemdl."%' OR '$kdemdl'='')
					ORDER BY 	t_mstmdl.kdemdl";
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<FORM ACTION=administrator.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>MODUL</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Modul</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdemdl'	
								TYPE		='text' 		
								SIZE		='25' 
								MAXLENGTH	='25'>
								
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='A1D01_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='administrator.php?mode=A1D01_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='administrator.php?mode=A1D01' METHOD='post' >
			<DIV style='overflow:auto;width:100%;height:370px;padding-right:-2px;'>                
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='70%'><CENTER>Modul			</CENTER></TD>
						<TD WIDTH='14%'><CENTER>Periode			</CENTER></TD>
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
							<TD><CENTER>$data[kdemdl]</CENTER></TD>
							<TD><CENTER>$data[prd]	</CENTER></TD>";
							// otorisasi akses detil
							if (hakakses("A1D01D")==1)
							{
								echo"
								<TD><CENTER><a href='administrator.php?mode=A1D01&kdemdl=$data[kdemdl]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("A1D01E")==1)
							{		
								echo"
								<TD><CENTER><a href='administrator.php?mode=A1D01&kdemdl=$data[kdemdl]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("A1D01H")==1)
							{		
								echo"
								<TD><CENTER><a href='administrator.php?mode=A1D01_Hapus&kdemdl=$data[kdemdl]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("A1D01T")==1)
			{
				echo"
				<INPUT TYPE='button' VALUE='Tambah Modul' onClick=window.location.href='administrator.php?mode=A1D01&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function A1D01()
	{
		// deklarasi java
		echo"<script TYPE='text/javascript' src='../js/fungsi_input.js'></script>";	
		
		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../administrator/js/A1D01_validasi_kdemdl.js'></SCRIPT>";

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
			$kdemdlB=$_GET['kdemdl'];
			$query 	="	SELECT 	t_mstmdl.* 
						FROM 	t_mstmdl 
						WHERE 	t_mstmdl.kdemdl='". mysql_escape_string($kdemdlB)."'";
			$result	=mysql_query($query) or die (mysql_error());
			$data 	=mysql_fetch_array($result);
		
			$kdemdl	=$data[kdemdl];
			$prd	=$data[prd];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='administrator.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>MODUL</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Modul</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdemdl'	
								TYPE		='text' 	
								SIZE		='25' 	
								MAXLENGTH	='25'
								VALUE 		='$kdemdl'
								id			='kdemdl'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...diisi'
								$isian>
						<SPAN 	ID			='msgbox'  
								STYLE		='display:none'>
						</SPAN>
					</TD>
				</TR>
				<TR><TD>Periode</TD>
					<TD>: 
						<INPUT 	NAME		='prd'	
								TYPE		='text' 
								SIZE		='4' 	
								MAXLENGTH	='4'		
								VALUE		='$prd'
								id			='prd'
								onkeyup		='javascript:checknumber(f1.prd);'
								onkeypress	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
			</TABLE>";
			
			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('A1D01T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 					VALUE='Tambah' 	onClick=window.location.href='administrator.php?mode=A1D01&pilihan=tambah'>";
			}	
				
			// tombol edit
			if (hakakses('A1D01E')==1 and $pilihan=='detil')	
			{
				echo"
				<INPUT TYPE='button' 				VALUE='Edit' 	onClick=window.location.href='administrator.php?mode=A1D01&kdemdl=$kdemdl&pilihan=edit'>";
			}	
					
			// tombol hapus
			if (hakakses('A1D01H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='A1D01_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdemdl'	VALUE='$kdemdl'>";
			}	
					
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='A1D01_Save'>";
			}
						
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdemdlB'	VALUE='$kdemdlB'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='A1D01_Save'>";
			}
			echo"
			<INPUT TYPE='button' VALUE='Cari' 	onClick=window.location.href='administrator.php?mode=A1D01_Cari'>
			<INPUT TYPE='button' VALUE='Kembali' onClick='history.go(-1)'>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function A1D01_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdemdl	=$_POST['kdemdl'];
		}
		else
		{
			$kdemdl	=$_GET['kdemdl'];
		}	
		
		$query	="	DELETE 
					FROM 	t_mstmdl 
					WHERE 	t_mstmdl.kdemdl='". mysql_escape_string($kdemdl)."'";
		$result= mysql_query($query) or die (mysql_error());
		
		echo"<meta http-equiv=\"refresh\" content=\"0;url=administrator.php?mode=A1D01_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function A1D01_Save()
	{
  		$kdemdlB=$_POST['kdemdlB'];
  		$kdemdl	=$_POST['kdemdl'];
  		$prd	=$_POST['prd'];
  		$pilihan=$_POST['pilihan'];

  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_mstmdl 
						SET		t_mstmdl.kdemdl	='". mysql_escape_string($kdemdl)."',
								t_mstmdl.prd	='". mysql_escape_string($prd)."'
						WHERE 	t_mstmdl.kdemdl	='". mysql_escape_string($kdemdlB)."'";
			$result= mysql_query($query) or die (mysql_error());
        }
  		else
  		{
  			$query 	="	INSERT INTO t_mstmdl 
						SET			t_mstmdl.kdemdl	='". mysql_escape_string($kdemdl)."',
									t_mstmdl.prd	='". mysql_escape_string($prd)."'";
			$result= mysql_query($query) or die (mysql_error());
  		}
		
		echo"<meta http-equiv=\"refresh\" content=\"0;url=administrator.php?mode=A1D01&kdemdl=$kdemdl\">\n"; 
 	}
}//akhir class
?>