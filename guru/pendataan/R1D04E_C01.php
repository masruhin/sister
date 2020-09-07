<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04E_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kdekls	=$_POST['kdekls'];
$trm	=$_POST['trm'];
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
	case 'PG':
		$judul	='PLAY GROUP';
		break;
	case 'KG':
		$judul	='KINDERGARTEN';
		break;
}		
$judul=$judul.' PROGRESS REPORT';

// dapatkan data kepala sekolah
$query 	="	SELECT 		t_prstkt.*,t_mstkry.*
			FROM 		t_prstkt,t_mstkry
			WHERE 		t_prstkt.kdetkt='". mysql_escape_string($kdetkt)."' AND
						t_prstkt.kdekry=t_mstkry.kdekry						AND
						t_prstkt.kdejbt=100";
$result =mysql_query($query) or die('Query gagal2');
$data 	=mysql_fetch_array($result);
$kplskl=$data[nmakry];

$logo	="../../images/logo.jpg";

$pdf = new FPDF('P','cm','A4');
$pdf->SetMargins(1,0.5,1);
$pdf->SetAutoPageBreak(True, 0.5);
$pdf->AddFont('FRIZQUAD','','FRIZQUAD.php');

$rcd='SELECT count(*) FROM t_setpgrpt WHERE t_setpgrpt.kdetkt="$kdetkt"';

$query 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw";
$result =mysql_query($query) or die('Query gagal3');

