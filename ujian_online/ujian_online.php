<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program			: guru.php
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
		<TITLE>Login Users</TITLE>
		<LINK rel='stylesheet' type='text/css' href='../css/styleutama.css'>
		<link href='../images/jps.ico' rel='icon' type='image/x-icon'/>
	</HEAD>
	
	<BODY TOPMARGIN=0 LEFTMARGIN=0>";
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
	
	$user	=$_SESSION["Admin"]["nis"];
    $username	=$_SESSION["Admin"]["nmassw"];
	$tgl 	=date("j F Y");
	$modul	="Siswa";

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
					<TD ALIGN='right'							BGCOLOR='#fcc012'><FONT class='adminhead'>Selamat Datang <B>$username</B> - Tanggal : <B>$tgl</B> - Jam :&nbsp</FONT></TD>
					<TD ALIGN='left' 	WIDTH='60'				BGCOLOR='#fcc012'><FONT class='adminhead'><B>$jam</B></FONT></TD>
				</TR>
			</TABLE>	
			<TABLE ALIGN=CENTER WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>	
				<TR><TD WIDTH='500'><IMG src='../images/atas_admin_kiri.jpg' HEIGHT='100' WIDTH='500'></TD>
					<TD WIDTH='50%' HEIGHT='100' BGCOLOR='#1F437F'></TD>
					<TD WIDTH='300'><IMG src='../images/atas_admin_kanan.jpg' HEIGHT='100' WIDTH='300'></TD>
				</TR>
			</TABLE>	
			<TABLE ALIGN=CENTER	WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>";
						
				// -------------------------------------------------- akhir menu --------------------------------------------------
				echo
				"<TR><TD VALIGN=top>";

					// -------------------------------------------------- tengah --------------------------------------------------
					require("pendataan/UJO01.php");

					$UJO01class	    =new UJO01class;

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
   						ujian();
   						break;

						// -------------------------------------------------- Buat SOal --------------------------------------------------
   						case "UJO01";
							$UJO01class->UJO01();
   							break;
						case "UJO01_Ujian";
							$UJO01class->UJO01_Ujian();
    						break;
    					case "UJO01_Save";
                            $UJO01class->UJO01_Save();
    						break;
                        case "UJO01_Nilai";
                            $UJO01class->UJO01_Nilai();
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
				<TR><TD WIDTH ='50%' HEIGHT='10' BGCOLOR='#ffffff'><FONT class='adminhead'>Copyright &copy 2012 - $nama_pt</FONT></TD>
					<TD WIDTH ='50%' ALIGN='right'><FONT class='adminhead'>Versi $versi <B>Best viewed with Mozilla Firefox</B></FONT></TD>
				</TR>
			</TABLE>";
		}
	}
	echo"
	</BODY>
</HTML>";
?>