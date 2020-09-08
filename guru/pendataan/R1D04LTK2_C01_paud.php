<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D01B_C01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Cetak SOAL
//----------------------------------------------------------------------------------------------------
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR . 'koneksi.php';
require_once FUNGSI_UMUM_DIR . 'fungsi_bantuan.php';
require_once FUNGSI_UMUM_DIR . 'fpdf/fpdf.php';

$kodekelas	= $_POST['kdekls'];
$nis	= substr($kodekelas, 0, 3);
$tglctk	= $_POST['tglctk'];

if ($tglctk == '') {
	$tglctk	= date('d F, Y');
} else {
	$tglctk	= strtotime($tglctk);
	$tglctk	= date('d F, Y', $tglctk);
}







//..
$query	= "	SELECT 		t_setthn_tk.*
			FROM 		t_setthn_tk
			WHERE		t_setthn_tk.set='Tahun Ajaran'";
$result	= mysql_query($query) or die('Query gagal1');
$data 	= mysql_fetch_array($result);
$thnajr = $data[nli];

$qABS	= "	SELECT 		t_hdrkmnps_pgtk1.*
				FROM 		t_hdrkmnps_pgtk1
				WHERE		t_hdrkmnps_pgtk1.nis='$kodekelas' "; // nis // menghasilka nilai kehadiran
$rABS = mysql_query($qABS) or die('Query gagal40');
$dABS = mysql_fetch_array($rABS);
$q1KMN = $dABS['kmn' . '1' . '1']; // q1 kmn	$sms.$midtrm
$q2KMN = $dABS['kmn' . '1' . '2']; // q2
$q3KMN = $dABS['kmn' . '2' . '1']; // q3
$q4KMN = $dABS['kmn' . '2' . '2']; // q4

$qABS2	= "	SELECT 		t_hdrkmnps_pgtk2.*
				FROM 		t_hdrkmnps_pgtk2
				WHERE		t_hdrkmnps_pgtk2.nis='$kodekelas' "; // nis // menghasilka nilai kehadiran
$rABS2 = mysql_query($qABS2) or die('Query gagal40');
$dABS2 = mysql_fetch_array($rABS2);
$q1KMN2 = $dABS2['kmn' . '1' . '1']; // q1 kmn	$sms.$midtrm
$q2KMN2 = $dABS2['kmn' . '1' . '2']; // q2
$q3KMN2 = $dABS2['kmn' . '2' . '1']; // q3
$q4KMN2 = $dABS2['kmn' . '2' . '2']; // q4

$qABS3	= "	SELECT 		t_hdrkmnps_pgtk3.*
				FROM 		t_hdrkmnps_pgtk3
				WHERE		t_hdrkmnps_pgtk3.nis='$kodekelas' "; // nis // menghasilka nilai kehadiran
$rABS3 = mysql_query($qABS3) or die('Query gagal40');
$dABS3 = mysql_fetch_array($rABS3);
$q1KMN3 = $dABS3['kmn' . '1' . '1']; // q1 kmn	$sms.$midtrm
$q2KMN3 = $dABS3['kmn' . '1' . '2']; // q2
$q3KMN3 = $dABS3['kmn' . '2' . '1']; // q3
$q4KMN3 = $dABS3['kmn' . '2' . '2']; // q4

$qABS4	= "	SELECT 		t_hdrkmnps_pgtk4.*
				FROM 		t_hdrkmnps_pgtk4
				WHERE		t_hdrkmnps_pgtk4.nis='$kodekelas' "; // nis // menghasilka nilai kehadiran
$rABS4 = mysql_query($qABS4) or die('Query gagal40');
$dABS4 = mysql_fetch_array($rABS4);
$q1KMN4 = $dABS4['kmn' . '1' . '1']; // q1 kmn	$sms.$midtrm
$q2KMN4 = $dABS4['kmn' . '1' . '2']; // q2
$q3KMN4 = $dABS4['kmn' . '2' . '1']; // q3
$q4KMN4 = $dABS4['kmn' . '2' . '2']; // q4

$qABS5	= "	SELECT 		t_hdrkmnps_pgtk5.*
				FROM 		t_hdrkmnps_pgtk5
				WHERE		t_hdrkmnps_pgtk5.nis='$kodekelas' "; // nis // menghasilka nilai kehadiran
