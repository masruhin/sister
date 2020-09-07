<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04PSMP_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) rapot smp 8-9
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
	$tglctk	=date('F d, Y');
}
else
{	
	$tglctk	=strtotime($tglctk);
	$tglctk	=date('F d, Y',$tglctk);
}


//untuk Q1 Q2 rapot 8-9


if( $sms=='1' AND $midtrm=='1' )
	echo"<meta http-equiv='refresh' content=\"0;url=R1D04PSMP2_C01.php?kdekls=$kdekls&sms=$sms&midtrm=$midtrm&thn_ajr=$thn_ajr\">\n";
else if( $sms=='2' AND $midtrm=='1' )
	echo"<meta http-equiv='refresh' content=\"0;url=R1D04PSMP3_C01.php?kdekls=$kdekls&sms=$sms&midtrm=$midtrm&thn_ajr=$thn_ajr\">\n";
//else if( $sms=='2' AND $midtrm=='2' )
	//echo"<meta http-equiv='refresh' content=\"0;url=R1D04PSMP4_C01.php?kdekls=$kdekls&sms=$sms&midtrm=$midtrm\">\n";



// dapatkan data tahun ajaran
$query	="	SELECT 		t_setthn_smp.*
			FROM 		t_setthn_smp
			WHERE		t_setthn_smp.set='Tahun Ajaran'"; // menghasilka tahun ajaran
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
		$query3 	="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE 		t_prgrptps_smp.nis='". mysql_escape_string($nis)."'	AND
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
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
									t_prgrptps_smp.thn_ajaran='". mysql_escape_string($thn_ajr)."'	AND
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
	$tgllhr	=date('F d, Y',$tgllhr);

	$query4	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$nis' AND 
							t_hdrkmnps.thn_ajaran='$thn_ajr' "; // menghasilka absen per siswa
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
						WHERE		t_prgrptps_smp.nis='$nis' AND 
									t_prgrptps_smp.thn_ajaran='$thn_ajr' AND
									t_prgrptps_smp.kdeplj='$kdeplj'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$result2=mysql_query($query2) or die('Query gagal');
			$data2 =mysql_fetch_array($result2);
			
			$cell[$i][4]=$data2['akh'."$sms"."1"];
			$cell[$i][5]=$data2['akh'."$sms"."2"];
			$cell[$i][6]=number_format(($cell[$i][4]+$cell[$i][5])/2,0,',','.');
			$nliakh		=$cell[$i][6];
			
			$cell[$i][7]=$data2['akh'."1"."1"]; // q1
			$cell[$i][8]=$data2['akh'."1"."2"]; // q2
			$cell[$i][9] = $data2['akh'."2"."1"];//q3
			//$cell[$i][10] = $data2['akh'."2"."2"];//q4

			$cell[$i][11]=$data2['aff'."1"."1"]; // aff1
			$cell[$i][12]=$data2['aff'."1"."2"]; // aff2
			$cell[$i][13] = $data2['aff'."2"."1"];//aff3
			//$cell[$i][14] = $data2['aff'."2"."2"];//aff4
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
	$pdf->Ln(0.75);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(16.5	,0.4, $judul,0,0,C); // 19
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
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
	$pdf->Cell( 1	,0.4,"  Junior High",0,0,L); 
	$pdf->Ln(0.5);
	$pdf->Cell( 1	,0.4,"                                  First Semester",0,0,L); 
	$pdf->Cell( 1	,0.4,"                                                                                                                                        Second Semester",0,0,L); 
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1.5	,0.4);
	$pdf->Cell( 1	,0.4,$strX11,'LRTB',0,C,true);
	$pdf->Cell( 0.4	,0.4);
	$pdf->Cell( 1	,0.4,"Mid",0,0,L); 
	$pdf->Cell( 0.24,0.4);
	$pdf->Cell( 1	,0.4,$strX12,'LRTB',0,C,true);
	$pdf->Cell( 0.4	,0.4);
	$pdf->Cell( 1	,0.4,"Final",0,0,L); 
	
	$pdf->Cell( 4	,0.4);
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
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.6	,0.8,'No','LRTB',0,C,true);
	$pdf->Cell( 5.7	,0.8,'SUBJECT','LRTB',0,C,true); // 6.2
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
	
	while ($id<99)
	{
		//menampilkan data dari hasil query database
		$nmasbj	=$cell[$j][1];
		$kdeplj	=$cell[$j][2];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		$q1		=$cell[$j][7];
		$q2		=$cell[$j][8];
		$q3		=$cell[$j][9];
		//$q4		=$cell[$j][10];
		
		if($q2=='0')
			$av1	= $q1;
		else
			$av1	= number_format( ($q1 + $q2) / 2 ,0,',','.');//$av1
		
		$aff1		=$cell[$j][11];
		$aff2		=$cell[$j][12];
		$aff3		=$cell[$j][13];
		//$aff4		=$cell[$j][14];
		
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
				
				/*if(substr($nmasbj,0,1)!='=')
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
				*/
				
			}	
			
			
			
			//$pdf->Cell( 2	,0.5,$kkm,'LRTB',0,C,true);			//kkm A
			
			
			
			$qBLGY ="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE		t_prgrptps_smp.nis='$nis'		AND
									t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
									t_prgrptps_smp.kdeplj='BLGY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rBLGY=mysql_query($qBLGY) or die('Query gagal');
			$dBLGY =mysql_fetch_array($rBLGY);
			
			$q1BLGY=$dBLGY['akh'."1"."1"]; // q1
			$q2BLGY=$dBLGY['akh'."1"."2"]; // q2
			
			$aff1BLGY=$dBLGY['aff'."1"."1"]; // aff1
			$aff2BLGY=$dBLGY['aff'."1"."2"]; // aff2
			
			$qPHY ="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE		t_prgrptps_smp.nis='$nis'		AND
									t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
									t_prgrptps_smp.kdeplj='PHY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rPHY=mysql_query($qPHY) or die('Query gagal');
			$dPHY =mysql_fetch_array($rPHY);
			
			$q1PHY=$dPHY['akh'."1"."1"]; // q1
			$q2PHY=$dPHY['akh'."1"."2"]; // q2
			
			$aff1PHY=$dPHY['aff'."1"."1"]; // aff1
			$aff2PHY=$dPHY['aff'."1"."2"]; // aff2
			
			//$aff1IPA='';
			
			$q1IPA = number_format( ( $q1BLGY + $q1PHY ) / 2);
			$q2IPA = number_format( ( $q2BLGY + $q2PHY ) / 2);
			
			if ( $kdeplj == 'IPA' )
			{
				$q1 = $q1IPA;
				$q2 = $q2IPA;
			}
			
			$qECN ="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE		t_prgrptps_smp.nis='$nis'		AND
									t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
									t_prgrptps_smp.kdeplj='ECN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rECN=mysql_query($qECN) or die('Query gagal');
			$dECN =mysql_fetch_array($rECN);
			
			$q1ECN=$dECN['akh'."1"."1"]; // q1
			$q2ECN=$dECN['akh'."1"."2"]; // q2
			
			$aff1ECN=$dECN['aff'."1"."1"]; // aff1
			$aff2ECN=$dECN['aff'."1"."2"]; // aff2
			
			$qHIST ="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE		t_prgrptps_smp.nis='$nis'		AND
									t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
									t_prgrptps_smp.kdeplj='HIST'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rHIST=mysql_query($qHIST) or die('Query gagal');
			$dHIST =mysql_fetch_array($rHIST);
			
			$q1HIST=$dHIST['akh'."1"."1"]; // q1
			$q2HIST=$dHIST['akh'."1"."2"]; // q2
			
			$aff1HIST=$dHIST['aff'."1"."1"]; // aff1
			$aff2HIST=$dHIST['aff'."1"."2"]; // aff2
			
			$qGGRY ="	SELECT 		t_prgrptps_smp.*
						FROM 		t_prgrptps_smp
						WHERE		t_prgrptps_smp.nis='$nis'		AND
									t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
									t_prgrptps_smp.kdeplj='GGRY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rGGRY=mysql_query($qGGRY) or die('Query gagal');
			$dGGRY =mysql_fetch_array($rGGRY);
			
			$q1GGRY=$dGGRY['akh'."1"."1"]; // q1
			$q2GGRY=$dGGRY['akh'."1"."2"]; // q2
			
			$aff1GGRY=$dGGRY['aff'."1"."1"]; // aff1
			$aff2GGRY=$dGGRY['aff'."1"."2"]; // aff2
			
			$q1IPS = number_format( ( $q1ECN + $q1HIST + $q1GGRY ) / 3);
			$q2IPS = number_format( ( $q2ECN + $q2HIST + $q2GGRY ) / 3);
			
			if ( $kdeplj == 'IPS' )
			{
				$q1 = $q1IPS;
				$q2 = $q2IPS;
			}
			
			
			
			
			
			
			
			
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
					else
					{
						$av1 = ( $q1IPA + $q2IPA ) / 2;
					}
				}
				else if( $kdeplj=='IPS' )
				{
					if( $q2==0 )
					{
						$av1 = $q1IPS;
					}
					else
					{
						$av1 = ( $q1IPS + $q2IPS ) / 2;
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
			
			
			
			//q1
			if($q1<$kkm)
			{
				//$q1 = 'DF';
			}
			
			
			//q2
			if($q2<$kkm)
			{
				//$q2 = 'DF';
			}
			
			//q3
			if($q3<$kkm)
			{
				//$q3 = 'DF';
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
					if($aff2 > $aff1)
					{
						if($aff2>100)
							$lg1 = 'ERR';
						else if($aff2>=85)
							$lg1 = 'A';
						else if($aff2>=70)
							$lg1 = 'B';
						else if($aff2>=60)
							$lg1 = 'C';
						else
							$lg1 = 'D';
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
			
			
			
			if($av1<$kkm)
			{
				//$av1 = 'DF';
			}
			if($av1<$kkm)
			{
				//$av1 = 'DF';
			}
			
			
			
			//..
			/**/
			
			
			
			//..
			/**/
			//..
			
			
			
			$pdf->SetTextColor(0,0,0);
			
			
		}	
		$j++;
		$id=$cell[$j][0];
	}
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//rlg
	$qRLG ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='RLG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rRLG=mysql_query($qRLG) or die('Query gagal');
	$dRLG =mysql_fetch_array($rRLG);
	
	$akh11RLG=$dRLG['akh'."1"."1"]; // q1
	$akh12RLG=$dRLG['akh'."1"."2"]; // q2
	$akh21RLG = $dRLG['akh'."2"."1"];//q3
	//akh22RLG = $dRLG['akh'."2"."2"];//q4

	$aff11RLG=$dRLG['aff'."1"."1"]; // aff1
	$aff12RLG=$dRLG['aff'."1"."2"]; // aff2
	$aff21RLG = $dRLG['aff'."2"."1"];//aff3
	//$aff22RLG = $dRLG['aff'."2"."2"];//aff4
	
	$av1RLG = number_format( ( $akh11RLG + $akh12RLG ) / 2 ,0,',','.');
	
	if($aff12RLG>100)
		$lg1 = 'ERR';
	else if($aff12RLG>=85)
		$lg1 = 'A';
	else if($aff12RLG>=70)
		$lg1 = 'B';
	else if($aff12RLG>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2RLG = $akh21RLG;
	
	if($aff21RLG>100)
		$lg2 = 'ERR';
	else if($aff21RLG>=85)
		$lg2 = 'A';
	else if($aff21RLG>=70)
		$lg2 = 'B';
	else if($aff21RLG>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11RLG < 70)//$kkmRLG
		//$akh11RLG = 'DF';
	if($akh12RLG < 70)//$kkmRLG
		//$akh12RLG = 'DF';
	if($akh21RLG < 70)//$kkmRLG
		//$akh21RLG = 'DF';
	
	if($av1RLG < 70)//$kkmRLG
		//$av1RLG = 'DF';
	if($av2RLG < 70)//$kkmRLG
		//$av2RLG = 'DF';
	
	if($akh21RLG == 'DF')
		$akh21RLG = '';
	if($av2RLG == 'DF')
		$av2RLG = '';
	
	$pdf->Cell(0.6	,0.5,'1','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Religion','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'72','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11RLG,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12RLG,'LRTB',0,C,true);//$q2
	$pdf->Cell( 1	,0.5,$av1RLG,'LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,$lg1,'LRTB',0,C,true);//$lg1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	
	
	
	$pdf->Ln();
	
	
	
	//CME
	$qCME ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='CME'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rCME=mysql_query($qCME) or die('Query gagal');
	$dCME =mysql_fetch_array($rCME);
	
	$akh11CME=$dCME['akh'."1"."1"]; // q1
	$akh12CME=$dCME['akh'."1"."2"]; // q2
	$akh21CME = $dCME['akh'."2"."1"];//q3
	//akh22CME = $dCME['akh'."2"."2"];//q4

	$aff11CME=$dCME['aff'."1"."1"]; // aff1
	$aff12CME=$dCME['aff'."1"."2"]; // aff2
	$aff21CME = $dCME['aff'."2"."1"];//aff3
	//$aff22CME = $dCME['aff'."2"."2"];//aff4
	
	$av1CME = number_format( ( $akh11CME + $akh12CME ) / 2 ,0,',','.');
	
	if($aff12CME>100)
		$lg1 = 'ERR';
	else if($aff12CME>=85)
		$lg1 = 'A';
	else if($aff12CME>=70)
		$lg1 = 'B';
	else if($aff12CME>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2CME = $akh21CME;
	
	if($aff21CME>100)
		$lg2 = 'ERR';
	else if($aff21CME>=85)
		$lg2 = 'A';
	else if($aff21CME>=70)
		$lg2 = 'B';
	else if($aff21CME>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11CME < 70)//$kkmCME
		//$akh11CME = 'DF';
	if($akh12CME < 70)//$kkmCME
		//$akh12CME = 'DF';
	if($akh21CME < 70)//$kkmCME
		//$akh21CME = 'DF';
	
	if($av1CME < 70)//$kkmCME
		//$av1CME = 'DF';
	if($av2CME < 70)//$kkmCME
		//$av2CME = 'DF';
	
	if($akh21CME == 'DF')
		$akh21CME = '';
	if($av2CME == 'DF')
		$av2CME = '';
	
	$pdf->Cell(0.6	,0.5,'2','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Civics/Moral Education','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'72','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11CME,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12CME,'LRTB',0,C,true);//$q2
	$pdf->Cell( 1	,0.5,$av1CME,'LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,$lg1,'LRTB',0,C,true);//$lg1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	
	
	
	$pdf->Ln();
	
	
	
	//BIN
	$qBIN ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='BIN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rBIN=mysql_query($qBIN) or die('Query gagal');
	$dBIN =mysql_fetch_array($rBIN);
	
	$akh11BIN=$dBIN['akh'."1"."1"]; // q1
	$akh12BIN=$dBIN['akh'."1"."2"]; // q2
	$akh21BIN = $dBIN['akh'."2"."1"];//q3
	//akh22BIN = $dBIN['akh'."2"."2"];//q4

	$aff11BIN=$dBIN['aff'."1"."1"]; // aff1
	$aff12BIN=$dBIN['aff'."1"."2"]; // aff2
	$aff21BIN = $dBIN['aff'."2"."1"];//aff3
	//$aff22BIN = $dBIN['aff'."2"."2"];//aff4
	
	$av1BIN = number_format( ( $akh11BIN + $akh12BIN ) / 2 ,0,',','.');
	
	if($aff12BIN>100)
		$lg1 = 'ERR';
	else if($aff12BIN>=85)
		$lg1 = 'A';
	else if($aff12BIN>=70)
		$lg1 = 'B';
	else if($aff12BIN>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2BIN = $akh21BIN;
	
	if($aff21BIN>100)
		$lg2 = 'ERR';
	else if($aff21BIN>=85)
		$lg2 = 'A';
	else if($aff21BIN>=70)
		$lg2 = 'B';
	else if($aff21BIN>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11BIN < 70)//$kkmBIN
		//$akh11BIN = 'DF';
	if($akh12BIN < 70)//$kkmBIN
		//$akh12BIN = 'DF';
	if($akh21BIN < 70)//$kkmBIN
		//$akh21BIN = 'DF';
	
	if($av1BIN < 70)//$kkmBIN
		//$av1BIN = 'DF';
	if($av2BIN < 70)//$kkmBIN
		//$av2BIN = 'DF';
	
	if($akh21BIN == 'DF')
		$akh21BIN = '';
	if($av2BIN == 'DF')
		$av2BIN = '';
	
	$pdf->Cell(0.6	,0.5,'3','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Bahasa Indonesia','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11BIN,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12BIN,'LRTB',0,C,true);//$q2
	$pdf->Cell( 1	,0.5,$av1BIN,'LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,$lg1,'LRTB',0,C,true);//$lg1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	
	
	
	$pdf->Ln();
	
	
	
	//ENG
	$qENG ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='ENG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rENG=mysql_query($qENG) or die('Query gagal');
	$dENG =mysql_fetch_array($rENG);
	
	$akh11ENG=$dENG['akh'."1"."1"]; // q1
	$akh12ENG=$dENG['akh'."1"."2"]; // q2
	$akh21ENG = $dENG['akh'."2"."1"];//q3
	//akh22ENG = $dENG['akh'."2"."2"];//q4

	$aff11ENG=$dENG['aff'."1"."1"]; // aff1
	$aff12ENG=$dENG['aff'."1"."2"]; // aff2
	$aff21ENG = $dENG['aff'."2"."1"];//aff3
	//$aff22ENG = $dENG['aff'."2"."2"];//aff4
	
	$av1ENG = number_format( ( $akh11ENG + $akh12ENG ) / 2 ,0,',','.');
	
	if($aff12ENG>100)
		$lg1 = 'ERR';
	else if($aff12ENG>=85)
		$lg1 = 'A';
	else if($aff12ENG>=70)
		$lg1 = 'B';
	else if($aff12ENG>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2ENG = $akh21ENG;
	
	if($aff21ENG>100)
		$lg2 = 'ERR';
	else if($aff21ENG>=85)
		$lg2 = 'A';
	else if($aff21ENG>=70)
		$lg2 = 'B';
	else if($aff21ENG>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11ENG < 70)//$kkmENG
		//$akh11ENG = 'DF';
	if($akh12ENG < 70)//$kkmENG
		//$akh12ENG = 'DF';
	if($akh21ENG < 70)//$kkmENG
		//$akh21ENG = 'DF';
	
	if($av1ENG < 70)//$kkmENG
		//$av1ENG = 'DF';
	if($av2ENG < 70)//$kkmENG
		//$av2ENG = 'DF';
	
	if($akh21ENG == 'DF')
		$akh21ENG = '';
	if($av2ENG == 'DF')
		$av2ENG = '';
	
	$pdf->Cell(0.6	,0.5,'4','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'English','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11ENG,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12ENG,'LRTB',0,C,true);//$q2
	$pdf->Cell( 1	,0.5,$av1ENG,'LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,$lg1,'LRTB',0,C,true);//$lg1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	
	
	
	$pdf->Ln();
	
	
	
	//MTH
	$qMTH ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='MTH'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rMTH=mysql_query($qMTH) or die('Query gagal');
	$dMTH =mysql_fetch_array($rMTH);
	
	$akh11MTH=$dMTH['akh'."1"."1"]; // q1
	$akh12MTH=$dMTH['akh'."1"."2"]; // q2
	$akh21MTH = $dMTH['akh'."2"."1"];//q3
	//akh22MTH = $dMTH['akh'."2"."2"];//q4

	$aff11MTH=$dMTH['aff'."1"."1"]; // aff1
	$aff12MTH=$dMTH['aff'."1"."2"]; // aff2
	$aff21MTH = $dMTH['aff'."2"."1"];//aff3
	//$aff22MTH = $dMTH['aff'."2"."2"];//aff4
	
	$av1MTH = number_format( ( $akh11MTH + $akh12MTH ) / 2 ,0,',','.');
	
	if($aff12MTH>100)
		$lg1 = 'ERR';
	else if($aff12MTH>=85)
		$lg1 = 'A';
	else if($aff12MTH>=70)
		$lg1 = 'B';
	else if($aff12MTH>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2MTH = $akh21MTH;
	
	if($aff21MTH>100)
		$lg2 = 'ERR';
	else if($aff21MTH>=85)
		$lg2 = 'A';
	else if($aff21MTH>=70)
		$lg2 = 'B';
	else if($aff21MTH>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11MTH < 70)//$kkmMTH
		//$akh11MTH = 'DF';
	if($akh12MTH < 70)//$kkmMTH
		//$akh12MTH = 'DF';
	if($akh21MTH < 70)//$kkmMTH
		//$akh21MTH = 'DF';
	
	if($av1MTH < 70)//$kkmMTH
		//$av1MTH = 'DF';
	if($av2MTH < 70)//$kkmMTH
		//$av2MTH = 'DF';
	
	if($akh21MTH == 'DF')
		$akh21MTH = '';
	if($av2MTH == 'DF')
		$av2MTH = '';
	
	$pdf->Cell(0.6	,0.5,'5','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Mathematics','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11MTH,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12MTH,'LRTB',0,C,true);//$q2
	$pdf->Cell( 1	,0.5,$av1MTH,'LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,$lg1,'LRTB',0,C,true);//$lg1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	
	
	
	$pdf->Ln();
	
	
	
	
	
	//BLGY
	$qBLGY ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='BLGY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rBLGY=mysql_query($qBLGY) or die('Query gagal');
	$dBLGY =mysql_fetch_array($rBLGY);
	
	$akh11BLGY=$dBLGY['akh'."1"."1"]; // q1
	$akh12BLGY=$dBLGY['akh'."1"."2"]; // q2
	$akh21BLGY = $dBLGY['akh'."2"."1"];//q3
	//akh22BLGY = $dBLGY['akh'."2"."2"];//q4

	$aff11BLGY=$dBLGY['aff'."1"."1"]; // aff1
	$aff12BLGY=$dBLGY['aff'."1"."2"]; // aff2
	$aff21BLGY = $dBLGY['aff'."2"."1"];//aff3
	//$aff22BLGY = $dBLGY['aff'."2"."2"];//aff4
	
	//PHY
	$qPHY ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='PHY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rPHY=mysql_query($qPHY) or die('Query gagal');
	$dPHY =mysql_fetch_array($rPHY);
	
	$akh11PHY=$dPHY['akh'."1"."1"]; // q1
	$akh12PHY=$dPHY['akh'."1"."2"]; // q2
	$akh21PHY = $dPHY['akh'."2"."1"];//q3
	//akh22PHY = $dPHY['akh'."2"."2"];//q4

	$aff11PHY=$dPHY['aff'."1"."1"]; // aff1
	$aff12PHY=$dPHY['aff'."1"."2"]; // aff2
	$aff21PHY = $dPHY['aff'."2"."1"];//aff3
	//$aff22PHY = $dPHY['aff'."2"."2"];//aff4
	
	//IPA
	$q1IPA =  number_format( ($akh11BLGY + $akh11PHY) / 2 ,0,',','.');
	$q2IPA =  number_format( ($akh12BLGY + $akh12PHY) / 2 ,0,',','.');
	$q3IPA =  number_format( ($akh21BLGY + $akh21PHY) / 2 ,0,',','.');
	$av1IPA = number_format( ($q1IPA + $q2IPA) / 2 ,0,',','.');
	
	if($q1IPA < 70)//$kkmMTH
		//$q1IPA = 'DF';
	if($q2IPA < 70)//$kkmMTH
		//$q2IPA = 'DF';
	if($q3IPA < 70)//$kkmMTH
		//$q3IPA = 'DF';
	if($av1IPA < 70)//$kkmMTH
		//$av1IPA = 'DF';
	
	if($q3IPA == 'DF')//$kkmMTH
		$q3IPA = '';
		
	$av2IPA = $q3IPA;
	
	if($av1IPA>100)
		$lg1 = 'ERR';
	else if($av1IPA>=85)
		$lg1 = 'A';
	else if($av1IPA>=70)
		$lg1 = 'B';
	else if($av1IPA>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	if($av2IPA>100)
		$lg2 = 'ERR';
	else if($av2IPA>=85)
		$lg2 = 'A';
	else if($av2IPA>=70)
		$lg2 = 'B';
	else if($av2IPA>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(0.6	,0.5,'6','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Natural Science (IPA)','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$q1IPA,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$q2IPA,'LRTB',0,C,true);//$q2
	$pdf->Cell( 1	,0.5,$av1IPA,'LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,$lg1,'LRTB',0,C,true);//$lg1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	$pdf->SetFont('Arial','',8);
	
	
	
	$pdf->Ln();
	
	
	
	//BLGY
	
	$av1BLGY = number_format( ( $akh11BLGY + $akh12BLGY ) / 2 ,0,',','.');
	
	if($aff12BLGY>100)
		$lg1 = 'ERR';
	else if($aff12BLGY>=85)
		$lg1 = 'A';
	else if($aff12BLGY>=70)
		$lg1 = 'B';
	else if($aff12BLGY>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2BLGY = $akh21BLGY;
	
	if($aff21BLGY>100)
		$lg2 = 'ERR';
	else if($aff21BLGY>=85)
		$lg2 = 'A';
	else if($aff21BLGY>=70)
		$lg2 = 'B';
	else if($aff21BLGY>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11BLGY < 70)//$kkmBLGY
		//$akh11BLGY = 'DF';
	if($akh12BLGY < 70)//$kkmBLGY
		//$akh12BLGY = 'DF';
	if($akh21BLGY < 70)//$kkmBLGY
		//$akh21BLGY = 'DF';
	
	if($av1BLGY < 70)//$kkmBLGY
		//$av1BLGY = 'DF';
	if($av2BLGY < 70)//$kkmBLGY
		//$av2BLGY = 'DF';
	
	if($akh21BLGY == 'DF')
		$akh21BLGY = '';
	if($av2BLGY == 'DF')
		$av2BLGY = '';
	
	$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'       Biology','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11BLGY,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12BLGY,'LRTB',0,C,true);//$q2
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg1
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	$pdf->SetFillColor(255,255,255);
	
	
	
	$pdf->Ln();
	
	
	
	//PHY
	
	$av1PHY = number_format( ( $akh11PHY + $akh12PHY ) / 2 ,0,',','.');
	
	if($aff12PHY>100)
		$lg1 = 'ERR';
	else if($aff12PHY>=85)
		$lg1 = 'A';
	else if($aff12PHY>=70)
		$lg1 = 'B';
	else if($aff12PHY>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2PHY = $akh21PHY;
	
	if($aff21PHY>100)
		$lg2 = 'ERR';
	else if($aff21PHY>=85)
		$lg2 = 'A';
	else if($aff21PHY>=70)
		$lg2 = 'B';
	else if($aff21PHY>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11PHY < 70)//$kkmPHY
		//$akh11PHY = 'DF';
	if($akh12PHY < 70)//$kkmPHY
		//$akh12PHY = 'DF';
	if($akh21PHY < 70)//$kkmPHY
		//$akh21PHY = 'DF';
	
	if($av1PHY < 70)//$kkmPHY
		//$av1PHY = 'DF';
	if($av2PHY < 70)//$kkmPHY
		//$av2PHY = 'DF';
	
	if($akh21PHY == 'DF')
		$akh21PHY = '';
	if($av2PHY == 'DF')
		$av2PHY = '';
	
	$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'       Chemistry / Physics','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11PHY,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12PHY,'LRTB',0,C,true);//$q2
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg1
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	$pdf->SetFillColor(255,255,255);
	
	
	
	$pdf->Ln();
	
	
	
	
	
	//ECN
	$qECN ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='ECN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rECN=mysql_query($qECN) or die('Query gagal');
	$dECN =mysql_fetch_array($rECN);
	
	$akh11ECN=$dECN['akh'."1"."1"]; // q1
	$akh12ECN=$dECN['akh'."1"."2"]; // q2
	$akh21ECN = $dECN['akh'."2"."1"];//q3
	//akh22ECN = $dECN['akh'."2"."2"];//q4

	$aff11ECN=$dECN['aff'."1"."1"]; // aff1
	$aff12ECN=$dECN['aff'."1"."2"]; // aff2
	$aff21ECN = $dECN['aff'."2"."1"];//aff3
	//$aff22ECN = $dECN['aff'."2"."2"];//aff4
	
	//HIST
	$qHIST ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='HIST'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rHIST=mysql_query($qHIST) or die('Query gagal');
	$dHIST =mysql_fetch_array($rHIST);
	
	$akh11HIST=$dHIST['akh'."1"."1"]; // q1
	$akh12HIST=$dHIST['akh'."1"."2"]; // q2
	$akh21HIST = $dHIST['akh'."2"."1"];//q3
	//akh22HIST = $dHIST['akh'."2"."2"];//q4

	$aff11HIST=$dHIST['aff'."1"."1"]; // aff1
	$aff12HIST=$dHIST['aff'."1"."2"]; // aff2
	$aff21HIST = $dHIST['aff'."2"."1"];//aff3
	//$aff22HIST = $dHIST['aff'."2"."2"];//aff4
	
	//GGRY
	$qGGRY ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='GGRY'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rGGRY=mysql_query($qGGRY) or die('Query gagal');
	$dGGRY =mysql_fetch_array($rGGRY);
	
	$akh11GGRY=$dGGRY['akh'."1"."1"]; // q1
	$akh12GGRY=$dGGRY['akh'."1"."2"]; // q2
	$akh21GGRY = $dGGRY['akh'."2"."1"];//q3
	//akh22GGRY = $dGGRY['akh'."2"."2"];//q4

	$aff11GGRY=$dGGRY['aff'."1"."1"]; // aff1
	$aff12GGRY=$dGGRY['aff'."1"."2"]; // aff2
	$aff21GGRY = $dGGRY['aff'."2"."1"];//aff3
	//$aff22GGRY = $dGGRY['aff'."2"."2"];//aff4
	
	//IPS
	
	$q1IPS =  number_format( ($akh11ECN + $akh11HIST + $akh11GGRY) / 3 ,0,',','.');
	$q2IPS =  number_format( ($akh12ECN + $akh12HIST + $akh12GGRY) / 3 ,0,',','.');
	$q3IPS =  number_format( ($akh21ECN + $akh21HIST + $akh21GGRY) / 3 ,0,',','.');
	$av1IPS = number_format( ($q1IPS + $q2IPS) / 2 ,0,',','.');
	
	if($q1IPS < 70)//$kkmMTH
		//$q1IPS = 'DF';
	if($q2IPS < 70)//$kkmMTH
		//$q2IPS = 'DF';
	if($q3IPS < 70)//$kkmMTH
		//$q3IPS = 'DF';
	if($av1IPS < 70)//$kkmMTH
		//$av1IPS = 'DF';
		
	if($q3IPS == 'DF')//$kkmMTH
		$q3IPS = '';
		
	$av2IPS = $q3IPS;
	
	if($av1IPS>100)
		$lg1 = 'ERR';
	else if($av1IPS>=85)
		$lg1 = 'A';
	else if($av1IPS>=70)
		$lg1 = 'B';
	else if($av1IPS>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	if($av2IPS>100)
		$lg2 = 'ERR';
	else if($av2IPS>=85)
		$lg2 = 'A';
	else if($av2IPS>=70)
		$lg2 = 'B';
	else if($av2IPS>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(0.6	,0.5,'7','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Social Studies (IPS)','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$q1IPS,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$q2IPS,'LRTB',0,C,true);//$q2
	$pdf->Cell( 1	,0.5,$av1IPS,'LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,$lg1,'LRTB',0,C,true);//$lg1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	$pdf->SetFont('Arial','',8);
	
	
	
	$pdf->Ln();
	
	
	
	
	//ECN
	$av1ECN = number_format( ( $akh11ECN + $akh12ECN ) / 2 ,0,',','.');
	
	if($aff12ECN>100)
		$lg1 = 'ERR';
	else if($aff12ECN>=85)
		$lg1 = 'A';
	else if($aff12ECN>=70)
		$lg1 = 'B';
	else if($aff12ECN>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2ECN = $akh21ECN;
	
	if($aff21ECN>100)
		$lg2 = 'ERR';
	else if($aff21ECN>=85)
		$lg2 = 'A';
	else if($aff21ECN>=70)
		$lg2 = 'B';
	else if($aff21ECN>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11ECN < 70)//$kkmECN
		//$akh11ECN = 'DF';
	if($akh12ECN < 70)//$kkmECN
		//$akh12ECN = 'DF';
	if($akh21ECN < 70)//$kkmECN
		//$akh21ECN = 'DF';
	
	if($av1ECN < 70)//$kkmECN
		//$av1ECN = 'DF';
	if($av2ECN < 70)//$kkmECN
		//$av2ECN = 'DF';
	
	if($akh21ECN == 'DF')
		$akh21ECN = '';
	if($av2ECN == 'DF')
		$av2ECN = '';
	
	$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'       Economics','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11ECN,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12ECN,'LRTB',0,C,true);//$q2
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg1
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	$pdf->SetFillColor(255,255,255);
	
	
	
	$pdf->Ln();
	
	
	
	//HIST
	
	$av1HIST = number_format( ( $akh11HIST + $akh12HIST ) / 2 ,0,',','.');
	
	if($aff12HIST>100)
		$lg1 = 'ERR';
	else if($aff12HIST>=85)
		$lg1 = 'A';
	else if($aff12HIST>=70)
		$lg1 = 'B';
	else if($aff12HIST>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2HIST = $akh21HIST;
	
	if($aff21HIST>100)
		$lg2 = 'ERR';
	else if($aff21HIST>=85)
		$lg2 = 'A';
	else if($aff21HIST>=70)
		$lg2 = 'B';
	else if($aff21HIST>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11HIST < 70)//$kkmHIST
		//$akh11HIST = 'DF';
	if($akh12HIST < 70)//$kkmHIST
		//$akh12HIST = 'DF';
	if($akh21HIST < 70)//$kkmHIST
		//$akh21HIST = 'DF';
	
	if($av1HIST < 70)//$kkmHIST
		//$av1HIST = 'DF';
	if($av2HIST < 70)//$kkmHIST
		//$av2HIST = 'DF';
	
	if($akh21HIST == 'DF')
		$akh21HIST = '';
	if($av2HIST == 'DF')
		$av2HIST = '';
	
	$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'       History','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11HIST,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12HIST,'LRTB',0,C,true);//$q2
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg1
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	$pdf->SetFillColor(255,255,255);
	
	
	
	$pdf->Ln();
	
	
	
	//GGRY
	
	$av1GGRY = number_format( ( $akh11GGRY + $akh12GGRY ) / 2 ,0,',','.');
	
	if($aff12GGRY>100)
		$lg1 = 'ERR';
	else if($aff12GGRY>=85)
		$lg1 = 'A';
	else if($aff12GGRY>=70)
		$lg1 = 'B';
	else if($aff12GGRY>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2GGRY = $akh21GGRY;
	
	if($aff21GGRY>100)
		$lg2 = 'ERR';
	else if($aff21GGRY>=85)
		$lg2 = 'A';
	else if($aff21GGRY>=70)
		$lg2 = 'B';
	else if($aff21GGRY>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11GGRY < 70)//$kkmGGRY
		//$akh11GGRY = 'DF';
	if($akh12GGRY < 70)//$kkmGGRY
		//$akh12GGRY = 'DF';
	if($akh21GGRY < 70)//$kkmGGRY
		//$akh21GGRY = 'DF';
	
	if($av1GGRY < 70)//$kkmGGRY
		//$av1GGRY = 'DF';
	if($av2GGRY < 70)//$kkmGGRY
		//$av2GGRY = 'DF';
	
	if($akh21GGRY == 'DF')
		$akh21GGRY = '';
	if($av2GGRY == 'DF')
		$av2GGRY = '';
	
	$pdf->Cell(0.6	,0.5,'','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'       Geografy','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11GGRY,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12GGRY,'LRTB',0,C,true);//$q2
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg1
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	$pdf->SetFillColor(255,255,255);
	
	
	
	$pdf->Ln();
	
	
	
	//art
	$qART ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='ART'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rART=mysql_query($qART) or die('Query gagal');
	$dART =mysql_fetch_array($rART);
	
	$akh11ART=$dART['akh'."1"."1"]; // q1
	$akh12ART=$dART['akh'."1"."2"]; // q2
	$akh21ART = $dART['akh'."2"."1"];//q3
	//akh22ART = $dART['akh'."2"."2"];//q4

	$aff11ART=$dART['aff'."1"."1"]; // aff1
	$aff12ART=$dART['aff'."1"."2"]; // aff2
	$aff21ART = $dART['aff'."2"."1"];//aff3
	//$aff22ART = $dART['aff'."2"."2"];//aff4
	
	$av1ART = number_format( ( $akh11ART + $akh12ART ) / 2 ,0,',','.');
	
	if($aff12ART>100)
		$lg1 = 'ERR';
	else if($aff12ART>=85)
		$lg1 = 'A';
	else if($aff12ART>=70)
		$lg1 = 'B';
	else if($aff12ART>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2ART = $akh21ART;
	
	if($aff21ART>100)
		$lg2 = 'ERR';
	else if($aff21ART>=85)
		$lg2 = 'A';
	else if($aff21ART>=70)
		$lg2 = 'B';
	else if($aff21ART>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11ART < 70)//$kkmART
		//$akh11ART = 'DF';
	if($akh12ART < 70)//$kkmART
		//$akh12ART = 'DF';
	if($akh21ART < 70)//$kkmART
		//$akh21ART = 'DF';
	
	if($av1ART < 70)//$kkmART
		//$av1ART = 'DF';
	if($av2ART < 70)//$kkmART
		//$av2ART = 'DF';
	
	if($akh21ART == 'DF')
		$akh21ART = '';
	if($av2ART == 'DF')
		$av2ART = '';
	
	$pdf->Cell(0.6	,0.5,'8','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Cultural Art / Music','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11ART,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12ART,'LRTB',0,C,true);//$q2
	$pdf->Cell( 1	,0.5,$av1ART,'LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,$lg1,'LRTB',0,C,true);//$lg1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	
	
	
	$pdf->Ln();
	
	
	
	//pe
	$qPE ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='PE'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rPE=mysql_query($qPE) or die('Query gagal');
	$dPE =mysql_fetch_array($rPE);
	
	$akh11PE=$dPE['akh'."1"."1"]; // q1
	$akh12PE=$dPE['akh'."1"."2"]; // q2
	$akh21PE = $dPE['akh'."2"."1"];//q3
	//akh22PE = $dPE['akh'."2"."2"];//q4

	$aff11PE=$dPE['aff'."1"."1"]; // aff1
	$aff12PE=$dPE['aff'."1"."2"]; // aff2
	$aff21PE = $dPE['aff'."2"."1"];//aff3
	//$aff22PE = $dPE['aff'."2"."2"];//aff4
	
	$av1PE = number_format( ( $akh11PE + $akh12PE ) / 2 ,0,',','.');
	
	if($aff12PE>100)
		$lg1 = 'ERR';
	else if($aff12PE>=85)
		$lg1 = 'A';
	else if($aff12PE>=70)
		$lg1 = 'B';
	else if($aff12PE>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2PE = $akh21PE;
	
	if($aff21PE>100)
		$lg2 = 'ERR';
	else if($aff21PE>=85)
		$lg2 = 'A';
	else if($aff21PE>=70)
		$lg2 = 'B';
	else if($aff21PE>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11PE < 70)//$kkmPE
		//$akh11PE = 'DF';
	if($akh12PE < 70)//$kkmPE
		//$akh12PE = 'DF';
	if($akh21PE < 70)//$kkmPE
		//$akh21PE = 'DF';
	
	if($av1PE < 70)//$kkmPE
		//$av1PE = 'DF';
	if($av2PE < 70)//$kkmPE
		//$av2PE = 'DF';
	
	if($akh21PE == 'DF')
		$akh21PE = '';
	if($av2PE == 'DF')
		$av2PE = '';
	
	$pdf->Cell(0.6	,0.5,'9','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Physical Education & Health','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11PE,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12PE,'LRTB',0,C,true);//$q2
	$pdf->Cell( 1	,0.5,$av1PE,'LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,$lg1,'LRTB',0,C,true);//$lg1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	
	
	
	$pdf->Ln();
	
	
	
	//ICT
	$qICT ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='ICT'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rICT=mysql_query($qICT) or die('Query gagal');
	$dICT =mysql_fetch_array($rICT);
	
	$akh11ICT=$dICT['akh'."1"."1"]; // q1
	$akh12ICT=$dICT['akh'."1"."2"]; // q2
	$akh21ICT = $dICT['akh'."2"."1"];//q3
	//akh22ICT = $dICT['akh'."2"."2"];//q4

	$aff11ICT=$dICT['aff'."1"."1"]; // aff1
	$aff12ICT=$dICT['aff'."1"."2"]; // aff2
	$aff21ICT = $dICT['aff'."2"."1"];//aff3
	//$aff22ICT = $dICT['aff'."2"."2"];//aff4
	
	$av1ICT = number_format( ( $akh11ICT + $akh12ICT ) / 2 ,0,',','.');
	
	if($aff12ICT>100)
		$lg1 = 'ERR';
	else if($aff12ICT>=85)
		$lg1 = 'A';
	else if($aff12ICT>=70)
		$lg1 = 'B';
	else if($aff12ICT>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2ICT = $akh21ICT;
	
	if($aff21ICT>100)
		$lg2 = 'ERR';
	else if($aff21ICT>=85)
		$lg2 = 'A';
	else if($aff21ICT>=70)
		$lg2 = 'B';
	else if($aff21ICT>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11ICT < 70)//$kkmICT
		//$akh11ICT = 'DF';
	if($akh12ICT < 70)//$kkmICT
		//$akh12ICT = 'DF';
	if($akh21ICT < 70)//$kkmICT
		//$akh21ICT = 'DF';
	
	if($av1ICT < 70)//$kkmICT
		//$av1ICT = 'DF';
	if($av2ICT < 70)//$kkmICT
		//$av2ICT = 'DF';
		
	if($akh21ICT == 'DF')
		$akh21ICT = '';
	if($av2ICT == 'DF')
		$av2ICT = '';
	
	$pdf->Cell(0.6	,0.5,'10','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Information Technology','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11ICT,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12ICT,'LRTB',0,C,true);//$q2
	$pdf->Cell( 1	,0.5,$av1ICT,'LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,$lg1,'LRTB',0,C,true);//$lg1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	
	
	
	$pdf->Ln();
	
	
	
	//FOR
	$Foreign='';
	$dFOR ='';
	$qFOR ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='GRM'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rFOR=mysql_query($qFOR) or die('Query gagal');
	$dFOR =mysql_fetch_array($rFOR);
	$str1FOR	=$dFOR['akh'."1"."1"];
	$Foreign='German';
	
	if( $str1FOR=='0' )//mnd
	{
		$qFOR ="	SELECT 		t_prgrptps_smp.*
					FROM 		t_prgrptps_smp
					WHERE		t_prgrptps_smp.nis='$nis'		AND
								t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
								t_prgrptps_smp.kdeplj='MND'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
		$rFOR=mysql_query($qFOR) or die('Query gagal');
		$dFOR =mysql_fetch_array($rFOR);
		$Foreign='Mandarin';
	}
	
	$akh11FOR=$dFOR['akh'."1"."1"]; // q1
	$akh12FOR=$dFOR['akh'."1"."2"]; // q2
	$akh21FOR = $dFOR['akh'."2"."1"];//q3
	//akh22FOR = $dFOR['akh'."2"."2"];//q4

	$aff11FOR=$dFOR['aff'."1"."1"]; // aff1
	$aff12FOR=$dFOR['aff'."1"."2"]; // aff2
	$aff21FOR = $dFOR['aff'."2"."1"];//aff3
	//$aff22FOR = $dFOR['aff'."2"."2"];//aff4
	
	$av1FOR = number_format( ( $akh11FOR + $akh12FOR ) / 2 ,0,',','.');
	
	if($aff12FOR>100)
		$lg1 = 'ERR';
	else if($aff12FOR>=85)
		$lg1 = 'A';
	else if($aff12FOR>=70)
		$lg1 = 'B';
	else if($aff12FOR>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2FOR = $akh21FOR;
	
	if($aff21FOR>100)
		$lg2 = 'ERR';
	else if($aff21FOR>=85)
		$lg2 = 'A';
	else if($aff21FOR>=70)
		$lg2 = 'B';
	else if($aff21FOR>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11FOR < 70)//$kkmFOR
		//$akh11FOR = 'DF';
	if($akh12FOR < 70)//$kkmFOR
		//$akh12FOR = 'DF';
	if($akh21FOR < 70)//$kkmFOR
		//$akh21FOR = 'DF';
	
	if($av1FOR < 70)//$kkmFOR
		//$av1FOR = 'DF';
	if($av2FOR < 70)//$kkmFOR
		//$av2FOR = 'DF';
	
	if($akh21FOR == 'DF')
		$akh21FOR = '';
	if($av2FOR == 'DF')
		$av2FOR = '';
	
	$pdf->Cell(0.6	,0.5,'11','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'Foreign Language: '.$Foreign,'LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'70','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11FOR,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12FOR,'LRTB',0,C,true);//$q2
	$pdf->Cell( 1	,0.5,$av1FOR,'LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,$lg1,'LRTB',0,C,true);//$lg1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	
	
	
	$pdf->Ln();
	
	
	
	//PLKJ
	$qPLKJ ="	SELECT 		t_prgrptps_smp.*
				FROM 		t_prgrptps_smp
				WHERE		t_prgrptps_smp.nis='$nis'		AND
							t_prgrptps_smp.thn_ajaran='$thn_ajr'		AND
							t_prgrptps_smp.kdeplj='PLKJ'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
	$rPLKJ=mysql_query($qPLKJ) or die('Query gagal');
	$dPLKJ =mysql_fetch_array($rPLKJ);
	
	$akh11PLKJ=$dPLKJ['akh'."1"."1"]; // q1
	$akh12PLKJ=$dPLKJ['akh'."1"."2"]; // q2
	$akh21PLKJ = $dPLKJ['akh'."2"."1"];//q3
	//akh22PLKJ = $dPLKJ['akh'."2"."2"];//q4

	$aff11PLKJ=$dPLKJ['aff'."1"."1"]; // aff1
	$aff12PLKJ=$dPLKJ['aff'."1"."2"]; // aff2
	$aff21PLKJ = $dPLKJ['aff'."2"."1"];//aff3
	//$aff22PLKJ = $dPLKJ['aff'."2"."2"];//aff4
	
	$av1PLKJ = number_format( ( $akh11PLKJ + $akh12PLKJ ) / 2 ,0,',','.');
	
	if($aff12PLKJ>100)
		$lg1 = 'ERR';
	else if($aff12PLKJ>=85)
		$lg1 = 'A';
	else if($aff12PLKJ>=70)
		$lg1 = 'B';
	else if($aff12PLKJ>=60)
		$lg1 = 'C';
	else
		$lg1 = 'D';
	
	$av2PLKJ = $akh21PLKJ;
	
	if($aff21PLKJ>100)
		$lg2 = 'ERR';
	else if($aff21PLKJ>=85)
		$lg2 = 'A';
	else if($aff21PLKJ>=70)
		$lg2 = 'B';
	else if($aff21PLKJ>=60)
		$lg2 = 'C';
	else
		$lg2 = 'D';
	
	
	
	if($akh11PLKJ < 70)//$kkmPLKJ
		//$akh11PLKJ = 'DF';
	if($akh12PLKJ < 70)//$kkmPLKJ
		//$akh12PLKJ = 'DF';
	if($akh21PLKJ < 70)//$kkmPLKJ
		//$akh21PLKJ = 'DF';
	
	if($av1PLKJ < 70)//$kkmPLKJ
		//$av1PLKJ = 'DF';
	if($av2PLKJ < 70)//$kkmPLKJ
		//$av2PLKJ = 'DF';
	
	if($akh21PLKJ == 'DF')
		$akh21PLKJ = '';
	if($av2PLKJ == 'DF')
		$av2PLKJ = '';
	
	$pdf->Cell(0.6	,0.5,'11','LRTB',0,C,true);
	$pdf->Cell(5.7	,0.5,'PLKJ','LRTB',0,L,true);
	$pdf->Cell( 2	,0.5,'71','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,$akh11PLKJ,'LRTB',0,C,true);//$q1
	$pdf->Cell( 1	,0.5,$akh12PLKJ,'LRTB',0,C,true);//$q2
	$pdf->Cell( 1	,0.5,$av1PLKJ,'LRTB',0,C,true);//$av1
	$pdf->Cell( 1	,0.5,$lg1,'LRTB',0,C,true);//$lg1
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$q3
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$av2
	$pdf->Cell( 1	,0.5,'','LRTB',0,C,true);//$lg2
	
	
	$pdf->Ln();
	//$pdf->Ln();
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	$klm	=str_replace('And','and',ucwords(number_to_words($ttlakh)));
	
	$rtrt	=number_format($rtrt,0,',','.');
	$klm	=ucwords(number_to_words($rtrt));
	$rnk	=$cell5[$y][3];
	
	$pdf->Ln(0.25);
	
	
	
	$nmaPil1='';
	$ktrPil1='';
	$ktrPil1b='';
	$s1='';
	
	$nmaPil2='';
	$ktrPil2='';
	$ktrPil2b='';
	$s2='';
	
	$nmaPil3='';
	$ktrPil3='';
	$ktrPil3b='';
	$s3='';
	
	$nmaPil4='';
	$ktrPil4='';
	$ktrPil4b='';
	$s4='';
	
	$nmaPil5='';
	$ktrPil5='';
	$ktrPil5b='';
	$s5='';
	
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 8.3	,0.4,'Enrichment / Extra Curricular Activities','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q2'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,'Q3'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q4'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//basketball
	$qBSK	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='BSK' "; // extra kurikuler
	$rBSK=mysql_query($qBSK) or die('Query gagal40');
	$dBSK =mysql_fetch_array($rBSK);
	$q1BSK=$dBSK['ext'."1"."1"]; // q1 BSK
	$q2BSK=$dBSK['ext'."1"."2"]; // q2 BSK
	$q3BSK=$dBSK['ext'."2"."1"]; // q3 BSK
	if($q1BSK!='')
	{
		$nmaPil1='Basket Ball';
		$ktrPil1=$q1BSK;
		$s1=$q1BSK;
	}
	/*else//if($q1BSK=='')
	{
		$nmaPil1='Sport Interest(Basketball/Futsal/Table Tennis)';
		$ktrPil1='-';
		$s1='-';
	}*/
	if($q2BSK!='')
	{
		$nmaPil1='Basket Ball';
		$ktrPil1b=$q2BSK;
		$s1=$q2BSK;
	}
	/*else//if($q2BSK=='')
	{
		$nmaPil1='Sport Interest(Basketball/Futsal/Table Tennis)';
		$ktrPil1b='-';
		$s1='-';
	}*/
	if($q3BSK!='')
	{
		$nmaPil1='Basket Ball';
		$ktrPil1c=$q3BSK;
		$s1=$q3BSK;
	}
	/*else//if($q1BSK=='')
	{
		$nmaPil1='Sport Interest(Basketball/Futsal/Table Tennis)';
		$ktrPil1c='-';
		$s1='-';
	}*/
	//futsal
	$qFTS	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='FTS' "; // extra kurikuler
	$rFTS=mysql_query($qFTS) or die('Query gagal40');
	$dFTS =mysql_fetch_array($rFTS);
	$q1FTS=$dFTS['ext'."1"."1"]; // q1 FTS
	$q2FTS=$dFTS['ext'."1"."2"]; // q2 FTS
	$q3FTS=$dFTS['ext'."2"."1"]; // q3 FTS
	if($q1FTS!='')
	{
		$nmaPil1='Futsal';
		$ktrPil1=$q1FTS;
		$s1=$q1FTS;
	}
	if($q2FTS!='')
	{
		$nmaPil1='Futsal';
		$ktrPil1b=$q2FTS;
		$s1=$q2FTS;
	}
	if($q3FTS!='')
	{
		$nmaPil1='Futsal';
		$ktrPil1c=$q3FTS;
		$s1=$q3FTS;
	}
	//table tennis
	$qTNS	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='TNS' "; // extra kurikuler
	$rTNS=mysql_query($qTNS) or die('Query gagal40');
	$dTNS =mysql_fetch_array($rTNS);
	$q1TNS=$dTNS['ext'."1"."1"]; // q1 TNS
	$q2TNS=$dTNS['ext'."1"."2"]; // q2 TNS
	$q3TNS=$dTNS['ext'."2"."1"]; // q3 TNS
	if($q1TNS!='')
	{
		$nmaPil1='Table tennis';
		$ktrPil1=$q1TNS;
		$s1=$q1TNS;
	}
	if($q2TNS!='')
	{
		$nmaPil1='Table tennis';
		$ktrPil1b=$q2TNS;
		$s1=$q2TNS;
	}
	if($q3TNS!='')
	{
		$nmaPil1='Table tennis';
		$ktrPil1c=$q3TNS;
		$s1=$q3TNS;
	}
	/*if( $q1BSK=='' OR $q1FTS=='' OR $q1TNS=='' )
	{
		$nmaPil1='Sport Interest(Basketball/Futsal/Table Tennis)';
		$ktrPil1='-';
		$s1='-';
	}
	if( $q2BSK=='' OR $q2FTS=='' OR $q2TNS=='' )
	{
		$nmaPil1='Sport Interest(Basketball/Futsal/Table Tennis)';
		$ktrPil1b='-';
		$s1='-';
	}*/
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,$nmaPil1,'LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,$ktrPil1		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ktrPil1b		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$s1		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//culinari
	$qCLN	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='CLN' "; // extra kurikuler
	$rCLN=mysql_query($qCLN) or die('Query gagal40');
	$dCLN =mysql_fetch_array($rCLN);
	$q1CLN=$dCLN['ext'."1"."1"]; // q1 CLN
	$q2CLN=$dCLN['ext'."1"."2"]; // q2 CLN
	$q3CLN=$dCLN['ext'."2"."1"]; // q3 CLN
	if($q1CLN!='')
	{
		$nmaPil2='Culinary';
		$ktrPil2=$q1CLN;
		$s2=$q1CLN;
	}
	if($q2CLN!='')
	{
		$nmaPil2='Culinary';
		$ktrPil2b=$q2CLN;
		$s2=$q2CLN;
	}
	if($q3CLN!='')
	{
		$nmaPil2='Culinary';
		$ktrPil2c=$q3CLN;
		$s2=$q3CLN;
	}
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'2','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,$nmaPil2,'LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,$ktrPil2		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ktrPil2b		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$s2		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//music
	$qMSC	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='MSC' "; // extra kurikuler
	$rMSC=mysql_query($qMSC) or die('Query gagal40');
	$dMSC =mysql_fetch_array($rMSC);
	$q1MSC=$dMSC['ext'."1"."1"]; // q1 MSC
	$q2MSC=$dMSC['ext'."1"."2"]; // q2 MSC
	$q3MSC=$dMSC['ext'."2"."1"]; // q1 MSC
	if($q1MSC!='')
	{
		$nmaPil3='Music';
		$ktrPil3=$q1MSC;
		$s3=$q1MSC;
	}
	if($q2MSC!='')
	{
		$nmaPil3='Music';
		$ktrPil3b=$q2MSC;
		$s3=$q2MSC;
	}
	if($q3MSC!='')
	{
		$nmaPil3='Music';
		$ktrPil3c=$q3MSC;
		$s3=$q3MSC;
	}
	//dance
	$qMDR	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='MDR' "; // extra kurikuler
	$rMDR=mysql_query($qMDR) or die('Query gagal40');
	$dMDR =mysql_fetch_array($rMDR);
	$q1MDR=$dMDR['ext'."1"."1"]; // q1 MDR
	$q2MDR=$dMDR['ext'."1"."2"]; // q2 MDR
	$q3MDR=$dMDR['ext'."2"."1"]; // q3 MDR
	if($q1MDR!='')
	{
		$nmaPil3='Dance';
		$ktrPil3=$q1MDR;
		$s3=$q1MDR;
	}
	if($q2MDR!='')
	{
		$nmaPil3='Dance';
		$ktrPil3b=$q2MDR;
		$s3=$q2MDR;
	}
	if($q3MDR!='')
	{
		$nmaPil3='Dance';
		$ktrPil3c=$q3MDR;
		$s3=$q3MDR;
	}
	//THEAter art
	$qTHE	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='THE' "; // extra kurikuler
	$rTHE=mysql_query($qTHE) or die('Query gagal40');
	$dTHE =mysql_fetch_array($rTHE);
	$q1THE=$dTHE['ext'."1"."1"]; // q1 THE
	$q2THE=$dTHE['ext'."1"."2"]; // q2 THE
	$q3THE=$dTHE['ext'."2"."1"]; // q3 THE
	if( $kdekls != 'JHS-9A' AND $kdekls != 'JHS-9B' )
	{
		if($q1THE!='')
		{
			$nmaPil3='Theater Art';
			$ktrPil3=$q1THE;
			$s3=$q1THE;
		}
		if($q2THE!='')
		{
			$nmaPil3='Theater Art';
			$ktrPil3b=$q2THE;
			$s3=$q2THE;
		}
		if($q3THE!='')
		{
			$nmaPil3='Theater Art';
			$ktrPil3c=$q3THE;
			$s3=$q3THE;
		}
	}
	
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'3','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,$nmaPil3,'LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,$ktrPil3		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ktrPil3b		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$s3		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//Interest(Choir)
	$qCHO	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='CHO' "; // extra kurikuler
	$rCHO=mysql_query($qCHO) or die('Query gagal40');
	$dCHO =mysql_fetch_array($rCHO);
	$q1CHO=$dCHO['ext'."1"."1"]; // q1 CHO
	$q2CHO=$dCHO['ext'."1"."2"]; // q2 CHO
	$q3CHO=$dCHO['ext'."2"."1"]; // q3 CHO
	if($q1CHO!='')
	{
		$nmaPil4='Interest(Choir)';
		$ktrPil4=$q1CHO;
		$s4=$q1CHO;
	}
	if($q2CHO!='')
	{
		$nmaPil4='Interest(Choir)';
		$ktrPil4b=$q2CHO;
		$s4=$q2CHO;
	}
	if($q3CHO!='')
	{
		$nmaPil4='Interest(Choir)';
		$ktrPil4c=$q3CHO;
		$s4=$q3CHO;
	}
	//Interest(Scouting)
	$qSCO	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='SCO' "; // extra kurikuler
	$rSCO=mysql_query($qSCO) or die('Query gagal40');
	$dSCO =mysql_fetch_array($rSCO);
	$q1SCO=$dSCO['ext'."1"."1"]; // q1 SCO
	$q2SCO=$dSCO['ext'."1"."2"]; // q2 SCO
	$q3SCO=$dSCO['ext'."2"."1"]; // q3 SCO
	if($q1SCO!='')
	{
		$nmaPil4='Interest(Scouting)';
		$ktrPil4=$q1SCO;
		$s4=$q1SCO;
	}
	if($q2SCO!='')
	{
		$nmaPil4='Interest(Scouting)';
		$ktrPil4b=$q2SCO;
		$s4=$q2SCO;
	}
	if($q3SCO!='')
	{
		$nmaPil4='Interest(Scouting)';
		$ktrPil4c=$q3SCO;
		$s4=$q3SCO;
	}
	//Interest(Modern Dance)
	$qDNC	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='DNC' "; // extra kurikuler
	$rDNC=mysql_query($qDNC) or die('Query gagal40');
	$dDNC =mysql_fetch_array($rDNC);
	$q1DNC=$dDNC['ext'."1"."1"]; // q1 DNC
	$q2DNC=$dDNC['ext'."1"."2"]; // q2 DNC
	$q3DNC=$dDNC['ext'."2"."1"]; // q3 DNC
	if($q1DNC!='')
	{
		$nmaPil4='Interest(Modern Dance)';
		$ktrPil4=$q1DNC;
		$s4=$q1DNC;
	}
	if($q2DNC!='')
	{
		$nmaPil4='Interest(Modern Dance)';
		$ktrPil4b=$q2DNC;
		$s4=$q2DNC;
	}
	if($q3DNC!='')
	{
		$nmaPil4='Interest(Modern Dance)';
		$ktrPil4c=$q3DNC;
		$s4=$q3DNC;
	}
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'4','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,$nmaPil4,'LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,$ktrPil4		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ktrPil4b		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$s4		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//Interest(Science & Math Club/English Club)
	$qCLB	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='CLB' "; // extra kurikuler
	$rCLB=mysql_query($qCLB) or die('Query gagal40');
	$dCLB =mysql_fetch_array($rCLB);
	$q1CLB=$dCLB['ext'."1"."1"]; // q1 CLB
	$q2CLB=$dCLB['ext'."1"."2"]; // q2 CLB
	$q3CLB=$dCLB['ext'."2"."1"]; // q3 CLB
	if($q1CLB!='')
	{
		$nmaPil5='English Club';//
		$ktrPil5=$q1CLB;
		$s5=$q1CLB;
	}
	else//if($q1CLB=='')
	{
		$nmaPil5='Interest(Science & Math Club/English Club)';
		$ktrPil5='-';
		$s5='-';
	}
	if($q2CLB!='')
	{
		$nmaPil5='English Club';//Interest(Science & Math Club/English Club)
		$ktrPil5b=$q2CLB;
		$s5=$q2CLB;
	}
	else//if($q2CLB=='')
	{
		$nmaPil5='Interest(Science & Math Club/English Club)';
		$ktrPil5b='-';
		$s5='-';
	}
	if($q3CLB!='')
	{
		$nmaPil5='English Club';//
		$ktrPil5c=$q3CLB;
		$s5=$q3CLB;
	}
	else//if($q1CLB=='')
	{
		$nmaPil5='Interest(Science & Math Club/English Club)';
		$ktrPil5c='-';
		//$s5='-';
	}
	//cODINg BEE
	$qBEE	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='BEE' "; // extra kurikuler
	$rBEE=mysql_query($qBEE) or die('Query gagal40');
	$dBEE =mysql_fetch_array($rBEE);
	$q1BEE=$dBEE['ext'."1"."1"]; // q1 BEE
	$q2BEE=$dBEE['ext'."1"."2"]; // q2 BEE
	$q3BEE=$dBEE['ext'."2"."1"]; // q3 BEE
	if($q1BEE!='')
	{
		$nmaPil5='Interest(Science & Math Club/English Club/Coding Bee)';
		$ktrPil5=$q1BEE;
		$s5=$q1BEE;
	}
	
	if($q2BEE!='')
	{
		$nmaPil5='Interest(Science & Math Club/English Club/Coding Bee)';
		$ktrPil5b=$q2BEE;
		$s5=$q2BEE;
	}
	
	if($q3BEE!='')
	{
		$nmaPil5='Interest(Science & Math Club/English Club/Coding Bee)';
		$ktrPil5c=$q3BEE;
		$s5=$q3BEE;
	}
	
	//robotic
	$qRBT	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='RBT' "; // extra kurikuler
	$rRBT=mysql_query($qRBT) or die('Query gagal40');
	$dRBT =mysql_fetch_array($rRBT);
	$q1RBT=$dRBT['ext'."1"."1"]; // q1 RBT
	$q2RBT=$dRBT['ext'."1"."2"]; // q2 RBT
	$q3RBT=$dRBT['ext'."2"."1"]; // q3 RBT
	if($q1RBT!='')
	{
		$nmaPil5='Robotic';
		$ktrPil5=$q1RBT;
		$s5=$q1RBT;
	}
	if($q2RBT!='')
	{
		$nmaPil5='Robotic';
		$ktrPil5b=$q2RBT;
		$s5=$q2RBT;
	}
	if($q3RBT!='')
	{
		$nmaPil5='Robotic';
		$ktrPil5c=$q3RBT;
		$s5=$q3RBT;
	}
	//THEAter art
	/*$qTHE2	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj='THE' "; // extra kurikuler
	$rTHE2=mysql_query($qTHE2) or die('Query gagal40');
	$dTHE2 =mysql_fetch_array($rTHE2);
	$q1THE2=$dTHE2['ext'."1"."1"]; // q1 THE2
	$q2THE2=$dTHE2['ext'."1"."2"]; // q2 THE2
	$q3THE2=$dTHE2['ext'."2"."1"]; // q3 THE2
	if($q1THE2!='')
	{
		$nmaPil5='Theater Art';
		$ktrPil5=$q1THE2;
		$s5=$q1THE2;
	}
	if($q2THE2!='')
	{
		$nmaPil5='Theater Art';
		$ktrPil5b=$q2THE2;
		$s5=$q2THE2;
	}
	if($q3THE2!='')
	{
		$nmaPil5='Theater Art';
		$ktrPil5c=$q3THE2;
		$s5=$q1THE2;
	}*/
	//Mandarin club
	$qMNDC	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.thn_ajaran='$thn_ajr' 	AND
							t_extcrrps.kdeplj='MNDC' "; // extra kurikuler
	$rMNDC=mysql_query($qMNDC) or die('Query gagal40');
	$dMNDC =mysql_fetch_array($rMNDC);
	$q1MNDC=$dMNDC['ext'."1"."1"]; // q1 MNDC
	$q2MNDC=$dMNDC['ext'."1"."2"]; // q2 MNDC
	$q3MNDC=$dMNDC['ext'."2"."1"]; // q3 MNDC
	if($q1MNDC!='')
	{
		$nmaPil5='Mandarin Club';
		$ktrPil5=$q1MNDC;
		$s5=$q1MNDC;
	}
	if($q2MNDC!='')
	{
		$nmaPil5='Mandarin Club';
		$ktrPil5b=$q2MNDC;
		$s5=$q2MNDC;
	}
	if($q3MNDC!='')
	{
		$nmaPil5='Mandarin Club';
		$ktrPil5c=$q3MNDC;
		$s5=$q3MNDC;
	}
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'5','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,$nmaPil5,'LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,$ktrPil5		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$ktrPil5b		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$s5		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	$pdf->Ln(0.6);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 8.3	,0.4,'Personality Traits (Kepribadian)','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q2'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,'Q3'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q4'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Av'		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//personality traits
	$qPER	="	SELECT 		t_personps.*
				FROM 		t_personps
				WHERE		t_personps.nis='$nis' AND 
							t_personps.thn_ajaran='$thn_ajr' "; // menghasilka nilai kepribadian
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
	
	$q3ATT=$dPER['att'."2"."1"]; // q3 att
	$q3DIL=$dPER['dil'."2"."1"]; // q3 dil
	$q3ORD=$dPER['ord'."2"."1"]; // q3 ord
	$q3CLE=$dPER['cle'."2"."1"]; // q3 cle
	
	$s1ATT='';
	$s1DIL='';
	$s1ORD='';
	$s1CLE='';
	
	if( $q2ATT!='' )
		$s1ATT=$q2ATT;
	else //if( $q2ATT=='' )
		$s1ATT=$q1ATT;
	
	if( $q2DIL!='' )
		$s1DIL=$q2DIL;
	else //if( $q2DIL=='' )
		$s1DIL=$q1DIL;
	
	if( $q2ORD!='' )
		$s1ORD=$q2ORD;
	else //if( $q2ORD=='' )
		$s1ORD=$q1ORD;
	
	if( $q2CLE!='' )
		$s1CLE=$q2CLE;
	else //if( $q2CLE=='' )
		$s1CLE=$q1CLE;
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Attitude (Kelakuan)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,$q1ATT		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$q2ATT		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$s1ATT		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'2','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Diligence/Discipline (Kerajinan/Kedisiplinan)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,$q1DIL		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$q2DIL		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$s1DIL		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'3','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Orderliness (Kerapihan)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,$q1ORD		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$q2ORD		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$s1ORD		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'4','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Cleanliness (Kebersihan)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,$q1CLE		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$q2CLE		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$s1CLE		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	
	
	$pdf->Ln(0.6);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 8.3	,0.4,'Absences (Ketidakhadiran)','LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q2'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Av'		,'LRTB',0,C,true);//'T'
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,'Q3'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'Q4'		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,'T'		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	
	//absences
	$qABS	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$nis' AND 
							t_hdrkmnps.thn_ajaran='$thn_ajr' "; // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	
	$q1SKT=$dABS['skt'."1"."1"]; // q1 skt
	$q1IZN=$dABS['izn'."1"."1"]; // q1 izn
	$q1ALP=$dABS['alp'."1"."1"]; // q1 alp
	$q1KMN=$dABS['kmn'."$sms"."$midtrm"]; // q1 kmn ."1"."1"
	
	$q2SKT=$dABS['skt'."1"."2"]; // q2 skt
	$q2IZN=$dABS['izn'."1"."2"]; // q2 izn
	$q2ALP=$dABS['alp'."1"."2"]; // q2 alp
	//$q2KMN=$dABS['kmn'."1"."2"]; // q2 kmn
	
	$q3SKT=$dABS['skt'."2"."1"]; // q3 skt
	$q3IZN=$dABS['izn'."2"."1"]; // q3 izn
	$q3ALP=$dABS['alp'."2"."1"]; // q3 alp
	
	$t1SKT = ($q1SKT + $q2SKT); // t1 skt  / 2
	$t1IZN = ($q1IZN + $q2IZN); // t1 izn  / 2
	$t1ALP = ($q1ALP + $q2ALP); // t1 alp  / 2
	$t1KMN = ($q1KMN + $q2KMN); // t1 kmn  / 2
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 0.6	,0.4,'1','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Sick (Sakit)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,$q1SKT		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$q2SKT		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$t1SKT		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'2','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Excused (Ijin)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,$q1IZN		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$q2IZN		,'LRTB',0,C,true);//$q2IZN
	$pdf->Cell( 1	,0.4,$t1IZN		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0.4,'3','LRTB',0,C,true);
	$pdf->Cell( 7.7	,0.4,'Not Excused (Alpa)','LRTB',0,L,true);
	$pdf->Cell( 1	,0.4,$q1ALP		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$q2ALP		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,$t1ALP		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->Cell( 1	,0.4,''		,'LRTB',0,C,true);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 1	,0.4,''			,'LRTB',0,C,true);
	$pdf->SetFillColor(255,255,255);
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
	$pdf->Cell( 14.7	,0.4,' '.substr($q1KMN,0,115),'RT',0,L);
	//$pdf->Cell( 14.7	,0.4,' It has been so nice working with Angle this school year. She is a very good student who has made excellent','RT',0,L);
	$pdf->Ln();
	$pdf->Cell( 1.6		,0.4,'','L',0,L);
	$pdf->Cell( 14.7	,0.4,' '.substr($q1KMN,115,115),'R',0,L);
	//$pdf->Cell( 14.7	,0.4,' progress in all academic areas and has shown herself to be well balanced in all subjects. Angle has taken great','R',0,L);
	$pdf->Ln();
	$pdf->Cell( 1.6		,0.4,'','L',0,L);
	$pdf->Cell( 14.7	,0.4,' '.substr($q1KMN,230,115),'R',0,L);
	//$pdf->Cell( 14.7	,0.4,' pride all year in putting top effort into everything she has done and it has shown in the quality of work she','R',0,L);
	$pdf->Ln();
	$pdf->Cell( 1.6		,0.4,'','L',0,L);
	$pdf->Cell( 14.7	,0.4,' '.substr($q1KMN,345,115),'R',0,L);
	//$pdf->Cell( 14.7	,0.4,' produces. She is very motivated to do well and has a strong work ethic which helps her achieve at high levels. I','R',0,L);
	$pdf->Ln();
	$pdf->Cell( 1.6		,0.4,'','L',0,L);
	$pdf->Cell( 14.7	,0.4,' '.substr($q1KMN,460,115),'R',0,L);
	//$pdf->Cell( 14.7	,0.4,' truly appreciate her for the effort she has put into her learning. Be blessed and be a blessing! I know you will be a','R',0,L);
	$pdf->Ln();
	$pdf->Cell( 1.6		,0.6,'','LB',0,L);
	$pdf->Cell( 14.7	,0.6,' '.substr($q1KMN,575,115),'RB',0,L);
	//$pdf->Cell( 14.7	,0.6,' great success in 9th grade and beyond! Have a wonderful vacation!','RB',0,L);
		
	
	
	$pdf->Ln(0.85);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 4.5	,0.4,$tglctk,'',0,C); // 6
	$pdf->Cell( 7	,0.4,'','',0,C);
	//$pdf->Image($signature, 7, 26.75, 3.85, 1.75);//4.577234, 2.143098
	$pdf->Cell( 6	,0.4,'','',0,C); // 'Jakarta, '.
	$pdf->Ln();
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 4.5	,0.4,'('.$wlikls.$gelar.')','',0,C); // 6
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