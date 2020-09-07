<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Absen</title>
   <style type="text/css">
    div {text-align:center;
         position:absolute;
         top:50%;
         left:0%;
         width:100%;
		 font-family 	: tahoma;
		font-weight 	: bold;
		font-size 		: 20px;
		color			: #1F437F;
         }
    </style>
</head>

<body>

<?php
require("../fungsi_umum/sysconfig.php");
require FUNGSI_UMUM_DIR.'koneksi.php';
//require FUNGSI_UMUM_DIR.'clock.php';
//require FUNGSI_UMUM_DIR.'fungsi_admin.php';

$tgl =date("d-m-Y");
$jam =date("h:i:s");
echo"
<SCRIPT language='javascript'>
		//agar kursor keposisi isian kode buku
		function sf()
			{ document.f1.absen.focus();
			}
		</SCRIPT>
<body onload=sf();>
<FORM ID='validasi'  METHOD='post' NAME='f1' ACTION='info.php'>
<div>
	absen<br>
	<input type='text' name='absen' id='absen' class='absen'>
	<input type='hidden' name='tglabs' id='tglabs' class='tglabs' value='$tgl'>
	<input type='hidden' name='jamabs' id='jamabs' class='jamabs' value='$jam'>
	<INPUT type='submit' NAME='login' value='Absen' id='submit' hidden/>
</div>
</FORM></body>" ;
?>

</body>

</html>
