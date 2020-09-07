<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04G_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
require_once FUNGSI_UMUM_DIR.'rotation.php';

class PDF extends PDF_Rotate
{
	function RotatedText($x,$y,$txt,$angle)
	{
		//Text rotated around its origin
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}

	function RotatedImage($file,$x,$y,$w,$h,$angle)
	{
		//Image rotated around its upper-left corner
		$this->Rotate($angle,$x,$y);
		$this->Image($file,$x,$y,$w,$h);
		$this->Rotate(0);
	}
}

$kdekls	=$_POST['kdekls'];
$sms	=$_POST['sms'];
$midtrm	=$_POST['midtrm'];
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
$query	="	SELECT 		t_setthn.*
			FROM 		t_setthn
			WHERE		t_setthn.set='Tahun Ajaran'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$thnajr=$data[nli];

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
switch($kdetkt)
{
	case 'PS':
		$judul	=$nama_pt_ps;
		break;
	case 'JHS':
		$judul	=$nama_pt_jhs;
		break;
	case 'SHS':
		$judul	=$nama_pt_shs;
		break;
}		
$judul2='SKILL & BEHAVIOUR '.'SEMESTER '.$sms.' MID TERM REPORT '.$midtrm;

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
				ORDER BY	t_prstkt.kdejbt ASC";
	$result =mysql_query($query) or die('Query gagal3');
	$data 	=mysql_fetch_array($result);
	$kplskl=$data[nmakry];
}

$logo_pt	="../../images/logo.jpg";
$logo_ttw	="../../images/tutwurihandayani.jpg";

$pdf = new PDF('P','cm','A4');
$pdf->SetMargins(1,0.4,1);
$pdf->SetAutoPageBreak(True, 0.4);

$query2	="	SELECT 		t_setpsrpt.*
			FROM 		t_setpsrpt
			WHERE		t_setpsrpt.kdetkt='$kdetkt' AND t_setpsrpt.kdeplj!=''
			ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id";
$result2=mysql_query($query2) or die('Query gagal4');
$x=1;
while($data2 = mysql_fetch_array($result2))
{
	$cell2[$x][0] 	=$data2[nmasbj];
	$x++;
}

$query 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' 
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw";
$result =mysql_query($query) or die('Query gagal5');

