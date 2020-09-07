<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: K6U04.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: Fungsi-fungsi GANTI PASSWORD
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<H1>Permission Denied</H1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class K6U04class
{
    // -------------------------------------------------- Layar Utama --------------------------------------------------
	function K6U04_Edit() 
	{
		$query 	="	SELECT 	t_mstkry.* 
					FROM 	t_mstkry 
					WHERE 	t_mstkry.userid = '".mysql_escape_string($_SESSION['Admin']['userid'])."'"; 
		$result = mysql_query ($query) 
		or die (mysql_error()); 
		$userinfo = mysql_fetch_array($result);

	 	echo"
		<FORM ACTION='keuangan.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>GANTI PASSWORD</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Password Baru</TD>
					<TD WIDTH='85%'>: <INPUT TYPE=password NAME=password SIZE=30> * (Diisi bila ingin dirubah)</TD>
				</TR>
				<TR><TD>Ulang Password Baru</TD>
					<TD>: <INPUT TYPE=password NAME=password2 SIZE=30></TD>
				</TR>
			</TABLE>	
			<INPUT TYPE=submit NAME=Submit 	VALUE=Simpan>
			<INPUT TYPE=reset 				VALUE=Ulang>
			<INPUT TYPE=hidden NAME=mode 	VALUE=K6U04_Save>
		</FORM>";  
	}
  
	function K6U04_Save() 
	{
        require FUNGSI_UMUM_DIR.'koneksi.php';
		include FUNGSI_UMUM_DIR.'fungsi_pass.php';
		$password=addslashes($_POST['password']);
		$password2=addslashes($_POST['password2']);
		
		if($password <> $password2 or $password=='') 
		{
			echo"
			<SCRIPT TYPE='text/javascript'>
				window.alert('PASSWORD harus sama dan tidak boleh kosong, mohon ulang !')
			</SCRIPT>";
		
			echo"<meta http-equiv='refresh' content=\"0;url=keuangan.php?mode=K6U04_Edit\">\n"; 		
		}
		else
		{ 
			$password 	=hex($password,82);
			$pass		="password = '".$password."',";

			$query 	="	UPDATE 	t_mstkry 
						SET 	t_mstkry.psswrd='$password' 
						WHERE 	t_mstkry.userid 	='".mysql_escape_string($_SESSION['Admin']['userid'])."'";
			$result = mysql_query ($query)   or die (mysql_error()); 

			echo"
			<SCRIPT TYPE='text/javascript'>
				window.alert('GANTI PASSWORD sudah selesai')
			</SCRIPT>";
		
			echo"<meta http-equiv='refresh' content='1; url=keuangan.php'>\n"; 
		}
	}
}
?>