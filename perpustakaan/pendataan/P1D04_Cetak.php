<?php
//----------------------------------------------------------------------------------------------------
//Program		: P1D04_Cetak.php
//Sumber		: sister
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak BUKTI KELUAR BARANG
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$nmrpjm	=$_GET['nmrpjm'];
$query	="	SELECT 	t_gnrpjm.*,t_dtlpjm.*,t_mstssw.*,t_mstbku.*
			FROM 	t_gnrpjm,t_dtlpjm,t_mstssw,t_mstbku
			WHERE 	t_gnrpjm.nmrpjm='". mysql_escape_string($nmrpjm)."'	AND
					t_dtlpjm.nmrpjm=t_gnrpjm.nmrpjm						AND
					t_gnrpjm.kdeang=t_mstssw.nis						AND
					t_mstbku.kdebku=t_dtlpjm.kdebku";
$result =mysql_query($query) or die('Query gagal');

$i=0;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[nmrpjm];
	$cell[$i][1] 	=$data[tglpjm];
	$cell[$i][2] 	=$data[stt];
	$cell[$i][3] 	=$data[kdeang];
	$cell[$i][4] 	=$data[nmassw];
	
	$cell[$i][5] 	=$data[kdebku];
	$cell[$i][6] 	=$data[jdl];
	$i++;
}

$pdf 	=new FPDF('P','cm','A4');

$tgl 	=date("d-m-Y");
$jam	=date("h:i:s");
$judul	="BUKTI PEMINJAMAN SISWA";

$j	=0;
$No	=1;
while ($j<$i)
{
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(14	,1, "SAINT JOHN'S SCHOOL"); // $nama_pt
	$pdf->SetFont('Arial','B',6);	
	$pdf->Cell( 5	,0.5, "Keperluan Intern",0,0,R);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(13	,1,'JAKARTA - INDONESIA'); // $kota_pt
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
	$pdf->Cell( 4.5	,0.7, "Dikeluarkan barang untuk :",'');
	$pdf->Cell(14.5	,0.7, $cell[$j][4].' ('.$cell[$j][3].')',''); // $cell[$j][2]
	$pdf->Ln();
	$pdf->Cell( 1	,0.7, "No.",'BTLR',0,C); 
	$pdf->Cell( 3	,0.7, "Kode",'BTLR',0,C); 
	$pdf->Cell(12.5	,0.7, "Nama",'BTLR',0,C); 
	$pdf->Cell( 2.5	,0.7, "Banyak",'BTLR',0,C); 
	$pdf->Ln();
	$utk=$cell[$j][4]; // $utk=explode(" ", $cell[$j][2]);
	$x=0;
	while ($j<$i and $x<=8)
	{
		$pdf->Cell( 1	,0.7, $No,LR,0,L); 
		$pdf->Cell( 3	,0.7, $cell[$j][5],LR,0,L); // $cell[$j][3]
		$pdf->Cell(12.5	,0.7, $cell[$j][6],LR,0,L); // $cell[$j][4]
		$pdf->Cell( 2.5	,0.7, '1',LR,0,R); // number_format($cell[$j][5])
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
	$pdf->Cell( 6	,0.5, "Diterima oleh",'BTLR',0,C); 	
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
	$pdf->Cell( 6	,0.5, $utk,'BLR',0,C); // $utk[0]
	$pdf->Ln(0.7);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 19,0,'',1); 	
	$pdf->Ln();
	$pdf->Cell(5	,0.5,'FORM : P1D04 (PERPUSTAKAAN)');
	$pdf->Cell(14	,0.5,$tgl.' '.$jam,0,0,R);
}	
//menampilkan output berupa halaman PDF
$pdf->Output();
?>