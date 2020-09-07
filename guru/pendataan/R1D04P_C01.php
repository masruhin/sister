<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04P_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdekls	=$_POST['kdekls'];
$sms	=$_POST['sms'];
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

// dapatkan data tahun ajaran
$query	="	SELECT 		t_setthn.*
			FROM 		t_setthn
			WHERE		t_setthn.set='Tahun Ajaran'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt.*
			FROM 		t_mstbbt
			WHERE		t_mstbbt.kdebbt='1HW'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt.*
			FROM 		t_mstbbt
			WHERE		t_mstbbt.kdebbt='2PRJ'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt.*
			FROM 		t_mstbbt
			WHERE		t_mstbbt.kdebbt='3TES'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt.*
			FROM 		t_mstbbt
			WHERE		t_mstbbt.kdebbt='4MID'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtmidtes=$data[bbt];

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
$kdeklm=$data[kdeklm]+1;
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
$judul2=$nmasms.'FINAL REPORT';

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
			ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id";
$result =mysql_query($query) or die('Query gagal5');
$k=0;
while($data =mysql_fetch_array($result))
{
	if($data[kdeplj]!='')
	{
		$kdeplj=$data[kdeplj];
		
		$query2 	="	SELECT 		t_mstssw.*
					FROM 		t_mstssw
					WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' 
					ORDER BY	t_mstssw.kdekls,t_mstssw.nis ASC
					LIMIT		1,1";
		$result2 =mysql_query($query2) or die('Query gagal5');
		$data2 	=mysql_fetch_array($result2);
		$nis	=$data2[nis];
		
		$query3 	="	SELECT 		t_prgrptps.*
						FROM 		t_prgrptps
						WHERE 		t_prgrptps.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps.nis,t_prgrptps.kdeplj";
		$result3 =mysql_query($query3) or die('Query gagal');
		$data3 	=mysql_fetch_array($result3);
		
		$akh1=$data3['akh'."$sms"."1"];
		$akh2=$data3['akh'."$sms"."2"];
		if(($akh1+$akh2)>0 OR $kdeplj=='MND' OR $kdeplj=='GRM' OR $kdeplj=='PHY' OR $kdeplj=='BLGY' OR $kdeplj=='CHM')
		{
			$cell2[$k][0]	=$data[kdeplj];
			$k++;
		}	
	}	
}

$query 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw";
$result =mysql_query($query) or die('Query gagal5');
$i=0;
while($data =mysql_fetch_array($result))
{
	$cell5[$i][0]=$data[nis];
	$cell5[$i][1]=$data[nmassw];
	$cell5[$i][2]=$data[nisn];
	$cell5[$i][3]=0;
	$nis=$data[nis];
	$ttlakh1=0;
	$ttlakh2=0;
	$ttlakh=0;
	$n=0;
	while($n<$k)
	{
		$kdeplj=$cell2[$n][0];
	
		$query2 	="	SELECT 		t_prgrptps.*
						FROM 		t_prgrptps
						WHERE 		t_prgrptps.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps.nis,t_prgrptps.kdeplj";
		$result2 =mysql_query($query2) or die('Query gagal');
		$data2 =mysql_fetch_array($result2);
	
		$akh1=$data2['akh'."$sms"."1"];
		$akh2=$data2['akh'."$sms"."2"];
		$ttlakh1=$ttlakh1+$akh1;
		$ttlakh2=$ttlakh2+$akh2;

		$akh=number_format(($data2['akh'."$sms"."1"]+$data2['akh'."$sms"."2"])/2,0,',','.');
		$ttlakh=$ttlakh+$akh;
		
		$n++;
	}
	$cell5[$i][$n+4]=$ttlakh1;
	$cell5[$i][$n+5]=$ttlakh2;
	$cell5[$i][$n+6]=number_format(($ttlakh1+$ttlakh2)/2,0,',','.');
	$cell5[$i][$n+7]=$ttlakh;
	$i++;
}
$x=$i;

foreach ($cell5 as $key => $row)
{
	$key_arr[$key] = $row[$n+7];
}
array_multisort($key_arr, SORT_DESC, $cell5);

$y=0;
while($y<$x)
{
	$cell5[$y][3]=$y+1;
	$y++;
}

foreach ($cell5 as $key => $row)
{
	$key_arr[$key] = $row[1];
}
array_multisort($key_arr, SORT_ASC, $cell5);