$rABS5 = mysql_query($qABS5) or die('Query gagal40');
$dABS5 = mysql_fetch_array($rABS5);
$q1KMN5 = $dABS5['kmn' . '1' . '1']; // q1 kmn	$sms.$midtrm
$q2KMN5 = $dABS5['kmn' . '1' . '2']; // q2
$q3KMN5 = $dABS5['kmn' . '2' . '1']; // q3
$q4KMN5 = $dABS5['kmn' . '2' . '2']; // q4

//ktr1
$qLG	= "	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='KG-B1' OR t_lrcd_tk.kdekls='KG-B2' ) AND t_lrcd_tk.kde LIKE 'KG-A%' ";
$rLG = mysql_query($qLG) or die('Query gagal40');
$i = 0;
while ($dLG = mysql_fetch_array($rLG)) {
	$nmektr[$i][0] = $dLG['nmektr'];
	$i++;
}

//ktr2
$qLG2	= "	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='KG-B1' OR t_lrcd_tk.kdekls='KG-B2' ) AND t_lrcd_tk.kde LIKE 'KG-B%' ";
$rLG2 = mysql_query($qLG2) or die('Query gagal40');
$i = 0;
while ($dLG2 = mysql_fetch_array($rLG2)) {
	$nmektr2[$i][0] = $dLG2['nmektr'];
	$i++;
}

//ktr3
$qLG3	= "	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='KG-B1' OR t_lrcd_tk.kdekls='KG-B2' ) AND t_lrcd_tk.kde LIKE 'KG-C%' ";
$rLG3 = mysql_query($qLG3) or die('Query gagal40');
$i = 0;
while ($dLG3 = mysql_fetch_array($rLG3)) {
	$nmektr3[$i][0] = $dLG3['nmektr'];
	$i++;
}

//ktr4
$qLG4	= "	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='KG-B1' OR t_lrcd_tk.kdekls='KG-B2' ) AND t_lrcd_tk.kde LIKE 'KG-D%' ";
$rLG4 = mysql_query($qLG4) or die('Query gagal40');
$i = 0;
while ($dLG4 = mysql_fetch_array($rLG4)) {
	$nmektr4[$i][0] = $dLG4['nmektr'];
	$i++;
}

//ktr5
$qLG5	= "	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='KG-B1' OR t_lrcd_tk.kdekls='KG-B2' ) AND t_lrcd_tk.kde LIKE 'KG-E%' ";
$rLG5 = mysql_query($qLG5) or die('Query gagal40');
$i = 0;
while ($dLG5 = mysql_fetch_array($rLG5)) {
	$nmektr5[$i][0] = $dLG5['nmektr'];
	$i++;
}

//ktr6
$qLG6	= "	SELECT 		 t_lrcd_tk.*
				FROM 		 t_lrcd_tk
				WHERE		 ( t_lrcd_tk.kdekls='KG-B1' OR t_lrcd_tk.kdekls='KG-B2' ) AND t_lrcd_tk.kde LIKE 'KG-F%' ";
$rLG6 = mysql_query($qLG6) or die('Query gagal40');
$i = 0;
while ($dLG6 = mysql_fetch_array($rLG6)) {
	$nmektr6[$i][0] = $dLG6['nmektr'];
	$i++;
}



