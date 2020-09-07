<?php
//----------------------------------------------------------------------------------------------------
//Program		: K5L04_Cetak.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: LAPORAN TUNGGAKAN
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$kdekls	=$_POST['kdekls'];
$kdejtu	=$_POST['kdejtu'];

$query	="	SELECT 		t_jtu.*
			FROM 		t_jtu
			WHERE 		t_jtu.kdejtu	='". mysql_escape_string($kdejtu)."'";
$result	=mysql_query($query) or die (mysql_error());
$data 	=mysql_fetch_array($result);

$nmajtu	=$data[nmajtu];

$query	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		(t_mstssw.kdekls	='". mysql_escape_string($kdekls)."'	OR '$kdekls'='')	
			ORDER BY 	t_mstssw.kdekls,t_mstssw.nis";
$result	=mysql_query($query) or die (mysql_error());

$i=1;
while($data =mysql_fetch_array($result))
{
	$nis   	=$data[nis];
	$nmassw	=$data[nmassw];
	$kls	=$data[kls];
	$queryy ="	SELECT 				t_btukng.*
				FROM 				t_btukng
				WHERE 				t_btukng.nis	='$nis'		AND
									t_btukng.kdejtu	='$kdejtu'";
	$resulty=mysql_query($queryy)	or die (mysql_error());
	$datay 	=mysql_fetch_array($resulty);
	if($datay==0)
	{
		$cell[$i][0] 	=$data[kdekls];
		$cell[$i][1] 	=$data[nis];
		$cell[$i][2] 	=$data[nmassw];
		$i++;
	}	
}

$pdf = new FPDF('P','cm','A4');

$j	=1;
$Hlm=1;
$No	=1;
while ($j<$i)
{
	$tgl 	=date("d-m-Y");
	$jam	=date("h:i:s");
	$judul	="LAPORAN TUNGGAKAN";

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
	if ($kdekls!='')
	{
		$pdf->Cell( 2.4	,0.4,"Kelas",0,0,L);
		$pdf->Cell( 2	,0.4,' : '.$kdekls); 
		$pdf->Ln();
	}	
	if ($kdejtu!='')
	{
		$pdf->Cell( 2.4	,0.4,"Jenis Tunggakan",0,0,L); 
		$pdf->Cell(16.6	,0.4," : ".$nmajtu);
		$pdf->Ln();
	}	
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell( 0.8	,0.4,'NO'			,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'KELAS'		,'LRTB',0,C);
	$pdf->Cell( 1.7	,0.4,'NIS'			,'LRTB',0,C);
	$pdf->Cell(14	,0.4,'NAMA'			,'LRTB',0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
    $x=1;
	while ($x<=60 AND $j<$i)
	{
		$kls	=$cell[$j][0];
		$nis	=$cell[$j][1];
		$nmassw	=$cell[$j][2];
		//menampilkan data dari hasil query database
		$pdf->Cell( 0.8	,0.4,$No				,0,0,R);
		$pdf->Cell( 2.5	,0.4,$kls				,0,0,C);
		$pdf->Cell( 1.7	,0.4,$nis				,0,0,C);
		$pdf->Cell(14	,0.4,$nmassw			,0,0,L);
		$pdf->Ln();
		$No++;		
		$x++;
		$j++;
	}
	$pdf->Cell(19   ,0,'',1); 	
	$pdf->Ln();
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 5	,0.4,'FORM : K5L04 (KEUANGAN)');
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