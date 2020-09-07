<?php
// -------------------------------------------------
function hex($str='',$code='') 
{
	if(($code>=0)and($code<100)) 
	{
		$t .=dechex(strlen($str)+$code)."g";
		$str=strrev($str);
		for($i=0;$i<=strlen($str)-1;$i++) 
		{
			$t .=dechex(ord(substr($str,$i,1))+$code);
		}
	}
	return $t;
}

// -------------------------------------------------
function unhex($str='',$code='') 
{
	$all	=explode("g",$str);
	$head	=hexdec($all[0])-$code;
	$content=$all[1];
	if($head==(strlen($content)/2)) 
	{
		for($i=0;$i<=$head-1;$i++) 
		{
			$t .=chr(hexdec(substr($content,$i*2,2))-$code);
		}
		$t =strrev($t);
	}
	return $t;
}
?>