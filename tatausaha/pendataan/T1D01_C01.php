<?php
//----------------------------------------------------------------------------------------------------
//Program		: T1D01_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_qrcode.php';

$nis=$_GET['nis'];

$query 		="	SELECT 	*,t_mstagm.nmaagm
				FROM 	t_mstssw,t_mstagm
				WHERE 	t_mstssw.nis='". mysql_escape_string($nis)."' AND
						t_mstssw.kdeagm=t_mstagm.kdeagm";
$result 	=mysql_query($query) or die('Query gagal');
$data 		=mysql_fetch_array($result);
$agmayh=$data[agmayh];
$agmibu=$data[agmibu];
$agmwli=$data[agmwli];
$kdeusr=$_SESSION['Admin']['username'];

$query2 	="	SELECT 	*
				FROM 	t_mstagm
				WHERE 	t_mstagm.kdeagm='". mysql_escape_string($agmayh)."'";
$result2 	=mysql_query($query2) or die('Query gagal');
$data2 		=mysql_fetch_array($result2);
$agmayh=$data2[nmaagm];

$query2 	="	SELECT 	*
				FROM 	t_mstagm
				WHERE 	t_mstagm.kdeagm='". mysql_escape_string($agmibu)."'";
$result2 	=mysql_query($query2) or die('Query gagal');
$data2 		=mysql_fetch_array($result2);
$agmibu=$data2[nmaagm];

$query2 	="	SELECT 	*
				FROM 	t_mstagm
				WHERE 	t_mstagm.kdeagm='". mysql_escape_string($agmwli)."'";
$result2 	=mysql_query($query2) or die('Query gagal');
$data2 		=mysql_fetch_array($result2);
$agmwli=$data2[nmaagm];

$logo	="../../images/logo_sd.jpg";
$photo	="../../files/photo/siswa/$nis.jpg";

$pdf 	=new FPDF('P','cm','A4');
$pdf->AddFont('FRIZQUAD','','FRIZQUAD.php');

$tgl 	=date("d-m-Y");
$jam	=date("h:i:s");
$judul1	="DATA SISWA";
$judul2	="DATA OF STUDENT";

$pdf->Open();
$pdf->AddPage();
$pdf->Image($logo,1.5,1.5,2,2);
$pdf->Ln(0.7);
$pdf->SetFont('arial','I',8);//FRIZQUAD
$pdf->Cell( 3	,1);
$pdf->Cell(10	,1, "sciantia, virtus, et vita");//$nama_pt2_a
$pdf->SetFont('arial','B',8);
$pdf->Cell( 6	,1, "",'',0,R);//$nama_pt 
$pdf->SetFont('arial','B',17.5);//FRIZQUAD 20
$pdf->Ln();
$pdf->Cell( 3	,-0.1);
$pdf->Cell(10	,-0.1, "SAINT JOHN'S SCHOOL");//$nama_pt2
$pdf->SetFont('arial','',6);
$pdf->Cell( 6	,-0.5, "",'',0,R);//$alamat1_pt
$pdf->Ln();
$pdf->SetFont('arial','',8);//FRIZQUAD
$pdf->Cell( 3	,1.7);
$pdf->Cell( 7.2	,1.7,"A NATIONAL PLUS SCHOOL",'',0,R); //$nama_pt2_b	CATHOLIC
$pdf->SetFont('arial','',6);
$pdf->Cell( 8.8	,1, "",'',0,R);//$alamat2_pt
$pdf->Ln();
$pdf->SetFont('arial','',6);
$pdf->Cell(19	,-0.5, "",'',0,R);//$alamat3_pt

