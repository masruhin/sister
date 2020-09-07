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
$sms	=$_POST['sms'];
$midtrm	='2';//$_POST['midtrm'];
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

if($sms=='2')
	echo"<meta http-equiv='refresh' content=\"0;url=R1D04PSD2_C01_HTML.php?kdekls=$kdekls\">\n";

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


$logo_pt	="../../images/logo.jpg";
$logo_ttw	="../../images/tutwurihandayani.jpg";

/*$pdf =new FPDF('P','cm','A4');
$pdf->SetMargins(0.65,0.4,1);
$pdf->SetAutoPageBreak(True, 0.4);*/

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
	/*$cell5[$i][$n+4]=$ttlakh1;
	$cell5[$i][$n+5]=$ttlakh2;
	$cell5[$i][$n+6]=number_format(($ttlakh1+$ttlakh2)/2,0,',','.');
	$cell5[$i][$n+7]=$ttlakh;*/
	$i++;
}
$x=$i;


foreach ($cell5 as $key => $row)
{
	$key_arr[$key] = $row[$n+7];
}
array_multisort($key_arr, SORT_DESC, $cell5);

/*$y=0;
while($y<$x)
{
	$cell5[$y][3]=$y+1;
	$y++;
}*/

foreach ($cell5 as $key => $row)
{
	$key_arr[$key] = $row[1];
}
array_multisort($key_arr, SORT_ASC, $cell5);

