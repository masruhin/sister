<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: P6U03.php
//sumber		: sister
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Fungsi-fungsi GANTI PASSWORD
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class P6U03class
{
    // -------------------------------------------------- Layar Utama --------------------------------------------------
	function P6U03_Edit() 
	{
		$query 	="	SELECT 	* 
					FROM 	t_mstkry 
					WHERE 	userid = '".mysql_escape_string($_SESSION['Admin']['userid'])."'"; 
		$query_result_hANDle = mysql_query ($query) or die (mysql_error()); 
		$userinfo = mysql_fetch_array($query_result_hANDle);

	 	echo"
		<FORM ACTION=perpustakaan.php METHOD=post NAME=f1 ENCTYPE=multipart/form-data>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>GANTI PASSWORD</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH=15%>Password Baru</TD>
					<TD WIDTH=85%>: 
						<INPUT TYPE=password NAME=password SIZE=30> * (Diisi bila ingin dirubah)
					</TD>
				</TR>
				<TR><TD>Ulang Password Baru</TD>
					<TD>: <INPUT TYPE=password NAME=password2 SIZE=30></TD>
				</TR>
			</TABLE>	
			<INPUT TYPE=submit NAME=Submit 	VALUE=Simpan>
			<INPUT TYPE=reset 				VALUE=Ulang>
			<INPUT TYPE=hidden NAME=mode 	VALUE=P6U03_Save>
		</FORM>";  
	}
  
	function P6U03_Save() 
	{
		include FUNGSI_UMUM_DIR.'fungsi_pass.php';
		$password=addslashes($_POST['password']);
		$password2=addslashes($_POST['password2']);
		
		if($password <> $password2 or $password=='') 
		{
			echo"
			<script type='text/javascript'>
				window.alert('PASSWORD harus sama dan tidak boleh kosong, mohon ulang !')
			</script>";
		
			echo"<meta http-equiv='refresh' content=\"0;url=perpustakaan.php?mode=P6U03_Edit\">\n"; 		
		}
		else
		{ 
			$password 	=hex($password,82);
			$pass		="password = '".$password."',";

			$sql 	="	UPDATE 	t_mstkry 
						SET 	t_mstkry.psswrd='$password' 
						WHERE 	t_mstkry.userid = '".mysql_escape_string($_SESSION['Admin']['userid'])."'";
			$query_result_hANDle = mysql_query ($sql)   or die (mysql_error()); 

			echo"
			<script type='text/javascript'>
				window.alert('GANTI PASSWORD sudah selesai')
			</script>";
		
			echo"<meta http-equiv='refresh' content='0'; url=perpustakaan.php'>\n"; 
		}
	}
}
?>