<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04I_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdeplj	=$_POST['kdeplj'];
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

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt.*
			FROM 		t_mstbbt
			WHERE		t_mstbbt.kdebbt='1HW'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt.*
			FROM 		t_mstbbt
			WHERE		t_mstbbt.kdebbt='2PRJ'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt.*
			FROM 		t_mstbbt
			WHERE		t_mstbbt.kdebbt='3TES'";
$result	=mysql_query($query) or die('Query gagal1');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt.*
			FROM 		t_mstbbt
			WHERE		t_mstbbt.kdebbt='4MID'";
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

// dapatkan data tingkat 
$query 	="	SELECT 		t_mstkls.*,t_klmkls.*
			FROM 		t_mstkls,t_klmkls
			WHERE 		t_mstkls.kdekls='". mysql_escape_string($kdekls)."' AND
						t_mstkls.kdeklm=t_klmkls.kdeklm";
$result =mysql_query($query) or die('Query gagal2');
$data 	=mysql_fetch_array($result);
$kdetkt=$data[kdetkt];
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
if($sms=='1')
	$nmasms='FIRST SEMESTER ';
else
	$nmasms='SECOND SEMESTER ';
$judul2=$nmasms.'MASTER SHEET REPORT '.$midtrm;

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

$pdf =new FPDF('P','cm','A4');
$pdf->SetMargins(1,0.4,1);
$pdf->SetAutoPageBreak(True, 0.4);

$query 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' 
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw";
$result =mysql_query($query) or die('Query gagal5');
$bghw	=1;
$bgprj	=1;
$bgtes	=1;
$i=0;
while($data =mysql_fetch_array($result))
{
	$cell[$i][0]=$data[nis];
	$nis		=$data[nis];
	$cell[$i][1]=$data[nmassw];
	
	$query2 ="	SELECT 		t_prgrptps.*
				FROM 		t_prgrptps
				WHERE		t_prgrptps.nis	='$nis'		AND
							t_prgrptps.kdeplj='$kdeplj'";
	$result2=mysql_query($query2) or die('Query gagal');
	$data2	=mysql_fetch_array($result2);
	$y	=1;
	$hw	=0;
	$prj=0;
	$tes=0;
	while($y<6)
	{
		if($data2['hw'."$sms"."$midtrm"."$y"]!=0)
			$hw++;
		if($data2['prj'."$sms"."$midtrm"."$y"]>0)
			$prj++;
		if($data2['tes'."$sms"."$midtrm"."$y"]>0)
			$tes++;	
		$y++;	
	}
	if($hw>$bghw)
		$bghw=$hw;
	if($prj>$bgprj)
		$bgprj=$prj;
	if($tes>$bgtes)
		$bgtes=$tes;
	
	$i++;
}

$j=0;
while($j<$i)
{
	$nis	=$cell[$j][0];
	$nmassw	=$cell[$j][1];
	$cell2[$j][0]=$nis;
	$cell2[$j][1]=$nmassw;

	$query2 ="	SELECT 		t_setpsrpt.*
				FROM 		t_setpsrpt
				WHERE		t_setpsrpt.kdetkt='$kdetkt'	AND
							t_setpsrpt.kdeplj!=''
				ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id";
	$result2=mysql_query($query2) or die('Query gagal');
	$data2 	=mysql_fetch_array($result2);
	while($data2=mysql_fetch_array($result2))
	{
		$idkdeplj	=$data2[id];
		$kdeplj		=$data2[kdeplj];
		
		$cell2[$j][2]=$idkdeplj;
		$cell2[$j][3]=$kdeplj;
		
		$query3 ="	SELECT 		t_prgrptps.*
					FROM 		t_prgrptps
					WHERE		t_prgrptps.nis='$nis'		AND
								t_prgrptps.kdeplj='$kdeplj'";
		$result3=mysql_query($query3) or die('Query gagal');
		$data3 	=mysql_fetch_array($result3);
		//------hw
		$ttlhw=0;
		$y=1;
		while($y<6)
		{
			$hw=$data3['hw'."$sms"."$midtrm"."$y"];
			$ttlhw=$ttlhw+$hw;
			$y++;
		}		
		$avghw	=$ttlhw/$bghw;
		$bavghw	=($avghw*$bbthw)/100;

		//------prj
		$ttlprj=0;
		$y=1;
		while($y<6)
		{
			$prj=$data3['prj'."$sms"."$midtrm"."$y"];
			$ttlprj=$ttlprj+$prj;
			$y++;
		}		
		$avgprj	=$ttlprj/$bgprj;
		$bavgprj	=($avgprj*$bbtprj)/100;

		//------tes
		$ttltes=0;
		$y=1;
		while($y<6)
		{
			$tes=$data3['tes'."$sms"."$midtrm"."$y"];
			$ttltes=$ttltes+$tes;
			$y++;
		}		
		$avgtes	=$ttltes/$bgtes;
		$bavgtes	=($avgtes*$bbttes)/100;

		$ttl	=$bavghw+$bavgprj+$bavgtes;
		$ttl70	=$ttl*((100-$bbtmidtes)/100);
		$midtes		=$data3['midtes'."$sms"."$midtrm"];
		$midtes30	=($midtes*$bbtmidtes)/100;
		$fnl		=$ttl70+$midtes30;
	}	
	$cell2[$j][4]=$fnl;
	$j++;
}		

