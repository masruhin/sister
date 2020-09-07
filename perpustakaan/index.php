<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: index.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: 
//----------------------------------------------------------------------------------------------------
if (isset($_SESSION["Admin"])) 
{
	session_destroy();
    echo"Anda telah melakukan login, silahkan untuk login kembali";
	
    echo"<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n"; 
}
else 
{
	if (!isset($_POST["username"]) || !isset($_POST["password"]))	
	{
?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
		<HTML>
			<HEAD>
				<TITLE> .: Login User :. </TITLE>
				<LINK rel="stylesheet" type="text/css" href="../css/stylemodul.css">
				<link href='../images/jps.ico' rel='icon' type='image/x-icon'/>
			</HEAD>

			<BODY>
				<FORM METHOD="POST" ACTION="index.php">
					<CENTER>
						<DIV class="display_white">
							<TABLE BORDER ="0" CELLSPACING="0" CELLPADDING="0">
								<TR><TD COLSPAN="3"><CENTER>.: Login User :.</CENTER></TD></TR>
								<TR><TD rowspan="3"><IMG src="../images/login.png" WIDTH="75" HEIGHT="71" ALIGN="left"/></TD>
									<TD>Username </TD><TD><INPUT type="text" NAME="username" id="uname"/></TD>
								</TR>
								<TR><TD>Password </TD><TD><INPUT type="password" NAME="password" id="pass"/></TD></TR>
								<TR><TD ALIGN="left"><INPUT type="submit" NAME="login" value="LogIn" id="submit"/></TD></TR>
							</TABLE>
						</DIV>
					</CENTER>
				</FORM>
			</BODY>
		</HTML>
<?php
	} 
	else 
	{
		require '../fungsi_umum/sysconfig.php';
		require FUNGSI_UMUM_DIR.'koneksi.php';
		require FUNGSI_UMUM_DIR.'fungsi_pass.php';
		echo"
		<HTML>\n<HEAD>\n<TITLE>Login User</TITLE>\n<LINK rel='stylesheet' type='text/css' href='../css/stylemodul.css'></HEAD>\n<BODY>\n";

		$username 	=addslashes($_POST['username']);
		$password 	=hex(addslashes($_POST['password']),82);
		$ret 		=mysql_query("	SELECT 	* 
									FROM 	t_mstkry 
									WHERE 	t_mstkry.kdekry 	='".mysql_escape_string($username)."' 		AND 
											psswrd 	='". mysql_escape_string($password) ."'");

		if (@mysql_num_rows($ret) != 0)	
		{
			$ret 					=mysql_fetch_array($ret);
			$_SESSION['Admin'] 		=$ret;
			$timeout 				=9000;
			$_SESSION["expires_by"] =time() + $timeout;
			//$username 				=$_SESSION['Admin']['username'];
			$kunjung 				=strval($_SESSION['Admin']['kunjung']) + 1;
			$tgl 					=date("H:i:s")." ".date("d/m/Y");
			$q						=mysql_query("	UPDATE  t_mstkry 
													SET 	waktu	='$tgl',
															ip		='".$_SERVER['REMOTE_ADDR']."',
															kunjung	='$kunjung' 
													WHERE 	t_mstkry.kdekry='$username' ");
			
			echo"Selamat Datang $username.. redirecting\n";
		
			echo"<meta http-equiv=\"refresh\" content=\"1;url=perpustakaan.php\">\n";	
		}
		else 
		{
			echo"
			<CENTER><DIV  class='display_red'>
			<TABLE BORDER =0 CELLPADDING=0 CELLSPACING=0>
				<TR><TD COLSPAN=2><CENTER>.: Login User :.</CENTER></TD></TR>
				<TR><TD ><IMG src='../images/login.png' ALIGN=left HEIGHT=71 WIDTH=75></TD>
					<TD>Maaf username dan password salah</TD>
				</TR>
			</TABLE>
			</DIV></CENTER>";
			
			echo"<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n"; 
		}
			
		echo"
		</BODY>\n</HTML>\n"; 
	}
}
?>