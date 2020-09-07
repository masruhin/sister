<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04SDlrcd_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) rapot mid term sd 4
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdekls	=$_POST['kdekls'];
$sms	=$_POST['sms'];
$midtrm	=$_POST['midtrm'];
$tglctk	=$_POST['tglctk'];

//$sms	= "1";
//$midtrm = "1";

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
$query	="	SELECT 		t_setthn_sd.*
			FROM 		t_setthn_sd
			WHERE		t_setthn_sd.set='Tahun Ajaran'"; // menghasilka tahun ajaran
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

// dapatkan data bobot nilai



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


//$logo_pt	="../../images/logo.jpg";
$logo_pt	="../../images/logo_sd.jpg";
$logo_ttw	="../../images/tutwurihandayani.jpg";

$pdf =new FPDF('P','cm','A4');
$pdf->SetMargins(0.5,0.4,1);//1,0.4,1
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
								
								t_mstssw.str=''	
					ORDER BY	t_mstssw.kdekls,t_mstssw.nis ASC
					LIMIT		1,1"; //t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."' AND 
					// menghasilka satu siswa per kelas per subjek
		$result2 =mysql_query($query2) or die('Query gagal5');
		$data2 	=mysql_fetch_array($result2);
		$nis	=$data2[nis];//asli
		
		
	}	
}

$query 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
						
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; //t_mstssw.thn_ajaran='". mysql_escape_string($thn_ajr)."' AND
			// menghasilka semua siswa per kelas
