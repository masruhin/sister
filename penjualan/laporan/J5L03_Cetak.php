<?php
//----------------------------------------------------------------------------------------------------
//Program		: J5L03_Cetak.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: LAPORAN PERNJUALAN ( Per Hari )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$tgl1B	=$_POST['tgl1'];
$tgl2B	=$_POST['tgl2'];

if (empty($tgl1B))
{
	$modul	='PENJUALAN';
	$prd 	=periode($modul);
	$tgl1B	=substr($prd,2).'-'.substr($prd,2,2).'-'.'01';
	$tgl1B	='01-'.substr($prd,2,2).'-'.date('Y',strtotime($tgl1B));
	$tglA	=$tgl1B;
}
else
{
	$prd	=substr($tgl1B,-2).substr($tgl1B,3,2);
	$tglA	=substr($prd,2).'-'.substr($prd,2,2).'-'.'01';
	$tglA	=substr($tgl1B,0,2).'-'.substr($prd,2,2).'-'.date('Y',strtotime($tglA));
}	
if (empty($tgl2B))
{
	$bulan	=substr($tgl1B,3,2);
	$tahun	=substr($tgl1B,-2);
	$tgl2B	=date('d-m-Y',strtotime('-1 second',strtotime('+1 month',strtotime(date($bulan).'/01/'.date($tahun).' 00:00:00'))));
}

$query 		="	SELECT 		*
				FROM 		t_gnrpnj
				WHERE 		t_gnrpnj.tglpnj>='$tgl1B'						AND		
							t_gnrpnj.tglpnj<='$tgl2B'						AND	
							substr(t_gnrpnj.tglpnj,4,2)=substr('$prd',-2) 	AND
							substr(t_gnrpnj.tglpnj,-2)=substr('$prd',1,2)";
$db_query 	=mysql_query($query) or die('Query gagal');

$i=1;
while($data =mysql_fetch_array($db_query))
{
	$cell[$i][ 0] 	=$data[nmrpnj];
	$cell[$i][ 1] 	=$data[tglpnj];
	$cell[$i][ 2] 	=$data[utk];
	$query		="	SELECT 		sum(t_dtlpnj.bny*t_dtlpnj.hrg) as ttl
					FROM 		t_dtlpnj
					WHERE 		t_dtlpnj.nmrpnj='$data[nmrpnj]'";
	$result 	=mysql_query($query) or die (mysql_error());
	$ttl 		=mysql_fetch_array($result);
	$ttl 		=$ttl['ttl'];	

	$cell[$i][ 3] 	=$ttl;
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
	$judul	="LAPORAN PENJUALAN ( Per Hari )";

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
	$pdf->Cell( 2.1	,0.4,"Dari Tanggal",0,0,L); 		
	$pdf->Cell( 2	,0.4,' : '.$tgl1B); 
	$pdf->Cell( 2.4	,0.4,"Sampai Tanggal",0,0,L); 		
	$pdf->Cell(12.5	,0.4,' : '.$tgl2B); 
	$pdf->Ln();
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell( 0.8	,0.4,'NO'			,'LRTB',0,C);
	$pdf->Cell( 2.2	,0.4,'NO. PENJUALAN','LRTB',0,C);
	$pdf->Cell( 1.5	,0.4,'TANGGAL'		,'LRTB',0,C);
	$pdf->Cell(12	,0.4,'UNTUK'		,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'TOTAL'		,'LRTB',0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
    $x=1;
	while ($x<=60 AND $j<$i)
	{
		//menampilkan data dari hasil query database
		$pdf->Cell( 0.8	,0.4,$No,0,0,R);
		$pdf->Cell( 2.2	,0.4,$cell[$j][0]);
		$pdf->Cell( 1.5	,0.4,$cell[$j][1]);
		$pdf->Cell(12	,0.4,$cell[$j][2]);
		$ttl=$cell[$j][3];
		$pdf->Cell( 2.5	,0.4,number_format($ttl),0,0,R);
		$pdf->Ln();
		$x++;
		$j++;
		$No++;		
		$gttl=$gttl+$ttl;
	}	
	$pdf->Cell(19   ,0,'',1); 	
	$pdf->Ln();
	if ($j>=$i)
	{
		$pdf->Cell(16.5	,0.4,'TOTAL SELURUHNYA',0,0,L); 	
		$pdf->Cell( 2.5	,0.4,number_format($gttl)	,0,0,R); 	
		$pdf->Ln();
		$pdf->Cell(19   ,0,'',1); 	
		$pdf->Ln();
	}	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 5	,0.4,'FORM : J5L03 (PENJUALAN)');
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