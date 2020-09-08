<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04R_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) GRADING SHEET
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
/*
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
*/

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
//$query	="	SELECT 		t_setthn_sd.*
//			FROM 		t_setthn_sd
//			WHERE		t_setthn_sd.set='Tahun Ajaran'";
//$result	=mysql_query($query) or die('Query gagal1');
//$data 	=mysql_fetch_array($result);
//$thnajr=$data[nli];

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
	//$logo_pt	="../../images/logo_sd.jpg";
	//$logo_ttw	="../../images/tutwurihandayani.jpg";
	
	if($sms=='1')
		$nmasms='FIRST SEMESTER ';
	else
		$nmasms='SECOND SEMESTER ';
	$judul2=$nmasms.'GRADING SHEET REPORT '.$midtrm;

/*
	$pdf =new FPDF('P','cm','A4');
	$pdf->SetMargins(1,0.4,1);
	$pdf->SetAutoPageBreak(True, 0.4);
*/

//AWAL BUATAN BARU
echo"
<html>
    <head>
        <style>
            @media print {
                .parent {
                    overflow: none;
                    display: block;
                }
                .pb_after  { page-break-after: always !important; }
            } 
        </style>
        <script>
            setTimeout(function() {
                window.print();
            }, 1000);
        </script>
    </head>
    <body>
        <div class='parent'>
			<div class='pb_after'>
                <!--Awal Halaman 1-->
					<table width='100%'>
						<tr>
							<td align='left'>
								<img src='../../images/logo_sd.jpg'/>
							</td>
							<td align='center'>
								<h2>
									<b>SAINT JOHN'S PRIMARY SCHOOL</b>
								</h2>
								<h3>
									$judul2<!--SEMESTER GRADING SHEET REPORT-->
								</h3>
							</td>
							<td align='right'>
								<img src='../../images/tutwurihandayani.jpg' height='80px' width='80px'/>
							</td>
						</tr>
					</table>
					
					<br/>
					
					
				
";
/*
//overflow: scroll;
table, th, td {
			  border: 1px solid black;
			  border-collapse: collapse;
			}
*/
//AKHIR BUATAN BARU

// dapatkan data guru 
$queryx 	="	SELECT 		t_mstpng.*
				FROM 		t_mstpng
				WHERE 		(t_mstpng.kdekls='". mysql_escape_string($kdekls)."' OR '$kdekls'='' ) AND
							t_mstpng.kdeplj='". mysql_escape_string($kdeplj)."' AND
							
							(t_mstpng.kdegru != '100000' AND t_mstpng.kdegru != '200000' AND t_mstpng.kdegru != '212070038' AND t_mstpng.kdegru != '208070009' AND t_mstpng.kdegru != '210070019' AND t_mstpng.kdegru != '214080057' )
							
				ORDER BY	t_mstpng.kdekls
				
							";
