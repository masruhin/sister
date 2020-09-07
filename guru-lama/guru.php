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
	</HEAD>
	
	<BODY TOPMARGIN=0 LEFTMARGIN=0 RIGHTMARGIN=0>";
?>
<!-- Beginning of compulsory code below -->


<!--[if lt IE 7]>
<style type="text/css" media="screen">
body { behavior:url("js/csshover.htc"); }
</style>
<![endif]-->

<!-- / END -->
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
			var numDiv 	= aObjDiv.length;

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
				
			$query	="	SELECT 		COUNT(*) as hsl
						FROM 		t_mstpng
						WHERE 		t_mstpng.kdegru='$kdekry'";
			$hsl	=mysql_query($query);	
			$hsl 	=mysql_fetch_assoc($hsl);
			$hsl 	=$hsl['hsl'];
			// -------------------------------------------------- Header --------------------------------------------------
			echo"
			<TABLE ALIGN=CENTER WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>
				<TR><TD ALIGN='left' 	WIDTH='500' HEIGHT='20'	BGCOLOR='#fcc012'><FONT class='adminhead'><B>&nbsp&nbsp&nbsp$modul</B> - $thn <B>$nlithn</B> - $sms <B>$nlisms-$nlimidtrm</B> - $trm <B>$nlitrm</B></TD>
					<TD ALIGN='right'							BGCOLOR='#fcc012'><FONT class='adminhead'>Welcome <B>$user</B> - Date : <B>$tgl</B>&nbsp-&nbsp</FONT></TD>
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
					<TD ALIGN='left' onclick='clickOpenMenu(\"pf\"); return false;' style='cursor: pointer;'>
					<ul id='nav' class='dropdown dropdown-horizontal'>
						<li><a href='guru.php'><IMG src='../images/home.png' WIDTH='10' ALIGN='absmiddle'>&nbspHome</a></li>";
						if($hsl>0)
						{
							echo"	
							<li><span class='dir'>Guru</span>
								<ul>
									<li><a href='guru.php?mode=R1D01A&pilihan=tambah_general'>Buat Materi</a></li>
									<li><a href='guru.php?mode=R1D01B_Soal&pilihan=tambah_general'>Buat Soal</a></li>
									<li><a href='guru.php?mode=R1D01C&pilihan=tambah'>Buat Rencana Test</a></li>";
									//<li><a href='guru.php?mode=R1D01D&pilihan=tambah_general'>Isi Nilai</a></li>
									echo"<li><a href='guru.php?mode=R1D01E&pilihan=tambah_general'>Upload Tugas</a></li>
									     <li><a href='guru.php?mode=R1D01F'>Hasil Tes</a></li>
								</ul>
							</li>";
						}
	 
						if($kdejbt=='000' OR $kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdekry=='@00000')
						{
							echo"
							<li><span class='dir'>Pengawasan</span>
								<ul>
									<li><a href='guru.php?mode=R1D02A'>Materi</a></li>
									<li><a href='guru.php?mode=R1D02B'>Kelas</a></li>
									<li><a href='guru.php?mode=R1D02C'>Guru</a></li>
									<li><a href='guru.php?mode=R1D02D'>Siswa</a></li>
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
						<li><span class='dir'>Raport</span>
							<ul>";
								if(($kdetkt=='PG' OR $kdetkt=='KG') AND ($kdejbt=='100' OR $kdejbt=='300' OR $kdejbt=='900'))
								{
									echo"
									<li><a href='guru.php?mode=R1D04A'>Input Progress Report (PG-KG)</a></li>";
								}
								if((($kdetkt=='PG' OR $kdetkt=='KG') AND ($kdejbt=='100' OR $kdejbt=='300' OR $kdejbt=='900')) OR $kdejbt=='000' OR $kdekry=='@00000')
								{
									echo"
									<li><a href='guru.php?mode=R1D04B'>Cetak Progress Report (PG-KG)</a></li>";
								}
								if(($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='400'))
								{
									echo"
									<li><a href='guru.php?mode=R1D04C_Cari'>Input Indicators of Behaviour (PS-JHS-SHS)</a></li>
									<li><a href='guru.php?mode=R1D04D_Cari'>Input Extra Curricular</a></li>";
								}
								if((($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='300' OR $kdejbt=='900')) OR $kdekry=='@00000')
								{
									echo"
									<li><a href='guru.php?mode=R1D04E'>Input Kehadiran</a></li>";
								}
								if(($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='400'))
								{
									echo"
									<li><a href='guru.php?mode=R1D04F_Cari'>Input Progress Report (PS-JHS-SHS)</a></li>";
								}
								if((($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='900')) OR $kdejbt=='000' OR $kdejbt=='100' OR $kdekry=='@00000')
								{
									echo"
									<li><a href='guru.php?mode=R1D04G'>Cetak Indicators of Behaviour (PS-JHS-SHS)</a></li>";
								}
								if(($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='100' OR $kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='400'))
								{
									echo"
									<li><a href='guru.php?mode=R1D04H'>Cetak Grading Sheet (PS-JHS-SHS)</a></li>";
								}	
								if((($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='900')) OR $kdejbt=='000' OR $kdejbt=='100' OR $kdekry=='@00000')
								/*{
									echo"
									<li><a href='guru.php?mode=R1D04I'>Cetak Master Sheet (PS-JHS-SHS)</a></li>";
								}*/
								if((($kdetkt=='PS' OR $kdetkt=='JHS' OR $kdetkt=='SHS')	AND ($kdejbt=='200' OR $kdejbt=='300' OR $kdejbt=='900')) OR $kdejbt=='000' OR $kdejbt=='100' OR $kdekry=='@00000')
								{
									echo"
									<li><a href='guru.php?mode=R1D04J'>Cetak Monthly Progress Report (PS-JHS-SHS)</a></li>";
								}	
							echo"		
							</ul>
						</li>";
						
					/* echo"	
					<li><a href='guru.php?mode=R1D03'>Informasi</a></li>";  */
					echo"	
					<li><a href='guru.php?mode=R6U01'>Ganti Password</a></li>	
					<li><a href='../guru/index.php'>Logout</a></li>	
					</ul>
					</TD>
				</TR>
			</TABLE>
			<TABLE ALIGN=CENTER	WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>";
						
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
                    require("pendataan/R1D02A.php");
                    require("pendataan/R1D02B.php");
                    require("pendataan/R1D02C.php");
                    require("pendataan/R1D02D.php");
                    require("pendataan/R1D04A.php");
					require("pendataan/R1D04B.php");
					require("pendataan/R1D04C.php");
					require("pendataan/R1D04D.php");
					require("pendataan/R1D04E.php");
					require("pendataan/R1D04F.php");
					require("pendataan/R1D04G.php");
					require("pendataan/R1D04H.php");
					require("pendataan/R1D04J.php");
					require("pendataan/R1D04I.php");
					require("pendataan/R6U01.php");

					$R1D01Aclass 	=new R1D01Aclass;
					$R1D01Bclass	=new R1D01Bclass;
					$R1D01Cclass 	=new R1D01Cclass;
					$R1D01Dclass 	=new R1D01Dclass;
					$R1D01Eclass 	=new R1D01Eclass;
					$R1D01Fclass 	=new R1D01Fclass;
                    $R1D02Aclass 	=new R1D02Aclass;
                    $R1D02Bclass 	=new R1D02Bclass;
                    $R1D02Cclass 	=new R1D02Cclass;
                    $R1D02Dclass 	=new R1D02Dclass;
					$R1D04Aclass 	=new R1D04Aclass;
					$R1D04Bclass 	=new R1D04Bclass;
					$R1D04Cclass 	=new R1D04Cclass;
					$R1D04Dclass 	=new R1D04Dclass;
					$R1D04Eclass 	=new R1D04Eclass;
					$R1D04Fclass 	=new R1D04Fclass;
					$R1D04Gclass 	=new R1D04Gclass;
					$R1D04Hclass 	=new R1D04Hclass;
					$R1D04Jclass 	=new R1D04Jclass;
					$R1D04Iclass 	=new R1D04Iclass;
					$R6U01class 	=new R6U01class;

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
                        case "R1D01B_Update";
                            $R1D01Bclass->R1D01B_Update();
    					break;
                        case "R1D01B_HapusG";
                            $R1D01Bclass->R1D01B_HapusG();
    					break;

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
   						case "R1D04A";
							$R1D04Aclass->R1D04A();
   							break;
    					case "R1D04A_Save";
							$R1D04Aclass->R1D04A_Save();
    						break;
    					case "R1D04A_Save_Seting";
							$R1D04Aclass->R1D04A_Save_Seting();
    						break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04B";
							$R1D04Bclass->R1D04B();
   							break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04C";
							$R1D04Cclass->R1D04C();
   							break;
    					case "R1D04C_Cari";
							$R1D04Cclass->R1D04C_Cari();
    						break;
    					case "R1D04C_Save";
							$R1D04Cclass->R1D04C_Save();
    						break;
    					case "R1D04C_Save_Seting";
							$R1D04Cclass->R1D04C_Save_Seting();
    						break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04D";
							$R1D04Dclass->R1D04D();
   							break;
    					case "R1D04D_Cari";
							$R1D04Dclass->R1D04D_Cari();
    						break;
    					case "R1D04D_Save";
							$R1D04Dclass->R1D04D_Save();
    						break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04E";
							$R1D04Eclass->R1D04E();
   							break;
    					case "R1D04E_Save";
							$R1D04Eclass->R1D04E_Save();
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
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04G";
							$R1D04Gclass->R1D04G();
   							break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04I";
							$R1D04Iclass->R1D04I();
   							break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04H";
							$R1D04Hclass->R1D04H();
   							break;
                        // -------------------------------------------------- Siswa --------------------------------------------------
   						case "R1D04J";
							$R1D04Jclass->R1D04J();
   							break;
                        // -------------------------------------------------- Materi  --------------------------------------------------
   						case "R1D03A";
							$R1D03Aclass->R1D03A();
   							break;
                        //-------------------------------------------------- Ganti Password --------------------------------------------------
						case "R6U01";
							$R6U01class->R6U01();
    						break;
    					case "R6U01_Save";
							$R6U01class->R6U01_Save();
    						break;
						// ----------------------------------------------------------------------------------------------------
					}
					// -------------------------------------------------- tutup --------------------------------------------------
					echo"
					</TD>
				</TR>
			</TABLE>";
			
			echo"
			<TABLE WIDTH='100%' ALIGN='CENTER' BORDER=0 BORDERCOLOR='#ffffff' CELLSPACING=0 CELLPADDING=0>
				<TR><TD COLSPAN=2><IMG src='../images/bawah_admin.jpg' HEIGHT=2 WIDTH='100%'></TD></TR>
				<TR><TD WIDTH ='50%' HEIGHT='10' BGCOLOR='#ffffff'><FONT class='adminhead'>Copyright &copy 2012 - SAINT JOHN'S SCHOOL</FONT></TD>
					<TD WIDTH ='50%' ALIGN='right'><FONT class='adminhead'>Versi $versi <B>Best viewed with Mozilla Firefox</B></FONT></TD>
			</TABLE>";
		}
	}
	echo"
	</TODY>
</HTML>";
?>