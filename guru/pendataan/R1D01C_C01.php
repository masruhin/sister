<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D01C_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SOAL
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdercu	=$_GET['kdercu'];
$query 	="	SELECT 		*
			FROM 		g_dtlrcu,g_gnrrcu,t_mstplj,t_mstkry
			WHERE		g_dtlrcu.kdercu='". mysql_escape_string($kdercu)."'	AND
						g_dtlrcu.kdercu=g_gnrrcu.kdercu	AND
						g_gnrrcu.kdeplj=t_mstplj.kdeplj
			ORDER BY 	g_dtlrcu.id";
$result =mysql_query($query) or die (mysql_error());

$i=0;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[kdercu];
	$cell[$i][1] 	=$data[nmaplj];
	$cell[$i][2] 	=$data[kls];
	$cell[$i][3] 	=$data[nmakry];
	$cell[$i][4] 	=$data[tglrcu];
	$cell[$i][5] 	=$data[jamrcu];
	$cell[$i][6] 	=$data[soal];
	$cell[$i][7] 	=$data[sttjwb];
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
	$pdf->Cell( 19	,0.5, "Kelas : ".$cell[$j][2]. " Guru	: ".$cell[$j][3]); 
	$pdf->Ln();
	$pdf->Cell( 19	,0.5, "Jadwal	: ".$cell[$j][4]." Jam : ".$cell[$j][5]); 
	$pdf->Ln();
	$pdf->Cell( 19,0,'',1); 	
	$x=0;
	while ($j<$i and $x<=35)
	{
		// soal
		$pdf->Ln(0.5);
		$pdf->Cell( 0.5	,0, $no.'.','',0,L); 

		$soal 	=susun_kalimat($cell[$j][6], 110);
		$jml	=count($soal);
		$sttjwb	=$cell[$j][7];

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

		$no++;
		$j++;
	}	
	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 19,0,'',1); 	
	$pdf->Ln(0.2);
	$pdf->Cell(5	,0,'FORM : R1D01C_C01 (GURU)');
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