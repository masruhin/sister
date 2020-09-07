<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: A6U09.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: Fungsi-fungsi RESTORE
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<H1>Permission Denied</H1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class A6U09class
{
    // -------------------------------------------------- Layar Utama --------------------------------------------------
 	function A6U09()
 	{
		// form upload file dumo
		echo"
		<FORM ENCTYPE='multipart/form-data' METHOD='post' ACTION='".$_SERVER['PHP_SELF']."?mode=A6U09'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>RESTORE DATABASE</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD>DB Name : $dbname</TD></TR>
				<TR><TD>
						<INPUT TYPE='hidden' NAME='MAX_FILE_SIZE' VALUE='20000000'>
						<INPUT NAME='datafile' TYPE='file'>
						<INPUT NAME='submit' TYPE='submit' VALUE='Restore'>
					</TD>
				</TR>	
			</TABLE>	
		</FORM>";

		// proses restore data
		if ($_GET['mode'] == "A6U09")
		{
			// baca nama file
			$fileName = $_FILES['datafile']['name'];

			// proses upload file
			move_uploaded_file($_FILES['datafile']['tmp_name'], $fileName);

			// membentuk string command untuk restore
			// di sini diasumsikan letak file mysql.exe terletak di direktori C:\AppServ\MySQL\bin
			$string = 'D:\JObdesk\xampp\mysql\bin\mysql -u '.$dbuser.' -p '.$dbpasswd.' '.$dbname.' < '.$fileName;

			// menjalankan command restore di shell via PHP
			exec($string);
		}
		echo"$fileName $string";
	}
}	
?>