while($data =mysql_fetch_array($result))
{
	$nis=$data[nis];
	$nmassw=$data[nmassw];
	$query1 ="	SELECT 		t_indbhvps.*,t_setpsbhv.*
				FROM 		t_indbhvps,t_setpsbhv
				WHERE		t_indbhvps.nis=$nis		AND
							t_indbhvps.id=t_setpsbhv.id
				ORDER BY	t_indbhvps.id,t_indbhvps.idkdeplj";
	$result1=mysql_query($query1) or die('Query gagal6');

	$i=1;
	while($data1 = mysql_fetch_array($result1))
	{
		$cell1[$i][0] 	=$data1[id];
		$id				=$data1[id];
		$cell1[$i][1] 	=$data1[kdeplj];
		$cell1[$i][2] 	=$data1['midtrm'."$sms"."$midtrm"];
		$cell1[$i][3] 	=$data1[indctring];
		$cell1[$i][4] 	=$data1[indctrind];
		$i++;
	}

	$j	=1;
	$Hlm=1;
	$pdf->Open();
	$pdf->AddPage();
	$pdf->Image($logo_pt ,1,1,2,2);
	$pdf->Image($logo_ttw,18,1,2,2);
	$pdf->Ln(0.8);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(19	,0.4, $judul,0,0,C);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Cell(19	,0.4, $judul2,0,0,C);
	$pdf->Ln();
	$pdf->Cell(19	,0.4, $thnajr,0,0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(19	,0.3, $alamat1_pt1,0,0,C);
	$pdf->Ln();
	$pdf->Cell(19	,0.3, $alamat2_pt2,0,0,C);
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(1);
	$pdf->Cell( 19	,0.4,"Skill and Behaviours that Support Learning (Keahlian dan Tingkah Laku yang Mendukung Pembelajaran)",0,0,L); 
	$pdf->Ln();
	$pdf->Cell( 19	,0.4,"( A-Excelent     B-Good     C-Sufficient     D-Needs Improvement )",0,0,L); 
	$pdf->Ln();
	
	$t=19-(($x-1)*0.5);
		
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell( $t	,5.5,'Indicator of Behaviour Performance','LRTB',0,C);
	$y=1;
	while($y<$x)
	{
		$pdf->Cell( 0.5	,5.5,'','LRTB',0,C);
		$y++;
	}
	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell( $t	,-4.5,'of '.$nmassw.' ( '.$nis.' )','',0,C);
	$pdf->Ln();
	$pdf->Cell( $t	,5.5,'Class : '.$kdekls,'',0,C);
	$pdf->Ln(4.5);
	$pdf->SetFont('Arial','',7);
	$y=1;
	while($y<$x)
	{
		$p=$t+1.3+(($y*0.5)-0.5);
		$q=strpos($cell2[$y][0], '.');
		$sbj=$cell2[$y][0];
		$pdf->RotatedText($p,9.9,$sbj,90);
		$y++;
	}
	$pdf->SetFont('Arial','',7);
	$j=1;
	while ($j<$i)
	{
		//menampilkan data dari hasil query database
		
		$id		  =$cell1[$j][0];
		$indctring=$cell1[$j][3];
		$indctrind=$cell1[$j][4];
		$pdf->Cell($t	,0.4,$indctring,'LRT',0,L);
		$y=1;
		while($id==$cell1[$j][0] AND $y<$x)
		{
			$pdf->Cell( 0.5	,0.8,$cell1[$j][2],'LRTB',0,C);
			$y++;
			$j++;
		}
		$pdf->Ln();
		$pdf->Cell($t	,-0.4,$indctrind,'LRT',0,L);
		$y=1;
		while($y<$x)
		{
			$pdf->Cell( 0.5	,0);
			$y++;
		}
		$pdf->Ln();
		
	}
	$pdf->Ln(0.3);
	$pdf->SetFont('Arial','B',7);	
	$pdf->Cell(19	,0.4,'Extra Curricular Activities ( A-Excelent     B-Good     C-Sufficient     D-Needs Improvement )','',0,L);
	$pdf->Ln();
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 0.5	,0.4,'No','LRTB',0,C,true);
	$pdf->Cell( 4.5	,0.4,'Jenis Kegiatan / Activity','LRTB',0,C,true);
	$pdf->Cell(14	,0.4,'Keterangan / Description','LRTB',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);

	$query3	="	SELECT 		t_extcrrps.*,t_mstplj.*
				FROM 		t_extcrrps,t_mstplj
				WHERE		t_extcrrps.nis='$nis'	AND
							t_extcrrps.kdeplj=t_mstplj.kdeplj
				ORDER BY	t_extcrrps.kdeplj";
	$result3=mysql_query($query3) or die('Query gagal40');

	$z=0;
	while($data3 = mysql_fetch_array($result3))
	{
		$cell3[$z][0]=$data3['nmaplj'].' : '.$data3['ext'."$sms"."$midtrm"];
		$cell3[$z][1]=$data3['ktr'."$sms"."$midtrm"];
		$z++;
	}
	
	$z=0;
	$no=1;
	while($z<4)
	{
		$pdf->Cell( 0.5	,0.4,$no,'LRTB',0,C);
		$pdf->Cell( 4.5	,0.4,$cell3[$z][0],'LRTB',0,L);
		$pdf->Cell(14	,0.4,$cell3[$z][1],'LRTB',0,L);
		$pdf->Ln();
		$z++;
		$no++;
	}

	$query3	="	SELECT 		t_khdrnps.*,t_mstplj.*
				FROM 		t_khdrnps,t_mstplj
				WHERE		t_khdrnps.nis='$nis'";
	$result3=mysql_query($query3) or die('Query gagal');
	$data3 = mysql_fetch_array($result3);
	$skt=$data3['skt'."$sms"."$midtrm"];
	$izn=$data3['izn'."$sms"."$midtrm"];
	$alp=$data3['alp'."$sms"."$midtrm"];
	$ttl=$skt+$izn+$alp;
	
	$pdf->Ln(0.4);
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell(19	,0.4,'Ketidakhadiran / Attendance Record','',0,L);
	$pdf->Ln();
	$pdf->Cell( 0.5	,0.4,'No','LRTB',0,C,true);
	$pdf->Cell( 4.5	,0.4,'Alasan / Reason','LRTB',0,C,true);
	$pdf->Cell(14	,0.4,'Lama / Days','LRTB',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 0.5	,0.4,'1','LRTB',0,C);
	$pdf->Cell( 4.5	,0.4,'Sakit / Sickness','LRTB',0,C);
	$pdf->Cell(14	,0.4,$skt,'LRTB',0,C);
	$pdf->Ln();
	$pdf->Cell( 0.5	,0.4,'2','LRTB',0,C);
	$pdf->Cell( 4.5	,0.4,'Izin / Excused','LRTB',0,C);
	$pdf->Cell(14	,0.4,$izn,'LRTB',0,C);
	$pdf->Ln();
	$pdf->Cell( 0.5	,0.4,'3','LRTB',0,C);
	$pdf->Cell( 4.5	,0.4,'Alpa / Non-Excused','LRTB',0,C);
	$pdf->Cell(14	,0.4,$alp,'LRTB',0,C);
	$pdf->Ln();
	$pdf->Cell( 0.5	,0.4,'','LRTB',0,C);
	$pdf->Cell( 4.5	,0.4,'Total','LRTB',0,C);
	$pdf->Cell(14	,0.4,$ttl,'LRTB',0,C);
	
	$pdf->Ln(0.6);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell( 6	,0.4,'Acknowledged by','',0,C);
	$pdf->Cell( 7	,0.4,'','',0,C);
	$pdf->Cell( 6	,0.4,'Bekasi, '.$tglctk,'',0,C);
	$pdf->Ln();
	$pdf->Cell( 6	,0.4,'Parents / Guardian,','',0,C);
	$pdf->Cell( 7	,0.4,'','',0,C);
	$pdf->Cell( 6	,0.4,'Homeroom Teacher','',0,C);
	$pdf->Ln(1.6);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 6	,0.4,"                                                      ",'',0,C);
	$pdf->Cell( 7	,0.4,'','',0,C);
	$pdf->Cell( 6	,0.4,$wlikls,'',0,C);
	$pdf->Ln();
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 7	,0.4,'Approved by','',0,C);
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->Ln(1.6);
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell( 7	,0.4,$kplskl,'',0,C);
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->Ln();
	$pdf->Cell( 6	,0.4,'','',0,C);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell( 7	,0.4,'Principal','',0,C);
	$pdf->Cell( 6	,0.4,'','',0,C);
};
$pdf->Output();
?>