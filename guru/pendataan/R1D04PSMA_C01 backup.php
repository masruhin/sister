<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04PSMA_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) rapot sma 8-9
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdekls	=$_POST['kdekls'];
//$nis	=$_POST['nis'];
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

// dapatkan data tahun ajaran
$query	="	SELECT 		t_setthn.*
			FROM 		t_setthn
			WHERE		t_setthn.set='Tahun Ajaran'"; // menghasilka tahun ajaran
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='1HW'"; // menghasilka bobot 1
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='2PRJ'"; // menghasilka bobot 2
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='3TES'"; // menghasilka bobot 3
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='4MID'"; // menghasilkan bobot 4
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
$gelar=$data[gelar];
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
$pdf->SetMargins(0.535,0.4,1);//1,0.4,1
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
		$query3 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sma.nis,t_prgrptps_sma.kdeplj"; // menghasilka satu siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	
		$query2 	="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE 		t_prgrptps_sma.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sma.nis,t_prgrptps_sma.kdeplj"; // menghasilka satu siswa per subjek (nilai akhir q1/q2/q3/q4)
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

//..sampai ini

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
	$tgllhr	=date('M d, Y',$tgllhr);

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
			$query2 ="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE		t_prgrptps_sma.nis='$nis'		AND
									t_prgrptps_sma.kdeplj='$kdeplj'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$result2=mysql_query($query2) or die('Query gagal');
			$data2 =mysql_fetch_array($result2);
			
			$cell[$i][4]=$data2['akh'."$sms"."1"];
			$cell[$i][5]=$data2['akh'."$sms"."2"];
			$cell[$i][6]=number_format(($cell[$i][4]+$cell[$i][5])/2,0,',','.');
			$nliakh		=$cell[$i][6];
			
			$cell[$i][7]=$data2['akh'."1"."1"]; // q1
			$cell[$i][8]=$data2['akh'."1"."2"]; // q2
			//$cell[$i][9] = $data2['akh'."2"."1"];//q3
			//$cell[$i][10] = $data2['akh'."2"."2"];//q4

			$cell[$i][11]=$data2['aff'."1"."1"]; // aff1
			//$cell[$i][12]=$data2['aff'."1"."2"]; // aff2
			//$cell[$i][13] = $data2['aff'."2"."1"];//aff3
			//$cell[$i][14] = $data2['aff'."2"."2"];//aff4
			
			$cell[$i][15]=$data2['fgt'."1"."1"]; // fgt1
			//$cell[$i][16]=$data2['fgt'."1"."2"]; // fgt2
			//$cell[$i][17]=$data2['fgt'."2"."1"]; // fgt3
			//$cell[$i][18]=$data2['fgt'."2"."2"]; // fgt4
			
			$cell[$i][19]=$data2['fgp'."1"."1"]; // fgp1
			//$cell[$i][20]=$data2['fgp'."1"."2"]; // fgp2
			//$cell[$i][21]=$data2['fgp'."2"."1"]; // fgp3
			//$cell[$i][22]=$data2['fgp'."2"."2"]; // fgp4
		}	
		else
		{
			$cell[$i][3]='';
		}
		$i++;
	}
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Image($logo_pt ,0.625,0.75,2,2);//1,0.75,2,2
	//$pdf->Image($logo_ttw,18,1,2,2);
	//$pdf->Ln(0.8);
	$pdf->Ln(0.75);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(19.22	,0.4, $judul,0,0,C); // 19
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	//$pdf->SetFont('Arial','U',10);
	$pdf->SetFont('Arial','IU',10);
	$pdf->Cell(19.1	,0.4, "STUDENT'S PROGRESS REPORT",0,0,C); // 19 $judul2
	$pdf->Ln();
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(19	,0.4, "ACADEMIC YEAR ".$thnajr,0,0,C);// 19
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(18	,0.3, '',0,0,C); // 19 $alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(18	,0.3, '',0,0,C); // 19 $alamat2_pt2
	
	
	
	$strX11 = '';
	$strX12 = '';
	$strX21 = '';
	$strX22 = '';
	
	if ( $sms==1 AND $midtrm ==1 )
	{
		$strX11 = 'X';
		$strX12 = '';
		$strX21 = '';
		$strX22 = '';
	}
	else if ( $sms==1 AND $midtrm ==2 )
	{
		$strX11 = '';
		$strX12 = 'X';
		$strX21 = '';
		$strX22 = '';
	}
	else if ( $sms==2 AND $midtrm ==1 )
	{
		$strX11 = '';
		$strX12 = '';
		$strX21 = 'X';
		$strX22 = '';
	}
	else //if ( $sms==2 AND $midtrm ==2 )
	{
		$strX11 = '';
		$strX12 = '';
		$strX21 = '';
		$strX22 = 'X';
	}
	
	
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(0.1);
	$pdf->Cell( 1	,0.4,"  Senior High",0,0,L); 
	$pdf->Ln(0.5);
	$pdf->Cell( 3	,0);
	$pdf->Cell( 1	,0.4,"                                  First Semester",0,0,L); 
	$pdf->Cell( 4.7	,0);
	$pdf->Cell( 1	,0.4,"                                  Second Semester",0,0,L); 
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 4.5	,0.4);
	$pdf->Cell( 1	,0.4,$strX11,'LRTB',0,C,true);
	$pdf->Cell( 0.4	,0.4);
	$pdf->Cell( 1	,0.4,"Mid",0,0,L); 
	$pdf->Cell( 0.24,0.4);
	$pdf->Cell( 1	,0.4,$strX12,'LRTB',0,C,true);
	$pdf->Cell( 0.4	,0.4);
	$pdf->Cell( 1	,0.4,"Final",0,0,L); 
	
	$pdf->Cell( 1	,0.4);
	$pdf->Cell( 1	,0.4,$strX21,'LRTB',0,C,true);
	$pdf->Cell( 0.4	,0.4);
	$pdf->Cell( 1	,0.4,"Mid",0,0,L); 
	$pdf->Cell( 0.24,0.4);
	$pdf->Cell( 1	,0.4,$strX22,'LRTB',0,C,true);
	$pdf->Cell( 0.4	,0.4);
	$pdf->Cell( 1	,0.4,"Final",0,0,L); 
	
	
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(0.75);
	$pdf->Cell( 1	,0.4,"Name",0,0,L); 
	$pdf->Cell( 14.5,0.4,"              :  ".$nmassw,0,0,L); // 13
	$pdf->Cell( 1	,0.4,"Date of Birth",0,0,L); // Grade
	$pdf->Cell( 4	,0.4,"              :  ".$tgllhr,0,0,L); // $kdekls
	$pdf->Ln();
	$pdf->Cell( 1	,0.4,"Student No.",0,0,L); // NIS
	$pdf->Cell( 14.5,0.4,"              :  ".substr($nis,0,3),0,0,L); // 13 $nis
	$pdf->Cell( 1	,0.4,"Class",0,0,L); // NISN
	$pdf->Cell( 4	,0.4,"              :  Grade ".substr($kdekls,4,2),0,0,L); // $nisn
	$pdf->Ln(0.5);

	$pdf->SetFont('Arial','B',8);
	//$pdf->SetFillColor(153,153,153);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.6	,1.2,'No','LRT',0,C,true);
	$pdf->Cell( 5.7	,1.2,'SUBJECT','LRT',0,C,true); // 6.2
	$pdf->Cell( 1.75	,0.4,'Minimum'		,'LRT',0,C,true);
	$pdf->Cell( 6	,0.4,'First Semester'		,'LRTB',0,C,true); // 8.2 Mark
	$pdf->Cell( 6	,0.4,'Second Semester'		,'LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 0.6	,0);
	$pdf->Cell( 5.7	,0); // 6.2
	$pdf->Cell( 1.75	,0.4,'Passing'		,'LR',0,C,true);
	$pdf->Cell( 2.25	,0.4,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,'Q2'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Sm'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.8,'Aff'		,'LRTB',0,C,true);
	
	$pdf->Cell( 2.25	,0.4,'Q3'		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,'Q4'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Sm'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.8,'Aff'		,'LRTB',0,C,true);
	
	$pdf->Ln(0.4);
	$pdf->Cell( 0.6	,0);
	$pdf->Cell( 5.7	,0); // 6.2
	$pdf->Cell( 1.75	,0.4,'Score'		,'LRB',0,C,true);
	
	$pdf->Cell( 0.75	,0.4,'Th'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Pr'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Th'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Pr'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Av'		,'LRTB',0,C,true);
	
	$pdf->Cell( 0.75	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0);
	
	$pdf->Cell( 0.75	,0.4,'Th'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Pr'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Th'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Pr'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Av'		,'LRTB',0,C,true);
	
	$pdf->Cell( 0.75	,0.4,'Av'		,'LRTB',0,C,true);
	//$pdf->Cell( 0.75	,0);
	
	$pdf->Ln();
	//------------------------------- Mata Pelajaran Kurikulum Nasional
	$j	=1;
	$no =1;
	$ttlakh=0;
	$jmlplj=0;
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[$j][0];
	
	while ($id<99)
	{
		//menampilkan data dari hasil query database
		$nmasbj	=$cell[$j][1];
		$kdeplj	=$cell[$j][2];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		$q1		=$cell[$j][7];
		$q2		=$cell[$j][8];
		//$q3		=$cell[$j][9];
		//$q4		=$cell[$j][10];
		
		if($q2=='0')
			$av1	= $q1;
		else
			$av1	= ($q1 + $q2) / 2;
		
		$aff1		=$cell[$j][11];
		//$aff2		=$cell[$j][12];
		//$aff3		=$cell[$j][13];
		//$aff4		=$cell[$j][14];
		
		$fgt1		=$cell[$j][15];
		//$fgt2		=$cell[$j][16];
		//$fgt3		=$cell[$j][17];
		//$fgt4		=$cell[$j][18];
		
		$fgp1		=$cell[$j][19];
		//$fgp2		=$cell[$j][20];
		//$fgp3		=$cell[$j][21];
		//$fgp4		=$cell[$j][22];
		
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
				
				if($q1==0)
				{
					$kkm	='';
					
				}
				else
				{
					$ttlakh	=$ttlakh+$nliakh;
					$jmlplj	=$jmlplj+1;
				}
			}	
			$pdf->Cell( 1.75	,0.5,$kkm,'LRTB',0,C,true);			//kkm A
			
			//q1
			if($q1<$kkm)
				$pdf->SetTextColor(255,0,0);
			else
				$pdf->SetTextColor(0,0,0);
			
			$qBLGY ="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE		t_prgrptps_sma.nis='$nis'		AND
									t_prgrptps_sma.kdeplj='BLGY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rBLGY=mysql_query($qBLGY) or die('Query gagal');
			$dBLGY =mysql_fetch_array($rBLGY);
			$q1BLGY=$dBLGY['akh'."1"."1"]; // q1
			$aff1BLGY=$dBLGY['aff'."1"."1"]; // aff1
			
			$qPHY ="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE		t_prgrptps_sma.nis='$nis'		AND
									t_prgrptps_sma.kdeplj='PHY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rPHY=mysql_query($qPHY) or die('Query gagal');
			$dPHY =mysql_fetch_array($rPHY);
			$q1PHY=$dPHY['akh'."1"."1"]; // q1
			$aff1PHY=$dPHY['aff'."1"."1"]; // aff1
			
			//$aff1IPA='';
			
			$q1IPA = number_format( ( $q1BLGY + $q1PHY ) / 2);
			if ( $kdeplj == 'IPA' )
				$q1 = $q1IPA;
			
			$qECN ="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE		t_prgrptps_sma.nis='$nis'		AND
									t_prgrptps_sma.kdeplj='ECN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rECN=mysql_query($qECN) or die('Query gagal');
			$dECN =mysql_fetch_array($rECN);
			$q1ECN=$dECN['akh'."1"."1"]; // q1
			$aff1ECN=$dECN['aff'."1"."1"]; // aff1
			
			$qHIST ="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE		t_prgrptps_sma.nis='$nis'		AND
									t_prgrptps_sma.kdeplj='HIST'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rHIST=mysql_query($qHIST) or die('Query gagal');
			$dHIST =mysql_fetch_array($rHIST);
			$q1HIST=$dHIST['akh'."1"."1"]; // q1
			$aff1HIST=$dHIST['aff'."1"."1"]; // aff1
			
			$qGGRY ="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE		t_prgrptps_sma.nis='$nis'		AND
									t_prgrptps_sma.kdeplj='GGRY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rGGRY=mysql_query($qGGRY) or die('Query gagal');
			$dGGRY =mysql_fetch_array($rGGRY);
			$q1GGRY=$dGGRY['akh'."1"."1"]; // q1
			$aff1GGRY=$dGGRY['aff'."1"."1"]; // aff1
			
			$q1IPS = number_format( ( $q1ECN + $q1HIST + $q1GGRY ) / 3);
			if ( $kdeplj == 'IPS' )
				$q1 = $q1IPS;
			
			
			
			
			
			
			//q2
			if($q2==0)
				$q2 = '';
			
			//av
			if($av1==0)
			{
				if( $kdeplj=='IPA' )
				{
					if( $q2==0 )
					{
						$av1 = $q1IPA;
					}
				}
				else if( $kdeplj=='IPS' )
				{
					if( $q2==0 )
					{
						$av1 = $q1IPS;
					}
				}
				else
					$av1 = '';
			}
			else
			{
				if( $kdeplj=='BLGY' OR $kdeplj=='PHY' OR $kdeplj=='ECN' OR $kdeplj=='HIST' OR $kdeplj=='GGRY' )
				{
					$av1 = '';
				}
			}
			
			
			
			//aff
			$lg1 = '';
			if ( $aff1!=0 )
			{
				if ( $kdeplj=='BLGY' OR $kdeplj=='PHY' OR $kdeplj=='ECN' OR $kdeplj=='HIST' OR $kdeplj=='GGRY' )
				{
					
				}
				else
				{
					if($aff1>100)
						$lg1 = 'ERR';
					else if($aff1>=85)
						$lg1 = 'A';
					else if($aff1>=70)
						$lg1 = 'B';
					else if($aff1>=60)
						$lg1 = 'C';
					else
						$lg1 = 'D';
				}
			}
			else
			{
				if( $kdeplj=='IPA' )
				{
					if( $aff1BLGY < $aff1PHY )
					{
						$aff1 = $aff1BLGY;
						
						if($aff1>100)
							$lg1 = 'ERR';
						else if($aff1>=85)
							$lg1 = 'A';
						else if($aff1>=70)
							$lg1 = 'B';
						else if($aff1>=60)
							$lg1 = 'C';
						else
							$lg1 = 'D';
					}
					else
					{
						$aff1 = $aff1PHY;
						
						if($aff1>100)
							$lg1 = 'ERR';
						else if($aff1>=85)
							$lg1 = 'A';
						else if($aff1>=70)
							$lg1 = 'B';
						else if($aff1>=60)
							$lg1 = 'C';
						else
							$lg1 = 'D';
					}
				}
				else if( $kdeplj=='IPS' )
				{
					if( $aff1ECN == 0 )
					{
						if( $aff1GGRY < $aff1HIST )
						{
							$aff1 = $aff1GGRY;
							
							if($aff1>100)
								$lg1 = 'ERR';
							else if($aff1>=85)
								$lg1 = 'A';
							else if($aff1>=70)
								$lg1 = 'B';
							else if($aff1>=60)
								$lg1 = 'C';
							else
								$lg1 = 'D';
						}
						else
						{
							$aff1 = $aff1HIST;
							
							if($aff1>100)
								$lg1 = 'ERR';
							else if($aff1>=85)
								$lg1 = 'A';
							else if($aff1>=70)
								$lg1 = 'B';
							else if($aff1>=60)
								$lg1 = 'C';
							else
								$lg1 = 'D';
						}
					}
					else
					{
						$aff1 = $aff1ECN;
						
						if($aff1>100)
							$lg1 = 'ERR';
						else if($aff1>=85)
							$lg1 = 'A';
						else if($aff1>=70)
							$lg1 = 'B';
						else if($aff1>=60)
							$lg1 = 'C';
						else
							$lg1 = 'D';
					}
				}
			}
			
			
			
			$pdf->Cell( 0.75	,0.5,$fgt1,'LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,$fgp1,'LRTB',0,C,true);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell( 0.75	,0.5,$av1,'LRTB',0,C,true);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			
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
		$kdeplj	=$cell[$j][2];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		$q1		=$cell[$j][7];
		$q2		=$cell[$j][8];
		//$q3		=$cell[$j][9];
		//$q4		=$cell[$j][10];
		
		if($q2=='0')
			$av1	= $q1;
		else
			$av1	= ($q1 + $q2) / 2;
		
		$aff1		=$cell[$j][11];
		//$aff2		=$cell[$j][12];
		//$aff3		=$cell[$j][13];
		//$aff4		=$cell[$j][14];
		
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
		
		$pdf->Cell( 1.75	,0.5,$kkm,'LRTB',0,C,true);			//kkm B
		
		if($q1<$kkm)
			$pdf->SetTextColor(255,0,0);
		else
			$pdf->SetTextColor(0,0,0);
		
		if($q2==0)
				$q2 = '';
			
		if($av1==0)
			$av1 = '';
		
		if($aff1!=0)
		{
			if($aff1>100)
				$lg = 'ERR';
			else if($aff1>=85)
				$lg = 'A';
			else if($aff1>=70)
				$lg = 'B';
			else if($aff1>=60)
				$lg = 'C';
			else
				$lg = 'D';
		}
		else
		{
			$lg = '';
		}
		
		$pdf->Cell( 0.75	,0.5,$q1,'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,$q2,'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,$av1,'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,$lg1,'LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
		
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
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
	$q1='';
	
	while ($j<$i)
	{
		//menampilkan data dari hasil query database
		
		$nmasbj	=$cell[$j][1];
		$kdeplj	=$cell[$j][2];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		$q1		=$cell[$j][7];
		$q2		=$cell[$j][8];
		//$q3		=$cell[$j][9];
		//$q4		=$cell[$j][10];
		
		if($q2=='0')
			$av1	= $q1;
		else
			$av1	= ($q1 + $q2) / 2;
		
		$aff1		=$cell[$j][11];
		//$aff2		=$cell[$j][12];
		//$aff3		=$cell[$j][13];
		//$aff4		=$cell[$j][14];
		
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
			$pdf->Cell( 1.75	,0.5,$kkm,'LRTB',0,C,true);			//kkm C
			
			//q1
			if($q1<$kkm)
				$pdf->SetTextColor(255,0,0);
			else
				$pdf->SetTextColor(0,0,0);
			
			$qMND ="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE		t_prgrptps_sma.nis='$nis'		AND
									t_prgrptps_sma.kdeplj='MND'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rMND=mysql_query($qMND) or die('Query gagal');
			$dMND =mysql_fetch_array($rMND);
			$q1MND=$dMND['akh'."1"."1"]; // q1
			
			$qGRM ="	SELECT 		t_prgrptps_sma.*
						FROM 		t_prgrptps_sma
						WHERE		t_prgrptps_sma.nis='$nis'		AND
									t_prgrptps_sma.kdeplj='GRM'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rGRM=mysql_query($qGRM) or die('Query gagal');
			$dGRM =mysql_fetch_array($rGRM);
			$q1GRM=$dGRM['akh'."1"."1"]; // q1
			
			if ( $kdeplj == 'FOR' )
			{
				if ( $q1MND == 0 )
					$q1 = $q1GRM;
				else
					$q1 = $q1MND;
			}
			
			//q2
			if($q2==0)
				$q2 = '';
			
			//av
			if($av1==0)
			{
				if ( $kdeplj == 'FOR' )
				{
					if ( $q1MND == 0 )
						$av1 = $q1GRM;
					else
						$av1 = $q1MND;
				}
				else
					$av1 = '';
			}
			
			//aff
			$aff1MND=$dMND['aff'."1"."1"]; // aff1
			$aff1GRM=$dGRM['aff'."1"."1"]; // aff1
			
			if($aff1!=0)
			{
				if($aff1>100)
					$lg = 'ERR';
				else if($aff1>=85)
					$lg = 'A';
				else if($aff1>=70)
					$lg = 'B';
				else if($aff1>=60)
					$lg = 'C';
				else
					$lg = 'D';
			}
			else
			{
				if ( $kdeplj == 'FOR' )
				{
					if ( $q1MND == 0 )
					{
						$aff1 = $aff1GRM;
						
						if($aff1>100)
							$lg = 'ERR';
						else if($aff1>=85)
							$lg = 'A';
						else if($aff1>=70)
							$lg = 'B';
						else if($aff1>=60)
							$lg = 'C';
						else
							$lg = 'D';
					}
					else
					{
						$aff1 = $aff1MND;
						
						if($aff1>100)
							$lg = 'ERR';
						else if($aff1>=85)
							$lg = 'A';
						else if($aff1>=70)
							$lg = 'B';
						else if($aff1>=60)
							$lg = 'C';
						else
							$lg = 'D';
					}
				}
				else
					$lg = '';
			}
			
			$pdf->Cell( 0.75	,0.5,$q1,'LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,$q2,'LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,$av1,'LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,$lg1,'LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
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
	
	
	
	$nmaPil1='';
	$ktrPil1='';
	$nmaPil2='';
	$ktrPil2='';
	$nmaPil3='';
	$ktrPil3='';
	$nmaPil4='';
	$ktrPil4='';
	$nmaPil5='';
	$ktrPil5='';
	
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 8.05	,0.4,'Enrichment / Extra Curricular Activities','LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,'Q2'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,'Q3'		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,'Q4'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//basketball
	$qBSK	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='BSK' "; // extra kurikuler
	$rBSK=mysql_query($qBSK) or die('Query gagal40');
	$dBSK =mysql_fetch_array($rBSK);
	$q1BSK=$dBSK['ext'."1"."1"]; // q1 BSK
	$q2BSK=$dBSK['ext'."1"."2"]; // q2 BSK
	if($q1BSK!='')
	{
		$nmaPil1='BASKET BALL';
		$ktrPil1=$q1BSK;
	}
	if($q2BSK!='')
	{
		$nmaPil2='BASKET BALL';
		$ktrPil2=$q2BSK;
	}
	//futsal
	$qFTS	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='FTS' "; // extra kurikuler
	$rFTS=mysql_query($qFTS) or die('Query gagal40');
	$dFTS =mysql_fetch_array($rFTS);
	$q1FTS=$dFTS['ext'."1"."1"]; // q1 FTS
	$q2FTS=$dFTS['ext'."1"."2"]; // q2 FTS
	if($q1FTS!='')
	{
		$nmaPil1='FUTSAL';
		$ktrPil1=$q1FTS;
	}
	if($q2FTS!='')
	{
		$nmaPil2='FUTSAL';
		$ktrPil2=$q2FTS;
	}
	
	//av1
	$aveEXT1='';
	if($ktrPil2=='')
		$aveEXT1=$ktrPil1;
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Sport Interest(Basketball/Futsal)','LRTB',0,L,true);//$nmaPil1
	$pdf->Cell( 2.25	,0.4,$ktrPil1		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$aveEXT1		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//culinari
	$qCLN	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='CLN' "; // extra kurikuler
	$rCLN=mysql_query($qCLN) or die('Query gagal40');
	$dCLN =mysql_fetch_array($rCLN);
	$q1CLN=$dCLN['ext'."1"."1"]; // q1 CLN
	if($q1CLN!='')
	{
		$nmaPil2='Culinary';
		$ktrPil2=$q1CLN;
	}
	
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'2','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Culinary','LRTB',0,L,true);//$nmaPil2
	$pdf->Cell( 2.25	,0.4,$ktrPil2		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//Interest(Robotic/Manner/Scouting)
	$qRBT	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='RBT' "; // extra kurikuler
	$rRBT=mysql_query($qRBT) or die('Query gagal40');
	$dRBT =mysql_fetch_array($rRBT);
	$q1RBT=$dRBT['ext'."1"."1"]; // q1 RBT
	if($q1RBT!='')
	{
		$nmaPil3='Interest(Robotic/Manner/Scouting)';
		$ktrPil3=$q1RBT;
	}
	
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'3','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Interest(Robotic/Manner)','LRTB',0,L,true);//$nmaPil3
	$pdf->Cell( 2.25	,0.4,$ktrPil3		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//music
	$qMSC	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='MSC' "; // extra kurikuler
	$rMSC=mysql_query($qMSC) or die('Query gagal40');
	$dMSC =mysql_fetch_array($rMSC);
	$q1MSC=$dMSC['ext'."1"."1"]; // q1 MSC
	$q2MSC=$dMSC['ext'."1"."2"]; // q2 MSC
	if($q1MSC!='')
	{
		$nmaPil4='Music';
		$ktrPil4=$q1MSC;
	}
	if($q2MSC!='')
	{
		$nmaPil4='Music';
		$ktrPil4=$q2MSC;
	}
	
	//av1
	$aveEXT1='';
	if($q2MSC=='')
		$aveEXT1=$q1MSC;
	
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'4','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Music Ensemble','LRTB',0,L,true);//$nmaPil4
	$pdf->Cell( 2.25	,0.4,$ktrPil4		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$aveEXT1		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//Interest(Science & Math Club/English Club)
	$qCLB	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='CLB' "; // extra kurikuler
	$rCLB=mysql_query($qCLB) or die('Query gagal40');
	$dCLB =mysql_fetch_array($rCLB);
	$q1CLB=$dCLB['ext'."1"."1"]; // q1 CLB
	if($q1CLB!='')
	{
		$nmaPil5='Interest(Science & Math Club/English Club)';
		$ktrPil5=$q1CLB;
	}
	
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'5','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Interest(Science & Math Club/English Club)','LRTB',0,L,true);//$nmaPil5
	$pdf->Cell( 2.25	,0.4,$ktrPil5		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	$pdf->Ln(0.6);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 8.05	,0.4,'Personality Traits (Kepribadian)','LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,'Q2'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,'Q3'		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,'Q4'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//personality traits
	$qPER	="	SELECT 		t_personps.*
				FROM 		t_personps
				WHERE		t_personps.nis='$nis' "; // menghasilka nilai kepribadian
	$rPER=mysql_query($qPER) or die('Query gagal40');
	$dPER =mysql_fetch_array($rPER);
	
	$q1ATT=$dPER['att'."1"."1"]; // q1 att
	$q1DIL=$dPER['dil'."1"."1"]; // q1 dil
	$q1ORD=$dPER['ord'."1"."1"]; // q1 ord
	$q1CLE=$dPER['cle'."1"."1"]; // q1 cle
	
	$q2ATT=$dPER['att'."1"."2"]; // q2 att
	$q2DIL=$dPER['dil'."1"."2"]; // q2 dil
	$q2ORD=$dPER['ord'."1"."2"]; // q2 ord
	$q2CLE=$dPER['cle'."1"."2"]; // q2 cle
	
	if($q2ATT=='')
		$a1ATT=$q1ATT;
	if($q2DIL=='')
		$a1DIL=$q1DIL;
	if($q2ORD=='')
		$a1ORD=$q1ORD;
	if($q2CLE=='')
		$a1CLE=$q1CLE;
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Attitude (Kelakuan)','LRTB',0,L,true);
	$pdf->Cell( 2.25	,0.4,$q1ATT		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$a1ATT		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'2','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Diligence/Discipline (Kerajinan/Kedisiplinan)','LRTB',0,L,true);
	$pdf->Cell( 2.25	,0.4,$q1DIL		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$a1DIL		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'3','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Orderliness (Kerapihan)','LRTB',0,L,true);
	$pdf->Cell( 2.25	,0.4,$q1ORD		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$a1ORD		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'4','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Cleanliness (Kebersihan)','LRTB',0,L,true);
	$pdf->Cell( 2.25	,0.4,$q1CLE		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$a1CLE		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	$pdf->Ln(0.6);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 8.05	,0.4,'Absences (Ketidakhadiran)','LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,'Q2'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'T'		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,'Q3'		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,'Q4'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,'T'		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//absences
	$qABS	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$nis' "; // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	
	$q1SKT=$dABS['skt'."1"."1"]; // q1 skt
	$q1IZN=$dABS['izn'."1"."1"]; // q1 izn
	$q1ALP=$dABS['alp'."1"."1"]; // q1 alp
	$q1KMN=$dABS['kmn'.$sms.$midtrm]; // q1 kmn
	
	$q2SKT=$dABS['skt'."1"."2"]; // q2 skt
	$q2IZN=$dABS['izn'."1"."2"]; // q2 izn
	$q2ALP=$dABS['alp'."1"."2"]; // q2 alp
	//$q2KMN=$dABS['kmn'."1"."2"]; // q2 kmn
	
	$t1SKT=$q1SKT+$q2SKT;
	$t1IZN=$q1IZN+$q2IZN;
	$t1ALP=$q1ALP+$q2ALP;
	//$t1KMN=$q1KMN+$q2KMN;
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Sick (Sakit)','LRTB',0,L,true);
	$pdf->Cell( 2.25	,0.4,$q1SKT		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$t1SKT		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'2','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Excused (Ijin)','LRTB',0,L,true);
	$pdf->Cell( 2.25	,0.4,$q1IZN		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$t1IZN		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'3','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Not Excused (Alpa)','LRTB',0,L,true);
	$pdf->Cell( 2.25	,0.4,$q1ALP		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$t1ALP		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln(0.6);
	
	
	
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 8	,0.4,'Affective / Extra-Curricular Activity Aspects','',0,L,true);
	$pdf->Cell( 1	,0.4,'','',0,L,false);
	$pdf->Cell( 8	,0.4,'Legend','',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'Scale','LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'Mark','LRTB',0,C,true);
	$pdf->Cell( 5	,0.4,'Description','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1	,0.4,'','',0,L,false);
	$pdf->Cell( 4	,0.4,'Q1           : 1st Quarter','',0,L,true);
	$pdf->Cell( 0.5	,0.4,'','',0,L,true);
	$pdf->Cell( 4	,0.4,'Th     : Theory','',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'85-100','LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'A','LRTB',0,C,true);
	$pdf->Cell( 5	,0.4,'Outstanding','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1	,0.4,'','',0,L,false);
	$pdf->Cell( 4	,0.4,'Q2           : 2nd Quarter','',0,L,true);
	$pdf->Cell( 0.5	,0.4,'','',0,L,true);
	$pdf->Cell( 4	,0.4,'Pr      : Practice','',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'70-84','LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'B','LRTB',0,C,true);
	$pdf->Cell( 5	,0.4,'Very Satisfactory','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1	,0.4,'','',0,L,false);
	$pdf->Cell( 4	,0.4,'Q3           : 3rd Quarter','',0,L,true);
	$pdf->Cell( 0.5	,0.4,'','',0,L,true);
	$pdf->Cell( 4	,0.4,'Av     : Average','',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'60-69','LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'C','LRTB',0,C,true);
	$pdf->Cell( 5	,0.4,'Satisfactory','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1	,0.4,'','',0,L,false);
	$pdf->Cell( 4	,0.4,'Q4           : 4th Quarter','',0,L,true);
	$pdf->Cell( 0.5	,0.4,'','',0,L,true);
	$pdf->Cell( 4	,0.4,'Aff     : Affective Grade','',0,L,true);
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'Below 60','LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'D','LRTB',0,C,true);
	$pdf->Cell( 5	,0.4,'Needs Improvement','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1	,0.4,'','',0,L,false);
	$pdf->Cell( 4	,0.4,'Sm Av     : Semester Average','',0,L,true);
	$pdf->Cell( 0.5	,0.4,'','',0,L,true);
	$pdf->Cell( 4	,0.4,'T       : Total','',0,L,true);
	
	
	
	$pdf->Ln(0.6);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1.6		,0.4,'Comments : ','LT',0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 18.46	,0.4,' '.substr($q1KMN,0,140),'RT',0,L);
	
	$pdf->Ln();
	$pdf->Cell( 1.6		,0.4,'','L',0,L);
	$pdf->Cell( 18.46	,0.4,' '.substr($q1KMN,140,140),'R',0,L);
	
	$pdf->Ln();
	$pdf->Cell( 1.6		,0.4,'','LB',0,L);
	$pdf->Cell( 18.46	,0.4,' '.substr($q1KMN,280,140),'RB',0,L);
		
	
	
	$pdf->Ln(0.85);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 4.5	,0.4,$tglctk,'',0,C); // 6
	$pdf->Cell( 2	,0);
	$pdf->Cell( 7	,0.4,'','',0,C);
	$pdf->Cell( 1	,0);
	$pdf->Cell( 6	,0.4,'','',0,C); // 'Jakarta, '.
	$pdf->Ln();
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 4.5	,0.4,'('.$wlikls.$gelar.')','',0,C); // 6
	$pdf->Cell( 2	,0);
	$pdf->Cell( 7	,0.4,'(Ir. '.$kplskl.', MBA)','',0,C);
	$pdf->Cell( 1	,0);
	$pdf->Cell( 6	,0.4,"(                                )",'',0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 4.5	,0.4,'Homeroom Teacher','',0,C); // 6
	$pdf->Cell( 2	,0);
	$pdf->Cell( 7	,0.4,'Principal','',0,C);
	$pdf->Cell( 1	,0);
	$pdf->Cell( 6	,0.4,"Parent",'',0,C);
	$pdf->Ln();
	
	$y++;
};
$pdf->Output();
?>