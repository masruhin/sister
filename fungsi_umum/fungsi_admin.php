<?php
if(!defined("sister")) 
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}

//-------------------------------------------------
function admin()
{
	require 'sysconfig.php';

	echo"
	<CENTER><BR>
		<BR>Welcome to School Information Systems <B> <BR><BR><span style='color: #DA3838;font-size: 16pt'>SAINT JOHN'S SCHOOL</SPAN></B><BR><BR><BR>
			  Please select a menu available to suit your job<BR>
			  Users can access to the menu in accordance with the level of administration
	</CENTER>";
}
//-------------------------------------------------
function ujian()
{
	require 'sysconfig.php';

	echo"
	<CENTER><BR>
		$ujian
	</CENTER>";
}

//-------------------------------------------------
function error($error) 
{
	echo $error;
}

//-------------------------------------------------
function hakakses($menu)
{
	require 'sysconfig.php';
	require FUNGSI_UMUM_DIR.'koneksi.php';
	$query 	="SELECT * FROM t_akskry WHERE userid='".$_SESSION['Admin']['userid']."' and menu='$menu'";
  	$result =mysql_query ($query) or die (mysql_error());
	$data 	=mysql_num_rows($result);
	return $data;
}

//-------------------------------------------------

function errordata() 
{
    echo $_SESSION['Admin']['userid'];
	echo"
	<br><br><center><table BORDER=1 BORDERCOLOR='#000000' WIDTH='300' height='120' CELLSPACING='0'  CELLPADDING='1'>
	<TR height='30' BGCOLOR='#DB3737' ><TD><B><center>Konfirmasi</center></B></td></tr>
	<TR><TD BGCOLOR='#ffffff' ><center><img src='../images/error.gif' align='left' ><B>Maaf anda tidak berhak mengakses fasilitas ini</a></center></td></tr></table>";
}

//-------------------------------------------------
function login_check() 
{
	$exp_time = $_SESSION["expires_by"];
    if (time() < $exp_time) 
	{
        $timeout = 9000;
    	$_SESSION["expires_by"] = time() + $timeout;
        return true;
    } 
	else 
	{
        unset($_SESSION["expires_by"]);
        return false;
    }
}
?>