<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$path 	="../../files/photo/soal/";
$kdesl	=$_POST['kdesl'];
$id		=$_POST['id'];
$gambar	=$_POST['gambar'];
$valid_formats =array("jpg", "png", "gif", "bmp");

?>