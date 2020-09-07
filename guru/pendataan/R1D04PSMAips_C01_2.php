<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04PSMAips_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) rapot sma 11 ips
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdekls	=$_GET['kdekls'];
//$nis	=$_POST['nis'];
$sms	='1';//$_POST['sms'];
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



//Q2




// dapatkan data tahun ajaran
$query	="	SELECT 		t_setthn_sma.*
			FROM 		t_setthn_sma
			WHERE		t_setthn_sma.set='Tahun Ajaran'"; // menghasilka tahun ajaran
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
$signature	="../../images/signature.jpg";

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
					//$pdf->Cell(0.6	,0.5,$no,'LRTB',0,C,true);
				}
				else
				{
					//$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);
				}
				
				if(substr($nmasbj,0,1)!='=')
				{
					//$pdf->Cell(0.1	,0.5,'','LTB',0,R,true); // 0.6 $no.'.'
					
					if($nmasbj=='Natural Science (IPA)' OR $nmasbj=='Social Studies (IPS)')
					{
						//$pdf->SetFont('Arial','B',8);
						//$pdf->Cell(5.6	,0.5,$nmasbj,'RTB',0,L,true);
					}
					else
						//$pdf->Cell(5.6	,0.5,$nmasbj,'RTB',0,L,true);
					
					$no++;
				}
				else
				{
					$nmasbj 	=str_replace("=","","$nmasbj");
					//$pdf->Cell(5.7	,0.5,'        '.$nmasbj,'LRTB',0,L,true); // 6.2
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
			
			//$pdf->Cell( 1.75	,0.5,$kkm,'LRTB',0,C,true);			//kkm A
			
			//q1
			if($q1<$kkm)
			{
				$q1='DF';
				//$pdf->SetTextColor(255,0,0);
			}
			/*else
				$pdf->SetTextColor(0,0,0);*/
			
			
			
			
			
			/*$pdf->Cell( 0.75	,0.5,$fgt1,'LRTB',0,C,true);
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
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);*/
			
			$pdf->SetTextColor(0,0,0);
			
			//$pdf->Ln();
		}	
		$j++;
		$id=$cell[$j][0];
	}
	
	
	
	//..awal
	$qKKMrlg 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='RLG'"; // menghasilka kkm per kelas per subjek
	$rKKMrlg	=mysql_query($qKKMrlg) or die('Query gagal');
	$dKKMrlg	=mysql_fetch_array($rKKMrlg);
	$nKKMrlg	=$dKKMrlg[kkm];
	
	$qKKMcme 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='CME'"; // menghasilka kkm per kelas per subjek
	$rKKMcme	=mysql_query($qKKMcme) or die('Query gagal');
	$dKKMcme	=mysql_fetch_array($rKKMcme);
	$nKKMcme	=$dKKMcme[kkm];
	
	$qKKMbin 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='BIN'"; // menghasilka kkm per kelas per subjek
	$rKKMbin	=mysql_query($qKKMbin) or die('Query gagal');
	$dKKMbin	=mysql_fetch_array($rKKMbin);
	$nKKMbin	=$dKKMbin[kkm];
	
	$qKKMeng 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='ENG'"; // menghasilka kkm per kelas per subjek
	$rKKMeng	=mysql_query($qKKMeng) or die('Query gagal');
	$dKKMeng	=mysql_fetch_array($rKKMeng);
	$nKKMeng	=$dKKMeng[kkm];
	
	$qKKMmth 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='MTH'"; // menghasilka kkm per kelas per subjek
	$rKKMmth	=mysql_query($qKKMmth) or die('Query gagal');
	$dKKMmth	=mysql_fetch_array($rKKMmth);
	$nKKMmth	=$dKKMmth[kkm];
	
	$qKKMblgy 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='BLGY'"; // menghasilka kkm per kelas per subjek
	$rKKMblgy	=mysql_query($qKKMblgy) or die('Query gagal');
	$dKKMblgy	=mysql_fetch_array($rKKMblgy);
	$nKKMblgy	=$dKKMblgy[kkm];
	
	$qKKMecn 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='ECN'"; // menghasilka kkm per kelas per subjek
	$rKKMecn	=mysql_query($qKKMecn) or die('Query gagal');
	$dKKMecn	=mysql_fetch_array($rKKMecn);
	$nKKMecn	=$dKKMecn[kkm];
	
	$qKKMchm 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='CHM'"; // menghasilka kkm per kelas per subjek
	$rKKMchm	=mysql_query($qKKMchm) or die('Query gagal');
	$dKKMchm	=mysql_fetch_array($rKKMchm);
	$nKKMchm	=$dKKMchm[kkm];
	
	//ips
	$qKKMhist 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='HIST'"; // menghasilka kkm per kelas per subjek
	$rKKMhist	=mysql_query($qKKMhist) or die('Query gagal');
	$dKKMhist	=mysql_fetch_array($rKKMhist);
	$nKKMhist	=$dKKMhist[kkm];
	
	$qKKMphy 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='PHY'"; // menghasilka kkm per kelas per subjek
	$rKKMphy	=mysql_query($qKKMphy) or die('Query gagal');
	$dKKMphy	=mysql_fetch_array($rKKMphy);
	$nKKMphy	=$dKKMphy[kkm];
	
	$qKKMscl 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='SCL'"; // menghasilka kkm per kelas per subjek
	$rKKMscl	=mysql_query($qKKMscl) or die('Query gagal');
	$dKKMscl	=mysql_fetch_array($rKKMscl);
	$nKKMscl	=$dKKMscl[kkm];
	
	//ipa
	$qKKMhist 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='HIST'"; // menghasilka kkm per kelas per subjek
	$rKKMhist	=mysql_query($qKKMhist) or die('Query gagal');
	$dKKMhist	=mysql_fetch_array($rKKMhist);
	$nKKMhist	=$dKKMhist[kkm];
	
	$qKKMggry 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='GGRY'"; // menghasilka kkm per kelas per subjek
	$rKKMggry	=mysql_query($qKKMggry) or die('Query gagal');
	$dKKMggry	=mysql_fetch_array($rKKMggry);
	$nKKMggry	=$dKKMggry[kkm];
	
	$qKKMart 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='ART'"; // menghasilka kkm per kelas per subjek
	$rKKMart	=mysql_query($qKKMart) or die('Query gagal');
	$dKKMart	=mysql_fetch_array($rKKMart);
	$nKKMart	=$dKKMart[kkm];
	
	$qKKMpe 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='PE'"; // menghasilka kkm per kelas per subjek
	$rKKMpe	=mysql_query($qKKMpe) or die('Query gagal');
	$dKKMpe	=mysql_fetch_array($rKKMpe);
	$nKKMpe	=$dKKMpe[kkm];
	
	$qKKMict 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='ICT'"; // menghasilka kkm per kelas per subjek
	$rKKMict	=mysql_query($qKKMict) or die('Query gagal');
	$dKKMict	=mysql_fetch_array($rKKMict);
	$nKKMict	=$dKKMict[kkm];
	
	//mnd-grm
	$qKKMfor 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='FOR'"; // menghasilka kkm per kelas per subjek
	$rKKMfor	=mysql_query($qKKMfor) or die('Query gagal');
	$dKKMfor	=mysql_fetch_array($rKKMfor);
	$nKKMfor	=$dKKMfor[kkm];
	
	
	
	//..
	//rlg
	$qRLG ="	SELECT 		t_prgrptps_sma.*
				FROM 		t_prgrptps_sma
				WHERE		t_prgrptps_sma.nis='$nis'		AND
							t_prgrptps_sma.kdeplj='RLG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rRLG=mysql_query($qRLG) or die('Query gagal');
	$dRLG =mysql_fetch_array($rRLG);
	$fgt1RLG	=$dRLG['fgt'."1"."1"];
	$fgt2RLG	=$dRLG['fgt'."1"."2"];
	$fgt3RLG	=$dRLG['fgt'."2"."1"];
	$fgt4RLG	=$dRLG['fgt'."2"."2"];
	$fgp1RLG	=$dRLG['fgp'."1"."1"];
	$fgp2RLG	=$dRLG['fgp'."1"."2"];
	$fgp3RLG	=$dRLG['fgp'."2"."1"];
	$fgp4RLG	=$dRLG['fgp'."2"."2"];
	$akh1RLG	=$dRLG['akh'."1"."1"];
	$akh2RLG	=$dRLG['akh'."1"."2"];
	$akh3RLG	=$dRLG['akh'."2"."1"];
	$akh4RLG	=$dRLG['akh'."2"."2"];
	$aff1RLG	=$dRLG['aff'."1"."1"];
	$aff2RLG	=$dRLG['aff'."1"."2"];
	$aff3RLG	=$dRLG['aff'."2"."1"];
	$aff4RLG	=$dRLG['aff'."2"."2"];
	
	$smav1RLG='';
	if($akh2RLG==0)
		$smav1RLG=$akh1RLG;
	else
	{
		$smav1RLG = number_format( ($akh1RLG+$akh2RLG)/2 ,0,',','.' );
	}
	
	if($aff1RLG>100)
		$lg1RLG = 'ERR';
	else if($aff1RLG>=85)
		$lg1RLG = 'A';
	else if($aff1RLG>=70)
		$lg1RLG = 'B';
	else if($aff1RLG>=59.5)
		$lg1RLG = 'C';
	else
		$lg1RLG = 'D';
	
	if($aff2RLG>100)
		$lg2RLG = 'ERR';
	else if($aff2RLG>=85)
		$lg2RLG = 'A';
	else if($aff2RLG>=70)
		$lg2RLG = 'B';
	else if($aff2RLG>=59.5)
		$lg2RLG = 'C';
	else
		$lg2RLG = 'D';
	
	
	
	//cme
	$qCME ="	SELECT 		t_prgrptps_sma_p.*
				FROM 		t_prgrptps_sma_p
				WHERE		t_prgrptps_sma_p.nis='$nis'		AND
							t_prgrptps_sma_p.kdeplj='CME'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rCME=mysql_query($qCME) or die('Query gagal');
	$dCME =mysql_fetch_array($rCME);
	$ahw1CME	=$dCME['avehw'."1"."1"];
	$ahw2CME	=$dCME['avehw'."1"."2"];
	$ahw3CME	=$dCME['avehw'."2"."1"];
	$ahw4CME	=$dCME['avehw'."2"."2"];
	$akh1CME	=$dCME['akh'."1"."1"];
	$akh2CME	=$dCME['akh'."1"."2"];
	$akh3CME	=$dCME['akh'."2"."1"];
	$akh4CME	=$dCME['akh'."2"."2"];
	$aff1CME	=$dCME['aff'."1"."1"];
	$aff2CME	=$dCME['aff'."1"."2"];
	$aff3CME	=$dCME['aff'."2"."1"];
	$aff4CME	=$dCME['aff'."2"."2"];
	
	$smav1CME='';
	if($akh2CME==0)
		$smav1CME=$akh1CME;
	else
	{
		$smav1CME = number_format( ($akh1CME+$akh2CME)/2 ,0,',','.' );
	}
	
	if($aff1CME>100)
		$lg1CME = 'ERR';
	else if($aff1CME>=85)
		$lg1CME = 'A';
	else if($aff1CME>=70)
		$lg1CME = 'B';
	else if($aff1CME>=59.5)
		$lg1CME = 'C';
	else
		$lg1CME = 'D';
	
	if($aff2CME>100)
		$lg2CME = 'ERR';
	else if($aff2CME>=85)
		$lg2CME = 'A';
	else if($aff2CME>=70)
		$lg2CME = 'B';
	else if($aff2CME>=59.5)
		$lg2CME = 'C';
	else
		$lg2CME = 'D';
	
	
	
	//bin
	$qBIN ="	SELECT 		t_prgrptps_sma.*
				FROM 		t_prgrptps_sma
				WHERE		t_prgrptps_sma.nis='$nis'		AND
							t_prgrptps_sma.kdeplj='BIN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rBIN=mysql_query($qBIN) or die('Query gagal');
	$dBIN =mysql_fetch_array($rBIN);
	$fgt1BIN	=$dBIN['fgt'."1"."1"];
	$fgt2BIN	=$dBIN['fgt'."1"."2"];
	$fgt3BIN	=$dBIN['fgt'."2"."1"];
	$fgt4BIN	=$dBIN['fgt'."2"."2"];
	$fgp1BIN	=$dBIN['fgp'."1"."1"];
	$fgp2BIN	=$dBIN['fgp'."1"."2"];
	$fgp3BIN	=$dBIN['fgp'."2"."1"];
	$fgp4BIN	=$dBIN['fgp'."2"."2"];
	$akh1BIN	=$dBIN['akh'."1"."1"];
	$akh2BIN	=$dBIN['akh'."1"."2"];
	$akh3BIN	=$dBIN['akh'."2"."1"];
	$akh4BIN	=$dBIN['akh'."2"."2"];
	$aff1BIN	=$dBIN['aff'."1"."1"];
	$aff2BIN	=$dBIN['aff'."1"."2"];
	$aff3BIN	=$dBIN['aff'."2"."1"];
	$aff4BIN	=$dBIN['aff'."2"."2"];
	
	$smav1BIN='';
	if($akh2BIN==0)
		$smav1BIN=$akh1BIN;
	else
	{
		$smav1BIN = number_format( ($akh1BIN+$akh2BIN)/2 ,0,',','.' );
	}
	
	if($aff1BIN>100)
		$lg1BIN = 'ERR';
	else if($aff1BIN>=85)
		$lg1BIN = 'A';
	else if($aff1BIN>=70)
		$lg1BIN = 'B';
	else if($aff1BIN>=59.5)
		$lg1BIN = 'C';
	else
		$lg1BIN = 'D';
	
	if($aff2BIN>100)
		$lg2BIN = 'ERR';
	else if($aff2BIN>=85)
		$lg2BIN = 'A';
	else if($aff2BIN>=70)
		$lg2BIN = 'B';
	else if($aff2BIN>=59.5)
		$lg2BIN = 'C';
	else
		$lg2BIN = 'D';
	
	
	
	//eng
	$qENG ="	SELECT 		t_prgrptps_sma.*
				FROM 		t_prgrptps_sma
				WHERE		t_prgrptps_sma.nis='$nis'		AND
							t_prgrptps_sma.kdeplj='ENG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rENG=mysql_query($qENG) or die('Query gagal');
	$dENG =mysql_fetch_array($rENG);
	$fgt1ENG	=$dENG['fgt'."1"."1"];
	$fgt2ENG	=$dENG['fgt'."1"."2"];
	$fgt3ENG	=$dENG['fgt'."2"."1"];
	$fgt4ENG	=$dENG['fgt'."2"."2"];
	$fgp1ENG	=$dENG['fgp'."1"."1"];
	$fgp2ENG	=$dENG['fgp'."1"."2"];
	$fgp3ENG	=$dENG['fgp'."2"."1"];
	$fgp4ENG	=$dENG['fgp'."2"."2"];
	$akh1ENG	=$dENG['akh'."1"."1"];
	$akh2ENG	=$dENG['akh'."1"."2"];
	$akh3ENG	=$dENG['akh'."2"."1"];
	$akh4ENG	=$dENG['akh'."2"."2"];
	$aff1ENG	=$dENG['aff'."1"."1"];
	$aff2ENG	=$dENG['aff'."1"."2"];
	$aff3ENG	=$dENG['aff'."2"."1"];
	$aff4ENG	=$dENG['aff'."2"."2"];
	
	$smav1ENG='';
	if($akh2ENG==0)
		$smav1ENG=$akh1ENG;
	else
	{
		$smav1ENG = number_format( ($akh1ENG+$akh2ENG)/2 ,0,',','.' );
	}
	
	if($aff1ENG>100)
		$lg1ENG = 'ERR';
	else if($aff1ENG>=85)
		$lg1ENG = 'A';
	else if($aff1ENG>=70)
		$lg1ENG = 'B';
	else if($aff1ENG>=59.5)
		$lg1ENG = 'C';
	else
		$lg1ENG = 'D';
	
	if($aff2ENG>100)
		$lg2ENG = 'ERR';
	else if($aff2ENG>=85)
		$lg2ENG = 'A';
	else if($aff2ENG>=70)
		$lg2ENG = 'B';
	else if($aff2ENG>=59.5)
		$lg2ENG = 'C';
	else
		$lg2ENG = 'D';
	
	
	
	//mth
	$qMTH ="	SELECT 		t_prgrptps_sma_p.*
				FROM 		t_prgrptps_sma_p
				WHERE		t_prgrptps_sma_p.nis='$nis'		AND
							t_prgrptps_sma_p.kdeplj='MTH'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rMTH=mysql_query($qMTH) or die('Query gagal');
	$dMTH =mysql_fetch_array($rMTH);
	$ahw1MTH	=$dMTH['avehw'."1"."1"];
	$ahw2MTH	=$dMTH['avehw'."1"."2"];
	$ahw3MTH	=$dMTH['avehw'."2"."1"];
	$ahw4MTH	=$dMTH['avehw'."2"."2"];
	$akh1MTH	=$dMTH['akh'."1"."1"];
	$akh2MTH	=$dMTH['akh'."1"."2"];
	$akh3MTH	=$dMTH['akh'."2"."1"];
	$akh4MTH	=$dMTH['akh'."2"."2"];
	$aff1MTH	=$dMTH['aff'."1"."1"];
	$aff2MTH	=$dMTH['aff'."1"."2"];
	$aff3MTH	=$dMTH['aff'."2"."1"];
	$aff4MTH	=$dMTH['aff'."2"."2"];
	
	$smav1MTH='';
	if($akh2MTH==0)//$ahw2MTH
		$smav1MTH=$akh1MTH;//$ahw1MTH
	else
	{
		$smav1MTH = number_format( ($akh1MTH+$akh2MTH)/2 ,0,',','.' );
	}
	
	if($aff1MTH>100)
		$lg1MTH = 'ERR';
	else if($aff1MTH>=85)
		$lg1MTH = 'A';
	else if($aff1MTH>=70)
		$lg1MTH = 'B';
	else if($aff1MTH>=59.5)
		$lg1MTH = 'C';
	else
		$lg1MTH = 'D';
	
	if($aff2MTH>100)
		$lg2MTH = 'ERR';
	else if($aff2MTH>=85)
		$lg2MTH = 'A';
	else if($aff2MTH>=70)
		$lg2MTH = 'B';
	else if($aff2MTH>=59.5)
		$lg2MTH = 'C';
	else
		$lg2MTH = 'D';
	
	
	
	//ecn
	$qECN ="	SELECT 		t_prgrptps_sma_p.*
				FROM 		t_prgrptps_sma_p
				WHERE		t_prgrptps_sma_p.nis='$nis'		AND
							t_prgrptps_sma_p.kdeplj='ECN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rECN=mysql_query($qECN) or die('Query gagal');
	$dECN =mysql_fetch_array($rECN);
	$ahw1ECN	=$dECN['avehw'."1"."1"];
	$ahw2ECN	=$dECN['avehw'."1"."2"];
	$ahw3ECN	=$dECN['avehw'."2"."1"];
	$ahw4ECN	=$dECN['avehw'."2"."2"];
	$akh1ECN	=$dECN['akh'."1"."1"];
	$akh2ECN	=$dECN['akh'."1"."2"];
	$akh3ECN	=$dECN['akh'."2"."1"];
	$akh4ECN	=$dECN['akh'."2"."2"];
	$aff1ECN	=$dECN['aff'."1"."1"];
	$aff2ECN	=$dECN['aff'."1"."2"];
	$aff3ECN	=$dECN['aff'."2"."1"];
	$aff4ECN	=$dECN['aff'."2"."2"];
	
	$smav1ECN='';
	if($akh2ECN==0)
		$smav1ECN=$akh1ECN;
	else
	{
		$smav1ECN = number_format( ($akh1ECN+$akh2ECN)/2 ,0,',','.' );
	}
	
	if($aff1ECN>100)
		$lg1ECN = 'ERR';
	else if($aff1ECN>=85)
		$lg1ECN = 'A';
	else if($aff1ECN>=70)
		$lg1ECN = 'B';
	else if($aff1ECN>=59.5)
		$lg1ECN = 'C';
	else
		$lg1ECN = 'D';
	
	if($aff2ECN>100)
		$lg2ECN = 'ERR';
	else if($aff2ECN>=85)
		$lg2ECN = 'A';
	else if($aff2ECN>=70)
		$lg2ECN = 'B';
	else if($aff2ECN>=59.5)
		$lg2ECN = 'C';
	else
		$lg2ECN = 'D';
	
	
	
	//hist
	$qHIST ="	SELECT 		t_prgrptps_sma_p.*
				FROM 		t_prgrptps_sma_p
				WHERE		t_prgrptps_sma_p.nis='$nis'		AND
							t_prgrptps_sma_p.kdeplj='HIST'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rHIST=mysql_query($qHIST) or die('Query gagal');
	$dHIST =mysql_fetch_array($rHIST);
	$ahw1HIST	=$dHIST['avehw'."1"."1"];
	$ahw2HIST	=$dHIST['avehw'."1"."2"];
	$ahw3HIST	=$dHIST['avehw'."2"."1"];
	$ahw4HIST	=$dHIST['avehw'."2"."2"];
	$akh1HIST	=$dHIST['akh'."1"."1"];
	$akh2HIST	=$dHIST['akh'."1"."2"];
	$akh3HIST	=$dHIST['akh'."2"."1"];
	$akh4HIST	=$dHIST['akh'."2"."2"];
	$aff1HIST	=$dHIST['aff'."1"."1"];
	$aff2HIST	=$dHIST['aff'."1"."2"];
	$aff3HIST	=$dHIST['aff'."2"."1"];
	$aff4HIST	=$dHIST['aff'."2"."2"];
	
	$smav1HIST='';
	if($akh2HIST==0)//$ahw2HIST
		$smav1HIST=$akh1HIST;//$ahw1HIST
	else
	{
		$smav1HIST = number_format( ($akh1HIST+$akh2HIST)/2 ,0,',','.' );
	}
	
	if($aff1HIST>100)
		$lg1HIST = 'ERR';
	else if($aff1HIST>=85)
		$lg1HIST = 'A';
	else if($aff1HIST>=70)
		$lg1HIST = 'B';
	else if($aff1HIST>=59.5)
		$lg1HIST = 'C';
	else
		$lg1HIST = 'D';
	
	if($aff2HIST>100)
		$lg2HIST = 'ERR';
	else if($aff2HIST>=85)
		$lg2HIST = 'A';
	else if($aff2HIST>=70)
		$lg2HIST = 'B';
	else if($aff2HIST>=59.5)
		$lg2HIST = 'C';
	else
		$lg2HIST = 'D';

	
	
	//SCL
	$qSCL ="	SELECT 		t_prgrptps_sma_p.*
				FROM 		t_prgrptps_sma_p
				WHERE		t_prgrptps_sma_p.nis='$nis'		AND
							t_prgrptps_sma_p.kdeplj='SCL'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rSCL=mysql_query($qSCL) or die('Query gagal');
	$dSCL =mysql_fetch_array($rSCL);
	$ahw1SCL	=$dSCL['avehw'."1"."1"];
	$ahw2SCL	=$dSCL['avehw'."1"."2"];
	$ahw3SCL	=$dSCL['avehw'."2"."1"];
	$ahw4SCL	=$dSCL['avehw'."2"."2"];
	$akh1SCL	=$dSCL['akh'."1"."1"];
	$akh2SCL	=$dSCL['akh'."1"."2"];
	$akh3SCL	=$dSCL['akh'."2"."1"];
	$akh4SCL	=$dSCL['akh'."2"."2"];
	$aff1SCL	=$dSCL['aff'."1"."1"];
	$aff2SCL	=$dSCL['aff'."1"."2"];
	$aff3SCL	=$dSCL['aff'."2"."1"];
	$aff4SCL	=$dSCL['aff'."2"."2"];
	
	$smav1SCL='';
	if($akh2SCL==0)//$ahw2SCL
		$smav1SCL=$akh1SCL;//$ahw1SCL
	else
	{
		$smav1SCL = number_format( ($akh1SCL+$akh2SCL)/2 ,0,',','.' );
	}
	
	if($aff1SCL>100)
		$lg1SCL = 'ERR';
	else if($aff1SCL>=85)
		$lg1SCL = 'A';
	else if($aff1SCL>=70)
		$lg1SCL = 'B';
	else if($aff1SCL>=59.5)
		$lg1SCL = 'C';
	else
		$lg1SCL = 'D';
	
	if($aff2SCL>100)
		$lg2SCL = 'ERR';
	else if($aff2SCL>=85)
		$lg2SCL = 'A';
	else if($aff2SCL>=70)
		$lg2SCL = 'B';
	else if($aff2SCL>=59.5)
		$lg2SCL = 'C';
	else
		$lg2SCL = 'D';
	
	
	
	//ggry
	$qGGRY ="	SELECT 		t_prgrptps_sma_p.*
				FROM 		t_prgrptps_sma_p
				WHERE		t_prgrptps_sma_p.nis='$nis'		AND
							t_prgrptps_sma_p.kdeplj='GGRY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rGGRY=mysql_query($qGGRY) or die('Query gagal');
	$dGGRY =mysql_fetch_array($rGGRY);
	$ahw1GGRY	=$dGGRY['avehw'."1"."1"];
	$ahw2GGRY	=$dGGRY['avehw'."1"."2"];
	$ahw3GGRY	=$dGGRY['avehw'."2"."1"];
	$ahw4GGRY	=$dGGRY['avehw'."2"."2"];
	$akh1GGRY	=$dGGRY['akh'."1"."1"];
	$akh2GGRY	=$dGGRY['akh'."1"."2"];
	$akh3GGRY	=$dGGRY['akh'."2"."1"];
	$akh4GGRY	=$dGGRY['akh'."2"."2"];
	$aff1GGRY	=$dGGRY['aff'."1"."1"];
	$aff2GGRY	=$dGGRY['aff'."1"."2"];
	$aff3GGRY	=$dGGRY['aff'."2"."1"];
	$aff4GGRY	=$dGGRY['aff'."2"."2"];
	
	$smav1GGRY='';
	if($akh2GGRY==0)//$ahw2GGRY
		$smav1GGRY=$akh1GGRY;//$ahw2GGRY
	else
	{
		$smav1GGRY = number_format( ($akh1GGRY+$akh2GGRY)/2 ,0,',','.' );
	}
	
	if($aff1GGRY>100)
		$lg1GGRY = 'ERR';
	else if($aff1GGRY>=85)
		$lg1GGRY = 'A';
	else if($aff1GGRY>=70)
		$lg1GGRY = 'B';
	else if($aff1GGRY>=59.5)
		$lg1GGRY = 'C';
	else
		$lg1GGRY = 'D';
	
	if($aff2GGRY>100)
		$lg2GGRY = 'ERR';
	else if($aff2GGRY>=85)
		$lg2GGRY = 'A';
	else if($aff2GGRY>=70)
		$lg2GGRY = 'B';
	else if($aff2GGRY>=59.5)
		$lg2GGRY = 'C';
	else
		$lg2GGRY = 'D';
	
	
	
	//art
	$qART ="	SELECT 		t_prgrptps_sma_p.*
				FROM 		t_prgrptps_sma_p
				WHERE		t_prgrptps_sma_p.nis='$nis'		AND
							t_prgrptps_sma_p.kdeplj='ART'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rART=mysql_query($qART) or die('Query gagal');
	$dART =mysql_fetch_array($rART);
	$ahw1ART	=$dART['avehw'."1"."1"];
	//$ahw2ART	=$dART['avehw'."1"."2"];
	$ahw3ART	=$dART['avehw'."2"."1"];
	$ahw4ART	=$dART['avehw'."2"."2"];
	$akh1ART	=$dART['akh'."1"."1"];
	//$akh2ART	=$dART['akh'."1"."2"];
	$akh3ART	=$dART['akh'."2"."1"];
	$akh4ART	=$dART['akh'."2"."2"];
	$aff1ART	=$dART['aff'."1"."1"];
	//$aff2ART	=$dART['aff'."1"."2"];
	$aff3ART	=$dART['aff'."2"."1"];
	$aff4ART	=$dART['aff'."2"."2"];
	
	$qART2 ="	SELECT 		t_prgrptps_sma.*
				FROM 		t_prgrptps_sma
				WHERE		t_prgrptps_sma.nis='$nis'		AND
							t_prgrptps_sma.kdeplj='ART'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rART2=mysql_query($qART2) or die('Query gagal');
	$dART2 =mysql_fetch_array($rART2);
	$fgt2ART	=$dART2['fgt'."1"."2"];
	$fgp2ART	=$dART2['fgp'."1"."2"];
	$akh2ART	=$dART2['akh'."1"."2"];
	$aff2ART	=$dART2['aff'."1"."2"];
	
	$smav1ART='';
	if($akh2ART==0)//$ahw2ART
		$smav1ART=$akh1ART;//$ahw1ART
	else
	{
		$smav1ART = number_format( ($akh1ART+$akh2ART)/2 ,0,',','.');
	}
	
	if($aff1ART>100)
		$lg1ART = 'ERR';
	else if($aff1ART>=85)
		$lg1ART = 'A';
	else if($aff1ART>=70)
		$lg1ART = 'B';
	else if($aff1ART>=59.5)
		$lg1ART = 'C';
	else
		$lg1ART = 'D';
	
	if($aff2ART>100)
		$lg2ART = 'ERR';
	else if($aff2ART>=85)
		$lg2ART = 'A';
	else if($aff2ART>=70)
		$lg2ART = 'B';
	else if($aff2ART>=59.5)
		$lg2ART = 'C';
	else
		$lg2ART = 'D';
	
	
	
	//pe
	$qPE ="	SELECT 		t_prgrptps_sma.*
				FROM 		t_prgrptps_sma
				WHERE		t_prgrptps_sma.nis='$nis'		AND
							t_prgrptps_sma.kdeplj='PE'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rPE=mysql_query($qPE) or die('Query gagal');
	$dPE =mysql_fetch_array($rPE);
	$fgt1PE	=$dPE['fgt'."1"."1"];
	$fgt2PE	=$dPE['fgt'."1"."2"];
	$fgt3PE	=$dPE['fgt'."2"."1"];
	$fgt4PE	=$dPE['fgt'."2"."2"];
	$fgp1PE	=$dPE['fgp'."1"."1"];
	$fgp2PE	=$dPE['fgp'."1"."2"];
	$fgp3PE	=$dPE['fgp'."2"."1"];
	$fgp4PE	=$dPE['fgp'."2"."2"];
	$akh1PE	=$dPE['akh'."1"."1"];
	$akh2PE	=$dPE['akh'."1"."2"];
	$akh3PE	=$dPE['akh'."2"."1"];
	$akh4PE	=$dPE['akh'."2"."2"];
	$aff1PE	=$dPE['aff'."1"."1"];
	$aff2PE	=$dPE['aff'."1"."2"];
	$aff3PE	=$dPE['aff'."2"."1"];
	$aff4PE	=$dPE['aff'."2"."2"];
	
	$smav1PE='';
	if($akh2PE==0)
		$smav1PE=$akh1PE;
	else
	{
		$smav1PE = number_format( ($akh1PE+$akh2PE)/2 ,0,',','.' );
	}
	
	if($aff1PE>100)
		$lg1PE = 'ERR';
	else if($aff1PE>=85)
		$lg1PE = 'A';
	else if($aff1PE>=70)
		$lg1PE = 'B';
	else if($aff1PE>=59.5)
		$lg1PE = 'C';
	else
		$lg1PE = 'D';
	
	if($aff2PE>100)
		$lg2PE = 'ERR';
	else if($aff2PE>=85)
		$lg2PE = 'A';
	else if($aff2PE>=70)
		$lg2PE = 'B';
	else if($aff2PE>=59.5)
		$lg2PE = 'C';
	else
		$lg2PE = 'D';
	
	
	
	//ICT
	$qICT ="	SELECT 		t_prgrptps_sma.*
				FROM 		t_prgrptps_sma
				WHERE		t_prgrptps_sma.nis='$nis'		AND
							t_prgrptps_sma.kdeplj='ICT'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rICT=mysql_query($qICT) or die('Query gagal');
	$dICT =mysql_fetch_array($rICT);
	$fgt1ICT	=$dICT['fgt'."1"."1"];
	$fgt2ICT	=$dICT['fgt'."1"."2"];
	$fgt3ICT	=$dICT['fgt'."2"."1"];
	$fgt4ICT	=$dICT['fgt'."2"."2"];
	$fgp1ICT	=$dICT['fgp'."1"."1"];
	$fgp2ICT	=$dICT['fgp'."1"."2"];
	$fgp3ICT	=$dICT['fgp'."2"."1"];
	$fgp4ICT	=$dICT['fgp'."2"."2"];
	$akh1ICT	=$dICT['akh'."1"."1"];
	$akh2ICT	=$dICT['akh'."1"."2"];
	$akh3ICT	=$dICT['akh'."2"."1"];
	$akh4ICT	=$dICT['akh'."2"."2"];
	$aff1ICT	=$dICT['aff'."1"."1"];
	$aff2ICT	=$dICT['aff'."1"."2"];
	$aff3ICT	=$dICT['aff'."2"."1"];
	$aff4ICT	=$dICT['aff'."2"."2"];
	
	$smav1ICT='';
	if($akh2ICT==0)
		$smav1ICT=$akh1ICT;
	else
	{
		$smav1ICT = number_format( ($akh1ICT+$akh2ICT)/2 ,0,',','.' );
	}
	
	if($aff1ICT>100)
		$lg1ICT = 'ERR';
	else if($aff1ICT>=85)
		$lg1ICT = 'A';
	else if($aff1ICT>=70)
		$lg1ICT = 'B';
	else if($aff1ICT>=59.5)
		$lg1ICT = 'C';
	else
		$lg1ICT = 'D';
	
	if($aff2ICT>100)
		$lg2ICT = 'ERR';
	else if($aff2ICT>=85)
		$lg2ICT = 'A';
	else if($aff2ICT>=70)
		$lg2ICT = 'B';
	else if($aff2ICT>=59.5)
		$lg2ICT = 'C';
	else
		$lg2ICT = 'D';
	
	
	
	//FOR
	$dFOR ='';
	$qFOR ="	SELECT 		t_prgrptps_sma.*
				FROM 		t_prgrptps_sma
				WHERE		t_prgrptps_sma.nis='$nis'		AND
							t_prgrptps_sma.kdeplj='GRM'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rFOR=mysql_query($qFOR) or die('Query gagal');
	$dFOR =mysql_fetch_array($rFOR);
	$str1FOR	=$dFOR['fgt'."1"."1"];
	
	if( $str1FOR=='0' )//mnd
	{
		$qFOR ="	SELECT 		t_prgrptps_sma.*
					FROM 		t_prgrptps_sma
					WHERE		t_prgrptps_sma.nis='$nis'		AND
								t_prgrptps_sma.kdeplj='MND'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
		$rFOR=mysql_query($qFOR) or die('Query gagal');
		$dFOR =mysql_fetch_array($rFOR);
	}
	//else//grm
		//$dFOR =mysql_fetch_array($rFOR);
	
	$fgt1FOR	=$dFOR['fgt'."1"."1"];
	$fgt2FOR	=$dFOR['fgt'."1"."2"];
	$fgt3FOR	=$dFOR['fgt'."2"."1"];
	$fgt4FOR	=$dFOR['fgt'."2"."2"];
	$fgp1FOR	=$dFOR['fgp'."1"."1"];
	$fgp2FOR	=$dFOR['fgp'."1"."2"];
	$fgp3FOR	=$dFOR['fgp'."2"."1"];
	$fgp4FOR	=$dFOR['fgp'."2"."2"];
	$akh1FOR	=$dFOR['akh'."1"."1"];
	$akh2FOR	=$dFOR['akh'."1"."2"];
	$akh3FOR	=$dFOR['akh'."2"."1"];
	$akh4FOR	=$dFOR['akh'."2"."2"];
	$aff1FOR	=$dFOR['aff'."1"."1"];
	$aff2FOR	=$dFOR['aff'."1"."2"];
	$aff3FOR	=$dFOR['aff'."2"."1"];
	$aff4FOR	=$dFOR['aff'."2"."2"];
	
	$smav1FOR='';
	if($akh2FOR==0)
		$smav1FOR=$akh1FOR;
	else
	{
		$smav1FOR = number_format( ($akh1FOR+$akh2FOR)/2 ,0,',','.' );
	}
	
	if($aff1FOR>100)
		$lg1FOR = 'ERR';
	else if($aff1FOR>=85)
		$lg1FOR = 'A';
	else if($aff1FOR>=70)
		$lg1FOR = 'B';
	else if($aff1FOR>=59.5)
		$lg1FOR = 'C';
	else
		$lg1FOR = 'D';
	
	if($aff2FOR>100)
		$lg2FOR = 'ERR';
	else if($aff2FOR>=85)
		$lg2FOR = 'A';
	else if($aff2FOR>=70)
		$lg2FOR = 'B';
	else if($aff2FOR>=59.5)
		$lg2FOR = 'C';
	else
		$lg2FOR = 'D';
			
	$str1='';
	$str2='';
	$str3='';
	$str4='';
	$str5='';
	
	$kkm2='';
	$kkm3='';
	$kkm4='';
	$kkm5='';
	
	if( substr($kdekls,-3)=='IPA' )
	{
		$str1='Natural Science (IPA)';
		$str2='Biology';
		$str3='Chemistry';
		$str4='Physics';
		$str5='History';
		
		$kkm2=$nKKMblgy;
		$kkm3=$nKKMchm;
		$kkm4=$nKKMphy;
		$kkm5=$nKKMhist;
	}
	
	if( substr($kdekls,-3)=='IPS' )
	{
		$str1='Social Studies (IPS)';
		$str2='Economics';
		$str3='History';
		$str4='Sociology';
		$str5='Geography';
		
		$kkm2=$nKKMecn;
		$kkm3=$nKKMhist;
		$kkm4=$nKKMscl;
		$kkm5=$nKKMggry;
	}
	
	//1
	$pdf->Cell(0.6	,0.5,'1','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Religion','LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$nKKMrlg,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgt1RLG,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgp1RLG,'LRTB',0,C,true);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1RLG,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75	,0.5,$fgt2RLG,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgp2RLG,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$akh2RLG,'LRTB',0,C,true);//$akh2RLG
	$pdf->Cell( 0.75	,0.5,$smav1RLG,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1RLG,'LRTB',0,C,true);
	
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//2
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'2','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Civics/Moral Education','LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$nKKMcme,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1CME,'LRTB',0,C,true);//ahw1CME
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,$akh2CME,'LRTB',0,C,true);//$ahw2CME
	$pdf->Cell( 0.75	,0.5,$smav1CME,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1CME,'LRTB',0,C,true);
	
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//3
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'3','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Bahasa Indonesia','LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$nKKMbin,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgt1BIN,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgp1BIN,'LRTB',0,C,true);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1BIN,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75	,0.5,$fgt2BIN,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgp2BIN,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$akh2BIN,'LRTB',0,C,true);//$akh2BIN
	$pdf->Cell( 0.75	,0.5,$smav1BIN,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1BIN,'LRTB',0,C,true);
	
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//4
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'4','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'English','LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$nKKMeng,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgt1ENG,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgp1ENG,'LRTB',0,C,true);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1ENG,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75	,0.5,$fgt2ENG,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgp2ENG,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$akh2ENG,'LRTB',0,C,true);//$akh2ENG
	$pdf->Cell( 0.75	,0.5,$smav1ENG,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1ENG,'LRTB',0,C,true);
	
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//5
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'5','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Mathematics','LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$nKKMmth,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1MTH,'LRTB',0,C,true);//$ahw1MTH
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,$akh2MTH,'LRTB',0,C,true);//$ahw2MTH
	$pdf->Cell( 0.75	,0.5,$smav1MTH,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1MTH,'LRTB',0,C,true);
	
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(5.7	,0.5,$str1,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(1.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
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
	$pdf->SetFillColor(255,255,255);
	
	//6
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'6','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'        '.$str2,'LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$kkm2,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1ECN,'LRTB',0,C,true);//ahw1ECN
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,$akh2ECN,'LRTB',0,C,true);//$ahw2ECN
	$pdf->Cell( 0.75	,0.5,$smav1ECN,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1ECN,'LRTB',0,C,true);
	
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//7
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'7','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'        '.$str3,'LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$kkm3,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1HIST,'LRTB',0,C,true);//$ahw1HIST
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,$akh2HIST,'LRTB',0,C,true);//$ahw2HIST
	$pdf->Cell( 0.75	,0.5,$smav1HIST,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1HIST,'LRTB',0,C,true);
	
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//8
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'8','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'        '.$str4,'LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$kkm4,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1SCL,'LRTB',0,C,true);//$ahw1SCL
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,$akh2SCL,'LRTB',0,C,true);//$ahw2SCL
	$pdf->Cell( 0.75	,0.5,$smav1SCL,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1SCL,'LRTB',0,C,true);
	
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//9
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'9','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'        '.$str5,'LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$kkm5,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1GGRY,'LRTB',0,C,true);//$ahw1GGRY
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,$akh2GGRY,'LRTB',0,C,true);//$ahw2GGRY
	$pdf->Cell( 0.75	,0.5,$smav1GGRY,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1GGRY,'LRTB',0,C,true);
	
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//10
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'10','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Cultural Art / Music','LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$nKKMart,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1ART,'LRTB',0,C,true);//$ahw1ART
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,$akh2ART,'LRTB',0,C,true);//$ahw2ART
	$pdf->Cell( 0.75	,0.5,$smav1ART,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1ART,'LRTB',0,C,true);
	
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//11
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'11','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Physical Education & Health','LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$nKKMpe,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgt1PE,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgp1PE,'LRTB',0,C,true);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1PE,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75	,0.5,$fgt2PE,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgp2PE,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$akh2PE,'LRTB',0,C,true);//$akh2PE
	$pdf->Cell( 0.75	,0.5,$smav1PE,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1PE,'LRTB',0,C,true);
	
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//12
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'12','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Information Technology','LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$nKKMict,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgt1ICT,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgp1ICT,'LRTB',0,C,true);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1ICT,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75	,0.5,$fgt2ICT,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgp2ICT,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$akh2ICT,'LRTB',0,C,true);//$akh2ICT
	$pdf->Cell( 0.75	,0.5,$smav1ICT,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1ICT,'LRTB',0,C,true);
	
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//13
	$pdf->Ln();
	$pdf->Cell(0.6	,0.5,'13','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Foreign Language: Mandarin/German','LRTB',0,L,true);
	$pdf->Cell(1.75	,0.5,$nKKMfor,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgt1FOR,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgp1FOR,'LRTB',0,C,true);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.75	,0.5,$akh1FOR,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75	,0.5,$fgt2FOR,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$fgp2FOR,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$akh2FOR,'LRTB',0,C,true);//$akh2FOR
	$pdf->Cell( 0.75	,0.5,$smav1FOR,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,$lg1FOR,'LRTB',0,C,true);
	
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);
	
	//..khir
	
	

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
			/*$pdf->Cell(0.6	,0.5,$no,'LRTB',0,C,true);
			$pdf->Cell(0.1	,0.5,'','LTB',0,R,true); // 0.6 $no.'.'
			$pdf->Cell(5.6	,0.5,$nmasbj,'RTB',0,L,true);*/
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
		
		//$pdf->Cell( 1.75	,0.5,$kkm,'LRTB',0,C,true);			//kkm B
		
		if($q1<$kkm)
		{
			$q1='DF';
			//$pdf->SetTextColor(255,0,0);
		}
		/*else
			$pdf->SetTextColor(0,0,0);*/
		
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
		
		/*$pdf->Cell( 0.75	,0.5,$q1,'LRTB',0,C,true);
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
		$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);*/
		$pdf->SetTextColor(0,0,0);
		
		//$pdf->Ln();
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
				/*$pdf->Cell(0.6	,0.5,$no,'LRTB',0,C,true);
				$pdf->Cell(0.1	,0.5,'','LTB',0,R,true); // 0.6 $no.'.'
				$pdf->Cell(5.6	,0.5,$nmasbj,'RTB',0,L,true);*/
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
			
			//$pdf->Cell( 1.75	,0.5,$kkm,'LRTB',0,C,true);			//kkm C
			
			//q1
			if($q1<$kkm)
			{
				$q1='DF';
				//$pdf->SetTextColor(255,0,0);
			}
			/*else
				$pdf->SetTextColor(0,0,0);*/
			
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
			
			/*$pdf->Cell( 0.75	,0.5,$q1,'LRTB',0,C,true);
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
			$pdf->Cell( 0.75	,0.5,'','LRTB',0,C,true);*/
			$pdf->SetTextColor(0,0,0);
			
			//$pdf->Ln();
			
			
			
		}	
		$j++;
		$id=$cell[$j][0];
	}
	$klm	=str_replace('And','and',ucwords(number_to_words($ttlakh)));
	
	$rtrt	=number_format($rtrt,0,',','.');
	$klm	=ucwords(number_to_words($rtrt));
	$rnk	=$cell5[$y][3];
	
	$pdf->Ln();
	$pdf->Ln();
	//$pdf->Ln(0.25);
	
	
	
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
	
	$nma1a='';
	$ktr1a='';
	$nma1b='';
	$ktr1b='';
	
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
		$nma1a='BASKET BALL';
		$ktr1a=$q1BSK;
	}
	if($q2BSK!='')
	{
		$nma1b='BASKET BALL';
		$ktr1b=$q2BSK;
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
		$nma1a='FUTSAL';
		$ktr1a=$q1FTS;
	}
	if($q2FTS!='')
	{
		$nma1b='FUTSAL';
		$ktr1b=$q2FTS;
	}
	
	//av1
	$ave1a='';
	if($ktr1b=='')
		$ave1a=$ktr1a;
	else
		$ave1a=$ktr1b;
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Sport Interest(Basketball/Futsal)','LRTB',0,L,true);//$nmaPil1
	$pdf->Cell( 2.25	,0.4,$ktr1a		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,$ktr1b		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$ave1a		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$nma2a='';
	$ktr2a='';
	$nma2b='';
	$ktr2b='';
	
	//culinari
	$qCLN	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='CLN' "; // extra kurikuler
	$rCLN=mysql_query($qCLN) or die('Query gagal40');
	$dCLN =mysql_fetch_array($rCLN);
	$q1CLN=$dCLN['ext'."1"."1"]; // q1 CLN
	$q2CLN=$dCLN['ext'."1"."2"]; // q2 CLN
	if($q1CLN!='')
	{
		$nma2a='Culinary';
		$ktr2a=$q1CLN;
	}
	if($q2CLN!='')
	{
		$nma2b='Culinary';
		$ktr2b=$q2CLN;
	}
	
	//av1
	$ave2a='';
	if($q2CLN=='')
		$ave2a=$q1CLN;
	else
		$ave2a=$q2CLN;
	
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'2','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Culinary','LRTB',0,L,true);//$nmaPil2
	$pdf->Cell( 2.25	,0.4,$ktr2a		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,$ktr2b		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$ave2a		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$nma3a='';
	$ktr3a='';
	$nma3b='';
	$ktr3b='';
	
	//Interest(Robotic/Manner/Scouting)
	$qRBT	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='RBT' "; // extra kurikuler
	$rRBT=mysql_query($qRBT) or die('Query gagal40');
	$dRBT =mysql_fetch_array($rRBT);
	$q1RBT=$dRBT['ext'."1"."1"]; // q1 RBT
	$q2RBT=$dRBT['ext'."1"."2"]; // q2 RBT
	if($q1RBT!='')
	{
		$nma3a='Interest(Robotic/Manner/Scouting)';
		$ktr3a=$q1RBT;
	}
	if($q2RBT!='')
	{
		$nma3b='Interest(Robotic/Manner/Scouting)';
		$ktr3b=$q2RBT;
	}
	
	//av1
	$ave3a='';
	if($q2RBT=='')
		$ave3a=$q1RBT;
	else
		$ave3a=$q2RBT;
	
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'3','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Interest(Robotic/Manner)','LRTB',0,L,true);//$nmaPil3
	$pdf->Cell( 2.25	,0.4,$ktr3a		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,$ktr3b		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$ave3a		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$nma4a='';
	$ktr4a='';
	$nma4b='';
	$ktr4b='';
	
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
		$nma4a='Music';
		$ktr4a=$q1MSC;
	}
	if($q2MSC!='')
	{
		$nma4b='Music';
		$ktr4b=$q2MSC;
	}
	
	//av1
	$ave4a='';
	if($q2MSC=='')
		$ave4a=$q1MSC;
	else
		$ave4a=$q2MSC;
	
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'4','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Music Ensemble','LRTB',0,L,true);//$nmaPil4
	$pdf->Cell( 2.25	,0.4,$ktr4a		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,$ktr4b		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$ave4a		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.75	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	$nma5a='';
	$ktr5a='';
	$nma5b='';
	$ktr5b='';
	
	//Interest(Science & Math Club/English Club)
	$qCLB	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='CLB' "; // extra kurikuler
	$rCLB=mysql_query($qCLB) or die('Query gagal40');
	$dCLB =mysql_fetch_array($rCLB);
	$q1CLB=$dCLB['ext'."1"."1"]; // q1 CLB
	$q2CLB=$dCLB['ext'."1"."2"]; // q2 CLB
	if($q1CLB!='')
	{
		$nma5a='Interest(Science & Math Club/English Club)';
		$ktr5a=$q1CLB;
	}
	if($q2CLB!='')
	{
		$nma5b='Interest(Science & Math Club/English Club)';
		$ktr5b=$q2CLB;
	}
	
	//av1
	$ave5a='';
	if($q2CLB=='')
		$ave5a=$q1CLB;
	else
		$ave5a=$q2CLB;
	
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'5','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Interest(Science & Math Club/English Club)','LRTB',0,L,true);//$nmaPil5
	$pdf->Cell( 2.25	,0.4,$ktr5a		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,$ktr5b		,'LRTB',0,C,true);
	$pdf->Cell( 0.75	,0.4,$ave5a		,'LRTB',0,C,true);
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
	else
		$a1ATT=$q2ATT;
	
	if($q2DIL=='')
		$a1DIL=$q1DIL;
	else
		$a1DIL=$q2DIL;
	
	if($q2ORD=='')
		$a1ORD=$q1ORD;
	else
		$a1ORD=$q2ORD;
	
	if($q2CLE=='')
		$a1CLE=$q1CLE;
	else
		$a1CLE=$q2CLE;
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1','LRTB',0,C,true);
	$pdf->Cell( 7.45	,0.4,'Attitude (Kelakuan)','LRTB',0,L,true);
	$pdf->Cell( 2.25	,0.4,$q1ATT		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,$q2ATT		,'LRTB',0,C,true);
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
	$pdf->Cell( 2.25	,0.4,$q2DIL		,'LRTB',0,C,true);
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
	$pdf->Cell( 2.25	,0.4,$q2ORD		,'LRTB',0,C,true);
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
	$pdf->Cell( 2.25	,0.4,$q2CLE		,'LRTB',0,C,true);
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
	$pdf->Cell( 2.25	,0.4,$q2SKT		,'LRTB',0,C,true);
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
	$pdf->Cell( 2.25	,0.4,$q2IZN		,'LRTB',0,C,true);
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
	$pdf->Cell( 2.25	,0.4,$q2ALP		,'LRTB',0,C,true);
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
		
	
	
	$pdf->Ln();
	$pdf->Ln(0.85);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 4.5	,0.4,$tglctk,'',0,C); // 6
	$pdf->Cell( 2	,0);
	//$pdf->Image($signature, 8.25, 24.75, 4.577234, 2.143098);//$pdf->Image($signature);		(4.577234, 2.143098);		,0.625,0.75,2,2
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