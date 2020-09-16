<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: guru.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Menu Utama penjualan (sistem)
//-----------------------------------------------------------------------------------------------------
require '../fungsi_umum/sysconfig.php';
require FUNGSI_UMUM_DIR . 'koneksi.php';
define("sister", 1);

echo "
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
<HTML>
	<HEAD>
		<TITLE>SAINT JOHN'S SCHOOL</TITLE>
<link href='./../css/dropdown/dropdown.limited.css' media='screen' rel='stylesheet' type='text/css' />
<link href='./../css/dropdown/themes/default.css' media='screen' rel='stylesheet' type='text/css' />

		<LINK rel='stylesheet' type='text/css' href='../css/styleutama.css'>
        <meta http-equiv='content-type' content='text/html; charset=UTF-8' />
		<link href='../images/jps.ico' rel='icon' type='image/x-icon'/>
		<meta http-equiv='Content-Type' content='application/json' />
	</HEAD>
	
	<BODY TOPMARGIN=0 LEFTMARGIN=0 RIGHTMARGIN=0 background=''>";

require("../fungsi_umum/sysconfig.php");
require FUNGSI_UMUM_DIR . 'clock.php';
require FUNGSI_UMUM_DIR . 'fungsi_admin.php';
require FUNGSI_UMUM_DIR . 'fungsi_periode.php';

$user	= $_SESSION["Admin"]["nmakry"];
$kdekry	= $_SESSION["Admin"]["kdekry"];
$tgl 	= date("j F Y");
$modul	= "GURU";
$thn	= 'Tahun Ajaran';
$sms	= 'Semester';
$trm	= 'Term';
$midtrm	= 'Mid Term';

