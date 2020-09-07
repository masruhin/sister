<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04M_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdeplj	=$_POST['kdeplj'];
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
		$judul	=$nama_pt_ps;
		break;
	case 'JHS':
		$judul	=$nama_pt_jhs;
		break;
	case 'SHS':
		$judul	=$nama_pt_shs;
		break;
}		
if($sms=='1')
	$nmasms='FIRST SEMESTER ';
else
	$nmasms='SECOND SEMESTER ';
$judul2=$nmasms.'MASTER SHEET FINAL REPORT ';

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
	$kplskl	=$data[nmakry];
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
		
		$akh=number_format(($data3['akh'."$sms"."1"]+$data3['akh'."$sms"."2"])/2,0,',','.');
		if($akh>0)
		{ 
			$cell2[$k][0]	=$data[kdeplj];
			$kdeplj			=$data[kdeplj];
			
			$query4 	="	SELECT 		t_kkm.*
							FROM 		t_kkm
							WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
										t_kkm.kdeplj='". mysql_escape_string($kdeplj)."'";
			$result4 =mysql_query($query4) or die('Query gagal');
			$data4 	=mysql_fetch_array($result4);
			
			$cell2[$k][1]	=$data4[kkm];
			$cell2[$k][2]	=$data[nmasbj2];
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
										t_kkm.kdeplj='". mysql_escape_string($kdeplj)."'";
			$result4 =mysql_query($query4) or die('Query gagal');
			$data4 	=mysql_fetch_array($result4);
			
			$cell2[$k][1]	=$data4[kkm];
			$cell2[$k][2]	=$data[nmasbj2];
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
$result =mysql_query($query) or die('Query gagal5');
$i=0;
while($data =mysql_fetch_array($result))
{
	$cell[$i][0]=$data[nis];
	$cell[$i][1]=$data[nmassw];
	$nis=$data[nis];
	$ttlakh	=0;
	$max	=0;
	$min	=0;
	$n=0;
	$m=0;
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
		
		$akh=number_format(($data2['akh'."$sms"."1"]+$data2['akh'."$sms"."2"])/2,0,',','.');
		$cell[$i][$n+2]=$akh;
		$ttlakh=$ttlakh+$akh;
		if($akh>0)
			$m++;
		$n++;
	}
	$cell[$i][$n+2]=$ttlakh;

	$cell[$i][$n+3]=number_format($ttlakh/($m),0,',','.');
	$i++;
}

foreach ($cell as $key => $row){
$key_arr[$key] = $row[$n+2];
}
array_multisort($key_arr, SORT_DESC, $cell);

$n=0;
while($n<$k)
{
	$cell3[$n][0]=$cell2[$n][0];
	$kdeplj		 =$cell2[$n][0];
	$jml=0;
	$jmlmnd=0;
	$jmlgrm=0;
	$jmlphy=0;
	$jmlblgy=0;
	$jmlchm=0;
	$j=0;
	while($j<$i)
	{
		$cell3[$n][1]=$cell3[$n][1]+$cell[$j][$n+2];
		if($kdeplj=='MND' AND $cell[$j][$n+2]!=0)
			$jmlmnd++;
		else
		{		
			if($kdeplj=='GRM' AND $cell[$j][$n+2]!=0)	
				$jmlgrm++;
			else
			{
				if($kdeplj=='PHY' AND $cell[$j][$n+2]!=0)
					$jmlphy++;
				else
				{
					if($kdeplj=='BLGY' AND $cell[$j][$n+2]!=0)
						$jmlblgy++;
					else
					{
						if($kdeplj=='CHM' AND $cell[$j][$n+2]!=0)
							$jmlchm++;
						else
							$jml++;
					}
				}	
			}	
		}
		
		if($j==0)
		{
			$max=$cell[$j][$n+2];
			$min=$cell[$j][$n+2];
		}
			
		if($cell[$j][$n+2]>$max)
		{
			$max=$cell[$j][$n+2];
		}
		if(($cell[$j][$n+2]<=$min AND $cell[$j][$n+2]!=0 ) OR $min==0)
		{
			$min=$cell[$j][$n+2];
		}	
		$j++;
	}	

	$query5 ="	SELECT 		t_rtpsrpt.*
				FROM 		t_rtpsrpt
				WHERE		t_rtpsrpt.kdekls='$kdekls'		AND
							t_rtpsrpt.kdeplj='$kdeplj'";
	$result5=mysql_query($query5) or die('Query gagal');
	$data5 =mysql_fetch_array($result5);
			
	$cell3[$n][2]=number_format(($data5['rt'."$sms"."1"]+$data5['rt'."$sms"."2"])/2,0,',','.');

	$cell3[$n][3]=$max;
	$cell3[$n][4]=$min;
	
	$n++;
}

