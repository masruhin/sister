<?php
//----------------------------------------------------------------------------------------------------
//Program		: K1D01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 23/04/2012
//Keterangan	: Fungsi-fungsi JENIS PENERIMAAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}

// -------------------------------------------------- Class --------------------------------------------------
class K1D01class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function K1D01_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdejtu	=$_GET['kdejtu'];
			
		$query 	="	SELECT 		t_jtu.* 
					FROM 		t_jtu 
					WHERE 		(t_jtu.kdejtu LIKE'%".$kdejtu."%' OR '$kdejtu'='')
					ORDER BY 	t_jtu.kdejtu";
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<FORM ACTION=keuangan.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>JENIS PENERIMAAN</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kode Jenis</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdejtu'	
								ID			='kdejtu'	
								TYPE		='text' 		
								SIZE		='10' 
								MAXLENGTH	='10'
								onkeyup		='uppercase(this.id)'>								
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='K1D01_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='keuangan.php?mode=K1D01_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='keuangan.php?mode=K1D01' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:370px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No		</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kode	</CENTER></TD>
						<TD WIDTH='64%'><CENTER>Jenis	</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Status	</CENTER></TD>
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
							<TD>$data[kdejtu]</TD>
							<TD>$data[nmajtu]</TD>
							<TD><CENTER>$data[sttbyr]</CENTER></TD>";
							
							// otorisasi akses detil
							if (hakakses("K1D01D")==1)
							{
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D01&kdejtu=$data[kdejtu]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("K1D01E")==1)
							{		
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D01&kdejtu=$data[kdejtu]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("K1D01H")==1)
							{		
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D01_Hapus&kdejtu=$data[kdejtu]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("K1D01T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah JENIS PENERIMAAN' onClick=window.location.href='keuangan.php?mode=K1D01&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function K1D01()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../keuangan/js/K1D01_validasi_kdejtu.js'></SCRIPT>";
		
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
			$kdejtuB=$_GET['kdejtu'];
			$query 	="	SELECT 	t_jtu.* 
						FROM 	t_jtu 
						WHERE 	kdejtu='". mysql_escape_string($kdejtuB)."'";
			$result	=mysql_query($query) or die (mysql_error());
			$data 	=mysql_fetch_array($result);
		
			$kdejtu	=$data[kdejtu];
			$nmajtu	=$data[nmajtu];
            $sttbyr =$data[sttbyr];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='keuangan.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>JENIS PENERIMAAN</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Jenis</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdejtu'	
								TYPE		='text' 	
								SIZE		='10' 	
								MAXLENGTH	='10'
								VALUE 		='$kdejtu'
								id			='kdejtu'
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
						<INPUT 	NAME		='nmajtu'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE		='$nmajtu'
								id			='nmajtu'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
                <TR><TD>Status</TD>
					<TD>:
						<SELECT	NAME		='sttbyr'
								VALUE 		='$sttbyr'
								onkeypress	='return enter(this,event)'
                                CLASS		='required'
								$isian><OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						$sql2	="	SELECT 		t_mststt.*
									FROM 		t_mststt
									ORDER BY 	t_mststt.kdestt";
    					$my		=mysql_query($sql2);
    					while($al=mysql_fetch_array($my))
    					{
							if ($sttbyr==$al[kdestt])
								echo
								"<OPTION VALUE='$al[kdestt]' SELECTED>$al[nmastt]</OPTION>";
  	  						else
								echo
								"<OPTION VALUE='$al[kdestt]' >$al[nmastt]</OPTION>";
    					}
       					echo
						"</SELECT>
					</TD>
				</TR>
			</TABLE>";
					
			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('K1D01T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='keuangan.php?mode=K1D01&pilihan=tambah'>";
			}	
					
			// tombol edit
			if (hakakses('K1D01E')==1 and $pilihan=='detil')	
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='keuangan.php?mode=K1D01&kdejtu=$kdejtu&pilihan=edit'>";
			}	
					
			// tombol hapus
			if (hakakses('K1D01H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='K1D01_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdejtu'	VALUE='$kdejtu'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='K1D01_Save'>";
			}
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='K1D01_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdejtuB'	VALUE='$kdejtuB'>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='keuangan.php?mode=K1D01_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function K1D01_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdejtu	=$_POST['kdejtu'];
		}
		else
		{
			$kdejtu	=$_GET['kdejtu'];
		}	
		
		$query	="	DELETE 
					FROM 	t_jtu 
					WHERE 	t_jtu.kdejtu='". mysql_escape_string($kdejtu)."'";
		$result	=mysql_query($query) or die (mysql_error());		

		echo"<meta http-equiv='refresh' content=\"0;url=keuangan.php?mode=K1D01_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function K1D01_Save()
	{
  		$kdejtuB=$_POST['kdejtuB'];
  		$kdejtu	=$_POST['kdejtu'];
  		$nmajtu	=$_POST['nmajtu'];
        $sttbyr	=$_POST['sttbyr'];
  		$pilihan=$_POST['pilihan'];
		$set	="	SET		t_jtu.kdejtu	='". mysql_escape_string($kdejtu)	."',
                            t_jtu.sttbyr	='". mysql_escape_string($sttbyr)	."',
							t_jtu.nmajtu	='". mysql_escape_string($nmajtu)	."'";
		
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_jtu ".$set. 
					 " 	WHERE 	t_jtu.kdejtu	='". mysql_escape_string($kdejtuB)	."'";
			$result	=mysql_query($query) or die (mysql_error());
        }
  		else
  		{
  			$query 	="	INSERT INTO t_jtu ".$set; 
			$result	=mysql_query($query) or die (mysql_error());
  		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=keuangan.php?mode=K1D01&kdejtu=$kdejtu\">\n"; 
 	}
}//akhir class
?>