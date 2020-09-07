<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LSMA11_C01.php
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
$query	="	SELECT 		t_setthn_sma.*
			FROM 		t_setthn_sma
			WHERE		t_setthn_sma.set='Tahun Ajaran'";
$result	=mysql_query($query) or die('Query gagal1g');
$data 	=mysql_fetch_array($result);
$thnajar3=$data[nli];

if($sms=='1')
	$semester3='XI/1 - Ganjil';
else if($sms=='2')
	$semester3='XI/2 - Genap';

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
$kkelas=$data[kdekls];
$tmplhr=$data[tmplhr];
$tgllhr=$data[tgllhr];
$jnsklm=$data[jnsklm];
$kdeagm=$data[kdeagm];
$tgllhr=strtotime($tgllhr);
$tgllhr=date('d F Y',$tgllhr);

$nmaibu =$data[nmaibu];
$nmaayh	=$data[nmaayh];
$almt	=$data[alm];
$pkjayh =$data[pkjayh];
$pkjibu =$data[pkjibu];
$hpaayh =$data[hpaayh];

$nmawli =$data[nmawli];
$almwli =$data[almwli];
$pkjwli =$data[pkjwli];
$hpawli =$data[hpawli];
//$kdekls =$data[kdekls];

$sklasl =$data[sklasl];
$status =$data[status];
$anakke =$data[anakke];
$pdatgl =$data[pdatgl];

if($sklasl=='SJSM')
	$sklasl="Saint John's School Meruya";

if($jnsklm=='P')
	$jnsklm='Perempuan';
else if($jnsklm=='L')
	$jnsklm='Laki-laki';

if($kkelas=='SHS-11IPA')
{
	$dikelas='11';
	$kelas3='XI';
	$wlikls="Markus Sumartono, S.Pd";
}
else if($kkelas=='SHS-11IPS')
{
	$dikelas='11';
	$kelas3='XI';
	$wlikls="Markus Sumartono, S.Pd";
}
else if($kkelas=='SHS-12IPA')
{
	$dikelas='12';
	$kelas3='XII';
	$wlikls="Bekti Yustiarti, S.Pd";
}
else if($kkelas=='SHS-12IPS')
{
	$dikelas='12';
	$kelas3='XII';
	$wlikls="Bekti Yustiarti, S.Pd";
}

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


	


$pdf =new FPDF('P','cm','A4');
$pdf->SetMargins(0.1,0.1,0.1);
$pdf->SetAutoPageBreak(True, 0.05);







	
	







//awal halaman 1

