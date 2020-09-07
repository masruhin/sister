<?php
session_start();
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$username	=$_SESSION['username'];
$tgl 		=date('d-m-Y');
$jam		=date('H:i:s');

//- Pengaturan data yang akan dicetak --------------------------------------------------------------
$judul	='ALL BORROWING NOT YET PAID';
$tgl1	=$_POST['tgl1'];
$tgl2	=$_POST['tgl2'];
$tgl3 	=date("Y-m-d",strtotime($tgl1));
$tgl4 	=date("Y-m-d",strtotime($tgl2));

if(empty($tgl1))	{$prd 	=tgltoprd(date('d-m-Y'));$tgl1=bod($prd);}
else				$prd	=tgltoprd($tgl1);
//if(empty($tgl2) or strtotime($tgl2)<strtotime($tgl1) or date('m',strtotime($tgl2))!=date('m',strtotime($tgl1)))	$tgl2=eod($prd);
if(empty($tgl2) or strtotime($tgl2)<strtotime($tgl1))	$tgl2=eod($prd);
else	$prd2	=tgltoprd($tgl2);

//$tglkmb	=$tgl1;
//$jml	=selisihtgl($tgl2,$tgl1);

$qry 	=mysql_query("select t_setprp.* from t_setprp");
$dta	=mysql_fetch_array($qry);
$bts	=$dta['bts'];
$dnd	=$dta['dnd'];

