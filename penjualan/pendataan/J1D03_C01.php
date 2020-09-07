<?php
//----------------------------------------------------------------------------------------------------
//Program		: J1D03_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak BUKTI MASUK BARANG
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$nmrbmb=$_GET['nmrbmb'];
$query 		="	UPDATE 	t_gnrbmb 
				SET		t_gnrbmb.str	='P'
				WHERE 	t_gnrbmb.nmrbmb	='". mysql_escape_string($nmrbmb)."'";
$result		=mysql_query ($query);	

$query 		="	SELECT 	*,t_gnrbmb.tglbmb,t_gnrbmb.dr,t_gnrbmb.rfr,t_mstbrn.nmabrn,t_gnrbmb.ktr
				FROM 	t_dtlbmb,t_gnrbmb,t_mstbrn
				WHERE 	t_dtlbmb.nmrbmb='". mysql_escape_string($nmrbmb)."'	AND
						t_dtlbmb.nmrbmb=t_gnrbmb.nmrbmb						AND
						t_dtlbmb.kdebrn=t_mstbrn.kdebrn";
$result 	=mysql_query($query) or die('Query gagal');

$i=0;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[nmrbmb];
	$cell[$i][1] 	=$data[tglbmb];
	$cell[$i][2] 	=$data[dr];
	$cell[$i][3] 	=$data[rfr];
	$cell[$i][4] 	=$data[kdebrn];
	$cell[$i][5] 	=$data[nmabrn];
	$cell[$i][6] 	=$data[bny];
	$cell[$i][7] 	=$data[ktr];
	$i++;
}

$pdf 	=new FPDF('P','cm','A4');

$tgl 	=date("d-m-Y");
$jam	=date("h:i:s");
$judul	="BUKTI MASUK BARANG";

$j	=0;
$No	=1;
while ($j<$i)
{
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(14	,1, $nama_pt);
	$pdf->SetFont('Arial','B',6);	
	$pdf->Cell( 5	,0.5, "Keperluan Intern",0,0,R);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(13	,1,$kota_pt);
	$pdf->Cell( 2.5	,0.7, "Nomor",'BTLR',0,C);
	$pdf->Cell( 3.5	,0.7, $cell[$j][0],'BTLR',0,C); 
	$pdf->Ln();
	$pdf->Cell(13	,1);
	$pdf->Cell( 2.5	,0.7, "Tanggal",'BTLR',0,C); 		
	$pdf->Cell( 3.5	,0.7, $cell[$j][1],'BTLR',0,C); 
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(13	,0.7, $judul); 
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell( 3.5	,0.7, "Diterima barang dari :",'');
	$pdf->Cell( 7	,0.7, $cell[$j][2],''); 
	$pdf->Cell( 1.8	,0.7, "Referensi :",'');
	$pdf->Cell( 6.7	,0.7, $cell[$j][3],''); 
	
	$pdf->Ln();
	$pdf->Cell( 1	,0.7, "No.",'BTLR',0,C); 
	$pdf->Cell( 3	,0.7, "Kode",'BTLR',0,C); 
	$pdf->Cell(12.5	,0.7, "Nama",'BTLR',0,C); 
	$pdf->Cell( 2.5	,0.7, "Banyak",'BTLR',0,C); 
	$pdf->Ln();
	$dr=explode(" ", $cell[$j][2]);
	$x=0;
	while ($j<$i and $x<=8)
	{
		$pdf->Cell( 1	,0.7, $No,LR,0,L); 
		$pdf->Cell( 3	,0.7, $cell[$j][4],LR,0,L); 
		$pdf->Cell(12.5	,0.7, $cell[$j][5],LR,0,L); 		
		$pdf->Cell( 2.5	,0.7, number_format($cell[$j][6]),LR,0,R); 
		$pdf->Ln();
		$No++;
		$j++;
		$x++;
	}	
	while ($x<=8)
	{
		$pdf->Cell( 1	,0.7, '',LR,0,L); 
		$pdf->Cell( 3	,0.7, '',LR,0,L); 
		$pdf->Cell(12.5	,0.7, '',LR,0,L); 		
		$pdf->Cell( 2.5	,0.7, '',LR,0,R); 
		$pdf->Ln();
		$x++;
	}	
	
	$pdf->Cell( 19,0,'',1); 
	$pdf->Ln(0.2);
	$pdf->Cell( 7	,0.5); 
	$pdf->Cell( 6	,0.5, "Mengetahui",'BTLR',0,C); 	
	$pdf->Cell( 6	,0.5, "Diserahkan oleh",'BTLR',0,C); 	
	$pdf->Ln();
	$pdf->Cell( 7	,0.5); 
	$pdf->Cell( 6	,0.5, "",'TLR'); 	
	$pdf->Cell( 6	,0.5, "",'TLR'); 	
	$pdf->Ln();
	$pdf->Cell( 7	,0.5); 
	$pdf->Cell( 6	,0.5, "",'LR'); 	
	$pdf->Cell( 6	,0.5, "",'LR'); 	
	$pdf->Ln();
	$pdf->Cell( 7	,0.5); 
	$pdf->Cell( 6	,0.5, "",'LR'); 	
	$pdf->Cell( 6	,0.5, "",'LR'); 	
	$pdf->Ln();
	$pdf->Cell( 7	,0.5); 
	$pdf->Cell( 6	,0.5, "",'BLR'); 	
	$pdf->Cell( 6	,0.5, $dr[0],'BLR',0,C); 	
	$pdf->Ln(0.7);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 19,0,'',1); 	
	$pdf->Ln();
	$pdf->Cell(5	,0.5,'FORM : J1D03_C01 (PENJUALAN)');
	$pdf->Cell(14	,0.5,$tgl.' '.$jam,0,0,R);
}	
//menampilkan output berupa halaman PDF
$pdf->Output();
?>