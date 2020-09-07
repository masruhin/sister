<?php
//----------------------------------------------------------------------------------------------------
//Program		: J1D01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi KELOMPOK BARANG
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class J1D01class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function J1D01_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdeklm	=$_GET['kdeklm'];
		
		$query2 ="	SELECT 		t_klmbrn.* 
					FROM 		t_klmbrn 
					WHERE 		(t_klmbrn.kdeklm LIKE'%".$kdeklm."%' OR '$kdeklm'='')
					ORDER BY 	t_klmbrn.kdeklm";
		$result= mysql_query($query2)	or die (mysql_error());

		echo"
		<FORM ACTION=penjualan.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>KELOMPOK BARANG</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kode Kelompok</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdeklm'	
								ID			='kdeklm'	
								TYPE		='text' 		
								SIZE		='3' 
								MAXLENGTH	='3' 
								onkeyup		='uppercase(this.id)'>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='J1D01_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='penjualan.php?mode=J1D01_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='penjualan.php?mode=J1D01' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:370px;padding-right:-2px;'>		
			<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
				<TR bgcolor='dedede'>
					<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No		</CENTER></TD>
					<TD WIDTH=' 5%'><CENTER>Kode	</CENTER></TD>
					<TD WIDTH='79%'><CENTER>Kelompok</CENTER></TD>
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
						<TD><CENTER>$no			</CENTER></TD>
						<TD><CENTER>$data[kdeklm]</CENTER></TD>
						<TD>$data[nmaklm]</TD>";
						// otorisasi akses detil
						if (hakakses("J1D01D")==1)
						{
							echo"
							<TD><CENTER><a href='penjualan.php?mode=J1D01&kdeklm=$data[kdeklm]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
						}
						else
						{
							echo"
							<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
						}
						
						// otorisasi akses edit
						if (hakakses("J1D01E")==1)
						{		
							echo"
							<TD><CENTER><a href='penjualan.php?mode=J1D01&kdeklm=$data[kdeklm]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
						}
						else
						{
							echo"
							<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
						}	
							
						// otorisasi akses hapus
						if (hakakses("J1D01H")==1)
						{		
							echo"
							<TD><CENTER><a href='penjualan.php?mode=J1D01_Hapus&kdeklm=$data[kdeklm]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("J1D01T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah KELOMPOK BARANG' onClick=window.location.href='penjualan.php?mode=J1D01&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function J1D01()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../penjualan/js/J1D01_validasi_kdeklm.js'></SCRIPT>";
		
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
			$query 	="	SELECT 	t_klmbrn.* 
						FROM 	t_klmbrn 
						WHERE 	t_klmbrn.kdeklm='". mysql_escape_string($kdeklmB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$kdeklm	=$data[kdeklm];
			$nmaklm	=$data[nmaklm];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='penjualan.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>KELOMPOK BARANG</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Kelompok</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdeklm'	
								TYPE		='text' 	
								SIZE		='3' 	
								MAXLENGTH	='3'
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
				<TR><TD>Kelompok</TD>
					<TD>: 
						<INPUT 	NAME		='nmaklm'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$nmaklm'
								id			='nmaklm'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
				
				<TABLE>
					<TR>
						<TD>";
						// pilihan tombol pilihan
						// tombol tambah
						if (hakakses('J1D01T')==1 and $pilihan=='detil')
						{
							echo"
							<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='penjualan.php?mode=J1D01&pilihan=tambah'>";
						}	
						
						// tombol edit
						if (hakakses('J1D01E')==1 and $pilihan=='detil')
						{
							echo"
							<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='penjualan.php?mode=J1D01&kdeklm=$kdeklm&pilihan=edit'>";
						}	
						
						// tombol hapus
						if (hakakses('J1D01H')==1 and $pilihan=='detil')
						{
							echo"
							<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
							<INPUT TYPE='hidden' NAME='mode'	VALUE='J1D01_Hapus'>
							<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
							<INPUT TYPE='hidden' NAME='kdeklm'	VALUE='$kdeklm'>";
						}	
						
						// tombol simpan (tambah)
						if($pilihan=='tambah')
						{
							echo"
							<INPUT TYPE='submit' 				VALUE='Simpan'>
							<INPUT TYPE='reset' 				VALUE='Ulang'>
							<INPUT TYPE='hidden' NAME='mode'	VALUE='J1D01_Save'>";
						}
						// tombol simpan (edit)
						if($pilihan=='edit')
						{
							echo"
							<INPUT TYPE='submit' 				VALUE='Simpan'>
							<INPUT TYPE='hidden' NAME='mode' 	VALUE='J1D01_Save'>
							<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
							<INPUT TYPE='hidden' NAME='kdeklmB'	VALUE='$kdeklmB'>";
						}
						echo"
						<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='penjualan.php?mode=J1D01_Cari'>
						<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
						</TD>
					</TR>
				</TABLE>
			</TABLE>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function J1D01_Hapus()
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
					FROM 	t_klmbrn 
					WHERE 	t_klmbrn.kdeklm='". mysql_escape_string($kdeklm)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"
		<meta http-equiv='refresh' content=\"0;url=penjualan.php?mode=J1D01_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function J1D01_Save()
	{
  		$kdeklmB=$_POST['kdeklmB'];
  		$kdeklm	=$_POST['kdeklm'];
  		$nmaklm	=$_POST['nmaklm'];
  		$pilihan=$_POST['pilihan'];
		$set="	SET		t_klmbrn.kdeklm	='". mysql_escape_string($kdeklm)	."',
						t_klmbrn.nmaklm	='". mysql_escape_string($nmaklm)	."'";
		
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_klmbrn ".$set.  
					 "	WHERE 	t_klmbrn.kdeklm	='". mysql_escape_string($kdeklmB)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_klmbrn ".$set;  
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=penjualan.php?mode=J1D01&kdeklm=$kdeklm\">\n"; 
 	}
}//akhir class
?>