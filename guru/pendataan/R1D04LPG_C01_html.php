<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D01B_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SOAL
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kodekelas	=$_POST['kdekls'];
$nis	=substr($kodekelas,0,3);
$tglctk	=$_POST['tglctk'];

if($tglctk=='')
{
	$tglctk	=date('d F, Y');
}
else
{	
	$tglctk	=strtotime($tglctk);
	$tglctk	=date('d F, Y',$tglctk);
}







//..
$query	="	SELECT 		t_setthn_tk.*
			FROM 		t_setthn_tk
			WHERE		t_setthn_tk.set='Tahun Ajaran'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

	$qABS	="	SELECT 		t_hdrkmnps_pgtk1.*
				FROM 		t_hdrkmnps_pgtk1
				WHERE		t_hdrkmnps_pgtk1.nis='$kodekelas' "; // nis // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	$q1KMN=$dABS['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN=$dABS['kmn'.'1'.'2']; // q2
	$q3KMN=$dABS['kmn'.'2'.'1']; // q3
	$q4KMN=$dABS['kmn'.'2'.'2']; // q4
	
	$qABS2	="	SELECT 		t_hdrkmnps_pgtk2.*
				FROM 		t_hdrkmnps_pgtk2
				WHERE		t_hdrkmnps_pgtk2.nis='$kodekelas' "; // nis // menghasilka nilai kehadiran
	$rABS2=mysql_query($qABS2) or die('Query gagal40');
	$dABS2=mysql_fetch_array($rABS2);
	$q1KMN2=$dABS2['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN2=$dABS2['kmn'.'1'.'2']; // q2
	$q3KMN2=$dABS2['kmn'.'2'.'1']; // q3
	$q4KMN2=$dABS2['kmn'.'2'.'2']; // q4
	
	$qABS3	="	SELECT 		t_hdrkmnps_pgtk3.*
				FROM 		t_hdrkmnps_pgtk3
				WHERE		t_hdrkmnps_pgtk3.nis='$kodekelas' "; // nis // menghasilka nilai kehadiran
	$rABS3=mysql_query($qABS3) or die('Query gagal40');
	$dABS3=mysql_fetch_array($rABS3);
	$q1KMN3=$dABS3['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN3=$dABS3['kmn'.'1'.'2']; // q2
	$q3KMN3=$dABS3['kmn'.'2'.'1']; // q3
	$q4KMN3=$dABS3['kmn'.'2'.'2']; // q4
	
	$qABS4	="	SELECT 		t_hdrkmnps_pgtk4.*
				FROM 		t_hdrkmnps_pgtk4
				WHERE		t_hdrkmnps_pgtk4.nis='$kodekelas' "; // nis // menghasilka nilai kehadiran
	$rABS4=mysql_query($qABS4) or die('Query gagal40');
	$dABS4=mysql_fetch_array($rABS4);
	$q1KMN4=$dABS4['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN4=$dABS4['kmn'.'1'.'2']; // q2
	$q3KMN4=$dABS4['kmn'.'2'.'1']; // q3
	$q4KMN4=$dABS4['kmn'.'2'.'2']; // q4
	
	$qABS5	="	SELECT 		t_hdrkmnps_pgtk5.*
				FROM 		t_hdrkmnps_pgtk5
				WHERE		t_hdrkmnps_pgtk5.nis='$kodekelas' "; // nis // menghasilka nilai kehadiran
	$rABS5=mysql_query($qABS5) or die('Query gagal40');
	$dABS5=mysql_fetch_array($rABS5);
	$q1KMN5=$dABS5['kmn'.'1'.'1']; // q1 kmn	$sms.$midtrm
	$q2KMN5=$dABS5['kmn'.'1'.'2']; // q2
	$q3KMN5=$dABS5['kmn'.'2'.'1']; // q3
	$q4KMN5=$dABS5['kmn'.'2'.'2']; // q4
	
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
				WHERE		 t_learnrcd_tk.nis='$kodekelas' AND ( t_learnrcd_tk.kdekls='PG1' OR t_learnrcd_tk.kdekls='PG2' ) AND t_learnrcd_tk.kdeplj='PG-A' ";
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
		
		
		
		if( $q1nli[$i][0]=='v' OR $q1nli[$i][0]=='V' )
			$q1nli[$i][0]='&#8730;';
		
		if( $q2nli[$i][0]=='v' OR $q2nli[$i][0]=='V' )
		{
			$q2nli[$i][0]='&#8730;';
			$smstr1[$i][0] = 'VS';
		}
		else if( $q2nli[$i][0]=='-' )
			$smstr1[$i][0] = 'S';
		else if( $q2nli[$i][0]=='+' )
			$smstr1[$i][0] = 'S';
		else if( $q2nli[$i][0]=='NO' )
			$smstr1[$i][0] = 'NO';
		else if( $q2nli[$i][0]=='/' )
			$smstr1[$i][0] = 'MS';
		else if( $q2nli[$i][0]=='*' )
			$smstr1[$i][0] = 'O';
		else if( $q2nli[$i][0]=='ND' )
			$smstr1[$i][0] = 'NH';//ND
		
		
		
		if( $q3nli[$i][0]=='v' OR $q3nli[$i][0]=='V' )
			$q3nli[$i][0]='&#8730;';
		
		if( $q4nli[$i][0]=='v' OR $q4nli[$i][0]=='V' )
		{
			$q4nli[$i][0]='&#8730;';
			$smstr2[$i][0] = 'VS';
		}
		else if( $q4nli[$i][0]=='-' )
			$smstr2[$i][0] = 'S';
		else if( $q4nli[$i][0]=='+' )
			$smstr2[$i][0] = 'S';
		else if( $q4nli[$i][0]=='NO' )
			$smstr2[$i][0] = 'NO';
		else if( $q4nli[$i][0]=='/' )
			$smstr2[$i][0] = 'MS';
		else if( $q4nli[$i][0]=='*' )
			$smstr2[$i][0] = 'O';
		else if( $q4nli[$i][0]=='ND' )
			$smstr2[$i][0] = 'NH';//ND
		
		
		
		$i++;
		$j++;
	}
	
	//nli2
	$qLGKG2	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kodekelas' AND ( t_learnrcd_tk.kdekls='PG1' OR t_learnrcd_tk.kdekls='PG2' ) AND t_learnrcd_tk.kdeplj='PG-C' ";
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
		
		
		
		if( $q1nliB[$i][0]=='v' OR $q1nliB[$i][0]=='V' )
			$q1nliB[$i][0]='&#8730;';
		
		if( $q2nliB[$i][0]=='v' OR $q2nliB[$i][0]=='V' )
		{
			$q2nliB[$i][0]='&#8730;';
			$smstr1B[$i][0] = 'VS';
		}
		else if( $q2nliB[$i][0]=='-' )
			$smstr1B[$i][0] = 'S';
		else if( $q2nliB[$i][0]=='+' )
			$smstr1B[$i][0] = 'S';
		else if( $q2nliB[$i][0]=='NO' )
			$smstr1B[$i][0] = 'NO';
		else if( $q2nliB[$i][0]=='*' )
			$smstr1B[$i][0] = 'O';
		else if( $q2nliB[$i][0]=='ND' )
			$smstr1B[$i][0] = 'NH';//ND
		else if( $q2nliB[$i][0]=='/' )
			$smstr1B[$i][0] = 'MS';
		
		
		
		if( $q3nliB[$i][0]=='v' OR $q3nliB[$i][0]=='V' )
			$q3nliB[$i][0]='&#8730;';
		
		if( $q4nliB[$i][0]=='v' OR $q4nliB[$i][0]=='V' )
		{
			$q4nliB[$i][0]='&#8730;';
			$smstr2B[$i][0] = 'VS';
		}
		else if( $q4nliB[$i][0]=='-' )
			$smstr2B[$i][0] = 'S';
		else if( $q4nliB[$i][0]=='+' )
			$smstr2B[$i][0] = 'S';
		else if( $q4nliB[$i][0]=='NO' )
			$smstr2B[$i][0] = 'NO';
		else if( $q4nliB[$i][0]=='*' )
			$smstr2B[$i][0] = 'O';
		else if( $q4nliB[$i][0]=='ND' )
			$smstr2B[$i][0] = 'NH';//ND
		else if( $q4nliB[$i][0]=='/' )
			$smstr2B[$i][0] = 'MS';
				
		
		
		$i++;
		$j++;
	}
	
	//nli3
	$qLGKG3	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kodekelas' AND ( t_learnrcd_tk.kdekls='PG1' OR t_learnrcd_tk.kdekls='PG2' ) AND t_learnrcd_tk.kdeplj='PG-D' ";
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
		
		
		
		if( $q1nliC[$i][0]=='v' OR $q1nliC[$i][0]=='V' )
			$q1nliC[$i][0]='&#8730;';
		
		if( $q2nliC[$i][0]=='v' OR $q2nliC[$i][0]=='V' )
		{
			$q2nliC[$i][0]='&#8730;';
			$smstr1C[$i][0] = 'VS';
		}
		else if( $q2nliC[$i][0]=='-' )
			$smstr1C[$i][0] = 'S';
		else if( $q2nliC[$i][0]=='+' )
			$smstr1C[$i][0] = 'S';
		else if( $q2nliC[$i][0]=='NO' )
			$smstr1C[$i][0] = 'NO';
		else if( $q2nliC[$i][0]=='/' )
			$smstr1C[$i][0] = 'MS';
		else if( $q2nliC[$i][0]=='ND' )
			$smstr1C[$i][0] = 'NH';//ND
		else if( $q2nliC[$i][0]=='*' )
			$smstr1C[$i][0] = 'O';
		
		
		
		if( $q3nliC[$i][0]=='v' OR $q3nliC[$i][0]=='V' )
			$q3nliC[$i][0]='&#8730;';
		
		if( $q4nliC[$i][0]=='v' OR $q4nliC[$i][0]=='V' )
		{
			$q4nliC[$i][0]='&#8730;';
			$smstr2C[$i][0] = 'VS';
		}
		else if( $q4nliC[$i][0]=='-' )
			$smstr2C[$i][0] = 'S';
		else if( $q4nliC[$i][0]=='+' )
			$smstr2C[$i][0] = 'S';
		else if( $q4nliC[$i][0]=='NO' )
			$smstr2C[$i][0] = 'NO';
		else if( $q4nliC[$i][0]=='/' )
			$smstr2C[$i][0] = 'MS';
		else if( $q4nliC[$i][0]=='ND' )
			$smstr2C[$i][0] = 'NH';//ND
		else if( $q4nliC[$i][0]=='*' )
			$smstr2C[$i][0] = 'O';
		
		
		
		$i++;
		$j++;
	}
	
	//nli4
	$qLGKG4	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kodekelas' AND ( t_learnrcd_tk.kdekls='PG1' OR t_learnrcd_tk.kdekls='PG2' ) AND t_learnrcd_tk.kdeplj='PG-E' ";
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
		
		
		
		if( $q1nliD[$i][0]=='v' OR $q1nliD[$i][0]=='V' )
			$q1nliD[$i][0]='&#8730;';
		
		if( $q2nliD[$i][0]=='v' OR $q2nliD[$i][0]=='V' )
		{
			$q2nliD[$i][0]='&#8730;';
			$smstr1D[$i][0] = 'VS';
		}
		else if( $q2nliD[$i][0]=='-' )
			$smstr1D[$i][0] = 'S';
		else if( $q2nliD[$i][0]=='+' )
			$smstr1D[$i][0] = 'S';
		else if( $q2nliD[$i][0]=='NO' )
			$smstr1D[$i][0] = 'NO';
		else if( $q2nliD[$i][0]=='/' )
			$smstr1D[$i][0] = 'MS';
		else if( $q2nliD[$i][0]=='*' )
			$smstr1D[$i][0] = 'O';
		else if( $q2nliD[$i][0]=='ND' )
			$smstr1D[$i][0] = 'NH';//ND
		
		
		
		if( $q3nliD[$i][0]=='v' OR $q3nliD[$i][0]=='V' )
			$q3nliD[$i][0]='&#8730;';
		
		if( $q4nliD[$i][0]=='v' OR $q4nliD[$i][0]=='V' )
		{
			$q4nliD[$i][0]='&#8730;';
			$smstr2D[$i][0] = 'VS';
		}
		else if( $q4nliD[$i][0]=='-' )
			$smstr2D[$i][0] = 'S';
		else if( $q4nliD[$i][0]=='+' )
			$smstr2D[$i][0] = 'S';
		else if( $q4nliD[$i][0]=='NO' )
			$smstr2D[$i][0] = 'NO';
		else if( $q4nliD[$i][0]=='/' )
			$smstr2D[$i][0] = 'MS';
		else if( $q4nliD[$i][0]=='*' )
			$smstr2D[$i][0] = 'O';
		else if( $q4nliD[$i][0]=='ND' )
			$smstr2D[$i][0] = 'NH';//ND
		
		
		
		$i++;
		$j++;
	}
	
	//nli5
	$qLGKG5	="	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kodekelas' AND ( t_learnrcd_tk.kdekls='PG1' OR t_learnrcd_tk.kdekls='PG2' ) AND t_learnrcd_tk.kdeplj='PG-B' ";
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
		
		//..yang lngkap
		
		if( $q1nliE[$i][0]=='v' OR $q1nliE[$i][0]=='V' )
			$q1nliE[$i][0]='&#8730;';
		
		if( $q2nliE[$i][0]=='v' OR $q2nliE[$i][0]=='V' )
		{
			$q2nliE[$i][0]='&#8730;';
			$smstr1E[$i][0] = 'VS';
		}
		else if( $q2nliE[$i][0]=='*' )
			$smstr1E[$i][0] = 'O';
		else if( $q2nliE[$i][0]=='+' )
			$smstr1E[$i][0] = 'S';
		else if( $q2nliE[$i][0]=='/' )
			$smstr1E[$i][0] = 'MS';
		else if( $q2nliE[$i][0]=='ND' )
			$smstr1E[$i][0] = 'NH';//ND
		else if( $q2nliE[$i][0]=='NO' )
			$smstr1E[$i][0] = 'NO';
		else if( $q2nliE[$i][0]=='-' )
			$smstr1E[$i][0] = 'S';
		
		
		
		if( $q3nliE[$i][0]=='v' OR $q3nliE[$i][0]=='V' )
			$q3nliE[$i][0]='&#8730;';
		
		if( $q4nliE[$i][0]=='v' OR $q4nliE[$i][0]=='V' )
		{
			$q4nliE[$i][0]='&#8730;';
			$smstr2E[$i][0] = 'VS';
		}
		else if( $q4nliE[$i][0]=='*' )
			$smstr2E[$i][0] = 'O';
		else if( $q4nliE[$i][0]=='+' )
			$smstr2E[$i][0] = 'S';
		else if( $q4nliE[$i][0]=='/' )
			$smstr2E[$i][0] = 'MS';
		else if( $q4nliE[$i][0]=='ND' )
			$smstr2E[$i][0] = 'NH';//ND
		else if( $q4nliE[$i][0]=='NO' )
			$smstr2E[$i][0] = 'NO';
		else if( $q4nliE[$i][0]=='-' )
			$smstr2E[$i][0] = 'S';
		
		
		
		$i++;
		$j++;
	}
