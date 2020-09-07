<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LSMP7_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SISWA ( versi 1 lembar )
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fpdf/fpdf.php';

$kdeplj	=$_POST['kdeplj'];
$kdekls	=$_POST['kdekls'];//nis
$sms	=$_POST['sms'];
$midtrm	='2';//$_POST['midtrm'];
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
$query	="	SELECT 		t_setthn_sma.*
			FROM 		t_setthn_sma
			WHERE		t_setthn_sma.set='Tahun Ajaran'";
$result	=mysql_query($query) or die('Query gagal1g');
$data 	=mysql_fetch_array($result);
$thnajar3=$data[nli];

if($sms=='1')
	$semester3='I / Ganjil';
else if($sms=='2')
	$semester3='II / Genap';

// dapatkan data bobot nilai
$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='1HW'";
$result	=mysql_query($query) or die('Query gagal1a');
$data 	=mysql_fetch_array($result);
$bbthw=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='2PRJ'";
$result	=mysql_query($query) or die('Query gagal1b');
$data 	=mysql_fetch_array($result);
$bbtprj=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='3TES'";
$result	=mysql_query($query) or die('Query gagal1c');
$data 	=mysql_fetch_array($result);
$bbttes=$data[bbt];

$query	="	SELECT 		t_mstbbt_sma.*
			FROM 		t_mstbbt_sma
			WHERE		t_mstbbt_sma.kdebbt='4MID'";
$result	=mysql_query($query) or die('Query gagal1d');
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

$query 	="	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE 		t_mstssw.nis='". mysql_escape_string($kdekls)."'";
$result =mysql_query($query) or die('Query gagal2');
$data 	=mysql_fetch_array($result);
$nisn=$data[nisn];
$nmassw=$data[nmassw];
$kkelas=$data[kdekls];
$tmplhr=$data[tmplhr];
$tgllhr=$data[tgllhr];
$jnsklm=$data[jnsklm];
$kdeagm=$data[kdeagm];
$tgllhr=strtotime($tgllhr);
$tgllhr=date('d F Y',$tgllhr);

$nmaibu =$data[nmaibu];
$nmaayh	=$data[nmaayh];
$almt	=$data[alm];
$pkjayh =$data[pkjayh];
$pkjibu =$data[pkjibu];
$hpaayh =$data[hpaayh];

//...............................
//...............................
//...............................

$nis = substr($kdekls,0,3);