$pdf->Ln();
$pdf->SetFont('arial','BU',12);
$pdf->Cell(19	,3, $judul1,0,0,C);
$pdf->Ln(1.9);
$pdf->SetFont('arial','I',8);
$pdf->Cell(19	,0, $judul2,0,0,C);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','BU',8);
$pdf->Cell(19	, 0, "Data Calon Siswa",0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(19	, 0, "Applicant's Personal Data",0,0,L);

$nmassw=$data[nmassw];
$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "1.",0,0,R);
$pdf->Cell(6	, 0, "Nama Lengkap",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[nmassw]." (NIS : ".substr($nis,0,3).")",0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Complete Name",0,0,L);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "2.",0,0,R);
$pdf->Cell(6	, 0, "Nama Panggilan",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[nmapgl],0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Nick Name",0,0,L);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "3.",0,0,R);
$pdf->Cell(6	, 0, "Tempat / tanggal Lahir",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[tmplhr].", ".$data[tgllhr],0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Place / Date of birth",0,0,L);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "4.",0,0,R);
$pdf->Cell(6	, 0, "Agama",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[nmaagm],0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Religion",0,0,L);

$almssw	=$data[alm].', '.$data[kta].'-'.$data[kdepos];
$alm 	=susun_kalimat($almssw, 54);
$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "5.",0,0,R);
$pdf->Cell(6	, 0, "Alamat Lengkap",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0,": ".$alm[0],0,0,L); 
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Complete Address",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0,"  ".$alm[1],0,0,L); 

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "6.",0,0,R);
$pdf->Cell(6	, 0, "Sekolah Asal",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[sklasl],0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Previous School",0,0,L);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "7.",0,0,R);
$pdf->Cell(6	, 0, "Bahasa yang digunakan sehari-hari",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[bhsdgn],0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Daily Language",0,0,L);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "8.",0,0,R);
$pdf->Cell(6	, 0, "Mendaftar Untuk Kelas",0,0,L);
$pdf->SetFont('arial','',10);
$pdf->Cell(12	, 0, ": ".$data[dftkls],0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Applying for grade",0,0,L);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','BU',8);
$pdf->Cell(19	, 0, "Data Orang Tua / Wali",0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(19	, 0, "Data of parents/Guardians",0,0,L);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "1.",0,0,R);
$pdf->Cell(6	, 0, "Nama Ayah",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[nmaayh],0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Father's Name",0,0,L);

if($almayh=='')
{
	$almayh=$almssw;
}
else
{
	$almayh=$data[almayh];
}
$almayh =susun_kalimat($almayh, 54);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "",0,0,R);
$pdf->Cell(6	, 0, "Alamat Lengkap",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0,": ".$almayh[0],0,0,L); 
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Complete Address",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0,"  ".$almayh[1],0,0,L); 

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Agama",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$agmayh,0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Religion",0,0,L);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Pekerjaan",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[pkjayh],0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Occupation",0,0,L);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "2.",0,0,R);
$pdf->Cell(6	, 0, "Nama Ibu",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[nmaibu],0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Mother's Name",0,0,L);

if($almibu=='')
{
	$almibu=$almssw;
}
else
{
	$almibu=$data[almibu];
}
$almibu =susun_kalimat($almibu, 54);
$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Alamat Lengkap",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0,": ".$almibu[0],0,0,L); 
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Complete Address",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0,"  ".$almibu[1],0,0,L); 

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Agama",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$agmibu,0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Religion",0,0,L);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Pekerjaan",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[pkjibu],0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Occupation",0,0,L);

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0, "3.",0,0,R);
$pdf->Cell(6	, 0, "Nama Wali",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[nmawli],0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Guardian Name",0,0,L);

if($almwli=='')
{
	$almwli=$almssw;
}
else
{
	$almwli=$data[almwli];
}
$almwli =susun_kalimat($almwli, 54);
$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Alamat Lengkap",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0,": ".$almwli[0],0,0,L); 
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Complete Address",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0,"  ".$almwli[1],0,0,L); 

$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Agama",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$agmwli,0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Religion",0,0,L);
$pdf->Ln(0.4);	
$pdf->SetFont('arial','B',8);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Pekerjaan",0,0,L);
$pdf->SetFont('arial','',8);
$pdf->Cell(12	, 0, ": ".$data[pkjwli],0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(1	, 0);
$pdf->Cell(6	, 0, "Occupation",0,0,L);

$pdf->Ln(0.4);
$pdf->SetFont('arial','BU',8);
$pdf->Cell(19	, 0, "Data Saudara Kandung",0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell(19	, 0, "Data of Siblings",0,0,L);
$pdf->Ln(0.3);	
$pdf->SetFont('arial','',8);
$pdf->Cell( 0.8	,0.6, "No",LRTB,0,C); 
$pdf->Cell( 6.2	,0.4, "Nama Anak",LRT,0,C); 
$pdf->Cell( 5	,0.4, "Tempat/Tanggal Lahir",LRT,0,C); 
$pdf->Cell( 3	,0.4, "Pendidikan Terakhir",LRT,0,C); 
$pdf->Cell( 4	,0.4, "Nama Sekolah / Instansi",LRT,0,C); 
$pdf->Ln(0.3);	
$pdf->SetFont('arial','I',6);
$pdf->Cell( 0.8	,0.3); 
$pdf->Cell( 6.2	,0.3, "Name",LRB,0,C); 
$pdf->Cell( 5	,0.3, "Place/Date of Birth",LRB,0,C); 
$pdf->Cell( 3	,0.3, "Education",LRB,0,C); 
$pdf->Cell( 4	,0.3, "Name of School / Institution",LRB,0,C); 
$pdf->SetFont('arial','',6);
$query 		="	SELECT 	*
				FROM 	t_sdrssw
				WHERE 	t_sdrssw.nis='". mysql_escape_string($nis)."'";
$result 	=mysql_query($query) or die('Query gagal');

$j=0;
$no=1;
while($data = mysql_fetch_array($result))
{
	$pdf->Ln(0.3);	
	$pdf->Cell( 0.8	,0.3, $no,LR,0,C); 
	$pdf->Cell( 6.2	,0.3, $data[nmasdr],LR,0,L); 
	$pdf->Cell( 5	,0.3, $data[tmplhr].', '.$data[tgllhr],LR,0,L); 
	$pdf->Cell( 3	,0.3, $data[pndsdr],LR,0,C); 
	$pdf->Cell( 4	,0.3, $data[sklsdr],LR,0,C); 
	$j++;
	$no++;
}
$pdf->Ln();
$pdf->Cell( 19,0,'',1); 

while($j<10)
{
	$pdf->Ln(0.3);	
	$j++;
}
$pdf->Ln(0.5);
$pdf->SetFont('arial','B',8);
$pdf->Cell( 10,0); 
//$pdf->Cell(  9,0, $kota2_pt.', '.date('d',$tgl).' '.date('F',$tgl).' '.date('Y',$tgl),'',0,C); 
$pdf->Cell(  9,0.6, "Jakarta".', '.$tgl,'',0,C); 
$pdf->Ln(1.3);
$pdf->SetFont('arial','BU',8);
$pdf->Cell( 10,0.6); 
$pdf->Cell(  9,0.6,'( '.$nmassw.' )','',0,C); 
$pdf->Ln(0.3);
$pdf->SetFont('arial','',6);
$pdf->Cell( 10,0.6); 
$pdf->Cell(  9,0.6,'Nama Calon Siswa','',0,C); 
$pdf->Ln(0.2);
$pdf->SetFont('arial','I',6);
$pdf->Cell( 10,0.6); 
$pdf->Cell(  9,0.6,'Name of the Applicant','',0,C); 
$pdf->Ln(0.5);
$pdf->SetFont('Arial','',6);
$pdf->Cell( 19,0,'',1); 
$pdf->Ln(0.2);
$pdf->Cell(5	,0,'FORM : T1D01_C01 (TATAUSAHA)');
$pdf->Cell(14	,0,$kdeusr.' '.$tgl.' '.$jam.' Page : 1 of 1',0,0,R);	













	/*$qABS	="	SELECT 		t_hdrkmnps_sd.*
				FROM 		t_hdrkmnps_sd
				WHERE		t_hdrkmnps_sd.nis='$nis' "; // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	
	$qKMN=$dABS['kmn']; // q kmn

$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('arial','B',12);
//$pdf->Cell( 10,0.6); 
$pdf->Cell(  9,0.6,'Catatan Bimbingan Konseling : ','',0,L); 
$pdf->Ln();
$pdf->SetFont('arial','',12);
$pdf->Cell(  9,0.6,$qKMN,'',0,L); */
//menampilkan output berupa halaman PDF
$pdf->Output();
?>