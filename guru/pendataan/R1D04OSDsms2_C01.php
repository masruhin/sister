<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04OSDsms_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) rapot mid term sd 4
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdekls	=$_GET['kdekls'];
//$nis	=$_POST['nis'];
//$sms	=$_POST['sms'];
$sms	='2';
$midtrm	='2';//$_POST['midtrm'];
$tglctk	=$_POST['tglctk'];

$thnajr	=$_GET['thnajr'];

if($tglctk=='')
{
	$tglctk	=date('d F Y');
}
else
{	
	$tglctk	=strtotime($tglctk);
	$tglctk	=date('d F Y',$tglctk);
}

//if($sms=='2')
	//echo"<meta http-equiv='refresh' content=\"0;url=R1D04OSDsms2_C01.php?kdekls=$kdekls\">\n";

// dapatkan data tahun ajaran
/*$query	="	SELECT 		t_setthn_sd.*
			FROM 		t_setthn_sd
			WHERE		t_setthn_sd.set='Tahun Ajaran'"; // menghasilka tahun ajaran
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];*/

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


$logo_pt	="../../images/logo_sjs_meruya.png";//logo.jpg
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
					WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND 
								t_mstssw.thn_ajaran='". mysql_escape_string($thnajr)."' 
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
									t_prgrptps_sd.thn_ajaran='". mysql_escape_string($thnajr)."' AND 
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
						t_mstssw.thn_ajaran='". mysql_escape_string($thnajr)."' AND 
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
									t_prgrptps_sd.thn_ajaran='". mysql_escape_string($thnajr)."'	AND 
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



