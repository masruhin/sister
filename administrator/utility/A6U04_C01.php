<?php
//----------------------------------------------------------------------------------------------------
//Program		: A6U04_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: CETAK FORMAT BEHAVIOUR PS-JHS-SHS
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
//require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
require_once FUNGSI_UMUM_DIR.'rotation.php';

class PDF extends PDF_Rotate
{
	function RotatedText($x,$y,$txt,$angle)
	{
		//Text rotated around its origin
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}

	function RotatedImage($file,$x,$y,$w,$h,$angle)
	{
		//Image rotated around its upper-left corner
		$this->Rotate($angle,$x,$y);
		$this->Image($file,$x,$y,$w,$h);
		$this->Rotate(0);
	}
}

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

$query2	="	SELECT 		t_setpsrpt.*
			FROM 		t_setpsrpt
			WHERE		t_setpsrpt.kdetkt='$kdetkt' AND t_setpsrpt.kdeplj!=''
			ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id";
$result2=mysql_query($query2) or die('Query gagal');
$x=1;
while($data2 = mysql_fetch_array($result2))
{
	$cell2[$x][0] 	=$data2[nmasbj];
	$x++;
}

$query 	="	SELECT 		t_setpsbhv.*
			FROM 		t_setpsbhv
			ORDER BY	t_setpsbhv.id";
$result =mysql_query($query) or die('Query gagal');

$i=1;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[indctring];
	$cell[$i][1] 	=$data[indctrind];
	$i++;
}
$logo_pt	="../../images/logo.jpg";
$logo_ttw	="../../images/tutwurihandayani.jpg";

