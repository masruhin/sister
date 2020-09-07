<?php
//----------------------------------------------------------------------------------------------------
//Program		: L1D02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi JURUSAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class L1D02class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function L1D02_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdejrs	=$_GET['kdejrs'];
		
		$query ="	SELECT 		t_mstjrs.* 
					FROM 		t_mstjrs
					WHERE 		(t_mstjrs.kdejrs LIKE'%".$kdejrs."%' OR '$kdejrs'='')
					ORDER BY 	t_mstjrs.kdejrs";
		$result	=mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=kurikulum.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>JURUSAN</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kode Jurusan</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdejrs'	
								ID			='kdejrs'	
								TYPE		='text' 		
								SIZE		='15' 
								MAXLENGTH	='15'
								onkeyup		='uppercase(this.id)'>								
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='L1D02_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='kurikulum.php?mode=L1D02_Cari'>
					</TD>
				</TR>	
			</TABLE>
		</FORM>
			
		<FORM ACTION='kurikulum.php?mode=L1D02' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:370px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='84%'><CENTER>Kode Jurusan	</CENTER></TD>
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
							<TD><CENTER>$data[kdejrs]	</CENTER></TD>";
						
							// otorisasi akses detil
							if (hakakses("L1D02D")==1)
							{
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D02&kdejrs=$data[kdejrs]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("L1D02E")==1)
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D02&kdejrs=$data[kdejrs]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("L1D02H")==1)
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D02_Hapus&kdejrs=$data[kdejrs]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("L1D02T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah JURUSAN' onClick=window.location.href='kurikulum.php?mode=L1D02&pilihan=tambah'>";
			}	
		echo"
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function L1D02()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>		
		<SCRIPT TYPE='text/javascript' 	src='../kurikulum/js/L1D02_validasi_kdejrs.js'></SCRIPT>";

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
			$kdejrsB=$_GET['kdejrs'];
			$query 	="	SELECT 	t_mstjrs.* 
						FROM 	t_mstjrs
						WHERE 	kdejrs='". mysql_escape_string($kdejrsB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$kdejrs	=$data[kdejrs];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='kurikulum.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>JURUSAN</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Jurusan</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdejrs'
								TYPE		='text' 	
								SIZE		='15'
								MAXLENGTH	='15'
								VALUE 		='$kdejrs'
								ID			='kdejrs'
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
			</TABLE>";

			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('L1D02T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='kurikulum.php?mode=L1D02&pilihan=tambah'>";
			}	
						
			// tombol edit
			if (hakakses('L1D02E')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='kurikulum.php?mode=L1D02&kdejrs=$kdejrs&pilihan=edit'>";
			}	
						
			// tombol hapus
			if (hakakses('L1D02H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D02_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdejrs'	VALUE='$kdejrs'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D02_Save'>";
			}
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='L1D02_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdejrsB'	VALUE='$kdejrsB'>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='kurikulum.php?mode=L1D02_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function L1D02_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdejrs	=$_POST['kdejrs'];
		}
		else
		{
			$kdejrs	=$_GET['kdejrs'];
		}	
		
		$query	="	DELETE 
					FROM 	t_mstjrs
					WHERE 	t_mstjrs.kdejrs='". mysql_escape_string($kdejrs)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D02_Cari\">\n";
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function L1D02_Save()
	{
  		$kdejrsB=$_POST['kdejrsB'];
  		$kdejrs	=$_POST['kdejrs'];
  		$pilihan=$_POST['pilihan'];
		$set	="	SET		t_mstjrs.kdejrs	='". mysql_escape_string($kdejrs)	."'";

  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_mstjrs ".$set.
					 "	WHERE 	t_mstjrs.kdejrs	='". mysql_escape_string($kdejrsB)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_mstjrs ".$set; 
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D02&kdejrs=$kdejrs\">\n"; 
 	}
}//akhir class
?>