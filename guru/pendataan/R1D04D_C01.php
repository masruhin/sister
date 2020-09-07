<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04D_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kdekls	=$_POST['kdekls'];
$idwa	=$_POST['idwa'];
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

// dapatkan data tingkat dan wali kelas
$query 	="	SELECT 		t_setpgwa.*
			FROM 		t_setpgwa
			WHERE 		t_setpgwa.idwa='". mysql_escape_string($idwa)."'";
$result =mysql_query($query) or die('Query gagal2');
$data 	=mysql_fetch_array($result);
$nmawa	=$data[nmawa];


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
	case 'PG':
		$judul1	='PLAY GROUP';
		break;
	case 'KG':
		$judul1	='KINDERGARTEN';
		break;
}		
$judul2='STUDENT WEEKLY PROGRESS';

// dapatkan data kepala sekolah
$query 	="	SELECT 		t_prstkt.*,t_mstkry.*
			FROM 		t_prstkt,t_mstkry
			WHERE 		t_prstkt.kdetkt='". mysql_escape_string($kdetkt)."' AND
						t_prstkt.kdekry=t_mstkry.kdekry						AND
						t_prstkt.kdejbt=100";
$result =mysql_query($query) or die('Query gagal2');
$data 	=mysql_fetch_array($result);
$kplskl=$data[nmakry];

$logo	="../../images/logo.jpg";

$pdf = new FPDF('P','cm','A4');
$pdf->SetMargins(1,0.5,1);
$pdf->SetAutoPageBreak(True, 0.5);
$pdf->AddFont('FRIZQUAD','','FRIZQUAD.php');

$query 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."' AND
							t_mstssw.str!='K'
			ORDER BY	t_mstssw.kdekls,t_mstssw.nmassw";
$result =mysql_query($query) or die('Query gagal3');

