<?php
//----------------------------------------------------------------------------------------------------
//Program		: K5L01_Cetak.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: LAPORAN BUKTI TERIMA UANG
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$tgl1B	=$_POST['tgl1'];
$tgl2B	=$_POST['tgl2'];
$kdejtu	=$_POST['kdejtu'];

if (empty($tgl1B))
{
	$prd 	=periode('KEUANGAN');
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

$query 	="	SELECT 		t_btukng.nmrbtu,t_btukng.tglbtu,t_btukng.dr,t_btukng.nli,t_jtu.nmajtu
			FROM 		t_btukng,t_jtu
			WHERE 		t_btukng.tglbtu>='$tgl1B'						AND		
						t_btukng.tglbtu<='$tgl2B'						AND	
						substr(t_btukng.tglbtu,4,2)=substr('$prd',-2) 	AND
						substr(t_btukng.tglbtu,-2)=substr('$prd',1,2)	AND
						(t_btukng.kdejtu	='". mysql_escape_string($kdejtu)."'	OR '$kdejtu'='')	AND
						t_btukng.kdejtu		=t_jtu.kdejtu
			ORDER BY 	t_btukng.nmrbtu,t_btukng.tglbtu";

$result =mysql_query($query) or die('Query gagal');

$i=1;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[nmrbtu];
	$cell[$i][1] 	=$data[tglbtu];
	$cell[$i][2] 	='Dari '.$data[dr];
	$cell[$i][3] 	=$data[nli];
	$cell[$i][4] 	=$data[nmajtu];
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
	$judul	="LAPORAN BUKTI TERIMA UANG";

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
	$pdf->Cell( 2.4	,0.4,"Dari Tanggal",0,0,L); 		
	$pdf->Cell( 2	,0.4,' : '.$tgl1B); 
	$pdf->Cell( 2.4	,0.4,"Sampai Tanggal",0,0,L); 		
	$pdf->Cell(12.2	,0.4,' : '.$tgl2B); 
	$pdf->Ln();
	if ($kdejtu!='')
	{
		$pdf->Cell( 2.4	,0.4,"Jenis Penerimaan",0,0,L); 
		$pdf->Cell(16.6	,0.4," : ".$cell[$j][4]);
		$pdf->Ln();
	}	
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell( 0.8	,0.4,'NO'			,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'NO. BUKTI'	,'LRTB',0,C);
	$pdf->Cell( 1.7	,0.4,'TANGGAL'		,'LRTB',0,C);
	$pdf->Cell(11.5	,0.4,'KETERANGAN'	,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'NILAI'		,'LRTB',0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
    $x=1;
	while ($x<=60 AND $j<$i)
	{
		$nmr=$cell[$j][0];
		$tgl=$cell[$j][1];
		$Ktr=$cell[$j][2];
		$nli=$cell[$j][3];
		//menampilkan data dari hasil query database
		$pdf->Cell( 0.8	,0.4,$No				,0,0,R);
		$pdf->Cell( 2.5	,0.4,$nmr				,0,0,C);
		$pdf->Cell( 1.7	,0.4,$tgl				,0,0,C);
		$pdf->Cell(11.5	,0.4,$Ktr				,0,0,L);
		$pdf->Cell( 2.5	,0.4,number_format($nli),0,0,R);
		$pdf->Ln();
		$Ttl=$Ttl+$nli;
		$No++;		
		$x++;
		$j++;
	}
	$pdf->Cell(19   ,0,'',1); 	
	$pdf->Ln();
	if ($j>=$i)
	{
		$pdf->Cell(16.5,0.4,'TOTAL',0,0,L); 	
		$pdf->Cell( 2.5,0.4,number_format($Ttl),0,0,R); 	
		$pdf->Ln();
		$pdf->Cell(19   ,0,'',1); 	
		$pdf->Ln();
	}
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 5	,0.4,'FORM : K5L01 (KEUANGAN)');
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