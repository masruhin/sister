<?php
//----------------------------------------------------------------------------------------------------
//Program		: K1D03_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 023/04/2012
//Keterangan	: Cetak BUKTI TERIMA UANG
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_qrcode.php';

$nmrbtu=$_GET['nmrbtu'];
$query 		="	UPDATE 	t_btukng 
				SET		t_btukng.str	='P'
				WHERE 	t_btukng.nmrbtu	='". mysql_escape_string($nmrbtu)."'";
$result		=mysql_query ($query);	

$query 		="	SELECT 	*
				FROM 	t_btukng
				WHERE 	t_btukng.nmrbtu='". mysql_escape_string($nmrbtu)."'";
$result 	=mysql_query($query) or die('Query gagal');
$data 		=mysql_fetch_array($result);

$QRCode	=buatQR($nmrbtu);
$QRCode	='../../'.DIRECTORY_SEPARATOR.'/files/QRtemp'.DIRECTORY_SEPARATOR.$nmrbtu.'.png';
$pdf 	=new FPDF('P','cm','A4');

$tgl 	=date("d-m-Y");
$jam	=date("h:i:s");
$judul	="BUKTI TERIMA UANG";

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
$pdf->Cell( 3.5	,0.7, $data[nmrbtu],'BTLR',0,C); 
$pdf->Ln();
$pdf->Cell(13	,1);
$pdf->Cell( 2.5	,0.7, "Tanggal",'BTLR',0,C); 		
$pdf->Cell( 3.5	,0.7, $data[tglbtu],'BTLR',0,C); 
$pdf->Ln();
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(13	,0.7, $judul); 
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell( 3.5	,0.7, "Diterima dari",'BTLR'); 
$pdf->Cell(15.5	,0.7, $data[dr],'BTLR'); 
$pdf->Ln();
$pdf->Cell( 3.5	,0.7, "Sejumlah",'BTLR'); 
$pdf->Cell(15.5	,0.7, "Rp. ".number_format($data[nli]).",-",'BTLR'); 
$pdf->Ln();
$terbilang=terbilang($data[nli]).' Rupiah';
$pdf->Cell( 3.5	,0.7, "Terbilang",'TLR'); 		
$terbilang 	=susun_kalimat($terbilang, 70);
$Jml		=count($terbilang);
$i=0;
while ($i<2)
{
	if ($i>0)
	{
		$pdf->Cell( 3.5	,0.7,'',LR); 	
	}	
	$pdf->Cell(15.5	,0.7, $terbilang[$i],LR,0,L); 
	$pdf->Ln();
	$i++;
}	
$pdf->Cell( 19,0,'',1); 
$pdf->Ln();
$pdf->Cell(19	,0.6, "Keterangan",LRT,0,L); 
$pdf->Ln();
$ktr 	=susun_kalimat($data[ktr], 85);
$Jml	=count($ktr);
$i=0;
while ($i<8)
{
	$pdf->Cell(19	,0.6, $ktr[$i],LR,0,L); 
	$pdf->Ln();
	$i++;
}	
$pdf->Cell( 19,0,'',1); 	
$pdf->Ln(0.2);
$pdf->Image($QRCode,1.7,11.9,2.2);
$pdf->Cell( 4	,0.5); 
$pdf->Cell( 3	,0.5, "Akuntansi",'BTLR',0,C); 	
$pdf->Cell( 3	,0.5, "TTD Cek",'BTLR',0,C); 	
$pdf->Cell( 3	,0.5, "Mengetahui",'BTLR',0,C); 	
$pdf->Cell( 3	,0.5, "Kasir",'BTLR',0,C); 	
$pdf->Cell( 3	,0.5, "Diserahkan oleh",'BTLR',0,C); 	
$pdf->Ln();
$pdf->Cell( 4	,0.5); 
$pdf->Cell( 3	,0.5, "",'TLR'); 	
$pdf->Cell( 3	,0.5, "",'TLR'); 	
$pdf->Cell( 3	,0.5, "",'TLR'); 	
$pdf->Cell( 3	,0.5, "",'TLR'); 	
$pdf->Cell( 3	,0.5, "",'TLR'); 	
$pdf->Ln();
$pdf->Cell( 4	,0.5); 
$pdf->Cell( 3	,0.5, "",'LR'); 	
$pdf->Cell( 3	,0.5, "",'LR'); 	
$pdf->Cell( 3	,0.5, "",'LR'); 	
$pdf->Cell( 3	,0.5, "",'LR'); 	
$pdf->Cell( 3	,0.5, "",'LR'); 	
$pdf->Ln();
$pdf->Cell( 4	,0.5); 
$pdf->Cell( 3	,0.5, "",'BLR'); 	
$pdf->Cell( 3	,0.5, "",'BLR'); 	
$pdf->Cell( 3	,0.5, "",'BLR'); 	
$pdf->Cell( 3	,0.5, "",'BLR'); 	
$dr=explode(" ", $data[dr]);
$pdf->Cell( 3	,0.5, $dr[0],'BLR',0,C); 	
$pdf->Ln(0.9);
$pdf->SetFont('Arial','',6);
$pdf->Cell( 19,0,'',1); 	
$pdf->Ln();
$pdf->Cell(5	,0.5,'FORM : K1D03_01 (KEUANGAN)');
$pdf->Cell(14	,0.5,$tgl.' '.$jam,0,0,R);
//menampilkan output berupa halaman PDF
$pdf->Output();
?>