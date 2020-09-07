<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
echo"
<OPTION selected VALUE=''> --Pilih-- </OPTION>";
$kdebbt =$_GET['kdebbt'];
$sms =$_GET['sms'];
$midtrm =$_GET['midtrm'];
$kl1='1';
$kl2='2';
$kl3='3';
$kl4='4';
$kl5='5';
//$kdeplj =$_GET['kdeplj'];
if($kdebbt=='1HW')
{
echo"<OPTION VALUE='hw$sms$midtrm$kl1'>HomeWork 1</OPTION>
     <OPTION VALUE='hw$sms$midtrm$kl2'>HomeWork 2</OPTION>
	 <OPTION VALUE='hw$sms$midtrm$kl3'>HomeWork 3</OPTION>
	 <OPTION VALUE='hw$sms$midtrm$kl4'>HomeWork 4</OPTION>
	 <OPTION VALUE='hw$sms$midtrm$kl5'>HomeWork 5</OPTION>";
}
else
if($kdebbt=='2PRJ')
{
echo"<OPTION VALUE='prj$sms$midtrm$kl1'>Project 1</OPTION>
     <OPTION VALUE='prj$sms$midtrm$kl2'>Project 2</OPTION>
	 <OPTION VALUE='prj$sms$midtrm$kl3'>Project 3</OPTION>
	 <OPTION VALUE='prj$sms$midtrm$kl4'>Project 4</OPTION>
	 <OPTION VALUE='prj$sms$midtrm$kl5'>Project 5</OPTION>";
}
else
if($kdebbt=='3TES')
{
echo"<OPTION VALUE='tes$sms$midtrm$kl1'>Test 1</OPTION>
     <OPTION VALUE='tes$sms$midtrm$kl2'>Test 2</OPTION>
	 <OPTION VALUE='$sms$midtrm$kl3'>Test 3</OPTION>
	 <OPTION VALUE='tes$sms$midtrm$kl4'>Test 4</OPTION>
	 <OPTION VALUE='$sms$midtrm$kl5'>Test 5</OPTION>";
}
else
if($kdebbt=='4MID')
{
echo"<OPTION VALUE='midtes$sms$midtrm'> Mid Test 1</OPTION>
     <OPTION VALUE='midtes$sms$midtrm'>Mid Test 2</OPTION>
	";
}
?>
