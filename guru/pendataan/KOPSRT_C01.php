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
$query	="	SELECT 		t_mstbbt_smp.*
			FROM 		t_mstbbt_smp
			WHERE		t_mstbbt_smp.kdebbt='1HW'";
$result	=mysql_query($query) or die('Query gagal1a');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp.*
			FROM 		t_mstbbt_smp
			WHERE		t_mstbbt_smp.kdebbt='2PRJ'";
$result	=mysql_query($query) or die('Query gagal1b');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp.*
			FROM 		t_mstbbt_smp
			WHERE		t_mstbbt_smp.kdebbt='3TES'";
$result	=mysql_query($query) or die('Query gagal1c');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp.*
			FROM 		t_mstbbt_smp
			WHERE		t_mstbbt_smp.kdebbt='4MID'";
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

if($kkelas=='JHS-7A')
{
	$dikelas='7';
	$kelas3='VII (TUJUH)';
	$wlikls="Romano A. Ordonez, BS ChE";
}
else if($kkelas=='JHS-7B')
{
	$dikelas='7';
	$kelas3='VII (TUJUH)';
	$wlikls="Jacqueline De Vera, BEED-ECE";
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
$pdf->SetMargins(0.5,0.5,0.5);
$pdf->SetAutoPageBreak(True, 0.05);







	
	



$ttlakh=0;
$ttlavg=0;
$hlm=1;
$no	=1;
$j	=0;
$rnk=1;



//awal halaman 1

$j=0;
//while($j<$i)
//{
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->Cell( 20	,28.75,"",'LRTB',0,C,True);
	
	/*$pdf->Ln();
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "SAINT JOHN'S CATHOLIC SCHOOL", '', 0, C, true);*/
	
	$logo	="../../images/logo_sd.jpg";
	$pdf->Image($logo, 9, 1, 2, 2);
	
	$sjs	="../../images/SJS.jpg";
	$pdf->Image($sjs, 7.5, 3.25, 5, 0.6);
	
	$almt	="../../images/alamat_sjs.jpg";
	$pdf->Image($almt, 8, 27, 5, 1.5);
	
	$foot	="../../images/footer_sjs.jpg";
	$pdf->Image($foot, 0.55, 28.5, 19.9, 0.7);
	
	
	
	
	
	
//};
$pdf->Output();
?>