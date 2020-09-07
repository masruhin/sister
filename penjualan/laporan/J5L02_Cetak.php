<?php
//----------------------------------------------------------------------------------------------------
//Program		: J5L02_Cetak.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: LAPORAN BUKTI KELUAR BARANG
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$kdebrnB=$_POST['kdebrn'];
$tgl1B	=$_POST['tgl1'];
$tgl2B	=$_POST['tgl2'];
$jnsklr	=$_POST['jnsklr'];

if (empty($tgl1B))
{
	$modul	="PENJUALAN";
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
$i=0;
if($jnsklr=='N' or $jnsklr=='')
{
	$query 		="	SELECT 		*
					FROM 		t_dtlbkb,t_gnrbkb,t_mstbrn
					WHERE		(t_dtlbkb.kdebrn 	='$kdebrnB' OR '$kdebrnB'='')	AND
								t_gnrbkb.tglbkb		>='$tgl1B'						AND		
								t_gnrbkb.tglbkb		<='$tgl2B'						AND	
								substr(t_gnrbkb.tglbkb,4,2)=substr('$prd',-2) 		AND
								substr(t_gnrbkb.tglbkb,-2)=substr('$prd',1,2)		AND
								t_dtlbkb.nmrbkb=t_gnrbkb.nmrbkb						AND
								t_dtlbkb.kdebrn=t_mstbrn.kdebrn
					ORDER BY 	t_dtlbkb.kdebrn,t_gnrbkb.tglbkb";

	$db_query 	= mysql_query($query) or die('Query gagal');

	while($data = mysql_fetch_array($db_query))
	{
		$cell[$i][0] 	=$data[kdebrn];
		$cell[$i][1] 	=$data[nmabrn];
		$cell[$i][2] 	=$data[nmrbkb];
		$cell[$i][3] 	=$data[tglbkb];
		$cell[$i][4] 	=$data[utk];
		$cell[$i][5] 	=$data[bny];
		$i++;
	}
}

if($jnsklr=='P' or $jnsklr=='')
{
	$query 		="	SELECT 			*
					FROM 			t_dtlpnj,t_gnrpnj,t_mstbrn
					WHERE			(t_dtlpnj.kdebrn 	='$kdebrnB' OR '$kdebrnB'='')	AND
									t_gnrpnj.tglpnj		>='$tgl1B'						AND		
									t_gnrpnj.tglpnj		<='$tgl2B'						AND	
									substr(t_gnrpnj.tglpnj,4,2)=substr('$prd',-2) 		AND
									substr(t_gnrpnj.tglpnj,-2)=substr('$prd',1,2)		AND
									t_dtlpnj.nmrpnj=t_gnrpnj.nmrpnj						AND
									t_dtlpnj.kdebrn=t_mstbrn.kdebrn
					ORDER BY 		t_dtlpnj.kdebrn,t_gnrpnj.tglpnj";

	$db_query 	= mysql_query($query) or die('Query gagal');

	while($data = mysql_fetch_array($db_query))
	{
		$cell[$i][0] 	=$data[kdebrn];
		$cell[$i][1] 	=$data[nmabrn];
		$cell[$i][2] 	=$data[nmrpnj];
		$cell[$i][3] 	=$data[tglpnj];
		$cell[$i][4] 	=$data[utk];
		$cell[$i][5] 	=$data[bny];
		$i++;
	}
}

if ($cell!='')
{
	foreach ($cell as $param => $row) 
	{
		$kdebrn[$param] 	=$row[0];
		$tgl[$param]  		=$row[3];
	}
	array_multisort($kdebrn, SORT_ASC, $tgl, SORT_ASC, $cell);
}

$pdf = new FPDF('P','cm','A4');

$j	=0;
$Hlm=1;
$No	=1;
while ($j<$i)
{
	$tgl 	=date("d-m-Y");
	$jam	=date("h:i:s");
	$judul	="LAPORAN BUKTI KELUAR BARANG";

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
	if ($kdebrnB!='')
	{
		$pdf->Cell( 2.2	,0.4,"Kode Barang",0,0,L); 
		$pdf->Cell(16.9	,0.4," : ".$cell[$j][0].' - '.$cell[$j][1]); 
		$pdf->Ln();
	}	
	if($jnsklr=='N')
	{
		$pdf->Cell( 2.2	,0.4,"Jenis"	,0,0,L);
		$pdf->Cell(16.9	,0.4," : NON PENJUALAN"); 
		$pdf->Ln();
	}
	if($jnsklr=='P')
	{
		$pdf->Cell( 2.2	,0.4,"Jenis"	,0,0,L);
		$pdf->Cell(16.9	,0.4," : PENJUALAN"); 
		$pdf->Ln();
	}
	$pdf->Cell( 2.2	,0.4,"Dari Tanggal"	,0,0,L); 		
	$pdf->Cell( 2	,0.4,' : '.$tgl1B); 
	$pdf->Cell( 2.4	,0.4,"Sampai Tanggal"	,0,0,L); 		
	$pdf->Cell(12.5	,0.4,' : '.$tgl2B); 
	$pdf->Ln();
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell( 0.8	,0.4,'NO'			,'LRTB',0,C);
	$pdf->Cell( 6	,0.4,'BARANG'		,'LRTB',0,C);	
	$pdf->Cell( 2.2	,0.4,'NO. BUKTI'	,'LRTB',0,C);
	$pdf->Cell( 1.5	,0.4,'TANGGAL'		,'LRTB',0,C);
	$pdf->Cell( 6	,0.4,'UNTUK'		,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'BANYAK'		,'LRTB',0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
    $x=1;
	while ($x<=60 AND $j<$i)
	{
		//menampilkan data dari hasil query database
		$pdf->Cell( 0.8	,0.4,$No,0,0,R);
		$kdebrn=$cell[$j][0];
		$pdf->Cell( 6	,0.4,$cell[$j][0].' - '.$cell[$j][1]);
		$a=0;
		while ($x<=60 AND $j<$i AND $kdebrn==$cell[$j][0])
		{
			if($a!=0)
			{
				$pdf->Cell( 0.8	,0.4);
				$pdf->Cell( 6	,0.4);
			}
			$nmrbkb	=$cell[$j][2];
			$tglbkb	=$cell[$j][3];
			$utk	=$cell[$j][4];
			$rfr	=$cell[$j][5];
			$bny	=$cell[$j][5];
			$Tbny	=$Tbny+$bny;

			$pdf->Cell( 2.2	,0.4,$nmrbkb);
			$pdf->Cell( 1.5	,0.4,$tglbkb);
			$pdf->Cell( 6	,0.4,$utk);
			$pdf->Cell( 2.5	,0.4,number_format($bny),0,0,R);
			$pdf->Ln();
			$x++;
			$j++;
			$a++;
		}
		if($kdebrn!=$cell[$j][0])
		{
			$pdf->Cell( 2.5	,0.4);
			$pdf->Cell(16.5 ,0,'',1); 	
			$pdf->Ln();		
			$pdf->Cell( 2.5	,0.4);
			$pdf->Cell(14	,0.4,'TOTAL PER BARANG',0,0,L); 	
			$pdf->Cell( 2.5	,0.4,number_format($Tbny),0,0,R);
			$pdf->Ln();
			$pdf->Cell(19   ,0,'',1); 	
			$pdf->Ln();
			$No++;		
			$Tbny=0;
		}	
	}
	$pdf->Cell(19   ,0,'',1); 	
	$pdf->Ln();
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 5	,0.4,'FORM : J5L02 (PENJUALAN)');
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