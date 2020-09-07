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

//$kdekry	=$_SESSION["Admin"]["kdekry"];
$kdekry	=$_POST["kdekry"];
$tglctk	=$_POST['tglctk'];



//..



$query 	="	SELECT 		t_intrvw_sd_det.*
			FROM 		t_intrvw_sd_det
			WHERE		t_intrvw_sd_det.tgl='". mysql_escape_string($tglctk)."' AND 
						t_intrvw_sd_det.kdeusr='". mysql_escape_string($kdekry)."'
			ORDER BY	t_intrvw_sd_det.no
			";
$result =mysql_query($query) or die('Query gagal');

$i=0;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[no];
	$cell[$i][1] 	=$data[nmassw_br];
	$cell[$i][2] 	=$data[tgl];
	$cell[$i][3] 	=$data[wkt];
	$cell[$i][4] 	=$data[intrvw];
	
	$i++;
}



$query2 	= "	SELECT 		t_mstkry.*
				FROM 		t_mstkry
				WHERE 		t_mstkry.kdekry='". mysql_escape_string($kdekry)."' ";
$result2 =mysql_query($query2) or die('Query gagal2');
$data2 	=mysql_fetch_array($result2);
$nmakry=$data2[nmakry];
$gelar=$data2[gelar];









//..



echo"

	
	
	<table align='center'>
		<tr>
			<td rowspan='2'>	<img src='../../images/logo_sd.jpg' height='60' width='60' /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	</td>
			<td align='center'>
				<b>
					<font face='Times New Roman' size='5'>SAINT JOHN'S SCHOOL - MERUYA</font>	<br/>
				</b>
					Hasil Interview tanggal <b>$tglctk</b> 				<br/>
								
				
			</td>
			
		</tr>
	</table>
	<br/>
	<table width='100%'  style='border-collapse: collapse;' border='1'>
		<thead>
		<tr bgcolor='#ADD8E6'>
			<th align='left' width='3%'>	No.	</th><th align='left' width='22%'>	Nama Siswa Baru	</th><th align='left' width='10%'>	Date	</th><th align='left' width='10%'>	Time	</th><th align='left'>	Hasil Interview	</th>
		</tr>
		</thead>";
		
		$j=0;
		$no=1;
		while($j<$i)
		{
			$no=$cell[$j][0];
			$nmassw_br=$cell[$j][1];
			$tgl=$cell[$j][2];
			$wkt=$cell[$j][3];
			$intrvw=$cell[$j][4];
			
			echo"
			<TR>
				<TD align='justify'>	$no	</TD><TD align='justify'>	$nmassw_br	</TD><TD align='justify'>	$tgl	</TD><TD align='justify'>	$wkt	</TD><TD align='justify'>	$intrvw	</TD>
			</TR>
			";
			$j++;
			$no++;
		}

		//$no. 
		
echo"	</table>
	
	
	
	
	
	
	
	
	<br/><br/>
	
	
";











echo"

<table width='100%'>
	<tr>
		<td>	 	</td><td align='right'>	prepared by:<br/><br/><br/><b>$nmakry</b>	</td>
	</tr>
</table>
<!--<p align='right'>
	<b>Ignatius Tula</b><br/>Curriculum Officer		$gelar
</p>-->";
?>