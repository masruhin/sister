<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D01B_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SOAL
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdesl	=$_GET['kdesl'];
$query 	="	SELECT 		g_dtlsal.*,g_gnrsal.ktr,t_mstplj.nmaplj
			FROM 		g_dtlsal,g_gnrsal,t_mstplj
			WHERE		g_dtlsal.kdesl='". mysql_escape_string($kdesl)."'	AND
						g_dtlsal.kdesl=g_gnrsal.kdesl	AND
						g_gnrsal.kdeplj=t_mstplj.kdeplj
			ORDER BY 	g_dtlsal.id";
$result =mysql_query($query) or die('Query gagal');

$i=0;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[kdesl];
	$cell[$i][1] 	=$data[nmaplj];
	$cell[$i][2] 	=$data[ktr];
	$cell[$i][3] 	=$data[soal];
	$cell[$i][4] 	=$data[jwb1];
	$cell[$i][5] 	=$data[jwb2];
	$cell[$i][6] 	=$data[jwb3];
	$cell[$i][7] 	=$data[jwb4];
	$cell[$i][8] 	=$data[jwb5];
	$cell[$i][9] 	=$data[sttjwb];
	$i++;
}

$logo	="../../images/logo.jpg";
$pdf 	=new FPDF('P','cm','A4');

$tgl 	=date("d-m-Y");
$jam	=date("h:i:s");
$judul	="LEMBAR SOAL";

$j	=0;
$no	=1;
$hlm=1;
while ($j<$i)
{
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Image($logo,1.5,1.5,2,2);
	$pdf->Ln(0.7);
	$pdf->SetFont('times','B',8);
	$pdf->Cell( 3	,1);
	$pdf->Cell(10	,1, "Lumen Vitae");
	$pdf->SetFont('arial','B',8);
	$pdf->Cell( 6	,1, $nama_pt,'',0,R);
	$pdf->SetFont('times','B',20);
	$pdf->Ln();
	$pdf->Cell( 3	,-0.1);
	$pdf->Cell(10	,-0.1, $nama_pt);
	$pdf->SetFont('arial','',6);
	$pdf->Cell( 6	,-0.5, $alamat1_pt,'',0,R);
	$pdf->Ln();
	$pdf->SetFont('times','B',8);
	$pdf->Cell( 3	,1.7);
	$pdf->Cell( 8	,1.7, "A CATHOLIC NATIONAL PLUS SCHOOL",'',0,R); 
	$pdf->SetFont('arial','',6);
	$pdf->Cell( 8	,1, $alamat2_pt,'',0,R);
	$pdf->Ln();
	$pdf->SetFont('arial','',6);
	$pdf->Cell(19	,-0.5, $alamat3_pt,'',0,R);
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(19	,0.7, $judul,'',0,C); 
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 19	,0.7, "Pelajaran 	: ".$cell[$j][1].' ( '.$cell[$j][0].' )');
	$pdf->Ln();
	$pdf->Cell( 19	,0.5, "Keterangan	: ".$cell[$j][2]); 
	$pdf->Ln();
	$pdf->Cell( 19,0,'',1); 	
	$x=0;
	while ($j<$i and $x<=35)
	{
		// soal
		$pdf->Ln(0.5);
		$pdf->Cell( 0.5	,0, $no.'.','',0,L); 

		$soal 	=susun_kalimat($cell[$j][3], 110);
		$jml	=count($soal);
		$sttjwb	=$cell[$j][9];

		$y=0;
		while($y<$jml)
		{
			if($y>0)
			{
				$pdf->Cell( 0.5	,0); 
			}
			$pdf->Cell( 18.5	,0, $soal[$y]);
			$pdf->Ln(0.5);
			$y++;
			$x++;
		}	
		$pdf->Ln(-0.3);
		// jawaban 1
		$jwb1 	=susun_kalimat($cell[$j][4], 110);
		$jml1	=count($jwb1);
		$pdf->Cell(  0.5	,0.5);
		if($sttjwb=='A')
			{$pdf->Cell(  0.5	,0.5,'A.','BTLR');}
		else
			{$pdf->Cell(  0.5	,0.5,'A.');}	

		$y=0;
		while($y<$jml1)
		{
			if($y>0)
			{$pdf->Cell(  1	,0.5);}
			$pdf->Cell( 18	,0.5, $jwb1[$y]);
			$pdf->Ln(0.5);
			$y++;
			$x++;
		}	
		
		// jawaban 2
		$jwb2 	=susun_kalimat($cell[$j][5], 110);
		$jml2	=count($jwb2);
		$pdf->Cell(  0.5	,0.5);
		if($sttjwb=='B')
			{$pdf->Cell(  0.5	,0.5,'B.','BTLR');}
		else
			{$pdf->Cell(  0.5	,0.5,'B.');}	

		$y=0;
		while($y<$jml2)
		{
			if($y>0)
			{$pdf->Cell(  1	,0.5);}
			$pdf->Cell( 18	,0.5, $jwb2[$y]);
			$pdf->Ln();
			$y++;
			$x++;
		}	

		// jawaban 3
		$jwb3 	=susun_kalimat($cell[$j][6], 110);
		$jml3	=count($jwb3);
		$pdf->Cell(  0.5	,0.5);
		if($sttjwb=='C')
			{$pdf->Cell(  0.5	,0.5,'C.','BTLR');}
		else
			{$pdf->Cell(  0.5	,0.5,'C.');}	

		$y=0;
		while($y<$jml3)
		{
			if($y>0)
			{$pdf->Cell(  1	,0.5);}
			$pdf->Cell( 18	,0.5, $jwb3[$y]);
			$pdf->Ln();
			$y++;
			$x++;
		}	

		// jawaban 4
		$jwb4 	=susun_kalimat($cell[$j][7], 110);
		$jml4	=count($jwb4);
		$pdf->Cell(  0.5	,0.5);
		if($sttjwb=='D')
			{$pdf->Cell(  0.5	,0.5,'D.','BTLR');}
		else
			{$pdf->Cell(  0.5	,0.5,'D.');}	

		$y=0;
		while($y<$jml4)
		{
			if($y>0)
			{$pdf->Cell(  1	,0.5);}
			$pdf->Cell( 18	,0.5, $jwb4[$y]);
			$pdf->Ln();
			$y++;
			$x++;
		}	

		if($cell[$j][8]!='')
		{
			// jawaban 5
			$jwb5 	=susun_kalimat($cell[$j][8], 110);
			$jml5	=count($jwb5);
			$pdf->Cell(  0.5	,0.5);
			if($sttjwb=='E')
				{$pdf->Cell(  0.5	,0.5,'E.','BRLR');}
			else
				{$pdf->Cell(  0.5	,0.5,'E.');}

			$y=0;
			while($y<$jml5)
			{
			if($y>0)
				{$pdf->Cell(  1	,0.5);}
				$pdf->Cell( 18	,0.5, $jwb5[$y]);
				$pdf->Ln();
				$y++;
				$x++;
			}	
		}
		$no++;
		$j++;
	}	
	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 19,0,'',1); 	
	$pdf->Ln(0.2);
	$pdf->Cell(5	,0,'FORM : R1D01B_01 (GURU)');
	$pdf->Cell(14	,0,$tgl.' '.$jam.' halaman : '.$hlm,0,0,R);
	if($j<$i)
	{
		$pdf->Ln(0.3);
		$hlm++;
		$pdf->Cell(19	,0,'bersambung ke halaman : '.$hlm,0,0,R);
	}
}
	
//menampilkan output berupa halaman PDF
$pdf->Output();
?>