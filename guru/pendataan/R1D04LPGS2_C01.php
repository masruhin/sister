<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LPG_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdeplj	=$_POST['kdeplj'];
$kdekls	=$_GET['kdekls'];//nis
$sms	=$_POST['sms'];
$midtrm	='2';//$_POST['midtrm'];
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
$query	="	SELECT 		t_setthn_tk.*
			FROM 		t_setthn_tk
			WHERE		t_setthn_tk.set='Tahun Ajaran'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_tk.*
			FROM 		t_mstbbt_tk
			WHERE		t_mstbbt_tk.kdebbt='1HW'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_tk.*
			FROM 		t_mstbbt_tk
			WHERE		t_mstbbt_tk.kdebbt='2PRJ'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_tk.*
			FROM 		t_mstbbt_tk
			WHERE		t_mstbbt_tk.kdebbt='3TES'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_tk.*
			FROM 		t_mstbbt_tk
			WHERE		t_mstbbt_tk.kdebbt='4MID'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtmidtes=$data[bbt];

// dapatkan data guru 
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

$query 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.nis='". mysql_escape_string($kdekls)."'";
$result =mysql_query($query) or die('Query gagal2');
$data 	=mysql_fetch_array($result);
$nmassw=$data[nmassw];
$kkelas=$data[kdekls];
$tmplhr=$data[tmplhr];
$tgllhr=$data[tgllhr];
$tgllhr=strtotime($tgllhr);
$tgllhr=date('d F, Y',$tgllhr);

$nmaibu =$data[nmaibu];
$nmaayh	=$data[nmaayh];
$almt	=$data[alm];

if( $kkelas == 'PG1' )
	$kkelas = 'Pre-K Nazareth';
else if( $kkelas == 'PG2' )
	$kkelas = 'Pre-K Bethlehem';
else if( $kkelas == 'KG-A1' )
	$kkelas = 'K1 Galilee';
else if( $kkelas == 'KG-A2' )
	$kkelas = 'K1 Jordan';
else if( $kkelas == 'KG-B1' )
	$kkelas = 'K2 Jericho';
else// if( $kkelas == 'KG-B2' )
	$kkelas = 'K2 Jerusalem';
	


$signature	="../../images/Pre-K/".$kdekls.".jpg";

$pdf =new FPDF('P','cm','A4');
$pdf->SetMargins(0.5,0.4,1);
$pdf->SetAutoPageBreak(True, 0.4);











$ttlakh=0;
$ttlavg=0;
$hlm=1;
$no	=1;
$j	=0;
$rnk=1;



//awal halaman 1