$i=0;
$j=0;
//while($j<$jml)
//{
	$qry 	=mysql_query("	select 		t_dtlpjm.*,t_gnrpjm.*,t_mstbku.*
							from 		t_dtlpjm,t_gnrpjm,t_mstbku
							where 		(cast(concat(substring(t_dtlpjm.tglkmb,-4),'-',substring(t_dtlpjm.tglkmb,4,2),'-',substring(t_dtlpjm.tglkmb,1,2)) as date) between '$tgl3' and '$tgl4') and
										substr(t_gnrpjm.tglpjm,4,2)>=substr('$prd',-2) 	and 
										substr(t_gnrpjm.tglpjm,4,2)<=substr('$prd2',-2) and
										substr(t_gnrpjm.tglpjm,-2)=substr('$prd',1,2)	and
										t_dtlpjm.nmrpjm=t_gnrpjm.nmrpjm and
										t_dtlpjm.kdebku=t_mstbku.kdebku and
										t_dtlpjm.dnd>0					and
										t_gnrpjm.str!=''
							order by	t_gnrpjm.kdeang,t_gnrpjm.nmrpjm,t_mstbku.jdl");

	while($dta=mysql_fetch_array($qry))
	{
		$cll[$i][0]	=$dta['nmrpjm'];
		$cll[$i][1]	=$dta['tglpjm'];
		$tglpjm		=$dta['tglpjm']; // tambah buatan
		$cll[$i][2]	=$dta['kdeang'];
		$kdeang		=$dta['kdeang'];
		if($dta['stt']=='S')
		{
			$qry2 		=mysql_query('select t_mstssw.* from t_mstssw where t_mstssw.nis="'. mysql_escape_string($kdeang).'"');
			$dta2		=mysql_fetch_array($qry2);
			$cll[$i][3]	=$dta2['nmassw'];
		}	
		else	
		{
			$qry2 		=mysql_query('select t_mstkry.* from t_mstkry where t_mstkry.kdekry="'. mysql_escape_string($kdeang).'"');
			$dta2		=mysql_fetch_array($qry2);
			$cll[$i][3]	=$dta2['nmakry'];
		}
		$cll[$i][4]	=$dta['kdebku'];
		$cll[$i][5]	=$dta['jdl'];
		
		
		
		// awal buatan
		$query1 = mysql_query("SELECT * FROM t_setprp");
		$result1 = mysql_fetch_array($query1);
		$setprp  = $result1['nli'];
		
		$tglpjm = date('d-m-Y',strtotime("+$setprp day",strtotime($tglpjm)));
		// akhir buatan
		
		
		
		$jdwkmb		=date('Y-m-d',strtotime($tglpjm)); // $jdwkmb		=date('Y-m-d',strtotime($cll[$i][1]));
		//$jdwkmb		=adddate($jdwkmb,$bts." day");
		$jdwkmb		=date('d',strtotime($jdwkmb)).'-'.date('m',strtotime($jdwkmb)).'-'.date('Y',strtotime($jdwkmb));

		$cll[$i][6]	=$jdwkmb;
		$cll[$i][7]	=$dta['tglkmb'];
		$cll[$i][8]	=$dta['dnd'];
		$i++;
	}	
	$tglkmb=date('Y-m-d',strtotime($tglkmb));
	//$tglkmb=adddate($tglkmb,"+1 day");
	$tglkmb=date('d',strtotime($tglkmb)).'-'.date('m',strtotime($tglkmb)).'-'.date('Y',strtotime($tglkmb));
	$j++;
//}
//--------------------------------------------------------------------------------------------------

//- Seting kertas landscape A4, margin (standar) -----------------------------------------------------
$pdf 	=new FPDF('L','cm','A4');
$pdf->setMargins(1,0);
$pdf->SetAutoPageBreak(True, 0);
//--------------------------------------------------------------------------------------------------

$j	=0;
$hlm=1;
$no	=1;
$gttl=0;
while($j<$i)
{
	//- Cetak Judul tanpa logo (standar) -----------------------------------------------------------
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Ln(0.7);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(25	,0.4,"SAINT JOHN'S SCHOOL"); // $nama_pt
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell( 4	,0.4,'Date : '.$tgl,0,0,L);
	$pdf->Ln();
	$pdf->Cell(25	,0.4,'JAKARTA - INDONESIA'); // $kota_pt
	$pdf->Cell( 4	,0.4,'Time : '.$jam,0,0,L);
	$pdf->Ln();
	$pdf->Cell(25	,0.4);	
	$pdf->Cell( 4	,0.4,'Page : '.$hlm,0,0,L);
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell(28	,0.4,$judul); 
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(0.7);
	//----------------------------------------------------------------------------------------------

	$pdf->Cell(28	,0.4,'From Returning : '.$tgl1.' Until : '.$tgl2,0,0,L);
	$pdf->Ln();
	
	if($stt!='')
	{
		$pdf->Cell(19	,0.4,'Status : '.$nmastt,0,0,L); 		
		$pdf->Ln();
	}	

	$pdf->SetFont('Arial','B',7);
	$pdf->Cell( 0.5	,0.4,'No.'		,'TB',0,C); // 0.8
	$pdf->Cell( 9.9	,0.4,'Member'	,'TB',0,L);	
	$pdf->Cell( 1.7	,0.4,'Number'	,'TB',0,L); // 1.4
	$pdf->Cell( 9.9	,0.4,'Book'		,'TB',0,L);
	$pdf->Cell( 1.5	,0.4,'Borrowing','TB',0,C);
	$pdf->Cell( 1.5	,0.4,'Schedule'	,'TB',0,C);
	$pdf->Cell( 1.5	,0.4,'Returned'	,'TB',0,C);
	$pdf->Cell( 1.5	,0.4,'Fine'		,'TB',0,R);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
    $x=1;
	while($x<=40 and $j<$i)
	{
		$kdeang	=$cll[$j][2];
		$nmaang	=$cll[$j][3];
		$pdf->Cell( 0.5	,0.4,$no,'',0,R); // 0.8
		$pdf->Cell( 9.9	,0.4,$nmaang,'',0,L);
		$z=0;
		while($x<=40 and $j<$i and $kdeang==$cll[$j][2])
		{
			if($z>0)	$pdf->Cell(10.4	,0.4); // 10.7
			
			$jdl	=$cll[$j][5];
			$nmrpjm	=$cll[$j][0];
			$tglpjm	=$cll[$j][1];
			$jdwkmb	=$cll[$j][6];
			$tglkmb	=$cll[$j][7];
			$dnd	=$cll[$j][8];
			$gttl	=$gttl+$dnd;
			$pdf->Cell( 1.7	,0.4,$nmrpjm,''	,0,L); // 1.4
			$pdf->Cell( 9.9	,0.4,$jdl,''	,0,L);
			$pdf->Cell( 1.5	,0.4,$tglpjm,''	,0,C);
			$pdf->Cell( 1.5	,0.4,$jdwkmb,''	,0,C);
			$pdf->Cell( 1.5	,0.4,$tglkmb,''	,0,C);
			$pdf->Cell( 1.5	,0.4,number_format($dnd),''	,0,R);
			$pdf->Ln();
			$x++;
			$j++;
			$z++;
		}	
		if($nmrpjm!=$cll[$j][0])	$no++;
	}	
	$pdf->Cell(28   ,0,'',1); 	
	$pdf->Ln();
	if ($j>=$i)
	{
		$pdf->Cell(25.5,0.4,'TOTAL',0,0,L); 	
		$pdf->Cell( 2.5,0.4,number_format($gttl),0,0,R); 	
		$pdf->Ln();
		$pdf->Cell(28   ,0,'',1); 	
		$pdf->Ln();
	}
	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 5	,0.4,'FORM : P5L03_C01 (LIBRARY)');
	if($j<$i)
	{
		$hlm++;
		$pdf->Cell(23  	,0.4,'Printed by : '.$username.' '.$tgl.' '.$jam.' Continued on Page : '.$hlm,0,0,R);
	}
	else
	{
		$pdf->Cell(23  	,0.4,'Printed by : '.$username.' '.$tgl.' '.$jam,0,0,R);
	}	
}
$pdf->Output();
?>