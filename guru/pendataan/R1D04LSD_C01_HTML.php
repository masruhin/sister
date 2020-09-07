<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LSD_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
/*
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
*/

$kdeplj	=$_POST['kdeplj'];
$kdekls	=$_POST['kdekls'];
$sms	=$_POST['sms'];
$midtrm	=$_POST['midtrm'];
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



if($sms=='1')
	$nmasms='FIRST SEMESTER ';
else
	$nmasms='SECOND SEMESTER ';
$judul2=$nmasms.'LEDGER REPORT '.$midtrm;//MASTER SHEET



//AWAL BUATAN BARU
echo"
<html>
    <head>
        <style>
            @media print {
                .parent {
                    overflow: none;
                    display: block;
                }
                .pb_after  { page-break-after: always !important; }
            } 
        </style>
        <script>
            setTimeout(function() {
                window.print();
            }, 1000);
        </script>
    </head>
    <body>
        <div class='parent'>
			<div class='pb_after'>
                <!--Awal Halaman 1-->
					<table width='100%'>
						<tr>
							<td align='left'>
								<img src='../../images/logo_sd.jpg'/>
							</td>
							<td align='center'>
								<h2>
									<b>SAINT JOHN'S PRIMARY SCHOOL</b>
								</h2>
								<h3>
									$judul2<!--SEMESTER GRADING SHEET REPORT-->
								</h3>
							</td>
							<td align='right'>
								<img src='../../images/tutwurihandayani.jpg' height='80px' width='80px'/>
							</td>
						</tr>
					</table>
					
					<br/>
					
					
				
";
//AKHIR BUATAN BARU



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

//$logo_pt	="../../images/logo_sd.jpg";//logo.jpg
//$logo_ttw	="../../images/tutwurihandayani.jpg";

/*
$pdf =new FPDF('P','cm','A4');
$pdf->SetMargins(1,0.4,1);
$pdf->SetAutoPageBreak(True, 0.4);
*/



$query 	="	SELECT 		t_setpsrpt.* 
			FROM 		t_setpsrpt
			WHERE 		t_setpsrpt.kdetkt='". mysql_escape_string($kdetkt)."' 
			ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id"; // menghasikan subjek per unit