//nli1
$qLGKG	= "	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kodekelas' AND ( t_learnrcd_tk.kdekls='KG-B1' OR t_learnrcd_tk.kdekls='KG-B2' ) AND t_learnrcd_tk.kdeplj='KG-A' ";
$rLGKG = mysql_query($qLGKG) or die('Query gagal40');
$dLGKG = mysql_fetch_array($rLGKG);
$i = 1;
$j = 1;
while ($i < 26) {
	$q1nli[$i][0] = $dLGKG['hw' . '1' . '1' . "$j"];
	$q2nli[$i][0] = $dLGKG['hw' . '1' . '2' . "$j"];
	$q3nli[$i][0] = $dLGKG['hw' . '2' . '1' . "$j"];
	$q4nli[$i][0] = $dLGKG['hw' . '2' . '2' . "$j"];



	if ($q1nli[$i][0] == 'v' or $q1nli[$i][0] == 'V')
		$q1nli[$i][0] = '&#8730;';

	if ($q2nli[$i][0] == 'v' or $q2nli[$i][0] == 'V') {
		$q2nli[$i][0] = '&#8730;';
		$smstr1[$i][0] = 'VS';
	} else if ($q2nli[$i][0] == '-')
		$smstr1[$i][0] = 'S';
	else if ($q2nli[$i][0] == '+')
		$smstr1[$i][0] = 'S';
	else if ($q2nli[$i][0] == 'NO')
		$smstr1[$i][0] = 'NO';
	else if ($q2nli[$i][0] == '/')
		$smstr1[$i][0] = 'MS';
	else if ($q2nli[$i][0] == '*')
		$smstr1[$i][0] = 'O';
	else if ($q2nli[$i][0] == 'ND')
		$smstr1[$i][0] = 'NH'; //ND



	if ($q3nli[$i][0] == 'v' or $q3nli[$i][0] == 'V')
		$q3nli[$i][0] = '&#8730;';

	if ($q4nli[$i][0] == 'v' or $q4nli[$i][0] == 'V') {
		$q4nli[$i][0] = '&#8730;';
		$smstr2[$i][0] = 'VS';
	} else if ($q4nli[$i][0] == '-')
		$smstr2[$i][0] = 'S';
	else if ($q4nli[$i][0] == '+')
		$smstr2[$i][0] = 'S';
	else if ($q4nli[$i][0] == 'NO')
		$smstr2[$i][0] = 'NO';
	else if ($q4nli[$i][0] == '/')
		$smstr2[$i][0] = 'MS';
	else if ($q4nli[$i][0] == '*')
		$smstr2[$i][0] = 'O';
	else if ($q4nli[$i][0] == 'ND')
		$smstr2[$i][0] = 'NH'; //ND



	$i++;
	$j++;
}

//nli2
$qLGKG2	= "	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kodekelas' AND ( t_learnrcd_tk.kdekls='KG-B1' OR t_learnrcd_tk.kdekls='KG-B2' ) AND t_learnrcd_tk.kdeplj='KG-B' ";
$rLGKG2 = mysql_query($qLGKG2) or die('Query gagal40');
$dLGKG2 = mysql_fetch_array($rLGKG2);
$i = 1;
$j = 1;
while ($i < 26) {
	$q1nliB[$i][0] = $dLGKG2['hw' . '1' . '1' . "$j"];
	$q2nliB[$i][0] = $dLGKG2['hw' . '1' . '2' . "$j"];
	$q3nliB[$i][0] = $dLGKG2['hw' . '2' . '1' . "$j"];
	$q4nliB[$i][0] = $dLGKG2['hw' . '2' . '2' . "$j"];



	if ($q1nliB[$i][0] == 'v' or $q1nliB[$i][0] == 'V')
		$q1nliB[$i][0] = '&#8730;';

	if ($q2nliB[$i][0] == 'v' or $q2nliB[$i][0] == 'V') {
		$q2nliB[$i][0] = '&#8730;';
		$smstr1B[$i][0] = 'VS';
	} else if ($q2nliB[$i][0] == '-')
		$smstr1B[$i][0] = 'S';
	else if ($q2nliB[$i][0] == '+')
		$smstr1B[$i][0] = 'S';
	else if ($q2nliB[$i][0] == 'NO')
		$smstr1B[$i][0] = 'NO';
	else if ($q2nliB[$i][0] == '*')
		$smstr1B[$i][0] = 'O';
	else if ($q2nliB[$i][0] == 'ND')
		$smstr1B[$i][0] = 'NH'; //ND
	else if ($q2nliB[$i][0] == '/')
		$smstr1B[$i][0] = 'MS';



	if ($q3nliB[$i][0] == 'v' or $q3nliB[$i][0] == 'V')
		$q3nliB[$i][0] = '&#8730;';

	if ($q4nliB[$i][0] == 'v' or $q4nliB[$i][0] == 'V') {
		$q4nliB[$i][0] = '&#8730;';
		$smstr2B[$i][0] = 'VS';
	} else if ($q4nliB[$i][0] == '-')
		$smstr2B[$i][0] = 'S';
	else if ($q4nliB[$i][0] == '+')
		$smstr2B[$i][0] = 'S';
	else if ($q4nliB[$i][0] == 'NO')
		$smstr2B[$i][0] = 'NO';
	else if ($q4nliB[$i][0] == '*')
		$smstr2B[$i][0] = 'O';
	else if ($q4nliB[$i][0] == 'ND')
		$smstr2B[$i][0] = 'NH'; //ND
	else if ($q4nliB[$i][0] == '/')
		$smstr2B[$i][0] = 'MS';



	$i++;
	$j++;
}

