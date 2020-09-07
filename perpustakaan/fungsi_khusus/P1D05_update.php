<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
 
$kdebku	=$_POST['kdebku'];
$tglkmb	=$_POST['tglkmb'];
$kdeang	=$_POST['kdeang1'];
$npj	=$_POST['npj'];
$query	=mysql_query(" 	SELECT 		*,t_dtlpjm.kdebku
						FROM 		t_gnrpjm,t_dtlpjm
						WHERE 		t_gnrpjm.kdeang='$kdeang' AND t_dtlpjm.kdebku='$kdebku' AND
									t_gnrpjm.nmrpjm=t_dtlpjm.nmrpjm
						ORDER BY 	tglkmb asc LIMIT 1 "); // AND t_dtlpjm.kdebku='$kdebku'
$data =mysql_fetch_assoc($query);
$tglkmbB=$data[tglkmb];
$nmrpjmB=$data[nmrpjm];

if(empty($tglkmbB))
{
	$query 	="	UPDATE 		t_dtlpjm
				SET  		t_dtlpjm.tglkmb	='". mysql_escape_string($tglkmb)."'
                WHERE 		t_dtlpjm.kdebku	='". mysql_escape_string($kdebku)."' AND 
							t_dtlpjm.nmrpjm	='$nmrpjmB' "; // kode buku & nomor peminjaman tidak 1 baris
	$result =mysql_query ($query)or die(error("Data tidak berhasil di Input")) ;
}
else
{
	echo"
	<SCRIPT LANGUAGE='JavaScript'>
		window.alert('Buku sudah masuk daftar pinjaman')
	</SCRIPT>";
    }
?>