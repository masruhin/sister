<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LTKaA_C01.php
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
	


$signature	="../../images/Pre-K/".$kdekls.".jpg";

$pdf =new FPDF('P','cm','A4');
$pdf->SetMargins(0.1,0.1,0.1);
$pdf->SetAutoPageBreak(True, 0.05);

//nli1
$qLGKG	="	SELECT 		 t_learnrcd_tk_akr.*
			FROM 		 t_learnrcd_tk_akr
			WHERE		 t_learnrcd_tk_akr.nis='$kdekls' AND ( t_learnrcd_tk_akr.kdekls='KG-A1' OR t_learnrcd_tk_akr.kdekls='KG-A2' ) AND t_learnrcd_tk_akr.kdeplj='AKG-A' ";
$rLGKG=mysql_query($qLGKG) or die('Query gagal40');
$dLGKG =mysql_fetch_array($rLGKG);
$i=1;
$j=1;
while($i<26)
{
	$q1nli[$i][0]=$dLGKG['hw'.'1'.'1'."$j"];
	$q2nli[$i][0]=$dLGKG['hw'.'1'.'2'."$j"];
	
	$q3nli[$i][0]=$dLGKG['hw'.'2'.'1'."$j"];
	$q4nli[$i][0]=$dLGKG['hw'.'2'.'2'."$j"];
	
	//smstr 1
	if( $q1nli[$i][0]=='*' OR $q2nli[$i][0]=='*' )
	{
		$smstr1[$i][0] = 'BB';
		$avg1='*';//[$i][0]
		$rata1='BB';
	}
	else if( $q1nli[$i][0]=='**' OR $q2nli[$i][0]=='**' )
	{
		$smstr1[$i][0] = 'MB';
		$avg1='**';//[$i][0]
		$rata1='MB';
	}
	else if( $q1nli[$i][0]=='***' OR $q2nli[$i][0]=='***' )
	{
		$smstr1[$i][0] = 'BSH';
		$avg1='***';//[$i][0]
		$rata1='BSH';
	}
	else if( $q1nli[$i][0]=='****' OR $q2nli[$i][0]=='****' )
	{
		$smstr1[$i][0] = 'BSB';
		$avg1='****';//[$i][0]
		$rata1='BSB';
	}
	
	//smstr 2
	if( $q3nli[$i][0]=='*' OR $q4nli[$i][0]=='*' )
	{
		$smstr2[$i][0] = 'BB';
		$avg2='*';//[$i][0]
		$rata2='BB';
	}
	else if( $q3nli[$i][0]=='**' OR $q4nli[$i][0]=='**' )
	{
		$smstr2[$i][0] = 'MB';
		$avg2='**';//[$i][0]
		$rata2='MB';
	}
	else if( $q3nli[$i][0]=='***' OR $q4nli[$i][0]=='***' )
	{
		$smstr2[$i][0] = 'BSH';
		$avg2='***';//[$i][0]
		$rata2='BSH';
	}
	else if( $q3nli[$i][0]=='****' OR $q4nli[$i][0]=='****' )
	{
		$smstr2[$i][0] = 'BSB';
		$avg2='****';//[$i][0]
		$rata2='BSB';
	}
	
	$i++;
	$j++;
}

//nli2
$qLGKG2	="	SELECT 		 t_learnrcd_tk_akr.*
			FROM 		 t_learnrcd_tk_akr
			WHERE		 t_learnrcd_tk_akr.nis='$kdekls' AND ( t_learnrcd_tk_akr.kdekls='KG-A1' OR t_learnrcd_tk_akr.kdekls='KG-A2' ) AND t_learnrcd_tk_akr.kdeplj='AKG-B' ";
$rLGKG2=mysql_query($qLGKG2) or die('Query gagal40');
$dLGKG2 =mysql_fetch_array($rLGKG2);
$i=1;
$j=1;
while($i<26)
{
	$q1nliB[$i][0]=$dLGKG2['hw'.'1'.'1'."$j"];
	$q2nliB[$i][0]=$dLGKG2['hw'.'1'.'2'."$j"];
	
	$q3nliB[$i][0]=$dLGKG2['hw'.'2'.'1'."$j"];
	$q4nliB[$i][0]=$dLGKG2['hw'.'2'.'2'."$j"];
	
	//smstr 1
	if( $q1nliB[$i][0]=='*' OR $q2nliB[$i][0]=='*' )
	{
		$smstr1B[$i][0] = 'BB';
		$avg1B='*';//[$i][0]
		$rata1B='BB';
	}
	else if( $q1nliB[$i][0]=='**' OR $q2nliB[$i][0]=='**' )
	{
		$smstr1B[$i][0] = 'MB';
		$avg1B='**';//[$i][0]
		$rata1B='MB';
	}
	else if( $q1nliB[$i][0]=='***' OR $q2nliB[$i][0]=='***' )
	{
		$smstr1B[$i][0] = 'BSH';
		$avg1B='***';//[$i][0]
		$rata1B='BSH';
	}
	else if( $q1nliB[$i][0]=='****' OR $q2nliB[$i][0]=='****' )
	{
		$smstr1B[$i][0] = 'BSB';
		$avg1B='****';//[$i][0]
		$rata1B='BSB';
	}
	
	//smstr 2
	if( $q3nliB[$i][0]=='*' OR $q4nliB[$i][0]=='*' )
	{
		$smstr2B[$i][0] = 'BB';
		$avg2B='*';//[$i][0]
		$rata2B='BB';
	}
	else if( $q3nliB[$i][0]=='**' OR $q4nliB[$i][0]=='**' )
	{
		$smstr2B[$i][0] = 'MB';
		$avg2B='**';//[$i][0]
		$rata2B='MB';
	}
	else if( $q3nliB[$i][0]=='***' OR $q4nliB[$i][0]=='***' )
	{
		$smstr2B[$i][0] = 'BSH';
		$avg2B='***';//[$i][0]
		$rata2B='BSH';
	}
	else if( $q3nliB[$i][0]=='****' OR $q4nliB[$i][0]=='****' )
	{
		$smstr2B[$i][0] = 'BSB';
		$avg2B='****';//[$i][0]
		$rata2B='BSB';
	}
	
	$i++;
	$j++;
}

//nli3
$qLGKG3	="	SELECT 		 t_learnrcd_tk_akr.*
			FROM 		 t_learnrcd_tk_akr
			WHERE		 t_learnrcd_tk_akr.nis='$kdekls' AND ( t_learnrcd_tk_akr.kdekls='KG-A1' OR t_learnrcd_tk_akr.kdekls='KG-A2' ) AND t_learnrcd_tk_akr.kdeplj='AKG-C' ";
