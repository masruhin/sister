<?php
//----------------------------------------------------------------------------------------------------
//Program		: K5L03_Cetak.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: LAPORAN BUKU HARIAN
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$tgl1B	=$_POST['tgl1'];
$tgl2B	=$_POST['tgl2'];

if (empty($tgl1B))
{
	$prd 	=periode('KEUANGAN');
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

$query 	="	SELECT 		t_sldkng.sldawl
			FROM 		t_sldkng
			WHERE 		t_sldkng.prd='$prd'";
$result1=mysql_query($query) or die('Query gagal');

$query	="	SELECT 		t_btukng.nmrbtu,t_btukng.tglbtu,t_btukng.dr,t_btukng.nli
			FROM 		t_btukng
			WHERE 		t_btukng.tglbtu>='$tgl1B'						AND		
						t_btukng.tglbtu<='$tgl2B'						AND	
						substr(t_btukng.tglbtu,4,2)=substr('$prd',-2) 	AND
						substr(t_btukng.tglbtu,-2)=substr('$prd',1,2)	
			ORDER BY 	nmrbtu,tglbtu";
$result2=mysql_query($query) or die('Query gagal');
		
$query	="	SELECT 		sum(t_btukng.nli) as Msk
			FROM 		t_btukng
			WHERE 		t_btukng.tglbtu<'$tgl1B'						AND
						substr(t_btukng.tglbtu,4,2)=substr('$prd',-2) 	AND
						substr(t_btukng.tglbtu,-2)=substr('$prd',1,2)";
$result =mysql_query($query) or die (mysql_error());
$TMsk 	=mysql_fetch_array($result);
$TMsk 	=$TMsk['Msk'];

$query 	="	SELECT 		t_bkukng.nmrbku,t_bkukng.tglbku,t_bkukng.utk,t_bkukng.nli
			FROM 		t_bkukng
			WHERE 		t_bkukng.tglbku>='$tgl1B'						AND		
						t_bkukng.tglbku<='$tgl2B'  						AND	
						substr(t_bkukng.tglbku,4,2)=substr('$prd',-2) 	AND
						substr(t_bkukng.tglbku,-2)=substr('$prd',1,2)	
			ORDER BY 	nmrbku,tglbku";
$result3=mysql_query($query) or die('Query gagal');

$query	="	SELECT 		sum(t_bkukng.nli) as Klr
			FROM 		t_bkukng
			WHERE 		t_bkukng.tglbku<'$tgl1B'						AND
						substr(t_bkukng.tglbku,4,2)=substr('$prd',-2) 	AND
						substr(t_bkukng.tglbku,-2)=substr('$prd',1,2)";
$result =mysql_query($query) or die (mysql_error());
$TKlr 	=mysql_fetch_array($result);
$TKlr 	=$TKlr['Klr'];

$i=0;
while($data = mysql_fetch_array($result1))
{
	$cell[$i][0] 	=$tglA;
	$cell[$i][1] 	="A";
	$cell[$i][2] 	="";
	$cell[$i][3] 	="Saldo Awal";
	$cell[$i][4] 	=$data[sldawl];
	$i++;
}

while($data = mysql_fetch_array($result2))
{
	$cell[$i][0] 	=$data[tglbtu];
	$cell[$i][1] 	="B";
	$cell[$i][2] 	=$data[nmrbtu];
	$cell[$i][3] 	="Dari ".$data[dr];
	$cell[$i][4] 	=$data[nli];
	$i++;
}

while($data = mysql_fetch_array($result3))
{
	$cell[$i][0] 	=$data[tglbku];
	$cell[$i][1] 	="C";	
	$cell[$i][2] 	=$data[nmrbku];
	$cell[$i][3] 	="Untuk ".$data[utk];
	$cell[$i][4] 	=$data[nli];
	$i++;
}

if ($cell!='')
{
	foreach ($cell as $param => $row) 
	{
		$tgl[$param]  	=$row[0];
		$Jenis[$param] 	=$row[1];
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
	$Judul4	="LAPORAN BUKU HARIAN";

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
	$pdf->Cell(19	,0.4,$Judul4); 
	$pdf->SetFont('Arial','B',8);
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
		$tgl=$cell[$j][0];
		$Jns=$cell[$j][1];
		$nmr=$cell[$j][2];
		$Ktr=$cell[$j][3];
		$nli=$cell[$j][4];
		//menampilkan data dari hasil query database
		$pdf->Cell( 0.8	,0.4,$No	,0,0,R);
		$pdf->Cell( 1.7	,0.4,$tgl	,0,0,C);
		$pdf->Cell( 2.5	,0.4,$nmr	,0,0,C);
		$pdf->Cell( 4	,0.4,$Ktr	,0,0,L);
		
		if($Jns=="A")
		{
			$sldawl	=$nli+$TMsk-$TKlr;
			$Msk	=0;
			$Klr	=0;
			$TMsk	=0;
			$TKlr	=0;
			$SldAkh	=$sldawl;
			$Tsldawl=$sldawl;
		}
		if($Jns=="B")
		{	
			$sldawl	=0;
			$Msk	=$nli;
			$Klr	=0;
			$SldAkh	=$SldAkh+$Msk;
			$TMsk	=$TMsk+$Msk;
		}
		if($Jns=="C")
		{
			$sldawl	=0;
			$Msk	=0;
			$Klr	=$nli;
			$SldAkh	=$SldAkh-$Klr;
			$TKlr	=$TKlr+$Klr;
		}
		$pdf->Cell( 2.5	,0.4,number_format($sldawl)	,0,0,R);
		$pdf->Cell( 2.5	,0.4,number_format($Msk)	,0,0,R);
		$pdf->Cell( 2.5	,0.4,number_format($Klr)	,0,0,R);
		$pdf->Cell( 2.5	,0.4,number_format($SldAkh)	,0,0,R);
		$pdf->Ln();
		$No++;		
		$x++;
		$j++;
	}
	$pdf->Cell( 19   ,0,'',1); 	
	$pdf->Ln();
	if ($j>=$i)
	{
		$pdf->Cell( 9	,0.4,'TOTAL',0,0,L); 	
		$pdf->Cell( 2.5,0.4,number_format($Tsldawl)	,0,0,R); 	
		$pdf->Cell( 2.5,0.4,number_format($TMsk)	,0,0,R); 	
		$pdf->Cell( 2.5,0.4,number_format($TKlr)	,0,0,R); 	
		$pdf->Cell( 2.5,0.4,number_format($SldAkh)	,0,0,R); 	
		$pdf->Ln();
		$pdf->Cell(19   ,0,'',1); 	
		$pdf->Ln();
	}
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 5	,0.4,'FORM : K5L03 (KEUANGAN)');
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