$k=0;
$l=0;
while($k<$j)
{
	$nis	=$cell2[$k][0];
	$nmassw	=$cell2[$k][1];
	$cell3[$l][0]=$nis;
	$cell3[$l][1]=$nmassw;
	$m		=2;
	$sum	=0;
	while($k<$j AND $nis = $nis	=$cell2[$k][0])
	{
		$cell3[$l][$m]	=$cell2[$k][4];
		$sum			=$sum+$cell2[$k][4];
		$m++;
		$k++;
	}
	$cell3[$l][$m]=$sum;
	$l++;
}
		
$hlm=1;
$no	=1;
$j	=0;
while($j<$l)
{
	$pdf->Open();
	$pdf->AddPage('L');
	$pdf->Image($logo_pt ,1,1,2,2);
	$pdf->Image($logo_ttw,27,1,2,2);
	$pdf->Ln(0.8);
	$pdf->SetFont('arial','B',11);
	$pdf->Cell(28	,0.4, $judul,0,0,C);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Cell(28	,0.4, $judul2,0,0,C);
	$pdf->Ln();
	$pdf->Cell(28	,0.4, $thnajr,0,0,C);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(28	,0.3, $alamat1_pt1,0,0,C);
	$pdf->Ln();
	$pdf->Cell(28	,0.3, $alamat2_pt2,0,0,C);
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(1);
	$pdf->Cell( 1	,0.4,"Grade",0,0,L); 
	$pdf->Cell(27	,0.4,": ".$kdekls,0,0,L); 
	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 0.6	,0.4,'No','LRTB',0,C,true);
	$pdf->Cell( 5.5	,0.4,'Name','LRTB',0,C,true);
	$n=2;
	while($n<$m)
	{
		$pdf->Cell( 0.9	,0.4,$n,'LRTB',0,C,true);
		$n++;
	}

	$pdf->Ln();
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(255,255,255);
	$x=1;
	while($j<$l AND $x<=25)
	{
		$pdf->Cell( 0.6	,0.4,$no,'LRTB',0,C,true);
		$pdf->Cell( 5.5	,0.4,$cell3[$j][1],'LRTB',0,C,true);
		$n=2;
		while($n<$m)
		{
			$pdf->Cell( 0.9	,0.4,$cell3[$j][$n],'LRTB',0,C,true);
			$n++;
		}
		$pdf->Ln();		
		$j++;
		$x++;
		$no++;
	}

	$pdf->Ln(1);
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	if($j<$i)
	{
		$pdf->Cell(28	,0.4," Page : ".$hlm." Continued on page ".($hlm+1),'',0,R,true);
		$hlm++;
	}
	else
	{
		$pdf->Cell( 14	,0.4,'Bekasi, '.$tglctk,'',0,C,true);
		$pdf->Cell( 14	,0.4,'','',0,C,true);
		$pdf->Ln();
		$pdf->Cell( 14	,0.4,'Subject Teacher','',0,C,true);
		$pdf->Cell( 14	,0.4,'Approved by','',0,C,true);
		$pdf->Ln(2);
		$pdf->SetFont('Arial','U',8);
		$pdf->Cell( 14	,0.4,$nmagru,'',0,C,true);
		$pdf->Cell( 14	,0.4,$kplskl,'',0,C,true);
		$pdf->Ln();
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(28	,0.4," Page : ".$hlm,'',0,R,true);
	}
};
$pdf->Output();
?>