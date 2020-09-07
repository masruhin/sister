<?php
//----------------------------------------------------------------------------------------------------
//Program		: A1D02.php  
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 01/05/2012
//Keterangan	: Fungsi-fungsi untuk Data userid
//----------------------------------------------------------------------------------------------------
if(!defined("sister")) 
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}

require("../fungsi_umum/sysconfig.php");
require FUNGSI_UMUM_DIR.'fungsi_admin.php';

// -------------------------------------------------- Class --------------------------------------------------
class A1D02class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function A1D02_Cari()
	{
		$userid	=$_SESSION['Admin']['userid'];

		// mengakses database userids
    	$query 	="	SELECT 		t_mstkry.* 
					FROM 		t_mstkry
					ORDER BY 	t_mstkry.kdekry";
		$result	=mysql_query($query) or die (mysql_error());

    	echo"
		<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><b>USER</b></TD></TR>
			<TR></TR><TR></TR>
		</TABLE>
  		
		<FORM action=administrator.php method=\"post\">
			<DIV style='overflow:auto;width:100%;height:430px;padding-right:-2px;'>                
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD width= 4% HEIGHT='20'><CENTER>No</CENTER></TD>
						<TD width=10%><CENTER>username	</CENTER></TD>
						<TD width=32%><CENTER>Nama		</CENTER></TD>
						<TD width=40%><CENTER>Visit		</CENTER></TD>
						<TD width=10%><CENTER>Tanggal	</CENTER></TD>
						<TD width= 4%><CENTER>Detil		</CENTER></TD>
					</TR>";
				
					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[kdekry]	</CENTER></TD>
							<TD><CENTER>$data[nmakry]	</CENTER></TD>
							<TD>$data[kunjung]</TD>
							<TD><CENTER>$data[waktu]	</CENTER></TD>";
							// otorisasi akses detil							
							if (hakakses("A1D02D")==1)
							{
								echo"
								<TD><CENTER><a href='administrator.php?mode=A1D02&userid=$data[userid]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}	
						echo"		
						</TR>";
					}
				echo"
				</TABLE>
			</DIV>
			<BR>
		</FORM>";
	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function A1D02()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
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
				$isian3	='disabled';
				break;
			case 'tambah':
				$isian1	='enable';
				$isian2	='enable';
				$isian3	='disabled';
				break;
			case 'edit':
				$isian1	='disabled';
				$isian2	='enable';
				$isian3	='disabled';
				break;
			case 'copy':
				$isian1	='disabled';
				$isian2	='disabled';
				$isian3	='enable';
				break;
		}		
		
		if ($pilihan=='detil' or $pilihan=='edit' or $pilihan=='copy')
		{
			$useridB=$_GET['userid'];
			$query 	="	SELECT 	t_mstkry.* 
						FROM 	t_mstkry
						WHERE 	t_mstkry.userid='". mysql_escape_string($useridB)."'";
			$result= mysql_query($query) or die (mysql_error());
			$data 	=mysql_fetch_array($result);
		
			$userid		=$data[userid];
			$kdekry	=$data[kdekry];
			$nmakry	=$data[nmakry];
			if($pilihan=='detil')
				$password	=$data[password];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian1
  		echo"
		<FORM ID='validasi' ACTION='administrator.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>USER</B></TD>
					<TD COLSPAN='5' ALIGN='right'>";
						if ($pilihan=='detil')
						{
							//echo"
							//| <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=pendaftaran'>Pendaftaran</a>";
							echo"
							| <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=tata_usaha'>Tata Usaha</a> 
							| <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=personalia'>Personalia</a> 
							| <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=penjualan'>Penjualan</a> 
							| <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=keuangan'>Keuangan</a> 
							| <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=perpustakaan'>Perpustakaan</a>
							| <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=kurikulum'>Kurikulum</a>
							| <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=administrator'>Administrator</a>";
						}	
					echo"
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Karyawan</TD>
					<TD WIDTH='85%'>:
						<INPUT 	NAME		='kdekry'
								TYPE		='text' 	
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$kdekry'
								ID			='kdekry'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...diisi'
								$isian1>
						</SPAN>
					</TD>
				</TR>
				<TR><TD>Nama Karyawan</TD>
					<TD>:
						<INPUT 	NAME		='nmakry'
								TYPE		='text' 	
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmakry'
								ID			='nmakry'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...diisi'
								$isian1>
						</SPAN>
					</TD>
				</TR>";
				
				if($pilihan!='detil' and $pilihan!='copy')
				{
					echo"
					<TR><TD>Password</TD>
						<TD>:
							<INPUT 	NAME		='password'
									TYPE		='password'
									SIZE		='30'
									MAXLENGTH	='30'
									VALUE 		='$password'
									ONKEYPRESS	='return enter(this,event)'
									$isian2>
						</TD>
					</TR>	

					<TR><TD>Ulangi Password</TD>
						<TD>:
							<INPUT 	NAME		='password2'
									TYPE		='password'
									SIZE		='30'
									MAXLENGTH	='30'
									VALUE 		='$password2'
									ONKEYPRESS	='return enter(this,event)'
									$isian2>
						</TD>
					</TR>";
				}
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
									$isian3>
							<OPTION VALUE=''>--Pilih--</OPTION>";
							$query="	SELECT 		user.* 
										FROM 		user  
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
					
			// tombol copy
			if (hakakses('A1D02')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Copy Otorisasi dari user lain' 	onClick=window.location.href='administrator.php?mode=A1D02&userid=$userid&pilihan=copy'>"; 
			}	
					
			// tombol simpan (copy)
			if($pilihan=='copy')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='copy'>
				<INPUT TYPE='hidden' NAME='userid'		VALUE='$userid'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='A1D02_Copy'>";
			}

			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='A1D02_Save'>
				<INPUT TYPE='hidden' NAME='userid'	VALUE='$userid'>";
			}

			echo"
			<INPUT TYPE='button' 	VALUE='Daftar USER' 	onClick=window.location.href='administrator.php?mode=A1D02_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}

	// -------------------------------------------------- Detil Menu --------------------------------------------------
	function A1D02_Menu()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		// iuseridiasi parameter berdasarkan pilihan tombol
		$pilihan	=$_GET['pilihan'];
		$menuutama	=$_GET['menuutama'];
		
		switch($menuutama)
		{
			/*case 'pendaftaran':
				$judul='PENDAFTARAN';
				$tabel='D';
				break;
			*/	
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
		$query 	="	SELECT 	t_mstkry.*
					FROM 	t_mstkry
					WHERE 	t_mstkry.userid='". mysql_escape_string($useridB)."'";
		$result= mysql_query($query) or die (mysql_error());
		$data 	=mysql_fetch_array($result);
		$userid	=$data[userid];
		$kdekry	=$data[kdekry];
		$nmakry	=$data[nmakry];
		
  		echo"
		<FORM ID='validasi' ACTION='administrator.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>$judul</B></TD>
					<TD COLSPAN='2' ALIGN='right'>";
						echo"
						| <a href='administrator.php?mode=A1D02&userid=$userid&pilihan=$pilihan'>User</a>";
						/*if($menuutama!='pendaftaran')
							echo" | <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=pendaftaran'>Pendaftaran</a>";
						*/	
						if($menuutama!='tata_usaha')	
							echo" | <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=tata_usaha'>Tata Usaha</a>"; 
						if($menuutama!='personalia')
							echo" | <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=personalia'>Personalia</a>"; 
						if($menuutama!='penjualan')
							echo" | <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=penjualan'>Penjualan</a>"; 
						if($menuutama!='keuangan')
							echo" | <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=keuangan'>Keuangan</a>"; 
						if($menuutama!='perpustakaan')
							echo" | <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=perpustakaan'>Perpustakaan</a>";
						if($menuutama!='kurikulum')
							echo" | <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=kurikulum'>Kurikulum</a>";
						if($menuutama!='administrator')
							echo" | <a href='administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=$pilihan&menuutama=administrator'>Administrator</a>";
					echo"
					</TD>
				</TR>
				
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Karyawan</TD>
					<TD WIDTH='85%'>:
						<INPUT 	NAME		='kdekry'
								TYPE		='text' 	
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$kdekry'
								DISABLED>
					</TD>
				</TR>			
				<TR><TD>Nama Karyawan</TD>
					<TD>:
						<INPUT 	NAME		='nmakry'
								TYPE		='text' 	
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmakry'
								DISABLED>
						</SPAN>
					</TD>
				</TR>
				<TR><TD COLSPAN='2'><HR></TD></TR>		
			</TABLE>	
			
			<DIV style='overflow:auto;width:100%;height:340px;padding-right:-2px;'>                
				<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
					<TR>
						<TD WIDTH='50%' VALIGN='top'><B>OTORISASI YANG DIPILIH</B>
							<INPUT TYPE='button'	VALUE='Hapus Semua Otorisasi yang dipilih' 	onClick=window.location.href='administrator.php?mode=A1D02_Hapus_Menu_Semua&userid=$userid&tabel=$tabel&menuutama=$menuutama'>";
							$query1 ="	SELECT 		t_akskry.*,menu.nama
										FROM 		t_akskry,menu
										WHERE 		t_akskry.userid			='$useridB'	AND
													SUBSTR(t_akskry.menu,1,1)	='$tabel'	AND
													t_akskry.menu				=menu.menu
										ORDER BY 	t_akskry.menu"; 
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
									<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
										<TD>$data1[menu]</TD>";
										$simbol	='&gt';
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
										<TD><CENTER><a href='administrator.php?mode=A1D02_Hapus_Menu&userid=$data1[userid]&idlevel=$data1[idlevel]&menuutama=$menuutama'><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
									echo"	
									</TR>";
								}
							echo"	
							</TABLE>						
						</TD>
				
						<TD WIDTH='50%' VALIGN='top'><B>PILIHAN OTORISASI</B>
							<INPUT TYPE='button'	VALUE='Pilih Semua Otorisasi' 	onClick=window.location.href='administrator.php?mode=A1D02_Save_Menu_Semua&userid=$userid&tabel=$tabel&menuutama=$menuutama'>";
							$query2 ="	SELECT 		DISTINCT menu.*,t_akskry.userid
										FROM 		menu
										LEFT JOIN 	t_akskry ON menu.menu=t_akskry.menu	AND t_akskry.userid='$userid'
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
									<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
										<TD>$data2[menu]</TD>";
										$simbol	='&gt';
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
											<TD><CENTER><a href='administrator.php?mode=A1D02_Save_Menu&userid=$useridB&menu=$data2[menu]&utama=$data2[utama]&menuutama=$menuutama'><IMG src='../images/pilih_e.gif' BORDER='0'></a></CENTER></TD>";
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
			
			<INPUT TYPE='button' 	VALUE='Daftar USER' 	onClick=window.location.href='administrator.php?mode=A1D02_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}
	
	// -------------------------------------------------- Hapus_Menu --------------------------------------------------
	function A1D02_Hapus_Menu()
	{
		$userid=$_GET['userid'];		
		$idlevel=$_GET['idlevel'];
		$menuutama	=$_GET['menuutama'];
		
		$query	="	DELETE 
					FROM 	t_akskry
					WHERE 	t_akskry.userid='". mysql_escape_string($userid)."'	AND
							t_akskry.idlevel='". mysql_escape_string($idlevel)."'";
		$result	=mysql_query($query) or die (mysql_error());

		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=detil&menuutama=$menuutama\">\n";
	}	

	// -------------------------------------------------- Hapus_Menu_Semua --------------------------------------------------
	function A1D02_Hapus_Menu_Semua()
	{
		$userid	=$_GET['userid'];		
		$tabel	=$_GET['tabel'];
		$menuutama	=$_GET['menuutama'];
		
		$query	="	DELETE 
					FROM 	t_akskry
					WHERE 	t_akskry.userid='". mysql_escape_string($userid)."'	AND
							SUBSTR(t_akskry.menu,1,1)='$tabel'";
		$result	=mysql_query($query) or die (mysql_error());

		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=detil&menuutama=$menuutama\">\n";
	}	
	
	// -------------------------------------------------- Save --------------------------------------------------
	function A1D02_Save()
	{
		require FUNGSI_UMUM_DIR.'fungsi_pass.php';
		$userid		=addslashes($_POST['userid']);
		$useridB	=addslashes($_POST['useridB']);
		$kdekry	=addslashes($_POST['kdekry']);
		$password	=addslashes($_POST['password']);
		$password2	=addslashes($_POST['password2']);
		$pilihan	=$_POST['pilihan'];
		
		if($password!=$password2)
		{
			echo"
			<SCRIPT LANGUAGE='JavaScript'>
				window.alert ('Password harus sama');
			</SCRIPT>";
			if($pilihan=='edit')
			{
				echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A1D02&userid=$userid&pilihan=edit\">\n"; 
			}
			else
			{
				echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A1D02&userid=$userid&pilihan=tambah\">\n"; 
			}
		}
		else
		{
		if($password=='' and $password2=='')
		{
			$query 		="	SELECT 	t_mstkry.* 
							FROM 	t_mstkry
							WHERE 	userid = '". mysql_escape_string($userid)."'";
			$result		=mysql_query($query) or die (mysql_error());
  			$data 		=mysql_fetch_array($result);
    		$password 	=$data[password];
		}
		else
		{
			$password = hex($password,82);
		}

		$set	="	SET		t_mstkry.userid		='". mysql_escape_string($userid)."',
							t_mstkry.kdekry	='". mysql_escape_string($kdekry)."',
							t_mstkry.password	='". mysql_escape_string($password)."'";
		
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_mstkry ".$set.
					 "	WHERE 	t_mstkry.userid	='". mysql_escape_string($useridB)	."'";
			$result	=mysql_query($query) or die (mysql_error());
        }
  		else
  		{
  			$query 	="	INSERT INTO t_mstkry ".$set; 
			$result	=mysql_query($query) or die (mysql_error());
  		}
		
		$query 	="	SELECT 	t_mstkry.* 
					FROM 	t_mstkry
					WHERE 	kdekry = '". mysql_escape_string($kdekry)."'";
		$result	=mysql_query($query) or die (mysql_error());
		$data 	=mysql_fetch_array($result);
    					
    	$userid =$data[userid]; 
		
		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A1D02&userid=$userid\">\n"; 
		}
	}

	// -------------------------------------------------- Save Tata Usaha --------------------------------------------------
	function A1D02_Save_Menu()
	{
  		$userid	=$_GET['userid'];
  		$menu	=$_GET['menu'];
		$utama	=$_GET['utama'];
		$menuutama	=$_GET['menuutama'];
		
		$set	="	SET		t_akskry.userid	='". mysql_escape_string($userid)."',
							t_akskry.menu		='". mysql_escape_string($menu)."',
							t_akskry.utama	='". mysql_escape_string($utama)."'";

		$query 	="	INSERT INTO t_akskry ".$set; 
		$result	=mysql_query($query) or die (mysql_error());

		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=detil&menuutama=$menuutama\">\n";
 	}	
	
	// -------------------------------------------------- Save Tata Usaha --------------------------------------------------
	function A1D02_Save_Menu_Semua()
	{
  		$userid	=$_GET['userid'];
  		$tabel	=$_GET['tabel'];
		$menuutama	=$_GET['menuutama'];

		$query	="	DELETE 
					FROM 	t_akskry
					WHERE 	t_akskry.userid='". mysql_escape_string($userid)."'	AND
							SUBSTR(t_akskry.menu,1,1)='$tabel'";
		$result	=mysql_query($query) or die (mysql_error());
		
		$query 	="	SELECT 		menu.*
					FROM 		menu
					WHERE 		SUBSTR(menu.menu,1,1)='$tabel'"; 
		$result	=mysql_query($query) or die (mysql_error());

		while($data =mysql_fetch_array($result))
		{
			$menu	=$data[menu];
			$utama	=$data[utama];

			$set	="	SET		t_akskry.userid	='". mysql_escape_string($userid)."',
								t_akskry.menu		='". mysql_escape_string($menu)."',
								t_akskry.utama	='". mysql_escape_string($utama)."'";

			$query2 ="	INSERT INTO t_akskry ".$set; 
			$result2=mysql_query($query2) or die (mysql_error());
		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A1D02_Menu&userid=$userid&pilihan=detil&menuutama=$menuutama\">\n";
 	}	

	// -------------------------------------------------- Save Copy --------------------------------------------------
	function A1D02_Copy()
	{
		$userid		=$_POST['userid'];
		$usercopy	=$_POST['usercopy'];
		
		$query	="	DELETE 
					FROM 	t_akskry
					WHERE 	t_akskry.userid='". mysql_escape_string($userid)."'";
		$result	=mysql_query($query) or die (mysql_error());
		
		$query 	="	SELECT 		user_level.*
					FROM 		user_level
					WHERE 		user_level.userid='$usercopy'"; 
		$result	=mysql_query($query) or die (mysql_error());

		while($data =mysql_fetch_array($result))
		{
			$menu	=$data[menu];
			$utama	=$data[utama];

			$set	="	SET		t_akskry.userid	='". mysql_escape_string($userid)."',
								t_akskry.menu		='". mysql_escape_string($menu)."',
								t_akskry.utama	='". mysql_escape_string($utama)."'";

			$query2 ="	INSERT INTO t_akskry ".$set; 
			$result2=mysql_query($query2) or die (mysql_error());
		}

		echo"
		<SCRIPT LANGUAGE='JavaScript'>
			window.alert ('Copy Otorisasi sudah selesai');
		</SCRIPT>";

		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A1D02&userid=$userid\">\n"; 
 	}		
}
?>