<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: J6U02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: Fungsi-fungsi TUTUP BUKU
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<H1>Permission Denied</H1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class J6U02class
{
    // -------------------------------------------------- Layar Utama --------------------------------------------------
 	function J6U02()
 	{
	 	echo"
		<FORM ACTION=penjualan.php METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>TUTUP BUKU</B></TD></TR>
				<TABLE>
					<TR><TD>
						<INPUT TYPE=submit 				VALUE=Proses	onClick=\"return confirm('Benar proses TUTUP BUKU akan dilakukan ?');\">
						<INPUT TYPE=hidden 	NAME=mode 	VALUE=J6U02_Tutup>
						</TD>
					</TR>
				</TABLE>
			</TABLE>
		</FORM>";
 	}

	function J6U02_Tutup()
	{
		require_once("../fungsi_umum/fungsi_bantuan.php");
		
		$modul	='PENJUALAN';
		$prd 	=periode($modul);
		$tglB	=substr($prd,0,2).'-'.substr($prd,2,2).'-'.'01';
		$tglB	='01-'.substr($prd,2,2).'-'.date('Y',strtotime($tglB));
		$x=1;
		$tglB	=date('Y',strtotime($tglB)).'-'.date('m',strtotime($tglB)).'-'.date('d',$tglB);
		$tglB 	=date('d-m-Y', strtotime('+'.$x.' month', strtotime($tglB)));
		$prdB	=substr($tglB,-2).substr($tglB,3,2);

		$query 		="	UPDATE 	t_mstmdl 
						SET		prd		='$prdB'
						WHERE 	kdemdl	='PENJUALAN'";
			$q 		=mysql_query ($query);

		$query 		="	SELECT 	*
						FROM 	t_sldbrn
						WHERE 	t_sldbrn.prd ='$prd'";
		$db_query 	=mysql_query($query) or die('Query gagal');

		$i=0;
		while($data = mysql_fetch_array($db_query))
		{
			$cell[$i][0] 	=$prdB;
			$cell[$i][1] 	=$data[kdebrn];
			$cell[$i][2] 	=$data[sldawl]+$data[msk]-$data[klr];
			$i++;
		}

		$query="	DELETE 
					FROM 	t_sldbrn 
					WHERE 	prd='$prdB'";
		$result=mysql_query($query) or die ("Query failed - Mysql");
		
		$j=0;
		while($j<$i)
		{
			$prd	=$cell[$j][0];
			$kdebrn	=$cell[$j][1];
			$sldawl	=$cell[$j][2];
			
  			$query2	="	INSERT INTO t_sldbrn 
						SET			prd		='". mysql_escape_string($prd)."',
									kdebrn	='". mysql_escape_string($kdebrn)."',
									sldawl	='". mysql_escape_string($sldawl)."'";
			$q 		=mysql_query ($query2) or die (error("Proses tidak berhasil"));
			$j++;
		}

		echo"
		<SCRIPT TYPE='text/javascript'>
			window.alert('Proses TUTUP BUKU sudah selesai')
		</SCRIPT>";
		
		echo"
		<meta http-equiv='refresh' content='0; url=penjualan.php'>\n"; 
	}	
}	
?>