//nli3
$qLGKG3	= "	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kodekelas' AND ( t_learnrcd_tk.kdekls='KG-B1' OR t_learnrcd_tk.kdekls='KG-B2' ) AND t_learnrcd_tk.kdeplj='KG-C' ";
$rLGKG3 = mysql_query($qLGKG3) or die('Query gagal40');
$dLGKG3 = mysql_fetch_array($rLGKG3);
$i = 1;
$j = 1;
while ($i < 26) {
	$q1nliC[$i][0] = $dLGKG3['hw' . '1' . '1' . "$j"];
	$q2nliC[$i][0] = $dLGKG3['hw' . '1' . '2' . "$j"];
	$q3nliC[$i][0] = $dLGKG3['hw' . '2' . '1' . "$j"];
	$q4nliC[$i][0] = $dLGKG3['hw' . '2' . '2' . "$j"];



	if ($q1nliC[$i][0] == 'v' or $q1nliC[$i][0] == 'V')
		$q1nliC[$i][0] = '&#8730;';

	if ($q2nliC[$i][0] == 'v' or $q2nliC[$i][0] == 'V') {
		$q2nliC[$i][0] = '&#8730;';
		$smstr1C[$i][0] = 'VS';
	} else if ($q2nliC[$i][0] == '-')
		$smstr1C[$i][0] = 'S';
	else if ($q2nliC[$i][0] == '+')
		$smstr1C[$i][0] = 'S';
	else if ($q2nliC[$i][0] == 'NO')
		$smstr1C[$i][0] = 'NO';
	else if ($q2nliC[$i][0] == '/')
		$smstr1C[$i][0] = 'MS';
	else if ($q2nliC[$i][0] == 'ND')
		$smstr1C[$i][0] = 'NH'; //ND
	else if ($q2nliC[$i][0] == '*')
		$smstr1C[$i][0] = 'O';



	if ($q3nliC[$i][0] == 'v' or $q3nliC[$i][0] == 'V')
		$q3nliC[$i][0] = '&#8730;';

	if ($q4nliC[$i][0] == 'v' or $q4nliC[$i][0] == 'V') {
		$q4nliC[$i][0] = '&#8730;';
		$smstr2C[$i][0] = 'VS';
	} else if ($q4nliC[$i][0] == '-')
		$smstr2C[$i][0] = 'S';
	else if ($q4nliC[$i][0] == '+')
		$smstr2C[$i][0] = 'S';
	else if ($q4nliC[$i][0] == 'NO')
		$smstr2C[$i][0] = 'NO';
	else if ($q4nliC[$i][0] == '/')
		$smstr2C[$i][0] = 'MS';
	else if ($q4nliC[$i][0] == 'ND')
		$smstr2C[$i][0] = 'NH'; //ND
	else if ($q4nliC[$i][0] == '*')
		$smstr2C[$i][0] = 'O';



	$i++;
	$j++;
}

