<?php
require 'sysconfig.php';

$dbhost = 'localhost';
$dbname = 'sister';
$dbuser = 'root';
$dbpasswd = '';
// Buat database connection.
if (!$db = @mysql_connect("$dbhost", "$dbuser", "$dbpasswd"))
	die('<font SIZE=+1>An Error Occured</FONT><hr>$nama_pt gagal koneksi dengan server <BR>Silahkah rubah variabel $dbhost, $dbuser, dan $dbpasswd ');
if (!@mysql_select_db("$dbname", $db))
	die("<FONT>Database belum ada </FONT>");
