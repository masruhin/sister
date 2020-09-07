<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LSMPK13_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) ledger smp 7
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
						t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
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
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
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
	$pdf->Cell( 0.8	,1.5,'NIS','LRTB',0,C,true);
	$pdf->Cell( 0.4	,1.5,'NO','LRTB',0,C,true); // 0.6
	$pdf->Cell( 3.5	,1.5,'DATE OF BIRTH','LRTB',0,C,true);
	$pdf->Cell( 3.5	,1.5,'STUDENTS','LRTB',0,C,true);//$t
	
	$pdf->SetFont('Arial','',7);
	$pdf->Cell( 6.75	,0.5,'Religion','LRTB',0,C,true);
	$pdf->Cell( 6.75	,0.5,'CME','LRTB',0,C,true);
	$pdf->Cell( 6.75	,0.5,'BAHASA','LRTB',0,C,true);
		
	
	
	
	
	
	//rlg
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 8.2	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	
	//cme
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	
	//bin
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//rlg
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 8.2	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	//cme
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	//bin
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	
	
	
	
	
		
	
	
	
	
	$queryX 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND 
						t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; // menghasilkan semua siswa per kelas
	$resultX =mysql_query($query) or die('Query gagal5');
	$i=0;
	while($dataX =mysql_fetch_array($resultX))
	{
		$cellX[$i][0]=$dataX[nis];
		$cellX[$i][1]=$dataX[nmassw];
		$cellX[$i][9]=$dataX[tmplhr]; // tmplhr
		$cellX[$i][10]=$dataX[tgllhr]; // tgllhr
		$nis=$dataX[nis];
		
		
		
		//rlg
		$qRLG	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='RLG' "; // menghasilkan nilai avehw rlg
		$rRLG =mysql_query($qRLG) or die('Query gagal5');
		while($dRLG =mysql_fetch_array($rRLG))
		{
			$cRLG[$i][0]=$dRLG['avehw'."$sms"."$midtrm"];
			$cRLG[$i][1]=$dRLG['aveprj'."$sms"."$midtrm"];
			$cRLG[$i][2]=$dRLG['avetes'."$sms"."$midtrm"];
			$cRLG[$i][3]=$dRLG['avemid'."$sms"."$midtrm"];
			$cRLG[$i][4]=$dRLG['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cRLG[$i][5]=$dRLG['aveae'."$sms"."$midtrm"];
			$cRLG[$i][6]=$dRLG['aveaf'."$sms"."$midtrm"];
			$cRLG[$i][7]=$dRLG['aveag'."$sms"."$midtrm"];
			$cRLG[$i][8]=$dRLG['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		//cme
		$qCME	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='CME' "; // menghasilkan nilai avehw cme
		$rCME =mysql_query($qCME) or die('Query gagal5');
		while($dCME =mysql_fetch_array($rCME))
		{
			$cCME[$i][0]=$dCME['avehw'."$sms"."$midtrm"];
			$cCME[$i][1]=$dCME['aveprj'."$sms"."$midtrm"];
			$cCME[$i][2]=$dCME['avetes'."$sms"."$midtrm"];
			$cCME[$i][3]=$dCME['avemid'."$sms"."$midtrm"];
			$cCME[$i][4]=$dCME['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cCME[$i][5]=$dCME['aveae'."$sms"."$midtrm"];
			$cCME[$i][6]=$dCME['aveaf'."$sms"."$midtrm"];
			$cCME[$i][7]=$dCME['aveag'."$sms"."$midtrm"];
			$cCME[$i][8]=$dCME['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		//bin
		$qBIN	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='BIN' "; // menghasilkan nilai avehw bin
		$rBIN =mysql_query($qBIN) or die('Query gagal5');
		while($dBIN =mysql_fetch_array($rBIN))
		{
			$cBIN[$i][0]=$dBIN['avehw'."$sms"."$midtrm"];
			$cBIN[$i][1]=$dBIN['aveprj'."$sms"."$midtrm"];
			$cBIN[$i][2]=$dBIN['avetes'."$sms"."$midtrm"];
			$cBIN[$i][3]=$dBIN['avemid'."$sms"."$midtrm"];
			$cBIN[$i][4]=$dBIN['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cBIN[$i][5]=$dBIN['aveae'."$sms"."$midtrm"];
			$cBIN[$i][6]=$dBIN['aveaf'."$sms"."$midtrm"];
			$cBIN[$i][7]=$dBIN['aveag'."$sms"."$midtrm"];
			$cBIN[$i][8]=$dBIN['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		$i++;
	}
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	
	
	
	//rlg
	$ttl_QG_rlg_K13=0;
	$ttl_QG_rlg_K14=0;
	$ttl_AVE_rlg_1314=0;
	
	//cme
	$ttl_QG_cme_K13=0;
	$ttl_QG_cme_K14=0;
	$ttl_AVE_cme_1314=0;
	
	//bin
	$ttl_QG_bin_K13=0;
	$ttl_QG_bin_K14=0;
	$ttl_AVE_bin_1314=0;
	
	$jmlssw=0;
	$x=1;
	//$j=0;
	while($j<$i AND $x<=30)
	{
		$nis=$cellX[$j][0];
		$tmplhr=$cellX[$j][9];
		$tgllhr=$cellX[$j][10];
		$tgllhr	=strtotime($tgllhr);
		$tgllhr	=date('d F Y',$tgllhr);
		
		
		
		//rlg
		$qgRLG_k13=$cRLG[$j][4];
		$qgRLG_k14=$cRLG[$j][8];
		$aveRLG1314=($qgRLG_k13+$qgRLG_k14)/2;
		
		//cme
		$qgCME_k13=$cCME[$j][4];
		$qgCME_k14=$cCME[$j][8];
		$aveCME1314=($qgCME_k13+$qgCME_k14)/2;
		
		//bin
		$qgBIN_k13=$cBIN[$j][4];
		$qgBIN_k14=$cBIN[$j][8];
		$aveBIN1314=($qgBIN_k13+$qgBIN_k14)/2;
		
		$pdf->Cell( 0.8	,0.4,substr($nis,0,3),'LRTB',0,C,true);
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true); // 0.6
		$pdf->Cell( 3.5	,0.4,$tmplhr.', '.$tgllhr,'LRTB',0,L,true);
		$pdf->Cell( 3.5	,0.4,$cellX[$j][1],'LRTB',0,L,true); // $t
		$pdf->SetFillColor(255,255,255);
		
		
		
		
		
		//rlg
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cRLG[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cRLG[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cRLG[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cRLG[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cRLG[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cRLG[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cRLG[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cRLG[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cRLG[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveRLG1314,'LRTB',0,C,true);
		
		//cme
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cCME[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cCME[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cCME[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cCME[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cCME[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cCME[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cCME[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cCME[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cCME[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveCME1314,'LRTB',0,C,true);
		
		//bin
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cBIN[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cBIN[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBIN[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBIN[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cBIN[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBIN[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBIN[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBIN[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cBIN[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveBIN1314,'LRTB',0,C,true);
		
		
		
		
		
		
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		
		
		//rlg
		$ttl_QG_rlg_K13 = $ttl_QG_rlg_K13 + $cRLG[$j][4];
		$ttl_QG_rlg_K14 = $ttl_QG_rlg_K14 + $cRLG[$j][8];
		$ttl_AVE_rlg_1314 = $ttl_AVE_rlg_1314 + $aveRLG1314;
		
		//cme
		$ttl_QG_cme_K13 = $ttl_QG_cme_K13 + $cCME[$j][4];
		$ttl_QG_cme_K14 = $ttl_QG_cme_K14 + $cCME[$j][8];
		$ttl_AVE_cme_1314 = $ttl_AVE_cme_1314 + $aveCME1314;
		
		//bin
		$ttl_QG_bin_K13 = $ttl_QG_bin_K13 + $cBIN[$j][4];
		$ttl_QG_bin_K14 = $ttl_QG_bin_K14 + $cBIN[$j][8];
		$ttl_AVE_bin_1314 = $ttl_AVE_bin_1314 + $aveBIN1314;
		
		$jmlssw++;
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	$pdf->Cell( 8.2	,0.4,'average','LRTB',0,C,true);
	
	
	
	//rlg
	$ave_QG_rlg_K13 = number_format( $ttl_QG_rlg_K13 / $jmlssw );
	$ave_QG_rlg_K14 = number_format( $ttl_QG_rlg_K14 / $jmlssw );
	$ave_QG_rlg_1314 = number_format( $ttl_AVE_rlg_1314 / $jmlssw ,3,',','.' );
	
	//cme
	$ave_QG_cme_K13 = number_format( $ttl_QG_cme_K13 / $jmlssw );
	$ave_QG_cme_K14 = number_format( $ttl_QG_cme_K14 / $jmlssw );
	$ave_QG_cme_1314 = number_format( $ttl_AVE_cme_1314 / $jmlssw ,3,',','.' );
	
	//bin
	$ave_QG_bin_K13 = number_format( $ttl_QG_bin_K13 / $jmlssw );
	$ave_QG_bin_K14 = number_format( $ttl_QG_bin_K14 / $jmlssw );
	$ave_QG_bin_1314 = number_format( $ttl_AVE_bin_1314 / $jmlssw ,3,',','.' );
	
	
	
	//rlg
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_rlg_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_rlg_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_rlg_1314,'LRTB',0,C,true);
	
	//cme
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_cme_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_cme_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_cme_1314,'LRTB',0,C,true);
	
	//bin
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_bin_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_bin_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_bin_1314,'LRTB',0,C,true);
	
	
	
	
	
	
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
	$pdf->Cell( 0.8	,1.5,'NIS','LRTB',0,C,true);
	$pdf->Cell( 0.4	,1.5,'NO','LRTB',0,C,true); // 0.6
	$pdf->Cell( 3.5	,1.5,'DATE OF BIRTH','LRTB',0,C,true);
	$pdf->Cell( 3.5	,1.5,'STUDENTS','LRTB',0,C,true);//$t
	
	$pdf->SetFont('Arial','',7);
	$pdf->Cell( 6.75	,0.5,'ENGLISH','LRTB',0,C,true);
	$pdf->Cell( 6.75	,0.5,'Mathematics','LRTB',0,C,true);
	$pdf->Cell( 6.75	,0.5,'BIOLOGY','LRTB',0,C,true);
	
	
	
	
	
	//eng
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 8.2	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//mth
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	
	//blgy
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	
	
	
	
	
	
	
	
	
	
	//eng
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 8.2	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	//mth
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
		
	//blgy
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	
	
	
	
	
	
	
		
	
	
	$queryY 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND 
						t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; // menghasilkan semua siswa per kelas
	$resultY =mysql_query($query) or die('Query gagal5');
	$i=0;
	while($dataY =mysql_fetch_array($resultY))
	{
		$cellY[$i][0]=$dataY[nis];
		$cellY[$i][1]=$dataY[nmassw];
		$cellY[$i][9]=$dataY[tmplhr]; // tmplhr
		$cellY[$i][10]=$dataY[tgllhr]; // tgllhr
		$nis=$dataY[nis];
		
		//eng
		$qENG	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='ENG' "; // menghasilkan nilai avehw eng
		$rENG =mysql_query($qENG) or die('Query gagal5');
		while($dENG =mysql_fetch_array($rENG))
		{
			$cENG[$i][0]=$dENG['avehw'."$sms"."$midtrm"];
			$cENG[$i][1]=$dENG['aveprj'."$sms"."$midtrm"];
			$cENG[$i][2]=$dENG['avetes'."$sms"."$midtrm"];
			$cENG[$i][3]=$dENG['avemid'."$sms"."$midtrm"];
			$cENG[$i][4]=$dENG['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cENG[$i][5]=$dENG['aveae'."$sms"."$midtrm"];
			$cENG[$i][6]=$dENG['aveaf'."$sms"."$midtrm"];
			$cENG[$i][7]=$dENG['aveag'."$sms"."$midtrm"];
			$cENG[$i][8]=$dENG['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		//mth
		$qMTH	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='MTH' "; // menghasilkan nilai avehw mth
		$rMTH =mysql_query($qMTH) or die('Query gagal5');
		while($dMTH =mysql_fetch_array($rMTH))
		{
			$cMTH[$i][0]=$dMTH['avehw'."$sms"."$midtrm"];
			$cMTH[$i][1]=$dMTH['aveprj'."$sms"."$midtrm"];
			$cMTH[$i][2]=$dMTH['avetes'."$sms"."$midtrm"];
			$cMTH[$i][3]=$dMTH['avemid'."$sms"."$midtrm"];
			$cMTH[$i][4]=$dMTH['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cMTH[$i][5]=$dMTH['aveae'."$sms"."$midtrm"];
			$cMTH[$i][6]=$dMTH['aveaf'."$sms"."$midtrm"];
			$cMTH[$i][7]=$dMTH['aveag'."$sms"."$midtrm"];
			$cMTH[$i][8]=$dMTH['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		//blgy
		$qBLGY	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='BLGY' "; // menghasilkan nilai avehw blgy
		$rBLGY =mysql_query($qBLGY) or die('Query gagal5');
		while($dBLGY =mysql_fetch_array($rBLGY))
		{
			$cBLGY[$i][0]=$dBLGY['avehw'."$sms"."$midtrm"];
			$cBLGY[$i][1]=$dBLGY['aveprj'."$sms"."$midtrm"];
			$cBLGY[$i][2]=$dBLGY['avetes'."$sms"."$midtrm"];
			$cBLGY[$i][3]=$dBLGY['avemid'."$sms"."$midtrm"];
			$cBLGY[$i][4]=$dBLGY['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cBLGY[$i][5]=$dBLGY['aveae'."$sms"."$midtrm"];
			$cBLGY[$i][6]=$dBLGY['aveaf'."$sms"."$midtrm"];
			$cBLGY[$i][7]=$dBLGY['aveag'."$sms"."$midtrm"];
			$cBLGY[$i][8]=$dBLGY['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		$i++;
	}
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	
	//eng
	$ttl_QG_eng_K13=0;
	$ttl_QG_eng_K14=0;
	$ttl_AVE_eng_1314=0;
	
	//mth
	$ttl_QG_mth_K13=0;
	$ttl_QG_mth_K14=0;
	$ttl_AVE_mth_1314=0;
	
	//blgy
	$ttl_QG_blgy_K13=0;
	$ttl_QG_blgy_K14=0;
	$ttl_AVE_blgy_1314=0;
	
	$jmlssw=0;
	$x=1;
	$j=0;
	$no=1;
	while($j<$i AND $x<=30)
	{
		$nis=$cellY[$j][0];
		$tmplhr=$cellY[$j][9];
		$tgllhr=$cellY[$j][10];
		$tgllhr	=strtotime($tgllhr);
		$tgllhr	=date('d F Y',$tgllhr);
		
		$pdf->Cell( 0.8	,0.4,substr($nis,0,3),'LRTB',0,C,true);
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true); // 0.6
		$pdf->Cell( 3.5	,0.4,$tmplhr.', '.$tgllhr,'LRTB',0,L,true);
		$pdf->Cell( 3.5	,0.4,$cellY[$j][1],'LRTB',0,L,true); // $t
		$pdf->SetFillColor(255,255,255);
		
		//eng
		$qgENG_k13=$cENG[$j][4];
		$qgENG_k14=$cENG[$j][8];
		$aveENG1314=($qgENG_k13+$qgENG_k14)/2;
		
		//mth
		$qgMTH_k13=$cMTH[$j][4];
		$qgMTH_k14=$cMTH[$j][8];
		$aveMTH1314=($qgMTH_k13+$qgMTH_k14)/2;
		
		//blgy
		$qgBLGY_k13=$cBLGY[$j][4];
		$qgBLGY_k14=$cBLGY[$j][8];
		$aveBLGY1314=($qgBLGY_k13+$qgBLGY_k14)/2;
		
		
		
		
		
		
		
		//eng
		$pdf->Cell( 0.5	,0.4,$cENG[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cENG[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cENG[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cENG[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cENG[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cENG[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cENG[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cENG[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cENG[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveENG1314,'LRTB',0,C,true);
		
		//mth
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cMTH[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cMTH[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMTH[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMTH[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cMTH[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMTH[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMTH[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMTH[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cMTH[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveMTH1314,'LRTB',0,C,true);
		
		//blgy
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cBLGY[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cBLGY[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBLGY[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBLGY[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cBLGY[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBLGY[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBLGY[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cBLGY[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cBLGY[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveBLGY1314,'LRTB',0,C,true);
		
		
		
		
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		//eng
		$ttl_QG_eng_K13 = $ttl_QG_eng_K13 + $cENG[$j][4];
		$ttl_QG_eng_K14 = $ttl_QG_eng_K14 + $cENG[$j][8];
		$ttl_AVE_eng_1314 = $ttl_AVE_eng_1314 + $aveENG1314;
		
		//mth
		$ttl_QG_mth_K13 = $ttl_QG_mth_K13 + $cMTH[$j][4];
		$ttl_QG_mth_K14 = $ttl_QG_mth_K14 + $cMTH[$j][8];
		$ttl_AVE_mth_1314 = $ttl_AVE_mth_1314 + $aveMTH1314;
		
		//blgy
		$ttl_QG_blgy_K13 = $ttl_QG_blgy_K13 + $cBLGY[$j][4];
		$ttl_QG_blgy_K14 = $ttl_QG_blgy_K14 + $cBLGY[$j][8];
		$ttl_AVE_blgy_1314 = $ttl_AVE_blgy_1314 + $aveBLGY1314;
		
		$jmlssw++;
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	$pdf->Cell( 8.2	,0.4,'average','LRTB',0,C,true);
	
	//eng
	$ave_QG_eng_K13 = number_format( $ttl_QG_eng_K13 / $jmlssw );
	$ave_QG_eng_K14 = number_format( $ttl_QG_eng_K14 / $jmlssw );
	$ave_QG_eng_1314 = number_format( $ttl_AVE_eng_1314 / $jmlssw ,3,',','.' );
	
	//mth
	$ave_QG_mth_K13 = number_format( $ttl_QG_mth_K13 / $jmlssw );
	$ave_QG_mth_K14 = number_format( $ttl_QG_mth_K14 / $jmlssw );
	$ave_QG_mth_1314 = number_format( $ttl_AVE_mth_1314 / $jmlssw ,3,',','.' );
		
	//blgy
	$ave_QG_blgy_K13 = number_format( $ttl_QG_blgy_K13 / $jmlssw );
	$ave_QG_blgy_K14 = number_format( $ttl_QG_blgy_K14 / $jmlssw );
	$ave_QG_blgy_1314 = number_format( $ttl_AVE_blgy_1314 / $jmlssw ,3,',','.' );
	
	//eng
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_eng_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_eng_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_eng_1314,'LRTB',0,C,true);
	
	//mth
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_mth_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_mth_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_mth_1314,'LRTB',0,C,true);
	
	//blgy
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_blgy_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_blgy_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_blgy_1314,'LRTB',0,C,true);
	
	
	
	
	
	
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
	$pdf->Cell( 0.8	,1.5,'NIS','LRTB',0,C,true);
	$pdf->Cell( 0.4	,1.5,'NO','LRTB',0,C,true); // 0.6
	$pdf->Cell( 3.5	,1.5,'DATE OF BIRTH','LRTB',0,C,true);
	$pdf->Cell( 3.5	,1.5,'STUDENTS','LRTB',0,C,true);//$t
	
	$pdf->SetFont('Arial','',7);
	$pdf->Cell( 6.75	,0.5,'PHYSICS CHEMESTRY','LRTB',0,C,true);
	$pdf->Cell( 6.75	,0.5,'ECONOMICS','LRTB',0,C,true);
	$pdf->Cell( 6.75	,0.5,'IPS GEOGRAFI','LRTB',0,C,true);
	
	
	
	
	
	//phy
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 8.2	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//ecn
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	
	//ggry
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	
	
	
	
	
	
	
	
	//phy
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 8.2	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	//ecn
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	//ggry
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	
	
	
	
	
	
		
	
	
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
		$cellZ[$i][9]=$dataZ[tmplhr]; // tmplhr
		$cellZ[$i][10]=$dataZ[tgllhr]; // tgllhr
		$nis=$dataZ[nis];
		
		//phy
		$qPHY	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='PHY' "; // menghasilkan nilai avehw phy
		$rPHY =mysql_query($qPHY) or die('Query gagal5');
		while($dPHY =mysql_fetch_array($rPHY))
		{
			$cPHY[$i][0]=$dPHY['avehw'."$sms"."$midtrm"];
			$cPHY[$i][1]=$dPHY['aveprj'."$sms"."$midtrm"];
			$cPHY[$i][2]=$dPHY['avetes'."$sms"."$midtrm"];
			$cPHY[$i][3]=$dPHY['avemid'."$sms"."$midtrm"];
			$cPHY[$i][4]=$dPHY['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cPHY[$i][5]=$dPHY['aveae'."$sms"."$midtrm"];
			$cPHY[$i][6]=$dPHY['aveaf'."$sms"."$midtrm"];
			$cPHY[$i][7]=$dPHY['aveag'."$sms"."$midtrm"];
			$cPHY[$i][8]=$dPHY['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		//ecn
		$qECN	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='ECN' "; // menghasilkan nilai avehw ecn
		$rECN =mysql_query($qECN) or die('Query gagal5');
		while($dECN =mysql_fetch_array($rECN))
		{
			$cECN[$i][0]=$dECN['avehw'."$sms"."$midtrm"];
			$cECN[$i][1]=$dECN['aveprj'."$sms"."$midtrm"];
			$cECN[$i][2]=$dECN['avetes'."$sms"."$midtrm"];
			$cECN[$i][3]=$dECN['avemid'."$sms"."$midtrm"];
			$cECN[$i][4]=$dECN['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cECN[$i][5]=$dECN['aveae'."$sms"."$midtrm"];
			$cECN[$i][6]=$dECN['aveaf'."$sms"."$midtrm"];
			$cECN[$i][7]=$dECN['aveag'."$sms"."$midtrm"];
			$cECN[$i][8]=$dECN['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		//ggry
		$qGGRY	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='GGRY' "; // menghasilkan nilai avehw ggry
		$rGGRY =mysql_query($qGGRY) or die('Query gagal5');
		while($dGGRY =mysql_fetch_array($rGGRY))
		{
			$cGGRY[$i][0]=$dGGRY['avehw'."$sms"."$midtrm"];
			$cGGRY[$i][1]=$dGGRY['aveprj'."$sms"."$midtrm"];
			$cGGRY[$i][2]=$dGGRY['avetes'."$sms"."$midtrm"];
			$cGGRY[$i][3]=$dGGRY['avemid'."$sms"."$midtrm"];
			$cGGRY[$i][4]=$dGGRY['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cGGRY[$i][5]=$dGGRY['aveae'."$sms"."$midtrm"];
			$cGGRY[$i][6]=$dGGRY['aveaf'."$sms"."$midtrm"];
			$cGGRY[$i][7]=$dGGRY['aveag'."$sms"."$midtrm"];
			$cGGRY[$i][8]=$dGGRY['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		$i++;
	}
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	
	//phy
	$ttl_QG_phy_K13=0;
	$ttl_QG_phy_K14=0;
	$ttl_AVE_phy_1314=0;
	
	//ecn
	$ttl_QG_ecn_K13=0;
	$ttl_QG_ecn_K14=0;
	$ttl_AVE_ecn_1314=0;
	
	//ggry
	$ttl_QG_ggry_K13=0;
	$ttl_QG_ggry_K14=0;
	$ttl_AVE_ggry_1314=0;
	
	$jmlssw=0;
	$x=1;
	$j=0;
	$no=1;
	while($j<$i AND $x<=30)
	{
		$nis=$cellZ[$j][0];
		$tmplhr=$cellZ[$j][9];
		$tgllhr=$cellZ[$j][10];
		$tgllhr	=strtotime($tgllhr);
		$tgllhr	=date('d F Y',$tgllhr);
		
		$pdf->Cell( 0.8	,0.4,substr($nis,0,3),'LRTB',0,C,true);
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true); // 0.6
		$pdf->Cell( 3.5	,0.4,$tmplhr.', '.$tgllhr,'LRTB',0,L,true);
		$pdf->Cell( 3.5	,0.4,$cellZ[$j][1],'LRTB',0,L,true); // $t
		$pdf->SetFillColor(255,255,255);
		
		//phy
		$qgPHY_k13=$cPHY[$j][4];
		$qgPHY_k14=$cPHY[$j][8];
		$avePHY1314=($qgPHY_k13+$qgPHY_k14)/2;
		
		//ecn
		$qgECN_k13=$cECN[$j][4];
		$qgECN_k14=$cECN[$j][8];
		$aveECN1314=($qgECN_k13+$qgECN_k14)/2;
		
		//ggry
		$qgGGRY_k13=$cGGRY[$j][4];
		$qgGGRY_k14=$cGGRY[$j][8];
		$aveGGRY1314=($qgGGRY_k13+$qgGGRY_k14)/2;
		
		
		
		
		
		
		
		
		
		//phy
		$pdf->Cell( 0.5	,0.4,$cPHY[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPHY[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPHY[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPHY[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPHY[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPHY[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPHY[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPHY[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPHY[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$avePHY1314,'LRTB',0,C,true);
		
		//ecn
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cECN[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cECN[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cECN[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cECN[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cECN[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cECN[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cECN[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cECN[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cECN[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveECN1314,'LRTB',0,C,true);
		
		//ggry
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cGGRY[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cGGRY[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGGRY[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGGRY[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cGGRY[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGGRY[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGGRY[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGGRY[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cGGRY[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveGGRY1314,'LRTB',0,C,true);
		
		
		
		
		
		
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		//phy
		$ttl_QG_phy_K13 = $ttl_QG_phy_K13 + $cPHY[$j][4];
		$ttl_QG_phy_K14 = $ttl_QG_phy_K14 + $cPHY[$j][8];
		$ttl_AVE_phy_1314 = $ttl_AVE_phy_1314 + $avePHY1314;
		
		//ecn
		$ttl_QG_ecn_K13 = $ttl_QG_ecn_K13 + $cECN[$j][4];
		$ttl_QG_ecn_K14 = $ttl_QG_ecn_K14 + $cECN[$j][8];
		$ttl_AVE_ecn_1314 = $ttl_AVE_ecn_1314 + $aveECN1314;
		
		//ggry
		$ttl_QG_ggry_K13 = $ttl_QG_ggry_K13 + $cGGRY[$j][4];
		$ttl_QG_ggry_K14 = $ttl_QG_ggry_K14 + $cGGRY[$j][8];
		$ttl_AVE_ggry_1314 = $ttl_AVE_ggry_1314 + $aveGGRY1314;
		
		$jmlssw++;
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	$pdf->Cell( 8.2	,0.4,'average','LRTB',0,C,true);
	
	//phy
	$ave_QG_phy_K13 = number_format( $ttl_QG_phy_K13 / $jmlssw );
	$ave_QG_phy_K14 = number_format( $ttl_QG_phy_K14 / $jmlssw );
	$ave_QG_phy_1314 = number_format( $ttl_AVE_phy_1314 / $jmlssw ,3,',','.' );
	
	//ecn
	$ave_QG_ecn_K13 = number_format( $ttl_QG_ecn_K13 / $jmlssw );
	$ave_QG_ecn_K14 = number_format( $ttl_QG_ecn_K14 / $jmlssw );
	$ave_QG_ecn_1314 = number_format( $ttl_AVE_ecn_1314 / $jmlssw ,3,',','.' );
	
	//ggry
	$ave_QG_ggry_K13 = number_format( $ttl_QG_ggry_K13 / $jmlssw );
	$ave_QG_ggry_K14 = number_format( $ttl_QG_ggry_K14 / $jmlssw );
	$ave_QG_ggry_1314 = number_format( $ttl_AVE_ggry_1314 / $jmlssw ,3,',','.' );
	
	
	
	
	
	//phy
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_phy_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_phy_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_phy_1314,'LRTB',0,C,true);
	
	//ecn
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_ecn_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_ecn_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_ecn_1314,'LRTB',0,C,true);
	
	//ggry
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_ggry_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_ggry_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_ggry_1314,'LRTB',0,C,true);
	
	
	
	
	
	
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



//.. sampai sini page 4



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
	$pdf->Cell( 0.8	,1.5,'NIS','LRTB',0,C,true);
	$pdf->Cell( 0.4	,1.5,'NO','LRTB',0,C,true); // 0.6
	$pdf->Cell( 3.5	,1.5,'DATE OF BIRTH','LRTB',0,C,true);
	$pdf->Cell( 3.5	,1.5,'STUDENTS','LRTB',0,C,true);//$t
	
	$pdf->SetFont('Arial','',7);
	$pdf->Cell( 6.75	,0.5,'HISTORY','LRTB',0,C,true);
	$pdf->Cell( 6.75	,0.5,'ART','LRTB',0,C,true);
	$pdf->Cell( 6.75	,0.5,'PE','LRTB',0,C,true);
	
	
	
	
	
	
	//hist
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 8.2	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//art
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//pe
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	
	
	
	
	
	
	
	
	
	//hist
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 8.2	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	//art
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	//pe
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	
	
	
	
	
		
	
	
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
		$cellZ[$i][9]=$dataZ[tmplhr]; // tmplhr
		$cellZ[$i][10]=$dataZ[tgllhr]; // tgllhr
		$nis=$dataZ[nis];
		
		//hist
		$qHIST	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='HIST' "; // menghasilkan nilai avehw hist
		$rHIST =mysql_query($qHIST) or die('Query gagal5');
		while($dHIST =mysql_fetch_array($rHIST))
		{
			$cHIST[$i][0]=$dHIST['avehw'."$sms"."$midtrm"];
			$cHIST[$i][1]=$dHIST['aveprj'."$sms"."$midtrm"];
			$cHIST[$i][2]=$dHIST['avetes'."$sms"."$midtrm"];
			$cHIST[$i][3]=$dHIST['avemid'."$sms"."$midtrm"];
			$cHIST[$i][4]=$dHIST['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cHIST[$i][5]=$dHIST['aveae'."$sms"."$midtrm"];
			$cHIST[$i][6]=$dHIST['aveaf'."$sms"."$midtrm"];
			$cHIST[$i][7]=$dHIST['aveag'."$sms"."$midtrm"];
			$cHIST[$i][8]=$dHIST['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		//art
		$qART	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='ART' "; // menghasilkan nilai avehw art
		$rART =mysql_query($qART) or die('Query gagal5');
		while($dART =mysql_fetch_array($rART))
		{
			$cART[$i][0]=$dART['avehw'."$sms"."$midtrm"];
			$cART[$i][1]=$dART['aveprj'."$sms"."$midtrm"];
			$cART[$i][2]=$dART['avetes'."$sms"."$midtrm"];
			$cART[$i][3]=$dART['avemid'."$sms"."$midtrm"];
			$cART[$i][4]=$dART['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cART[$i][5]=$dART['aveae'."$sms"."$midtrm"];
			$cART[$i][6]=$dART['aveaf'."$sms"."$midtrm"];
			$cART[$i][7]=$dART['aveag'."$sms"."$midtrm"];
			$cART[$i][8]=$dART['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		//pe
		$qPE	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='PE' "; // menghasilkan nilai avehw pe
		$rPE =mysql_query($qPE) or die('Query gagal5');
		while($dPE =mysql_fetch_array($rPE))
		{
			$cPE[$i][0]=$dPE['avehw'."$sms"."$midtrm"];
			$cPE[$i][1]=$dPE['aveprj'."$sms"."$midtrm"];
			$cPE[$i][2]=$dPE['avetes'."$sms"."$midtrm"];
			$cPE[$i][3]=$dPE['avemid'."$sms"."$midtrm"];
			$cPE[$i][4]=$dPE['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cPE[$i][5]=$dPE['aveae'."$sms"."$midtrm"];
			$cPE[$i][6]=$dPE['aveaf'."$sms"."$midtrm"];
			$cPE[$i][7]=$dPE['aveag'."$sms"."$midtrm"];
			$cPE[$i][8]=$dPE['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		
		
		$i++;
	}
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	
	
	
	//hist
	$ttl_QG_hist_K13=0;
	$ttl_QG_hist_K14=0;
	$ttl_AVE_hist_1314=0;
	
	//art
	$ttl_QG_art_K13=0;
	$ttl_QG_art_K14=0;
	$ttl_AVE_art_1314=0;
	
	//pe
	$ttl_QG_pe_K13=0;
	$ttl_QG_pe_K14=0;
	$ttl_AVE_pe_1314=0;
	
	
	
	$jmlssw++;
	$x=1;
	$j=0;
	$no=1;
	while($j<$i AND $x<=30)
	{
		$nis=$cellZ[$j][0];
		$tmplhr=$cellZ[$j][9];
		$tgllhr=$cellZ[$j][10];
		$tgllhr	=strtotime($tgllhr);
		$tgllhr	=date('d F Y',$tgllhr);
		
		$pdf->Cell( 0.8	,0.4,substr($nis,0,3),'LRTB',0,C,true);
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true); // 0.6
		$pdf->Cell( 3.5	,0.4,$tmplhr.', '.$tgllhr,'LRTB',0,L,true);
		$pdf->Cell( 3.5	,0.4,$cellZ[$j][1],'LRTB',0,L,true); // $t
		$pdf->SetFillColor(255,255,255);
		
		//hist
		$qgHIST_k13=$cHIST[$j][4];
		$qgHIST_k14=$cHIST[$j][8];
		$aveHIST1314=($qgHIST_k13+$qgHIST_k14)/2;
		
		//art
		$qgART_k13=$cART[$j][4];
		$qgART_k14=$cART[$j][8];
		$aveART1314=($qgART_k13+$qgART_k14)/2;
		
		//pe
		$qgPE_k13=$cPE[$j][4];
		$qgPE_k14=$cPE[$j][8];
		$avePE1314=($qgPE_k13+$qgPE_k14)/2;
		
		
		
		
		
		
		
		
		
		//hist
		$pdf->Cell( 0.5	,0.4,$cHIST[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cHIST[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cHIST[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cHIST[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cHIST[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cHIST[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cHIST[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cHIST[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cHIST[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveHIST1314,'LRTB',0,C,true);
		
		//art
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cART[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cART[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cART[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cART[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cART[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cART[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cART[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cART[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cART[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveART1314,'LRTB',0,C,true);
		
		//pe
		$pdf->Cell( 0.5	,0.4,$cPE[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPE[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPE[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPE[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPE[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPE[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPE[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPE[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPE[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$avePE1314,'LRTB',0,C,true);
		
		
		
		
		
		
		
		
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		//hist
		$ttl_QG_hist_K13 = $ttl_QG_hist_K13 + $cHIST[$j][4];
		$ttl_QG_hist_K14 = $ttl_QG_hist_K14 + $cHIST[$j][8];
		$ttl_AVE_hist_1314 = $ttl_AVE_hist_1314 + $aveHIST1314;
		
		//art
		$ttl_QG_art_K13 = $ttl_QG_art_K13 + $cART[$j][4];
		$ttl_QG_art_K14 = $ttl_QG_art_K14 + $cART[$j][8];
		$ttl_AVE_art_1314 = $ttl_AVE_art_1314 + $aveART1314;
		
		//pe
		$ttl_QG_pe_K13 = $ttl_QG_pe_K13 + $cPE[$j][4];
		$ttl_QG_pe_K14 = $ttl_QG_pe_K14 + $cPE[$j][8];
		$ttl_AVE_pe_1314 = $ttl_AVE_pe_1314 + $avePE1314;
		
		
		
		$jmlssw++;
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	//mpe sini 5
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	$pdf->Cell( 8.2	,0.4,'average','LRTB',0,C,true);
	
	
	
	
	//hist
	$ave_QG_hist_K13 = number_format( $ttl_QG_hist_K13 / $jmlssw );
	$ave_QG_hist_K14 = number_format( $ttl_QG_hist_K14 / $jmlssw );
	$ave_QG_hist_1314 = number_format( $ttl_AVE_hist_1314 / $jmlssw ,3,',','.' );
	
	//art
	$ave_QG_art_K13 = number_format( $ttl_QG_art_K13 / $jmlssw );
	$ave_QG_art_K14 = number_format( $ttl_QG_art_K14 / $jmlssw );
	$ave_QG_art_1314 = number_format( $ttl_AVE_art_1314 / $jmlssw ,3,',','.' );
	
	//pe
	$ave_QG_pe_K13 = number_format( $ttl_QG_pe_K13 / $jmlssw );
	$ave_QG_pe_K14 = number_format( $ttl_QG_pe_K14 / $jmlssw );
	$ave_QG_pe_1314 = number_format( $ttl_AVE_pe_1314 / $jmlssw ,3,',','.' );
	
	
	
	
	//hist
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_hist_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_hist_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_hist_1314,'LRTB',0,C,true);
	
	//art
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_art_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_art_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_art_1314,'LRTB',0,C,true);
	
	//pe
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_pe_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_pe_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_pe_1314,'LRTB',0,C,true);
	
	
	
	
	
	
	
	
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
		$pdf->Cell(  4	,0.4," Page : 4",'',0,R,true);
	} 
//}; 



//.. sampai sini page 5



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
	$pdf->Cell( 0.8	,1.5,'NIS','LRTB',0,C,true);
	$pdf->Cell( 0.4	,1.5,'NO','LRTB',0,C,true); // 0.6
	$pdf->Cell( 3.5	,1.5,'DATE OF BIRTH','LRTB',0,C,true);
	$pdf->Cell( 3.5	,1.5,'STUDENTS','LRTB',0,C,true);//$t
	
	$pdf->SetFont('Arial','',7);
	
	$pdf->Cell( 6.75	,0.5,'TLE','LRTB',0,C,true);
	$pdf->Cell( 6.75	,0.5,'PLKJ','LRTB',0,C,true);
	
	
	
	
	
	
	
	
	//ict
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 8.2	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	
	//plkj
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	
	
	
	
	
	
	
	
	
	
	
	
	//ict
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 8.2	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	//plkj
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	
	
	
	
	
	
		
	
	
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
		$cellZ[$i][9]=$dataZ[tmplhr]; // tmplhr
		$cellZ[$i][10]=$dataZ[tgllhr]; // tgllhr
		$nis=$dataZ[nis];
		
		
		
		//ict
		$qICT	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp_k13.kdeplj='ICT' "; // menghasilkan nilai avehw ict
		$rICT =mysql_query($qICT) or die('Query gagal5');
		while($dICT =mysql_fetch_array($rICT))
		{
			$cICT[$i][0]=$dICT['avehw'."$sms"."$midtrm"];
			$cICT[$i][1]=$dICT['aveprj'."$sms"."$midtrm"];
			$cICT[$i][2]=$dICT['avetes'."$sms"."$midtrm"];
			$cICT[$i][3]=$dICT['avemid'."$sms"."$midtrm"];
			$cICT[$i][4]=$dICT['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cICT[$i][5]=$dICT['aveae'."$sms"."$midtrm"];
			$cICT[$i][6]=$dICT['aveaf'."$sms"."$midtrm"];
			$cICT[$i][7]=$dICT['aveag'."$sms"."$midtrm"];
			$cICT[$i][8]=$dICT['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		//plkj
		$qPLKJ	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp_k13.kdeplj='PLKJ' "; // menghasilkan nilai avehw plkj
		$rPLKJ =mysql_query($qPLKJ) or die('Query gagal5');
		while($dPLKJ =mysql_fetch_array($rPLKJ))
		{
			$cPLKJ[$i][0]=$dPLKJ['avehw'."$sms"."$midtrm"];
			$cPLKJ[$i][1]=$dPLKJ['aveprj'."$sms"."$midtrm"];
			$cPLKJ[$i][2]=$dPLKJ['avetes'."$sms"."$midtrm"];
			$cPLKJ[$i][3]=$dPLKJ['avemid'."$sms"."$midtrm"];
			$cPLKJ[$i][4]=$dPLKJ['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cPLKJ[$i][5]=$dPLKJ['aveae'."$sms"."$midtrm"];
			$cPLKJ[$i][6]=$dPLKJ['aveaf'."$sms"."$midtrm"];
			$cPLKJ[$i][7]=$dPLKJ['aveag'."$sms"."$midtrm"];
			$cPLKJ[$i][8]=$dPLKJ['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		
		
		$i++;
	}
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	
	
	
	//ict
	$ttl_QG_ict_K13=0;
	$ttl_QG_ict_K14=0;
	$ttl_AVE_ict_1314=0;
	
	//plkj
	$ttl_QG_plkj_K13=0;
	$ttl_QG_plkj_K14=0;
	$ttl_AVE_plkj_1314=0;
	
	
		
	$jmlssw=0;
	$x=1;
	$j=0;
	$no=1;
	while($j<$i AND $x<=30)
	{
		$nis=$cellZ[$j][0];
		$tmplhr=$cellZ[$j][9];
		$tgllhr=$cellZ[$j][10];
		$tgllhr	=strtotime($tgllhr);
		$tgllhr	=date('d F Y',$tgllhr);
		
		
		
		//ict
		$qgICT_k13=$cICT[$j][4];
		$qgICT_k14=$cICT[$j][8];
		$aveICT1314=($qgICT_k13+$qgICT_k14)/2;
		
		//plkj
		$qgPLKJ_k13=$cPLKJ[$j][4];
		$qgPLKJ_k14=$cPLKJ[$j][8];
		$avePLKJ1314=($qgPLKJ_k13+$qgPLKJ_k14)/2;
		
		
		
		$pdf->Cell( 0.8	,0.4,substr($nis,0,3),'LRTB',0,C,true);
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true); // 0.6
		$pdf->Cell( 3.5	,0.4,$tmplhr.', '.$tgllhr,'LRTB',0,L,true);
		$pdf->Cell( 3.5	,0.4,$cellZ[$j][1],'LRTB',0,L,true); // $t
		$pdf->SetFillColor(255,255,255);
		
		
		
		
		
		
		
		
		//ict
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cICT[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cICT[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cICT[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cICT[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cICT[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cICT[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cICT[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cICT[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cICT[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveICT1314,'LRTB',0,C,true);
		
		//plkj
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cPLKJ[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPLKJ[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPLKJ[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPLKJ[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPLKJ[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPLKJ[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPLKJ[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cPLKJ[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cPLKJ[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$avePLKJ1314,'LRTB',0,C,true);
		
		
		
		
		
		
		
		
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		
		
		//ict
		$ttl_QG_ict_K13 = $ttl_QG_ict_K13 + $cICT[$j][4];
		$ttl_QG_ict_K14 = $ttl_QG_ict_K14 + $cICT[$j][8];
		$ttl_AVE_ict_1314 = $ttl_AVE_ict_1314 + $aveICT1314;
		
		//plkj
		$ttl_QG_plkj_K13 = $ttl_QG_plkj_K13 + $cPLKJ[$j][4];
		$ttl_QG_plkj_K14 = $ttl_QG_plkj_K14 + $cPLKJ[$j][8];
		$ttl_AVE_plkj_1314 = $ttl_AVE_plkj_1314 + $avePLKJ1314;
		
		
		
		$jmlssw++;
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	//mpe sini 6
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	$pdf->Cell( 8.2	,0.4,'average','LRTB',0,C,true);
	
	
	
	//ict
	$ave_QG_ict_K13 = number_format( $ttl_QG_ict_K13 / $jmlssw );
	$ave_QG_ict_K14 = number_format( $ttl_QG_ict_K14 / $jmlssw );
	$ave_QG_ict_1314 = number_format( $ttl_AVE_ict_1314 / $jmlssw ,3,',','.' );
	
	//plkj
	$ave_QG_plkj_K13 = number_format( $ttl_QG_plkj_K13 / $jmlssw );
	$ave_QG_plkj_K14 = number_format( $ttl_QG_plkj_K14 / $jmlssw );
	$ave_QG_plkj_1314 = number_format( $ttl_AVE_plkj_1314 / $jmlssw ,3,',','.' );
	
	
	
	
	
	//ict
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_ict_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_ict_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_ict_1314,'LRTB',0,C,true);
	
	//plkj
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_plkj_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_plkj_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_plkj_1314,'LRTB',0,C,true);
	
	
	
	
	
	
	
	
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
		$pdf->Cell(  4	,0.4," Page : 5",'',0,R,true);
	} 
//}; 



//.. sampai sini page 6



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
	$pdf->Cell( 0.8	,1.5,'NIS','LRTB',0,C,true);
	$pdf->Cell( 0.4	,1.5,'NO','LRTB',0,C,true); // 0.6
	$pdf->Cell( 3.5	,1.5,'DATE OF BIRTH','LRTB',0,C,true);
	$pdf->Cell( 3.5	,1.5,'STUDENTS','LRTB',0,C,true);//$t
	
	$pdf->SetFont('Arial','',7);
	$pdf->Cell( 6.75	,0.5,'MANDARIN','LRTB',0,C,true);
	$pdf->Cell( 6.75	,0.5,'GERMAN','LRTB',0,C,true);
	
	
	
	
	
	//mnd
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 8.2	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//grm
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'Q/P','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'O/P/H/P','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'UT','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'MT','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P4','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P3','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'P2','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'GRADE','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'AVG','LRTB',0,C,true);
	
	
	
	
	
	
	
	
	
	
	
	
	//mnd
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 8.2	,0.5,''		,0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	//grm
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'30%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'40%','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.5,'20%','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'100','LRTB',0,C,true);
	$pdf->Cell( 0.75,0.5,'','LRTB',0,C,true);
	
	
	
	
	
	
	
	
	
		
	
	
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
		$cellZ[$i][9]=$dataZ[tmplhr]; // tmplhr
		$cellZ[$i][10]=$dataZ[tgllhr]; // tgllhr
		$nis=$dataZ[nis];
		
		//mnd
		$qMND	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='MND' "; // menghasilkan nilai avehw mnd
		$rMND =mysql_query($qMND) or die('Query gagal5');
		while($dMND =mysql_fetch_array($rMND))
		{
			$cMND[$i][0]=$dMND['avehw'."$sms"."$midtrm"];
			$cMND[$i][1]=$dMND['aveprj'."$sms"."$midtrm"];
			$cMND[$i][2]=$dMND['avetes'."$sms"."$midtrm"];
			$cMND[$i][3]=$dMND['avemid'."$sms"."$midtrm"];
			$cMND[$i][4]=$dMND['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cMND[$i][5]=$dMND['aveae'."$sms"."$midtrm"];
			$cMND[$i][6]=$dMND['aveaf'."$sms"."$midtrm"];
			$cMND[$i][7]=$dMND['aveag'."$sms"."$midtrm"];
			$cMND[$i][8]=$dMND['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		//grm
		$qGRM	 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND 
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND 
									t_prgrptps_smp_k13.kdeplj='GRM' "; // menghasilkan nilai avehw grm
		$rGRM =mysql_query($qGRM) or die('Query gagal5');
		while($dGRM =mysql_fetch_array($rGRM))
		{
			$cGRM[$i][0]=$dGRM['avehw'."$sms"."$midtrm"];
			$cGRM[$i][1]=$dGRM['aveprj'."$sms"."$midtrm"];
			$cGRM[$i][2]=$dGRM['avetes'."$sms"."$midtrm"];
			$cGRM[$i][3]=$dGRM['avemid'."$sms"."$midtrm"];
			$cGRM[$i][4]=$dGRM['qg_k13_'."$sms"."$midtrm"]; // QG k13
			
			$cGRM[$i][5]=$dGRM['aveae'."$sms"."$midtrm"];
			$cGRM[$i][6]=$dGRM['aveaf'."$sms"."$midtrm"];
			$cGRM[$i][7]=$dGRM['aveag'."$sms"."$midtrm"];
			$cGRM[$i][8]=$dGRM['qg_k14_'."$sms"."$midtrm"]; // QG k14
		}
		
		$i++;
	}
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	
	//mnd
	$ttl_QG_mnd_K13=0;
	$ttl_QG_mnd_K14=0;
	$ttl_AVE_mnd_1314=0;
	
	//grm
	$ttl_QG_grm_K13=0;
	$ttl_QG_grm_K14=0;
	$ttl_AVE_grm_1314=0;
		
	$jmlssw=0;
	$x=1;
	$j=0;
	$no=1;
	while($j<$i AND $x<=30)
	{
		$nis=$cellZ[$j][0];
		$tmplhr=$cellZ[$j][9];
		$tgllhr=$cellZ[$j][10];
		$tgllhr	=strtotime($tgllhr);
		$tgllhr	=date('d F Y',$tgllhr);
		
		$pdf->Cell( 0.8	,0.4,substr($nis,0,3),'LRTB',0,C,true);
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true); // 0.6
		$pdf->Cell( 3.5	,0.4,$tmplhr.', '.$tgllhr,'LRTB',0,L,true);
		$pdf->Cell( 3.5	,0.4,$cellZ[$j][1],'LRTB',0,L,true); // $t
		$pdf->SetFillColor(255,255,255);
		
		//mnd
		$qgMND_k13=$cMND[$j][4];
		$qgMND_k14=$cMND[$j][8];
		$aveMND1314=($qgMND_k13+$qgMND_k14)/2;
		
		//grm
		$qgGRM_k13=$cGRM[$j][4];
		$qgGRM_k14=$cGRM[$j][8];
		$aveGRM1314=($qgGRM_k13+$qgGRM_k14)/2;
		
		
		
		
		//mnd
		$pdf->Cell( 0.5	,0.4,$cMND[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cMND[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMND[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMND[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cMND[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMND[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMND[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cMND[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cMND[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveMND1314,'LRTB',0,C,true);
		
		//grm
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cGRM[$j][0],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cGRM[$j][1],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGRM[$j][2],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGRM[$j][3],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cGRM[$j][4],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGRM[$j][5],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGRM[$j][6],'LRTB',0,C,true);
		$pdf->Cell( 0.5	,0.4,$cGRM[$j][7],'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,$cGRM[$j][8],'LRTB',0,C,true);
		$pdf->Cell( 0.75,0.4,$aveGRM1314,'LRTB',0,C,true);
		
		
		
		
		
		
		
		
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		
		//mnd
		$ttl_QG_mnd_K13 = $ttl_QG_mnd_K13 + $cMND[$j][4];
		$ttl_QG_mnd_K14 = $ttl_QG_mnd_K14 + $cMND[$j][8];
		$ttl_AVE_mnd_1314 = $ttl_AVE_mnd_1314 + $aveMND1314;
		
		//GRM
		$ttl_QG_GRM_K13 = $ttl_QG_GRM_K13 + $cGRM[$j][4];
		$ttl_QG_GRM_K14 = $ttl_QG_GRM_K14 + $cGRM[$j][8];
		$ttl_AVE_GRM_1314 = $ttl_AVE_GRM_1314 + $aveGRM1314;
		
		
		$jmlssw++;
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);//153,153,153
	$pdf->Cell( 8.2	,0.4,'average','LRTB',0,C,true);
	
	//mnd
	$ave_QG_mnd_K13 = number_format( $ttl_QG_mnd_K13 / $jmlssw );
	$ave_QG_mnd_K14 = number_format( $ttl_QG_mnd_K14 / $jmlssw );
	$ave_QG_mnd_1314 = number_format( $ttl_AVE_mnd_1314 / $jmlssw ,3,',','.' );
	
	//grm
	$ave_QG_grm_K13 = number_format( $ttl_QG_grm_K13 / $jmlssw );
	$ave_QG_grm_K14 = number_format( $ttl_QG_grm_K14 / $jmlssw );
	$ave_QG_grm_1314 = number_format( $ttl_AVE_grm_1314 / $jmlssw ,3,',','.' );
	
	
	
	//mnd
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_mnd_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_mnd_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_mnd_1314,'LRTB',0,C,true);
	
	//grm
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_grm_K13,'LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ave_QG_grm_K14,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',6.5);
	$pdf->Cell( 0.75,0.4,$ave_QG_grm_1314,'LRTB',0,C,true);
	
	
	
	
	
	
	
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
		$pdf->Cell(  4	,0.4," Page : 6",'',0,R,true);
	} 
//};
$pdf->Output();
?>