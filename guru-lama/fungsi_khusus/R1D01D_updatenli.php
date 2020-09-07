<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

// membaca jumlah mahasiswa (n) dari submit.php
$jumSiswa = $_POST['n'];

// membaca kode MK yang akan diupdate
$kdenli = $_POST['kdenli'];

// proses looping untuk membaca nilai dan nim mahasiswa dari form, serta menjalankan query update
for ($i=1; $i<=$jumSiswa; $i++)
{
   // membaca nim mahasiswa ke-i, i = 1, 2, 3, ..., n
   $nis = $_POST['nis'.$i];

   // membaca nilai mahasiswa ke-i, i = 1, 2, 3, ..., n
   $nli  = $_POST['nli'.$i];

   // update nilai mahasiswa ke-i, i = 1, 2, 3, ..., n
   $query = "UPDATE g_dtlnli SET nli = $nli WHERE kdenli = '$kdenli' AND nis = '$nis' ";
   mysql_query($query);
}

echo"<meta http-equiv='refresh' content=\"0;url=../guru.php?mode=R1D01D&kdenli=$kdenli&pilihan=detil_general\">\n";
?>