echo"
	<center>
		<b><H2>DATA NILAI SISWA SMA, Halaman 1</H2></b>
	
	<b>
		NAMA SISWA : $nmassw<br/>
		NOMOR INDUK SEKOLAH : $nis<br/>
		NOMOR INDUK NASIONAL : $nisn
	</b>
	</center>
	
	<table border='1' style='border-collapse:collapse;' width='100%'>
	
		<tr>
			<td rowspan='4' align='center'>No.</td><td rowspan='4' align='center' width='30%'>MATA PELAJARAN \ NILAI RAPOR</td><td align='center' colspan='7'>Kelas : ..... Tahun Pelajaran : .....</td>
		</tr>
		<tr>
			<td align='center' colspan='7'>Semester Ganjil</td>
		</tr>
		<tr>
			<td rowspan='2' align='center'>KKM</td><td align='center' colspan='2'>Penguasaan dan<br/>Pemahaman Konsep</td><td align='center' colspan='2'>Praktek</td><td align='center'>Sikap<br/>Minat</td><td rowspan='2' align='center'>Catatan Guru</td>
		</tr>
		<tr>
			<td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Predikat</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>1.</td><td rowspan='2'>Pendidikan Agama</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>2.</td><td rowspan='2'>Pendidikan Kewarganegaraan</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>3.</td><td rowspan='2'>Bahasa dan Sastra Indonesia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>4.</td><td rowspan='2'>Bahasa Inggris</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>5.</td><td rowspan='2'>Matematika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>6.</td><td rowspan='2'>Kesenian</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>7.</td><td rowspan='2'>Pendidikan Jasmani</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'>Sejarah</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'>Geografi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'>Ekonomi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'>Sosiologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>12.</td><td rowspan='2'>Fisika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>13.</td><td rowspan='2'>Kimia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>14.</td><td rowspan='2'>Biologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>15.</td><td rowspan='2'>Teknologi Informasi & Komunikasi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>16.</td><td rowspan='2'>Keterampilan / Bahasa Asing ...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>17.</td><td rowspan='2'>...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td ></td><TD ><table width='100%' style='border-collapse:collapse;' border='1'><tr><td align='center' width='33%'>IPA</td><td align='center' width='33%'>IPS</td><td align='center' width='33%'>IPB</td></tr></table></TD><td ></td><td ></td><td ></td><td ></td><td ></td><td ></td><td></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Mate-<br/>matika</td><td width='33%'>Sejarah</td><td width='33%'>Sejarah</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Fisika</td><td width='33%'>Geog-<br/>rafi</td><td width='33%'>Antro-<br/>pologi</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Kimia</td><td width='33%'>Ekono-<br/>mi</td><td width='33%'>Sastra<br/>Indo.</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Biologi</td><td width='33%'>Sosio-<br/>logi</td><td width='33%'>Bhs. Asg.<br/>Lainnya</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah Nilai</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Nilai Rata-rata</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Peringkat ke</td>			<td colspan='7'></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='2'>Keg. Ektra<br/>Kurikuler</TD><TD WIDTH='5%'>1.</TD><TD></TD></TR>
					<TR><TD>2.</TD><TD></TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='4' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='4'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Perilaku</TD></TR>
					<TR><TD>2.</TD><TD>Kerajinan/Kedisiplinan</TD></TR>
					<TR><TD>3.</TD><TD>Kerapihan</TD></TR>
					<TR><TD>4.</TD><TD>Kebersihan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='3' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='3'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Sakit</TD></TR>
					<TR><TD>2.</TD><TD>Ijin</TD></TR>
					<TR><TD>3.</TD><TD>Tanpa Keterangan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah</td>			<td colspan='7' align='center'>......... Hari = .........%</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>% Kehadiran</td>		<td colspan='7' align='center'>.............. % ..............</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>STATUS AKHIR TAHUN</td>			<td colspan='7' align='center'>Wali Kelas : ............................................</td>
		</tr>
				
		
		
	</table>
	
	KKM = Kriteria Ketuntasan Minimal
	<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Diisi oleh guru mata pelajaran bersangkutan
	
	
	
	<p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>
	<br/><br/><br/>
	
	
	
	
	<table border='1' style='border-collapse:collapse;' width='100%'>
	
		<tr>
			<td rowspan='4' align='center'>No.</td><td rowspan='4' align='center' width='30%'>MATA PELAJARAN \ NILAI RAPOR</td><td align='center' colspan='7'>Kelas : ..... Tahun Pelajaran : .....</td>
		</tr>
		<tr>
			<td align='center' colspan='7'>Semester Genap</td>
		</tr>
		<tr>
			<td rowspan='2' align='center'>KKM</td><td align='center' colspan='2'>Penguasaan dan<br/>Pemahaman Konsep</td><td align='center' colspan='2'>Praktek</td><td align='center'>Sikap<br/>Minat</td><td rowspan='2' align='center'>Catatan Guru</td>
		</tr>
		<tr>
			<td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Predikat</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>1.</td><td rowspan='2'>Pendidikan Agama</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>2.</td><td rowspan='2'>Pendidikan Kewarganegaraan</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>3.</td><td rowspan='2'>Bahasa dan Sastra Indonesia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>4.</td><td rowspan='2'>Bahasa Inggris</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>5.</td><td rowspan='2'>Matematika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>6.</td><td rowspan='2'>Kesenian</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>7.</td><td rowspan='2'>Pendidikan Jasmani</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'>Sejarah</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'>Geografi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'>Ekonomi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'>Sosiologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>12.</td><td rowspan='2'>Fisika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>13.</td><td rowspan='2'>Kimia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>14.</td><td rowspan='2'>Biologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>15.</td><td rowspan='2'>Teknologi Informasi & Komunikasi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>16.</td><td rowspan='2'>Keterampilan / Bahasa Asing ...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>17.</td><td rowspan='2'>...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td ></td><TD ><table width='100%' style='border-collapse:collapse;' border='1'><tr><td align='center' width='33%'>IPA</td><td align='center' width='33%'>IPS</td><td align='center' width='33%'>IPB</td></tr></table></TD><td ></td><td ></td><td ></td><td ></td><td ></td><td ></td><td></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Mate-<br/>matika</td><td width='33%'>Sejarah</td><td width='33%'>Sejarah</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Fisika</td><td width='33%'>Geog-<br/>rafi</td><td width='33%'>Antro-<br/>pologi</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Kimia</td><td width='33%'>Ekono-<br/>mi</td><td width='33%'>Sastra<br/>Indo.</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Biologi</td><td width='33%'>Sosio-<br/>logi</td><td width='33%'>Bhs. Asg.<br/>Lainnya</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah Nilai</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Nilai Rata-rata</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Peringkat ke</td>			<td colspan='7'></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='2'>Keg. Ektra<br/>Kurikuler</TD><TD WIDTH='5%'>1.</TD><TD></TD></TR>
					<TR><TD>2.</TD><TD></TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='4' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='4'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Perilaku</TD></TR>
					<TR><TD>2.</TD><TD>Kerajinan/Kedisiplinan</TD></TR>
					<TR><TD>3.</TD><TD>Kerapihan</TD></TR>
					<TR><TD>4.</TD><TD>Kebersihan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='3' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='3'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Sakit</TD></TR>
					<TR><TD>2.</TD><TD>Ijin</TD></TR>
					<TR><TD>3.</TD><TD>Tanpa Keterangan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah</td>			<td colspan='7' align='center'>......... Hari = .........%</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>% Kehadiran</td>		<td colspan='7' align='center'>.............. % ..............</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>STATUS AKHIR TAHUN</td>			<td colspan='7' align='center'>Naik Ke/Tinggal di : Kelas ........</td>
		</tr>
				
		
		
	</table>
	
	
	
	<p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>
	<br/><br/><br/><br/>
	<br/><br/><br/>
	<br/><br/>
	<br/>
	
	
	
	<table border='1' style='border-collapse:collapse;' width='100%'>
	
		<tr>
			<td rowspan='4' align='center'>No.</td><td rowspan='4' align='center' width='30%'>MATA PELAJARAN \ NILAI RAPOR</td><td align='center' colspan='7'>Kelas : ..... Tahun Pelajaran : .....</td>
		</tr>
		<tr>
			<td align='center' colspan='7'>Semester Ganjil</td>
		</tr>
		<tr>
			<td rowspan='2' align='center'>KKM</td><td align='center' colspan='2'>Penguasaan dan<br/>Pemahaman Konsep</td><td align='center' colspan='2'>Praktek</td><td align='center'>Sikap<br/>Minat</td><td rowspan='2' align='center'>Catatan Guru</td>
		</tr>
		<tr>
			<td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Predikat</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>1.</td><td rowspan='2'>Pendidikan Agama</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>2.</td><td rowspan='2'>Pendidikan Kewarganegaraan</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>3.</td><td rowspan='2'>Bahasa dan Sastra Indonesia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>4.</td><td rowspan='2'>Bahasa Inggris</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>5.</td><td rowspan='2'>Matematika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>6.</td><td rowspan='2'>Kesenian</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>7.</td><td rowspan='2'>Pendidikan Jasmani</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'>Sejarah</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'>Geografi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'>Ekonomi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'>Sosiologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>12.</td><td rowspan='2'>Fisika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>13.</td><td rowspan='2'>Kimia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>14.</td><td rowspan='2'>Biologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>15.</td><td rowspan='2'>Teknologi Informasi & Komunikasi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>16.</td><td rowspan='2'>Keterampilan / Bahasa Asing ...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>17.</td><td rowspan='2'>...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td ></td><TD ><table width='100%' style='border-collapse:collapse;' border='1'><tr><td align='center' width='33%'>IPA</td><td align='center' width='33%'>IPS</td><td align='center' width='33%'>IPB</td></tr></table></TD><td ></td><td ></td><td ></td><td ></td><td ></td><td ></td><td></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Mate-<br/>matika</td><td width='33%'>Sejarah</td><td width='33%'>Sejarah</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Fisika</td><td width='33%'>Geog-<br/>rafi</td><td width='33%'>Antro-<br/>pologi</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Kimia</td><td width='33%'>Ekono-<br/>mi</td><td width='33%'>Sastra<br/>Indo.</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Biologi</td><td width='33%'>Sosio-<br/>logi</td><td width='33%'>Bhs. Asg.<br/>Lainnya</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah Nilai</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Nilai Rata-rata</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Peringkat ke</td>			<td colspan='7'></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='2'>Keg. Ektra<br/>Kurikuler</TD><TD WIDTH='5%'>1.</TD><TD></TD></TR>
					<TR><TD>2.</TD><TD></TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='4' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='4'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Perilaku</TD></TR>
					<TR><TD>2.</TD><TD>Kerajinan/Kedisiplinan</TD></TR>
					<TR><TD>3.</TD><TD>Kerapihan</TD></TR>
					<TR><TD>4.</TD><TD>Kebersihan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='3' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='3'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Sakit</TD></TR>
					<TR><TD>2.</TD><TD>Ijin</TD></TR>
					<TR><TD>3.</TD><TD>Tanpa Keterangan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah</td>			<td colspan='7' align='center'>......... Hari = .........%</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>% Kehadiran</td>		<td colspan='7' align='center'>.............. % ..............</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>STATUS AKHIR TAHUN</td>			<td colspan='7' align='center'>Wali Kelas : ............................................</td>
		</tr>
				
		
		
	</table>
	
	
	
	
	
	
	
