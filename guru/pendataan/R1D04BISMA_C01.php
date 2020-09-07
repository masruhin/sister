<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LSMP7_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdeplj	=$_POST['kdeplj'];
$kdekls	=$_POST['kdekls'];//nis
$sms	=$_POST['sms'];
$midtrm	='2';//$_POST['midtrm'];
$tglctk	=$_POST['tglctk'];
if($tglctk=='')
{
	$tglctk	=date('F d, Y');
}
else
{	
	$tglctk	=strtotime($tglctk);
	$tglctk	=date('F d, Y',$tglctk);
}	

// dapatkan data tahun ajaran
$query	="	SELECT 		t_setthn_smp.*
			FROM 		t_setthn_smp
			WHERE		t_setthn_smp.set='Tahun Ajaran'";
$result	=mysql_query($query) or die('Query gagal1g');
$data 	=mysql_fetch_array($result);
$thnajar3=$data[nli];

if($sms=='1')
	$semester3='I / Ganjil';
else if($sms=='2')
	$semester3='II / Genap';

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='1HW'";
$result	=mysql_query($query) or die('Query gagal1a');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='2PRJ'";
$result	=mysql_query($query) or die('Query gagal1b');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='3TES'";
$result	=mysql_query($query) or die('Query gagal1c');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='4MID'";
$result	=mysql_query($query) or die('Query gagal1d');
$data 	=mysql_fetch_array($result);
$bbtmidtes=$data[bbt];

// dapatkan data guru 
$query 	="	SELECT 		t_mstpng.*
			FROM 		t_mstpng
			WHERE 		t_mstpng.kdekls='". mysql_escape_string($kdekls)."' AND
						t_mstpng.kdeplj='". mysql_escape_string($kdeplj)."'";
$result =mysql_query($query) or die('Query gagal2');
$data 	=mysql_fetch_array($result);
$kdegru=$data[kdegru];

$query 	="	SELECT 		t_mstkry.*
			FROM 		t_mstkry
			WHERE 		t_mstkry.kdekry='". mysql_escape_string($kdegru)."'";
$result =mysql_query($query) or die('Query gagal2');
$data 	=mysql_fetch_array($result);
$nmagru=$data[nmakry];

$query 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.nis='". mysql_escape_string($kdekls)."'";
$result =mysql_query($query) or die('Query gagal2');
$data 	=mysql_fetch_array($result);
$nisn=$data[nisn];
$nmassw=$data[nmassw];
$nmapgl=$data[nmapgl];
$kkelas=$data[kdekls];
$tmplhr=$data[tmplhr];
$tgllhr=$data[tgllhr];
$jnsklm=$data[jnsklm];
$kdeagm=$data[kdeagm];
$tgllhr=strtotime($tgllhr);
$tgllhr=date('d F Y',$tgllhr);

//$nmaibu =$data[nmaibu];
//$nmaayh	=$data[nmaayh];
$almt	=$data[alm];
//$pkjayh =$data[pkjayh];
//$pkjibu =$data[pkjibu];
//$hpaayh =$data[hpaayh];

$tlp	=$data[tlp];
$glndrh	=$data[glndrh];
$anakke =$data[anakke];
$sklasl	=$data[sklasl];

$nmaayh =$data[nmaayh];
$almayh =$data[almayh];
$tlpayh =$data[tlpayh];
$hpaayh	=$data[hpaayh];
$agmayh =$data[agmayh];
$pkjayh =$data[pkjayh];

$nmaibu =$data[nmaibu];
$almibu =$data[almibu];
$tlpibu =$data[tlpibu];
$hpaibu	=$data[hpaibu];
$agmibu =$data[agmibu];
$pkjibu =$data[pkjibu];

$nmawli =$data[nmawli];
$almwli =$data[almwli];
$tlpwli =$data[tlpwli];
$hpawli	=$data[hpawli];
$agmwli =$data[agmwli];
$pkjwli =$data[pkjwli];



	


$pdf =new FPDF('P','cm','A4');
$pdf->SetMargins(0.1,0.1,0.1);
$pdf->SetAutoPageBreak(True, 0.05);







	
	



if($sklasl=='SJSM')
	$sklasl="Saint John's School Meruya";

if($jnsklm=='P')
	$jnsklm='Perempuan';
else if($jnsklm=='L')
	$jnsklm='Laki-laki';

if($kdeagm=='1')
	$kdeagm='Islam';
else if($kdeagm=='2')
	$kdeagm='Katolik';
else if($kdeagm=='3')
	$kdeagm='Protestan';
else if($kdeagm=='4')
	$kdeagm='Budha';
else if($kdeagm=='5')
	$kdeagm='Hindu';
else if($kdeagm=='6')
	$kdeagm='Lainnya';



//awal halaman 1

