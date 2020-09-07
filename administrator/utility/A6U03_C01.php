<?php
//----------------------------------------------------------------------------------------------------
//Program		: A6U03_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: CETAK FORMAT PROGRES REPORT PS-JHS-SHS
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$kdetkt=$_GET['kdetkt'];

switch($kdetkt)
{
	case 'PS':
		$judul	=$nama_pt_ps;
		break;
	case 'JHS':
		$judul	=$nama_pt_jhs;
		break;
	case 'SHS':
		$judul	=$nama_pt_shs;
		break;
}		

$query1 ="	SELECT 		t_setthn.*
			FROM 		t_setthn
			WHERE		t_setthn.set='Tahun Ajaran'";
$result1=mysql_query($query1) or die('Query gagal');
$data1 	= mysql_fetch_array($result1);
$thnajr=$data1[nli];

$query 	="	SELECT 		t_setpsrpt.*
			FROM 		t_setpsrpt
			WHERE		t_setpsrpt.kdetkt='$kdetkt'
			ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id";
$result =mysql_query($query) or die('Query gagal');

$i=1;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[id];
	$cell[$i][1] 	=$data[nmasbj];
	$i++;
}
$logo_pt	="../../images/logo.jpg";
$logo_ttw	="../../images/tutwurihandayani.jpg";

$pdf = new FPDF('P','cm','A4');
$pdf->SetMargins(1,0.4,1);
$pdf->SetAutoPageBreak(True, 0.4);
$pdf->AddFont('FRIZQUAD','','FRIZQUAD.php');

$j	=1;
$Hlm=1;

	$pdf->Open();
	$pdf->AddPage();
	$pdf->Image($logo_ttw,1,1,1.5,1.5);
	$pdf->Image($logo_pt ,18.5,1,1.5,1.5);
	$pdf->Ln(0.8);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(19	,0.4, $judul,0,0,C);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Cell(19	,0.4, 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',0,0,C);
	$pdf->Ln();
	$pdf->Cell(19	,0.4, $thnajr,0,0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(19	,0.3, $alamat1_pt1,0,0,C);
	$pdf->Ln();
	$pdf->Cell(19	,0.3, $alamat2_pt2,0,0,C);
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(1);
	$pdf->Cell( 1	,0.4,"Name",0,0,L); 
	$pdf->Cell( 13	,0.4,": XXXXXXXXXXXXXXXXXXXXXXXX",0,0,L); 
	$pdf->Cell( 1	,0.4,"Grade",0,0,L); 
	$pdf->Cell( 4	,0.4,": XXXXXXXXXX",0,0,L); 
	$pdf->Ln();
	$pdf->Cell( 1	,0.4,"NIS",0,0,L); 
	$pdf->Cell( 13	,0.4,": XXXXXXXXXXXXXXXXXXXXXXXX",0,0,L); 
	$pdf->Cell( 1	,0.4,"NISN",0,0,L); 
	$pdf->Cell( 4	,0.4,": XXXXXXXXXX",0,0,L); 
	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.6	,0.8,'No','LRT',0,C,true);
	$pdf->Cell( 7.9	,0.8,'Subject','LRT',0,C,true);
	$pdf->Cell( 3.5	,0.4,'HW/CW'				,'LRT',0,C,true);
	$pdf->Cell( 3.5	,0.4,'Project/Experiment'	,'LRTB',0,C,true);
	$pdf->Cell( 3.5	,0.4,'Test'		,'LRT',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0);
	$pdf->Cell( 7.9	,0);
	$pdf->Cell( 0.7	,0.4,'1'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'2'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'3'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'4'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'5'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'1'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'2'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'3'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'4'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'5'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'1'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'2'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'3'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'4'		,'LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'5'		,'LRTB',0,C,true);
	$pdf->Ln();
	
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[1][0];
	$pdf->Cell(0.6	,0.4,'A','LRTB',0,C,true);	
	while ($id<99)
	{
		//menampilkan data dari hasil query database
		
		$nmasbj=$cell[$j][1];
		if(substr($nmasbj,0,1)=='/')
		{
			$nmasbj 	=str_replace("/","","$nmasbj");
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(204,204,204);
			$pdf->Cell(7.9	,0.4,$nmasbj,'LRTB',0,L,true);
		}
		else
		{
			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(0.6	,0.4,'','LRTB',0,C,true);
			$pdf->Cell(7.9	,0.4,$nmasbj,'LRTB',0,L,true);
		}	
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Ln();
		$j++;
		$id=$cell[$j][0];
	}
	$pdf->Cell( 0.6	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 7.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[j][0];
	$pdf->Cell(0.6	,0.4,'B','LRTB',0,C,true);	
	while ($id<200)
	{
		//menampilkan data dari hasil query database
		
		$nmasbj=$cell[$j][1];
		if(substr($nmasbj,0,1)=='/')
		{
			$nmasbj 	=str_replace("/","","$nmasbj");
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(204,204,204);
			$pdf->Cell(7.9	,0.4,$nmasbj,'LRTB',0,L,true);
		}
		else
		{
			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(0.6	,0.4,'','LRTB',0,C,true);
			$pdf->Cell(7.9	,0.4,$nmasbj,'LRTB',0,L,true);
		}	
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Ln();
		$j++;
		$id=$cell[$j][0];
	}
	$pdf->Cell( 0.6	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 7.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell(0.6	,0.4,'C','LRTB',0,C,true);	
	$pdf->Cell(7.9	,0.4,'Pengembangan Diri','LRTB',0,L,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);

	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.6	,0.4,'','LRTB',0,C,true);	
	$pdf->Cell(7.9	,0.4,'Ekstrakulikuler','LRTB',0,L,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 7.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[j][0];
	$pdf->Cell(0.6	,0.4,'D','LRTB',0,C,true);	
	while ($j<$i)
	{
		//menampilkan data dari hasil query database
		
		$nmasbj=$cell[$j][1];
		if(substr($nmasbj,0,1)=='/')
		{
			$nmasbj 	=str_replace("/","","$nmasbj");
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(204,204,204);
			$pdf->Cell(7.9	,0.4,$nmasbj,'LRTB',0,L,true);
		}
		else
		{
			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(0.6	,0.4,'','LRTB',0,C,true);
			$pdf->Cell(7.9	,0.4,$nmasbj,'LRTB',0,L,true);
		}	
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Cell( 0.7	,0.4,'','LRTB',0,C,true);
		$pdf->Ln();
		$j++;
		$id=$cell[$j][0];
	}

	$pdf->Ln(1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 9.5	,0.4,'Acknowledged by','',0,C,true);
	$pdf->Cell( 9.5	,0.4,'Bekasi, XXXXXXXXXXXXX 99, 9999','',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 9.5	,0.4,'Parents / Guardian,','',0,C,true);
	$pdf->Cell( 9.5	,0.4,'Homeroom Teacher','',0,C,true);
	$pdf->Ln(2);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 9.5	,0.4,"                                                      ",'',0,C,true);
	$pdf->Cell( 9.5	,0.4,'XXXXXXXXXXXXXXXXXXXXX','',0,C,true);
//menampilkan output berupa Hlmaman PDF
$pdf->Output();
?>