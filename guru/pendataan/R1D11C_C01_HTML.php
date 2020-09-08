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

$kdekls	=$_POST['kdekls'];
//$nis	=$_POST['nis'];
//$sms	=$_POST['sms'];
//$midtrm	='2';
//$_POST['midtrm'];
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
				
";



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
		/*$nisn	=$data2[nisn];
		$nmassw	=$data2[nmassw];*/
		
		
		
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
		if(($akh1+$akh2)>0 OR $kdeplj=='MND' OR $kdeplj=='GRM' OR $kdeplj=='PHY' OR $kdeplj=='BLGY' OR $kdeplj=='CHM')
		{
			$cell2[$k][0]	=$data[kdeplj];
			$k++;
		}	
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
	
	
	
	//$nis_x
	$cell5[$i][4]=$data[tgllhr]; // buatan tgl lahir
	
	
	
	//AWAL BUATAN BARU
	
	$cell5[$i][5]=$data[tmplhr];
	$cell5[$i][6]=$data[jnsklm];
	$cell5[$i][7]=$data[kdeagm];
	$cell5[$i][8]=$data[status];
	$cell5[$i][9]=$data[alm];
	$cell5[$i][10]=$data[tlp];
	$cell5[$i][11]=$data[dftkls];
	$cell5[$i][12]=$data[pdatgl];
	$cell5[$i][13]=$data[sklasl];
	$cell5[$i][14]=$data[sklasl_almt];
	$cell5[$i][15]=$data[sttb];
	$cell5[$i][16]=$data[sttb_thn];
	$cell5[$i][17]=$data[nmaayh];
	$cell5[$i][18]=$data[nmaibu];
	$cell5[$i][19]=$data[almayh];
	$cell5[$i][20]=$data[tlpayh];
	$cell5[$i][21]=$data[pkjayh];
	$cell5[$i][22]=$data[pkjibu];
	$cell5[$i][23]=$data[nmawli];
	$cell5[$i][24]=$data[almwli];
	$cell5[$i][25]=$data[tlpwli];
	$cell5[$i][26]=$data[pkjwli];
	
	//AKHIR BUATAN BARU
	
	
	
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
	//$cell5[$y][3]=$y+1;
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
	$tgllhr	=date('d F Y',$tgllhr);//'d-M-Y'
	
	
	
	//AWAL BUATAN BARU
	$tanggallahir	=$cell5[$y][4];
	
	$tanggal_lahir	=substr($tgllhr,0,2);
	$bulan_lahir	=substr($tgllhr,3,3);
	$tahun_lahir	=substr($tanggallahir,6,4);
	
	if ( $bulan_lahir == 'Jan' )
		$bulan_lahir = 'Januari';
	else if ( $bulan_lahir == 'Feb' )
		$bulan_lahir = 'Februari';
	else if ( $bulan_lahir == 'Mar' )
		$bulan_lahir = 'Maret';
	else if ( $bulan_lahir == 'Apr' )
		$bulan_lahir = 'April';
	else if ( $bulan_lahir == 'May' )
		$bulan_lahir = 'Mei';
	else if ( $bulan_lahir == 'Jun' )
		$bulan_lahir = 'Juni';
	else if ( $bulan_lahir == 'Jul' )
		$bulan_lahir = 'Juli';
	else if ( $bulan_lahir == 'Aug' )
		$bulan_lahir = 'Agustus';
	else if ( $bulan_lahir == 'Sep' )
		$bulan_lahir = 'September';
	else if ( $bulan_lahir == 'Oct' )
		$bulan_lahir = 'Oktober';
	else if ( $bulan_lahir == 'Nov' )
		$bulan_lahir = 'November';
	else if ( $bulan_lahir == 'Dec' )
		$bulan_lahir = 'Desember';
	else //if ( $bulan_lahir == 'Mar' )
		$bulan_lahir = 'Err';
	
	$tmplhr			=$cell5[$y][5];
	$jeniskelamin	=$cell5[$y][6];
	
	if ( $jeniskelamin == 'L' )
		$jeniskelamin = 'Laki-laki';
	else if ( $jeniskelamin == 'P' )
		$jeniskelamin = 'Perempuan';
	else
		$jeniskelamin = 'Err';
	
	$kodeagama	=$cell5[$y][7];
	
	if ( $kodeagama == '1' )
		$kodeagama = 'Islam';
	else if ( $kodeagama == '2' )
		$kodeagama = 'Katolik';
	else if ( $kodeagama == '3' )
		$kodeagama = 'Protestan';
	else if ( $kodeagama == '4' )
		$kodeagama = 'Budha';
	else if ( $kodeagama == '5' )
		$kodeagama = 'Hindu';
	else if ( $kodeagama == '6' )
		$kodeagama = 'Lainnya';
	else
		$kodeagama = 'Err';
	
	$statusanak			=$cell5[$y][8];
	$alamatsiswa		=$cell5[$y][9];
	$tlpsiswa			=$cell5[$y][10];
	$dftkls				=$cell5[$y][11];
	
	if ( $dftkls == '01' )
		$dftkls = 'I';
	else if ( $dftkls == '02' )
		$dftkls = 'II';
	else if ( $dftkls == '03' )
		$dftkls = 'III';
	else if ( $dftkls == '04' )
		$dftkls = 'IV';
	else if ( $dftkls == '05' )
		$dftkls = 'V';
	else if ( $dftkls == '06' )
		$dftkls = 'VI';
	else //if ( $dftkls == '07' )
		$dftkls = 'Err';
	
	$pdatgl				=$cell5[$y][12];
	$sklasl				=$cell5[$y][13];
	$sklasl_almt		=$cell5[$y][14];
	$sttb				=$cell5[$y][15];
	$sttb_thn			=$cell5[$y][16];
	$nmaayh				=$cell5[$y][17];
	$nmaibu				=$cell5[$y][18];
	$almayh				=$cell5[$y][19];
	$tlpayh				=$cell5[$y][20];
	
	if ( $almayh == '' )
		$almayh = $alamatsiswa;
	else
		$almayh = $almayh;
	
	if ( $tlpayh == '' )
		$tlpayh = $tlpsiswa;
	else
		$tlpayh = $tlpayh;
	
	$pkjayh				=$cell5[$y][21];
	$pkjibu				=$cell5[$y][22];
	$nmawli				=$cell5[$y][23];
	$almwli				=$cell5[$y][24];
	$tlpwli				=$cell5[$y][25];
	$pkjwli				=$cell5[$y][26];
	
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
			
		}	
		else
		{
			$cell[$i][3]='';
		}
		$i++;
	}
	
	
	
	//AWAL BUATAN BARU
	echo"
		<div class='pb_after'>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<center>
				<b>
				<h2>
				
				IDENTITAS PESERTA DIDIK
				
				</h2>
				</b>
				
				<br/>
				<br/>
				
				<table width='80%'>
					<tr>
						<td width='4%'>
							01. 
						</td>
						<td width='33%'>
							Nama Siswa
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$nmassw
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							02. 
						</td>
						<td width='33%'>
							NISN
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$nis / $nisn
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							03. 
						</td>
						<td width='33%'>
							Tempat dan tanggal lahir
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$tmplhr, $tanggal_lahir $bulan_lahir $tahun_lahir
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							04. 
						</td>
						<td width='33%'>
							Jenis kelamin
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$jeniskelamin
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							05. 
						</td>
						<td width='33%'>
							Agama
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$kodeagama
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							06. 
						</td>
						<td width='33%'>
							Status anak
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$statusanak
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							07. 
						</td>
						<td width='33%'>
							Alamat Siswa
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$alamatsiswa
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							Telepon
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$tlpsiswa
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							08. 
						</td>
						<td width='33%'>
							Diterima di sekolah ini
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							a. Di kelas
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$dftkls
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							b. Tanggal
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$pdatgl
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							09. 
						</td>
						<td width='33%'>
							Sekolah asal
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							a. Nama Sekolah
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$sklasl
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							b. Alamat
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$sklasl_almt
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							10. 
						</td>
						<td width='33%'>
							Surat Tanda Lulus (STL)
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							a. Tahun
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$sttb_thn
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							b. Nomor
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$sttb
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							11. 
						</td>
						<td width='33%'>
							Orang Tua
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							a. Nama Ayah
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$nmaayh
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							b. Nama Ibu
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$nmaibu
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							12. 
						</td>
						<td width='33%'>
							Alamat Orang Tua
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$almayh
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							Telepon
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$tlpayh
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							13. 
						</td>
						<td width='33%'>
							Pekerjaan Orang Tua
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							a. Ayah
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$pkjayh
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							b. Ibu
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$pkjibu
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							14. 
						</td>
						<td width='33%'>
							Nama Wali
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$nmawli
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							15. 
						</td>
						<td width='33%'>
							Alamat Wali
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$almwli
						</td>
					</tr>
					<tr>
						<td width='4%'>
							
						</td>
						<td width='33%'>
							Telepon
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$tlpwli
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							16. 
						</td>
						<td width='33%'>
							Pekerjaan Wali
						</td>
						<td width='3%'>
							 : 
						</td>
						<td>
							$pkjwli
						</td>
					</tr>
					
					
					
					<tr>
						<td colspan='4'>
							<br/>
							<br/>
						</td>
					</tr>
					
					
					
					<tr>
						<td width='4%'>
							 
						</td>
						<td width='33%'>
							<img src='../../images/siswa/$nis.jpg' width='150px' height='180px'/>
						</td>
						<td width='3%'>
							
						</td>
						<td>
							Jakarta,<br/>
							Kepala SDS Saint John`s School
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							(Sikstus Bonaventura Goo, S.Fil)
						</td>
					</tr>
				</table>
				
				
				
			</center>
	";
	//AKHIR BUATAN BARU
	
	
	
	//------------------------------- Mata Pelajaran Kurikulum Nasional
	$j	=1;
	$no =1;
	//$ttlakh=0;
	//$jmlplj=0;
	
	$id=$cell[$j][0];
	
	//echo"$id - ";
	
	while ($id<99)
	{
		//menampilkan data dari hasil query database
		$nmasbj	=$cell[$j][1];
		$kdeplj	=$cell[$j][2];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		
		
		
		
		
		
		
		
		
		$j++;
		$id++;
		//$id=$cell[$j][0];
	}
				
	
		
	echo"			
				<!--</table>-->
				
				</div>
				
			</div>
		";
	//AKHIR BUATAN BARU
	
	
	
	//absences
	$qABS	="	SELECT 		t_hdrkmnps.*
				FROM 		t_hdrkmnps
				WHERE		t_hdrkmnps.nis='$nis' 
				"; // menghasilka nilai kehadiran
	$rABS=mysql_query($qABS) or die('Query gagal40');
	$dABS =mysql_fetch_array($rABS);
	
	$q1SKT=$dABS['skt'.'1'.'1']; // q1 skt
	$q1IZN=$dABS['izn'.'1'.'1']; // q1 izn
	$q1ALP=$dABS['alp'.'1'.'1']; // q1 alp
	
	$q2SKT=$dABS['skt'.'1'.'2']; // q2 skt
	$q2IZN=$dABS['izn'.'1'.'2']; // q2 izn
	$q2ALP=$dABS['alp'.'1'.'2']; // q2 alp
	
	$ts1SKT = $q1SKT + $q2SKT;
	$ts1IZN = $q1IZN + $q2IZN;
	$ts1ALP = $q1ALP + $q2ALP;
	
	if($ts1SKT==0)
		$ts1SKT='-';
	if($ts1IZN==0)
		$ts1IZN='-';
	if($ts1ALP==0)
		$ts1ALP='-';
	
	
	
	//AWAL BUATAN BARU
	echo"
				<!--</table>-->
			</div>
		</div>
	";
	//AKHIR BUATAN BARU
	
	
	
	$y++;
	
}//cetak all



//AWAL BUATAN BARU
echo"
			<!--</font>-->
			<!--</div>-->
    </body>
</html>
";
//AKHIR BUATAN BARU

?>