$bghw	=1;
$bgprj	=1;
$bgtes	=1;
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
						Q1
					</th>
					<th align='center' width='6.5%'>
						Q2
					</th>
					<th align='center' width='6.5%' bgcolor='lightgrey'>
						FINAL
					</th>
					<th align='center' width='6.5%'>
						Q1
					</th>
					<th align='center' width='6.5%'>
						Q2
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
	
	
	
	/*$pdf->Open();
	$pdf->AddPage();
	//$pdf->Image($logo_pt ,1,0.75,2,2);
	//$pdf->Image($logo_ttw,18,1,2,2);
	$pdf->Ln(2.5);//4
	$pdf->SetFont('arial','B',20);
	$pdf->Cell( 1	,0.4,"",0,0,L); 
	$pdf->Cell(17.5	,0.6, "STUDENT'S PROGRESS REPORT",0,0,C); // 19 $judul
	$pdf->SetFont('Arial','B',18);
	$pdf->Ln();
	
	$pdf->Cell( 1	,0.4,"",0,0,L);
	$pdf->Cell(17.5	,0.6, "ACADEMIC YEAR ".$thnajr,0,0,C); // 19 $judul2
	$pdf->Ln();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell( 1	,0.4,"",0,0,L);
	$pdf->Cell(17.5	,0.6, "PRIMARY ".substr($kdekls,-2)." - ".$strkls,0,0,C);// 19 SAINT JOHN'S SCHOOL
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat1_pt1
	$pdf->Ln();
	$pdf->Cell(17.5	,0.3, '',0,0,C); // 19 $alamat2_pt2
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 6.5	,0.4,"",0,0,L); 
	$pdf->Cell( 2	,0.4,"Semester : ",0,0,L); 
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 1.5	,0.4," ".$sms,0,0,L); //"     ".."     "
	$pdf->Cell( 0.5	,0.4,"",0,0,L); 
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 1	,0.4,"Term : ",0,0,L); 
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 1.5	,0.4,"   ".$midtrm,0,0,L); //".$sms."=2//"     ".."     "
	
	$pdf->Ln(0.75);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 4.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3	,0.4,"STUDENT NAME : ",0,0,L); 
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell( 5.7	,0.4,"      ".$nmassw,0,0,L); //."                         "
	
	$pdf->Ln(0.5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 4.5	,0.4,"",0,0,L); 
	$pdf->Cell( 3.5	,0.4,"STUDENT ID NO : ",0,0,L); 
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 2	,0.4,"  ".substr($nis,0,3)."          ",0,0,L); 
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 2.5	,0.4,"BIRTHDAY : ",0,0,L); 
	$pdf->SetFont('Arial','',12);
	$pdf->Cell( 2	,0.4,$tgllhr,0,0,L);*/ 
	
	
	
	//..sampai sini
	
	
	
	/*$pdf->Ln(0.75);
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(255,255,255);
	//$pdf->Cell( 1.25	,0.6,'',0,0,L); 
	$pdf->Cell( 19.8	,0.6,'ACADEMIC PERFORMANCE'		,'LRTB',0,C,true);
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	//$pdf->Cell( 1.25	,0.6,'',0,0,L); 
	$pdf->Cell( 7.8	,1.8,'SUBJECT'		,'LRTB',0,C,true);
	$pdf->Cell( 10.5	,0.6,'CLASSROOM PERFORMANCE'		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,1.8,'ATT'		,'LRTB',0,C,true);//ATTITUDE
	
	$pdf->Ln(0.6);
	//$pdf->Cell( 1.25	,0.6,'',0,0,L); 
	$pdf->Cell( 7.8	,1.8,''		,0,0,C,false);
	$pdf->Cell( 4.5	,0.6,'KNOWLEDGE'		,'LRTB',0,C,true);
	$pdf->Cell( 4.5	,0.6,'SKILLS'		,'LRTB',0,C,true);
	//$pdf->SetFillColor(255, 255, 0);
	$pdf->Cell( 1.5		,1.2,'AV'		,'LRTB',0,C,true);//AVERAGE
	$pdf->SetFillColor(255, 255, 255);
	
	$pdf->Ln(0.6);
	//$pdf->Cell( 1.25	,0.6,'',0,0,L); 
	$pdf->Cell( 7.8	,1.8,''		,0,0,C,false);
	$pdf->Cell( 1.5	,0.6,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 1.5,0.6,'Q2'		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.6,'FINAL'		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell( 1.5,0.6,'Q1'		,'LRTB',0,C,true);
	$pdf->Cell( 1.5	,0.6,'Q2'		,'LRTB',0,C,true);
	//$pdf->SetFillColor(0, 183, 235);
	$pdf->Cell( 1.5	,0.6,'FINAL'		,'LRTB',0,C,true);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Ln();*/
	//------------------------------- Mata Pelajaran Kurikulum Nasional
	$j	=1;
	$no =1;
	//$ttlakh=0;
	//$jmlplj=0;
	/*$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(204,204,204);*/
	$id=$cell[$j][0];
	
	
	//echo"$id - ";
	
	
	while ($id<99)
	{
		//menampilkan data dari hasil query database
		$nmasbj	=$cell[$j][1];
		$kdeplj	=$cell[$j][2];
		$kkm	=$cell[$j][3];
		$nliakh	=$cell[$j][6];
		
		//$q1		=$cell[$j][7];
		//$q2		=$cell[$j][8];
		
		//$q3		=$cell[$j][9];
		//$q4		=$cell[$j][10];
		//$av1	= ($q1 + $q2) / 2;
		
		$q1K='';
		$q1S='';
		
		$lgK='';
		$lgS='';
		
		$ave1KS='';
		$lgKS='';
		
		$lg7='';
		
		
		
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
		
		echo"
			<tr style='visibility: $str_vis_d'>
		";
		//AKHIR BUATAN BARU
		
		
		
		if($nmasbj!='')
		{
			if(substr($nmasbj,0,1)=='/')
			{
				$nmasbj 	=str_replace("/","","$nmasbj");
				/*$pdf->SetFont('Arial','B',12);
				$pdf->SetFillColor(204,204,204);
				$pdf->Cell(6.2	,0.6,$nmasbj,'LRTB',0,L,true);*/		//A		6.2	,0.5
				
				
				
				//AWAL BUATAN BARU
				echo"
					<td>
						$nmasbj
					</td>
				";
				//AKHIR BUATAN BARU
				
				
				
				$nliakh	='';
				
			}
			else
			{
				/*$pdf->SetFont('Arial','',12);
				$pdf->SetFillColor(255,255,255);*/
				
				if(substr($nmasbj,0,1)!='=')
				{
					/*$pdf->Cell(0.6	,0.6,$no,'LRTB',0,C,true);*/				//0.6	,0.5					//$pdf->Cell( 1.25	,0.6,'',0,0,L);//1.5	,0.4
					
					
					
					//AWAL BUATAN BARU
						echo"
							<td align='right'>
								$no
							</td>
						";
					//AKHIR BUATAN BARU
					
					
					
				}
				else
				{
					
					/*$pdf->Cell(0.6	,0.6,'','LRTB',0,C,true);*/					//0.6	,0.5					//$pdf->Cell( 1.25	,0.6,'',0,0,L);//1.5	,0.4
				}
				
				if(substr($nmasbj,0,1)!='=')
				{
					/*$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0.1	,0.6,'','LTB',0,R,true); 						// 0.6 $no.'.'		0.1	,0.5
					$pdf->Cell(7.1	,0.6,$nmasbj,'RTB',0,L,true);*/					//5.6	,0.5
					
					
					
					//AWAL BUATAN BARU
						echo"
								<td>
									$nmasbj
								</td>
						";
					//AKHIR BUATAN BARU
					
					
					
					$no++;
				}
				else
				{
					$nmasbj 	=str_replace("=","","$nmasbj");
					/*$pdf->Cell(5.7	,0.5,'        '.$nmasbj,'LRTB',0,L,true);*/ // 6.2
					
					
					
					//AWAL BUATAN BARU
						echo"
								<td>
									$nmasbj
								</td>
							
							</tr>
						";
					//AKHIR BUATAN BARU
				}	
				
				
				
			}	
			
			
			
			$qry ="	SELECT 		t_prgrptps_sd.*
						FROM 		t_prgrptps_sd
						WHERE		t_prgrptps_sd.nis='$nis'		AND 
									
									t_prgrptps_sd.kdeplj='$kdeplj'"; // menghasilka per siswa per subjek (nilai akhir q1/q2/q3/q4)
			$rsl=mysql_query($qry) or die('Query gagal');
			$dat =mysql_fetch_array($rsl);
			
			/*$q1STK=$dat['st'.$sms.$midtrm."9"]; // q1
			$q1STS=$dat['st_'.$sms.$midtrm."9"]; // q1
			$q1av7=$dat['akh'.$sms.$midtrm]; // q1
			
			$q1K = $q1STK;
			$q1S = $q1STS;
			
			$ave1KS = ( $q1K + $q1S ) / 2;*/
				
			$q1fgk=$dat['fgk'.'1'.'1'];//q1
			$q2fgk=$dat['fgk'.'1'.'2'];//q2
			
			$q1fgs=$dat['fgs'.'1'.'1'];//q1
			$q2fgs=$dat['fgs'.'1'.'2'];//q2
			
			$kf = number_format( ($q1fgk+$q2fgk)/2 ,0,',','.');
			$sf = number_format( ($q1fgs+$q2fgs)/2 ,0,',','.');
			
			$av = number_format( ($kf+$sf)/2 ,0,',','.');
			
			$q2aff=$dat['aff'.$sms.$midtrm];//q2//.'1'.'2'
			
			
			
			//AWAL BUATAN BARU
			if ( $q2aff >= 90.00 AND $q2aff <= 100.00 )
				$lg7 = 'A';
			else if ( $q2aff >= 80.00 AND $q2aff <= 89.99 )
				$lg7 = 'B';
			else if ( $q2aff >= 70.00 AND $q2aff <= 79.99 )
				$lg7 = 'C';
			else if ( $q2aff >= 0.00 AND $q2aff <= 69.99 )
				$lg7 = 'D';
			else
				$lg7 = 'ERR';
			//AKHIR BAUTAN BARU
			
			
				
			/*if($q2aff>100)
				$lg7 = 'ERR';
			else if($q2aff>=91.5)
				$lg7 = 'A';
			else if($q2aff>=83.25)
				$lg7 = 'A-';
			else if($q2aff>=75)
				$lg7 = 'B+';
			else if($q2aff>=66.5)
				$lg7 = 'B';
			else if($q2aff>=58.25)
				$lg7 = 'B-';
			else if($q2aff>=41.5)
				$lg7 = "C";
			else if($q2aff>=33.25)
				$lg7 = "C-";
			else if($q2aff>=25)
				$lg7 = "D+";
			else //if($q2aff>=0)
				$lg7 = "D";*/
			
			
			
			if( ($kdekls=='P-1A' AND $kdeplj=='COM') OR ($kdekls=='P-1B' AND $kdeplj=='COM') OR ($kdekls=='P-1C' AND $kdeplj=='COM') OR ($kdekls=='P-1D' AND $kdeplj=='COM') )
			{
				/*$pdf->SetFillColor(204,204,204);*/
			}
			else
			{
				/*$pdf->SetFillColor(255,255,255);*/
			}
			
			
			
			//AWAL BUATAN BARU
			echo"
				<td align='center' width='6.5%'>
					$q1fgk
				</td>
				<td align='center' width='6.5%'>
					$q2fgk
				</td>
			";
			//AKHIR BUATAN BARU
			
			
			
			/*$pdf->SetFont('Arial','',12);
			$pdf->Cell( 1.5	,0.6,$q1fgk,'LRTB',0,C,true);				//$q1K
			$pdf->Cell( 1.5,0.6,$q2fgk,'LRTB',0,C,true);*/				//K//$lgK
			
			if( ($kdekls=='P-1A' AND $kdeplj=='COM') OR ($kdekls=='P-1B' AND $kdeplj=='COM') OR ($kdekls=='P-1C' AND $kdeplj=='COM') OR ($kdekls=='P-1D' AND $kdeplj=='COM') )
			{
				/*$pdf->SetFillColor(204,204,204);*/
				$kf='';
			}
			else
			{
				//$pdf->SetFillColor(0, 183, 235);
			}
			
			
			
			//AWAL BUATAN BARU
			echo"
				<td align='center' width='6.5%' bgcolor='lightgrey'>
					$kf
				</td>
			";
			//AKHIR BUATAN BARU
			
			
			
			/*$pdf->Cell( 1.5	,0.6,$kf,'LRTB',0,C,true);*///S//$q1S
			
			
			
			if( ($kdekls=='P-1A' AND $kdeplj=='COM') OR ($kdekls=='P-1B' AND $kdeplj=='COM') OR ($kdekls=='P-1C' AND $kdeplj=='COM') OR ($kdekls=='P-1D' AND $kdeplj=='COM') )
			{
				/*$pdf->SetFillColor(204,204,204);*/
			}
			else
			{
				/*$pdf->SetFillColor(255,255,255);*/
			}
			
			
			
			//AWAL BUATAN BARU
			echo"
				<td align='center' width='6.5%'>
					$q1fgs
				</td>
				<td align='center' width='6.5%'>
					$q2fgs
				</td>
			";
			//AKHIR BUATAN BARU
			
			
			
			/*$pdf->Cell( 1.5,0.6,$q1fgs,'LRTB',0,C,true);//$lgS
			$pdf->Cell( 1.5	,0.6,$q2fgs,'LRTB',0,C,true);*///$ave1KS
			
			if( ($kdekls=='P-1A' AND $kdeplj=='COM') OR ($kdekls=='P-1B' AND $kdeplj=='COM') OR ($kdekls=='P-1C' AND $kdeplj=='COM') OR ($kdekls=='P-1D' AND $kdeplj=='COM') )
			{
				/*$pdf->SetFillColor(204,204,204);*/
				$sf='';
			}
			else
			{
				//$pdf->SetFillColor(0, 183, 235);
			}
				
			
			
			//AWAL BUATAN BARU
			echo"
				<td align='center' width='6.5%' bgcolor='lightgrey'>
					$sf
				</td>
			";
			//AKHIR BUATAN BARU
			
			
			
			/*$pdf->Cell( 1.5	,0.6,$sf,'LRTB',0,C,true);*///$lgKS
			
			
			
			if( ($kdekls=='P-1A' AND $kdeplj=='COM') OR ($kdekls=='P-1B' AND $kdeplj=='COM') OR ($kdekls=='P-1C' AND $kdeplj=='COM') OR ($kdekls=='P-1D' AND $kdeplj=='COM') )
			{
				/*$pdf->SetFillColor(204,204,204);*/
				$av='';
			}
			else
			{
				//$pdf->SetFillColor(255, 255, 0);
			}
				
			
			
			//AWAL BUATAN BARU
			echo"
				<td align='center' width='6.5%' bgcolor='yellow'>
					$av
				</td>
			";
			//AKHIR BUATAN BARU
			
			
			
			/*$pdf->Cell( 1.5	,0.6,$av,'LRTB',0,C,true);*///$lg7
			
			
			
			if( ($kdekls=='P-1A' AND $kdeplj=='COM') OR ($kdekls=='P-1B' AND $kdeplj=='COM') OR ($kdekls=='P-1C' AND $kdeplj=='COM') OR ($kdekls=='P-1D' AND $kdeplj=='COM') )
			{
				/*$pdf->SetFillColor(204,204,204);*/
				$lg7='';
			}
			else
			{
				/*$pdf->SetFillColor(255, 255, 255);*/
			}
			
			
			
			//AWAL BUATAN BARU
			echo"
					<td align='center'>
						$lg7
					</td>
				</tr>
			";
			//AKHIR BUATAN BARU
			
			
			
			/*$pdf->Cell( 1.5	,0.6,$lg7,'LRTB',0,C,true);
			
			
			
			$pdf->SetTextColor(0,0,0);
			
			$pdf->Ln();*/
		}	
		
		
		
		$j++;
		$id++;
		//$id=$cell[$j][0];
	}
	
	
	
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
	
	
	
	echo"			
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
		else //if($q1KAR=='-')
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
	
}//cetak all

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