//nli4
$qLGKG4	= "	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kodekelas' AND ( t_learnrcd_tk.kdekls='KG-B1' OR t_learnrcd_tk.kdekls='KG-B2' ) AND t_learnrcd_tk.kdeplj='KG-D' ";
$rLGKG4 = mysql_query($qLGKG4) or die('Query gagal40');
$dLGKG4 = mysql_fetch_array($rLGKG4);
$i = 1;
$j = 1;
while ($i < 26) {
	$q1nliD[$i][0] = $dLGKG4['hw' . '1' . '1' . "$j"];
	$q2nliD[$i][0] = $dLGKG4['hw' . '1' . '2' . "$j"];
	$q3nliD[$i][0] = $dLGKG4['hw' . '2' . '1' . "$j"];
	$q4nliD[$i][0] = $dLGKG4['hw' . '2' . '2' . "$j"];



	if ($q1nliD[$i][0] == 'v' or $q1nliD[$i][0] == 'V')
		$q1nliD[$i][0] = '&#8730;';

	if ($q2nliD[$i][0] == 'v' or $q2nliD[$i][0] == 'V') {
		$q2nliD[$i][0] = '&#8730;';
		$smstr1D[$i][0] = 'VS';
	} else if ($q2nliD[$i][0] == '-')
		$smstr1D[$i][0] = 'S';
	else if ($q2nliD[$i][0] == '+')
		$smstr1D[$i][0] = 'S';
	else if ($q2nliD[$i][0] == 'NO')
		$smstr1D[$i][0] = 'NO';
	else if ($q2nliD[$i][0] == '/')
		$smstr1D[$i][0] = 'MS';
	else if ($q2nliD[$i][0] == '*')
		$smstr1D[$i][0] = 'O';
	else if ($q2nliD[$i][0] == 'ND')
		$smstr1D[$i][0] = 'NH'; //ND



	if ($q3nliD[$i][0] == 'v' or $q3nliD[$i][0] == 'V')
		$q3nliD[$i][0] = '&#8730;';

	if ($q4nliD[$i][0] == 'v' or $q4nliD[$i][0] == 'V') {
		$q4nliD[$i][0] = '&#8730;';
		$smstr2D[$i][0] = 'VS';
	} else if ($q4nliD[$i][0] == '-')
		$smstr2D[$i][0] = 'S';
	else if ($q4nliD[$i][0] == '+')
		$smstr2D[$i][0] = 'S';
	else if ($q4nliD[$i][0] == 'NO')
		$smstr2D[$i][0] = 'NO';
	else if ($q4nliD[$i][0] == '/')
		$smstr2D[$i][0] = 'MS';
	else if ($q4nliD[$i][0] == '*')
		$smstr2D[$i][0] = 'O';
	else if ($q4nliD[$i][0] == 'ND')
		$smstr2D[$i][0] = 'NH'; //ND



	$i++;
	$j++;
}

//nli5
$qLGKG5	= "	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kodekelas' AND ( t_learnrcd_tk.kdekls='KG-B1' OR t_learnrcd_tk.kdekls='KG-B2' ) AND t_learnrcd_tk.kdeplj='KG-E' ";
$rLGKG5 = mysql_query($qLGKG5) or die('Query gagal40');
$dLGKG5 = mysql_fetch_array($rLGKG5);
$i = 1;
$j = 1;
while ($i < 26) {
	$q1nliE[$i][0] = $dLGKG5['hw' . '1' . '1' . "$j"];
	$q2nliE[$i][0] = $dLGKG5['hw' . '1' . '2' . "$j"];
	$q3nliE[$i][0] = $dLGKG5['hw' . '2' . '1' . "$j"];
	$q4nliE[$i][0] = $dLGKG5['hw' . '2' . '2' . "$j"];

	//..yang lngkap

	if ($q1nliE[$i][0] == 'v' or $q1nliE[$i][0] == 'V')
		$q1nliE[$i][0] = '&#8730;';

	if ($q2nliE[$i][0] == 'v' or $q2nliE[$i][0] == 'V') {
		$q2nliE[$i][0] = '&#8730;';
		$smstr1E[$i][0] = 'VS';
	} else if ($q2nliE[$i][0] == '*')
		$smstr1E[$i][0] = 'O';
	else if ($q2nliE[$i][0] == '+')
		$smstr1E[$i][0] = 'S';
	else if ($q2nliE[$i][0] == '/')
		$smstr1E[$i][0] = 'MS';
	else if ($q2nliE[$i][0] == 'ND')
		$smstr1E[$i][0] = 'NH'; //ND
	else if ($q2nliE[$i][0] == 'NO')
		$smstr1E[$i][0] = 'NO';
	else if ($q2nliE[$i][0] == '-')
		$smstr1E[$i][0] = 'S';



	if ($q3nliE[$i][0] == 'v' or $q3nliE[$i][0] == 'V')
		$q3nliE[$i][0] = '&#8730;';

	if ($q4nliE[$i][0] == 'v' or $q4nliE[$i][0] == 'V') {
		$q4nliE[$i][0] = '&#8730;';
		$smstr2E[$i][0] = 'VS';
	} else if ($q4nliE[$i][0] == '*')
		$smstr2E[$i][0] = 'O';
	else if ($q4nliE[$i][0] == '+')
		$smstr2E[$i][0] = 'S';
	else if ($q4nliE[$i][0] == '/')
		$smstr2E[$i][0] = 'MS';
	else if ($q4nliE[$i][0] == 'ND')
		$smstr2E[$i][0] = 'NH'; //ND
	else if ($q4nliE[$i][0] == 'NO')
		$smstr2E[$i][0] = 'NO';
	else if ($q4nliE[$i][0] == '-')
		$smstr2E[$i][0] = 'S';



	$i++;
	$j++;
}

