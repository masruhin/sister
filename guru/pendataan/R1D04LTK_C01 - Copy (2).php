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
	
// dapatkan data kepala sekolah
/*$query 	="	SELECT 		t_prstkt.*,t_mstkry.*
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
}*/

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
/*while($j<$i)
{
	$pdf->Open();
	$pdf->AddPage('L');
	
	
	
	
	//.. sampai sini
	
	
	
	
	//----

};*/ 



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
	
	
	
	//..halaman 2
	//----
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(255,255,255); 
	$pdf->Cell( 5	,0.4,'','',0,C,true);
	$pdf->Cell(1, 1, "SECOND TERM", '', 0, C, true);
	$pdf->Ln(0.75);
	$pdf->Cell( 5	,0.4,'','',0,C,true);
	$pdf->Cell(1, 1, "REMARKS", '', 0, C, true);
	
	
	
	//$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	//$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(1.5, 1, "1. Personal, Social, and Emotional Development", '', 0, L, true);//LRTB
	//1
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LRT', 0, C, true);
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//4
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LRB', 0, C, true);
	
	
	
	//$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	//$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(1, 1, "2. Communication, Language and Literacy", '', 0, L, true);					$pdf->SetFont('Arial','B',16);	$pdf->Cell( 17.5	,1,'','',0,C,false);	$pdf->Cell(1, 1, "Student's Information", '', 0, L, true);//LRTB
	//1
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.75, "", 'LRT', 0, C, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 5	,0.5,'','',0,C,false);	$pdf->Cell(3, 1, " Student No.", 'LT', 0, L, true);			$pdf->Cell(0.5, 1, " : ", 'T', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(7.5, 1, substr($kdekls,0,3), 'RT', 0, L, true);//nis
	//2
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.75, "", 'LR', 0, C, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 5	,0.5,'','',0,C,false);	$pdf->Cell(3, 1, " Name", 'L', 0, L, true);					$pdf->Cell(0.5, 1, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(7.5, 1, $nmassw, 'R', 0, L, true);//nis
	//3
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,false);
	$pdf->Cell(10, 0.75, "", 'LR', 0, C, false);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 5	,0.5,'','',0,C,false);	$pdf->Cell(3, 1, " Class", 'L', 0, L, true);				$pdf->Cell(0.5, 1, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(7.5, 1, $kkelas, 'R', 0, L, true);//nis
	//4
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.75, "", 'LRB', 0, C, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 5	,0.5,'','',0,C,false);	$pdf->Cell(3, 1, " Place of Birth", 'L', 0, L, true);		$pdf->Cell(0.5, 1, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(7.5, 1, $tmplhr, 'R', 0, L, true);
	
	
	
	//$pdf->Ln();
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','BU',11);
	//$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(1, 0.75, "3. Mathematical/Cognitive Development", '', 0, L, true);					$pdf->SetFont('Arial','',11);	$pdf->Cell( 15.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 1, " Date of Birth", 'L', 0, L, true);		$pdf->Cell(0.5, 1, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(7.5, 1, $tgllhr, 'R', 0, L, true);//nis
	
	
	
	//1
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.75, "", 'LRT', 0, C, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 5	,0.5,'','',0,C,false);	$pdf->Cell(3, 1, " Mother's Name", 'L', 0, L, true);		$pdf->Cell(0.5, 1, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(7.5, 1, $nmaibu, 'R', 0, L, true);//nis
	//2
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.75, "", 'LR', 0, C, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 5	,0.5,'','',0,C,false);	$pdf->Cell(3, 1, " Father's Name", 'L', 0, L, true);		$pdf->Cell(0.5, 1, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(7.5, 1, $nmaayh, 'R', 0, L, true);//nis
	//3
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.75, "", 'LR', 0, C, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 5	,0.5,'','',0,C,false);	$pdf->Cell(3, 1, " Address", 'LB', 0, L, true);				$pdf->Cell(0.5, 1, " : ", 'B', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(7.5, 1, $almt, 'RB', 0, L, true);//nis
	
	//4
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.75, "", 'LR', 0, C, true);
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LRB', 0, C, true);
	
	
	
	//$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	//$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(1, 1, "4. Creative Development", '', 0, L, true);									$pdf->SetFont('Arial','',11);	$pdf->Cell( 23.25	,1,'','',0,C,false);	$pdf->Cell(3, 1, "Jakarta, ".$tglctk, '', 0, R, true);				
	//1
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LRT', 0, C, true);
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//4
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LRB', 0, C, true);														$pdf->SetFont('Arial','U',11);	$pdf->Cell( 13	,1,'','',0,C,false);	$pdf->Cell(3, 1, 'Glorya Lumbantoruan S.Pd.', '', 0, R, true);				
	
	
	
	$pdf->Image($signature, 18, 13.8, 5, 4);
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','BU',11);
	//$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(1, 0.75, "5. Physical Development (Gross and Fine Motor Skills)", '', 0, L, true);	$pdf->SetFont('Arial','',11);	$pdf->Cell( 22.5	,0.75,'','',0,C,false);	$pdf->Cell(3, 0.75, 'School Principal', '', 0, C, true);				
	//1
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LRT', 0, C, true);
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//4
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( 1.5	,0.4,'','',0,C,true);
	$pdf->Cell(10, 0.5, "", 'LRB', 0, C, true);
	
	
	
	
	
	
	
	//..halaman 3
	/*$pdf->SetFillColor(255,255,255);*/
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell( 5	,0.4,'','',0,C,true);
	$pdf->Cell(3, 1, "Personal, Social and Emotional Development", '', 0, C, true);				$pdf->SetFont('Arial','B',14);	$pdf->Cell( 12.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.75, 'FIRST TERM', '', 0, C, true);					
	
	//1
	//$pdf->Ln();
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',13);
	//$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(7.5, 1, "Learning Goals", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(1.5, 1, "Term 1", 'LRT', 0, C, true);
	$pdf->Cell(1.5, 1, "Term 2", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(2.75, 1, "SEMESTER 1", 'LRT', 0, C, true);										$pdf->SetFont('Arial','B',14);	$pdf->Cell( 7.25	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.75, "REMARKS", '', 0, C, true);					
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "A. Spirituality and Religiosity", 'LRT', 0, L, true);
	
	//1
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "1", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.5	,0.5,'','',0,C,false);	$pdf->Cell(1, 0.75, "1. Personal, Social, and Emotional Development", '', 0, L, true);
	
	//1
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 10	,0.4,'','',0,C,false);		$pdf->Cell(10, 0.5, "", 'LRT', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "2", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//2
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 10	,0.4,'','',0,C,false);		$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "B. Disposition and attitude", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);				$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "3", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LRB', 0, C, true);
	//3
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 8.3	,0.5,'','',0,C,false);		$pdf->Cell(1, 0.75, "2. Communication, Language and Literacy", '', 0, L, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "4", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LRT', 0, C, true);
	//4
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 10	,0.4,'','',0,C,false);		$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	//4
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 10	,0.4,'','',0,C,false);		$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "5", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);		$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//5
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 10	,0.4,'','',0,C,false);			$pdf->Cell(10, 0.5, "", 'LRB', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "C. Self-care and Independence", 'LRT', 0, L, true);					$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.55	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.75, "3. Mathematical/Cognitive Development", '', 0, L, true);
	
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "6", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LRT', 0, C, true);
	//6
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 10	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//7
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "7", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//7
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 10	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//8
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "8", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LRB', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "D. Confidence and Self-esteem", 'LRT', 0, L, true);					$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.55	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.75, "4. Creative Development", '', 0, L, true);
	
	//9
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "9", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LRT', 0, C, true);
	//9
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 10	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//10
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "10", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//10
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 10	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	//10
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 10	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LRB', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//11
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "11", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.55	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.75, "5. Physical Development (Gross and Fine Motor Skills)", '', 0, L, true);
	
	//12
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "12", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LRT', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "E. Behaviour and self-control", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	
	//13
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "13", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	//13
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 10	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//14
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "14", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 4.25	,0.4,'','',0,C,false);	$pdf->Cell(10, 0.5, "", 'LRB', 0, C, true);
	
	//15
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "15", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												
	//15
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//16
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "16", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 1.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 1.5, "", 'LRTB', 0, C, true);												
	//16
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	//16
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LRB', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRB', 0, C, true);												
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	
	
	//..halaman 4
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell( 5	,0.4,'','',0,C,true);
	$pdf->Cell(3, 1, "Communication, Language and Literacy", '', 0, C, true);					$pdf->SetFont('Arial','B',13);	$pdf->Cell( 12.5	,0.5,'','',0,C,false);					$pdf->Cell(3, 0.75, 'Mathematical / Cognitive Development', '', 0, C, true);					
	
	//1
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(7.5, 1, "Learning Goals", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(1.5, 1, "Term 1", 'LRT', 0, C, true);
	$pdf->Cell(1.5, 1, "Term 2", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(2.75, 1, "SEMESTER 1", 'LRT', 0, C, true);										$pdf->SetFont('Arial','B',13);	$pdf->Cell( 2.25	,1,'','',0,C,false);					$pdf->Cell(7.5, 1, "Learning Goals", 'LRT', 0, C, true);	$pdf->SetFont('Arial','B',10);													$pdf->Cell(1.5, 1, "Term 1", 'LRT', 0, C, true);	$pdf->Cell(1.5, 1, "Term 2", 'LRT', 0, C, true);	$pdf->SetFont('Arial','B',11);					$pdf->Cell(2.75, 1, "SEMESTER 1", 'LRT', 0, C, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "Bahasa Indonesia", 'LRT', 0, L, true);								$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.25	,1,'','',0,C,false);					$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.25, 0.5, "A. Numbers as Labels and for Counting", 'LRT', 0, L, true);
	
	//1
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "1", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.5,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "1", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);
	
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "2", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.5,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "2", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);
	
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "3", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.5,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "3", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "4", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "5", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.25	,1,'','',0,C,false);					$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.25, 0.5, "B. Calculating", 'LRT', 0, L, true);
	
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "6", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.5,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "4", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	//6
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//7
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "7", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.5,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "5", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	
	//8
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "8", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	
	//9
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "9", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.5,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "6", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "10", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "Mandarin", 'LRT', 0, L, true);										$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.5,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "7", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "1", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	
	//2
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "2", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.5,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "8", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1.5, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1.5, "", 'LRT', 0, C, true);
	
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "3", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	
	//4
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "4", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "5", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.5,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "9", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	//5
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//6
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "6", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.25	,1,'','',0,C,false);					$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.25, 0.5, "C. Shape, Space and Measure", 'LRT', 0, L, true);
	
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "7", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.5,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "10", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	//7
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//8
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "8", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.5,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "11", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1.5, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1.5, "", 'LRT', 0, C, true);
	
	//9
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "9", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	//9
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);							$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "10", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 1, "", 'LRTB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.5,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "12", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);
	//10
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", 'LRB', 0, C, true);
	$pdf->Cell(7	, 0.5, "", 'LRB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.5,'','',0,C,false);							$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "13", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.5, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.5, "", 'LRT', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);//14
	$pdf->Cell(7	, 0.5, "", '', 0, C, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.5,'','',0,C,false);							$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "14", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, "", '', 0, C, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);							$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);//15
	$pdf->Cell(7	, 0.5, "", '', 0, C, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.5,'','',0,C,false);							$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "15", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, "", '', 0, C, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);							$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);//16
	$pdf->Cell(7	, 0.5, "", '', 0, C, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.5,'','',0,C,false);							$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "16", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, "", '', 0, C, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);							$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);//17
	$pdf->Cell(7	, 0.5, "", '', 0, C, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.5,'','',0,C,false);							$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.5, "17", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.5, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1.5, "", 'LRTB', 0, C, true);		$pdf->Cell(1.5	, 1.5, "", 'LRTB', 0, C, true);	$pdf->Cell(2.75	, 1.5, "", 'LRTB', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, "", '', 0, C, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);							$pdf->Cell(0.5	, 0.5, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->Cell(0.5	, 0.5, "", '', 0, C, false);
	$pdf->Cell(7	, 0.5, "", '', 0, C, false);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);							$pdf->Cell(0.5	, 0.5, "", 'LRB', 0, C, true);				$pdf->Cell(7	, 0.5, "", 'LRB', 0, C, true);
	
	
	
	
	
	
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
	$pdf->Cell(1.5, 0.8, "Term 1", 'LRT', 0, C, true);
	$pdf->Cell(1.5, 0.8, "Term 2", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(2.75, 0.8, "SEMESTER 1", 'LRT', 0, C, true);										$pdf->SetFont('Arial','B',13);	$pdf->Cell( 2.25	,0.8,'','',0,C,false);					$pdf->Cell(7.5, 0.8, "Learning Goals", 'LRT', 0, C, true);	$pdf->SetFont('Arial','B',10);													$pdf->Cell(1.5, 0.8, "Term 1", 'LRT', 0, C, true);	$pdf->Cell(1.5, 0.8, "Term 2", 'LRT', 0, C, true);	$pdf->SetFont('Arial','B',11);					$pdf->Cell(2.75, 0.8, "SEMESTER 1", 'LRT', 0, C, true);
	$pdf->Ln(0.8);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.4, "A. Exploring Media and Art Materials", 'LRT', 0, L, true);			$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.25	,0.8,'','',0,C,false);					$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.25, 0.4, "A. Listening and Speaking", 'LRT', 0, L, true);
	
	//1
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "1", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.8, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "1", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, "", 'LRT', 0, C, true);
	//1
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "2", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, "", 'LRT', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//2
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "2", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.4, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "3", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);									$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	
	//3
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "3", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.8, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);
	//3
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "4", 'LRT', 0, C, true);									$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, "", 'LRT', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.4, "B. Music", 'LRT', 0, L, true);										$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "5", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);									$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	
	//4
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "4", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.4, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);
	
	//5
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "5", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.4, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "6", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);									$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	
	//6
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "6", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.4, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.4, "C. Responding and Expressing ideas", 'LRT', 0, L, true);			$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "7", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);									$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, "", 'LRT', 0, C, true);		
	
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "7", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 0.8, "", 'LRTB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "8", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);									$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	//7
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LRB', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);
	/*$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(1.5	, 0.5, "", 'LR', 0, C, true);
	$pdf->Cell(2.75	, 0.5, "", 'LR', 0, C, true);*/
	
	//8
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "8", 'LRTB', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 0.4, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 0.4, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 0.4, "", 'LRTB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "9", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);									$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, "", 'LRT', 0, C, true);
	
	$pdf->Ln();																					$pdf->SetFont('Arial','',10);	$pdf->Cell( 15.5	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "10", 'LRT', 0, C, true);			$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);									$pdf->Cell(1.5	, 1.2, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1.2, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1.2, "", 'LRT', 0, C, true);
	$pdf->Ln(0.4);																					
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell( 5	,0.4,'','',0,C,true);
	$pdf->Cell(3, 0.8, "Physical Development (Gross and Fine Motor)", '', 0, C, true);			$pdf->SetFont('Arial','',10);	$pdf->Cell( 7.5	,0.8,'','',0,C,false);						$pdf->Cell(0.5	, 0.8, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.8, "", 'LR', 0, C, true);
	
	$pdf->Ln(0.8);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.4, "A. Gross Motor Development", 'LRT', 0, L, true);					$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.25	,0.8,'','',0,C,false);					$pdf->SetFillColor(153,153,153);							$pdf->Cell(13.25, 0.4, "B. Reading and Writing", 'LRT', 0, L, true);
	
	//1
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "1", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.2, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 1.2, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 1.2, "", 'LRTB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "11", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);									$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1, "", 'LRT', 0, C, true);
	//1
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LRB', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);
	//1
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LRB', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);						$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "12", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);									$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, "", 'LRT', 0, C, true);
	
	//2
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "2", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 0.8, "", 'LRTB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "13", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);									$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.4, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.4, "", 'LRT', 0, C, true);
	//2
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LRB', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "14", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);										$pdf->Cell(1.5	, 1.2, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 1.2, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 1.2, "", 'LRT', 0, C, true);
	
	//3
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "3", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.2, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.2, "", 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1.2, "", 'LRT', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);
	//3
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);						$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);
	//3
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "15", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);										$pdf->Cell(1.5	, 0.8, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, "", 'LRT', 0, C, true);
	
	//4
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "4", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 0.8, "", 'LRTB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);				$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);
	//4
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LRB', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "16", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);										$pdf->Cell(1.5	, 0.8, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.4, "B. Fine Motor Development", 'LRT', 0, L, true);						$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);				$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);
	
	//5
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "5", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 0.8, "", 'LRTB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "17", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);										$pdf->Cell(1.5	, 0.8, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, "", 'LRT', 0, C, true);
	//5
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LRB', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);				$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);
	
	//6
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "6", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 0.8, "", 'LRTB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "18", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);										$pdf->Cell(1.5	, 0.8, "", 'LRT', 0, C, true);		$pdf->Cell(1.5	, 0.8, "", 'LRT', 0, C, true);	$pdf->Cell(2.75	, 0.8, "", 'LRT', 0, C, true);
	//6
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LRB', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);				$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);
	
	//7
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "7", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.2, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 1.2, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 1.2, "", 'LRTB', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 2.25	,0.4,'','',0,C,false);					$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "19", 'LRT', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);										$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);		$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);	$pdf->Cell(2.75	, 0.8, "", 'LRTB', 0, C, true);
	//7
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);												$pdf->SetFont('Arial','',10);	$pdf->Cell( 8.0	,0.4,'','',0,C,false);				$pdf->SetFillColor(255,255,255);							$pdf->Cell(0.5	, 0.4, "", 'LRB', 0, C, true);				$pdf->Cell(7	, 0.4, "", 'LRB', 0, C, true);
	//7
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LRB', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRB', 0, C, true);	
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.4, "C. Health and Body Awareness", 'LRT', 0, L, true);
	
	//8
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "8", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 0.8, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 0.8, "", 'LRTB', 0, C, true);												
	//8
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LRB', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRB', 0, C, true);	
	
	//9
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.4, "9", 'LRT', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.2, "", 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 1.2, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 1.2, "", 'LRTB', 0, C, true);												
	//9
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LR', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LR', 0, C, true);	
	//9
	$pdf->Ln(0.4);
	$pdf->Cell(0.5	, 0.4, "", 'LRB', 0, C, true);
	$pdf->Cell(7	, 0.4, "", 'LRB', 0, C, true);	
	
//};
$pdf->Output();
?>