$n=0;
while($n<$k)
{
	$jmlbwh=0;
	$jmlats=0;
	$j=0;
	while($j<$i)
	{
		if($cell[$j][$n+2]<$cell2[$n][1])
		{
			if($cell[$j][$n+2]!=0)
				$jmlbwh++;
		}	
		else
		{
			if($cell[$j][$n+2]!=0)
				$jmlats++;
		}	
		$j++;
	}	

	$cell3[$n][5]=$jmlbwh;
	$cell3[$n][6]=$jmlats;
	$n++;
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
	$pdf->Cell(28	,0.3, $alamat1_pt1,0,0,C);
	$pdf->Ln();
	$pdf->Cell(28	,0.3, $alamat2_pt2,0,0,C);
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(0.5);
	$pdf->Cell( 1	,0.4,"Grade",0,0,L); 
	$pdf->Cell(27	,0.4,": ".$kdekls,0,0,L); 
	$pdf->Ln();

	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.6	,0.5,'No','LRTB',0,C,true);
	$pdf->Cell( 1.4	,0.5,'NIS','LRTB',0,C,true);
	$t=26-(($k+3)*0.9);
	$pdf->Cell( $t	,0.5,'Name','LRTB',0,C,true);
	$n=0;
	while($n<$k)
	{
		$plj=$cell2[$n][2];
		$pdf->Cell( 0.9	,0.5,$plj,'LRTB',0,C,true);
		$n++;
	}
	$pdf->Cell( 0.9	,0.5,'Sum','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.5,'Ave','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.5,'Rank','LRTB',0,C,true);

	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	$x=1;
	while($j<$i AND $x<=30)
	{
		$nis=$cell[$j][0];
		$pdf->Cell( 0.6	,0.4,$no,'LRTB',0,C,true);
		$pdf->Cell( 1.4	,0.4,$nis,'LRTB',0,C,true);
		$pdf->Cell( $t	,0.4,$cell[$j][1],'LRTB',0,L,true);
		$n=0;
		while($n<$k)
		{
			$nliakh	=$cell[$j][$n+2];
			$kdeplj =$cell2[$n][0];
			$kkm	=$cell2[$n][1];
			if(($nliakh<$kkm AND ($kdeplj!='GRM' AND $kdeplj!='MND' AND $kdeplj!='PHY' AND $kdeplj!='BLGY' AND $kdeplj!='CHM')) OR (($kdeplj=='MND' OR $kdeplj=='GRM' OR $kdeplj=='PHY' OR $kdeplj=='BLGY' OR $kdeplj=='CHM') AND $nliakh<$kkm AND $nliakh!=0))
				$pdf->SetTextColor(255,0,0);
			else
				$pdf->SetTextColor(0,0,0);

			if(($kdeplj=='MND' OR $kdeplj=='GRM' OR $kdeplj=='PHY' OR $kdeplj=='BLGY' OR $kdeplj=='CHM') AND $nliakh==0)
				$nliakh='-';
			
			$pdf->Cell( 0.9	,0.4,$nliakh,'LRTB',0,C,true);
			$pdf->SetTextColor(0,0,0);
			$n++;
		}	
		$pdf->SetFillColor(229,229,229); 
		$pdf->Cell( 0.9	,0.4,$cell[$j][$n+2],'LRTB',0,C,true);
		$pdf->Cell( 0.9	,0.4,$cell[$j][$n+3],'LRTB',0,C,true);
		$pdf->Cell( 0.9	,0.4,$rnk,'LRTB',0,C,true);
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();		
		$ttlakh=$ttlakh+$cell[$j][$n+2];
		$ttlavg=$ttlavg+$cell[$j][$n+3];
		$j++;
		$x++;
		$no++;
		$rnk++;
	}
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(153,153,153);
	
	if($j>=$i)
	{
	$pdf->Cell( $t+2	,0.4,'Sum','LRTB',0,C,true);
	
	$n=0;
	while($n<$k)
	{
		$pdf->Cell( 0.9	,0.4,$cell3[$n][1],'LRTB',0,C,true);
		$n++;
	}	
	$pdf->Cell( 0.9	,0.4,$ttlakh,'LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	
	// average
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( $t+2	,0.4,'Average','LRTB',0,C,true);
	$n=0;
	while($n<$k)
	{
		$nliakh	=$cell3[$n][2];
		$kkm	=$cell2[$n][1];
		if($nliakh<$kkm)
			$pdf->SetTextColor(255,0,0);
		else
			$pdf->SetTextColor(0,0,0);
	
		$pdf->Cell( 0.9	,0.4,$nliakh,'LRTB',0,C,true);
		$pdf->SetTextColor(0,0,0);
		$n++;
	}	
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);	

	// highest score
	$pdf->Ln();
	$pdf->Cell( $t+2	,0.4,'Highest Score','LRTB',0,C,true);
	$n=0;
	while($n<$k)
	{
		$max	=$cell3[$n][3];
		$kkm	=$cell2[$n][1];
		if($max<$kkm)
			$pdf->SetTextColor(255,0,0);
		else
			$pdf->SetTextColor(0,0,0);
	
		$pdf->Cell( 0.9	,0.4,$max,'LRTB',0,C,true);
		$pdf->SetTextColor(0,0,0);
		$n++;
	}	
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);	

	// Lowest score
	$pdf->Ln();
	$pdf->Cell( $t+2	,0.4,'Lowest Score','LRTB',0,C,true);
	$n=0;
	while($n<$k)
	{
		$min	=$cell3[$n][4];
		$kkm	=$cell2[$n][1];
		if($min<$kkm)
			$pdf->SetTextColor(255,0,0);
		else
			$pdf->SetTextColor(0,0,0);
	
		$pdf->Cell( 0.9	,0.4,$min,'LRTB',0,C,true);
		$pdf->SetTextColor(0,0,0);
		$n++;
	}	
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);	
	
	// minimum requirement
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(153,153,153);
	$pdf->Ln();
	$pdf->Cell( $t+2	,0.4,'Minimum Requirement','LRTB',0,C,true);
	$n=0;
	while($n<$k)
	{
		$pdf->Cell( 0.9	,0.4,$cell2[$n][1],'LRTB',0,C,true);
		$n++;
	}	
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);	
	}

	// below minimum requirement
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,165,165);
	$pdf->Ln();
	$pdf->Cell( $t+2	,0.4,'Below Minimum Requirement','LRTB',0,C,true);
	$n=0;
	while($n<$k)
	{
		$jmlbwh	=$cell3[$n][5];
		$pdf->Cell( 0.9	,0.4,$jmlbwh,'LRTB',0,C,true);
		$n++;
	}	
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);	

	// Percentage below minimum requirement
	$pdf->Ln();
	$pdf->Cell( $t+2	,0.4,'Percentage (Below Minimum Requirement)','LRTB',0,C,true);
	$n=0;
	while($n<$k)
	{
		$jmlbwh	=$cell3[$n][5];
		$jmlslrh=$cell3[$n][5]+$cell3[$n][6];
		$prcbwh=0;
		if($jmlslrh!=0)
			$prcbwh=number_format(($jmlbwh/$jmlslrh)*100,2,',','.');
		$pdf->Cell( 0.9	,0.4,$prcbwh,'LRTB',0,C,true);
		
		$n++;
	}	
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);	

	// Over minimum requirement
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(229,229,229);
	$pdf->Ln();
	$pdf->Cell( $t+2	,0.4,'Over Minimum Requirement','LRTB',0,C,true);
	$n=0;
	while($n<$k)
	{
		$jmlats	=$cell3[$n][6];
		$pdf->Cell( 0.9	,0.4,$jmlats,'LRTB',0,C,true);
		$n++;
	}	
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);	
	
	// Percentage Over minimum requirement
	$pdf->Ln();
	$pdf->Cell( $t+2	,0.4,'Percentage (Over Minimum Requirement)','LRTB',0,C,true);
	$n=0;
	
	while($n<$k)
	{
		$jmlats	=$cell3[$n][6];
		$jmlslrh=$cell3[$n][5]+$cell3[$n][6];
		$prcats=0;
		if($jmlslrh>0)
			$prcats=number_format(($jmlats/$jmlslrh)*100,2,',','.');
		$pdf->Cell( 0.9	,0.4,$prcats,'LRTB',0,C,true);
		
		$n++;
	}	
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.9	,0.4,'','LRTB',0,C,true);	
	
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
		$pdf->Cell( 12	,0.4,'Bekasi, '.$tglctk,'',0,L,true);
		$pdf->Cell( 12	,0.4,'Approved by','',0,L,true);
		$pdf->Ln();
		$pdf->Cell( 12	,0.4,'Homeroom Teacher : '.$wlikls,'',0,L,true);
		$pdf->Cell( 12	,0.4,'Principal : '.$kplskl,'',0,L,true);
		$pdf->Cell(  4	,0.4," Page : ".$hlm,'',0,R,true);
	} 
}; 
$pdf->Output();
?>