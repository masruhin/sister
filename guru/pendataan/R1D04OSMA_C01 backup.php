<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04OSMA_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) rapot mid term sma 10 ipa
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
$query	="	SELECT 		t_setthn_sma.*
			FROM 		t_setthn_sma
			WHERE		t_setthn_sma.set='Tahun Ajaran'"; // menghasilka tahun ajaran
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_sma_k13.*
			FROM 		t_mstbbt_sma_k13
			WHERE		t_mstbbt_sma_k13.kdebbt='1HW'"; // menghasilka bobot 1
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma_k13.*
			FROM 		t_mstbbt_sma_k13
			WHERE		t_mstbbt_sma_k13.kdebbt='2PRJ'"; // menghasilka bobot 2
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma_k13.*
			FROM 		t_mstbbt_sma_k13
			WHERE		t_mstbbt_sma_k13.kdebbt='3TES'"; // menghasilka bobot 3
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma_k13.*
			FROM 		t_mstbbt_sma_k13
			WHERE		t_mstbbt_sma_k13.kdebbt='4MID'"; // menghasilkan bobot 4
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtmidtes=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma_k13.*
			FROM 		t_mstbbt_sma_k13
			WHERE		t_mstbbt_sma_k13.kdebbt='5ST'"; // menghasilkan bobot 5
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
$signature	="../../images/signature.jpg";

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
		$query3 	="	SELECT 		t_prgrptps_sma_k13.*
						FROM 		t_prgrptps_sma_k13
						WHERE 		t_prgrptps_sma_k13.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma_k13.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sma_k13.nis,t_prgrptps_sma_k13.kdeplj"; // menghasilka satu siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	$cell5[$i][5]=$data[tmplhr]; // buatan tMP lahir
	
	$ttlakh1=0;
	$ttlakh2=0;
	$ttlakh=0;
	$n=0;
	while($n<$k)
	{
		$kdeplj=$cell2[$n][0];
	
		$query2 	="	SELECT 		t_prgrptps_sma_k13.*
						FROM 		t_prgrptps_sma_k13
						WHERE 		t_prgrptps_sma_k13.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_sma_k13.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sma_k13.nis,t_prgrptps_sma_k13.kdeplj"; // menghasilka satu siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	$tgllhr	=date('F d, Y',$tgllhr);
	$tmplhr	=$cell5[$y][5];
	
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
			$query2 ="	SELECT 		t_prgrptps_sma_k13.*
						FROM 		t_prgrptps_sma_k13
						WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
									t_prgrptps_sma_k13.kdeplj='$kdeplj'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	
	
	
	// awal halaman 1
	
	
	
	$pdf->Open();
	$pdf->AddPage();
	//$pdf->Image($logo_pt ,1,0.75,2,2);
	//$pdf->Image($logo_ttw,18,1,2,2);
	$pdf->Ln(3);
	$pdf->SetFont('arial','BU',12);
	$pdf->Cell(17.5	,0.4, "SENIOR HIGH SCHOOL",0,0,C); // 19 $judul
	$pdf->SetFont('Arial','B',14);
	$pdf->Ln(0.55);
	
	$pdf->Cell(17.5	,0.4, "STUDENT'S PROGRESS REPORT",0,0,C); // 19 $judul2 .substr($kdekls,-2)
	$pdf->Ln();
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(17.5	,0.4, "ACADEMIC YEAR ".$thnajr,0,0,C);// 19 ." - SAINT JOHN'S SCHOOL"
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat2_pt2
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Semester",0,0,L); 
	$pdf->Cell( 0.5	,0.4," :",0,0,C); 
	$pdf->Cell( 5.7	,0.4,$sms,0,0,L); //1.5
	$pdf->Cell( 0.5	,0.4,"",0,0,L); 
	$pdf->Cell( 1.5	,0.4,"Term",0,0,L); 
	$pdf->Cell( 0.5	,0.4," :",0,0,C); 
	$pdf->Cell( 1.5	,0.4,$midtrm,0,0,L); //".$sms."=2
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Student Name",0,0,L); 
	$pdf->Cell( 0.5	,0.4," :",0,0,C); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 5.7	,0.4,$nmassw,0,0,L); //."                         "
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Student ID No",0,0,L); 
	$pdf->Cell( 0.5	,0.4," :",0,0,C); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 5.7	,0.4,substr($nis,0,3),0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.5	,0.4,"",0,0,L); 
	$pdf->Cell( 1.5	,0.4,"Birthday",0,0,L); 
	$pdf->Cell( 0.5	,0.4," :",0,0,C); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 2	,0.4,$tmplhr.", ".$tgllhr,0,0,L); 
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 0.5	,0.4,"A.",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Attitude",0,0,L); 
	
	//1
	//spiritual behaviour
	$qPER	="	SELECT 		t_personps.*
				FROM 		t_personps
				WHERE		t_personps.nis='$nis' "; // menghasilka nilai kepribadian
	$rPER=mysql_query($qPER) or die('Query gagal40');
	$dPER =mysql_fetch_array($rPER);
	
	$q1SPR=$dPER['spr'.$sms.$midtrm]; // q1 spr
	$q1SOC=$dPER['soc'.$sms.$midtrm]; // q1 soc
	
	$desSPR='';
	$desSOC='';
	
	if($q1SPR=='A')
		$desSPR='Has shown a very good understanding of the scipture relating it to his/her life experiences. Demonstrates a very good retention of bibilical terms and characters, church practices and doctrines. ';
	else if($q1SPR=='B')
		$desSPR='Has shown a  good understanding of the scipture relating it to his/her life experiences. Demonstrates a good retention of bibilical terms and characters, church practices and doctrines. ';
	else if($q1SPR=='C')
		$desSPR='Has shown an average understanding of the scipture relating it to his/her life experiences. Demonstrates an average retention of bibilical terms and characters, church practices and doctrines. ';
	else if($q1SPR=='D')
		$desSPR='-';
	else //if($q1SPR=='E')
		$desSPR='-';
	
	if($q1SOC=='A')
		$desSOC='Has formulated a very good and sound principle for him/herself to become worthy individual and citizen in accordance to the principles of Pancasila. Has a very good understanding of what is right and good for himself and others, environment, country and the world.';
	else if($q1SOC=='B')
		$desSOC='Has formulated a good and sound principle for him/herself to become worthy individual and citizen in accordance to the principles of Pancasila. Has a good understanding of what is right and good for himself and others, environment, country and the world.';
	else if($q1SOC=='C')
		$desSOC='Has a moderate principle for him/herself to become worthy individual and citizen in accordance to the principles of Pancasila. Has an average understanding of what is right and good for himself and others, environment, country and the world.';
	else if($q1SOC=='D')
		$desSOC='-';
	else //if($q1SOC=='E')
		$desSOC='-';
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 0.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"1   Spiritual Behavior",0,0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.8,"",0,0,L); 
	$pdf->Cell( 3	,0.8,"LETTER GRADE",'LRTB',0,C); 
	$pdf->Cell( 11.8	,0.8,"DESCRIPTION",'LRTB',0,C); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3	,0.4,"",'LR',0,C); 
	$pdf->Cell( 11.8	,0.4,substr($desSPR,0,92),'LR',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3	,0.4,$q1SPR,'LR',0,C); 
	$pdf->Cell( 11.8	,0.4,substr($desSPR,92,92),'LR',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3	,0.4,"",'LRB',0,C); 
	$pdf->Cell( 11.8	,0.4,substr($desSPR,184,92),'LRB',0,L);
	
	//2
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 0.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"2   Social Behavior",0,0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.8,"",0,0,L); 
	$pdf->Cell( 3	,0.8,"LETTER GRADE",'LRTB',0,C); 
	$pdf->Cell( 11.8	,0.8,"DESCRIPTION",'LRTB',0,C); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3	,0.4,"",'LR',0,C); 
	$pdf->Cell( 11.8	,0.4,substr($desSOC,0,80),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3	,0.8,$q1SOC,'LR',0,C); 
	$pdf->Cell( 11.8	,0.4,substr($desSOC,80,80),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3	,0.4,"",'LR',0,C,false); 
	$pdf->Cell( 11.8	,0.4,substr($desSOC,160,80),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3	,0.4,"",'LRB',0,C); 
	$pdf->Cell( 11.8	,0.4,substr($desSOC,240,80),'LRB',0,L); 
	
	//3
	//absences
	$qABS	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$nis' "; // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	
	//$q1SKT=$dABS['skt'."1"."1"]; // q1 skt
	//$q1IZN=$dABS['izn'."1"."1"]; // q1 izn
	//$q1ALP=$dABS['alp'."1"."1"]; // q1 alp
	//$q1KMN=$dABS['kmn'."1"."1"]; // q1 kmn
	$qKMN=$dABS['kmn'.$sms.$midtrm]; // q kmn
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 0.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"3   Comment",0,0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 14.8,0.4,substr($qKMN,0,114),'LRT',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 14.8,0.4,substr($qKMN,114,114),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 14.8,0.4,substr($qKMN,228,114),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 14.8,0.4,substr($qKMN,342,114),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 14.8,0.4,substr($qKMN,456,114),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 14.8,0.4,substr($qKMN,570,114),'LRB',0,L); 
	
	
	
	
	
	
	
	
	
	
	
	$pdf->Ln(1);
	$pdf->Ln(0.85);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.4,'',0,0,C,false);
	$pdf->Cell( 1.6	,0.4,'Place/Date:',0,0,L);
	$pdf->Cell( 1.3	,0.4,'',0,0,L);
	$pdf->Cell( 6 ,0.4,'Jakarta, '.$tglctk,0,0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 5.35,0.4,'',0,0,C,false);
	$pdf->Cell( 0.25,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 5.35,0.4,'',0,0,C,false);
	$pdf->Cell( 0.25,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->Cell( 1.6,0.4,'',0,0,L);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 5.35,0.4,'',0,0,C,false);
	$pdf->Cell( 0.25,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 0.25,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','',8);
	//$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->Cell( 1.6	,0.4,'Issued by:',0,0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 6	,0.4,'  '.'  ',0,0,C,true);
	$pdf->Image($signature, 13, 20, 4.577234, 2.143098);
	
	//..
	
	$pdf->Ln(2);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',8);
	$pdf->Cell( 3	,0.4,'                     '.'                    ',0,0,C,true);
	$pdf->Cell( 2.7,0.4,'',0,0,L);
	$pdf->Cell( 3	,0.4,'  '.$wlikls.$gelar.'  ',0,0,C,true);
	$pdf->Cell( 2.7,0.4,'',0,0,L);
	$pdf->Cell( 3	,0.4,'  '.'Ir. '.$kplskl.', MBA'.'  ',0,0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 3	,0.4,"Parent's Signature",0,0,C,true);
	$pdf->Cell( 2.7,0.4,'',0,0,L);
	$pdf->Cell( 3	,0.4,'Homeroom Adviser',0,0,C,true);
	$pdf->Cell( 2.7,0.4,'',0,0,L);
	$pdf->Cell( 3	,0.4,'Principal',0,0,C,true);
	
	
	
	//..sampai sini
	//awal halaman 2
	
	
	
	$pdf->Open();
	$pdf->AddPage();
	//$pdf->Image($logo_pt ,1,0.75,2,2);
	//$pdf->Image($logo_ttw,18,1,2,2);
	$pdf->Ln(3);
	$pdf->SetFont('arial','BU',12);
	$pdf->Cell(17.5	,0.4, "SENIOR HIGH SCHOOL",0,0,C); // 19 $judul
	$pdf->SetFont('Arial','B',14);
	$pdf->Ln(0.55);
	
	$pdf->Cell(17.5	,0.4, "STUDENT'S PROGRESS REPORT",0,0,C); // 19 $judul2 .substr($kdekls,-2)
	$pdf->Ln();
	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(17.5	,0.4, "ACADEMIC YEAR ".$thnajr,0,0,C);// 19 ." - SAINT JOHN'S SCHOOL"
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat2_pt2
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Semester",0,0,L); 
	$pdf->Cell( 0.5	,0.4," :",0,0,C); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 5.7	,0.4,$sms,0,0,L); //1.5
	$pdf->Cell( 0.5	,0.4,"",0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"Term",0,0,L); 
	$pdf->Cell( 0.5	,0.4," :",0,0,C); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,$midtrm,0,0,L); //".$sms."=2
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Student Name",0,0,L); 
	$pdf->Cell( 0.5	,0.4," :",0,0,C); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 5.7	,0.4,$nmassw,0,0,L); //."                         "
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"Student ID No",0,0,L); 
	$pdf->Cell( 0.5	,0.4," :",0,0,C); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 5.7	,0.4,substr($nis,0,3),0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.5	,0.4,"",0,0,L); 
	$pdf->Cell( 1.5	,0.4,"Birthday",0,0,L); 
	$pdf->Cell( 0.5	,0.4," :",0,0,C); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 2	,0.4,$tmplhr.", ".$tgllhr,0,0,L); 
	
	//..sampai sini
	
	$pdf->Ln(0.75);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->Cell( 0.6	,1.2,'No'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,1.2,'SUBJECT'		,'LRTB',0,C,true);//6.7
	$pdf->Cell( 2	,0.4,'Minimum'		,'LRT',0,C,true);
	$pdf->Cell( 5	,0.4,'CLASSROOM PERFORMANCE'		,'LRTB',0,C,true);
	
	$pdf->Ln(0.4);
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->Cell( 7.8	,1.2,''		,0,0,C,false);//7.3
	$pdf->Cell( 2	,0.4,'Passing'		,'LR',0,C,true);
	$pdf->Cell( 2.5	,0.4,'KNOWLEDGE'		,'LRTB',0,C,true);
	$pdf->Cell( 2.5	,0.4,'SKILLS'		,'LRTB',0,C,true);
	
	$pdf->Ln(0.4);
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->Cell( 7.8	,1.2,''		,0,0,C,false);//7.3
	$pdf->Cell( 2	,0.4,'Score'		,'LRB',0,C,true);
	$pdf->Cell( 1	,0.4,'Score'		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,'Letter Grade'		,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,'Score'		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,'Letter Grade'		,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,235);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFillColor(245, 222, 179);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.6	,0.4,''			,'LTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'CORE'		,'TB',0,L,true);
	$pdf->Cell( 2	,0.4,''		,'TB',0,C,true);
	$pdf->Cell( 5	,0.4,''		,'RTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//rlg
	$qKKMrlg 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='RLG' "; // menghasilka kkm per kelas per subjek
	$rKKMrlg =mysql_query($qKKMrlg) or die('Query gagal');
	$dKKMrlg =mysql_fetch_array($rKKMrlg);
	$nKKMrlg=$dKKMrlg[kkm];
	
	$qRLG ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='RLG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rRLG=mysql_query($qRLG) or die('Query gagal');
	$dRLG =mysql_fetch_array($rRLG);
	
	$qSTK=$dRLG['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dRLG['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'Religion and Character Education'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,$nKKMrlg		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//cme
	$qKKMcme 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='CME' "; // menghasilka kkm per kelas per subjek
	$rKKMcme =mysql_query($qKKMcme) or die('Query gagal');
	$dKKMcme =mysql_fetch_array($rKKMcme);
	$nKKMcme=$dKKMcme[kkm];
	
	$qCME ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='CME'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rCME=mysql_query($qCME) or die('Query gagal');
	$dCME =mysql_fetch_array($rCME);
	
	$qSTK=$dCME['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dCME['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'2'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'Pancasila and Civics Education'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,$nKKMcme		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//bin
	$qKKMbin 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='BIN' "; // menghasilka kkm per kelas per subjek
	$rKKMbin =mysql_query($qKKMbin) or die('Query gagal');
	$dKKMbin =mysql_fetch_array($rKKMbin);
	$nKKMbin=$dKKMbin[kkm];
	
	$qBIN ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='BIN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rBIN=mysql_query($qBIN) or die('Query gagal');
	$dBIN =mysql_fetch_array($rBIN);
	
	$qSTK=$dBIN['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dBIN['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'3'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'Bahasa Indonesia'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,$nKKMbin		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//eng
	$qKKMeng 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='ENG' "; // menghasilka kkm per kelas per subjek
	$rKKMeng =mysql_query($qKKMeng) or die('Query gagal');
	$dKKMeng =mysql_fetch_array($rKKMeng);
	$nKKMeng=$dKKMeng[kkm];
	
	$qENG ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='ENG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rENG=mysql_query($qENG) or die('Query gagal');
	$dENG =mysql_fetch_array($rENG);
	
	$qSTK=$dENG['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dENG['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'4'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'English'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,$nKKMeng		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//mth
	$qKKMmth 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='MTH' "; // menghasilka kkm per kelas per subjek
	$rKKMmth =mysql_query($qKKMmth) or die('Query gagal');
	$dKKMmth =mysql_fetch_array($rKKMmth);
	$nKKMmth=$dKKMmth[kkm];
	
	$qMTH ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='MTH'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rMTH=mysql_query($qMTH) or die('Query gagal');
	$dMTH =mysql_fetch_array($rMTH);
	
	$qSTK=$dMTH['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dMTH['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'5'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'Compulsory Mathematics'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,$nKKMmth		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//hist
	$qKKMhist 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='HIST' "; // menghasilka kkm per kelas per subjek
	$rKKMhist =mysql_query($qKKMhist) or die('Query gagal');
	$dKKMhist =mysql_fetch_array($rKKMhist);
	$nKKMhist=$dKKMhist[kkm];
	
	$qHIST ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='HIST'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rHIST=mysql_query($qHIST) or die('Query gagal');
	$dHIST =mysql_fetch_array($rHIST);
	
	$qSTK=$dHIST['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dHIST['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'6'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'History'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,'71'		,'LRTB',0,C,true);//$nKKMhist
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFillColor(245, 222, 179);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.6	,0.4,''			,'LTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'SCIENCES'		,'TB',0,L,true);
	$pdf->Cell( 2	,0.4,''		,'TB',0,C,true);
	$pdf->Cell( 5	,0.4,''		,'RTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//phy
	$qKKMphy 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='PHY' "; // menghasilka kkm per kelas per subjek
	$rKKMphy =mysql_query($qKKMphy) or die('Query gagal');
	$dKKMphy =mysql_fetch_array($rKKMphy);
	$nKKMphy=$dKKMphy[kkm];
	
	$qPHY ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='PHY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rPHY=mysql_query($qPHY) or die('Query gagal');
	$dPHY =mysql_fetch_array($rPHY);
	
	$qSTK=$dPHY['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dPHY['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'7'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'Physics'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,$nKKMphy		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//blgy
	$qKKMblgy 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='BLGY' "; // menghasilka kkm per kelas per subjek
	$rKKMblgy =mysql_query($qKKMblgy) or die('Query gagal');
	$dKKMblgy =mysql_fetch_array($rKKMblgy);
	$nKKMblgy=$dKKMblgy[kkm];
	
	$qBLGY ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='BLGY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rBLGY=mysql_query($qBLGY) or die('Query gagal');
	$dBLGY =mysql_fetch_array($rBLGY);
	
	$qSTK=$dBLGY['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dBLGY['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'8'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'Biology'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,$nKKMblgy		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//chm
	$qKKMchm 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='CHM' "; // menghasilka kkm per kelas per subjek
	$rKKMchm =mysql_query($qKKMchm) or die('Query gagal');
	$dKKMchm =mysql_fetch_array($rKKMchm);
	$nKKMchm=$dKKMchm[kkm];
	
	$qCHM ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='CHM'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rCHM=mysql_query($qCHM) or die('Query gagal');
	$dCHM =mysql_fetch_array($rCHM);
	
	$qSTK=$dCHM['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dCHM['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'9'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'Chemistry'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,$nKKMchm		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//smth
	$qSMTH ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='SMTH'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rSMTH=mysql_query($qSMTH) or die('Query gagal');
	$dSMTH =mysql_fetch_array($rSMTH);
	
	$qSTK=$dSMTH['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dSMTH['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'10'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'Supplementary Mathematics'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,'70'		,'LRTB',0,C,true);//$nKKMsmth
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFillColor(245, 222, 179);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.6	,0.4,''			,'LTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'REQUIRED'		,'TB',0,L,true);
	$pdf->Cell( 2	,0.4,''		,'TB',0,C,true);
	$pdf->Cell( 5	,0.4,''		,'RTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//artm
	$qKKMartm 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='ARTM' "; // menghasilka kkm per kelas per subjek
	$rKKMartm =mysql_query($qKKMartm) or die('Query gagal');
	$dKKMartm =mysql_fetch_array($rKKMartm);
	$nKKMartm=$dKKMartm[kkm];
	
	$qARTM ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='ARTM'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rARTM=mysql_query($qARTM) or die('Query gagal');
	$dARTM =mysql_fetch_array($rARTM);
	
	$qSTK=$dARTM['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dARTM['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'11'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'Cultural Art (Music/Art)'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,$nKKMartm		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//pe
	$qKKMpe 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='PE' "; // menghasilka kkm per kelas per subjek
	$rKKMpe =mysql_query($qKKMpe) or die('Query gagal');
	$dKKMpe =mysql_fetch_array($rKKMpe);
	$nKKMpe=$dKKMpe[kkm];
	
	$qPE ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='PE'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rPE=mysql_query($qPE) or die('Query gagal');
	$dPE =mysql_fetch_array($rPE);
	
	$qSTK=$dPE['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dPE['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'12'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'Physical Education and Health'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,$nKKMpe		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//ict
	$qKKMict 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='ICT' "; // menghasilka kkm per kelas per subjek
	$rKKMict =mysql_query($qKKMict) or die('Query gagal');
	$dKKMict =mysql_fetch_array($rKKMict);
	$nKKMict=$dKKMict[kkm];
	
	$qICT ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='ICT'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rICT=mysql_query($qICT) or die('Query gagal');
	$dICT =mysql_fetch_array($rICT);
	
	$qSTK=$dICT['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dICT['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'13'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'Technology and Livelihood Education'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,$nKKMict		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFillColor(245, 222, 179);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.6	,0.4,''			,'LTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'ELECTIVES'		,'TB',0,L,true);
	$pdf->Cell( 2	,0.4,''		,'TB',0,C,true);
	$pdf->Cell( 5	,0.4,''		,'RTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//engl
	$qENGL ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='$nis'		AND
							t_prgrptps_sma_k13.kdeplj='ENGL'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rENGL=mysql_query($qENGL) or die('Query gagal');
	$dENGL =mysql_fetch_array($rENGL);
	
	$qSTK=$dENGL['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dENGL['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
		
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'14'			,'LRTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'English Literature'		,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.4,'70'		,'LRTB',0,C,true);//$nKKMengl
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//for
	$qKKMfor 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='FOR' "; // menghasilka kkm per kelas per subjek
	$rKKMfor =mysql_query($qKKMfor) or die('Query gagal');
	$dKKMfor =mysql_fetch_array($rKKMfor);
	$nKKMfor=$dKKMfor[kkm];
	
	$strFOR='';
	//$qFOR='';
	//$rFOR='';
	
	$qFOR ="	SELECT 		t_prgrptps_sma_k13.*
				FROM 		t_prgrptps_sma_k13
				WHERE		t_prgrptps_sma_k13.nis='". mysql_escape_string($nis)."'		AND
							t_prgrptps_sma_k13.kdeplj='GRM'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rFOR=mysql_query($qFOR) or die('Query gagal');//german
	
	if(mysql_num_rows($rFOR)=='0')
	{
		$strFOR='Mandarin';
		
		$qFOR ="	SELECT 		t_prgrptps_sma_k13.*
					FROM 		t_prgrptps_sma_k13
					WHERE		t_prgrptps_sma_k13.nis='". mysql_escape_string($nis)."'		AND
								t_prgrptps_sma_k13.kdeplj='MND'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
		$rFOR=mysql_query($qFOR) or die('Query gagal');//mandarin
	}
	else
		$strFOR='German';
	
	$dFOR =mysql_fetch_array($rFOR);
	
	$qSTK=$dFOR['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dFOR['qg_k14_'.$sms.$midtrm]; // q
	$qK = $qSTK;
	$qS = $qSTS;
	
	if($qK>100)
		$lgK = 'ERR';
	else if($qK>=90)
		$lgK = 'A';
	else if($qK>=80)
		$lgK = 'B';
	else if($qK>=70)
		$lgK = 'C';
	else if($qK>=0)
		$lgK = 'D';
	else //if($qK==0)
		$lgK = "ERR";
	
	if($qS>100)
		$lgS = 'ERR';
	else if($qS>=90)
		$lgS = 'A';
	else if($qS>=80)
		$lgS = 'B';
	else if($qS>=70)
		$lgS = 'C';
	else if($qS>=0)
		$lgS = 'D';
	else //if($qS==0)
		$lgS = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'15'			,'LRTB',0,C,true);
	$pdf->Cell( 5.35	,0.4,'Foreign Language'		,'LRTB',0,L,true);
	$pdf->Cell( 1.85	,0.4,$strFOR		,'LRTB',0,C,true);
	$pdf->Cell( 2	,0.4,$nKKMfor		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$qK		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1	,0.4,$qS		,'LRTB',0,C,true);
	$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.4,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	$pdf->Ln();
	
	
	
	//absen
	$pdf->Ln(0.35);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 7.95	,0.4,'ATTENDANCE',LRTB,0,C,true);
	
	//absences
	$qABS	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$nis' "; // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	
	$q1SKT=$dABS['skt'.$sms.$midtrm]; // q1 skt
	$q1IZN=$dABS['izn'.$sms.$midtrm]; // q1 izn
	$q1ALP=$dABS['alp'.$sms.$midtrm]; // q1 alp
	
	if($q1SKT==0)
		$q1SKT='0';
	if($q1IZN==0)
		$q1IZN='0';
	if($q1ALP==0)
		$q1ALP='0';
	
	
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1','LRTB',0,C);
	$pdf->Cell( 5.35,0.4,'ABSENCE DUE TO SICKNESS','LRTB',0,L,true);
	$pdf->Cell( 0.25,0.4,' : ','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,'   '.$q1SKT.'   ','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1	,0.4,' day/s  ','LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,0.4,'2','LRTB',0,C);
	$pdf->Cell( 5.35,0.4,'EXCUSED ABSENCE','LRTB',0,L,true);
	$pdf->Cell( 0.25,0.4,' : ','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,'   '.$q1IZN.'   ','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1	,0.4,' day/s  ','LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,0.4,'3','LRTB',0,C);
	$pdf->Cell( 5.35,0.4,'UNEXCUSED ABSENCE','LRTB',0,L,true);
	$pdf->Cell( 0.25,0.4,' : ','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,'   '.$q1ALP.'   ','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1	,0.4,' day/s  ','LRTB',0,C,true);
	
	//..
	
	//ekskul
	$pdf->Ln(0.85);
	$pdf->Cell( 1.5	,0.5,'',0,0,L);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 14.8,0.5,'EXTRA-CURRICULAR ACTIVITY PERFORMANCE','LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 5.8	,0.4,'ACTIVITY','LRTB',0,C,true);
	$pdf->Cell( 9	,0.4,'REMARKS','LRTB',0,C,true);
	
	
	
	$nmaPil1='SCOUTING';
	$ktrPil1='Sometimes present in the activities and exhibits helpfulness and cooperation';
	
	$nmaPil2='';
	$ktrPil2='';
	
	$nmaPil3='';
	$ktrPil3='';
	
	//basketball
	/*$qBSK	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='BSK' "; // extra kurikuler
	$rBSK=mysql_query($qBSK) or die('Query gagal40');
	$dBSK =mysql_fetch_array($rBSK);
	$q1BSK=$dBSK['ktr'.$sms.$midtrm]; // q1 BSK
	if($q1BSK!='')
	{
		$nmaPil2='BASKET BALL';
		$ktrPil2=$q1BSK;
	}*/
	//futsal
	$qFTS	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='FTS' "; // extra kurikuler
	$rFTS=mysql_query($qFTS) or die('Query gagal40');
	$dFTS =mysql_fetch_array($rFTS);
	$q1FTS=$dFTS['ktr'.$sms.$midtrm]; // q1 FTS
	if($q1FTS!='')
	{
		$nmaPil2='Futsal';
		$ktrPil2=$q1FTS;
	}
	//table tennis
	$qTNS	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='TNS' "; // extra kurikuler
	$rTNS=mysql_query($qTNS) or die('Query gagal40');
	$dTNS =mysql_fetch_array($rTNS);
	$q1TNS=$dTNS['ktr'.$sms.$midtrm]; // q1 TNS
	if($q1TNS!='')
	{
		$nmaPil2='Table Tennis';
		$ktrPil2=$q1TNS;
	}
	
	//culinary
	/*$qCLN	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='CLN' "; // extra kurikuler
	$rCLN=mysql_query($qCLN) or die('Query gagal40');
	$dCLN =mysql_fetch_array($rCLN);
	$q1CLN=$dCLN['ktr'.$sms.$midtrm]; // q1 CLN
	if($q1CLN!='')
	{
		$nmaPil3='CULINARY ART';
		$ktrPil3=$q1CLN;
	}*/
	//modern dance
	/*$qMDR	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='MDR' "; // extra kurikuler
	$rMDR=mysql_query($qMDR) or die('Query gagal40');
	$dMDR =mysql_fetch_array($rMDR);
	$q1MDR=$dMDR['ktr'.$sms.$midtrm]; // q1 MDR
	if($q1MDR!='')
	{
		$nmaPil3='MODERN DANCE';
		$ktrPil3=$q1MDR;
	}*/
	//theatre art
	$qTHE	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='THE' "; // extra kurikuler
	$rTHE=mysql_query($qTHE) or die('Query gagal40');
	$dTHE =mysql_fetch_array($rTHE);
	$q1THE=$dTHE['ktr'.$sms.$midtrm]; // q1 THE
	if($q1THE!='')
	{
		$nmaPil2='Theatre';//THEATRE ART
		$ktrPil2=$q1THE;
		
		$nmaPil3='Theatre';//THEATRE ART
		$ktrPil3=$q1THE;
	}
	//Interest(Science & Math Club/English Club)
	/*$qCLB	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='CLB' "; // extra kurikuler
	$rCLB=mysql_query($qCLB) or die('Query gagal40');
	$dCLB =mysql_fetch_array($rCLB);
	$q1CLB=$dCLB['ktr'.$sms.$midtrm]; // q1 CLB
	if($q1CLB!='')
	{
		$nmaPil3='INTEREST(SCIENCE & MATH CLUB/ENGLISH CLUB)';
		$ktrPil3=$q1CLB;
	}*/
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,1,'1','LRTB',0,C,true);
	$pdf->Cell( 5.2	,1,$nmaPil1,'LRTB',0,C,true);
	$pdf->Cell( 9	,0.5,substr($ktrPil1,0,64),'LRT',0,J,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1,'',0,0,C,false);
	$pdf->Cell( 5.2	,1,'',0,0,C,false);
	$pdf->Cell( 9	,0.5,substr($ktrPil1,64,64),'LRB',0,J,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1,'2','LRTB',0,C,true);
	$pdf->Cell( 5.2	,1,$nmaPil2,'LRTB',0,C,true);
	$pdf->Cell( 9	,0.5,substr($ktrPil2,0,64),'LRT',0,J);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1.5,'',0,0,C,false);
	$pdf->Cell( 5.2	,1.5,'',0,0,C,false);
	$pdf->Cell( 9	,0.5,substr($ktrPil2,64,64),'LRB',0,J);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1,'3','LRTB',0,C,true);
	$pdf->Cell( 5.2	,1,$nmaPil3,'LRTB',0,C,true);
	$pdf->Cell( 9	,0.5,substr($ktrPil3,0,64),'LRT',0,J);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1.5,'',0,0,C,false);
	$pdf->Cell( 5.2	,1.5,'',0,0,C,false);
	$pdf->Cell( 9	,0.5,substr($ktrPil3,64,64),'LRB',0,J);
	
	//..
	
	//$pdf->Ln();
	$pdf->Ln(0.85);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.4,'',0,0,C,false);
	$pdf->Cell( 1.6	,0.4,'Place/Date:',0,0,L);
	$pdf->Cell( 1.3	,0.4,'',0,0,L);
	$pdf->Cell( 6 ,0.4,'Jakarta, '.$tglctk,0,0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 5.35,0.4,'',0,0,C,false);
	$pdf->Cell( 0.25,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 5.35,0.4,'',0,0,C,false);
	$pdf->Cell( 0.25,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->Cell( 1.6,0.4,'',0,0,L);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 5.35,0.4,'',0,0,C,false);
	$pdf->Cell( 0.25,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 0.25,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','',8);
	//$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->Cell( 1.6	,0.4,'Issued by:',0,0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 6	,0.4,'  '.'  ',0,0,C,true);
	$pdf->Image($signature, 13, 24, 4.577234, 2.143098);
	
	//..
	
	$pdf->Ln(2);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',8);
	$pdf->Cell( 3	,0.4,'                     '.'                    ',0,0,C,true);
	$pdf->Cell( 2.7,0.4,'',0,0,L);
	$pdf->Cell( 3	,0.4,'  '.$wlikls.$gelar.'  ',0,0,C,true);
	$pdf->Cell( 2.7,0.4,'',0,0,L);
	$pdf->Cell( 3	,0.4,'  '.'Ir. '.$kplskl.', MBA'.'  ',0,0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 3	,0.4,"Parent's Signature",0,0,C,true);
	$pdf->Cell( 2.7,0.4,'',0,0,L);
	$pdf->Cell( 3	,0.4,'Homeroom Adviser',0,0,C,true);
	$pdf->Cell( 2.7,0.4,'',0,0,L);
	$pdf->Cell( 3	,0.4,'Principal',0,0,C,true);
	
	
	
	
	$y++;
	
}//cetak all

$pdf->Output();

?>