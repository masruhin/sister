<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04OSD_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar ) rapot mid term sd 4
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
/*
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
*/

$kdekls	=$_POST['kdekls'];
//$nis	=$_POST['nis'];
$sms	=$_POST['sms'];
$midtrm	=$_POST['midtrm'];
$tglctk	=$_POST['tglctk'];

$thnajr	="2020-2021";

if($tglctk=='')
{
	$tglctk	=date('d F Y');
}
else
{	
	$tglctk	=strtotime($tglctk);
	$tglctk	=date('d F Y',$tglctk);
}



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



/*
div.word{
			  font-size: 15px;
			  font-family: 'Times New Roman', Times, serif;
			}
*/



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
		
		/*if($nis!='')
			$nis_x	= $nis;
		else
			$nis_x	=$data2[nis];*/
		
		//$nis_x
		$query3 	="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE 		t_prgrptps_sd.nis='". mysql_escape_string($nis)."' AND 
									
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
		}*/	
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
	/*$cell5[$i][$n+4]=$ttlakh1;
	$cell5[$i][$n+5]=$ttlakh2;
	$cell5[$i][$n+6]=number_format(($ttlakh1+$ttlakh2)/2,0,',','.');
	$cell5[$i][$n+7]=$ttlakh;*/
	$i++;
	
	
	
	//
	
	
	
}
$x=$i;


/*foreach ($cell5 as $key => $row)
{
	$key_arr[$key] = $row[$n+7];
}
array_multisort($key_arr, SORT_DESC, $cell5);*/

/*$y=0;
while($y<$x)
{
	$cell5[$y][3]=$y+1;
	$y++;
}*/

/*foreach ($cell5 as $key => $row)
{
	$key_arr[$key] = $row[1];
}
array_multisort($key_arr, SORT_ASC, $cell5);*/

