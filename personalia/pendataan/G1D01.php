<?php
//----------------------------------------------------------------------------------------------------
//Program		: G1D01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi STATUS KARYAWAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class G1D01class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function G1D01_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdestt	=$_GET['kdestt'];
		
		$query ="	SELECT 		t_sttkry.* 
					FROM 		t_sttkry 
					WHERE 		(t_sttkry.kdestt LIKE'%".$kdestt."%' OR '$kdestt'='')
					ORDER BY 	t_sttkry.kdestt";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=personalia.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>STATUS KARYAWAN</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kode Status</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdestt'
								ID			='kdestt'
								TYPE		='text' 		
								SIZE		='3' 
								MAXLENGTH	='3' 
								onkeyup		='uppercase(this.id)'>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='G1D01_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='personalia.php?mode=G1D01_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='personalia.php?mode=G1D01' METHOD='post' >
			<DIV style='overflow:auto;width:100%;height:370px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No		</CENTER></TD>
						<TD WIDTH=' 5%'><CENTER>Kode	</CENTER></TD>
						<TD WIDTH='79%'><CENTER>Status	</CENTER></TD>
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
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[kdestt]	</CENTER></TD>
							<TD>$data[nmastt]</TD>";
							// otorisasi akses detil
							if (hakakses("G1D01D")==1)
							{
								echo"
								<TD><CENTER><a href='personalia.php?mode=G1D01&kdestt=$data[kdestt]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("G1D01E")==1)
							{		
								echo"
								<TD><CENTER><a href='personalia.php?mode=G1D01&kdestt=$data[kdestt]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("G1D01H")==1)
							{		
								echo"
								<TD><CENTER><a href='personalia.php?mode=G1D01_Hapus&kdestt=$data[kdestt]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("G1D01T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah STATUS KARYAWAN' onClick=window.location.href='personalia.php?mode=G1D01&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function G1D01()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../personalia/js/G1D01_validasi_kdestt.js'></SCRIPT>";
		
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
			$kdesttB=$_GET['kdestt'];
			$query 	="	SELECT 	* 
						FROM 	t_sttkry 
						WHERE 	kdestt='". mysql_escape_string($kdesttB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$kdestt	=$data[kdestt];
			$nmastt	=$data[nmastt];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='personalia.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>STATUS KARYAWAN</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD></TD>
					<TD COLSPAN=2 align=left><span style='color: #FF0000;'>* Khusus guru, digit pertama status karyawan huruf 'G'</span></TD>
				</TR>
				<TR><TD WIDTH='15%'>Kode Status</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdestt'	
								TYPE		='text' 	
								SIZE		='3' 	
								MAXLENGTH	='3'
								VALUE 		='$kdestt'
								ID			='kdestt'
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
				<TR><TD>Status</TD>
					<TD>: 
						<INPUT 	NAME		='nmastt'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$nmastt'
								id			='nmastt'
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
			if (hakakses('G1D01T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='personalia.php?mode=G1D01&pilihan=tambah'>";
			}	
					
			// tombol edit
			if (hakakses('G1D01E')==1 and $pilihan=='detil')	
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='personalia.php?mode=G1D01&kdestt=$kdestt&pilihan=edit'>";
			}	
						
			// tombol hapus
			if (hakakses('G1D01H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='G1D01_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdestt'	VALUE='$kdestt'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='G1D01_Save'>";
			}
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdesttB'	VALUE='$kdesttB'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='G1D01_Save'>";
			}
			echo"
			<INPUT TYPE='button'	VALUE='Cari' 	onClick=window.location.href='personalia.php?mode=G1D01_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function G1D01_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdestt	=$_POST['kdestt'];
		}
		else
		{
			$kdestt	=$_GET['kdestt'];
		}	
		
		$query	="	DELETE 
					FROM 	t_sttkry 
					WHERE 	t_sttkry.kdestt='". mysql_escape_string($kdestt)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=personalia.php?mode=G1D01_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function G1D01_Save()
	{
  		$kdesttB=$_POST['kdesttB'];
  		$kdestt	=$_POST['kdestt'];
  		$nmastt	=$_POST['nmastt'];
		
  		$pilihan=$_POST['pilihan'];
		$set	="	SET		t_sttkry.kdestt	='". mysql_escape_string($kdestt)	."',
							t_sttkry.nmastt	='". mysql_escape_string($nmastt)	."'";
		
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_sttkry ".$set. 
					 " 	WHERE 	t_sttkry.kdestt	='". mysql_escape_string($kdesttB)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_sttkry ".$set;  
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=personalia.php?mode=G1D01&kdestt=$kdestt\">\n"; 
 	}
}//akhir class
?>