$result =mysql_query($query) or die('Query gagal setpsrpt');
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
					LIMIT		1,1"; 
					// menghasilkan data satu siswa
		$result2 =mysql_query($query2) or die('Query gagal menghasilkan data satu siswa');
		$data2 	=mysql_fetch_array($result2);
		$nis	=$data2[nis];
		
		$query3 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sd.nis,t_prgrptps_sd.kdeplj"; 
						// menghasilkan nilai satu siswa per subjek
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
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; 
			// menghasilkan semua siswa per kelas
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
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sd.nis,t_prgrptps_sd.kdeplj"; 
						// menghasilkan nilai per siswa per subjek
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
	//AWAL BUATAN BARU
		echo"
			<table width='100%'>
				<tr>
					<th align='left'>
						Grade : $kdekls
					</th>
					<th align='center'>
						
					</th>
					<th align='right'>
						
					</th>
				</tr>
			</table>
			<table width='100%' border='1' style='border-collapse: collapse;'>
				<tr bgcolor=''>
					<th align='center' rowspan='3'>
						<b>No</b>
					</th>
					<th align='center' rowspan='3'>
						<b>SN</b>
					</th>
					<th align='center' rowspan='3'>
						<b>Name <BR/> of <br/> Student</b>
					</th>
					<th align='center' rowspan='3'>
						<b>BIRTHDAY</b>
					</th>
					
					<th align='center' colspan='44'>
						<b>SUBJECT</b>
					</th>
					
					<th align='center' colspan='3' rowspan='2'>
						<b>AVE / STU</b>
					</th>
				</tr>
				<tr bgcolor=''><!--lightgrey-->
					<th align='center' colspan='4'>
						Religion
					</th>
					<th align='center' colspan='4'>
						CME
					</th>
					<th align='center' colspan='4'>
						Bahasa Indonesia
					</th>
					<th align='center' colspan='4'>
						Maths
					</th>
					<th align='center' colspan='4'>
						Science
					</th>
					<th align='center' colspan='4'>
						Soc. Studies
					</th>
					<th align='center' colspan='4'>
						Cultural Art
					</th>
					<th align='center' colspan='4'>
						IT
					</th>
					<th align='center' colspan='4'>
						PE
					</th>
					<th align='center' colspan='4'>
						English
					</th>
					<th align='center' colspan='4'>
						Mandarin
					</th>
				</tr>
				<tr>
					<th align='center'>K</th><th align='center'>S</th><th align='center' bgcolor='pink'>AVE</th><th align='center' bgcolor='lightblue'>ATT</th>
					<th align='center'>K</th><th align='center'>S</th><th align='center' bgcolor='pink'>AVE</th><th align='center' bgcolor='lightblue'>ATT</th>
					<th align='center'>K</th><th align='center'>S</th><th align='center' bgcolor='pink'>AVE</th><th align='center' bgcolor='lightblue'>ATT</th>
					<th align='center'>K</th><th align='center'>S</th><th align='center' bgcolor='pink'>AVE</th><th align='center' bgcolor='lightblue'>ATT</th>
					<th align='center'>K</th><th align='center'>S</th><th align='center' bgcolor='pink'>AVE</th><th align='center' bgcolor='lightblue'>ATT</th>
					<th align='center'>K</th><th align='center'>S</th><th align='center' bgcolor='pink'>AVE</th><th align='center' bgcolor='lightblue'>ATT</th>
					<th align='center'>K</th><th align='center'>S</th><th align='center' bgcolor='pink'>AVE</th><th align='center' bgcolor='lightblue'>ATT</th>
					<th align='center'>K</th><th align='center'>S</th><th align='center' bgcolor='pink'>AVE</th><th align='center' bgcolor='lightblue'>ATT</th>
					<th align='center'>K</th><th align='center'>S</th><th align='center' bgcolor='pink'>AVE</th><th align='center' bgcolor='lightblue'>ATT</th>
					<th align='center'>K</th><th align='center'>S</th><th align='center' bgcolor='pink'>AVE</th><th align='center' bgcolor='lightblue'>ATT</th>
					<th align='center'>K</th><th align='center'>S</th><th align='center' bgcolor='pink'>AVE</th><th align='center' bgcolor='lightblue'>ATT</th>
					
					<th align='center'>K</th><th align='center'>S</th><th align='center' bgcolor='pink'>AVE</th>
				</tr>
			
		";
		//AKHIR BUATAN BARU
	
	
		
	
	
	$queryX 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND 
						
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; 
			// menghasilkan semua siswa per kelas
	$resultX =mysql_query($queryX) or die('Query gagal5');
	$i=0;
	while($dataX =mysql_fetch_array($resultX))
	{
		$cellX[$i][0]=$dataX[nis];
		$cellX[$i][1]=$dataX[nmassw];
		$cellX[$i][10]=$dataX[tgllhr];
		$nis=$dataX[nis];
		
		//rlg
		$qRLG	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='RLG' "; 
									// menghasilkan nilai avehw rlg
		$rRLG =mysql_query($qRLG) or die('Query gagal5');
		while($dRLG =mysql_fetch_array($rRLG))
		{
			$cRLG[$i][0]=$dRLG['st'."$sms"."$midtrm"."9"]; // K
			$cRLG[$i][1]=$dRLG['st_'."$sms"."$midtrm"."9"]; // S
			$cRLG[$i][2]=$dRLG['akh'."$sms"."$midtrm"];
			$cRLG[$i][3]=$dRLG['fgk'."$sms"."$midtrm"];
			$cRLG[$i][4]=$dRLG['fgs'."$sms"."$midtrm"];
		}
		
		//cme
		$qCME	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='CME' "; 
									// menghasilkan nilai avehw cme
		$rCME =mysql_query($qCME) or die('Query gagal5');
		while($dCME =mysql_fetch_array($rCME))
		{
			$cCME[$i][0]=$dCME['st'."$sms"."$midtrm"."9"]; // K
			$cCME[$i][1]=$dCME['st_'."$sms"."$midtrm"."9"]; // S
			$cCME[$i][2]=$dCME['akh'."$sms"."$midtrm"];
			$cCME[$i][3]=$dCME['fgk'."$sms"."$midtrm"];
			$cCME[$i][4]=$dCME['fgs'."$sms"."$midtrm"];
		}
		
		//bin
		$qBIN	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='BIN' "; 
									// menghasilkan nilai avehw bin
		$rBIN =mysql_query($qBIN) or die('Query gagal5');
		while($dBIN =mysql_fetch_array($rBIN))
		{
			$cBIN[$i][0]=$dBIN['st'."$sms"."$midtrm"."9"]; // K
			$cBIN[$i][1]=$dBIN['st_'."$sms"."$midtrm"."9"]; // S
			$cBIN[$i][2]=$dBIN['akh'."$sms"."$midtrm"];
			$cBIN[$i][3]=$dBIN['fgk'."$sms"."$midtrm"];
			$cBIN[$i][4]=$dBIN['fgs'."$sms"."$midtrm"];
		}
		
		//mth
		$qMTH	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='MTH' "; //'MAT'	
									// menghasilkan nilai avehw mth
		$rMTH =mysql_query($qMTH) or die('Query gagal5');
		while($dMTH =mysql_fetch_array($rMTH))
		{
			$cMTH[$i][0]=$dMTH['st'."$sms"."$midtrm"."9"]; // K
			$cMTH[$i][1]=$dMTH['st_'."$sms"."$midtrm"."9"]; // S
			$cMTH[$i][2]=$dMTH['akh'."$sms"."$midtrm"];
			$cMTH[$i][3]=$dMTH['fgk'."$sms"."$midtrm"];
			$cMTH[$i][4]=$dMTH['fgs'."$sms"."$midtrm"];
		}
		
		//scn
		$qSCN	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='SCN' "; //'IPA'	
									// menghasilkan nilai avehw scn
		$rSCN =mysql_query($qSCN) or die('Query gagal5');
		while($dSCN =mysql_fetch_array($rSCN))
		{
			$cSCN[$i][0]=$dSCN['st'."$sms"."$midtrm"."9"]; // K
			$cSCN[$i][1]=$dSCN['st_'."$sms"."$midtrm"."9"]; // S
			$cSCN[$i][2]=$dSCN['akh'."$sms"."$midtrm"];
			$cSCN[$i][3]=$dSCN['fgk'."$sms"."$midtrm"];
			$cSCN[$i][4]=$dSCN['fgs'."$sms"."$midtrm"];
		}
		
		//scls
		$qSCLS	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='SCLS' "; //'IPS'		
									// menghasilkan nilai avehw scls
		$rSCLS =mysql_query($qSCLS) or die('Query gagal5');
		while($dSCLS =mysql_fetch_array($rSCLS))
		{
			$cSCLS[$i][0]=$dSCLS['st'."$sms"."$midtrm"."9"]; // K
			$cSCLS[$i][1]=$dSCLS['st_'."$sms"."$midtrm"."9"]; // S
			$cSCLS[$i][2]=$dSCLS['akh'."$sms"."$midtrm"];
			$cSCLS[$i][3]=$dSCLS['fgk'."$sms"."$midtrm"];
			$cSCLS[$i][4]=$dSCLS['fgs'."$sms"."$midtrm"];
		}
		
		//art
		$qART	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='ART' "; 
									// menghasilkan nilai avehw art
		$rART =mysql_query($qART) or die('Query gagal5');
		while($dART =mysql_fetch_array($rART))
		{
			$cART[$i][0]=$dART['st'."$sms"."$midtrm"."9"]; // K
			$cART[$i][1]=$dART['st_'."$sms"."$midtrm"."9"]; // S
			$cART[$i][2]=$dART['akh'."$sms"."$midtrm"];
			$cART[$i][3]=$dART['fgk'."$sms"."$midtrm"];
			$cART[$i][4]=$dART['fgs'."$sms"."$midtrm"];
		}
		
		//com
		$qCOM	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='COM' "; 
									// menghasilkan nilai avehw com
		$rCOM =mysql_query($qCOM) or die('Query gagal5');
		while($dCOM =mysql_fetch_array($rCOM))
		{
			$cCOM[$i][0]=$dCOM['st'."$sms"."$midtrm"."9"]; // K
			$cCOM[$i][1]=$dCOM['st_'."$sms"."$midtrm"."9"]; // S
			$cCOM[$i][2]=$dCOM['akh'."$sms"."$midtrm"];
			$cCOM[$i][3]=$dCOM['fgk'."$sms"."$midtrm"];
			$cCOM[$i][4]=$dCOM['fgs'."$sms"."$midtrm"];
		}
		
		//pe
		$qPE	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='PE' "; 
									// menghasilkan nilai avehw pe
		$rPE =mysql_query($qPE) or die('Query gagal5');
		while($dPE =mysql_fetch_array($rPE))
		{
			$cPE[$i][0]=$dPE['st'."$sms"."$midtrm"."9"]; // K
			$cPE[$i][1]=$dPE['st_'."$sms"."$midtrm"."9"]; // S
			$cPE[$i][2]=$dPE['akh'."$sms"."$midtrm"];
			$cPE[$i][3]=$dPE['fgk'."$sms"."$midtrm"];
			$cPE[$i][4]=$dPE['fgs'."$sms"."$midtrm"];
		}
		
		//eng
		$qENG	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='ENG' "; 
									// menghasilkan nilai avehw eng
		$rENG =mysql_query($qENG) or die('Query gagal5');
		while($dENG =mysql_fetch_array($rENG))
		{
			$cENG[$i][0]=$dENG['st'."$sms"."$midtrm"."9"]; // K
			$cENG[$i][1]=$dENG['st_'."$sms"."$midtrm"."9"]; // S
			$cENG[$i][2]=$dENG['akh'."$sms"."$midtrm"];
			$cENG[$i][3]=$dENG['fgk'."$sms"."$midtrm"];
			$cENG[$i][4]=$dENG['fgs'."$sms"."$midtrm"];
		}
		
		//mnd
		$qMND	 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
									t_prgrptps_sd.kdeplj='MND' "; //'MAN'		
									// menghasilkan nilai avehw mnd
		$rMND =mysql_query($qMND) or die('Query gagal5');
		while($dMND =mysql_fetch_array($rMND))
		{
			$cMND[$i][0]=$dMND['st'."$sms"."$midtrm"."9"]; // K
			$cMND[$i][1]=$dMND['st_'."$sms"."$midtrm"."9"]; // S
			$cMND[$i][2]=$dMND['akh'."$sms"."$midtrm"];
			$cMND[$i][3]=$dMND['fgk'."$sms"."$midtrm"];
			$cMND[$i][4]=$dMND['fgs'."$sms"."$midtrm"];
		}
		
		$i++;
	}
	
	/*
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	*/
	
	//$ttlSTKrlg=0;
	//$ttlSTSrlg=0;
	
	//$jmlssw=0;
	$j=0;
	$x=1;
	
	while($j<$i AND $x<=30)
	{
		$affRLG=$cRLG[$j][2];
		$affCME=$cCME[$j][2];
		$affBIN=$cBIN[$j][2];
		$affMTH=$cMTH[$j][2];
		$affSCN=$cSCN[$j][2];
		$affSCLS=$cSCLS[$j][2];
		$affART=$cART[$j][2];
		$affCOM=$cCOM[$j][2];
		$affPE=$cPE[$j][2];
		$affENG=$cENG[$j][2];
		$affMND=$cMND[$j][2];
		
		if ( $affRLG >= 90.00 AND $affRLG <= 100.00 )
			$lgRLG = 'A';
		else if ( $affRLG >= 80.00 AND $affRLG <= 89.99 )
			$lgRLG = 'B';
		else if ( $affRLG >= 70.00 AND $affRLG <= 79.99 )
			$lgRLG = 'C';
		else if ( $affRLG >= 0.00 AND $affRLG <= 69.99 )
			$lgRLG = 'D';
		else
			$lgRLG = 'ERR';
		
		/*if($affRLG>100)
			$lgRLG = 'ERR';
		else if($affRLG>=91.5)
			$lgRLG = 'A';
		else if($affRLG>=83.25)
			$lgRLG = 'A-';
		else if($affRLG>=75)
			$lgRLG = 'B+';
		else if($affRLG>=66.5)
			$lgRLG = 'B';
		else if($affRLG>=58.25)
			$lgRLG = 'B-';
		else if($affRLG>=41.5)
			$lgRLG = "C";
		else if($affRLG>=33.25)
			$lgRLG = "C-";
		else //if($affRLG>=25)
			$lgRLG = "D+";*/
		
		if ( $affCME >= 90.00 AND $affCME <= 100.00 )
			$lgCME = 'A';
		else if ( $affCME >= 80.00 AND $affCME <= 89.99 )
			$lgCME = 'B';
		else if ( $affCME >= 70.00 AND $affCME <= 79.99 )
			$lgCME = 'C';
		else if ( $affCME >= 0.00 AND $affCME <= 69.99 )
			$lgCME = 'D';
		else
			$lgCME = 'ERR';
		
		/*if($affCME>100)
			$lgCME = 'ERR';
		else if($affCME>=91.5)
			$lgCME = 'A';
		else if($affCME>=83.25)
			$lgCME = 'A-';
		else if($affCME>=75)
			$lgCME = 'B+';
		else if($affCME>=66.5)
			$lgCME = 'B';
		else if($affCME>=58.25)
			$lgCME = 'B-';
		else if($affCME>=41.5)
			$lgCME = "C";
		else if($affCME>=33.25)
			$lgCME = "C-";
		else //if($affCME>=25)
			$lgCME = "D+";*/
			
		if ( $affBIN >= 90.00 AND $affBIN <= 100.00 )
			$lgBIN = 'A';
		else if ( $affBIN >= 80.00 AND $affBIN <= 89.99 )
			$lgBIN = 'B';
		else if ( $affBIN >= 70.00 AND $affBIN <= 79.99 )
			$lgBIN = 'C';
		else if ( $affBIN >= 0.00 AND $affBIN <= 69.99 )
			$lgBIN = 'D';
		else
			$lgBIN = 'ERR';
		
		/*if($affBIN>100)
			$lgBIN = 'ERR';
		else if($affBIN>=91.5)
			$lgBIN = 'A';
		else if($affBIN>=83.25)
			$lgBIN = 'A-';
		else if($affBIN>=75)
			$lgBIN = 'B+';
		else if($affBIN>=66.5)
			$lgBIN = 'B';
		else if($affBIN>=58.25)
			$lgBIN = 'B-';
		else if($affBIN>=41.5)
			$lgBIN = "C";
		else if($affBIN>=33.25)
			$lgBIN = "C-";
		else //if($affBIN>=25)
			$lgBIN = "D+";*/
			
		if ( $affMTH >= 90.00 AND $affMTH <= 100.00 )
			$lgMTH = 'A';
		else if ( $affMTH >= 80.00 AND $affMTH <= 89.99 )
			$lgMTH = 'B';
		else if ( $affMTH >= 70.00 AND $affMTH <= 79.99 )
			$lgMTH = 'C';
		else if ( $affMTH >= 0.00 AND $affMTH <= 69.99 )
			$lgMTH = 'D';
		else
			$lgMTH = 'ERR';
		
		/*if($affMTH>100)
			$lgMTH = 'ERR';
		else if($affMTH>=91.5)
			$lgMTH = 'A';
		else if($affMTH>=83.25)
			$lgMTH = 'A-';
		else if($affMTH>=75)
			$lgMTH = 'B+';
		else if($affMTH>=66.5)
			$lgMTH = 'B';
		else if($affMTH>=58.25)
			$lgMTH = 'B-';
		else if($affMTH>=41.5)
			$lgMTH = "C";
		else if($affMTH>=33.25)
			$lgMTH = "C-";
		else //if($affMTH>=25)
			$lgMTH = "D+";*/
			
		if ( $affSCN >= 90.00 AND $affSCN <= 100.00 )
			$lgSCN = 'A';
		else if ( $affSCN >= 80.00 AND $affSCN <= 89.99 )
			$lgSCN = 'B';
		else if ( $affSCN >= 70.00 AND $affSCN <= 79.99 )
			$lgSCN = 'C';
		else if ( $affSCN >= 0.00 AND $affSCN <= 69.99 )
			$lgSCN = 'D';
		else
			$lgSCN = 'ERR';
		
		/*if($affSCN>100)
			$lgSCN = 'ERR';
		else if($affSCN>=91.5)
			$lgSCN = 'A';
		else if($affSCN>=83.25)
			$lgSCN = 'A-';
		else if($affSCN>=75)
			$lgSCN = 'B+';
		else if($affSCN>=66.5)
			$lgSCN = 'B';
		else if($affSCN>=58.25)
			$lgSCN = 'B-';
		else if($affSCN>=41.5)
			$lgSCN = "C";
		else if($affSCN>=33.25)
			$lgSCN = "C-";
		else //if($affSCN>=25)
			$lgSCN = "D+";*/
			
		if ( $affSCLS >= 90.00 AND $affSCLS <= 100.00 )
			$lgSCLS = 'A';
		else if ( $affSCLS >= 80.00 AND $affSCLS <= 89.99 )
			$lgSCLS = 'B';
		else if ( $affSCLS >= 70.00 AND $affSCLS <= 79.99 )
			$lgSCLS = 'C';
		else if ( $affSCLS >= 0.00 AND $affSCLS <= 69.99 )
			$lgSCLS = 'D';
		else
			$lgSCLS = 'ERR';
		
		/*if($affSCLS>100)
			$lgSCLS = 'ERR';
		else if($affSCLS>=91.5)
			$lgSCLS = 'A';
		else if($affSCLS>=83.25)
			$lgSCLS = 'A-';
		else if($affSCLS>=75)
			$lgSCLS = 'B+';
		else if($affSCLS>=66.5)
			$lgSCLS = 'B';
		else if($affSCLS>=58.25)
			$lgSCLS = 'B-';
		else if($affSCLS>=41.5)
			$lgSCLS = "C";
		else if($affSCLS>=33.25)
			$lgSCLS = "C-";
		else //if($affSCLS>=25)
			$lgSCLS = "D+";*/
			
		if ( $affART >= 90.00 AND $affART <= 100.00 )
			$lgART = 'A';
		else if ( $affART >= 80.00 AND $affART <= 89.99 )
			$lgART = 'B';
		else if ( $affART >= 70.00 AND $affART <= 79.99 )
			$lgART = 'C';
		else if ( $affART >= 0.00 AND $affART <= 69.99 )
			$lgART = 'D';
		else
			$lgART = 'ERR';
		
		/*if($affART>100)
			$lgART = 'ERR';
		else if($affART>=91.5)
			$lgART = 'A';
		else if($affART>=83.25)
			$lgART = 'A-';
		else if($affART>=75)
			$lgART = 'B+';
		else if($affART>=66.5)
			$lgART = 'B';
		else if($affART>=58.25)
			$lgART = 'B-';
		else if($affART>=41.5)
			$lgART = "C";
		else if($affART>=33.25)
			$lgART = "C-";
		else //if($affART>=25)
			$lgART = "D+";*/
			
		if ( $affCOM >= 90.00 AND $affCOM <= 100.00 )
			$lgCOM = 'A';
		else if ( $affCOM >= 80.00 AND $affCOM <= 89.99 )
			$lgCOM = 'B';
		else if ( $affCOM >= 70.00 AND $affCOM <= 79.99 )
			$lgCOM = 'C';
		else if ( $affCOM >= 0.00 AND $affCOM <= 69.99 )
			$lgCOM = 'D';
		else
			$lgCOM = 'ERR';
			
		/*if($affCOM>100)
			$lgCOM = 'ERR';
		else if($affCOM>=91.5)
			$lgCOM = 'A';
		else if($affCOM>=83.25)
			$lgCOM = 'A-';
		else if($affCOM>=75)
			$lgCOM = 'B+';
		else if($affCOM>=66.5)
			$lgCOM = 'B';
		else if($affCOM>=58.25)
			$lgCOM = 'B-';
		else if($affCOM>=41.5)
			$lgCOM = "C";
		else if($affCOM>=33.25)
			$lgCOM = "C-";
		else //if($affCOM>=25)
			$lgCOM = "D+";*/
			
		if ( $affPE >= 90.00 AND $affPE <= 100.00 )
			$lgPE = 'A';
		else if ( $affPE >= 80.00 AND $affPE <= 89.99 )
			$lgPE = 'B';
		else if ( $affPE >= 70.00 AND $affPE <= 79.99 )
			$lgPE = 'C';
		else if ( $affPE >= 0.00 AND $affPE <= 69.99 )
			$lgPE = 'D';
		else
			$lgPE = 'ERR';
			
		/*if($affPE>100)
			$lgPE = 'ERR';
		else if($affPE>=91.5)
			$lgPE = 'A';
		else if($affPE>=83.25)
			$lgPE = 'A-';
		else if($affPE>=75)
			$lgPE = 'B+';
		else if($affPE>=66.5)
			$lgPE = 'B';
		else if($affPE>=58.25)
			$lgPE = 'B-';
		else if($affPE>=41.5)
			$lgPE = "C";
		else if($affPE>=33.25)
			$lgPE = "C-";
		else //if($affPE>=25)
			$lgPE = "D+";*/
			
		if ( $affENG >= 90.00 AND $affENG <= 100.00 )
			$lgENG = 'A';
		else if ( $affENG >= 80.00 AND $affENG <= 89.99 )
			$lgENG = 'B';
		else if ( $affENG >= 70.00 AND $affENG <= 79.99 )
			$lgENG = 'C';
		else if ( $affENG >= 0.00 AND $affENG <= 69.99 )
			$lgENG = 'D';
		else
			$lgENG = 'ERR';
		
		/*if($affENG>100)
			$lgENG = 'ERR';
		else if($affENG>=91.5)
			$lgENG = 'A';
		else if($affENG>=83.25)
			$lgENG = 'A-';
		else if($affENG>=75)
			$lgENG = 'B+';
		else if($affENG>=66.5)
			$lgENG = 'B';
		else if($affENG>=58.25)
			$lgENG = 'B-';
		else if($affENG>=41.5)
			$lgENG = "C";
		else if($affENG>=33.25)
			$lgENG = "C-";
		else //if($affENG>=25)
			$lgENG = "D+";*/
			
		if ( $affMND >= 90.00 AND $affMND <= 100.00 )
			$lgMND = 'A';
		else if ( $affMND >= 80.00 AND $affMND <= 89.99 )
			$lgMND = 'B';
		else if ( $affMND >= 70.00 AND $affMND <= 79.99 )
			$lgMND = 'C';
		else if ( $affMND >= 0.00 AND $affMND <= 69.99 )
			$lgMND = 'D';
		else
			$lgMND = 'ERR';
			
		/*if($affMND>100)
			$lgMND = 'ERR';
		else if($affMND>=91.5)
			$lgMND = 'A';
		else if($affMND>=83.25)
			$lgMND = 'A-';
		else if($affMND>=75)
			$lgMND = 'B+';
		else if($affMND>=66.5)
			$lgMND = 'B';
		else if($affMND>=58.25)
			$lgMND = 'B-';
		else if($affMND>=41.5)
			$lgMND = "C";
		else if($affMND>=33.25)
			$lgMND = "C-";
		else //if($affMND>=25)
			$lgMND = "D+";*/
		
		$nis=$cell[$j][0];
		$tgllhr=$cellX[$j][10];
		$tgllhr	=strtotime($tgllhr);
		$tgllhr	=date('d-M-y',$tgllhr);
		
		/* lama
		$pdf->Cell( 0.4	,0.4,$no,'LRTB',0,C,true); // 0.6
		$pdf->SetFillColor(153,153,153);
		$pdf->Cell( 0.7	,0.4,substr($nis,0,3),'LRTB',0,C,true); // 1.4
		$pdf->Cell( 3.5	,0.4,$cellX[$j][1],'LRTB',0,L,true); // $t
		$pdf->Cell( 1.4	,0.4,$tgllhr,'LRTB',0,C,true);
		*/
		
		//AWAL BUATAN BARU
		$nis_d = $cellX[$j][1];
		
		echo"
			<tr>
				<td>
					$no
				</td>
				<td bgcolor='lightgrey'>
					$nis
				</td>
				<td bgcolor='lightgrey'>
					$nis_d
				</td>
				<td bgcolor='lightgrey'>
					$tgllhr
				</td>
		";
		//AKHIR BUATAN BARU
		
		
		
		//rlg
		/* lama
		$pdf->SetFillColor(255,255,255); 
		
		if( $cRLG[$j][3] < 75 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cRLG[$j][3],'LRTB',0,C,true);
		
		if( $cRLG[$j][4] < 75 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cRLG[$j][4],'LRTB',0,C,true);
		
		if( (($cRLG[$j][3] + $cRLG[$j][4])/2) < 75 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4, ($cRLG[$j][3] + $cRLG[$j][4])/2,'LRTB',0,C,true);
		
		$pdf->SetFillColor(229,229,229);
		$pdf->Cell( 0.5	,0.4,$lgRLG,'LRTB',0,C,true);
		*/
		
		//AWAL BUATAN BARU
		//RLG
		$cRLG_d3 = $cRLG[$j][3];
		$cRLG_d4 = $cRLG[$j][4];
		$cRLG_d34= ($cRLG[$j][3] + $cRLG[$j][4])/2;
		
		if( $cRLG_d3 < 70 )
		{
			if( $cRLG_d3 == 0 )
				$bgcolor_d3 = ''; 
			else
				$bgcolor_d3 = 'red'; 
		}
		else
		{
			$bgcolor_d3 = ''; 
		}
				
		if( $cRLG_d4 < 70 )
		{
			if( $cRLG_d4 == 0 )
				$bgcolor_d4 = ''; 
			else
				$bgcolor_d4 = 'red'; 
		}
		else
		{
			$bgcolor_d4 = '';  
		}
				
		if( $cRLG_d34 < 70 )
		{
			if( $cRLG_d34 == 0 )
				$bgcolor_d34 = 'pink'; 
			else
				$bgcolor_d34 = 'red'; 
		}
		else// if( $cRLG_d34 >= 70 )
		{
			$bgcolor_d34 = 'pink';  
		}
		
		echo"
				<td align='center' bgcolor='$bgcolor_d3'>
					$cRLG_d3
				</td>
				<td align='center' bgcolor='$bgcolor_d4'>
					$cRLG_d4
				</td>
				<td align='center' bgcolor='$bgcolor_d34'>
					$cRLG_d34
				</td>
				<td align='center' bgcolor='lightblue'>
					$lgRLG
				</td>
		";
		//AKHIR BUATAN BARU
		
		
		
		//cme
		/* lama
		$pdf->SetFillColor(255,255,255); 
		
		if( $cCME[$j][3] < 75 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cCME[$j][3],'LRTB',0,C,true);
		
		if( $cCME[$j][4] < 75 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cCME[$j][4],'LRTB',0,C,true);
		
		if( (($cCME[$j][3] + $cCME[$j][4])/2) < 75 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4, ($cCME[$j][3] + $cCME[$j][4])/2,'LRTB',0,C,true);
		
		$pdf->SetFillColor(229,229,229);
		$pdf->Cell( 0.5	,0.4,$lgCME,'LRTB',0,C,true);
		*/
		
		//AWAL BUATAN BARU
		//CME
		$cCME_d3 = $cCME[$j][3];
		$cCME_d4 = $cCME[$j][4];
		$cCME_d34= ($cCME[$j][3] + $cCME[$j][4])/2;
		
		if( $cCME_d3 < 70 )
		{
			if( $cCME_d3 == 0 )
				$bgcolor_d3 = ''; 
			else
				$bgcolor_d3 = 'red'; 
		}
		else
		{
			$bgcolor_d3 = ''; 
		}
				
		if( $cCME_d4 < 70 )
		{
			if( $cCME_d4 == 0 )
				$bgcolor_d4 = ''; 
			else
				$bgcolor_d4 = 'red'; 
		}
		else
		{
			$bgcolor_d4 = '';  
		}
				
		if( $cCME_d34 < 70 )
		{
			if( $cCME_d34 == 0 )
				$bgcolor_d34 = 'pink'; 
			else
				$bgcolor_d34 = 'red'; 
		}
		else// if( $cCME_d34 >= 70 )
		{
			$bgcolor_d34 = 'pink';  
		}
		
		echo"
				<td align='center' bgcolor='$bgcolor_d3'>
					$cCME_d3
				</td>
				<td align='center' bgcolor='$bgcolor_d4'>
					$cCME_d4
				</td>
				<td align='center' bgcolor='$bgcolor_d34'>
					$cCME_d34
				</td>
				<td align='center' bgcolor='lightblue'>
					$lgCME
				</td>
		";
		//AKHIR BUATAN BARU
		
		
		
		//bin
		/* lama
		$pdf->SetFillColor(255,255,255); 
		
		if( $cBIN[$j][3] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cBIN[$j][3],'LRTB',0,C,true);
		
		if( $cBIN[$j][4] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cBIN[$j][4],'LRTB',0,C,true);
		
		if( (($cBIN[$j][3] + $cBIN[$j][4])/2) < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4, ($cBIN[$j][3] + $cBIN[$j][4])/2,'LRTB',0,C,true);
		
		$pdf->SetFillColor(229,229,229);
		$pdf->Cell( 0.5	,0.4,$lgBIN,'LRTB',0,C,true);
		*/
		
		//AWAL BUATAN BARU
		//BIN
		$cBIN_d3 = $cBIN[$j][3];
		$cBIN_d4 = $cBIN[$j][4];
		$cBIN_d34= ($cBIN[$j][3] + $cBIN[$j][4])/2;
		
		if( $cBIN_d3 < 70 )
		{
			if( $cBIN_d3 == 0 )
				$bgcolor_d3 = ''; 
			else
				$bgcolor_d3 = 'red'; 
		}
		else
		{
			$bgcolor_d3 = ''; 
		}
				
		if( $cBIN_d4 < 70 )
		{
			if( $cBIN_d4 == 0 )
				$bgcolor_d4 = ''; 
			else
				$bgcolor_d4 = 'red'; 
		}
		else
		{
			$bgcolor_d4 = '';  
		}
				
		if( $cBIN_d34 < 70 )
		{
			if( $cBIN_d34 == 0 )
				$bgcolor_d34 = 'pink'; 
			else
				$bgcolor_d34 = 'red'; 
		}
		else// if( $cBIN_d34 >= 70 )
		{
			$bgcolor_d34 = 'pink';  
		}
		
		echo"
				<td align='center' bgcolor='$bgcolor_d3'>
					$cBIN_d3
				</td>
				<td align='center' bgcolor='$bgcolor_d4'>
					$cBIN_d4
				</td>
				<td align='center' bgcolor='$bgcolor_d34'>
					$cBIN_d34
				</td>
				<td align='center' bgcolor='lightblue'>
					$lgBIN
				</td>
		";
		//AKHIR BUATAN BARU
		
		
		
		//mth
		/* lama
		$pdf->SetFillColor(255,255,255); 
		
		if( $cMTH[$j][3] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cMTH[$j][3],'LRTB',0,C,true);
		
		if( $cMTH[$j][4] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cMTH[$j][4],'LRTB',0,C,true);
		
		if( (($cMTH[$j][3] + $cMTH[$j][4])/2) < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4, ($cMTH[$j][3] + $cMTH[$j][4])/2,'LRTB',0,C,true);
		
		$pdf->SetFillColor(229,229,229);
		$pdf->Cell( 0.5	,0.4,$lgMTH,'LRTB',0,C,true);
		*/
		
		//AWAL BUATAN BARU
		//MAT
		$cMTH_d3 = $cMTH[$j][3];
		$cMTH_d4 = $cMTH[$j][4];
		$cMTH_d34= ($cMTH[$j][3] + $cMTH[$j][4])/2;
		
		if( $cMTH_d3 < 70 )
		{
			if( $cMTH_d3 == 0 )
				$bgcolor_d3 = ''; 
			else
				$bgcolor_d3 = 'red'; 
		}
		else
		{
			$bgcolor_d3 = ''; 
		}
				
		if( $cMTH_d4 < 70 )
		{
			if( $cMTH_d4 == 0 )
				$bgcolor_d4 = ''; 
			else
				$bgcolor_d4 = 'red'; 
		}
		else
		{
			$bgcolor_d4 = '';  
		}
				
		if( $cMTH_d34 < 70 )
		{
			if( $cMTH_d34 == 0 )
				$bgcolor_d34 = 'pink'; 
			else
				$bgcolor_d34 = 'red'; 
		}
		else// if( $cMTH_d34 >= 70 )
		{
			$bgcolor_d34 = 'pink';  
		}
		
		echo"
				<td align='center' bgcolor='$bgcolor_d3'>
					$cMTH_d3
				</td>
				<td align='center' bgcolor='$bgcolor_d4'>
					$cMTH_d4
				</td>
				<td align='center' bgcolor='$bgcolor_d34'>
					$cMTH_d34
				</td>
				<td align='center' bgcolor='lightblue'>
					$lgMTH
				</td>
		";
		//AKHIR BUATAN BARU
		
		
		
		//scn
		/* lama
		$pdf->SetFillColor(255,255,255); 
		
		if( $cSCN[$j][3] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cSCN[$j][3],'LRTB',0,C,true);
		
		if( $cSCN[$j][4] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cSCN[$j][4],'LRTB',0,C,true);
		
		if( (($cSCN[$j][3] + $cSCN[$j][4])/2) < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4, ($cSCN[$j][3] + $cSCN[$j][4])/2,'LRTB',0,C,true);
		
		$pdf->SetFillColor(229,229,229);
		$pdf->Cell( 0.5	,0.4,$lgSCN,'LRTB',0,C,true);
		*/
		
		//AWAL BUATAN BARU
		//IPA
		$cSCN_d3 = $cSCN[$j][3];
		$cSCN_d4 = $cSCN[$j][4];
		$cSCN_d34= ($cSCN[$j][3] + $cSCN[$j][4])/2;
		
		if( $cSCN_d3 < 70 )
		{
			if( $cSCN_d3 == 0 )
				$bgcolor_d3 = ''; 
			else
				$bgcolor_d3 = 'red'; 
		}
		else
		{
			$bgcolor_d3 = ''; 
		}
				
		if( $cSCN_d4 < 70 )
		{
			if( $cSCN_d4 == 0 )
				$bgcolor_d4 = ''; 
			else
				$bgcolor_d4 = 'red'; 
		}
		else
		{
			$bgcolor_d4 = '';  
		}
				
		if( $cSCN_d34 < 70 )
		{
			if( $cSCN_d34 == 0 )
				$bgcolor_d34 = 'pink'; 
			else
				$bgcolor_d34 = 'red'; 
		}
		else// if( $cSCN_d34 >= 70 )
		{
			$bgcolor_d34 = 'pink';  
		}
		
		echo"
				<td align='center' bgcolor='$bgcolor_d3'>
					$cSCN_d3
				</td>
				<td align='center' bgcolor='$bgcolor_d4'>
					$cSCN_d4
				</td>
				<td align='center' bgcolor='$bgcolor_d34'>
					$cSCN_d34
				</td>
				<td align='center' bgcolor='lightblue'>
					$lgSCN
				</td>
		";
		//AKHIR BUATAN BARU
		
		
		
		//scls
		/* lama
		$pdf->SetFillColor(255,255,255); 
		
		if( $cSCLS[$j][3] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cSCLS[$j][3],'LRTB',0,C,true);
		
		if( $cSCLS[$j][4] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cSCLS[$j][4],'LRTB',0,C,true);
		
		if( (($cSCLS[$j][3] + $cSCLS[$j][4])/2) < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4, ($cSCLS[$j][3] + $cSCLS[$j][4])/2,'LRTB',0,C,true);
		
		$pdf->SetFillColor(229,229,229);
		$pdf->Cell( 0.5	,0.4,$lgSCLS,'LRTB',0,C,true);
		*/
		
		//AWAL BUATAN BARU
		//IPS
		$cSCLS_d3 = $cSCLS[$j][3];
		$cSCLS_d4 = $cSCLS[$j][4];
		$cSCLS_d34= ($cSCLS[$j][3] + $cSCLS[$j][4])/2;
		
		if( $cSCLS_d3 < 70 )
		{
			if( $cSCLS_d3 == 0 )
				$bgcolor_d3 = ''; 
			else
				$bgcolor_d3 = 'red'; 
		}
		else
		{
			$bgcolor_d3 = ''; 
		}
				
		if( $cSCLS_d4 < 70 )
		{
			if( $cSCLS_d4 == 0 )
				$bgcolor_d4 = ''; 
			else
				$bgcolor_d4 = 'red'; 
		}
		else
		{
			$bgcolor_d4 = '';  
		}
				
		if( $cSCLS_d34 < 70 )
		{
			if( $cSCLS_d34 == 0 )
				$bgcolor_d34 = 'pink'; 
			else
				$bgcolor_d34 = 'red'; 
		}
		else// if( $cSCLS_d34 >= 70 )
		{
			$bgcolor_d34 = 'pink';  
		}
		
		echo"
				<td align='center' bgcolor='$bgcolor_d3'>
					$cSCLS_d3
				</td>
				<td align='center' bgcolor='$bgcolor_d4'>
					$cSCLS_d4
				</td>
				<td align='center' bgcolor='$bgcolor_d34'>
					$cSCLS_d34
				</td>
				<td align='center' bgcolor='lightblue'>
					$lgSCLS
				</td>
		";
		//AKHIR BUATAN BARU
		
		
		
		//art
		/* lama
		$pdf->SetFillColor(255,255,255); 
		
		if( $cART[$j][3] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cART[$j][3],'LRTB',0,C,true);
		
		if( $cART[$j][4] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cART[$j][4],'LRTB',0,C,true);
		
		if( (($cART[$j][3] + $cART[$j][4])/2) < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4, ($cART[$j][3] + $cART[$j][4])/2,'LRTB',0,C,true);
		
		$pdf->SetFillColor(229,229,229);
		$pdf->Cell( 0.5	,0.4,$lgART,'LRTB',0,C,true);
		*/
		
		//AWAL BUATAN BARU
		//ART
		$cART_d3 = $cART[$j][3];
		$cART_d4 = $cART[$j][4];
		$cART_d34= ($cART[$j][3] + $cART[$j][4])/2;
		
		if( $cART_d3 < 70 )
		{
			if( $cART_d3 == 0 )
				$bgcolor_d3 = ''; 
			else
				$bgcolor_d3 = 'red'; 
		}
		else
		{
			$bgcolor_d3 = ''; 
		}
				
		if( $cART_d4 < 70 )
		{
			if( $cART_d4 == 0 )
				$bgcolor_d4 = ''; 
			else
				$bgcolor_d4 = 'red'; 
		}
		else
		{
			$bgcolor_d4 = '';  
		}
				
		if( $cART_d34 < 70 )
		{
			if( $cART_d34 == 0 )
				$bgcolor_d34 = 'pink'; 
			else
				$bgcolor_d34 = 'red'; 
		}
		else// if( $cART_d34 >= 70 )
		{
			$bgcolor_d34 = 'pink';  
		}
		
		echo"
				<td align='center' bgcolor='$bgcolor_d3'>
					$cART_d3
				</td>
				<td align='center' bgcolor='$bgcolor_d4'>
					$cART_d4
				</td>
				<td align='center' bgcolor='$bgcolor_d34'>
					$cART_d34
				</td>
				<td align='center' bgcolor='lightblue'>
					$lgART
				</td>
		";
		//AKHIR BUATAN BARU
		
		
		
		//com
		/* lama
		$pdf->SetFillColor(255,255,255); 
		
		if( $cCOM[$j][3] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cCOM[$j][3],'LRTB',0,C,true);
		
		if( $cCOM[$j][4] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cCOM[$j][4],'LRTB',0,C,true);
		
		if( (($cCOM[$j][3] + $cCOM[$j][4])/2) < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4, ($cCOM[$j][3] + $cCOM[$j][4])/2,'LRTB',0,C,true);
		
		$pdf->SetFillColor(229,229,229);
		$pdf->Cell( 0.5	,0.4,$lgCOM,'LRTB',0,C,true);
		*/
		
		//AWAL BUATAN BARU
		//COM
		$cCOM_d3 = $cCOM[$j][3];
		$cCOM_d4 = $cCOM[$j][4];
		$cCOM_d34= ($cCOM[$j][3] + $cCOM[$j][4])/2;
		
		if( $cCOM_d3 < 70 )
		{
			if( $cCOM_d3 == 0 )
				$bgcolor_d3 = ''; 
			else
				$bgcolor_d3 = 'red'; 
		}
		else
		{
			$bgcolor_d3 = ''; 
		}
				
		if( $cCOM_d4 < 70 )
		{
			if( $cCOM_d4 == 0 )
				$bgcolor_d4 = ''; 
			else
				$bgcolor_d4 = 'red'; 
		}
		else
		{
			$bgcolor_d4 = '';  
		}
				
		if( $cCOM_d34 < 70 )
		{
			if( $cCOM_d34 == 0 )
				$bgcolor_d34 = 'pink'; 
			else
				$bgcolor_d34 = 'red'; 
		}
		else// if( $cCOM_d34 >= 70 )
		{
			$bgcolor_d34 = 'pink';  
		}
		
		echo"
				<td align='center' bgcolor='$bgcolor_d3'>
					$cCOM_d3
				</td>
				<td align='center' bgcolor='$bgcolor_d4'>
					$cCOM_d4
				</td>
				<td align='center' bgcolor='$bgcolor_d34'>
					$cCOM_d34
				</td>
				<td align='center' bgcolor='lightblue'>
					$lgCOM
				</td>
		";
		//AKHIR BUATAN BARU
		
		
		
		//pe
		/* lama
		$pdf->SetFillColor(255,255,255); 
		
		if( $cPE[$j][3] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cPE[$j][3],'LRTB',0,C,true);
		
		if( $cPE[$j][4] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4,$cPE[$j][4],'LRTB',0,C,true);
		
		if( (($cPE[$j][3] + $cPE[$j][4])/2) < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4, ($cPE[$j][3] + $cPE[$j][4])/2,'LRTB',0,C,true);
		
		$pdf->SetFillColor(229,229,229);
		$pdf->Cell( 0.5	,0.4,$lgPE,'LRTB',0,C,true);
		*/
		
		//AWAL BUATAN BARU
		//PE
		$cPE_d3 = $cPE[$j][3];
		$cPE_d4 = $cPE[$j][4];
		$cPE_d34= ($cPE[$j][3] + $cPE[$j][4])/2;
		
		if( $cPE_d3 < 70 )
		{
			if( $cPE_d3 == 0 )
				$bgcolor_d3 = ''; 
			else
				$bgcolor_d3 = 'red'; 
		}
		else
		{
			$bgcolor_d3 = ''; 
		}
				
		if( $cPE_d4 < 70 )
		{
			if( $cPE_d4 == 0 )
				$bgcolor_d4 = ''; 
			else
				$bgcolor_d4 = 'red'; 
		}
		else
		{
			$bgcolor_d4 = '';  
		}
				
		if( $cPE_d34 < 70 )
		{
			if( $cPE_d34 == 0 )
				$bgcolor_d34 = 'pink'; 
			else
				$bgcolor_d34 = 'red'; 
		}
		else// if( $cPE_d34 >= 70 )
		{
			$bgcolor_d34 = 'pink';  
		}
		
		echo"
				<td align='center' bgcolor='$bgcolor_d3'>
					$cPE_d3
				</td>
				<td align='center' bgcolor='$bgcolor_d4'>
					$cPE_d4
				</td>
				<td align='center' bgcolor='$bgcolor_d34'>
					$cPE_d34
				</td>
				<td align='center' bgcolor='lightblue'>
					$lgPE
				</td>
		";
		//AKHIR BUATAN BARU
		
		
		
		//eng
		/* lama
		$pdf->SetFillColor(255,255,255); 
		
		if( $cENG[$j][3] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cENG[$j][3],'LRTB',0,C,true);
		
		if( $cENG[$j][4] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4,$cENG[$j][4],'LRTB',0,C,true);
		
		if( (($cENG[$j][3] + $cENG[$j][4])/2) < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4, ($cENG[$j][3] + $cENG[$j][4])/2,'LRTB',0,C,true);
		
		$pdf->SetFillColor(229,229,229);
		$pdf->Cell( 0.5	,0.4,$lgENG,'LRTB',0,C,true);
		*/
		
		//AWAL BUATAN BARU
		//ENG
		$cENG_d3 = $cENG[$j][3];
		$cENG_d4 = $cENG[$j][4];
		$cENG_d34= ($cENG[$j][3] + $cENG[$j][4])/2;
		
		if( $cENG_d3 < 70 )
		{
			if( $cENG_d3 == 0 )
				$bgcolor_d3 = ''; 
			else
				$bgcolor_d3 = 'red'; 
		}
		else
		{
			$bgcolor_d3 = ''; 
		}
				
		if( $cENG_d4 < 70 )
		{
			if( $cENG_d4 == 0 )
				$bgcolor_d4 = ''; 
			else
				$bgcolor_d4 = 'red'; 
		}
		else
		{
			$bgcolor_d4 = '';  
		}
				
		if( $cENG_d34 < 70 )
		{
			if( $cENG_d34 == 0 )
				$bgcolor_d34 = 'pink'; 
			else
				$bgcolor_d34 = 'red'; 
		}
		else// if( $cENG_d34 >= 70 )
		{
			$bgcolor_d34 = 'pink';  
		}
		
		echo"
				<td align='center' bgcolor='$bgcolor_d3'>
					$cENG_d3
				</td>
				<td align='center' bgcolor='$bgcolor_d4'>
					$cENG_d4
				</td>
				<td align='center' bgcolor='$bgcolor_d34'>
					$cENG_d34
				</td>
				<td align='center' bgcolor='lightblue'>
					$lgENG
				</td>
		";
		//AKHIR BUATAN BARU
		
		
		
		//mnd
		/* lama
		$pdf->SetFillColor(255,255,255); 
		
		if( $cMND[$j][3] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255); 
		$pdf->Cell( 0.5	,0.4,$cMND[$j][3],'LRTB',0,C,true);
		
		if( $cMND[$j][4] < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4,$cMND[$j][4],'LRTB',0,C,true);
		
		if( (($cMND[$j][3] + $cMND[$j][4])/2) < 70 )
			$pdf->SetFillColor(255,165,165); 
		else
			$pdf->SetFillColor(255,255,255);
		$pdf->Cell( 0.5	,0.4, ($cMND[$j][3] + $cMND[$j][4])/2,'LRTB',0,C,true);
		
		$pdf->SetFillColor(229,229,229);
		$pdf->Cell( 0.5	,0.4,$lgMND,'LRTB',0,C,true);
		*/
		
		//AWAL BUATAN BARU
		//MAN
		$cMND_d3 = $cMND[$j][3];
		$cMND_d4 = $cMND[$j][4];
		$cMND_d34= ($cMND[$j][3] + $cMND[$j][4])/2;
		
		if( $cMND_d3 < 70 )
		{
			if( $cMND_d3 == 0 )
				$bgcolor_d3 = ''; 
			else
				$bgcolor_d3 = 'red'; 
		}
		else
		{
			$bgcolor_d3 = ''; 
		}
				
		if( $cMND_d4 < 70 )
		{
			if( $cMND_d4 == 0 )
				$bgcolor_d4 = ''; 
			else
				$bgcolor_d4 = 'red'; 
		}
		else
		{
			$bgcolor_d4 = '';  
		}
				
		if( $cMND_d34 < 70 )
		{
			if( $cMND_d34 == 0 )
				$bgcolor_d34 = 'pink'; 
			else
				$bgcolor_d34 = 'red'; 
		}
		else// if( $cMND_d34 >= 70 )
		{
			$bgcolor_d34 = 'pink';  
		}
		
		echo"
				<td align='center' bgcolor='$bgcolor_d3'>
					$cMND_d3
				</td>
				<td align='center' bgcolor='$bgcolor_d4'>
					$cMND_d4
				</td>
				<td align='center' bgcolor='$bgcolor_d34'>
					$cMND_d34
				</td>
				<td align='center' bgcolor='lightblue'>
					$lgMND
				</td>
		";
		
		
		
		$t=26-(($k+3)*0.9);
		
		
		
		$ttlAVEk = ( $cRLG[$j][0] + $cCME[$j][0] + $cBIN[$j][0] + $cMTH[$j][0] + $cSCN[$j][0] + $cSCLS[$j][0] + $cART[$j][0] + $cCOM[$j][0] + $cPE[$j][0] + $cENG[$j][0] + $cMND[$j][0] ) / 11;
		$ttlAVEs = ( $cRLG[$j][1] + $cCME[$j][1] + $cBIN[$j][1] + $cMTH[$j][1] + $cSCN[$j][1] + $cSCLS[$j][1] + $cART[$j][1] + $cCOM[$j][0] + $cPE[$j][1] + $cENG[$j][1] + $cMND[$j][1] ) / 11;
		
		$ttlAVEk_d = number_format($ttlAVEk);
		$ttlAVEs_d = number_format($ttlAVEs);
		$ttlAVEks_d= ( number_format($ttlAVEk) + number_format($ttlAVEs) ) / 2;
		
		echo"
			
				<td align='center'>
					$ttlAVEk_d
				</td>
				<td align='center'>
					$ttlAVEs_d
				</td>
				<td align='center' bgcolor='pink'>
					$ttlAVEks_d
				</td>
			</tr>
		";
		//AKHIR BUATAN BARU
				
		
		
		
		$j++;
		$x++;
		$no++;
		$rnk++;
		
	}
	
	
	
	if($j<$i)
	{
		/*
		$pdf->Cell(28	,0.4," Page : ".$hlm." Continued on page ".($hlm+1),'',0,R,true);
		*/
		$hlm++;
	}
	else
	{
		/*
		$pdf->Cell( 12	,0.4,'Jakarta, '.$tglctk,'',0,L,true);
		$pdf->Cell( 12	,0.4,'Approved by','',0,L,true);
		$pdf->Ln();
		$pdf->Cell( 12	,0.4,'Homeroom Teacher : '.$wlikls,'',0,L,true);
		$pdf->Cell( 12	,0.4,'Principal : '.$kplskl,'',0,L,true);
		$pdf->Cell(  4	,0.4," Page : ".$hlm,'',0,R,true);
		*/
	} 
	
	
	
	//AWAL BUATAN BARU
			echo"
			
				
			
				<table width='100%'>
					<br/>
					<br/>
					<br/>
					<tr>
						<td align='left'>
							Jakarta, $tglctk
							<br/>
							Homeroom Teacher : $wlikls
						</td>
						<td align='right'>
							Approved by : 
							<br/>
							Principal : $kplskl
						</td>
					</tr>
				</table>
			";
		//AKHIR BUATAN BARU
	
	
	
}; 



//awal halaman 2

//$j=0;
//while($j<$i)
//{
	

	//$t=26-(($k+3)*0.9);
	
	
	
	
	
	
	
	
	

/*
$pdf->Output();
*/

//AWAL BUATAN BARU
echo"
					</table>
					<!--</table>-->
					
				<!--Akhir Halaman 1-->
            </div>
		</div>
    </body>
</html>
";
//AKHIR BUATAN BARU

?>