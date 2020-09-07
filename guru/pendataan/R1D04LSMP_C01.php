<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LSMP_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) ledger smp 8-9
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
$query	="	SELECT 		t_setthn_smp.*
			FROM 		t_setthn_smp
			WHERE		t_setthn_smp.set='Tahun Ajaran'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_smp.*
			FROM 		t_mstbbt_smp
			WHERE		t_mstbbt_smp.kdebbt='1HW'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp.*
			FROM 		t_mstbbt_smp
			WHERE		t_mstbbt_smp.kdebbt='2PRJ'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp.*
			FROM 		t_mstbbt_smp
			WHERE		t_mstbbt_smp.kdebbt='3TES'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp.*
			FROM 		t_mstbbt_smp
			WHERE		t_mstbbt_smp.kdebbt='4MID'";
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
		
		$query3 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_smp.nis,t_prgrptps_smp.kdeplj"; // menghasilkan nilai satu siswa per subjek
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
	
		$query2 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."' AND 
									t_prgrptps_smp.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_smp.nis,t_prgrptps_smp.kdeplj"; // menghasilkan nilai per siswa per subjek
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
	$pdf->Cell( 4	,0.5,'Religion','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'CME','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'Bahasa Indo.','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'English','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'Maths','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'Biology','LRTB',0,C,true);
	
	
	
	
	//rlg
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 3.9	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//cme
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//bin
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//eng
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//mth
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//blgy
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	
	
	
	
	//rlg
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 3.9	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//cme
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//bin
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//eng
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//mth
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//blgy
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
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
		
		//cme
		$qCME	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='CME' "; // menghasilkan nilai avehw cme
		$rCME =mysql_query($qCME) or die('Query gagal5');
		while($dCME =mysql_fetch_array($rCME))
		{
			$cCME[$i][0]=$dCME['avehw'."$sms"."$midtrm"];
			$cCME[$i][1]=$dCME['aveprj'."$sms"."$midtrm"];
			$cCME[$i][2]=$dCME['avetes'."$sms"."$midtrm"];
			$cCME[$i][3]=$dCME['avemid'."$sms"."$midtrm"];
			$cCME[$i][4]=$dCME['akh'."$sms"."$midtrm"]; // QG
			$cCME[$i][5]=$dCME['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//bin
		$qBIN	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='BIN' "; // menghasilkan nilai avehw bin
		$rBIN =mysql_query($qBIN) or die('Query gagal5');
		while($dBIN =mysql_fetch_array($rBIN))
		{
			$cBIN[$i][0]=$dBIN['avehw'."$sms"."$midtrm"];
			$cBIN[$i][1]=$dBIN['aveprj'."$sms"."$midtrm"];
			$cBIN[$i][2]=$dBIN['avetes'."$sms"."$midtrm"];
			$cBIN[$i][3]=$dBIN['avemid'."$sms"."$midtrm"];
			$cBIN[$i][4]=$dBIN['akh'."$sms"."$midtrm"]; // QG
			$cBIN[$i][5]=$dBIN['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//rlg
		$qRLG	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='RLG' "; // menghasilkan nilai avehw rlg
		$rRLG =mysql_query($qRLG) or die('Query gagal5');
		while($dRLG =mysql_fetch_array($rRLG))
		{
			$cRLG[$i][0]=$dRLG['avehw'."$sms"."$midtrm"];
			$cRLG[$i][1]=$dRLG['aveprj'."$sms"."$midtrm"];
			$cRLG[$i][2]=$dRLG['avetes'."$sms"."$midtrm"];
			$cRLG[$i][3]=$dRLG['avemid'."$sms"."$midtrm"];
			$cRLG[$i][4]=$dRLG['akh'."$sms"."$midtrm"]; // QG
			$cRLG[$i][5]=$dRLG['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//eng
		$qENG	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='ENG' "; // menghasilkan nilai avehw eng
		$rENG =mysql_query($qENG) or die('Query gagal5');
		while($dENG =mysql_fetch_array($rENG))
		{
			$cENG[$i][0]=$dENG['avehw'."$sms"."$midtrm"];
			$cENG[$i][1]=$dENG['aveprj'."$sms"."$midtrm"];
			$cENG[$i][2]=$dENG['avetes'."$sms"."$midtrm"];
			$cENG[$i][3]=$dENG['avemid'."$sms"."$midtrm"];
			$cENG[$i][4]=$dENG['akh'."$sms"."$midtrm"]; // QG
			$cENG[$i][5]=$dENG['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//mth
		$qMTH	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='MTH' "; // menghasilkan nilai avehw mth
		$rMTH =mysql_query($qMTH) or die('Query gagal5');
		while($dMTH =mysql_fetch_array($rMTH))
		{
			$cMTH[$i][0]=$dMTH['avehw'."$sms"."$midtrm"];
			$cMTH[$i][1]=$dMTH['aveprj'."$sms"."$midtrm"];
			$cMTH[$i][2]=$dMTH['avetes'."$sms"."$midtrm"];
			$cMTH[$i][3]=$dMTH['avemid'."$sms"."$midtrm"];
			$cMTH[$i][4]=$dMTH['akh'."$sms"."$midtrm"]; // QG
			$cMTH[$i][5]=$dMTH['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//blgy
		$qBLGY	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='BLGY' "; // menghasilkan nilai avehw blgy
		$rBLGY =mysql_query($qBLGY) or die('Query gagal5');
		while($dBLGY =mysql_fetch_array($rBLGY))
		{
			$cBLGY[$i][0]=$dBLGY['avehw'."$sms"."$midtrm"];
			$cBLGY[$i][1]=$dBLGY['aveprj'."$sms"."$midtrm"];
			$cBLGY[$i][2]=$dBLGY['avetes'."$sms"."$midtrm"];
			$cBLGY[$i][3]=$dBLGY['avemid'."$sms"."$midtrm"];
			$cBLGY[$i][4]=$dBLGY['akh'."$sms"."$midtrm"]; // QG
			$cBLGY[$i][5]=$dBLGY['aff'."$sms"."$midtrm"]; // AFF
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
		$affCME=$cCME[$j][5];
		$affBIN=$cBIN[$j][5];
		$affRLG=$cRLG[$j][5];
		$affENG=$cENG[$j][5];
		$affMTH=$cMTH[$j][5];
		$affBLGY=$cBLGY[$j][5];
		
		
		if($affCME>100)
			$lgCME = 'ERR';
		else if($affCME>=85)
			$lgCME = 'A';
		else if($affCME>=70)
			$lgCME = 'B';
		else if($affCME>=60)
			$lgCME = 'C';
		else
			$lgCME = 'D';
		
		if($affBIN>100)
			$lgBIN = 'ERR';
		else if($affBIN>=85)
			$lgBIN = 'A';
		else if($affBIN>=70)
			$lgBIN = 'B';
		else if($affBIN>=60)
			$lgBIN = 'C';
		else
			$lgBIN = 'D';
		
		if($affRLG>100)
			$lgRLG = 'ERR';
		else if($affRLG>=85)
			$lgRLG = 'A';
		else if($affRLG>=70)
			$lgRLG = 'B';
		else if($affRLG>=60)
			$lgRLG = 'C';
		else
			$lgRLG = 'D';
		
		if($affENG>100)
			$lgENG = 'ERR';
		else if($affENG>=85)
			$lgENG = 'A';
		else if($affENG>=70)
			$lgENG = 'B';
		else if($affENG>=60)
			$lgENG = 'C';
		else
			$lgENG = 'D';
		
		if($affMTH>100)
			$lgMTH = 'ERR';
		else if($affMTH>=85)
			$lgMTH = 'A';
		else if($affMTH>=70)
			$lgMTH = 'B';
		else if($affMTH>=60)
			$lgMTH = 'C';
		else
			$lgMTH = 'D';
		
		if($affBLGY>100)
			$lgBLGY = 'ERR';
		else if($affBLGY>=85)
			$lgBLGY = 'A';
		else if($affBLGY>=70)
			$lgBLGY = 'B';
		else if($affBLGY>=60)
			$lgBLGY = 'C';
		else
			$lgBLGY = 'D';
		
		
		
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true); // 0.6
		$pdf->Cell( 3.5	,0.4,$cellX[$j][1],'LRTB',0,L,true); // $t
		$pdf->SetFillColor(255,255,255);
		
		
		
		//rlg
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cRLG[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cRLG[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cRLG[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cRLG[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cRLG[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgRLG,'LRTB',0,C,true);
		
		//cme
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cCME[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cCME[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cCME[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cCME[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cCME[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgCME,'LRTB',0,C,true); // $cCME[$j][5]
		
		//bin
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cBIN[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBIN[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBIN[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBIN[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cBIN[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgBIN,'LRTB',0,C,true);
		
		//eng
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cENG[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cENG[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cENG[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cENG[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cENG[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgENG,'LRTB',0,C,true);
		
		//mth
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cMTH[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMTH[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMTH[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMTH[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cMTH[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgMTH,'LRTB',0,C,true);
		
		//blgy
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cBLGY[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBLGY[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBLGY[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBLGY[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cBLGY[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgBLGY,'LRTB',0,C,true);
		
		
		
		
		
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
	$pdf->Cell( 3.9	,0.4,'average','LRTB',0,C,true);
	
	//rlg
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//cme
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);//$ttlQGcme/$jmlssw
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//bin
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//eng
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//mth
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//blgy
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	
	
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
	$pdf->Cell( 4	,0.5,'PHYSICS/CHEMISTRY','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'IPA','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'ECONOMICS','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'HISTORY','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'GEOGRAPHY','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'IPS','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'CULTURAL ART/MUSIC','LRTB',0,C,true);
	
	
	
	
	
	
	//phy
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 3.9	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//ipa
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//ecn
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//hist
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//ggry
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//ips
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//art
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	
	
	
	
	
	
	//phy
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 3.9	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//ipa
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//ecn
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//hist
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//ggry
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//ips
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//art
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
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
		$qPHY	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='PHY' "; // menghasilkan nilai avehw phy
		$rPHY =mysql_query($qPHY) or die('Query gagal5');
		while($dPHY =mysql_fetch_array($rPHY))
		{
			$cPHY[$i][0]=$dPHY['avehw'."$sms"."$midtrm"];
			$cPHY[$i][1]=$dPHY['aveprj'."$sms"."$midtrm"];
			$cPHY[$i][2]=$dPHY['avetes'."$sms"."$midtrm"];
			$cPHY[$i][3]=$dPHY['avemid'."$sms"."$midtrm"];
			$cPHY[$i][4]=$dPHY['akh'."$sms"."$midtrm"]; // QG
			$cPHY[$i][5]=$dPHY['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//ecn
		$qECN	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='ECN' "; // menghasilkan nilai avehw ecn
		$rECN =mysql_query($qECN) or die('Query gagal5');
		while($dECN =mysql_fetch_array($rECN))
		{
			$cECN[$i][0]=$dECN['avehw'."$sms"."$midtrm"];
			$cECN[$i][1]=$dECN['aveprj'."$sms"."$midtrm"];
			$cECN[$i][2]=$dECN['avetes'."$sms"."$midtrm"];
			$cECN[$i][3]=$dECN['avemid'."$sms"."$midtrm"];
			$cECN[$i][4]=$dECN['akh'."$sms"."$midtrm"]; // QG
			$cECN[$i][5]=$dECN['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//hist
		$qHIST	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='HIST' "; // menghasilkan nilai avehw hist
		$rHIST =mysql_query($qHIST) or die('Query gagal5');
		while($dHIST =mysql_fetch_array($rHIST))
		{
			$cHIST[$i][0]=$dHIST['avehw'."$sms"."$midtrm"];
			$cHIST[$i][1]=$dHIST['aveprj'."$sms"."$midtrm"];
			$cHIST[$i][2]=$dHIST['avetes'."$sms"."$midtrm"];
			$cHIST[$i][3]=$dHIST['avemid'."$sms"."$midtrm"];
			$cHIST[$i][4]=$dHIST['akh'."$sms"."$midtrm"]; // QG
			$cHIST[$i][5]=$dHIST['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//ggry
		$qGGRY	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='GGRY' "; // menghasilkan nilai avehw ggry
		$rGGRY =mysql_query($qGGRY) or die('Query gagal5');
		while($dGGRY =mysql_fetch_array($rGGRY))
		{
			$cGGRY[$i][0]=$dGGRY['avehw'."$sms"."$midtrm"];
			$cGGRY[$i][1]=$dGGRY['aveprj'."$sms"."$midtrm"];
			$cGGRY[$i][2]=$dGGRY['avetes'."$sms"."$midtrm"];
			$cGGRY[$i][3]=$dGGRY['avemid'."$sms"."$midtrm"];
			$cGGRY[$i][4]=$dGGRY['akh'."$sms"."$midtrm"]; // QG
			$cGGRY[$i][5]=$dGGRY['aff'."$sms"."$midtrm"]; // AFF
		}
		
		
		
		//art
		$qART	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='ART' "; // menghasilkan nilai avehw art
		$rART =mysql_query($qART) or die('Query gagal5');
		while($dART =mysql_fetch_array($rART))
		{
			$cART[$i][0]=$dART['avehw'."$sms"."$midtrm"];
			$cART[$i][1]=$dART['aveprj'."$sms"."$midtrm"];
			$cART[$i][2]=$dART['avetes'."$sms"."$midtrm"];
			$cART[$i][3]=$dART['avemid'."$sms"."$midtrm"];
			$cART[$i][4]=$dART['akh'."$sms"."$midtrm"]; // QG
			$cART[$i][5]=$dART['aff'."$sms"."$midtrm"]; // AFF
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
		$qgBLGY=$cBLGY[$j][4];
		$qgPHY=$cPHY[$j][4];
		$affBLGY=$cBLGY[$j][5];
		$affPHY=$cPHY[$j][5];
		
		$qgECN=$cECN[$j][4];
		$qgHIST=$cHIST[$j][4];
		$qgGGRY=$cGGRY[$j][4];
		
		
		$affECN=$cECN[$j][5];
		$affHIST=$cHIST[$j][5];
		$affGGRY=$cGGRY[$j][5];
		$affART=$cART[$j][5];
		
		
		
		
		$ipa='';
		if ( $affBLGY < $affPHY )
			$ipa = $affBLGY;
		else
			$ipa = $affPHYY;
		
		$ips='';
		if ( $affECN == 0 )
		{
			if ( $affGGRY < $affHIST )
				$ips = $affGGRY;
			else
				$ips = $affHIST;
		}	
		else
			$ips = $affECN;
		
		
		
		if($affPHY>100)
			$lgPHY = 'ERR';
		else if($affPHY>=85)
			$lgPHY = 'A';
		else if($affPHY>=70)
			$lgPHY = 'B';
		else if($affPHY>=60)
			$lgPHY = 'C';
		else
			$lgPHY = 'D';
		
		if($ipa>100)
			$ipa = 'ERR';
		else if($ipa>=85)
			$ipa = 'A';
		else if($ipa>=70)
			$ipa = 'B';
		else if($ipa>=60)
			$ipa = 'C';
		else
			$ipa = 'D';
		
		if($affECN>100)
			$lgECN = 'ERR';
		else if($affECN>=85)
			$lgECN = 'A';
		else if($affECN>=70)
			$lgECN = 'B';
		else if($affECN>=60)
			$lgECN = 'C';
		else
			$lgECN = 'D';
		
		if($affHIST>100)
			$lgHIST = 'ERR';
		else if($affHIST>=85)
			$lgHIST = 'A';
		else if($affHIST>=70)
			$lgHIST = 'B';
		else if($affHIST>=60)
			$lgHIST = 'C';
		else
			$lgHIST = 'D';
		
		if($affGGRY>100)
			$lgGGRY = 'ERR';
		else if($affGGRY>=85)
			$lgGGRY = 'A';
		else if($affGGRY>=70)
			$lgGGRY = 'B';
		else if($affGGRY>=60)
			$lgGGRY = 'C';
		else
			$lgGGRY = 'D';
		
		if($ips>100)
			$ips = 'ERR';
		else if($ips>=85)
			$ips = 'A';
		else if($ips>=70)
			$ips = 'B';
		else if($ips>=60)
			$ips = 'C';
		else
			$ips = 'D';
		
		if($affART>100)
			$lgART = 'ERR';
		else if($affART>=85)
			$lgART = 'A';
		else if($affART>=70)
			$lgART = 'B';
		else if($affART>=60)
			$lgART = 'C';
		else
			$lgART = 'D';
		
		
		
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true);
		$pdf->Cell( 3.5	,0.4,$cellY[$j][1],'LRTB',0,L,true);
		$pdf->SetFillColor(255,255,255);
		
		
		
		
		
		
		//phy
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cPHY[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPHY[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPHY[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPHY[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPHY[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgPHY,'LRTB',0,C,true);
		
		//ipa
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4,number_format( ($qgBLGY+$qgPHY)/2 ),'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$ipa,'LRTB',0,C,true);
		
		//ecn
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cECN[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cECN[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cECN[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cECN[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cECN[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgECN,'LRTB',0,C,true);
		
		//hist
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cHIST[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cHIST[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cHIST[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cHIST[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cHIST[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgHIST,'LRTB',0,C,true);
		
		//ggry
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cGGRY[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGGRY[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGGRY[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGGRY[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cGGRY[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgGGRY,'LRTB',0,C,true);
		
		//ips
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4,number_format( ($qgECN+$qgGGRY+$qgHIST)/3 ),'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$ips,'LRTB',0,C,true);
		
		//art
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cART[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cART[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cART[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cART[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cART[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgART,'LRTB',0,C,true);
		
		
		
		
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		
		
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	$pdf->Cell( 3.9	,0.4,'average','LRTB',0,C,true);
	
	//phy
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//ipa
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//ecn
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//hist
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//ggry
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//ips
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//art
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	
	
	
	
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
	$pdf->Cell( 4	,0.5,'PHYSICAL EDUCATION','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'INFORMATION TECHNOLOGY','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'MANDARIN','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'GERMAN','LRTB',0,C,true);
	$pdf->Cell( 4	,0.5,'PLKJ','LRTB',0,C,true);
	
	
	
	
	
	
	//pe
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 3.9	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//ict
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//mnd = for
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//grm = for
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//plkj
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'WO','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'PP','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'Q','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AFF','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	
	
	
	
	
	
	//pe
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 3.9	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//ict
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//mnd = for
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//grm = for
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	//plkj
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'A','LRTB',0,C,true);
	
	
	
	
	
	
	
		
	
	
	$queryZ 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
						t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; // menghasilkan semua siswa per kelas
	$resultZ =mysql_query($query) or die('Query gagal5');
	$i=0;
	while($dataZ =mysql_fetch_array($resultZ))
	{
		$cellZ[$i][0]=$dataZ[nis];
		$cellZ[$i][1]=$dataZ[nmassw];
		$nis=$dataZ[nis];
		
		
		
		//pe
		$qPE	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='PE' "; // menghasilkan nilai avehw pe
		$rPE =mysql_query($qPE) or die('Query gagal5');
		while($dPE =mysql_fetch_array($rPE))
		{
			$cPE[$i][0]=$dPE['avehw'."$sms"."$midtrm"];
			$cPE[$i][1]=$dPE['aveprj'."$sms"."$midtrm"];
			$cPE[$i][2]=$dPE['avetes'."$sms"."$midtrm"];
			$cPE[$i][3]=$dPE['avemid'."$sms"."$midtrm"];
			$cPE[$i][4]=$dPE['akh'."$sms"."$midtrm"]; // QG
			$cPE[$i][5]=$dPE['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//ict
		$qICT	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='ICT' "; // menghasilkan nilai avehw ict
		$rICT =mysql_query($qICT) or die('Query gagal5');
		while($dICT =mysql_fetch_array($rICT))
		{
			$cICT[$i][0]=$dICT['avehw'."$sms"."$midtrm"];
			$cICT[$i][1]=$dICT['aveprj'."$sms"."$midtrm"];
			$cICT[$i][2]=$dICT['avetes'."$sms"."$midtrm"];
			$cICT[$i][3]=$dICT['avemid'."$sms"."$midtrm"];
			$cICT[$i][4]=$dICT['akh'."$sms"."$midtrm"]; // QG
			$cICT[$i][5]=$dICT['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//mnd
		$qMND	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='MND' "; // menghasilkan nilai avehw mnd
		$rMND =mysql_query($qMND) or die('Query gagal5');
		while($dMND =mysql_fetch_array($rMND))
		{
			$cMND[$i][0]=$dMND['avehw'."$sms"."$midtrm"];
			$cMND[$i][1]=$dMND['aveprj'."$sms"."$midtrm"];
			$cMND[$i][2]=$dMND['avetes'."$sms"."$midtrm"];
			$cMND[$i][3]=$dMND['avemid'."$sms"."$midtrm"];
			$cMND[$i][4]=$dMND['akh'."$sms"."$midtrm"]; // QG
			$cMND[$i][5]=$dMND['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//grm
		$qGRM	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='GRM' "; // menghasilkan nilai avehw grm
		$rGRM =mysql_query($qGRM) or die('Query gagal5');
		while($dGRM =mysql_fetch_array($rGRM))
		{
			$cGRM[$i][0]=$dGRM['avehw'."$sms"."$midtrm"];
			$cGRM[$i][1]=$dGRM['aveprj'."$sms"."$midtrm"];
			$cGRM[$i][2]=$dGRM['avetes'."$sms"."$midtrm"];
			$cGRM[$i][3]=$dGRM['avemid'."$sms"."$midtrm"];
			$cGRM[$i][4]=$dGRM['akh'."$sms"."$midtrm"]; // QG
			$cGRM[$i][5]=$dGRM['aff'."$sms"."$midtrm"]; // AFF
		}
		
		//plkj
		$qPLKJ	 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp.kdeplj='PLKJ' "; // menghasilkan nilai avehw plkj
		$rPLKJ =mysql_query($qPLKJ) or die('Query gagal5');
		while($dPLKJ =mysql_fetch_array($rPLKJ))
		{
			$cPLKJ[$i][0]=$dPLKJ['avehw'."$sms"."$midtrm"];
			$cPLKJ[$i][1]=$dPLKJ['aveprj'."$sms"."$midtrm"];
			$cPLKJ[$i][2]=$dPLKJ['avetes'."$sms"."$midtrm"];
			$cPLKJ[$i][3]=$dPLKJ['avemid'."$sms"."$midtrm"];
			$cPLKJ[$i][4]=$dPLKJ['akh'."$sms"."$midtrm"]; // QG
			$cPLKJ[$i][5]=$dPLKJ['aff'."$sms"."$midtrm"]; // AFF
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
		$affPE=$cPE[$j][5];
		$affICT=$cICT[$j][5];
		$affMND=$cMND[$j][5];
		$affGRM=$cGRM[$j][5];
		$affPLKJ=$cPLKJ[$j][5];
		
		
		
		if($affPE>100)
			$lgPE = 'ERR';
		else if($affPE>=85)
			$lgPE = 'A';
		else if($affPE>=70)
			$lgPE = 'B';
		else if($affPE>=60)
			$lgPE = 'C';
		else
			$lgPE = 'D';
		
		if($affICT>100)
			$lgICT = 'ERR';
		else if($affICT>=85)
			$lgICT = 'A';
		else if($affICT>=70)
			$lgICT = 'B';
		else if($affICT>=60)
			$lgICT = 'C';
		else
			$lgICT = 'D';
		
		if($affMND>100)
			$lgMND = 'ERR';
		else if($affMND>=85)
			$lgMND = 'A';
		else if($affMND>=70)
			$lgMND = 'B';
		else if($affMND>=60)
			$lgMND = 'C';
		else
			$lgMND = 'D';
		
		if($affGRM>100)
			$lgGRM = 'ERR';
		else if($affGRM>=85)
			$lgGRM = 'A';
		else if($affGRM>=70)
			$lgGRM = 'B';
		else if($affGRM>=60)
			$lgGRM = 'C';
		else
			$lgGRM = 'D';
		
		
		
		if($affPLKJ>100)
			$lgPLKJ = 'ERR';
		else if($affPLKJ>=85)
			$lgPLKJ = 'A';
		else if($affPLKJ>=70)
			$lgPLKJ = 'B';
		else if($affPLKJ>=60)
			$lgPLKJ = 'C';
		else
			$lgPLKJ = 'D';
		
		
		
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true); // 0.6
		$pdf->Cell( 3.5	,0.4,$cellZ[$j][1],'LRTB',0,L,true); // $t
		$pdf->SetFillColor(255,255,255);
		
		
		
		
		//pe
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cPE[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPE[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPE[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPE[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPE[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgPE,'LRTB',0,C,true);
		
		//ict
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cICT[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cICT[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cICT[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cICT[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cICT[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgICT,'LRTB',0,C,true);
		
		//mnd = for
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cMND[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMND[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMND[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMND[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cMND[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgMND,'LRTB',0,C,true);
		
		//grm = for
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cGRM[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGRM[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGRM[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGRM[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cGRM[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgGRM,'LRTB',0,C,true);
		
		
		
		//plkj
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cPLKJ[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPLKJ[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPLKJ[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPLKJ[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPLKJ[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$lgPLKJ,'LRTB',0,C,true);
		
		
		
		
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	$pdf->Cell( 3.9	,0.4,'average','LRTB',0,C,true);
	
	//pe
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//ict
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//mnd = for
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//grm = for
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	//plkj
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	
	
	
	
	
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