$pdf = new PDF('P','cm','A4');
//$pdf=new PDF();
$pdf->SetMargins(1,0.4,1);
$pdf->SetAutoPageBreak(True, 0.4);

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
	$pdf->Cell( 19	,0.4,"Skill and Behaviours that Support Learning (Keahlian dan Tingkah Laku yang Mendukung Pembelajaran)",0,0,L); 
	$pdf->Ln();
	$pdf->Cell( 19	,0.4,"( A-Excelent     B-Good     C-Sufficient     D-Needs Improvement )",0,0,L); 
	$pdf->Ln();
	
	$t=19-(($x-1)*0.5);
		
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( $t	,5.5,'Indicator of Behaviour Performance','LRTB',0,C);
	$y=1;
	while($y<$x)
	{
		$pdf->Cell( 0.5	,5.5,'','LRTB',0,C);
		$y++;
	}
	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( $t	,-4.5,'of','',0,C);
	$pdf->Ln();
	$pdf->Cell( $t	,5.5,'Class :','',0,C);
	$pdf->Ln(4.5);
	$pdf->SetFont('Arial','',7);
	$y=1;
	while($y<$x)
	{
		$p=$t+1.3+(($y*0.5)-0.5);
		$q=strpos($cell2[$y][0], '.');
		$sbj=$cell2[$y][0];
		$pdf->RotatedText($p,9.9,$sbj,90);
		$y++;
	}
	$pdf->SetFont('Arial','',6);
	
	while ($j<$i)
	{
		//menampilkan data dari hasil query database
		
		$indctring=$cell[$j][0];
		$indctrind=$cell[$j][1];
		$pdf->Cell($t	,0.3,$indctring,'LRT',0,L);
		$y=1;
		while($y<$x)
		{
			$pdf->Cell( 0.5	,0.6,'A','LRTB',0,C);
			$y++;
		}
		$pdf->Ln();
		$pdf->Cell($t	,-0.3,$indctrind,'LRT',0,L);
		$y=1;
		while($y<$x)
		{
			$pdf->Cell( 0.5	,0);
			$y++;
		}
		$pdf->Ln();
		$j++;
	}
	$pdf->Ln(0.3);
	$pdf->SetFont('Arial','B',7);	
	$pdf->Cell(19	,0.4,'Extra Curricular Activities ( A-Excelent     B-Good     C-Sufficient     D-Needs Improvement )','',0,L);
	$pdf->Ln();
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.5	,0.4,'No','LRTB',0,C,true);
	$pdf->Cell( 4.5	,0.4,'Jenis Kegiatan / Activity','LRTB',0,C,true);
	$pdf->Cell(14	,0.4,'Keterangan / Description','LRTB',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.5	,0.4,'1','LRTB',0,C);
	$pdf->Cell( 4.5	,0.4,'','LRTB',0,C);
	$pdf->Cell(14	,0.4,'','LRTB',0,C);
	$pdf->Ln();
	$pdf->Cell( 0.5	,0.4,'2','LRTB',0,C);
	$pdf->Cell( 4.5	,0.4,'','LRTB',0,C);
	$pdf->Cell(14	,0.4,'','LRTB',0,C);
	$pdf->Ln();
	$pdf->Cell( 0.5	,0.4,'3','LRTB',0,C);
	$pdf->Cell( 4.5	,0.4,'','LRTB',0,C);
	$pdf->Cell(14	,0.4,'','LRTB',0,C);
	$pdf->Ln();
	$pdf->Cell( 0.5	,0.4,'4','LRTB',0,C);
	$pdf->Cell( 4.5	,0.4,'','LRTB',0,C);
	$pdf->Cell(14	,0.4,'','LRTB',0,C);

	$pdf->Ln(0.7);
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell(19	,0.4,'Ketidakhadiran / Attendance Record','',0,L);
	$pdf->Ln();
	$pdf->Cell( 0.5	,0.4,'No','LRTB',0,C,true);
	$pdf->Cell( 4.5	,0.4,'Alasan / Reason','LRTB',0,C,true);
	$pdf->Cell(14	,0.4,'Lama / Days','LRTB',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.5	,0.4,'1','LRTB',0,C);
	$pdf->Cell( 4.5	,0.4,'Sakit / Sickness','LRTB',0,C);
	$pdf->Cell(14	,0.4,'','LRTB',0,C);
	$pdf->Ln();
	$pdf->Cell( 0.5	,0.4,'2','LRTB',0,C);
	$pdf->Cell( 4.5	,0.4,'Izin / Excused','LRTB',0,C);
	$pdf->Cell(14	,0.4,'','LRTB',0,C);
	$pdf->Ln();
	$pdf->Cell( 0.5	,0.4,'3','LRTB',0,C);
	$pdf->Cell( 4.5	,0.4,'Alpa / Non-Excused','LRTB',0,C);
	$pdf->Cell(14	,0.4,'','LRTB',0,C);
	$pdf->Ln();
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C);
	$pdf->Cell( 4.5	,0.4,'Total','LRTB',0,C);
	$pdf->Cell(14	,0.4,'','LRTB',0,C);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 6	,0.4,'Acknowledged by','',0,C);
	$pdf->Cell( 7	,0.4,'','',0,C);
	$pdf->Cell( 6	,0.4,'Bekasi, XXXXXXXXXXXXX 99, 9999','',0,C);
	$pdf->Ln();
	$pdf->Cell( 6	,0.4,'Parents / Guardian,','',0,C);
	$pdf->Cell( 7	,0.4,'','',0,C);
	$pdf->Cell( 6	,0.4,'Homeroom Teacher','',0,C);
	$pdf->Ln(2);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 6	,0.4,"                                                      ",'',0,C);
	$pdf->Cell( 7	,0.4,'','',0,C);
	$pdf->Cell( 6	,0.4,'XXXXXXXXXXXXXXXXXXXXX','',0,C);
	$pdf->Ln();
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 7	,0.4,'Approved by','',0,C);
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->Ln(2);
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 7	,0.4,'XXXXXXXXXXXXXXXXXXXXX','',0,C);
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->Ln();
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 7	,0.4,'Principal','',0,C);
	$pdf->Cell( 6	,0.4,'','',0,C);
//menampilkan output berupa Hlmaman PDF
$pdf->Output();
?>