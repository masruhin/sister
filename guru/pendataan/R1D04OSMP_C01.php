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

$thn_ajr	=$_POST['thn_ajr'];

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
$query	="	SELECT 		t_setthn_smp.*
			FROM 		t_setthn_smp
			WHERE		t_setthn_smp.set='Tahun Ajaran'"; // menghasilka tahun ajaran
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_smp_k13.*
			FROM 		t_mstbbt_smp_k13
			WHERE		t_mstbbt_smp_k13.kdebbt='1HW'"; // menghasilka bobot 1
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp_k13.*
			FROM 		t_mstbbt_smp_k13
			WHERE		t_mstbbt_smp_k13.kdebbt='2PRJ'"; // menghasilka bobot 2
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp_k13.*
			FROM 		t_mstbbt_smp_k13
			WHERE		t_mstbbt_smp_k13.kdebbt='3TES'"; // menghasilka bobot 3
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp_k13.*
			FROM 		t_mstbbt_smp_k13
			WHERE		t_mstbbt_smp_k13.kdebbt='4MID'"; // menghasilkan bobot 4
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtmidtes=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp_k13.*
			FROM 		t_mstbbt_smp_k13
			WHERE		t_mstbbt_smp_k13.kdebbt='5AE'"; // menghasilkan bobot 5
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtae=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp_k13.*
			FROM 		t_mstbbt_smp_k13
			WHERE		t_mstbbt_smp_k13.kdebbt='6AF'"; // menghasilkan bobot 6
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtaf=$data[bbt];

