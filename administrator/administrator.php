<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: administrator.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Menu Utama ADMINISTRATOR (sistem)
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
	
	$user	=$_SESSION["Admin"]["nmakry"];
    $kdekry	=$_SESSION["Admin"]["kdekry"];
	$tgl 	=date("j F Y");
	$modul	="ADMINISTRATOR";

	if (!isset($_SESSION['Admin']))
	{
		echo"Anda harus login dulu.. redirecting\n";
	
		echo"<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
	}
	else
	{
		if (isset($_GET['logout']))
		{
			$username	=$_SESSION["Admin"]["username"];
			unset($_SESSION['Admin']);
			//session_destroy();
			echo"Terima kasih.. redirecting\n";
			
			echo"<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
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
							<DIV class='LeftMenuHead' onclick='clickOpenPage(\"administrator.php\",\"_top\"); return false;' style='cursor: pointer;'><IMG src='../images/home.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> [ Home ]</DIV>";

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
									if ($row[menu]=='A1D01') echo'<div style="cursor: pointer;"><a href="administrator.php?mode=A1D01_Cari"	class=ver11 >- Modul</a></div>';
									if ($row[menu]=='A1D02') echo'<div style="cursor: pointer;"><a href="administrator.php?mode=A1D02_Cari"		class=ver11 >- User</a></div>';
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
									if ($row[menu]=='A6U01') echo '<div style="cursor: pointer;"><a href="administrator.php?mode=A6U01_Cari" class=ver11 >- Seting User</a></div>';
									if ($row[menu]=='A6U02') echo '<div style="cursor: pointer;"><a href="administrator.php?mode=A6U02" class=ver11 >- Seting Raport PG-KG</a></div>';
									if ($row[menu]=='A6U03') echo '<div style="cursor: pointer;"><a href="administrator.php?mode=A6U03" class=ver11 >- Seting Raport PS-JHS-SHS</a></div>';
									if ($row[menu]=='A6U04') echo '<div style="cursor: pointer;"><a href="administrator.php?mode=A6U04" class=ver11 >- Seting Behaviour PS-JHS-SHS</a></div>';
									if ($row[menu]=='A6U05') echo '<div style="cursor: pointer;"><a href="administrator.php?mode=A6U05" class=ver11 >- Buat Data Behaviour</a></div>';
									if ($row[menu]=='A6U06') echo '<div style="cursor: pointer;"><a href="administrator.php?mode=A6U06" class=ver11 >- Buat Data Progress</a></div>';
									//if ($row[menu]=='A6U02') echo '<div style="cursor: pointer;"><a href="administrator.php?mode=A6U02" class=ver11 >- BackUp</a></div>';
									//if ($row[menu]=='A6U03') echo '<div style="cursor: pointer;"><a href="administrator.php?mode=A6U03" class=ver11 >- Restore</a></div>';
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
						require("pendataan/A1D01.php");
						require("pendataan/A1D02.php");
						require("Utility/A6U01.php");
						require("Utility/A6U02.php");
						require("Utility/A6U03.php");
						require("Utility/A6U04.php");
						require("Utility/A6U05.php");
						require("Utility/A6U06.php");
						
						$A1D01class	=new A1D01class;
						$A1D02class =new A1D02class;
						$A6U01class =new A6U01class;
						$A6U02class =new A6U02class;
						$A6U03class =new A6U03class;
						$A6U04class =new A6U04class;
						$A6U05class =new A6U05class;
						$A6U06class =new A6U06class;

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
							
							echo"<meta http-equiv=\"refresh\" content=\"1;url=administrator.php?logout\">\n";
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

							// -------------------------------------------------- Rekening --------------------------------------------------
    						case "A1D01";
								if (hakakses("A1D01")==1) $A1D01class->A1D01();
								else errordata();
    							break;
							case "A1D01_Hapus";
								if (hakakses("A1D01H")==1) $A1D01class->A1D01_Hapus();
								else errordata();
    							break;	
							case "A1D01_Cari";
								if (hakakses("A1D01")==1) $A1D01class->A1D01_Cari();
								else errordata();
    							break;
    						case "A1D01_Save";
								if (hakakses("A1D01")==1) $A1D01class->A1D01_Save();
								else errordata();
    							break;

							// -------------------------------------------------- User --------------------------------------------------
    						case "A1D02";
								if (hakakses("A1D02")==1) $A1D02class->A1D02();
								else errordata();
    							break;
							case "A1D02_Cari";
								if (hakakses("A1D02")==1) $A1D02class->A1D02_Cari();
								else errordata();
    							break;
    						case "A1D02_Save";
								if (hakakses("A1D02")==1) $A1D02class->A1D02_Save();
								else errordata();
    							break;
    						case "A1D02_Menu";
								if (hakakses("A1D02")==1) $A1D02class->A1D02_Menu();
								else errordata();
    							break;
    						case "A1D02_Save_Menu";
								if (hakakses("A1D02")==1) $A1D02class->A1D02_Save_Menu();
								else errordata();
    							break;
    						case "A1D02_Save_Menu_Semua";
								if (hakakses("A1D02")==1) $A1D02class->A1D02_Save_Menu_Semua();
								else errordata();
    							break;
    						case "A1D02_Hapus_Menu";
								if (hakakses("A1D02")==1) $A1D02class->A1D02_Hapus_Menu();
								else errordata();
    							break;
    						case "A1D02_Hapus_Menu_Semua";
								if (hakakses("A1D02")==1) $A1D02class->A1D02_Hapus_Menu_Semua();
								else errordata();
    							break;
    						case "A1D02_Copy";
								if (hakakses("A1D02")==1) $A1D02class->A1D02_Copy();
								else errordata();
    							break;
    						case "A1D02_Buat_Admin";
								if (hakakses("A1D02")==1) $A1D02class->A1D02_Buat_Admin();
								else errordata();
    							break;
								
							// -------------------------------------------------- User --------------------------------------------------
    						case "A6U01";
								if (hakakses("A6U01")==1) $A6U01class->A6U01();
								else errordata();
    							break;
							case "A6U01_Hapus";
								if (hakakses("A6U01")==1) $A6U01class->A6U01_Hapus();
								else errordata();
    							break;	
							case "A6U01_Cari";
								if (hakakses("A6U01")==1) $A6U01class->A6U01_Cari();
								else errordata();
    							break;
    						case "A6U01_Save";
								if (hakakses("A6U01")==1) $A6U01class->A6U01_Save();
								else errordata();
    							break;
    						case "A6U01_Menu";
								if (hakakses("A6U01")==1) $A6U01class->A6U01_Menu();
								else errordata();
    							break;
    						case "A6U01_Save_Menu";
								if (hakakses("A6U01")==1) $A6U01class->A6U01_Save_Menu();
								else errordata();
    							break;
    						case "A6U01_Save_Menu_Semua";
								if (hakakses("A6U01")==1) $A6U01class->A6U01_Save_Menu_Semua();
								else errordata();
    							break;
    						case "A6U01_Hapus_Menu";
								if (hakakses("A6U01")==1) $A6U01class->A6U01_Hapus_Menu();
								else errordata();
    							break;
    						case "A6U01_Hapus_Menu_Semua";
								if (hakakses("A6U01")==1) $A6U01class->A6U01_Hapus_Menu_Semua();
								else errordata();
    							break;
    						case "A6U01_Copy";
								if (hakakses("A6U01")==1) $A6U01class->A6U01_Copy();
								else errordata();
    							break;
    						case "A6U01_Buat_Admin";
								if (hakakses("A6U01")==1) $A6U01class->A6U01_Buat_Admin();
								else errordata();
    							break;						
							// -------------------------------------------------- Seting Raport PG-KG --------------------------------------------------
    						case "A6U02";
								if (hakakses("A6U02")==1) $A6U02class->A6U02();
								else errordata();
    							break;
                            // -------------------------------------------------- Seting Raport PS-JHS-SHS --------------------------------------------------
						    case "A6U03":
								if (hakakses("A6U03")==1) $A6U03class->A6U03();
								else errordata();
						    	break;
                            // -------------------------------------------------- Seting Behaviour PS-JHS-SHS --------------------------------------------------
						    case "A6U04":
								if (hakakses("A6U04")==1) $A6U04class->A6U04();
								else errordata();
						    	break;
                            // -------------------------------------------------- Buat Data Behaviour --------------------------------------------------
						    case "A6U05":
								if (hakakses("A6U05")==1) $A6U05class->A6U05();
								else errordata();
						    	break;
						    case "A6U05_Buat":
								if (hakakses("A6U05")==1) $A6U05class->A6U05_Buat();
								else errordata();
						    	break;
								
                            // -------------------------------------------------- Buat Data Progress --------------------------------------------------
						    case "A6U06":
								if (hakakses("A6U06")==1) $A6U06class->A6U06();
								else errordata();
						    	break;
						    case "A6U06_Buat":
								if (hakakses("A6U06")==1) $A6U06class->A6U06_Buat();
								else errordata();
						    	break;

						// -------------------------------------------------------------------------------
						}
						// -------------------------------------------------- tutup --------------------------------------------------
						echo"
						</TD>
					</TR>
				</TABLE>
			</TABLE>";
			
			echo"
			<TABLE WIDTH='100%' ALIGN='CENTER' BORDER=0 BORDERCOLOR='#ffffff' CELLSPACING=0 CELLPADDING=0>	
				<TR><TD COLSPAN=2><IMG src='images/bawah_admin.jpg' HEIGHT=2 WIDTH='100%'></TD></TR>
				<TR><TD WIDTH ='50%' HEIGHT='10' BGCOLOR='#ffffff'><FONT class='adminhead'>Copyright &copy 2012 - SAINT JOHN'S SCHOOL</FONT></TD>
					<TD WIDTH ='50%' ALIGN='right'><FONT class='adminhead'>Versi $versi <B>Best viewed with Mozilla Firefox</B></FONT></TD>
				</TR>
			</TABLE>";
		}
	}
	echo"
	</BODY>
</HTML>";
?>