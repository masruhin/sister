<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program			: perpustakaan.php
//Di edit oleh		: hin & rusdi
//Tanggal Edit		: 07/12/2011
//Keterangan		: Menu Utama penjualan (sistem)
//-----------------------------------------------------------------------------------------------------
require '../fungsi_umum/sysconfig.php';
require FUNGSI_UMUM_DIR.'koneksi.php';
define("sister",1);

echo"
<HTML>
	<HEAD>
		<TITLE>Login User</TITLE>
		<LINK rel='stylesheet' type='text/css' href='../css/styleutama.css'>
		<link href='../images/jps.ico' rel='icon' type='image/x-icon'/>
	</HEAD>
	
	<BODY TOPMARGIN=0 LEFTMARGIN=0 RIGHTMARGIN=0>";
?>
	<script type="text/javascript">
		/* <![CDATA[ */
		SetCookie('didgettingstarted',1);

		function setDisplayMenu(idName) 
		{
			if (idName == '') 
			{
				// '' is news, AND etc.
				idName = 'o';  
			}
			if ( idName !=null) 
			{
				closeMenuDiv();
				openMenuDiv(idName); 
			}
			else 
			{
				closeMenuDiv(); 
			}
		}

		function clickOpenMenu(idName) 
		{
			closeMenuDiv();
			openMenuDiv(idName); 
		}

		function closeMenuDiv() 
		{
			var aObjDiv = document.getElementsByTagName("Div");
			var numDiv = aObjDiv.length;

			for(i=0; i < numDiv; i++) 
			{
				var idName = aObjDiv[i].getAttribute("id");

				if(idName) 
				{
					var isMenu = idName.match(/SubCat/i);

					if(isMenu !=null) 
					{
						document.getElementById(idName).style.visibility = "hidden";
						document.getElementById(idName).style.position = "absolute"; 
					}
				}
			}
		}

		function openMenuDiv(idName) 
		{
			document.getElementById('SubCat_'+idName).style.visibility = "visible";
			document.getElementById('SubCat_'+idName).style.position = "static"; 
		}

		function clickOpenPage(URL,target) 
		{
			window.open(URL, target); 
		}
	</script>
