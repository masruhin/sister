<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04Q_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdeplj	=$_POST['kdeplj'];
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

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt.*
			FROM 		t_mstbbt
			WHERE		t_mstbbt.kdebbt='1HW'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt.*
			FROM 		t_mstbbt
			WHERE		t_mstbbt.kdebbt='2PRJ'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt.*
			FROM 		t_mstbbt
			WHERE		t_mstbbt.kdebbt='3TES'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes	=$data[bbt];

$query	="	SELECT 		t_mstbbt.*
			FROM 		t_mstbbt
			WHERE		t_mstbbt.kdebbt='4MID'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtmidtes=$data[bbt];

$query 	="	SELECT 		t_kkm.*
			FROM 		t_kkm
			WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
						t_kkm.kdeplj='". mysql_escape_string($kdeplj)."'";
$result =mysql_query($query) or die('Query gagal');
$data 	=mysql_fetch_array($result);
$kkm=$data[kkm];

// dapatkan data guru 
	$logo_pt	="../../images/logo.jpg";
	$logo_ttw	="../../images/tutwurihandayani.jpg";

	$pdf =new FPDF('P','cm','A4');
	$pdf->SetMargins(1,0.4,1);
	$pdf->SetAutoPageBreak(True, 0.4);

// dapatkan data guru 
$queryx 	="	SELECT 		t_mstpng.*
				FROM 		t_mstpng
				WHERE 		(t_mstpng.kdekls='". mysql_escape_string($kdekls)."' OR '$kdekls'='' ) AND
							t_mstpng.kdeplj='". mysql_escape_string($kdeplj)."'
				ORDER BY	t_mstpng.kdekls";
