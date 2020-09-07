<?php
//----------------------------------------------------------------------------------------------------
//Program		: J5L04_Cetak.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: LAPORAN KARTU STOCK 
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$kdebrnB=$_POST['kdebrn'];
$tgl1B	=$_POST['tgl1'];
$tgl2B	=$_POST['tgl2'];

if (empty($tgl1B))
{
	$modul	='PENJUALAN';
	$prd 	=periode($modul);
	$tgl1B	=substr($prd,0,2).'-'.substr($prd,2,2).'-'.'01';
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

$query 		="	SELECT 		t_sldbrn.kdebrn,t_mstbrn.nmabrn,t_sldbrn.sldawl
				FROM 		t_sldbrn,t_mstbrn
				WHERE 		t_sldbrn.prd	='$prd'		AND
							t_sldbrn.kdebrn ='$kdebrnB'	AND
							t_sldbrn.kdebrn	=t_mstbrn.kdebrn";
$db_query1 	=mysql_query($query) or die('Query gagal');

$query		="	SELECT 		*,t_mstbrn.nmabrn,t_gnrbmb.tglbmb,t_gnrbmb.dr,t_dtlbmb.bny
				FROM 		t_dtlbmb,t_gnrbmb,t_mstbrn
				WHERE 		t_dtlbmb.kdebrn ='$kdebrnB'						AND
							t_gnrbmb.tglbmb>='$tgl1B'						AND		
							t_gnrbmb.tglbmb<='$tgl2B'						AND	
							substr(t_gnrbmb.tglbmb,4,2)	=substr('$prd',-2) 	AND
							substr(t_gnrbmb.tglbmb,-2)	=substr('$prd',1,2) AND
							t_dtlbmb.nmrbmb	=t_gnrbmb.nmrbmb				AND
							t_dtlbmb.kdebrn =t_mstbrn.kdebrn  
				ORDER BY 	t_dtlbmb.kdebrn,t_gnrbmb.tglbmb";
$db_query2 	=mysql_query($query) or die('Query gagal');
		
$query		="	SELECT 		sum(t_dtlbmb.bny) as msk
				FROM 		t_dtlbmb,t_gnrbmb
				WHERE 		t_dtlbmb.kdebrn ='$kdebrnB'						AND
							t_gnrbmb.tglbmb<'$tgl1B'						AND
							substr(t_gnrbmb.tglbmb,4,2)	=substr('$prd',-2) 	AND
							substr(t_gnrbmb.tglbmb,-2)	=substr('$prd',1,2)	AND
							t_dtlbmb.nmrbmb	=t_gnrbmb.nmrbmb";
$result 	=mysql_query($query) or die (mysql_error());
$tmsk 		=mysql_fetch_array($result);
$tmsk 		=$tmsk['msk'];

$query		="	SELECT 		*,t_mstbrn.nmabrn,t_gnrbkb.tglbkb,t_gnrbkb.utk,t_dtlbkb.bny
				FROM 		t_dtlbkb,t_gnrbkb,t_mstbrn
				WHERE 		t_dtlbkb.kdebrn ='$kdebrnB'						AND
							t_gnrbkb.tglbkb>='$tgl1B'						AND		
							t_gnrbkb.tglbkb<='$tgl2B'						AND	
							substr(t_gnrbkb.tglbkb,4,2)	=substr('$prd',-2) 	AND
							substr(t_gnrbkb.tglbkb,-2)	=substr('$prd',1,2) AND
							t_dtlbkb.nmrbkb =t_gnrbkb.nmrbkb				AND
							t_dtlbkb.kdebrn =t_mstbrn.kdebrn
				ORDER BY 	t_dtlbkb.kdebrn,t_gnrbkb.tglbkb";
$db_query3 	=mysql_query($query) or die('Query gagal');

$query		="	SELECT 		sum(t_dtlbkb.bny) as klr
				FROM 		t_dtlbkb,t_gnrbkb
				WHERE 		t_dtlbkb.kdebrn ='$kdebrnB'						AND
							t_gnrbkb.tglbkb<'$tgl1B'						AND
							substr(t_gnrbkb.tglbkb,4,2)=substr('$prd',-2) 	AND
							substr(t_gnrbkb.tglbkb,-2)=substr('$prd',1,2)	AND
							t_dtlbkb.nmrbkb =t_gnrbkb.nmrbkb";
$result 	=mysql_query($query) or die (mysql_error());
$tklr 		=mysql_fetch_array($result);
$tklr 		=$tklr['klr'];

$query		="	SELECT 		*,t_mstbrn.nmabrn,t_gnrpnj.tglpnj,t_gnrpnj.utk,t_dtlpnj.bny
				FROM 		t_dtlpnj,t_gnrpnj,t_mstbrn
				WHERE 		t_dtlpnj.kdebrn ='$kdebrnB'						AND
							t_gnrpnj.tglpnj>='$tgl1B'						AND		
							t_gnrpnj.tglpnj<='$tgl2B'						AND	
							substr(t_gnrpnj.tglpnj,4,2)	=substr('$prd',-2) 	AND
							substr(t_gnrpnj.tglpnj,-2)	=substr('$prd',1,2) AND
							t_dtlpnj.nmrpnj =t_gnrpnj.nmrpnj				AND
							t_dtlpnj.kdebrn =t_mstbrn.kdebrn
				ORDER BY 	t_dtlpnj.kdebrn,t_gnrpnj.tglpnj";
$db_query4 	=mysql_query($query) or die('Query gagal');

$query		="	SELECT 		sum(t_dtlpnj.bny) as klr
				FROM 		t_dtlpnj,t_gnrpnj
				WHERE 		t_dtlpnj.kdebrn ='$kdebrnB'						AND
							t_gnrpnj.tglpnj<'$tgl1B'						AND
							substr(t_gnrpnj.tglpnj,4,2)=substr('$prd',-2) 	AND
							substr(t_gnrpnj.tglpnj,-2)=substr('$prd',1,2)	AND
							t_dtlpnj.nmrpnj =t_gnrpnj.nmrpnj";
$result 	=mysql_query($query) or die (mysql_error());
$tklr2 		=mysql_fetch_array($result);
$tklr 		=$tklr+$tklr2['klr'];

$i=0;
while($data = mysql_fetch_array($db_query1))
{
	$cell[$i][0] 	=$data[kdebrn];
	$cell[$i][1] 	=$data[nmabrn];
	$cell[$i][2] 	=$tglA;
	$cell[$i][3] 	="A";
	$cell[$i][4] 	="";
	$cell[$i][5] 	="Saldo Awal";
	$cell[$i][6] 	=$data[sldawl];
	$i++;
}

while($data = mysql_fetch_array($db_query2))
{
	$cell[$i][0] 	=$data[kdebrn];
	$cell[$i][1] 	=$data[nmabrn];
	$cell[$i][2] 	=$data[tglbmb];
	$cell[$i][3] 	="B";
	$cell[$i][4] 	=$data[nmrbmb];
	$cell[$i][5] 	=" Dari ".$data[dr];
	$cell[$i][6] 	=$data[bny];
	$i++;
}

while($data = mysql_fetch_array($db_query3))
{
	$cell[$i][0] 	=$data[kdebrn];
	$cell[$i][1] 	=$data[nmabrn];
	$cell[$i][2] 	=$data[tglbkb];
	$cell[$i][3] 	="C";	
	$cell[$i][4] 	=$data[nmrbkb];
	$cell[$i][5] 	=" Untuk ".$data[utk];
	$cell[$i][6] 	=$data[bny];
	$i++;
}

while($data = mysql_fetch_array($db_query4))
{
	$cell[$i][0] 	=$data[kdebrn];
	$cell[$i][1] 	=$data[nmabrn];
	$cell[$i][2] 	=$data[tglpnj];
	$cell[$i][3] 	="C";	
	$cell[$i][4] 	=$data[nmrpnj];
	$cell[$i][5] 	=" Untuk ".$data[utk];
	$cell[$i][6] 	=$data[bny];
	$i++;
}

if ($cell!='')
{
	foreach ($cell as $param => $row) 
	{
		$tgl[$param]  	=$row[2];
		$Jenis[$param] 	=$row[3];
	}
	array_multisort($tgl, SORT_ASC, $Jenis, SORT_ASC, $cell);
}	

$pdf = new FPDF('P','cm','A4');

$j		=0;
$Hlm	=1;
$No		=1;
while ($j<$i)
{
	$tgl 	=date("d-m-Y");
	$jam	=date("h:i:s");
	$judul	="LAPORAN KARTU STOCK";
	$kdebrn	=$cell[$j][0];
	$nmabrn	=$cell[$j][1];

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
	$pdf->Cell( 2.1	,0.4,"Kode Barang :",0,0,L); 
	$pdf->Cell(16.9	,0.4,' : '.$kdebrn.' - '.$nmabrn); 
	$pdf->Ln();
	$pdf->Cell( 2.1	,0.4,"Dari Tanggal",0,0,L); 		
	$pdf->Cell( 2	,0.4,' : '.$tgl1B); 
	$pdf->Cell( 2.4	,0.4,"Sampai Tanggal",0,0,L); 		
	$pdf->Cell(12.5	,0.4,' : '.$tgl2B); 
	$pdf->Ln();
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell( 0.8	,0.4,'NO'			,'LRTB',0,C);
	$pdf->Cell( 1.7	,0.4,'TANGGAL'		,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'NOMOR BUKTI'	,'LRTB',0,C);
	$pdf->Cell( 4	,0.4,'KETERANGAN'	,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'SALDO AWAL'	,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'MASUK'		,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'KELUAR'		,'LRTB',0,C);
	$pdf->Cell( 2.5	,0.4,'SALDO AKHIR'	,'LRTB',0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
    $x=1;
	while ($x<=60 AND $j<$i)
	{
		$tgl=$cell[$j][2];
		$jns=$cell[$j][3];
		$nmr=$cell[$j][4];
		$ktr=$cell[$j][5];
		$bny=$cell[$j][6];
		//menampilkan data dari hasil query database
		$pdf->Cell( 0.8	,0.4,$No	,0,0,R);
		$pdf->Cell( 1.7	,0.4,$tgl	,0,0,C);
		$pdf->Cell( 2.5	,0.4,$nmr	,0,0,C);
		$pdf->Cell( 4	,0.4,$ktr	,0,0,L);
		
		if($jns=="A")
		{
			$sldawl	=$bny+$tmsk-$tklr;
			$msk	=0;
			$klr	=0;
			$tmsk	=0;
			$tklr	=0;
			$sldakh	=$sldawl;
			$Tsldawl=$sldawl;
		}
		if($jns=="B")
		{	
			$sldawl	=0;
			$msk	=$bny;
			$klr	=0;
			$sldakh	=$sldakh+$msk;
			$tmsk	=$tmsk+$msk;
		}
		if($jns=="C")
		{
			$sldawl	=0;
			$msk	=0;
			$klr	=$bny;
			$sldakh	=$sldakh-$klr;
			$tklr	=$tklr+$klr;
		}
		$pdf->Cell( 2.5	,0.4,number_format($sldawl)	,0,0,R);
		$pdf->Cell( 2.5	,0.4,number_format($msk)	,0,0,R);
		$pdf->Cell( 2.5	,0.4,number_format($klr)	,0,0,R);
		$pdf->Cell( 2.5	,0.4,number_format($sldakh)	,0,0,R);
		$pdf->Ln();
		$No++;		
		$x++;
		$j++;
	}
	$pdf->Cell(19   ,0,'',1); 	
	$pdf->Ln();
	if ($j>=$i)
	{
		$pdf->Cell( 9	,0.4,'TOTAL',0,0,L); 	
		$pdf->Cell( 2.5	,0.4,number_format($Tsldawl),0,0,R); 	
		$pdf->Cell( 2.5	,0.4,number_format($tmsk)	,0,0,R); 	
		$pdf->Cell( 2.5	,0.4,number_format($tklr)	,0,0,R); 	
		$pdf->Cell( 2.5	,0.4,number_format($sldakh)	,0,0,R); 	
		$pdf->Ln();
		$pdf->Cell(19   ,0,'',1); 	
		$pdf->Ln();
	}
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 5	,0.4,'FORM : J5L04 (PENJUALAN)');
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