<?php
	require("../fungsi_umum/sysconfig.php");
	require FUNGSI_UMUM_DIR.'clock.php';
	require FUNGSI_UMUM_DIR.'fungsi_admin.php';
	require FUNGSI_UMUM_DIR.'fungsi_periode.php';
	
	$user	=$_SESSION["Admin"]["nmakry"];
    $kdekry	=$_SESSION["Admin"]["kdekry"];
	$tgl 	=date("j F Y");
	$modul	="PERPUSTAKAAN";

	$prd 	=periode($modul);

	if (!isset($_SESSION['Admin']))
	{
		echo"
		Anda harus login dulu.. redirecting\n";
	
		echo"
		<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
	}
	else
	{
		if (isset($_GET['logout']))
		{
			$username	=$_SESSION["Admin"]["username"];
			unset($_SESSION['Admin']);
			//session_destroy();
			echo"
			Terima kasih.. redirecting\n";
			
			echo"
			<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
		}
		else
		{
			// -------------------------------------------------- Header --------------------------------------------------
			echo"
			<TABLE ALIGN=CENTER WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>
				<TR><TD BGCOLOR='#1F437F'><IMG src='../images/atas_admin_kiri.jpg' HEIGHT='100' WIDTH='500'></TD>
					<TD BGCOLOR='#1F437F' WIDTH='100%'></TD>
					<TD BGCOLOR='#1F437F'><IMG src='../images/atas_admin_kanan.jpg' HEIGHT='100' WIDTH='300'></TD>
				</TR>
			</TABLE>	
			<TABLE ALIGN=CENTER WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>
				<TR><TD ALIGN='left' 	WIDTH='12%' HEIGHT='20'	BGCOLOR='#fcc012'><B>&nbsp&nbsp&nbsp$modul</B></TD>
					<TD ALIGN='right'	WIDTH='83%'				BGCOLOR='#fcc012'><FONT class='adminhead'>Selamat Datang <B>$user</B> - Tanggal : <B>$tgl</B> - Jam :&nbsp</FONT></TD>
					<TD ALIGN='left' 	WIDTH=' 5%'				BGCOLOR='#fcc012'><FONT class='adminhead'><B>$jam</B></FONT></TD>
				</TR>
				
				<TABLE ALIGN=CENTER	WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>
					<TR><TD></TD></TR>
						<TR><TD WIDTH='14%' VALIGN='top' BGCOLOR='#3362A8'>";

						// -------------------------------------------------- Menu --------------------------------------------------
						echo"
						<DIV id='LeftMenu'>
							<DIV class='LeftMenuHead' onclick='clickOpenPage(\"perpustakaan.php\",\"_top\"); return false;' style='cursor: pointer;'><IMG src='../images/home.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> [ Home ]</DIV>";

							echo"
							<DIV class='LeftMenuline'></DIV>
							<DIV class='LeftMenuHead' onclick='clickOpenMenu(\"pf\"); return false;' style='cursor: pointer;'><IMG src='../images/pendataan.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> Pendataan</DIV>
							<DIV style='visibility: hidden; position: absolute;' id='SubCat_pf'>";
								$query 	="	SELECT 		* 
											FROM 		t_akskry 
											WHERE 		userid	='".mysql_escape_string($_SESSION['Admin']['userid'])."' AND 
														utama	='1' 
											ORDER BY 	menu";
								$result	=mysql_query($query) or die (mysql_error());
					
								while($row	=mysql_fetch_array($result))
								{
									if ($row[menu]=='P1D01') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P1D01_Cari' class=ver11>- Kategori</a></DIV>";
									if ($row[menu]=='P1D02') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P1D02_Cari'	class=ver11>- Buku</a></DIV>";
									if ($row[menu]=='P1D03') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P1D03_Cari'	class=ver11>- Anggota</a></DIV>";
									if ($row[menu]=='P1D04') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P1D04&pilihan=tambah'	class=ver11>- Peminjaman Siswa</a></DIV>";
									if ($row[menu]=='P1D05') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P1D05'	class=ver11>- Pengembalian</a></DIV>";
									if ($row[menu]=='P1D06') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P1D06&pilihan=tambah'	class=ver11>- Peminjaman Guru</a></DIV>";
								}

							echo"
							</DIV>
							<DIV class='LeftMenuline'></DIV>
							<DIV class='LeftMenuHead' onclick='clickOpenMenu(\"m\"); return false;' style='cursor: pointer;'><IMG src='../images/laporan.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> Laporan</DIV>
							<DIV style='visibility: hidden; position: absolute;' id='SubCat_m'>";
								$query 	="	SELECT 		* 
											FROM 		t_akskry 
											WHERE 		userid	='".mysql_escape_string($_SESSION['Admin']['userid'])."' AND 
														utama	='5' 
											ORDER BY 	menu";
								$result = mysql_query ($query) or die (mysql_error());
					
								while($row = mysql_fetch_array($result))
								{
									if ($row[menu]=='P5L01') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P5L01'	class=ver11>- Buku dipinjam Siswa</a></DIV>";
									if ($row[menu]=='P5L02') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P5L02'	class=ver11>- Buku belum kembali Siswa</a></DIV>";
									if ($row[menu]=='P5L03') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P5L03'	class=ver11>- Denda</a></DIV>";
									if ($row[menu]=='P5L04') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P5L04'	class=ver11>- Buku dipinjam Guru</a></DIV>";
									if ($row[menu]=='P5L05') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P5L05'	class=ver11>- Buku belum kembali Guru</a></DIV>";
								}

							echo"
							</DIV>
							<DIV class='LeftMenuline'></DIV><DIV class='LeftMenuHead' onclick='clickOpenMenu(\"l\"); return false;' style='cursor: pointer;'><IMG src='../images/utility.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> Utility</DIV>
							<DIV style='visibility: hidden; position: absolute;' id='SubCat_l'>";
								$query 	="	SELECT 		* 
											FROM 		t_akskry 
											WHERE 		userid='".mysql_escape_string($_SESSION['Admin']['userid'])."' AND 
														utama='6'
											ORDER BY 	menu ";
								$result = mysql_query ($query) or die (mysql_error());
					
								while($row = mysql_fetch_array($result))
								{
									if ($row[menu]=='P6U01') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P6U01' class=ver11>- Set Perpustakaan</a></DIV>";
									if ($row[menu]=='P6U03') echo"<DIV style='cursor: pointer;'><a href='perpustakaan.php?mode=P6U03_Edit' class=ver11>- Ganti Password</a></DIV>";
								}

							echo"
							</DIV>
							<DIV class='LeftMenuline'></DIV>
							<DIV class='LeftMenuHead' onclick='clickOpenPage(\"../index.php\",\"_top\"); return false;' style='cursor: pointer;'><IMG src='../images/logout.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> [ Logout ]</DIV>
						</DIV>";

						echo"
						</TD>";
						// -------------------------------------------------- akhir menu --------------------------------------------------
						echo"	
						<TD VALIGN=top>";

						// -------------------------------------------------- tengah --------------------------------------------------
						require("pendataan/P1D01.php");
						require("pendataan/P1D02.php");
						require("pendataan/P1D03.php");
						require("pendataan/P1D04.php");
						require("pendataan/P1D05.php");
						require("pendataan/P1D06.php");
						require("laporan/P5L01.php");
						require("laporan/P5L02.php"); // uncomment jika diperlukan || buatan d || menu
						require("laporan/P5L03.php"); // uncomment jika diperlukan || buatan d || menu
						require("laporan/P5L04.php");
						require("laporan/P5L05.php");
						require("Utility/P6U01.php");
						require("Utility/P6U03.php");

						$P1D01class		=new P1D01class;
						$P1D02class 	=new P1D02class;
						$P1D03class 	=new P1D03class;
						$P1D04class 	=new P1D04class;
						$P1D05class 	=new P1D05class;
						$P1D06class 	=new P1D06class;
						$P5L01class 	=new P5L01class;
						$P5L02class 	=new P5L02class; // uncomment jika diperlukan || buatan d || menu
						$P5L03class 	=new P5L03class; // uncomment jika diperlukan || buatan d || menu
						$P5L04class 	=new P5L04class;
						$P5L05class 	=new P5L05class;
						$P6U01class 	=new P6U01class;
						$P6U03class 	=new P6U03class;

						if (login_check()==false)
						{
							echo"
							<CENTER><DIV class='display_red'>
							<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0>
								<TR><TD COLSPAN=2><CENTER>.: Konfirmasi :.</CENTER></TD></TR>
    							<TR><TD ><IMG src='login.png' ALIGN=left HEIGHT=60 WIDTH=60></TD>
									<TD>Jika tidak ada kegiatan sama sekali, Anda akan logout secara otomatis</TD>
								</TR>
							</TABLE>
 							</DIV></CENTER>";

							echo"
							<script src='#' onload='alert(\"Jika tidak ada kegiatan sama sekali, Anda akan logout secara otomatis\")'></script>";
							
							echo"
							<meta http-equiv=\"refresh\" content=\"1;url=perpustakaan.php?logout\">\n";
						}

						if (isset($_GET['mode'])) 
							$mode=$_GET['mode'];
						else 
							$mode=$_POST['mode'];
							
						switch($mode)
						{
    						default:
    						admin();
    						break;

							// -------------------------------------------------- Barang --------------------------------------------------
    						case "P1D01";
								if (hakakses("P1D01")==1) $P1D01class->P1D01();
								else errordata();
    							break;
							case "P1D01_Hapus";
								if (hakakses("P1D01H")==1) $P1D01class->P1D01_Hapus();
								else errordata();
    							break;	
							case "P1D01_Cari";
								if (hakakses("P1D01")==1) $P1D01class->P1D01_Cari();
								else errordata();
    							break;
    						case "P1D01_Save";
								if (hakakses("P1D01")==1) $P1D01class->P1D01_Save();
								else errordata();
    							break;

							// -------------------------------------------------- Jenis Keluar Uang --------------------------------------------------
    						case "P1D02";
								if (hakakses("P1D02")==1) $P1D02class->P1D02();
								else errordata();
    							break;
							case "P1D02_Hapus";
								if (hakakses("P1D02H")==1) $P1D02class->P1D02_Hapus();
								else errordata();
    							break;	
							case "P1D02_Cari";
								if (hakakses("P1D02")==1) $P1D02class->P1D02_Cari();
								else errordata();
    							break;
    						case "P1D02_Save";
								if (hakakses("P1D02")==1) $P1D02class->P1D02_Save();
								else errordata();
    							break;

							// -------------------------------------------------- Bukti Terima Uang --------------------------------------------------
    						case "P1D03";
								if (hakakses("P1D03")==1) $P1D03class->P1D03();
								else errordata();
    							break;
							case "P1D03_Cari";
								if (hakakses("P1D03")==1) $P1D03class->P1D03_Cari();
								else errordata();
    							break;
							case "P1D03_Siswa";
								if (hakakses("P1D03")==1) $P1D03class->P1D03_Siswa();
								else errordata();
    							break;
							case "P1D03_Karyawan";
								if (hakakses("P1D03")==1) $P1D03class->P1D03_Karyawan();
								else errordata();
    							break;

							// -------------------------------------------------- Bukti Keluar Uang --------------------------------------------------
    						case "P1D04";
								if (hakakses("P1D04")==1) $P1D04class->P1D04();
								else errordata();
    							break;
							case "P1D04_Cari";
								if (hakakses("P1D04")==1) $P1D04class->P1D04_Cari();
								else errordata();
    							break;
    						case "P1D04_Save";
								if (hakakses("P1D04")==1) $P1D04class->P1D04_Save();
								else errordata();
    							break;
    						case "P1D04_Save_Item";
								if (hakakses("P1D04")==1) $P1D04class->P1D04_Save_Item();
								else errordata();
    							break;
							// -------------------------------------------------- Bukti Keluar Uang --------------------------------------------------
    						case "P1D05";
								if (hakakses("P1D05")==1) $P1D05class->P1D05();
								else errordata();
    							break;
							case "P1D05_Hapus";
								if (hakakses("P1D05H")==1) $P1D05class->P1D05_Hapus();
								else errordata();
    							break;	
							case "P1D05_Cari";
								if (hakakses("P1D05")==1) $P1D05class->P1D05_Cari();
								else errordata();
    							break;
    						case "P1D05_Save";
								if (hakakses("P1D05")==1) $P1D05class->P1D05_Save();
								else errordata();
    							break;
    							case "P1D05_Save_Item";
								if (hakakses("P1D05")==1) $P1D05class->P1D05_Save_Item();
								else errordata();
    							break;
    						case "P1D05_Update";
								if (hakakses("P1D05")==1) $P1D05class->P1D05_Update();
								else errordata();
    							break;
							// -------------------------------------------------- Bukti Keluar Uang --------------------------------------------------
    						case "P1D06";
								if (hakakses("P1D06")==1) $P1D06class->P1D06();
								else errordata();
    							break;
							case "P1D06_Cari";
								if (hakakses("P1D06")==1) $P1D06class->P1D06_Cari();
								else errordata();
    							break;
    						case "P1D06_Save";
								if (hakakses("P1D06")==1) $P1D06class->P1D06_Save();
								else errordata();
    							break;
    						case "P1D06_Save_Item";
								if (hakakses("P1D06")==1) $P1D06class->P1D06_Save_Item();
								else errordata();
    							break;
								
							// -------------------------------------------------- Laporan Buku dipinjam Siswa --------------------------------------------------
							case "P5L01";
								if (hakakses("P5L01")==1) $P5L01class->P5L01();
								else errordata();
    							break;	
								// -------------------------------------------------- Laporan Buku belum kembali Siswa --------------------------------------------------
							case "P5L02";
								if (hakakses("P5L02")==1) $P5L02class->P5L02();
								else errordata();
    							break;
                            // -------------------------------------------------- Laporan Harian --------------------------------------------------
							case "P5L03";
								if (hakakses("P5L03")==1) $P5L03class->P5L03();
								else errordata();
    							break;
							// -------------------------------------------------- Laporan Buku dipinjam Guru --------------------------------------------------
							case "P5L04";
								if (hakakses("P5L04")==1) $P5L04class->P5L04();
								else errordata();
    							break;	
								// -------------------------------------------------- Laporan Buku belum kembali Guru --------------------------------------------------
							case "P5L05";
								if (hakakses("P5L05")==1) $P5L05class->P5L05();
								else errordata();
    							break;
                            // -------------------------------------------------- Set Perpustakaan --------------------------------------------------
							case "P6U01";
								if (hakakses("P6U01")==1) $P6U01class->P6U01();
								else errordata();
    							break;
    						case "P6U01_Save";
								if (hakakses("P6U01")==1) $P6U01class->P6U01_Save();
								else errordata();
    							break;
                            // -------------------------------------------------- Ganti Password --------------------------------------------------
							case "P6U03_Edit";
								if (hakakses("P6U03")==1) $P6U03class->P6U03_Edit();
								else errordata();
    							break;
    						case "P6U03_Save";
								if (hakakses("P6U03")==1) $P6U03class->P6U03_Save();
								else errordata();
    							break;
							// ----------------------------------------------------------------------------------------------------
						}
						// -------------------------------------------------- tutup --------------------------------------------------
						echo"
						</TD>
					</TR>
				</TABLE>
			</TABLE>";
			
			echo"
			<TABLE WIDTH='100%' ALIGN='CENTER' BORDER=0 BORDERCOLOR='#ffffff' CELLSPACING=0 CELLPADDING=0>	
				<TR><TD COLSPAN=2><IMG src='../images/bawah_admin.jpg' HEIGHT=2 WIDTH='100%'></TD></TR>
				<TR><TD WIDTH ='50%' HEIGHT='10' BGCOLOR='#ffffff'><FONT class='adminhead'>Copyright &copy 2012 - SAINT JOHN'S SCHOOL</FONT></TD>
					<TD WIDTH ='50%' ALIGN='right'><FONT class='adminhead'>Versi $versi <B>Best viewed with Mozilla Firefox</B></FONT></TD>
				</TR>
			</TABLE>";
		}
	}
	echo"
	</TODY>
</HTML>";
?>