//while($y<$x) //..cetak all
//{
	$nis	=$cell5[$y][0];
	$nmassw	=$cell5[$y][1];
	$nisn	=$cell5[$y][2];
	
	$tgllhr	=$cell5[$y][4];
	$tgllhr	=strtotime($tgllhr);
	$tgllhr	=date('d-M-Y',$tgllhr);
	
	$strkls='';
	if($kdekls=='P-1A')
		$strkls='SAINT ANASTASIA';
	else if($kdekls=='P-1B')
		$strkls='SAINT TARCISIUS';
	else if($kdekls=='P-1C')
		$strkls='SAINT PATRICIA';
	else if($kdekls=='P-2A')
		$strkls='SAINT ATTALIA';
	else if($kdekls=='P-2B')
		$strkls='SAINT BEATRICE';
	else if($kdekls=='P-2C')
		$strkls='SAINT CHARLES';
	else if($kdekls=='P-3A')
		$strkls='SAINT TERESA';
	else if($kdekls=='P-3B')
		$strkls='SAINT ALOYSIUS GONZAGA';
	else if($kdekls=='P-3C')
		$strkls='SAINT MARGARET';
	else if($kdekls=='P-4A')
		$strkls='SAINT ABIGAIL';
	else if($kdekls=='P-4B')
		$strkls='SAINT BENEDICT';
	else if($kdekls=='P-4C')
		$strkls='SAINT CAROLUS';
	else if($kdekls=='P-5A')
		$strkls='SAINT ALENA';
	else if($kdekls=='P-5B')
		$strkls='SAINT BRIDGET';
	else if($kdekls=='P-5C')
		$strkls='SAINT COLETTE';
	else if($kdekls=='P-6A')
		$strkls='SAINT ARNOLD JANSSEN';
	else if($kdekls=='P-6B')
		$strkls='SAINT BLAISE';
	else //if($kdekls=='P-6C')
		$strkls='SAINT CLAIRE';
	
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
									t_prgrptps_sd.kdeplj='$kdeplj' AND 
									t_prgrptps_sd.thn_ajaran='$thnajr' "; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	$pdf->Image($logo_pt , 3, 2.5, 3, 3);
	//$pdf->Image($logo_ttw,18,1,2,2);
	$pdf->Ln(2.5);//4
	$pdf->SetFont('arial','B',16);
	$pdf->Cell( 2	,0.4,"",0,0,L); 
	$pdf->Cell(17.5	,0.6, "SAINT JOHN'S SCHOOL - MERUYA",0,0,C); // 19 $judul
	$pdf->SetFont('Arial','B',14);
	
	$pdf->Ln();
	$pdf->Cell( 2	,0.4,"",0,0,L);
	$pdf->Cell(17.5	,0.6, "SECOND SEMESTER CLASS PERFORMANCE",0,0,C); // 19 $judul2 
	$pdf->SetFont('Arial','',14);
	$pdf->Ln();
	$pdf->Cell( 2	,0.4,"",0,0,L);
	$pdf->Cell(17.5	,0.6, "ACADEMIC YEAR ".$thnajr,0,0,C); // 19 $judul2 .$thnajr
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',14);
	$pdf->Cell( 2	,0.4,"",0,0,L);
	$pdf->Cell(17.5	,0.6, "PRIMARY ".substr($kdekls,-2)." - ".$strkls,0,0,C);// 19
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat2_pt2
	
	
	
	//..sampai sini
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.75	,0.6,'',0,0,L); 
	$pdf->Cell( 0.6	,1.8,'No'		,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,1.8,'Subject'		,'LRTB',0,C,true);
	$pdf->Cell( 2.5	,0.6,'Minimum'		,'LRT',0,C,true);
	$pdf->Cell( 3	,0.6,'Class'		,'LRT',0,C,true);
	$pdf->Cell( 2	,0.6,'The'		,'LRT',0,C,true);
	$pdf->Cell( 2	,0.6,'The'		,'LRT',0,C,true);
	
	$pdf->Ln(0.6);
	$pdf->Cell( 0.75	,0.6,'',0,0,L); 
	$pdf->Cell( 7.8	,1.8,''		,0,0,C,false);
	$pdf->Cell( 2.5	,0.6,'Passing'		,'LR',0,C,true);//KNOWLEDGE
	$pdf->Cell( 3	,0.6,'Performance'		,'LR',0,C,true);//SKILLS
	$pdf->Cell( 2		,0.6,'Highest'		,'LR',0,C,true);//AVERAGE
	$pdf->Cell( 2		,0.6,'Lowest'		,'LR',0,C,true);//AVERAGE
	
	$pdf->Ln(0.6);
	$pdf->Cell( 0.75	,0.6,'',0,0,L); 
	$pdf->Cell( 7.8	,1.8,''		,0,0,C,false);
	$pdf->Cell( 2.5	,0.6,'Score'		,'LRB',0,C,true);//SCORE
	$pdf->Cell( 3	,0.6,'(Ave. Grade)'		,'LRB',0,C,true);//SCORE
	$pdf->Cell( 2	,0.6,'Grade'		,'LRB',0,C,true);//SCORE
	$pdf->Cell( 2	,0.6,'Grade'		,'LRB',0,C,true);//SCORE
	
	$pdf->Ln();
	//------------------------------- Mata Pelajaran Kurikulum Nasional
	$j	=1;
	$no =1;
	//$ttlakh=0;
	//$jmlplj=0;
	$pdf->SetFont('Arial','B',12);
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
				$pdf->SetFont('Arial','B',12);
				$pdf->SetFillColor(204,204,204);
				$pdf->Cell(6.2	,0.6,$nmasbj,'LRTB',0,L,true);		//A		6.2	,0.5
				$nliakh	='';
				
			}
			else
			{
				$pdf->SetFont('Arial','',12);
				$pdf->SetFillColor(255,255,255);
				
				if(substr($nmasbj,0,1)!='=')
				{
					$pdf->Cell( 0.75	,0.6,'',0,0,L);//1.5	,0.4
					$pdf->Cell(0.6	,0.6,$no,'LRTB',0,C,true);//0.6	,0.5
				}
				else
				{
					$pdf->Cell( 0.75	,0.6,'',0,0,L);//1.5	,0.4
					$pdf->Cell(0.6	,0.6,'','LRTB',0,C,true);//0.6	,0.5
				}
				
				if(substr($nmasbj,0,1)!='=')
				{
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0.1	,0.6,'','LTB',0,R,true); // 0.6 $no.'.'		0.1	,0.5
					$pdf->Cell(7.1	,0.6,$nmasbj,'RTB',0,L,true);//5.6	,0.5
					
					$no++;
				}
				else
				{
					$nmasbj 	=str_replace("=","","$nmasbj");
					$pdf->Cell(5.7	,0.5,'        '.$nmasbj,'LRTB',0,L,true); // 6.2
				}	
				
				
				
			}	
			
			
			
			$qry ="	SELECT 		t_smscp_sd.*
						FROM 		t_smscp_sd
						WHERE		t_smscp_sd.kdekls='$kdekls'		AND
									t_smscp_sd.kdeplj='$kdeplj' AND 
									t_smscp_sd.thn_ajaran='$thnajr'	"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl=mysql_query($qry) or die('Query gagal');
			$dat =mysql_fetch_array($rsl);
			
			$avekls=$dat['avekls2'];
			$maxkls=$dat['maxkls2'];
			$minkls=$dat['minkls2'];
			
				
			
			
			$pdf->SetFont('Arial','',12);
			$pdf->Cell( 2.5	,0.6, $kkm,'LRTB',0,C,true);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell( 3	,0.6, number_format( $avekls ,2,',','.'),'LRTB',0,C,true);//S
			$pdf->SetFont('Arial','',12);
			$pdf->Cell( 2	,0.6, $maxkls ,'LRTB',0,C,true);
			$pdf->Cell( 2	,0.6, $minkls ,'LRTB',0,C,true);
			
			$pdf->SetTextColor(0,0,0);
			
			$pdf->Ln();
		}	
		
		
		
		$j++;
		$id++;
		//$id=$cell[$j][0];
	}
	
	
	
	//..
	
	//$pdf->Ln();
	$pdf->Ln(0.85);
	$pdf->Cell( 0.75	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 8.7	,0.6,'','',0,C,true);//7.1
	$pdf->Cell( 1	,0.4,'',0,0,L);
	$pdf->Cell( 6.1	,0.6,'Jakarta, '.$tglctk,0,0,L);//2.3
	$pdf->Cell( 6.1 ,0.6,'',0,0,L,true);
	
	//absences
	$qABS	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$nis' AND 
							t_hdrkmnps.thn_ajaran='$thnajr'  "; // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	
	$q1SKT=$dABS['skt'.$sms.$midtrm]; // q1 skt
	$q1IZN=$dABS['izn'.$sms.$midtrm]; // q1 izn
	$q1ALP=$dABS['alp'.$sms.$midtrm]; // q1 alp
	
	if($q1SKT==0)
		$q1SKT='-';
	if($q1IZN==0)
		$q1IZN='-';
	if($q1ALP==0)
		$q1ALP='-';
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.75	,0.4,'',0,0,L);
	$pdf->Cell( 6.35,0.6,'','',0,C,true);//5.35
	$pdf->Cell( 0.25,0.6,'','',0,C,true);
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell( 0.75,0.6,'','',0,C,true);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 1.35,0.6,'','',0,C,true);//0.75
	$pdf->Cell( 1	,0.4,'',0,0,L);
	$pdf->Cell( 1.6,0.6,'Issued by:',0,0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.75	,0.4,'',0,0,L);
	$pdf->Cell( 6.35,0.6,'','',0,C,true);
	$pdf->Cell( 0.25,0.6,'',0,0,C,true);
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell( 0.75,0.6,'',0,0,C,true);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 1.35,0.6,'','',0,C,true);
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.75	,0.4,'',0,0,L);
	$pdf->Cell( 6.35,0.6,'','',0,C,true);
	$pdf->Cell( 0.25,0.6,'','',0,C,true);
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell( 0.75,0.6,'','',0,C,true);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 1.35,0.6,'','',0,C,true);
	$pdf->Cell( 0.7	,0.6,'',0,0,L);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 7.1	,0.6,'',0,0,C,true);//'                  '.
	
	//..
	
	$pdf->Ln(0.6);//0.5
	$pdf->Cell( 0.75	,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,false);
	$pdf->Cell( 2.3,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell( 7.1	,0.6,''.$wlikls.$gelar,0,0,C,true);
	
	$pdf->Ln(0.5);//0.5
	$pdf->Cell( 0.75	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
	$pdf->Cell( 2.3,0.4,'',0,0,L);
	//$pdf->SetFont('Arial','',12);
	$pdf->Cell( 7.1	,0.6,''.'Homeroom Adviser',0,0,C,true);
	
	$pdf->Ln(2);//2
	$pdf->Cell( 0.75	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell( 7.1	,0.4,'',0,0,L,true);
	$pdf->Cell( 2.3,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell( 7.1	,0.4,'',0,0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 0.75	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 7.1	,0.6,"",0,0,C,true);
	$pdf->Cell( 2.3,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.6,'',0,0,C,true);
	
	
	
	
	$y++;
	
//}//cetak all

$pdf->Output();

?>