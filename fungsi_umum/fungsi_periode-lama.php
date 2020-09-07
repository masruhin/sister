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
//Keterangan	: fungsi untuk merubah format periode (tahun dan bulan) menjadi format bulan dan tahun
//Sintak		: $prdB=prdtotgl($prd)
//Contoh		: $prdB=prdtotgl('1206')
//Catatan		: hasilnya akan berbentuk format "JUNI 2012" 
//----------------------------------------------------------------------------------------------------
function prdtotgl($prd) 
{
	$tgl	=substr($prd,0,2).'-'.substr($prd,-2).'-01';
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
//----------------------------------------------------------------------------------------------------
function tanggal($format,$nilai="now"){
$en=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

$id=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu",
"Jan","Feb","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
return str_replace($en,$id,date($format,strtotime($nilai)));
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