while($data =mysql_fetch_array($result))
{
	$nis=$data[nis];
	$nmassw=$data[nmassw];
	$query1 ="	SELECT 		t_prgrptpg.*,t_setpgrpt.*
				FROM 		t_prgrptpg,t_setpgrpt
				WHERE		t_prgrptpg.nis=$nis	AND
							t_prgrptpg.id=t_setpgrpt.id	AND
							t_setpgrpt.kdetkt='$kdetkt'
				ORDER BY	t_prgrptpg.nis,t_prgrptpg.id";
	$result1=mysql_query($query1) or die('Query gagal4');

	$i=1;
	while($data1 = mysql_fetch_array($result1))
	{
		$cell1[$i][0] 	=$data1[id];
		$cell1[$i][1] 	=$data1[lrnare];
		$cell1[$i][2] 	=$data1[trm1];
		if($trm>1)
			$cell1[$i][3] 	=$data1[trm2];
		else
			$cell1[$i][3] 	='';
		if($trm>2)	
			$cell1[$i][4] 	=$data1[trm3];
		else
			$cell1[$i][4] 	='';
		if($trm>3)	
			$cell1[$i][5] 	=$data1[trm4];
		else
			$cell1[$i][5] 	='';

		$i++;
	}

	$query2 ="	SELECT 		t_attspcpg.*
				FROM 		t_attspcpg
				WHERE		t_attspcpg.nis=$nis";
	$result2=mysql_query($query2) or die('Query gagal4');

	$x=1;
	while($data2 = mysql_fetch_array($result2))
	{
		$atttrm1 	=$data2[atttrm1];
		$spctrm1 	=$data2[spctrm1];

		if($trm>1)
		{
			$atttrm2 	=$data2[atttrm2];
			$spctrm2 	=$data2[spctrm2];
		}
		else
		{	
			$atttrm2 	='';
			$spctrm2 	='';
		}	
		if($trm>2)
		{
			$atttrm3 	=$data2[atttrm3];
			$spctrm3 	=$data2[spctrm3];
		}
		else
		{
			$atttrm3 	='';
			$spctrm3 	='';
		}
		if($trm>3)
		{
			$atttrm4 	=$data2[atttrm4];
			$spctrm4 	=$data2[spctrm4];
		}
		else
		{	
			$atttrm4 	='';
			$spctrm4 	='';
		}	
		$x++;
	}
	$hlm=1;
	$pdf->Open();	
	$pdf->AddPage();
	$pdf->Image($logo,1,1,2,2);
	$pdf->Ln(0.7);
	$pdf->SetFont('FRIZQUAD','',8);
	$pdf->Cell( 2.3	,1);
	$pdf->Cell(10.7	,1, $nama_pt2_a);
	$pdf->SetFont('arial','B',8);
	$pdf->Cell( 6	,1, $nama_pt,'',0,R);
	$pdf->SetFont('FRIZQUAD','',20);
	$pdf->Ln();
	$pdf->Cell( 2.3	,-0.1);
	$pdf->Cell(10.7	,-0.1, $nama_pt2);
	$pdf->SetFont('arial','',6);
	$pdf->Cell( 6	,-0.5, $alamat1_pt,'',0,R);
	$pdf->Ln();
	$pdf->SetFont('FRIZQUAD','',8);
	$pdf->Cell( 2.3	,1.7);
	$pdf->Cell( 7.2	,1.7,$nama_pt2_b,'',0,R); 
	$pdf->SetFont('arial','',6);
	$pdf->Cell( 9.5	,1, $alamat2_pt,'',0,R);
	$pdf->Ln();
	$pdf->SetFont('arial','',6);
	$pdf->Cell(19	,-0.5, $alamat3_pt,'',0,R);

	$pdf->Ln();
	$pdf->SetFont('arial','BU',12);
	$pdf->Cell(19	,3, $judul,0,0,C);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(1.8);
	$pdf->Cell(19	,0.4, $thnajr,0,0,C);
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(1);
	$pdf->Cell( 9.5	,0.4,"Name : ".$nmassw,0,0,L); 
	$pdf->Cell( 9.5	,0.4,"Homeroom Teacher : ".$wlikls,0,0,R); 
	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.4	,0.7,'Learning Area','LRTB',0,C,true);
	$pdf->Cell( 1.4	,0.7,'Term 1'		,'LRTB',0,C,true);
	$pdf->Cell( 1.4	,0.7,'Term 2'		,'LRTB',0,C,true);
	$pdf->Cell( 1.4	,0.7,'Term 3'		,'LRTB',0,C,true);
	$pdf->Cell( 1.4	,0.7,'Term 4'		,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$j	=1;
	$id=$cell1[1][0];
	while ($id<99)
	{
		//menampilkan data dari hasil query database
		
		$lrnarev=$cell1[$j][1];
		if(substr($lrnarev,0,1)=='/')
		{
			$bg='true';
			$lrnarev 	=str_replace("/","","$lrnarev");
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(204,204,204);
			$pdf->Cell(13.4	,0.6,$lrnarev,'LRTB',0,C,$bg);
			$term1='';
			$term2='';
			$term3='';
			$term4='';
		}
		else
		{
			$bg='false';
			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(13.4	,0.6,$lrnarev,'LRTB',0,L,$bg);
			$term1=$cell1[$j][2];
			$term2=$cell1[$j][3];
			$term3=$cell1[$j][4];
			$term4=$cell1[$j][5];
		}	
		$pdf->Cell( 1.4	,0.6,$term1,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.6,$term2,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.6,$term3,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.6,$term4,'LRTB',0,C,$bg);
		$pdf->Ln();		
		$j++;
		$id=$cell1[$j][0];
	}
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(9.5	,0.4,$nmassw.' ( '.$nis.' '.$kdekls.' )'.' '.$thnajr,0,0,L);	
	$pdf->Cell(9.5	,0.4,' Page : '.$hlm." of 3",0,0,R);	
	$hlm++;
	
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Ln(2);
	$id=$cell1[j][0];
	$term1='Term 1';
	$term2='Term 2';
	$term3='Term 3';
	$term4='Term 4';
	$q=0;
	$z=0;
	while ($id<199)
	{
		//menampilkan data dari hasil query database
		
		$lrnarev=$cell1[$j][1];
		if(substr($lrnarev,0,1)=='/')
		{
			$bg='true';
			$lrnarev 	=str_replace("/","","$lrnarev");
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(204,204,204);
			$pdf->Cell(13.4	,0.6,$lrnarev,'LRTB',0,C,$bg);
			if($q==0)
			{
			$term1='Term 1';
			$term2='Term 2';
			$term3='Term 3';
			$term4='Term 4';
			}
			else
			{
				$term1='';
				$term2='';
				$term3='';
				$term4='';
			}	
		}
		else
		{
			$bg='false';
			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(13.4	,0.6,$lrnarev,'LRTB',0,L,$bg);
			$term1=$cell1[$j][2];
			$term2=$cell1[$j][3];
			$term3=$cell1[$j][4];
			$term4=$cell1[$j][5];
		}	
		$pdf->Cell( 1.4	,0.6,$term1,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.6,$term2,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.6,$term3,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.6,$term4,'LRTB',0,C,$bg);
		$pdf->Ln();
		$j++;
		$q++;
		$z++;
		$id=$cell1[$j][0];
	}

	$pdf->SetFont('Arial','',6);
	$pdf->Cell(9.5	,0.4,$nmassw.' ( '.$nis.' '.$kdekls.' )'.' '.$thnajr,0,0,L);	
	$pdf->Cell(9.5	,0.4,' Page : '.$hlm." of 3",0,0,R);	
	$hlm++;
	
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Ln(2);
	$term1='Term 1';
	$term2='Term 2';
	$term3='Term 3';
	$term4='Term 4';
	
	while ($j<$i)
	{
		//menampilkan data dari hasil query database
		
		$lrnarev=$cell1[$j][1];
		if(substr($lrnarev,0,1)=='/')
		{
			$bg='true';
			$lrnarev 	=str_replace("/","","$lrnarev");
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(204,204,204);
			$pdf->Cell(13.4	,0.6,$lrnarev,'LRTB',0,C,$bg);
		}
		else
		{
			$bg='false';
			$pdf->SetFont('Arial','',8);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(13.4	,0.6,$lrnarev,'LRTB',0,L,$bg);
			$term1=$cell1[$j][2];
			$term2=$cell1[$j][3];
			$term3=$cell1[$j][4];
			$term4=$cell1[$j][5];
		}	
		$pdf->Cell( 1.4	,0.6,$term1,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.6,$term2,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.6,$term3,'LRTB',0,C,$bg);
		$pdf->Cell( 1.4	,0.6,$term4,'LRTB',0,C,$bg);
		$pdf->Ln(0.6);
		$j++;
	}

	//------------------------------------------- Attitudes --------------------------	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell(19	,0.6,'Attitudes toward learning','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$z=0;
	$ktr 	=susun_kalimat($atttrm1, 100);
	$jml	=count($ktr);
	$y=0;
	while ($y<$jml)
	{
		$tmp=str_replace("’","'",$ktr[$y]);
		if($y==0)
			$pdf->Cell( 1.5	,0.6,'Term 1','LRT',0,C,true);
		else
			$pdf->Cell( 1.5	,0.6,'','LR',0,C,true);

		if($y==0)
			$pdf->Cell(17.5	,0.6, $tmp,'LRT',0,L); 
		else
			$pdf->Cell(17.5	,0.6, $tmp,'LR',0,L); 
		
		$pdf->Ln(0.6);
		$y++;
		$z++;
	}	

	$ktr 	=susun_kalimat($atttrm2, 100);
	$jml	=count($ktr);
	$y=0;
	while ($y<$jml)
	{
		$tmp=str_replace("’","'",$ktr[$y]);
		if($y==0)
			$pdf->Cell( 1.5	,0.6,'Term 2','LRT',0,C,true);
		else
			$pdf->Cell( 1.5	,0.6,'','LR',0,C,true);
			
		if($y==0)
			$pdf->Cell(17.5	,0.6, $tmp,'LRT',0,L); 
		else
			$pdf->Cell(17.5	,0.6, $tmp,'LR',0,L); 
		
		$pdf->Ln(0.6);
		$y++;
		$z++;
	}	
	
	$ktr 	=susun_kalimat($atttrm3, 100);
	$jml	=count($ktr);
	$y=0;
	while ($y<$jml)
	{
		$tmp=str_replace("’","'",$ktr[$y]);
		if($y==0)
			$pdf->Cell( 1.5	,0.6,'Term 3','LRT',0,C,true);
		else
			$pdf->Cell( 1.5	,0.6,'','LR',0,C,true);
			
		if($y==0)
			$pdf->Cell(17.5	,0.6, $tmp,'LRT',0,L); 
		else
			$pdf->Cell(17.5	,0.6, $tmp,'LR',0,L); 
		
		$pdf->Ln(0.6);
		$y++;
		$z++;
	}	
	
	$ktr 	=susun_kalimat($atttrm4, 100);
	$jml	=count($ktr);
	$y=0;
	while ($y<$jml)
	{
		$tmp=str_replace("’","'",$ktr[$y]);
		if($y==0)
			$pdf->Cell( 1.5	,0.6,'Term 4','LRT',0,C,true);
		else
			$pdf->Cell( 1.5	,0.6,'','LR',0,C,true);
				
		if($y==0)
			$pdf->Cell(17.5	,0.6, $tmp,'LRT',0,L); 
		else
			$pdf->Cell(17.5	,0.6, $tmp,'LR',0,L); 
		
		$pdf->Ln(0.6);
		$y++;
		$z++;
	}
	$pdf->Cell(19	,0.6,'','T',0,L); 	
	//---------------------------------------------------------------------

	//------------------------------------------- Special Note --------------------------	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell(19	,0.6,'Special Note','LRTB',0,C,true);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	$z=0;
	$ktr 	=susun_kalimat($spctrm1, 100);
	$jml	=count($ktr);
	$y=0;
	while ($y<$jml)
	{
		$tmp=str_replace("’","'",$ktr[$y]);
		if($y==0)
			$pdf->Cell( 1.5	,0.6,'Term 1','LRT',0,C,true);
		else
			$pdf->Cell( 1.5	,0.6,'','LR',0,C,true);

		if($y==0)
			$pdf->Cell(17.5	,0.6, $tmp,'LRT',0,L); 
		else
			$pdf->Cell(17.5	,0.6, $tmp,'LR',0,L); 
		
		$pdf->Ln(0.6);
		$y++;
		$z++;
	}	

	$ktr 	=susun_kalimat($spctrm2, 100);
	$jml	=count($ktr);
	$y=0;
	while ($y<$jml)
	{
		$tmp=str_replace("’","'",$ktr[$y]);
		if($y==0)
			$pdf->Cell( 1.5	,0.6,'Term 2','LRT',0,C,true);
		else
			$pdf->Cell( 1.5	,0.6,'','LR',0,C,true);
			
		if($y==0)
			$pdf->Cell(17.5	,0.6, $tmp,'LRT',0,L); 
		else
			$pdf->Cell(17.5	,0.6, $tmp,'LR',0,L); 
		
		$pdf->Ln(0.6);
		$y++;
		$z++;
	}	
	
	$ktr 	=susun_kalimat($spctrm3, 100);
	$jml	=count($ktr);
	$y=0;
	while ($y<$jml)
	{
		$tmp=str_replace("’","'",$ktr[$y]);
		if($y==0)
			$pdf->Cell( 1.5	,0.6,'Term 3','LRT',0,C,true);
		else
			$pdf->Cell( 1.5	,0.6,'','LR',0,C,true);
			
		if($y==0)
			$pdf->Cell(17.5	,0.6, $tmp,'LRT',0,L); 
		else
			$pdf->Cell(17.5	,0.6, $tmp,'LR',0,L); 
		
		$pdf->Ln(0.6);
		$y++;
		$z++;
	}	
	
	$ktr 	=susun_kalimat($spctrm4, 100);
	$jml	=count($ktr);
	$y=0;
	while ($y<$jml)
	{
		$tmp=str_replace("’","'",$ktr[$y]);
		if($y==0)
			$pdf->Cell( 1.5	,0.6,'Term 4','LRT',0,C,true);
		else
			$pdf->Cell( 1.5	,0.6,'','LR',0,C,true);
				
		if($y==0)
			$pdf->Cell(17.5	,0.6, $tmp,'LRT',0,L); 
		else
			$pdf->Cell(17.5	,0.6, $tmp,'LR',0,L); 
		
		$pdf->Ln(0.6);
		$y++;
		$z++;
	}
	$pdf->Cell(19	,0.6,'','T',0,L); 	
	//---------------------------------------------------------------------

	//---------------------------------------------------------------------
	$pdf->Ln(0.6);
	$pdf->SetFont('Arial','I',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(19	,0.6,'Scoring Symbols :      A-Excellent          B-Very Good          C-Good          D-Keep Trying          N/A-Not Applicable','LRTB',0,C,true);
	$pdf->Ln(0.6);
	$z++;
	$z++;

	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 6	,0.6,'','',0,C,true);
	$pdf->Cell( 7	,0.6,'Term '.$trm,'',0,C,true);
	$pdf->Cell( 6	,0.6,'Bekasi, '.$tglctk,'',0,C,true);
	$pdf->Ln();
	$pdf->Cell( 6	,3,'','LRT',0,C,true);
	$pdf->Cell( 7	,3,'','LRT',0,C,true);
	$pdf->Cell( 6	,3,'','LRT',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','U',7);
	$pdf->Cell( 6	,0.6,$kplskl,'LR',0,C,true);
	$pdf->Cell( 7	,0.6,$wlikls,'LR',0,C,true);
	$pdf->Cell( 6	,0.6,'                                                   ','LR',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->Cell( 6	,0.6,'Principal','LRB',0,C,true);
	$pdf->Cell( 7	,0.6,'Homeroom Teacher','LRB',0,C,true);
	$pdf->Cell( 6	,0.6,"Parent's Signature",'LRB',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(9.5	,0.4,$nmassw.' ( '.$nis.' '.$kdekls.' )'.' '.$thnajr,0,0,L);	
	$pdf->Cell(9.5	,0.4,' Page : '.$hlm." of 3",0,0,R);		
};
$pdf->Output();
?>