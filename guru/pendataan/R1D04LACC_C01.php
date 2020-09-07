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
$sms	=$_POST['sms'];
$midtrm	=$_POST['midtrm'];
$thn	=$_POST['thn'];
$period = $sms . $midtrm . $thn;

if( $sms=='1' AND $midtrm=='1' )
	$periode = 'July to October';
else if( $sms=='1' AND $midtrm=='2' )
	$periode = 'Ocotber to December';
else if( $sms=='2' AND $midtrm=='1' )
	$periode = 'January to April';
else //if( $sms=='2' AND $midtrm=='2' )
	$periode = 'April to June';



//..



$query 	="	SELECT 		t_acc_sd_det.*
			FROM 		t_acc_sd_det
			WHERE		t_acc_sd_det.period='". mysql_escape_string($period)."' AND 
						t_acc_sd_det.kdeusr='". mysql_escape_string($kdekry)."'
			";
$result =mysql_query($query) or die('Query gagal');

$i=0;
while($data = mysql_fetch_array($result))
{
	$cell[$i][0] 	=$data[no];
	$cell[$i][1] 	=$data[period];
	$cell[$i][2] 	=$data[stud];
	$cell[$i][3] 	=$data[teac];
	$cell[$i][4] 	=$data[curr];
	$cell[$i][5] 	=$data[phys];
	$cell[$i][6] 	=$data[comm];
	$cell[$i][7] 	=$data[othe];
	
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
					Accomplishment Report <b>$periode $thn</b> 				<br/>
								
				
			</td>
			
		</tr>
	</table>
	<br/>
	<table width='100%'  style='border-collapse: collapse;' border='1'>
		<thead>
		<tr bgcolor='#ADD8E6'>
			<th align='left'>	I. Student Development	</th><th align='left'>	II. Teacher Development	</th><th align='left'>	III. Curriculum Development	</th><th align='left'>	IV. Physical Development	</th><th align='left'>	V. Community Development	</th><th align='left'>	VI. Other Related Concerns	</th>
		</tr>
		</thead>";
		
		$j=0;
		$no=1;
		while($j<$i)
		{
			$no=$cell[$j][0];
			$period=$cell[$j][1];
			$stud=$cell[$j][2];
			$teac=$cell[$j][3];
			$curr=$cell[$j][4];
			$phys=$cell[$j][5];
			$comm=$cell[$j][6];
			$othe=$cell[$j][7];
			echo"
			<TR>
				<TD align='justify'>	$stud	</TD><TD align='justify'>	$teac	</TD><TD align='justify'>	$curr	</TD><TD align='justify'>	$phys	</TD><TD align='justify'>	$comm	</TD><TD align='justify'>	$othe	</TD>
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