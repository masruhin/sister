<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: J6U01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: Fungsi-fungsi PERBAIKI DATA
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<H1>Permission Denied</H1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class J6U01class
{
    // -------------------------------------------------- Layar Utama --------------------------------------------------
 	function J6U01()
 	{
	 	echo"
		<FORM ACTION=penjualan.php METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>PERBAIKI DATA</B></TD></TR>
					<TR><TD>
						<INPUT TYPE=submit 				VALUE=Proses	onClick=\"return confirm('Benar proses PERBAIKI DATA akan dilakukan ?');\">
						<INPUT TYPE=hidden 	NAME=mode 	VALUE=J6U01_Perbaiki>
						</TD>
					</TR>
			</TABLE>
		</FORM>";
 	}

	function J6U01_Perbaiki()
	{
		require_once("../fungsi_umum/fungsi_bantuan.php");
		
		$modul	="PENJUALAN";
		$prd 	=periode($modul);
		$bulan	=substr($prd,-2);
		$tahun	=substr($prd,0,2);
		
		$query 	="	SELECT 	t_mstbrn.kdebrn
					FROM 	t_mstbrn";
		$db_query 	=mysql_query($query) or die('Query gagal');

		$i=0;
		while($data = mysql_fetch_array($db_query))
		{
			$cell[$i][0] 	=$data[kdebrn];
			$i++;
		}
		
		$j=0;
		while($j<$i)
		{
			$kdebrn	=$cell[$j][0];

			$query1	="	SELECT 	sum(t_dtlbmb.bny) as msk
						FROM 	t_dtlbmb,t_gnrbmb
						WHERE 	t_dtlbmb.kdebrn ='$kdebrn'				AND
								substr(t_gnrbmb.tglbmb,4,2)	='$bulan' 	AND
								substr(t_gnrbmb.tglbmb,-2)	='$tahun'	AND
								t_dtlbmb.nmrbmb=t_gnrbmb.nmrbmb";
			$result1=mysql_query($query1) or die (mysql_error());
			$tmsk	=mysql_fetch_array($result1);
			$tmsk 	=$tmsk['msk'];

			$query2	="	SELECT 	sum(t_dtlbkb.bny) as klr
						FROM 	t_dtlbkb,t_gnrbkb
						WHERE 	t_dtlbkb.kdebrn ='$kdebrn'				AND
								substr(t_gnrbkb.tglbkb,4,2)	='$bulan' 	AND
								substr(t_gnrbkb.tglbkb,-2)	='$tahun'	AND
								t_dtlbkb.nmrbkb=t_gnrbkb.nmrbkb";
			$result2=mysql_query($query2) or die (mysql_error());
			$tklr	= mysql_fetch_array($result2);
			$tklr 	=$tklr['klr'];

			$query2	="	SELECT 	sum(t_dtlpnj.bny) as klr2
						FROM 	t_dtlpnj,t_gnrpnj
						WHERE 	t_dtlpnj.kdebrn ='$kdebrn'				AND
								substr(t_gnrpnj.tglpnj,4,2)	='$bulan' 	AND
								substr(t_gnrpnj.tglpnj,-2)	='$tahun'	AND
								t_dtlpnj.nmrpnj=t_gnrpnj.nmrpnj";
			$result2=mysql_query($query2) or die (mysql_error());
			$tklr2	= mysql_fetch_array($result2);
			$tklr2 	=$tklr2['klr2'];
			
    		$query3	="	UPDATE 	t_sldbrn 
						SET		msk		='". mysql_escape_string($tmsk)."',
								klr		='". mysql_escape_string($tklr+$tklr2)."'
						WHERE 	prd	  	='$prd'		AND	
								kdebrn	='$kdebrn'";
			$q 		=mysql_query ($query3) or die (error("PENJUALAN tidak berhasil di perbaiki"));

			$j++;
		}

		echo"
		<SCRIPT TYPE='text/javascript'>
			window.alert('Proses PERBAIKI DATA sudah selesai')
		</SCRIPT>";
		
		echo"
		<meta http-equiv='refresh' content='0; url=penjualan.php'>\n"; 
	}
}	
?>