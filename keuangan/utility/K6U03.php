<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: K6U03.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Fungsi-fungsi TUTUP BUKU
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class K6U03class
{
    // -------------------------------------------------- Layar Utama --------------------------------------------------
 	function K6U03()
 	{
	 	echo"
		<FORM ACTION=keuangan.php METHOD=post NAME=f1 ENCTYPE=multipart/form-data>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>TUTUP BUKU</B></TD></TR>
			</TABLE>
			<INPUT TYPE=submit 				VALUE=Proses	onClick=\"return confirm('Benar proses TUTUP BUKU akan dilakukan ?');\">
			<INPUT TYPE=hidden 	NAME=mode 	VALUE=K6U03_Tutup>
		</FORM>";
 	}

	function K6U03_Tutup()
	{
		require_once("../fungsi_umum/fungsi_bantuan.php");
		
		$prd 	=periode('KEUANGAN');
		$tglB	=substr($prd,0,2).'-'.substr($prd,2,2).'-'.'01';
		$tglB	='01-'.substr($prd,2,2).'-'.date('Y',strtotime($tglB));
		$x=1;
		$tglB	=date('Y',strtotime($tglB)).'-'.date('m',strtotime($tglB)).'-'.date('d',$tglB);
		$tglB 	=date('d-m-Y', strtotime('+'.$x.' month', strtotime($tglB)));
		$prdB	=substr($tglB,-2).substr($tglB,3,2);

		$query 		="	UPDATE 	t_mstmdl 
						SET		prd		='$prdB'
						WHERE 	KdeMdl	='KEUANGAN'";
		$result 	=mysql_query ($query);

		$query 		="	SELECT 	t_sldkng.sldawl,t_sldkng.msk,t_sldkng.klr
						FROM 	t_sldkng
						WHERE 	t_sldkng.prd ='$prd'";
		$result 	=mysql_query($query) or die('Query gagal');

		$i=0;
		while($data = mysql_fetch_array($result))
		{
			$cell[$i][0] 	=$prdB;
			$cell[$i][1] 	=$data[sldawl]+$data[msk]-$data[klr];
			$i++;
		}

		$query	="	DELETE 
					FROM 	t_sldkng 
					WHERE 	t_sldkng.prd='$prdB'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		$j=0;
		while($j<$i)
		{
			$prd	=$cell[$j][0];
			$sldawl	=$cell[$j][1];
			
  			$query	="	INSERT INTO t_sldkng 
						SET			t_sldkng.prd	='". mysql_escape_string($prd)."',
									t_sldkng.sldawl	='". mysql_escape_string($sldawl)."'";
			$result =mysql_query ($query) or die (error("Proses tidak berhasil"));
			$j++;
		}
		
		echo"
		<script type='text/javascript'>
			window.alert('Proses TUTUP BUKU sudah selesai')
		</script>";
		
		echo"<meta http-equiv='refresh' content='0'; url=keuangan.php'>\n"; 
	}	
}	
?>