";
//...............................
//...............................
//...............................
echo"
	<p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>
	
	<br/><br/>
	<br/><br/><br/><br/>



	<center>
		<b><H2>DATA NILAI SISWA SMA, Halaman 2</H2></b>
	
	<b>
		NAMA SISWA : $nmassw<br/>
		NOMOR INDUK SEKOLAH : $nis<br/>
		NOMOR INDUK NASIONAL : $nisn
	</b>
	</center>
	
	<table border='1' style='border-collapse:collapse;' width='100%'>
	
		<tr>
			<td rowspan='4' align='center'>No.</td><td rowspan='4' align='center' width='30%'>MATA PELAJARAN \ NILAI RAPOR</td><td align='center' colspan='7'>Kelas : ..... Tahun Pelajaran : .....</td>
		</tr>
		<tr>
			<td align='center' colspan='7'>Semester Genap</td>
		</tr>
		<tr>
			<td rowspan='2' align='center'>KKM</td><td align='center' colspan='2'>Penguasaan dan<br/>Pemahaman Konsep</td><td align='center' colspan='2'>Praktek</td><td align='center'>Sikap<br/>Minat</td><td rowspan='2' align='center'>Catatan Guru</td>
		</tr>
		<tr>
			<td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Predikat</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>1.</td><td rowspan='2'>Pendidikan Agama</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>2.</td><td rowspan='2'>Pendidikan Kewarganegaraan</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>3.</td><td rowspan='2'>Bahasa dan Sastra Indonesia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>4.</td><td rowspan='2'>Bahasa Inggris</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>5.</td><td rowspan='2'>Matematika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>6.</td><td rowspan='2'>Kesenian</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>7.</td><td rowspan='2'>Pendidikan Jasmani</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'>Sejarah</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'>Geografi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'>Ekonomi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'>Sosiologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>12.</td><td rowspan='2'>Fisika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>13.</td><td rowspan='2'>Kimia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>14.</td><td rowspan='2'>Biologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>15.</td><td rowspan='2'>Teknologi Informasi & Komunikasi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>16.</td><td rowspan='2'>Keterampilan / Bahasa Asing ...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>17.</td><td rowspan='2'>...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td ></td><TD ><table width='100%' style='border-collapse:collapse;' border='1'><tr><td align='center' width='33%'>IPA</td><td align='center' width='33%'>IPS</td><td align='center' width='33%'>IPB</td></tr></table></TD><td ></td><td ></td><td ></td><td ></td><td ></td><td ></td><td></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Mate-<br/>matika</td><td width='33%'>Sejarah</td><td width='33%'>Sejarah</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Fisika</td><td width='33%'>Geog-<br/>rafi</td><td width='33%'>Antro-<br/>pologi</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Kimia</td><td width='33%'>Ekono-<br/>mi</td><td width='33%'>Sastra<br/>Indo.</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Biologi</td><td width='33%'>Sosio-<br/>logi</td><td width='33%'>Bhs. Asg.<br/>Lainnya</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah Nilai</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Nilai Rata-rata</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Peringkat ke</td>			<td colspan='7'></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='2'>Keg. Ektra<br/>Kurikuler</TD><TD WIDTH='5%'>1.</TD><TD></TD></TR>
					<TR><TD>2.</TD><TD></TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='4' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='4'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Perilaku</TD></TR>
					<TR><TD>2.</TD><TD>Kerajinan/Kedisiplinan</TD></TR>
					<TR><TD>3.</TD><TD>Kerapihan</TD></TR>
					<TR><TD>4.</TD><TD>Kebersihan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='3' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='3'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Sakit</TD></TR>
					<TR><TD>2.</TD><TD>Ijin</TD></TR>
					<TR><TD>3.</TD><TD>Tanpa Keterangan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah</td>			<td colspan='7' align='center'>......... Hari = .........%</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>% Kehadiran</td>		<td colspan='7' align='center'>.............. % ..............</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>STATUS AKHIR TAHUN</td>			<td colspan='7' align='center'>Naik Ke/Tinggal di : Kelas ........</td>
		</tr>
				
		
		
	</table>
	
	KKM = Kriteria Ketuntasan Minimal
	<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Diisi oleh guru mata pelajaran bersangkutan
	
	
	
	<p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>
	<p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>
	
	<br/>
	
	
	
	<table border='1' style='border-collapse:collapse;' width='100%'>
	
		<tr>
			<td rowspan='4' align='center'>No.</td><td rowspan='4' align='center' width='30%'>MATA PELAJARAN \ NILAI RAPOR</td><td align='center' colspan='7'>Kelas : ..... Tahun Pelajaran : .....</td>
		</tr>
		<tr>
			<td align='center' colspan='7'>Semester Ganjil</td>
		</tr>
		<tr>
			<td rowspan='2' align='center'>KKM</td><td align='center' colspan='2'>Penguasaan dan<br/>Pemahaman Konsep</td><td align='center' colspan='2'>Praktek</td><td align='center'>Sikap<br/>Minat</td><td rowspan='2' align='center'>Catatan Guru</td>
		</tr>
		<tr>
			<td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Predikat</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>1.</td><td rowspan='2'>Pendidikan Agama</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>2.</td><td rowspan='2'>Pendidikan Kewarganegaraan</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>3.</td><td rowspan='2'>Bahasa dan Sastra Indonesia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>4.</td><td rowspan='2'>Bahasa Inggris</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>5.</td><td rowspan='2'>Matematika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>6.</td><td rowspan='2'>Kesenian</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>7.</td><td rowspan='2'>Pendidikan Jasmani</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'>Sejarah</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'>Geografi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'>Ekonomi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'>Sosiologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>12.</td><td rowspan='2'>Fisika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>13.</td><td rowspan='2'>Kimia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>14.</td><td rowspan='2'>Biologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>15.</td><td rowspan='2'>Teknologi Informasi & Komunikasi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>16.</td><td rowspan='2'>Keterampilan / Bahasa Asing ...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>17.</td><td rowspan='2'>...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td ></td><TD ><table width='100%' style='border-collapse:collapse;' border='1'><tr><td align='center' width='33%'>IPA</td><td align='center' width='33%'>IPS</td><td align='center' width='33%'>IPB</td></tr></table></TD><td ></td><td ></td><td ></td><td ></td><td ></td><td ></td><td></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Mate-<br/>matika</td><td width='33%'>Sejarah</td><td width='33%'>Sejarah</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Fisika</td><td width='33%'>Geog-<br/>rafi</td><td width='33%'>Antro-<br/>pologi</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Kimia</td><td width='33%'>Ekono-<br/>mi</td><td width='33%'>Sastra<br/>Indo.</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Biologi</td><td width='33%'>Sosio-<br/>logi</td><td width='33%'>Bhs. Asg.<br/>Lainnya</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah Nilai</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Nilai Rata-rata</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Peringkat ke</td>			<td colspan='7'></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='2'>Keg. Ektra<br/>Kurikuler</TD><TD WIDTH='5%'>1.</TD><TD></TD></TR>
					<TR><TD>2.</TD><TD></TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='4' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='4'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Perilaku</TD></TR>
					<TR><TD>2.</TD><TD>Kerajinan/Kedisiplinan</TD></TR>
					<TR><TD>3.</TD><TD>Kerapihan</TD></TR>
					<TR><TD>4.</TD><TD>Kebersihan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='3' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='3'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Sakit</TD></TR>
					<TR><TD>2.</TD><TD>Ijin</TD></TR>
					<TR><TD>3.</TD><TD>Tanpa Keterangan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah</td>			<td colspan='7' align='center'>......... Hari = .........%</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>% Kehadiran</td>		<td colspan='7' align='center'>.............. % ..............</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>STATUS AKHIR TAHUN</td>			<td colspan='7' align='center'>Wali Kelas : ............................................</td>
		</tr>
				
		
		
	</table>
	
	
	
	<p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>
	<br/>
	
	
	
	<table border='1' style='border-collapse:collapse;' width='100%'>
	
		<tr>
			<td rowspan='4' align='center'>No.</td><td rowspan='4' align='center' width='30%'>MATA PELAJARAN \ NILAI RAPOR</td><td align='center' colspan='7'>Kelas : ..... Tahun Pelajaran : .....</td>
		</tr>
		<tr>
			<td align='center' colspan='7'>Semester Genap</td>
		</tr>
		<tr>
			<td rowspan='2' align='center'>KKM</td><td align='center' colspan='2'>Penguasaan dan<br/>Pemahaman Konsep</td><td align='center' colspan='2'>Praktek</td><td align='center'>Sikap<br/>Minat</td><td rowspan='2' align='center'>Catatan Guru</td>
		</tr>
		<tr>
			<td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Predikat</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>1.</td><td rowspan='2'>Pendidikan Agama</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>2.</td><td rowspan='2'>Pendidikan Kewarganegaraan</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>3.</td><td rowspan='2'>Bahasa dan Sastra Indonesia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>4.</td><td rowspan='2'>Bahasa Inggris</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>5.</td><td rowspan='2'>Matematika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>6.</td><td rowspan='2'>Kesenian</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>7.</td><td rowspan='2'>Pendidikan Jasmani</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'>Sejarah</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'>Geografi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'>Ekonomi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'>Sosiologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>12.</td><td rowspan='2'>Fisika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>13.</td><td rowspan='2'>Kimia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>14.</td><td rowspan='2'>Biologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>15.</td><td rowspan='2'>Teknologi Informasi & Komunikasi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>16.</td><td rowspan='2'>Keterampilan / Bahasa Asing ...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>17.</td><td rowspan='2'>...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td ></td><TD ><table width='100%' style='border-collapse:collapse;' border='1'><tr><td align='center' width='33%'>IPA</td><td align='center' width='33%'>IPS</td><td align='center' width='33%'>IPB</td></tr></table></TD><td ></td><td ></td><td ></td><td ></td><td ></td><td ></td><td></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Mate-<br/>matika</td><td width='33%'>Sejarah</td><td width='33%'>Sejarah</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Fisika</td><td width='33%'>Geog-<br/>rafi</td><td width='33%'>Antro-<br/>pologi</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Kimia</td><td width='33%'>Ekono-<br/>mi</td><td width='33%'>Sastra<br/>Indo.</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Biologi</td><td width='33%'>Sosio-<br/>logi</td><td width='33%'>Bhs. Asg.<br/>Lainnya</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah Nilai</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Nilai Rata-rata</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Peringkat ke</td>			<td colspan='7'></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='2'>Keg. Ektra<br/>Kurikuler</TD><TD WIDTH='5%'>1.</TD><TD></TD></TR>
					<TR><TD>2.</TD><TD></TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='4' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='4'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Perilaku</TD></TR>
					<TR><TD>2.</TD><TD>Kerajinan/Kedisiplinan</TD></TR>
					<TR><TD>3.</TD><TD>Kerapihan</TD></TR>
					<TR><TD>4.</TD><TD>Kebersihan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='3' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='3'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Sakit</TD></TR>
					<TR><TD>2.</TD><TD>Ijin</TD></TR>
					<TR><TD>3.</TD><TD>Tanpa Keterangan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah</td>			<td colspan='7' align='center'>......... Hari = .........%</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>% Kehadiran</td>		<td colspan='7' align='center'>.............. % ..............</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>STATUS AKHIR TAHUN</td>			<td colspan='7' align='center'>Naik Ke/Tinggal di : Kelas ........Lulus/Tidak lulus</td>
		</tr>
				
		
		
	</table>
	
	
	
	<p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>
	<br/><br/>