$rLGKG3=mysql_query($qLGKG3) or die('Query gagal40');
$dLGKG3 =mysql_fetch_array($rLGKG3);
$i=1;
$j=1;
while($i<26)
{
	$q1nliC[$i][0]=$dLGKG3['hw'.'1'.'1'."$j"];
	$q2nliC[$i][0]=$dLGKG3['hw'.'1'.'2'."$j"];
	
	$q3nliC[$i][0]=$dLGKG3['hw'.'2'.'1'."$j"];
	$q4nliC[$i][0]=$dLGKG3['hw'.'2'.'2'."$j"];
	
	//smstr 1
	if( $q1nliC[$i][0]=='*' OR $q2nliC[$i][0]=='*' )
	{
		$smstr1C[$i][0] = 'BB';
		$avg1C='*';//[$i][0]
		$rata1C='BB';
	}
	else if( $q1nliC[$i][0]=='**' OR $q2nliC[$i][0]=='**' )
	{
		$smstr1C[$i][0] = 'MB';
		$avg1C='**';//[$i][0]
		$rata1C='MB';
	}
	else if( $q1nliC[$i][0]=='***' OR $q2nliC[$i][0]=='***' )
	{
		$smstr1C[$i][0] = 'BSH';
		$avg1C='***';//[$i][0]
		$rata1C='BSH';
	}
	else if( $q1nliC[$i][0]=='****' OR $q2nliC[$i][0]=='****' )
	{
		$smstr1C[$i][0] = 'BSB';
		$avg1C='****';//[$i][0]
		$rata1C='BSB';
	}
	
	//smstr 2
	if( $q3nliC[$i][0]=='*' OR $q4nliC[$i][0]=='*' )
	{
		$smstr2C[$i][0] = 'BB';
		$avg2C='*';//[$i][0]
		$rata2C='BB';
	}
	else if( $q3nliC[$i][0]=='**' OR $q4nliC[$i][0]=='**' )
	{
		$smstr2C[$i][0] = 'MB';
		$avg2C='**';//[$i][0]
		$rata2C='MB';
	}
	else if( $q3nliC[$i][0]=='***' OR $q4nliC[$i][0]=='***' )
	{
		$smstr2C[$i][0] = 'BSH';
		$avg2C='***';//[$i][0]
		$rata2C='BSH';
	}
	else if( $q3nliC[$i][0]=='****' OR $q4nliC[$i][0]=='****' )
	{
		$smstr2C[$i][0] = 'BSB';
		$avg2C='****';//[$i][0]
		$rata2C='BSB';
	}
	
	$i++;
	$j++;
}

//nli4
$qLGKG4	="	SELECT 		 t_learnrcd_tk_akr.*
			FROM 		 t_learnrcd_tk_akr
			WHERE		 t_learnrcd_tk_akr.nis='$kdekls' AND ( t_learnrcd_tk_akr.kdekls='KG-A1' OR t_learnrcd_tk_akr.kdekls='KG-A2' ) AND t_learnrcd_tk_akr.kdeplj='AKG-D' ";
$rLGKG4=mysql_query($qLGKG4) or die('Query gagal40');
$dLGKG4 =mysql_fetch_array($rLGKG4);
$i=1;
$j=1;
while($i<26)
{
	$q1nliD[$i][0]=$dLGKG4['hw'.'1'.'1'."$j"];
	$q2nliD[$i][0]=$dLGKG4['hw'.'1'.'2'."$j"];
	
	$q3nliD[$i][0]=$dLGKG4['hw'.'2'.'1'."$j"];
	$q4nliD[$i][0]=$dLGKG4['hw'.'2'.'2'."$j"];
	
	//smstr 1
	if( $q1nliD[$i][0]=='*' OR $q2nliD[$i][0]=='*' )
	{
		$smstr1D[$i][0] = 'BB';
		$avg1D='*';//[$i][0]
		$rata1D='BB';
	}
	else if( $q1nliD[$i][0]=='**' OR $q2nliD[$i][0]=='**' )
	{
		$smstr1D[$i][0] = 'MB';
		$avg1D='**';//[$i][0]
		$rata1D='MB';
	}
	else if( $q1nliD[$i][0]=='***' OR $q2nliD[$i][0]=='***' )
	{
		$smstr1D[$i][0] = 'BSH';
		$avg1D='***';//[$i][0]
		$rata1D='BSH';
	}
	else if( $q1nliD[$i][0]=='****' OR $q2nliD[$i][0]=='****' )
	{
		$smstr1D[$i][0] = 'BSB';
		$avg1D='****';//[$i][0]
		$rata1D='BSB';
	}
	
	//smstr 2
	if( $q3nliD[$i][0]=='*' OR $q4nliD[$i][0]=='*' )
	{
		$smstr2D[$i][0] = 'BB';
		$avg2D='*';//[$i][0]
		$rata2D='BB';
	}
	else if( $q3nliD[$i][0]=='**' OR $q4nliD[$i][0]=='**' )
	{
		$smstr2D[$i][0] = 'MB';
		$avg2D='**';//[$i][0]
		$rata2D='MB';
	}
	else if( $q3nliD[$i][0]=='***' OR $q4nliD[$i][0]=='***' )
	{
		$smstr2D[$i][0] = 'BSH';
		$avg2D='***';//[$i][0]
		$rata2D='BSH';
	}
	else if( $q3nliD[$i][0]=='****' OR $q4nliD[$i][0]=='****' )
	{
		$smstr2D[$i][0] = 'BSB';
		$avg2D='****';//[$i][0]
		$rata2D='BSB';
	}
	
	$i++;
	$j++;
}

//nli5
$qLGKG5	="	SELECT 		 t_learnrcd_tk_akr.*
			FROM 		 t_learnrcd_tk_akr
			WHERE		 t_learnrcd_tk_akr.nis='$kdekls' AND ( t_learnrcd_tk_akr.kdekls='KG-A1' OR t_learnrcd_tk_akr.kdekls='KG-A2' ) AND t_learnrcd_tk_akr.kdeplj='AKG-E' ";