//nli6
$qLGKG6	= "	SELECT 		 t_learnrcd_tk.*
				FROM 		 t_learnrcd_tk
				WHERE		 t_learnrcd_tk.nis='$kodekelas' AND ( t_learnrcd_tk.kdekls='KG-B1' OR t_learnrcd_tk.kdekls='KG-B2' ) AND t_learnrcd_tk.kdeplj='KG-F' ";
$rLGKG6 = mysql_query($qLGKG6) or die('Query gagal40');
$dLGKG6 = mysql_fetch_array($rLGKG6);
$i = 1;
$j = 1;
while ($i < 26) {
	$q1nliF[$i][0] = $dLGKG6['hw' . '1' . '1' . "$j"];
	$q2nliF[$i][0] = $dLGKG6['hw' . '1' . '2' . "$j"];
	$q3nliF[$i][0] = $dLGKG6['hw' . '2' . '1' . "$j"];
	$q4nliF[$i][0] = $dLGKG6['hw' . '2' . '2' . "$j"];

	//..yang lngkap

	if ($q1nliF[$i][0] == 'v' or $q1nliF[$i][0] == 'V')
		$q1nliF[$i][0] = '&#8730;';

	if ($q2nliF[$i][0] == 'v' or $q2nliF[$i][0] == 'V') {
		$q2nliF[$i][0] = '&#8730;';
		$smstr1F[$i][0] = 'VS';
	} else if ($q2nliF[$i][0] == '*')
		$smstr1F[$i][0] = 'O';
	else if ($q2nliF[$i][0] == '+')
		$smstr1F[$i][0] = 'S';
	else if ($q2nliF[$i][0] == '/')
		$smstr1F[$i][0] = 'MS';
	else if ($q2nliF[$i][0] == 'ND')
		$smstr1F[$i][0] = 'NH'; //ND
	else if ($q2nliF[$i][0] == 'NO')
		$smstr1F[$i][0] = 'NO';
	else if ($q2nliF[$i][0] == '-')
		$smstr1F[$i][0] = 'S';



	if ($q3nliF[$i][0] == 'v' or $q3nliF[$i][0] == 'V')
		$q3nliF[$i][0] = '&#8730;';

	if ($q4nliF[$i][0] == 'v' or $q4nliF[$i][0] == 'V') {
		$q4nliF[$i][0] = '&#8730;';
		$smstr2F[$i][0] = 'VS';
	} else if ($q4nliF[$i][0] == '*')
		$smstr2F[$i][0] = 'O';
	else if ($q4nliF[$i][0] == '+')
		$smstr2F[$i][0] = 'S';
	else if ($q4nliF[$i][0] == '/')
		$smstr2F[$i][0] = 'MS';
	else if ($q4nliF[$i][0] == 'ND')
		$smstr2F[$i][0] = 'NH'; //ND
	else if ($q4nliF[$i][0] == 'NO')
		$smstr2F[$i][0] = 'NO';
	else if ($q4nliF[$i][0] == '-')
		$smstr2F[$i][0] = 'S';



	$i++;
	$j++;
}
//..







$query2 	= "	SELECT 		t_mstssw.*
			FROM 		t_mstssw
			WHERE		t_mstssw.nis='" . ($kodekelas) . "'
			"; //$nis
$result2 = mysql_query($query2) or die('Query gagal');

