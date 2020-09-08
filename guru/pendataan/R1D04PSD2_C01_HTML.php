<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04PSD_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) rapot mid term sd 4
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
/*require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';*/

$kdekls	=$_GET['kdekls'];
//$nis	=$_POST['nis'];
//$sms	=$_POST['sms'];
$sms	='2';
$midtrm	='2';//$_POST['midtrm'];
$tglctk	=$_POST['11-06-2021'];//tglctk

$thnajr	="2020-2021";

if($tglctk=='')
{
	//$tglctk	=date('d F Y');
	//$tglctk ='11-06-2021';
	
	$tglctk	=strtotime('11-06-2021');
	$tglctk	=date('d F Y',$tglctk);
}
else
{	
	$tglctk	=strtotime($tglctk);
	$tglctk	=date('d F Y',$tglctk);
}

// dapatkan data tahun ajaran
/*$query	="	SELECT 		t_setthn_sd.*
			FROM 		t_setthn_sd
			WHERE		t_setthn_sd.set='Tahun Ajaran'"; // menghasilka tahun ajaran
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];*/

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='1HW'"; // menghasilka bobot 1
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='2PRJ'"; // menghasilka bobot 2
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='3TES'"; // menghasilka bobot 3
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='4MID'"; // menghasilkan bobot 4
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtmidtes=$data[bbt];

$query	="	SELECT 		t_mstbbt_sd.*
			FROM 		t_mstbbt_sd
			WHERE		t_mstbbt_sd.kdebbt='5ST'"; // menghasilkan bobot 5
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtst=$data[bbt];



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
		<style type='text/css'>
			TH{
				font-family: Arial;
				font-size: 10pt;
			}
			TD{
				font-family: Arial;
				font-size: 10pt;
			}
			B{
				font-family: Arial;
				font-size: 10pt;
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
				
";//font-family: Arial, Helvetica, sans-serif; //



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
$gelar=$data[gelar];
$kdeklm=$data[kdeklm]+1;
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
$judul2=$nmasms.'FINAL REPORT';


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
				ORDER BY	t_prstkt.kdejbt ASC"; // kalu string kplskl kosong
	$result =mysql_query($query) or die('Query gagal3');
	$data 	=mysql_fetch_array($result);
	$kplskl=$data[nmakry];
}


//$logo_pt	="../../images/logo.jpg";
//$logo_ttw	="../../images/tutwurihandayani.jpg";



$query 	="	SELECT 		t_setpsrpt.* 
			FROM 		t_setpsrpt
			WHERE 		t_setpsrpt.kdetkt='". mysql_escape_string($kdetkt)."' 
			ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id"; // menghasilka subjek rapot per unit
$result =mysql_query($query) or die('Query gagal5');
$k=0;
while($data =mysql_fetch_array($result))
{
	if($data[kdeplj]!='')
	{
		$kdeplj=$data[kdeplj];
		
		$query2 	="	SELECT 		t_mstssw.*
					FROM 		t_mstssw
					WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."'  
								
					ORDER BY	t_mstssw.kdekls,t_mstssw.nis ASC
					LIMIT		1,1"; // menghasilka satu siswa per kelas per subjek
		$result2 =mysql_query($query2) or die('Query gagal5');
		$data2 	=mysql_fetch_array($result2);
		$nis	=$data2[nis];//asli
		//$tanggallahir = $data2[tgllhr];
		
		/*if($nis!='')
			$nis_x	= $nis;
		else
			$nis_x	=$data2[nis];*/
		
		//$nis_x
		$query3 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sd.nis,t_prgrptps_sd.kdeplj"; // menghasilka satu siswa per subjek (nilai akhir q1/q2/q3/q4)
		$result3 =mysql_query($query3) or die('Query gagal');
		$data3 	=mysql_fetch_array($result3);
		
		$akh1=$data3['akh'."$sms"."1"];
		$akh2=$data3['akh'."$sms"."2"];
		/*if(($akh1+$akh2)>0 OR $kdeplj=='MND' OR $kdeplj=='GRM' OR $kdeplj=='PHY' OR $kdeplj=='BLGY' OR $kdeplj=='CHM')
		{
			$cell2[$k][0]	=$data[kdeplj];
			$k++;
		}	*/
	}	
}

$query 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND 
						
						t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw"; // menghasilka semua siswa per kelas
$result =mysql_query($query) or die('Query gagal5');
$i=0;
while($data =mysql_fetch_array($result))
{
	$cell5[$i][0]=$data[nis];
	$cell5[$i][1]=$data[nmassw];
	$cell5[$i][2]=$data[nisn];
	$cell5[$i][3]=0;
	$nis=$data[nis];//asli
	
	/*if($nis!='')
			$nis_x	= $nis;
		else
			$nis_x	=$data[nis];*/
	
	//$nis_x
	$cell5[$i][4]=$data[tgllhr]; // buatan tgl lahir
	
	$ttlakh1=0;
	$ttlakh2=0;
	$ttlakh=0;
	$n=0;
	while($n<$k)
	{
		$kdeplj=$cell2[$n][0];
	
		$query2 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."'	AND 
									
									t_prgrptps_sd.kdeplj='$kdeplj'
						ORDER BY	t_prgrptps_sd.nis,t_prgrptps_sd.kdeplj"; // menghasilka satu siswa per subjek (nilai akhir q1/q2/q3/q4)
		$result2 =mysql_query($query2) or die('Query gagal');
		$data2 =mysql_fetch_array($result2);
	
		$akh1=$data2['akh'."$sms"."1"];
		$akh2=$data2['akh'."$sms"."2"];
		$ttlakh1=$ttlakh1+$akh1;
		$ttlakh2=$ttlakh2+$akh2;

		$akh=number_format(($data2['akh'."$sms"."1"]+$data2['akh'."$sms"."2"])/2,0,',','.');
		$ttlakh=$ttlakh+$akh;
		
		$n++;
	}
	
	$i++;
}
$x=$i;









$y=0;

//..--
//echo"$y<$x sampai sini";