$rLGKG5=mysql_query($qLGKG5) or die('Query gagal40');
$dLGKG5 =mysql_fetch_array($rLGKG5);
$i=1;
$j=1;
while($i<26)
{
	$q1nliE[$i][0]=$dLGKG5['hw'.'1'.'1'."$j"];
	$q2nliE[$i][0]=$dLGKG5['hw'.'1'.'2'."$j"];
	
	$q3nliE[$i][0]=$dLGKG5['hw'.'2'.'1'."$j"];
	$q4nliE[$i][0]=$dLGKG5['hw'.'2'.'2'."$j"];
	
	//smstr 1
	if( $q1nliE[$i][0]=='*' OR $q2nliE[$i][0]=='*' )
	{
		$smstr1E[$i][0] = 'BB';
		$avg1E='*';//[$i][0]
		$rata1E='BB';
	}
	else if( $q1nliE[$i][0]=='**' OR $q2nliE[$i][0]=='**' )
	{
		$smstr1E[$i][0] = 'MB';
		$avg1E='**';//[$i][0]
		$rata1E='MB';
	}
	else if( $q1nliE[$i][0]=='***' OR $q2nliE[$i][0]=='***' )
	{
		$smstr1E[$i][0] = 'BSH';
		$avg1E='***';//[$i][0]
		$rata1E='BSH';
	}
	else if( $q1nliE[$i][0]=='****' OR $q2nliE[$i][0]=='****' )
	{
		$smstr1E[$i][0] = 'BSB';
		$avg1E='****';//[$i][0]
		$rata1E='BSB';
	}
	
	//smstr 2
	if( $q3nliE[$i][0]=='*' OR $q4nliE[$i][0]=='*' )
	{
		$smstr2E[$i][0] = 'BB';
		$avg2E='*';//[$i][0]
		$rata2E='BB';
	}
	else if( $q3nliE[$i][0]=='**' OR $q4nliE[$i][0]=='**' )
	{
		$smstr2E[$i][0] = 'MB';
		$avg2E='**';//[$i][0]
		$rata2E='MB';
	}
	else if( $q3nliE[$i][0]=='***' OR $q4nliE[$i][0]=='***' )
	{
		$smstr2E[$i][0] = 'BSH';
		$avg2E='***';//[$i][0]
		$rata2E='BSH';
	}
	else if( $q3nliE[$i][0]=='****' OR $q4nliE[$i][0]=='****' )
	{
		$smstr2E[$i][0] = 'BSB';
		$avg2E='****';//[$i][0]
		$rata2E='BSB';
	}
	
	$i++;
	$j++;
}

//nli6
$qLGKG6	="	SELECT 		 t_learnrcd_tk_akr.*
			FROM 		 t_learnrcd_tk_akr
			WHERE		 t_learnrcd_tk_akr.nis='$kdekls' AND ( t_learnrcd_tk_akr.kdekls='KG-A1' OR t_learnrcd_tk_akr.kdekls='KG-A2' ) AND t_learnrcd_tk_akr.kdeplj='AKG-F' ";