";

//...............................
//...............................
//...............................

echo"
	<center>
		<b><H2>DATA NILAI SISWA SMA, Halaman 3</H2></b>
	
	<b>
		NAMA SISWA : $nmassw<br/>
		NOMOR INDUK SEKOLAH : $nis<br/>
		NOMOR INDUK NASIONAL : $nisn
	</b>
	</center>
	
	
	
	<table border='1' style='border-collapse:collapse;' width='100%'>
	
		<tr>
			<td rowspan='4' align='center'>No.</td><td rowspan='4' align='center' width='30%'>MATA PELAJARAN \ NILAI RAPOR</td><td align='center' colspan='7'>Kelas : ..... Tahun Pelajaran : .....</td>
		</tr>
		<tr>
			<td align='center' colspan='7'>Semester Ganjil</td>
		</tr>
		<tr>
			<td rowspan='2' align='center'>KKM</td><td align='center' colspan='2'>Penguasaan dan<br/>Pemahaman Konsep</td><td align='center' colspan='2'>Praktek</td><td align='center'>Sikap<br/>Minat</td><td rowspan='2' align='center'>Catatan Guru</td>
		</tr>
		<tr>
			<td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Predikat</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>1.</td><td rowspan='2'>Pendidikan Agama</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>2.</td><td rowspan='2'>Pendidikan Kewarganegaraan</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>3.</td><td rowspan='2'>Bahasa dan Sastra Indonesia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>4.</td><td rowspan='2'>Bahasa Inggris</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>5.</td><td rowspan='2'>Matematika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>6.</td><td rowspan='2'>Kesenian</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>7.</td><td rowspan='2'>Pendidikan Jasmani</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'>Sejarah</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'>Geografi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'>Ekonomi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'>Sosiologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>12.</td><td rowspan='2'>Fisika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>13.</td><td rowspan='2'>Kimia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>14.</td><td rowspan='2'>Biologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>15.</td><td rowspan='2'>Teknologi Informasi & Komunikasi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>16.</td><td rowspan='2'>Keterampilan / Bahasa Asing ...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>17.</td><td rowspan='2'>...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td ></td><TD ><table width='100%' style='border-collapse:collapse;' border='1'><tr><td align='center' width='33%'>IPA</td><td align='center' width='33%'>IPS</td><td align='center' width='33%'>IPB</td></tr></table></TD><td ></td><td ></td><td ></td><td ></td><td ></td><td ></td><td></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Mate-<br/>matika</td><td width='33%'>Sejarah</td><td width='33%'>Sejarah</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Fisika</td><td width='33%'>Geog-<br/>rafi</td><td width='33%'>Antro-<br/>pologi</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Kimia</td><td width='33%'>Ekono-<br/>mi</td><td width='33%'>Sastra<br/>Indo.</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Biologi</td><td width='33%'>Sosio-<br/>logi</td><td width='33%'>Bhs. Asg.<br/>Lainnya</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah Nilai</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Nilai Rata-rata</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Peringkat ke</td>			<td colspan='7'></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='2'>Keg. Ektra<br/>Kurikuler</TD><TD WIDTH='5%'>1.</TD><TD></TD></TR>
					<TR><TD>2.</TD><TD></TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='4' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='4'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Perilaku</TD></TR>
					<TR><TD>2.</TD><TD>Kerajinan/Kedisiplinan</TD></TR>
					<TR><TD>3.</TD><TD>Kerapihan</TD></TR>
					<TR><TD>4.</TD><TD>Kebersihan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='3' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='3'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Sakit</TD></TR>
					<TR><TD>2.</TD><TD>Ijin</TD></TR>
					<TR><TD>3.</TD><TD>Tanpa Keterangan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah</td>			<td colspan='7' align='center'>......... Hari = .........%</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>% Kehadiran</td>		<td colspan='7' align='center'>.............. % ..............</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>STATUS AKHIR TAHUN</td>			<td colspan='7' align='center'>Wali Kelas : ............................................</td>
		</tr>
				
		
		
	</table>
	
	KKM = Kriteria Ketuntasan Minimal
	<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Diisi oleh guru mata pelajaran bersangkutan
	
	
	
	<p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>
	<p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>
	
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	
	
	
	<table border='1' style='border-collapse:collapse;' width='100%'>
	
		<tr>
			<td rowspan='4' align='center'>No.</td><td rowspan='4' align='center' width='30%'>MATA PELAJARAN \ NILAI RAPOR</td><td align='center' colspan='7'>Kelas : ..... Tahun Pelajaran : .....</td>
		</tr>
		<tr>
			<td align='center' colspan='7'>Semester Genap</td>
		</tr>
		<tr>
			<td rowspan='2' align='center'>KKM</td><td align='center' colspan='2'>Penguasaan dan<br/>Pemahaman Konsep</td><td align='center' colspan='2'>Praktek</td><td align='center'>Sikap<br/>Minat</td><td rowspan='2' align='center'>Catatan Guru</td>
		</tr>
		<tr>
			<td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Predikat</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>1.</td><td rowspan='2'>Pendidikan Agama</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>2.</td><td rowspan='2'>Pendidikan Kewarganegaraan</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>3.</td><td rowspan='2'>Bahasa dan Sastra Indonesia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>4.</td><td rowspan='2'>Bahasa Inggris</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>5.</td><td rowspan='2'>Matematika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>6.</td><td rowspan='2'>Kesenian</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>7.</td><td rowspan='2'>Pendidikan Jasmani</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'>Sejarah</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'>Geografi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'>Ekonomi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'>Sosiologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>12.</td><td rowspan='2'>Fisika</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>13.</td><td rowspan='2'>Kimia</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>14.</td><td rowspan='2'>Biologi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>15.</td><td rowspan='2'>Teknologi Informasi & Komunikasi</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>16.</td><td rowspan='2'>Keterampilan / Bahasa Asing ...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>17.</td><td rowspan='2'>...............................................</td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td ></td><TD ><table width='100%' style='border-collapse:collapse;' border='1'><tr><td align='center' width='33%'>IPA</td><td align='center' width='33%'>IPS</td><td align='center' width='33%'>IPB</td></tr></table></TD><td ></td><td ></td><td ></td><td ></td><td ></td><td ></td><td></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2'>8.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Mate-<br/>matika</td><td width='33%'>Sejarah</td><td width='33%'>Sejarah</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>9.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Fisika</td><td width='33%'>Geog-<br/>rafi</td><td width='33%'>Antro-<br/>pologi</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>10.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Kimia</td><td width='33%'>Ekono-<br/>mi</td><td width='33%'>Sastra<br/>Indo.</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td rowspan='2'>11.</td><td rowspan='2'> <table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Biologi</td><td width='33%'>Sosio-<br/>logi</td><td width='33%'>Bhs. Asg.<br/>Lainnya</td></tr></table> </td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td rowspan='2'></td><td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah Nilai</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Nilai Rata-rata</td>			<td colspan='7'></td>
		</tr>
		<tr>
			<td colspan='2' align='center'>Peringkat ke</td>			<td colspan='7'></td>
		</tr>
		
		
		
		<tr>
			<td rowspan='2' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='2'>Keg. Ektra<br/>Kurikuler</TD><TD WIDTH='5%'>1.</TD><TD></TD></TR>
					<TR><TD>2.</TD><TD></TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='4' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='4'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Perilaku</TD></TR>
					<TR><TD>2.</TD><TD>Kerajinan/Kedisiplinan</TD></TR>
					<TR><TD>3.</TD><TD>Kerapihan</TD></TR>
					<TR><TD>4.</TD><TD>Kebersihan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		<tr>
			<td colspan='7'>
				
			</td>
		</tr>
		
		
		
		<tr>
			<td rowspan='3' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='3'>Kepriba-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Sakit</TD></TR>
					<TR><TD>2.</TD><TD>Ijin</TD></TR>
					<TR><TD>3.</TD><TD>Tanpa Keterangan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		<tr>
			<td colspan='7' align='center'>
				......... Hari = .........%
			</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>Jumlah</td>			<td colspan='7' align='center'>......... Hari = .........%</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>% Kehadiran</td>		<td colspan='7' align='center'>.............. % ..............</td>
		</tr>
		
		
		
		<tr>
			<td colspan='2' align='center'>STATUS AKHIR TAHUN</td>			<td colspan='7' align='center'>Lulus/Tidak lulus</td>
		</tr>
				
		
		
	</table>
	
	
	
	
	
	
	<p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>
	<p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p>
	
	<br/><br/><br/><br/><br/><br/><br/><br/>
	
	
	
	
	
	
	
	<table border='1' style='border-collapse:collapse;' width='100%'>
	
		<tr>
			<td rowspan='3' align='center'>No.</td>
			<td rowspan='3' align='center' width='30%'>MATA PELAJARAN \ NILAI RAPOR</td>
			<td align='center' colspan='4' >Nilai STTB</td>
		</tr>
		
		<tr>
			<td align='center' colspan='2'>Teori</td><td align='center' colspan='2'>Praktek</td>
		</tr>
		<tr>
			<td align='center'>Angka</td><td align='center'>Huruf</td><td align='center'>Angka</td><td align='center'>Huruf</td>
		</tr>
		
		
		
		<tr>
			<td >1.</td><td >Pendidikan Agama</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >2.</td><td >Pendidikan Kewarganegaraan</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >3.</td><td >Bahasa dan Sastra Indonesia</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >4.</td><td >Bahasa Inggris</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >5.</td><td >Matematika</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >6.</td><td >Kesenian</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >7.</td><td >Pendidikan Jasmani</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >8.</td><td >Sejarah</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >9.</td><td >Geografi</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >10.</td><td >Ekonomi</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >11.</td><td >Sosiologi</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >12.</td><td >Fisika</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >13.</td><td >Kimia</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >14.</td><td >Biologi</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >15.</td><td >Tekhnologi Informasi & Komunikasi</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >16.</td><td >Keterampilan / Bahasa Asing ...............................................</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >17.</td><td >...............................................</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td ></td><td ><table width='100%' style='border-collapse:collapse;' border='1'><tr><td align='center' width='33%'>IPA</td><td align='center' width='33%'>IPS</td><td align='center' width='33%'>IPB</td></tr></table></td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >8.</td><td >	<table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Mate-<br/>matika</td><td width='33%'>Sejarah</td><td width='33%'>Sejarah</td></tr></table>	</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >9.</td><td >	<table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Fisika</td><td width='33%'>Geog-<br/>rafi</td><td width='33%'>Antro-<br/>pologi</td></tr></table>	</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >10.</td><td >	<table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Kimia</td><td width='33%'>Ekono-<br/>mi</td><td width='33%'>Sastra<br/>Indo.</td></tr></table>	</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td >11.</td><td >	<table width='100%' style='border-collapse:collapse;' border='1'><tr><td width='33%'>Biologi</td><td width='33%'>Sosio-<br/>logi</td><td width='33%'>Bhs. Asg.<br/>Lainnya</td></tr></table>	</td><td ></td><td ></td><td ></td><td ></td>
		</tr>
		
		<tr>
			<td colspan='2' align='center'>Jumlah Nilai</td>			<td colspan='4' align='left'>UAN</td>
		</tr>
		
		<tr>
			<td colspan='2' align='center'>Nilai Rata-rata</td>			<td colspan='4'>1. P.Kewarganegaraan</td>
		</tr>
		
		<tr>
			<td colspan='2' align='center'>Peringkat ke</td>			<td colspan='4'>2. B.Indonesia</td>
		</tr>
		
		<tr>
			<td rowspan='2' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='2'>Keg. Ektra<br/>Kurikuler</TD><TD WIDTH='5%'>1.</TD><TD></TD></TR>
					<TR><TD>2.</TD><TD></TD></TR>
				</TABLE>
			</td>			
			<td colspan='4'>
				3. Matematika
			</td>
		</tr>
		<tr>
			<td colspan='4'>
				4. IPS &nbsp;&nbsp;&nbsp; 1. Sejarah
			</td>
		</tr>
		
		<tr>
			<td rowspan='4' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='4'>Kepri-<br/>dian</TD><TD WIDTH='5%'>1.</TD><TD>Perilaku</TD></TR>
					<TR><TD>2.</TD><TD>Kerajinan/Kedisiplinan</TD></TR>
					<TR><TD>3.</TD><TD>Kerapihan</TD></TR>
					<TR><TD>4.</TD><TD>Kebersihan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='4'>
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2. Geografi
			</td>
		</tr>
		<tr>
			<td colspan='4'>
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3. Ekonomi
			</td>
		</tr>
		<tr>
			<td colspan='4'>
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4. Sosiologi
			</td>
		</tr>
		<tr>
			<td colspan='4'>
				5. IPA &nbsp;&nbsp;&nbsp; 1. Fisika
			</td>
		</tr>
		
		<tr>
			<td rowspan='3' colspan='2' align='center'>
				<TABLE WIDTH='100%' border='1' style='border-collapse:collapse;'>
					<TR><TD WIDTH='35%' ROWSPAN='3'>Kehadiran</TD><TD WIDTH='5%'>1.</TD><TD>Sakit</TD></TR>
					<TR><TD>2.</TD><TD>Ijin</TD></TR>
					<TR><TD>3.</TD><TD>Tanpa Keterangan</TD></TR>
				</TABLE>
			</td>			
			<td colspan='4'>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2. Kimia
			</td>
		</tr>
		<tr>
			<td colspan='4'>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3.. Biologi
			</td>
		</tr>
		<tr>
			<td colspan='4'>
				6. B. Inggris
			</td>
		</tr>
		
		<tr>
			<td colspan='2' align='center'>Jumlah</td>			<td colspan='4' align='left'>7. ...........................</td>
		</tr>
		
		<tr>
			<td colspan='2' align='center'>% Kehadiran</td>		<td colspan='4' align='left'>Jumlah</td>
		</tr>
		
		<tr>
			<td colspan='2' align='center'></td>				<td colspan='4' align='left'>Rata-rata</td>
		</tr>
		
		<tr>
			<td colspan='2' align='center'></td>				<td colspan='4' align='left'>	<br/>	</td>
		</tr>
		
		<tr>
			<td colspan='2' align='center'>STATUS AKHIR TAHUN</td>				<td colspan='4' align='left'>STTB/Ijazah<br/>No. :<br/>Tgl. :</td>
		</tr>
				
		
		
	</table>
";







?>