$j=0;
//while($j<$i)
//{
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "LEMBAR BUKU INDUK SISWA SMA", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Nomor Induk Siswa : ".substr($kdekls,0,3), '', 0, C, true);//...............................
	$pdf->Ln(0.6);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 19.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Lembar ke : ..............", '', 0, R, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "A.", '', 0, L, true);
	$pdf->Cell(1.5, 0.6, "KETERANGAN TENTANG DIRI SISWA", '', 0, L, true);
	$pdf->Cell( 5	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "1.     Nama siswa", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        a.   Nama Lengkap", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $nmassw, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        b.   Nama Panggilan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $nmapgl, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "2.     Jenis kelamin", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $jnsklm, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "3.     Tempat dan tanggal lahir", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $tmplhr . ', ' . $tgllhr, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "4.     Agama", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $kdeagm, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "5.     Kewarganegaraaan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);//
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "6.     Anak keberapa", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $anakke, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "7.     Jumlah saudara kandung", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "8.     Jumlah saudara tiri", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "9.     Jumlah saudara angkat", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "10.   Anak Yatim / piatu / yatim piatu", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "11.   Bahasa sehari-hari dirumah", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "B.", '', 0, L, true);
	$pdf->Cell(1.5, 0.6, "KETERANGAN TEMPAT TINGGAL", '', 0, L, true);
	$pdf->Cell( 5	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "12.   Alamat", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $almt, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "13.   Nomor telepon", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $tlp, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "14.   Tinggal dengan orang tua / saudara", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        Di Asrama / Kost", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "15.   Jarak tempat tinggal ke Sekolah", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "C.", '', 0, L, true);
	$pdf->Cell(1.5, 0.6, "KETERANGAN KESEHATAN", '', 0, L, true);
	$pdf->Cell( 5	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "16.   Golongan Darah", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $glndrh, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "17.   Penyakit yang pernah diderita,", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        TBC / Cacar / Malaria dan lain-lain", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "18.   Kelainan jasmani", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "19.   Tinggi dan berat badan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "D.", '', 0, L, true);
	$pdf->Cell(1.5, 0.6, "KETERANGAN PENDIDIKAN", '', 0, L, true);
	$pdf->Cell( 5	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "20.   Pendidikan sebelumnya", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        a.   Lulusan dari", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $sklasl, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        b.   Tanggal dan nomor STTB", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        c.   Lama belajar", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "21.   Pindahan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        a.   Dari Sekolah", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        b.   Alasan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "22.   Diterima di sekolah ini", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        a.   Di Tingkat", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        b.   Kelompok", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        c.   Jurusan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        d.   Tanggal", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	
	
	//awal halaman 2
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "E.", '', 0, L, true);
	$pdf->Cell(2.5, 0.6, "KETERANGAN TENTANG AYAH KANDUNG", '', 0, L, true);
	$pdf->Cell( 5	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "23.   Nama", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $nmaayh, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "24.   Tempat dan tanggal lahir", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "25.   Agama", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $agmayh, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "26.   Kewarganegaraaan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "27.   Pendidikan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "28.   Pekerjaan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $pkjayh, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "29.   Penghasilan per bulan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "30.   Alamat Rumah / Nomor Telepon", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "31.   Masih hidup / meninggal dunia tahun", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "F.", '', 0, L, true);
	$pdf->Cell(2.5, 0.6, "KETERANGAN TENTANG IBU KANDUNG", '', 0, L, true);
	$pdf->Cell( 5	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "32.   Nama", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $nmaibu, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "33.   Tempat dan tanggal lahir", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "34.   Agama", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $agmayh, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "35.   Kewarganegaraaan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "36.   Pendidikan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "37.   Pekerjaan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $pkjibu, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "38.   Penghasilan per bulan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "39.   Alamat Rumah / Nomor Telepon", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "40.   Masih hidup / meninggal dunia tahun", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "G.", '', 0, L, true);
	$pdf->Cell(2.5, 0.6, "KETERANGAN TENTANG WALI", '', 0, L, true);
	$pdf->Cell( 5	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "41.   Nama", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $nmawli, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "42.   Tempat dan tanggal lahir", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "43.   Agama", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $agmwli, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "44.   Kewarganegaraaan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "45.   Pendidikan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "46.   Pekerjaan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, $pkjwli, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "47.   Penghasilan per bulan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "48.   Alamat rumah / Nomor telepon", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "H.", '', 0, L, true);
	$pdf->Cell(2.5, 0.6, "KEGEMARAN SISWA", '', 0, L, true);
	$pdf->Cell( 5	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "49.   Kesenian", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "50.   Olahraga", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "51.   Kemasyarakatan / Organisasi", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "52.   Lain - lain", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$gmbr1	="../../images/3x4.jpg";
	$pdf->Image($gmbr1, 16.5, 2, 3.5, 4);
	
	$gmbr2	="../../images/3x4.jpg";
	$pdf->Image($gmbr2, 16.5, 8, 3.5, 4);
	
	$gmbr3	="../../images/3x4 b.jpg";
	$pdf->Image($gmbr3, 16.5, 14, 3.5, 4);
	
	$gmbr4	="../../images/3x4 b.jpg";
	$pdf->Image($gmbr4, 16.5, 20, 3.5, 4);
	
	
	
	//awal halaman 3
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "I.", '', 0, L, true);
	$pdf->Cell(2.5, 0.6, "KETERANGAN PERKEMBANGAN SISWA", '', 0, L, true);
	$pdf->Cell( 5	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "53.   Menerima Bea siswa", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, ' Tahun', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, ' Tahun', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, ' Tahun', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "54.   Meninggalkan Sekolah", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        a.   Tanggal meninggalkan sekolah", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        b.   Alasan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "55.   Akhir pendidikan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        a.   Tamat belajar", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, ' Tahun', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        b.   STTB Nomor", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "J.", '', 0, L, true);
	$pdf->Cell(3.5, 0.6, "KETERANGAN SETELAH SELESAI PENDIDIKAN", '', 0, L, true);
	$pdf->Cell( 5	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "56.   Melanjutkan di", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "57.   bekerja", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        a.   Tanggal mulai bekerja", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        b.   Nama perusahaan / lembaga /", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "              dan lain-lain", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 0.5	,0.6,'','',0,C,false);
	$pdf->Cell(0.5, 0.6, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.6, "        c.   Penghasilan", '', 0, L, true);
	$pdf->Cell( 6	,0.6,'','',0,C,false);
	$pdf->Cell(0.25, 0.6, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, '', '', 0, L, true);
	
	
	
//};
$pdf->Output();
?>