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
									";
									if($kdetkt=='PS')
									{
										echo"<li><a href='guru.php?mode=R1D01B_Soal&pilihan=tambah_general'>Create Questions</a></li>";
									}
									
									/* asli
									
									<li><a href='guru.php?mode=R1D01C&pilihan=tambah'>Planning Test</a></li>
									
									<li><a href='guru.php?mode=R1D01F'>Test Result</a></li>
									*/
									
									//<li><a href='guru.php?mode=R1D01D&pilihan=tambah_general'>Isi Nilai</a></li> // Master Plan
									
									
									
									if($kdetkt=='PG' OR $kdetkt=='KG')
									{
										echo"<li><a href='guru.php?mode=R1D01I&pilihan=tambah_general'>Lesson Plan</a></li>";
									}
									else
									{
										echo"<li><a href='guru.php?mode=R1D01A&pilihan=tambah_general'>Upload Material</a></li>
										<li><a href='guru.php?mode=R1D01E&pilihan=tambah_general'>Upload Task</a></li>
									     <li><a href='guru.php?mode=R1D01H&pilihan=tambah_general'>Curriculum Plan</a></li>";
										echo"<li><a href='guru.php?mode=R1D01G&pilihan=tambah_general'>Lesson Plan</a></li>";
									}
									
									echo"
								</ul>
							</li>";
						}
						
						//&kdetkt=$kdetkt
	 
						if($kdejbt=='000' OR $kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR substr($kdekry,0,1)=='@')
						{
							if($kdejbt=='000' OR $kdejbt=='100' OR $kdejbt=='200' OR substr($kdekry,0,1)=='@')
							{
								echo"
								<li><span class='dir'>Control</span>
									<ul>";
									
										if($kdetkt=='PG' OR $kdetkt=='KG')
										{
											
										}
										else
										{
											echo"<li><a href='guru.php?mode=R1D02A'>Subject</a></li>";
										}
										echo"<li><a href='guru.php?mode=R1D02B'>Class</a></li>";
										
										if($kdetkt=='PG' OR $kdetkt=='KG')
										{
											echo"<li><a href='guru.php?mode=R1D02E'>Teacher</a></li>";
										}
										else
										{
											echo"<li><a href='guru.php?mode=R1D02C'>Teacher</a></li>";
										}
										
										echo"<li><a href='guru.php?mode=R1D02D'>Student</a></li>
									</ul>
								</li>";
							}
							else//if($kdejbt=='300')
							{
								echo"
								<li><span class='dir'>Control</span>
									<ul>";
										if($kdetkt=='PG' OR $kdetkt=='KG')
										{
											
										}
										else
										{
											echo"<li><a href='guru.php?mode=R1D02A'>Subject</a></li>";
										}
										echo"<li><a href='guru.php?mode=R1D02B'>Class</a></li>";
										
										echo"<li><a href='guru.php?mode=R1D02D'>Student</a></li>
									</ul>
								</li>";
							}
							
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
						<li>";
							if($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	
							{
								echo"<span class='dir'>Report</span>";
							}
							echo"<ul>";
						
								/*if(($kdetkt=='PG' OR $kdetkt=='KG') AND ($kdejbt=='100' OR $kdejbt=='300' OR $kdejbt=='400' OR $kdejbt=='500'))
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
								}*/
								if(($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='400'))
								{
									/* asli
									echo"
									<li><a href='guru.php?mode=R1D04F_Cari'>Input Indicators of Behaviour (PS-JHS-SHS) </a></li>
									";
									*/
									echo"<li><a href='guru.php?mode=R1D04G_Cari'>Input Extra Curricular</a></li>";
									
									if($kdetkt=='PS')
									{
										echo"<li><a href='guru.php?mode=R1D04SD'>Input Learning Record (PS)</a></li>";
									}
									
									if($kdetkt=='JHS' OR $kdetkt=='SHS')
									{
										echo"<li><a href='guru.php?mode=R1D04F'>Input Personality Traits & Behavior</a></li>";
										//echo"<li><a href='guru.php?mode=R1D04FSMP'>Input Spiritual Behaviour</a></li>";
										//echo"<li><a href='guru.php?mode=R1D04FSMPK13'>Input Social Behaviour</a></li>";
									}
								}
								if(($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='900'))		//$kdejbt=='200' OR 
								{
									///*asli
									echo"
									<li><a href='guru.php?mode=R1D04H'>Input Absences & Comment</a></li>";
									//*/
								}
								if(($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='400'))
								{
									// awal buatan
									if ($kdetkt=='PS')
									{
										echo"
										<li><a href='guru.php?mode=R1D04X_Cari'>Input Grading Sheet (PS)</a></li>";
									}
									else if ($kdetkt=='JHS' OR $kdetkt=='SHS')
									{
										echo"
										<li><a href='guru.php?mode=R1D04YSMP_Cari'>Input Grading Sheet (JHS) 7</a></li>";
										echo"
										<li><a href='guru.php?mode=R1D04Y_Cari'>Input Grading Sheet (JHS) 8-9</a></li>";
										
										echo"
										<li><a href='guru.php?mode=R1D04YSMA_Cari'>Input Grading Sheet (SHS) 10</a></li>";
										
										echo"
										<li><a href='guru.php?mode=R1D04Z_Cari'>Input Grading Sheet (SHS) 11-12 v1</a></li>";
										echo"
										<li><a href='guru.php?mode=R1D04ZSMA_Cari'>Input Grading Sheet (SHS) 11-12 v2</a></li>";
									}
									else
									{
										echo"
										<li><a href='guru.php?mode=R1D04I_Cari'>Input Progress Report (PS-JHS-SHS)</a></li>";
									}
									// akhirs buatan
									
									/*echo"
									<li><a href='guru.php?mode=R1D04I_Cari'>Input Progress Report (PS-JHS-SHS)</a></li>";*/ // input grading sheet
								}
								if((($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='900')) OR $kdejbt=='000' OR substr($kdekry,0,1)=='@')
								{
									/* asli
									echo"
									<li><a href='guru.php?mode=R1D04J'>Print Indicators of Behaviour (PS-JHS-SHS)</a></li>";
									*/
								}
								if(($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='400' OR $kdejbt=='900' OR $kdejbt=='000' ) OR substr($kdekry,0,1)=='@')
								{
									// awal buatan
									if ($kdetkt=='PS')
									{
										echo"
										<li><a href='guru.php?mode=R1D04SDlrcd'>Print Learning Record (PS)</a></li>";
										echo"
										<li><a href='guru.php?mode=R1D04R'>Print Grading Sheet (PS)</a></li>";
									}
									else if ($kdetkt=='JHS' OR $kdetkt=='SHS')
									{
										echo"
										<li><a href='guru.php?mode=R1D04SSMP'>Print Grading Sheet (JHS) 7</a></li>";
										echo"
										<li><a href='guru.php?mode=R1D04S'>Print Grading Sheet (JHS) 8-9</a></li>";
										
										echo"
										<li><a href='guru.php?mode=R1D04SSMA'>Print Grading Sheet (SHS) 10</a></li>";
										
										echo"
										<li><a href='guru.php?mode=R1D04T'>Print Grading Sheet (SHS) 11-12 v1</a></li>";
										echo"
										<li><a href='guru.php?mode=R1D04TSMA'>Print Grading Sheet (SHS) 11-12 v2</a></li>";
									}
									else
									{
										echo"
										<li><a href='guru.php?mode=R1D04K'>Print Grading Sheet (PS-JHS-SHS)</a></li>";
									}
									// akhirs buatan
									
									/*echo"
									<li><a href='guru.php?mode=R1D04K'>Print Grading Sheet (PS-JHS-SHS)</a></li>";
									echo"
									<li><a href='guru.php?mode=R1D04Q'>Print Grading Sheet Final (PS-JHS-SHS)</a></li>";	asli */
								}	
								if((($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='900')) OR $kdejbt=='000' OR substr($kdekry,0,1)=='@')
								{
									/* asli
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
									*/
									if ($kdetkt=='PS')
									{
										echo"
										<li><a href='guru.php?mode=R1D04LSD'>Print Mid Term Ledger (PS)</a></li>";
										echo"
										<li><a href='guru.php?mode=R1D04OSD'>Print Mid Term Report (PS)</a></li>";
										//echo"
										//<li><a href='guru.php?mode=R1D04PSD'>Print Final Report (PS)</a></li>"; 
									}
									else if ($kdetkt=='JHS')
									{
										if ($kdekry=='M11070032')
										{
											
										}
										else
										{
											echo"
											<li><a href='guru.php?mode=R1D04LSMPK13'>Print Mid Term Ledger (JHS) 7</a></li>";
											echo"
											<li><a href='guru.php?mode=R1D04LSMP'>Print Mid Term Ledger (JHS) 8-9</a></li>";
										}
										
										echo"
										<li><a href='guru.php?mode=R1D04OSMP'>Print Mid Term Report (JHS) 7</a></li>";
										echo"
										<li><a href='guru.php?mode=R1D04PSMP'>Print Final Report (JHS) 8-9</a></li>"; 
									}
									else if ($kdetkt=='SHS')
									{
										echo"
											<li><a href='guru.php?mode=R1D04LSMAK13'>Print Mid Term Ledger (SHS) 10 IPA</a></li>";
										echo"
											<li><a href='guru.php?mode=R1D04LSMAK13ips'>Print Mid Term Ledger (SHS) 10 IPS</a></li>";
											
										//..
										
										echo"
										<li><a href='guru.php?mode=R1D04LSMAG'>Print Mid Term Ledger (SHS) 11-12 Grade</a></li>";
										echo"
										<li><a href='guru.php?mode=R1D04LSMA'>Print Mid Term Ledger (SHS) 11-12 Tp Grade</a></li>";
										
										//..
										
										echo"
										<li><a href='guru.php?mode=R1D04OSMA'>Print Mid Term Report (SHS) 10 IPA</a></li>";
										echo"
										<li><a href='guru.php?mode=R1D04OSMAips'>Print Mid Term Report (SHS) 10 IPS</a></li>";
										
										//..
										
										echo"
										<li><a href='guru.php?mode=R1D04PSMA'>Print Final Report (SHS) 11 IPA</a></li>"; 
										echo"
										<li><a href='guru.php?mode=R1D04PSMAips'>Print Final Report (SHS) 11 IPS</a></li>"; 
										
										//..
										
										echo"
										<li><a href='guru.php?mode=R1D04PSMA12'>Print Final Report (SHS) 12 IPA</a></li>"; 
										echo"
										<li><a href='guru.php?mode=R1D04PSMAips12'>Print Final Report (SHS) 12 IPS</a></li>"; 
									}
									else
									{
										echo"
										<li><a href='guru.php?mode=R1D04P'>Print Final Report (PS-JHS-SHS)</a></li>"; 
									}
								}	
							echo"		
							</ul>
						</li>";
						
					/* echo"	
					<li><a href='guru.php?mode=R1D03'>Informasi</a></li>";  */
					//<li><a href='guru.php?mode=R6U02'>eMail<span style='color: #DA3838;font-size: 7pt'>$mail</span></a></li>						
					echo"	
					<li><a href='guru.php?mode=R6U01'>Change Password</a></li>
					
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
					require("pendataan/R1D01G.php");//rpp ps-jhs-shs
					require("pendataan/R1D01H.php");
					require("pendataan/R1D01I.php");//rpp pg-kg
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
					
					require("pendataan/R1D04L.php");
					require("pendataan/R1D04LSD.php"); // ledger mid term sd
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
					
					require("pendataan/R1D04SD.php"); // input learning record sd
					require("pendataan/R1D04X.php"); // input grading sheet sd
					require("pendataan/R1D04Y.php"); // input grading sheet smp 8-9
					require("pendataan/R1D04YSMP.php"); // input grading sheet smp 7
					require("pendataan/R1D04YSMA.php"); // input grading sheet sma 10
					require("pendataan/R1D04Z.php"); // input grading sheet sma 11-12 ipa
					require("pendataan/R1D04ZSMA.php"); // input grading sheet sma 11-12 ips
					
					require("pendataan/R6U01.php");
					require("pendataan/R6U02.php");

					$R1D01Aclass 	=new R1D01Aclass;
					$R1D01Bclass	=new R1D01Bclass;
					$R1D01Cclass 	=new R1D01Cclass;
					$R1D01Dclass 	=new R1D01Dclass;
					$R1D01Eclass 	=new R1D01Eclass;
					$R1D01Fclass 	=new R1D01Fclass;
					$R1D01Gclass 	=new R1D01Gclass;//rpp ps-jhs-sjs
					$R1D01Hclass 	=new R1D01Hclass;
					$R1D01Iclass 	=new R1D01Iclass;//rpp pg-kg
                    $R1D02Aclass 	=new R1D02Aclass;
                    $R1D02Bclass 	=new R1D02Bclass;
                    $R1D02Cclass 	=new R1D02Cclass;
                    $R1D02Dclass 	=new R1D02Dclass;
					$R1D02Eclass 	=new R1D02Eclass;
					$R1D04Cclass 	=new R1D04Cclass;
					$R1D04Eclass 	=new R1D04Eclass;
					$R1D04Fclass 	=new R1D04Fclass;
					//$R1D04FSMPclass 	=new R1D04FSMPclass;
					//$R1D04FSMPK13class 	=new R1D04FSMPK13class;
					$R1D04Gclass 	=new R1D04Gclass;
					$R1D04Hclass 	=new R1D04Hclass;
					$R1D04Iclass 	=new R1D04Iclass;
					$R1D04Jclass 	=new R1D04Jclass;
					$R1D04Kclass 	=new R1D04Kclass;
					
					$R1D04Lclass 	=new R1D04Lclass;
					$R1D04LSDclass 	=new R1D04LSDclass; // ledger mid term sd 
					$R1D04LSMPK13class=new R1D04LSMPK13class; // ledger mid term smp 7
					$R1D04LSMPclass 	=new R1D04LSMPclass; // ledger mid term smp 8-9 
					$R1D04LSMAK13class=new R1D04LSMAK13class; // ledger mid term sma 10 ipa
					$R1D04LSMAK13ipsclass=new R1D04LSMAK13ipsclass; // ledger mid term sma 10 ips
					$R1D04LSMAGclass 	=new R1D04LSMAGclass; // ledger mid term sma 11-12 grade 
					$R1D04LSMAclass 	=new R1D04LSMAclass; // ledger mid term sma 11-12 tpgrade 
					
					$R1D04Mclass 	=new R1D04Mclass;
					$R1D04Nclass 	=new R1D04Nclass;
					$R1D04Oclass 	=new R1D04Oclass;
					
					$R1D04SDlrcdclass 	=new R1D04SDlrcdclass; // learning record mid term sd 
					
					$R1D04OSDclass 	=new R1D04OSDclass; // rapot mid term sd 
					$R1D04OSMPclass 	=new R1D04OSMPclass; // rapot mid term SMP 7
					$R1D04OSMAclass 	=new R1D04OSMAclass; // rapot mid term SMA 10 ipa
					$R1D04OSMAipsclass 	=new R1D04OSMAipsclass; // rapot mid term SMA 10 ips
					$R1D04Pclass 	=new R1D04Pclass;
					
					$R1D04PSMPclass 	=new R1D04PSMPclass; // rapot final smp 8-9
					$R1D04PSMAclass 	=new R1D04PSMAclass; // rapot final sma 11 ipa
					$R1D04PSMAipsclass 	=new R1D04PSMAipsclass; // rapot final sma 11 ips
					$R1D04PSMA12class 	=new R1D04PSMA12class; // rapot final sma 12 ipa
					$R1D04PSMAips12class 	=new R1D04PSMAips12class; // rapot final sma 12 ips
					$R1D04Qclass 	=new R1D04Qclass;
					
					$R1D04Rclass 	=new R1D04Rclass; // print grading sheet sd 
					$R1D04SSMPclass =new R1D04SSMPclass; // print grading sheet smp 7
					$R1D04Sclass 	=new R1D04Sclass; // print grading sheet smp 8-9
					$R1D04SSMAclass =new R1D04SSMAclass; // print grading sheet sma 10
					$R1D04Tclass 	=new R1D04Tclass; // print grading sheet sma 11-12 ipa
					$R1D04TSMAclass 	=new R1D04TSMAclass; // print grading sheet sma 11-12 ips
					
					$R1D04Aclass 	=new R1D04Aclass;
					$R1D04Bclass 	=new R1D04Bclass;
					$R1D04Dclass 	=new R1D04Dclass;
					
					$R1D04SDclass 	=new R1D04SDclass; // input LEARNING record sd 
					$R1D04Xclass 	=new R1D04Xclass; // input grading sheet sd 
					$R1D04Yclass 	=new R1D04Yclass; // input grading sheet smp 8-9
					$R1D04YSMPclass 	=new R1D04YSMPclass; // input grading sheet smp 7
					$R1D04YSMAclass 	=new R1D04YSMAclass; // input grading sheet sma 10
					$R1D04Zclass 	=new R1D04Zclass; // input grading sheet sma 11-12 ipa
					$R1D04ZSMAclass 	=new R1D04ZSMAclass; // input grading sheet sma 11-12 ips
					
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
						// -------------------------------------------------- ledger mid term sd  --------------------------------------------------
   						case "R1D04LSD";
							$R1D04LSDclass->R1D04LSD();
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
						// -------------------------------------------------- print final report sd 4 --------------------------------------------------
   						/*case "R1D04PSD";
							$R1D04PSDclass->R1D04PSD();
   							break;*/
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