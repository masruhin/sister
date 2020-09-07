<?php
//----------------------------------------------------------------------------------------------------
//Program		: L1D06_C02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: CETAK DAFTAR PENGAJARAN ( Per Pelajaran )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$kdepljB=$_POST['kdeplj'];

$judul='DAFTAR PENGAJARAN ( Per Pelajaran )';

$query 	="	SELECT 		t_mstpng.*,t_mstkry.*,t_mstplj.*
			FROM 		t_mstpng,t_mstkry,t_mstplj
			WHERE 		(t_mstpng.kdeplj ='$kdepljB'	or '$kdepljB'='')	AND
						t_mstpng.kdegru =t_mstkry.kdekry				AND
						t_mstpng.kdeplj =t_mstplj.kdeplj
			ORDER BY 	t_mstplj.nmaplj,t_mstkry.nmakry";
$result =mysql_query($query) or die('Query gagal');

$i=1;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[kdeplj];
	$cell[$i][1] 	=$data[nmaplj];
	$cell[$i][2] 	=$data[kdegru];
	$cell[$i][3] 	=$data[nmakry];
	$cell[$i][4] 	=$data[kdekls];
	$i++;
}
$logo	="../../images/logo.jpg";
$photo	="../../files/photo/siswa/$nis.jpg";

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
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(23	,0.4,"SAINT JOHN'S SCHOOL"); // $nama_pt
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell( 3	,0.4,"Tanggal :",0,0,R);
	$pdf->Cell( 2	,0.4,$tgl,0,0,L);
	$pdf->Ln();
	$pdf->Cell(23	,0.4,'JAKARTA - INDONESIA'); // $kota_pt
	$pdf->Cell( 3	,0.4,"jam :",0,0,R);
	$pdf->Cell( 2	,0.4,$jam,0,0,L);
	$pdf->Ln();
	$pdf->Cell(26	,0.4,"Hal :",0,0,R);
	$pdf->Cell( 2	,0.4,$Hlm,0,0,L);
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell(28	,0.4,$judul); 
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln();
	if($kdepljB!='')
	{
		$pdf->Cell( 2	,0.4,"Pelajaran",0,0,L); 
		$pdf->Cell(26	,0.4,': '.$cell[$j][1]); 
		$pdf->Ln();
	}
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell( 0.6	,0.5,'NO'			,'LRTB',0,C);
	$pdf->Cell( 4	,0.5,'PELAJARAN'	,'LRTB',0,C);
	$pdf->Cell( 4.4	,0.5,'GURU'			,'LRTB',0,C);
	$pdf->Cell(19	,0.5,'KELAS'		,'LRTB',0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','',6);
    $x=1;
	while ($x<=38 AND $j<$i)
	{
		$nmaplj=$cell[$j][1];
		$pdf->Cell( 0.6	,0.4,$No,'',0,C);
		$pdf->Cell( 4	,0.4,substr($nmaplj,0,30) );
		$kdeplj=$cell[$j][0];
		
		$a=0;
		while ($x<=38 AND $j<$i AND $kdeplj==$cell[$j][0])
		{
			if($a!=0)
			{
				$pdf->Cell( 0.6	,0.4);
				$pdf->Cell( 4	,0.4);
			}

			//menampilkan data dari hasil query database
			$pdf->Cell( 4.4	,0.4,$cell[$j][3]);
			$kdegru=$cell[$j][2];
			$kls='';
			while ($j<$i AND $kdeplj==$cell[$j][0] AND $kdegru==$cell[$j][2])
			{
				$kls=$kls.'   ('.$cell[$j][4].')';
				$j++;
			}

			$pdf->Cell(19	,0.4,$kls);
			$pdf->Ln();
			$x++;
			$a++;			
		}	
		$No++;
	}
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(28   ,0,'',1); 	
	$pdf->Ln();
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 5	,0.4,'FORM : L1D06_C02 (KURIKULUM)');
	if ($j<$i)
	{
		$Hlm=$Hlm+1;
		$pdf->Cell(23  	,0.4,"Bersambung ke hal : ".$Hlm,0,0,R);
		$pdf->Ln();
	}
}
//menampilkan output berupa Hlmaman PDF
$pdf->Output();
?>