$result =mysql_query($query) or die('Query gagal5');
$i=0;
while($data =mysql_fetch_array($result))
{
	$cell5[$i][0]=$data[nis];
	$cell5[$i][1]=$data[nmassw];
	$cell5[$i][2]=$data[nisn];
	$cell5[$i][3]=0;
	$nis=$data[nis];//asli
	
	//$nis_x
	$cell5[$i][4]=$data[tgllhr]; // buatan tgl lahir
	
	
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
	
	
	
	$strkls='';
	if($kdekls=='P-1A')
		$strkls='Primary-1A (St. Anastasia)';
	else if($kdekls=='P-1B')
		$strkls='Primary-1B (St. Tarcisius)';
	else if($kdekls=='P-1C')
		$strkls='Primary-1C (St. Patricia)';
	else if($kdekls=='P-2A')
		$strkls='Primary-2A (St. Attalia)';
	else if($kdekls=='P-2B')
		$strkls='Primary-2B (St. Beatrice)';
	else if($kdekls=='P-2C')
		$strkls='Primary-2C (St. Charles)';
	else if($kdekls=='P-3A')
		$strkls='Primary-3A (St. Teresa)';
	else if($kdekls=='P-3B')
		$strkls='Primary-3B (St. Aloysius Gonzaga)';
	else if($kdekls=='P-3C')
		$strkls='Primary-3C (St. Margaret)';
	else if($kdekls=='P-4A')
		$strkls='Primary-4A (St. Abigail)';
	else if($kdekls=='P-4B')
		$strkls='Primary-4B (St. Benedict)';
	else if($kdekls=='P-4C')
		$strkls='Primary-4C (St. Carolus)';
	else if($kdekls=='P-5A')
		$strkls='Primary-5A (St. Alena)';
	else if($kdekls=='P-5B')
		$strkls='Primary-5B (St. Bridget)';
	else if($kdekls=='P-5C')
		$strkls='Primary-5C (St. Colette)';
	else if($kdekls=='P-6A')
		$strkls='Primary-6A (St. Arnold Janssen)';
	else if($kdekls=='P-6B')
		$strkls='Primary-6B (St. Blaise)';
	else //if($kdekls=='P-6C')
		$strkls='Primary-6C (St. Claire)';
	
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Image($logo_pt ,4.5,0.3,2,2);
	//$pdf->Image($logo_ttw,18,1,2,2);
	$pdf->SetFont('arial','B',16);//20
	$pdf->Cell( 2.25	,0.4,"",0,0,L); 
	$pdf->Cell(17.5	,0.5, "SAINT JOHN'S SCHOOL",0,0,C); // 19 $judul
	$pdf->SetFont('Arial','B',16);//18
	$pdf->Ln();
	
	$pdf->Cell( 2.25	,0.4,"",0,0,L);
	$pdf->Cell(17.5	,0.5, "Student Learning Record",0,0,C); // 19 $judul2 .$thnajr
	$pdf->Ln();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell( 2.25	,0.4,"",0,0,L);
	$pdf->Cell(17.5	,0.5, "Academic Year ".$thnajr,0,0,C);// 19
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat2_pt2
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.8	,0.4,"Semester         : ",0,0,L); 
	$pdf->SetFont('Arial','',10.5);
	$pdf->Cell( 1.5	,0.4,"  ".$sms,0,0,L); //"     ".."     "
	$pdf->Cell( 8.75	,0.4,"",0,0,L); 
	$pdf->SetFont('Arial','',10.5);
	$pdf->Cell( 2.5	,0.4,"Term           : ",0,0,L); 
	$pdf->SetFont('Arial','',10.5);
	$pdf->Cell( 2	,0.4,$midtrm,0,0,L); //".$sms."=2//"     ".."     "
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.8	,0.4,"Grade              : ",0,0,L); 
	$pdf->SetFont('Arial','',10.5);
	$pdf->Cell( 1.5	,0.4,"  ".$strkls,0,0,L); //"      ".."                         "
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Cell( 1.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2.8	,0.4,"Student Name : ",0,0,L); 
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 1.5	,0.4,"  ".$nmassw."          ",0,0,L); //
	$pdf->Cell( 8.75	,0.4,"",0,0,L);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Cell( 2.5	,0.4,"Student No. : ",0,0,L); 
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 2	,0.4," ".substr($nis,0,3),0,0,L); //$tgllhr
	
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Cell( 20	,0.5,'Dear Parents:',0,0,L); 
	$pdf->Ln();
	$pdf->Cell( 20	,0.5,'This Learning Record shows the extent to which your child has achieved in each of the learning objectives based on the ','',0,J,true);
	$pdf->Ln();
	$pdf->Cell( 20	,0.5,'observation and assessments made in this semester. There is no passing or failing marks in this record but only a desc','',0,J,true);
	$pdf->Ln();
	$pdf->Cell( 20	,0.5,'ription of the level of performance to guide parents and teachers in tracking the progress of the student. It is assumed that ','',0,J,true);
	$pdf->Ln();
	$pdf->Cell( 20	,0.5,'students has the emerging knowledge and skills in most of the competencies listed and will develop continuously in the ','',0,J,true);
	$pdf->Ln();
	$pdf->Cell( 20	,0.5,'succeeding terms or semester to meet or even exceed in the desired competence.','',0,J,true);
	
	$pdf->Ln(0.75);
	$pdf->SetFillColor(204,204,204);
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 16	,0.9,'Learning Objectives'		,'LRTB',0,C,true);
	$pdf->Cell( 4	,0.9,'Description'		,'LRTB',0,C,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->SetFillColor(255,255,255);
	
	
	
	$result='';
	$query 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."'  ";//AND t_learnrcd.thn_ajaran='". mysql_escape_string($thn_ajr)."'
	$result =mysql_query($query);
	if(mysql_num_rows($result)=='0')
	{
		$query 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' ";
		$result =mysql_query($query);
	}
	
	
	
	/*$query 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' ";// ORDER BY	t_lrcd. asli
	$result =mysql_query($query);*/
	$i=0;
	while($data = mysql_fetch_array($result))
	{
		$cell[$i][0]=$data[kde];
		$cell[$i][1]=$data[nmektr];
		$kde		=$data[kde];
		
		
		
		/*$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_learnrcd_sd.kdeplj	='". mysql_escape_string( substr($kde,0,3) )."' ";
		$result2 =mysql_query($query2);
		$data2	=mysql_fetch_array($result2);*/
		
		
		
		//$cell[$i][2]=$data2['hw'."$sms"."$midtrm".'1'];
		//$cell[$i][3]=$data2['nmektr'];
		$i++;
	}
	
	
	
	//rlg
	$pdf->Ln();
	$pdf->SetFillColor(255,255,0);
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 20	,0.5,'Subject : Religion and Character Education'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 20	,0.5,'Pupil is able to:'		,'LRTB',0,L,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	
	
	
	$rRLG='';
	$qRLG 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'rlg%' ";//t_learnrcd.thn_ajaran='". mysql_escape_string($thn_ajr)."' AND
	$rRLG =mysql_query($qRLG);
	if(mysql_num_rows($rRLG)=='0')
	{
		$qRLG 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'rlg%' ";
		$rRLG =mysql_query($qRLG);
	}
	
	
	/*$qRLG 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'rlg%' ";
	$rRLG =mysql_query($qRLG);*/
	$j=0;
	$no=1;
	$strnli='';
	while($dRLG = mysql_fetch_array($rRLG))
	{
		$cell[$j][4]=$dRLG[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd_sd.kdeplj	='RLG' ";//t_learnrcd_sd.thn_ajaran='". mysql_escape_string($thn_ajr)."' AND
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cRLG[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cRLG[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
			
		
		
		if( strlen($nmektr)>95 )
		{
			$pdf->SetFont('Arial','',9.25);
			$pdf->Cell( 1	,0.5,$no		,'LRT',0,C,true);
			$pdf->Cell( 15	,0.5,substr($nmektr,0,95)	,'LRT',0,L,true);
			
			if($nli==5 OR $nli==4 OR $nli==0)
				$pdf->SetFont('Arial','',9.25);
			else //if($nli==3 OR $nli==2 OR $nli==1)
				$pdf->SetFont('Arial','',6);
			
			$pdf->Cell( 4	,0.5,$strnli		,'LRT',0,L,true);
			
			$pdf->Ln();
			$pdf->Cell( 1	,0.5,''		,'LRB',0,C,true);
			$pdf->Cell( 15	,0.5,substr($nmektr,95,95)	,'LRB',0,L,true);
			$pdf->Cell( 4	,0.5,''		,'LRB',0,L,true);
		}
		else
		{
			$pdf->SetFont('Arial','',9.25);
			$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
			$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
			
			if($nli==5 OR $nli==4 OR $nli==0)
				$pdf->SetFont('Arial','',9.25);
			else //if($nli==3 OR $nli==2 OR $nli==1)
				$pdf->SetFont('Arial','',6);
				
			$pdf->Cell( 4	,0.5,$strnli	,'LRTB',0,L,true);
		}
		
		
		
		//$pdf->SetFont('Arial','',10.5);
		$pdf->Ln();
		
		$j++;
		$no++;
	}
	
	
	
	if( $kdekls=='P-4A' OR $kdekls=='P-4B' OR $kdekls=='P-4C' )
	{
		$pdf->Cell( 1	,0.5,''		,'',0,C,true);
		$pdf->Cell( 15	,0.5,''		,'',0,L,true);
		$pdf->Cell( 4	,0.5,''		,'',0,L,true);
		$pdf->Ln();
	}
	
	
	
	//cme
	$pdf->SetFillColor(255,255,0);
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 20	,0.5,'Subject : Pancasila and Civic Education'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 20	,0.5,'Pupil is able to:'		,'LRTB',0,L,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	
	
	
	$rCME='';
	$qCME 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'cme%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
	$rCME =mysql_query($qCME);
	if(mysql_num_rows($rCME)=='0')
	{
		$qCME 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'cme%' ";
		$rCME =mysql_query($qCME);
	}
	
	
	/*$qCME 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'cme%' "; 		// ORDER BY	t_lrcd.
	$rCME =mysql_query($qCME);*/
	$no=1;
	$strnli='';
	while($dCME = mysql_fetch_array($rCME))
	{
		$cell[$j][4]=$dCME[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd_sd.kdeplj	='CME' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND	
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cCME[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cCME[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
		
		
		
		
		
		
		
		$pdf->SetFont('Arial','',9.5);//
		$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
		$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
		
		if($nli==5 OR $nli==4 OR $nli==0)
			$pdf->SetFont('Arial','',10.5);
		else //if($nli==3 OR $nli==2 OR $nli==1)
			$pdf->SetFont('Arial','',6);
		
		$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		$pdf->Ln();

		$j++;
		$no++;
	}
	
	
	
	if( $kdekls=='P-4A' OR $kdekls=='P-4B' OR $kdekls=='P-4C' )
	{
		$pdf->Cell( 1	,0.5,''		,'',0,C,true);
		$pdf->Cell( 15	,0.5,''		,'',0,L,true);
		$pdf->Cell( 4	,0.5,''		,'',0,L,true);
		$pdf->Ln();
	}
	
	
	
	//bin
	$pdf->SetFillColor(255,255,0);
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 20	,0.5,'Subject : Bahasa Indonesia'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 20	,0.5,'Siswa mampu:'		,'LRTB',0,L,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 1	,0.5,''		,'LRTB',0,C,true);
	$pdf->SetFont('Arial','B',9);
	if($kdekls=='P-1A' OR $kdekls=='P-1B' OR $kdekls=='P-1C' OR $kdekls=='P-2A' OR $kdekls=='P-2B' OR $kdekls=='P-2C' OR $kdekls=='P-3A' OR $kdekls=='P-3B' OR $kdekls=='P-3C')
	{
		$pdf->Cell( 15	,0.5,'Mendengarkan dan Berbicara'	,'LRTB',0,L,true);
	}
	else
	{
		$pdf->Cell( 15	,0.5,'Membaca dan Menulis'	,'LRTB',0,L,true);
	}
	$pdf->SetFont('Arial','',10.5);
	$pdf->Cell( 4	,0.5,''		,'LRTB',0,L,true);
	$pdf->Ln();
	
	
	
	$rBIN1='';
	$qBIN1 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'binA%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
	$rBIN1 =mysql_query($qBIN1);
	if(mysql_num_rows($rBIN1)=='0')
	{
		$qBIN1 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'binA%' ";
		$rBIN1 =mysql_query($qBIN1);
	}
	
	
	/*$qBIN1 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'binA%' "; 		// ORDER BY	t_lrcd.
	$rBIN1 =mysql_query($qBIN1);*/
	$no=1;
	$strnli='';
	while($dBIN1 = mysql_fetch_array($rBIN1))
	{
		$cell[$j][4]=$dBIN1[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd_sd.kdeplj	='BIN' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cBIN[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cBIN[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
			
			
			
		if( strlen($nmektr)>90 )
		{
			$pdf->SetFont('Arial','',9);
			$pdf->Cell( 1	,0.5,$no		,'LRT',0,C,true);
			$pdf->Cell( 15	,0.5,substr($nmektr,0,90)	,'LRT',0,L,true);
			
			if($nli==5 OR $nli==4 OR $nli==0)
				$pdf->SetFont('Arial','',10.5);
			else //if($nli==3 OR $nli==2 OR $nli==1)
				$pdf->SetFont('Arial','',6);
			
			$pdf->Cell( 4	,0.5,$strnli		,'LRT',0,L,true);
			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);
			$pdf->Cell( 1	,0.5,''		,'LRB',0,C,true);
			$pdf->Cell( 15	,0.5,substr($nmektr,90,90)	,'LRB',0,L,true);
			$pdf->Cell( 4	,0.5,''		,'LRB',0,L,true);
		}
		else
		{
			$pdf->SetFont('Arial','',9);
			$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
			$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
			
			if($nli==5 OR $nli==4 OR $nli==0)
				$pdf->SetFont('Arial','',10.5);
			else //if($nli==3 OR $nli==2 OR $nli==1)
				$pdf->SetFont('Arial','',6);
			
			$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		}
		
		
		
		$pdf->Ln();

		$j++;
		$no++;
	}
	$pdf->Cell( 1	,0.5,''		,'LRTB',0,C,true);
	$pdf->SetFont('Arial','B',9);
	if($kdekls=='P-1A' OR $kdekls=='P-1B' OR $kdekls=='P-1C' OR $kdekls=='P-2A' OR $kdekls=='P-2B' OR $kdekls=='P-2C' OR $kdekls=='P-3A' OR $kdekls=='P-3B' OR $kdekls=='P-3C')
	{
		$pdf->Cell( 15	,0.5,'Membaca dan Menulis'	,'LRTB',0,L,true);
	}
	else
	{
		$pdf->Cell( 15	,0.5,'Mendengarkan dan Berbicara'	,'LRTB',0,L,true);
	}
	$pdf->SetFont('Arial','',10.5);
	$pdf->Cell( 4	,0.5,''		,'LRTB',0,L,true);
	$pdf->Ln();
	
	
	
	$rBIN2='';
	$qBIN2 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'binB%' 
				ORDER BY	t_learnrcd.kdekls, t_learnrcd.kde
							";
	$rBIN2 =mysql_query($qBIN2);
	if(mysql_num_rows($rBIN2)=='0')
	{
		$qBIN2 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'binB%' 
					ORDER BY	t_lrcd.nourut			
								";
		$rBIN2 =mysql_query($qBIN2);
	}
	
	
	/*$qBIN2 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'binB%' "; 		// ORDER BY	t_lrcd.
	$rBIN2 =mysql_query($qBIN2);*/
	//$no=1;
	$strnli='';
	while($dBIN2 = mysql_fetch_array($rBIN2))
	{
		$cell[$j][4]=$dBIN2[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd_sd.kdeplj	='BIN' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cBIN[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cBIN[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
		
		$pdf->SetFont('Arial','',9);
		$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
		$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
		
		if($nli==5 OR $nli==4 OR $nli==0)
			$pdf->SetFont('Arial','',10.5);
		else //if($nli==3 OR $nli==2 OR $nli==1)
			$pdf->SetFont('Arial','',6);
		
		$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		$pdf->Ln();

		$j++;
		$no++;
	}
	
	
	
	if( $kdekls=='P-4A' OR $kdekls=='P-4B' OR $kdekls=='P-4C' )
	{
		$pdf->Cell( 1	,0.5,''		,'',0,C,true);
		$pdf->Cell( 15	,0.5,''		,'',0,L,true);
		$pdf->Cell( 4	,0.5,''		,'',0,L,true);
		$pdf->Ln();
	}
	if($kdekls=='P-5A' OR $kdekls=='P-5B' OR $kdekls=='P-5C')
	{
		$pdf->Ln();
		$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 6.35,0.6,'','',0,C,true);
		$pdf->Cell( 0.25,0.6,'',0,0,C,true);
		$pdf->Cell( 0.75,0.6,'',0,0,C,true);
		$pdf->Cell( 1.35,0.6,'','',0,C,true);
		$pdf->Cell( 1.6,0.6,'Issued by:',0,0,L);
		
		$pdf->Ln();
		$pdf->Ln(0.6);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,false);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->SetFont('Arial','BU',10.5);
		$pdf->Cell( 7.1	,0.6,'  '.$wlikls.$gelar.'  ',0,0,C,true);
		$pdf->SetFont('Arial','',10.5);
		
		$pdf->Ln(0.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.6,''.'Homeroom Adviser',0,0,C,true);
		$pdf->Ln();
		
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(20   ,0,'',1); 	
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$pdf->Cell( 5	,0.4,$nmassw.' - Term '.$midtrm);
		$pdf->Cell(15  	,0.4,'Page : 1 ',0,0,R);
		$pdf->Ln();
	}
	if($kdekls=='P-6A' OR $kdekls=='P-6B' OR $kdekls=='P-6C')
	{
		$pdf->Ln();
		$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 6.35,0.6,'','',0,C,true);
		$pdf->Cell( 0.25,0.6,'',0,0,C,true);
		$pdf->Cell( 0.75,0.6,'',0,0,C,true);
		$pdf->Cell( 1.35,0.6,'','',0,C,true);
		$pdf->Cell( 1.6,0.6,'Issued by:',0,0,L);
		
		$pdf->Ln();
		$pdf->Ln(0.6);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,false);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->SetFont('Arial','BU',10.5);
		$pdf->Cell( 7.1	,0.6,'  '.$wlikls.$gelar.'  ',0,0,C,true);
		$pdf->SetFont('Arial','',10.5);
		
		$pdf->Ln(0.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.6,''.'Homeroom Adviser',0,0,C,true);
		$pdf->Ln();
		
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		//$pdf->Ln();
		$pdf->Cell(20   ,0,'',1); 	
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$pdf->Cell( 5	,0.4,$nmassw.' - Term '.$midtrm);
		$pdf->Cell(15  	,0.4,'Page : 1 ',0,0,R);
		$pdf->Ln();
	}
	
	
	
	//mth
	$pdf->SetFillColor(255,255,0);
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 20	,0.5,'Subject : Mathematics'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 20	,0.5,'Pupil is able to:'		,'LRTB',0,L,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	
	
	
	$rMTH='';
	$qMTH 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'mth%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
	$rMTH =mysql_query($qMTH);
	if(mysql_num_rows($rMTH)=='0')
	{
		$qMTH 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'mth%' ";
		$rMTH =mysql_query($qMTH);
	}
	
	
	/*$qMTH 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'mth%' "; 		// ORDER BY	t_lrcd.
	$rMTH =mysql_query($qMTH);*/
	$no=1;
	$strnli='';
	while($dMTH = mysql_fetch_array($rMTH))
	{
		$cell[$j][4]=$dMTH[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
									
								t_learnrcd_sd.kdeplj	='MTH' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cMTH[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cMTH[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
		
		$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
		$pdf->Cell( 15	,0.5,$cell[$j][4]	,'LRTB',0,L,true);//$nmektr
		
		if($nli==5 OR $nli==4 OR $nli==0)
			$pdf->SetFont('Arial','',10.5);
		else //if($nli==3 OR $nli==2 OR $nli==1)
			$pdf->SetFont('Arial','',6);
		
		$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		$pdf->Ln();

		$j++;
		$no++;
	}
	
	
	
	if($kdekls=='P-3A' OR $kdekls=='P-3B' OR $kdekls=='P-3C')
	{
		$pdf->Ln();
		$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 6.35,0.6,'','',0,C,true);
		$pdf->Cell( 0.25,0.6,'',0,0,C,true);
		$pdf->Cell( 0.75,0.6,'',0,0,C,true);
		$pdf->Cell( 1.35,0.6,'','',0,C,true);
		$pdf->Cell( 1.6,0.6,'Issued by:',0,0,L);
		
		$pdf->Ln();
		$pdf->Ln(0.6);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,false);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->SetFont('Arial','BU',10.5);
		$pdf->Cell( 7.1	,0.6,'  '.$wlikls.$gelar.'  ',0,0,C,true);
		$pdf->SetFont('Arial','',10.5);
		
		$pdf->Ln(0.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.6,''.'Homeroom Adviser',0,0,C,true);
		$pdf->Ln();
		
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(20   ,0,'',1); 	
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$pdf->Cell( 5	,0.4,$nmassw.' - Term '.$midtrm);
		$pdf->Cell(15  	,0.4,'Page : 1 ',0,0,R);
		$pdf->Ln();
	}
	if($kdekls=='P-4A' OR $kdekls=='P-4B' OR $kdekls=='P-4C')
	{
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(20   ,0,'',1); 	
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$pdf->Cell( 5	,0.4,$nmassw.' - Term '.$midtrm);
		$pdf->Cell(15  	,0.4,'Page : 1 ',0,0,R);
		$pdf->Ln();
	}
	
	
	
	//scn
	$pdf->SetFillColor(255,255,0);
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 20	,0.5,'Subject : General Science'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 20	,0.5,'Pupil is able to:'		,'LRTB',0,L,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	
	
	
	$rSCN='';
	$qSCN 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'scn%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
	$rSCN =mysql_query($qSCN);
	if(mysql_num_rows($rSCN)=='0')
	{
		$qSCN 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'scn%' ";
		$rSCN =mysql_query($qSCN);
	}
	
	
	/*$qSCN 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'scn%' "; 		// ORDER BY	t_lrcd.
	$rSCN =mysql_query($qSCN);*/
	$no=1;
	$strnli='';
	while($dSCN = mysql_fetch_array($rSCN))
	{
		$cell[$j][4]=$dSCN[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd_sd.kdeplj	='SCN' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cSCN[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cSCN[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
		
		$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
		$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
		
		if($nli==5 OR $nli==4 OR $nli==0)
			$pdf->SetFont('Arial','',10.5);
		else //if($nli==3 OR $nli==2 OR $nli==1)
			$pdf->SetFont('Arial','',6);
		
		$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		$pdf->Ln();

		$j++;
		$no++;
	}
	
	
	
	if($kdekls=='P-1A' OR $kdekls=='P-1B' OR $kdekls=='P-1C')
	{
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		//$pdf->Ln();
		$pdf->Cell(20   ,0,'',1); 	
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$pdf->Cell( 5	,0.4,$nmassw.' - Term '.$midtrm);
		$pdf->Cell(15  	,0.4,'Page : 1 ',0,0,R);
		$pdf->Ln();
	}
	
	
	
	//scls
	$pdf->SetFillColor(255,255,0);
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 20	,0.5,'Subject: Social Studies'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	
	
	
	$rSCLS='';
	$qSCLS 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'scls%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
	$rSCLS =mysql_query($qSCLS);
	if(mysql_num_rows($rSCLS)=='0')
	{
		$qSCLS 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'scls%' ";
		$rSCLS =mysql_query($qSCLS);
	}
	
	
	/*$qSCLS 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'scls%' "; 		// ORDER BY	t_lrcd.
	$rSCLS =mysql_query($qSCLS);*/
	$no=1;
	$strnli='';
	while($dSCLS = mysql_fetch_array($rSCLS))
	{
		$cell[$j][4]=$dSCLS[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd_sd.kdeplj	='SCLS' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cSCLS[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cSCLS[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
		
		$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
		$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
		
		if($nli==5 OR $nli==4 OR $nli==0)
			$pdf->SetFont('Arial','',10.5);
		else //if($nli==3 OR $nli==2 OR $nli==1)
			$pdf->SetFont('Arial','',6);
		
		$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		$pdf->Ln();

		$j++;
		$no++;
	}
	
	
	
	if($kdekls=='P-2A' OR $kdekls=='P-2B' OR $kdekls=='P-2C')
	{
		$pdf->Ln();
		$pdf->Ln();
		//$pdf->Ln();
		$pdf->Cell(20   ,0,'',1); 	
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$pdf->Cell( 5	,0.4,$nmassw.' - Term '.$midtrm);
		$pdf->Cell(15  	,0.4,'Page : 1 ',0,0,R);
		$pdf->Ln();
	}
	
	
	
	//art
	$pdf->SetFillColor(255,255,0);
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 20	,0.5,'Subject : Cultural Arts And Music'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 20	,0.5,'Pupil is able to:'		,'LRTB',0,L,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	
	
	
	$rART='';
	$qART 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'art%' 
				ORDER BY	t_learnrcd.kdekls, t_learnrcd.kde			
							";
	$rART =mysql_query($qART);
	if(mysql_num_rows($rART)=='0')
	{
		$qART 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'art%' 
					ORDER BY	t_lrcd.nourut			
								";
		$rART =mysql_query($qART);
	}
	
	
	/*$qART 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'art%' "; 		// ORDER BY	t_lrcd.
	$rART =mysql_query($qART);*/
	$no=1;
	$strnli='';
	while($dART = mysql_fetch_array($rART))
	{
		$cell[$j][4]=$dART[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_learnrcd_sd.kdeplj	='ART' ";
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cART[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cART[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
			
			
		
		if( strlen($nmektr)>85 )
		{
			$pdf->SetFont('Arial','',10.5);
			$pdf->Cell( 1	,0.5,$no		,'LRT',0,C,true);
			$pdf->Cell( 15	,0.5,substr($nmektr,0,85)	,'LRT',0,L,true);
			
			if($nli==5 OR $nli==4 OR $nli==0)
				$pdf->SetFont('Arial','',10.5);
			else //if($nli==3 OR $nli==2 OR $nli==1)
				$pdf->SetFont('Arial','',6);
			
			$pdf->Cell( 4	,0.5,$strnli		,'LRT',0,L,true);
			
			$pdf->Ln();
			$pdf->Cell( 1	,0.5,''		,'LRB',0,C,true);
			$pdf->Cell( 15	,0.5,substr($nmektr,85,85)	,'LRB',0,L,true);
			$pdf->Cell( 4	,0.5,''		,'LRB',0,L,true);
		}
		else
		{
			$pdf->SetFont('Arial','',10.5);
			$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
			$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
			
			if($nli==5 OR $nli==4 OR $nli==0)
				$pdf->SetFont('Arial','',10.5);
			else //if($nli==3 OR $nli==2 OR $nli==1)
				$pdf->SetFont('Arial','',6);
			
			$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		}
		
		$pdf->Ln();

		$j++;
		$no++;
	}
	
	
	
	//..
	
	
	
	//pe
	/*$pdf->SetFillColor(255,255,0);
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 20	,0.5,'Subject : Physical Education and Health'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 20	,0.5,'Pupil is able to:'		,'LRTB',0,L,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$qPE 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'pe%' "; 		// ORDER BY	t_lrcd.
	$rPE =mysql_query($qPE);
	$no=1;
	$strnli='';
	while($dPE = mysql_fetch_array($rPE))
	{
		$cell[$j][4]=$dPE[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_learnrcd_sd.kdeplj	='PE' ";
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cPE[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cPE[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
		
		$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
		$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
		
		if($nli==5 OR $nli==4 OR $nli==0)
			$pdf->SetFont('Arial','',10.5);
		else //if($nli==3 OR $nli==2 OR $nli==1)
			$pdf->SetFont('Arial','',6);
		
		$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		$pdf->Ln();

		$j++;
		$no++;
	}*/
	
	
	
	if($kdekls=='P-5A' OR $kdekls=='P-5B' OR $kdekls=='P-5C')
	{
		$pdf->Ln();
		$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 6.35,0.6,'','',0,C,true);
		$pdf->Cell( 0.25,0.6,'',0,0,C,true);
		$pdf->Cell( 0.75,0.6,'',0,0,C,true);
		$pdf->Cell( 1.35,0.6,'','',0,C,true);
		$pdf->Cell( 1.6,0.6,'Issued by:',0,0,L);
		
		$pdf->Ln();
		$pdf->Ln(0.6);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,false);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->SetFont('Arial','BU',10.5);
		$pdf->Cell( 7.1	,0.6,'  '.$wlikls.$gelar.'  ',0,0,C,true);
		$pdf->SetFont('Arial','',10.5);
		
		$pdf->Ln(0.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.6,''.'Homeroom Adviser',0,0,C,true);
		$pdf->Ln();
		
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(20   ,0,'',1); 	
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$pdf->Cell( 5	,0.4,$nmassw.' - Term '.$midtrm);
		$pdf->Cell(15  	,0.4,'Page : 2 ',0,0,R);
		$pdf->Ln();
	}
	if($kdekls=='P-6A' OR $kdekls=='P-6B' OR $kdekls=='P-6C')
	{
		$pdf->Ln();
		$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 6.35,0.6,'','',0,C);
		$pdf->Cell( 0.25,0.6,'',0,0,C);
		$pdf->Cell( 0.75,0.6,'',0,0,C);
		$pdf->Cell( 1.35,0.6,'','',0,C);
		$pdf->Cell( 1.6,0.6,'Issued by:',0,0,L);
		
		$pdf->Ln();
		$pdf->Ln(0.6);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,false);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->SetFont('Arial','BU',10.5);
		$pdf->Cell( 7.1	,0.6,'  '.$wlikls.$gelar.'  ',0,0,C,true);
		$pdf->SetFont('Arial','',10.5);
		
		$pdf->Ln(0.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.6,''.'Homeroom Adviser',0,0,C,true);
		$pdf->Ln();
		
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(20   ,0,'',1); 	
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$pdf->Cell( 5	,0.4,$nmassw.' - Term '.$midtrm);
		$pdf->Cell(15  	,0.4,'Page : 2 ',0,0,R);
		$pdf->Ln();
	}
	
	
	
	//pe
	$pdf->SetFillColor(255,255,0);
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 20	,0.5,'Subject : Physical Education and Health'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 20	,0.5,'Pupil is able to:'		,'LRTB',0,L,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	
	
	
	$rPE='';
	$qPE 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'pe%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
	$rPE =mysql_query($qPE);
	if(mysql_num_rows($rPE)=='0')
	{
		$qPE 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'pe%' ";
		$rPE =mysql_query($qPE);
	}
	
	
	/*$qPE 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'pe%' "; 		// ORDER BY	t_lrcd.
	$rPE =mysql_query($qPE);*/
	$no=1;
	$strnli='';
	while($dPE = mysql_fetch_array($rPE))
	{
		$cell[$j][4]=$dPE[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd_sd.kdeplj	='PE' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cPE[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cPE[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
		
		$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
		$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
		
		if($nli==5 OR $nli==4 OR $nli==0)
			$pdf->SetFont('Arial','',10.5);
		else //if($nli==3 OR $nli==2 OR $nli==1)
			$pdf->SetFont('Arial','',6);
		
		$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		$pdf->Ln();

		$j++;
		$no++;
	}
	
	
	
	//eng
	$pdf->SetFillColor(255,255,0);
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 20	,0.5,'Subject : English'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 20	,0.5,'Pupil is able to:'		,'LRTB',0,L,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','BI',10.5);
	$pdf->Ln();
	//$pdf->SetFillColor(255,192,203);pink
	$pdf->Cell( 20	,0.5,'Phonics, Spelling and Vocabulary'		,'LRTB',0,L,true);
	//$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	
	
	
	$rENG1='';
	$qENG1 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'engA%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
	$rENG1 =mysql_query($qENG1);
	if(mysql_num_rows($rENG1)=='0')
	{
		$qENG1 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'engA%' ";
		$rENG1 =mysql_query($qENG1);
	}
	
	
	/*$qENG1 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'engA%' "; 		// ORDER BY	t_lrcd.
	$rENG1 =mysql_query($qENG1);*/
	$no=1;
	$strnli='';
	while($dENG1 = mysql_fetch_array($rENG1))
	{
		$cell[$j][4]=$dENG1[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd_sd.kdeplj	='ENG' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cENG[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cENG[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
		
		$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
		$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
		
		if($nli==5 OR $nli==4 OR $nli==0)
			$pdf->SetFont('Arial','',10.5);
		else //if($nli==3 OR $nli==2 OR $nli==1)
			$pdf->SetFont('Arial','',6);
		
		$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		$pdf->Ln();

		$j++;
		$no++;
	}
	$pdf->SetFont('Arial','BI',10.5);
	$pdf->Cell( 20	,0.5,'Grammar and Punctuation'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	
	
	
	$rENG2='';
	$qENG2 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'engB%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
	$rENG2 =mysql_query($qENG2);
	if(mysql_num_rows($rENG2)=='0')
	{
		$qENG2 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'engB%' ";
		$rENG2 =mysql_query($qENG2);
	}
	
	
	/*$qENG2 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'engB%' "; 		// ORDER BY	t_lrcd.
	$rENG2 =mysql_query($qENG2);*/
	//$no=1;
	$strnli='';
	while($dENG2 = mysql_fetch_array($rENG2))
	{
		$cell[$j][4]=$dENG2[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd_sd.kdeplj	='ENG' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cENG[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cENG[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
		
		
		
		if( strlen($nmektr)>90 )
		{
			$pdf->SetFont('Arial','',9.5);
			$pdf->Cell( 1	,0.5,$no		,'LRT',0,C,true);
			$pdf->Cell( 15	,0.5,substr($nmektr,0,90)	,'LRT',0,L,true);
			
			if($nli==5 OR $nli==4 OR $nli==0)
				$pdf->SetFont('Arial','',9.5);
			else //if($nli==3 OR $nli==2 OR $nli==1)
				$pdf->SetFont('Arial','',6);
			
			$pdf->Cell( 4	,0.5,$strnli		,'LRT',0,L,true);
			
			$pdf->Ln();
			$pdf->SetFont('Arial','',9.5);
			$pdf->Cell( 1	,0.5,''		,'LRB',0,C,true);
			$pdf->Cell( 15	,0.5,substr($nmektr,90,90)	,'LRB',0,L,true);
			$pdf->Cell( 4	,0.5,''		,'LRB',0,L,true);
		}
		else
		{
			$pdf->SetFont('Arial','',9.5);
			$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
			$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
			
			if($nli==5 OR $nli==4 OR $nli==0)
				$pdf->SetFont('Arial','',9.5);
			else //if($nli==3 OR $nli==2 OR $nli==1)
				$pdf->SetFont('Arial','',6);
			
			$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		}
		
		
		
		/*$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
		$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
		
		if($nli==5 OR $nli==4 OR $nli==0)
			$pdf->SetFont('Arial','',10.5);
		else //if($nli==3 OR $nli==2 OR $nli==1)
			$pdf->SetFont('Arial','',6);
		
		$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);*/
		$pdf->Ln();

		$j++;
		$no++;
	}
	$pdf->SetFont('Arial','BI',10.5);
	$pdf->Cell( 20	,0.5,'Reading and Writing'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	
	
	
	$rENG3='';
	$qENG3 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'engC%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
	$rENG3 =mysql_query($qENG3);
	if(mysql_num_rows($rENG3)=='0')
	{
		$qENG3 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'engC%' ";
		$rENG3 =mysql_query($qENG3);
	}
	
	
	/*$qENG3 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'engC%' "; 		// ORDER BY	t_lrcd.
	$rENG3 =mysql_query($qENG3);*/
	//$no=1;
	$strnli='';
	while($dENG3 = mysql_fetch_array($rENG3))
	{
		$cell[$j][4]=$dENG3[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd_sd.kdeplj	='ENG' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cENG[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cENG[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
		
		$pdf->SetFont('Arial','',8.5);
		$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
		$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
		
		if($nli==5 OR $nli==4 OR $nli==0)
			$pdf->SetFont('Arial','',10.5);
		else //if($nli==3 OR $nli==2 OR $nli==1)
			$pdf->SetFont('Arial','',6);
		
		$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		$pdf->Ln();

		$j++;
		$no++;
	}
	$pdf->SetFont('Arial','BI',10.5);
	$pdf->Cell( 20	,0.5,'Speaking and Listening'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	
	
	
	$rENG4='';
	$qENG4 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'engD%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
	$rENG4 =mysql_query($qENG4);
	if(mysql_num_rows($rENG4)=='0')
	{
		$qENG4 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'engD%' ";
		$rENG4 =mysql_query($qENG4);
	}
	
	
	/*$qENG4 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'engD%' "; 		// ORDER BY	t_lrcd.
	$rENG4 =mysql_query($qENG4);*/
	//$no=1;
	$strnli='';
	while($dENG4 = mysql_fetch_array($rENG4))
	{
		$cell[$j][4]=$dENG4[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd_sd.kdeplj	='ENG' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cENG[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cENG[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
		
		$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
		$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
		
		if($nli==5 OR $nli==4 OR $nli==0)
			$pdf->SetFont('Arial','',10.5);
		else //if($nli==3 OR $nli==2 OR $nli==1)
			$pdf->SetFont('Arial','',6);
		
		$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		$pdf->Ln();

		$j++;
		$no++;
	}
	
	
	
	if($kdekls=='P-3A' OR $kdekls=='P-3B' OR $kdekls=='P-3C')
	{
		$pdf->Ln();
		$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 6.35,0.6,'','',0,C,true);
		$pdf->Cell( 0.25,0.6,'',0,0,C,true);
		$pdf->Cell( 0.75,0.6,'',0,0,C,true);
		$pdf->Cell( 1.35,0.6,'','',0,C,true);
		$pdf->Cell( 1.6,0.6,'Issued by:',0,0,L);
		
		$pdf->Ln();
		$pdf->Ln(0.6);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,false);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->SetFont('Arial','BU',10.5);
		$pdf->Cell( 7.1	,0.6,'  '.$wlikls.$gelar.'  ',0,0,C,true);
		$pdf->SetFont('Arial','',10.5);
		
		$pdf->Ln(0.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.6,''.'Homeroom Adviser',0,0,C,true);
		$pdf->Ln();
		
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		//$pdf->Ln();
		$pdf->Cell(20   ,0,'',1); 	
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$pdf->Cell( 5	,0.4,$nmassw.' - Term '.$midtrm);
		$pdf->Cell(15  	,0.4,'Page : 2 ',0,0,R);
		$pdf->Ln();
	}
	
	
	
	//mnd
	$pdf->SetFillColor(255,255,0);
	$pdf->SetFont('Arial','B',10.5);
	$pdf->Cell( 20	,0.5,'Subject : Mandarin'		,'LRTB',0,L,true);
	$pdf->SetFont('Arial','',10.5);
	$pdf->Ln();
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 20	,0.5,'Pupil is able to:'		,'LRTB',0,L,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	
	
	
	$rMND='';
	$qMND 	="	SELECT 		t_learnrcd.*
				FROM 		t_learnrcd 
				WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							
							t_learnrcd.kde LIKE 'mnd%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
	$rMND =mysql_query($qMND);
	if(mysql_num_rows($rMND)=='0')
	{
		$qMND 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'mnd%' ";
		$rMND =mysql_query($qMND);
	}
	
	
	/*$qMND 	="	SELECT 		t_lrcd.*
				FROM 		t_lrcd 
				WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
							t_lrcd.kde LIKE 'mnd%' "; 		// ORDER BY	t_lrcd.
	$rMND =mysql_query($qMND);*/
	$no=1;
	$strnli='';
	while($dMND = mysql_fetch_array($rMND))
	{
		$cell[$j][4]=$dMND[nmektr];
		$nmektr	=$cell[$j][4];
		
		$query2	="	SELECT 		t_learnrcd_sd.*
					FROM 		t_learnrcd_sd
					WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
								t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd_sd.kdeplj	='MND' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
		$result2 =mysql_query($query2);
		$data2=mysql_fetch_array($result2);
		
		$cMND[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
		$nli	=$cMND[$no][5];
		
		if($nli==5)
			$strnli='Exceeds expectation';
		else if($nli==4)
			$strnli='Meets expectation';
		else if($nli==3)
			$strnli='Progressing in the desired competency';
		else if($nli==2)
			$strnli='Emerging in the desired competency';
		else if($nli==1)
			$strnli='Not Yet Demonstrated/Observed';
		else //if($nli==0)
			$strnli='# N / A';
		
		$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
		$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
		
		if($nli==5 OR $nli==4 OR $nli==0)
			$pdf->SetFont('Arial','',10.5);
		else //if($nli==3 OR $nli==2 OR $nli==1)
			$pdf->SetFont('Arial','',6);
		
		$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
		$pdf->Ln();

		$j++;
		$no++;
	}
	
	
	
	//..
	
	
	
	if($kdekls=='P-1A' OR $kdekls=='P-1B' OR $kdekls=='P-1C')// OR $kdekls=='P-2A' OR $kdekls=='P-2B' OR $kdekls=='P-2C'
	{
		
	}
	else
	{
		//com
		$pdf->SetFillColor(255,255,0);
		$pdf->SetFont('Arial','B',10.5);
		$pdf->Cell( 20	,0.5,'Subject : Computer Education'		,'LRTB',0,L,true);
		$pdf->SetFont('Arial','',10.5);
		$pdf->Ln();
		$pdf->SetFillColor(204,204,204);
		$pdf->Cell( 20	,0.5,'Pupil is able to:'		,'LRTB',0,L,true);
		$pdf->SetFillColor(255,255,255);
		$pdf->Ln();
		
	
	
		$rCOM='';
		$qCOM 	="	SELECT 		t_learnrcd.*
					FROM 		t_learnrcd 
					WHERE		t_learnrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								
								t_learnrcd.kde LIKE 'com%' ";//t_learnrcd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
		$rCOM =mysql_query($qCOM);
		if(mysql_num_rows($rCOM)=='0')
		{
			$qCOM 	="	SELECT 		t_lrcd.*
						FROM 		t_lrcd 
						WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
									t_lrcd.kde LIKE 'com%' ";
			$rCOM =mysql_query($qCOM);
		}
		
		
		/*$qCOM 	="	SELECT 		t_lrcd.*
					FROM 		t_lrcd 
					WHERE		t_lrcd.kdekls	='". mysql_escape_string($kdekls)."' AND
								t_lrcd.kde LIKE 'com%' "; 		// ORDER BY	t_lrcd.
		$rCOM =mysql_query($qCOM);*/
		$no=1;
		$strnli='';
		while($dCOM = mysql_fetch_array($rCOM))
		{
			$cell[$j][4]=$dCOM[nmektr];
			$nmektr	=$cell[$j][4];
			
			$query2	="	SELECT 		t_learnrcd_sd.*
						FROM 		t_learnrcd_sd
						WHERE 		t_learnrcd_sd.nis	='". mysql_escape_string($nis)."' AND
									
									t_learnrcd_sd.kdekls	='". mysql_escape_string($kdekls)."' AND
									t_learnrcd_sd.kdeplj	='COM' ";//t_learnrcd_sd.thn_ajaran	='". mysql_escape_string($thn_ajr)."' AND
			$result2 =mysql_query($query2);
			$data2=mysql_fetch_array($result2);
			
			$cCOM[$no][5]=$data2['hw'."$sms"."$midtrm"."$no"];
			$nli	=$cCOM[$no][5];
			
			if($nli==5)
				$strnli='Exceeds expectation';
			else if($nli==4)
				$strnli='Meets expectation';
			else if($nli==3)
				$strnli='Progressing in the desired competency';
			else if($nli==2)
				$strnli='Emerging in the desired competency';
			else if($nli==1)
				$strnli='Not Yet Demonstrated/Observed';
			else //if($nli==0)
				$strnli='# N / A';
			
			$pdf->Cell( 1	,0.5,$no		,'LRTB',0,C,true);
			$pdf->Cell( 15	,0.5,$nmektr	,'LRTB',0,L,true);
			
			if($nli==5 OR $nli==4 OR $nli==0)
				$pdf->SetFont('Arial','',10.5);
			else //if($nli==3 OR $nli==2 OR $nli==1)
				$pdf->SetFont('Arial','',6);
			
			$pdf->Cell( 4	,0.5,$strnli		,'LRTB',0,L,true);
			$pdf->Ln();

			$j++;
			$no++;
		}
	}
	//..sampai sini
	
	
	
	if($kdekls=='P-1A' OR $kdekls=='P-1B' OR $kdekls=='P-1C' OR $kdekls=='P-4A' OR $kdekls=='P-4B' OR $kdekls=='P-4C')
	{
		$pdf->Ln();
		$pdf->Cell(20   ,0,'',1); 	
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$pdf->Cell( 5	,0.4,$nmassw.' - Term '.$midtrm);
		$pdf->Cell(15  	,0.4,'Page : 2 ',0,0,R);
	}
	else if($kdekls=='P-2A' OR $kdekls=='P-2B' OR $kdekls=='P-2C')
	{
		$pdf->Ln();
		$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 6.35,0.6,'','',0,C,true);
		$pdf->Cell( 0.25,0.6,'',0,0,C,true);
		$pdf->Cell( 0.75,0.6,'',0,0,C,true);
		$pdf->Cell( 1.35,0.6,'','',0,C,true);
		$pdf->Cell( 1.6,0.6,'Issued by:',0,0,L);
		
		$pdf->Ln();
		$pdf->Ln(0.6);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,false);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->SetFont('Arial','BU',10.5);
		$pdf->Cell( 7.1	,0.6,'  '.$wlikls.$gelar.'  ',0,0,C,true);
		$pdf->SetFont('Arial','',10.5);
		
		$pdf->Ln(0.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.6,''.'Homeroom Adviser',0,0,C,true);
		$pdf->Ln();
		
		$pdf->Ln();
		$pdf->Cell(20   ,0,'',1); 	
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$pdf->Cell( 5	,0.4,$nmassw.' - Term '.$midtrm);
		$pdf->Cell(15  	,0.4,'Page : 2 ',0,0,R);
	}
	else
	{
		$pdf->Ln();
		$pdf->SetFont('Arial','',10.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 6.35,0.6,'','',0,C,true);
		$pdf->Cell( 0.25,0.6,'',0,0,C,true);
		$pdf->Cell( 0.75,0.6,'',0,0,C,true);
		$pdf->Cell( 1.35,0.6,'','',0,C,true);
		$pdf->Cell( 1.6,0.6,'Issued by:',0,0,L);
		
		$pdf->Ln();
		$pdf->Ln(0.6);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,false);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->SetFont('Arial','BU',10.5);
		$pdf->Cell( 7.1	,0.6,'  '.$wlikls.$gelar.'  ',0,0,C,true);
		$pdf->SetFont('Arial','',10.5);
		
		$pdf->Ln(0.5);
		$pdf->Cell( 3	,0.4,'',0,0,L);
		$pdf->Cell( 1.25	,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
		$pdf->Cell( 2.3,0.4,'',0,0,L);
		$pdf->Cell( 7.1	,0.6,''.'Homeroom Adviser',0,0,C,true);
		$pdf->Ln();
		
		$pdf->Ln();
		$pdf->Cell(20   ,0,'',1); 	
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$pdf->Cell( 5	,0.4,$nmassw.' - Term '.$midtrm);
		$pdf->Cell(15  	,0.4,'Page : 3 ',0,0,R);
	}
	
	
	
	//..
	
	
	
	//..
	
	
	
	
	$y++;
	
}//cetak all



$pdf->Output();

?>