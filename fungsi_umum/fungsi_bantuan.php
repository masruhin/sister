<?php
//----------------------------------------------------------------------------------------------------
//Keterangan	: Fungsi-fungsi yang ada pada file fungsi_bantuan.php ini untuk memudahkan 
//				  membuat program
//Isi			: terbilang 	-> membuat angka menjadi kalimat
//				: susun_kalimat	-> menyusun kalimat menjadi array dengan batas digit
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//Fungsi		: kekata dan terbilang
//Keterangan	: fungsi kekata untuk mendukung fungsi terbilang
//				  fungsi terbilang untuk membuat angka menjadi kalimat
//Sintak		: $ktr=terbilang(angka)
//Contoh		: $ktr=terbilang(1000000)
//Catatan		: hasilnya akan berbentuk kalimat 'satu juta'
//----------------------------------------------------------------------------------------------------
function kekata($x) 
{
	$x 		=abs($x);
	$angka 	=array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp 	="";
	if($x <12) 
	{
		$temp	=" ". $angka[$x];
	} 
	else if($x <20) 
	{
		$temp 	=kekata($x - 10)." belas";
	} 
	else if($x <100) 
	{
		$temp 	=kekata($x/10)." puluh".kekata($x % 10);
	} 
	else if($x <200) 
	{
		$temp 	=" seratus".kekata($x - 100);
	} 
	else if($x <1000) 
	{
		$temp 	=kekata($x/100)." ratus".kekata($x % 100);
	} 
	else if($x <2000) 
	{
		$temp 	=" seribu".kekata($x - 1000);
	} 
	else if($x <1000000) 
	{
		$temp 	=kekata($x/1000)." ribu".kekata($x % 1000);
	} 
	else if($x <1000000000) 
	{
		$temp 	=kekata($x/1000000)." juta".kekata($x % 1000000);
	} 
	else if($x <1000000000000) 
	{
		$temp 	=kekata($x/1000000000)." milyar".kekata(fmod($x,1000000000));
	} 
	else if($x <1000000000000000) 
	{
		$temp 	=kekata($x/1000000000000)." trilyun".kekata(fmod($x,1000000000000));
	}  
	return $temp;
}
//----------------------------------------------------------------------------------------------------
function terbilang($x, $style=4) 
{
	if($x<0) 
	{
		$hasil ="minus ".trim(kekata($x));
	} 
	else 
	{
		$hasil =trim(kekata($x));
	}  
	
	switch($style) 
	{
		case 1:
			$hasil 	=strtoupper($hasil);
			break;
		case 2:
			$hasil 	=strtolower($hasil);
			break;
		case 3:
			$hasil 	=ucwords($hasil);
			break;
		default:
			$hasil 	=ucfirst($hasil);
			break;
	}  
	return $hasil;
}
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//Fungsi		: numberToWords atau number_to_words (bisa pilih salah satu)
//Keterangan	: fungsi kekata untuk mendukung fungsi terbilang
//				  fungsi terbilang untuk membuat angka menjadi kalimat (bahasa inggris)
//Sintak		: $ktr=terbilang(angka)
//Contoh		: $ktr=terbilang(1000000)
//Catatan		: hasilnya akan berbentuk kalimat 'satu juta'
//----------------------------------------------------------------------------------------------------

function numberToWords ($number)
{
	$words = array ('zero',
			'one',
			'two',
			'three',
			'four',
			'five',
			'six',
			'seven',
			'eight',
			'nine',
			'ten',
			'eleven',
			'twelve',
			'thirteen',
			'fourteen',
			'fifteen',
			'sixteen',
			'seventeen',
			'eighteen',
			'nineteen',
			'twenty',
			30=> 'thirty',
			40 => 'fourty',
			50 => 'fifty',
			60 => 'sixty',
			70 => 'seventy',
			80 => 'eighty',
			90 => 'ninety',
			100 => 'hundred',
			1000=> 'thousand');
 
	if (is_numeric ($number))
	{
		$number = (int) round($number);
		if ($number < 0)
		{
			$number = -$number;
			$number_in_words = 'minus ';
		}
		if ($number > 1000)
		{
			$number_in_words = $number_in_words . numberToWords(floor($number/1000)) . " " . $words[1000];
			$hundreds = $number % 1000;
			$tens = $hundreds % 100;
			if ($hundreds > 100)
			{
				$number_in_words = $number_in_words . ", " . numberToWords ($hundreds);
			}
			elseif ($tens)
			{
				$number_in_words = $number_in_words . " and " . numberToWords ($tens);
			}
		}
		elseif ($number > 100)
		{
			$number_in_words = $number_in_words . numberToWords(floor ($number / 100)) . " " . $words[100];
			$tens = $number % 100;
			if ($tens)
			{
				$number_in_words = $number_in_words . " and " . numberToWords ($tens);
			}
		}
		elseif ($number > 20)
		{
			$number_in_words = $number_in_words . " " . $words[10 * floor ($number/10)];
			$units = $number % 10;
			if ($units)
			{
				$number_in_words = $number_in_words . numberToWords ($units);
			}
		}
		else
		{
			$number_in_words = $number_in_words . " " . $words[$number];
		}
		return $number_in_words;
	}
	return false;
}
//----------------------------------------------------------------------------------------------------
function number_to_words($number)
{
    if (($number < 0) || ($number > 999999999))
    {
       throw new Exception("Number is out of range");
    }

    $Gn = floor($number / 1000000);  /* Millions (giga) */
    $number -= $Gn * 1000000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10;               /* Ones */ 

    $result = ""; 

    if ($Gn)
    {  $result .= number_to_words($Gn) . " Million";  } 

    if ($kn)
    {  $result .= (empty($result) ? "" : " ") . number_to_words($kn) . " Thousand"; } 

    if ($Hn)
    {  $result .= (empty($result) ? "" : " ") . number_to_words($Hn) . " Hundred";  } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n)
    {
       if (!empty($result))
       {  $result .= " and ";
       } 

       if ($Dn < 2)
       {  $result .= $ones[$Dn * 10 + $n];
       }
       else
       {  $result .= $tens[$Dn];
          if ($n)
          {  $result .= "-" . $ones[$n];
          }
       }
    }

    if (empty($result))
    {  $result = "zero"; } 

    return $result;
} 
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//Fungsi		: susun_kalimat
//Keterangan	: fungsi untuk menyusun kalimat menjadi array
//Sintak		: $ktr=susun_kalimat(kalimat,batas panjang kalimat)
//Contoh		: $ktr=susun_kalimat($kalimat,80)
//Catatan		: hasilnya akan berbentuk array	dimana @ panjangnya 80 digit
//				  digunakan untuk mencetak/menampilkan kalimat agar rapih.	
//----------------------------------------------------------------------------------------------------
function susun_kalimat($ktr,$batas) 
{
	$ktr 	=wordwrap($ktr, $batas, "<BR>");
	$ktr 	=explode("<BR>", $ktr);
	$jml	=count($ktr);
	$i=0;
	while($i<$jml)
	{
		$ktr[$i]=LTRIM($ktr[$i]);
		$i++;
	}
	return $ktr;
}
//----------------------------------------------------------------------------------------------------
?>