while($y<$x)
{
	$nis	=$cell5[$y][0];
	$nmassw	=$cell5[$y][1];
	$nisn	=$cell5[$y][2];
	
	$tgllhr	=$cell5[$y][4];
	$tgllhr	=strtotime($tgllhr);
	$tgllhr	=date('d F Y',$tgllhr);//'d-M-Y'
	
	
	
	//AWAL BUATAN BARU
	$tanggallahir	=$cell5[$y][4];
	
	$tanggal_lahir	=substr($tgllhr,0,2);
	$bulan_lahir	=substr($tgllhr,3,3);
	$tahun_lahir	=substr($tanggallahir,6,4);
	
	if ( $bulan_lahir == 'Jan' )
		$bulan_lahir = 'January';
	else if ( $bulan_lahir == 'Feb' )
		$bulan_lahir = 'February';
	else if ( $bulan_lahir == 'Mar' )
		$bulan_lahir = 'March';
	else if ( $bulan_lahir == 'Apr' )
		$bulan_lahir = 'April';
	else if ( $bulan_lahir == 'May' )
		$bulan_lahir = 'May';
	else if ( $bulan_lahir == 'Jun' )
		$bulan_lahir = 'June';
	else if ( $bulan_lahir == 'Jul' )
		$bulan_lahir = 'July';
	else if ( $bulan_lahir == 'Aug' )
		$bulan_lahir = 'August';
	else if ( $bulan_lahir == 'Sep' )
		$bulan_lahir = 'September';
	else if ( $bulan_lahir == 'Oct' )
		$bulan_lahir = 'October';
	else if ( $bulan_lahir == 'Nov' )
		$bulan_lahir = 'November';
	else if ( $bulan_lahir == 'Dec' )
		$bulan_lahir = 'December';
	else //if ( $bulan_lahir == 'Mar' )
		$bulan_lahir = 'Err';
	//AKHIR BUATAN BARU
	
	
	
	$query1 ="	SELECT 		t_setpsrpt.*
				FROM 		t_setpsrpt
				WHERE		t_setpsrpt.kdetkt='$kdetkt'
				ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id"; // menghasilka subjek per unit
	$result1=mysql_query($query1) or die('Query gagal1');
	$i=1;
	while($data1 =mysql_fetch_array($result1))
	{
		$cell[$i][0]=$data1[id];	
		$cell[$i][1]=$data1[nmasbj];
		$cell[$i][2]=$data1[kdeplj];
		$kdeplj	=$data1[kdeplj];
		
		if($kdeplj!='')
		{
			$query6 	="	SELECT 		t_kkm.*
							FROM 		t_kkm
							WHERE 		t_kkm.kdekls='". mysql_escape_string($kdekls)."'	AND
										t_kkm.kdeplj='". mysql_escape_string($kdeplj)."'"; // menghasilka kkm per kelas per subjek
			$result6 =mysql_query($query6) or die('Query gagal');
			$data6 	=mysql_fetch_array($result6);

			$cell[$i][3]=$data6[kkm];
			$query2 ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='$kdeplj'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$result2=mysql_query($query2) or die('Query gagal');
			$data2 =mysql_fetch_array($result2);
			
			$cell[$i][4]=$data2['akh'."$sms"."1"];
			$cell[$i][5]=$data2['akh'."$sms"."2"];
			$cell[$i][6]=number_format(($cell[$i][4]+$cell[$i][5])/2,0,',','.');
			$nliakh		=$cell[$i][6];
			
			//$cell[$i][7]=$data2['akh'."1"."1"]; // q1
			//$cell[$i][8]=$data2['akh'."1"."2"]; // q2
			
			//$cell[$i][9] = $data2['akh'."2"."1"];//q3
			//$cell[$i][10] = $data2['akh'."2"."2"];//q4

			
		}	
		else
		{
			$cell[$i][3]='';
		}
		$i++;
	}
	
	
	
	//AWAL BUATAN BARU
	$nomor_absen_d = '';
	$nomor_absen_d = $y + 1;
	
	if($nomor_absen_d < 10)
	{
		$nomor_absen_d = '0'.$nomor_absen_d;
	}
	
	// dapatkan nomor absen
	
	$kdekls_d = substr($kdekls,-2);
	
	$strkls='';
	if($kdekls=='P-1A')
		$strkls='1A ANASTASIA';
	else if($kdekls=='P-1B')
		$strkls='1B TARCISIUS';
	else if($kdekls=='P-1C')
		$strkls='1C PATRICIA';
	else if($kdekls=='P-1D')
		$strkls='1D ';
	else if($kdekls=='P-2A')
		$strkls='2A ATTALIA';
	else if($kdekls=='P-2B')
		$strkls='2B BEATRICE';
	else if($kdekls=='P-2C')
		$strkls='2C CHARLES';
	else if($kdekls=='P-3A')
		$strkls='3A TERESA';
	else if($kdekls=='P-3B')
		$strkls='3B ALOYSIUS GONZAGA';
	else if($kdekls=='P-3C')
		$strkls='3C MARGARET';
	else if($kdekls=='P-4A')
		$strkls='4A ABIGAIL';
	else if($kdekls=='P-4B')
		$strkls='4B BENEDICT';
	else if($kdekls=='P-4C')
		$strkls='4C CAROLUS';
	else if($kdekls=='P-5A')
		$strkls='5A ALENA';
	else if($kdekls=='P-5B')
		$strkls='5B BRIDGET';
	else if($kdekls=='P-5C')
		$strkls='5C COLETTE';
	else if($kdekls=='P-6A')
		$strkls='6A ARNOLD JANSSEN';
	else if($kdekls=='P-6B')
		$strkls='6B BLAISE';
	else //if($kdekls=='P-6C')
		$strkls='6C CLAIRE';
	
	$midtrm_d='';
	if($midtrm=='1')
		$midtrm_d='Mid';
	else if($midtrm=='2')
		$midtrm_d='Final';
	
	echo"
		<div class='pb_after'>
		
			<!--<div class='word'>-->
			
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			
			<!--<font face='Arial' size='1'>-->
			
			<table width='100%'>
				<tr>
					<td align='center'><b><font size='4'>STUDENT'S PROGRESS REPORT</font></b></td>
				</tr>
				<tr>
					<td align='center'><b><font size='4'>PRIMARY SCHOOL</font></b></td>
				</tr>
				<tr>
					<td align='center'><b><font size='4'>ACADEMIC YEAR $thnajr</font></b></td>
				</tr>
				<!--
				<tr>
					<td align='center'><b><font size='4'>PRIMARY $kdekls_d $strkls</font></b></td>SAINT JOHN'S SCHOOL
				</tr>
				-->
			</table>
			
			<br/>
			
			<table width='100%'>
				<tr>
					<td align='left' valign='top'>
						
						<table>
							
							<tr><td>STUDENT NAME   </td><td> : </td><td>$nmassw</td></tr>
							<tr><td>STUDENT ID NO. </td><td> : </td><td>$nis</td></tr>
							
						</table>
						
					</td>
					<td align='right'>
						
						<table>
							
							<tr><td>BIRTHDAY </td><td> : </td><td>$tanggal_lahir $bulan_lahir $tahun_lahir</td></tr><!--$tgllhr-->
							<tr><td>SEMESTER </td><td> : </td><td>Semester $sms / $midtrm_d</td></tr>
							<tr><td>CLASS    </td><td> : </td><td>$strkls / $nomor_absen_d</td></tr><!--nomor_absen_d-->
							
						</table>
						
					</td>
				</tr>
			</table>
			
			<br/>
			
			<b>ACADEMIC PERFORMANCE</b>
			<table width='100%' border='1' style='border-collapse: collapse;'>
				<tr>
					<th align='center' rowspan='3' width='4%'>
						NO
					</th>
					<th align='center' rowspan='3' width='40.5%'><!--	-->
						SUBJECT
					</th>
					<th align='center' colspan='7' width='45.5%'><!---->
						CLASSROOM PERFORMANCE
					</th>
					<th align='center' rowspan='3' width='10%'>
						ATTITUDE
					</th>
				</tr>
				<tr>
					<th align='center' colspan='3' width='19.5%'><!--	-->
						KNOWLEDGE
					</th>
					<th align='center' colspan='3' width='19.5%'><!--	-->
						SKILLS
					</th>
					<th align='center' rowspan='2' width='6.5%' bgcolor='yellow'><!--	-->
						AV
					</th>
				</tr>
				<tr>
					<th align='center' width='6.5%'>
						Q3
					</th>
					<th align='center' width='6.5%'>
						Q4
					</th>
					<th align='center' width='6.5%' bgcolor='lightgrey'>
						FINAL
					</th>
					<th align='center' width='6.5%'>
						Q3
					</th>
					<th align='center' width='6.5%'>
						Q4
					</th>
					<th align='center' width='6.5%' bgcolor='lightgrey'>
						FINAL
					</th>
				</tr>
			
			<!--</table>
			
		</div>-->
	";
	
	//$nomor_absen_d = $nomor_absen_d + 1;
	//AKHIR BUATAN BARU
	
	
	
	
	//------------------------------- Mata Pelajaran Kurikulum Nasional
	//$j	=1;
	//$no =1;
	//$id=$cell[$j][0];
	//echo"$id - ";
	
	
	
			//RLG
			$qry_RLG ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='RLG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_RLG=mysql_query($qry_RLG) or die('Query gagal');
			$dat_RLG=mysql_fetch_array($rsl_RLG);
			
			$q1fgk_RLG=$dat_RLG['fgk'.'2'.'1'];//q1
			$q2fgk_RLG=$dat_RLG['fgk'.'2'.'2'];//q2
			
			$q1fgs_RLG=$dat_RLG['fgs'.'2'.'1'];//q1
			$q2fgs_RLG=$dat_RLG['fgs'.'2'.'2'];//q2
			
			//AWAL BUATAN BARU
			if ( $q1fgk_RLG < 60 )
				$q1fgk_RLG = 60;
			else if ( $q1fgk_RLG == 100 )
				$q1fgk_RLG = 99;
			
			if ( $q2fgk_RLG < 60 )
				$q2fgk_RLG = 60;
			else if ( $q2fgk_RLG == 100 )
				$q2fgk_RLG = 99;
			
			if ( $q1fgs_RLG < 60 )
				$q1fgs_RLG = 60;
			else if ( $q1fgs_RLG == 100 )
				$q1fgs_RLG = 99;
			
			if ( $q2fgs_RLG < 60 )
				$q2fgs_RLG = 60;
			else if ( $q2fgs_RLG == 100 )
				$q2fgs_RLG = 99;
			//AKHIR BUATAN BARU
			
			$kf_RLG = number_format( ($q1fgk_RLG+$q2fgk_RLG)/2 ,0,',','.');
			$sf_RLG = number_format( ($q1fgs_RLG+$q2fgs_RLG)/2 ,0,',','.');
			$av_RLG = number_format( ($kf_RLG+$sf_RLG)/2 ,0,',','.');
			$q2aff_RLG=$dat_RLG['aff'.$sms.$midtrm];//q2//.'1'.'2'
			
			//AWAL BUATAN BARU
			if ( $q2aff_RLG >= 90.00 AND $q2aff_RLG <= 100.00 )
				$lg7_RLG = 'A';
			else if ( $q2aff_RLG >= 80.00 AND $q2aff_RLG <= 89.99 )
				$lg7_RLG = 'B';
			else if ( $q2aff_RLG >= 70.00 AND $q2aff_RLG <= 79.99 )
				$lg7_RLG = 'C';
			else if ( $q2aff_RLG >= 0.00 AND $q2aff_RLG <= 69.99 )
				$lg7_RLG = 'D';
			else
				$lg7_RLG = 'ERR';
			//AKHIR BUATAN BARU
			
			
			
			//CME
			$qry_CME ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='CME'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_CME=mysql_query($qry_CME) or die('Query gagal');
			$dat_CME=mysql_fetch_array($rsl_CME);
			
			$q1fgk_CME=$dat_CME['fgk'.'2'.'1'];//q1
			$q2fgk_CME=$dat_CME['fgk'.'2'.'2'];//q2
			
			$q1fgs_CME=$dat_CME['fgs'.'2'.'1'];//q1
			$q2fgs_CME=$dat_CME['fgs'.'2'.'2'];//q2
			
			//AWAL BUATAN BARU
			if ( $q1fgk_CME < 60 )
				$q1fgk_CME = 60;
			else if ( $q1fgk_CME == 100 )
				$q1fgk_CME = 99;
			
			if ( $q2fgk_CME < 60 )
				$q2fgk_CME = 60;
			else if ( $q2fgk_CME == 100 )
				$q2fgk_CME = 99;
			
			if ( $q1fgs_CME < 60 )
				$q1fgs_CME = 60;
			else if ( $q1fgs_CME == 100 )
				$q1fgs_CME = 99;
			
			if ( $q2fgs_CME < 60 )
				$q2fgs_CME = 60;
			else if ( $q2fgs_CME == 100 )
				$q2fgs_CME = 99;
			//AKHIR BUATAN BARU
			
			$kf_CME = number_format( ($q1fgk_CME+$q2fgk_CME)/2 ,0,',','.');
			$sf_CME = number_format( ($q1fgs_CME+$q2fgs_CME)/2 ,0,',','.');
			$av_CME = number_format( ($kf_CME+$sf_CME)/2 ,0,',','.');
			$q2aff_CME=$dat_CME['aff'.$sms.$midtrm];//q2//.'1'.'2'
			
			//AWAL BUATAN BARU
			if ( $q2aff_CME >= 90.00 AND $q2aff_CME <= 100.00 )
				$lg7_CME = 'A';
			else if ( $q2aff_CME >= 80.00 AND $q2aff_CME <= 89.99 )
				$lg7_CME = 'B';
			else if ( $q2aff_CME >= 70.00 AND $q2aff_CME <= 79.99 )
				$lg7_CME = 'C';
			else if ( $q2aff_CME >= 0.00 AND $q2aff_CME <= 69.99 )
				$lg7_CME = 'D';
			else
				$lg7_CME = 'ERR';
			//AKHIR BUATAN BARU
			
			
			
			//BIN
			$qry_BIN ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='BIN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_BIN=mysql_query($qry_BIN) or die('Query gagal');
			$dat_BIN=mysql_fetch_array($rsl_BIN);
			
			$q1fgk_BIN=$dat_BIN['fgk'.'2'.'1'];//q1
			$q2fgk_BIN=$dat_BIN['fgk'.'2'.'2'];//q2
			
			$q1fgs_BIN=$dat_BIN['fgs'.'2'.'1'];//q1
			$q2fgs_BIN=$dat_BIN['fgs'.'2'.'2'];//q2
			
			//AWAL BUATAN BARU
			if ( $q1fgk_BIN < 60 )
				$q1fgk_BIN = 60;
			else if ( $q1fgk_BIN == 100 )
				$q1fgk_BIN = 99;
			
			if ( $q2fgk_BIN < 60 )
				$q2fgk_BIN = 60;
			else if ( $q2fgk_BIN == 100 )
				$q2fgk_BIN = 99;
			
			if ( $q1fgs_BIN < 60 )
				$q1fgs_BIN = 60;
			else if ( $q1fgs_BIN == 100 )
				$q1fgs_BIN = 99;
			
			if ( $q2fgs_BIN < 60 )
				$q2fgs_BIN = 60;
			else if ( $q2fgs_BIN == 100 )
				$q2fgs_BIN = 99;
			//AKHIR BUATAN BARU
			
			$kf_BIN = number_format( ($q1fgk_BIN+$q2fgk_BIN)/2 ,0,',','.');
			$sf_BIN = number_format( ($q1fgs_BIN+$q2fgs_BIN)/2 ,0,',','.');
			$av_BIN = number_format( ($kf_BIN+$sf_BIN)/2 ,0,',','.');
			$q2aff_BIN=$dat_BIN['aff'.$sms.$midtrm];//q2//.'1'.'2'
			
			//AWAL BUATAN BARU
			if ( $q2aff_BIN >= 90.00 AND $q2aff_BIN <= 100.00 )
				$lg7_BIN = 'A';
			else if ( $q2aff_BIN >= 80.00 AND $q2aff_BIN <= 89.99 )
				$lg7_BIN = 'B';
			else if ( $q2aff_BIN >= 70.00 AND $q2aff_BIN <= 79.99 )
				$lg7_BIN = 'C';
			else if ( $q2aff_BIN >= 0.00 AND $q2aff_BIN <= 69.99 )
				$lg7_BIN = 'D';
			else
				$lg7_BIN = 'ERR';
			//AKHIR BUATAN BARU
			
			
			
			//MTH
			$qry_MTH ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='MTH'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_MTH=mysql_query($qry_MTH) or die('Query gagal');
			$dat_MTH=mysql_fetch_array($rsl_MTH);
			
			$q1fgk_MTH=$dat_MTH['fgk'.'2'.'1'];//q1
			$q2fgk_MTH=$dat_MTH['fgk'.'2'.'2'];//q2
			
			$q1fgs_MTH=$dat_MTH['fgs'.'2'.'1'];//q1
			$q2fgs_MTH=$dat_MTH['fgs'.'2'.'2'];//q2
			
			//AWAL BUATAN BARU
			if ( $q1fgk_MTH < 60 )
				$q1fgk_MTH = 60;
			else if ( $q1fgk_MTH == 100 )
				$q1fgk_MTH = 99;
			
			if ( $q2fgk_MTH < 60 )
				$q2fgk_MTH = 60;
			else if ( $q2fgk_MTH == 100 )
				$q2fgk_MTH = 99;
			
			if ( $q1fgs_MTH < 60 )
				$q1fgs_MTH = 60;
			else if ( $q1fgs_MTH == 100 )
				$q1fgs_MTH = 99;
			
			if ( $q2fgs_MTH < 60 )
				$q2fgs_MTH = 60;
			else if ( $q2fgs_MTH == 100 )
				$q2fgs_MTH = 99;
			//AKHIR BUATAN BARU
			
			$kf_MTH = number_format( ($q1fgk_MTH+$q2fgk_MTH)/2 ,0,',','.');
			$sf_MTH = number_format( ($q1fgs_MTH+$q2fgs_MTH)/2 ,0,',','.');
			$av_MTH = number_format( ($kf_MTH+$sf_MTH)/2 ,0,',','.');
			$q2aff_MTH=$dat_MTH['aff'.$sms.$midtrm];//q2//.'1'.'2'
			
			//AWAL BUATAN BARU
			if ( $q2aff_MTH >= 90.00 AND $q2aff_MTH <= 100.00 )
				$lg7_MTH = 'A';
			else if ( $q2aff_MTH >= 80.00 AND $q2aff_MTH <= 89.99 )
				$lg7_MTH = 'B';
			else if ( $q2aff_MTH >= 70.00 AND $q2aff_MTH <= 79.99 )
				$lg7_MTH = 'C';
			else if ( $q2aff_MTH >= 0.00 AND $q2aff_MTH <= 69.99 )
				$lg7_MTH = 'D';
			else
				$lg7_MTH = 'ERR';
			//AKHIR BUATAN BARU
			
			
			
			//SCN
			$qry_SCN ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='SCN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_SCN=mysql_query($qry_SCN) or die('Query gagal');
			$dat_SCN=mysql_fetch_array($rsl_SCN);
			
			$q1fgk_SCN=$dat_SCN['fgk'.'2'.'1'];//q1
			$q2fgk_SCN=$dat_SCN['fgk'.'2'.'2'];//q2
			
			$q1fgs_SCN=$dat_SCN['fgs'.'2'.'1'];//q1
			$q2fgs_SCN=$dat_SCN['fgs'.'2'.'2'];//q2
			
			//AWAL BUATAN BARU
			if ( $q1fgk_SCN < 60 )
				$q1fgk_SCN = 60;
			else if ( $q1fgk_SCN == 100 )
				$q1fgk_SCN = 99;
			
			if ( $q2fgk_SCN < 60 )
				$q2fgk_SCN = 60;
			else if ( $q2fgk_SCN == 100 )
				$q2fgk_SCN = 99;
			
			if ( $q1fgs_SCN < 60 )
				$q1fgs_SCN = 60;
			else if ( $q1fgs_SCN == 100 )
				$q1fgs_SCN = 99;
			
			if ( $q2fgs_SCN < 60 )
				$q2fgs_SCN = 60;
			else if ( $q2fgs_SCN == 100 )
				$q2fgs_SCN = 99;
			//AKHIR BUATAN BARU
			
			$kf_SCN = number_format( ($q1fgk_SCN+$q2fgk_SCN)/2 ,0,',','.');
			$sf_SCN = number_format( ($q1fgs_SCN+$q2fgs_SCN)/2 ,0,',','.');
			$av_SCN = number_format( ($kf_SCN+$sf_SCN)/2 ,0,',','.');
			$q2aff_SCN=$dat_SCN['aff'.$sms.$midtrm];//q2//.'1'.'2'
			
			//AWAL BUATAN BARU
			if ( $q2aff_SCN >= 90.00 AND $q2aff_SCN <= 100.00 )
				$lg7_SCN = 'A';
			else if ( $q2aff_SCN >= 80.00 AND $q2aff_SCN <= 89.99 )
				$lg7_SCN = 'B';
			else if ( $q2aff_SCN >= 70.00 AND $q2aff_SCN <= 79.99 )
				$lg7_SCN = 'C';
			else if ( $q2aff_SCN >= 0.00 AND $q2aff_SCN <= 69.99 )
				$lg7_SCN = 'D';
			else
				$lg7_SCN = 'ERR';
			//AKHIR BUATAN BARU
			
			
			
			//SCLS
			$qry_SCLS ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='SCLS'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_SCLS=mysql_query($qry_SCLS) or die('Query gagal');
			$dat_SCLS=mysql_fetch_array($rsl_SCLS);
			
			$q1fgk_SCLS=$dat_SCLS['fgk'.'2'.'1'];//q1
			$q2fgk_SCLS=$dat_SCLS['fgk'.'2'.'2'];//q2
			
			$q1fgs_SCLS=$dat_SCLS['fgs'.'2'.'1'];//q1
			$q2fgs_SCLS=$dat_SCLS['fgs'.'2'.'2'];//q2
			
			//AWAL BUATAN BARU
			if ( $q1fgk_SCLS < 60 )
				$q1fgk_SCLS = 60;
			else if ( $q1fgk_SCLS == 100 )
				$q1fgk_SCLS = 99;
			
			if ( $q2fgk_SCLS < 60 )
				$q2fgk_SCLS = 60;
			else if ( $q2fgk_SCLS == 100 )
				$q2fgk_SCLS = 99;
			
			if ( $q1fgs_SCLS < 60 )
				$q1fgs_SCLS = 60;
			else if ( $q1fgs_SCLS == 100 )
				$q1fgs_SCLS = 99;
			
			if ( $q2fgs_SCLS < 60 )
				$q2fgs_SCLS = 60;
			else if ( $q2fgs_SCLS == 100 )
				$q2fgs_SCLS = 99;
			//AKHIR BUATAN BARU
			
			$kf_SCLS = number_format( ($q1fgk_SCLS+$q2fgk_SCLS)/2 ,0,',','.');
			$sf_SCLS = number_format( ($q1fgs_SCLS+$q2fgs_SCLS)/2 ,0,',','.');
			$av_SCLS = number_format( ($kf_SCLS+$sf_SCLS)/2 ,0,',','.');
			$q2aff_SCLS=$dat_SCLS['aff'.$sms.$midtrm];//q2//.'1'.'2'
			
			//AWAL BUATAN BARU
			if ( $q2aff_SCLS >= 90.00 AND $q2aff_SCLS <= 100.00 )
				$lg7_SCLS = 'A';
			else if ( $q2aff_SCLS >= 80.00 AND $q2aff_SCLS <= 89.99 )
				$lg7_SCLS = 'B';
			else if ( $q2aff_SCLS >= 70.00 AND $q2aff_SCLS <= 79.99 )
				$lg7_SCLS = 'C';
			else if ( $q2aff_SCLS >= 0.00 AND $q2aff_SCLS <= 69.99 )
				$lg7_SCLS = 'D';
			else
				$lg7_SCLS = 'ERR';
			//AKHIR BUATAN BARU
			
			
			
			//ART
			$qry_ART ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='ART'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_ART=mysql_query($qry_ART) or die('Query gagal');
			$dat_ART=mysql_fetch_array($rsl_ART);
			
			$q1fgk_ART=$dat_ART['fgk'.'2'.'1'];//q1
			$q2fgk_ART=$dat_ART['fgk'.'2'.'2'];//q2
			
			$q1fgs_ART=$dat_ART['fgs'.'2'.'1'];//q1
			$q2fgs_ART=$dat_ART['fgs'.'2'.'2'];//q2
			
			//AWAL BUATAN BARU
			if ( $q1fgk_ART < 60 )
				$q1fgk_ART = 60;
			else if ( $q1fgk_ART == 100 )
				$q1fgk_ART = 99;
			
			if ( $q2fgk_ART < 60 )
				$q2fgk_ART = 60;
			else if ( $q2fgk_ART == 100 )
				$q2fgk_ART = 99;
			
			if ( $q1fgs_ART < 60 )
				$q1fgs_ART = 60;
			else if ( $q1fgs_ART == 100 )
				$q1fgs_ART = 99;
			
			if ( $q2fgs_ART < 60 )
				$q2fgs_ART = 60;
			else if ( $q2fgs_ART == 100 )
				$q2fgs_ART = 99;
			//AKHIR BUATAN BARU
			
			$kf_ART = number_format( ($q1fgk_ART+$q2fgk_ART)/2 ,0,',','.');
			$sf_ART = number_format( ($q1fgs_ART+$q2fgs_ART)/2 ,0,',','.');
			$av_ART = number_format( ($kf_ART+$sf_ART)/2 ,0,',','.');
			$q2aff_ART=$dat_ART['aff'.$sms.$midtrm];//q2//.'1'.'2'
			
			//AWAL BUATAN BARU
			if ( $q2aff_ART >= 90.00 AND $q2aff_ART <= 100.00 )
				$lg7_ART = 'A';
			else if ( $q2aff_ART >= 80.00 AND $q2aff_ART <= 89.99 )
				$lg7_ART = 'B';
			else if ( $q2aff_ART >= 70.00 AND $q2aff_ART <= 79.99 )
				$lg7_ART = 'C';
			else if ( $q2aff_ART >= 0.00 AND $q2aff_ART <= 69.99 )
				$lg7_ART = 'D';
			else
				$lg7_ART = 'ERR';
			//AKHIR BUATAN BARU
			
			
			
			//PE
			$qry_PE ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='PE'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_PE=mysql_query($qry_PE) or die('Query gagal');
			$dat_PE=mysql_fetch_array($rsl_PE);
			
			$q1fgk_PE=$dat_PE['fgk'.'2'.'1'];//q1
			$q2fgk_PE=$dat_PE['fgk'.'2'.'2'];//q2
			
			$q1fgs_PE=$dat_PE['fgs'.'2'.'1'];//q1
			$q2fgs_PE=$dat_PE['fgs'.'2'.'2'];//q2
			
			//AWAL BUATAN BARU
			if ( $q1fgk_PE < 60 )
				$q1fgk_PE = 60;
			else if ( $q1fgk_PE == 100 )
				$q1fgk_PE = 99;
			
			if ( $q2fgk_PE < 60 )
				$q2fgk_PE = 60;
			else if ( $q2fgk_PE == 100 )
				$q2fgk_PE = 99;
			
			if ( $q1fgs_PE < 60 )
				$q1fgs_PE = 60;
			else if ( $q1fgs_PE == 100 )
				$q1fgs_PE = 99;
			
			if ( $q2fgs_PE < 60 )
				$q2fgs_PE = 60;
			else if ( $q2fgs_PE == 100 )
				$q2fgs_PE = 99;
			//AKHIR BUATAN BARU
			
			$kf_PE = number_format( ($q1fgk_PE+$q2fgk_PE)/2 ,0,',','.');
			$sf_PE = number_format( ($q1fgs_PE+$q2fgs_PE)/2 ,0,',','.');
			$av_PE = number_format( ($kf_PE+$sf_PE)/2 ,0,',','.');
			$q2aff_PE=$dat_PE['aff'.$sms.$midtrm];//q2//.'1'.'2'
			
			//AWAL BUATAN BARU
			if ( $q2aff_PE >= 90.00 AND $q2aff_PE <= 100.00 )
				$lg7_PE = 'A';
			else if ( $q2aff_PE >= 80.00 AND $q2aff_PE <= 89.99 )
				$lg7_PE = 'B';
			else if ( $q2aff_PE >= 70.00 AND $q2aff_PE <= 79.99 )
				$lg7_PE = 'C';
			else if ( $q2aff_PE >= 0.00 AND $q2aff_PE <= 69.99 )
				$lg7_PE = 'D';
			else
				$lg7_PE = 'ERR';
			//AKHIR BUATAN BARU
			
			
			
			//ENG
			$qry_ENG ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='ENG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_ENG=mysql_query($qry_ENG) or die('Query gagal');
			$dat_ENG=mysql_fetch_array($rsl_ENG);
			
			$q1fgk_ENG=$dat_ENG['fgk'.'2'.'1'];//q1
			$q2fgk_ENG=$dat_ENG['fgk'.'2'.'2'];//q2
			
			$q1fgs_ENG=$dat_ENG['fgs'.'2'.'1'];//q1
			$q2fgs_ENG=$dat_ENG['fgs'.'2'.'2'];//q2
			
			//AWAL BUATAN BARU
			if ( $q1fgk_ENG < 60 )
				$q1fgk_ENG = 60;
			else if ( $q1fgk_ENG == 100 )
				$q1fgk_ENG = 99;
			
			if ( $q2fgk_ENG < 60 )
				$q2fgk_ENG = 60;
			else if ( $q2fgk_ENG == 100 )
				$q2fgk_ENG = 99;
			
			if ( $q1fgs_ENG < 60 )
				$q1fgs_ENG = 60;
			else if ( $q1fgs_ENG == 100 )
				$q1fgs_ENG = 99;
			
			if ( $q2fgs_ENG < 60 )
				$q2fgs_ENG = 60;
			else if ( $q2fgs_ENG == 100 )
				$q2fgs_ENG = 99;
			//AKHIR BUATAN BARU
			
			$kf_ENG = number_format( ($q1fgk_ENG+$q2fgk_ENG)/2 ,0,',','.');
			$sf_ENG = number_format( ($q1fgs_ENG+$q2fgs_ENG)/2 ,0,',','.');
			$av_ENG = number_format( ($kf_ENG+$sf_ENG)/2 ,0,',','.');
			$q2aff_ENG=$dat_ENG['aff'.$sms.$midtrm];//q2//.'1'.'2'
			
			//AWAL BUATAN BARU
			if ( $q2aff_ENG >= 90.00 AND $q2aff_ENG <= 100.00 )
				$lg7_ENG = 'A';
			else if ( $q2aff_ENG >= 80.00 AND $q2aff_ENG <= 89.99 )
				$lg7_ENG = 'B';
			else if ( $q2aff_ENG >= 70.00 AND $q2aff_ENG <= 79.99 )
				$lg7_ENG = 'C';
			else if ( $q2aff_ENG >= 0.00 AND $q2aff_ENG <= 69.99 )
				$lg7_ENG = 'D';
			else
				$lg7_ENG = 'ERR';
			//AKHIR BUATAN BARU
			
			
			
			//MND
			$qry_MND ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='MND'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_MND=mysql_query($qry_MND) or die('Query gagal');
			$dat_MND=mysql_fetch_array($rsl_MND);
			
			$q1fgk_MND=$dat_MND['fgk'.'2'.'1'];//q1
			$q2fgk_MND=$dat_MND['fgk'.'2'.'2'];//q2
			
			$q1fgs_MND=$dat_MND['fgs'.'2'.'1'];//q1
			$q2fgs_MND=$dat_MND['fgs'.'2'.'2'];//q2
			
			//AWAL BUATAN BARU
			if ( $q1fgk_MND < 60 )
				$q1fgk_MND = 60;
			else if ( $q1fgk_MND == 100 )
				$q1fgk_MND = 99;
			
			if ( $q2fgk_MND < 60 )
				$q2fgk_MND = 60;
			else if ( $q2fgk_MND == 100 )
				$q2fgk_MND = 99;
			
			if ( $q1fgs_MND < 60 )
				$q1fgs_MND = 60;
			else if ( $q1fgs_MND == 100 )
				$q1fgs_MND = 99;
			
			if ( $q2fgs_MND < 60 )
				$q2fgs_MND = 60;
			else if ( $q2fgs_MND == 100 )
				$q2fgs_MND = 99;
			//AKHIR BUATAN BARU
			
			$kf_MND = number_format( ($q1fgk_MND+$q2fgk_MND)/2 ,0,',','.');
			$sf_MND = number_format( ($q1fgs_MND+$q2fgs_MND)/2 ,0,',','.');
			$av_MND = number_format( ($kf_MND+$sf_MND)/2 ,0,',','.');
			$q2aff_MND=$dat_MND['aff'.$sms.$midtrm];//q2//.'1'.'2'
			
			//AWAL BUATAN BARU
			if ( $q2aff_MND >= 90.00 AND $q2aff_MND <= 100.00 )
				$lg7_MND = 'A';
			else if ( $q2aff_MND >= 80.00 AND $q2aff_MND <= 89.99 )
				$lg7_MND = 'B';
			else if ( $q2aff_MND >= 70.00 AND $q2aff_MND <= 79.99 )
				$lg7_MND = 'C';
			else if ( $q2aff_MND >= 0.00 AND $q2aff_MND <= 69.99 )
				$lg7_MND = 'D';
			else
				$lg7_MND = 'ERR';
			//AKHIR BUATAN BARU
			
			
			
			//COM
			$qry_COM ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='COM'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_COM=mysql_query($qry_COM) or die('Query gagal');
			$dat_COM=mysql_fetch_array($rsl_COM);
			
			$q1fgk_COM=$dat_COM['fgk'.'2'.'1'];//q1
			$q2fgk_COM=$dat_COM['fgk'.'2'.'2'];//q2
			
			$q1fgs_COM=$dat_COM['fgs'.'2'.'1'];//q1
			$q2fgs_COM=$dat_COM['fgs'.'2'.'2'];//q2
			
			//AWAL BUATAN BARU
			if ( $q1fgk_COM < 60 )
				$q1fgk_COM = 60;
			else if ( $q1fgk_COM == 100 )
				$q1fgk_COM = 99;
			
			if ( $q2fgk_COM < 60 )
				$q2fgk_COM = 60;
			else if ( $q2fgk_COM == 100 )
				$q2fgk_COM = 99;
			
			if ( $q1fgs_COM < 60 )
				$q1fgs_COM = 60;
			else if ( $q1fgs_COM == 100 )
				$q1fgs_COM = 99;
			
			if ( $q2fgs_COM < 60 )
				$q2fgs_COM = 60;
			else if ( $q2fgs_COM == 100 )
				$q2fgs_COM = 99;
			//AKHIR BUATAN BARU
			
			$kf_COM = number_format( ($q1fgk_COM+$q2fgk_COM)/2 ,0,',','.');
			$sf_COM = number_format( ($q1fgs_COM+$q2fgs_COM)/2 ,0,',','.');
			$av_COM = number_format( ($kf_COM+$sf_COM)/2 ,0,',','.');
			$q2aff_COM=$dat_COM['aff'.$sms.$midtrm];//q2//.'1'.'2'
			
			//AWAL BUATAN BARU
			if ( $q2aff_COM >= 90.00 AND $q2aff_COM <= 100.00 )
				$lg7_COM = 'A';
			else if ( $q2aff_COM >= 80.00 AND $q2aff_COM <= 89.99 )
				$lg7_COM = 'B';
			else if ( $q2aff_COM >= 70.00 AND $q2aff_COM <= 79.99 )
				$lg7_COM = 'C';
			else if ( $q2aff_COM >= 0.00 AND $q2aff_COM <= 69.99 )
				$lg7_COM = 'D';
			else
				$lg7_COM = 'ERR';
			//AKHIR BUATAN BARU
			
			
			
			//AWAL BUATAN BARU
			$str_vis_d = '';
			
			if( ($kdekls=='P-1A' AND $kdeplj=='COM') OR ($kdekls=='P-1B' AND $kdeplj=='COM') OR ($kdekls=='P-1C' AND $kdeplj=='COM') OR ($kdekls=='P-1D' AND $kdeplj=='COM') )
			{
				$str_vis_d = 'hidden';
			}
			else
			{
				$str_vis_d = 'visible';
			}
			//AKHIR BUATAN BARU
			
			
			
			echo"
				<tr>
					<td align='right'>1</td>
					<td>Religion and Character Education</td>
					<td align='center' width='6.5%'>
						$q1fgk_RLG
					</td>
					<td align='center' width='6.5%'>
						$q2fgk_RLG
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$kf_RLG
					</td>
					<td align='center' width='6.5%'>
						$q1fgs_RLG
					</td>
					<td align='center' width='6.5%'>
						$q2fgs_RLG
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$sf_RLG
					</td>
					<td align='center' width='6.5%' bgcolor='yellow'>
						$av_RLG
					</td>
					<td align='center'>
						$lg7_RLG
					</td>
				</tr>
				
				
				
				<tr>
					<td align='right'>2</td>
					<td>Pancasila and Civic Education</td>
					<td align='center' width='6.5%'>
						$q1fgk_CME
					</td>
					<td align='center' width='6.5%'>
						$q2fgk_CME
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$kf_CME
					</td>
					<td align='center' width='6.5%'>
						$q1fgs_CME
					</td>
					<td align='center' width='6.5%'>
						$q2fgs_CME
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$sf_CME
					</td>
					<td align='center' width='6.5%' bgcolor='yellow'>
						$av_CME
					</td>
					<td align='center'>
						$lg7_CME
					</td>
				</tr>
				
				
				
				<tr>
					<td align='right'>3</td>
					<td>Bahasa Indonesia</td>
					<td align='center' width='6.5%'>
						$q1fgk_BIN
					</td>
					<td align='center' width='6.5%'>
						$q2fgk_BIN
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$kf_BIN
					</td>
					<td align='center' width='6.5%'>
						$q1fgs_BIN
					</td>
					<td align='center' width='6.5%'>
						$q2fgs_BIN
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$sf_BIN
					</td>
					<td align='center' width='6.5%' bgcolor='yellow'>
						$av_BIN
					</td>
					<td align='center'>
						$lg7_BIN
					</td>
				</tr>
				
				
				
				<tr>
					<td align='right'>4</td>
					<td>Mathematics</td>
					<td align='center' width='6.5%'>
						$q1fgk_MTH
					</td>
					<td align='center' width='6.5%'>
						$q2fgk_MTH
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$kf_MTH
					</td>
					<td align='center' width='6.5%'>
						$q1fgs_MTH
					</td>
					<td align='center' width='6.5%'>
						$q2fgs_MTH
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$sf_MTH
					</td>
					<td align='center' width='6.5%' bgcolor='yellow'>
						$av_MTH
					</td>
					<td align='center'>
						$lg7_MTH
					</td>
				</tr>
				
				
				
				<tr>
					<td align='right'>5</td>
					<td>General Science</td>
					<td align='center' width='6.5%'>
						$q1fgk_SCN
					</td>
					<td align='center' width='6.5%'>
						$q2fgk_SCN
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$kf_SCN
					</td>
					<td align='center' width='6.5%'>
						$q1fgs_SCN
					</td>
					<td align='center' width='6.5%'>
						$q2fgs_SCN
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$sf_SCN
					</td>
					<td align='center' width='6.5%' bgcolor='yellow'>
						$av_SCN
					</td>
					<td align='center'>
						$lg7_SCN
					</td>
				</tr>
				
				
				
				<tr>
					<td align='right'>6</td>
					<td>Social Studies</td>
					<td align='center' width='6.5%'>
						$q1fgk_SCLS
					</td>
					<td align='center' width='6.5%'>
						$q2fgk_SCLS
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$kf_SCLS
					</td>
					<td align='center' width='6.5%'>
						$q1fgs_SCLS
					</td>
					<td align='center' width='6.5%'>
						$q2fgs_SCLS
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$sf_SCLS
					</td>
					<td align='center' width='6.5%' bgcolor='yellow'>
						$av_SCLS
					</td>
					<td align='center'>
						$lg7_SCLS
					</td>
				</tr>
				
				
				
				<tr>
					<td align='right'>7</td>
					<td>Cultural Art and Music</td>
					<td align='center' width='6.5%'>
						$q1fgk_ART
					</td>
					<td align='center' width='6.5%'>
						$q2fgk_ART
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$kf_ART
					</td>
					<td align='center' width='6.5%'>
						$q1fgs_ART
					</td>
					<td align='center' width='6.5%'>
						$q2fgs_ART
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$sf_ART
					</td>
					<td align='center' width='6.5%' bgcolor='yellow'>
						$av_ART
					</td>
					<td align='center'>
						$lg7_ART
					</td>
				</tr>
				
				
				
				<tr>
					<td align='right'>8</td>
					<td>Physical Education & Health</td>
					<td align='center' width='6.5%'>
						$q1fgk_PE
					</td>
					<td align='center' width='6.5%'>
						$q2fgk_PE
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$kf_PE
					</td>
					<td align='center' width='6.5%'>
						$q1fgs_PE
					</td>
					<td align='center' width='6.5%'>
						$q2fgs_PE
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$sf_PE
					</td>
					<td align='center' width='6.5%' bgcolor='yellow'>
						$av_PE
					</td>
					<td align='center'>
						$lg7_PE
					</td>
				</tr>
				
				
				
				<tr>
					<td align='right'>9</td>
					<td>English</td>
					<td align='center' width='6.5%'>
						$q1fgk_ENG
					</td>
					<td align='center' width='6.5%'>
						$q2fgk_ENG
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$kf_ENG
					</td>
					<td align='center' width='6.5%'>
						$q1fgs_ENG
					</td>
					<td align='center' width='6.5%'>
						$q2fgs_ENG
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$sf_ENG
					</td>
					<td align='center' width='6.5%' bgcolor='yellow'>
						$av_ENG
					</td>
					<td align='center'>
						$lg7_ENG
					</td>
				</tr>
				
				
				
				<tr>
					<td align='right'>10</td>
					<td>Mandarin</td>
					<td align='center' width='6.5%'>
						$q1fgk_MND
					</td>
					<td align='center' width='6.5%'>
						$q2fgk_MND
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$kf_MND
					</td>
					<td align='center' width='6.5%'>
						$q1fgs_MND
					</td>
					<td align='center' width='6.5%'>
						$q2fgs_MND
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$sf_MND
					</td>
					<td align='center' width='6.5%' bgcolor='yellow'>
						$av_MND
					</td>
					<td align='center'>
						$lg7_MND
					</td>
				</tr>
				
				
				
				<tr style='visibility: $str_vis_d'>
					<td align='right'>11</td>
					<td>Computer Education</td>
					<td align='center' width='6.5%'>
						$q1fgk_COM
					</td>
					<td align='center' width='6.5%'>
						$q2fgk_COM
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$kf_COM
					</td>
					<td align='center' width='6.5%'>
						$q1fgs_COM
					</td>
					<td align='center' width='6.5%'>
						$q2fgs_COM
					</td>
					<td align='center' width='6.5%' bgcolor='lightgrey'>
						$sf_COM
					</td>
					<td align='center' width='6.5%' bgcolor='yellow'>
						$av_COM
					</td>
					<td align='center'>
						$lg7_COM
					</td>
				</tr>
			";
			//AKHIR BAUTAN BARU
	
	
	
	//AWAL BUATAN BARU
		echo"
					
			</table>
			
			<br/>
			
			<b>EXTRACURRICULAR</b>
			<table width='100%' border='1' style='border-collapse: collapse;'>
				<tr>
					<th width='4%'>
						No
					</th>
					<th width='46%'>
						Activity
					</th>
					<th>
						Remarks
					</th>
				</tr>
				";
				
				//
				$nmaWaj_d='';
				$ktrWaj_d='';
				
				$query1	="	SELECT 		t_extcrrps.*, t_mstplj.nmaplj
							FROM 		t_extcrrps
							INNER JOIN	t_mstplj
							ON			t_mstplj.kdeplj = t_extcrrps.kdeplj
							WHERE		t_extcrrps.nis='$nis' "; 
										// extra kurikuler
				$result1=mysql_query($query1) or die('Query gagal1');
				$i = 1;
				while($data1 =mysql_fetch_array($result1))
				{
					$cell[$i][0]=$data1[nmaplj];
					$cell[$i][1]=$data1['ext'.$sms.$midtrm];
					$ktrWaj_d=$cell[$i][0];
					$nmaWaj_d=$cell[$i][1];
					
					if ( $ktrWaj_d == 'Pramuka' )
					{
						if ( $nmaWaj_d == 'A' )
							$nmaWaj_d = 'Regularly attends the scout activities well and show enthusiasm in learning the scout material provided by coaches.';
						else if ( $nmaWaj_d == 'B' )
							$nmaWaj_d = 'Able to take part in all scout activities taught by the coaches actively participate in various activities in groups or teams.';
						else if ( $nmaWaj_d == 'C' )
							$nmaWaj_d = 'Sometimes following all the scout activities taught by the coaches and participatng in group or team activities.';
						else
							$nmaWaj_d = '';
					}
					else //if ( $ktrWaj_d != 'Pramuka' )
					{
						if ( $nmaWaj_d == 'A' )
							$nmaWaj_d = 'Regularly attends and actively participates in school activities and shows great enthusiasm in performing school activities. ';
						else if ( $nmaWaj_d == 'B' )
							$nmaWaj_d = 'Participates in the activities, shows cooperation and shows enthusiasm and volunteer to help.';
						else if ( $nmaWaj_d == 'C' )
							$nmaWaj_d = 'Sometimes not attending activities and shows cooperation but is inconsistent.';
						else
							$nmaWaj_d = '';
					}
					
					echo"
						<tr>
							<td align='center'>
								$i
							</td>
							<td>
								$ktrWaj_d
							</td>
							<td align='justify'>
								$nmaWaj_d
							</td>
						</tr>
					";
					
					$i++;
				}
				
				
				
				//absences
				$qABS	="	SELECT 		t_hdrkmnps.*
							FROM 		t_hdrkmnps
							WHERE		t_hdrkmnps.nis='$nis'  "; 
							// menghasilka nilai kehadiran
				$rABS=mysql_query($qABS) or die('Query gagal40');
				$dABS =mysql_fetch_array($rABS);
				
				$q1SKT=$dABS['skt'.$sms.$midtrm]; // q1 skt
				$q1IZN=$dABS['izn'.$sms.$midtrm]; // q1 izn
				$q1ALP=$dABS['alp'.$sms.$midtrm]; // q1 alp
				
				if($q1SKT==0)
					$q1SKT='-';
				if($q1IZN==0)
					$q1IZN='-';
				if($q1ALP==0)
					$q1ALP='-';
	
	
	
		echo"		<tr>
						<td align='center'>
							<br/>
						</td>
						<td>
							
						</td>
						<td align='justify'>
							
						</td>
					</tr>
					<tr>
						<td align='center'>
							<br/>
						</td>
						<td>
							
						</td>
						<td align='justify'>
							
						</td>
					</tr>	
				</table>
				
				<br/>
				
				<table width='100%'>
					<tr>
						<td width='50%' valign='top'>
							<b>ATTENDANCE</b>
							<table width='100%' border='1' style='border-collapse: collapse;'>
								<tr>
									<th align='center'>
										No
									</th>
									<th align='center'>
										Remarks
									</th>
									<th align='center'>
										Day(s)
									</th>
								</tr>
								<tr>
									<td align='center'>
										1
									</td>
									<td align='left'>
										ABSENCE DUE TO SICKNESS
									</td>
									<td align='center'>
										$q1SKT
									</td>
								</tr>
								<tr>
									<td align='center'>
										2
									</td>
									<td align='left'>
										EXCUSED ABSENCE
									</td>
									<td align='center'>
										$q1IZN
									</td>
								</tr>
								<tr>
									<td align='center'>
										3
									</td>
									<td align='left'>
										UNEXCUSED ABSENCE
									</td>
									<td align='center'>
										$q1ALP
									</td>
								</tr>
							</table>
						</td>
						<td width='50%' valign='top'>
							<b>RATING SCALES</b>
							<table width='100%' border='1' style='border-collapse: collapse;'>
								<tr>
									<th align='center'>
										Mark
									</th>
									<th align='center'>
										Grade
									</th>
									<th align='center'>
										Category
									</th>
								</tr>
								<tr>
									<td align='center'>
										90.00 - 100.00
									</td>
									<td align='center'>
										A
									</td>
									<td align='center'>
										Excellent
									</td>
								</tr>
								<tr>
									<td align='center'>
										80.00 - 89.99
									</td>
									<td align='center'>
										B
									</td>
									<td align='center'>
										Exceeds Expectations
									</td>
								</tr>
								<tr>
									<td align='center'>
										70.00 - 79.99
									</td>
									<td align='center'>
										C
									</td>
									<td align='center'>
										Meets Expectations
									</td>
								</tr>
								<tr>
									<td align='center'>
										0.00 - 69.99
									</td>
									<td align='center'>
										D
									</td>
									<td align='center'>
										Needs Expectations
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				
				<br/>
				
				<table width='100%'>
					<tr>
						<td width='40%' valign='top'>
							Jakarta, $tglctk<br/>
							Homeroom Teacher<br/>
							
							<br/><br/><br/>
							
							$wlikls$gelar
						</td>
						<td width='45%' valign='top'>
							<br/>
							Principal<br/>
							
							<br/><br/><br/>
							
							$kplskl, S. Fil
						</td>
						<td width='15%' valign='top'>
							<br/>
							Parents<br/>
							
							<br/><br/><br/>
							
							.....................
						</td>
					</tr>
				</table>
				
				</div>
				
			</div>
		";
	//AKHIR BUATAN BARU
	
	//..
	
		
	
	//..
	
	
	
	/*$pdf->Ln(0.35);
	$pdf->SetFont('Arial','',12);
	//$pdf->Cell( 1.25	,0.6,'',0,0,L);
	$pdf->Cell( 19.8,0.6,'EXTRA-CURRICULAR ACTIVITY PERFORMANCE','LRTB',0,C,true);//+1.5
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	//$pdf->Cell( 1.25	,0.6,'',0,0,L);
	$pdf->Cell( 6.8	,0.6,'ACTIVITY','LRTB',0,C,true);
	$pdf->Cell( 13	,0.6,'REMARKS','LRTB',0,C,true);*/
	
	/*$nmaWaj='';
	$ktrWaj='';*/
	
	//pramuka wajib
	/*$qPMK	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND 
							
							t_extcrrps.kdeplj='PMK' "; // extra kurikuler
	$rPMK=mysql_query($qPMK) or die('Query gagal40');
	$dPMK =mysql_fetch_array($rPMK);
	$q1PMK=$dPMK['ext'.$sms.$midtrm];*/ // q1 PMK
	
	/*if($q1PMK!='')
	{
		$nmaWaj='Praja Muda Karana (Pramuka)';
		
		if($q1PMK=='A+')
			$ktrWaj='Shows leadership and actively participate in performing school activities.';
		else if($q1PMK=='A')
			$ktrWaj='Regularly attends and actively participates in school          activities and shows great enthusiasm in performing school   activities.';
		else if($q1PMK=='A/A')
			$ktrWaj='Regularly attends and actively participates in school activities, demonstrates helpfulness and cooperation in performing activities.';
		else if($q1PMK=='B')
			$ktrWaj='Shows enthusiasm and volunteer to help but sometimes absent in activities  and participates in the activities with teachers supervision.';
		else if($q1PMK=='B/B')
			$ktrWaj='Participates in the activities, shows cooperation and show enthusiasm and volunteer to help.';
		else if($q1PMK=='C')
			$ktrWaj='Sometimes not attending activities and cooperation but is      inconsistent.';
		else //if($q1PMK=='-')
			$ktrWaj='-';
	}*/
	
	//karate
	/*$qKAR	="	SELECT 		t_extcrrps.*
				FROM 		t_extcrrps
				WHERE		t_extcrrps.nis='$nis'	AND 
							
							t_extcrrps.kdeplj='KAR' "; // extra kurikuler
	$rKAR=mysql_query($qKAR) or die('Query gagal40');
	$dKAR =mysql_fetch_array($rKAR);
	$q1KAR=$dKAR['ext'.$sms.$midtrm];*/ // q1 KAR
	
	/*if($q1KAR!='')
	{
		$nmaWaj='Karate';
		
		if($q1KAR=='A+')
			$ktrWaj='Shows leadership and actively participate in performing school activities.';
		else if($q1KAR=='A')
			$ktrWaj='Regularly attends and actively participates in school          activities and shows great enthusiasm in performing school   activities.';
		else if($q1KAR=='A/A')
			$ktrWaj='Regularly attends and actively participates in school activities, demonstrates helpfulness and cooperation in performing activities.';
		else if($q1KAR=='B')
			$ktrWaj='Shows enthusiasm and volunteer to help but sometimes absent in activities  and participates in the activities with teachers supervision.';
		else if($q1KAR=='B/B')
			$ktrWaj='Participates in the activities, shows cooperation and show enthusiasm and volunteer to help.';
		else if($q1KAR=='C')
			$ktrWaj='Sometimes not attending activities and cooperation but is      inconsistent.';
		else// if($q1KAR=='-')
			$ktrWaj='-';
	}*/
	
	
	
	
	/*$nmaPil='';
	$ktrPil='';*/
	
	
	
	
	
	
	
	
	/*$pdf->Ln();
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1.8,'1','LRTB',0,C,true);
	$pdf->Cell( 6.2	,1.8,$nmaWaj,'LRTB',0,C,true);//'Praja Muda Karana (Pramuka)'
	if( $ktrWaj=='-' )
		$pdf->Cell( 13	,0.6,'','LRT',0,J,true);
	else
		$pdf->Cell( 13	,0.6,substr($ktrWaj,0,63),'LRT',0,J,true);//Regularly attends and actively participates in 
	
	$pdf->Ln();
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1.8,'',0,0,C,false);
	$pdf->Cell( 6.2	,1.8,'',0,0,C,false);
	if( $ktrWaj=='-' )
		$pdf->Cell( 13	,0.6,'-','LR',0,C,true);
	else
		$pdf->Cell( 13	,0.6,substr($ktrWaj,63,61),'LR',0,J,true);//school activities and shows great enthusiasm in 
	
	$pdf->Ln();
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1.8,'',0,0,C,false);
	$pdf->Cell( 6.2	,1.8,'',0,0,C,false);
	$pdf->Cell( 13	,0.6,substr($ktrWaj,124,61),'LRB',0,J,true);//performing school activities
	
	$pdf->Ln();
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1.8,'2','LRTB',0,C,true);
	$pdf->Cell( 6.2	,1.8,$nmaPil,'LRTB',0,C,true);
	$pdf->Cell( 13	,0.6,substr($ktrPil,0,63),'LRT',0,J);
	
	$pdf->Ln();
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1.8,'',0,0,C,false);
	$pdf->Cell( 6.2	,1.8,'',0,0,C,false);
	$pdf->Cell( 13	,0.6,substr($ktrPil,63,61),'LR',0,J);//B 63,63
	
	$pdf->Ln();
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->Cell( 0.6	,1.8,'',0,0,C,false);
	$pdf->Cell( 6.2	,1.8,'',0,0,C,false);
	$pdf->Cell( 13	,0.6,substr($ktrPil,124,61),'LRB',0,J);*/
	
	//..
	
	//$pdf->Ln();
	/*$pdf->Ln(0.85);
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 8.7	,0.6,'ATTENDANCE',LRTB,0,C,true);//7.1
	$pdf->Cell( 3	,0.4,'',0,0,L);
	$pdf->Cell( 2.3	,0.6,'Place/Date:',0,0,L);//1.6
	$pdf->Cell( 6.1 ,0.6,'Jakarta, '.$tglctk,0,0,L,true);*/
	
	//absences
	$qABS	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$nis'  
							 "; // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	
	$q1SKT=$dABS['skt'.'2'.'1']; // q1 skt
	$q1IZN=$dABS['izn'.'2'.'1']; // q1 izn
	$q1ALP=$dABS['alp'.'2'.'1']; // q1 alp
	
	$q2SKT=$dABS['skt'.'2'.'2']; // q2 skt
	$q2IZN=$dABS['izn'.'2'.'2']; // q2 izn
	$q2ALP=$dABS['alp'.'2'.'2']; // q2 alp
	
	$ts1SKT = $q1SKT + $q2SKT;
	$ts1IZN = $q1IZN + $q2IZN;
	$ts1ALP = $q1ALP + $q2ALP;
	
	if($ts1SKT==0)
		$ts1SKT='-';
	if($ts1IZN==0)
		$ts1IZN='-';
	if($ts1ALP==0)
		$ts1ALP='-';
	
	
	
	/*$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->Cell( 6.35,0.6,'ABSENCE DUE TO SICKNESS','LT',0,C,true);//5.35
	$pdf->Cell( 0.25,0.6,' : ','T',0,C,true);
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell( 0.75,0.6,'   '.$ts1SKT.'   ','T',0,C,true);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 1.35,0.6,' day/s  ','RT',0,C,true);//0.75
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->Cell( 6.35,0.6,'EXCUSED ABSENCE','L',0,C,true);
	$pdf->Cell( 0.25,0.6,' : ',0,0,C,true);
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell( 0.75,0.6,'   '.$ts1IZN.'   ',0,0,C,true);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 1.35,0.6,' day/s  ','R',0,C,true);
	$pdf->Cell( 3	,0.4,'',0,0,L);
	$pdf->Cell( 2.3,0.6,'Issued by:',0,0,L);//1.6
	
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->Cell( 6.35,0.6,'UNEXCUSED ABSENCE','LB',0,C,true);
	$pdf->Cell( 0.25,0.6,' : ','B',0,C,true);
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell( 0.75,0.6,'   '.$ts1ALP.'   ','B',0,C,true);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 1.35,0.6,' day/s  ','RB',0,C,true);
	$pdf->Cell( 0.7	,0.6,'',0,0,L);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 7.1	,0.6,'',0,0,C,true);*///'                  '.
	
	//..
	
	/*$pdf->Ln(0.6);//0.5
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,false);
	$pdf->Cell( 3	,0.4,'',0,0,L);
	$pdf->Cell( 2.3,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell( 7.1	,0.6,''.$wlikls.$gelar,0,0,C,true);
	
	$pdf->Ln(0.5);//0.5
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
	$pdf->Cell( 3	,0.4,'',0,0,L);
	$pdf->Cell( 2.3,0.4,'',0,0,L);
	//$pdf->SetFont('Arial','',12);
	$pdf->Cell( 7.1	,0.6,''.'Homeroom Adviser',0,0,C,true);
	
	$pdf->Ln(2);//2
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell( 7.1	,0.4,'                      '.'                  '.'                      ',0,0,L,true);
	$pdf->Cell( 3	,0.4,'',0,0,L);
	$pdf->Cell( 2.3,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell( 7.1	,0.4,'  '.$kplskl.', S.Fil'.'  ',0,0,C,true);
	
	$pdf->Ln();
	//$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 7.1	,0.6,"PARENT'S SIGNATURE",0,0,C,true);
	$pdf->Cell( 3	,0.4,'',0,0,L);
	$pdf->Cell( 2.3,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.6,'PRINCIPAL',0,0,C,true);*/
	
	
	
	//AWAL BUATAN BARU
	echo"
			
			
			
				</table>
			</div>
		</div>
	";
	//AKHIR BUATAN BARU
	
	
	
	$y++;
	
}

/*$pdf->Output();*/

//AWAL BUATAN BARU
echo"
			<!--</font>-->
			<!--</div>-->
    </body>
</html>
";
//AKHIR BUATAN BARU

?>