$resultx =mysql_query($queryx) or die('Query gagal2');
//while ($datax 	=mysql_fetch_array($resultx))
if ($datax 	=mysql_fetch_array($resultx))
{
	$kdekls=$datax[kdekls];

	$query 	="	SELECT 		t_mstpng.*
				FROM 		t_mstpng
				WHERE 		t_mstpng.kdekls='". mysql_escape_string($kdekls)."' AND
							t_mstpng.kdeplj='". mysql_escape_string($kdeplj)."' AND
							
							(t_mstpng.kdegru != '100000' AND t_mstpng.kdegru != '200000' AND t_mstpng.kdegru != '212070038' AND t_mstpng.kdegru != '208070009' AND t_mstpng.kdegru != '210070019' AND t_mstpng.kdegru != '214080057' )
							
							";
	$result =mysql_query($query) or die('Query gagal2');
	$data 	=mysql_fetch_array($result);
	$kdegru=$data[kdegru];

	$query 	="	SELECT 		t_mstkry.*
				FROM 		t_mstkry
				WHERE 		t_mstkry.kdekry='". mysql_escape_string($kdegru)."' AND
				
							t_mstkry.kdestt = 'G01' 
							
							";//(t_mstkry.kdekry != '100000' AND t_mstkry.kdekry != '200000')
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
	
	/*
	if($sms=='1')
		$nmasms='FIRST SEMESTER ';
	else
		$nmasms='SECOND SEMESTER ';
	$judul2=$nmasms.'GRADING SHEET REPORT '.$midtrm;
	*/

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
		
		
		
		//AWAL BUATAN BARU
		$d_ka1 = $data2['ka1_'."$sms"."$midtrm"];
		$d_ka2 = $data2['ka2_'."$sms"."$midtrm"];
		$d_ka3 = $data2['ka3_'."$sms"."$midtrm"];
		$d_ka4 = $data2['ka4_'."$sms"."$midtrm"];
		$d_ka5 = $data2['ka5_'."$sms"."$midtrm"];
		$d_ka6 = $data2['ka6_'."$sms"."$midtrm"];
		$d_ka7 = $data2['ka7_'."$sms"."$midtrm"];
		$d_ka8 = $data2['ka8_'."$sms"."$midtrm"];
		
		$d_sa1 = $data2['sa1_'."$sms"."$midtrm"];
		$d_sa2 = $data2['sa2_'."$sms"."$midtrm"];
		$d_sa3 = $data2['sa3_'."$sms"."$midtrm"];
		$d_sa4 = $data2['sa4_'."$sms"."$midtrm"];
		$d_sa5 = $data2['sa5_'."$sms"."$midtrm"];
		$d_sa6 = $data2['sa6_'."$sms"."$midtrm"];
		$d_sa7 = $data2['sa7_'."$sms"."$midtrm"];
		$d_sa8 = $data2['sa8_'."$sms"."$midtrm"];
		//AKHIR BUATAN BARU
		
		
	
		$i++;
	}

	$hlm=1;
	$no=1;
	$j=0;
	
	
	
	//AWAL WHILE
	/*while($j<$i)
	{*/
		//AWAL BUATAN BARU
		echo"
			<table width='100%'>
				<tr>
					<th align='left'>
						Grade : $kdekls
					</th>
					<th align='center'>
						
					</th>
					<th align='right'>
						Subject : $nmaplj
					</th>
				</tr>
			</table>
			<table width='100%' border='1' style='border-collapse: collapse;'>
				<tr bgcolor=''>
					<th align='center' rowspan='3'>
						No
					</th>
					<th align='center' rowspan='3'>
						Name
					</th>
					<th align='center' colspan='14'>
						<b><u>Knowledge Assessments (KA)</u></b>							<br/><br/>
						Homework, Worksheet, Quiz, Daily Review, Daily Test					<br/><br/>
					</th>
					<th align='center' colspan='14'>
						<b><u>Skills Assessments (SA)</u></b>								<br/><br/>
						Project, Presentation, Pratical Review, Pratical Test				<br/><br/>
					</th>
					<th align='center' colspan='3' bgcolor='lightgreen'>
						Ave. KA-SA 
					</th>
					<th align='center' colspan='10'>
						<b><u>Spiritual & Social Behavior</u></b>
					</th>
				</tr>
				<tr bgcolor='lightgrey'>
					<th align='center' bgcolor='yellow'>$d_ka1<!--1--></th><th align='center' bgcolor='yellow'>$d_ka2<!--2--></th><th align='center' bgcolor='yellow'>$d_ka3<!--3--></th><th align='center' bgcolor='yellow'>$d_ka4<!--4--></th><th align='center' bgcolor='yellow'>$d_ka5<!--5--></th><th align='center' bgcolor='yellow'>$d_ka6<!--6--></th><th align='center' bgcolor='yellow'>$d_ka7<!--7--></th><th align='center' bgcolor='yellow'>$d_ka8<!--8--></th><th align='center'><!--Ave.--></th><th align='center' colspan='2' bgcolor='lightblue'>Mid Test / Final Test<!--ST--></th><th align='center' bgcolor='pink'><!--FG--></th><th align='center' bgcolor='pink'><!--LG--></th><th align='center' bgcolor='pink'><!--NG--></th>
					<th align='center' bgcolor='yellow'>$d_sa1<!--1--></th><th align='center' bgcolor='yellow'>$d_sa2<!--2--></th><th align='center' bgcolor='yellow'>$d_sa3<!--3--></th><th align='center' bgcolor='yellow'>$d_sa4<!--4--></th><th align='center' bgcolor='yellow'>$d_sa5<!--5--></th><th align='center' bgcolor='yellow'>$d_sa6<!--6--></th><th align='center' bgcolor='yellow'>$d_sa7<!--7--></th><th align='center' bgcolor='yellow'>$d_sa8<!--8--></th><th align='center'><!--Ave.--></th><th align='center' colspan='2' bgcolor='lightblue'>Mid Test / Final Test<!--ST--></th><th align='center' bgcolor='pink'><!--FG--></th><th align='center' bgcolor='pink'><!--LG--></th><th align='center' bgcolor='pink'><!--NG--></th>
					<th align='center' bgcolor='lightgreen'><!--Ave.--></th><th align='center' bgcolor='lightgreen'><!--LG--></th><th align='center' bgcolor='lightgreen'><!--NG--></th>
					<th align='center' bgcolor='yellow'>Respect<!--1--></th><th align='center' bgcolor='yellow'>Responsibility<!--2--></th><th align='center' bgcolor='yellow'>Resilience<!--3--></th><th align='center' bgcolor='yellow'>Integrity<!--4--></th><th align='center' bgcolor='yellow'>Generosity<!--5--></th><th align='center' bgcolor='yellow'>Harmony<!--6--></th><th align='center' bgcolor='yellow'>Truth<!--7--></th><th align='center' bgcolor='lightgreen'><!--Ave.--></th><th align='center' bgcolor='lightgreen'><!--LG--></th><th align='center' bgcolor='lightgreen'><!--NG--></th>
				</tr>
				<tr bgcolor='lightgrey'>
					<th align='center' bgcolor='yellow'>1</th><th align='center' bgcolor='yellow'>2</th><th align='center' bgcolor='yellow'>3</th><th align='center' bgcolor='yellow'>4</th><th align='center' bgcolor='yellow'>5</th><th align='center' bgcolor='yellow'>6</th><th align='center' bgcolor='yellow'>7</th><th align='center' bgcolor='yellow'>8</th><th align='center'>Ave.</th><th align='center' colspan='2' bgcolor='lightblue'>ST</th><th align='center' bgcolor='pink'>FG</th><th align='center' bgcolor='pink'>LG</th><th align='center' bgcolor='pink'>NG</th>
					<th align='center' bgcolor='yellow'>1</th><th align='center' bgcolor='yellow'>2</th><th align='center' bgcolor='yellow'>3</th><th align='center' bgcolor='yellow'>4</th><th align='center' bgcolor='yellow'>5</th><th align='center' bgcolor='yellow'>6</th><th align='center' bgcolor='yellow'>7</th><th align='center' bgcolor='yellow'>8</th><th align='center'>Ave.</th><th align='center' colspan='2' bgcolor='lightblue'>ST</th><th align='center' bgcolor='pink'>FG</th><th align='center' bgcolor='pink'>LG</th><th align='center' bgcolor='pink'>NG</th>
					<th align='center' bgcolor='lightgreen'>Ave.</th><th align='center' bgcolor='lightgreen'>LG</th><th align='center' bgcolor='lightgreen'>NG</th>
					<th align='center' bgcolor='yellow'>1</th><th align='center' bgcolor='yellow'>2</th><th align='center' bgcolor='yellow'>3</th><th align='center' bgcolor='yellow'>4</th><th align='center' bgcolor='yellow'>5</th><th align='center' bgcolor='yellow'>6</th><th align='center' bgcolor='yellow'>7</th><th align='center' bgcolor='lightgreen'>Ave.</th><th align='center' bgcolor='lightgreen'>LG</th><th align='center' bgcolor='lightgreen'>NG</th>
				</tr>
			
		";
		//AKHIR BUATAN BARU
		
		/*
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
		*/
		$y=1;
		while($y<9)
		{	
			/*
			$pdf->Cell( 0.5	,0.4,$y		,'LRTB',0,C,true); // 0.7
			*/
			$y++;
		}
		/*		
		$pdf->Cell( 0.5	,0.4,'Ave.'		,'LRTB',0,C,true); // 0.9
		$pdf->Cell( 1.0	,0.4,'ST'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'FG'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'LG'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'NG'		,'LRTB',0,C,true);
		*/
	
		$y=1;
		while($y<9)
		{
			/*
			$pdf->Cell( 0.5	,0.4,$y		,'LRTB',0,C,true);
			*/
			$y++;
		}	
		/*
		$pdf->Cell( 0.5	,0.4,'Ave.'		,'LRTB',0,C,true); // 0.9
		$pdf->Cell( 1.0	,0.4,'ST'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'FG'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'LG'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'NG'		,'LRTB',0,C,true);
		*/
		
		// awal buatan
		/*
		$pdf->Cell( 0.8	,0.4,'Ave.'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'LG'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'NG'		,'LRTB',0,C,true);
		*/
		// khir buatan
	
		$y=1;
		while($y<8)
		{
			/*
			$pdf->Cell( 0.5	,0.4,$y		,'LRTB',0,C,true);
			*/
			$y++;
		}	
		/*
		$pdf->Cell( 0.8	,0.4,'Ave.'		,'LRTB',0,C,true); // 0.9
		$pdf->Cell( 0.8	,0.4,'LG'		,'LRTB',0,C,true);
		$pdf->Cell( 0.8	,0.4,'NG'		,'LRTB',0,C,true);
		
		$pdf->Ln();
		$pdf->SetFont('Arial','',7);
		$pdf->SetFillColor(255,255,255);
		*/
		$x=1;
		while($j<$i AND $x<=30)
		{
			$nis	=$cell[$j][0];
			$nmassw	=$cell[$j][1];
			
			/* lama
			$pdf->Cell( 0.4	,0.5,$no,'LRTB',0,C,true); // 0.6
			$pdf->Cell( 3.5	,0.5,$nmassw,'LRTB',0,L,true); // 5.5
			*/
			
			//AWAL BUATAN BARU
			echo"
				<tr>
					<td>
						$no
					</td>
					<td>
						$nmassw
					</td>
			";
			//AKHIR BUATAN BARU
			
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
				
				/* lama
				$pdf->Cell( 0.5	,0.5,"$hw",'LRTB',0,R,true);
				*/
				
				//AWAL BUATAN BARU
				echo"
					<td align='center'>
						$hw
					</td>
				";
				//AKHIR BUATAN BARU
				
				$y++;
			}		
			
			
			
			//awal buatan
			$bghw_x = 100 * $bghw;
			$avghw	=$ttlhw*100/$bghw_x;//AVERAGE KNOWLEDGE		//$avghw 	=number_format($avghw,2);
			//khir buatan
			
			
			
			//$avghw	=$ttlhw/$bghw;
			$bavghw	=($avghw*$bbthw)/100;
			
			/* lama
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 0.5	,0.5,number_format($avghw),'LRTB',0,R,true);//0.9		//$pdf->Cell( 0.5	,0.5,$avghw,'LRTB',0,R,true);   
			$pdf->SetFillColor(255,255,255);
			*/
			
			//AWAL BUATAN BARU
				//$avghw 	=number_format($avghw);//ASLI
				$avghw 		=number_format($avghw,2,',','.');
				
				echo"
					<td align='center' bgcolor='lightgrey'>
						$avghw
					</td>
				";
			//AKHIR BUATAN BARU
			
			// awal buatan
			$y=9;
			$st=$data2['st'."$sms"."$midtrm"."$y"];
			
			if($st==0)
				$st='';
			
			/* lama
			$pdf->Cell( 0.5	,0.5,$st,'LRTB',0,R,true); // ST
			*/
			
			//AWAL BUATAN BARU
				echo"
					<td align='center'>
						$st
					</td>
				";
			//AKHIR BUATAN BARU
			
			$st = $st * 100 / 100; // catatan / 100 nya inputan
			
			/* lama
			$pdf->Cell( 0.5	,0.5,$st,'LRTB',0,R,true);// ST
			*/
			// khir buatan
			
			//AWAL BUATAN BARU
				echo"
					<td align='center' bgcolor='lightblue'>
						$st
					</td>
				";
			//AKHIR BUATAN BARU
			
			
			
			/*$queryV 	="	SELECT 	t_mstbbt_sd.*
						FROM 	t_mstbbt_sd
						WHERE	t_mstbbt_sd.kdebbt = '1HW' "; // -- bobot  	Knowledge Assessments (KA)
			$resultV =mysql_query($queryV);
			$dataV 	=mysql_fetch_array($resultV);
			$bbtV	=$dataV[bbt];
			$avghw = number_format($avghw,2,',','.') * $bbtV / 100; // Ave. x 0.7			
			//$avghw = number_format($avghw) * $bbtV / 100;
			
			$queryW 	="	SELECT 	t_mstbbt_sd.*
						FROM 	t_mstbbt_sd
						WHERE	t_mstbbt_sd.kdebbt = '5ST' "; // -- bobot  	ST
			$resultW =mysql_query($queryW);
			$dataW 	=mysql_fetch_array($resultW);
			$bbtW	=$dataW[bbt];
			$st = $st * $bbtW / 100; // ST x 0.3
			
			$fghw = $avghw + $st;*/
			
			
			
			//AWAL BUATAN BARU
				$fgk_d=$data2['fgk'."$sms"."$midtrm"];			//$fghw_d 	=number_format($fgk_d);
			//AKHIR BUATAN BARU
				
				
				
			$fg_x = $fgk_d;
			
			if ( $fg_x >= 90.00 AND $fg_x <= 100.00 )
				$lg = 'A';
			else if ( $fg_x >= 80.00 AND $fg_x <= 89.99 )
				$lg = 'B';
			else if ( $fg_x >= 70.00 AND $fg_x <= 79.99 )
				$lg = 'C';
			else if ( $fg_x >= 0.00 AND $fg_x <= 69.99 )
				$lg = 'D';
			else
				$lg = 'ERR';
			
			/*if($fg_x>100)
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
				$lg = "D+";*/
			
			$ng = $fg_x * 4 / 100;
			
			
			
			// khir buatan
			
			/* lama
			//$pdf->SetFillColor(0,0,26);
			$pdf->Cell( 0.8	,0.5,$fghw,'LRTB',0,R,true); // FG hw
			$pdf->Cell( 0.8	,0.5,$lg,'LRTB',0,R,true); // LG
			$pdf->Cell( 0.8	,0.5,number_format($ng,2,',','.'),'LRTB',0,R,true); // NG
			$pdf->SetFillColor(255,255,255);
			*/
			
			//AWAL BUATAN BARU
			$ng_d = number_format($ng,2,',','.');
			
				echo"
					<td align='center' bgcolor='pink'>
						$fgk_d
					</td>
					<td align='center' bgcolor='pink'>
						$lg
					</td>
					<td align='center' bgcolor='pink'>
						$ng_d
					</td>
				";
			//AKHIR BUATAN BARU

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
				
				/* lama
				$pdf->Cell( 0.5	,0.5,"$prj",'LRTB',0,R,true);
				*/
				
				//AWAL BUATAN BARU
					echo"
						<td align='center'>
							$prj
						</td>
					";
				//AKHIR BUATAN BARU
				
				$y++;
			}		
			
			
			
			//awal buatan
			$bgprj_x = 100 * $bgprj;//98
			$avgprj	=$ttlprj*100/$bgprj_x;
			//khir buatan
			
			
			
			//$avgprj	=$ttlprj/$bgprj;
			$bavgprj	=($avgprj*$bbtprj)/100;
			
			/* lama
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 0.5	,0.5,number_format($avgprj),'LRTB',0,R,true); // 0.9 
			$pdf->SetFillColor(255,255,255);
			*/
			
			//AWAL BUATAN BARU
				//$avgprj_d = number_format($avgprj);//ASLI
				$avgprj_d 	= number_format($avgprj,2,',','.');
				
				echo"
					<td align='center' bgcolor='lightgrey'>
						$avgprj_d
					</td>
				";
			//AKHIR BUATAN BARU
			
			// awal buatan
			$y=9;
			$st=$data2['st_'."$sms"."$midtrm"."$y"];
			
			if($st==0)
				$st='';
			
			/* lama
			$pdf->Cell( 0.5	,0.5,$st,'LRTB',0,R,true); // ST
			*/
			
			//AWAL BUATAN BARU
				echo"
					<td align='center'>
						$st
					</td>
				";
			//AKHIR BUATAN BARU
			
			$st = $st * 100 / 100; // catatan / 98 nya inputan
			
			/* lama
			$pdf->Cell( 0.5	,0.5,number_format($st),'LRTB',0,R,true);
			*/
			
			//AWAL BUATAN BARU
				echo"
					<td align='center' bgcolor='lightblue'>
						$st
					</td>
				";
			//AKHIR BUATAN BARU
			
			
			
			/*$queryX 	="	SELECT 	t_mstbbt_sd.*
						FROM 	t_mstbbt_sd
						WHERE	t_mstbbt_sd.kdebbt = '2PRJ' "; // -- bobot  	Skills Assessments (SA)
			$resultX =mysql_query($queryX);
			$dataX 	=mysql_fetch_array($resultX);
			$bbtX	=$dataX[bbt];
			$avgprj = number_format($avgprj,2,',','.') * $bbtX / 100; // Ave. x 0.7		
			//$avgprj = number_format($avgprj) * $bbtX / 100; 
			
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
				$fgprj = $avgprj + $st;*/
			
			
			
			//AWAL BUATAN BARU
				$fgs_d=$data2['fgs'."$sms"."$midtrm"];		//$fgprj_d 	=number_format($fgs_d);
			//AKHIR BUATAN BARU
			
			
			
			$fg_x = $fgs_d;
			
			if ( $fg_x >= 90.00 AND $fg_x <= 100.00 )
				$lg = 'A';
			else if ( $fg_x >= 80.00 AND $fg_x <= 89.99 )
				$lg = 'B';
			else if ( $fg_x >= 70.00 AND $fg_x <= 79.99 )
				$lg = 'C';
			else if ( $fg_x >= 0.00 AND $fg_x <= 69.99 )
				$lg = 'D';
			else
				$lg = 'ERR';
			
			/*if($fg_x>100)
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
				$lg = "D+";*/
			
			$ng = $fg_x * 4 / 100;
			
			
			
			// khir buatan
			
			/* lama
			//$pdf->SetFillColor(0,0,26);
			$pdf->Cell( 0.8	,0.5,$fgprj,'LRTB',0,R,true); // FG prj
			$pdf->Cell( 0.8	,0.5,$lg,'LRTB',0,R,true); // LG
			$pdf->Cell( 0.8	,0.5,number_format($ng,2,',','.'),'LRTB',0,R,true); // NG
			$pdf->SetFillColor(255,255,255);
			*/
			
			//AWAL BUATAN BARU
				$ng_d = number_format($ng,2,',','.');
				
				echo"
					<td align='center' bgcolor='pink'>
						$fgs_d
					</td>
					<td align='center' bgcolor='pink'>
						$lg
					</td>
					<td align='center' bgcolor='pink'>
						$ng_d
					</td>
				";
			//AKHIR BUATAN BARU
			
			
			
			// awal buatan
			$aveKASA = ($fgk_d + $fgs_d) / 2;
			
			$aveKASA_x = $aveKASA;
			
			if ( $aveKASA_x >= 90.00 AND $aveKASA_x <= 100.00 )
				$lg = 'A';
			else if ( $aveKASA_x >= 80.00 AND $aveKASA_x <= 89.99 )
				$lg = 'B';
			else if ( $aveKASA_x >= 70.00 AND $aveKASA_x <= 79.99 )
				$lg = 'C';
			else if ( $aveKASA_x >= 0.00 AND $aveKASA_x <= 69.99 )
				$lg = 'D';
			else
				$lg = 'ERR';
			
			/*if($aveKASA_x>100)
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
				$lg = "D+";*/
			
			$ng = $aveKASA_x * 4 / 100;
			
			/* lama
			$pdf->Cell( 0.8	,0.5,$aveKASA,'LRTB',0,R,true); // Ave. KA-SA
			$pdf->Cell( 0.8	,0.5,$lg,'LRTB',0,R,true); // LG
			$pdf->Cell( 0.8	,0.5,number_format($ng,2,',','.'),'LRTB',0,R,true); // NG
			*/
			// khir buatan
			
			//AWAL BUATAN BARU
				$ng_d = number_format($ng,2,',','.');
				
				echo"
					<td align='center' bgcolor='lightgreen'>
						$aveKASA
					</td>
					<td align='center' bgcolor='lightgreen'>
						$lg
					</td>
					<td align='center' bgcolor='lightgreen'>
						$ng_d
					</td>
				";
			//AKHIR BUATAN BARU
			
			
			
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
				
				/*
				$pdf->Cell( 0.5	,0.5,"$tes",'LRTB',0,R,true);
				*/
				
				//AWAL BUATAN BARU
					echo"
						<td align='center'>
							$tes
						</td>
					";
				//AKHIR BUATAN BARU
				
				$y++;
			}		
			
			
			
			//awal buatan
			$bgtes_x = 100 * $bgtes;
			$avgtes	=$ttltes*100/$bgtes_x;
			//khir buatan
			
			
			
			//$avgtes	=$ttltes/$bgtes;
			$bavgtes	=($avgtes*$bbttes)/100;
			
			/* lama
			$pdf->SetFillColor(229,229,229);
			$pdf->Cell( 0.8	,0.5,number_format($avgtes),'LRTB',0,R,true); // 0.9 
			*/
			
			//AWAL BUATAN BARU
				$avgtes = number_format($avgtes);
				
				echo"
					<td align='center' bgcolor='lightgreen'>
						$avgtes
					</td>
				";
			//AKHIR BUATAN BARU
			
			// awal buatan
			$avgtes_x = number_format($avgtes);
			
			if ( $avgtes_x >= 90.00 AND $avgtes_x <= 100.00 )
				$lg = 'A';
			else if ( $avgtes_x >= 80.00 AND $avgtes_x <= 89.99 )
				$lg = 'B';
			else if ( $avgtes_x >= 70.00 AND $avgtes_x <= 79.99 )
				$lg = 'C';
			else if ( $avgtes_x >= 0.00 AND $avgtes_x <= 69.99 )
				$lg = 'D';
			else
				$lg = 'ERR';
			
			/*if($avgtes_x>100)
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
				$lg = "D+";*/
			
			$ng = $avgtes_x * 4 / 100;
			// khir buatan
			
			/* lama
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell( 0.8	,0.5,$lg,'LRTB',0,R,true); // LG
			$pdf->Cell( 0.8	,0.5,number_format($ng,2,',','.'),'LRTB',0,R,true); // NG
			$pdf->SetFillColor(255,255,255);
			$pdf->Ln();
			*/
			
			//AWAL BUATAN BARU
				$ng_d = number_format($ng,2,',','.');
				
				echo"
						<td align='center' bgcolor='lightgreen'>
							$lg
						</td>
						<td align='center' bgcolor='lightgreen'>
							$ng_d
						</td>
					</tr>
				";
			//AKHIR BUATAN BARU
			
			
			
			$j++;
			$x++;
			$no++;
		}
		
		/*
		$pdf->Ln(0.1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetFillColor(255,255,255);
		*/
		if($j<$i)
		{
			/*
			$pdf->Cell(28	,0.4," Page : ".$hlm." Continued on page ".($hlm+1),'',0,R,true);
			*/
			$hlm++;
		}
		else
		{
			/* lama
			$pdf->Cell( 12	,0.4,'Jakarta, '.$tglctk,'',0,L,true);
			$pdf->Cell( 12	,0.4,'Approved by','',0,L,true);
			$pdf->Ln();
			$pdf->Cell( 12	,0.4,'Subject Teacher : '.$nmagru,'',0,L,true);
			$pdf->Cell( 12	,0.4,'Principal : '.$kplskl,'',0,L,true);
			$pdf->Cell(  4	,0.4," Page : ".$hlm,'',0,R,true);
			*/
		}
		
		//AWAL BUATAN BARU
			echo"
				<table width='100%'>
					<br/>
					<br/>
					<br/>
					<tr>
						<td align='left'>
							Jakarta, $tglctk
							<br/>
							Subject Teacher : $nmagru
						</td>
						<td align='right'>
							Approved by : 
							<br/>
							Principal : $kplskl
						</td>
					</tr>
				</table>
			";
		//AKHIR BUATAN BARU
		
		
		
	/*}*/
	//AKHIR WHILE
	
	
	
};
/*
$pdf->Output();
*/

//AWAL BUATAN BARU
echo"
				</table>
				<!--Akhir Halaman 1-->
            </div>
		</div>
    </body>
</html>
";
//AKHIR BUATAN BARU

?>