<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LSDfnl_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdeplj	=$_GET['kdeplj'];
$kdekls	=$_GET['kdekls'];
$sms	='2';
//$sms	=$_POST['sms'];
$midtrm	='2';//$_POST['midtrm'];
$tglctk	=$_POST['tglctk'];



if($tglctk=='')
{
	$tglctk	=date('F d, Y');
}
else
{	
	$tglctk	=strtotime($tglctk);
	$tglctk	=date('F d, Y',$tglctk);
}	

//if($sms=='2')
	//echo"<meta http-equiv='refresh' content=\"0;url=R1D04LSDfnl2_C01.php?kdekls=$kdekls\">\n";

// dapatkan data tahun ajaran
/*$query	="	SELECT 		t_setthn_sd.*
			FROM 		t_setthn_sd
			WHERE		t_setthn_sd.set='Tahun Ajaran'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];*/

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='1HW'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='2PRJ'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='3TES'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='4MID'";
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
$judul2=$nmasms.'LEDGER REPORT '.$midtrm;//MASTER SHEET

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

$logo_pt	="../../images/logo_sjs_meruya.png";//logo.jpg
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
					WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' 
					ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw ASC
					LIMIT		1,1"; // menghasilkan data satu siswa
		$result2 =mysql_query($query2) or die('Query gagal5');
		$data2 	=mysql_fetch_array($result2);
		$nis	=$data2[nis];
		
		$query3 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sd.nis,t_prgrptps_sd.kdeplj"; // menghasilkan nilai satu siswa per subjek
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
	
		$query2 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sd.nis,t_prgrptps_sd.kdeplj"; // menghasilkan nilai per siswa per subjek
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
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 3	,0.5,'Religion','LRTB',0,C,true);
	$pdf->Cell( 3	,0.5,'CME','LRTB',0,C,true);
	$pdf->Cell( 3	,0.5,'Bahasa Indo.','LRTB',0,C,true);
	$pdf->Cell( 3	,0.5,'Maths','LRTB',0,C,true);
	$pdf->Cell( 3	,0.5,'Science','LRTB',0,C,true);
	$pdf->Cell( 3	,0.5,'Soc. Studies','LRTB',0,C,true);
	$pdf->Cell( 3	,0.5,'Music/Arts','LRTB',0,C,true);
	$pdf->Cell( 3	,0.5,'Computer','LRTB',0,C,true);
	$pdf->Cell( 3	,0.5,'PE','LRTB',0,C,true);
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'Q3','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'Q4','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AV','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Cell( 1	,0.5,'Q3','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'Q4','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AV','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Cell( 1	,0.5,'Q3','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'Q4','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AV','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Cell( 1	,0.5,'Q3','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'Q4','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AV','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Cell( 1	,0.5,'Q3','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'Q4','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AV','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Cell( 1	,0.5,'Q3','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'Q4','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AV','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Cell( 1	,0.5,'Q3','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'Q4','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AV','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Cell( 1	,0.5,'Q3','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'Q4','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AV','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Cell( 1	,0.5,'Q3','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'Q4','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AV','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	//..AVE / STU
	
	
	
	
		
	
	
	$queryX 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND 
						
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; // menghasilkan semua siswa per kelas
	$resultX =mysql_query($queryX) or die('Query gagal5');
	$i=0;
	while($dataX =mysql_fetch_array($resultX))
	{
		$cellX[$i][0]=$dataX[nis];
		$cellX[$i][1]=$dataX[nmassw];
		$nis=$dataX[nis];
		
		//rlg
		$qRLG	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='RLG' "; // menghasilkan nilai avehw rlg
		$rRLG =mysql_query($qRLG) or die('Query gagal5');
		while($dRLG =mysql_fetch_array($rRLG))
		{
			$cRLG[$i][0]=$dRLG['st'.'2'.'1'."9"]; // K
			$cRLG[$i][1]=$dRLG['st_'.'2'.'1'."9"]; // S
			
			$cRLG[$i][2]=$dRLG['st'.'2'.'2'."9"]; // K
			$cRLG[$i][3]=$dRLG['st_'.'2'.'2'."9"]; // S
			
			$cRLG[$i][4]=$dRLG['fgk'.'2'.'1']; // K
			$cRLG[$i][5]=$dRLG['fgs'.'2'.'1']; // S
			
			$cRLG[$i][6]=$dRLG['fgk'.'2'.'2']; // K
			$cRLG[$i][7]=$dRLG['fgs'.'2'.'2']; // S
		}
		
		//cme
		$qCME	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='CME' "; // menghasilkan nilai avehw cme
		$rCME =mysql_query($qCME) or die('Query gagal5');
		while($dCME =mysql_fetch_array($rCME))
		{
			$cCME[$i][0]=$dCME['st'.'2'.'1'."9"]; // K
			$cCME[$i][1]=$dCME['st_'.'2'.'1'."9"]; // S
			
			$cCME[$i][2]=$dCME['st'.'2'.'2'."9"]; // K
			$cCME[$i][3]=$dCME['st_'.'2'.'2'."9"]; // S
			
			$cCME[$i][4]=$dCME['fgk'.'2'.'1']; // K
			$cCME[$i][5]=$dCME['fgs'.'2'.'1']; // S
			
			$cCME[$i][6]=$dCME['fgk'.'2'.'2']; // K
			$cCME[$i][7]=$dCME['fgs'.'2'.'2']; // S
		}
		
		//bin
		$qBIN	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='BIN' "; // menghasilkan nilai avehw bin
		$rBIN =mysql_query($qBIN) or die('Query gagal5');
		while($dBIN =mysql_fetch_array($rBIN))
		{
			$cBIN[$i][0]=$dBIN['st'.'2'.'1'."9"]; // K
			$cBIN[$i][1]=$dBIN['st_'.'2'.'1'."9"]; // S
			
			$cBIN[$i][2]=$dBIN['st'.'2'.'2'."9"]; // K
			$cBIN[$i][3]=$dBIN['st_'.'2'.'2'."9"]; // S
			
			$cBIN[$i][4]=$dBIN['fgk'.'2'.'1']; // K
			$cBIN[$i][5]=$dBIN['fgs'.'2'.'1']; // S
			
			$cBIN[$i][6]=$dBIN['fgk'.'2'.'2']; // K
			$cBIN[$i][7]=$dBIN['fgs'.'2'.'2']; // S
		}
		
		//mth
		$qMTH	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='MTH' "; // menghasilkan nilai avehw mth
		$rMTH =mysql_query($qMTH) or die('Query gagal5');
		while($dMTH =mysql_fetch_array($rMTH))
		{
			$cMTH[$i][0]=$dMTH['st'.'2'.'1'."9"]; // K
			$cMTH[$i][1]=$dMTH['st_'.'2'.'1'."9"]; // S
			
			$cMTH[$i][2]=$dMTH['st'.'2'.'2'."9"]; // K
			$cMTH[$i][3]=$dMTH['st_'.'2'.'2'."9"]; // S
			
			$cMTH[$i][4]=$dMTH['fgk'.'2'.'1']; // K
			$cMTH[$i][5]=$dMTH['fgs'.'2'.'1']; // S
			
			$cMTH[$i][6]=$dMTH['fgk'.'2'.'2']; // K
			$cMTH[$i][7]=$dMTH['fgs'.'2'.'2']; // S
		}
		
		//scn
		$qSCN	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='SCN' "; // menghasilkan nilai avehw scn
		$rSCN =mysql_query($qSCN) or die('Query gagal5');
		while($dSCN =mysql_fetch_array($rSCN))
		{
			$cSCN[$i][0]=$dSCN['st'.'2'.'1'."9"]; // K
			$cSCN[$i][1]=$dSCN['st_'.'2'.'1'."9"]; // S
			
			$cSCN[$i][2]=$dSCN['st'.'2'.'2'."9"]; // K
			$cSCN[$i][3]=$dSCN['st_'.'2'.'2'."9"]; // S
			
			$cSCN[$i][4]=$dSCN['fgk'.'2'.'1']; // K
			$cSCN[$i][5]=$dSCN['fgs'.'2'.'1']; // S
			
			$cSCN[$i][6]=$dSCN['fgk'.'2'.'2']; // K
			$cSCN[$i][7]=$dSCN['fgs'.'2'.'2']; // S
		}
		
		//scls
		$qSCLS	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='SCLS' "; // menghasilkan nilai avehw scls
		$rSCLS =mysql_query($qSCLS) or die('Query gagal5');
		while($dSCLS =mysql_fetch_array($rSCLS))
		{
			$cSCLS[$i][0]=$dSCLS['st'.'2'.'1'."9"]; // K
			$cSCLS[$i][1]=$dSCLS['st_'.'2'.'1'."9"]; // S
			
			$cSCLS[$i][2]=$dSCLS['st'.'2'.'2'."9"]; // K
			$cSCLS[$i][3]=$dSCLS['st_'.'2'.'2'."9"]; // S
			
			$cSCLS[$i][4]=$dSCLS['fgk'.'2'.'1']; // K
			$cSCLS[$i][5]=$dSCLS['fgs'.'2'.'1']; // S
			
			$cSCLS[$i][6]=$dSCLS['fgk'.'2'.'2']; // K
			$cSCLS[$i][7]=$dSCLS['fgs'.'2'.'2']; // S
		}
		
		//art
		$qART	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='ART' "; // menghasilkan nilai avehw art
		$rART =mysql_query($qART) or die('Query gagal5');
		while($dART =mysql_fetch_array($rART))
		{
			$cART[$i][0]=$dART['st'.'2'.'1'."9"]; // K
			$cART[$i][1]=$dART['st_'.'2'.'1'."9"]; // S
			
			$cART[$i][2]=$dART['st'.'2'.'2'."9"]; // K
			$cART[$i][3]=$dART['st_'.'2'.'2'."9"]; // S
			
			$cART[$i][4]=$dART['fgk'.'2'.'1']; // K
			$cART[$i][5]=$dART['fgs'.'2'.'1']; // S
			
			$cART[$i][6]=$dART['fgk'.'2'.'2']; // K
			$cART[$i][7]=$dART['fgs'.'2'.'2']; // S
		}
		
		//com
		$qCOM	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='COM' "; // menghasilkan nilai avehw com
		$rCOM =mysql_query($qCOM) or die('Query gagal5');
		while($dCOM =mysql_fetch_array($rCOM))
		{
			$cCOM[$i][0]=$dCOM['st'.'2'.'1'."9"]; // K
			$cCOM[$i][1]=$dCOM['st_'.'2'.'1'."9"]; // S
			
			$cCOM[$i][2]=$dCOM['st'.'2'.'2'."9"]; // K
			$cCOM[$i][3]=$dCOM['st_'.'2'.'2'."9"]; // S
			
			$cCOM[$i][4]=$dCOM['fgk'.'2'.'1']; // K
			$cCOM[$i][5]=$dCOM['fgs'.'2'.'1']; // S
			
			$cCOM[$i][6]=$dCOM['fgk'.'2'.'2']; // K
			$cCOM[$i][7]=$dCOM['fgs'.'2'.'2']; // S
		}
		
		//pe
		$qPE	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='PE' "; // menghasilkan nilai avehw pe
		$rPE =mysql_query($qPE) or die('Query gagal5');
		while($dPE =mysql_fetch_array($rPE))
		{
			$cPE[$i][0]=$dPE['st'.'2'.'1'."9"]; // K
			$cPE[$i][1]=$dPE['st_'.'2'.'1'."9"]; // S
			
			$cPE[$i][2]=$dPE['st'.'2'.'2'."9"]; // K
			$cPE[$i][3]=$dPE['st_'.'2'.'2'."9"]; // S
			
			$cPE[$i][4]=$dPE['fgk'.'2'.'1']; // K
			$cPE[$i][5]=$dPE['fgs'.'2'.'1']; // S
			
			$cPE[$i][6]=$dPE['fgk'.'2'.'2']; // K
			$cPE[$i][7]=$dPE['fgs'.'2'.'2']; // S
		}
		
		//eng
		$qENG	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='ENG' "; // menghasilkan nilai avehw eng
		$rENG =mysql_query($qENG) or die('Query gagal5');
		while($dENG =mysql_fetch_array($rENG))
		{
			$cENG[$i][0]=$dENG['st'.'2'.'1'."9"]; // K
			$cENG[$i][1]=$dENG['st_'.'2'.'1'."9"]; // S
			
			$cENG[$i][2]=$dENG['st'.'2'.'2'."9"]; // K
			$cENG[$i][3]=$dENG['st_'.'2'.'2'."9"]; // S
			
			$cENG[$i][4]=$dENG['fgk'.'2'.'1']; // K
			$cENG[$i][5]=$dENG['fgs'.'2'.'1']; // S
			
			$cENG[$i][6]=$dENG['fgk'.'2'.'2']; // K
			$cENG[$i][7]=$dENG['fgs'.'2'.'2']; // S
		}
		
		//mnd
		$qMND	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='MND' "; // menghasilkan nilai avehw mnd
		$rMND =mysql_query($qMND) or die('Query gagal5');
		while($dMND =mysql_fetch_array($rMND))
		{
			$cMND[$i][0]=$dMND['st'.'2'.'1'."9"]; // K
			$cMND[$i][1]=$dMND['st_'.'2'.'1'."9"]; // S
			
			$cMND[$i][2]=$dMND['st'.'2'.'2'."9"]; // K
			$cMND[$i][3]=$dMND['st_'.'2'.'2'."9"]; // S
			
			$cMND[$i][4]=$dMND['fgk'.'2'.'1']; // K
			$cMND[$i][5]=$dMND['fgs'.'2'.'1']; // S
			
			$cMND[$i][6]=$dMND['fgk'.'2'.'2']; // K
			$cMND[$i][7]=$dMND['fgs'.'2'.'2']; // S
		}
		
		$i++;
	}
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	
	$ttlAVErlg=0;
	$ttlAVEcme=0;
	$ttlAVEbin=0;
	$ttlAVEmth=0;
	$ttlAVEscn=0;
	$ttlAVEscls=0;
	$ttlAVEart=0;
	$ttlAVEcom=0;
	$ttlAVEpe=0;
	
	$jmlssw=0;
	$x=1;
	
	$maxRLG =0;
	$minRLG =0;
	$maxCME =0;
	$minCME =0;
	$maxBIN =0;
	$minBIN =0;
	$maxMTH =0;
	$minMTH =0;
	$maxSCN =0;
	$minSCN =0;
	$maxSCLS =0;
	$minSCLS =0;
	$maxART =0;
	$minART =0;
	$maxCOM =0;
	$minCOM =0;
	$maxPE =0;
	$minPE =0;
	
	while($j<$i AND $x<=30)
	{
		//rlg
		$q1RLG = ($cRLG[$j][4] + $cRLG[$j][5])/2;
		$q2RLG = ($cRLG[$j][6] + $cRLG[$j][7])/2;
		$avRLG = ( $q1RLG + $q2RLG ) / 2;
		if( $maxRLG == 0 )
			$maxRLG = $avRLG;
		else 
		{
			if( $maxRLG < $avRLG )
			$maxRLG = $avRLG;
		}
		if( $minRLG == 0 )
			$minRLG = $avRLG;
		else 
		{
			if( $minRLG > $avRLG )
			$minRLG = $avRLG;
		}
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4, $q1RLG,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4, $q2RLG,'LRTB',0,C,true);
		$pdf->SetFillColor(255,165,165);
		$pdf->Cell( 1	,0.4, $avRLG,'LRTB',0,C,true);
		
		
		
		//cme
		$q1CME = ($cCME[$j][4] + $cCME[$j][5])/2;
		$q2CME = ($cCME[$j][6] + $cCME[$j][7])/2;
		$avCME = ( $q1CME + $q2CME ) / 2;
		if( $maxCME == 0 )
			$maxCME = $avCME;
		else 
		{
			if( $maxCME < $avCME )
			$maxCME = $avCME;
		}
		
		if( $minCME == 0 )
			$minCME = $avCME;
		else 
		{
			if( $minCME > $avCME )
			$minCME = $avCME;
		}
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4, $q1CME,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4, $q2CME,'LRTB',0,C,true);
		$pdf->SetFillColor(255,165,165);
		$pdf->Cell( 1	,0.4, $avCME,'LRTB',0,C,true);
		
		
		
		//bin
		$q1BIN = ($cBIN[$j][4] + $cBIN[$j][5])/2;
		$q2BIN = ($cBIN[$j][6] + $cBIN[$j][7])/2;
		$avBIN = ( $q1BIN + $q2BIN ) / 2;
		if( $maxBIN == 0 )
			$maxBIN = $avBIN;
		else 
		{
			if( $maxBIN < $avBIN )
			$maxBIN = $avBIN;
		}
		
		if( $minBIN == 0 )
			$minBIN = $avBIN;
		else 
		{
			if( $minBIN > $avBIN )
			$minBIN = $avBIN;
		}
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4, $q1BIN,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4, $q2BIN,'LRTB',0,C,true);
		$pdf->SetFillColor(255,165,165);
		$pdf->Cell( 1	,0.4, $avBIN,'LRTB',0,C,true);
		
		
		
		//mth
		$q1MTH = ($cMTH[$j][4] + $cMTH[$j][5])/2;
		$q2MTH = ($cMTH[$j][6] + $cMTH[$j][7])/2;
		$avMTH = ( $q1MTH + $q2MTH ) / 2;
		if( $maxMTH == 0 )
			$maxMTH = $avMTH;
		else 
		{
			if( $maxMTH < $avMTH )
			$maxMTH = $avMTH;
		}
		
		if( $minMTH == 0 )
			$minMTH = $avMTH;
		else 
		{
			if( $minMTH > $avMTH )
			$minMTH = $avMTH;
		}
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4, $q1MTH,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4, $q2MTH,'LRTB',0,C,true);
		$pdf->SetFillColor(255,165,165);
		$pdf->Cell( 1	,0.4, $avMTH,'LRTB',0,C,true);
		
		
		
		//scn
		$q1SCN = ($cSCN[$j][4] + $cSCN[$j][5])/2;
		$q2SCN = ($cSCN[$j][6] + $cSCN[$j][7])/2;
		$avSCN = ( $q1SCN + $q2SCN ) / 2;
		if( $maxSCN == 0 )
			$maxSCN = $avSCN;
		else 
		{
			if( $maxSCN < $avSCN )
			$maxSCN = $avSCN;
		}
		
		if( $minSCN == 0 )
			$minSCN = $avSCN;
		else 
		{
			if( $minSCN > $avSCN )
			$minSCN = $avSCN;
		}
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4, $q1SCN,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4, $q2SCN,'LRTB',0,C,true);
		$pdf->SetFillColor(255,165,165);
		$pdf->Cell( 1	,0.4, $avSCN,'LRTB',0,C,true);
		
		
		
		//scls
		$q1SCLS = ($cSCLS[$j][4] + $cSCLS[$j][5])/2;
		$q2SCLS = ($cSCLS[$j][6] + $cSCLS[$j][7])/2;
		$avSCLS = ( $q1SCLS + $q2SCLS ) / 2;
		if( $maxSCLS == 0 )
			$maxSCLS = $avSCLS;
		else 
		{
			if( $maxSCLS < $avSCLS )
			$maxSCLS = $avSCLS;
		}
		
		if( $minSCLS == 0 )
			$minSCLS = $avSCLS;
		else 
		{
			if( $minSCLS > $avSCLS )
			$minSCLS = $avSCLS;
		}
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4, $q1SCLS,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4, $q2SCLS,'LRTB',0,C,true);
		$pdf->SetFillColor(255,165,165);
		$pdf->Cell( 1	,0.4, $avSCLS,'LRTB',0,C,true);
		
		
		
		//art
		$q1ART = ($cART[$j][4] + $cART[$j][5])/2;
		$q2ART = ($cART[$j][6] + $cART[$j][7])/2;
		$avART = ( $q1ART + $q2ART ) / 2;
		if( $maxART == 0 )
			$maxART = $avART;
		else 
		{
			if( $maxART < $avART )
			$maxART = $avART;
		}
		
		if( $minART == 0 )
			$minART = $avART;
		else 
		{
			if( $minART > $avART )
			$minART = $avART;
		}
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4, $q1ART,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4, $q2ART,'LRTB',0,C,true);
		$pdf->SetFillColor(255,165,165);
		$pdf->Cell( 1	,0.4, $avART,'LRTB',0,C,true);
		
		
		
		//com
		$q1COM = ($cCOM[$j][4] + $cCOM[$j][5])/2;
		$q2COM = ($cCOM[$j][6] + $cCOM[$j][7])/2;
		$avCOM = ( $q1COM + $q2COM ) / 2;
		if( $maxCOM == 0 )
			$maxCOM = $avCOM;
		else 
		{
			if( $maxCOM < $avCOM )
			$maxCOM = $avCOM;
		}
		
		if( $minCOM == 0 )
			$minCOM = $avCOM;
		else 
		{
			if( $minCOM > $avCOM )
			$minCOM = $avCOM;
		}
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4, $q1COM,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4, $q2COM,'LRTB',0,C,true);
		$pdf->SetFillColor(255,165,165);
		$pdf->Cell( 1	,0.4, $avCOM,'LRTB',0,C,true);
		
		
		
		//pe
		$q1PE = ($cPE[$j][4] + $cPE[$j][5])/2;
		$q2PE = ($cPE[$j][6] + $cPE[$j][7])/2;
		$avPE = ( $q1PE + $q2PE ) / 2;
		if( $maxPE == 0 )
			$maxPE = $avPE;
		else 
		{
			if( $maxPE < $avPE )
			$maxPE = $avPE;
		}
		
		if( $minPE == 0 )
			$minPE = $avPE;
		else 
		{
			if( $minPE > $avPE )
			$minPE = $avPE;
		}
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4, $q1PE,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4, $q2PE,'LRTB',0,C,true);
		$pdf->SetFillColor(255,165,165);
		$pdf->Cell( 1	,0.4, $avPE,'LRTB',0,C,true);
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		$ttlAVErlg = $ttlAVErlg + $avRLG;
		$ttlAVEcme = $ttlAVEcme + $avCME;
		$ttlAVEbin = $ttlAVEbin + $avBIN;
		$ttlAVEmth = $ttlAVEmth + $avMTH;
		$ttlAVEscn = $ttlAVEscn + $avSCN;
		$ttlAVEscls = $ttlAVEscls + $avSCLS;
		$ttlAVEart = $ttlAVEart + $avART;
		$ttlAVEcom = $ttlAVEcom + $avCOM;
		$ttlAVEpe = $ttlAVEpe + $avPE;
		
		$jmlssw++;
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);
	
	$aveRLG = number_format( $ttlAVErlg / $jmlssw ,1,',','.');
	$aveCME = number_format( $ttlAVEcme / $jmlssw ,1,',','.');
	$aveBIN = number_format( $ttlAVEbin / $jmlssw ,1,',','.');
	$aveMTH = number_format( $ttlAVEmth / $jmlssw ,1,',','.');
	$aveSCN = number_format( $ttlAVEscn / $jmlssw ,1,',','.');
	$aveSCLS = number_format( $ttlAVEscls / $jmlssw ,1,',','.');
	$aveART = number_format( $ttlAVEart / $jmlssw ,1,',','.');
	$aveCOM = number_format( $ttlAVEcom / $jmlssw ,1,',','.');
	$avePE = number_format( $ttlAVEpe / $jmlssw ,1,',','.');
	
	//rlg
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'AV','',0,C,true);
	$pdf->SetFillColor(230,230,250);
	$pdf->Cell( 1	,0.4, $aveRLG,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//cme
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'AV','',0,C,true);
	$pdf->SetFillColor(230,230,250);
	$pdf->Cell( 1	,0.4, $aveCME,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//bin
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'AV','',0,C,true);
	$pdf->SetFillColor(230,230,250);
	$pdf->Cell( 1	,0.4, $aveBIN,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//mth
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'AV','',0,C,true);
	$pdf->SetFillColor(230,230,250);
	$pdf->Cell( 1	,0.4, $aveMTH,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//scn
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'AV','',0,C,true);
	$pdf->SetFillColor(230,230,250);
	$pdf->Cell( 1	,0.4, $aveSCN,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//scls
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'AV','',0,C,true);
	$pdf->SetFillColor(230,230,250);
	$pdf->Cell( 1	,0.4, $aveSCLS,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//art
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'AV','',0,C,true);
	$pdf->SetFillColor(230,230,250);
	$pdf->Cell( 1	,0.4, $aveART,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//com
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'AV','',0,C,true);
	$pdf->SetFillColor(230,230,250);
	$pdf->Cell( 1	,0.4, $aveCOM,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//pe
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'AV','',0,C,true);
	$pdf->SetFillColor(230,230,250);
	$pdf->Cell( 1	,0.4, $avePE,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->Ln();
	
	//rlg
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Max','',0,C,true);
	$pdf->SetFillColor(0,0,255);
	$pdf->Cell( 1	,0.4,$maxRLG,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//cme
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Max','',0,C,true);
	$pdf->SetFillColor(0,0,255);
	$pdf->Cell( 1	,0.4,$maxCME,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//bin
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Max','',0,C,true);
	$pdf->SetFillColor(0,0,255);
	$pdf->Cell( 1	,0.4,$maxBIN,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//mth
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Max','',0,C,true);
	$pdf->SetFillColor(0,0,255);
	$pdf->Cell( 1	,0.4,$maxMTH,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//scn
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Max','',0,C,true);
	$pdf->SetFillColor(0,0,255);
	$pdf->Cell( 1	,0.4,$maxSCN,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//scls
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Max','',0,C,true);
	$pdf->SetFillColor(0,0,255);
	$pdf->Cell( 1	,0.4,$maxSCLS,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//art
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Max','',0,C,true);
	$pdf->SetFillColor(0,0,255);
	$pdf->Cell( 1	,0.4,$maxART,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//com
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Max','',0,C,true);
	$pdf->SetFillColor(0,0,255);
	$pdf->Cell( 1	,0.4,$maxCOM,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//pe
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Max','',0,C,true);
	$pdf->SetFillColor(0,0,255);
	$pdf->Cell( 1	,0.4,$maxPE,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	
	//rlg
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Min','',0,C,true);
	$pdf->SetFillColor(0,255,0);
	$pdf->Cell( 1	,0.4,$minRLG,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//cme
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Min','',0,C,true);
	$pdf->SetFillColor(0,255,0);
	$pdf->Cell( 1	,0.4,$minCME,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//bin
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Min','',0,C,true);
	$pdf->SetFillColor(0,255,0);
	$pdf->Cell( 1	,0.4,$minBIN,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//mth
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Min','',0,C,true);
	$pdf->SetFillColor(0,255,0);
	$pdf->Cell( 1	,0.4,$minMTH,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//scn
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Min','',0,C,true);
	$pdf->SetFillColor(0,255,0);
	$pdf->Cell( 1	,0.4,$minSCN,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//scls
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Min','',0,C,true);
	$pdf->SetFillColor(0,255,0);
	$pdf->Cell( 1	,0.4,$minSCLS,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//art
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Min','',0,C,true);
	$pdf->SetFillColor(0,255,0);
	$pdf->Cell( 1	,0.4,$minART,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//com
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Min','',0,C,true);
	$pdf->SetFillColor(0,255,0);
	$pdf->Cell( 1	,0.4,$minCOM,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//pe
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Min','',0,C,true);
	$pdf->SetFillColor(0,255,0);
	$pdf->Cell( 1	,0.4,$minPE,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//.. sampai sini
	
	
	$pdf->Ln();	
	
	
	// average
	

	// highest score
	

	// Lowest score
	
	
	// minimum requirement
	
	
	//} // end ..

	// below minimum requirement
	

	// Percentage below minimum requirement
	

	// Over minimum requirement
	
	
	// Percentage Over minimum requirement
	
	
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



//awal halaman 2

$j=0;
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
	
	$pdf->SetFillColor(255,255,255);//153,153,153
	
	
	
	$pdf->Ln();
	$pdf->Cell( 3	,0.5,'English','LRTB',0,C,true);
	$pdf->Cell( 3	,0.5,'Mandarin','LRTB',0,C,true);
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',6);
	$pdf->Cell( 1	,0.5,'Q3','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'Q4','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AV','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Cell( 1	,0.5,'Q3','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'Q4','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'AV','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
		
	
	$queryX 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND 
						
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; // menghasilkan semua siswa per kelas
	$resultX =mysql_query($queryX) or die('Query gagal5');
	$i=0;
	while($dataX =mysql_fetch_array($resultX))
	{
		$cellX[$i][0]=$dataX[nis];
		$cellX[$i][1]=$dataX[nmassw];
		$nis=$dataX[nis];
		
		
		
		$i++;
	}
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	
	$ttlAVEeng=0;
	$ttlAVEmnd=0;
	
	$jmlssw=0;
	$x=1;
	$no=1;
	
	$maxENG =0;
	$minENG =0;
	$maxMND =0;
	$minMND =0;
	
	while($j<$i AND $x<=30)
	{
		//eng
		$q1ENG = ($cENG[$j][0] + $cENG[$j][1])/2;
		$q2ENG = ($cENG[$j][2] + $cENG[$j][3])/2;
		$avENG = ( $q1ENG + $q2ENG ) / 2;
		if( $maxENG == 0 )
			$maxENG = $avENG;
		else 
		{
			if( $maxENG < $avENG )
			$maxENG = $avENG;
		}
		
		if( $minENG == 0 )
			$minENG = $avENG;
		else 
		{
			if( $minENG > $avENG )
			$minENG = $avENG;
		}
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4, $q1ENG,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4, $q2ENG,'LRTB',0,C,true);
		$pdf->SetFillColor(255,165,165);
		$pdf->Cell( 1	,0.4, $avENG,'LRTB',0,C,true);
		
		
		
		//mnd
		$q1MND = ($cMND[$j][0] + $cMND[$j][1])/2;
		$q2MND = ($cMND[$j][2] + $cMND[$j][3])/2;
		$avMND = ( $q1MND + $q2MND ) / 2;
		if( $maxMND == 0 )
			$maxMND = $avMND;
		else 
		{
			if( $maxMND < $avMND )
			$maxMND = $avMND;
		}
		
		if( $minMND == 0 )
			$minMND = $avMND;
		else 
		{
			if( $minMND > $avMND )
			$minMND = $avMND;
		}
		$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 1	,0.4, $q1MND,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4, $q2MND,'LRTB',0,C,true);
		$pdf->SetFillColor(255,165,165);
		$pdf->Cell( 1	,0.4, $avMND,'LRTB',0,C,true);
		
		
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		
		$ttlAVEeng = $ttlAVEeng + $avENG;
		$ttlAVEmnd = $ttlAVEmnd + $avMND;
		
		$jmlssw++;
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);
	
	$aveENG = number_format( $ttlAVEeng / $jmlssw ,1,',','.');
	$aveMND = number_format( $ttlAVEmnd / $jmlssw ,1,',','.');
	
	//eng
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'AV','',0,C,true);
	$pdf->SetFillColor(230,230,250);
	$pdf->Cell( 1	,0.4, $aveENG,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//mnd
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'AV','',0,C,true);
	$pdf->SetFillColor(230,230,250);
	$pdf->Cell( 1	,0.4, $aveMND,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->Ln();
	
	//eng
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Max','',0,C,true);
	$pdf->SetFillColor(0,0,255);
	$pdf->Cell( 1	,0.4,$maxENG,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//mnd
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Max','',0,C,true);
	$pdf->SetFillColor(0,0,255);
	$pdf->Cell( 1	,0.4,$maxMND,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	
	//eng
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Min','',0,C,true);
	$pdf->SetFillColor(0,255,0);
	$pdf->Cell( 1	,0.4,$minENG,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	//mnd
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell( 1	,0.4,'Min','',0,C,true);
	$pdf->SetFillColor(0,255,0);
	$pdf->Cell( 1	,0.4,$minMND,'',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	//.. sampai sini
	
	
	
	$pdf->Ln();	
	
	$query 	="	SELECT 		t_setpsrpt.* 
				FROM 		t_setpsrpt
				WHERE 		t_setpsrpt.kdetkt='". mysql_escape_string($kdetkt)."' 
				ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id ";
	$result =mysql_query($query);
	
	//$avekls[1][1];
	$avekls[0][1] = $ttlAVErlg / $jmlssw; // $aveRLG;
	$avekls[1][1] = $ttlAVEcme / $jmlssw; // $aveCME;
	$avekls[2][1] = $ttlAVEbin / $jmlssw; // $aveBIN;
	$avekls[3][1] = $ttlAVEmth / $jmlssw; // $aveMTH;
	$avekls[4][1] = $ttlAVEscn / $jmlssw; // $aveSCN;
	$avekls[5][1] = $ttlAVEscls / $jmlssw; // $aveSCLS;
	$avekls[6][1] = $ttlAVEart / $jmlssw; // $aveART;
	$avekls[7][1] = $ttlAVEcom / $jmlssw; // $aveCOM;
	$avekls[8][1] = $ttlAVEpe / $jmlssw; // $avePE;
	$avekls[9][1] = $ttlAVEeng / $jmlssw; // $aveENG;
	$avekls[10][1] = $ttlAVEmnd / $jmlssw; // $aveMND;
	
	//$maxkls[1][2];
	$maxkls[0][2] = $maxRLG;
	$maxkls[1][2] = $maxCME;
	$maxkls[2][2] = $maxBIN;
	$maxkls[3][2] = $maxMTH;
	$maxkls[4][2] = $maxSCN;
	$maxkls[5][2] = $maxSCLS;
	$maxkls[6][2] = $maxART;
	$maxkls[7][2] = $maxCOM;
	$maxkls[8][2] = $maxPE;
	$maxkls[9][2] = $maxENG;
	$maxkls[10][2] = $maxMND;
	
	//$minkls[1][3];
	$minkls[0][3] = $minRLG;
	$minkls[1][3] = $minCME;
	$minkls[2][3] = $minBIN;
	$minkls[3][3] = $minMTH;
	$minkls[4][3] = $minSCN;
	$minkls[5][3] = $minSCLS;
	$minkls[6][3] = $minART;
	$minkls[7][3] = $minCOM;
	$minkls[8][3] = $minPE;
	$minkls[9][3] = $minENG;
	$minkls[10][3] = $minMND;
	
	/*$ave		='avekls'."$sms";
	$max		='maxkls'."$sms";
	$min		='minkls'."$sms";
	
					"t_smscp_sd."."$ave"."	=	'". mysql_escape_string($avekls[$i][1])."',
					t_smscp_sd."."$max"."	=	'". mysql_escape_string($maxkls[$i][2])."',
					t_smscp_sd."."$min"."	=	'". mysql_escape_string($minkls[$i][3])."',"*/
	
	$i=0;
	while($data = mysql_fetch_array($result))
	{
		$kdeplj=$data[kdeplj];
		
		$set	="	SET	t_smscp_sd.kdekls='". mysql_escape_string($kdekls)."',
					t_smscp_sd.kdeplj='". mysql_escape_string($kdeplj)."',
					
					t_smscp_sd.avekls2	=	'". mysql_escape_string($avekls[$i][1])."',
					t_smscp_sd.maxkls2	=	'". mysql_escape_string($maxkls[$i][2])."',
					t_smscp_sd.minkls2	=	'". mysql_escape_string($minkls[$i][3])."',
					
					t_smscp_sd.kdeusr='". mysql_escape_string($userid)."',
					t_smscp_sd.tglrbh='". mysql_escape_string($tgl)."',
					t_smscp_sd.jamrbh='". mysql_escape_string($jam)."' 
					
					 ";

		$qry	=mysql_query("	SELECT 	t_smscp_sd.*
								FROM 	t_smscp_sd
								WHERE 	t_smscp_sd.kdekls='". mysql_escape_string($kdekls)."' and
										t_smscp_sd.kdeplj='". mysql_escape_string($kdeplj)."' 

										");
		$bny	=mysql_num_rows($qry);
					
		if($bny>0)	mysql_query("	UPDATE 	t_smscp_sd ".$set. 
								" 	WHERE 	t_smscp_sd.kdekls='". mysql_escape_string($kdekls)."' and
											t_smscp_sd.kdeplj='". mysql_escape_string($kdeplj)."' 

											");
		else		mysql_query("INSERT INTO t_smscp_sd ".$set);
		
		$i++;
	}
	
	
	
	// average
	

	// highest score
	

	// Lowest score
	
	
	// minimum requirement
	
	
	//} // end ..

	// below minimum requirement
	

	// Percentage below minimum requirement
	

	// Over minimum requirement
	
	
	// Percentage Over minimum requirement
	
	
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
		$pdf->Cell(  4	,0.4," Page : 2",'',0,R,true);//
	} 
//};
$pdf->Output();
?>