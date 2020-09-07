<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: K6U02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Fungsi-fungsi PERBAIKI DATA
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class K6U02class
{
    // -------------------------------------------------- Layar Utama --------------------------------------------------
 	function K6U02()
 	{
	 	echo"
		<FORM ACTION=keuangan.php METHOD=post NAME=f1 ENCTYPE=multipart/form-data>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>PERBAIKI DATA</B></TD></TR>
			</TABLE>
			<INPUT TYPE=submit 				VALUE=Proses	onClick=\"return confirm('Benar proses PERBAIKI DATA akan dilakukan ?');\">
			<INPUT TYPE=hidden 	NAME=mode 	VALUE=K6U02_Perbaiki>
		</FORM>";
 	}

	function K6U02_Perbaiki()
	{
		require_once("../fungsi_umum/fungsi_bantuan.php");
		
		$prd 	=periode('KEUANGAN');
		$bulan	=substr($prd,-2);
		$tahun	=substr($prd,0,2);
		
		$query1	="	SELECT 	sum(t_btukng.nli) as msk
					FROM 	t_btukng
					WHERE 	substr(t_btukng.tglbtu,4,2)	='$bulan' 	AND
							substr(t_btukng.tglbtu,-2)	='$tahun'";
		$result1=mysql_query($query1) or die (mysql_error());
		$Tmsk	=mysql_fetch_array($result1);
		$Tmsk 	=$Tmsk['msk'];

		$query2	="	SELECT 	sum(t_bkukng.nli) as klr
					FROM 	t_bkukng
					WHERE 	substr(t_bkukng.tglbku,4,2)	='$bulan' 	AND
							substr(t_bkukng.tglbku,-2)	='$tahun'";
		$result2=mysql_query($query2) or die (mysql_error());
		$Tklr	= mysql_fetch_array($result2);
		$Tklr 	=$Tklr['klr'];
			
   		$query3	="	UPDATE 	t_sldkng 
					SET		msk		='". mysql_escape_string($Tmsk)."',
							klr		='". mysql_escape_string($Tklr)."'
					WHERE 	prd	  ='$prd'";
		$result3=mysql_query($query3) or die (error("KEUANGAN tidak berhasil di perbaiki"));

		echo"
		<script type='text/javascript'>
			window.alert('Proses PERBAIKI DATA sudah selesai')
		</script>";
		
		echo"<meta http-equiv='refresh' content='0'; url=keuangan.php'>\n"; 
	}
}	
?>