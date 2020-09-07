<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: siswa.php
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
		<TITLE>$nama_pt</TITLE>
		<link href='./../css/dropdown/dropdown.limited.css' media='screen' rel='stylesheet' type='text/css' />
<link href='./../css/dropdown/themes/default.css' media='screen' rel='stylesheet' type='text/css' />

		<LINK rel='stylesheet' type='text/css' href='../css/styleutama.css'>
        <meta http-equiv='content-type' content='text/html; charset=UTF-8' />
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
	
	$user	=$_SESSION["Admin"]["nmassw"];
	$induk	=$_SESSION["Admin"]["nis"];
	$kelas	=$_SESSION["Admin"]["kdekls"];
	$tgl 	=date("j F Y");
	$modul	="SISWA";

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
			$username	=$_SESSION["Admin"]["nis"];

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
				<TR><TD ALIGN='left' 	WIDTH='50' HEIGHT='20'	BGCOLOR='#fcc012'><B>&nbsp&nbsp&nbsp$modul</B></TD>
					<TD ALIGN='right'							BGCOLOR='#fcc012'><FONT class='adminhead'>Selamat Datang <B>$user ( $induk - $kelas )</B> - Tanggal : <B>$tgl</B> - Jam :&nbsp</FONT></TD>
					<TD ALIGN='left' 	WIDTH='60'				BGCOLOR='#fcc012'><FONT class='adminhead'><B>$jam</B></FONT></TD>
				</TR>
			</TABLE>	
			<TABLE ALIGN=CENTER WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>	
				<TR><TD WIDTH='500'><IMG src='../images/atas_admin_kiri.jpg' HEIGHT='100' WIDTH='500'></TD>
					<TD WIDTH='50%' HEIGHT='100' BGCOLOR='#1F437F'></TD>
					<TD WIDTH='300'><IMG src='../images/atas_admin_kanan.jpg' HEIGHT='100' WIDTH='300'></TD>
				</TR>
			</TABLE>	
			<TABLE ALIGN=CENTER	WIDTH='100%' BORDER='0' CELLPADDING='0' CELLSPACING='0'>
				<TR BGCOLOR='#E6E7E9' HEIGHT='20'>";

					// -------------------------------------------------- Menu --------------------------------------------------
					echo"
					<TD WIDTH='96%' ALIGN='left' onclick='clickOpenMenu(\"pf\"); return false;' style='cursor: pointer;'>
					<ul id='nav' class='dropdown dropdown-horizontal'>
					<li><a href='siswa.php'><IMG src='../images/home.png' WIDTH='10' ALIGN='absmiddle'>&nbspHome</a></li>
					<li><span class='dir'>Pelajaran</span>
						<ul>
							<li><a href='siswa.php?mode=S1D01A'>Materi</a></li>
							<li><a href='siswa.php?mode=S1D01B'>Tugas</a></li>
						</ul>
					</li>


					<li><a href='siswa.php?mode=S1D02'>Hasil Test</a></li>
					<li><a href='siswa.php?mode=S1D03'>Kehadiran</a></li>
					<li><span class='dir'>Informasi</span>
						<ul>
							<li><a href='siswa.php?mode=S1D04A'>Silabus</a></li>
							<li><a href='siswa.php?mode=S1D04B'>Jadwal Pelajaran</a></li>
							<li><a href='siswa.php?mode=S1D04C'>Peminjaman Buku</a></li>
							<li><a href='siswa.php?mode=S1D04D'>Pembayaran</a></li>
							<li><a href='siswa.php?mode=S1D04E'>Lain-lain</a></li>
						</ul>
					</li>
					<li><a href='siswa.php?mode=S1D05_Cari'>Konsultasi siswa</a></li>
					<li><a href='siswa.php?mode=S6U01'>Ganti Password</a></li>
					<li><a href='../guru/index.php'>Logout</a></li> 
					</ul>
					</TD>
					<TD ALIGN='left'><a href='siswa.php?mode=S1D00'>Profile</a></TD>
				</TR>
			</TABLE>
			<TABLE ALIGN=CENTER	WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>";
						
				// -------------------------------------------------- akhir menu --------------------------------------------------
				echo
				"<TR><TD VALIGN=top>";

					// -------------------------------------------------- tengah --------------------------------------------------
					require("pendataan/S1D01A.php");
					require("pendataan/S1D01B.php");
					require("pendataan/S1D02.php");
					require("pendataan/S1D03.php");
				    require("pendataan/S1D04A.php");
                    require("pendataan/S1D04B.php");
                    require("pendataan/S1D04C.php");
                    require("pendataan/S1D04D.php");
					require("pendataan/S6U01.php");
					require("pendataan/S1D00.php");

					$S1D01Aclass 	=new S1D01Aclass;
					$S1D01Bclass 	=new S1D01Bclass;
					$S1D02class	    =new S1D02class;
					$S1D03class 	=new S1D03class;
					$S1D04Aclass 	=new S1D04Aclass;
                    $S1D04Bclass 	=new S1D04Bclass;
                    $S1D04Cclass 	=new S1D04Cclass;
                    $S1D04Dclass 	=new S1D04Dclass;
					$S6U01class 	=new S6U01class;
					$S1D00class 	=new S1D00class;

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
						<meta http-equiv=\"refresh\" content=\"1;url=siswa.php?logout\">\n";
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

						// -------------------------------------------------- Kehadiran --------------------------------------------------
   						case "S1D02";
							$S1D02class->S1D02();
   							break;

                        // -------------------------------------------------- Informasi Hasil Test --------------------------------------------------
    					case "S1D03";
						    $S1D03class->S1D03();
							break;

                        // -------------------------------------------------- Modul Pelajaran --------------------------------------------------
   						case "S1D01A";
							$S1D01Aclass->S1D01A();
   							break;

                        // -------------------------------------------------- Modul Pelajaran --------------------------------------------------
   						case "S1D01B";
							$S1D01Bclass->S1D01B();
   							break;
							
                        // -------------------------------------------------- pengumuman --------------------------------------------------
   						case "S1D04A";
							$S1D04Aclass->S1D04A();
   							break;
                        case "S1D04B";
							$S1D04Bclass->S1D04B();
   							break;
                        case "S1D04C";
							$S1D04Cclass->S1D04C();
   							break;
                        case "S1D04D";
							$S1D04Dclass->S1D04D();
   							break;

                             // -------------------------------------------------- Konsultasi SIswa --------------------------------------------------
   						case "S1D05";
							$S1D05class->S1D05();
   							break;

                        // -------------------------------------------------- Ganti Password --------------------------------------------------
						case "S6U01";
							$S6U01class->S6U01();
    						break;
    					case "S6U01_Save";
							$S6U01class->S6U01_Save();
    						break;
							// -------------------------------------------------- Guru --------------------------------------------------
    						case "S1D00";
								$S1D00class->S1D00();
    							break;
    						case "S1D00_Ayah";
								$S1D00class->S1D00_Ayah();
    							break;
    						case "S1D00_Ibu";
								$S1D00class->S1D00_Ibu();
    							break;
    						case "S1D00_Wali";
								$S1D00class->S1D00_Wali();
    							break;
    						case "S1D00_Saudara";
								$S1D00class->S1D00_Saudara();
    							break;

					}
					// -------------------------------------------------- tutup --------------------------------------------------
					echo"
					</TD>
				</TR>
			</TABLE>";
			
			echo"
			<TABLE WIDTH='100%' ALIGN='CENTER' BORDER=0 BORDERCOLOR='#ffffff' CELLSPACING=0 CELLPADDING=0>
				<TR><TD COLSPAN=2><IMG src='../images/bawah_admin.jpg' HEIGHT=2 WIDTH='100%'></TD></TR>
				<TR><TD WIDTH ='50%' HEIGHT='10' BGCOLOR='#ffffff'><FONT class='adminhead'>Copyright &copy 2012 - $nama_pt</FONT></TD>
					<TD WIDTH ='50%' ALIGN='right'><FONT class='adminhead'>Versi $versi <B>Best viewed with Mozilla Firefox</B></FONT></TD>
			</TABLE>";
		}
	}
	echo"
	</TODY>
</HTML>";
?>