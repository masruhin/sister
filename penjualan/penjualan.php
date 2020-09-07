<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: penjualan.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Menu Utama penjualan (sistem)
//-----------------------------------------------------------------------------------------------------
require '../fungsi_umum/sysconfig.php';
require FUNGSI_UMUM_DIR.'koneksi.php';
define("sister",1);

echo"
<HTML>
	<HEAD>
		<TITLE>SAINT JOHN'S SCHOOL</TITLE>
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
	$modul	="PENJUALAN";

	$prd 	=periode($modul);
	$periode 	=prdtotgl($prd);
	if($prd=='')
	{
		echo"
		<SCRIPT TYPE='text/javascript'>
			window.alert('Transaksi PENJUALAN harus di seting dahulu di Administrator')
		</SCRIPT>";
		
		echo"
		<meta http-equiv='refresh' content='0; url=../index.php'>\n"; 
	}

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
							<DIV class='LeftMenuHead' onclick='clickOpenPage(\"penjualan.php\",\"_top\"); return false;' style='cursor: pointer;'><IMG src='../images/home.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> [ Home ]</DIV>";

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
									if ($row[menu]=='J1D01') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J1D01_Cari' class=ver11>- Kelompok Barang</a></DIV>";
									if ($row[menu]=='J1D02') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J1D02_Cari'	class=ver11>- Barang</a></DIV>";
									if ($row[menu]=='J1D03') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J1D03&pilihan=tambah'	class=ver11>- Bukti Masuk Barang</a></DIV>";
									if ($row[menu]=='J1D04') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J1D04&pilihan=tambah'	class=ver11>- Bukti Keluar Barang</a></DIV>";
									if ($row[menu]=='J1D05') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J1D05&pilihan=tambah'	class=ver11>- Penjualan</a></DIV>";
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
									if ($row[menu]=='J5L01') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J5L01'	class=ver11>- Masuk Barang per hari</a></DIV>";
									if ($row[menu]=='J5L02') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J5L02'	class=ver11>- Keluar Barang per hari</a></DIV>";
									if ($row[menu]=='J5L03') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J5L03'	class=ver11>- Penjualan per hari</a></DIV>";
									if ($row[menu]=='J5L04') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J5L04'	class=ver11>- Kartu Stock</a></DIV>";
									if ($row[menu]=='J5L05') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J5L05'	class=ver11>- Persediaan</a></DIV>";
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
									if ($row[menu]=='J6U01') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J6U01' 		class=ver11>- Perbaiki Data</a></DIV>";
									if ($row[menu]=='J6U02') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J6U02' 		class=ver11>- Tutup Buku</a></DIV>";
									if ($row[menu]=='J6U03') echo"<DIV style='cursor: pointer;'><a href='penjualan.php?mode=J6U03_Edit' class=ver11>- Ganti Password</a></DIV>";
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
						require("pendataan/J1D01.php");
						require("pendataan/J1D02.php");
						require("pendataan/J1D03.php");
						require("pendataan/J1D04.php");
						require("pendataan/J1D05.php");
						require("laporan/J5L01.php");
						require("laporan/J5L02.php");
						require("laporan/J5L03.php");
						require("laporan/J5L04.php");
						require("laporan/J5L05.php");
						require("Utility/J6U01.php");
						require("Utility/J6U02.php");
						require("Utility/J6U03.php");

						$J1D01class		=new J1D01class;
						$J1D02class 	=new J1D02class;
						$J1D03class 	=new J1D03class;
						$J1D04class 	=new J1D04class;
						$J1D05class 	=new J1D05class;
						$J5L01class 	=new J5L01class;
						$J5L02class 	=new J5L02class;
						$J5L03class 	=new J5L03class;
						$J5L04class 	=new J5L04class;
						$J5L05class 	=new J5L05class;
						$J6U01class 	=new J6U01class;
						$J6U02class 	=new J6U02class;
						$J6U03class 	=new J6U03class;

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
							<meta http-equiv=\"refresh\" content=\"1;url=penjualan.php?logout\">\n";
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
    						case "J1D01";
								if (hakakses("J1D01")==1) $J1D01class->J1D01();
								else errordata();
    							break;
							case "J1D01_Hapus";
								if (hakakses("J1D01H")==1) $J1D01class->J1D01_Hapus();
								else errordata();
    							break;	
							case "J1D01_Cari";
								if (hakakses("J1D01")==1) $J1D01class->J1D01_Cari();
								else errordata();
    							break;
    						case "J1D01_Save";
								if (hakakses("J1D01")==1) $J1D01class->J1D01_Save();
								else errordata();
    							break;

							// -------------------------------------------------- Jenis Keluar Uang --------------------------------------------------
    						case "J1D02";
								if (hakakses("J1D02")==1) $J1D02class->J1D02();
								else errordata();
    							break;
							case "J1D02_Hapus";
								if (hakakses("J1D02H")==1) $J1D02class->J1D02_Hapus();
								else errordata();
    							break;	
							case "J1D02_Cari";
								if (hakakses("J1D02")==1) $J1D02class->J1D02_Cari();
								else errordata();
    							break;
    						case "J1D02_Save";
								if (hakakses("J1D02")==1) $J1D02class->J1D02_Save();
								else errordata();
    							break;

							// -------------------------------------------------- Bukti Terima Uang --------------------------------------------------
    						case "J1D03";
								if (hakakses("J1D03")==1) $J1D03class->J1D03();
								else errordata();
    							break;
							case "J1D03_Hapus";
								if (hakakses("J1D03H")==1) $J1D03class->J1D03_Hapus();
								else errordata();
    							break;	
							case "J1D03_Cari";
								if (hakakses("J1D03")==1) $J1D03class->J1D03_Cari();
								else errordata();
    							break;
    						case "J1D03_Save";
								if (hakakses("J1D03")==1) $J1D03class->J1D03_Save();
								else errordata();
    							break;
    						case "J1D03_Save_Item";
								if (hakakses("J1D03")==1) $J1D03class->J1D03_Save_Item();
								else errordata();
    							break;
							// -------------------------------------------------- Bukti Keluar Uang --------------------------------------------------
    						case "J1D04";
								if (hakakses("J1D04")==1) $J1D04class->J1D04();
								else errordata();
    							break;
							case "J1D04_Hapus";
								if (hakakses("J1D04H")==1) $J1D04class->J1D04_Hapus();
								else errordata();
    							break;	
							case "J1D04_Cari";
								if (hakakses("J1D04")==1) $J1D04class->J1D04_Cari();
								else errordata();
    							break;
    						case "J1D04_Save";
								if (hakakses("J1D04")==1) $J1D04class->J1D04_Save();
								else errordata();
    							break;
    						case "J1D04_Save_Item";
								if (hakakses("J1D04")==1) $J1D04class->J1D04_Save_Item();
								else errordata();
    							break;
							// -------------------------------------------------- Bukti Keluar Uang --------------------------------------------------
    						case "J1D05";
								if (hakakses("J1D05")==1) $J1D05class->J1D05();
								else errordata();
    							break;
							case "J1D05_Hapus";
								if (hakakses("J1D05H")==1) $J1D05class->J1D05_Hapus();
								else errordata();
    							break;	
							case "J1D05_Cari";
								if (hakakses("J1D05")==1) $J1D05class->J1D05_Cari();
								else errordata();
    							break;
    						case "J1D05_Save";
								if (hakakses("J1D05")==1) $J1D05class->J1D05_Save();
								else errordata();
    							break;
    							case "J1D05_Save_Item";
								if (hakakses("J1D05")==1) $J1D05class->J1D05_Save_Item();
								else errordata();
    							break;

							// -------------------------------------------------- Laporan Bukti Terima Kas --------------------------------------------------
							case "J5L01";
								if (hakakses("J5L01")==1) $J5L01class->J5L01();
								else errordata();
    							break;	
								// -------------------------------------------------- Laporan Bukti Keluar Kas --------------------------------------------------
							case "J5L02";
								if (hakakses("J5L02")==1) $J5L02class->J5L02();
								else errordata();
    							break;
                            // -------------------------------------------------- Laporan Harian --------------------------------------------------
							case "J5L03";
								if (hakakses("J5L03")==1) $J5L03class->J5L03();
								else errordata();
    							break;
                            // -------------------------------------------------- Laporan Harian --------------------------------------------------
							case "J5L04";
								if (hakakses("J5L04")==1) $J5L04class->J5L04();
								else errordata();
    							break;
                            // -------------------------------------------------- Laporan Harian --------------------------------------------------
							case "J5L05";
								if (hakakses("J5L05")==1) $J5L05class->J5L05();
								else errordata();
    							break;

                            // -------------------------------------------------- Perbaiki Data --------------------------------------------------
							case "J6U01";
								if (hakakses("J6U01")==1) $J6U01class->J6U01();
								else errordata();
    							break;
							case "J6U01_Perbaiki";
								if (hakakses("J6U01")==1) { $J6U01class->J6U01_Perbaiki();}
								else errordata();
    							break;
							// -------------------------------------------------- Tutup Buku --------------------------------------------------
							case "J6U02";
								if (hakakses("J6U02")==1) $J6U02class->J6U02();
								else errordata();
    							break;
							case "J6U02_Tutup";
								if (hakakses("J6U02")==1) { $J6U02class->J6U02_Tutup();}
								else errordata();
    							break;
                            // -------------------------------------------------- Ganti Password --------------------------------------------------
							case "J6U03_Edit";
								if (hakakses("J6U03")==1) $J6U03class->J6U03_Edit();
								else errordata();
    							break;
    						case "J6U03_Save";
								if (hakakses("J6U03")==1) $J6U03class->J6U03_Save();
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
				<TR><TD WIDTH ='50%' HEIGHT='10' BGCOLOR='#ffffff'><FONT class='adminhead'>Copyright &copy 2012 - SAINT JOHN'S SCHOOL <b>( Periode : $periode )</b></FONT></TD>
					<TD WIDTH ='50%' ALIGN='right'><FONT class='adminhead'>Versi $versi <B>Best viewed with Mozilla Firefox</B></FONT></TD>
				</TR>
			</TABLE>";
		}
	}
	echo"
	</TODY>
</HTML>";
?>
