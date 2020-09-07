<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LTK_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdeplj	=$_POST['kdeplj'];
$kdekls	=$_POST['kdekls'];//nis
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



if($kdekls=='437TK')
	echo"<meta http-equiv='refresh' content=\"0;url=R1D04LTK_437_C01.php?kdekls=$kdekls\">\n";
else if($kdekls=='426TK')
	echo"<meta http-equiv='refresh' content=\"0;url=R1D04LTK_426_C01.php?kdekls=$kdekls\">\n";



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
$visi		="../../images/Visi Misi TK.jpg";
$dear		="../../images/Dear Parents TK.jpg";

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
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',100);
	$pdf->SetFillColor(255,255,255); 
	$pdf->Cell( 9.3	,0.4,'','',0,C,true);
	$pdf->Cell(10, 10, "Student No. : ".substr($kdekls,0,3), '', 0, C, true);//nis
	
	
	
	//.. sampai sini
	
	
	
	$qABS	="	SELECT 		t_hdrkmnps_pgtk1.*
				FROM 		t_hdrkmnps_pgtk1
				WHERE		t_hdrkmnps_pgtk1.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	$q1KMN=$dABS['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN=$dABS['kmn'.'1'.'2']; // q2
	$q3KMN=$dABS['kmn'.'2'.'1']; // q3
	$q4KMN=$dABS['kmn'.'2'.'2']; // q4
	
	$qABS2	="	SELECT 		t_hdrkmnps_pgtk2.*
				FROM 		t_hdrkmnps_pgtk2
				WHERE		t_hdrkmnps_pgtk2.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS2=mysql_query($qABS2) or die('Query gagal40');
	$dABS2=mysql_fetch_array($rABS2);
	$q1KMN2=$dABS2['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN2=$dABS2['kmn'.'1'.'2']; // q2
	$q3KMN2=$dABS2['kmn'.'2'.'1']; // q3
	$q4KMN2=$dABS2['kmn'.'2'.'2']; // q4
	
	$qABS3	="	SELECT 		t_hdrkmnps_pgtk3.*
				FROM 		t_hdrkmnps_pgtk3
				WHERE		t_hdrkmnps_pgtk3.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS3=mysql_query($qABS3) or die('Query gagal40');
	$dABS3=mysql_fetch_array($rABS3);
	$q1KMN3=$dABS3['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN3=$dABS3['kmn'.'1'.'2']; // q2
	$q3KMN3=$dABS3['kmn'.'2'.'1']; // q3
	$q4KMN3=$dABS3['kmn'.'2'.'2']; // q4
	
	$qABS4	="	SELECT 		t_hdrkmnps_pgtk4.*
				FROM 		t_hdrkmnps_pgtk4
				WHERE		t_hdrkmnps_pgtk4.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS4=mysql_query($qABS4) or die('Query gagal40');
	$dABS4=mysql_fetch_array($rABS4);
	$q1KMN4=$dABS4['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN4=$dABS4['kmn'.'1'.'2']; // q2
	$q3KMN4=$dABS4['kmn'.'2'.'1']; // q3
	$q4KMN4=$dABS4['kmn'.'2'.'2']; // q4
	
	$qABS5	="	SELECT 		t_hdrkmnps_pgtk5.*
				FROM 		t_hdrkmnps_pgtk5
				WHERE		t_hdrkmnps_pgtk5.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS5=mysql_query($qABS5) or die('Query gagal40');
	$dABS5=mysql_fetch_array($rABS5);
	$q1KMN5=$dABS5['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN5=$dABS5['kmn'.'1'.'2']; // q2
	$q3KMN5=$dABS5['kmn'.'2'.'1']; // q3
	$q4KMN5=$dABS5['kmn'.'2'.'2']; // q4
	
	//..halaman 2
	//----
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',11);
	$pdf->SetFillColor(255,255,255); 
	$pdf->Cell( 5.5	,0.4,'','',0,C,true);
	$pdf->Cell(1, 1, "FOURTH TERM", '', 0, C, true);
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell( 5.5	,0.4,'','',0,C,true);
	$pdf->Cell(1, 1, "REMARKS", '', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1.5, 1, "1. Personal, Social, and Emotional Development", '', 0, L, true);
	//1
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN,0,81), 'LRT', 0, J, true);
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN,81,81), 'LR', 0, J, true);
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN,162,81), 'LR', 0, J, true);
	//4
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN,243,81), 'LR', 0, J, true);														$pdf->SetFont('Arial','BU',14);	$pdf->Cell( 7	,1,'','',0,C,false);	$pdf->Cell(1, 0.5, "Student's Information", '', 0, L, true);//LRTB
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN,324,81), 'LRB', 0, J, true);
	
	
	
	//
	$pdf->Ln(0.5);																										$pdf->SetFont('Arial','',11);	$pdf->Cell( 15.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, "", 'LT', 0, L, true);						$pdf->Cell(0.5, 0.5, "", 'T', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'RT', 0, L, true);//nis
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "2. Communication, Language and Literacy", '', 0, L, true);										$pdf->SetFont('Arial','',11);	$pdf->Cell( 14.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Student No.", 'L', 0, L, true);			$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','',11);	$pdf->Cell(10, 0.5, substr($kdekls,0,3), 'R', 0, C, true);//nis
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN2,0,81), 'LRT', 0, J, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'L', 0, L, true);						$pdf->Cell(0.5, 0.5, "", '', 0, L, true);			$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);//nis
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN2,81,81), 'LR', 0, J, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Name", 'L', 0, L, true);					$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $nmassw, 'R', 0, C, true);//nis
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN2,162,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, "", 'L', 0, L, true);					$pdf->Cell(0.5, 0.5, "", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);//nis
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,false);
	$pdf->Cell(11.5, 0.5, substr($q4KMN2,243,81), 'LR', 0, J, false);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Class", 'L', 0, L, true);				$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $kkelas, 'R', 0, C, true);//nis
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN2,324,81), 'LRB', 0, L, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'L', 0, L, true);						$pdf->Cell(0.5, 0.5, "  ", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);
	//
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,false);
	$pdf->Cell(11.5, 0.5, '', '', 0, L, false);																			$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Place of Birth", 'L', 0, L, true);		$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $tmplhr, 'R', 0, C, true);
	//
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "3. Mathematical/Cognitive Development", '', 0, L, true);										$pdf->SetFont('Arial','',11);	$pdf->Cell( 14.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'L', 0, L, true);					$pdf->Cell(0.5, 0.5, "  ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);//nis
	
	
	
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN3,0,81), 'LRT', 0, J, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Date of Birth", 'L', 0, L, true);		$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $tgllhr, 'R', 0, C, true);//nis
	
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN3,81,81), 'LR', 0, J, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, "", 'L', 0, L, true);					$pdf->Cell(0.5, 0.5, "  ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);//nis
	
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN3,162,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Mother's Name", 'L', 0, L, true);		$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $nmaibu, 'R', 0, C, true);//nis
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN3,243,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'L', 0, L, true);					$pdf->Cell(0.5, 0.5, "  ", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);//nis
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN3,324,81), 'LRB', 0, J, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Father's Name", 'L', 0, L, true);		$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $nmaayh, 'R', 0, C, true);//nis
	
	//
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,false);
	$pdf->Cell(11.5, 0.5, '', '', 0, J, false);																			$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'L', 0, L, true);					$pdf->Cell(0.5, 0.5, "  ", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);//nis
	
	//
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "4. Creative Development", '', 0, L, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 14.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Address", 'L', 0, L, true);			$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, substr($almt,0,37), 'R', 0, C, true);//nis
	
	
	
	/*if( strlen($almt)>37 )
	{
		$pdf->Image($signature, 19.5, 15.25, 4, 4);
		$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Address", 'L', 0, L, true);			$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','',11);	$pdf->Cell(10, 0.5, substr($almt,0,37), 'R', 0, C, true);//nis
		
		$pdf->Ln(0.5);																														$pdf->SetFont('Arial','',11);	$pdf->Cell( 15.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, "", 'L', 0, L, true);				$pdf->Cell(0.5, 0.5, "  ", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, substr($almt,37,37), 'R', 0, C, true);//nis
		$pdf->Ln(0.5);
		$pdf->SetFont('Arial','BU',11);
		$pdf->Cell(1, 0.5, "4. Creative Development", '', 0, L, true);																		$pdf->SetFont('Arial','',11);	$pdf->Cell(14.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'LB', 0, L, true);					$pdf->Cell(0.5, 0.5, "", 'B', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'RB', 0, L, true);//nis
	}
	else
	{
		$pdf->Image($signature, 19.5, 15.25, 4, 4);
		$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Address", 'L', 0, L, true);			$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $almt, 'R', 0, C, true);//nis
		$pdf->SetFont('Arial','',11);	$pdf->Cell(15.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'LB', 0, L, true);					$pdf->Cell(0.5, 0.5, "", 'B', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'RB', 0, L, true);//nis
		
		$pdf->Ln(0.5);																														$pdf->SetFont('Arial','',11);	$pdf->Cell(15.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'LB', 0, L, true);					$pdf->Cell(0.5, 0.5, "", 'B', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'RB', 0, L, true);//nis
		$pdf->Ln(0.5);
		$pdf->SetFont('Arial','BU',11);
		$pdf->Cell(1, 0.5, "4. Creative Development", '', 0, L, true);
	}*/
	
	
	
	$pdf->Image($signature, 19.5, 14.75, 4, 4);
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN4,0,81), 'LRT', 0, J, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell(3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'LB', 0, L, true);					$pdf->Cell(0.5, 0.5, "", 'B', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'RB', 0, L, true);//nis
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN4,81,81), 'LR', 0, J, true);														
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN4,162,81), 'LR', 0, J, true);															
	//4
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN4,243,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 13	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, "Jakarta, March 28, 2018", '', 0, R, true);//.$tglctk
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN4,324,81), 'LRB', 0, J, true);
	//
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,false);
	$pdf->Cell(11.5, 0.5, '', '', 0, J, false);														
	
	
	
	//
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "5. Physical Development (Gross and Fine Motor Skills)", '', 0, L, true);							
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN5,0,81), 'LRT', 0, J, true);															
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN5,81,81), 'LR', 0, J, true);														$pdf->SetFont('Arial','U',11);	$pdf->Cell( 13.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, 'Glorya Lumbantoruan S.Pd.', '', 0, R, true);				
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN5,162,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 12.55	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, 'School Principal', '', 0, L, true);				
	//4
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN5,243,81), 'LR', 0, J, true);
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q4KMN5,324,81), 'LRB', 0, J, true);
	
	
	
	
	
	
	
	//ktr1
	$qLG	="	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='KG-A1' OR t_lrcd_tk.kdekls='KG-A2' ) AND t_lrcd_tk.kde LIKE 'KG-A%' ";
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
				WHERE		 ( t_lrcd_tk.kdekls='KG-A1' OR t_lrcd_tk.kdekls='KG-A2' ) AND t_lrcd_tk.kde LIKE 'KG-B%' ";
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
				WHERE		 ( t_lrcd_tk.kdekls='KG-A1' OR t_lrcd_tk.kdekls='KG-A2' ) AND t_lrcd_tk.kde LIKE 'KG-C%' ";
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
				WHERE		 ( t_lrcd_tk.kdekls='KG-A1' OR t_lrcd_tk.kdekls='KG-A2' ) AND t_lrcd_tk.kde LIKE 'KG-D%' ";
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
				WHERE		 ( t_lrcd_tk.kdekls='KG-A1' OR t_lrcd_tk.kdekls='KG-A2' ) AND t_lrcd_tk.kde LIKE 'KG-E%' ";
	$rLG5=mysql_query($qLG5) or die('Query gagal40');
	$i=0;
	while($dLG5 =mysql_fetch_array($rLG5))
	{
		$nmektr5[$i][0]=$dLG5['nmektr'];
		$i++;
	}
	
	//ktr6
	$qLG6	="	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='KG-A1' OR t_lrcd_tk.kdekls='KG-A2' ) AND t_lrcd_tk.kde LIKE 'KG-F%' ";
	$rLG6=mysql_query($qLG6) or die('Query gagal40');
	$i=0;
	while($dLG6 =mysql_fetch_array($rLG6))
	{
		$nmektr6[$i][0]=$dLG6['nmektr'];
		$i++;
	}
	
	
	
	//nli1
	$qLGKG	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kdekls' AND ( t_learnrcd_tk.kdekls='KG-A1' OR t_learnrcd_tk.kdekls='KG-A2' ) AND t_learnrcd_tk.kdeplj='KG-A' ";
	$rLGKG=mysql_query($qLGKG) or die('Query gagal40');
	$dLGKG =mysql_fetch_array($rLGKG);
	$i=1;
	$j=1;
	while($i<26)
	{
		$q1nli[$i][0]=$dLGKG['hw'.'1'.'1'."$j"];
		$q2nli[$i][0]=$dLGKG['hw'.'1'.'2'."$j"];
		$q3nli[$i][0]=$dLGKG['hw'.'2'.'1'."$j"];
		
		
		
		if( $q2nli[$i][0]=='v' OR $q2nli[$i][0]=='V' )
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
			$smstr1[$i][0] = 'NH';//'NO'
			
		else if( $q2nli[$i][0]=='+' )
			$smstr1[$i][0] = 'S';
		else if( $q2nli[$i][0]=='/' )
			$smstr1[$i][0] = 'MS';
			
		else if( $q2nli[$i][0]=='+' )
			$smstr1[$i][0] = 'S';
		else if( $q2nli[$i][0]=='v' )
			$smstr1[$i][0] = 'VS';
		
		else if( $q2nli[$i][0]=='*' )
			$smstr1[$i][0] = 'O';
		else if( $q2nli[$i][0]=='ND' )
			$smstr1[$i][0] = 'NH';
		
		$i++;
		$j++;
	}
	
	//nli2
	$qLGKG2	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kdekls' AND ( t_learnrcd_tk.kdekls='KG-A1' OR t_learnrcd_tk.kdekls='KG-A2' ) AND t_learnrcd_tk.kdeplj='KG-B' ";
	$rLGKG2=mysql_query($qLGKG2) or die('Query gagal40');
	$dLGKG2 =mysql_fetch_array($rLGKG2);
	$i=1;
	$j=1;
	while($i<26)
	{
		$q1nliB[$i][0]=$dLGKG2['hw'.'1'.'1'."$j"];
		$q2nliB[$i][0]=$dLGKG2['hw'.'1'.'2'."$j"];
		$q3nliB[$i][0]=$dLGKG2['hw'.'2'.'1'."$j"];
		
		
		
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
			$smstr1B[$i][0] = 'NH';
			
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
		
		else if( $q2nliB[$i][0]=='*' )
			$smstr1B[$i][0] = 'O';
		else if( $q2nliB[$i][0]=='ND' )
			$smstr1B[$i][0] = 'NH';
		
		$i++;
		$j++;
	}
	
	//nli3
	$qLGKG3	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kdekls' AND ( t_learnrcd_tk.kdekls='KG-A1' OR t_learnrcd_tk.kdekls='KG-A2' ) AND t_learnrcd_tk.kdeplj='KG-C' ";
	$rLGKG3=mysql_query($qLGKG3) or die('Query gagal40');
	$dLGKG3 =mysql_fetch_array($rLGKG3);
	$i=1;
	$j=1;
	while($i<26)
	{
		$q1nliC[$i][0]=$dLGKG3['hw'.'1'.'1'."$j"];
		$q2nliC[$i][0]=$dLGKG3['hw'.'1'.'2'."$j"];
		$q3nliC[$i][0]=$dLGKG3['hw'.'2'.'1'."$j"];
		
		
		
		if( $q2nliC[$i][0]=='v' OR $q2nliC[$i][0]=='V' )
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
			$smstr1C[$i][0] = 'NH';
			
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
		
		else if( $q2nliC[$i][0]=='*' )
			$smstr1C[$i][0] = 'O';
		else if( $q2nliC[$i][0]=='ND' )
			$smstr1C[$i][0] = 'NH';
		
		$i++;
		$j++;
	}
	
	//nli4
	$qLGKG4	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kdekls' AND ( t_learnrcd_tk.kdekls='KG-A1' OR t_learnrcd_tk.kdekls='KG-A2' ) AND t_learnrcd_tk.kdeplj='KG-D' ";
	$rLGKG4=mysql_query($qLGKG4) or die('Query gagal40');
	$dLGKG4 =mysql_fetch_array($rLGKG4);
	$i=1;
	$j=1;
	while($i<26)
	{
		$q1nliD[$i][0]=$dLGKG4['hw'.'1'.'1'."$j"];
		$q2nliD[$i][0]=$dLGKG4['hw'.'1'.'2'."$j"];
		$q3nliD[$i][0]=$dLGKG4['hw'.'2'.'1'."$j"];
		
		
		
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
			$smstr1D[$i][0] = 'NH';
			
		else if( $q2nliD[$i][0]=='+' )
			$smstr1D[$i][0] = 'S';
		else if( $q2nliD[$i][0]=='/' )
			$smstr1D[$i][0] = 'MS';
			
		else if( $q2nliD[$i][0]=='*' )
			$smstr1D[$i][0] = 'O';
		else if( $q2nliD[$i][0]=='ND' )
			$smstr1D[$i][0] = 'NH';
		
		$i++;
		$j++;
	}
	
	//nli5
	$qLGKG5	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kdekls' AND ( t_learnrcd_tk.kdekls='KG-A1' OR t_learnrcd_tk.kdekls='KG-A2' ) AND t_learnrcd_tk.kdeplj='KG-E' ";
	$rLGKG5=mysql_query($qLGKG5) or die('Query gagal40');
	$dLGKG5 =mysql_fetch_array($rLGKG5);
	$i=1;
	$j=1;
	while($i<26)
	{
		$q1nliE[$i][0]=$dLGKG5['hw'.'1'.'1'."$j"];
		$q2nliE[$i][0]=$dLGKG5['hw'.'1'.'2'."$j"];
		$q3nliE[$i][0]=$dLGKG5['hw'.'2'.'1'."$j"];
		
		
		
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
			$smstr1E[$i][0] = 'NH';
		else if( $q2nliE[$i][0]=='-' )
			$smstr1E[$i][0] = 'S';
		
		$i++;
		$j++;
	}
	
	//nli6
	$qLGKG6	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kdekls' AND ( t_learnrcd_tk.kdekls='KG-A1' OR t_learnrcd_tk.kdekls='KG-A2' ) AND t_learnrcd_tk.kdeplj='KG-F' ";
	$rLGKG6=mysql_query($qLGKG6) or die('Query gagal40');
	$dLGKG6 =mysql_fetch_array($rLGKG6);
	$i=1;
	$j=1;
	while($i<26)
	{
		$q1nliF[$i][0]=$dLGKG6['hw'.'1'.'1'."$j"];
		$q2nliF[$i][0]=$dLGKG6['hw'.'1'.'2'."$j"];
		$q3nliF[$i][0]=$dLGKG6['hw'.'2'.'1'."$j"];
		
		//..yang lngkap
		
		if( $q2nliF[$i][0]=='*' )
			$smstr1F[$i][0] = 'O';
		
		else if( $q2nliF[$i][0]=='v' OR $q2nliF[$i][0]=='V' )
			$smstr1F[$i][0] = 'VS';
		else if( $q2nliF[$i][0]=='+' )
			$smstr1F[$i][0] = 'S';
		
		else if( $q2nliF[$i][0]=='/' )
			$smstr1F[$i][0] = 'MS';
		else if( $q2nliF[$i][0]=='ND' )
			$smstr1F[$i][0] = 'NH';
		
		else if( $q2nliF[$i][0]=='NO' )
			$smstr1F[$i][0] = 'NH';
		else if( $q2nliF[$i][0]=='-' )
			$smstr1F[$i][0] = 'S';
			
			
		
		$i++;
		$j++;
	}
	
	
	
	
	
	
	//..halaman 3
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetMargins(0.1,0.1,1);//
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell( 2.8	,0.4,'','',0,C,false);
	$pdf->Cell(3, 0.5, "", '', 0, C, true);																								$pdf->Cell( 2	,0.4,'','',0,C,false);										$pdf->SetFont('Arial','B',11);	$pdf->Cell( 12.7	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, 'THIRD TERM', '', 0, C, true);					
	
	//1
	$pdf->Ln(0.5);																														$pdf->SetFont('Arial','B',13);	$pdf->Cell( 20.9	,0.5,'','',0,C,false);	$pdf->Cell(3, 1, "REMARKS", '', 0, C, true);					
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell( 0.5	,0.4,'','',0,C,false);
	$pdf->Cell(3, 0.5, "", '', 0, L, false);
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell( 0.5	,0.4,'','',0,C,false);
	$pdf->Cell(3, 0.5, "Dear Parents,", '', 0, L, true);
		
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell( 0.5	,0.4,'','',0,C,false);
	$pdf->Cell(3, 0.5, "", '', 0, L, false);																							$pdf->Cell( 10	,0.4,'','',0,C,false);										$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.9	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);						$pdf->Cell(1, 0.5, "1. Personal, Social, and Emotional Development", '', 0, L, true);
	
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 1, '', '', 0, C, true);
	$pdf->Cell(7	, 0.5, "This Learning Record Book aims to inform you of your child's", '', 0, J, true);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);
	$pdf->Cell(2.25	, 1, '', '', 0, C, false);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);																							$pdf->SetFont('Arial','',9);	$pdf->Cell( 3.4	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q3KMN,0,81), 'LRT', 0, J, true);
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "progress in school.", '', 0, J, true);																		$pdf->SetFont('Arial','',9);	$pdf->Cell( 9.4	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q3KMN,81,81), 'LR', 0, J, true);
	
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, '', '', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);
	$pdf->Cell(2.25	, 1,'', '', 0, C, false);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);																							$pdf->SetFont('Arial','',9);	$pdf->Cell( 3.4	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q3KMN,162,81), 'LR', 0, J, true);
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, 'Through a carefully planned activities and experiences, we aim', '', 0, J, true);							$pdf->SetFont('Arial','',9);	$pdf->Cell( 9.4	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q3KMN,243,81), 'LR', 0, J, true);
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell( 0.5	,0.4,'','',0,C,false);
	$pdf->Cell(3, 0.5, "to provide your child with a wide range of opportunities to", '', 0, L, true);									$pdf->Cell( 10	,0.4,'','',0,C,false);	$pdf->SetFont('Arial','',9);	$pdf->Cell( 3.4	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q3KMN,324,81), 'LRB', 0, J, true);
	
	//$pdf->Ln(0.5);
	
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "grow and develop in character and academics.", '', 0, J, true);					
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);
	$pdf->Cell(2.25	, 1,'', '', 0, C, false);										
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "", '', 0, J, true);																							$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 8.9	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.5, "2. Communication, Language and Literacy", '', 0, L, true);
	
	
	
	
	
	
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "The learning goals in which your child needs to undergo", '', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.5, '', '', 0, C, false);
	$pdf->Cell(1.25	, 1.5, '', '', 0, C, false);
	$pdf->Cell(2.25	, 1.5, '', '', 0, C, false);
	$pdf->Cell(1.25	, 1.5, '', '', 0, C, false);																						$pdf->SetFont('Arial','',9);	$pdf->Cell( 3.4	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q3KMN2,0,81), 'LRT', 0, J, true);
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "through teaching and learning processes throughout the school", '', 0, J, true);							$pdf->SetFont('Arial','',9);	$pdf->Cell( 9.4	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q3KMN2,81,81), 'LR', 0, J, true);
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "year are herein described for your reference in each quarter or", '', 0, J, true);							$pdf->SetFont('Arial','',9);	$pdf->Cell( 9.4	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q3KMN2,162,81), 'LR', 0, J, true);
	
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "term report. These \"Early Learning Goals\" serve as guidelines", '', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);
	$pdf->Cell(2.25	, 1, '', '', 0, C, false);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);																							$pdf->SetFont('Arial','',9);	$pdf->Cell( 3.4	,0.4,'','',0,C,false);			$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q3KMN2,243,81), 'LR', 0, J, true);
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "for expectations of children's achievements throughout the", '', 0, J, true);								$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 9.4	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q3KMN2,324,81), 'LR', 0, J, true);
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7, 0.5, "\"Early Years Foundation Stage\".", '', 0, L, true);															$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 9.4	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q3KMN2,405,81), 'LR', 0, J, true);
	
	
	
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "", '', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);
	$pdf->Cell(2.25	, 1, '', '', 0, C, false);
	$pdf->Cell(1.25	, 1, '', '', 0, C, false);																							$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 3.4	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q3KMN2,486,81), 'LR', 0, J, true);
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "There are four terms in the whole academic year in which we", '', 0, J, true);								$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 9.4	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q3KMN2,567,81), 'LR', 0, J, true);
	
	
	
	
	
	
	
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "inform you of your child's level of performance in the different", '', 0, J, true);							
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, '', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 1,'', '', 0, C, FALSE);
	$pdf->Cell(2.25	, 1,'', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 1, '', '', 0, C, FALSE);																							$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 3.4	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q3KMN2,648,81), 'LR', 0, J, true);
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "competencies expected of him or her. The first term is the entry", '', 0, J, true);							$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 9.4	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q3KMN2,729,81), 'LR', 0, J, true);
	
	//8
	$pdf->Ln();
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "level in which your child is assessed based on his/her prior", '', 0, J, true);								
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, '', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 1,'', '', 0, C, FALSE);
	$pdf->Cell(2.25	, 1,'', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 1, '', '', 0, C, FALSE);																							$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 3.4	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q3KMN2,810,81), 'LRB', 0, J, true);
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7, 0.5, "knowledge and the initial experiences in school. The second and", '', 0, L, true);								
	
	//9
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "third term are the review periods wherein your child's", '', 0, J, true);									
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, '', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 1,'', '', 0, C, FALSE);
	$pdf->Cell(2.25	, 1,'', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 1, '', '', 0, C, FALSE);																							$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.9	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.5, "3. Mathematical/Cognitive Development", '', 0, L, true);
	//9
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "development is described on these stages and the fourth term", '', 0, J, true);								$pdf->SetFont('Arial','',9);	$pdf->Cell( 9.4	,0.4,'','',0,C,false);			$pdf->Cell(11.5, 0.5, substr($q3KMN3,0,81), 'LRT', 0, J, true);
	
	
	
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "is the exit level or the final stage where your child's", '', 0, J, true);									
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, '', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 1,'', '', 0, C, FALSE);
	$pdf->Cell(2.25	, 1,'', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 1, '', '', 0, C, FALSE);																							$pdf->SetFont('Arial','',9);	$pdf->Cell( 3.4	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q3KMN3,81,81), 'LR', 0, J, true);
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "performance is described based on the extent of achievement", '', 0, J, true);								$pdf->SetFont('Arial','',9);	$pdf->Cell( 9.4	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q3KMN3,162,81), 'LR', 0, J, true);
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "or progress made as expected of him or her at the end of the", '', 0, J, true);								$pdf->SetFont('Arial','',9);	$pdf->Cell( 9.4	,0.4,'','',0,C,false);		$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q3KMN3,243,81), 'LRB', 0, J, true);	
	
	//11
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "academic year.", '', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, '', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 0.5,'', '', 0, C, FALSE);
	$pdf->Cell(2.25	, 0.5,'', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 0.5, '', '', 0, C, FALSE);																							
	
	
	
	
	
	
	//12
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "", '', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, '', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 0.5,'', '', 0, C, FALSE);
	$pdf->Cell(2.25	, 0.5,'', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 0.5, '', '', 0, C, FALSE);																						$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.9	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);										$pdf->Cell(1, 0.5, "4. Creative Development", '', 0, L, true);	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7, 0.5, "May this record book serves its purpose with your feedbacks,", '', 0, L, true);									$pdf->SetFont('Arial','',9);	$pdf->Cell( 9.4	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q3KMN4,0,81), 'LRT', 0, J, true);	
	
	//13
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "cooperation and support as we share in the growth and", '', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, '', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 1,'', '', 0, C, FALSE);
	$pdf->Cell(2.25	, 1,'', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 1, '', '', 0, C, FALSE);																							$pdf->SetFont('Arial','',9);	$pdf->Cell( 3.4	,0.4,'','',0,C,false);			$pdf->Cell(11.5, 0.5, substr($q3KMN4,81,81), 'LR', 0, J, true);
	//13
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "development of your child throughout the year.", '', 0, J, true);											$pdf->SetFont('Arial','',9);	$pdf->Cell( 9.4	,0.4,'','',0,C,false);			$pdf->Cell(11.5, 0.5, substr($q3KMN4,162,81), 'LR', 0, J, true);
	
	
	//14
	$pdf->Ln();
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "", '', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, '', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 1,'', '', 0, C, FALSE);
	$pdf->Cell(2.25	, 1,'', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 1, '', '', 0, C, FALSE);																							$pdf->SetFont('Arial','',9);	$pdf->Cell( 3.4	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q3KMN4,243,81), 'LRB', 0, J, true);
	
	
	//15
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "Thank you very much.", '', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, '', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 0.5,'', '', 0, C, FALSE);
	$pdf->Cell(2.25	, 0.5,'', '', 0, C, FALSE);
	$pdf->Cell(1.25	, 0.5, '', '', 0, C, FALSE);																						
	//15
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5,"", '', 0, J, true);																							$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 8.9	,0.4,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.5, "5. Physical Development (Gross and Fine Motor Skills)", '', 0, L, true);
	
	//16
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BI',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, "", '', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.5, '', '', 0, C, true);
	$pdf->Cell(1.25	, 1.5, '', '', 0, C, true);
	$pdf->Cell(2.25	, 1.5, '', '', 0, C, true);
	$pdf->Cell(1.25	, 1.5, '', '', 0, C, true);																							$pdf->SetFont('Arial','',9);	$pdf->Cell( 3.4	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q3KMN5,0,81), 'LRT', 0, J, true);
	//16
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 8	,0.5,'','',0,C,false);
	$pdf->Cell(2, 0.5, "Saint John's School", '', 0, J, true);																			$pdf->SetFont('Arial','',9);	$pdf->Cell( 6.9	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q3KMN5,81,81), 'LR', 0, J, true);
	//16
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, '', '', 0, J, true);																							$pdf->SetFont('Arial','',9);	$pdf->Cell( 9.4	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q3KMN5,162,81), 'LR', 0, J, true);
	//16
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, true);
	$pdf->Cell(7	, 0.5, '', '', 0, J, true);																							$pdf->SetFont('Arial','',9);	$pdf->Cell( 9.4	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q3KMN5,243,81), 'LRB', 0, J, true);
	
	
	
	
	//..halaman 4
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',11);
	$pdf->SetMargins(0.5,0.1,1);
	$pdf->SetFillColor(255,255,255); 
	$pdf->Cell( 5.9	,0.4,'','',0,C,true);
	$pdf->Cell(1, 0.75, "SECOND TERM", '', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell( 5.5	,0.4,'','',0,C,true);
	$pdf->Cell(1, 1, "REMARKS", '', 0, C, true);																	
	
	//$pdf->Image($visi, 16, 1.8, 12, 9);
	
	
	
	$pdf->Ln(0.5);																									$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 15.5	,0.5,'','',0,C,false);		$pdf->Cell(3, 0.5, "", '', 0, J, false);
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1.5, 0.5, "1. Personal, Social, and Emotional Development", '', 0, L, true);							$pdf->SetFont('Arial','B',14);	$pdf->Cell( 14	,0.5,'','',0,C,false);		$pdf->Cell(3, 0.5, "Our Vision and Mission Statements", '', 0, J, FALSE);//
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN,0,81), 'LRT', 0, J, true);													$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, FALSE);
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN,81,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, FALSE);
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN,162,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','BU',13);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "Vision", '', 0, J, FALSE);//	
	//4
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN,243,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(2, 0.5, "As a Catholic school, we envision our students to pursue", '', 0, J, FALSE);//
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN,324,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, "education in the best local and international universities,", '', 0, J, FALSE);//
	//6
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN,405,81), 'LRB', 0, J, true);												$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, "to be the best in their chosen career or vocation, to be ", '', 0, J, FALSE);//
	
	
	

	//
	$pdf->Ln(0.5);																									$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 15.5	,0.5,'','',0,C,false);	$pdf->Cell(2, 0.5, "productive members of the society- indepedent, disciplined, ", '', 0, J, FALSE);//
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "2. Communication, Language and Literacy", '', 0, L, true);									$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 14.5	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "creative, critical thinkers, having a better understanding and ", '', 0, J, false);//
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,0,81), 'LRT', 0, J, true);													$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "deeper appreciation of their cultural heritage, and effective ", '', 0, J, false);//
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,81,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "Christian witnesses to the world.", '', 0, J, false);//
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,162,81), 'LR', 0, J, true);												
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,false);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,243,81), 'LR', 0, J, false);												$pdf->SetFont('Arial','BU',13);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(2, 0.5, "Mission", '', 0, J, false);//
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,324,81), 'LR', 0, L, true);												$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(2, 0.5, "Saint John's Catholic School is committed to provide a strong ", '', 0, J, false);//
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,405,81), 'LR', 0, L, true);												$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(2, 0.5, "basic education living up to its three-fold ideal of Scientia, ", '', 0, J, false);//
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,486,81), 'LR', 0, L, true);												$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(2, 0.5, "Virtus et Vita (Knowledge, Virtues and Life) within the framework", '', 0, J, false);//
	//8
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,567,81), 'LRB', 0, L, true);												$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "of Christian values.", '', 0, J, false);//

	
	
	
	//
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
	$pdf->Cell(11.5, 0.5, substr($q2KMN3,243,81), 'LR', 0, J, true);												$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN3,324,81), 'LRB', 0, J, true);												$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);
	
		
	
	$pdf->Ln(0.5);																									$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 15.5	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "4. Creative Development", '', 0, L, true);													$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 14.5	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN4,0,81), 'LRT', 0, J, true);													$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN4,81,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN4,162,81), 'LR', 0, J, true);												$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);
	//4
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN4,243,81), 'LR', 0, J, true);												$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN4,324,81), 'LRB', 0, J, true);												
	
	
	
	//
	$pdf->Ln(0.5);																									$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 15.5	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "5. Physical Development (Gross and Fine Motor Skills)", '', 0, L, true);					$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 14.5	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN5,0,81), 'LRT', 0, J, true);													$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN5,81,81), 'LR', 0, J, true);													
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN5,162,81), 'LR', 0, J, true);												$pdf->SetFont('Arial','BI',12);	$pdf->Cell( 3	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);	
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
	
	
	
	//$pdf->Ln();
	//$pdf->SetFont('Arial','B',12);	$pdf->Cell( 23	,0.5,'','',0,C,false);		$pdf->Cell(2, 0.5, "", '', 0, J, true);
	
	
	
	//..halaman 5
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetMargins(0.5,0.1,1);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell( 5	,0.4,'','',0,C,true);
	$pdf->Cell(3, 1, "Personal, Social and Emotional Development", '', 0, C, true);				$pdf->SetFont('Arial','B',11);	$pdf->Cell( 12.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.75, 'FIRST TERM', '', 0, C, true);					
	
	//1
	$pdf->Ln(0.5);																				$pdf->SetFont('Arial','B',13);	$pdf->Cell( 20.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 1, "REMARKS", '', 0, C, true);					
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(7.5, 1, "Learning Goals", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(1.25, 0.5, "TERM", 'LRT', 0, C, true);
	$pdf->Cell(1.25, 0.5, "TERM", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(2.25, 0.5, "SEMESTER", 'LRT', 0, C, true);
	$pdf->Cell(1.25, 0.5, "TERM", 'LRT', 0, C, true);	
	
	
	
	
	
	
if( $kdekls=='370TK' OR $kdekls=='380TK' OR $kdekls=='384TK' OR $kdekls=='432TK' OR $kdekls=='425TK' ) 
{
	$pdf->Ln(0.5);
	$pdf->Cell(7.5, 1, "", '', 0, C, false);
	$pdf->Cell(1.25, 0.5, "1", 'LR', 0, C, true);
	$pdf->Cell(1.25, 0.5, "2", 'LR', 0, C, true);
	$pdf->Cell(2.25, 0.5, "1", 'LR', 0, C, true);
	$pdf->Cell(1.25, 0.5, "3", 'LR', 0, C, true);												$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.5	,0.5,'','',0,C,false);	$pdf->SetFillColor(255,255,255);						$pdf->Cell(1, 0.5, "1. Personal, Social, and Emotional Development", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.5, "A. Spirituality and Religiosity", 'LRT', 0, L, true);				$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);						$pdf->Cell(11.5, 0.5, substr($q1KMN,0,81), 'LRT', 0, J, true);
	
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "1", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[0][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[1][0], 'LRT', 0, C, true);//$dLGKG['hw'.'1'.'1'."1"]
	$pdf->Cell(1.25	, 1, $q2nli[1][0], 'LRT', 0, C, true);//$dLGKG['hw'.'1'.'2'."1"]
	$pdf->Cell(2.25	, 1, $smstr1[1][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q3nli[1][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN,81,81), 'LR', 0, J, true);
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[0][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN,162,81), 'LR', 0, J, true);
	
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "2", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[1][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[2][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nli[2][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1[2][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q3nli[2][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN,243,81), 'LR', 0, J, true);
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[1][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN,324,81), 'LR', 0, J, true);
		
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.5, "B. Disposition and attitude", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN,405,81), 'LR', 0, J, true);
		
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "3", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[2][0] ,0,53 ), 'RT', 0, J, true);					
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[3][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nli[3][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1[3][0], 'LRT', 0, C, true);										
	$pdf->Cell(1.25	, 1, $q3nli[3][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN,486,81), 'LR', 0, J, true);
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[2][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN,567,81), 'LRB', 0, J, true);
		
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "4", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[3][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.5, $q1nli[4][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.5, $q2nli[4][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1.5, $smstr1[4][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.5, $q3nli[4][0], 'LRT', 0, C, true);									
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[3][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 8.5	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.5, "2. Communication, Language and Literacy", '', 0, L, true);
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[3][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN2,0,81), 'LRT', 0, J, true);
	
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "5", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[4][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[5][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nli[5][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1[5][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q3nli[5][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN2,81,81), 'LR', 0, J, true);
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[4][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN2,162,81), 'LR', 0, J, true);
		
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.5, "C. Self-care and Independence", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);			$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN2,243,81), 'LR', 0, J, true);
		
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "6", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[5][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[6][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nli[6][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1[6][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q3nli[6][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN2,324,81), 'LR', 0, J, true);
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[5][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN2,405,81), 'LRB', 0, J, true);
}
else
{
	$pdf->Ln(0.5);
	$pdf->Cell(7.5, 1, "", '', 0, C, false);
	$pdf->Cell(1.25, 0.5, "1", 'LR', 0, C, true);
	$pdf->Cell(1.25, 0.5, "2", 'LR', 0, C, true);
	$pdf->Cell(2.25, 0.5, "1", 'LR', 0, C, true);
	$pdf->Cell(1.25, 0.5, "3", 'LR', 0, C, true);												$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.5	,0.5,'','',0,C,false);	$pdf->SetFillColor(255,255,255);						$pdf->Cell(1, 0.5, "1. Personal, Social, and Emotional Development", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.5, "A. Spirituality and Religiosity", 'LRT', 0, L, true);				$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);						$pdf->Cell(11.5, 0.5, substr($q1KMN,0,81), 'LRT', 0, J, true);
	
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "1", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[0][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[1][0], 'LRT', 0, C, true);//$dLGKG['hw'.'1'.'1'."1"]
	$pdf->Cell(1.25	, 1, $q2nli[1][0], 'LRT', 0, C, true);//$dLGKG['hw'.'1'.'2'."1"]
	$pdf->Cell(2.25	, 1, $smstr1[1][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q3nli[1][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN,81,81), 'LR', 0, J, true);
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[0][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN,162,81), 'LR', 0, J, true);
	
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "2", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[1][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[2][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nli[2][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1[2][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q3nli[2][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN,243,81), 'LR', 0, J, true);
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[1][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN,324,81), 'LR', 0, J, true);
		
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.5, "B. Disposition and attitude", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN,405,81), 'LRB', 0, J, true);
		
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "3", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[2][0] ,0,53 ), 'RT', 0, J, true);					
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[3][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nli[3][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1[3][0], 'LRT', 0, C, true);										
	$pdf->Cell(1.25	, 1, $q3nli[3][0], 'LRT', 0, C, true);										
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[2][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 8.5	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.5, "2. Communication, Language and Literacy", '', 0, L, true);
		
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "4", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[3][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.5, $q1nli[4][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.5, $q2nli[4][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1.5, $smstr1[4][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.5, $q3nli[4][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN2,0,81), 'LRT', 0, J, true);
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[3][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN2,81,81), 'LR', 0, J, true);
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[3][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN2,162,81), 'LR', 0, J, true);
	
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "5", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[4][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[5][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nli[5][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1[5][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q3nli[5][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);			$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN2,243,81), 'LR', 0, J, true);
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[4][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN2,324,81), 'LR', 0, J, true);
		
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.5, "C. Self-care and Independence", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN2,405,81), 'LR', 0, J, true);
		
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "6", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[5][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[6][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nli[6][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1[6][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q3nli[6][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN2,486,81), 'LR', 0, J, true);
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[5][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);				$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN2,567,81), 'LRB', 0, J, true);
}	
	
	
	
	
	
	
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "7", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[6][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[7][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nli[7][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1[7][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q3nli[7][0], 'LRT', 0, C, true);										
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[6][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 8.5	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.5, "3. Mathematical/Cognitive Development", '', 0, L, true);
	
	//8
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "8", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[7][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nli[8][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nli[8][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1[8][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nli[8][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN3,0,81), 'LRT', 0, J, true);	
		
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.5, "D. Confidence and Self-esteem", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q1KMN3,81,81), 'LR', 0, J, true);
	
	//9
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "9", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[8][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[9][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nli[9][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1[9][0], 'LRT', 0, C, true);										
	$pdf->Cell(1.25	, 1, $q3nli[9][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q1KMN3,162,81), 'LR', 0, J, true);
	//9
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[8][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q1KMN3,243,81), 'LR', 0, J, true);
		
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "10", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[9][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.5, $q1nli[10][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.5, $q2nli[10][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1.5, $smstr1[10][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.5, $q3nli[10][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);		$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q1KMN3,324,81), 'LRB', 0, J, true);
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[9][0] ,53,53 ), 'R', 0, J, true);					
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[9][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 8.5	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);										$pdf->Cell(1, 0.5, "4. Creative Development", '', 0, L, true);	
	
	//11
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "11", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[10][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nli[11][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nli[11][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1[11][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nli[11][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN4,0,81), 'LRT', 0, J, true);	
	
	
	
	
	
	
	
	//mpe sini
	
	
	
	//12
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetMargins(0.5,0.1,1);
	$pdf->Cell(0.5	, 0.5, "12", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[11][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nli[12][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nli[12][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1[12][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nli[12][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN4,81,81), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.5, "E. Behaviour and self-control", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',9);	$pdf->SetFillColor(255,255,255);			$pdf->Cell( 3	,0.4,'','',0,C,false);			$pdf->Cell(11.5, 0.5, substr($q1KMN4,162,81), 'LR', 0, J, true);
	
	//13
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "13", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[12][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[13][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nli[13][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1[13][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1, $q3nli[13][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN4,243,81), 'LR', 0, J, true);
	//13
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[12][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN4,324,81), 'LRB', 0, J, true);	
	
	
	//14
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "14", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[13][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nli[14][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nli[14][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1[14][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nli[14][0], 'LRT', 0, C, true);									
	
	
	//15
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "15", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[14][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nli[15][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nli[15][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1[15][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q3nli[15][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.5	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.5, "5. Physical Development (Gross and Fine Motor Skills)", '', 0, L, true);	
	//15
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[14][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN5,0,81), 'LRT', 0, J, true);
	
	//16
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "16", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[15][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.5, $q1nli[16][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.5, $q2nli[16][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 1.5, $smstr1[16][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.5, $q3nli[16][0], 'LRTB', 0, C, true);									$pdf->SetFont('Arial','',9);	$pdf->Cell( 3	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);				$pdf->Cell(11.5, 0.5, substr($q1KMN5,81,81), 'LR', 0, J, true);
	//16
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[15][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN5,162,81), 'LR', 0, J, true);
	//16
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[15][0] ,106,53 ), 'RB', 0, J, true);					$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN5,243,81), 'LR', 0, J, true);
	
	
	
	//
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, '', '', 0, J, false);												$pdf->SetFont('Arial','',9);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN5,324,81), 'LRB', 0, J, true);
	
	
	
	
	
	
	//..halaman 6
	$pdf->SetMargins(0.5,0.1,1);
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',13);
	$pdf->SetMargins(0.5,0.1,1);
	$pdf->Cell( 5	,1.0,'','',0,C,true);
	$pdf->Cell(3, 1.0, "Communication, Language and Literacy", '', 0, C, true);					$pdf->SetFont('Arial','B',13);	$pdf->Cell( 12.5	,1.0,'','',0,C,false);					$pdf->Cell(3, 1.0, 'Mathematical / Cognitive Development', '', 0, C, true);					
	
	//1
	$pdf->Ln(1.0);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(7.5, 1.0, "Learning Goals", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(1.25, 0.5, "TERM", 'LRT', 0, C, true);
	$pdf->Cell(1.25, 0.5, "TERM", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(2.25, 0.5, "SEMESTER", 'LRT', 0, C, true);
	$pdf->Cell(1.25, 0.5, "TERM", 'LRT', 0, C, true);											$pdf->SetFont('Arial','B',13);	$pdf->Cell( 2	,1.0,'','',0,C,false);						$pdf->Cell(7.5, 1.0, "Learning Goals", 'LRT', 0, C, true);	$pdf->SetFont('Arial','B',10);													$pdf->Cell(1.25, 0.5, "TERM", 'LRT', 0, C, true);	$pdf->Cell(1.25, 0.5, "TERM", 'LRT', 0, C, true);	$pdf->SetFont('Arial','B',11);					$pdf->Cell(2.25, 0.5, "SEMESTER", 'LRT', 0, C, true);		$pdf->Cell(1.25, 0.5, "TERM", 'LRT', 0, C, true);

	$pdf->Ln(0.5);
	$pdf->Cell(7.5, 1, "", '', 0, C, false);
	$pdf->Cell(1.25, 0.5, "1", 'LR', 0, C, true);
	$pdf->Cell(1.25, 0.5, "2", 'LR', 0, C, true);
	$pdf->Cell(2.25, 0.5, "1", 'LR', 0, C, true);
	$pdf->Cell(1.25, 0.5, "3", 'LR', 0, C, true);												$pdf->SetFont('Arial','B',13);	$pdf->Cell( 2	,1.0,'','',0,C,false);						$pdf->Cell(7.5, 1.0, "", '', 0, C, false);					$pdf->SetFont('Arial','B',10);													$pdf->Cell(1.25, 0.5, "1", 'LR', 0, C, true);		$pdf->Cell(1.25, 0.5, "2", 'LR', 0, C, true);	$pdf->SetFont('Arial','B',11);						$pdf->Cell(2.25, 0.5, "1", 'LR', 0, C, true);				$pdf->Cell(1.25, 0.5, "3", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.5, "Bahasa Indonesia", 'LRT', 0, L, true);								$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2	,1.0,'','',0,C,false);						$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.5, 0.5, "A. Numbers as Labels and for Counting", 'LRT', 0, L, true);
	
	//mpe sini 0.4 0.8
	
	//1
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "1", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[0][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nliB[1][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nliB[1][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1B[1][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nliB[1][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "1", 'LT', 0, C, true);									$pdf->Cell(7	, 0.5, substr( $nmektr3[0][0] ,0,53 ), 'RT', 0, J, true);								$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 0.5, $q1nliC[1][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.5, $q2nliC[1][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.5, $smstr1C[1][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.5, $q3nliC[1][0], 'LRT', 0, C, true);
	
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "2", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[1][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nliB[2][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nliB[2][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1B[2][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nliB[2][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "2", 'LT', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[1][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 0.5, $q1nliC[2][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.5, $q2nliC[2][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.5, $smstr1C[2][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.5, $q3nliC[2][0], 'LRT', 0, C, true);
	
	
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "3", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[2][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nliB[3][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nliB[3][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1B[3][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nliB[3][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "3", 'LT', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[2][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 1.0, $q1nliC[3][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q2nliC[3][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 1.0, $smstr1C[3][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q3nliC[3][0], 'LRT', 0, C, true);
	
	
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "4", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[3][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nliB[4][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nliB[4][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1B[4][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nliB[4][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[2][0] ,53,53 ), 'R', 0, J, true);
	
	
	
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "5", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[4][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nliB[5][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nliB[5][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1B[5][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nliB[5][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2	,1.0,'','',0,C,false);					$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.5, 0.5, "B. Calculating", 'LRT', 0, L, true);
	
	//bhsa indo
	
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "6", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[5][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.5, $q1nliB[6][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.5, $q2nliB[6][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1.5, $smstr1B[6][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.5, $q3nliB[6][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "4", 'LT', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[3][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 1.0, $q1nliC[4][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q2nliC[4][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 1.0, $smstr1C[4][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q3nliC[4][0], 'LRT', 0, C, true);
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[5][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[3][0] ,53,53 ), 'R', 0, J, true);
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[5][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "5", 'LT', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[4][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 1.0, $q1nliC[5][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q2nliC[5][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 1.0, $smstr1C[5][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q3nliC[5][0], 'LRT', 0, C, true);
	
	
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "7", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[6][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.0, $q1nliB[7][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q2nliB[7][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1.0, $smstr1B[7][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q3nliB[7][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[4][0] ,53,53 ), 'R', 0, J, true);
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[6][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "6", 'LT', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[5][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 1.0, $q1nliC[6][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q2nliC[6][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 1.0, $smstr1C[6][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q3nliC[6][0], 'LRT', 0, C, true);
	
	//8
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "8", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[7][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nliB[8][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nliB[8][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1B[8][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nliB[8][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[5][0] ,53,53 ), 'R', 0, J, true);
	
	//
	
	//9
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "9", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[8][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nliB[9][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nliB[9][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1B[9][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nliB[9][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "7", 'LT', 0, C, true);									$pdf->Cell(7	, 0.5, substr( $nmektr3[6][0] ,0,53 ), 'RT', 0, J, true);								$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 1.0, $q1nliC[7][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q2nliC[7][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 1.0, $smstr1C[7][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q3nliC[7][0], 'LRT', 0, C, true);
	
	
	
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "10", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[9][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nliB[10][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nliB[10][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1B[10][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nliB[10][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[6][0] ,53,53 ), 'R', 0, J, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.5, "Mandarin", 'LRT', 0, L, true);										$pdf->SetFont('Arial','',10);	$pdf->SetFillColor(255,255,255);						$pdf->Cell( 2	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "8", 'LT', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[7][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 1.5, $q1nliC[8][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.5, $q2nliC[8][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 1.5, $smstr1C[8][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.5, $q3nliC[8][0], 'LRT', 0, C, true);
	
	
	
	
	
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetMargins(0.5,0.1,1);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "1", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[10][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1, $q1nliB[11][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q2nliB[11][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1, $smstr1B[11][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1, $q3nliB[11][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[7][0] ,53,53 ), 'R', 0, J, true);
	//1
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[10][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[7][0] ,106,53 ), 'R', 0, J, true);
	
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "2", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[11][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.0, $q1nliB[12][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q2nliB[12][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1.0, $smstr1B[12][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q3nliB[12][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "9", 'LT', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[8][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 1.0, $q1nliC[9][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q2nliC[9][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 1.0, $smstr1C[9][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1, $q3nliC[9][0], 'LRT', 0, C, true);
	//2
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[11][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[8][0] ,53,53 ), 'R', 0, J, true);
		
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "3", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[12][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nliB[13][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nliB[13][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1B[13][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nliB[13][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2	,1.0,'','',0,C,false);					$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.5, 0.5, "C. Shape, Space and Measure", 'LRT', 0, L, true);
																								
	
	
	
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "4", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[13][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nliB[14][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nliB[14][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1B[14][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nliB[14][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->SetFillColor(255,255,255);						$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "10", 'LT', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[9][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 1.0, $q1nliC[10][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q2nliC[10][0], 'LRT', 0, C, true);		$pdf->Cell(2.25	, 1.0, $smstr1C[10][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1, $q3nliC[10][0], 'LRT', 0, C, true);
	
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "5", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[14][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.0, $q1nliB[15][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q2nliB[15][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 1.0, $smstr1B[15][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q3nliB[15][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[9][0] ,53,53 ), 'R', 0, J, true);
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[14][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "11", 'LT', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[10][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 1.5, $q1nliC[11][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.5, $q2nliC[11][0], 'LRT', 0, C, true);		$pdf->Cell(2.25	, 1.5, $smstr1C[11][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.5, $q3nliC[11][0], 'LRT', 0, C, true);
	
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "6", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[15][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.0, $q1nliB[16][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q2nliB[16][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 1.0, $smstr1B[16][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q3nliB[16][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[10][0] ,53,53 ), 'R', 0, J, true);
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[15][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[10][0] ,106,53 ), 'R', 0, J, true);
	
	
	
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "7", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[16][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.0, $q1nliB[17][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q2nliB[17][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 1.0, $smstr1B[17][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q3nliB[17][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell(2	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "12", 'LT', 0, C, true);			$pdf->Cell(7	, 0.5, substr( $nmektr3[11][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 0.5, $q1nliC[12][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.5, $q2nliC[12][0], 'LRT', 0, C, true);		$pdf->Cell(2.25	, 0.5, $smstr1C[12][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.5, $q3nliC[12][0], 'LRT', 0, C, true);
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[16][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "13", 'LT', 0, C, true);			$pdf->Cell(7	, 0.5, substr( $nmektr3[12][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 0.5, $q1nliC[13][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.5, $q2nliC[13][0], 'LRT', 0, C, true);		$pdf->Cell(2.25	, 0.5, $smstr1C[13][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.5, $q3nliC[13][0], 'LRT', 0, C, true);
	
	//8
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "8", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[17][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 0.5, $q1nliB[18][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q2nliB[18][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 0.5, $smstr1B[18][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.5, $q3nliB[18][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "14", 'LT', 0, C, true);			$pdf->Cell(7	, 0.5, substr( $nmektr3[13][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 1.0, $q1nliC[14][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q2nliC[14][0], 'LRT', 0, C, true);		$pdf->Cell(2.25	, 1.0, $smstr1C[14][0], 'LRT', 0, C, true);			$pdf->Cell(1.25	, 1, $q3nliC[14][0], 'LRT', 0, C, true);
																								
	
	
	
	//mpe sini 89
	
	
	
	//9
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "9", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[18][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.0, $q1nliB[19][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q2nliB[19][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 1.0, $smstr1B[19][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q3nliB[19][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[13][0] ,53,53 ), 'R', 0, J, true);
	//9
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[18][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);				$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "15", 'LT', 0, C, true);								$pdf->Cell(7	, 0.5, substr( $nmektr3[14][0] ,0,53 ), 'RT', 0, J, true);								$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 1.0, $q1nliC[15][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q2nliC[15][0], 'LRT', 0, C, true);		$pdf->Cell(2.25	, 1.0, $smstr1C[15][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q3nliC[15][0], 'LRT', 0, C, true);
	
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "10", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[19][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.25	, 1.0, $q1nliB[20][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q2nliB[20][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 1.0, $smstr1B[20][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.0, $q3nliB[20][0], 'LRTB', 0, C, true);									$pdf->SetFont('Arial','',10);	$pdf->Cell( 2		,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[14][0] ,53,53 ), 'R', 0, J, true);
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0.5	, 0.5, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr2[19][0] ,53,53 ), 'RB', 0, J, true);					$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "16", 'LT', 0, C, true);			$pdf->Cell(7	, 0.5, substr( $nmektr3[15][0] ,0,53 ), 'RT', 0, J, true);																												$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 1.0, $q1nliC[16][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.0, $q2nliC[16][0], 'LRT', 0, C, true);		$pdf->Cell(2.25	, 1.0, $smstr1C[16][0], 'LRT', 0, C, true);			$pdf->Cell(1.25	, 1.0, $q3nliC[16][0], 'LRT', 0, C, true);
	
	
	
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, "", '', 0, J, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[15][0] ,53,53 ), 'R', 0, J, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, "", '', 0, J, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "17", 'LT', 0, C, true);								$pdf->Cell(7	, 0.5, substr( $nmektr3[16][0] ,0,53 ), 'RT', 0, J, true);								$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 2.0, $q1nliC[17][0], 'LRTB', 0, C, true);		$pdf->Cell(1.25	, 2.0, $q2nliC[17][0], 'LRTB', 0, C, true);		$pdf->Cell(2.25	, 2.0, $smstr1C[17][0], 'LRTB', 0, C, true);		$pdf->Cell(1.25	, 2.0, $q3nliC[17][0], 'LRTB', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);//17
	$pdf->Cell(7	, 0.5, "", '', 0, J, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[16][0] ,53,53 ), 'R', 0, J, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, "", '', 0, J, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[16][0] ,106,53 ), 'R', 0, J, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);	
	$pdf->Cell(7	, 0.5, "", '', 0, J, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8	,0.5,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "", 'LB', 0, C, true);				$pdf->Cell(7	, 0.5, substr( $nmektr3[16][0] ,159,53 ), 'RB', 0, J, true);
	
	
	
	//MPE SINI 0.4 0.8
	

	
	
	
	
	//..halaman 5
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell( 5	,0.4,'','',0,C,true);
	$pdf->Cell(3, 0.8, "Creative Development", '', 0, C, true);									$pdf->SetFont('Arial','B',13);	$pdf->Cell( 12.5	,0.4,'','',0,C,false);					$pdf->Cell(3, 0.8, 'English Communication, Language and Literacy', '', 0, C, true);					
	
	//1
	$pdf->Ln(0.8);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(7.5, 0.8, "Learning Goals", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(1.25, 0.4, "TERM", 'LRT', 0, C, true);
	$pdf->Cell(1.25, 0.4, "TERM", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(2.25, 0.4, "SEMESTER", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(1.25, 0.4, "TERM", 'LRT', 0, C, true);											$pdf->SetFont('Arial','B',13);	$pdf->Cell( 2	,0.8,'','',0,C,false);						$pdf->Cell(7.5, 0.8, "Learning Goals", 'LRT', 0, C, true);	$pdf->SetFont('Arial','B',10);													$pdf->Cell(1.25, 0.4, "TERM", 'LRT', 0, C, true);								$pdf->Cell(1.25, 0.4, "TERM", 'LRT', 0, C, true);	$pdf->SetFont('Arial','B',11);					$pdf->Cell(2.25, 0.4, "SEMESTER", 'LRT', 0, C, true);			$pdf->SetFont('Arial','B',10);			$pdf->Cell(1.25, 0.4, "TERM", 'LRT', 0, C, true);
	
	$pdf->Ln(0.4);
	$pdf->Cell(7.5, 0.8, "", '', 0, C, false);
	$pdf->Cell(1.25, 0.4, "1", 'LR', 0, C, true);
	$pdf->Cell(1.25, 0.4, "2", 'LR', 0, C, true);
	$pdf->Cell(2.25, 0.4, "1", 'LR', 0, C, true);
	$pdf->Cell(1.25, 0.4, "3", 'LR', 0, C, true);												$pdf->SetFont('Arial','B',13);	$pdf->Cell( 2	,0.8,'','',0,C,false);						$pdf->Cell(7.5, 0.8, "", '', 0, C, false);					$pdf->SetFont('Arial','B',10);													$pdf->Cell(1.25, 0.4, "1", 'LR', 0, C, true);		$pdf->Cell(1.25, 0.4, "2", 'LR', 0, C, true);	$pdf->SetFont('Arial','B',11);						$pdf->Cell(2.25, 0.4, "1", 'LR', 0, C, true);				$pdf->SetFont('Arial','B',10);			$pdf->Cell(1.25, 0.4, "3", 'LR', 0, C, true);
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.4, "A. Exploring Media and Art Materials", 'LRT', 0, L, true);			$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2	,0.8,'','',0,C,false);						$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.5, 0.4, "A. Listening and Speaking", 'LRT', 0, L, true);
	
	//1
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "1", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[0][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 0.8, $q1nliD[1][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q2nliD[1][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.8, $smstr1D[1][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q3nliD[1][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "1", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[0][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.4, $q1nliF[1][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.4, $q2nliF[1][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.4, $smstr1F[1][0], 'LRT', 0, C, true);			$pdf->Cell(1.25	, 0.4, $q3nliF[1][0], 'LRT', 0, C, true);
	//1
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[0][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "2", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[1][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.8, $q1nliF[2][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[2][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[2][0], 'LRT', 0, C, true);			$pdf->Cell(1.25	, 0.8, $q3nliF[2][0], 'LRT', 0, C, true);
	
	
	
	//2
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "2", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[1][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 0.4, $q1nliD[2][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.4, $q2nliD[2][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.4, $smstr1D[2][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.4, $q3nliD[2][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr6[1][0] ,53,53 ), 'R', 0, J, true);
	
	//3
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "3", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[2][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 0.8, $q1nliD[3][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q2nliD[3][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.8, $smstr1D[3][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q3nliD[3][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "3", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[2][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.8, $q1nliF[3][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[3][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[3][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q3nliF[3][0], 'LRT', 0, C, true);
	//3
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[2][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr6[2][0] ,53,53 ), 'R', 0, J, true);
	
	
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.4, "B. Music", 'LRT', 0, L, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "4", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[3][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.4, $q1nliF[4][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.4, $q2nliF[4][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.4, $smstr1F[4][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.4, $q3nliF[4][0], 'LRT', 0, C, true);
	
	//4
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "4", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[3][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 0.4, $q1nliD[4][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.4, $q2nliD[4][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.4, $smstr1D[4][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.4, $q3nliD[4][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "5", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[4][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.8, $q1nliF[5][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[5][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[5][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q3nliF[5][0], 'LRT', 0, C, true);
	
	
	
	//5
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "5", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[4][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 0.4, $q1nliD[5][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.4, $q2nliD[5][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.4, $smstr1D[5][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.4, $q3nliD[5][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr6[4][0] ,53,53 ), 'R', 0, J, true);
	
	//6
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "6", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[5][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 0.4, $q1nliD[6][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.4, $q2nliD[6][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 0.4, $smstr1D[6][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 0.4, $q3nliD[6][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "6", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[5][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.8, $q1nliF[6][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[6][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[6][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q3nliF[6][0], 'LRT', 0, C, true);
	
	
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.4, "C. Responding and Expressing ideas", 'LRT', 0, L, true);				$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[5][0] ,53,53 ), 'R', 0, J, true);
	
	
	
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "7", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[6][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 0.8, $q1nliD[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q2nliD[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 0.8, $smstr1D[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q3nliD[7][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "7", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[6][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.4, $q1nliF[7][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.4, $q2nliF[7][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.4, $smstr1F[7][0], 'LRT', 0, C, true);			$pdf->Cell(1.25	, 0.4, $q3nliF[7][0], 'LRT', 0, C, true);
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[6][0] ,53,53 ), 'RB', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "8", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[7][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.8, $q1nliF[8][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[8][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[8][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q3nliF[8][0], 'LRT', 0, C, true);
	
	
	
	//8
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "8", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[7][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 0.8, $q1nliD[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q2nliD[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 0.8, $smstr1D[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q3nliD[8][0], 'LRTB', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr6[7][0] ,53,53 ), 'R', 0, J, true);
	//8
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr4[7][0] ,53,53 ), 'RB', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "9", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[8][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.8, $q1nliF[9][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[9][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[9][0], 'LRT', 0, C, true);			$pdf->Cell(1.25	, 0.8, $q3nliF[9][0], 'LRT', 0, C, true);
	
	
	
	$pdf->Ln(0.4);																				$pdf->SetFont('Arial','',8);	$pdf->Cell( 15.5	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr6[8][0] ,53,53 ), 'R', 0, J, true);
	$pdf->Ln(0.4);																					
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell( 5	,0.4,'','',0,C,true);
	$pdf->Cell(3, 0.4, "Physical Development (Gross and Fine Motor)", '', 0, C, true);			$pdf->SetFont('Arial','',8);	$pdf->Cell( 7.5	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "10", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[9][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.8, $q1nliF[10][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[10][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[10][0], 'LRT', 0, C, true);			$pdf->Cell(1.25	, 0.8, $q3nliF[10][0], 'LRT', 0, C, true);
	
	$pdf->Ln(0.4);																				$pdf->SetFont('Arial','',8);	$pdf->Cell( 15.5	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr6[9][0] ,53,53 ), 'R', 0, J, true);
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.4, "A. Gross Motor Development", 'LRT', 0, L, true);						$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2	,0.8,'','',0,C,false);						$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.5, 0.4, "B. Reading and Writing", 'LRT', 0, L, true);
	
	
	
	//1
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "1", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[0][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 1.2, $q1nliE[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.2, $q2nliE[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 1.2, $smstr1E[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.2, $q3nliE[1][0], 'LRTB', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "11", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[10][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.8, $q1nliF[11][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[11][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[11][0], 'LRT', 0, C, true);			$pdf->Cell(1.25	, 0.8, $q3nliF[11][0], 'LRT', 0, C, true);
	//1
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[0][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr6[10][0] ,53,53 ), 'R', 0, J, true);
	//1
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[0][0] ,106,53 ), 'RB', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "12", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[11][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.4, $q1nliF[12][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.4, $q2nliF[12][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.4, $smstr1F[12][0], 'LRT', 0, C, true);			$pdf->Cell(1.25	, 0.4, $q3nliF[12][0], 'LRT', 0, C, true);
	
	//2
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "2", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[1][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 0.8, $q1nliE[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q2nliE[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 0.8, $smstr1E[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q3nliE[2][0], 'LRTB', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "13", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[12][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 0.4, $q1nliF[13][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.4, $q2nliF[13][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.4, $smstr1F[13][0], 'LRT', 0, C, true);			$pdf->Cell(1.25	, 0.4, $q3nliF[13][0], 'LRT', 0, C, true);			$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LR', 0, J, true);
	//2
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[1][0] ,53,53 ), 'RB', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "14", 'LT', 0, C, true);									$pdf->Cell(7	, 0.4, substr( $nmektr6[13][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);						$pdf->Cell(1.25	, 1.2, $q1nliF[14][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 1.2, $q2nliF[14][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 1.2, $smstr1F[14][0], 'LRT', 0, C, true);			$pdf->Cell(1.25	, 1.2, $q3nliF[14][0], 'LRT', 0, C, true);
	
	
	
	//3
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "3", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[2][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 1.2, $q1nliE[3][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.2, $q2nliE[3][0], 'LRT', 0, C, true);
	$pdf->Cell(2.25	, 1.2, $smstr1E[3][0], 'LRT', 0, C, true);
	$pdf->Cell(1.25	, 1.2, $q3nliE[3][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr6[13][0] ,53,53 ), 'R', 0, J, true);
	//3
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[2][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr6[13][0] ,106,53 ), 'R', 0, J, true);
	//3
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[2][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "15", 'LT', 0, C, true);											$pdf->Cell(7	, 0.4, substr( $nmektr6[14][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);				$pdf->Cell(1.25	, 0.8, $q1nliF[15][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[15][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[15][0], 'LRT', 0, C, true);				$pdf->Cell(1.25	, 0.8, $q3nliF[15][0], 'LRT', 0, C, true);
	
	//4
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "4", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[3][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 1.2, $q1nliE[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.2, $q2nliE[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 1.2, $smstr1E[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.2, $q3nliE[4][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);				$pdf->Cell(7	, 0.4, substr( $nmektr6[14][0] ,53,53 ), 'R', 0, J, true);
	//4
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[3][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "16", 'LT', 0, C, true);											$pdf->Cell(7	, 0.4, substr( $nmektr6[15][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);				$pdf->Cell(1.25	, 0.8, $q1nliF[16][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[16][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[16][0], 'LRT', 0, C, true);				$pdf->Cell(1.25	, 0.8, $q3nliF[16][0], 'LRT', 0, C, true);
	//4
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[3][0] ,106,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);											$pdf->Cell(7	, 0.4, substr( $nmektr6[15][0] ,53,53 ), 'R', 0, J, true);
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.4, "B. Fine Motor Development", 'LRT', 0, L, true);						$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "17", 'LT', 0, C, true);											$pdf->Cell(7	, 0.4, substr( $nmektr6[16][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);				$pdf->Cell(1.25	, 0.8, $q1nliF[17][0], 'LRT', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[17][0], 'LRT', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[17][0], 'LRT', 0, C, true);				$pdf->Cell(1.25	, 0.8, $q3nliF[17][0], 'LRT', 0, C, true);
	
	//5
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "5", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[4][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 0.8, $q1nliE[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q2nliE[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 0.8, $smstr1E[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q3nliE[5][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);											$pdf->Cell(7	, 0.4, substr( $nmektr6[16][0] ,53,53 ), 'R', 0, J, true);
	//5
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[4][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "18", 'LT', 0, C, true);											$pdf->Cell(7	, 0.4, substr( $nmektr6[17][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);				$pdf->Cell(1.25	, 0.8, $q1nliF[18][0], 'LRTB', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[18][0], 'LRTB', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[18][0], 'LRTB', 0, C, true);			$pdf->Cell(1.25	, 0.8, $q3nliF[18][0], 'LRTB', 0, C, true);
	
	//6
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "6", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[5][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 0.8, $q1nliE[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q2nliE[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 0.8, $smstr1E[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q3nliE[6][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);											$pdf->Cell(7	, 0.4, substr( $nmektr6[17][0] ,53,53 ), 'R', 0, J, true);
	//6
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[5][0] ,53,53 ), 'RB', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 8	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "19", 'LT', 0, C, true);											$pdf->Cell(7	, 0.4, substr( $nmektr6[18][0] ,0,53 ), 'RT', 0, J, true);		$pdf->SetFont('Arial','',11);					$pdf->Cell(1.25	, 0.8, $q1nliF[19][0], 'LRTB', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q2nliF[19][0], 'LRTB', 0, C, true);	$pdf->Cell(2.25	, 0.8, $smstr1F[19][0], 'LRTB', 0, C, true);		$pdf->Cell(1.25	, 0.8, $q3nliF[19][0], 'LRTB', 0, C, true);
	
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "7", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[6][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 1.2, $q1nliE[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.2, $q2nliE[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 1.2, $smstr1E[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.2, $q3nliE[7][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','',8);	$pdf->Cell( 2	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);											$pdf->Cell(7	, 0.4, substr( $nmektr6[18][0] ,53,53 ), 'RB', 0, J, true);
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[6][0] ,53,53 ), 'R', 0, J, true);					
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[6][0] ,106,53 ), 'RB', 0, J, true);					
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.5, 0.4, "C. Health and Body Awareness", 'LRT', 0, L, true);					
	
	//8
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "8", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[7][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 0.8, $q1nliE[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 0.8, $q2nliE[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 0.8, $smstr1E[8][0], 'LRTB', 0, C, true);									
	$pdf->Cell(1.25	, 0.8, $q3nliE[8][0], 'LRTB', 0, C, true);
	//8
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[7][0] ,53,53 ), 'RB', 0, J, true);	
	
	//9
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "9", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[8][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(1.25	, 1.2, $q1nliE[9][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.25	, 1.2, $q2nliE[9][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.25	, 1.2, $smstr1E[9][0], 'LRTB', 0, C, true);												
	$pdf->Cell(1.25	, 1.2, $q3nliE[9][0], 'LRTB', 0, C, true);
	//9
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[8][0] ,53,53 ), 'R', 0, J, true);
	//9
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.4, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.4, substr( $nmektr5[8][0] ,106,53 ), 'RB', 0, J, true);
//};
$pdf->Output();
?>