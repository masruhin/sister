<?php
//----------------------------------------------------------------------------------------------------
//Program		: G1D02_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_qrcode.php';

$kdekry=$_GET['kdekry'];

$query 		="	SELECT 	t_mstkry.*,t_mstagm.*,t_sttkry.*
				FROM 	t_mstkry,t_mstagm,t_sttkry
				WHERE 	t_mstkry.kdekry='". mysql_escape_string($kdekry)."' AND
						t_mstkry.kdeagm=t_mstagm.kdeagm						AND
						t_mstkry.kdestt=t_sttkry.kdestt";
$result 	=mysql_query($query) or die('Query gagal');
$data 		=mysql_fetch_array($result);
$kdeusr=$_SESSION['Admin']['username'];


$logo	="../../images/logo_sd.jpg";
$photo	="../../files/photo/karyawan/$kdekry.jpg";

$pdf 	=new FPDF('P','cm','A4');
$pdf->AddFont('FRIZQUAD','','FRIZQUAD.php');

$tgl 	=date("d-m-Y");
$jam	=date("h:i:s");
$judul1	="DATA KARYAWAN";

$pdf->Open();
$pdf->AddPage();
$pdf->Image($logo,1.5,1.5,2,2);
$pdf->Ln(0.7);
$pdf->SetFont('arial','',8);//FRIZQUAD
$pdf->Cell( 3	,1);
$pdf->Cell(10	,1, 'sciantia, virtus, et vita');//$nama_pt2_a
$pdf->SetFont('arial','B',8);
$pdf->Cell( 6	,1, '','',0,R);//$nama_pt
$pdf->SetFont('arial','B',20);//FRIZQUAD
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
$pdf->Cell(19	,3, $judul1,0,0,C);

$pdf->Ln(2.5);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, " 1.",0,0,R);
$pdf->Cell(6	, 0, "Status",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[nmastt],0,0,L);

$pdf->Ln(0.8);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, " 2.",0,0,R);
$pdf->Cell(6	, 0, "Kode Karyawan",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[kdekry],0,0,L);

$pdf->Ln(0.8);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, " 3.",0,0,R);
$pdf->Cell(6	, 0, "Nama Lengkap",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[nmakry],0,0,L);

$pdf->Ln(0.8);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, " 4.",0,0,R);
$pdf->Cell(6	, 0, "Jenis Kelamin",0,0,L);
$pdf->SetFont('arial','',8);
if($data[jnsklm]=='L')
{
	$pdf->Cell(12	, 0, ": LAKI-LAKI",0,0,L);
}
else
{
	$pdf->Cell(12	, 0, ": PEREMPUAN",0,0,L);
}	

$pdf->Ln(0.8);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, " 5.",0,0,R);
$pdf->Cell(6	, 0, "Tempat / tanggal Lahir",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[tmplhr].", ".$data[tgllhr],0,0,L);

$pdf->Ln(0.8);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, " 6.",0,0,R);
$pdf->Cell(6	, 0, "Agama",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[nmaagm],0,0,L);

$almkry	=$data[alm].', '.$data[kta].'-'.$data[kdepos];
$alm 	=susun_kalimat($almkry, 54);
$pdf->Ln(0.8);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, " 7.",0,0,R);
$pdf->Cell(6	, 0, "Alamat Lengkap",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0,": ".$alm[0],0,0,L); 
$pdf->Ln(0.3);	
$pdf->SetFont('arial','',8);
$pdf->Cell(7	, 0, "",0,0,L);
$pdf->Cell(12	, 0,"  ".$alm[1],0,0,L); 

$pdf->Ln(0.8);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, " 8.",0,0,R);
$pdf->Cell(6	, 0, "Telpon",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[tlp],0,0,L);

$pdf->Ln(0.8);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, " 9.",0,0,R);
$pdf->Cell(6	, 0, "HP Aktif",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[hpakt],0,0,L);

$pdf->Ln(0.8);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "10.",0,0,R);
$pdf->Cell(6	, 0, "Warga Negara",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[wrgngr],0,0,L);

$pdf->Ln(0.8);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "11.",0,0,R);
$pdf->Cell(6	, 0, "Nama Pasangan",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[nmapsn],0,0,L);

$pdf->Ln(0.8);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "12.",0,0,R);
$pdf->Cell(6	, 0, "Keterangan",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[ktr],0,0,L);

$pdf->Ln(0.5);
$pdf->SetFont('Arial','',6);
$pdf->Cell( 19,0,'',1); 
$pdf->Ln(0.2);
$pdf->Cell(5	,0,'FORM : G1D02_C01 (PERSONALIA)');
$pdf->Cell(14	,0,$kdeusr.' '.$tgl.' '.$jam.' Page : 1 of 1',0,0,R);	
//menampilkan output berupa halaman PDF
$pdf->Output();
?>