$j=0;
//while($j<$i)
//{
	
	
	
	
	//.. sampai sini
	
	
	
	$qABS	="	SELECT 		t_hdrkmnps_pgtk1.*
				FROM 		t_hdrkmnps_pgtk1
				WHERE		t_hdrkmnps_pgtk1.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	$q1KMN=$dABS['kmn'.'2'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN=$dABS['kmn'.'2'.'2']; // q2
	
	$qABS2	="	SELECT 		t_hdrkmnps_pgtk2.*
				FROM 		t_hdrkmnps_pgtk2
				WHERE		t_hdrkmnps_pgtk2.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS2=mysql_query($qABS2) or die('Query gagal40');
	$dABS2=mysql_fetch_array($rABS2);
	$q1KMN2=$dABS2['kmn'.'2'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN2=$dABS2['kmn'.'2'.'2']; // q2
	
	$qABS3	="	SELECT 		t_hdrkmnps_pgtk3.*
				FROM 		t_hdrkmnps_pgtk3
				WHERE		t_hdrkmnps_pgtk3.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS3=mysql_query($qABS3) or die('Query gagal40');
	$dABS3=mysql_fetch_array($rABS3);
	$q1KMN3=$dABS3['kmn'.'2'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN3=$dABS3['kmn'.'2'.'2']; // q2
	
	$qABS4	="	SELECT 		t_hdrkmnps_pgtk4.*
				FROM 		t_hdrkmnps_pgtk4
				WHERE		t_hdrkmnps_pgtk4.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS4=mysql_query($qABS4) or die('Query gagal40');
	$dABS4=mysql_fetch_array($rABS4);
	$q1KMN4=$dABS4['kmn'.'2'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN4=$dABS4['kmn'.'2'.'2']; // q2
	
	$qABS5	="	SELECT 		t_hdrkmnps_pgtk5.*
				FROM 		t_hdrkmnps_pgtk5
				WHERE		t_hdrkmnps_pgtk5.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS5=mysql_query($qABS5) or die('Query gagal40');
	$dABS5=mysql_fetch_array($rABS5);
	$q1KMN5=$dABS5['kmn'.'2'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN5=$dABS5['kmn'.'2'.'2']; // q2
	
	//..halaman 2
	//----
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(255,255,255); 
	$pdf->Cell( 5.5	,0.4,'','',0,C,true);
	$pdf->Cell(1, 1, "FOURTH TERM", '', 0, C, true);
	$pdf->Ln(0.75);
	$pdf->Cell( 5.5	,0.4,'','',0,C,true);
	$pdf->Cell(1, 1, "TEACHER'S REMARK", '', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1.5, 1, "1. Personal, Social, and Emotional Development", '', 0, L, true);//LRTB
	//1
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN,0,81), 'LRT', 0, J, true);
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN,81,81), 'LR', 0, J, true);
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN,162,81), 'LR', 0, J, true);
	//4
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN,243,81), 'LR', 0, J, true);														
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN,324,81), 'LRB', 0, J, true);
	
	
	
	$pdf->Ln(0.5);																										
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "2. Communication, Language and Literacy", '', 0, L, true);										
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,0,81), 'LRT', 0, J, true);														
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,81,81), 'LR', 0, J, true);														
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,162,81), 'LR', 0, J, true);													
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,false);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,243,81), 'LR', 0, J, false);													
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,324,81), 'LRB', 0, L, true);													
	
	
	$pdf->Ln(0.5);																										
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "3. Mathematical/Cognitive Development", '', 0, L, true);										
	
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN3,0,81), 'LRT', 0, J, true);														
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN3,81,81), 'LR', 0, J, true);														
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN3,162,81), 'LR', 0, J, true);													
	
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN3,243,81), 'LR', 0, J, true);													
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN3,324,81), 'LRB', 0, J, true);													
	
	
	
	$pdf->Ln(0.5);																														
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "4. Creative Development", '', 0, L, true);
	
	
	
	
	
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN4,0,81), 'LRT', 0, J, true);														
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN4,81,81), 'LR', 0, J, true);															
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN4,162,81), 'LR', 0, J, true);														
	//4
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN4,243,81), 'LR', 0, J, true);
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN4,324,81), 'LRB', 0, J, true);														
	
	
	
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','BU',11);
	//$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(1, 0.5, "5. Physical Development (Gross and Fine Motor Skills)", '', 0, L, true);							
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN5,0,81), 'LRT', 0, J, true);															
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN5,81,81), 'LR', 0, J, true);															
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN5,162,81), 'LR', 0, J, true);														
	//4
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN5,243,81), 'LR', 0, J, true);
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN5,324,81), 'LRB', 0, J, true);
	
	
	
	
	
	
	
	//ktr1
	$qLG	="	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='PG1' OR t_lrcd_tk.kdekls='PG2' ) AND t_lrcd_tk.kde LIKE 'PG-A%' ";
	$rLG=mysql_query($qLG) or die('Query gagal40');
	$i=0;
	while($dLG =mysql_fetch_array($rLG))
	{
		$nmektr[$i][0]=$dLG['nmektr'];
		$i++;
	}
	
	//ktr2
	$qLG2	="	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='PG1' OR t_lrcd_tk.kdekls='PG2' ) AND t_lrcd_tk.kde LIKE 'PG-C%' ";
	$rLG2=mysql_query($qLG2) or die('Query gagal40');
	$i=0;
	while($dLG2 =mysql_fetch_array($rLG2))
	{
		$nmektr2[$i][0]=$dLG2['nmektr'];
		$i++;
	}
	
	//ktr3
	$qLG3	="	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='PG1' OR t_lrcd_tk.kdekls='PG2' ) AND t_lrcd_tk.kde LIKE 'PG-D%' ";
	$rLG3=mysql_query($qLG3) or die('Query gagal40');
	$i=0;
	while($dLG3=mysql_fetch_array($rLG3))
	{
		$nmektr3[$i][0]=$dLG3['nmektr'];
		$i++;
	}
	
	//ktr4
	$qLG4	="	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='PG1' OR t_lrcd_tk.kdekls='PG2' ) AND t_lrcd_tk.kde LIKE 'PG-E%' ";
	$rLG4=mysql_query($qLG4) or die('Query gagal40');
	$i=0;
	while($dLG4 =mysql_fetch_array($rLG4))
	{
		$nmektr4[$i][0]=$dLG4['nmektr'];
		$i++;
	}
	
	//ktr5
	$qLG5	="	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='PG1' OR t_lrcd_tk.kdekls='PG2' ) AND t_lrcd_tk.kde LIKE 'PG-B%' ";
	$rLG5=mysql_query($qLG5) or die('Query gagal40');
	$i=0;
	while($dLG5 =mysql_fetch_array($rLG5))
	{
		$nmektr5[$i][0]=$dLG5['nmektr'];
		$i++;
	}
	
	
	
	//nli1
	$qLGKG	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kdekls' AND ( t_learnrcd_tk.kdekls='PG1' OR t_learnrcd_tk.kdekls='PG2' ) AND t_learnrcd_tk.kdeplj='PG-A' ";
	$rLGKG=mysql_query($qLGKG) or die('Query gagal40');
	$dLGKG =mysql_fetch_array($rLGKG);
	$i=1;
	$j=1;
	while($i<26)
	{
		$q1nli[$i][0]=$dLGKG['hw'.'2'.'1'."$j"];
		$q2nli[$i][0]=$dLGKG['hw'.'2'.'2'."$j"];
		
		
		
		if( $q2nli[$i][0]=='v'OR$q2nli[$i][0]=='V' )
			$smstr1[$i][0] = 'VS';
		else if( $q2nli[$i][0]=='-' )
			$smstr1[$i][0] = 'S';
			
		else if( $q2nli[$i][0]=='v' OR $q2nli[$i][0]=='V' )
			$smstr1[$i][0] = 'VS';
		else if( $q2nli[$i][0]=='v' OR $q2nli[$i][0]=='V' )
			$smstr1[$i][0] = 'VS';
			
		else if( $q2nli[$i][0]=='+' )
			$smstr1[$i][0] = 'S';
		else if( $q2nli[$i][0]=='NO' )
			$smstr1[$i][0] = 'NO';
			
		else if( $q2nli[$i][0]=='+' )
			$smstr1[$i][0] = 'S';
		else if( $q2nli[$i][0]=='/' )
			$smstr1[$i][0] = 'MS';
			
		else if( $q2nli[$i][0]=='+' )
			$smstr1[$i][0] = 'S';
		else if( $q2nli[$i][0]=='v' )
			$smstr1[$i][0] = 'VS';
		
		$i++;
		$j++;
	}
	
	//nli2
	$qLGKG2	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kdekls' AND ( t_learnrcd_tk.kdekls='PG1' OR t_learnrcd_tk.kdekls='PG2' ) AND t_learnrcd_tk.kdeplj='PG-C' ";
	$rLGKG2=mysql_query($qLGKG2) or die('Query gagal40');
	$dLGKG2 =mysql_fetch_array($rLGKG2);
	$i=1;
	$j=1;
	while($i<26)
	{
		$q1nliB[$i][0]=$dLGKG2['hw'.'2'.'1'."$j"];
		$q2nliB[$i][0]=$dLGKG2['hw'.'2'.'2'."$j"];
		
		
		
		if( $q2nliB[$i][0]=='v' OR $q2nliB[$i][0]=='V' )
			$smstr1B[$i][0] = 'VS';
		else if( $q2nliB[$i][0]=='-' )
			$smstr1B[$i][0] = 'S';
			
		else if( $q2nliB[$i][0]=='v' OR $q2nliB[$i][0]=='V' )
			$smstr1B[$i][0] = 'VS';
		else if( $q2nliB[$i][0]=='v' OR $q2nliB[$i][0]=='V' )
			$smstr1B[$i][0] = 'VS';
			
		else if( $q2nliB[$i][0]=='+' )
			$smstr1B[$i][0] = 'S';
		else if( $q2nliB[$i][0]=='NO' )
			$smstr1B[$i][0] = 'NO';
			
		else if( $q2nliB[$i][0]=='+' )
			$smstr1B[$i][0] = 'S';
		else if( $q2nliB[$i][0]=='/' )
			$smstr1B[$i][0] = 'MS';
			
		else if( $q2nliB[$i][0]=='+' )
			$smstr1B[$i][0] = 'S';
		//..
		else if( $q2nliB[$i][0]=='v' OR $q2nliB[$i][0]=='V' )
			$smstr1B[$i][0] = 'VS';
		else if( $q2nliB[$i][0]=='/' )
			$smstr1B[$i][0] = 'MS';
		
		else if( $q2nliB[$i][0]=='+' )
			$smstr1B[$i][0] = 'S';
		else if( $q2nliB[$i][0]=='v' OR $q2nliB[$i][0]=='V' )
			$smstr1B[$i][0] = 'VS';
		
		
		
		
		
		$i++;
		$j++;
	}
	
	//nli3
	$qLGKG3	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kdekls' AND ( t_learnrcd_tk.kdekls='PG1' OR t_learnrcd_tk.kdekls='PG2' ) AND t_learnrcd_tk.kdeplj='PG-D' ";
	$rLGKG3=mysql_query($qLGKG3) or die('Query gagal40');
	$dLGKG3 =mysql_fetch_array($rLGKG3);
	$i=1;
	$j=1;
	while($i<26)
	{
		$q1nliC[$i][0]=$dLGKG3['hw'.'2'.'1'."$j"];
		$q2nliC[$i][0]=$dLGKG3['hw'.'2'.'2'."$j"];
		
		
		
		if( $q2nliC[$i][0]=='v'OR$q2nliC[$i][0]=='V' )
			$smstr1C[$i][0] = 'VS';
		else if( $q2nliC[$i][0]=='-' )
			$smstr1C[$i][0] = 'S';
			
		else if( $q2nliC[$i][0]=='v' OR $q2nliC[$i][0]=='V' )
			$smstr1C[$i][0] = 'VS';
		else if( $q2nliC[$i][0]=='v' OR $q2nliC[$i][0]=='V' )
			$smstr1C[$i][0] = 'VS';
			
		else if( $q2nliC[$i][0]=='+' )
			$smstr1C[$i][0] = 'S';
		else if( $q2nliC[$i][0]=='NO' )
			$smstr1C[$i][0] = 'NO';
			
		else if( $q2nliC[$i][0]=='+' )
			$smstr1C[$i][0] = 'S';
		else if( $q2nliC[$i][0]=='/' )
			$smstr1C[$i][0] = 'MS';
			
		else if( $q2nliC[$i][0]=='+' )
			$smstr1C[$i][0] = 'S';
		else if( $q2nliC[$i][0]=='v' )
			$smstr1C[$i][0] = 'VS';
		//..
		else if( $q2nliC[$i][0]=='v' OR $q2nliC[$i][0]=='V' )
			$smstr1C[$i][0] = 'VS';
		else if( $q2nliC[$i][0]=='/' )
			$smstr1C[$i][0] = 'MS';
		
		else if( $q2nliC[$i][0]=='+' )
			$smstr1C[$i][0] = 'S';
		else if( $q2nliC[$i][0]=='v' OR $q2nliC[$i][0]=='V' )
			$smstr1C[$i][0] = 'VS';
		
		else if( $q2nliC[$i][0]=='+' )
			$smstr1C[$i][0] = 'S';
		
		
		
		
		
		$i++;
		$j++;
	}
	
	//nli4
	$qLGKG4	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kdekls' AND ( t_learnrcd_tk.kdekls='PG1' OR t_learnrcd_tk.kdekls='PG2' ) AND t_learnrcd_tk.kdeplj='PG-E' ";
	$rLGKG4=mysql_query($qLGKG4) or die('Query gagal40');
	$dLGKG4 =mysql_fetch_array($rLGKG4);
	$i=1;
	$j=1;
	while($i<26)
	{
		$q1nliD[$i][0]=$dLGKG4['hw'.'2'.'1'."$j"];
		$q2nliD[$i][0]=$dLGKG4['hw'.'2'.'2'."$j"];
		
		
		
		if( $q2nliD[$i][0]=='v' OR $q2nliD[$i][0]=='V' )
			$smstr1D[$i][0] = 'VS';
		else if( $q2nliD[$i][0]=='-' )
			$smstr1D[$i][0] = 'S';
			
		else if( $q2nliD[$i][0]=='v' OR $q2nliD[$i][0]=='V' )
			$smstr1D[$i][0] = 'VS';
		else if( $q2nliD[$i][0]=='v' OR $q2nliD[$i][0]=='V' )
			$smstr1D[$i][0] = 'VS';
			
		else if( $q2nliD[$i][0]=='+' )
			$smstr1D[$i][0] = 'S';
		else if( $q2nliD[$i][0]=='NO' )
			$smstr1D[$i][0] = 'NO';
			
		else if( $q2nliD[$i][0]=='+' )
			$smstr1D[$i][0] = 'S';
		else if( $q2nliD[$i][0]=='/' )
			$smstr1D[$i][0] = 'MS';
			
		else if( $q2nliD[$i][0]=='+' )
			$smstr1D[$i][0] = 'S';
		else if( $q2nliD[$i][0]=='v' )
			$smstr1D[$i][0] = 'VS';
		
		
		
		$i++;
		$j++;
	}
	
	//nli5
	$qLGKG5	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kdekls' AND ( t_learnrcd_tk.kdekls='PG1' OR t_learnrcd_tk.kdekls='PG2' ) AND t_learnrcd_tk.kdeplj='PG-B' ";
	$rLGKG5=mysql_query($qLGKG5) or die('Query gagal40');
	$dLGKG5 =mysql_fetch_array($rLGKG5);
	$i=1;
	$j=1;
	while($i<26)
	{
		$q1nliE[$i][0]=$dLGKG5['hw'.'2'.'1'."$j"];
		$q2nliE[$i][0]=$dLGKG5['hw'.'2'.'2'."$j"];
		
		//..yang lngkap
		
		if( $q2nliE[$i][0]=='*' )
			$smstr1E[$i][0] = 'O';
		
		else if( $q2nliE[$i][0]=='v' OR $q2nliE[$i][0]=='V' )
			$smstr1E[$i][0] = 'VS';
		else if( $q2nliE[$i][0]=='+' )
			$smstr1E[$i][0] = 'S';
		
		else if( $q2nliE[$i][0]=='/' )
			$smstr1E[$i][0] = 'MS';
		else if( $q2nliE[$i][0]=='ND' )
			$smstr1E[$i][0] = 'NH';
		
		else if( $q2nliE[$i][0]=='NO' )
			$smstr1E[$i][0] = 'NO';
		else //if( $q2nliE[$i][0]=='-' )
			$smstr1E[$i][0] = 'S';
		
		
		
		$i++;
		$j++;
	}
	
	
	
	
	
	
	
	
	
	
	//..halaman 3
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell( 5	,0.4,'','',0,C,true);
	$pdf->Cell(3, 1, "Personal, Social and Emotional Development", '', 0, C, true);				$pdf->SetFont('Arial','B',11);	$pdf->Cell( 12.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.75, 'THIRD TERM', '', 0, C, true);					
	
	//1
	$pdf->Ln(0.5);																				$pdf->SetFont('Arial','B',14);	$pdf->Cell( 20.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 1, "REMARKS", '', 0, C, true);					
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(7.5, 1, "Learning Goals", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(1.5, 1, "TERM 3", 'LRT', 0, C, true);
	$pdf->Cell(1.5, 1, "TERM 4", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(2.75, 1, "SEMESTER 2", 'LRT', 0, C, true);										
	$pdf->Ln(1);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "A. Disposition and attitude", 'LRT', 0, L, true);				$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.5	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);						$pdf->Cell(1, 0.5, "1. Personal, Social, and Emotional Development", '', 0, L, true);
	
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "1", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[0][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[1][0], 'LRT', 0, C, true);//$dLGKG['hw'.'1'.'1'."1"]
	$pdf->Cell(1.5	, 1, $q2nli[1][0], 'LRT', 0, C, true);//$dLGKG['hw'.'1'.'2'."1"]
	$pdf->Cell(2.75	, 1, $smstr1[1][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN,0,90), 'LRT', 0, J, true);
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[0][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN,90,90), 'LR', 0, J, true);
	
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "2", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[1][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[2][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[2][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[2][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN,180,90), 'LR', 0, J, true);
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[1][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN,270,90), 'LR', 0, J, true);
	
	
	
	
	
	
	
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "3", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[2][0] ,0,53 ), 'RT', 0, J, true);					
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1.5, $q1nli[3][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.5, $q2nli[3][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1.5, $smstr1[3][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN,360,90), 'LRB', 0, J, true);	
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[2][0] ,53,53 ), 'R', 0, J, true);
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[2][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 8.25	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.5, "2. Communication, Language and Literacy", '', 0, L, true);
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "B. Self-care and independence", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);			$pdf->SetFillColor(255,255,255);				$pdf->Cell(11.5, 0.5, substr($q1KMN2,0,90), 'LRT', 0, J, true);
	
	
	
	
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "4", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[3][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[4][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[4][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[4][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN2,90,90), 'LR', 0, J, true);
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[3][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN2,180,90), 'LR', 0, J, true);
	
	
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "5", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[4][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 0.5, $q1nli[5][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, $q2nli[5][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, $smstr1[5][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN2,270,90), 'LR', 0, J, true);	
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "C. Confidence and Self-esteem", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN2,360,90), 'LRB', 0, J, true);
	
	
	
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "6", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[5][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[6][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[6][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[6][0], 'LRT', 0, C, true);										
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[5][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 8.25	,0.5,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(1, 0.5, "3. Mathematical/Cognitive Development", '', 0, L, true);
	
	
	
	
	
	
	
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "7", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[6][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[7][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[7][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[7][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN3,0,90), 'LRT', 0, J, true);
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[6][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN3,90,90), 'LR', 0, J, true);
	
	//8
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "8", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[7][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[8][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[8][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[8][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q1KMN3,180,90), 'LR', 0, J, true);
	//8
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[7][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q1KMN3,270,90), 'LR', 0, J, true);
	
	//9
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "9", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[8][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[9][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[9][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[9][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);		$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q1KMN3,360,90), 'LRB', 0, J, true);
	//9
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[8][0] ,53,53 ), 'R', 0, J, true);					
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "D. Behaviour and self-control", 'LRT', 0, L, true);					$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.5	,0.5,'','',0,C,false);	$pdf->SetFillColor(255,255,255);										$pdf->Cell(1, 0.5, "4. Creative Development", '', 0, L, true);
	
	
	
	
	
	
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "10", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[9][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[10][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[10][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[10][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN4,0,90), 'LRT', 0, J, true);
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[9][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);			$pdf->Cell(11.5, 0.5, substr($q1KMN4,90,90), 'LR', 0, J, true);	
	
	//11
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "11", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[10][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[11][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[11][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[11][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN4,180,90), 'LR', 0, J, true);
	//11
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[10][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);			$pdf->Cell(11.5, 0.5, substr($q1KMN4,270,90), 'LR', 0, J, true);
		
	//12
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "12", 'LTB', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[11][0] ,0,53 ), 'RTB', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 0.5, $q1nli[12][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 0.5, $q2nli[12][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 0.5, $smstr1[12][0], 'LRTB', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);		$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN4,360,90), 'LRB', 0, J, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, '', '', 0, J, false);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, '', '', 0, J, false);												$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 8.25	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.5, "5. Physical Development (Gross and Fine Motor Skills)", '', 0, L, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, '', '', 0, J, false);												$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN5,0,90), 'LRT', 0, J, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, '', '', 0, J, false);												$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);				$pdf->Cell(11.5, 0.5, substr($q1KMN5,90,90), 'LR', 0, J, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, '', '', 0, J, false);												$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN5,180,90), 'LR', 0, J, true);						
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, '', '', 0, J, false);												$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN5,270,90), 'LR', 0, J, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, '', '', 0, J, false);												$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN5,360,90), 'LRB', 0, J, true);						
	
	
	
	
	
	
	
	//..mpe sini
	//..halaman 4
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell( 5	,0.4,'','',0,C,true);
	$pdf->Cell(3, 0.8, "Mathematical / Cognitive Development", '', 0, C, true);					$pdf->SetFont('Arial','B',13);	$pdf->Cell( 12.5	,0.4,'','',0,C,false);					$pdf->Cell(3, 0.75, 'Creative Development', '', 0, C, true);					
	
	//1
	$pdf->Ln(0.8);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(7.5, 0.8, "Learning Goals", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(1.5, 0.8, "TERM 3", 'LRT', 0, C, true);
	$pdf->Cell(1.5, 0.8, "TERM 4", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(2.75, 0.8, "SEMESTER 2", 'LRT', 0, C, true);										$pdf->SetFont('Arial','B',13);	$pdf->Cell( 2.25	,0.8,'','',0,C,false);					$pdf->Cell(7.5, 0.8, "Learning Goals", 'LRT', 0, C, true);	$pdf->SetFont('Arial','B',10);													$pdf->Cell(1.5, 0.8, "TERM 3", 'LRT', 0, C, true);	$pdf->Cell(1.5, 0.8, "TERM 4", 'LRT', 0, C, true);	$pdf->SetFont('Arial','B',11);					$pdf->Cell(2.75, 0.8, "SEMESTER 2", 'LRT', 0, C, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.4, "A. Numbers for Counting and labels", 'LRT', 0, L, true);			$pdf->SetFont('Arial','BU',10);	$pdf->Cell( 2.25	,0.8,'','',0,C,false);					$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.25, 0.4, "A. Exploring Media and Materials", 'LRT', 0, L, true);
	
	
	
	//1
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "1", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[0][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 0.8, $q1nliB[1][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, $q2nliB[1][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.8, $smstr1B[1][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "1", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr3[0][0] ,0,53 ), 'RT', 0, J, true);								$pdf->SetFont('Arial','',11);					$pdf->Cell(1.5	, 0.8, $q1nliC[1][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliC[1][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1C[1][0], 'LRT', 0, C, true);
	//1
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[0][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[0][0] ,53,53 ), 'R', 0, J, true);
	
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "2", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[1][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 0.8, $q1nliB[2][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, $q2nliB[2][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.8, $smstr1B[2][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "2", 'LT', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[1][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.5	, 0.8, $q1nliC[2][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliC[2][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1C[2][0], 'LRT', 0, C, true);
	//2
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[1][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[1][0] ,53,53 ), 'R', 0, J, true);
	
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "3", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[2][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 0.8, $q1nliB[3][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, $q2nliB[3][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.8, $smstr1B[3][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "3", 'LT', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[2][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.5	, 0.8, $q1nliC[3][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliC[3][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1C[3][0], 'LRT', 0, C, true);
	//3
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[2][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[2][0] ,53,53 ), 'R', 0, J, true);
	
	//4
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "4", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[3][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 0.8, $q1nliB[4][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, $q2nliB[4][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.8, $smstr1B[4][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "4", 'LT', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[3][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.5	, 0.8, $q1nliC[4][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliC[4][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1C[4][0], 'LRT', 0, C, true);
	//4
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[3][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[3][0] ,53,53 ), 'R', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.4, "B. Calculating", 'LRT', 0, L, true);								$pdf->SetFont('Arial','BU',10);	$pdf->Cell( 2.25	,0.8,'','',0,C,false);					$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.25, 0.4, "B. Music", 'LRT', 0, L, true);
	
	//5
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "5", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[4][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1.2, $q1nliB[5][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.2, $q2nliB[5][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1.2, $smstr1B[5][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "5", 'LT', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[4][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.5	, 0.4, $q1nliC[5][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, $q2nliC[5][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, $smstr1C[5][0], 'LRT', 0, C, true);
	//5
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[4][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "6", 'LT', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[5][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.5	, 0.8, $q1nliC[6][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliC[6][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1C[6][0], 'LRT', 0, C, true);
	//5
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[4][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[5][0] ,53,53 ), 'R', 0, J, true);
	
	
	
	//6
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "6", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[5][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 0.8, $q1nliB[6][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, $q2nliB[6][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.8, $smstr1B[6][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "7", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr3[6][0] ,0,53 ), 'RT', 0, J, true);								$pdf->SetFont('Arial','',11);					$pdf->Cell(1.5	, 0.4, $q1nliC[7][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, $q2nliC[7][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, $smstr1C[7][0], 'LRT', 0, C, true);
	//6
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[5][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "8", 'LT', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[7][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.5	, 0.4, $q1nliC[8][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, $q2nliC[8][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, $smstr1C[8][0], 'LRT', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.4, "C. Shape, Space and Measure", 'LRT', 0, L, true);					$pdf->SetFont('Arial','BU',10);	$pdf->Cell( 2.25	,0.8,'','',0,C,false);					$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.25, 0.4, "C. Responding to and Expressing Ideas", 'LRT', 0, L, true);
	
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "7", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[6][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1.2, $q1nliB[7][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.2, $q2nliB[7][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1.2, $smstr1B[7][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "9", 'LT', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[8][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.5	, 0.8, $q1nliC[9][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliC[9][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1C[9][0], 'LRT', 0, C, true);
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[6][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[8][0] ,53,53 ), 'R', 0, J, true);
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[6][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "10", 'LT', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[9][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.5	, 1.2, $q1nliC[10][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1.2, $q2nliC[10][0], 'LRT', 0, C, true);		$pdf->Cell(2.75	, 1.2, $smstr1C[10][0], 'LRT', 0, C, true);
	
	//8
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "8", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[7][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 0.8, $q1nliB[8][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, $q2nliB[8][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.8, $smstr1B[8][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);				$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[9][0] ,53,53 ), 'R', 0, J, true);
	//8
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[7][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[9][0] ,106,53 ), 'R', 0, J, true);
	
	
	
	//9
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "9", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[8][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1.2, $q1nliB[9][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.2, $q2nliB[9][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1.2, $smstr1B[9][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "11", 'LT', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[10][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.5	, 0.8, $q1nliC[11][0], 'LRTB', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliC[11][0], 'LRTB', 0, C, true);		$pdf->Cell(2.75	, 0.8, $smstr1C[11][0], 'LRTB', 0, C, true);
	//9
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[8][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr3[10][0] ,53,53 ), 'RB', 0, J, true);
	//9
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[8][0] ,106,53 ), 'R', 0, J, true);
	
	
	//10
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "10", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[9][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1.2, $q1nliB[10][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 1.2, $q2nliB[10][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 1.2, $smstr1B[10][0], 'LRTB', 0, C, true);									
	//10
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[9][0] ,53,53 ), 'R', 0, J, true);
	//10
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr2[9][0] ,106,53 ), 'RB', 0, J, true);
	
	
	
	
	
	
	
	
	
	
	//..halaman 5
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell( 5	,0.4,'','',0,C,true);
	$pdf->Cell(3, 0.8, "Physical Development (Gross and Fine Motor)", '', 0, C, true);			$pdf->SetFont('Arial','B',13);	$pdf->Cell( 12.5	,0.4,'','',0,C,false);					$pdf->Cell(3, 0.8, 'Communication, Language and Literacy', '', 0, C, true);					
	
	//1
	$pdf->Ln(0.8);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(7.5, 0.8, "Learning Goals", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(1.5, 0.8, "TERM 3", 'LRT', 0, C, true);
	$pdf->Cell(1.5, 0.8, "TERM 4", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(2.75, 0.8, "SEMESTER 2", 'LRT', 0, C, true);										$pdf->SetFont('Arial','B',13);	$pdf->Cell( 2.25	,0.8,'','',0,C,false);					$pdf->Cell(7.5, 0.8, "Learning Goals", 'LRT', 0, C, true);	$pdf->SetFont('Arial','B',10);													$pdf->Cell(1.5, 0.8, "TERM 3", 'LRT', 0, C, true);								$pdf->Cell(1.5, 0.8, "TERM 4", 'LRT', 0, C, true);	$pdf->SetFont('Arial','B',11);					$pdf->Cell(2.75, 0.8, "SEMESTER 2", 'LRT', 0, C, true);
	$pdf->Ln(0.8);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.4, "A. Gross Motor Development", 'LRT', 0, L, true);					$pdf->SetFont('Arial','BU',10);	$pdf->Cell( 2.25	,0.8,'','',0,C,false);					$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.25, 0.4, "A. Listening", 'LRT', 0, L, true);
	
	//1
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "1", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[0][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.5	, 1.2, $q1nliD[1][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.2, $q2nliD[1][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1.2, $smstr1D[1][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "1", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[0][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.4, $q1nliE[1][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, $q2nliE[1][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, $smstr1E[1][0], 'LRT', 0, C, true);
	//1
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[0][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "2", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[1][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.4, $q1nliE[2][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, $q2nliE[2][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, $smstr1E[2][0], 'LRT', 0, C, true);
	//1
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[0][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "3", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[2][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.8, $q1nliE[3][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliE[3][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1E[3][0], 'LRT', 0, C, true);
	
	
	//2
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "2", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[1][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.5	, 1.6, $q1nliD[2][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.6, $q2nliD[2][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1.6, $smstr1D[2][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr5[2][0] ,53,53 ), 'R', 0, J, true);
	//2
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[1][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "4", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[3][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.8, $q1nliE[4][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliE[4][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1E[4][0], 'LRT', 0, C, true);
	//2
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[1][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr5[3][0] ,53,53 ), 'R', 0, J, true);
	//2
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[1][0] ,159,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','BU',10);	$pdf->Cell( 8	,0.8,'','',0,C,false);						$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.25, 0.4, "B. Speaking", 'LRT', 0, L, true);
	
	//3
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "3", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[2][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.5	, 1.2, $q1nliD[3][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.2, $q2nliD[3][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1.2, $smstr1D[3][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "5", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[4][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.8, $q1nliE[5][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliE[5][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1E[5][0], 'LRT', 0, C, true);
	//3
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[2][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr5[4][0] ,53,53 ), 'R', 0, J, true);
	//3
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[2][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "6", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[5][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.8, $q1nliE[6][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliE[6][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1E[6][0], 'LRT', 0, C, true);
	
	//4
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "4", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[3][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.5	, 0.8, $q1nliD[4][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, $q2nliD[4][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.8, $smstr1D[4][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr5[5][0] ,53,53 ), 'R', 0, J, true);
	//4
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[3][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "7", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[6][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 1.2, $q1nliE[7][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1.2, $q2nliE[7][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1.2, $smstr1E[7][0], 'LRT', 0, C, true);
	
	//5
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "5", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[4][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.5	, 0.8, $q1nliD[5][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, $q2nliD[5][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.8, $smstr1D[5][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);				$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr5[6][0] ,53,53 ), 'R', 0, J, true);
	//5
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[4][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr5[6][0] ,106,53 ), 'R', 0, J, true);
	
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.4, "B. Fine Motor Development", 'LRT', 0, L, true);						$pdf->SetFont('Arial','BU',10);	$pdf->Cell( 2.25	,0.8,'','',0,C,false);				$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.25, 0.4, "C. Reading", 'LRT', 0, L, true);
	
	
	
	
	
	
	//6
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "6", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[5][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.5	, 1.6, $q1nliD[6][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.6, $q2nliD[6][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1.6, $smstr1D[6][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);				$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "8", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[7][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.8, $q1nliE[8][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliE[8][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1E[8][0], 'LRT', 0, C, true);
	//6
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[5][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr5[7][0] ,53,53 ), 'R', 0, J, true);
	//6
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[5][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);				$pdf->SetFillColor(255,255,255);								$pdf->Cell(0.5	, 0.4, "9", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[8][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.8, $q1nliE[9][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliE[9][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1E[9][0], 'LRT', 0, C, true);
	//6
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[5][0] ,159,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr5[8][0] ,53,53 ), 'R', 0, J, true);
	
	
	
	
	
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "7", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[6][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.5	, 1.2, $q1nliD[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 1.2, $q2nliD[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 1.2, $smstr1D[7][0], 'LRTB', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);			$pdf->SetFillColor(255,255,255);								$pdf->Cell(0.5	, 0.4, "10", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[9][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 1.2, $q1nliE[10][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1.2, $q2nliE[10][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1.2, $smstr1E[10][0], 'LRT', 0, C, true);
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[6][0] ,53,53 ), 'RB', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);				$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);					$pdf->Cell(7	, 0.4, substr( $nmektr5[9][0] ,53,53 ), 'R', 0, J, true);
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[6][0] ,106,53 ), 'RB', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);				$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);					$pdf->Cell(7	, 0.4, substr( $nmektr5[9][0] ,106,53 ), 'R', 0, J, true);
	
	//8
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "8", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[7][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.5	, 0.8, $q1nliD[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 0.8, $q2nliD[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 0.8, $smstr1D[8][0], 'LRTB', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);			$pdf->SetFillColor(255,255,255);								$pdf->Cell(0.5	, 0.4, "11", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[10][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.4, $q1nliE[11][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, $q2nliE[11][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, $smstr1E[11][0], 'LRT', 0, C, true);
	//8
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[7][0] ,53,53 ), 'RB', 0, J, true);					$pdf->SetFont('Arial','BU',10);	$pdf->Cell( 8	,0.8,'','',0,C,false);				$pdf->SetFillColor(153,153,153);								$pdf->Cell(13.25, 0.4, "D. Writing / Handwriting", 'LRT', 0, L, true);
	
	//9
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "9", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[8][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.5	, 0.8, $q1nliD[9][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 0.8, $q2nliD[9][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 0.8, $smstr1D[9][0], 'LRTB', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);			$pdf->SetFillColor(255,255,255);								$pdf->Cell(0.5	, 0.4, "12", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[11][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.8, $q1nliE[12][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliE[12][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1E[12][0], 'LRT', 0, C, true);
	//9
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[8][0] ,53,53 ), 'RB', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);				$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);					$pdf->Cell(7	, 0.4, substr( $nmektr5[11][0] ,53,53 ), 'R', 0, J, true);
	
	
	
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.4, "C. Health and Body Awareness", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);			$pdf->SetFillColor(255,255,255);								$pdf->Cell(0.5	, 0.4, "13", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[12][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.8, $q1nliE[13][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliE[13][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1E[13][0], 'LRT', 0, C, true);
	
	//10
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "10", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[9][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.5	, 0.8, $q1nliD[10][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 0.8, $q2nliD[10][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 0.8, $smstr1D[10][0], 'LRTB', 0, C, true);								$pdf->SetFont('Arial','',8);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);			$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);					$pdf->Cell(7	, 0.4, substr( $nmektr5[12][0] ,53,53 ), 'R', 0, J, true);	
	//10
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[9][0] ,53,53 ), 'RB', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);				$pdf->SetFillColor(255,255,255);								$pdf->Cell(0.5	, 0.4, "14", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[13][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.4, $q1nliE[14][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, $q2nliE[14][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, $smstr1E[14][0], 'LRT', 0, C, true);
	
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", '', 0, C, false);
	$pdf->Cell(7	, 0.4, '', '', 0, J, false);												$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);				$pdf->SetFillColor(255,255,255);								$pdf->Cell(0.5	, 0.4, "15", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[14][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.4, $q1nliE[15][0], 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, $q2nliE[15][0], 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, $smstr1E[15][0], 'LRT', 0, C, true);
	
	
	
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", '', 0, C, false);
	$pdf->Cell(7	, 0.4, '', '', 0, J, false);												$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);				$pdf->SetFillColor(255,255,255);								$pdf->Cell(0.5	, 0.4, "16", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr5[15][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.5	, 0.8, $q1nliE[16][0], 'LRTB', 0, C, true);		$pdf->Cell(1.5	, 0.8, $q2nliE[16][0], 'LRTB', 0, C, true);	$pdf->Cell(2.75	, 0.8, $smstr1E[16][0], 'LRTB', 0, C, true);
	
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", '', 0, C, false);
	$pdf->Cell(7	, 0.4, '', '', 0, J, false);												$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);				$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);					$pdf->Cell(7	, 0.4, substr( $nmektr5[15][0] ,53,53 ), 'RB', 0, J, true);	
	
//};
$pdf->Output();
?>