//..







$query2 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE		t_mstssw.nis='". mysql_escape_string($kodekelas)."'
			";//$nis
$result2 =mysql_query($query2) or die('Query gagal');

if($data2 = mysql_fetch_array($result2))
{
	$nmassw 	=$data2[nmassw];
	$jnsklm 	=$data2[jnsklm];
	$tmplhr 	=$data2[tmplhr];
	$tgllhr 	=$data2[tgllhr];
	$kkelas 	=$data2[kdekls];
	//$kdekls 	=$data2[kdekls];
	
	$nmaayh 	=$data2[nmaayh];
	$pkjayh 	=$data2[pkjayh];
	$nmaibu 	=$data2[nmaibu];
	$pkjibu 	=$data2[pkjibu];
	
	$alm	 	=$data2[alm];
	$tlp	 	=$data2[tlp];
	
	if($jnsklm=='P')
		$jnsklm = 'Perempuan';
	else if($jnsklm=='L')
		$jnsklm = 'Laki-laki';
	
	$tgllhr=strtotime($tgllhr);
	$tgllhr=date('d F, Y',$tgllhr);
	
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
}





//..



echo"



	<br/>
	<br/><br/>
	<br/>
	<br/><br/>
	<br/>
	<br/><br/>
	<br/>
	<br/><br/>
	<br/>
	<br/><br/>
	
	
	
	<center>
			<FONT FACE='ARIAL' SIZE='100'><b>Student No. : $nis</b></font>
	</center>
	
	
	
	<br/>
	<br/><br/>
	<br/>
	<br/><br/>
	<br/>
	<br/><br/>
	<br/>
	<br/><br/>
	<br/>
	<br/><br/>
	<br/>
	<br/><br/>
	<br/>
	<br/><br/>
	
	
	
	<!--	awal halaman 2	-->
	<table width='100%'>
		<tr>
			<!--	awal table kiri	-->
			<td width='2.5%'>
			
			</td>
			<td width='47.50%'>		
				<TABLE width='100%'>
				
				<CAPTION>
					<B><FONT FACE='ARIAL'  SIZE='4'>FOURTH TERM</font></B><br/><B><FONT FACE='ARIAL'  SIZE='5'>REMARKS</font></B><br/><br/>
				</CAPTION>
				
				<TR>
					<TD colspan='2'><b><u>1. Personal, Social, and Emotional Development</u></b></TD>
				</TR>
				<TR>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='95%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size='2'>$q4KMN</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<TD colspan='2'><b><u>2. Communication, Language and Literacy</u></b></TD>
				</TR>
				<TR>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='95%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size='2'>$q4KMN2</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<TD colspan='2'><b><u>3. Mathematical/Cognitive Development</u></b></TD>
				</TR>
				<TR>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='95%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size='2'>$q4KMN3</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<TD colspan='2'><b><u>4. Creative Development</u></b></TD>
				</TR>
				<TR>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='95%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size='2'>$q4KMN4</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<TD colspan='2'><b><u>5. Physical Development (Gross and Fine Motor Skills)</u></b></TD>
				</TR>
				<TR>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='95%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size='2'>$q4KMN5</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				</TABLE>
			</td>
			<!--	akhir table kiri	-->
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<!--	awal table kanan	-->
			<td width='50%'>
				<br/><br/>
				<br/><br/>
				<br/><br/>
				<br/><br/>
				<center>
				<table width='100%'>
				
				
				
				<tr>
				<td	width='50'></td>
				<td align='center'>	
					<FONT FACE='ARIAL'  SIZE='5'><b><u>Student's Information</u></b></font><br/><br/>
				
				
				
					<table style='border-collapse: collapse;' border='1' width='90%' height='100'>
						<tr>
							
							<TD valign='top'>
								<table width='95%'>
									
									
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	Student No.		</td><td width='5%' align='center'>	:	</td><td width='65%' align='center'>	<u>$nis</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	Name		</td><td width='5%' align='center'>	:	</td><td width='65%' align='center'>	<u>$nmassw</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	Class		</td><td width='5%' align='center'>	:	</td><td width='65%' align='center'>	<u>$kkelas</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	 Place of Birth		</td><td width='5%' align='center'>	:	</td><td width='65%' align='center'>	<u>$tmplhr</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	 Date of Birth		</td><td width='5%' align='center'>	:	</td><td width='65%' align='center'>	<u>$tgllhr</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	 Mother's Name		</td><td width='5%' align='center'>	:	</td><td width='65%' align='center'>	<u>$nmaibu</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	 Father's Name		</td><td width='5%' align='center'>	:	</td><td width='65%' align='center'>	<u>$nmaayh</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	 Address		</td><td width='5%' align='center'>	:	</td><td width='65%' align='center'>	<u>$alm</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									
									
								</table>
							</td>
						</tr>
					</table>
				</td>
				</tr>
				
				
				
				</table>
				</center>
				
				
				
				<br/>
				
				
				
				<table align='right'>
					<tr>
						<!--<td	width='50'></td>-->
						<td>	<img src='../../images/Pre-K/".$kodekelas.".jpg' height='148' width='150' />	</td><td valign='top'>	<br/> &nbsp;&nbsp; Jakarta, October 6, 2017 <br/><br/><br/><br/><br/> <u>Glorya Lumbantoruan S.Pd.</u> <br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; School Principal	</td>
						<td	width='20'></td>
					</tr>
				</table>
			</td>
			<!--	akhir table kanan	-->
		</tr>
	</table>
	<!--	khir halaman 2	-->
	
	
	
	
	
	
	
	<!--	awal halaman 3	-->
	<table width='100%'>
		<tr>
			<!--	awal table kiri	-->
			<td width='2.5%'>
			
			</td>
			<td width='47.50%'>		
				<TABLE width='90%'>
				
					<tr>
						<td align='justify'>
							<br/><br/>
							<br/>
							
							<b><i>
								Dear Parents,
								
								<br/><br/>
								
								This Learning Record Book aims to inform you of your child's progress in school.
								
								<br/><br/>
								
								Through a carefully planned activities and experiences, we aim to provide your child with a wide range of opportunities to grow and develop in character and academics.
								
								<br/><br/>
								
								The learning goals in which your child needs to undergo through teaching and learning processes throughout the school year are herein described for your reference in each quarter or term report. These \"Early Learning Goals\" serve as guidelines for expectations of children's achievements throughout the \"Early Years Foundation Stage\".
								
								<br/><br/>
								
								There are four terms in the whole academic year in which we inform you of your child's level of performance in the different competencies expected of him or her. The first term is the entry level in which your child is assessed based on his/her prior knowledge and the initial experiences in school. The second and third term are the review periods wherein your child's development is described on these stages and the fourth term is the exit level or the final stage where your child's performance is described based on the extent of achievement or progress made as expected of him or her at the end of the academic year.
								
								<br/><br/>
								
								May this record book serves its purpose with your feedbacks cooperation and support as we share in the growth and development of your child throughout the year. 
								
								<br/><br/>
								
								Thank you very much.
								
								<br/><br/><br/>
								
								</i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Saint John's School
							</b>
						</td>
					</tr>
				
				</TABLE>
			</td>
			<!--	akhir table kiri	-->
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<!--	awal table kanan	-->
			<td width='50%' valign='top'>
				<TABLE width='100%'>
				
				<CAPTION>
					<B><FONT FACE='ARIAL'  SIZE='4'>THIRD TERM</font></B><br/><B><FONT FACE='ARIAL'  SIZE='5'>REMARKS</font></B><br/><br/>
				</CAPTION>
				
				<TR>
					<td	width='50'></td><TD colspan='2'><b><u>1. Personal, Social, and Emotional Development</u></b></TD>
				</TR>
				<TR>
					<td	width='50'></td>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q3KMN</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<td	width='50'></td><TD colspan='2'><b><u>2. Communication, Language and Literacy</u></b></TD>
				</TR>
				<TR>
					<td	width='50'></td>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q3KMN2</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<td	width='50'></td><TD colspan='2'><b><u>3. Mathematical/Cognitive Development</u></b></TD>
				</TR>
				<TR>
					<td	width='50'></td>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q3KMN3</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<td	width='50'></td><TD colspan='2'><b><u>4. Creative Development</u></b></TD>
				</TR>
				<TR>
					<td	width='50'></td>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q3KMN4</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<td	width='50'></td><TD colspan='2'><b><u>5. Physical Development (Gross and Fine Motor Skills)</u></b></TD>
				</TR>
				<TR>
					<td	width='50'></td>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q3KMN5</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				</TABLE>
			</td>
			<!--	akhir table kanan	-->
		</tr>
	</table>
	<!--	khir halaman 3	-->
	
	
	
	
	
	
	
	<!--	awal halaman 4	-->
	<table width='100%'>
		<tr>
			<!--	awal table kiri	-->
			<td width='2.5%'>
			
			</td>
			<td width='47.50%'>		
				<TABLE width='100%'>
				
				<CAPTION>
					<B><FONT FACE='ARIAL'  SIZE='4'>SECOND TERM</font></B><br/><B><FONT FACE='ARIAL'  SIZE='5'>REMARKS</font></B><br/><br/>
				</CAPTION>
				
				<TR>
					<TD colspan='2'><b><u>1. Personal, Social, and Emotional Development</u></b></TD>
				</TR>
				<TR>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size='2'>$q2KMN</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<TD colspan='2'><b><u>2. Communication, Language and Literacy</u></b></TD>
				</TR>
				<TR>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q2KMN2</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<TD colspan='2'><b><u>3. Mathematical/Cognitive Development</u></b></TD>
				</TR>
				<TR>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q2KMN3</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<TD colspan='2'><b><u>4. Creative Development</u></b></TD>
				</TR>
				<TR>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q2KMN4</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<TD colspan='2'><b><u>5. Physical Development (Gross and Fine Motor Skills)</u></b></TD>
				</TR>
				<TR>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q2KMN5</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				</TABLE>
			</td>
			<!--	akhir table kiri	-->
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<!--	awal table kanan	-->
			<td width='50%' valign='top'>
				<TABLE width='90%'>
				
					<tr>
						<td	width='50'>
						
						</td>
						<td align='justify'>	
							<br/><br/>
							<br/>
							
								<b>
									<font size='5'>Our Vision and Mission Statements</font>
									
									<br/><br/>
									<br/>
									
									<u>Vision</u>
								</b>
								
								<br/>
							
							<b><i>
								
								As a Catholic school, we envision our students to pursue education in the best local and international universities, to be the best in their chosen career or vocation, to be productive members of the society- indepedent, disciplined, creative, critical thinkers, having a better understanding and deeper appreciation of their cultural heritage, and effective Christian witnesses to the world.
								
							</b></I>
							
							<br/><br/>
							
							<u><b>Mission</b></u>
							
							<br/>
							
							<b><i>
							
							Saint John's Catholic School is committed to provide a strong basic education living up to its three-fold ideal of Scientia, Virtus et Vita (Knowledge, Virtues and Life) within the framework of Christian values.

							
							</b></i>
						</td>
					</tr>
				
				</TABLE>
			</td>
			<!--	akhir table kanan	-->
		</tr>
	</table>
	<!--	khir halaman 4	-->
	
	
	
	
	
	
	
	<!--	awal halaman 5	-->
	<table width='100%'>
		<tr>
			<!--	awal table kiri	-->
			<td width='2.5%'>
			
			</td>
			<td width='47.50%' valign='top'>		
				<TABLE width='95%' style='border-collapse: collapse;' border='1'>
					
					<CAPTION>
						<font size='4'><b>Personal, Social and Emotional Development </b></font><br/><br/>
					</CAPTION>
					
					<TR>
						<TD height='20' WIDTH='50%' align='center'>	<b>Learning Goals</b>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 1</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 2</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>SEMESTER 1</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 3</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 4</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>SEMESTER 2</b></font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> A. Disposition and attitude</font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>1</td><td align='justify'><font size='1'>".$nmektr[0][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nli[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nli[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nli[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nli[1][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2[1][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>2</td><td align='justify'><font size='1'>".$nmektr[1][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nli[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nli[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nli[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nli[2][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2[2][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>3</td><td align='justify'><font size='1'>".$nmektr[2][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nli[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nli[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nli[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nli[3][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2[3][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> B. Self-care and independence </font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>4</td><td align='justify'><font size='1'>".$nmektr[3][0]."</font></td></tr></table>	</TD><TD align='center'>	<font size='1'>".$q1nli[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nli[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nli[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nli[4][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2[4][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>5</td><td align='justify'><font size='1'>".$nmektr[4][0]."</font></td></tr></table>	</TD><TD align='center'>	<font size='1'>".$q1nli[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nli[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nli[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nli[5][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2[5][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> C. Confidence and Self-esteem </font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>6</td><td align='justify'><font size='1'>".$nmektr[5][0]."</font></td></tr></table>	</TD><TD align='center'>	<font size='1'>".$q1nli[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nli[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nli[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nli[6][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2[6][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>7</td><td align='justify'><font size='1'>".$nmektr[6][0]."</font></td></tr></table>	</TD><TD align='center'>	<font size='1'>".$q1nli[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nli[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nli[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nli[7][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2[7][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>8</td><td align='justify'><font size='1'>".$nmektr[7][0]."</font></td></tr></table>	</TD><TD align='center'>	<font size='1'>".$q1nli[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nli[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nli[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nli[8][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2[8][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>9</td><td align='justify'><font size='1'>".$nmektr[8][0]."</font></td></tr></table>	</TD><TD align='center'>	<font size='1'>".$q1nli[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nli[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nli[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nli[9][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2[9][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> D. Behaviour and self-control </font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>10</td><td align='justify'><font size='1'>".$nmektr[9][0]."</font></td></tr></table>	</TD><TD align='center'>	<font size='1'>".$q1nli[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nli[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nli[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nli[10][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2[10][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>11</td><td align='justify'><font size='1'>".$nmektr[10][0]."</font></td></tr></table>	</TD><TD align='center'>	<font size='1'>".$q1nli[11][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nli[11][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1[11][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nli[11][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nli[11][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2[11][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>12</td><td align='justify'><font size='1'>".$nmektr[11][0]."</font></td></tr></table>	</TD><TD align='center'>	<font size='1'>".$q1nli[12][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nli[12][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1[12][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nli[12][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nli[12][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2[12][0]."</font>	</TD>
					</TR>
					
				</TABLE>
			</td>
			<!--	akhir table kiri	-->
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<!--	awal table kanan	-->
			<td width='50%'>
				<TABLE width='95%'>
				
				<CAPTION>
					<B><FONT FACE='ARIAL'  SIZE='4'>FIRST TERM</font></B><br/><B><FONT FACE='ARIAL'  SIZE='5'>REMARKS</font></B><br/><br/>
				</CAPTION>
				
				<TR>
					<td	width='50'></td><TD colspan='2'><b><u>1. Personal, Social, and Emotional Development</u></b></TD>
				</TR>
				<TR>
					<td	width='50'></td>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size='2'>$q1KMN</font></td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<td	width='50'></td><TD colspan='2'><b><u>2. Communication, Language and Literacy</u></b></TD>
				</TR>
				<TR>
					<td	width='50'></td>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q1KMN2</font></td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<td	width='50'></td><TD colspan='2'><b><u>3. Mathematical/Cognitive Development</u></b></TD>
				</TR>
				<TR>
					<td	width='50'></td>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q1KMN3</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<td	width='50'></td><TD colspan='2'><b><u>4. Creative Development</u></b></TD>
				</TR>
				<TR>
					<td	width='50'></td>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q1KMN4</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				<TR>
					<td	width='50'></td><TD colspan='2'><b><u>5. Physical Development (Gross and Fine Motor Skills)</u></b></TD>
				</TR>
				<TR>
					<td	width='50'></td>
					<TD width='25'>
						
					</TD>
					<TD>
						<table width='90%' style='border-collapse: collapse;' border='1'>
							<tr>
								<td height='100' align='justify' valign='top'><font size=''>$q1KMN5</td>
							</tr>
						</table>
					</TD>
				</TR>
				
				
				
				</TABLE>
			</td>
			<!--	akhir table kanan	-->
		</tr>
	</table>
	<!--	khir halaman 5	-->
	
	
	
	
	
	
	
	<!--	awal halaman 6	-->
	<table width='100%'>
		<tr>
			<!--	awal table kiri	-->
			<td width='2.5%'>
			
			</td>
			<td width='47.50%' valign='top'>		
				<TABLE width='95%' style='border-collapse: collapse;' border='1'>
					
					<CAPTION>
						<font size='4'><b>Mathematical / Cognitive Development  </b></font><br/><br/>
					</CAPTION>
					
					<TR>
						<TD height='20' WIDTH='50%' align='center'>	<b>Learning Goals</b>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 1</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 2</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>SEMESTER 1</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 3</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 4</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>SEMESTER 2</b></font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> A. Numbers for Counting and labels</font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>1</td><td align='justify'><font size='1'>".$nmektr2[0][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliB[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliB[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1B[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliB[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliB[1][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2B[1][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>2</td><td align='justify'><font size='1'>".$nmektr2[1][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliB[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliB[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1B[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliB[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliB[2][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2B[2][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>3</td><td align='justify'><font size='1'>".$nmektr2[2][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliB[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliB[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1B[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliB[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliB[3][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2B[3][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>4</td><td align='justify'><font size='1'>".$nmektr2[3][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliB[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliB[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1B[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliB[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliB[4][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2B[4][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> B. Calculating</font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>5</td><td align='justify'><font size='1'>".$nmektr2[4][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliB[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliB[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1B[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliB[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliB[5][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2B[5][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>6</td><td align='justify'><font size='1'>".$nmektr2[5][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliB[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliB[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1B[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliB[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliB[6][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2B[6][0]."</font>	</TD>
					</TR>
					
					<TR bgcolor='#A9A9A9'>
						<TD COLSPAN='7'><u><b><font size='1'> C. Shape, Space and Measure</font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>7</td><td align='justify'><font size='1'>".$nmektr2[6][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliB[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliB[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1B[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliB[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliB[7][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2B[7][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>8</td><td align='justify'><font size='1'>".$nmektr2[7][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliB[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliB[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1B[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliB[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliB[8][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2B[8][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>9</td><td align='justify'><font size='1'>".$nmektr2[8][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliB[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliB[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1B[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliB[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliB[9][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2B[9][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>10</td><td align='justify'><font size='1'>".$nmektr2[9][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliB[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliB[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1B[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliB[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliB[10][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2B[10][0]."</font>	</TD>
					</TR>
					
				</TABLE>
			</td>
			<!--	akhir table kiri	-->
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<!--	awal table kanan	-->
			<td width='2.5%'>
			
			</td>
			<td width='47.50%' valign='top'>
				<TABLE width='95%' style='border-collapse: collapse;' border='1'>
					
					<CAPTION>
						<font size='4'><b>Creative Development  </b></font><br/><br/>
					</CAPTION>
					
					<TR>
						<TD height='20' WIDTH='50%' align='center'>	<b>Learning Goals</b>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 1</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 2</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>SEMESTER 1</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 3</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 4</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>SEMESTER 2</b></font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='2'> A. Exploring Media and Materials</font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='2'>1</td><td align='justify'><font size='2'>".$nmektr3[0][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='2'>".$q1nliC[1][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q2nliC[1][0]."</font>	</TD><TD align='center'>	<font size='2'>".$smstr1C[1][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q3nliC[1][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q4nliC[1][0]."</font>	</TD><TD height='20' align='center'>	<font size='2'>".$smstr2C[1][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='2'>2</td><td align='justify'><font size='2'>".$nmektr3[1][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='2'>".$q1nliC[2][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q2nliC[2][0]."</font>	</TD><TD align='center'>	<font size='2'>".$smstr1C[2][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q3nliC[2][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q4nliC[2][0]."</font>	</TD><TD height='20' align='center'>	<font size='2'>".$smstr2C[2][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='2'>3</td><td align='justify'><font size='2'>".$nmektr3[2][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='2'>".$q1nliC[3][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q2nliC[3][0]."</font>	</TD><TD align='center'>	<font size='2'>".$smstr1C[3][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q3nliC[3][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q4nliC[3][0]."</font>	</TD><TD height='20' align='center'>	<font size='2'>".$smstr2C[3][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='2'>4</td><td align='justify'><font size='2'>".$nmektr3[3][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='2'>".$q1nliC[4][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q2nliC[4][0]."</font>	</TD><TD align='center'>	<font size='2'>".$smstr1C[4][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q3nliC[4][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q4nliC[4][0]."</font>	</TD><TD height='20' align='center'>	<font size='2'>".$smstr2C[4][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='2'> B. Music</font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='2'>5</td><td align='justify'><font size='2'>".$nmektr3[4][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='2'>".$q1nliC[5][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q2nliC[5][0]."</font>	</TD><TD align='center'>	<font size='2'>".$smstr1C[5][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q3nliC[5][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q4nliC[5][0]."</font>	</TD><TD height='20' align='center'>	<font size='2'>".$smstr2C[5][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='2'>6</td><td align='justify'><font size='2'>".$nmektr3[5][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='2'>".$q1nliC[6][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q2nliC[6][0]."</font>	</TD><TD align='center'>	<font size='2'>".$smstr1C[6][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q3nliC[6][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q4nliC[6][0]."</font>	</TD><TD height='20' align='center'>	<font size='2'>".$smstr2C[6][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='2'>7</td><td align='justify'><font size='2'>".$nmektr3[6][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='2'>".$q1nliC[7][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q2nliC[7][0]."</font>	</TD><TD align='center'>	<font size='2'>".$smstr1C[7][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q3nliC[7][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q4nliC[7][0]."</font>	</TD><TD height='20' align='center'>	<font size='2'>".$smstr2C[7][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='2'>8</td><td align='justify'><font size='2'>".$nmektr3[7][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='2'>".$q1nliC[8][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q2nliC[8][0]."</font>	</TD><TD align='center'>	<font size='2'>".$smstr1C[8][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q3nliC[8][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q4nliC[8][0]."</font>	</TD><TD height='20' align='center'>	<font size='2'>".$smstr2C[8][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='2'> C. Responding to and Expressing Ideas</font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='2'>9</td><td align='justify'><font size='2'>".$nmektr3[8][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='2'>".$q1nliC[9][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q2nliC[9][0]."</font>	</TD><TD align='center'>	<font size='2'>".$smstr1C[9][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q3nliC[9][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q4nliC[9][0]."</font>	</TD><TD height='20' align='center'>	<font size='2'>".$smstr2C[9][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='2'>10</td><td align='justify'><font size='2'>".$nmektr3[9][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='2'>".$q1nliC[10][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q2nliC[10][0]."</font>	</TD><TD align='center'>	<font size='2'>".$smstr1C[10][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q3nliC[10][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q4nliC[10][0]."</font>	</TD><TD height='20' align='center'>	<font size='2'>".$smstr2C[10][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='2'>11</td><td align='justify'><font size='2'>".$nmektr3[10][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='2'>".$q1nliC[11][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q2nliC[11][0]."</font>	</TD><TD align='center'>	<font size='2'>".$smstr1C[11][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q3nliC[11][0]."</font>	</TD><TD align='center'>	<font size='2'>".$q4nliC[11][0]."</font>	</TD><TD height='20' align='center'>	<font size='2'>".$smstr2C[11][0]."</font>	</TD>
					</TR>
					
					
				</TABLE>
			</td>
			<!--	akhir table kanan	-->
		</tr>
	</table>
	<!--	khir halaman 6	-->
	
	
	
	
	
	
	
	<br/><br/>
	
	
	<!--	awal halaman 7	-->
	<table width='100%'>
		<tr>
			<!--	awal table kiri	-->
			<td width='2.5%'>
			
			</td>
			<td width='47.50%' valign='top'>		
				<TABLE width='95%' style='border-collapse: collapse;' border='1'>
					
					<CAPTION>
						<font size='4'><b>Physical Development (Gross and Fine Motor)  </b></font><br/><br/>
					</CAPTION>
					
					<TR>
						<TD height='20' WIDTH='50%' align='center'>	<b>Learning Goals</b>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 1</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 2</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>SEMESTER 1</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 3</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 4</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>SEMESTER 2</b></font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> A. Gross Motor Development </font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>1</td><td align='justify'><font size='1'>".$nmektr4[0][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliD[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliD[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1D[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliD[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliD[1][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2D[1][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>2</td><td align='justify'><font size='1'>".$nmektr4[1][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliD[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliD[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1D[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliD[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliD[2][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2D[2][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>3</td><td align='justify'><font size='1'>".$nmektr4[2][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliD[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliD[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1D[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliD[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliD[3][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2D[3][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>4</td><td align='justify'><font size='1'>".$nmektr4[3][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliD[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliD[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1D[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliD[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliD[4][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2D[4][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>5</td><td align='justify'><font size='1'>".$nmektr4[4][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliD[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliD[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1D[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliD[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliD[5][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2D[5][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> B. Fine Motor Development </font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>6</td><td align='justify'><font size='1'>".$nmektr4[5][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliD[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliD[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1D[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliD[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliD[6][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2D[6][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>7</td><td align='justify'><font size='1'>".$nmektr4[6][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliD[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliD[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1D[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliD[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliD[7][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2D[7][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>8</td><td align='justify'><font size='1'>".$nmektr4[7][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliD[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliD[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1D[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliD[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliD[8][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2D[8][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>9</td><td align='justify'><font size='1'>".$nmektr4[8][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliD[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliD[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1D[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliD[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliD[9][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2D[9][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> C. Health and Body Awareness  </font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>10</td><td align='justify'><font size='1'>".$nmektr4[9][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliD[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliD[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1D[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliD[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliD[10][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2D[10][0]."</font>	</TD>
					</TR>
					
				</TABLE>
			</td>
			<!--	akhir table kiri	-->
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<!--	awal table kanan	-->
			<td width='2.5%'>
			
			</td>
			<td width='47.50%' valign='top'>
				<TABLE width='95%' style='border-collapse: collapse;' border='1'>
					
					<CAPTION>
						<font size='4'><b>Communication, Language and Literacy  </b></font><br/><br/>
					</CAPTION>
					
					<TR>
						<TD height='20' WIDTH='50%' align='center'>	<b>Learning Goals</b>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 1</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 2</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>SEMESTER 1</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 3</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>TERM 4</b></font>	</TD><TD height='20' align='center'>	<font size='2'><b>SEMESTER 2</b></font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> A. Listening </font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>1</td><td align='justify'><font size='1'>".$nmektr5[0][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[1][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[1][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[1][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>2</td><td align='justify'><font size='1'>".$nmektr5[1][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[2][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[2][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[2][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>3</td><td align='justify'><font size='1'>".$nmektr5[2][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[3][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[3][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[3][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>4</td><td align='justify'><font size='1'>".$nmektr5[3][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[4][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[4][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[4][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> B. Speaking </font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>5</td><td align='justify'><font size='1'>".$nmektr5[4][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[5][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[5][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[5][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>6</td><td align='justify'><font size='1'>".$nmektr5[5][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[6][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[6][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[6][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>7</td><td align='justify'><font size='1'>".$nmektr5[6][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[7][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[7][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[7][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> C. Reading </font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>8</td><td align='justify'><font size='1'>".$nmektr5[7][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[8][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[8][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[8][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>9</td><td align='justify'><font size='1'>".$nmektr5[8][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[9][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[9][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[9][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>10</td><td align='justify'><font size='1'>".$nmektr5[9][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[10][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[10][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[10][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>11</td><td align='justify'><font size='1'>".$nmektr5[10][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[11][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[11][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[11][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[11][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[11][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[11][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD COLSPAN='7' bgcolor='#A9A9A9'><u><b><font size='1'> D. Writing / Handwriting </font></b></u></TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>12</td><td align='justify'><font size='1'>".$nmektr5[11][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[12][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[12][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[12][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[12][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[12][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[12][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	 <table align='left'><tr><td valign='top'><font size='1'>13</td><td align='justify'><font size='1'>".$nmektr5[12][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[13][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[13][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[13][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[13][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[13][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[13][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>14</td><td align='justify'><font size='1'>".$nmektr5[13][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[14][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[14][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[14][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[14][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[14][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[14][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>15</td><td align='justify'><font size='1'>".$nmektr5[14][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[15][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[15][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[15][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[15][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[15][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[15][0]."</font>	</TD>
					</TR>
					
					<TR>
						<TD WIDTH='50%'>	<table align='left'><tr><td valign='top'><font size='1'>16</td><td align='justify'><font size='1'>".$nmektr5[15][0]."</font></td></tr></table>		</TD><TD align='center'>	<font size='1'>".$q1nliE[16][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q2nliE[16][0]."</font>	</TD><TD align='center'>	<font size='1'>".$smstr1E[16][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q3nliE[16][0]."</font>	</TD><TD align='center'>	<font size='1'>".$q4nliE[16][0]."</font>	</TD><TD height='20' align='center'>	<font size='1'>".$smstr2E[16][0]."</font>	</TD>
					</TR>
					
				</TABLE>
			</td>
			<!--	akhir table kanan	-->
		</tr>
	</table>
	<!--	khir halaman 7	-->
";



//..







?>