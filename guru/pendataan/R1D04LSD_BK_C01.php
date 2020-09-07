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
$nis	=$kodekelas;
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

$nisssw=substr($nis,0,3);

$tglskr=date('d');
$blnskr=date('m');
$thnskr=date('Y');

if( $blnskr=='01' )
	$blnskr='I';
else if( $blnskr=='02' )
	$blnskr='II';
else if( $blnskr=='03' )
	$blnskr='III';
else if( $blnskr=='04' )
	$blnskr='IV';
else if( $blnskr=='05' )
	$blnskr='V';
else if( $blnskr=='06' )
	$blnskr='VI';
else if( $blnskr=='07' )
	$blnskr='VII';
else if( $blnskr=='08' )
	$blnskr='VIII';
else if( $blnskr=='09' )
	$blnskr='IX';
else if( $blnskr=='10' )
	$blnskr='X';
else if( $blnskr=='11' )
	$blnskr='XI';
else if( $blnskr=='12' )
	$blnskr='XII';



//..



$query 	="	SELECT 		t_hdrkmnps_sd_det.*
			FROM 		t_hdrkmnps_sd_det
			WHERE		t_hdrkmnps_sd_det.nis='". mysql_escape_string($nis)."'
			";
$result =mysql_query($query) or die('Query gagal');

$i=0;
while($data = mysql_fetch_array($result))
{
	//$cell[$i][0] 	=$data[nokode];
	$cell[$i][1] 	=$data[tgl];
	$cell[$i][2] 	=$data[wkt];
	$cell[$i][3] 	=$data[kmn];
	$cell[$i][4] 	=$data[tind];
	$cell[$i][5] 	=$data[jenis];
	$cell[$i][6] 	=$data[peny];
	/*
	$nokode 	=$data[nokode];
	$tgl	 	=$data[tgl];
	$wkt	 	=$data[wkt];
	$kmn	 	=$data[kmn];//annectdotal record
	$tind	 	=$data[tind];//school action
	*/
	$i++;
}

$query2 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE		t_mstssw.nis='". mysql_escape_string($nis)."'
			";
$result2 =mysql_query($query2) or die('Query gagal');

if($data2 = mysql_fetch_array($result2))
{
	$nmassw 	=$data2[nmassw];
	$jnsklm 	=$data2[jnsklm];
	$tgllhr 	=$data2[tgllhr];
	$kdekls 	=$data2[kdekls];
	
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
	
	$tgllhr	=strtotime($tgllhr);
	$tgllhr	=date('d F, Y',$tgllhr);
	
	//$tgllhr	=date('d F, Y');
}

$query3 	="	SELECT 		t_hdrkmnps_sd_det.*
			FROM 		t_hdrkmnps_sd_det
			WHERE		t_hdrkmnps_sd_det.nis='". mysql_escape_string($nis)."' AND 
						t_hdrkmnps_sd_det.peny!=''
			";
$result3 =mysql_query($query3) or die('Query gagal');

$m=0;
while($data3 = mysql_fetch_array($result3))
{
	$cell3[$m][1] 	=$data3[tgl];
	$cell3[$m][6] 	=$data3[peny];
	
	$m++;
}

$query4 	="	SELECT 		t_mstkls.*,t_klmkls.*,t_mstkry.*
			FROM 		t_mstkls,t_klmkls,t_mstkry
			WHERE 		t_mstkls.kdekls='". mysql_escape_string($kdekls)."' AND
						t_mstkls.kdeklm=t_klmkls.kdeklm	AND
						t_mstkls.wlikls=t_mstkry.kdekry";
$result4 =mysql_query($query4) or die('Query gagal2');
$data4 	=mysql_fetch_array($result4);
$wlikls=$data4[nmakry];
$gelar=$data4[gelar];



//..



