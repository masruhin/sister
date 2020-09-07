<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04R_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) GRADING SHEET
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdeplj	=$_POST['kdeplj'];
$kdekls	=$_POST['kdekls'];
$sms	=$_POST['sms'];
$midtrm	=$_POST['midtrm'];
$tglctk	=$_POST['tglctk'];

//$thnajr	=$_POST['thnajr'];

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
/*$query	="	SELECT 		t_setthn_sd.*
			FROM 		t_setthn_sd
			WHERE		t_setthn_sd.set='Tahun Ajaran'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];*/

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='1HW'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='2PRJ'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='3TES'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes	=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='4MID'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtmidtes=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='5ST'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtst=$data[bbt];

// dapatkan data guru 
	$logo_pt	="../../images/logo_sd.jpg";
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
	$judul2=$nmasms.'GRADING SHEET REPORT '.$midtrm;

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
				ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw";//t_mstssw.thn_ajaran='". mysql_escape_string($thnajr)."' AND
	$result =mysql_query($query) or die('Query gagal5');
	$bghw	=1;
	$bgprj	=1;
	$bgtes	=1;
	$i=0;
	while($data =mysql_fetch_array($result))
	{
		$cell[$i][0]=$data[nis];
		$nis		=$data[nis];
		$cell[$i][1]=$data[nmassw];
	
		$query2 ="	SELECT 		t_prgrptps_sd.*
					FROM 		t_prgrptps_sd
					WHERE		t_prgrptps_sd.nis	='$nis' AND
									
								t_prgrptps_sd.kdeplj='$kdeplj'";
		$result2=mysql_query($query2) or die('Query gagal');//t_prgrptps_sd.thn_ajaran='$thnajr' 		AND
		$data2	=mysql_fetch_array($result2);
		$y	=1;
		$hw	=0;
		$prj=0;
		$tes=0;
		while($y<9)
		{
			if($data2['hw'."$sms"."$midtrm"."$y"]>0)
				$hw++;
			if($data2['prj'."$sms"."$midtrm"."$y"]>0)
				$prj++;
			$y++;	
		}
		$y	=1;
		while($y<8)
		{
			if($data2['tes'."$sms"."$midtrm"."$y"]>0)
				$tes++;	
			$y++;	
		}
		if($hw>$bghw)
			$bghw=$hw;
		if($prj>$bgprj)
			$bgprj=$prj;
		if($tes>$bgtes)
			$bgtes=$tes;
	
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
		$pdf->Cell(28	,0.3, '',0,0,C); //$alamat1_pt1
		$pdf->Ln();
		$pdf->Cell(28	,0.3, '',0,0,C); // $alamat2_pt2
	
		$pdf->SetFont('Arial','B',8);
		$pdf->Ln(0.5);
		$pdf->Cell(14	,0.4,"Grade : ".$kdekls,0,0,L); 
		$pdf->Cell(14	,0.4,"Subject : ".$nmaplj,0,0,R); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',8);
		$pdf->SetFillColor(153,153,153);
		$pdf->Cell( 0.4	,0.8,'No','LRT',0,C,true); // 0.6
		$pdf->Cell( 3.5	,0.8,'Name','LRT',0,C,true); // 5.5
		$pdf->Cell( 7.9	,0.4,'Knowledge Assessments (KA)'				,'LRT',0,C,true); // 5.2
		$pdf->Cell( 7.9	,0.4,'Skills Assessments (SA)'	,'LRTB',0,C,true); // 5.2
		$pdf->Cell( 2.4	,0.4,'Ave. KA-SA'	,'LRTB',0,C,true);
		$pdf->Cell( 5.9	,0.4,'Spiritual & Social Behavior'		,'LRT',0,C,true); // 5.2 Spiritual & Social Behavior (7 CORE VALUES)
		$pdf->Ln();
		// jumlah   28
	
		$pdf->Cell( 0.4	,0); // 0.6
		$pdf->Cell( 3.5	,0); // 5.5
		$y=1;
		while($y<9)
		{	
			$pdf->Cell( 0.5	,0.4,$y		,'LRTB',0,C,true); // 0.7
			$y++;
		}	
		$pdf->Cell( 0.5	,0.4,'Ave.'		,'LRTB',0,C,true); // 0.9
		$pdf->Cell( 1.0	,0.4,'ST'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'FG'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'LG'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'NG'		,'LRTB',0,C,true);
	
		$y=1;
		while($y<9)
		{
			$pdf->Cell( 0.5	,0.4,$y		,'LRTB',0,C,true);
			$y++;
		}	
		$pdf->Cell( 0.5	,0.4,'Ave.'		,'LRTB',0,C,true); // 0.9
		$pdf->Cell( 1.0	,0.4,'ST'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'FG'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'LG'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'NG'		,'LRTB',0,C,true);
		
		// awal buatan
		$pdf->Cell( 0.8	,0.4,'Ave.'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'LG'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'NG'		,'LRTB',0,C,true);
		// khir buatan
	
		$y=1;
		while($y<8)
		{
			$pdf->Cell( 0.5	,0.4,$y		,'LRTB',0,C,true);
			$y++;
		}	
		$pdf->Cell( 0.8	,0.4,'Ave.'		,'LRTB',0,C,true); // 0.9
		$pdf->Cell( 0.8	,0.4,'LG'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'NG'		,'LRTB',0,C,true);
		
		$pdf->Ln();
		$pdf->SetFont('Arial','',7);
		$pdf->SetFillColor(255,255,255);
		$x=1;
		while($j<$i AND $x<=30)
		{
			$nis	=$cell[$j][0];
			$nmassw	=$cell[$j][1];
			$pdf->Cell( 0.4	,0.5,$no,'LRTB',0,C,true); // 0.6
			$pdf->Cell( 3.5	,0.5,$nmassw,'LRTB',0,L,true); // 5.5

			$query2 ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis' AND
									
									t_prgrptps_sd.kdeplj='$kdeplj'";//t_prgrptps_sd.thn_ajaran='$thnajr' AND
			$result2=mysql_query($query2) or die('Query gagal');
			$data2 =mysql_fetch_array($result2);
			//------hw
			$ttlhw=0;
			$y=1;
			while($y<9)
			{
				$hw=$data2['hw'."$sms"."$midtrm"."$y"];
				
				// awal buatan
				if($hw==0)
					$hw='';
				// khir buatan
				
				$ttlhw=$ttlhw+$hw;
				$pdf->Cell( 0.5	,0.5,"$hw",'LRTB',0,R,true);
				$y++;
			}		
			
			
			
			//awal buatan
			$bghw_x = 100 * $bghw;
			$avghw	=$ttlhw*100/$bghw_x;//AVERAGE KNOWLEDGE
			//$avghw 	=number_format($avghw,2);
			//khir buatan
			
			
			
			//$avghw	=$ttlhw/$bghw;
			$bavghw	=($avghw*$bbthw)/100;
			
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 0.5	,0.5,number_format($avghw),'LRTB',0,R,true);//0.9
			//$pdf->Cell( 0.5	,0.5,$avghw,'LRTB',0,R,true);   
			$pdf->SetFillColor(255,255,255);
			
			// awal buatan
			$y=9;
			$st=$data2['st'."$sms"."$midtrm"."$y"];
			
			if($st==0)
				$st='';
			
			$pdf->Cell( 0.5	,0.5,$st,'LRTB',0,R,true); // ST
			
			$st = $st * 100 / 100; // catatan / 100 nya inputan
			
			$pdf->Cell( 0.5	,0.5,$st,'LRTB',0,R,true);// ST
			// khir buatan
			
			
			
			$queryV 	="	SELECT 	t_mstbbt_sd.*
						FROM 	t_mstbbt_sd
						WHERE	t_mstbbt_sd.kdebbt = '1HW' "; // -- bobot  	Knowledge Assessments (KA)
			$resultV =mysql_query($queryV);
			$dataV 	=mysql_fetch_array($resultV);
			$bbtV	=$dataV[bbt];
			$avghw = number_format($avghw) * $bbtV / 100; // Ave. x 0.7
			
			$queryW 	="	SELECT 	t_mstbbt_sd.*
						FROM 	t_mstbbt_sd
						WHERE	t_mstbbt_sd.kdebbt = '5ST' "; // -- bobot  	ST
			$resultW =mysql_query($queryW);
			$dataW 	=mysql_fetch_array($resultW);
			$bbtW	=$dataW[bbt];
			$st = $st * $bbtW / 100; // ST x 0.3
			
			$fghw = $avghw + $st;
			
			
			
			$fg_x = $fghw;
			
			if($fg_x>100)
				$lg = 'ERR';
			else if($fg_x>=91.5)
				$lg = 'A';
			else if($fg_x>=83.25)
				$lg = 'A-';
			else if($fg_x>=75)
				$lg = 'B+';
			else if($fg_x>=66.5)
				$lg = 'B';
			else if($fg_x>=58.25)
				$lg = 'B-';
			else if($fg_x>=41.5)
				$lg = "C";
			else if($fg_x>=33.25)
				$lg = "C-";
			else //if($fg_x>=25)
				$lg = "D+";
			
			$ng = $fg_x * 4 / 100;
			
			
			
			// khir buatan
			
			//$pdf->SetFillColor(0,0,26);
			$pdf->Cell( 0.8	,0.5,$fghw,'LRTB',0,R,true); // FG hw
			$pdf->Cell( 0.8	,0.5,$lg,'LRTB',0,R,true); // LG
			$pdf->Cell( 0.8	,0.5,number_format($ng,2,',','.'),'LRTB',0,R,true); // NG
			$pdf->SetFillColor(255,255,255);

			//------prj
			$ttlprj=0;
			$y=1;
			while($y<9)
			{
				$prj=$data2['prj'."$sms"."$midtrm"."$y"];
				
				// awal buatan
				if($prj==0)
					$prj='';
				// khir buatan
				
				$ttlprj=$ttlprj+$prj;
				$pdf->Cell( 0.5	,0.5,"$prj",'LRTB',0,R,true);
				$y++;
			}		
			
			
			
			//awal buatan
			$bgprj_x = 100 * $bgprj;//98
			$avgprj	=$ttlprj*100/$bgprj_x;
			//khir buatan
			
			
			
			//$avgprj	=$ttlprj/$bgprj;
			$bavgprj	=($avgprj*$bbtprj)/100;
			
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 0.5	,0.5,number_format($avgprj),'LRTB',0,R,true); // 0.9 
			$pdf->SetFillColor(255,255,255);
			
			// awal buatan
			$y=9;
			$st=$data2['st_'."$sms"."$midtrm"."$y"];
			
			if($st==0)
				$st='';
			
			$pdf->Cell( 0.5	,0.5,$st,'LRTB',0,R,true); // ST
			
			$st = $st * 100 / 100; // catatan / 98 nya inputan
			
			$pdf->Cell( 0.5	,0.5,number_format($st),'LRTB',0,R,true);
			
			
			
			$queryX 	="	SELECT 	t_mstbbt_sd.*
						FROM 	t_mstbbt_sd
						WHERE	t_mstbbt_sd.kdebbt = '2PRJ' "; // -- bobot  	Skills Assessments (SA)
			$resultX =mysql_query($queryX);
			$dataX 	=mysql_fetch_array($resultX);
			$bbtX	=$dataX[bbt];
			$avgprj = number_format($avgprj) * $bbtX / 100; // Ave. x 0.7
			
			$queryY 	="	SELECT 	t_mstbbt_sd.*
						FROM 	t_mstbbt_sd
						WHERE	t_mstbbt_sd.kdebbt = '5ST' "; // -- bobot  	ST
			$resultY =mysql_query($queryY);
			$dataY 	=mysql_fetch_array($resultY);
			$bbtY	=$dataY[bbt];
			$st = number_format($st) * $bbtY / 100; // ST x 0.3
			
			if ($st==0)
				$fgprj = $avgprj;
			else
				$fgprj = $avgprj + $st;
			
			
			
			$fg_x = $fgprj;
			
			if($fg_x>100)
				$lg = 'ERR';
			else if($fg_x>=91.5)
				$lg = 'A';
			else if($fg_x>=83.25)
				$lg = 'A-';
			else if($fg_x>=75)
				$lg = 'B+';
			else if($fg_x>=66.5)
				$lg = 'B';
			else if($fg_x>=58.25)
				$lg = 'B-';
			else if($fg_x>=41.5)
				$lg = "C";
			else if($fg_x>=33.25)
				$lg = "C-";
			else //if($fg_x>=25)
				$lg = "D+";
			
			$ng = $fg_x * 4 / 100;
			
			
			
			// khir buatan
			
			//$pdf->SetFillColor(0,0,26);
			$pdf->Cell( 0.8	,0.5,$fgprj,'LRTB',0,R,true); // FG prj
			$pdf->Cell( 0.8	,0.5,$lg,'LRTB',0,R,true); // LG
			$pdf->Cell( 0.8	,0.5,number_format($ng,2,',','.'),'LRTB',0,R,true); // NG
			$pdf->SetFillColor(255,255,255);
			
			
			
			// awal buatan
			$aveKASA = ($fghw + $fgprj) / 2;
			
			$aveKASA_x = $aveKASA;
			
			if($aveKASA_x>100)
				$lg = 'ERR';
			else if($aveKASA_x>=91.5)
				$lg = 'A';
			else if($aveKASA_x>=83.25)
				$lg = 'A-';
			else if($aveKASA_x>=75)
				$lg = 'B+';
			else if($aveKASA_x>=66.5)
				$lg = 'B';
			else if($aveKASA_x>=58.25)
				$lg = 'B-';
			else if($aveKASA_x>=41.5)
				$lg = "C";
			else if($aveKASA_x>=33.25)
				$lg = "C-";
			else //if($aveKASA_x>=25)
				$lg = "D+";
			
			$ng = $aveKASA_x * 4 / 100;
			
			$pdf->Cell( 0.8	,0.5,$aveKASA,'LRTB',0,R,true); // Ave. KA-SA
			$pdf->Cell( 0.8	,0.5,$lg,'LRTB',0,R,true); // LG
			$pdf->Cell( 0.8	,0.5,number_format($ng,2,',','.'),'LRTB',0,R,true); // NG
			// khir buatan

			
			
			//------tes
			$ttltes=0;
			$y=1;
			while($y<8)
			{
				$tes=$data2['tes'."$sms"."$midtrm"."$y"];
				
				// awal buatan
				if($tes==0)
					$tes='';
				// khir buatan
				
				$ttltes=$ttltes+$tes;
				$pdf->Cell( 0.5	,0.5,"$tes",'LRTB',0,R,true);
				$y++;
			}		
			
			
			
			//awal buatan
			$bgtes_x = 100 * $bgtes;
			$avgtes	=$ttltes*100/$bgtes_x;
			//khir buatan
			
			
			
			//$avgtes	=$ttltes/$bgtes;
			$bavgtes	=($avgtes*$bbttes)/100;
			
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 0.8	,0.5,number_format($avgtes),'LRTB',0,R,true); // 0.9 
			
			// awal buatan
			$avgtes_x = number_format($avgtes);
			
			if($avgtes_x>100)
				$lg = 'ERR';
			else if($avgtes_x>=91.5)
				$lg = 'A';
			else if($avgtes_x>=83.25)
				$lg = 'A-';
			else if($avgtes_x>=75)
				$lg = 'B+';
			else if($avgtes_x>=66.5)
				$lg = 'B';
			else if($avgtes_x>=58.25)
				$lg = 'B-';
			else if($avgtes_x>=41.5)
				$lg = "C";
			else if($avgtes_x>=33.25)
				$lg = "C-";
			else //if($avgtes_x>=25)
				$lg = "D+";
			
			$ng = $avgtes_x * 4 / 100;
			// khir buatan
			
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell( 0.8	,0.5,$lg,'LRTB',0,R,true); // LG
			$pdf->Cell( 0.8	,0.5,number_format($ng,2,',','.'),'LRTB',0,R,true); // NG
			
			$pdf->SetFillColor(255,255,255);

			/*$pdf->Cell( 1.7	,0.5,'','LRTB',0,R,true);
			$ttl	=$bavghw+$bavgprj+$bavgtes;
			$ttl70	=$ttl*((100-$bbtmidtes)/100);
			$pdf->Cell( 1	,0.5,number_format($ttl,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 0.8	,0.5,number_format($ttl70,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(255,255,255);
			$midtes		=$data2['midtes'."$sms"."$midtrm"];
			$midtes30	=($midtes*$bbtmidtes)/100;
			$pdf->Cell( 1	,0.5,$midtes,'LRTB',0,R,true);
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 0.8	,0.5,number_format($midtes30,2,',','.'),'LRTB',0,R,true);
			$pdf->SetFillColor(255,255,255);
		
			$pdf->Cell( 1	,0.5,number_format($ttl70+$midtes30,0,',','.'),'LRTB',0,R,true);*/
		
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