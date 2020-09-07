<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: keuangan.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Menu Utama KEUANGAN (sistem)
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
	$modul	="KEUANGAN";

	$prd 	=periode($modul);
	$periode 	=prdtotgl($prd);

	if($prd=='')
	{
		echo"
		<SCRIPT TYPE='text/javascript'>
			window.alert('Transaksi KEUANGAN harus di seting dahulu di Administrator')
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
							<DIV class='LeftMenuHead' onclick='clickOpenPage(\"keuangan.php\",\"_top\"); return false;' style='cursor: pointer;'><IMG src='../images/home.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> [ Home ]</DIV>";

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
									if ($row[menu]=='K1D01') echo"<DIV style='cursor: pointer;'><a href='keuangan.php?mode=K1D01_Cari' 	class=ver11>- Jenis Penerimaan</a></DIV>";
									if ($row[menu]=='K1D02') echo"<DIV style='cursor: pointer;'><a href='keuangan.php?mode=K1D02_Cari'	class=ver11>- Jenis Pengeluaran</a></DIV>";
									if ($row[menu]=='K1D03') echo"<DIV style='cursor: pointer;'><a href='keuangan.php?mode=K1D03_Cari'	class=ver11>- Bukti Terima Uang</a></DIV>";
									if ($row[menu]=='K1D04') echo"<DIV style='cursor: pointer;'><a href='keuangan.php?mode=K1D04_Cari'	class=ver11>- Bukti Keluar Uang</a></DIV>";
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
									if ($row[menu]=='K5L01') echo"<DIV style='cursor: pointer;'><a href='keuangan.php?mode=K5L01'	class=ver11>- Bukti Terima Uang</a></DIV>";
									if ($row[menu]=='K5L02') echo"<DIV style='cursor: pointer;'><a href='keuangan.php?mode=K5L02'	class=ver11>- Bukti Keluar Uang</a></DIV>";
									if ($row[menu]=='K5L03') echo"<DIV style='cursor: pointer;'><a href='keuangan.php?mode=K5L03'	class=ver11>- Laporan Harian</a></DIV>";
									if ($row[menu]=='K5L04') echo"<DIV style='cursor: pointer;'><a href='keuangan.php?mode=K5L04'	class=ver11>- Laporan Tunggakan</a></DIV>";
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
									if ($row[menu]=='K6U01') echo"<DIV style='cursor: pointer;'><a href='keuangan.php?mode=K6U01' 		class=ver11>- Seting Uang Sekolah</a></DIV>";
									if ($row[menu]=='K6U02') echo"<DIV style='cursor: pointer;'><a href='keuangan.php?mode=K6U02' 		class=ver11>- Perbaiki Data</a></DIV>";
									if ($row[menu]=='K6U03') echo"<DIV style='cursor: pointer;'><a href='keuangan.php?mode=K6U03' 		class=ver11>- Tutup Buku</a></DIV>";
									if ($row[menu]=='K6U04') echo"<DIV style='cursor: pointer;'><a href='keuangan.php?mode=K6U04_Edit' 	class=ver11>- Ganti Password</a></DIV>";
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
						require("pendataan/K1D01.php");
						require("pendataan/K1D02.php");
						require("pendataan/K1D03.php");
						require("pendataan/K1D04.php");
						require("laporan/K5L01.php");
						require("laporan/K5L02.php");
						require("laporan/K5L03.php");
						require("laporan/K5L04.php");
						require("Utility/K6U01.php");
						require("Utility/K6U02.php");
						require("Utility/K6U03.php");
						require("Utility/K6U04.php");

						$K1D01class	=new K1D01class;
						$K1D02class =new K1D02class;
						$K1D03class =new K1D03class;
						$K1D04class =new K1D04class;
						$K5L01class =new K5L01class;
						$K5L02class =new K5L02class;
						$K5L03class =new K5L03class;
						$K5L04class =new K5L04class;
						$K6U01class =new K6U01class;
						$K6U02class =new K6U02class;
						$K6U03class =new K6U03class;
						$K6U04class =new K6U04class;

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
							<meta http-equiv=\"refresh\" content=\"1;url=keuangan.php?logout\">\n";
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

							// -------------------------------------------------- Jenis Terima Uang --------------------------------------------------
    						case "K1D01";
								if (hakakses("K1D01")==1) $K1D01class->K1D01();
								else errordata();
    							break;
							case "K1D01_Hapus";
								if (hakakses("K1D01H")==1) $K1D01class->K1D01_Hapus();
								else errordata();
    							break;	
							case "K1D01_Cari";
								if (hakakses("K1D01")==1) $K1D01class->K1D01_Cari();
								else errordata();
    							break;
    						case "K1D01_Save";
								if (hakakses("K1D01")==1) $K1D01class->K1D01_Save();
								else errordata();
    							break;

							// -------------------------------------------------- Jenis Keluar Uang --------------------------------------------------
    						case "K1D02";
								if (hakakses("K1D02")==1) $K1D02class->K1D02();
								else errordata();
    							break;
							case "K1D02_Hapus";
								if (hakakses("K1D02H")==1) $K1D02class->K1D02_Hapus();
								else errordata();
    							break;	
							case "K1D02_Cari";
								if (hakakses("K1D02")==1) $K1D02class->K1D02_Cari();
								else errordata();
    							break;
    						case "K1D02_Save";
								if (hakakses("K1D02")==1) $K1D02class->K1D02_Save();
								else errordata();
    							break;

							// -------------------------------------------------- Bukti Terima Uang --------------------------------------------------
    						case "K1D03";
								if (hakakses("K1D03")==1) $K1D03class->K1D03();
								else errordata();
    							break;
							case "K1D03_Hapus";
								if (hakakses("K1D03H")==1) $K1D03class->K1D03_Hapus();
								else errordata();
    							break;	
							case "K1D03_Cari";
								if (hakakses("K1D03")==1) $K1D03class->K1D03_Cari();
								else errordata();
    							break;
    						case "K1D03_Save";
								if (hakakses("K1D03")==1) $K1D03class->K1D03_Save();
								else errordata();
    							break;								
    						case "K1D03_Check";
								if (hakakses("K1D03")==1) $K1D03class->K1D03_Check();
								else errordata();
    							break;								

							// -------------------------------------------------- Bukti Keluar Uang --------------------------------------------------
    						case "K1D04";
								if (hakakses("K1D04")==1) $K1D04class->K1D04();
								else errordata();
    							break;
							case "K1D04_Hapus";
								if (hakakses("K1D04H")==1) $K1D04class->K1D04_Hapus();
								else errordata();
    							break;	
							case "K1D04_Cari";
								if (hakakses("K1D04")==1) $K1D04class->K1D04_Cari();
								else errordata();
    							break;
    						case "K1D04_Save";
								if (hakakses("K1D04")==1) $K1D04class->K1D04_Save();
								else errordata();
    							break;

							// -------------------------------------------------- Laporan Bukti Terima Kas --------------------------------------------------
							case "K5L01";
								if (hakakses("K5L01")==1) $K5L01class->K5L01();
								else errordata();
    							break;	
								// -------------------------------------------------- Laporan Bukti Keluar Kas --------------------------------------------------
							case "K5L02";
								if (hakakses("K5L02")==1) $K5L02class->K5L02();
								else errordata();
    							break;
                            // -------------------------------------------------- Laporan Harian --------------------------------------------------
							case "K5L03";
								if (hakakses("K5L03")==1) $K5L03class->K5L03();
								else errordata();
    							break;
                            // -------------------------------------------------- Laporan Tunggakan --------------------------------------------------
							case "K5L04";
								if (hakakses("K5L04")==1) $K5L04class->K5L04();
								else errordata();
    							break;

							// -------------------------------------------------- Seting Uang Sekolah --------------------------------------------------
    						case "K6U01";
								if (hakakses("K6U01")==1) $K6U01class->K6U01();
								else errordata();
    							break;
    						case "K6U01_Save";
								if (hakakses("K6U01")==1) $K6U01class->K6U01_Save();
								else errordata();
    							break;
    						case "K6U01_Save_Seting";
								if (hakakses("K6U01")==1) $K6U01class->K6U01_Save_Seting();
								else errordata();
    							break;
                            // -------------------------------------------------- Perbaiki Data --------------------------------------------------
							case "K6U02";
								if (hakakses("K6U02")==1) $K6U02class->K6U02();
								else errordata();
    							break;
							case "K6U02_Perbaiki";
								if (hakakses("K6U02")==1) { $K6U02class->K6U02_Perbaiki();}
								else errordata();
    							break;
							// -------------------------------------------------- Tutup Buku --------------------------------------------------
							case "K6U03";
								if (hakakses("K6U03")==1) $K6U03class->K6U03();
								else errordata();
    							break;
							case "K6U03_Tutup";
								if (hakakses("K6U03")==1) { $K6U03class->K6U03_Tutup();}
								else errordata();
    							break;
                            // -------------------------------------------------- Ganti Password --------------------------------------------------
							case "K6U04_Edit";
								if (hakakses("K6U04")==1) $K6U04class->K6U04_Edit();
								else errordata();
    							break;
    						case "K6U04_Save";
								if (hakakses("K6U04")==1) $K6U04class->K6U04_Save();
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