$bghw	=1;
$bgprj	=1;
$bgtes	=1;
$y=0;

while($y<$x)
{
	$nis	=$cell5[$y][0];
	$nmassw	=$cell5[$y][1];
	$nisn	=$cell5[$y][2];

	$query4	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$nis'";
	$result4=mysql_query($query4) or die('Query gagal');
	$data4 	=mysql_fetch_array($result4);
	$kenaikan	=$data4['kenaikan22'];
	
	$query1 ="	SELECT 		t_setpsrpt.*
				FROM 		t_setpsrpt
				WHERE		t_setpsrpt.kdetkt='$kdetkt'
				ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id";
	$result1=mysql_query($query1) or die('Query gagal1');
	$i=1;
	while($data1 =mysql_fetch_array($result1))
	{
		$cell[$i][0]=$data1[id];	
		$cell[$i][1]=$data1[nmasbj];
		$cell[$i][2]=$data1[kdeplj];
		$kdeplj	=$data1[kdeplj];
		
		if($kdeplj!='')
		{
			$query6 	="	SELECT 		t_kkm.*
							FROM 		t_kkm
							WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
										t_kkm.kdeplj='". mysql_escape_string($kdeplj)."'";
			$result6 =mysql_query($query6) or die('Query gagal');
			$data6 	=mysql_fetch_array($result6);

			$cell[$i][3]=$data6[kkm];
			$query2 ="	SELECT 		t_prgrptps.*
						FROM 		t_prgrptps
						WHERE		t_prgrptps.nis='$nis'		AND
									t_prgrptps.kdeplj='$kdeplj'";
			$result2=mysql_query($query2) or die('Query gagal');
			$data2 =mysql_fetch_array($result2);
			
			$cell[$i][4]=$data2['akh'."$sms"."1"];
			$cell[$i][5]=$data2['akh'."$sms"."2"];
			$cell[$i][6]=number_format(($cell[$i][4]+$cell[$i][5])/2,0,',','.');
			$nliakh		=$cell[$i][6];

			$query5 ="	SELECT 		t_rtpsrpt.*
						FROM 		t_rtpsrpt
						WHERE		t_rtpsrpt.kdekls='$kdekls'		AND
									t_rtpsrpt.kdeplj='$kdeplj'";
			$result5=mysql_query($query5) or die('Query gagal');
			$data5 =mysql_fetch_array($result5);
			
			$cell[$i][7]=$data5['rt'."$sms"."1"];
			$cell[$i][8]=$data5['rt'."$sms"."2"];
			$cell[$i][9]=number_format(($cell[$i][7]+$cell[$i][8])/2,0,',','.');
			
			if(substr($cell[$i][1],0,1)=='*' AND $cell[$i][0]>=15 AND $kdetkt=='SHS')
			{
				if($nliakh==0)	
					$cell[$i][1]='';
				else	
					$cell[$i][1]=str_replace("*","",$cell[$i][1]);
			}		
			
			if(substr($cell[$i][1],0,1)=='*' AND $cell[$i][0]<15  AND $kdetkt=='SHS') 
			{
				if($nliakh==0	AND (strpos($kdekls,'IPA')!='' OR strpos($kdekls,'IPS')!=''))
					$cell[$i][1]='';
				else	
					$cell[$i][1]=str_replace("*","",$cell[$i][1]);
			}		
			
			if($kdetkt=='JHS')
			{
				if(substr($cell[$i][1],0,1)=='*' AND $nliakh==0)	
					$cell[$i][1]='';
				else	
					$cell[$i][1]=str_replace("*","",$cell[$i][1]);
			}		
			if($kdetkt=='PS')
			{
				$cell[$i][1]=str_replace("*","",$cell[$i][1]);
			}		
		}	
		else
		{
			$cell[$i][3]='';
		}
		$i++;
	}
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Image($logo_pt ,1,1,2,2);
	$pdf->Image($logo_ttw,18,1,2,2);
	$pdf->Ln(0.8);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(19	,0.4, $judul,0,0,C);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Cell(19	,0.4, $judul2,0,0,C);
	$pdf->Ln();
	$pdf->Cell(19	,0.4, $thnajr,0,0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(19	,0.3, $alamat1_pt1,0,0,C);
	$pdf->Ln();
	$pdf->Cell(19	,0.3, $alamat2_pt2,0,0,C);
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(1);
	$pdf->Cell( 1	,0.4,"Name",0,0,L); 
	$pdf->Cell( 13	,0.4,": ".$nmassw,0,0,L); 
	$pdf->Cell( 1	,0.4,"Grade",0,0,L); 
	$pdf->Cell( 4	,0.4,": ".$kdekls,0,0,L); 
	$pdf->Ln();
	$pdf->Cell( 1	,0.4,"NIS",0,0,L); 
	$pdf->Cell( 13	,0.4,": ".$nis,0,0,L); 
	$pdf->Cell( 1	,0.4,"NISN",0,0,L); 
	$pdf->Cell( 4	,0.4,": ".$nisn,0,0,L); 
	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.6	,0.8,'No','LRT',0,C,true);
	$pdf->Cell( 6.2	,0.8,'Subject','LRT',0,C,true);
	$pdf->Cell( 2	,0.4,'Minimum'		,'LRT',0,C,true);
	$pdf->Cell( 8.2	,0.4,'Mark'		,'LRTB',0,C,true);
	$pdf->Cell( 2	,0.4,'Class'		,'LRT',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0);
	$pdf->Cell( 6.2	,0);
	$pdf->Cell( 2	,0.4,'Requirement'		,'LRB',0,C,true);
	$pdf->Cell( 2	,0.4,'Number'		,'LRTB',0,C,true);
	$pdf->Cell( 6.2	,0.4,'In Word'		,'LRTB',0,C,true);
	$pdf->Cell( 2	,0.4,'Average'		,'LRB',0,C,true);
	$pdf->Ln();
	//------------------------------- Mata Pelajaran Kurikulum Nasional
	$j	=1;
	$no =1;
	$ttlakh=0;
	$jmlplj=0;
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[$j][0];
	$pdf->Cell(0.6	,0.5,'A','LRTB',0,C,true);	
	while ($id<99)
	{
		//menampilkan data dari hasil query database
		$nmasbj	=$cell[$j][1];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		$rt		=$cell[$j][9];
		if($nmasbj!='')
		{
			if(substr($nmasbj,0,1)=='/')
			{
				$nmasbj 	=str_replace("/","","$nmasbj");
				$pdf->SetFont('Arial','B',8);
				$pdf->SetFillColor(204,204,204);
				$pdf->Cell(6.2	,0.5,$nmasbj,'LRTB',0,L,true);
				$nliakh	='';
				$klm	='';
				$rt		='';
			}
			else
			{
				$pdf->SetFont('Arial','',8);
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);
				if(substr($nmasbj,0,1)!='=')
				{
					$pdf->Cell(0.6	,0.5,$no.'.','LTB',0,R,true);
					$pdf->Cell(5.6	,0.5,$nmasbj,'RTB',0,L,true);
					$no++;
				}
				else
				{
					$nmasbj 	=str_replace("=","","$nmasbj");
					$pdf->Cell(6.2	,0.5,'        '.$nmasbj,'LRTB',0,L,true);
				}	
				$nliakh	=number_format($nliakh,0,',','.');
				$klm	=ucwords(number_to_words($nliakh));
				if($nliakh==0)
				{
					$kkm	='';
					$nliakh	='-';
					$klm	='-';
				}
				else
				{
					$ttlakh	=$ttlakh+$nliakh;
					$jmlplj	=$jmlplj+1;
				}
			}	
			$pdf->Cell( 2	,0.5,$kkm,'LRTB',0,C,true);

			if($nliakh<$kkm)
				$pdf->SetTextColor(255,0,0);
			else
				$pdf->SetTextColor(0,0,0);
			
			$pdf->Cell( 2	,0.5,$nliakh,'LRTB',0,C,true);
			if($klm=='-')
				$pdf->Cell( 6.2	,0.5,$klm,'LRTB',0,C,true);
			else
				$pdf->Cell( 6.2	,0.5,$klm,'LRTB',0,L,true);
			$pdf->SetTextColor(0,0,0);
			$pdf->Cell( 2	,0.5,$rt,'LRTB',0,C,true);
			$pdf->Ln();
		}	
		$j++;
		$id=$cell[$j][0];
	}
	$pdf->Cell( 0.6	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 6.2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 6.2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Ln();

	//------------------------------- Muatan Lokal 
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[j][0];
	$pdf->Cell(0.6	,0.5,'B','LRTB',0,C,true);	
	while ($id<200)
	{
		//menampilkan data dari hasil query database
		
		$nmasbj=$cell[$j][1];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		$rt		=$cell[$j][9];
		if(substr($nmasbj,0,1)=='/')
		{
			$nmasbj 	=str_replace("/","","$nmasbj");
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(204,204,204);
			$pdf->Cell(6.2	,0.5,$nmasbj,'LRTB',0,L,true);
			$nliakh	='';
			$klm	='';
			$rt		='';
		}
		else
		{
			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);
			$pdf->Cell(0.6	,0.5,$no.'.','LTB',0,R,true);
			$pdf->Cell(5.6	,0.5,$nmasbj,'RTB',0,L,true);
			$no++;

			$nliakh	=number_format($nliakh,0,',','.');
			$klm	=ucwords(number_to_words($nliakh));
			if($nliakh==0)
			{
				$kkm	='';
				$nliakh	='-';
				$klm	='-';
			}
				else
				{
					$ttlakh	=$ttlakh+$nliakh;
					$jmlplj	=$jmlplj+1;
				}
		}	
		
		$pdf->Cell( 2	,0.5,$kkm,'LRTB',0,C,true);
		if($nliakh<$kkm)
			$pdf->SetTextColor(255,0,0);
		else
			$pdf->SetTextColor(0,0,0);
		$pdf->Cell( 2	,0.5,$nliakh,'LRTB',0,C,true);
		if($klm=='-')
			$pdf->Cell( 6.2	,0.5,$klm,'LRTB',0,C,true);
		else
			$pdf->Cell( 6.2	,0.5,$klm,'LRTB',0,L,true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell( 2	,0.5,$rt,'LRTB',0,C,true);
		$pdf->Ln();
		$j++;
		$id=$cell[$j][0];
	}
	$pdf->Cell( 0.6	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 6.2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 6.2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Ln();

	//------------------------------- Pengembangan diri
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell(0.6	,0.5,'C','LRTB',0,C,true);	
	$pdf->Cell(6.2	,0.5,'Pengembangan Diri','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 6.2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Ln();

	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);	
	$pdf->Cell(6.2	,0.5,'Ekstrakurikuler','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 6.2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Ln();

	$query3	="	SELECT 		t_extcrrps.*,t_mstplj.*
				FROM 		t_extcrrps,t_mstplj
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj=t_mstplj.kdeplj
				ORDER BY	t_extcrrps.kdeplj";
	$result3=mysql_query($query3) or die('Query gagal40');

	//$z=0;
	while($data3 = mysql_fetch_array($result3))
	{
		if($data3['ext'."$sms"."2"]!='')
		{
			$ext='  '.ucwords(strtolower($data3['nmaplj'])).' : '.$data3['ext'."$sms"."2"];
			$pdf->Cell( 0.6	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 6.2	,0.5,$ext,'LRTB',0,L,true);
			$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 6.2	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
			$pdf->Ln();
		}	
		//$z++;
	}
	$pdf->Cell( 0.6	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 6.2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 6.2	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 2	,0.5,'','LRTB',0,C,true);
	$pdf->Ln();
	
	//------------------------------- Cambridge Curiculum
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[j][0];
	$pdf->Cell(0.6	,0.5,'D','LRTB',0,C,true);	
	while ($j<$i)
	{
		//menampilkan data dari hasil query database
		
		$nmasbj	=$cell[$j][1];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		$rt		=$cell[$j][9];
		if($nmasbj!='')
		{
			if(substr($nmasbj,0,1)=='/')
			{
				$nmasbj 	=str_replace("/","","$nmasbj");
				$pdf->SetFont('Arial','B',8);
				$pdf->SetFillColor(204,204,204);
				$pdf->Cell(6.2	,0.5,$nmasbj,'LRTB',0,L,true);
				$nliakh	='';
				$klm	='';
				$rt		='';
			}
			else
			{
				$pdf->SetFont('Arial','',8);
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);
				$pdf->Cell(0.6	,0.5,$no.'.','LTB',0,R,true);
				$pdf->Cell(5.6	,0.5,$nmasbj,'RTB',0,L,true);
				$no++;

				$nliakh	=number_format($nliakh,0,',','.');
				$klm	=ucwords(number_to_words($nliakh));
				if($nliakh==0)
				{
					$kkm	='';
					$nliakh	='-';
					$klm	='-';
				}
				else
				{
					$ttlakh	=$ttlakh+$nliakh;
					$jmlplj	=$jmlplj+1;
				}
			}	
			$pdf->Cell( 2	,0.5,$kkm,'LRTB',0,C,true);
			if($nliakh<$kkm)
				$pdf->SetTextColor(255,0,0);
			else
				$pdf->SetTextColor(0,0,0);
			$pdf->Cell( 2	,0.5,$nliakh,'LRTB',0,C,true);
			if($klm=='-')
				$pdf->Cell( 6.2	,0.5,$klm,'LRTB',0,C,true);
			else
				$pdf->Cell( 6.2	,0.5,$klm,'LRTB',0,L,true);
			$pdf->SetTextColor(0,0,0);
			$pdf->Cell( 2	,0.5,$rt,'LRTB',0,C,true);
			$pdf->Ln();
		}	
		$j++;
		$id=$cell[$j][0];
	}
	$klm	=str_replace('And','and',ucwords(number_to_words($ttlakh)));
	$pdf->Cell( 8.8	,0.5,"Total",'LRTB',0,C);	
	$pdf->Cell( 2	,0.5,$ttlakh,'LRTB',0,C);	
	$pdf->Cell( 8.2	,0.5,$klm,'LRTB',0,L);	
	$pdf->Ln();
	//$rtrt	=$ttlakh/$jmlplj;
	$rtrt	=number_format($rtrt,0,',','.');
	$klm	=ucwords(number_to_words($rtrt));
	$rnk	=$cell5[$y][3];
	$pdf->Cell( 8.8	,0.5,"Average",'LRTB',0,C);	
	$pdf->Cell( 2	,0.5,$rtrt,'LRTB',0,C);	
	$pdf->Cell( 8.2	,0.5,$klm,'LRTB',0,L);	
	$pdf->Ln();
	$pdf->Cell( 8.8	,0.5,"Ranking",'LRTB',0,C);	
	if($rnk>10)
		$rnk='-';
	$pdf->Cell( 2	,0.5,$rnk,'LRTB',0,C);	
	$pdf->Cell( 8.2	,0.5,"",'LRTB',0,C);	
	$pdf->Ln();

	if($sms==2)
	{
		if($kenaikan=='T')
		{
			$pdf->Cell(8.77	,0.5,'Promoted /','',0,R);
			$pdf->Cell(9.5	,0.5,'Not Promoted to grade '.$kdeklm.' ( '.number_to_words($kdeklm).' )','',0,L);
			$pdf->Ln();		
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(8.7	,-0.5,"---------------",'',0,R);
			$pdf->SetFont('Arial','',8);
		}	
		else
		{
			$pdf->Cell(8.77	,0.5,'Promoted /','',0,R);
			$pdf->Cell(9.5	,0.5,'Not Promoted to grade '.$kdeklm.' ( '.number_to_words($kdeklm).' )','',0,L);
			$pdf->Ln();		
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(10.8	,-0.5,"--------------------",'',0,R);
				$pdf->SetFont('Arial','',8);
		}	
	}	
	$pdf->Ln();
	
	$pdf->Ln(0.6);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 6	,0.4,'Acknowledged by','',0,C);
	$pdf->Cell( 7	,0.4,'','',0,C);
	$pdf->Cell( 6	,0.4,'Jakarta, '.$tglctk,'',0,C);
	$pdf->Ln();
	$pdf->Cell( 6	,0.4,'Parents / Guardian','',0,C);
	$pdf->Cell( 7	,0.4,'','',0,C);
	$pdf->Cell( 6	,0.4,'Homeroom Teacher','',0,C);
	$pdf->Ln(1.6);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 6	,0.4,"                                                      ",'',0,C);
	$pdf->Cell( 7	,0.4,'','',0,C);
	$pdf->Cell( 6	,0.4,$wlikls,'',0,C);
	$pdf->Ln();
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 7	,0.4,'Approved by','',0,C);
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->Ln(1.6);
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 7	,0.4,$kplskl,'',0,C);
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->Ln();
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 7	,0.4,'Principal','',0,C);
	$pdf->Cell( 6	,0.4,'','',0,C);  
	$y++;
};
$pdf->Output();
?>