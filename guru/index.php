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
    require("../fungsi_umum/sysconfig.php");
    echo"
	<center><b>Anda Berhasil Log Out</b><br>
                 <img src='../images/ajax-loader.gif'></center>";

    echo"
	<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
}
else
{
	if (!isset($_POST["username"]) || !isset($_POST["psswrd"]))
	{
	  $tgl 	=date("j F Y");
	  require '../fungsi_umum/sysconfig.php';
      require FUNGSI_UMUM_DIR.'clock.php';

?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
		<HTML>
			<HEAD>
				<TITLE> .: Login User :. </TITLE>

                <LINK rel='stylesheet' type='text/css' href='../css/styleindex.css'>
				<link href='../images/jps.ico' rel='icon' type='image/x-icon'/>
            	</HEAD>
                <BODY TOPMARGIN=0 LEFTMARGIN=0 RIGHTMARGIN=0 background=''>

			<TABLE ALIGN=CENTER WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>
				<TR><TD WIDTH='500'><IMG src='../images/atas_admin_kiri_light.jpg' HEIGHT='100' WIDTH='500'></TD>
					<TD WIDTH='50%' HEIGHT='100' BGCOLOR='#F1F1F1'></TD>
					<TD WIDTH='300'><IMG src='../images/atas_admin_kanan_light.jpg' HEIGHT='100' WIDTH='300'></TD>
				</TR>
			</TABLE>

                <TABLE ALIGN=CENTER WIDTH='100%' BORDER='0' BORDERCOLOR='#ffffff' CELLPADDING='0' CELLSPACING='0'>
                <TR>
					<td width='10%'></td>
                    <td ALIGN='left' width='55%' VALIGN='TOP'>
						<DIV class="display_white">
						<marquee onmouseout='this.start()' direction='up' scrollamount='2' height='250' onmouseover='this.stop()' bgcolor='#000000' style='border:0px solid #000000; padding-left: 0px; padding-right: 0px; padding-top:0px; padding-bottom:0px; background-color:#FFFFFF' width='100%'>
						<span style='color: #FF0000; font-size: 1em;'><b>WELCOME TO...<br><br>
						<span style='color: #FF0000; font-size: 5em;'><i>SISTER</i></B><br></span>
						<span style='color: #FF0000; font-size: 1.2em;'><i><B>S</B>ISTEM <B>I</B>NFORMASI <B>S</B>EKOLAH <B>TER</B>PADU</i></B></span>
						</marquee>
						</div>

					</td>

                    <TD ALIGN='CENTER' width='25%' VALIGN='TOP'>
						<DIV class="display_grey">
                        <FORM METHOD="POST"  name="f1"ACTION="index.php">
							<TABLE BORDER ="0" CELLSPACING="0" CELLPADDING="0">
								<TR><TD HEIGHT='10'></TD></TR>
								<TR><TD COLSPAN="3" align='right'><FONT class='adminhead3'><b>SJS-Access</b></font></CENTER></TD></TR>
								<TR><TD HEIGHT='10'></TD></TR>
								<TR><TD><p style='font-size:15px'>Sign in</p></CENTER></TD></TR>
								<TR><TD HEIGHT='10'></TD></TR>
								<TR><TD><b>Username</b></TD></TR>
								<TR><TD><INPUT type="text" SIZE	='30'  NAME="username" id="username" class="username"/></TD></TR>
								<TR><TD HEIGHT='10'></TD></TR>
								<TR><TD><b>Password</b></TD></TR>
								<TR><TD><INPUT type="password" SIZE	='30' NAME="psswrd" id="pass"/></TD></TR>
								<TR><TD HEIGHT='10'></TD></TR>
								<TR><TD ALIGN="LEFT"><INPUT type="submit" NAME="login" value="Sign in" id="submit"/></TD></TR>
								<TR><TD HEIGHT='20'><FONT class='adminhead2'><i>* please contact IT division <br>&nbsp if you forget your username and password</i></font></TD></TR>
							</TABLE>
                            </FORM>
						</DIV>
                        </TD>
						<td width='10%'></td></TR>
						<tr><TD colspan='3' valign='top' align='right'><a href='../ujian_online/index.php'>Test Online</a></td></tr>
						<?php
						echo"
				<TR><TD></TD><TD HEIGHT='10' BGCOLOR='#ffffff'><FONT class='adminhead'>Copyright &copy 2020 - SAINT JOHN'S SCHOOL</FONT></TD>
					<TD ALIGN='right'><FONT class='adminhead'>Versi $versi <B>Best viewed with Mozilla Firefox</B></FONT></TD><TD></TD>";
				?>	
				</TABLE>
				
				

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

		<HTML>\n<HEAD>\n<TITLE>Login</TITLE>\n</HEAD>\n<BODY>\n";

        $username 	=$_POST['username'];
        $ret1 		=mysql_query("	SELECT 	*
									FROM  t_mstkry
									WHERE 	usernm	='".mysql_escape_string($username)."'
											 limit 0,1"); // WHERE 	kdekry	='".mysql_escape_string($username)."'
       while($dt=mysql_fetch_array($ret1))
       {
         $kdekr=$dt['kdekry'];
			$usernm = $dt['usernm'];
       }


        //if($username==$kdekr)
		if($username==$usernm) // tambah buatan
        {

			$password 	=$_POST['psswrd'];
			$password 	=hex($password,82);
			$ret 		=mysql_query("	SELECT 	*
										FROM  t_mstkry
										WHERE 	usernm	='".mysql_escape_string($username)."' 		AND
												psswrd ='". mysql_escape_string($password) ."'
												 limit 0,1"); // WHERE 	kdekry	='".mysql_escape_string($username)."'

			 if (@mysql_num_rows($ret) != 0)
			{
				$ret 					=mysql_fetch_array($ret);
				$_SESSION['Admin'] 		=$ret;
				$timeout 				=9000;
				$_SESSION["expires_by"] =time() + $timeout;
				$username 				=$_SESSION['Admin']['kdekry'];
				$nmakry				=$_SESSION['Admin']['nmakry'];
				$kunjung 				=strval($_SESSION['Admin']['kunjung']) + 1;
				$tgl 					=date("H:i:s")." ".date("d/m/Y");
				$q						=mysql_query("	UPDATE  user
													SET 	waktu	='$tgl',
															ip		='".$_SERVER['REMOTE_ADDR']."',
															kunjung	='$kunjung'
													WHERE 	username='$username' ");

              	echo"<center><b>Welcome...$nmakry</b><br>
                 <img src='../images/ajax-loader.gif'></center>";
              echo"<meta http-equiv=\"refresh\" content=\"1;url=guru.php\">\n";
            }
			else
			{
				echo"
				$ErrorLogin";

				echo"<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
			}
        }
        else
		if(substr($username,0,1)=="P")
        {
          $username=substr($username,1);


		$password 	=$_POST['psswrd'];
		$password 	=hex($password,82);
		$ret 		=mysql_query("	SELECT 	*
									FROM  t_mstssw
									WHERE 	nis	='".mysql_escape_string($username)."' 		AND
											psswrdot ='". mysql_escape_string($password) ."'
											 limit 0,1");

         if (@mysql_num_rows($ret) != 0)
		{
			$ret 					=mysql_fetch_array($ret);
			$_SESSION['Admin'] 		=$ret;
			$timeout 				=9000;
			$_SESSION["expires_by"] =time() + $timeout;
			$username 				=$_SESSION['Admin']['nis'];
            $nmassw 				=$_SESSION['Admin']['nmassw'];
			$kunjung 				=strval($_SESSION['Admin']['kunjung']) + 1;
			$tgl 					=date("H:i:s")." ".date("d/m/Y");
			$q						=mysql_query("	UPDATE  user
													SET 	waktu	='$tgl',
															ip		='".$_SERVER['REMOTE_ADDR']."',
															kunjung	='$kunjung'
													WHERE 	username='$username' ");

              	echo"<center><b>Welcome...$nmassw</b><br>
                 <img src='../images/ajax-loader.gif'></center>";
              echo"<meta http-equiv=\"refresh\" content=\"1;url=../siswa/orangtua.php\">\n";
            }
		else
		{
			echo"
			$ErrorLogin";

			echo"<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
		}
            }

        else
        {
          $username 	=$_POST['username'];
           //$Parent='P'.$username;
           //$welcome='Selamat Datang Orang Tua'.$username;

		$password 	=$_POST['psswrd'];
		$password 	=hex($password,82);
		$ret 		=mysql_query("	SELECT 	*
									FROM  t_mstssw
									WHERE 	nis	='".mysql_escape_string($username)."' 		AND
											psswrd 	='". mysql_escape_string($password) ."'
											 limit 0,1");



		if (@mysql_num_rows($ret) != 0)
		{
			$ret 					=mysql_fetch_array($ret);
			$_SESSION['Admin'] 		=$ret;
			$timeout 				=9000;
			$_SESSION["expires_by"] =time() + $timeout;
			$username 				=$_SESSION['Admin']['nis'];
            $nmassw 				=$_SESSION['Admin']['nmassw'];
			$kunjung 				=strval($_SESSION['Admin']['kunjung']) + 1;
			$tgl 					=date("H:i:s")." ".date("d/m/Y");
			$q						=mysql_query("	UPDATE  user
													SET 	waktu	='$tgl',
															ip		='".$_SERVER['REMOTE_ADDR']."',
															kunjung	='$kunjung'
													WHERE 	username='$username' ");

             	echo"<center><b>Welcome...$nmassw</b><br>
                 <img src='../images/ajax-loader.gif'></center>";
              echo"<meta http-equiv=\"refresh\" content=\"1;url=../siswa/siswa.php\">\n";
            }


		else
		{
			echo"
			$ErrorLogin";

			echo"<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
		}
		echo"</BODY>\n</HTML>\n";
	}
    }
}
?>
