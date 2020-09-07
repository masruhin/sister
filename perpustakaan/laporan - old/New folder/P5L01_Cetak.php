<?php
//----------------------------------------------------------------------------------------------------
//Program		: P5L01_Cetak.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: LAPORAN BUKU DIPINJAM
//----------------------------------------------------------------------------------------------------
//	PERPUSTAKAAN
//		laporan
//			buku dipinjam
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$kdektg	=$_POST['kdektg'];

$query 	="	SELECT 		t_dtlpjm.*,t_gnrpjm.*,t_mstbku.*,t_ktg.*
			FROM 		t_dtlpjm,t_gnrpjm,t_mstbku,t_ktg
			WHERE 		(t_mstbku.kdektg	='". mysql_escape_string($kdektg)."'	OR '$kdektg'='')	AND
						t_dtlpjm.tglkmb=''	AND
						t_dtlpjm.nmrpjm=t_gnrpjm.nmrpjm	AND
						t_dtlpjm.kdebku		=t_mstbku.kdebku	AND
						t_mstbku.kdektg		=t_ktg.kdektg
			ORDER BY 	t_gnrpjm.tglpjm";

$result =mysql_query($query) or die('Query gagal 1');

$i=1;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[kdebku];
	$cell[$i][1] 	=$data[jdl]; // $cell[$i][1] 	=$data[nmabku];
	$stt		 	=$data[stt];
	$kdeang			=$data[kdeang];
	$cell[$i][2] 	=$data[nmaktg];
	if($stt=='S')
	{
		$query2	="	SELECT 		t_mstssw.*
					FROM 		t_mstssw
					WHERE 		t_mstssw.nis	='". mysql_escape_string($kdeang)."' ";
		$result2=mysql_query($query2) or die('Query gagal 2');
		$data2 	=mysql_fetch_array($result2);
		$cell[$i][3]=$data2[nmassw].'-'.$data2[kdekls];
	}
	else
	{
		$query2	="	SELECT 		t_mstkry.*
					FROM 		t_mstkry
					WHERE 		t_mstkry.kdekry	='". mysql_escape_string($kdeang)."' ";
		$result2=mysql_query($query2) or die('Query gagal 3');
		$data2 	=mysql_fetch_array($result2);
		$cell[$i][3]=$data2[nmakry];
	}
	$cell[$i][4] 	=$data[tglpjm];
	$i++;
}

$pdf = new FPDF('P','cm','A4');

$j	=1;
$Hlm=1;
$No	=1;
while ($j<$i)
{
	$tgl 	=date("d-m-Y");
	$jam	=date("h:i:s");
	$judul	="LAPORAN BUKU DIPINJAM";

	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(14	,0.4,"SAINT JOHN'S SCHOOL"); // $nama_pt
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell( 3	,0.4,"Tanggal :",0,0,R);
	$pdf->Cell( 2	,0.4,$tgl,0,0,L);
	$pdf->Ln();
	$pdf->Cell(14	,0.4,"JAKARTA - INDONESIA"); // $kota_pt 
	$pdf->Cell( 3	,0.4,"jam :",0,0,R);
	$pdf->Cell( 2	,0.4,$jam,0,0,L);
	$pdf->Ln();
	$pdf->Cell(17	,0.4,"Hal :",0,0,R);
	$pdf->Cell( 2	,0.4,$Hlm,0,0,L);
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell(19	,0.4,$judul); 
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln();
	/*if ($kdektg!='')
	{
		$pdf->Cell( 2.2	,0.4,"Kategori",0,0,L); 
		$pdf->Cell(16.9	,0.4," : ".$cell[$i][2].' - '.$cell[$j][1]); 
		$pdf->Ln();
	}*/
	if ($kdektg=='')
	{
		$pdf->Cell( 2.2	,0.4,"Kategori",0,0,L); 
		$pdf->Cell(16.9	,0.4," : ".$cell[$i][2].' --Semua-- '.$cell[$j][1]); 
		$pdf->Ln();
	}
	else// ($kdektg!='')
	{
		$pdf->Cell( 2.2	,0.4,"Kategori",0,0,L); 
		$pdf->Cell(16.9	,0.4," : ".$cell[$i][2]. $kdektg .$cell[$j][1]); 
		$pdf->Ln();
	}
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell( 0.5	,0.4,'NO'			,'LRTB',0,C); // 0.8
	$pdf->Cell( 5.0	,0.4,'DIPINJAM OLEH','LRTB',0,C); // 2.5 JUDUL
	$pdf->Cell(12.0	,0.4,'JUDUL'		,'LRTB',0,C); // 13.2 DIPINJAM OLEH
	$pdf->Cell( 1.5	,0.4,'TANGGAL'		,'LRTB',0,C); // 2.5
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
    $x=1;
	while ($x<=60 AND $j<$i)
	{
		$jdl=$cell[$j][1];
		//$jdl=$cell[$j][2];
		$nma=$cell[$j][3];
		$tgl=$cell[$j][4];
		//menampilkan data dari hasil query database
		$pdf->Cell( 0.5	,0.4,$No				,0,0,R); // 0.8
		$pdf->Cell( 5.0	,0.4,$nma				,0,0,C); // 2.5 $jdl
		$pdf->Cell(12.0	,0.4,$jdl				,0,0,C); // 13.2 $nma
		$pdf->Cell( 1.5	,0.4,$tgl				,0,0,L); // 2.5
		$pdf->Ln();
		$Ttl=$Ttl+$nli;
		$No++;		
		$x++;
		$j++;
	}
	$pdf->Cell(19   ,0,'',1); 	
	$pdf->Ln();
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 5	,0.4,'FORM : P5L01 (PERPUSTAKAAN)');
	if ($j<$i)
	{
		$Hal=$Hal+1;
		$pdf->Cell(19  	,0.4,"Bersambung ke hal : ".$Hal,0,0,R);
		$pdf->Ln();
	}
}
//menampilkan output berupa halaman PDF
$pdf->Output();
?>