<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04PSMP_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdekls	=$_POST['kdekls'];
//$nis	=$_POST['nis'];
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
			WHERE		t_setthn.set='Tahun Ajaran'"; // menghasilka tahun ajaran
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_smp.*
			FROM 		t_mstbbt_smp
			WHERE		t_mstbbt_smp.kdebbt='1HW'"; // menghasilka bobot 1
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp.*
			FROM 		t_mstbbt_smp
			WHERE		t_mstbbt_smp.kdebbt='2PRJ'"; // menghasilka bobot 2
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp.*
			FROM 		t_mstbbt_smp
			WHERE		t_mstbbt_smp.kdebbt='3TES'"; // menghasilka bobot 3
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp.*
			FROM 		t_mstbbt_smp
			WHERE		t_mstbbt_smp.kdebbt='4MID'"; // menghasilkan bobot 4
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
				ORDER BY	t_prstkt.kdejbt ASC"; // kalu string kplskl kosong
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
			ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id"; // menghasilka subjek rapot per unit
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
					LIMIT		1,1"; // menghasilka satu siswa per kelas per subjek
		$result2 =mysql_query($query2) or die('Query gagal5');
		$data2 	=mysql_fetch_array($result2);
		$nis	=$data2[nis];//asli
		
		/*if($nis!='')
			$nis_x	= $nis;
		else
			$nis_x	=$data2[nis];*/
		
		//$nis_x
		$query3 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_smp.nis,t_prgrptps_smp.kdeplj"; // menghasilka satu siswa per subjek (nilai akhir q1/q2/q3/q4)
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
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; // menghasilka semua siswa per kelas
$result =mysql_query($query) or die('Query gagal5');
$i=0;
while($data =mysql_fetch_array($result))
{
	$cell5[$i][0]=$data[nis];
	$cell5[$i][1]=$data[nmassw];
	$cell5[$i][2]=$data[nisn];
	$cell5[$i][3]=0;
	$nis=$data[nis];//asli
	
	/*if($nis!='')
			$nis_x	= $nis;
		else
			$nis_x	=$data[nis];*/
	
	//$nis_x
	$cell5[$i][4]=$data[tgllhr]; // buatan tgl lahir
	
	$ttlakh1=0;
	$ttlakh2=0;
	$ttlakh=0;
	$n=0;
	while($n<$k)
	{
		$kdeplj=$cell2[$n][0];
	
		$query2 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_smp.nis,t_prgrptps_smp.kdeplj"; // menghasilka satu siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	/*if($nis!='')
			$nis_x	= $nis;
		else
			$nis_x	=$cell5[$y][0];*/
		
	//$nis_x
	$nis	=$cell5[$y][0];
	$nmassw	=$cell5[$y][1];
	$nisn	=$cell5[$y][2];
	
	$tgllhr	=$cell5[$y][4];
	$tgllhr	=strtotime($tgllhr);
	$tgllhr	=date('F d, Y',$tgllhr);

	$query4	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$nis'"; // menghasilka absen per siswa
	$result4=mysql_query($query4) or die('Query gagal');
	$data4 	=mysql_fetch_array($result4);
	$kenaikan	=$data4['kenaikan22'];
	
	$query1 ="	SELECT 		t_setpsrpt.*
				FROM 		t_setpsrpt
				WHERE		t_setpsrpt.kdetkt='$kdetkt'
				ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id"; // menghasilka subjek per unit
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
										t_kkm.kdeplj='". mysql_escape_string($kdeplj)."'"; // menghasilka kkm per kelas per subjek
			$result6 =mysql_query($query6) or die('Query gagal');
			$data6 	=mysql_fetch_array($result6);

			$cell[$i][3]=$data6[kkm];
			$query2 ="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE		t_prgrptps_smp.nis='$nis'		AND
									t_prgrptps_smp.kdeplj='$kdeplj'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$result2=mysql_query($query2) or die('Query gagal');
			$data2 =mysql_fetch_array($result2);
			
			$cell[$i][4]=$data2['akh'."$sms"."1"];
			$cell[$i][5]=$data2['akh'."$sms"."2"];
			$cell[$i][6]=number_format(($cell[$i][4]+$cell[$i][5])/2,0,',','.');
			$nliakh		=$cell[$i][6];
			
			$cell[$i][7]=$data2['akh'."1"."1"]; // q1
			$cell[$i][8]=$data2['akh'."1"."2"]; // q2
			
			
			//$cell[$i][10] = $data2['akh'."2"."1"];
			//$cell[$i][11] = $data2['akh'."2"."2"];

			
		}	
		else
		{
			$cell[$i][3]='';
		}
		$i++;
	}
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Image($logo_pt ,1,0.75,2,2);
	//$pdf->Image($logo_ttw,18,1,2,2);
	//$pdf->Ln(0.8);
	$pdf->Ln(0.75);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(16.5	,0.4, $judul,0,0,C); // 19
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	//$pdf->SetFont('Arial','U',10);
	$pdf->SetFont('Arial','IU',10);
	$pdf->Cell(16.5	,0.4, "STUDENT'S PROGRESS REPORT",0,0,C); // 19 $judul2
	$pdf->Ln();
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(16.5	,0.4, "ACADEMIC YEAR ".$thnajr,0,0,C);// 19
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(16.5	,0.3, '',0,0,C); // 19 $alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(16.5	,0.3, '',0,0,C); // 19 $alamat2_pt2
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(0.1);
	$pdf->Cell( 1	,0.4,"  Junior High",0,0,L); 
	$pdf->Ln(0.5);
	$pdf->Cell( 1	,0.4,"                                  First Semester",0,0,L); 
	$pdf->Cell( 1	,0.4,"                                                                                                                                        Second Semester",0,0,L); 
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1.5	,0.4);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.4	,0.4);
	$pdf->Cell( 1	,0.4,"Mid",0,0,L); 
	$pdf->Cell( 0.24,0.4);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.4	,0.4);
	$pdf->Cell( 1	,0.4,"Final",0,0,L); 
	
	$pdf->Cell( 4	,0.4);
	$pdf->Cell( 1	,0.4,'','LRTB',0,C,true);
	$pdf->Cell( 0.4	,0.4);
	$pdf->Cell( 1	,0.4,"Mid",0,0,L); 
	$pdf->Cell( 0.24,0.4);
	$pdf->Cell( 1	,0.4,'X','LRTB',0,C,true);
	$pdf->Cell( 0.4	,0.4);
	$pdf->Cell( 1	,0.4,"Final",0,0,L); 
	
	
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(0.75);
	$pdf->Cell( 1	,0.4,"Name",0,0,L); 
	$pdf->Cell( 10.5,0.4,"              :  ".$nmassw,0,0,L); // 13
	$pdf->Cell( 1	,0.4,"Date of Birth",0,0,L); // Grade
	$pdf->Cell( 4	,0.4,"              :  ".$tgllhr,0,0,L); // $kdekls
	$pdf->Ln();
	$pdf->Cell( 1	,0.4,"Student No.",0,0,L); // NIS
	$pdf->Cell( 10.5,0.4,"              :  ".substr($nis,0,3),0,0,L); // 13 $nis
	$pdf->Cell( 1	,0.4,"Class",0,0,L); // NISN
	$pdf->Cell( 4	,0.4,"              :  Grade ".substr($kdekls,-2),0,0,L); // $nisn
	$pdf->Ln(0.5);

	$pdf->SetFont('Arial','B',8);
	//$pdf->SetFillColor(153,153,153);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.6	,0.8,'No','LRT',0,C,true);
	$pdf->Cell( 5.7	,0.8,'SUBJECT','LRT',0,C,true); // 6.2
	$pdf->Cell( 2	,0.4,'Minimum'		,'LRT',0,C,true);
	$pdf->Cell( 4	,0.4,'First Semester'		,'LRTB',0,C,true); // 8.2 Mark
	
	$pdf->Cell( 4	,0.4,'Second Semester'		,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0);
	$pdf->Cell( 5.7	,0); // 6.2
	$pdf->Cell( 2	,0.4,'Passing Score'		,'LRB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q2'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Aff'		,'LRTB',0,C,true);
	
	$pdf->Cell( 1	,0.4,'Q3'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q4'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Aff'		,'LRTB',0,C,true);
	$pdf->Ln();
	//------------------------------- Mata Pelajaran Kurikulum Nasional
	$j	=1;
	$no =1;
	$ttlakh=0;
	$jmlplj=0;
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[$j][0];
	//$pdf->Cell(0.6	,0.5,'A','LRTB',0,C,true);						//A
	while ($id<99)
	{
		//menampilkan data dari hasil query database
		$nmasbj	=$cell[$j][1];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		$q1		=$cell[$j][7];
		$q2		=$cell[$j][8];
		$av1	= ($q1 + $q2) / 2;
		/*$q3		=$cell[$j][10];
		$q4		=$cell[$j][11];*/
		
		if($nmasbj!='')
		{
			if(substr($nmasbj,0,1)=='/')
			{
				$nmasbj 	=str_replace("/","","$nmasbj");
				$pdf->SetFont('Arial','B',8);
				$pdf->SetFillColor(204,204,204);
				$pdf->Cell(6.2	,0.5,$nmasbj,'LRTB',0,L,true);		//A
				$nliakh	='';
				$klm	='';
				$rt		='';
			}
			else
			{
				$pdf->SetFont('Arial','',8);
				$pdf->SetFillColor(255,255,255);
				
				if(substr($nmasbj,0,1)!='=')
				{
					$pdf->Cell(0.6	,0.5,$no,'LRTB',0,C,true);
				}
				else
				{
					$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);
				}
				
				if(substr($nmasbj,0,1)!='=')
				{
					$pdf->Cell(0.1	,0.5,'','LTB',0,R,true); // 0.6 $no.'.'
					
					if($nmasbj=='Natural Science (IPA)' OR $nmasbj=='Social Studies (IPS)')
					{
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(5.6	,0.5,$nmasbj,'RTB',0,L,true);
					}
					else
						$pdf->Cell(5.6	,0.5,$nmasbj,'RTB',0,L,true);
					
					$no++;
				}
				else
				{
					$nmasbj 	=str_replace("=","","$nmasbj");
					$pdf->Cell(5.7	,0.5,'        '.$nmasbj,'LRTB',0,L,true); // 6.2
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
			$pdf->Cell( 2	,0.5,$kkm,'LRTB',0,C,true);			//kkm A

			if($q1<$kkm) // if($nliakh<$kkm)
				$pdf->SetTextColor(255,0,0);
			else
				$pdf->SetTextColor(0,0,0);
			
			if($q2==0)
				$q2 = '';
			
			if($av1==0)
				$av1 = '';
			
			
			$pdf->Cell( 1	,0.5,$q1,'LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,$q2,'LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,$av1,'LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
			
			$pdf->SetTextColor(0,0,0);
			
			$pdf->Ln();
		}	
		$j++;
		$id=$cell[$j][0];
	}
	

	//------------------------------- Muatan Lokal 
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[j][0];
	
	while ($id<200)
	{
		//menampilkan data dari hasil query database
		
		$nmasbj=$cell[$j][1];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		$q1		=$cell[$j][7];
		/*$q2	=$cell[$j][8];
		$q3		=$cell[$j][9];
		$q4		=$cell[$j][10];*/
		
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
			$pdf->Cell(0.6	,0.5,$no,'LRTB',0,C,true);
			$pdf->Cell(0.1	,0.5,'','LTB',0,R,true); // 0.6 $no.'.'
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
		if($q1<$kkm)
			$pdf->SetTextColor(255,0,0);
		else
			$pdf->SetTextColor(0,0,0);
		
		$pdf->Cell( 1	,0.5,$q1,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
		$pdf->SetTextColor(0,0,0);
		
		$pdf->Ln();
		$j++;
		$id=$cell[$j][0];
	}
	

	//------------------------------- Pengembangan diri
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	

	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	

	$query3	="	SELECT 		t_extcrrps.*,t_mstplj.*
				FROM 		t_extcrrps,t_mstplj
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj=t_mstplj.kdeplj
				ORDER BY	t_extcrrps.kdeplj"; // extra kurikuler
	$result3=mysql_query($query3) or die('Query gagal40');

	//$z=0;
	while($data3 = mysql_fetch_array($result3))
	{
		if($data3['ext'."$sms"."2"]!='')
		{
			$ext='  '.ucwords(strtolower($data3['nmaplj'])).' : '.$data3['ext'."$sms"."2"];
			
		}	
		//$z++;
	}
	
	
	//------------------------------- Cambridge Curiculum
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[j][0];
	
	while ($j<$i)
	{
		//menampilkan data dari hasil query database
		
		$nmasbj	=$cell[$j][1];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		$q1		=$cell[$j][7];
		/*$q2	=$cell[$j][8];
		$q3		=$cell[$j][9];
		$q4		=$cell[$j][10];*/
		
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
				$pdf->Cell(0.6	,0.5,$no,'LRTB',0,C,true);
				$pdf->Cell(0.1	,0.5,'','LTB',0,R,true); // 0.6 $no.'.'
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
			if($q1<$kkm)
				$pdf->SetTextColor(255,0,0);
			else
				$pdf->SetTextColor(0,0,0);
			
			$pdf->Cell( 1	,0.5,$q1,'LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
			$pdf->SetTextColor(0,0,0);
			
			$pdf->Ln();
		}	
		$j++;
		$id=$cell[$j][0];
	}
	$klm	=str_replace('And','and',ucwords(number_to_words($ttlakh)));
	
	$rtrt	=number_format($rtrt,0,',','.');
	$klm	=ucwords(number_to_words($rtrt));
	$rnk	=$cell5[$y][3];
	
	$pdf->Ln(0.25);
	
	
	
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 8.3	,0.4,'Enrichment / Extra Curricular Activities','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q2'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q3'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q4'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Basketball','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'2','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Culinary','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'3','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Music','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'4','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Interest(Robotic/Manner/Scouting)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'5','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Interest(Science & Math Club/English Club)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	
	
	
	$pdf->Ln(0.6);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 8.3	,0.4,'Personality Traits (Kepribadian)','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q2'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q3'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q4'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Attitude (Kelakuan)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'2','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Diligence/Discipline (Kerajinan/Kedisiplinan)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'3','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Orderliness (Kerapihan)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'4','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Cleanliness (Kebersihan)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	
	
	
	$pdf->Ln(0.6);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 8.3	,0.4,'Absences (Ketidakhadiran)','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q2'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'T'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q3'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q4'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'T'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Sick (Sakit)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'2','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Excused (Ijin)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'3','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Not Excused (Alpa)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->Ln(0.6);
	
	
	
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 8	,0.4,'Affective / Extra-Curricular Activity Aspects','',0,L,true);
	$pdf->Cell( 0.3	,0.4,'','',0,L,true);
	$pdf->Cell( 8	,0.4,'Legend','',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'Scale','LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'Mark','LRTB',0,C,true);
	$pdf->Cell( 5	,0.4,'Description','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.3	,0.4,'','',0,L,true);
	$pdf->Cell( 4	,0.4,'Q1     : 1st Quarter','',0,L,true);
	$pdf->Cell( 4	,0.4,'Q4     : 4th Quarter','',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'85-100','LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'A','LRTB',0,C,true);
	$pdf->Cell( 5	,0.4,'Outstanding','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.3	,0.4,'','',0,L,true);
	$pdf->Cell( 4	,0.4,'Q2     : 2nd Quarter','',0,L,true);
	$pdf->Cell( 4	,0.4,'Av      : Average','',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'70-84','LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'B','LRTB',0,C,true);
	$pdf->Cell( 5	,0.4,'Very Satisfactory','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.3	,0.4,'','',0,L,true);
	$pdf->Cell( 4	,0.4,'Q3     : 3rd Quarter','',0,L,true);
	$pdf->Cell( 4	,0.4,'','',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'60-69','LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'C','LRTB',0,C,true);
	$pdf->Cell( 5	,0.4,'Satisfactory','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.3	,0.4,'','',0,L,true);
	$pdf->Cell( 4	,0.4,'','',0,L,true);
	$pdf->Cell( 4	,0.4,'','',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'Below 60','LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'D','LRTB',0,C,true);
	$pdf->Cell( 5	,0.4,'Needs Improvement','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.3	,0.4,'','',0,L,true);
	$pdf->Cell( 4	,0.4,'','',0,L,true);
	$pdf->Cell( 4	,0.4,'','',0,L,true);
	
	
	
	$pdf->Ln(0.6);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1.6		,0.4,'Comments : ','LT',0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 14.7	,0.4,' It has been so nice working with Angle this school year. She is a very good student who has made excellent','RT',0,L);
	$pdf->Ln();
	$pdf->Cell( 1.6		,0.4,'','L',0,L);
	$pdf->Cell( 14.7	,0.4,' progress in all academic areas and has shown herself to be well balanced in all subjects. Angle has taken great','R',0,L);
	$pdf->Ln();
	$pdf->Cell( 1.6		,0.4,'','L',0,L);
	$pdf->Cell( 14.7	,0.4,' pride all year in putting top effort into everything she has done and it has shown in the quality of work she','R',0,L);
	$pdf->Ln();
	$pdf->Cell( 1.6		,0.4,'','L',0,L);
	$pdf->Cell( 14.7	,0.4,' produces. She is very motivated to do well and has a strong work ethic which helps her achieve at high levels. I','R',0,L);
	$pdf->Ln();
	$pdf->Cell( 1.6		,0.4,'','L',0,L);
	$pdf->Cell( 14.7	,0.4,' truly appreciate her for the effort she has put into her learning. Be blessed and be a blessing! I know you will be a','R',0,L);
	$pdf->Ln();
	$pdf->Cell( 1.6		,0.6,'','LB',0,L);
	$pdf->Cell( 14.7	,0.6,' great success in 9th grade and beyond! Have a wonderful vacation!','RB',0,L);
	//$pdf->Ln();
		
	
	
	$pdf->Ln(0.85);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 4.5	,0.4,$tglctk,'',0,C); // 6
	$pdf->Cell( 7	,0.4,'','',0,C);
	$pdf->Cell( 6	,0.4,'','',0,C); // 'Jakarta, '.
	$pdf->Ln();
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 4.5	,0.4,'( '.$wlikls.' )','',0,C); // 6
	$pdf->Cell( 7	,0.4,'(Ir. '.$kplskl.', MBA)','',0,C);
	$pdf->Cell( 6	,0.4,"(                                )",'',0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 4.5	,0.4,'Homeroom Teacher','',0,C); // 6
	$pdf->Cell( 7	,0.4,'Principal','',0,C);
	$pdf->Cell( 6	,0.4,"Parent",'',0,C);
	$pdf->Ln();
	
	$y++;
};
$pdf->Output();
?>