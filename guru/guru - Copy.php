<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: guru.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Menu Utama penjualan (sistem)
//-----------------------------------------------------------------------------------------------------
require '../fungsi_umum/sysconfig.php';
require FUNGSI_UMUM_DIR.'koneksi.php';
define("sister",1);

echo"
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
	
	<BODY TOPMARGIN=0 LEFTMARGIN=0 RIGHTMARGIN=0>";

	require("../fungsi_umum/sysconfig.php");
	require FUNGSI_UMUM_DIR.'clock.php';
	require FUNGSI_UMUM_DIR.'fungsi_admin.php';
	require FUNGSI_UMUM_DIR.'fungsi_periode.php';
	
	$user	=$_SESSION["Admin"]["nmakry"];
    $kdekry	=$_SESSION["Admin"]["kdekry"];
	$tgl 	=date("j F Y");
	$modul	="GURU";
	$thn	='Tahun Ajaran';
	$sms	='Semester';
	$trm	='Term';
	$midtrm	='Mid Term';
	
	$query 	=mysql_query("	SELECT 		t_setthn.* 
							FROM 		t_setthn
							WHERE		t_setthn.set='$thn'");
	$data = mysql_fetch_array($query);
	$nlithn=$data[nli];
	
	$query 	=mysql_query("	SELECT 		t_setthn.* 
							FROM 		t_setthn
							WHERE		t_setthn.set='$sms'");
	$data = mysql_fetch_array($query);
	$nlisms=$data[nli];

	$query 	=mysql_query("	SELECT 		t_setthn.* 
							FROM 		t_setthn
							WHERE		t_setthn.set='$trm'");
	$data = mysql_fetch_array($query);
	$nlitrm=$data[nli];

	$query 	=mysql_query("	SELECT 		t_setthn.* 
							FROM 		t_setthn
							WHERE		t_setthn.set='$midtrm'");
	$data = mysql_fetch_array($query);
	$nlimidtrm=$data[nli];
	
	if($nlithn=='' or $nlisms=='' or $nlitrm=='' or $nlimidtrm=='')
	{
		echo"
		<SCRIPT TYPE='text/javascript'>
			window.alert('Tahun Ajaran / Semester belum di seting bagian Kurikulum')
		</SCRIPT>";
		
		echo"
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
			$username	=$_SESSION["Admin"]["nmakry"];
			unset($_SESSION['Admin']);
			//session_destroy();
			echo"
			Terima kasih.. redirecting\n";
			
			echo"
			<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
		}
		else
		{  
			$query	="	SELECT 		t_prstkt.* 
						FROM 		t_prstkt
						WHERE 		t_prstkt.kdekry='$kdekry' 
						ORDER BY 	t_prstkt.kdekry";
			$result	=mysql_query($query);
			$kdejbt=1000;
			while($data=mysql_fetch_array($result))
			{
				if($data[kdejbt]<$kdejbt AND $data[kdejbt]!='')
				{
					$kdejbt	=$data[kdejbt];
					$kdetkt	=$data[kdetkt];
				}	
				if($kdejbt=='000')
				{
					$modul	="PIMPINAN";
				}
			}	
			$modul	="TEACHER";
			$thn	='School year';
			$sms	='Semester';
			$trm	='Term';
			$midtrm	='Mid Term';
				
			$query	="	SELECT 		COUNT(*) as hsl
						FROM 		t_mstpng
						WHERE 		t_mstpng.kdegru='$kdekry'";
			$hsl	=mysql_query($query);	
			$hsl 	=mysql_fetch_assoc($hsl);
			$hsl 	=$hsl['hsl'];
			// -------------------------------------------------- Header --------------------------------------------------
			echo"
			<TABLE ALIGN=CENTER WIDTH='100%' BORDER='0' BORDERCOLOR='#R1D04FR1D04F' CELLPADDING='0' CELLSPACING='0'>
				<TR><TD ALIGN='left' 	WIDTH='500' HEIGHT='20'	BGCOLOR='#fcc012'><FONT class='adminhead'><B>&nbsp&nbsp&nbsp$modul</B> - $thn <B>$nlithn</B> - $sms <B>$nlisms-$nlimidtrm</B> - $trm <B>$nlitrm</B></TD>
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
					echo"
					<TD ALIGN='left' onclick='clickOpenMenu(\"pf\"); return false;' style='cursor: pointer;'>
					<ul id='nav' class='dropdown dropdown-horizontal'>
						<li><a href='guru.php'><IMG src='../images/home.png' WIDTH='10' ALIGN='absmiddle'>&nbspHome</a></li>";
						if($hsl>0)
						{
							echo"	
							<li><span class='dir'>Teacher Tools</span>
								<ul>
									<li><a href='guru.php?mode=R1D01A&pilihan=tambah_general'>Upload Material</a></li>
									<li><a href='guru.php?mode=R1D01B_Soal&pilihan=tambah_general'>Create Questions</a></li>
									<li><a href='guru.php?mode=R1D01C&pilihan=tambah'>Planning Test</a></li>";
									//<li><a href='guru.php?mode=R1D01D&pilihan=tambah_general'>Isi Nilai</a></li> // Master Plan
									echo"<li><a href='guru.php?mode=R1D01E&pilihan=tambah_general'>Upload Task</a></li>
									     <li><a href='guru.php?mode=R1D01F'>Test Result</a></li>
										 <li><a href='guru.php?mode=R1D01G&pilihan=tambah_general'>Lesson Plan</a></li>
								</ul>
							</li>";
						}
	 
						if($kdejbt=='000' OR $kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR substr($kdekry,0,1)=='@')
						{
							echo"
							<li><span class='dir'>Control</span>
								<ul>
									<li><a href='guru.php?mode=R1D02A'>Subject</a></li>
									<li><a href='guru.php?mode=R1D02B'>Class</a></li>
									<li><a href='guru.php?mode=R1D02C'>Teacher</a></li>
									<li><a href='guru.php?mode=R1D02D'>Student</a></li>
								</ul>
							</li>";
							/*
							echo"
							<li><span class='dir'>Analisa</span>
								<ul>
									<li><a href='#'>Materi</a></li>
									<li><a href='#'>Kelas</a></li>
									<li><a href='#'>Guru</a></li>
									<li><a href='#'>Siswa</a></li>
								</ul>
							</li>";  */
						}
						
						echo"
						<li><span class='dir'>Report</span>
							<ul>";
								if(($kdetkt=='PG' OR $kdetkt=='KG') AND ($kdejbt=='100' OR $kdejbt=='300' OR $kdejbt=='400' OR $kdejbt=='500'))
								{
									echo"<li><a href='guru.php?mode=R1D04A_Cari'>Setting Weekly Progress (PG-KG)</a></li>";
									echo"<li><a href='guru.php?mode=R1D04B'>Input Weekly Progress (PG-KG)</li>";
								}
								if(($kdetkt=='PG' OR $kdetkt=='KG') AND ($kdejbt=='100' OR $kdejbt=='300' OR $kdejbt=='900'))
								{
//									if($kdejbt=='100' OR $kdejbt=='900')
									echo"<li><a href='guru.php?mode=R1D04C'>Input Progress Report (PG-KG)</a></li>";
								}
								if((($kdetkt=='PG' OR $kdetkt=='KG') AND ($kdejbt=='100' OR $kdejbt=='300' OR $kdejbt=='900')) OR $kdejbt=='000' OR substr($kdekry,0,1)=='@')
								{
									echo"
									<li><a href='guru.php?mode=R1D04D'>Print Weekly Progress (PG-KG)</a></li>";
									echo"
									<li><a href='guru.php?mode=R1D04E'>Print Progress Report (PG-KG)</a></li>";
								}
								if(($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='400'))
								{
									echo"
									<li><a href='guru.php?mode=R1D04F_Cari'>Input Indicators of Behaviour (PS-JHS-SHS)</a></li>
									<li><a href='guru.php?mode=R1D04G_Cari'>Input Extra Curricular</a></li>";
								}
								if(($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='300' OR $kdejbt=='900'))
								{
									echo"
									<li><a href='guru.php?mode=R1D04H'>Input Attendance & Comment</a></li>";
								}
								if(($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='400'))
								{
									echo"
									<li><a href='guru.php?mode=R1D04I_Cari'>Input Progress Report (PS-JHS-SHS)</a></li>";
								}
								if((($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='900')) OR $kdejbt=='000' OR substr($kdekry,0,1)=='@')
								{
									echo"
									<li><a href='guru.php?mode=R1D04J'>Print Indicators of Behaviour (PS-JHS-SHS)</a></li>";
								}
								if(($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='400' OR $kdejbt=='900' OR $kdejbt=='000' ) OR substr($kdekry,0,1)=='@')
								{
									echo"
									<li><a href='guru.php?mode=R1D04K'>Print Grading Sheet (PS-JHS-SHS)</a></li>";
									echo"
									<li><a href='guru.php?mode=R1D04Q'>Print Grading Sheet Final (PS-JHS-SHS)</a></li>";
								}	
								if((($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='900')) OR $kdejbt=='000' OR substr($kdekry,0,1)=='@')
								{
									echo"
									<li><a href='guru.php?mode=R1D04L'>Print Master Sheet-Mid Term (PS-JHS-SHS)</a></li>";
									echo"
									<li><a href='guru.php?mode=R1D04M'>Print Master Sheet-Final (PS-JHS-SHS)</a></li>";
									echo"
									<li><a href='guru.php?mode=R1D04N'>Print Monthly Progress Report (PS-JHS-SHS)</a></li>";
									echo"
									<li><a href='guru.php?mode=R1D04O'>Print Mid Term Report (PS-JHS-SHS)</a></li>";
									echo"
									<li><a href='guru.php?mode=R1D04P'>Print Final Report (PS-JHS-SHS)</a></li>"; 
								}	
							echo"		
							</ul>
						</li>";
						
					/* echo"	
					<li><a href='guru.php?mode=R1D03'>Informasi</a></li>";  */
					echo"	
					<li><a href='guru.php?mode=R6U01'>Change Password</a></li>
					<li><a href='guru.php?mode=R6U02'>eMail<span style='color: #DA3838;font-size: 7pt'>$mail</span></a></li>						
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
					require("pendataan/R1D01C.php");
					require("pendataan/R1D01D.php");
					require("pendataan/R1D01E.php");
					require("pendataan/R1D01F.php");
					require("pendataan/R1D01G.php");
                    require("pendataan/R1D02A.php");
                    require("pendataan/R1D02B.php");
                    require("pendataan/R1D02C.php");
                    require("pendataan/R1D02D.php");
                    require("pendataan/R1D04C.php");
					require("pendataan/R1D04E.php");
					require("pendataan/R1D04F.php");
					require("pendataan/R1D04G.php");
					require("pendataan/R1D04H.php");
					require("pendataan/R1D04I.php");
					require("pendataan/R1D04J.php");
					require("pendataan/R1D04K.php");
					require("pendataan/R1D04L.php");
					require("pendataan/R1D04M.php");
					require("pendataan/R1D04N.php");
					require("pendataan/R1D04O.php");
					require("pendataan/R1D04P.php");	
					require("pendataan/R1D04Q.php");
					require("pendataan/R1D04A.php");
					require("pendataan/R1D04B.php");
					require("pendataan/R1D04D.php");
					require("pendataan/R6U01.php");
					require("pendataan/R6U02.php");

					$R1D01Aclass 	=new R1D01Aclass;
					$R1D01Bclass	=new R1D01Bclass;
					$R1D01Cclass 	=new R1D01Cclass;
					$R1D01Dclass 	=new R1D01Dclass;
					$R1D01Eclass 	=new R1D01Eclass;
					$R1D01Fclass 	=new R1D01Fclass;
					$R1D01Gclass 	=new R1D01Gclass;
                    $R1D02Aclass 	=new R1D02Aclass;
                    $R1D02Bclass 	=new R1D02Bclass;
                    $R1D02Cclass 	=new R1D02Cclass;
                    $R1D02Dclass 	=new R1D02Dclass;
					$R1D04Cclass 	=new R1D04Cclass;
					$R1D04Eclass 	=new R1D04Eclass;
					$R1D04Fclass 	=new R1D04Fclass;
					$R1D04Gclass 	=new R1D04Gclass;
					$R1D04Hclass 	=new R1D04Hclass;
					$R1D04Iclass 	=new R1D04Iclass;
					$R1D04Jclass 	=new R1D04Jclass;
					$R1D04Kclass 	=new R1D04Kclass;
					$R1D04Lclass 	=new R1D04Lclass;
					$R1D04Mclass 	=new R1D04Mclass;
					$R1D04Nclass 	=new R1D04Nclass;
					$R1D04Oclass 	=new R1D04Oclass;
					$R1D04Pclass 	=new R1D04Pclass;
					$R1D04Qclass 	=new R1D04Qclass;
					$R1D04Aclass 	=new R1D04Aclass;
					$R1D04Bclass 	=new R1D04Bclass;
					$R1D04Dclass 	=new R1D04Dclass;
					$R6U01class 	=new R6U01class;
					$R6U02class 	=new R6U02class;

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
						<meta http-equiv=\"refresh\" content=\"1;url=guru.php?logout\">\n";
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
						
						 // -------------------------------------------------- Master Plan --------------------------------------------------
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
                        //
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D02D";
							$R1D02Dclass->R1D02D();
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
    					case "R1D04F_Cari";
							$R1D04Fclass->R1D04F_Cari();
    						break;
    					case "R1D04F_Save";
							$R1D04Fclass->R1D04F_Save();
    						break;
    					case "R1D04F_Save_Seting";
							$R1D04Fclass->R1D04F_Save_Seting();
    						break;
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
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04I";
							$R1D04Iclass->R1D04I();
   							break;
    					case "R1D04I_Cari";
							$R1D04Iclass->R1D04I_Cari();
    						break;
    					case "R1D04I_Save";
							$R1D04Iclass->R1D04I_Save();
    						break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04J";
							$R1D04Jclass->R1D04J();
   							break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04L";
							$R1D04Lclass->R1D04L();
   							break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04M";
							$R1D04Mclass->R1D04M();
   							break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04K";
							$R1D04Kclass->R1D04K();
   							break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04N";
							$R1D04Nclass->R1D04N();
   							break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04O";
							$R1D04Oclass->R1D04O();
   							break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04P";
							$R1D04Pclass->R1D04P();
   							break;
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
					echo"
					</TD>
				</TR>
			</TABLE>";
			echo"
			<div id='judulbawah'>
			<TABLE WIDTH='100%'>	
				<TR><TD WIDTH ='50%' HEIGHT='10' BGCOLOR='#ffffff'><FONT class='adminhead'>Copyright &copy 2012 - SAINT JOHN'S SCHOOL</FONT></TD>
					<TD WIDTH ='50%' ALIGN='right'><FONT class='adminhead'>Versi $versi <B>Best viewed with Mozilla Firefox, with screen resolution 1366 by 768 pixels</B></FONT></TD>
				</TR>
			</TABLE></div>";
		}
	}
	echo"
	</BODY>
</HTML>";
?>