/*$bghw	=1;
$bgprj	=1;
$bgtes	=1;*/
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
	$tgllhr	=date('d F Y',$tgllhr);
	
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
							
							<tr><td>BIRTHDAY </td><td> : </td><td>$tanggal_lahir $bulan_lahir $tahun_lahir</td></tr>
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
					<th align='center' rowspan='3' width='37%'>
						SUBJECT
					</th>
					<th align='center' rowspan='3' width='10%'>
						Minimum
						<br/>
						Passing
						<br/>
						Score
					</th>
					<th align='center' colspan='6' width='39%'>
						CLASSROOM PERFORMANCE
					</th>
					<th align='center' rowspan='3' width='10%'>
						ATTITUDE
					</th>
				</tr>
				<tr>
					<th align='center' colspan='2' width='13%'>
						KNOWLEDGE
					</th>
					<th align='center' colspan='2' width='13%'>
						SKILLS
					</th>
					<th align='center' colspan='2' width='13%'>
						Average
					</th>
				</tr>
				<tr>
					<th align='center' width='6.5%'>
						Score
					</th>
					<th align='center' width='6.5%'>
						LG
					</th>
					<th align='center' width='6.5%'>
						Score
					</th>
					<th align='center' width='6.5%'>
						LG
					</th>
					<th align='center' width='6.5%'>
						Score
					</th>
					<th align='center' width='6.5%'>
						LG
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
	//$ttlakh=0;
	//$jmlplj=0;
	//$id=$cell[$j][0];
	
	
	
			//RLG
			$qry_RLG ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='RLG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_RLG=mysql_query($qry_RLG) or die('Query gagal');
			$dat_RLG =mysql_fetch_array($rsl_RLG);
			
			$q1STK_RLG=$dat_RLG['fgk'.$sms.$midtrm]; // q1	st	."9"
			$q1STS_RLG=$dat_RLG['fgs'.$sms.$midtrm]; // q1	st_	."9"
			$q1av7_RLG=$dat_RLG['akh'.$sms.$midtrm]; // q1
			
			$q1K_RLG = $q1STK_RLG;
			$q1S_RLG = $q1STS_RLG;
			
			
			
			//AWAL BUATAN BARU
			if ( $q1K_RLG < 60 )
				$q1K_RLG = 60;
			else if ( $q1K_RLG == 100 )
				$q1K_RLG = 99;
			
			if ( $q1S_RLG < 60 )
				$q1S_RLG = 60;
			else if ( $q1S_RLG == 100 )
				$q1S_RLG = 99;
			//AKHIR BUATAN BARU
					
			
			
			$ave1KS_RLG = ( $q1K_RLG + $q1S_RLG ) / 2;
			
			if ( $q1K_RLG >= 90.00 AND $q1K_RLG <= 100.00 )
				$lgK_RLG = 'A';
			else if ( $q1K_RLG >= 80.00 AND $q1K_RLG <= 89.99 )
				$lgK_RLG = 'B';
			else if ( $q1K_RLG >= 70.00 AND $q1K_RLG <= 79.99 )
				$lgK_RLG = 'C';
			else if ( $q1K_RLG >= 0.00 AND $q1K_RLG <= 69.99 )
				$lgK_RLG = 'D';
			else
				$lgK_RLG = 'ERR';
			
			if ( $q1S_RLG >= 90.00 AND $q1S_RLG <= 100.00 )
				$lgS_RLG = 'A';
			else if ( $q1S_RLG >= 80.00 AND $q1S_RLG <= 89.99 )
				$lgS_RLG = 'B';
			else if ( $q1S_RLG >= 70.00 AND $q1S_RLG <= 79.99 )
				$lgS_RLG = 'C';
			else if ( $q1S_RLG >= 0.00 AND $q1S_RLG <= 69.99 )
				$lgS_RLG = 'D';
			else
				$lgS_RLG = 'ERR';
			
			$ave1KS_RLG = number_format( $ave1KS_RLG,2,'.','.');
			
			if ( $ave1KS_RLG >= 90.00 AND $ave1KS_RLG <= 100.00 )
				$lgKS_RLG = 'A';
			else if ( $ave1KS_RLG >= 80.00 AND $ave1KS_RLG <= 89.99 )
				$lgKS_RLG = 'B';
			else if ( $ave1KS_RLG >= 70.00 AND $ave1KS_RLG <= 79.99 )
				$lgKS_RLG = 'C';
			else if ( $ave1KS_RLG >= 0.00 AND $ave1KS_RLG <= 69.99 )
				$lgKS_RLG = 'D';
			else
				$lgKS_RLG = 'ERR';
			
			if ( $q1av7_RLG >= 90.00 AND $q1av7_RLG <= 100.00 )
				$lg7_RLG = 'A';
			else if ( $q1av7_RLG >= 80.00 AND $q1av7_RLG <= 89.99 )
				$lg7_RLG = 'B';
			else if ( $q1av7_RLG >= 70.00 AND $q1av7_RLG <= 79.99 )
				$lg7_RLG = 'C';
			else if ( $q1av7_RLG >= 0.00 AND $q1av7_RLG <= 69.99 )
				$lg7_RLG = 'D';
			else
				$lg7_RLG = 'ERR';
			
			
			
			//CME
			$qry_CME ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='CME'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_CME=mysql_query($qry_CME) or die('Query gagal');
			$dat_CME =mysql_fetch_array($rsl_CME);
			
			$q1STK_CME=$dat_CME['fgk'.$sms.$midtrm]; // q1	st	."9"
			$q1STS_CME=$dat_CME['fgs'.$sms.$midtrm]; // q1	st_	."9"
			$q1av7_CME=$dat_CME['akh'.$sms.$midtrm]; // q1
			
			$q1K_CME = $q1STK_CME;
			$q1S_CME = $q1STS_CME;
			
			
			
			//AWAL BUATAN BARU
			if ( $q1K_CME < 60 )
				$q1K_CME = 60;
			else if ( $q1K_CME == 100 )
				$q1K_CME = 99;
			
			if ( $q1S_CME < 60 )
				$q1S_CME = 60;
			else if ( $q1S_CME == 100 )
				$q1S_CME = 99;
			//AKHIR BUATAN BARU
			
			
			
			$ave1KS_CME = ( $q1K_CME + $q1S_CME ) / 2;
			
			if ( $q1K_CME >= 90.00 AND $q1K_CME <= 100.00 )
				$lgK_CME = 'A';
			else if ( $q1K_CME >= 80.00 AND $q1K_CME <= 89.99 )
				$lgK_CME = 'B';
			else if ( $q1K_CME >= 70.00 AND $q1K_CME <= 79.99 )
				$lgK_CME = 'C';
			else if ( $q1K_CME >= 0.00 AND $q1K_CME <= 69.99 )
				$lgK_CME = 'D';
			else
				$lgK_CME = 'ERR';
			
			if ( $q1S_CME >= 90.00 AND $q1S_CME <= 100.00 )
				$lgS_CME = 'A';
			else if ( $q1S_CME >= 80.00 AND $q1S_CME <= 89.99 )
				$lgS_CME = 'B';
			else if ( $q1S_CME >= 70.00 AND $q1S_CME <= 79.99 )
				$lgS_CME = 'C';
			else if ( $q1S_CME >= 0.00 AND $q1S_CME <= 69.99 )
				$lgS_CME = 'D';
			else
				$lgS_CME = 'ERR';
			
			$ave1KS_CME = number_format( $ave1KS_CME,2,'.','.');
			
			if ( $ave1KS_CME >= 90.00 AND $ave1KS_CME <= 100.00 )
				$lgKS_CME = 'A';
			else if ( $ave1KS_CME >= 80.00 AND $ave1KS_CME <= 89.99 )
				$lgKS_CME = 'B';
			else if ( $ave1KS_CME >= 70.00 AND $ave1KS_CME <= 79.99 )
				$lgKS_CME = 'C';
			else if ( $ave1KS_CME >= 0.00 AND $ave1KS_CME <= 69.99 )
				$lgKS_CME = 'D';
			else
				$lgKS_CME = 'ERR';
			
			if ( $q1av7_CME >= 90.00 AND $q1av7_CME <= 100.00 )
				$lg7_CME = 'A';
			else if ( $q1av7_CME >= 80.00 AND $q1av7_CME <= 89.99 )
				$lg7_CME = 'B';
			else if ( $q1av7_CME >= 70.00 AND $q1av7_CME <= 79.99 )
				$lg7_CME = 'C';
			else if ( $q1av7_CME >= 0.00 AND $q1av7_CME <= 69.99 )
				$lg7_CME = 'D';
			else
				$lg7_CME = 'ERR';
			
			
			
			//BIN
			$qry_BIN ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='BIN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_BIN=mysql_query($qry_BIN) or die('Query gagal');
			$dat_BIN =mysql_fetch_array($rsl_BIN);
			
			$q1STK_BIN=$dat_BIN['fgk'.$sms.$midtrm]; // q1	st	."9"
			$q1STS_BIN=$dat_BIN['fgs'.$sms.$midtrm]; // q1	st_	."9"
			$q1av7_BIN=$dat_BIN['akh'.$sms.$midtrm]; // q1
			
			$q1K_BIN = $q1STK_BIN;
			$q1S_BIN = $q1STS_BIN;
			
			
			
			//AWAL BUATAN BARU
			if ( $q1K_BIN < 60 )
				$q1K_BIN = 60;
			else if ( $q1K_BIN == 100 )
				$q1K_BIN = 99;
			
			if ( $q1S_BIN < 60 )
				$q1S_BIN = 60;
			else if ( $q1S_BIN == 100 )
				$q1S_BIN = 99;
			//AKHIR BUATAN BARU
			
			
			
			$ave1KS_BIN = ( $q1K_BIN + $q1S_BIN ) / 2;
			
			if ( $q1K_BIN >= 90.00 AND $q1K_BIN <= 100.00 )
				$lgK_BIN = 'A';
			else if ( $q1K_BIN >= 80.00 AND $q1K_BIN <= 89.99 )
				$lgK_BIN = 'B';
			else if ( $q1K_BIN >= 70.00 AND $q1K_BIN <= 79.99 )
				$lgK_BIN = 'C';
			else if ( $q1K_BIN >= 0.00 AND $q1K_BIN <= 69.99 )
				$lgK_BIN = 'D';
			else
				$lgK_BIN = 'ERR';
			
			if ( $q1S_BIN >= 90.00 AND $q1S_BIN <= 100.00 )
				$lgS_BIN = 'A';
			else if ( $q1S_BIN >= 80.00 AND $q1S_BIN <= 89.99 )
				$lgS_BIN = 'B';
			else if ( $q1S_BIN >= 70.00 AND $q1S_BIN <= 79.99 )
				$lgS_BIN = 'C';
			else if ( $q1S_BIN >= 0.00 AND $q1S_BIN <= 69.99 )
				$lgS_BIN = 'D';
			else
				$lgS_BIN = 'ERR';
			
			$ave1KS_BIN = number_format( $ave1KS_BIN,2,'.','.');
			
			if ( $ave1KS_BIN >= 90.00 AND $ave1KS_BIN <= 100.00 )
				$lgKS_BIN = 'A';
			else if ( $ave1KS_BIN >= 80.00 AND $ave1KS_BIN <= 89.99 )
				$lgKS_BIN = 'B';
			else if ( $ave1KS_BIN >= 70.00 AND $ave1KS_BIN <= 79.99 )
				$lgKS_BIN = 'C';
			else if ( $ave1KS_BIN >= 0.00 AND $ave1KS_BIN <= 69.99 )
				$lgKS_BIN = 'D';
			else
				$lgKS_BIN = 'ERR';
			
			if ( $q1av7_BIN >= 90.00 AND $q1av7_BIN <= 100.00 )
				$lg7_BIN = 'A';
			else if ( $q1av7_BIN >= 80.00 AND $q1av7_BIN <= 89.99 )
				$lg7_BIN = 'B';
			else if ( $q1av7_BIN >= 70.00 AND $q1av7_BIN <= 79.99 )
				$lg7_BIN = 'C';
			else if ( $q1av7_BIN >= 0.00 AND $q1av7_BIN <= 69.99 )
				$lg7_BIN = 'D';
			else
				$lg7_BIN = 'ERR';
			
			
			
			//MTH
			$qry_MTH ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='MTH'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_MTH=mysql_query($qry_MTH) or die('Query gagal');
			$dat_MTH =mysql_fetch_array($rsl_MTH);
			
			$q1STK_MTH=$dat_MTH['fgk'.$sms.$midtrm]; // q1	st	."9"
			$q1STS_MTH=$dat_MTH['fgs'.$sms.$midtrm]; // q1	st_	."9"
			$q1av7_MTH=$dat_MTH['akh'.$sms.$midtrm]; // q1
			
			$q1K_MTH = $q1STK_MTH;
			$q1S_MTH = $q1STS_MTH;
			
			
			
			//AWAL BUATAN BARU
			if ( $q1K_MTH < 60 )
				$q1K_MTH = 60;
			else if ( $q1K_MTH == 100 )
				$q1K_MTH = 99;
			
			if ( $q1S_MTH < 60 )
				$q1S_MTH = 60;
			else if ( $q1S_MTH == 100 )
				$q1S_MTH = 99;
			//AKHIR BUATAN BARU
			
			
			
			$ave1KS_MTH = ( $q1K_MTH + $q1S_MTH ) / 2;
			
			if ( $q1K_MTH >= 90.00 AND $q1K_MTH <= 100.00 )
				$lgK_MTH = 'A';
			else if ( $q1K_MTH >= 80.00 AND $q1K_MTH <= 89.99 )
				$lgK_MTH = 'B';
			else if ( $q1K_MTH >= 70.00 AND $q1K_MTH <= 79.99 )
				$lgK_MTH = 'C';
			else if ( $q1K_MTH >= 0.00 AND $q1K_MTH <= 69.99 )
				$lgK_MTH = 'D';
			else
				$lgK_MTH = 'ERR';
			
			if ( $q1S_MTH >= 90.00 AND $q1S_MTH <= 100.00 )
				$lgS_MTH = 'A';
			else if ( $q1S_MTH >= 80.00 AND $q1S_MTH <= 89.99 )
				$lgS_MTH = 'B';
			else if ( $q1S_MTH >= 70.00 AND $q1S_MTH <= 79.99 )
				$lgS_MTH = 'C';
			else if ( $q1S_MTH >= 0.00 AND $q1S_MTH <= 69.99 )
				$lgS_MTH = 'D';
			else
				$lgS_MTH = 'ERR';
			
			$ave1KS_MTH = number_format( $ave1KS_MTH,2,'.','.');
			
			if ( $ave1KS_MTH >= 90.00 AND $ave1KS_MTH <= 100.00 )
				$lgKS_MTH = 'A';
			else if ( $ave1KS_MTH >= 80.00 AND $ave1KS_MTH <= 89.99 )
				$lgKS_MTH = 'B';
			else if ( $ave1KS_MTH >= 70.00 AND $ave1KS_MTH <= 79.99 )
				$lgKS_MTH = 'C';
			else if ( $ave1KS_MTH >= 0.00 AND $ave1KS_MTH <= 69.99 )
				$lgKS_MTH = 'D';
			else
				$lgKS_MTH = 'ERR';
			
			if ( $q1av7_MTH >= 90.00 AND $q1av7_MTH <= 100.00 )
				$lg7_MTH = 'A';
			else if ( $q1av7_MTH >= 80.00 AND $q1av7_MTH <= 89.99 )
				$lg7_MTH = 'B';
			else if ( $q1av7_MTH >= 70.00 AND $q1av7_MTH <= 79.99 )
				$lg7_MTH = 'C';
			else if ( $q1av7_MTH >= 0.00 AND $q1av7_MTH <= 69.99 )
				$lg7_MTH = 'D';
			else
				$lg7_MTH = 'ERR';
			
			
			
			//SCN
			$qry_SCN ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='SCN'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_SCN=mysql_query($qry_SCN) or die('Query gagal');
			$dat_SCN =mysql_fetch_array($rsl_SCN);
			
			$q1STK_SCN=$dat_SCN['fgk'.$sms.$midtrm]; // q1	st	."9"
			$q1STS_SCN=$dat_SCN['fgs'.$sms.$midtrm]; // q1	st_	."9"
			$q1av7_SCN=$dat_SCN['akh'.$sms.$midtrm]; // q1
			
			$q1K_SCN = $q1STK_SCN;
			$q1S_SCN = $q1STS_SCN;
			
			
			
			//AWAL BUATAN BARU
			if ( $q1K_SCN < 60 )
				$q1K_SCN = 60;
			else if ( $q1K_SCN == 100 )
				$q1K_SCN = 99;
			
			if ( $q1S_SCN < 60 )
				$q1S_SCN = 60;
			else if ( $q1S_SCN == 100 )
				$q1S_SCN = 99;
			//AKHIR BUATAN BARU
			
			
			
			$ave1KS_SCN = ( $q1K_SCN + $q1S_SCN ) / 2;
			
			if ( $q1K_SCN >= 90.00 AND $q1K_SCN <= 100.00 )
				$lgK_SCN = 'A';
			else if ( $q1K_SCN >= 80.00 AND $q1K_SCN <= 89.99 )
				$lgK_SCN = 'B';
			else if ( $q1K_SCN >= 70.00 AND $q1K_SCN <= 79.99 )
				$lgK_SCN = 'C';
			else if ( $q1K_SCN >= 0.00 AND $q1K_SCN <= 69.99 )
				$lgK_SCN = 'D';
			else
				$lgK_SCN = 'ERR';
			
			if ( $q1S_SCN >= 90.00 AND $q1S_SCN <= 100.00 )
				$lgS_SCN = 'A';
			else if ( $q1S_SCN >= 80.00 AND $q1S_SCN <= 89.99 )
				$lgS_SCN = 'B';
			else if ( $q1S_SCN >= 70.00 AND $q1S_SCN <= 79.99 )
				$lgS_SCN = 'C';
			else if ( $q1S_SCN >= 0.00 AND $q1S_SCN <= 69.99 )
				$lgS_SCN = 'D';
			else
				$lgS_SCN = 'ERR';
			
			$ave1KS_SCN = number_format( $ave1KS_SCN,2,'.','.');
			
			if ( $ave1KS_SCN >= 90.00 AND $ave1KS_SCN <= 100.00 )
				$lgKS_SCN = 'A';
			else if ( $ave1KS_SCN >= 80.00 AND $ave1KS_SCN <= 89.99 )
				$lgKS_SCN = 'B';
			else if ( $ave1KS_SCN >= 70.00 AND $ave1KS_SCN <= 79.99 )
				$lgKS_SCN = 'C';
			else if ( $ave1KS_SCN >= 0.00 AND $ave1KS_SCN <= 69.99 )
				$lgKS_SCN = 'D';
			else
				$lgKS_SCN = 'ERR';
			
			if ( $q1av7_SCN >= 90.00 AND $q1av7_SCN <= 100.00 )
				$lg7_SCN = 'A';
			else if ( $q1av7_SCN >= 80.00 AND $q1av7_SCN <= 89.99 )
				$lg7_SCN = 'B';
			else if ( $q1av7_SCN >= 70.00 AND $q1av7_SCN <= 79.99 )
				$lg7_SCN = 'C';
			else if ( $q1av7_SCN >= 0.00 AND $q1av7_SCN <= 69.99 )
				$lg7_SCN = 'D';
			else
				$lg7_SCN = 'ERR';
			
			
			
			//SCLS
			$qry_SCLS ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='SCLS'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_SCLS=mysql_query($qry_SCLS) or die('Query gagal');
			$dat_SCLS =mysql_fetch_array($rsl_SCLS);
			
			$q1STK_SCLS=$dat_SCLS['fgk'.$sms.$midtrm]; // q1	st	."9"
			$q1STS_SCLS=$dat_SCLS['fgs'.$sms.$midtrm]; // q1	st_	."9"
			$q1av7_SCLS=$dat_SCLS['akh'.$sms.$midtrm]; // q1
			
			$q1K_SCLS = $q1STK_SCLS;
			$q1S_SCLS = $q1STS_SCLS;
			
			
			
			//AWAL BUATAN BARU
			if ( $q1K_SCLS < 60 )
				$q1K_SCLS = 60;
			else if ( $q1K_SCLS == 100 )
				$q1K_SCLS = 99;
			
			if ( $q1S_SCLS < 60 )
				$q1S_SCLS = 60;
			else if ( $q1S_SCLS == 100 )
				$q1S_SCLS = 99;
			//AKHIR BUATAN BARU
			
			
			
			$ave1KS_SCLS = ( $q1K_SCLS + $q1S_SCLS ) / 2;
			
			if ( $q1K_SCLS >= 90.00 AND $q1K_SCLS <= 100.00 )
				$lgK_SCLS = 'A';
			else if ( $q1K_SCLS >= 80.00 AND $q1K_SCLS <= 89.99 )
				$lgK_SCLS = 'B';
			else if ( $q1K_SCLS >= 70.00 AND $q1K_SCLS <= 79.99 )
				$lgK_SCLS = 'C';
			else if ( $q1K_SCLS >= 0.00 AND $q1K_SCLS <= 69.99 )
				$lgK_SCLS = 'D';
			else
				$lgK_SCLS = 'ERR';
			
			if ( $q1S_SCLS >= 90.00 AND $q1S_SCLS <= 100.00 )
				$lgS_SCLS = 'A';
			else if ( $q1S_SCLS >= 80.00 AND $q1S_SCLS <= 89.99 )
				$lgS_SCLS = 'B';
			else if ( $q1S_SCLS >= 70.00 AND $q1S_SCLS <= 79.99 )
				$lgS_SCLS = 'C';
			else if ( $q1S_SCLS >= 0.00 AND $q1S_SCLS <= 69.99 )
				$lgS_SCLS = 'D';
			else
				$lgS_SCLS = 'ERR';
			
			$ave1KS_SCLS = number_format( $ave1KS_SCLS,2,'.','.');
			
			if ( $ave1KS_SCLS >= 90.00 AND $ave1KS_SCLS <= 100.00 )
				$lgKS_SCLS = 'A';
			else if ( $ave1KS_SCLS >= 80.00 AND $ave1KS_SCLS <= 89.99 )
				$lgKS_SCLS = 'B';
			else if ( $ave1KS_SCLS >= 70.00 AND $ave1KS_SCLS <= 79.99 )
				$lgKS_SCLS = 'C';
			else if ( $ave1KS_SCLS >= 0.00 AND $ave1KS_SCLS <= 69.99 )
				$lgKS_SCLS = 'D';
			else
				$lgKS_SCLS = 'ERR';
			
			if ( $q1av7_SCLS >= 90.00 AND $q1av7_SCLS <= 100.00 )
				$lg7_SCLS = 'A';
			else if ( $q1av7_SCLS >= 80.00 AND $q1av7_SCLS <= 89.99 )
				$lg7_SCLS = 'B';
			else if ( $q1av7_SCLS >= 70.00 AND $q1av7_SCLS <= 79.99 )
				$lg7_SCLS = 'C';
			else if ( $q1av7_SCLS >= 0.00 AND $q1av7_SCLS <= 69.99 )
				$lg7_SCLS = 'D';
			else
				$lg7_SCLS = 'ERR';
			
			
			
			//ART
			$qry_ART ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='ART'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_ART=mysql_query($qry_ART) or die('Query gagal');
			$dat_ART =mysql_fetch_array($rsl_ART);
			
			$q1STK_ART=$dat_ART['fgk'.$sms.$midtrm]; // q1	st	."9"
			$q1STS_ART=$dat_ART['fgs'.$sms.$midtrm]; // q1	st_	."9"
			$q1av7_ART=$dat_ART['akh'.$sms.$midtrm]; // q1
			
			$q1K_ART = $q1STK_ART;
			$q1S_ART = $q1STS_ART;
			
			
			
			//AWAL BUATAN BARU
			if ( $q1K_ART < 60 )
				$q1K_ART = 60;
			else if ( $q1K_ART == 100 )
				$q1K_ART = 99;
			
			if ( $q1S_ART < 60 )
				$q1S_ART = 60;
			else if ( $q1S_ART == 100 )
				$q1S_ART = 99;
			//AKHIR BUATAN BARU
			
			
			
			$ave1KS_ART = ( $q1K_ART + $q1S_ART ) / 2;
			
			if ( $q1K_ART >= 90.00 AND $q1K_ART <= 100.00 )
				$lgK_ART = 'A';
			else if ( $q1K_ART >= 80.00 AND $q1K_ART <= 89.99 )
				$lgK_ART = 'B';
			else if ( $q1K_ART >= 70.00 AND $q1K_ART <= 79.99 )
				$lgK_ART = 'C';
			else if ( $q1K_ART >= 0.00 AND $q1K_ART <= 69.99 )
				$lgK_ART = 'D';
			else
				$lgK_ART = 'ERR';
			
			if ( $q1S_ART >= 90.00 AND $q1S_ART <= 100.00 )
				$lgS_ART = 'A';
			else if ( $q1S_ART >= 80.00 AND $q1S_ART <= 89.99 )
				$lgS_ART = 'B';
			else if ( $q1S_ART >= 70.00 AND $q1S_ART <= 79.99 )
				$lgS_ART = 'C';
			else if ( $q1S_ART >= 0.00 AND $q1S_ART <= 69.99 )
				$lgS_ART = 'D';
			else
				$lgS_ART = 'ERR';
			
			$ave1KS_ART = number_format( $ave1KS_ART,2,'.','.');
			
			if ( $ave1KS_ART >= 90.00 AND $ave1KS_ART <= 100.00 )
				$lgKS_ART = 'A';
			else if ( $ave1KS_ART >= 80.00 AND $ave1KS_ART <= 89.99 )
				$lgKS_ART = 'B';
			else if ( $ave1KS_ART >= 70.00 AND $ave1KS_ART <= 79.99 )
				$lgKS_ART = 'C';
			else if ( $ave1KS_ART >= 0.00 AND $ave1KS_ART <= 69.99 )
				$lgKS_ART = 'D';
			else
				$lgKS_ART = 'ERR';
			
			if ( $q1av7_ART >= 90.00 AND $q1av7_ART <= 100.00 )
				$lg7_ART = 'A';
			else if ( $q1av7_ART >= 80.00 AND $q1av7_ART <= 89.99 )
				$lg7_ART = 'B';
			else if ( $q1av7_ART >= 70.00 AND $q1av7_ART <= 79.99 )
				$lg7_ART = 'C';
			else if ( $q1av7_ART >= 0.00 AND $q1av7_ART <= 69.99 )
				$lg7_ART = 'D';
			else
				$lg7_ART = 'ERR';
			
			
			
			//PE
			$qry_PE ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='PE'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_PE=mysql_query($qry_PE) or die('Query gagal');
			$dat_PE =mysql_fetch_array($rsl_PE);
			
			$q1STK_PE=$dat_PE['fgk'.$sms.$midtrm]; // q1	st	."9"
			$q1STS_PE=$dat_PE['fgs'.$sms.$midtrm]; // q1	st_	."9"
			$q1av7_PE=$dat_PE['akh'.$sms.$midtrm]; // q1
			
			$q1K_PE = $q1STK_PE;
			$q1S_PE = $q1STS_PE;
			
			
			
			//AWAL BUATAN BARU
			if ( $q1K_PE < 60 )
				$q1K_PE = 60;
			else if ( $q1K_PE == 100 )
				$q1K_PE = 99;
			
			if ( $q1S_PE < 60 )
				$q1S_PE = 60;
			else if ( $q1S_PE == 100 )
				$q1S_PE = 99;
			//AKHIR BUATAN BARU
			
			
			
			$ave1KS_PE = ( $q1K_PE + $q1S_PE ) / 2;
			
			if ( $q1K_PE >= 90.00 AND $q1K_PE <= 100.00 )
				$lgK_PE = 'A';
			else if ( $q1K_PE >= 80.00 AND $q1K_PE <= 89.99 )
				$lgK_PE = 'B';
			else if ( $q1K_PE >= 70.00 AND $q1K_PE <= 79.99 )
				$lgK_PE = 'C';
			else if ( $q1K_PE >= 0.00 AND $q1K_PE <= 69.99 )
				$lgK_PE = 'D';
			else
				$lgK_PE = 'ERR';
			
			if ( $q1S_PE >= 90.00 AND $q1S_PE <= 100.00 )
				$lgS_PE = 'A';
			else if ( $q1S_PE >= 80.00 AND $q1S_PE <= 89.99 )
				$lgS_PE = 'B';
			else if ( $q1S_PE >= 70.00 AND $q1S_PE <= 79.99 )
				$lgS_PE = 'C';
			else if ( $q1S_PE >= 0.00 AND $q1S_PE <= 69.99 )
				$lgS_PE = 'D';
			else
				$lgS_PE = 'ERR';
			
			$ave1KS_PE = number_format( $ave1KS_PE,2,'.','.');
			
			if ( $ave1KS_PE >= 90.00 AND $ave1KS_PE <= 100.00 )
				$lgKS_PE = 'A';
			else if ( $ave1KS_PE >= 80.00 AND $ave1KS_PE <= 89.99 )
				$lgKS_PE = 'B';
			else if ( $ave1KS_PE >= 70.00 AND $ave1KS_PE <= 79.99 )
				$lgKS_PE = 'C';
			else if ( $ave1KS_PE >= 0.00 AND $ave1KS_PE <= 69.99 )
				$lgKS_PE = 'D';
			else
				$lgKS_PE = 'ERR';
			
			if ( $q1av7_PE >= 90.00 AND $q1av7_PE <= 100.00 )
				$lg7_PE = 'A';
			else if ( $q1av7_PE >= 80.00 AND $q1av7_PE <= 89.99 )
				$lg7_PE = 'B';
			else if ( $q1av7_PE >= 70.00 AND $q1av7_PE <= 79.99 )
				$lg7_PE = 'C';
			else if ( $q1av7_PE >= 0.00 AND $q1av7_PE <= 69.99 )
				$lg7_PE = 'D';
			else
				$lg7_PE = 'ERR';
			
			
			
			//ENG
			$qry_ENG ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='ENG'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_ENG=mysql_query($qry_ENG) or die('Query gagal');
			$dat_ENG =mysql_fetch_array($rsl_ENG);
			
			$q1STK_ENG=$dat_ENG['fgk'.$sms.$midtrm]; // q1	st	."9"
			$q1STS_ENG=$dat_ENG['fgs'.$sms.$midtrm]; // q1	st_	."9"
			$q1av7_ENG=$dat_ENG['akh'.$sms.$midtrm]; // q1
			
			$q1K_ENG = $q1STK_ENG;
			$q1S_ENG = $q1STS_ENG;
			
			
			
			//AWAL BUATAN BARU
			if ( $q1K_ENG < 60 )
				$q1K_ENG = 60;
			else if ( $q1K_ENG == 100 )
				$q1K_ENG = 99;
			
			if ( $q1S_ENG < 60 )
				$q1S_ENG = 60;
			else if ( $q1S_ENG == 100 )
				$q1S_ENG = 99;
			//AKHIR BUATAN BARU
			
			
			
			$ave1KS_ENG = ( $q1K_ENG + $q1S_ENG ) / 2;
			
			if ( $q1K_ENG >= 90.00 AND $q1K_ENG <= 100.00 )
				$lgK_ENG = 'A';
			else if ( $q1K_ENG >= 80.00 AND $q1K_ENG <= 89.99 )
				$lgK_ENG = 'B';
			else if ( $q1K_ENG >= 70.00 AND $q1K_ENG <= 79.99 )
				$lgK_ENG = 'C';
			else if ( $q1K_ENG >= 0.00 AND $q1K_ENG <= 69.99 )
				$lgK_ENG = 'D';
			else
				$lgK_ENG = 'ERR';
			
			if ( $q1S_ENG >= 90.00 AND $q1S_ENG <= 100.00 )
				$lgS_ENG = 'A';
			else if ( $q1S_ENG >= 80.00 AND $q1S_ENG <= 89.99 )
				$lgS_ENG = 'B';
			else if ( $q1S_ENG >= 70.00 AND $q1S_ENG <= 79.99 )
				$lgS_ENG = 'C';
			else if ( $q1S_ENG >= 0.00 AND $q1S_ENG <= 69.99 )
				$lgS_ENG = 'D';
			else
				$lgS_ENG = 'ERR';
			
			$ave1KS_ENG = number_format( $ave1KS_ENG,2,'.','.');
			
			if ( $ave1KS_ENG >= 90.00 AND $ave1KS_ENG <= 100.00 )
				$lgKS_ENG = 'A';
			else if ( $ave1KS_ENG >= 80.00 AND $ave1KS_ENG <= 89.99 )
				$lgKS_ENG = 'B';
			else if ( $ave1KS_ENG >= 70.00 AND $ave1KS_ENG <= 79.99 )
				$lgKS_ENG = 'C';
			else if ( $ave1KS_ENG >= 0.00 AND $ave1KS_ENG <= 69.99 )
				$lgKS_ENG = 'D';
			else
				$lgKS_ENG = 'ERR';
			
			if ( $q1av7_ENG >= 90.00 AND $q1av7_ENG <= 100.00 )
				$lg7_ENG = 'A';
			else if ( $q1av7_ENG >= 80.00 AND $q1av7_ENG <= 89.99 )
				$lg7_ENG = 'B';
			else if ( $q1av7_ENG >= 70.00 AND $q1av7_ENG <= 79.99 )
				$lg7_ENG = 'C';
			else if ( $q1av7_ENG >= 0.00 AND $q1av7_ENG <= 69.99 )
				$lg7_ENG = 'D';
			else
				$lg7_ENG = 'ERR';
			
			
			
			//MND
			$qry_MND ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='MND'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_MND=mysql_query($qry_MND) or die('Query gagal');
			$dat_MND =mysql_fetch_array($rsl_MND);
			
			$q1STK_MND=$dat_MND['fgk'.$sms.$midtrm]; // q1	st	."9"
			$q1STS_MND=$dat_MND['fgs'.$sms.$midtrm]; // q1	st_	."9"
			$q1av7_MND=$dat_MND['akh'.$sms.$midtrm]; // q1
			
			$q1K_MND = $q1STK_MND;
			$q1S_MND = $q1STS_MND;
			
			
			
			//AWAL BUATAN BARU
			if ( $q1K_MND < 60 )
				$q1K_MND = 60;
			else if ( $q1K_MND == 100 )
				$q1K_MND = 99;
			
			if ( $q1S_MND < 60 )
				$q1S_MND = 60;
			else if ( $q1S_MND == 100 )
				$q1S_MND = 99;
			//AKHIR BUATAN BARU
			
			
			
			$ave1KS_MND = ( $q1K_MND + $q1S_MND ) / 2;
			
			if ( $q1K_MND >= 90.00 AND $q1K_MND <= 100.00 )
				$lgK_MND = 'A';
			else if ( $q1K_MND >= 80.00 AND $q1K_MND <= 89.99 )
				$lgK_MND = 'B';
			else if ( $q1K_MND >= 70.00 AND $q1K_MND <= 79.99 )
				$lgK_MND = 'C';
			else if ( $q1K_MND >= 0.00 AND $q1K_MND <= 69.99 )
				$lgK_MND = 'D';
			else
				$lgK_MND = 'ERR';
			
			if ( $q1S_MND >= 90.00 AND $q1S_MND <= 100.00 )
				$lgS_MND = 'A';
			else if ( $q1S_MND >= 80.00 AND $q1S_MND <= 89.99 )
				$lgS_MND = 'B';
			else if ( $q1S_MND >= 70.00 AND $q1S_MND <= 79.99 )
				$lgS_MND = 'C';
			else if ( $q1S_MND >= 0.00 AND $q1S_MND <= 69.99 )
				$lgS_MND = 'D';
			else
				$lgS_MND = 'ERR';
			
			$ave1KS_MND = number_format( $ave1KS_MND,2,'.','.');
			
			if ( $ave1KS_MND >= 90.00 AND $ave1KS_MND <= 100.00 )
				$lgKS_MND = 'A';
			else if ( $ave1KS_MND >= 80.00 AND $ave1KS_MND <= 89.99 )
				$lgKS_MND = 'B';
			else if ( $ave1KS_MND >= 70.00 AND $ave1KS_MND <= 79.99 )
				$lgKS_MND = 'C';
			else if ( $ave1KS_MND >= 0.00 AND $ave1KS_MND <= 69.99 )
				$lgKS_MND = 'D';
			else
				$lgKS_MND = 'ERR';
			
			if ( $q1av7_MND >= 90.00 AND $q1av7_MND <= 100.00 )
				$lg7_MND = 'A';
			else if ( $q1av7_MND >= 80.00 AND $q1av7_MND <= 89.99 )
				$lg7_MND = 'B';
			else if ( $q1av7_MND >= 70.00 AND $q1av7_MND <= 79.99 )
				$lg7_MND = 'C';
			else if ( $q1av7_MND >= 0.00 AND $q1av7_MND <= 69.99 )
				$lg7_MND = 'D';
			else
				$lg7_MND = 'ERR';
			
			
			
			//COM
			$qry_COM ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='COM'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl_COM=mysql_query($qry_COM) or die('Query gagal');
			$dat_COM =mysql_fetch_array($rsl_COM);
			
			$q1STK_COM=$dat_COM['fgk'.$sms.$midtrm]; // q1	st	."9"
			$q1STS_COM=$dat_COM['fgs'.$sms.$midtrm]; // q1	st_	."9"
			$q1av7_COM=$dat_COM['akh'.$sms.$midtrm]; // q1
			
			$q1K_COM = $q1STK_COM;
			$q1S_COM = $q1STS_COM;
			
			
			
			//AWAL BUATAN BARU
			if ( $q1K_COM < 60 )
				$q1K_COM = 60;
			else if ( $q1K_COM == 100 )
				$q1K_COM = 99;
			
			if ( $q1S_COM < 60 )
				$q1S_COM = 60;
			else if ( $q1S_COM == 100 )
				$q1S_COM = 99;
			//AKHIR BUATAN BARU
			
			
			
			$ave1KS_COM = ( $q1K_COM + $q1S_COM ) / 2;
			
			if ( $q1K_COM >= 90.00 AND $q1K_COM <= 100.00 )
				$lgK_COM = 'A';
			else if ( $q1K_COM >= 80.00 AND $q1K_COM <= 89.99 )
				$lgK_COM = 'B';
			else if ( $q1K_COM >= 70.00 AND $q1K_COM <= 79.99 )
				$lgK_COM = 'C';
			else if ( $q1K_COM >= 0.00 AND $q1K_COM <= 69.99 )
				$lgK_COM = 'D';
			else
				$lgK_COM = 'ERR';
			
			if ( $q1S_COM >= 90.00 AND $q1S_COM <= 100.00 )
				$lgS_COM = 'A';
			else if ( $q1S_COM >= 80.00 AND $q1S_COM <= 89.99 )
				$lgS_COM = 'B';
			else if ( $q1S_COM >= 70.00 AND $q1S_COM <= 79.99 )
				$lgS_COM = 'C';
			else if ( $q1S_COM >= 0.00 AND $q1S_COM <= 69.99 )
				$lgS_COM = 'D';
			else
				$lgS_COM = 'ERR';
			
			$ave1KS_COM = number_format( $ave1KS_COM,2,'.','.');
			
			if ( $ave1KS_COM >= 90.00 AND $ave1KS_COM <= 100.00 )
				$lgKS_COM = 'A';
			else if ( $ave1KS_COM >= 80.00 AND $ave1KS_COM <= 89.99 )
				$lgKS_COM = 'B';
			else if ( $ave1KS_COM >= 70.00 AND $ave1KS_COM <= 79.99 )
				$lgKS_COM = 'C';
			else if ( $ave1KS_COM >= 0.00 AND $ave1KS_COM <= 69.99 )
				$lgKS_COM = 'D';
			else
				$lgKS_COM = 'ERR';
			
			if ( $q1av7_COM >= 90.00 AND $q1av7_COM <= 100.00 )
				$lg7_COM = 'A';
			else if ( $q1av7_COM >= 80.00 AND $q1av7_COM <= 89.99 )
				$lg7_COM = 'B';
			else if ( $q1av7_COM >= 70.00 AND $q1av7_COM <= 79.99 )
				$lg7_COM = 'C';
			else if ( $q1av7_COM >= 0.00 AND $q1av7_COM <= 69.99 )
				$lg7_COM = 'D';
			else
				$lg7_COM = 'ERR';
			
			
			
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
					<td align='center'>70</td>
					<td align='center'>$q1K_RLG</td>
					<td align='center'>$lgK_RLG</td>
					<td align='center'>$q1S_RLG</td>
					<td align='center'>$lgS_RLG</td>
					<td align='center'>$ave1KS_RLG</td>
					<td align='center'>$lgKS_RLG</td>
					<td align='center'>$lg7_RLG</td>
				</tr>
				
				<tr>
					<td align='right'>2</td>
					<td>Pancasila and Civic Education</td>
					<td align='center'>70</td>
					<td align='center'>$q1K_CME</td>
					<td align='center'>$lgK_CME</td>
					<td align='center'>$q1S_CME</td>
					<td align='center'>$lgS_CME</td>
					<td align='center'>$ave1KS_CME</td>
					<td align='center'>$lgKS_CME</td>
					<td align='center'>$lg7_CME</td>
				</tr>
				
				<tr>
					<td align='right'>3</td>
					<td>Bahasa Indonesia</td>
					<td align='center'>70</td>
					<td align='center'>$q1K_BIN</td>
					<td align='center'>$lgK_BIN</td>
					<td align='center'>$q1S_BIN</td>
					<td align='center'>$lgS_BIN</td>
					<td align='center'>$ave1KS_BIN</td>
					<td align='center'>$lgKS_BIN</td>
					<td align='center'>$lg7_BIN</td>
				</tr>
				
				<tr>
					<td align='right'>4</td>
					<td>Mathemetics</td>
					<td align='center'>70</td>
					<td align='center'>$q1K_MTH</td>
					<td align='center'>$lgK_MTH</td>
					<td align='center'>$q1S_MTH</td>
					<td align='center'>$lgS_MTH</td>
					<td align='center'>$ave1KS_MTH</td>
					<td align='center'>$lgKS_MTH</td>
					<td align='center'>$lg7_MTH</td>
				</tr>
				
				<tr>
					<td align='right'>5</td>
					<td>General Science</td>
					<td align='center'>70</td>
					<td align='center'>$q1K_SCN</td>
					<td align='center'>$lgK_SCN</td>
					<td align='center'>$q1S_SCN</td>
					<td align='center'>$lgS_SCN</td>
					<td align='center'>$ave1KS_SCN</td>
					<td align='center'>$lgKS_SCN</td>
					<td align='center'>$lg7_SCN</td>
				</tr>
				
				<tr>
					<td align='right'>6</td>
					<td>Social Studies</td>
					<td align='center'>70</td>
					<td align='center'>$q1K_SCLS</td>
					<td align='center'>$lgK_SCLS</td>
					<td align='center'>$q1S_SCLS</td>
					<td align='center'>$lgS_SCLS</td>
					<td align='center'>$ave1KS_SCLS</td>
					<td align='center'>$lgKS_SCLS</td>
					<td align='center'>$lg7_SCLS</td>
				</tr>
				
				<tr>
					<td align='right'>7</td>
					<td>Cultural Art and Music</td>
					<td align='center'>70</td>
					<td align='center'>$q1K_ART</td>
					<td align='center'>$lgK_ART</td>
					<td align='center'>$q1S_ART</td>
					<td align='center'>$lgS_ART</td>
					<td align='center'>$ave1KS_ART</td>
					<td align='center'>$lgKS_ART</td>
					<td align='center'>$lg7_ART</td>
				</tr>
				
				<tr>
					<td align='right'>8</td>
					<td>Physical Education & Health</td>
					<td align='center'>70</td>
					<td align='center'>$q1K_PE</td>
					<td align='center'>$lgK_PE</td>
					<td align='center'>$q1S_PE</td>
					<td align='center'>$lgS_PE</td>
					<td align='center'>$ave1KS_PE</td>
					<td align='center'>$lgKS_PE</td>
					<td align='center'>$lg7_PE</td>
				</tr>
				
				<tr>
					<td align='right'>9</td>
					<td>English</td>
					<td align='center'>70</td>
					<td align='center'>$q1K_ENG</td>
					<td align='center'>$lgK_ENG</td>
					<td align='center'>$q1S_ENG</td>
					<td align='center'>$lgS_ENG</td>
					<td align='center'>$ave1KS_ENG</td>
					<td align='center'>$lgKS_ENG</td>
					<td align='center'>$lg7_ENG</td>
				</tr>
				
				<tr>
					<td align='right'>10</td>
					<td>Mandarin</td>
					<td align='center'>70</td>
					<td align='center'>$q1K_MND</td>
					<td align='center'>$lgK_MND</td>
					<td align='center'>$q1S_MND</td>
					<td align='center'>$lgS_MND</td>
					<td align='center'>$ave1KS_MND</td>
					<td align='center'>$lgKS_MND</td>
					<td align='center'>$lg7_MND</td>
				</tr>
				
				<tr style='visibility: $str_vis_d'>
					<td align='right'>11</td>
					<td>Computer Education</td>
					<td align='center'>70</td>
					<td align='center'>$q1K_COM</td>
					<td align='center'>$lgK_COM</td>
					<td align='center'>$q1S_COM</td>
					<td align='center'>$lgS_COM</td>
					<td align='center'>$ave1KS_COM</td>
					<td align='center'>$lgKS_COM</td>
					<td align='center'>$lg7_COM</td>
				</tr>
	";
	
	
	
	
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
				
				
				
		echo"			<tr>
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
							
							<!--$kplskl-->Sikstus Bonaventura Goo, S. Fil
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
	
	/*
	$pdf->Ln(0.6);//0.5
	$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,false);
	$pdf->Cell( 2.3,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell( 7.1	,0.6,''.$wlikls.$gelar,0,0,C,true);
	
	$pdf->Ln(0.5);//0.5
	$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 7.1	,0.4,'                              '.'                  '.'                              ',0,0,L,true);
	$pdf->Cell( 2.3,0.4,'',0,0,L);
	//$pdf->SetFont('Arial','',12);
	$pdf->Cell( 7.1	,0.6,''.'Homeroom Adviser',0,0,C,true);
	
	$pdf->Ln(2);//2
	$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell( 7.1	,0.4,'                      '.'                  '.'                      ',0,0,L,true);
	$pdf->Cell( 2.3,0.4,'',0,0,L);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell( 7.1	,0.4,'  '.$kplskl.', S.Fil'.'  ',0,0,C,true);
	
	$pdf->Ln();
	$pdf->Cell( 1.25	,0.4,'',0,0,L);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 7.1	,0.6,"PARENT'S SIGNATURE",0,0,C,true);
	$pdf->Cell( 2.3,0.4,'',0,0,L);
	$pdf->Cell( 7.1	,0.6,'PRINCIPAL',0,0,C,true);
	*/
	
	
	
	$y++;
	
}//cetak all

/*
$pdf->Output();
*/

//AWAL BUATAN BARU
echo"
			<!--</font>-->
			<!--</div>-->
    </body>
</html>
";
//AKHIR BUATAN BARU

?>