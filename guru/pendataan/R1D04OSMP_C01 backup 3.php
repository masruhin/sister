<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04OSMP_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) rapot mid term smp 7
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
		$query3 	="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE 		t_prgrptps_smp_k13.nis='". mysql_escape_string($nis)."'	AND
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
	$tgllhr	=date('d F Y',$tgllhr);
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
	$pdf->Ln(3);
	$pdf->SetFont('arial','BU',12);
	$pdf->Cell(17.5	,0.4, "JUNIOR HIGH SCHOOL",0,0,C); // 19 $judul
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
	//$q1KMN=$dABS['kmn'."1"."1"]; // q1 kmn.$sms.$midtrm
	$q1KMN=$dABS['kmn'.$sms.$midtrm]; // q1 kmn
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 0.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.5	,0.4,"3   Comment",0,0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 14.8,0.4,substr($q1KMN,0,105),'LRT',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 14.8,0.4,substr($q1KMN,105,105),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 14.8,0.4,substr($q1KMN,210,105),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 14.8,0.4,substr($q1KMN,315,105),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 14.8,0.4,substr($q1KMN,420,105),'LR',0,L); 
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 14.8,0.4,substr($q1KMN,525,105),'LRB',0,L); 
	
	
	
	
	
	
	
	
	
	
	
	$pdf->Ln(1);
	$pdf->Ln(0.85);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.4,'',0,0,C,false);
	$pdf->Cell( 1.6	,0.4,'Place/Date:',0,0,L);
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
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->Cell( 1.6	,0.4,'Issued by:',0,0,L);
	$pdf->SetFont('Arial','BU',8);
	$pdf->Cell( 6	,0.4,'              '.$wlikls.$gelar.'            ',0,0,C,true);
	$pdf->Image($signature, 11.75, 20.85, 4.577234, 2.143098);
	
	//..
	
	$pdf->Ln(0.5);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
	$pdf->Cell( 1.6 ,0.4,'',0,0,L);
	$pdf->Cell( 6	,0.4,''.'Homeroom Adviser',0,0,C,true);
	
	$pdf->Ln();
	$pdf->Ln(2);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',8);
	$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,C,true);
	$pdf->Cell( 1.6,0.4,'',0,0,L);
	$pdf->Cell( 6	,0.4,'                   '.'Ir. '.$kplskl.', MBA'.'                   ',0,0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 7.1	,0.4,"Parent's Signature",0,0,C,true);
	$pdf->Cell( 1.6,0.4,'',0,0,L);
	$pdf->Cell( 6	,0.4,'Principal',0,0,C,true);
	
	
	
	//..sampai sini
	//awal halaman 2
	
	
	
	$pdf->Open();
	$pdf->AddPage();
	//$pdf->Image($logo_pt ,1,0.75,2,2);
	//$pdf->Image($logo_ttw,18,1,2,2);
	$pdf->Ln(3);
	$pdf->SetFont('arial','BU',12);
	$pdf->Cell(17.5	,0.4, "JUNIOR HIGH SCHOOL",0,0,C); // 19 $judul
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
	$pdf->Cell( 1.5	,0.4,'Letter Grade'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Score'		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.4,'Letter Grade'		,'LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L); 
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( 0.6	,0.4,''			,'LTB',0,C,true);
	$pdf->Cell( 7.2	,0.4,'CORE SUBJECTS'		,'TB',0,L,true);//6.7
	$pdf->Cell( 2	,0.4,''		,'T',0,C,true);
	$pdf->Cell( 5	,0.4,''		,'RTB',0,C,true);
	$pdf->Ln();
	
	//------------------------------- Mata Pelajaran Kurikulum Nasional
	$j	=1;
	$no =1;
	
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
		
		if($j==13)
		{
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell( 1.5	,0.4,'',0,0,L); 
			$pdf->Cell( 0.6	,0.4,''			,'LTB',0,C,true);
			$pdf->Cell( 7.2	,0.4,'REQUIRED SUBJECTS'		,'TB',0,L,true);//6.7
			$pdf->Cell( 2	,0.4,''		,'T',0,C,true);
			$pdf->Cell( 5	,0.4,''		,'RTB',0,C,true);
			$pdf->Ln();
		}
		
		if($nmasbj!='')
		{
			if(substr($nmasbj,0,1)=='/')
			{
				$nmasbj 	=str_replace("/","","$nmasbj");
				$pdf->SetFont('Arial','B',8);
				$pdf->SetFillColor(204,204,204);
				$pdf->Cell(7.7	,0.5,$nmasbj,'LRTB',0,L,true);		//A
				$nliakh	='';
				
			}
			else
			{
				$pdf->SetFont('Arial','',8);
				$pdf->SetFillColor(255,255,255);
				
				
				
				//mnd
				$qMND ="	SELECT 		t_prgrptps_smp_k13.*
							FROM 		t_prgrptps_smp_k13
							WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
										t_prgrptps_smp_k13.kdeplj='MND'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
				$rMND=mysql_query($qMND) or die('Query gagal');
				$dMND =mysql_fetch_array($rMND);
				$q1STKMND=$dMND['qg_k13_'.$sms.$midtrm]; // q1
				$q1STSMND=$dMND['qg_k14_'.$sms.$midtrm]; // q1
				
				//grm
				$qGRM ="	SELECT 		t_prgrptps_smp_k13.*
							FROM 		t_prgrptps_smp_k13
							WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
										t_prgrptps_smp_k13.kdeplj='GRM'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
				$rGRM=mysql_query($qGRM) or die('Query gagal');
				$dGRM =mysql_fetch_array($rGRM);
				$q1STKGRM=$dGRM['qg_k13_'.$sms.$midtrm]; // q1
				$q1STSGRM=$dGRM['qg_k14_'.$sms.$midtrm]; // q1
				
				if($kdeplj=='FOR')
				{
					if($q1STKMND!=0)
					{
						$nmasbj = 'Foreign Language: Mandarin';
						//$q1K = $q1STKMND;
						//$q1S = $q1STSMND;
					}
					
					if($q1STKGRM!=0)
					{
						$nmasbj = 'Foreign Language: German';
						//$q1K = $q1STKGRM;
						//$q1S = $q1STSGRM;
					}
				}
				
				
				
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
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(0.1	,0.5,'','LTB',0,R,true); // 0.6 $no.'.'
					//$pdf->Cell(7.1	,0.5,$nmasbj,'RTB',0,L,true);//6.6
					
					if($nmasbj=='Natural Science (IPA)' OR $nmasbj=='Social Studies (IPS)')
					{
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(7.1	,0.5,$nmasbj,'RTB',0,L,true);
					}
					else
						$pdf->Cell(7.1	,0.5,$nmasbj,'RTB',0,L,true);
					
					$no++;
				}
				else
				{
					$nmasbj 	=str_replace("=","","$nmasbj");
					$pdf->Cell(7.2	,0.5,'        '.$nmasbj,'LRTB',0,L,true); // 6.7
				}	
				
				
				
			}	
			
			
			
			$qry ="	SELECT 		t_prgrptps_smp_k13.*
						FROM 		t_prgrptps_smp_k13
						WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
									t_prgrptps_smp_k13.kdeplj='$kdeplj'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl=mysql_query($qry) or die('Query gagal');
			$dat =mysql_fetch_array($rsl);
			
			$q1STK=$dat['qg_k13_'.$sms.$midtrm]; // q1
			$q1STS=$dat['qg_k14_'.$sms.$midtrm]; // q1
			
			$q1K = $q1STK;
			$q1S = $q1STS;
			
			
			
			if($kdeplj=='FOR')
			{
				if($q1STKMND!=0)
				{
					$q1K = $q1STKMND;
					$q1S = $q1STSMND;
				}
				
				if($q1STKGRM!=0)
				{
					$q1K = $q1STKGRM;
					$q1S = $q1STSGRM;
				}
			}
			
			if($kdeplj=='IPA')
			{
				//blgy
				$qBLGY ="	SELECT 		t_prgrptps_smp_k13.*
							FROM 		t_prgrptps_smp_k13
							WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
										t_prgrptps_smp_k13.kdeplj='BLGY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
				$rBLGY=mysql_query($qBLGY) or die('Query gagal');
				$dBLGY =mysql_fetch_array($rBLGY);
				$q1STKBLGY=$dBLGY['qg_k13_'.$sms.$midtrm]; // q1
				$q1STSBLGY=$dBLGY['qg_k14_'.$sms.$midtrm]; // q1
				
				//phy	chemistry/physisc
				$qPHY ="	SELECT 		t_prgrptps_smp_k13.*
							FROM 		t_prgrptps_smp_k13
							WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
										t_prgrptps_smp_k13.kdeplj='PHY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
				$rPHY=mysql_query($qPHY) or die('Query gagal');
				$dPHY =mysql_fetch_array($rPHY);
				$q1STKPHY=$dPHY['qg_k13_'.$sms.$midtrm]; // q1
				$q1STSPHY=$dPHY['qg_k14_'.$sms.$midtrm]; // q1
				
				$q1K = number_format(  ($q1STKBLGY+$q1STKPHY)/2 ,0,',','.');
				$q1S = number_format(  ($q1STSBLGY+$q1STSPHY)/2 ,0,',','.');
			}
			
			if($kdeplj=='IPS')
			{
				//ecn
				$qECN ="	SELECT 		t_prgrptps_smp_k13.*
							FROM 		t_prgrptps_smp_k13
							WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
										t_prgrptps_smp_k13.kdeplj='ECN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
				$rECN=mysql_query($qECN) or die('Query gagal');
				$dECN =mysql_fetch_array($rECN);
				$q1STKECN=$dECN['qg_k13_'.$sms.$midtrm]; // q1
				$q1STSECN=$dECN['qg_k14_'.$sms.$midtrm]; // q1
				
				//hist
				$qHIST ="	SELECT 		t_prgrptps_smp_k13.*
							FROM 		t_prgrptps_smp_k13
							WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
										t_prgrptps_smp_k13.kdeplj='HIST'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
				$rHIST=mysql_query($qHIST) or die('Query gagal');
				$dHIST =mysql_fetch_array($rHIST);
				$q1STKHIST=$dHIST['qg_k13_'.$sms.$midtrm]; // q1
				$q1STSHIST=$dHIST['qg_k14_'.$sms.$midtrm]; // q1
				
				//ggry
				$qGGRY ="	SELECT 		t_prgrptps_smp_k13.*
							FROM 		t_prgrptps_smp_k13
							WHERE		t_prgrptps_smp_k13.nis='$nis'		AND
										t_prgrptps_smp_k13.kdeplj='GGRY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
				$rGGRY=mysql_query($qGGRY) or die('Query gagal');
				$dGGRY =mysql_fetch_array($rGGRY);
				$q1STKGGRY=$dGGRY['qg_k13_'.$sms.$midtrm]; // q1
				$q1STSGGRY=$dGGRY['qg_k14_'.$sms.$midtrm]; // q1
				
				$q1K = number_format(  ($q1STKECN+$q1STKHIST+$q1STKGGRY)/3 ,0,',','.');
				$q1S = number_format(  ($q1STSECN+$q1STSHIST+$q1STSGGRY)/3 ,0,',','.');
			}
			
			
			
			if($q1K>100)
				$lgK = 'ERR';
			else if($q1K>=90)
				$lgK = 'A';
			else if($q1K>=80)
				$lgK = 'B';
			else if($q1K>=70)
				$lgK = 'C';
			else if($q1K>=0)
				$lgK = 'D';
			else //if($q1K==0)
				$lgK = "ERR";
			
			if($q1S>100)
				$lgS = 'ERR';
			else if($q1S>=90)
				$lgS = 'A';
			else if($q1S>=80)
				$lgS = 'B';
			else if($q1S>=70)
				$lgS = 'C';
			else if($q1S>=0)
				$lgS = 'D';
			else //if($q1S==0)
				$lgS = "ERR";
				
			
			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell( 2	,0.5,$kkm,'LRTB',0,C,true);//Kkm
			$pdf->Cell( 1	,0.5,$q1K,'LRTB',0,C,true);
			$pdf->Cell( 1.5	,0.5,$lgK,'LRTB',0,C,true);//K
			$pdf->Cell( 1	,0.5,$q1S,'LRTB',0,C,true);//S
			$pdf->Cell( 1.5	,0.5,$lgS,'LRTB',0,C,true);
			
			$pdf->SetTextColor(0,0,0);
			
			$pdf->Ln();
		}	
		
		
		
		$j++;
		$id++;
		
	}
	
	
	
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
	$qBSK	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='BSK' "; // extra kurikuler
	$rBSK=mysql_query($qBSK) or die('Query gagal40');
	$dBSK =mysql_fetch_array($rBSK);
	$q1BSK=$dBSK['ext'.$sms.$midtrm]; 	//$q1BSK=$dBSK['ktr'.$sms.$midtrm]; // q1 BSK
	if($q1BSK!='')
	{
		$nmaPil2='BASKET BALL';			//$ktrPil2=$q1BSK;
		
		if( $q1BSK == 'A')
			$ktrPil2 = 'Shows enthusiasm, leadership and cooperation through regular attendance and active participation in the activities.';
		else if( $q1BSK == 'B')
			$ktrPil2 = 'Sometimes present in the activities and exhibits helpfulness and cooperation.';
		else if( $q1BSK == 'C')
			$ktrPil2 = 'Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of roles and tasks.';
		else if( $q1BSK == 'D')
			$ktrPil2 = 'Rarely, if not never, attends activities.';
		else //if( $q1BSK == 'NA')
			$ktrPil2 = '-';
	}
	//futsal
	$qFTS	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='FTS' "; // extra kurikuler
	$rFTS=mysql_query($qFTS) or die('Query gagal40');
	$dFTS =mysql_fetch_array($rFTS);
	$q1FTS=$dFTS['ext'.$sms.$midtrm]; 	// $q1FTS=$dFTS['ktr'.$sms.$midtrm]; // q1 FTS
	if($q1FTS!='')
	{
		$nmaPil2='FUTSAL';				// $ktrPil2=$q1FTS;
		
		if( $q1FTS == 'A')
			$ktrPil2 = 'Shows enthusiasm, leadership and cooperation through regular attendance and active participation in the activities.';
		else if( $q1FTS == 'B')
			$ktrPil2 = 'Sometimes present in the activities and exhibits helpfulness and cooperation.';
		else if( $q1FTS == 'C')
			$ktrPil2 = 'Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of roles and tasks.';
		else if( $q1FTS == 'D')
			$ktrPil2 = 'Rarely, if not never, attends activities.';
		else //if( $q1FTS == 'NA')
			$ktrPil2 = '-';
	}
	//table tennis
	$qTNS	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='TNS' "; // extra kurikuler
	$rTNS=mysql_query($qTNS) or die('Query gagal40');
	$dTNS =mysql_fetch_array($rTNS);
	$q1TNS=$dTNS['ext'.$sms.$midtrm]; 	// $q1TNS=$dTNS['ktr'.$sms.$midtrm]; // q1 TNS
	if($q1TNS!='')
	{
		$nmaPil2='TABLE TENNIS';		// $ktrPil2=$q1TNS;
		
		if( $q1TNS == 'A')
			$ktrPil2 = 'Shows enthusiasm, leadership and cooperation through regular attendance and active participation in the activities.';
		else if( $q1TNS == 'B')
			$ktrPil2 = 'Sometimes present in the activities and exhibits helpfulness and cooperation.';
		else if( $q1TNS == 'C')
			$ktrPil2 = 'Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of roles and tasks.';
		else if( $q1TNS == 'D')
			$ktrPil2 = 'Rarely, if not never, attends activities.';
		else //if( $q1TNS == 'NA')
			$ktrPil2 = '-';
	}
	
	//culinary
	$qCLN	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='CLN' "; // extra kurikuler
	$rCLN=mysql_query($qCLN) or die('Query gagal40');
	$dCLN =mysql_fetch_array($rCLN);
	$q1CLN=$dCLN['ext'.$sms.$midtrm]; 	// $q1CLN=$dCLN['ktr'.$sms.$midtrm]; // q1 CLN
	if($q1CLN!='')
	{
		$nmaPil3='CULINARY ART';		// $ktrPil3=$q1CLN;
		
		if( $q1CLN == 'A')
			$ktrPil3 = 'Shows enthusiasm, leadership and cooperation through regular attendance and active participation in the activities.';
		else if( $q1CLN == 'B')
			$ktrPil3 = 'Sometimes present in the activities and exhibits helpfulness and cooperation.';
		else if( $q1CLN == 'C')
			$ktrPil3 = 'Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of roles and tasks.';
		else if( $q1CLN == 'D')
			$ktrPil3 = 'Rarely, if not never, attends activities.';
		else //if( $q1CLN == 'NA')
			$ktrPil3 = '-';
	}
	//modern dance
	$qMDR	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='MDR' "; // extra kurikuler
	$rMDR=mysql_query($qMDR) or die('Query gagal40');
	$dMDR =mysql_fetch_array($rMDR);
	$q1MDR=$dMDR['ext'.$sms.$midtrm]; 	// $q1MDR=$dMDR['ktr'.$sms.$midtrm]; // q1 MDR
	if($q1MDR!='')
	{
		$nmaPil3='MODERN DANCE';		// $ktrPil3=$q1MDR;
		
		if( $q1MDR == 'A')
			$ktrPil3 = 'Shows enthusiasm, leadership and cooperation through regular attendance and active participation in the activities.';
		else if( $q1MDR == 'B')
			$ktrPil3 = 'Sometimes present in the activities and exhibits helpfulness and cooperation.';
		else if( $q1MDR == 'C')
			$ktrPil3 = 'Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of roles and tasks.';
		else if( $q1MDR == 'D')
			$ktrPil3 = 'Rarely, if not never, attends activities.';
		else //if( $q1MDR == 'NA')
			$ktrPil3 = '-';
	}
	//theatre art
	$qTHE	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='THE' "; // extra kurikuler
	$rTHE=mysql_query($qTHE) or die('Query gagal40');
	$dTHE =mysql_fetch_array($rTHE);
	$q1THE=$dTHE['ext'.$sms.$midtrm]; 	// $q1THE=$dTHE['ktr'.$sms.$midtrm]; // q1 THE
	if($q1THE!='')
	{
		$nmaPil3='THEATRE ART';			// $ktrPil3=$q1THE;
		
		if( $q1THE == 'A')
			$ktrPil3 = 'Shows enthusiasm, leadership and cooperation through regular attendance and active participation in the activities.';
		else if( $q1THE == 'B')
			$ktrPil3 = 'Sometimes present in the activities and exhibits helpfulness and cooperation.';
		else if( $q1THE == 'C')
			$ktrPil3 = 'Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of roles and tasks.';
		else if( $q1THE == 'D')
			$ktrPil3 = 'Rarely, if not never, attends activities.';
		else //if( $q1THE == 'NA')
			$ktrPil3 = '-';
	}
	//Interest(Science & Math Club/English Club)
	$qCLB	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='CLB' "; // extra kurikuler
	$rCLB=mysql_query($qCLB) or die('Query gagal40');
	$dCLB =mysql_fetch_array($rCLB);
	$q1CLB=$dCLB['ext'.$sms.$midtrm]; 	// $q1CLB=$dCLB['ktr'.$sms.$midtrm]; // q1 CLB
	if($q1CLB!='')
	{
		$nmaPil3='INTEREST(SCIENCE & MATH CLUB/ENGLISH CLUB)'; // $ktrPil3=$q1CLB;
		
		if( $q1CLB == 'A')
			$ktrPil3 = 'Shows enthusiasm, leadership and cooperation through regular attendance and active participation in the activities.';
		else if( $q1CLB == 'B')
			$ktrPil3 = 'Sometimes present in the activities and exhibits helpfulness and cooperation.';
		else if( $q1CLB == 'C')
			$ktrPil3 = 'Lacks enthusiasm as shown by the usual absence in the activities and being continuously reminded of roles and tasks.';
		else if( $q1CLB == 'D')
			$ktrPil3 = 'Rarely, if not never, attends activities.';
		else //if( $q1CLB == 'NA')
			$ktrPil3 = '-';
	}
	
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
	$pdf->Cell( 6 ,0.4,'Jakarta, '.$tglctk,0,0,C,true);
	
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
		$q1SKT='-';
	if($q1IZN==0)
		$q1IZN='-';
	if($q1ALP==0)
		$q1ALP='-';
	
	
	
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
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.75,0.4,'',0,0,C,false);
	$pdf->Cell( 1.6	,0.4,'Issued by:',0,0,L);
	$pdf->SetFont('Arial','BU',8);
	$pdf->Cell( 6	,0.4,'              '.$wlikls.$gelar.'            ',0,0,C,true);
	$pdf->Image($signature, 12.15, 26.5, 4, 1.9);//4.577234, 2.143098
	
	//..
	
	$pdf->Ln(0.5);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
	$pdf->Cell( 1.6 ,0.4,'',0,0,L);
	$pdf->Cell( 6	,0.4,''.'Homeroom Adviser',0,0,C,true);
	
	//$pdf->Ln();
	$pdf->Ln(2);
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',8);
	$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,C,true);
	$pdf->Cell( 1.6,0.4,'',0,0,L);
	$pdf->Cell( 6	,0.4,'                   '.'Ir. '.$kplskl.', MBA'.'                   ',0,0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.5	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 7.1	,0.4,"Parent's Signature",0,0,C,true);
	$pdf->Cell( 1.6,0.4,'',0,0,L);
	$pdf->Cell( 6	,0.4,'Principal',0,0,C,true);
	
	
	
	
	$y++;
	
}//cetak all

$pdf->Output();

?>