$query	="	SELECT 		t_mstbbt_smp_k13.*
			FROM 		t_mstbbt_smp_k13
			WHERE		t_mstbbt_smp_k13.kdebbt='7AG'"; // menghasilkan bobot 7
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtae=$data[bbt];

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
$pdf->SetMargins(0,0.4,1);//0.8
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
								t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."' AND 
								t_mstssw.str='' 
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
		$query3 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp_k13.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_smp_k13.nis,t_prgrptps_smp_k13.kdeplj"; // menghasilka satu siswa per subjek (nilai akhir q1/q2/q3/q4)
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
						t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."' AND 
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
	
		$query2 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp_k13.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_smp_k13.nis,t_prgrptps_smp_k13.kdeplj"; // menghasilka satu siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	$tgllhr	=date('d F, Y',$tgllhr);//F d
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
			$query2 ="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
									t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
									t_prgrptps_smp_k13.kdeplj='$kdeplj'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	$pdf->Ln(2.75);
	$pdf->SetFont('arial','BU',13);
	$pdf->Cell(20.5	,0.5, "JUNIOR HIGH SCHOOL",0,0,C); // 19 $judul
	$pdf->SetFont('Arial','B',15);
	$pdf->Ln(0.65);
	
	$pdf->Cell(20.5	,0.5, "STUDENT'S PROGRESS REPORT",0,0,C); // 19 $judul2 .substr($kdekls,-2)
	$pdf->Ln();
	
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(20.5	,0.5, "ACADEMIC YEAR ".$thnajr,0,0,C);// 19 ." - SAINT JOHN'S SCHOOL"
	/*$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat2_pt2*/
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 2.5	,0.5,"Semester",0,0,L); 
	$pdf->Cell( 0.5	,0.5,"   :",0,0,C); 
	$pdf->Cell( 5.7	,0.5,$sms,0,0,L); //1.5
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 1.5	,0.5,"Term",0,0,L); 
	$pdf->Cell( 0.5	,0.5," :",0,0,C); 
	$pdf->Cell( 1.5	,0.5,$midtrm,0,0,L); //".$sms."=2
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 2.5	,0.5,"Student Name",0,0,L); 
	$pdf->Cell( 0.5	,0.5,"   :",0,0,C); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 5.7	,0.5,$nmassw,0,0,L); //."                         "
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 2.5	,0.5,"Student ID No",0,0,L); 
	$pdf->Cell( 0.5	,0.5,"   :",0,0,C); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 5.7	,0.5,substr($nis,0,3),0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 1.5	,0.5,"Birthday",0,0,L); 
	$pdf->Cell( 0.5	,0.5," :",0,0,C); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 2	,0.5,$tmplhr.", ".$tgllhr,0,0,L); 
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 0.5	,0.5,"A.",0,0,L); 
	$pdf->Cell( 2.5	,0.5,"Attitude",0,0,L); 
	
	//1
	//spiritual behaviour
	$qPER	="	SELECT 		t_personps.*
				FROM 		t_personps
				WHERE		t_personps.nis='$nis' AND 
							t_personps.thn_ajaran='$thn_ajr' "; // menghasilka nilai kepribadian
	$rPER=mysql_query($qPER) or die('Query gagal40');
	$dPER =mysql_fetch_array($rPER);
	
	$q1SPR=$dPER['spr'.$sms.$midtrm]; // q1 spr
	$q1SOC=$dPER['soc'.$sms.$midtrm]; // q1 soc
	
	$desSPR='';
	$desSOC='';
	
	if($q1SPR=='A')
		$desSPR='Has shown a very good understanding of the scipture relating it to his/her life      experiences. Demonstrates a very good retention of bibilical terms and characters,   church practices and doctrines. ';
	else if($q1SPR=='B')
		$desSPR='Has shown a good understanding of the scipture relating it to his/her life experiences. Demonstrates a good retention of bibilical terms and characters, church practices and doctrines. ';
	else if($q1SPR=='C')
		$desSPR='Has shown an average understanding of the scipture relating it to his/her life experiences. Demonstrates an average retention of bibilical terms and characters, church practices and doctrines. ';
	else if($q1SPR=='D')
		$desSPR='-';
	else //if($q1SPR=='E')
		$desSPR='-';
	
	if($q1SOC=='A')
		$desSOC='Has formulated a very good and sound principle for him/herself to become worthy      individual and citizen in accordance to the principles of Pancasila. Has a very good understanding of what is right and good for himself and others, environment,         country and the world.';
	else if($q1SOC=='B')
		$desSOC='Has formulated a good and sound principle for him/herself to become worthy           individual and citizen in accordance to the principles of Pancasila. Has a good      understanding of what is right and good for himself and others, environment,         country and the world.';
	else if($q1SOC=='C')
		$desSOC='Has a moderate principle for him/herself to become worthy individual and citizen in accordance to the principles of Pancasila. Has an average understanding of what is right and good for himself and others, environment, country and the world.';
	else if($q1SOC=='D')
		$desSOC='-';
	else //if($q1SOC=='E')
		$desSOC='-';
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 0.5	,0.5,"",0,0,L); 
	$pdf->Cell( 2.5	,0.5,"1   Spiritual Behavior",0,0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,1.0,"",0,0,L); 
	$pdf->Cell( 3.5	,1.0,"LETTER GRADE",'LRTB',0,C); 
	$pdf->Cell( 14.5	,1.0,"DESCRIPTION",'LRTB',0,C); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 3.5	,0.5,"",'LR',0,C); 
	$pdf->Cell( 14.5	,0.5,substr($desSPR,0,85),'LR',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 3.5	,0.5,$q1SPR,'LR',0,C); 
	$pdf->Cell( 14.5	,0.5,substr($desSPR,85,85),'LR',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 3.5	,0.5,"",'LRB',0,C); 
	$pdf->Cell( 14.5	,0.5,substr($desSPR,170,85),'LRB',0,L);
	
	//2
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 0.5	,0.5,"",0,0,L); 
	$pdf->Cell( 2.5	,0.5,"2   Social Behavior",0,0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,1.0,"",0,0,L); 
	$pdf->Cell( 3.5	,1.0,"LETTER GRADE",'LRTB',0,C); 
	$pdf->Cell( 14.5	,1.0,"DESCRIPTION",'LRTB',0,C); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 3.5	,0.5,"",'LR',0,C); 
	$pdf->Cell( 14.5	,0.5,substr($desSOC,0,85),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 3.5	,1.0,$q1SOC,'LR',0,C); 
	$pdf->Cell( 14.5	,0.5,substr($desSOC,85,85),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 3.5	,0.5,"",'LR',0,C,false); 
	$pdf->Cell( 14.5	,0.5,substr($desSOC,170,85),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 3.5	,0.5,"",'LRB',0,C); 
	$pdf->Cell( 14.5	,0.5,substr($desSOC,255,85),'LRB',0,L); 
	
	//3
	//absences
	$qABS	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$nis' AND 
							t_hdrkmnps.thn_ajaran='$thn_ajr' "; // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	
	//$q1SKT=$dABS['skt'."1"."1"]; // q1 skt
	//$q1IZN=$dABS['izn'."1"."1"]; // q1 izn
	//$q1ALP=$dABS['alp'."1"."1"]; // q1 alp
	//$q1KMN=$dABS['kmn'."1"."1"]; // q1 kmn
	$qKMN=$dABS['kmn'.$sms.$midtrm]; // q kmn
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 0.5	,0.5,"",0,0,L); 
	$pdf->Cell( 2.5	,0.5,"3   Comment",0,0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 18,0.5,substr($qKMN,0,105),'LRT',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 18,0.5,substr($qKMN,105,105),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 18,0.5,substr($qKMN,210,105),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 18,0.5,substr($qKMN,315,105),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 18,0.5,substr($qKMN,420,105),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 18,0.5,substr($qKMN,525,105),'LR',0,L);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 18,0.5,substr($qKMN,630,105),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 18,0.5,substr($qKMN,735,105),'LRB',0,L); 
	
	
	
	
	
	
	
	
	
	
	
	//$pdf->Ln(1);
	$pdf->Ln(0.85);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 2.5	,0.5,'',0,0,L);
	$pdf->Cell( 7.1	,0.5,'',0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	$pdf->Cell( 1.6	,0.5,'Place/Date:',0,0,L);
	$pdf->Cell( 1.3	,0.5,'',0,0,L);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	$pdf->Cell( 6 ,0.5,'Jakarta, '.$tglctk,0,0,C,true);
	
	/*$pdf->Ln();
	$pdf->Cell( 2.5	,0.5,'',0,0,L);
	$pdf->Cell( 5.35,0.5,'',0,0,C,false);
	$pdf->Cell( 0.25,0.5,'',0,0,C,false);
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell( 0.75,0.5,'',0,0,C,false);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.75,0.5,'',0,0,C,false);*/
	
	/*$pdf->Ln();
	$pdf->Cell( 2.5	,0.5,'',0,0,L);
	$pdf->Cell( 5.35,0.5,'',0,0,C,false);
	$pdf->Cell( 0.25,0.5,'',0,0,C,false);
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell( 0.75,0.5,'',0,0,C,false);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.75,0.5,'',0,0,C,false);
	$pdf->Cell( 1.6,0.5,'',0,0,L);*/
	
	$pdf->Ln();
	$pdf->Cell( 2.5	,0.5,'',0,0,L);
	$pdf->Cell( 5.35,0.5,'',0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	//$pdf->Cell( 0.25,0.5,'',0,0,C,false);
	//$pdf->SetFont('Arial','U',12);
	//$pdf->Cell( 0.25,0.5,'',0,0,C,false);
	//$pdf->SetFont('Arial','',12);
	//$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->Cell( 2	,0.5,'Issued by:',0,0,L);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 6	,0.5,'  '.'  ',0,0,C,true);
	//$pdf->Image($signature, 14, 20.3, 4.577234, 2.143098);
	
	//..
	
	$pdf->Ln(2);
	$pdf->Cell( 2.5	,0.5,'',0,0,L);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell( 3	,0.5,'                     '.'                    ',0,0,C,true);
	$pdf->Cell( 2.7,0.5,'',0,0,L);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	$pdf->Cell( 3	,0.5,'  '.$wlikls.$gelar.'  ',0,0,C,true);
	$pdf->Cell( 2.7,0.5,'',0,0,L);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	$pdf->Cell( 3	,0.5,'  '.'Ir. '.$kplskl.', MBA'.'  ',0,0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 2.5	,0.5,'',0,0,L);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 3	,0.5,"Parent's Signature",0,0,C,true);
	$pdf->Cell( 2.7,0.5,'',0,0,L);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	$pdf->Cell( 3	,0.5,'Homeroom Adviser',0,0,C,true);
	$pdf->Cell( 2.7,0.5,'',0,0,L);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	$pdf->Cell( 3	,0.5,'Principal',0,0,C,true);
	
	
	
	//..sampai sini
	//awal halaman 2
	
	
	
	$pdf->Open();
	$pdf->AddPage();
	//$pdf->Image($logo_pt ,1,0.75,2,2);
	//$pdf->Image($logo_ttw,18,1,2,2);
	$pdf->Ln(2.75);
	$pdf->SetFont('arial','BU',13);
	$pdf->Cell(20.5	,0.5, "JUNIOR HIGH SCHOOL",0,0,C); // 19 $judul
	$pdf->SetFont('Arial','B',15);
	$pdf->Ln(0.65);
	
	$pdf->Cell(20.5	,0.5, "STUDENT'S PROGRESS REPORT",0,0,C); // 19 $judul2 .substr($kdekls,-2)
	$pdf->Ln();
	
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(20.5	,0.5, "ACADEMIC YEAR ".$thnajr,0,0,C);// 19 ." - SAINT JOHN'S SCHOOL"
	/*$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat2_pt2*/
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 2.5	,0.5,"Semester",0,0,L); 
	$pdf->Cell( 0.5	,0.5,"   :",0,0,C); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 5.7	,0.5,$sms,0,0,L); //1.5
	$pdf->Cell( 0.5	,0.5,"",0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L);
	$pdf->Cell( 1.5	,0.5,"Term",0,0,L); 
	$pdf->Cell( 0.5	,0.5," :",0,0,C); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,$midtrm,0,0,L); //".$sms."=2
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 2.5	,0.5,"Student Name",0,0,L); 
	$pdf->Cell( 0.5	,0.5,"   :",0,0,C); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 5.7	,0.5,$nmassw,0,0,L); //."                         "
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.5	,0.5,"",0,0,L); 
	$pdf->Cell( 2.5	,0.5,"Student ID No",0,0,L); 
	$pdf->Cell( 0.5	,0.5,"   :",0,0,C); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 5.7	,0.5,substr($nis,0,3),0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.5	,0.5,"",0,0,L); 
	$pdf->Cell( 1.5	,0.5,"",0,0,L);
	$pdf->Cell( 1.5	,0.5,"Birthday",0,0,L); 
	$pdf->Cell( 0.5	,0.5," :",0,0,C); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 2	,0.5,$tmplhr.", ".$tgllhr,0,0,L); 
	
	//..sampai sini
	
	$pdf->Ln(0.75);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->Cell( 0.6	,1.5,'No'			,'LRTB',0,C,true);
	$pdf->Cell( 7.7	,1.5,'SUBJECT'		,'LRTB',0,C,true);//6.7
	$pdf->Cell( 2.5	,0.5,'Minimum'		,'LRT',0,C,true);
	$pdf->Cell( 7	,0.5,'CLASSROOM PERFORMANCE'		,'LRTB',0,C,true);//
	
	$pdf->Ln(0.5);
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->Cell( 8.3	,1.5,''		,0,0,C,false);//7.3
	$pdf->Cell( 2.5	,0.5,'Passing'		,'LR',0,C,true);
	$pdf->Cell( 3.5	,0.5,'KNOWLEDGE'		,'LRTB',0,C,true);//
	$pdf->Cell( 3.5	,0.5,'SKILLS'		,'LRTB',0,C,true);//
	
	$pdf->Ln(0.5);
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->Cell( 8.3	,1.5,''		,0,0,C,false);//7.3
	$pdf->Cell( 2.5	,0.5,'Score'		,'LRB',0,C,true);
	$pdf->Cell( 1.5	,0.5,'SC'		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,'LG'		,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1.5	,0.5,'SC'		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,'LG'		,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,235);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFillColor(245, 222, 179);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 0.6	,0.5,''			,'LTB',0,C,true);
	$pdf->Cell( 7.7	,0.5,'CORE SUBJECTS'		,'TB',0,L,true);
	$pdf->Cell( 2.5	,0.5,''		,'TB',0,C,true);
	$pdf->Cell( 7	,0.5,''		,'RTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//rlg
	$qKKMrlg 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='RLG' "; // menghasilka kkm per kelas per subjek
	$rKKMrlg =mysql_query($qKKMrlg) or die('Query gagal');
	$dKKMrlg =mysql_fetch_array($rKKMrlg);
	$nKKMrlg=$dKKMrlg[kkm];
	
	$qRLG ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='RLG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'1'			,'LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.5,'Religion and Character Education'		,'LRTB',0,L,true);
	$pdf->Cell( 2.5	,0.5,$nKKMrlg		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.5,$qK		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qS		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//cme
	$qKKMcme 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='CME' "; // menghasilka kkm per kelas per subjek
	$rKKMcme =mysql_query($qKKMcme) or die('Query gagal');
	$dKKMcme =mysql_fetch_array($rKKMcme);
	$nKKMcme=$dKKMcme[kkm];
	
	$qCME ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='CME'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'2'			,'LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.5,'Pancasila and Civics Education'		,'LRTB',0,L,true);
	$pdf->Cell( 2.5	,0.5,$nKKMcme		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.5,$qK		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qS		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//bin
	$qKKMbin 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='BIN' "; // menghasilka kkm per kelas per subjek
	$rKKMbin =mysql_query($qKKMbin) or die('Query gagal');
	$dKKMbin =mysql_fetch_array($rKKMbin);
	$nKKMbin=$dKKMbin[kkm];
	
	$qBIN ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='BIN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'3'			,'LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.5,'Bahasa Indonesia'		,'LRTB',0,L,true);
	$pdf->Cell( 2.5	,0.5,$nKKMbin		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.5,$qK		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qS		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	//..sampai ini
	
	//eng
	$qKKMeng 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='ENG' "; // menghasilka kkm per kelas per subjek
	$rKKMeng =mysql_query($qKKMeng) or die('Query gagal');
	$dKKMeng =mysql_fetch_array($rKKMeng);
	$nKKMeng=$dKKMeng[kkm];
	
	$qENG ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='ENG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'4'			,'LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.5,'English'		,'LRTB',0,L,true);
	$pdf->Cell( 2.5	,0.5,$nKKMeng		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.5,$qK		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qS		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//mth
	$qKKMmth 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='MTH' "; // menghasilka kkm per kelas per subjek
	$rKKMmth =mysql_query($qKKMmth) or die('Query gagal');
	$dKKMmth =mysql_fetch_array($rKKMmth);
	$nKKMmth=$dKKMmth[kkm];
	
	$qMTH ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='MTH'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'5'			,'LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.5,'Mathematics'		,'LRTB',0,L,true);
	$pdf->Cell( 2.5	,0.5,$nKKMmth		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.5,$qK		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qS		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	
	
	//ipa
	
	//blgy
	$qKKMblgy 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='BLGY' "; // menghasilka kkm per kelas per subjek
	$rKKMblgy =mysql_query($qKKMblgy) or die('Query gagal');
	$dKKMblgy =mysql_fetch_array($rKKMblgy);
	$nKKMblgy=$dKKMblgy[kkm];
	
	$qBLGY ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='BLGY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rBLGY=mysql_query($qBLGY) or die('Query gagal');
	$dBLGY =mysql_fetch_array($rBLGY);
	
	$qSTK=$dBLGY['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dBLGY['qg_k14_'.$sms.$midtrm]; // q
	$qKblgy = $qSTK;
	$qSblgy = $qSTS;
		
	if($qKblgy>100)
		$lgK = 'ERR';
	else if($qKblgy>=90)
		$lgK = 'A';
	else if($qKblgy>=80)
		$lgK = 'B';
	else if($qKblgy>=70)
		$lgK = 'C';
	else if($qKblgy>=0)
		$lgK = 'D';
	else //if($qKblgy==0)
		$lgK = "ERR";
	
	if($qSblgy>100)
		$lgS = 'ERR';
	else if($qSblgy>=90)
		$lgS = 'A';
	else if($qSblgy>=80)
		$lgS = 'B';
	else if($qSblgy>=70)
		$lgS = 'C';
	else if($qSblgy>=0)
		$lgS = 'D';
	else //if($qSblgy==0)
		$lgS = "ERR";
		
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'6'			,'LRTB',0,C,true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 2.7	,0.5,'Natural'		,'LRT',0,C,true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 5	,0.5,'Biology'		,'LRTB',0,L,true);//Geography & History
	$pdf->Cell( 2.5	,0.5,$nKKMblgy		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.5,$qKblgy		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qSblgy		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	//phy - chm
	//phy
	$qKKMphy 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='PHY' "; // menghasilka kkm per kelas per subjek
	$rKKMphy =mysql_query($qKKMphy) or die('Query gagal');
	$dKKMphy =mysql_fetch_array($rKKMphy);
	$nKKMphy=$dKKMphy[kkm];
	
	$qPHY ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='PHY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rPHY=mysql_query($qPHY) or die('Query gagal');
	$dPHY =mysql_fetch_array($rPHY);
	
	$qSTK=$dPHY['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dPHY['qg_k14_'.$sms.$midtrm]; // q
	$qKphy = $qSTK;
	$qSphy = $qSTS;
		
	if($qKphy>100)
		$lgK = 'ERR';
	else if($qKphy>=90)
		$lgK = 'A';
	else if($qKphy>=80)
		$lgK = 'B';
	else if($qKphy>=70)
		$lgK = 'C';
	else if($qKphy>=0)
		$lgK = 'D';
	else //if($qKphy==0)
		$lgK = "ERR";
	
	if($qSphy>100)
		$lgS = 'ERR';
	else if($qSphy>=90)
		$lgS = 'A';
	else if($qSphy>=80)
		$lgS = 'B';
	else if($qSphy>=70)
		$lgS = 'C';
	else if($qSphy>=0)
		$lgS = 'D';
	else //if($qSphy==0)
		$lgS = "ERR";
	
	
		
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 2.7	,0.5,'Science'		,'LR',0,C,true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 5	,0.5,'Physics & Chemistry'		,'LRTB',0,L,true);
	$pdf->Cell( 2.5	,0.5,$nKKMphy		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.5,$qKphy		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qSphy		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	$qKipa = number_format( ($qKblgy+$qKphy)/2 ,0,',','.' );
	$qSipa = number_format( ($qSblgy+$qSphy)/2 ,0,',','.' );
	
	if($qKipa>100)
		$lgKipa = 'ERR';
	else if($qKipa>=90)
		$lgKipa = 'A';
	else if($qKipa>=80)
		$lgKipa = 'B';
	else if($qKipa>=70)
		$lgKipa = 'C';
	else if($qKipa>=0)
		$lgKipa = 'D';
	else //if($qKipa==0)
		$lgKipa = "ERR";
	
	if($qSipa>100)
		$lgSipa = 'ERR';
	else if($qSipa>=90)
		$lgSipa = 'A';
	else if($qSipa>=80)
		$lgSipa = 'B';
	else if($qSipa>=70)
		$lgSipa = 'C';
	else if($qSipa>=0)
		$lgSipa = 'D';
	else //if($qSipa==0)
		$lgSipa = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,''			,'LRB',0,C,true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 2.7	,0.5,'(IPA)'		,'LR',0,C,true);
	$pdf->SetFont('Arial','BI',11);
	$pdf->Cell( 5	,0.5,'Average'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 2.5	,0.5,'70'		,'LRTB',0,C,true);//$nKKMblgy
	$pdf->Cell( 1.5	,0.5,$qKipa		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgKipa		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qSipa		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgSipa		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//ips
	
	//ecn
	$qKKMecn 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='ECN' "; // menghasilka kkm per kelas per subjek
	$rKKMecn =mysql_query($qKKMecn) or die('Query gagal');
	$dKKMecn =mysql_fetch_array($rKKMecn);
	$nKKMecn=$dKKMecn[kkm];
	
	$qECN ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='ECN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rECN=mysql_query($qECN) or die('Query gagal');
	$dECN =mysql_fetch_array($rECN);
	
	$qSTK=$dECN['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dECN['qg_k14_'.$sms.$midtrm]; // q
	$qKecn = $qSTK;
	$qSecn = $qSTS;
		
	if($qKecn>100)
		$lgKecn = 'ERR';
	else if($qKecn>=90)
		$lgKecn = 'A';
	else if($qKecn>=80)
		$lgKecn = 'B';
	else if($qKecn>=70)
		$lgKecn = 'C';
	else if($qKecn>=0)
		$lgKecn = 'D';
	else //if($qKecn==0)
		$lgKecn = "ERR";
	
	if($qSecn>100)
		$lgSecn = 'ERR';
	else if($qSecn>=90)
		$lgSecn = 'A';
	else if($qSecn>=80)
		$lgSecn = 'B';
	else if($qSecn>=70)
		$lgSecn = 'C';
	else if($qSecn>=0)
		$lgSecn = 'D';
	else //if($qSecn==0)
		$lgSecn = "ERR";
		
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'7'			,'LRTB',0,C,true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 2.7	,0.5,'Social'		,'LRT',0,C,true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 5	,0.5,'Economics'		,'LRTB',0,L,true);
	$pdf->Cell( 2.5	,0.5,'70'		,'LRTB',0,C,true);//$nKKMecn
	$pdf->Cell( 1.5	,0.5,$qKecn		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgKecn		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qSecn		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgSecn		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	//ggry+hist
	$qGGRY ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='GGRY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rGGRY=mysql_query($qGGRY) or die('Query gagal');
	$dGGRY =mysql_fetch_array($rGGRY);
	
	$qSTK=$dGGRY['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dGGRY['qg_k14_'.$sms.$midtrm]; // q
	$qKggry = $qSTK;
	$qSggry = $qSTS;
		
	$qHIST ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='HIST'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rHIST=mysql_query($qHIST) or die('Query gagal');
	$dHIST =mysql_fetch_array($rHIST);
	
	$qSTK=$dHIST['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dHIST['qg_k14_'.$sms.$midtrm]; // q
	$qKhist = $qSTK;
	$qShist = $qSTS;
	
	$qKgh = number_format( ($qKggry+$qKhist)/2 ,0,',','.' );
	$qSgh = number_format( ($qSggry+$qShist)/2 ,0,',','.' );
		
	if($qKgh>100)
		$lgKgh = 'ERR';
	else if($qKgh>=90)
		$lgKgh = 'A';
	else if($qKgh>=80)
		$lgKgh = 'B';
	else if($qKgh>=70)
		$lgKgh = 'C';
	else if($qKgh>=0)
		$lgKgh = 'D';
	else //if($qKgh==0)
		$lgKgh = "ERR";
	
	if($qSgh>100)
		$lgSgh = 'ERR';
	else if($qSgh>=90)
		$lgSgh = 'A';
	else if($qSgh>=80)
		$lgSgh = 'B';
	else if($qSgh>=70)
		$lgSgh = 'C';
	else if($qSgh>=0)
		$lgSgh = 'D';
	else //if($qSgh==0)
		$lgSgh = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,''			,'LRT',0,C,true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 2.7	,0.5,'Studies'		,'LR',0,C,true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 5	,0.5,'Geography & History'		,'LRTB',0,L,true);
	$pdf->Cell( 2.5	,0.5,'70'		,'LRTB',0,C,true);//$nKKMgh
	$pdf->Cell( 1.5	,0.5,$qKgh		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgKgh		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qSgh		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgSgh		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	$qKips = number_format( ($qKecn+$qKgh)/2 ,0,',','.' );
	$qSips = number_format( ($qSecn+$qSgh)/2 ,0,',','.' );
		
	if($qKips>100)
		$lgKips = 'ERR';
	else if($qKips>=90)
		$lgKips = 'A';
	else if($qKips>=80)
		$lgKips = 'B';
	else if($qKips>=70)
		$lgKips = 'C';
	else if($qKips>=0)
		$lgKips = 'D';
	else //if($qKips==0)
		$lgKips = "ERR";
	
	if($qSips>100)
		$lgSips = 'ERR';
	else if($qSips>=90)
		$lgSips = 'A';
	else if($qSips>=80)
		$lgSips = 'B';
	else if($qSips>=70)
		$lgSips = 'C';
	else if($qSips>=0)
		$lgSips = 'D';
	else //if($qSips==0)
		$lgSips = "ERR";
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,''			,'LRB',0,C,true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 2.7	,0.5,'(IPS)'		,'LR',0,C,true);
	$pdf->SetFont('Arial','BI',11);
	$pdf->Cell( 5	,0.5,'Average'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 2.5	,0.5,'70'		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.5,$qKips		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgKips		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qSips		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgSips		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	
	
	
	
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFillColor(245, 222, 179);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 0.6	,0.5,''			,'LTB',0,C,true);
	$pdf->Cell( 7.7	,0.5,'REQUIRED SUBJECTS'		,'TB',0,L,true);
	$pdf->Cell( 2.5	,0.5,''		,'TB',0,C,true);
	$pdf->Cell( 7	,0.5,''		,'RTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//art
	$qKKMart 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='ART' "; // menghasilka kkm per kelas per subjek
	$rKKMart =mysql_query($qKKMart) or die('Query gagal');
	$dKKMart =mysql_fetch_array($rKKMart);
	$nKKMart=$dKKMart[kkm];
	
	$qART ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='ART'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rART=mysql_query($qART) or die('Query gagal');
	$dART =mysql_fetch_array($rART);
	
	$qSTK=$dART['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dART['qg_k14_'.$sms.$midtrm]; // q
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
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'8'			,'LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.5,'Cultural Art (Music/Art)'		,'LRTB',0,L,true);
	$pdf->Cell( 2.5	,0.5,$nKKMart		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.5,$qK		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qS		,'LRTB',0,C,true);
	//pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//pe
	$qKKMpe 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='PE' "; // menghasilka kkm per kelas per subjek
	$rKKMpe =mysql_query($qKKMpe) or die('Query gagal');
	$dKKMpe =mysql_fetch_array($rKKMpe);
	$nKKMpe=$dKKMpe[kkm];
	
	$qPE ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='PE'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'9'			,'LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.5,'Physical Education and Health'		,'LRTB',0,L,true);
	$pdf->Cell( 2.5	,0.5,$nKKMpe		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.5,$qK		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qS		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	//ict
	$qKKMict 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='ICT' "; // menghasilka kkm per kelas per subjek
	$rKKMict =mysql_query($qKKMict) or die('Query gagal');
	$dKKMict =mysql_fetch_array($rKKMict);
	$nKKMict=$dKKMict[kkm];
	
	$qICT ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='ICT'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
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
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'10'			,'LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.5,'Technology and Livelihood Education'		,'LRTB',0,L,true);
	$pdf->Cell( 2.5	,0.5,$nKKMict		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.5,$qK		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qS		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	
	
	
	
	//plkj
	$qKKMplkj 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
								t_kkm.kdeplj='PLKJ' "; // menghasilka kkm per kelas per subjek
	$rKKMplkj =mysql_query($qKKMplkj) or die('Query gagal');
	$dKKMplkj =mysql_fetch_array($rKKMplkj);
	$nKKMplkj=$dKKMplkj[kkm];
	
	$qPLKJ ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
							t_prgrptps_smp_k13.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp_k13.kdeplj='PLKJ'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rPLKJ=mysql_query($qPLKJ) or die('Query gagal');
	$dPLKJ =mysql_fetch_array($rPLKJ);
	
	$qSTK=$dPLKJ['qg_k13_'.$sms.$midtrm]; // q
	$qSTS=$dPLKJ['qg_k14_'.$sms.$midtrm]; // q
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
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'11'			,'LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.5,'PLKJ'		,'LRTB',0,L,true);//Pendidikan Lingkungan Kebudayaan Jakarta
	$pdf->Cell( 2.5	,0.5,$nKKMplkj		,'LRTB',0,C,true);//'70'
	$pdf->Cell( 1.5	,0.5,$qK		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qS		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgS		,'LRTB',0,C,true);
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
	
	$qFOR ="	SELECT 		t_prgrptps_smp_k13.*
				FROM 		t_prgrptps_smp_k13
				WHERE		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'		AND
							t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'		AND
							t_prgrptps_smp_k13.kdeplj='GRM'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rFOR=mysql_query($qFOR) or die('Query gagal');//german
	$dFOR =mysql_fetch_array($rFOR);
	$qFORstk=$dFOR['qg_k13_'.$sms.$midtrm]; // q
	
	if( $qFORstk=='0' )
	{
		$strFOR='Mandarin';
		
		$qFOR ="	SELECT 		t_prgrptps_smp_k13.*
					FROM 		t_prgrptps_smp_k13
					WHERE		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'		AND
								t_prgrptps_smp_k13.thn_ajaran='". mysql_escape_string($thn_ajr)."'		AND
								t_prgrptps_smp_k13.kdeplj='MND'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
		$rFOR=mysql_query($qFOR) or die('Query gagal');//mandarin
		$dFOR =mysql_fetch_array($rFOR);
	}
	else
		$strFOR='German';
	
	
	
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
	$pdf->Cell( 1.5	,0.5,'',0,0,L); 
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'12'			,'LRTB',0,C,true);
	$pdf->Cell( 5.6	,0.5,'Foreign Language'		,'LRTB',0,L,true);
	$pdf->Cell( 2.1	,0.5,$strFOR		,'LRTB',0,C,true);
	$pdf->Cell( 2.5	,0.5,$nKKMfor		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.5,$qK		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgK		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5	,0.5,$qS		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 2	,0.5,$lgS		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	
	$pdf->Ln();
	
	
	
	//absen
	$pdf->Ln(0.35);
	$pdf->Cell( 1.5	,0.5,'',0,0,L);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 9.3	,0.5,'ATTENDANCE',LRTB,0,C,true);
	
	//absences
	$qABS	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$nis' AND 
							t_hdrkmnps.thn_ajaran='$thn_ajr' "; // menghasilka nilai kehadiran
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
	$pdf->Cell( 1.5	,0.5,'',0,0,L);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,0.5,'1','LRTB',0,C);
	$pdf->Cell( 6.35,0.5,'ABSENCE DUE TO SICKNESS','LRTB',0,L,true);
	$pdf->Cell( 0.25,0.5,' : ','LRTB',0,C,true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.75,0.5,'   '.$q1SKT.'   ','LRTB',0,C,true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.35	,0.5,' day/s  ','LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.5,'',0,0,L);
	$pdf->Cell( 0.6	,0.5,'2','LRTB',0,C);
	$pdf->Cell( 6.35,0.5,'EXCUSED ABSENCE','LRTB',0,L,true);
	$pdf->Cell( 0.25,0.5,' : ','LRTB',0,C,true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.75,0.5,'   '.$q1IZN.'   ','LRTB',0,C,true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.35	,0.5,' day/s  ','LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.5,'',0,0,L);
	$pdf->Cell( 0.6	,0.5,'3','LRTB',0,C);
	$pdf->Cell( 6.35,0.5,'UNEXCUSED ABSENCE','LRTB',0,L,true);
	$pdf->Cell( 0.25,0.5,' : ','LRTB',0,C,true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.75,0.5,'   '.$q1ALP.'   ','LRTB',0,C,true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 1.35	,0.5,' day/s  ','LRTB',0,C,true);
	
	//..
	
	//ekskul
	$pdf->Ln(0.85);
	$pdf->Cell( 1.5	,0.5,'',0,0,L);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 17.8,0.5,'EXTRA-CURRICULAR ACTIVITY PERFORMANCE','LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell( 1.5	,0.5,'',0,0,L);
	$pdf->Cell( 5.8	,0.5,'ACTIVITY','LRTB',0,C,true);
	$pdf->Cell( 12	,0.5,'REMARKS','LRTB',0,C,true);
	
	
	
	$nmaPil1='';//='Scouting';//'SCOUTING'
	$ktrPil1='';//='Sometimes present in the activities and exhibits helpfulness and cooperation';
	
	$nmaPil2='';
	$ktrPil2='';
	
	$nmaPil3='';
	$ktrPil3='';
	
	
	
	//pramuka
	$qPMK	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr'	AND
							t_extcrrps.kdeplj='PMK' "; // extra kurikuler
	$rPMK=mysql_query($qPMK) or die('Query gagal40');
	$dPMK =mysql_fetch_array($rPMK);
	$q1PMK=$dPMK['ext'.$sms.$midtrm]; // q1 PMK 'ext'
	if($q1PMK!='')
	{
		$nmaPil1='Scouting';
		//$ktrPil2='';//$q1PMK
		
		if($q1PMK=='A')
			$ktrPil1='Shosw enthusiasm, leadership and cooperation through regular     attendance and active participation in the activities.';
		else if($q1PMK=='B')
			$ktrPil1='Sometimes present in the activities and exhibits helpfulness and cooperation';
		else if($q1PMK=='C')
			$ktrPil1='Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of role and tasks.';
		else if($q1PMK=='D')
			$ktrPil1='Rarely, if not never, attends activities.';
		else //if($q1PMK=='NA')
			$ktrPil1='-';
	}
	else
	{
		$nmaPil1='-';
		$nliPil1='-';
		$ktrPil1='-';
	}
	
	//futsal
	$qFTS	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr'	AND
							t_extcrrps.kdeplj='FTS' "; // extra kurikuler
	$rFTS=mysql_query($qFTS) or die('Query gagal40');
	$dFTS =mysql_fetch_array($rFTS);
	$q1FTS=$dFTS['ext'.$sms.$midtrm]; // q1 FTS 'ext'
	if($q1FTS!='')
	{
		$nmaPil2='Futsal';
		//$ktrPil2='';//$q1FTS
		
		if($q1FTS=='A')
			$ktrPil2='Shosw enthusiasm, leadership and cooperation through regular     attendance and active participation in the activities.';
		else if($q1FTS=='B')
			$ktrPil2='Sometimes present in the activities and exhibits helpfulness and cooperation';
		else if($q1FTS=='C')
			$ktrPil2='Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of role and tasks.';
		else if($q1FTS=='D')
			$ktrPil2='Rarely, if not never, attends activities.';
		else //if($q1FTS=='NA')
			$ktrPil2='-';
	}
	//basket
	$qBSK	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr'	AND
							t_extcrrps.kdeplj='BSK' "; // extra kurikuler
	$rBSK=mysql_query($qBSK) or die('Query gagal40');
	$dBSK =mysql_fetch_array($rBSK);
	$q1BSK=$dBSK['ext'.$sms.$midtrm]; // q1 BSK 'ext'
	if($q1BSK!='')
	{
		$nmaPil2='Basket';
		//$ktrPil2='';//$q1BSK
		
		if($q1BSK=='A')
			$ktrPil2='Shosw enthusiasm, leadership and cooperation through regular     attendance and active participation in the activities.';
		else if($q1BSK=='B')
			$ktrPil2='Sometimes present in the activities and exhibits helpfulness and cooperation';
		else if($q1BSK=='C')
			$ktrPil2='Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of role and tasks.';
		else if($q1BSK=='D')
			$ktrPil2='Rarely, if not never, attends activities.';
		else //if($q1BSK=='NA')
			$ktrPil2='-';
	}
	//table tennis
	$qTNS	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr'	AND
							t_extcrrps.kdeplj='TNS' "; // extra kurikuler
	$rTNS=mysql_query($qTNS) or die('Query gagal40');
	$dTNS =mysql_fetch_array($rTNS);
	$q1TNS=$dTNS['ext'.$sms.$midtrm]; // q1 TNS
	if($q1TNS!='')
	{
		$nmaPil2='Table Tennis';
		//$ktrPil2='';//$q1TNS
		
		if($q1TNS=='A')
			$ktrPil2='Shows enthusiasm, leadership and cooperation through regular     attendance and active participation in the activities.';
		else if($q1TNS=='B')
			$ktrPil2='Sometimes present in the activities and exhibits helpfulness and cooperation';
		else if($q1TNS=='C')
			$ktrPil2='Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of role and tasks.';
		else if($q1TNS=='D')
			$ktrPil2='Rarely, if not never, attends activities.';
		else //if($q1TNS=='NA')
			$ktrPil2='-';
	}
	
	
	
	//dance
	$qMDR	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr'	AND
							t_extcrrps.kdeplj='MDR' "; // extra kurikuler
	$rMDR=mysql_query($qMDR) or die('Query gagal40');
	$dMDR =mysql_fetch_array($rMDR);
	$q1MDR=$dMDR['ext'.$sms.$midtrm]; // q1 MDR
	if($q1MDR!='')
	{
		$nmaPil3='Modern Dance';
		//$ktrPil3='';//$q1MDR
		
		if($q1MDR=='A')
			$ktrPil3='Shows enthusiasm, leadership and cooperation through regular     attendance and active participation in the activities.';
		else if($q1MDR=='B')
			$ktrPil3='Sometimes present in the activities and exhibits helpfulness and cooperation';
		else if($q1MDR=='C')
			$ktrPil3='Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of role and tasks.';
		else if($q1MDR=='D')
			$ktrPil3='Rarely, if not never, attends activities.';
		else //if($q1MDR=='NA')
			$ktrPil3='-';
	}
	
	//theatre art
	$qTHE	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr'	AND
							t_extcrrps.kdeplj='THE' "; // extra kurikuler
	$rTHE=mysql_query($qTHE) or die('Query gagal40');
	$dTHE =mysql_fetch_array($rTHE);
	$q1THE=$dTHE['ext'.$sms.$midtrm]; // q1 THE
	if($q1THE!='')
	{
		$nmaPil3='Theatre Art';//THEATRE ART
		//$ktrPil3='';//$q1THE
		
		if($q1THE=='A')
			$ktrPil3='Shows enthusiasm, leadership and cooperation through regular     attendance and active participation in the activities.';
		else if($q1THE=='B')
			$ktrPil3='Sometimes present in the activities and exhibits helpfulness and cooperation';
		else if($q1THE=='C')
			$ktrPil3='Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of role and tasks.';
		else if($q1THE=='D')
			$ktrPil3='Rarely, if not never, attends activities.';
		else //if($q1THE=='NA')
			$ktrPil3='-';
	}
	
	//mandarin club
	$qMNDC	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr'	AND
							t_extcrrps.kdeplj='MNDC' "; // extra kurikuler
	$rMNDC=mysql_query($qMNDC) or die('Query gagal40');
	$dMNDC =mysql_fetch_array($rMNDC);
	$q1MNDC=$dMNDC['ext'.$sms.$midtrm]; // q1 MNDC
	if($q1MNDC!='')
	{
		$nmaPil3='Mandarin Club';//THEATRE ART
		//$ktrPil3='';//$q1THE
		
		if($q1MNDC=='A')
			$ktrPil3='Shows enthusiasm, leadership and cooperation through regular     attendance and active participation in the activities.';
		else if($q1MNDC=='B')
			$ktrPil3='Sometimes present in the activities and exhibits helpfulness and cooperation';
		else if($q1MNDC=='C')
			$ktrPil3='Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of role and tasks.';
		else if($q1MNDC=='D')
			$ktrPil3='Rarely, if not never, attends activities.';
		else //if($q1MNDC=='NA')
			$ktrPil3='-';
	}
	
	//english club
	$qCLB	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr'	AND
							t_extcrrps.kdeplj='CLB' "; // extra kurikuler
	$rCLB=mysql_query($qCLB) or die('Query gagal40');
	$dCLB =mysql_fetch_array($rCLB);
	$q1CLB=$dCLB['ext'.$sms.$midtrm]; // q1 CLB
	if($q1CLB!='')
	{
		$nmaPil3='English Club';//THEATRE ART
		//$ktrPil3='';//$q1THE
		
		if($q1CLB=='A')
			$ktrPil3='Shows enthusiasm, leadership and cooperation through regular     attendance and active participation in the activities.';
		else if($q1CLB=='B')
			$ktrPil3='Sometimes present in the activities and exhibits helpfulness and cooperation';
		else if($q1CLB=='C')
			$ktrPil3='Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of role and tasks.';
		else if($q1CLB=='D')
			$ktrPil3='Rarely, if not never, attends activities.';
		else //if($q1CLB=='NA')
			$ktrPil3='-';
	}
	
	//robotic
	$qRBT	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr'	AND
							t_extcrrps.kdeplj='RBT' "; // extra kurikuler
	$rRBT=mysql_query($qRBT) or die('Query gagal40');
	$dRBT =mysql_fetch_array($rRBT);
	$q1RBT=$dRBT['ext'.$sms.$midtrm]; // q1 RBT
	if($q1RBT!='')
	{
		$nmaPil3='Robotic';//THEATRE ART
		//$ktrPil3='';//$q1THE
		
		if($q1RBT=='A')
			$ktrPil3='Shows enthusiasm, leadership and cooperation through regular     attendance and active participation in the activities.';
		else if($q1RBT=='B')
			$ktrPil3='Sometimes present in the activities and exhibits helpfulness and cooperation';
		else if($q1RBT=='C')
			$ktrPil3='Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of role and tasks.';
		else if($q1RBT=='D')
			$ktrPil3='Rarely, if not never, attends activities.';
		else //if($q1RBT=='NA')
			$ktrPil3='-';
	}
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.5,'',0,0,L);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.6	,1.0,'1','LRTB',0,C,true);
	$pdf->Cell( 5.2	,1.0,$nmaPil1,'LRTB',0,C,true);
	$pdf->Cell( 12	,0.5,substr($ktrPil1,0,65),'LRT',0,J,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.5,'',0,0,L);
	$pdf->Cell( 0.6	,1.0,'',0,0,C,false);
	$pdf->Cell( 5.2	,1.0,'',0,0,C,false);
	$pdf->Cell( 12	,0.5,substr($ktrPil1,65,65),'LRB',0,J,true);
	
	if($q1FTS=='' AND $q1BSK=='' AND $q1TNS=='')
	{
		$nmaPil2='-';
		$nliPil2='-';
		$ktrPil2='-';
		
		$pdf->Ln();
		$pdf->Cell( 1.5	,0.5,'',0,0,L);
		$pdf->Cell( 0.6	,1.0,'2','LRTB',0,C,true);
		$pdf->Cell( 5.2	,1.0,$nmaPil2,'LRTB',0,C,true);
		$pdf->Cell( 12	,1,substr($ktrPil2,0,65),'LRTB',0,J);
		
		//$pdf->Ln(0.5);
	}
	else
	{
		$pdf->Ln();
		$pdf->Cell( 1.5	,0.5,'',0,0,L);
		$pdf->Cell( 0.6	,1.0,'2','LRTB',0,C,true);
		$pdf->Cell( 5.2	,1.0,$nmaPil2,'LRTB',0,C,true);
		$pdf->Cell( 12	,0.5,substr($ktrPil2,0,65),'LRT',0,J);
		
		$pdf->Ln();
		$pdf->Cell( 1.5	,0.5,'',0,0,L);
		$pdf->Cell( 0.6	,1.5,'',0,0,C,false);
		$pdf->Cell( 5.2	,1.5,'',0,0,C,false);
		$pdf->Cell( 12	,0.5,substr($ktrPil2,65,65),'LRB',0,J);
	}
	
	if($q1THE=='' AND $q1MNDC=='' AND $q1MDR=='' AND $q1CLB=='' AND $q1RBT=='')
	{
		$nmaPil3='-';
		$nliPil3='-';
		$ktrPil3='-';
		
		$pdf->Ln();
		$pdf->Cell( 1.5	,0.5,'',0,0,L);
		$pdf->Cell( 0.6	,1.0,'3','LRTB',0,C,true);
		$pdf->Cell( 5.2	,1.0,$nmaPil3,'LRTB',0,C,true);
		$pdf->Cell( 12	,1,substr($ktrPil3,0,65),'LRTB',0,J);
		
		$pdf->Ln(0.5);
	}
	else
	{
		$pdf->Ln();
		$pdf->Cell( 1.5	,0.5,'',0,0,L);
		$pdf->Cell( 0.6	,1.0,'3','LRTB',0,C,true);
		$pdf->Cell( 5.2	,1.0,$nmaPil3,'LRTB',0,C,true);
		$pdf->Cell( 12	,0.5,substr($ktrPil3,0,65),'LRT',0,J);
		
		$pdf->Ln();
		$pdf->Cell( 1.5	,0.5,'',0,0,L);
		$pdf->Cell( 0.6	,1.5,'',0,0,C,false);
		$pdf->Cell( 5.2	,1.5,'',0,0,C,false);
		$pdf->Cell( 12	,0.5,substr($ktrPil3,65,65),'LRB',0,J);
	}
	
	//..
	
	//
	$pdf->Ln(0.85);
	$pdf->Cell( 2.5	,0.5,'',0,0,L);
	$pdf->Cell( 7.1	,0.5,'',0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	$pdf->Cell( 1.6	,0.5,'Place/Date:',0,0,L);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	$pdf->Cell( 1.3	,0.5,'',0,0,L);
	$pdf->Cell( 6 ,0.5,'Jakarta, '.$tglctk,0,0,C,true);
	
	/*$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 5.35,0.4,'',0,0,C,false);
	$pdf->Cell( 0.25,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);*/
	
	/*$pdf->Ln();
	$pdf->Cell( 2.5	,0.5,'',0,0,L);
	$pdf->Cell( 5.35,0.5,'',0,0,C,false);
	$pdf->Cell( 0.25,0.5,'',0,0,C,false);
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell( 0.75,0.5,'',0,0,C,false);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.75,0.5,'',0,0,C,false);
	$pdf->Cell( 1.6,0.5,'',0,0,L);*/
	
	$pdf->Ln();
	$pdf->Cell( 2.5	,0.5,'',0,0,L);
	$pdf->Cell( 5.35,0.5,'',0,0,C,false);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	//$pdf->Cell( 0.25,0.4,'',0,0,C,false);
	//$pdf->SetFont('Arial','U',8);
	//$pdf->Cell( 0.25,0.4,'',0,0,C,false);
	//$pdf->SetFont('Arial','',8);
	//$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->Cell( 2	,0.5,'Issued by:',0,0,L);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 6	,0.5,'  '.'  ',0,0,C,true);
	//$pdf->Image($signature, 14, 25.75, 4.577234, 2.143098);
	
	//..
	
	$pdf->Ln(2);
	$pdf->Cell( 2.5	,0.5,'',0,0,L);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell( 3	,0.5,'                     '.'                    ',0,0,C,true);
	$pdf->Cell( 2.7,0.5,'',0,0,L);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	$pdf->Cell( 3	,0.5,'  '.$wlikls.$gelar.'  ',0,0,C,true);
	$pdf->Cell( 2.7,0.5,'',0,0,L);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	$pdf->Cell( 3	,0.5,'  '.'Ir. '.$kplskl.', MBA'.'  ',0,0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 2.5	,0.5,'',0,0,L);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 3	,0.5,"Parent's Signature",0,0,C,true);
	$pdf->Cell( 2.7,0.5,'',0,0,L);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	$pdf->Cell( 3	,0.5,'Homeroom Adviser',0,0,C,true);
	$pdf->Cell( 2.7,0.5,'',0,0,L);
	$pdf->Cell( 0.5	,0.5,'',0,0,L);//..
	$pdf->Cell( 3	,0.5,'Principal',0,0,C,true);
	
	
	
	
	$y++;
	
}//cetak all

$pdf->Output();

?>