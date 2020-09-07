<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: index.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 15/12/2011
//Keterangan	: Menu Utama SISTER
//------------------------------------------------------------------------------------------------------
require './fungsi_umum/sysconfig.php';
define("sister",1);

echo"
<HTML>
	<HEAD><TITLE>SAINT JOHN'S SCHOOL</TITLE>
		<LINK rel='stylesheet' TYPE='text/css' href='css/styleutama.css'>
        <meta http-equiv='content-type' content='text/html; charset=UTF-8' />
		<link href='./images/jps.ico' rel='icon' type='image/x-icon'/>
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
				// '' is news, and etc.
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
			var aObjDiv = document.getElementsByTagName("div");
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
	require './fungsi_umum/sysconfig.php';
	require FUNGSI_UMUM_DIR.'clock.php';
	$tgl 	=date("j F Y");
	$modul	="MENU UTAMA";

	// -------------------------------------------------- HEADER --------------------------------------------------
	echo"
	<TABLE ALIGN=CENTER WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>
    	<TR><TD BGCOLOR='#1F437F'><IMG src='./images/atas_admin_kiri.jpg' HEIGHT='100' WIDTH='500'></TD>
			<TD BGCOLOR='#1F437F' WIDTH='100%'></TD>
			<TD BGCOLOR='#1F437F'><IMG src='./images/atas_admin_kanan.jpg' HEIGHT='100' WIDTH='300' ALIGN='right'></TD>
		</TR>
	</TABLE>	
	<TABLE ALIGN=CENTER WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>
    	<TR><TD ALIGN='left' 	WIDTH='12%' HEIGHT='20'	BGCOLOR='#fcc012'><B>&nbsp&nbsp&nbsp$modul</B></TD>
    		<TD ALIGN='right'	WIDTH='83%'				BGCOLOR='#fcc012'><FONT class='adminhead'>Tanggal : <B>$tgl</B> - Jam :&nbsp</FONT></TD>
			<TD ALIGN='left' 	WIDTH=' 5%'				BGCOLOR='#fcc012'><FONT class='adminhead'><B>$jam</B></FONT></TD>
    	</TR>
				
		<TABLE ALIGN=CENTER	WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>
			<TR><TD></TD></TR>
			<TR><TD WIDTH='13%' VALIGN='top' BGCOLOR='#3362A8'>";
			
			// -------------------------------------------------- Menu --------------------------------------------------
			/*
			echo"
			<DIV id='LeftMenu'>
			<DIV class='LeftMenuHead' onclick='clickOpenPage(\"index.php\",\"_top\"); return false;' style='cursor: pointer;'>PENDAFTARAN</DIV>";


			echo"
			<DIV class='LeftMenuline'></DIV>
			*/
			echo"
			<DIV id='LeftMenu'>
            <DIV class='LeftMenuHead' onclick='clickOpenPage(\"personalia/index.php\",\"_top\"); return false;' 	style='cursor: pointer;'>PERSONALIA</DIV>
			";


            echo"
			<DIV class='LeftMenuline'></DIV>
			<DIV class='LeftMenuHead' onclick='clickOpenPage(\"kurikulum/index.php\",\"_top\"); return false;' 	style='cursor: pointer;'>KURIKULUM</DIV>";

            echo"
			<DIV class='LeftMenuline'></DIV>
			<DIV class='LeftMenuHead' onclick='clickOpenPage(\"tatausaha/index.php\",\"_top\"); return false;' 	style='cursor: pointer;'>TATA USAHA</DIV>";

			echo"
			<DIV class='LeftMenuline'></DIV>
			<DIV class='LeftMenuHead' onclick='clickOpenPage(\"penjualan/index.php\",\"_top\"); return false;' 		style='cursor: pointer;'>PENJUALAN</DIV>";

			echo"
			<DIV class='LeftMenuline'></DIV>
			<DIV class='LeftMenuHead' onclick='clickOpenPage(\"keuangan/index.php\",\"_top\"); return false;' 		style='cursor: pointer;'>KEUANGAN</DIV>";

			echo"
			<DIV class='LeftMenuline'></DIV>
			<DIV class='LeftMenuHead' onclick='clickOpenPage(\"perpustakaan/index.php\",\"_top\"); return false;' 	style='cursor: pointer;'>PERPUSTAKAAN</DIV>";


			
			echo"
			<DIV class='LeftMenuline'></DIV>
			<DIV class='LeftMenuHead' onclick='clickOpenPage(\"administrator/index.php\",\"_top\"); return false;' 	style='cursor: pointer;'>ADMINISTRATOR</DIV>";
			
			
			
			echo"
			<DIV class='LeftMenuline'></DIV>
			<DIV class='LeftMenuHead' onclick='clickOpenPage(\"guru/index.php\",\"_top\"); return false;' 	style='cursor: pointer;'>GURU</DIV>";



			// -------------------------------------------------- akhir menu --------------------------------------------------

			echo"
			</TD><TD VALIGN=top>";
			echo"
			<CENTER>
				<BR>
				<BR>Welcome to School Information Systems <B> <BR><BR><span style='color: #DA3838;font-size: 16pt'>SAINT JOHN'S SCHOOL</SPAN></B><BR><BR><BR>
			  Please select a menu available to suit your job<BR>
			  Users can access to the menu in accordance with the level of administration
			</CENTER>";
		// -------------------------------------------------- tutup --------------------------------------------------
		echo"
			</TD>
		</TR>
 	</TABLE>";

	echo"
	<TABLE WIDTH='100%' ALIGN='CENTER' BORDER=0 BORDERCOLOR='#ffffff' CELLSPACING=0 CELLPADDING=0>
		<TR><TD COLSPAN=3><IMG src='./images/bawah_admin.jpg' HEIGHT=3 WIDTH='100%'></TD></TR>
	    <TR><TD WIDTH ='50%' HEIGHT='10' BGCOLOR='#ffffff'><FONT class='adminhead'>Copyright &copy 2020 - SAINT JOHN'S SCHOOL</FONT></TD>
			<TD WIDTH ='50%' ALIGN='right'><FONT class='adminhead'>Versi $versi <B>Best viewed with Mozilla Firefox</B></FONT></TD>
		</TR>
	</TABLE>";
echo"
	</BODY>
</HTML>";
?>