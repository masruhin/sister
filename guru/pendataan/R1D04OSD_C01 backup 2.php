<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04OSD_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) rapot mid term sd 4
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
	$tglctk	=date('d F Y');
}
else
{	
	$tglctk	=strtotime($tglctk);
	$tglctk	=date('d F Y',$tglctk);
}

// dapatkan data tahun ajaran
$query	="	SELECT 		t_setthn.*
			FROM 		t_setthn
			WHERE		t_setthn.set='Tahun Ajaran'"; // menghasilka tahun ajaran
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='1HW'"; // menghasilka bobot 1
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='2PRJ'"; // menghasilka bobot 2
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='3TES'"; // menghasilka bobot 3
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='4MID'"; // menghasilkan bobot 4
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtmidtes=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='5ST'"; // menghasilkan bobot 5
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtst=$data[bbt];

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
		$query3 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sd.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sd.nis,t_prgrptps_sd.kdeplj"; // menghasilka satu siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	
		$query2 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sd.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sd.nis,t_prgrptps_sd.kdeplj"; // menghasilka satu siswa per subjek (nilai akhir q1/q2/q3/q4)
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

//..--
//echo"$y<$x sampai sini";

while($y<$x)
{
	$nis	=$cell5[$y][0];
	$nmassw	=$cell5[$y][1];
	$nisn	=$cell5[$y][2];
	
	$tgllhr	=$cell5[$y][4];
	$tgllhr	=strtotime($tgllhr);
	$tgllhr	=date('d-M-Y',$tgllhr);
	
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
			$query2 ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND
									t_prgrptps_sd.kdeplj='$kdeplj'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$result2=mysql_query($query2) or die('Query gagal');
			$data2 =mysql_fetch_array($result2);
			
			$cell[$i][4]=$data2['akh'."$sms"."1"];
			$cell[$i][5]=$data2['akh'."$sms"."2"];
			$cell[$i][6]=number_format(($cell[$i][4]+$cell[$i][5])/2,0,',','.');
			$nliakh		=$cell[$i][6];
			
			//$cell[$i][7]=$data2['akh'."1"."1"]; // q1
			//$cell[$i][8]=$data2['akh'."1"."2"]; // q2
			
			//$cell[$i][9] = $data2['akh'."2"."1"];//q3
			//$cell[$i][10] = $data2['akh'."2"."2"];//q4

			
		}	
		else
		{
			$cell[$i][3]='';
		}
		$i++;
	}
	
	$pdf->Open();
	$pdf->AddPage();
	//$pdf->Image($logo_pt ,1,0.75,2,2);
	//$pdf->Image($logo_ttw,18,1,2,2);
	$pdf->Ln(4);//3.5
	$pdf->SetFont('arial','B',12);
	$pdf->Cell(17.5	,0.4, "STUDENT'S PROGRESS REPORT",0,0,C); // 19 $judul
	$pdf->SetFont('Arial','B',11);
	$pdf->Ln();
	
	$pdf->Cell(17.5	,0.4, "ACADEMIC YEAR ".$thnajr,0,0,C); // 19 $judul2
	$pdf->Ln();
	
	$pdf->Cell(17.5	,0.4, "PRIMARY ".substr($kdekls,-2)." - SAINT JOHN'S SCHOOL",0,0,C);// 19
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat2_pt2
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 6	,0.4,"",0,0,L); 
	$pdf->Cell( 1.5	,0.4,"Semester : ",0,0,L); 
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 1.5	,0.4,"     ".$sms."     ",0,0,L); 
	$pdf->Cell( 0.5	,0.4,"",0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.	,0.4,"Term : ",0,0,L); 
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 1.5	,0.4,"     ".$midtrm."     ",0,0,L); //".$sms."=2
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 4.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"STUDENT NAME  : ",0,0,L); 
	$pdf->SetFont('Arial','UB',8);
	$pdf->Cell( 5.7	,0.4,$nmassw."                         ",0,0,L); 
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 4.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"STUDENT ID NO. : ",0,0,L); 
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 2	,0.4,substr($nis,0,3)."          ",0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.7	,0.4,"BIRTHDAY : ",0,0,L); 
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 2	,0.4,$tgllhr,0,0,L); 
	
	//..sampai sini
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->Cell( 14.8	,0.4,'ACADEMIC PERFORMANCE'		,'LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->Cell( 6.3	,1.2,'SUBJECT'		,'LRTB',0,C,true);
	$pdf->Cell( 7	,0.4,'CLASSROOM PERFORMANCE'		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,1.2,'ATTITUDE'		,'LRTB',0,C,true);
	
	$pdf->Ln(0.4);
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->Cell( 6.3	,1.2,''		,0,0,C,false);
	$pdf->Cell( 2.25	,0.4,'KNOWLEDGE'		,'LRTB',0,C,true);
	$pdf->Cell( 2.25	,0.4,'SKILLS'		,'LRTB',0,C,true);
	$pdf->Cell( 2.5		,0.4,'AVERAGE'		,'LRTB',0,C,true);
	
	$pdf->Ln(0.4);
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->Cell( 6.3	,1.2,''		,0,0,C,false);
	$pdf->Cell( 1.5	,0.4,'SCORE'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75,0.4,'LG'		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'SCORE'		,'LRTB',0,C,true);
	$pdf->Cell( 0.75,0.4,'LG'		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'SCORE'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'LG'		,'LRTB',0,C,true);
	$pdf->Ln();
	//------------------------------- Mata Pelajaran Kurikulum Nasional
	$j	=1;
	$no =1;
	//$ttlakh=0;
	//$jmlplj=0;
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[$j][0];
	
	
	//echo"$id - ";
	
	
	while ($id<99)
	{
		//menampilkan data dari hasil query database
		$nmasbj	=$cell[$j][1];
		$kdeplj	=$cell[$j][2];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		
		//$q1		=$cell[$j][7];
		//$q2		=$cell[$j][8];
		
		//$q3		=$cell[$j][9];
		//$q4		=$cell[$j][10];
		//$av1	= ($q1 + $q2) / 2;
		
		$q1K='';
		$q1S='';
		
		$lgK='';
		$lgS='';
		
		$ave1KS='';
		$lgKS='';
		
		$lg7='';
		
		if($nmasbj!='')
		{
			if(substr($nmasbj,0,1)=='/')
			{
				$nmasbj 	=str_replace("/","","$nmasbj");
				$pdf->SetFont('Arial','B',8);
				$pdf->SetFillColor(204,204,204);
				$pdf->Cell(6.2	,0.5,$nmasbj,'LRTB',0,L,true);		//A
				$nliakh	='';
				
			}
			else
			{
				$pdf->SetFont('Arial','',8);
				$pdf->SetFillColor(255,255,255);
				
				if(substr($nmasbj,0,1)!='=')
				{
					$pdf->Cell( 1.5	,0.4,'',0,0,L);
					$pdf->Cell(0.6	,0.5,$no,'LRTB',0,C,true);
				}
				else
				{
					$pdf->Cell( 1.5	,0.4,'',0,0,L);
					$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);
				}
				
				if(substr($nmasbj,0,1)!='=')
				{
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(0.1	,0.5,'','LTB',0,R,true); // 0.6 $no.'.'
					$pdf->Cell(5.6	,0.5,$nmasbj,'RTB',0,L,true);
					
					$no++;
				}
				else
				{
					$nmasbj 	=str_replace("=","","$nmasbj");
					$pdf->Cell(5.7	,0.5,'        '.$nmasbj,'LRTB',0,L,true); // 6.2
				}	
				
				
				//if($q1==0)
				//{
					//$kkm	='';
				//}
				
			}	
			//$pdf->Cell( 2	,0.5,$kkm,'LRTB',0,C,true);			//kkm
			
			//q1
			//if($q1<$kkm)
				//$pdf->SetTextColor(255,0,0);
			//else
				//$pdf->SetTextColor(0,0,0);
			
			$qry ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND
									t_prgrptps_sd.kdeplj='$kdeplj'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl=mysql_query($qry) or die('Query gagal');
			$dat =mysql_fetch_array($rsl);
			
			$q1STK=$dat['st'."1"."1"."9"]; // q1
			$q1STS=$dat['st_'."1"."1"."9"]; // q1
			$q1av7=$dat['akh'."1"."1"]; // q1
			
			$q1K = $q1STK;
			$q1S = $q1STS;
			
			$ave1KS = ( $q1K + $q1S ) / 2;
				
			if($q1K>100)
				$lgK = 'ERR';
			else if($q1K>=91.5)
				$lgK = 'A';
			else if($q1K>=83.25)
				$lgK = 'A-';
			else if($q1K>=75)
				$lgK = 'B+';
			else if($q1K>=66.5)
				$lgK = 'B';
			else if($q1K>=58.25)
				$lgK = 'B-';
			else if($q1K>=41.5)
				$lgK = "C";
			else if($q1K>=33.25)
				$lgK = "C-";
			else if($q1K>=25)
				$lgK = "D+";
			else //if($q1K>=0)
				$lgK = "D";
			
			if($q1S>100)
				$lgS = 'ERR';
			else if($q1S>=91.5)
				$lgS = 'A';
			else if($q1S>=83.25)
				$lgS = 'A-';
			else if($q1S>=75)
				$lgS = 'B+';
			else if($q1S>=66.5)
				$lgS = 'B';
			else if($q1S>=58.25)
				$lgS = 'B-';
			else if($q1S>=41.5)
				$lgS = "C";
			else if($q1S>=33.25)
				$lgS = "C-";
			else if($q1S>=25)
				$lgS = "D+";
			else //if($q1S>=0)
				$lgS = "D";
				
			if($ave1KS>100)
				$lgKS = 'ERR';
			else if($ave1KS>=91.5)
				$lgKS = 'A';
			else if($ave1KS>=83.25)
				$lgKS = 'A-';
			else if($ave1KS>=75)
				$lgKS = 'B+';
			else if($ave1KS>=66.5)
				$lgKS = 'B';
			else if($ave1KS>=58.25)
				$lgKS = 'B-';
			else if($ave1KS>=41.5)
				$lgKS = "C";
			else if($ave1KS>=33.25)
				$lgKS = "C-";
			else if($ave1KS>=25)
				$lgKS = "D+";
			else //if($ave1KS>=0)
				$lgKS = "D";
				
			if($q1av7>100)
				$lg7 = 'ERR';
			else if($q1av7>=91.5)
				$lg7 = 'A';
			else if($q1av7>=83.25)
				$lg7 = 'A-';
			else if($q1av7>=75)
				$lg7 = 'B+';
			else if($q1av7>=66.5)
				$lg7 = 'B';
			else if($q1av7>=58.25)
				$lg7 = 'B-';
			else if($q1av7>=41.5)
				$lg7 = "C";
			else if($q1av7>=33.25)
				$lg7 = "C-";
			else if($q1av7>=25)
				$lg7 = "D+";
			else //if($q1av7>=0)
				$lg7 = "D";
			
			/*$qRLG ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND
									t_prgrptps_sd.kdeplj='RLG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rRLG=mysql_query($qRLG) or die('Query gagal');
			$dRLG =mysql_fetch_array($rRLG);
			$q1STKrlg=$dRLG['st'."1"."1"."9"]; // q1
			
			if ( $kdeplj == 'RLG' )
			{
				$q1 = $q1STKrlg;
				
				if($q1STKrlg>100)
					$lg = 'ERR';
				else if($q1STKrlg>=91.5)
					$lg = 'A';
				else if($q1STKrlg>=83.25)
					$lg = 'A-';
				else if($q1STKrlg>=75)
					$lg = 'B+';
				else if($q1STKrlg>=66.5)
					$lg = 'B';
				else if($q1STKrlg>=58.25)
					$lg = 'B-';
				else if($q1STKrlg>=41.5)
					$lg = "C";
				else if($q1STKrlg>=33.25)
					$lg = "C-";
				else if($q1STKrlg>=25)
					$lg = "D+";
				else //if($q1STKrlg>=0)
					$lg = "D";
			}*/
			
			
			
			//q2
			//if($q2==0)
				//$q2 = '';
			
			//av1
			//if($av1==0)
				//$av1 = '';
			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell( 1.5	,0.5,$q1K,'LRTB',0,C,true);
			$pdf->Cell( 0.75,0.5,$lgK,'LRTB',0,C,true);//K
			$pdf->Cell( 1.5	,0.5,$q1S,'LRTB',0,C,true);//S
			$pdf->Cell( 0.75,0.5,$lgS,'LRTB',0,C,true);
			$pdf->Cell( 1.5	,0.5, $ave1KS,'LRTB',0,C,true);
			$pdf->Cell( 1	,0.5,$lgKS,'LRTB',0,C,true);
			$pdf->Cell( 1.5	,0.5,$lg7,'LRTB',0,C,true);
			
			$pdf->SetTextColor(0,0,0);
			
			$pdf->Ln();
		}	
		
		
		
		$j++;
		$id++;
		//$id=$cell[$j][0];
	}
	
	$pdf->Ln(0.35);
	$pdf->Cell( 1.5	,0.5,'',0,0,L);
	$pdf->Cell( 14.8,0.5,'EXTRA-CURRICULAR ACTIVITY PERFORMANCE','LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 5.8	,0.4,'ACTIVITY','LRTB',0,C,true);
	$pdf->Cell( 9	,0.4,'REMARKS','LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1,'1','LRTB',0,C,true);
	$pdf->Cell( 5.2	,1,'Praja Muda Karana (Pramuka)','LRTB',0,C,true);
	$pdf->Cell( 9	,1,'-','LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1,'2','LRTB',0,C,true);
	$pdf->Cell( 5.2	,1,'BASKETBALL','LRTB',0,C,true);
	$pdf->Cell( 9	,0.5,'Regularly attends and actively participates in school activities and ','LRT',0,L,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1,'',0,0,C,false);
	$pdf->Cell( 5.2	,1,'',0,0,C,false);
	$pdf->Cell( 9	,0.5,'shows great enthusiasm in performing school activities','LRB',0,L,true);
	
	//..
	
	$pdf->Ln(0.85);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.4,'ATTENDANCE',LRTB,0,C,true);
	$pdf->Cell( 1.6	,0.4,'Place/Date:',0,0,L);
	$pdf->Cell( 6.1 ,0.4,'         Jakarta, '.$tglctk,0,0,L,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 5.35,0.4,'ABSENCE DUE TO SICKNESS','LT',0,C,true);
	$pdf->Cell( 0.25,0.4,' : ','T',0,C,true);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 0.75,0.4,'   -   ','T',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,' day/s  ','RT',0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 5.35,0.4,'EXCUSED ABSENCE','L',0,C,true);
	$pdf->Cell( 0.25,0.4,' : ',0,0,C,true);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 0.75,0.4,'   -   ',0,0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,' day/s  ','R',0,C,true);
	$pdf->Cell( 1.6,0.4,'Issued by:',0,0,L);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 5.35,0.4,'UNEXCUSED ABSENCE','LB',0,C,true);
	$pdf->Cell( 0.25,0.4,' : ','B',0,C,true);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 0.75,0.4,'   -   ','B',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,' day/s  ','RB',0,C,true);
	$pdf->Cell( 0.6	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',8);
	$pdf->Cell( 7.1	,0.4,'                  '.$wlikls.$gelar.'                 ',0,0,C,true);
	
	//..
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
	$pdf->Cell( 0.6,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.4,''.'Homeroom Adviser',0,0,C,true);
	
	$pdf->Ln(2);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',8);
	$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
	$pdf->Cell( 0.6,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.4,'                   '.$kplskl.', S.Fil'.'                   ',0,0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 7.1	,0.4,"                   PARENT'S SIGNATURE",0,0,L,true);
	$pdf->Cell( 0.6,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.4,'PRINCIPAL',0,0,C,true);
	
	
	
	
	$y++;
	
}//cetak all

$pdf->Output();

?>