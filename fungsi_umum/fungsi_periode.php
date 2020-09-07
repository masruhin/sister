<?php
//----------------------------------------------------------------------------------------------------
//Keterangan	: Fungsi-fungsi yang ada pada file fungsi_periode.php ini berhubungan dengan periode
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//Fungsi		: periode
//Keterangan	: fungsi untuk mendapatkan periode berjalan
//Sintak		: $prd=periode(nama_modul)
//Contoh		: $prd=periode("PENJUALAN")
//Catatan		: hasilnya akan berbentuk angka "9999" ->2 digit tahun dan 2 digit bulan
//----------------------------------------------------------------------------------------------------
function periode($modul) 
{
	$query 	=mysql_query("	SELECT 	* 
							FROM 	t_mstmdl 
							WHERE 	kdemdl	='$modul'");
	$data 	=mysql_fetch_assoc($query);
	$prd 	=$data[prd];	
	return $prd;
}
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//Fungsi		: tgltoprd
//Keterangan	: fungsi untuk merubah format tanggal menjadi periode (tahun dan bulan)
//Sintak		: $prdB=tgltoprd(tanggal)
//Contoh		: $prdB=tgltoprd('01-10-2011')
//Catatan		: hasilnya akan berbentuk angka "1110" ->tahun 2011, bulan 10
//----------------------------------------------------------------------------------------------------
function tgltoprd($tgl) 
{
	$prdB	=substr($tgl,-2).substr($tgl,3,2);
	return $prdB;
}
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
//Fungsi		: prdtotgl
//Keterangan	: fungsi untuk merubah format periode (tahun dan bulan) menjadi format bulan dan tahun di tambah n bulan
//Sintak		: $prdB=prdtotgl($prd,1,$plh)	
//Contoh		: 1. $prdB=prdtotgl('1206',1,'N')    2. $prdB=prdtotgl('1206',1,'A')
//Catatan		: 1. hasilnya akan berbentuk format "JULI 2012" 
//				  2. hasilnya akan berbentuk format "1207"
//				: $plh ada 2 'N' -> nama, atau 'A' -> angka
//----------------------------------------------------------------------------------------------------
function prdtotgl($prd,$n=0,$plh='N') 
{
	$tgl	=substr($prd,0,2).'-'.substr($prd,2,2).'-'.'01';
	$tgl	='01-'.substr($prd,2,2).'-'.date('Y',strtotime($tgl));
	$tgl	=date('Y',strtotime($tgl)).'-'.date('m',strtotime($tgl)).'-'.date('d',$tgl);
	$tgl 	=date('d-m-Y', strtotime('+'.$n.' month', strtotime($tgl)));
	if($plh=='A')
		$periode	=substr($tgl,-2).substr($tgl,3,2);
	if($plh=='N')	
		$periode=tanggal('M',$tgl).' '.tanggal('Y',$tgl);	
		
	return $periode;
}
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
//Fungsi		: tanggal
//Keterangan	: fungsi untuk mengganti format tanggal ke indonesia (seperti fungsi date)
//Sintak		: tanggal($format,$nilai="now")
//Contoh		: misalkan hari ini tanggal 13 maret 2011
//				  echo date("D, j M Y");						//keluaran Sun, 13 Mar 2011
//				  echo tanggal("D, j M Y");						//keluaran Minggu, 13 Maret 2011
//				  echo tanggal("M")."<br/>";					//keluaran Maret
//				  echo tanggal("D")."<br/>";					//keluaran Minggu
//				  echo tanggal("D, j M Y","1988-06-02");		//keluaran Kamis, 2 Juni 19688
//				  echo tanggal("D","1988-06-02");				//keluaran Kamis
//				  echo tanggal("M","1988-06-02");				//keluaran Juni
//Catatan		: sama seperti fungsi date()
// 				  untuk bahasa, gunakan salah satu $id dibawah ini
//				  $id=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
//				  $id=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
//----------------------------------------------------------------------------------------------------
function tanggal($format,$nilai="now"){
$en=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

$id=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
return str_replace($en,$id,date($format,strtotime($nilai)));
}
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
//Fungsi		: bod
//Keterangan	: fungsi membentuk tanggal 1 dari periode 9999 (begin of date)
//Sintak		: bod('1307')
//Contoh		: misalkan periode saat ini 1307
//				  echo bod("1307");						//keluaran 01-07-2013
//----------------------------------------------------------------------------------------------------
function bod($prd)
{
	$tgl	=substr($prd,0,2).'-'.substr($prd,-2).'-'.'01';
	$tgl	='01-'.substr($prd,-2).'-'.date('Y',strtotime($tgl));
	return $tgl;
}
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
//Fungsi		: eod
//Keterangan	: fungsi membentuk tanggal terakhir dari periode 9999 (end of date)
//Sintak		: eod('1307')
//Contoh		: misalkan periode saat ini 1307
//				  echo eod("1307");						//keluaran 31-07-2013
//----------------------------------------------------------------------------------------------------
function eod($prd)
{
	$bln	=substr($prd,-2);
	$thn	=substr($prd,0,2);
	$tgl	=date('d-m-Y',strtotime('-1 second',strtotime('+1 month',strtotime(date($bln).'/01/'.date($thn).' 00:00:00'))));
	return $tgl;
}
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
//Fungsi		: combo
//Keterangan	: fungsi untuk menampilkan isian tanggal,bulan dan tahun
//Sintak		: 
//Contoh		: 
//Catatan		: untuk bahasa, gunakan salah satu $nama_bln dibawah ini
//				  $nama_bln=array(1=> "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
//				  $nama_bln=array(1=> "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
//----------------------------------------------------------------------------------------------------
function combotgl($awal, $akhir, $var, $terpilih)
{
	echo"<select name=$var>";
		for ($i=$awal; $i<=$akhir; $i++)
		{
			$lebar=strlen($i);
			switch($lebar)
			{
				case 1:
				{
					$g="0".$i;
					break;     
				}
				case 2:
				{
					$g=$i;
					break;     
				}      
			}  
			if($i==$terpilih)
				echo"<option value=$g selected>$g</option>";
			else
				echo"<option value=$g>$g</option>";
		}
	echo"</select> ";
}

function combobln($awal, $akhir, $var, $terpilih)
{
	echo"<select name=$var>";
		for ($bln=$awal; $bln<=$akhir; $bln++)
		{
			$lebar=strlen($bln);
			switch($lebar)
			{
				case 1:
				{
					$b="0".$bln;
					break;     
				}
				case 2:
				{
					$b=$bln;
					break;     
				}      
			}  
			if($bln==$terpilih)
				echo"<option value=$b selected>$b</option>";
			else
				echo"<option value=$b>$b</option>";
		}
	echo"</select> ";
}

function combothn($awal, $akhir, $var, $terpilih)
{
	echo"<select name=$var>";
		for($i=$awal; $i<=$akhir; $i++)
		{
			if($i==$terpilih)
				echo"<option value=$i selected>$i</option>";
			else
				echo"<option value=$i>$i</option>";
		}
	echo"</select> ";
}

function combonamabln($awal, $akhir, $var, $terpilih)
{
	$nama_bln=array(1=> "Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
	echo"<select name=$var>";
	for($bln=$awal; $bln<=$akhir; $bln++)
	{
		if($bln==$terpilih)
			echo"<option value=$bln selected>$nama_bln[$bln]</option>";
		else
			echo"<option value=$bln>$nama_bln[$bln]</option>";
	}
	echo"</select> ";
}
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
//Fungsi		: adddate
//Keterangan	: fungsi untuk menambah tanggal,bulan, tahun
//Sintak		: 
//Contoh		: adddate("2010-08-01","+1 day"); -> hasil 2010-08-02
//Catatan		: +1 day, +3 day, + 1 month, +1 year, -3 day, -10 day
//----------------------------------------------------------------------------------------------------
function adddate($vardate,$added)
{
	$data = explode("-", $vardate);
	$date = new DateTime();
	$date->setDate($data[0], $data[1], $data[2]);
	$date->modify("".$added."");
	$day= $date->format("Y-m-d");
	return $day;
}

//----------------------------------------------------------------------------------------------------
//Fungsi		: selisihtgl
//Keterangan	: fungsi untuk mendapatkan selisih tanggal
//Sintak		: selisihtgl($tgl1,$tgl2);
//Contoh		: selisihtgl("01-08-2013","10-08-2013"); -> hasil 9
//Catatan		: 
//----------------------------------------------------------------------------------------------------
function selisihtgl($tgl1,$tgl2)
{
	$selisih = strtotime($tgl1) -  strtotime($tgl2);
	$hari = $selisih/(60*60*24);
	return $hari;
}
?>