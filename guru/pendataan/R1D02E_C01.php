<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D02E_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: STATISTIK
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$query ="	SELECT 		g_dtlmtr.*,g_gnrmtr.*,t_mstplj.*,t_mstkry.*,t_klmkls.*
			FROM 		g_dtlmtr,g_gnrmtr,t_mstplj,t_mstkry,t_klmkls
			WHERE 		g_dtlmtr.kdemtr=g_gnrmtr.kdemtr AND
						g_dtlmtr.kdegru=t_mstkry.kdekry AND
						g_gnrmtr.kdeplj=t_mstplj.kdeplj AND
						g_gnrmtr.kdeklm=t_klmkls.kdeklm
			ORDER BY 	t_mstkry.nmakry,g_gnrmtr.kdeklm,t_mstplj.nmaplj";
$result =mysql_query($query);

$i=0;
while($data =mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[kdegru];
	$cell[$i][1] 	=$data[nmakry];
	$cell[$i][2] 	=$data[kdeplj];
	$cell[$i][3] 	=$data[nmaplj];
	$cell[$i][4] 	=$data[kdeklm];
	$cell[$i][5] 	=$data[nmaklm];
	$i++;
}
$j=0;
$z=0;
while($j<$i)
{
	$kdegru			=$cell[$j][0];
	$nmakry			=$cell[$j][1];
	while($kdegru==$cell[$j][0] AND $j<$i)
	{
		$kdeplj			=$cell[$j][2];
		$nmaplj			=$cell[$j][3];
		while($kdegru==$cell[$j][0] AND $kdeplj==$cell[$j][2] AND $j<$i)
		{
			$kdeklm=$cell[$j][4];
			$nmaklm=$cell[$j][5];
			$x=0;
			while($kdegru==$cell[$j][0] AND $kdeplj==$cell[$j][2] AND $kdeklm==$cell[$j][4] AND $j<$i)
			{
				$x++;
				$j++;
			}
			$cell2[$z][0]	=$kdegru;
			$cell2[$z][1]	=$nmakry;
			$cell2[$z][2]	=$kdeplj;
			$cell2[$z][3]	=$nmaplj;
			$cell2[$z][4]	=$kdeklm;			
			$cell2[$z][5]	=$nmaklm;
			$cell2[$z][6]	=$x;
			$z++;
		}	
	}	
}

$pdf = new FPDF('P','cm','A4');

$j	=0;
$hlm=1;
$No	=1;
while ($j<$z)
{
	$tgl 	=date("d-m-Y");
	$jam	=date("h:i:s");
	$judul	="STATISTIC";

	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(14	,0.4,"SAINT JOHN'S SCHOOL");//$nama_pt
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell( 3	,0.4,"Tanggal :",0,0,R);
	$pdf->Cell( 2	,0.4,$tgl,0,0,L);
	$pdf->Ln();
	$pdf->Cell(14	,0.4,"JAKARTA - INDONESIA");//$kota_pt
	$pdf->Cell( 3	,0.4,"jam :",0,0,R);
	$pdf->Cell( 2	,0.4,$jam,0,0,L);
	$pdf->Ln();
	$pdf->Cell(17	,0.4,"Hal :",0,0,R);
	$pdf->Cell( 2	,0.4,$hlm,0,0,L);
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell(19	,0.4,$judul); 
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell( 0.8	,0.4,'NO',		'TB',0,C);
	$pdf->Cell( 1.2	,0.4,'CODE',	'TB',0,C);	
	$pdf->Cell( 8	,0.4,'NAME'	,	'TB',0,C);
	$pdf->Cell( 3.5	,0.4,'SUBJECT',	'TB',0,C);
	$pdf->Cell( 2.5	,0.4,'CLASS',	'TB',0,C);
	$pdf->Cell( 1.5	,0.4,'MATERIAL','TB',0,C);
	$pdf->Cell( 1.5	,0.4,'WORKSHEET',	'TB',0,C);//TASK
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
    $x=1;
	while ($x<=60 AND $j<$z)
	{
		//menampilkan data dari hasil query database
		$pdf->Cell( 0.8	,0.4,$No,0,0,R);
		$kdegru=$cell2[$j][0];
		$nmagru=$cell2[$j][1];
		$pdf->Cell( 1.2	,0.4,$kdegru);
		$pdf->Cell( 8	,0.4,$nmagru);
		$a=0;
		while ($x<=60 AND $j<$z AND $kdegru==$cell2[$j][0])
		{
			if($a!=0)
			{
				$pdf->Cell( 0.8	,0.4);
				$pdf->Cell( 9.2	,0.4);
			}
			$kdeplj	=$cell2[$j][2];
			$nmaplj	=$cell2[$j][3];

			$pdf->Cell( 3.5	,0.4,$nmaplj);

			$b=0;
			while ($x<=60 AND $j<$z AND $kdegru==$cell2[$j][0] AND $kdeplj==$cell2[$j][2])
			{
				if($b!=0)
				{
					$pdf->Cell( 0.8	,0.4);
					$pdf->Cell( 9.2	,0.4);
					$pdf->Cell( 3.5	,0.4);
				}
			
				$kdeklm	=$cell2[$j][4];
				$nmaklm	=$cell2[$j][5];
				$mtr	=$cell2[$j][6];
				$pdf->Cell( 2.5	,0.4,$nmaklm,	'',0,C);
				$pdf->Cell( 1.5	,0.4,$mtr,		'',0,C);
				$pdf->Ln();
				$x++;
				$j++;
				$b++;
			}	
			$a++;
		}
		if($kdegru!=$cell2[$j][0])
		{
			$No++;		
		}		
	}
	$pdf->Cell(19   ,0,'',1); 	
	$pdf->Ln();
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 5	,0.4,'FORM : R1D02E');
	if ($j<$z)
	{
		$hlm=$hlm+1;
		$pdf->Cell(14  	,0.4,"Bersambung ke hal : ".$hlm,0,0,R);
		$pdf->Ln();
	}
}
//menampilkan output berupa halaman PDF
$pdf->Output();
?>