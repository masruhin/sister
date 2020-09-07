<?php
//----------------------------------------------------------------------------------------------------
//Program		: A6U01.php  
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 01/05/2012
//Keterangan	: Fungsi-fungsi untuk Data userid
//----------------------------------------------------------------------------------------------------
if(!defined("sister")) 
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}

// -------------------------------------------------- Class --------------------------------------------------
class A6U01class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function A6U01_Cari()
	{
		$userid	=$_SESSION['Admin']['userid'];

		// mengakses database userids
    	$query 	="	SELECT 		user.* 
					FROM 		user
					ORDER BY 	userid";
		$result	=mysql_query($query) or die (mysql_error());

    	echo"
		<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><b>SETING USER</b></TD></TR>
			<TR></TR><TR></TR>
		</TABLE>
  		
		<FORM action=administrator.php method=\"post\">
			<DIV style='overflow:auto;width:100%;height:400px;padding-right:-2px;'>                
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD width= 4% HEIGHT='20'><CENTER>No</CENTER></TD>
						<TD width=88%><CENTER>user		</CENTER></TD>
						<TD width= 4%><CENTER>Detil		</CENTER></TD>
						<TD width= 4%><CENTER>Hapus		</CENTER></TD>
					</TR>";
				
					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[username]	</CENTER></TD>";
							// otorisasi akses detil							
							if (hakakses("A6U01D")==1)
							{
								echo"
								<TD><CENTER><a href='administrator.php?mode=A6U01&userid=$data[userid]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}	

							// otorisasi akses hapus
							if (hakakses("A6U01H")==1)
							{		
								echo"
								<TD><CENTER><a href='administrator.php?mode=A6U01_Hapus&userid=$data[userid]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("A6U01T")==1)
			{
				echo"
				<INPUT TYPE='button' VALUE='Tambah USER' 			onClick=window.location.href='administrator.php?mode=A6U01&pilihan=tambah'>
				<INPUT TYPE='button' VALUE='Buat Otorisasi Admin' 	onClick=window.location.href='administrator.php?mode=A6U01_Buat_Admin'>";
			}
		echo"	
		</FORM>";
	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function A6U01()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../administrator/js/A6U01_validasi_username.js'></SCRIPT>";

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

		if(empty($pilihan))
		{
			$pilihan='detil';
		}
		
		switch($pilihan)
		{
			case 'detil':
				$isian1	='disabled';
				$isian2	='disabled';
				break;
			case 'tambah':
				$isian1	='enable';
				$isian2	='disabled';
				break;
			case 'edit':
				$isian1	='disabled';
				$isian2	='disabled';
				break;
			case 'copy':
				$isian1	='disabled';
				$isian2	='enable';
				break;
		}		
		
		if ($pilihan=='detil' or $pilihan=='edit' or $pilihan=='copy')
		{
			$useridB=$_GET['userid'];
			$query 	="	SELECT 	user.* 
						FROM 	user
						WHERE 	user.userid='". mysql_escape_string($useridB)."'";
			$result= mysql_query($query) or die (mysql_error());
			$data 	=mysql_fetch_array($result);
		
			$userid		=$data[userid];
			$username	=$data[username];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian1
  		echo"
		<FORM ID='validasi' ACTION='administrator.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>SETING USER</B></TD>
					<TD COLSPAN='5' ALIGN='right'>";
						if ($pilihan=='detil')
						{
							echo"
							| <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=pendaftaran'>Pendaftaran</a> 
							| <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=tata_usaha'>Tata Usaha</a> 
							| <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=personalia'>Personalia</a> 
							| <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=penjualan'>Penjualan</a> 
							| <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=keuangan'>Keuangan</a> 
							| <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=perpustakaan'>Perpustakaan</a>
							| <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=kurikulum'>Kurikulum</a>
							| <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=administrator'>Administrator</a>";
						}	
					echo"
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>User</TD>
					<TD WIDTH='85%'>:
						<INPUT 	NAME		='username'
								TYPE		='text' 	
								SIZE		='30'
								MAXLENGTH	='30'
								VALUE 		='$username'
								ID			='username'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...diisi'
								$isian1>
						<SPAN 	ID			='msgbox'  
								STYLE		='display:none'>
						</SPAN>
					</TD>
				</TR>";
				
				if($pilihan=='copy')
				{
					echo"
					<TR><TD>Copy otorisasi dari</TD>
						<TD>: 
							<SELECT	NAME		='usercopy'	
									VALUE 		='$usercopy'
									ID			='usercopy'
									onkeypress	='return enter(this,event)'
									CLASS		='required' 
									TITLE		='...harus diisi'
									$isian2>
							<OPTION VALUE=''>--Pilih--</OPTION>";
							$query="	SELECT 		user.* 
										FROM 		user  
										WHERE		user.userid!=$userid
										ORDER BY 	user.userid";
							$result= mysql_query($query) or die (mysql_error());
						
							while($data=mysql_fetch_array($result))
							{
								echo"<OPTION VALUE='$data[userid]'>$data[username]</OPTION>";
							}
							echo
							"</SELECT>		
						</TD>
					</TR>";	
				}
				echo"
			</TABLE>";
			
			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('A6U01')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Tambah USER' 	onClick=window.location.href='administrator.php?mode=A6U01&pilihan=tambah'>";
			}	
					
			// tombol hapus
			if (hakakses('A6U01')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='A6U01_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='userid'	VALUE='$userid'>";
			}	

			// tombol copy
			if (hakakses('A6U01')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Copy Otorisasi dari user lain' 	onClick=window.location.href='administrator.php?mode=A6U01&userid=$userid&pilihan=copy'>"; 
			}	
					
			// tombol simpan (copy)
			if($pilihan=='copy')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='copy'>
				<INPUT TYPE='hidden' NAME='userid'		VALUE='$userid'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='A6U01_Copy'>";
			}

			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='A6U01_Save'>
				<INPUT TYPE='hidden' NAME='userid'	VALUE='$userid'>";
			}

			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='edit'>
				<INPUT TYPE='hidden' NAME='username'	VALUE='$username'>
				<INPUT TYPE='hidden' NAME='userid'		VALUE='$userid'>
				<INPUT TYPE='hidden' NAME='useridB'		VALUE='$useridB'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='A6U01_Save'>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Daftar USER' 	onClick=window.location.href='administrator.php?mode=A6U01_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}

	// -------------------------------------------------- Detil Menu --------------------------------------------------
	function A6U01_Menu()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		// iuseridiasi parameter berdasarkan pilihan tombol
		$pilihan	=$_GET['pilihan'];
		$menuutama	=$_GET['menuutama'];
		
		switch($menuutama)
		{
			case 'pendaftaran':
				$judul='PENDAFTARAN';
				$tabel='D';
				break;
			case 'tata_usaha': 
				$judul='TATA USAHA';
				$tabel='T';
				break;
			case 'personalia':
				$judul='PERSONALIA';
				$tabel='G';
				break;
			case 'penjualan':
				$judul='PENJUALAN';
				$tabel='J';
				break;
			case 'keuangan':
				$judul='KEUANGAN';
				$tabel='K';
				break;
			case 'perpustakaan':
				$judul='PERPUSTAKAAN';
				$tabel='P';
				break;
			case 'kurikulum':
				$judul='KURIKULUM';
				$tabel='L';
				break;
			case 'administrator':
				$judul='ADMINISTRATOR';
				$tabel='A';
				break;
		}

		$useridB=$_GET['userid'];
		$query 	="	SELECT 	user.*
					FROM 	user
					WHERE 	user.userid='". mysql_escape_string($useridB)."'";
		$result= mysql_query($query) or die (mysql_error());
		$data 	=mysql_fetch_array($result);
		$userid		=$data[userid];
		$username	=$data[username];
		
  		echo"
		<FORM ID='validasi' ACTION='administrator.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>$judul</B></TD>
					<TD COLSPAN='2' ALIGN='right'>";
						echo"
						| <a href='administrator.php?mode=A6U01&userid=$userid&pilihan=$pilihan'>User</a>";
						if($menuutama!='pendaftaran')
							echo" | <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=pendaftaran'>Pendaftaran</a>";
						if($menuutama!='tata_usaha')	
							echo" | <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=tata_usaha'>Tata Usaha</a>"; 
						if($menuutama!='personalia')
							echo" | <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=personalia'>Personalia</a>"; 
						if($menuutama!='penjualan')
							echo" | <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=penjualan'>Penjualan</a>"; 
						if($menuutama!='keuangan')
							echo" | <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=keuangan'>Keuangan</a>"; 
						if($menuutama!='perpustakaan')
							echo" | <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=perpustakaan'>Perpustakaan</a>";
						if($menuutama!='kurikulum')
							echo" | <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=kurikulum'>Kurikulum</a>";
						if($menuutama!='administrator')
							echo" | <a href='administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=$pilihan&menuutama=administrator'>Administrator</a>";
					echo"
					</TD>
				</TR>
				
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>User</TD>
					<TD WIDTH='85%'>:
						<INPUT 	NAME		='username'
								TYPE		='text' 	
								SIZE		='30'
								MAXLENGTH	='30'
								VALUE 		='$username'
								DISABLED>
					</TD>
				</TR>				
				<TR><TD COLSPAN='2'><HR></TD></TR>		
			</TABLE>	
			
			<DIV style='overflow:auto;width:100%;height:370px;padding-right:-2px;'>                
				<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
					<TR>
						<TD WIDTH='50%' VALIGN='top'><B>OTORISASI YANG DIPILIH</B>
							<INPUT TYPE='button'	VALUE='Hapus Semua Otorisasi yang dipilih' 	onClick=window.location.href='administrator.php?mode=A6U01_Hapus_Menu_Semua&userid=$userid&tabel=$tabel&menuutama=$menuutama'>";
							$query1 ="	SELECT 		user_level.*,menu.nama
										FROM 		user_level,menu
										WHERE 		user_level.userid			='$useridB'	AND
													SUBSTR(user_level.menu,1,1)	='$tabel'	AND
													user_level.menu				=menu.menu
										ORDER BY 	user_level.menu"; 
							$result1= mysql_query($query1)	or die (mysql_error());
						
							echo"
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD WIDTH='15%' HEIGHT='20'><CENTER>Menu 			</CENTER></TD>
									<TD WIDTH='75%'><CENTER>Nama 			</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Hapus 			</CENTER></TD>
								</TR>";

								while($data1 =mysql_fetch_array($result1))
								{
									echo"
									<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
										<TD>$data1[menu]</TD>";
										$simbol	=chr(149);
										$besar	=strtoupper($data1[nama]);
										if(strlen($data1[menu])==5)
										{
											echo"<TD><B>$besar</B></TD>";
										}
										else
										{
											echo"<TD>$simbol $data1[nama]</TD>";
										}	
										echo"
										<TD><CENTER><a href='administrator.php?mode=A6U01_Hapus_Menu&userid=$data1[userid]&idlevel=$data1[idlevel]&menuutama=$menuutama'><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
									echo"	
									</TR>";
								}
							echo"	
							</TABLE>						
						</TD>
				
						<TD WIDTH='50%' VALIGN='top'><B>PILIHAN OTORISASI</B>
							<INPUT TYPE='button'	VALUE='Pilih Semua Otorisasi' 	onClick=window.location.href='administrator.php?mode=A6U01_Save_Menu_Semua&userid=$userid&tabel=$tabel&menuutama=$menuutama'>";
							$query2 ="	SELECT 		DISTINCT menu.*,user_level.userid
										FROM 		menu
										LEFT JOIN 	user_level ON menu.menu=user_level.menu	AND user_level.userid='$userid'
										WHERE		SUBSTR(menu.menu,1,1)='$tabel'
										ORDER BY 	menu.menu";  
										
							$result2= mysql_query($query2)	or die (mysql_error());
							echo"
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD WIDTH='15%' HEIGHT='20'><CENTER>Menu 			</CENTER></TD>
									<TD WIDTH='75%'><CENTER>Nama 			</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Pilih 			</CENTER></TD>
								</TR>";

								while($data2 =mysql_fetch_array($result2))
								{
									$userid	=$data2[userid];
									echo"
									<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
										<TD>$data2[menu]</TD>";
										$simbol	=chr(149);
										$besar	=strtoupper($data2[nama]);
										if(strlen($data2[menu])==5)
										{
											echo"<TD><B>$besar</B></TD>";
										}
										else
										{
											echo"<TD>$simbol $data2[nama]</TD>";
										}	
										// otorisasi akses detil
										if($userid=='')
										{
											echo"
											<TD><CENTER><a href='administrator.php?mode=A6U01_Save_Menu&userid=$useridB&menu=$data2[menu]&utama=$data2[utama]&menuutama=$menuutama'><IMG src='../images/pilih_e.gif' BORDER='0'></a></CENTER></TD>";
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
			<BR>
			
			<INPUT TYPE='button' 	VALUE='Daftar USER' 	onClick=window.location.href='administrator.php?mode=A6U01_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}
	
	// -------------------------------------------------- Hapus --------------------------------------------------
	function A6U01_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$userid	=$_POST['userid'];
		}
		else
		{
			$userid	=$_GET['userid'];
		}			

		$query	="	DELETE 
					FROM 	user
					WHERE 	user.userid='". mysql_escape_string($userid)."'";
		$result	=mysql_query($query) or die (mysql_error());

		$query	="	DELETE 
					FROM 	user_level
					WHERE 	user_level.userid='". mysql_escape_string($userid)."'";
		$result	=mysql_query($query) or die (mysql_error());
		
		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A6U01_Cari\">\n";
	}
	
	// -------------------------------------------------- Hapus_Menu --------------------------------------------------
	function A6U01_Hapus_Menu()
	{
		$userid=$_GET['userid'];		
		$idlevel=$_GET['idlevel'];
		$menuutama	=$_GET['menuutama'];
		
		$query	="	DELETE 
					FROM 	user_level
					WHERE 	user_level.userid='". mysql_escape_string($userid)."'	AND
							user_level.idlevel='". mysql_escape_string($idlevel)."'";
		$result	=mysql_query($query) or die (mysql_error());

		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=detil&menuutama=$menuutama\">\n";
	}	

	// -------------------------------------------------- Hapus_Menu_Semua --------------------------------------------------
	function A6U01_Hapus_Menu_Semua()
	{
		$userid	=$_GET['userid'];		
		$tabel	=$_GET['tabel'];
		$menuutama	=$_GET['menuutama'];
		
		$query	="	DELETE 
					FROM 	user_level
					WHERE 	user_level.userid='". mysql_escape_string($userid)."'	AND
							SUBSTR(user_level.menu,1,1)='$tabel'";
		$result	=mysql_query($query) or die (mysql_error());

		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=detil&menuutama=$menuutama\">\n";
	}	
	
	// -------------------------------------------------- Save --------------------------------------------------
	function A6U01_Save()
	{
		require FUNGSI_UMUM_DIR.'fungsi_pass.php';
		$userid		=addslashes($_POST['userid']);
		$useridB	=addslashes($_POST['useridB']);
		$username	=addslashes($_POST['username']);
		$pilihan	=$_POST['pilihan'];
		
		$set	="	SET		user.userid		='". mysql_escape_string($userid)."',
							user.username	='". mysql_escape_string($username)."'";
		
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	user ".$set.
					 "	WHERE 	user.userid	='". mysql_escape_string($useridB)	."'";
			$result	=mysql_query($query) or die (mysql_error());
        }
  		else
  		{
  			$query 	="	INSERT INTO user ".$set; 
			$result	=mysql_query($query) or die (mysql_error());
  		}
		
		$query 	="	SELECT 	user.* 
					FROM 	user
					WHERE 	username = '". mysql_escape_string($username)."'";
		$result	=mysql_query($query) or die (mysql_error());
		$data 	=mysql_fetch_array($result);
    					
    	$userid =$data[userid]; 
		
		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A6U01&userid=$userid\">\n"; 
	}

	// -------------------------------------------------- Save Tata Usaha --------------------------------------------------
	function A6U01_Save_Menu()
	{
  		$userid	=$_GET['userid'];
  		$menu	=$_GET['menu'];
		$utama	=$_GET['utama'];
		$menuutama	=$_GET['menuutama'];
		
		$set	="	SET		user_level.userid	='". mysql_escape_string($userid)."',
							user_level.menu		='". mysql_escape_string($menu)."',
							user_level.utama	='". mysql_escape_string($utama)."'";

		$query 	="	INSERT INTO user_level ".$set; 
		$result	=mysql_query($query) or die (mysql_error());

		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=detil&menuutama=$menuutama\">\n";
 	}	
	
	// -------------------------------------------------- Save Tata Usaha --------------------------------------------------
	function A6U01_Save_Menu_Semua()
	{
  		$userid	=$_GET['userid'];
  		$tabel	=$_GET['tabel'];
		$menuutama	=$_GET['menuutama'];

		$query	="	DELETE 
					FROM 	user_level
					WHERE 	user_level.userid='". mysql_escape_string($userid)."'	AND
							SUBSTR(user_level.menu,1,1)='$tabel'";
		$result	=mysql_query($query) or die (mysql_error());
		
		$query 	="	SELECT 		menu.*
					FROM 		menu
					WHERE 		SUBSTR(menu.menu,1,1)='$tabel'"; 
		$result	=mysql_query($query) or die (mysql_error());

		while($data =mysql_fetch_array($result))
		{
			$menu	=$data[menu];
			$utama	=$data[utama];

			$set	="	SET		user_level.userid	='". mysql_escape_string($userid)."',
								user_level.menu		='". mysql_escape_string($menu)."',
								user_level.utama	='". mysql_escape_string($utama)."'";

			$query2 ="	INSERT INTO user_level ".$set; 
			$result2=mysql_query($query2) or die (mysql_error());
		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A6U01_Menu&userid=$userid&pilihan=detil&menuutama=$menuutama\">\n";
 	}	

	// -------------------------------------------------- Save Copy --------------------------------------------------
	function A6U01_Copy()
	{
		$userid		=$_POST['userid'];
		$usercopy	=$_POST['usercopy'];
		
		$query	="	DELETE 
					FROM 	user_level
					WHERE 	user_level.userid='". mysql_escape_string($userid)."'";
		$result	=mysql_query($query) or die (mysql_error());
		
		$query 	="	SELECT 		user_level.*
					FROM 		user_level
					WHERE 		user_level.userid='$usercopy'"; 
		$result	=mysql_query($query) or die (mysql_error());

		while($data =mysql_fetch_array($result))
		{
			$menu	=$data[menu];
			$utama	=$data[utama];

			$set	="	SET		user_level.userid	='". mysql_escape_string($userid)."',
								user_level.menu		='". mysql_escape_string($menu)."',
								user_level.utama	='". mysql_escape_string($utama)."'";

			$query2 ="	INSERT INTO user_level ".$set; 
			$result2=mysql_query($query2) or die (mysql_error());
		}

		echo"
		<SCRIPT LANGUAGE='JavaScript'>
			window.alert ('Copy Otorisasi sudah selesai');
		</SCRIPT>";

		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A6U01&userid=$userid\">\n"; 
 	}		
	
	// -------------------------------------------------- Buat Admin --------------------------------------------------
	function A6U01_Buat_Admin()
	{
		$amenu=array('A1D01' ,'Pendataan Modul','1',	'A1D01D','Detil','1','A1D01T','Tambah','1','A1D01E','Edit','1','A1D01H','Hapus','1',
				'A1D02' ,'Pendataan User','1',			'A1D02D','Detil','1',
				'A6U01' ,'Seting User','6',				'A6U01D','Detil','6','A6U01T','Tambah','6','A6U01E','Edit','6','A6U01H','Hapus','6',
				'A6U02' ,'Seting Raport PG-KG','6',
				'A6U03'	,'Seting Raport PS-JHS-SHS','6',
				'A6U04'	,'Seting Behaviour PS-JHS-SHS','6',
				'A6U05'	,'Buat Data Behaviour','6',				
				'A6U06'	,'Buat Data Progress','6',				
				'T1D01' ,'Pendataan Siswa','1',			'T1D01D','Detil','1','T1D01T','Tambah','1','T1D01E','Edit','1','T1D01H','Hapus','1',
				'T1D02' ,'Pendataan Absensi','1',		'T1D02D','Detil','1','T1D02T','Tambah','1','T1D02E','Edit','1','T1D02H','Hapus','1',
				'T5L01' ,'Laporan Absensi','5',
				'T5L02' ,'Laporan Kenaikan Kelas','5',
				'T6U01' ,'Kenaikan Kelas','6',
				'T6U03' ,'Ganti Password','6',
				'G1D01' ,'Pendataan Status Karyawan','1',	'G1D01D','Detil','1','G1D01T','Tambah','1','G1D01E','Edit','1','G1D01H','Hapus','1',
				'G1D02' ,'Pendataan Karyawan','1',			'G1D02D','Detil','1','G1D02T','Tambah','1','G1D02E','Edit','1','G1D02H','Hapus','1',
				'G1D03' ,'Pendataan Absensi','1',			'G1D03D','Detil','1','G1D03T','Tambah','1','G1D03E','Edit','1','G1D03H','Hapus','1',
				'G5L01' ,'Laporan Absensi','5',				
				'G6U01' ,'','6',
				'G6U02' ,'','6',
				'G6U03' ,'Ganti Password','6',
				'J1D01' ,'Pendataan Kelompok Barang','1',		'J1D01D','Detil','1','J1D01T','Tambah','1','J1D01E','Edit','1','J1D01H','Hapus','1',
				'J1D02' ,'Pendataan Barang','1',				'J1D02D','Detil','1','J1D02T','Tambah','1','J1D02E','Edit','1','J1D02H','Hapus','1',
				'J1D03' ,'Pendataan Bukti Masuk Barang','1',	'J1D03D','Detil','1','J1D03T','Tambah','1','J1D03E','Edit','1','J1D03H','Hapus','1',
				'J1D04' ,'Pendataan Bukti Keluar Barang','1',	'J1D04D','Detil','1','J1D04T','Tambah','1','J1D04E','Edit','1','J1D04H','Hapus','1',
				'J1D05' ,'Pendataan Penjualan','1',				'J1D05D','Detil','1','J1D05T','Tambah','1','J1D05E','Edit','1','J1D05H','Hapus','1',
				'J5L01' ,'Laporan Masuk Barang per hari','5',
				'J5L02' ,'Laporan Keluar Barang per hari','5',
				'J5L03' ,'Laporan Penjualan per hari','5',
				'J5L04' ,'Laporan Kartu Stock','5',
				'J5L05' ,'Laporan Persediaan','5',
				'J6U01' ,'Perbaiki Data','6',
				'J6U02' ,'Tutup Buku','6',
				'J6U03' ,'Ganti Password','6',
				'K1D01' ,'Pendataan Jenis Penerimaan','1',	'K1D01D','Detil','1','K1D01T','Tambah','1','K1D01E','Edit','1','K1D01H','Hapus','1',
				'K1D02' ,'Pendataan Jenis Pengeluaran','1',	'K1D02D','Detil','1','K1D02T','Tambah','1','K1D02E','Edit','1','K1D02H','Hapus','1',
				'K1D03' ,'Pendataan Bukti Terima Uang','1',	'K1D03D','Detil','1','K1D03T','Tambah','1','K1D03E','Edit','1','K1D03H','Hapus','1',
				'K1D04' ,'Pendataan Bukti Keluar Uang','1',	'K1D04D','Detil','1','K1D04T','Tambah','1','K1D04E','Edit','1','K1D04H','Hapus','1',
				'K5L01' ,'Laporan Bukti Terima Uang','5',
				'K5L02' ,'Laporan Bukti Keluar Uang','5',
				'K5L03' ,'Laporan Harian','5',
				'K5L04' ,'Laporan Tunggakan','5',
				'K6U01' ,'Seting Uang Sekolah','6',
				'K6U02' ,'Perbaiki Data','6',
				'K6U03' ,'Tutup Buku','6',
				'K6U04' ,'Ganti Password','6',
				'P1D01' ,'Pendataan Kategori','1',		'P1D01D','Detil','1','P1D01T','Tambah','1','P1D01E','Edit','1','P1D01H','Hapus','1',
				'P1D02' ,'Pendataan Buku','1',			'P1D02D','Detil','1','P1D02T','Tambah','1','P1D02E','Edit','1','P1D02H','Hapus','1',
				'P1D03' ,'Pendataan Anggota','1',		'P1D03D','Detil','1','P1D03T','Tambah','1','P1D03E','Edit','1','P1D03H','Hapus','1',
				'P1D04' ,'Pendataan Peminjaman','1',	'P1D04D','Detil','1','P1D04T','Tambah','1',
				'P1D05' ,'Pendataan Pengembalian','1',	'P1D05D','Detil','1','P1D05T','Tambah','1','P1D05E','Edit','1','P1D05H','Hapus','1',
				'P5L01' ,'Laporan Buku dipinjam','5',
				'P5L02' ,'Laporan Buku belum kembali','5',
				'P5L03' ,'Laporan Denda','5',
				'P6U01' ,'Set Perpustakaan','6',
				'P6U03' ,'Ganti Password','6',
				'L1D01' ,'Pendataan Tingkat','1',		'L1D01D','Detil','1','L1D01T','Tambah','1','L1D01E','Edit','1','L1D01H','Hapus','1',
				'L1D02' ,'Pendataan Jurusan','1',		'L1D02D','Detil','1','L1D02T','Tambah','1','L1D02E','Edit','1','L1D02H','Hapus','1',
				'L1D03' ,'Pendataan Kelompok Kelas','1','L1D03D','Detil','1','L1D03T','Tambah','1','L1D03E','Edit','1','L1D03H','Hapus','1',
				'L1D04' ,'Pendataan Kelas','1',			'L1D04D','Detil','1','L1D04T','Tambah','1','L1D04E','Edit','1','L1D04H','Hapus','1',
				'L1D05'	,'Pendataan Pelajaran','1',		'L1D05D','Detil','1','L1D05T','Tambah','1','L1D05E','Edit','1','L1D05H','Hapus','1',
				'L1D06' ,'Pendataan Pengajaran','1',	'L1D06D','Detil','1','L1D06T','Tambah','1','L1D06E','Edit','1','L1D06H','Hapus','1',
				'L1D07' ,'Pendataan Bobot Nilai','1',	'L1D07D','Detil','1','L1D07E','Edit','1',
				'L1D08' ,'Minimum Kriteria','1',		'L1D08D','Detil','1','L1D08E','Edit','1',
				'L6U01' ,'Seting Tahun Ajaran','6',
				'L6U03' ,'Ganti Password','6');
				
		$query	="	DELETE 
					FROM 	menu";
		$result	=mysql_query($query) or die (mysql_error());
		
		$i=count($amenu)/3;
		$j=0;
		while($j<=$i)
		{
			$menu	=$amenu[($j+1)*3-3];
			$nama	=$amenu[($j+1)*3-2];
			$utama	=$amenu[($j+1)*3-1];

			$set	="	SET		menu.menu	='". mysql_escape_string($menu)."',
								menu.nama	='". mysql_escape_string($nama)."',	
								menu.utama	='". mysql_escape_string($utama)."'";
			$query 	="	INSERT INTO menu ".$set; 
			$result	=mysql_query($query) or die (mysql_error());

			$j++;
		}
		
		$query	="	DELETE 
					FROM 	user
					WHERE	user.userid='1'";
		$result	=mysql_query($query) or die (mysql_error());
		
		$set	="	SET		user.userid		='". mysql_escape_string(1)."',
							user.username	='". mysql_escape_string('admin')."'";
		$query 	="	INSERT INTO user ".$set; 
		$result	=mysql_query($query) or die (mysql_error());
		
		$query	="	DELETE 
					FROM 	user_level
					WHERE	user_level.userid='1'";
		$result	=mysql_query($query) or die (mysql_error());

		$j=0;
		while($j<$i)
		{
			$userid	='1';
			$menu	=$amenu[($j+1)*3-3];
			$utama	=$amenu[($j+1)*3-1];

			$set	="	SET		user_level.userid	='". mysql_escape_string($userid)."',
								user_level.menu		='". mysql_escape_string($menu)."',
								user_level.utama	='". mysql_escape_string($utama)."'";

			$query2 ="	INSERT INTO user_level ".$set; 
			$result2=mysql_query($query2) or die (mysql_error());
			$j++;
		}

		echo"
		<SCRIPT LANGUAGE='JavaScript'>
			window.alert ('Pembuatan Otorisasi untuk admin sudah selesai');
		</SCRIPT>";

		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A6U01_Cari\">\n";
 	}		
}
?>