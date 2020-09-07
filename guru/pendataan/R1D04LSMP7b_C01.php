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
$kdekls	=$_GET['kdekls'];//nis
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

/*if($sms=='1')
	$semester3='I / Ganjil';
else if($sms=='2')*/
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
$pdf->SetMargins(0.1,0.1,0.1);
$pdf->SetAutoPageBreak(True, 0.05);







	
	



$ttlakh=0;
$ttlavg=0;
$hlm=1;
$no	=1;
$j	=0;
$rnk=1;



//awal halaman 1

$j=0;

	
	
	
	//awal halaman 2
	
	
	
	
	
	
	
	//awal halaman 3
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "Nama Sekolah  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 1, "Saint John's School", '', 0, L, true);									$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,1,'','',0,C,false);	$pdf->Cell(2.1, 1, "Kelas", '', 0, L, true);			$pdf->Cell( 0.4	,1,'','',0,C,false);	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,1,'','',0,C,false);	$pdf->SetFont('Arial','U',9);	$pdf->Cell(0.4, 1, $kelas3, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "Alamat  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.4, "Jl. Taman Palem Raya Blok D1 No.", '', 0, L, true);					$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,1,'','',0,C,false);	$pdf->Cell(2.1, 1, "Semester", '', 0, L, true);			$pdf->Cell( 0.4	,1,'','',0,C,false);	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,1,'','',0,C,false);	$pdf->SetFont('Arial','U',9);	$pdf->Cell(0.4, 1, $semester3, '', 0, L, true);
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "  ", '', 0, L, false);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "   ", '', 0, L, false);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.4, "1, Villa Meruya", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "Nama  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 1, $nmassw, '', 0, L, true);												$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,1,'','',0,C,false);	$pdf->Cell(2.1, 1, "Tahun Pelajaran", '', 0, L, true);	$pdf->Cell( 0.4	,1,'','',0,C,false);	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,1,'','',0,C,false);	$pdf->SetFont('Arial','U',9);	$pdf->Cell(0.4, 1, $thnajar3, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "NISN  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 1, $nisn, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(18   ,0,'',1);
	$pdf->Ln();
	
	$pdf->Ln(1.5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "CAPAIAN HASIL BELAJAR", '', 0, C, true);
	
	
	
	$pdf->Ln(1.5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"A.",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"SIKAP",0,0,L); 
	
	//1
	//spiritual behaviour
	$qPER	="	SELECT 		t_personps.*
				FROM 		t_personps
				WHERE		t_personps.nis='$kdekls' "; // menghasilka nilai kepribadian
	$rPER=mysql_query($qPER) or die('Query gagal40');
	$dPER =mysql_fetch_array($rPER);
	
	$q1SPR=$dPER['spr'.$sms.$midtrm]; // q1 spr
	$q1SOC=$dPER['soc'.$sms.$midtrm]; // q1 soc
	
	$desSPR='';
	$desSOC='';
	
	if($q1SPR=='A')
		$desSPR='Mengerti, memahami dan merefleksikan Firman Tuhan dalam hidupnya dengan sangat baik';
	else if($q1SPR=='B')
		$desSPR='Mengerti, memahami dan merefleksikan Firman Tuhan dalam hidupnya dengan baik';
	else if($q1SPR=='C')
		$desSPR='Mengerti, memahami dan merefleksikan Firman Tuhan dalam hidupnya dengan cukup baik';
	else if($q1SPR=='D')
		$desSPR='-';
	else //if($q1SPR=='E')
		$desSPR='-';
	
	if($q1SOC=='A')
		$desSOC='Memahami dan mempraktekkan nilai-nilai moral, mengetahui tentang apa itu hak dan   kewajiban bagi dirinya, bagi sesama, bagi lingkungan dan  bagi dunia dengan sangat baik';
	else if($q1SOC=='B')
		$desSOC='Memahami dan mempraktekkan nilai-nilai moral, mengetahui tentang apa itu hak dan   kewajiban bagi dirinya, bagi sesama, bagi lingkungan dan  bagi dunia dengan  baik';
	else if($q1SOC=='C')
		$desSOC='Memahami dan mempraktekkan nilai-nilai moral, mengetahui tentang apa itu hak dan   kewajiban bagi dirinya, bagi sesama, bagi lingkungan dan  bagi dunia dengan cukup baik';
	else if($q1SOC=='D')
		$desSOC='-';
	else //if($q1SOC=='E')
		$desSOC='-';
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"1   Sikap Spiritual",0,0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,1.0,"",0,0,L); 
	$pdf->Cell( 3.5	,1.0,"Predikat",'LRTB',0,C); 
	$pdf->Cell( 14.5	,1.0,"Deskripsi",'LRTB',0,C); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,$q1SPR,'LR',0,C); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 14.5	,0.4,substr($desSPR,0,83),'LR',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,'','LR',0,C); 
	$pdf->Cell( 14.5	,0.4,substr($desSPR,83,83),'LR',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,'','LR',0,C); 
	$pdf->Cell( 14.5	,0.4,substr($desSPR,166,83),'LR',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,'','LR',0,C); 
	$pdf->Cell( 14.5	,0.4,substr($desSPR,249,83),'LR',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,'','LR',0,C); 
	$pdf->Cell( 14.5	,0.4,substr($desSPR,332,83),'LR',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,'','LR',0,C); 
	$pdf->Cell( 14.5	,0.4,substr($desSPR,415,83),'LR',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,"",'LRB',0,C); 
	$pdf->Cell( 14.5	,0.4,substr($desSPR,498,83),'LRB',0,L);
	
	//2
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"2   Sikap Sosial",0,0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,1.0,"",0,0,L); 
	$pdf->Cell( 3.5	,1.0,"Predikat",'LRTB',0,C); 
	$pdf->Cell( 14.5	,1.0,"Deskripsi",'LRTB',0,C); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,$q1SOC,'LR',0,C); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 14.5	,0.4,substr($desSOC,0,83),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,1.0,'','LR',0,C); 
	$pdf->Cell( 14.5	,0.4,substr($desSOC,83,83),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,1.0,'','LR',0,C); 
	$pdf->Cell( 14.5	,0.4,substr($desSOC,166,83),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,"",'LR',0,C,false); 
	$pdf->Cell( 14.5	,0.4,substr($desSOC,249,83),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,"",'LR',0,C,false); 
	$pdf->Cell( 14.5	,0.4,substr($desSOC,332,83),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,"",'LR',0,C,false); 
	$pdf->Cell( 14.5	,0.4,substr($desSOC,415,83),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,"",'LRB',0,C); 
	$pdf->Cell( 14.5	,0.4,substr($desSOC,498,83),'LRB',0,L);  
		
	
	
	//awal halaman 4
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "Nama Sekolah  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 1, "Saint John's School", '', 0, L, true);									$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,1,'','',0,C,false);	$pdf->Cell(2.1, 1, "Kelas", '', 0, L, true);			$pdf->Cell( 0.4	,1,'','',0,C,false);	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,1,'','',0,C,false);	$pdf->SetFont('Arial','U',9);	$pdf->Cell(0.4, 1, $kelas3, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "Alamat  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.4, "Jl. Taman Palem Raya Blok D1 No.", '', 0, L, true);					$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,1,'','',0,C,false);	$pdf->Cell(2.1, 1, "Semester", '', 0, L, true);			$pdf->Cell( 0.4	,1,'','',0,C,false);	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,1,'','',0,C,false);	$pdf->SetFont('Arial','U',9);	$pdf->Cell(0.4, 1, $semester3, '', 0, L, true);
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "  ", '', 0, L, false);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "   ", '', 0, L, false);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.4, "1, Villa Meruya", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "Nama  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 1, $nmassw, '', 0, L, true);												$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,1,'','',0,C,false);	$pdf->Cell(2.1, 1, "Tahun Pelajaran", '', 0, L, true);	$pdf->Cell( 0.4	,1,'','',0,C,false);	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,1,'','',0,C,false);	$pdf->SetFont('Arial','U',9);	$pdf->Cell(0.4, 1, $thnajar3, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "NISN  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 1, $nisn, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(18   ,0,'',1);
	$pdf->Ln();
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"B.",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Pengetahuan",0,0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"Kriteria Ketuntasan Minimal = 70",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"",0,0,L);
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,1,'NO'			,'LRTB',0,C,true);
	$pdf->Cell( 5	,1,'Mata Pelajaran'			,'LRTB',0,C,true);
	$pdf->Cell( 2	,0.4,'Nilai'			,'LRTB',0,C,true);
	$pdf->Cell( 2	,0.4,'Predikat'			,'LRTB',0,C,true);
	$pdf->Cell( 8.5	,1,'Deskripsi'			,'LRTB',0,C,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.4,'','',0,L,false); 
	$pdf->Cell( 0.6	,1,''			,'',0,C,false);
	$pdf->Cell( 5	,1,''			,'',0,C,false);
	$pdf->Cell( 2	,0.4,'1-100'			,'LRTB',0,C,true);
	$pdf->Cell( 2	,0.4,'A-D'			,'LRTB',0,C,true);
	$pdf->Cell( 8.5	,1,''			,'',0,C,false);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 1.3	,0.,'',0,0,L); 
	$pdf->Cell( 18.1	,0.5,'KELOMPOK A'			,'LRTB',0,L,true);
	
	//rlg
	$qRLG ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='RLG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rRLG=mysql_query($qRLG) or die('Query gagal');
	$dRLG =mysql_fetch_array($rRLG);
	
	$qSTK1	=$dRLG['qg_k13_'.$sms.'1']; // q
	$qSTK2	=$dRLG['qg_k13_'.$sms.'2']; // q
	
	$qK = number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' );
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
	{
		$lgK = 'A';
		$RLGk1 = "Sangat mampu memahami keunikan diri sebagai citra Allah, memahami gender dan memahami seksualitas sebagai anugerah Allah.";
	}
	else if($qK>=80)
	{
		$lgK = 'B';
		$RLGk1 = "Mampu memahami keunikan diri sebagai citra Allah, memahami gender dan memahami seksualitas sebagai  anugerah Allah.";
	}
	else if($qK>=70)
	{
		$lgK = 'C';
		$RLGk1 = "Cukup mampu memahami keunikan diri sebagai citra Allah, memahami gender dan memahami seksualitas sebagai anugerah Allah.";
	}
	else if($qK>=0)
	{
		$lgK = 'D';
		$RLGk1 = "";
	}
	else //if($qK==0)
		$lgK = "ERR";
		
	//
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'1'			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,'Pendidikan Agama dan Budi'			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($RLGk1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Pekerti'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgK			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($RLGk1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($RLGk1,100,50)			,'LR',0,L,true);
	
	//cme
	$qCME ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='CME'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rCME=mysql_query($qCME) or die('Query gagal');
	$dCME =mysql_fetch_array($rCME);
	
	$qSTK1	=$dCME['qg_k13_'.$sms.'1']; // q
	$qSTK2	=$dCME['qg_k13_'.$sms.'2']; // q
	
	$qK = number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' );
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
	{
		$lgK = 'A';
		$CMEk1 = "Sangat memahami perumusan pancasila sebagai dasar negara, UUD 1945, dan memahami norma-norma yang berlaku.";
	}
	else if($qK>=80)
	{
		$lgK = 'B';
		$CMEk1 = "Mampu memahami perumusan pancasila sebagai dasar  negara, UUD 1945, dan memahami norma-norma yang   berlaku.";
	}
	else if($qK>=70)
	{
		$lgK = 'C';
		$CMEk1 = "Cukup mampu memahami perumusan pancasila sebagai  dasar negara, UUD 1945, dan memahami norma-norma yang berlaku.";
	}
	else if($qK>=0)
	{
		$lgK = 'D';
		$CMEk1 = "";
	}
	else //if($qK==0)
		$lgK = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'2'			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,'Pendidikan Pancasila dan '			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($CMEk1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Kewarganegaraan'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgK			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($CMEk1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($CMEk1,100,50)			,'LR',0,L,true);
	
	//bin
	$qBIN ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='BIN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rBIN=mysql_query($qBIN) or die('Query gagal');
	$dBIN =mysql_fetch_array($rBIN);
	
	$qSTK1	=$dBIN['qg_k13_'.$sms.'1']; // q
	$qSTK2	=$dBIN['qg_k13_'.$sms.'2']; // q
	
	$qK = number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' );
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
	{
		$lgK = 'A';
		$BINk1 = "Sangat mampu memahami data, kesan, dan gagasan dalam bentuk Teks Deskripsi, Teks Narasi, Teks Prosedur, dan Teks Laporan Hasil Observasi.";
	}
	else if($qK>=80)
	{
		$lgK = 'B';
		$BINk1 = "Mampu memahami data, kesan, dan gagasan dalam     bentuk Teks Deskripsi, Teks Narasi, Teks Prosedur, dan Teks Laporan Hasil Observasi.";
	}
	else if($qK>=70)
	{
		$lgK = 'C';
		$BINk1 = "Cukup mampu memahami data, kesan, dan gagasan     dalam bentuk Teks Deskripsi, Teks Narasi, Teks    Prosedur, dan Teks Laporan Hasil Observasi.";
	}
	else if($qK>=0)
	{
		$lgK = 'D';
		$BINk1 = "";
	}
	else //if($qK==0)
		$lgK = "ERR";
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($BINk1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'3'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Bahasa Indonesia'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgK			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($BINk1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($BINk1,100,50)			,'LR',0,L,true);
	
	//mth
	$qMTH ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='MTH'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rMTH=mysql_query($qMTH) or die('Query gagal');
	$dMTH =mysql_fetch_array($rMTH);
	
	$qSTK1	=$dMTH['qg_k13_'.$sms.'1']; // q
	$qSTK2	=$dMTH['qg_k13_'.$sms.'2']; // q
	
	$qK = number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' );
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
	{
		$lgK = 'A';
		$MTHk1 = "Sangat memahami Linear equation and simple inequalities, functions and linear graphs.";
	}
	else if($qK>=80)
	{
		$lgK = 'B';
		$MTHk1 = "Mampu memahami Linear equation and simple         inequalities, functions and linear graphs.";
	}
	else if($qK>=70)
	{
		$lgK = 'C';
		$MTHk1 = "Cukup memahami Linear equation and simple         inequalities, functions and linear graphs.";
	}
	else if($qK>=0)
	{
		$lgK = 'D';
		$MTHk1 = "Kurang mampu memahami Linear equation and simple  inequalities, functions and linear graphs.";
	}
	else //if($qK==0)
		$lgK = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($MTHk1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'4'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Matematika'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgK			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($MTHk1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($MTHk1,100,50)			,'LR',0,L,true);
	
	//ipa
	$qBLGY ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='BLGY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rBLGY=mysql_query($qBLGY) or die('Query gagal');
	$dBLGY =mysql_fetch_array($rBLGY);
	
	$qPHY ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='PHY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rPHY=mysql_query($qPHY) or die('Query gagal');
	$dPHY =mysql_fetch_array($rPHY);
	
	/*$qSTK=$dBLGY['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dBLGY['qg_k14_'.$sms.$midtrm]; // q
	$qKblgy = $qSTK;
	$qSblgy = $qSTS;*/
		
	/*if($qKblgy>100)
		$lgK = 'ERR';
	else if($qKblgy>=90)
		$lgK = 'A';
	else if($qKblgy>=80)
		$lgK = 'B';
	else if($qKblgy>=70)
		$lgK = 'C';
	else if($qKblgy>=0)
		$lgK = 'D';
	else //if($qKblgy==0)
		$lgK = "ERR";*/
		
	$qSTK1	=$dBLGY['qg_k13_'.$sms.'1']; // q
	$qSTK2	=$dBLGY['qg_k13_'.$sms.'2']; // q
	
	$qSTK3	=$dPHY['qg_k13_'.$sms.'1']; // q
	$qSTK4	=$dPHY['qg_k13_'.$sms.'2']; // q
	
	$qK = number_format( ($qSTK1+$qSTK2 + $qSTK3+$qSTK4)/4 ,0,',','.' );
	
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
	{
		$lgK = 'A';
		$IPAk1 = "Sangat mampu memahami karakteristik dan klasifikasi mahluk hidup, pengenalan laboratorium, organisasi kehidupan, dan wujud dan klasifikasi zat.";
	}
	else if($qK>=80)
	{
		$lgK = 'B';
		$IPAk1 = "Mampu memahami karakteristik dan klasifikasi mahluk hidup, pengenalan laboratorium, organisasi kehidupan, dan wujud dan klasifikasi zat.";
	}
	else if($qK>=70)
	{
		$lgK = 'C';
		$IPAk1 = "Cukup mampu memahami karakteristik dan klasifikasi mahluk hidup, pengenalan laboratorium, organisasi kehidupan, dan wujud dan klasifikasi zat.";
	}
	else if($qK>=0)
	{
		$lgK = 'D';
		$IPAk1 = "Kurang mampu memahami karakteristik dan           klasifikasi mahluk hidup, pengenalan laboratorium, organisasi kehidupan, dan wujud dan klasifikasi zat.";
	}
	else //if($qK==0)
		$lgK = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($IPAk1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'5'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Ilmu Pengetahuan Alam'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTK1+$qSTK2 + $qSTK3+$qSTK4)/4 ,0,',','.' )			,'LR',0,C,false);//number_format( ( (($qSTK1+$qSTK2)/2) + (($qSTK3+$qSTK4)/2) ) / 2 ,0,',','.' )
	$pdf->Cell( 2	,0.4,$lgK			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($IPAk1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($IPAk1,100,55)			,'LR',0,L,true);
	
	//ips
	$qECN ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='ECN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rECN=mysql_query($qECN) or die('Query gagal');
	$dECN =mysql_fetch_array($rECN);
	
	$qGGRY ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='GGRY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rGGRY=mysql_query($qGGRY) or die('Query gagal');
	$dGGRY =mysql_fetch_array($rGGRY);
	
	$qHIST ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='HIST'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rHIST=mysql_query($qHIST) or die('Query gagal');
	$dHIST =mysql_fetch_array($rHIST);
	
	$qSTK1	=$dECN['qg_k13_'.$sms.'1']; // q
	$qSTK2	=$dECN['qg_k13_'.$sms.'2']; // q
	
	$qSTK3	=$dGGRY['qg_k13_'.$sms.'1']; // q
	$qSTK4	=$dGGRY['qg_k13_'.$sms.'2']; // q
	
	$qSTK5	=$dHIST['qg_k13_'.$sms.'1']; // q
	$qSTK6	=$dHIST['qg_k13_'.$sms.'2']; // q
	
	$qK = number_format( ($qSTK1+$qSTK2 + $qSTK3+$qSTK4 + $qSTK5+$qSTK6)/6 ,0,',','.' );
	
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
	{
		$lgK = 'A';
		$IPSk1 = "Sangat memahami perubahan Indonesia pada masa     praaksara, masa hindu buddha dan masa Islam dalam aspek geografis, ekonomi, budaya, pendidikan dan politik.";
	}
	else if($qK>=80)
	{
		$lgK = 'B';
		$IPSk1 = "Mampu memahami perubahan Indonesia pada masa      praaksara, masa hindu buddha dan masa Islam dalam aspek geografis, ekonomi, budaya, pendidikan dan politik.";
	}
	else if($qK>=70)
	{
		$lgK = 'C';
		$IPSk1 = "Cukup memahami perubahan Indonesia pada masa      praaksara, masa hindu buddha dan masa Islam dalam aspek geografis, ekonomi, budaya, pendidikan dan politik.";
	}
	else if($qK>=0)
	{
		$lgK = 'D';
		$IPSk1 = "";
	}
	else //if($qK==0)
		$lgK = "ERR";
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($IPSk1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'6'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Ilmu Pengetahuan Sosial'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,	number_format( ($qSTK1+$qSTK2 + $qSTK3+$qSTK4 + $qSTK5+$qSTK6)/6 ,0,',','.' )		,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgK			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($IPSk1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($IPSk1,100,57)			,'LR',0,L,true);
	
	//eng
	$qENG ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='ENG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rENG=mysql_query($qENG) or die('Query gagal');
	$dENG =mysql_fetch_array($rENG);
	
	$qSTK1	=$dENG['qg_k13_'.$sms.'1']; // q
	$qSTK2	=$dENG['qg_k13_'.$sms.'2']; // q
	
	$qK = number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' );
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
	{
		$lgK = 'A';
		$ENGk1 = "Sangat mampu memahami house and home, tall tales, favourite things, school stories.";
	}
	else if($qK>=80)
	{
		$lgK = 'B';
		$ENGk1 = "Mampu memahami house and home, tall tales,         favourite things, school stories.";
	}
	else if($qK>=70)
	{
		$lgK = 'C';
		$ENGk1 = "Cukup mampu memahami house and home, tall tales,  favourite things, school stories.";
	}
	else if($qK>=0)
	{
		$lgK = 'D';
		$ENGk1 = "";
	}
	else //if($qK==0)
		$lgK = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ENGk1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'7'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Bahasa Inggris'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgK			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ENGk1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ENGk1,100,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 1.3	,0.5,'',0,0,L); 
	$pdf->Cell( 18.1	,0.5,'KELOMPOK B'			,'LRTB',0,L,true);
	
	//art
	$qART ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='ART'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rART=mysql_query($qART) or die('Query gagal');
	$dART =mysql_fetch_array($rART);
	
	$qSTK1	=$dART['qg_k13_'.$sms.'1']; // q
	$qSTK2	=$dART['qg_k13_'.$sms.'2']; // q
	
	$qK = number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' );
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
	{
		$lgK = 'A';
		$ARTk1 = "Sangat mampu memahami konsep dasar bernyanyi dan konsep dasar alat musik sederhana.";
	}
	else if($qK>=80)
	{
		$lgK = 'B';
		$ARTk1 = "Mampu memahami konsep dasar bernyanyi dan konsep  dasar alat musik sederhana.";
	}
	else if($qK>=70)
	{
		$lgK = 'C';
		$ARTk1 = "Cukup mampu memahami konsep dasar bernyanyi dan   konsep dasar alat musik sederhana.";
	}
	else if($qK>=0)
	{
		$lgK = 'D';
		$ARTk1 = "";
	}
	else //if($qK==0)
		$lgK = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ARTk1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'8'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Seni Budaya'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgK			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ARTk1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ARTk1,100,50)			,'LR',0,L,true);
	
	//pe
	$qPE ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='PE'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rPE=mysql_query($qPE) or die('Query gagal');
	$dPE =mysql_fetch_array($rPE);
	
	$qSTK1	=$dPE['qg_k13_'.$sms.'1']; // q
	$qSTK2	=$dPE['qg_k13_'.$sms.'2']; // q
	
	$qK = number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' );
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
	{
		$lgK = 'A';
		$PEk1 = "Sangat mampu memahami permainan bola basket, badminton, renang gaya dada dan senam aerobik.";
	}
	else if($qK>=80)
	{
		$lgK = 'B';
		$PEk1 = "Mampu memahami permainan bola basket, badminton,  renang gaya dada dan senam aerobik.";
	}
	else if($qK>=70)
	{
		$lgK = 'C';
		$PEk1 = "Cukup mampu memahami permainan bola basket, badminton, renang gaya dada dan senam aerobik.";
	}
	else if($qK>=0)
	{
		$lgK = 'D';
		$PEk1 = "";
	}
	else //if($qK==0)
		$lgK = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'9'			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,'Pendidikan Jasmani, Olah '			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($PEk1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Raga, dan Kesehatan'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4, number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgK			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($PEk1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($PEk1,100,50)			,'LR',0,L,true);
	
	//ict
	$qICT ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='ICT'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rICT=mysql_query($qICT) or die('Query gagal');
	$dICT =mysql_fetch_array($rICT);
	
	$qSTK1	=$dICT['qg_k13_'.$sms.'1']; // q
	$qSTK2	=$dICT['qg_k13_'.$sms.'2']; // q
	
	$qK = number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' );
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
	{
		$lgK = 'A';
		$ICTk1 = "Sangat memahami pengetahuan tentang jenis, sifat, karakter, teknik, prinsip, pembuatan dan penyajian kerajinan dari bahan serat dan tekstil.";
	}
	else if($qK>=80)
	{
		$lgK = 'B';
		$ICTk1 = "Mampu memahami pengetahuan tentang jenis, sifat,  karakter, teknik, prinsip, pembuatan dan penyajian kerajinan dari bahan serat.";
	}
	else if($qK>=70)
	{
		$lgK = 'C';
		$ICTk1 = "Cukup memahami pengetahuan tentang jenis, sifat,  karakter, teknik, prinsip, pembuatan dan penyajian kerajinan dari bahan serat.";
	}
	else if($qK>=0)
	{
		$lgK = 'D';
		$ICTk1 = "";
	}
	else //if($qK==0)
		$lgK = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ICTk1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'10'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Prakarya'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4, number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgK			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ICTk1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ICTk1,100,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 1.3	,0.5,'',0,0,L); 
	$pdf->Cell( 18.1	,0.5,'KELOMPOK C: MUATAN LOKAL'			,'LRTB',0,L,true);
	
	//PLKJ
	$qPLKJ ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$kdekls'		AND
							t_prgrptps_smp_k13.kdeplj='PLKJ'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rPLKJ=mysql_query($qPLKJ) or die('Query gagal');
	$dPLKJ =mysql_fetch_array($rPLKJ);
	
	$qSTK1	=$dPLKJ['qg_k13_'.$sms.'1']; // q
	$qSTK2	=$dPLKJ['qg_k13_'.$sms.'2']; // q
	
	$qK = number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' );
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
	{
		$lgK = 'A';
		$PLKJk1 = "Sangat mampu menjelaskan pengertian penduduk  DKI Jakarta dan kehidupan sosial di DKI Jakarta.";
	}
	else if($qK>=80)
	{
		$lgK = 'B';
		$PLKJk1 = "Mampu menjelaskan pengertian penduduk  DKI Jakarta dan kehidupan sosial di DKI Jakarta.";
	}
	else if($qK>=70)
	{
		$lgK = 'C';
		$PLKJk1 = "Cukup mampu menjelaskan pengertian penduduk  DKI  Jakarta dan kehidupan sosial di DKI Jakarta.";
	}
	else if($qK>=0)
	{
		$lgK = 'D';
		$PLKJk1 = "";
	}
	else //if($qK==0)
		$lgK = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($PLKJk1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'11'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'PLKJ'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4, number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgK			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($PLKJk1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($PLKJk1,100,50)			,'LR',0,L,true);
	
	//for
	$strFOR='';
	
	$qFOR ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='". mysql_escape_string($kdekls)."'		AND
							t_prgrptps_smp_k13.kdeplj='GRM'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rFOR=mysql_query($qFOR) or die('Query gagal');//german
	$dFOR =mysql_fetch_array($rFOR);
	$qFORstk=$dFOR['qg_k13_'.$sms.$midtrm]; // q
	
	if( $qFORstk=='0' )
	{
		$strFOR='Mandarin';
		
		$qFOR ="	SELECT 		t_prgrptps_smp_k13.*
					FROM 		t_prgrptps_smp_k13
					WHERE		t_prgrptps_smp_k13.nis='". mysql_escape_string($kdekls)."'		AND
								t_prgrptps_smp_k13.kdeplj='MND'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
		$rFOR=mysql_query($qFOR) or die('Query gagal');//mandarin
		$dFOR =mysql_fetch_array($rFOR);
	}
	else
		$strFOR='Jerman';
	
	$qSTK1	=$dFOR['qg_k13_'.$sms.'1']; // q
	$qSTK2	=$dFOR['qg_k13_'.$sms.'2']; // q
	
	$qK = number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' );
	
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
	{
		$lgK = 'A';
		
		if($strFOR=='Mandarin')
			$FORk1 = "Sangat mampu memahami konsep menyapa, berterima   kasih, maaf, dialog keseharian, makan, olah raga  dan hobi.";
		else //if($strFOR=='Jerman')
			$FORk1 = "Sangat memahami konsep menyapa, indentitas diri dan artikel kata benda.";
	}
	else if($qK>=80)
	{
		$lgK = 'B';
		
		if($strFOR=='Mandarin')
			$FORk1 = "Mampu memahami konsep menyapa, berterima kasih, maaf, dialog keseharian, makan, olah raga dan hobi.";
		else //if($strFOR=='Jerman')
			$FORk1 = "Mampu memahami konsep menyapa, indentitas diri dan artikel kata benda.";
	}
	else if($qK>=70)
	{
		$lgK = 'C';
		
		if($strFOR=='Mandarin')
			$FORk1 = "Cukup mampu memahami konsep menyapa, berterima kasih, maaf, dialog keseharian, makan, olah raga dan hobi.";
		else //if($strFOR=='Jerman')
			$FORk1 = "Cukup memahami konsep menyapa, indentitas diri dan artikel kata benda.";
	}
	else if($qK>=0)
	{
		$lgK = 'D';
		
		if($strFOR=='Mandarin')
			$FORk1 = "";
		else //if($strFOR=='Jerman')
			$FORk1 = "";
	}
	else //if($qK==0)
		$lgK = "ERR";
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 3	,0.4,''			,'LRT',0,L,true);$pdf->Cell( 2	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($FORk1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'12'			,'LR',0,C,true);
	$pdf->Cell( 3	,0.4,'Bahasa Asing'	,'LR',0,L,true);$pdf->Cell( 2	,0.4,$strFOR			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4, number_format( ($qSTK1+$qSTK2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgK			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($FORk1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRB',0,C,true);
	$pdf->Cell( 3	,0.4,''			,'LRB',0,L,true);$pdf->Cell( 2	,0.4,''			,'LRB',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LRB',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LRB',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($FORk1,100,50)			,'LRB',0,L,true);
	
	
	
	//awal halaman 5
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "Nama Sekolah  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 1, "Saint John's School", '', 0, L, true);									$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,1,'','',0,C,false);	$pdf->Cell(2.1, 1, "Kelas", '', 0, L, true);			$pdf->Cell( 0.4	,1,'','',0,C,false);	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,1,'','',0,C,false);	$pdf->SetFont('Arial','U',9);	$pdf->Cell(0.4, 1, $kelas3, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "Alamat  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.4, "Jl. Taman Palem Raya Blok D1 No.", '', 0, L, true);					$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,1,'','',0,C,false);	$pdf->Cell(2.1, 1, "Semester", '', 0, L, true);			$pdf->Cell( 0.4	,1,'','',0,C,false);	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,1,'','',0,C,false);	$pdf->SetFont('Arial','U',9);	$pdf->Cell(0.4, 1, $semester3, '', 0, L, true);
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "  ", '', 0, L, false);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "   ", '', 0, L, false);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.4, "1, Villa Meruya", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "Nama  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 1, $nmassw, '', 0, L, true);												$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,1,'','',0,C,false);	$pdf->Cell(2.1, 1, "Tahun Pelajaran", '', 0, L, true);	$pdf->Cell( 0.4	,1,'','',0,C,false);	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,1,'','',0,C,false);	$pdf->SetFont('Arial','U',9);	$pdf->Cell(0.4, 1, $thnajar3, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "NISN  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 1, $nisn, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(18   ,0,'',1);
	$pdf->Ln();
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"C.",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Keterampilan",0,0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"Kriteria Ketuntasan Minimal = 70",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"",0,0,L);
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,1,'NO'			,'LRTB',0,C,true);
	$pdf->Cell( 5	,1,'Mata Pelajaran'			,'LRTB',0,C,true);
	$pdf->Cell( 2	,0.4,'Nilai'			,'LRTB',0,C,true);
	$pdf->Cell( 2	,0.4,'Predikat'			,'LRTB',0,C,true);
	$pdf->Cell( 8.5	,1,'Deskripsi'			,'LRTB',0,C,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.3	,0.4,'','',0,L,false); 
	$pdf->Cell( 0.6	,1,''			,'',0,C,false);
	$pdf->Cell( 5	,1,''			,'',0,C,false);
	$pdf->Cell( 2	,0.4,'1-100'			,'LRTB',0,C,true);
	$pdf->Cell( 2	,0.4,'A-D'			,'LRTB',0,C,true);
	$pdf->Cell( 8.5	,1,''			,'',0,C,false);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 1.3	,0.,'',0,0,L); 
	$pdf->Cell( 18.1	,0.5,'KELOMPOK A'			,'LRTB',0,L,true);
	
	//rlg
	$qSTS1	=$dRLG['qg_k14_'.$sms.'1']; // q
	$qSTS2	=$dRLG['qg_k14_'.$sms.'2']; // q
	
	$qS = number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' );
		
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
	{
		$lgS = 'A';
		$RLGs1 = "Sangat mampu  mengungkapkan rasa syukur sebagai citra Allah,gender dan seksualitas sebagai anugerah Allah.";
	}
	else if($qS>=80)
	{
		$lgS = 'B';
		$RLGs1 = "Mampu mengungkapkan rasa syukur sebagai citra     Allah,gender dan seksualitas sebagai anugerah     Allah.";
	}
	else if($qS>=70)
	{
		$lgS = 'C';
		$RLGs1 = "Cukup mampu  mengungkapkan rasa syukur sebagai citra Allah,gender dan seksualitas sebagai anugerah Allah.";
	}
	else if($qS>=0)
	{
		$lgS = 'D';
		$RLGs1 = "";
	}
	else //if($qS==0)
		$lgS = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'1'			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,'Pendidikan Agama dan Budi'			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($RLGs1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Pekerti'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgS			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($RLGs1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($RLGs1,100,50)			,'LR',0,L,true);
	
	//cme
	$qSTS1	=$dCME['qg_k14_'.$sms.'1']; // q
	$qSTS2	=$dCME['qg_k14_'.$sms.'2']; // q
	
	$qS = number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' );
		
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
	{
		$lgS = 'A';
		$CMEs1 = "Sangat mampu menyaji analisis perumusan Pancasila dan UUD 1945, serta perilaku yang sesuai dengan   norma.";
	}
	else if($qS>=80)
	{
		$lgS = 'B';
		$CMEs1 = "Mampu menyaji analisis perumusan Pancasila dan UUD 1945, serta perilaku yang sesuai dengan norma.";
	}
	else if($qS>=70)
	{
		$lgS = 'C';
		$CMEs1 = "Cukup mampu menyaji analisis perumusan Pancasila  dan UUD 1945, serta perilaku yang sesuai dengan   norma.";
	}
	else if($qS>=0)
	{
		$lgS = 'D';
		$CMEs1 = "";
	}
	else //if($qS==0)
		$lgS = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'2'			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,'Pendidikan Pancasila dan '			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($CMEs1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Kewarganegaraan'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgS			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($CMEs1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($CMEs1,100,50)			,'LR',0,L,true);
	
	//bin
	$qSTS1	=$dBIN['qg_k14_'.$sms.'1']; // q
	$qSTS2	=$dBIN['qg_k14_'.$sms.'2']; // q
	
	$qS = number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' );
		
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
	{
		$lgS = 'A';
		$BINs1 = "Sangat mampu menyaji dalam ranah konkret dan ranah abstrak sesuai dengan yang dipelajari di sekolah dan sumber lain yang sama dalam sudut pandang/teori.";
	}
	else if($qS>=80)
	{
		$lgS = 'B';
		$BINs1 = "Mampu menyaji dalam ranah konkret dan ranah       abstrak sesuai dengan yang dipelajari di sekolah  dan sumber lain yang sama dalam sudut pandang/teori.";
	}
	else if($qS>=70)
	{
		$lgS = 'C';
		$BINs1 = "Cukup mampu menyaji dalam ranah konkret dan ranah abstrak sesuai dengan yang dipelajari di sekolah  dan sumber lain yang sama dalam sudut pandang/teori.";
	}
	else if($qS>=0)
	{
		$lgS = 'D';
		$BINs1 = "";
	}
	else //if($qS==0)
		$lgS = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($BINs1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'3'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Bahasa Indonesia'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgS			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($BINs1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($BINs1,100,51)			,'LR',0,L,true);
	
	//mth
	$qSTS1	=$dMTH['qg_k14_'.$sms.'1']; // q
	$qSTS2	=$dMTH['qg_k14_'.$sms.'2']; // q
	
	$qS = number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' );
		
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
	{
		$lgS = 'A';
		$MTHs1 = "Sangat mampu menyajikan konsep Linear equation and simple inequalities, functions and linear graphs.";
	}
	else if($qS>=80)
	{
		$lgS = 'B';
		$MTHs1 = "Mampu menyajikan konsep Linear equation and simple inequalities, functions and linear graphs.";
	}
	else if($qS>=70)
	{
		$lgS = 'C';
		$MTHs1 = "Cukup mampu menyajikan konsep Linear equation and simple inequalities, functions and linear graphs.";
	}
	else if($qS>=0)
	{
		$lgS = 'D';
		$MTHs1 = "Kurang mampu menyajikan konsep Linear equation and simple inequalities, functions and linear graphs.";
	}
	else //if($qS==0)
		$lgS = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($MTHs1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'4'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Matematika'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgS			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($MTHs1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($MTHs1,100,50)			,'LR',0,L,true);
	
	//ipa
	$qSTS1	=$dBLGY['qg_k14_'.$sms.'1']; // q
	$qSTS2	=$dBLGY['qg_k14_'.$sms.'2']; // q
	
	$qSTS3	=$dPHY['qg_k14_'.$sms.'1']; // q
	$qSTS4	=$dPHY['qg_k14_'.$sms.'2']; // q
	
	$qS = number_format( ($qSTS1+$qSTS2 + $qSTS3+$qSTS4)/4 ,0,',','.' );
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
	{
		$lgS = 'A';
		$IPAs1 = "Sangat mampu menyajikan karakteristik dan klasifikasi mahluk hidup, pengenalan laboratorium, organisasi kehidupan, dan wujud dan klasifikasi zat.";
	}
	else if($qS>=80)
	{
		$lgS = 'B';
		$IPAs1 = "Mampu menyajikan karakteristik dan klasifikasi mahluk hidup, pengenalan laboratorium, organisasi kehidupan, dan wujud dan klasifikasi zat.";
	}
	else if($qS>=70)
	{
		$lgS = 'C';
		$IPAs1 = "Cukup mampu menyajikan karakteristik dan klasifikasi mahluk hidup, pengenalan laboratorium, organisasi kehidupan, dan wujud dan klasifikasi zat.";
	}
	else if($qS>=0)
	{
		$lgS = 'D';
		$IPAs1 = "Kurang mampu menyajikan karakteristik dan         klasifikasi mahluk hidup, pengenalan laboratorium, organisasi kehidupan, dan wujud dan klasifikasi zat.";
	}
	else //if($qS==0)
		$lgS = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($IPAs1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'5'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Ilmu Pengetahuan Alam'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTS1+$qSTS2 + $qSTS3+$qSTS4)/4 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgS			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($IPAs1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($IPAs1,100,54)			,'LR',0,L,true);
	
	//ips
	$qSTS1	=$dECN['qg_k14_'.$sms.'1']; // q
	$qSTS2	=$dECN['qg_k14_'.$sms.'2']; // q
	
	$qSTS3	=$dGGRY['qg_k14_'.$sms.'1']; // q
	$qSTS4	=$dGGRY['qg_k14_'.$sms.'2']; // q
	
	$qSTS5	=$dHIST['qg_k14_'.$sms.'1']; // q
	$qSTS6	=$dHIST['qg_k14_'.$sms.'2']; // q
	
	$qS = number_format( ($qSTS1+$qSTS2 + $qSTS3+$qSTS4 + $qSTS5+$qSTS6)/6 ,0,',','.' );
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
	{
		$lgS = 'A';
		$IPSs1 = "Sangat mampu menyajikan hasil kebudayaan dan pikiran masyarakat Indonesia pada masa praaksara, masa hindu buddha dan masa Islam.";
	}
	else if($qS>=80)
	{
		$lgS = 'B';
		$IPSs1 = "Mampu menyajikan hasil kebudayaan dan pikiran     masyarakat Indonesia pada masa praaksara, masa    hindu buddha dan masa Islam.";
	}
	else if($qS>=70)
	{
		$lgS = 'C';
		$IPSs1 = "Cukup mampu menyajikan hasil kebudayaan dan       pikiran masyarakat Indonesia pada masa praaksara, masa hindu buddha dan masa Islam.";
	}
	else if($qS>=0)
	{
		$lgS = 'D';
		$IPSs1 = "";
	}
	else //if($qS==0)
		$lgS = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($IPSs1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'6'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Ilmu Pengetahuan Sosial'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTS1+$qSTS2 + $qSTS3+$qSTS4 + $qSTS5+$qSTS6)/6 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgS			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($IPSs1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($IPSs1,100,50)			,'LR',0,L,true);
	
	//eng
	$qSTS1	=$dENG['qg_k14_'.$sms.'1']; // q
	$qSTS2	=$dENG['qg_k14_'.$sms.'2']; // q
	
	$qS = number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' );
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
	{
		$lgS = 'A';
		$ENGs1 = "Sangat mampu menyajikan house and home, tall tales, favourite things, school stories.";
	}
	else if($qS>=80)
	{
		$lgS = 'B';
		$ENGs1 = "Mampu menyajikan house and home, tall tales,      favourite things, school stories.";
	}
	else if($qS>=70)
	{
		$lgS = 'C';
		$ENGs1 = "Cukup mampu menyajikan house and home, tall tales, favourite things, school stories.";
	}
	else if($qS>=0)
	{
		$lgS = 'D';
		$ENGs1 = "";
	}
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ENGs1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'7'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Bahasa Inggris'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgS			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ENGs1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ENGs1,100,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 1.3	,0.5,'',0,0,L); 
	$pdf->Cell( 18.1	,0.5,'KELOMPOK B'			,'LRTB',0,L,true);
	
	//art
	$qSTS1	=$dART['qg_k14_'.$sms.'1']; // q
	$qSTS2	=$dART['qg_k14_'.$sms.'2']; // q
	
	$qS = number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' );
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
	{
		$lgS = 'A';
		$ARTs1 = "Sangat mampu menyanyikan lagu dan memainkan alat musik sederhana.";
	}
	else if($qS>=80)
	{
		$lgS = 'B';
		$ARTs1 = "Mampu menyanyikan lagu dan memainkan alat musik   sederhana.";
	}
	else if($qS>=70)
	{
		$lgS = 'C';
		$ARTs1 = "Cukup mampu menyanyikan lagu dan memainkan alat musik sederhana.";
	}
	else if($qS>=0)
	{
		$lgS = 'D';
		$ARTs1 = "";
	}
	else //if($qS==0)
		$lgS = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ARTs1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'8'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Seni Budaya'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgS			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ARTs1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ARTs1,100,50)			,'LR',0,L,true);
	
	//pe
	$qSTS1	=$dPE['qg_k14_'.$sms.'1']; // q
	$qSTS2	=$dPE['qg_k14_'.$sms.'2']; // q
	
	$qS = number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' );
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
	{
		$lgS = 'A';
		$PEs1 = "Sangat mampu mempraktekan permainan bola basket, badminton, renang gaya dada dan senam aerobik.";
	}
	else if($qS>=80)
	{
		$lgS = 'B';
		$PEs1 = "Mampu mempraktekan permainan bola basket,         badminton, renang gaya dada dan senam aerobik.";
	}
	else if($qS>=70)
	{
		$lgS = 'C';
		$PEs1 = "Cukup mampu mempraktekan permainan bola basket, badminton, renang gaya dada dan senam aerobik.";
	}
	else if($qS>=0)
	{
		$lgS = 'D';
		$PEs1 = "";
	}
	else //if($qS==0)
		$lgS = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'9'			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,'Pendidikan Jasmani, Olah '			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($PEs1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Raga, dan Kesehatan'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4, number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgS			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($PEs1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($PEs1,100,50)			,'LR',0,L,true);
	
	//ict
	$qSTS1	=$dICT['qg_k14_'.$sms.'1']; // q
	$qSTS2	=$dICT['qg_k14_'.$sms.'2']; // q
	
	$qS = number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' );
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
	{
		$lgS = 'A';
		$ICTs1 = "Sangat mampu mengolah dan menyajikan product kerajinan dari bahan serat dan tekstil.";
	}
	else if($qS>=80)
	{
		$lgS = 'B';
		$ICTs1 = "Mampu mengolah dan menyajikan product kerajinan   dari bahan serat dan tekstil. ";
	}
	else if($qS>=70)
	{
		$lgS = 'C';
		$ICTs1 = "Cukup mampu mengolah dan menyajikan product       kerajinan dari bahan serat dan tekstil.";
	}
	else if($qS>=0)
	{
		$lgS = 'D';
		$ICTs1 = "";
	}
	else //if($qS==0)
		$lgS = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ICTs1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'10'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'Prakarya'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$qS			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ICTs1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($ICTs1,100,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 1.3	,0.5,'',0,0,L); 
	$pdf->Cell( 18.1	,0.5,'KELOMPOK C: MUATAN LOKAL'			,'LRTB',0,L,true);
	
	//PLKJ
	$qSTS1	=$dPLKJ['qg_k14_'.$sms.'1']; // q
	$qSTS2	=$dPLKJ['qg_k14_'.$sms.'2']; // q
	
	$qS = number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' );
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
	{
		$lgS = 'A';
		$PLKJs1 = "Sangat mampu menerapkan nilai - nilai budi pekerti dalam kehidupan sosial di DKI Jakarta.";
	}
	else if($qS>=80)
	{
		$lgS = 'B';
		$PLKJs1 = "Mampu menerapkan nilai - nilai budi pekerti dalam kehidupan sosial di DKI Jakarta.";
	}
	else if($qS>=70)
	{
		$lgS = 'C';
		$PLKJs1 = "Cukup mampu menerapkan nilai - nilai budi pekerti dalam kehidupan sosial di DKI Jakarta.";
	}
	else if($qS>=0)
	{
		$lgS = 'D';
		$PLKJs1 = "";
	}
	else //if($qS==0)
		$lgS = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($PLKJs1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'11'			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,'PLKJ'			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgS			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($PLKJs1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LR',0,C,true);
	$pdf->Cell( 5	,0.4,''			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($PLKJs1,100,50)			,'LR',0,L,true);
	
	//for
	$qSTS1	=$dFOR['qg_k14_'.$sms.'1']; // q
	$qSTS2	=$dFOR['qg_k14_'.$sms.'2']; // q
	
	$qS = number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' );
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
	{
		$lgS = 'A';
		
		if($strFOR=='Mandarin')
			$FORs1 = "Sangat mampu mempraktekan konsep menyapa,         berterima kasih, maaf, dialog keseharian, makan,  olah raga dan hobi.";
		else //if($strFOR=='Jerman')
			$FORs1 = "Sangat mampu mempraktekan konsep menyapa, indentitas diri dan artikel kata benda.";
	}
	else if($qS>=80)
	{
		$lgS = 'B';
		
		if($strFOR=='Mandarin')
			$FORs1 = "Mampu mempraktekan konsep menyapa, berterima kasih, maaf, dialog keseharian, makan, olah raga dan hobi.";
		else //if($strFOR=='Jerman')
			$FORs1 = "Mampu mempraktekan konsep menyapa, indentitas diri dan artikel kata benda.";
	}
	else if($qS>=70)
	{
		$lgS = 'C';
		
		if($strFOR=='Mandarin')
			$FORs1 = "Cukup memahami konsep menyapa, indentitas diri dan artikel kata benda.";
		else //if($strFOR=='Jerman')
			$FORs1 = "Cukup mampu mempraktekan konsep menyapa,          indentitas diri dan artikel kata benda.";
	}
	else if($qS>=0)
	{
		$lgS = 'D';
		
		if($strFOR=='Mandarin')
			$FORs1 = "";
		else //if($strFOR=='Jerman')
			$FORs1 = "";
	}
	else //if($qS==0)
		$lgS = "ERR";
		
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRT',0,C,true);
	$pdf->Cell( 3	,0.4,''			,'LRT',0,L,true);$pdf->Cell( 2	,0.4,''			,'LRT',0,L,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->Cell( 2	,1.2,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($FORs1,0,50)			,'LRT',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,'12'			,'LR',0,C,true);
	$pdf->Cell( 3	,0.4,'Bahasa Asing'	,'LR',0,L,true);$pdf->Cell( 2	,0.4,$strFOR			,'LR',0,L,true);
	$pdf->Cell( 2	,0.4,number_format( ($qSTS1+$qSTS2)/2 ,0,',','.' )			,'LR',0,C,false);
	$pdf->Cell( 2	,0.4,$lgS			,'LR',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($FORs1,50,50)			,'LR',0,L,true);
	
	$pdf->Ln(0.4);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'LRB',0,C,true);
	$pdf->Cell( 3	,0.4,''			,'LRB',0,L,true);$pdf->Cell( 2	,0.4,''			,'LRB',0,L,true);
	$pdf->Cell( 2	,0.4,''			,'LRB',0,C,false);
	$pdf->Cell( 2	,0.4,''			,'LRB',0,C,false);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 8.5	,0.4,substr($FORs1,100,50)			,'LRB',0,L,true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'',0,C,false);
	$pdf->Cell( 2	,0.6,'KKM'			,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.6,'D'			,'LRTB',0,C,false);
	$pdf->Cell( 2	,0.6,'C'			,'LRTB',0,C,false);
	$pdf->Cell( 2	,0.6,'B'			,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.6,'A'			,'LRTB',0,L,true);
	
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 1.3	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,0.4,''			,'',0,C,false);
	$pdf->Cell( 2	,0.8,'70'			,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.8,'<= 69'			,'LRTB',0,C,false);
	$pdf->Cell( 2	,0.8,'>= 70'			,'LRTB',0,C,false);
	$pdf->Cell( 2	,0.8,'>= 80'			,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.8,'>= 90'			,'LRTB',0,L,true);
	
	
	
	//..awal halaman 6
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "Nama Sekolah  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 1, "Saint John's School", '', 0, L, true);									$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,1,'','',0,C,false);	$pdf->Cell(2.1, 1, "Kelas", '', 0, L, true);			$pdf->Cell( 0.4	,1,'','',0,C,false);	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,1,'','',0,C,false);	$pdf->SetFont('Arial','U',9);	$pdf->Cell(0.4, 1, $kelas3, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "Alamat  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.4, "Jl. Taman Palem Raya Blok D1 No.", '', 0, L, true);					$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,1,'','',0,C,false);	$pdf->Cell(2.1, 1, "Semester", '', 0, L, true);			$pdf->Cell( 0.4	,1,'','',0,C,false);	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,1,'','',0,C,false);	$pdf->SetFont('Arial','U',9);	$pdf->Cell(0.4, 1, $semester3, '', 0, L, true);
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "  ", '', 0, L, false);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "   ", '', 0, L, false);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 0.4, "1, Villa Meruya", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "Nama  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 1, $nmassw, '', 0, L, true);												$pdf->SetFont('Arial','B',9);	$pdf->Cell( 5.5	,1,'','',0,C,false);	$pdf->Cell(2.1, 1, "Tahun Pelajaran", '', 0, L, true);	$pdf->Cell( 0.4	,1,'','',0,C,false);	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);		$pdf->Cell( 0.1	,1,'','',0,C,false);	$pdf->SetFont('Arial','U',9);	$pdf->Cell(0.4, 1, $thnajar3, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(2, 1, "NISN  ", '', 0, L, true);
	$pdf->Cell( 0.4	,1,'','',0,C,false);
	$pdf->Cell(0.4, 1, "  : ", '', 0, L, true);
	$pdf->Cell( 0.1	,1,'','',0,C,false);
	$pdf->SetFont('Arial','U',9);
	$pdf->Cell(1.2, 1, $nisn, '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Cell( 1.3	,1,'','',0,C,false);
	$pdf->Cell(18   ,0,'',1);
	$pdf->Ln();
	
	//d. ektra kurikuler
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"D.",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Ektra Kurikuler",0,0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.6,"",0,0,L); 
	$pdf->Cell( 0.4	,0.6,"",0,0,L); 
	$pdf->Cell( 5	,0.6,"Kegiatan Ektra Kurikuler",'LRTB',0,L);
	$pdf->Cell( 2	,0.6,"Predikat",'LRTB',0,C);
	$pdf->Cell( 10	,0.6,"Keterangan",'LRTB',0,C);
	
	$nmaPil1='';
	$nliPil1='';
	$ktrPil1='';
	
	$nmaPil2='';
	$nliPil2='';
	$ktrPil2='';
	
	$nmaPil3='';
	$nliPil3='';
	$ktrPil3='';
	
	//pramuka
	$qPMK	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$kdekls'	AND
							t_extcrrps.kdeplj='PMK' "; // extra kurikuler
	$rPMK=mysql_query($qPMK) or die('Query gagal40');
	$dPMK =mysql_fetch_array($rPMK);
	$q1PMK=$dPMK['ext'.$sms.'2']; // q1 PMK 'ext'		$midtrm
	if($q1PMK!='')
	{
		$nmaPil1='Pramuka';
		$nliPil1=$q1PMK;
		
		if($q1PMK=='A')
			$ktrPil1='Memiliki kepimimpinan dan kerjasama yang sangat baik. Selalu aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1PMK=='B')
			$ktrPil1='Memiliki kepimimpinan dan kerjasama yang  baik. Aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1PMK=='C')
			$ktrPil1='Memiliki kepimimpinan dan kerjasama yang  cukup  baik.Kurang aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1PMK=='D')
			$ktrPil1='Memiliki kepimimpinan dan kerjasama yang  tidak  baik.Tidak aktif mengikuti kegiatan ekstrakurikuler.';
		else //if($q1PMK=='NA')
			$ktrPil1='-';
	}
	else
	{
		$nmaPil1='-';
		$nliPil1='-';
		$ktrPil1='-';
	}
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.8,"",0,0,L); 
	$pdf->Cell( 0.4	,0.8,"",0,0,L);
	$pdf->Cell( 1	,0.8,"1",'LRTB',0,C);
	$pdf->Cell( 4	,0.8,$nmaPil1,'LRTB',0,C);
	$pdf->Cell( 2	,0.8,$nliPil1,'LRTB',0,C);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 10	,0.4,substr($ktrPil1,0,53),'LRT',0,L);
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.8,"",'',0,L,false); 
	$pdf->Cell( 0.4	,0.8,"",'',0,L,false);
	$pdf->Cell( 1	,0.8,"",'',0,C,false);
	$pdf->Cell( 4	,0.8,"",'',0,L,false);
	$pdf->Cell( 2	,0.8,"",'',0,C,false);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 10	,0.4,substr($ktrPil1,53,53),'LR',0,L);
	
	//futsal
	$qFTS	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$kdekls'	AND
							t_extcrrps.kdeplj='FTS' "; // extra kurikuler
	$rFTS=mysql_query($qFTS) or die('Query gagal40');
	$dFTS =mysql_fetch_array($rFTS);
	$q1FTS=$dFTS['ext'.$sms.'2']; // q1 FTS 'ext'
	if($q1FTS!='')
	{
		$nmaPil2='Futsal';
		$nliPil2=$q1FTS;
		
		if($q1FTS=='A')
			$ktrPil2='Memiliki kepimimpinan dan kerjasama yang sangat baik. Selalu aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1FTS=='B')
			$ktrPil2='Memiliki kepimimpinan dan kerjasama yang  baik. Aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1FTS=='C')
			$ktrPil2='Memiliki kepimimpinan dan kerjasama yang  cukup  baik.Kurang aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1FTS=='D')
			$ktrPil2='Memiliki kepimimpinan dan kerjasama yang  tidak  baik.Tidak aktif mengikuti kegiatan ekstrakurikuler.';
		else //if($q1FTS=='NA')
			$ktrPil2='-';
	}
		
	//basket
	$qBSK	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$kdekls'	AND
							t_extcrrps.kdeplj='BSK' "; // extra kurikuler
	$rBSK=mysql_query($qBSK) or die('Query gagal40');
	$dBSK =mysql_fetch_array($rBSK);
	$q1BSK=$dBSK['ext'.$sms.'2']; // q1 BSK 'ext'
	if($q1BSK!='')
	{
		$nmaPil2='Basket';
		$nliPil2=$q1BSK;
		
		if($q1BSK=='A')
			$ktrPil2='Memiliki kepimimpinan dan kerjasama yang sangat baik. Selalu aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1BSK=='B')
			$ktrPil2='Memiliki kepimimpinan dan kerjasama yang  baik. Aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1BSK=='C')
			$ktrPil2='Memiliki kepimimpinan dan kerjasama yang  cukup  baik.Kurang aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1BSK=='D')
			$ktrPil2='Memiliki kepimimpinan dan kerjasama yang  tidak  baik.Tidak aktif mengikuti kegiatan ekstrakurikuler.';
		else //if($q1BSK=='NA')
			$ktrPil2='-';
	}
		
	//TABLE tenni
	$qTNS	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$kdekls'	AND
							t_extcrrps.kdeplj='TNS' "; // extra kurikuler
	$rTNS=mysql_query($qTNS) or die('Query gagal40');
	$dTNS =mysql_fetch_array($rTNS);
	$q1TNS=$dTNS['ext'.$sms.'2']; // q1 TNS 'ext'
	if($q1TNS!='')
	{
		$nmaPil2='Table Tennis';
		$nliPil2=$q1TNS;
		
		if($q1TNS=='A')
			$ktrPil2='Memiliki kepimimpinan dan kerjasama yang sangat baik. Selalu aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1TNS=='B')
			$ktrPil2='Memiliki kepimimpinan dan kerjasama yang  baik. Aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1TNS=='C')
			$ktrPil2='Memiliki kepimimpinan dan kerjasama yang  cukup  baik.Kurang aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1TNS=='D')
			$ktrPil2='Memiliki kepimimpinan dan kerjasama yang  tidak  baik.Tidak aktif mengikuti kegiatan ekstrakurikuler.';
		else //if($q1TNS=='NA')
			$ktrPil2='-';
	}
	
	if($q1FTS=='' AND $q1BSK=='' AND $q1TNS=='')
	{
		$nmaPil2='-';
		$nliPil2='-';
		$ktrPil2='-';
	}
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.8,"",0,0,L); 
	$pdf->Cell( 0.4	,0.8,"",0,0,L);
	$pdf->Cell( 1	,0.8,"2",'LRTB',0,C);
	$pdf->Cell( 4	,0.8,$nmaPil2,'LRTB',0,C);
	$pdf->Cell( 2	,0.8,$nliPil2,'LRTB',0,C);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 10	,0.4,substr($ktrPil2,0,53),'LRT',0,L);
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.8,"",'',0,L,false); 
	$pdf->Cell( 0.4	,0.8,"",'',0,L,false);
	$pdf->Cell( 1	,0.8,"",'',0,C,false);
	$pdf->Cell( 4	,0.8,"",'',0,L,false);
	$pdf->Cell( 2	,0.8,"",'',0,C,false);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 10	,0.4,substr($ktrPil2,53,53),'LR',0,L);
	
	//Theatre art
	$qTHE	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$kdekls'	AND
							t_extcrrps.kdeplj='THE' "; // extra kurikuler
	$rTHE=mysql_query($qTHE) or die('Query gagal40');
	$dTHE =mysql_fetch_array($rTHE);
	$q1THE=$dTHE['ext'.$sms.'2']; // q1 THE 'ext'
	if($q1THE!='')
	{
		$nmaPil3='Theatre Art';
		$nliPil3=$q1THE;
		
		if($q1THE=='A')
			$ktrPil3='Memiliki kepimimpinan dan kerjasama yang sangat baik. Selalu aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1THE=='B')
			$ktrPil3='Memiliki kepimimpinan dan kerjasama yang  baik. Aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1THE=='C')
			$ktrPil3='Memiliki kepimimpinan dan kerjasama yang  cukup  baik.Kurang aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1THE=='D')
			$ktrPil3='Memiliki kepimimpinan dan kerjasama yang  tidak  baik.Tidak aktif mengikuti kegiatan ekstrakurikuler.';
		else //if($q1THE=='NA')
			$ktrPil3='-';
	}
	
	//Mandarin club
	$qMNDC	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$kdekls'	AND
							t_extcrrps.kdeplj='MNDC' "; // extra kurikuler
	$rMNDC=mysql_query($qMNDC) or die('Query gagal40');
	$dMNDC =mysql_fetch_array($rMNDC);
	$q1MNDC=$dMNDC['ext'.$sms.'2']; // q1 MNDC 'ext'
	if($q1MNDC!='')
	{
		$nmaPil3='Mandarin Club';
		$nliPil3=$q1MNDC;
		
		if($q1MNDC=='A')
			$ktrPil3='Memiliki kepimimpinan dan kerjasama yang sangat baik. Selalu aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1MNDC=='B')
			$ktrPil3='Memiliki kepimimpinan dan kerjasama yang  baik. Aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1MNDC=='C')
			$ktrPil3='Memiliki kepimimpinan dan kerjasama yang  cukup  baik.Kurang aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1MNDC=='D')
			$ktrPil3='Memiliki kepimimpinan dan kerjasama yang  tidak  baik.Tidak aktif mengikuti kegiatan ekstrakurikuler.';
		else //if($q1MNDC=='NA')
			$ktrPil3='-';
	}
	
	//modern dance
	$qMDR	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$kdekls'	AND
							t_extcrrps.kdeplj='MDR' "; // extra kurikuler
	$rMDR=mysql_query($qMDR) or die('Query gagal40');
	$dMDR =mysql_fetch_array($rMDR);
	$q1MDR=$dMDR['ext'.$sms.'2']; // q1 MDR 'ext'
	if($q1MDR!='')
	{
		$nmaPil3='Modern Dance';
		$nliPil3=$q1MDR;
		
		if($q1MDR=='A')
			$ktrPil3='Memiliki kepimimpinan dan kerjasama yang sangat baik. Selalu aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1MDR=='B')
			$ktrPil3='Memiliki kepimimpinan dan kerjasama yang  baik. Aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1MDR=='C')
			$ktrPil3='Memiliki kepimimpinan dan kerjasama yang  cukup  baik.Kurang aktif mengikuti kegiatan ekstrakurikuler.';
		else if($q1MDR=='D')
			$ktrPil3='Memiliki kepimimpinan dan kerjasama yang  tidak  baik.Tidak aktif mengikuti kegiatan ekstrakurikuler.';
		else //if($q1MDR=='NA')
			$ktrPil3='-';
	}
	
	if($q1THE=='' AND $q1MNDC=='' AND $q1MDR=='')
	{
		$nmaPil3='-';
		$nliPil3='-';
		$ktrPil3='-';
		
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell( 2	,0.8,"",0,0,L); 
		$pdf->Cell( 0.4	,0.8,"",0,0,L);
		$pdf->Cell( 1	,0.8,"3",'LRTB',0,C);
		$pdf->Cell( 4	,0.8,$nmaPil3,'LRTB',0,C);
		$pdf->Cell( 2	,0.8,$nliPil3,'LRTB',0,C);
		$pdf->Cell( 10	,0.8,substr($ktrPil3,0,53),'LRTB',0,L);
	}
	else
	{
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell( 2	,0.8,"",0,0,L); 
		$pdf->Cell( 0.4	,0.8,"",0,0,L);
		$pdf->Cell( 1	,0.8,"3",'LRTB',0,C);
		$pdf->Cell( 4	,0.8,$nmaPil3,'LRTB',0,C);
		$pdf->Cell( 2	,0.8,$nliPil3,'LRTB',0,C);
		$pdf->Cell( 10	,0.4,substr($ktrPil3,0,53),'LRT',0,L);
		
		$pdf->Ln(0.4);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell( 2	,0.8,"",'',0,L,false); 
		$pdf->Cell( 0.4	,0.8,"",'',0,L,false);
		$pdf->Cell( 1	,0.8,"",'',0,C,false);
		$pdf->Cell( 4	,0.8,"",'',0,L,false);
		$pdf->Cell( 2	,0.8,"",'',0,C,false);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell( 10	,0.4,substr($ktrPil3,53,53),'LRB',0,L);
	}
	
	//e. prestasi
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"E.",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Prestasi",0,0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.6,"",0,0,L); 
	$pdf->Cell( 0.4	,0.6,"",0,0,L); 
	$pdf->Cell( 1	,0.6,"No",'LRTB',0,C);
	$pdf->Cell( 6	,0.6,"Jenis Kegiatan",'LRTB',0,C);
	$pdf->Cell( 10	,0.6,"Keterangan",'LRTB',0,C);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.8,"",0,0,L); 
	$pdf->Cell( 0.4	,0.8,"",0,0,L);
	$pdf->Cell( 1	,0.8,"1",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"-",'LRTB',0,C);
	$pdf->Cell( 10	,0.8,"-",'LRT',0,L);//0.4
	
	/*$pdf->Ln(0.4);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.8,"",'',0,L,false); 
	$pdf->Cell( 0.4	,0.8,"",'',0,L,false);
	$pdf->Cell( 1	,0.8,"",'',0,C,false);
	$pdf->Cell( 6	,0.8,"",'',0,C,false);
	$pdf->Cell( 10	,0.4,"",'LR',0,L);*/
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.8,"",0,0,L); 
	$pdf->Cell( 0.4	,0.8,"",0,0,L);
	$pdf->Cell( 1	,0.8,"2",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"-",'LRTB',0,C);
	$pdf->Cell( 10	,0.8,"-",'LRT',0,L);//0.4
	
	/*$pdf->Ln(0.4);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.8,"",'',0,L,false); 
	$pdf->Cell( 0.4	,0.8,"",'',0,L,false);
	$pdf->Cell( 1	,0.8,"",'',0,C,false);
	$pdf->Cell( 6	,0.8,"",'',0,C,false);
	$pdf->Cell( 10	,0.4,"",'LR',0,L);*/
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.8,"",0,0,L); 
	$pdf->Cell( 0.4	,0.8,"",0,0,L);
	$pdf->Cell( 1	,0.8,"3",'LRTB',0,C);
	$pdf->Cell( 6	,0.8,"-",'LRTB',0,C);
	$pdf->Cell( 10	,0.8,"-",'LRTB',0,L);//0.4
	
	/*$pdf->Ln(0.4);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.8,"",'',0,L,false); 
	$pdf->Cell( 0.4	,0.8,"",'',0,L,false);
	$pdf->Cell( 1	,0.8,"",'',0,C,false);
	$pdf->Cell( 6	,0.8,"",'',0,C,false);
	$pdf->Cell( 10	,0.4,"",'LRB',0,L);*/
	
	//f. ketidakhadiran
	//absences
	$qABS	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$kdekls' "; // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	
	$q1SKT=$dABS['skt'.$sms.'1']; // q1 skt
	$q2SKT=$dABS['skt'.$sms.'2']; // q2 skt
	
	$q1IZN=$dABS['izn'.$sms.'1']; // q1 izn
	$q2IZN=$dABS['izn'.$sms.'2']; // q2 izn
	
	$q1ALP=$dABS['alp'.$sms.'1']; // q1 alp
	$q2ALP=$dABS['alp'.$sms.'2']; // q2 alp
	
	$qSKT = $q1SKT + $q2SKT;
	$qIZN = $q1IZN + $q2IZN;
	$qALP = $q1ALP + $q2ALP;
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"F.",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Ketidakhadiran",0,0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 2	,0.6,"",0,0,L); 
	$pdf->Cell( 0.4	,0.6,"",0,0,L); 
	$pdf->Cell( 5	,0.6,"Sakit",'LRTB',0,C);
	$pdf->Cell( 2	,0.6,$qSKT,'LRTB',0,C);
	$pdf->Cell( 2	,0.6,"Hari",'LRTB',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 2	,0.6,"",0,0,L); 
	$pdf->Cell( 0.4	,0.6,"",0,0,L); 
	$pdf->Cell( 5	,0.6,"Izin",'LRTB',0,C);
	$pdf->Cell( 2	,0.6,$qIZN,'LRTB',0,C);
	$pdf->Cell( 2	,0.6,"Hari",'LRTB',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 2	,0.6,"",0,0,L); 
	$pdf->Cell( 0.4	,0.6,"",0,0,L); 
	$pdf->Cell( 5	,0.6,"Tanpa Keterangan",'LRTB',0,C);
	$pdf->Cell( 2	,0.6,$qALP,'LRTB',0,C);
	$pdf->Cell( 2	,0.6,"Hari",'LRTB',0,L);
	
	//g. catatan wali kelas
	//absences
	$qABS	="	SELECT 		t_hdrkmnps_smp.*
				FROM 		t_hdrkmnps_smp
				WHERE		t_hdrkmnps_smp.nis='$kdekls' "; // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	
	//$q1SKT=$dABS['skt'."1"."1"]; // q1 skt
	//$q1IZN=$dABS['izn'."1"."1"]; // q1 izn
	//$q1ALP=$dABS['alp'."1"."1"]; // q1 alp
	//$q1KMN=$dABS['kmn'."1"."1"]; // q1 kmn
	$qKMN=$dABS['kmn'.$sms.$midtrm]; // q kmn
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"G.",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Catatan Wali Kelas",0,0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 0.4	,0.5,"",0,0,L); 
	$pdf->Cell( 17	,0.5,$qKMN,'LRT',0,L);//1
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 0.4	,0.5,"",0,0,L); 
	$pdf->Cell( 17	,0.5,"",'LR',0,L);//2
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 0.4	,0.5,"",0,0,L); 
	$pdf->Cell( 17	,0.5,"",'LR',0,L);//3
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 0.4	,0.5,"",0,0,L); 
	$pdf->Cell( 17	,0.5,"",'LRB',0,L);//4
	
	//h. tanggapan orang tua/wali murid
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"H.",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Tanggapan Orang Tua/Wali Murid",0,0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 0.4	,0.5,"",0,0,L); 
	$pdf->Cell( 17	,0.5,"",'LRT',0,L);//1
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 0.4	,0.5,"",0,0,L); 
	$pdf->Cell( 17	,0.5,"",'LR',0,L);//2
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 0.4	,0.5,"",0,0,L); 
	$pdf->Cell( 17	,0.5,"",'LR',0,L);//3
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 0.4	,0.5,"",0,0,L); 
	$pdf->Cell( 17	,0.5,"",'LRB',0,L);//4
	
	//tanda tangan
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 9	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Mengetahui:",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"22 Desember 2017",'',0,L);//4
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 8.25	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"Kepala Sekolah SMP",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->Cell( 5	,0.5,"",'',0,L);//4
	
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell( 0.4	,0.4,"____________",0,0,L); 
	$pdf->Cell( 5.7	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,"Ir. Paulus Pontoh MBA",'',0,L);//4
	$pdf->Cell( 2	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell( 5	,0.5,$wlikls,'',0,L);//4
	
	
	
//};
$pdf->Output();
?>