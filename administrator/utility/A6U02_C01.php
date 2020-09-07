<?php
//----------------------------------------------------------------------------------------------------
//Program		: A6U02_C02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: CETAK FORMAT RAPORT PG
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$kdetkt=$_GET['kdetkt'];
switch($kdetkt)
{
	case 'PG':
		$judul	='PLAY GROUP';
		break;
	case 'KG':
		$judul	='KINDERGARTEN';
		break;
}		
$judul=$judul.' PROGRESS REPORT';

$query1 ="	SELECT 		t_setthn.*
			FROM 		t_setthn
			WHERE		t_setthn.set='Tahun Ajaran'";
$result1=mysql_query($query1) or die('Query gagal');
$data1 	= mysql_fetch_array($result1);
$thnajr=$data1[nli];

$query 	="	SELECT 		t_setpgrpt.*
			FROM 		t_setpgrpt";
$result =mysql_query($query) or die('Query gagal');

$i=1;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[id];
	$cell[$i][1] 	=$data[lrnare];
	$i++;
}
$logo	="../../images/logo.jpg";

$pdf = new FPDF('P','cm','A4');
$pdf->SetMargins(1,0.5,1);
$pdf->SetAutoPageBreak(True, 0.5);
$pdf->AddFont('FRIZQUAD','','FRIZQUAD.php');