$query 	= mysql_query("	SELECT 		t_setthn.* 
							FROM 		t_setthn
							WHERE		t_setthn.set='$thn'");
$data = mysql_fetch_array($query);
$nlithn = $data[nli];

$query 	= mysql_query("	SELECT 		t_setthn.* 
							FROM 		t_setthn
							WHERE		t_setthn.set='$sms'");
$data = mysql_fetch_array($query);
$nlisms = $data[nli];

$query 	= mysql_query("	SELECT 		t_setthn.* 
							FROM 		t_setthn
							WHERE		t_setthn.set='$trm'");
$data = mysql_fetch_array($query);
$nlitrm = $data[nli];

$query 	= mysql_query("	SELECT 		t_setthn.* 
							FROM 		t_setthn
							WHERE		t_setthn.set='$midtrm'");
$data = mysql_fetch_array($query);
$nlimidtrm = $data[nli];

if ($nlithn == '' or $nlisms == '' or $nlitrm == '' or $nlimidtrm == '') {
	echo "
		<SCRIPT TYPE='text/javascript'>
			window.alert('Tahun Ajaran / Semester belum di seting bagian Kurikulum')
		</SCRIPT>";

	echo "
		<meta http-equiv='refresh' content='0; url=index.php'>\n";
}
/*
	$mail='';
	$query 	=mysql_query("	SELECT 		 g_trmeml.* 
							FROM 		 g_trmeml
							WHERE		 g_trmeml.utk='$kdekry'	AND
										 g_trmeml.stt=''");
	$data = mysql_fetch_array($query);
	if($data[utk]!='')
		$mail=' (You have new mail...)';
*/
if (!isset($_SESSION['Admin'])) {
	echo "
		Anda harus login dulu.. redirecting\n";

	echo "
		<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
} else {
	if (isset($_GET['logout'])) {
		$username	= $_SESSION["Admin"]["nmakry"];
		unset($_SESSION['Admin']);
		//session_destroy();
		echo "
			Terima kasih.. redirecting\n";

		echo "
			<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
	} else {
		$query	= "	SELECT 		t_prstkt.* 
						FROM 		t_prstkt
						WHERE 		t_prstkt.kdekry='$kdekry' 
						ORDER BY 	t_prstkt.kdekry";
		$result	= mysql_query($query);
		$kdejbt = 1000;
		while ($data = mysql_fetch_array($result)) {
			if ($data[kdejbt] < $kdejbt and $data[kdejbt] != '') {
				$kdejbt	= $data[kdejbt];
				$kdetkt	= $data[kdetkt];
			}
			if ($kdejbt == '000') {
				$modul	= "PIMPINAN";
			}
		}
		$modul	= "TEACHER";
		$thn	= 'School year';
		$sms	= 'Semester';
		$trm	= 'Term';
		$midtrm	= 'Mid Term';

		$query	= "	SELECT 		COUNT(*) as hsl
						FROM 		t_mstpng
						WHERE 		t_mstpng.kdegru='$kdekry'";
		$hsl	= mysql_query($query);
		$hsl 	= mysql_fetch_assoc($hsl);
		$hsl 	= $hsl['hsl'];
		// -------------------------------------------------- Header --------------------------------------------------
		echo "
			<TABLE ALIGN=CENTER WIDTH='100%' BORDER='0' BORDERCOLOR='#R1D04FR1D04F' CELLPADDING='0' CELLSPACING='0'>
				<TR><TD ALIGN='left' 	WIDTH='500' HEIGHT='20'	BGCOLOR='#fcc012'><FONT class='adminhead'><B>&nbsp&nbsp&nbsp$modul</B> - $thn <B>$nlithn</B> - $sms <B>$nlisms-$nlimidtrm</B></TD>	<!--			 - $trm <B>$nlitrm</B></TD>				-->
					<TD ALIGN='right'							BGCOLOR='#fcc012'><FONT class='adminhead'>Welcome <B>$user</B> - Date : <B>$tgl</B>&nbsp-&nbsp</FONT></TD>
					<TD ALIGN='left' 	WIDTH='60'				BGCOLOR='#fcc012'><FONT class='adminhead'><B>$jam</B></FONT></TD>
				</TR>
			</TABLE>	
			<TABLE ALIGN=CENTER WIDTH='100%' BORDER='0' BORDERCOLOR='#R1D04FR1D04F' CELLPADDING='0' CELLSPACING='0'>	
				<TR><TD WIDTH='500'><IMG src='../images/atas_admin_kiri.jpg' HEIGHT='100' WIDTH='500'></TD>
					<TD WIDTH='50%' HEIGHT='100' BGCOLOR='#1F437F'></TD>
					<TD WIDTH='300'><IMG src='../images/atas_admin_kanan.jpg' HEIGHT='100' WIDTH='300'></TD>
				</TR>
			</TABLE>	
			<TABLE ALIGN=CENTER	WIDTH='100%' BORDER='0' CELLPADDING='0' CELLSPACING='0'>
				<TR BGCOLOR='#E6E7E9' HEIGHT='20'>";

		// -------------------------------------------------- Menu --------------------------------------------------
		echo "
					<TD ALIGN='left' onclick='clickOpenMenu(\"pf\"); return false;' style='cursor: pointer;'>
					<ul id='nav' class='dropdown dropdown-horizontal'>
						<li><a href='guru.php'><IMG src='../images/home.png' WIDTH='10' ALIGN='absmiddle'>&nbspHome</a></li>";



		echo "<li>";

		echo "<span class='dir'>Upload</span>";

		echo "<ul>";

		//
		echo "<li><a href='guru.php?mode=R1D01H&pilihan=tambah_general'>Silabus</a></li>"; //Curriculum Plan

		//Year Plan
		echo "<li><a href='guru.php?mode=R1D01BS&pilihan=tambah_general'>Year Plan</a></li>";

		//Semester Plan
		echo "<li><a href='guru.php?mode=R1D01Q&pilihan=tambah_general'>Semester Plan</a></li>";

		//
		echo "<li><a href='guru.php?mode=R1D01G&pilihan=tambah_general'>Lesson Plan</a></li>";

		//echo"<li><hr/></li>";

		//Assessment
		echo "<li><a href='guru.php?mode=R1D01E&pilihan=tambah_general'>Assessment</a></li>";

		//Handout
		echo "<li><a href='guru.php?mode=R1D01A&pilihan=tambah_general'>Handout</a></li>";

		echo "</ul>";

		echo "</li>";



		echo "
						<li>";

		if ($kdekry == '100000') {
			echo "<span class='dir'>Report</span>";
			echo "<ul>";
			echo "<li><a href='guru.php?mode=R1D04HPGTK1'>Input Comment (1. Personal, Social, and Emotional Development)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04HPGTK2'>Input Comment (2. Communication, Language and Literacy)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04HPGTK3'>Input Comment (3. Mathematical/Cognitive Development)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04HPGTK4'>Input Comment (4. Creative Development)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04HPGTK5'>Input Comment (5. Physical Development (Gross and Fine Motor Skills))</a></li>";
			echo "<li><a href='guru.php?mode=R1D04XTK_Cari'>Input Learning Record (Pre-K - KG)</a></li>";
			//echo"<li><a href='guru.php?mode=R1D04LPG'>Print Learning Record (Pre-K)</a></li>";// - Pre-K
			echo "<li><a href='guru.php?mode=R1D04LTK'>Print Learning Record (K1)</a></li>"; // - K1
			echo "<li><a href='guru.php?mode=R1D04LTK2'>Print Learning Record (K2)</a></li>"; // - K2

			echo "<hr/>";

			echo "<li><a href='guru.php?mode=R1D04H'>Input Absences (PS)</a></li>"; //Input Absences & Comment

			echo "<li><a href='guru.php?mode=R1D04X_Cari'>Input Grading Sheet (PS)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04R'>Print Grading Sheet (PS)</a></li>";

			echo "<li><a href='guru.php?mode=R1D04LSD'>Print Mid Semester Ledger (PS)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04LSDfnl'>Print Final Semester Ledger (PS)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04OSD'>Print Mid Semester Report (PS)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04PSD'>Print Final Semester Report (PS)</a></li>";



			echo "</ul>";
		}

		//TK
		if ($kdetkt == 'PG' or $kdetkt == 'KG') {

			// Dropdown menu Penilain
			// echo "<span class='dir'>Valuation</span>";
			// echo "<ul>";
			// echo "<li><a href='guru.php?mode=R1D01H&pilihan=tambah_general'>Silabus</a></li>"; //Curriculum Plan
			// echo "<li><a href='guru.php?mode=R1D01BS&pilihan=tambah_general'>Year Plan</a></li>";
			// echo "<li><a href='guru.php?mode=R1D01Q&pilihan=tambah_general'>Semester Plan</a></li>";
			// echo "<li><a href='guru.php?mode=R1D01G&pilihan=tambah_general'>Lesson Plan</a></li>";
			// echo "<li><a href='guru.php?mode=R1D01E&pilihan=tambah_general'>Assessment</a></li>";
			// echo "<li><a href='guru.php?mode=R1D01A&pilihan=tambah_general'>Handout</a></li>";
			// echo "</ul>";
			// echo "</li>";

			// Dropdown menu report
			// echo "<li>";
			echo "<span class='dir'>Report</span>";
			echo "<ul>";
			echo "<li><a href='guru.php?mode=R1D04HPGTK1'>Input Comment (1. Personal, Social, and Emotional Development)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04HPGTK2'>Input Comment (2. Communication, Language and Literacy)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04HPGTK3'>Input Comment (3. Mathematical/Cognitive Development)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04HPGTK4'>Input Comment (4. Creative Development)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04HPGTK5'>Input Comment (5. Physical Development (Gross and Fine Motor Skills))</a></li>";

			echo "<li><a href='guru.php?mode=R1D04XTK_Cari'>Input Learning Record (Pre-K - KG)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04LTK21'>Input Student Progress Report (PG1)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04LTK22'>Print Learning Record (PG1)</a></li>";
			//echo"<li><a href='guru.php?mode=R1D04LPG'>Print Learning Record (Pre-K)</a></li>";// - Pre-K
			echo "<li><a href='guru.php?mode=R1D04LTK'>Print Learning Record (K1)</a></li>"; // - K1
			echo "<li><a href='guru.php?mode=R1D04LTK2'>Print Learning Record (K2)</a></li>"; // - K2

			echo "</ul>";
		}

		//SD
		if ($kdetkt == 'PS') {
			echo "<span class='dir'>Report</span>";
			echo "<ul>";
			echo "<li><a href='guru.php?mode=R1D04H'>Input Absences (PS)</a></li>"; //Input Absences & Comment
			echo "<li><a href='guru.php?mode=R1D04X_Cari'>Input Grading Sheet (PS)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04R'>Print Grading Sheet (PS)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04LSD'>Print Mid Semester Ledger (PS)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04LSDfnl'>Print Final Semester Ledger (PS)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04OSD'>Print Mid Semester Report (PS)</a></li>";
			echo "<li><a href='guru.php?mode=R1D04PSD'>Print Final Semester Report (PS)</a></li>";
			echo "</ul>";
		}

		//SMP
		if ($kdetkt == 'JHS') {
			echo "<span class='dir'>Report</span>";
			echo "<ul>";



			echo "<li>	SMP	</li>";



			echo "</ul>";
		}

		//SMA
		if ($kdetkt == 'SHS') {
			echo "<span class='dir'>Report</span>";
			echo "<ul>";



			echo "<li>	SMA	</li>";



			echo "</ul>";
		}


		echo "</li>";



		if ($kdetkt == 'PS') {
			echo "<li>";

			echo "<span class='dir'>Rapor Diknas</span>";
			echo "<ul>";
			echo "<li><a href='guru.php?mode=R1D11A'>Cetak Rapor Diknas Cover 1 (SD)</a></li>";
			echo "<li><a href='guru.php?mode=R1D11B'>Cetak Rapor Diknas Cover 2 (SD)</a></li>";
			echo "<li><a href='guru.php?mode=R1D11C'>Cetak Rapor Diknas Cover 3 (SD)</a></li>";

			echo "<li><a href='guru.php?mode=R1D11D'>Cetak Rapor Diknas Akademik Pengetahuan (SD)</a></li>";
			echo "<li><a href='guru.php?mode=R1D11E'>Cetak Rapor Diknas Akademik Keterampilan (SD)</a></li>";

			echo "</ul>";

			echo "</li>";
		}



		if ($kdetkt == 'JHS' or $kdetkt == 'SHS') {
			echo "	
							<li><span class='dir'>Comment</span>
								<ul>
									";


			echo "
									<li><a href='guru.php?mode=R1D04HSMP'>Catatan Wali Kelas</a></li>";


			echo "
								</ul>
							</li>";
		}

		echo "	
					<!--	<li><a href='guru.php?mode=R6U01'>Change Password</a></li>	-->
					
					<li><a href='../guru/index.php'>Logout</a></li>	
					</ul>
					</TD>
				</TR>
			</TABLE>
			<TABLE ALIGN=CENTER	WIDTH='100%' BORDER='0' BORDERCOLOR='#R1D04FR1D04F' CELLPADDING='0' CELLSPACING='0'>";

		// -------------------------------------------------- akhir menu --------------------------------------------------
		echo
			"<TR><TD VALIGN=top>";

		// -------------------------------------------------- tengah --------------------------------------------------
		require("pendataan/R1D01A.php");
		require("pendataan/R1D01B.php");
		require("pendataan/R1D01BS.php"); //bank soal sd
		require("pendataan/R1D01C.php");
		require("pendataan/R1D01D.php");
		require("pendataan/R1D01E.php");
		require("pendataan/R1D01F.php");
		require("pendataan/R1D01G.php"); //rpp ps-jhs-shs
		require("pendataan/R1D01GQ1.php"); //rpp ps-jhs-shs Q1
		require("pendataan/R1D01GQ2.php"); //rpp ps-jhs-shs Q2
		require("pendataan/R1D01GQ3.php"); //rpp ps-jhs-shs Q3
		require("pendataan/R1D01GQ4.php");	//rpp ps-jhs-shs Q4
		require("pendataan/R1D01H.php");
		require("pendataan/R1D01H1.php"); //krk semester 1
		require("pendataan/R1D01H2.php"); //krk semester 2
		require("pendataan/R1D01I.php"); //rpp pg-kg
		require("pendataan/R1D01Q.php"); //utq ps
		require("pendataan/R1D02A.php");
		require("pendataan/R1D02B.php");
		require("pendataan/R1D02C.php");
		require("pendataan/R1D02D.php");
		require("pendataan/R1D02E.php");
		require("pendataan/R1D04C.php");
		require("pendataan/R1D04E.php");
		require("pendataan/R1D04F.php");
		//require("pendataan/R1D04FSMP.php");
		//require("pendataan/R1D04FSMPK13.php");
		require("pendataan/R1D04G.php");
		require("pendataan/R1D04H.php");
		require("pendataan/R1D04I.php");
		require("pendataan/R1D04J.php");
		require("pendataan/R1D04K.php");

		require("pendataan/R1D04HACC.php"); //input accomplishment report sd
		require("pendataan/R1D04LACC.php"); //print accomplishment report sd

		require("pendataan/R1D04HINTRVW.php"); //input hasil interview SD

		//require("pendataan/R1D04HSD.php");//Catatan bimbigan koseling BK sd
		require("pendataan/R1D04HSD2.php"); //Catatan bimbigan koseling BK sd 2
		require("pendataan/R1D04HSMP.php"); //CAT wali kelas

		require("pendataan/R1D04HPGTK1.php"); //input comment pgkg 1
		require("pendataan/R1D04HPGTK2.php"); //input comment pgkg 2
		require("pendataan/R1D04HPGTK3.php"); //input comment pgkg 3
		require("pendataan/R1D04HPGTK4.php"); //input comment pgkg 4
		require("pendataan/R1D04HPGTK5.php"); //input comment pgkg 5

		require("pendataan/R1D04HPGTK1_AKR.php"); //input narasi kbtk 1
		require("pendataan/R1D04HPGTK2_AKR.php"); //input narasi kbtk 2
		require("pendataan/R1D04HPGTK3_AKR.php"); //input narasi kbtk 3
		require("pendataan/R1D04HPGTK4_AKR.php"); //input narasi kbtk 4
		require("pendataan/R1D04HPGTK5_AKR.php"); //input narasi kbtk 5
		require("pendataan/R1D04HPGTK6_AKR.php"); //input narasi kbtk 6

		require("pendataan/R1D04L.php");
		require("pendataan/R1D04LSD.php"); // ledger mid term sd
		require("pendataan/R1D04LSDfnl.php"); // ledger final sd
		require("pendataan/R1D04LSMPK13.php"); // ledger mid term smp 7
		require("pendataan/R1D04LSMP.php"); // ledger mid term smp 8-9
		require("pendataan/R1D04LSMAK13.php"); // ledger mid term sma 10 ipa
		require("pendataan/R1D04LSMAK13ips.php"); // ledger mid term sma 10 ips
		require("pendataan/R1D04LSMAG.php"); // ledger mid term sma 11-12 grade
		require("pendataan/R1D04LSMA.php"); // ledger mid term sma 11-12 tpgrade

		require("pendataan/R1D04M.php");
		require("pendataan/R1D04N.php");
		require("pendataan/R1D04O.php");

		require("pendataan/R1D04SDlrcd.php"); // learning record mid term sd

		require("pendataan/R1D04OSD.php"); // rapot mid term sd
		require("pendataan/R1D04OSMP.php"); // rapot mid term smp 7
		require("pendataan/R1D04OSMA.php"); // rapot mid term sma 10 ipa
		require("pendataan/R1D04OSMAips.php"); // rapot mid term sma 10 ips
		require("pendataan/R1D04P.php");

		require("pendataan/R1D04OSDsms.php");	// rapot class performance sd

		require("pendataan/R1D04PSD.php");	// rapot final sd
		require("pendataan/R1D04PSMP.php");	// rapot final smp 8-9
		require("pendataan/R1D04PSMA.php");	// rapot final sma 11 ipa
		require("pendataan/R1D04PSMAips.php");	// rapot final sma 11 ips
		require("pendataan/R1D04PSMA12.php");	// rapot final sma 12 ipa
		require("pendataan/R1D04PSMAips12.php");	// rapot final sma 12 ips
		require("pendataan/R1D04Q.php");

		require("pendataan/R1D04R.php"); // print grading sheet sd
		require("pendataan/R1D04SSMP.php"); // print grading sheet smp 7
		require("pendataan/R1D04S.php"); // print grading sheet smp 8-9
		require("pendataan/R1D04SSMA.php"); // print grading sheet sma 10
		require("pendataan/R1D04T.php"); // print grading sheet sma 11-12 ipa
		require("pendataan/R1D04TSMA.php"); // print grading sheet sma 11-12 ips

		require("pendataan/R1D04A.php");
		require("pendataan/R1D04B.php");
		require("pendataan/R1D04D.php");

		require("pendataan/R1D04LSMP7.php"); // cetak rapot diknas 7
		require("pendataan/R1D04LSMA11.php"); // cetak rapot diknas 11

		require("pendataan/R1D04BISMA.php"); // cetak buku induk siswa sma
		require("pendataan/R1D04BISMA2.php"); // cetak data nilai siswa sma

		//require("pendataan/R1D04LTKS2_C01.php"); // print learning record tk k1 semester 2

		require("pendataan/R1D04LPG.php"); // print learning record pRE-K
		require("pendataan/R1D04LTK.php"); // print learning record tk k1
		require("pendataan/R1D04LTK2.php"); // print learning record tk k2
		require("pendataan/R1D04LPGab.php"); // cetak laporan perkembangan anak pg
		require("pendataan/R1D04LTKaA.php"); // cetak laporan perkembangan anak tka
		require("pendataan/R1D04LTKbB.php"); // cetak laporan perkembangan anak tkb

		require("pendataan/R1D04LSD_BK.php"); // print bimbingan konseling ar sd
		require("pendataan/R1D04LSD_BK2.php"); // print bimbingan konseling sc sd
		require("pendataan/R1D04LINTRVW.php"); // print hasil interview sd

		require("pendataan/R1D04XTK_AKR.php"); // input learning record kb-tk
		require("pendataan/R1D04XTK.php"); // input learning record pg-kg
		require("pendataan/R1D04SD.php"); // input learning record sd
		require("pendataan/R1D04XSD.php"); // input learning record sd v2
		require("pendataan/R1D04X.php"); // input grading sheet sd
		require("pendataan/R1D04Y.php"); // input grading sheet smp 8-9
		require("pendataan/R1D04YSMP.php"); // input grading sheet smp 7
		require("pendataan/R1D04YSMA.php"); // input grading sheet sma 10
		require("pendataan/R1D04Z.php"); // input grading sheet sma 11-12 ipa
		require("pendataan/R1D04ZSMA.php"); // input grading sheet sma 11-12 ips

		require("pendataan/R6U01.php");
		require("pendataan/R6U02.php");



		//AWAL BUATAN BARU
		require("pendataan/R1D04LTK21.php");
		require("pendataan/R1D04LTK22.php");
		require("pendataan/R1D11A.php");
		require("pendataan/R1D11B.php");
		require("pendataan/R1D11C.php");
		require("pendataan/R1D11D.php");
		// require("pendataan/R1D11E.php");
		//AKHIR BUATAN BARU



		$R1D01Aclass 	= new R1D01Aclass;
		$R1D01Bclass	= new R1D01Bclass;
		$R1D01BSclass	= new R1D01BSclass; //upload bank soal sd
		$R1D01Cclass 	= new R1D01Cclass;
		$R1D01Dclass 	= new R1D01Dclass;
		$R1D01Eclass 	= new R1D01Eclass;
		$R1D01Fclass 	= new R1D01Fclass;
		$R1D01Gclass 	= new R1D01Gclass; //upload rpp ps-jhs-sjs
		$R1D01GQ1class 	= new R1D01GQ1class; //upload rpp ps-jhs-sjs Q1
		$R1D01GQ2class 	= new R1D01GQ2class; //upload rpp ps-jhs-sjs Q2
		$R1D01GQ3class 	= new R1D01GQ3class; //upload rpp ps-jhs-sjs Q3
		$R1D01GQ4class 	= new R1D01GQ4class;	//upload rpp ps-jhs-sjs Q4
		$R1D01Hclass 	= new R1D01Hclass;
		$R1D01H1class 	= new R1D01H1class; //krk semester 1
		$R1D01H2class 	= new R1D01H2class; //krk semester 2
		$R1D01Iclass 	= new R1D01Iclass; //upload rpp pg-kg
		$R1D01Qclass 	= new R1D01Qclass; //upload rpp ps-jhs-sjs
		$R1D02Aclass 	= new R1D02Aclass;
		$R1D02Bclass 	= new R1D02Bclass;
		$R1D02Cclass 	= new R1D02Cclass;
		$R1D02Dclass 	= new R1D02Dclass;
		$R1D02Eclass 	= new R1D02Eclass;
		$R1D04Cclass 	= new R1D04Cclass;
		$R1D04Eclass 	= new R1D04Eclass;
		$R1D04Fclass 	= new R1D04Fclass;
		//$R1D04FSMPclass 	=new R1D04FSMPclass;
		//$R1D04FSMPK13class 	=new R1D04FSMPK13class;
		$R1D04Gclass 	= new R1D04Gclass;
		$R1D04Hclass 	= new R1D04Hclass;
		$R1D04Iclass 	= new R1D04Iclass;
		$R1D04Jclass 	= new R1D04Jclass;
		$R1D04Kclass 	= new R1D04Kclass;

		$R1D04HACCclass 	= new R1D04HACCclass; //input accomplishment report sd
		$R1D04LACCclass 	= new R1D04LACCclass; //PRInt accomplishment report sd

		$R1D04HINTRVWclass 	= new R1D04HINTRVWclass; //input hasil interview

		//$R1D04HSDclass 		=new R1D04HSDclass;//cat bk sd
		$R1D04HSD2class 	= new R1D04HSD2class; //cat bk sd 2
		$R1D04HSMPclass 	= new R1D04HSMPclass; //cat wali kelas

		$R1D04HPGTK1class 	= new R1D04HPGTK1class; //input comment pgkg 1
		$R1D04HPGTK2class 	= new R1D04HPGTK2class; //input comment pgkg 2
		$R1D04HPGTK3class 	= new R1D04HPGTK3class; //input comment pgkg 3
		$R1D04HPGTK4class 	= new R1D04HPGTK4class; //input comment pgkg 4
		$R1D04HPGTK5class 	= new R1D04HPGTK5class; //input comment pgkg 5

		$R1D04HPGTK1_AKRclass 	= new R1D04HPGTK1_AKRclass; //input narasi kbtk 1
		$R1D04HPGTK2_AKRclass 	= new R1D04HPGTK2_AKRclass; //input narasi kbtk 2
		$R1D04HPGTK3_AKRclass 	= new R1D04HPGTK3_AKRclass; //input narasi kbtk 3
		$R1D04HPGTK4_AKRclass 	= new R1D04HPGTK4_AKRclass; //input narasi kbtk 4
		$R1D04HPGTK5_AKRclass 	= new R1D04HPGTK5_AKRclass; //input narasi kbtk 5
		$R1D04HPGTK6_AKRclass 	= new R1D04HPGTK6_AKRclass; //input narasi kbtk 6

		$R1D04Lclass 	= new R1D04Lclass;
		$R1D04LSDclass 	= new R1D04LSDclass; // ledger mid term sd 
		$R1D04LSDfnlclass 	= new R1D04LSDfnlclass; // ledger final sd 
		$R1D04LSMPK13class = new R1D04LSMPK13class; // ledger mid term smp 7
		$R1D04LSMPclass 	= new R1D04LSMPclass; // ledger mid term smp 8-9 
		$R1D04LSMAK13class = new R1D04LSMAK13class; // ledger mid term sma 10 ipa
		$R1D04LSMAK13ipsclass = new R1D04LSMAK13ipsclass; // ledger mid term sma 10 ips
		$R1D04LSMAGclass 	= new R1D04LSMAGclass; // ledger mid term sma 11-12 grade 
		$R1D04LSMAclass 	= new R1D04LSMAclass; // ledger mid term sma 11-12 tpgrade 

		$R1D04Mclass 	= new R1D04Mclass;
		$R1D04Nclass 	= new R1D04Nclass;
		$R1D04Oclass 	= new R1D04Oclass;

		$R1D04SDlrcdclass 	= new R1D04SDlrcdclass; // learning record mid term sd 

		$R1D04OSDclass 	= new R1D04OSDclass; // rapot mid term sd 
		$R1D04OSMPclass 	= new R1D04OSMPclass; // rapot mid term SMP 7
		$R1D04OSMAclass 	= new R1D04OSMAclass; // rapot mid term SMA 10 ipa
		$R1D04OSMAipsclass 	= new R1D04OSMAipsclass; // rapot mid term SMA 10 ips
		$R1D04Pclass 	= new R1D04Pclass;

		$R1D04OSDsmsclass 	= new R1D04OSDsmsclass; // rapot class performance sd

		$R1D04PSDclass 	= new R1D04PSDclass; // rapot final sd
		$R1D04PSMPclass 	= new R1D04PSMPclass; // rapot final smp 8-9
		$R1D04PSMAclass 	= new R1D04PSMAclass; // rapot final sma 11 ipa
		$R1D04PSMAipsclass 	= new R1D04PSMAipsclass; // rapot final sma 11 ips
		$R1D04PSMA12class 	= new R1D04PSMA12class; // rapot final sma 12 ipa
		$R1D04PSMAips12class 	= new R1D04PSMAips12class; // rapot final sma 12 ips
		$R1D04Qclass 	= new R1D04Qclass;

		$R1D04Rclass 	= new R1D04Rclass; // print grading sheet sd 
		$R1D04SSMPclass = new R1D04SSMPclass; // print grading sheet smp 7
		$R1D04Sclass 	= new R1D04Sclass; // print grading sheet smp 8-9
		$R1D04SSMAclass = new R1D04SSMAclass; // print grading sheet sma 10
		$R1D04Tclass 	= new R1D04Tclass; // print grading sheet sma 11-12 ipa
		$R1D04TSMAclass 	= new R1D04TSMAclass; // print grading sheet sma 11-12 ips

		$R1D04Aclass 	= new R1D04Aclass;
		$R1D04Bclass 	= new R1D04Bclass;
		$R1D04Dclass 	= new R1D04Dclass;

		$R1D04LSMP7class = new R1D04LSMP7class; // cetak rapot diknas 7
		$R1D04LSMA11class = new R1D04LSMA11class; // cetak rapot diknas 11

		$R1D04BISMAclass = new R1D04BISMAclass; // cetak buku induk siswa sma
		$R1D04BISMA2class = new R1D04BISMA2class; // cetak Data Nilai siswa sma

		//$R1D04LTKS2_C01class 	=new R1D04LTKS2_C01class; // print LEARNING record tk k1 semester 2

		$R1D04LPGclass 	= new R1D04LPGclass; // print LEARNING record pre-k
		$R1D04LTKclass 	= new R1D04LTKclass; // print LEARNING record tk k1
		$R1D04LTK2class = new R1D04LTK2class; // print LEARNING record tk k2
		$R1D04LPGabclass = new R1D04LPGabclass; // cetak laporan perkembangan anak pg
		$R1D04LTKaAclass = new R1D04LTKaAclass; // cetak laporan perkembangan anak tka
		$R1D04LTKbBclass = new R1D04LTKbBclass; // cetak laporan perkembangan anak tkb

		$R1D04LSD_BKclass 	= new R1D04LSD_BKclass; // print bimbingan koseling ar sd
		$R1D04LSD_BK2class 	= new R1D04LSD_BK2class; // print bimbingan koseling sc sd
		$R1D04LINTRVWclass 	= new R1D04LINTRVWclass; // print hasil interview sd

		$R1D04XTK_AKRclass 	= new R1D04XTK_AKRclass; // input LEARNING record kb-tk
		$R1D04XTKclass 	= new R1D04XTKclass; // input LEARNING record pg-KG
		$R1D04SDclass 	= new R1D04SDclass; // input LEARNING record sd 
		$R1D04XSDclass 	= new R1D04XSDclass; // input LEARNING record sd v2
		$R1D04Xclass 	= new R1D04Xclass; // input grading sheet sd 
		$R1D04Yclass 	= new R1D04Yclass; // input grading sheet smp 8-9
		$R1D04YSMPclass 	= new R1D04YSMPclass; // input grading sheet smp 7
		$R1D04YSMAclass 	= new R1D04YSMAclass; // input grading sheet sma 10
		$R1D04Zclass 	= new R1D04Zclass; // input grading sheet sma 11-12 ipa
		$R1D04ZSMAclass 	= new R1D04ZSMAclass; // input grading sheet sma 11-12 ips

		$R6U01class 	= new R6U01class;
		$R6U02class 	= new R6U02class;



		//AWAL BUATAN BARU
		$R1D04LTK21class 	= new R1D04LTK21class;
		$R1D04LTK22class 	= new R1D04LTK22class;

		$R1D11Aclass 	= new R1D11Aclass;
		$R1D11Bclass 	= new R1D11Bclass;
		$R1D11Cclass 	= new R1D11Cclass;
		$R1D11Dclass 	= new R1D11Dclass;
		// $R1D11Eclass 	= new R1D11Eclass;
		//AKHIR BUATAN BARU



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
						<meta http-equiv=\"refresh\" content=\"1;url=guru.php?logout\">\n";
		}

		if (isset($_GET['mode']))
			$mode = $_GET['mode'];
		else
			$mode = $_POST['mode'];

		switch ($mode) {
			default:
				admin();
				break;

				// -------------------------------------------------- Buat SOal --------------------------------------------------
			case "R1D01B_Soal";
				$R1D01Bclass->R1D01B_Soal();
				break;
			case "R1D01B_Hapus";
				$R1D01Bclass->R1D01B_Hapus();
				break;
			case "R1D01B_Cari";
				$R1D01Bclass->R1D01B_Cari();
				break;
			case "R1D01B_Save";
				$R1D01Bclass->R1D01B_Save();
				break;
			case "R1D01B_Transfer";
				$R1D01Bclass->R1D01B_Transfer();
				break;
			case "R1D01B_Update";
				$R1D01Bclass->R1D01B_Update();
				break;
			case "R1D01B_Save_Item";
				$R1D01Bclass->R1D01B_Save_Item();
				break;
				//                        case "R1D01B_HapusG";
				//                            $R1D01Bclass->R1D01B_HapusG();
				//    					break;

				// -------------------------------------------------- Rencana Ujian --------------------------------------------------
			case "R1D01C";
				$R1D01Cclass->R1D01C();
				break;
			case "R1D01C_Hapus";
				$R1D01Cclass->R1D01C_Hapus();
				break;
			case "R1D01C_Cari";
				$R1D01Cclass->R1D01C_Cari();
				break;
			case "R1D01C_Save";
				$R1D01Cclass->R1D01C_Save();
				break;

				// -------------------------------------------------- Materi Pelajaran --------------------------------------------------
			case "R1D01A";
				$R1D01Aclass->R1D01A();
				break;
			case "R1D01A_Save";
				$R1D01Aclass->R1D01A_Save();
				break;
			case "R1D01A_Save_Item";
				$R1D01Aclass->R1D01A_Save_Item();
				break;
			case "R1D01A_Update";
				$R1D01Aclass->R1D01A_Update();
				break;

				// -------------------------------------------------- Bank Soal --------------------------------------------------
			case "R1D01BS";
				$R1D01BSclass->R1D01BS();
				break;
			case "R1D01BS_Save";
				$R1D01BSclass->R1D01BS_Save();
				break;
			case "R1D01BS_Save_Item";
				$R1D01BSclass->R1D01BS_Save_Item();
				break;
			case "R1D01BS_Update";
				$R1D01BSclass->R1D01BS_Update();
				break;

				// -------------------------------------------------- Lesson Plan ps-jhs-shs --------------------------------------------------
			case "R1D01G";
				$R1D01Gclass->R1D01G();
				break;
			case "R1D01G_Save";
				$R1D01Gclass->R1D01G_Save();
				break;
			case "R1D01G_Save_Item";
				$R1D01Gclass->R1D01G_Save_Item();
				break;
			case "R1D01G_Update";
				$R1D01Gclass->R1D01G_Update();
				break;

				// -------------------------------------------------- Lesson Plan ps-jhs-shs Q1 --------------------------------------------------
			case "R1D01GQ1";
				$R1D01GQ1class->R1D01GQ1();
				break;
			case "R1D01GQ1_Save";
				$R1D01GQ1class->R1D01GQ1_Save();
				break;
			case "R1D01GQ1_Save_Item";
				$R1D01GQ1class->R1D01GQ1_Save_Item();
				break;
			case "R1D01GQ1_Update";
				$R1D01GQ1class->R1D01GQ1_Update();
				break;

				// -------------------------------------------------- Lesson Plan ps-jhs-shs Q2 --------------------------------------------------
			case "R1D01GQ2";
				$R1D01GQ2class->R1D01GQ2();
				break;
			case "R1D01GQ2_Save";
				$R1D01GQ2class->R1D01GQ2_Save();
				break;
			case "R1D01GQ2_Save_Item";
				$R1D01GQ2class->R1D01GQ2_Save_Item();
				break;
			case "R1D01GQ2_Update";
				$R1D01GQ2class->R1D01GQ2_Update();
				break;

				// -------------------------------------------------- Lesson Plan ps-jhs-shs Q3 --------------------------------------------------
			case "R1D01GQ3";
				$R1D01GQ3class->R1D01GQ3();
				break;
			case "R1D01GQ3_Save";
				$R1D01GQ3class->R1D01GQ3_Save();
				break;
			case "R1D01GQ3_Save_Item";
				$R1D01GQ3class->R1D01GQ3_Save_Item();
				break;
			case "R1D01GQ3_Update";
				$R1D01GQ3class->R1D01GQ3_Update();
				break;

				// -------------------------------------------------- Lesson Plan ps-jhs-shs Q4 --------------------------------------------------
			case "R1D01GQ4";
				$R1D01GQ4class->R1D01GQ4();
				break;
			case "R1D01GQ4_Save";
				$R1D01GQ4class->R1D01GQ4_Save();
				break;
			case "R1D01GQ4_Save_Item";
				$R1D01GQ4class->R1D01GQ4_Save_Item();
				break;
			case "R1D01GQ4_Update";
				$R1D01GQ4class->R1D01GQ4_Update();
				break;

				// -------------------------------------------------- Upload test questions ps --------------------------------------------------
			case "R1D01Q";
				$R1D01Qclass->R1D01Q();
				break;
			case "R1D01Q_Save";
				$R1D01Qclass->R1D01Q_Save();
				break;
			case "R1D01Q_Save_Item";
				$R1D01Qclass->R1D01Q_Save_Item();
				break;
			case "R1D01Q_Update";
				$R1D01Qclass->R1D01Q_Update();
				break;

				// -------------------------------------------------- Lesson Plan pg-kg --------------------------------------------------
			case "R1D01I";
				$R1D01Iclass->R1D01I();
				break;
			case "R1D01I_Save";
				$R1D01Iclass->R1D01I_Save();
				break;
			case "R1D01I_Save_Item";
				$R1D01Iclass->R1D01I_Save_Item();
				break;
			case "R1D01I_Update";
				$R1D01Iclass->R1D01I_Update();
				break;

				// -------------------------------------------------- Kurikulum Plan --------------------------------------------------
			case "R1D01H";
				$R1D01Hclass->R1D01H();
				break;
			case "R1D01H_Save";
				$R1D01Hclass->R1D01H_Save();
				break;
			case "R1D01H_Save_Item";
				$R1D01Hclass->R1D01H_Save_Item();
				break;
			case "R1D01H_Update";
				$R1D01Hclass->R1D01H_Update();
				break;

				// -------------------------------------------------- Kurikulum Plan semester 1 --------------------------------------------------
			case "R1D01H1";
				$R1D01H1class->R1D01H1();
				break;
			case "R1D01H1_Save";
				$R1D01H1class->R1D01H1_Save();
				break;
			case "R1D01H1_Save_Item";
				$R1D01H1class->R1D01H1_Save_Item();
				break;
			case "R1D01H1_Update";
				$R1D01H1class->R1D01H1_Update();
				break;

				// -------------------------------------------------- Kurikulum Plan semester 2 --------------------------------------------------
			case "R1D01H2";
				$R1D01H2class->R1D01H2();
				break;
			case "R1D01H2_Save";
				$R1D01H2class->R1D01H2_Save();
				break;
			case "R1D01H2_Save_Item";
				$R1D01H2class->R1D01H2_Save_Item();
				break;
			case "R1D01H2_Update";
				$R1D01H2class->R1D01H2_Update();
				break;

				// -------------------------------------------------- Materi Pelajaran --------------------------------------------------
			case "R1D01D";
				$R1D01Dclass->R1D01D();
				break;
			case "R1D01D_Cari";
				$R1D01Dclass->R1D01D_Cari();
				break;
			case "R1D01D_Save";
				$R1D01Dclass->R1D01D_Save();
				break;
			case "R1D01D_Edit";
				$R1D01Dclass->R1D01D_Edit();
				break;
			case "R1D01D_Update";
				$R1D01Dclass->R1D01D_Update();
				break;
				// -------------------------------------------------- Materi Pelajaran --------------------------------------------------
			case "R1D01E";
				$R1D01Eclass->R1D01E();
				break;
			case "R1D01E_Save";
				$R1D01Eclass->R1D01E_Save();
				break;
			case "R1D01E_Save_Item";
				$R1D01Eclass->R1D01E_Save_Item();
				break;
			case "R1D01E_Update";
				$R1D01Eclass->R1D01E_Update();
				break;
				// -------------------------------------------------- Hasil Tes --------------------------------------------------
			case "R1D01F";
				$R1D01Fclass->R1D01F();
				break;
			case "R1D01F_Detil";
				$R1D01Fclass->R1D01F_Detil();
				break;
			case "R1D01F_Save";
				$R1D01Fclass->R1D01F_Save();
				break;
				// -------------------------------------------------- Materi  --------------------------------------------------
			case "R1D02A";
				$R1D02Aclass->R1D02A();
				break;
				// -------------------------------------------------- Kelas --------------------------------------------------
			case "R1D02B";
				$R1D02Bclass->R1D02B();
				break;
				// -------------------------------------------------- Guru --------------------------------------------------
			case "R1D02C";
				$R1D02Cclass->R1D02C();
				break;

				// -------------------------------------------------- Siswa --------------------------------------------------
			case "R1D02D";
				$R1D02Dclass->R1D02D();
				break;
				// -------------------------------------------------- Guru --------------------------------------------------
			case "R1D02E";
				$R1D02Eclass->R1D02E();
				break;
				// -------------------------------------------------- Siswa --------------------------------------------------
			case "R1D04C";
				$R1D04Cclass->R1D04C();
				break;
			case "R1D04C_Save";
				$R1D04Cclass->R1D04C_Save();
				break;
			case "R1D04C_Save_Seting";
				$R1D04Cclass->R1D04C_Save_Seting();
				break;
				// -------------------------------------------------- Siswa --------------------------------------------------
			case "R1D04E";
				$R1D04Eclass->R1D04E();
				break;
				// -------------------------------------------------- Siswa --------------------------------------------------
			case "R1D04F";
				$R1D04Fclass->R1D04F();
				break;
			case "R1D04F_Save";
				$R1D04Fclass->R1D04F_Save();
				break;
			case "R1D04F_Save_Seting";
				$R1D04Fclass->R1D04F_Save_Seting();
				break;
				// -------------------------------------------------- Siswa --------------------------------------------------
				/*case "R1D04FSMP";
							$R1D04FSMPclass->R1D04FSMP();
   							break;
    					case "R1D04FSMP_Save";
							$R1D04FSMPclass->R1D04FSMP_Save();
    						break;
    					case "R1D04FSMP_Save_Seting";
							$R1D04FSMPclass->R1D04FSMP_Save_Seting();
    						break;*/
				// -------------------------------------------------- Siswa --------------------------------------------------
				/*case "R1D04FSMPK13";
							$R1D04FSMPK13class->R1D04FSMPK13();
   							break;
    					case "R1D04FSMPK13_Save";
							$R1D04FSMPK13class->R1D04FSMPK13_Save();
    						break;
    					case "R1D04FSMPK13_Save_Seting";
							$R1D04FSMPK13class->R1D04FSMPK13_Save_Seting();
    						break;*/
				// -------------------------------------------------- Siswa --------------------------------------------------
			case "R1D04G";
				$R1D04Gclass->R1D04G();
				break;
			case "R1D04G_Cari";
				$R1D04Gclass->R1D04G_Cari();
				break;
			case "R1D04G_Save";
				$R1D04Gclass->R1D04G_Save();
				break;
				// -------------------------------------------------- Siswa --------------------------------------------------
			case "R1D04H";
				$R1D04Hclass->R1D04H();
				break;
			case "R1D04H_Save";
				$R1D04Hclass->R1D04H_Save();
				break;
			case "R1D04H_Save_Komentar";
				$R1D04Hclass->R1D04H_Save_Komentar();
				break;
			case "R1D04H_Save_Kenaikan";
				$R1D04Hclass->R1D04H_Save_Kenaikan();
				break;



				// -------------------------------------------------- PERint Accomplishment Report sd --------------------------------------------------
			case "R1D04LACC";
				$R1D04LACCclass->R1D04LACC();
				break;

				// -------------------------------------------------- input accomplishment report sd --------------------------------------------------
			case "R1D04HACC";
				$R1D04HACCclass->R1D04HACC();
				break;

			case "R1D04HACC_Save_Komentar";
				$R1D04HACCclass->R1D04HACC_Save_Komentar();
				break;



				// -------------------------------------------------- INPUT hasil interview --------------------------------------------------
			case "R1D04HINTRVW";
				$R1D04HINTRVWclass->R1D04HINTRVW();
				break;

			case "R1D04HINTRVW_Save_Komentar";
				$R1D04HINTRVWclass->R1D04HINTRVW_Save_Komentar();
				break;

				// -------------------------------------------------- cat bk sd --------------------------------------------------
				/*case "R1D04HSD";
							$R1D04HSDclass->R1D04HSD();
   							break;
    					
						case "R1D04HSD_Save_Komentar";
							$R1D04HSDclass->R1D04HSD_Save_Komentar();
    						break;*/

				// -------------------------------------------------- cat bk sd 2 --------------------------------------------------
			case "R1D04HSD2";
				$R1D04HSD2class->R1D04HSD2();
				break;

			case "R1D04HSD2_Save_Komentar";
				$R1D04HSD2class->R1D04HSD2_Save_Komentar();
				break;



				// -------------------------------------------------- cat wali kelas --------------------------------------------------
			case "R1D04HSMP";
				$R1D04HSMPclass->R1D04HSMP();
				break;

			case "R1D04HSMP_Save_Komentar";
				$R1D04HSMPclass->R1D04HSMP_Save_Komentar();
				break;



				// -------------------------------------------------- input comment pgkg 1 --------------------------------------------------
			case "R1D04HPGTK1";
				$R1D04HPGTK1class->R1D04HPGTK1();
				break;

			case "R1D04HPGTK1_Save_Komentar";
				$R1D04HPGTK1class->R1D04HPGTK1_Save_Komentar();
				break;

				// -------------------------------------------------- input comment pgkg 2 --------------------------------------------------
			case "R1D04HPGTK2";
				$R1D04HPGTK2class->R1D04HPGTK2();
				break;

			case "R1D04HPGTK2_Save_Komentar";
				$R1D04HPGTK2class->R1D04HPGTK2_Save_Komentar();
				break;

				// -------------------------------------------------- input comment pgkg 3 --------------------------------------------------
			case "R1D04HPGTK3";
				$R1D04HPGTK3class->R1D04HPGTK3();
				break;

			case "R1D04HPGTK3_Save_Komentar";
				$R1D04HPGTK3class->R1D04HPGTK3_Save_Komentar();
				break;

				// -------------------------------------------------- input comment pgkg 4 --------------------------------------------------
			case "R1D04HPGTK4";
				$R1D04HPGTK4class->R1D04HPGTK4();
				break;

			case "R1D04HPGTK4_Save_Komentar";
				$R1D04HPGTK4class->R1D04HPGTK4_Save_Komentar();
				break;

				// -------------------------------------------------- input comment pgkg 5 --------------------------------------------------
			case "R1D04HPGTK5";
				$R1D04HPGTK5class->R1D04HPGTK5();
				break;

			case "R1D04HPGTK5_Save_Komentar";
				$R1D04HPGTK5class->R1D04HPGTK5_Save_Komentar();
				break;




				// -------------------------------------------------- input narasi kbtk 1 --------------------------------------------------
			case "R1D04HPGTK1_AKR";
				$R1D04HPGTK1_AKRclass->R1D04HPGTK1_AKR();
				break;

			case "R1D04HPGTK1_AKR_Save_Komentar";
				$R1D04HPGTK1_AKRclass->R1D04HPGTK1_AKR_Save_Komentar();
				break;

				// -------------------------------------------------- input narasi kbtk 2 --------------------------------------------------
			case "R1D04HPGTK2_AKR";
				$R1D04HPGTK2_AKRclass->R1D04HPGTK2_AKR();
				break;

			case "R1D04HPGTK2_AKR_Save_Komentar";
				$R1D04HPGTK2_AKRclass->R1D04HPGTK2_AKR_Save_Komentar();
				break;

				// -------------------------------------------------- input narasi kbtk 3 --------------------------------------------------
			case "R1D04HPGTK3_AKR";
				$R1D04HPGTK3_AKRclass->R1D04HPGTK3_AKR();
				break;

			case "R1D04HPGTK3_AKR_Save_Komentar";
				$R1D04HPGTK3_AKRclass->R1D04HPGTK3_AKR_Save_Komentar();
				break;

				// -------------------------------------------------- input narasi kbtk 4 --------------------------------------------------
			case "R1D04HPGTK4_AKR";
				$R1D04HPGTK4_AKRclass->R1D04HPGTK4_AKR();
				break;

			case "R1D04HPGTK4_AKR_Save_Komentar";
				$R1D04HPGTK4_AKRclass->R1D04HPGTK4_AKR_Save_Komentar();
				break;

				// -------------------------------------------------- input narasi kbtk 5 --------------------------------------------------
			case "R1D04HPGTK5_AKR";
				$R1D04HPGTK5_AKRclass->R1D04HPGTK5_AKR();
				break;

			case "R1D04HPGTK5_AKR_Save_Komentar";
				$R1D04HPGTK5_AKRclass->R1D04HPGTK5_AKR_Save_Komentar();
				break;

				// -------------------------------------------------- input narasi kbtk 6 --------------------------------------------------
			case "R1D04HPGTK6_AKR";
				$R1D04HPGTK6_AKRclass->R1D04HPGTK6_AKR();
				break;

			case "R1D04HPGTK6_AKR_Save_Komentar";
				$R1D04HPGTK6_AKRclass->R1D04HPGTK6_AKR_Save_Komentar();
				break;




				// -------------------------------------------------- input grading sheet --------------------------------------------------
			case "R1D04I";
				$R1D04Iclass->R1D04I();
				break;
			case "R1D04I_Cari";
				$R1D04Iclass->R1D04I_Cari();
				break;
			case "R1D04I_Save";
				$R1D04Iclass->R1D04I_Save();
				break;

				// -------------------------------------------------- input learning record KB-TK  --------------------------------------------------
			case "R1D04XTK_AKR";
				$R1D04XTK_AKRclass->R1D04XTK_AKR();
				break;
			case "R1D04XTK_AKR_Save";
				$R1D04XTK_AKRclass->R1D04XTK_AKR_Save();
				break;
			case "R1D04XTK_AKR_Cari";
				$R1D04XTK_AKRclass->R1D04XTK_AKR_Cari();
				break;

				// -------------------------------------------------- input learning record PG-KG  --------------------------------------------------
			case "R1D04XTK";
				$R1D04XTKclass->R1D04XTK();
				break;
			case "R1D04XTK_Save";
				$R1D04XTKclass->R1D04XTK_Save();
				break;
			case "R1D04XTK_Cari";
				$R1D04XTKclass->R1D04XTK_Cari();
				break;

				// -------------------------------------------------- input learning record SD  --------------------------------------------------
			case "R1D04SD";
				$R1D04SDclass->R1D04SD();
				break;
			case "R1D04SD_Save";
				$R1D04SDclass->R1D04SD_Save();
				break;
			case "R1D04SD_Save_Seting";
				$R1D04SDclass->R1D04SD_Save_Seting();
				break;

				// -------------------------------------------------- input learning record SD v2  --------------------------------------------------
			case "R1D04XSD";
				$R1D04XSDclass->R1D04XSD();
				break;
			case "R1D04XSD_Save";
				$R1D04XSDclass->R1D04XSD_Save();
				break;
			case "R1D04XSD_Cari";
				$R1D04XSDclass->R1D04XSD_Cari();
				break;

				// -------------------------------------------------- input grading sheet SD  --------------------------------------------------
			case "R1D04X";
				$R1D04Xclass->R1D04X();
				break;
			case "R1D04X_Cari";
				$R1D04Xclass->R1D04X_Cari();
				break;
			case "R1D04X_Save";
				$R1D04Xclass->R1D04X_Save();
				break;
				// -------------------------------------------------- input grading sheet SMP 8-9 --------------------------------------------------
			case "R1D04Y";
				$R1D04Yclass->R1D04Y();
				break;
			case "R1D04Y_Cari";
				$R1D04Yclass->R1D04Y_Cari();
				break;
			case "R1D04Y_Save";
				$R1D04Yclass->R1D04Y_Save();
				break;
				// -------------------------------------------------- input grading sheet SMP 7 --------------------------------------------------
			case "R1D04YSMP";
				$R1D04YSMPclass->R1D04YSMP();
				break;
			case "R1D04YSMP_Cari";
				$R1D04YSMPclass->R1D04YSMP_Cari();
				break;
			case "R1D04YSMP_Save";
				$R1D04YSMPclass->R1D04YSMP_Save();
				break;
				// -------------------------------------------------- input grading sheet SMA 10 --------------------------------------------------
			case "R1D04YSMA";
				$R1D04YSMAclass->R1D04YSMA();
				break;
			case "R1D04YSMA_Cari";
				$R1D04YSMAclass->R1D04YSMA_Cari();
				break;
			case "R1D04YSMA_Save";
				$R1D04YSMAclass->R1D04YSMA_Save();
				break;
				// -------------------------------------------------- input grading sheet SMA 11-12 ipa --------------------------------------------------
			case "R1D04Z";
				$R1D04Zclass->R1D04Z();
				break;
			case "R1D04Z_Cari";
				$R1D04Zclass->R1D04Z_Cari();
				break;
			case "R1D04Z_Save";
				$R1D04Zclass->R1D04Z_Save();
				break;
				// -------------------------------------------------- input grading sheet SMA 11-12 ips --------------------------------------------------
			case "R1D04ZSMA";
				$R1D04ZSMAclass->R1D04ZSMA();
				break;
			case "R1D04ZSMA_Cari";
				$R1D04ZSMAclass->R1D04ZSMA_Cari();
				break;
			case "R1D04ZSMA_Save";
				$R1D04ZSMAclass->R1D04ZSMA_Save();
				break;
				// -------------------------------------------------- Siswa --------------------------------------------------
			case "R1D04J";
				$R1D04Jclass->R1D04J();
				break;
				// -------------------------------------------------- Siswa --------------------------------------------------
			case "R1D04L";
				$R1D04Lclass->R1D04L();
				break;



				// -------------------------------------------------- learning record  k1 SEMESTER 2 --------------------------------------------------
				/*case "R1D04LTKS2_C01";
							$R1D04LTKS2_C01class->R1D04LTKS2_C01();
   							break;*/



				// -------------------------------------------------- learning record pre-k  --------------------------------------------------
			case "R1D04LPG";
				$R1D04LPGclass->R1D04LPG();
				break;
				// -------------------------------------------------- learning record  k1 --------------------------------------------------
			case "R1D04LTK";
				$R1D04LTKclass->R1D04LTK();
				break;
				// -------------------------------------------------- learning record  k2 --------------------------------------------------
			case "R1D04LTK2";
				$R1D04LTK2class->R1D04LTK2();
				break;
				// -------------------------------------------------- learning record pg  --------------------------------------------------
			case "R1D04LPGab";
				$R1D04LPGabclass->R1D04LPGab();
				break;
				// -------------------------------------------------- learning record tka --------------------------------------------------
			case "R1D04LTKaA";
				$R1D04LTKaAclass->R1D04LTKaA();
				break;
				// -------------------------------------------------- learning record tkb --------------------------------------------------
			case "R1D04LTKbB";
				$R1D04LTKbBclass->R1D04LTKbB();
				break;



				// -------------------------------------------------- bimbingan konseling sd --------------------------------------------------
			case "R1D04LSD_BK";
				$R1D04LSD_BKclass->R1D04LSD_BK();
				break;
				// -------------------------------------------------- bimbingan konseling 2 sd --------------------------------------------------
			case "R1D04LSD_BK2";
				$R1D04LSD_BK2class->R1D04LSD_BK2();
				break;

				// -------------------------------------------------- print hasil interview sd --------------------------------------------------
			case "R1D04LINTRVW";
				$R1D04LINTRVWclass->R1D04LINTRVW();
				break;



				// -------------------------------------------------- cetak rapot diknas 7  --------------------------------------------------
			case "R1D04LSMP7";
				$R1D04LSMP7class->R1D04LSMP7();
				break;

				// -------------------------------------------------- cetak rapot diknas 7  --------------------------------------------------
			case "R1D04LSMA11";
				$R1D04LSMA11class->R1D04LSMA11();
				break;

				// -------------------------------------------------- cetak buku induk siswa sma  --------------------------------------------------
			case "R1D04BISMA";
				$R1D04BISMAclass->R1D04BISMA();
				break;

				// -------------------------------------------------- cetak buku induk siswa sma  --------------------------------------------------
			case "R1D04BISMA2";
				$R1D04BISMA2class->R1D04BISMA2();
				break;



				// -------------------------------------------------- ledger mid term sd  --------------------------------------------------
			case "R1D04LSD";
				$R1D04LSDclass->R1D04LSD();
				break;
				// -------------------------------------------------- ledger final sd  --------------------------------------------------
			case "R1D04LSDfnl";
				$R1D04LSDfnlclass->R1D04LSDfnl();
				break;
				// -------------------------------------------------- ledger mid term smp 7  --------------------------------------------------
			case "R1D04LSMPK13";
				$R1D04LSMPK13class->R1D04LSMPK13();
				break;
				// -------------------------------------------------- ledger mid term smp 8-9  --------------------------------------------------
			case "R1D04LSMP";
				$R1D04LSMPclass->R1D04LSMP();
				break;
				// -------------------------------------------------- ledger mid term sma 10 ipa --------------------------------------------------
			case "R1D04LSMAK13";
				$R1D04LSMAK13class->R1D04LSMAK13();
				break;
				// -------------------------------------------------- ledger mid term sma 10 ips --------------------------------------------------
			case "R1D04LSMAK13ips";
				$R1D04LSMAK13ipsclass->R1D04LSMAK13ips();
				break;
				// -------------------------------------------------- ledger mid term sma 11-12 grade  --------------------------------------------------
			case "R1D04LSMAG";
				$R1D04LSMAGclass->R1D04LSMAG();
				break;
				// -------------------------------------------------- ledger mid term sma 11-12 tpgrade  --------------------------------------------------
			case "R1D04LSMA";
				$R1D04LSMAclass->R1D04LSMA();
				break;
				// -------------------------------------------------- Siswa --------------------------------------------------
			case "R1D04M";
				$R1D04Mclass->R1D04M();
				break;
				// -------------------------------------------------- print grading sheet --------------------------------------------------
			case "R1D04K";
				$R1D04Kclass->R1D04K();
				break;
				// -------------------------------------------------- print grading sheet sd 4 --------------------------------------------------
			case "R1D04R";
				$R1D04Rclass->R1D04R();
				break;
				// -------------------------------------------------- print grading sheet smp 7 --------------------------------------------------
			case "R1D04SSMP";
				$R1D04SSMPclass->R1D04SSMP();
				break;
				// -------------------------------------------------- print grading sheet smp 8-9 --------------------------------------------------
			case "R1D04S";
				$R1D04Sclass->R1D04S();
				break;
				// -------------------------------------------------- print grading sheet sma 10 --------------------------------------------------
			case "R1D04SSMA";
				$R1D04SSMAclass->R1D04SSMA();
				break;
				// -------------------------------------------------- print grading sheet sma 11-12 ipa --------------------------------------------------
			case "R1D04T";
				$R1D04Tclass->R1D04T();
				break;
				// -------------------------------------------------- print grading sheet sma 11-12 ips --------------------------------------------------
			case "R1D04TSMA";
				$R1D04TSMAclass->R1D04TSMA();
				break;
				// -------------------------------------------------- Siswa --------------------------------------------------
			case "R1D04N";
				$R1D04Nclass->R1D04N();
				break;
				// -------------------------------------------------- learning record mid term sd --------------------------------------------------
			case "R1D04SDlrcd";
				$R1D04SDlrcdclass->R1D04SDlrcd();
				break;
				// -------------------------------------------------- rapot mid term --------------------------------------------------
			case "R1D04O";
				$R1D04Oclass->R1D04O();
				break;
				// -------------------------------------------------- rapot class performance sd --------------------------------------------------
			case "R1D04OSDsms";
				$R1D04OSDsmsclass->R1D04OSDsms();
				break;
				// -------------------------------------------------- rapot mid term sd --------------------------------------------------
			case "R1D04OSD";
				$R1D04OSDclass->R1D04OSD();
				break;
				// -------------------------------------------------- rapot mid term SMP 7 --------------------------------------------------
			case "R1D04OSMP";
				$R1D04OSMPclass->R1D04OSMP();
				break;
				// -------------------------------------------------- rapot mid term SMA 10 ipa --------------------------------------------------
			case "R1D04OSMA";
				$R1D04OSMAclass->R1D04OSMA();
				break;
				// -------------------------------------------------- rapot mid term SMA 10 ips --------------------------------------------------
			case "R1D04OSMAips";
				$R1D04OSMAipsclass->R1D04OSMAips();
				break;
				// -------------------------------------------------- print final report --------------------------------------------------
			case "R1D04P";
				$R1D04Pclass->R1D04P();
				break;
				// -------------------------------------------------- print final report sd --------------------------------------------------
			case "R1D04PSD";
				$R1D04PSDclass->R1D04PSD();
				break;
				// -------------------------------------------------- print final report smp 8-9 --------------------------------------------------
			case "R1D04PSMP";
				$R1D04PSMPclass->R1D04PSMP();
				break;
				// -------------------------------------------------- print final report sma 11 ipa--------------------------------------------------
			case "R1D04PSMA";
				$R1D04PSMAclass->R1D04PSMA();
				break;
				// -------------------------------------------------- print final report sma 11 ips--------------------------------------------------
			case "R1D04PSMAips";
				$R1D04PSMAipsclass->R1D04PSMAips();
				break;
				// -------------------------------------------------- print final report sma 12 ipa--------------------------------------------------
			case "R1D04PSMA12";
				$R1D04PSMA12class->R1D04PSMA12();
				break;
				// -------------------------------------------------- print final report sma 12 ips--------------------------------------------------
			case "R1D04PSMAips12";
				$R1D04PSMAips12class->R1D04PSMAips12();
				break;


				//AWAL BUATAN BARU
			case "R1D04LTK21";
				$R1D04LTK21class->R1D04LTK21();
				break;

			case "R1D04LTK22";
				$R1D04LTK22class->R1D04LTK22();
				break;

				// -------------------------------------------------- cetak rapor diknas sd --------------------------------------------------

			case "R1D11A";
				$R1D11Aclass->R1D11A();
				break;

			case "R1D11B";
				$R1D11Bclass->R1D11B();
				break;

			case "R1D11C";
				$R1D11Cclass->R1D11C();
				break;

			case "R1D11D";
				$R1D11Dclass->R1D11D();
				break;

			case "R1D11E";
				$R1D11Eclass->R1D11E();
				break;
				//AKHIR BUATAN BARU



				// -------------------------------------------------- Siswa --------------------------------------------------
			case "R1D04Q";
				$R1D04Qclass->R1D04Q();
				break;
				// -------------------------------------------------- Rencana Ujian --------------------------------------------------
			case "R1D04A";
				$R1D04Aclass->R1D04A();
				break;
			case "R1D04A_Hapus";
				$R1D04Aclass->R1D04A_Hapus();
				break;
			case "R1D04A_Cari";
				$R1D04Aclass->R1D04A_Cari();
				break;
			case "R1D04A_Save";
				$R1D04Aclass->R1D04A_Save();
				break;
			case "R1D04A_Save_Edit";
				$R1D04Aclass->R1D04A_Save_Edit();
				break;
				// -------------------------------------------------- Siswa --------------------------------------------------
			case "R1D04B";
				$R1D04Bclass->R1D04B();
				break;
			case "R1D04B_Save";
				$R1D04Bclass->R1D04B_Save();
				break;
			case "R1D04B_Save_Seting";
				$R1D04Bclass->R1D04B_Save_Seting();
				break;
				// -------------------------------------------------- Siswa --------------------------------------------------	
			case "R1D04D";
				$R1D04Dclass->R1D04D();
				break;

				//-------------------------------------------------- Ganti Password --------------------------------------------------
			case "R6U01";
				$R6U01class->R6U01();
				break;
			case "R6U01_Save";
				$R6U01class->R6U01_Save();
				break;
				//-------------------------------------------------- Email --------------------------------------------------
			case "R6U02";
				$R6U02class->R6U02();
				break;
			case "R6U02_Kirim";
				$R6U02class->R6U02_Kirim();
				break;
			case "R6U02_Save";
				$R6U02class->R6U02_Save();
				break;
				// ----------------------------------------------------------------------------------------------------
		}
		// -------------------------------------------------- tutup --------------------------------------------------
		echo "
					</TD>
				</TR>
			</TABLE>";
		echo "
				<!--<center>
					<img src='../images/fotobersama.jpg' height='80%' width='100%'/>
				</center>-->
			<div id='judulbawah'>
			<TABLE WIDTH='100%'>	
				<TR><TD WIDTH ='50%' HEIGHT='10' BGCOLOR='#ffffff'><FONT class='adminhead'>Copyright &copy 2020 - SAINT JOHN'S SCHOOL</FONT></TD>
					<TD WIDTH ='50%' ALIGN='right'><FONT class='adminhead'>Versi $versi <B>Best viewed with Mozilla Firefox, with screen resolution 1366 by 768 pixels</B></FONT></TD>
				</TR>
			</TABLE></div>";
	}
}
echo "
				
	</BODY>
</HTML>";
