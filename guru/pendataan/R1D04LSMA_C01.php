<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LSMA_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) ledger sma 11-12 tpgrade
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdeplj	=$_POST['kdeplj'];
$kdekls	=$_POST['kdekls'];
$sms	=$_POST['sms'];
$midtrm	=$_POST['midtrm'];
$tglctk	=$_POST['tglctk'];

$thn_ajr	=$_POST['thn_ajr'];

if($tglctk=='')
{
	$tglctk	=date('F d, Y');
}
else
{	
	$tglctk	=strtotime($tglctk);
	$tglctk	=date('F d, Y',$tglctk);
}	

// dapatkan data tahun ajaran
$query	="	SELECT 		t_setthn_sma.*
			FROM 		t_setthn_sma
			WHERE		t_setthn_sma.set='Tahun Ajaran'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='1HW'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='2PRJ'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='3TES'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='4MID'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtmidtes=$data[bbt];

// dapatkan data guru 
$query 	="	SELECT 		t_mstpng.*
			FROM 		t_mstpng
			WHERE 		t_mstpng.kdekls='". mysql_escape_string($kdekls)."' AND
						t_mstpng.kdeplj='". mysql_escape_string($kdeplj)."'";
$result =mysql_query($query) or die('Query gagal2');
$data 	=mysql_fetch_array($result);
$kdegru=$data[kdegru];

$query 	="	SELECT 		t_mstkry.*
			FROM 		t_mstkry
			WHERE 		t_mstkry.kdekry='". mysql_escape_string($kdegru)."'";
$result =mysql_query($query) or die('Query gagal2');
$data 	=mysql_fetch_array($result);
$nmagru=$data[nmakry];

// dapatkan data tingkat dan wali kelas
$query 	="	SELECT 		t_mstkls.*,t_klmkls.*,t_mstkry.*
			FROM 		t_mstkls,t_klmkls,t_mstkry
			WHERE 		t_mstkls.kdekls='". mysql_escape_string($kdekls)."' AND
						t_mstkls.kdeklm=t_klmkls.kdeklm	AND
						t_mstkls.wlikls=t_mstkry.kdekry";
$result =mysql_query($query) or die('Query gagal2');
$data 	=mysql_fetch_array($result);
$kdetkt=$data[kdetkt];
$wlikls=$data[nmakry];
switch($kdetkt)
{
	case 'PS':
		$judul	= "SAINT JOHN'S PRIMARY SCHOOL"; // $nama_pt_ps
		break;
	case 'JHS':
		$judul	= "SAINT JOHN'S JUNIOR HIGH SCHOOL"; // $nama_pt_jhs
		break;
	case 'SHS':
		$judul	= "SAINT JOHN'S SENIOR HIGH SCHOOL"; // $nama_pt_shs
		break;
}		
if($sms=='1')
	$nmasms='FIRST SEMESTER ';
else
	$nmasms='SECOND SEMESTER ';
$judul2=$nmasms.'LEDGER REPORT '.$midtrm; // MASTER SHEET

// dapatkan data kepala sekolah
$query 	="	SELECT 		t_prstkt.*,t_mstkry.*
			FROM 		t_prstkt,t_mstkry
			WHERE 		t_prstkt.kdetkt='". mysql_escape_string($kdetkt)."' AND
						t_prstkt.kdekry=t_mstkry.kdekry						AND
						t_prstkt.kdejbt=100";
$result =mysql_query($query) or die('Query gagal3');
$data 	=mysql_fetch_array($result);
$kplskl=$data[nmakry];

if($kplskl=='')
{
	$query 	="	SELECT 		t_prstkt.*,t_mstkry.*
				FROM 		t_prstkt,t_mstkry
				WHERE 		t_prstkt.kdetkt='". mysql_escape_string($kdetkt)."' AND
							t_prstkt.kdekry=t_mstkry.kdekry						AND
							t_prstkt.kdejbt=000	AND t_prstkt.kdekry!='@00000'	
				ORDER BY	t_prstkt.kdejbt ASC";
	$result =mysql_query($query) or die('Query gagal3');
	$data 	=mysql_fetch_array($result);
	$kplskl=$data[nmakry];
}

$logo_pt	="../../images/logo.jpg";
$logo_ttw	="../../images/tutwurihandayani.jpg";

$pdf =new FPDF('P','cm','A4');
$pdf->SetMargins(1,0.4,1);
$pdf->SetAutoPageBreak(True, 0.4);

$query 	="	SELECT 		t_setpsrpt.* 
			FROM 		t_setpsrpt
			WHERE 		t_setpsrpt.kdetkt='". mysql_escape_string($kdetkt)."' 
			ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id"; // menghasikan subjek per unit
