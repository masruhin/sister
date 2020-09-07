<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: S6U01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: Fungsi-fungsi GANTI PASSWORD
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<H1>Permission Denied</H1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class S6U01class
{
    // -------------------------------------------------- Layar Utama --------------------------------------------------
	function S6U01()
	{
		$user	=$_SESSION["Admin"]["nis"];
		$query 	="	SELECT 	* 
					FROM 	t_mstssw
					WHERE 	t_mstssw.nis = '".mysql_escape_string($_SESSION['Admin']['nis'])."'"; 
		$result = mysql_query ($query) or die (mysql_error()); 
		$userinfo = mysql_fetch_array($result);

	 	echo"
		<FORM ACTION='siswa.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
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
			<INPUT TYPE=hidden NAME=mode 	VALUE=S6U01_Save>
		</FORM>";  
	}

	function S6U01_Save() 
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
		
			echo"<meta http-equiv='refresh' content=\"0;url=siswa.php?mode=S6U01_Edit\">\n"; 		
		}
		else
		{ 
			$password 	=hex($password,82);
			$pass		="password = '".$password."',";

			$query 	="	UPDATE 	t_mstssw 
						SET 	t_mstssw.psswrd='$password' 
						WHERE 	t_mstssw.nis 	='".mysql_escape_string($_SESSION['Admin']['nis'])."'";
			$result = mysql_query ($query)   or die (mysql_error()); 

			echo"
			<SCRIPT TYPE='text/javascript'>
				window.alert('GANTI PASSWORD sudah selesai')
			</SCRIPT>";
		
			echo"<meta http-equiv='refresh' content='1; url=siswa.php'>\n";
		}
	}

    function S6U01OT()
	{
		$user	=$_SESSION["Admin"]["nis"];
		$query 	="	SELECT 	*
					FROM 	t_mstssw
					WHERE 	t_mstssw.nis = '".mysql_escape_string($_SESSION['Admin']['nis'])."'";
		$result = mysql_query ($query) or die (mysql_error());
		$userinfo = mysql_fetch_array($result);

	 	echo"
		<FORM ACTION='orangtua.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
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
			<INPUT TYPE=hidden NAME=mode 	VALUE=S6U01OT_Save>
		</FORM>";
	}

	function S6U01OT_Save()
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

			echo"<meta http-equiv='refresh' content=\"0;url=orangtua.php?mode=S6U01_Edit\">\n";
		}
		else
		{
			$password 	=hex($password,82);
			$pass		="password = '".$password."',";

			$query 	="	UPDATE 	t_mstssw
						SET 	t_mstssw.psswrdot='$password'
						WHERE 	t_mstssw.nis 	='".mysql_escape_string($_SESSION['Admin']['nis'])."'";
			$result = mysql_query ($query)   or die (mysql_error());

			echo"
			<SCRIPT TYPE='text/javascript'>
				window.alert('GANTI PASSWORD sudah selesai')
			</SCRIPT>";

			echo"<meta http-equiv='refresh' content='1; url=orangtua.php'>\n";
		}
	}
}
?>