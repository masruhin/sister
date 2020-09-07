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
	
	
	
	$qABS	="	SELECT 		t_hdrkmnps_pgtk1.*
				FROM 		t_hdrkmnps_pgtk1
				WHERE		t_hdrkmnps_pgtk1.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	$q1KMN=$dABS['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN=$dABS['kmn'.'1'.'2']; // q2
	
	$qABS2	="	SELECT 		t_hdrkmnps_pgtk2.*
				FROM 		t_hdrkmnps_pgtk2
				WHERE		t_hdrkmnps_pgtk2.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS2=mysql_query($qABS2) or die('Query gagal40');
	$dABS2=mysql_fetch_array($rABS2);
	$q1KMN2=$dABS2['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN2=$dABS2['kmn'.'1'.'2']; // q2
	
	$qABS3	="	SELECT 		t_hdrkmnps_pgtk3.*
				FROM 		t_hdrkmnps_pgtk3
				WHERE		t_hdrkmnps_pgtk3.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS3=mysql_query($qABS3) or die('Query gagal40');
	$dABS3=mysql_fetch_array($rABS3);
	$q1KMN3=$dABS3['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN3=$dABS3['kmn'.'1'.'2']; // q2
	
	$qABS4	="	SELECT 		t_hdrkmnps_pgtk4.*
				FROM 		t_hdrkmnps_pgtk4
				WHERE		t_hdrkmnps_pgtk4.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS4=mysql_query($qABS4) or die('Query gagal40');
	$dABS4=mysql_fetch_array($rABS4);
	$q1KMN4=$dABS4['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN4=$dABS4['kmn'.'1'.'2']; // q2
	
	$qABS5	="	SELECT 		t_hdrkmnps_pgtk5.*
				FROM 		t_hdrkmnps_pgtk5
				WHERE		t_hdrkmnps_pgtk5.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS5=mysql_query($qABS5) or die('Query gagal40');
	$dABS5=mysql_fetch_array($rABS5);
	$q1KMN5=$dABS5['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN5=$dABS5['kmn'.'1'.'2']; // q2
	
	//..halaman 2
	//----
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(255,255,255); 
	$pdf->Cell( 5.5	,0.4,'','',0,C,true);
	$pdf->Cell(1, 1, "SECOND TERM", '', 0, C, true);
	$pdf->Ln(0.75);
	$pdf->Cell( 5.5	,0.4,'','',0,C,true);
	$pdf->Cell(1, 1, "REMARKS", '', 0, C, true);
	
	
	
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
	$pdf->Cell(11.5, 0.5, substr($q2KMN,243,81), 'LR', 0, J, true);														$pdf->SetFont('Arial','BU',14);	$pdf->Cell( 7	,1,'','',0,C,false);	$pdf->Cell(1, 0.5, "Student's Information", '', 0, L, true);//LRTB
	//5
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN,324,81), 'LRB', 0, J, true);
	
	
	
	$pdf->Ln(0.5);																										$pdf->SetFont('Arial','',11);	$pdf->Cell( 15.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, "", 'LT', 0, L, true);						$pdf->Cell(0.5, 0.5, "", 'T', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'RT', 0, L, true);//nis
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "2. Communication, Language and Literacy", '', 0, L, true);										$pdf->SetFont('Arial','',11);	$pdf->Cell( 14.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Student No.", 'L', 0, L, true);			$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','',11);	$pdf->Cell(10, 0.5, substr($kdekls,0,3), 'R', 0, C, true);//nis
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,0,81), 'LRT', 0, J, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'L', 0, L, true);						$pdf->Cell(0.5, 0.5, "", '', 0, L, true);			$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);//nis
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,81,81), 'LR', 0, J, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Name", 'L', 0, L, true);					$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $nmassw, 'R', 0, C, true);//nis
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,162,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, "", 'L', 0, L, true);					$pdf->Cell(0.5, 0.5, "", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);//nis
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,false);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,243,81), 'LR', 0, J, false);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Class", 'L', 0, L, true);				$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $kkelas, 'R', 0, C, true);//nis
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,324,81), 'LR', 0, L, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'L', 0, L, true);						$pdf->Cell(0.5, 0.5, "  ", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,405,81), 'LR', 0, L, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Place of Birth", 'L', 0, L, true);		$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $tmplhr, 'R', 0, C, true);
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN2,486,81), 'LRB', 0, L, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'L', 0, L, true);					$pdf->Cell(0.5, 0.5, "  ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);//nis
	
	
	$pdf->Ln(0.5);																										$pdf->SetFont('Arial','',11);	$pdf->Cell( 15.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Date of Birth", 'L', 0, L, true);		$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $tgllhr, 'R', 0, C, true);//nis
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "3. Mathematical/Cognitive Development", '', 0, L, true);										$pdf->SetFont('Arial','',11);	$pdf->Cell( 14.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, "", 'L', 0, L, true);					$pdf->Cell(0.5, 0.5, "  ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);//nis
	
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN3,0,81), 'LRT', 0, J, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Mother's Name", 'L', 0, L, true);		$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $nmaibu, 'R', 0, C, true);//nis
	//2
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN3,81,81), 'LR', 0, J, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'L', 0, L, true);					$pdf->Cell(0.5, 0.5, "  ", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);//nis
	//3
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN3,162,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Father's Name", 'L', 0, L, true);		$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);	$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $nmaayh, 'R', 0, C, true);//nis
	
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN3,243,81), 'LR', 0, J, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'L', 0, L, true);					$pdf->Cell(0.5, 0.5, "  ", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'R', 0, L, true);//nis
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN3,324,81), 'LRB', 0, J, true);													$pdf->SetFont('Arial','',11);	$pdf->Cell( 3	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " Address", 'L', 0, L, true);				$pdf->Cell(0.5, 0.5, " : ", '', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, $almt, 'R', 0, C, true);//nis
	
	
	
	$pdf->Ln(0.5);																										$pdf->SetFont('Arial','',11);	$pdf->Cell(15.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, " ", 'LB', 0, L, true);				$pdf->Cell(0.5, 0.5, "", 'B', 0, L, true);		$pdf->SetFont('Arial','U',11);	$pdf->Cell(10, 0.5, '', 'RB', 0, L, true);//nis
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',11);
	$pdf->Cell(1, 0.5, "4. Creative Development", '', 0, L, true);														
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN4,0,81), 'LRT', 0, J, true);														$pdf->SetFont('Arial','',11);	$pdf->Cell( 13.15	,1,'','',0,C,false);	$pdf->Cell(3, 1, "Jakarta, March 28, 2018", '', 0, R, true);//.$tglctk
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
	
	
	
	$pdf->Image($signature, 19.5, 14.25, 4, 4);
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','BU',11);
	//$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(1, 0.5, "5. Physical Development (Gross and Fine Motor Skills)", '', 0, L, true);							$pdf->SetFont('Arial','U',11);	$pdf->Cell( 25	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, 'Glorya Lumbantoruan S.Pd.', '', 0, R, true);				
	//1
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 1	,0.4,'','',0,C,true);
	$pdf->Cell(11.5, 0.5, substr($q2KMN5,0,81), 'LRT', 0, J, true);															$pdf->SetFont('Arial','',11);	$pdf->Cell( 12.6	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.5, 'School Principal', '', 0, L, true);				
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
		
		/*if( $q1nli[$i][0] == 'v' OR $q1nli[$i][0] == 'V' )
			$q1nli[$i][0] = '√';
		if( $q2nli[$i][0] == 'v' OR $q2nli[$i][0] == 'V' )
			$q2nli[$i][0] = '√';*/
		
		if( $q1nli[$i][0]=='-' AND ($q2nli[$i][0]=='v'OR$q2nli[$i][0]=='V') ) // - v
			$smstr1[$i][0] = 'VS';
		else if( $q1nli[$i][0]=='-' AND $q2nli[$i][0]=='-' )// - -
			$smstr1[$i][0] = 'S';
			
		else if( ($q1nli[$i][0]=='v'OR$q1nli[$i][0]=='V') AND ($q2nli[$i][0]=='v'OR$q2nli[$i][0]=='V') ) // v v
			$smstr1[$i][0] = 'VS';
		else if( $q1nli[$i][0]=='+' AND ($q2nli[$i][0]=='v'OR$q2nli[$i][0]=='V') ) // + v
			$smstr1[$i][0] = 'VS';
			
		else if( $q1nli[$i][0]=='NO' AND $q2nli[$i][0]=='+' ) // NO +
			$smstr1[$i][0] = 'S';
		else if( $q1nli[$i][0]=='NO' AND $q2nli[$i][0]=='NO' ) // NO NO
			$smstr1[$i][0] = 'NO';
			
		else if( $q1nli[$i][0]=='+' AND $q2nli[$i][0]=='+' ) // + +
			$smstr1[$i][0] = 'S';
		else if( $q1nli[$i][0]=='+' AND $q2nli[$i][0]=='/' ) // + /
			$smstr1[$i][0] = 'MS';
			
		else if( $q1nli[$i][0]=='/' AND $q2nli[$i][0]=='+' ) // / +
			$smstr1[$i][0] = 'S';
		else if( $q1nli[$i][0]=='NO' AND $q2nli[$i][0]=='v' ) // NO v
			$smstr1[$i][0] = 'VS';
		
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
		
		/*if( $q1nliB[$i][0] == 'v' OR $q1nliB[$i][0] == 'V' )
			$q1nliB[$i][0] = '√';
		if( $q2nliB[$i][0] == 'v' OR $q2nliB[$i][0] == 'V' )
			$q2nliB[$i][0] = '√';*/
		
		if( $q1nliB[$i][0]=='-' AND ($q2nliB[$i][0]=='v'OR$q2nliB[$i][0]=='V') ) // - v
			$smstr1B[$i][0] = 'VS';
		else if( $q1nliB[$i][0]=='-' AND $q2nliB[$i][0]=='-' )// - -
			$smstr1B[$i][0] = 'S';
			
		else if( ($q1nliB[$i][0]=='v'OR$q1nliB[$i][0]=='V') AND ($q2nliB[$i][0]=='v'OR$q2nliB[$i][0]=='V') ) // v v
			$smstr1B[$i][0] = 'VS';
		else if( $q1nliB[$i][0]=='+' AND ($q2nliB[$i][0]=='v'OR$q2nliB[$i][0]=='V') ) // + v
			$smstr1B[$i][0] = 'VS';
			
		else if( $q1nliB[$i][0]=='NO' AND $q2nliB[$i][0]=='+' ) // NO +
			$smstr1B[$i][0] = 'S';
		else if( $q1nliB[$i][0]=='NO' AND $q2nliB[$i][0]=='NO' ) // NO NO
			$smstr1B[$i][0] = 'NO';
			
		else if( $q1nliB[$i][0]=='+' AND $q2nliB[$i][0]=='+' ) // + +
			$smstr1B[$i][0] = 'S';
		else if( $q1nliB[$i][0]=='+' AND $q2nliB[$i][0]=='/' ) // + /
			$smstr1B[$i][0] = 'MS';
			
		else if( $q1nliB[$i][0]=='/' AND $q2nliB[$i][0]=='+' ) // / +
			$smstr1B[$i][0] = 'S';
		
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
		
		/*if( $q1nliC[$i][0] == 'v' OR $q1nliC[$i][0] == 'V' )
			$q1nliC[$i][0] = '√';
		if( $q2nliC[$i][0] == 'v' OR $q2nliC[$i][0] == 'V' )
			$q2nliC[$i][0] = '√';*/
		
		if( $q1nliC[$i][0]=='-' AND ($q2nliC[$i][0]=='v'OR$q2nliC[$i][0]=='V') ) // - v
			$smstr1C[$i][0] = 'VS';
		else if( $q1nliC[$i][0]=='-' AND $q2nliC[$i][0]=='-' )// - -
			$smstr1C[$i][0] = 'S';
			
		else if( ($q1nliC[$i][0]=='v'OR$q1nliC[$i][0]=='V') AND ($q2nliC[$i][0]=='v'OR$q2nliC[$i][0]=='V') ) // v v
			$smstr1C[$i][0] = 'VS';
		else if( $q1nliC[$i][0]=='+' AND ($q2nliC[$i][0]=='v'OR$q2nliC[$i][0]=='V') ) // + v
			$smstr1C[$i][0] = 'VS';
			
		else if( $q1nliC[$i][0]=='NO' AND $q2nliC[$i][0]=='+' ) // NO +
			$smstr1C[$i][0] = 'S';
		else if( $q1nliC[$i][0]=='NO' AND $q2nliC[$i][0]=='NO' ) // NO NO
			$smstr1C[$i][0] = 'NO';
			
		else if( $q1nliC[$i][0]=='+' AND $q2nliC[$i][0]=='+' ) // + +
			$smstr1C[$i][0] = 'S';
		else if( $q1nliC[$i][0]=='+' AND $q2nliC[$i][0]=='/' ) // + /
			$smstr1C[$i][0] = 'MS';
			
		else if( $q1nliC[$i][0]=='/' AND $q2nliC[$i][0]=='+' ) // / +
			$smstr1C[$i][0] = 'S';
		else if( $q1nliC[$i][0]=='NO' AND $q2nliC[$i][0]=='v' ) // NO v
			$smstr1C[$i][0] = 'VS';
		
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
		
		/*if( $q1nliD[$i][0] == 'v' OR $q1nliD[$i][0] == 'V' )
			$q1nliD[$i][0] = '√';
		if( $q2nliD[$i][0] == 'v' OR $q2nliD[$i][0] == 'V' )
			$q2nliD[$i][0] = '√';*/
		
		if( $q1nliD[$i][0]=='-' AND ($q2nliD[$i][0]=='v'OR$q2nliD[$i][0]=='V') ) // - v
			$smstr1D[$i][0] = 'VS';
		else if( $q1nliD[$i][0]=='-' AND $q2nliD[$i][0]=='-' )// - -
			$smstr1D[$i][0] = 'S';
			
		else if( ($q1nliD[$i][0]=='v'OR$q1nliD[$i][0]=='V') AND ($q2nliD[$i][0]=='v'OR$q2nliD[$i][0]=='V') ) // v v
			$smstr1D[$i][0] = 'VS';
		else if( $q1nliD[$i][0]=='+' AND ($q2nliD[$i][0]=='v'OR$q2nliD[$i][0]=='V') ) // + v
			$smstr1D[$i][0] = 'VS';
			
		else if( $q1nliD[$i][0]=='NO' AND $q2nliD[$i][0]=='+' ) // NO +
			$smstr1D[$i][0] = 'S';
		else if( $q1nliD[$i][0]=='NO' AND $q2nliD[$i][0]=='NO' ) // NO NO
			$smstr1D[$i][0] = 'NO';
			
		else if( $q1nliD[$i][0]=='+' AND $q2nliD[$i][0]=='+' ) // + +
			$smstr1D[$i][0] = 'S';
		else if( $q1nliD[$i][0]=='+' AND $q2nliD[$i][0]=='/' ) // + /
			$smstr1D[$i][0] = 'MS';
			
		else if( $q1nliD[$i][0]=='/' AND $q2nliD[$i][0]=='+' ) // / +
			$smstr1D[$i][0] = 'S';
		else if( $q1nliD[$i][0]=='NO' AND $q2nliD[$i][0]=='v' ) // NO v
			$smstr1D[$i][0] = 'VS';
		
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
		
		/*if( $q1nliE[$i][0] == 'v' OR $q1nliE[$i][0] == 'V' )
			$q1nliE[$i][0] = '√';
		if( $q2nliE[$i][0] == 'v' OR $q2nliE[$i][0] == 'V' )
			$q2nliE[$i][0] = '√';*/
		
		if( $q1nliE[$i][0]=='-' AND ($q2nliE[$i][0]=='v'OR$q2nliE[$i][0]=='V') ) // - v
			$smstr1E[$i][0] = 'VS';
		else if( $q1nliE[$i][0]=='-' AND $q2nliE[$i][0]=='-' )// - -
			$smstr1E[$i][0] = 'S';
			
		else if( ($q1nliE[$i][0]=='v'OR$q1nliE[$i][0]=='V') AND ($q2nliE[$i][0]=='v'OR$q2nliE[$i][0]=='V') ) // v v
			$smstr1E[$i][0] = 'VS';
		else if( $q1nliE[$i][0]=='+' AND ($q2nliE[$i][0]=='v'OR$q2nliE[$i][0]=='V') ) // + v
			$smstr1E[$i][0] = 'VS';
			
		else if( $q1nliE[$i][0]=='NO' AND $q2nliE[$i][0]=='+' ) // NO +
			$smstr1E[$i][0] = 'S';
		else if( $q1nliE[$i][0]=='NO' AND $q2nliE[$i][0]=='NO' ) // NO NO
			$smstr1E[$i][0] = 'NO';
			
		else if( $q1nliE[$i][0]=='+' AND $q2nliE[$i][0]=='+' ) // + +
			$smstr1E[$i][0] = 'S';
		else if( $q1nliE[$i][0]=='+' AND $q2nliE[$i][0]=='/' ) // + /
			$smstr1E[$i][0] = 'MS';
			
		else if( $q1nliE[$i][0]=='/' AND $q2nliE[$i][0]=='+' ) // / +
			$smstr1E[$i][0] = 'S';
		else if( $q1nliE[$i][0]=='NO' AND $q2nliE[$i][0]=='v' ) // NO v
			$smstr1E[$i][0] = 'VS';
		
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
		
		/*if( $q1nliF[$i][0] == 'v' OR $q1nliF[$i][0] == 'V' )
			$q1nliF[$i][0] = '√';
		if( $q2nliF[$i][0] == 'v' OR $q2nliF[$i][0] == 'V' )
			$q2nliF[$i][0] = '√';*/
		
		if( $q1nliF[$i][0]=='-' AND ($q2nliF[$i][0]=='v'OR$q2nliF[$i][0]=='V') ) // - v
			$smstr1F[$i][0] = 'VS';
		else if( $q1nliF[$i][0]=='-' AND $q2nliF[$i][0]=='-' )// - -
			$smstr1F[$i][0] = 'S';
			
		else if( ($q1nliF[$i][0]=='v'OR$q1nliF[$i][0]=='V') AND ($q2nliF[$i][0]=='v'OR$q2nliF[$i][0]=='V') ) // v v
			$smstr1F[$i][0] = 'VS';
		else if( $q1nliF[$i][0]=='+' AND ($q2nliF[$i][0]=='v'OR$q2nliF[$i][0]=='V') ) // + v
			$smstr1F[$i][0] = 'VS';
			
		else if( $q1nliF[$i][0]=='NO' AND $q2nliF[$i][0]=='+' ) // NO +
			$smstr1F[$i][0] = 'S';
		else if( $q1nliF[$i][0]=='NO' AND $q2nliF[$i][0]=='NO' ) // NO NO
			$smstr1F[$i][0] = 'NO';
			
		else if( $q1nliF[$i][0]=='+' AND $q2nliF[$i][0]=='+' ) // + +
			$smstr1F[$i][0] = 'S';
		else if( $q1nliF[$i][0]=='+' AND $q2nliF[$i][0]=='/' ) // + /
			$smstr1F[$i][0] = 'MS';
			
		else if( $q1nliF[$i][0]=='/' AND $q2nliF[$i][0]=='+' ) // / +
			$smstr1F[$i][0] = 'S';
		else if( $q1nliF[$i][0]=='NO' AND $q2nliF[$i][0]=='v' ) // NO v
			$smstr1F[$i][0] = 'VS';
		
		$i++;
		$j++;
	}
	
	
	
	
	
	
	//..halaman 3
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell( 5	,0.4,'','',0,C,true);
	$pdf->Cell(3, 1, "Personal, Social and Emotional Development", '', 0, C, true);				$pdf->SetFont('Arial','B',11);	$pdf->Cell( 12.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 0.75, 'FIRST TERM', '', 0, C, true);					
	
	//1
	$pdf->Ln(0.5);																				$pdf->SetFont('Arial','B',14);	$pdf->Cell( 20.5	,0.5,'','',0,C,false);	$pdf->Cell(3, 1, "REMARKS", '', 0, C, true);					
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(7.5, 1, "Learning Goals", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(1.5, 1, "TERM 1", 'LRT', 0, C, true);
	$pdf->Cell(1.5, 1, "TERM 2", 'LRT', 0, C, true);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(2.75, 1, "SEMESTER 1", 'LRT', 0, C, true);										
	$pdf->Ln(1);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "A. Spirituality and Religiosity", 'LRT', 0, L, true);				$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.5	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);						$pdf->Cell(1, 0.5, "1. Personal, Social, and Emotional Development", '', 0, L, true);
	
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
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "B. Disposition and attitude", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN,360,90), 'LRB', 0, J, true);
	
	
	
	//3
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "3", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[2][0] ,0,53 ), 'RT', 0, J, true);					
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 0.5, $q1nli[3][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, $q2nli[3][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, $smstr1[3][0], 'LRT', 0, C, true);										
	
	
	
	
	
	
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "4", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[3][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[4][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[4][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[4][0], 'LRT', 0, C, true);									$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.5	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.5, "2. Communication, Language and Literacy", '', 0, L, true);
	//4
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[3][0] ,53,53 ), 'R', 0, J, true);				$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN2,0,90), 'LRT', 0, J, true);
	
	
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "5", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[4][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[5][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[5][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[5][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN2,90,90), 'LR', 0, J, true);
	//5
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[4][0] ,53,53 ), 'R', 0, J, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN2,180,90), 'LR', 0, J, true);
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "C. Self-care and Independence", 'LRT', 0, L, true);					$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN2,270,90), 'LR', 0, J, true);
	
	
	
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "6", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[5][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[6][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[6][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[6][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN2,360,90), 'LRB', 0, J, true);
	//6
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[5][0] ,53,53 ), 'R', 0, J, true);					
	
	
	
	
	
	
	
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "7", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[6][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[7][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[7][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[7][0], 'LRT', 0, C, true);											$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 2.5	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.5, "3. Mathematical/Cognitive Development", '', 0, L, true);
	//7
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[6][0] ,53,53 ), 'R', 0, J, true);						$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN3,0,90), 'LRT', 0, J, true);
	
	//8
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "8", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[7][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 0.5, $q1nli[8][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, $q2nli[8][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, $smstr1[8][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN3,90,90), 'LR', 0, J, true);
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "D. Confidence and Self-esteem", 'LRT', 0, L, true);						$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q1KMN3,180,90), 'LR', 0, J, true);
	
	//9
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "9", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[8][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[9][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[9][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[9][0], 'LRT', 0, C, true);											$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q1KMN3,270,90), 'LR', 0, J, true);
	//9
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[8][0] ,53,53 ), 'R', 0, J, true);						$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->SetFillColor(255,255,255);										$pdf->Cell(11.5, 0.5, substr($q1KMN3,360,90), 'LRB', 0, J, true);
	
	
	
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "10", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[9][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1.5, $q1nli[10][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1.5, $q2nli[10][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1.5, $smstr1[10][0], 'LRT', 0, C, true);										
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[9][0] ,53,53 ), 'R', 0, J, true);						$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 8.25	,0.5,'','',0,C,false);	$pdf->SetFillColor(255,255,255);										$pdf->Cell(1, 0.5, "4. Creative Development", '', 0, L, true);
	//10
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[9][0] ,106,53 ), 'R', 0, J, true);						$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN4,0,90), 'LRT', 0, J, true);
	
	//11
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "11", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[10][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[11][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[11][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[11][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);			$pdf->Cell(11.5, 0.5, substr($q1KMN4,90,90), 'LR', 0, J, true);
	//11
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[10][0] ,53,53 ), 'R', 0, J, true);						$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);			$pdf->Cell(11.5, 0.5, substr($q1KMN4,180,90), 'LR', 0, J, true);
		
	//12
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "12", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[11][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 0.5, $q1nli[12][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, $q2nli[12][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 0.5, $smstr1[12][0], 'LRTB', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN4,270,90), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','BU',10);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(13.25, 0.5, "E. Behaviour and self-control", 'LRT', 0, L, true);						$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);		$pdf->SetFillColor(255,255,255);									$pdf->Cell(11.5, 0.5, substr($q1KMN4,360,90), 'LRB', 0, J, true);
	
	//13
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "13", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[12][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[13][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[13][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[13][0], 'LRTB', 0, C, true);										
	//13
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[12][0] ,53,53 ), 'R', 0, J, true);						$pdf->SetFont('Arial','BU',11);	$pdf->Cell( 8.25	,0.5,'','',0,C,false);		$pdf->SetFillColor(255,255,255);				$pdf->Cell(1, 0.5, "5. Physical Development (Gross and Fine Motor Skills)", '', 0, L, true);
	
	
	//14
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "14", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[13][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 0.5, $q1nli[14][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 0.5, $q2nli[14][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 0.5, $smstr1[14][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN5,0,90), 'LRT', 0, J, true);
	
	
	//15
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "15", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[14][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1, $q1nli[15][0], 'LRT', 0, C, true);
	$pdf->Cell(1.5	, 1, $q2nli[15][0], 'LRT', 0, C, true);
	$pdf->Cell(2.75	, 1, $smstr1[15][0], 'LRT', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->SetFillColor(255,255,255);				$pdf->Cell(11.5, 0.5, substr($q1KMN5,90,90), 'LR', 0, J, true);
	//15
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[14][0] ,53,53 ), 'R', 0, J, true);						$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN5,180,90), 'LR', 0, J, true);						
	
	//16
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(0.5	, 0.5, "16", 'LT', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[15][0] ,0,53 ), 'RT', 0, J, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1.5	, 1.5, $q1nli[16][0], 'LRTB', 0, C, true);
	$pdf->Cell(1.5	, 1.5, $q2nli[16][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.75	, 1.5, $smstr1[16][0], 'LRTB', 0, C, true);										$pdf->SetFont('Arial','',8);	$pdf->Cell( 3.25	,0.4,'','',0,C,false);	$pdf->Cell(11.5, 0.5, substr($q1KMN5,270,90), 'LR', 0, J, true);
	//16
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'L', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[15][0] ,53,53 ), 'R', 0, J, true);						$pdf->SetFont('Arial','',8);	$pdf->Cell( 9	,0.4,'','',0,C,false);		$pdf->Cell(11.5, 0.5, substr($q1KMN5,360,90), 'LRB', 0, J, true);						
	//16
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0.5	, 0.5, "", 'LB', 0, C, true);
	$pdf->Cell(7	, 0.5, substr( $nmektr[15][0] ,106,53 ), 'RB', 0, J, true);	
	
	
	
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