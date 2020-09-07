<?php
//----------------------------------------------------------------------------------------------------
//Program		: J5L05_Cetak.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: LAPORAN PERSEDIAAN
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$prd	=$_POST['prd'];
if($prd=='')
{
	$prd=periode('PENJUALAN');
}
$kdeklm	=$_POST['kdeklm'];
$tgl	=substr($prd,2).'-'.substr($prd,-2).'-01';
$periode=tanggal('M Y',$tgl);

$query 	="	SELECT 		*,t_mstbrn.nmabrn,t_klmbrn.nmaklm
			FROM 		t_sldbrn,t_mstbrn,t_klmbrn
			WHERE 		t_sldbrn.prd>='$prd'							AND
						(t_mstbrn.kdeklm 	='$kdeklm' OR '$kdeklm'='')	AND
						t_sldbrn.kdebrn=t_mstbrn.kdebrn					AND
						t_mstbrn.kdeklm=t_klmbrn.kdeklm";
$result =mysql_query($query) or die('Query gagal');

$i=1;
while($data =mysql_fetch_array($result))
{
	$cell[$i][ 0] 	=$data[kdebrn];
	$cell[$i][ 1] 	=$data[nmabrn];
	$cell[$i][ 2] 	=$data[sldawl];
	$cell[$i][ 3] 	=$data[msk];
	$cell[$i][ 4] 	=$data[klr];
	$cell[$i][ 5] 	=$data[nmaklm];
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
	$judul	="LAPORAN PERSEDIAAN";

	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(14	,0.4,$nama_pt);
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell( 3	,0.4,"Tanggal :",0,0,R);
	$pdf->Cell( 2	,0.4,$tgl,0,0,L);
	$pdf->Ln();
	$pdf->Cell(14	,0.4,$kota_pt);
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
	$pdf->Cell( 2.1	,0.4,"Periode",0,0,L); 		
	$pdf->Cell( 2	,0.4,' : '.$periode); 
	$pdf->Ln();
	if ($kdeklm!='')
	{
		$pdf->Cell( 2.5	,0.4,"Kelompok Barang",0,0,L); 
		$pdf->Cell(16.5	,0.4," : ".$cell[$j][5]); 
		$pdf->Ln();
	}	
	
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell( 0.8	,0.4,'NO'			,'LRTB',0,C);
	$pdf->Cell( 8.2	,0.4,'BARANG'		,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'SALDO AWAL'	,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'MASUK'		,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'KELUAR'		,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'SALDO AKHIR'	,'LRTB',0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
    $x=1;
	while ($x<=60 AND $j<$i)
	{
		//menampilkan data dari hasil query database
		$nmabrn	=$cell[$j][ 1];
		$sldawal=$cell[$j][ 2];
		$msk	=$cell[$j][ 3];
		$klr	=$cell[$j][ 4];
		$sldakh	=$cell[$j][ 2]+$cell[$j][ 3]-$cell[$j][ 4];;
		$pdf->Cell( 0.8	,0.4,$No,0,0,R);
		$pdf->Cell( 8.2	,0.4,$nmabrn);
		$pdf->Cell( 2.5	,0.4,number_format($sldawal),0,0,R);
		$pdf->Cell( 2.5	,0.4,number_format($msk),0,0,R);
		$pdf->Cell( 2.5	,0.4,number_format($klr),0,0,R);
		$pdf->Cell( 2.5	,0.4,number_format($sldakh),0,0,R);
		$pdf->Ln();
		$x++;
		$j++;
		$No++;		
		$gttl=$gttl+$ttl;
	}	
	$pdf->Cell(19   ,0,'',1); 	
	$pdf->Ln();
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 5	,0.4,'FORM : J5L05 (PENJUALAN)');
	if ($j<$i)
	{
		$Hal=$Hal+1;
		$pdf->Cell(14  	,0.4,"Bersambung ke hal : ".$Hal,0,0,R);
		$pdf->Ln();
	}
}
//menampilkan output berupa halaman PDF
$pdf->Output();
?>