<?php
//----------------------------------------------------------------------------------------------------
//Program		: G1D02_C02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: CETAK DAFTAR KARYAWAN
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$kdestt	=$_POST['kdestt'];
$jnsklm	=$_POST['jnsklm'];
$kdeagm	=$_POST['kdeagm'];
$jdl	=$_POST['jdl'];
$urt	=$_POST['urt'];

if($jdl=='')
	$judul='DAFTAR KARYAWAN';
else
	$judul=$jdl;	

if($urt=='1')
	$order='ORDER BY 	t_mstkry.kdestt,t_mstkry.kdekry';
else	
	$order='ORDER BY 	t_mstkry.kdestt,t_mstkry.nmakry';
	
$query 		="	SELECT 		t_mstkry.*,t_mstagm.*,t_sttkry.*
				FROM 		t_mstkry,t_mstagm,t_sttkry
				WHERE 		(t_mstkry.kdestt ='$kdestt'	or '$kdestt'='')	AND
							(t_mstkry.jnsklm='$jnsklm'	or '$jnsklm'='')	AND
							(t_mstkry.kdeagm='$kdeagm'	or '$kdeagm'='')			AND
							t_mstkry.str='' AND t_mstkry.kdekry LIKE 'M%'								AND
							t_mstkry.kdestt =t_sttkry.kdestt				AND	
							t_mstkry.kdeagm =t_mstagm.kdeagm ".$order;

$db_query 	=mysql_query($query) or die('Query gagal');

$i=1;
while($data = mysql_fetch_array($db_query))
{
	$cell[$i][0] 	=$data[kdestt];
	$cell[$i][1] 	=$data[nmastt];
	$cell[$i][2] 	=$data[kdekry];
	$cell[$i][3] 	=$data[nmakry];
	$cell[$i][4] 	=$data[nmaagm];
	$i++;
}
$logo	="../../images/logo.jpg";
$photo	="../../files/photo/karyawan/$kdekry.jpg";

$pdf = new FPDF('P','cm','A4');
$pdf->AddFont('FRIZQUAD','','FRIZQUAD.php');

$j	=1;
$Hlm=1;
$No	=1;
while ($j<$i)
{
	$tgl 	=date("d-m-Y");
	$jam	=date("h:i:s");

	$pdf->Open();
	$pdf->AddPage();
	$pdf->Image($logo,1.5,1.5,2,2);
	$pdf->Ln(0.7);
	$pdf->SetFont('arial','',8);//FRIZQUAD
	$pdf->Cell( 3	,1);
	$pdf->Cell(10	,1, 'sciantia, virtus, et vita');//$nama_pt2_a
	$pdf->SetFont('arial','B',8);
	$pdf->Cell( 6	,1, '','',0,R);//$nama_pt
	$pdf->SetFont('arial','',20);//FRIZQUAD
	$pdf->Ln();
	$pdf->Cell( 3	,-0.1);
	$pdf->Cell(10	,-0.1, "Saint John's School");//$nama_pt2
	$pdf->SetFont('arial','',6);
	$pdf->Cell( 6	,-0.5, '','',0,R);//$alamat1_pt
	$pdf->Ln();
	$pdf->SetFont('arial','',8);//FRIZQUAD
	$pdf->Cell( 3	,1.7);
	$pdf->Cell( 7.2	,1.7,'A CATHOLIC NATIONAL PLUS SCHOOL','',0,R); //$nama_pt2_b
	$pdf->SetFont('arial','',6);
	$pdf->Cell( 8.8	,1, '','',0,R);//$alamat2_pt
	$pdf->Ln();
	$pdf->SetFont('arial','',6);
	$pdf->Cell(19	,-0.5, '','',0,R);//$alamat3_pt

	$pdf->Ln();
	$pdf->SetFont('arial','BU',12);
	$pdf->Cell(19	,3, $judul,0,0,C);

	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(2);
	$pdf->Cell( 2.1	,0.4,"Status",0,0,L); 
	$pdf->Cell(16.9	,0.4,": ".$cell[$j][1]); 
	$pdf->Ln();
	if($jnsklm!='')
	{
		$pdf->Cell( 2.1	,0.4,"Jenis Kelamin",0,0,L); 
		if($jnsklm=='L')
			$pdf->Cell(16.9	,0.4,': LAKI-LAKI'); 
		else
			$pdf->Cell(16.9	,0.4,': PEREMPUAN'); 
		$pdf->Ln();
	}
	if($kdeagm!='')
	{	
		$pdf->Cell( 2.1	,0.4,"Agama",0,0,L);
		$pdf->Cell(16.9	,0.4,": ".$cell[$j][4]); 
		$pdf->Ln();
	}	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.8	,0.5,'NO'			,'LRTB',0,C);
	$pdf->Cell( 2	,0.5,'KODE'			,'LRTB',0,C);
	$pdf->Cell(11.2	,0.5,'NAMA KARYAWAN'	,'LRTB',0,C);
	$pdf->Cell( 5	,0.5,'TANDA TANGAN'	,'LRTB',0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$kdestt=$cell[$j][0];
    $x=1;
	while ($x<=30 AND $j<$i AND $kdestt==$cell[$j][0])
	{
		//menampilkan data dari hasil query database
		$pdf->Cell( 0.8	,0.72,$No,'LRTB',0,R);
		$pdf->Cell( 2	,0.72,$cell[$j][2],'LRTB',0,C);
		$pdf->Cell(11.2	,0.72,$cell[$j][3],'LRTB',0,L);
		$pdf->Cell( 5	,0.72,'','LRTB',0,C);
		$pdf->Ln();
		$x++;
		$j++;
		$No++;
	}
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(19   ,0,'',1); 	
	$pdf->Ln();
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 5	,0.4,'FORM : G1D02_C02 (PERSONALIA)');
	if ($j<$i AND $kdestt==$cell[$j][0])
	{
		$Hlm=$Hlm+1;
		$pdf->Cell(14	,0.4,$kdeusr.' '.$tgl.' '.$jam.' Bersambung ke Halaman : '.$Hlm,0,0,R);	
		$pdf->Ln();
	}
	else
	{
		$pdf->Cell(14	,0.4,$kdeusr.' '.$tgl.' '.$jam.' Halaman : '.$Hlm,0,0,R);	
		$pdf->Ln();
		$Hlm=1;
		$No=1;
	}
}
//menampilkan output berupa Hlmaman PDF
$pdf->Output();
?>