$j	=1;
$Hlm=1;

	$pdf->Open();
	$pdf->AddPage();
	$pdf->Image($logo,1,1,2,2);
	$pdf->Ln(0.7);
	$pdf->SetFont('FRIZQUAD','',8);
	$pdf->Cell( 2.3	,1);
	$pdf->Cell(10.7	,1, $nama_pt2_a);
	$pdf->SetFont('arial','B',8);
	$pdf->Cell( 6	,1, $nama_pt,'',0,R);
	$pdf->SetFont('FRIZQUAD','',20);
	$pdf->Ln();
	$pdf->Cell( 2.3	,-0.1);
	$pdf->Cell(10.7	,-0.1, $nama_pt2);
	$pdf->SetFont('arial','',6);
	$pdf->Cell( 6	,-0.5, $alamat1_pt,'',0,R);
	$pdf->Ln();
	$pdf->SetFont('FRIZQUAD','',8);
	$pdf->Cell( 2.3	,1.7);
	$pdf->Cell( 7.2	,1.7,$nama_pt2_b,'',0,R); 
	$pdf->SetFont('arial','',6);
	$pdf->Cell( 9.5	,1, $alamat2_pt,'',0,R);
	$pdf->Ln();
	$pdf->SetFont('arial','',6);
	$pdf->Cell(19	,-0.5, $alamat3_pt,'',0,R);

	$pdf->Ln();
	$pdf->SetFont('arial','BU',12);
	$pdf->Cell(19	,3, $judul,0,0,C);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(1.8);
	$pdf->Cell(19	,0.4, $thnajr,0,0,C);
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(1);
	$pdf->Cell( 9.5	,0.4,"Name : "."XXXXXXXXXXXXXXXXXXXXXXXX",0,0,L); 
	$pdf->Cell( 9.5	,0.4,"Homeroom Teacher : "."XXXXXXXXXXXXXXXXXXXXXXXX",0,0,R); 
	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.4	,0.7,'Learning Area','LRTB',0,C,true);
	$pdf->Cell( 1.4	,0.7,'Term 1'		,'LRTB',0,C,true);
	$pdf->Cell( 1.4	,0.7,'Term 2'		,'LRTB',0,C,true);
	$pdf->Cell( 1.4	,0.7,'Term 3'		,'LRTB',0,C,true);
	$pdf->Cell( 1.4	,0.7,'Term 4'		,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$id=$cell[1][0];
	while ($id<99)
	{
		//menampilkan data dari hasil query database
		
		$lrnarev=$cell[$j][1];
		if(substr($lrnarev,0,1)=='/')
		{
			$bg='true';
			$lrnarev 	=str_replace("/","","$lrnarev");
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(204,204,204);
			$pdf->Cell(13.4	,0.7,$lrnarev,'LRTB',0,C,$bg);
		}
		else
		{
			$bg='false';
			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(13.4	,0.7,$lrnarev,'LRTB',0,L,$bg);
		}	
		$pdf->Cell( 1.4	,0.7,'','LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.7,'','LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.7,'','LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.7,'','LRTB',0,C,$bg);
		$pdf->Ln();
		$j++;
		$id=$cell[$j][0];
	}
	$pdf->Ln(2.4);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(19	,0.4,' Page : '.$Hlm." of 3",0,0,R);	
	$Hlm++;
	
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Ln(2);
	$id=$cell[j][0];
	$term1='Term 1';
	$term2='Term 2';
	$term3='Term 3';
	$term4='Term 4';
	while ($id<199)
	{
		//menampilkan data dari hasil query database
		
		$lrnarev=$cell[$j][1];
		if(substr($lrnarev,0,1)=='/')
		{
			$bg='true';
			$lrnarev 	=str_replace("/","","$lrnarev");
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(204,204,204);
			$pdf->Cell(13.4	,0.7,$lrnarev,'LRTB',0,C,$bg);
		}
		else
		{
			$bg='false';
			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(13.4	,0.7,$lrnarev,'LRTB',0,L,$bg);
			$term1='';
			$term2='';
			$term3='';
			$term4='';
		}	
		$pdf->Cell( 1.4	,0.7,$term1,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.7,$term2,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.7,$term3,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.7,$term4,'LRTB',0,C,$bg);
		$pdf->Ln();
		$j++;
		$id=$cell[$j][0];
	}
	$pdf->Ln(8.1);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(19	,0.4,' Page : '.$Hlm." of 3",0,0,R);	
	$Hlm++;
	
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Ln(2);
	$term1='Term 1';
	$term2='Term 2';
	$term3='Term 3';
	$term4='Term 4';
	
	while ($j<$i)
	{
		//menampilkan data dari hasil query database
		
		$lrnarev=$cell[$j][1];
		if(substr($lrnarev,0,1)=='/')
		{
			$bg='true';
			$lrnarev 	=str_replace("/","","$lrnarev");
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(204,204,204);
			$pdf->Cell(13.4	,0.7,$lrnarev,'LRTB',0,C,$bg);
		}
		else
		{
			$bg='false';
			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(13.4	,0.7,$lrnarev,'LRTB',0,L,$bg);
			$term1='';
			$term2='';
			$term3='';
			$term4='';
		}	
		$pdf->Cell( 1.4	,0.7,$term1,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.7,$term2,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.7,$term3,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.7,$term4,'LRTB',0,C,$bg);
		$pdf->Ln();
		$j++;
	}

	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell(19	,0.7,'Attitudes toward learning','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.7,'Term 1','LRTB',0,C,true);
	$pdf->Cell(17.5	,0.7,'','LRTB',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.7,'Term 2','LRTB',0,C,true);
	$pdf->Cell(17.5	,0.7,'','LRTB',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.7,'Term 3','LRTB',0,C,true);
	$pdf->Cell(17.5	,0.7,'','LRTB',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.7,'Term 4','LRTB',0,C,true);
	$pdf->Cell(17.5	,0.7,'','LRTB',0,L,true);
	$pdf->Ln();

	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell(19	,0.7,'Special Note','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.7,'Term 1','LRTB',0,C,true);
	$pdf->Cell(17.5	,0.7,'','LRTB',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.7,'Term 2','LRTB',0,C,true);
	$pdf->Cell(17.5	,0.7,'','LRTB',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.7,'Term 3','LRTB',0,C,true);
	$pdf->Cell(17.5	,0.7,'','LRTB',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.7,'Term 4','LRTB',0,C,true);
	$pdf->Cell(17.5	,0.7,'','LRTB',0,L,true);
	$pdf->Ln();

	$pdf->Ln();
	$pdf->SetFont('Arial','I',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(19	,0.7,'Scoring Symbols :      A-Excellent          B-Very Good          C-Good          D-Keep Trying          N/A-Not Applicable','LRTB',0,C,true);
	$pdf->Ln();

	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 6	,0.7,'','',0,C,true);
	$pdf->Cell( 7	,0.7,'Term X','',0,C,true);
	$pdf->Cell( 6	,0.7,'Bekasi, XXXXXXXXXXXXX 99, 9999','',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 6	,3,'','LRT',0,C,true);
	$pdf->Cell( 7	,3,'','LRT',0,C,true);
	$pdf->Cell( 6	,3,'','LRT',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 6	,0.5,'XXXXXXXXXXXXXXXXXXXXX','LR',0,C,true);
	$pdf->Cell( 7	,0.5,'XXXXXXXXXXXXXXXXXXXXX','LR',0,C,true);
	$pdf->Cell( 6	,0.5,'XXXXXXXXXXXXXXXXXXXXX','LR',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 6	,0.5,'Principal','LRB',0,C,true);
	$pdf->Cell( 7	,0.5,'Homeroom Teacher','LRB',0,C,true);
	$pdf->Cell( 6	,0.5,"Parent's Signature",'LRB',0,C,true);
	$pdf->Ln(8.8);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(19	,0.4,' Page : '.$Hlm." of 3",0,0,R);	

//menampilkan output berupa Hlmaman PDF
$pdf->Output();
?>