while($data =mysql_fetch_array($result))
{
	$nis=$data[nis];
	$nmassw=$data[nmassw];

	
	$hlm=1;
	$pdf->Open();	
	$pdf->AddPage();
	$pdf->Image($logo,1,1,2,2);
	$pdf->Ln(0.7);
	$pdf->SetFont('FRIZQUAD','',8);
	$pdf->Cell( 2.3	,1);
	$pdf->Cell(10.7	,1, $nama_pt2_a);
	$pdf->SetFont('arial','B',8);
	$pdf->Cell( 6	,1, $nama_pt,'',0,R);
	$pdf->SetFont('FRIZQUAD','',20);
	$pdf->Ln();
	$pdf->Cell( 2.3	,-0.1);
	$pdf->Cell(10.7	,-0.1, $nama_pt2);
	$pdf->SetFont('arial','',6);
	$pdf->Cell( 6	,-0.5, $alamat1_pt,'',0,R);
	$pdf->Ln();
	$pdf->SetFont('FRIZQUAD','',8);
	$pdf->Cell( 2.3	,1.7);
	$pdf->Cell( 7.2	,1.7,$nama_pt2_b,'',0,R); 
	$pdf->SetFont('arial','',6);
	$pdf->Cell( 9.5	,1, $alamat2_pt,'',0,R);
	$pdf->Ln();
	$pdf->SetFont('arial','',6);
	$pdf->Cell(19	,-0.5, $alamat3_pt,'',0,R);

	$pdf->Ln();
	$pdf->SetFont('arial','BU',11);
	$pdf->Cell(19	,2.5, $judul1,0,0,C);
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(1.5);
	$pdf->Cell(19	,0.3, $judul2,0,0,C);
	$pdf->Ln();
	$pdf->Cell(19	,0.4, $nmawa,0,0,C);
	$pdf->SetFont('Arial','',7);
	$pdf->Ln(0.2);
	$pdf->Cell(19	,0.4, 'Note to parents :',0,0,L);
	$pdf->Ln();
	$pdf->Cell(19	,0.3, 'a. The lessons for this week are listed below (see topic and outcomes / expectations).',0,0,L);
	$pdf->Ln();
	$pdf->SetFont('Arial','I',7);
	$pdf->Cell(19	,0.2, '    Pelajaran/pelajaran untuk minggu ini tercantum di bawah (harap melihat bagian topic dan tujuan pembelajaran).',0,0,L);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(19	,0.3, 'b. The Overview of progress will be sent home at the end of the week.',0,0,L);
	$pdf->Ln();
	$pdf->SetFont('Arial','I',7);
	$pdf->Cell(19	,0.2, '    Gambaran perkembangan siswa akan diinformasikan pada akhir minggu.',0,0,L);
	$pdf->Ln(0.3);
	$pdf->SetFont('arial','B',8);
	$pdf->Cell( 7.5	,0.4,"Name : ".$nmassw,0,0,L); 
	$pdf->Cell( 4	,0.4,"Class : ".$kdekls,0,0,L); 
	$pdf->Cell( 7.5	,0.4,"Homeroom Teacher : ".$wlikls,0,0,R); 
	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(153,153,153);
	$pdf->Cell( 7.3	,0.8,'Subject and Topic','LRTB'	,0,C,true);
	$pdf->Cell( 7.7	,0.8,'Outcomes / Expectations'	,'LRTB',0,C,true);
	$pdf->Cell( 4	,0.4,'Overview of Progress'	 	,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->Cell(7.3	,0.4);
	$pdf->Cell(7.7	,0.4);
	$pdf->Cell(0.8	,0.4,'A'	 	,'LRTB',0,C,true);
	$pdf->Cell(0.8	,0.4,'B'	 	,'LRTB',0,C,true);
	$pdf->Cell(0.8	,0.4,'C'	 	,'LRTB',0,C,true);
	$pdf->Cell(0.8	,0.4,'D'	 	,'LRTB',0,C,true);
	$pdf->Cell(0.8	,0.4,'N/A'	 	,'LRTB',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);

	$query2	="	SELECT 		t_setpgwaplj.* 
				FROM 		t_setpgwaplj 
				WHERE 		t_setpgwaplj.kdetkt='". mysql_escape_string($kdetkt)."'	
				ORDER BY 	t_setpgwaplj.kdetkt,t_setpgwaplj.idplj";
	$result2=mysql_query($query2) or die (mysql_error());

	$i=0;
	while($data2 = mysql_fetch_array($result2))
	{
		$cell[$i][0] 	=$data2['kdeplj'];
		$kdeplj			=$data2['kdeplj'];
		$cell[$i][1] 	=$data2['nmaplj'];

		$query3	="	SELECT 		t_setpgwatpk.* 
					FROM 		t_setpgwatpk 
					WHERE 		t_setpgwatpk.idwa='". mysql_escape_string($idwa)."'	AND
								t_setpgwatpk.kdeplj='". mysql_escape_string($kdeplj)."'";
		$result3=mysql_query($query3) or die (mysql_error());
		$data3 	=mysql_fetch_array($result3);
						
		$cell[$i][2] 	=$data3['tpk1'];
		$cell[$i][3] 	=$data3['tpk2'];
		$cell[$i][4] 	=$data3['tpk3'];
		$cell[$i][5] 	=$data3['tpk4'];
		$cell[$i][6] 	=$data3['tpk5'];
		$cell[$i][7] 	=$data3['out1'];
		$cell[$i][9] 	=$data3['out2'];
		$cell[$i][11] 	=$data3['out3'];
		$cell[$i][13] 	=$data3['out4'];
		$cell[$i][15] 	=$data3['out5'];
							
		$query3	="	SELECT 		t_wapg.* 
					FROM 		t_wapg 
					WHERE 		t_wapg.nis='". mysql_escape_string($nis)."' AND
								t_wapg.idwa='". mysql_escape_string($idwa)."' AND
								t_wapg.kdeplj='". mysql_escape_string($kdeplj)."'";
		$result3=mysql_query($query3) or die (mysql_error());
		$data3 	=mysql_fetch_array($result3);
		$cell[$i][8] 	=$data3['nliout1'];
		$cell[$i][10] 	=$data3['nliout2'];
		$cell[$i][12] 	=$data3['nliout3'];
		$cell[$i][14] 	=$data3['nliout4'];
		$cell[$i][16] 	=$data3['nliout5'];
		$i++;
	}
	
	$j=0;
	while ($j<$i)
	{
		$kdeplj	=$cell[$j][0];
		$nmaplj	=$cell[$j][1];
		$bg='false';
		$pdf->SetFont('Arial','B',7);
		$pdf->SetFillColor(204,204,204);
		$pdf->Cell( 19	,0.4,$nmaplj,'LRTB',0,L,$bg);
		$pdf->Ln();
		$pdf->SetFont('Arial','',6);
		$x=1;
		while($x<6)
		{
			if($cell[$j][$x*2+5]!='' OR $cell[$j][$x+1]!='')
			{
				$pdf->Cell( 7.3	,0.4,$cell[$j][$x+1],'LRTB',0,L);
				$pdf->Cell( 7.7	,0.4,$cell[$j][$x*2+5],'LRTB',0,L);
			
				$y=1;
				while($y<6)
				{
					$tanda='';
					if(($y==1 AND $cell[$j][$x*2+6]=='A') OR ($y==2 AND $cell[$j][$x*2+6]=='B') OR ($y==3 AND $cell[$j][$x*2+6]=='C') OR ($y==4 AND $cell[$j][$x*2+6]=='D') OR ($y==5 AND $cell[$j][$x*2+6]=='N'))
						$tanda='V';
			
					$pdf->Cell( 0.8	,0.4,$tanda,'LRTB',0,C);
					$y++;
				}	
				$pdf->Ln();				
			}	
			$x++;
		}
		$j++;
	}
	
	//------------------------------------------- Attendance --------------------------	
	$query3	="	SELECT 		t_wapgabs.* 
				FROM 		t_wapgabs 
				WHERE 		t_wapgabs.nis='". mysql_escape_string($nis)."' AND
							t_wapgabs.idwa='". mysql_escape_string($idwa)."'";
	$result3=mysql_query($query3) or die (mysql_error());
	$data3 	=mysql_fetch_array($result3);
	$att 	=$data3['att'];
	$abs 	=$data3['abs'];
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(204,204,204);
	$pdf->Cell( 17	,0.4,'Attendance','LRT',0,C,true);
	$pdf->Cell( 2	,0.4,'Days','LRT',0,C,true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(17	,0.4, 'Days Attended','LRTB',0,L); 
	$pdf->Cell( 2	,0.4, $att,'LRTB',0,C); 
	$pdf->Ln();
	$pdf->Cell(17	,0.4, 'Days Absent','LRTB',0,L); 
	$pdf->Cell( 2	,0.4, $abs,'LRTB',0,C); 
	$pdf->Ln();
	//---------------------------------------------------------------------
	$pdf->Ln(0.2);
	$pdf->SetFont('Arial','I',7);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(19	,0.5,'Scoring Symbols :      A-Excellent          B-Very Good          C-Good          D-Keep Trying          N/A-Not Applicable','LRTB',0,C,true);
};
$pdf->Output();
?>