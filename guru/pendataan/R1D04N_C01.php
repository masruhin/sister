<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04N_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdekls	=$_POST['kdekls'];
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
			WHERE		t_setthn.set='Tahun Ajaran'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

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
switch($kdetkt)
{
	case 'PS':
		$judul	=$nama_pt_ps;
		break;
	case 'JHS':
		$judul	=$nama_pt_jhs;
		break;
	case 'SHS':
		$judul	=$nama_pt_shs;
		break;
}		
if($sms=='1')
	$nmasms='FIRST SEMESTER ';
else
	$nmasms='SECOND SEMESTER ';
$judul2=$nmasms.' MONTHLY PROGRESS REPORT '.$midtrm;

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
				ORDER BY	t_prstkt.kdejbt ASC";
	$result =mysql_query($query) or die('Query gagal3');
	$data 	=mysql_fetch_array($result);
	$kplskl=$data[nmakry];
}

$logo_pt	="../../images/logo.jpg";
$logo_ttw	="../../images/tutwurihandayani.jpg";

$pdf =new FPDF('P','cm','A4');
$pdf->SetMargins(1,0.4,1);
$pdf->SetAutoPageBreak(True, 0.4);

$query 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw";
$result =mysql_query($query) or die('Query gagal5');

while($data =mysql_fetch_array($result))
{
	$nis	=$data[nis];
	$nmassw	=$data[nmassw];
	$nisn	=$data[nisn];

	$query1 ="	SELECT 		t_setpsrpt.*
				FROM 		t_setpsrpt
				WHERE		t_setpsrpt.kdetkt='$kdetkt'
				ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id";
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
			$query2 ="	SELECT 		t_prgrptps.*
						FROM 		t_prgrptps
						WHERE		t_prgrptps.nis='$nis'		AND
									t_prgrptps.kdeplj='$kdeplj'";
			$result2=mysql_query($query2) or die('Query gagal');
			$data2 =mysql_fetch_array($result2);
			$y=1;
			$jml=0;
			while($y<6)
			{
				$cell[$i][$y+2]=$data2['hw'."$sms"."$midtrm"."$y"];
				$jml=$jml+$cell[$i][$y+2];
				if($cell[$i][$y+2]==0)
					$cell[$i][$y+2]='-';
					
				$cell[$i][$y+7]=$data2['prj'."$sms"."$midtrm"."$y"];
				$jml=$jml+$cell[$i][$y+7];
				if($cell[$i][$y+7]==0)
					$cell[$i][$y+7]='-';
					
				$cell[$i][$y+12]=$data2['tes'."$sms"."$midtrm"."$y"];
				$jml=$jml+$cell[$i][$y+12];
				if($cell[$i][$y+12]==0)
					$cell[$i][$y+12]='-';
				
				$y++;
			}
			if(substr($cell[$i][1],0,1)=='*' AND $cell[$i][0]>=15 AND $kdetkt=='SHS')
			{
				if($jml==0)	
					$cell[$i][1]='';
				else	
					$cell[$i][1]=str_replace("*","",$cell[$i][1]);
			}		
			
			if(substr($cell[$i][1],0,1)=='*' AND $cell[$i][0]<15  AND $kdetkt=='SHS') 
			{
				if($jml==0	AND (strpos($kdekls,'IPA')!='' OR strpos($kdekls,'IPS')!=''))
					$cell[$i][1]='';
				else	
					$cell[$i][1]=str_replace("*","",$cell[$i][1]);
			}		
			
			if($kdetkt=='JHS')
			{
				if(substr($cell[$i][1],0,1)=='*' AND $jml==0)	
					$cell[$i][1]='';
				else	
					$cell[$i][1]=str_replace("*","",$cell[$i][1]);
			}		
			if($kdetkt=='PS')
			{
				$cell[$i][1]=str_replace("*","",$cell[$i][1]);
			}		
		}	
		$i++;
	}
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Image($logo_pt ,1,1,2,2);
	$pdf->Image($logo_ttw,18,1,2,2);
	$pdf->Ln(0.8);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(19	,0.4, $judul,0,0,C);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Cell(19	,0.4, $judul2,0,0,C);
	$pdf->Ln();
	$pdf->Cell(19	,0.4, $thnajr,0,0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(19	,0.3, $alamat1_pt1,0,0,C);
	$pdf->Ln();
	$pdf->Cell(19	,0.3, $alamat2_pt2,0,0,C);
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(1);
	$pdf->Cell( 1	,0.4,"Name",0,0,L); 
	$pdf->Cell( 13	,0.4,": ".$nmassw,0,0,L); 
	$pdf->Cell( 1	,0.4,"Grade",0,0,L); 
	$pdf->Cell( 4	,0.4,": ".$kdekls,0,0,L); 
	$pdf->Ln();
	$pdf->Cell( 1	,0.4,"NIS",0,0,L); 
	$pdf->Cell( 13	,0.4,": ".$nis,0,0,L); 
	$pdf->Cell( 1	,0.4,"NISN",0,0,L); 
	$pdf->Cell( 4	,0.4,": ".$nisn,0,0,L); 
	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.6	,1.2,'No','LRT',0,C,true);
	$pdf->Cell( 7.9	,1.2,'Subject','LRT',0,C,true);
	$pdf->Cell( 3.5	,0.6,'HW/CW'				,'LRT',0,C,true);
	$pdf->Cell( 3.5	,0.6,'Project/Experiment'	,'LRTB',0,C,true);
	$pdf->Cell( 3.5	,0.6,'Test'		,'LRT',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 0.6	,0);
	$pdf->Cell( 7.9	,0);
	$y=1;
	while($y<6)
	{
		$pdf->Cell( 0.7	,0.6,$y		,'LRTB',0,C,true);
		$y++;
	}	
	$y=1;
	while($y<6)
	{
		$pdf->Cell( 0.7	,0.6,$y		,'LRTB',0,C,true);
		$y++;
	}	
	$y=1;
	while($y<6)
	{
		$pdf->Cell( 0.7	,0.6,$y		,'LRTB',0,C,true);
		$y++;
	}	
	$pdf->Ln();

	//------------------------------- Mata Pelajaran Kurikulum Nasional
	$j	=1;
	$no =1;
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[$j][0];
	$pdf->Cell(0.6	,0.6,'A','LRTB',0,C,true);	
	while ($id<99)
	{
		//menampilkan data dari hasil query database
		$nmasbj=$cell[$j][1];
		if($nmasbj!='')
		{
			if(substr($nmasbj,0,1)=='/')
			{
				$nmasbj 	=str_replace("/","","$nmasbj");
				$pdf->SetFont('Arial','B',8);
				$pdf->SetFillColor(204,204,204);
				$pdf->Cell(7.9	,0.6,$nmasbj,'LRTB',0,L,true);
			}
			else
			{
				$pdf->SetFont('Arial','',8);
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(0.6	,0.6,'','LRTB',0,C,true);
				if(substr($nmasbj,0,1)!='=')
				{
					$pdf->Cell(0.6	,0.6,$no.'.','LTB',0,R,true);
					$pdf->Cell(7.3	,0.6,$nmasbj,'RTB',0,L,true);
					$no++;
				}
				else
				{
					$nmasbj 	=str_replace("=","","$nmasbj");
					$pdf->Cell(7.9	,0.6,'        '.$nmasbj,'LRTB',0,L,true);
				}	
			}	
			$y=1;
			while($y<16)
			{
				$pdf->Cell( 0.7	,0.6,$cell[$j][$y+2],'LRTB',0,C,true);
				$y++;
			}	
			$pdf->Ln();
		}	
		$j++;
		$id=$cell[$j][0];
	}
	$pdf->Cell( 0.6	,0.6,'','LRTB',0,C,true);
	$pdf->Cell( 7.9	,0.6,'','LRTB',0,C,true);
	$y=1;
	while($y<16)
	{
		$pdf->Cell( 0.7	,0.6,'','LRTB',0,C,true);
		$y++;
	}	
	$pdf->Ln();

	//------------------------------- Muatan Lokal 
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[j][0];
	$pdf->Cell(0.6	,0.6,'B','LRTB',0,C,true);	
	while ($id<200)
	{
		//menampilkan data dari hasil query database
		
		$nmasbj=$cell[$j][1];
		if(substr($nmasbj,0,1)=='/')
		{
			$nmasbj 	=str_replace("/","","$nmasbj");
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(204,204,204);
			$pdf->Cell(7.9	,0.6,$nmasbj,'LRTB',0,L,true);
		}
		else
		{
			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(0.6	,0.6,'','LRTB',0,C,true);
			$pdf->Cell(0.6	,0.6,$no.'.','LTB',0,R,true);
			$pdf->Cell(7.3	,0.6,$nmasbj,'RTB',0,L,true);
			$no++;
		}	
		$y=1;
		while($y<16)
		{
			$pdf->Cell( 0.7	,0.6,$cell[$j][$y+2],'LRTB',0,C,true);
			$y++;
		}	
		$pdf->Ln();
		$j++;
		$id=$cell[$j][0];
	}
	$pdf->Cell( 0.6	,0.6,'','LRTB',0,C,true);
	$pdf->Cell( 7.9	,0.6,'','LRTB',0,C,true);
	$y=1;
	while($y<16)
	{
		$pdf->Cell( 0.7	,0.6,'','LRTB',0,C,true);
		$y++;
	}	
	$pdf->Ln();

	//------------------------------- Pengembangan diri
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell(0.6	,0.6,'C','LRTB',0,C,true);	
	$pdf->Cell(7.9	,0.6,'Pengembangan Diri','LRTB',0,L,true);
	$y=1;
	while($y<16)
	{
		$pdf->Cell( 0.7	,0.6,'','LRTB',0,C,true);
		$y++;
	}	
	$pdf->Ln();

	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.6	,0.6,'','LRTB',0,C,true);	
	$pdf->Cell(7.9	,0.6,'Ekstrakurikuler','LRTB',0,L,true);
	$y=1;
	while($y<16)
	{
		$pdf->Cell( 0.7	,0.6,'','LRTB',0,C,true);
		$y++;
	}	
	$pdf->Ln();

	$query3	="	SELECT 		t_extcrrps.*,t_mstplj.*
				FROM 		t_extcrrps,t_mstplj
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj=t_mstplj.kdeplj
				ORDER BY	t_extcrrps.kdeplj";
	$result3=mysql_query($query3) or die('Query gagal40');

	$z=0;
	while($data3 = mysql_fetch_array($result3))
	{
		if($data3['ext'."$sms"."$midtrm"]!='')
		{
			$ext='  '.ucwords(strtolower($data3['nmaplj'])).' : '.$data3['ext'."$sms"."$midtrm"];
			$pdf->Cell( 0.6	,0.6,'','LRTB',0,C,true);
			$pdf->Cell( 7.9	,0.6,$ext,'LRTB',0,L,true);
			
			$y=1;
			while($y<16)
			{
				$pdf->Cell( 0.7	,0.6,'','LRTB',0,C,true);
				$y++;
			}	
			$pdf->Ln();
		}	
	}
	$pdf->Cell( 0.6	,0.6,'','LRTB',0,C,true);
	$pdf->Cell( 7.9	,0.6,'','LRTB',0,C,true);
	$y=1;
	while($y<16)
	{
		$pdf->Cell( 0.7	,0.6,'','LRTB',0,C,true);
		$y++;
	}	
	$pdf->Ln();
	
	//------------------------------- Cambridge Curiculum
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$id=$cell[j][0];
	$pdf->Cell(0.6	,0.6,'D','LRTB',0,C,true);	
	while ($j<$i)
	{
		//menampilkan data dari hasil query database
		
		$nmasbj=$cell[$j][1];
		if($nmasbj!='')
		{
			if(substr($nmasbj,0,1)=='/')
			{
				$nmasbj 	=str_replace("/","","$nmasbj");
				$pdf->SetFont('Arial','B',8);
				$pdf->SetFillColor(204,204,204);
				$pdf->Cell(7.9	,0.6,$nmasbj,'LRTB',0,L,true);
			}
			else
			{
				$pdf->SetFont('Arial','',8);
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(0.6	,0.6,'','LRTB',0,C,true);
				$pdf->Cell(0.6	,0.6,$no.'.','LTB',0,R,true);
				$pdf->Cell(7.3	,0.6,$nmasbj,'RTB',0,L,true);
				$no++;
			}	
			$y=1;
			while($y<16)
			{
				$pdf->Cell( 0.7	,0.6,$cell[$j][$y+2],'LRTB',0,C,true);
				$y++;
			}	
			$pdf->Ln();
		}	
		$j++;
		$id=$cell[$j][0];
	}

	$pdf->Ln(1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 9.5	,0.4,'Acknowledged by','',0,C,true);
	$pdf->Cell( 9.5	,0.4,'Bekasi, '.$tglctk,'',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 9.5	,0.4,'Parents / Guardian,','',0,C,true);
	$pdf->Cell( 9.5	,0.4,'Homeroom Teacher','',0,C,true);
	$pdf->Ln(2);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 9.5	,0.4,"                                                      ",'',0,C,true);
	$pdf->Cell( 9.5	,0.4,$wlikls,'',0,C,true); 
};
$pdf->Output();
?>