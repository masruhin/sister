<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: kurikulum.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Menu Utama TATA USAHA (sistem)
//-----------------------------------------------------------------------------------------------------
require '../fungsi_umum/sysconfig.php';
require FUNGSI_UMUM_DIR . 'koneksi.php';
define("sister", 1);

echo "
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
	SetCookie('didgettingstarted', 1);

	function setDisplayMenu(idName) {
		if (idName == '') {
			// '' is news, AND etc.
			idName = 'o';
		}
		if (idName != null) {
			closeMenuDiv();
			openMenuDiv(idName);
		} else {
			closeMenuDiv();
		}
	}

	function clickOpenMenu(idName) {
		closeMenuDiv();
		openMenuDiv(idName);
	}

	function closeMenuDiv() {
		var aObjDiv = document.getElementsByTagName("Div");
		var numDiv = aObjDiv.length;

		for (i = 0; i < numDiv; i++) {
			var idName = aObjDiv[i].getAttribute("id");

			if (idName) {
				var isMenu = idName.match(/SubCat/i);

				if (isMenu != null) {
					document.getElementById(idName).style.visibility = "hidden";
					document.getElementById(idName).style.position = "absolute";
				}
			}
		}
	}

	function openMenuDiv(idName) {
		document.getElementById('SubCat_' + idName).style.visibility = "visible";
		document.getElementById('SubCat_' + idName).style.position = "static";
	}

	function clickOpenPage(URL, target) {
		window.open(URL, target);
	}
</script>
<?php
require("../fungsi_umum/sysconfig.php");
require FUNGSI_UMUM_DIR . 'clock.php';
require FUNGSI_UMUM_DIR . 'fungsi_admin.php';
require FUNGSI_UMUM_DIR . 'fungsi_periode.php';

$user	= $_SESSION["Admin"]["nmakry"];
$kdekry	= $_SESSION["Admin"]["kdekry"];
$tgl 	= date("j F Y");
$modul	= "KURIKULUM";

$prd 	= periode($modul);