echo"

	<!--<center>
			<img src='../../images/logo_sd.jpg' />
			<br/>
			<b><u><font size='4'>GUIDANCE & COUNSELING SERVICE</font></u>
			<br/>
			<font size='4'>Saint John's School Meruya</font></b>
			<br/>
			Taman Villa Meruya, Blok D1/1, Kembangan Jakarta Barat
			<br/>
			Telp: 589-02399, Fax:589-02398
	</center>-->
	
	<table width='100%'>
		<tr>
			<td align='right'>	<img src='../../images/logo_sd.jpg' />	</td>
			<td align='center'>
				<b>
					<font face='Century Gothic' size='4'>Guidance and Counseling Service</font>	<br/>
					<font face='Times New Roman' size='5'>SAINT JOHN'S PRIMARY SCHOOL</font>	<br/>
					Jl. Taman Palem Raya Blok D1 No. 1 Taman Villa Meruya, 				<br/>
					Kembangan, Jakarta Barat 11650 										<br/>
					Telp.: 021-58902399     Email: guidancecounselingsjs@gmail.com				
				</b>
			</td>
			<td align='left'>	<img src='../../images/tangen.jpg' />	</td>
		</tr>
	</table>
	
	<hr/>
	
	<br/>
	
	<table>
		<tr>
			<td>	No. Kode	</td><td>	:	</td><td>	$tglskr$nisssw/GC/$blnskr/$thnskr</td>
		</tr>
		<tr>
			<td>	Tanggal		</td><td>	:	</td><td>	$tglctk	</td>
		</tr>
		<tr>
			<td>	Pertemuan	</td><td>	:	</td><td>	1 (pukul 09.00 WIB)	</td>
		</tr>
		<tr>
			<td>	Format		</td><td>	:	</td><td>	Konseling Pribadi (Komponen Belajar Sosial)	</td>
		</tr>
		
		<tr>
			<td colspan='3'><br/></td>
		</tr>
		
		<tr>
			<td colspan='3'><b><i><u>Identitas Pribadi</b></i></u></td>
		</tr>
		<tr>
			<td>	1. Student Name	</td>		<td>	:	</td><td>	$nmassw	</td>
		</tr>
		<tr>
			<td>	2. Gender	</td>			<td>	:	</td><td>	$jnsklm	</td>
		</tr>
		<tr>
			<td>	3. Birth Date	</td>		<td>	:	</td><td>	$tgllhr	</td>
		</tr>
		<tr>
			<td>	4. Class	</td>			<td>	:	</td><td>	$kdekls	</td>
		</tr>
		<tr>
			<td>	5. Parents	</td>			<td>		</td><td>		</td>
		</tr>
		<tr>
			<td>	 &nbsp;&nbsp;&nbsp; a. Father	</td>								<td>		</td><td>		</td>
		</tr>
		<tr>
			<td>	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name	</td>			<td>	:	</td><td>	$nmaayh	</td>
		</tr>
		<tr>
			<td>	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Job	</td>				<td>	:	</td><td>	$pkjayh	</td>
		</tr>
		<tr>
			<td>	 &nbsp;&nbsp;&nbsp; b. Mother	</td>								<td>		</td><td>		</td>
		</tr>
		<tr>
			<td>	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name	</td>			<td>	:	</td><td>	$nmaibu	</td>
		</tr>
		<tr>
			<td>	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Job	</td>				<td>	:	</td><td>	$pkjibu	</td>
		</tr>
		<tr>
			<td>	Address	</td>				<td>	:	</td><td>	$alm	</td>
		</tr>
		<tr>
			<td>	Telephone	</td>			<td>	:	</td><td>	$tlp	</td>
		</tr>
	</table>
	
	
	
	<br/><br/>
	
	
	
";



//..ANNECTDOTAL RECORD



echo"
<TABLE width='100%'  style='border-collapse: collapse;' border='1'>

<CAPTION>
	<B>ANNECDOTAL RECORD</B><br/><br/>
</CAPTION>";

echo"
	<THEAD>
	<TR>
		<TH rowspan='2' align='center'>	Day / Date	</TH><TH rowspan='2' align='center' width='30%'>	Annecdotal Record	</TH><TH rowspan='2' align='center' width='30%'>	School Action	</TH><TH rowspan='2' align='center'>	Jenis Bimbingan & Layanan	</TH><TH colspan='2' align='center'>	Signature	</TH>
	</TR>
	<TR>
		<TH align='center'>	Student	</TH><TH align='center'>	Parents	</TH>
	</TR>
	</THEAD>
";

$j=0;
$no=1;
while($j<$i)
{
	$tgl=$cell[$j][1];
	$kmn=$cell[$j][3];
	$tind=$cell[$j][4];
	$jenis=$cell[$j][5];
	echo"
	<TR>
		<TD>	$tgl	</TD><TD align='justify'>	$kmn	</TD><TD align='justify'>	$tind	</TD><TD align='center'>	$jenis	</TD><TD>		</TD><TD>		</TD>
	</TR>
	";
	$j++;
	$no++;
}



echo"
</TABLE>";







echo"
<br/><br/>
<br/><br/>
<br/><br/>
<br/><br/>
<table width='100%'>
	<tr>
		<td>	<b><u>$wlikls$gelar</u></b><br/> Homeroom Adviser	</td><td align='right'>	<b><u>Victor Julianus Silaban, S.S., M.Pd.</u></b><br/> Guidance Counselor 	</td>
	</tr>
</table>
<!--<p align='right'>
	<b>Victor Julianus Silaban, S.S., M.Pd.</b>
</p>-->";
?>