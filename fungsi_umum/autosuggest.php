<?php
require 'sysconfig.php';
require FUNGSI_UMUM_DIR.'koneksi.php';

if(isset($_GET['suggest']) && isset($_GET['letters']))
{
	$letters = $_GET['letters'];
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$res = mysql_query("select * from t_mstbrn where nmabrn like '".$letters."%'") or die(mysql_error());
	#echo "1###select ID,countryName from ajax_countries where countryName like '".$letters."%'|";
	while($inf = mysql_fetch_array($res)){
		echo $inf["kdebrn"]."###".$inf["nmabrn"]."|";
	}
}
?>