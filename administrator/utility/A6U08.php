<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: A6U08.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Fungsi-fungsi BACKUP FILE
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class A6U08class
{
    // -------------------------------------------------- Layar Utama --------------------------------------------------
 	function A6U08()
 	{
		echo"
		<script type='text/javascript'>
			function popup() 
			{
				popupwindow = window.open('./utility/backup/db-backup.php','','toolbar=no,location=no,scrollbars=no,resizable=no,width=200,height=100,left=500,top=200')
			}
		</script>";
		
		echo"
		<FORM ACTION=administrator.php METHOD=post NAME=f1 ENCTYPE=multipart/form-data>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>BACKUP FILE</B></TD></TR>
				<TABLE>
					<TR><TD>
							<INPUT TYPE=submit onclick=popup()				VALUE=Proses>
						</TD>
					</TR>
				</TABLE>
			</TABLE>
		</FORM>";
 	}

	function A6U08_Buat()
	{
		echo"
		<script type='text/javascript'>
			window.location='./utility/A6U08_backup.php';
		</script>
		<meta http-equiv='refresh' content='1; url=./administrator.php'>\n";
	}	
}	
?>