$j=0;
//while($j<$i)
//{
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$signature	="../../images/SMA/garuda.jpg";
	$pdf->Image($signature, 8.5, 2, 3, 3);
	
	$pdf->Ln(6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "LAPORAN HASIL BELAJAR SISWA", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "SEKOLAH MENENGAH ATAS", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "(SMA)", '', 0, C, true);
	
	$signature	="../../images/logo_sd.jpg";
	$pdf->Image($signature, 8.5, 11, 3, 3);
	
	$pdf->Ln(12);
	$pdf->Cell( 6.5	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Nama Siswa   : ".$nmassw, '', 0, L, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 6.5	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "No. Induk        : ".$nisn.'/'.substr($kdekls,0,3), '', 0, L, true);
	
	
	
	//awal halaman 2
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->Cell( 13	,0.6,'','',0,C,false);
	$pdf->Cell(7, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln(2);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "SMA Saint John's School", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Dinas Pendidikan Propinsi DKI Jakarta", '', 0, C, true);
	
	
	$signature	="../../images/SMA/garuda.jpg";
	$pdf->Image($signature, 8.5, 5, 3, 3);
	
	$pdf->Ln(6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "LAPORAN HASIL BELAJAR SISWA", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "SEKOLAH MENENGAH ATAS", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "(SMA)", '', 0, C, true);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "Nama Siswa", '', 0, L, true);
	$pdf->Cell( 4	,1.0,'','',0,C,false);
	$pdf->Cell(0.25, 1.0, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, $nmassw, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "No. Induk", '', 0, L, true);
	$pdf->Cell( 4	,1.0,'','',0,C,false);
	$pdf->Cell(0.25, 1.0, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, $nisn.'/'.substr($kdekls,0,3), '', 0, L, true);//"0051173685"
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "Nama Sekolah", '', 0, L, true);
	$pdf->Cell( 4	,1.0,'','',0,C,false);
	$pdf->Cell(0.25, 1.0, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "SMA Saint John's School", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "NPSN", '', 0, L, true);
	$pdf->Cell( 4	,1.0,'','',0,C,false);
	$pdf->Cell(0.25, 1.0, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "20177837", '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "ALAMAT SEKOLAH", '', 0, L, true);
	$pdf->Cell( 4	,1.0,'','',0,C,false);
	$pdf->Cell(0.25, 1.0, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "Jl. Taman Palem Raya Blok D1 No. 1, Villa Meruya", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "", '', 0, L, false);
	$pdf->Cell( 4	,1.0,'','',0,C,false);
	$pdf->Cell(2.3, 1.0, "   KODE POS ", '', 0, L, true);
	$pdf->Cell( 0.3	,1.0,'','',0,C,false);
	$pdf->Cell(0.1, 1.0, ": ", '', 0, L, true);
	$pdf->Cell( 0.1	,1.0,'','',0,C,false);
	$pdf->Cell(1, 1.0, " 11650", '', 0, L, true);
	$pdf->Cell( 0.4	,1.0,'','',0,C,false);
	$pdf->Cell(1, 1.0, "", '', 0, L, true);
	$pdf->Cell( 0.1	,1.0,'','',0,C,false);
	$pdf->Cell(1, 1.0, "", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "KELURAHAN", '', 0, L, true);
	$pdf->Cell( 4	,1.0,'','',0,C,false);
	$pdf->Cell(0.25, 1.0, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "Meruya Selatan", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "KECAMATAN", '', 0, L, true);
	$pdf->Cell( 4	,1.0,'','',0,C,false);
	$pdf->Cell(0.25, 1.0, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "Kembangan", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "KABUPATEN/KOTA", '', 0, L, true);
	$pdf->Cell( 4	,1.0,'','',0,C,false);
	$pdf->Cell(0.25, 1.0, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "Kodya Jakarta Barat", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "PROVINSI", '', 0, L, true);
	$pdf->Cell( 4	,1.0,'','',0,C,false);
	$pdf->Cell(0.25, 1.0, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,1.0,'','',0,C,false);
	$pdf->Cell(1.2, 1.0, "DKI Jakarta", '', 0, L, true);
	
	
	
	//awal halaman 3
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','UB',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "IDENTITAS PESERTA DIDIK", '', 0, C, true);
	/*$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "No. ID.Reg : SJM/15-16/X/053", '', 0, C, true);*/
	
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "1", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Nama Peserta Didik", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $nmassw, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "2", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Nomor Induk ", '', 0, L, true);//Siswa Nasional
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $nisn, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "3", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Tempat Tanggal Lahir", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $tmplhr.', '.$tgllhr, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "4", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Jenis Kelamin", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $jnsklm, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "5", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Agama", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $kdeagm, '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "6", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Anak ke", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $anakke, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "7", '', 0, L, false);
	$pdf->Cell(1.2, 0.5, "Status dalam Keluarga", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $status, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "8", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Alamat Peserta Didik", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $almt, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Telepon", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $hpaayh, '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "Diterima di Sekolah ini", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "", '', 0, L, false);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "a.   Di Kelas", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $dikelas, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "b.   Pada Tanggal", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $pdatgl, '', 0, L, true);//13 Juli 2017
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "c.   Semester", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $dikelas, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "9", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Sekolah Asal", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);//Saint John's School Meruya//
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "a.   Nama Sekolah", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $sklasl, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "b.   Alamat", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);//"Jl. Taman Palem Raya Blok D1 No. 1, Villa Meruya"
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "11", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Ijazah SMP/MTs/Paket B", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "a.   Tahun", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);//'2015'
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "b.   Nomor", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);//DN-01 DI 0056552
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "12", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Surat Keterangan Hasil Ujian Nasional (SKHUN) SMP/MTs, Paket B", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, "", '', 0, L, false);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, false);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "a.   Tahun", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);//'2015'
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "b.   Nomor", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);//DN-01 DI 0060980
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "13", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Orang Tua", '', 0, L, true);
	$pdf->Cell( 4.9	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "a.   Ayah", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $nmaayh, '', 0, L, true);//7
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "b.   Ibu", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $nmaibu, '', 0, L, true);//13 Juli 2017
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "14", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Alamat Orang Tua", '', 0, L, true);
	$pdf->Cell( 4.9	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $almt, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	//$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Telepon", '', 0, L, true);
	$pdf->Cell( 4.9	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $hpaayh, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "15", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Pekerjaan Orang Tua", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "a.   Ayah", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $pkjayh, '', 0, L, true);//7
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "b.   Ibu", '', 0, L, true);
	$pdf->Cell( 4.5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $pkjibu, '', 0, L, true);//13 Juli 2017
	
	/*$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "13", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Wali Peserta Didik", '', 0, L, true);
	$pdf->Cell( 5	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, "", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);*/
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "16", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Nama Wali", '', 0, L, true);
	$pdf->Cell( 4.9	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $nmawli, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "17", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Alamat Wali", '', 0, L, true);
	$pdf->Cell( 4.9	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $almwli, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", '', 0, L, true);
	//$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Telepon", '', 0, L, true);
	$pdf->Cell( 4.9	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $hpawli, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "18", '', 0, L, true);
	//$pdf->Cell(0.4, 0.5, "", '', 0, L, true);
	$pdf->Cell(1.2, 0.5, "Pekerjaan Wali", '', 0, L, true);
	$pdf->Cell( 4.9	,0.5,'','',0,C,false);
	$pdf->Cell(0.25, 0.5, ":", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, $pkjwli, '', 0, L, true);
	
	$signature	="../../images/SMA/".$kdekls.".jpg";
	$pdf->Image($signature, 2, 23, 3.5, 4);
	
	$pdf->Ln(3.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(12.5, 0.5, "", '', 0, L, false);
	$pdf->Cell(1.2, 0.5, '13 Juli 2017', '', 0, L, true);//$tglctk
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(12.5, 0.5, "", '', 0, L, false);
	$pdf->Cell(1.2, 0.5, 'Kepala Sekolah,', '', 0, L, true);
	
	$pdf->Ln(3.2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(12.5, 0.5, "", '', 0, L, false);
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell(1.2, 0.5, 'Ir. Paulus Pontoh MBA', '', 0, L, true);
	
	
	
	// awal halaman 4
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "LAPORAN HASIL BELAJAR", '', 0, C, true);
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "SISWA SEKOLAH MENENGAH ATAS", '', 0, C, true);
		
	$pdf->Ln(1.5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "Nama Siswa  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(1.2, 0.5, $nmassw, '', 0, L, true);													$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Nama Sekolah", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, "SMA Saint John's School", '', 0, L, true);
	
	//"Saint John's School"		$kelas3
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "No. Induk  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(1.2, 0.5, $nisn.'/'.substr($kdekls,0,3), '', 0, L, true);							$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Th. Pelajaran", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, $thnajar3, '', 0, L, true);
	
	//"Jl. Taman Palem Raya Blok D1 No."
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "No. ID. Reg  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);														$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Kelas Semester", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, 'XI/1-Ganjil', '', 0, L, true);//$semester3
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1.5, "No", 'LRTB', 0, L, true);
	$pdf->Cell(6, 1.5, "Mata Pelajaran", 'LRTB', 0, L, true);
	$pdf->Cell(1.5, 1.5, "KKM*", 'LRTB', 0, L, true);
	$pdf->Cell(9.5, 0.5, "Nilai Hasil Belajar", 'LRTB', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1.5, "", '', 0, C, false);
	$pdf->Cell(6, 1.5, "", '', 0, C, false);
	$pdf->Cell(1.5, 1.5, "", '', 0, C, false);
	$pdf->Cell(4.0, 0.5, "Pemahaman Konsep", 'LRTB', 0, C, true);
	$pdf->Cell(4.0, 0.5, "Praktik", 'LRTB', 0, C, true);
	$pdf->Cell(1.5, 0.5, "Sikap", 'LRTB', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1.5, "", '', 0, C, false);
	$pdf->Cell(6, 1.5, "", '', 0, C, false);
	$pdf->Cell(1.5, 1.5, "", '', 0, C, false);
	$pdf->Cell(1.5, 0.5, "Angka", 'LRTB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "Huruf", 'LRTB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "Angka", 'LRTB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "Huruf", 'LRTB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "Predikat", 'LRTB', 0, L, true);
	
	//1
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "1", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Pendidikan Agama", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "2", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Pendidikan Kewarganegaraan", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "3", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Bahasa Indonesia", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "4", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Bahasa Inggris", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "5", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Matematika", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "6", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Ekonomi", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "7", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Sejarah", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "8", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Sosiologi", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "9", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Geografi", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "10", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Seni Budaya", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "11", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Pendidikan Jasmani, Olahraga, ", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "dan Kesehatan", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "12", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Teknologi Informasi dan", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "Komunikasi", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "13", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Keterampilan/Bahasa Asing **)", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "Mandarin", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	//tanda tangan
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 8.25	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Mengetahui,",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Jakarta, 16 Juni 2017",'',0,L);//4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L);
	$pdf->Cell( 1.25	,0.5,"Orang Tua/Wali,",'',0,L);//4
	//$pdf->Cell( 8.25	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Kepala Sekolah,",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Wali Kelas,",'',0,L);//4
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"(_______________)",0,0,L); 
	$pdf->Cell( 5.7	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,"Ir. Paulus Pontoh MBA",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,$wlikls,'',0,L);//4
	
	
	
	// awal halaman 5
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "LAPORAN KETERCAPAIAN KOMPETENSI", '', 0, C, true);
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "SISWA SEKOLAH MENENGAH ATAS", '', 0, C, true);
		
	$pdf->Ln(1.5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "Nama Siswa  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(1.2, 0.5, $nmassw, '', 0, L, true);													$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Nama Sekolah", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, "SMA Saint John's School", '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "No. Induk  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(1.2, 0.5, $nisn.'/'.substr($kdekls,0,3), '', 0, L, true);							$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Th. Pelajaran", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, $thnajar3, '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "No. ID. Reg  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);														$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Kelas Semester", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, 'XI/1-Ganjil', '', 0, L, true);//$semester3
	
	
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "No", 'LRTB', 0, L, true);
	$pdf->Cell(4, 0.5, "Mata Pelajaran", 'LRTB', 0, L, true);
	$pdf->Cell(14, 0.5, "Keterangan", 'LRTB', 0, L, true);
	
	//rlg
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "1", 'LRTB', 0, L, true);
	$pdf->Cell(4, 0.5, "Pendidikan Agama", 'LRTB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRTB', 0, C, true);
	
	//cme
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "2", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Pendidikan ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "Kewarganegaraan", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//bin
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "3", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Bahasa Indonesia ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//eng
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, " ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "4", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "Bahasa Inggris", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//mth
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "5", 'LRTB', 0, L, true);
	$pdf->Cell(4, 0.5, "Matematika", 'LRTB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRTB', 0, C, true);
	
	//hist
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, " ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "6", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "Sejarah", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//ggry
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "7", 'LRTB', 0, L, true);
	$pdf->Cell(4, 0.5, "Geografi", 'LRTB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRTB', 0, C, true);
	
	//ecn
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "8", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Ekonomi ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//scl
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "9", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Sosiologi ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//art
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "10", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Seni Budaya ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//pe
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "11", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Pendidikan ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "Jasmani, Olahraga,", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "dan Kesehatan", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//ict
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "12", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Teknologi ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "Informasi dan", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "Komunikasi", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//pe
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "13", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Keterampilan/ ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "Bahasa Asing **)", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "Mandarin", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	
	
	//tanda tangan
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 8.25	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Mengetahui,",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Jakarta, 16 Juni 2017",'',0,L);//4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L);
	$pdf->Cell( 1.25	,0.5,"Orang Tua/Wali,",'',0,L);//4
	//$pdf->Cell( 8.25	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Kepala Sekolah,",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Wali Kelas,",'',0,L);//4
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"(_______________)",0,0,L); 
	$pdf->Cell( 5.7	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,"Ir. Paulus Pontoh MBA",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,$wlikls,'',0,L);//4
	
	
	
	//awal halaman 6
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "LAPORAN HASIL BELAJAR", '', 0, C, true);
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "SISWA SEKOLAH MENENGAH ATAS", '', 0, C, true);
	
	$pdf->Ln(1.5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "Nama Siswa  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(1.2, 0.5, $nmassw, '', 0, L, true);													$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Nama Sekolah", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, "SMA Saint John's School", '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "No. Induk  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(1.2, 0.5, $nisn.'/'.substr($kdekls,0,3), '', 0, L, true);							$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Th. Pelajaran", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, $thnajar3, '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "No. ID. Reg  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);														$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Kelas Semester", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, 'XI/1-Ganjil', '', 0, L, true);//$semester3
	
	
	
	//Pengembangan Diri
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"Pengembangan Diri",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"",0,0,L,false);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.6,"",0,0,L); 
	$pdf->Cell( 1	,0.6,"No",'LRTB',0,C);
	$pdf->Cell( 6	,0.6,"Jenis Kegiatan",'LRTB',0,C);
	$pdf->Cell( 11	,0.6,"Keterangan",'LRTB',0,C);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"A",'LRTB',0,C);
	$pdf->Cell( 6	,0.5,"Kegiatan Ekstrakurikuler",'LRTB',0,L);
	$pdf->Cell( 11	,0.5,"",'LRT',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"",'LRTB',0,C);
	$pdf->Cell( 1	,0.5,"1",'LRTB',0,L);
	$pdf->Cell( 5	,0.5,"",'LRTB',0,L);
	$pdf->Cell( 11	,0.5,"",'LRT',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"",'LRTB',0,C);
	$pdf->Cell( 1	,0.5,"2",'LRTB',0,L);
	$pdf->Cell( 5	,0.5,"",'LRTB',0,L);
	$pdf->Cell( 11	,0.5,"",'LRTB',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"",'LRTB',0,C);
	$pdf->Cell( 6	,0.5,"",'LRTB',0,L);
	$pdf->Cell( 11	,0.5,"",'LRTB',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"B",'LRT',0,C);
	$pdf->Cell( 6	,0.5,"Keikutsertaan dalam Organisasi/",'LRT',0,L);
	$pdf->Cell( 11	,0.5,"",'LRT',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"",'LRB',0,C);
	$pdf->Cell( 6	,0.5,"Kegiatan di Sekolah",'LRB',0,L);
	$pdf->Cell( 11	,0.5,"",'LR',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"",'LRTB',0,C);
	$pdf->Cell( 1	,0.5,"1",'LRTB',0,L);
	$pdf->Cell( 5	,0.5,"",'LRTB',0,L);
	$pdf->Cell( 11	,0.5,"",'LRT',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"",'LRTB',0,C);
	$pdf->Cell( 1	,0.5,"",'LRTB',0,L);
	$pdf->Cell( 5	,0.5,"",'LRTB',0,L);
	$pdf->Cell( 11	,0.5,"",'LRTB',0,C);//0.4
	
	
	
	//ketidakhadiran
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"Ketidakhadiran",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"",0,0,L,false);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.6,"",0,0,L); 
	$pdf->Cell( 1	,0.6,"No",'LRTB',0,C);
	$pdf->Cell( 6	,0.6,"Alasan Ketidakhadiran",'LRTB',0,C);
	$pdf->Cell( 11	,0.6,"Keterangan",'LRTB',0,C);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"1",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Sakit",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"-",'LRT',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"2",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Izin",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"-",'LRT',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"3",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Tanpa Keterangan",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"-",'LRTB',0,C);//0.4
	
	
	
	//Kepribadian
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"Ketidakhadiran",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"",0,0,L,false);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.6,"",0,0,L); 
	$pdf->Cell( 1	,0.6,"No",'LRTB',0,C);
	$pdf->Cell( 6	,0.6,"Kepribadian",'LRTB',0,C);
	$pdf->Cell( 11	,0.6,"Keterangan",'LRTB',0,C);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"1",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Kelakuan",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"Baik : hormat, perhatian dan peduli dengan siapapun",'LRT',0,L);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"2",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Kerajinan/Kedisiplinan",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"Baik : tepat waktu dalam mengerjakan tugas maupun dalam kegiatan",'LRT',0,L);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"3",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Kerapihan",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"Baik : penampilan sehari-hari rapi dan sopan",'LRTB',0,L);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"4",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Kebersihan",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"Baik : peduli dengan kebersihan kelas dan peralatan sekolah",'LRTB',0,L);//0.4
	
	
	
	//g. catatan wali kelas
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"Catatan Wali Kelas",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"",0,0,L,false);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 18	,0.5,'','LRT',0,L);//1
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 18	,0.5,"",'LR',0,L);//2
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 18	,0.5,"",'LR',0,L);//3
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 18	,0.5,"",'LRB',0,L);//4
	
	
	
	//tanda tangan
	
	$pdf->Ln(2);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 8.25	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Mengetahui,",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Jakarta, 16 Juni 2017",'',0,L);//4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L);
	$pdf->Cell( 1.25	,0.5,"Orang Tua/Wali,",'',0,L);//4
	$pdf->Cell( 5	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Kepala Sekolah,",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Wali Kelas,",'',0,L);//4
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"(_______________)",0,0,L); 
	$pdf->Cell( 5.7	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,"Ir. Paulus Pontoh MBA",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,$wlikls,'',0,L);//4
	
	
	
	// awal halaman 7
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "LAPORAN HASIL BELAJAR", '', 0, C, true);
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "SISWA SEKOLAH MENENGAH ATAS", '', 0, C, true);
		
	$pdf->Ln(1.5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "Nama Siswa  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(1.2, 0.5, $nmassw, '', 0, L, true);													$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Nama Sekolah", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, "SMA Saint John's School", '', 0, L, true);
	
	//
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "No. Induk  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(1.2, 0.5, $nisn.'/'.substr($kdekls,0,3), '', 0, L, true);							$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Th. Pelajaran", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, $thnajar3, '', 0, L, true);
	
	//
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "No. ID. Reg  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);														$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Kelas Semester", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, 'XI/2-Genap', '', 0, L, true);//$semester3
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1.5, "No", 'LRTB', 0, L, true);
	$pdf->Cell(6, 1.5, "Mata Pelajaran", 'LRTB', 0, L, true);
	$pdf->Cell(1.5, 1.5, "KKM*", 'LRTB', 0, L, true);
	$pdf->Cell(9.5, 0.5, "Nilai Hasil Belajar", 'LRTB', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1.5, "", '', 0, C, false);
	$pdf->Cell(6, 1.5, "", '', 0, C, false);
	$pdf->Cell(1.5, 1.5, "", '', 0, C, false);
	$pdf->Cell(4.0, 0.5, "Pemahaman Konsep", 'LRTB', 0, C, true);
	$pdf->Cell(4.0, 0.5, "Praktik", 'LRTB', 0, C, true);
	$pdf->Cell(1.5, 0.5, "Sikap", 'LRTB', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1.5, "", '', 0, C, false);
	$pdf->Cell(6, 1.5, "", '', 0, C, false);
	$pdf->Cell(1.5, 1.5, "", '', 0, C, false);
	$pdf->Cell(1.5, 0.5, "Angka", 'LRTB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "Huruf", 'LRTB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "Angka", 'LRTB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "Huruf", 'LRTB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "Predikat", 'LRTB', 0, L, true);
	
	//1
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "1", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Pendidikan Agama", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "2", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Pendidikan Kewarganegaraan", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "3", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Bahasa Indonesia", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "4", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Bahasa Inggris", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "5", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Matematika", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "6", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Ekonomi", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "7", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Sejarah", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "8", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Sosiologi", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "9", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Geografi", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "10", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Seni Budaya", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "11", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Pendidikan Jasmani, Olahraga, ", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "dan Kesehatan", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "12", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Teknologi Informasi dan", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "Komunikasi", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "13", 'LRT', 0, L, false);
	$pdf->Cell(6, 0.5, "Keterampilan/Bahasa Asing **)", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRT', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(6, 0.5, "Mandarin", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, false);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(2.5, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(1.5, 0.5, "", 'LRB', 0, L, true);
	
	//tanda tangan
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 8.25	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Mengetahui,",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Jakarta, 16 Juni 2017",'',0,L);//4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L);
	$pdf->Cell( 1.25	,0.5,"Orang Tua/Wali,",'',0,L);//4
	//$pdf->Cell( 8.25	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Kepala Sekolah,",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Wali Kelas,",'',0,L);//4
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"(_______________)",0,0,L); 
	$pdf->Cell( 5.7	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,"Ir. Paulus Pontoh MBA",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,$wlikls,'',0,L);//4
	
	
	
	// awal halaman 9
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "LAPORAN KETERCAPAIAN KOMPETENSI", '', 0, C, true);
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "SISWA SEKOLAH MENENGAH ATAS", '', 0, C, true);
		
	$pdf->Ln(1.5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "Nama Siswa  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(1.2, 0.5, $nmassw, '', 0, L, true);													$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Nama Sekolah", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, "SMA Saint John's School", '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "No. Induk  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(1.2, 0.5, $nisn.'/'.substr($kdekls,0,3), '', 0, L, true);							$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Th. Pelajaran", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, $thnajar3, '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "No. ID. Reg  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);														$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Kelas Semester", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, 'XI/2-Genap', '', 0, L, true);//$semester3
	
	
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "No", 'LRTB', 0, L, true);
	$pdf->Cell(4, 0.5, "Mata Pelajaran", 'LRTB', 0, L, true);
	$pdf->Cell(14, 0.5, "Keterangan", 'LRTB', 0, L, true);
	
	//rlg
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "1", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Pendidikan Agama", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//cme
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "2", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Pendidikan ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "Kewarganegaraan", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//bin
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "3", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Bahasa Indonesia ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//eng
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, " ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "4", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "Bahasa Inggris", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//mth
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "5", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Matematika", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//hist
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, " ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "6", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "Sejarah", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//ggry
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "7", 'LRTB', 0, L, true);
	$pdf->Cell(4, 0.5, "Geografi", 'LRTB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRTB', 0, C, true);
	
	//ecn
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "8", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Ekonomi ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//scl
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "9", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Sosiologi ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//art
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "10", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Seni Budaya ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//pe
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "11", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Pendidikan ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "Jasmani, Olahraga,", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "dan Kesehatan", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//ict
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "12", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Teknologi ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "Informasi dan", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "Komunikasi", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	//pe
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "13", 'LRT', 0, L, true);
	$pdf->Cell(4, 0.5, "Keterampilan/ ", 'LRT', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRT', 0, C, true);//Mampu memahami materi tentang Budaya politik dan budaya demokrasi
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LR', 0, L, true);
	$pdf->Cell(4, 0.5, "Bahasa Asing **)", 'LR', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 0.8	,0.5,'','',0,C,false);
	$pdf->Cell(1, 0.5, "", 'LRB', 0, L, true);
	$pdf->Cell(4, 0.5, "Mandarin", 'LRB', 0, L, true);
	$pdf->Cell(14, 0.5, "", 'LRB', 0, C, true);
	
	
	
	//tanda tangan
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 8.25	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Mengetahui,",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Jakarta, 16 Juni 2017",'',0,L);//4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L);
	$pdf->Cell( 1.25	,0.5,"Orang Tua/Wali,",'',0,L);//4
	//$pdf->Cell( 8.25	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Kepala Sekolah,",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Wali Kelas,",'',0,L);//4
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"(_______________)",0,0,L); 
	$pdf->Cell( 5.7	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,"Ir. Paulus Pontoh MBA",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,$wlikls,'',0,L);//4
	
	
	
	//awal halaman 9
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "LAPORAN HASIL BELAJAR", '', 0, C, true);
	$pdf->Ln();
	$pdf->Cell( 9.3	,0.5,'','',0,C,false);
	$pdf->Cell(1.2, 0.5, "SISWA SEKOLAH MENENGAH ATAS", '', 0, C, true);
	
	$pdf->Ln(1.5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "Nama Siswa  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(1.2, 0.5, $nmassw, '', 0, L, true);													$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Nama Sekolah", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, "SMA Saint John's School", '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "No. Induk  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(1.2, 0.5, $nisn.'/'.substr($kdekls,0,3), '', 0, L, true);							$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Th. Pelajaran", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, $thnajar3, '', 0, L, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "No. ID. Reg  ", '', 0, L, true);
	$pdf->Cell( 0.4	,0.5,'','',0,C,false);
	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,0.5,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.5, '', '', 0, L, true);														$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,0.5,'','',0,C,false);	$pdf->Cell(2.1, 0.5, "Kelas Semester", '', 0, L, true);			$pdf->Cell( 0.4	,0.5,'','',0,C,false);	$pdf->Cell(0.4, 0.5, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,0.5,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell(0.4, 0.5, 'XI/2-Genap', '', 0, L, true);//$semester3
	
	
	
	//Pengembangan Diri
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"Pengembangan Diri",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"",0,0,L,false);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.6,"",0,0,L); 
	$pdf->Cell( 1	,0.6,"No",'LRTB',0,C);
	$pdf->Cell( 6	,0.6,"Jenis Kegiatan",'LRTB',0,C);
	$pdf->Cell( 11	,0.6,"Keterangan",'LRTB',0,C);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"A",'LRTB',0,C);
	$pdf->Cell( 6	,0.5,"Kegiatan Ekstrakurikuler",'LRTB',0,L);
	$pdf->Cell( 11	,0.5,"",'LRT',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"",'LRTB',0,C);
	$pdf->Cell( 1	,0.5,"1",'LRTB',0,L);
	$pdf->Cell( 5	,0.5,"",'LRTB',0,L);
	$pdf->Cell( 11	,0.5,"",'LRT',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"",'LRTB',0,C);
	$pdf->Cell( 1	,0.5,"2",'LRTB',0,L);
	$pdf->Cell( 5	,0.5,"",'LRTB',0,L);
	$pdf->Cell( 11	,0.5,"",'LRTB',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"",'LRTB',0,C);
	$pdf->Cell( 6	,0.5,"",'LRTB',0,L);
	$pdf->Cell( 11	,0.5,"",'LRTB',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"B",'LRT',0,C);
	$pdf->Cell( 6	,0.5,"Keikutsertaan dalam Organisasi/",'LRT',0,L);
	$pdf->Cell( 11	,0.5,"",'LRT',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"",'LRB',0,C);
	$pdf->Cell( 6	,0.5,"Kegiatan di Sekolah",'LRB',0,L);
	$pdf->Cell( 11	,0.5,"",'LR',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"",'LRTB',0,C);
	$pdf->Cell( 1	,0.5,"1",'LRTB',0,L);
	$pdf->Cell( 5	,0.5,"",'LRTB',0,L);
	$pdf->Cell( 11	,0.5,"",'LRT',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 1	,0.5,"",'LRTB',0,C);
	$pdf->Cell( 1	,0.5,"",'LRTB',0,L);
	$pdf->Cell( 5	,0.5,"",'LRTB',0,L);
	$pdf->Cell( 11	,0.5,"",'LRTB',0,C);//0.4
	
	
	
	//ketidakhadiran
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"Ketidakhadiran",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"",0,0,L,false);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.6,"",0,0,L); 
	$pdf->Cell( 1	,0.6,"No",'LRTB',0,C);
	$pdf->Cell( 6	,0.6,"Alasan Ketidakhadiran",'LRTB',0,C);
	$pdf->Cell( 11	,0.6,"Keterangan",'LRTB',0,C);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"1",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Sakit",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"-",'LRT',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"2",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Izin",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"-",'LRT',0,C);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"3",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Tanpa Keterangan",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"-",'LRTB',0,C);//0.4
	
	
	
	//Kepribadian
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"Ketidakhadiran",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"",0,0,L,false);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.6,"",0,0,L); 
	$pdf->Cell( 1	,0.6,"No",'LRTB',0,C);
	$pdf->Cell( 6	,0.6,"Kepribadian",'LRTB',0,C);
	$pdf->Cell( 11	,0.6,"Keterangan",'LRTB',0,C);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"1",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Kelakuan",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"Baik : hormat, perhatian dan peduli dengan siapapun",'LRT',0,L);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"2",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Kerajinan/Kedisiplinan",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"Baik : tepat waktu dalam mengerjakan tugas maupun dalam kegiatan",'LRT',0,L);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"3",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Kerapihan",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"Baik : penampilan sehari-hari rapi dan sopan",'LRTB',0,L);//0.4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.8,"",0,0,L); 
	$pdf->Cell( 1	,0.8,"4",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"Kebersihan",'LRTB',0,L);
	$pdf->Cell( 11	,0.8,"Baik : peduli dengan kebersihan kelas dan peralatan sekolah",'LRTB',0,L);//0.4
	
	
	
	//g. catatan wali kelas
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"Catatan Wali Kelas",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"",0,0,L,false);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 18	,0.5,'','LRT',0,L);//1
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 18	,0.5,"",'LR',0,L);//2
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 18	,0.5,"",'LR',0,L);//3
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.5,"",0,0,L); 
	$pdf->Cell( 18	,0.5,"",'LRB',0,L);//4
	
	
	
	//tanda tangan
	
	$pdf->Ln(2);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 8.25	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Mengetahui,",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Jakarta, 16 Juni 2017",'',0,L);//4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L);
	$pdf->Cell( 1.25	,0.5,"Orang Tua/Wali,",'',0,L);//4
	$pdf->Cell( 5	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Kepala Sekolah,",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Wali Kelas,",'',0,L);//4
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"(_______________)",0,0,L); 
	$pdf->Cell( 5.7	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,"Ir. Paulus Pontoh MBA",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,$wlikls,'',0,L);//4
	
	
	
//};
$pdf->Output();
?>