if (!isset($_SESSION['Admin'])) {
	echo "
		Anda harus login dulu.. redirecting\n";

	echo "
		<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
} else {
	if (isset($_GET['logout'])) {
		$username	= $_SESSION["Admin"]["username"];
		unset($_SESSION['Admin']);
		//session_destroy();
		echo "
			Terima kasih.. redirecting\n";

		echo "
			<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
	} else {
		// -------------------------------------------------- Header --------------------------------------------------
		echo "
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
		echo "
						<DIV id='LeftMenu'>
							<DIV class='LeftMenuHead' onclick='clickOpenPage(\"kurikulum.php\",\"_top\"); return false;' style='cursor: pointer;'><IMG src='../images/home.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> [ Home ]</DIV>";

		echo "
							<DIV class='LeftMenuline'></DIV>
							<DIV class='LeftMenuHead' onclick='clickOpenMenu(\"pf\"); return false;' style='cursor: pointer;'><IMG src='../images/pendataan.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> Pendataan</DIV>
							<DIV style='visibility: hidden; position: absolute;' id='SubCat_pf'>";
		$query 	= "	SELECT 		* 
											FROM 		t_akskry 
											WHERE 		userid	='" . mysql_escape_string($_SESSION['Admin']['userid']) . "' AND 
														utama	='1' 
											ORDER BY 	menu";
		$result	= mysql_query($query) or die(mysql_error());

		while ($row	= mysql_fetch_array($result)) {
			if ($row[menu] == 'L1D01') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L1D01_Cari' class=ver11>- Tingkat</a></DIV>";
			if ($row[menu] == 'L1D02') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L1D02_Cari' class=ver11>- Jurusan</a></DIV>";
			if ($row[menu] == 'L1D03') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L1D03_Cari' class=ver11>- Kelompok Kelas</a></DIV>";
			if ($row[menu] == 'L1D04') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L1D04_Cari' class=ver11>- Kelas</a></DIV>";
			if ($row[menu] == 'L1D05') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L1D05_Cari'	class=ver11>- Pelajaran</a></DIV>";
			if ($row[menu] == 'L1D06') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L1D06_Cari'	class=ver11>- Pengajaran</a></DIV>";
			if ($row[menu] == 'L1D07') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L1D07_Cari'	class=ver11>- Bobot Nilai</a></DIV>";
			if ($row[menu] == 'L1D08') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L1D08'	class=ver11>- Minimum Kriteria</a></DIV>";
		}
		echo "
							</DIV>
							<DIV class='LeftMenuline'></DIV>
							<DIV class='LeftMenuHead' onclick='clickOpenMenu(\"m\"); return false;' style='cursor: pointer;'><IMG src='../images/laporan.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> Laporan</DIV>
							<DIV style='visibility: hidden; position: absolute;' id='SubCat_m'>";
		$query 	= "	SELECT 		* 
											FROM 		t_akskry 
											WHERE 		userid	='" . mysql_escape_string($_SESSION['Admin']['userid']) . "' AND 
														utama	='5' 
											ORDER BY 	menu";
		$result = mysql_query($query) or die(mysql_error());

		while ($row = mysql_fetch_array($result)) {
			//if ($row[menu]=='T5L01') echo"<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=T5L01'	class=ver11>- Absensi</a></DIV>";
			//if ($row[menu]=='T5L02') echo"<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=T5L02'	class=ver11>- Kenaikan Kelas</a></DIV>";
		}

		echo "
							</DIV>
							<DIV class='LeftMenuline'></DIV><DIV class='LeftMenuHead' onclick='clickOpenMenu(\"l\"); return false;' style='cursor: pointer;'><IMG src='../images/utility.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> Utility</DIV>
							<DIV style='visibility: hidden; position: absolute;' id='SubCat_l'>";
		$query 	= "	SELECT 		* 
											FROM 		t_akskry 
											WHERE 		userid='" . mysql_escape_string($_SESSION['Admin']['userid']) . "' AND 
														utama='6'
											ORDER BY 	menu ";
		$result = mysql_query($query) or die(mysql_error());

		while ($row = mysql_fetch_array($result)) {
			if ($row[menu] == 'L6U01') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L6U01' 			class=ver11>- Seting Tahun Pelajaran</a></DIV>";
			if ($row[menu] == 'L6U01TK') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L6U01TK' 			class=ver11>- Seting Tahun Pelajaran TK</a></DIV>";
			if ($row[menu] == 'L6U01SD') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L6U01SD' 			class=ver11>- Seting Tahun Pelajaran SD</a></DIV>";
			if ($row[menu] == 'L6U01SMP') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L6U01SMP' 		class=ver11>- Seting Tahun Pelajaran SMP</a></DIV>";
			if ($row[menu] == 'L6U01SMA') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L6U01SMA' 			class=ver11>- Seting Tahun Pelajaran SMA</a></DIV>";
			if ($row[menu] == 'L6U03') echo "<DIV style='cursor: pointer;'><a href='kurikulum.php?mode=L6U03_Edit' 	class=ver11>- Ganti Password</a></DIV>";
		}

		echo "
							</DIV>
							<DIV class='LeftMenuline'></DIV>
							<DIV class='LeftMenuHead' onclick='clickOpenPage(\"../index.php\",\"_top\"); return false;' style='cursor: pointer;'><IMG src='../images/logout.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> [ Logout ]</DIV>
						</DIV>";

		echo "
						</TD>";
		// -------------------------------------------------- akhir menu --------------------------------------------------
		echo "	
						<TD VALIGN=top>";

		// -------------------------------------------------- tengah --------------------------------------------------
		require("pendataan/L1D01.php");
		require("pendataan/L1D02.php");
		require("pendataan/L1D03.php");
		require("pendataan/L1D04.php");
		require("pendataan/L1D05.php");
		require("pendataan/L1D06.php");
		require("pendataan/L1D07.php");
		require("pendataan/L1D08.php");
		//require("laporan/T5L01.php");
		//require("laporan/T5L02.php");
		require("Utility/L6U01.php");
		require("Utility/L6U01TK.php");
		require("Utility/L6U01SD.php");
		require("Utility/L6U01SMP.php");
		require("Utility/L6U01SMA.php");
		require("Utility/L6U03.php");

		$L1D01class	= new L1D01class;
		$L1D02class	= new L1D02class;
		$L1D03class	= new L1D03class;
		$L1D04class = new L1D04class;
		$L1D05class = new L1D05class;
		$L1D06class = new L1D06class;
		$L1D07class = new L1D07class;
		$L1D08class = new L1D08class;
		//$T5L01class =new T5L01class;
		//$T5L02class =new T5L02class;
		$L6U01class = new L6U01class;
		$L6U01TKclass = new L6U01TKclass;
		$L6U01SDclass = new L6U01SDclass;
		$L6U01SMPclass = new L6U01SMPclass;
		$L6U01SMAclass = new L6U01SMAclass;
		$L6U03class = new L6U03class;

		if (login_check() == false) {
			echo "
							<CENTER><DIV class='display_red'>
							<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0>
								<TR><TD COLSPAN=2><CENTER>.: Konfirmasi :.</CENTER></TD></TR>
    							<TR><TD ><IMG src='login.png' ALIGN=left HEIGHT=60 WIDTH=60></TD>
									<TD>Jika tidak ada kegiatan sama sekali, Anda akan logout secara otomatis</TD>
								</TR>
							</TABLE>
 							</DIV></CENTER>";

			echo "
							<script src='#' onload='alert(\"Jika tidak ada kegiatan sama sekali, Anda akan logout secara otomatis\")'></script>";

			echo "
							<meta http-equiv=\"refresh\" content=\"1;url=kurikulum.php?logout\">\n";
		}

		if (isset($_GET['mode']))
			$mode = $_GET['mode'];
		else
			$mode = $_POST['mode'];

		switch ($mode) {
			default:
				admin();
				break;

				// -------------------------------------------------- Tingkat --------------------------------------------------
			case "L1D01";
				if (hakakses("L1D01") == 1) $L1D01class->L1D01();
				else errordata();
				break;
			case "L1D01_Hapus";
				if (hakakses("L1D01H") == 1) $L1D01class->L1D01_Hapus();
				else errordata();
				break;
			case "L1D01_Cari";
				if (hakakses("L1D01") == 1) $L1D01class->L1D01_Cari();
				else errordata();
				break;
			case "L1D01_Save";
				if (hakakses("L1D01") == 1) $L1D01class->L1D01_Save();
				else errordata();
				break;
			case "L1D01_Personil";
				if (hakakses("L1D01") == 1) $L1D01class->L1D01_Personil();
				else errordata();
				break;
			case "L1D01_Save_Personil";
				if (hakakses("L1D01") == 1) $L1D01class->L1D01_Save_Personil();
				else errordata();
				break;
			case "L1D01_Save_Personil_Semua";
				if (hakakses("L1D01") == 1) $L1D01class->L1D01_Save_Personil_Semua();
				else errordata();
				break;
			case "L1D01_Save_Edit_Personil";
				if (hakakses("L1D01") == 1) $L1D01class->L1D01_Save_Edit_Personil();
				else errordata();
				break;
			case "L1D01_Hapus_Personil";
				if (hakakses("L1D01") == 1) $L1D01class->L1D01_Hapus_Personil();
				else errordata();
				break;
			case "L1D01_Hapus_Personil_Semua";
				if (hakakses("L1D01") == 1) $L1D01class->L1D01_Hapus_Personil_Semua();
				else errordata();
				break;

				// -------------------------------------------------- Kelas --------------------------------------------------
			case "L1D02";
				if (hakakses("L1D02") == 1) $L1D02class->L1D02();
				else errordata();
				break;
			case "L1D02_Hapus";
				if (hakakses("L1D02H") == 1) $L1D02class->L1D02_Hapus();
				else errordata();
				break;
			case "L1D02_Cari";
				if (hakakses("L1D02") == 1) $L1D02class->L1D02_Cari();
				else errordata();
				break;
			case "L1D02_Save";
				if (hakakses("L1D02") == 1) $L1D02class->L1D02_Save();
				else errordata();
				break;

				// -------------------------------------------------- Kelompok Kelas --------------------------------------------------
			case "L1D03";
				if (hakakses("L1D03") == 1) $L1D03class->L1D03();
				else errordata();
				break;
			case "L1D03_Hapus";
				if (hakakses("L1D03H") == 1) $L1D03class->L1D03_Hapus();
				else errordata();
				break;
			case "L1D03_Cari";
				if (hakakses("L1D03") == 1) $L1D03class->L1D03_Cari();
				else errordata();
				break;
			case "L1D03_Save";
				if (hakakses("L1D03") == 1) $L1D03class->L1D03_Save();
				else errordata();
				break;

				// -------------------------------------------------- Pelajaran --------------------------------------------------
			case "L1D04";
				if (hakakses("L1D04") == 1) $L1D04class->L1D04();
				else errordata();
				break;
			case "L1D04_Hapus";
				if (hakakses("L1D04H") == 1) $L1D04class->L1D04_Hapus();
				else errordata();
				break;
			case "L1D04_Cari";
				if (hakakses("L1D04") == 1) $L1D04class->L1D04_Cari();
				else errordata();
				break;
			case "L1D04_Save";
				if (hakakses("L1D04") == 1) $L1D04class->L1D04_Save();
				else errordata();
				break;
			case "L1D04_Pelajaran";
				if (hakakses("L1D04") == 1) $L1D04class->L1D04_Pelajaran();
				else errordata();
				break;
			case "L1D04_Save_Pelajaran";
				if (hakakses("L1D04") == 1) $L1D04class->L1D04_Save_Pelajaran();
				else errordata();
				break;

				// -------------------------------------------------- Siswa --------------------------------------------------
			case "L1D05";
				if (hakakses("L1D05") == 1) $L1D05class->L1D05();
				else errordata();
				break;
			case "L1D05_Hapus";
				if (hakakses("L1D05H") == 1) $L1D05class->L1D05_Hapus();
				else errordata();
				break;
			case "L1D05_Cari";
				if (hakakses("L1D05") == 1) $L1D05class->L1D05_Cari();
				else errordata();
				break;
			case "L1D05_Save";
				if (hakakses("L1D05") == 1) $L1D05class->L1D05_Save();
				else errordata();
				break;
			case "L1D05_Silabus";
				if (hakakses("L1D05") == 1) $L1D05class->L1D05_Silabus();
				else errordata();
				break;
			case "L1D05_Save_Silabus";
				if (hakakses("L1D05") == 1) $L1D05class->L1D05_Save_Silabus();
				else errordata();
				break;
			case "L1D05_isidata";
				if (hakakses("L1D05") == 1) $L1D05class->L1D05_isidata();
				else errordata();
				break;
			case "L1D05_Extra";
				if (hakakses("L1D05T") == 1) $L1D05class->L1D05_Extra();
				else errordata();
				break;

				// -------------------------------------------------- Guru --------------------------------------------------
			case "L1D06";
				if (hakakses("L1D06") == 1) $L1D06class->L1D06();
				else errordata();
				break;
			case "L1D06_Hapus";
				if (hakakses("L1D06H") == 1) $L1D06class->L1D06_Hapus();
				else errordata();
				break;
			case "L1D06_Cari";
				if (hakakses("L1D06") == 1) $L1D06class->L1D06_Cari();
				else errordata();
				break;
			case "L1D06_Save";
				if (hakakses("L1D06") == 1) $L1D06class->L1D06_Save();
				else errordata();
				break;
			case "L1D06_CetakL1";
				if (hakakses("L1D06") == 1) $L1D06class->L1D06_CetakL1();
				else errordata();
				break;
			case "L1D06_CetakL2";
				if (hakakses("L1D06") == 1) $L1D06class->L1D06_CetakL2();
				else errordata();
				break;
			case "L1D06_CetakL3";
				if (hakakses("L1D06") == 1) $L1D06class->L1D06_CetakL3();
				else errordata();
				break;

				// -------------------------------------------------- Bobot Nilai --------------------------------------------------
			case "L1D07";
				if (hakakses("L1D07") == 1) $L1D07class->L1D07();
				else errordata();
				break;
			case "L1D07_Cari";
				if (hakakses("L1D07") == 1) $L1D07class->L1D07_Cari();
				else errordata();
				break;
			case "L1D07_Save";
				if (hakakses("L1D07") == 1) $L1D07class->L1D07_Save();
				else errordata();
				break;
				// -------------------------------------------------- Kriteria --------------------------------------------------
			case "L1D08";
				if (hakakses("L1D08") == 1) $L1D08class->L1D08();
				else errordata();
				break;
			case "L1D08_Save";
				if (hakakses("L1D08") == 1) $L1D08class->L1D08_Save();
				else errordata();
				break;
				// -------------------------------------------------- Laporan Bukti Terima Kas --------------------------------------------------
			case "T5L01";
				if (hakakses("T5L01") == 1) $T5L01class->T5L01();
				else errordata();
				break;
				// -------------------------------------------------- Laporan Bukti Keluar Kas --------------------------------------------------
			case "T5L02";
				if (hakakses("T5L02") == 1) $T5L02class->T5L02();
				else errordata();
				break;
				// -------------------------------------------------- Laporan Buku Kas --------------------------------------------------
			case "T5L03";
				if (hakakses("T5L03") == 1) $T5L03class->T5L03();
				else errordata();
				break;
				// -------------------------------------------------- Set Perpustakaan --------------------------------------------------
			case "L6U01";
				if (hakakses("L6U01") == 1) $L6U01class->L6U01();
				else errordata();
				break;
			case "L6U01_Save";
				if (hakakses("L6U01") == 1) $L6U01class->L6U01_Save();
				else errordata();
				break;



				// -------------------------------------------------- Set TK --------------------------------------------------
			case "L6U01TK";
				if (hakakses("L6U01TK") == 1) $L6U01TKclass->L6U01TK();
				else errordata();
				break;
			case "L6U01TK_Save";
				if (hakakses("L6U01TK") == 1) $L6U01TKclass->L6U01TK_Save();
				else errordata();
				break;
				// -------------------------------------------------- Set SD --------------------------------------------------
			case "L6U01SD";
				if (hakakses("L6U01SD") == 1) $L6U01SDclass->L6U01SD();
				else errordata();
				break;
			case "L6U01SD_Save";
				if (hakakses("L6U01SD") == 1) $L6U01SDclass->L6U01SD_Save();
				else errordata();
				break;
				// -------------------------------------------------- Set SMP --------------------------------------------------
			case "L6U01SMP";
				if (hakakses("L6U01SMP") == 1) $L6U01SMPclass->L6U01SMP();
				else errordata();
				break;
			case "L6U01SMP_Save";
				if (hakakses("L6U01SMP") == 1) $L6U01SMPclass->L6U01SMP_Save();
				else errordata();
				break;
				// -------------------------------------------------- Set Sma --------------------------------------------------
			case "L6U01SMA";
				if (hakakses("L6U01SMA") == 1) $L6U01SMAclass->L6U01SMA();
				else errordata();
				break;
			case "L6U01SMA_Save";
				if (hakakses("L6U01SMA") == 1) $L6U01SMAclass->L6U01SMA_Save();
				else errordata();
				break;



				// -------------------------------------------------- Ganti Password --------------------------------------------------
			case "L6U03_Edit";
				if (hakakses("L6U03") == 1) $L6U03class->L6U03_Edit();
				else errordata();
				break;
			case "L6U03_Save";
				if (hakakses("L6U03") == 1) $L6U03class->L6U03_Save();
				else errordata();
				break;
				// ----------------------------------------------------------------------------------------------------
		}
		// -------------------------------------------------- tutup --------------------------------------------------
		echo "
						</TD>
					</TR>
				</TABLE>
			</TABLE>";

		echo "
			<TABLE WIDTH='100%' ALIGN='CENTER' BORDER=0 BORDERCOLOR='#ffffff' CELLSPACING=0 CELLPADDING=0>	
				<TR><TD COLSPAN=2><IMG src='../images/bawah_admin.jpg' HEIGHT=2 WIDTH='100%'></TD></TR>
				<TR><TD WIDTH ='50%' HEIGHT='10' BGCOLOR='#ffffff'><FONT class='adminhead'>Copyright &copy 2012 - SAINT JOHN'S SCHOOL</FONT></TD>
					<TD WIDTH ='50%' ALIGN='right'><FONT class='adminhead'>Versi $versi <B>Best viewed with Mozilla Firefox</B></FONT></TD>
				</TR>
			</TABLE>";
	}
}
echo "
	</TODY>
</HTML>";
?>