$rLGKG6=mysql_query($qLGKG6) or die('Query gagal40');
$dLGKG6 =mysql_fetch_array($rLGKG6);
$i=1;
$j=1;
while($i<26)
{
	$q1nliF[$i][0]=$dLGKG6['hw'.'1'.'1'."$j"];
	$q2nliF[$i][0]=$dLGKG6['hw'.'1'.'2'."$j"];
	
	$q3nliF[$i][0]=$dLGKG6['hw'.'2'.'1'."$j"];
	$q4nliF[$i][0]=$dLGKG6['hw'.'2'.'2'."$j"];
	
	//smstr 1
	if( $q1nliF[$i][0]=='*' OR $q2nliF[$i][0]=='*' )
	{
		$smstr1F[$i][0] = 'BB';
		$avg1F='*';//[$i][0]
		$rata1F='BB';
	}
	else if( $q1nliF[$i][0]=='**' OR $q2nliF[$i][0]=='**' )
	{
		$smstr1F[$i][0] = 'MB';
		$avg1F='**';//[$i][0]
		$rata1F='MB';
	}
	else if( $q1nliF[$i][0]=='***' OR $q2nliF[$i][0]=='***' )
	{
		$smstr1F[$i][0] = 'BSH';
		$avg1F='***';//[$i][0]
		$rata1F='BSH';
	}
	else if( $q1nliF[$i][0]=='****' OR $q2nliF[$i][0]=='****' )
	{
		$smstr1F[$i][0] = 'BSB';
		$avg1F='****';//[$i][0]
		$rata1F='BSB';
	}
	
	//smstr 2
	if( $q3nliF[$i][0]=='*' OR $q4nliF[$i][0]=='*' )
	{
		$smstr2F[$i][0] = 'BB';
		$avg2F='*';//[$i][0]
		$rata2F='BB';
	}
	else if( $q3nliF[$i][0]=='**' OR $q4nliF[$i][0]=='**' )
	{
		$smstr2F[$i][0] = 'MB';
		$avg2F='**';//[$i][0]
		$rata2F='MB';
	}
	else if( $q3nliF[$i][0]=='***' OR $q4nliF[$i][0]=='***' )
	{
		$smstr2F[$i][0] = 'BSH';
		$avg2F='***';//[$i][0]
		$rata2F='BSH';
	}
	else if( $q3nliF[$i][0]=='****' OR $q4nliF[$i][0]=='****' )
	{
		$smstr2F[$i][0] = 'BSB';
		$avg2F='****';//[$i][0]
		$rata2F='BSB';
	}
	
	$i++;
	$j++;
}



	$qABS	="	SELECT 		t_hdrkmnps_pgtk1_akr.*
				FROM 		t_hdrkmnps_pgtk1_akr
				WHERE		t_hdrkmnps_pgtk1_akr.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	$q1KMN=$dABS['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN=$dABS['kmn'.'1'.'2']; // q2
	$q3KMN=$dABS['kmn'.'2'.'1']; // q3 kmn	$sms.$midtrm
	$q4KMN=$dABS['kmn'.'2'.'2']; // q4
	
	$qABS2	="	SELECT 		t_hdrkmnps_pgtk2_akr.*
				FROM 		t_hdrkmnps_pgtk2_akr
				WHERE		t_hdrkmnps_pgtk2_akr.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS2=mysql_query($qABS2) or die('Query gagal40');
	$dABS2=mysql_fetch_array($rABS2);
	$q1KMN2=$dABS2['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN2=$dABS2['kmn'.'1'.'2']; // q2
	$q3KMN2=$dABS2['kmn'.'2'.'1']; // q3 kmn	$sms.$midtrm
	$q4KMN2=$dABS2['kmn'.'2'.'2']; // q4
	
	$qABS3	="	SELECT 		t_hdrkmnps_pgtk3_akr.*
				FROM 		t_hdrkmnps_pgtk3_akr
				WHERE		t_hdrkmnps_pgtk3_akr.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS3=mysql_query($qABS3) or die('Query gagal40');
	$dABS3=mysql_fetch_array($rABS3);
	$q1KMN3=$dABS3['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN3=$dABS3['kmn'.'1'.'2']; // q2
	$q3KMN3=$dABS3['kmn'.'2'.'1']; // q3 kmn	$sms.$midtrm
	$q4KMN3=$dABS3['kmn'.'2'.'2']; // q4
	
	$qABS4	="	SELECT 		t_hdrkmnps_pgtk4_akr.*
				FROM 		t_hdrkmnps_pgtk4_akr
				WHERE		t_hdrkmnps_pgtk4_akr.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS4=mysql_query($qABS4) or die('Query gagal40');
	$dABS4=mysql_fetch_array($rABS4);
	$q1KMN4=$dABS4['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN4=$dABS4['kmn'.'1'.'2']; // q2
	$q3KMN4=$dABS4['kmn'.'2'.'1']; // q3 kmn	$sms.$midtrm
	$q4KMN4=$dABS4['kmn'.'2'.'2']; // q4
	
	$qABS5	="	SELECT 		t_hdrkmnps_pgtk5_akr.*
				FROM 		t_hdrkmnps_pgtk5_akr
				WHERE		t_hdrkmnps_pgtk5_akr.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS5=mysql_query($qABS5) or die('Query gagal40');
	$dABS5=mysql_fetch_array($rABS5);
	$q1KMN5=$dABS5['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN5=$dABS5['kmn'.'1'.'2']; // q2
	$q3KMN5=$dABS5['kmn'.'2'.'1']; // q3 kmn	$sms.$midtrm
	$q4KMN5=$dABS5['kmn'.'2'.'2']; // q4
	
	$qABS6	="	SELECT 		t_hdrkmnps_pgtk6_akr.*
				FROM 		t_hdrkmnps_pgtk6_akr
				WHERE		t_hdrkmnps_pgtk6_akr.nis='$kdekls' "; // nis // menghasilka nilai kehadiran
	$rABS6=mysql_query($qABS6) or die('Query gagal40');
	$dABS6 =mysql_fetch_array($rABS6);
	$q1KMN6=$dABS6['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN6=$dABS6['kmn'.'1'.'2']; // q2
	$q3KMN6=$dABS6['kmn'.'2'.'1']; // q3 kmn	$sms.$midtrm
	$q4KMN6=$dABS6['kmn'.'2'.'2']; // q4











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
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "LAPORAN PERKEMBANGAN SISWA", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "SEMESTER I", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "TAHUN PELAJARAN 2017 - 2018", '', 0, C, true);
	
	$pdf->Ln(1.2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "NAMA                  : ".$nmassw, '', 0, L, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "KELOMPOK        : TK A", '', 0, L, true);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 0.6, "Narasi Kemampuan", 'LRT', 0, C, true);// Anak
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	$pdf->Cell(5.7, 0.6, "Anak Didik", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "I.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 1, "NILAI - NILAI AGAMA DAN MORAL", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LRT', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal Agama yang dianut", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Sikap doa yang baik", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Berdoa sebelum/sesudah kegiatan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Berbuat baik dan sopan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengucapkan salam dan membalas salam", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "6.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengucapkan kutipan ayat alkitab", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "7.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal dan menyayangi ciptaan Tuhan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(9.7, 1, "RATA - RATA", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "II.", 'LRTB', 0, C, true);
	$pdf->Cell(20.2, 1, "SOSIAL EMOSIONAL DAN KEMANDIRIAN", 'LRTB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Sikap Mandiri", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengendalikan Emosi", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menunjukkan ras percaya diri", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mentaati peraturan dan disiplin", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Memiliki tanggung jawab", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "6.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mau berbagi dan menolong teman", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "7.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menjaga diri sendiri dan orang lain", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(0.5, 1, "8.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menghargai / menghormati orang lain", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12.5);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(9.7, 1, "RATA - RATA", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	
	
	//awal halaman2
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "LAPORAN PERKEMBANGAN SISWA", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "TK SAINT JOHN'S SCHOOL", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "SEMESTER I", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "TAHUN PELAJARAN 2017 - 2018", '', 0, C, true);
	
	$pdf->Ln(1.2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "NAMA                  : ".$nmassw, '', 0, L, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "KELOMPOK        : TK A", '', 0, L, true);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 1.2, "NARASI", 'LRT', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	//$pdf->Cell(5.7, 0.6, "Anak Didik", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "I.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 1, "NILAI - NILAI MORAL DAN AGAMA", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LRT', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Sikap doa yang baik", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nli[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1[1][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN,0,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN,30,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Berdoa sebelum/sesudah melakukan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nli[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1[2][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN,60,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "kegiatan (Bapa Kami dan Salam Maria)", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN,90,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengucap syair dan menyanyi lagu - lagu", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nli[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1[3][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN,120,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "keagamaan", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN,150,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal dan menyayangi ciptaan Tuhan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nli[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1[4][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN,180,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN,210,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Berbuat baik dan sopan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nli[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1[5][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN,240,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN,270,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRB', 0, C, true);
	$pdf->Cell(0.5, 1, "6.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengucap salam, terimakasih", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nli[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1[6][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN,300,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN,330,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "II.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 1, "SOSIAL EMOSIONAL DAN KEMANDIRIAN", 'LRTB', 0, L, true);//20.2
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LRT', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mandiri dan menunjukkan percaya diri", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliB[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1B[1][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN2,0,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN2,30,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Menaati peraturan dan menirukan kegiatan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliB[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1B[2][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN2,60,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "yang dilakukan orang dewasa", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN2,90,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengendalikan emosi", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliB[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1B[3][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN2,120,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN2,150,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menghargai orang lain", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliB[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1B[4][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN2,180,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN2,210,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRB', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mau berbagi, membantu teman dan bekerja", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliB[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1B[5][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN2,240,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "sama", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN2,270,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 1, $avg1B, 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $rata1B, 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	
	
	//awal halaman 3
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "NAMA                  : ".$nmassw, '', 0, L, true);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 1.2, "NARASI", 'LRT', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "IV.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "PENGEMBANGAN KOGNITIF", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "A.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "PENGETAHUAN UMUM - SAINS", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal benda berdasarkan fungsi", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[1][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,0,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,30,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Percobaan sederhana", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[2][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,60,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,90,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengenal konsep sederhana (waktu, hujan,", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[3][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,120,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "gelap, terang, dsb)", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,150,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal sebab akibat", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[4][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,180,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,210,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengenal konsep sederhana dalam", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[5][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,240,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "kehidupan sehari-hari", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,270,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "B.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "KONSEP BENTUK, WARNA , UKURAN, DAN POLA", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,300,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal pola", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[6][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,330,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,360,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengurutkan benda berdasarkan besar -", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[7][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,390,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "kecil, tebal - tipis, panjang - pendek", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,420,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengklasifikasikan benda berdasarkan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[8][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,450,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "bentuk dan warna", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,480,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengklasifikasikan benda ke dalam", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[9][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[9][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,510,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "kelompok yang sama / sejenis", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,540,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "C.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "KONSEP BILANGAN - LAMBANG BILANGAN", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,570,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal konsep banyak - sedikit", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[10][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[10][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,600,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,630,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal lambang bilangan 1 - 10", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[11][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[11][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,660,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,690,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menebalkan lambang bilangan 1 - 10", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[12][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[12][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,720,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,750,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal konsep bilangan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliD[13][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1D[13][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,780,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN4,810,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 1, $avg1D, 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $rata1D, 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	
	
	//awal halaman 4
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "NAMA                  : ".$nmassw, '', 0, L, true);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 1.2, "NARASI", 'LRT', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "III.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "PENGEMBANGAN BAHASA", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "A.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "MENERIMA BAHASA", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mendengarkan orang lain berbicara", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliC[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1C[1][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,0,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,30,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal perbendaharaan kata", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliC[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1C[2][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,60,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,90,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Melakukan perintah sederhana", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliC[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1C[3][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,120,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,150,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "B.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "MENGUNGKAPKAN BAHASA", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,180,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mulai menceritakan pengalaman dengan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliC[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1C[4][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,210,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "kalimat sederhana", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,240,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Menirukan kalimat sederhana dan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliC[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1C[5][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,270,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "menyebutkan kata - kata yang dikenal", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,300,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengucapkan syair", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliC[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1C[6][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,330,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,360,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengutarakan pendapat kepada orang lain", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliC[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1C[7][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,390,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,420,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "C.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "KEAKSARAAN", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,450,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal huruf a i u e o", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliC[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1C[8][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,480,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,510,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menebalkan huruf a i u e o", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliC[9][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1C[9][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,540,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,570,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal simbol - simbol", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliC[10][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1C[10][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,600,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,630,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengenal suara hewan / benda yang ada di", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliC[11][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1C[11][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,660,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "sekitarnya", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN3,690,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 1, $avg1C, 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $rata1C, 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1.7	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Penjelasan                  :", '', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(4, 1, "SIMBOL", 'LRTB', 0, C, true);
	$pdf->Cell(4.7, 1, "KLASIFIKASI", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "KETERANGAN", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "1.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " *", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "2.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " **", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "3.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " ***", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "4.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " ****", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	
	
	//awal halaman 5
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "NAMA                  : ".$nmassw, '', 0, L, true);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 1.2, "NARASI", 'LRT', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "V.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "PENGEMBANGAN BAHASA", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "A.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "MOTORIK KASAR", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menirukan gerakan, senam", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliE[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1E[1][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,0,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,30,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Melompat, berlari, merangkak", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliE[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1E[2][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,60,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,90,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Melempar dan menangkap bola", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliE[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1E[3][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,120,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,150,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Bermain di luar kelas", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliE[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1E[4][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,180,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,210,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Berjalan bervariasi", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliE[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1E[5][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,240,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,270,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "B.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "MOTORIK HALUS", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,300,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Membuat aneka garis", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliE[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1E[6][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,330,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,360,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Melipat, menjahit dan menempel", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliE[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1E[7][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,390,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,420,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Membuat berbagai bentuk menggunakan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliE[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1E[8][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,450,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "lego atau plastisin", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN5,480,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 1, $avg1E, 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $rata1E, 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "VI.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "PENGEMBANGAN SENI", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Menyanyi dan memainkan alat musik", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliF[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1F[1][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN6,0,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "sederhana (perkusi)", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN6,30,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menari", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliF[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1F[2][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN6,60,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN6,90,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Menggambar dan mewarnai bentuk", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliF[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1F[3][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN6,120,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "gambar sederhana", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN6,150,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mencap", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliF[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1F[4][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN6,180,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN6,210,30), 'LR', 0, J, true);
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mozaik", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q2nliF[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr1F[5][0], 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN6,240,30), 'LR', 0, J, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(5.7, 0.5, substr($q2KMN6,270,30), 'LR', 0, J, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 1, $avg1F, 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $rata1F, 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1.7	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Penjelasan                  :", '', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(4, 1, "SIMBOL", 'LRTB', 0, C, true);
	$pdf->Cell(4.7, 1, "KLASIFIKASI", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "KETERANGAN", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "1.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " *", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "2.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " **", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "3.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " ***", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "4.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " ****", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	
	
	//..awal halaman 6
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Perkembangan Peserta Didik", '', 0, C, true);
	
	$pdf->Ln(1.2);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "NAMA                  : ".$nmassw, '', 0, L, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "KELOMPOK        : TK A", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "ASPEK", 'LRTB', 0, C, true);
	$pdf->Cell(3, 1, "KRITERIA", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "TANGGAL PEMERIKSAAN", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Mata / Penglihatan", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Telinga / Pendengaran", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Mulut", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Hidung / Penciuman", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Gigi", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "6.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Kulit", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "7.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Anggota Badan", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8, 1, "Keterangan", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Tinggi Badan", 'LRTB', 0, C, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);//tinggi Badan
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Berat Badan", 'LRTB', 0, C, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);//Berat Badan
	
	$pdf->Ln(1.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "Ketidakhadiran di sekolah karena :", '', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Sakit", '', 0, L, true);
	$pdf->Cell(3, 0.5, " :      hari", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Ijin", '', 0, L, true);
	$pdf->Cell(3, 0.5, " :      hari", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Tanpa Keterangan", '', 0, L, true);
	$pdf->SetFont('Arial','U',11);
	$pdf->Cell(3, 0.5, " :      hari", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Jumlah", '', 0, L, true);
	$pdf->Cell(3, 0.5, " :      hari", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Ln();																		$pdf->Cell( 12.5	,0.5,'','',0,C,false);		$pdf->Cell(5, 0.5, "Jakarta, 2018", '', 0, L, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Orang Tua Siswa", '', 0, L, true);							$pdf->Cell( 3.45	,0.5,'','',0,C,false);		$pdf->Cell(5, 0.5, "Guru Kelas ", '', 0, L, true);//KB 2
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "............................", '', 0, L, true);				$pdf->Cell( 3.45	,0.5,'','',0,C,false);		$pdf->Cell(5, 0.5, "(                         )", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(9, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Mengetahui,", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(7, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Kepala KB - TK Saint John's School", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(7.75, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Glorya Lumbantoruan, S.Pd", '', 0, L, true);	
	
	
	
	// awal halaman 7
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "LAPORAN PERKEMBANGAN SISWA TK SAINT JOHN'S SCHOOL", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "SEMESTER II", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "TAHUN PELAJARAN 2017 - 2018", '', 0, C, true);
	
	$pdf->Ln(1.2);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Nama                  : ".$nmassw, '', 0, L, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Kelompok          : TK A", '', 0, L, true);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 1.2, "NARASI", 'LRT', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	//$pdf->Cell(5.7, 0.6, "Anak Didik", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "I.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 1, "NILAI - NILAI MORAL DAN AGAMA", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LRT', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal Agama yang dianut", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Sikap doa yang baik", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Berdoa sebelum/sesudah kegiatan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Berbuat baik dan sopan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengucapkan salam dan membalas salam", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRB', 0, C, true);
	$pdf->Cell(0.5, 1, "6.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengucapkan kutipan ayat alkitab", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRB', 0, C, true);
	$pdf->Cell(0.5, 1, "7.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal dan menyayangi ciptaan Tuhan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'RTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "II.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 1, "SOSIAL EMOSIONAL DAN KEMANDIRIAN", 'LRTB', 0, L, true);//20.2
	//$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LRT', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Sikap mandiri", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengendalikan emosi", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menunjukkan rasa percaya diri", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mentaati peraturan dan disiplin", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Memiliki tanggung jawab", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "6.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mau berbagi dan menolong teman", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "7.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menjaga diri sendiri dan orang lain", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12.5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "8.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menghargai / menghormati orang lain", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'RTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	
	
	// awal halaman 8
	
	
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "LAPORAN PERKEMBANGAN SISWA", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "TK SAINT JOHN'S SCHOOL", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "SEMESTER II", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "TAHUN PELAJARAN 2017 - 2018", '', 0, C, true);
	
	$pdf->Ln(1.2);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "NAMA                  : ".$nmassw, '', 0, L, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "KELOMPOK        : TK A", '', 0, L, true);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 1.2, "NARASI", 'LRT', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "I.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "NILAI-NILAI MORAL DAN AGAMA", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Sikap doa yang baik", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nli[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Berdoa sebelum/sesudah kegiatan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nli[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "(Bapa Kami dan Salam Maria)", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengucap syair dan menyanyi lagu-", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nli[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "lagu keagamaan", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
		
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal dan menyayangi ciptaan Tuhan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nli[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Berbuat baik dan sopan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nli[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "6.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengucap salam, terimakasih", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nli[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "II.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "SOSIAL EMOSIONAL DAN KEMANDIRIAN", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mandiri dan menunjukkan percaya diri", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliB[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2B[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Menaati peraturan dan menirukan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliB[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2B[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "kegiatan yang dilakukan orang dewasa", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengendalikan emosi", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliB[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2B[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menghargai orang lain", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliB[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2B[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mau berbagi, membantu teman dan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliB[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2B[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "bekerja sama", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->Ln();
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(4, 1, "SIMBOL", 'LRTB', 0, C, true);
	$pdf->Cell(4.7, 1, "KLASIFIKASI", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "KETERANGAN", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "1.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " *", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "2.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " **", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "3.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " ***", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "4.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " ****", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	
	
	//awal halaman 9
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "LAPORAN PERKEMBANGAN SISWA", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "TK SAINT JOHN'S SCHOOL", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "SEMESTER II", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "TAHUN PELAJARAN 2017 - 2018", '', 0, C, true);
	
	$pdf->Ln(1.2);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "NAMA                  : ".$nmassw, '', 0, L, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "KELOMPOK        : TK A", '', 0, L, true);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 1.2, "NARASI", 'LRT', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "IV.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "PENGEMBANGAN KOGNITIF", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "A.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "PENGETAHUAN UMUM-SAINS", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal benda berdasarkan fungsi", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Percobaan sederhana", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengenal konsep sederhana (waktu, hujan, ", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "gelap, terang, dsb", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
		
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal sebab akibat", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengenal konsep sederhana dalam ", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "kehidupan sehari-hari", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "B.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "KONSEP BENTUK, WARNA, UKURAN, DAN POLA", 'LRTB', 0, L, true);
	//$pdf->Cell(8.7, 0.5, "KONSEP BENTUK, WARNA, UKURAN, DAN POLA", 'LRTB', 0, L, true);
	//$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	//$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal pola", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengurutkan benda berdasarkan besar-kecil, ", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "tebal - tipis, panjang - pendek", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengklasifikasikan benda berdasarkan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "bentuk dan warna", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengklasifikasikan benda ke dalam", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[9][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[9][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "kelompok yang sama / sejenis", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "C.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "KONSEP BILANGAN - LAMBANG BILANGAN", 'LRTB', 0, L, true);
	//$pdf->Cell(8.7, 0.5, "KONSEP BENTUK, WARNA, UKURAN, DAN POLA", 'LRTB', 0, L, true);
	//$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	//$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal konsep banyak - sedikit", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[10][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[10][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal lambang bilangan 1 - 10", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[11][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[11][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menebalkan lambang bilangan 1 - 10", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[12][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[12][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal konsep bilangan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliD[13][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2D[13][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1.7	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Penjelasan                  :", '', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(4, 1, "SIMBOL", 'LRTB', 0, C, true);
	$pdf->Cell(4.7, 1, "KLASIFIKASI", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "KETERANGAN", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "1.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " *", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "2.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " **", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "3.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " ***", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "4.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " ****", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	
	
	//awal halaman 10
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "LAPORAN PERKEMBANGAN SISWA", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "TK SAINT JOHN'S SCHOOL", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "SEMESTER II", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "TAHUN PELAJARAN 2017 - 2018", '', 0, C, true);
	
	$pdf->Ln(1.2);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "NAMA                  : ".$nmassw, '', 0, L, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "KELOMPOK        : TK A", '', 0, L, true);
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 1.2, "NARASI", 'LRT', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "III.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "PENGEMBANGAN BAHASA", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "A.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "MENERIMA BAHASA", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mendengarkan orang lain berbicara", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliC[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2C[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal perbendaharaan kata", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliC[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2C[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Melakukan perintah sederhana", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliC[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2C[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
		
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "B.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "MENGUNGKAPKAN BAHASA", 'LRTB', 0, L, true);
	//$pdf->Cell(8.7, 0.5, "KONSEP BENTUK, WARNA, UKURAN, DAN POLA", 'LRTB', 0, L, true);
	//$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	//$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mulai menceritakan pengalaman dengan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliC[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2C[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "kalimat sederhana", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Menirukan kalimat sederhana dan  ", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliC[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2C[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "menyebutkan kata-kata yang dikenal", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengucapkan syair", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliC[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2C[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengutarakan pendapat kepada orang lain", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliC[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2C[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Bertanya dan menjawab pertanyaan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliC[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2C[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "C.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "KEAKSARAAN", 'LRTB', 0, L, true);
	//$pdf->Cell(8.7, 0.5, "KONSEP BENTUK, WARNA, UKURAN, DAN POLA", 'LRTB', 0, L, true);
	//$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	//$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal huruf a i u e o", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliC[9][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2C[9][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menebalkan  huruf a i u e o", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliC[10][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2C[10][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal simbol - simbol", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliC[11][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2C[11][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengenal suara hewan / benda yang ada", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliC[12][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2C[12][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "di sekitarnya", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
		
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1.7	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Penjelasan                  :", '', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(4, 1, "SIMBOL", 'LRTB', 0, C, true);
	$pdf->Cell(4.7, 1, "KLASIFIKASI", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "KETERANGAN", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "1.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " *", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "2.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " **", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "3.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " ***", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "4.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " ****", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	
	
	//awal halaman 11
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 1.2, "NARASI", 'LRT', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "III.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "PENGEMBANGAN BAHASA", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "A.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "MENERIMA BAHASA", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mendengarkan orang lain berbicara", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Melakukan dua perintah sederhana", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Memahami cerita", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal perbendaharaan kata", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
		
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "B.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "MENGUNGKAPKAN BAHASA", 'LRTB', 0, L, true);
	//$pdf->Cell(8.7, 0.5, "KONSEP BENTUK, WARNA, UKURAN, DAN POLA", 'LRTB', 0, L, true);
	//$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	//$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LRT', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menirukan kalimat sederhana", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Bertanya / menjawab pertanyaan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengucapkan syair", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengutarakan pendapat kepada orang lain", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Menceritakan pengalaman dan cerita yang", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "didengar", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "C.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "KEAKSARAAN", 'LRTB', 0, L, true);
	//$pdf->Cell(8.7, 0.5, "KONSEP BENTUK, WARNA, UKURAN, DAN POLA", 'LRTB', 0, L, true);
	//$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	//$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LRT', 0, C, true);
	
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal huruf dan kata", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Menyebutkan kata - kata dari huruf awal", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "yang sama", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Membuat coretan yang bermakna", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "(menulis huruf  /  kata)", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Meniru huruf / tulisan sederhana", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
		
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'RTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(19.7, 0.5, "", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "IV.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "PENGEMBANGAN KOGNITIF", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "A.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "PENGETAHUAN UMUM - SAINS", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal benda berdasarkan fungsi", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal konsep waktu", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengenal konsep sederhana dalam ", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "kehidupan sehari -  hari", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengenal posisi", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "(depan - belakang, atas -  bawah)", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRB', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Percobaan sederhana", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	
	
	//awal halaman 12
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "LAPORAN PERKEMBANGAN SISWA", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "TK SAINT JOHN'S SCHOOL", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "SEMESTER II", '', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 9.3	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "TAHUN PELAJARAN 2017 - 2018", '', 0, C, true);
	
	$pdf->Ln(1.2);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "NAMA                  : ".$nmassw, '', 0, L, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "KELOMPOK        : TK A", '', 0, L, true);
	
	
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 1.2, "NARASI", 'LRT', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "V.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "PENGEMBANGAN BAHASA", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "A.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "MOTORIK KASAR", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menirukan gerakan, senam", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliE[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2E[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Melompat, berlari, merangkak", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliE[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2E[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Melempar dan menangkap bola", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliE[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2E[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Bermain di luar kelas", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliE[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2E[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Berjalan bervariasi", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliE[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2E[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "B.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "MOTORIK HALUS", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Membuat aneka garis", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliE[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2E[6][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Melipat, menjahit dan menempel", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliE[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2E[7][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Membuat berbagai bentuk menggunakan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliE[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2E[8][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "lego atau plastisin", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "VI.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "PENGEMBANGAN SENI", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Menyanyi dan memainkan alat musik", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliF[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2F[1][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "sederhana (perkusi)", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menari", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliF[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2F[2][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Menggambar dan mewarnai bentuk", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliF[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2F[3][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "gambar sederhana", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mencap", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliF[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2F[4][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mozaik", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, $q4nliF[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, $smstr2F[5][0], 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1.7	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Penjelasan                  :", '', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(4, 1, "SIMBOL", 'LRTB', 0, C, true);
	$pdf->Cell(4.7, 1, "KLASIFIKASI", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "KETERANGAN", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "1.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " *", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "2.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " **", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "3.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " ***", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "4.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',28);
	$pdf->Cell(4, 1, " ****", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(4.7, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.3, 1, "", 'LRTB', 0, C, true);
	
	
	
	
	
	
	
	//awal halaman 13
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "B.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "KONSEP BENTUK, WARNA, UKURAN DAN POLA", 'LRTB', 0, L, true);
	//$pdf->Cell(8.7, 0.5, "KONSEP BENTUK, WARNA, UKURAN, DAN POLA", 'LRTB', 0, L, true);
	//$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	//$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LRT', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengklasifikasikan benda berdasarkan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "bentuk dan warna", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal bentuk - bentuk geometri", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Memasangkan benda sesuai pasangannya", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengurutkan benda berdasarkan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "besar - kecil, tebal - tipis.", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	
	
	
	
	
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "C.", 'LRTB', 0, C, true);
	$pdf->Cell(14, 0.5, "KONSEP BILANGAN DAN LAMBANG BILANGAN", 'LRTB', 0, L, true);
	//$pdf->Cell(8.7, 0.5, "KONSEP BENTUK, WARNA, UKURAN, DAN POLA", 'LRTB', 0, L, true);
	//$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	//$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LRT', 0, C, true);
	
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengenal konsep banyak - sedikit,", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "sama - tidak sama", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mengenal konsep bilangan", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Membilang 1 - 20", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mencontoh lambang bilangan 1 - 10", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Mengenal penjumlahan dengan gambar ", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "dan bilangan", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
		
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	//$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'RTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 1.2, "NARASI", 'LRT', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "V.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "PENGEMBANGAN FISIK", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "A.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "MOTORIK KASAR", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menirukan gerakan binatang dan tanaman", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Melompat, berlari, merangkak, dan jalan", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "bervariasi", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "Menangkap dan melempar bola secara", 'LRT', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(8.7, 0.5, "terarah", 'LRB', 0, L, true);
	$pdf->Cell(5.3, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menendang bola secara terarah", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Senam dengan berbagai variasi", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.5, "", 'LRT', 0, C, true);
	$pdf->SetFillColor(255,192,203);
	$pdf->Cell(0.5, 0.5, "B.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 0.5, "MOTORIK HALUS", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 0.5, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 0.5, "", 'LRTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Membuat aneka garis", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Melipat, merobek dan menempel", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menjiplak bentuk", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menjahit - meronce", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	//$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'RTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	
	
	
	
	
	
	//awal halaman 14
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	
	
	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1.2, "KEMAMPUAN DASAR", 'LRTB', 0, C, true);
	$pdf->Cell(2.8, 0.6, "SIMBOL", 'LRT', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KLASIFI", 'LRT', 0, C, true);//	1
	$pdf->Cell(5.7, 1.2, "NARASI", 'LRT', 0, C, true);
	$pdf->Ln(0.6);
	$pdf->Cell( 0.05	,0.6,'','',0,C,false);
	$pdf->Cell(1, 1.2, "", '', 0, C, false);
	$pdf->Cell(8.7, 1.2, "", '', 0, C, false);
	$pdf->Cell(2.8, 0.6, "PRESTASI", 'LRB', 0, C, true);
	$pdf->Cell(2.5, 0.6, "KASI", 'LRB', 0, C, true);
	
	
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 0.75, "VI.", 'LRTB', 0, C, true);
	$pdf->Cell(14.5, 0.75, "PENGEMBANGAN SENI", 'LRTB', 0, L, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(5.7, 0.75, "", 'LRT', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LRT', 0, C, true);
	$pdf->Cell(0.5, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menyanyi", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Mewarnai bentuk gambar sederhana", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menggambar bentuk sederhana", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Bermain alat musik sederhana", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menciptakan bentuk dengan berbagai media", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", 'LR', 0, C, true);
	$pdf->Cell(0.5, 1, "6.", 'LRTB', 0, C, true);
	$pdf->Cell(8.7, 1, "Menari", 'LRTB', 0, L, true);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell(0.5, 1, "", 'LTB', 0, C, true);
	$pdf->Cell(9.2, 1, "RATA - RATA", 'RTB', 0, C, true);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(2.8, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(2.5, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(5.7, 0.5, "", 'LR', 0, C, true);
	$pdf->Ln(0.5);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(0.5, 1, "", '', 0, C, false);
	$pdf->Cell(14.5, 1, "", '', 0, L, false);
	$pdf->Cell(5.7, 0.5, "", 'LRB', 0, C, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 1.7	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "Penjelasan                  :", '', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(4, 1, "SIMBOL", 'LRTB', 0, C, true);
	$pdf->Cell(4.7, 1, "KLASIFIKASI", 'LRTB', 0, C, true);
	$pdf->Cell(7, 1, "KETERANGAN", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "1.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',24);
	$pdf->Cell(4, 1, " ****", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(4.7, 1, "BSB", 'LRTB', 0, C, true);
	$pdf->Cell(7, 1, "Berkembang Sangat Baik ( A )", 'LRTB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "2.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',24);
	$pdf->Cell(4, 1, " ***", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(4.7, 1, "BSH", 'LRTB', 0, C, true);
	$pdf->Cell(7, 1, "Berkembang Sesuai Harapan ( B )", 'LRTB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "3.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',24);
	$pdf->Cell(4, 1, " **", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(4.7, 1, "MB", 'LRTB', 0, C, true);
	$pdf->Cell(7, 1, "Mulai Berkembang ( C )", 'LRTB', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(1, 1, "4.", 'LRTB', 0, C, true);
	$pdf->SetFont('Arial','B',24);
	$pdf->Cell(4, 1, " *", 'LRTB', 0, L, true);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(4.7, 1, "BB", 'LRTB', 0, C, true);
	$pdf->Cell(7, 1, "Belum Berkembang ( K )", 'LRTB', 0, L, true);
	
	
	
	//awal halaman 15
	
	$pdf->Open();
	$pdf->AddPage('P');
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	
	$pdf->Ln(1.2);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "NAMA                  : ".$nmassw, '', 0, L, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.1	,0.6,'','',0,C,false);
	$pdf->Cell(1.2, 0.6, "KELOMPOK        : TK A", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "ASPEK", 'LRTB', 0, C, true);
	$pdf->Cell(3, 1, "KRITERIA", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "TANGGAL PEMERIKSAAN", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Mata / Penglihatan", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Telinga / Pendengaran", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "3.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Mulut", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "4.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Hidung / Penciuman", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "5.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Gigi", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "6.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Kulit", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "7.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Anggota Badan", 'LRTB', 0, L, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);
	$pdf->Cell(6, 1, "", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "NO", 'LRTB', 0, C, true);
	$pdf->Cell(8, 1, "Keterangan", 'LRTB', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "1.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Tinggi Badan", 'LRTB', 0, C, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);//tinggi Badan
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 1, "2.", 'LRTB', 0, C, true);
	$pdf->Cell(5, 1, "Berat Badan", 'LRTB', 0, C, true);
	$pdf->Cell(3, 1, "", 'LRTB', 0, C, true);//Berat Badan
	
	$pdf->Ln(1.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 1.3	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "Ketidakhadiran di sekolah karena :", '', 0, C, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Sakit", '', 0, L, true);
	$pdf->Cell(3, 0.5, " :      hari", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Ijin", '', 0, L, true);
	$pdf->Cell(3, 0.5, " :      hari", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Tanpa Keterangan", '', 0, L, true);
	$pdf->SetFont('Arial','U',11);
	$pdf->Cell(3, 0.5, " :      hari", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Jumlah", '', 0, L, true);
	$pdf->Cell(3, 0.5, " :      hari", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Ln();																		$pdf->Cell( 12.5	,0.5,'','',0,C,false);		$pdf->Cell(5, 0.5, "Jakarta, 2018", '', 0, L, true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Orang Tua Siswa", '', 0, L, true);							$pdf->Cell( 3.45	,0.5,'','',0,C,false);		$pdf->Cell(5, 0.5, "Guru Kelas ", '', 0, L, true);//KB 2
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(4, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "............................", '', 0, L, true);				$pdf->Cell( 3.45	,0.5,'','',0,C,false);		$pdf->Cell(5, 0.5, "(                         )", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(9, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Mengetahui,", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(7, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Kepala KB - TK Saint John's School", '', 0, L, true);
	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell( 0.05	,0.5,'','',0,C,false);
	$pdf->Cell(7.75, 0.5, "", '', 0, C, false);
	$pdf->Cell(5, 0.5, "Glorya Lumbantoruan, S.Pd", '', 0, L, true);	
	
//};
$pdf->Output();
?>