$result =mysql_query($query) or die('Query gagal5');
$k=0; // NILAI var k
while($data =mysql_fetch_array($result))
{
	if($data[kdeplj]!='')
	{
		$kdeplj=$data[kdeplj];
		
		$query2 	="	SELECT 		t_mstssw.*
					FROM 		t_mstssw
					WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
								t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."' AND 
								t_mstssw.str='' 
					ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw
					LIMIT		1"; // ,1 menghasilkan data satu siswa
		$result2 =mysql_query($query2) or die('Query gagal5');
		$data2 	=mysql_fetch_array($result2);
		$nis	=$data2[nis];
		
		$query3 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sma.nis,t_prgrptps_sma.kdeplj"; // menghasilkan nilai satu siswa per subjek
		$result3 =mysql_query($query3) or die('Query gagal');
		$data3 	=mysql_fetch_array($result3);
		
		$akh=$data3['akh'."$sms"."$midtrm"];
		if($akh>0)
		{ 
			$cell2[$k][0]	=$data[kdeplj];
			$kdeplj			=$data[kdeplj];
			
			$query4 	="	SELECT 		t_kkm.*
							FROM 		t_kkm
							WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
										t_kkm.kdeplj='". mysql_escape_string($kdeplj)."'";
			$result4 =mysql_query($query4) or die('Query gagal'); // menghasilkan kkm per subjek per kelas
			$data4 	=mysql_fetch_array($result4);
			
			$cell2[$k][1]	=$data4[kkm];
			$cell2[$k][2]	=$data[kdeplj];//nmasbj
			$k++;
		}	
		else
		{
			if( $kdeplj=='MND' OR $kdeplj=='GRM' OR ( ($kdeplj=='PHY' OR $kdeplj=='BLGY' OR $kdeplj=='CHM') AND ( strpos($kdekls,'9')!='' OR strpos($kdekls,'10')!='')))	
			{
			$cell2[$k][0]	=$data[kdeplj];
			$kdeplj			=$data[kdeplj];
			
			$query4 	="	SELECT 		t_kkm.*
							FROM 		t_kkm
							WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
										t_kkm.kdeplj='". mysql_escape_string($kdeplj)."'"; // menghasilkan kkm per subjek per kelas
			$result4 =mysql_query($query4) or die('Query gagal');
			$data4 	=mysql_fetch_array($result4);
			
			$cell2[$k][1]	=$data4[kkm];
			$cell2[$k][2]	=$data[kdeplj];//nmasbj
			$k++;
			}
		}
	}	
}

$query 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
						t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."' AND
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; // menghasilkan semua siswa per kelas
$result =mysql_query($query) or die('Query gagal5');
$i=0;
while($data =mysql_fetch_array($result))
{
	$cell[$i][0]=$data[nis];
	$cell[$i][1]=$data[nmassw];
	$cell[$i][10]=$data[tgllhr]; // tgllhr
	$nis=$data[nis];
	$ttlakh	=0;
	$max	=0;
	$min	=0;
	$n=0;
	$m=0;
	while($n<$k)
	{
		$kdeplj=$cell2[$n][0];
	
		$query2 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sma.nis,t_prgrptps_sma.kdeplj"; // menghasilkan nilai per siswa per subjek
		$result2 =mysql_query($query2) or die('Query gagal');
		$data2 =mysql_fetch_array($result2);
		
		$akh=$data2['akh'."$sms"."$midtrm"];
		$cell[$i][$n+2]=$akh;
		$ttlakh=$ttlakh+$akh;
		if($akh>0)
			$m++;
		$n++;
	}
	$cell[$i][$n+2]=$ttlakh;
	
	if($m==0)
		$m=1;

	$cell[$i][$n+3]=number_format($ttlakh/($m),0,',','.');
	$i++;
}



//.. ke atas belum