if ($data2 = mysql_fetch_array($result2)) {
	$nmassw 	= $data2[nmassw];
	$jnsklm 	= $data2[jnsklm];
	$tmplhr 	= $data2[tmplhr];
	$tgllhr 	= $data2[tgllhr];
	$kkelas 	= $data2[kdekls];
	//$kdekls 	=$data2[kdekls];

	$nmaayh 	= $data2[nmaayh];
	$pkjayh 	= $data2[pkjayh];
	$nmaibu 	= $data2[nmaibu];
	$pkjibu 	= $data2[pkjibu];

	$alm	 	= $data2[alm];
	$tlp	 	= $data2[tlp];

	if ($jnsklm == 'P')
		$jnsklm = 'Perempuan';
	else if ($jnsklm == 'L')
		$jnsklm = 'Laki-laki';

	$tgllhr = strtotime($tgllhr);
	$tgllhr = date('d F, Y', $tgllhr);

	if ($kkelas == 'PG1')
		$kkelas = 'Pre-K Nazareth';
	else if ($kkelas == 'PG2')
		$kkelas = 'Pre-K Bethlehem';
	else if ($kkelas == 'KG-A1')
		$kkelas = 'K1 Galilee';
	else if ($kkelas == 'KG-A2')
		$kkelas = 'K1 Jordan';
	else if ($kkelas == 'KG-B1')
		$kkelas = 'K2 Jericho';
	else // if( $kkelas == 'KG-B2' )
		$kkelas = 'K2 Jerusalem';
}





//..margin-top: 0; margin-left: 0; margin-right: 0; margin-bottom: 0;



echo "


	
	
	
	<!--	awal halaman 2	-->

	<center></center>
	<table width='100%' class='center'>
		<tr>
			<!--	awal table kanan	-->
			<td width='50%'>
				<br/><br/>
				<br/><br/>
				<br/><br/>
				<br/><br/>
				<center>
				<table width='100%'>
				<tr>
				<td	width='50'></td>
				<td align='center'>	
					<FONT FACE='ARIAL'  SIZE='5'><b><u>Student's Information</u></b></font><br/><br/>
					<table style='border-collapse: collapse;' border='1' width='90%' height='100'>
						<tr>
							<TD valign='top'>
								<table width='95%'>
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	Student No.		</td><td width='5%' align='center'>	:	</td><td width='65%' align=''>	<u>$nis</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	Name		</td><td width='5%' align='center'>	:	</td><td width='65%' align=''>	<u>$nmassw</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	Class		</td><td width='5%' align='center'>	:	</td><td width='65%' align=''>	<u>$kkelas</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	 Place of Birth		</td><td width='5%' align='center'>	:	</td><td width='65%' align=''>	<u>$tmplhr</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	 Date of Birth		</td><td width='5%' align='center'>	:	</td><td width='65%' align=''>	<u>$tgllhr</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	 Mother's Name		</td><td width='5%' align='center'>	:	</td><td width='65%' align=''>	<u>$nmaibu</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	 Father's Name		</td><td width='5%' align='center'>	:	</td><td width='65%' align=''>	<u>$nmaayh</u>	</td>
									</tr>
									
									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
									<tr>
										<td width='30%'>	 Address		</td><td width='5%' align='center'>	:	</td><td width='65%' align=''>	<u>$alm</u>	</td>
									</tr>

									<tr height='10'>
										<td colspan='3'>		</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				</tr>
				
				</table>
				</center>
				
				<br/>
				
				
				<table align='right'>
					<tr>
						<!--<td	width='50'></td>-->
						<td>	<img src='../../images/Pre-K/" . $kodekelas . ".jpg' height='130' width='150' />	</td><td valign='top'>	<br/> &nbsp;&nbsp; Jakarta, October 6, 2017 <br/><br/><br/><br/><br/> <u>Glorya Lumbantoruan S.Pd.</u> <br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; School Principal	</td>
						<td	width='20'></td>
					</tr>
				</table>
			</td>
			<!--	akhir table kanan	-->
		</tr>
	</table>";
if ($nis == '327') {
} else if ($nis == '396' or $nis = '320') {
	echo "<br/><br/>";
}

echo "

	
";



//..