$resultx =mysql_query($queryx) or die('Query gagal2');
while($datax 	=mysql_fetch_array($resultx))
{
	$kdekls=$datax[kdekls];

	$query 	="	SELECT 		t_mstpng.*
				FROM 		t_mstpng
				WHERE 		t_mstpng.kdekls='". mysql_escape_string($kdekls)."' AND
							t_mstpng.kdeplj='". mysql_escape_string($kdeplj)."'";
	$result =mysql_query($query) or die('Query gagal2');
	$data 	=mysql_fetch_array($result);
	$kdegru=$data[kdegru];

	$query 	="	SELECT 		t_mstkry.*
				FROM 		t_mstkry
				WHERE 		t_mstkry.kdekry='". mysql_escape_string($kdegru)."'";
	$result =mysql_query($query) or die('Query gagal2');
	$data 	=mysql_fetch_array($result);
	$nmagru=$data[nmakry];

	// dapatkan data tingkat 
	$query 	="	SELECT 		t_mstkls.*,t_klmkls.*
				FROM 		t_mstkls,t_klmkls
				WHERE 		t_mstkls.kdekls='". mysql_escape_string($kdekls)."' AND
							t_mstkls.kdeklm=t_klmkls.kdeklm";
	$result =mysql_query($query) or die('Query gagal2');
	$data 	=mysql_fetch_array($result);
	$kdetkt=$data[kdetkt];
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
	$judul2=$nmasms.'GRADING SHEET FINAL REPORT';

	// dapatkan data pelajaran
	$query 	="	SELECT 		t_mstplj.*
				FROM 		t_mstplj
				WHERE 		t_mstplj.kdeplj='". mysql_escape_string($kdeplj)."' ";
	$result =mysql_query($query) or die('Query gagal3');
	$data 	=mysql_fetch_array($result);
	$nmaplj=$data[nmaplj];

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

	$query 	="	SELECT 		t_mstssw.*
				FROM 		t_mstssw
				WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
							t_mstssw.str!='K'
				ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw";
	$result =mysql_query($query) or die('Query gagal5');
	$bghw1	=1;
	$bgprj1	=1;
	$bgtes1	=1;
	$bghw2	=1;
	$bgprj2	=1;
	$bgtes2	=1;
	$i=0;
	while($data =mysql_fetch_array($result))
	{
		$cell[$i][0]=$data[nis];
		$nis		=$data[nis];
		$cell[$i][1]=$data[nmassw];
	
		$query2 ="	SELECT 		t_prgrptps.*
					FROM 		t_prgrptps
					WHERE		t_prgrptps.nis	='$nis'		AND
								t_prgrptps.kdeplj='$kdeplj'";
		$result2=mysql_query($query2) or die('Query gagal');
		$data2	=mysql_fetch_array($result2);
		$z=1;
		while($z<3)
		{
			$midtrm=$z;
			$y	=1;
			$hw	=0;
			$prj=0;
			$tes=0;
			while($y<6)
			{
				if($data2['hw'."$sms"."$midtrm"."$y"]>0)
					$hw++;
				if($data2['prj'."$sms"."$midtrm"."$y"]>0)
					$prj++;
				if($data2['tes'."$sms"."$midtrm"."$y"]>0)
					$tes++;	
				$y++;	
			}
			if($z==1)
			{
				if($hw>$bghw1)
					$bghw1=$hw;
				if($prj>$bgprj1)
					$bgprj1=$prj;
				if($tes>$bgtes1)
					$bgtes1=$tes;
			}		
			if($z==2)
			{
				if($hw>$bghw2)
					$bghw2=$hw;
				if($prj>$bgprj2)
					$bgprj2=$prj;
				if($tes>$bgtes2)
					$bgtes2=$tes;
			}		
			$z++;	
		}
		$i++;
	}

	$hlm=1;
	$no=1;
	$j=0;
	while($j<$i)
	{
		$pdf->Open();
		$pdf->AddPage('L');
		$pdf->Image($logo_pt ,1,1,2,2);
		$pdf->Image($logo_ttw,27,1,2,2);
		$pdf->Ln(0.8);
		$pdf->SetFont('arial','B',11);
		$pdf->Cell(28	,0.4, $judul,0,0,C);
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln();
		$pdf->Cell(28	,0.4, $judul2,0,0,C);
		$pdf->Ln();
		$pdf->Cell(28	,0.4, $thnajr,0,0,C);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(28	,0.3, $alamat1_pt1,0,0,C);
		$pdf->Ln();
		$pdf->Cell(28	,0.3, $alamat2_pt2,0,0,C);
	
		$pdf->SetFont('Arial','B',8);
		$pdf->Ln(0.5);
		$pdf->Cell(14	,0.4,"Grade : ".$kdekls,0,0,L); 
		$pdf->Cell(14	,0.4,"Subject : ".$nmaplj,0,0,R); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',8);
		$pdf->SetFillColor(153,153,153);
		$pdf->Cell( 0.6	,0.8,'No','LRT',0,C,true);
		$pdf->Cell( 5.5	,0.8,'Name','LRT',0,C,true);
		$pdf->Cell( 4	,0.4,'Home Work / Class Work'				,'LRT',0,C,true);
		$pdf->Cell( 4	,0.4,'Project/Experiment/Research'	,'LRTB',0,C,true);
		$pdf->Cell( 4	,0.4,'Test'		,'LRT',0,C,true);
		$pdf->Cell( 1.8	,0.4,'Total 1','LRT',0,C,true);
		$pdf->Cell( 1.8	,0.4,'Total 2','LRT',0,C,true);
		$pdf->Cell( 1.8	,0.4,'Mid Test 1','LRT',0,C,true);
		$pdf->Cell( 1.8	,0.4,'Mid Test 2','LRT',0,C,true);
		$pdf->Cell( 0.8	,0.8,'Trm1'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.8,'Trm2'		,'LRTB',0,C,true);
		$pdf->Cell( 1.1	,0.4,'Final','LRT',0,C,true);
		$pdf->Ln();
	
		$pdf->Cell( 0.6	,0);
		$pdf->Cell( 5.5	,0);

		$pdf->Cell( 1	,0.4,'Ave-1'		,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,"$bbthw".'%','LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,'Ave-2'		,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,"$bbthw".'%','LRTB',0,C,true);
	
		$pdf->Cell( 1	,0.4,'Ave-1'		,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,"$bbtprj".'%','LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,'Ave-2'		,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,"$bbtprj".'%','LRTB',0,C,true);
	
		$pdf->Cell( 1	,0.4,'Ave-1'		,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,"$bbttes".'%','LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,'Ave-2'		,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,"$bbttes".'%','LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,'100%'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'70%'		,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,'100%'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'70%'		,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,'Score'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'30%'		,'LRTB',0,C,true);
		$pdf->Cell( 1	,0.4,'Score'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'30%'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0);
		$pdf->Cell( 0.8	,0);
		$pdf->Cell( 1.1	,0.4,'Total'		,'LRTB',0,C,true);
		$pdf->Ln();
		$pdf->SetFont('Arial','',7);
		$pdf->SetFillColor(255,255,255);
		$x=1;
		while($j<$i AND $x<=30)
		{
			$nis	=$cell[$j][0];
			$nmassw	=$cell[$j][1];
			$pdf->Cell( 0.6	,0.5,$no,'LRTB',0,C,true);
			$pdf->Cell( 5.5	,0.5,$nmassw,'LRTB',0,L,true);

			$query2 ="	SELECT 		t_prgrptps.*
						FROM 		t_prgrptps
						WHERE		t_prgrptps.nis='$nis'		AND
									t_prgrptps.kdeplj='$kdeplj'";
			$result2=mysql_query($query2) or die('Query gagal');
			$data2 =mysql_fetch_array($result2);
			//------hw

			$z=1;
			while($z<3)
			{
				$midtrm=$z;
				$ttlhw=0;
				$y=1;
				while($y<6)
				{
					$hw=$data2['hw'."$sms"."$midtrm"."$y"];
					$ttlhw=$ttlhw+$hw;
					$y++;
				}
				if($z==1)
				{
					$avghw1	=$ttlhw/$bghw1;
					$bavghw1=($avghw1*$bbthw)/100;
				}
				if($z==2)
				{
					$avghw2	=$ttlhw/$bghw2;
					$bavghw2=($avghw2*$bbthw)/100;
				}
				$z++;
			}	
			$pdf->Cell( 1	,0.5,number_format($avghw1,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 1	,0.5,number_format($bavghw1,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell( 1	,0.5,number_format($avghw2,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 1	,0.5,number_format($bavghw2,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(255,255,255);

			//------prj
			$z=1;
			while($z<3)
			{
				$midtrm=$z;
				$ttlprj=0;
				$y=1;
				while($y<6)
				{
					$prj=$data2['prj'."$sms"."$midtrm"."$y"];
					$ttlprj=$ttlprj+$prj;
					$y++;
				}		
				if($z==1)
				{
					$avgprj1	=$ttlprj/$bgprj1;
					$bavgprj1	=($avgprj1*$bbtprj)/100;
				}	
				if($z==2)
				{
					$avgprj2	=$ttlprj/$bgprj2;
					$bavgprj2	=($avgprj2*$bbtprj)/100;
				}	
				$z++;
			}
			$pdf->Cell( 1	,0.5,number_format($avgprj1,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 1	,0.5,number_format($bavgprj1,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell( 1	,0.5,number_format($avgprj2,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 1	,0.5,number_format($bavgprj2,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(255,255,255);

			//------tes
			$z=1;
			while($z<3)
			{
				$midtrm=$z;
				$ttltes=0;
				$y=1;
				while($y<6)
				{
					$tes=$data2['tes'."$sms"."$midtrm"."$y"];
					$ttltes=$ttltes+$tes;
					$y++;
				}
				if($z==1)
				{
					$avgtes1	=$ttltes/$bgtes1;
					$bavgtes1	=($avgtes1*$bbttes)/100;
				}	
				if($z==2)
				{
					$avgtes2	=$ttltes/$bgtes2;
					$bavgtes2	=($avgtes2*$bbttes)/100;
				}	
				$z++;
			}	

			$pdf->Cell( 1	,0.5,number_format($avgtes1,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 1	,0.5,number_format($bavgtes1,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell( 1	,0.5,number_format($avgtes2,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 1	,0.5,number_format($bavgtes2,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(255,255,255);

			$ttl1	=$bavghw1+$bavgprj1+$bavgtes1;
			$ttl701	=$ttl1*((100-$bbtmidtes)/100);
			$pdf->Cell( 1	,0.5,number_format($ttl1,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 0.8	,0.5,number_format($ttl701,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(255,255,255);

			$ttl2	=$bavghw2+$bavgprj2+$bavgtes2;
			$ttl702	=$ttl2*((100-$bbtmidtes)/100);
			$pdf->Cell( 1	,0.5,number_format($ttl2,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 0.8	,0.5,number_format($ttl702,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(255,255,255);
			
			$midtes1	=$data2['midtes'."$sms"."1"];
			$midtes301	=($midtes1*$bbtmidtes)/100;
			$pdf->Cell( 1	,0.5,$midtes1,'LRTB',0,R,true);
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 0.8	,0.5,number_format($midtes301,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(255,255,255);

			$midtes2	=$data2['midtes'."$sms"."2"];
			$midtes302	=($midtes2*$bbtmidtes)/100;
			$pdf->Cell( 1	,0.5,$midtes2,'LRTB',0,R,true);
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 0.8	,0.5,number_format($midtes302,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(255,255,255);
			$nlitrm1=number_format($ttl701+$midtes301,0,',','.');
			$nlitrm2=number_format($ttl702+$midtes302,0,',','.');
			$nliakh	=number_format((($nlitrm1+$nlitrm2))/2,0,',','.');
			if($nlitrm1<$kkm)
				$pdf->SetTextColor(255,0,0);
			else
				$pdf->SetTextColor(0,0,0);
			$pdf->Cell( 0.8	,0.5,number_format($nlitrm1,0,',','.'),'LRTB',0,R,true);
			
			if($nlitrm2<$kkm)
				$pdf->SetTextColor(255,0,0);
			else
				$pdf->SetTextColor(0,0,0);
			$pdf->Cell( 0.8	,0.5,number_format($nlitrm2,0,',','.'),'LRTB',0,R,true);
			
			if($nliakh<$kkm)
				$pdf->SetTextColor(255,0,0);
			else
				$pdf->SetTextColor(0,0,0);
			
			$pdf->Cell( 1.1	,0.5,number_format($nliakh,0,',','.'),'LRTB',0,R,true);
			$pdf->SetTextColor(0,0,0);
			
			$pdf->Ln();
			$j++;
			$x++;
			$no++;
		}

		$pdf->Ln(0.1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetFillColor(255,255,255);
		if($j<$i)
		{
			$pdf->Cell(28	,0.4," Page : ".$hlm." Continued on page ".($hlm+1),'',0,R,true);
			$hlm++;
		}
		else
		{
			$pdf->Cell( 12	,0.4,'Jakarta, '.$tglctk,'',0,L,true);
			$pdf->Cell( 12	,0.4,'Approved by','',0,L,true);
			$pdf->Ln();
			$pdf->Cell( 12	,0.4,'Subject Teacher : '.$nmagru,'',0,L,true);
			$pdf->Cell( 12	,0.4,'Principal : '.$kplskl,'',0,L,true);
			$pdf->Cell(  4	,0.4," Page : ".$hlm,'',0,R,true);
		}
	}
};
$pdf->Output();
?>