$ttlakh=0;
$ttlavg=0;
$hlm=1;
$no	=1;
$j	=0;
$rnk=1;
while($j<$i)
{
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->Image($logo_pt ,1,1,2,2);
	$pdf->Image($logo_ttw,27,1,2,2);
	$pdf->Ln(0.8);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(28	,0.4, $judul,0,0,C);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Cell(28	,0.4, $judul2,0,0,C);
	$pdf->Ln();
	$pdf->Cell(28	,0.4, $thnajr,0,0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(28	,0.3, "",0,0,C);//$alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(28	,0.3, "",0,0,C);//$alamat2_pt2
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(0.5);
	$pdf->Cell( 1	,0.4,"Grade",0,0,L); 
	$pdf->Cell(27	,0.4,": ".$kdekls,0,0,L); 
	$pdf->Ln();

	$t=26-(($k+3)*0.9);
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	$pdf->Cell( 0.4	,1.5,'No','LRTB',0,C,true); // 0.6
	$pdf->Cell( 3.5	,1.5,'STUDENTS','LRTB',0,C,true);//$t
	
	$pdf->SetFont('Arial','',7);
	$pdf->Cell( 3.5	,0.5,'Religion','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'CME','LRTB',0,C,true);
	$pdf->Cell( 3.5	,0.5,'Bahasa Indo.','LRTB',0,C,true);
	$pdf->Cell( 3.5	,0.5,'English','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'Maths','LRTB',0,C,true);
	$pdf->Cell( 3.5	,0.5,'Biology','LRTB',0,C,true);
	$pdf->Cell( 3.5	,0.5,'CHEMISTRY','LRTB',0,C,true);
	
	
	
	//rlg
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 3.9	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.75	,0.5,'TH','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'PR','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//cme
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//bin
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'TH','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'PR','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//eng
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'TH','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'PR','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//mth
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//blgy
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'TH','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'PR','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//chm
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'TH','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'PR','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	
	
	
	
	//rlg
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 3.9	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//cme
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//bin
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//eng
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//mth
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//blgy
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//chm
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	
	
	
	
		
	
	
	
	
	$queryX 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
						t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."' AND
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; // menghasilkan semua siswa per kelas
	$resultX =mysql_query($query) or die('Query gagal5');
	$i=0;
	while($dataX =mysql_fetch_array($resultX))
	{
		$cellX[$i][0]=$dataX[nis];
		$cellX[$i][1]=$dataX[nmassw];
		$nis=$dataX[nis];
		
		//rlg
		$qRLG	 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj='RLG' "; // menghasilkan nilai avehw rlg
		$rRLG =mysql_query($qRLG) or die('Query gagal5');
		while($dRLG =mysql_fetch_array($rRLG))
		{
			$cRLG[$i][0]=$dRLG['fgt'."$sms"."$midtrm"];
			$cRLG[$i][1]=$dRLG['fgp'."$sms"."$midtrm"];
			
			$cRLG[$i][4]=$dRLG['akh'."$sms"."$midtrm"]; // QG
			$cRLG[$i][5]=$dRLG['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//cme
		$qCME	 	="	SELECT 		t_prgrptps_sma_p.*
						FROM 		t_prgrptps_sma_p
						WHERE 		t_prgrptps_sma_p.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma_p.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma_p.kdeplj='CME' "; // menghasilkan nilai avehw cme
		$rCME =mysql_query($qCME) or die('Query gagal5');
		while($dCME =mysql_fetch_array($rCME))
		{
			$cCME[$i][0]=$dCME['akh'."$sms"."$midtrm"];//'avehw'
			
			$cCME[$i][5]=$dCME['aff'."$sms"."$midtrm"];
		}
		
		//bin
		$qBIN	 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj='BIN' "; // menghasilkan nilai avehw bin
		$rBIN =mysql_query($qBIN) or die('Query gagal5');
		while($dBIN =mysql_fetch_array($rBIN))
		{
			$cBIN[$i][0]=$dBIN['fgt'."$sms"."$midtrm"];
			$cBIN[$i][1]=$dBIN['fgp'."$sms"."$midtrm"];
			
			$cBIN[$i][4]=$dBIN['akh'."$sms"."$midtrm"]; // QG
			$cBIN[$i][5]=$dBIN['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//eng
		$qENG	 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj='ENG' "; // menghasilkan nilai avehw eng
		$rENG =mysql_query($qENG) or die('Query gagal5');
		while($dENG =mysql_fetch_array($rENG))
		{
			$cENG[$i][0]=$dENG['fgt'."$sms"."$midtrm"];
			$cENG[$i][1]=$dENG['fgp'."$sms"."$midtrm"];
			
			$cENG[$i][4]=$dENG['akh'."$sms"."$midtrm"]; // QG
			$cENG[$i][5]=$dENG['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//mth
		$qMTH	 	="	SELECT 		t_prgrptps_sma_p.*
						FROM 		t_prgrptps_sma_p
						WHERE 		t_prgrptps_sma_p.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma_p.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma_p.kdeplj='MTH' "; // menghasilkan nilai avehw mth
		$rMTH =mysql_query($qMTH) or die('Query gagal5');
		while($dMTH =mysql_fetch_array($rMTH))
		{
			$cMTH[$i][0]=$dMTH['akh'."$sms"."$midtrm"];//avehw
			
			$cMTH[$i][5]=$dMTH['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//blgy
		$qBLGY	 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj='BLGY' "; // menghasilkan nilai avehw blgy
		$rBLGY =mysql_query($qBLGY) or die('Query gagal5');
		while($dBLGY =mysql_fetch_array($rBLGY))
		{
			$cBLGY[$i][0]=$dBLGY['fgt'."$sms"."$midtrm"];
			$cBLGY[$i][1]=$dBLGY['fgp'."$sms"."$midtrm"];
			
			$cBLGY[$i][4]=$dBLGY['akh'."$sms"."$midtrm"]; // QG
			$cBLGY[$i][5]=$dBLGY['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//chm
		$qCHM	 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj='CHM' "; // menghasilkan nilai avehw chm
		$rCHM =mysql_query($qCHM) or die('Query gagal5');
		while($dCHM =mysql_fetch_array($rCHM))
		{
			$cCHM[$i][0]=$dCHM['fgt'."$sms"."$midtrm"];
			$cCHM[$i][1]=$dCHM['fgp'."$sms"."$midtrm"];
			
			$cCHM[$i][4]=$dCHM['akh'."$sms"."$midtrm"]; // QG
			$cCHM[$i][5]=$dCHM['aff'."$sms"."$midtrm"]; // AFF
		}
		
		$i++;
	}
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	
	//$ttlQGcme=0;
	//$jmlssw=0;
	
	$x=1;
	//$j=0;
	while($j<$i AND $x<=30)
	{
		$affRLG=$cRLG[$j][5];
		$affCME=$cCME[$j][5];
		$affBIN=$cBIN[$j][5];
		$affENG=$cENG[$j][5];
		$affMTH=$cMTH[$j][5];
		$affBLGY=$cBLGY[$j][5];
		$affCHM=$cCHM[$j][5];
		
		
		
		if($affRLG>100)
			$lgRLG = 'ERR';
		else if($affRLG>=85)
			$lgRLG = 'A';
		else if($affRLG>=70)
			$lgRLG = 'B';
		else if($affRLG>=59.5)
			$lgRLG = 'C';
		else
			$lgRLG = 'D';
		
		if($affCME>100)
			$lgCME = 'ERR';
		else if($affCME>=85)
			$lgCME = 'A';
		else if($affCME>=70)
			$lgCME = 'B';
		else if($affCME>=59.5)
			$lgCME = 'C';
		else
			$lgCME = 'D';
		
		if($affBIN>100)
			$lgBIN = 'ERR';
		else if($affBIN>=85)
			$lgBIN = 'A';
		else if($affBIN>=70)
			$lgBIN = 'B';
		else if($affBIN>=59.5)
			$lgBIN = 'C';
		else
			$lgBIN = 'D';
		
		if($affENG>100)
			$lgENG = 'ERR';
		else if($affENG>=85)
			$lgENG = 'A';
		else if($affENG>=70)
			$lgENG = 'B';
		else if($affENG>=59.5)
			$lgENG = 'C';
		else
			$lgENG = 'D';
		
		if($affMTH>100)
			$lgMTH = 'ERR';
		else if($affMTH>=85)
			$lgMTH = 'A';
		else if($affMTH>=70)
			$lgMTH = 'B';
		else if($affMTH>=59.5)
			$lgMTH = 'C';
		else
			$lgMTH = 'D';
		
		if($affBLGY>100)
			$lgBLGY = 'ERR';
		else if($affBLGY>=85)
			$lgBLGY = 'A';
		else if($affBLGY>=70)
			$lgBLGY = 'B';
		else if($affBLGY>=59.5)
			$lgBLGY = 'C';
		else
			$lgBLGY = 'D';
		
		if($affCHM>100)
			$lgCHM = 'ERR';
		else if($affCHM>=85)
			$lgCHM = 'A';
		else if($affCHM>=70)
			$lgCHM = 'B';
		else if($affCHM>=59.5)
			$lgCHM = 'C';
		else
			$lgCHM = 'D';
		
		
		
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true); // 0.6
		$pdf->Cell( 3.5	,0.4,$cellX[$j][1],'LRTB',0,L,true); // $t
		$pdf->SetFillColor(255,255,255);
		
		
		
		//rlg
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.75	,0.4,$cRLG[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.4,$cRLG[$j][1],'LRTB',0,C,true);
		
		$pdf->Cell( 1	,0.4,$cRLG[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgRLG,'LRTB',0,C,true);
		
		//cme
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4,$cCME[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgCME,'LRTB',0,C,true); // $cCME[$j][5]
		
		//bin
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.75	,0.4,$cBIN[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.4,$cBIN[$j][1],'LRTB',0,C,true);
		
		$pdf->Cell( 1	,0.4,$cBIN[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgBIN,'LRTB',0,C,true);
		
		//eng
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.75	,0.4,$cENG[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.4,$cENG[$j][1],'LRTB',0,C,true);
		
		$pdf->Cell( 1	,0.4,$cENG[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgENG,'LRTB',0,C,true);
		
		//mth
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4,$cMTH[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgMTH,'LRTB',0,C,true);
		
		//blgy
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.75	,0.4,$cBLGY[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.4,$cBLGY[$j][1],'LRTB',0,C,true);
		
		$pdf->Cell( 1	,0.4,$cBLGY[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgBLGY,'LRTB',0,C,true);
		
		//chm
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.75	,0.4,$cCHM[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.4,$cCHM[$j][1],'LRTB',0,C,true);
		
		$pdf->Cell( 1	,0.4,$cCHM[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgCHM,'LRTB',0,C,true);
		
		
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		//$ttlQGcme=$ttlQGcme+$cell[$j][4];
		//$jmlssw++;
		
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	//$pdf->Cell( 3.9	,0.4,'average','LRTB',0,C,true);
	
	
	
	//.. sampai sini
	
	
	
	//----
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	if($j<$i)
	{
		$pdf->Cell(28	,0.4," Page : ".$hlm." Continued on page ".($hlm+1),'',0,R,true);
		$hlm++;
	}
	else
	{
		$pdf->Cell( 12	,0.4,'Jakarta, '.$tglctk,'',0,L,true);
		$pdf->Cell( 12	,0.4,'Approved by','',0,L,true);
		$pdf->Ln();
		$pdf->Cell( 12	,0.4,'Homeroom Teacher : '.$wlikls,'',0,L,true);
		$pdf->Cell( 12	,0.4,'Principal : '.$kplskl,'',0,L,true);
		$pdf->Cell(  4	,0.4," Page : ".$hlm,'',0,R,true);
	} 
};


//..sampai biology page 2



//while($j<$i)
//{
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->Image($logo_pt ,1,1,2,2);
	$pdf->Image($logo_ttw,27,1,2,2);
	$pdf->Ln(0.8);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(28	,0.4, $judul,0,0,C);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Cell(28	,0.4, $judul2,0,0,C);
	$pdf->Ln();
	$pdf->Cell(28	,0.4, $thnajr,0,0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(28	,0.3, "",0,0,C);//$alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(28	,0.3, "",0,0,C);//$alamat2_pt2
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(0.5);
	$pdf->Cell( 1	,0.4,"Grade",0,0,L); 
	$pdf->Cell(27	,0.4,": ".$kdekls,0,0,L); 
	$pdf->Ln();

	$t=26-(($k+3)*0.9);
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.4	,1.5,'No','LRTB',0,C,true);
	$pdf->Cell( 3.5	,1.5,'STUDENTS','LRTB',0,C,true);
	
	$pdf->SetFont('Arial','',7);
	$pdf->Cell( 3.5	,0.5,'PHYSICS','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'ECONOMICS','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'GEOGRAPHY','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'Sociology','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'History','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'Cultural Art','LRTB',0,C,true);
	$pdf->Cell( 3.5	,0.5,'PE','LRTB',0,C,true);
	$pdf->Cell( 3.5	,0.5,'IT','LRTB',0,C,true);
	$pdf->Cell( 3.5	,0.5,'German','LRTB',0,C,true);
	
	
	
	//phy
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 3.9	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.75	,0.5,'TH','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'PR','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//ecn
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//ggry
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//scl
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//hist
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//art
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//pe
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'TH','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'PR','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//ict
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'TH','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'PR','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//grm
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'TH','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'PR','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	
	
	
	
	//phy
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 3.9	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//ecn
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//ggry
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//scl
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//hist
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//art
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//pe
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//ict
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//grm
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	
	
	$queryY 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
						t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."' AND
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; // menghasilkan semua siswa per kelas
	$resultY =mysql_query($query) or die('Query gagal5');
	$i=0;
	while($dataY =mysql_fetch_array($resultY))
	{
		$cellY[$i][0]=$dataY[nis];
		$cellY[$i][1]=$dataY[nmassw];
		$nis=$dataY[nis];
		
		//phy
		$qPHY	 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj='PHY' "; // menghasilkan nilai avehw phy
		$rPHY =mysql_query($qPHY) or die('Query gagal5');
		while($dPHY =mysql_fetch_array($rPHY))
		{
			$cPHY[$i][0]=$dPHY['fgt'."$sms"."$midtrm"];
			$cPHY[$i][1]=$dPHY['fgp'."$sms"."$midtrm"];
			
			$cPHY[$i][4]=$dPHY['akh'."$sms"."$midtrm"]; // QG
			$cPHY[$i][5]=$dPHY['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//ecn
		$qECN	 	="	SELECT 		t_prgrptps_sma_p.*
						FROM 		t_prgrptps_sma_p
						WHERE 		t_prgrptps_sma_p.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma_p.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma_p.kdeplj='ECN' "; // menghasilkan nilai avehw ecn
		$rECN =mysql_query($qECN) or die('Query gagal5');
		while($dECN =mysql_fetch_array($rECN))
		{
			$cECN[$i][0]=$dECN['avehw'."$sms"."$midtrm"];
			
			$cECN[$i][5]=$dECN['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//ggry
		$qGGRY	 	="	SELECT 		t_prgrptps_sma_p.*
						FROM 		t_prgrptps_sma_p
						WHERE 		t_prgrptps_sma_p.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma_p.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma_p.kdeplj='GGRY' "; // menghasilkan nilai avehw ggry
		$rGGRY =mysql_query($qGGRY) or die('Query gagal5');
		while($dGGRY =mysql_fetch_array($rGGRY))
		{
			$cGGRY[$i][0]=$dGGRY['akh'."$sms"."$midtrm"];//'avehw'
			
			$cGGRY[$i][5]=$dGGRY['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//scl
		$qSCL	 	="	SELECT 		t_prgrptps_sma_p.*
						FROM 		t_prgrptps_sma_p
						WHERE 		t_prgrptps_sma_p.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma_p.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma_p.kdeplj='SCL' "; // menghasilkan nilai avehw scl
		$rSCL =mysql_query($qSCL) or die('Query gagal5');
		while($dSCL =mysql_fetch_array($rSCL))
		{
			$cSCL[$i][0]=$dSCL['akh'."$sms"."$midtrm"];//'avehw'
			
			$cSCL[$i][5]=$dSCL['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//hist
		$qHIST	 	="	SELECT 		t_prgrptps_sma_p.*
						FROM 		t_prgrptps_sma_p
						WHERE 		t_prgrptps_sma_p.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma_p.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma_p.kdeplj='HIST' "; // menghasilkan nilai avehw hist
		$rHIST =mysql_query($qHIST) or die('Query gagal5');
		while($dHIST =mysql_fetch_array($rHIST))
		{
			$cHIST[$i][0]=$dHIST['akh'."$sms"."$midtrm"];//'avehw'
			
			$cHIST[$i][5]=$dHIST['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//art
		$qART	 	="	SELECT 		t_prgrptps_sma_p.*
						FROM 		t_prgrptps_sma_p
						WHERE 		t_prgrptps_sma_p.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma_p.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma_p.kdeplj='ART' "; // menghasilkan nilai avehw art
		$rART =mysql_query($qART) or die('Query gagal5');
		while($dART =mysql_fetch_array($rART))
		{
			$cART[$i][0]=$dART['akh'."$sms"."$midtrm"];//'avehw'
			
			$cART[$i][5]=$dART['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//pe
		$qPE	 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj='PE' "; // menghasilkan nilai avehw pe
		$rPE =mysql_query($qPE) or die('Query gagal5');
		while($dPE =mysql_fetch_array($rPE))
		{
			$cPE[$i][0]=$dPE['fgt'."$sms"."$midtrm"];
			$cPE[$i][1]=$dPE['fgp'."$sms"."$midtrm"];
			
			$cPE[$i][4]=$dPE['akh'."$sms"."$midtrm"]; // QG
			$cPE[$i][5]=$dPE['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//ict
		$qICT	 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj='ICT' "; // menghasilkan nilai avehw ict
		$rICT =mysql_query($qICT) or die('Query gagal5');
		while($dICT =mysql_fetch_array($rICT))
		{
			$cICT[$i][0]=$dICT['fgt'."$sms"."$midtrm"];
			$cICT[$i][1]=$dICT['fgp'."$sms"."$midtrm"];
			
			$cICT[$i][4]=$dICT['akh'."$sms"."$midtrm"]; // QG
			$cICT[$i][5]=$dICT['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//grm
		$qGRM	 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj='GRM' "; // menghasilkan nilai avehw grm
		$rGRM =mysql_query($qGRM) or die('Query gagal5');
		while($dGRM =mysql_fetch_array($rGRM))
		{
			$cGRM[$i][0]=$dGRM['fgt'."$sms"."$midtrm"];
			$cGRM[$i][1]=$dGRM['fgp'."$sms"."$midtrm"];
			
			$cGRM[$i][4]=$dGRM['akh'."$sms"."$midtrm"]; // QG
			$cGRM[$i][5]=$dGRM['aff'."$sms"."$midtrm"]; // AFF
		}
		
		$i++;
	}
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	
	$x=1;
	$j=0;
	$no=1;
	while($j<$i AND $x<=30)
	{
		$affPHY=$cPHY[$j][5];
		$affECN=$cECN[$j][5];
		$affGGRY=$cGGRY[$j][5];
		$affSCL=$cSCL[$j][5];
		$affHIST=$cHIST[$j][5];
		$affART=$cART[$j][5];
		$affPE=$cPE[$j][5];
		$affICT=$cICT[$j][5];
		$affGRM=$cGRM[$j][5];
		
		if($affPHY>100)
			$lgPHY = 'ERR';
		else if($affPHY>=85)
			$lgPHY = 'A';
		else if($affPHY>=70)
			$lgPHY = 'B';
		else if($affPHY>=59.5)
			$lgPHY = 'C';
		else
			$lgPHY = 'D';
		
		if($affECN>100)
			$lgECN = 'ERR';
		else if($affECN>=85)
			$lgECN = 'A';
		else if($affECN>=70)
			$lgECN = 'B';
		else if($affECN>=59.5)
			$lgECN = 'C';
		else
			$lgECN = 'D';
		
		if($affGGRY>100)
			$lgGGRY = 'ERR';
		else if($affGGRY>=85)
			$lgGGRY = 'A';
		else if($affGGRY>=70)
			$lgGGRY = 'B';
		else if($affGGRY>=59.5)
			$lgGGRY = 'C';
		else
			$lgGGRY = 'D';
		
		if($affSCL>100)
			$lgSCL = 'ERR';
		else if($affSCL>=85)
			$lgSCL = 'A';
		else if($affSCL>=70)
			$lgSCL = 'B';
		else if($affSCL>=59.5)
			$lgSCL = 'C';
		else
			$lgSCL = 'D';
		
		if($affHIST>100)
			$lgHIST = 'ERR';
		else if($affHIST>=85)
			$lgHIST = 'A';
		else if($affHIST>=70)
			$lgHIST = 'B';
		else if($affHIST>=59.5)
			$lgHIST = 'C';
		else
			$lgHIST = 'D';
		
		if($affART>100)
			$lgART = 'ERR';
		else if($affART>=85)
			$lgART = 'A';
		else if($affART>=70)
			$lgART = 'B';
		else if($affART>=59.5)
			$lgART = 'C';
		else
			$lgART = 'D';
		
		if($affPE>100)
			$lgPE = 'ERR';
		else if($affPE>=85)
			$lgPE = 'A';
		else if($affPE>=70)
			$lgPE = 'B';
		else if($affPE>=59.5)
			$lgPE = 'C';
		else
			$lgPE = 'D';
		
		if($affICT>100)
			$lgICT = 'ERR';
		else if($affICT>=85)
			$lgICT = 'A';
		else if($affICT>=70)
			$lgICT = 'B';
		else if($affICT>=59.5)
			$lgICT = 'C';
		else
			$lgICT = 'D';
		
		if($affGRM>100)
			$lgGRM = 'ERR';
		else if($affGRM>=85)
			$lgGRM = 'A';
		else if($affGRM>=70)
			$lgGRM = 'B';
		else if($affGRM>=59.5)
			$lgGRM = 'C';
		else
			$lgGRM = 'D';
		
		
		
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true);
		$pdf->Cell( 3.5	,0.4,$cellY[$j][1],'LRTB',0,L,true);
		$pdf->SetFillColor(255,255,255);
		
		
		
		
		
		
		//phy
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.75	,0.4,$cPHY[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.4,$cPHY[$j][1],'LRTB',0,C,true);
		
		$pdf->Cell( 1	,0.4,$cPHY[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgPHY,'LRTB',0,C,true);
		
		//ecn
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4,$cECN[$j][0],'LRTB',0,C,true);
		
		$pdf->Cell( 1	,0.4,$lgECN,'LRTB',0,C,true);
		
		//ggry
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4,$cGGRY[$j][0],'LRTB',0,C,true);
		
		$pdf->Cell( 1	,0.4,$lgGGRY,'LRTB',0,C,true);
		
		//scl
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4,$cSCL[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgSCL,'LRTB',0,C,true);
		
		//hist
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4,$cHIST[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgHIST,'LRTB',0,C,true);
		
		//art
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4,$cART[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgART,'LRTB',0,C,true);
		
		//pe
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.75	,0.4,$cPE[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.4,$cPE[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPE[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgPE,'LRTB',0,C,true);
		
		//ict
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.75	,0.4,$cICT[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.4,$cICT[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cICT[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgICT,'LRTB',0,C,true);
		
		//grm
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.75	,0.4,$cGRM[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.4,$cGRM[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cGRM[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgGRM,'LRTB',0,C,true);
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		
		
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	//$pdf->Cell( 3.9	,0.4,'average','LRTB',0,C,true);
	
	
	
	//.. sampai sini
	
	
	
	//----
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	if($j<$i)
	{
		$pdf->Cell(28	,0.4," Page : ".$hlm." Continued on page ".($hlm+1),'',0,R,true);
		$hlm++;
	}
	else
	{
		$pdf->Cell( 12	,0.4,'Jakarta, '.$tglctk,'',0,L,true);
		$pdf->Cell( 12	,0.4,'Approved by','',0,L,true);
		$pdf->Ln();
		$pdf->Cell( 12	,0.4,'Homeroom Teacher : '.$wlikls,'',0,L,true);
		$pdf->Cell( 12	,0.4,'Principal : '.$kplskl,'',0,L,true);
		$pdf->Cell(  4	,0.4," Page : 2",'',0,R,true);
	} 
//};


//..sampai physical education and health page 3



//while($j<$i)
//{
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->Image($logo_pt ,1,1,2,2);
	$pdf->Image($logo_ttw,27,1,2,2);
	$pdf->Ln(0.8);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(28	,0.4, $judul,0,0,C);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Cell(28	,0.4, $judul2,0,0,C);
	$pdf->Ln();
	$pdf->Cell(28	,0.4, $thnajr,0,0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(28	,0.3, "",0,0,C);//$alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(28	,0.3, "",0,0,C);//$alamat2_pt2
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(0.5);
	$pdf->Cell( 1	,0.4,"Grade",0,0,L); 
	$pdf->Cell(27	,0.4,": ".$kdekls,0,0,L); 
	$pdf->Ln();

	$t=26-(($k+3)*0.9);
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	$pdf->Cell( 0.4	,1.5,'No','LRTB',0,C,true); // 0.6
	$pdf->Cell( 3.5	,1.5,'STUDENTS','LRTB',0,C,true);//$t
	
	$pdf->SetFont('Arial','',7);
	$pdf->Cell( 3.5	,0.5,'MANDARIN','LRTB',0,C,true);
	
	
	
	//mnd = for
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 3.9	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.75	,0.5,'TH','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'PR','LRTB',0,C,true);
	
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	
	
	
	
	//mnd = for
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 3.9	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'50%','LRTB',0,C,true);
	
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	
	
	
	
	
		
	
	
	$queryZ 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
						t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."' AND
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; // menghasilkan semua siswa per kelas
	$resultZ =mysql_query($query) or die('Query gagal5');
	$i=0;
	while($dataZ =mysql_fetch_array($resultZ))
	{
		$cellZ[$i][0]=$dataZ[nis];
		$cellZ[$i][1]=$dataZ[nmassw];
		$nis=$dataZ[nis];
		
		//mnd
		$qMND	 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_sma.kdeplj='MND' "; // menghasilkan nilai avehw mnd
		$rMND =mysql_query($qMND) or die('Query gagal5');
		while($dMND =mysql_fetch_array($rMND))
		{
			$cMND[$i][0]=$dMND['fgt'."$sms"."$midtrm"];
			$cMND[$i][1]=$dMND['fgp'."$sms"."$midtrm"];
			
			$cMND[$i][4]=$dMND['akh'."$sms"."$midtrm"]; // QG
			$cMND[$i][5]=$dMND['aff'."$sms"."$midtrm"]; // AFF
		}
		
		
		$i++;
	}
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	
	$x=1;
	$j=0;
	$no=1;
	while($j<$i AND $x<=30)
	{
		$affMND=$cMND[$j][5];
		
		if($affMND>100)
			$lgMND = 'ERR';
		else if($affMND>=85)
			$lgMND = 'A';
		else if($affMND>=70)
			$lgMND = 'B';
		else if($affMND>=59.5)
			$lgMND = 'C';
		else
			$lgMND = 'D';
		
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true); // 0.6
		$pdf->Cell( 3.5	,0.4,$cellZ[$j][1],'LRTB',0,L,true); // $t
		$pdf->SetFillColor(255,255,255);
		
		
		
		
		
		
		//mnd = for
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.75	,0.4,$cMND[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.4,$cMND[$j][1],'LRTB',0,C,true);
		
		$pdf->Cell( 1	,0.4,$cMND[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgMND,'LRTB',0,C,true);
		
		
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	//$pdf->Cell( 3.9	,0.4,'average','LRTB',0,C,true);
	
	
	
	
	//.. sampai sini
	
	
	
	//----
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	if($j<$i)
	{
		$pdf->Cell(28	,0.4," Page : ".$hlm." Continued on page ".($hlm+1),'',0,R,true);
		$hlm++;
	}
	else
	{
		$pdf->Cell( 12	,0.4,'Jakarta, '.$tglctk,'',0,L,true);
		$pdf->Cell( 12	,0.4,'Approved by','',0,L,true);
		$pdf->Ln();
		$pdf->Cell( 12	,0.4,'Homeroom Teacher : '.$wlikls,'',0,L,true);
		$pdf->Cell( 12	,0.4,'Principal : '.$kplskl,'',0,L,true);
		$pdf->Cell(  4	,0.4," Page : 3",'',0,R,true);
	} 
//}; 
$pdf->Output();
?>